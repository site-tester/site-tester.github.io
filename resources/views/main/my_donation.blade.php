@extends('layouts.app')

@section('title', 'Donation Confirmation')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />
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
    <div class="container p-5 pb-0">
        @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mx-5 mb-0" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        <div class="card shadow m-5">
            <div class="row p-4">
                <div class="col-2">
                    <img src="" alt="">
                </div>
                <div class="col">
                    <h4>{{ Auth::user()->name }}</h4>
                    <h5><i class="bi bi-clock p-1"></i> Last Donated: {{ $lastDonated }}</h5>
                    <h5><i class="bi bi-heart-fill p-1"></i> Donor for {{ $firstDonated }}</h5>
                </div>
            </div>
            <div class="row border-top m-0">
                <div class="d-flex align-items-start mx-0 px-0 ">
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <button class="nav-link text-nowrap active text-end" id="v-pills-dashboard-tab"
                            data-bs-toggle="pill" data-bs-target="#v-pills-dashboard" type="button" role="tab"
                            aria-controls="v-pills-dashboard" aria-selected="true">Dashboard
                        </button>
                        <button class="nav-link text-nowrap text-end" id="v-pills-notification-tab" data-bs-toggle="pill"
                            data-bs-target="#v-pills-notification" type="button" role="tab"
                            aria-controls="v-pills-notification" aria-selected="true">Notifications
                            @if (Auth::user()->unreadNotifications->count() > 0)
                                <span class="text-bg-danger badge text-center">
                                    {{ Auth::user()->unreadNotifications->count() }}
                                </span>
                            @endif
                        </button>
                        <button class="nav-link text-nowrap text-end" id="v-pills-history-tab" data-bs-toggle="pill"
                            data-bs-target="#v-pills-history" type="button" role="tab" aria-controls="v-pills-history"
                            aria-selected="false">Donation History
                        </button>
                    </div>
                    <div class="tab-content w-100 h-100" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-dashboard" role="tabpanel"
                            aria-labelledby="v-pills-dashboard-tab" tabindex="0">
                            <div class="p-3 w-100 border">
                                <h5><i class="bi bi-graph-up-arrow"></i> Your Donor Stats</h5>
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12 col-md-4 mb-3">
                                                <div class="text-center border rounded mx-5">
                                                    <h1>{{ $historyDonations->count() }}</h1>
                                                    <p class="text-uppercase">Total Number of Donations</p>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4 mb-3">
                                                <div class="text-center border rounded mx-5">
                                                    <h1>{{ $historyDonations->where('status', 'Pending Approval')->count() }}
                                                    </h1>
                                                    <p class="text-uppercase">Total Number of Pending Donations</p>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4 mb-3">
                                                <div class="text-center border rounded mx-5">
                                                    <h1>{{ $recentDonations->where('status', 'Completed')->count() }}</h1>
                                                    <p class="text-uppercase">Total Number of Completed Donations</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <h5 class="m-0"><i class="bi bi-calendar3"></i> Recent Donations</h5>
                                <table id="dashboardTable" class="border rounded-table mt-0" style="width:100%">
                                    <thead>
                                        <tr class="">
                                            <th class="text-center">ID</th>
                                            <th class="text-center">Barangay</th>
                                            <th class="text-center">Type</th>
                                            <th class="text-center">Date</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($recentDonations as $donation)
                                            @if ($donation->status == 'Pending Approval')
                                                @php
                                                    $badgeClass = 'text-bg-warning'; // Yellow indicates awaiting action
                                                @endphp
                                            @elseif ($donation->status === 'Approved')
                                                @php
                                                    $badgeClass = 'text-bg-success'; // Green indicates approval
                                                @endphp
                                            @elseif ($donation->status === 'Awaiting Delivery')
                                                @php
                                                    $badgeClass = 'text-bg-info'; // Blue indicates a process in motion
                                                @endphp
                                            @elseif ($donation->status === 'Received')
                                                @php
                                                    $badgeClass = 'text-bg-secondary'; // Grey indicates a neutral state (received but not processed yet)
                                                @endphp
                                            @elseif ($donation->status === 'Under Segregation')
                                                @php
                                                    $badgeClass = 'badge text-bg-primary'; // Primary indicates an active process
                                                @endphp
                                            @elseif ($donation->status === 'Categorized')
                                                @php
                                                    $badgeClass = 'text-bg-secondary'; // Grey indicates a state of readiness (categorized but not yet distributed)
                                                @endphp
                                            @elseif ($donation->status === 'In Inventory')
                                                @php
                                                    $badgeClass = 'text-bg-dark'; // Dark indicates stored and available for future use
                                                @endphp
                                            @elseif ($donation->status === 'Ready for Distribution')
                                                @php
                                                    $badgeClass = 'text-bg-primary'; // Primary to indicate it's actively ready for distribution
                                                @endphp ?>
                                            @elseif ($donation->status === 'Distributed')
                                                @php
                                                    $badgeClass = 'text-bg-success'; // Green indicates the process is complete
                                                @endphp ?>
                                            @elseif ($donation->status === 'Completed')
                                                @php
                                                    $badgeClass = 'text-bg-dark'; // Dark indicates closure/completion
                                                @endphp ?>
                                            @else
                                                @php
                                                    $badgeClass = ''; // Default class if none match
                                                @endphp ?> ?>
                                            @endif
                                            <tr>
                                                <td class="text-center">{{ $donation->id }}</td>
                                                <td class="text-center">{{ $donation->barangay->name }}</td>
                                                <td class="text-capitalize text-center ">{{ $donation->type }}</td>
                                                <td class="text-center">{{ $donation->created_at->format('M/d/Y') }}</td>
                                                <td class="text-center align-items-center">
                                                    <span
                                                        class="{{ $badgeClass }} badge rounded-pill p-2 mx-1 text-nowarp">
                                                    </span>
                                                    {{ $donation->status }}
                                                </td>
                                                <td class="text-center">
                                                    <button class="btn border bg-green" data-bs-toggle="modal"
                                                        data-bs-target="#donationDetailsModal"
                                                        onclick="loadDonationDetails({{ $donation->id }})">View</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade w-100 border" id="v-pills-history" role="tabpanel"
                            aria-labelledby="v-pills-history-tab" tabindex="0">
                            <div class="p-3">
                                <h5 class="m-0">{{ $historyDonations->count() }} Total Donations</h5>
                                <table id="historyTable" class="border rounded-table mt-0" style="width:100%">
                                    <thead>
                                        <tr class="">
                                            <th class="text-center">ID</th>
                                            <th class="text-center">Barangay</th>
                                            <th class="text-center">Type</th>
                                            <th class="text-center">Date</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($historyDonations as $donation)
                                            @if ($donation->status == 'Pending Approval')
                                                @php
                                                    $badgeClass = 'text-bg-warning'; // Yellow indicates awaiting action
                                                @endphp
                                            @elseif ($donation->status === 'Approved')
                                                @php
                                                    $badgeClass = 'text-bg-success'; // Green indicates approval
                                                @endphp
                                            @elseif ($donation->status === 'Awaiting Delivery')
                                                @php
                                                    $badgeClass = 'text-bg-info'; // Blue indicates a process in motion
                                                @endphp
                                            @elseif ($donation->status === 'Received')
                                                @php
                                                    $badgeClass = 'text-bg-secondary'; // Grey indicates a neutral state (received but not processed yet)
                                                @endphp
                                            @elseif ($donation->status === 'Under Segregation')
                                                @php
                                                    $badgeClass = 'badge text-bg-primary'; // Primary indicates an active process
                                                @endphp
                                            @elseif ($donation->status === 'Categorized')
                                                @php
                                                    $badgeClass = 'text-bg-secondary'; // Grey indicates a state of readiness (categorized but not yet distributed)
                                                @endphp
                                            @elseif ($donation->status === 'In Inventory')
                                                @php
                                                    $badgeClass = 'text-bg-dark'; // Dark indicates stored and available for future use
                                                @endphp
                                            @elseif ($donation->status === 'Ready for Distribution')
                                                @php
                                                    $badgeClass = 'text-bg-primary'; // Primary to indicate it's actively ready for distribution
                                                @endphp
                                            @elseif ($donation->status === 'Distributed')
                                                @php
                                                    $badgeClass = 'text-bg-success'; // Green indicates the process is complete
                                                @endphp
                                            @elseif ($donation->status === 'Completed')
                                                @php
                                                    $badgeClass = 'text-bg-dark'; // Dark indicates closure/completion
                                                @endphp
                                            @else
                                                @php
                                                    $badgeClass = ''; // Default class if none match
                                                @endphp
                                            @endif
                                            <tr>
                                                <td class="text-center">{{ $donation->id }}</td>
                                                <td class="text-center">{{ $donation->barangay->name }}</td>
                                                <td class="text-capitalize text-center ">{{ $donation->type }}</td>
                                                <td class="text-center">{{ $donation->created_at->format('M/d/Y') }}</td>
                                                <td class="text-center align-items-center">
                                                    <span class="{{ $badgeClass }} badge rounded-pill p-2 mx-1"> </span>
                                                    {{ $donation->status }}
                                                </td>
                                                <td class="text-center">
                                                    <button class="btn border bg-green" data-bs-toggle="modal"
                                                        data-bs-target="#donationDetailsModal"
                                                        onclick="loadDonationDetails({{ $donation->id }})">View</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade w-100 border" id="v-pills-notification" role="tabpanel"
                            aria-labelledby="v-pills-notification-tab" tabindex="0">
                            <div class="p-3">
                                <h5 class="m-0"> Notifications</h5>
                                <table id="notificationTable" class="table table-striped border rounded-table mt-0" style="width:100%">
                                    <thead>
                                        <tr class="">
                                            <th class="text-center">Donation ID</th>
                                            <th class="text-center">Notification</th>
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
                                                <td class="text-center">{{ $notification->data['donation_id'] }}</td>
                                                <td class="text-center">{{ $notification->data['message'] }}</td>
                                                <td class="text-center">{{ $notification->created_at }}</td>
                                                <td class="text-center">
                                                    @if (is_null($notification->read_at)) <!-- Check if the notification is unread -->
                                                        <form action="{{ route('notif.markAsRead', $notification->id) }}" method="POST">
                                                            @csrf
                                                            @method('POST')
                                                            <button type="submit" class="btn btn-info">Mark as Read</button>
                                                        </form>
                                                    @else
                                                        <span class="btn btn-success disabled">Read</span> <!-- Show "Read" badge if already read -->
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
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script>
        $(document).ready(function() {
            $('#dashboardTable').DataTable({
                searching: false,
                lengthChange: false,
                paging: false,
                ordering: false,
            });
            $('#historyTable').DataTable({
                ordering: false,
            });
            $('#notificationTable').DataTable({
                ordering: false,
            });
        });

        function loadDonationDetails(donationId) {
            // Clear previous details
            document.getElementById('donationDetailsContent').innerHTML = 'Loading...';

            // Make an AJAX request to get the donation details
            fetch('/donation/view/' + donationId)
                .then(response => response.json())
                .then(data => {
                    let donationItems = JSON.parse(data.items);
                    // Build a table for donation items
                    let itemsHtml = `
                    <table class="table table-striped px-5">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Quantity</th>
                            </tr>
                        </thead>
                        <tbody>`;

                    donationItems.forEach(item => {
                        itemsHtml += `
                        <tr>
                            <td>${item.name}</td>
                            <td>${item.quantity}</td>
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
                });
        }
    </script>
@endsection
