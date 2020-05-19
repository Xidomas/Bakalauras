@extends('layout')

@section('title', $rentOffer-> name)

@section('content')

<div class="breadcrumbs">
    <div class="container">
        <a href="/">Namai</a>
        <i class="fa fa-chevron-right breadcrumb-separator"></i>
        <a href="{{route('rentOfferList.index')}}">Nuoma</a>
        <i class="fa fa-chevron-right breadcrumb-separator"></i>
        <span>{{$rentOffer-> name}}</span>
    </div>
</div>
<div class="rentOffer-section container">
    <div>
        <div class="rentOffer-section-image">
            <img src="{{rentOfferImage($rentOffer->image)}}" alt="rentOffer image" class="active" id="currentImage">
        </div>
        <div class="rentOffer-section-images">
            <div class="rentOffer-section-thumbnail selected">
                <img src="{{ rentOfferImage($rentOffer->image) }}" alt="rentOffer image">
            </div>
            @if ($rentOffer->images)
                @foreach (json_decode($rentOffer->images, true) as $image)
                    <div class="rentOffer-section-thumbnail">
                        <img src="{{ rentOfferImage($image) }}" alt="rentOffer image">
                    </div>
                @endforeach
            @endif
        </div>
    </div>
    <div class="rentOffer-section-information">
        <div class="rentOffer-section-title"><h1>{{$rentOffer-> name}}</h1></div>
        <div class="rentOffer-section-details">{{$rentOffer->details}}</div>
        <div class="rentOffer-section-price"><span style="font-weight:bold;">Kaina (parai): </span><span style="font-family: Arial; font-size:16px;">{{presentPrice($rentOffer -> price)}}</span></div>
        <div class="rentOffer-section-quantity"><span style="font-weight:bold;">Turimas kiekis: </span><span style="font-family: Arial; font-size:16px;">{{$rentOffer-> quantity}}</span></div>
        <div class="rentOffer-section-year"><span style="font-weight:bold;">Metai: </span><span style="font-family: Arial; font-size:16px;">{{$rentOffer->year}}</span></div>
        <div class="rentOffer-section-town"><span style="font-weight:bold;">Miestas: </span><span style="font-family: Arial; font-size:16px;">{{townName($rentOffer->town_id)}}</span></div>
        <div class="rentOffer-section-vendor"><span style="font-weight:bold;">Paslaugos tiekėjas: </span><span style="font-family: Arial; font-size:16px;">{{vendorName($rentOffer->vendor_id)}}</span></div>
        <div class="rentOffer-section-description" ><span style="font-weight:bold;">Papildomas aprašymas: </span><span style="font-family: Arial; font-size:16px;">{!!$rentOffer ->description!!}</span></div>
        <form action="{{route('cart.store')}}" method = "POST">
            {{ csrf_field() }}
            <input type="hidden" name="id" value="{{$rentOffer->id}}">
            <input type="hidden" name="name" value="{{$rentOffer->name}}">
            <input type="hidden" name="price" value="{{$rentOffer->price}}">
            <input type="hidden" name="quantity" value="{{$rentOffer->quantity}}">
            <button type ="submit" class="rentOffer-section-button">Dėti pasiūlymą į krepšelį</button>
        </form>
    </div>
</div>

@include('partials.might-like')

@endsection

@section('extra-js')

<script>
    (function(){
        const currentImage = document.querySelector('#currentImage');
        const images = document.querySelectorAll('.rentOffer-section-thumbnail');
        images.forEach((element) => element.addEventListener('click', thumbnailClick));
        function thumbnailClick(e) {
            currentImage.classList.remove('active');
            currentImage.addEventListener('transitionend', () => {
            currentImage.src = this.querySelector('img').src;
            currentImage.classList.add('active');
            })
            images.forEach((element) => element.classList.remove('selected'));
            this.classList.add('selected');
        }
    })();
</script>

@endsection