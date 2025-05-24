<?php

namespace Modules\Message\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Channel\Entities\Channel;
use Modules\Contact\Entities\Contact;
use Modules\Core\Traits\Dashboard\CrudDashboardController;

class MessageController extends Controller
{
    use CrudDashboardController;

    public function uploadFile(Request $request) {
        $fileObj = $request->file->storeAs('/public/messages/images', $request->file->getClientOriginalName());
        return response()->json([
            'uploaded' => 1,
            'url'      => asset(str_replace('public','storage',$fileObj)),
        ]);
    }

    public function getChannelData($id) {
        $channelObj = Channel::find($id);
        return response()->json([
            'success' => true,
            'data'      => [
                'contacts' => $channelObj->contacts ?? [],
                'numbers_groups' => $channelObj->numbers_groups ?? []
            ],
        ]);
    }

    public function getContactDetails(Request $request) {
        $contactObj = Contact::where(['channel_id'=>$request->channel_id,'whatsapp'=>$request->phone,['name','!=',null]])->first();
        return response()->json([
            'success' => true,
            'data'      => [
                'name' => $contactObj?->name ?? '',
                'whatsapp' => $contactObj?->whatsapp ?? '',
            ],
        ]);
    }
}
