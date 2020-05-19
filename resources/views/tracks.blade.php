@extends('layout')

@section('title', 'Trasos')

@section('content')

<div class="breadcrumbs">
    <div class="container">
        <a href="/">Namai</a>
        <i class="fa fa-chevron-right breadcrumb-separator"></i>
        <span>Trasos</span>
    </div>
</div>

<div class="track-section">
    <div class="container">
        <div class ="tracks-title"><h1>Trasos</h1></div>
        <p class="track-description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur tempor leo et mauris hendrerit dignissim. Fusce dictum vehicula purus vel hendrerit. Cras dui erat, elementum sit amet ullamcorper id, rhoncus tempus ante. Nullam porta risus non orci viverra vehicula. Mauris tempor tincidunt nisl. Ut nec ornare risus. Fusce a malesuada risus. Vivamus interdum malesuada tortor, at semper odio laoreet in. Nullam viverra tortor eu neque sagittis, vitae tincidunt purus porta. Proin tincidunt purus urna, in malesuada nunc tristique sit amet.</p>
        <div class="track-posts">
            @foreach($tracks as $track)
                <a href="{{$track -> slug}}">
                    <div class="track-post">
                        <img src="{{$track -> img_url}}" alt="{{$track -> slug}} town image">
                        <h2 class="track-title">{{$track -> position_name}}</h2>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</div>

@endsection