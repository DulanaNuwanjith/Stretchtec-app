<div class="flex h-full w-full">
    <div class="flex-1 overflow-y-hidden mb-20">
        <div class="py-4">
            <div class="w-full px-6 lg:px-2">
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
                        <form id="filterForm3" method="GET" action="" class="mb-6 flex gap-6 items-center">
                            <div class="flex items-center gap-4">
                                <!-- Sample No Dropdown -->
                                <div class="relative inline-block text-left w-48">
                                    <label for="sampleDropdown"
                                        class="block text-sm font-medium text-gray-700 mb-1">Sample No</label>

                                    <button type="button" id="sampleDropdown"
                                        class="inline-flex w-full justify-between rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-gray-300 hover:bg-gray-50"
                                        onclick="toggleSampleDropdown()" aria-haspopup="listbox" aria-expanded="false">
                                        <span id="selectedSample">Select Sample No</span>
                                        <svg class="ml-2 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 10.94l3.71-3.71a.75.75 0 1 1 1.06 1.06l-4.24 4.24a.75.75 0 0 1-1.06 0L5.25 8.29a.75.75 0 0 1-.02-1.08z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>

                                    <div id="sampleDropdownMenu"
                                        class="hidden absolute z-10 mt-2 w-full rounded-md bg-white shadow-lg ring-1 ring-black/5 max-h-48 overflow-y-auto">

                                        <!-- Search box -->
                                        <div class="p-2 sticky top-0 bg-white z-10">
                                            <input type="text" id="sampleSearchInput"
                                                placeholder="Search Sample No..."
                                                class="w-full px-2 py-1 text-sm border rounded-md"
                                                oninput="filterSamples()" />
                                        </div>

                                        <div class="py-1" role="listbox" tabindex="-1">
                                            <!-- Clear / Reset -->
                                            <button type="button"
                                                class="sample-option w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                                onclick="selectSample('', 'Select Sample No')">
                                                All Sample No
                                            </button>

                                            <!-- Sample Options -->
                                            <button type="button"
                                                class="sample-option w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                                onclick="selectSample('001', 'SAMPLE-001')">SAMPLE-001</button>
                                            <button type="button"
                                                class="sample-option w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                                onclick="selectSample('002', 'SAMPLE-002')">SAMPLE-002</button>
                                            <button type="button"
                                                class="sample-option w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                                onclick="selectSample('003', 'SAMPLE-003')">SAMPLE-003</button>
                                        </div>
                                    </div>

                                    <input type="hidden" name="sample_no" id="sampleInput">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Production
                                        Deadline</label>
                                    <input type="date" id="productionDeadlineFilter" name="production_deadline"
                                        value="{{ request('') }}"
                                        class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Order
                                        Complete Date</label>
                                    <input type="date" id="oderCompleteDateFilter" name="order_complete_date"
                                        value="{{ request('') }}"
                                        class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                </div>
                            </div>

                            <button type="submit"
                                class="mt-4 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                                Apply Filters
                            </button>

                            <button type="button" id="clearFiltersBtnProduction"
                                class="mt-4 bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-200 px-4 py-2 rounded hover:bg-gray-300">
                                Clear Filters
                            </button>
                        </form>


                        <div class="flex justify-between items-center mb-6">
                            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Sample Preperation
                                Production
                                Records
                            </h1>
                        </div>

                        <div class="overflow-x-auto bg-white dark:bg-gray-900 shadow rounded-lg">
                            <table class="table-fixed w-full text-sm divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-100 dark:bg-gray-700 text-left">
                                    <tr>
                                        <th
                                            class="px-4 py-3 w-20 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                            Order No
                                        </th>
                                        <th
                                            class="px-4 py-3 w-32 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                            Production Deadline
                                        </th>
                                        <th
                                            class="px-4 py-3 w-32 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                            Order Received Date & Time
                                        </th>
                                        <th
                                            class="px-4 py-3 w-40 text-center text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                            Order Start Date & Time
                                        </th>
                                        <th
                                            class="px-4 py-3 w-40 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                            Operator Name
                                        </th>
                                        <th
                                            class="px-4 py-3 w-40 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                            Supervisor Name
                                        </th>
                                        <th
                                            class="px-4 py-3 w-40 text-center text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                            Order Complete Date & Time
                                        </th>
                                        <th
                                            class="px-4 py-3 w-40 text-center text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                            Dispatch to R&D
                                        </th>
                                        <th
                                            class="px-4 py-3 w-32 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                            Production Output</th>
                                        <th
                                            class="px-4 py-3 w-72 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                            Special Note
                                        </th>
                                        <th
                                            class="px-4 py-3 w-48 text-center text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="serviceRecords"
                                    class="bg-white dark:bg-gray-800 divide-y text-left divide-gray-200 dark:divide-gray-700">

                                    <tr id="serviceRow1">
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">001</span>
                                            <input
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="001" />
                                        </td>
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">2025-05-05</span>
                                            <input type="date"
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="2025-05-05" />
                                        </td>
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">2025-05-05</span>
                                            <input type="date"
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="2025-05-05" />
                                        </td>
                                        <td class="py-3 whitespace-normal break-words text-center">
                                            <div class="order-start-item mb-4">
                                                <button onclick="toggleOrderStart(event, this)" type="button"
                                                    class="order-start-btn bg-gray-300 text-black px-2 py-1 mt-3 rounded hover:bg-gray-400 transition-all duration-200">
                                                    Pending
                                                </button>
                                                <div
                                                    class="order-start-timestamp mt-1 text-xs text-gray-500 dark:text-gray-400">
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">Operator 001</span>
                                            <input
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="Operator 001" />
                                        </td>
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">Supervisor 001</span>
                                            <input
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="Supervisor 001" />
                                        </td>
                                        <td class="py-3 whitespace-normal break-words text-center">
                                            <div class="order-complete-item mb-4">
                                                <button onclick="toggleOrderComplete(event, this)" type="button"
                                                    class="order-complete-btn bg-gray-300 text-black px-2 py-1 mt-3 rounded hover:bg-gray-400 transition-all duration-200">
                                                    Pending
                                                </button>
                                                <div
                                                    class="order-complete-timestamp mt-1 text-xs text-gray-500 dark:text-gray-400">
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-3 whitespace-normal break-words text-center">
                                            <div class="sample-dispatch-item mb-4">
                                                <button onclick="toggleSampleDispatch(event, this)" type="button"
                                                    class="sample-dispatch-btn bg-gray-300 text-black px-2 py-1 mt-3 rounded hover:bg-gray-400 transition-all duration-200">
                                                    Pending
                                                </button>
                                                <div
                                                    class="sample-dispatch-timestamp mt-1 text-xs text-gray-500 dark:text-gray-400">
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">5 yard</span>
                                            <input
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="5 yard" />
                                        </td>
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">abc 1234 long sample description to test line
                                                wrapping</span>
                                            <textarea
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                rows="2">abc 1234 long sample description to test line wrapping</textarea>
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <div class="flex text-center space-x-2 justify-center">
                                                <button
                                                    class="bg-green-600 h-10 hover:bg-green-700 text-white px-3 py-1 rounded text-sm"
                                                    onclick="editServiceRow('serviceRow1')">
                                                    Edit
                                                </button>
                                                <button
                                                    class="bg-blue-600 h-10 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm hidden"
                                                    onclick="saveServiceRow('serviceRow1')">
                                                    Save
                                                </button>
                                                <button
                                                    class="bg-gray-600 h-10 hover:bg-gray-700 text-white px-3 py-1 rounded text-sm">Download</button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr id="serviceRow1">
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">001</span>
                                            <input
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="001" />
                                        </td>
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">2025-05-05</span>
                                            <input type="date"
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="2025-05-05" />
                                        </td>
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">2025-05-05</span>
                                            <input type="date"
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="2025-05-05" />
                                        </td>
                                        <td class="py-3 whitespace-normal break-words text-center">
                                            <div class="order-start-item mb-4">
                                                <button onclick="toggleOrderStart(event, this)" type="button"
                                                    class="order-start-btn bg-gray-300 text-black px-2 py-1 mt-3 rounded hover:bg-gray-400 transition-all duration-200">
                                                    Pending
                                                </button>
                                                <div
                                                    class="order-start-timestamp mt-1 text-xs text-gray-500 dark:text-gray-400">
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">Operator 001</span>
                                            <input
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="Operator 001" />
                                        </td>
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">Supervisor 001</span>
                                            <input
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="Supervisor 001" />
                                        </td>
                                        <td class="py-3 whitespace-normal break-words text-center">
                                            <div class="order-complete-item mb-4">
                                                <button onclick="toggleOrderComplete(event, this)" type="button"
                                                    class="order-complete-btn bg-gray-300 text-black px-2 py-1 mt-3 rounded hover:bg-gray-400 transition-all duration-200">
                                                    Pending
                                                </button>
                                                <div
                                                    class="order-complete-timestamp mt-1 text-xs text-gray-500 dark:text-gray-400">
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-3 whitespace-normal break-words text-center">
                                            <div class="sample-dispatch-item mb-4">
                                                <button onclick="toggleSampleDispatch(event, this)" type="button"
                                                    class="sample-dispatch-btn bg-gray-300 text-black px-2 py-1 mt-3 rounded hover:bg-gray-400 transition-all duration-200">
                                                    Pending
                                                </button>
                                                <div
                                                    class="sample-dispatch-timestamp mt-1 text-xs text-gray-500 dark:text-gray-400">
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">5 yard</span>
                                            <input
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="5 yard" />
                                        </td>
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">abc 1234 long sample description to test line
                                                wrapping</span>
                                            <textarea
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                rows="2">abc 1234 long sample description to test line wrapping</textarea>
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <div class="flex text-center space-x-2 justify-center">
                                                <button
                                                    class="bg-green-600 h-10 hover:bg-green-700 text-white px-3 py-1 rounded text-sm"
                                                    onclick="editServiceRow('serviceRow1')">
                                                    Edit
                                                </button>
                                                <button
                                                    class="bg-blue-600 h-10 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm hidden"
                                                    onclick="saveServiceRow('serviceRow1')">
                                                    Save
                                                </button>
                                                <button
                                                    class="bg-gray-600 h-10 hover:bg-gray-700 text-white px-3 py-1 rounded text-sm">Download</button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr id="serviceRow1">
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">001</span>
                                            <input
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="001" />
                                        </td>
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">2025-05-05</span>
                                            <input type="date"
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="2025-05-05" />
                                        </td>
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">2025-05-05</span>
                                            <input type="date"
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="2025-05-05" />
                                        </td>
                                        <td class="py-3 whitespace-normal break-words text-center">
                                            <div class="order-start-item mb-4">
                                                <button onclick="toggleOrderStart(event, this)" type="button"
                                                    class="order-start-btn bg-gray-300 text-black px-2 py-1 mt-3 rounded hover:bg-gray-400 transition-all duration-200">
                                                    Pending
                                                </button>
                                                <div
                                                    class="order-start-timestamp mt-1 text-xs text-gray-500 dark:text-gray-400">
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">Operator 001</span>
                                            <input
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="Operator 001" />
                                        </td>
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">Supervisor 001</span>
                                            <input
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="Supervisor 001" />
                                        </td>
                                        <td class="py-3 whitespace-normal break-words text-center">
                                            <div class="order-complete-item mb-4">
                                                <button onclick="toggleOrderComplete(event, this)" type="button"
                                                    class="order-complete-btn bg-gray-300 text-black px-2 py-1 mt-3 rounded hover:bg-gray-400 transition-all duration-200">
                                                    Pending
                                                </button>
                                                <div
                                                    class="order-complete-timestamp mt-1 text-xs text-gray-500 dark:text-gray-400">
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-3 whitespace-normal break-words text-center">
                                            <div class="sample-dispatch-item mb-4">
                                                <button onclick="toggleSampleDispatch(event, this)" type="button"
                                                    class="sample-dispatch-btn bg-gray-300 text-black px-2 py-1 mt-3 rounded hover:bg-gray-400 transition-all duration-200">
                                                    Pending
                                                </button>
                                                <div
                                                    class="sample-dispatch-timestamp mt-1 text-xs text-gray-500 dark:text-gray-400">
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">5 yard</span>
                                            <input
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="5 yard" />
                                        </td>
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">abc 1234 long sample description to test line
                                                wrapping</span>
                                            <textarea
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                rows="2">abc 1234 long sample description to test line wrapping</textarea>
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <div class="flex text-center space-x-2 justify-center">
                                                <button
                                                    class="bg-green-600 h-10 hover:bg-green-700 text-white px-3 py-1 rounded text-sm"
                                                    onclick="editServiceRow('serviceRow1')">
                                                    Edit
                                                </button>
                                                <button
                                                    class="bg-blue-600 h-10 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm hidden"
                                                    onclick="saveServiceRow('serviceRow1')">
                                                    Save
                                                </button>
                                                <button
                                                    class="bg-gray-600 h-10 hover:bg-gray-700 text-white px-3 py-1 rounded text-sm">Download</button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr id="serviceRow1">
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">001</span>
                                            <input
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="001" />
                                        </td>
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">2025-05-05</span>
                                            <input type="date"
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="2025-05-05" />
                                        </td>
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">2025-05-05</span>
                                            <input type="date"
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="2025-05-05" />
                                        </td>
                                        <td class="py-3 whitespace-normal break-words text-center">
                                            <div class="order-start-item mb-4">
                                                <button onclick="toggleOrderStart(event, this)" type="button"
                                                    class="order-start-btn bg-gray-300 text-black px-2 py-1 mt-3 rounded hover:bg-gray-400 transition-all duration-200">
                                                    Pending
                                                </button>
                                                <div
                                                    class="order-start-timestamp mt-1 text-xs text-gray-500 dark:text-gray-400">
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">Operator 001</span>
                                            <input
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="Operator 001" />
                                        </td>
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">Supervisor 001</span>
                                            <input
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="Supervisor 001" />
                                        </td>
                                        <td class="py-3 whitespace-normal break-words text-center">
                                            <div class="order-complete-item mb-4">
                                                <button onclick="toggleOrderComplete(event, this)" type="button"
                                                    class="order-complete-btn bg-gray-300 text-black px-2 py-1 mt-3 rounded hover:bg-gray-400 transition-all duration-200">
                                                    Pending
                                                </button>
                                                <div
                                                    class="order-complete-timestamp mt-1 text-xs text-gray-500 dark:text-gray-400">
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-3 whitespace-normal break-words text-center">
                                            <div class="sample-dispatch-item mb-4">
                                                <button onclick="toggleSampleDispatch(event, this)" type="button"
                                                    class="sample-dispatch-btn bg-gray-300 text-black px-2 py-1 mt-3 rounded hover:bg-gray-400 transition-all duration-200">
                                                    Pending
                                                </button>
                                                <div
                                                    class="sample-dispatch-timestamp mt-1 text-xs text-gray-500 dark:text-gray-400">
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">5 yard</span>
                                            <input
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="5 yard" />
                                        </td>
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">abc 1234 long sample description to test line
                                                wrapping</span>
                                            <textarea
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                rows="2">abc 1234 long sample description to test line wrapping</textarea>
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <div class="flex text-center space-x-2 justify-center">
                                                <button
                                                    class="bg-green-600 h-10 hover:bg-green-700 text-white px-3 py-1 rounded text-sm"
                                                    onclick="editServiceRow('serviceRow1')">
                                                    Edit
                                                </button>
                                                <button
                                                    class="bg-blue-600 h-10 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm hidden"
                                                    onclick="saveServiceRow('serviceRow1')">
                                                    Save
                                                </button>
                                                <button
                                                    class="bg-gray-600 h-10 hover:bg-gray-700 text-white px-3 py-1 rounded text-sm">Download</button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr id="serviceRow1">
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">001</span>
                                            <input
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="001" />
                                        </td>
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">2025-05-05</span>
                                            <input type="date"
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="2025-05-05" />
                                        </td>
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">2025-05-05</span>
                                            <input type="date"
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="2025-05-05" />
                                        </td>
                                        <td class="py-3 whitespace-normal break-words text-center">
                                            <div class="order-start-item mb-4">
                                                <button onclick="toggleOrderStart(event, this)" type="button"
                                                    class="order-start-btn bg-gray-300 text-black px-2 py-1 mt-3 rounded hover:bg-gray-400 transition-all duration-200">
                                                    Pending
                                                </button>
                                                <div
                                                    class="order-start-timestamp mt-1 text-xs text-gray-500 dark:text-gray-400">
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">Operator 001</span>
                                            <input
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="Operator 001" />
                                        </td>
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">Supervisor 001</span>
                                            <input
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="Supervisor 001" />
                                        </td>
                                        <td class="py-3 whitespace-normal break-words text-center">
                                            <div class="order-complete-item mb-4">
                                                <button onclick="toggleOrderComplete(event, this)" type="button"
                                                    class="order-complete-btn bg-gray-300 text-black px-2 py-1 mt-3 rounded hover:bg-gray-400 transition-all duration-200">
                                                    Pending
                                                </button>
                                                <div
                                                    class="order-complete-timestamp mt-1 text-xs text-gray-500 dark:text-gray-400">
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-3 whitespace-normal break-words text-center">
                                            <div class="sample-dispatch-item mb-4">
                                                <button onclick="toggleSampleDispatch(event, this)" type="button"
                                                    class="sample-dispatch-btn bg-gray-300 text-black px-2 py-1 mt-3 rounded hover:bg-gray-400 transition-all duration-200">
                                                    Pending
                                                </button>
                                                <div
                                                    class="sample-dispatch-timestamp mt-1 text-xs text-gray-500 dark:text-gray-400">
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">5 yard</span>
                                            <input
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="5 yard" />
                                        </td>
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">abc 1234 long sample description to test line
                                                wrapping</span>
                                            <textarea
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                rows="2">abc 1234 long sample description to test line wrapping</textarea>
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <div class="flex text-center space-x-2 justify-center">
                                                <button
                                                    class="bg-green-600 h-10 hover:bg-green-700 text-white px-3 py-1 rounded text-sm"
                                                    onclick="editServiceRow('serviceRow1')">
                                                    Edit
                                                </button>
                                                <button
                                                    class="bg-blue-600 h-10 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm hidden"
                                                    onclick="saveServiceRow('serviceRow1')">
                                                    Save
                                                </button>
                                                <button
                                                    class="bg-gray-600 h-10 hover:bg-gray-700 text-white px-3 py-1 rounded text-sm">Download</button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr id="serviceRow1">
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">001</span>
                                            <input
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="001" />
                                        </td>
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">2025-05-05</span>
                                            <input type="date"
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="2025-05-05" />
                                        </td>
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">2025-05-05</span>
                                            <input type="date"
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="2025-05-05" />
                                        </td>
                                        <td class="py-3 whitespace-normal break-words text-center">
                                            <div class="order-start-item mb-4">
                                                <button onclick="toggleOrderStart(event, this)" type="button"
                                                    class="order-start-btn bg-gray-300 text-black px-2 py-1 mt-3 rounded hover:bg-gray-400 transition-all duration-200">
                                                    Pending
                                                </button>
                                                <div
                                                    class="order-start-timestamp mt-1 text-xs text-gray-500 dark:text-gray-400">
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">Operator 001</span>
                                            <input
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="Operator 001" />
                                        </td>
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">Supervisor 001</span>
                                            <input
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="Supervisor 001" />
                                        </td>
                                        <td class="py-3 whitespace-normal break-words text-center">
                                            <div class="order-complete-item mb-4">
                                                <button onclick="toggleOrderComplete(event, this)" type="button"
                                                    class="order-complete-btn bg-gray-300 text-black px-2 py-1 mt-3 rounded hover:bg-gray-400 transition-all duration-200">
                                                    Pending
                                                </button>
                                                <div
                                                    class="order-complete-timestamp mt-1 text-xs text-gray-500 dark:text-gray-400">
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-3 whitespace-normal break-words text-center">
                                            <div class="sample-dispatch-item mb-4">
                                                <button onclick="toggleSampleDispatch(event, this)" type="button"
                                                    class="sample-dispatch-btn bg-gray-300 text-black px-2 py-1 mt-3 rounded hover:bg-gray-400 transition-all duration-200">
                                                    Pending
                                                </button>
                                                <div
                                                    class="sample-dispatch-timestamp mt-1 text-xs text-gray-500 dark:text-gray-400">
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">5 yard</span>
                                            <input
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="5 yard" />
                                        </td>
                                        <td class="px-4 py-3 whitespace-normal break-words">
                                            <span class="readonly">abc 1234 long sample description to test line
                                                wrapping</span>
                                            <textarea
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                rows="2">abc 1234 long sample description to test line wrapping</textarea>
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <div class="flex text-center space-x-2 justify-center">
                                                <button
                                                    class="bg-green-600 h-10 hover:bg-green-700 text-white px-3 py-1 rounded text-sm"
                                                    onclick="editServiceRow('serviceRow1')">
                                                    Edit
                                                </button>
                                                <button
                                                    class="bg-blue-600 h-10 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm hidden"
                                                    onclick="saveServiceRow('serviceRow1')">
                                                    Save
                                                </button>
                                                <button
                                                    class="bg-gray-600 h-10 hover:bg-gray-700 text-white px-3 py-1 rounded text-sm">Download</button>
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
    document.addEventListener('DOMContentLoaded', () => {
        const clearFiltersBtn = document.getElementById('clearFiltersBtnProduction');
        const filterForm = document.getElementById('filterForm3');

        clearFiltersBtn.addEventListener('click', () => {
            // Reset dropdown label and hidden sample input
            document.getElementById('selectedSample').innerText = 'All Sample No';
            document.getElementById('sampleInput').value = '';

            // Reset date fields manually
            document.getElementById('productionDeadlineFilter').value = '';
            document.getElementById('oderCompleteDateFilter').value = '';

            // Close dropdown
            document.getElementById('sampleDropdownMenu').classList.add('hidden');
            document.getElementById('sampleDropdown').setAttribute('aria-expanded', 'false');

            // Prevent form submission and page reload
            // filterForm.submit(); // Removed as per your request
        });
    });


    function toggleSampleDropdown() {
        const menu = document.getElementById('sampleDropdownMenu');
        const btn = document.getElementById('sampleDropdown');
        const expanded = btn.getAttribute('aria-expanded') === 'true';

        menu.classList.toggle('hidden');
        btn.setAttribute('aria-expanded', String(!expanded));

        if (!menu.classList.contains('hidden')) {
            document.getElementById('sampleSearchInput').value = '';
            filterSamples();
        }
    }

    function filterSamples() {
        const filter = document.getElementById('sampleSearchInput').value.toLowerCase();
        const options = document.querySelectorAll('#sampleDropdownMenu .sample-option');

        options.forEach(option => {
            const text = option.textContent.toLowerCase();
            option.style.display = text.includes(filter) ? '' : 'none';
        });
    }

    function selectSample(id, label) {
        document.getElementById('selectedSample').innerText = label;
        document.getElementById('sampleInput').value = id;
        document.getElementById('sampleDropdownMenu').classList.add('hidden');
        document.getElementById('sampleDropdown').setAttribute('aria-expanded', 'false');
    }

    // Close dropdown if clicking outside of it
    document.addEventListener('click', function(e) {
        const btn = document.getElementById('sampleDropdown');
        const menu = document.getElementById('sampleDropdownMenu');

        if (!btn.contains(e.target) && !menu.contains(e.target)) {
            menu.classList.add('hidden');
            btn.setAttribute('aria-expanded', 'false');
        }
    });
</script>

<script>
    function editServiceRow(rowId) {
        const row = document.getElementById(rowId);
        const spans = row.querySelectorAll('span.readonly');
        const inputs = row.querySelectorAll('input.editable, textarea.editable');

        spans.forEach(span => span.classList.add('hidden'));
        inputs.forEach(input => input.classList.remove('hidden'));

        const editBtn = row.querySelector('button.bg-green-600');
        const saveBtn = row.querySelector('button.bg-blue-600');
        editBtn.classList.add('hidden');
        saveBtn.classList.remove('hidden');
    }

    function saveServiceRow(rowId) {
        const row = document.getElementById(rowId);
        const spans = row.querySelectorAll('span.readonly');
        const inputs = row.querySelectorAll('input.editable, textarea.editable');

        inputs.forEach((input, index) => {
            if (input.tagName.toLowerCase() === 'textarea') {
                spans[index].textContent = input.value;
            } else {
                spans[index].textContent = input.value;
            }
        });

        spans.forEach(span => span.classList.remove('hidden'));
        inputs.forEach(input => input.classList.add('hidden'));

        const editBtn = row.querySelector('button.bg-green-600');
        const saveBtn = row.querySelector('button.bg-blue-600');
        editBtn.classList.remove('hidden');
        saveBtn.classList.add('hidden');
    }
</script>

<script>
    function toggleOrderStart(event, button) {
        const isPending = button.textContent.trim() === 'Pending';
        const container = button.closest('.order-start-item');
        const timestamp = container.querySelector('.order-start-timestamp');

        if (isPending) {
            button.textContent = 'Started';
            button.classList.remove('bg-gray-300', 'text-black', 'hover:bg-gray-400');
            button.classList.add('bg-[#FF9119]', 'text-white', 'hover:bg-[#FF9119]/80');

            const now = new Date();
            timestamp.textContent = `Started on ${now.toLocaleDateString()} at ${now.toLocaleTimeString()}`;
        } else {
            button.textContent = 'Pending';
            button.classList.remove('bg-[#FF9119]', 'text-white', 'hover:bg-[#FF9119]/80');
            button.classList.add('bg-gray-300', 'text-black', 'hover:bg-gray-400');

            timestamp.textContent = '';
        }
    }
</script>

<script>
    function toggleOrderComplete(event, button) {
        const isPending = button.textContent.trim() === 'Pending';
        const container = button.closest('.order-complete-item');
        const timestamp = container.querySelector('.order-complete-timestamp');

        if (isPending) {
            button.textContent = 'Completed';
            button.classList.remove('bg-gray-300', 'text-black', 'hover:bg-gray-400');
            button.classList.add('bg-green-500', 'text-white', 'hover:bg-green-600');

            const now = new Date();
            timestamp.textContent = `Completed on ${now.toLocaleDateString()} at ${now.toLocaleTimeString()}`;
        } else {
            button.textContent = 'Pending';
            button.classList.remove('bg-green-500', 'text-white', 'hover:bg-green-600');
            button.classList.add('bg-gray-300', 'text-black', 'hover:bg-gray-400');

            timestamp.textContent = '';
        }
    }
</script>

<script>
    function toggleSampleDispatch(event, button) {
        const isPending = button.textContent.trim() === 'Pending';
        const container = button.closest('.sample-dispatch-item');
        const timestamp = container.querySelector('.sample-dispatch-timestamp');

        if (isPending) {
            button.textContent = 'Done';
            button.classList.remove('bg-gray-300', 'text-black', 'hover:bg-gray-400');
            button.classList.add('bg-green-500', 'text-white', 'hover:bg-green-600');

            const now = new Date();
            timestamp.textContent = `Done on ${now.toLocaleDateString()} at ${now.toLocaleTimeString()}`;
        } else {
            button.textContent = 'Pending';
            button.classList.remove('bg-green-500', 'text-white', 'hover:bg-green-600');
            button.classList.add('bg-gray-300', 'text-black', 'hover:bg-gray-400');

            timestamp.textContent = '';
        }
    }
</script>
