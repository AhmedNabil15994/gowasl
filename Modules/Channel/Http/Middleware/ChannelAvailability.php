<?php

namespace Modules\Channel\Http\Middleware;

use Illuminate\Http\Request;
use Closure;
use Modules\Channel\Entities\Channel;
use Modules\User\Entities\User;

class ChannelAvailability
{
    public function handle(Request $request, Closure $next)
    {
        $deviceObj = Channel::getOneByChannelId(CHANNEL_ID);
        $check = $deviceObj?->incrementDialyUsage(1);
        if(!$check){
            return response()->json($response = [
                'success' => false,
                'message' => __('channel::dashboard.channels.exceed_daily_limit'),
            ], 401);
        }

        return $next($request);
    }
}
