<?php

namespace Modules\Channel\Repositories\Api;

use Modules\Core\Repositories\Dashboard\CrudRepository;
use Modules\Channel\Entities\Channel;
use Modules\Channel\Services\WAService;

class ChannelRepository extends CrudRepository
{
    public $service;
    public function __construct()
    {
        parent::__construct(Channel::class);
        $this->service = new WAService();
    }

    public function modelCreated($model, $request, $is_created = true): void
    {
        $result = json_decode(json_encode($this->service->createChannel($model->id)),true);
        if(isset($result['status']) && isset($result['status']['status']) && $result['status']['status']){
            $instanceData = $result['data']['instance'];
            $model->multidevice = 'YES';
            $model->channel_id = $instanceData['id'];
            $model->channel_token = $instanceData['token'];
            $model->valid_until = date('Y-m-d H:i:s',strtotime('+'.$model->days.' days',strtotime(  date('Y-m-d H:i:s')) ));
            $model->save();
        }
    }

    public function modelUpdated($model, $request): void
    {
        if(isset($request['settings']) && !empty($request['settings'])){
            $model->settings()->updateOrCreate(['sessionId'=>$model->channel_id],request()['settings']);
        }
    }
}
