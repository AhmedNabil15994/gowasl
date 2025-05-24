<?php

namespace Modules\Message\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Modules\Contact\Entities\Contact;
use Modules\Core\Traits\HasTranslations;
use Modules\Core\Traits\ScopesTrait;
use Modules\Channel\Entities\Channel;
use Spatie\SchemalessAttributes\SchemalessAttributesTrait;
use Staudenmeir\EloquentJsonRelations\HasJsonRelationships;

class DecisionMessage extends Model
{
    use SoftDeletes ;
    use ScopesTrait ;
    use SchemalessAttributesTrait;
    use HasJsonRelationships {
        HasJsonRelationships::getAttributeValue as getAttributeValueJson;
    }
    public function getAttributeValue($key)
    {
        return $this->getAttributeValueJson($key);
    }


    protected $fillable = [
        'channel_id',
        'message_data',
        'send_at',
        'whatsapp',
        'queue_data',
        'is_replied',
        'is_sent',
        'job_queue_id',
        'status',
    ];

    protected $schemalessAttributes = [
        'message_data','queue_data'
    ];

    public function channel(){
        return $this->hasOne(Channel::class,'channel_id','channel_id');
    }

    public function job(){
        return $this->hasOne(Job::class,'id','queue_data->job');
    }

    public function message(){
        return $this->belongsTo(Message::class,'queue_data->message_id','message_id');
    }

}
