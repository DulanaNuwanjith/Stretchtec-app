<head>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<div class="flex h-full w-full">
    @extends('layouts.reports')

    @section('content')
        <div class="flex h-full w-full bg-white">
            <div class="flex-1 p-8">
                <!-- Header -->
                <div class="flex justify-center items-center mb-16">
                    <h2 class="text-3xl font-bold text-gray-800 dark:text-white">Sample Reports Generator</h2>
                </div>

                <!-- Flex container for all forms -->
                <div class="flex flex-wrap justify-center items-stretch gap-6 max-w-7xl mx-auto pb-32">

                    <!-- Form Wrapper -->
                    <div class="flex-1 min-w-[300px] max-w-sm flex">
                        <form action="{{ route('report.order') }}" method="GET"
                            class="flex flex-col bg-white dark:bg-gray-800 p-6 rounded shadow flex-1">
                            @csrf
                            <div class="flex-grow space-y-6">
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Sample Order Report</h3>
                                <h3 class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                    Produce a complete, detailed report containing all relevant data associated with the
                                    specified order number.
                                </h3>
                                <div>
                                    <label for="order_no" class="block font-medium mb-2 text-gray-700 dark:text-gray-300">
                                        Enter Order Number
                                    </label>
                                    <input type="text" name="order_no" id="order_no" required
                                        class="w-full border border-gray-300 rounded px-3 py-2 text-gray-900 dark:bg-gray-700 dark:text-white" />
                                </div>
                            </div>
                            <button type="submit"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded transition">
                                Download PDF
                            </button>
                        </form>
                    </div>

                    <div class="flex-1 min-w-[300px] max-w-sm flex">
                        <form action="{{ route('report.inquiryRange') }}" method="GET"
                            class="flex flex-col bg-white dark:bg-gray-800 p-6 rounded shadow flex-1">
                            @csrf
                            <div class="flex-grow space-y-6">
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Sample Order Delivery
                                    Report</h3>
                                <h3 class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                    Produce a complete, detailed report of all inquiries within the selected date range,
                                    showing both delivered and undelivered orders.
                                </h3>
                                <div>
                                    <label for="start_date"
                                        class="block font-medium mb-2 text-gray-700 dark:text-gray-300">Start Date</label>
                                    <input type="date" name="start_date" id="start_date" required
                                        class="w-full border border-gray-300 rounded px-3 py-2 text-gray-900 dark:bg-gray-700 dark:text-white"
                                        value="{{ request('start_date') }}" />
                                </div>
                                <div>
                                    <label for="end_date"
                                        class="block font-medium mb-2 text-gray-700 dark:text-gray-300">End Date</label>
                                    <input type="date" name="end_date" id="end_date" required
                                        class="w-full border border-gray-300 rounded px-3 py-2 text-gray-900 dark:bg-gray-700 dark:text-white"
                                        value="{{ request('end_date') }}" />
                                </div>
                            </div>
                            <button type="submit"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded transition">
                                Download PDF
                            </button>
                        </form>
                    </div>

                    <div class="flex-1 min-w-[300px] max-w-sm flex">
                        <form action="{{ route('reports.customerDecision') }}" method="GET"
                            class="flex flex-col bg-white dark:bg-gray-800 p-6 rounded shadow flex-1">
                            @csrf
                            <div class="flex-grow space-y-6">
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Customer Decision Report
                                </h3>
                                <h3 class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                    Produce a complete, detailed report of all inquiries within the selected date range,
                                    including the recorded customer decisions for each order.
                                </h3>
                                <div>
                                    <label for="start_date_cd"
                                        class="block font-medium mb-2 text-gray-700 dark:text-gray-300">Start Date</label>
                                    <input type="date" id="start_date_cd" name="start_date" required
                                        class="w-full border border-gray-300 rounded px-3 py-2 text-gray-900 dark:bg-gray-700 dark:text-white"
                                        value="{{ request('start_date') }}" />
                                </div>
                                <div>
                                    <label for="end_date_cd"
                                        class="block font-medium mb-2 text-gray-700 dark:text-gray-300">End Date</label>
                                    <input type="date" id="end_date_cd" name="end_date" required
                                        class="w-full border border-gray-300 rounded px-3 py-2 text-gray-900 dark:bg-gray-700 dark:text-white"
                                        value="{{ request('end_date') }}" />
                                </div>
                                <div>
                                    <label for="customer" class="block font-medium mb-2 text-gray-700 dark:text-gray-300">
                                        Customer (Optional)
                                    </label>

                                    <div class="relative inline-block text-left w-full">
                                        <button type="button"
                                            class="dropdown-btn inline-flex w-full justify-between rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-gray-300 hover:bg-gray-50"
                                            onclick="toggleDropdownDispatch(this, 'customer')">
                                            <span class="selected-customer">All Customers</span>
                                            <svg class="ml-2 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 10.94l3.71-3.71a.75.75 0 1 1 1.06 1.06l-4.24 4.24a.75.75 0 0 1-1.06 0L5.25 8.29a.75.75 0 0 1-.02-1.08z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </button>

                                        <div
                                            class="dropdown-menu-customer hidden absolute z-10 mt-2 w-full rounded-md bg-white shadow-lg ring-1 ring-black/5 max-h-48 overflow-y-auto">
                                            <div class="p-2 sticky top-0 bg-white z-10">
                                                <input type="text" placeholder="Search customer..."
                                                    class="w-full px-2 py-1 text-sm border rounded-md"
                                                    oninput="filterDropdownOptionsDispatch(this)" />
                                            </div>

                                            <div class="py-1" role="listbox" tabindex="-1">
                                                <button type="button"
                                                    class="dropdown-option w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                                    onclick="selectDropdownOptionDispatch(this, '', 'customer')">
                                                    All Customers
                                                </button>
                                                @foreach ($customers as $customer)
                                                    <button type="button"
                                                        class="dropdown-option w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                                        onclick="selectDropdownOptionDispatch(this, '{{ $customer }}', 'customer')">
                                                        {{ $customer }}
                                                    </button>
                                                @endforeach
                                            </div>
                                        </div>

                                        <input type="hidden" name="customer" class="input-customer" value="">
                                    </div>
                                </div>
                            </div>
                            <button type="submit"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded transition mt-5">
                                Download PDF
                            </button>
                        </form>
                    </div>

                    <!-- Second Row: Next 3 Forms -->
                    <div class="flex-1 min-w-[300px] max-w-sm flex">
                        <form action="{{ route('reports.yarnSupplierSpending') }}" method="GET"
                            class="flex flex-col bg-white dark:bg-gray-800 p-6 rounded shadow flex-1">
                            @csrf
                            <div class="flex-grow space-y-6">
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Yarn Supplier Spending
                                    Report</h3>
                                <h3 class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                    Generate a report showing total spending on yarn, grouped by supplier, for the selected
                                    date range.
                                </h3>
                                <div>
                                    <label for="start_date_ys"
                                        class="block font-medium mb-2 text-gray-700 dark:text-gray-300">Start Date</label>
                                    <input type="date" id="start_date_ys" name="start_date" required
                                        class="w-full border border-gray-300 rounded px-3 py-2 text-gray-900 dark:bg-gray-700 dark:text-white" />
                                </div>
                                <div>
                                    <label for="end_date_ys"
                                        class="block font-medium mb-2 text-gray-700 dark:text-gray-300">End Date</label>
                                    <input type="date" id="end_date_ys" name="end_date" required
                                        class="w-full border border-gray-300 rounded px-3 py-2 text-gray-900 dark:bg-gray-700 dark:text-white" />
                                </div>
                            </div>
                            <button type="submit"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded transition">
                                Download PDF
                            </button>
                        </form>
                    </div>

                    <div class="flex-1 min-w-[300px] max-w-sm flex">
                        <form action="{{ route('reports.coordinatorPdf') }}" method="GET"
                            class="flex flex-col bg-white dark:bg-gray-800 p-6 rounded shadow flex-1">
                            @csrf
                            <div class="flex-grow space-y-6">
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Coordinator Order Report
                                </h3>
                                <h3 class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                    Generate a report showing all orders grouped by customer coordinator within the selected
                                    date range.
                                </h3>
                                <div>
                                    <label for="start_date_co"
                                        class="block font-medium mb-2 text-gray-700 dark:text-gray-300">Start Date</label>
                                    <input type="date" id="start_date_co" name="start_date" required
                                        class="w-full border border-gray-300 rounded px-3 py-2 text-gray-900 dark:bg-gray-700 dark:text-white" />
                                </div>
                                <div>
                                    <label for="end_date_co"
                                        class="block font-medium mb-2 text-gray-700 dark:text-gray-300">End Date</label>
                                    <input type="date" id="end_date_co" name="end_date" required
                                        class="w-full border border-gray-300 rounded px-3 py-2 text-gray-900 dark:bg-gray-700 dark:text-white" />
                                </div>
                            </div>
                            <button type="submit"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded transition mt-5">
                                Download PDF
                            </button>
                        </form>
                    </div>

                    <div class="flex-1 min-w-[300px] max-w-sm flex">
                        <form action="{{ route('reports.reference_delivery') }}" method="GET"
                            class="flex flex-col bg-white dark:bg-gray-800 p-6 rounded shadow flex-1">
                            @csrf
                            <div class="flex-grow space-y-6">
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Reference Delivery
                                    Report</h3>
                                <h3 class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                    Generate a report of all references delivered between the selected dates.
                                </h3>
                                <div>
                                    <label for="start_date_ref"
                                        class="block font-medium mb-2 text-gray-700 dark:text-gray-300">Start Date</label>
                                    <input type="date" id="start_date_ref" name="start_date" required
                                        class="w-full border border-gray-300 rounded px-3 py-2 text-gray-900 dark:bg-gray-700 dark:text-white"
                                        value="{{ request('start_date') }}" />
                                </div>
                                <div>
                                    <label for="end_date_ref"
                                        class="block font-medium mb-2 text-gray-700 dark:text-gray-300">End Date</label>
                                    <input type="date" id="end_date_ref" name="end_date" required
                                        class="w-full border border-gray-300 rounded px-3 py-2 text-gray-900 dark:bg-gray-700 dark:text-white"
                                        value="{{ request('end_date') }}" />
                                </div>
                            </div>
                            <button type="submit"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded transition">
                                Download PDF
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleDropdownDispatch(button, type) {
            const dropdownMenu = button.nextElementSibling;
            document.querySelectorAll('.dropdown-menu-' + type).forEach(menu => {
                if (menu !== dropdownMenu) menu.classList.add('hidden');
            });
            dropdownMenu.classList.toggle('hidden');
        }

        function selectDropdownOptionDispatch(button, selectedValue, type) {
            const dropdown = button.closest('.relative');
            dropdown.querySelector('.selected-' + type).innerText = selectedValue;
            dropdown.querySelector('.input-' + type).value = selectedValue;
            dropdown.querySelector('.dropdown-menu-' + type).classList.add('hidden');
        }

        function filterDropdownOptionsDispatch(input) {
            const filter = input.value.toLowerCase();
            const options = input.closest('[class^="dropdown-menu-"]').querySelectorAll('.dropdown-option');
            options.forEach(option => {
                const text = option.textContent.toLowerCase();
                option.style.display = text.includes(filter) ? 'block' : 'none';
            });
        }

        document.addEventListener('click', function(event) {
            document.querySelectorAll('[class^="dropdown-menu-"]').forEach(menu => {
                if (!menu.contains(event.target) && !menu.previousElementSibling.contains(event.target)) {
                    menu.classList.add('hidden');
                }
            });
        });
    </script>
@endsection
