<?php

namespace Modules\Bot\Repositories\Dashboard;

use DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\Core\Repositories\Dashboard\CrudRepository;

class BotRepository extends CrudRepository
{

    public function prepareData(array $data, Request $request, $is_create = false): array
    {
        $reply = [];
        foreach($data['reply'] as $key => $item){
            if($item !== null && $item !== '+'){
                $reply[$key] = $item;
            }
        }
        foreach ($reply as $oneReplyKey => $oneReply){
            if(in_array($oneReplyKey,['gif_caption','image_caption','video_caption'])){
                $reply['caption'] = $oneReply;
                unset($reply[$oneReplyKey]);
            }
        }
        $data['reply'] = $reply;
        return $data;
    }
}
