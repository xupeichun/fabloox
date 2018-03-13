<?php
/**
 * Created by PhpStorm.
 * User: salman
 * Date: 10/19/17
 * Time: 7:44 PM
 */

namespace App\Repositories\Backend\Access\Gallery;


use App\Models\Access\Gallery\Gallery;
use Carbon\Carbon;
use DB;
use App\Repositories\BaseRepository;

class GalleryRepository extends BaseRepository
{
    const MODEL = Gallery::class;
    protected $gallery;

    public function __construct(Gallery $gallery)
    {
        $this->gallery = $gallery;

    }

    public function allActive()
    {
        $result = $this->query()->where('status', 1);

        return $result;
    }

    public function allDeactive()
    {
        $result = $this->query()->where('status', 0);


        return $result;
    }

    public function deactiveItem($value)
    {
        $galleryModel = Gallery::find($value);
        $galleryModel->status = 0;

        DB::transaction(function () use ($galleryModel) {
            if ($galleryModel->save()) {
                return true;
            }

            throw new GeneralException(trans('exceptions.backend.access.users.create_error'));
        });
    }

    public function deleteBrand($value)
    {
        $galleryModel = Gallery::find($value);


        DB::transaction(function () use ($galleryModel) {
            if ($galleryModel->delete()) {
                return true;
            }

            throw new GeneralException(trans('exceptions.backend.access.users.create_error'));
        });
    }

    public function activeItem($value)
    {
        $galleryModel = Gallery::find($value);
        $galleryModel->status = 1;


        DB::transaction(function () use ($galleryModel) {
            if ($galleryModel->save()) {
                return true;
            }

            throw new GeneralException(trans('exceptions.backend.access.users.create_error'));
        });
    }

    public function create($input)
    {
        $galleryModel = new Gallery();


        $sDate = new Carbon($input['data']['start_date']);
//        $sDate->toDateTimeString();
        $eDate = new Carbon($input['data']['end_date']);
//        $eDate->toDateTimeString();

        $galleryModel->status = 1;
        $galleryModel->start_date = $sDate;
        $galleryModel->end_date = $eDate;

        $file = $input['file'];

        if (!empty($file)) {
            $ext = $file->getClientOriginalExtension();
            $ext = strtolower($ext);
            if ($ext == 'jpg' || $ext == 'png' || $ext == 'jpeg') {
                $newFilename = "inf_img_" . time() . "_" . str_replace(" ", "-", $file->getClientOriginalName());

                $destinationPath = public_path() . '/uploads/gallery';
                $file->move($destinationPath, $newFilename);
                $picPath = '/uploads/gallery/' . $newFilename;
                $galleryModel->image = $picPath;

            } else {
                return false;
            }
        }


        DB::transaction(function () use ($galleryModel) {
            if ($galleryModel->save()) {
                return true;
            }

            throw new GeneralException(trans('exceptions.backend.access.users.create_error'));
        });
        return true;

    }

    public function update($input)
    {

        $galleryModel = Gallery::find($input['data']['id']);

        $sDate = new Carbon($input['data']['start_date']);
        $sDate->toDateTimeString();
        $eDate = new Carbon($input['data']['end_date']);
        $eDate->toDateTimeString();
        $galleryModel->start_date = $sDate;
        $galleryModel->end_date = $eDate;

        $file = $input['file'];

        if (!empty($file)) {
            $ext = $file->getClientOriginalExtension();
            $ext = strtolower($ext);
            if ($ext == 'jpg' || $ext == 'png' || $ext == 'jpeg') {
                $newFilename = "inf_img_" . time() . "_" . str_replace(" ", "-", $file->getClientOriginalName());

                $destinationPath = public_path() . '/uploads/gallery';
                $file->move($destinationPath, $newFilename);
                $picPath = '/uploads/gallery/' . $newFilename;
                $galleryModel->image = $picPath;

            } else {
                return false;
            }
        }

        DB::transaction(function () use ($galleryModel) {
            if ($galleryModel->save()) {
                return true;
            }

            throw new GeneralException(trans('exceptions.backend.access.users.create_error'));
        });
        return true;

    }

}