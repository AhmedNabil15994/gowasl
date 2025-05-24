<?php

namespace Modules\Offer\Http\Controllers\Vendor;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Area\Entities\City;
use Modules\Area\Entities\State;
use Modules\Core\Traits\Dashboard\CrudDashboardController;
use Modules\Core\Traits\DataTable;
use Modules\Coupon\Http\Requests\Dashboard\CouponRequest;
use Modules\Coupon\Repositories\CouponRepository;
use Modules\Coupon\Transformers\Dashboard\CouponResource;
use Modules\User\Entities\User;


class OfferController extends Controller
{
    use CrudDashboardController;

    public function extraData($model): array
    {
        return [
            'model' => $model,
            'sellers' => (new User())->getSellers(auth()->user()->id),
            'cities' => City::active()->get(),
            'states' => State::active()->get(),
        ];
    }
}
