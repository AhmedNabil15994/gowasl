<?php

namespace Modules\Apps\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class ContactUsRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->getMethod()) {
            // handle creates
            case 'post':
            case 'POST':

                return [
                    'name' => 'required|string|min:3',
                    'mobile' => 'required|numeric',
                    // 'mobile' => 'required|numeric|digits_between:8,8',
                    'email' => 'required|email',
                    'message' => 'required|string|min:10',
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
            'name.required' => __('apps::frontend.contact_us_page.validations.username.required'),
            'name.string' => __('apps::frontend.contact_us_page.validations.username.string'),
            'name.min' => __('apps::frontend.contact_us_page.validations.username.min'),
            'mobile.required' => __('apps::frontend.contact_us_page.validations.mobile.required'),
            'mobile.numeric' => __('apps::frontend.contact_us_page.validations.mobile.numeric'),
            'mobile.digits_between' => __('apps::frontend.contact_us_page.validations.mobile.digits_between'),
            'email.required' => __('apps::frontend.contact_us_page.validations.email.required'),
            'email.email' => __('apps::frontend.contact_us_page.validations.email.email'),
            'message.required' => __('apps::frontend.contact_us_page.validations.message.required'),
            'message.string' => __('apps::frontend.contact_us_page.validations.message.string'),
            'message.min' => __('apps::frontend.contact_us_page.validations.message.min'),
        ];

        return $v;

    }
}
