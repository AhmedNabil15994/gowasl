@extends('apps::vendor.layouts.app')
@section('title', __('message::dashboard.decision_messages.routes.show'))
@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/css/intlTelInput.css">
    <style>
        .iti{
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
                        <a href="{{ url(route('vendor.decision_messages.index')) }}">
                            {{__('message::dashboard.decision_messages.routes.index')}}
                        </a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="#">{{__('message::dashboard.decision_messages.routes.show')}}</a>
                    </li>
                </ul>
            </div>

            <h1 class="page-title"></h1>

            <div class="row">

                <div class="col-md-12">
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
                                                        @foreach($channels->where('id_users',auth()->user()->id)->whereChannelId($model->channel_id)->get() as $channel)
                                                            <option disabled value="{{$channel->id}}" data-token="{{$channel->channel_token}}" data-owner="{{$channel->owner->identifier}}">{{$channel->name}}</option>
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

                                            @include('message::vendor.decision_messages.bulk.message_details',['disableTypes' => 1])

                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                                    <div class="form-body">
                                        <div class="form-group row mb-2">
                                            <label class="col-xs-4">{{__('message::dashboard.decision_messages.datatable.queue_data')}}</label>
                                            <div class="col-xs-7">
                                                <div style="padding: 25px;border-radius: 5px;border:1px solid #ddd;background-color: #eef1f5">
                                                    <p>{{  'decision_message_id : ' . $model->queue_data->message_id ?? '' }}</p>
                                                    <p>{{__('message::dashboard.decision_messages.form.user_action')}}</p>
                                                    <p>{{  'action : ' . ($model->queue_data->user_action['action'] ?? '') }}</p>
                                                    <p>{{  'action_message_id : ' . ($model->queue_data?->user_action['message_id'] ?? '') }}</p>
                                                    <p>{{  'created_at : ' . ($model->queue_data->user_action['created_at'] ?? '') }}</p>
                                                </div>
                                            </div>
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
                                            <div class="form-group row mb-2">
                                                <label class="col-xs-4">{{__('message::dashboard.messages.message_type')}} </label>
                                                <div class="col-xs-7">
                                                    {{$model?->message_data?->agree['message_type'] ?? ''}}
                                                </div>
                                            </div>
                                            <div class="form-group row mb-2">
                                                <label class="col-xs-4">{{__('message::dashboard.messages.message')}} </label>
                                                <div class="col-xs-7">
                                                    <div style="padding: 10px;border-radius: 5px;border:1px solid #ddd;background-color: #eef1f5">
                                                    @foreach($model->message_data?->agree as $key => $item)
                                                        @if($key != 'message_type')
                                                        <p>{{ $key . ': ' . $item }}</p>
                                                        @endif
                                                    @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="refuse msg_actions">
                                            <h4 class="caption-subject bold uppercase">{{__('message::dashboard.refuse')}} ( 2 )</h4>
                                            <div class="form-group row mb-2">
                                                <label class="col-xs-4">{{__('message::dashboard.messages.message_type')}} </label>
                                                <div class="col-xs-7">
                                                    {{$model?->message_data?->refuse['message_type'] ?? ''}}
                                                </div>
                                            </div>
                                            <div class="form-group row mb-2">
                                                <label class="col-xs-4">{{__('message::dashboard.messages.message')}} </label>
                                                <div class="col-xs-7">
                                                    <div style="padding: 10px;border-radius: 5px;border:1px solid #ddd;background-color: #eef1f5">
                                                    @foreach($model->message_data?->refuse as $key => $item)
                                                        @if($key != 'message_type')
                                                            <p>{{ $key . ': ' . $item }}</p>
                                                        @endif
                                                    @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-2">
                                            <label class="col-xs-4">{{__('message::dashboard.decision_messages.form.notify_url')}} </label>
                                            <div class="col-xs-7">
                                                <input type="text" name="notify_url" class="form-control" value="{{$model->message_data?->notify_url ?? ''}}" placeholder="{{__('message::dashboard.decision_messages.form.notify_url')}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- PAGE ACTION --}}
                    <div class="col-md-12">
                        <div class="form-actions">
                            @include('apps::vendor.layouts._ajax-msg')
                            <div class="form-group">
                                <a href="{{url(route('vendor.messages.index')) }}" class="btn btn-lg red">
                                    {{__('apps::dashboard.buttons.back')}}
                                </a>
                            </div>
                        </div>
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

        const input1 = document.querySelector(".inputTel");
        const iti1 = intlTelInput(input1,itiOptions)

        $(function () {

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
                    url: '{{route('vendor.messages.getChannelData',$model->channel->id)}}'.replace(':id',$(this).val()),
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

            $('select[name="message_type"]').val("{{$model->message_type}}").trigger('change');

            $('select[name="channel_id"]').val("{{$model->channel->id}}").trigger('change');

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

            function fixDesign(){
                $('#excel_file_wrap label').removeClass('col-md-2').addClass('col-xs-4')
                $('#excel_file_wrap .col-md-9').removeClass('col-md-9').addClass('col-xs-8')
            }

            fixDesign();
        });
    </script>

@endsection
