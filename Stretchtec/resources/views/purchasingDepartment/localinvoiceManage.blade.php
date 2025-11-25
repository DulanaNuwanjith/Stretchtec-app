@php use Carbon\Carbon; @endphp
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- ===================== SWEETALERT SUCCESS ===================== -->
@if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: "{{ session('success') }}",
            confirmButtonColor: '#2563eb'
        });
    </script>
@endif

<!-- ===================== SWEETALERT VALIDATION ERRORS ===================== -->
@if($errors->any())
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Validation Error',
            html: `{!! implode('<br>', $errors->all()) !!}`,
            confirmButtonColor: '#dc2626'
        });
    </script>
@endif

<div class="flex h-full w-full">
    @extends('layouts.purchasing-tabs')

    @section('content')
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
                {{ session('error') }}
            </div>
        @endif

        <div class="p-6">

            <!-- Header -->
            <div class="flex items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">
                    Local Procurement Records
                </h1>

                <div class="ml-auto flex space-x-3">
                    <button
                        onclick="document.getElementById('addLocalProcModal').classList.remove('hidden')"
                        class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded shadow">
                        + Add Local Procurement
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

            <!-- ================= TABLE ================== -->
            <div class="overflow-x-auto max-h-[1200px] bg-white dark:bg-gray-900 shadow rounded-lg">
                <table class="table-fixed w-full text-sm divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-200 dark:bg-gray-700 text-left">
                    <tr class="text-center">
                        <th class="font-bold sticky left-0 z-10 bg-white px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase">
                            PO Number
                        </th>
                        <th class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase">
                            Date
                        </th>
                        <th class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-28 text-xs text-gray-600 dark:text-gray-300 uppercase">
                            Invoice No
                        </th>
                        <th class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-28 text-xs text-gray-600 dark:text-gray-300 uppercase">
                            Supplier
                        </th>
                        <th class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-28 text-xs text-gray-600 dark:text-gray-300 uppercase">
                            Color
                        </th>
                        <th class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-28 text-xs text-gray-600 dark:text-gray-300 uppercase">
                            Shade
                        </th>
                        <th class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-24 text-xs text-gray-600 dark:text-gray-300 uppercase">
                            TKT
                        </th>
                        <th class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-20 text-xs text-gray-600 dark:text-gray-300 uppercase">
                            UOM
                        </th>
                        <th class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-28 text-xs text-gray-600 dark:text-gray-300 uppercase">
                            Quantity
                        </th>
                        <th class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-28 text-xs text-gray-600 dark:text-gray-300 uppercase">
                            PST No
                        </th>
                        <th class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-40 text-xs text-gray-600 dark:text-gray-300 uppercase">
                            Supplier Comment
                        </th>
                        <th class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-28 text-xs text-gray-600 dark:text-gray-300 uppercase">
                            Status
                        </th>
                    </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700 text-center">
                    @forelse($localProcurements as $proc)
                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                            <td class="px-4 py-3">{{ $proc->po_number }}</td>
                            <td class="px-4 py-3">{{ $proc->date }}</td>
                            <td class="px-4 py-3">{{ $proc->invoice_number }}</td>
                            <td class="px-4 py-3">{{ $proc->supplier_name }}</td>
                            <td class="px-4 py-3">{{ $proc->color }}</td>
                            <td class="px-4 py-3">{{ $proc->shade }}</td>
                            <td class="px-4 py-3">{{ $proc->tkt }}</td>
                            <td class="px-4 py-3">{{ $proc->uom }}</td>
                            <td class="px-4 py-3">{{ $proc->quantity }}</td>
                            <td class="px-4 py-3">{{ $proc->pst_no }}</td>
                            <td class="px-4 py-3 whitespace-normal break-words">{{ $proc->supplier_comment }}</td>
                            <td class="px-4 py-3">
                        <span class="px-2 py-1 rounded-full text-xs font-semibold
                            @if($proc->status === 'pending') bg-yellow-100 text-yellow-800
                            @elseif($proc->status === 'approved') bg-green-100 text-green-800
                            @elseif($proc->status === 'rejected') bg-red-100 text-red-800
                            @else bg-gray-100 text-gray-800 @endif">
                            {{ ucfirst($proc->status) }}
                        </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="12" class="px-4 py-4 text-gray-500 dark:text-gray-400 text-center">
                                No records found.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="p-2 border-t border-gray-200 dark:border-gray-700">
                {{ $localProcurements->links() }}
            </div>


            <!-- ================= ADD LOCAL PROCUREMENT MODAL ================== -->
            <div id="addLocalProcModal"
                 class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center py-5">
                <div
                    class="w-full max-w-[700px] bg-white dark:bg-gray-900 rounded-2xl shadow-2xl p-4 transform transition-all scale-95 max-h-[calc(100vh-10rem)] overflow-y-auto"
                    onclick="event.stopPropagation()">
                    <div class="max-w-[600px] mx-auto p-8">
                        <h2 class="text-2xl font-semibold mb-8 text-blue-900 dark:text-gray-100 text-center">
                            Add Local Procurement
                        </h2>

                        <!-- Local Procurement Form -->
                        <form id="localProcForm" action="{{ route('localinvoiceManage.store') }}" method="POST">
                            @csrf

                            <!-- Master Invoice Fields -->
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-sm font-medium">Invoice Number</label>
                                    <input type="text" name="invoice_number" required
                                           class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium">Date</label>
                                    <input type="date" name="date" required
                                           class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                </div>
                            </div>

                            <div class="mt-3">
                                <label class="block text-sm font-medium">PO Number</label>
                                <select name="po_number" required
                                        class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                    <option value="" disabled selected>Select PO Number</option>
                                    @foreach($poNumbers as $po)
                                        <option value="{{ $po }}">{{ $po }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mt-3">
                                <label class="block text-sm font-medium">Supplier Name</label>
                                <input type="text" name="supplier_name" required
                                       class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                            </div>

                            <!-- Dynamic Item Container -->
                            <div id="localProcItemsContainer" class="mt-6"></div>

                            <!-- Add Item Button -->
                            <button type="button" id="addLocalProcItemBtn"
                                    class="mt-4 px-4 py-2 bg-green-500 hover:bg-green-600 text-white text-sm rounded">
                                + Add Item
                            </button>

                            <!-- Action Buttons -->
                            <div class="flex justify-end mt-6 space-x-3">
                                <button type="button"
                                        onclick="document.getElementById('addLocalProcModal').classList.add('hidden')"
                                        class="px-4 py-2 bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-200 text-sm rounded hover:bg-gray-300">
                                    Cancel
                                </button>
                                <button type="submit"
                                        class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white text-sm rounded">
                                    Save Record
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <script>
                let localProcItemIndex = 0;
                const addLocalProcItemBtn = document.getElementById('addLocalProcItemBtn');
                const localProcContainer = document.getElementById('localProcItemsContainer');

                // Add new item dynamically
                addLocalProcItemBtn.addEventListener('click', () => {
                    const itemHTML = getLocalProcItemFields(localProcItemIndex++);
                    localProcContainer.insertAdjacentHTML('beforeend', itemHTML);
                    attachLocalProcListeners();
                });

                // Remove an item
                function removeLocalProcItem(btn) {
                    btn.closest('.local-proc-item-block').remove();
                }

                // Template for Local Procurement item fields
                function getLocalProcItemFields(index) {
                    return `
        <div class="local-proc-item-block border rounded-lg p-4 mt-4 bg-gray-50 dark:bg-gray-800 relative">
            <button type="button" onclick="removeLocalProcItem(this)"
                    class="absolute top-2 right-2 text-red-500 hover:text-red-700 text-sm">✖</button>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm font-medium">Shade</label>
                    <input type="text" name="items[${index}][shade]" required
                        class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium">Color</label>
                    <input type="text" name="items[${index}][color]" required
                        class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3 mt-3">
                <div>
                    <label class="block text-sm font-medium">TKT</label>
                    <input type="text" name="items[${index}][tkt]" required
                        class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                </div>
               <div>
                    <label class="block text-sm font-medium">UOM</label>
                    <select name="items[${index}][uom]" required
                        class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                        <option value="" disabled selected>Select Unit</option>
                        <option value="g">Gram (g)</option>
                        <option value="kg">Kilogram (kg)</option>
                        <option value="m">Meter (m)</option>
                        <option value="yard">Yard</option>
                        <option value="corn">Corn</option>
                        <option value="piece">Piece</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3 mt-3">
                <div>
                    <label class="block text-sm font-medium">Quantity</label>
                    <input type="number" name="items[${index}][quantity]" required min="1"
                        class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium">PST No</label>
                    <input type="text" name="items[${index}][pst_no]"
                        class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                </div>
            </div>

            <div class="mt-3">
                <label class="block text-sm font-medium">Supplier Comment</label>
                <textarea name="items[${index}][supplier_comment]" rows="2"
                    class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm"></textarea>
            </div>
        </div>`;
                }

                function attachLocalProcListeners() {
                    // Currently no auto-calculation, but can add if needed
                }

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

        </div>
@endsection
