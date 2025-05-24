<?php

namespace Modules\Message\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\ScopesTrait;
use Modules\Channel\Entities\Channel;

class Message extends Model
{
    use SoftDeletes ;
    use ScopesTrait ;


    protected $fillable = [
        'message_id',
        'channel_id',
        'body',
        'author',
        'fromMe',
        'chatName',
        'pushName',
        'remoteJid',
        'messageType',
        'deviceSentFrom',
        'timeFormatted',
        'time',
        'status',
    ];


    public function channel(){
        return $this->hasOne(Channel::class,'id','channel_id');
    }

    public function decision_message(){
        return $this->hasOne(DecisionMessage::class,'queue_data->message_id','message_id');
    }

    public static function getUserDecisionMessage($sessionId,$chatName)
    {
        return self::whereHas('decision_message',function ($q){
            $q->where([
                ['is_replied',0],
                ['status',1],
                ['is_sent',1]
            ]);
        })->where([
            ['fromMe','true'],
            ['channel_id',$sessionId],
            ['chatName',$chatName],
        ])->orderBy('id','desc')->first();
    }
}
