<?php

namespace Modules\Channel\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class LinkMessageRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'phone'            => 'required',
            'description'            => 'required',
            'title'                  => 'required',
            'url'                    => 'required',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [
            'phone.required'           =>  "Receiver Phone field is required !!",
            'title.required'         => "Link Title field is required !!",
            'url.required'         => "Link URL field is required !!",
            'description.required'         => "Link Description field is required !!",
        ];
    }
}
