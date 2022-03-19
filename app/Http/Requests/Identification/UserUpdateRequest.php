<?php

namespace App\Http\Requests\Identification;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
            'standoff_id' => 'numeric|min:1|max:9999999999999',
            'clan' => 'string|min:3|max:16'
        ];
    }

    public function wantsJson()
    {
        return true;
    }
}
