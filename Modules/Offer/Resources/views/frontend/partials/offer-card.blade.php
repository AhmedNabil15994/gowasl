<div class="card border-0">
    <a href="{{ route('frontend.offers.show',['id'=>$offer->id]) }}" class="image-cotainer">
        <img src="{{asset($offer->main_image)}}" class="card-img-top rounded" alt="main_image">
        <div class="overlay"></div>
    </a>
    @auth
        <a href="{{ route('frontend.offers.toggleFavorite',['id'=>$offer->id]) }}" class="like-btn">
            @if($offer->is_favorite)
                <i class="bi bi-x-circle"></i>
            @else
                <i class="bi bi-heart-fill"></i>
            @endif
        </a>
    @endauth
    <div class="card-body">
        <a href="{{ route('frontend.offers.show',['id'=>$offer->id]) }}" class="card-title">
            {{$offer->title}}
        </a>
        <p class="card-text">
            {{$offer->discount_desc}}
        </p>
    </div>
</div>
