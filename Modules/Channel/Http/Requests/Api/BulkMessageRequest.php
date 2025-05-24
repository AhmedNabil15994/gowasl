<?php

namespace Modules\Channel\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class BulkMessageRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'interval'            => 'required',
            'phones'            => 'required',
            'messageType'            => 'required',
            'messageData'            => 'required',
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
            'phones.required'           =>  "Receivers Phones field is required !!",
            'interval.required'         => "Message Interval field is required !!",
            'messageType.required'         => "Message Type field is required !!",
            'messageData.required'         => "Message Data field is required !!",
        ];
    }
}
