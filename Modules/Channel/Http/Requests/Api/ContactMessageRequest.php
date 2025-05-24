<?php

namespace Modules\Channel\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class ContactMessageRequest extends FormRequest
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
            'name'            => 'required',
            'contact'            => 'required',
            'organization'            => 'nullable',
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
            'name.required'         => "Contact Name field is required !!",
            'contact.required'         => "Contact Number field is required !!",
        ];
    }
}
