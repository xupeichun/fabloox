<?php

namespace App\Http\Controllers\Backend\Access\Brand;

use App\Library\TokenSingletonClass\TokenSingletonClass;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Access\User\ManageUserRequest;
use App\Http\Requests\Backend\Access\Brand\StoreBrandRequest;
use App\Repositories\Backend\Access\Brand\BrandRepository;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * @var RoleRepository
     */
    protected $brand;


    public function __construct(BrandRepository $brand)
    {
        $this->brand = $brand;

    }


    public function index(ManageUserRequest $request)
    {
        return view('backend.access.brand.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(ManageUserRequest $request)
    {
        return view('backend.access.brand.createBrand');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBrandRequest $request)
    {
        $status = $this->brand->create(
            [
                'data' => $request->only(
                    'brandName',
                    'merchant_id',
                    'sort_no',
                    'detail'
                ),
                'file' => $request->file('logo')
            ]);
        if (!$status) {
            return redirect()->back()
                ->withFlashDanger('Image format not supported');
        }
        return redirect()->route('admin.access.brand.index')->withFlashSuccess('Brand created successfully!');
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
        $brand = $this->brand->find($id);
        return view('backend.access.brand.editBrand', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreBrandRequest $request, $id)
    {
        $status = $this->brand->update(
            [
                'data' => $request->only(
                    'brandName',
                    'id',
                    'brandName',
                    'merchant_id',
                    'sort_no',
                    'detail'
                ),
                'file' => $request->file('logo')
            ]);
        if (!$status) {
            return redirect()->back()
                ->withFlashDanger('Image format not supported');
        }
        return redirect()->route('admin.access.brand.index')->withFlashSuccess('Brand updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ManageUserRequest $request, $id)
    {
        $this->brand->deleteBrand($id);
    }
}
