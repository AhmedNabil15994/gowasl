@if(!isset($disableTypes) || !$disableTypes)
    <div class="form-group row {{isset($parentClass) ? $parentClass : ''}} mb-2">
    <label class="col-xs-2 col-form-label">{{__('message::dashboard.messages.message_type')}} </label>
    <div class="col-xs-9">
        <select name="message_type" {{isset($model) && $model?->message_data?->message_type ? 'disabled' : ''}} class="form-control select2">
            <option value="text" data-target="{{isset($parentClass) ? '.'.$parentClass : ''}} #item-text-inputs" data-action="{{route('api.channels.messages.sendMessage')}}">{{__('message::dashboard.messages.text')}}</option>
            <option value="image" data-target="{{isset($parentClass) ? '.'.$parentClass : ''}} #item-image-inputs" data-action="{{route('api.channels.messages.sendImage')}}">{{__('message::dashboard.messages.image')}}</option>
        </select>
    </div>
</div>
@endif
<div class="clearfix"></div>
<div class="replies">
    <div class="reply_msg" id="item-text-inputs">
        @include('message::dashboard.messages.partials.text')
    </div>
    <div class="reply_msg hidden" id="item-image-inputs">
        @include('message::dashboard.messages.partials.image')
    </div>
</div>
