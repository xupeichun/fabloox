<?php

namespace App\Http\Controllers\Backend\Access\Product;

use App\Http\Requests\Backend\Access\User\ManageUserRequest;
use App\Models\Access\BestOnFabloox\BestOnFabloox;
use App\Models\Access\Gallery\Gallery;
use App\Models\Access\GalleryProduct\GalleryProduct;
use App\Models\Access\Product\ProductVideo;
use App\Repositories\Backend\Access\Product\ProductRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Access\Product\Product;
use Mockery\Exception;
use Yajra\Datatables\Facades\Datatables;
use Validator;

class ProductTableController extends Controller
{

    protected $product;


    public function __construct(ProductRepository $product)
    {
        $this->product = $product;

    }

    public function getIndex(Request $request)
    {
        $gallery = Gallery::where('status', 1)->whereDate('end_date', '>', Carbon::now())->get();

        return view('backend.access.product2.index', compact('gallery'));
    }

    public function deactivateView(ManageUserRequest $request)
    {
        return view('backend.access.product.deactivatedProduct');
    }


    public function deactivateProduct(ManageUserRequest $request)
    {
        $this->product->create(
            [
                'data' => $request->only(
                    'product_id',
                    'name',
                    'image',
                    'category',
                    'merchant_name'
                )
            ]);
        return response()->json(['status' => 200, 'message' => "Product deactivated."]);

    }

    public function allDeactvated(ManageUserRequest $request)
    {
        $cat = $this->product->allDeactive();
        return Datatables::of($cat)
            ->addColumn('image', function ($cat) {
                return '<img width="50" src="' . $cat->image . '"/>';
            })
            ->addColumn('action', function ($cat) {
                return '<button  id="cat-activate-' . $cat->id . '" class="btn btn-xs btn-success activateButton" data-id="' . $cat->id . '"><i class="glyphicon glyphicon-play"></i> Activate</button> ';
            })
            ->rawColumns(['image', 'action'])
            ->make(true);
    }

    public function activateItem(ManageUserRequest $request)
    {

        $this->product->activeItem($request->id);
    }

    public function addVideoLinks(Request $request)
    {


        $result = validator($request->all(), [
            'link_id' => 'required',
            'url.*' => ['required', 'url', "regex:/^(?:https?:\/\/)?(?:www\.)?youtube\.com\/watch\?(?=.*v=((\w|-){11}))(?:\S+)?$/"],
            'url' => 'array|required'
        ]);
        if ($result->fails()) {
            $errors = [];
            if ($result->errors()->has('url.*')) {

                array_push($errors, ["Please enter valid url"]);
            }
            if ($result->errors()->has('link_id')) {
                array_push($errors, ["Product id is Required"]);
            }
            return response()->json(["status" => 401, "data" => $errors]);
        }
        $result = $this->YoutubeVideoById($request->input('url'));

        if ($result['status'] == 200) {
            foreach ($result['videos'] as $key => $value) {
                $linkModel = new ProductVideo();
                $linkModel->link_id = $request->link_id;
                $linkModel->url = $value['videoLink'];
                $linkModel->thumbnail = $value['image'];
                $linkModel->video_name = $value['name'];
                $linkModel->video_description = $value['description'];
                $linkModel->status = 1;
                $linkModel->save();
            }
            return response()->json(["status" => 200, "data" => "Record added successfully!"]);
        } elseif ($result['status'] == 204) {
            return response()->json(["status" => 401, "data" => ['Unable to find videos']]);
        }


    }

    public function editVideoLinks($id)
    {
        try {
            $result = ProductVideo::where('link_id', $id)->get();
            if (!$result->isEmpty()) {
                return view('backend.access.product.editLink', compact('result'));
            } else {
                return redirect()->route('admin.access.product.index');
            }
        } catch (Exception $exception) {
            return redirect()->route('admin.access.product.index');
        }
    }

    public function updateVideoLinks(Request $request)
    {
        try {
            $result = validator($request->all(), [
                'link_id' => 'min:1',
                'url' => 'array|required',
                'url.*' => ['required', 'url', "regex:/^(?:https?:\/\/)?(?:www\.)?youtube\.com\/watch\?(?=.*v=((\w|-){11}))(?:\S+)?$/"],
                'url' => 'array|required',
                'id.*' => 'required|string|min:1',
            ]);
            if ($result->fails()) {

                return redirect()->back()->withErrors($result);
            }


            $result = $this->YoutubeVideoById($request->url);
            if ($result['status'] == 200) {
                if (count($result['videos']) == count($request->url)) {
                    for ($i = 0; $i < count($request->url); $i++) {
                        if ($request->id[$i] != "") {
                            $productVideo = ProductVideo::find($request->id[$i]);
                            $productVideo->url = $result['videos'][$i]['videoLink'];
                            $productVideo->thumbnail = $result['videos'][$i]['image'];
                            $productVideo->video_name = $result['videos'][$i]['name'];
                            $productVideo->video_description = $result['videos'][$i]['description'];
                            $productVideo->save();
                        } else {
                            return redirect()->back()->withFlashDanger('Error updating links');
                        }
                    }
                } else {
                    $videoIds = $result['videos'];
                    return redirect()->back()->withInput()->withFlashDanger('Could not found videos with this link', $videoIds);

                }

            } else {

                return redirect()->back()->withFlashDanger('No video found with these links');
            }

            return redirect()->route('admin.access.product.index')->withFlashSuccess('Video Link updated successfuly!');
        } catch (Exception $exception) {
            return redirect()->route('admin.access.product.index');
        }
    }

    public function deleteVideoLinks(Request $request)
    {

        try {
            if (isset($request->id) && $request->id != "") {
                $result = ProductVideo::find($request->id);
                if (isset($result)) {
                    $result->delete();
                    return response()->json(["status" => 200, "message" => "Link deleted successfully!"]);
                } else {
                    return response()->json(["status" => 401, "message" => "Link deleted successfully!"]);
                }
            }

        } catch (Exception $exception) {
            return redirect()->route('admin.access.product.index');
        }
    }

    public function showBestOnFabloox()
    {
        $result = BestOnFabloox::all();
        return view('backend.access.product.bestOnFabloox', compact('result'));
    }

    public function addBestOnFabloox(Request $request)
    {

        try {
            $bestOnFabloox = new BestOnFabloox();
            $bestOnFabloox->linkId = $request->product_id;
            $bestOnFabloox->productName = $request->name;
            $bestOnFabloox->merchantId = $request->merchantId;
            $bestOnFabloox->sku = $request->sku;
            $bestOnFabloox->categoryName = $request->categoryName;
            $bestOnFabloox->secondaryCategoryName = $request->category;
            $bestOnFabloox->currency = $request->currency;
            $bestOnFabloox->priceCurrency = $request->priceCurrency;
            $bestOnFabloox->salePriceCurrency = $request->salePriceCurrency;
            $bestOnFabloox->shortDescription = $request->shortDescription;
            $bestOnFabloox->longDescription = $request->longDescription;
            $bestOnFabloox->linkUrl = $request->linkUrl;
            $bestOnFabloox->image = $request->image;
            $bestOnFabloox->merchant_name = $request->merchant_name;

            if ($bestOnFabloox->save()) {
                return response()->json(["status" => 200, "data" => "Record added successfully!"]);
            } else {
                return response()->json(["status" => 401, "data" => "something went wrong"]);
            }


        } catch (Exception $exception) {
            return response()->json(["status" => 500, "data" => "something went south"]);
        }
    }

    public function removeBestOnFabloox(Request $request)
    {

        try {
            $bestOnFabloox = BestOnFabloox::where('linkId', $request->id);
            if (isset($bestOnFabloox)) {
                if ($bestOnFabloox->delete()) {
                    return response()->json(["status" => 200, "data" => "Record added successfully!"]);
                } else {
                    return response()->json(["status" => 401, "data" => "something went wrong"]);
                }
            } else {
                return response()->json(["status" => 401, "data" => "something went wrong"]);
            }


        } catch (Exception $exception) {
            return response()->json(["status" => 500, "data" => "something went south"]);
        }
    }

    public function viewGalleryProducts()
    {
        $result=GalleryProduct::all();
        return view('backend.access.product.galleryProductList',compact('result'));
    }

    public function addGalleryProducts(Request $request)
    {

        try {
            $galleryProductOld = GalleryProduct::where('linkId', $request->product_id)->first();
            $galleryImageExist = GalleryProduct::where('gallery_id', $request->imgId)->first();

            if (isset($galleryProductOld) && !isset($galleryImageExist)) {
                $galleryProductOld->gallery_image = $request->imagePath;
                $galleryProductOld->gallery_id = $request->imgId;
                if ($galleryProductOld->save()) {
                    return response()->json(["status" => 200, "data" => "Record Successfully added"]);
                } else {
                    return response()->json(["status" => 401, "data" => "something went wrong"]);
                }
            } else {
                if (!isset($galleryImageExist)) {

                    $galleryProduct = new GalleryProduct();
                    $galleryProduct->gallery_image = $request->imagePath;
                    $galleryProduct->gallery_id = $request->imgId;
                    $galleryProduct->linkId = $request->product_id;
                    $galleryProduct->productName = $request->name;
                    $galleryProduct->merchantId = $request->merchantId;
                    $galleryProduct->sku = $request->sku;
                    $galleryProduct->categoryName = $request->categoryName;
                    $galleryProduct->secondaryCategoryName = $request->category;
                    $galleryProduct->currency = $request->currency;
                    $galleryProduct->priceCurrency = $request->priceCurrency;
                    $galleryProduct->salePriceCurrency = $request->salePriceCurrency;
                    $galleryProduct->shortDescription = $request->shortDescription;
                    $galleryProduct->longDescription = $request->longDescription;
                    $galleryProduct->linkUrl = $request->linkUrl;
                    $galleryProduct->image = $request->image;
                    $galleryProduct->merchant_name = $request->merchant_name;

                    if ($galleryProduct->save()) {

                        return response()->json(["status" => 200, "data" => "Success"]);

                    } else {
                        return response()->json(["status" => 401, "data" => "something went wrong"]);
                    }
                } else {
                    return response()->json(["status" => 401, "data" => "This image is already added to the product."]);

                }
            }

        } catch (Exception $exception) {
            return response()->json(["status" => 500, "data" => "something went south"]);
        }
    }
    public function removeGalleryProducts(Request $request)
    {

        try {
            $galleryProduct = GalleryProduct::where('id', $request->id);
            if (isset($galleryProduct)) {
                if ($galleryProduct->delete()) {
                    return response()->json(["status" => 200, "data" => "Record deleted successfully!"]);
                } else {
                    return response()->json(["status" => 401, "data" => "something went wrong"]);
                }
            } else {
                return response()->json(["status" => 401, "data" => "something went wrong"]);
            }


        } catch (Exception $exception) {
            return response()->json(["status" => 500, "data" => "something went south"]);
        }
    }
}
