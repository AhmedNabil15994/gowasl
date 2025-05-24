<div class="form-group row {{isset($parentClass) ? $parentClass : ''}} mb-2">
    <label class="col-xs-2 col-form-label">{{__('message::dashboard.messages.message_type')}} </label>
    <div class="col-xs-9">
        <select name="message_type" {{isset($model) && $model?->bulk_flag ? 'disabled' : ''}} class="form-control select2">
            <option value="text" data-target="{{isset($parentClass) ? '.'.$parentClass : ''}} #item-text-inputs" data-action="{{route('api.channels.messages.sendMessage')}}">{{__('message::dashboard.messages.text')}}</option>
            <option value="image" data-target="{{isset($parentClass) ? '.'.$parentClass : ''}} #item-image-inputs" data-action="{{route('api.channels.messages.sendImage')}}">{{__('message::dashboard.messages.image')}}</option>
            <option value="video" data-target="{{isset($parentClass) ? '.'.$parentClass : ''}} #item-video-inputs" data-action="{{route('api.channels.messages.sendVideo')}}">{{__('message::dashboard.messages.video')}}</option>
            <option value="file" data-target="{{isset($parentClass) ? '.'.$parentClass : ''}} #item-file-inputs" data-action="{{route('api.channels.messages.sendFile')}}">{{__('message::dashboard.messages.file')}}</option>
            <option value="audio" data-target="{{isset($parentClass) ? '.'.$parentClass : ''}} #item-audio-inputs" data-action="{{route('api.channels.messages.sendAudio')}}">{{__('message::dashboard.messages.audio')}}</option>
            <option value="link" data-target="{{isset($parentClass) ? '.'.$parentClass : ''}} #item-link-inputs" data-action="{{route('api.channels.messages.sendLink')}}">{{__('message::dashboard.messages.link')}}</option>
            <option value="sticker" data-target="{{isset($parentClass) ? '.'.$parentClass : ''}} #item-sticker-inputs" data-action="{{route('api.channels.messages.sendSticker')}}">{{__('message::dashboard.messages.sticker')}}</option>
            <option value="gif" data-target="{{isset($parentClass) ? '.'.$parentClass : ''}} #item-gif-inputs" data-action="{{route('api.channels.messages.sendGif')}}">{{__('message::dashboard.messages.gif')}}</option>
            <option value="contact" data-target="{{isset($parentClass) ? '.'.$parentClass : ''}} #item-contact-inputs" data-action="{{route('api.channels.messages.sendContact')}}">{{__('message::dashboard.messages.contact')}}</option>
            <option value="location" data-target="{{isset($parentClass) ? '.'.$parentClass : ''}} #item-location-inputs" data-action="{{route('api.channels.messages.sendLocation')}}">{{__('message::dashboard.messages.location')}}</option>
            <option value="mention" data-target="{{isset($parentClass) ? '.'.$parentClass : ''}} #item-mention-inputs" data-action="{{route('api.channels.messages.sendMention')}}">{{__('message::dashboard.messages.mention')}}</option>
        </select>
    </div>
</div>
<div class="clearfix"></div>
<div class="replies">
    @if((! isset($model) || ! $model?->bulk_flag) && !isset($parentClass))
    @include('bot::dashboard.bots.partials.variables')
    @endif
    <div class="reply_msg" id="item-text-inputs">
        @include('message::dashboard.messages.partials.text')
    </div>
    <div class="reply_msg hidden" id="item-image-inputs">
        @include('message::dashboard.messages.partials.image',['parentClass' => $parentClass ?? null])
    </div>
    <div class="reply_msg hidden" id="item-video-inputs">
        @include('message::dashboard.messages.partials.video')
    </div>
    <div class="reply_msg hidden" id="item-file-inputs">
        @include('message::dashboard.messages.partials.file')
    </div>
    <div class="reply_msg hidden" id="item-audio-inputs">
        @include('message::dashboard.messages.partials.audio')
    </div>
    <div class="reply_msg hidden" id="item-link-inputs">
        @include('message::dashboard.messages.partials.link')
    </div>
    <div class="reply_msg hidden" id="item-sticker-inputs">
        @include('message::dashboard.messages.partials.sticker')
    </div>
    <div class="reply_msg hidden" id="item-gif-inputs">
        @include('message::dashboard.messages.partials.gif')
    </div>
    <div class="reply_msg hidden" id="item-contact-inputs">
        @include('message::dashboard.messages.partials.contact')
    </div>
    <div class="reply_msg hidden" id="item-location-inputs">
        @include('message::dashboard.messages.partials.location')
    </div>
    <div class="reply_msg hidden" id="item-mention-inputs">
        @include('message::dashboard.messages.partials.mention')
    </div>
</div>
