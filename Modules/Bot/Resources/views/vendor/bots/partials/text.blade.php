<div class="reply_msg {{$model && $model->reply_type == 'text' ? '' : 'hidden'}}" id="item-text-inputs">
    <div class="form-group">
        <label for="" class="col-md-2">{{__('bot::dashboard.bots.form.reply')}}</label>
        <div class="col-md-9">
            <textarea name="reply[body]" rows="8" cols="80" class="form-control">{{$model  ? $model?->reply?->body : ''}}</textarea>
            <div class="help-block"></div>
        </div>
    </div>
</div>
