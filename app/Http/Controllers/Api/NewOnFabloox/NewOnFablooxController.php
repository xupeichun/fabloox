<?php

namespace App\Http\Controllers\Api\NewOnFabloox;

use App\Models\Access\BestOnFabloox\BestOnFabloox;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NewOnFablooxController extends Controller
{
    //


    public function newOnFabloox(Request $request)
    {


        $bestOnFablooxes = BestOnFabloox::all();

        $bestOnFablooxData = [];

        foreach ($bestOnFablooxes as $besOnFabloox) {
            array_push($bestOnFablooxData, [
                "merchantId" => (int)$besOnFabloox->merchantId,
                "merchantName" => (string)$besOnFabloox->merchant_name,
                "linkId" => (int)$besOnFabloox->linkId,
                "createdOn" => (string)$besOnFabloox->createdOn,
                "sku" => (string)$besOnFabloox->sku,
                "productName" => (string)$besOnFabloox->productName,
                "categoryName" => (string)$besOnFabloox->categoryName,
                "secondaryCategoryName" => (string)$besOnFabloox->secondaryCategoryName,
                "currency" => "$",
                "priceCurrency" => (string)$besOnFabloox->priceCurrency,
                "salePriceCurrency" => (string)$besOnFabloox->salePriceCurrency,
                "shortDescription" => (string)$besOnFabloox->shortDescription,
                "longDescription" => (string)$besOnFabloox->longDescription,
                "linkUrl" => (string)$besOnFabloox->linkUrl,
                "image" => (string)$besOnFabloox->image,
                "isBlocked" => false,
                "isFavourite" => \Auth::guard('api')->user() && \Auth::guard('api')->user()->favourites()->where('linkId',
                    '=',
                    (int)$besOnFabloox->linkid)->count() > 0 ? true : false,
            ]);
        }


        return $this->prepareResult(200, [
            'NewInFabloox' => $bestOnFablooxData,
        ], 'Records found', null);


    }
}
