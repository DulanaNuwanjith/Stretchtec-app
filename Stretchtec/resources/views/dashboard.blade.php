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
                    <div class="text-3xl font-semibold text-green-600">{{ $acceptedOrders ?? 0 }}</div>
                    <div class="text-gray-500 dark:text-gray-400 text-sm">Samples</div>
                </div>

                <hr class="w-full border-gray-300 dark:border-gray-700" />

                <!-- Last 30 days data -->
                <div class="text-center w-full">
                    <h4 class="text-md font-semibold text-gray-700 dark:text-gray-300 mb-1">Last 30 Days</h4>
                    <div class="text-3xl font-semibold text-green-400">{{ $acceptedOrdersWithin30Days ?? 0 }}</div>
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
                    <div class="text-3xl font-semibold text-red-600">{{ $rejectedOrders ?? 0 }}</div>
                    <div class="text-gray-500 dark:text-gray-400 text-sm">Samples</div>
                </div>

                <hr class="w-full border-gray-300 dark:border-gray-700" />

                <!-- Last 30 days data -->
                <div class="text-center w-full">
                    <h4 class="text-md font-semibold text-gray-700 dark:text-gray-300 mb-1">Last 30 Days</h4>
                    <div class="text-3xl font-semibold text-red-400">{{ $rejectedOrdersWithin30Days ?? 0 }}</div>
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
                    <div class="text-3xl font-semibold text-yellow-600">{{ $ordersInProduction ?? 0 }}</div>
                    <div class="text-gray-500 dark:text-gray-400 text-sm">Samples</div>
                </div>

                <hr class="w-full border-gray-300 dark:border-gray-700" />

                <!-- Last 30 days data -->
                <div class="text-center w-full">
                    <h4 class="text-md font-semibold text-gray-700 dark:text-gray-300 mb-1">Last 30 Days</h4>
                    <div class="text-3xl font-semibold text-yellow-400">{{ $ordersInProductionWithin30Days ?? 0 }}</div>
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
                    <div class="text-3xl font-semibold text-pink-600">{{ $yarnOrderedNotReceived ?? 0 }}</div>
                    <div class="text-gray-500 dark:text-gray-400 text-sm">Samples</div>
                </div>

                <hr class="w-full border-gray-300 dark:border-gray-700" />

                <!-- Last 30 days data -->
                <div class="text-center w-full">
                    <h4 class="text-md font-semibold text-gray-700 dark:text-gray-300 mb-1">Last 30 Days</h4>
                    <div class="text-3xl font-semibold text-pink-400">{{ $yarnOrderedNotReceivedWithin30Days ?? 0 }}</div>
                    <div class="text-gray-500 dark:text-gray-400 text-sm">Samples</div>
                </div>
            </div>
        </div>

            <!-- Graphs Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Graph 1 Placeholder -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 h-96">
                <h3 class="text-xl font-semibold mb-4 text-gray-700 dark:text-gray-200">Orders Overview</h3>
                <canvas id="ordersChart" class="w-full h-80"></canvas>
            </div>

            <!-- Graph 2 Placeholder -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 h-96">
                <h3 class="text-xl font-semibold mb-4 text-gray-700 dark:text-gray-200">Production & Yarn Status</h3>
                <canvas id="productionChart" class="w-full h-80"></canvas>
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
