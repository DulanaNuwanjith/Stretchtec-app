@php
    use Carbon\Carbon;
    use Illuminate\Support\Facades\Auth;
@endphp

<head>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <!-- Include Flatpickr (CDN) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <title>Stretchtec</title>
</head>

<div class="flex h-full w-full">
    @extends('layouts.production-tabs')

    @section('content')
        <div class="flex-1 overflow-y-hidden">
            <div class="">
                <div class="w-full px-6 lg:px-2">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-4 text-gray-900 dark:text-gray-100">

                            {{-- Style for Sweet Alert --}}
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
                                        class="bg-white border border-blue-500 text-blue-500 hover:text-blue-600 hover:border-blue-600 font-semibold py-1 px-3 rounded shadow flex items-center gap-2 mb-6">
                                    <img src="{{ asset('icons/filter.png') }}" class="w-6 h-6" alt="Filter Icon">
                                    Filters
                                </button>
                                <button onclick="toggleReportForm()"
                                        class="bg-white border border-blue-500 text-blue-500 hover:text-blue-600 hover:border-blue-600 font-semibold py-1 px-3 rounded shadow flex items-center gap-2 mb-6 ml-2">
                                    Generate Report
                                </button>
                            </div>

                            <div id="filterFormContainer" class="hidden mt-4">
                                <!-- Filter Form -->
                                <form id="filterForm1" method="GET" action="{{ route('sample-inquery-details.index') }}"
                                      class="mb-6 sticky top-0 z-40 flex gap-6 items-center">
                                    <div class="flex items-center gap-4 flex-wrap">


                                    </div>
                                </form>
                            </div>

                            <div class="flex justify-between items-center mb-6">
                                <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Production Inquiry
                                    Records
                                </h1>
                                <button onclick="document.getElementById('addSampleModal').classList.remove('hidden')"
                                        class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded shadow">
                                    + Add New Production Order
                                </button>
                            </div>

                            <!-- Add Order Modal -->
                            <div id="addSampleModal"
                                 class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center py-5">
                                <div
                                    class="w-full max-w-[900px] bg-white dark:bg-gray-900 rounded-2xl shadow-2xl p-4 transform transition-all scale-95 max-h-[calc(100vh-10rem)] overflow-y-auto"
                                    onclick="event.stopPropagation()">
                                    <div class="max-w-[800px] mx-auto p-8">
                                        <h2
                                            class="text-2xl font-semibold mb-8 text-blue-900 mt-4 dark:text-gray-100 text-center">
                                            Add New Production Order
                                        </h2>

                                        <!-- Unified Form -->
                                        <form id="unifiedOrderForm"
                                              action="{{ route('production-inquery-details.store') }}"
                                              method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div id="itemsContainer"></div>

                                            <button type="button" id="addItemBtn"
                                                    class="mt-4 px-4 py-2 bg-green-500 text-white rounded text-sm">
                                                + Add Item
                                            </button>

                                            <!-- Master Order fields -->
                                            <div class="mt-6">
                                                <label
                                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">PO
                                                    Number</label>
                                                <input type="text" name="po_number" required
                                                       class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                            </div>
                                            <div class="mt-3">
                                                <label
                                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Customer
                                                    Name</label>
                                                <input type="text" name="customer_name" required
                                                       class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                            </div>
                                            <div class="mt-3">
                                                <label
                                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Merchandiser
                                                    Name</label>
                                                <input type="text" name="merchandiser_name" required
                                                       class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                            </div>
                                            <div class="mt-3">
                                                <label
                                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Customer
                                                    Coordinator</label>
                                                <input type="text" name="customer_coordinator" readonly
                                                       value="{{ Auth::user()->name }}"
                                                       class="w-full mt-1 px-3 py-2 border rounded-md bg-gray-100 dark:bg-gray-600 dark:text-white text-sm">
                                            </div>
                                            <div class="mt-3">
                                                <label
                                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Customer
                                                    Requested Date</label>
                                                <input type="date" name="customer_req_date"
                                                       class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                            </div>
                                            <div class="mt-3">
                                                <label
                                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Customer
                                                    Notes</label>
                                                <input type="text" name="remarks"
                                                       class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                            </div>

                                            <div class="flex justify-end mt-6 space-x-3">
                                                <button type="button" id="cancelForm"
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
                                 class="overflow-x-auto max-h-[1200px] bg-white dark:bg-gray-900 shadow rounded-lg">
                                <!-- Spinner -->
                                <div id="pageLoadingSpinner"
                                     class="fixed inset-0 z-50 bg-white bg-opacity-80 flex flex-col items-center justify-center">
                                    <svg class="animate-spin h-10 w-10 text-blue-600" xmlns="http://www.w3.org/2000/svg"
                                         fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                                stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                              d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                                    </svg>
                                    <p class="mt-3 text-gray-700 font-semibold">Loading data...</p>
                                </div>
                                <table class="table-fixed w-full text-sm divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead class="bg-gray-200 dark:bg-gray-700 text-left">
                                    <tr class="text-center">
                                        <th
                                            class="font-bold sticky left-0 top-0 z-20 bg-white px-4 py-3 w-36 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                            Order No
                                        </th>
                                        <th
                                            class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-48 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                            Reference Number
                                        </th>
                                        <th
                                            class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                            PO Number
                                        </th>
                                        <th
                                            class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                            Customer Coordinator
                                        </th>
                                        <th
                                            class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                            Quantity
                                        </th>
                                        <th
                                            class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-40 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                            Customer Name
                                        </th>
                                        <th
                                            class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-48 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                            PO Value
                                        </th>
                                        <th
                                            class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                            Requested Date
                                        </th>
                                        <th
                                            class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                            Notes
                                        </th>
                                        <th
                                            class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-48 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                            Send to Stores
                                        </th>
                                        <th
                                            class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-48 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                            Send to Production
                                        </th>
                                        <th
                                            class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                            Status
                                        </th>
                                        <th
                                            class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                            Customer Delivery Status
                                        </th>
                                        <th
                                            class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                            Action
                                        </th>
                                    </tr>
                                    </thead>

                                    <tbody id="productionDetailsRecords"
                                           class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @forelse($productInquiries as $inquiry)
                                        <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200  text-left">
                                            @if ($inquiry->supplier === null)
                                                <td
                                                    class="px-4 py-3 font-bold sticky left-0 z-10 bg-gray-100 whitespace-normal break-words border-r border-gray-300 text-blue-500">
                                                    {{ $inquiry->prod_order_no ?? 'N/A' }}
                                                    <div class="text-xs font-normal text-gray-500">
                                                        Date:
                                                        {{ $inquiry->po_received_date ? Carbon::parse($inquiry->po_received_date)->format('Y-m-d') : '' }}
                                                        <br>
                                                        Time:
                                                        {{ $inquiry->po_received_date ? Carbon::parse($inquiry->po_received_date)->format('H:i') : '' }}
                                                    </div>
                                                </td>
                                            @else
                                                <td
                                                    class="px-4 py-3 font-bold sticky left-0 z-10 bg-gray-100 whitespace-normal break-words border-r border-gray-300">
                                                    {{ $inquiry->prod_order_no ?? 'N/A' }}
                                                    <div class="text-xs font-normal text-gray-500">
                                                        Date:
                                                        {{ $inquiry->po_received_date ? Carbon::parse($inquiry->po_received_date)->format('Y-m-d') : '' }}
                                                        <br>
                                                        Time:
                                                        {{ $inquiry->po_received_date ? Carbon::parse($inquiry->po_received_date)->format('H:i') : '' }}
                                                    </div>
                                                </td>
                                            @endif

                                            <!-- Reference Number -->
                                            <td
                                                class="px-4 py-3 whitespace-normal break-words border-r border-gray-300  text-center">
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
                                                        data-itemDescription="{{ $inquiry->item_description ?? '' }}"
                                                        data-suppliercomment="{{ $inquiry->supplier_comment ?? '' }}">
                                                    {{ $inquiry->reference_no ?? 'N/A' }}
                                                </button>
                                            </td>

                                            <!-- PO Number -->
                                            <td
                                                class="px-4 py-3 whitespace-normal break-words border-r border-gray-300  text-center">
                                                {{ $inquiry->po_number ?? 'N/A' }}</td>

                                            <!-- Customer Coordinator -->
                                            <td
                                                class="px-4 py-3 whitespace-normal break-words border-r border-gray-300  text-center">
                                                {{ $inquiry->customer_coordinator ?? 'N/A' }}</td>

                                            <!-- Quantity -->
                                            <td
                                                class="px-4 py-3 whitespace-normal break-words border-r border-gray-300  text-center">
                                                {{ $inquiry->qty ?? '0' }} {{ $inquiry->uom ?? 'N/A' }}</td>

                                            <!-- Customer Name -->
                                            <td
                                                class="px-4 py-3 whitespace-normal break-words border-r border-gray-300  text-center">
                                                {{ $inquiry->customer_name ?? 'N/A' }}<br><span
                                                    class="text-xs text-gray-500">{{ $inquiry->merchandiser_name ?? 'N/A' }}</span>
                                            </td>

                                            <!-- PO Value -->
                                            <td
                                                class="px-4 py-3 whitespace-normal break-words border-r border-gray-300  text-center text-green-600 font-medium">
                                                {{ $inquiry->price ? '$  ' . number_format($inquiry->price, 2) : '0' }}
                                                <br>
                                                <span class="mt-2 text-xs text-blue-700 font-semibold">($
                                                        {{ $inquiry->unitPrice }} X {{ $inquiry->qty }})</span>
                                            </td>

                                            <!-- Requested Date -->
                                            <td
                                                class="px-4 py-3 whitespace-normal break-words border-r border-gray-300  text-center">
                                                {{ $inquiry->customer_req_date ?? 'N/A' }}</td>

                                            <!-- Notes -->
                                            <td
                                                class="px-4 py-3 whitespace-normal break-words border-r border-gray-300  text-center text-gray-500 italic">
                                                {{ $inquiry->remarks ?? '-' }}
                                            </td>

                                            <td
                                                class="py-3 whitespace-normal break-words border-r border-gray-300 text-center">
                                                <div class="colour-match-stock flex justify-center items-center">
                                                    @if (!$inquiry->isSentToStock && !$inquiry->canSendToProduction)
                                                        {{-- Show button if neither is true --}}
                                                        <form
                                                            action="{{ route('production.sendToStore', $inquiry->id) }}"
                                                            method="POST" onsubmit="handleSubmit(this)">
                                                            @csrf
                                                            <button type="submit"
                                                                    class="px-3 py-1 text-xs rounded-lg bg-blue-100 text-blue-700 hover:bg-blue-200 mt-4 flex items-center justify-center"
                                                                    id="sendToStoreBtn-{{ $inquiry->id }}">
                                                                Send to Stores
                                                            </button>
                                                        </form>
                                                    @elseif($inquiry->isSentToStock && $inquiry->canSendToProduction && !$inquiry->sent_to_stock_at)
                                                        {{-- No stock available (red) --}}
                                                        <span
                                                            class="inline-block m-1 text-sm font-semibold text-red-700 bg-red-100 dark:bg-gray-800 px-3 py-1 rounded">
                                                                No Stock Available
                                                            </span>
                                                    @elseif($inquiry->isSentToStock && !$inquiry->canSendToProduction)
                                                        {{-- Sent to stock only (blue) --}}
                                                        <span
                                                            class="inline-block m-1 text-sm font-semibold text-blue-700 bg-blue-100 dark:bg-gray-800 px-3 py-1 rounded">
                                                                Sent on <br>
                                                                {{ Carbon::parse($inquiry->sent_to_stock_at)->format('Y-m-d') }}
                                                                at
                                                                {{ Carbon::parse($inquiry->sent_to_stock_at)->format('H:i') }}
                                                            </span>
                                                    @elseif($inquiry->isSentToStock && $inquiry->canSendToProduction)
                                                        {{-- Both conditions true (green) --}}
                                                        <span
                                                            class="inline-block m-1 text-sm font-semibold text-green-700 bg-green-100 dark:bg-gray-800 px-3 py-1 rounded">
                                                                Ready for Production <br>
                                                                {{ Carbon::parse($inquiry->sent_to_stock_at)->format('Y-m-d') }}
                                                                at
                                                                {{ Carbon::parse($inquiry->sent_to_stock_at)->format('H:i') }}
                                                            </span>
                                                    @endif
                                                </div>
                                                @if ($inquiry->isSentToStock && $inquiry->canSendToProduction && $inquiry->sent_to_stock_at)
                                                    <ul class="mt-2 text-xs text-green-700 font-semibold">
                                                        @forelse($inquiry->stores as $store)
                                                            <li>{{ $store->reference_no }}
                                                                → {{ $store->qty_allocated ?? 0 }}
                                                                {{ $store->allocated_uom ?? 'NA' }}</li>
                                                        @empty
                                                            <li>No allocations yet</li>
                                                        @endforelse
                                                    </ul>
                                                @endif
                                            </td>

                                            <!-- Send to Production -->
                                            <td class="py-3 whitespace-normal break-words border-r border-gray-300 text-center">
                                                @if ($inquiry->canSendToProduction === 1)
                                                    <div class="colour-match-production">
                                                        @if ($inquiry->status === 'Ready For Delivery - Direct')
                                                            <!-- ✅ Always show this label when status is 'Ready For Delivery - Direct' -->
                                                            <span
                                                                class="inline-block m-1 text-sm font-semibold text-green-700 bg-green-100 dark:bg-gray-800 px-3 py-1 rounded">
                                                                No need of Production
                                                            </span>

                                                        @elseif ($inquiry->isSentToProduction)
                                                            <!-- ✅ Show timestamp only if sent to production AND status is not 'Ready For Delivery - Direct' -->
                                                            <span
                                                                class="inline-block m-1 text-sm font-semibold text-gray-700 dark:text-white bg-yellow-100 dark:bg-gray-800 px-3 py-1 rounded">
                                                                Sent on <br>
                                                                {{ Carbon::parse($inquiry->sent_to_production_at)->format('Y-m-d') }}
                                                                at
                                                                {{ Carbon::parse($inquiry->sent_to_production_at)->format('H:i') }}
                                                            </span>

                                                        @else
                                                            <!-- ✅ Pending or ready-to-send state -->
                                                            @if (Auth::user()->role === 'ADMIN')
                                                                <!-- Admin sees disabled button -->
                                                                <button type="button"
                                                                        class="px-3 py-1 text-xs rounded-lg bg-gray-200 text-gray-500 cursor-not-allowed"
                                                                        disabled>
                                                                    Pending
                                                                </button>
                                                            @else
                                                                <div class="flex justify-center items-center">
                                                                    <!-- Other users see the active Send button -->
                                                                    <form
                                                                        action="{{ route('production-inquiry.sendToProduction', $inquiry->id) }}"
                                                                        method="POST"
                                                                        onsubmit="handleSubmit(this)">
                                                                        @csrf
                                                                        @method('PATCH')
                                                                        <button type="submit"
                                                                                class="px-3 py-1 mt-4 text-xs rounded-lg bg-indigo-100 text-indigo-700 hover:bg-indigo-200 flex items-center justify-center"
                                                                                id="sendToProductionBtn-{{ $inquiry->id }}">
                                                                            Send to Production
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            @endif
                                                        @endif
                                                    </div>
                                                @else
                                                    <!-- ✅ Disabled button when cannot send to production -->
                                                    <button type="button"
                                                            class="px-3 py-1 text-xs rounded-lg bg-gray-200 text-gray-500 cursor-not-allowed"
                                                            disabled>
                                                        Send to Production
                                                    </button>
                                                @endif
                                            </td>

                                            <!-- Status -->
                                            <td
                                                class="px-4 py-3 whitespace-normal break-words border-r border-gray-300 text-center">
                                                    <span
                                                        class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full shadow-sm
                                                    {{ $inquiry->status === 'Completed'
                                                        ? 'bg-green-100 text-green-700 border border-green-300'
                                                        : ($inquiry->status === 'Pending'
                                                            ? 'bg-yellow-100 text-yellow-700 border border-yellow-300'
                                                            : 'bg-gray-100 text-gray-600 border border-gray-300') }}">
                                                        {{ $inquiry->status ?? 'Pending' }}
                                                    </span>
                                            </td>


                                            <!-- Customer Delivery Status -->
                                            <td
                                                class="px-4 py-3 whitespace-normal break-words border-r border-gray-300 text-center">
                                                @if ($inquiry->status === 'Ready For Delivery' || $inquiry->status === 'Ready For Delivery - Direct')
                                                    <div class="flex justify-center items-center">
                                                        <form
                                                            action="#"
                                                            method="POST"
                                                            onsubmit="handleSubmit(this)">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit"
                                                                    class="px-3 py-1 mt-4 text-xs rounded-lg bg-indigo-100 text-indigo-700 hover:bg-indigo-200 flex items-center justify-center">
                                                                Deliver to Customer
                                                            </button>
                                                        </form>
                                                    </div>
                                                @elseif ($inquiry->status === 'Delivered')
                                                    <span
                                                        class="inline-block m-1 text-sm font-semibold text-green-700 bg-green-100 px-3 py-1 rounded">
                                                                Delivered
                                                            </span>
                                                @else
                                                    <span class="text-gray-500 italic">No action available</span>
                                                @endif
                                            </td>

                                            <!-- Action -->
                                            <td
                                                class="px-4 py-3 whitespace-normal break-words border-r border-gray-300  text-center">
                                                <form id="delete-form-{{ $inquiry->id }}" method="POST"
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
                            </div>

                            <div class="py-6 flex justify-center">
                                {{ $productInquiries->links() }}
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
    document.addEventListener("DOMContentLoaded", function () {
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
            "Item Description": button.dataset.itemDescription,
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
    function handleSubmit(form) {
        let btn = form.querySelector("button[type='submit']");
        btn.disabled = true;

        // Replace text with loading spinner
        btn.innerHTML = `
            <svg class="animate-spin h-4 w-4 mr-2 text-blue-700" xmlns="http://www.w3.org/2000/svg" fill="none"
                 viewBox="0 0 24 24">
                 <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                 <path class="opacity-75" fill="currentColor"
                       d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
            </svg>
            Processing...
        `;

        // Allow form to continue submitting
        return true;
    }
</script>

<script>
    function handleSubmit(form) {
        let btn = form.querySelector("button[type='submit']");
        btn.disabled = true;

        // Replace button content with loading spinner
        btn.innerHTML = `
            <svg class="animate-spin h-4 w-4 mr-2 text-indigo-700" xmlns="http://www.w3.org/2000/svg" fill="none"
                 viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor"
                      d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
            </svg>
            Processing...
        `;

        return true; // allow form to submit
    }
</script>

<script>
    let itemIndex = 0;

    document.addEventListener('DOMContentLoaded', () => {
        const form = document.querySelector('#unifiedOrderForm');
        const submitBtn = form.querySelector("button[type='submit']");
        document.getElementById("addItemBtn").addEventListener("click", addItem);

        form.addEventListener('submit', function () {
            submitBtn.disabled = true;

            submitBtn.innerHTML = `
            <span class="flex items-center justify-center">
                <svg class="animate-spin h-4 w-4 mr-2 text-blue-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                </svg>
                <span>Processing...</span>
            </span>
        `;
        });
    });

    function addItem() {
        const container = document.getElementById("itemsContainer");

        const itemHTML = `
    <div class="item-group border rounded-md p-4 mb-4 bg-gray-50 dark:bg-gray-800" data-index="${itemIndex}">

        <!-- Order Type -->
        <div class="mt-3">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Order Type</label>
            <select name="items[${itemIndex}][order_type]" onchange="renderFields(this)"
                class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                <option value="">Select Order Type</option>
                <option value="sample">Sample</option>
                <option value="direct">Direct</option>
            </select>
        </div>

        <!-- Field container -->
        <div class="item-fields mt-3"></div>

        <!-- Remove button -->
        <div class="flex justify-end mt-4">
            <button type="button" onclick="removeItem(this)"
                class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 text-sm">
                Remove
            </button>
        </div>
    </div>
    `;

        container.insertAdjacentHTML("beforeend", itemHTML);
        itemIndex++;
    }

    function removeItem(button) {
        const container = document.getElementById("itemsContainer");
        const allItems = container.querySelectorAll('.item-group');
        if (allItems.length > 1) {
            button.closest(".item-group").remove();
        } else {
            alert("You must keep at least one item.");
        }
    }

    function renderFields(select) {
        const type = select.value;
        const index = select.closest(".item-group").dataset.index;
        const fieldsContainer = select.closest(".item-group").querySelector(".item-fields");

        if (!type) {
            fieldsContainer.innerHTML = "";
            return;
        }

        if (type === "sample") {
            fieldsContainer.innerHTML = getSampleFieldsHTML(index);
        } else if (type === "direct") {
            fieldsContainer.innerHTML = getDirectFieldsHTML(index);
        }
    }

    function getSampleFieldsHTML(index) {
        return `
    <div class="mt-3">
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Sample Reference</label>
        <div class="relative">
            <button type="button" class="sampleReferenceDropdown w-full inline-flex justify-between rounded-md bg-white px-3 py-2 text-sm font-semibold shadow-sm ring-1 ring-gray-300 hover:bg-gray-50 h-10"
                    onclick="toggleDropdown(this)" aria-haspopup="listbox">
                <span class="selectedSampleReference">Select Sample Reference</span>
                <svg class="ml-2 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.25 8.29a.75.75 0 01-.02-1.08z" clip-rule="evenodd"/>
                </svg>
            </button>
            <div class="dropdownMenu absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto hidden">
                <div class="sticky top-0 bg-white px-2 py-1">
                    <input type="text" placeholder="Search reference..." onkeyup="filterSamples(this)"
                           class="w-full px-2 py-1 text-sm border rounded-md focus:outline-none"/>
                </div>
                <ul class="sampleOptions max-h-48 overflow-y-auto">
                    @foreach ($samples as $sample)
        <li class="cursor-pointer select-none px-3 py-2 hover:bg-gray-100"
            onclick="selectSampleReference(this, '{{ $sample->id }}', '{{ $sample->reference_no }}', ${index})">
                            {{ $sample->reference_no }}
        </li>
@endforeach
        </ul>
    </div>
</div>
<input type="hidden" name="items[${index}][sample_id]" class="sampleReferenceHidden">
    </div>

    <div class="grid grid-cols-2 gap-4 mt-3">
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Shade</label>
            <input type="text" name="items[${index}][shade]" readonly class="sampleShade w-full mt-1 px-3 py-2 border rounded-md bg-gray-100 dark:bg-gray-600 dark:text-white text-sm">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Color</label>
            <input type="text" name="items[${index}][color]" readonly class="sampleColour w-full mt-1 px-3 py-2 border rounded-md bg-gray-100 dark:bg-gray-600 dark:text-white text-sm">
        </div>
    </div>

    <div class="grid grid-cols-2 gap-4 mt-3">
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">TKT</label>
            <input type="text" name="items[${index}][tkt]" readonly class="sampleTKT w-full mt-1 px-3 py-2 border rounded-md bg-gray-100 dark:bg-gray-600 dark:text-white text-sm">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Size</label>
            <input type="text" name="items[${index}][size]" readonly class="sampleSize w-full mt-1 px-3 py-2 border rounded-md bg-gray-100 dark:bg-gray-600 dark:text-white text-sm">
        </div>
    </div>

    <div class="grid grid-cols-2 gap-4 mt-3">
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Item</label>
            <input type="text" name="items[${index}][item]" readonly class="sampleItem w-full mt-1 px-3 py-2 border rounded-md bg-gray-100 dark:bg-gray-600 dark:text-white text-sm">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Supplier</label>
            <input type="text" name="items[${index}][supplier]" readonly class="sampleSupplier w-full mt-1 px-3 py-2 border rounded-md bg-gray-100 dark:bg-gray-600 dark:text-white text-sm">
        </div>
    </div>

    <div class="grid grid-cols-3 gap-4 mt-3">
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">PST No</label>
            <input type="text" name="items[${index}][pst_no]" readonly class="samplePSTNo w-full mt-1 px-3 py-2 border rounded-md bg-gray-100 dark:bg-gray-600 dark:text-white text-sm">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Supplier Comment</label>
            <input type="text" name="items[${index}][supplier_comment]" readonly class="sampleSupplierComment w-full mt-1 px-3 py-2 border rounded-md bg-gray-100 dark:bg-gray-600 dark:text-white text-sm">
        </div>
         <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Item Description</label>
            <input type="text" name="items[${index}][item_description]" readonly class="sampleItemDescription w-full mt-1 px-3 py-2 border rounded-md bg-gray-100 dark:bg-gray-600 dark:text-white text-sm">
        </div>
    </div>

    <div class="grid grid-cols-4 gap-4 mt-3">
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Qty</label>
            <input type="number" name="items[${index}][qty]" class="sampleQty w-full mt-1 px-3 py-2 border rounded-md text-sm" placeholder="Qty" oninput="updatePOValue(this)">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">UOM</label>
            <select name="items[${index}][uom]" class="sampleUom w-full mt-1 px-3 py-2 border rounded-md text-sm">
                <option value="meters">Meters</option>
                <option value="yards">Yards</option>
                <option value="pieces">Pieces</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Unit Price</label>
            <input type="number" step="0.01" name="items[${index}][unitPrice]" class="sampleUnitPrice w-full mt-1 px-3 py-2 border rounded-md text-sm" placeholder="Unit Price" oninput="updatePOValue(this)">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">PO Value</label>
            <input type="text" name="items[${index}][price]" readonly placeholder="PO Value" class="samplePOValue w-full mt-1 px-3 py-2 border rounded-md bg-gray-100 dark:bg-gray-600 dark:text-white text-sm">
        </div>
    </div>
    `;
    }

    function getDirectFieldsHTML(index) {
        return `
    <div class="grid grid-cols-2 gap-4 mt-3">
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Shade</label>
            <input type="text" name="items[${index}][shade]" placeholder="Shade"
                class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Color</label>
            <input type="text" name="items[${index}][color]" placeholder="Color"
                class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
        </div>
    </div>

    <div class="grid grid-cols-3 gap-4 mt-3">
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Size</label>
            <input type="text" name="items[${index}][size]" placeholder="Size"
                class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Quantity</label>
            <input type="number" name="items[${index}][qty]" placeholder="Quantity"
                class="w-full mt-1 px-3 py-2 border rounded-md text-sm" oninput="updatePOValue(this)">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">UOM</label>
            <select name="items[${index}][uom]"
                class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                <option value="meters">Meters</option>
                <option value="yards">Yards</option>
                <option value="pieces">Pieces</option>
            </select>
        </div>
    </div>

    <div class="mt-3">
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Item</label>
        <input type="text" name="items[${index}][item]" placeholder="Item"
            class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
    </div>

    <div class="grid grid-cols-2 gap-4 mt-3">
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Unit Price</label>
            <input type="number" step="0.01" name="items[${index}][unitPrice]" placeholder="Unit Price"
                class="w-full mt-1 px-3 py-2 border rounded-md text-sm" oninput="updatePOValue(this)">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">PO Value</label>
            <input type="text" name="items[${index}][price]" readonly placeholder="PO Value"
                class="w-full mt-1 px-3 py-2 border rounded-md bg-gray-100 dark:bg-gray-600 dark:text-white text-sm">
        </div>
    </div>
    `;
    }

    function toggleDropdown(button) {
        button.nextElementSibling.classList.toggle("hidden");
    }

    function filterSamples(input) {
        const filter = input.value.toLowerCase();
        const options = input.closest(".dropdownMenu").querySelectorAll("li");
        options.forEach(option => {
            option.style.display = option.textContent.toLowerCase().includes(filter) ? "" : "none";
        });
    }

    function selectSampleReference(element, sampleId, referenceNo, index) {
        const group = document.querySelector(`.item-group[data-index="${index}"]`);
        group.querySelector(".selectedSampleReference").innerText = referenceNo;
        group.querySelector(".sampleReferenceHidden").value = sampleId;
        group.querySelector(".dropdownMenu").classList.add("hidden");

        const base = "{{ url('product-catalog') }}";
        fetch(`${base}/${sampleId}/details`)
            .then(resp => resp.json())
            .then(data => {
                group.querySelector(".sampleShade").value = data.shade || '';
                group.querySelector(".sampleColour").value = data.colour || '';
                group.querySelector(".sampleTKT").value = data.tkt || '';
                group.querySelector(".sampleSize").value = data.size || '';
                group.querySelector(".sampleItem").value = data.item || '';
                group.querySelector(".samplePSTNo").value = data.pst_no || '';
                group.querySelector(".sampleSupplier").value = data.supplier || '';
                group.querySelector(".sampleSupplierComment").value = data.supplier_comments || '';
                group.querySelector(".sampleItemDescription").value = data.item_description || '';
            })
            .catch(err => console.error('Error fetching sample details:', err));
    }

    function updatePOValue(element) {
        const itemGroup = element.closest('.item-group');
        const qty = parseFloat(itemGroup.querySelector('input[name*="[qty]"]')?.value) || 0;
        const unitPrice = parseFloat(itemGroup.querySelector('input[name*="[unitPrice]"]')?.value) || 0;
        const poValueField = itemGroup.querySelector('input[name*="[price]"]');
        if (poValueField) {
            poValueField.value = (qty * unitPrice).toFixed(2);
        }
    }
</script>

<script>
    function toggleFilterForm() {
        const form = document.getElementById('filterFormContainer');
        form.classList.toggle('hidden');
    }

    function toggleReportForm() {
        const form = document.getElementById('reportFormContainer');
        form.classList.toggle('hidden');
    }
</script>

@endsection
