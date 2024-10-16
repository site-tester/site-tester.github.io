@extends('layouts.app')

@section('title', 'Donation Confirmation')

@section('content')
    <div class="container">
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
        <div class="container-fluid" style="padding-right: 0px;padding-left: 0px;">
            <div class="justify-content-center text-center"></div>
            <div class="card"
                style="padding-top: 0px;margin-top: 0px;border-radius: 0px;border-bottom-width: 0px;border-bottom-style: none;background: rgb(29,62,41);">
                <img class="w-100 d-block img-fluid" src="{{ url(asset('storage/uploads/drrmc/confirmationbanner.jpg')) }}"
                    style="height: 346px;border-radius: 0px;margin-top: 0px;">
                <div class="card-img-overlay my-5" style="height: 367px;">
                    <h4 class="w-100 mt-5"
                        style="color: #ffffff;font-size: 86.4px;text-align: center;font-family: 'Saira Condensed', sans-serif;font-weight: bold;border-bottom-color: rgb(18,79,31);background: rgba(18,79,31,0.6);text-shadow: 7px 5px #082d0e;">
                        THANK YOU FOR YOUR GENEROSITY!</h4>
                </div>
            </div>
        </div>
        <div class="container-fluid" style="background: #1d3e29;padding-left: 0px;padding-right: 0px;">
            <div class="card w-100" style="border-bottom-width: 0px;border-radius: 0px;">
                <div class="card-body" style="border-bottom-style: none;">
                    <p class="card-text mb-3"
                        style="text-align: center;color: rgb(18,79,31);font-family: 'Saira Condensed', sans-serif;font-size: 45px;font-weight: bold;background: #ffffff;">
                        YOUR DONATION IS BEING PROCESSED.</p>
                    <div class="container-fluid my-4" style="padding-right: 0px;padding-left: 0px;text-align: center;">
                        <a class="mt-5 px-3" href="/"
                            style="font-size: 32px;background: #124f1f;color: rgb(251,251,251);border-radius: 16px;border-style: solid;border-color: rgb(18,79,31);box-shadow: 3px 5px 5px rgb(8,50,20);">
                            RETURN TO HOMEPAGE
                        </a>
                    </div>
                    <hr style="color: rgb(18,79,31);background: #124f1f;">
                    <p class="card-text mb-3 mt-4 fs-4"
                        style="text-align: center;">We are deeply grateful
                        for your support. Your contribution will help to make a meaningful impact in Parañaque, aiding local
                        families and communities in need.</p>
                </div>
            </div>
        </div>
        <div class="container-fluid" style="background: #124f1f;">
            <div class="row" style="color: rgb(88,123,101);">
                <div class="col" style="background: #124f1f;">
                    <h1 class="my-3"
                        style="text-align: center;font-family: 'Saira Condensed', sans-serif;font-size: 50px;font-weight: bold;color: rgb(255,255,255);background: #124f1f;">
                        WHAT HAPPENS NEXT</h1>
                </div>
            </div>
        </div>
        <div class="container-fluid py-4" style="background: #ffffff;">
            <div class="row gy-4 row-cols-1 row-cols-md-2 mb-2">
                <div class="col col-md-4">
                    <div class="text-center rounded d-flex flex-column align-items-center align-items-xl-center"
                        style="background: #08390a;height: 200px;">
                        <div class="bs-icon-lg rounded bs-icon-primary d-flex flex-shrink-0 justify-content-center align-items-center d-inline-block mb-3 mt-3 bs-icon lg"
                            style="background: rgb(255,255,255);">
                            <svg class="p-2" xmlns="http://www.w3.org/2000/svg" width="1em"
                                height="1em" fill="currentColor" viewBox="0 0 16 16"
                                class="bi bi-globe-central-south-asia" style="color: rgb(2,30,2);width: 50px;height: 50px;">
                                <path
                                    d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0M4.882 1.731a.482.482 0 0 0 .14.291.487.487 0 0 1-.126.78l-.291.146a.721.721 0 0 0-.188.135l-.48.48a1 1 0 0 1-1.023.242l-.02-.007a.996.996 0 0 0-.462-.04 7.03 7.03 0 0 1 2.45-2.027Zm-3 9.674.86-.216a1 1 0 0 0 .758-.97v-.184a1 1 0 0 1 .445-.832l.04-.026a1 1 0 0 0 .152-1.54L3.121 6.621a.414.414 0 0 1 .542-.624l1.09.818a.5.5 0 0 0 .523.047.5.5 0 0 1 .724.447v.455a.78.78 0 0 0 .131.433l.795 1.192a1 1 0 0 1 .116.238l.73 2.19a1 1 0 0 0 .949.683h.058a1 1 0 0 0 .949-.684l.73-2.189a1 1 0 0 1 .116-.238l.791-1.187A.454.454 0 0 1 11.743 8c.16 0 .306.084.392.218.557.875 1.63 2.282 2.365 2.282a.61.61 0 0 0 .04-.001 7.003 7.003 0 0 1-12.658.905Z">
                                </path>
                            </svg>
                        </div>
                        <div class="px-3">
                            <h4
                                style="font-family: 'Saira Condensed', sans-serif;font-weight: bold;font-size: 30px;color: rgb(255,255,255);">
                                Spread the word</h4>
                            <p style="font-family: 'Saira Condensed', sans-serif;color: var(--bs-secondary-bg);">Share your
                                support on social media!</p>
                        </div>
                    </div>
                </div>
                <div class="col col-md-4" style="font-family: 'Saira Condensed', sans-serif;height: 200px;">
                    <div class="text-center rounded d-flex flex-column align-items-center align-items-xl-center"
                        style="font-family: 'Saira Condensed', sans-serif;background: #07230a;height: 200px;">
                        <div class="bs-icon-lg rounded bs-icon-primary d-flex flex-shrink-0 justify-content-center align-items-center d-inline-block mb-3 bs-icon lg mt-3"
                            style="background: rgb(255,255,255);font-family: 'Saira Condensed', sans-serif;">
                            <svg class="p-2"
                                xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="1em"
                                viewBox="0 0 24 24" width="1em" fill="currentColor"
                                style="color: rgb(2,30,2);width: 50px;height: 50px;font-family: 'Saira Condensed', sans-serif;">
                                <rect fill="none" height="24" width="24"></rect>
                                <path
                                    d="M11,14H9c0-4.97,4.03-9,9-9v2C14.13,7,11,10.13,11,14z M18,11V9c-2.76,0-5,2.24-5,5h2C15,12.34,16.34,11,18,11z M7,4 c0-1.11-0.89-2-2-2S3,2.89,3,4s0.89,2,2,2S7,5.11,7,4z M11.45,4.5h-2C9.21,5.92,7.99,7,6.5,7h-3C2.67,7,2,7.67,2,8.5V11h6V8.74 C9.86,8.15,11.25,6.51,11.45,4.5z M19,17c1.11,0,2-0.89,2-2s-0.89-2-2-2s-2,0.89-2,2S17.89,17,19,17z M20.5,18h-3 c-1.49,0-2.71-1.08-2.95-2.5h-2c0.2,2.01,1.59,3.65,3.45,4.24V22h6v-2.5C22,18.67,21.33,18,20.5,18z">
                                </path>
                            </svg>
                        </div>
                        <div class="px-3" style="font-family: 'Saira Condensed', sans-serif;">
                            <h4
                                style="font-family: 'Saira Condensed', sans-serif;font-weight: bold;font-size: 30px;color: rgb(255,255,255);">
                                Stay connected</h4>
                            <p style="font-family: 'Saira Condensed', sans-serif;color: rgb(220,231,241);">Follow us on
                                social media&nbsp; to see how your donation makes a difference</p>
                        </div>
                    </div>
                </div>
                <div class="col col-md-4"
                    style="font-family: 'Saira Condensed', sans-serif;">
                    <div class="text-center rounded d-flex flex-column align-items-center align-items-xl-center"
                        style="font-family: 'Saira Condensed', sans-serif; background: #1d7a3d;height: 200px;">
                        <div class="bs-icon-lg rounded bs-icon-primary d-flex flex-shrink-0 justify-content-center align-items-center d-inline-block mb-3 bs-icon lg mt-3"
                            style="background: rgb(255,255,255);font-family: 'Saira Condensed', sans-serif;">
                            <svg class="p-2"
                                xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor"
                                viewBox="0 0 16 16" class="bi bi-person-heart"
                                style="color: rgb(16,46,22);width: 50px;height: 50px;font-family: 'Saira Condensed', sans-serif;">
                                <path
                                    d="M9 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0m-9 8c0 1 1 1 1 1h10s1 0 1-1-1-4-6-4-6 3-6 4m13.5-8.09c1.387-1.425 4.855 1.07 0 4.277-4.854-3.207-1.387-5.702 0-4.276Z">
                                </path>
                            </svg></div>
                        <div class="px-3" style="font-family: 'Saira Condensed', sans-serif;">
                            <h4
                                style="font-family: 'Saira Condensed', sans-serif;font-weight: bold;font-size: 30px;color: rgb(227,233,238);">
                                Get involved</h4>
                            <p style="font-family: 'Saira Condensed', sans-serif;color: rgb(244,244,245);">Continue
                                spreading love and support</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid my-3" style="padding-left: 0px;padding-right: 0px;background: #124f1f;">
            <h1 class="mt-2 mb-3"
                style="font-family: 'Saira Condensed', sans-serif;text-align: center;color: rgb(18,79,31);font-weight: bold;font-size: 40px;background: #ffffff;">
                THANK YOU FOR STANDING WITH US AND MAKING A DIFFERENCE IN PARAÑAQUE!</h1>
        </div>

    </div>
@endsection
