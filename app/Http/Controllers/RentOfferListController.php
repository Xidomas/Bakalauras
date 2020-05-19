<?php

namespace App\Http\Controllers;

use App\rentOffer;
use App\Category;
use App\Town;
use Illuminate\Http\Request;

class RentOfferListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pagination = 24;
        $categories = Category::all();
        $towns = Town::all();
        if(request()->category && request()->town){
            $categoryId = $categories->where('slug', request() -> category) ->first()->id;
            $townId = $towns->where('slug', request() -> town) ->first()->id;
            $rentOffers = rentOffer::where('category_id', $categoryId) -> where('town_id', $townId);
            $categoryName = $categories->where('slug', request() -> category) ->first()->name;
        }
        else if(request()->category){
            $categoryId = $categories->where('slug', request() -> category) ->first()->id;
            $rentOffers = rentOffer::where('category_id', $categoryId);
            $categoryName = $categories->where('slug', request() -> category) ->first()->name;
        }
        else if(request()->town){
            $townId = $towns->where('slug', request() -> town) ->first()->id;
            $rentOffers = rentOffer::where('town_id', $townId);
            $categoryName = 'Nuomos pasiulymai!';
        }
        else{
            $rentOffers = rentOffer::where('featured', true);
            $categoryName = 'Reklamuojami pasiūlymai!';
        }
        if(request()->sort =='low_high'){
            $rentOffers = $rentOffers -> orderBy('price')->paginate($pagination);
        }
        elseif(request()->sort =='high_low'){
            $rentOffers = $rentOffers -> orderBy('price','desc')->paginate($pagination);
        }
        else{
            $rentOffers = $rentOffers->paginate($pagination);
        }
        return view('rentOfferList')->with([
            'rentOffers' => $rentOffers,
            'categories' => $categories,
            'categoryName' => $categoryName,
            'towns' => $towns
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $rentOffer = rentOffer::where('slug', $slug)->firstOrFail();
        $mightLike = rentOffer::where('slug','!=', $slug)->inRandomOrder()->take(4)->get();
        return view('rentOffer')->with([
            'rentOffer' => $rentOffer,
            'mightLike' => $mightLike,
        ]);
    }
}