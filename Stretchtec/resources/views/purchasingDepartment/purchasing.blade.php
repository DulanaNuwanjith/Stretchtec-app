@php use Carbon\Carbon; @endphp

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<div class="flex h-full w-full bg-white">
    @extends('layouts.purchasing-tabs')

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

            <script>
                function confirmDelete(id) {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "This record will be permanently deleted!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3b82f6',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Yes, delete it!',
                        background: '#ffffff',
                        color: '#3b82f6',
                        customClass: {
                            popup: 'swal2-toast swal2-shadow'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById(`delete-form-${id}`).submit();
                        }
                    });
                }
            </script>

           {{-- Filters --}}
            <div class="flex justify-start">
                <button onclick="toggleFilterForm()"
                    class="bg-white border border-blue-500 text-blue-500 hover:text-blue-600 font-semibold py-1 px-3 rounded shadow flex items-center gap-2 mb-6">
                    <img src="{{ asset('icons/filter.png') }}" class="w-6 h-6" alt="Filter Icon">
                    Filters
                </button>
            </div>

            <div id="filterFormContainer" class="hidden mt-4">
                <form id="filterForm" method="GET" action="{{ route('purchasing.index') }}" class="mb-6">
                    <div class="flex items-center gap-4 flex-wrap">

                        {{-- Filter: PO Number --}}
                        <div class="relative inline-block text-left w-48">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">PO Number</label>
                            <input type="hidden" name="po_number" id="poNumberInput" value="{{ request('po_number') }}">

                            <button type="button" id="poDropdown" onclick="toggleDropdown('poDropdown', 'poNumberDropdownMenu')"
                                class="inline-flex w-full justify-between rounded-md bg-white px-3 py-2 text-sm font-semibold
                                    text-gray-900 shadow-sm ring-1 ring-gray-300 hover:bg-gray-50 h-10 dark:bg-gray-700 dark:text-white"
                                aria-expanded="false">
                                <span id="selectedPONumber">{{ request('po_number') ?? 'Select PO Number' }}</span>
                                <svg class="ml-2 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 10.94l3.71-3.71a.75.75 0 1 1 1.06 1.06l-4.24
                                        4.24a.75.75 0 0 1-1.06 0L5.25 8.29a.75.75 0 0 1-.02-1.08z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>

                            <div id="poNumberDropdownMenu"
                                class="absolute z-40 mt-1 w-full bg-white border rounded-lg shadow-lg hidden max-h-48 overflow-y-auto p-2">
                                <input type="text" id="poNumberSearch" onkeyup="filterDropdown('.po-number-option', 'poNumberSearch')"
                                    placeholder="Search..."
                                    class="w-full px-2 py-1 text-sm border rounded-md dark:bg-gray-600 dark:text-white dark:placeholder-gray-300">

                                @foreach ($uniquePoNumbersAll as $po)
                                    <div onclick="selectDropdownValue('poDropdown', 'poNumberDropdownMenu', 'selectedPONumber', 'poNumberInput', '{{ $po }}', 'Select PO Number')"
                                        class="po-number-option px-4 py-2 hover:bg-gray-100 cursor-pointer text-sm">
                                        {{ $po }}
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Filter: Supplier (updated to searchable dropdown) --}}
                        <div class="relative inline-block text-left w-48">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Supplier</label>
                            <input type="hidden" name="supplier" id="supplierInput" value="{{ request('supplier') }}">

                            <button type="button" id="supplierDropdown" onclick="toggleDropdown('supplierDropdown', 'supplierDropdownMenu')"
                                class="inline-flex w-full justify-between rounded-md bg-white px-3 py-2 text-sm font-semibold
                                    text-gray-900 shadow-sm ring-1 ring-gray-300 hover:bg-gray-50 h-10 dark:bg-gray-700 dark:text-white"
                                aria-expanded="false">
                                <span id="selectedSupplier">{{ request('supplier') ?? 'Select Supplier' }}</span>
                                <svg class="ml-2 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 10.94l3.71-3.71a.75.75 0 1 1 1.06 1.06l-4.24
                                        4.24a.75.75 0 0 1-1.06 0L5.25 8.29a.75.75 0 0 1-.02-1.08z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>

                            <div id="supplierDropdownMenu"
                                class="absolute z-40 mt-1 w-full bg-white border rounded-lg shadow-lg hidden max-h-48 overflow-y-auto p-2">
                                <input type="text" id="supplierSearch" onkeyup="filterDropdown('.supplier-option', 'supplierSearch')"
                                    placeholder="Search..."
                                    class="w-full px-2 py-1 text-sm border rounded-md dark:bg-gray-600 dark:text-white dark:placeholder-gray-300">

                                @foreach ($suppliers as $supplier)
                                    <div onclick="selectDropdownValue('supplierDropdown', 'supplierDropdownMenu', 'selectedSupplier', 'supplierInput', '{{ $supplier }}', 'Select Supplier')"
                                        class="supplier-option px-4 py-2 hover:bg-gray-100 cursor-pointer text-sm">
                                        {{ $supplier }}
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Filter: PO Date --}}
                        <div class="w-48">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">PO Date</label>
                            <input type="date" name="po_date" value="{{ request('po_date') }}"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 text-sm">
                        </div>

                        {{-- Filter Buttons --}}
                        <div class="flex items-end space-x-2 mt-2">
                            <button type="submit"
                                class="mt-4 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                                Apply Filters
                            </button>

                            <button type="button" onclick="clearFilters()"
                                class="mt-4 bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-200 px-4 py-2 rounded hover:bg-gray-300">
                                Clear
                            </button>
                        </div>

                    </div>
                </form>
            </div>




            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">
                    Purchase Department Records
                </h1>
                <div class="flex space-x-3">
                    <button onclick="document.getElementById('addPurchaseModal').classList.remove('hidden')"
                        class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded shadow">
                        + Add New Purchase Order
                    </button>

                    <button onclick="document.getElementById('orderPopupModal').classList.remove('hidden')"
                        class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded shadow">
                        View & Update Orders
                    </button>
                </div>
            </div>

            <!-- Orders Popup Modal -->
            <div id="orderPopupModal"
                class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
                <div
                    class="bg-white dark:bg-gray-900 w-11/12 max-w-9xl rounded-2xl shadow-lg overflow-y-auto max-h-[90vh] relative p-6">

                    <!-- Close Button -->
                    <button onclick="closeOrderPopup()"
                        class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 text-xl">
                        ✖
                    </button>

                    <h2 class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-100">
                        Manage & Update Purchase Orders
                    </h2>

                    <!-- Search Bar -->
                    <div class="mb-6">
                        <form id="orderSearchForm" method="GET" action="{{ route('purchasing.index') }}" class="flex items-center space-x-2 max-w-2xl">
                            <!-- Preserve order_page parameter -->
                            <input type="hidden" name="order_page" value="{{ request('order_page', 1) }}">

                            <input type="text" name="order_search" id="orderSearchInput" value="{{ request('order_search') }}"
                                placeholder="Search by Order No, Customer, Reference, Item, Shade, TKT, Supplier, PST No"
                                autocomplete="off"
                                class="px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition duration-200 ease-in-out" />

                            <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm whitespace-nowrap">
                                Search
                            </button>

                            <a href="javascript:void(0)" onclick="clearOrderSearch()" id="orderClearBtn"
                                class="px-4 py-2 bg-gray-400 text-white rounded hover:bg-gray-500 text-sm whitespace-nowrap select-none">
                                Clear
                            </a>
                        </form>
                    </div>

                    <!-- Loading Overlay -->
                    <div id="orderModalLoadingSpinner" class="hidden">
                        <div class="flex items-center justify-center py-8">
                            <svg class="animate-spin h-10 w-10 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- Table Container -->
                    <div id="orderTableContainer"
                        class="overflow-x-auto border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm">
                        <table class="min-w-full border-collapse">
                            <thead class="bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300">
                                <tr class="text-center">
                                    <th
                                        class="font-bold sticky left-0 top-0 z-20 bg-white px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                        Order No
                                    </th>
                                    <th
                                        class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase">
                                        Customer
                                    </th>
                                    <th
                                        class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase">
                                        Reference No
                                    </th>
                                    <th
                                        class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase">
                                        Item
                                    </th>
                                    <th
                                        class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-24 text-xs text-gray-600 dark:text-gray-300 uppercase">
                                        Size
                                    </th>
                                    <th
                                        class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-24 text-xs text-gray-600 dark:text-gray-300 uppercase">
                                        Color
                                    </th>
                                    <th
                                        class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-24 text-xs text-gray-600 dark:text-gray-300 uppercase">
                                        Shade
                                    </th>
                                    <th
                                        class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-24 text-xs text-gray-600 dark:text-gray-300 uppercase">
                                        TKT
                                    </th>
                                    <th
                                        class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-24 text-xs text-gray-600 dark:text-gray-300 uppercase">
                                        Quantity
                                    </th>
                                    <th
                                        class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase">
                                        Supplier
                                    </th>
                                    <th
                                        class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-28 text-xs text-gray-600 dark:text-gray-300 uppercase">
                                        PST No
                                    </th>
                                    <th
                                        class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-36 text-xs text-gray-600 dark:text-gray-300 uppercase">
                                        Supplier Comment
                                    </th>
                                    <th
                                        class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-40 text-xs text-gray-600 dark:text-gray-300 uppercase">
                                        Mark Raw Material Ordered
                                    </th>

                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                                @forelse($orderPreparations as $order)
                                    <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200 text-center">
                                        <!-- Sticky first column -->
                                        <td
                                            class="px-4 py-3 font-bold sticky left-0 z-10 bg-gray-100 whitespace-normal break-words border-r border-gray-300 text-blue-500 text-sm">
                                            {{ $order->prod_order_no ?? 'N/A' }}
                                        </td>
                                        <td class="px-4 py-3 border-r border-gray-300 text-sm">{{ $order->customer_name ?? '-' }}
                                        </td>
                                        <td class="px-4 py-3 border-r border-gray-300 text-sm">{{ $order->reference_no ?? '-' }}
                                        </td>
                                        <td class="px-4 py-3 border-r border-gray-300 text-sm">{{ $order->item ?? '-' }}</td>
                                        <td class="px-4 py-3 border-r border-gray-300 text-sm">{{ $order->size ?? '-' }}</td>
                                        <td class="px-4 py-3 border-r border-gray-300 text-sm">{{ $order->color ?? '-' }}</td>
                                        <td class="px-4 py-3 border-r border-gray-300 text-sm">{{ $order->shade ?? '-' }}</td>
                                        <td class="px-4 py-3 border-r border-gray-300 text-sm">{{ $order->tkt ?? '-' }}</td>
                                        <td class="px-4 py-3 border-r border-gray-300 text-sm">{{ $order->qty ?? 0 }} {{ $order->uom ?? '-' }}</td>
                                        <td class="px-4 py-3 border-r border-gray-300 text-sm">{{ $order->supplier ?? '-' }}</td>
                                        <td class="px-4 py-3 border-r border-gray-300 text-sm">{{ $order->pst_no ?? '-' }}</td>
                                        <td class="px-4 py-3 border-r border-gray-300 text-sm">
                                            {{ $order->supplier_comment ?? '-' }}</td>

                                        <!-- Mark Raw Material Ordered -->
                                        <td class="py-3 whitespace-normal break-words border-r border-gray-300 text-center">
                                            <div class="flex flex-col items-center justify-center">

                                                @if ($order->isRawMaterialOrdered)
                                                    <!-- Banner showing ordered timestamp -->
                                                    <span
                                                        class="inline-block m-1 text-sm font-semibold text-gray-700 dark:text-white bg-blue-100 dark:bg-gray-800 px-3 py-1 rounded">
                                                        Ordered on <br>
                                                        {{ Carbon::parse($order->raw_material_ordered_date)->format('Y-m-d') }}
                                                        at
                                                        {{ Carbon::parse($order->raw_material_ordered_date)->format('H:i') }}
                                                    </span>

                                                @else
                                                    @php
                                                        $deadlineSet = $order->source_order?->production_deadline !== null;
                                                    @endphp

                                                    <form action="{{ route('orders.markOrdered', $order->id) }}"
                                                          method="POST" onsubmit="handleSubmit(this)">
                                                        @csrf
                                                        @method('PATCH')

                                                        <button type="submit"
                                                                class="px-3 py-1 mt-4 text-xs rounded-lg flex items-center justify-center
                                                            {{ $deadlineSet ? 'bg-blue-100 text-blue-700 hover:bg-blue-200' : 'bg-gray-200 text-gray-400 cursor-not-allowed' }}"
                                                            {{ $deadlineSet ? '' : 'disabled' }}>
                                                            Mark as Ordered
                                                        </button>

                                                    </form>

                                                    @unless($deadlineSet)
                                                        <span class="text-[11px] text-red-500 mt-1">
                                                            Set production deadline first
                                                        </span>
                                                    @endunless

                                                @endif

                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="15" class="px-4 py-3 text-center text-gray-500 dark:text-gray-400">
                                            No orders available.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{-- Pagination --}}
                    <div id="orderPaginationContainer" class="py-6 flex justify-center">
                        {{ $orderPreparations->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>


            <!-- Add Purchase Modal -->
            <div id="addPurchaseModal"
                class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center py-5">
                <div class="w-full max-w-[700px] bg-white dark:bg-gray-900 rounded-2xl shadow-2xl p-4 transform transition-all scale-95 max-h-[calc(100vh-10rem)] overflow-y-auto"
                    onclick="event.stopPropagation()">
                    <div class="max-w-[600px] mx-auto p-8">
                        <h2 class="text-2xl font-semibold mb-8 text-blue-900 mt-4 dark:text-gray-100 text-center">
                            Add New Purchase Order
                        </h2>

                        <!-- Purchase Order Form -->
                        <form id="purchaseOrderForm" action="{{ route('purchasing.store') }}" method="POST">
                            @csrf

                            <!-- Master PO Fields -->
                            <div class="mt-3">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    PO Number
                                </label>
                                <input type="text" name="po_number" required
                                    class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                    placeholder="Enter Purchase Order Number">
                            </div>

                            <div class="mt-3">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    PO Date
                                </label>
                                <input type="date" name="po_date" required
                                    class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                            </div>

                            <div class="mt-3">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Supplier
                                </label>
                                <input type="text" name="supplier" required
                                    class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                    placeholder="Enter Supplier Name">
                            </div>

                            <!-- Item Container -->
                            <div id="purchaseItemsContainer" class="mt-6"></div>

                            <!-- Add Item Button -->
                            <button type="button" id="addPurchaseItemBtn"
                                class="mt-4 px-4 py-2 bg-green-500 hover:bg-green-600 text-white text-sm rounded">
                                + Add Item
                            </button>

                            <div class="mt-4">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Total Amount
                                </label>
                                <input type="number" step="0.01" name="total_amount" required
                                    class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                    placeholder="Enter Total Amount">
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex justify-end mt-6 space-x-3">
                                <button type="button"
                                    onclick="document.getElementById('addPurchaseModal').classList.add('hidden')"
                                    class="px-4 py-2 bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-200 text-sm rounded hover:bg-gray-300">
                                    Cancel
                                </button>
                                <button type="submit" id="createPurchaseBtn"
                                    class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white text-sm rounded">
                                    Create Purchase Order
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Collapsible Purchase Order Table -->
            <div class="overflow-x-auto max-h-[1200px] bg-white dark:bg-gray-900 shadow rounded-lg">

                <!-- Spinner -->
                <div id="pageLoadingSpinner"
                    class="fixed inset-0 z-50 bg-white bg-opacity-80 flex flex-col items-center justify-center">
                    <svg class="animate-spin h-10 w-10 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>
                    <p class="mt-3 text-gray-700 font-semibold">Loading data...</p>
                </div>

                <table class="table-fixed w-full text-sm divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-100 dark:bg-gray-700">
                        <tr class="text-center">

                            <!-- Parent row headings -->
                            <th
                                class="font-bold sticky left-0 z-10 bg-white px-4 py-3 w-36 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                PO Number
                            </th>
                            <th
                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-36 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                PO Date
                            </th>
                            <th
                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                Supplier
                            </th>

                            <!-- Only shown for item rows -->
                            <th
                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                Shade
                            </th>
                            <th
                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                Color
                            </th>
                            <th
                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                TKT
                            </th>
                            <th
                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                PST No
                            </th>
                            <th
                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                Supplier Comment
                            </th>
                            <th
                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                Quantity
                            </th>
                            <th
                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                Rate
                            </th>
                            <th
                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                Amount
                            </th>
                            <th
                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                Total Amount
                            </th>
                            <th
                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                Status
                            </th>

                            <th class="sticky top-0 bg-gray-200 px-4 py-3 w-32 text-xs font-bold uppercase text-gray-600">
                                Actions
                            </th>

                        </tr>
                    </thead>

                    @forelse ($groupedPurchaseOrders as $poNumber => $items)
                        @php
                            $hasMultipleItems = $items->count() > 1;
                            $first = $items->first();
                        @endphp

                        <tbody x-data="{ open: false }" class="divide-y divide-gray-200 dark:divide-gray-600">
                            <!-- Parent Row -->
                            <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200 text-center">

                                <!-- Expand PO Number -->
                                <td
                                    class="sticky left-0 z-10 bg-white px-4 py-3 text-sm bg-gray-100 border-r border-gray-300 text-left whitespace-normal break-words font-bold">
                                    @if ($hasMultipleItems)
                                        <button @click="open = !open"
                                            class="flex items-center w-full gap-2 text-blue-600 hover:text-blue-800">
                                            <span class="w-2 shrink-0" x-text="open ? '▾' : '▸'"></span>

                                            <!-- centered PO number -->
                                            <span class="flex-1 text-center">{{ $poNumber }}</span>
                                        </button>
                                    @else
                                        <div class="flex items-center w-full gap-2">
                                            <!-- invisible placeholder to preserve left spacing -->
                                            <span class="w-1 shrink-0 opacity-0" aria-hidden="true">></span>

                                            <!-- centered PO number -->
                                            <span class="flex-1 text-center">{{ $poNumber }}</span>
                                        </div>
                                    @endif
                                </td>

                                <!-- PO Date -->
                                <td class="px-2 py-4 text-sm text-gray-800 dark:text-gray-200 border-r break-words">
                                    {{ $first->po_date }}</td>

                                <!-- Supplier -->
                                <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 border-r break-words">
                                    {{ $first->supplier }}</td>

                                <!-- Single Item View -->
                                @if (!$hasMultipleItems)
                                    <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 border-r break-words">
                                        {{ $first->shade }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 border-r break-words">
                                        {{ $first->color }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 border-r break-words">
                                        {{ $first->tkt }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 border-r break-words">
                                        {{ $first->pst_no }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 border-r break-words">
                                        {{ $first->supplier_comment }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 border-r break-words">
                                        {{ $first->quantity }} {{ $first->uom }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 border-r break-words">
                                        {{ $first->rate }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 border-r break-words">
                                        {{ $first->amount }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 border-r break-words">
                                        {{ $first->total_amount }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 border-r break-words">
                                        <span
                                            class="px-2 py-1 rounded-full text-xs font-semibold
                                        @if ($first->status === 'Pending') bg-yellow-100 text-yellow-800
                                        @elseif($first->status === 'Approved') bg-green-100 text-green-800
                                        @elseif($first->status === 'Rejected') bg-red-100 text-red-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                            {{ $first->status }}
                                        </span>
                                    </td>
                                @else
                                    <!-- Parent shows the first item -->
                                    <td
                                        class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 border-r text-center break-words">
                                        {{ $first->shade }}</td>
                                    <td
                                        class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 border-r text-center break-words">
                                        {{ $first->color }}</td>
                                    <td
                                        class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 border-r text-center break-words">
                                        {{ $first->tkt }}</td>
                                    <td
                                        class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 border-r text-center break-words">
                                        {{ $first->pst_no }}</td>
                                    <td
                                        class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 border-r text-center break-words">
                                        {{ $first->supplier_comment }}</td>
                                    <td
                                        class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 border-r text-center break-words">
                                        {{ $first->quantity }} {{ $first->uom }}</td>
                                    <td
                                        class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 border-r text-center break-words">
                                        {{ $first->rate }}</td>
                                    <td
                                        class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 border-r text-center break-words">
                                        {{ $first->amount }}</td>

                                    <!-- Total + Status -->
                                    <td
                                        class="px-4 py-3 text-sm text-gray-800 dark:text-gray-200 border-r text-center break-words">
                                        {{ $first->total_amount }}</td>
                                    <td
                                        class="px-4 py-3 text-sm text-gray-800 dark:text-gray-200 border-r text-center break-words">
                                        <span
                                            class="px-2 py-1 rounded-full text-xs font-semibold
                                        @if ($first->status === 'Pending') bg-yellow-100 text-yellow-800
                                        @elseif($first->status === 'Approved') bg-green-100 text-green-800
                                        @elseif($first->status === 'Rejected') bg-red-100 text-red-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                            {{ $first->status }}
                                        </span>
                                    </td>
                                @endif
                                <!-- Actions -->
                                <td class="px-4 py-3 whitespace-normal break-words text-center">
                                    <div class="flex space-x-2 justify-center items-center">
                                        @if (Auth::user()->role === 'SUPERADMIN')
                                            <form id="delete-form-{{ $poNumber }}"
                                                action="{{ route('purchasing.destroy', $poNumber) }}" method="POST"
                                                class="flex items-center">

                                                @csrf
                                                @method('DELETE')

                                                <button type="button" onclick="confirmDelete('{{ $poNumber }}')"
                                                    class="bg-red-600 h-10 mt-3 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">
                                                    Delete
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>

                            <!-- Collapsible Child Rows -->
                            @if ($hasMultipleItems)
                                @foreach ($items->skip(1) as $item)
                                    <tr x-show="open" style="display: none;" class="bg-gray-50">

                                        <!-- Empty parent columns -->
                                        <td class="sticky left-0 z-10 border-r bg-white"></td>
                                        <td
                                            class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 border-r text-center">
                                        </td>
                                        <td
                                            class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 border-r text-center">
                                        </td>

                                        <!-- Item Columns -->
                                        <td
                                            class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 border-r text-center break-words">
                                            {{ $item->shade }}</td>
                                        <td
                                            class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 border-r text-center break-words">
                                            {{ $item->color }}</td>
                                        <td
                                            class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 border-r text-center break-words">
                                            {{ $item->tkt }}</td>
                                        <td
                                            class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 border-r text-center break-words">
                                            {{ $item->pst_no }}</td>
                                        <td
                                            class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 border-r text-center break-words">
                                            {{ $item->supplier_comment }}</td>
                                        <td
                                            class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 border-r text-center break-words">
                                            {{ $item->quantity }} {{ $item->uom }}</td>
                                        <td
                                            class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 border-r text-center break-words">
                                            {{ $item->rate }}</td>
                                        <td
                                            class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 border-r text-center break-words">
                                            {{ $item->amount }}</td>
                                        <td
                                            class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 border-r text-center">
                                            -</td>
                                        <td
                                            class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 border-r text-center">
                                            <span class="px-2 py-1 rounded-full text-xs font-semibold text-center">-</span>
                                        </td>
                                        <td class="px-4 py-2">
                                            <span class="px-2 py-1 rounded-full text-xs font-semibold text-center"></span>
                                        </td>

                                    </tr>
                                @endforeach
                            @endif

                        </tbody>
                        @empty
                            <tr>
                                <td colspan="14"
                                    class="text-center px-6 py-6 text-gray-500 text-sm italic">
                                    No records found.
                                </td>
                            </tr>
                    @endforelse
                </table>
            </div>

            {{-- Pagination --}}
            <div class="py-6 flex justify-center">
                {{ $uniquePoNumbers->links() }}
            </div>
        </div>
        </div>
        </div>
        </div>
        </div>


        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const spinner = document.getElementById("pageLoadingSpinner");

                // Show spinner immediately
                spinner.classList.remove("hidden");

                // Wait for table to render completely
                window.requestAnimationFrame(() => {
                    spinner.classList.add("hidden"); // hide spinner after rendering
                });
            });
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const form = document.querySelector('#addPurchaseModal form');
                const submitBtn = document.getElementById('createPurchaseBtn');

                form.addEventListener('submit', function() {
                    // Disable the button to prevent multiple clicks
                    submitBtn.disabled = true;
                    submitBtn.innerText = 'Submitting...';
                });
            });
        </script>

        <script>
            let purchaseItemIndex = 0;

            const addPurchaseItemBtn = document.getElementById('addPurchaseItemBtn');
            const container = document.getElementById('purchaseItemsContainer');
            const totalAmountInput = document.querySelector('input[name="total_amount"]');

            // Add new item block dynamically
            addPurchaseItemBtn.addEventListener('click', () => {
                const itemHTML = getPurchaseItemFields(purchaseItemIndex++);
                container.insertAdjacentHTML('beforeend', itemHTML);
                attachItemListeners(); // attach events to new item inputs
                calculateTotalAmount(); // recalc after adding
            });

            // Remove an item block
            function removePurchaseItem(btn) {
                btn.closest('.purchase-item-block').remove();
                calculateTotalAmount(); // recalc after removing
            }

            // Template for purchase item fields
            function getPurchaseItemFields(index) {
                return `
        <div class="purchase-item-block border rounded-lg p-4 mt-4 bg-gray-50 dark:bg-gray-800 relative">
            <button type="button" onclick="removePurchaseItem(this)"
                    class="absolute top-2 right-2 text-red-500 hover:text-red-700 text-sm">✖</button>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Shade</label>
                    <input type="text" name="items[${index}][shade]" required
                        class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Color</label>
                    <input type="text" name="items[${index}][color]" required
                        class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3 mt-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">TKT</label>
                    <input type="text" name="items[${index}][tkt]" required
                        class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">PST No</label>
                    <input type="text" name="items[${index}][pst_no]"
                        class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                </div>
            </div>

            <div class="mt-3">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Supplier Comment</label>
                <textarea name="items[${index}][supplier_comment]" rows="2"
                    class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm"></textarea>
            </div>

            <div class="grid grid-cols-2 gap-3 mt-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">UOM</label>
                    <select name="items[${index}][uom]" required
                        class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                        <option value="" disabled selected>Select Unit</option>
                        <option value="g">Gram (g)</option>
                        <option value="kg">Kilogram (kg)</option>
                        <option value="m">Meter (m)</option>
                        <option value="y">Yard</option>
                        <option value="cone">Cone</option>
                        <option value="pcs">Piece</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Quantity</label>
                    <input type="number" step="0.01" name="items[${index}][quantity]" required
                        class="quantity-input w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3 mt-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Rate</label>
                    <input type="number" step="0.01" name="items[${index}][rate]" required
                        class="rate-input w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Amount</label>
                    <input type="number" step="0.01" name="items[${index}][amount]" required readonly
                        class="amount-input w-full mt-1 px-3 py-2 border rounded-md bg-gray-100 dark:bg-gray-600 dark:text-white text-sm">
                </div>
            </div>
        </div>`;
            }

            // Attach listeners to quantity and rate fields for auto-calculation
            function attachItemListeners() {
                const itemBlocks = document.querySelectorAll('.purchase-item-block');
                itemBlocks.forEach(block => {
                    const quantityInput = block.querySelector('.quantity-input');
                    const rateInput = block.querySelector('.rate-input');
                    const amountInput = block.querySelector('.amount-input');

                    const updateAmount = () => {
                        const qty = parseFloat(quantityInput.value) || 0;
                        const rate = parseFloat(rateInput.value) || 0;
                        const amount = qty * rate;
                        amountInput.value = amount.toFixed(2);
                        calculateTotalAmount(); // update grand total
                    };

                    quantityInput.removeEventListener('input', updateAmount);
                    rateInput.removeEventListener('input', updateAmount);

                    quantityInput.addEventListener('input', updateAmount);
                    rateInput.addEventListener('input', updateAmount);
                });
            }

            // Calculate and update the total amount across all items
            function calculateTotalAmount() {
                let total = 0;
                const amountInputs = document.querySelectorAll('.amount-input');
                amountInputs.forEach(input => {
                    const value = parseFloat(input.value) || 0;
                    total += value;
                });
                totalAmountInput.value = total.toFixed(2);
            }

            // Initialize event listeners
            attachItemListeners();
        </script>

        <script>
            function openOrderPopup() {
                // Clear default 'page' param and add order_page parameter to maintain modal state
                const url = new URL(window.location);
                url.searchParams.delete('page'); // Remove main table pagination
                if (!url.searchParams.has('order_page') && !url.searchParams.has('order_search')) {
                    url.searchParams.set('order_page', '1');
                }
                window.history.pushState({}, '', url);
                document.getElementById('orderPopupModal').classList.remove('hidden');
            }

            function closeOrderPopup() {
                // Remove order_page and order_search parameters when closing modal
                const url = new URL(window.location);
                url.searchParams.delete('order_page');
                url.searchParams.delete('order_search');
                window.history.pushState({}, '', url);
                document.getElementById('orderPopupModal').classList.add('hidden');
            }

            // Keep modal open if order_page or order_search parameter exists (from pagination or search)
            document.addEventListener('DOMContentLoaded', function() {
                const urlParams = new URLSearchParams(window.location.search);
                if (urlParams.has('order_page') || urlParams.has('order_search')) {
                    document.getElementById('orderPopupModal').classList.remove('hidden');
                }

                // Setup AJAX pagination for modal
                setupModalPagination();

                // Setup AJAX search for modal
                setupModalSearch();
            });

            // AJAX Search for Orders Modal
            function setupModalSearch() {
                const searchForm = document.getElementById('orderSearchForm');
                if (searchForm) {
                    searchForm.addEventListener('submit', function(e) {
                        e.preventDefault();

                        const formData = new FormData(searchForm);
                        const searchValue = formData.get('order_search');

                        loadModalPage(1, searchValue);
                    });
                }
            }

            // Clear search function
            function clearOrderSearch() {
                document.getElementById('orderSearchInput').value = '';
                loadModalPage(1, '');
            }

            // AJAX Pagination for Orders Modal
            function setupModalPagination() {
                // Intercept pagination link clicks inside the modal
                document.addEventListener('click', function(e) {
                    // Check if clicked element is a pagination link inside the order modal
                    const paginationLink = e.target.closest('#orderPaginationContainer a');

                    if (paginationLink) {
                        e.preventDefault();

                        const url = new URL(paginationLink.href);
                        const orderPage = url.searchParams.get('order_page');
                        const orderSearch = url.searchParams.get('order_search') || '';

                        if (orderPage) {
                            loadModalPage(orderPage, orderSearch);
                        }
                    }
                });
            }

            // Load modal page via AJAX
            function loadModalPage(page, search = '') {
                // Show loading overlay
                const tableContainer = document.getElementById('orderTableContainer');
                const paginationContainer = document.getElementById('orderPaginationContainer');
                const loadingSpinner = document.getElementById('orderModalLoadingSpinner');

                tableContainer.style.opacity = '0.4';
                paginationContainer.style.opacity = '0.4';
                loadingSpinner.classList.remove('hidden');

                // Build request URL
                const params = new URLSearchParams();
                params.set('order_page', page);
                if (search) {
                    params.set('order_search', search);
                }
                params.set('ajax', '1'); // Add ajax flag

                // Fetch new page content
                fetch(`{{ route('purchasing.index') }}?${params.toString()}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(html => {
                    // Parse the HTML response
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');

                    // Extract table and pagination from response
                    const newTable = doc.querySelector('#orderTableContainer table');
                    const newPagination = doc.querySelector('#orderPaginationContainer');

                    if (newTable && newPagination) {
                        // Update table content
                        tableContainer.querySelector('table').innerHTML = newTable.innerHTML;

                        // Update pagination
                        paginationContainer.innerHTML = newPagination.innerHTML;

                        // Update search input and clear button visibility
                        const searchInput = document.getElementById('orderSearchInput');
                        const clearBtn = document.getElementById('orderClearBtn');
                        if (searchInput) {
                            searchInput.value = search;
                        }
                        if (clearBtn) {
                            if (search) {
                                clearBtn.classList.remove('hidden');
                            } else {
                                clearBtn.classList.add('hidden');
                            }
                        }

                        // Update URL without reload
                        const newUrl = new URL(window.location);
                        newUrl.searchParams.set('order_page', page);
                        if (search) {
                            newUrl.searchParams.set('order_search', search);
                        } else {
                            newUrl.searchParams.delete('order_search');
                        }
                        window.history.pushState({}, '', newUrl);
                    }

                    // Hide loading overlay with smooth animation after rendering
                    window.requestAnimationFrame(() => {
                        loadingSpinner.classList.add('hidden');
                        tableContainer.style.opacity = '1';
                        paginationContainer.style.opacity = '1';
                    });
                })
                .catch(error => {
                    console.error('Error loading page:', error);
                    window.requestAnimationFrame(() => {
                        loadingSpinner.classList.add('hidden');
                        tableContainer.style.opacity = '1';
                        paginationContainer.style.opacity = '1';
                    });
                    alert('Failed to load page. Please try again.');
                });
            }

            // Optional: Close modal when clicking outside content
            window.addEventListener('click', function(e) {
                const modal = document.getElementById('orderPopupModal');
                if (e.target === modal) closeOrderPopup();
            });
        </script>

       <script>
        function toggleFilterForm() {
            document.getElementById('filterFormContainer').classList.toggle('hidden');
        }

        // ===== Dropdown functions =====
        function toggleDropdown(btnId, menuId) {
            const btn = document.getElementById(btnId);
            const menu = document.getElementById(menuId);
            const expanded = btn.getAttribute('aria-expanded') === 'true';
            menu.classList.toggle('hidden');
            btn.setAttribute('aria-expanded', !expanded);
        }

        function selectDropdownValue(btnId, menuId, selectedId, inputId, value, defaultText) {
            document.getElementById(selectedId).innerText = value || defaultText;
            document.getElementById(inputId).value = value;
            closeDropdown(btnId, menuId);
        }

        function filterDropdown(optionClass, inputId) {
            const input = document.getElementById(inputId).value.toLowerCase();
            const items = document.querySelectorAll(optionClass);
            items.forEach(item => {
                const text = item.textContent.toLowerCase();
                item.style.display = text.includes(input) ? 'block' : 'none';
            });
        }

        function closeDropdown(btnId, menuId) {
            const btn = document.getElementById(btnId);
            const menu = document.getElementById(menuId);
            menu.classList.add('hidden');
            btn.setAttribute('aria-expanded', false);
        }

        function clearFilters() {
            // Clear PO Number
            document.getElementById('selectedPONumber').innerText = 'Select PO Number';
            document.getElementById('poNumberInput').value = '';
            document.getElementById('poNumberSearch').value = '';
            filterDropdown('.po-number-option', 'poNumberSearch');

            // Clear Supplier
            document.getElementById('selectedSupplier').innerText = 'Select Supplier';
            document.getElementById('supplierInput').value = '';
            document.getElementById('supplierSearch').value = '';
            filterDropdown('.supplier-option', 'supplierSearch');

            // Clear PO Date
            document.querySelector('input[name="po_date"]').value = '';

            // Reset the form just in case
            document.getElementById('filterForm').reset();

            // Reload page to clear query parameters
            window.location.href = "{{ route('purchasing.index') }}";
        }

        // Close dropdown if click outside
        document.addEventListener('click', function(e) {
            const dropdowns = [
                { btn: 'poDropdown', menu: 'poNumberDropdownMenu' },
                { btn: 'supplierDropdown', menu: 'supplierDropdownMenu' },
            ];
            dropdowns.forEach(d => {
                const btn = document.getElementById(d.btn);
                const menu = document.getElementById(d.menu);
                if (!btn.contains(e.target) && !menu.contains(e.target)) {
                    closeDropdown(d.btn, d.menu);
                }
            });
        });
    </script>


    @endsection
