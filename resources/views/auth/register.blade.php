@extends('layouts.app')

@section('title', 'Registration')

@section('background-color', 'bg-container')

@section('content')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-5 d-flex align-items-center">
                <img class="img-fluid d-none d-md-block" src="{{ asset('storage/uploads/drrmc/login register.png') }}"
                    alt="">
            </div>

            <div class="col-md-6">
                <div class="card shadow">
                    {{-- <div class="card-header">{{ __('Register') }}</div> --}}

                    <div class="card-body p-5">
                        <div class="mb-4">
                            <h1 class='text-green'>Join Our Family!</h1>
                            <h6>A platform for user to Donate to people.</h6>
                        </div>

                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="form-check form-switch  mb-3">
                                <input class="form-check-input reg-switch" type="checkbox" role="switch"
                                    name="inOrganization" id="flexSwitchCheckDefault">
                                <label class="form-check-label reg-switch" for="flexSwitchCheckDefault">&nbsp;Organization
                                    Representative?</label>
                            </div>

                            <div class="input-org input-group mb-3 d-none">
                                <span class="input-group-text" id="org"><i class="bi bi-building"></i></span>
                                <input type="text"
                                    class="form-control @error('organization') is-invalid @enderror org-input"
                                    name="organization" placeholder="{{ __('Organization Name') }}"
                                    aria-label="{{ __('Email Address') }}" aria-describedby="org"
                                    value="{{ old('organization') }}" required autocomplete="organization" disabled>
                                @error('organization')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="row mb-3">
                                <div class="col">
                                    <div class="input-group">
                                        <span class="input-group-text" id="fname-reg"><i
                                                class="bi bi-person-fill"></i></span>
                                        <input type="text" class="form-control" name="first_name"
                                            placeholder="{{ __('First Name') }}" aria-label="{{ __('First Name') }}"
                                            aria-describedby="fname-reg" value="{{ old('first_name') }}" required
                                            autocomplete="given-name">
                                        @error('first_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="input-group">
                                        <span class="input-group-text" id="lname-reg"><i
                                                class="bi bi-person-fill"></i></span>
                                        <input type="text" class="form-control" name="last_name"
                                            placeholder="{{ __('Last Name') }}" aria-label="{{ __('Last Name') }}"
                                            aria-describedby="lname-reg" value="{{ old('last_name') }}" required
                                            autocomplete="family-name">
                                        @error('last_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                            </div>

                            <div class="row mb-3">
                                <div class="col">
                                    <div class="input-group">
                                        <span class="input-group-text" id="email-reg"><i
                                                class="bi bi-envelope-at"></i></span>
                                        <input type="text" class="form-control @error('email') is-invalid @enderror"
                                            name="email" placeholder="{{ __('Email Address') }}"
                                            aria-label="{{ __('Email Address') }}" aria-describedby="email-reg"
                                            value="{{ old('email') }}" required autocomplete="email">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="input-group">
                                        <span class="input-group-text" id="contact-number-reg"><i
                                                class="bi bi-telephone"></i></span>
                                        <input type="text"
                                            class="form-control @error('contact_number') is-invalid @enderror"
                                            name="contact_number" placeholder="{{ __('Contact Number') }}"
                                            aria-label="{{ __('Contact Number') }}" aria-describedby="contact-number-reg"
                                            value="{{ old('contact_number') }}" required autocomplete="tel">
                                        @error('contact_number')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="input-group mb-3">
                                <span class="input-group-text" id="address-reg"><i class="bi bi-house-door"></i></span>
                                <input type="text" class="form-control @error('address') is-invalid @enderror"
                                    name="address" placeholder="{{ __('Address') }}" aria-label="{{ __('Address') }}"
                                    aria-describedby="address-reg" required autocomplete="address">
                                @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="input-group mb-3">
                                <span class="input-group-text" id="password-reg"><i id="togglePassword" class="fa fa-eye" style="font-size: 12px"></i></span>
                                <input id="password-field" type="password" class="form-control @error('password') is-invalid @enderror"
                                    name="password" placeholder="{{ __('Password') }}"
                                    aria-label="{{ __('Password') }}" aria-describedby="password-reg" required
                                    autocomplete="new-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="input-group mb-4">
                                <span class="input-group-text" id="password-confirm-reg"><i id="toggleConfirmPassword"
                                        class="fa-solid fa-eye" style="font-size: 12px"></i></span>
                                <input id="confirm-password-field" type="password" class="form-control" name="password_confirmation"
                                    placeholder="{{ __('Confirm Password') }}" aria-label="{{ __('Confirm Password') }}"
                                    aria-describedby="password-confirm-reg" required>
                            </div>

                            <div class="form-check mb-3">
                                <div class="d-flex justify-content-center">
                                    <input id="regCheckbox"
                                        class="form-check-input @error('terms_and_conditions') is-invalid @enderror"
                                        type="checkbox" name="terms_and_conditions" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        &nbsp I accept all
                                        <a class="link-underline-primary" href="{{ url('terms-and-conditions') }}">Terms
                                            and
                                            Conditions</a>
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
                                    <button type="submit" class="btn bg-green btn-lg w-75">
                                        {{ __('SIGN UP') }}
                                    </button>
                                </div>
                            </div>

                            <div>
                                <div class="d-flex justify-content-center">
                                    <label>Already have an account? <a class="link-underline-primary"
                                            href="{{ route('login') }}">Login</a></label>
                                </div>
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
            $('.reg-switch').change(function() {
                if ($(this).is(':checked')) {
                    $('.input-org').removeClass('d-none');
                    $('.org-input').attr('disabled', false);
                } else {
                    $('.input-org').addClass('d-none');
                    $('.org-input').attr('disabled', true);
                }
            });

            // $('#regCheckbox').prop('checked', true);
            $('#regCheckbox').change(function() {
                if ($(this).is(':checked')) {
                    $('#your-input-id').attr('checked', 'checked');
                } else {
                    $('#your-input-id').removeAttr('checked');
                }
            });

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

            //  Toggle  Password Start
            $("#toggleConfirmPassword").removeClass("fa-solid fa-eye").addClass("fa-solid fa-eye-slash");
            $("#toggleConfirmPassword").click(function() {
                const passwordInput = $("#confirm-password-field");
                const type = passwordInput.attr("type");

                if (type === "password") {
                    passwordInput.attr("type", "text");
                    $("#toggleConfirmPassword").removeClass("fa-solid fa-eye-slash").addClass("fa-solid fa-eye");
                } else {
                    passwordInput.attr("type", "password");
                    $("#toggleConfirmPassword").removeClass("fa-solid fa-eye").addClass("fa-solid fa-eye-slash");
                }
            });
            //  Toggle  Password End
        });
    </script>
@endsection
