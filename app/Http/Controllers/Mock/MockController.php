<?php

namespace App\Http\Controllers\Mock;

use App\Models\Admin\MockResonse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MockController extends Controller
{
    //

    public function index($url)
    {
        $data = MockResonse::where('url', '=', $url)->first();
        $response = json_decode($data->response);
        return response()->json($response);
    }


}
