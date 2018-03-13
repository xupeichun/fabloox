<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\Access\User\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    //


    public function sendEmail(Request $request)
    {

        $validator = validator($request->all(), [
            'email' => 'email|required|exists:users,email'
        ]);

        if ($validator->fails()) {
            return $this->prepareResult(401, null, trans('api.forgot_password.wrong_email'), $validator->errors());
        }

        $user = User::where('email', $request->email)->first();
        $total = \DB::table('password_resets')
            ->where(['user_id' => $user->id])
            ->where('created_at', '<', DB::raw('DATE_SUB(NOW(),INTERVAL 120 MINUTE)'))
            ->count();


        if (!$total) {
            $random = rand(100000, 999999);
            \DB::table('password_resets')
                ->insert([
                    'user_id' => $user->id,
                    'verification_code' => $random,
                    'email' => $request->email,
                    'created_at' => Carbon::now()
                ]);


        }


        $verifycode = \DB::table('password_resets')
            ->where([
                'user_id' => $user->id,
            ])
            ->where('created_at', '<', DB::raw('DATE_SUB(NOW(),INTERVAL 120 MINUTE)'))
            ->first();

        $data = [];

        Mail::send('emails.code-verify', ['user' => $user, 'verifycode' => $verifycode],
            function ($m) use ($user, $verifycode) {
                $m->from('test@sprintart.com', 'Verification Code');
                $m->to($user->email, $user->name)
                    ->subject('Verification code');
            });


        return $this->prepareResult(200, null, 'Verification Code sent is on your email', null);
    }

}
