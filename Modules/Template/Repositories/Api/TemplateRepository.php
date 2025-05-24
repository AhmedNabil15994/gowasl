<?php

namespace Modules\Template\Repositories\Api;

use DB;
use Modules\Package\Entities\Package;
use Modules\Template\Entities\Template;

class TemplateRepository
{

    public function __construct(Template $model)
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
