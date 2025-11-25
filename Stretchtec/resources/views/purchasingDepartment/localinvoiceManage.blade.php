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
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">
                    Local Procurement Records
                </h1>

                <div class="flex space-x-3">
                    <button
                        onclick="document.getElementById('addLocalProcModal').classList.remove('hidden')"
                        class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded shadow">
                        + Add Local Procurement
                    </button>
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
                    <input type="text" name="items[${index}][uom]" required
                        class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
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

        </div>
@endsection
