<div class="flex h-full w-full">
    <div class="flex-1 overflow-y-auto">
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
                        <form id="filterForm1" method="GET" action="" class="mb-6 flex gap-6 items-center">
                            <div class="flex items-center gap-4">

                                <!-- CUSTOMER DROPDOWN -->
                                <div class="relative inline-block text-left w-48">
                                    <label for="customerDropdown"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Customer</label>
                                    <div>
                                        <button type="button" id="customerDropdown"
                                            class="inline-flex w-full justify-between rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-gray-300 hover:bg-gray-50 h-10 dark:bg-gray-700 dark:text-white"
                                            onclick="toggleDropdown('customer')" aria-haspopup="listbox"
                                            aria-expanded="false">
                                            <span
                                                id="selectedCustomer">{{ request('customer') ? request('customer') : 'Select Customer' }}</span>
                                            <svg class="ml-2 h-5 w-5 text-gray-400" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 10.94l3.71-3.71a.75.75 0 1 1 1.06 1.06l-4.24 4.24a.75.75 0 0 1-1.06 0L5.25 8.29a.75.75 0 0 1-.02-1.08z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>
                                    <div id="customerDropdownMenu"
                                        class="hidden absolute z-10 mt-2 w-full rounded-md bg-white shadow-lg ring-1 ring-black/5 dark:bg-gray-700 max-h-48 overflow-y-auto">
                                        <div class="p-2 sticky top-0 bg-white dark:bg-gray-700 z-10">
                                            <input type="text" id="customerSearchInput"
                                                placeholder="Search customers..."
                                                class="w-full px-2 py-1 text-sm border rounded-md dark:bg-gray-600 dark:text-white dark:placeholder-gray-300"
                                                onkeyup="filterOptions('customer')" />
                                        </div>
                                        <div class="py-1" role="listbox" tabindex="-1"
                                            aria-labelledby="customerDropdown">
                                            <button type="button"
                                                class="customer-option w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600"
                                                onclick="selectOption('customer', '')">Select Customer</button>
                                            <button type="button"
                                                class="customer-option w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600"
                                                onclick="selectOption('customer', 'TIMEX')">TIMEX</button>
                                            <button type="button"
                                                class="customer-option w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600"
                                                onclick="selectOption('customer', 'NESTLE')">NESTLE</button>
                                            <button type="button"
                                                class="customer-option w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600"
                                                onclick="selectOption('customer', 'PEPSI')">PEPSI</button>
                                        </div>
                                    </div>
                                    <input type="hidden" name="customer" id="customerInput"
                                        value="{{ request('customer') }}">
                                </div>

                                <!-- MERCHANDISER DROPDOWN -->
                                <div class="relative inline-block text-left w-48">
                                    <label for="merchandiserDropdown"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Merchandiser</label>
                                    <div>
                                        <button type="button" id="merchandiserDropdown"
                                            class="inline-flex w-full justify-between rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-gray-300 hover:bg-gray-50 h-10 dark:bg-gray-700 dark:text-white"
                                            onclick="toggleDropdown('merchandiser')" aria-haspopup="listbox"
                                            aria-expanded="false">
                                            <span
                                                id="selectedMerchandiser">{{ request('merchandiser') ? request('merchandiser') : 'Select Merchandiser' }}</span>
                                            <svg class="ml-2 h-5 w-5 text-gray-400" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 10.94l3.71-3.71a.75.75 0 1 1 1.06 1.06l-4.24 4.24a.75.75 0 0 1-1.06 0L5.25 8.29a.75.75 0 0 1-.02-1.08z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>
                                    <div id="merchandiserDropdownMenu"
                                        class="hidden absolute z-10 mt-2 w-full rounded-md bg-white shadow-lg ring-1 ring-black/5 dark:bg-gray-700 max-h-48 overflow-y-auto">
                                        <div class="p-2 sticky top-0 bg-white dark:bg-gray-700 z-10">
                                            <input type="text" id="merchandiserSearchInput"
                                                placeholder="Search merchandisers..."
                                                class="w-full px-2 py-1 text-sm border rounded-md dark:bg-gray-600 dark:text-white dark:placeholder-gray-300"
                                                onkeyup="filterOptions('merchandiser')" />
                                        </div>
                                        <div class="py-1" role="listbox" tabindex="-1"
                                            aria-labelledby="merchandiserDropdown">
                                            <button type="button"
                                                class="merchandiser-option w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600"
                                                onclick="selectOption('merchandiser', '')">Select Merchandiser</button>
                                            <button type="button"
                                                class="merchandiser-option w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600"
                                                onclick="selectOption('merchandiser', 'John Doe')">John Doe</button>
                                            <button type="button"
                                                class="merchandiser-option w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600"
                                                onclick="selectOption('merchandiser', 'Jane Smith')">Jane
                                                Smith</button>
                                        </div>
                                    </div>
                                    <input type="hidden" name="merchandiser" id="merchandiserInput"
                                        value="{{ request('merchandiser') }}">
                                </div>

                                <!-- ITEM DROPDOWN -->
                                <div class="relative inline-block text-left w-48">
                                    <label for="itemDropdown"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Item</label>
                                    <div>
                                        <button type="button" id="itemDropdown"
                                            class="inline-flex w-full justify-between rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-gray-300 hover:bg-gray-50 h-10 dark:bg-gray-700 dark:text-white"
                                            onclick="toggleDropdown('item')" aria-haspopup="listbox"
                                            aria-expanded="false">
                                            <span
                                                id="selectedItem">{{ request('item') ? request('item') : 'Select Item' }}</span>
                                            <svg class="ml-2 h-5 w-5 text-gray-400" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 10.94l3.71-3.71a.75.75 0 1 1 1.06 1.06l-4.24 4.24a.75.75 0 0 1-1.06 0L5.25 8.29a.75.75 0 0 1-.02-1.08z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>
                                    <div id="itemDropdownMenu"
                                        class="hidden absolute z-10 mt-2 w-full rounded-md bg-white shadow-lg ring-1 ring-black/5 dark:bg-gray-700 max-h-48 overflow-y-auto">
                                        <div class="p-2 sticky top-0 bg-white dark:bg-gray-700 z-10">
                                            <input type="text" id="itemSearchInput" placeholder="Search items..."
                                                class="w-full px-2 py-1 text-sm border rounded-md dark:bg-gray-600 dark:text-white dark:placeholder-gray-300"
                                                onkeyup="filterOptions('item')" />
                                        </div>
                                        <div class="py-1" role="listbox" tabindex="-1"
                                            aria-labelledby="itemDropdown">
                                            <button type="button"
                                                class="item-option w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600"
                                                onclick="selectOption('item', '')">Select Item</button>
                                            <button type="button"
                                                class="item-option w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600"
                                                onclick="selectOption('item', 'ITEM001')">ITEM001</button>
                                            <button type="button"
                                                class="item-option w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600"
                                                onclick="selectOption('item', 'ITEM002')">ITEM002</button>
                                            <button type="button"
                                                class="item-option w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600"
                                                onclick="selectOption('item', 'ITEM003')">ITEM003</button>
                                        </div>
                                    </div>
                                    <input type="hidden" name="item" id="itemInput"
                                        value="{{ request('item') }}">
                                </div>


                            </div>

                            <button type="submit"
                                class="mt-4 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                                Apply Filters
                            </button>

                            <button type="button" id="clearFiltersBtn"
                                class="mt-4 bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-200 px-4 py-2 rounded hover:bg-gray-300">
                                Clear Filters
                            </button>
                        </form>


                        <div class="flex justify-between items-center mb-6">
                            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Sample Inquiry Records</h1>
                            <button onclick="document.getElementById('addSampleModal').classList.remove('hidden')"
                                class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded shadow">
                                + Add New Order
                            </button>
                        </div>

                        <div class="overflow-x-auto bg-white dark:bg-gray-900 shadow rounded-lg">
                            <table class="table-fixed w-full text-sm divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-100 dark:bg-gray-700 text-left">
                                    <tr>
                                        <th
                                            class="px-4 py-3 w-20 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                            Order No</th>
                                        <th
                                            class="px-4 py-3 w-32 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                            Inquiry Receive Date</th>
                                        <th
                                            class="px-4 py-3 w-32 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                            Customer</th>
                                        <th
                                            class="px-4 py-3 w-36 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                            Merchandiser</th>
                                        <th
                                            class="px-4 py-3 w-32 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                            Item</th>
                                        <th
                                            class="px-4 py-3 w-20 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                            Size</th>
                                        <th
                                            class="px-4 py-3 w-32 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                            Colour</th>
                                        <th
                                            class="px-4 py-3 w-32 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                            Sample Quantity</th>
                                        <th
                                            class="px-4 py-3 w-32 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                            Customer Special Comments</th>
                                        <th
                                            class="px-4 py-3 w-32 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                            Customer Requested Dates</th>
                                        <th
                                            class="px-4 py-3 w-32 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                            Development Plan Date</th>
                                        <th
                                            class="px-4 py-3 w-48 text-xs text-center font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                            Action</th>
                                    </tr>
                                </thead>
                                <tbody id="serviceRecords"
                                    class="bg-white dark:bg-gray-800 divide-y text-left divide-gray-200 dark:divide-gray-700">
                                    <tr id="row1">
                                        <!-- Each cell has a span for readonly text and a hidden input for editing -->
                                        <td class="px-4 py-3 w-20 whitespace-normal break-words">
                                            <span class="readonly">001</span>
                                            <input
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="001" />
                                        </td>
                                        <td class="px-4 py-3 w-32 whitespace-normal break-words">
                                            <span class="readonly">2025-05-05</span>
                                            <input type="date"
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="2025-05-05" />
                                        </td>
                                        <td class="px-4 py-3 w-32 whitespace-normal break-words">
                                            <span class="readonly">TIMEX</span>
                                            <input
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="TIMEX" />
                                        </td>
                                        <td class="px-4 py-3 w-36 whitespace-normal break-words">
                                            <span class="readonly">Chamith</span>
                                            <input
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="Chamith" />
                                        </td>
                                        <td class="px-4 py-3 w-32 whitespace-normal break-words">
                                            <span class="readonly">Scock Cord</span>
                                            <input
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="Scock Cord" />
                                        </td>
                                        <td class="px-4 py-3 w-20 whitespace-normal break-words">
                                            <span class="readonly">2mm</span>
                                            <input
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="2mm" />
                                        </td>
                                        <td class="px-4 py-3 w-32 whitespace-normal break-words">
                                            <span class="readonly">white cap grey</span>
                                            <input
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="white cap grey" />
                                        </td>
                                        <td class="px-4 py-3 w-32 whitespace-normal break-words">
                                            <span class="readonly">5 YDS</span>
                                            <input
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="5 YDS" />
                                        </td>
                                        <td class="px-4 py-3 w-32 whitespace-normal break-words">
                                            <span class="readonly"></span>
                                            <input
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm5"
                                                value="" />
                                        </td>
                                        <td class="px-4 py-3 w-32 whitespace-normal break-words">
                                            <span class="readonly">2025-06-05</span>
                                            <input type="date"
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="2025-06-05" />
                                        </td>
                                        <td class="px-4 py-3 w-32 whitespace-normal break-words">
                                            <span class="readonly">2025-06-05</span>
                                            <input type="date"
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="2025-06-05" />
                                        </td>
                                        <td class="px-4 py-3 w-48 text-center whitespace-normal break-words">
                                            <div class="flex space-x-2 justify-center">
                                                <button
                                                    class="bg-green-600 h-10 hover:bg-green-700 text-white px-3 py-1 rounded text-sm"
                                                    onclick="editRow('row1')">Edit</button>
                                                <button
                                                    class="bg-blue-600 h-10 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm hidden"
                                                    onclick="saveRow('row1')">Save</button>
                                                <button
                                                    class="bg-red-600 h-10 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">Download</button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="py-6 flex justify-center">

                            </div>
                        </div>


                        <!-- Add Sample Modal -->
                        <div id="addSampleModal"
                            class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center py-5">
                            <div class="w-full max-w-[700px] bg-white dark:bg-gray-900 rounded-2xl shadow-2xl p-4 transform transition-all scale-95 max-h-[calc(100vh-10rem)] overflow-y-auto"
                                onclick="event.stopPropagation()">
                                <div class="max-w-[600px] mx-auto p-8">
                                    <h2
                                        class="text-2xl font-semibold mb-8 text-blue-900 mt-4 dark:text-gray-100 text-center">
                                        Add New Sample Development
                                    </h2>
                                    <form action="" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="space-y-4">

                                            <!-- File Upload -->
                                            <div class="flex items-center justify-center w-full">
                                                <label for="sampleFile"
                                                    class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50
                                                     dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                                    <div class="flex flex-col items-center justify-center pt-5 pb-6 ">
                                                        <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400"
                                                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                            fill="none" viewBox="0 0 20 16">
                                                            <path stroke="currentColor" stroke-linecap="round"
                                                                stroke-linejoin="round" stroke-width="2"
                                                                d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                                        </svg>
                                                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                                                            <span class="font-semibold">Upload Order soft copy</span>
                                                            or drag and drop
                                                        </p>
                                                        <p class="text-xs text-gray-500 dark:text-gray-400">PDF, JPG
                                                            (MAX. 800x400px)</p>
                                                    </div>
                                                    <input id="sampleFile" name="order_file" type="file"
                                                        class="hidden" accept=".pdf,.jpg,.jpeg" />
                                                </label>
                                            </div>

                                            <!-- Oder Number -->
                                            <div>
                                                <label for="sampleQuantity"
                                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Oder
                                                    Number
                                                </label>
                                                <input id="sampleQuantity" type="text" name="sample_quantity"
                                                    required
                                                    class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm mb-4">
                                            </div>

                                            <!-- Inquiry receive date & Customer -->
                                            <div class="flex gap-4">
                                                <div class="w-1/2">
                                                    <label for="inquiryDate"
                                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Inquiry
                                                        Receive Date</label>
                                                    <input id="inquiryDate" type="date" name="inquiry_date"
                                                        required
                                                        class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                </div>
                                                <div class="w-1/2">
                                                    <label for="customer"
                                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Customer</label>
                                                    <input id="customer" type="text" name="customer" required
                                                        class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                </div>
                                            </div>

                                            <!-- Merchandiser & Item -->
                                            <div class="flex gap-4">
                                                <div class="w-1/2">
                                                    <label for="merchandiser"
                                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Merchandiser</label>
                                                    <input id="merchandiser" type="text" name="merchandiser"
                                                        required
                                                        class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                </div>
                                                <div class="w-1/2">
                                                    <label for="item"
                                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Item</label>
                                                    <input id="item" type="text" name="item" required
                                                        class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                </div>
                                            </div>

                                            <!-- Size & Colour -->
                                            <div class="flex gap-4">
                                                <div class="w-1/2">
                                                    <label for="size"
                                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Size</label>
                                                    <input id="size" type="text" name="size" required
                                                        class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                </div>
                                                <div class="w-1/2">
                                                    <label for="colour"
                                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Colour</label>
                                                    <input id="colour" type="text" name="colour" required
                                                        class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                </div>
                                            </div>

                                            <!-- Sample Quantity -->
                                            <div>
                                                <label for="sampleQuantity"
                                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Sample
                                                    Quantity (yds or mtr)</label>
                                                <input id="sampleQuantity" type="text" name="sample_quantity"
                                                    required
                                                    class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm mb-4">
                                            </div>

                                            <span class="font-sans font-semibold text-m block mb-2">SPECIAL CUSTOMER
                                                COMMENTS & REQUESTED DATES</span>

                                            <!-- Customer Comments & Requested Dates -->
                                            <div class="flex gap-4">
                                                <div class="w-1/2">
                                                    <label for="customerComments"
                                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Customer
                                                        Comments</label>
                                                    <input id="customerComments" type="text"
                                                        name="customer_comments"
                                                        class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                </div>
                                                <div class="w-1/2">
                                                    <label for="requestedDate"
                                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Customer
                                                        Requested Date</label>
                                                    <input id="requestedDate" type="date"
                                                        name="customer_requested_date"
                                                        class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                </div>
                                            </div>

                                        </div>

                                        <!-- Buttons -->
                                        <div class="flex justify-end gap-3 mt-12">
                                            <button type="button"
                                                onclick="document.getElementById('addSampleModal').classList.add('hidden')"
                                                class="px-4 py-2 bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-200 text-sm rounded hover:bg-gray-300">
                                                Cancel
                                            </button>
                                            <button type="submit"
                                                class="px-4 py-2 bg-blue-500 text-white text-sm rounded hover:bg-blue-600">
                                                Create Order
                                            </button>
                                        </div>
                                    </form>
                                </div>
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
        const vehicleInput = document.getElementById('vehicleInput');
        const serviceDateFilter = document.getElementById('serviceDateFilter');
        const nextServiceDateFilter = document.getElementById('nextServiceDateFilter');
        const clearFiltersBtn = document.getElementById('clearFiltersBtn');
        const selectedVehicle = document.getElementById('selectedVehicle');
        const filterForm = document.getElementById('filterForm');

        clearFiltersBtn.addEventListener('click', () => {
            // Clear values
            vehicleInput.value = '';
            serviceDateFilter.value = '';
            nextServiceDateFilter.value = '';
            document.getElementById('customerInput').value = '';
            document.getElementById('merchandiserInput').value = '';
            document.getElementById('itemInput').value = '';

            // Reset dropdown labels
            if (selectedVehicle) selectedVehicle.textContent = 'All Vehicles';
            document.getElementById('selectedCustomer').textContent = 'Select Customer';
            document.getElementById('selectedMerchandiser').textContent = 'Select Merchandiser';
            document.getElementById('selectedItem').textContent = 'Select Item';

            // Submit the form
            filterForm.submit();
        });

    });
</script>


<script>
    function showServiceDetailsModal(service) {
        document.getElementById('viewVehicle').textContent = service.vehicle.license_plate;
        document.getElementById('viewServiceDate').textContent = service.service_date;
        document.getElementById('viewServiceType').textContent = service.service_type || '-';
        document.getElementById('viewMileage').textContent = service.mileage;
        document.getElementById('viewNextMileage').textContent = service.next_service_mileage;
        document.getElementById('viewNextDate').textContent = service.next_service_date;
        document.getElementById('viewLocation').textContent = service.service_location || '-';
        document.getElementById('viewCost').textContent = parseFloat(service.service_cost).toFixed(2);
        document.getElementById('viewNotes').textContent = service.service_notes || 'N/A';

        document.getElementById('viewServiceModal').classList.remove('hidden');
    }
</script>
<script>
    function toggleDropdown(type) {
        const menu = document.getElementById(`${type}DropdownMenu`);
        const btn = document.getElementById(`${type}Dropdown`);
        const expanded = btn.getAttribute('aria-expanded') === 'true';
        menu.classList.toggle('hidden');
        btn.setAttribute('aria-expanded', !expanded);
    }

    function selectOption(type, value) {
        const displayText = value || `Select ${type.charAt(0).toUpperCase() + type.slice(1)}`;
        document.getElementById(`selected${capitalize(type)}`).innerText = value || `All ${capitalize(type)}s`;
        document.getElementById(`${type}Input`).value = value;
        document.getElementById(`${type}DropdownMenu`).classList.add('hidden');
        document.getElementById(`${type}Dropdown`).setAttribute('aria-expanded', false);
    }

    function filterOptions(type) {
        const input = document.getElementById(`${type}SearchInput`).value.toLowerCase();
        const options = document.querySelectorAll(`.${type}-option`);
        options.forEach(option => {
            const text = option.textContent.toLowerCase();
            option.style.display = text.includes(input) ? 'block' : 'none';
        });
    }

    function capitalize(str) {
        return str.charAt(0).toUpperCase() + str.slice(1);
    }

    // Close dropdowns on outside click
    document.addEventListener('click', function(e) {
        ['item', 'customer', 'merchandiser'].forEach(type => {
            const btn = document.getElementById(`${type}Dropdown`);
            const menu = document.getElementById(`${type}DropdownMenu`);
            if (!btn.contains(e.target) && !menu.contains(e.target)) {
                menu.classList.add('hidden');
                btn.setAttribute('aria-expanded', false);
            }
        });
    });
</script>

<script>
    function editRow(rowId) {
        const row = document.getElementById(rowId);
        row.querySelectorAll('.readonly').forEach(span => span.classList.add('hidden'));
        row.querySelectorAll('.editable').forEach(input => input.classList.remove('hidden'));
        row.querySelector('button.bg-green-600').classList.add('hidden'); // Hide Edit button
        row.querySelector('button.bg-blue-600').classList.remove('hidden'); // Show Save button
    }

    function saveRow(rowId) {
        const row = document.getElementById(rowId);
        const inputs = row.querySelectorAll('.editable');
        const spans = row.querySelectorAll('.readonly');

        inputs.forEach((input, i) => {
            spans[i].textContent = input.value;
            input.classList.add('hidden');
        });
        spans.forEach(span => span.classList.remove('hidden'));

        row.querySelector('button.bg-green-600').classList.remove('hidden'); // Show Edit button
        row.querySelector('button.bg-blue-600').classList.add('hidden'); // Hide Save button
    }
</script>
