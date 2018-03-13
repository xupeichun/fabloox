<?php

namespace App\Http\Controllers\Backend\Access\Product;

use App\Http\Requests\Backend\Access\User\ManageUserRequest;
use App\Models\Access\Gallery\Gallery;
use App\Repositories\Backend\Access\Product\ProductRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * @var RoleRepository
     */
    protected $product;


    public function __construct(ProductRepository $product)
    {
        $this->product = $product;

    }


    public function index(ManageUserRequest $request)
    {
        $gallery = Gallery::where('status', 1)->whereDate('end_date', '>', Carbon::now())->get();

        return view('backend.access.product.index', compact('gallery'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(ManageUserRequest $request)
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request .
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInfluencerRequest $request)
    {

        $this->product->create(
            [
                'data' => $request->only(
                    'influencerName',
                    'channel',
                    'description'
                ),
                'file' => $request->file('image')
            ]);

        return redirect()->route('admin.access.influencer.index')->withFlashSuccess('Influencer created successfuly');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(ManageUserRequest $request, $id)
    {
        $brand = $this->product->find($id);
        return view('backend.access.influencer.editInfluencer', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreInfluencerRequest $request, $id)
    {
        $this->product->update(
            [
                'data' => $request->only(
                    'influencerName',
                    'channel',
                    'description',
                    'id'
                ),
                'file' => $request->file('image')
            ]);

        return redirect()->route('admin.access.influencer.index')->withFlashSuccess('Influencer updated successfuly!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ManageUserRequest $request, $id)
    {
        $this->product->deleteBrand($id);
    }
}
