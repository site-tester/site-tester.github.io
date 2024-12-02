@extends('layouts.app')

@section('title', 'Donation Request')

@section('css')
    <link href="https://unpkg.com/smartwizard@6/dist/css/smart_wizard_all.min.css" rel="stylesheet" type="text/css" />

    <link href='https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/south-street/jquery-ui.css' rel='stylesheet'>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <link href="https://cdn.datatables.net/v/dt/dt-2.1.8/r-3.0.3/datatables.min.css" rel="stylesheet">

@endsection

@section('background-color', 'bg-container')

@section('content')
    <h1 class="text-center mt-5 text-greener">Donation Request</h1>
    <div class="container my-5">
        <div class="card">
            <div class="row w-75 mx-auto  p-5">
                <div class="col mb-3">
                    {{-- Impact Level --}}
                    <select class="form-select form-select-lg" name="impactLevel" id="impactLevelSelect">
                        <option></option>
                        <option value="all">All</option>
                        <option value="high">High</option>
                        <option value="moderate">Moderate</option>
                        <option value="low">Low</option>
                    </select>
                </div>
                <div class="col mb-3">
                    <select class="form-select form-select-lg" name="disasterType" id="disasterTypeSelect">
                        <option></option>
                        <option value="all">All</option>
                        <option value="fire">Fire</option>
                        <option value="flood">Flood</option>
                        <option value="earthquake">Earthquake</option>
                    </select>
                </div>
                <div class="col mb-3">
                    <div class="d-grid gap-2">
                        <button type="button" id="applyFilterBtn" class="btn btn-success btn-sm">
                            Apply Filter
                        </button>
                    </div>
                </div>
            </div>
            <div class="row px-1 mb-3 mx-2">
                <ul class="nav nav-fill nav-tabs pe-0" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="fill-tab-0" data-bs-toggle="tab" href="#fill-tabpanel-0"
                            role="tab" aria-controls="fill-tabpanel-0" aria-selected="true">Active</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="fill-tab-1" data-bs-toggle="tab" href="#fill-tabpanel-1" role="tab"
                            aria-controls="fill-tabpanel-1" aria-selected="false">Done</a>
                    </li>
                </ul>
                <div class="tab-content pt-1" id="tab-content" style="min-height: 100px !important;">
                    <div class="tab-pane active px-3" id="fill-tabpanel-0" role="tabpanel" aria-labelledby="fill-tab-0">
                        <table class="table">
                            <thead>
                                <tr class="text-center">
                                    <th>Date</th>
                                    <th>Disaster Type</th>
                                    <th>Barangay</th>
                                    <th>Status</th>
                                    <th>Disaster Report</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @if ($donationActiveRequest->isEmpty())
                                    <tr>
                                        <td colspan="5" class="text-center">No records found.</td>
                                    </tr>
                                @else
                                    @foreach ($donationActiveRequest as $item)
                                        @php
                                            $rawValue = $item->disaster_type;
                                            $rawValue = stripslashes($rawValue);
                                            $cleanValue = trim($rawValue, '"');
                                            $decoded = json_decode($cleanValue, true);
                                            // Apply ucfirst to each item
                                            $formatted = array_map('ucfirst', $decoded);
                                            $disaster_type = implode(', ', $formatted);
                                        @endphp
                                        <tr>
                                            <td>{{ $item->date_requested }}</td>
                                            <td>{{ $disaster_type }}</td>
                                            <td>{{ $item->barangay->name }}</td>
                                            <td>{{ $item->status }}</td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-link" data-bs-toggle="modal"
                                                    data-bs-target="#modalId-{{ $item->id }}"> {{-- {{ $item->id }} --}}
                                                    View
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>

                        </table>
                    </div>
                    <div class="tab-pane" id="fill-tabpanel-1" role="tabpanel" aria-labelledby="fill-tab-1">
                        <table class="table">
                            <thead>
                                <tr class="text-center">
                                    <th>Date</th>
                                    <th>Disaster Type</th>
                                    <th>Barangay</th>
                                    <th>Status</th>
                                    <th>Disaster Report</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @if ($donationDoneRequest->isEmpty())
                                    <tr>
                                        <td colspan="5" class="text-center">No records found.</td>
                                    </tr>
                                @else
                                    @foreach ($donationDoneRequest as $item)
                                        @php
                                            $rawValue = $item->disaster_type;
                                            $rawValue = stripslashes($rawValue);
                                            $cleanValue = trim($rawValue, '"');
                                            $decoded = json_decode($cleanValue, true);
                                            // Apply ucfirst to each item
                                            $formatted = array_map('ucfirst', $decoded);
                                            $disaster_type = implode(', ', $formatted);
                                        @endphp
                                        <tr>
                                            <td>{{ $item->date_requested }}</td>
                                            <td>{{ $disaster_type }}</td>
                                            <td>{{ $item->barangay->name }}</td>
                                            <td>
                                                @if ($item->deleted_at)
                                                    Completed
                                                @else
                                                    {{ $item->status }}
                                                @endif
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-link" data-bs-toggle="modal"
                                                    data-bs-target="#modalId-{{ $item->id }}"> {{-- {{ $item->id }} --}}
                                                    View
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
            @if ($donationRequest->isNotEmpty())
                <div id="donationRequestResults" class="row disaster_request px-5 my-5 mx-auto">
                    @foreach ($donationRequest as $item)
                        @php
                            // dd($item);
                            $rawValue = $item->disaster_type;
                            $rawValue = stripslashes($rawValue);
                            $cleanValue = trim($rawValue, '"');
                            $decoded = json_decode($cleanValue, true);
                            // Apply ucfirst to each item
                            $formatted = array_map('ucfirst', $decoded);
                            $disaster_type = implode(', ', $formatted);

                            $rawValue = $item->preffered_donation_type;
                            $rawValue = stripslashes($rawValue);
                            $cleanValue = trim($rawValue, '"');
                            $decoded = json_decode($cleanValue, true);
                            // Apply ucfirst to each item
                            $formatted = array_map('ucfirst', $decoded);
                            $preffered_donation_type = implode(', ', $formatted);

                            $incident_time = \Carbon\Carbon::parse($item->incident_time)->format('h:i A');
                        @endphp
                        <div id="donation-request" class="col-auto">
                            <div class="card p-3 shadow border-success" style="width: 18rem;">
                                <h4 class="text-center">{{ $item->barangay->name }}</h4>
                                <h5
                                    class="text-center
                                    @if ($item->vulnerability == 'High') text-danger
                                    @elseif ($item->vulnerability == 'Moderate')
                                        text-warning
                                    @elseif ($item->vulnerability == 'High')
                                        text-success @endif
                                ">
                                    {{ $item->vulnerability }}</h5>
                                <div>
                                    <h6>Disaster Type:</h6>
                                    <p>{{ $disaster_type }}</p>
                                </div>
                                <div>
                                    <h6>Date Reported:</h6>
                                    <p>{{ $item->created_at->format('M-d-Y') }}</p>
                                </div>
                                {{-- <div>
                                    <h6>Estimated Affected Population:</h6>
                                    <table class="table">
                                        <tr>
                                            <td>Families</td>
                                            <td>{{ $item->affected_family }}</td>
                                        </tr>
                                        <tr>
                                            <td>Persons</td>
                                            <td>{{ $item->affected_person }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div>
                                    <h6>Immediate Needs:</h6>
                                    <table class="table table-responsive">
                                        <tr>
                                            <td>Food</td>
                                            <td>{{ $item->immediate_needs_food }}</td>
                                        </tr>
                                        <tr>
                                            <td>NonFood</td>
                                            <td>{{ $item->immediate_needs_nonfood }}</td>
                                        </tr>
                                        <tr>
                                            <td>Medicine</td>
                                            <td>{{ $item->immediate_needs_medicine }}</td>
                                        </tr>
                                    </table>
                                </div> --}}
                                <div class="text-center mb-3">
                                    <!-- Modal trigger button -->
                                    <button type="button" class="btn btn-link btn-lg" data-bs-toggle="modal"
                                        data-bs-target="#modalId-{{ $item->id }}">
                                        View Disaster Report
                                    </button>
                                </div>
                                <!-- Modal Body -->
                                <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
                                <div class="modal fade" id="modalId-{{ $item->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="modalTitleId" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered"
                                        role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div>
                                                    <h4 class="text-center mb-0">{{ $item->barangay->name }}</h4>
                                                    <h5 class="text-center">{{ $item->exact_location }}</h5>
                                                    <h5
                                                        class="text-center
                                                        @if ($item->vulnerability == 'High') text-danger
                                                            @elseif ($item->vulnerability == 'Moderate')
                                                                text-warning
                                                            @elseif ($item->vulnerability == 'High')
                                                                text-success @endif
                                                        ">
                                                        {{ $item->vulnerability }}</h5>
                                                    <div>
                                                        <h6>Disaster Type:</h6>
                                                        <p>{{ $disaster_type }}</p>
                                                    </div>
                                                    <div>
                                                        <h6>Caused By:</h6>
                                                        <p>{{ $item->caused_by }}</p>
                                                    </div>
                                                    <div>
                                                        <h6>Date Reported:</h6>
                                                        <p>{{ $item->created_at->format('M-d-Y') }}</p>
                                                    </div>
                                                    <div>
                                                        <h6>Incident date:</h6>
                                                        <p>{{ $item->incident_date }}</p>
                                                    </div>
                                                    <div>
                                                        <h6>Incident Time:</h6>
                                                        <p>{{ $incident_time }}</p>
                                                    </div>
                                                    <div>
                                                        <h6>Estimated Affected Population:</h6>
                                                        <table class="table">
                                                            <tr>
                                                                <td>Families</td>
                                                                <td>{{ $item->affected_family }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Persons</td>
                                                                <td>{{ $item->affected_person }}</td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div>
                                                        <h6>Preffered Donation Type:</h6>
                                                        <p>{{ $preffered_donation_type }}</p>
                                                    </div>
                                                    <div>
                                                        <h6>Immediate Needs:</h6>
                                                        <table class="table table-responsive">
                                                            <tr>
                                                                <td>Food</td>
                                                                <td>{{ $item->immediate_needs_food }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>NonFood</td>
                                                                <td>{{ $item->immediate_needs_nonfood }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Medicine</td>
                                                                <td>{{ $item->immediate_needs_medicine }}</td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center d-grid gap-2">
                                    <a class="btn bg-greener btn-lg" href="{{ route('donate-now-urgent', $item->id) }}">
                                        Donate
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div id="pagination" class="d-flex justify-content-center">
                        {{ $donationRequest->links() }}
                    </div>
                </div>
            @endif
            @if ($donationRequest->isEmpty())
                <div class="border-top bg-secondary-subtle text-secondary-emphasis">
                    <div class="px-5 py-5 fst-italic text-center">
                        <p>
                            No disaster reports have been submitted by the barangays at this time. However, you may still
                            send
                            donations to open barangays to help them prepare for future emergencies. Your support ensures
                            that
                            the barangays are well-equipped and ready to respond to any disaster. Your generosity is highly
                            appreciated.
                        </p>
                        <div class="text-center">
                            <div class=" mx-auto ">
                                <a href="{{ route('donate-now') }}" class="btn bg-green text-white w-50">Donate Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#impactLevelSelect').select2({
                placeholder: "Impact Level",
                // allowClear: true
            });
            $('#disasterTypeSelect').select2({
                placeholder: "Disaster Type",
                // allowClear: true
            });

            $('#applyFilterBtn').click(function() {
                var impactLevel = $('#impactLevelSelect').val();
                var disasterType = $('#disasterTypeSelect').val();

                // Send an AJAX request with selected filters
                $.ajax({
                    url: '{{ route('donation-requests.filter') }}', // Define your route here
                    method: 'GET',
                    data: {
                        impactLevel: impactLevel,
                        disasterType: disasterType,
                        _token: '{{ csrf_token() }}', // CSRF token for security
                    },
                    success: function(response) {
                        // Update the results section with the new filtered content
                        $('#donationRequestResults').html(response.view);
                        // Update pagination links (if applicable)
                        $('#pagination').append(response.pagination);
                    }
                });
            });
        })
    </script>
@endsection
