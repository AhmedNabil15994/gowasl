<?php

namespace Modules\Offer\Repositories\Frontend;

use Illuminate\Support\Facades\DB;
use Modules\Offer\Entities\Offer;

class OfferRepository
{

    public function __construct(Offer $offer)
    {
        $this->offer = $offer;
    }

    public function getAll($request,$is_published=null){
        return $this->offer->where(function ($q) use ($request,$is_published){
            if(isset($request->city_id) && !empty($request->city_id)){
                $q->whereIn('city_id',$request->city_id);
            }
            if($is_published){
                $q->where('is_published',$is_published);
            }
        })->where('quantity','>=',1)
            ->when(auth()->check(), fn($query) => $query->isFavourite(auth()->id()))
        ->orderBy('id','asc')->paginate(15);
    }

    public function getOffer($id){
        $id = (int) $id;
        return $this->offer->when(auth()->check(), fn($query) => $query->isFavourite(auth()->id()))->findOrFail($id);
    }

    public function getByCategory($category_id,$id=null){
        return $this->offer->where([
                ['category_id',$category_id],
                ['id','!=',$id]
            ])->where('quantity','>=',1)->get();
    }

    public function userOffers(){
        return $this->offer
            ->when(auth()->check(), fn ($q) => $q->subscribed(auth()->id()))
            ->withCount('orderItems')
            ->whereHas(
                'orderItems',
                fn ($q) => $q
                    ->whereUserId(auth()->id())
                    ->notExpired()
                    ->successPay()
            )->orderBy('id', 'desc')->get();
    }
}
