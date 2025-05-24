{!! field()->file('file',__('message::dashboard.messages.video'),(isset($model) && $model?->message_data ? $model->message_data->url : ''),['accept'=>"video/*",]) !!}
<div class="form-group row mb-2 mt-2">
    <label class="col-xs-2 col-form-label">{{__('message::dashboard.messages.caption')}} </label>
    <div class="col-xs-9">
        <input type="text" class="form-control" value="{{isset($model) && $model?->message_data ? $model?->message_data?->caption : ''}}" name="caption" placeholder="{{__('message::dashboard.messages.caption')}}">
    </div>
</div>
