<div class="flex h-full w-full font-sans bg-gray-50 dark:bg-gray-900">
    @include('layouts.side-bar')

    <div class="flex-1 overflow-y-auto p-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold text-gray-800 dark:text-white">Reports Generator</h2>
        </div>

        <!-- Flex container for all forms -->
        <div class="flex flex-col md:flex-row md:space-x-8 space-y-8 md:space-y-0 max-w-7xl mx-auto">

            <!-- Order Number Form -->
            <form action="{{ route('report.order') }}" method="GET"
                class="flex-1 bg-white dark:bg-gray-800 p-6 rounded shadow space-y-6 max-w-md mx-auto">
                @csrf
                <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4">Generate by Order Number</h3>
                <div>
                    <label for="order_no" class="block font-medium mb-2 text-gray-700 dark:text-gray-300">Enter Order Number</label>
                    <input type="text" name="order_no" id="order_no" required
                        class="w-full border border-gray-300 rounded px-3 py-2 text-gray-900 dark:bg-gray-700 dark:text-white" />
                </div>
                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded transition">Generate Report</button>
            </form>

            <!-- Date Range Form -->
            <form action="{{ route('report.inquiryRange') }}" method="GET"
                class="flex-1 bg-white dark:bg-gray-800 p-6 rounded shadow space-y-6 max-w-md mx-auto">
                @csrf
                <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4">Generate by Inquiry Date Range</h3>
                <div>
                    <label for="start_date" class="block font-medium mb-2 text-gray-700 dark:text-gray-300">Start Date</label>
                    <input type="date" name="start_date" id="start_date" required
                        class="w-full border border-gray-300 rounded px-3 py-2 text-gray-900 dark:bg-gray-700 dark:text-white"
                        value="{{ request('start_date') }}" />
                </div>
                <div>
                    <label for="end_date" class="block font-medium mb-2 text-gray-700 dark:text-gray-300">End Date</label>
                    <input type="date" name="end_date" id="end_date" required
                        class="w-full border border-gray-300 rounded px-3 py-2 text-gray-900 dark:bg-gray-700 dark:text-white"
                        value="{{ request('end_date') }}" />
                </div>
                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded transition">Download PDF</button>
            </form>

            <!-- Date Range + Customer Form -->
            <form action="{{ route('reports.customerDecision') }}" method="GET"
                class="flex-1 bg-white dark:bg-gray-800 p-6 rounded shadow space-y-6 max-w-md mx-auto">
                @csrf
                <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4">Date Range + Customer</h3>
                <div>
                    <label for="start_date_cd" class="block font-medium mb-2 text-gray-700 dark:text-gray-300">Start Date</label>
                    <input type="date" id="start_date_cd" name="start_date" required
                        class="w-full border border-gray-300 rounded px-3 py-2 text-gray-900 dark:bg-gray-700 dark:text-white"
                        value="{{ request('start_date') }}" />
                </div>
                <div>
                    <label for="end_date_cd" class="block font-medium mb-2 text-gray-700 dark:text-gray-300">End Date</label>
                    <input type="date" id="end_date_cd" name="end_date" required
                        class="w-full border border-gray-300 rounded px-3 py-2 text-gray-900 dark:bg-gray-700 dark:text-white"
                        value="{{ request('end_date') }}" />
                </div>
                <div>
                    <label for="customer" class="block font-medium mb-2 text-gray-700 dark:text-gray-300">Customer (Optional)</label>
                    <select id="customer" name="customer"
                        class="w-full border border-gray-300 rounded px-3 py-2 text-gray-900 dark:bg-gray-700 dark:text-white">
                        <option value="">All Customers</option>
                        @foreach ($customers as $customer)
                            <option value="{{ $customer }}" {{ request('customer') == $customer ? 'selected' : '' }}>
                                {{ $customer }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded transition">Download PDF</button>
            </form>
        </div>
    </div>
</div>
