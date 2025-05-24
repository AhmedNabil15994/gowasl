<?php

namespace Modules\Channel\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Closure;
use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\Channel\Entities\Channel;
use Modules\User\Entities\User;

class ChannelAuthenticate
{
    public function handle(Request $request, Closure $next)
    {
        if (!isset($_SERVER['HTTP_SESSION'])) {
            if (!isset($_SERVER['HTTP_ID'])) {
                return (new ApiController())->error("Channel ID is invalid");
            }

            if (!isset($_SERVER['HTTP_TOKEN'])) {
                return (new ApiController())->error("Channel Token is invalid");
            }

            $channelId = $_SERVER['HTTP_ID'];
            $channelToken = $_SERVER['HTTP_TOKEN'];

            $checkChannel = Channel::getUserDevice($channelId,$channelToken);
        }else{
            $channelName = $_SERVER['HTTP_SESSION'];
            $checkChannel = Channel::where('channel_id',$channelName)->first();
        }

        if ($checkChannel == null || $checkChannel->id_users != USER_ID) {
            return (new ApiController())->error("Invalid Channel, Please Check Your Credential");
        }

        if ($checkChannel->valid_until < date('Y-m-d H:i:s')) {
            return (new ApiController())->error("Insufficient Channel Days, Please Pay or transfer days from another channel to increase paid until date");
        }

        define('CHANNEL_ID', $checkChannel->channel_id);
        define('CHANNEL_TOKEN', $checkChannel->channel_token);
        define('NAME', $checkChannel->name);

        return $next($request);
    }
}
