<?php

namespace Modules\Message\Repositories\Dashboard;

use DB;
use Carbon\Carbon;
use Modules\Core\Repositories\Dashboard\CrudRepository;

class MessageRepository extends CrudRepository
{
    public function QueryTable($request)
    {
        $query = $this->model;
        if(auth()->user()->can('dashboard_access')){
            if(!auth()->user()->hasRole('super-admin')){
                $query = $query->whereIn('channel_id',auth()->user()->channels()->pluck('id')->toArray());
            }
        }

        return $this->filterDataTable($query, $request);
    }
    public function filterDataTable($query, $request)
    {
        return $query->orderBy('id','desc');
    }
}
