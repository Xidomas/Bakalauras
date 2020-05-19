@extends('layout')

@section('title', 'Nuoma')

@section('content')

<div class="breadcrumbs">
    <div class="container">
        <a href="/">Namai</a>
        <i class="fa fa-chevron-right breadcrumb-separator"></i>
        <span">Nuoma</span>
    </div>
</div>
<div class="rentOfferList-section container">
    <div class="rentOfferList-leftbar">
        <div class="rentOfferList-left-filter">
            <h3>Pagal Kategoriją:</h3>
            <ul>
                @foreach($categories as $category)
                    <a href="{{route('rentOfferList.index', [ 'category' => $category->slug, 'town' => request()->town])}}"><li class="{{setActiveCategory($category->slug)}}">{{$category->name}}</li></a>
                @endforeach
            </ul>
        </div>
        <div class="rentOfferList-left-filter">
            <h3>Pagal Vietovę:</h3>
            <ul>
                @foreach($towns as $town)
                    <a href="{{route('rentOfferList.index', ['category' => request()->category, 'town' => $town->slug])}}"><li class="{{setActiveTown($town->slug)}}">{{$town->name}}</li></a>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="rentOfferList-rightbar">
        <div class="rentOfferList-header">
            <h1>{{$categoryName}}</h1>
            <div class="rentOfferList-right-order">
                <div>
                    <strong> Kaina: </strong>
                    <a href="{{route('rentOfferList.index', ['category' => request()->category, 'town' => request()->town, 'sort' => 'low_high'])}}"> Nuo Pigiausio </a> |
                    <a href="{{route('rentOfferList.index', ['category' => request()->category, 'town' => request()->town, 'sort' => 'high_low'])}}"> Nuo Brangiausio </a>
                </div>
            </div>
        </div>
        <div class="rentOffers text-center">
            @forelse($rentOffers as $rentOffer)
                @if( $rentOffer-> quantity != 0)
                    <a href="{{route ('rentOfferList.show', $rentOffer->slug)}}">
                        <div class="rentOffer">
                            <img src="{{rentOfferImage($rentOffer->image)}}" alt="rentOffer Image">
                            <div class="rentOffer-name">{{$rentOffer -> name}}</div>
                            <div class="rentOffer-price">{{presentPrice($rentOffer -> price)}}</div>
                        </div>
                    </a>
                @endif
            @empty
                <div>Nuomos pasiūlymų nerasta!</div>
            @endforelse
        </div>
        <div class="spacer"></div>
        {{$rentOffers->appends(request()->input())->links()}}
    </div>
</div>

@endsection