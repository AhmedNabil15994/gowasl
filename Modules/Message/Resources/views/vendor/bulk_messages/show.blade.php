@extends('apps::vendor.layouts.app')
@section('title', __('message::dashboard.bulk_messages.routes.show'))
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
                            {{__('message::dashboard.bulk_messages.routes.index')}}
                        </a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="#">{{__('message::dashboard.bulk_messages.routes.show')}}</a>
                    </li>
                </ul>
            </div>

            <h1 class="page-title"></h1>

            <div class="row">

                <div class="col-md-12">
                    <div class="row">
                        <div class="col-sm-3 col-xs-12 mb-25">
                            <a class="dashboard-stat dashboard-stat-v2 dark"href="#">
                                <div class="visual">
                                    <i class="fa fa-number"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <span data-counter="counterup" data-value="{{count($model->bulk_contacts->contacts) ?? 0}}">{{count($model->bulk_contacts->contacts) ?? 0}}</span>
                                    </div>
                                    <div class="desc">{{__('message::dashboard.bulk_messages.datatable.contacts_count')}}</div>
                                </div>
                            </a>
                        </div>
                        <div class="col-sm-3 col-xs-12 mb-25">
                            <a class="dashboard-stat dashboard-stat-v2 green"href="#">
                                <div class="visual">
                                    <i class="fa fa-number"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <span data-counter="counterup" data-value="{{count($model->bulk_contacts->phones) ?? 0}}">{{count($model->bulk_contacts->phones) ?? 0}}</span>
                                    </div>
                                    <div class="desc">{{__('message::dashboard.bulk_messages.datatable.sent_msgs_count')}}</div>
                                </div>
                            </a>
                        </div>
                        <div class="col-sm-3 col-xs-12 mb-25">
                            <a class="dashboard-stat dashboard-stat-v2 orange"href="#">
                                <div class="visual">
                                    <i class="fa fa-number"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <span data-counter="counterup" data-value="{{!$model?->job?->queue ? count($model->bulk_contacts->phones) : 0}}">{{!$model?->job?->queue ? count($model->bulk_contacts->phones) : 0}}</span>
                                    </div>
                                    <div class="desc">{{__('message::dashboard.bulk_messages.datatable.total_sent_msgs_count')}}</div>
                                </div>
                            </a>
                        </div>
                        <div class="col-sm-3 col-xs-12 mb-25">
                            <a class="dashboard-stat dashboard-stat-v2 blue"href="#">
                                <div class="visual">
                                    <i class="fa fa-number"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <span data-counter="counterup" data-value="0">0</span>
                                    </div>
                                    <div class="desc">{{__('message::dashboard.bulk_messages.datatable.pending_msgs_count')}}</div>
                                </div>
                            </a>
                        </div>

                    </div>
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
                                                        @foreach($channels->where('id_users',auth()->user()->id)->whereId($model->channel_id)->get() as $channel)
                                                            <option disabled value="{{$channel->id}}" data-token="{{$channel->channel_token}}" data-owner="{{$channel->owner->identifier}}">{{$channel->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row  mb-2">
                                                <label class="col-xs-2">{{__('message::dashboard.messages.type')}} </label>
                                                <div class="col-xs-9">
                                                    <select name="type" class="form-control select2">
                                                        <option value="2" data-target=".bulk">{{__('message::dashboard.messages.bulk')}}</option>
                                                    </select>
                                                </div>
                                            </div>

                                            @include('message::vendor.messages.partials.message_details')

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
                                    {{__('message::dashboard.messages.bulk_message')}}
                                </span>
                                    </div>
                                </div>
                                <div class="portlet-body form">
                                    <div class="">
                                        <div class="form-group row mb-3">
                                            <label class="col-xs-4">{{__('message::dashboard.messages.interval')}} ( {{__('message::dashboard.messages.seconds')}} )</label>
                                            <div class="col-xs-8">
                                                <input type="number" disabled class="interval form-control" value="{{$model->interval}}" name="interval" min="60"
                                                       placeholder="{{__('message::dashboard.messages.interval')}}">
                                            </div>
                                        </div>

                                        <div class="form-group row mb-3">
                                            <label class="col-xs-4">{{__('message::dashboard.messages.sending_date')}} :</label>
                                            <div class="col-xs-8">
                                                <div class="mt-radio-inline" style="padding: 0">
                                                    <label class="mt-radio mt-radio-outline">
                                                        {{__('message::dashboard.messages.now')}}
                                                        <input disabled type="radio" class="first" name="sending" value="1"
                                                            {{$model->sending_later == 0 ? 'checked' : ''}}>
                                                        <span></span>
                                                    </label>
                                                    <label class="mt-radio mt-radio-outline">
                                                        {{__('message::dashboard.messages.send_at')}}
                                                        <input disabled type="radio" class="second" value="2" name="sending" {{$model->sending_later == 1 ? 'checked' : ''}}>
                                                        <span></span>
                                                    </label>
                                                    <input type="datetime-local" disabled class="form-control datetimepicker-input" min="{{date('Y-m-d H:i')}}" placeholder="yyyy-mm-dd hh:mm" value="{{$model->sending_date}}" name="date"/>
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>

                                        <div class="form-group row mb-2 ">
                                            <label class="col-xs-4">{{__('message::dashboard.messages.contacts')}} </label>
                                            <div class="col-xs-8">
                                                <table class="table table-bordered table-striped">
                                                    <thead>
                                                    <tr>
                                                        <th>{{__('contact::dashboard.contacts.datatable.name')}}</th>
                                                        <th>{{__('contact::dashboard.contacts.datatable.whatsapp')}}</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($model->contacts as $contact)
                                                        <tr>
                                                            <td>{{$contact->name}}</td>
                                                            <td>{{$contact->whatsapp}}</td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            @include('message::vendor.messages.partials.notes')
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

    <script type="text/javascript">
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
