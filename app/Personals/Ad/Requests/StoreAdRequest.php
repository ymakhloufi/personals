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
            'title'                 => 'required|string|min:2|max:64',
            'text'                  => 'required|string|min:16|max:8192',
            'author_name'           => 'required|string|max:16',
            'author_age'            => 'number|between:0,99',
            'author_email'          => 'required|email|max:64',
            'author_phone'          => 'string|max:32',
            'author_phonw_whatsapp' => '',
            'author_zip'            => 'max:10',
            'author_town'           => 'string|max:32',
            'author_country'        => 'required|string|in:' . implode(',', array_keys(config('countries.all'))),
            'commercial'            => '',
            'expiry'                => 'required|string|in:"1 week","2 weeks","3 weeks","4 weeks"',
        ];
    }
}
