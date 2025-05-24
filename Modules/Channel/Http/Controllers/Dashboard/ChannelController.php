<?php

namespace Modules\Channel\Http\Controllers\Dashboard;

use Illuminate\Routing\Controller;
use Modules\Core\Traits\Dashboard\CrudDashboardController;
use Modules\Channel\Entities\Channel;
use Modules\Channel\Services\WAService;

class ChannelController extends Controller
{
    use CrudDashboardController {
        CrudDashboardController::__construct as private __crudConstruct;
    }

    public function __construct()
    {
        $this->__crudConstruct();
        $this->model=new Channel();
    }

    public function show($id)
    {
        $model = $this->model->userChannel()->find($id);
        if(!$model){
            abort(404);
        }
        return view('channel::dashboard.channels.show', compact('model'));
    }


    public function logout($id){
        $check = $this->model->onChannel()->find($id);
        if($check){
            $this->repository->disconnect($check->id);
        }
        return redirect()->back();
    }

    public function clearData($id){
        $check = $this->model->onChannel()->find($id);
        if($check){
            $this->repository->clearInstance($check->id);
        }
        return redirect()->back();
    }

    public function clearChannel($id){
        $check = $this->model->onChannel()->find($id);
        if($check){
            $this->repository->clearInstanceData($check->id);
        }
        return redirect()->back();
    }

    public function pushSettings($id){
        $check = $this->model->find($id);
        if($check){
            $check->update(request()->all());
            if(isset(request()['settings']) && !empty(request()['settings'])){
                $check->settings()->updateOrCreate(['sessionId'=>$check->channel_id],request()['settings']);
            }
        }
        return redirect()->back();
    }
}
