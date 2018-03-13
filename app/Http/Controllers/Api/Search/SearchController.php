<?php

namespace App\Http\Controllers\Api\Search;

use App\Models\Access\Brand\Brand;
use App\Models\Access\Influencer\Influencer;
use App\Models\Search\SearchHistory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DSentker\ImageOrientationFixer\ImageOrientationFixer;
use Illuminate\Support\Facades\Log;

class SearchController extends Controller
{


    public function deleteSingleHistory($id)
    {

        $delete = SearchHistory::where('id', '=', $id)
            ->where('user_id', '=', \Auth::id())
            ->delete();

        if ($delete) {
            return $this->prepareResult(200, null, 'History deleted successfully', null);
        }
        return $this->prepareResult(404, null, 'History Not found', null);

    }


    public function getSearch(Request $request)
    {


        Log::info('Method ==' . __METHOD__, $request->header());

        $searches = SearchHistory::groupBy('name')
            ->orderBy('created_at', 'DESC')
            ->get(['id', 'name', 'created_at']);

        if (count($searches)) {
            return $this->prepareResult(200, ['history' => $searches], 'Results found', null);
        }
        return $this->prepareResult(204, null, 'No user history at the moment.', null);
    }

    public function deleteUserHistory(Request $request)
    {

        Log::info('Method ==' . __METHOD__, $request->header());
        Log::info('Delete user history', $request->all());
        $searches = SearchHistory::orderBy('created_at', 'DESC')
            ->where('user_id', '=', \Auth::id())
            ->delete();


        return $this->prepareResult(200, null, 'History cleared successfully', null);
    }


    public function getUserHistory(Request $request)
    {


        Log::info('Method ==' . __METHOD__, $request->header());
        Log::info('get User History method', $request->all(), $request->headers);

        $searches = null;


        if (\Auth::guard('api')->user()) {


            Log::info('Inside history');


            $searches = SearchHistory::where('user_id', '=', \Auth::guard('api')->user()->id)
                ->groupBy('name')
                ->orderBy('id', 'DESC')
                ->take(10)
                ->get(['id', 'name', 'created_at']);

            if (count($searches)) {
                return $this->prepareResult(200, ['history' => $searches], 'Results found', null);
            } else {

                return $this->prepareResult(204, ['history' => $searches], 'No result found', null);
            }


        }


        return $this->prepareResult(204, null, 'Please login to see your previous history.', null);


    }


    public function index(Request $request)
    {

        Log::info('Method ==' . __METHOD__, $request->header());

        Log::info('Search overall', $request->all());

        if ($request->keyword) {
            $search = new SearchHistory();
            $search->name = $request->keyword;
            if (\Auth::guard('api')->user()) {


                Log::info('sajan mera ', $request->all(), $request->headers);

                $search->user_id = \Auth::guard('api')->user()->id;
                $search->save();

                Log::info('User search saved', $request->all());
            }
        }

        if (strtolower($request->type) == 'product') {

            $product = [];

            $vglinkProducts = $this->getVgLinkProduct($request, null);
            $rakutenProducts = $this->getRakutenProducts($request, null);


//            dd($vglinkProducts['pageInfo']['totalRecords'], $rakutenProducts['pageInfo']['totalRecords']);


            $product = [];

            $products = data_merge($rakutenProducts, $vglinkProducts);
            $data = $products;


            if (isset($vglinkProducts['pageInfo']['totalRecords']) && isset($rakutenProducts['pageInfo']['totalRecords'])) {

                $products['pageInfo']['totalRecords'] = $vglinkProducts['pageInfo']['totalRecords'] + $rakutenProducts['pageInfo']['totalRecords'];
                $products['pageInfo']['totalPage'] = (int)($products['pageInfo']['totalRecords'] / 20);
                $products['pageInfo']['pageNumber'] = !\request()->pagenumber?1:request()->pagenumber;
                $products['pageInfo']['pageSize'] = 20;

            }

            if (isset($products['products'])) {
                $collections = collect($products['products']);

                if (strtolower($request->sorttype) == 'asc') {
                    $data = $collections->sortBy('salePriceCurrency');
                }

                if (strtolower($request->sorttype) == 'dsc') {
                    $data = $collections->sortByDesc('salePriceCurrency');
                }


//                dd(count($products['products']));
                return $this->prepareResult(
                    isset($products['products']) && count($products['products']) ? 200 : 204,
                    [
                        'pageInfo' => isset($products['pageInfo']) && count($products['pageInfo']) ? $products['pageInfo'] : new \ArrayObject(),
                        'products' => isset($products['products']) && count($products['products']) ? $products['products'] : [],
                        'brands' => [],
                        'influencers' => []
                    ],
                    isset($products['products']) && count($products['products']) ? 'Results found' : ' No result found',
                    null);


            } else {

                return $this->prepareResult(
                    204,
                    [
                        'products' => isset($products['products']) && count($products['products']) ? $products['products'] : [],
                        'brands' => [],
                        'influencers' => []
                    ],
                    ' No result found',
                    null);


            }


        }


        if (strtolower($request->type) == 'brand') {

            $brands = $this->getBrands($request);
            return $this->prepareResult(count($brands) ? 200 : 204,
                [
                    'products' => [],
                    'brands' => $brands,
                    'influencers' => []
                ],
                count($brands) ? 'Result found' : 'No result found'
            );
        }


        if (strtolower($request->type) == 'influencer') {
            $influencers = $this->getInfluencers($request);
            return $this->prepareResult(count($influencers) ? 200 : 204,
                [
                    'products' => [],
                    'brands' => [],
                    'influencers' => $influencers
                ],
                count($influencers) ? 'Result found' : 'No result found'
            );
        }


    }


    public function getProducts(Request $request)
    {
        $vglinkProducts = $this->getVgLinkProduct($request);


        $rakutenProducts = $this->getRakutenProducts($request);


        $data = [];

        if (is_array($rakutenProducts) && is_array($vglinkProducts) && count($rakutenProducts) && count($rakutenProducts)) {
            $data = array_merge($vglinkProducts, $rakutenProducts);
        } elseif ($rakutenProducts) {
            $data = $rakutenProducts;
        } elseif ($vglinkProducts) {
            $data = $vglinkProducts;
        }


        return $data;


    }

    public function getBrands(Request $request)
    {

        $brands = Brand::where('status', 1)
            ->orderBy('sort_no', 'ASC')
            ->where('brandName', 'LIKE', '%' . $request->keyword . '%')
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
        return $data;

    }


    public function getInfluencers(Request $request)
    {
        $influencers = Influencer::where('status', 1)
            ->where('influencerName', 'LIKE', '%' . $request->keyword . '%')
            ->get();
        $result = [];
        if (count($influencers)) {
            foreach ($influencers as $influencer) {
                array_push($result, [
                    "id" => $influencer->id,
                    "InfluencerId" => (int)$influencer->id,
                    "name" => $influencer->influencerName,
                    "channelId" => $influencer->channel,
                    "description" => $influencer->description,
                    "videoLink" => "",
                    "image" => env('APP_URL') . '/uploads/influencerimages/' . $influencer->image
                ]);
            }
        }
        return $result;
    }


    //
}
