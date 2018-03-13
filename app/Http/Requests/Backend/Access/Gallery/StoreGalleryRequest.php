<?php

namespace App\Http\Requests\Backend\Access\Gallery;

use Illuminate\Foundation\Http\FormRequest;

class StoreGalleryRequest extends FormRequest
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
            'image' => 'required_if:img_status,==,notExist|image|mimes:jpeg,jpg,png|max:2048',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ];
    }
}
