@extends('apps::Frontend.layouts.app')

@section('title',$category->title)
@section( 'content')
    <div class="container-fluid">
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="filters-button-group">
                    <button class="filter active" data-filter="*">
                        <span class="d-block">All</span>
                    </button>
                    @foreach($category->children as $child)
                    <button class="filter" data-filter=".f{{$child->id}}">
                        <span class="d-block">{{$child->title}}</span>
                    </button>
                    @endforeach
                </div>
            </div>
        </div>


{{--        <div class="section-block ads-grid d-desk">--}}
{{--            <div class="container-fluid">--}}
{{--                <div class="row justify-content-center">--}}
{{--                    <div class="col-md-12 col-12">--}}
{{--                        <a class="ads-block" href='#'>--}}
{{--                            <div class="img-block">--}}
{{--                                <img class="img-fluid" src="{{asset('frontend/assets/images/banner/ads1.jpg')}}" alt="" />--}}
{{--                            </div>--}}
{{--                        </a>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="section-block ads-grid d-mobile">--}}
{{--            <div class="container">--}}
{{--                <div class="home-products owl-carousel">--}}
{{--                    <div class="item">--}}
{{--                        <a class="ads-block" href='#'>--}}
{{--                            <div class="img-block">--}}
{{--                                <img class="img-fluid" src="{{asset('frontend/assets/images/banner/ads1.jpg')}}" alt="" />--}}
{{--                            </div>--}}
{{--                        </a>--}}
{{--                    </div>--}}
{{--                    <div class="item">--}}
{{--                        <a class="ads-block" href='#'>--}}
{{--                            <div class="img-block">--}}
{{--                                <img class="img-fluid" src="{{asset('frontend/assets/images/banner/ads2.jpg')}}" alt="" />--}}
{{--                            </div>--}}
{{--                        </a>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}

        <div class="grid row">
            <!-- -->
            @foreach($offers as $key=> $keyOffers)
                @foreach($keyOffers as $offer)
                <div class="grid-item col-lg-4 col-md-4 col-sm-6 f{{$key}} ">
                    @include('offer::frontend.partials.offer-card',['offer'=>$offer])
                </div>
                @endforeach
            @endforeach
        </div>

    </div>

@endsection
