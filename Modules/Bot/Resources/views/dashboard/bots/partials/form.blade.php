<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/css/intlTelInput.css">
<style>
    .form-horizontal{
        padding: 10px 0;
    }
    .pd-25{
        padding: 25px;
    }
    .mt-2{
        margin-top: 15px !important;
    }
    .mb-2{
        margin-bottom: 15px !important;
    }
    .iti{
        width: 100% !important;
    }
    .select2-container--bootstrap{
        width: 100% !important;
    }
</style>
@inject("channels",'Modules\Channel\Entities\Channel')

{!! field()->select('channel_id', __('bot::dashboard.bots.form.channel') , $channels->pluck('name','id')->toArray()) !!}

<div class="form-group">
    <label for="" class="col-md-2">{{__('bot::dashboard.bots.form.message_type')}}</label>
    <div class="col-md-9">
        <select name="message_type" id="" class="form-control select2">
            <option value="same" {{ $model && $model->message_type == 'same' ? 'selected' : '' }}>{{__('bot::dashboard.bots.form.same')}}</option>
            <option value="part" {{ $model && $model->message_type == 'part' ? 'selected' : '' }}>{{__('bot::dashboard.bots.form.part')}}</option>
        </select>
        <div class="help-block"></div>
    </div>
</div>

{!! field()->text('message', __('bot::dashboard.bots.form.message')) !!}

<div class="form-group">
    <label for="" class="col-md-2">{{__('bot::dashboard.bots.form.reply_type')}}</label>
    <div class="col-md-9">
        <select name="reply_type" class="form-control select2">
            <option value="">Select</option>
            <option value="text" {{ $model && $model->reply_type == 'text' ? 'selected' : '' }} data-target="#item-text-inputs" data-action="{{route('api.channels.messages.sendMessage')}}">{{__('message::dashboard.messages.text')}}</option>
            <option value="image" {{ $model && $model->reply_type == "image" ? 'selected' : '' }} data-target="#item-image-inputs" data-action="{{route('api.channels.messages.sendImage')}}">{{__('message::dashboard.messages.image')}}</option>
            <option value="video" {{ $model && $model->reply_type == "video" ? 'selected' : '' }} data-target="#item-video-inputs" data-action="{{route('api.channels.messages.sendVideo')}}">{{__('message::dashboard.messages.video')}}</option>
            <option value="file" {{ $model && $model->reply_type == "file" ? 'selected' : '' }} data-target="#item-file-inputs" data-action="{{route('api.channels.messages.sendFile')}}">{{__('message::dashboard.messages.file')}}</option>
            <option value="audio" {{ $model && $model->reply_type == "audio" ? 'selected' : '' }} data-target="#item-audio-inputs" data-action="{{route('api.channels.messages.sendAudio')}}">{{__('message::dashboard.messages.audio')}}</option>
            <option value="link" {{ $model && $model->reply_type == "link" ? 'selected' : '' }} data-target="#item-link-inputs" data-action="{{route('api.channels.messages.sendLink')}}">{{__('message::dashboard.messages.link')}}</option>
            <option value="sticker" {{ $model && $model->reply_type == "sticker" ? 'selected' : '' }} data-target="#item-sticker-inputs" data-action="{{route('api.channels.messages.sendSticker')}}">{{__('message::dashboard.messages.sticker')}}</option>
            <option value="gif" {{ $model && $model->reply_type == "gif" ? 'selected' : '' }} data-target="#item-gif-inputs" data-action="{{route('api.channels.messages.sendGif')}}">{{__('message::dashboard.messages.gif')}}</option>
            <option value="contact" {{ $model && $model->reply_type == "contact" ? 'selected' : '' }} data-target="#item-contact-inputs" data-action="{{route('api.channels.messages.sendContact')}}">{{__('message::dashboard.messages.contact')}}</option>
            <option value="location" {{ $model && $model->reply_type == "location" ? 'selected' : '' }} data-target="#item-location-inputs" data-action="{{route('api.channels.messages.sendLocation')}}">{{__('message::dashboard.messages.location')}}</option>
            <option value="mention" {{ $model && $model->reply_type == "mention" ? 'selected' : '' }} data-target="#item-mention-inputs" data-action="{{route('api.channels.messages.sendMention')}}">{{__('message::dashboard.messages.mention')}}</option>
        </select>
        <div class="help-block"></div>
    </div>
</div>

@include('bot::dashboard.bots.partials.variables')

@include('bot::dashboard.bots.partials.text')
@include('bot::dashboard.bots.partials.image')
@include('bot::dashboard.bots.partials.video')
@include('bot::dashboard.bots.partials.file')
@include('bot::dashboard.bots.partials.audio')
@include('bot::dashboard.bots.partials.link')
@include('bot::dashboard.bots.partials.sticker')
@include('bot::dashboard.bots.partials.gif')
@include('bot::dashboard.bots.partials.contact')
@include('bot::dashboard.bots.partials.location')
@include('bot::dashboard.bots.partials.mention')


{!! field()->checkBox('status', __('bot::dashboard.bots.form.status')) !!}

@if ($model->trashed())
{!! field()->checkBox('trash_restore', __('bot::dashboard.bots.form.restore')) !!}
@endif

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/intlTelInput.min.js"></script>
    <script>
        const itiOptions = {
            utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/utils.js",
            preferredCountries: ["kw","ae","bh","sa","om","eg"],
        };

        const input1 = document.querySelector("#item-contact-inputs .inputTel");
        const input2 = document.querySelector("#item-mention-inputs .inputTel");
        const iti1 = intlTelInput(input1,itiOptions)
        const iti2 = intlTelInput(input2,itiOptions)

        $('select[name="reply_type"]').on('change',function (){
            $($(this).children('option:selected').data('target')).siblings('.reply_msg').addClass('hidden');
            $($(this).children('option:selected').data('target')).removeClass('hidden');
            if(['text','image','video','gif','link'].includes($(this).val())){
                $('.variables').show();
            }else{
                $('.variables').hide();
            }
        })

        let file_url = '';
        function uploadFile(element){
            var formData = new FormData();
            formData.append('file', element[0].files[0]);
            formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

            $.ajax({
                url : '{{route('dashboard.messages.uploadFile')}}',
                type : 'POST',
                data : formData,
                processData: false,
                contentType: false,
                success : function(data) {
                    file_url = data.url;
                    $('input[name="reply[url]"]').val(file_url)
                },
                error: function (error){
                    toastr['error'](error.responseJSON.message)
                    $('.send_message').attr('disabled',false);
                }
            });
        }

        $(document).on('change','#item-image-inputs input[name="file"] , #item-video-inputs input[name="file"] , #item-file-inputs input[name="file"] , #item-audio-inputs input[name="file"] , #item-sticker-inputs input[name="file"] , #item-gif-inputs input[name="file"] ',function (){
            uploadFile($(this));
        });

        $('input[name="reply[contact]"]').blur(function (){
            $('input[name="reply[contact]"]').val(iti1.getNumber())
        })

        $('input[name="reply[mention]"]').on('blur',function (e){
            $('input[name="reply[mention]"]').val(iti2.getNumber())
        })
    </script>
@endsection
