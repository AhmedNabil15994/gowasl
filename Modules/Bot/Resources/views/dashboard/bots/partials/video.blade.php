<div class="reply_msg {{$model && $model->reply_type == 'video' ? '' : 'hidden'}}" id="item-video-inputs">
    {!! field()->file('file',__('message::dashboard.messages.video'),(isset($model) && $model?->reply ? $model?->reply?->url : ''),['accept'=>"video/*",]) !!}
    <div class="form-group row mb-2 mt-2">
        <label class="col-xs-2 col-form-label">{{__('message::dashboard.messages.caption')}} </label>
        <div class="col-xs-9">
            <input type="text" class="form-control" value="{{isset($model) && $model?->reply ? $model?->reply?->caption : ''}}" name="reply[video_caption]" placeholder="{{__('message::dashboard.messages.caption')}}">
        </div>
    </div>
</div>
