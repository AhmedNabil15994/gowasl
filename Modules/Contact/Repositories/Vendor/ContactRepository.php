<?php

namespace Modules\Contact\Repositories\Vendor;

use DB;
use Carbon\Carbon;
use Modules\Contact\Entities\Contact;
use Modules\Core\Repositories\Dashboard\CrudRepository;

class ContactRepository extends CrudRepository
{
    public function __construct()
    {
        parent::__construct(Contact::class);
    }

    public function findById($id)
    {
        if (method_exists($this->model, 'trashed')) {
            $model = $this->model->withDeleted()->whereIn('channel_id',auth()->user()->channels()->pluck('id')->toArray())->findOrFail($id);
        } else {
            $model = $this->model->whereIn('channel_id',auth()->user()->channels()->pluck('id')->toArray())->findOrFail($id);
        }
        return $model;
    }

    public function QueryTable($request)
    {
        $query = $this->model;
        if(auth()->user()->can('dashboard_access') || auth()->user()->can('seller_access')){
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

    public function modelCreated($model, $request, $is_created = true): void
    {
        $this->syncNumbersGroups($model,$request);
    }

    public function modelUpdated($model, $request): void
    {
        $this->syncNumbersGroups($model,$request);
    }

    public function syncNumbersGroups($model, $request)
    {
        if($request['numbers_groups']){
            $model->numbers_groups()->sync($request['numbers_groups']);
        }
        return true;
    }
}
