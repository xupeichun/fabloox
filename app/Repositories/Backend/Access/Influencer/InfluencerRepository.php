<?php
/**
 * Created by PhpStorm.
 * User: salman
 * Date: 9/21/17
 * Time: 1:27 PM
 */

namespace App\Repositories\Backend\Access\Influencer;

use Auth;
Use DB;
use App\Repositories\BaseRepository;
use App\Models\Access\Influencer\Influencer;

class InfluencerRepository extends BaseRepository
{
    const MODEL = Influencer::class;
    protected $influencers;

    public function __construct(Influencer $influencer)
    {
        $this->influencers = $influencer;

    }

    public function allActive()
    {
        $result = $this->query()->with('influencerVideos')->where('status', 1);


        return $result;
    }

    public function allDeactive()
    {
        $result = $this->query()->where('status', 0);


        return $result;
    }

    public function deactiveItem($value)
    {
        $influencerModel = Influencer::find($value);
        $influencerModel->status = 0;
        $influencerModel->addedBy = Auth::user()->id;

        DB::transaction(function () use ($influencerModel) {
            if ($influencerModel->save()) {
                return true;
            }

            throw new GeneralException(trans('exceptions.backend.access.users.create_error'));
        });
    }

    public function deleteBrand($value)
    {
        $influencerModel = Influencer::find($value);


        DB::transaction(function () use ($influencerModel) {
            if ($influencerModel->delete()) {
                return true;
            }

            throw new GeneralException(trans('exceptions.backend.access.users.create_error'));
        });
    }

    public function activeItem($value)
    {
        $influencerModel = Influencer::find($value);
        $influencerModel->status = 1;
        $influencerModel->addedBy = Auth::user()->id;

        DB::transaction(function () use ($influencerModel) {
            if ($influencerModel->save()) {
                return true;
            }

            throw new GeneralException(trans('exceptions.backend.access.users.create_error'));
        });
    }

    public function create($input)
    {
        $influencerModel = new Influencer();
        $influencerModel->influencerName = $input['data']['influencerName'];
        $influencerModel->channel = $input['data']['channel'];
        $influencerModel->description = $input['data']['description'];
        $influencerModel->order = $input['data']['order'];
        $influencerModel->channel_name = $input['data']['channel_name'];
        $influencerModel->addedBy = Auth::user()->id;

        $file = $input['file'];

        if (!empty($file)) {
            $ext = $file->getClientOriginalExtension();
            $ext = strtolower($ext);
            if ($ext == 'jpg' || $ext == 'png' || $ext == 'jpeg') {
                $newFilename = "inf_img_" . time() . "_" . str_replace(" ","-",$file->getClientOriginalName());

                $destinationPath = public_path() . '/uploads/influencerimages';
                $file->move($destinationPath, $newFilename);
                $picPath = $newFilename;
                $influencerModel->image = $picPath;

            } else {
                    return false;
            }
        }

        DB::transaction(function () use ($influencerModel) {
            if ($influencerModel->save()) {
                return true;
            }

            throw new GeneralException(trans('exceptions.backend.access.users.create_error'));
        });
        return true;

    }

    public function update($input)
    {

        $influencerModel = Influencer::find($input['data']['id']);
        $influencerModel->influencerName = $input['data']['influencerName'];
        $influencerModel->channel = $input['data']['channel'];
        $influencerModel->description = $input['data']['description'];
        $influencerModel->order = $input['data']['order'];
        $influencerModel->channel_name = $input['data']['channel_name'];

        $influencerModel->addedBy = Auth::user()->id;

        $file = $input['file'];

        if (!empty($file)) {
            $ext = $file->getClientOriginalExtension();
            $ext = strtolower($ext);
            if ($ext == 'jpg' || $ext == 'png' || $ext == 'jpeg') {
                $newFilename = "inf_img_" . time() . "_" . str_replace(" ","-",$file->getClientOriginalName());

                $destinationPath = public_path() . '/uploads/influencerimages';
                $file->move($destinationPath, $newFilename);
                $picPath = $newFilename;
                $influencerModel->image = $picPath;

            } else {
                    return false;
            }
        }
        DB::transaction(function () use ($influencerModel) {
            if ($influencerModel->save()) {
                return true;
            }

            throw new GeneralException(trans('exceptions.backend.access.users.create_error'));
        });
        return true;

    }

}