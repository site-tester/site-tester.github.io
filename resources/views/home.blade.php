@extends('layouts.app')

@section('title', 'Home Page')

@section('css')
    <script src="https://kit.fontawesome.com/be5b1ff12e.js" crossorigin="anonymous"></script>
@endsection

@section('background-color', 'bg-container')

@section('content')
    <div class="container-fluid px-0">
        <section id="hero" class="text-bg-dark hero">
            <div class="container-fluid">
                <div class="row align-items-center justify-content-center hero">
                    <div class="col-md-8 ">
                        <div class="float-end text-end p-5 ">
                            <p class="fs-4">Give Them A Chance</p>
                            <h1 class="fw-bolder">Help Us Save <br> the Citizens of <br> Paranaque.</h1>
                                <a href="
                                @guest
                                {{ route('login') }}
                                @else
                                {{ route('donate-now')}}
                                @endguest
                                " class="btn btn-light text-green rounded fw-bolder">Donate Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <button id="moveUpButton" class="move-up-button text-light align-items-center" style="display: none;">
            <i class="bi bi-chevron-up"></i>
        </button>
        <section id="tally" class="p-4">
            <div class="container">
                <div class="row d-flex justify-content-center">
                    <div class="col-12 col-md-4 pb-3">
                        <div class="row text-greener">
                            <div class="col-12 text-center col-md-6 text-md-end counter-number">1.2K</div>
                            <div class="col-12 text-center text-md-start col-md-6 align-self-center fw-bolder fs-4">Total
                                Received
                                Donations</div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 pb-3">
                        <div class="row text-greener">
                            <div class="col-12 text-center col-md-6 text-md-end counter-number">543</div>
                            <div class="col-12 text-center text-md-start col-md-6 align-self-center fw-bolder fs-4">
                                Registered Donors</div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 pb-3">
                        <div class="row text-greener">
                            <div class="col-12 text-center col-md-6 text-md-end counter-number">1.1K</div>
                            <div class="col-12 text-center text-md-start col-md-6 align-self-center fw-bolder fs-4">Total
                                Goods Delivered
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="carousel" class="container card">
            <div class="owl-carousel ">
                <div class="row align-items-center">
                    <div class="col-12 col-md-5">
                        <img class="img-fluid p-5" src="https://placehold.co/100" alt="">
                    </div>
                    <div class="col-12 col-md-6 bg-greener p-5 pe-5 me-5">
                        <div>
                            <h2>Your Donations Means Another Smile</h2><br>
                            <p class="">Last June 26, 2024, our team, in partnership with the local barangay
                                officials, successfully
                                distributed much-needed relief goods and financial assistance to the victims of the recent
                                fire in Espiritu Compound, Barangay San Dionisio. This effort is a testament to the power of
                                community and the generosity of our donors. Your contributions have directly impacted the
                                lives of those affected, providing them with essential support during this challenging time.
                                <br><br>
                                Together, we are making a difference—one donation at a time.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center ">
                    <div class="col-12 col-md-5">
                        <img class="img-fluid p-5" src="https://placehold.co/100" alt="">
                    </div>
                    <div class="col-12 col-md-6 bg-greener p-5 me-5">
                        <div class=" border-top border-bottom border-success border-3 mb-3">
                            <h2 class="mt-3">Typhoon Carina Ravages</h2>
                            <h1 class="">Paranaque City</h1>
                        </div>
                        <p class="px-2 font-monospace pb-4">July 22, 2024, Parañaque City is currently grappling with severe
                            flooding as
                            Typhoon Carina wreaks havoc across the region. The powerful storm has inundated numerous areas,
                            causing significant disruptions to daily life. Streets are submerged under several feet of
                            water, and many homes have been affected by the rising tides.</p><br><br>
                    </div>

                </div>
                <div class="row align-items-center ">
                    <div class="col-12 col-md-5">
                        <img class="img-fluid p-5" src="https://placehold.co/100" alt="">
                    </div>
                    <div class="col-12 col-md-6 bg-greener p-5 me-5">
                        <h2>Spread Hope: Donate to Make a Difference</h2><br>
                        <p class="font-monospace">July 27, 2024, flood victims from Typhoon Carina received essential relief
                            goods thanks to the
                            generosity of donors. The outpouring of support has provided crucial aid, including food and
                            water, to those in need. We extend our heartfelt thanks to all who contributed, demonstrating
                            the power of collective compassion in times of crisis.</p><br><br><br><br>
                    </div>
                </div>
            </div>
        </section>

        <section id="what2donate" class="container mb-5">
            <div class="my-5">
                <h1 class="text-greener text-center">WHAT TO DONATE?</h1>
            </div>
            <div class="row justify-content-center">
                <div class="col-12 col-md-4 mb-3">
                    <div class="card bg-greener w-75 m-auto shadow-sm">
                        <div class="text-center">
                            <div class="donate-icons text-greener my-4">
                                <svg class="bg-light rounded-circle p-3 " xmlns="http://www.w3.org/2000/svg" width="100"
                                    height="100" viewBox="-2 -2 36 36">
                                    <rect width="32" height="32" fill="none" />
                                    <path fill="currentColor"
                                        d="M6.68 2c-1.138 0-2.175.757-2.444 1.916C3.936 5.21 3.5 7.43 3.5 9.5a6.5 6.5 0 0 0 2.818 5.358c.468.321.682.713.682 1.032a1 1 0 0 1-.006.1c-.058.49-.305 2.58-.538 4.744C6.226 22.862 6 25.159 6 26a4 4 0 0 0 8 0c0-.84-.227-3.138-.456-5.266c-.233-2.164-.48-4.255-.538-4.745a1 1 0 0 1-.006-.1c0-.318.214-.71.681-1.031A6.5 6.5 0 0 0 16.5 9.5c0-2.071-.435-4.291-.736-5.584C15.495 2.757 14.458 2 13.32 2a2.56 2.56 0 0 0-1.629.582A2.74 2.74 0 0 0 10 2c-.638 0-1.225.217-1.691.582A2.56 2.56 0 0 0 6.68 2m6.07 2.57a.57.57 0 0 1 .57-.57c.26 0 .45.166.496.369c.29 1.249.684 3.292.684 5.131a4.5 4.5 0 0 1-1.952 3.71c-.79.543-1.548 1.473-1.548 2.68q0 .167.02.336c.058.487.304 2.57.536 4.722C11.79 23.135 12 25.295 12 26a2 2 0 1 1-4 0c0-.705.209-2.865.444-5.052c.232-2.152.478-4.235.536-4.722q.02-.17.02-.336c0-1.207-.759-2.137-1.548-2.68A4.5 4.5 0 0 1 5.5 9.5c0-1.84.394-3.882.684-5.131A.49.49 0 0 1 6.68 4a.57.57 0 0 1 .57.57V10a1 1 0 1 0 2 0V4.75a.75.75 0 0 1 1.5 0V10a1 1 0 1 0 2 0zM20 9.5a5.5 5.5 0 0 1 5-5.478V15c0 .279.055.908.127 1.658c.075.777.177 1.758.284 2.792v.003C25.694 22.164 26 25.136 26 26a2 2 0 1 1-4 0c0-.714.212-3.115.448-5.544a635 635 0 0 1 .535-5.244a3 3 0 0 0 .013-.159A1 1 0 0 0 21.997 14H20.5a.5.5 0 0 1-.5-.5zM25.5 2A7.5 7.5 0 0 0 18 9.5v4a2.5 2.5 0 0 0 2.5 2.5h.389a616 616 0 0 0-.431 4.262c-.23 2.37-.458 4.9-.458 5.738a4 4 0 1 0 8 0c0-.985-.317-4.033-.586-6.631l-.013-.122a425 425 0 0 1-.283-2.781C27.04 15.668 27 15.158 27 15V3a1 1 0 0 0-1-1z" />
                                </svg>
                            </div>
                            <h1 class="text-center text-light">Food</h1>
                        </div>
                        <div>
                            <ul class="text-center list-group list-group-flush rounded ">
                                <li class="list-group-item bg-greener">Canned Goods</li>
                                <li class="list-group-item bg-greener">Packaged Snacks</li>
                                <li class="list-group-item bg-greener">Instant Food</li>
                                <li class="list-group-item bg-greener">Instant Formula/Baby Food</li>
                                <li class="list-group-item bg-greener">Beverages</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4 mb-3">
                    <div class="card bg-light w-75 m-auto shadow-sm">
                        <div class="text-center">
                            <div class="donate-icons bg-light my-4">
                                <svg class="text-white bg-greener rounded-circle p-3 " xmlns="http://www.w3.org/2000/svg"
                                    width="100" height="100" viewBox="-3 -3 30 30">
                                    <rect width="24" height="24" fill="none" />
                                    <path fill="none" stroke="currentColor" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="1.5"
                                        d="M6 4h3s0 3 3 3s3-3 3-3h3m0 7v8.4a.6.6 0 0 1-.6.6H6.6a.6.6 0 0 1-.6-.6V11m12-7l4.443 1.777a.6.6 0 0 1 .334.78l-1.626 4.066a.6.6 0 0 1-.557.377H18M6 4L1.557 5.777a.6.6 0 0 0-.334.78l1.626 4.066a.6.6 0 0 0 .557.377H6" />
                                </svg>
                            </div>
                            <h1 class="text-center text-greener">Non Food</h1>
                        </div>
                        <div>
                            <ul class="text-center list-group list-group-flush rounded ">
                                <li class="list-group-item bg-light">Clothing</li>
                                <li class="list-group-item bg-light">Personal Hygiene</li>
                                <li class="list-group-item bg-light">Blanket and Sleeping Bags</li>
                                <li class="list-group-item bg-light">Household Supplies</li>
                                <li class="list-group-item bg-light">Baby Essentials</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4 mb-3">
                    <div class="card bg-greener w-75 m-auto shadow-sm">
                        <div class="text-center">
                            <div class="donate-icons text-greener my-4">
                                <svg class="bg-light rounded-circle  p-3" xmlns="http://www.w3.org/2000/svg"
                                    width="100" height="100" viewBox="0 -120 500 800">
                                    <rect width="70" height="70" fill="none" />
                                    <path fill="currentColor"
                                        d="M184 48h144c4.4 0 8 3.6 8 8v40H176V56c0-4.4 3.6-8 8-8m-56 8v424h256V56c0-30.9-25.1-56-56-56H184c-30.9 0-56 25.1-56 56M96 96H64c-35.3 0-64 28.7-64 64v256c0 35.3 28.7 64 64 64h32zm320 384h32c35.3 0 64-28.7 64-64V160c0-35.3-28.7-64-64-64h-32zM224 208c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16v48h48c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16h-48v48c0 8.8-7.2 16-16 16h-32c-8.8 0-16-7.2-16-16v-48h-48c-8.8 0-16-7.2-16-16v-32c0-8.8 7.2-16 16-16h48z" />
                                </svg>
                            </div>
                            <h2 class="text-center text-light mb-3">Medical Supplies</h2>
                        </div>
                        <div>
                            <ul class="text-center list-group list-group-flush rounded ">
                                <li class="list-group-item bg-greener">First Aid Kits</li>
                                <li class="list-group-item bg-greener">Face Mask</li>
                                <li class="list-group-item bg-greener">Basic Medical Supplies</li>
                                <li class="list-group-item bg-greener">Durable Medical Equipment</li>
                                <li class="list-group-item bg-greener">Medications</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="ideas" class="container-fluid mb-5 py-5 border-top border-bottom bg-light">
            <div class="mb-4">
                <h1 class="text-uppercase text-greener text-center">Ideas To Get You Started</h1>
                <p class="text-gray text-center">There are lots of way to make good things happen</p>
            </div>
            <div class="row m-auto justify-content-center">
                <div class="col-md-5 border px-5 py-3 m-3 bg-container">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h5 class="text-greener fw-bolder">Why we use non monetary?</h5>
                            <p class="mb-0">We focus on non-monetary donations to ensure that every item directly meets
                                the immediate
                                needs of disaster victims and provides tangible support in their time of crisis.</p>
                        </div>
                        <div class="col-4">
                            <svg class="img-fluid text-greener" xmlns="http://www.w3.org/2000/svg" width="120"
                                height="120" viewBox="0 0 24 24">
                                <rect width="24" height="24" fill="none" />
                                <path fill="currentColor"
                                    d="M3.28 2.22a.75.75 0 0 0-1.06 1.06l1.738 1.74A2.25 2.25 0 0 0 2 7.25v7.5A2.25 2.25 0 0 0 4.25 17h11.69l1.494 1.495q-.09.005-.184.005H4.401A3 3 0 0 0 7 20h10.25c.51 0 1-.08 1.46-.229l2.01 2.01a.75.75 0 1 0 1.06-1.061zM14.44 15.5H6.5v-.75a2.25 2.25 0 0 0-2.25-2.25H3.5v-3h.75a2.25 2.25 0 0 0 2.231-1.958l1.636 1.636a3 3 0 0 0 4.206 4.206zm-5.243-5.243l2.046 2.047a1.5 1.5 0 0 1-2.046-2.046M3.5 7.25a.75.75 0 0 1 .75-.75H5v.75a.75.75 0 0 1-.75.75H3.5zm.75 8.25a.75.75 0 0 1-.75-.75V14h.75a.75.75 0 0 1 .75.75v.75zm12.5-3a2.2 2.2 0 0 0-.887.182L17.18 14h.319v.32l1.318 1.317a2.2 2.2 0 0 0 .182-.887v-7.5A2.25 2.25 0 0 0 16.75 5H8.18l1.5 1.5h4.82v.75a2.25 2.25 0 0 0 2.25 2.25h.75v3zm.75-5.25V8h-.75a.75.75 0 0 1-.75-.75V6.5h.75a.75.75 0 0 1 .75.75m2.562 9.631l1.085 1.085c.538-.77.853-1.706.853-2.716V10a3 3 0 0 0-1.5-2.599v7.849a3.24 3.24 0 0 1-.438 1.631" />
                            </svg>

                        </div>
                    </div>
                </div>

                <div class="col-md-5 border px-5 py-3 m-3 bg-container">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h5 class="text-greener fw-bolder">Help People in Need</h5>
                            <p class="mb-0">Your contribution directly impacts the lives of those affected, providing
                                essential supplies and hope to individuals and families in desperate need.</p>
                        </div>
                        <div class="col-4">
                            <svg class="img-fluid text-greener" xmlns="http://www.w3.org/2000/svg" width="120"
                                height="120" viewBox="0 0 24 24">
                                <rect width="24" height="24" fill="none" />
                                <path fill="currentColor"
                                    d="M21.71 8.71c1.25-1.25.68-2.71 0-3.42l-3-3c-1.26-1.25-2.71-.68-3.42 0L13.59 4H11C9.1 4 8 5 7.44 6.15L3 10.59v4l-.71.7c-1.25 1.26-.68 2.71 0 3.42l3 3c.54.54 1.12.74 1.67.74c.71 0 1.36-.35 1.75-.74l2.7-2.71H15c1.7 0 2.56-1.06 2.87-2.1c1.13-.3 1.75-1.16 2-2C21.42 14.5 22 13.03 22 12V9h-.59zM20 12c0 .45-.19 1-1 1h-1v1c0 .45-.19 1-1 1h-1v1c0 .45-.19 1-1 1h-4.41l-3.28 3.28c-.31.29-.49.12-.6.01l-2.99-2.98c-.29-.31-.12-.49-.01-.6L5 15.41v-4l2-2V11c0 1.21.8 3 3 3s3-1.79 3-3h7zm.29-4.71L18.59 9H11v2c0 .45-.19 1-1 1s-1-.55-1-1V8c0-.46.17-2 2-2h3.41l2.28-2.28c.31-.29.49-.12.6-.01l2.99 2.98c.29.31.12.49.01.6" />
                            </svg>

                        </div>
                    </div>
                </div>

                <div class="col-md-5 border px-5 py-3 m-3 bg-container">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h5 class="text-greener fw-bolder">Take Action in an Emergency</h5>
                            <p class="mb-0">By taking action now, you become a crucial part of the emergency response,
                                helping to deliver vital aid and support to those who need it most.</p>
                        </div>
                        <div class="col-4">
                            <svg class="img-fluid text-greener" xmlns="http://www.w3.org/2000/svg" width="120"
                                height="120" viewBox="0 0 24 24">
                                <rect width="24" height="24" fill="none" />
                                <path fill="currentColor"
                                    d="M10 9a1 1 0 0 1 1-1a1 1 0 0 1 1 1v4.47l1.21.13l4.94 2.19c.53.24.85.77.85 1.35v4.36c-.03.82-.68 1.47-1.5 1.5H11c-.38 0-.74-.15-1-.43l-4.9-4.2l.74-.77c.19-.21.46-.32.74-.32h.22L10 19zm1-4a4 4 0 0 1 4 4c0 1.5-.8 2.77-2 3.46v-1.22c.61-.55 1-1.35 1-2.24a3 3 0 0 0-3-3a3 3 0 0 0-3 3c0 .89.39 1.69 1 2.24v1.22C7.8 11.77 7 10.5 7 9a4 4 0 0 1 4-4m0-2a6 6 0 0 1 6 6c0 1.7-.71 3.23-1.84 4.33l-1-.45A5.02 5.02 0 0 0 16 9a5 5 0 0 0-5-5a5 5 0 0 0-5 5c0 2.05 1.23 3.81 3 4.58v1.08C6.67 13.83 5 11.61 5 9a6 6 0 0 1 6-6" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="col-md-5 border px-5 py-3 m-3 bg-container">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h5 class="text-greener fw-bolder">Take part in a Donation Drive</h5>
                            <p class="mb-0">Join our donation drive to make a meaningful difference in our community
                                every item you contribute helps build recovery for disaster-affected families.</p>
                        </div>
                        <div class="col-4">
                            <svg class="img-fluid text-greener" xmlns="http://www.w3.org/2000/svg" width="120"
                                height="120" viewBox="0 0 16 16">
                                <rect width="16" height="16" fill="none" />
                                <path fill="currentColor" fill-rule="evenodd"
                                    d="m13.6 12.186l-1.357-1.358c-.025-.025-.058-.034-.084-.056c.53-.794.84-1.746.84-2.773a5 5 0 0 0-.84-2.772c.026-.02.059-.03.084-.056L13.6 3.813a6.96 6.96 0 0 1 0 8.373M8 15a6.96 6.96 0 0 1-4.186-1.4l1.358-1.358c.025-.025.034-.057.055-.084C6.02 12.688 6.974 13 8 13a5 5 0 0 0 2.773-.84c.02.026.03.058.056.083l1.357 1.358A6.96 6.96 0 0 1 8 15m-5.601-2.813a6.96 6.96 0 0 1 0-8.373l1.359 1.358c.024.025.057.035.084.056A4.97 4.97 0 0 0 3 8c0 1.027.31 1.98.842 2.773c-.027.022-.06.031-.084.056zm5.6-.187A4 4 0 1 1 8 4a4 4 0 0 1 0 8M8 1c1.573 0 3.019.525 4.187 1.4L10.83 3.758c-.025.025-.035.057-.056.084A5 5 0 0 0 8 3a5 5 0 0 0-2.773.842c-.021-.027-.03-.059-.055-.084L3.814 2.4A6.96 6.96 0 0 1 8 1m0-1a8.001 8.001 0 1 0 .003 16.002A8.001 8.001 0 0 0 8 0" />
                            </svg>

                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="mission" class="container w-100 w-md-50 m-auto mb-5 pb-5">
            <ul class="nav nav-tabs rounded" id="myTab" role="tablist">
                <li class="nav-item " role="presentation">
                    <a class="nav-link active" href="#tab-1" role="tab" data-bs-toggle="tab">Mission<br />
                    </a>
                </li>
                <li class="nav-item " role="presentation">
                    <a class="nav-link" href="#tab-2" role="tab" data-bs-toggle="tab">Vision<br />
                    </a>
                </li>
                <li class="nav-item " role="presentation">
                    <a class="nav-link" href="#tab-3" role="tab" data-bs-toggle="tab">Value<br />
                    </a>
                </li>
            </ul>

            <div class="tab-content shadow rounded">
                <div id="tab-1" class="tab-pane fade show active bg-greener" role="tabpanel">
                    <div class="row align-items-center">
                        <div class="col-12 col-md-7  p-5">
                            <h5 class="fw-bolder">Empowering Communities, One Donation at a Time</h5><br>
                            <p>We are dedicated to transforming the way donations are managed and distributed by fostering
                                transparency, collaboration, and compassion. Our mission is to ensure that every donation
                                reaches
                                those who need it most, with integrity and efficiency, creating a lasting positive impact in
                                the
                                lives of the vulnerable and those affected by disaster.</p>
                        </div>
                        <div class="col-12 col-md-5 px-0">
                            <img class="img-fluid " src="https://placehold.co/400" alt="" srcset="">
                        </div>
                    </div>
                </div>
                <div id="tab-2" class="tab-pane fade bg-greener" role="tabpanel">
                    <div class="row align-items-center">
                        <div class="col-12 col-md-7 p-5">
                            <h5 class="fw-bolder">Strength in Solidarity</h5><br>
                            <p>Our vision is to create a resilient network of support within Parañaque, where communities
                                come together to respond smoothly and effectively to crises. We aim to be helpful platform
                                for disaster relief, where technology and human compassion unite to ensure that no one is
                                left behind.</p><br><br>
                        </div>
                        <div class="col-12 col-md-5 px-0">
                            <img class="img-fluid" src="https://placehold.co/400" alt="" srcset="">
                        </div>
                    </div>
                </div>
                <div id="tab-3" class="tab-pane fade bg-greener" role="tabpanel">
                    <div class="row align-items-center">
                        <div class="col-12 col-md-7 p-5">
                            <h5 class="fw-bolder">Uniting Hearts for a Stronger Community</h5><br>
                            <p>We believe in the power of collective effort. Our core values of transparency,
                                community-centric focus, integrity, empowerment, innovation, compassion, and collaboration
                                guide every action we take. These values are the foundation of our commitment to making a
                                meaningful difference in the lives of those we serve.</p>
                        </div>
                        <div class="col-12 col-md-5 px-0">
                            <img class="img-fluid" src="https://placehold.co/400" alt="" srcset="">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="contact" class="container mb-5">
            <div class="row text-center justify-content-center">
                <h1 class="col-12 fw-bolder mb-4">Contact Us</h1>
                <div class="col-12 col-md-4 mb-3">
                    <svg class="mb-2" xmlns="http://www.w3.org/2000/svg" width="100" height="100"
                        viewBox="0 0 24 24">
                        <rect width="24" height="24" fill="none" />
                        <circle cx="12" cy="12" r="0" fill="currentColor">
                            <animate fill="freeze" attributeName="r" begin="0.7s" dur="0.2s" values="0;4" />
                        </circle>
                        <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2">
                            <path stroke-dasharray="56" stroke-dashoffset="56"
                                d="M12 4c4.42 0 8 3.58 8 8c0 4.42 -3.58 8 -8 8c-4.42 0 -8 -3.58 -8 -8c0 -4.42 3.58 -8 8 -8Z">
                                <animate fill="freeze" attributeName="stroke-dashoffset" dur="0.6s"
                                    values="56;0" />
                            </path>
                            <path stroke-dasharray="4" stroke-dashoffset="4" d="M12 4v0M20 12h0M12 20v0M4 12h0"
                                opacity="0">
                                <animate fill="freeze" attributeName="d" begin="1s" dur="0.2s"
                                    values="M12 4v0M20 12h0M12 20v0M4 12h0;M12 4v-2M20 12h2M12 20v2M4 12h-2" />
                                <animate fill="freeze" attributeName="stroke-dashoffset" begin="1s" dur="0.2s"
                                    values="4;0" />
                                <set fill="freeze" attributeName="opacity" begin="1s" to="1" />
                                <animateTransform attributeName="transform" dur="30s" repeatCount="indefinite"
                                    type="rotate" values="0 12 12;360 12 12" />
                            </path>
                        </g>
                    </svg>

                    <h2 class="">Address</h2>
                    <h5>Paranaque City</h5>
                </div>
                <div class="col-12 col-md-4 mb-3">
                    <svg class="mb-2" xmlns="http://www.w3.org/2000/svg" width="100" height="100"
                        viewBox="0 0 24 24">
                        <rect width="24" height="24" fill="none" />
                        <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2">
                            <path stroke-dasharray="64" stroke-dashoffset="64"
                                d="M8 3c0.5 0 2.5 4.5 2.5 5c0 1 -1.5 2 -2 3c-0.5 1 0.5 2 1.5 3c0.39 0.39 2 2 3 1.5c1 -0.5 2 -2 3 -2c0.5 0 5 2 5 2.5c0 2 -1.5 3.5 -3 4c-1.5 0.5 -2.5 0.5 -4.5 0c-2 -0.5 -3.5 -1 -6 -3.5c-2.5 -2.5 -3 -4 -3.5 -6c-0.5 -2 -0.5 -3 0 -4.5c0.5 -1.5 2 -3 4 -3Z">
                                <animate fill="freeze" attributeName="stroke-dashoffset" dur="0.6s"
                                    values="64;0" />
                                <animateTransform id="lineMdPhoneCallLoop0" fill="freeze" attributeName="transform"
                                    begin="0.6s;lineMdPhoneCallLoop0.begin+2.7s" dur="0.5s" type="rotate"
                                    values="0 12 12;15 12 12;0 12 12;-12 12 12;0 12 12;12 12 12;0 12 12;-15 12 12;0 12 12" />
                            </path>
                            <path stroke-dasharray="4" stroke-dashoffset="4"
                                d="M15.76 8.28c-0.5 -0.51 -1.1 -0.93 -1.76 -1.24M15.76 8.28c0.49 0.49 0.9 1.08 1.2 1.72">
                                <animate fill="freeze" attributeName="stroke-dashoffset"
                                    begin="lineMdPhoneCallLoop0.begin+0s" dur="2.7s" keyTimes="0;0.111;0.259;0.37;1"
                                    values="4;0;0;4;4" />
                            </path>
                            <path stroke-dasharray="6" stroke-dashoffset="6"
                                d="M18.67 5.35c-1 -1 -2.26 -1.73 -3.67 -2.1M18.67 5.35c0.99 1 1.72 2.25 2.08 3.65">
                                <animate fill="freeze" attributeName="stroke-dashoffset"
                                    begin="lineMdPhoneCallLoop0.begin+0.2s" dur="2.7s"
                                    keyTimes="0;0.074;0.185;0.333;0.444;1" values="6;6;0;0;6;6" />
                            </path>
                        </g>
                    </svg>

                    <h2 class="">Phone</h2>
                    <h5>Paranaque City</h5>
                </div>
                <div class="col-12 col-md-4 mb-3">
                    <svg class="mb-2" xmlns="http://www.w3.org/2000/svg" width="100" height="100"
                        viewBox="0 0 24 24">
                        <rect width="24" height="24" fill="none" />
                        <path fill="currentColor" fill-opacity="0" d="M12 13l-8 -5v10h16v-10l-8 5Z">
                            <animate fill="freeze" attributeName="fill-opacity" begin="0.8s" dur="0.15s"
                                values="0;0.3" />
                        </path>
                        <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2">
                            <path stroke-dasharray="64" stroke-dashoffset="64"
                                d="M4 5h16c0.55 0 1 0.45 1 1v12c0 0.55 -0.45 1 -1 1h-16c-0.55 0 -1 -0.45 -1 -1v-12c0 -0.55 0.45 -1 1 -1Z">
                                <animate fill="freeze" attributeName="stroke-dashoffset" dur="0.6s"
                                    values="64;0" />
                            </path>
                            <path stroke-dasharray="24" stroke-dashoffset="24" d="M3 6.5l9 5.5l9 -5.5">
                                <animate fill="freeze" attributeName="stroke-dashoffset" begin="0.6s" dur="0.2s"
                                    values="24;0" />
                            </path>
                        </g>
                    </svg>

                    <h2 class="">Email</h2>
                    <h5>Paranaque City</h5>
                </div>
            </div>
        </section>



        {{-- <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div> --}}
    </div>
@endsection

@section('scripts')

    <script>
        $(document).ready(function() {
            $('.owl-carousel').owlCarousel({
                items: 1,
                loop: true,
                // margin: 10,
                autoplay: true,
                // autoplayTimeout: 5000,
                autoplayHoverPause: true
            });
        });
    </script>
@endsection
