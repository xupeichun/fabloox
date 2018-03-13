<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\Access\Device\Device;
use App\Models\Access\User\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SocialLoginController extends Controller
{
    //

    public function socialLogin(Request $request)
    {
        $validator = validator($request->all(), [
            'fb_id' => 'required',
            'email' => 'sometimes|email',

        ]);
        if ($validator->fails()) {
            return $this->prepareResult(403, null, $validator->errors()->first(), $validator->errors());
        }

        $user = User::where('fb_id', $request->fb_id)->first();

        if (empty($user)) {

            $validator = validator($request->all(), [
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'email',
                'age' => 'integer'
            ]);

            if ($validator->fails()) {
                return $this->prepareResult(403, null,
                    $validator->errors()->first(),
                    $validator->errors());
            }

            if ($request->email) {

                $userByEmail = User::where('email', $request->email)->first();
                if ($userByEmail instanceof User) {
                    $userByEmail->fb_id = $request->fb_id;
                    $userByEmail->update();
                    $loggedInUser = \Auth::loginUsingId($userByEmail->id);

                    $token = $loggedInUser->createToken($request->device_type)->accessToken;


                    $this->userDevices($loggedInUser);

                    return $this->prepareResult(200, ['access_token' => $token, 'user' => \Auth::user()],
                        'User logged in successfully', null);
                }
            }


            $user = User::create($request->all());

            $loggedInUser = \Auth::loginUsingId($user->id);

            $token = $loggedInUser->createToken($request->device_type)->accessToken;

            $this->userDevices($loggedInUser);
            return $this->prepareResult(200, ['access_token' => $token, 'user' => \Auth::user()],
                'User logged in successfully', null);
        } else {

            $user = \Auth::loginUsingId($user->id);
            $token = $user->createToken($request->device_type)->accessToken;
            $this->userDevices($user);
            return $this->prepareResult(200, ['access_token' => $token, 'user' => \Auth::user()],
                'User logged in successfully', null);

        }


    }


    public function userDevices($user)
    {

        $devices = Device::where('device_token', request()->device_token);

        if ($devices->count()) {
            $devices->delete();
        }
        if (request()->device_token && request()->device_type) {
            $user->devices()->create([
                'device_token' => request()->device_token,
                'device_type' => request()->device_type
            ]);
        }


    }


}
