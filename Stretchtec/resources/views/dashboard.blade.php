<head>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
</head>
<div class="flex h-full w-full font-sans bg-white">
    @include('layouts.side-bar')

    <div class="flex-1 overflow-y-auto p-6 md:p-10">
        <div class="flex justify-between items-start md:items-center mb-5">
            <!-- Header -->
            <div>
                <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100 mb-5">Sample Development Dashboard</h1>
            </div>
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10">
                <h2 class=" text-lg font-semibold text-blue-900 dark:text-white text-center">
                    Welcome, {{ Auth::user()->name }}!
                </h2>
            </div>
        </div>

        <!-- Cards Section -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-6 gap-6 mb-12">

            <!-- Default Sample Inquiry Cards -->
            @php
                $cards = [
                    [
                        'title' => 'All Samples',
                        'allTime' => $allSamplesReceived ?? 0,
                        'last30' => $allSamplesReceivedWithin30Days ?? 0,
                        'color' => 'indigo',
                    ],
                    [
                        'title' => 'Bulk Received',
                        'allTime' => $acceptedSamples ?? 0,
                        'last30' => $acceptedSamplesWithin30Days ?? 0,
                        'color' => 'green',
                    ],
                    [
                        'title' => 'Decision Pending',
                        'allTime' => $yetNotReceivedSamples ?? 0,
                        'last30' => $yetNotReceivedSamplesWithin30Days ?? 0,
                        'color' => 'pink',
                    ],
                    [
                        'title' => 'Rejected',
                        'allTime' => $rejectedSamples ?? 0,
                        'last30' => $rejectedSamplesWithin30Days ?? 0,
                        'color' => 'red',
                    ],
                ];
                $shadowColors = [
                    'indigo' => 'rgba(99, 102, 241, 0.5)', // indigo-500 with 50% opacity
                    'green' => 'rgba(34, 197, 94, 0.5)', // green-500
                    'pink' => 'rgba(236, 72, 153, 0.5)', // pink-500
                    'red' => 'rgba(239, 68, 68, 0.5)', // red-500
                ];
                $yellowShadow = 'rgba(234, 179, 8, 0.5)'; // Tailwind yellow-500 with 50% opacity
                $blueShadow = 'rgba(59, 130, 246, 0.5)'; // gray-400 at 30% opacity
            @endphp

            @foreach ($cards as $card)
                <div class="bg-white dark:bg-gray-800 rounded-xl transition-shadow duration-300 p-6 flex flex-col items-center space-y-6 border border-gray-100 dark:border-gray-700"
                    style="box-shadow: 0 4px 15px 0 {{ $shadowColors[$card['color']] ?? 'rgba(0,0,0,0.1)' }};">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white text-center">
                        {{ $card['title'] }}
                    </h3>

                    <!-- All-time data -->
                    <div class="text-center w-full">
                        <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">All Time</h4>
                        <div class="text-3xl font-bold text-{{ $card['color'] }}-600">{{ $card['allTime'] }}</div>
                        <div class="text-gray-400 text-xs">Samples</div>
                    </div>

                    <hr class="w-full border-gray-200 dark:border-gray-700" />

                    <!-- Last 30 days data -->
                    <div class="text-center w-full">
                        <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Last 30 Days</h4>
                        <div class="text-3xl font-bold text-{{ $card['color'] }}-400">{{ $card['last30'] }}</div>
                        <div class="text-gray-400 text-xs">Samples</div>
                    </div>
                </div>
            @endforeach

            <!-- Yarn Ordered but Not Received - Single Card with Supplier List -->
            <div class="bg-white dark:bg-gray-800 rounded-xl transition-shadow duration-300 p-6 flex flex-col items-center space-y-6 border border-gray-100 dark:border-gray-700"
                style="box-shadow: 0 4px 15px 0 {{ $yellowShadow }};">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-6 text-center">
                    Yarn Ordered But Not Received
                </h3>

                @if (count($yarnOrderedNotReceived) === 0)
                    <p class="text-center text-gray-500 dark:text-gray-400">No pending yarn orders found.</p>
                @else
                    <ul class="divide-y divide-gray-200 dark:divide-gray-700 max-h-60 overflow-y-auto">
                        @foreach ($yarnOrderedNotReceived as $supplier => $count)
                            @if (!empty($supplier))
                                <li class="flex justify-between py-2">
                                    <span
                                        class="text-gray-700 dark:text-gray-300 font-medium text-sm mr-10">{{ ucwords($supplier) }}</span>
                                    <span class="text-yellow-500 font-bold text-lg">{{ $count }}</span>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                @endif
            </div>

            <!-- Other Information-->
            <div class="bg-white dark:bg-gray-800 rounded-xl transition-shadow duration-300 p-6 flex flex-col items-center space-y-6 border border-gray-100 dark:border-gray-700"
                style="box-shadow: 0 4px 15px 0 {{ $blueShadow }};">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-6 text-center">
                    Sample Production Details
                </h3>
                <ul class="divide-y divide-gray-200 dark:divide-gray-700 max-h-60 overflow-y-auto">
                    <li class="flex justify-between py-2">
                        <span class="text-gray-700 dark:text-gray-300 font-medium text-sm mr-8">Leftover yarn</span>
                        <span class="text-indigo-500 font-bold text-lg">{{ $totalLeftOverYarn }}</span> <!-- Indigo -->
                    </li>
                    <li class="flex justify-between py-2">
                        <span class="text-gray-700 dark:text-gray-300 font-medium text-sm mr-8">Damaged Output</span>
                        <span class="text-red-500 font-bold text-lg">{{ $totalDamagedOutput }}</span> <!-- Red -->
                    </li>
                    <li class="flex justify-between py-2">
                        <span class="text-gray-700 dark:text-gray-300 font-medium text-sm mr-8">Production Output</span>
                        <span class="text-green-500 font-bold text-lg">{{ $totalProductionOutput }}</span>
                        <!-- Green -->
                    </li>
                </ul>
            </div>

        </div>


        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div
                class="bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 p-6 flex flex-col" style="border-top: 3px solid #3b82f6;">
                <h3 class="text-xl font-semibold mb-4 text-gray-700 dark:text-gray-200">
                    Sample Overview by Customer Coordinators
                </h3>
                <canvas id="ordersChart" class="flex-grow w-full"></canvas>
            </div>

            <div
                class="bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 p-6 flex flex-col" style="border-bottom: 3px solid #3b82f6;">
                <h3 class="text-xl font-semibold mb-4 text-gray-700 dark:text-gray-200">
                    Sample Overview by Customers
                </h3>
                <canvas id="customerSamplesChart" class="flex-grow w-full"></canvas>
            </div>
        </div>
    </div>
</div>


<script>
    // Auto-reload the dashboard every 60 seconds
    setTimeout(() => {
        window.location.reload();
    }, 30000);
</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('ordersChart').getContext('2d');

        // These variables will be injected from the controller as JSON encoded data
        const labels = @json($coordinatorNames);
        const acceptedSamples = @json($acceptedSamplesCount);
        const rejectedSamples = @json($rejectedSamplesCount);

        const ordersChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                        label: 'Accepted Samples',
                        data: acceptedSamples,
                        backgroundColor: 'rgba(34, 197, 94, 0.7)', // greenish
                    },
                    {
                        label: 'Rejected Samples',
                        data: rejectedSamples,
                        backgroundColor: 'rgba(239, 68, 68, 0.7)', // reddish
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Number of Samples'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Customer Coordinator'
                        }
                    }
                }
            }
        });

        const ctx2 = document.getElementById('customerSamplesChart').getContext('2d');

        const customerSamplesChart = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: @json($customerNames), // e.g. ["Customer A", "Customer B", "Customer C"]
                datasets: [{
                        label: 'Accepted Samples',
                        data: @json($acceptedSamplesCount2), // e.g. [10, 15, 7]
                        backgroundColor: 'rgba(34, 197, 94, 0.7)', // green-ish
                    },
                    {
                        label: 'Rejected Samples',
                        data: @json($rejectedSamplesCount2), // e.g. [2, 3, 1]
                        backgroundColor: 'rgba(239, 68, 68, 0.7)', // red-ish
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        stacked: false,
                        title: {
                            display: true,
                            text: 'Customers'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Number of Samples'
                        }
                    }
                }
            }
        });

    });
</script>
