<div class="reply_msg {{$model && $model->reply_type == 'file' ? '' : 'hidden'}}" id="item-file-inputs">
    {!! field()->file('file',__('message::dashboard.messages.file'),(isset($model) && $model?->reply ? $model?->reply?->url : ''),['accept'=>".xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf",]) !!}
</div>
