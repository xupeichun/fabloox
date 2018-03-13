<?php
/**
 * Created by PhpStorm.
 * User: salman
 * Date: 9/14/17
 * Time: 1:38 PM
 */

namespace App\Repositories\Backend\Access\Category;


use Auth;
Use DB;
use App\Repositories\BaseRepository;
use App\Models\Access\Category\Category;

class CategoryRepository extends BaseRepository
{
    const MODEL = Category::class;
    protected $categories;

    public function __construct(Category $category)
    {
        $this->categories = $category;

    }

    public function allActive()
    {
        $result = $this->query()->where('status', 1);
        return $result;
    }

    public function allDeactive()
    {
        $result = $this->query()->where('status', 0);


        return $result;
    }

    public function deactiveCat($value)
    {
        $categoryModel = Category::find($value);
        $categoryModel->status = 0;
        $categoryModel->addedBy = Auth::user()->id;

        DB::transaction(function () use ($categoryModel) {
            if ($categoryModel->save()) {
                return true;
            }

            throw new GeneralException(trans('exceptions.backend.access.users.create_error'));
        });
    }

    public function deleteCat($value)
    {
        $categoryModel = Category::find($value);


        DB::transaction(function () use ($categoryModel) {
            if ($categoryModel->delete()) {
                return true;
            }

            throw new GeneralException(trans('exceptions.backend.access.users.create_error'));
        });
    }

    public function activeCat($value)
    {
        $categoryModel = Category::find($value);
        $categoryModel->status = 1;
        $categoryModel->addedBy = Auth::user()->id;

        DB::transaction(function () use ($categoryModel) {
            if ($categoryModel->save()) {
                return true;
            }

            throw new GeneralException(trans('exceptions.backend.access.users.create_error'));
        });
    }

    public function create($input)
    {

        $categoryModel = new Category();
        $categoryModel->categoryName = $input['data']['categoryName'];
        $categoryModel->sort_id = (int)$input['data']['sort_id'];
        $categoryModel->keyword = $input['data']['keyword'];
        $categoryModel->featured = $input['data']['featured'];
        $categoryModel->addedBy = Auth::user()->id;

        $file = $input['file'];

        if (!empty($file)) {

            $ext = $file->getClientOriginalExtension();
            $ext = strtolower($ext);
            if ($ext == 'jpg' || $ext == 'png' || $ext == 'jpeg') {

                $newFilename = "inf_img_" . time() . "_" . str_replace(" ", "-", $file->getClientOriginalName());

                $destinationPath = public_path() . '/uploads/categoryimages';
                $file->move($destinationPath, $newFilename);
                $picPath = '/uploads/categoryimages/' . $newFilename;
                $categoryModel->image = $picPath;

            } else {
                return false;
            }
        }

        DB::transaction(function () use ($categoryModel) {
            if ($categoryModel->save()) {

                return true;
            }

            throw new GeneralException(trans('exceptions.backend.access.users.create_error'));
        });
        return true;
    }

    public function update($input)
    {

        $categoryModel = Category::find($input['data']['id']);
        $categoryModel->categoryName = $input['data']['categoryName'];
        $categoryModel->sort_id = (int)$input['data']['sort_id'];
        $categoryModel->keyword = $input['data']['keyword'];
        $categoryModel->featured = $input['data']['featured'];
        $categoryModel->addedBy = Auth::user()->id;


        $file = $input['file'];

        if (!empty($file)) {
            $ext = $file->getClientOriginalExtension();
            $ext = strtolower($ext);
            if ($ext == 'jpg' || $ext == 'png' || $ext == 'jpeg') {
                $newFilename = "inf_img_" . time() . "_" . str_replace(" ", "-", $file->getClientOriginalName());

                $destinationPath = public_path() . '/uploads/categoryimages';
                $file->move($destinationPath, $newFilename);
                $picPath = '/uploads/categoryimages/' . $newFilename;
                $categoryModel->image = $picPath;

            } else {
                return false;
            }
        }

        DB::transaction(function () use ($categoryModel) {
            if ($categoryModel->save()) {
                return true;
            }

            throw new GeneralException(trans('exceptions.backend.access.users.create_error'));
        });
        return true;

    }

}