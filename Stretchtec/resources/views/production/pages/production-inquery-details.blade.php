@php use Illuminate\Support\Facades\Auth; @endphp
<head>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <!-- Include Flatpickr (CDN) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <title>Stretchtec</title>
</head>

<div class="flex h-full w-full">
    @extends('layouts.production-tabs')

    @section('content')
        <div class="flex-1 overflow-y-hidden mb-20">
            <div class="">
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

                            <div class="flex justify-between items-center mb-6">
                                <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Production Inquiry
                                    Records
                                </h1>
                                <button onclick="document.getElementById('addSampleModal').classList.remove('hidden')"
                                        class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded shadow">
                                    + Add New Production Order
                                </button>
                            </div>

                            <!-- Add Sample Modal -->
                            <div id="addSampleModal"
                                 class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center py-5">
                                <div
                                    class="w-full max-w-[700px] bg-white dark:bg-gray-900 rounded-2xl shadow-2xl p-4 transform transition-all scale-95 max-h-[calc(100vh-10rem)] overflow-y-auto"
                                    onclick="event.stopPropagation()">
                                    <div class="max-w-[600px] mx-auto p-8">
                                        <h2
                                            class="text-2xl font-semibold mb-8 text-blue-900 mt-4 dark:text-gray-100 text-center">
                                            Add New Production Order
                                        </h2>
                                        <form action="" method="POST" enctype="multipart/form-data">
                                            @csrf

                                            <!-- ORDER TYPE TOGGLE -->
                                            <div class="mb-6">
                                                <label
                                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Order
                                                    Type</label>

                                                <!-- Tab-style toggle -->
                                                <div
                                                    class="flex space-x-4 mt-3 border-b border-gray-300 dark:border-gray-700">
                                                    <button type="button"
                                                            onclick="setOrderType('sample')"
                                                            id="tab-sample"
                                                            class="pb-2 px-3 font-semibold border-b-2 border-blue-500 text-blue-600">
                                                        From Sample
                                                    </button>
                                                    <button type="button"
                                                            onclick="setOrderType('direct')"
                                                            id="tab-direct"
                                                            class="pb-2 px-3 font-semibold text-gray-600 dark:text-gray-300 hover:text-blue-500">
                                                        Direct Order
                                                    </button>
                                                </div>

                                                <!-- Hidden input to send selected type -->
                                                <input type="hidden" name="order_type" id="order_type" value="sample">
                                            </div>

                                            <!-- DIRECT ORDER FIELDS -->
                                            <div id="directOrderFields" class="space-y-4 hidden">
                                                <!-- Reference Number -->
                                                <div>
                                                    <label for="referenceNumber"
                                                           class="block text-sm font-medium text-gray-700 dark:text-gray-300">Reference
                                                        Number</label>
                                                    <input id="referenceNumber" type="text" name="referenceNumber"
                                                           class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                </div>

                                                <!-- PO Number -->
                                                <div class="flex gap-4">
                                                    <div class="w-1/2">
                                                        <label for="poNumber"
                                                               class="block text-sm font-medium text-gray-700 dark:text-gray-300">PO
                                                            Number</label>
                                                        <input id="poNumber" type="text" name="po_number"
                                                               class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                    </div>
                                                    <div class="w-1/2">
                                                        <label
                                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Customer
                                                            Coordinator</label>
                                                        <input id="customerCoordinator" type="text" readonly
                                                               class="w-full mt-1 px-3 py-2 border rounded-md bg-gray-100 dark:bg-gray-600 text-sm"
                                                               value="{{Auth::user()->name}}">
                                                    </div>
                                                </div>

                                                <!-- Shade & Colour -->
                                                <div class="flex gap-4">
                                                    <div class="w-1/2">
                                                        <label for="shade"
                                                               class="block text-sm font-medium text-gray-700 dark:text-gray-300">Shade</label>
                                                        <input id="shade" type="text" name="shade"
                                                               class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                    </div>
                                                    <div class="w-1/2">
                                                        <label for="colour"
                                                               class="block text-sm font-medium text-gray-700 dark:text-gray-300">Colour</label>
                                                        <input id="colour" type="text" name="colour"
                                                               class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                    </div>
                                                </div>

                                                <!-- Size & Quantity -->
                                                <div class="flex gap-4">
                                                    <div class="w-1/2">
                                                        <label for="size"
                                                               class="block text-sm font-medium text-gray-700 dark:text-gray-300">Size</label>
                                                        <input id="size" type="text" name="size"
                                                               class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                    </div>
                                                    <div class="w-1/2">
                                                        <label for="qtyRequested"
                                                               class="block text-sm font-medium text-gray-700 dark:text-gray-300">Quantity
                                                        </label>
                                                        <input id="qtyRequested" type="text" name="qty_requested"
                                                               class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                    </div>
                                                </div>

                                                <!-- Customer name & TKT -->
                                                <div class="flex gap-4">
                                                    <div class="w-1/2">
                                                        <label for="item"
                                                               class="block text-sm font-medium text-gray-700 dark:text-gray-300">Item</label>
                                                        <input id="item" type="text" name="item"
                                                               class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                    </div>
                                                    <div class="w-1/2">
                                                        <label for="tkt"
                                                               class="block text-sm font-medium text-gray-700 dark:text-gray-300">TKT</label>
                                                        <input id="tkt" type="text" name="tkt"
                                                               class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                    </div>
                                                </div>


                                                <!-- Customer Merchandiser & TKT -->
                                                <div class="flex gap-4">
                                                    <div class="w-1/2">
                                                        <label for="customerMerchandiser"
                                                               class="block text-sm font-medium text-gray-700 dark:text-gray-300">Customer
                                                            Merchandiser</label>
                                                        <input id="customerMerchandiser" type="text"
                                                               name="customer_merchandiser"
                                                               class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                    </div>
                                                    <div class="w-1/2">
                                                        <label for="customerName"
                                                               class="block text-sm font-medium text-gray-700 dark:text-gray-300">Customer
                                                            Name</label>
                                                        <input id="customerName" type="text"
                                                               name="customerName"
                                                               class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                    </div>
                                                </div>

                                                <!-- Customer Requested Date & Notes -->
                                                <div class="flex gap-4">
                                                    <div class="w-1/2">
                                                        <label for="totalValue"
                                                               class="block text-sm font-medium text-gray-700 dark:text-gray-300">PO
                                                            Value</label>
                                                        <input id="totalValue" type="text" name="totalValue"
                                                               class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                    </div>
                                                    <div class="w-1/2">
                                                        <label for="customerRequestedDate"
                                                               class="block text-sm font-medium text-gray-700 dark:text-gray-300">Customer
                                                            Requested Date</label>
                                                        <input id="customerRequestedDate" type="date"
                                                               name="customer_requested_date"
                                                               class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                    </div>
                                                </div>

                                                <div class="flex gap-4">
                                                    <div class="w-1/2">
                                                        <label for="customerNotes"
                                                               class="block text-sm font-medium text-gray-700 dark:text-gray-300">Customer
                                                            Notes</label>
                                                        <input id="customerNotes" type="text" name="customer_notes"
                                                               class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- SAMPLE ORDER FIELDS (Default Visible) -->
                                            <div id="sampleOrderFields" class="space-y-4">
                                                <!-- Select Reference Number -->
                                                <!-- Dropdown Button -->
                                                <div class="relative">
                                                    <button type="button" id="sampleReferenceDropdown"
                                                            class="inline-flex w-full justify-between rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm
                                                               ring-1 ring-gray-300 hover:bg-gray-50 h-10
                                                               dark:bg-gray-700 dark:text-white dark:ring-gray-600"
                                                            onclick="toggleDropdown('sampleReference')"
                                                            aria-haspopup="listbox"
                                                            aria-expanded="false">
                                                        <span
                                                            id="selectedSampleReference">Select Sample Reference</span>
                                                        <svg class="ml-2 h-5 w-5 text-gray-400" viewBox="0 0 20 20"
                                                             fill="currentColor">
                                                            <path fill-rule="evenodd"
                                                                  d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 10.94l3.71-3.71a.75.75 0 1 1 1.06
                                                                 1.06l-4.24 4.24a.75.75 0 0 1-1.06 0L5.25
                                                                 8.29a.75.75 0 0 1-.02-1.08z"
                                                                  clip-rule="evenodd"/>
                                                        </svg>
                                                    </button>

                                                    <!-- Dropdown Menu -->
                                                    <div id="dropdownMenusampleReference"
                                                         class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base
                                                            ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none
                                                            hidden dark:bg-gray-700 dark:text-white sm:text-sm">

                                                        <!-- Search Box -->
                                                        <div class="sticky top-0 bg-white dark:bg-gray-700 px-2 py-1">
                                                            <input type="text" id="sampleSearchInput"
                                                                   placeholder="Search reference..."
                                                                   onkeyup="filterSamples()"
                                                                   class="w-full px-2 py-1 text-sm border rounded-md focus:outline-none focus:ring focus:ring-indigo-500
                                                                     dark:bg-gray-600 dark:text-white dark:border-gray-500"/>
                                                        </div>

                                                        <!-- Options -->
                                                        <ul id="sampleOptions" class="max-h-48 overflow-y-auto">
                                                            @foreach($samples as $sample)
                                                                <li class="cursor-pointer select-none px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-600"
                                                                    onclick="selectSampleReference('{{ $sample->id }}', '{{ $sample->reference_no }}')">
                                                                    {{ $sample->reference_no }}
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>

                                                <!-- Hidden input to hold selected value -->
                                                <input type="hidden" name="sample_reference" id="sampleReferenceHidden">

                                                <!-- Auto-filled fields -->
                                                <div class="flex gap-4">
                                                    <div class="w-1/2">
                                                        <label
                                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Shade</label>
                                                        <input id="sampleShade" type="text" readonly
                                                               class="w-full mt-1 px-3 py-2 border rounded-md bg-gray-100 dark:bg-gray-600 text-sm">
                                                    </div>
                                                    <div class="w-1/2">
                                                        <label
                                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Colour</label>
                                                        <input id="sampleColour" type="text" readonly
                                                               class="w-full mt-1 px-3 py-2 border rounded-md bg-gray-100 dark:bg-gray-600 text-sm">
                                                    </div>
                                                </div>

                                                <div class="flex gap-4">
                                                    <div class="w-1/2">
                                                        <label
                                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">TKT</label>
                                                        <input id="sampleTKT" type="text" readonly
                                                               class="w-full mt-1 px-3 py-2 border rounded-md bg-gray-100 dark:bg-gray-600 text-sm">
                                                    </div>
                                                    <div class="w-1/2">
                                                        <label
                                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Size</label>
                                                        <input id="sampleSize" type="text" readonly
                                                               class="w-full mt-1 px-3 py-2 border rounded-md bg-gray-100 dark:bg-gray-600 text-sm">
                                                    </div>
                                                </div>

                                                <div class="flex gap-4">
                                                    <div class="w-1/2">
                                                        <label
                                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Item</label>
                                                        <input id="sampleItem" type="text" readonly
                                                               class="w-full mt-1 px-3 py-2 border rounded-md bg-gray-100 dark:bg-gray-600 text-sm">
                                                    </div>

                                                    <div class="w-1/2">
                                                        <label
                                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Supplier</label>
                                                        <input id="sampleSupplier" type="text" readonly
                                                               class="w-full mt-1 px-3 py-2 border rounded-md bg-gray-100 dark:bg-gray-600 text-sm">
                                                    </div>
                                                </div>

                                                <div class="flex gap-4">
                                                    <div class="w-1/2">
                                                        <label
                                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Customer
                                                            Coordinator</label>
                                                        <input id="customerCoordinator" type="text" readonly
                                                               class="w-full mt-1 px-3 py-2 border rounded-md bg-gray-100 dark:bg-gray-600 text-sm"
                                                               value="{{Auth::user()->name}}">
                                                    </div>
                                                </div>

                                                <!-- Editable fields -->
                                                <div class="flex gap-4">
                                                    <div class="w-1/2">
                                                        <label for="sampleQty"
                                                               class="block text-sm font-medium text-gray-700 dark:text-gray-300">Quantity</label>
                                                        <input id="sampleQty" type="text" name="qty"
                                                               class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                    </div>
                                                    <div class="w-1/2">
                                                        <label for="samplePoNumber"
                                                               class="block text-sm font-medium text-gray-700 dark:text-gray-300">PO
                                                            Number</label>
                                                        <input id="samplePoNumber" type="text" name="po_number_sample"
                                                               class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                    </div>
                                                </div>

                                                <div class="flex gap-4">
                                                    <div class="w-1/2">
                                                        <label for="customerName"
                                                               class="block text-sm font-medium text-gray-700 dark:text-gray-300">Customer
                                                            Name</label>
                                                        <input id="customerName" type="text" name="customerName"
                                                               class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                    </div>
                                                    <div class="w-1/2">
                                                        <label for="customerMerchandiser"
                                                               class="block text-sm font-medium text-gray-700 dark:text-gray-300">Customer
                                                            Merchandiser</label>
                                                        <input id="customerMerchandiser" type="text"
                                                               name="customerMerchandiser"
                                                               class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                    </div>
                                                </div>

                                                <div class="flex gap-4">
                                                    <div class="w-1/2">
                                                        <label for="totalValue"
                                                               class="block text-sm font-medium text-gray-700 dark:text-gray-300">PO
                                                            Value</label>
                                                        <input id="totalValue" type="text" name="totalValue"
                                                               class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                    </div>
                                                    <div class="w-1/2">
                                                        <label for="sampleCustomerRequestedDate"
                                                               class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                                            Customer Requested Date
                                                        </label>
                                                        <input id="sampleCustomerRequestedDate"
                                                               type="text"
                                                               name="customer_requested_date_sample"
                                                               placeholder="Select a date"
                                                               class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm focus:ring focus:ring-indigo-500">
                                                    </div>
                                                </div>

                                                <div class="flex gap-4">
                                                    <div class="w-1/2">
                                                        <label for="customerNotes"
                                                               class="block text-sm font-medium text-gray-700 dark:text-gray-300">Customer
                                                            Notes</label>
                                                        <input id="customerNotes" type="text" name="customer_notes"
                                                               class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
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

                            <div id="productionDetailsScroll"
                                 class="overflow-x-auto max-h-[1200px] bg-white dark:bg-gray-900 shadow rounded-lg relative">
                                <table
                                    class="table-fixed min-w-[1400px] text-sm divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead class="bg-gray-200 dark:bg-gray-700 text-left">
                                    <tr class="text-center">
                                        <th
                                            class="font-bold sticky left-0 top-0 z-20 bg-white px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                            Order No
                                        </th>
                                        <th class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 text-xs uppercase text-gray-600 dark:text-gray-300">
                                            Reference Number
                                        </th>
                                        <th class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 text-xs uppercase text-gray-600 dark:text-gray-300">
                                            PO Number
                                        </th>
                                        <th class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 text-xs uppercase text-gray-600 dark:text-gray-300">
                                            Customer Coordinator
                                        </th>
                                        <th class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 text-xs uppercase text-gray-600 dark:text-gray-300">
                                            Quantity
                                        </th>
                                        <th class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 text-xs uppercase text-gray-600 dark:text-gray-300">
                                            Customer Name
                                        </th>
                                        <th class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 text-xs uppercase text-gray-600 dark:text-gray-300">
                                            Customer Merchandiser
                                        </th>
                                        <th class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 text-xs uppercase text-gray-600 dark:text-gray-300">
                                            PO Value
                                        </th>
                                        <th class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 text-xs uppercase text-gray-600 dark:text-gray-300">
                                            Customer Requested Date
                                        </th>
                                        <th class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 text-xs uppercase text-gray-600 dark:text-gray-300">
                                            Customer Notes
                                        </th>

                                        <th class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 text-xs uppercase text-gray-600 dark:text-gray-300">
                                            Send to Stock
                                        </th>

                                        <th class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 text-xs uppercase text-gray-600 dark:text-gray-300">
                                            Send to Production
                                        </th>

                                        <th class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 text-xs uppercase text-gray-600 dark:text-gray-300">
                                            Status
                                        </th>
                                        <th class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 text-xs uppercase text-gray-600 dark:text-gray-300">
                                            Action
                                        </th>
                                    </tr>
                                    </thead>

                                    <tbody id="productionDetailsRecords"
                                           class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">

                                    <tr id="row1"
                                        class="odd:bg-white even:bg-gray-50 border-b border-gray-200 text-center">

                                        <!-- Production ID -->
                                        <td class="sticky left-0 z-10 px-4 py-3 bg-gray-100 whitespace-normal break-words border-r border-gray-300">
                                            <span class="readonly font-bold">ST-PD-001</span>
                                        </td>

                                        <!-- Reference Number (Clickable for modal) -->
                                        <td class="px-4 py-3 border-r border-gray-300">
                                            <button type="button"
                                                    class="text-blue-600 font-bold underline"
                                                    onclick="openDetailsModal(this)"
                                                    data-ref-no="REF-001"
                                                    data-shade="Light Blue"
                                                    data-colour="Navy"
                                                    data-item="Twill Tape"
                                                    data-tkt="TKT-45"
                                                    data-size="M"
                                                    data-supplier="ABC Textiles">
                                                REF-001
                                            </button>
                                        </td>

                                        <!-- PO Number -->
                                        <td class="px-4 py-3 border-r border-gray-300">
                                            <span class="readonly">PO-789</span>
                                        </td>

                                        <!-- Customer Coordinator -->
                                        <td class="px-4 py-3 border-r border-gray-300">
                                            <span class="readonly">John Doe</span>
                                        </td>

                                        <!-- Quantity -->
                                        <td class="px-4 py-3 border-r border-gray-300">
                                            <span class="readonly">100</span>
                                        </td>

                                        <!-- Customer Name -->
                                        <td class="px-4 py-3 border-r border-gray-300">
                                            <span class="readonly">XYZ Garments</span>
                                        </td>

                                        <!-- Customer Merchandiser -->
                                        <td class="px-4 py-3 border-r border-gray-300">
                                            <span class="readonly">Jane Smith</span>
                                        </td>

                                        <!-- PO Value -->
                                        <td class="px-4 py-3 border-r border-gray-300">
                                            <span class="readonly">$2500</span>
                                        </td>

                                        <!-- Customer Requested Date -->
                                        <td class="px-4 py-3 border-r border-gray-300">
                                            <span class="readonly">2025-09-30</span>
                                        </td>

                                        <!-- Customer Notes -->
                                        <td class="px-4 py-3 border-r border-gray-300">
                                            <span class="readonly">Urgent delivery</span>
                                        </td>

                                        <!-- Send to Stock -->
                                        <td class="px-4 py-3 border-r border-gray-300">

                                        </td>

                                        <!-- Send to Production -->
                                        <td class="px-4 py-3 border-r border-gray-300">

                                        </td>

                                        <!-- Status -->
                                        <td class="px-4 py-3 border-r border-gray-300">

                                        </td>

                                        <!-- Action -->
                                        <td class="px-4 py-3 border-r border-gray-300">
                                            <div class="flex justify-center gap-2">
                                                <!-- Edit Button -->
                                                <button type="button"
                                                        onclick="enableEdit('row1')"
                                                        class="bg-yellow-500 hover:bg-yellow-600 text-white h-10 w-20 rounded text-sm">
                                                    Edit
                                                </button>

                                                <!-- Delete Button -->
                                                <form id="delete-form-1" method="POST" class="flex items-center">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button"
                                                            onclick="confirmDelete('1')"
                                                            class="bg-red-600 hover:bg-red-700 text-white h-10 w-20 rounded text-sm">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>

                                <!-- Details Modal -->
                                <div id="detailsModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
                                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-1/3 p-6">
                                        <h2 class="text-xl font-bold mb-4">Order Details</h2>
                                        <div id="modalContent" class="space-y-2">
                                            <!-- Details will be injected dynamically -->
                                        </div>
                                        <div class="mt-4 flex justify-end">
                                            <button onclick="closeDetailsModal()"
                                                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">
                                                Close
                                            </button>
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
    function toggleOrderType(type) {
        document.getElementById('directOrderFields').classList.toggle('hidden', type !== 'direct');
        document.getElementById('sampleOrderFields').classList.toggle('hidden', type !== 'sample');
    }
</script>

<script>
    function openDetailsModal(button) {
        const refNumber = button.dataset.refNo;
        const shade = button.dataset.shade;
        const colour = button.dataset.colour;
        const item = button.dataset.item;
        const tkt = button.dataset.tkt;
        const size = button.dataset.size;
        const supplier = button.dataset.supplier;

        document.getElementById("modalContent").innerHTML = `
        <p><strong>Ref No:</strong> ${refNumber}</p>
        <p><strong>Shade:</strong> ${shade}</p>
        <p><strong>Colour:</strong> ${colour}</p>
        <p><strong>Item:</strong> ${item}</p>
        <p><strong>TKT:</strong> ${tkt}</p>
        <p><strong>Size:</strong> ${size}</p>
        <p><strong>Supplier:</strong> ${supplier}</p>
    `;

        document.getElementById("detailsModal").classList.remove("hidden");
    }

    function closeDetailsModal() {
        document.getElementById("detailsModal").classList.add("hidden");
    }
</script>

<script>
    function setOrderType(type) {
        const directFields = document.getElementById('directOrderFields');
        const sampleFields = document.getElementById('sampleOrderFields');
        const orderTypeInput = document.getElementById('order_type');

        // reset tab styles
        document.getElementById('tab-direct').classList.remove('border-b-2', 'border-blue-500', 'text-blue-600');
        document.getElementById('tab-direct').classList.add('text-gray-600', 'dark:text-gray-300');

        document.getElementById('tab-sample').classList.remove('border-b-2', 'border-blue-500', 'text-blue-600');
        document.getElementById('tab-sample').classList.add('text-gray-600', 'dark:text-gray-300');

        if (type === 'direct') {
            directFields.classList.remove('hidden');
            sampleFields.classList.add('hidden');
            orderTypeInput.value = 'direct';
            document.getElementById('tab-direct').classList.add('border-b-2', 'border-blue-500', 'text-blue-600');
        } else {
            sampleFields.classList.remove('hidden');
            directFields.classList.add('hidden');
            orderTypeInput.value = 'sample';
            document.getElementById('tab-sample').classList.add('border-b-2', 'border-blue-500', 'text-blue-600');
        }
    }
</script>

<script>
    function toggleDropdown(id) {
        document.getElementById(`dropdownMenu${id}`).classList.toggle('hidden');
    }

    function selectSampleReference(id, referenceNo) {
        document.getElementById('selectedSampleReference').textContent = referenceNo;
        document.getElementById('sampleReferenceHidden').value = id;
        document.getElementById('dropdownMenusampleReference').classList.add('hidden');

        // If you want to trigger fetching details when selected
        if (typeof fetchSampleDetails === "function") {
            fetchSampleDetails(id);
        }
    }

    function filterSamples() {
        let input = document.getElementById('sampleSearchInput');
        let filter = input.value.toLowerCase();
        let options = document.getElementById("sampleOptions").getElementsByTagName("li");

        for (let i = 0; i < options.length; i++) {
            let txtValue = options[i].textContent || options[i].innerText;
            if (txtValue.toLowerCase().indexOf(filter) > -1) {
                options[i].style.display = "";
            } else {
                options[i].style.display = "none";
            }
        }
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function (event) {
        const dropdown = document.getElementById('dropdownMenusampleReference');
        const button = document.getElementById('sampleReferenceDropdown');

        if (!dropdown.contains(event.target) && !button.contains(event.target)) {
            dropdown.classList.add('hidden');
        }
    });

</script>

<script>
    flatpickr("#sampleCustomerRequestedDate", {
        minDate: "today",
        dateFormat: "Y-m-d",
        onDayCreate: function (dObj, dStr, fp, dayElem) {
            const today = new Date();
            const dayDate = new Date(dayElem.dateObj);
            const diffDays = Math.floor((dayDate - today) / (1000 * 60 * 60 * 24));

            // Style based on range
            if (diffDays >= 0 && diffDays <= 10) {
                dayElem.classList.add("bg-red-200", "text-red-800", "rounded-md");
            } else if (diffDays > 10 && diffDays <= 20) {
                dayElem.classList.add("bg-yellow-200", "text-yellow-800", "rounded-md");
            } else if (diffDays > 20) {
                dayElem.classList.add("bg-green-200", "text-green-800", "rounded-md");
            }
        }
    });
</script>
@endsection
