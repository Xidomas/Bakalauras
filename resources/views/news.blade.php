@extends('layout')

@section('title', 'Naujienos')

@section('content')

<div class="breadcrumbs">
    <div class="container">
        <a href="/">Namai</a>
        <i class="fa fa-chevron-right breadcrumb-separator"></i>
        <span>Naujienos</span>
    </div>
</div>

<div class="news-section">
	<div class="container">
		@foreach($news as $new)
			<div class="news-content">
				<div class="news-title">
					<a href="/news/{{ $new->slug }}">{{ $new->title }}</a>
				</div>
				<div class="news-image">
					<a href="/news/{{ $new->slug }}"><img src="{{ Voyager::image( $new->image ) }}"></a>
				</div>
				<div class="news-description">
					<a href="/news/{{ $new->slug }}">{!! $new->body !!}</p></a>
				</div>
			</div>
		@endforeach
	</div>
</div>

@endsection