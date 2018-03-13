<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\CreateBrandVideoRequest;
use App\Http\Requests\Admin\UpdateBrandVideoRequest;
use App\Repositories\Admin\BrandVideoRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class BrandVideoController extends AppBaseController
{
    /** @var  BrandVideoRepository */
    private $brandVideoRepository;

    public function __construct(BrandVideoRepository $brandVideoRepo)
    {
        $this->brandVideoRepository = $brandVideoRepo;
    }

    /**
     * Display a listing of the BrandVideo.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->brandVideoRepository->pushCriteria(new RequestCriteria($request));
        $brandVideos = $this->brandVideoRepository->all();

        return view('admin.brand_videos.index')
            ->with('brandVideos', $brandVideos);
    }

    /**
     * Show the form for creating a new BrandVideo.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.brand_videos.create');
    }

    /**
     * Store a newly created BrandVideo in storage.
     *
     * @param CreateBrandVideoRequest $request
     *
     * @return Response
     */
    public function store(CreateBrandVideoRequest $request)
    {
        $input = $request->all();

        $brandVideo = $this->brandVideoRepository->create($input);


        $file = $request->file('image');

        if ($file) {
            $ext = $file->getClientOriginalExtension();


            $ext = strtolower($ext);

            if ($ext == 'jpg' || $ext == 'png' || $ext == 'jpeg') {
                $newFilename = "inf_img_" . time() . "_" . $file->getClientOriginalName();

                $destinationPath = public_path() . '/uploads/brands';
                $file->move($destinationPath, $newFilename);
                $picPath = '/uploads/brands/' . $newFilename;
                $brandVideo->image = $picPath;
                $brandVideo->update();

            } else {

            }
        }
        Flash::success('Brand Video saved successfully.');

        return redirect(route('admin.brandVideos.index'));
    }

    /**
     * Display the specified BrandVideo.
     *
     * @param  int $id
     *
     * @return Response
     */
    public
    function show(
        $id
    )
    {
        $brandVideo = $this->brandVideoRepository->findWithoutFail($id);

        if (empty($brandVideo)) {
            Flash::error('Brand Video not found');

            return redirect(route('admin.brandVideos.index'));
        }

        return view('admin.brand_videos.show')->with('brandVideo', $brandVideo);
    }

    /**
     * Show the form for editing the specified BrandVideo.
     *
     * @param  int $id
     *
     * @return Response
     */
    public
    function edit(
        $id
    )
    {
        $brandVideo = $this->brandVideoRepository->findWithoutFail($id);

        if (empty($brandVideo)) {
            Flash::error('Brand Video not found');

            return redirect(route('admin.brandVideos.index'));
        }

        return view('admin.brand_videos.edit')->with('brandVideo', $brandVideo);
    }

    /**
     * Update the specified BrandVideo in storage.
     *
     * @param  int $id
     * @param UpdateBrandVideoRequest $request
     *
     * @return Response
     */
    public
    function update( $id, UpdateBrandVideoRequest $request)
    {
        $brandVideo = $this->brandVideoRepository->findWithoutFail($id);

        if (empty($brandVideo)) {
            Flash::error('Brand Video not found');

            return redirect(route('admin.brandVideos.index'));
        }

        $brandVideo = $this->brandVideoRepository->update($request->all(), $id);
        $file = $request->file('image');

        if ($file) {
            $ext = $file->getClientOriginalExtension();
            $ext = strtolower($ext);
            if ($ext == 'jpg' || $ext == 'png' || $ext == 'jpeg') {
                $newFilename = "inf_img_" . time() . "_" . $file->getClientOriginalName();
                $destinationPath = public_path() . '/uploads/brands';
                $file->move($destinationPath, $newFilename);
                $picPath = '/uploads/brands/' . $newFilename;
                $brandVideo->image = $picPath;
                $brandVideo->update();


            } else {


            }
        }
        Flash::success('Brand Video updated successfully.');

        return redirect(route('admin.brandVideos.index'));
    }

    /**
     * Remove the specified BrandVideo from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public
    function destroy(
        $id
    )
    {
        $brandVideo = $this->brandVideoRepository->findWithoutFail($id);

        if (empty($brandVideo)) {
            Flash::error('Brand Video not found');

            return redirect(route('admin.brandVideos.index'));
        }

        $this->brandVideoRepository->delete($id);

        Flash::success('Brand Video deleted successfully.');

        return redirect(route('admin.brandVideos.index'));
    }
}
