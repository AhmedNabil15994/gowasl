<?php
namespace Modules\Channel\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\Dashboard\CrudModel;
use Spatie\SchemalessAttributes\SchemalessAttributesTrait;

class DeviceSetting extends Model{
    use SchemalessAttributesTrait;

    protected $schemalessAttributes = [
        'webhooks',
    ];

    protected $table = 'device_setting';
    protected $connection = 'mysql';
    protected $fillable = ['id','sessionId','userId','sendDelay','webhooks','statusNotificationsOn','filesUploadOn','ignoreOldMessages','disableGroupsArchive','disableDialogsArchive','created_at','updated_at'];
}
