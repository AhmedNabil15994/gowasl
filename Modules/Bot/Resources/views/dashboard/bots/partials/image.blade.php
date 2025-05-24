<div class="reply_msg {{$model && $model->reply_type == 'image' ? '' : 'hidden'}}" id="item-image-inputs">
    {!! field()->file('file',__('message::dashboard.messages.image'),(isset($model) && $model?->reply ? $model?->reply?->url : ''),['accept'=>"image/*",]) !!}
    <input type="hidden" name="reply[url]">
    <div class="form-group row mb-2 mt-2">
        <label class="col-xs-2 col-form-label">{{__('message::dashboard.messages.caption')}} </label>
        <div class="col-xs-9">
            <input type="text" class="form-control" value="{{$model  ? $model?->reply?->caption : ''}}" name="reply[image_caption]" placeholder="{{__('message::dashboard.messages.caption')}}">
        </div>
    </div>
</div>
