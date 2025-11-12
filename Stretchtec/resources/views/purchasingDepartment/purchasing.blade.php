@php use Carbon\Carbon; @endphp

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<div class="flex h-full w-full">
    @extends('layouts.purchasing-tabs')

    @section('content')
        <div class="flex-1 overflow-y-auto p-8 bg-white">
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

                    <!-- Table Container -->
                    <div id="orderTableContainer"
                         class="overflow-x-auto border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm">
                        <table class="min-w-full border-collapse">
                            <thead class="bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300">
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
                                <th class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-28 text-xs text-gray-600 dark:text-gray-300 uppercase">
                                    UOM
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
                                <th class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-40 text-xs text-gray-600 dark:text-gray-300 uppercase">
                                    Mark Raw Material Ordered
                                </th>
                                <th class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-40 text-xs text-gray-600 dark:text-gray-300 uppercase">
                                    Mark Raw Material Received
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
                                    <td class="px-4 py-3 border-r border-gray-300">{{ $order->reference_no ?? '-' }}</td>
                                    <td class="px-4 py-3 border-r border-gray-300">{{ $order->item ?? '-' }}</td>
                                    <td class="px-4 py-3 border-r border-gray-300">{{ $order->size ?? '-' }}</td>
                                    <td class="px-4 py-3 border-r border-gray-300">{{ $order->color ?? '-' }}</td>
                                    <td class="px-4 py-3 border-r border-gray-300">{{ $order->shade ?? '-' }}</td>
                                    <td class="px-4 py-3 border-r border-gray-300">{{ $order->tkt ?? '-' }}</td>
                                    <td class="px-4 py-3 border-r border-gray-300">{{ $order->qty ?? 0 }}</td>
                                    <td class="px-4 py-3 border-r border-gray-300">{{ $order->uom ?? '-' }}</td>
                                    <td class="px-4 py-3 border-r border-gray-300">{{ $order->supplier ?? '-' }}</td>
                                    <td class="px-4 py-3 border-r border-gray-300">{{ $order->pst_no ?? '-' }}</td>
                                    <td class="px-4 py-3 border-r border-gray-300">{{ $order->supplier_comment ?? '-' }}</td>

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
                                            @else
                                                <!-- Mark Received button -->
                                                <form action="{{ route('orders.markReceived', $order->id) }}"
                                                      method="POST" onsubmit="handleSubmit(this)">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit"
                                                            class="px-3 py-1 mt-4 text-xs rounded-lg bg-green-100 text-green-700 hover:bg-green-200 flex items-center justify-center">
                                                        Mark as Received
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-3 text-center text-gray-500 dark:text-gray-400">
                                        No orders available.
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Add Purchase Modal -->
            <div id="addPurchaseModal"
                 class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center py-5">
                <div
                    class="w-full max-w-[700px] bg-white dark:bg-gray-900 rounded-2xl shadow-2xl p-4 transform transition-all scale-95 max-h-[calc(100vh-10rem)] overflow-y-auto"
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

                            <div class="mt-3">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Status
                                </label>
                                <select name="status" required
                                        class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                    <option value="pending">Pending</option>
                                    <option value="approved">Approved</option>
                                    <option value="rejected">Rejected</option>
                                </select>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex justify-end mt-6 space-x-3">
                                <button type="button"
                                        onclick="document.getElementById('addPurchaseModal').classList.add('hidden')"
                                        class="px-4 py-2 bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-200 text-sm rounded hover:bg-gray-300">
                                    Cancel
                                </button>
                                <button type="submit"
                                        class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white text-sm rounded">
                                    Create Purchase Order
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Stock / Stores Records Table -->
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
                    <thead class="bg-gray-200 dark:bg-gray-700 text-left">
                    <tr class="text-center">
                        <th class="font-bold sticky left-0 z-10 bg-white px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase">
                            PO Number
                        </th>
                        <th class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase">
                            PO Date
                        </th>
                        <th class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-28 text-xs text-gray-600 dark:text-gray-300 uppercase">
                            Supplier
                        </th>
                        <th class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-28 text-xs text-gray-600 dark:text-gray-300 uppercase">
                            Shade
                        </th>
                        <th class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-28 text-xs text-gray-600 dark:text-gray-300 uppercase">
                            Color
                        </th>
                        <th class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-24 text-xs text-gray-600 dark:text-gray-300 uppercase">
                            TKT
                        </th>
                        <th class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-28 text-xs text-gray-600 dark:text-gray-300 uppercase">
                            PST No
                        </th>
                        <th class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-40 text-xs text-gray-600 dark:text-gray-300 uppercase">
                            Supplier Comment
                        </th>
                        <th class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-20 text-xs text-gray-600 dark:text-gray-300 uppercase">
                            UOM
                        </th>
                        <th class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-28 text-xs text-gray-600 dark:text-gray-300 uppercase">
                            Quantity
                        </th>
                        <th class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-28 text-xs text-gray-600 dark:text-gray-300 uppercase">
                            Rate
                        </th>
                        <th class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase">
                            Amount
                        </th>
                        <th class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase">
                            Total Amount
                        </th>
                        <th class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-28 text-xs text-gray-600 dark:text-gray-300 uppercase">
                            Status
                        </th>
                    </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700 text-center">
                    @foreach ($purchaseDepartments as $purchase)
                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                            <td class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ $purchase->po_number }}</td>
                            <td class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ $purchase->po_date }}</td>
                            <td class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ $purchase->supplier }}</td>
                            <td class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ $purchase->shade }}</td>
                            <td class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ $purchase->color }}</td>
                            <td class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ $purchase->tkt }}</td>
                            <td class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ $purchase->pst_no }}</td>
                            <td class="px-4 py-3 text-gray-700 dark:text-gray-300 whitespace-normal break-words">{{ $purchase->supplier_comment }}</td>
                            <td class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ $purchase->uom }}</td>
                            <td class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ $purchase->quantity }}</td>
                            <td class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ $purchase->rate }}</td>
                            <td class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ $purchase->amount }}</td>
                            <td class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ $purchase->total_amount }}</td>
                            <td class="px-4 py-3 text-gray-700 dark:text-gray-300">
                    <span class="px-2 py-1 rounded-full text-xs font-semibold
                        @if($purchase->status === 'Pending') bg-yellow-100 text-yellow-800
                        @elseif($purchase->status === 'Approved') bg-green-100 text-green-800
                        @elseif($purchase->status === 'Rejected') bg-red-100 text-red-800
                        @else bg-gray-100 text-gray-800 @endif">
                        {{ $purchase->status }}
                    </span>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="p-2 border-t border-gray-200 dark:border-gray-700">
                {{ $purchaseDepartments->links() }}
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
                    <input type="text" name="items[${index}][uom]" required
                        class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
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
                document.getElementById('orderPopupModal').classList.remove('hidden');
            }

            function closeOrderPopup() {
                document.getElementById('orderPopupModal').classList.add('hidden');
            }

            // Optional: Close modal when clicking outside content
            window.addEventListener('click', function (e) {
                const modal = document.getElementById('orderPopupModal');
                if (e.target === modal) closeOrderPopup();
            });
        </script>


@endsection
