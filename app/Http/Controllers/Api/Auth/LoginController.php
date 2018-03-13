<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\Access\Device\Device;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Mockery\Exception;
use GuzzleHttp\Client;

class LoginController extends Controller
{
    public function login(Request $request)
    {


        $validator = validator($request->all(), [
            'username' => 'required',
            'password' => 'required',
//            'device_type' => 'required',
//            'device_token' => 'required'
        ]);


        if ($validator->fails()) {
            $this->errors = $validator->errors();
            return $this->prepareResult(401, null, $validator->errors()->first(), $this->errors);
        }


        try {

            $credentials = [
                'username' => $request->username,
                'password' => $request->password,
                'status' => 1,
            ];


            if (Auth::attempt($credentials)) {

                $user = \Auth::user();


                $devices = Device::where('device_token', $request->device_token);

                if ($devices->count()) {
                    $devices->delete();
                }

                if ($request->device_token && $request->device_type) {
                    $user->devices()->create([
                        'device_token' => $request->device_token,
                        'device_type' => $request->device_type
                    ]);
                }

                $accesstoken = $user->createToken($request->device_type)->accessToken;
                return $this->prepareResult(200, [
                    'access_token' => $accesstoken,
                    'user' => \Auth::user()
                ],
                    trans('api.login.success'), null);

            } else {
                return $this->prepareResult(401, null, trans('api.login.fails'), null);
            }

        } catch (Exception $e) {


        }
    }
}
