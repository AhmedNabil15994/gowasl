@extends('apps::dashboard.layouts.app')
@section('title', __('apps::dashboard.index.title'))
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
                        <a href="{{ url(route('dashboard.home')) }}">
                            {{ __('apps::dashboard.index.title') }}
                        </a>
                    </li>
                </ul>
            </div>
            <h1 class="page-title"> {{ __('apps::dashboard.index.welcome') }} ,
                <small><b style="color:red">{{ Auth::user()->name }} </b></small>
            </h1>
            @can('show_statistics')
            <div class="row">
                <div class="portlet light bordered col-lg-12">
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 mb-25">
                        <a class="dashboard-stat dashboard-stat-v2 orange"
                           href="{{url(route('dashboard.packages.index'))}}">

                            <div class="visual">
                              <i class="fa fa-building-o"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup" data-value="{{$data['packages']}}">{{$data['packages']}}</span>
                                </div>
                                <div class="desc">{{ __('apps::dashboard.index.statistics.packages') }}</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 mb-25">
                        <a class="dashboard-stat dashboard-stat-v2 yellow"
                           href="{{url(route('dashboard.addons.index'))}}">

                            <div class="visual">
                                <i class="fa fa-users"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup" data-value="{{$data['addons']}}">{{$data['addons']}}</span>
                                </div>
                                <div class="desc">{{ __('apps::dashboard.index.statistics.addons') }}</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 mb-25">
                        <a class="dashboard-stat dashboard-stat-v2 green"
                           href="{{url(route('dashboard.orders.index'))}}">

                            <div class="visual">
                              <i class="fa fa-building-o"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup" data-value="{{$data['orders']}}">{{$data['orders']}}</span>
                                </div>
                                <div class="desc">{{ __('apps::dashboard.index.statistics.orders') }}</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 mb-25">
                        <a class="dashboard-stat dashboard-stat-v2 blue"
                           href="{{url(route('dashboard.channels.index'))}}">

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
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 mb-25">
                        <a class="dashboard-stat dashboard-stat-v2 dark"
                           href="{{url(route('dashboard.contacts.index'))}}">

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
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 mb-25">
                        <a class="dashboard-stat dashboard-stat-v2 red"
                           href="{{url(route('dashboard.messages.index'))}}">

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
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 mb-25">
                        <a class="dashboard-stat dashboard-stat-v2 yellow"
                           href="{{url(route('dashboard.bots.index'))}}">

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
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 mb-25">
                        <a class="dashboard-stat dashboard-stat-v2 green"
                           href="{{url(route('dashboard.templates.index'))}}">

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

                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 mb-25">
                      <a class="dashboard-stat dashboard-stat-v2 orange"
                         href="{{url(route('dashboard.users.index'))}}">

                        <div class="visual">
                          <i class="fa fa-users"></i>
                        </div>
                        <div class="details">
                          <div class="number">
                            <span data-counter="counterup" data-value="{{$data['users']}}">{{$data['users']}}</span>
                          </div>
                          <div class="desc">{{ __('apps::dashboard.index.statistics.users') }}</div>
                        </div>
                      </a>
                    </div>
                </div>

                <div class="portlet light bordered col-lg-12">
                    <div class="portlet-title tabbable-line">
                        <div class="caption">
                            <i class="icon-bubbles font-dark hide"></i>
                            <span class="caption-subject font-dark bold uppercase">
                            {{__('apps::dashboard.index.statistics.titles.orders')}}
                        </span>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <a class="dashboard-stat dashboard-stat-v2 label-warning"
                           href="{{url(route('dashboard.orders.index'))}}" style="color: white">

                            <div class="visual">
                                <i class="fa fa-shopping-cart"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup" data-value="{{$data['pending_orders']}}">{{$data['pending_orders']}}</span>
                                </div>
                                <div class="desc">{{ __('apps::dashboard.index.statistics.pending_orders') }}</div>
                            </div>
                        </a>
                    </div>

                    <div class="col-lg-4">
                        <a class="dashboard-stat dashboard-stat-v2 green-dark"
                           href="{{url(route('dashboard.orders.index'))}}" style="color: white">

                            <div class="visual">
                                <i class="fa fa-shopping-cart"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup" data-value="{{$data['active_orders']}}">{{$data['active_orders']}}</span>
                                </div>
                                <div class="desc">{{ __('apps::dashboard.index.statistics.completed_orders') }}</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-4">
                        <a class="dashboard-stat dashboard-stat-v2 label-primary"
                           href="{{url(route('dashboard.orders.index'))}}" style="color: white">

                            <div class="visual">
                                <i class="fa fa-shopping-cart"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup" data-value="{{$data['orders']}}">{{$data['orders']}}</span>
                                </div>
                                <div class="desc">{{ __('apps::dashboard.index.statistics.total_orders') }}</div>
                            </div>
                        </a>
                    </div>

                </div>
            </div>
            @endcan
        </div>
    </div>

@stop
@section('scripts')
  @include('apps::dashboard.layouts._js')
@endsection
