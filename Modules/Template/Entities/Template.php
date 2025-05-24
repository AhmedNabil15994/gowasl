<?php

namespace Modules\Template\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\HasTranslations;
use Modules\Core\Traits\ScopesTrait;
use Modules\Channel\Entities\Channel;

class Template extends Model
{
    use SoftDeletes ;
    use ScopesTrait ;
    use HasTranslations;

    
    protected $fillable = [
        'channel_id',
        'title',
        'description',
        'order',
        'status',
    ];

    public $translatable  = [ 'title','description' ];

   
    public function channel(){
        return $this->hasOne(Channel::class,'id','channel_id');
    }

}
