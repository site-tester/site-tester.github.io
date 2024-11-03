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
                        <a class="nav-link text-nowrap" href="{{ route('my.donation') }}" role="tab" aria-selected="true">Dashboard</a>
                        <a class="nav-link text-nowrap" href="{{ route('my.donation.notification') }}" role="tab" aria-selected="false">Notifications
                            @if (Auth::user()->unreadNotifications->count() > 0)
                                <span class="text-bg-danger badge text-center">
                                    {{ Auth::user()->unreadNotifications->count() }}
                                </span>
                            @endif
                        </a>
                        <a class="nav-link text-nowrap" href="{{ route('my.donation.history') }}" role="tab" aria-selected="false">Donation History</a>
                        <a class="nav-link active text-nowrap" href="{{ route('my.donation.transparency') }}" role="tab" aria-selected="false">Transparency Board</a>
                    </div>
                    <div class="w-100 h100">
                        <div class="p-3">
                            <h5 class="m-0 mb-3"><i class="bi bi-clipboard-heart"></i> Transparency Board</h5>
                            <div class="row mt-2 mx-2 align-items-center">
                                <div class="col-12 col-md-4 mx-1">
                                    <div class=" row mb-2">
                                        <h6>Filter by Barangay:</h6> {{-- All barangay, Barangay 1,2,3.... --}}
                                        <select id="barangayFilter" class="form-select ">
                                            <option value="" selected>All Barangays</option>
                                            <!-- Dynamically generate options for barangays -->
                                            @foreach ($barangays as $barangay)
                                                <option value="{{ $barangay->id }}">{{ $barangay->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-md-2 mx-1">
                                    <div class="row mb-2">
                                        <h6>Activity by Time:</h6> {{-- Quarterly 1,2,3,4 or anually --}}
                                        <select id="timeFilter" class="form-select">
                                            <option value="">Select Time Period</option>
                                            <option value="Q1">Q1 (Jan-Mar)</option>
                                            <option value="Q2">Q2 (Apr-Jun)</option>
                                            <option value="Q3">Q3 (Jul-Sep)</option>
                                            <option value="Q4">Q4 (Oct-Dec)</option>
                                            <option value="Annual" selected>Annual</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-md-3 mx-1">
                                    <div class="row mb-2">
                                        <h6>Filter by Year:</h6>
                                        <select id="yearFilter" class="form-select">
                                            <option value="">Select Year</option>
                                            @for ($year = now()->year; $year >= $firstDonationYear; $year--)
                                                <option value="{{ $year }}">{{ $year }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-md">
                                    <button id="filterButton" class="btn bg-greener">Apply Filters</button>
                                </div>
                            </div>
                            <small class="text-secondary fs-6 float-end">*Apply Filter First</small>
                            <div id="donationResults">
                                <table id="transparencyTable" class="border rounded-table">
                                    <thead>
                                        <tr>
                                            <th class="fs-6">Barangay</th>
                                            <th class="fs-6">Coordinator</th>
                                            <th class="fs-6">Donor Name</th>
                                            <th class="fs-6">Date of Donation</th>
                                            <th class="fs-6">Donation Type</th>
                                            <th class="fs-6">Itemized List</th>
                                            <th class="fs-6">Quantity/Volume</th>
                                            <th class="fs-6">Status</th>
                                            <th class="fs-6">Last Updated</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Dynamic rows will be appended here -->

                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="donationDetailsModal" tabindex="-1" aria-labelledby="donationDetailsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="donationDetailsModalLabel">Donation Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Donation details will be dynamically loaded here -->
                    <div id="donationDetailsContent">
                        Loading...
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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

            $('#transparencyTable').DataTable({
                searching: false,
                lengthChange: false,
                paging: false,
                ordering: false,
                responsive: true,
                autoWidth: false,
            });
            // $('#historyTable').DataTable({
            //     ordering: false,
            //     responsive: true,
            //     autoWidth: false,
            // });
            // $('#notificationTable').DataTable({
            //     ordering: false,
            //     responsive: true,
            //     autoWidth: false,
            // });
            // $('#transparencyTable').DataTable({
            //     responsive: true,
            //     autoWidth: false,
            //     searching: false,
            //     ordering: false,
            //     lengthChange: false,
            // });

            $('#filterButton').on('click', function() {
                const barangayId = $('#barangayFilter').val();
                const timePeriod = $('#timeFilter').val();
                const year = $('#yearFilter').val();

                $.ajax({
                    url: '/transparency-board',
                    method: 'GET',
                    data: {
                        barangay_id: barangayId,
                        time_period: timePeriod,
                        year: year
                    },
                    dataType: 'json',
                    success: function(response) {
                        const $tbody = $('#donationResults tbody');
                        $tbody.empty(); // Clear previous results

                        if (response.donations.length === 0) {
                            // Show 'No Data Available' message if there's no data
                            const noDataMessage = `
                        <tr>
                            <td colspan="9" class="text-center">No data available in table</td>
                        </tr>`;
                            $tbody.append(noDataMessage);
                        } else {
                            $.each(response.donations, function(index, donation) {
                                const itemList = donation.items.join('<br>');
                                const quantityList = donation.quantities.join('<br>');

                                const donationEntry = `
                        <tr>
                            <td class="h6">${donation.barangay_name}</td>
                            <td class="h6">${donation.barangay_rep}</td>
                            <td class="h6">${donation.anonymous == 'true' ? 'Anonymous Donor' : donation.donor_name}</td>
                            <td class="h6">${new Date(donation.donation_date).toLocaleDateString()}</td>
                            <td class="h6">${donation.donation_type}</td>
                            <td class="h6">${itemList}</td>
                            <td class="h6">${quantityList}</td>
                            <td class="h6">${donation.status}</td>
                            <td class="h6">${new Date(donation.updated_at).toLocaleDateString()}</td>
                        </tr>`;
                                $tbody.append(donationEntry);
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching data:', error);
                    }
                });
            });

            function fetchDonations() {
                const barangayId = $('#barangayFilter').val();
                const timePeriod = $('#timeFilter').val();
                const year = $('#yearFilter').val();

                $.ajax({
                    url: '/transparency-board',
                    method: 'GET',
                    data: {
                        barangay_id: barangayId,
                        time_period: timePeriod,
                        year: year
                    },
                    dataType: 'json',
                    success: function(response) {
                        const $tbody = $('#donationResults tbody');
                        $tbody.empty(); // Clear previous results

                        $.each(response.donations, function(index, donation) {
                            const itemList = donation.items.join(', ');
                            const quantityList = donation.quantities.join(', ');

                            const donationEntry = `
                        <tr>
                            <td>D-${donation.id}</td>
                            <td>${donation.donor_name}</td>
                            <td>${new Date(donation.donation_date).toLocaleDateString()}</td>
                            <td>${donation.donation_type}</td>
                            <td>${donation.barangay_name}</td>
                            <td>${itemList}</td>
                            <td>${quantityList}</td>
                            <td>${donation.status}</td>
                            <td>${new Date(donation.updated_at).toLocaleDateString()}</td>
                        </tr>`;
                            $tbody.append(donationEntry);
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching data:', error);
                    }
                });
            }
        });

        function loadDonationDetails(donationId) {
            // Clear previous details
            document.getElementById('donationDetailsContent').innerHTML = 'Loading...';

            // Make an AJAX request to get the donation details
            fetch('/donation/view/' + donationId)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    let donationItems = data.items; // Items are already an array of objects

                    // Build a table for donation items
                    let itemsHtml = `
                <table class="table table-striped px-5">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Quantity</th>
                            <th>Expiration or Condition</th>
                        </tr>
                    </thead>
                    <tbody>`;

                    donationItems.forEach(item => {
                        itemsHtml += `
                    <tr>
                        <td>${item.item_name}</td>
                        <td>${item.quantity}</td>
                        <td>${item.expiration_date ?? item.condition ?? 'N/A'}</td>
                    </tr>
                `;
                    });

                    itemsHtml += `</tbody></table>`;

                    // Populate the modal with the donation details
                    let detailsHtml = `
                <p><strong>Donation ID:</strong> ${data.id}</p>
                <p><strong>Donation Date:</strong> ${new Date(data.created_at).toLocaleString()}</p>
                <p><strong>Donation Status:</strong> ${data.status}</p>
                <p><strong>Donation Items:</strong></p>
                ${itemsHtml}
                <!-- Add other fields as needed -->
            `;

                    document.getElementById('donationDetailsContent').innerHTML = detailsHtml;
                })
                .catch(error => {
                    console.error('Error fetching donation details:', error);
                    document.getElementById('donationDetailsContent').innerHTML = 'Error loading details.';
                })
        }
    </script>
@endsection
