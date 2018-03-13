<?php

namespace App\Http\Controllers\Backend\Access\HomepageVideo;

use App\Http\Requests\Backend\Access\User\ManageUserRequest;
use App\Repositories\Backend\Access\HomepageVideo\HomepageVideoRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Facades\Datatables;

class HomepageVideoTableController extends Controller
{

    protected $homepageVideo;


    public function __construct(HomepageVideoRepository $homepageVideo)
    {
        $this->homepageVideo = $homepageVideo;

    }

    public function getAll(ManageUserRequest $request)
    {
        $cat = $this->homepageVideo->allActive();
        return Datatables::of($cat)
            ->addColumn('action', function ($cat) {
                return '<a href="homepagevideo/' . $cat->id . '/edit" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a> <button id="cat-deactivate-' . $cat->id . '" class="btn btn-xs btn-warning deactivateButton" data-id="' . $cat->id . '"><i class="glyphicon glyphicon-pause "></i> Deactivate</button> <button id="cat-delete-' . $cat->id . '" class="btn btn-xs btn-danger btn-delete deleteButton" data-id="' . $cat->id . '" data-remote="edit"><i class="glyphicon glyphicon-trash"></i> Delete</button>';
            })->addIndexColumn()
            ->make(true);
    }

    public function allDeactvated(ManageUserRequest $request)
    {
        $cat = $this->homepageVideo->allDeactive();

        return Datatables::of($cat)
            ->addColumn('action', function ($cat) {
                return '<a href="' . $cat->id . '/edit" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a> <button  id="cat-activate-' . $cat->id . '" class="btn btn-xs btn-success activateButton" data-id="' . $cat->id . '"><i class="glyphicon glyphicon-play"></i> Activate</button> <button id="cat-delete-' . $cat->id . '" class="btn btn-xs btn-danger btn-delete deleteButton" data-id="' . $cat->id . '" data-remote="edit"><i class="glyphicon glyphicon-trash"></i> Delete</button>';
            })->addIndexColumn()
            ->make(true);
    }

    public function deactivateView(ManageUserRequest $request)
    {
        return view('backend.access.homepageVideo.deactivatedHomepageVideo');
    }

    public function deactivateItem(ManageUserRequest $request)
    {

        $this->homepageVideo->deactiveItem($request->id);
    }

    public function activateItem(ManageUserRequest $request)
    {

        $this->homepageVideo->activeItem($request->id);
    }


}
