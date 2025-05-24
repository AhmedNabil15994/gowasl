@extends('apps::Frontend.layouts.app')
@section('title', __('cart::frontend.show.title') )
@push('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
{{--  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/css/bootstrap-select.min.css" rel="stylesheet" />--}}
<link href="https://cdnjs.cloudflare.com/ajax/libs/Ladda/1.0.6/ladda-themeless.min.css" rel="stylesheet">
@endpush
@section('content')
    <div class="container-fluid">
        <section class="page-head align-items-center text-center d-flex">
            <div class="container">
                <ul>
                    <li><a href="{{URL::to('/')}}"> {{__("apps::frontend.home")}} </a></li>/
                    @if(count($items) == 1)
                        @php $first =array_values(reset($items))[0]; @endphp
                        <li><a href="{{route('frontend.categories.show',['category'=>$first['attributes']['product']['category_id']])}}">
                            {{$first['attributes']['product']['category']}} </a></li>/
                        <li><a href="{{route('frontend.offers.show',['id' => $first['attributes']['product']['id']])}}"> {{$first['attributes']['product']['title']}} </a></li>/
                    @endif
                    <li class="active">{{__('apps::frontend.checkout')}}</li>
                </ul>
            </div>
        </section>

        <section class="item-details">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="sticky-top">
                            <div class="stiky-box p-3">
                                <div class="price-box bb-1">
                                    <h3>
                                        <span>{{__('apps::frontend.order_summary')}}</span>
                                    </h3>
                                </div>
                                <div class="charge-fees bb-1  py-3">
                                    @foreach($items as $item)
                                    <div class="d-flex row  justify-content-between py-1">
                                        <div class="col-md-7 col-sm-12">
                                            <span>{{$item['name']}}</span>
                                        </div>
                                        <div class="col-md-2 col-sm-6">
                                            <span class="co-grey">{{$item['quantity']}}x</span>
                                        </div>
                                        <div class="col-md-3 col-sm-6">
                                            <span class="co-main">{{__('apps::frontend.kd')}} <b>{{$item['price']}}</b>  </span>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <div class="d-flex  justify-content-between  font-weight-bold py-3 total">
                                    <span>{{__('apps::frontend.total')}}</span>
                                    <span class="co-main">{{__('apps::frontend.kd')}} <b>{{ Cart::getTotal() }}</b></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="sticky-top">
                            <div class="stiky-box p-3">
                                <form class="d-flex mx-lg-auto">
                                    @csrf
                                    <input class="form-control" name="code" type="text" placeholder="{{__('apps::frontend.promo_code')}}">
                                    <button class="btn btn-info Redeem" type="button">
                                        {{__('apps::frontend.add')}}
                                    </button>
                                </form>
                            </div>
                            <form action="{{route('frontend.order.create')}}" method="post">
                                @csrf
                                <button type="submit" class="btn  btn-primary  mt-20 rounded-pill w-100">{{__('apps::frontend.proceed_to_payment')}}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@stop
@push('js')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Ladda/1.0.6/spin.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Ladda/1.0.6/ladda.min.js"></script>
  <script>
    $(function (){


        Ladda.bind( '.ladda-button' );
        function submitCourseForm(btn,id){
            $(btn).prop('disabled',true);
            var l = Ladda.create($(btn));
            l.start();
            $(`#${id}`).submit();
        }

        $('.Redeem').on('click',function(){
           $.ajax({
               type:"POST",
               url:"{{route('frontend.check_coupon')}}",
               data:{
                   '_token': $('meta[name="csrf-token"]').attr('content'),
                   'price': "{{Cart::getTotal()}}",
                   'code': $('input[name="code"]').val(),
               },
               success:function (data){
                   $('input[name="code"]').val('');
                   $('.total .co-main b').html(data.total)
               }
           });
        });

    })
  </script>

@endpush
