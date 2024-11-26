@extends('layouts.app')

@section('title', 'Donate Form')

@section('css')
    <link href="https://unpkg.com/smartwizard@6/dist/css/smart_wizard_all.min.css" rel="stylesheet" type="text/css" />

    <link href='https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/south-street/jquery-ui.css' rel='stylesheet'>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <link href="https://cdn.datatables.net/v/dt/dt-2.1.8/r-3.0.3/datatables.min.css" rel="stylesheet">

    <style>
        .select2-container .select2-selection--single {
            justify-content: center;
            height: 45px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            height: 100% !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 100%;
        }

        .flatpickr-day.selected,
        .flatpickr-day.selected.nextMonthDay {
            background: #5bba6f;
            border-color: #157347;
        }

        .flatpickr-day.selected:hover {
            background: #157347;
            border-color: #5bba6f;
        }
    </style>

@endsection

@section('background-color', 'bg-container')

@section('content')

    <div class="container-fluid m-auto w-75 mt-5">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card  m-0">
            <div class="card-header mb-3 pt-3">
                <div class="row align-items-center justify-content-center">
                    <a class="col-1 " href="{{ url()->previous() }}"><i
                            class="bi bi-arrow-left-circle text-success h1"></i></a>
                    <h1 class="col text-greener"><strong class="display-6">Donation Form</strong></h1>
                </div>
            </div>

            <div class="mx-4 mx-md-5 ">
                <div class="mb-3 row align-items-center justify-content-center justify-content-md-between">
                    <h3 class="col-12 col-md-3">Your information</h3>
                    <div class="col-12 col-md-3">
                        <div class="form-check form-switch float-end d-flex align-items-center">
                            <input class="form-check-input me-2" type="checkbox" role="switch" id="anonymousCheckbox"
                                name="anonymousDonor" value="1">
                            <label class="form-check-label fs-md-5 fs-6" for="anonymousCheckbox"> Donate as
                                Anonymous</label>
                        </div>
                    </div>
                </div>
                <div class="mb-3 p-md-5 bg-secondary-subtle ">
                    <div class="donorAnonymous d-flex justify-content-center d-none">
                        <h3>You are now Anonymous</h3>
                    </div>
                    <div class="donorInformation">
                        <div class="mb-3 px-3">
                            <div class="">
                                <div class="row">
                                    <div class="col-12 col-md-6 mb-3">
                                        <label for="" class="form-label">Full Name</label>
                                        <input type="text" class="form-control" placeholder="{{ Auth::user()->name }}"
                                            readonly />
                                    </div>
                                    @if (Auth::user()->profile->other_details)
                                        <div class="col-12 col-md-6 mb-3">
                                            <label for="" class="form-label">Organization</label>
                                            <input type="text" class="form-control"
                                                placeholder="{{ Auth::user()->profile->other_details ? Auth::user()->profile->other_details : '-' }}"
                                                readonly />
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="">
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Phone</label>
                                            <input type="text" class="form-control"
                                                placeholder="{{ Auth::user()->profile->contact_number }}" readonly />
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Email</label>
                                            <input type="text" class="form-control"
                                                placeholder="{{ Auth::user()->email }}" readonly />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Address</label>
                                <input type="text" class="form-control"
                                    placeholder="{{ Auth::user()->profile->address }}" readonly />
                            </div>
                        </div>
                        <small class="ms-2 mb-3 fs-6 text-secondary">*Edit from your profile</small>
                    </div>
                </div>

                <form action="" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3 p-md-5 bg-secondary-subtle">
                        <div class="px-3">
                            <div class="mb-3">
                                <label for="" class="form-label h4">Barangay</label>

                                <select id="barangaySelect" name="barangay_id" class="w-100">
                                    @foreach ($barangayLists as $barangay)
                                        <option value="{{ $barangay['id'] }}"
                                            data-flood-risk="{{ $barangay->flood_risk_score }}"
                                            data-fire-risk="{{ $barangay->fire_risk_level }}"
                                            data-earthquake-risk="low"
                                            {{ $barangayID === $barangay['id'] ? 'selected' : '' }}>
                                            {{ $barangay['name'] }}
                                        </option>
                                    @endforeach
                                </select>


                                <div class="ms-3 mt-2 small text-secondary">
                                    <strong>Legend:</strong>
                                    <table class="table table-bordered rounded">
                                        <tr>
                                            <th style="min-width:70px" class="text-center">Flood</th>
                                            <th style="min-width:70px" class="text-center">Fire</th>
                                            <th style="min-width:70px" class="text-center">Earhquake</th>
                                            <th style="width:95%">Description</th>
                                        </tr>
                                        <tr>
                                            <td class="text-danger text-center">
                                                <i class="fas fa-house-flood-water"></i>
                                            </td>
                                            <td class="text-danger text-center" style="width:30px">
                                                <i class="fas fa-house-fire"></i>
                                            </td>
                                            <td class="text-success text-center">
                                                <svg width="20" height="20" viewBox="0 0 24 24"
                                                    xmlns="http://www.w3.org/2000/svg" fill="#dc3545">
                                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                        stroke-linejoin="round"></g>
                                                    <g id="SVGRepo_iconCarrier">
                                                        <g>
                                                            <path fill="none" d="M0 0h24v24H0z"></path>
                                                            <path fill-rule="nonzero"
                                                                d="M5 21a1 1 0 0 1-.993-.883L4 20v-9H1l10.327-9.388a1 1 0 0 1 1.246-.08l.1.08L23 11h-3v9a1 1 0 0 1-.883.993L19 21H5zm7-17.298L6 9.156V19h4.357l1.393-1.5L8 14l5-3-2.5-2 3-3-.5 3 2.5 2-4 3 3.5 3-1.25 2H18V9.157l-6-5.455z">
                                                            </path>
                                                        </g>
                                                    </g>
                                                </svg>
                                            </td>
                                            <td class="text-danger text-start">
                                                High Risk Area
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-warning text-center">
                                                <i class="fas fa-tint"></i>
                                            </td>
                                            <td class="text-warning text-center">
                                                <i class="fa-solid fa-fire"></i>
                                            </td>
                                            <td class="text-success text-center">
                                                <svg fill="#ffc107" height="20" width="20" version="1.1"
                                                    id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 413 413"
                                                    xml:space="preserve">
                                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                        stroke-linejoin="round"></g>
                                                    <g id="SVGRepo_iconCarrier">
                                                        <g>
                                                            <path
                                                                d="M291.114,114.452l-74.069-55.029c-4.794-3.561-12.015-3.548-16.793,0.034l-73.412,55.01 c-2.652,1.987-3.191,5.748-1.204,8.399c1.987,2.653,5.748,3.192,8.399,1.204l73.412-55.01c0.514-0.385,1.539-0.635,2.442-0.005 l74.068,55.029c1.075,0.799,2.329,1.184,3.573,1.184c1.834,0,3.643-0.837,4.821-2.422 C294.328,120.186,293.774,116.428,291.114,114.452z">
                                                            </path>
                                                            <path
                                                                d="M408,243.893c0,0-62.375,0-83.166,0c-4.583,0-4.229-3.8-4.229-3.8V133.966c0,0-0.229-2.655,2.895-2.655 c2.942,0,11.771,0,11.771,0c5.165,0,8.031-2.989,8.991-5.787c0.961-2.797,0.535-6.917-3.54-10.089L318.073,97.8 c-1.073-1.021-1.26-2.242-1.26-2.864V55.135c0-6.341-5.159-11.5-11.5-11.5h-26.914c-6.341,0-11.5,5.159-11.5,11.5 c0,0,0,0.717,0,0.956c0,2.209-1.535,0.67-1.535,0.67L216.417,18.65c-2.149-1.674-4.906-2.596-7.763-2.596s-5.613,0.922-7.764,2.596 L76.587,115.435c-4.076,3.172-4.502,7.292-3.541,10.089c0.96,2.798,3.826,5.787,8.991,5.787c0,0,9.487,0,12.649,0 c2.231,0,2.016,2.405,2.016,2.405v107.562c0,0,0.36,2.615-3.515,2.615c-22.047,0-88.187,0-88.187,0c-2.75,0-5,2.25-5,5v143.053 c0,2.75,2.25,5,5,5h5c2.75,0,5-2.25,5-5V263.893c0-2.75,2.25-5,5-5h88.202h70.267h60.371h70.266H393c2.75,0,5,2.25,5,5v128.053 c0,2.75,2.25,5,5,5h5c2.75,0,5-2.25,5-5V248.893C413,246.143,410.75,243.893,408,243.893z M281.899,59.53 c0-0.875,0.872-0.895,0.872-0.895h17.935c0,0,1.107-0.043,1.107,1.145c0,5.795,0,16.39,0,21.854c0,1.375-0.762,0.693-0.762,0.693 l-18.679-15.51c-0.178-0.229-0.474-0.475-0.474-1.008C281.899,65.809,281.899,61.099,281.899,59.53z M189.826,206.728 c-0.003-0.088-0.068-9.02,5.132-14.402c2.957-3.061,7.171-4.548,12.883-4.548c18.583,0,19.545,15.962,19.55,19.112 c-0.028,2.226-0.051,5.867-0.051,8.093l-0.006,25.918c0,0,0.166,2.992-3.522,2.992c-7.825,0-21.958,0-31.302,0 c-2.677,0-2.542-2.057-2.542-2.057v-26.854C189.969,212.692,189.905,208.988,189.826,206.728z M245.75,243.893 c-3.5,0-3.41-3.107-3.41-3.107v-25.803c0-2.175,0.023-5.732,0.049-7.907c0.02-1.516-0.098-15.091-9.833-24.946 c-6.128-6.205-14.443-9.352-24.715-9.352c-9.855,0-17.819,3.07-23.67,9.126c-9.58,9.915-9.389,23.791-9.335,25.342 c0.072,2.083,0.133,5.626,0.133,7.737v26.936c0,0,0.073,1.975-2.177,1.975c-14.526,0-43.034,0-58.105,0 c-3.103,0-2.985-2.742-2.985-2.742v-113.34c0-5.79-4.488-9.752-9.876-11.386c-1.514-0.459-0.032-1.607-0.032-1.607l104.473-81.344 c0,0,1.172-1.092,2.4-1.092c1.104,0,2.26,1.003,2.26,1.003l104.175,81.112c0,0,2.461,1.594-0.155,2.017 c-5.339,0.863-9.341,5.693-9.341,11.297v112.203c0,0,0.311,3.879-4.104,3.879C287.564,243.893,260.714,243.893,245.75,243.893z">
                                                            </path>
                                                            <path
                                                                d="M369.581,327.196h-39.32c-2.75,0-6.435,1.733-8.187,3.853l-24.824,30.008c-1.752,2.119-3.915,1.724-4.806-0.878 l-12.419-36.277c-0.891-2.602-3.833-4.331-6.539-3.843l-34.563,6.24c-2.707,0.488-5.293-1.331-5.747-4.043l-7.117-42.48 c-0.454-2.712-2.199-3.148-3.878-0.971l-62.678,81.332c-1.679,2.179-3.705,1.808-4.503-0.824l-20.547-67.75 c-0.798-2.632-2.915-3.076-4.704-0.988l-32.163,37.538c-1.789,2.089-5.503,3.797-8.253,3.797H46.598c-2.75,0-5,2.25-5,5v2 c0,2.75,2.25,5,5,5h48.258c2.75,0,6.464-1.708,8.253-3.797l21.511-25.106c1.789-2.088,3.906-1.644,4.704,0.988l20.957,69.102 c0.798,2.632,2.824,3.003,4.503,0.824l60.109-77.998c1.679-2.178,3.424-1.74,3.878,0.972l4.578,27.33 c0.454,2.712,3.04,4.532,5.747,4.044l36.377-6.568c2.706-0.488,5.648,1.241,6.539,3.843l16.019,46.797 c0.891,2.602,3.054,2.997,4.807,0.878l34.883-42.168c1.753-2.119,5.438-3.853,8.188-3.853h33.674c2.75,0,5-2.25,5-5v-2 C374.581,329.446,372.331,327.196,369.581,327.196z">
                                                            </path>
                                                        </g>
                                                    </g>
                                                </svg>
                                            </td>
                                            <td class="text-warning">
                                                Moderate Risk Area
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-success text-center">
                                                <i class="fas fa-water"></i>
                                            </td>
                                            <td class="text-success text-center">
                                                <i class="fa-solid fa-fire-flame-simple"></i>
                                            </td>
                                            <td class="text-success text-center">
                                                <svg fill="#198754" version="1.1" id="Layer_1" height="20"
                                                    width="20" xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 92 92"
                                                    enable-background="new 0 0 92 92" xml:space="preserve">
                                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                        stroke-linejoin="round"></g>
                                                    <g id="SVGRepo_iconCarrier">
                                                        <path id="XMLID_1181_"
                                                            d="M92,57c0,2.2-1.8,4-4,4H69.2c-1.7,0-3.2-0.9-3.8-2.6l-3-8.4l-9.8,33.1c-0.5,1.7-2.1,2.9-3.8,2.9 c0,0-0.1,0-0.1,0c-1.8-0.1-3.4-1.3-3.8-3.1L32,27l-7.8,31.1c-0.4,1.8-2,2.9-3.9,2.9H4c-2.2,0-4-1.8-4-4s1.8-4,4-4h13.2L28.3,8.9 C28.7,7.1,30.4,6,32.2,6c1.8,0,3.4,1.3,3.9,3.1l13.2,57.2l9-30.4c0.5-1.7,2-2.9,3.7-2.9c1.7-0.1,3.3,1,3.9,2.6L72,53h16 C90.2,53,92,54.8,92,57z">
                                                        </path>
                                                    </g>
                                                </svg>
                                            </td>
                                            <td class="text-success">
                                                Low Risk Area
                                            </td>
                                        </tr>

                                    </table>
                                </div>
                            </div>

                            <div class="mb-3 donationForm">
                                <label for="" class="m-0 form-label row h4 mb-2">Donation Type</label>

                                <div class="row">
                                    <div class="col-12 col-md-4 mb-3">
                                        <input type="checkbox" class="btn-check" name="donation_type[]" id="btncheck1"
                                            autocomplete="off" value="Food"
                                            {{ in_array('Food', $donation_type ?? []) ? 'checked' : '' }} />
                                        <label class="btn btn-donate-now w-100 border border-dark text-nowrap fs-3"
                                            for="btncheck1">Food</label>
                                    </div>

                                    <div class="col-12 col-md-4 mb-3">
                                        <input type="checkbox" class="btn-check" name="donation_type[]" id="btncheck2"
                                            autocomplete="off" value="NonFood"
                                            {{ in_array('NonFood', $donation_type ?? []) ? 'checked' : '' }} />
                                        <label class="btn btn-donate-now w-100 border border-dark text-nowrap fs-3"
                                            for="btncheck2">Non-Food</label>
                                    </div>

                                    <div class="col-12 col-md-4 mb-3">
                                        <input type="checkbox" class="btn-check" name="donation_type[]" id="btncheck3"
                                            autocomplete="off" value="Medical"
                                            {{ in_array('Medical', $donation_type ?? []) ? 'checked' : '' }} />
                                        <label class="btn btn-donate-now w-100 border border-dark text-nowrap fs-3"
                                            for="btncheck3">Medical</label>
                                    </div>
                                </div>

                                <div class="">
                                    <input type="hidden" name="donation-food-basket-array">
                                    <input type="hidden" name="donation-nonfood-basket-array">
                                    <input type="hidden" name="donation-medical-basket-array">
                                    <div id="expirationNote" class="alert alert-warning" style="display: none;">
                                        Please ensure that donated food items and medical supplies have an expiration date
                                        of at least 1 year from the donation date. Items expiring sooner will not be
                                        accepted.
                                    </div>
                                    <div id="foodInputs" class="d-none">
                                        <h5>Food Donation</h5>
                                        <div class="table-responsive">
                                            <table class="table table-bordered text-center">
                                                <thead>
                                                    <tr class="donation-food-basket-item">
                                                        <th class="fw-bold" style="width: 25%;">Item</th>
                                                        <th class="fw-bold text-nowrap">Quantity</th>
                                                        <th class="fw-bold text-nowrap">Unit</th>
                                                        <th class="fw-bold text-nowrap" style="width: 20%;">Expiration
                                                            Date</th>
                                                        <th class="fw-bold text-nowrap" style="width: 15%;">Image</th>
                                                        <th style="width: 5%;"></th>
                                                    </tr>
                                                </thead>
                                                <tbody id="donation-food-basket">
                                                    <!-- Dynamic food donation items will go here -->
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td><input class="form-control donation_food_item_name"
                                                                type="text" placeholder="Item"></td>
                                                        <td><input class="form-control donation_food_item_quantity"
                                                                min="1" type="number" placeholder="Quantity">
                                                        </td>
                                                        <td>
                                                            <select class="form-control donation_food_item_qty_con">
                                                                <option value="" disabled selected hidden>
                                                                </option>
                                                                <option value="Piece/s">Pc/s</option>
                                                                <option value="Pack/s">Pack/s</option>
                                                                <option value="Box/es">Box/es</option>
                                                            </select>
                                                        </td>
                                                        <td><input class="form-control donation_food_item_exp"
                                                                type="text" placeholder="Exp. Date"></td>
                                                        <td><input class="form-control donation_food_item_image"
                                                                type="file" accept="image/*"
                                                                name="donation_food_item_image"></td>
                                                        <td><button type="button"
                                                                class="btn btn-success add-to-donation-food-basket">+</button>
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>

                                    <!-- Table inputs for Non-Food -->
                                    <div id="nonFoodInputs" class="d-none">
                                        <h5>Non-Food Donation</h5>
                                        <div class="table-responsive">
                                            <table class="table table-bordered text-center">
                                                <thead>
                                                    <tr class="donation-nonfood-basket-item">
                                                        <th class="fw-bold" style="width: 25%;">Item</th>
                                                        <th class="fw-bold text-nowrap">Quantity</th>
                                                        <th class="fw-bold text-nowrap">Unit</th>
                                                        <th class="fw-bold text-nowrap" style="width: 20%;">Condition</th>
                                                        <th class="fw-bold text-nowrap" style="width: 15%;">Image</th>
                                                        <th style="width: 5%;"></th>
                                                    </tr>
                                                </thead>
                                                <tbody id="donation-nonfood-basket">
                                                    <!-- Dynamic non-food donation items will go here -->
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td><input class="form-control donation_nonfood_item_name"
                                                                type="text" placeholder="Item"></td>
                                                        <td><input class="form-control donation_nonfood_item_quantity"
                                                                type="number" placeholder="Quantity" min="1">
                                                        </td>
                                                        <td>
                                                            <select class="form-control donation_nonfood_item_qty_con">
                                                                <option value="" disabled selected hidden>
                                                                </option>
                                                                <option value="Piece/s">Pc/s</option>
                                                                <option value="Pack/s">Pack/s</option>
                                                                <option value="Box/es">Box/es</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <select class="form-control donation_nonfood_item_condition"
                                                                id="conditionSelect">
                                                                <option value="" disabled selected hidden>Condition
                                                                </option>
                                                                <option value="New">New</option>
                                                                <option value="Used Like New">Used Like New</option>
                                                                <option value="Used Good">Used Good</option>
                                                                <option value="Used Fair">Used Fair</option>
                                                            </select>
                                                        </td>
                                                        <td><input class="form-control donation_nonfood_item_image"
                                                                type="file" accept="image/*"
                                                                name="donation_nonfood_item_image"></td>
                                                        <td><button type="button"
                                                                class="btn btn-success add-to-donation-nonfood-basket">+</button>
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>


                                    <div id="medicalInputs" class="d-none">
                                        <h5>Medical Donation</h5>
                                        <div class="table-responsive">
                                            <table class="table table-bordered text-center">
                                                <thead>
                                                    <tr class="donation-medical-basket-item">
                                                        <th class="fw-bold" style="width: 25%;">Item</th>
                                                        <th class="fw-bold text-nowrap">Quantity</th>
                                                        <th class="fw-bold text-nowrap">Unit</th>
                                                        <th class="fw-bold text-nowrap" style="width: 20%;">Expiration
                                                            Date</th>
                                                        <th class="fw-bold text-nowrap" style="width: 15%;">Image</th>
                                                        <th style="width: 5%;"></th>
                                                    </tr>
                                                </thead>
                                                <tbody id="donation-medical-basket">
                                                    <!-- Dynamic medical donation items will go here -->
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td><input class="form-control donation_medical_item_name"
                                                                type="text" placeholder="Item"></td>
                                                        <td><input class="form-control donation_medical_item_quantity"
                                                                min="1" type="number" placeholder="Quantity">
                                                        </td>
                                                        <td>
                                                            <select class="form-control donation_medical_item_qty_con">
                                                                <option value="" disabled selected hidden>
                                                                </option>
                                                                <option value="Piece/s">Pc/s</option>
                                                                <option value="Pack/s">Pack/s</option>
                                                                <option value="Box/es">Box/es</option>
                                                            </select>
                                                        </td>
                                                        <td><input class="form-control donation_medical_item_exp"
                                                                type="text" placeholder="Expiration Date">
                                                        </td>
                                                        <td><input class="form-control donation_medical_item_image"
                                                                type="file" accept="image/*"
                                                                name="donation_food_item_image"></td>
                                                        <td><button type="button"
                                                                class="btn btn-success add-to-donation-medical-basket">+</button>
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                    <small id="additionalNote" class="fw-bold text-end " style="display: none;">
                                        * If the expiration date of an item is different from others, please add it as a new
                                        item.
                                        <br>
                                        *Ensure the expiration date is clearly visible in your photo. If not, you may need
                                        to resubmit the form with a clearer image.
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 p-md-5 bg-secondary-subtle">
                        <label for="" class="m-0 form-label row h4 mb-2">Scheduling of Appointment</label>
                        <div class="row mx-2">
                            <div class="col mb-3">
                                <label for="schedDate" class="form-label h5">Select a Date:</label>
                                <input type="text" class="form-control border border-dark" name="schedule_date"
                                    id="schedDate" aria-describedby="helpId" placeholder="Select a Date" />
                            </div>
                            <div class="col mb-3">
                                <label for="donationTime" class="form-label h5">Select a Time:</label>
                                <input id="donationTime" class="form-control border border-dark" type="text"
                                    name="donation_time">


                            </div>

                        </div>
                    </div>


                    <div class="text-center mb-5">
                        <button id="submit-donation" class="btn bg-green  px-5">
                            <h1>Send Donation Form</h1>
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        $(document).ready(function() {

            $('#anonymousCheckbox').on('change', function() {
                if ($(this).is(':checked')) {
                    $('.donorInformation').fadeOut(); // Hide when checked
                    $('.donorAnonymous').fadeIn().removeClass('d-none').addClass('d-block');
                } else {
                    $('.donorInformation').fadeIn(); // Show when unchecked
                    $('.donorAnonymous').fadeOut().removeClass('d-block').addClass('d-none');
                }
            });

            flatpickr("#donationTime", {
                enableTime: true,
                noCalendar: true,
                inline: true,
                dateFormat: "h:i K",
                time_24hr: false,
            });

            flatpickr("#schedDate", {
                inline: true,
                // defaultDate: new Date(),
                minDate: "today",
            });
            // $("#donationTime").flatpickr([
            //     enableTime: true,
            //     noCalendar: true,
            //     dateFormat: "H:i",
            //     time_24hr: false,
            // ]);

            // Call the function to disable past time slots
            // disablePastTimeSlots();

            const $foodInputs = $('#foodInputs');
            const $nonFoodInputs = $('#nonFoodInputs');
            const $medicalInputs = $('#medicalInputs');

            $('#btncheck1').on('click', function() {
                if ($(this).is(':checked')) {
                    $foodInputs.removeClass('d-none'); // Show food inputs
                    $('#expirationNote').fadeIn(); // Show expiration note
                    $('#additionalNote').fadeIn(); // Show additional note
                } else {
                    $foodInputs.addClass('d-none'); // Hide food inputs
                    if (!$('#btncheck3').is(':checked')) {
                        $('#expirationNote').fadeOut(); // Hide expiration note
                        $('#additionalNote').fadeOut(); // Hide additional note
                    }
                }
            });

            $('#btncheck2').on('click', function() {
                if ($(this).is(':checked')) {
                    $nonFoodInputs.removeClass('d-none'); // Show non-food inputs
                } else {
                    $nonFoodInputs.addClass('d-none'); // Hide non-food inputs
                }
            });

            $('#btncheck3').on('click', function() {
                if ($(this).is(':checked')) {
                    $medicalInputs.removeClass('d-none'); // Show medical inputs
                    $('#expirationNote').fadeIn(); // Show expiration note
                    $('#additionalNote').fadeIn(); // Show additional note
                } else {
                    $medicalInputs.addClass('d-none'); // Hide medical inputs
                    if (!$('#btncheck1').is(':checked')) {
                        $('#expirationNote').fadeOut(); // Hide expiration note
                        $('#additionalNote').fadeOut(); // Hide additional note
                    }

                }
            });


            var donationBasketArray = [];
            var nonfoodBasketArray = [];
            var medicalBasketArray = [];
            var donationFoodFormData = new FormData();
            var donationNonFoodFormData = new FormData();
            var donationMedicalFormData = new FormData();
            var removedItemIds = [];

            $('.add-to-donation-food-basket').click(function() {
                var donationItemName = $('.donation_food_item_name').val();
                var donationItemQuantity = $('.donation_food_item_quantity').val();
                var donationItemQtyCon = $('.donation_food_item_qty_con').val();
                var donationItemExp = $('.donation_food_item_exp').val();
                var donationItemImage = $('.donation_food_item_image')[0].files[0]; // Get the image file

                if (donationItemName && donationItemQuantity && donationItemExp && donationItemImage) {
                    var uniqueId = new Date().getTime();

                    var formattedQuantity = donationItemQuantity + ' ' + donationItemQtyCon;

                    donationFoodFormData.append(`food_name_${uniqueId}`,
                        donationItemName); // Use array notation
                    donationFoodFormData.append(`food_quantity_${uniqueId}`,
                        formattedQuantity); // Use array notation
                    donationFoodFormData.append(`food_expiration_${uniqueId}`,
                        donationItemExp); // Use array notation
                    donationFoodFormData.append(`food_image_${uniqueId}`,
                        donationItemImage); // Use array notation

                    // Add item to the basket array
                    var donationItem = {
                        id: uniqueId,
                        name: donationItemName,
                        quantity: formattedQuantity,
                        expiration: donationItemExp,
                        imagePreview: URL.createObjectURL(
                            donationItemImage) // Generate a preview URL for the image
                    };

                    donationBasketArray.push(donationItem);

                    // Update hidden input field with JSON data
                    $('[name="donation-food-basket-array"]').val(JSON.stringify(donationBasketArray));

                    // Append the new item to the donation basket
                    var newItem = $('<tr class="donation-food-basket-item" data-id="' + uniqueId + '">');
                    newItem.append('<td>' + donationItemName + '</td>');
                    newItem.append('<td colspan="2">' + formattedQuantity + '</td>');
                    newItem.append('<td>' + donationItemExp + '</td>');
                    newItem.append('<td><img src="' + donationItem.imagePreview +
                        '" class="img-thumbnail" width="50"/></td>');
                    newItem.append('<td><button class="remove-item btn btn-danger">-</button></td>');
                    $('#donation-food-basket').append(newItem);

                    // Clear input fields
                    $('.donation_food_item_name').val('');
                    $('.donation_food_item_quantity').val('');
                    $('.donation_food_item_qty_con').val('');
                    $('.donation_food_item_exp').val('');
                    $('.donation_food_item_image').val('');

                    // Remove item event
                    newItem.find('.remove-item').click(function() {
                        var itemId = $(this).closest('.donation-food-basket-item').data('id');

                        // Track the ID of the removed item
                        removedItemIds.push(itemId);

                        // Remove item from array
                        donationBasketArray = donationBasketArray.filter(function(item) {
                            return item.id !== itemId;
                        });

                        // Update the hidden input field
                        $('[name="donation-food-basket-array"]').val(JSON.stringify(
                            donationBasketArray));

                        // Remove item from DOM
                        $(this).closest('.donation-food-basket-item').remove();
                    });
                } else {
                    alert('Please fill in all fields and upload an image.');
                }
            });

            $('.add-to-donation-nonfood-basket').click(function() {
                var donationItemName = $('.donation_nonfood_item_name').val();
                var donationItemQuantity = $('.donation_nonfood_item_quantity').val();
                var donationItemQtyCon = $('.donation_nonfood_item_qty_con').val();
                var donationItemCondition = $('.donation_nonfood_item_condition').val();
                var donationItemImage = $('.donation_nonfood_item_image')[0].files[0]; // Get the image file

                if (donationItemName && donationItemQuantity && donationItemImage &&
                    donationItemCondition) {
                    var uniqueId = new Date().getTime();

                    var formattedQuantity = donationItemQuantity + ' ' + donationItemQtyCon;

                    // Create FormData to handle the file upload (for server-side upload)
                    donationNonFoodFormData.append(`nonfood_name_${uniqueId}`, donationItemName);
                    donationNonFoodFormData.append(`nonfood_quantity_${uniqueId}`, formattedQuantity);
                    donationNonFoodFormData.append(`nonfood_condition_${uniqueId}`, donationItemCondition);
                    donationNonFoodFormData.append(`nonfood_image_${uniqueId}`,
                        donationItemImage); // Append the image file

                    // Add item to the basket array
                    var donationItem = {
                        id: uniqueId,
                        name: donationItemName,
                        quantity: formattedQuantity,
                        condition: donationItemCondition,
                        imagePreview: URL.createObjectURL(
                            donationItemImage) // Generate a preview URL for the image
                    };

                    nonfoodBasketArray.push(donationItem);

                    // Update hidden input field with JSON data
                    $('[name="donation-nonfood-basket-array"]').val(JSON.stringify(nonfoodBasketArray));

                    // Append the new item to the donation basket
                    var newItem = $('<tr class="donation-nonfood-basket-item" data-id="' + uniqueId + '">');
                    newItem.append('<td>' + donationItemName + '</td>');
                    newItem.append('<td colspan="2">' + formattedQuantity + '</td>');
                    newItem.append('<td>' + donationItemCondition + '</td>');
                    newItem.append('<td><img src="' + donationItem.imagePreview +
                        '" class="img-thumbnail" width="50"/></td>');
                    newItem.append('<td><button class="remove-item btn btn-danger">-</button></td>');
                    $('#donation-nonfood-basket').append(newItem);


                    // Clear input fields
                    $('.donation_nonfood_item_name').val('');
                    $('.donation_nonfood_item_quantity').val('');
                    $('.donation_nonfood_item_qty_con').val('');
                    $('.donation_nonfood_item_condition').val('');
                    $('.donation_nonfood_item_image').val('');

                    // Remove item event
                    newItem.find('.remove-item').click(function() {
                        var itemId = $(this).closest('.donation-nonfood-basket-item').data('id');

                        removedItemIds.push(itemId);

                        // Remove item from array
                        nonfoodBasketArray = nonfoodBasketArray.filter(function(item) {
                            return item.id !== itemId;
                        });

                        // Update the hidden input field
                        $('[name="donation-nonfood-basket-array"]').val(JSON.stringify(
                            nonfoodBasketArray));

                        // Remove item from DOM
                        $(this).closest('.donation-nonfood-basket-item').remove();
                    });
                } else {
                    alert('Please fill in all fields and upload an image.');
                }
            });

            $('.add-to-donation-medical-basket').click(function() {
                var donationItemName = $('.donation_medical_item_name').val();
                var donationItemQuantity = $('.donation_medical_item_quantity').val();
                var donationItemQtyCon = $('.donation_medical_item_qty_con').val();
                var donationItemCondition = $('.donation_medical_item_exp').val();
                var donationItemImage = $('.donation_medical_item_image')[0].files[0]; // Get the image file

                if (donationItemName && donationItemQuantity && donationItemImage &&
                    donationItemCondition) {
                    var uniqueId = new Date().getTime();

                    var formattedQuantity = donationItemQuantity + ' ' + donationItemQtyCon;

                    // Create FormData to handle the file upload (for server-side upload)
                    donationMedicalFormData.append(`medical_name_${uniqueId}`, donationItemName);
                    donationMedicalFormData.append(`medical_quantity_${uniqueId}`, formattedQuantity);
                    donationMedicalFormData.append(`medical_condition_${uniqueId}`, donationItemCondition);
                    donationMedicalFormData.append(`medical_image_${uniqueId}`,
                        donationItemImage); // Append the image file

                    // Add item to the basket array
                    var donationItem = {
                        id: uniqueId,
                        name: donationItemName,
                        quantity: formattedQuantity,
                        condition: donationItemCondition,
                        imagePreview: URL.createObjectURL(
                            donationItemImage) // Generate a preview URL for the image
                    };

                    medicalBasketArray.push(donationItem);

                    // Update hidden input field with JSON data
                    $('[name="donation-medical-basket-array"]').val(JSON.stringify(medicalBasketArray));

                    // Append the new item to the donation basket
                    var newItem = $('<tr class="donation-medical-basket-item" data-id="' + uniqueId + '">');
                    newItem.append('<td>' + donationItemName + '</td>');
                    newItem.append('<td colspan="2">' + formattedQuantity + '</td>');
                    newItem.append('<td>' + donationItemCondition + '</td>');
                    newItem.append('<td><img src="' + donationItem.imagePreview +
                        '" class="img-thumbnail" width="50"/></td>');
                    newItem.append('<td><button class="remove-item btn btn-danger">-</button></td>');
                    $('#donation-medical-basket').append(newItem);


                    // Clear input fields
                    $('.donation_medical_item_name').val('');
                    $('.donation_medical_item_quantity').val('');
                    $('.donation_medical_item_qty_con').val('');
                    $('.donation_medical_item_exp').val('');
                    $('.donation_medical_item_image').val('');

                    // Remove item event
                    newItem.find('.remove-item').click(function() {
                        var itemId = $(this).closest('.donation-medical-basket-item').data('id');

                        removedItemIds.push(itemId);

                        // Remove item from array
                        medicalBasketArray = medicalBasketArray.filter(function(item) {
                            return item.id !== itemId;
                        });

                        // Update the hidden input field
                        $('[name="donation-medical-basket-array"]').val(JSON.stringify(
                            medicalBasketArray));

                        // Remove item from DOM
                        $(this).closest('.donation-medical-basket-item').remove();
                    });
                } else {
                    alert('Please fill in all fields and upload an image.');
                }
            });

            function filterFormData(originalFormData) {
                let newFormData = new FormData();
                originalFormData.forEach((value, key) => {
                    let itemId = key.split('_').pop(); // Get unique item ID from the key
                    if (!removedItemIds.includes(Number(itemId))) {
                        // Remove the uniqueId suffix from the key
                        let baseKey = key.replace(/_\d+$/, '') + '[]';

                        // Append to the new FormData without the uniqueId
                        newFormData.append(baseKey, value);
                    }
                });
                return newFormData;
            }

            $('#submit-donation').on('click', function(event) {
                event.preventDefault();

                // Global FormData to hold all data
                var combinedFormData = new FormData();

                // Get the CSRF token from the meta tag
                var csrfToken = $('meta[name="csrf-token"]').attr('content');

                // Append the CSRF token to the FormData
                combinedFormData.append('_token', csrfToken);

                // Append the 'anonymous' donation option
                combinedFormData.append('anonymous', $('input[name="anonymousDonor"]:checked').val());

                // Append barangay and other form data
                combinedFormData.append('barangay', $('#barangaySelect').val());

                // Get the selected donation types (multiple checkboxes)
                var selectedDonationTypes = $('input[name="donation_type[]"]:checked').map(function() {
                    return this.value;
                }).get(); // Get as an array of values

                // Append selected donation types as a JSON string
                combinedFormData.append('donation_type', JSON.stringify(selectedDonationTypes));

                // Append schedule date and time slot
                combinedFormData.append('schedule_date', $('#schedDate').val());
                combinedFormData.append('time_slot', $('#donationTime').val());

                // Append food donation data to combinedFormData
                let filteredFoodData = filterFormData(donationFoodFormData);
                for (var pair of filteredFoodData.entries()) {
                    combinedFormData.append(pair[0], pair[1]);
                }

                // Append non-food donation data to combinedFormData
                let filteredNonFoodData = filterFormData(donationNonFoodFormData);
                for (var pair of filteredNonFoodData.entries()) {
                    combinedFormData.append(pair[0], pair[1]);
                }

                // Append medical donation data to combinedFormData
                let filteredMedicalData = filterFormData(donationMedicalFormData);
                for (var pair of filteredMedicalData.entries()) {
                    combinedFormData.append(pair[0], pair[1]);
                }

                // Perform AJAX request with combinedFormData
                $.ajax({
                    url: '{{ route('donate.store') }}',
                    type: 'POST',
                    data: combinedFormData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        console.log('AJAX Success:',
                            response); // Log the response for debugging
                        if (response.redirect_url) {
                            window.location.href = response
                                .redirect_url; // Redirect if URL is provided
                        } else {
                            alert(
                                'Success, but no redirect URL provided. Check server response.'
                            );
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', {
                            status: status,
                            error: error,
                            response: xhr.responseText
                        });
                        // Display detailed error for debugging
                        // alert(
                        //     'Error occurred:\n' +
                        //     'Status: ' + xhr.status + ' (' + xhr.statusText + ')\n' +
                        //     'Response: ' + xhr.responseText
                        // );
                    }
                });
            });

            $(function() {
                $(".donation_food_item_exp").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    minDate: '+1y' // Minimum date set to 1 year from now
                });

                $(".donation_medical_item_exp").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    minDate: '+1y' // Minimum date set to 1 year from now
                });

                // $("#schedDate").datepicker({
                //     changeMonth: true,
                //     changeYear: true,
                // });
            });

            $('#barangaySelect').select2({
                templateResult: function(data) {
                    if (!data.id) {
                        return data.text; // Return the placeholder text if no selection
                    }

                    // Get the flood and fire risk scores from data attributes
                    const floodRiskScore = $(data.element).data('flood-risk');
                    const fireRiskLevel = $(data.element).data('fire-risk');
                    const earthquakeRiskLevel = $(data.element).data('earthquake-risk');

                    // Determine flood icon and color
                    let floodIconClass = 'fas fa-water';
                    let floodColor = 'green';

                    if (floodRiskScore > 7) {
                        floodIconClass = 'fas fa-house-flood-water';
                        floodColor = 'red';
                    } else if (floodRiskScore > 3) {
                        floodIconClass = 'fas fa-tint';
                        floodColor = 'orange';
                    }

                    // Determine fire icon and color
                    let fireIconClass = 'fas fa-fire-flame-simple';
                    let fireColor = 'green';

                    if (fireRiskLevel == 'high') {
                        fireIconClass = 'fas fa-house-fire';
                        fireColor = 'red';
                    } else if (fireRiskLevel == 'medium') {
                        fireIconClass = 'fas fa-fire';
                        fireColor = 'orange';
                    }

                    // just placeholders
                    let earthquakeIconClass = ' ';
                    let earthquakeColor = ' ';
                    let earthquakeSVG =
                        '<svg fill="#198754" version="1.1" id="Layer_1" height="20" width="20" xmlns="http://www.w3.org/2000/svg"  xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 92 92"  enable-background="new 0 0 92 92" xml:space="preserve"> <g id="SVGRepo_bgCarrier" stroke-width="0"></g> <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g> <g id="SVGRepo_iconCarrier"> <path id="XMLID_1181_" d="M92,57c0,2.2-1.8,4-4,4H69.2c-1.7,0-3.2-0.9-3.8-2.6l-3-8.4l-9.8,33.1c-0.5,1.7-2.1,2.9-3.8,2.9 c0,0-0.1,0-0.1,0c-1.8-0.1-3.4-1.3-3.8-3.1L32,27l-7.8,31.1c-0.4,1.8-2,2.9-3.9,2.9H4c-2.2,0-4-1.8-4-4s1.8-4,4-4h13.2L28.3,8.9 C28.7,7.1,30.4,6,32.2,6c1.8,0,3.4,1.3,3.9,3.1l13.2,57.2l9-30.4c0.5-1.7,2-2.9,3.7-2.9c1.7-0.1,3.3,1,3.9,2.6L72,53h16 C90.2,53,92,54.8,92,57z"> </path> </g> </svg>';

                    if (earthquakeRiskLevel == 'high') {
                        earthquakeIconClass = ' ';
                        earthquakeColor = ' ';
                    } else if (earthquakeRiskLevel == ' ') {
                        earthquakeIconClass = ' ';
                        earthquakeColor = ' ';
                    }

                    // Create a custom option with both icons
                    const $result = $(`
                        <div style="display: flex; align-items: center; height: 100%;">
                            <i class="${floodIconClass}" style="color: ${floodColor}; margin-right: 8px;"></i>
                            <i class="${fireIconClass}" style="color: ${fireColor}; margin-right: 8px;"></i>
                            <div style="margin-right: 8px;"">
                                ${earthquakeSVG}
                            </div>
                            ${data.text}
                        </div>
                    `);

                    return $result;
                },
                templateSelection: function(data) {
                    if (!data.id) {
                        return data.text; // Return the placeholder text if no selection
                    }

                    // Get flood and fire risk scores for the selected item
                    const floodRiskScore = $(data.element).data('flood-risk');
                    const fireRiskLevel = $(data.element).data('fire-risk');
                    const earthquakeRiskLevel = $(data.element).data('earthquake-risk');

                    let floodIconClass = 'fas fa-water';
                    let floodColor = 'green';

                    if (floodRiskScore > 7) {
                        floodIconClass = 'fas fa-house-flood-water';
                        floodColor = 'red';
                    } else if (floodRiskScore > 3) {
                        floodIconClass = 'fas fa-tint';
                        floodColor = 'orange';
                    }

                    let fireIconClass = 'fas fa-fire-flame-simple';
                    let fireColor = 'green';

                    if (fireRiskLevel == 'high') {
                        fireIconClass = 'fas fa-house-fire';
                        fireColor = 'red';
                    } else if (fireRiskLevel == 'medium') {
                        fireIconClass = 'fas fa-fire';
                        fireColor = 'orange';
                    }

                    // just placeholders
                    let earthquakeIconClass = ' ';
                    let earthquakeColor = ' ';
                    let earthquakeSVG =
                        '<svg fill="#198754" version="1.1" id="Layer_1" height="20" width="20" xmlns="http://www.w3.org/2000/svg"  xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 92 92"  enable-background="new 0 0 92 92" xml:space="preserve"> <g id="SVGRepo_bgCarrier" stroke-width="0"></g> <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g> <g id="SVGRepo_iconCarrier"> <path id="XMLID_1181_" d="M92,57c0,2.2-1.8,4-4,4H69.2c-1.7,0-3.2-0.9-3.8-2.6l-3-8.4l-9.8,33.1c-0.5,1.7-2.1,2.9-3.8,2.9 c0,0-0.1,0-0.1,0c-1.8-0.1-3.4-1.3-3.8-3.1L32,27l-7.8,31.1c-0.4,1.8-2,2.9-3.9,2.9H4c-2.2,0-4-1.8-4-4s1.8-4,4-4h13.2L28.3,8.9 C28.7,7.1,30.4,6,32.2,6c1.8,0,3.4,1.3,3.9,3.1l13.2,57.2l9-30.4c0.5-1.7,2-2.9,3.7-2.9c1.7-0.1,3.3,1,3.9,2.6L72,53h16 C90.2,53,92,54.8,92,57z"> </path> </g> </svg>';

                    if (earthquakeRiskLevel == 'high') {
                        earthquakeIconClass = ' ';
                        earthquakeColor = ' ';
                    } else if (earthquakeRiskLevel == ' ') {
                        earthquakeIconClass = ' ';
                        earthquakeColor = ' ';
                    }

                    const $selection = $(`
                            <div style="display: flex; align-items: center; height: 100%;">
                                <i class="${floodIconClass}" style="color: ${floodColor}; margin-right: 8px;"></i>
                                <i class="${fireIconClass}" style="color: ${fireColor}; margin-right: 8px;"></i>
                                <div style="margin-right: 8px;"">
                                    ${earthquakeSVG}
                                </div>
                                ${data.text}
                            </div>
                        `);

                    return $selection;
                }
            });

        });
    </script>
@endsection
