<?php

namespace Modules\Offer\Repositories\Dashboard;

use Illuminate\Support\Facades\DB;
use Modules\Core\Repositories\Dashboard\CrudRepository;
use Modules\Offer\Entities\Offer;

class OfferRepository extends CrudRepository
{

    public function __construct()
    {
        parent::__construct(Offer::class);
        $this->statusAttribute = ['status','is_published'];
        $this->fileAttribute       = ['main_image' => 'main_image','images'=>'images','video'=>'videos'];
    }

}
