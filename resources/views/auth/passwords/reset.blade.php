@extends('layout')

@section('title', 'Atstatyti slaptažodį')

@section('content')

<div class="container">
    <div class="auth-pages">
        <div class="auth-left">
            @if (session()->has('status'))
                <div class="alert alert-success">
                    {{ session()->get('status') }}
                </div>
            @endif @if(count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <h2>Atstatyti slaptažodį</h2>
            <div class="spacer"></div>
            <form class="form-horizontal" method="POST" action="{{ route('password.request') }}">
                {{ csrf_field() }}
                <input type="hidden" name="token" value="{{ $token }}">
                <label for="email">El. paštas: </label>
                <input id="email" type="email" class="form-control" name="email" value="{{ $email or old('email') }}" placeholder="El. paštas" required autofocus>
                <label for="password">Slaptažodis: </label>
                <input id="password" type="password" class="form-control" name="password" placeholder="Slaptažodis" required>
                <label for="password-confirm">Patvirtinti slaptažodį: </label>
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Patvirtinti slaptažodį" required>
                <div class="login-container">
                    <button type="submit" class="auth-button">Atstatyti slaptažodį</button>
                </div>
            </form>
        </div>
        <div class="auth-right">
            <h2>Atstatyti slaptažodį?</h2>
            <div class="spacer"></div>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Vel dicta obcaecati exercitationem ut atque inventore
                cum. Magni autem error ut!</p>
            <div class="spacer"></div>
            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Vel accusantium quasi necessitatibus rerum fugiat eos,
                a repudiandae tempore nisi ipsa delectus sunt natus!</p>
        </div>
    </div>
</div>

@endsection