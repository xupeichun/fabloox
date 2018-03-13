<?php

namespace App\Http\Controllers\Api\Rakuten;

use App\Models\Access\BestOnFabloox\BestOnFabloox;
use App\Models\Access\Product\Product;
use App\Models\Access\Product\ProductVideo;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

use App\Http\Controllers\Api\ApiBaseController;


use Auth;

class RakutenApiController extends ApiBaseController
{
    public function __construct()
    {
        /*parent::__construct();*/

    }

    public function getProducts(Request $request)
    {
        if ($this->rakutenRefreshToken() != 'error') {
            $products = $this->getRakutenProducts($request);

            if ($products) {
                return $this->prepareResult(200, $products,
                    "Record found");
            }
            return $this->prepareResult(200, null,
                "No record found");
        }

    }


}
