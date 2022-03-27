<?php

namespace App\Http\Requests\Identification;

use Illuminate\Foundation\Http\FormRequest;

class AvatarRequest extends FormRequest
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
            'avatar' => 'required|image|dimensions:min_width=64,min_height=64,ratio=1/1|mimes:jpg,png|max:1024'
        ];
    }

    public function wantsJson()
    {
        return true;
    }
}
