<?php

namespace App\Http\Requests\Backend\Access\Brand;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBrandRequest extends FormRequest
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
            'brandName' => ['required', 'min:2', 'max:25'],
            'merchant_id' => 'required|min:1',
            'sort_no' => ['required','numeric','min:1'],
            'detail' => ['required','string'],
            'logo' => 'required_if:img_status,==,notExist|image|mimes:jpeg,jpg,png|max:2048',
        ];
    }
}
