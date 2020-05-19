@extends('layout')

@section('title', 'Padėka')

@section('body-class', 'sticky-footer')

@section('content')

<div class="thank-you-section">
    <h1>Laisvalaikio transporto priemonės nuomos pasiūlymų kiekis atnaujintas!</h1>
    <p>Dekui kad naudojatės mūsų paslaugomis!</p>
    <div class="spacer"></div>
    <div>
        <a href="{{ url('/') }}" class="thank-you-section-button">Namai</a>
    </div>
</div>

@endsection