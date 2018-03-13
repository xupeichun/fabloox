<?php

namespace App\Http\Controllers\Backend\Access\Influencer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Access\User\ManageUserRequest;
use App\Http\Requests\Backend\Access\Influencer\StoreInfluencerRequest;
use App\Repositories\Backend\Access\Influencer\InfluencerRepository;

class InfluencerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * @var RoleRepository
     */
    protected $influencer;


    public function __construct(InfluencerRepository $influencer)
    {
        $this->influencer = $influencer;

    }


    public function index(ManageUserRequest $request)
    {
        return view('backend.access.influencer.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(ManageUserRequest $request)
    {
        return view('backend.access.influencer.createInfluencer');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request .
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInfluencerRequest $request)
    {
        $status = $this->influencer->create(
            [
                'data' => $request->only(
                    'influencerName',
                    'channel',
                    'description',
                    'order',
                    'channel_name'
                ),
                'file' => $request->file('image')
            ]);
        if (!$status) {
            return redirect()->back()
                ->withFlashDanger('Image format not supported');
        }
        return redirect()->route('admin.access.influencer.index')->withFlashSuccess('Influencer created successfully!');
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
        $brand = $this->influencer->find($id);
        return view('backend.access.influencer.editInfluencer', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreInfluencerRequest $request, $id)
    {
        $status = $this->influencer->update(
            [
                'data' => $request->only(
                    'influencerName',
                    'channel',
                    'description',
                    'order',
                    'id',
                    'channel_name'
                ),
                'file' => $request->file('image')
            ]);

        if (!$status) {
            return redirect()->back()
                ->withFlashDanger('Image format not supported');
        }
        return redirect()->route('admin.access.influencer.index')->withFlashSuccess('Influencer updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ManageUserRequest $request, $id)
    {
        $this->influencer->deleteBrand($id);
    }
}
