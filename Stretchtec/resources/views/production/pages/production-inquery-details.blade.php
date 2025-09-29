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
                                        <h2 class="text-2xl font-semibold mb-8 text-blue-900 mt-4 dark:text-gray-100 text-center">
                                            Add New Production Order
                                        </h2>

                                        <!-- TABS -->
                                        <div class="mb-6">
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Order
                                                Type</label>
                                            <div
                                                class="flex space-x-4 mt-3 border-b border-gray-300 dark:border-gray-700">
                                                <button type="button" onclick="setOrderType('sample')" id="tab-sample"
                                                        class="pb-2 px-3 font-semibold">
                                                    From Sample
                                                </button>
                                                <button type="button" onclick="setOrderType('direct')" id="tab-direct"
                                                        class="pb-2 px-3 font-semibold">
                                                    Direct Order
                                                </button>
                                            </div>
                                        </div>

                                        <!-- ================= Direct ORDER FORM ================= -->
                                        <form id="directForm" class="space-y-4 hidden"
                                              action="{{ route('production-inquery-details.store') }}" method="POST"
                                              enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="order_type" value="direct">

                                            <!-- Reference Number -->
                                            <div>
                                                <label for="direct_reference_no"
                                                       class="block text-sm font-medium text-gray-700 dark:text-gray-300">Reference
                                                    Number</label>
                                                <input id="direct_reference_no" type="text" name="reference_no"
                                                       class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                            </div>

                                            <!-- PO Number & Coordinator -->
                                            <div class="flex gap-4">
                                                <div class="w-1/2">
                                                    <label for="direct_po_number"
                                                           class="block text-sm font-medium text-gray-700 dark:text-gray-300">PO
                                                        Number</label>
                                                    <input id="direct_po_number" type="text" name="po_number"
                                                           class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                </div>
                                                <div class="w-1/2">
                                                    <label
                                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Customer
                                                        Coordinator</label>
                                                    <input id="direct_customer_coordinator" type="text" readonly
                                                           name="customer_coordinator"
                                                           value="{{ Auth::user()->name }}"
                                                           class="w-full mt-1 px-3 py-2 border rounded-md bg-gray-100 dark:bg-gray-600 text-sm">
                                                </div>
                                            </div>

                                            <!-- Shade & Colour -->
                                            <div class="flex gap-4">
                                                <div class="w-1/2">
                                                    <label for="direct_shade"
                                                           class="block text-sm font-medium text-gray-700 dark:text-gray-300">Shade</label>
                                                    <input id="direct_shade" type="text" name="shade"
                                                           class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                </div>
                                                <div class="w-1/2">
                                                    <label for="direct_color"
                                                           class="block text-sm font-medium text-gray-700 dark:text-gray-300">Colour</label>
                                                    <input id="direct_color" type="text" name="color"
                                                           class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                </div>
                                            </div>

                                            <!-- Size, Qty, UoM -->
                                            <div class="flex gap-4">
                                                <div class="w-1/3">
                                                    <label for="direct_size"
                                                           class="block text-sm font-medium text-gray-700 dark:text-gray-300">Size</label>
                                                    <input id="direct_size" type="text" name="size"
                                                           class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                </div>
                                                <div class="w-1/3">
                                                    <label for="direct_qty"
                                                           class="block text-sm font-medium text-gray-700 dark:text-gray-300">Quantity</label>
                                                    <input id="direct_qty" type="number" name="qty" min="0"
                                                           class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                </div>
                                                <div class="w-1/3">
                                                    <label for="direct_uom"
                                                           class="block text-sm font-medium text-gray-700 dark:text-gray-300">Unit</label>
                                                    <select id="direct_uom" name="uom"
                                                            class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                        <option value="meters">Meters</option>
                                                        <option value="yards">Yards</option>
                                                        <option value="pieces">Pieces</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Item & TKT -->
                                            <div class="flex gap-4">
                                                <div class="w-1/2">
                                                    <label for="direct_item"
                                                           class="block text-sm font-medium text-gray-700 dark:text-gray-300">Item</label>
                                                    <input id="direct_item" type="text" name="item"
                                                           class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                </div>
                                                <div class="w-1/2">
                                                    <label for="direct_tkt"
                                                           class="block text-sm font-medium text-gray-700 dark:text-gray-300">TKT</label>
                                                    <input id="direct_tkt" type="text" name="tkt"
                                                           class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                </div>
                                            </div>

                                            <!-- Merchandiser & Customer -->
                                            <div class="flex gap-4">
                                                <div class="w-1/2">
                                                    <label for="direct_merchandiser_name"
                                                           class="block text-sm font-medium text-gray-700 dark:text-gray-300">Customer
                                                        Merchandiser</label>
                                                    <input id="direct_merchandiser_name" type="text"
                                                           name="merchandiser_name"
                                                           class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                </div>
                                                <div class="w-1/2">
                                                    <label for="direct_customer_name"
                                                           class="block text-sm font-medium text-gray-700 dark:text-gray-300">Customer
                                                        Name</label>
                                                    <input id="direct_customer_name" type="text" name="customer_name"
                                                           class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                </div>
                                            </div>

                                            <!-- Price & Requested Date -->
                                            <div class="flex gap-4">
                                                <div class="w-1/2">
                                                    <label for="direct_price"
                                                           class="block text-sm font-medium text-gray-700 dark:text-gray-300">PO
                                                        Value</label>
                                                    <input id="direct_price" type="number" step="0.01" name="price"
                                                           class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                </div>
                                                <div class="w-1/2">
                                                    <label for="direct_customer_req_date"
                                                           class="block text-sm font-medium text-gray-700 dark:text-gray-300">Customer
                                                        Requested Date</label>
                                                    <input id="direct_customer_req_date" type="date"
                                                           name="customer_req_date"
                                                           class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                </div>
                                            </div>

                                            <!-- Remarks -->
                                            <div>
                                                <label for="direct_remarks"
                                                       class="block text-sm font-medium text-gray-700 dark:text-gray-300">Customer
                                                    Notes</label>
                                                <input id="direct_remarks" type="text" name="remarks"
                                                       class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                            </div>

                                            <div class="flex justify-end gap-3 mt-6">
                                                <button type="button"
                                                        onclick="document.getElementById('addSampleModal').classList.add('hidden')"
                                                        class="px-4 py-2 bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-200 text-sm rounded hover:bg-gray-300">
                                                    Cancel
                                                </button>
                                                <button type="submit"
                                                        class="px-4 py-2 bg-blue-500 text-white text-sm rounded hover:bg-blue-600">
                                                    Create Direct Order
                                                </button>
                                            </div>
                                        </form>

                                        <!-- ================= Sample ORDER FORM ================= -->
                                        <form id="sampleForm" class="space-y-4"
                                              action="{{ route('production-inquery-details.store') }}" method="POST"
                                              enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="order_type" value="sample">

                                            <!-- SAMPLE REFERENCE DROPDOWN -->
                                            <div class="relative">
                                                <button type="button" id="sampleReferenceDropdown"
                                                        class="inline-flex w-full justify-between rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-gray-300 hover:bg-gray-50 h-10 dark:bg-gray-700 dark:text-white dark:ring-gray-600"
                                                        onclick="toggleDropdown('sampleReference')"
                                                        aria-haspopup="listbox" aria-expanded="false">
                                                    <span id="selectedSampleReference">Select Sample Reference</span>
                                                    <svg class="ml-2 h-5 w-5 text-gray-400" viewBox="0 0 20 20"
                                                         fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                              d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 10.94l3.71-3.71a.75.75 0 1 1 1.06 1.06l-4.24 4.24a.75.75 0 0 1-1.06 0L5.25 8.29a.75.75 0 0 1-.02-1.08z"
                                                              clip-rule="evenodd"/>
                                                    </svg>
                                                </button>

                                                <div id="dropdownMenusampleReference"
                                                     class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto hidden dark:bg-gray-700 dark:text-white sm:text-sm">
                                                    <div class="sticky top-0 bg-white dark:bg-gray-700 px-2 py-1">
                                                        <input type="text" id="sampleSearchInput"
                                                               placeholder="Search reference..."
                                                               onkeyup="filterSamples()"
                                                               class="w-full px-2 py-1 text-sm border rounded-md focus:outline-none focus:ring focus:ring-indigo-500 dark:bg-gray-600 dark:text-white dark:border-gray-500"/>
                                                    </div>
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

                                            <!-- Hidden ref value (will be sent as reference_no) -->
                                            <input type="hidden" name="reference_no" id="sampleReferenceHidden">

                                            <!-- Auto-filled fields (unique IDs for sample form) -->
                                            <div class="flex gap-4">
                                                <div class="w-1/2">
                                                    <label
                                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Shade</label>
                                                    <input id="sampleShade" type="text" name="shade" readonly
                                                           class="editable w-full mt-1 px-3 py-2 border rounded-md bg-gray-100 dark:bg-gray-600 text-sm">
                                                </div>
                                                <div class="w-1/2">
                                                    <label
                                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Colour</label>
                                                    <input id="sampleColour" type="text" name="color" readonly
                                                           class="editable w-full mt-1 px-3 py-2 border rounded-md bg-gray-100 dark:bg-gray-600 text-sm">
                                                </div>
                                            </div>

                                            <div class="flex gap-4">
                                                <div class="w-1/2">
                                                    <label
                                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">TKT</label>
                                                    <input id="sampleTKT" type="text" name="tkt" readonly
                                                           class="editable w-full mt-1 px-3 py-2 border rounded-md bg-gray-100 dark:bg-gray-600 text-sm">
                                                </div>
                                                <div class="w-1/2">
                                                    <label
                                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Size</label>
                                                    <input id="sampleSize" type="text" name="size" readonly
                                                           class="editable w-full mt-1 px-3 py-2 border rounded-md bg-gray-100 dark:bg-gray-600 text-sm">
                                                </div>
                                            </div>

                                            <div class="flex gap-4">
                                                <div class="w-1/2">
                                                    <label
                                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Item</label>
                                                    <input id="sampleItem" type="text" name="item" readonly
                                                           class="editable w-full mt-1 px-3 py-2 border rounded-md bg-gray-100 dark:bg-gray-600 text-sm">
                                                </div>
                                                <div class="w-1/2">
                                                    <label
                                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Supplier</label>
                                                    <input id="sampleSupplier" type="text" name="supplier" readonly
                                                           class="editable w-full mt-1 px-3 py-2 border rounded-md bg-gray-100 dark:bg-gray-600 text-sm">
                                                </div>
                                            </div>

                                            <div class="flex gap-4">
                                                <div class="w-1/2">
                                                    <label
                                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">PST
                                                        No</label>
                                                    <input id="samplePSTNo" type="text" name="pst_no" readonly
                                                           class="editable w-full mt-1 px-3 py-2 border rounded-md bg-gray-100 dark:bg-gray-600 text-sm">
                                                </div>
                                                <div class="w-1/2">
                                                    <label
                                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Supplier
                                                        Comment</label>
                                                    <input id="sampleSupplierComment" type="text"
                                                           name="supplier_comment" readonly
                                                           class="editable w-full mt-1 px-3 py-2 border rounded-md bg-gray-100 dark:bg-gray-600 text-sm">
                                                </div>
                                            </div>

                                            <!-- Coordinator (always readonly) -->
                                            <div class="flex gap-4">
                                                <div class="w-1/2">
                                                    <label
                                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                                        Customer Coordinator
                                                    </label>
                                                    <input id="sample_customer_coordinator" type="text"
                                                           name="customer_coordinator" readonly
                                                           value="{{ Auth::user()->name }}"
                                                           class="w-full mt-1 px-3 py-2 border rounded-md bg-gray-100 dark:bg-gray-600 text-sm">
                                                </div>

                                                <!-- Centered Edit Button -->
                                                <div class="w-1/2">
                                                    <label
                                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                                        For customized order
                                                    </label>
                                                    <button type="button" id="editButton"
                                                            class="px-4 py-1 mt-1 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                                        Edit
                                                    </button>
                                                </div>
                                            </div>

                                            <!-- Editable sample fields -->
                                            <div class="flex gap-4">
                                                <div class="w-1/3">
                                                    <label for="sampleQty"
                                                           class="block text-sm font-medium text-gray-700 dark:text-gray-300">Quantity</label>
                                                    <input id="sampleQty" type="number" name="qty" min="0" required
                                                           class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                </div>
                                                <div class="w-1/3">
                                                    <label for="direct_uom"
                                                           class="block text-sm font-medium text-gray-700 dark:text-gray-300">Unit</label>
                                                    <select id="direct_uom" name="uom"
                                                            class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                        <option value="meters">Meters</option>
                                                        <option value="yards">Yards</option>
                                                        <option value="pieces">Pieces</option>
                                                    </select>
                                                </div>
                                                <div class="w-1/3">
                                                    <label for="samplePoNumber"
                                                           class="block text-sm font-medium text-gray-700 dark:text-gray-300">PO
                                                        Number</label>
                                                    <input id="samplePoNumber" type="text" name="po_number" required
                                                           class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                </div>
                                            </div>

                                            <div class="flex gap-4">
                                                <div class="w-1/2">
                                                    <label for="customerName"
                                                           class="block text-sm font-medium text-gray-700 dark:text-gray-300">Customer
                                                        Name</label>
                                                    <input id="customerName" type="text" name="customer_name" required
                                                           class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                </div>
                                                <div class="w-1/2">
                                                    <label for="customerMerchandiser"
                                                           class="block text-sm font-medium text-gray-700 dark:text-gray-300">Customer
                                                        Merchandiser</label>
                                                    <input id="customerMerchandiser" type="text"
                                                           name="merchandiser_name" required
                                                           class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                </div>
                                            </div>

                                            <div class="flex gap-4">
                                                <div class="w-1/2">
                                                    <label for="totalValue"
                                                           class="block text-sm font-medium text-gray-700 dark:text-gray-300">PO
                                                        Value</label>
                                                    <input id="totalValue" type="number" step="0.01" name="price"
                                                           required
                                                           class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                </div>
                                                <div class="w-1/2">
                                                    <label for="sampleCustomerRequestedDate"
                                                           class="block text-sm font-medium text-gray-700 dark:text-gray-300">Customer
                                                        Requested Date</label>
                                                    <input id="sampleCustomerRequestedDate" type="date"
                                                           name="customer_req_date" required
                                                           class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm focus:ring focus:ring-indigo-500">
                                                </div>
                                            </div>

                                            <div>
                                                <label for="customerNotes"
                                                       class="block text-sm font-medium text-gray-700 dark:text-gray-300">Customer
                                                    Notes</label>
                                                <input id="customerNotes" type="text" name="remarks"
                                                       class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                            </div>

                                            <div class="flex justify-end gap-3 mt-6">
                                                <button type="button"
                                                        onclick="document.getElementById('addSampleModal').classList.add('hidden')"
                                                        class="px-4 py-2 bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-200 text-sm rounded hover:bg-gray-300">
                                                    Cancel
                                                </button>
                                                <button type="submit"
                                                        class="px-4 py-2 bg-blue-500 text-white text-sm rounded hover:bg-blue-600">
                                                    Create Sample Order
                                                </button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>

                            <div id="productionDetailsScroll"
                                 class="overflow-x-auto max-h-[1200px] bg-white dark:bg-gray-900 shadow-md rounded-xl relative border border-gray-200 dark:border-gray-700">

                                <table
                                    class="table-fixed w-full text-sm divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead class="bg-gray-200 dark:bg-gray-700 text-left">
                                    <tr class="text-center ">
                                        <th class="font-bold sticky left-0 top-0 z-20 bg-white px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                            Order No
                                        </th>
                                        <th class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">Reference Number</th>
                                        <th class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">PO Number</th>
                                        <th class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">Customer Coordinator</th>
                                        <th class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">Quantity</th>
                                        <th class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">Customer Name</th>
                                        <th class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">Customer Merchandiser</th>
                                        <th class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">PO Value</th>
                                        <th class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">Requested Date</th>
                                        <th class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">Notes</th>
                                        <th class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">Send to Stock</th>
                                        <th class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">Send to Production</th>
                                        <th class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">Status</th>
                                        <th class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">Action</th>
                                    </tr>
                                    </thead>

                                    <tbody id="productionDetailsRecords"
                                           class="divide-y divide-gray-200 dark:divide-gray-700">
                                    @forelse($productInquiries as $inquiry)
                                        <tr class="text-center hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors duration-200 divide-x divide-gray-200 dark:divide-gray-700">
                                            <!-- Production ID -->

                                            @if ($inquiry->supplier === null)
                                                <td class="px-4 py-3 font-semibold sticky left-0 z-10 bg-gray-50 dark:bg-gray-900 text-blue-500">
                                                    {{ $inquiry->prod_order_no ?? 'N/A' }}
                                                </td>
                                            @else
                                                <td class="px-4 py-3 font-semibold sticky left-0 z-10 bg-gray-50 dark:bg-gray-900">
                                                    {{ $inquiry->prod_order_no ?? 'N/A' }}
                                                </td>
                                            @endif

                                            <!-- Reference Number -->
                                            <td class="px-4 py-3">
                                                <button type="button"
                                                        class="text-blue-600 dark:text-blue-400 font-medium hover:text-blue-800"
                                                        onclick="openDetailsModal(this)"
                                                        data-ref-no="{{ $inquiry->reference_no ?? '' }}"
                                                        data-shade="{{ $inquiry->shade ?? '' }}"
                                                        data-colour="{{ $inquiry->color ?? '' }}"
                                                        data-item="{{ $inquiry->item ?? '' }}"
                                                        data-tkt="{{ $inquiry->tkt ?? '' }}"
                                                        data-size="{{ $inquiry->size ?? '' }}"
                                                        data-supplier="{{ $inquiry->supplier ?? '' }}"
                                                        data-pstno="{{ $inquiry->pst_no ?? '' }}"
                                                        data-suppliercomment="{{ $inquiry->supplier_comment ?? '' }}">
                                                    {{ $inquiry->reference_no ?? 'N/A' }}
                                                </button>
                                            </td>

                                            <!-- PO Number -->
                                            <td class="px-4 py-3">{{ $inquiry->po_number ?? 'N/A' }}</td>

                                            <!-- Customer Coordinator -->
                                            <td class="px-4 py-3">{{ $inquiry->customer_coordinator ?? 'N/A' }}</td>

                                            <!-- Quantity -->
                                            <td class="px-4 py-3">{{ $inquiry->qty ?? '0' }}</td>

                                            <!-- Customer Name -->
                                            <td class="px-4 py-3">{{ $inquiry->customer_name ?? 'N/A' }}</td>

                                            <!-- Customer Merchandiser -->
                                            <td class="px-4 py-3">{{ $inquiry->merchandiser_name ?? 'N/A' }}</td>

                                            <!-- PO Value -->
                                            <td class="px-4 py-3 text-green-600 font-medium">
                                                {{ $inquiry->price ? '$' . number_format($inquiry->price, 2) : '0' }}
                                            </td>

                                            <!-- Requested Date -->
                                            <td class="px-4 py-3">{{ $inquiry->customer_req_date ?? 'N/A' }}</td>

                                            <!-- Notes -->
                                            <td class="px-4 py-3 text-gray-500 italic">
                                                {{ $inquiry->remarks ?? '-' }}
                                            </td>

                                            <!-- Send to Stock -->
                                            <td class="px-4 py-3">
                                                <button
                                                    class="px-3 py-1 text-xs rounded-lg bg-blue-100 text-blue-700 hover:bg-blue-200">
                                                    Stock
                                                </button>
                                            </td>

                                            <!-- Send to Production -->
                                            <td class="px-4 py-3">
                                                <button
                                                    class="px-3 py-1 text-xs rounded-lg bg-indigo-100 text-indigo-700 hover:bg-indigo-200">
                                                    Production
                                                </button>
                                            </td>

                                            <!-- Status -->
                                            <td class="px-4 py-3">
                                                <span class="px-2 py-1 text-xs rounded-full
                                                    {{ $inquiry->status === 'Completed' ? 'bg-green-100 text-green-700' :
                                                      ($inquiry->status === 'Pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-gray-100 text-gray-600') }}">
                                                    {{ $inquiry->status ?? 'Pending' }}
                                                </span>
                                            </td>

                                            <!-- Action -->
                                            <td class="px-4 py-3">
                                                <form id="delete-form-{{ $inquiry->id }}"
                                                      method="POST"
                                                      action="{{ route('production-inquery-details.destroy', $inquiry->id) }}"
                                                      class="flex justify-center">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button"
                                                            onclick="confirmDelete('{{ $inquiry->id }}')"
                                                            class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-xs shadow-sm my-2">
                                                        Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="14"
                                                class="px-4 py-6 text-center text-gray-500 dark:text-gray-400">
                                                No inquiries found.
                                            </td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>

                                <div class="p-4 border-t border-gray-200 dark:border-gray-700">
                                    {{ $productInquiries->links() }}
                                </div>
                            </div>

                            <!-- Details Modal -->
                            <div id="detailsModal"
                                 class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
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
    function openDetailsModal(button) {
        const fields = {
            "Ref No": button.dataset.refNo,
            "Shade": button.dataset.shade,
            "Colour": button.dataset.colour,
            "Item": button.dataset.item,
            "TKT": button.dataset.tkt,
            "Size": button.dataset.size,
            "Supplier": button.dataset.supplier,
            "PST No": button.dataset.pstno,
            "Supplier Comment": button.dataset.suppliercomment
        };

        let html = "";

        Object.entries(fields).forEach(([label, value]) => {
            if (value && value !== "null" && value.trim() !== "") {
                html += `<p><strong>${label}:</strong> ${value}</p>`;
            }
        });

        document.getElementById("modalContent").innerHTML = html || "<p>No details available.</p>";

        document.getElementById("detailsModal").classList.remove("hidden");
    }

    function closeDetailsModal() {
        document.getElementById("detailsModal").classList.add("hidden");
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

<!-- ========= SCRIPTS: tabs, dropdown, sample fetch ========= -->
<script>
    // initialize tabs on page load
    document.addEventListener('DOMContentLoaded', function () {
        setOrderType('sample'); // default
        // close sample dropdown if clicked outside
        document.addEventListener('click', function (e) {
            if (!e.target.closest('#dropdownMenusampleReference') && !e.target.closest('#sampleReferenceDropdown')) {
                const dd = document.getElementById('dropdownMenusampleReference');
                if (dd) dd.classList.add('hidden');
            }
        });
    });

    function setOrderType(type) {
        const sampleForm = document.getElementById('sampleForm');
        const directForm = document.getElementById('directForm');
        const tabSample = document.getElementById('tab-sample');
        const tabDirect = document.getElementById('tab-direct');

        if (type === 'sample') {
            sampleForm.classList.remove('hidden');
            directForm.classList.add('hidden');
            tabSample.classList.add('border-b-2', 'border-blue-500', 'text-blue-600');
            tabDirect.classList.remove('border-b-2', 'border-blue-500', 'text-blue-600');
        } else {
            directForm.classList.remove('hidden');
            sampleForm.classList.add('hidden');
            tabDirect.classList.add('border-b-2', 'border-blue-500', 'text-blue-600');
            tabSample.classList.remove('border-b-2', 'border-blue-500', 'text-blue-600');
        }
    }

    // Simple dropdown toggle (for sample references)
    function toggleDropdown(name) {
        // We only have sampleReference dropdown here
        const el = document.getElementById('dropdownMenusampleReference');
        if (!el) return;
        el.classList.toggle('hidden');
    }

    // Filter list of sample options
    function filterSamples() {
        const q = (document.getElementById('sampleSearchInput').value || '').toLowerCase();
        document.querySelectorAll('#sampleOptions li').forEach(li => {
            li.style.display = li.textContent.toLowerCase().includes(q) ? '' : 'none';
        });
    }

    // Called when a sample reference is clicked
    function selectSampleReference(id, referenceNo) {
        // label + hidden ref id
        document.getElementById('selectedSampleReference').innerText = referenceNo;
        document.getElementById('sampleReferenceHidden').value = id;
        // close dropdown
        document.getElementById('dropdownMenusampleReference').classList.add('hidden');

        // fetch details from backend and populate fields
        const base = "{{ url('product-catalog') }}";
        fetch(`${base}/${id}/details`)
            .then(resp => {
                if (!resp.ok) throw new Error('Network response was not ok');
                return resp.json();
            })
            .then(data => {
                // These must match the sample-form IDs above
                document.getElementById('sampleShade').value = data.shade || data.colour || '';
                document.getElementById('sampleColour').value = data.colour || '';
                document.getElementById('sampleTKT').value = data.tkt || '';
                document.getElementById('sampleSize').value = data.size || '';
                document.getElementById('sampleItem').value = data.item || '';
                document.getElementById('sampleSupplier').value = data.supplier || '';
                if (document.getElementById('samplePSTNo')) {
                    document.getElementById('samplePSTNo').value = data.pst_no || '';
                }
                if (document.getElementById('sampleSupplierComment')) {
                    document.getElementById('sampleSupplierComment').value = data.supplier_comments || '';
                }

                // optional: prefill PO or other fields if returned
                if (data.preferred_po) document.getElementById('samplePoNumber').value = data.preferred_po;
            })
            .catch(err => {
                console.error('Error fetching sample details:', err);
                // optionally show a toast/error in UI
            });
    }
</script>

<script>
    document.getElementById("editButton").addEventListener("click", function () {
        // Select all editable fields
        const fields = document.querySelectorAll(".editable");
        fields.forEach(field => {
            field.removeAttribute("readonly");
            field.classList.remove("bg-gray-100", "dark:bg-gray-600"); // remove gray background
            field.classList.add("bg-white", "dark:bg-gray-800"); // make editable background
        });
    });
</script>

@endsection
