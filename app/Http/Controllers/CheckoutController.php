<?php

namespace App\Http\Controllers;

use App\Order;
use App\rentOffer;
use App\orderRentOffer;
use App\Mail\OrderPlacedUser;
use App\Mail\OrderPlacedVendor;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Illuminate\Support\Facades\Mail;
use Cartalyst\Stripe\Exception\CardErrorException;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Http\Requests\CheckoutRequest;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Cart::instance('default')->count() == 0) {
            return redirect()->route('rentOfferList.index');
        }
        if (auth()->user() && request()->is('guestCheckout')) {
            return redirect()->route('checkout.index');
        }
        $gateway = new \Braintree\Gateway([
            'environment' => config('services.braintree.environment'),
            'merchantId' => config('services.braintree.merchantId'),
            'publicKey' => config('services.braintree.publicKey'),
            'privateKey' => config('services.braintree.privateKey')
        ]);
        $paypalToken = $gateway->ClientToken()->generate();
        return view('checkout')->with([
            'paypalToken' => $paypalToken,
            'discount' => $this->getNumbers()->get('discount'),
            'newSubtotal' => $this->getNumbers()->get('newSubtotal'),
            'newTax' => $this->getNumbers()->get('newTax'),
            'newTotal' => $this->getNumbers()->get('newTotal'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CheckoutRequest $request)
    {
        if($this -> rentOffersAreNoLongerAvailable()){
            return back()-> withErrors('Atsiprašome, tačiau vienas iš krepšelyje esančių nuomos pasiūlymų nebegalioja!');
        }
        $contents = Cart::content()->map(function ($rentOffer) {
            return $rentOffer->model->slug.', '.$rentOffer->qty;
        })->values()->toJson();
        try {
            $charge = Stripe::charges()->create([
                'amount' => $this->getNumbers()->get('newTotal') / 100,
                'currency' => 'EUR',
                'source' => $request->stripeToken,
                'description' => 'Order',
                'receipt_email' => $request->email,
                'metadata' => [
                    'contents' => $contents,
                    'quantity' => Cart::instance('default')->count(),
                    'discount' => collect(session()->get('coupon'))->toJson(),
                ],
            ]);
            foreach (Cart::content() as $item) {
                $rentOffer = rentOffer::find($item->model->vendor_id);
                $vendorEmail = vendorEmail($rentOffer->vendor_id);
            }
            $order = $this->addToOrdersTables($request, null);
            foreach (Cart::content() as $item) {
                $day = 0;
                foreach($item->options as $rentdays){
                    $day = $rentdays;
                }
                $vendorOrder = ([
                    'order_id' => $item->id,
                    'billing_name' => $request->name,
                    'billing_email' => $request->email,
                    'rent_offer_id' => $item->model->id,
                    'name' => $item->name,
                    'quantity' => $item->qty,
                    'price' => $item->price,
                    'days' => $day,
                    'billing_total' => $this->getNumbers()->get('newTotal'),
                ]);
                Mail::send(new OrderPlacedVendor($vendorOrder, $vendorEmail));
                sleep(5);
            }
            Mail::send(new OrderPlacedUser($order));
            $this -> decreaseRentOfferQuantity();
            Cart::instance('default') -> destroy();
            session()->forget('coupon');
            return redirect()->route('confirmation.index')->with('success_message', 'Dekui! Jūsų mokėjimas sėkmingai priimtas!');
        } catch (CardErrorException $e) {
            return back()-> withErrors('Error! ' . $e->getMessage());
        }
    }

    protected function addToOrdersTables($request, $error)
    {
        $order = Order::create([
            'user_id' => auth()->user() ? auth()->user()->id : null,
            'billing_email' => $request->email,
            'billing_name' => $request->name,
            'billing_address' => $request->address,
            'billing_city' => $request->city,
            'billing_province' => $request->province,
            'billing_postalcode' => $request->postalcode,
            'billing_phone' => $request->phone,
            'billing_name_on_card' => $request->name_on_card,
            'billing_discount' => $this->getNumbers()->get('discount'),
            'billing_discount_code' => $this->getNumbers()->get('code'),
            'billing_subtotal' => $this->getNumbers()->get('newSubtotal'),
            'billing_tax' => $this->getNumbers()->get('newTax'),
            'billing_total' => $this->getNumbers()->get('newTotal'),
        ]);
        foreach (Cart::content() as $item) {
            $day = 0;
            foreach($item->options as $rentdays){
                $day = $rentdays;
            }
            orderRentOffer::create([
                'order_id' => $order->id,
                'rent_offer_id' => $item->model->id,
                'quantity' => $item->qty,
                'days' => $day,
            ]);
        }
        return $order;
    }

    protected function getNumbers(){
        $tax = config('cart.tax') / 100;
        $discount = session()->get('coupon')['discount'] ?? 0;
        $code = session()->get('coupon')['name'] ?? null;
        $newSubtotal = (Cart::subtotal() - $discount);
        if($newSubtotal < 0){
            $newSubtotal = 100;
        }
        $newTax = $newSubtotal * $tax;
        $newTotal = $newSubtotal + $newTax;
        return collect([
            'discount' => $discount,
            'code' => $code,
            'newSubtotal' => $newSubtotal,
            'newTax' => $newTax,
            'newTotal' => $newTotal,
        ]);
    }

    protected function decreaseRentOfferQuantity()
    {
        foreach (Cart::content() as $item) {
            $rentOffer = rentOffer::find($item->model->id);
            $rentOffer->update(['quantity' => $rentOffer->quantity - $item->qty]);
        }
    }

    protected function rentOffersAreNoLongerAvailable()
    {
        foreach (Cart::content() as $item) {
            $rentOffer = rentOffer::find($item->model->id);
            if($rentOffer -> quantity < $item->qty){
                return true;
            }
        }
        return false;
    }
}