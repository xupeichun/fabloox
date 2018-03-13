<?php

namespace App\Http\Controllers\Backend\Access\Gallery;

use App\Http\Requests\Backend\Access\User\ManageUserRequest;
use App\Repositories\Backend\Access\Gallery\GalleryRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;

class GalleryTableController extends Controller
{

    protected $gallery;


    public function __construct(GalleryRepository $gallery)
    {
        $this->gallery = $gallery;

    }

    public function getAll(ManageUserRequest $request)
    {
        $cat = $this->gallery->allActive();
        return Datatables::of($cat)
            ->addColumn('images', function ($cat) {
                return '<img width="50" src="' . asset('/') . '/' . $cat->image . '"/>';
            })
            ->addColumn('action', function ($cat) {
                return '<a href="gallery/' . $cat->id . '/edit" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a> <button id="cat-deactivate-' . $cat->id . '" class="btn btn-xs btn-warning deactivateButton" data-id="' . $cat->id . '"><i class="glyphicon glyphicon-pause "></i> Deactivate</button> <button id="cat-delete-' . $cat->id . '" class="btn btn-xs btn-danger btn-delete deleteButton" data-id="' . $cat->id . '" data-remote="edit"><i class="glyphicon glyphicon-trash"></i> Delete</button>';
            })->addIndexColumn()
            ->rawColumns(['images', 'action'])
            ->make(true);
    }

    public function allDeactvated(ManageUserRequest $request)
    {
        $cat = $this->gallery->allDeactive();

        return Datatables::of($cat)
            ->addColumn('images', function ($cat) {
                return '<img width="50" src="' . asset('/') . '/' . $cat->image . '"/>';
            })
            ->addColumn('action', function ($cat) {
                return '<a href="' . $cat->id . '/edit" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a> <button  id="cat-activate-' . $cat->id . '" class="btn btn-xs btn-success activateButton" data-id="' . $cat->id . '"><i class="glyphicon glyphicon-play"></i> Activate</button> <button id="cat-delete-' . $cat->id . '" class="btn btn-xs btn-danger btn-delete deleteButton" data-id="' . $cat->id . '" data-remote="edit"><i class="glyphicon glyphicon-trash"></i> Delete</button>';
            })->addIndexColumn()
            ->rawColumns(['images', 'action'])
            ->make(true);
    }

    public function deactivateView(ManageUserRequest $request)
    {
        return view('backend.access.gallery.deactivatedGallery');
    }

    public function deactivateItem(ManageUserRequest $request)
    {

        $this->gallery->deactiveItem($request->id);
    }

    public function activateItem(ManageUserRequest $request)
    {

        $this->gallery->activeItem($request->id);
    }


}