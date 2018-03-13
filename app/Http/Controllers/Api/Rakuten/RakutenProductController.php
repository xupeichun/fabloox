<?php

namespace App\Http\Controllers\Api\Rakuten;

use App\Models\Access\Product\Product;
use App\Models\Access\Product\ProductVideo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\ApiBaseController;
use GuzzleHttp\Client;

class RakutenProductController extends ApiBaseController
{


    public function getProducts(Request $request, $max = 3)
    {

        if ($this->rakutenRefreshToken() != 'error') {
            try {
                $param = $request->all();

                $param['cat'] = !$request->cat ? env('DEFAULT_CATEGORY') : $request->cat;
                $param['max'] = $max;

                $token = $this->rakutenRefreshToken();
                $client = new Client([
                    // Base URI is used with relative requests
                    'base_uri' => 'https://api.rakutenmarketing.com',
                    // You can set any number of default request options.
                    'timeout' => 0,
                ]);

                $response = $client->get('/productsearch/1.0?', [
                    'query' => $param,
                    'headers' => [
                        'Authorization' => 'Bearer ' . $token,
                        'Accept' => 'application/xml',
                    ]
                ]);

                $xml = simplexml_load_string($response->getBody(), null);
                if ($xml->TotalMatches > 0) {
                    $product = [];
                    $productInfo = [
                        "pageNumber" => (int)$xml->PageNumber,
                        "pageSize" => count($xml->item),
                        "totalPage" => (int)$xml->TotalPages,
                        "totalRecords" => (int)$xml->TotalMatches,
                    ];
                    foreach ($xml->item as $products) {

                        $blocked = Product::where('product_id', (int)$products->linkid)->count();

                        if ($blocked) {
                            continue;
                        }

                        array_push($product, [
                            "merchantId" => (int)$products->mid,
                            "merchantName" => (string)$products->merchantname,
                            "linkId" => (int)$products->linkid,
                            "createdOn" => (string)$products->createdon,
                            "sku" => (string)$products->sku,
                            "productName" => (string)$products->productname,
                            "categoryName" => (string)$products->category->primary,
                            "secondaryCategoryName" => (string)$products->category->secondary,
                            "currency" => "$",
                            "priceCurrency" => (string)$products->price,
                            "salePriceCurrency" => (string)$products->saleprice,
                            "shortDescription" => (string)$products->description->short,
                            "longDescription" => (string)$products->description->long,
                            "linkUrl" => (string)$products->linkurl,
                            "image" => (string)$products->imageurl,
                            "isBlocked" => false,
                            "isFavourite" => \Auth::guard('api')->user() && \Auth::guard('api')->user()->favourites()->where('linkId',
                                '=',
                                (int)$products->linkid)->count() > 0 ? true : false,
                        ]);
                    }

                    return $product;

                } else {

                    return false;

                }
            } catch (\Exception $e) {
                return response()->json([
                    'message' => 'Something went south',
                    'statusCode' => 500
                ]);
            }
        }
    }


    //
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
                "videoLink" =>  $video->url,
                "image" => $video->thumbnail

            ]);

        }


        $similarProducts = $this->getProducts($request);

        $data = [
            'similarProducts' => $similarProducts != false ? $similarProducts : [],
            'similarVideos' => $videosData

        ];

        return $this->prepareResult(200, $data, 'Records found', null);


    }

}
