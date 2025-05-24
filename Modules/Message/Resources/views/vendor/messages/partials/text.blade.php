<div class="form-group row mb-2">
    <label class="col-xs-2">{{__('message::dashboard.messages.message')}} </label>
    <div class="col-xs-9">
        <textarea name="body" cols="30" rows="10" class="form-control" placeholder="{{__('user::dashboard.channels.message')}}">{{isset($model) && $model?->message_data ? $model?->message_data?->body : ''}}</textarea>
    </div>
</div>
