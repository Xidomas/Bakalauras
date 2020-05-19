<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;

class SaveForLaterController extends Controller
{
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Cart::instance('saveForLater') -> remove($id);
        return back()->with('success_message', "Nuomos pasiūlymas išimtas iš krepšelio!");
    }

    /**
     * Switch to cart item from save for later.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function switchToCart($id)
    {
        $rentOffer = Cart::instance('saveForLater')->get($id);
        Cart::instance('saveForLater')->remove($id);
        
        $duplicates = Cart::instance('default')->search(function ($cartItem, $rowId) use ($id) {
            return $rowId === $id;
        });
        if ($duplicates->isNotEmpty()) {
            return redirect()->route('cart.index')->with('success_message', 'Nuomos pasiūlymas jau yra jūsų krepšelyje!');
        }
        Cart::instance('default')->add($rentOffer -> id, $rentOffer -> name, 1, $rentOffer -> price, ['days' => '1'])
            ->associate('App\rentOffer');
            return redirect()-> route('cart.index')->with('success_message', 'Nuomos pasiūlymas įdėtas į krepšelį!');
    }
}