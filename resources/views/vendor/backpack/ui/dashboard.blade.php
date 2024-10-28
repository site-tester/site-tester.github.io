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
    <div class="container">
        <div class="row justify-content-between mb-3">
            <h1 class=" col-1 ">Dashboard</h1>
            <div class=" col-1 ">
                <button class="btn btn-dark" onClick="window.print()">
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
        <div id="printableContent">
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
                    <div class="col border-end text-center">
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
    </div>
@endsection
@push('after_styles')
    <style>
        /* Print-specific styles */
        @media print {
            body * {
                visibility: hidden;
            }
            #printableContent, #printableContent * {
                visibility: visible;
            }
            #printableContent {
                position: absolute;
                top: 0;
                left: 0;
            }
        }
    </style>
@endpush

@section('after_scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
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
@endsection
