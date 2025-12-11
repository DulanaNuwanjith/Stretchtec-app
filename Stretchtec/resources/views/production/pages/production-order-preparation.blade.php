@php use Carbon\Carbon; @endphp
<head>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Include Flatpickr (CDN) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<div class="flex h-full w-full">
    @extends('layouts.production-tabs')

    @section('content')
        <div class="flex-1 overflow-y-hidden mb-20">
            <div class="w-full px-6 lg:px-2">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 text-gray-900 dark:text-gray-100 mb-20">

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
                            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">
                                Production Order Preparation Records
                            </h1>
                        </div>


                        {{-- Data Table --}}
                        <div id="orderPreparationScroll"
                             class="overflow-x-auto max-h-[1200px] bg-white dark:bg-gray-900 shadow rounded-lg">
                            <!-- Spinner -->
                            <div id="pageLoadingSpinner"
                                 class="fixed inset-0 z-50 bg-white bg-opacity-80 flex flex-col items-center justify-center">
                                <svg class="animate-spin h-10 w-10 text-blue-600" xmlns="http://www.w3.org/2000/svg"
                                     fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                            stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                          d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z">
                                    </path>
                                </svg>
                                <p class="mt-3 text-gray-700 font-semibold">Loading data...</p>
                            </div>
                            <table class="table-fixed w-full text-sm divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-200 dark:bg-gray-700 text-center">
                                <tr class="text-center">
                                    <th class="font-bold sticky left-0 top-0 z-20 bg-white px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                        Order No
                                    </th>
                                    <th class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase">
                                        Customer
                                    </th>
                                    <th class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase">
                                        Reference No
                                    </th>
                                    <th class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase">
                                        Requested Date
                                    </th>
                                    <th class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase">
                                        Item
                                    </th>
                                    <th class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-24 text-xs text-gray-600 dark:text-gray-300 uppercase">
                                        Size
                                    </th>
                                    <th class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-24 text-xs text-gray-600 dark:text-gray-300 uppercase">
                                        Color
                                    </th>
                                    <th class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-24 text-xs text-gray-600 dark:text-gray-300 uppercase">
                                        Shade
                                    </th>
                                    <th class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-24 text-xs text-gray-600 dark:text-gray-300 uppercase">
                                        TKT
                                    </th>
                                    <th class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-24 text-xs text-gray-600 dark:text-gray-300 uppercase">
                                        Quantity
                                    </th>
                                    <th class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase">
                                        Supplier
                                    </th>
                                    <th class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-28 text-xs text-gray-600 dark:text-gray-300 uppercase">
                                        PST No
                                    </th>
                                    <th class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-36 text-xs text-gray-600 dark:text-gray-300 uppercase">
                                        Supplier Comment
                                    </th>
                                    <th class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-28 text-xs text-gray-600 dark:text-gray-300 uppercase">
                                        Status
                                    </th>
                                    <th class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-40 text-xs text-gray-600 dark:text-gray-300 uppercase">
                                        Mark Raw Material Ordered
                                    </th>
                                    <th class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-40 text-xs text-gray-600 dark:text-gray-300 uppercase">
                                        Mark Raw Material Received
                                    </th>
                                    <th class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-36 text-xs text-gray-600 dark:text-gray-300 uppercase">
                                        Assign Order
                                    </th>
                                </tr>
                                </thead>

                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($orderPreparations as $order)
                                    <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200 text-center">
                                        <!-- Sticky first column -->
                                        <td class="px-4 py-3 font-bold sticky left-0 z-10 bg-gray-100 whitespace-normal break-words border-r border-gray-300 text-blue-500">
                                            {{ $order->prod_order_no ?? 'N/A' }}
                                        </td>
                                        <td class="px-4 py-3 border-r border-gray-300">{{ $order->customer_name ?? '-' }}</td>
                                        <td class="px-4 py-3 border-r border-gray-300">
                                            {{ $order->reference_no ?? '-' }}

                                            @if(!empty($order->item_description))
                                                <br>
                                                <span class="text-xs text-gray-500">
                                                    {{ $order->item_description }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 border-r border-gray-300">{{ $order->requested_date ?? '-' }}</td>
                                        <td class="px-4 py-3 border-r border-gray-300">{{ $order->item ?? '-' }}</td>
                                        <td class="px-4 py-3 border-r border-gray-300">{{ $order->size ?? '-' }}</td>
                                        <td class="px-4 py-3 border-r border-gray-300">{{ $order->color ?? '-' }}</td>
                                        <td class="px-4 py-3 border-r border-gray-300">{{ $order->shade ?? '-' }}</td>
                                        <td class="px-4 py-3 border-r border-gray-300">{{ $order->tkt ?? '-' }}</td>
                                        <td class="px-4 py-3 border-r border-gray-300 whitespace-nowrap min-w-[100px]">{{ $order->qty ?? 0 }} {{ $order->uom ?? '-' }}</td>
                                        <td class="px-4 py-3 border-r border-gray-300">{{ $order->supplier ?? '-' }}</td>
                                        <td class="px-4 py-3 border-r border-gray-300">{{ $order->pst_no ?? '-' }}</td>
                                        <td class="px-4 py-3 border-r border-gray-300">{{ $order->supplier_comment ?? '-' }}</td>
                                        <td class="px-4 py-3 border-r border-gray-300">
                                        <span class="px-2 py-1 text-xs rounded-full
                                            {{ $order->status === 'Completed'
                                                ? 'bg-green-100 text-green-700'
                                                : ($order->status === 'Pending'
                                                    ? 'bg-yellow-100 text-yellow-700'
                                                    : 'bg-gray-100 text-gray-600') }}">
                                            {{ $order->status ?? 'Pending' }}
                                        </span>
                                        </td>

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
                                                    <!-- Mark Ordered button -->
                                                    <form action="{{ route('orders.markOrdered', $order->id) }}"
                                                          method="POST" onsubmit="handleSubmit(this)">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit"
                                                                class="px-3 py-1 mt-4 text-xs rounded-lg bg-blue-100 text-blue-700 hover:bg-blue-200 flex items-center justify-center">
                                                            Mark as Ordered
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>

                                        <!-- Mark Raw Material Received -->
                                        <td class="py-3 whitespace-normal break-words border-r border-gray-300 text-center">
                                            <div class="flex flex-col items-center justify-center">
                                                @if ($order->isRawMaterialReceived)
                                                    <!-- Banner showing received timestamp -->
                                                    <span
                                                        class="inline-block m-1 text-sm font-semibold text-gray-700 dark:text-white bg-green-100 dark:bg-gray-800 px-3 py-1 rounded">
                                                        Received on <br>
                                                        {{ Carbon::parse($order->raw_material_received_date)->format('Y-m-d') }}
                                                        at
                                                        {{ Carbon::parse($order->raw_material_received_date)->format('H:i') }}
                                                    </span>
                                                @elseif ($order->isRawMaterialOrdered)
                                                    <!-- Mark Received button (only if ordered) -->
                                                    <form action="{{ route('orders.markReceived', $order->id) }}"
                                                          method="POST" onsubmit="handleSubmit(this)">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit"
                                                                class="px-3 py-1 mt-4 text-xs rounded-lg bg-green-100 text-green-700 hover:bg-green-200 flex items-center justify-center">
                                                            Mark as Received
                                                        </button>
                                                    </form>
                                                @else
                                                    <!-- Optional: Show disabled button or placeholder if not ordered -->
                                                    <span class="text-gray-400 text-sm">Not ordered yet</span>
                                                @endif
                                            </div>
                                        </td>

                                        <td class="px-4 py-3 border-r border-gray-300">
                                            @if($order->isRawMaterialOrdered && $order->isRawMaterialReceived)
                                                <button type="button"
                                                        onclick="openAssignModal({{ $order->id }}, '{{ $order->prod_order_no }}', {{ $order->isOrderAssigned ? 'true' : 'false' }})"
                                                        class="bg-purple-500 hover:bg-purple-600 text-white text-xs font-semibold py-2 px-3 rounded shadow transition">
                                                    Assign Order
                                                </button>
                                            @else
                                                <!-- Optional: Show a disabled button for visual feedback -->
                                                <button type="button"
                                                        disabled
                                                        class="bg-gray-300 text-gray-600 text-xs font-semibold py-2 px-3 rounded shadow cursor-not-allowed">
                                                    Assign Order
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="16" class="px-4 py-6 text-center text-gray-500 dark:text-gray-400">
                                            No records found.
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>


                        {{-- Pagination --}}
                        <div class="p-2 border-t border-gray-200 dark:border-gray-700">
                            {{ $orderPreparations->links() }}
                        </div>

                        <!-- Assign Modal -->
                        <div id="assignModal"
                             class="fixed inset-0 bg-black bg-opacity-40 hidden items-center justify-center z-50">
                            <div class="bg-white rounded-xl shadow-xl w-full max-w-7xl p-6 space-y-6">

                                <div class="flex justify-between items-center mb-4">
                                    <h2 class="text-xl font-semibold text-gray-800">
                                        Select Raw Materials for Order No: <span id="assignOrderNo"></span>
                                    </h2>

                                    <!-- Production Type Dropdown -->
                                    <div>
                                        <select id="productionType" class="border rounded px-3 py-2 w-48 mt-2">
                                            <option value="Knitted">Knitted</option>
                                            <option value="Loom">Loom</option>
                                            <option value="Braiding">Braiding</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Tabs Wrapper -->
                                <div x-data="{ tab: 'local' }">

                                    <!-- Tab Headers -->
                                    <div class="flex border-b mb-4">
                                        <button
                                            @click="tab = 'local'"
                                            :class="tab === 'local' ? 'border-b-2 border-purple-600 text-purple-600' : 'text-gray-500'"
                                            class="px-4 py-2 font-semibold">
                                            Local Raw Materials
                                        </button>

                                        <button
                                            @click="tab = 'export'"
                                            :class="tab === 'export' ? 'border-b-2 border-purple-600 text-purple-600' : 'text-gray-500'"
                                            class="px-4 py-2 font-semibold">
                                            Export Raw Materials
                                        </button>
                                    </div>

                                    <!-- LOCAL TAB -->
                                    <div x-show="tab === 'local'" class="space-y-2">
                                        <div class="max-h-60 overflow-y-auto border rounded-lg">
                                            <table class="w-full text-sm">
                                                <thead class="bg-gray-100">
                                                <tr>
                                                    <th class="px-3 py-2 border">Select</th>
                                                    <th class="px-3 py-2 border">Color</th>
                                                    <th class="px-3 py-2 border">Shade</th>
                                                    <th class="px-3 py-2 border">Qty</th>
                                                    <th class="px-3 py-2 border">Assign Qty</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($localRawMaterials as $mat)
                                                    <tr class="border h-12"> <!-- FIXED HEIGHT -->
                                                        <td class="px-3 py-2 border text-center">
                                                            <input type="checkbox"
                                                                   class="material-check"
                                                                   data-type="local"
                                                                   data-id="{{ $mat->id }}"
                                                                   data-name="{{ $mat->color }} - {{ $mat->shade }}"
                                                                   data-price="{{ $mat->unit_price }}"
                                                                   data-unit="{{ $mat->unit }}"
                                                                   data-max="{{ $mat->available_quantity }}"
                                                                   onchange="toggleQtyInput(this)">
                                                        </td>
                                                        <td class="px-3 py-2 border">{{ $mat->color }}</td>
                                                        <td class="px-3 py-2 border">{{ $mat->shade }}</td>
                                                        <td class="px-3 py-2 border">{{ $mat->available_quantity }} {{ $mat->unit }}</td>

                                                        <!-- FIXED HEIGHT + FIXED ALIGNMENT -->
                                                        <td class="px-3 py-2 border">
                                                            <div class="h-full flex items-center">
                                                                <input type="number"
                                                                       class="qty-input w-20 px-2 py-1 border rounded hidden"
                                                                       min="1"
                                                                       max="{{ $mat->available_quantity }}"
                                                                       data-max="{{ $mat->available_quantity }}"
                                                                       oninput="validateQty(this)">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <!-- EXPORT TAB -->
                                    <div x-show="tab === 'export'" class="space-y-2">
                                        <div class="max-h-60 overflow-y-auto border rounded-lg">
                                            <table class="w-full text-sm">
                                                <thead class="bg-gray-100">
                                                <tr>
                                                    <th class="px-3 py-2 border">Select</th>
                                                    <th class="px-3 py-2 border">Description</th>
                                                    <th class="px-3 py-2 border">Net Weight</th>
                                                    <th class="px-3 py-2 border">Assign Qty</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($exportRawMaterials as $mat)
                                                    <tr class="border h-12"> <!-- FIXED HEIGHT -->
                                                        <td class="px-3 py-2 border text-center">
                                                            <input type="checkbox"
                                                                   class="material-check"
                                                                   data-type="export"
                                                                   data-id="{{ $mat->id }}"
                                                                   data-name="{{ $mat->product_description }}"
                                                                   data-price="{{ $mat->unit_price }}"
                                                                   data-unit="{{ $mat->uom }}"
                                                                   data-max="{{ $mat->net_weight }}"
                                                                   onchange="toggleQtyInput(this)">
                                                        </td>
                                                        <td class="px-3 py-2 border">{{ $mat->product_description }}</td>
                                                        <td class="px-3 py-2 border">{{ $mat->net_weight }} {{ $mat->uom }}</td>

                                                        <!-- FIXED HEIGHT + FIXED ALIGNMENT -->
                                                        <td class="px-3 py-2 border">
                                                            <div class="h-full flex items-center">
                                                                <input type="number"
                                                                       class="qty-input w-20 px-2 py-1 border rounded hidden"
                                                                       min="1"
                                                                       max="{{ $mat->net_weight }}"
                                                                       data-max="{{ $mat->net_weight }}"
                                                                       oninput="validateQty(this)">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div> <!-- End Tabs -->

                                <!-- Buttons (Close / Add to Cart) -->
                                <div class="flex justify-end gap-3">
                                    <button onclick="closeAssignModal()"
                                            class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded">
                                        Cancel
                                    </button>

                                    <button
                                        onclick="addToCart()"
                                        class="px-4 py-2 text-white rounded shadow bg-purple-600 hover:bg-purple-700">
                                        Add to Cart
                                    </button>

                                </div>

                                <!-- Cart + Submit Buttons -->
                                <div class="flex justify-between items-center pt-4 border-t mt-4" data-order-id="">
                                    <!-- LEFT SIDE: Cart + Assigned buttons -->
                                    <div class="flex items-center gap-3">
                                        <button onclick="openCartModal()"
                                                class="relative bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg shadow font-semibold">
                                            Cart
                                            <span id="cart-count"
                                                  class="absolute -top-2 -right-2 bg-red-600 text-white text-xs w-5 h-5 flex items-center justify-center rounded-full shadow">
                                            </span>
                                        </button>

                                        <button onclick="openAssignedRawModal(selectedOrderId)"
                                                class="relative bg-pink-600 hover:bg-pink-700 text-white px-4 py-2 rounded-lg shadow font-semibold">
                                            Assigned
                                        </button>
                                    </div>

                                    <!-- RIGHT SIDE: Submit button -->
                                    <button onclick="submitCart()"
                                            id="submitCartBtn"
                                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow font-semibold">
                                        Submit
                                    </button>
                                </div>

                            </div>
                        </div>

                        <!-- Cart Modal -->
                        <div id="cartModal"
                             class="fixed inset-0 bg-black bg-opacity-40 hidden items-center justify-center z-50">
                            <div class="bg-white rounded-xl shadow-xl w-full max-w-3xl p-6 space-y-6">
                                <h2 class="text-xl font-semibold text-gray-800">
                                    Cart Items for Order No: <span id="cartOrderNo"></span>
                                </h2>
                                <div id="cart-items-container" class="max-h-80 overflow-y-auto space-y-4"></div>
                                <div class="flex justify-end gap-3">
                                    <button onclick="closeCartModal()"
                                            class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded">
                                        Close
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Assigned Raw Materials Modal -->
                        <div id="assignedRawModal"
                             class="fixed inset-0 bg-black bg-opacity-40 hidden items-center justify-center z-50">
                            <div class="bg-white rounded-xl shadow-xl w-full max-w-3xl p-6 space-y-6">
                                <h2 class="text-xl font-semibold text-gray-800">
                                    Assigned Raw Materials for Order No: <span id="assignedOrderNo"></span>
                                </h2>
                                <div id="assigned-items-container" class="max-h-80 overflow-y-auto space-y-4"></div>
                                <div class="flex justify-end gap-3">
                                    <button onclick="closeAssignedRawModal()"
                                            class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded">
                                        Close
                                    </button>
                                </div>
                            </div>
                        </div>

                        <form id="cartSubmitForm" action="{{ route('orders.assignRawMaterials') }}" method="POST">
                            @csrf
                            <input type="hidden" name="cart_items" id="cartDataInput">
                        </form>

                    </div>
                </div>
            </div>
        </div>

        <script>
            // Global variable to store the currently selected order
            let selectedOrderId = null;
            let selectedOrderNo = null;

            // ------------- CART LOGIC -------------
            function updateCartCount() {
                const cart = JSON.parse(localStorage.getItem('raw_material_cart')) || [];
                document.getElementById('cart-count').textContent = cart.length;
            }

            function openCartModal() {
                const cart = JSON.parse(localStorage.getItem('raw_material_cart')) || [];
                const container = document.getElementById('cart-items-container');
                container.innerHTML = "";

                // Set the order number in the heading
                document.getElementById('cartOrderNo').textContent = selectedOrderNo || 'N/A';

                if (cart.length === 0) {
                    container.innerHTML = `<p class="text-gray-500">No items in the cart.</p>`;
                } else {
                    cart.forEach((item, index) => {
                        container.innerHTML += `
            <div class="border p-3 rounded-lg flex justify-between items-center bg-gray-50">
                <div>
                    <p class="font-semibold">${item.name}</p>
                    <p class="text-xs text-gray-600">Type: ${item.type}</p>
                    <p class="text-xs text-gray-600">Order ID: ${item.order_id}</p>
                    <p class="text-xs text-gray-600">Qty Selected:
                        <span class="font-semibold">${item.used_qty} ${item.unit}</span>
                    </p>
                </div>
                <button onclick="removeFromCart(${index})"
                        class="text-red-600 font-bold hover:underline text-sm">
                    Remove
                </button>
            </div>`;
                    });
                }

                document.getElementById('cartModal').classList.remove('hidden');
                document.getElementById('cartModal').classList.add('flex');
            }

            function closeCartModal() {
                document.getElementById('cartModal').classList.add('hidden');
                document.getElementById('cartModal').classList.remove('flex');
            }

            function removeFromCart(index) {
                let cart = JSON.parse(localStorage.getItem('raw_material_cart')) || [];
                cart.splice(index, 1);
                localStorage.setItem('raw_material_cart', JSON.stringify(cart));
                openCartModal();
                updateCartCount();
            }

            function submitCart() {
                const cart = JSON.parse(localStorage.getItem('raw_material_cart')) || [];
                if (cart.length === 0) {
                    alert("Cart is empty!");
                    return;
                }

                document.getElementById('cartDataInput').value = JSON.stringify(cart);
                document.getElementById('cartSubmitForm').submit();

                // Clear cart after submission
                localStorage.removeItem('raw_material_cart');
            }

            updateCartCount();
        </script>

        <script>
            // ------------- ASSIGN MODAL LOGIC -------------
            let currentOrderAssigned = false; // Track whether the current order is assigned

            function openAssignModal(orderId, orderNo, isAssigned) {
                selectedOrderId = orderId;
                selectedOrderNo = orderNo;
                currentOrderAssigned = isAssigned;

                // Set the order number in the modal heading
                document.getElementById('assignOrderNo').textContent = selectedOrderNo || 'N/A';

                // Show modal
                const modal = document.getElementById('assignModal');
                modal.classList.remove('hidden');
                modal.classList.add('flex');

                // Update Add to Cart button state
                const addToCartBtn = modal.querySelector('button[onclick="addToCart()"]');
                const submitButton = modal.querySelector('button[onclick="submitCart()"]')

                if (currentOrderAssigned) {
                    addToCartBtn.disabled = true;
                    submitButton.disabled = true;
                    addToCartBtn.classList.add('bg-purple-400', 'cursor-not-allowed');
                    addToCartBtn.classList.remove('bg-purple-600', 'hover:bg-purple-700');
                    submitButton.classList.add('bg-green-400', 'cursor-not-allowed');
                    submitButton.classList.remove('bg-green-600', 'hover:bg-green-700');
                } else {
                    addToCartBtn.disabled = false;
                    submitButton.disabled = false;
                    addToCartBtn.classList.remove('bg-purple-400', 'cursor-not-allowed');
                    addToCartBtn.classList.add('bg-purple-600', 'hover:bg-purple-700');
                    submitButton.classList.remove('bg-green-400', 'cursor-not-allowed');
                    submitButton.classList.add('bg-green-600', 'hover:bg-green-700');
                }
            }

            function closeAssignModal() {
                selectedOrderId = null;
                selectedOrderNo = null;
                currentOrderAssigned = false;

                const modal = document.getElementById('assignModal');
                modal.classList.add('hidden');
                modal.classList.remove('flex');

                // Reset Add to Cart button
                const addToCartBtn = modal.querySelector('button[onclick="addToCart()"]');
                addToCartBtn.disabled = false;
                addToCartBtn.classList.remove('bg-purple-400', 'cursor-not-allowed');
                addToCartBtn.classList.add('bg-purple-600', 'hover:bg-purple-700');

                // Clear all selected checkboxes and qty inputs
                modal.querySelectorAll(".material-check").forEach(chk => {
                    chk.checked = false;
                    const row = chk.closest("tr");
                    const qtyInput = row.querySelector(".qty-input");
                    qtyInput.value = "";
                    qtyInput.classList.add("hidden");
                });
            }

        </script>

        <script>
            // ------------- RAW MATERIAL SELECTION -------------
            function toggleQtyInput(checkbox) {
                const row = checkbox.closest("tr");
                const qtyInput = row.querySelector(".qty-input");

                if (checkbox.checked) {
                    qtyInput.classList.remove("hidden");
                    qtyInput.value = "";
                } else {
                    qtyInput.classList.add("hidden");
                    qtyInput.value = "";
                }
            }

            function validateQty(input) {
                const max = parseFloat(input.dataset.max);
                let val = parseFloat(input.value);

                if (val > max) input.value = max;
                if (val < 1) input.value = "";
            }

            function addToCart() {
                const selected = document.querySelectorAll(".material-check:checked");
                let cart = JSON.parse(localStorage.getItem("raw_material_cart")) || [];

                if (!selectedOrderId) {
                    alert("No order selected!");
                    return;
                }

                if (selected.length === 0) {
                    alert("Please select at least one item.");
                    return;
                }

                let hasError = false;

                selected.forEach(chk => {
                    const row = chk.closest("tr");
                    const qtyInput = row.querySelector(".qty-input");

                    if (!qtyInput.value || qtyInput.value <= 0) {
                        hasError = true;
                        return;
                    }

                    cart.push({
                        type: chk.dataset.type,
                        material_id: chk.dataset.id,
                        name: chk.dataset.name,
                        price: chk.dataset.price,
                        unit: chk.dataset.unit,
                        used_qty: qtyInput.value,
                        max_qty: chk.dataset.max,
                        order_id: selectedOrderId,

                        productionType: document.getElementById('productionType').value
                    });
                });

                if (hasError) {
                    alert("Please enter quantity for all selected items.");
                    return;
                }

                localStorage.setItem("raw_material_cart", JSON.stringify(cart));
                updateCartCount();
                alert("Items added to cart successfully!");

                // Clear selections
                selected.forEach(chk => {
                    chk.checked = false;
                    const row = chk.closest("tr");
                    row.querySelector(".qty-input").value = "";
                    row.querySelector(".qty-input").classList.add("hidden");
                });
            }
        </script>

        <script>
            // ------------- ASSIGNED RAW MATERIALS MODAL -------------
            const assignedLocal = @json($assignedLocalRawMaterials);
            const assignedExport = @json($assignedExportRawMaterials);

            function openAssignedRawModal(orderId) {
                const container = document.getElementById('assigned-items-container');
                container.innerHTML = "";

                // Set the order number in the heading
                document.getElementById('assignedOrderNo').textContent = selectedOrderNo || 'N/A';

                const localFiltered = assignedLocal.filter(item => item.order_preperation_id == orderId);
                const exportFiltered = assignedExport.filter(item => item.order_preperation_id == orderId);

                if (localFiltered.length === 0 && exportFiltered.length === 0) {
                    container.innerHTML = `<p class="text-gray-500">No assigned raw materials for this order.</p>`;
                } else {
                    localFiltered.forEach(item => {
                        const rm = item.raw_material;
                        container.innerHTML += `
            <div class="border p-3 rounded-lg bg-gray-50">
                <p class="font-semibold">Local Raw Material: ${rm.color} / ${rm.shade} / ${rm.tkt}</p>
                <p class="text-xs text-gray-600">PST No: ${rm.pst_no}</p>
                <p class="text-xs text-gray-600">Supplier: ${rm.supplier}</p>
                <p class="text-xs text-gray-600">Assigned Qty: <span class="font-semibold">${item.assigned_quantity}</span></p>
            </div>`;
                    });

                    exportFiltered.forEach(item => {
                        const rm = item.export_raw_material;
                        container.innerHTML += `
            <div class="border p-3 rounded-lg bg-gray-50">
                <p class="font-semibold">Export Raw Material</p>
                <p class="text-xs text-gray-600">Suuplier: ${rm.supplier}</p>
                <p class="text-xs text-gray-600">Description: ${rm.product_description}</p>
                <p class="text-xs text-gray-600">Assigned Qty: <span class="font-semibold">${item.assigned_quantity}</span></p>
            </div>`;
                    });
                }

                document.getElementById('assignedRawModal').classList.remove('hidden');
                document.getElementById('assignedRawModal').classList.add('flex');
            }

            function closeAssignedRawModal() {
                document.getElementById('assignedRawModal').classList.add('hidden');
                document.getElementById('assignedRawModal').classList.remove('flex');
            }
        </script>

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
            function toggleFilterForm() {
                const form = document.getElementById('filterFormContainer');
                form.classList.toggle('hidden');
            }

            function toggleReportForm() {
                const form = document.getElementById('reportFormContainer');
                form.classList.toggle('hidden');
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

@endsection
