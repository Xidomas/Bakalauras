<div class="might-like-section">
    <div class="container">
        <h2>Taip pat gali patikti:</h2>
        <div class="might-like-grid">
            @foreach($mightLike as $rentOffer)
                <a href="{{route('rentOfferList.show', $rentOffer->slug)}}" class="might-like-rentOffer">
                    <img src="{{rentOfferImage($rentOffer->image)}}" alt="rentOffer image">
                    <div class="might-like-rentOffer-name">{{$rentOffer -> name}}</div>
                    <div class="might-like-rentOffer-price">{{presentPrice($rentOffer -> price)}}</div>
                </a>
            @endforeach
        </div>
    </div>
</div>
