<?php

namespace Modules\User\Http\Controllers\Api;

use Modules\User\Entities\FirebaseToken;
use Modules\User\Http\Requests\Api\FCMTokenRequest;
use Modules\User\Transformers\Api\FCMTokenResource;
use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\Notification\Traits\SendNotificationTrait;

class FCMTokenController extends ApiController
{
    use SendNotificationTrait;
    public function store(FCMTokenRequest $request)
    {
        $data=$request->all();
        $data['user_id'] = auth('sanctum')->id();
        $data['device_type'] = FirebaseToken::DEVICE_TYPES[$request->device_type];
        
        $firebaseToken=FirebaseToken::updateOrCreate(['firebase_token'=>$data['firebase_token']], $data);
        return $this->response(new FCMTokenResource($firebaseToken));
    }
}
