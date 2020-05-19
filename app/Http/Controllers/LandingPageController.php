<?php

namespace App\Http\Controllers;

use App\rentOffer;
use App\Post;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rentOffers = rentOffer::where('featured', true)->take(4)->inRandomOrder()->get();
        $news = Post::orderBy('created_at', 'desc')->take(3)->get();
        return view('landingPage')-> with([
            'rentOffers' => $rentOffers,
            'news' => $news,
            ]);
    }
}