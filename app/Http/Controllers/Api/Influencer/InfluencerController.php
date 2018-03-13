<?php

namespace App\Http\Controllers\Api\Influencer;

use App\Models\Access\Influencer\Influencer;
use App\Repositories\Backend\Access\Influencer\InfluencerRepository;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Mockery\Exception;


class InfluencerController extends Controller
{
    protected $influencer;


    public function __construct(InfluencerRepository $influencer)
    {
        $this->influencer = $influencer;

    }

    public function getInfluencers()
    {
        $influencer = Influencer::where('status', 1)
            ->get();
        $result = [];
        if (count($influencer)) {

            foreach ($influencer as $influencer) {
                array_push($result, [
                    "id" => $influencer->id,
                    "InfluencerId" => (int)$influencer->id,
                    "name" => $influencer->influencerName,
                    "channelId" => $influencer->channel,
                    "description" => $influencer->description,
                    "videoLink" => "",
                    "image" => env('APP_URL') . '/uploads/influencerimages/' . $influencer->image
                ]);
            }


            return $this->prepareResult(200, ['Influencers' => $result], 'Records found', null);
        }

        return $this->prepareResult(200, null, 'No record found', null);


    }

    public function getVideos(Request $request)
    {
        try {
            $influencer = Influencer::find($request->input('id'));

            if (isset($influencer)) {

                $param = $request->except(['id']);

                $param['channelId'] = $influencer->channel;
                $param['type'] = 'video';
                $param['part'] = 'snippet';
                $param['key'] = env('GOOGLE_DEV_KEY');
                $param['maxResults'] = 50;


                $client = new Client([
                    // Base URI is used with relative requests
                    'base_uri' => 'https://www.googleapis.com',
                    // You can set any number of default request options.
                    'timeout' => 0,
                ]);

                $response = $client->get('/youtube/v3/search?', [
                    'query' => $param
                ]);

                $result = json_decode((string)$response->getBody(), true);



                if ($result['pageInfo']['totalResults'] > 0) {
                    $videos = [];
                    $pageInfo = [
                        "nextPageToken" => isset($result['nextPageToken']) ? $result['nextPageToken'] : "",
                        "prevPageToken" => isset($result['prevPageToken']) ? $result['prevPageToken'] : "",
                        "pageSize" => $result['pageInfo']['resultsPerPage'],
                        "totalRecords" => (int)$result['pageInfo']['totalResults'],
                    ];
                    foreach ($result['items'] as $video) {

                        array_push($videos, [
                            "id" => (integer)$influencer->id,
                            "InfluencerId" => (int)$request->input('id'),
                            "name" => $video['snippet']['title'],
                            "channelId" => $video['snippet']['channelId'],
                            "description" => $video['snippet']['description'],
                            "videoLink" => "https://www.youtube.com/watch?v=" . $video['id']['videoId'],
                            "image" => $video['snippet']['thumbnails']['high']['url']

                        ]);
                    }
                    return $this->prepareResult(200, ["pageInfo" => $pageInfo, "videos" => $videos],
                        "Record found");

                } else {
                    return $this->prepareResult(200, null, "No record found");
                }


            } else {
                return $this->prepareResult(200, null, "No record found");
            }

        } catch (Exception $exception) {

        }
    }


    public function searchInfluencer(Request $request)
    {


        $influencers = Influencer::where('influencerName', 'like', '%' . $request->search . '%')
            ->get();
        $result = [];
        if (count($influencers)) {

            foreach ($influencers as $influencer) {
                array_push($result, [
                    "id" => $influencer->id,
                    "InfluencerId" => $influencer->id,
                    "name" => $influencer->influencerName,
                    "channelId" => $influencer->channelId,
                    "description" => $influencer->description,
                    "videoLink" => "",
                    "image" => env('APP_URL') . '/uploads/influencerimages/' . $influencer->image
                ]);
            }


            return $this->prepareResult(200, ['influencers' => $result], 'Records found', null);
        }

        return $this->prepareResult(200, null, 'No record found', null);


    }

}