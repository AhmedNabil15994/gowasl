<?php

namespace Modules\Channel\Entities;
use Illuminate\Database\Eloquent\Model;
use Modules\Bot\Entities\Bot;
use Modules\Contact\Entities\Contact;
use Modules\Contact\Entities\NumbersGroup;
use Modules\Core\Traits\Dashboard\CrudModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Message\Entities\Message;
use Modules\Template\Entities\Template;
use Modules\User\Entities\User;
use Modules\Package\Entities\Package;

class Channel extends Model
{
    use CrudModel{
        __construct as private CrudConstruct;
    }

    use SoftDeletes {
      restore as private restoreB;
    }
    protected $guard_name = 'web';
    protected $table = 'device';
    protected $connection = 'mysql';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'id_users',
        'number',
        'name',
        'image',
        'description',
        'package_id',
        'channel_id',
        'channel_token',
        'multidevice',
        'created_at',
        'updated_at',
        'days',
        'valid_until',
        'status',
        'deleted_at',
        'deleted_by',
    ];

    public function settings(){
        return $this->hasOne(DeviceSetting::class,'sessionId','channel_id');
    }

    public function owner(){
        return $this->hasOne(User::class,'id','id_users');
    }

    public function package(){
        return $this->hasOne(Package::class,'id','package_id');
    }

    public function contacts(){
        return $this->hasMany(Contact::class,'channel_id','id');
    }

    public function numbers_groups(){
        return $this->hasMany(NumbersGroup::class,'channel_id','id');
    }

    public function messages(){
        return $this->hasMany(Message::class,'channel_id','id');
    }

    public function templates(){
        return $this->hasMany(Template::class,'channel_id','id');
    }

    public function bots(){
        return $this->hasMany(Bot::class,'channel_id','id');
    }

    static function getOne($id) {
        return self::find($id);
    }

    static function getOneByChannelId($id) {
        return self::with('settings')->where('channel_id',$id)->first();
    }

    static function getUserDevice($id,$token) {
        return self::where([
            ['channel_id',$id],
            ['channel_token',$token],
        ])->first();
    }

    static function getDaysData($source){
        $days = 0;
        if($source->valid_until != null){
            if($source->valid_until > date('Y-m-d H:i:s')){
                $days = round((strtotime($source->valid_until) - strtotime(date('Y-m-d H:i:s'))) / (60 * 60 * 24));
            }
        }
        $source->days = $days;
        return $source;
    }

    public function generateNewKey($name){
        $dataObj = $this->orderBy('id','DESC')->first();
        if($dataObj == null || $dataObj->id == null ){
            $newKey = 10001;
        }
        $newKey = (int) $dataObj->id + 1;
        $hashedToken = md5($name);

        return [
            'id' =>$newKey ,
            'token' => $hashedToken,
        ];
    }

    public function scopeActiveChannel($query) {
        return $query->where([
            ['valid_until' , '>' , date('Y-m-d')],
        ]);
    }

    public function scopeUserChannel($query) {
        if(auth()->id() != 1){
            return $query->where('id_users' , auth()->id());
        }else{
            return  $query;
        }
    }

    public function scopeConnectedChannel($query) {
        return $query->where('status' , 'connected');
    }

    public function scopeOnChannel($query) {
        return $query->activeChannel()->connectedChannel()->userChannel();
    }

    public function isUserActive($id) {
        return $this->userChannel()->find($id);
    }

    public function DailyUsages() {
        return $this->hasMany(DailyUsage::class,'channel_id','id');
    }

    public function todayUsage() {
        return $this->hasOne(DailyUsage::class,'channel_id','id')->where('date',date('Y-m-d'));
    }

    public function incrementDialyUsage($messagesCount = null) {
        $maxPerDay = $this->package->daily_limit;
        $currentCounter = $this?->todayUsage?->counter;
        if($maxPerDay < ($currentCounter + ($messagesCount ?? 0))){
            return false;
        }

        if($this->todayUsage){
            $this->todayUsage()->update(['counter' => $currentCounter+1]);
        }else{
            $this->DailyUsages()->create(['date'=>date('Y-m-d'),'counter'=>1]);
        }
        return true;
    }
}
