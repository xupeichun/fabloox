<?php
/**
 * Created by PhpStorm.
 * User: salman
 * Date: 9/21/17
 * Time: 1:27 PM
 */

namespace App\Repositories\Backend\Access\Product;

use Auth;
Use DB;
use App\Repositories\BaseRepository;
use App\Models\Access\Product\Product;

class ProductRepository extends BaseRepository
{
    const MODEL = Product::class;
    protected $products;

    public function __construct(Product $product)
    {
        $this->products = $product;

    }

    public function allActive()
    {
        $result = $this->query()->where('status', 1);


        return $result;
    }

    public function allDeactive()
    {
        $result = $this->query()->where('status', 0)->get();


        return $result;
    }

    public function deactiveItem($value)
    {
        $productModel = Product::find($value);
        $productModel->status = 0;
        $productModel->addedBy = Auth::user()->id;

        DB::transaction(function () use ($productModel) {
            if ($productModel->save()) {
                return true;
            }

            throw new GeneralException(trans('exceptions.backend.access.users.create_error'));
        });
    }

    public function deleteBrand($value)
    {
        $productModel = Product::find($value);


        DB::transaction(function () use ($productModel) {
            if ($productModel->delete()) {
                return true;
            }

            throw new GeneralException(trans('exceptions.backend.access.users.create_error'));
        });
    }

    public function activeItem($value)
    {
        $productModel = Product::find($value);
//        $productModel->status = 1;

        DB::transaction(function () use ($productModel) {
            if ($productModel->delete()) {
                return true;
            }

            throw new GeneralException(trans('exceptions.backend.access.users.create_error'));
        });
    }

    public function create($input)
    {
//       dd((int)$input['data']['product_id']);
        $productModel = new Product();
        $productModel->product_id = $input['data']['product_id'];
        $productModel->name = $input['data']['name'];
        $productModel->image = $input['data']['image'];
        $productModel->category = $input['data']['category'];
        $productModel->merchant_name = $input['data']['merchant_name'];
        $productModel->status = 0;


        DB::transaction(function () use ($productModel) {
            if ($productModel->save()) {
                return true;
            }

            throw new GeneralException(trans('exceptions.backend.access.users.create_error'));
        });
    }

    public function update($input)
    {

        $productModel = Product::find($input['data']['id']);
        $productModel->influencerName = $input['data']['influencerName'];
        $productModel->channel = $input['data']['channel'];
        $productModel->description = $input['data']['description'];
        $productModel->addedBy = Auth::user()->id;

        $file = $input['file'];

        if (!empty($file)) {
            $ext = $file->getClientOriginalExtension();
            if ($ext == 'jpg' || $ext == 'png' || $ext == 'jpeg') {
                $newFilename = "inf_img_" . time() . "_" . $file->getClientOriginalName();

                $destinationPath = public_path() . '/uploads/influencerimages';
                $file->move($destinationPath, $newFilename);
                $picPath = $newFilename;
                $productModel->image = $picPath;

            } else {

            }
        }
        DB::transaction(function () use ($productModel) {
            if ($productModel->save()) {
                return true;
            }

            throw new GeneralException(trans('exceptions.backend.access.users.create_error'));
        });
    }

}