<?php

namespace Modules\Bot\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class BotRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'channel_id' => 'required',
            'message_type' => 'required',
            'message' => 'required',
            'reply_type' => 'required',

            'reply.body'   => 'required_if:reply_type,==,text',
            'reply.url'   => 'required_if:reply_type,image,video,file,audio,sticker,gif,link',
            'reply.caption' => 'nullable',
            'reply.title' => 'required_if:reply_type,==,link',
            'reply.description' => 'required_if:reply_type,==,link',
            'reply.name' => 'required_if:reply_type,==,contact',
            'reply.contact' => 'required_if:reply_type,==,contact',
//            'reply.organization' => 'required_if:reply_type,==,contact',
            'reply.lat' => 'required_if:reply_type,==,location',
            'reply.lng' => 'required_if:reply_type,==,location',
            'reply.mention' => 'required_if:reply_type,==,mention',
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
