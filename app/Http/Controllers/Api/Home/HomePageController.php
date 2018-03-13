<?php

namespace App\Http\Controllers\Api\Home;

use App\Models\Access\BestOnFabloox\BestOnFabloox;
use App\Models\Access\Category\Category;
use App\Models\Access\Gallery\Gallery;
use App\Models\Access\GalleryProduct\GalleryProduct;
use App\Models\Access\HomepageVideo\HomepageVideo;
use App\Models\Access\Influencer\Influencer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomePageController extends Controller
{
    //
    public function getHomePage()
    {


//        try {

        $galleries = GalleryProduct::join('galleries', 'galleries.id', '=', 'gallery_id')
            ->where('galleries.status', '=', 1)
            ->whereDate('galleries.start_date', '<', Carbon::now())
            ->whereDate('galleries.end_date', '>', Carbon::now())
            ->select(['gallery_products.*'])
            ->get();


        $bestOnFabloox = BestOnFabloox::all();

        $categories = Category::where('featured', 1)
            ->where('status', '=', 1)->get();

        $galleryProducts = [];
        foreach ($galleries as $gallery) {
            array_push($galleryProducts, [
                "bannerImage" => asset($gallery->gallery_image),
                "product" => [
                    "merchantId" => (int)$gallery->merchantId,
                    "merchantName" => (string)$gallery->merchant_name,
                    "linkId" => (int)$gallery->linkId,
                    "createdOn" => (string)$gallery->createdOn,
                    "sku" => (string)$gallery->sku,
                    "productName" => (string)$gallery->productName,
                    "categoryName" => (string)$gallery->categoryName,
                    "secondaryCategoryName" => (string)$gallery->secondaryCategoryName,
                    "currency" => "$",
                    "priceCurrency" => (string)$gallery->priceCurrency,
                    "salePriceCurrency" => (string)$gallery->salePriceCurrency,
                    "shortDescription" => (string)$gallery->shortDescription,
                    "longDescription" => (string)$gallery->longDescription,
                    "linkUrl" => (string)$gallery->linkUrl,
                    "image" => (string)asset($gallery->image),
                    "isBlocked" => false,
                    "isFavourite" => \Auth::guard('api')->user() && \Auth::guard('api')->user()->favourites()->where('linkId',
                        '=',
                        (int)$gallery->linkid)->count() > 0 ? true : false,

                    "isBest" => false,
                    "hasVideo" => false
                ]
            ]);

        }


        $dataCategories = [];
        foreach ($categories as $category) {
            array_push($dataCategories, [

                'id' => $category->id,
                'categoryName' => $category->categoryName,
                'image' => asset($category->image),
                'keyword' => $category->keyword
            ]);
        }

        $bestOnFablooxes = BestOnFabloox::all();
//        dd($bestOnFablooxes);
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

        $videos = HomepageVideo::where('status', 1)
            ->get();
        $videosData = [];

        foreach ($videos as $vide) {
            array_push($videosData, [
                "id" => $vide->id,
                "InfluencerId" => (int)$vide->id,
                "name" => $vide->video_name,
                "channelId" => $vide->channel,
                "description" => $vide->video_description,
                "videoLink" => $vide->url,
                "image" => $vide->thumbnail
            ]);

        }

        return $this->prepareResult(200, [
            'banners' => $galleryProducts,
            'categories' => $dataCategories,
            'NewInFabloox' => $bestOnFablooxData,
            'Influencers' => $videosData
        ]);
//        }
////        catch (\Exception $e){
////
////        }
    }
}
