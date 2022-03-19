<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'username' => 'required|alpha_dash|max:255|unique:users|regex:/(^([a-zA-Z]+)(\d+)?$)/u',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|max:32',
            'c_password' => 'required|same:password',
            'standoff_id' => 'required|numeric|min:1|max:9999999999999',
            //'device.*' => 'required'
        ];
    }

    public function wantsJson(): bool
    {
        return true;
    }
}
