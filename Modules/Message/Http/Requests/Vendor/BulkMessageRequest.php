<?php

namespace Modules\Message\Http\Requests\Vendor;

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
            'channel_id' => 'required',
            'message_type' => 'required',

            'body'   => 'required_if:message_type,==,text',
            'url'   => 'required_if:message_type,image,video,file,audio,sticker,gif,link',
            'caption' => 'nullable',
            'title' => 'required_if:message_type,==,link',
            'description' => 'required_if:message_type,==,link',
            'name' => 'required_if:message_type,==,contact',
            'contact' => 'required_if:message_type,==,contact',
            'organization' => 'required_if:message_type,==,contact',
            'lat' => 'required_if:message_type,==,location',
            'lng' => 'required_if:message_type,==,location',
            'mention' => 'required_if:message_type,==,mention',

            'interval'  => 'required',
            'sending_date'  => 'required',
            'sending_later' => 'nullable',
            'bulk_flag' => 'required_if:bulk_flag,numbers_groups,phones,contacts,new_contacts',
            'numbers_groups' => 'required_if:bulk_flag,numbers_groups',
            'new_contacts' => 'required_if:bulk_flag,new_contacts',
            'contacts' => 'required_if:bulk_flag,contacts',
            'excel_contacts' => 'required_if:bulk_flag,excel_contacts',
            'excel_file' => 'required_if:bulk_flag,excel_contacts|file',
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
