@extends('layout')

@section('title', 'Padėka')

@section('body-class', 'sticky-footer')

@section('content')

<div class="thank-you-section">
    <h1>Dekui kad naudojatės mūsų paslaugomis!</h1>
    <p>Užsakymo detalės išsiųstos paštu.</p>
    <div class="spacer"></div>
    <div>
        <a href="{{ url('/') }}" class="thank-you-section-button">Namai</a>
    </div>
</div>

@endsection