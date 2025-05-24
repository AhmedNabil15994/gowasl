<?php

namespace Modules\Contact\Repositories\Dashboard;

use DB;
use Carbon\Carbon;
use Modules\Core\Repositories\Dashboard\CrudRepository;

class ContactRepository extends CrudRepository
{

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
