<?php

namespace App\Http\Controllers\Api\Coupon;

use App\Library\TokenSingletonClass\TokenSingletonClass;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiBaseController;
use Mockery\Exception;
use Carbon\Carbon;

use Auth;

class CouponController extends ApiBaseController
{
    static $time = null;


    public function __construct()
    {
        $time = Carbon::now();
    }

    public function getCoupons(Request $request)
    {
//        var_dump($request);exit;
//            dd($request->all());
//        $myTime= new TokenSingletonClass;
//
//        dd($myTime->getTime());

        $theToken =$this->rakutenRefreshToken();

        try {
            if ($theToken != 'error') {
                $param = $request->all();

                $param['category'] = !$request->cat ? 6 : $request->cat;

                $token = $theToken;
                $client = new Client([
                    // Base URI is used with relative requests
                    'base_uri' => 'https://api.rakutenmarketing.com',
                    // You can set any number of default request options.
                    'timeout' => 10,
                ]);

                $response = $client->get('/coupon/1.0?', [
                    'query' => $param,
                    'headers' => [
                        'Authorization' => 'Bearer ' . $token,
                        'Accept' => 'application/xml',
                    ]
                ]);

                $xml = simplexml_load_string($response->getBody(), null);
                if ($xml->TotalMatches > 0) {
                    $promotion = [];
                    $promotionInfo = [
                        "pageNumber" => (int)$xml->PageNumberRequested,
                        "pageSize" => count($xml->item),
                        "totalPage" => (int)$xml->TotalPages,
                        "totalRecords" => (int)$xml->TotalMatches,
                    ];
                    foreach ($xml->link as $products) {
                        array_push($promotion, [
                            "categories" => $products->categories,
                            "promotiontypes" => $products->promotiontypes,
                            "offerdescription" => (string)$products->offerdescription,
                            "offerstartdate" => (string)$products->offerstartdate,
                            "offerenddate" => (string)$products->offerenddate,
                            "couponcode" => (string)$products->couponcode,
                            "couponrestriction" => (string)$products->couponrestriction,
                            "clickurl" => (string)$products->clickurl,
                            "impressionpixel" => (string)$products->impressionpixel,
                            "advertiserid" => (int)$products->advertiserid,
                            "advertisername" => (string)$products->advertisername,
                            "network" => (string)$products->network,
                        ]);
                    }
                    return $this->prepareResult(200, ["pageInfo" => $promotionInfo, "promotions" => $promotion],
                        "Record found");

                } else {
                    return $this->prepareResult(200, null, "No record found");

                }


            } else {
                return response()->json(['message' => 'Something went south',
                    'statusCode' => 500]);
            }
        } catch (Exception $e) {
            return response()->json(['message' => 'Something went south',
                'statusCode' => 500]);
        }

    }
}
