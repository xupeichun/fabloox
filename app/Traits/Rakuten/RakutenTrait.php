<?php

namespace App\Traits\Rakuten;

use App\Models\Access\Brand\Brand;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Models\Access\BestOnFabloox\BestOnFabloox;
use App\Models\Access\Product\Product;
use App\Models\Access\Product\ProductVideo;
use Illuminate\Support\Facades\Log;


trait  RakutenTrait
{


    public $token;


    private function makeLogsRakuten($data)
    {
//        file_put_contents('/var/log/apache2/fabloox-vigilinks.log', PHP_EOL . print_r($data, true) . PHP_EOL . Carbon::now(),
//            FILE_APPEND);
//        chmod('/var/log/apache2/fabloox-vigilinks.log', 0777);
    }


    public function rakutenRefreshToken()
    {

        try {
            $client = new Client([
                // Base URI is used with relative requests
                'base_uri' => 'https://api.rakutenmarketing.com',
//            'base_uri' => 'https://api.rakutenmarketing.com/coupon/1.0'
                // You can set any number of default request options.
                'timeout' => 10,
            ]);

            $response = $client->post('/token', [
                'form_params' => [
                    'grant_type' => 'password',
                    'username' => env('RAKUTEN_USERNAME'),
                    'password' => env('RAKUTEN_PASSWORD'),
                    'scope' => env('RAKUTEN_SCOPE'),
                ],
                'headers' => [
                    'Authorization' => env('RAKUTEN_APP_KEY'),
                    'Content-Type' => 'application/x-www-form-urlencoded',

                ]
            ]);


            $token = json_decode($response->getBody());

            return $token->access_token;
        } catch (\Exception $e) {
            return $e->getMessage();

        }


    }


    public function getRakutenProducts(Request $request, $brand = null, $secondCall = false)
    {
        $allBrands = Brand::where('merchant_id', '>', 0)->pluck('merchant_id')->toArray();
//        if ((int)$brand == 0  && !request()->mid) {
//            return false;
//        }
        try
        {
            $slug = request()->keyword;
            $param = [];
            if (trim(request()->keyword) != '')
            {
                $slug = str_slug(request()->keyword, ' ');
                request()->merge(['keyword' => $slug]);

            } else {
                $param = request()->except(['keyword']);
            }

            if (!in_array(request()->sorttype, ['asc', 'dsc']))
            {
                request()->request->remove('sorttype');
                request()->request->remove('sort');
            }
            if (trim(request()->sorttype) == '' || trim(request()->sort) == '')
            {
                request()->request->remove('sorttype');
                request()->request->remove('sort');
            }

            if (request()->mid == '')
            {
                request()->request->remove('mid');
            }

            if (request()->keyword == '')
            {
                request()->request->remove('keyword');
            }
            if (request()->cat && !request()->keyword)
            {
                $param['keyword'] = request()->cat;
            }
            if (!$secondCall)
            {
                $this->token = $this->rakutenRefreshToken();
            }

            $param = request()->all();

            if ($brand != null) {
                $param['mid'] = $brand;
            }
            if (request()->pagenumber)
            {
                $param['pagenumber'] = request()->pagenumber;
            }

            $param['max'] = isset(request()->max) ? request()->max : 100;

            if (request()->cat)
            {
                $param['keyword'] = request()->cat;
                unset($param['cat']);
            }

//            $param['keyword'] = 'oil haircare';

            if (!request()->mid && !request()->keyword && !$brand)
            {
                $param['cat'] = env('DEFAULT_CATEGORY');
            }


            if (\Request::is('admin*'))
            {

                $param['cat'] =  'health beauty' ;//env('DEFAULT_CATEGORY');

            }

            Log::info('input >>>>>>', $param);

//            dd($param);

            $client = new Client([
                // Base URI is used with relative requests
                'base_uri' => 'https://api.rakutenmarketing.com',
                // You can set any number of default request options.
                'timeout' => 10,
            ]);

            $response = $client->get('/productsearch/1.0?', [
                'query' => $param,
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->token,
                    'Accept' => 'application/xml',
                ]
            ]);

            $xml = simplexml_load_string($response->getBody(), null);

            if (isset($xml->TotalMatches) && $xml->TotalMatches > 0)
            {
                Log::info('Request Data', request()->all());
                $product = [];
                $productInfo = [
                    "pageNumber" => (int)$xml->PageNumber,
                    "pageSize" => count($xml->item),
                    "totalPage" => (int)$xml->TotalPages,
                    "totalRecords" => (int)$xml->TotalMatches,
                ];
                foreach ($xml->item as $products)
                {
                    $blocked = Product::where('product_id', $products->linkid)->count();
                    if ($blocked)
                    {
                        continue;
                    }
                    if (!in_array((string)$products->mid, $allBrands) && !\Request::is('admin*'))
                    {
                        continue;
                    }

                    // 如果有关联视频带上
                    $hasVideosRes = ProductVideo::where('link_id', $products->linkid)->count();;
                    if ($hasVideosRes)
                    {
                        $hasVideos = true;
                    } else {
                        $hasVideos = false;
                    }
                    array_push($product, [
                        "merchantId" => (string)$products->mid,
                        "merchantName" => (string)$products->merchantname,
                        "linkId" => (string)$products->linkid,
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
                            $products->linkid)->count() > 0 ? true : false,
                        'isBest' => BestOnFabloox::where('linkId', $products->linkid)->count() ? true : false,
                        'hasVideo' => $hasVideos
                    ]);
                }
//                Log::info('Page Number', [(int)$xml->PageNumber]);
//                Log::info('Total Pages', [(int)$xml->TotalPages]);
//                Log::info('Products', $product);
                $this->makeLogsRakuten("Param");
                $this->makeLogsRakuten($param);
                if (!count($product) && ((int)$xml->PageNumber) < (int)$xml->TotalPages)
                {
                    request()->merge(['pagenumber' => ++request()->pagenumber]);
                    $secondCall = true;
                    return $this->getRakutenProducts(request(), $brand, true);
                }

                $data = ['pageInfo' => $productInfo, 'products' => $product];
                $result = $data;
                return $result;

            } else {
                return false;
            }
        } catch (\Exception $e) {
            return false;
        }
    }

    public function YoutubeVideoById($inputs)
    {

        try {
            if (count($inputs) > 0) {
                $urlIds = [];
                foreach ($inputs as $key => $value) {
                    $url = $inputs[$key];
                    parse_str(parse_url($url, PHP_URL_QUERY), $my_array_of_vars);
                    array_push($urlIds, $my_array_of_vars['v']);

                }

//                $param['type'] = 'video';
                $param['part'] = 'snippet';
                $param['key'] = env('GOOGLE_DEV_KEY');
                $param['id'] = implode(",", $urlIds);

                $client = new Client([
                    // Base URI is used with relative requests
                    'base_uri' => 'https://www.googleapis.com',
                    // You can set any number of default request options.
                    'timeout' => 0,
                ]);

                $response = $client->get('/youtube/v3/videos?', [
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
                            "name" => $video['snippet']['title'],
                            "channelId" => $video['snippet']['channelId'],
                            "description" => $video['snippet']['description'],
                            "videoLink" => "https://www.youtube.com/watch?v=" . $video['id'],
                            "image" => $video['snippet']['thumbnails']['high']['url']

                        ]);
                    }
                    return ['status' => 200, "videos" => $videos];

                } else {
                    return ['status' => 204, "videos" => null];
                }


            } else {
                return ['status' => 500, "videos" => null];
            }

        } catch (\Exception $exception) {

        }
    }
}
