<div class="form-group row mb-2">
    <label class="col-xs-2">{{__('message::dashboard.messages.lat')}} </label>
    <div class="col-xs-9">
        <input type="text" name="lat" class="form-control" value="{{isset($model) && $model?->message_data ? $model?->message_data?->lat : ''}}" placeholder="{{__('message::dashboard.messages.lat')}}">
    </div>
</div>
<div class="form-group row mb-2">
    <label class="col-xs-2">{{__('message::dashboard.messages.lng')}} </label>
    <div class="col-xs-9">
        <input type="text" name="lng" class="form-control" value="{{isset($model) && $model?->message_data ? $model?->message_data?->lng : ''}}" placeholder="{{__('message::dashboard.messages.lng')}}">
    </div>
</div>
