<?php

namespace Modules\Bot\Http\Controllers\Vendor;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Core\Traits\DataTable;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\Dashboard\CrudDashboardController;

class BotController extends Controller
{

    use CrudDashboardController;

}
