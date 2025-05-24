<!DOCTYPE html>
<html lang="{{ locale() }}" dir="{{ is_rtl() }}">

    @if (is_rtl() == 'rtl')
        @include('apps::dashboard.layouts._head_rtl')
    @else
        @include('apps::dashboard.layouts._head_ltr')
    @endif
    <style>
        .package h5{
            margin: 5px;
            font-weight: bold;
        }
        .package_img{
            width: 100%;
            height: 100%;
        }
    </style>
    <body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white page-md">
        <div class="page-wrapper">


            <div class="clearfix"> </div>

            <div class="page-container">

                <div class="page-content-wrapper">
                    <div class="page-content">
                        <div class="row">
                            <form role="form" class="form-horizontal form-row-seperated" method="post" enctype="multipart/form-data" action="{{route('frontend.order.create')}}">
                                @csrf
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <div class="portlet light bordered">
                                            <div class="portlet-title">
                                                <div class="caption font-red-sunglo">
                                                    <i class="icon-settings font-red-sunglo"></i>
                                                    <span class="caption-subject bold uppercase">
                                                            {{__('order::frontend.user_details')}}
                                                        </span>
                                                </div>
                                            </div>
                                            <div class="portlet-body form">
                                                <div class="form-body">
                                                    @inject('packages','Modules\Package\Entities\Package')
                                                    {!! field()->text('name',__('user::dashboard.admins.create.form.name'))!!}
                                                    {!! field()->email('email',__('user::dashboard.admins.create.form.email'))!!}
                                                    {!! field()->text('mobile',__('user::dashboard.admins.create.form.mobile'))!!}
                                                    {!! field()->password('password',__('user::dashboard.admins.create.form.password'))!!}
                                                    {!! field()->password('confirm_password',__('user::dashboard.admins.create.form.confirm_password'))!!}
                                                    {!! field()->select('package_id',__('order::frontend.package'),
                                                            $packages->active()->pluck('title','id')->toArray() , (request()->get('package_id') ?? '')   )!!}
                                                    {!! field()->select('duration_type',__('order::frontend.duration_type'),
                                                            [1 => __('order::frontend.monthly'), 2 => __('order::frontend.annual')], (request()->get('duration_type') ?? (request()->has('package_id') ? 1 : 0)) ) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="subscription_data hidden">
                                            <div class="portlet light bordered">
                                                <div class="portlet-title">
                                                    <div class="caption font-red-sunglo">
                                                        <i class="icon-settings font-red-sunglo"></i>
                                                        <span class="caption-subject bold uppercase">
                                                            {{__('order::frontend.subscription_details')}}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="portlet-body form">
                                                    <div class="form-body" >
                                                        <div class="package">
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <img class="package_img" src="http://127.0.0.1:8000/storage/media/128/Screenshot-from-2023-11-01-13-50-23.png" alt="">
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <h3 class="package_title">Package 1</h3>
                                                                    <p class="package_dates">2023-11-08 - 2023-12-08</p>
                                                                </div>
                                                            </div>
                                                            <div class="row" style="margin-top: 25px;">
                                                                <div class="col-md-6">
                                                                    <h5>{{__('order::frontend.subtotal')}}</h5>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <b class="subtotal">12.000</b> {{__('apps::frontend.kd')}}
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <h5>{{__('order::frontend.discount')}}</h5>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <b class="discount">0.000</b> {{__('apps::frontend.kd')}}
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <h5>{{__('order::frontend.total')}}</h5>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <b class="total">12.000</b> {{__('apps::frontend.kd')}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="portlet light bordered">
                                                <div class="portlet-title">
                                                    <div class="caption font-red-sunglo">
                                                        <i class="icon-settings font-red-sunglo"></i>
                                                        <span class="caption-subject bold uppercase">
                                                            {{__('order::frontend.coupon')}}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="portlet-body form">
                                                    <div class="form-body">
                                                        {!! field()->text('code',__('order::frontend.coupon_code'))!!}
                                                        <button type="button" class="btn btn-lg blue applay_coupon">
                                                            {{__('order::frontend.apply_coupon')}}
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-actions">
                                            @include('apps::dashboard.layouts._ajax-msg')
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-lg blue">
                                                    {{__('order::frontend.checkout')}}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

            @include('apps::dashboard.layouts._footer')
        </div>

        @include('apps::dashboard.layouts._jquery')
        <script>
            $(function (){
                let price;
                function updatePrices(newPrice){
                    price = newPrice
                }


                function getOrderDetails(){
                    let package_id = $('[name="package_id"]').val();
                    let duration_type = $('[name="duration_type"]').val();
                    if(package_id && duration_type){
                        $.ajax({
                            url: "{{route('frontend.order.getOrderDetails')}}",
                            type: "get",
                            data: {
                                'package_id': package_id,
                                'duration_type': duration_type,
                            },
                            success: function (data){
                                $('.subscription_data').removeClass('hidden')
                                $('.package_img').attr('src',data.image);
                                $('.package_title').html(data.title);
                                $('.package_dates').html(data.start_date + ' - ' + data.end_date);
                                $('.total').html(data.price.toFixed(3));
                                $('.discount').html('0.000');
                                $('.subtotal').html(data.price.toFixed(3));
                                updatePrices(data.price)
                            },
                            error: function (error){
                                $('.subscription_data').addClass('hidden')
                                toastr['error'](error.responseJSON.message)
                            }
                        });
                    }
                }

                $('.applay_coupon').on('click',function (){
                    $.ajax({
                        url: "{{route('frontend.check_coupon')}}",
                        type: "post",
                        data: {
                            '_token': $('meta[name="csrf-token"]').attr('content'),
                            'code': $('input[name="code"]').val(),
                            'price': price,
                        },
                        success: function (data){
                            $('.total').html(data.total.toFixed(3));
                            $('.discount').html(data.coupon_value.toFixed(3));
                            toastr['success'](data.message)
                        },
                        error: function (error){
                            toastr['error'](error.responseJSON.message)
                        }
                    });
                });

                $('[name="package_id"]').on('change',function (){
                    getOrderDetails();
                });
                $('[name="duration_type"]').on('change',function (){
                    getOrderDetails();
                });

                @if(request()->has('package_id') && !empty(request()->get('package_id')))
                getOrderDetails();
                @endif

            });
        </script>
    </body>
</html>
