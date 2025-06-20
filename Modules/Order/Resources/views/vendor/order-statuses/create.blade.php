@extends('apps::vendor.layouts.app')
@section('title', __('order::vendor.order_statuses.routes.create'))
@section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <a href="{{ url(route('vendor.home')) }}">{{ __('apps::vendor.index.title') }}</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="{{ url(route('vendor.order-statuses.index')) }}">
                        {{__('order::vendor.order_statuses.routes.index')}}
                    </a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="#">{{__('order::vendor.order_statuses.routes.create')}}</a>
                </li>
            </ul>
        </div>

        <h1 class="page-title"></h1>

        <div class="row">
            <form id="form" role="form" class="form-horizontal form-row-seperated" method="post" enctype="multipart/form-data" action="{{route('vendor.order-statuses.store')}}">
                @csrf
                <div class="col-md-12">

                    {{-- RIGHT SIDE --}}
                    <div class="col-md-3">
                        <div class="panel-group accordion scrollable" id="accordion2">
                            <div class="panel panel-default">

                                <div id="collapse_2_1" class="panel-collapse in">
                                    <div class="panel-body">
                                        <ul class="nav nav-pills nav-stacked">
                                            <li class="active">
                                                <a href="#global_setting" data-toggle="tab">
                                                    {{ __('order::vendor.order_statuses.form.tabs.general') }}
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    {{-- PAGE CONTENT --}}
                    <div class="col-md-9">
                        <div class="tab-content">

                            {{-- CREATE FORM --}}
                            <div class="tab-pane active fade in" id="global_setting">
                                <div class="col-md-10">
                                    @foreach (config('translatable.locales') as $code)
                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('order::vendor.order_statuses.form.title')}} - {{ $code }}
                                        </label>
                                        <div class="col-md-9">
                                            <input type="text" name="title[{{$code}}]" class="form-control" data-name="title.{{$code}}">
                                            <div class="help-block"></div>
                                        </div>
                                    </div>
                                    @endforeach
                                    <div class="form-group form-md-radios">
                                        <label class="col-md-2">
                                            {{__('order::vendor.order_statuses.form.color_label')}}
                                        </label>
                                        <div class="col-md-9">
                                            <div class="md-radio-list">
                                                <div class="md-radio has-success">
                                                    <input type="radio" id="success" name="color_label" class="md-radiobtn" value="success">
                                                    <label for="success">
                                                        <span></span>
                                                        <span class="check"></span>
                                                        <span class="box"></span>
                                                    </label>
                                                </div>
                                                <div class="md-radio has-warning">
                                                    <input type="radio" id="warning" name="color_label" class="md-radiobtn" value="warning">
                                                    <label for="warning">
                                                        <span></span>
                                                        <span class="check"></span>
                                                        <span class="box"></span>
                                                    </label>
                                                </div>
                                                <div class="md-radio has-error">
                                                    <input type="radio" id="error" name="color_label" class="md-radiobtn" value="danger">
                                                    <label for="error">
                                                        <span></span>
                                                        <span class="check"></span>
                                                        <span class="box"></span>
                                                    </label>
                                                </div>
                                                <div class="md-radio has-info">
                                                    <input type="radio" id="info" name="color_label" class="md-radiobtn" value="info">
                                                    <label for="info">
                                                        <span></span>
                                                        <span class="check"></span>
                                                        <span class="box"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('order::vendor.order_statuses.form.success_status')}}
                                        </label>
                                        <div class="col-md-9">
                                            <input type="checkbox" class="make-switch" id="test" data-size="small" name="success_status">
                                            <div class="help-block"></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('order::vendor.order_statuses.form.failed_status')}}
                                        </label>
                                        <div class="col-md-9">
                                            <input type="checkbox" class="make-switch" id="test" data-size="small" name="failed_status">
                                            <div class="help-block"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- END CREATE FORM --}}
                        </div>
                    </div>

                    {{-- PAGE ACTION --}}
                    <div class="col-md-12">
                        <div class="form-actions">
                            @include('apps::vendor.layouts._ajax-msg')
                            <div class="form-group">
                                <button type="submit" id="submit" class="btn btn-lg blue">
                                    {{__('apps::vendor.buttons.add')}}
                                </button>
                                <a href="{{url(route('vendor.order-statuses.index')) }}" class="btn btn-lg red">
                                    {{__('apps::vendor.buttons.back')}}
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>
@stop
