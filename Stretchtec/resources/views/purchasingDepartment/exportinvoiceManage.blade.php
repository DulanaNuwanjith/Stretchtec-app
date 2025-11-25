@php use Carbon\Carbon; @endphp

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<div class="flex h-full w-full">
    @extends('layouts.purchasing-tabs')

    @section('content')

        {{-- SUCCESS & ERROR MESSAGES --}}
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

        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="mb-4 p-3 bg-yellow-100 text-yellow-800 rounded">
                <strong>Validation Errors:</strong><br>
                {!! implode('<br>', $errors->all()) !!}
            </div>
        @endif

        <div class="p-6">

            {{-- ===================== PAGE HEADER ===================== --}}
            <div class="flex items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">
                    Export Procurement Records
                </h1>

                <div class="ml-auto flex space-x-3">
                    <button onclick="document.getElementById('addExportProcModal').classList.remove('hidden')"
                            class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded shadow">
                        + Add Export Procurement
                    </button>
                </div>
            </div>

            {{-- ===================== TABLE CONTAINER ===================== --}}
            <div class="overflow-x-auto border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm">
                <table class="min-w-full border-collapse">
                    <thead class="bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300">
                    <tr class="text-center">

                        <th class="sticky top-0 px-4 py-3 w-32 text-xs font-bold uppercase">
                            Date
                        </th>

                        <th class="sticky top-0 px-4 py-3 w-32 text-xs font-bold uppercase">
                            Invoice No
                        </th>

                        <th class="sticky top-0 px-4 py-3 w-40 text-xs font-bold uppercase">
                            Supplier
                        </th>

                        <th class="sticky top-0 px-4 py-3 w-64 text-xs font-bold uppercase">
                            Product Description
                        </th>

                        <th class="sticky top-0 px-4 py-3 w-28 text-xs font-bold uppercase">
                            Net Weight
                        </th>

                        <th class="sticky top-0 px-4 py-3 w-28 text-xs font-bold uppercase">
                            Unit Price
                        </th>

                        <th class="sticky top-0 px-4 py-3 w-32 text-xs font-bold uppercase">
                            Total Amount
                        </th>

                        <th class="sticky top-0 px-4 py-3 w-32 text-xs font-bold uppercase">
                            Checked By
                        </th>

                        <th class="sticky top-0 px-4 py-3 w-28 text-xs font-bold uppercase">
                            Actions
                        </th>

                    </tr>
                    </thead>

                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($exportProcurements as $exp)
                        <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200 text-center">

                            <td class="px-4 py-3">{{ $exp->date }}</td>
                            <td class="px-4 py-3">{{ $exp->invoice_number }}</td>
                            <td class="px-4 py-3">{{ $exp->supplier }}</td>
                            <td class="px-4 py-3 whitespace-normal break-words">
                                {{ $exp->product_description }}
                            </td>
                            <td class="px-4 py-3">{{ $exp->net_weight }}</td>
                            <td class="px-4 py-3">{{ number_format($exp->unit_price, 2) }}</td>
                            <td class="px-4 py-3">{{ number_format($exp->total_amount, 2) }}</td>
                            <td class="px-4 py-3">{{ $exp->checked_by }}</td>

                            <td class="px-4 py-3">
                                <button onclick="openEditModal('{{ $exp->id }}')" class="text-blue-600 hover:underline">
                                    Edit
                                </button>

                                <button onclick="confirmDelete('{{ $exp->id }}')"
                                        class="text-red-600 hover:underline ml-3">
                                    Delete
                                </button>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-4 py-4 text-gray-500 text-center">
                                No export procurement records found.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            {{-- ===================== PAGINATION ===================== --}}
            <div class="p-3 border-t border-gray-200 dark:border-gray-700">
                {{ $exportProcurements->links() }}
            </div>

        </div>

        {{-- ===================== DELETE CONFIRMATION ===================== --}}
        <script>
            function confirmDelete(id) {
                if (confirm("Are you sure you want to delete this record?")) {
                    document.getElementById(`delete-form-${id}`).submit();
                }
            }
        </script>
</div>


<!-- ================= ADD EXPORT PROCUREMENT MODAL ================== -->
<div id="addExportProcModal"
     class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center py-5">

    <div class="w-full max-w-[750px] bg-white dark:bg-gray-900 rounded-2xl shadow-2xl p-6
                transform transition-all scale-95 max-h-[calc(100vh-10rem)] overflow-y-auto"
         onclick="event.stopPropagation()">

        <h2 class="text-2xl font-semibold mb-6 text-blue-900 dark:text-gray-100 text-center">
            Add Export Procurement
        </h2>

        <form id="exportProcForm" action="{{ route('exportinvoiceManage.store') }}" method="POST">
            @csrf

            <!-- MASTER FIELDS -->
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm font-medium">Date</label>
                    <input type="date" name="date" required
                           class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium">Invoice Number</label>
                    <input type="text" name="invoice_number" required
                           class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                </div>
            </div>

            <div class="mt-3">
                <label class="block text-sm font-medium">Supplier</label>
                <input type="text" name="supplier" required
                       class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
            </div>

            <!-- DYNAMIC ITEMS -->
            <div id="exportProcItemsContainer" class="mt-6"></div>

            <!-- ADD ITEM BUTTON -->
            <button type="button" id="addExportProcItemBtn"
                    class="mt-4 px-4 py-2 bg-green-500 hover:bg-green-600 text-white text-sm rounded">
                + Add Item
            </button>

            <!-- AUTO-CALCULATED FIELDS -->
            <div class="grid grid-cols-2 gap-4 mt-6">
                <div>
                    <label class="block text-sm font-medium">Total Weight</label>
                    <input type="number" step="0.01" name="total_weight" id="totalWeight" readonly
                           class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm bg-gray-100">
                </div>

                <div>
                    <label class="block text-sm font-medium">Invoice Value</label>
                    <input type="number" step="0.01" name="invoice_value" id="invoiceValue" readonly
                           class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm bg-gray-100">
                </div>
            </div>

            <div class="mt-3">
                <label class="block text-sm font-medium">Checked By</label>
                <input type="text" name="checked_by"
                       class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
            </div>

            <div class="mt-3">
                <label class="block text-sm font-medium">Notes</label>
                <textarea name="notes" rows="3"
                          class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm"></textarea>
            </div>

            <div class="flex justify-end mt-6 space-x-3">
                <button type="button"
                        onclick="document.getElementById('addExportProcModal').classList.add('hidden')"
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

<script>
    let exportProcItemIndex = 0;
    const addExportItemBtn = document.getElementById('addExportProcItemBtn');
    const exportItemsContainer = document.getElementById('exportProcItemsContainer');
    const totalWeightField = document.getElementById('totalWeight');
    const invoiceValueField = document.getElementById('invoiceValue');

    // Add new item block
    addExportItemBtn.addEventListener('click', () => {
        const html = getExportItemFields(exportProcItemIndex++);
        exportItemsContainer.insertAdjacentHTML('beforeend', html);
        attachCalculationListeners();
    });

    // Remove item
    function removeExportProcItem(btn) {
        btn.closest('.export-item-block').remove();
        calculateTotals();
    }

    // TEMPLATE FOR ITEM FIELDS
    function getExportItemFields(index) {
        return `
            <div class="export-item-block border rounded-lg p-4 mt-4 bg-gray-50 dark:bg-gray-800 relative">
                <button type="button" onclick="removeExportProcItem(this)"
                        class="absolute top-2 right-2 text-red-500 hover:text-red-700 text-sm">✖</button>

                <div>
                    <label class="block text-sm font-medium">Product Description</label>
                    <textarea name="items[${index}][product_description]" required rows="2"
                        class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm"></textarea>
                </div>

                <div class="grid grid-cols-2 gap-2 mt-2">
                    <div>
                        <label class="block text-sm font-medium">Net Weight</label>
                        <input type="number" step="0.01" class="netWeight w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm"
                               name="items[${index}][net_weight]" required
                               oninput="calculateTotals()">
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Unit Price</label>
                        <input type="number" step="0.01" class="unitPrice w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm"
                               name="items[${index}][unit_price]" required
                               oninput="calculateTotals()">
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Total Amount</label>
                        <input type="number" step="0.01" class="totalAmount w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm bg-gray-100"
                               name="items[${index}][total_amount]" readonly>
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Unit of Measurement</label>
                        <select name="items[${index}][uom]" required
                                class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                            <option value="">Select UOM</option>
                            <option value="kg">Kilogram (KG)</option>
                            <option value="g">Gram (G)</option>
                            <option value="pcs">Pieces (PCS)</option>
                            <option value="m">Meter (M)</option>
                            <option value="m">Yards (M)</option>
                            <option value="m">Cones (C)</option>

                        </select>
                    </div>
                </div>
            </div>
        `;
    }

    // Attach event listeners after new items are added
    function attachCalculationListeners() {
        document.querySelectorAll('.netWeight, .unitPrice').forEach(input => {
            input.addEventListener('input', calculateTotals);
        });
    }

    // CALCULATION LOGIC
    function calculateTotals() {
        let totalWeight = 0;
        let totalInvoiceAmount = 0;

        document.querySelectorAll('.export-item-block').forEach(block => {
            const netWeight = parseFloat(block.querySelector('.netWeight')?.value) || 0;
            const unitPrice = parseFloat(block.querySelector('.unitPrice')?.value) || 0;

            const totalAmount = netWeight * unitPrice;
            block.querySelector('.totalAmount').value = totalAmount.toFixed(2);

            totalWeight += netWeight;
            totalInvoiceAmount += totalAmount;
        });

        totalWeightField.value = totalWeight.toFixed(2);
        invoiceValueField.value = totalInvoiceAmount.toFixed(2);
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

@endsection
