<?php

namespace Modules\Contact\Repositories\Vendor;

use App\Imports\ContactImport;
use DB;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Contact\Entities\Contact;
use Modules\Contact\Entities\NumbersGroup;
use Modules\Core\Repositories\Dashboard\CrudRepository;

class NumbersGroupRepository extends CrudRepository
{

    public function __construct()
    {
        parent::__construct(NumbersGroup::class);
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
        $this->dealWithExcel($request,$model);
    }

    public function modelUpdated($model, $request): void
    {
        $this->dealWithExcel($request,$model);
    }

    public function dealWithExcel($request,$model) {
        if($request->hasFile('excel_file')){
            $rows = Excel::toArray(new ContactImport(), $request->file('excel_file'));
            $data = array_filter(array_slice($rows[0], 1, 100) , function ($subArray) {
                return $subArray[0] !== null;
            });

            collect($data)->map(function ($item) use($model){
                $contact = Contact::firstOrCreate([
                    'whatsapp'  => $item[1],
                ],[
                    'name'  => $item[0],
                    'mobile'  => $item[1],
                    'whatsapp'  => $item[1],
                    'channel_id'  => request()->channel_id,
                ]);
                $contact->numbers_groups()->attach($model->id);
                return true;
            });
        }
    }
}
