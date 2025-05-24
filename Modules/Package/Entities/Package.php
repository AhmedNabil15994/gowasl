<?php

namespace Modules\Package\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\HasTranslations;
use Modules\Core\Traits\ScopesTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Package extends Model implements HasMedia
{
    use SoftDeletes ;
    use ScopesTrait ;
    use InteractsWithMedia;
    use HasTranslations;

    protected $fillable = [
        'title',
        'description',
        'order',
        'addons',
        'daily_limit',
        'monthly_price',
        'annual_price',
        'order',
        'status',
    ];
    public $translatable  = [ 'title','description' ];

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
