<?php

namespace Modules\Contact\Repositories\Dashboard;

use App\Imports\ContactImport;
use DB;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Contact\Entities\Contact;
use Modules\Core\Repositories\Dashboard\CrudRepository;

class NumbersGroupRepository extends CrudRepository
{

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
