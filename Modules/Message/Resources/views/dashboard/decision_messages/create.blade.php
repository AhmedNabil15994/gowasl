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

            <form id="form" role="form" class="form-horizontal form-row-seperated" method="post" action="{{route('dashboard.decision_messages.store')}}">
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
                                <div class="form-horizontal msg_details" style="padding: 20px 0">
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

                                    <div class="form-group row mb-2">
                                        <label class="col-xs-2">{{__('message::dashboard.messages.form.whatsapp')}} </label>
                                        <div class="col-xs-9">
                                            <input type="tel" name="whatsapp" class="form-control inputTel" value="{{isset($model) && $model?->whatsapp ? '+'.$model?->whatsapp : ''}}" placeholder="{{__('message::dashboard.messages.form.whatsapp')}}">
                                        </div>
                                    </div>

                                    @include('message::dashboard.decision_messages.bulk.message_details',['parentClass'=>'msg_details'])

                                    <div class="form-group col-xs-12 text-right" style="margin-top: 20px;">
                                        <div class="col-9">
                                            <button type="button" class="send_message group btn btn-success waves-effect waves-light float-right">
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
                    <div class="portlet light bordered types bulk">
                        <div class="portlet-title">
                            <div class="caption font-red-sunglo">
                                <i class="icon-settings font-red-sunglo"></i>
                                <span class="caption-subject bold uppercase">
                                    {{__('message::dashboard.decision_message')}}
                                </span>
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <div class="">
                                <div class="agree msg_actions">
                                    <h4 class="caption-subject bold uppercase">{{__('message::dashboard.agree')}} ( 1 )</h4>
                                    @include('message::dashboard.messages.partials.message_details',['parentClass' => 'agree'])
                                </div>
                                <hr>
                                <div class="refuse msg_actions">
                                    <h4 class="caption-subject bold uppercase">{{__('message::dashboard.refuse')}} ( 2 )</h4>
                                    @include('message::dashboard.messages.partials.message_details',['parentClass' => 'refuse'])
                                </div>

                                <div class="form-group row mb-2">
                                    <label class="col-xs-2">{{__('message::dashboard.decision_messages.form.notify_url')}} </label>
                                    <div class="col-xs-9">
                                        <input type="text" name="notify_url" class="form-control" placeholder="{{__('message::dashboard.decision_messages.form.notify_url')}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </form>
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

        const input1 = document.querySelector(".inputTel");
        const iti1 = intlTelInput(input1,itiOptions)

        let file_url=[];
        function uploadFile(element){
            let key = element.parents('.msg_actions').hasClass('agree') ? 'agree' : (element.parents('.msg_details').length ? 'msg_details' : 'refuse');

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
                    file_url[key] = data.url;
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

        $('select[name="channel_id"]').on('change',function (){
            $.ajax({
                url: '{{route('dashboard.messages.getChannelData',":id")}}'.replace(':id',$(this).val()),
                type: 'GET',
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function (data){},
                error: function (error){
                    toastr['error'](error.responseJSON.message)
                }
            })
        });

        function buildMessageData(parentClass,message_type){
            let ajaxData = {};
            ajaxData['message_type'] = message_type;
            if(message_type == 'text'){ // Text Message
                ajaxData['body'] = $(parentClass+' textarea[name="body"]').val();
            }else if(message_type == 'image'){ // Image Message
                ajaxData['caption'] = $(parentClass+' #item-image-inputs input[name="caption"]').val();
                ajaxData['url'] = file_url[parentClass.replace('.','')];
            }else if(message_type == 'video'){ // Video Message
                ajaxData['caption'] = $(parentClass+' #item-video-inputs input[name="caption"]').val();
                ajaxData['url'] = file_url[parentClass.replace('.','')];
            }else if(message_type == 'file'){ // File Message
                ajaxData['url'] = file_url[parentClass.replace('.','')];
            }else if(message_type == 'audio'){ // Audio Message
                ajaxData['url'] = file_url[parentClass.replace('.','')];
            }else if(message_type == 'link'){ // Link with preview Message
                ajaxData['url'] =  $(parentClass+' #item-link-inputs input[name="url"]').val();
                ajaxData['title'] =  $(parentClass+' #item-link-inputs input[name="title"]').val();
                ajaxData['description'] =  $(parentClass+' #item-link-inputs [name="description"]').val();
            }else if(message_type == 'sticker'){ // Sticker Message
                ajaxData['url'] = file_url[parentClass.replace('.','')];
            }else if(message_type == 'gif'){ // Gif Message
                ajaxData['caption'] = $(parentClass+' #item-gif-inputs input[name="caption"]').val();
                ajaxData['url'] = file_url[parentClass.replace('.','')];
            }else if(message_type == 'contact'){ // Contact Message
                ajaxData['name'] = $(parentClass+' #item-contact-inputs input[name="name"]').val();
                ajaxData['organization'] = $(parentClass+' #item-contact-inputs input[name="name"]').val();
                ajaxData['contact'] = $(parentClass+' #item-contact-inputs input[name="contact"]').val();
            }else if(message_type == 'location'){ // Location Message
                ajaxData['lat'] = $(parentClass+' #item-location-inputs input[name="lat"]').val();
                ajaxData['lng'] = $(parentClass+' #item-location-inputs input[name="lng"]').val();
            }else if(message_type == 'mention'){ // Mention Message
                ajaxData['mention'] = $(parentClass+' #item-mention-inputs input[name="mention"]').val();
            }
            return ajaxData;
        }

        $('[name="message_type"]').on('change',function (){
            $($(this).children('option:selected').data('target')).removeClass('hidden');
            $($(this).children('option:selected').data('target')).siblings('.reply_msg').addClass('hidden');
            if(['text','image','video','gif','link'].includes($(this).val())){
                $('.variables').show();
            }else{
                $('.variables').hide();
            }
        })

        $('.send_message').on('click',function (e){
            let element = $(this);
            // element.attr('disabled','disabled');
            let agreeAction = buildMessageData('.agree',$('.agree select[name="message_type"]').val());
            let refuseAction = buildMessageData('.refuse',$('.refuse select[name="message_type"]').val());


            $.ajax({
                url: '{{route('dashboard.decision_messages.store')}}',
                type: 'POST',
                data: {
                    '_token' : $('meta[name="csrf-token"]').attr('content'),
                    'whatsapp': iti1.getNumber().replace('+',''),
                    'channel_id': $('select[name="channel_id"]').children('option:selected').val(),
                    'message_data[message_type]': $('.msg_details [name="message_type"]').children('option:selected').val(),
                    'message_data[body]': $('.msg_details textarea[name="body"]').val() ? $('.msg_details textarea[name="body"]').val() : $('.msg_details textarea[name="caption"]').val(),
                    'message_data[url]': file_url['msg_details'],
                    'message_data[notify_url]': $('input[name="notify_url"]').val(),
                    'message_data[agree]' : agreeAction,
                    'message_data[refuse]' :  refuseAction,
                },
                success : function(data) {
                    element.attr('disabled',false);
                    if(data.success) {
                        toastr['success'](data.message);
                        window.location.href = '{{route('dashboard.decision_messages.show',":id")}}'.replace(":id",data.id);
                    }
                },
                error: function (error){
                    toastr['error'](error.responseJSON.message)
                    element.attr('disabled',false);
                }
            })
        });

    </script>
@endsection
