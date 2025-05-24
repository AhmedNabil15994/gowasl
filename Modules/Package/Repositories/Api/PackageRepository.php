<?php

namespace Modules\Package\Repositories\Api;

use DB;
use Carbon\Carbon;
use Modules\Core\Repositories\Dashboard\CrudRepository;
use Modules\Package\Entities\Package;

class PackageRepository
{

    public function __construct(Package $model)
    {
        $this->model = $model;
    }

    public function getAllActive($request,$order = 'id', $sort = 'desc')
    {
        $record = $this->model->active()->orderBy($order, $sort)->get();
        return $record;
    }

    public function findById($id)
    {
        if (method_exists($this->model, 'trashed')) {
            $model = $this->model->withDeleted()->findOrFail($id);
        } else {
            $model = $this->model->findOrFail($id);
        }

        return $model;
    }

}
