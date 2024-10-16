@extends('layouts.app')

@section('title', 'Profile')

@section('css')
    <link href="https://unpkg.com/smartwizard@6/dist/css/smart_wizard_all.min.css" rel="stylesheet" type="text/css" />

    <link href='https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/south-street/jquery-ui.css' rel='stylesheet'>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">

    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@eonasdan/tempus-dominus@6.9.4/dist/css/tempus-dominus.min.css"
        crossorigin="anonymous"> --}}
@endsection

@section('background-color', 'bg-container')

@section('content')
    <div class="container-fluid m-auto w-75  mt-5">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="card shadow">
            <div class="text-center mt-4">
                <h1 class="text-greener"><strong class="display-3">Donation</strong> Form</h1>
                <hr class="col-1 m-auto text-greener border-3 opacity-50    ">
                <p class="my-3 mt-5 h5 lead">Your Donations go directly to the citezens of the barangay of your choice.</p>
            </div>
            <form action="{{ route('donate.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div id="donateNow" class="p-2 p-md-5">
                    <ul class="nav nav-progress">
                        <li class="nav-item">
                            <a class="nav-link" href="#step-0">
                                <div class="num">1</div>
                                <h5>Select a Barangay</h5>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#step-1">
                                <div class="num">2</div>
                                <h5>Donation Type</h5>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#step-2">
                                <span class="num">3</span>
                                <h5>Donate Items</h5>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#step-3">
                                <span class="num">4</span>
                                <h5>Schedule Appointment</h5>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a id="stepLast" class="nav-link " href="#step-4">
                                <span class="num">5</span>
                                <h5>Upload Image</h5>
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content overflow-auto">
                        <div id="step-0" class="tab-pane mx-2 mx-md-5 donation-type" role="tabpanel"
                            aria-labelledby="step-0">
                            <div class="row align-items-center">
                                @foreach ($barangayLists as $barangay)
                                    <div class="col-6 mb-3"> <!-- Adjust columns as per your requirement -->
                                        <div class="text-center h-100">
                                            <input type="radio" class="btn-check" name="barangay"
                                                id="barangay-{{ $barangay->id }}" value="{{ $barangay->id }}"
                                                autocomplete="off" checked>
                                            <label class="btn p-3 px-5 btn-donate-now w-100 h-100 m-2 fs-3"
                                                for="barangay-{{ $barangay->id }}">
                                                {{ $barangay->name }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div id="step-1" class="tab-pane  mx-2 mx-md-5 donation-type" role="tabpanel"
                            aria-labelledby="step-1">
                            <div class="text-center row align-items-center">
                                <div class="col">
                                    <input type="radio" class="btn-check " name="donation_type" id="food"
                                        value="food" autocomplete="off" checked>
                                    <label class="btn p-3 btn-donate-now w-100  m-2 fs-3" for="food">FOOD</label>
                                </div>
                                <div class="col">
                                    <input type="radio" class="btn-check " name="donation_type" id="nonfood"
                                        value="nonfood" autocomplete="off">
                                    <label class="btn p-3 btn-donate-now w-100  m-2 fs-3" for="nonfood">NON-FOOD</label>
                                </div>
                                <div class="col">
                                    <input type="radio" class="btn-check " name="donation_type" id="medical"
                                        value="medical" autocomplete="off">
                                    <label class="btn p-3 btn-donate-now w-100  m-2 fs-3" for="medical">MEDICAL</label>
                                </div>
                            </div>
                            <div class="text-center mt-3 m-auto">
                                <p><strong>NOTE: </strong> We only accept clothing, personal hygiene items, blankets and
                                    sleeping bags, household supplies, and baby essentials.</p>
                            </div>
                        </div>
                        <div id="step-2" class="tab-pane item-container" role="tabpanel" aria-labelledby="step-2">
                            <div class="row m-auto w-100 px-5">
                                <div class="row">
                                    <input type="hidden" name="donation-basket-array">
                                    <div id="donation-basket" class="border rounded">
                                        <div class="row donation-basket-item border-bottom align-items-center text-center">
                                            <div class="col fw-bold p-2">Item</div>
                                            <div class="col-3 fw-bold">Qty</div>
                                            {{-- <div class="col-3 fw-bold food" hidden>Expiration Date</div> --}}
                                            <div class="col-3 fw-bold"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <input class="col m-1 donation_item_name rounded" type="text"
                                        name="donation_item_name" value="" placeholder="Donation Item">
                                    <input class="col-3 m-1 donation_item_quantity rounded" type="number"
                                        name="donation_item_quantity rounded" value="" placeholder="Qty">
                                    <div class=" col-3 m-1 add-to-donation-basket btn btn-success">+</div>
                                </div>
                            </div>
                        </div>
                        <div id="step-3" class="tab-pane" role="tabpanel" aria-labelledby="step-3">
                            <div class="row">
                                <div id='calendar' class="col-md-5 m-auto ">
                                    <div class="m-auto">
                                        <div class="mb-3">
                                            <label for="schedule_date" class="form-label h1">Date:</label>
                                            <input class="form-control p-3 fs-5" type="text" name="schedule_date"
                                                id="schedule_date">
                                        </div>

                                        <div class="mb-3">
                                            <label for="schedule_time" class="form-label h1">Time:</label>
                                            <input class="form-control p-3 fs-5" type="text" name="schedule_time"
                                                id="schedule_time">
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div id="step-4" class="tab-pane" role="tabpanel" aria-labelledby="step-4">
                            <div class=" file-upload">
                                <div class="container image-upload-wrap image-preview-container">
                                    <div class="drag-text">
                                        <h3>Image Preview</h3>
                                    </div>
                                </div>
                                <input type="file" name="images[]" id="images" multiple>
                                <div class="file-upload-btn mt-5 upload-button text-center" type="button">Add Image</div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/smartwizard@6/dist/js/jquery.smartWizard.min.js" type="text/javascript">
    </script>

    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>

    <script>
        $(document).ready(function() {

            $('#donateNow').smartWizard({
                theme: 'dots',
                justified: true,
                autoAdjustHeight: true,
                backButtonSupport: true,
                transition: {
                    animation: 'fade',
                    speed: '400',
                },
                toolbar: {
                    position: 'bottom', // none|top|bottom|both
                    showNextButton: true, // show/hide a Next button
                    showPreviousButton: true, // show/hide a Previous button
                    extraHtml: `<button id="donationSubmit" class="btn sw-btn" disabled type="submit">Finish</button>`
                },
                anchor: {
                    enableNavigation: true, // Enable/Disable anchor navigation
                    enableNavigationAlways: false, // Activates all anchors clickable always
                    enableDoneState: true, // Add done state on visited steps
                    markPreviousStepsAsDone: true, // When a step selected by url hash, all previous steps are marked done
                    unDoneOnBackNavigation: true, // While navigate back, done state will be cleared
                    enableDoneStateNavigation: true // Enable/Disable the done state navigation
                },
                keyboard: {
                    keyNavigation: false, // Enable/Disable keyboard navigation(left and right keys are used if enabled)
                    keyLeft: [37], // Left key code
                    keyRight: [39] // Right key code
                },
                lang: { // Language variables for button
                    next: 'Next',
                    previous: 'Previous'
                },

            });

            $("#donateNow").on("leaveStep", function(e, anchorObject, currentStepIndex, nextStepIndex,
                stepDirection) {
                if (nextStepIndex == 4 && stepDirection == 'forward') {
                    $("#donationSubmit").removeAttr('disabled');
                }
                if (stepDirection == 'backward' && nextStepIndex == 3) {
                    $("#donationSubmit").prop('disabled', true);
                }
            });

            var donationBasketArray = [];
            $('.add-to-donation-basket').click(function() {
                var donationItemName = $('.donation_item_name').val();
                var donationItemQuantity = $('.donation_item_quantity').val();

                if (donationItemName && donationItemQuantity) {
                    var uniqueId = new Date().getTime();
                    var donationItem = {
                        id: uniqueId,
                        name: donationItemName,
                        quantity: donationItemQuantity
                    };

                    donationBasketArray.push(donationItem);

                    // Update the hidden input field
                    $('[name="donation-basket-array"]').val(JSON.stringify(donationBasketArray));

                    // Append the item to the donation basket
                    var newItem = $(
                        '<div class="row my-1 py-1 donation-basket-item border-bottom align-items-center text-center" data-id="' +
                        uniqueId + '">');
                    newItem.append('<div class="col">' + donationItemName + '</div>');
                    newItem.append('<div class="col-3">' + donationItemQuantity + '</div>');
                    newItem.append(
                        '<div class="col-3"><div class="remove-item btn btn-danger">-</div></div>'
                    );
                    $('#donation-basket').append(newItem);

                    var newHeight = $('#donation-basket').prop('scrollHeight');
                    $('.tab-content').height(newHeight);

                    // Add a click event handler to the remove button
                    newItem.find('.remove-item').click(function() {
                        // Get the unique ID from the data-id attribute
                        var itemId = $(this).parent().data('id');

                        // Filter the donationBasketArray to remove the item with matching ID
                        donationBasketArray = donationBasketArray.filter(function(item) {
                            return item.id !== uniqueId;
                        });

                        // Update the hidden input field
                        $('[name="donation-basket-array"]').val(JSON.stringify(
                            donationBasketArray));

                        // Remove the item from the DOM
                        console.log($(this).parent());
                        // $(this).parent().remove();
                        $(this).closest('.donation-basket-item').remove();
                    });
                } else {
                    alert('Please fill in both Donation Item and Quantity.');
                }
            });

            $(function() {
                $("#schedule_date").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    minDate: '0d'
                });
            });

            $('#schedule_time').timepicker({
                timeFormat: 'HH:mm',
                interval: 30,
                minTime: '08:00', // Minimum time
                maxTime: '16:59', // Maximum time
                dynamic: true,
                dropdown: true,
                scrollbar: true
            });

            // Upload Funtions
            // Store selected files to allow for removal from the preview
            let selectedFiles = [];

            $('.upload-button').on('click', function() {
                $('#images').click(); // Trigger the hidden file input
            });

            // When file input changes (images are selected)
            $('#images').on('change', function(e) {
                const files = this.files;

                // Clear previous previews
                $('.image-preview-container').html('');
                selectedFiles = []; // Reset the selected files

                // Loop through selected files and create previews
                $.each(files, function(index, file) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        const img = $('<div class="image-preview"></div>').css(
                            'background-image', 'url(' + e.target.result + ')');

                        // Create remove button for each image
                        const removeBtn = $('<button class="remove-image">&times;</button>')
                            .click(function() {
                                // Remove image preview
                                $(this).parent().remove();

                                // Remove the file from the selectedFiles array by index
                                selectedFiles.splice(index, 1);

                                // Update the file input with remaining files
                                updateFileInput();
                            });

                        img.append(removeBtn); // Add remove button to the image preview
                        $('.image-preview-container').append(img);

                        // Store the file for potential upload
                        selectedFiles.push(file);
                    };

                    reader.readAsDataURL(file);
                });
            });

            // Update the file input with the remaining files after removal
            function updateFileInput() {
                // Create a new DataTransfer object to simulate file input behavior
                let dataTransfer = new DataTransfer();

                // Loop through the remaining files and add them to the DataTransfer object
                $.each(selectedFiles, function(i, file) {
                    dataTransfer.items.add(file);
                });

                // Update the input with the remaining files
                $('#images')[0].files = dataTransfer.files;
            }

        });
    </script>

@endsection
