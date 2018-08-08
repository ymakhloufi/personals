<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdRequest extends FormRequest
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
            'title'                => 'required|string',
            'text'                 => 'required|string',
            'author_name'          => 'required|string',
            'author_age'           => 'numeric',
            'author_email'         => 'required|email',
            'image.*'              => 'mimes:jpg,jpeg,png|max:4096',
            'g-recaptcha-response' => 'required|captcha',
        ];
    }
}
