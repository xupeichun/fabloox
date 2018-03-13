<?php

namespace App\Http\Controllers\Backend\Access\Gallery;

use App\Http\Requests\Backend\Access\Gallery\StoreGalleryRequest;
use App\Http\Requests\Backend\Access\User\ManageUserRequest;
use App\Repositories\Backend\Access\Gallery\GalleryRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * @var RoleRepository
     */
    protected $gallery;


    public function __construct(GalleryRepository $gallery)
    {
        $this->gallery = $gallery;

    }


    public function index(ManageUserRequest $request)
    {
        return view('backend.access.gallery.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(ManageUserRequest $request)
    {
        return view('backend.access.gallery.createGallery');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request .
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGalleryRequest $request)
    {
        $status= $this->gallery->create(
            [   'data'=>$request->only([
                    'start_date',
                    'end_date'
            ]),
                'file'=>$request->file('image')
            ]);
        if (!$status) {
            return redirect()->back()
                ->withFlashDanger('Image format not supported');
        }
        return redirect()->route('admin.access.gallery.index')->withFlashSuccess('Image added successfully!');
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
        $brand = $this->gallery->find($id);
        return view('backend.access.gallery.editGallery', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreGalleryRequest $request, $id)
    {
        $status=   $this->gallery->update(
            [
                'data' => $request->only(
                    'id',
                    'start_date',
                    'end_date'
                ),
                'file'=>$request->file('image')
            ]);
        if (!$status) {
            return redirect()->back()
                ->withFlashDanger('Image format not supported');
        }
        return redirect()->route('admin.access.gallery.index')->withFlashSuccess('Image updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ManageUserRequest $request, $id)
    {
        $this->gallery->deleteBrand($id);
    }
}
