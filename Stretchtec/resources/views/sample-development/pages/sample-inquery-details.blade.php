<head>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<div class="flex h-full w-full bg-white">
    @extends('layouts.sample-tabs')

    @section('content')
        <div class="flex-1 overflow-y-hidden">
            <div class="">
                <div class="w-full px-6 lg:px-2">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden">
                        <div class="p-4 text-gray-900 dark:text-gray-100">
                            <style>
                                .swal2-toast {
                                    font-size: 0.875rem;
                                    padding: 0.75rem 1rem;
                                    border-radius: 8px;
                                    background-color: #ffffff !important;
                                    position: relative;
                                    box-sizing: border-box;
                                    color: #3b82f6 !important;
                                }

                                .swal2-toast .swal2-title,
                                .swal2-toast .swal2-html-container {
                                    color: #3b82f6 !important;
                                }

                                .swal2-toast .swal2-icon {
                                    color: #3b82f6 !important;
                                }

                                .swal2-shadow {
                                    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
                                }

                                .swal2-toast::after {
                                    content: '';
                                    position: absolute;
                                    bottom: 0;
                                    left: 0;
                                    width: 100%;
                                    height: 3px;
                                    background-color: #3b82f6;
                                    border-radius: 0 0 8px 8px;
                                }
                            </style>

                            <script>
                                document.addEventListener('DOMContentLoaded', () => {
                                    @if (session('success'))
                                        Swal.fire({
                                            toast: true,
                                            position: 'top-end',
                                            icon: 'success',
                                            title: '{{ session('success') }}',
                                            showConfirmButton: false,
                                            timer: 2000,
                                            timerProgressBar: true,
                                            customClass: {
                                                popup: 'swal2-toast swal2-shadow'
                                            },
                                        });
                                    @endif

                                    @if (session('error'))
                                        Swal.fire({
                                            toast: true,
                                            position: 'top-end',
                                            icon: 'error',
                                            title: '{{ session('error') }}',
                                            showConfirmButton: false,
                                            timer: 2000,
                                            timerProgressBar: true,
                                            customClass: {
                                                popup: 'swal2-toast swal2-shadow'
                                            },
                                        });
                                    @endif

                                    @if ($errors->any())
                                        Swal.fire({
                                            toast: true,
                                            position: 'top-end',
                                            icon: 'warning',
                                            title: 'Validation Errors',
                                            html: `{!! implode('<br>', $errors->all()) !!}`,
                                            showConfirmButton: false,
                                            timer: 3000,
                                            timerProgressBar: true,
                                            customClass: {
                                                popup: 'swal2-toast swal2-shadow'
                                            },
                                        });
                                    @endif
                                });
                            </script>
                            <div class="flex justify-start">
                                <button onclick="toggleFilterForm()"
                                    class="bg-white border border-blue-500 text-blue-500 hover:text-blue-600 hover:border-blue-600 font-semibold py-1 px-3 rounded shadow flex items-center gap-2 mb-6">
                                    <img src="{{ asset('icons/filter.png') }}" alt="" class="w-6 h-6"
                                        alt="Filter Icon">
                                    Filters
                                </button>
                            </div>

                            <div id="filterFormContainer" class="hidden mt-4">
                                <!-- Filter Form -->
                                <form id="filterForm1" method="GET" action="{{ route('sample-inquery-details.index') }}"
                                    class="mb-6 sticky top-0 z-20 flex gap-6 items-center">
                                    <div class="flex items-center gap-4 flex-wrap">

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

                                                    @foreach ($customers as $customer)
                                                        <button type="button"
                                                            class="customer-option w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600"
                                                            onclick="selectOption('customer', '{{ $customer }}')">{{ $customer }}</button>
                                                    @endforeach
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
                                                        onclick="selectOption('merchandiser', '')">Select
                                                        Merchandiser</button>

                                                    @foreach ($merchandisers as $merch)
                                                        <button type="button"
                                                            class="merchandiser-option w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600"
                                                            onclick="selectOption('merchandiser', '{{ $merch }}')">{{ $merch }}</button>
                                                    @endforeach
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
                                                    <span id="selectedItem">{{ request('item') ?: 'Select Item' }}</span>
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
                                                    <input type="text" id="itemSearchInput"
                                                        placeholder="Search items..."
                                                        class="w-full px-2 py-1 text-sm border rounded-md dark:bg-gray-600 dark:text-white dark:placeholder-gray-300"
                                                        onkeyup="filterOptions('item')" />
                                                </div>
                                                <div class="py-1" role="listbox" tabindex="-1"
                                                    aria-labelledby="itemDropdown">
                                                    <button type="button"
                                                        class="item-option w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600"
                                                        onclick="selectOption('item', '')">Select Item</button>

                                                    @foreach ($items as $item)
                                                        <button type="button"
                                                            class="item-option w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600"
                                                            onclick="selectOption('item', '{{ $item }}')">{{ $item }}</button>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <input type="hidden" name="item" id="itemInput"
                                                value="{{ request('item') }}">
                                        </div>

                                        <!-- CUSTOMER DELIVERY STATUS DROPDOWN -->
                                        <div class="relative inline-block text-left w-48">
                                            <label for="deliveryStatusDropdown"
                                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                Customer Delivery Status
                                            </label>

                                            <!-- Dropdown Toggle Button -->
                                            <div>
                                                <button type="button" id="deliveryStatusDropdown"
                                                    class="inline-flex w-full justify-between rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-gray-300 hover:bg-gray-50 h-10 dark:bg-gray-700 dark:text-white"
                                                    onclick="toggleDropdown('deliveryStatus')" aria-haspopup="listbox"
                                                    aria-expanded="false">
                                                    <span id="selectedDeliveryStatus">
                                                        {{ request('deliveryStatus') ?: 'Select Status' }}
                                                    </span>
                                                    <svg class="ml-2 h-5 w-5 text-gray-400" viewBox="0 0 20 20"
                                                        fill="currentColor" aria-hidden="true">
                                                        <path fill-rule="evenodd"
                                                            d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.25 8.29a.75.75 0 01-.02-1.08z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </div>

                                            <!-- Dropdown Menu -->
                                            <div id="deliveryStatusDropdownMenu"
                                                class="hidden absolute z-10 mt-2 w-full rounded-md bg-white shadow-lg ring-1 ring-black/5 dark:bg-gray-700 max-h-48 overflow-y-auto">

                                                <!-- Search Input -->
                                                <div class="p-2 sticky top-0 bg-white dark:bg-gray-700 z-10">
                                                    <input type="text" id="deliveryStatusSearchInput"
                                                        placeholder="Search status..."
                                                        class="w-full px-2 py-1 text-sm border rounded-md dark:bg-gray-600 dark:text-white dark:placeholder-gray-300"
                                                        onkeyup="filterOptions('deliveryStatus')" />
                                                </div>

                                                <!-- Option Buttons -->
                                                <div class="py-1" role="listbox" tabindex="-1"
                                                    aria-labelledby="deliveryStatusDropdown">
                                                    @php
                                                        $statuses = ['', 'Delivered', 'Pending'];
                                                    @endphp
                                                    @foreach ($statuses as $status)
                                                        <button type="button"
                                                            class="deliveryStatus-option w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600"
                                                            onclick="selectOption('deliveryStatus', '{{ $status }}')">
                                                            {{ $status === '' ? 'All Statuses' : $status }}
                                                        </button>
                                                    @endforeach
                                                </div>
                                            </div>

                                            <!-- Hidden Input for Form Submission -->
                                            <input type="hidden" name="deliveryStatus" id="deliveryStatusInput"
                                                value="{{ request('deliveryStatus') }}">
                                        </div>


                                        <div class="flex gap-6 items-end">
                                            <!-- CUSTOMER DECISION DROPDOWN -->
                                            <div class="relative inline-block text-left w-48">
                                                <label for="customerDecisionDropdown"
                                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                    Customer Decision
                                                </label>

                                                <!-- Dropdown Toggle -->
                                                <div>
                                                    <button type="button" id="customerDecisionDropdown"
                                                        class="inline-flex w-full justify-between rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-gray-300 hover:bg-gray-50 h-10 dark:bg-gray-700 dark:text-white"
                                                        onclick="toggleDropdown('customerDecision')"
                                                        aria-haspopup="listbox" aria-expanded="false">
                                                        <span id="selectedCustomerDecision">
                                                            {{ request('customerDecision') ?: 'Select Decision' }}
                                                        </span>
                                                        <svg class="ml-2 h-5 w-5 text-gray-400" viewBox="0 0 20 20"
                                                            fill="currentColor" aria-hidden="true">
                                                            <path fill-rule="evenodd"
                                                                d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.25 8.29a.75.75 0 01-.02-1.08z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    </button>
                                                </div>

                                                <!-- Dropdown Menu -->
                                                <div id="customerDecisionDropdownMenu"
                                                    class="hidden absolute z-10 mt-2 w-full rounded-md bg-white shadow-lg ring-1 ring-black/5 dark:bg-gray-700 max-h-48 overflow-y-auto">
                                                    <div class="p-2 sticky top-0 bg-white dark:bg-gray-700 z-10">
                                                        <input type="text" id="customerDecisionSearchInput"
                                                            placeholder="Search decision..."
                                                            class="w-full px-2 py-1 text-sm border rounded-md dark:bg-gray-600 dark:text-white dark:placeholder-gray-300"
                                                            onkeyup="filterOptions('customerDecision')" />
                                                    </div>
                                                    <div class="py-1" role="listbox" tabindex="-1"
                                                        aria-labelledby="customerDecisionDropdown">
                                                        @php
                                                            $decisions = [
                                                                '', // For "All"
                                                                'Pending',
                                                                'Order Received',
                                                                'Order Not Received',
                                                                'Order Rejected',
                                                            ];
                                                        @endphp
                                                        @foreach ($decisions as $decision)
                                                            <button type="button"
                                                                class="customerDecision-option w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600"
                                                                onclick="selectOption('customerDecision', '{{ $decision }}')">
                                                                {{ $decision === '' ? 'All Decisions' : $decision }}
                                                            </button>
                                                        @endforeach
                                                    </div>
                                                </div>

                                                <input type="hidden" name="customerDecision" id="customerDecisionInput"
                                                    value="{{ request('customerDecision') }}">
                                            </div>

                                            <button type="submit"
                                                class="mt-4 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                                                Apply Filters
                                            </button>

                                            <button type="button" id="clearFiltersBtn"
                                                class="mt-4 bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-200 px-4 py-2 rounded hover:bg-gray-300">
                                                Clear Filters
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>


                            <div class="flex justify-between items-center mb-6">
                                <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Sample Inquiry Records</h1>
                                <div class="flex space-x-3">
                                    <button onclick="document.getElementById('addSampleModal').classList.remove('hidden')"
                                        class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded shadow">
                                        + Add New Order
                                    </button>
                                    <a href="{{ route('sampleStockManagement.index') }}">
                                        <button
                                            class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded shadow">
                                            Sample Stock Management
                                        </button>
                                    </a>

                                </div>
                            </div>

                            <div class="overflow-x-auto bg-white dark:bg-gray-900 shadow rounded-lg">
                                <table class="table-fixed w-full text-sm divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead class="bg-gray-200 dark:bg-gray-700 text-left">
                                        <tr class="text-center">
                                            <th
                                                class="sticky left-0 z-10 bg-white px-4 py-3 w-32 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
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
                                                class="px-4 py-3 w-40 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                Customer Requested Sample Quantity</th>
                                            <th
                                                class="px-4 py-3 w-32 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                Customer Special Comments</th>
                                            <th
                                                class="px-4 py-3 w-32 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                Customer Requested Dates</th>
                                            <th
                                                class="px-4 py-3 w-56 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                Already Developed & In Sample Stock</th>
                                            <th
                                                class="px-4 py-3 w-40 text-xs font-medium uppercase text-gray-600 dark:text-gray-300 whitespace-normal break-words">
                                                Sent order to sample development</th>
                                            <th
                                                class="px-4 py-3 w-32 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                Development Plan Date</th>
                                            <th
                                                class="px-4 py-3 w-36 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                Production Status</th>
                                            <th
                                                class="px-4 py-3 w-48 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                Reference No</th>
                                            <th
                                                class="px-4 py-3 w-40 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                Customer Delivery Status</th>
                                            <th
                                                class="px-4 py-3 w-56 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                Customer Decision</th>
                                            <th
                                                class="px-4 py-3 w-72 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                Note</th>
                                            <th
                                                class="px-4 py-3 w-48 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                Action</th>
                                        </tr>
                                    </thead>

                                    <tbody id="sampleInquiryRecords"
                                        class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                        @foreach ($inquiries as $inquiry)
                                            <tr id="row{{ $inquiry->id }}"
                                                class="odd:bg-white even:bg-gray-50 border-b border-gray-200  text-left">
                                                <!-- Order No -->
                                                <td
                                                    class="sticky left-0 z-10 bg-white px-4 py-3 bg-gray-100 whitespace-normal break-words border-r border-gray-300">
                                                    <span class="readonly font-bold">{{ $inquiry->orderNo }}</span>
                                                    <input type="text"
                                                        class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                        value="{{ $inquiry->orderNo }}" />
                                                </td>

                                                <!-- Inquiry Receive Date -->
                                                <td
                                                    class="px-4 py-3 whitespace-normal break-words border-r border-gray-300  text-center">
                                                    <span class="readonly">
                                                        {{ \Carbon\Carbon::parse($inquiry->inquiryReceiveDate)->format('Y-m-d') }}
                                                    </span>
                                                    <input type="date" class="hidden editable ..."
                                                        value="{{ \Carbon\Carbon::parse($inquiry->inquiryReceiveDate)->format('Y-m-d') }}" />
                                                </td>

                                                <!-- Customer -->
                                                <td
                                                    class="px-4 py-3 whitespace-normal break-words border-r border-gray-300  text-center">
                                                    <span class="readonly">{{ $inquiry->customerName }}</span>
                                                    <input type="text"
                                                        class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                        value="{{ $inquiry->customerName }}" />
                                                </td>

                                                <!-- Merchandiser -->
                                                <td
                                                    class="px-4 py-3 whitespace-normal break-words border-r border-gray-300  text-center">
                                                    <span class="readonly">{{ $inquiry->merchandiseName }}</span>
                                                    <input type="text"
                                                        class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                        value="{{ $inquiry->merchandiseName }}" />
                                                </td>

                                                <!-- Item -->
                                                <td
                                                    class="px-4 py-3 whitespace-normal break-words border-r border-gray-300  text-center">
                                                    <span class="readonly">{{ $inquiry->item }}</span>
                                                    <input type="text"
                                                        class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                        value="{{ $inquiry->item }}" />
                                                </td>

                                                <!-- Size -->
                                                <td
                                                    class="px-4 py-3 whitespace-normal break-words border-r border-gray-300  text-center">
                                                    <span class="readonly">{{ $inquiry->size }}</span>
                                                    <input type="text"
                                                        class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                        value="{{ $inquiry->size }}" />
                                                </td>

                                                <!-- Color -->
                                                <td
                                                    class="px-4 py-3 whitespace-normal break-words border-r border-gray-300  text-center">
                                                    <span class="readonly">{{ $inquiry->color }}</span>
                                                    <input type="text"
                                                        class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                        value="{{ $inquiry->color }}" />
                                                </td>

                                                <!-- Sample Qty -->
                                                <td
                                                    class="px-4 py-3 whitespace-normal break-words border-r border-gray-300  text-center">
                                                    <span class="readonly">{{ $inquiry->sampleQty }}</span>
                                                    <input type="text"
                                                        class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                        value="{{ $inquiry->sampleQty }}" />
                                                </td>

                                                <!-- Customer Comments -->
                                                <td
                                                    class="px-4 py-3 whitespace-normal break-words border-r border-gray-300  text-center">
                                                    <span class="readonly">{{ $inquiry->customerSpecialComment ?? 'N/A' }}</span>
                                                    <input type="text"
                                                        class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                        value="{{ $inquiry->customerSpecialComment }}" />
                                                </td>

                                                <!-- Requested Date -->
                                                <td class="px-4 py-3 whitespace-normal break-words border-r border-gray-300 text-center">
                                                    @if ($inquiry->customerRequestDate)
                                                        <span class="readonly">{{ $inquiry->customerRequestDate->format('Y-m-d') }}</span>
                                                        <input type="date"
                                                               class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                               value="{{ $inquiry->customerRequestDate->format('Y-m-d') }}" />
                                                    @else
                                                        <span class="readonly">N/A</span>
                                                        <input type="date"
                                                               class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                               value="" />
                                                    @endif
                                                </td>

                                                <!-- Already Developed -->
                                                <td
                                                    class="px-4 py-3 whitespace-normal break-words border-r border-gray-300">
                                                    <div class="relative inline-block text-left">
                                                        @if (!$inquiry->alreadyDeveloped && !$inquiry->sentToSampleDevelopmentDate)
                                                            <form method="POST"
                                                                action="{{ route('inquiry.updateDevelopedStatus') }}">
                                                                @csrf
                                                                <input type="hidden" name="id"
                                                                    value="{{ $inquiry->id }}">
                                                                <input type="hidden" name="alreadyDeveloped"
                                                                    id="alreadyDevelopedInput{{ $inquiry->id }}"
                                                                    value="0">

                                                                <!-- Dropdown Button -->
                                                                <button type="button"
                                                                    id="alreadyDevelopedDropdown{{ $inquiry->id }}"
                                                                    class="inline-flex justify-between w-48 rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-gray-300 hover:bg-gray-50 h-10 dark:bg-gray-700 dark:text-white transition-all duration-200"
                                                                    onclick="toggleDevelopedDropdown(event, {{ $inquiry->id }})">
                                                                    <span
                                                                        id="selectedAlreadyDeveloped{{ $inquiry->id }}">Need
                                                                        to Develop</span>
                                                                    <svg class="ml-2 h-5 w-5 text-gray-400"
                                                                        viewBox="0 0 20 20" fill="currentColor">
                                                                        <path fill-rule="evenodd"
                                                                            d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 10.94l3.71-3.71a.75.75 0 1 1 1.06 1.06l-4.24 4.24a.75.75 0 0 1-1.06 0L5.25 8.29a.75.75 0 0 1-.02-1.08z"
                                                                            clip-rule="evenodd" />
                                                                    </svg>
                                                                </button>

                                                                <!-- Dropdown Menu -->
                                                                <div id="alreadyDevelopedDropdownMenu{{ $inquiry->id }}"
                                                                    class="hidden absolute z-10 mt-2 w-48 rounded-md bg-white shadow-lg ring-1 ring-black/5 dark:bg-gray-700">
                                                                    <div class="py-1">
                                                                        <button type="submit"
                                                                            onclick="setDevelopedStatus({{ $inquiry->id }}, 0, 'Need to Develop')"
                                                                            class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600">
                                                                            Need to Develop
                                                                        </button>
                                                                        <button type="submit"
                                                                            onclick="setDevelopedStatus({{ $inquiry->id }}, 1, 'No Need to Develop')"
                                                                            class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600">
                                                                            No Need to Develop
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        @else
                                                            <div
                                                                class="inline-flex items-center w-48 rounded-md bg-gray-200 px-3 py-2 text-sm font-semibold text-gray-500 shadow-inner h-10 dark:bg-gray-700 dark:text-gray-400">
                                                                {{ $inquiry->alreadyDeveloped ? 'No Need to Develop' : 'Need to Develop' }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </td>

                                                {{-- Sent Order to Sample Development --}}
                                                <td
                                                    class="py-3 whitespace-normal break-words border-r border-gray-300 text-center">
                                                    @if (!$inquiry->alreadyDeveloped)
                                                        <div class="colour-match-sent">
                                                            @if (is_null($inquiry->sentToSampleDevelopmentDate))
                                                                {{-- Show form with clickable button --}}
                                                                <form action="{{ route('inquiry.markSentToSampleDev') }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    <input type="hidden" name="id"
                                                                        value="{{ $inquiry->id }}">
                                                                    <button type="submit"
                                                                        class="delivered-btn bg-gray-300 text-black px-2 py-1 mt-3 rounded hover:bg-gray-400 transition-all duration-200">
                                                                        Pending
                                                                    </button>
                                                                </form>
                                                            @else
                                                                {{-- Show static timestamp info --}}
                                                                <span
                                                                    class="inline-block m-1 text-sm font-semibold text-gray-700 dark:text-white bg-yellow-100 dark:bg-gray-800 px-3 py-1 rounded">
                                                                    Sent on <br>
                                                                    {{ \Carbon\Carbon::parse($inquiry->sentToSampleDevelopmentDate)->format('Y-m-d') }}
                                                                    at
                                                                    {{ \Carbon\Carbon::parse($inquiry->sentToSampleDevelopmentDate)->format('H:i') }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>

                                                {{-- Develop Plan Date --}}
                                                <td
                                                    class="px-4 py-3 whitespace-normal break-words border-r border-gray-300 text-center ">
                                                    @if (!$inquiry->alreadyDeveloped)
                                                        <span class="readonly">{{ $inquiry->developPlannedDate }}</span>
                                                        <input type="date" name="developPlannedDate"
                                                            class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                            value="{{ $inquiry->developPlannedDate }}" />
                                                        <span
                                                            class="readonly">{{ $inquiry->developPlannedDate ?? 'N/D' }}</span>
                                                        <input type="date" name="developPlannedDate"
                                                            class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                            value="{{ $inquiry->developPlannedDate ?? 'N/D' }}" />
                                                    @else
                                                        {{-- Show empty cell or readonly text if needed --}}
                                                        <span class="text-gray-400 italic">—</span>
                                                    @endif
                                                </td>

                                                {{-- Production Status --}}
                                                <td
                                                    class="px-4 py-3 whitespace-normal break-words border-r border-gray-300 text-center">
                                                    @if (!$inquiry->alreadyDeveloped)
                                                        @php
                                                            $status = $inquiry->productionStatus;
                                                            $badgeClass = match ($status) {
                                                                'Pending'
                                                                    => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-white',
                                                                'In_progress'
                                                                    => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-700 dark:text-white',
                                                                'Complete'
                                                                    => 'bg-green-100 text-green-800 dark:bg-green-700 dark:text-white',
                                                                default
                                                                    => 'bg-blue-100 text-blue-800 dark:bg-blue-700 dark:text-white',
                                                            };
                                                        @endphp

                                                        <!-- Read-only badge -->
                                                        <span
                                                            class="readonly inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $badgeClass }}">
                                                            {{ $status }}
                                                        </span>

                                                        <!-- Editable input field (hidden by default, shown in edit mode) -->
                                                        <input type="text" name="productionStatus"
                                                            class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                            value="{{ $status }}" />
                                                    @else
                                                        <span class="text-gray-400 italic">—</span>
                                                    @endif
                                                </td>

                                                <!-- Reference No -->
                                                <td
                                                    class="px-4 py-3 whitespace-normal break-words border-r border-gray-300 text-center ">
                                                    <span class="readonly">{{ $inquiry->referenceNo ?? 'N/D' }}</span>
                                                    <input type="text"
                                                        class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                        value="{{ $inquiry->referenceNo ?? 'N/D' }}" />
                                                </td>

                                                <td
                                                    class="py-3 whitespace-normal break-words border-r border-gray-300 text-center ">
                                                    <div class="delivery-item">
                                                        @if (is_null($inquiry->customerDeliveryDate))
                                                            <form action="{{ route('inquiry.markCustomerDelivered') }}"
                                                                method="POST">
                                                                @csrf
                                                                <input type="hidden" name="id"
                                                                    value="{{ $inquiry->id }}">
                                                                <button type="submit"
                                                                    class="delivered-btn bg-gray-300 text-black px-2 py-1 mt-3 rounded hover:bg-gray-400 transition-all duration-200">
                                                                    Pending
                                                                </button>
                                                            </form>
                                                            <div
                                                                class="timestamp mt-1 text-xs text-gray-500 dark:text-gray-400">
                                                            </div>
                                                        @else
                                                            <span
                                                                class="inline-block m-1 text-sm font-semibold text-gray-700 dark:text-white bg-green-100 dark:bg-gray-800 px-3 py-1 rounded">
                                                                Delivered on <br>
                                                                {{ \Carbon\Carbon::parse($inquiry->customerDeliveryDate)->format('Y-m-d') }}
                                                                at
                                                                {{ \Carbon\Carbon::parse($inquiry->customerDeliveryDate)->format('H:i') }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </td>

                                                <!-- Customer Decision -->
                                                <td class="px-4 whitespace-normal break-words border-r border-gray-300">
                                                    <form
                                                        action="{{ route('sample-inquery-details.update-decision', $inquiry->id) }}"
                                                        method="POST" class="relative inline-block text-left w-48">
                                                        @csrf
                                                        @method('PATCH')

                                                        @php
                                                            $status = $inquiry->customerDecision;
                                                            $colorClass = match ($status) {
                                                                'Order Rejected'
                                                                    => 'bg-red-100 text-red-800 dark:bg-red-700 dark:text-white',
                                                                'Order Received'
                                                                    => 'bg-green-100 text-green-800 dark:bg-green-700 dark:text-white',
                                                                'Order Not Received'
                                                                    => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-700 dark:text-white',
                                                                'Pending'
                                                                    => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-white',
                                                                default
                                                                    => 'bg-white text-gray-900 dark:bg-gray-700 dark:text-white',
                                                            };
                                                        @endphp

                                                        <!-- Dropdown Button -->
                                                        <button type="button"
                                                            id="customerDecisionDropdownTable-{{ $inquiry->id }}"
                                                            class="inline-flex justify-between w-48 rounded-md px-3 py-2 text-sm font-semibold shadow-sm ring-1 h-10 transition-all duration-200 {{ $colorClass }}"
                                                            onclick="toggleCustomerDecisionDropdownTable(event, '{{ $inquiry->id }}')">
                                                            <span
                                                                id="selectedCustomerDecisionTable-{{ $inquiry->id }}">{{ $status }}</span>
                                                            <svg class="ml-2 h-5 w-5 text-gray-400" viewBox="0 0 20 20"
                                                                fill="currentColor">
                                                                <path fill-rule="evenodd"
                                                                    d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 10.94l3.71-3.71a.75.75 0 1 1 1.06 1.06l-4.24 4.24a.75.75 0 0 1-1.06 0L5.25 8.29a.75.75 0 0 1-.02-1.08z"
                                                                    clip-rule="evenodd" />
                                                            </svg>
                                                        </button>

                                                        <!-- Dropdown Menu -->
                                                        <div id="customerDecisionDropdownMenuTable-{{ $inquiry->id }}"
                                                            class="hidden absolute z-10 mt-2 w-48 rounded-md bg-white shadow-lg ring-1 ring-black/5 dark:bg-gray-700">
                                                            <div class="py-1" role="listbox" tabindex="-1"
                                                                aria-labelledby="customerDecisionDropdownTable-{{ $inquiry->id }}">
                                                                @php
                                                                    $options = [
                                                                        'Pending',
                                                                        'Order Received',
                                                                        'Order Not Received',
                                                                        'Order Rejected',
                                                                    ];
                                                                    $colors = [
                                                                        'Pending' =>
                                                                            'hover:bg-gray-100 text-gray-700 dark:text-white dark:hover:bg-gray-600',
                                                                        'Order Received' =>
                                                                            'hover:bg-green-100 text-green-700 dark:text-white dark:hover:bg-green-600',
                                                                        'Order Not Received' =>
                                                                            'hover:bg-yellow-100 text-yellow-700 dark:text-white dark:hover:bg-yellow-600',
                                                                        'Order Rejected' =>
                                                                            'hover:bg-red-100 text-red-700 dark:text-white dark:hover:bg-red-600',
                                                                    ];
                                                                @endphp

                                                                @foreach ($options as $option)
                                                                    <button type="submit" name="customerDecision"
                                                                        value="{{ $option }}"
                                                                        class="decision-option w-full text-left px-4 py-2 text-sm {{ $colors[$option] }}"
                                                                        onclick="selectCustomerDecisionTable('{{ $option }}', '{{ $inquiry->id }}')">
                                                                        {{ $option }}
                                                                    </button>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </form>
                                                </td>

                                                <!-- Notes -->
                                                <td
                                                    class="px-4 py-3 whitespace-normal break-words border-r border-gray-300 text-center ">
                                                    <span class="readonly">{{ $inquiry->notes ?? 'N/D' }}</span>
                                                    <textarea
                                                        class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                        rows="2">{{ $inquiry->notes ?? 'N/D' }}</textarea>
                                                </td>

                                                <!-- Actions -->
                                                <td class="px-4 py-3 whitespace-normal break-words text-center">
                                                    <div class="flex space-x-2 justify-center">

                                                        @if (Auth::user()->role === 'Super_admin')
                                                            <button
                                                                class="edit-btn bg-green-600 h-10 hover:bg-green-700 text-white px-3 py-1 rounded text-sm"
                                                                onclick="editRow('row{{ $inquiry->id }}')">
                                                                Edit
                                                            </button>
                                                        @endif

                                                        <button
                                                            class="save-btn bg-blue-600 h-10 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm hidden"
                                                            onclick="saveRow('row{{ $inquiry->id }}')">
                                                            Save
                                                        </button>

                                                        <div class="flex items-center justify-center">
                                                            @if ($inquiry->orderFile)
                                                                <a href="{{ asset('storage/' . $inquiry->orderFile) }}"
                                                                   target="_blank"
                                                                   class="bg-gray-600 h-10 w-20 hover:bg-gray-700 text-white px-3 py-2 rounded text-sm">
                                                                    View
                                                                </a>
                                                            @else
                                                                <button type="button"
                                                                        class="bg-gray-300 h-10 w-20 text-gray-500 px-3 py-1 rounded text-sm cursor-not-allowed"
                                                                        disabled>
                                                                    No File
                                                                </button>
                                                            @endif
                                                        </div>

                                                    </div>
                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="py-6 flex justify-center">
                                {{ $inquiries->links() }}
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
                                        <form action="{{ route('sampleInquiry.store') }}" method="POST"
                                            enctype="multipart/form-data">
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
                                                            class="block" accept=".pdf,.jpg,.jpeg" />
                                                    </label>
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
            const clearFiltersBtn = document.getElementById('clearFiltersBtn');
            const filterForm = document.getElementById('filterForm');

            clearFiltersBtn.addEventListener('click', () => {
                document.getElementById('customerInput').value = '';
                document.getElementById('merchandiserInput').value = '';
                document.getElementById('itemInput').value = '';
                document.getElementById('deliveryStatusInput').value = '';
                document.getElementById('customerDecisionInput').value = '';

                document.getElementById('selectedCustomer').textContent = 'Select Customer';
                document.getElementById('selectedMerchandiser').textContent = 'Select Merchandiser';
                document.getElementById('selectedItem').textContent = 'Select Item';
                document.getElementById('selectedDeliveryStatus').textContent = 'Select Status';
                document.getElementById('selectedCustomerDecision').textContent = 'Select Decision';

                filterForm.submit();
            });

            document.querySelectorAll('td').forEach(td => {
                const timestampDiv = td.querySelector('.timestamp');
                const deliveredBtn = td.querySelector('button.delivered-btn');

                if (timestampDiv && timestampDiv.textContent.trim() && deliveredBtn) {
                    deliveredBtn.classList.add('hidden');
                } else if (timestampDiv && !timestampDiv.textContent.trim() && deliveredBtn) {
                    deliveredBtn.classList.remove('hidden');
                }
            });
        });

        function toggleDropdown(type) {
            const menu = document.getElementById(`${type}DropdownMenu`);
            const btn = document.getElementById(`${type}Dropdown`);
            const expanded = btn.getAttribute('aria-expanded') === 'true';
            menu.classList.toggle('hidden');
            btn.setAttribute('aria-expanded', !expanded);
        }

        // Helper function to get custom "All ..." label for each type
        function getDisplayLabel(type, value) {
            if (value) return value;
            switch (type) {
                case 'customer':
                    return 'All Customer';
                case 'merchandiser':
                    return 'All Merchandiser';
                case 'item':
                    return 'All Item';
                case 'deliveryStatus':
                    return 'All Delivery Status';
                case 'customerDecision':
                    return 'All Decision';
                default:
                    return 'All';
            }
        }

        function formatDisplayValue(value, type) {
            // You can decide if you want to use getDisplayLabel here or keep generic
            // Using getDisplayLabel to keep consistency
            return getDisplayLabel(type, value);
        }

        function selectOption(type, value) {
            const displayText = value || `Select ${capitalize(type)}`;
            const displayValue = getDisplayLabel(type, value);

            document.getElementById(`selected${capitalize(type)}`).innerText = displayValue;
            document.getElementById(`${type}Input`).value = value || '';
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

        // Close dropdown menus when clicking outside
        document.addEventListener('click', function(e) {
            ['item', 'customer', 'merchandiser', 'deliveryStatus', 'customerDecision'].forEach(type => {
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
        document.addEventListener("DOMContentLoaded", () => {
            const filters = ['customer', 'merchandiser', 'item', 'deliveryStatus', 'customerDecision'];

            // Bind dropdown toggle
            filters.forEach(type => {
                const button = document.getElementById(`${type}Dropdown`);
                const menu = document.getElementById(`${type}DropdownMenu`);

                if (button && menu) {
                    button.addEventListener("click", (e) => {
                        e.stopPropagation();
                        closeAllDropdowns();
                        menu.classList.toggle("hidden");
                        button.setAttribute("aria-expanded", menu.classList.contains("hidden") ?
                            "false" : "true");
                    });
                }
            });

            // Bind option selection
            filters.forEach(type => {
                const options = document.querySelectorAll(`.${type}-option`);
                options.forEach(option => {
                    option.addEventListener("click", () => {
                        const value = option.textContent.trim() ===
                            `Select ${capitalize(type)}` ? '' : option.textContent.trim();
                        document.getElementById(`${type}Input`).value = value;
                        document.getElementById(`selected${capitalize(type)}`).textContent =
                            value || `Select ${capitalize(type)}`;
                        document.getElementById(`${type}DropdownMenu`).classList.add(
                            "hidden");
                        document.getElementById(`${type}Dropdown`).setAttribute(
                            "aria-expanded", "false");
                    });
                });
            });

            // Bind search filter
            filters.forEach(type => {
                const searchInput = document.getElementById(`${type}SearchInput`);
                if (searchInput) {
                    searchInput.addEventListener("keyup", () => {
                        const query = searchInput.value.toLowerCase();
                        const options = document.querySelectorAll(`.${type}-option`);
                        options.forEach(option => {
                            const text = option.textContent.toLowerCase();
                            option.style.display = text.includes(query) ? "block" : "none";
                        });
                    });
                }
            });

            // Close all dropdowns if clicked outside
            document.addEventListener("click", (e) => {
                filters.forEach(type => {
                    const menu = document.getElementById(`${type}DropdownMenu`);
                    const button = document.getElementById(`${type}Dropdown`);
                    if (!menu.contains(e.target) && !button.contains(e.target)) {
                        menu.classList.add("hidden");
                        button.setAttribute("aria-expanded", "false");
                    }
                });
            });

            function capitalize(str) {
                return str.charAt(0).toUpperCase() + str.slice(1);
            }

            function closeAllDropdowns() {
                filters.forEach(type => {
                    const menu = document.getElementById(`${type}DropdownMenu`);
                    const button = document.getElementById(`${type}Dropdown`);
                    menu.classList.add("hidden");
                    button.setAttribute("aria-expanded", "false");
                });
            }
        });
    </script>

    <script>
        function editRow(rowId) {
            const row = document.getElementById(rowId);

            // Show editable inputs, hide readonly spans
            row.querySelectorAll('.readonly').forEach(span => span.classList.add('hidden'));
            row.querySelectorAll('.editable').forEach(input => input.classList.remove('hidden'));

            // Hide the Edit button and show the Save button
            const editBtn = row.querySelector('button.edit-btn');
            const saveBtn = row.querySelector('button.save-btn');
            if (editBtn) editBtn.classList.add('hidden');
            if (saveBtn) saveBtn.classList.remove('hidden');
        }


        function saveRow(rowId) {
            const row = document.getElementById(rowId);

            // Hide inputs, show spans again
            row.querySelectorAll('.editable').forEach(input => input.classList.add('hidden'));
            row.querySelectorAll('.readonly').forEach(span => span.classList.remove('hidden'));

            // Show Edit, hide Save
            const editBtn = row.querySelector('button.edit-btn');
            const saveBtn = row.querySelector('button.save-btn');
            if (editBtn) editBtn.classList.remove('hidden');
            if (saveBtn) saveBtn.classList.add('hidden');
        }
    </script>

    <script>
        function toggleDone(event, button) {
            const isPending = button.textContent.trim() === 'Pending';
            const container = button.closest('.delivery-item');
            const timestamp = container.querySelector('.timestamp');

            if (isPending) {
                // ✅ Change button to "Delivered"
                button.textContent = 'Delivered';
                button.classList.remove('bg-gray-300', 'text-black', 'hover:bg-gray-400');
                button.classList.add('bg-[#FF9119]', 'text-white', 'hover:bg-[#FF9119]/80');

                // ✅ Show current date and time
                const now = new Date();
                timestamp.textContent = `Delivered on ${now.toLocaleDateString()} at ${now.toLocaleTimeString()}`;
            } else {
                // ✅ Change back to "Pending"
                button.textContent = 'Pending';
                button.classList.remove('bg-[#FF9119]', 'text-white', 'hover:bg-[#FF9119]/80');
                button.classList.add('bg-gray-300', 'text-black', 'hover:bg-gray-400');

                // ✅ Clear timestamp
                timestamp.textContent = '';
            }
        }
    </script>


    <script>
        const buttons = document.querySelectorAll('.toggle-btn-accepted');

        buttons.forEach(button => {
            button.addEventListener('click', () => {
                const isDelivered = button.textContent.trim() === 'Accepted';

                if (isDelivered) {
                    button.textContent = 'Rejected';
                    button.classList.remove('bg-blue-500', 'text-white', 'hover:bg-blue-600');
                    button.classList.add('bg-red-600', 'text-white', 'hover:bg-red-700');
                } else {
                    button.textContent = 'Accepted';
                    button.classList.remove('bg-red-600', 'text-white', 'hover:bg-red-700');
                    button.classList.add('bg-blue-500', 'text-white', 'hover:bg-blue-600');
                }
            });
        });
    </script>

    <script>
        function toggleDevelopedDropdown(event, id) {
            event.stopPropagation();
            const menu = document.getElementById(`alreadyDevelopedDropdownMenu${id}`);
            const btn = document.getElementById(`alreadyDevelopedDropdown${id}`);
            const expanded = btn.getAttribute('aria-expanded') === 'true';

            menu.classList.toggle('hidden');
            btn.setAttribute('aria-expanded', !expanded);
        }

        function setDevelopedStatus(id, value, label) {
            document.getElementById(`alreadyDevelopedInput${id}`).value = value;
            document.getElementById(`selectedAlreadyDeveloped${id}`).innerText = label;
        }

        // Close all "Already Developed" dropdowns on outside click
        document.addEventListener('click', function(e) {
            document.querySelectorAll('[id^=alreadyDevelopedDropdownMenu]').forEach(menu => {
                if (!menu.contains(e.target)) {
                    menu.classList.add('hidden');
                }
            });

            document.querySelectorAll('[id^=alreadyDevelopedDropdown]').forEach(btn => {
                btn.setAttribute('aria-expanded', false);
            });
        });
    </script>


    <script>
        function toggleCustomerDecisionDropdownTable(event, id) {
            event.stopPropagation();
            const menu = document.getElementById('customerDecisionDropdownMenuTable-' + id);
            const btn = document.getElementById('customerDecisionDropdownTable-' + id);
            const expanded = btn.getAttribute('aria-expanded') === 'true';

            menu.classList.toggle('hidden');
            btn.setAttribute('aria-expanded', !expanded);
        }

        function selectCustomerDecisionTable(status, id) {
            const span = document.getElementById('selectedCustomerDecisionTable-' + id);
            const btn = document.getElementById('customerDecisionDropdownTable-' + id);
            const menu = document.getElementById('customerDecisionDropdownMenuTable-' + id);

            // Update span text
            span.innerText = status;

            // Remove color classes
            btn.classList.remove(
                'bg-white', 'bg-green-100', 'bg-yellow-100', 'bg-red-100', 'bg-gray-100',
                'text-gray-800', 'text-green-800', 'text-yellow-800', 'text-red-800',
                'dark:bg-red-700', 'dark:bg-green-700', 'dark:bg-yellow-700', 'dark:bg-gray-700',
                'dark:text-white'
            );

            // Add new color
            if (status === 'Order Received') {
                btn.classList.add('bg-green-100', 'text-green-800', 'dark:bg-green-700', 'dark:text-white');
            } else if (status === 'Order Not Received') {
                btn.classList.add('bg-yellow-100', 'text-yellow-800', 'dark:bg-yellow-700', 'dark:text-white');
            } else if (status === 'Order Rejected') {
                btn.classList.add('bg-red-100', 'text-red-800', 'dark:bg-red-700', 'dark:text-white');
            } else {
                btn.classList.add('bg-gray-100', 'text-gray-800', 'dark:bg-gray-700', 'dark:text-white');
            }

            // Hide dropdown
            menu.classList.add('hidden');
            btn.setAttribute('aria-expanded', false);
        }

        document.addEventListener('click', function(e) {
            document.querySelectorAll('[id^="customerDecisionDropdownMenuTable"]').forEach(menu => {
                if (!menu.contains(e.target)) {
                    menu.classList.add('hidden');
                }
            });

            document.querySelectorAll('[id^="customerDecisionDropdownTable"]').forEach(btn => {
                btn.setAttribute('aria-expanded', false);
            });
        });
    </script>


    <script>
        function toggleDropdown(id) {
            document.getElementById(`dropdownMenu${id}`).classList.toggle('hidden');
        }

        document.addEventListener('click', function(event) {
            // Hide all open dropdowns when clicked outside
            document.querySelectorAll('[id^="dropdownMenu"]').forEach(menu => {
                if (!menu.contains(event.target) && !event.target.closest(
                        '[id^="developmentStatusDropdown"]')) {
                    menu.classList.add('hidden');
                }
            });
        });
    </script>
    <script>
        function toggleSentOrderToSampleDevelopment(event, button) {
            const isPending = button.textContent.trim() === 'Pending';
            const container = button.closest('.colour-match-sent');
            const timestamp = container.querySelector('.timestamp');

            if (isPending) {
                // Mark as Done
                button.textContent = 'sent';
                button.classList.remove('bg-gray-300', 'text-black', 'hover:bg-gray-400');
                button.classList.add('bg-[#FF9119]', 'text-white', 'hover:bg-[#FF9119]/80');

                const now = new Date();
                timestamp.textContent = `sent on ${now.toLocaleDateString()} at ${now.toLocaleTimeString()}`;
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
        document.addEventListener("DOMContentLoaded", function() {
            const today = new Date().toISOString().split('T')[0];
            document.getElementById("inquiryDate").value = today;
        });
    </script>
    <script>
        document.getElementById('clearFiltersBtn').addEventListener('click', function() {
            // Reload the page to clear all filters and reset state
            window.location.href = window.location.pathname;
        });
    </script>

    <script>
        function toggleFilterForm() {
            const form = document.getElementById('filterFormContainer');
            form.classList.toggle('hidden');
        }
    </script>
@endsection
