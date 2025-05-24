<?php

namespace Modules\Order\Traits;

use Modules\Addon\Entities\Addon;
use Modules\Cart\Traits\CartTrait;
use Modules\Package\Entities\Package;

trait OrderCalculationTrait
{
    use CartTrait;

    public function calculateTheOrder($request)
    {
        $subtotal = 0.000;
        $total = 0.000;

        $packageObj = Package::find($request->package_id);
        $coupon = null;
        $total = ($request->duration_type == 1 ? $packageObj?->monthly_price : $packageObj?->annual_price )?? 0;

        return [
            'subtotal' => $total,
            'total' => $total,
            'discount'  => isset($coupon['discount_value']) ? floatval($coupon['discount_value']) : 0,
            'coupon' => null,
        ];
    }
}
