<?php

namespace App\Http\Controllers\Backend\Wordpress;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Facades\Datatables;
use App\Events\Backend\Wordpress\WordpressCreated;
use App\Events\Backend\Wordpress\WordpressUpdated;
use App\Events\Backend\Wordpress\WordpressDeleted;
use App\Events\Backend\Wordpress\WordpressDeactivated;
use App\Events\Backend\Wordpress\WordpressReactivated;
use App\Events\Backend\Wordpress\WordpressPermanentlyDeleted;
use App\Events\Backend\Wordpress\WordpressRestored;
use App\Models\Wordpress\Wordpress;
use App\Models\Resource\ResourceVersion;

class WpVersionController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		return view ( 'backend.wordpress.index' );
	}
	
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		return view ( 'backend.wordpress.create' );
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
					'name' => 'required|unique:wordpress|string',
					'version' => 'required|max:8|min:3',
					'archive' => 'required|mimes:zip' 
			] );
			
			if ($validator->fails ()) {
				return redirect ()->back ()->withInput ()->withErrors ( $validator->errors () );
			}
			$wordpress = new Wordpress ();
			$data ['name'] = $request->get ( 'name' );
			$data ['status'] = ($request->has ( 'is_current' )) ? 1 : 0;
			$versionData ['version'] = $request->get ( 'version' );
			$versionData ['is_current'] = ($request->has ( 'is_current' )) ? 'Yes' : 'No';
			$wordpress->fill ( $data );
			\DB::transaction ( function () use ($wordpress) {
				$wordpress->slug = str_slug ( $wordpress->name, '-' );
				Wordpress::toggleStatus($wordpress->status);
				if ($wordpress->save ()) {
					event ( new WordpressCreated ( $wordpress ) );
					return true;
				}
				return redirect ()->back ()->withInput ()->withFlashDanger ( trans ( 'exceptions.backend.theme.create_error' ) );
			} );
			if ($request->hasFile ( 'archive' ) && $request->file ( 'archive' )->isValid ()) {
				$extention = $request->archive->extension ();
				$versionData ['path'] = \Storage::putFileAs ( 'wordpress/' . $wordpress->id , $request->file ( 'archive' ), $wordpress->slug . '-' . $request->get ( 'version' ) . '.' . $extention );
			}
			$version = new ResourceVersion ();
			$version->fill ( $versionData );
			$wordpress->versions ()->save ( $version );
		} catch ( \Exception $exp ) {
			return redirect ()->route ( 'admin.wordpress.wordpress.index' )->withFlashDanger ( $exp->getMessage () );
		}
		return redirect ()->route ( 'admin.wordpress.wordpress.index' )->withFlashSuccess ( trans ( 'alerts.backend.wordpress.created' ) );
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
			$wordpress = Wordpress::findOrFail ( $id );
			$version = $wordpress->versions->first ();
			
			return view ( 'backend.wordpress.edit', compact ( 'wordpress', 'version' ) );
		} catch ( \Exception $exp ) {
			return redirect ()->route ( 'admin.wordpress.wordpress.index' )->withFlashDanger ( $exp->getMessage () );
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
			$validator = validator ( $request->all (), [ 
					'name' => 'required|string|unique:wordpress,name,'.$id,
					'version' => 'required|max:8|min:3',
					'archive' => 'sometimes|nullable|mimes:zip' 
			] );
			
			if ($validator->fails ()) {
				return redirect ()->back ()->withInput ()->withErrors ( $validator->errors () );
			}
			$wordpress = Wordpress::findOrFail ( $id );
			$version = $wordpress->versions->first ();
			$data ['name'] = $request->get ( 'name' );
			$data ['status'] = ($request->has ( 'is_current' )) ? 1 : 0;
			$versionData ['version'] = $request->get ( 'version' );
			$versionData ['is_current'] = ($request->has ( 'is_current' )) ? 'Yes' : 'No';
			$wordpress->fill ( $data );
			\DB::transaction ( function () use ($wordpress) {
				Wordpress::toggleStatus($wordpress->status);
				if ($wordpress->update ()) {
					event ( new WordpressUpdated ( $wordpress ) );
					return true;
				}
				return redirect ()->back ()->withInput ()->withFlishError ( trans ( 'exceptions.backend.theme.update_error' ) );
			} );
			if ($request->hasFile ( 'archive' ) && $request->file ( 'archive' )->isValid ()) {
				$extention = $request->archive->extension ();
				$versionData ['path'] = \Storage::putFileAs ( 'wordpress/' . $wordpress->id , $request->file ( 'archive' ), $wordpress->slug . '-' . $request->get ( 'version' ) . '.' . $extention );
			}
			$version->fill ( $versionData );
			$wordpress->versions ()->save ( $version );
		} catch ( \Exception $exp ) {
			return redirect ()->route ( 'admin.wordpress.wordpress.index' )->withFlashDanger ( $exp->getMessage () );
		}
		return redirect ()->route ( 'admin.wordpress.wordpress.index' )->withFlashSuccess ( trans ( 'alerts.backend.wordpress.updated' ) );
	}
	
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param int $id        	
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		try {
			$wordpress = Wordpress::findOrFail ( $id );
			\DB::transaction ( function () use ($wordpress) {
				if ($wordpress->delete ()) {
					event ( new WordpressDeleted ( $wordpress ) );
					return true;
				}
				return redirect ()->back ()->withInput ()->withFlishError ( trans ( 'exceptions.backend.theme.delete_error' ) );
			} );
		} catch ( \Exception $exp ) {
			return redirect ()->route ( 'admin.wordpress.wordpress.index' )->withFlashDanger ( $exp->getMessage () );
		}
		return redirect ()->route ( 'admin.wordpress.wordpress.index' )->withFlashSuccess ( trans ( 'alerts.backend.wordpress.deleted' ) );
	}
	public function getForDataTable($trashed = false) {
		return Datatables::of ( (new Wordpress ())->getVersionForDataTable ( $trashed ) )->addColumn ( 'actions', function ($wordpress) {
			return $wordpress->action_buttons;
		} )->rawColumns ( [ 
				'actions' 
		] )->withTrashed ()->make ( true );
	}
	public function getAllWordpressVersions(Request $request) {
		return $this->getForDataTable ( $request->get ( 'trashed' ) );
	}
	public function getTrashed() {
		return view ( 'backend.wordpress.deleted' );
	}
	public function changeStatus($themeId, $status) {
		try {
			$wordpress = Wordpress::findOrFail ( $themeId );
			$version = $wordpress->versions->first();
			$version->is_current = ($status) ? 'Yes' : 'No';
			$wordpress->status = ($status == 1) ? 1 : 0;
			switch ($status) {
				case 0 :
					event ( new WordpressDeactivated ( $wordpress ) );
					break;
				
				case 1 :
					event ( new WordpressReactivated ( $wordpress ) );
					break;
			}
			Wordpress::toggleStatus($status);
			$wordpress->update ();
			$version->update();
		} catch ( \Exception $exp ) {
			return redirect ()->route ( 'admin.wordpress.wordpress.index' )->withFlashDanger ( $exp->getMessage () );
		}
		return redirect ()->route ( 'admin.wordpress.wordpress.index' )->withFlashSuccess ( trans ( 'alerts.backend.wordpress.status_update' ) );
	}
	public function deletePermenently($id) {
		try {
			$wordpress = Wordpress::withTrashed ()->findOrFail ( $id );
			$version = $wordpress->versions->first();
			\DB::transaction ( function () use ($wordpress, $version) {
				
				if ($wordpress->forceDelete ()) {
					\Storage::delete($version->path);
					\Storage::deleteDirectory('wordpress/'.$wordpress->id);
					$version->forceDelete();
					event ( new WordpressPermanentlyDeleted ( $wordpress ) );
					return true;
				}
				return redirect ()->route ( 'admin.wordpress.wordpress.index' )->withFlashSuccess ( trans ( 'alerts.backend.wordpress.delete_error' ) );
			} );
		} catch ( \Exception $exp ) {
			return redirect ()->route ( 'admin.wordpress.deleted' )->withFlashDanger ( $exp->getMessage () );
		}
		return redirect ()->route ( 'admin.wordpress.deleted' )->withFlashSuccess ( trans ( 'alerts.backend.wordpress.deleted' ) );
	}
	public function restore($id) {
		try {
			$wordpress = Wordpress::withTrashed ()->findOrFail ( $id );
			if ($wordpress->restore ()) {
				event ( new WordpressRestored ( $wordpress ) );
			}
		} catch ( \Exception $exp ) {
			return redirect ()->route ( 'admin.wordpress.deleted' )->withFlashDanger ( $exp->getMessage () );
		}
		return redirect ()->route ( 'admin.wordpress.deleted' )->withFlashSuccess ( trans ( 'alerts.backend.wordpress.deleted' ) );
	}
}
