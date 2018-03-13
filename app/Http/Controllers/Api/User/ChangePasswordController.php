<?php

namespace App\Http\Controllers\Api\User;

use App\Models\Access\User\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    //
    public function changePassword(Request $request)
    {


        $validator = validator($request->all(), [
            'old_password' => 'required',
            'password' => 'required|confirmed'
        ]);

        if ($validator->fails()) {
            return $this->prepareResult(401, null, $validator->errors()->first(), $validator->errors());
        }


        $user = User::find(access()->id());

        if (Hash::check($request->old_password, $user->password)) {
            $user->password = bcrypt($request->password);
            $user->save();
            return $this->prepareResult(200, ['user' => $user], 'Password updated successfully!', null);
        } else {
            return $this->prepareResult(401, ['user' => $user], 'Old Password does not match', null);
        }


    }

}
