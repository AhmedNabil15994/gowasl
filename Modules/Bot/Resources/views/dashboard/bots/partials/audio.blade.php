<div class="reply_msg {{$model && $model->reply_type == 'audio' ? '' : 'hidden'}}" id="item-audio-inputs">
    {!! field()->file('file',__('message::dashboard.messages.audio'),(isset($model) && $model?->reply ? $model?->reply?->url : ''),['accept'=>"audio/*",]) !!}
</div>
