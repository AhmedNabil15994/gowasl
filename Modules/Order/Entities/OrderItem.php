<?php

namespace Modules\Order\Entities;

use Carbon\Carbon;
use Modules\Addon\Entities\Addon;
use Modules\Offer\Entities\Offer;
use Modules\Package\Entities\Package;
use Modules\User\Entities\User;
use Illuminate\Database\Eloquent\Model;
use Spatie\SchemalessAttributes\SchemalessAttributesTrait;
use Staudenmeir\EloquentJsonRelations\HasJsonRelationships;

class OrderItem extends Model
{
    protected $fillable = [
        'total',
        'package_id',
        'order_id',
        'user_id',
        'expired_date',
        'start_date',
        'duration_type',
        'settings',
    ];

    use SchemalessAttributesTrait;
    use HasJsonRelationships {
        HasJsonRelationships::getAttributeValue as getAttributeValueJson;
    }
    public function getAttributeValue($key)
    {
        return $this->getAttributeValueJson($key);
    }

    protected $schemalessAttributes = [
        'settings',
    ];

    public function package()
    {
        return $this->belongsTo(Package::class)->withTrashed();
    }

    public function addons()
    {
        return $this->belongsToJson(Addon::class,'settings->addons');
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }


    public function scopeNotExpired($q)
    {
        $q->whereNull('expired_date')
            ->orWhere('expired_date', '>=', Carbon::now()->toDateTimeString());
    }

    function scopeSuccessPay($q)
    {
        $q->whereHas(
            'order',
            fn ($q) => $q->whereHas(
                'orderStatus',
                fn ($q) => $q->successPayment()
            )
        );
    }
}
