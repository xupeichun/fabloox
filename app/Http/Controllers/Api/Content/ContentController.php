<?php

namespace App\Http\Controllers\Api\Content;

use App\Models\Access\User\Content;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContentController extends Controller
{
    //
    public function index(Request $request)
    {


        $data = Content::first();

        if ($data) {

            $data = [
                'about' => $data->info,
                'terms' => $data->terms,
                'privacy' => $data->policy
            ];;

            return $this->prepareResult(200, ['contents' => $data]);


        } else {

            return $this->prepareResult(204, [], 'No content found');
        }
    }
}
