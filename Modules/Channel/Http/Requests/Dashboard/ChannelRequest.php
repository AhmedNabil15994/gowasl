<?php

namespace Modules\Channel\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class ChannelRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->getMethod())
        {
            // handle creates
            case 'post':
            case 'POST':

                return [
                    'name'            => 'required',
                    'package_id'            => 'required',
                    'id_users'            => 'required',
                  'days'          => 'required|numeric',
                ];

            //handle updates
            case 'put':
            case 'PUT':
                return [
                    'name'            => 'required',
                    'package_id'            => 'required',
                    'id_users'            => 'required',
                    'days'          => 'required|numeric',
                  ];

            case 'get':
            case 'GET':
                return [
                    'name'            => 'required',
                    'package_id'            => 'required',
                    'id_users'            => 'required',
                    'days'          => 'required|numeric',
                ];
        }
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

        $v = [
            'name.required'           => __('user::dashboard.channels.validation.name.required'),
            'days.required'         => __('user::dashboard.channels.validation.days.required'),
            'days.numeric'          => __('user::dashboard.channels.validation.days.numeric'),
        ];

        return $v;
    }
}
