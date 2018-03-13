<?php
/**
 * Created by PhpStorm.
 * User: salman
 * Date: 9/28/17
 * Time: 12:47 PM
 */

namespace App\Repositories\Api\Auth;

use Auth;
Use DB;
use App\Repositories\BaseRepository;
use App\Models\Access\User\User;

class UserRepositoryApi extends BaseRepository
{
    const MODEL = User::class;
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;


    }



    public function create($input)
    {

        $userModel = new User();
        $userModel->first_name = $input['first_name'];
        $userModel->last_name = $input['last_name'];
        $userModel->gender = $input['gender'];
        $userModel->username = $input['username'];
        $userModel->email = $input['email'];
        $userModel->password = bcrypt($input['password']);
        $userModel->status = 1;
        $userModel->confirmation_code = md5(uniqid(mt_rand(), true));
        $userModel->confirmed = 0;


        DB::transaction(function () use ($userModel) {
            if ($userModel->save()) {

//                $userModel->createToken('android');
                return true;
            }

            throw new GeneralException(trans('exceptions.backend.access.users.create_error'));
        });
    }
}