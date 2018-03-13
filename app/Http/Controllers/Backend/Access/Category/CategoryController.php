<?php

namespace App\Http\Controllers\Backend\Access\Category;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Access\User\ManageUserRequest;
use App\Http\Requests\Backend\Access\Category\StoreCategoryRequest;
use App\Repositories\Backend\Access\Category\CategoryRepository;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * @var RoleRepository
     */
    protected $category;


    public function __construct(CategoryRepository $category)
    {
        $this->category = $category;

    }


    public function index(ManageUserRequest $request)
    {
        return view('backend.access.category.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(ManageUserRequest $request)
    {
        return view('backend.access.category.createCategory');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request)
    {
        $status = $this->category->create(
            [
                'data' => $request->only(
                    'categoryName',
                    'sort_id',
                    'keyword',
                    'featured'
                ),
                'file' => $request->file('image')
            ]);

        if (!$status) {
            return redirect()->back()
                ->withFlashDanger('Image format not supported.');
        }

        return redirect()->route('admin.access.category.index')->withFlashSuccess('Category created successfully!');

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(ManageUserRequest $request, $id)
    {
        $cat = $this->category->find($id);
        return view('backend.access.category.editCategory', compact('cat'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCategoryRequest $request, $id)
    {
        $status=  $this->category->update(
            [
                'data' => $request->only(
                    'categoryName',
                    'id',
                    'sort_id',
                    'keyword',
                    'featured'
                ),
                'file' => $request->file('image')
            ]);
        if (!$status) {
            return redirect()->back()
                ->withFlashDanger('Image format not supported.');
        }
        return redirect()->route('admin.access.category.index')->withFlashSuccess('Category updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ManageUserRequest $request, $id)
    {
        $this->category->deleteCat($id);
    }
}
