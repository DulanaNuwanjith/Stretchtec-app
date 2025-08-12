<div class="flex h-full w-full font-sans">
    @include('layouts.side-bar')
    <div class="flex-1 overflow-y-auto p-8 bg-white dark:bg-gray-900">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold text-gray-800 dark:text-white">Reports Generator</h2>
        </div>

        <!-- Order Number Form -->
        <form action="{{ route('report.order') }}" method="GET" class="mb-6 space-y-4">
            @csrf
            <div>
                <label for="order_no" class="block font-medium mb-1">Enter Order Number:</label>
                <input type="text" name="order_no" id="order_no" required class="border p-2 rounded w-64">
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Generate Report
            </button>
        </form>

        <!-- Date Range Form -->
        <form action="{{ route('report.inquiryRange') }}" method="GET" class="mb-6 space-y-4">
            @csrf
            <div>
                <label for="start_date" class="block font-medium mb-1">Start Date:</label>
                <input type="date" name="start_date" id="start_date" required class="border p-2 rounded w-64">
            </div>

            <div>
                <label for="end_date" class="block font-medium mb-1">End Date:</label>
                <input type="date" name="end_date" id="end_date" required class="border p-2 rounded w-64">
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Download PDF
            </button>
        </form>
    </div>
</div>
