<?php

namespace App\Http\Controllers\Api\Product;

use App\Models\Access\Product\ProductVideo;
use App\Traits\VgLink\VgLinkProductTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;


class ProductController extends Controller
{


    public function index(Request $request)
    {
        /**
         * 1.check memache  是否有数据
         * 2.没有数据，请求接口 得到data
         * 3.有数据，直接处理 data
         * 4.分页给出指定页
         */
        $currentPageSize = isset($request->max) ?  $request->max : 20;
        $currentPage     = isset($request->pageNumber) ? $request->pageNumber : 1;

        if (isset($request->sorttype))
        {
            $request->max = $currentPageSize + 79;
            $vglinkProducts = $this->getVgLinkProduct($request);
            $rakutenProducts = $this->getRakutenProducts($request);
            $data = data_merge($rakutenProducts, $vglinkProducts);

            $sort = strtolower($request->sorttype) == 'asc' ? SORT_ASC : SORT_DESC;
            array_multisort(array_column($data['products'], 'priceCurrency' ), $sort, $data['products'] );
            $data['products'] = array_slice($data['products'], $currentPage - 1 , $currentPageSize);
        }
        else
        {
            $vglinkProducts = $this->getVgLinkProduct($request);
            $rakutenProducts = $this->getRakutenProducts($request);
            dd($rakutenProducts);exit;
            $data = data_merge($rakutenProducts, $vglinkProducts);
        }

        $data['pageInfo']['totalRecords'] = (int) $vglinkProducts['pageInfo']['totalRecords'] + (int) $rakutenProducts['pageInfo']['totalRecords'];
        $data['pageInfo']['pageNumber'] =(int) $currentPage;
        $data['pageInfo']['pageSize'] = (int) $currentPageSize;
        $data['pageInfo']['totalPage'] = (int) ceil($data['pageInfo']['totalRecords'] / $data['pageInfo']['pageSize']);

        if (count($data))
        {
            return $this->prepareResult(200, $data, 'Records found', null);
        } else {
            return $this->prepareResult(204, null, 'No record found', null);
        }
    }


    public function productDetails(Request $request, $linkid)
    {


        $videos = ProductVideo::where('link_id', $linkid)->get();
        $videosData = [];

        foreach ($videos as $video) {
            array_push($videosData, [

                "id" => (integer)$video->id,
                "InfluencerId" => (int)$video->id,
                "name" => $video->video_name,
                "channelId" => $video->link_id,
                "description" => $video->video_description,
                "videoLink" => $video->url,
                "image" => $video->thumbnail

            ]);
        }


        $vglinkProducts = $this->getVgLinkProduct($request, null);
        $rakutenProducts = $this->getRakutenProducts($request, null);

        $product = [];

        $product = data_merge($rakutenProducts, $vglinkProducts);


        $isFavourite = false;
        $isFavourite = \Auth::guard('api')->user() && \Auth::guard('api')->user()->favourites()->where('linkId', '=',
            $linkid)->count() > 0 ? true : false;

//        dd($isFavourite);

        $data = [
            'isFavourite' => $isFavourite,
            'similarProducts' => isset($product['products']) ? $product['products'] : [],
            'similarVideos' => $videosData

        ];

        return $this->prepareResult(200, $data, 'Records found', null);

    }

}
