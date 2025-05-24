{!! field()->file('file',__('message::dashboard.messages.sticker'),(isset($model) && $model?->message_data ? $model?->message_data?->url : ''),['accept'=>"image/*",]) !!}
