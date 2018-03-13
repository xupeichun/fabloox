<?php

namespace App\Http\Requests\Backend\Access\User;

use App\Http\Requests\Request;
use Illuminate\Validation\Rule;

/**
 * Class StoreUserRequest.
 */
class StoreUserRequest extends Request
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
            'first_name'     => ['required', "regex:/^[a-zA-Z\s\.]+$/", 'min:2', 'max:25'],
            'last_name'  => ['required', "regex:/^[a-zA-Z\s\.]+$/", 'min:2', 'max:25'],
            'gender'  => 'required',
            'username'  => ['required','unique:users,username'],
            'email'    => ['required', 'email', 'max:191', Rule::unique('users')],
            'password' => 'required|min:8|max:16|confirmed',
            'image' => 'image|mimes:jpeg,jpg,png|max:2048'
        ];
    }
}
