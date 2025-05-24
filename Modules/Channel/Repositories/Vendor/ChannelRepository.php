<?php

namespace Modules\Channel\Repositories\Vendor;

use Illuminate\Support\Facades\Http;
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

    public function QueryTable($request)
    {
        $query = $this->model->where('id_users',auth()->user()->id)->where(function ($query) use ($request) {
            $query->where($this->model->getKeyName(), 'like', '%' . $request->input('search.value') . '%');
            $this->appendSearch($query, $request);
            foreach ($this->getModelTranslatable() as $key) {
                $query->orWhere($key . '->' . locale(), 'like', '%' . $request->input('search.value') . '%');
            }
        });


        $query = $this->filterDataTable($query, $request);
        return $query;
    }

    public function filterDataTable($query, $request)
    {
        $query=parent::filterDataTable($query, $request);
        return $query;
    }

    public function disconnect($id){
        try {
            $deviceObj = $this->model->userChannel()->find($id);
            if($deviceObj->status != 'connected'){
                return [0,"Account Status isn't equal to connected !!"];
            }

            $this->service->disconnect($id);
            $deviceObj->update(['status'=>'disconnected','image'=>null]);
            return [true,"Disconnected Successfully !!!"];
        }catch (\Exception $e){}
    }

    public function clearInstance($id){
        try {
            $deviceObj = $this->model->userChannel()->find($id);
            if($deviceObj->status != 'connected'){
                return [0,"Account Status isn't equal to connected !!"];
            }

            $this->service->clearInstance($id);

            $deviceObj->update(['status'=>null,'image'=>null]);

            return [true,"Cleared Successfully !!!"];

        }catch (\Exception $e){}
    }

    public function clearInstanceData($id){
        try {
            $deviceObj = $this->model->userChannel()->find($id);
            if($deviceObj->status != 'connected'){
                return [0,"Account Status isn't equal to connected !!"];
            }

            $this->service->clearInstanceData($id);

            $deviceObj->update(['status'=>null,'image'=>null]);

            return [true,"Cleared Successfully !!!"];
        }catch (\Exception $e){}
    }

    public function modelCreated($model, $request, $is_created = true): void
    {
        $result = $this->service->createChannel($model->id);
        if($result?->success){
            $instance = $this->model->generateNewKey($model->id);
            $model->multidevice = 'YES';
            $model->channel_id = $instance['id'];
            $model->channel_token = $instance['token'];
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
