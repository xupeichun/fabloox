<?php

namespace App\Http\Controllers\Backend\Themes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Themes\Theme;
use Yajra\Datatables\Facades\Datatables;
use App\Events\Backend\Themes\ThemeCreated;
use App\Events\Backend\Themes\ThemeUpdated;
use App\Exceptions\GeneralException;
use function GuzzleHttp\Promise\exception_for;
use App\Models\Resource\ResourceVersion;

class ThemesVersionController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @param $themeId
     * @return \Illuminate\Http\Response
     */
	public function index($themeId) {
		return view ( 'backend.themes.version.index', compact ( 'themeId' ) );
	}

    /**
     * Show the form for creating a new resource.
     *
     * @param $themeId
     * @return \Illuminate\Http\Response
     */
	public function create($themeId) {
		return view ( 'backend.themes.version.create', compact ( 'themeId' ) );
	}

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param $themeId
     * @return \Illuminate\Http\Response
     */
	public function store(Request $request, $themeId) {
		try {
			$validator = validator ( $request->all (), [ 
					'version' => 'required|max:8|min:3',
					'archive' => 'required|mimes:zip' 
			] );
			
			if ($validator->fails ()) {
				return redirect ()->back ()->withInput ()->withErrors ( $validator->errors () );
			}
			$theme = Theme::findOrFail ( $themeId );
			$version = new ResourceVersion ();
			$data ['version'] = $request->get ( 'version' );
			$data ['is_current'] = ($request->has ( 'is_current' )) ? 'Yes' : 'No';
			if ($request->hasFile ( 'archive' ) && $request->file ( 'archive' )->isValid ()) {
				$extention = $request->archive->extension ();
				$data ['path'] = \Storage::putFileAs ( 'themes/' . $themeId, $request->file ( 'archive' ), $theme->slug . '-' . $request->get ( 'version' ) . '.' . $extention );
			}
			$version->fill ( $data );
			
			\DB::transaction ( function () use ($theme, $version) {
				$theme->slug = str_slug ( $theme->name, '-' );
				if ($theme->versions ()->save ( $version )) {
					 event ( new ThemeCreated ( $theme ) );
					return true;
				}
				return redirect ()->back ()->withInput ()->withFlashDanger ( trans ( 'exceptions.backend.theme.create_error' ) );
			} );
		} catch ( \Exception $exp ) {
			return redirect ()->route ( 'admin.themes.version.index', $themeId )->withFlashDanger ( $exp->getMessage () );
		}
		return redirect ()->route ( 'admin.themes.version.index', $themeId )->withFlashSuccess ( trans ( 'alerts.backend.themes.versions.created' ) );
	}

    /**
     * Show the form for editing the specified resource.
     *
     * @param $themeId
     * @param $versionId
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
	public function edit($themeId, $versionId) {
		try {
			$version = ResourceVersion::findOrFail ( $versionId );
			return view ( 'backend.themes.version.edit', compact ( 'version', 'themeId' ) );
		} catch ( \Exception $exp ) {
			return redirect ()->route ( 'admin.themes.version.index', $themeId )->withFlashDanger ( $exp->getMessage () );
		}
	}

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param $themeId
     * @param $versionId
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
	public function update(Request $request, $themeId, $versionId) {
		try {
			$validator = validator ( $request->all (), [ 
					'version' => 'required|max:8|min:3',
					'archive' => 'sometimes|nullable|mimes:zip' 
			] );
			
			if ($validator->fails ()) {
				return redirect ()->back ()->withInput ()->withErrors ( $validator->errors () );
			}
			$theme = Theme::findOrFail ( $themeId );
			$version = ResourceVersion::findOrFail ( $versionId );
			$data ['version'] = $request->get ( 'version' );
			$data ['is_current'] = ($request->has ( 'is_current' )) ? 'Yes' : 'No';
			if ($request->hasFile ( 'archive' ) && $request->file ( 'archive' )->isValid ()) {
				$extention = $request->archive->extension ();
				$data ['path'] = \Storage::putFileAs ( 'themes/' . $themeId, $request->file ( 'archive' ), $theme->slug . '-' . $version->version . '.' . $extention );
			}
			$version->fill ( $data );
			\DB::transaction ( function () use ($theme) {
				if ($theme->update ()) {
					// event ( new ThemeUpdated ( $theme ) );
					return true;
				}
				return redirect ()->back ()->withInput ()->withFlishError ( trans ( 'exceptions.backend.theme.update_error' ) );
			} );
		} catch ( \Exception $exp ) {
			return redirect ()->route ( 'admin.themes.version.edit', $themeId, $versionId )->withFlashDanger ( $exp->getMessage () );
		}
		return redirect ()->route ( 'admin.themes.version.index', $themeId )->withFlashSuccess ( trans ( 'alerts.backend.themes.versions.updated' ) );
	}

    /**
     * Remove the specified resource from storage.
     *
     * @param $themeId
     * @param $versionId
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
	public function destroy($themeId, $versionId) {
		try {
			$version = ResourceVersion::findOrFail ( $versionId );
			$version->delete ();
		} catch ( \Exception $exp ) {
			return redirect ()->route ( 'admin.themes.version.index', [ 
					$themeId 
			] )->withFlashDanger ( $exp->getMessage () );
		}
		return redirect ()->route ( 'admin.themes.version.index', [ 
				$themeId 
		] )->withFlashSuccess ( trans ( 'alerts.backend.themes.versions.deleted' ) );
	}
	public function getForDataTable($themeId, $trashed = 'false') {
		return Datatables::of ( (new Theme ())->getVersionForDataTable ( $themeId, $trashed ) )->addColumn ( 'actions', function ($themes) {
			return $themes->action_buttons;
		} )->rawColumns ( [ 
				'actions' 
		] )->withTrashed ()->make ( true );
	}
	public function getAllVersions(Request $request, $themeId) {
		return $this->getForDataTable ( $themeId, $request->get ( 'trashed' ) );
	}
	public function getTrashed($themeId) {
		return view ( 'backend.themes.version.deleted', compact ( 'themeId' ) );
	}
	public function changeStatus($themeId, $versionId, $status) {
		try {
			$theme = Theme::findOrFail ( $themeId );
			$theme->status = $status;
			$theme->update ();
		} catch ( \Exception $exp ) {
			return redirect ()->route ( 'admin.themes.version.index', $themeId )->withFlashDanger ( $exp->getMessage () );
		}
		return redirect ()->route ( 'admin.themes.version.index', $themeId )->withFlashSuccess ( trans ( 'alerts.backend.themes.versions.status_update' ) );
	}
	public function deletePermenently($themeId, $versionId) {
		try {
			$version = ResourceVersion::withTrashed ()->findOrFail ( $versionId );
			\DB::transaction ( function () use ($version) {
				if ($version->forceDelete ()) {
					if (! is_null ( $version->path )) {
						\Storage::delete ( $version->path );
					}
					return true;
				}
				return redirect ()->back ()->withInput ()->withFlishError ( trans ( 'exceptions.backend.theme.update_error' ) );
			} );
		} catch ( \Exception $exp ) {
			return redirect ()->route ( 'admin.themes.version.deleted', $themeId )->withFlashDanger ( $exp->getMessage () );
		}
		return redirect ()->route ( 'admin.themes.version.deleted',$themeId )->withFlashSuccess ( trans ( 'alerts.backend.themes.versions.deleted' ) );
	}
	public function restore($themeId) {
		try {
			$theme = Theme::withTrashed ()->findOrFail ( $themeId );
			$theme->restore ();
		} catch ( \Exception $exp ) {
			return redirect ()->route ( 'admin.themes.version.deleted' )->withFlashDanger ( $exp->getMessage () );
		}
		return redirect ()->route ( 'admin.themes.version.deleted' )->withFlashSuccess ( trans ( 'alerts.backend.themes.versions.deleted' ) );
	}
}
