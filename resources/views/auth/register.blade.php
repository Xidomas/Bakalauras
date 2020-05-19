@extends('layout')

@section('title', 'Registruotis')

@section('content')

<div class="container">
    <div class="register-pages">
        <div>
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
            <h2>Registruotis</h2>
            <div class="spacer"></div>
            <form method="POST" action="{{ route('register') }}">
                {{ csrf_field() }}
                <label for="name">Vardas: </label>
                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Vardas" required autofocus>
                <label for="email">El. paštas: </label>
                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="El. paštas" required>
                <label for="password">Slaptažodis: </label>
                <input id="password" type="password" class="form-control" name="password" placeholder="Slaptažodis" required>
                <label for="password-confirm">Slaptažodžio patvirtinimas: </label>
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Slaptažodžio patvirtinimas" required>
                <div class="register-container">
                    <button type="submit" class="register-button">Registruotis</button>
                    <div class="already-have-container">
                        <p><strong>Jau turite vartotojo paskyrą?</strong></p>
                        <a href="{{ route('login') }}">Prisijungti</a>
                    </div>
                </div>
            </form>
        </div>
        <div class="register-right">
            <h2>Naujas klientas?</h2>
            <div class="spacer"></div>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam porttitor turpis eget magna bibendum, vitae egestas turpis vestibulum. Maecenas sed lacus ac libero cursus feugiat. Donec vulputate sapien et nulla efficitur maximus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam porttitor turpis eget magna bibendum, vitae egestas turpis vestibulum. Maecenas sed lacus ac libero cursus feugiat. Donec vulputate sapien et nulla efficitur maximus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam porttitor turpis eget magna bibendum, vitae egestas turpis vestibulum. Maecenas sed lacus ac libero cursus feugiat. Donec vulputate sapien et nulla efficitur maximus.</p>
        </div>
    </div>
</div>

@endsection
