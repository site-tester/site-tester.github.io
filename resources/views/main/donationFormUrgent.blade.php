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
                            <div class="mb-3" hidden>
                                <label for="" class="form-label h4">Barangay</label>

                                <select id="barangaySelect" class="w-100" disabled>
                                    @foreach ($barangayLists as $barangay)
                                        <option value="{{ $barangay['id'] }}"
                                            data-flood-risk="{{ $barangay->flood_risk_score }}"
                                            data-fire-risk="{{ $barangay->fire_risk_level }}" data-earthquake-risk="low"
                                            {{ $barangayID === $barangay['id'] ? 'selected' : '' }}>
                                            {{ $barangay['name'] }}
                                        </option>
                                    @endforeach
                                    <input type="hidden" value="{{ $barangayID }}" name="barangay_id" disabled>
                                </select>

                                <div class="ms-3 mt-2 small text-secondary">
                                    <strong>Legend:</strong>
                                    <table class="table table-bordered rounded">
                                        <tr>
                                            <th style="width:50px">Flood</th>
                                            <th style="width:70px">Fire</th>
                                            <th style="width:95%">Description</th>
                                        </tr>
                                        <tr>
                                            <td class="text-danger text-center">
                                                <i class="fas fa-house-flood-water"></i>
                                            </td>
                                            <td class="text-danger text-center" style="width:30px">
                                                <i class="fas fa-house-fire"></i>
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
                                            <td class="text-success">
                                                Low Risk Area
                                            </td>
                                        </tr>

                                    </table>
                                </div>
                            </div>
                            {{-- <div class="mb3">
                                <h4>Barangay:
                                    <span class="fw-normal">
                                        @foreach ($barangayLists as $barangay)
                                            {{ $barangayID === $barangay['id'] ? $barangay['name'] : '' }}
                                        @endforeach
                                    </span>
                                    <input type="hidden" value="{{ $barangayID }}" name="barangay_id">
                                </h4>
                            </div> --}}
                            @php
                                $rawValue = $donationRequest->disaster_type;
                                $rawValue = stripslashes($rawValue);
                                $cleanValue = trim($rawValue, '"');
                                $decoded = json_decode($cleanValue, true);
                                // Apply ucfirst to each item
                                $formatted = array_map('ucfirst', $decoded);
                                $disaster_type = implode(', ', $formatted);
                            @endphp
                            <div class="mb-3 ">

                                <div class="px-3">
                                    <h3>Barangay:
                                        <span class="fw-normal">
                                            @foreach ($barangayLists as $barangay)
                                                {{ $barangayID === $barangay['id'] ? $barangay['name'] : '' }}
                                            @endforeach
                                        </span>
                                        <input type="hidden" value="{{ $barangayID }}" name="barangay_id">
                                    </h3>
                                    <h3
                                        class="@if ($donationRequest->vulnerability == 'High') text-danger
                                    @elseif ($donationRequest->vulnerability == 'Moderate')
                                        text-warning
                                    @elseif ($donationRequest->vulnerability == 'High')
                                        text-success @endif">
                                        {{ $donationRequest->vulnerability }}</h3>
                                    <h5>Type of Disaster: <span class="fw-normal">{{ $disaster_type }}</span></h5>
                                    <h5>Date Reported: <span
                                            class="fw-normal">{{ $donationRequest->created_at->format('M-d-Y') }}</span>
                                    </h5>
                                    {{-- <h5>Estimated Population Affecte:d</h5>
                                    <div class="px-1 px-md-5 py-2">
                                        <table class="table table-bordered">
                                            <tr>
                                                <td class="fw-bold col-2 text-end">Families</td>
                                                <td>{{ $donationRequest->affected_family }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold col-2 text-end">Persons</td>
                                                <td>{{ $donationRequest->affected_person }}</td>
                                            </tr>
                                        </table>
                                    </div> --}}

                                    <h5>Immediate Needs:</h5>
                                    <div class="px-1 px-md-5 py-2">
                                        <table class="table table-bordered">
                                            @if ($donationRequest->immediate_needs_food)
                                                <tr>
                                                    <td class="fw-bold col-2 text-end">Food</td>
                                                    <td>{{ $donationRequest->immediate_needs_food }}</td>
                                                </tr>
                                            @endif

                                            @if ($donationRequest->immediate_needs_nonfood)
                                                <tr>
                                                    <td class="fw-bold col-2 text-end">Non-Food</td>
                                                    <td>{{ $donationRequest->immediate_needs_nonfood }}</td>
                                                </tr>
                                            @endif

                                            @if ($donationRequest->immediate_needs_medicine)
                                                <tr>
                                                    <td class="fw-bold col-2 text-end">Medicine</td>
                                                    <td>{{ $donationRequest->immediate_needs_medicine }}</td>
                                                </tr>
                                            @endif

                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3 donationForm">
                                <label for="" class="m-0 form-label row h4 mb-2">Donation Type</label>
                                {{-- <div class="btn-group btn-group-lg mb-3 w-100" role="group"
                                    aria-label="Basic checkbox toggle button group">
                                    <input type="radio" class="btn-check" name="donation_type" id="btncheck1"
                                        autocomplete="off" value="Food"
                                        {{ $donation_type === 'Food' ? 'checked' : '' }} />
                                    <label class="btn btn-donate-now border border-dark text-nowrap"
                                        for="btncheck1">Food</label>

                                    <input type="radio" class="btn-check" name="donation_type" id="btncheck2"
                                        autocomplete="off" value="NonFood"
                                        {{ $donation_type === 'Nonfood' ? 'checked' : '' }} />
                                    <label class="btn btn-donate-now border border-dark text-nowrap"
                                        for="btncheck2">Non-Food</label>

                                    <input type="radio" class="btn-check" name="donation_type" id="btncheck3"
                                        autocomplete="off" value="Medical"
                                        {{ $donation_type === 'Medical' ? 'checked' : '' }} />
                                    <label class="btn btn-donate-now border border-dark text-nowrap"
                                        for="btncheck3">Medical</label>
                                </div> --}}
                                @php
                                    $preffered_donation_type = json_decode($donationRequest->preffered_donation_type);
                                    // dd($donationRequest->preffered_donation_type );
                                    $incident_date = \Carbon\Carbon::parse($donationRequest->incident_date)->timezone(
                                        'UTC',
                                    );
                                    // dd($donationRequest);
                                @endphp
                                <div class="row">
                                    <div class="col-12 col-md-4 mb-3">
                                        <input type="checkbox" class="btn-check" name="donation_type[]" id="btncheck1"
                                            autocomplete="off" value="Food"
                                            {{ in_array('Food', $preffered_donation_type ?? []) ? 'checked' : '' }} />
                                        <label class="btn btn-donate-now w-100 border border-dark text-nowrap fs-3"
                                            for="btncheck1">Food</label>
                                    </div>

                                    <div class="col-12 col-md-4 mb-3">
                                        <input type="checkbox" class="btn-check" name="donation_type[]" id="btncheck2"
                                            autocomplete="off" value="NonFood"
                                            {{ in_array('NonFood', $preffered_donation_type ?? []) ? 'checked' : '' }} />
                                        <label class="btn btn-donate-now w-100 border border-dark text-nowrap fs-3"
                                            for="btncheck2">Non-Food</label>
                                    </div>

                                    <div class="col-12 col-md-4 mb-3">
                                        <input type="checkbox" class="btn-check" name="donation_type[]" id="btncheck3"
                                            autocomplete="off" value="Medical"
                                            {{ in_array('Medicine', $preffered_donation_type ?? []) ? 'checked' : '' }} />
                                        <label class="btn btn-donate-now w-100 border border-dark text-nowrap fs-3"
                                            for="btncheck3">Medical</label>
                                    </div>
                                </div>

                                <div class="">
                                    <input type="hidden" name="donation-food-basket-array">
                                    <input type="hidden" name="donation-nonfood-basket-array">
                                    <input type="hidden" name="donation-medical-basket-array">
                                    <div id="expirationNote" class="alert alert-warning" style="display: block;">
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
                                                        <th class="fw-bold text-nowrap" style="width: 20%;">Exp. Date</th>
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
                                                                <option value="Piece/s">Piece/s</option>
                                                                <option value="Pack/s">Pack/s</option>
                                                                <option value="Box/es">Box/es</option>
                                                            </select>
                                                        </td>
                                                        <td><input class="form-control donation_food_item_exp"
                                                                type="text" placeholder="Expiration Date"></td>
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
                                                        <th class="fw-bold text-nowrap" style="width: 20%;">Exp. Date</th>
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
                                    <small id="additionalNote" class="fw-bold text-end " style="display: block;">
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
                                    id="schedDate" aria-describedby="helpId" value="{{ $incident_date }}" />
                            </div>
                            <div class="col mb-3">
                                <label for="donationTime" class="form-label h5">Select a Time:</label>
                                <input id="donationTime" class="form-control border border-dark" type="text"
                                    name="donation_time" value="{{ $donationRequest->incident_date }}">
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
            // JSON passed from the controller (decode it in JavaScript)
            const preferredDonationType = JSON.parse(@json($donationRequest->preffered_donation_type));
            // Iterate through the array and toggle visibility
            if (Array.isArray(preferredDonationType)) {
                preferredDonationType.forEach(type => {
                    if (type === "Food") {
                        $('#foodInputs').removeClass('d-none').addClass('d-block');
                    }
                    if (type === "NonFood") {
                        $('#nonFoodInputs').removeClass('d-none').addClass('d-block');
                    }
                    if (type === "Medicine") {
                        $('#medicalInputs').removeClass('d-none').addClass('d-block');
                    }
                });
            } else {
                console.error("preferredDonationType is not an array:", preferredDonationType);
            }

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
                minDate: "today",
            });

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

                    let fireIconClass = 'fas fa-fire-alt';
                    let fireColor = 'green';

                    if (fireRiskLevel == 'high') {
                        fireIconClass = 'fas fa-fire';
                        fireColor = 'red';
                    } else if (fireRiskLevel == 'medium') {
                        fireIconClass = 'fas fa-fire-smoke';
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
