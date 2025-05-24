@inject('users','Modules\User\Entities\User')
@inject('packages','Modules\Package\Entities\Package')
{!! field()->text('name',__('user::dashboard.channels.create.form.name'))!!}
{!! field()->text('number',__('user::dashboard.channels.create.form.number'))!!}
<div class="form-group">
    <label for="" class="col-md-2">{{__('user::dashboard.channels.create.form.description')}}</label>
    <div class="col-md-9">
        <textarea name="description" rows="8" cols="80" class="form-control" data-name="description">{{ $model->description }}</textarea>
        <div class="help-block"></div>
    </div>
</div>

@php
$ids = [
    isset($model) && isset($model->id) ? $model->id_users : null
];
@endphp
{!! field()->select('id_users',__('user::dashboard.channels.create.form.owner'),$users->pluck('name','id')->toArray(),$ids)!!}
{!! field()->select('package_id',__('user::dashboard.channels.create.form.package'),$packages->pluck('title','id')->toArray(),$model?->package_id)!!}

{!! field()->number('days',__('user::dashboard.channels.create.form.days'))!!}



