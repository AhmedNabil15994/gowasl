@extends('apps::dashboard.layouts.app')
@section('title', __('user::dashboard.channels.update.title'))
@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/css/intlTelInput.css">
    <livewire:styles />
    <style>
        .details{
            padding-top: 25px;
        }
        .details p{
            margin: 5px;
        }
        .w-100{
            width: 100%;
            margin-bottom: 15px;
        }
        .qrImage{
            height: 205px;
            width: 205px;
        }
        .form-horizontal{
            padding: 10px 0;
        }
        .pd-25{
            padding: 25px;
        }
        .form-horizontal .form-group{
            margin: 0;
        }
        .mb-2{
            margin-bottom: 15px !important;
        }
        .iti{
            width: 100% !important;
        }
        .dashboard-stat .details .desc{
            font-size: 13px;
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
                        <a href="{{ url(route('dashboard.channels.index')) }}">
                            {{__('user::dashboard.channels.index.title')}}
                        </a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="#">{{__('user::dashboard.channels.update.title')}}</a>
                    </li>
                </ul>
            </div>

            <h1 class="page-title"></h1>

            <div class="row">
                <div class="col-md-6">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption font-red-sunglo">
                                <i class="icon-settings font-red-sunglo"></i>
                                <span class="caption-subject bold uppercase">
                                    {{__('user::dashboard.channels.channel_details')}}
                                </span>
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <div class="form-body" style="padding:0">
                                <div class="row">
                                    <div class="col-md-6 details">
                                        <p>{{__('user::dashboard.channels.id')}}: <b>{{$model->channel_id}}</b></p>
                                        <p>{{__('user::dashboard.channels.token')}}: <b>{{$model->channel_token}}</b></p>
                                        <p>{{__('user::dashboard.channels.identifier')}}: <b>{{$model->owner->identifier}}</b></p>
                                        <p>{{__('user::dashboard.channels.days')}}: <b>{{$model->days}}</b></p>
                                        <p>{{__('user::dashboard.channels.valid_until')}}: <b>{{date('Y-m-d',strtotime($model->valid_until))}}</b></p>
                                        <p>{{__('user::dashboard.channels.status')}}: <b>{{date('Y-m-d') < $model->valid_until ? __('user::dashboard.channels.active') : __('user::dashboard.channels.notActive')}}</b></p>
                                    </div>
                                    <div class="col-md-6 text-center">
                                        @livewire('qr-image',[
                                        'id' => $model->channel_id,
                                        'token' => $model->token,
                                        'identifier' => $model->owner->identifier,
                                        'days' => $model->days
                                        ])
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="portlet light bordered actions {{$model->status == 'connected' ? '' : 'hidden'}}">
                        <div class="portlet-title">
                            <div class="caption font-red-sunglo">
                                <i class="icon-settings font-red-sunglo"></i>
                                <span class="caption-subject bold uppercase">
                                    {{__('user::dashboard.channels.channel_stats')}}
                                </span>
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <div class="form-body" style="padding:0">
                                <div class="row">
                                    <div class="col-sm-3 col-xs-12 mb-25">
                                        <a class="dashboard-stat dashboard-stat-v2 red"href="#">
                                            <div class="visual">
                                                <i class="fa fa-number"></i>
                                            </div>
                                            <div class="details">
                                                <div class="number">
                                                    <span data-counter="counterup" data-value="{{$model->package->daily_limit}}">{{$model->package->daily_limit}}</span>
                                                </div>
                                                <div class="desc">{{__('user::dashboard.channels.daily_msgs_limit')}}</div>
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
                                                    <span data-counter="counterup" data-value="{{$model->todayUsage?->counter ?? 0}}">{{$model->todayUsage?->counter ?? 0}}</span>
                                                </div>
                                                <div class="desc">{{__('user::dashboard.channels.sent_msgs_count')}}</div>
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
                                                    <span data-counter="counterup" data-value="{{$model->contacts()->count() ?? 0}}">{{$model->contacts()->count() ?? 0}}</span>
                                                </div>
                                                <div class="desc">{{__('user::dashboard.channels.contacts')}}</div>
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
                                                    <span data-counter="counterup" data-value="{{$model->messages()->count() ?? 0}}">{{$model->messages()->count() ?? 0}}</span>
                                                </div>
                                                <div class="desc">{{__('user::dashboard.channels.messages')}}</div>
                                            </div>
                                        </a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="portlet light bordered actions {{$model->status == 'connected' ? '' : 'hidden'}}">
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
                                <div class="row">
                                    <form action="#" class="form-horizontal" method="post" style="padding: 20px 0">
                                        @csrf
                                        <div class="form-group col-xs-12 mb-2">
                                            <label class="col-4 col-form-label">{{__('user::dashboard.channels.phone')}} </label>
                                            <div class="col-8">
                                                <input type="tel" class="form-control inputTel">
                                            </div>
                                        </div>
                                        <div class="form-group col-xs-12 mb-2">
                                            <label class="col-4 col-form-label">{{__('user::dashboard.channels.message')}} </label>
                                            <div class="col-8">
                                                <textarea name="body" cols="30" rows="10" class="form-control" placeholder="{{__('user::dashboard.channels.message')}}"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group col-xs-12 text-right" style="margin-top: 20px;">
                                            <div class="col-9">
                                                <button type="button" class="send_message btn btn-success waves-effect waves-light float-right">{{__('user::dashboard.channels.send_message')}}</button>
                                                <div class="clearfix"></div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 actions {{$model->status == 'connected' ? '' : 'hidden'}}">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption font-red-sunglo">
                                <i class="icon-settings font-red-sunglo"></i>
                                <span class="caption-subject bold uppercase">
                                    {{__('user::dashboard.channels.channel_actions')}}
                                </span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="form-body" style="padding:0">
                                <a class="btn btn-warning btn-sm btn-icon" href="{{route('dashboard.channels.logout',['id'=>$model->id])}}">{{__('user::dashboard.channels.logout')}}</a>
                                <a class="btn btn-primary btn-sm btn-icon" href="{{route('dashboard.channels.clearData',['id'=>$model->id])}}">{{__('user::dashboard.channels.clear_data')}}</a>
                                <a class="btn btn-danger btn-sm btn-icon" href="{{route('dashboard.channels.clearChannel',['id'=>$model->id])}}">{{__('user::dashboard.channels.clear_channel')}}</a>
                            </div>
                        </div>
                    </div>
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption font-red-sunglo">
                                <i class="icon-settings font-red-sunglo"></i>
                                <span class="caption-subject bold uppercase">
                                    {{__('user::dashboard.channels.channel_settings')}}
                                </span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="form-body" style="padding:0">
                                <form class="form-horizontal row" action="{{URL::current()}}" method="post">
                                    @csrf
                                    @if(in_array(1,auth()->user()->roles()->pluck('id')->toArray()))
                                        <div class="form-group col-md-6 mb-2">
                                            <label class="col-4 col-form-label">{{__('user::dashboard.channels.valid_until')}} </label>
                                            <div class="col-8">
                                                <input type="date" value="{{date('Y-m-d',strtotime($model->valid_until))}}" class="form-control" min="{{date('Y-m-d')}}" name="valid_until" placeholder="{{__('user::dashboard.channels.valid_until')}}}">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6 mb-2">
                                            <label class="col-4 col-form-label">{{__('user::dashboard.channels.package')}} </label>
                                            @inject('packages','Modules\Package\Entities\Package')
                                            <div class="col-8">
                                                <select name="package_id" class="form-control select2">
                                                    <option value=""></option>
                                                    @foreach($packages->active()->get() as $package)
                                                        <option value="{{$package->id}}" {{$model->package_id == $package->id ? 'selected' : ''}}>{{$package->title}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="form-group col-md-6 mb-2">
                                        <label class="col-4 col-form-label">{{__('user::dashboard.channels.msgs_webhook_url')}}</label>
                                        <div class="col-8">
                                            <input type="text" class="form-control" name="settings[webhooks][messageNotifications]" placeholder="{{__('user::dashboard.channels.msgs_webhook_url')}}" value="{{$model?->settings?->webhooks?->messageNotifications}}">
                                        </div>
                                    </div>
                                    {{-- <div class="form-group col-md-6 mb-2">
                                        <label class="col-4 col-form-label">{{trans('main.ackNotifications')}}</label>
                                        <div class="col-8">
                                            <input type="text" class="form-control" name="ackNotifications" placeholder="{{trans('main.ackNotifications')}}" value="">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6 mb-2">
                                        <label class="col-4 col-form-label">{{trans('main.chatNotifications')}}</label>
                                        <div class="col-8">
                                            <input type="text" class="form-control" name="chatNotifications" placeholder="{{trans('main.chatNotifications')}}" value="">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6 mb-2">
                                        <label class="col-4 col-form-label">{{trans('main.businessNotifications')}}</label>
                                        <div class="col-8">
                                            <input type="text" class="form-control" name="businessNotifications" placeholder="{{trans('main.businessNotifications')}}" value="">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6 mb-2">
                                        <label class="col-4 col-form-label">{{trans('main.sendDelay')}} (in seconds)</label>
                                        <div class="col-8">
                                            <input type="tel" value="" class="form-control" name="sendDelay" placeholder="{{trans('main.sendDelay')}}">
                                        </div>
                                    </div>
--}}


                                    <div class="form-group col-xs-12 text-right" style="margin-top: 20px;">
                                        <div class="col-9">
                                            <button type="submit" class="btn btn-info waves-effect waves-light float-right">{{__('user::dashboard.channels.update_btn')}}</button>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>

                                </form>
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
    <livewire:scripts />
    <script>
        Livewire.on('statusChanged', qrData => {
            if(qrData.channelStatus == 'connected'){
                $('.actions').removeClass('hidden');
            }else{
                $('.actions').addClass('hidden');
            }
        });

        const input = document.querySelector(".inputTel");
        const iti = intlTelInput(input,{
            utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/utils.js",
            preferredCountries: ["kw","ae","bh","sa","om","eg"],
        })

        $('.send_message').on('click',function (){
            let body = $('textarea[name="body"]').val();
            let phone = iti.getNumber().replace('+','');
            $.ajax({
                url: "{{route('api.channels.messages.sendMessage')}}",
                type: 'POST',
                headers: {
                    'ID' : "{{$model->channel_id}}",
                    "TOKEN" : "{{$model->channel_token}}",
                    "Accept": "application/json",
                    "Authorization" : "Bearer " + "{{$model->owner->identifier}}",
                },
                data: {
                    '_token' : $('meta[name="csrf-token"]').attr('content'),
                    'phone': phone,
                    'body' : body,
                },
                success: function (data){
                    if(data.success){
                        toastr['success'](data.message)
                        $('textarea[name="body"]').val('')
                    }
                },
                error: function (error){
                    toastr['error'](error.responseJSON.message)
                }
            })
        });

    </script>
@endsection
