<div class="flex h-full w-full">
    <div class="flex-1 overflow-y-auto">
        <div class="py-4">
            <div class="max-w-7xl mx-auto sm:px-2">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 text-gray-900 dark:text-gray-100">

                        @if (session('success'))
                            <div
                                class="mb-4 p-4 text-green-800 bg-green-100 border border-green-300 rounded-md dark:text-green-200 dark:bg-green-900 dark:border-green-800">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div
                                class="mb-4 p-4 text-red-800 bg-red-100 border border-red-300 rounded-md dark:text-red-200 dark:bg-red-900 dark:border-red-800">
                                {{ session('error') }}
                            </div>
                        @endif

                        <!-- Filter Form -->
                        <form id="filterForm2" method="GET" action="" class="mb-6 flex gap-6 items-center">
                            <div class="flex items-center gap-4">
                                <div class="relative inline-block text-left w-48">
                                    <label for="orderDropdown"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Order
                                        No</label>
                                    <div>
                                        <button type="button" id="orderDropdown"
                                            class="inline-flex w-full justify-between rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-gray-300 hover:bg-gray-50 h-10 dark:bg-gray-700 dark:text-white"
                                            onclick="toggleOrderDropdown()" aria-haspopup="listbox"
                                            aria-expanded="false">
                                            <span id="selectedOrderNo">Select Order No</span>
                                            <svg class="ml-2 h-5 w-5 text-gray-400" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 10.94l3.71-3.71a.75.75 0 1 1 1.06 1.06l-4.24 4.24a.75.75 0 0 1-1.06 0L5.25 8.29a.75.75 0 0 1-.02-1.08z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>

                                    <div id="orderDropdownMenu"
                                        class="hidden absolute z-10 mt-2 w-full rounded-md bg-white shadow-lg ring-1 ring-black/5 dark:bg-gray-700 max-h-48 overflow-y-auto">
                                        <!-- Search box -->
                                        <div class="p-2 sticky top-0 bg-white dark:bg-gray-700 z-10">
                                            <input type="text" id="orderSearchInput" placeholder="Search order no..."
                                                class="w-full px-2 py-1 text-sm border rounded-md dark:bg-gray-600 dark:text-white dark:placeholder-gray-300"
                                                onkeyup="filterOrders()" />
                                        </div>

                                        <div class="py-1" role="listbox" tabindex="-1"
                                            aria-labelledby="orderDropdown">
                                            <!-- Replace these options with your actual order numbers -->
                                            <button type="button"
                                                class="order-option w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600"
                                                onclick="selectOrder('')">Select Order No</button>
                                            <button type="button"
                                                class="order-option w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600"
                                                onclick="selectOrder('ORD001')">ORD001</button>
                                            <button type="button"
                                                class="order-option w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600"
                                                onclick="selectOrder('ORD002')">ORD002</button>
                                            <button type="button"
                                                class="order-option w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600"
                                                onclick="selectOrder('ORD003')">ORD003</button>
                                        </div>
                                    </div>

                                    <input type="hidden" name="order_no" id="orderInput" value="">
                                </div>
                            </div>

                            <button type="submit"
                                class="mt-4 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                                Apply Filters
                            </button>

                            <button type="button" id="clearFiltersBtn"
                                class="mt-4 bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-200 px-4 py-2 rounded hover:bg-gray-300"
                                onclick="clearFilters()">
                                Clear Filters
                            </button>

                        </form>


                        <div class="flex justify-between items-center mb-6">
                            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Sample Preperation R & D
                                Records
                            </h1>
                        </div>

                        <div class="overflow-x-auto bg-white dark:bg-gray-900 shadow rounded-lg">
                            <table class="min-w-full table-fixed text-sm divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-100 dark:bg-gray-700">
                                    <tr>
                                        <th
                                            class="px-4 py-3 w-10 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">
                                            Oder No</th>
                                        <th
                                            class="px-4 py-3 w-10 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">
                                            customer requested date</th>
                                        <th
                                            class="px-4 py-3 w-10 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">
                                            development plan date</th>
                                        <th
                                            class="px-4 py-3 w-32 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">
                                            COLOUR MATCH SENT</th>
                                        <th
                                            class="px-4 py-3 w-32 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">
                                            COLOUR MATCH RECEIVE DATE</th>
                                        <th
                                            class="px-4 py-3 w-32 text-center text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">
                                            YARN ORDERED DATE</th>
                                        <th
                                            class="px-4 py-3 w-32 text-center text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">
                                            YARN ORDERED PO NUMBER</th>
                                        <th
                                            class="px-4 py-3 w-32 text-center text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">
                                            Shade</th>
                                        <th
                                            class="px-4 py-3 w-60 text-center text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">
                                            tkt</th>
                                        <th
                                            class="px-4 py-3 text-center text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">
                                            Yarn Suppyler </th>
                                        <th
                                            class="px-4 py-3 text-center text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">
                                            Yarn receive date</th>
                                        <th
                                            class="px-4 py-3 w-10 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">
                                            production deadline</th>
                                        <th
                                            class="px-4 py-3 w-10 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">
                                            Send oder to production status</th>
                                        <th
                                            class="px-4 py-3 w-10 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">
                                            sample complete status</th>
                                        <th
                                            class="px-4 py-3 text-center text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">
                                            Reference No</th>
                                        <th
                                            class="px-4 py-3 w-10 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">
                                            Sample delivered date</th>
                                        <th
                                            class="px-4 py-3 w-10 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">
                                            customer accepted or not</th>
                                        <th
                                            class="px-4 py-3 w-10 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">
                                            Special Note</th>
                                        <th
                                            class="px-4 py-3 text-center text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">
                                            Action</th>

                                    </tr>
                                </thead>
                                <tbody id="serviceRecords"
                                    class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    <tr>
                                        <td class="px-4 py-4 w-10">001</td>
                                        <td class="px-4 py-4 w-40">2025-05-05</td>
                                        <td class="px-4 py-4 w-40">2025-05-05</td>
                                        <td class="px-4 py-4 w-40">2025-05-05</td>
                                        <td class="px-4 py-4 w-40">2025-05-05</td>
                                        <td class="px-4 py-4 w-40">2025-05-05</td>
                                        <td class="px-4 py-4 w-40">PO001</td>
                                        <td class="px-4 py-4 w-40">W45735</td>
                                        <td class="px-4 py-4 w-40 text-center">T 160</td>
                                        <td class="px-4 py-4 w-40 text-center">AE</td>
                                        <td class="px-4 py-4 w-40 text-center">2025-05-05</td>
                                        <td class="px-4 py-4 w-40">2025-05-05</td>
                                        <td class="px-4 py-4 text-center">Done</td>
                                        <td class="px-4 py-4 text-center">Production done</td>
                                        <td class="px-4 py-4 w-40 text-center">STKE/NR22/MAY 24</td>
                                        <td class="px-4 py-4 text-center">2025-06-05</td>
                                        <td class="px-4 py-4 text-center">Customer Accepted</td>
                                        <td class="px-4 py-4 w-40">abc</td>
                                        <td class="px-4 py-4">
                                            <div class="flex w-50">
                                                <button
                                                    class="bg-green-600 h-12 mr-4 hover:bg-green-700 text-white px-3 py-1 rounded text-sm">
                                                    Edit
                                                </button>
                                                <button
                                                    class="bg-blue-600 h-12 mr-4 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm">
                                                    save
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    function toggleOrderDropdown() {
        const menu = document.getElementById('orderDropdownMenu');
        const btn = document.getElementById('orderDropdown');
        const expanded = btn.getAttribute('aria-expanded') === 'true';

        menu.classList.toggle('hidden');
        btn.setAttribute('aria-expanded', !expanded);
    }

    function selectOrder(orderNo) {
        document.getElementById('selectedOrderNo').innerText = orderNo || 'Select Order No';
        document.getElementById('orderInput').value = orderNo;
        document.getElementById('orderDropdownMenu').classList.add('hidden');
        document.getElementById('orderDropdown').setAttribute('aria-expanded', false);
    }

    function filterOrders() {
        const input = document.getElementById('orderSearchInput').value.toLowerCase();
        const items = document.querySelectorAll('.order-option');

        items.forEach(item => {
            const text = item.textContent.toLowerCase();
            item.style.display = text.includes(input) ? 'block' : 'none';
        });
    }

    function clearFilters() {

        document.getElementById('selectedOrderNo').innerText = 'Select Order No';
        document.getElementById('orderInput').value = '';
        document.getElementById('orderSearchInput').value = '';

        filterOrders();

    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        const orderBtn = document.getElementById('orderDropdown');
        const orderMenu = document.getElementById('orderDropdownMenu');

        if (!orderBtn.contains(e.target) && !orderMenu.contains(e.target)) {
            orderMenu.classList.add('hidden');
            orderBtn.setAttribute('aria-expanded', false);
        }
    });
</script>
