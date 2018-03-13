<?php

namespace App\Http\Controllers\api\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    //

    public function update(Request $request)
    {

        $validator = validator($request->all(),
            [
                'first_name' => 'required',
                'last_name' => 'required',
                'gender' => 'required',
                'age' => 'required|min:12|max:90|integer',
                'avatar' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:10240'
            ]
        );

        if ($validator->fails()) {
            $this->errors = $validator->errors();
            return $this->prepareResult(401, null, $validator->errors()->first(), $this->errors);
        }
        $file = $request->file('avatar');
        $user = \Auth::user();
        
        if ($file) {

            $ext = $file->getClientOriginalExtension();
            $ext = strtolower($ext);
            if ($ext == 'jpg' || $ext == 'png' || $ext == 'jpeg') {
                $newFilename = "inf_img_" . time() . "_" . $file->getClientOriginalName();

                $destinationPath = public_path() . '/uploads/users';
                $file->move($destinationPath, $newFilename);
                $picPath = '/uploads/users/' . $newFilename;
                $user->avatar = $picPath;

            } else {

            }
        }

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->age = $request->age;
        $user->gender = $request->gender;
        $user->update();
        return $this->prepareResult(200, ['user' => $user], trans('api.profile.update'), null);

    }

}
