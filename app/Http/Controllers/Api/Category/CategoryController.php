<?php

namespace App\Http\Controllers\Api\Category;

use App\Models\Access\Category\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    //
    public function index()
    {
        $categories = Category::where('status', 1)
            ->orderBy('sort_id', 'ASC')
            ->get();

        if (count($categories)) {

            $data = [];
            foreach ($categories as $category) {
                array_push($data, [

                    'id' => $category->id,
                    'categoryName' => $category->categoryName,
                    'image' => asset($category->image),
                    'keyword' => $category->keyword

                ]);
            }


            return $this->prepareResult(200, ['categories' => $data], 'Categories found successfully', null);

        }

        return $this->prepareResult(204, null, 'No categories found', null);


    }
}
