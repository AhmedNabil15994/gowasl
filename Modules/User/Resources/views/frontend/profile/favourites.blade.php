@extends('apps::Frontend.layouts.app')

@section('content')
    <div class="container-fluid">

        <section class="page-head align-items-center text-center d-flex">
            <div class="container">
                <ul>
                    <li><a href="{{URL::to('/')}}"> {{__("apps::frontend.home")}} </a></li>/
                    <li class="active">{{__("apps::frontend.favorite")}}</li>
                </ul>
            </div>
        </section>
        <section class="filter-section">
            <div class="container">
                <div class="grid row">
                    @foreach($favourites as $offer)
                    <div class="grid-item col-lg-4 col-md-4 col-sm-12">
                        @php $offer->is_favorite = 1; @endphp
                    @include('offer::frontend.partials.offer-card',['offer'=>$offer,'page'=>'profile'])
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

    </div>
@endsection



@push('js')
@endpush
