@extends('apps::Frontend.layouts.app')
@push('css')
    @php
        $styles = [
           'layerslider',
        ];
    @endphp
    <style>
        .share-btn a{
            color: inherit;
        }
    </style>
@endpush
@section('content')
    <div class="container-fluid">

        <section class="page-head align-items-center text-center d-flex">
            <div class="container">
                <ul>
                    <li><a href="{{URL::to('/')}}"> {{__("apps::frontend.home")}} </a></li>/
                    <li><a href="{{route('frontend.home').'?category_id='.$offer->category_id}}"> {{$offer->category?->title}} </a></li>/
                    <li class="active">{{$offer->title}}</li>
                </ul>
            </div>
        </section>

        <section class="item-details">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="banner-section">
                            <div class="container p-0">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="banner-image big-banner single-property">
                                            <div class="image-wrapper">
                                                <a class="image-gallery" href="{{asset($offer->main_image)}}" title="11.jpg">
                                                    <img src="{{asset($offer->main_image)}}" class="img-fuild" alt="image" />
                                                </a>
                                            </div>
                                            <button class="btn share-btn {{ $offer->is_favorite ? 'active' : ''}}" type="button">
                                                <a href="{{ route('frontend.offers.toggleFavorite',['id'=>$offer->id]) }}"><i class="bi bi-heart-fill"></i></a>
                                            </button>
                                            <button class="btn share-btn share-img" type="button" data-toggle="modal" data-target="#share-modal">
                                                <img src="{{asset('frontend/assets/images/icons/share.png')}}" />
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-6 d-none d-md-block">
                                        <div class="row">
                                            @if(count($offer->images_arr))
                                            @foreach($offer->images_arr as $index)
                                            <div class="col-sm-6">
                                                <div class="banner-image small-banner">
                                                    <div class="image-wrapper">
                                                        <a class="image-gallery" href="{{$index ? asset($index) : ''}}" title="2.jpg">
                                                            <img src="{{$index ? asset($index) : ''}}" class="img-fuild" alt="image" />
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button class="gallery" type="button" data-toggle="modal" data-target="#slider-modal">
                                <i class="bi bi-grid-3x3-gap-fill"></i>
                                {{__('apps::frontend.show_all_photos')}}
                            </button>
                        </div>
                    </div>

                    <!-- title -->
                    <div class="col-md-8">
                        <div class="item-info">
                            <div class="item-title-info bb-1">
                                <h2 class="h3">
                                    {{$offer->title}}
                                </h2>
                                <ul class="list-inline number-list">
                                    <li class="list-inline-item bought-time">
                                        <i class="bi bi-dot"></i>
                                        <span>{{$offer->discount_desc}}</span>
                                    </li>
                                    <li class="list-inline-item bought-time">
                                        <span class="offers">{{$offer->discount_title}}  % {{__('apps::frontend.off')}}</span>
                                    </li>
                                    @if($offer->video)
                                    <li class="list-inline-item video mb-20">
                                        <a href="#video-modal" data-toggle="modal" data-target="#video-modal"><i class="ti-control-play"></i> {{__('apps::frontend.watch_video')}} </a>
                                    </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                        <div class="item-details bb-1 py-3">
                            <div class="discription-box">
                                <p>{{$offer->description}}</p>
                            </div>
                        </div>
                        <!-- feature -->
                        <div class="item-feature-info bb-1 py-3">
                            <h3 class="h4">
                                {{__('apps::frontend.details')}}:
                            </h3>
                            <ul class="list-unstyled feature-list">
                                @foreach(explode("\r\n",$offer->details) as $item)
                                <li class="feature-item">
                                    <i class="bi bi-chevron-double-right"></i>
                                    <p class="mb-0">{{$item}}</p>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        <!-- map -->
                        <div class="item-lcation py-3">
                            <iframe src="https://maps.google.com/maps?q={{$offer->lat}}, {{$offer->lng}}&z=10&output=embed" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>


                    <!-- Stiky colum -->
                    @if(auth()->check() && \Modules\Offer\Entities\Offer::checkSubscription($offer->id))
                        <div class="col-md-4">
                            <div class="sticky-top">
                                <div class="stiky-box p-3">
                                    <div class="check-form">
                                        <a href="tel:{{$offer->seller->mobile}}" class="btn btn-green btn-block my-2">{{__('apps::frontend.call')}}</a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    @else
                    <div class="col-md-4">
                        <div class="sticky-top">
                            <div class="stiky-box p-3">
                                <div class="price-box">
                                    <h3>
                                        <span> {{$offer->price}} {{__('apps::frontend.kd')}}</span>
                                    </h3>
                                </div>
                                <form class="check-form" method="get" action="{{ $offer->price ? route('frontend.cart.add',['id'=>$offer->id,'type'=>'offer']) : '#' }}">
                                    <div class="quantity text-center">
                                        <div class="buttons-added d-flex align-items-center justify-content-between">
                                            <button class="sign minus"><i class="ti-minus"></i></button>
                                            <div class="qty-text">
                                                <input type="text" min="1" max="{{$offer->user_max_uses}}" value="1"  name="qty"  title="Qty" class="input-text qty text" size="1">
                                            </div>
                                            <button class="sign plus"><i class="ti-plus"></i></button>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-gridient btn-block my-2">{{__('apps::frontend.add_to_cart')}}</button>
                                </form>
                            </div>

                        </div>
                    </div>
                    @endif
                </div>
            </div>
            <hr>
            @if((!auth()->check()) || (auth()->check() && !\Modules\Offer\Entities\Offer::checkSubscription($offer->id)))
            <div class="section-block ads-grid also-like">
                <div class="container">
                    <h4>{{__('apps::frontend.you_may_like')}} </h4>
                    <div class="product-like owl-carousel">
                        @foreach($related as $oneItem)
                        <div class="item">
                            @include('offer::frontend.partials.offer-card',['offer'=>$oneItem])
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </section>

    </div>
    @include('offer::frontend.partials.slider-modal')
    @include('offer::frontend.partials.share-modal')
    @include('offer::frontend.partials.video-modal')
@endsection



@push('js')
  @php
      $scripts = [
            'greensock','layerslider.transitions','layerslider.kreaturamedia.jquery',
        ];
  @endphp
  <script>
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
              }
          } else {
              if (min && (min == currentVal || currentVal < min)) {
                  $qty.val(min);
              } else if (currentVal > 0) {
                  $qty.val(currentVal - parseFloat(step));
              }
          }

          // Trigger change event
          $qty.trigger('change');
          e.preventDefault();
      });
  </script>
@endpush
