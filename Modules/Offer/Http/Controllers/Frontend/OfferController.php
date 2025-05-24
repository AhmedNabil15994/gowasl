<?php

namespace Modules\Offer\Http\Controllers\Frontend;

use Illuminate\Routing\Controller;
use Modules\Offer\Repositories\Frontend\OfferRepository;
use Modules\User\Repositories\Frontend\FavoriteRepository;

class OfferController extends Controller
{
    public function __construct(OfferRepository $offer,FavoriteRepository $fav)
    {
        $this->offer = $offer;
        $this->fav = $fav;
    }

    public function show($id){
        $offer   = $this->offer->getOffer($id);
        if(!$offer){
            abort(404);
        }
        $related = $this->offer->getByCategory($offer->category_id,$id);
        return view('offer::frontend.show',compact('offer','related'));
    }
    public function toggleFavorite($id){
        $user  = auth()->user();
        $offer   = $this->offer->getOffer($id);
        if(!$offer){
            abort(404);
        }
        $toggle =  $this->fav->toggleToCurrentUser($user, $id);
        return redirect()->back()->with(['status'=> 'success']);
    }
}
