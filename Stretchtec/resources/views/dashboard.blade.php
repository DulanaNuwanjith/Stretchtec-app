<div class="flex h-full w-full font-sans">
    @include('layouts.side-bar')
    <div class="flex-1 overflow-y-auto p-8 bg-white dark:bg-gray-900">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold text-gray-800 dark:text-white">
                Welcome, {{ Auth::user()->name }}!
            </h2>
        </div>

        <!-- Cards Section -->
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-6 mb-12">

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 flex flex-col items-center space-y-6">
                <!-- Active Orders Card -->
                <div class="mb-4">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white whitespace-nowrap overflow-hidden text-ellipsis">
                        All Sample Inquiries</h3>
                </div>

                <!-- All-time data -->
                <div class="text-center w-full">
                    <h4 class="text-md font-semibold text-gray-700 dark:text-gray-300 mb-1">All Time</h4>
                    <div class="text-3xl font-semibold text-indigo-600">{{ $allSamplesReceived ?? 0 }}</div>
                    <div class="text-gray-500 dark:text-gray-400 text-sm">Samples</div>
                </div>

                <hr class="w-full border-gray-300 dark:border-gray-700" />

                <!-- Last 30 days data -->
                <div class="text-center w-full">
                    <h4 class="text-md font-semibold text-gray-700 dark:text-gray-300 mb-1">Last 30 Days</h4>
                    <div class="text-3xl font-semibold text-indigo-400">{{ $allSamplesReceivedWithin30Days ?? 0 }}</div>
                    <div class="text-gray-500 dark:text-gray-400 text-sm">Samples</div>
                </div>
            </div>

            <!-- Accepted Orders Card -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 flex flex-col items-center space-y-6">
                <div class="mb-4">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white whitespace-nowrap overflow-hidden text-ellipsis">
                        Accepted Samples</h3>
                </div>

                <!-- All-time data -->
                <div class="text-center w-full">
                    <h4 class="text-md font-semibold text-gray-700 dark:text-gray-300 mb-1">All Time</h4>
                    <div class="text-3xl font-semibold text-green-600">{{ $acceptedSamples ?? 0 }}</div>
                    <div class="text-gray-500 dark:text-gray-400 text-sm">Samples</div>
                </div>

                <hr class="w-full border-gray-300 dark:border-gray-700" />

                <!-- Last 30 days data -->
                <div class="text-center w-full">
                    <h4 class="text-md font-semibold text-gray-700 dark:text-gray-300 mb-1">Last 30 Days</h4>
                    <div class="text-3xl font-semibold text-green-400">{{ $acceptedSamplesWithin30Days ?? 0 }}</div>
                    <div class="text-gray-500 dark:text-gray-400 text-sm">Orders</div>
                </div>
            </div>

            <!-- Rejected Orders Card -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 flex flex-col items-center space-y-6">
                <div class="mb-4">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white whitespace-nowrap overflow-hidden text-ellipsis">
                        Rejected Samples</h3>
                </div>

                <!-- All-time data -->
                <div class="text-center w-full">
                    <h4 class="text-md font-semibold text-gray-700 dark:text-gray-300 mb-1">All Time</h4>
                    <div class="text-3xl font-semibold text-red-600">{{ $rejectedSamples ?? 0 }}</div>
                    <div class="text-gray-500 dark:text-gray-400 text-sm">Samples</div>
                </div>

                <hr class="w-full border-gray-300 dark:border-gray-700" />

                <!-- Last 30 days data -->
                <div class="text-center w-full">
                    <h4 class="text-md font-semibold text-gray-700 dark:text-gray-300 mb-1">Last 30 Days</h4>
                    <div class="text-3xl font-semibold text-red-400">{{ $rejectedSamplesWithin30Days ?? 0 }}</div>
                    <div class="text-gray-500 dark:text-gray-400 text-sm">Samples</div>
                </div>
            </div>

            <!-- Orders in Production Card -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 flex flex-col items-center space-y-6">
                <div class="mb-4">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white whitespace-nowrap overflow-hidden text-ellipsis">
                        In Production</h3>
                </div>

                <!-- All-time data -->
                <div class="text-center w-full">
                    <h4 class="text-md font-semibold text-gray-700 dark:text-gray-300 mb-1">All Time</h4>
                    <div class="text-3xl font-semibold text-yellow-600">{{ $inProductionSamples ?? 0 }}</div>
                    <div class="text-gray-500 dark:text-gray-400 text-sm">Samples</div>
                </div>

                <hr class="w-full border-gray-300 dark:border-gray-700" />

                <!-- Last 30 days data -->
                <div class="text-center w-full">
                    <h4 class="text-md font-semibold text-gray-700 dark:text-gray-300 mb-1">Last 30 Days</h4>
                    <div class="text-3xl font-semibold text-yellow-400">{{ $inProductionSamplesWithin30Days ?? 0 }}</div>
                    <div class="text-gray-500 dark:text-gray-400 text-sm">Samples</div>
                </div>
            </div>

            <!-- Production Complete Samples Card -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 flex flex-col items-center space-y-6">
                <div class="mb-4">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white whitespace-nowrap overflow-hidden text-ellipsis">
                        Production Complete</h3>
                </div>

                <!-- All-time data -->
                <div class="text-center w-full">
                    <h4 class="text-md font-semibold text-gray-700 dark:text-gray-300 mb-1">All Time</h4>
                    <div class="text-3xl font-semibold text-blue-600">{{ $productionCompleteSamples ?? 0 }}</div>
                    <div class="text-gray-500 dark:text-gray-400 text-sm">Samples</div>
                </div>

                <hr class="w-full border-gray-300 dark:border-gray-700" />

                <!-- Last 30 days data -->
                <div class="text-center w-full">
                    <h4 class="text-md font-semibold text-gray-700 dark:text-gray-300 mb-1">Last 30 Days</h4>
                    <div class="text-3xl font-semibold text-blue-400">{{ $productionCompleteSamplesWithin30Days ?? 0 }}</div>
                    <div class="text-gray-500 dark:text-gray-400 text-sm">Samples</div>
                </div>
            </div>

            <!-- Yarn Ordered but Not Received Card -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 flex flex-col items-center space-y-6">
                <div class="mb-4">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white whitespace-nowrap overflow-hidden text-ellipsis">
                        Yarn Ordered (Not Received)</h3>
                </div>

                <!-- All-time data -->
                <div class="text-center w-full">
                    <h4 class="text-md font-semibold text-gray-700 dark:text-gray-300 mb-1">All Time</h4>
                    <div class="text-3xl font-semibold text-pink-600">{{ $yarnOrderedButNotReceived ?? 0 }}</div>
                    <div class="text-gray-500 dark:text-gray-400 text-sm">Samples</div>
                </div>

                <hr class="w-full border-gray-300 dark:border-gray-700" />

                <!-- Last 30 days data -->
                <div class="text-center w-full">
                    <h4 class="text-md font-semibold text-gray-700 dark:text-gray-300 mb-1">Last 30 Days</h4>
                    <div class="text-3xl font-semibold text-pink-400">{{ $yarnOrderedButNotReceivedWithin30Days ?? 0 }}</div>
                    <div class="text-gray-500 dark:text-gray-400 text-sm">Samples</div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 h-96">
                <h3 class="text-xl font-semibold mb-4 text-gray-700 dark:text-gray-200">Sample Overview by Customer Coordinators</h3>
                <canvas id="ordersChart" class="w-full h-80"></canvas>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 h-96">
                <h3 class="text-xl font-semibold mb-4 text-gray-700 dark:text-gray-200">Sample Overview by Customers</h3>
                <canvas id="customerSamplesChart" class="w-full h-80"></canvas>
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
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('ordersChart').getContext('2d');

        // These variables will be injected from the controller as JSON encoded data
        const labels = @json($coordinatorNames);
        const acceptedSamples = @json($acceptedSamplesCount);
        const rejectedSamples = @json($rejectedSamplesCount);

        const ordersChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Accepted Samples',
                        data: acceptedSamples,
                        backgroundColor: 'rgba(34, 197, 94, 0.7)',  // greenish
                    },
                    {
                        label: 'Rejected Samples',
                        data: rejectedSamples,
                        backgroundColor: 'rgba(239, 68, 68, 0.7)',  // reddish
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
                datasets: [
                    {
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
