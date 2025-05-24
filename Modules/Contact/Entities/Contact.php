<?php

namespace Modules\Contact\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\ScopesTrait;
use Modules\Channel\Entities\Channel;

class Contact extends Model
{
    use SoftDeletes ;
    use ScopesTrait ;


    protected $fillable = [
        'channel_id',
        'name',
        'email',
        'mobile',
        'whatsapp',
        'status',
    ];


    public function channel(){
        return $this->hasOne(Channel::class,'id','channel_id');
    }

    public function numbers_groups(){
        return $this->belongsToMany(NumbersGroup::class, 'numbers_groups_contacts')->withTimestamps();
    }

    public function insertMultipleRecords($data)
    {
        return self::insert($data);
    }
}
