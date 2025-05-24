<div class="form-group row mb-2">
    <label class="col-xs-2">{{__('message::dashboard.messages.mention')}} </label>
    <div class="col-xs-9">
        <input type="tel" name="mention" class="form-control inputTel" value="{{isset($model) && $model?->message_data ? '+'.$model?->message_data?->mention : ''}}" placeholder="{{__('message::dashboard.messages.mention')}}">
    </div>
</div>
