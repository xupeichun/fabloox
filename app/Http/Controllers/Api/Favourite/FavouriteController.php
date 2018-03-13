<?php

namespace App\Http\Controllers\Api\Favourite;

use App\Models\Favourite\Favourite;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FavouriteController extends Controller
{
    //


    public function index()
    {
        $favourites = \Auth::user()->favourites;


        if ($favourites->count()) {

            return $this->prepareResult(200, ['favourites' => $favourites], 'Favorites added successfully',
                $this->errors);
        } else {
            return $this->prepareResult(404, null, 'No record found', $this->errors);
        }
    }

    public function store(Request $request)
    {
        \Auth::user()->favourites()->create($request->all());
        $favourites = \Auth::user()->favourites;
        return $this->prepareResult(200, ['favourites' => $favourites], 'Favorites added successfully',
            $this->errors);
    }

    public function destroy($id)
    {

        $delete = \Auth::user()->favourites()->where('linkId','=' ,$id)->delete();
        if ($delete) {

            $favourites = \Auth::user()->favourites;
            return $this->prepareResult(200, ['favourites' => $favourites], 'Product deleted from favorites',
                $this->errors);
        }
        $favourites = \Auth::user()->favourites;
        return $this->prepareResult(404, ['favourites' => $favourites], 'Favorites cannot be deleted', $this->errors);
    }
}
