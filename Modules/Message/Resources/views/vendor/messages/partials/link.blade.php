<div class="form-group row mb-2">
    <label class="col-xs-2">{{__('message::dashboard.messages.url')}} </label>
    <div class="col-xs-9">
        <input type="text" name="url" class="form-control" value="{{isset($model) && $model?->message_data ? $model?->message_data?->url : ''}}" placeholder="{{__('message::dashboard.messages.url')}}">
    </div>
</div>
<div class="form-group row mb-2">
    <label class="col-xs-2">{{__('message::dashboard.messages.url_title')}} </label>
    <div class="col-xs-9">
        <input type="text" name="title" class="form-control" value="{{isset($model) && $model?->message_data ? $model?->message_data?->title : ''}}" placeholder="{{__('message::dashboard.messages.url_title')}}">
    </div>
</div>

<div class="form-group row mb-2">
    <label class="col-xs-2">{{__('message::dashboard.messages.url_description')}} </label>
    <div class="col-xs-9">
        <textarea name="description" cols="30" rows="10" class="form-control" placeholder="{{__('message::dashboard.messages.url_description')}}">{{isset($model) && $model?->message_data ? $model?->message_data?->description : ''}}</textarea>
    </div>
</div>
