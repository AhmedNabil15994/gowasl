@extends('apps::dashboard.layouts.app')
@section('title', __('message::dashboard.messages.routes.create'))
@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/css/intlTelInput.css">
    <style>
        .form-horizontal{
            padding: 10px 0;
        }
        .pd-25{
            padding: 25px;
        }
        .form-horizontal .form-group{
            margin: 0;
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
        .notes li{
            padding: 2px;
            margin: 5px 0;
        }
        .variables{
            margin: 10px 0 20px 0 !important;
        }
        .select2-container--bootstrap{
            width: 100% !important;
        }
    </style>
@endsection
@section('content')
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <a href="{{ url(route('dashboard.home')) }}">{{ __('apps::dashboard.index.title') }}</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="{{ url(route('dashboard.messages.index')) }}">
                            {{__('message::dashboard.messages.routes.index')}}
                        </a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="#">{{__('message::dashboard.messages.routes.create')}}</a>
                    </li>
                </ul>
            </div>

            <h1 class="page-title"></h1>

            <div class="row">
                <div class="col-md-7">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption font-red-sunglo">
                                <i class="icon-settings font-red-sunglo"></i>
                                <span class="caption-subject bold uppercase">
                                    {{__('user::dashboard.channels.send_whatsapp_msg')}}
                                </span>
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <div class="form-body" style="padding:0">
                                <div class="form-horizontal" style="padding: 20px 0">
                                    @csrf
                                    @inject('channels','Modules\Channel\Entities\Channel')
                                    <div class="form-group row mb-2">
                                        <label class="col-xs-2">{{__('bot::dashboard.bots.form.channel')}} </label>
                                        <div class="col-xs-9">
                                            <select name="channel_id" class="form-control select2">
                                                <option value=""></option>
                                                @foreach($channels->get() as $channel)
                                                <option value="{{$channel->id}}" data-token="{{$channel->channel_token}}" data-owner="{{$channel->owner->identifier}}">{{$channel->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row  mb-2 hidden">
                                        <label class="col-xs-2">{{__('message::dashboard.messages.type')}} </label>
                                        <div class="col-xs-9">
                                            <select name="type" class="form-control select2">
                                                <option value="1" data-target=".single">{{__('message::dashboard.messages.single')}}</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="types single">
                                        <div class="form-group row mb-2 single">
                                            <label class="col-xs-2">{{__('message::dashboard.messages.phone')}} </label>
                                            <div class="col-xs-9">
                                                <input type="tel" class="form-control inputTel">
                                            </div>
                                        </div>
                                    </div>

                                    @include('message::dashboard.messages.partials.message_details')

                                    <div class="form-group col-xs-12 text-right" style="margin-top: 20px;">
                                        <div class="col-9">
                                            <button type="button" class="send_message btn btn-success waves-effect waves-light float-right">
                                                {{__('message::dashboard.messages.send_message')}}
                                            </button>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    @include('message::dashboard.messages.partials.notes')
                </div>
            </div>

        </div>
    </div>
    </div>
@stop

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/intlTelInput.min.js"></script>
    <script>
        const itiOptions = {
            utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/utils.js",
            preferredCountries: ["kw","ae","bh","sa","om","eg"],
        };

        const input = document.querySelector(".inputTel");
        const input1 = document.querySelector("#item-contact-inputs .inputTel");
        const input2 = document.querySelector("#item-mention-inputs .inputTel");
        const iti = intlTelInput(input,itiOptions)
        const iti1 = intlTelInput(input1,itiOptions)
        const iti2 = intlTelInput(input2,itiOptions)

        function dealWithMessageVariables(ajaxData,variables){
            let  varsArray = ['{CUSTOMER_NAME}','{CUSTOMER_PHONE}','{MESSAGE_TIMESTAMPS}'];
            $.each(ajaxData,function (index,item){
                item = item.replace('{CUSTOMER_NAME}',variables['name']);
                item = item.replace('{CUSTOMER_PHONE}',variables['phone']);
                item = item.replace('{MESSAGE_TIMESTAMPS}',variables['time']);
                ajaxData[index] = item;
            })
            return ajaxData;
        }

        $('select[name="type"]').on('change',function (){
            if($(this).val() == 1){
                $('.types.single').removeClass('hidden');
                $('.types.bulk').addClass('hidden');
            }else if($(this).val() == 2){
                $('.types.single').addClass('hidden');
                $('.types.bulk').removeClass('hidden');
            }
            $('.send_message').toggleClass('group');
        })

        $('select[name="message_type"]').on('change',function (){
            $($(this).children('option:selected').data('target')).removeClass('hidden');
            $($(this).children('option:selected').data('target')).siblings('.reply_msg').addClass('hidden');
            if(['text','image','video','gif','link'].includes($(this).val())){
                $('.variables').show();
            }else{
                $('.variables').hide();
            }
        })

        function fireSendingMessage(ajaxData,requestData){
            $.ajax({
                url: requestData[3],
                type: 'POST',
                headers: {
                    'ID' : requestData[0],
                    "TOKEN" : requestData[1],
                    "Accept": "application/json",
                    "Authorization" : "Bearer " + requestData[2],
                },
                data: ajaxData,
                success: function (data){
                    if(data.success){
                        toastr['success'](data.message)
                    }
                    location.reload()
                },
                error: function (error){
                    toastr['error'](error.responseJSON.message)
                    $('.send_message').attr('disabled',false);
                }
            })
        }

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

        function buildMessageData(ajaxData,message_type,body){
            if(message_type == 'text'){ // Text Message
                ajaxData['body'] = body;
            }else if(message_type == 'image'){ // Image Message
                ajaxData['caption'] = $('#item-image-inputs input[name="caption"]').val();
                ajaxData['url'] = file_url;
            }else if(message_type == 'video'){ // Video Message
                ajaxData['caption'] = $('#item-video-inputs input[name="caption"]').val();
                ajaxData['url'] = file_url;
            }else if(message_type == 'file'){ // File Message
                ajaxData['url'] = file_url;
            }else if(message_type == 'audio'){ // Audio Message
                ajaxData['url'] = file_url;
            }else if(message_type == 'link'){ // Link with preview Message
                ajaxData['url'] =  $('#item-link-inputs input[name="url"]').val();
                ajaxData['title'] =  $('#item-link-inputs input[name="title"]').val();
                ajaxData['description'] =  $('#item-link-inputs [name="description"]').val();
            }else if(message_type == 'sticker'){ // Sticker Message
                ajaxData['url'] = file_url;
            }else if(message_type == 'gif'){ // Gif Message
                ajaxData['caption'] = $('#item-gif-inputs input[name="caption"]').val();
                ajaxData['url'] = file_url;
            }else if(message_type == 'contact'){ // Contact Message
                ajaxData['name'] = $('#item-contact-inputs input[name="name"]').val();
                ajaxData['organization'] = $('#item-contact-inputs input[name="name"]').val();
                ajaxData['contact'] = $('#item-contact-inputs input[name="contact"]').val();
            }else if(message_type == 'location'){ // Location Message
                ajaxData['lat'] = $('#item-location-inputs input[name="lat"]').val();
                ajaxData['lng'] = $('#item-location-inputs input[name="lng"]').val();
            }else if(message_type == 'mention'){ // Mention Message
                ajaxData['mention'] = $('#item-mention-inputs input[name="mention"]').val();
            }
            return ajaxData;
        }

        $('.send_message').on('click',function (e){
            $(this).attr('disabled','disabled');
            $('a.tag[data-time="1"]').click();
            let body = $('textarea[name="body"]').val();
            let phone = iti.getNumber().replace('+','');
            let contactData = [];

            let url = $('select[name="message_type"]').children('option:selected').data('action');
            let channel_id = $('select[name="channel_id"]').children('option:selected').val();
            let channel_token = $('select[name="channel_id"]').children('option:selected').data('token');
            let identifier = $('select[name="channel_id"]').children('option:selected').data('owner');

            let message_type = $('select[name="message_type"]').val();
            let ajaxData = {
                '_token' : $('meta[name="csrf-token"]').attr('content'),
                'phone': phone,
            };

            $.ajax({
                url: '{{route('dashboard.messages.getContactDetails')}}',
                type: 'GET',
                data: {
                    '_token' : $('meta[name="csrf-token"]').attr('content'),
                    'phone': phone,
                    'channel_id': channel_id,
                },
                success: function (data){
                    if(data.success){
                        contactData['name'] = data.data.name !== '' ? data.data.name : phone;
                        contactData['phone'] = data.data.whatsapp !== '' ? data.data.whatsapp : phone ;
                        contactData['time'] = "{{\Carbon\Carbon::now()}}";

                        ajaxData = buildMessageData(ajaxData,message_type,body);
                        ajaxData = dealWithMessageVariables(ajaxData,contactData)
                        return fireSendingMessage(ajaxData,[channel_id,channel_token,identifier,url]);
                    }
                },
                error: function (error){
                    toastr['error'](error.responseJSON.message)
                }
            })
        });

    </script>
@endsection
