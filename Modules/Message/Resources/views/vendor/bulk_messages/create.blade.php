@extends('apps::vendor.layouts.app')
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
                        <a href="{{ url(route('vendor.home')) }}">{{ __('apps::dashboard.index.title') }}</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="{{ url(route('vendor.bulk_messages.index')) }}">
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
                                                @foreach($channels->where('id_users',auth()->user()->id)->get() as $channel)
                                                    <option value="{{$channel->id}}" data-token="{{$channel->channel_token}}" data-owner="{{$channel->owner->identifier}}">{{$channel->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row  mb-2 hidden">
                                        <label class="col-xs-2">{{__('message::dashboard.messages.type')}} </label>
                                        <div class="col-xs-9">
                                            <select name="type" class="form-control select2">
                                                <option value="2" data-target=".bulk">{{__('message::dashboard.messages.bulk')}}</option>
                                            </select>
                                        </div>
                                    </div>


                                    @include('message::vendor.messages.partials.message_details')

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
                                    {{__('message::dashboard.messages.bulk_message')}}
                                </span>
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <div class="">
                                <div class="form-group row mb-3">
                                    <label class="col-xs-4">{{__('message::dashboard.messages.interval')}} ( {{__('message::dashboard.messages.seconds')}} )</label>
                                    <div class="col-xs-8">
                                        <input type="number" class="interval form-control" value="60" name="interval" min="60"
                                               placeholder="{{__('message::dashboard.messages.interval')}}">
                                    </div>
                                </div>

                                <div class="form-group row mb-3">
                                    <label class="col-xs-4">{{__('message::dashboard.messages.sending_date')}} :</label>
                                    <div class="col-xs-8">
                                        <div class="mt-radio-inline" style="padding: 0">
                                            <label class="mt-radio mt-radio-outline">
                                                {{__('message::dashboard.messages.now')}}
                                                <input type="radio" class="first" name="sending" value="1" checked>
                                                <span></span>
                                            </label>
                                            <label class="mt-radio mt-radio-outline">
                                                {{__('message::dashboard.messages.send_at')}}
                                                <input type="radio" class="second" value="2" name="sending">
                                                <span></span>
                                            </label>
                                            <input type="datetime-local" class="hidden form-control datetimepicker-input" min="{{date('Y-m-d H:i')}}" placeholder="yyyy-mm-dd hh:mm" name="date"/>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>

                                @include('message::vendor.bulk_messages.bulk.bulk_contacts')

                                <div class="bulk_contacts" id="numbers_groups">
                                    @include('message::vendor.bulk_messages.bulk.numbers_groups')
                                </div>

                                <div class="bulk_contacts" id="new_contacts" style="display: none">
                                    @include('message::vendor.bulk_messages.bulk.new_contacts')
                                </div>

                                <div class="bulk_contacts" id="contacts" style="display: none">
                                    @include('message::vendor.bulk_messages.bulk.contacts')
                                </div>

                                <div class="bulk_contacts" id="excel_contacts" style="display: none">
                                    @include('message::vendor.bulk_messages.bulk.excel_contacts')
                                </div>
                            </div>
                        </div>
                    </div>

                    @include('message::vendor.messages.partials.notes')
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

        const input1 = document.querySelector("#item-contact-inputs .inputTel");
        const input2 = document.querySelector("#item-mention-inputs .inputTel");
        const iti1 = intlTelInput(input1,itiOptions)
        const iti2 = intlTelInput(input2,itiOptions)

        function dealWithMessageVariables(body,variables){}

        $('input[name="sending"]').on('change',function(){
            $("input[name='date']").toggleClass('hidden');
        });

        $('select[name="message_type"]').on('change',function (){
            $($(this).children('option:selected').data('target')).removeClass('hidden');
            $($(this).children('option:selected').data('target')).siblings('.reply_msg').addClass('hidden');
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
                url : '{{route('vendor.messages.uploadFile')}}',
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

        function getReceivers(){
            let data = [];
            let receivers_type = $('input[name="bulk_flag"]:checked').val();
            if(receivers_type == 'numbers_groups'){
                data['numbers_groups'] = $('select[name="numbers_groups[]"]').val() ?? '';
            }else if(receivers_type == 'new_contacts'){
                data[receivers_type] = $('textarea[name="phones"]').val().split('\n');
            }else if(receivers_type == 'contacts'){
                data[receivers_type] = $('select[name="contacts[]"]').val() ?? '';
            }else if(receivers_type == 'excel_contacts'){
                data[receivers_type] = 'file';
            }
            return data;
        }

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

        function toggleBulkFlag(flag) {
            switch (flag) {
                case 'numbers_groups':
                    $('#numbers_groups').show();
                    $('#new_contacts').hide();
                    $('#contacts').hide();
                    $('#excel_contacts').hide();
                    break;

                case 'new_contacts':
                    $('#numbers_groups').hide();
                    $('#new_contacts').show();
                    $('#contacts').hide();
                    $('#excel_contacts').hide();
                    break;

                case 'contacts':
                    $('#numbers_groups').hide();
                    $('#new_contacts').hide();
                    $('#contacts').show();
                    $('#excel_contacts').hide();
                    break;

                case 'excel_contacts':
                    $('#numbers_groups').hide();
                    $('#new_contacts').hide();
                    $('#contacts').hide();
                    $('#excel_contacts').show();
                    break;

                default:
                    break;
            }
        }

        function buildSelect(element,data){
            element.empty().select2('destroy');
            let x = '<option value=""></option>';
            $.each(data ,function (index,item) {
                x+= '<option value="'+(item.id)+'">'+(item.title ?? (item.name ?? item.whatsapp))+'</option>';
            })

            element.append(x).select2({
                placeholder: "Select"
            });
        }

        $('select[name="channel_id"]').on('change',function (){
            $.ajax({
                url: '{{route('vendor.messages.getChannelData',":id")}}'.replace(':id',$(this).val()),
                type: 'GET',
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function (data){
                    if(data.success){
                        buildSelect($('select[name="numbers_groups[]"]'),data.data.numbers_groups)
                        buildSelect($('select[name="contacts[]"]'),data.data.contacts)
                    }
                },
                error: function (error){
                    toastr['error'](error.responseJSON.message)
                }
            })
        })

        $('.send_message').on('click',function (e){
            sendBulkMessage($(this));
        });

        function sendBulkMessage (element){
            element.attr('disabled','disabled');
            $('a.tag[data-time="1"]').click();
            let body = $('textarea[name="body"]').val();
            let phones = getReceivers();

            let channel_id = $('select[name="channel_id"]').val();
            let message_type = $('select[name="message_type"]').val();

            var formData = new FormData();
            formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
            formData.append('channel_id',channel_id);
            formData.append('message_type',message_type);
            formData.append('bulk_flag',$('input[name="bulk_flag"]:checked').val());

            let ajaxData = {
                'receivers': phones,
                'interval': $('input[name="interval"]').val(),
                'sending_later': $('input[name="sending"]:checked').val() == 2 ? 1 : 0,
                'sending_date' : $('input[name="sending"]:checked').val() == 2 ? $('.mt-radio-inline input[name="date"]').val() : "{{date('Y-m-d H:i')}}",
            };

            ajaxData = buildMessageData(ajaxData,message_type,body);

            Object.keys(ajaxData).map(index => {
                return  formData.append(index, ajaxData[index]);
            });

            Object.keys(ajaxData.receivers).map(index => {
                return  formData.append(index, ajaxData['receivers'][index]);
            });

            if($('input[name="bulk_flag"]:checked').val() == 'excel_contacts'){
                formData.append('excel_file', $('#excel_file')[0].files[0]);
            }

            $.ajax({
                url : '{{route('vendor.bulk_messages.store')}}',
                type : 'POST',
                data : formData,
                processData: false,
                contentType: false,
                success : function(data) {
                    element.attr('disabled',false);
                    if(data.success) {
                        toastr['success'](data.message);
                        window.location.href = '{{route('vendor.bulk_messages.show',":id")}}'.replace(":id",data.id);
                    }
                },
                error: function (error){
                    toastr['error'](error.responseJSON.message)
                    element.attr('disabled',false);
                }
            });

        };

        function fixDesign(){
            $('#excel_file_wrap label').removeClass('col-md-2').addClass('col-xs-4')
            $('#excel_file_wrap .col-md-9').removeClass('col-md-9').addClass('col-xs-8')
        }

        fixDesign();
    </script>
@endsection
