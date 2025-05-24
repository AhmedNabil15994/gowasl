@extends('apps::dashboard.layouts.app')
@section('css')
    <style>
        textarea{
            min-height: 150px;
            max-height: 200px;
        }
    </style>
@endsection
@section('title', __('offer::dashboard.offers.routes.update'))
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
                        <a href="{{ url(route('dashboard.offers.index')) }}">
                            {{ __('offer::dashboard.offers.routes.index') }}
                        </a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="#">{{ __('offer::dashboard.offers.routes.update') }}</a>
                    </li>
                </ul>
            </div>

            <h1 class="page-title"></h1>
            <div class="row">
                <form id="updateForm" page="form" class="form-horizontal form-row-seperated" method="post"
                    enctype="multipart/form-data" action="{{ route('dashboard.offers.update', $model->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="col-md-12">

                        {{-- RIGHT SIDE --}}
                        <div class="col-md-3">
                            <div class="panel-group accordion scrollable" id="accordion2">
                                <div class="panel panel-default">
                                    {{-- <div class="panel-heading">
                                        <h4 class="panel-title"><a class="accordion-toggle"></a></h4>
                                    </div> --}}
                                    <div id="collapse_2_1" class="panel-collapse in">
                                        <div class="panel-body">
                                            <ul class="nav nav-pills nav-stacked">
                                                <li class="active">
                                                    <a href="#global_setting" data-toggle="tab">
                                                        {{ __('offer::dashboard.offers.form.tabs.general') }}
                                                    </a>
                                                </li>

                                                <li class="">
                                                    <a href="#category" data-toggle="tab">
                                                        {{ __('offer::dashboard.offers.form.tabs.category') }}
                                                    </a>
                                                </li>

                                                <li class="">
                                                    <a href="#use" data-toggle="tab">
                                                        {{ __('offer::dashboard.offers.form.tabs.use') }}
                                                    </a>
                                                </li>

                                                <li class="">
                                                    <a href="#media" data-toggle="tab">
                                                        {{ __('offer::dashboard.offers.form.tabs.media') }}
                                                    </a>
                                                </li>

                                                <li class="">
                                                    <a href="#location" data-toggle="tab">
                                                        {{ __('offer::dashboard.offers.form.tabs.location') }}
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
                                    {{-- <h3 class="page-title">{{__('coupon::dashboard.coupons.form.tabs.general')}}</h3> --}}
                                    <div class="col-md-10">

                                        <div>
                                            <div class="tabbable">
                                                <ul class="nav nav-tabs bg-slate nav-tabs-component">
                                                    @foreach (config('laravellocalization.supportedLocales') as $code => $lang)
                                                        <li class=" {{ ($code == locale()) ? 'active' : '' }}">
                                                            <a href="#colored-rounded-tab-general-{{$code}}" data-toggle="tab" aria-expanded="false"> {{ $lang['native'] }}
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>

                                            <div class="tab-content">
                                                @foreach (config('laravellocalization.supportedLocales') as $code => $lang)
                                                    <div class="tab-pane @if ($code == locale()) active @endif"
                                                         id="colored-rounded-tab-general-{{ $code }}">
                                                        <div class="form-group">
                                                            <label class="col-md-2">
                                                                {{ __('offer::dashboard.offers.form.title') }}
                                                            </label>
                                                            <div class="col-md-9">
                                                                <input type="text" name="title[{{ $code }}]"
                                                                       class="form-control"
                                                                       data-name="title.{{ $code }}" value="{{$model->getTranslations('title')[$code]}}">
                                                                <div class="help-block"></div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-2">
                                                                {{ __('offer::dashboard.offers.form.description') }}
                                                            </label>
                                                            <div class="col-md-9">
                                                                <textarea name="description[{{ $code }}]"
                                                                          class="form-control"
                                                                          data-name="description.{{ $code }}">{{$model->getTranslations('description')[$code] ?? ''}}</textarea>
                                                                <div class="help-block"></div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="col-md-2">
                                                                {{ __('offer::dashboard.offers.form.discount_desc') }}
                                                            </label>
                                                            <div class="col-md-9">
                                                                <input type="text" name="discount_desc[{{ $code }}]"
                                                                       class="form-control"
                                                                       data-name="discount_desc.{{ $code }}" value="{{$model->getTranslations('discount_desc')[$code]}}">
                                                                <div class="help-block"></div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-2">
                                                                {{ __('offer::dashboard.offers.form.details') }}
                                                            </label>
                                                            <div class="col-md-9">
                                                                <textarea name="details[{{ $code }}]"
                                                                          class="form-control"
                                                                          data-name="details.{{ $code }}">{{$model->getTranslations('details')[$code] ?? ''}}</textarea>
                                                                <div class="help-block"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                                <div class="form-group">
                                                    <label class="col-md-2">
                                                        {{ __('offer::dashboard.offers.form.discount_title') }}
                                                    </label>
                                                    <div class="col-md-9">
                                                        <input type="text" name="discount_title"
                                                               class="form-control"
                                                               data-name="discount_title" value="{{$model->discount_title}}">
                                                        <div class="help-block"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{ __('offer::dashboard.offers.form.quantity') }}
                                            </label>
                                            <div class="col-md-9">
                                                <input type="number" class="form-control" id="quantity" data-size="small" value="{{$model->quantity}}" name="quantity">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{ __('offer::dashboard.offers.form.price') }}
                                            </label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" id="price" data-size="small" value="{{$model->price}}" name="price">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{ __('offer::dashboard.offers.form.seller') }}
                                            </label>
                                            <div class="col-md-9">
                                                <select name="seller_id" class="form-control select2">
                                                    <option value=""></option>
                                                    @foreach($sellers as $seller)
                                                        <option value="{{$seller->id}}" {{$model->seller_id == $seller->id ? 'selected' : ''}}>{{$seller->name}}</option>
                                                    @endforeach
                                                </select>
                                                <div class="help-block"></div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{ __('offer::dashboard.offers.form.status') }}
                                            </label>
                                            <div class="col-md-9">
                                                <input type="checkbox" class="make-switch" id="test" data-size="small"
                                                       name="status" {{$model->status ? 'checked' : ''}}>
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{ __('offer::dashboard.offers.form.is_published') }}
                                            </label>
                                            <div class="col-md-9">
                                                <input type="checkbox" class="make-switch" id="is_published" data-size="small"
                                                       name="is_published" {{$model->is_published ? 'checked' : ''}}>
                                                <div class="help-block"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade in" id="category">
                                    <div class="tab-content">
                                        <div class="tab-pane active fade in" id="category_level">
                                            <h3 class="page-title">{{ __('category::dashboard.categories.form.tabs.category_level') }}</h3>
                                            <input type="hidden" id="root_category" name="category_id">
                                            <div id="jstree">
                                                @include('category::dashboard.tree.categories.edit',['mainCategories' => $mainCategories,'hasRelation' => 1,])
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade in" id="use">
                                    <div class="col-md-10">
                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{ __('offer::dashboard.offers.form.start_at') }}
                                            </label>
                                            <div class="col-md-9">
                                                <div class="input-group input-medium date time date-picker"
                                                     data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
                                                    <input type="text" id="offer-form" class="form-control"
                                                           name="start_at" data-name="start_at" value="{{$model->start_at}}">
                                                    <span class="input-group-btn">
                                                        <button class="btn default" type="button">
                                                            <i class="fa fa-calendar"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{ __('offer::dashboard.offers.form.expired_at') }}
                                            </label>
                                            <div class="col-md-9">
                                                <div class="input-group input-medium date time date-picker"
                                                     data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
                                                    <input type="text" id="offer-form" class="form-control"
                                                           name="expired_at" data-name="expired_at" value="{{$model->expired_at}}">
                                                    <span class="input-group-btn">
                                                        <button class="btn default" type="button">
                                                            <i class="fa fa-calendar"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{ __('offer::dashboard.offers.form.user_max_uses') }}
                                                <i class="fa fa-question-circle tooltips"
                                                   data-original-title="{{ __('offer::dashboard.offers.form.tooltips.user_max_uses_tooltip') }}"></i>
                                            </label>
                                            <div class="col-md-9">
                                                <input type="number" name="user_max_uses" class="form-control"
                                                       data-name="user_max_uses" value="{{ $model->user_max_uses }}">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="tab-pane fade in" id="media">
                                    <div class="tab-content">
                                        <div class="tab-pane active fade in" id="mediaDiv">
                                            {!! field()->file('main_image',__('offer::dashboard.offers.form.image'), $model->id ? $model->main_image:'')!!}
                                            {!! field()->file('images[]',__('offer::dashboard.offers.form.images'), $model->id ? $model->images :'' , ['multiple'=>true])!!}
                                            {!! field()->file('video',__('offer::dashboard.offers.form.video'), $model->id ? $model->video :'')!!}
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade in" id="location">
                                    <div class="col-md-10">
                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{ __('offer::dashboard.offers.form.city') }}
                                            </label>
                                            <div class="col-md-9">
                                                <select name="city_id" class="form-control select2">
                                                    <option value=""></option>
                                                    @foreach($cities as $city)
                                                        <option value="{{$city->id}}" {{$city->id == $model->city_id ? 'selected' :""}}>{{$city->title}}</option>
                                                    @endforeach
                                                </select>
                                                <div class="help-block"></div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{ __('offer::dashboard.offers.form.state') }}
                                            </label>
                                            <div class="col-md-9">
                                                <select name="state_id" class="form-control select2">
                                                    <option value=""></option>
                                                    @foreach($states as $state)
                                                        <option value="{{$state->id}}" {{$state->id == $model->state_id ? 'selected' : ''}}>{{$state->title}}</option>
                                                    @endforeach
                                                </select>
                                                <div class="help-block"></div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{ __('offer::dashboard.offers.form.location_on_map') }}
                                            </label>
                                            <div class="col-md-9">
                                                <div id="somecomponent" style="width: 100%; height: 400px;"></div>
                                                <input type="hidden" name="lat" value="{{$model->lat}}">
                                                <input type="hidden" name="lng" value="{{$model->lng}}">
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
                                @include('apps::dashboard.layouts._ajax-msg')
                                <div class="form-group">
                                    <button type="submit" id="submit" class="btn btn-lg green">
                                        {{ __('apps::dashboard.buttons.edit') }}
                                    </button>
                                    <a href="{{ url(route('dashboard.offers.index')) }}" class="btn btn-lg red">
                                        {{ __('apps::dashboard.buttons.back') }}
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

@section('scripts')
    <style>
        .bootstrap-switch{
            max-height: 32px;
        }
        #somecomponent div:nth-child(2){
            /*z-index: -1  !important;*/
        }
    </style>
    <script type="text/javascript" src='http://maps.google.com/maps/api/js?sensor=false&libraries=places'></script>
    <script src="{{asset('admin/js/locationpicker.jquery.js')}}"></script>
    <script type="text/javascript">
        $(function () {
            $('#somecomponent').locationpicker({
                location: {latitude:  "{{$model->lat ?? '29.3117'}}",  longitude: "{{$model->lng ?? '47.4818'}}"},
                zoom: 8,
                onchanged: function(currentLocation, radius, isMarkerDropped) {
                    $('input[name="lat"]').val(currentLocation.latitude);
                    $('input[name="lng"]').val(currentLocation.longitude);
                }
            });
            $('#jstree').jstree({

            });

            $('#jstree').on("changed.jstree", function (e, data) {
                $('#root_category').val(data.selected);
            });

            $('select[name="city_id"]').on('change',function (){
                if($(this).val()){
                    $.ajax({
                        type:'get',
                        url: "{{route('dashboard.states.getByCityId',['city_id'=>':id'])}}".replace(':id',$(this).val()),
                        success: function (data){
                            $('select[name="state_id"]').empty().select2('destroy');
                            let x = '<option value=""></option>';
                            $.each(data,function(index,item){
                                x+="<option value='"+item.id+"'>"+item.title+"</option>";
                            });
                            $('select[name="state_id"]').append(x).select2();
                        },
                    });
                }
            });
        });
    </script>

@endsection
