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
                                {{ $totalDonation }}
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
                                <select class="col form-select" id="timeChartOnePeriod">
                                    <option value="daily">Daily</option>
                                    <option value="weekly">Weekly</option>
                                    <option value="monthly">Monthly</option>
                                </select>
                                <button class="mx-1 btn col-2 btn-secondary" id="printChartOneButton">
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
                            <canvas id="donationsChart" style="height: 300px;"></canvas>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card p-3">
                            <div class="row">
                                <select class="col form-select" id="timeChartTwoPeriod">
                                    <option value="daily">Daily</option>
                                    <option value="weekly">Weekly</option>
                                    <option value="monthly">Monthly</option>
                                </select>
                                <button class="mx-1 btn col-2 btn-secondary" id="printChartTwoButton">
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
                            <canvas id="donationBreakdownChart" style="height: 300px;"></canvas>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="card p-3">
                            <canvas id="inventoryTypeChart" style="height: 300px;"></canvas>
                        </div>
                    </div>

                    <div class="col">
                        <div class="card p-3">
                            <canvas id="barangayDonationChart" style="height: 300px;"></canvas>
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

            {{-- Printables --}}
            <div id="printChartOneTableContainer" style="display:none;">
                <table id="printTable" border="1" cellpadding="5" cellspacing="0"
                    style="width:100%; border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th>Period</th>
                            <th>Total Donations</th>
                        </tr>
                    </thead>
                    <tbody id="printChartOneTableBody">
                        <!-- Data rows will be inserted here -->
                    </tbody>
                </table>
            </div>


            {{-- Chart two printable --}}
            <table class="table table-bordered" id="printChartTwoTable" style="display:none;">
                <thead>
                    <tr>
                        <th>Period</th>
                        <th>Food</th>
                        <th>Nonfood</th>
                        <th>Medical</th>
                    </tr>
                </thead>
                <tbody id="printChartTwoTableBody"></tbody>
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
                                    <canvas id="barangayRequestsChart" style="height: 300px;"></canvas>
                                </div>
                            </div>
                            <!-- Chart 2 -->
                            <div class="col">
                                <div class="card shadow p-2 m-1">
                                    <canvas id="prioritizationChart" style="height: 300px;"></canvas>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Chart 3 -->
                            <div class="col">
                                <div class="card shadow p-2 m-1">
                                    <canvas id="totalDonationsChart" style="height: 300px;"></canvas>
                                </div>
                            </div>
                            <!-- Chart 4 -->
                            <div class="col">
                                <div class="card shadow p-2 m-1">
                                    <canvas id="engagementChart" style="height: 300px;"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
            //JS for Barangay
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

            // New Charts
            document.addEventListener('DOMContentLoaded', function() {
                // Chart One
                const ctx = document.getElementById('donationsChart').getContext('2d');
                const timeChartOnePeriodSelect = document.getElementById('timeChartOnePeriod');
                const printChartOneButton = document.getElementById('printChartOneButton');

                // Chart Two
                const ctxTwo = document.getElementById('donationBreakdownChart').getContext('2d');
                const timeChartTwoPeriod = document.getElementById('timeChartTwoPeriod');
                const printChartTwoButton = document.getElementById('printChartTwoButton');
                const printChartTwoTable = document.getElementById('printChartTwoTable');
                const tableChartTwoBody = document.getElementById('printChartTwoTableBody');


                let donationsChart = new Chart(ctx, {
                    type: 'line', // You can change to 'line' if preferred
                    data: {
                        labels: [],
                        datasets: [{
                            label: 'Total Donations',
                            data: [],
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            x: {
                                beginAtZero: true
                            },
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });

                function updateChart(period) {
                    fetch(`https://paranaque.disasterease.org/admin/donations-chart-data?period=${period}`)
                        .then(response => response.json())
                        .then(data => {

                            const labels = data.map(item => {
                                if (period === 'weekly') {
                                    // Use week_start and week_end for weekly period
                                    return `${item.week_start} to ${item.week_end}`;
                                }
                                return item.period; // Use period for daily and monthly
                            });

                            // const labels = data.map(item => item.period);
                            const counts = data.map(item => item.total);

                            donationsChart.data.labels = labels;
                            donationsChart.data.datasets[0].data = counts;
                            donationsChart.update();

                            // Populate table for printing
                            populateChartOnePrintTable(data);
                        })
                        .catch(error => console.error('Error fetching data:', error));
                }

                function populateChartOnePrintTable(data) {
                    const tableBody = document.getElementById('printChartOneTableBody');
                    tableBody.innerHTML = ''; // Clear existing rows
                    data.forEach(item => {
                        const row = document.createElement('tr');
                        const periodCell = document.createElement('td');
                        const totalCell = document.createElement('td');

                        // If it's a week-based period, show the formatted week range
                        if (item.week_start && item.week_end) {
                            periodCell.textContent = `${item.week_start} to ${item.week_end}`;
                        } else {
                            // For other periods, you can just display the period (e.g., '2024-01-01')
                            periodCell.textContent = item.period || 'N/A';
                        }


                        totalCell.textContent = item.total;

                        row.appendChild(periodCell);
                        row.appendChild(totalCell);
                        tableBody.appendChild(row);
                    });
                }

                printChartOneButton.addEventListener('click', () => {
                    const printWindow = window.open('', '', 'width=800,height=600');
                    const printContent = document.getElementById('printChartOneTableContainer').innerHTML;
                    printWindow.document.write(printContent);
                    printWindow.document.close();
                    printWindow.print();
                });

                // Initialize chart with default period
                updateChart(timeChartOnePeriodSelect.value);

                // Update chart when time period changes
                timeChartOnePeriodSelect.addEventListener('change', (event) => {
                    updateChart(event.target.value);
                });

                // 2nd Chart
                let donationBreakdownChart = new Chart(ctxTwo, {
                    type: 'bar',
                    data: {
                        labels: [],
                        datasets: [{
                                label: 'Food',
                                data: [],
                                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                borderColor: 'rgba(255, 99, 132, 1)',
                                borderWidth: 1
                            },
                            {
                                label: 'NonFood',
                                data: [],
                                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            },
                            {
                                label: 'Medical',
                                data: [],
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 1
                            }
                        ]
                    },
                    options: {
                        scales: {
                            x: {
                                beginAtZero: true
                            },
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });

                function updateChartTwo(period) {
                    fetch(`https://paranaque.disasterease.org/admin/donation-breakdown-chart-data?period=${period}`)
                        .then(response => response.json())
                        .then(data => {
                            console.log('Fetched data:', data); // Log the response for debugging

                            // Initialize label and data arrays
                            const labels = [...new Set(data.map(item => item.period))];
                            const foodData = Array(labels.length).fill(0);
                            const nonfoodData = Array(labels.length).fill(0);
                            const medicalData = Array(labels.length).fill(0);

                            // Process data to populate datasets
                            data.forEach(item => {
                                const labelIndex = labels.indexOf(item.period);
                                if (labelIndex !== -1) {
                                    if (item.category === "Food") {
                                        foodData[labelIndex] += item.total;
                                    } else if (item.category === "NonFood") {
                                        nonfoodData[labelIndex] += item.total;
                                    } else if (item.category === "Medical") {
                                        medicalData[labelIndex] += item.total;
                                    }
                                }
                            });

                            const formattedLabels = labels.map(periodLabel => {
                                if (periodLabel.includes('W')) {
                                    // Extract year and week number from period label (e.g., '2024-W47')
                                    const [year, week] = periodLabel.split('-W');
                                    const startDate = getStartOfISOWeek(parseInt(year), parseInt(week));

                                    // Calculate the start and end dates of the week
                                    const end = new Date(startDate);
                                    end.setDate(startDate.getDate() + 6); // End date (6 days later)

                                    // Format the date range (e.g., '2024-11-18 to 2024-11-24')
                                    const startFormatted = startDate.toISOString().split('T')[0];
                                    const endFormatted = end.toISOString().split('T')[0];
                                    return `${startFormatted} to ${endFormatted}`;
                                } else {
                                    return periodLabel; // If it's not a weekly period, return the original label
                                }
                            });

                            // Log processed data for verification
                            console.log("Labels:", formattedLabels);
                            console.log("Food Data:", foodData);
                            console.log("NonFood Data:", nonfoodData);
                            console.log("Medical Data:", medicalData);

                            // Update the chart data
                            donationBreakdownChart.data.labels = formattedLabels;
                            donationBreakdownChart.data.datasets[0].data = foodData;
                            donationBreakdownChart.data.datasets[1].data = nonfoodData;
                            donationBreakdownChart.data.datasets[2].data = medicalData;

                            // Refresh the chart
                            donationBreakdownChart.update();

                            // Populate the print table
                            populateChartTwoPrintTable(labels, foodData, nonfoodData, medicalData);
                        })
                        .catch(error => console.error('Error fetching data:', error));
                }

                function getStartOfISOWeek(year, week) {
                    const date = new Date(year, 0, 1); // Start with the first day of the year
                    const days = (week - 1) * 7 - date.getDay() + 1; // Adjust for ISO week (Monday = 1)
                    date.setDate(date.getDate() + days);
                    return date;
                }

                function populateChartTwoPrintTable(labels, foodData, nonfoodData, medicalData) {
                    tableChartTwoBody.innerHTML = ''; // Clear the existing rows

                    labels.forEach((label, index) => {
                        const row = document.createElement('tr');

                        const periodCell = document.createElement('td');
                        const foodCell = document.createElement('td');
                        const nonfoodCell = document.createElement('td');
                        const medicalCell = document.createElement('td');

                        periodCell.textContent = label || 'N/A';
                        foodCell.textContent = foodData[index] || 0;
                        nonfoodCell.textContent = nonfoodData[index] || 0;
                        medicalCell.textContent = medicalData[index] || 0;

                        row.appendChild(periodCell);
                        row.appendChild(foodCell);
                        row.appendChild(nonfoodCell);
                        row.appendChild(medicalCell);

                        tableChartTwoBody.appendChild(row);
                    });

                    console.log('Populating table with labels:', labels);
                    console.log('Table content added:', tableChartTwoBody.innerHTML);
                }


                updateChartTwo(timeChartTwoPeriod.value);

                timeChartTwoPeriod.addEventListener('change', (event) => {
                    updateChartTwo(event.target.value);
                });

                printChartTwoButton.addEventListener('click', () => {
                    printChartTwoTable.style.display = 'block';
                    window.print();
                    printChartTwoTable.style.display = 'none';
                });

                function updateInventoryChart() {
                    fetch('https://paranaque.disasterease.org/admin/inventory-data') // Adjust URL to fetch the inventory data
                        .then(response => response.json())
                        .then(data => {
                            console.log('Fetched inventory data:', data);

                            // Initialize labels and datasets
                            const labels = data.map(item => item.donation_type);
                            const quantities = data.map(item => item.total);

                            // Chart configuration
                            const inventoryChart = new Chart(document.getElementById('inventoryTypeChart')
                                .getContext(
                                    '2d'), {
                                    type: 'bar', // Bar chart type
                                    data: {
                                        labels: labels,
                                        datasets: [{
                                            label: 'Inventory Levels',
                                            data: quantities,
                                            backgroundColor: ['#42A5F5', '#66BB6A',
                                                '#FF7043'
                                            ], // Different colors for each category
                                            borderColor: ['#1E88E5', '#43A047', '#D32F2F'],
                                            borderWidth: 1
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        plugins: {
                                            legend: {
                                                position: 'top',
                                            },
                                            tooltip: {
                                                callbacks: {
                                                    label: function(tooltipItem) {
                                                        return `${tooltipItem.label}: ${tooltipItem.raw} items`;
                                                    }
                                                }
                                            }
                                        },
                                        scales: {
                                            y: {
                                                beginAtZero: true,
                                                title: {
                                                    display: true,
                                                    text: 'Quantity'
                                                }
                                            },
                                            x: {
                                                title: {
                                                    display: true,
                                                    text: 'Donation Type'
                                                }
                                            }
                                        }
                                    }
                                });
                        })
                        .catch(error => console.error('Error fetching inventory data:', error));
                }

                // Call the function to load the chart
                updateInventoryChart();



            });
        </script>
    @endcan
    @can('browse_dashboard_municipal')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // JS for admin
            // Barangay Requests Chart
            const barangayRequestsData = @json($barangayRequests);
            const barangayRequestsLabels = barangayRequestsData.map(item => item.barangay_name);
            const barangayRequestsCounts = barangayRequestsData.map(item => item.request_count);
            new Chart(document.getElementById('barangayRequestsChart'), {
                type: 'bar',
                data: {
                    labels: barangayRequestsLabels,
                    datasets: [{
                        label: 'Requests',
                        data: barangayRequestsCounts,
                        backgroundColor: 'rgba(75, 192, 192, 0.6)'
                    }],
                    options: {
                        scales: {
                            x: {
                                beginAtZero: true
                            },
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                }
            });

            // Prioritization Chart
            const prioritizationData = @json($prioritization);
            const prioritizationLabels = prioritizationData.map(item => item.area);
            const prioritizationUrgency = prioritizationData.map(item => item.urgency_level);
            new Chart(document.getElementById('prioritizationChart'), {
                type: 'doughnut',
                data: {
                    labels: prioritizationLabels,
                    datasets: [{
                        label: 'Urgency',
                        data: prioritizationUrgency,
                        backgroundColor: ['#ff6384', '#36a2eb', '#cc65fe']
                    }]
                }
            });

            // Total Donations Chart
            const totalDonationsData = @json($totalDonations);
            const totalDonationsLabels = totalDonationsData.map(item => item.barangay_name);
            const totalDonationsCounts = totalDonationsData.map(item => item.total_donations);
            new Chart(document.getElementById('totalDonationsChart'), {
                type: 'pie',
                data: {
                    labels: totalDonationsLabels,
                    datasets: [{
                        label: 'Donations',
                        data: totalDonationsCounts,
                        backgroundColor: ['#ffcd56', '#ff6384', '#36a2eb', '#cc65fe']
                    }],
                    options: {
                        scales: {
                            x: {
                                beginAtZero: true
                            },
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                }
            });

            // User Engagement Chart
            const userEngagementData = @json($userEngagement);
            const userEngagementLabels = userEngagementData.map(item => item.role);
            const userEngagementCounts = userEngagementData.map(item => item.user_count);
            new Chart(document.getElementById('engagementChart'), {
                type: 'radar',
                data: {
                    labels: userEngagementLabels,
                    datasets: [{
                        label: 'Engagement',
                        data: userEngagementCounts,
                        backgroundColor: 'rgba(153, 102, 255, 0.6)'
                    }]
                }
            });
        </script>
    @endcan
@endsection
