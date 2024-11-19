@extends('layouts.app')

@section('title', 'Login')

@section('background-color', 'bg-container')

@section('css')
    <style>

    </style>
@endsection

@section('content')
    <div class="container-fluid my-5 ">
        @if (session('status'))
            <div class="alert alert-success mx-auto w-50">
                {{ session('status') }}
            </div>
        @endif
        <div class="row justify-content-center">

            <div class="col-md-6 align-self-end" style="max-width: 500px">
                <img class="img-fluid d-none d-md-block " src="{{ asset('storage/uploads/drrmc/login register.png') }}"
                    alt="">
            </div>

            <div class="col-md-6 align-self-center" style="max-width: 500px">
                <div class="card shadow">
                    {{-- <div class="card-header">{{ __('Login') }}</div> --}}

                    <div class="card-body p-5">
                        <div class="mb-5">
                            <h1 class='text-green'>Welcome to DisasterEase!</h1>
                            <h6>We are so glad to see you here.</h6>
                        </div>

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="row mb-3">
                                <div class="input-group w-75 mx-auto">
                                    <span class="input-group-text" id="email-reg"><i class="bi bi-envelope-at"
                                            style="font-size: 14px"></i></span>
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email" autofocus
                                        placeholder="Email Address">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="input-group w-75 mx-auto password-section">

                                    <span class="input-group-text"><i id="togglePassword" class="fa fa-eye"
                                            style="font-size: 12px"></i></span>
                                    <input id="password-field" type="password"
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

                                        <label class="form-label fs-5" for="remember">
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
                                <a class="btn btn-link" href="{{ route('register') }}">
                                    {{ __('Already have a Account?') }}
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {

            //  Toggle  Password Start
            $("#togglePassword").removeClass("fa fa-eye").addClass("fa fa-eye-slash");
            $("#togglePassword").click(function() {
                const passwordInput = $("#password-field");
                const type = passwordInput.attr("type");

                if (type === "password") {
                    passwordInput.attr("type", "text");
                    $("#togglePassword").removeClass("fa fa-eye-slash").addClass("fa fa-eye");
                } else {
                    passwordInput.attr("type", "password");
                    $("#togglePassword").removeClass("fa fa-eye").addClass("fa fa-eye-slash");
                }
            });
            //  Toggle  Password End

        });
    </script>

@endsection
