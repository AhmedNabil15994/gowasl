<?php

namespace Modules\Channel\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class ButtonsMessageRequest extends FormRequest
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
            'body'            => 'required',
            'footer'            => 'required',
            'hasImage'          => 'required',
            'imageURL'          => 'nullable',
            'buttons.*'         => 'required',
            'buttons.*.id'    =>  'required',
            'buttons.*.title' => 'required'
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
            'body.required'         => "Message Body field is required !!",
            'footer.required'         => "Message Footer field is required !!",
        ];
    }
}
