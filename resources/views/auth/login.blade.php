@extends('layout')

@section('title', 'Prisijungti')

@section('content')

<div class="container">
    <div class="login-pages">
        <div class="login-left">
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
            <h2>Grįžtantis klientas?</h2>
            <div class="spacer"></div>
            <form action="{{ route('login') }}" method="POST">
                {{ csrf_field() }}
                <label for="email">El. paštas: </label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="El. paštas" required autofocus>
                <label for="password">Slaptažodis: </label>
                <input type="password" id="password" name="password" value="{{ old('password') }}" placeholder="Slaptažodis" required>
                <div class="login-container">
                    <button type="submit" class="login-button">Prisijungti</button>
                    <label>
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Prisiminti mane
                    </label>
                </div>
                <div class="spacer"></div>
                <a href="{{ route('password.request') }}">
                    Pamiršote slaptažodį?
                </a>
            </form>
        </div>
        <div class="login-right">
            <h2>Naujas klientas?</h2>
            <div class="spacer"></div>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam porttitor turpis eget magna bibendum, vitae egestas turpis vestibulum. Maecenas sed lacus ac libero cursus feugiat. Donec vulputate sapien et nulla efficitur maximus.</p>
            <div class="spacer"></div>
            <a href="{{ route('register') }}" class="login-button-hollow">Registruotis</a>
            <div class="spacer"></div>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam porttitor turpis eget magna bibendum, vitae egestas turpis vestibulum. Maecenas sed lacus ac libero cursus feugiat. Donec vulputate sapien et nulla efficitur maximus.</p>
            <div class="spacer"></div>
            <a href="{{ route('guestCheckout.index') }}" class="login-button-hollow">Tęsti kaip svečias</a>
        </div>
    </div>
</div>

@endsection