<?php

namespace Modules\User\Entities;

use Illuminate\Support\Carbon;
use Modules\Channel\Entities\Channel;
use Modules\Course\Entities\Course;
use Modules\Course\Entities\Note;
use Modules\Exam\Entities\UserExam;
use Modules\Offer\Entities\Offer;
use Modules\Order\Entities\Address;
use Modules\Order\Entities\NoteOrder;
use Modules\Order\Entities\Order;
use Modules\Package\Entities\Package;
use Modules\Trainer\Entities\Trainer;
use Modules\Trainer\Entities\TrainerProfile;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Support\Facades\Hash;
use Modules\Core\Traits\ScopesTrait;
use Spatie\Permission\Traits\HasRoles;
use Modules\Order\Entities\OrderItem;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\InteractsWithMedia;
use Modules\Core\Traits\Dashboard\CrudModel;
use Modules\DeviceToken\Traits\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Staudenmeir\EloquentJsonRelations\Relations\Postgres\HasOne;

class User extends Authenticatable implements HasMedia
{
    use CrudModel{
        __construct as private CrudConstruct;
    }

    use Notifiable , HasRoles , InteractsWithMedia,HasApiTokens;

    use SoftDeletes {
      restore as private restoreB;
    }
    protected $guard_name = 'web';
    protected $appends = ['image_file'];
    protected $dates = [
      'deleted_at'
    ];

    protected $fillable = [
        'name', 'email', 'password', 'mobile' , 'image','academic_year_id','first_login','gender','birthday'
    ];


    protected $hidden = [
        'password', 'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setLogAttributes(['name', 'email', 'password', 'mobile' , 'image']);

    }

    public function setImageAttribute($value)
    {
        if (!$value) {
            $this->attributes['image'] = '/uploads/users/user.png';
        }
        $this->attributes['image'] = $this->getImageFileAttribute();
    }

    public function getImageFileAttribute()
    {
        return $this->hasMedia('images') ? $this->getFirstMediaUrl('images') : '/uploads/users/user.png';
    }

      public function setPasswordAttribute($value)
    {
        if ($value === null || !is_string($value)) {
            return;
        }
        $this->attributes['password'] = Hash::needsRehash($value) ? Hash::make($value) : $value;
    }

    public function restore()
    {
        $this->restoreB();
    }

    public function getSellers($id=null){
        return $this->whereHas('roles.permissions',function ($q){
            $q->where('name','seller_access');
        })->when($id,function ($q){
            $q->where('id',auth()->id());
        })->orderBy('id','DESC')->get();
    }


    public function address()
    {
        return $this->hasOne(Address::class, 'user_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class,'user_id');
    }
    public function fcmTokens()
    {
        return $this->hasMany(FirebaseToken::class);
    }

    public function offerFavorites()
    {
        return $this->belongsToMany(Offer::class, "favorites", "user_id", "offer_id")
            ->withTimestamps();
    }

    public function getMyOffersAttribute()
    {
        if(auth()->check() && auth()->user()->can('seller_access')){
            return Offer::where('seller_id',auth()->id());
        }else if(auth()->check() && auth()->user()->can('dashboard_access')){
            return Offer::where('id','!=',null);
        }

        return Offer::with(['category'])
            ->where(fn ($q) => $q->whereHas('orders', fn ($q) => $q->UserAccess($this->id)));
    }
    public function channels()
    {
        return $this->hasMany(Channel::class,'id_users','id');
    }

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model){
            $model->identifier = md5($model->phone.$model->email);
        });
    }
}
