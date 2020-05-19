<?php

namespace App\Http\Controllers;

use App\rentOffer;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cart');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $duplicates = Cart::search(function($cartItem, $rowId) use ($request){
            return $cartItem -> id === $request->id;
        });
        if($request->quantity == 0)
        {
            return back();
        }
        if($duplicates->isNotEmpty()){
            return redirect()->route('cart.index')->with('success_message', 'Nuomos pasiūlymas jau yra jūsų krepšelyje!');
        }
        Cart::add($request -> id, $request -> name, 1, $request -> price, ['days' => '1'])
            ->associate('App\rentOffer');
            return redirect()-> route('cart.index')->with('success_message', 'Nuomos pasiūlymas įdėtas į krepšelį!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateq(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'quantity' => 'required|numeric|between:1,5'
        ]);
        if ($validator->fails()) {
            session()->flash('errors', collect(['Nuomos pasiūlymų kiekis turi būti tarp 1 ir 5!']));
            return response()->json(['success' => false], 400);
        }
        if ($request->quantity > $request->rentOfferQuantity ){
            session()->flash('errors', collect(['Nuomos pasiūlymų kiekis per didelis!']));
            return response()->json(['success' => false], 400);
        }
        Cart::update($id, ['qty' => $request -> quantity]);
        session()->flash('success_message', 'Nuomos pasiūlymų kiekis atnaujintas sekmingai!');
        return response()->json(['success' => true]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updated(Request $request, $id)
    {
        Cart::update($id, ['options' => ['days' => $request -> days]]);
        session()->flash('success_message', 'Dienų kiekis atnaujintos sekmingai!');
        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Cart::remove($id);
        return back()->with('success_message', "Nuomos pasiūlymas išimtas iš krepšelio!");
    }

    /**
     * Save for later cart.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function saveForLater($id)
    {
        $rentOffer = Cart::get($id);
        Cart::remove($id);
        $duplicates = Cart::instance('saveForLater')->search(function ($cartItem, $rowId) use ($id) {
            return $rowId === $id;
        });
        if ($duplicates->isNotEmpty()) {
            return redirect()->route('cart.index')->with('success_message', 'Nuomos pasiūlymas jau yra išsaugotas prisiminimuose!');
        }
        Cart::instance('saveForLater')->add($rentOffer -> id, $rentOffer -> name, 1, $rentOffer -> price)
            ->associate('App\rentOffer');
            return redirect()-> route('cart.index')->with('success_message', 'Nuomos pasiūlymas sekmingai išsaugotas prisiminimuose!');
    }
}