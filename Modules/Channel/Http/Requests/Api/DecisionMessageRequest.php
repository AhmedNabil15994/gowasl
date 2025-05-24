<?php

namespace Modules\Channel\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class DecisionMessageRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'phone'   => 'required',
            'send_at'   => 'required',
            'message_data.message_type'   => 'required',
            'message_data.url'   => 'required_if:message_data.message_type,==,image',
            'message_data.body'   => 'required',
            'message_data.notify_url'   => 'required',
            'message_data.agree'   => 'required',
            'message_data.refuse'   => 'required',

            'message_data.agree.body'   => 'required_if:message_data.agree.message_type,==,text',
            'message_data.agree.url'   => 'required_if:message_data.agree.message_type,image,video,file,audio,sticker,gif,link',
            'message_data.agree.caption' => 'nullable',
            'message_data.agree.title' => 'required_if:message_data.agree.message_type,==,link',
            'message_data.agree.description' => 'required_if:message_data.agree.message_type,==,link',
            'message_data.agree.name' => 'required_if:message_data.agree.message_type,==,contact',
            'message_data.agree.contact' => 'required_if:message_data.agree.message_type,==,contact',
            'message_data.agree.organization' => 'required_if:message_data.agree.message_type,==,contact',
            'message_data.agree.lat' => 'required_if:message_data.agree.message_type,==,location',
            'message_data.agree.lng' => 'required_if:message_data.agree.message_type,==,location',
            'message_data.agree.mention' => 'required_if:message_data.agree.message_type,==,mention',

            'message_data.refuse.body'   => 'nullable',//'required_if:message_data.refuse.message_type,==,text',
            'message_data.refuse.url'   => 'required_if:message_data.refuse.message_type,image,video,file,audio,sticker,gif,link',
            'message_data.refuse.caption' => 'nullable',
            'message_data.refuse.title' => 'required_if:message_data.refuse.message_type,==,link',
            'message_data.refuse.description' => 'required_if:message_data.refuse.message_type,==,link',
            'message_data.refuse.name' => 'required_if:message_data.refuse.message_type,==,contact',
            'message_data.refuse.contact' => 'required_if:message_data.refuse.message_type,==,contact',
            'message_data.refuse.organization' => 'required_if:message_data.refuse.message_type,==,contact',
            'message_data.refuse.lat' => 'required_if:message_data.refuse.message_type,==,location',
            'message_data.refuse.lng' => 'required_if:message_data.refuse.message_type,==,location',
            'message_data.refuse.mention' => 'required_if:message_data.refuse.message_type,==,mention',
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
