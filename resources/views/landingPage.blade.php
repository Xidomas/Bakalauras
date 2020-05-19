@extends('layout')

@section('title', 'Laisvalaikio transporto priemonių nuoma!')

@section('content')

<div class="landing-section">
    <div class="landing-img">
        <div class="landing-img-cover"></div>
    </div>
    <div class="landing-content">
        <h1>Lift Up</h1>
        <p>Tai Lietuvos laisvalaikio transporto priemonių nuoma užsiimančias įmones vienijanti, viena bendra plaforma, sukurta palengvinti tiek klientų tiek įmonių veiklą šioje nuomos rinkoje. Čia rasite didžiausią laisvalaikio transporto priemonių nuomos pasirinkimą kad ir kur bebūtumėte, smagiam ir turiningam laisvalaikiui, šventėms ir kitoms progoms. Ši siūlo puikų būdą pažinti Vilnių ar kitas Lietuvos apylinkes.</p>
        <div>
            <a href="{{route("news.index")}}" class="landing_button">Naujienos</a>
            <a href="{{route("rentOfferList.index")}}" class="landing_button">Nuomos pasiūlymai</a>
        </div>
    </div>
</div>
<div class="landing-news-section">
    <div class="container">
    <h1 class="text-center">Naujienos</h1>
        <p class="landing-news-description">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolore vitae nisi, consequuntur illum dolores cumque pariatur quis provident deleniti nesciunt officia est reprehenderit sunt aliquid possimus temporibus enim eum hic.Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolore vitae nisi, consequuntur illum dolores cumque pariatur quis provident deleniti nesciunt officia est reprehenderit sunt aliquid possimus temporibus enim eum hic.</p>
        <div class="landing-news-posts">
            @foreach($news as $new)
                <div class="landing-news-post">
                    <a href="/news/{{ $new->slug }}"><img src="{{newsImage($new->image)}}" alt="News Image"></a>
                    <a href="/news/{{ $new->slug }}"><h2 class="news-title">{{$new->title}}</h2></a>
                </div>
            @endforeach
        </div>
    </div>
</div>
<div class="landing-rentOffer-section">
    <div class="container">
        <h1 class="text-center">Mūsų paslaugos</h1>
        <p class="landing-rentOffer-description">Bendradarbiaudami su daugybę Lietuvos laisvalaikio transporto priemonių nuoma užsiimančių imonių, siūlome platų šių transporto priemonių pasirinkimą pagal jūsų poreikius. Padėsime ieškantiems transporto kelionėms tiek mieste, tiek miške.</p>
        <div class="landing-rentOffers">
            @foreach($rentOffers as $rentOffer)
                @if( $rentOffer-> quantity != 0)
                    <a href="{{route('rentOfferList.show', $rentOffer->slug)}}">
                        <div class="landing-rentOffer">
                            <img src="{{rentOfferImage($rentOffer->image)}}" alt="RentOffer Image">
                            <div class="landing-rentOffer-name">{{$rentOffer -> name}}</div>
                            <div class="landing-rentOffer-price">{{presentPrice($rentOffer -> price)}}</div>
                        </div>
                    </a>
                @endif
            @endforeach
        </div>
        <div class="landing-rentOffer-button">
            <a href="{{route('rentOfferList.index')}}">Peržiurėti daugiau pasiūlymų</a>
        </div>
    </div>
</div>

@endsection