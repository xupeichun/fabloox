<?php

namespace App\Http\Controllers\Api\Brand;

use App\Models\Access\Brand\Brand;
use App\Models\Access\Product\Product;
use App\Models\Admin\BrandVideo;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Backend\Access\Brand\BrandRepository;
use Mockery\Exception;

class BrandController extends Controller
{
    protected $brand;

    public function __construct(BrandRepository $brand)
    {
        $this->brand = $brand;
    }

    public function getBrands()
    {
        $brands = Brand::where('status', 1)
            ->orderBy('sort_no', 'ASC')
            ->get();


        $data = [];

        foreach ($brands as $brand) {
            array_push($data, [
                'id' => $brand->id,
                'brandId' => $brand->merchant_id,
                'brandName' => $brand->brandName,
                'detail' => $brand->detail,
                'image' => asset($brand->logo)
            ]);
        }

        if (count($data)) {
            return $this->prepareResult(200, ['brands' => $data], 'Records found', null);
        }

        return $this->prepareResult(204, null, 'No record found', null);
    }


    public function getBrandDetails(Request $request, $id, $max = 10)
    {

        $brand = Brand::where('id', $id)->orWhere('merchant_id', $id)->first();


        if (!count($brand)) {
            return $this->prepareResult(204, null, 'Brand not found', null);
        }


        $vglinkProducts = $this->getVgLinkProduct($request, $brand->merchant_id);
        $rakutenProducts = $this->getRakutenProducts($request, $brand->merchant_id);


        $product = [];


        if (is_array($rakutenProducts) && is_array($rakutenProducts) && $vglinkProducts && $rakutenProducts) {
            $product = array_merge($rakutenProducts,$vglinkProducts );
        } elseif (is_array($rakutenProducts)) {
            $product = $rakutenProducts;
        } elseif (is_array($vglinkProducts)) {
            $product = $vglinkProducts;
        }

        $brandVideos = BrandVideo::where('brand_id', $brand->id)->get();
        $brandVideosData = [];
        foreach ($brandVideos as $brandVideo) {
            array_push($brandVideosData, [
                'InfluencerId' => (int)$brandVideo->id,
                'name' => $brandVideo->name,
                'channelId' => "",
                'videoLink' => $brandVideo->videoLink,
                'description' => $brandVideo->description,
                'image' => $brandVideo->image,
            ]);
        }

        return $this->prepareResult(200, [

            'similarProducts' => isset($product['products']) ? $product['products'] : [],
            'similarVideos' => $brandVideosData

        ], '');
    }


}
