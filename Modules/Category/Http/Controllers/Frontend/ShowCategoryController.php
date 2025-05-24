<?php

namespace Modules\Category\Http\Controllers\Frontend;

use Illuminate\Routing\Controller;
use Modules\Category\Entities\Category;
use Modules\Offer\Entities\Offer;
use Modules\Offer\Repositories\Frontend\OfferRepository;
use Illuminate\Http\Request;
class ShowCategoryController extends Controller
{
    public function __construct(OfferRepository $offer,Category $category)
    {
        $this->offer = $offer;
        $this->category = $category;
    }
    public function index(Request $request){
        $offers = $this->offer->getAll($request);
        return view('apps::Frontend.index',compact('offers'));
    }
    public function show(Category $category)
    {
        $ids = $category->children()->pluck('id');
        $ids = reset($ids);
        $ids[] = $category->id;
        $arr =[];
        foreach ($ids as $category_id) {
            $arr[$category_id] = Offer::where('category_id',$category_id)->get();
        }
        return view('category::frontend.categories.show', ['category' => $category->load('children'),'offers'=>$arr]);
    }
}
