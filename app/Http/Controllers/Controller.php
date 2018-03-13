<?php

namespace App\Http\Controllers;

use App\Traits\VgLink\VgLinkProductTrait;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Traits\Rakuten\RakutenTrait;
use GuzzleHttp\Client;
use Mockery\Exception;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, RakutenTrait,VgLinkProductTrait;



    public $errors;

    public function prepareResult($responseCode = 200, $data = null, $message = null, $errors = null)
    {
        $responseArray = [
            'responseCode' => $responseCode,
            'message' => $message == null ? "" : $message,
            'data' => $data == null ? new \ArrayObject() : $data,
            'errors' => $errors,
        ];

        $param = [];
        $param['request'] = request()->all();
        $param['files'] = request()->file('avatar')?request()->file('avatar')->getClientOriginalName():'No image received';
        $param['response'] = $responseArray;
//        try {
//            $client = new Client([
//                // Base URI is used with relative requests
//                'base_uri' => 'https://script.google.com/a/origamistudios.us/macros/s/AKfycbzEUtB0vl4PxHPDBwEYPECcqQ4rSbBZwKduYcl3efgMSbjLnuk/exec?usp=sharing',
//                // You can set any number of default request options.
//                'timeout' => 0,
//            ]);
//
//            $response = $client->post('', [
//                'form_params' => $param,
//                /*            'headers' => [
//                                'Authorization' => 'Bearer ' . $token,
//                                'Accept' => 'application/json',
//                            ]*/
//            ]);
//        } catch (\Exception $e) {
//
//            \Log::info('google exception'. $e);
//            \Log::info('Data >>>>'. print_r(request()));
//
//        }

        return $responseArray;
    }

}
