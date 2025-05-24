<div class="form-group row mb-2">
    <label class="col-xs-2">{{__('message::dashboard.messages.name')}} </label>
    <div class="col-xs-9">
        <input type="text" name="name" class="form-control" value="{{isset($model) && $model?->message_data ? $model?->message_data?->name : ''}}" placeholder="{{__('message::dashboard.messages.name')}}">
    </div>
</div>
<div class="form-group row mb-2">
    <label class="col-xs-2">{{__('message::dashboard.messages.contact_phone')}} </label>
    <div class="col-xs-9">
        <input type="tel" name="contact" class="form-control inputTel" value="{{isset($model) && $model?->message_data ? '+'.$model?->message_data?->contact : ''}}" placeholder="{{__('message::dashboard.messages.contact_phone')}}">
    </div>
</div>
