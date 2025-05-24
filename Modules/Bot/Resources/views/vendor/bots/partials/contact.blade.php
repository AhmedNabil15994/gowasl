<div class="reply_msg {{$model && $model->reply_type == 'contact' ? '' : 'hidden'}}" id="item-contact-inputs">
    <div class="form-group row mb-2">
        <label class="col-xs-2">{{__('message::dashboard.messages.name')}} </label>
        <div class="col-xs-9">
            <input type="text" name="reply[name]" class="form-control" value="{{isset($model) && $model?->reply ? $model?->reply?->name : ''}}" placeholder="{{__('message::dashboard.messages.name')}}">
        </div>
    </div>
    <div class="form-group row mb-2">
        <label class="col-xs-2">{{__('message::dashboard.messages.contact_phone')}} </label>
        <div class="col-xs-9">
            <input type="tel" name="reply[contact]" class="form-control inputTel" value="{{isset($model) && $model?->reply?->contact ? $model?->reply?->contact : ''}}" placeholder="{{__('message::dashboard.messages.contact_phone')}}">
        </div>
    </div>
</div>
