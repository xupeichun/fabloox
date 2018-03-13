<?php

namespace App\Http\Requests\Backend\Access\Category;

use App\Http\Requests\Request;
use Illuminate\Validation\Rule;

/**
 * Class StoreUserRequest.
 */
class StoreCategoryRequest extends Request
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
            'categoryName'     => ['required', 'min:2', 'max:25'],
            'keyword'     => ['required', 'min:2', 'max:25'],
            'sort_id'     => ['required','numeric','min:1'],
            'featured'     => 'boolean',
            'image' => 'required_if:img_status,==,notExist|image|mimes:jpeg,jpg,png|max:2048',

        ];
    }
}
