@extends('layouts.app')

@section('content')
<div class="container">


    <div>{{ __('Login') }}</div>
    <div>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <label for="email">{{ __('Adresse email') }}</label>
            <input id="email" type="email" class="form-input form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
            @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror

            <label for="password">{{ __('Mot de passe') }}</label>
            <input id="password" type="password" class="form-input form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
            @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror

            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
            <label for="remember">
                {{ __('Remember Me') }}
            </label>

            <button type="submit">
                {{ __('Connexion') }}
            </button>

            @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}">
                {{ __('Mot de passe oublié?') }}
            </a>
            @endif
    </div>
    </form>
</div>

</div>
@endsection