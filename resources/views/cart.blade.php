@extends('layout')

@section('title', 'Krepšelis')

<script src="{{asset('js/app.js')}}"></script>

@section('content')

<div class="breadcrumbs">
    <div class="container">
        <a href="/">Namai</a>
        <i class="fa fa-chevron-right breadcrumb-separator"></i>
        <span>Krepšelis</span>
    </div>
</div>
<div class="cart-section container">
    @if (session()->has('success_message'))
        <div class="alert alert-success">
            {{ session()->get('success_message') }}
        </div>
    @endif
    @if(count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (Cart::count() > 0)
        <h2>{{ Cart::count() }} pasiūlymai krepšelyje</h2>
        <div class="cart-table">
            @foreach(Cart::content() as $rentOffer)
                <div class="cart-table-row">
                    <div class="cart-table-row-left">
                        <a href="{{route('rentOfferList.show', $rentOffer ->model->slug)}}"><img src="{{rentOfferImage($rentOffer->model ->image)}}" alt="item" class="cart-table-img"></a>
                        <div class="cart-item-details">
                            <div class="cart-table-item"><a href="{{route('rentOfferList.show', $rentOffer ->model->slug)}}">{{$rentOffer -> model -> name}}</a></div>
                            <div class="cart-table-description">{{$rentOffer -> model -> details}}</div>
                        </div>
                    </div>
                    <div class="cart-table-row-right">
                        <div class="cart-table-actions">
                        <form action="{{ route('cart.destroy', $rentOffer->rowId) }}" method="POST">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button type="submit" class ="cart-options">Pašalinti</button>
                        </form>
                        <form action="{{ route('cart.saveForLater', $rentOffer->rowId) }}" method="POST">
                            {{ csrf_field() }}
                            <button type="submit" class ="cart-options">Išsaugoti</button>
                        </form>
                        </div>
                        <div class="cart-table-quantity"><p>Kiekis:</p>
                            <div>
                                <select class="quantity" data-q="{{$rentOffer -> rowId}}" data-rentOfferQuantity="{{$rentOffer -> model -> quantity}}">
                                    @for($i = 1; $i < 5 + 1; $i++)
                                        <option {{$rentOffer ->qty == $i ? 'selected' : '' }}>{{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="cart-table-days"><p>Dienos:</p>
                            <div>
                                <select class="days" id ="days" data-d="{{$rentOffer -> rowId}}">
                                    @for($i = 1; $i < 10 + 1; $i++)
                                        @foreach($rentOffer->options as $day)
                                            <option {{$day == $i ? 'selected' : '' }}>{{$i}}</option>
                                        @endforeach
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="cart-table-price">{{presentPrice($rentOffer ->price)}}</div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="cart-totals">
            <div class="cart-totals-left">
                <div>
                    Pirminė kaina: <br>
                    Mokesčiai (15%): <br>
                    <span class="cart-totals-total">Galutinė kaina: </span>
                </div>
            </div>
            <div class="cart-totals-right">
                <div class="cart-totals-subtotal">
                    {{presentPrice(Cart::subtotal())}}<br>
                    {{presentPrice(Cart::tax())}}<br>
                    <span class="cart-totals-total">{{presentPrice(Cart::total())}}</span>
                </div>
            </div>
        </div>
        <div class="cart-buttons">
            <a href="{{route('rentOfferList.index')}}" class="cart-button-left">Tęsti pasiūlymų paiešką</a>
            <a href="{{route('checkout.index')}}" class="cart-button-right">Tęsti mokėjimą</a>
        </div>
    @else
        <h3>Krepšelis tuščias!</h3>
        <div style="margin-top:20px;"></div>
        <div class="cart-buttons">
            <a href="{{route('rentOfferList.index')}}" class = "cart-button-left">Tęsti pasiūlymų paiešką</a>
        </div>
        <div style="margin-bottom:20px;"></div>
    @endif
    @if (Cart::instance('saveForLater')->count() > 0)
        <h2>{{ Cart::instance('saveForLater')->count() }} išsaugoti pasiūlymai</h2>
        <div class="saved-for-later cart-table">
            @foreach(Cart::instance('saveForLater')->content() as $rentOffer)
                <div class="cart-table-row">
                    <div class="cart-table-row-left">
                        <a href="{{route('rentOfferList.show', $rentOffer ->model->slug)}}"><img src="{{rentOfferImage($rentOffer->model ->image)}}" alt="item" class="cart-table-img"></a>
                        <div class="cart-item-details">
                            <div class="cart-table-item"><a href="{{route('rentOfferList.show', $rentOffer ->model->slug)}}">{{$rentOffer -> model -> name}}</a></div>
                            <div class="cart-table-description">{{$rentOffer -> model -> details}}</div>
                        </div>
                    </div>
                    <div class="cart-table-row-right">
                        <div class="cart-table-actions">
                        <form action="{{ route('saveForLater.destroy', $rentOffer->rowId) }}" method="POST">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button type="submit" class ="cart-options">Pašalinti</button>
                        </form>
                        <form action="{{ route('saveForLater.switchToCart', $rentOffer->rowId) }}" method="POST">
                            {{ csrf_field() }}
                            <button type="submit" class ="cart-options">Perkelti į krepšelį</button>
                        </form>
                        </div>
                        <div class="cart-table-price">{{presentPrice($rentOffer -> model -> price)}}</div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <h3>Išsaugotų nuomos pasiūlymų nėra.</h3>
    @endif
</div>

@endsection

@section('extra-js')

<script>
    (function(){
        const quantity = document.querySelectorAll('.quantity')
        const days = document.querySelectorAll('.days')
        Array.from(quantity).forEach(function(element){
            element.addEventListener('change', function(){
                const id = element.getAttribute('data-q')
                const rentOfferQuantity = element.getAttribute('data-rentOfferQuantity')
                axios.patch(`/cart/q/${id}`, {
                    quantity: this.value,
                    rentOfferQuantity: rentOfferQuantity
                })
                .then(function (response) {
                    window.location.href='{{route('cart.index')}}';
                })
                .catch(function (error) {
                    console.log(error);
                    window.location.href='{{route('cart.index')}}';
                });
            })
        })
        Array.from(days).forEach(function(element){
            element.addEventListener('change', function(){
                const id = element.getAttribute('data-d')
                axios.patch(`/cart/d/${id}`, {
                    days: this.value,
                })
                .then(function (response) {
                    console.log(response);
                    window.location.href='{{route('cart.index')}}';
                })
                .catch(function (error) {
                    console.log(error);
                    window.location.href='{{route('cart.index')}}';
                });
            })
        })
    })();
</script>

@endsection