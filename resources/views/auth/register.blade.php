@extends('layouts.app')

@section('title','Registration')

@section('background-color','bg-container')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-5 d-flex align-items-center">
            <img class="img-fluid d-none d-md-block" src="https://placehold.co/500" alt="">
        </div>

        <div class="col-md-6">
            <div class="card shadow">
                {{-- <div class="card-header">{{ __('Register') }}</div> --}}

                <div class="card-body p-5">
                    <div class="mb-5">
                        <h1 class='text-green'>Join Our Family!</h1>
                        <h6>A platform for user to Donate to people.</h6>
                    </div>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="input-group mb-3">
                            <span class="input-group-text" id="email-reg"><i class="bi bi-envelope-at"></i></span>
                            <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="{{ __('Email Address') }}" aria-label="{{ __('Email Address') }}" aria-describedby="email-reg" value="{{ old('email') }}" required autocomplete="email">
                            @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <div class="input-group">
                                    <span class="input-group-text" id="fname-reg"><i class="bi bi-person-fill"></i></span>
                                    <input type="text" class="form-control" name="first_name" placeholder="{{ __('First Name') }}" aria-label="{{ __('First Name') }}" aria-describedby="fname-reg" value="{{ old('first_name') }}" required autocomplete="given-name">
                                    @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col">
                                <div class="input-group">
                                    <span class="input-group-text" id="fname-reg"><i class="bi bi-person-fill"></i></span>
                                    <input type="text" class="form-control" name="last_name" placeholder="{{ __('Last Name') }}" aria-label="{{ __('Last Name') }}" aria-describedby="fname-reg" value="{{ old('last_name') }}" required autocomplete="family-name">
                                    @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <span class="input-group-text" id="password-reg"><i class="bi bi-eye-slash"></i></span>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="{{ __('Password') }}" aria-label="{{ __('Password') }}" aria-describedby="password-reg" required autocomplete="new-password">
                            @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div class="input-group mb-4">
                            <span class="input-group-text" id="password-confirm-reg"><i class="bi bi-eye-slash-fill"></i></span>
                            <input type="password" class="form-control" name="password_confirmation" placeholder="{{ __('Confirm Password') }}" aria-label="{{ __('Confirm Password') }}" aria-describedby="password-confirm-reg" required autocomplete="new-password">
                        </div>


                        <div class="form-check mb-3">
                            <div class="d-flex justify-content-center">
                                <input class="form-check-input @error('terms_and_conditions') is-invalid @enderror" type="checkbox" name="terms_and_conditions" value="" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    &nbsp I accept all
                                  <a class="link-underline-primary" href="#">Terms and Conditions</a>
                                </label>
                            </div>
                            <div>
                                @error('terms_and_conditions')
                                <span class="invalid-feedback d-block d-flex justify-content-center" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3 text-center">
                            <div class="col">
                                <button type="submit" class="btn bg-green btn-lg w-75" >
                                    {{ __('SIGN UP') }}
                                </button>
                            </div>
                        </div>

                        <div>
                            <div class="d-flex justify-content-center">
                                <label>Already have an account? <a class="link-underline-primary" href="{{route('login')}}">Login</a></label>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
