@extends('layouts.app')

@section('title', 'Login')

@section('background-color', 'bg-container')

@section('content')
    <div class="container-fluid my-5 ">
        <div class="row justify-content-center">
            <div class="col-md-6 align-self-end" style="max-width: 500px">
                <img class="img-fluid d-none d-md-block " src="https://placehold.co/500" alt="">
            </div>

            <div class="col-md-6 align-self-center" style="max-width: 500px">
                <div class="card shadow">
                    {{-- <div class="card-header">{{ __('Login') }}</div> --}}

                    <div class="card-body p-5">
                        <div class="mb-5">
                            <h1 class='text-green'>Welcome to the Family!</h1>
                            <h6>We are so glad to see you here.</h6>
                        </div>

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="row mb-3">
                                <div class="input-group w-75 mx-auto">
                                    <span class="input-group-text" id="email-reg"><i class="bi bi-envelope-at"></i></span>
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email Address">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="input-group w-75 mx-auto">
                                    <span class="input-group-text" id="email-reg"><i class="bi bi-person-lock"></i></span>
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="current-password" placeholder="Password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                            {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-8 offset-md-3">
                                    <button type="submit" class="btn bg-green btn-lg w-75">
                                        {{ __('LOGIN') }}
                                    </button>

                                    {{-- @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif --}}
                                </div>
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
