<?php

namespace App\Http\Requests\Api\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class RegisterUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            'first_name' => ['required', "regex:/^[a-zA-Z\s\.]+$/", 'min:2', 'max:25'],
            'last_name' => ['required', "regex:/^[a-zA-Z\s\.]+$/", 'min:2', 'max:25'],
            'gender' => 'required',
            'username' => ['required', 'unique:users,username'],
            'email' => ['required', 'email', 'max:191', Rule::unique('users')],
            'password' => 'required|min:8|max:16',
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'name req'
        ];
    }

    public function response(array $errors)
    {

        return response()->json($errors,400);

    }
}
