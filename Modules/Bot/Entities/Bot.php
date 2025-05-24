<?php

namespace Modules\Bot\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\HasTranslations;
use Modules\Core\Traits\ScopesTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\SchemalessAttributes\SchemalessAttributesTrait;
use Modules\Channel\Entities\Channel;
use Nicolaslopezj\Searchable\SearchableTrait;

class Bot extends Model implements HasMedia
{
    use SchemalessAttributesTrait;
    use SoftDeletes ;
    use ScopesTrait ;
    use InteractsWithMedia;
    use SearchableTrait;

    protected $searchable = [
        'columns' => [
            'message' => 255,
        ],
    ];
    protected $schemalessAttributes = [
        'reply',
    ];

    protected $fillable = [
        'channel_id',
        'message_type',
        'message',
        'reply_type',
        'reply',
        'order',
        'status',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function channel(){
        return $this->hasOne(Channel::class,'id','channel_id');
    }

    static function findBotMessage($senderMessage,$channel_id){
        if($senderMessage != ''){
            $obj = self::active()->where([
                ['message_type','same'],
                ['message',$senderMessage],
                ['channel_id',$channel_id]
            ])->first();
            if(!$obj){
                return  self::active()->where([
                    ['message_type','part'],
                    ['channel_id',$channel_id]
                ])->search(strtolower($senderMessage), null, true, true)->first();
//                $allBots = self::active()->where([
//                    ['message_type',2],
//                    ['channel_id',$channel_id]
//                ])->search(strtolower($senderMessage))->get();
//                foreach ($allBots as $key => $value) {
//                    if(in_array(strtolower($senderMessage),array_map('trim', explode(',', $value->message)))){
//                        return $value;
//                    }
//                }
            }else{
                return $obj;
            }
        }
    }

}
