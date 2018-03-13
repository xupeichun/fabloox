<?php

namespace App\Http\Controllers\Backend\Plugins;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Facades\Datatables;
use App\Models\Resource\ResourceVersion;

use App\Models\Plugins\Plugin;
use App\Events\Backend\Plugins\Versions\PluginVersionUpdated;
use App\Events\Backend\Plugins\Versions\PluginVersionRestored;
use App\Events\Backend\Plugins\Versions\PluginVersionReactivated;
use App\Events\Backend\Plugins\Versions\PluginVersionPermanentlyDeleted;
use App\Events\Backend\Plugins\Versions\PluginVersionDeleted;
use App\Events\Backend\Plugins\Versions\PluginVersionDeactivated;
use App\Events\Backend\Plugins\Versions\PluginVersionCreated;

class PluginVersionController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @param $pluginId
     * @return \Illuminate\Http\Response
     */
	public function index($pluginId) {
		return view ( 'backend.plugins.version.index', compact ( 'pluginId' ) );
	}

    /**
     * Show the form for creating a new resource.
     *
     * @param $pluginId
     * @return \Illuminate\Http\Response
     */
	public function create($pluginId) {
		return view ( 'backend.plugins.version.create', compact ( 'pluginId' ) );
	}

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param $pluginId
     * @return \Illuminate\Http\Response
     */
	public function store(Request $request, $pluginId) {
		try {
			$validator = validator ( $request->all (), [ 
					'version' => 'required|max:8|min:3',
					'archive' => 'required|mimes:zip' 
			] );
			
			if ($validator->fails ()) {
				return redirect ()->back ()->withInput ()->withErrors ( $validator->errors () );
			}
			$plugin = Plugin::findOrFail ( $pluginId);
			$version = new ResourceVersion ();
			$data ['version'] = $request->get ( 'version' );
			$data ['is_current'] = ($request->has ( 'is_current' )) ? 'Yes' : 'No';
			if ($request->hasFile ( 'archive' ) && $request->file ( 'archive' )->isValid ()) {
				$extention = $request->archive->extension ();
				$data ['path'] = \Storage::putFileAs ( 'plugins/' . $pluginId, $request->file ( 'archive' ), $plugin->slug . '-' . $request->get ( 'version' ) . '.' . $extention );
			}
			$version->fill ( $data );
			
			\DB::transaction ( function () use ($plugin, $version) {
				if ($plugin->versions ()->save ( $version )) {
					event ( new PluginVersionCreated( $version) );
					return true;
				}
				return redirect ()->back ()->withInput ()->withFlashDanger ( trans ( 'exceptions.backend.plugins.create_error' ) );
			} );
		} catch ( \Exception $exp ) {
			return redirect ()->route ( 'admin.plugins.version.index', $pluginId)->withFlashDanger ( $exp->getMessage () );
		}
		return redirect ()->route ( 'admin.plugins.version.index', $pluginId)->withFlashSuccess ( trans ( 'alerts.backend.plugins.versions.created' ) );
	}

    /**
     * Show the form for editing the specified resource.
     *
     * @param $pluginId
     * @param $versionId
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
	public function edit($pluginId, $versionId) {
		try {
			$version = ResourceVersion::findOrFail ( $versionId );
			
			return view ( 'backend.plugins.version.edit', compact ( 'version', 'pluginId' ) );
		} catch ( \Exception $exp ) {
			return redirect ()->route ( 'admin.plugins.version.index', $pluginId)->withFlashDanger ( $exp->getMessage () );
		}
	}

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param $pluginId
     * @param $versionId
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
	public function update(Request $request, $pluginId, $versionId) {
		try {
			$validator = validator ( $request->all (), [ 
					'version' => 'required|max:8|min:3',
					'archive' => 'sometimes|nullable|mimes:zip' 
			] );
			
			if ($validator->fails ()) {
				return redirect ()->back ()->withInput ()->withErrors ( $validator->errors () );
			}
			$plugin = Plugin::findOrFail ( $pluginId);
			$version = ResourceVersion::findOrFail ( $versionId );
			$data ['version'] = $request->get ( 'version' );
			$data ['is_current'] = ($request->has ( 'is_current' )) ? 'Yes' : 'No';
			if ($request->hasFile ( 'archive' ) && $request->file ( 'archive' )->isValid ()) {
				$extention = $request->archive->extension ();
				$data ['path'] = \Storage::putFileAs ( 'plugins/' . $pluginId, $request->file ( 'archive' ), $plugin->slug . '-' . $version->version . '.' . $extention );
			}
			$version->fill ( $data );
			\DB::transaction ( function () use ($version) {
				if ($version->update ()) {
					event ( new PluginVersionUpdated( $version) );
					return true;
				}
				return redirect ()->back ()->withInput ()->withFlashError ( trans ( 'exceptions.backend.plugins.update_error' ) );
			} );
		} catch ( \Exception $exp ) {
			return redirect ()->route ( 'admin.plugins.version.edit', $pluginId, $versionId )->withFlashDanger ( $exp->getMessage () );
		}
		return redirect ()->route ( 'admin.plugins.version.index', $pluginId)->withFlashSuccess ( trans ( 'alerts.backend.plugins.versions.updated' ) );
	}

    /**
     * Remove the specified resource from storage.
     *
     * @param $pluginid
     * @param $versionId
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
	public function destroy($pluginid, $versionId) {
		
		try {
			$version = ResourceVersion::findOrFail ( $versionId );
			\DB::transaction ( function () use ($version) {
				if ($version->delete()) {
					event ( new PluginVersionDeleted( $version) );
					return true;
				}
				return redirect ()->back ()->withFlashDanger( trans ( 'exceptions.backend.plugins.delete_error' ) );
			} );
			
		} catch ( \Exception $exp ) {
			return redirect ()->route ( 'admin.plugins.version.index', [ 
					$pluginid
			] )->withFlashDanger ( $exp->getMessage () );
		}
		return redirect ()->route ( 'admin.plugins.version.index', [ 
				$pluginid
		] )->withFlashSuccess ( trans ( 'alerts.backend.plugins.versions.deleted' ) );
	}
	public function getForDataTable($pluginid, $trashed = 'false') {
		return Datatables::of ( (new Plugin ())->getVersionForDataTable ( $pluginid, $trashed ) )->addColumn ( 'actions', function ($plugins) {
			return $plugins->action_buttons;
		} )->rawColumns ( [ 
				'actions' 
		] )->withTrashed ()->make ( true );
	}
	public function getAllVersions(Request $request, $pluginId) {
		return $this->getForDataTable ( $pluginId, $request->get ( 'trashed' ) );
	}
	public function getTrashed($pluginId) {
		return view ( 'backend.plugins.version.deleted', compact ( 'pluginId' ) );
	}
	public function changeStatus($pluginId, $versionId, $status) {
		try {
			$plugin = Plugin::findOrFail ( $pluginId);
			$plugin->status = $status;
			$plugin->update ();
		} catch ( \Exception $exp ) {
			return redirect ()->route ( 'admin.plugins.version.index', $pluginId)->withFlashDanger ( $exp->getMessage () );
		}
		return redirect ()->route ( 'admin.plugins.version.index', $pluginId)->withFlashSuccess ( trans ( 'alerts.backend.plugins.versions.status_update' ) );
	}
	public function deletePermenently($pluginId, $versionId) {
		try {
			$version = ResourceVersion::withTrashed ()->findOrFail ( $versionId );
			$plugin = $version->plugin()->first();
			\DB::transaction ( function () use ($version,$plugin) {
				if ($version->forceDelete ()) {
					if (! is_null ( $version->path )) {
						\Storage::delete ( $version->path );
					}
					event ( new PluginVersionPermanentlyDeleted( $version, $plugin) );
					return true;
				}
				return redirect ()->back ()->withInput ()->withFlishError ( trans ( 'exceptions.backend.plugins.update_error' ) );
			} );
		} catch ( \Exception $exp ) {
			return redirect ()->route ( 'admin.plugins.version.deleted', $pluginId)->withFlashDanger ( $exp->getMessage () );
		}
		return redirect ()->route ( 'admin.plugins.version.deleted',$pluginId)->withFlashSuccess ( trans ( 'alerts.backend.plugins.versions.deleted' ) );
	}
	public function restore($pluginId, $versionId) {
		try {
			$version = ResourceVersion::withTrashed ()->findOrFail ( $versionId);
			if ($version->restore ()) {
				event ( new PluginVersionRestored( $version) );
			}
		
		} catch ( \Exception $exp ) {
			return redirect ()->route ( 'admin.plugins.version.deleted',$pluginId)->withFlashDanger ( $exp->getMessage () );
		}
		return redirect ()->route ( 'admin.plugins.version.deleted',$pluginId)->withFlashSuccess ( trans ( 'alerts.backend.plugins.versions.restored' ) );
	}
}
