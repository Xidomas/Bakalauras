@extends('layout')

@section('title', 'Mano Profilis')

@section('content')

<div class="breadcrumbs">
    <div class="container">
        <a href="/">Namai</a>
        <i class="fa fa-chevron-right breadcrumb-separator"></i>
        <span>Mano profilis</span>
    </div>
</div>
<div class="container">
    @if (session()->has('success_message'))
        <div class="alert alert-success">
            {{ session()->get('success_message') }}
        </div>
    @endif
    @if(count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
<div class="my-profile container">
    <div class="my-profile-sidebar">
        <ul>
            <li class="active"><a href="{{ route('users.edit') }}">Mano profilis</a></li>
            <li><a href="{{ route('orders.index') }}">Mano užsakymai</a></li>
        </ul>
    </div>
    <div class="my-profile-content">
        <div>
            <h1>Mano profilis</h1>
        </div>
        <div>
            <form action="{{ route('users.update') }}" method="POST">
                {{method_field('patch')}}
                {{csrf_field()}}
                <div class="form-control">
                    <label for="name">Vardas: </label>
                    <input id="name" type="text" name="name" value="{{ $user->name }}" placeholder="Vardas" required>
                </div>
                <div class="form-control">
                    <label for="email">El. paštas: </label>
                    <input id="email" type="email" name="email" value="{{ $user->email }}" placeholder="Elektroninis paštas" required>
                </div>
                <div class="form-control">
                    <label for="password">Slaptažodis: </label>
                    <input id="password" type="password" name="password" placeholder="Slaptažodis">
                    <div>Palikite slaptažodį tuščią, kad palikti senąjį!</div>
                </div>
                <div class="form-control">
                <label for="password-confirm">Patvirtinti slaptažodį: </label>
                    <input id="password-confirm" type="password" name="password_confirmation" placeholder="Patvirtinti slaptažodį">
                </div>
                <div>
                    <button type="submit" class="my-profile-button">Atnaujinti profilį</button>
                </div>
            </form>
        </div>
        <div class="spacer"></div>
    </div>
</div>

@endsection