<?php

namespace App\Traits\VgLink;

use App\Models\Access\BestOnFabloox\BestOnFabloox;
use App\Models\Access\Brand\Brand;
use App\Models\Access\Product\Product;
use App\Models\Access\Product\ProductVideo;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\ApiBaseController;
use Mockery\Exception;


trait VgLinkProductTrait
{


    private function makeLogs($data)
    {
        file_put_contents('/tmp/fabloox/fabloox-vigilinks.log', PHP_EOL . print_r($data, true) . PHP_EOL . Carbon::now(),
            FILE_APPEND);
        chmod('/tmp/fabloox/fabloox-vigilinks.log', 0777);
    }


    public function getVgLinkProduct(Request $request, $brand = null)
    {
        $this->makeLogs('VGLINKS REQUEST');
        $this->makeLogs($request->all());

        //1.取得 vglink平台品牌
        $allBrands = Brand::where('merchant_id', 'REGEXP', '[a-zA-Z]')->pluck('merchant_id')->toArray();

        if ((int)request()->mid > 0)
        {
            return false;
        }

        try
        {
            $slug = str_slug(request()->keyword, ' ');

            $request->merge(['keyword' => $slug]);

            $brandSearch = Brand::where('merchant_id', '=', $slug )->first(['merchant_id']);

            if ($brandSearch)
            {

                $brand =  $brandSearch->merchant_id;
            }

            $param = request()->all();
            $param['country'] = 'us';
            $param['apiKey'] = env('VIGLINK_API_KEY');


            $param['query'] = request()->keyword;


            if ($brandSearch)
            {
                $param['query'] = '';
                $brand =  $brandSearch->merchant_id;
            }

            if ($request->cat)
            {

               unset($param['cat']);
                $param['query'] = request()->cat;
            }


//            $param['itemsPerPage'] = request()->itemsPerPage ? request()->itemsPerPage : 10;
            $param['itemsPerPage'] = request()->max ? request()->max : 10;

            $param['page'] = $request->pagenumber;


            if ($request->has('sorttype'))
            {
                if (strtolower($request->sorttype) == 'asc')
                {
                    $param['sortBy'] = 'price';
                }
                elseif (strtolower($request->sorttype) == 'dsc')
                {
                    $param['sortBy'] = '-price';
                }
            }

            if ($request->mid == '')
            {
                request()->request->remove('mid');
            }
//


            if ($brand == null && !$request->mid)
            {

                $param['brand'] = $allBrands;
            }
            else
            {

                $param['brand'] = $brand;
            }

            if ($request->mid)
            {
                $param['brand'] = $request->mid;
            }

            if ($request->type)
            {
                unset ($param['type']);
            }

            \Log::info('Request After Parse', $param);
//            dd($param);
            $client = new Client([
                'base_uri' => 'https://rest.viglink.com',
                'timeout' => 10,
            ]);
            $response = $client->get('/api/product/search?', [
                'query' => $param,
                'headers' => [
                    'Authorization' => 'd4d72c0156400f0226ef48546148ef3451188ce9'
                ]
            ]);
            $xml = json_decode($response->getBody());
            if ($xml->totalItems > 0)
            {
                $product = [];
                $productInfo = [
                    "pageNumber" => (int)$xml->queryProfile->page,
                    "pageSize" => count($xml->items),
                    "totalPage" => (int)$xml->totalItems,
                    "totalRecords" => (int)$xml->totalItems,
                ];

                foreach ($xml->items as $products)
                {//如果产品本地有，在本地加载
                    $blocked = Product::where('product_id', md5($products->imageUrl))->count();
                    if ($blocked)
                    {
                        continue;
                    }
                    //产品有视频关联视频
                    $hasVideosRes = ProductVideo::where('link_id', md5($products->imageUrl))->count();;
                    if ($hasVideosRes)
                    {
                        $hasVideos = true;
                    }
                    else
                    {
                        $hasVideos = false;
                    }
                    $linkId = md5($products->imageUrl);
                    array_push($product, [
                        "merchantId" => $products->feedMerchantId,
                        "merchantName" => (string)($products->brand ? $products->brand : $products->merchant),
                        "linkId" => $linkId,
                        "createdOn" => null,
                        "sku" => null,
                        "productName" => (string)$products->name,
                        "categoryName" => (string)$products->category,
                        "secondaryCategoryName" => (string)$products->category,
                        "currency" => "$",
                        "priceCurrency" => (string)$products->price,
                        "salePriceCurrency" => (string)$products->price,
                        "shortDescription" => (string)$products->name,
                        "longDescription" => (string)$products->name,
                        "linkUrl" => (string)$products->url,
                        "image" => (string)$products->imageUrl,
                        "isBlocked" => false,
                        "isFavourite" => \Auth::guard('api')->user() && \Auth::guard('api')->user()->favourites()->where('linkId',
                            '=',
                            $linkId)->count() > 0 ? true : false,

                        'isBest' => BestOnFabloox::where('linkId', $linkId)->count() ? true : false,
                        'hasVideo' => $hasVideos
                    ]);
                }


                $data = [];
                $data['products'] = $product;
                $data['pageInfo'] = $productInfo;


                return $data;


            } else {


                return false;

            }
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Something went south',
                'statusCode' => 500
            ]);
        }
    }


}