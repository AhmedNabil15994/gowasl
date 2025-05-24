<?php

namespace Modules\Contact\Http\Controllers\Vendor;

use Modules\Contact\Entities\NumbersGroup;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\Dashboard\CrudDashboardController;

class NumbersGroupController extends Controller
{

    use CrudDashboardController{
        CrudDashboardController::__construct as CrudeConstruct;
    }

    public function __construct()
    {
        $this->CrudeConstruct();
        $this->setViewPath('contact::vendor.numbers_groups');
        $this->setModel(NumbersGroup::class);
    }

}
