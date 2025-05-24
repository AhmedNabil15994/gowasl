<?php
namespace Modules\Channel\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\Dashboard\CrudModel;
use Spatie\SchemalessAttributes\SchemalessAttributesTrait;

class DailyUsage extends Model{

    protected $table = 'daily_usage';
    protected $connection = 'mysql';
    protected $fillable = ['id','channel_id','date','counter'];
}
