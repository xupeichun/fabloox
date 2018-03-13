<?php

namespace App\Http\Requests\Backend\Access\User;

use App\Http\Requests\Request;

/**
 * Class UpdateUserRequest.
 */
class UpdateUserRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return access()->hasRole(1);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email|max:191',
            'first_name'     => ['required', "regex:/^[a-zA-Z\s\.]+$/", 'min:2', 'max:25'],
            'last_name'  => ['required', "regex:/^[a-zA-Z\s\.]+$/", 'min:2', 'max:25'],
            'gender'  => 'required',
            /*'username'  => ['required','unique:users,username'],*/
        ];
    }
}
