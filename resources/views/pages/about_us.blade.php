@extends('layouts.app')

@section('title', $page->title)

@section('css')
    <style>
        @import url(//fonts.googleapis.com/css?family=Montserrat:300,400,500);


        .contact2 {
            font-weight: 300;
            padding: 60px 0;
            margin-bottom: 150px;
            background-position: center top;


        }

        .contact2-banner {
            position: absolute;
            width: 100%;
            height: 400px;
            /* Adjust the height based on your preference */
            background-image: url('{{ asset('storage/uploads/drrmc/about_us_banner.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            text-align: center;
            top:0;
            z-index: -1;
        }

        .contact2 h1,
        .contact2 h2,
        .contact2 h3,
        .contact2 h4,
        .contact2 h5,
        .contact2 h6 {
            color: #3e4555;
        }

        .contact2 .font-weight-medium {
            font-weight: 500;
        }

        .contact2 .subtitle {
            color: #8d97ad;
            line-height: 24px;
        }

        .contact2 .bg-image {
            background-size: cover;
            position: relative;
            display: -webkit-box;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
        }

        .contact2 .card.card-shadow {
            -webkit-box-shadow: 0px 0px 30px rgba(115, 128, 157, 0.1);
            box-shadow: 0px 0px 30px rgba(115, 128, 157, 0.1);
        }

        /* .contact2 .detail-box .round-social {
                                margin-top: 100px;
                            } */

        .contact2 .round-social a {
            background: transparent;
            margin: 0 7px;
            padding: 11px 12px;
        }

        .contact2 .about-container .links a {
            color: #8d97ad;
        }

        .contact2 .about-container {
            position: relative;
            top: 200px;
        }

        .contact2 .btn-green-gradiant {
            background: #5BBA6F;
            background: -webkit-linear-gradient(legacy-direction(to right), #5BBA6F 0%, #428851e5 100%);
            background: -webkit-gradient(linear, left top, right top, from(#5BBA6F), to(#428851e5));
            background: -webkit-linear-gradient(left, #5BBA6F 0%, #428851e5 100%);
            background: -o-linear-gradient(left, #5BBA6F 0%, #428851e5 100%);
            background: linear-gradient(to right, #5BBA6F 0%, #428851e5 100%);
        }

        .contact2 .btn-green-gradiant:hover {
            background: #428851e5;
            background: -webkit-linear-gradient(legacy-direction(to right), #428851e5 0%, #5BBA6F 100%);
            background: -webkit-gradient(linear, left top, right top, from(#428851e5), to(#5BBA6F));
            background: -webkit-linear-gradient(left, #428851e5 0%, #5BBA6F 100%);
            background: -o-linear-gradient(left, #428851e5 0%, #5BBA6F 100%);
            background: linear-gradient(to right, #428851e5 0%, #5BBA6F 100%);
        }

        .contact2 .container .center-heading {
            text-align: center;
            position: relative;
            top: 100px;
            font-size: 50px;
        }
    </style>
@endsection

@section('background-color', 'bg-container')

@section('content')
    <div>

        <div class="contact2" id="about">
            <div class="contact2-banner">
            </div>
            <div class="container">
                <div>
                    <h1 class="center-heading text-light">About Us</h1>
                </div>
                <div class="row about-container pt-5">
                    <div class="col-lg-12">
                        <div class="border-0 ">
                            <div class="row m-0 rounded align-items-center">
                                <div class="col-lg-6 p-0">
                                    <div class="about-box p-5">
                                        <h1 class="text-center">{!! $page->extras['about_us_header'] !!}</h1>
                                        <hr>
                                        <p>
                                            {!! $page->extras['about_us_content'] !!}
                                        </p>
                                    </div>
                                </div>
                                <div class="col-lg-6 ">
                                    <div class="detail-box p-4">
                                        <img class="img-fluid" src="{{ url(asset('storage/uploads/drrmc/donations.jpg')) }}" alt="">
                                    </div>
                                </div>
                            </div>
                            <div class="row m-0 rounded">
                                <div class="col ">
                                    <div class="row p-5 mb-3 bg-green rounded">
                                        <div class="col ">
                                            <h2 class="text-light h1">Mission</h2>
                                            <hr class="text-light">
                                            <h3 class="text-light">{!! $page->extras['mission_header'] !!}</h3>
                                            <p>{!! $page->extras['mission_content'] !!}</p>
                                        </div>
                                    </div>
                                    <div class="row p-5 mb-3 card rounded">
                                        <div class="col ">
                                            <h2 class="h1">Vision</h2>
                                            <hr>
                                            <h3>{!! $page->extras['vision_header'] !!}</h3>
                                            <p>{!! $page->extras['vision_content'] !!}</p>
                                        </div>
                                    </div>
                                    <div class="row p-5 bg-green rounded">
                                        <div class="col ">
                                            <h2 class="text-light h1">Values</h2>
                                            <hr class="text-light">
                                            <h3 class="text-light">{!! $page->extras['values_header'] !!}</h3>
                                            <p>{!! $page->extras['values_content'] !!}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="container bg-light px-0 border mt-2 border-success border-5 rounded">
                            <h1 class="text-center bg-green text-light m-2 p-3 rounded">Join Us</h1>
                            <div class="card m-2 p-3 px-5 text-center">
                                <div class="px-5">
                                    <h3>{!! $page->extras['cta_header'] !!}</h3>
                                    <p>{!! $page->extras['cta_content'] !!}</p>
                                    <a class="btn bg-green  m-auto rounded-pill text-nowrap" href="/donate-now">Donate Now</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

@endsection
