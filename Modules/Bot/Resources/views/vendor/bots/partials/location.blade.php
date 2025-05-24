<div class="reply_msg {{$model && $model->reply_type == 'location' ? '' : 'hidden'}}" id="item-location-inputs">
    <div class="form-group row mb-2">
        <label class="col-xs-2">{{__('message::dashboard.messages.lat')}} </label>
        <div class="col-xs-9">
            <input type="text" name="reply[lat]" class="form-control" value="{{isset($model) && $model?->reply ? $model?->reply?->lat : ''}}" placeholder="{{__('message::dashboard.messages.lat')}}">
        </div>
    </div>
    <div class="form-group row mb-2">
        <label class="col-xs-2">{{__('message::dashboard.messages.lng')}} </label>
        <div class="col-xs-9">
            <input type="text" name="reply[lng]" class="form-control" value="{{isset($model) && $model?->reply ? $model?->reply?->lng : ''}}" placeholder="{{__('message::dashboard.messages.lng')}}">
        </div>
    </div>
</div>
