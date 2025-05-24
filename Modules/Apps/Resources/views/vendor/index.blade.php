@extends('apps::vendor.layouts.app')
@section('title', __('apps::vendor.index.title'))
@section('css')
<style>
    .mb-25{
      margin-bottom: 25px !important;
    }
</style>
@endsection
@section('content')

    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <a href="{{ url(route('vendor.home')) }}">
                            {{ __('apps::vendor.index.title') }}
                        </a>
                    </li>
                </ul>
            </div>
            <h1 class="page-title"> {{ __('apps::vendor.index.welcome') }} ,
                <small><b style="color:red">{{ Auth::user()->name }} </b></small>
            </h1>

            @can('show_statistics')
                <div class="row">
                    <div class="portlet light bordered col-lg-12">
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 mb-25">
                            <a class="dashboard-stat dashboard-stat-v2 blue"
                               href="{{url(route('vendor.channels.index'))}}">

                                <div class="visual">
                                    <i class="fa fa-building-o"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <span data-counter="counterup" data-value="{{$data['channels']}}">{{$data['channels']}}</span>
                                    </div>
                                    <div class="desc">{{ __('apps::dashboard.index.statistics.channels') }}</div>
                                </div>
                            </a>
                        </div>
                        @can('show_contacts')
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 mb-25">
                            <a class="dashboard-stat dashboard-stat-v2 dark"
                               href="#">

                                <div class="visual">
                                    <i class="fa fa-building-o"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <span data-counter="counterup" data-value="{{$data['contacts']}}">{{$data['contacts']}}</span>
                                    </div>
                                    <div class="desc">{{ __('apps::dashboard.index.statistics.contacts') }}</div>
                                </div>
                            </a>
                        </div>
                        @endcan
                        @can('show_messages')
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 mb-25">
                            <a class="dashboard-stat dashboard-stat-v2 red"
                               href="#">

                                <div class="visual">
                                    <i class="fa fa-building-o"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <span data-counter="counterup" data-value="{{$data['messages']}}">{{$data['messages']}}</span>
                                    </div>
                                    <div class="desc">{{ __('apps::dashboard.index.statistics.messages') }}</div>
                                </div>
                            </a>
                        </div>
                        @endcan
                        @can('show_bots')
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 mb-25">
                            <a class="dashboard-stat dashboard-stat-v2 yellow"
                               href="#">

                                <div class="visual">
                                    <i class="fa fa-building-o"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <span data-counter="counterup" data-value="{{$data['bots']}}">{{$data['bots']}}</span>
                                    </div>
                                    <div class="desc">{{ __('apps::dashboard.index.statistics.bots') }}</div>
                                </div>
                            </a>
                        </div>
                        @endcan
                        @can('show_templates')
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 mb-25">
                            <a class="dashboard-stat dashboard-stat-v2 green"
                               href="#">

                                <div class="visual">
                                    <i class="fa fa-building-o"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <span data-counter="counterup" data-value="{{$data['templates']}}">{{$data['templates']}}</span>
                                    </div>
                                    <div class="desc">{{ __('apps::dashboard.index.statistics.templates') }}</div>
                                </div>
                            </a>
                        </div>
                        @endcan
                    </div>
                </div>
            @endcan
        </div>
    </div>

@stop
@section('scripts')
  @include('apps::vendor.layouts._js')
@endsection
