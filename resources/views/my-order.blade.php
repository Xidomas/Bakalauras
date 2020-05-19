@extends('layout')

@section('title', 'Mano užsakymas')

@section('content')

<div class="breadcrumbs">
    <div class="container">
        <a href="/">Namai</a>
        <i class="fa fa-chevron-right breadcrumb-separator"></i>
        <span>Mano užsakymai</span>
    </div>
</div>
<div class="container">
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
</div>
<div class="my-orders container">
<div class="my-orders-sidebar">
    <ul>
        <li><a href="{{ route('users.edit') }}">Mano profilis</a></li>
        <li class="active"><a href="{{ route('orders.index') }}">Mano užsakymai</a></li>
    </ul>
</div>
    <div class="my-orders-content">
        <div class="my-orders-header">
            <h1>Užsakymo ID: {{ $order->id }}</h1>
        </div>
        <div>
            <div class="my-orders-container">
                <div class="my-orders-header">
                    <div class="my-orders-header-items">
                        <div>
                            <div class="uppercase font-bold">Užsakymo ID: {{ $order->id }}</div>
                        </div>
                        <div>
                            <div class="uppercase font-bold">Galutinė kaina: {{ presentPrice($order->billing_total) }}</div>
                        </div>
                        <div>
                            <div class="uppercase font-bold">Užsakymas pateiktas: {{ presentDate($order->created_at) }}</div>
                        </div>
                    </div>
                </div>
                <div class="my-orders-rentOffers">
                    <table class="table" style="width:50%">
                        <tbody>
                            <tr>
                                <td>Vardas: </td>
                                <td>{{ $order->user->name }}</td>
                            </tr>
                            <tr>
                                <td>Adresas: </td>
                                <td>{{ $order->billing_address }}</td>
                            </tr>
                            <tr>
                                <td>Miestas: </td>
                                <td>{{ $order->billing_city }}</td>
                            </tr>
                            <tr>
                                <td>Pirminė kaina: </td>
                                <td>{{ presentPrice($order->billing_subtotal) }}</td>
                            </tr>
                            <tr>
                                <td>Mokesčiai: </td>
                                <td>{{ presentPrice($order->billing_tax) }}</td>
                            </tr>
                            <tr>
                                <td>Galutinė kaina: </td>
                                <td>{{ presentPrice($order->billing_total) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="my-orders-container">
                <div class="my-orders-header">
                    <div class="my-orders-header-items">
                        <div>
                            Užsakymo nuomos pasiūlymų sąrašas
                        </div>
                    </div>
                </div>
                <div class="my-orders-rentOffers">
                    @foreach ($rentOffers as $rentOffer)
                        <div class="my-orders-rentOffer-item">
                            <div><img src="{{rentOfferImage($rentOffer->image)}}" alt="rentOffers Image"></div>
                            <div>
                                <div>
                                    <a href="{{ route('rentOfferList.show', $rentOffer->slug) }}">{{ $rentOffer->name }}</a>
                                </div>
                                <div>Kaina dienai: {{ presentPrice($rentOffer->price) }}</div>
                                <div>Kiekis: {{ $rentOffer -> pivot -> quantity }}</div>
                                <div>Dienų kiekis: {{ $rentOffer -> pivot -> days }}</div>
                            </div>
                        </div>
                        <hr>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="spacer"></div>
    </div>
</div>

@endsection