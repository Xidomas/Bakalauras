@extends('layout')

@section('title', $post->title)

@section('content')

<div class="breadcrumbs">
	<div class="container">
		<a href="/">Namai</a>
		<i class="fa fa-chevron-right breadcrumb-separator"></i>
		<a href="{{route('news.index')}}">Naujienos</a>
		<i class="fa fa-chevron-right breadcrumb-separator"></i>
		<span>{{$post->title}}</span>
	</div>
</div>
<div class="post-section">
	<div class="container">
		<div class="post-content">
			<div class="post-title">
				<h1>{{ $post->title }}</h1>
			</div>
			<div class="post-image">
				<img src="{{ Voyager::image( $post->image ) }}">
			</div>
			<div class="post-description">
				<p>{!! $post->body !!}</p>
			</div>
		</div>
	</div>
</div>

@endsection