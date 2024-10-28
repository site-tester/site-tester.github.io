@extends('layouts.app')

@section('title', 'Donate Form')

@section('css')
    <link href="https://unpkg.com/smartwizard@6/dist/css/smart_wizard_all.min.css" rel="stylesheet" type="text/css" />

    <link href='https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/south-street/jquery-ui.css' rel='stylesheet'>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> --}}

    <style>
        .select2-container .select2-selection--single{
            justify-content: center;
            height: 45px;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered{
            height: 100% !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow{
            height: 100%;
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
                <h3 class="mb-3">Your information</h3>
                <div class="mb-3 p-md-5 bg-secondary-subtle">
                    <div class="mb-3 px-3">
                        <div class="mb-3">
                            <div class="row">
                                <div class="col">
                                    <label for="" class="form-label">Full Name</label>
                                    <input type="text" class="form-control" placeholder="{{ Auth::user()->name }}"
                                        readonly />
                                </div>
                                @if (Auth::user()->profile->other_details)
                                    <div class="col">
                                        <label for="" class="form-label">Organization</label>
                                        <input type="text" class="form-control"
                                            placeholder="{{ Auth::user()->profile->other_details ? Auth::user()->profile->other_details : '-' }}"
                                            readonly />
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Phone</label>
                                        <input type="text" class="form-control"
                                            placeholder="{{ Auth::user()->profile->contact_number }}" readonly />
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Email</label>
                                        <input type="text" class="form-control" placeholder="{{ Auth::user()->email }}"
                                            readonly />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Address</label>
                            <input type="text" class="form-control" placeholder="{{ Auth::user()->profile->address }}"
                                readonly />
                        </div>
                    </div>
                    <small class="ms-2 mb-3 fs-6 text-secondary">*Edit from your profile</small>
                </div>

                <form action="" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3 p-md-5 bg-secondary-subtle">
                        <div class="px-3">
                            <div class="mb-3 row align-items-center justify-content-center" hidden>
                                <div class="form-check col">
                                    <input class="form-check-input border border-success" type="checkbox" value="true"
                                        id="anonymousCheckbox" name="anonymousDonor" />
                                    <label class="form-check-label h5" for="anonymousCheckbox"> Donate Anonymously </label>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="" class="form-label h4">Barangay</label>

                                <select id="barangaySelect" name="barangay_id" class="w-100 ">
                                    @foreach ($barangayLists as $barangay)
                                        <option value="{{ $barangay['id'] }}" data-risk="{{ $barangay->flood_risk_score }}" {{$barangayID === $barangay['id'] ? 'selected': ''}}>
                                            {{ $barangay['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="ms-3 mt-2 small text-muted">
                                    <strong>Legend:</strong>
                                    <ul>
                                        <li><span class="text-danger"><i class="fas fa-house-flood-water"></i> High Risk Area</span></li>
                                        <li><span class="text-warning"><i class="fas fa-tint"></i> Moderate Risk Area</span></li>
                                        <li><span class="text-success"><i class="fas fa-water"></i> Low Risk Area</span></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="mb-3 donationForm">
                                <label for="" class="m-0 form-label row h4 mb-2">Donation Type</label>
                                <div class="btn-group btn-group-lg mb-3 w-100" role="group"
                                    aria-label="Basic checkbox toggle button group">
                                    <input type="radio" class="btn-check" name="donation_type" id="btncheck1"
                                        autocomplete="off" value="Food" {{$donation_type === 'Food'? 'checked' :'' }}/>
                                    <label class="btn btn-donate-now border border-dark text-nowrap"
                                        for="btncheck1">Food</label>

                                    <input type="radio" class="btn-check" name="donation_type" id="btncheck2"
                                        autocomplete="off" value="NonFood" {{$donation_type === 'Nonfood'? 'checked' :'' }}/>
                                    <label class="btn btn-donate-now border border-dark text-nowrap"
                                        for="btncheck2">Non-Food</label>

                                    <input type="radio" class="btn-check" name="donation_type" id="btncheck3"
                                        autocomplete="off" value="Medical" {{$donation_type === 'Medical'? 'checked' :'' }}/>
                                    <label class="btn btn-donate-now border border-dark text-nowrap"
                                        for="btncheck3">Medical</label>
                                </div>

                                <div class="">
                                    <input type="hidden" name="donation-food-basket-array">
                                    <input type="hidden" name="donation-nonfood-basket-array">
                                    <input type="hidden" name="donation-medical-basket-array">
                                    <div id="foodInputs" class="d-block">
                                        <h5>Food Donation</h5>
                                        <div id="donation-food-basket" class="border rounded">
                                            <div
                                                class="row mx-0 donation-food-basket-item border border-dark align-items-center text-center">
                                                <div class="col fw-bold p-2">Item</div>
                                                <div class="col-1 fw-bold text-nowrap">Qty</div>
                                                <div class="col-2 fw-bold text-nowrap">Exp Date</div>
                                                <div class="col-2 fw-bold text-nowrap">Image</div>
                                                <div class="col-2 fw-bold"> </div>
                                            </div>
                                        </div>
                                        <div class="row mx-1">
                                            <input class="col m-1 donation_food_item_name rounded fs-6" type="text"
                                                placeholder="Item">
                                            <input class="col-2 m-1 donation_food_item_quantity rounded fs-6"
                                                min="1" type="number" placeholder="Qty">
                                            <input class="col-2 m-1 donation_food_item_exp rounded fs-6" type="text"
                                                placeholder="Exp. Date">
                                            <input class="col-2 m-1 donation_food_item_image btn fs-6" type="file"
                                                accept="image/*" name="donation_food_item_image">
                                            <div class="col-1 m-1 add-to-donation-food-basket btn btn-success">+</div>
                                        </div>
                                    </div>

                                    <!-- Table inputs for Non-Food -->
                                    <div id="nonFoodInputs" class="d-none">
                                        <h5>Non-Food Donation</h5>
                                        <div id="donation-nonfood-basket" class="border rounded">
                                            <div
                                                class="row mx-0 donation-nonfood-basket-item border border-dark align-items-center text-center">
                                                <div class="col fw-bold p-2">Item</div>
                                                <div class="col-1 fw-bold text-nowrap">Qty</div>
                                                <div class="col-2 fw-bold text-nowrap">Condition</div>
                                                <div class="col-2 fw-bold text-nowrap">Image</div>
                                                <div class="col-2 fw-bold"></div>
                                            </div>
                                        </div>
                                        <div class="row mx-1">
                                            <input class="col m-1 donation_nonfood_item_name rounded fs-6" type="text"
                                                placeholder="Item">
                                            <input class="col-2 m-1 donation_nonfood_item_quantity rounded fs-6"
                                                type="number" placeholder="Qty" min="1">
                                            <select class="col-2 m-1 donation_nonfood_item_condition rounded fs-6"
                                                id="conditionSelect">
                                                <option value="" disabled selected hidden>Condition</option>
                                                <option value="New">New</option>
                                                <option value="Used Like New">Used Like New</option>
                                                <option value="Used Good">Used New</option>
                                                <option value="Used Fair">Used Fair</option>
                                            </select>
                                            <input class="col-2 m-1 donation_nonfood_item_image rounded btn"
                                                type="file" accept="image/*" name="donation_nonfood_item_image">
                                            <div class="col-1 m-1 add-to-donation-nonfood-basket btn btn-success">+</div>
                                        </div>
                                    </div>

                                    <div id="medicalInputs" class="d-none">
                                        <h5>Medical Donation</h5>
                                        <div id="donation-medical-basket" class="border rounded">
                                            <div
                                                class="row mx-0 donation-medical-basket-item border border-dark align-items-center text-center">
                                                <div class="col fw-bold p-2">Item</div>
                                                <div class="col-1 fw-bold text-nowrap">Qty</div>
                                                <div class="col-2 fw-bold text-nowrap">Condition</div>
                                                <div class="col-2 fw-bold text-nowrap">Image</div>
                                                <div class="col-2 fw-bold"> </div>
                                            </div>
                                        </div>
                                        <div class="row mx-1">
                                            <input class="col m-1 donation_medical_item_name rounded fs-6" type="text"
                                                placeholder="Item">
                                            <input class="col-2 m-1 donation_medical_item_quantity rounded fs-6"
                                                min="1" type="number" placeholder="Qty">
                                            <select class="col-2 m-1 donation_medical_item_condition rounded fs-6"
                                                id="conditionMedicalSelect">
                                                <option value="" disabled selected hidden>Condition</option>
                                                <option value="New">New</option>
                                                <option value="Used Like New">Used Like New</option>
                                                <option value="Used Good">Used New</option>
                                                <option value="Used Fair">Used Fair</option>
                                            </select>
                                            <input class="col-2 m-1 donation_medical_item_image btn fs-6" type="file"
                                                accept="image/*" name="donation_food_item_image">
                                            <div class="col-1 m-1 add-to-donation-medical-basket btn btn-success">+</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 p-md-5 bg-secondary-subtle">
                        <label for="" class="m-0 form-label row h4 mb-2">Scheduling of Appointment</label>
                        <div class="row mx-2">
                            <div class="mb-3">
                                <label for="" class="form-label h5">Select a Date:</label>
                                <input type="text" class="form-control border border-dark" name="schedule_date"
                                    id="schedDate" aria-describedby="helpId" placeholder="Select a Date" />
                            </div>
                            <div class="mb-3">
                                <div class="mb-3">
                                    <div class="time-slot-group donationForm">
                                        <label class="form-label h5 mb-0">Morning</label><br>
                                        <small class="fs-6">9:00 AM to 12:00 PM</small>
                                        <div class="row mb-1">
                                            <!-- Time slot radio buttons -->
                                            {{-- <div class="col-12 col-md-6 col-lg-4 mb-2">
                                                <input type="radio" class="btn-check" name="time_slot" id="time7"
                                                    value="07:00 AM - 08:00 AM" autocomplete="off">
                                                <label class="btn btn-donate-now border border-light fs-6 text-nowrap w-100"
                                                    for="time7">7:00 AM - 8:00 AM</label>
                                            </div>

                                            <div class="col-12 col-md-6 col-lg-4 mb-2">
                                                <input type="radio" class="btn-check" name="time_slot" id="time8"
                                                    value="08:00 AM - 09:00 AM" autocomplete="off">
                                                <label class="btn btn-donate-now border border-light fs-6 text-nowrap w-100"
                                                    for="time8">8:00 AM - 9:00 AM</label>
                                            </div> --}}

                                            <div class="col-12 col-md-6 col-lg-4 mb-2">
                                                <input type="radio" class="btn-check" name="time_slot" id="time9"
                                                    value="09:00 AM - 10:00 AM" autocomplete="off">
                                                <label class="btn btn-donate-now border border-dark fs-6 text-nowrap w-100"
                                                    for="time9">9:00 AM - 10:00 AM</label>
                                            </div>

                                            <div class="col-12 col-md-6 col-lg-4 mb-2">
                                                <input type="radio" class="btn-check" name="time_slot" id="time10"
                                                    value="10:00 AM - 11:00 AM" autocomplete="off">
                                                <label class="btn btn-donate-now border border-dark fs-6 text-nowrap w-100"
                                                    for="time10">10:00 AM - 11:00 AM</label>
                                            </div>

                                            <div class="col-12 col-md-6 col-lg-4 mb-2">
                                                <input type="radio" class="btn-check" name="time_slot" id="time11"
                                                    value="11:00 AM - 12:00 PM" autocomplete="off">
                                                <label class="btn btn-donate-now border border-dark fs-6 text-nowrap w-100"
                                                    for="time11">11:00 AM - 12:00 PM</label>
                                            </div>
                                        </div>
                                        <label class="form-label h5 mb-0">Afternoon</label><br>
                                        <small class="fs-6">1:00 PM to 5:00 PM</small>
                                        <div class="row mb-1">
                                            {{-- <div class="col-12 col-md-6 col-lg-4 mb-2">
                                                <input type="radio" class="btn-check" name="time_slot" id="time12"
                                                    value="12:00 PM - 01:00 PM" autocomplete="off">
                                                <label class="btn btn-donate-now border border-light fs-6 text-nowrap w-100"
                                                    for="time12">12:00 PM - 1:00 PM</label>
                                            </div> --}}

                                            <div class="col-12 col-md-6 col-lg-4 mb-2">
                                                <input type="radio" class="btn-check" name="time_slot" id="time13"
                                                    value="01:00 PM - 02:00 PM" autocomplete="off">
                                                <label class="btn btn-donate-now border border-dark fs-6 text-nowrap w-100"
                                                    for="time13">1:00 PM - 2:00 PM</label>
                                            </div>

                                            <div class="col-12 col-md-6 col-lg-4 mb-2">
                                                <input type="radio" class="btn-check" name="time_slot" id="time14"
                                                    value="02:00 PM - 03:00 PM" autocomplete="off">
                                                <label class="btn btn-donate-now border border-dark fs-6 text-nowrap w-100"
                                                    for="time14">2:00 PM - 3:00 PM</label>
                                            </div>

                                            <div class="col-12 col-md-6 col-lg-4 mb-2">
                                                <input type="radio" class="btn-check" name="time_slot" id="time15"
                                                    value="03:00 PM - 04:00 PM" autocomplete="off">
                                                <label class="btn btn-donate-now border border-dark fs-6 text-nowrap w-100"
                                                    for="time15">3:00 PM - 4:00 PM</label>
                                            </div>

                                            <div class="col-12 col-md-6 col-lg-4 mb-2">
                                                <input type="radio" class="btn-check" name="time_slot" id="time16"
                                                    value="04:00 PM - 05:00 PM" autocomplete="off">
                                                <label class="btn btn-donate-now border border-dark fs-6 text-nowrap w-100"
                                                    for="time16">4:00 PM - 5:00 PM</label>
                                            </div>
                                        </div>
                                        <label class="form-label h5 mb-0">Evening</label><br>
                                        <small class="fs-6 mt-0">5:00 PM to 10:00 PM</small>
                                        <div class="row mb-1">
                                            <div class="col-12 col-md-6 col-lg-4 mb-2">
                                                <input type="radio" class="btn-check" name="time_slot" id="time17"
                                                    value="05:00 PM - 06:00 PM" autocomplete="off">
                                                <label class="btn btn-donate-now border border-dark fs-6 text-nowrap w-100"
                                                    for="time17">5:00 PM - 6:00 PM</label>
                                            </div>

                                            <div class="col-12 col-md-6 col-lg-4 mb-2">
                                                <input type="radio" class="btn-check" name="time_slot" id="time18"
                                                    value="06:00 PM - 07:00 PM" autocomplete="off">
                                                <label class="btn btn-donate-now border border-dark fs-6 text-nowrap w-100"
                                                    for="time18">6:00 PM - 7:00 PM</label>
                                            </div>

                                            <div class="col-12 col-md-6 col-lg-4 mb-2">
                                                <input type="radio" class="btn-check" name="time_slot" id="time19"
                                                    value="7:00 PM - 8:00 PM" autocomplete="off">
                                                <label class="btn btn-donate-now border border-dark fs-6 text-nowrap w-100"
                                                    for="time19">7:00 PM - 8:00 PM</label>
                                            </div>

                                            <div class="col-12 col-md-6 col-lg-4 mb-2">
                                                <input type="radio" class="btn-check" name="time_slot" id="time20"
                                                    value="8:00 PM - 9:00 PM" autocomplete="off">
                                                <label class="btn btn-donate-now border border-dark fs-6 text-nowrap w-100"
                                                    for="time20">8:00 PM - 9:00 PM</label>
                                            </div>

                                            <div class="col-12 col-md-6 col-lg-4 mb-2">
                                                <input type="radio" class="btn-check" name="time_slot" id="time21"
                                                    value="9:00 PM - 10:00 PM" autocomplete="off">
                                                <label class="btn btn-donate-now border border-dark fs-6 text-nowrap w-100"
                                                    for="time21">9:00 PM - 10:00 PM</label>
                                            </div>
                                        </div>
                                    </div>

                                </div>

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
    <script>
        $(document).ready(function() {
            // $('#barangaySelect').select2({
            //     placeholder: 'Select a Barangay',
            // });

            const $foodInputs = $('#foodInputs');
            const $nonFoodInputs = $('#nonFoodInputs');
            const $medicalInputs = $('#medicalInputs');

            $('#btncheck1').on('click', function() {
                $foodInputs.removeClass('d-none');
                $nonFoodInputs.addClass('d-none');
                $medicalInputs.addClass('d-none');
            });

            $('#btncheck2').on('click', function() {
                $nonFoodInputs.removeClass('d-none');
                $foodInputs.addClass('d-none');
                $medicalInputs.addClass('d-none');
            });

            $('#btncheck3').on('click', function() {
                $medicalInputs.removeClass('d-none');
                $nonFoodInputs.addClass('d-none');
                $foodInputs.addClass('d-none');
            });

            var donationBasketArray = [];
            var nonfoodBasketArray = [];
            var medicalBasketArray = [];
            var donationFoodFormData = new FormData();
            var donationNonFoodFormData = new FormData();
            var donationMedicalFormData = new FormData();

            $('.add-to-donation-food-basket').click(function() {
                var donationItemName = $('.donation_food_item_name').val();
                var donationItemQuantity = $('.donation_food_item_quantity').val();
                var donationItemExp = $('.donation_food_item_exp').val();
                var donationItemImage = $('.donation_food_item_image')[0].files[0]; // Get the image file

                if (donationItemName && donationItemQuantity && donationItemExp && donationItemImage) {
                    var uniqueId = new Date().getTime();

                    donationFoodFormData.append('food_name[]', donationItemName); // Use array notation
                    donationFoodFormData.append('food_quantity[]',
                        donationItemQuantity); // Use array notation
                    donationFoodFormData.append('food_expiration[]', donationItemExp); // Use array notation
                    donationFoodFormData.append('food_image[]', donationItemImage); // Use array notation

                    // Add item to the basket array
                    var donationItem = {
                        id: uniqueId,
                        name: donationItemName,
                        quantity: donationItemQuantity,
                        expiration: donationItemExp,
                        imagePreview: URL.createObjectURL(
                            donationItemImage) // Generate a preview URL for the image
                    };

                    donationBasketArray.push(donationItem);

                    // Update hidden input field with JSON data
                    $('[name="donation-food-basket-array"]').val(JSON.stringify(donationBasketArray));

                    // Append the new item to the donation basket
                    var newItem = $(
                        '<div class="row my-1 mx-0 py-1 donation-food-basket-item border border-dark align-items-center text-center" data-id="' +
                        uniqueId + '">');
                    newItem.append('<div class="col">' + donationItemName + '</div>');
                    newItem.append('<div class="col-2">' + donationItemQuantity + '</div>');
                    newItem.append('<div class="col-2">' + donationItemExp + '</div>');
                    newItem.append('<div class="col-3"><img src="' + donationItem.imagePreview +
                        '" class="img-thumbnail" width="50"/></div>');
                    newItem.append(
                        '<div class="col-1"><div class="remove-item btn btn-danger">-</div></div>');
                    $('#donation-food-basket').append(newItem);

                    // Clear input fields
                    $('.donation_food_item_name').val('');
                    $('.donation_food_item_quantity').val('');
                    $('.donation_food_item_exp').val('');
                    $('.donation_food_item_image').val('');

                    // Remove item event
                    newItem.find('.remove-item').click(function() {
                        var itemId = $(this).closest('.donation-food-basket-item').data('id');

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
                var donationItemCondition = $('.donation_nonfood_item_condition').val();
                var donationItemImage = $('.donation_nonfood_item_image')[0].files[0]; // Get the image file

                if (donationItemName && donationItemQuantity && donationItemImage &&
                    donationItemCondition) {
                    var uniqueId = new Date().getTime();

                    // Create FormData to handle the file upload (for server-side upload)
                    donationNonFoodFormData.append('nonfood_name[]', donationItemName);
                    donationNonFoodFormData.append('nonfood_quantity[]', donationItemQuantity);
                    donationNonFoodFormData.append('nonfood_condition[]', donationItemCondition);
                    donationNonFoodFormData.append('nonfood_image[]',
                        donationItemImage); // Append the image file

                    // Add item to the basket array
                    var donationItem = {
                        id: uniqueId,
                        name: donationItemName,
                        quantity: donationItemQuantity,
                        condition: donationItemCondition,
                        imagePreview: URL.createObjectURL(
                            donationItemImage) // Generate a preview URL for the image
                    };

                    nonfoodBasketArray.push(donationItem);

                    // Update hidden input field with JSON data
                    $('[name="donation-nonfood-basket-array"]').val(JSON.stringify(nonfoodBasketArray));

                    // Append the new item to the donation basket
                    var newItem = $(
                        '<div class="row my-1 mx-0 py-1 donation-nonfood-basket-item border border-dark align-items-center text-center" data-id="' +
                        uniqueId + '">');
                    newItem.append('<div class="col">' + donationItemName + '</div>');
                    newItem.append('<div class="col-2">' + donationItemQuantity + '</div>');
                    newItem.append('<div class="col-2">' + donationItemCondition + '</div>');
                    newItem.append('<div class="col-3"><img src="' + donationItem.imagePreview +
                        '" class="img-thumbnail" width="50"/></div>');
                    newItem.append(
                        '<div class="col-1"><div class="remove-item btn btn-danger">-</div></div>');
                    $('#donation-nonfood-basket').append(newItem);

                    // Clear input fields
                    $('.donation_nonfood_item_name').val('');
                    $('.donation_nonfood_item_quantity').val('');
                    $('.donation_nonfood_item_condition').val('');
                    $('.donation_nonfood_item_image').val('');

                    // Remove item event
                    newItem.find('.remove-item').click(function() {
                        var itemId = $(this).closest('.donation-nonfood-basket-item').data('id');

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
                var donationItemCondition = $('.donation_medical_item_condition').val();
                var donationItemImage = $('.donation_medical_item_image')[0].files[0]; // Get the image file

                if (donationItemName && donationItemQuantity && donationItemImage &&
                    donationItemCondition) {
                    var uniqueId = new Date().getTime();

                    // Create FormData to handle the file upload (for server-side upload)
                    donationMedicalFormData.append('medical_name[]', donationItemName);
                    donationMedicalFormData.append('medical_quantity[]', donationItemQuantity);
                    donationMedicalFormData.append('medical_condition[]', donationItemCondition);
                    donationMedicalFormData.append('medical_image[]',
                        donationItemImage); // Append the image file

                    // Add item to the basket array
                    var donationItem = {
                        id: uniqueId,
                        name: donationItemName,
                        quantity: donationItemQuantity,
                        condition: donationItemCondition,
                        imagePreview: URL.createObjectURL(
                            donationItemImage) // Generate a preview URL for the image
                    };

                    medicalBasketArray.push(donationItem);

                    // Update hidden input field with JSON data
                    $('[name="donation-medical-basket-array"]').val(JSON.stringify(medicalBasketArray));

                    // Append the new item to the donation basket
                    var newItem = $(
                        '<div class="row my-1 mx-0 py-1 donation-medical-basket-item border border-dark align-items-center text-center" data-id="' +
                        uniqueId + '">');
                    newItem.append('<div class="col">' + donationItemName + '</div>');
                    newItem.append('<div class="col-2">' + donationItemQuantity + '</div>');
                    newItem.append('<div class="col-2">' + donationItemCondition + '</div>');
                    newItem.append('<div class="col-3"><img src="' + donationItem.imagePreview +
                        '" class="img-thumbnail" width="50"/></div>');
                    newItem.append(
                        '<div class="col-1"><div class="remove-item btn btn-danger">-</div></div>');
                    $('#donation-medical-basket').append(newItem);

                    // Clear input fields
                    $('.donation_medical_item_name').val('');
                    $('.donation_medical_item_quantity').val('');
                    $('.donation_medical_item_condition').val('');
                    $('.donation_medical_item_image').val('');

                    // Remove item event
                    newItem.find('.remove-item').click(function() {
                        var itemId = $(this).closest('.donation-medical-basket-item').data('id');

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

            $('#submit-donation').on('click', function(event) {
                event.preventDefault();

                // Global FormData to hold all data
                var combinedFormData = new FormData();

                // Get the CSRF token from the meta tag
                var csrfToken = $('meta[name="csrf-token"]').attr('content');

                // Append the CSRF token to the FormData
                combinedFormData.append('_token', csrfToken);

                // Append barangay and other form data
                combinedFormData.append('anonymous', $('input[name="anonymousDonor"]:checked').val());
                combinedFormData.append('barangay', $('#barangaySelect').val());
                combinedFormData.append('donation_type', $('input[name="donation_type"]:checked').val());
                combinedFormData.append('schedule_date', $('#schedDate').val());
                combinedFormData.append('time_slot', $('input[name="time_slot"]:checked').val());

                // Append food donation data to combinedFormData
                for (var pair of donationFoodFormData.entries()) {
                    combinedFormData.append(pair[0], pair[1]);
                }

                // Append non-food donation data to combinedFormData
                for (var pair of donationNonFoodFormData.entries()) {
                    combinedFormData.append(pair[0], pair[1]);
                }

                // Append medical donation data to combinedFormData
                for (var pair of donationMedicalFormData.entries()) {
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
                        console.log(response);
                        // Handle success
                        window.location.href = response.redirect_url;
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        // Handle error
                    }
                });
            });

            $(function() {
                $(".donation_food_item_exp").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    minDate: '0d'
                });
                $("#schedDate").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    minDate: '0d'
                });
            });

            $('#barangaySelect').select2({
                templateResult: function(data) {
                    if (!data.id) {
                        return data.text; // Return the placeholder text if no selection
                    }

                    // Get the flood risk score from data attributes
                    const riskScore = $(data.element).data('risk');

                    // Determine icon and color based on flood risk score
                    let iconClass = 'fas fa-water'; // Default icon
                    let color = 'green'; // Default color

                    if (riskScore > 7) {
                        iconClass = 'fas fa-house-flood-water';
                        color = 'red';
                    } else if (riskScore > 3) {
                        iconClass = 'fas fa-tint';
                        color = 'orange';
                    }

                    // Create a custom option with an icon
                    const $result = $(
                        `<div style="display: flex; align-items: center; height: 100%;">
                    <i class="${iconClass}" style="color: ${color}; margin-right: 8px;"></i>
                    ${data.text}
                </div>`
                    );

                    return $result;
                },
                templateSelection: function(data) {
                    if (!data.id) {
                        return data.text; // Return the placeholder text if no selection
                    }

                    // Create a selected item with an icon
                    const riskScore = $(data.element).data('risk');
                    let iconClass = 'fas fa-water';
                    let color = 'green';

                    if (riskScore > 7) {
                        iconClass = 'fas fa-house-flood-water';
                        color = 'red';
                    } else if (riskScore > 3) {
                        iconClass = 'fas fa-tint';
                        color = 'orange';
                    }

                    const $selection = $(
                        `<div style="display: flex; align-items: center; height: 100%;">
                    <i class="${iconClass}" style="color: ${color}; margin-right: 8px;"></i>
                    ${data.text}
                </div>`
                    );

                    return $selection;
                }
            });
        });
    </script>
@endsection
