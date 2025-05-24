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

class BulkMessage extends Model
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
        'message_type',
        'message_data',
        'sending_later',
        'sending_date',
        'bulk_flag',
        'bulk_contacts',
        'status',
        'interval',
        'queue_data',

    ];

    protected $schemalessAttributes = [
        'message_data','bulk_contacts','queue_data'
    ];

    public function channel(){
        return $this->hasOne(Channel::class,'id','channel_id');
    }

    public function job(){
        return $this->hasOne(Job::class,'id','queue_data->job');
    }

    public function contacts(){
        return $this->belongsToJson(Contact::class, 'bulk_contacts->contacts');
    }

}
