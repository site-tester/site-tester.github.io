@extends('layouts.app')

@section('title', 'Profile')

@section('css')
    <script src="https://kit.fontawesome.com/be5b1ff12e.js" crossorigin="anonymous"></script>
@endsection

@section('background-color', 'bg-container')

@section('content')
    <div class="container w-75 m-auto mt-5">
        @if (Session::has('success'))
            <div class="toast-container end-0 ">
                <div id="liveToast" class="toast bg-success-subtle text-success-emphasis show" role="alert"
                    aria-live="assertive" aria-atomic="true">
                    <div class="toast-body">
                        {{ Session::get('success') }}
                        <button type="button" class="btn-close float-end" data-bs-dismiss="toast"
                            aria-label="Close"></button>
                    </div>
                </div>
            </div>
        @endif
        <div class="container w-75">
            <div class="my-5 ">

                <div class="card shadow">
                    <div class=" ">
                        <h3 class="py-3 px-4 mb-0">Profile</h3>
                    </div>
                    <form class="row" action="{{-- {{ route('customer.profile.update', Auth::user()->id) }} --}}" method="POST" enctype="multipart/form-data"
                        autocomplete="off">
                        @csrf
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="px-3">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="col-12 col-lg-3 border-end border-top ">
                            <ul id="myProfileTab" class="nav nav-pills flex-column " role="tablist"
                                aria-orientation="vertical">
                                <li class="nav-item ">
                                    <h5><a class="nav-link w-100 float-end text-end active rounded-start"
                                            href="#profile-details-tab" role="tab" data-bs-toggle="tab">Profile</a></h5>
                                </li>
                                @isset($profile->other_details)
                                    <li class="nav-item ">
                                        <h5><a class="nav-link w-100 float-end text-end rounded-start"
                                                href="#profile-org-tab" role="tab" data-bs-toggle="tab">Organization</a>
                                        </h5>
                                    </li>
                                @endisset
                                <li class="nav-item ">
                                    <h5><a class="nav-link w-100 float-end text-end rounded-start"
                                            href="#profile-security-tab" role="tab" data-bs-toggle="tab">Security</a>
                                    </h5>
                                </li>
                            </ul>
                        </div>
                        <div class="col-12 col-lg-9 ps-0 tab-content border-top">
                            <!-- Account details -->
                            <div id="profile-details-tab" class="tab-pane fade show active mb-4 p-3 p-md-4" role="tabpanel">
                                <div class="">
                                    <!-- Profile picture card-->
                                    {{-- <div class="border-0 mb-4 mb-xl-0 p-3 p-md-4">
                                        <div class="text-center">
                                            <!-- Profile picture image-->
                                            <img class="img-fluid rounded-circle mb-2"
                                                src="{{ asset('storage/' . Auth::user()->avatar) }}" alt=""
                                                style="width:70%;">
                                            <!-- Profile picture help block-->
                                            <div class="small font-italic text-muted mb-4">JPG,JPEG or PNG no larger than 2
                                                MB
                                            </div>
                                            <!-- Profile picture upload button-->
                                            <input class="btn btn-outline-secondary m-auto" type="file" name="avatar">
                                        </div>
                                    </div> --}}
                                    {{-- Full Name --}}
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="ProfileName" name="name" type="text"
                                            value="{{ Auth::user()->name }}" value="{{ old('name') }}">
                                        <label class="small mb-1" for="name">Full Name</label>
                                        @error('email')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <!-- Email Address -->
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="ProfileEmail" name="profileEmail" type="email"
                                            value="{{ Auth::user()->email }}" value="{{ old('profileEmail') }}">
                                        <label class="small mb-1" for="ProfileEmail">Email address</label>
                                        @error('email')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <!-- Form Group (Phone Number)-->
                                    <div class=" form-floating mb-3">
                                        <input class="form-control" id="Phone_number" name="contact_number" type="text"
                                            value="{{ $profile->contact_number }}">
                                        <label class="small mb-1" for="Phone_number">Contact Number</label>
                                        @error('contact_number')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="input-group">
                                        <!-- Form Group (Address)-->
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="address" name="address" type="text"
                                                value="{{ $profile->address }}">
                                            <label class="small mb-1" for="address">Street Address</label>
                                            @error('address')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="my-4">
                                        <button class="btn bg-green btn-lg" type="submit">{{ __('Save') }}</button>
                                    </div>
                                </div>
                            </div>
                            <!-- Security -->
                            <div id="profile-security-tab" class="tab-pane fade mb-4 p-3 p-md-4">
                                <div class="">
                                    <!-- Old Password -->
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="ProfileOldPassword" name="profileOldPassword"
                                            type="password">
                                        <label class="small mb-1" for="profileOldPassword">Old Password</label>
                                        @error('old_password')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <!-- New Password -->
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="ProfilePassword" name="profilePassword"
                                            type="password">
                                        <label class="small mb-1" for="profilePassword">New Password</label>
                                        @error('password')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Confirm New Password -->
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="ProfilePassword_confirmation"
                                            name="profilePassword_confirmation" type="password">
                                        <label class="small mb-1" for="ProfilePassword_confirmation">Confirm New
                                            Password</label>
                                        @error('password_confirmation')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>


                                    <div class="my-4">
                                        <button class="btn bg-green btn-lg" type="submit">{{ __('Save') }}</button>
                                    </div>
                                    <!-- Save changes button-->

                                </div>
                            </div>
                            {{-- Others --}}
                            @isset($profile->other_details)
                            <div id="profile-org-tab" class="tab-pane fade mb-4 p-3 p-md-4">
                                <div class="">
                                    <!-- Form Group (Phone Number)-->
                                    <div class=" form-floating mb-3">
                                        <input class="form-control" id="org-name" name="organization" type="text"
                                            value="{{ $profile->other_details }}">
                                        <label class="small mb-1" for="organization">Organization name</label>
                                        @error('organization')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="my-4">
                                        <button class="btn bg-green btn-lg" type="submit">{{ __('Save') }}</button>
                                    </div>
                                    <!-- Save changes button-->

                                </div>
                            </div>
                            @endisset
                        </div>
                </div>
            </div>

            </form>
        </div>
    </div>
@endsection
