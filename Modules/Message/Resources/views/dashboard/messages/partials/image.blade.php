{!! field()->file('file',__('message::dashboard.messages.image'),(isset($model) && $model?->message_data ? (is_array($model?->message_data?->url) ? $model?->message_data?->url[0] : $model?->message_data?->url) : ''),['accept'=>"image/*",]) !!}
<div class="form-group row mb-2 mt-2">
    <label class="col-xs-2 col-form-label">{{__('message::dashboard.messages.caption')}} </label>
    <div class="col-xs-9">
        @if(isset($parentClass))
            <textarea name="caption" cols="30" rows="10" class="form-control" placeholder="{{__('message::dashboard.messages.caption')}}">{{isset($model) && $model?->message_data ? $model?->message_data?->caption : ''}}</textarea>
        @else
        <input type="text" class="form-control" value="{{isset($model) && $model?->message_data ? $model?->message_data?->caption : ''}}" name="caption" placeholder="{{__('message::dashboard.messages.caption')}}">
        @endif
    </div>
</div>
