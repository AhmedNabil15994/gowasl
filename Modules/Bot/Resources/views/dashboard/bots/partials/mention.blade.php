<div class="reply_msg {{$model && $model->reply_type == 'mention' ? '' : 'hidden'}}" id="item-mention-inputs">
    <div class="form-group row mb-2">
        <label class="col-xs-2">{{__('message::dashboard.messages.mention')}} </label>
        <div class="col-xs-9">
            <input type="tel" name="reply[mention]" class="form-control inputTel" value="{{isset($model) && $model?->reply?->mention ? $model?->reply?->mention : ''}}" placeholder="{{__('message::dashboard.messages.mention')}}">
        </div>
    </div>
</div>
