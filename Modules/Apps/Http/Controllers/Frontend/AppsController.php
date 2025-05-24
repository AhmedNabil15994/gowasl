<?php

namespace Modules\Apps\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Notification;
use Modules\Apps\Http\Requests\Frontend\ContactUsRequest;
use Modules\Apps\Notifications\Frontend\ContactUsNotification;
use Modules\Faq\Entities\Faq;
use Modules\Offer\Repositories\Frontend\OfferRepository;
use Modules\Page\Entities\Page;

class AppsController extends Controller
{
    public function __construct()
    {
    }

    public function index(Request $request)
    {
        return view('apps::Frontend.index');
    }
}
