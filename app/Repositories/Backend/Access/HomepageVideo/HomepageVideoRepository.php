<?php
/**
 * Created by PhpStorm.
 * User: salman
 * Date: 10/16/17
 * Time: 6:54 PM
 */

namespace App\Repositories\Backend\Access\HomepageVideo;

use Auth;
Use DB;
use App\Repositories\BaseRepository;
use App\Models\Access\HomepageVideo\HomepageVideo;
use App\Traits\Rakuten;

class HomepageVideoRepository extends BaseRepository
{
    const MODEL = HomepageVideo::class;
    protected $homepageVideo;
    use Rakuten\RakutenTrait;

    public function __construct(HomepageVideo $homepageVideo)
    {
        $this->homepageVideo = $homepageVideo;

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
        $homepageVideoModel = HomepageVideo::find($value);
        $homepageVideoModel->status = 0;

        DB::transaction(function () use ($homepageVideoModel) {
            if ($homepageVideoModel->save()) {
                return true;
            }

            throw new GeneralException(trans('exceptions.backend.access.users.create_error'));
        });
    }

    public function deleteBrand($value)
    {
        $homepageVideoModel = HomepageVideo::find($value);


        DB::transaction(function () use ($homepageVideoModel) {
            if ($homepageVideoModel->delete()) {
                return true;
            }

            throw new GeneralException(trans('exceptions.backend.access.users.create_error'));
        });
    }

    public function activeItem($value)
    {
        $homepageVideoModel = HomepageVideo::find($value);
        $homepageVideoModel->status = 1;


        DB::transaction(function () use ($homepageVideoModel) {
            if ($homepageVideoModel->save()) {
                return true;
            }

            throw new GeneralException(trans('exceptions.backend.access.users.create_error'));
        });
    }

    public function create($input)
    {

        $theArray=[];
        array_push($theArray,$input['data']['url']);
        $result = $this->YoutubeVideoById($theArray);

        if ($result['status'] == 200) {
            foreach ($result['videos'] as $key => $value) {
                $homepageVideoModel = new HomepageVideo();

                $homepageVideoModel->url = $value['videoLink'];
                $homepageVideoModel->thumbnail = $value['image'];
                $homepageVideoModel->video_name = $value['name'];
                $homepageVideoModel->video_description = $value['description'];
                $homepageVideoModel->status = 1;
                $homepageVideoModel->save();
                return true;
            }

        } elseif ($result['status'] == 204) {
            return false;
        }


        /*        DB::transaction(function () use ($homepageVideoModel) {
                    if ($homepageVideoModel->save()) {
                        return true;
                    }

                    throw new GeneralException(trans('exceptions.backend.access.users.create_error'));
                });*/
    }

    public function update($input)
    {

        $homepageVideoModel = HomepageVideo::find($input['data']['id']);
        $theArray=[];
        array_push($theArray,$input['data']['url']);
        $result = $this->YoutubeVideoById($theArray);

        if ($result['status'] == 200) {
            foreach ($result['videos'] as $key => $value) {


                $homepageVideoModel->url = $value['videoLink'];
                $homepageVideoModel->thumbnail = $value['image'];
                $homepageVideoModel->video_name = $value['name'];
                $homepageVideoModel->video_description = $value['description'];
                $homepageVideoModel->status = 1;
                $homepageVideoModel->save();
                return true;
            }

        } elseif ($result['status'] == 204) {
            return false;
        }
    }

}