@extends('apps::Frontend.layouts.app')
@section('title', __('cart::frontend.show.title') )
@push('css')
@endpush
@section('content')


    <div class="container-fluid">
        <section class="page-head align-items-center text-center d-flex">
            <div class="container">
                <ul>
                    <li><a href="{{URL::to('/')}}"> {{__("apps::frontend.home")}} </a></li>/
                    <li class="active">{{__("apps::frontend.cart")}}</li>
                </ul>
            </div>
        </section>

        @if (count($items))
        <section class="item-details">
            <div class="container">
                <div class="row justify-content-between">
                    <div class="col-md-8">
                        <div class="cart-list">
                            @foreach($items as $item)
                            <div class="cart-item">
                                <div class="d-flex align-items-center">
                                    <div class="img-block">
                                        <img src="{{asset($item['attributes']['image'])}}" alt="">
                                    </div>
                                    <div>
                                        <h3><a href="{{route('frontend.offers.show',['id' =>$item['id']])}}">{{$item['name']}}</a></h3>
                                        <span class="pro-price">{{__('apps::frontend.kd')}} <b> {{$item['price']}} </b> </span>
                                    </div>
                                </div>
                                <div class="quantity text-center">
                                    <div class="buttons-added d-flex align-items-center justify-content-between">
                                        <button class="sign minus" data-area="{{$item['price']}}" data-target="{{$item['attributes']['item_id']}}"><i class="ti-minus"></i></button>
                                        <div class="qty-text">
                                            <input type="text" max="{{$item['attributes']['product']['user_max_uses']}}" value="{{$item['quantity']}}" title="Qty" class="input-text qty text" size="1">
                                        </div>
                                        <button class="sign plus" data-area="{{$item['price']}}" data-target="{{$item['attributes']['item_id']}}"><i class="ti-plus"></i></button>
                                    </div>
                                </div>
                                <div class="cart-options d-flex">
                                    <a class="delete-item btn" href="{{route('frontend.cart.remove',[$item->attributes->type, $item->attributes->item_id])}}"><i class="ti-close"></i></a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="sticky-top">
                            <div class="stiky-box p-3">
                                <div class="d-flex  justify-content-between  font-weight-bold py-3">
                                    <span>{{__('apps::frontend.total')}}</span>
                                    <span class="co-main"> {{__('apps::frontend.kd')}} <b>{{ Cart::getTotal() }} </b></span>
                                </div>
                                <a href="{{route('frontend.cart.checkout')}}" class="btn  btn-primary  mt-20 rounded-pill w-100">{{__('apps::frontend.checkout')}}</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    @else
    <div class="inner-page">
        <div class="container">
            <div class="order-done text-center">
                <img class="img-fluid" src="assets/images/icons/reserved.png" alt="" />
                <h1>{{__('apps::frontend.cart_empty')}}</h1>
                <p>{{__('apps::frontend.no_items')}}</p>
                <a href="{{route('frontend.categories.index')}}" class="btn  btn-primary  mt-20 rounded-pill w-100">{{__('apps::frontend.browse')}}</a>
            </div>
        </div>
    </div>
    @endif
@stop
@push('js')
  <script>
    $(function (){
        $('.delete-item').on('click',function (){
            $(this).parents('.cart-item').remove()
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).on('click', '.quantity .plus, .quantity .minus', function (e) {
            var $qty = $(this).closest('.quantity').find('.qty'),
                currentVal = parseFloat($qty.val()),
                max = parseFloat($qty.attr('max')),
                min = parseFloat($qty.attr('min')),
                step = $qty.attr('step');
            // Format values
            if (!currentVal || currentVal === '' || currentVal === 'NaN')
                currentVal = 0;
            if (max === '' || max === 'NaN')
                max = '';
            if (min === '' || min === 'NaN')
                min = 0;
            if (step === 'any' || step === '' || step === undefined || parseFloat(step) === 'NaN')
                step = 1;
            // Change the value
            if ($(this).is('.plus')) {
                if (max && (max == currentVal || currentVal > max)) {
                    $qty.val(max);
                } else {
                    $qty.val(currentVal + parseFloat(step));
                    $.ajax({
                        type: "get",
                        url: "{{route('frontend.cart.add',['id'=> ':id','type'=>'offer'])}}".replace(':id',$(this).data('target')),
                        data:{'qty':  currentVal + parseFloat(step)},
                        success: function (){window.location.reload()}
                    })
                }
            } else {
                if (min && (min == currentVal || currentVal < min)) {
                    $qty.val(min);
                } else if (currentVal > 0) {
                    $qty.val(currentVal - parseFloat(step));
                    $.ajax({
                        type: "get",
                        url: "{{route('frontend.cart.add',['id'=> ':id','type'=>'offer'])}}".replace(':id',$(this).data('target')),
                        data:{'qty':  currentVal - parseFloat(step),'replace':true},
                        success: function (){window.location.reload()}
                    })
                }
            }

            // Trigger change event
            $qty.trigger('change');
            $(this).parents('.cart-item').find('.pro-price').children('b').html($(this).siblings('.qty-text').children('.qty').val() * $(this).data('area'))
            e.preventDefault();
            if($qty.val() == 0){
                $(this).closest('.delete-item').trigger('click')
                $.ajax({
                    type: "get",
                    url: "{{route('frontend.cart.remove',['id'=> ':id','type'=>'offer'])}}".replace(':id',$(this).data('target')),
                    success: function (){window.location.reload()}
                })
            }
        });
    })
  </script>

@endpush
