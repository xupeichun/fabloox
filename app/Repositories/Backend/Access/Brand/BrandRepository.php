<?php
/**
 * Created by PhpStorm.
 * User: salman
 * Date: 9/14/17
 * Time: 1:38 PM
 */

namespace App\Repositories\Backend\Access\Brand;


use Auth;
Use DB;
use App\Repositories\BaseRepository;
use App\Models\Access\Brand\Brand;

class BrandRepository extends BaseRepository
{
    const MODEL = Brand::class;
    protected $brands;

    public function __construct(brand $brand)
    {
        $this->brands = $brand;

    }

    public function allActive()
    {
        $result = $this->query()->with('brandVideos')->where('status', 1);


        return $result;
    }

    public function allDeactive()
    {
        $result = $this->query()->where('status', 0);


        return $result;
    }

    public function deactiveBrand($value)
    {
        $brandModel = Brand::find($value);
        $brandModel->status = 0;
        $brandModel->addedBy = Auth::user()->id;

        DB::transaction(function () use ($brandModel) {
            if ($brandModel->save()) {
                return true;
            }

            throw new GeneralException(trans('exceptions.backend.access.users.create_error'));
        });
    }

    public function deleteBrand($value)
    {
        $brandModel = Brand::find($value);


        DB::transaction(function () use ($brandModel) {
            if ($brandModel->delete()) {
                return true;
            }

            throw new GeneralException(trans('exceptions.backend.access.users.create_error'));
        });
    }

    public function activeBrand($value)
    {
        $brandModel = Brand::find($value);
        $brandModel->status = 1;
        $brandModel->addedBy = Auth::user()->id;

        DB::transaction(function () use ($brandModel) {
            if ($brandModel->save()) {
                return true;
            }

            throw new GeneralException(trans('exceptions.backend.access.users.create_error'));
        });
    }

    public function create($input)
    {

        $brandModel = new Brand();
        $brandModel->brandName = $input['data']['brandName'];
        $brandModel->merchant_id = $input['data']['merchant_id'];
        $brandModel->sort_no = $input['data']['sort_no'];
        $brandModel->detail = $input['data']['detail'];
        $brandModel->addedBy = Auth::user()->id;

        $file = $input['file'];

        if (!empty($file)) {
            $ext = $file->getClientOriginalExtension();
            $ext = strtolower($ext);
            if ($ext == 'jpg' || $ext == 'png' || $ext == 'jpeg') {
                $newFilename = "inf_img_" . time() . "_" . str_replace(" ", "-", $file->getClientOriginalName());

                $destinationPath = public_path() . '/uploads/brandimages';
                $file->move($destinationPath, $newFilename);
                $picPath = '/uploads/brandimages/' . $newFilename;
                $brandModel->logo = $picPath;

            } else {
                return false;
            }
        }

        DB::transaction(function () use ($brandModel) {
            if ($brandModel->save()) {
                return true;
            }

            throw new GeneralException(trans('exceptions.backend.access.users.create_error'));
        });
        return true;

    }

    public function update($input)
    {

        $brandModel = Brand::find($input['data']['id']);
        $brandModel->brandName = $input['data']['brandName'];
        $brandModel->merchant_id = $input['data']['merchant_id'];
        $brandModel->sort_no = $input['data']['sort_no'];
        $brandModel->detail = $input['data']['detail'];
        $brandModel->addedBy = Auth::user()->id;

        $file = $input['file'];

        if (!empty($file)) {
            $ext = $file->getClientOriginalExtension();
            $ext = strtolower($ext);
            if ($ext == 'jpg' || $ext == 'png' || $ext == 'jpeg') {
                $newFilename = "inf_img_" . time() . "_" . str_replace(" ", "-", $file->getClientOriginalName());

                $destinationPath = public_path() . '/uploads/brandimages';
                $file->move($destinationPath, $newFilename);
                $picPath = '/uploads/brandimages/' . $newFilename;
                $brandModel->logo = $picPath;

            } else {
                return false;
            }
        }

        DB::transaction(function () use ($brandModel) {
            if ($brandModel->save()) {
                return true;
            }

            throw new GeneralException(trans('exceptions.backend.access.users.create_error'));
        });
        return true;

    }


    public function allBrands()
    {
        $brand = Brand::where('status', 1)->get();
        return $brand;
    }
}