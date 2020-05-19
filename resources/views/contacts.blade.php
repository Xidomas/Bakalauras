@extends('layout')

@section('title', 'Kontaktai')

@section('content')

<div class="breadcrumbs">
    <div class="container">
        <a href="/">Namai</a>
        <i class="fa fa-chevron-right breadcrumb-separator"></i>
        <span>Kontaktai</span>
    </div>
</div>

<div class="contacts-section">
    <div class="container">
        <div class ="contacts-title"><h1>Kontaktai</h1></div>
        <p class="contacts-section-description"><span style="font-size:24px; font-weight:bold;">Su mumis galite susisiekti žemiau paminėtais kontaktais!*</span></p>
        <p class="contacts-section-description"><span style="font-weight:bold;">Gmail:</span> liftup@gmail.com</p>
        <p class="contacts-section-description"><span style="font-weight:bold;">Facebook:</span> liftup@facebook.com</p>
        <p class="contacts-section-description"><span style="font-weight:bold;">Twitter:</span> liftup@twitter.com</p>
        <p class="contacts-section-description"><span style="font-weight:bold;">Instagram:</span> liftup@instagram.com</p>
        <p class="contacts-section-description"><span style="font-size:12px;">*Į žinutes vėliausiai atsakoma per 48h.</span></p>
    </div>
</div>

@endsection