@extends('layouts.app')

@section('title', 'Donation Confirmation')

@section('css')
    <link href="https://cdn.datatables.net/v/dt/dt-2.1.8/r-3.0.3/datatables.min.css" rel="stylesheet">
    <style>
        .nav .nav-item button.active {
            background-color: transparent;
            color: var(--bs-danger) !important;

        }

        .nav .nav-item button.active::after {
            content: "";
            border-right: 4px solid var(--bs-danger);
            height: 100%;
            position: absolute;
            right: -1px;
            top: 0;
            border-radius: 5px 0 0 5px;
        }

        .rounded-table {
            border-collapse: separate;
            /* Ensure borders are treated separately */
            border-spacing: 0;
            /* Remove spacing between cells */
            border: 2px solid grey;
            /* Change this to your desired border color */
            border-radius: 7px;
            /* Adjust this for more or less rounding */
            overflow: hidden;
            /* Ensures that rounded corners are applied */
        }
    </style>
@endsection

@section('content')
    <div class="container p-0 p-md-5 pb-0">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mx-5 mb-0" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="card shadow m-5">
            <div class="row p-4">
                <div class="col">
                    <h4>{{ Auth::user()->name }}</h4>
                    <h5><i class="bi bi-clock p-1"></i> Last Donated: {{ $lastDonated }}</h5>
                    <h5><i class="bi bi-heart-fill p-1"></i> Donor for {{ $firstDonated }}</h5>
                </div>
            </div>
            <div class="row border-top m-0">
                <div class=" mx-0 px-0 ">
                    <div class="nav nav-pills" id="pills-tab" role="tablist">
                        <a class="nav-link text-nowrap" href="{{ route('my.donation') }}" role="tab"
                            aria-selected="true">Dashboard</a>
                        <a class="nav-link active text-nowrap" href="{{ route('my.donation.notification') }}" role="tab"
                            aria-selected="false">Notifications
                            @if (Auth::user()->unreadNotifications->count() > 0)
                                <span class="text-bg-danger badge text-center">
                                    {{ Auth::user()->unreadNotifications->count() }}
                                </span>
                            @endif
                        </a>
                        <a class="nav-link text-nowrap" href="{{ route('my.donation.history') }}" role="tab"
                            aria-selected="false">Donation History</a>
                        <a class="nav-link text-nowrap" href="{{ route('my.donation.transparency') }}" role="tab"
                            aria-selected="false">Transparency Board</a>
                    </div>

                    <div class="w-100 h-100">
                        <div class="p-3">
                            <h5 class="m-0"><i class="bi bi-bell"></i> Notifications</h5>
                            <!-- Button trigger modal -->
                            {{-- <button type="button" class="btn btn-link" data-bs-toggle="modal"
                                data-bs-target="#receiptDetailsModal">
                                Launch demo modal
                            </button> --}}
                            <table id="notificationTable" class="table table-striped border rounded-table mt-0"
                                style="width:100%">
                                <thead>
                                    <tr class="">
                                        {{-- <th class="text-center">Notification ID</th> --}}
                                        <th class="text-center">Message</th>
                                        <th class="text-center">Date</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($donationNotification as $notification)
                                        {{-- @php
                                            // $data = json_decode($notification->data, true);
                                            dd($notification->id);
                                        @endphp --}}
                                        <tr>
                                            {{-- <td class="text-center">{{ $notification->id }}</td> --}}
                                            <td class="text-center">
                                                {!! $notification->data['message'] !!}
                                            </td>
                                            <td class="text-center">{{ $notification->created_at->format('M/d/Y') }}
                                            </td>
                                            <td class="text-center">
                                                @if (is_null($notification->read_at))
                                                    <!-- Check if the notification is unread -->
                                                    <form action="{{ route('notif.markAsRead', $notification->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('POST')
                                                        <button type="submit" class="btn btn-info">Mark as
                                                            Read</button>
                                                    </form>
                                                @else
                                                    <span class="btn btn-success disabled">Read</span>
                                                    <!-- Show "Read" badge if already read -->
                                                @endif
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="receiptDetailsModal" tabindex="-1" aria-labelledby="receiptDetailsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Donation details will be dynamically loaded here -->
                    <div id="receiptDetailsContent">
                        Loading...
                    </div>
                </div>
                <div class="text-center py-3 border-top">
                    <button type="button" id="printReceiptButton" class="btn btn-dark">
                        <i class="bi bi-printer"></i> Print
                    </button>
                </div>
            </div>
        </div>
    </div>

    </div>
@endsection

@section('scripts')
    <script src="https://cdn.datatables.net/v/dt/dt-2.1.8/r-3.0.3/datatables.min.js"></script>
    <script>
        $(document).ready(function() {

            $('#notificationTable').DataTable({
                searching: false,
                lengthChange: false,
                paging: false,
                ordering: false,
                responsive: true,
                autoWidth: false,
            });


            $('a[data-bs-toggle="pill"]').on('shown.bs.tab', function(e) {
                var targetTab = $(e.target).attr("href"); // Get the target tab
                var table = $(targetTab).find('table').DataTable(); // Get the DataTable instance
                if ($.fn.DataTable.isDataTable(table.table().node())) {
                    table.destroy(); // Destroy if already initialized
                }
                $(targetTab).find('table').DataTable({
                    responsive: true,
                    autoWidth: false,
                });
            });
        });

        function loadRecieptDetails(donationId) {
            // Clear previous details
            document.getElementById('receiptDetailsContent').innerHTML = 'Loading...';

            // Make an AJAX request to get the donation details
            fetch('/donation/receipt-view/' + donationId)
                .then(response => {
                    if (!response.ok) {
                        console.error('HTTP error:', response.status); // Log HTTP status
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    // Extract data from the response
                    console.log('Donation Details:', data);
                    let donationFoodItems = data.foodItems || [];
                    let donationNonFoodItems = data.nonFoodItems || [];
                    let donationMedicineItems = data.medicalItems || [];

                    // Start building items HTML
                    let itemsHtml = `<div><h5>ITEMS</h5>`;

                    // Add Food Items if available
                    if (donationFoodItems.length > 0) {
                        itemsHtml += `
                <div class="p-2 border border-dark rounded my-2">
                    <h5 class="text-center">Food</h5>
                    <table class="table table-striped px-5">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Quantity</th>
                                <th>Expiration Date/Condition</th>
                            </tr>
                        </thead>
                        <tbody>`;
                        donationFoodItems.forEach(item => {
                            itemsHtml += `
                    <tr>
                        <td>${item.item_name}</td>
                        <td>${item.quantity}</td>
                        <td>${item.expiration_date ?? item.condition ?? 'N/A'}</td>
                    </tr>`;
                        });
                        itemsHtml += `
                        </tbody>
                    </table>
                </div>`;
                    }

                    // Add Non-Food Items if available
                    if (donationNonFoodItems.length > 0) {
                        itemsHtml += `
                <div class="p-2 border border-dark rounded my-2">
                    <h5 class="text-center">Non-Food</h5>
                    <table class="table table-striped px-5">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Quantity</th>
                                <th>Condition</th>
                            </tr>
                        </thead>
                        <tbody>`;
                        donationNonFoodItems.forEach(item => {
                            itemsHtml += `
                    <tr>
                        <td>${item.item_name}</td>
                        <td>${item.quantity}</td>
                        <td>${item.condition ?? 'N/A'}</td>
                    </tr>`;
                        });
                        itemsHtml += `
                        </tbody>
                    </table>
                </div>`;
                    }

                    // Add Medical Items if available
                    if (donationMedicineItems.length > 0) {
                        itemsHtml += `
                <div class="p-2 border border-dark rounded my-2">
                    <h5 class="text-center">Medical Supplies</h5>
                    <table class="table table-striped px-5">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Quantity</th>
                                <th>Expiration Date/Condition</th>
                            </tr>
                        </thead>
                        <tbody>`;
                        donationMedicineItems.forEach(item => {
                            itemsHtml += `
                    <tr>
                        <td>${item.item_name}</td>
                        <td>${item.quantity}</td>
                        <td>${item.expiration_date ?? item.condition ?? 'N/A'}</td>
                    </tr>`;
                        });
                        itemsHtml += `
                        </tbody>
                    </table>
                </div>`;
                    }

                    itemsHtml += `</div>`; // Close items container

                    // Populate the modal with donation details
                    let detailsHtml = `
                        <div class="bg-secondary-subtle text-secondary-emphasis py-3 px-4 rounded">
                            <h1 class="text-center">Donation Receipt</h1>
                            <div class="d-flex justify-content-between px-1">
                                <h6>Donation ID: ${data.id}</h6>
                                <h6>${new Date(data.created_at).toLocaleDateString()}</h6>
                            </div>`;
                    if (data.anonymous == false) {
                        detailsHtml += `<div>
                                                <h5>DONATED BY:</h5>
                                                <p class="mb-0 pb-0">${data.name}</p>
                                                <p class="mb-0 pb-0">Contact Number: ${data.contactNumber}</p>
                                                <p>Address: ${data.address}</p>
                                            </div>`;
                    }
                    detailsHtml += `
                            <div>
                                <h5>DONATED TO:</h5>
                                <p>${data.barangay}</p>
                            </div>
                            <div>
                                <h5>DROP OFF SCHEDULE:</h5>
                                <p class="mb-0 pb-0">${new Date(data.dropOffDate).toLocaleDateString()}</p>
                                <p>${data.dropOffTime}</p>
                            </div>
                            ${itemsHtml}
                            <hr>
                            <div>
                                <h5 class="text-end">APPROVED BY:</h5>
                                <h6 class="text-end">${data.approvedBy}</h6>
                            </div>
                        </div>`;

                    // Update modal content
                    document.getElementById('receiptDetailsContent').innerHTML = detailsHtml;
                })
                .catch(error => {
                    console.error('Error fetching donation details:', error);
                    document.getElementById('receiptDetailsContent').innerHTML = 'Error loading details.';
                });
        }

        document.getElementById('printReceiptButton').addEventListener('click', function() {
            // Get the content to print
            const printContent = document.getElementById('receiptDetailsContent').innerHTML;

            // Get all the stylesheets in the main document
            const stylesheets = Array.from(document.styleSheets)
                .map(sheet => {
                    try {
                        return sheet.href ? `<link rel="stylesheet" href="${sheet.href}">` : '';
                    } catch (e) {
                        console.warn("Could not access stylesheet:", sheet);
                        return '';
                    }
                })
                .join('\n');

            // Create a new window
            const printWindow = window.open('', '_blank', 'width=800,height=600');

            // Add the content and styles to the new window
            printWindow.document.open();
            printWindow.document.write(`
        <!DOCTYPE html>
        <html>
        <head>
            <title>Print Receipt</title>
            ${stylesheets}
        </head>
        <body>
            ${printContent}
        </body>
        </html>
    `);
            printWindow.document.close();

            // Wait for the new window to load styles before triggering print
            printWindow.onload = () => {
                printWindow.focus(); // Focus the print window
                printWindow.print(); // Trigger the print dialog
                printWindow.close(); // Close the window after printing
            };
        });
    </script>
@endsection
