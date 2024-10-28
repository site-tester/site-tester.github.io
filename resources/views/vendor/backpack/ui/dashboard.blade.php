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
        <h1>Dashboard</h1>
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
                <div class="col  text-center">
                    <div class="h1 mb-1">
                        {{ $totalDonation }}
                    </div>
                    <span class="text-secondary fs-4">Total Donation</span>
                </div>
            </div>


        </div>
        {{-- ChartJs --}}
        <div class="row">
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

    </div>
@endsection

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
    </script>
@endsection
