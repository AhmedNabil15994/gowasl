<?php

namespace Modules\Channel\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Closure;
use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\Channel\Entities\Channel;
use Modules\User\Entities\User;

class ChannelOwnerAuthenticate
{
    public function handle(Request $request, Closure $next)
    {
        $userObj=null;

        // for updating channel status based on qr updates
        if($request->segment(3) == 'instances' && $request->segment(4) == 'status'){
            if(isset($_SERVER['HTTP_SESSION'])){
                $channelObj = Channel::where('channel_id',$_SERVER['HTTP_SESSION'])->first();
                if($channelObj){
                    $userObj = User::find($channelObj->id_users);
                }
            }
        }

        if(!$userObj){
            if(!isset($_SERVER['HTTP_AUTHORIZATION'])){
                return (new ApiController())->error("Authorization Key is required");
            }
            $identifier = str_replace('Bearer ', '', $_SERVER['HTTP_AUTHORIZATION']);
            $userObj = User::whereIdentifier($identifier)->first();
        }

        if (!$userObj) {
            return (new ApiController())->error("Authorization Key is invalid");
        }

        define('USER_ID',$userObj->id);
        define('IDENTIFIER',$userObj->identifier);

        return $next($request);
    }
}
