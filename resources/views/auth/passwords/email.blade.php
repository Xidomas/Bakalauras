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
            <h2>Pamiršote slaptažodį?</h2>
            <div class="spacer"></div>
            <form action="{{ route('password.email') }}" method="POST">
                {{ csrf_field() }}
                <label for="email">El. paštas: </label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="El. paštas" required autofocus>
                <div class="auth-container">
                    <button type="submit" class="auth-button">Siųsti slaptažodžio atstatymo nuorodą</button>
                </div>
            </form>
        </div>
        <div class="auth-right">
            <h2>Pamirštas slaptažodis?</h2>
            <div class="spacer"></div>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Vel dicta obcaecati exercitationem ut atque inventore cum. Magni autem error ut!</p>
            <div class="spacer"></div>
            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Vel accusantium quasi necessitatibus rerum fugiat eos, a repudiandae tempore nisi ipsa delectus sunt natus!</p>
        </div>
    </div>
</div>
@endsection
