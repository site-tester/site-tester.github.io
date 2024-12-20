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
                    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
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
