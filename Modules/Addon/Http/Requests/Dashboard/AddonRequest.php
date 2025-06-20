<?php

namespace Modules\Addon\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class AddonRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title.*' => 'required',
            'description.*' => 'required',
            'order' => 'nullable',
            'price.*' => 'required',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:10000',
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
}
