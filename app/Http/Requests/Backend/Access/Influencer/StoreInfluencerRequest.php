<?php

namespace App\Http\Requests\Backend\Access\Influencer;

use Illuminate\Foundation\Http\FormRequest;

class StoreInfluencerRequest extends FormRequest
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
            'influencerName' => ['required', 'min:2', 'max:25'],
            'channel' => ['required', 'min:2'],
            'channel_name' => ['string'],
            'description' => ['required', 'min:2'],
            'order' => ['required','numeric'],
            'image' => 'required_if:img_status,==,notExist|image|mimes:jpeg,jpg,png|max:2048',

        ];
    }
}
