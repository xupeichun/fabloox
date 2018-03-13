<?php

namespace App\Http\Controllers\Backend\Plugins;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Facades\Datatables;
use App\Events\Backend\Plugins\PluginCreated;
use App\Events\Backend\Plugins\PluginUpdated;
use App\Events\Backend\Plugins\PluginDeleted;
use App\Events\Backend\Plugins\PluginDeactivated;
use App\Events\Backend\Plugins\PluginReactivated;
use App\Events\Backend\Plugins\PluginPermanentlyDeleted;
use App\Events\Backend\Plugins\PluginRestored;
use App\Models\Plugins\Plugin;

class PluginController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		return view ( 'backend.plugins.index' );
	}
	
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		return view ( 'backend.plugins.create' );
	}
	
	/**
	 * Store a newly created resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		try {
			$validator = validator ( $request->all (), [ 
					'name' => 'required|unique:plugin|string' 
			] );
			
			if ($validator->fails ()) {
				return redirect ()->back ()->withInput ()->withErrors ( $validator->errors () );
			}
			$plugin = new Plugin();
			$data ['name'] = $request->get ( 'name' );
			$data ['status'] = ($request->has ( 'status' )) ? 1 : 0;
			$data ['default'] = ($request->has ( 'default' )) ? 1 : 0;
			$plugin->fill ( $data );
			\DB::transaction ( function () use ($plugin) {
				$plugin->slug = str_slug ( $plugin->name, '-' );
				
				if ($plugin->save ()) {
					event ( new PluginCreated( $plugin) );
					return true;
				}
				return redirect ()->back ()->withInput ()->withFlashDanger ( trans ( 'exceptions.backend.plugins.create_error' ) );
			} );
		} catch ( \Exception $exp ) {
			return redirect ()->route ( 'admin.plugins.plugins.index' )->withFlashDanger ( $exp->getMessage () );
		}
		return redirect ()->route ( 'admin.plugins.plugins.index' )->withFlashSuccess ( trans ( 'alerts.backend.plugins.created' ) );
	}
	
	/**
	 * Display the specified resource.
	 *
	 * @param int $id        	
	 * @return \Illuminate\Http\Response
	 */
	public function show($id) {
		//
	}
	
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param int $id        	
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id) {
		try {
			$plugin = Plugin::findOrFail ( $id );
			return view ( 'backend.plugins.edit', compact ( 'plugin' ) );
		} catch ( \Exception $exp ) {
			return redirect ()->route ( 'admin.plugins.plugins.index' )->withFlashDanger ( $exp->getMessage () );
		}
	}
	
	/**
	 * Update the specified resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @param int $id        	
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id) {
		try {
			$plugin = Plugin::findOrFail ( $id );
			$data ['name'] = $request->get ( 'name' );
			$data ['status'] = ($request->has ( 'status' )) ? 1 : 0;
			$data ['default'] = ($request->has ( 'default' )) ? 1 : 0;
			$plugin->fill ( $data );
			\DB::transaction ( function () use ($plugin) {
				if ($plugin->update ()) {
					event ( new PluginUpdated($plugin));
					return true;
				}
				return redirect ()->back ()->withInput ()->withFlishError ( trans ( 'exceptions.backend.plugins.update_error' ) );
			} );
		} catch ( \Exception $exp ) {
			return redirect ()->route ( 'admin.plugins.plugins.index' )->withFlashDanger ( $exp->getMessage () );
		}
		return redirect ()->route ( 'admin.plugins.plugins.index' )->withFlashSuccess ( trans ( 'alerts.backend.plugins.updated' ) );
	}
	
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param int $id        	
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		try {
			$plugin = Plugin::findOrFail ( $id );
			\DB::transaction ( function () use ($plugin) {
				if ($plugin->delete ()) {
					event ( new PluginDeleted( $plugin) );
					return true;
				}
				return redirect ()->back ()->withInput ()->withFlishError ( trans ( 'exceptions.backend.plugins.delete_error' ) );
			} );
		} catch ( \Exception $exp ) {
			return redirect ()->route ( 'admin.plugins.plugins.index' )->withFlashDanger ( $exp->getMessage () );
		}
		return redirect ()->route ( 'admin.plugins.plugins.index' )->withFlashSuccess ( trans ( 'alerts.backend.plugins.deleted' ) );
	}
	public function getForDataTable($trashed = false) {
		return Datatables::of ( (new Plugin ())->getForDataTable ( $trashed ) )->addColumn ( 'actions', function ($plugins) {
			return $plugins->action_buttons;
		} )->rawColumns ( [ 
				'actions' 
		] )->withTrashed ()->make ( true );
	}
	public function getAllThemes(Request $request) {
		return $this->getForDataTable ( $request->get ( 'trashed' ) );
	}
	public function getTrashed() {
		return view ( 'backend.plugins.deleted' );
	}
	public function changeStatus($id, $status) {
		try {
			$plugin = Plugin::findOrFail ( $id);
			$plugin->status = $status;
			switch ($status) {
				case 0 :
					event ( new PluginDeactivated ( $plugin) );
					break;
				
				case 1 :
					event ( new PluginReactivated ( $plugin) );
					break;
			}
			$plugin->update ();
		} catch ( \Exception $exp ) {
			return redirect ()->route ( 'admin.plugins.plugins.index' )->withFlashDanger ( $exp->getMessage () );
		}
		return redirect ()->route ( 'admin.plugins.plugins.index' )->withFlashSuccess ( trans ( 'alerts.backend.plugins.status_update' ) );
	}
	public function deletePermenently($id) {
		try {
			$plugin = Plugin::withTrashed ()->findOrFail ($id);
			
			\DB::transaction ( function () use ($plugin) {
				if ($plugin->forceDelete ()) {
					event ( new PluginPermanentlyDeleted ( $plugin) );
					
					return true;
				}
				
				return redirect ()->route ( 'admin.plugins.plugins.index' )->withFlashSuccess ( trans ( 'alerts.backend.plugins.delete_error' ) );
			} );
		} catch ( \Exception $exp ) {
			return redirect ()->route ( 'admin.plugins.deleted' )->withFlashDanger ( $exp->getMessage () );
		}
		return redirect ()->route ( 'admin.plugins.deleted' )->withFlashSuccess ( trans ( 'alerts.backend.plugins.deleted' ) );
	}
	public function restore($id) {
		try {
			$plugin = Plugin::withTrashed ()->findOrFail ( $id);
			if ($plugin->restore ()) {
				event ( new PluginRestored ( $plugin) );
			}
		} catch ( \Exception $exp ) {
			return redirect ()->route ( 'admin.plugins.deleted' )->withFlashDanger ( $exp->getMessage () );
		}
		return redirect ()->route ( 'admin.plugins.deleted' )->withFlashSuccess ( trans ( 'alerts.backend.plugins.deleted' ) );
	}
}
