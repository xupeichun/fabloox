<?php

namespace App\Http\Controllers\Api\Auth;

use App\Exceptions\GeneralException;
use App\Http\Requests\Api\Auth\RegisterUserRequest;
use App\Models\Access\User\User;
use App\Repositories\Api\Auth\UserRepositoryApi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Mockery\Exception;


class RegisterController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $user;

    public function __construct(UserRepositoryApi $users)
    {
        $this->user = $users;
    }

    public function register(Request $request)
    {

        $validator = validator($request->all(), [
            'first_name' => 'required',
            'username' => 'required|unique:users,username',
            'last_name' => 'required',
            'password' => 'required|min:8|confirmed',
            'gender' => 'required',
            'email' => 'required|unique:users,email',
            'device_type' => 'required',
            'device_token' => 'required'
        ],
            [
                'email.email' => trans('api.register.wrong_email')
            ]
        );

        if ($validator->fails()) {
            return $this->prepareResult(401, null, $validator->errors()->first(), $validator->errors());
        }

        $user = new User();

        $user->fill($request->only(
            'first_name',
            'last_name',
            'username',
            'password',
            'gender',
            'email'
        ));
        $user->password = bcrypt($request->password);

        if ($user->save()) {
            $token = $user->createToken($request->device_type)->accessToken;
            $user->attachRoles(["2"=>2]);

        }
        $user->devices()->create([
            'device_token' => $request->device_token,
            'device_type' => $request->device_type
        ]);


        $user = \Auth::loginUsingId($user->id);
        $user_email= $user->email;
        Mail::send('emails.welcome', ['firstName' => 	$user->first_name, 'lastName' => $user->last_name], function ($message) use ($user_email)
        {
            $message->subject("Welcome to Fabloox");

            $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));

            $message->to($user_email);

        });

        return $this->prepareResult(200, [
            'access_token' => $token,
            'user' => $user
        ],
            'You have signed up successfully',
            $validator->errors()
        );


    }
}
