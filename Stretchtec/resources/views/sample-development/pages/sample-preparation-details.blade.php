<div class="flex h-full w-full">
    <div class="flex-1 overflow-y-hidden mb-20">
        <div class="py-4 mb-10">
            <div class="w-full px-6 lg:px-2">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 text-gray-900 dark:text-gray-100  mb-20">

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
                        <form id="filterForm2" method="GET" action="" class="mb-6">
                            <div class="flex gap-4 items-center flex-wrap">
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

                                <div class="relative inline-block text-left w-48">
                                    <label for="poDropdown"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">PO
                                        No</label>
                                    <div>
                                        <button type="button" id="poDropdown"
                                            class="inline-flex w-full justify-between rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-gray-300 hover:bg-gray-50 h-10 dark:bg-gray-700 dark:text-white"
                                            onclick="togglePODropdown()" aria-haspopup="listbox" aria-expanded="false">
                                            <span id="selectedPONo">Select PO No</span>
                                            <svg class="ml-2 h-5 w-5 text-gray-400" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 10.94l3.71-3.71a.75.75 0 1 1 1.06 1.06l-4.24 4.24a.75.75 0 0 1-1.06 0L5.25 8.29a.75.75 0 0 1-.02-1.08z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>

                                    <div id="poDropdownMenu"
                                        class="hidden absolute z-10 mt-2 w-full rounded-md bg-white shadow-lg ring-1 ring-black/5 dark:bg-gray-700 max-h-48 overflow-y-auto">
                                        <!-- Search box -->
                                        <div class="p-2 sticky top-0 bg-white dark:bg-gray-700 z-10">
                                            <input type="text" id="poSearchInput" placeholder="Search PO no..."
                                                class="w-full px-2 py-1 text-sm border rounded-md dark:bg-gray-600 dark:text-white dark:placeholder-gray-300"
                                                onkeyup="filterPOs()" />
                                        </div>

                                        <div class="py-1" role="listbox" tabindex="-1" aria-labelledby="poDropdown">
                                            <button type="button"
                                                class="po-option w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600"
                                                onclick="selectPO('')">Select PO No</button>
                                            <button type="button"
                                                class="po-option w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600"
                                                onclick="selectPO('PO001')">PO001</button>
                                            <button type="button"
                                                class="po-option w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600"
                                                onclick="selectPO('PO002')">PO002</button>
                                            <button type="button"
                                                class="po-option w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600"
                                                onclick="selectPO('PO003')">PO003</button>
                                        </div>
                                    </div>

                                    <input type="hidden" name="po_no" id="poInput" value="">
                                </div>

                                <div class="relative inline-block text-left w-48">
                                    <label for="shadeDropdown"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Shade</label>
                                    <button type="button" id="shadeDropdown"
                                        class="inline-flex w-full justify-between rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-gray-300 hover:bg-gray-50 h-10 dark:bg-gray-700 dark:text-white"
                                        onclick="toggleShadeDropdown()" aria-haspopup="listbox"
                                        aria-expanded="false">
                                        <span id="selectedShade">Select Shade</span>
                                        <svg class="ml-2 h-5 w-5 text-gray-400" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 10.94l3.71-3.71a.75.75 0 1 1 1.06 1.06l-4.24 4.24a.75.75 0 0 1-1.06 0L5.25 8.29a.75.75 0 0 1-.02-1.08z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                    <div id="shadeDropdownMenu"
                                        class="hidden absolute z-10 mt-2 w-full rounded-md bg-white shadow-lg ring-1 ring-black/5 dark:bg-gray-700 max-h-48 overflow-y-auto">
                                        <div class="p-2 sticky top-0 bg-white dark:bg-gray-700 z-10">
                                            <input type="text" id="shadeSearchInput" placeholder="Search shade..."
                                                class="w-full px-2 py-1 text-sm border rounded-md dark:bg-gray-600 dark:text-white dark:placeholder-gray-300"
                                                onkeyup="filterShades()" />
                                        </div>
                                        <div class="py-1" role="listbox" tabindex="-1"
                                            aria-labelledby="shadeDropdown">
                                            <button type="button"
                                                class="shade-option w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600"
                                                onclick="selectShade('SHADE001')">SHADE001</button>
                                            <button type="button"
                                                class="shade-option w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600"
                                                onclick="selectShade('SHADE002')">SHADE002</button>
                                        </div>
                                    </div>
                                    <input type="hidden" name="shade" id="shadeInput" value="">
                                </div>

                                <div class="relative inline-block text-left w-48">
                                    <label for="refDropdown"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Reference
                                        No</label>
                                    <button type="button" id="refDropdown"
                                        class="inline-flex w-full justify-between rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-gray-300 hover:bg-gray-50 h-10 dark:bg-gray-700 dark:text-white"
                                        onclick="toggleRefDropdown()" aria-haspopup="listbox" aria-expanded="false">
                                        <span id="selectedRef">Select Reference No</span>
                                        <svg class="ml-2 h-5 w-5 text-gray-400" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 10.94l3.71-3.71a.75.75 0 1 1 1.06 1.06l-4.24 4.24a.75.75 0 0 1-1.06 0L5.25 8.29a.75.75 0 0 1-.02-1.08z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                    <div id="refDropdownMenu"
                                        class="hidden absolute z-10 mt-2 w-full rounded-md bg-white shadow-lg ring-1 ring-black/5 dark:bg-gray-700 max-h-48 overflow-y-auto">
                                        <div class="p-2 sticky top-0 bg-white dark:bg-gray-700 z-10">
                                            <input type="text" id="refSearchInput"
                                                placeholder="Search reference no..."
                                                class="w-full px-2 py-1 text-sm border rounded-md dark:bg-gray-600 dark:text-white dark:placeholder-gray-300"
                                                onkeyup="filterRefs()" />
                                        </div>
                                        <div class="py-1" role="listbox" tabindex="-1"
                                            aria-labelledby="refDropdown">
                                            <button type="button"
                                                class="ref-option w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600"
                                                onclick="selectRef('REF001')">REF001</button>
                                            <button type="button"
                                                class="ref-option w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600"
                                                onclick="selectRef('REF002')">REF002</button>
                                        </div>
                                    </div>
                                    <input type="hidden" name="reference_no" id="refInput" value="">
                                </div>
                            </div>

                            <!-- Second row: Date inputs and buttons -->
                            <div class="flex flex-wrap gap-6 items-end mt-4">
                                <div>
                                    <label for="customerRequestedDate"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Customer Requested Date
                                    </label>
                                    <input type="date" id="customerRequestedDate" name="customer_requested_date"
                                        value="{{ request('customer_requested_date') }}"
                                        class="w-48 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm" />
                                </div>

                                <div>
                                    <label for="developmentPlanDate"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Development Plan Date
                                    </label>
                                    <input type="date" id="developmentPlanDate" name="development_plan_date"
                                        value="{{ request('development_plan_date') }}"
                                        class="w-48 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm" />
                                </div>

                                <button type="submit"
                                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                                    Apply Filters
                                </button>

                                <button type="button" id="clearFiltersBtn"
                                    class="bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-200 px-4 py-2 rounded hover:bg-gray-300"
                                    onclick="clearFilters()">
                                    Clear Filters
                                </button>
                            </div>
                        </form>


                        <div class="flex justify-between items-center mb-6">
                            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Sample Preperation R & D
                                Records
                            </h1>
                        </div>

                        <div class="overflow-x-auto bg-white dark:bg-gray-900 shadow rounded-lg">
                            <table class="table-fixed w-full text-sm divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-100 dark:bg-gray-700 text-left">
                                    <tr>
                                        <th
                                            class="px-4 py-3 w-20 text-xs font-medium uppercase text-gray-600 dark:text-gray-300 whitespace-normal break-words">
                                            Order No</th>
                                        <th
                                            class="px-4 py-3 w-40 text-xs font-medium uppercase text-gray-600 dark:text-gray-300 whitespace-normal break-words">
                                            Customer Requested Date</th>
                                        <th
                                            class="px-4 py-3 w-40 text-xs font-medium uppercase text-gray-600 dark:text-gray-300 whitespace-normal break-words">
                                            Development Plan Date</th>
                                        <th
                                            class="px-4 py-3 w-40 text-center text-xs font-medium uppercase text-gray-600 dark:text-gray-300 whitespace-normal break-words">
                                            Colour Match Sent Date</th>
                                        <th
                                            class="px-4 py-3 w-40 text-center text-xs font-medium uppercase text-gray-600 dark:text-gray-300 whitespace-normal break-words">
                                            Colour Match Receive Date</th>
                                        <th
                                            class="px-4 py-3 w-40 text-center text-xs font-medium uppercase text-gray-600 dark:text-gray-300 whitespace-normal break-words">
                                            Yarn Ordered Date</th>
                                        <th
                                            class="px-4 py-3 w-40 text-xs font-medium uppercase text-gray-600 dark:text-gray-300 whitespace-normal break-words">
                                            Yarn Ordered PO Number</th>
                                        <th
                                            class="px-4 py-3 w-40 text-xs font-medium uppercase text-gray-600 dark:text-gray-300 whitespace-normal break-words">
                                            Shade</th>
                                        <th
                                            class="px-4 py-3 w-40 text-xs font-medium uppercase text-gray-600 dark:text-gray-300 whitespace-normal break-words">
                                            Yarn ordered quantity</th>
                                        <th
                                            class="px-4 py-3 w-40 text-xs font-medium uppercase text-gray-600 dark:text-gray-300 whitespace-normal break-words">
                                            Tkt</th>
                                        <th
                                            class="px-4 py-3 w-40 text-xs font-medium uppercase text-gray-600 dark:text-gray-300 whitespace-normal break-words">
                                            Yarn Supplier</th>
                                        <th
                                            class="px-4 py-3 w-40 text-center text-xs font-medium uppercase text-gray-600 dark:text-gray-300 whitespace-normal break-words">
                                            Yarn Receive Date</th>
                                        <th
                                            class="px-4 py-3 w-40 text-xs font-medium uppercase text-gray-600 dark:text-gray-300 whitespace-normal break-words">
                                            Production Deadline</th>
                                        <th
                                            class="px-4 py-3 w-40 text-center text-xs font-medium uppercase text-gray-600 dark:text-gray-300 whitespace-normal break-words">
                                            Send Order To Production Status</th>
                                        <th
                                            class="px-4 py-3 w-32 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                            Production Status</th>
                                        <th
                                            class="px-4 py-3 w-32 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                            Production Output</th>
                                        <th
                                            class="px-4 py-3 w-32 text-xs font-medium uppercase text-gray-600 dark:text-gray-300 text-center whitespace-normal break-words">
                                            Action</th>
                                    </tr>
                                </thead>
                                <tbody id="productionRecords"
                                    class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700 text-left">

                                    <tr id="prodRow1">
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">001</span>
                                            <input
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="001" />
                                        </td>
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">2025-06-05</span>
                                            <input type="date"
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="2025-06-05" />
                                        </td>
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">2025-06-10</span>
                                            <input type="date"
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="2025-06-10" />
                                        </td>

                                        <td class="py-3 whitespace-normal break-words text-center">
                                            <div class="colour-match-sent mb-4">
                                                <button onclick="toggleColourMatchSent(event, this)" type="button"
                                                    class="delivered-btn bg-gray-300 text-black px-2 py-1 mt-3 rounded hover:bg-gray-400 transition-all duration-200">
                                                    Pending
                                                </button>
                                                <div class="timestamp mt-1 text-xs text-gray-500 dark:text-gray-400">
                                                </div>
                                            </div>
                                        </td>

                                        <td class="py-3 whitespace-normal break-words text-center">
                                            <div class="colour-match-receive mb-4">
                                                <button onclick="toggleColourMatchReceive(event, this)" type="button"
                                                    class="receive-btn bg-gray-300 text-black px-2 py-1 mt-3 rounded hover:bg-gray-400 transition-all duration-200">
                                                    Pending
                                                </button>
                                                <div
                                                    class="receive-timestamp mt-1 text-xs text-gray-500 dark:text-gray-400">
                                                </div>
                                            </div>
                                        </td>

                                        <td class="py-3 whitespace-normal break-words text-center">
                                            <div class="yarn-ordered-item mb-4">
                                                <button onclick="toggleYarnOrdered(event, this)" type="button"
                                                    class="yarn-ordered-btn bg-gray-300 text-black px-2 py-1 mt-3 rounded hover:bg-gray-400 transition-all duration-200">
                                                    Pending
                                                </button>
                                                <div
                                                    class="yarn-timestamp mt-1 text-xs text-gray-500 dark:text-gray-400">
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">PO12345</span>
                                            <input
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="PO12345" />
                                        </td>
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">Dark Blue</span>
                                            <input
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="Dark Blue" />
                                        </td>
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">5000m Corn</span>
                                            <input
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="5000m Corn" />
                                        </td>
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">30</span>
                                            <input type="number"
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="30" />
                                        </td>
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">Supplier A</span>
                                            <input
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="Supplier A" />
                                        </td>
                                        <td class="py-3 whitespace-normal break-words text-center">
                                            <div class="yarn-receive-item mb-4">
                                                <button onclick="toggleYarnReceived(event, this)" type="button"
                                                    class="yarn-receive-btn bg-gray-300 text-black px-2 py-1 mt-3 rounded hover:bg-gray-400 transition-all duration-200">
                                                    Pending
                                                </button>
                                                <div
                                                    class="yarn-receive-timestamp mt-1 text-xs text-gray-500 dark:text-gray-400">
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">2025-07-01</span>
                                            <input type="date"
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="2025-07-01" />
                                        </td>
                                        <td class="py-3 whitespace-normal break-words text-center">
                                            <div class="send-production-item mb-4">
                                                <button onclick="toggleSendProduction(event, this)" type="button"
                                                    class="send-production-btn bg-gray-300 text-black px-2 py-1 mt-3 rounded hover:bg-gray-400 transition-all duration-200">
                                                    Pending
                                                </button>
                                                <div
                                                    class="send-production-timestamp mt-1 text-xs text-gray-500 dark:text-gray-400">
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">Production complete</span>
                                            <input
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="Production complete" />
                                        </td>
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">5 yard</span>
                                            <input
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="5 yard" />
                                        </td>
                                        <td class="px-4 py-3 text-center whitespace-normal break-words">
                                            <div class="flex justify-center space-x-2">
                                                <button
                                                    class="bg-green-600 h-10 px-3 py-1 rounded text-white text-sm hover:bg-green-700"
                                                    onclick="editRow('prodRow1')">Edit</button>
                                                <button
                                                    class="bg-blue-600 h-10 px-3 py-1 rounded text-white text-sm hover:bg-blue-700 hidden"
                                                    onclick="saveRow('prodRow1')">Save</button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr id="prodRow1">
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">001</span>
                                            <input
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="001" />
                                        </td>
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">2025-06-05</span>
                                            <input type="date"
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="2025-06-05" />
                                        </td>
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">2025-06-10</span>
                                            <input type="date"
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="2025-06-10" />
                                        </td>

                                        <td class="py-3 whitespace-normal break-words text-center">
                                            <div class="colour-match-sent mb-4">
                                                <button onclick="toggleColourMatchSent(event, this)" type="button"
                                                    class="delivered-btn bg-gray-300 text-black px-2 py-1 mt-3 rounded hover:bg-gray-400 transition-all duration-200">
                                                    Pending
                                                </button>
                                                <div class="timestamp mt-1 text-xs text-gray-500 dark:text-gray-400">
                                                </div>
                                            </div>
                                        </td>

                                        <td class="py-3 whitespace-normal break-words text-center">
                                            <div class="colour-match-receive mb-4">
                                                <button onclick="toggleColourMatchReceive(event, this)" type="button"
                                                    class="receive-btn bg-gray-300 text-black px-2 py-1 mt-3 rounded hover:bg-gray-400 transition-all duration-200">
                                                    Pending
                                                </button>
                                                <div
                                                    class="receive-timestamp mt-1 text-xs text-gray-500 dark:text-gray-400">
                                                </div>
                                            </div>
                                        </td>

                                        <td class="py-3 whitespace-normal break-words text-center">
                                            <div class="yarn-ordered-item mb-4">
                                                <button onclick="toggleYarnOrdered(event, this)" type="button"
                                                    class="yarn-ordered-btn bg-gray-300 text-black px-2 py-1 mt-3 rounded hover:bg-gray-400 transition-all duration-200">
                                                    Pending
                                                </button>
                                                <div
                                                    class="yarn-timestamp mt-1 text-xs text-gray-500 dark:text-gray-400">
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">PO12345</span>
                                            <input
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="PO12345" />
                                        </td>
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">Dark Blue</span>
                                            <input
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="Dark Blue" />
                                        </td>
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">5000m Corn</span>
                                            <input
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="5000m Corn" />
                                        </td>
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">30</span>
                                            <input type="number"
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="30" />
                                        </td>
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">Supplier A</span>
                                            <input
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="Supplier A" />
                                        </td>
                                        <td class="py-3 whitespace-normal break-words text-center">
                                            <div class="yarn-receive-item mb-4">
                                                <button onclick="toggleYarnReceived(event, this)" type="button"
                                                    class="yarn-receive-btn bg-gray-300 text-black px-2 py-1 mt-3 rounded hover:bg-gray-400 transition-all duration-200">
                                                    Pending
                                                </button>
                                                <div
                                                    class="yarn-receive-timestamp mt-1 text-xs text-gray-500 dark:text-gray-400">
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">2025-07-01</span>
                                            <input type="date"
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="2025-07-01" />
                                        </td>
                                        <td class="py-3 whitespace-normal break-words text-center">
                                            <div class="send-production-item mb-4">
                                                <button onclick="toggleSendProduction(event, this)" type="button"
                                                    class="send-production-btn bg-gray-300 text-black px-2 py-1 mt-3 rounded hover:bg-gray-400 transition-all duration-200">
                                                    Pending
                                                </button>
                                                <div
                                                    class="send-production-timestamp mt-1 text-xs text-gray-500 dark:text-gray-400">
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">Production complete</span>
                                            <input
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="Production complete" />
                                        </td>
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">5 yard</span>
                                            <input
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="5 yard" />
                                        </td>
                                        <td class="px-4 py-3 text-center whitespace-normal break-words">
                                            <div class="flex justify-center space-x-2">
                                                <button
                                                    class="bg-green-600 h-10 px-3 py-1 rounded text-white text-sm hover:bg-green-700"
                                                    onclick="editRow('prodRow1')">Edit</button>
                                                <button
                                                    class="bg-blue-600 h-10 px-3 py-1 rounded text-white text-sm hover:bg-blue-700 hidden"
                                                    onclick="saveRow('prodRow1')">Save</button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr id="prodRow1">
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">001</span>
                                            <input
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="001" />
                                        </td>
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">2025-06-05</span>
                                            <input type="date"
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="2025-06-05" />
                                        </td>
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">2025-06-10</span>
                                            <input type="date"
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="2025-06-10" />
                                        </td>

                                        <td class="py-3 whitespace-normal break-words text-center">
                                            <div class="colour-match-sent mb-4">
                                                <button onclick="toggleColourMatchSent(event, this)" type="button"
                                                    class="delivered-btn bg-gray-300 text-black px-2 py-1 mt-3 rounded hover:bg-gray-400 transition-all duration-200">
                                                    Pending
                                                </button>
                                                <div class="timestamp mt-1 text-xs text-gray-500 dark:text-gray-400">
                                                </div>
                                            </div>
                                        </td>

                                        <td class="py-3 whitespace-normal break-words text-center">
                                            <div class="colour-match-receive mb-4">
                                                <button onclick="toggleColourMatchReceive(event, this)" type="button"
                                                    class="receive-btn bg-gray-300 text-black px-2 py-1 mt-3 rounded hover:bg-gray-400 transition-all duration-200">
                                                    Pending
                                                </button>
                                                <div
                                                    class="receive-timestamp mt-1 text-xs text-gray-500 dark:text-gray-400">
                                                </div>
                                            </div>
                                        </td>

                                        <td class="py-3 whitespace-normal break-words text-center">
                                            <div class="yarn-ordered-item mb-4">
                                                <button onclick="toggleYarnOrdered(event, this)" type="button"
                                                    class="yarn-ordered-btn bg-gray-300 text-black px-2 py-1 mt-3 rounded hover:bg-gray-400 transition-all duration-200">
                                                    Pending
                                                </button>
                                                <div
                                                    class="yarn-timestamp mt-1 text-xs text-gray-500 dark:text-gray-400">
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">PO12345</span>
                                            <input
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="PO12345" />
                                        </td>
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">Dark Blue</span>
                                            <input
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="Dark Blue" />
                                        </td>
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">5000m Corn</span>
                                            <input
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="5000m Corn" />
                                        </td>
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">30</span>
                                            <input type="number"
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="30" />
                                        </td>
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">Supplier A</span>
                                            <input
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="Supplier A" />
                                        </td>
                                        <td class="py-3 whitespace-normal break-words text-center">
                                            <div class="yarn-receive-item mb-4">
                                                <button onclick="toggleYarnReceived(event, this)" type="button"
                                                    class="yarn-receive-btn bg-gray-300 text-black px-2 py-1 mt-3 rounded hover:bg-gray-400 transition-all duration-200">
                                                    Pending
                                                </button>
                                                <div
                                                    class="yarn-receive-timestamp mt-1 text-xs text-gray-500 dark:text-gray-400">
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">2025-07-01</span>
                                            <input type="date"
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="2025-07-01" />
                                        </td>
                                        <td class="py-3 whitespace-normal break-words text-center">
                                            <div class="send-production-item mb-4">
                                                <button onclick="toggleSendProduction(event, this)" type="button"
                                                    class="send-production-btn bg-gray-300 text-black px-2 py-1 mt-3 rounded hover:bg-gray-400 transition-all duration-200">
                                                    Pending
                                                </button>
                                                <div
                                                    class="send-production-timestamp mt-1 text-xs text-gray-500 dark:text-gray-400">
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">Production complete</span>
                                            <input
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="Production complete" />
                                        </td>
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">5 yard</span>
                                            <input
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="5 yard" />
                                        </td>
                                        <td class="px-4 py-3 text-center whitespace-normal break-words">
                                            <div class="flex justify-center space-x-2">
                                                <button
                                                    class="bg-green-600 h-10 px-3 py-1 rounded text-white text-sm hover:bg-green-700"
                                                    onclick="editRow('prodRow1')">Edit</button>
                                                <button
                                                    class="bg-blue-600 h-10 px-3 py-1 rounded text-white text-sm hover:bg-blue-700 hidden"
                                                    onclick="saveRow('prodRow1')">Save</button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr id="prodRow1">
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">001</span>
                                            <input
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="001" />
                                        </td>
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">2025-06-05</span>
                                            <input type="date"
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="2025-06-05" />
                                        </td>
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">2025-06-10</span>
                                            <input type="date"
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="2025-06-10" />
                                        </td>

                                        <td class="py-3 whitespace-normal break-words text-center">
                                            <div class="colour-match-sent mb-4">
                                                <button onclick="toggleColourMatchSent(event, this)" type="button"
                                                    class="delivered-btn bg-gray-300 text-black px-2 py-1 mt-3 rounded hover:bg-gray-400 transition-all duration-200">
                                                    Pending
                                                </button>
                                                <div class="timestamp mt-1 text-xs text-gray-500 dark:text-gray-400">
                                                </div>
                                            </div>
                                        </td>

                                        <td class="py-3 whitespace-normal break-words text-center">
                                            <div class="colour-match-receive mb-4">
                                                <button onclick="toggleColourMatchReceive(event, this)" type="button"
                                                    class="receive-btn bg-gray-300 text-black px-2 py-1 mt-3 rounded hover:bg-gray-400 transition-all duration-200">
                                                    Pending
                                                </button>
                                                <div
                                                    class="receive-timestamp mt-1 text-xs text-gray-500 dark:text-gray-400">
                                                </div>
                                            </div>
                                        </td>

                                        <td class="py-3 whitespace-normal break-words text-center">
                                            <div class="yarn-ordered-item mb-4">
                                                <button onclick="toggleYarnOrdered(event, this)" type="button"
                                                    class="yarn-ordered-btn bg-gray-300 text-black px-2 py-1 mt-3 rounded hover:bg-gray-400 transition-all duration-200">
                                                    Pending
                                                </button>
                                                <div
                                                    class="yarn-timestamp mt-1 text-xs text-gray-500 dark:text-gray-400">
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">PO12345</span>
                                            <input
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="PO12345" />
                                        </td>
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">Dark Blue</span>
                                            <input
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="Dark Blue" />
                                        </td>
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">5000m Corn</span>
                                            <input
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="5000m Corn" />
                                        </td>
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">30</span>
                                            <input type="number"
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="30" />
                                        </td>
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">Supplier A</span>
                                            <input
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="Supplier A" />
                                        </td>
                                        <td class="py-3 whitespace-normal break-words text-center">
                                            <div class="yarn-receive-item mb-4">
                                                <button onclick="toggleYarnReceived(event, this)" type="button"
                                                    class="yarn-receive-btn bg-gray-300 text-black px-2 py-1 mt-3 rounded hover:bg-gray-400 transition-all duration-200">
                                                    Pending
                                                </button>
                                                <div
                                                    class="yarn-receive-timestamp mt-1 text-xs text-gray-500 dark:text-gray-400">
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">2025-07-01</span>
                                            <input type="date"
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="2025-07-01" />
                                        </td>
                                        <td class="py-3 whitespace-normal break-words text-center">
                                            <div class="send-production-item mb-4">
                                                <button onclick="toggleSendProduction(event, this)" type="button"
                                                    class="send-production-btn bg-gray-300 text-black px-2 py-1 mt-3 rounded hover:bg-gray-400 transition-all duration-200">
                                                    Pending
                                                </button>
                                                <div
                                                    class="send-production-timestamp mt-1 text-xs text-gray-500 dark:text-gray-400">
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">Production complete</span>
                                            <input
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="Production complete" />
                                        </td>
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">5 yard</span>
                                            <input
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="5 yard" />
                                        </td>
                                        <td class="px-4 py-3 text-center whitespace-normal break-words">
                                            <div class="flex justify-center space-x-2">
                                                <button
                                                    class="bg-green-600 h-10 px-3 py-1 rounded text-white text-sm hover:bg-green-700"
                                                    onclick="editRow('prodRow1')">Edit</button>
                                                <button
                                                    class="bg-blue-600 h-10 px-3 py-1 rounded text-white text-sm hover:bg-blue-700 hidden"
                                                    onclick="saveRow('prodRow1')">Save</button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr id="prodRow1">
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">001</span>
                                            <input
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="001" />
                                        </td>
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">2025-06-05</span>
                                            <input type="date"
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="2025-06-05" />
                                        </td>
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">2025-06-10</span>
                                            <input type="date"
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="2025-06-10" />
                                        </td>

                                        <td class="py-3 whitespace-normal break-words text-center">
                                            <div class="colour-match-sent mb-4">
                                                <button onclick="toggleColourMatchSent(event, this)" type="button"
                                                    class="delivered-btn bg-gray-300 text-black px-2 py-1 mt-3 rounded hover:bg-gray-400 transition-all duration-200">
                                                    Pending
                                                </button>
                                                <div class="timestamp mt-1 text-xs text-gray-500 dark:text-gray-400">
                                                </div>
                                            </div>
                                        </td>

                                        <td class="py-3 whitespace-normal break-words text-center">
                                            <div class="colour-match-receive mb-4">
                                                <button onclick="toggleColourMatchReceive(event, this)" type="button"
                                                    class="receive-btn bg-gray-300 text-black px-2 py-1 mt-3 rounded hover:bg-gray-400 transition-all duration-200">
                                                    Pending
                                                </button>
                                                <div
                                                    class="receive-timestamp mt-1 text-xs text-gray-500 dark:text-gray-400">
                                                </div>
                                            </div>
                                        </td>

                                        <td class="py-3 whitespace-normal break-words text-center">
                                            <div class="yarn-ordered-item mb-4">
                                                <button onclick="toggleYarnOrdered(event, this)" type="button"
                                                    class="yarn-ordered-btn bg-gray-300 text-black px-2 py-1 mt-3 rounded hover:bg-gray-400 transition-all duration-200">
                                                    Pending
                                                </button>
                                                <div
                                                    class="yarn-timestamp mt-1 text-xs text-gray-500 dark:text-gray-400">
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">PO12345</span>
                                            <input
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="PO12345" />
                                        </td>
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">Dark Blue</span>
                                            <input
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="Dark Blue" />
                                        </td>
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">5000m Corn</span>
                                            <input
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="5000m Corn" />
                                        </td>
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">30</span>
                                            <input type="number"
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="30" />
                                        </td>
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">Supplier A</span>
                                            <input
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="Supplier A" />
                                        </td>
                                        <td class="py-3 whitespace-normal break-words text-center">
                                            <div class="yarn-receive-item mb-4">
                                                <button onclick="toggleYarnReceived(event, this)" type="button"
                                                    class="yarn-receive-btn bg-gray-300 text-black px-2 py-1 mt-3 rounded hover:bg-gray-400 transition-all duration-200">
                                                    Pending
                                                </button>
                                                <div
                                                    class="yarn-receive-timestamp mt-1 text-xs text-gray-500 dark:text-gray-400">
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">2025-07-01</span>
                                            <input type="date"
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="2025-07-01" />
                                        </td>
                                        <td class="py-3 whitespace-normal break-words text-center">
                                            <div class="send-production-item mb-4">
                                                <button onclick="toggleSendProduction(event, this)" type="button"
                                                    class="send-production-btn bg-gray-300 text-black px-2 py-1 mt-3 rounded hover:bg-gray-400 transition-all duration-200">
                                                    Pending
                                                </button>
                                                <div
                                                    class="send-production-timestamp mt-1 text-xs text-gray-500 dark:text-gray-400">
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">Production complete</span>
                                            <input
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="Production complete" />
                                        </td>
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">5 yard</span>
                                            <input
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="5 yard" />
                                        </td>
                                        <td class="px-4 py-3 text-center whitespace-normal break-words">
                                            <div class="flex justify-center space-x-2">
                                                <button
                                                    class="bg-green-600 h-10 px-3 py-1 rounded text-white text-sm hover:bg-green-700"
                                                    onclick="editRow('prodRow1')">Edit</button>
                                                <button
                                                    class="bg-blue-600 h-10 px-3 py-1 rounded text-white text-sm hover:bg-blue-700 hidden"
                                                    onclick="saveRow('prodRow1')">Save</button>
                                            </div>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                            <div class="py-6 flex justify-center">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    // ===== ORDER dropdown =====
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
        closeDropdown('orderDropdown', 'orderDropdownMenu');
    }

    function filterOrders() {
        const input = document.getElementById('orderSearchInput').value.toLowerCase();
        const items = document.querySelectorAll('.order-option');

        items.forEach(item => {
            const text = item.textContent.toLowerCase();
            item.style.display = text.includes(input) ? 'block' : 'none';
        });
    }

    // ===== PO dropdown =====
    function togglePODropdown() {
        const menu = document.getElementById('poDropdownMenu');
        const btn = document.getElementById('poDropdown');
        const expanded = btn.getAttribute('aria-expanded') === 'true';

        menu.classList.toggle('hidden');
        btn.setAttribute('aria-expanded', !expanded);
    }

    function selectPO(poNo) {
        document.getElementById('selectedPONo').innerText = poNo || 'Select PO No';
        document.getElementById('poInput').value = poNo;
        closeDropdown('poDropdown', 'poDropdownMenu');
    }

    function filterPOs() {
        const input = document.getElementById('poSearchInput').value.toLowerCase();
        const items = document.querySelectorAll('.po-option');

        items.forEach(item => {
            const text = item.textContent.toLowerCase();
            item.style.display = text.includes(input) ? 'block' : 'none';
        });
    }

    // ===== SHADE dropdown =====
    function toggleShadeDropdown() {
        const menu = document.getElementById('shadeDropdownMenu');
        const btn = document.getElementById('shadeDropdown');
        const expanded = btn.getAttribute('aria-expanded') === 'true';

        menu.classList.toggle('hidden');
        btn.setAttribute('aria-expanded', !expanded);
    }

    function selectShade(shade) {
        document.getElementById('selectedShade').innerText = shade || 'Select Shade';
        document.getElementById('shadeInput').value = shade;
        closeDropdown('shadeDropdown', 'shadeDropdownMenu');
    }

    function filterShades() {
        const input = document.getElementById('shadeSearchInput').value.toLowerCase();
        const items = document.querySelectorAll('.shade-option');

        items.forEach(item => {
            const text = item.textContent.toLowerCase();
            item.style.display = text.includes(input) ? 'block' : 'none';
        });
    }

    // ===== REFERENCE NO dropdown =====
    function toggleRefDropdown() {
        const menu = document.getElementById('refDropdownMenu');
        const btn = document.getElementById('refDropdown');
        const expanded = btn.getAttribute('aria-expanded') === 'true';

        menu.classList.toggle('hidden');
        btn.setAttribute('aria-expanded', !expanded);
    }

    function selectRef(ref) {
        document.getElementById('selectedRef').innerText = ref || 'Select Reference No';
        document.getElementById('refInput').value = ref;
        closeDropdown('refDropdown', 'refDropdownMenu');
    }

    function filterRefs() {
        const input = document.getElementById('refSearchInput').value.toLowerCase();
        const items = document.querySelectorAll('.ref-option');

        items.forEach(item => {
            const text = item.textContent.toLowerCase();
            item.style.display = text.includes(input) ? 'block' : 'none';
        });
    }

    // ===== Helper to close dropdown =====
    function closeDropdown(btnId, menuId) {
        const btn = document.getElementById(btnId);
        const menu = document.getElementById(menuId);

        menu.classList.add('hidden');
        btn.setAttribute('aria-expanded', false);
    }

    function clearFilters() {
        // Order
        document.getElementById('selectedOrderNo').innerText = 'Select Order No';
        document.getElementById('orderInput').value = '';
        document.getElementById('orderSearchInput').value = '';
        filterOrders();

        // PO
        document.getElementById('selectedPONo').innerText = 'Select PO No';
        document.getElementById('poInput').value = '';
        document.getElementById('poSearchInput').value = '';
        filterPOs();

        // Shade
        document.getElementById('selectedShade').innerText = 'Select Shade';
        document.getElementById('shadeInput').value = '';
        document.getElementById('shadeSearchInput').value = '';
        filterShades();

        // Reference No
        document.getElementById('selectedRef').innerText = 'Select Reference No';
        document.getElementById('refInput').value = '';
        document.getElementById('refSearchInput').value = '';
        filterRefs();

        // Dates
        document.getElementById('customerRequestedDate').value = '';
        document.getElementById('developmentPlanDate').value = '';
    }


    // ===== Close dropdowns if click outside =====
    document.addEventListener('click', function(e) {
        // List of dropdowns to check
        const dropdowns = [{
                btnId: 'orderDropdown',
                menuId: 'orderDropdownMenu'
            },
            {
                btnId: 'poDropdown',
                menuId: 'poDropdownMenu'
            },
            {
                btnId: 'shadeDropdown',
                menuId: 'shadeDropdownMenu'
            },
            {
                btnId: 'refDropdown',
                menuId: 'refDropdownMenu'
            }
        ];

        dropdowns.forEach(({
            btnId,
            menuId
        }) => {
            const btn = document.getElementById(btnId);
            const menu = document.getElementById(menuId);

            if (!btn.contains(e.target) && !menu.contains(e.target)) {
                closeDropdown(btnId, menuId);
            }
        });
    });
</script>


<script>
    function editRow(rowId) {
        const row = document.getElementById(rowId);
        const spans = row.querySelectorAll('span.readonly');
        const inputs = row.querySelectorAll('input.editable');
        spans.forEach(s => s.classList.add('hidden'));
        inputs.forEach(i => i.classList.remove('hidden'));

        // Toggle buttons
        const editBtn = row.querySelector('button.bg-green-600');
        const saveBtn = row.querySelector('button.bg-blue-600');
        if (editBtn && saveBtn) {
            editBtn.classList.add('hidden');
            saveBtn.classList.remove('hidden');
        }
    }

    function saveRow(rowId) {
        const row = document.getElementById(rowId);
        const spans = row.querySelectorAll('span.readonly');
        const inputs = row.querySelectorAll('input.editable');

        inputs.forEach((input, idx) => {
            spans[idx].textContent = input.value;
        });

        spans.forEach(s => s.classList.remove('hidden'));
        inputs.forEach(i => i.classList.add('hidden'));

        // Toggle buttons
        const editBtn = row.querySelector('button.bg-green-600');
        const saveBtn = row.querySelector('button.bg-blue-600');
        if (editBtn && saveBtn) {
            editBtn.classList.remove('hidden');
            saveBtn.classList.add('hidden');
        }
    }
</script>

<script>
    function toggleColourMatchSent(event, button) {
        const isPending = button.textContent.trim() === 'Pending';
        const container = button.closest('.colour-match-sent');
        const timestamp = container.querySelector('.timestamp');

        if (isPending) {
            // Mark as Done
            button.textContent = 'Done';
            button.classList.remove('bg-gray-300', 'text-black', 'hover:bg-gray-400');
            button.classList.add('bg-[#FF9119]', 'text-white', 'hover:bg-[#FF9119]/80');

            const now = new Date();
            timestamp.textContent = `Done on ${now.toLocaleDateString()} at ${now.toLocaleTimeString()}`;
        } else {
            // Revert to Pending
            button.textContent = 'Pending';
            button.classList.remove('bg-[#FF9119]', 'text-white', 'hover:bg-[#FF9119]/80');
            button.classList.add('bg-gray-300', 'text-black', 'hover:bg-gray-400');

            timestamp.textContent = '';
        }
    }
</script>

<script>
    function toggleColourMatchReceive(event, button) {
        const isPending = button.textContent.trim() === 'Pending';
        const container = button.closest('.colour-match-receive');
        const timestamp = container.querySelector('.receive-timestamp');

        if (isPending) {
            // Change to "Receive" with green color
            button.textContent = 'Receive';
            button.classList.remove('bg-gray-300', 'text-black', 'hover:bg-gray-400');
            button.classList.add('bg-green-500', 'text-white', 'hover:bg-green-600');

            const now = new Date();
            timestamp.textContent = `Received on ${now.toLocaleDateString()} at ${now.toLocaleTimeString()}`;
        } else {
            // Revert to "Pending" with gray color
            button.textContent = 'Pending';
            button.classList.remove('bg-green-500', 'text-white', 'hover:bg-green-600');
            button.classList.add('bg-gray-300', 'text-black', 'hover:bg-gray-400');

            timestamp.textContent = '';
        }
    }
</script>

<script>
    function toggleYarnOrdered(event, button) {
        const isPending = button.textContent.trim() === 'Pending';
        const container = button.closest('.yarn-ordered-item');
        const timestamp = container.querySelector('.yarn-timestamp');

        if (isPending) {
            // ✅ Set to "Ordered" with green color
            button.textContent = 'Ordered';
            button.classList.remove('bg-gray-300', 'text-black', 'hover:bg-gray-400');
            button.classList.add('bg-[#FF9119]', 'text-white', 'hover:bg-[#FF9119]/80');

            const now = new Date();
            timestamp.textContent = `Ordered on ${now.toLocaleDateString()} at ${now.toLocaleTimeString()}`;
        } else {
            // ✅ Set back to "Pending"
            button.textContent = 'Pending';
            button.classList.remove('bg-[#FF9119]', 'text-white', 'hover:bg-[#FF9119]/80');
            button.classList.add('bg-gray-300', 'text-black', 'hover:bg-gray-400');

            timestamp.textContent = '';
        }
    }
</script>

<script>
    function toggleYarnReceived(event, button) {
        const isPending = button.textContent.trim() === 'Pending';
        const container = button.closest('.yarn-receive-item');
        const timestamp = container.querySelector('.yarn-receive-timestamp');

        if (isPending) {
            // ✅ Change to "Received"
            button.textContent = 'Received';
            button.classList.remove('bg-gray-300', 'text-black', 'hover:bg-gray-400');
            button.classList.add('bg-green-500', 'text-white', 'hover:bg-green-600');

            const now = new Date();
            timestamp.textContent = `Received on ${now.toLocaleDateString()} at ${now.toLocaleTimeString()}`;
        } else {
            // ✅ Revert to "Pending"
            button.textContent = 'Pending';
            button.classList.remove('bg-green-500', 'text-white', 'hover:bg-green-600');
            button.classList.add('bg-gray-300', 'text-black', 'hover:bg-gray-400');

            timestamp.textContent = '';
        }
    }
</script>

<script>
    function toggleSendProduction(event, button) {
        const isPending = button.textContent.trim() === 'Pending';
        const container = button.closest('.send-production-item');
        const timestamp = container.querySelector('.send-production-timestamp');

        if (isPending) {
            // Change to Sent (green)
            button.textContent = 'Sent';
            button.classList.remove('bg-gray-300', 'text-black', 'hover:bg-gray-400');
            button.classList.add('bg-[#FF9119]', 'text-white', 'hover:bg-[#FF9119]/80');

            const now = new Date();
            timestamp.textContent = `Sent on ${now.toLocaleDateString()} at ${now.toLocaleTimeString()}`;
        } else {
            // Revert to Pending
            button.textContent = 'Pending';
            button.classList.remove('bg-[#FF9119]', 'text-white', 'hover:bg-[#FF9119]/80');
            button.classList.add('bg-gray-300', 'text-black', 'hover:bg-gray-400');

            timestamp.textContent = '';
        }
    }
</script>
