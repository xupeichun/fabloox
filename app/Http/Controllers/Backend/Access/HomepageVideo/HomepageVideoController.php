<?php

namespace App\Http\Controllers\Backend\Access\HomepageVideo;

use App\Http\Requests\Backend\Access\HomepageVideo\StoreHomepageVideoRequest;
use App\Http\Requests\Backend\Access\User\ManageUserRequest;
use App\Repositories\Backend\Access\HomepageVideo\HomepageVideoRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomepageVideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * @var RoleRepository
     */
    protected $homepageVideo;


    public function __construct(HomepageVideoRepository $homepageVideo)
    {
        $this->homepageVideo = $homepageVideo;

    }


    public function index(ManageUserRequest $request)
    {
        return view('backend.access.homepageVideo.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(ManageUserRequest $request)
    {
        return view('backend.access.homepageVideo.createHomepageVideo');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request .
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreHomepageVideoRequest $request)
    {
        if ($this->homepageVideo->create(['data' => $request->only('url')])) {
            return redirect()->route('admin.access.homepagevideo.index')->withFlashSuccess('Video added successfully!');

        } else {
            return redirect()->route('admin.access.homepagevideo.create')->withFlashDanger('Video Not found with this URL.');

        }

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
        $brand = $this->homepageVideo->find($id);
        return view('backend.access.homepageVideo.editHomepageVideo', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreHomepageVideoRequest $request, $id)
    {
        if ($this->homepageVideo->update(['data' => $request->only('id', 'url')])) {
            return redirect()->route('admin.access.homepagevideo.index')->withFlashSuccess('Video updated successfully!');

        } else {
            return redirect()->route('admin.access.homepagevideo.edit',['id' => $request->input('id')])->withFlashDanger('Video Not found with this URL');

        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ManageUserRequest $request, $id)
    {
        $this->homepageVideo->deleteBrand($id);
    }
}