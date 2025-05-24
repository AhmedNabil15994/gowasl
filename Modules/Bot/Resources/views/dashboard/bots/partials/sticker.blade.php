<div class="reply_msg {{$model && $model->reply_type == 'sticker' ? '' : 'hidden'}}" id="item-sticker-inputs">
    {!! field()->file('file',__('message::dashboard.messages.sticker'),(isset($model) && $model?->reply ? $model?->reply?->url : ''),['accept'=>"image/*",]) !!}
</div>
