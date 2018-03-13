<?php

namespace App\Http\Controllers\Backend\Themes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Themes\Theme;
use Yajra\Datatables\Facades\Datatables;
use App\Events\Backend\Themes\ThemeCreated;
use App\Events\Backend\Themes\ThemeUpdated;
use App\Events\Backend\Themes\ThemeDeleted;
use App\Events\Backend\Themes\ThemeDeactivated;
use App\Events\Backend\Themes\ThemeReactivated;
use App\Events\Backend\Themes\ThemePermanentlyDeleted;
use App\Events\Backend\Themes\ThemeRestored;

class ThemesController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		return view ( 'backend.themes.index' );
	}
	
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		return view ( 'backend.themes.create' );
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
					'name' => 'required|unique:theme|string' 
			] );
			
			if ($validator->fails ()) {
				return redirect ()->back ()->withInput ()->withErrors ( $validator->errors () );
			}
			$theme = new Theme ();
			$data ['name'] = $request->get ( 'name' );
			$data ['status'] = ($request->has ( 'status' )) ? 1 : 0;
			$theme->fill ( $data );
			\DB::transaction ( function () use ($theme) {
				$theme->slug = str_slug ( $theme->name, '-' );
				
				if ($theme->save ()) {
					event ( new ThemeCreated ( $theme ) );
					return true;
				}
				return redirect ()->back ()->withInput ()->withFlashDanger ( trans ( 'exceptions.backend.theme.create_error' ) );
			} );
		} catch ( \Exception $exp ) {
			return redirect ()->route ( 'admin.themes.themes.index' )->withFlashDanger ( $exp->getMessage () );
		}
		return redirect ()->route ( 'admin.themes.themes.index' )->withFlashSuccess ( trans ( 'alerts.backend.themes.created' ) );
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
			$theme = Theme::findOrFail ( $id );
			return view ( 'backend.themes.edit', compact ( 'theme' ) );
		} catch ( \Exception $exp ) {
			return redirect ()->route ( 'admin.themes.themes.index' )->withFlashDanger ( $exp->getMessage () );
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
			$theme = Theme::findOrFail ( $id );
			$data ['name'] = $request->get ( 'name' );
			$data ['status'] = ($request->has ( 'status' )) ? 1 : 0;
			$theme->fill ( $data );
			\DB::transaction ( function () use ($theme) {
				if ($theme->update ()) {
					event ( new ThemeUpdated ( $theme ) );
					return true;
				}
				return redirect ()->back ()->withInput ()->withFlishError ( trans ( 'exceptions.backend.theme.update_error' ) );
			} );
		} catch ( \Exception $exp ) {
			return redirect ()->route ( 'admin.themes.themes.index' )->withFlashDanger ( $exp->getMessage () );
		}
		return redirect ()->route ( 'admin.themes.themes.index' )->withFlashSuccess ( trans ( 'alerts.backend.themes.updated' ) );
	}
	
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param int $id        	
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		try {
			$theme = Theme::findOrFail ( $id );
			\DB::transaction ( function () use ($theme) {
				if ($theme->delete ()) {
					event ( new ThemeDeleted ( $theme ) );
					return true;
				}
				return redirect ()->back ()->withInput ()->withFlishError ( trans ( 'exceptions.backend.theme.delete_error' ) );
			} );
		} catch ( \Exception $exp ) {
			return redirect ()->route ( 'admin.themes.themes.index' )->withFlashDanger ( $exp->getMessage () );
		}
		return redirect ()->route ( 'admin.themes.themes.index' )->withFlashSuccess ( trans ( 'alerts.backend.themes.deleted' ) );
	}
	public function getForDataTable($trashed = false) {
		return Datatables::of ( (new Theme ())->getForDataTable ( $trashed ) )->addColumn ( 'actions', function ($themes) {
			return $themes->action_buttons;
		} )->rawColumns ( [ 
				'actions' 
		] )->withTrashed ()->make ( true );
	}
	public function getAllThemes(Request $request) {
		return $this->getForDataTable ( $request->get ( 'trashed' ) );
	}
	public function getTrashed() {
		return view ( 'backend.themes.deleted' );
	}
	public function changeStatus($themeId, $status) {
		try {
			$theme = Theme::findOrFail ( $themeId );
			$theme->status = $status;
			switch ($status) {
				case 0 :
					event ( new ThemeDeactivated ( $theme ) );
					break;
				
				case 1 :
					event ( new ThemeReactivated ( $theme ) );
					break;
			}
			$theme->update ();
		} catch ( \Exception $exp ) {
			return redirect ()->route ( 'admin.themes.themes.index' )->withFlashDanger ( $exp->getMessage () );
		}
		return redirect ()->route ( 'admin.themes.themes.index' )->withFlashSuccess ( trans ( 'alerts.backend.themes.status_update' ) );
	}
	public function deletePermenently($themeId) {
		try {
			$theme = Theme::withTrashed ()->findOrFail ( $themeId );
			\DB::transaction ( function () use ($theme) {
				if ($theme->forceDelete ()) {
					event ( new ThemePermanentlyDeleted ( $theme ) );
					
					return true;
				}
				
				return redirect ()->route ( 'admin.themes.themes.index' )->withFlashSuccess ( trans ( 'alerts.backend.themes.delete_error' ) );
			} );
		} catch ( \Exception $exp ) {
			return redirect ()->route ( 'admin.themes.deleted' )->withFlashDanger ( $exp->getMessage () );
		}
		return redirect ()->route ( 'admin.themes.deleted' )->withFlashSuccess ( trans ( 'alerts.backend.themes.deleted' ) );
	}
	public function restore($themeId) {
		try {
			$theme = Theme::withTrashed ()->findOrFail ( $themeId );
			if ($theme->restore ()) {
				event ( new ThemeRestored ( $theme ) );
			}
		} catch ( \Exception $exp ) {
			return redirect ()->route ( 'admin.themes.deleted' )->withFlashDanger ( $exp->getMessage () );
		}
		return redirect ()->route ( 'admin.themes.deleted' )->withFlashSuccess ( trans ( 'alerts.backend.themes.deleted' ) );
	}
}
