@extends(backpack_view('blank'))

@php
    // if (backpack_theme_config('show_getting_started')) {
    //     $widgets['before_content'][] = [
    //         'type'        => 'view',
    //         'view'        => backpack_view('inc.getting_started'),
    //     ];
    // } else {
    //     $widgets['before_content'][] = [
    //         'type'        => 'jumbotron',
    //         'heading'     => trans('backpack::base.welcome'),
    //         'heading_class' => 'display-3 '.(backpack_theme_config('layout') === 'horizontal_overlap' ? ' text-white' : ''),
    //         'content'     => trans('backpack::base.use_sidebar'),
    //         'content_class' => backpack_theme_config('layout') === 'horizontal_overlap' ? 'text-white' : '',
    //         'button_link' => backpack_url('logout'),
    //         'button_text' => trans('backpack::base.logout'),
    //     ];
    // }
@endphp

@section('content')
    @can('browse_dashboard')
        <div class="container">
            <div class="row justify-content-between mb-3">
                <h1 class=" col-1 ">Dashboard</h1>

            </div>
            <div id="notprintableContent">
                <div class="card shadow mb-3">
                    <div class="row align-items-center p-3 mb-3">
                        <div class="col border-end text-center">
                            <div class="h1 mb-1">
                                {{ $pendingDonation }}
                            </div>
                            <span class="text-secondary fs-4">Pending Request</span>
                        </div>
                        <div class="col border-end text-center">
                            <div class="h1 mb-1">
                                {{ $totalDonors }}
                            </div>
                            <span class="text-secondary fs-4">Donors</span>
                        </div>
                        <div class="col text-center">
                            <div class="h1 mb-1">
                                {{ $totalDonation }}
                            </div>
                            <span class="text-secondary fs-4">Total Donation</span>
                        </div>
                        {{-- <div class="col  text-center">
                        <div class="h1 mb-1">
                            {{ $totalDonation }}
                        </div>
                        <span class="text-secondary fs-4">Total Donation</span>
                    </div> --}}
                    </div>


                </div>
                {{-- ChartJs --}}
                <div class="row mb-3">
                    <div class="col">
                        <div class="card p-3">
                            <canvas id="donationsChart" style="height: 300px;"></canvas>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card p-3">
                            <canvas id="donorChart" style="height: 300px;"></canvas>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="card p-3">
                            <canvas id="donationTypeChart" style="height: 300px;"></canvas>
                        </div>
                    </div>

                    <div class="col">
                        <div class="card p-3">
                            <canvas id="barangayDonationChart" style="height: 300px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row my-3">
                <div class="col-md-2">
                    <select id="filterReportSelector" class="form-select mb-3">
                        <option value="" disabled selected>Select a Report View</option>
                        <option value="This Day">This Day</option>
                        <option value="This Week">This Week</option>
                        <option value="Month">Month</option>
                        <option value="Year">Year</option>
                    </select>
                </div>

                <div id="monthSelector" class="col-md-2" style="display: none;">
                    <select class="form-select" id="monthSelect">
                        <option value="" disabled selected>Select a Month</option>
                        <option value="January">January</option>
                        <option value="February">February</option>
                        <option value="March">March</option>
                        <option value="April">April</option>
                        <option value="May">May</option>
                        <option value="June">June</option>
                        <option value="July">July</option>
                        <option value="August">August</option>
                        <option value="September">September</option>
                        <option value="October">October</option>
                        <option value="November">November</option>
                        <option value="December">December</option>
                    </select>
                </div>

                <div id="yearSelector" class="col-md-2" style="display: none;">
                    <select class="form-select" id="yearSelect">
                        <option value="" disabled selected>Select a Year</option>
                        <!-- PHP code for dynamically populating the year options -->
                        @foreach ($years as $year)
                            <option value="{{ $year->year }}">{{ $year->year }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col text-nowrap">
                    <div class="row">
                        <div class="col-2">
                            <button id="generateFilter" class="btn btn-dark">
                                Apply Filter
                            </button>
                        </div>
                        <div class="col-2">
                            <button class="btn btn-dark" id="printButton">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-printer" viewBox="0 0 16 16">
                                    <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1" />
                                    <path
                                        d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1" />
                                </svg>
                                &nbsp;
                                Print
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div id="reportSection" class="printableContent d-none">
                <!-- Report Title and Date -->
                <h2 style="text-align: center; margin-bottom: 10px;">Barangay Donation Summary Report</h2>
                <p style="text-align: left; font-size: 14px;">
                    Date: <span id="reportDate">{{ now()->format('Y-m-d') }}</span><br>
                    Time: <span id="reportTime">{{ now()->format('H:i:s') }}</span>
                </p>

                <!-- Summary Table -->
                <table id="reportTable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Coordinator</th>
                            <th>Donor</th>
                            <th>Type</th>
                            <th>Items</th>
                            <th>Quantities</th>
                            <th>Donation Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Report data will be injected here -->
                    </tbody>
                </table>
            </div>

        </div>
    @endcan
    @can('browse_dashboard_municipal')
        <h1>
            Admin Dashboard
        </h1>
    @endcan
@endsection
@push('after_styles')
    <style>
        /* Print-specific styles */
        @media print {
            body * {
                visibility: hidden;
            }

            .printableContent,
            .printableContent * {
                visibility: visible;
            }

            .printableContent {
                position: absolute;
                top: 0;
                left: 0;
            }
        }
    </style>
@endpush

@section('after_scripts')
    @can('browse_dashboard')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            $('#filterReportSelector').change(function() {
                var selectedValue = $(this).val();

                if (selectedValue === "Month") {
                    $('#monthSelector').show();
                    $('#yearSelector').hide();
                } else if (selectedValue === "Year") {
                    $('#monthSelector').hide();
                    $('#yearSelector').show();
                } else {
                    $('#monthSelector').hide();
                    $('#yearSelector').hide();
                }
            });

            // Apply the filter and load the report
            $('#generateFilter').click(function() {
                var reportType = $('#filterReportSelector').val();
                var month = $('#monthSelect').val();
                var year = $('#yearSelect').val();

                // Validate input selection
                if (!reportType) {
                    alert("Please select a report view");
                    return;
                }

                // Fetch report data based on the filter
                $.ajax({
                    url: '/generate-report', // Create this route in Laravel
                    method: 'GET',
                    data: {
                        reportView: reportType,
                        month: month,
                        year: year
                    },
                    success: function(data) {
                        // Display the report section
                        $('#reportSection').removeClass('d-none');

                        // Populate the report table
                        var reportRows = '';
                        data.forEach(function(report) {
                            reportRows += '<tr>';
                            reportRows += '<td>' + report.id + '</td>';
                            reportRows += '<td>' + report.coordinator + '</td>';
                            reportRows += '<td>' + report.donor + '</td>';
                            reportRows += '<td>' + report.type + '</td>';
                            reportRows += '<td>' + report.items + '</td>';
                            reportRows += '<td>' + report.quantities + '</td>';
                            reportRows += '<td>' + report.donation_date + '</td>';
                            reportRows += '<td>' + report.status + '</td>';
                            reportRows += '</tr>';
                        });

                        $('#reportTable tbody').html(reportRows);
                    },
                    error: function() {
                        alert("Error generating report. Please try again.");
                    }
                });
            });

            $('#printButton').on('click', function() {
                // Temporarily show the report for printing, even if it's hidden
                $('.printableContent:visible').each(function() {
                    $(this).addClass('print-temp').removeClass('d-none');
                });

                // Trigger print
                window.print();

                // Hide the report again after printing
                $('.print-temp').each(function() {
                    $(this).removeClass('print-temp').addClass('d-none');
                });

                // Reset dropdown selection (optional)
                $('#reportSelector').val('');
            });

            const weekLabels = ["Sun", "Mon", "Tue", "Wed", "Thur", "Fri", "Sat"];
            const individualDonor = @json($individualDonor->values());
            const organizationDonor = @json($organizationDonor->values());
            // Prepare data for the chart
            const donationCtx = document.getElementById('donationsChart').getContext('2d');
            new Chart(donationCtx, {
                type: 'bar',
                data: {
                    labels: weekLabels,
                    datasets: [{
                            label: 'Individual',
                            data: individualDonor,
                            backgroundColor: 'rgba(34, 173, 64, 0.7)',
                            borderColor: 'rgba(34, 173, 64, 1)',
                            borderWidth: 1,
                            borderRadius: 5,
                        },
                        {
                            label: 'Organization',
                            data: organizationDonor,
                            backgroundColor: 'rgba(18, 79, 31, 0.7)',
                            borderColor: 'rgba(18, 79, 31, 1)',
                            borderWidth: 1,
                            borderRadius: 5,
                        },
                    ]
                },
                options: {
                    scales: {
                        x: {
                            stacked: true,
                        },
                        y: {
                            stacked: true,
                            ticks: {
                                precision: 0,
                            }
                        }
                    },
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Donations'
                        }
                    }
                }
            });

            const donorCtx = document.getElementById('donorChart').getContext('2d');
            new Chart(donorCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Individual', 'Organization'],
                    datasets: [{
                        data: [{{ $donorTypesCount['individual'] }}, {{ $donorTypesCount['organization'] }}],
                        backgroundColor: ['rgba(34, 173, 64, 0.7)', 'rgba(18, 79, 31, 0.7)'],
                        borderColor: ['rgba(34, 173, 64, 1)', 'rgba(18, 79, 31, 1)'],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    aspectRatio: 1, // This keeps a square aspect ratio
                    plugins: {
                        legend: {
                            position: 'right',
                        },
                        title: {
                            display: true,
                            text: 'Donors'
                        }
                    }
                }
            })

            const getDonationTypesCount = {!! json_encode($getDonationTypesCount) !!};

            const donationTypes = ["Food", "Non-Food", "Medical"];
            const donationCounts = [getDonationTypesCount.FoodDonationCount, getDonationTypesCount.NonFoodDonationCount,
                getDonationTypesCount.MedicalDonationCount
            ];
            const donationTypeCtx = document.getElementById('donationTypeChart').getContext('2d');
            new Chart(donationTypeCtx, {
                type: 'bar',
                data: {
                    labels: donationTypes,
                    datasets: [{
                        label: 'Donations Count',
                        data: donationCounts,
                        backgroundColor: [
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',

                        ],
                        borderColor: [
                            'rgba(75, 192, 192, 1)',
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',

                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Number of Donations'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Donation Types'
                            }
                        }
                    }
                }
            });

            const barangayData = {!! json_encode($barangayDonations) !!};

            const barangayLabels = Object.keys(barangayData);
            const donationCounter = Object.values(barangayData);

            const barangayCtx = document.getElementById('barangayDonationChart').getContext('2d');
            new Chart(barangayCtx, {
                type: 'bar',
                data: {
                    labels: barangayLabels,
                    datasets: [{
                        label: 'Donations ',
                        data: donationCounter,
                        backgroundColor: 'rgba(54, 162, 235, 0.5)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    indexAxis: 'y',
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Barangay'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Number of Donations'
                            }
                        }
                    }
                }
            });
        </script>
    @endcan
@endsection
