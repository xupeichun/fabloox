<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\Access\User\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class ResetPasswordController extends Controller
{
    //
    public function resetPassword(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        $total = \DB::table('password_resets')
            ->where(['user_id' => $user->id, 'verification_code' => $request->code])
            ->where('created_at', '<', DB::raw('DATE_SUB(NOW(),INTERVAL 120 MINUTE)'))
            ->count();

        if ($total) {
            return $this->prepareResult(200, null, 'Code Verified Successfully.', $this->errors);
        }
        return $this->prepareResult(401, null, 'Code is expired or wrong', $this->errors);
    }

    public function changePassword(Request $request)
    {
        $validator = validator($request->all(), [
            'email' => 'email|required|exists:users',
            'password' => 'required|min:8|confirmed',
            'code' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->prepareResult(401, null, $validator->errors()->first(), $this->errors);
        }

        $user = User::where('email', $request->email)->first();
        $total = \DB::table('password_resets')
            ->where(['user_id' => $user->id, 'verification_code' => $request->code])
            ->where('created_at', '<', DB::raw('DATE_SUB(NOW(),INTERVAL 120 MINUTE)'))
            ->count();

        if ($total) {
            \DB::table('password_resets')
                ->where(['user_id' => $user->id, 'verification_code' => $request->code])
                ->where('created_at', '<', DB::raw('DATE_SUB(NOW(),INTERVAL 120 MINUTE)'))
                ->delete();
            $user->password = bcrypt($request->password);
            $user->update();
            return $this->prepareResult(200, ['user' => $user], 'Password updated successfully!', null);
        }

        return $this->prepareResult(401, null, 'Verification code is expired', null);
    }

}
