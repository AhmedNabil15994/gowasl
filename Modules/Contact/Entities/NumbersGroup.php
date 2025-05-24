<?php

namespace Modules\Contact\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Channel\Entities\Channel;
use Modules\Core\Traits\Dashboard\CrudModel;
use Modules\Core\Traits\HasTranslations;

class NumbersGroup extends Model
{
    use CrudModel,SoftDeletes, HasTranslations;

    protected $fillable = ['status','description', 'title','channel_id'];
    public $translatable = ['description', 'title',];

    public function channel(){
        return $this->hasOne(Channel::class,'id','channel_id');
    }

    public function contacts()
    {
        return $this->belongsToMany(Contact::class, 'numbers_groups_contacts')->withTimestamps();
    }
}
