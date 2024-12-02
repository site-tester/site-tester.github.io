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
                                {{ $totalActiveDonation }}
                            </div>
                            <span class="text-secondary fs-4">Active Donations</span>
                        </div>
                        <div class="col text-center">
                            <div class="h1 mb-1">
                                {{ $totalActiveDisasterReport }}
                            </div>
                            <span class="text-secondary fs-4">My Active Disaster Report</span>
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
                            <div class="row">
                                <select class="col form-select" id="totalDonationChartFilter"
                                    onchange="updateTotalDonationChart()">
                                    <option value="day">This Day</option>
                                    <option value="week">This Week</option>
                                    <option value="month">This Month</option>
                                    <option value="year">This Year</option>
                                </select>
                                <button class="mx-1 btn col-2 btn-secondary" onclick="printTable('totalDonationChartTable')">
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
                            <canvas id="totalDonationChart" style="max-height: 300px;"></canvas>
                        </div>
                    </div>
                    <div class="col">

                        <div class="card p-3">
                            <div class="row">
                                <select class="col form-select" id="donationCategoryChartFilter"
                                    onchange="updateDonationCategoryChart()">
                                    <option value="day">This Day</option>
                                    <option value="week">This Week</option>
                                    <option value="month">This Month</option>
                                    <option value="year">This Year</option>
                                </select>
                                <button class="mx-1 btn col-2 btn-secondary" onclick="printTable('donationCategoryChartTable')">
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
                            <canvas id="donationCategoryChart" style="max-height: 300px;"></canvas>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">

                        <div class="card p-3">
                            <div class="row">
                                <select class="col form-select" id="inventoryStockChartFilter"
                                    onchange="updateInventoryStockChart()">
                                    <option value="day">This Day</option>
                                    <option value="week">This Week</option>
                                    <option value="month">This Month</option>
                                    <option value="year">This Year</option>
                                </select>
                                <button class="mx-1 btn col-2 btn-secondary" onclick="printTable('inventoryStockChartTable')">
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
                            <canvas id="inventoryStockChart" style="max-height: 300px;"></canvas>
                        </div>
                    </div>

                    <div class="col">
                        <div class="card p-3">
                            <div class="row">
                                <select class="col form-select" id="distributedDonationChartFilter"
                                    onchange="updateDistributedDonationChart()">
                                    <option value="day">This Day</option>
                                    <option value="week">This Week</option>
                                    <option value="month">This Month</option>
                                    <option value="year">This Year</option>
                                </select>
                                <button class="mx-1 btn col-2 btn-secondary"
                                    onclick="printTable('distributedDonationChartTable')">
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
                            <canvas id="distributedDonationChart" style="max-height: 300px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Chart Print Tables --}}
            <table class="table table-bordered w-100 caption-top m-auto d-none" id="totalDonationChartTable">
                <caption class="text-center h5 mb-0">Total Donations Received</caption>
                <caption class="text-center p mb-3">{{now()->format('M-d-Y')}}</caption>
                <thead class="w-100 m-auto">
                    <tr>
                        <th>Time Period</th>
                        <th>Donations</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>

            <table class="table table-bordered w-100 caption-top m-auto d-none" id="donationCategoryChartTable">
                <caption class="text-center h5 mb-0">Donation Category Breakdown</caption>
                <caption class="text-center p mb-3">{{now()->format('M-d-Y')}}</caption>
                <thead>
                    <tr>
                        <th>Time Period</th>
                        <th>Food Donations</th>
                        <th>Non-Food Donations</th>
                        <th>Medicine Donations</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>

            <table class="table table-bordered w-100 caption-top m-auto d-none" id="inventoryStockChartTable">
                <caption class="text-center h5 mb-0">Inventory Category Levels</caption>
                <caption class="text-center p mb-3">{{now()->format('M-d-Y')}}</caption>
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>Low</th>
                        <th>Mid</th>
                        <th>High</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>

            <table class="table table-bordered w-100 caption-top m-auto d-none" id="distributedDonationChartTable">
                <caption class="text-center h5 mb-0">Distributed Donations</caption>
                <caption class="text-center p mb-3">{{now()->format('M-d-Y')}}</caption>
                <thead>
                    <tr>
                        <th>Time Period</th>
                        <th>Number of Donations</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>

        </div>
    @endcan
    @can('browse_dashboard_municipal')
        <div class="container">
            <div class="row justify-content-between mb-3">
                <h1 class=" col-1 ">Dashboard</h1>
                <div>
                    <div class="card shadow mb-3">
                        <div class="row align-items-center p-3 mb-3">
                            <div class="col border-end text-center">
                                <div class="h1 mb-1">
                                    {{ $pendingDisasterReport }}
                                </div>
                                <span class="text-secondary fs-4">Pending Disaster Report</span>
                            </div>
                            <div class="col border-end text-center">
                                <div class="h1 mb-1">
                                    {{ $verifiedDisasterReport }}
                                </div>
                                <span class="text-secondary fs-4">Verified Disaster Report</span>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="row">
                            <!-- Chart 1 -->
                            <div class="col">
                                <div class="card shadow p-2 m-1">
                                    {{-- <h6 class="text-center">Barangay Donation Requests</h6> --}}
                                    <canvas id="barangayRequestsChart" style="height: 400px;"></canvas>
                                </div>
                            </div>
                            <!-- Chart 2 -->
                            <div class="col">
                                <div class="card shadow p-2 m-1">
                                    <canvas id="barangayVulnerabilityChart" style="height: 400px;"></canvas>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Chart 3 -->
                            <div class="col">
                                <div class="card shadow p-2 m-1">
                                    <canvas id="barangayDonationsChart" style="height: 400px;"></canvas>
                                </div>
                            </div>
                            <!-- Chart 4 -->
                            <div class="col">
                                <div class="card shadow p-2 m-1">
                                    <canvas id="userRolesChart" style="height: 400px;"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endcan
@endsection

@section('after_scripts')
    @can('browse_dashboard')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            let donationChart;
            let categoryChart;
            let inventoryStockChart;
            let distributedDonationChart;

            function updateTotalDonationChart() {
                const filter = document.getElementById('totalDonationChartFilter').value;

                fetch(`/admin/total-donation?filter=${filter}`)
                    .then(response => response.json())
                    .then(data => {
                        // Update chart
                        if (donationChart) donationChart.destroy();

                        const ctx = document.getElementById('totalDonationChart').getContext('2d');
                        donationChart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: Object.keys(data.data),
                                datasets: [{
                                    label: 'Donations Received',
                                    data: Object.values(data.data),
                                    backgroundColor: 'rgba(75, 192, 192, 0.5)',
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                responsive: true,
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });

                        // Update table
                        const tableBody = document.getElementById('totalDonationChartTable')?.querySelector('tbody');
                        if (tableBody) {
                            tableBody.innerHTML = '';
                            Object.entries(data.data).forEach(([time, count]) => {
                                const row = `<tr><td>${time}</td><td>${count}</td></tr>`;
                                tableBody.innerHTML += row;
                            });
                        } else {
                            console.error('Error: Table body element not found.');
                        }
                    })
                    .catch(error => console.error('Error fetching donations:', error));
            }

            function updateDonationCategoryChart() {
                const filter = document.getElementById('donationCategoryChartFilter').value;

                fetch(`/admin/donation-category?filter=${filter}`)
                    .then(response => response.json())
                    .then(data => {
                        // Update chart
                        if (categoryChart) categoryChart.destroy();

                        const ctx = document.getElementById('donationCategoryChart').getContext('2d');

                        // Prepare chart labels (time periods) and datasets
                        const labels = [];
                        const foodData = [];
                        const nonFoodData = [];
                        const medicineData = [];

                        // Collect all time periods (keys) from the data
                        Object.values(data.data).forEach(category => {
                            Object.keys(category).forEach(time => {
                                if (!labels.includes(time)) {
                                    labels.push(time);
                                }
                            });
                        });

                        // Populate the data arrays for each category based on time
                        labels.forEach(label => {
                            foodData.push(data.data.Food[label] || 0);
                            nonFoodData.push(data.data.NonFood[label] || 0);
                            medicineData.push(data.data.Medicine[label] || 0);
                        });

                        categoryChart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: labels, // Time periods
                                datasets: [{
                                        label: 'Food',
                                        data: foodData,
                                        backgroundColor: 'rgba(75, 192, 192, 0.5)',
                                        borderColor: 'rgba(75, 192, 192, 1)',
                                        borderWidth: 1,
                                    },
                                    {
                                        label: 'Non-Food',
                                        data: nonFoodData,
                                        backgroundColor: 'rgba(255, 159, 64, 0.5)',
                                        borderColor: 'rgba(255, 159, 64, 1)',
                                        borderWidth: 1,
                                    },
                                    {
                                        label: 'Medicine',
                                        data: medicineData,
                                        backgroundColor: 'rgba(153, 102, 255, 0.5)',
                                        borderColor: 'rgba(153, 102, 255, 1)',
                                        borderWidth: 1,
                                    },
                                ],
                            },
                            options: {
                                responsive: true,
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                    },
                                },
                            },
                        });

                        // Update table
                        const tableBody = document.getElementById('donationCategoryChartTable')?.querySelector('tbody');
                        if (tableBody) {
                            tableBody.innerHTML = '';
                            // Iterate through all time periods and populate the table
                            labels.forEach(time => {
                                const foodCount = data.data.Food[time] || 0;
                                const nonFoodCount = data.data.NonFood[time] || 0;
                                const medicineCount = data.data.Medicine[time] || 0;
                                const row = `
                                <tr>
                                    <td>${time}</td>
                                    <td>Food: ${foodCount}</td>
                                    <td>Non-Food: ${nonFoodCount}</td>
                                    <td>Medicine: ${medicineCount}</td>
                                </tr>`;
                                tableBody.innerHTML += row;
                            });
                        } else {
                            console.error('Error: Table body element not found.');
                        }
                    })
                    .catch(error => console.error('Error fetching donation categories:', error));
            }

            function updateInventoryStockChart() {
                const filter = document.getElementById('inventoryStockChartFilter').value;

                fetch(`/admin/inventory-stock?filter=${filter}`)
                    .then(response => response.json())
                    .then(data => {
                        // Update chart
                        if (inventoryStockChart) inventoryStockChart.destroy();

                        const ctx = document.getElementById('inventoryStockChart').getContext('2d');

                        // Prepare chart labels (categories) and datasets
                        const labels = [];
                        const lowData = [];
                        const midData = [];
                        const highData = [];

                        // Iterate through each category in the response
                        Object.keys(data.data).forEach(category => {
                            labels.push(category);
                            lowData.push(data.data[category].low || 0);
                            midData.push(data.data[category].mid || 0);
                            highData.push(data.data[category].high || 0);
                        });

                        inventoryStockChart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: labels, // Inventory categories (e.g., Food, Non-Food)
                                datasets: [{
                                        label: 'Low',
                                        data: lowData,
                                        backgroundColor: 'rgba(255, 99, 132, 0.5)',
                                        borderColor: 'rgba(255, 99, 132, 1)',
                                        borderWidth: 1,
                                    },
                                    {
                                        label: 'Mid',
                                        data: midData,
                                        backgroundColor: 'rgba(255, 159, 64, 0.5)',
                                        borderColor: 'rgba(255, 159, 64, 1)',
                                        borderWidth: 1,
                                    },
                                    {
                                        label: 'High',
                                        data: highData,
                                        backgroundColor: 'rgba(75, 192, 192, 0.5)',
                                        borderColor: 'rgba(75, 192, 192, 1)',
                                        borderWidth: 1,
                                    },
                                ],
                            },
                            options: {
                                responsive: true,
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                    },
                                },
                            },
                        });

                        // Update table
                        const tableBody = document.getElementById('inventoryStockChartTable')?.querySelector('tbody');
                        if (tableBody) {
                            tableBody.innerHTML = '';
                            // Iterate through each category and populate the table
                            Object.keys(data.data).forEach(category => {
                                const lowCount = data.data[category].low || 0;
                                const midCount = data.data[category].mid || 0;
                                const highCount = data.data[category].high || 0;
                                const row = `
                        <tr>
                            <td>${category}</td>
                            <td>${lowCount}</td>
                            <td>${midCount}</td>
                            <td>${highCount}</td>
                        </tr>`;
                                tableBody.innerHTML += row;
                            });
                        } else {
                            console.error('Error: Table body element not found.');
                        }
                    })
                    .catch(error => console.error('Error fetching inventory categories:', error));
            }

            function updateDistributedDonationChart() {
                const filter = document.getElementById('distributedDonationChartFilter').value;

                fetch(`/admin/distributed-donation?filter=${filter}`) // Replace with your actual API endpoint
                    .then(response => {
                        return response.json();
                    })
                    .then(data => {

                        if (!data || !data.data) {
                            console.error('Error: Invalid data received from the server');
                            return; // Exit early if no data is found
                        }

                        // Update chart
                        if (distributedDonationChart) distributedDonationChart.destroy();

                        const ctx = document.getElementById('distributedDonationChart').getContext('2d');
                        distributedDonationChart = new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: Object.keys(data.data), // Time periods (e.g., days, months, years)
                                datasets: [{
                                    label: 'Distributed Donations',
                                    data: Object.values(data.data), // Corresponding number of donations
                                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                                    borderColor: 'rgba(54, 162, 235, 1)',
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                responsive: true,
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });

                        // Update table
                        const tableBody = document.getElementById('distributedDonationChartTable')?.querySelector('tbody');
                        if (tableBody) {
                            tableBody.innerHTML = '';
                            Object.entries(data.data).forEach(([time, count]) => {
                                const row = `<tr><td>${time}</td><td>${count}</td></tr>`;
                                tableBody.innerHTML += row;
                            });
                        } else {
                            console.error('Error: Table body element not found.');
                        }
                    })
                    .catch(error => console.error('Error fetching distributed donations:', error));
            }

            // Print Function
            function printTable(tableId) {
                const table = document.getElementById(tableId);
                table.classList.remove('d-none');

                const newWindow = window.open();
                newWindow.document.write(`
                <html>
                    <head>
                        <title>Print</title>
                        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
                         <style>
                            @media print {
                                body {
                                    margin: 0;
                                    padding: 0;
                                }

                            }
                            table {
                                    width: 100%;
                                    margin: auto;
                            }
                        </style>
                    </head>
                    <body>
                        <div class="container-fluid mt-3">
                            <div>
                                <h3 class="text-center">DisasterEase</h3>
                                <div class="table-responsive">
                                    ${table.outerHTML}
                                </div>
                            </div>
                        </div>
                    </body>
                </html>
                `);
                // Close document to signal it is fully loaded
                newWindow.document.close();
                // Use a timeout to ensure the external styles are applied
                setTimeout(() => {
                    newWindow.print(); // Trigger the print dialog
                    newWindow.close(); // Close the new window after printing
                }, 50);
                table.classList.add('d-none');
            }

            document.addEventListener('DOMContentLoaded', function() {
                updateTotalDonationChart();
                updateDonationCategoryChart();
                updateInventoryStockChart();
                updateDistributedDonationChart();
            });
        </script>
    @endcan
    @can('browse_dashboard_municipal')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Function Chart Collection
                createBarangayRequestChart();
                createBarangayVulnerabilityChart();
                createBarangayDonationsPieChart();
                createUserRolesRadarChart();

                // Chart Barangay Request - Chart 1
                function createBarangayRequestChart() {
                    const barangayRequestsChart = document.getElementById('barangayRequestsChart').getContext('2d');

                    fetch('/admin/barangay-requests-data')
                        .then(response => response.json())
                        .then(data => {
                            // Process data for the chart
                            const labels = data.map(item => item.barangay.name);
                            const counts = data.map(item => item.total_requests);

                            // Create the chart
                            new Chart(barangayRequestsChart, {
                                type: 'bar',
                                data: {
                                    labels: labels,
                                    datasets: [{
                                        label: 'Number of Requests',
                                        data: counts,
                                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                                        borderColor: 'rgba(54, 162, 235, 1)',
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    indexAxis: 'y',
                                    scales: {
                                        x: {
                                            beginAtZero: true,
                                            title: {
                                                display: true,
                                                text: 'Number of Requests'
                                            }
                                        },
                                        y: {
                                            title: {
                                                display: true,
                                                text: 'Barangays'
                                            },
                                        }
                                    },
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    plugins: {
                                        title: {
                                            display: true,
                                            text: 'Barangay Donation Requests',
                                            padding: {
                                                top: 10,
                                            }
                                        }
                                    }
                                }
                            });
                        })
                        .catch(error => console.error('Error fetching barangay request data:', error));
                }


                // Barangay Priotization - Chart 2
                function createBarangayVulnerabilityChart() {
                    const barangayVulnerabilityChart = document.getElementById('barangayVulnerabilityChart').getContext(
                        '2d');

                    fetch('/admin/barangay-vulnerability-data') // Endpoint for fetching the vulnerability data
                        .then(response => response.json())
                        .then(data => {

                            // Process data for the chart
                            const labels = data.map(item => item.barangay); // Extract barangay names
                            const highVulnerability = data.map(item => item.vulnerability === 'High' ? 1 : 0);
                            const moderateVulnerability = data.map(item => item.vulnerability === 'Moderate' ? 1 :
                                0);
                            const lowVulnerability = data.map(item => item.vulnerability === 'Low' ? 1 : 0);

                            // Create the chart
                            new Chart(barangayVulnerabilityChart, {
                                type: 'bar', // Horizontal bar chart
                                data: {
                                    labels: labels, // Barangay names
                                    datasets: [{
                                            label: 'High Vulnerability',
                                            data: highVulnerability,
                                            backgroundColor: 'rgba(255, 99, 132, 0.6)',
                                            borderColor: 'rgba(255, 99, 132, 1)',
                                            borderWidth: 1
                                        },
                                        {
                                            label: 'Moderate Vulnerability',
                                            data: moderateVulnerability,
                                            backgroundColor: 'rgba(255, 159, 64, 0.6)',
                                            borderColor: 'rgba(255, 159, 64, 1)',
                                            borderWidth: 1
                                        },
                                        {
                                            label: 'Low Vulnerability',
                                            data: lowVulnerability,
                                            backgroundColor: 'rgba(75, 192, 192, 0.6)',
                                            borderColor: 'rgba(75, 192, 192, 1)',
                                            borderWidth: 1
                                        }
                                    ]
                                },
                                options: {
                                    indexAxis: 'y', // Horizontal bar chart
                                    scales: {
                                        x: {
                                            beginAtZero: true,
                                            title: {
                                                display: true,
                                                text: 'Number of Barangays'
                                            }
                                        },
                                        y: {
                                            title: {
                                                display: true,
                                                text: 'Barangays'
                                            }
                                        }
                                    },
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    plugins: {
                                        title: {
                                            display: true,
                                            text: 'Urgency per Barangay',
                                            padding: {
                                                top: 10,
                                            }
                                        }
                                    }
                                }
                            });

                        })
                        .catch(error => console.error('Error fetching barangay vulnerability data:', error));
                }

                // Barangay Total Donations - Chart 3
                function createBarangayDonationsPieChart() {
                    const barangayDonationsChart = document.getElementById('barangayDonationsChart').getContext('2d');

                    fetch('/admin/barangay-donations-data') // Endpoint for fetching the donation data
                        .then(response => response.json())
                        .then(data => {

                            // Process data for the chart
                            const labels = data.map(item => item.barangay); // Barangay names
                            const donationCounts = data.map(item => item
                                .total_donations); // Total donations per barangay

                            // Define a static color palette (16 visually pleasing colors)
                            const colorPalette = [
                                'rgba(255, 99, 132, 0.6)', // Soft Red
                                'rgba(54, 162, 235, 0.6)', // Soft Blue
                                'rgba(75, 192, 192, 0.6)', // Aqua
                                'rgba(255, 205, 86, 0.6)', // Soft Yellow
                                'rgba(153, 102, 255, 0.6)', // Lavender
                                'rgba(201, 203, 207, 0.6)', // Light Gray
                                'rgba(255, 159, 64, 0.6)', // Orange
                                'rgba(140, 235, 54, 0.6)', // Lime Green
                                'rgba(66, 135, 245, 0.6)', // Sky Blue
                                'rgba(245, 66, 206, 0.6)', // Pink
                                'rgba(100, 66, 245, 0.6)', // Purple
                                'rgba(54, 245, 165, 0.6)', // Mint Green
                                'rgba(245, 134, 66, 0.6)', // Coral
                                'rgba(140, 66, 245, 0.6)', // Violet
                                'rgba(245, 245, 66, 0.6)', // Sunflower Yellow
                                'rgba(66, 245, 102, 0.6)' // Fresh Green
                            ];

                            // Trim or repeat colors to match the number of barangays
                            const backgroundColors = colorPalette.slice(0, labels.length);
                            const borderColors = backgroundColors.map(color => color.replace('0.6', '1'));

                            // Create the chart
                            new Chart(barangayDonationsChart, {
                                type: 'pie',
                                data: {
                                    labels: labels, // Labels are barangay names
                                    datasets: [{
                                        label: 'Total Donations per Barangay',
                                        data: donationCounts, // Donation counts
                                        backgroundColor: backgroundColors,
                                        borderColor: borderColors,
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    plugins: {
                                        title: {
                                            display: true,
                                            text: 'Barangay Donations',
                                            padding: {
                                                top: 10,
                                            }
                                        }
                                    }
                                }
                            });
                        })
                        .catch(error => console.error('Error fetching barangay donations data:', error));
                }

                function createUserRolesRadarChart() {
                    const userRolesChart = document.getElementById('userRolesChart').getContext('2d');

                    fetch('/admin/user-role-counts') // Endpoint to fetch role counts
                        .then(response => response.json())
                        .then(data => {
                            console.log(data);

                            // Extract roles and counts
                            const labels = data.roles; // Roles: ["Users", "Barangay"]
                            const roleCounts = data.counts; // Counts: [150, 16]

                            // Define a color palette
                            const backgroundColors = [
                                'rgba(54, 162, 235, 0.5)', // Blue for Users
                                'rgba(255, 99, 132, 0.5)', // Red for Barangay
                                'rgba(54, 62, 35, 0.5)',
                            ];
                            const borderColors = [
                                'rgba(54, 162, 235, 1)', // Blue Border
                                'rgba(255, 99, 132, 1)', // Red Border
                                'rgba(54, 62, 35, 1)',
                            ];

                            // Create the radar chart
                            new Chart(userRolesChart, {
                                type: 'radar',
                                data: {
                                    labels: labels, // User roles
                                    datasets: [{
                                        label: 'Users',
                                        data: roleCounts, // Counts
                                        backgroundColor: backgroundColors[0],
                                        borderColor: borderColors[0],
                                        borderWidth: 2,
                                        pointBackgroundColor: borderColors[0],
                                        pointBorderColor: '#fff',
                                        pointHoverBackgroundColor: '#fff',
                                        pointHoverBorderColor: borderColors[0]
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    scales: {
                                        r: {
                                            beginAtZero: true, // Start radar from 0
                                            grid: {
                                                color: 'rgba(200, 200, 200, 0.2)' // Light grid color
                                            },
                                            ticks: {
                                                stepSize: 5 // Adjust step size for readability
                                            }
                                        }
                                    },
                                    plugins: {
                                        legend: {
                                            position: 'top'
                                        },
                                        tooltip: {
                                            enabled: true
                                        },
                                        title: {
                                            display: true,
                                            text: 'User Engagements',
                                            padding: {
                                                top: 10,
                                            }
                                        }
                                    },

                                }
                            });
                        })
                        .catch(error => console.error('Error fetching user role counts data:', error));
                }



            });
        </script>
    @endcan
@endsection
