@extends('layout')

@section('title', 'Mokėjimas')

<script src="https://js.stripe.com/v3/"></script>
<script src="https://js.braintreegateway.com/web/dropin/1.22.1/js/dropin.min.js"></script>

@section('content')

<div class="container">
    @if (session()->has('success_message'))
        <div class="spacer"></div>
        <div class="alert alert-success">
            {{ session()->get('success_message') }}
        </div>
    @endif
    @if(count($errors) > 0)
        <div class="spacer"></div>
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{!! $error !!}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <h1 class="checkout-heading">Mokėjimas</h1>
    <div class="checkout-section">
        <div>
            <form action="{{route('checkout.store')}}" method = "POST" id="payment-form">
                {{csrf_field()}}
                <h2>Atsiskaitymo informacija:</h2>
                <div class="spacer"></div>
                <div class="form-group">
                    <label for="email">El. paštas:</label>
                    @if (auth()->user())
                        <input type="email" class="form-control" id="email" name="email" placeholder="El. paštas" value="{{auth()->user()->email}}" readonly>
                    @else
                        <input type="email" class="form-control" id="email" name="email" placeholder="El. paštas" value="" required>
                    @endif
                </div>
                <div class="form-group">
                    <label for="name">Vardas:</label>
                    <input type="text" class="form-control" id="name" name="name"placeholder="Vardas" value="" required>
                </div>
                <div class="form-group">
                    <label for="address">Adresas:</label>
                    <input type="text" class="form-control" id="address" name="address" placeholder="Adresas" value="" required>
                </div>
                <div class="half-form">
                    <div class="form-group">
                        <label for="city">Miestas:</label>
                        <input type="text" class="form-control" id="city" name="city" placeholder="Miestas" value="" required>
                    </div>
                    <div class="form-group">
                        <label for="province">Savivaldybė:</label>
                        <input type="text" class="form-control" id="province" name="province" placeholder="Savivaldybė" value="" required>
                    </div>
                </div>
                <div class="half-form">
                    <div class="form-group">
                        <label for="postalcode">Pašto kodas:</label>
                        <input type="text" class="form-control" id="postalcode" name="postalcode" placeholder="Pašto kodas" value="" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Tel. numeris:</label>
                        <input type="text" class="form-control" id="phone" name="phone" placeholder="Tel. numeris" value="" required>
                    </div>
                </div>
                <div class="spacer"></div>
                <h2>Mokėjimo detalės</h2>
                <div class="form-group">
                    <label for="name_on_card">Vardas ant kortelės:</label>
                    <input type="text" class="form-control" id="name_on_card" name="name_on_card" placeholder="Vardas ant kortelės" value="" required>
                </div>
                <div class="form-group">
                    <label for="card-element">
                        Kreditinė ar Diabetinė kortelė:
                    </label>
                    <div id="card-element"></div>
                    <div id="card-errors" role="alert"></div>
                </div>
                <div class="checkbox-group" style="text-align:center;">
                    <label for="checkbox">
                        Sutinku su nuomos <a href="{{route('rules.index')}}" style="color:blue;">taisyklėmis</a>:
                    </label>
                    <input type="checkbox" id="checkbox" required>
                </div>
                <div class="spacer"></div>
                <button type="submit" id ="complete-order" class="payment-form-button full-width">Užbaigti mokėjimą</button>
            </form>
            <div class="or">Arba</div>
            <div>
                <form method="post" id="paypal-payment-form" action="{{ route('checkout.paypal') }}">
                    {{csrf_field()}}
                    <section>
                        <div class="bt-drop-in-wrapper">
                            <div id="bt-dropin"></div>
                        </div>
                    </section>
                    <input id="nonce" name="payment_method_nonce" type="hidden" />
                </form>
            </div>
        </div>
        <div class="checkout-table-container">
            <h2>Jūsų nuomos užsakymai:</h2>
            <div class="checkout-table">
                @foreach (Cart::content() as $rentOffer)
                    <div class="checkout-table-row">
                        <div class="checkout-table-row-left">
                            <a href="{{route('rentOfferList.show', $rentOffer ->model->slug)}}"><img src="{{rentOfferImage($rentOffer->model ->image)}}" alt="item" class="checkout-table-img"></a>
                            <div class="checkout-item-details">
                                <div class="checkout-table-item"><a href="{{route('rentOfferList.show', $rentOffer ->model->slug)}}">{{$rentOffer -> model -> name}}</a></div>
                                <div class="checkout-table-description">{{$rentOffer -> model -> details}}</div>
                            </div>
                        </div>
                        <div class="checkout-table-row-right">
                            <div>
                                <p>Kiekis:</p>
                                <div>
                                    <div class="checkout-table-quantity">{{$rentOffer -> qty}}</div>
                                </div>
                            </div>
                            <div>
                                <p>Dienos:</p>
                                <div>
                                    @foreach($rentOffer->options as $day)
                                        <div class="checkout-table-quantity">{{$day}}</div>
                                    @endforeach  
                                </div>
                            </div>
                            <div class="checkout-table-price">{{presentPrice($rentOffer -> model -> price)}}</div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="checkout-totals">
                <div class="checkout-totals-left">
                    Pirminė kaina: <br>
                    @if(session()->has('coupon'))
                        Nuolaida ({{ session()->get('coupon')['name']}}):
                        <form action="{{ route('coupon.destroy') }}" method="POST" style="display:inline">
                            {{ csrf_field() }}
                            {{ method_field('delete') }}
                            <button type="submit" style="font-size:14px; border:none;">Pašalinti</button>
                            <br>
                        </form>
                        <hr>
                        Nauja pirminė kaina:
                        <br>
                    @endif
                    Mokesčiai ({{config('cart.tax')}}%): <br>
                    <span class="checkout-totals-total">Galutinė kaina:</span>
                </div>
                <div class="checkout-totals-right">
                    {{presentPrice(Cart::subtotal())}}<br>
                    @if(session()->has('coupon'))
                        - {{presentPrice($discount)}}<br>
                        <hr>
                        {{presentPrice($newSubtotal)}}<br>
                    @endif
                    {{presentPrice($newTax)}}<br>
                    <span class="checkout-totals-total">{{presentPrice($newTotal)}}</span>
                </div>
            </div>
            @if(!session()->has('coupon'))
                <div class="have-code">Turite kuponą?</div>
                <div class="have-code-container">
                    <form action="{{route('coupon.store')}}" method="POST">
                        {{csrf_field()}}
                        <input name="coupon_code" id="coupon_code" type="text">
                        <button type="submit" class="checkout-button">Aktyvuoti</button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>

@endsection

@section('extra-js')

<script>
    (function(){
        // Create a Stripe client.
        var stripe = Stripe('pk_test_4umI11b3DsYrWQK1NZ8kmObB00PiUsnp33');
        // Create an instance of Elements.
        var elements = stripe.elements();
        // Custom styling can be passed to options when creating an Element.
        // (Note that this demo uses a wider set of styles than the guide below.)
        var style = {
        base: {
        color: '#32325d',
        fontFamily: '"Roboto", "Helvetica Neue", Helvetica, sans-serif',
        fontSmoothing: 'antialiased',
        fontSize: '16px',
        '::placeholder': {
            color: '#aab7c4'
        }
        },
        invalid: {
        color: '#fa755a',
        iconColor: '#fa755a'
        }
        };
        // Create an instance of the card Element.
        var card = elements.create('card', {
        style: style,
        hidePostalCode: true
        });
        // Add an instance of the card Element into the `card-element` <div>.
        card.mount('#card-element');
        // Handle real-time validation errors from the card Element.
        card.addEventListener('change', function(event) {
        var displayError = document.getElementById('card-errors');
        if (event.error) {
        displayError.textContent = event.error.message;
        } else {
        displayError.textContent = '';
        }
        });
        // Handle form submission.
        var form = document.getElementById('payment-form');
        form.addEventListener('submit', function(event) {
        event.preventDefault();
        document.getElementById('complete-order').disabled = true;
        var options = {
            name: document.getElementById('name_on_card').value,
            address_line1: document.getElementById('address').value,
            address_city: document.getElementById('city').value,
            address_state: document.getElementById('province').value,
            address_zip: document.getElementById('postalcode').value
        }
        stripe.createToken(card, options).then(function(result) {
        if (result.error) {
            // Inform the user if there was an error.
            var errorElement = document.getElementById('card-errors');
            errorElement.textContent = result.error.message;
            document.getElementById('complete-order').disabled = true;
        } else {
            // Send the token to your server.
            stripeTokenHandler(result.token);
        }
        });
        });
        // Submit the form with the token ID.
        function stripeTokenHandler(token) {
        // Insert the token ID into the form so it gets submitted to the server
        var form = document.getElementById('payment-form');
        var hiddenInput = document.createElement('input');
        hiddenInput.setAttribute('type', 'hidden');
        hiddenInput.setAttribute('name', 'stripeToken');
        hiddenInput.setAttribute('value', token.id);
        form.appendChild(hiddenInput);
        //Submit the form
        form.submit();
        }
        // PayPal Stuff
        var form = document.querySelector('#paypal-payment-form');
        var client_token = "{{ $paypalToken }}";
        braintree.dropin.create({
            authorization: client_token,
            selector: '#bt-dropin',
            paypal: {
            flow: 'vault'
            }
        }, function (createErr, instance) {
            if (createErr) {
            console.log('Create Error', createErr);
            return;
            }
            // remove credit card option
            var elem = document.querySelector('.braintree-option__card');
            elem.parentNode.removeChild(elem);
            form.addEventListener('submit', function (event) {
                event.preventDefault();
                instance.requestPaymentMethod(function (err, payload) {
                    if (err) {
                    console.log('Request Payment Method Error', err);
                    return;
                    }
                    // Add the nonce to the form and submit
                    document.querySelector('#nonce').value = payload.nonce;
                    form.submit();
                });
            });
        });
    })();
</script>

@endsection