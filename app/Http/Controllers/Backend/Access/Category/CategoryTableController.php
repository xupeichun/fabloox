<?php

namespace App\Http\Controllers\Backend\Access\Category;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Access\User\ManageUserRequest;
use App\Repositories\Backend\Access\Category\CategoryRepository;
use Yajra\Datatables\Facades\Datatables;

class CategoryTableController extends Controller
{

    protected $category;


    public function __construct(CategoryRepository $category)
    {
        $this->category = $category;

    }

    public function getAll(ManageUserRequest $request)
    {
        $cat = $this->category->allActive()->get();
        return Datatables::of($cat)
            ->addColumn('image', function ($cat) {
                return '<img width="50" src="' . asset("/") . '/' . $cat->image . '">';
            })
            ->addColumn('featured', function ($cat) {
                return $cat->featured == 1 ? "true" : "false";
            })
            ->addColumn('action', function ($cat) {
                return '<a href="category/' . $cat->id . '/edit" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a> <button id="cat-deactivate-' . $cat->id . '" class="btn btn-xs btn-warning deactivateButton" data-id="' . $cat->id . '"><i class="glyphicon glyphicon-pause" aria-hidden="true"></i> Deactivate</button> <button id="cat-delete-' . $cat->id . '" class="btn btn-xs btn-danger btn-delete deleteButton" data-id="' . $cat->id . '" data-remote="edit"> <i class="glyphicon glyphicon-trash"></i> Delete</button>';
            })->addIndexColumn()
            ->rawColumns(['image', 'action', 'featured'])
            ->make(true);
    }

    public function allDeactvated(ManageUserRequest $request)
    {
        $cat = $this->category->allDeactive();

        return Datatables::of($cat)
            ->addColumn('image', function ($cat) {
                return '<img width="50" src="' . asset("/") . '/' . $cat->image . '">';
            })
            ->addColumn('featured', function ($cat) {
                return $cat->featured == 1 ? "true" : "false";
            })
            ->addColumn('action', function ($cat) {
                return '<a href="' . $cat->id . '/edit" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a> <button  id="cat-activate-' . $cat->id . '" class="btn btn-xs btn-success activateButton" data-id="' . $cat->id . '"><i class="glyphicon glyphicon-play"></i> Activate</button> <button id="cat-delete-' . $cat->id . '" class="btn btn-xs btn-danger btn-delete deleteButton" data-id="' . $cat->id . '" data-remote="edit"><i class="glyphicon glyphicon-trash"></i> Delete</button>';
            })->addIndexColumn()
            ->rawColumns(['image', 'action', 'featured'])
            ->make(true);
    }

    public function deactivateView(ManageUserRequest $request)
    {
        return view('backend.access.category.deactivatedCategory');
    }

    public function deactivateCategory(ManageUserRequest $request)
    {

        $this->category->deactiveCat($request->id);
    }

    public function activateCategory(ManageUserRequest $request)
    {

        $this->category->activeCat($request->id);
    }

    public function deleteCategory(ManageUserRequest $request)
    {

        $this->category->deleteCat($request->id);
    }

}
