<?php

namespace App\Http\Controllers\Api\VigLink;

use App\Models\Access\BestOnFabloox\BestOnFabloox;
use App\Models\Access\Product\Product;
use App\Models\Access\Product\ProductVideo;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\ApiBaseController;
use Mockery\Exception;

use Auth;

class VigLinkApiController extends Controller
{
    public function getProducts(Request $request)
    {
        if ($request->thebrand){
            $product = $this->getVgLinkProduct($request,$request->thebrand);
        }else{
            $product = $this->getVgLinkProduct($request);
        }



        if ($product) {

            return $this->prepareResult(200, $product , 'Records found', null);

        } else {

            return $this->prepareResult(204, null, "No record found");

        }


    }

}
