<?php

namespace Modules\Channel\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class LocationMessageRequest extends FormRequest
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
            'lat'            => 'required',
            'lng'            => 'required',
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
            'lat.required'         => "Location Latitude field is required !!",
            'lng.required'         => "Location Longitude field is required !!",
        ];
    }
}
