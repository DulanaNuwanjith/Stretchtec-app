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

                            <th
                                class="font-bold sticky left-0 z-10 bg-white px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase">
                                Invoice No
                            </th>

                            <th
                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase">
                                Date
                            </th>

                            <th
                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase">
                                Supplier
                            </th>

                            <th
                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase">
                                Product Description
                            </th>

                            <th
                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-28 text-xs text-gray-600 dark:text-gray-300 uppercase">
                                Net Weight
                            </th>

                            <th
                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-28 text-xs text-gray-600 dark:text-gray-300 uppercase">
                                Unit Price
                            </th>

                            <th
                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase">
                                Total Amount
                            </th>

                            <th
                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase">
                                Checked By
                            </th>

                            <th
                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase">
                                Notes
                            </th>

                            <th
                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase">
                                Actions
                            </th>

                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700 text-center">
                        @forelse($exportProcurements as $exp)
                            <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200 text-center">

                                <td
                                    class="sticky left-0 z-10 bg-white px-4 py-3 text-sm bg-gray-100 border-r border-gray-300 text-center whitespace-normal break-words font-bold">
                                    {{ $exp->invoice_number }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 border-r break-words">
                                    {{ $exp->date }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 border-r break-words">
                                    {{ $exp->supplier }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 border-r break-words">
                                    {{ $exp->product_description }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 border-r break-words">
                                    {{ $exp->net_weight }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 border-r break-words">
                                    {{ number_format($exp->unit_price, 2) }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 border-r break-words">
                                    {{ number_format($exp->total_amount, 2) }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 border-r break-words">
                                    {{ $exp->checked_by }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 border-r break-words">
                                    {{ $exp->notes }}</td>

                                <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 border-r text-center">
                                    <button onclick="openEditModal('{{ $exp->id }}')"
                                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs shadow-sm mt-2">
                                        Edit
                                    </button>

                                    <button onclick="confirmDelete('{{ $exp->id }}')"
                                        class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-xs shadow-sm mt-2">
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
                    <button type="button" onclick="document.getElementById('addExportProcModal').classList.add('hidden')"
                        class="px-4 py-2 bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-200 text-sm rounded hover:bg-gray-300">
                        Cancel
                    </button>
                    <button type="submit" id="createExportInvoiceBtn" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white text-sm rounded">
                        Save Invoice Record
                    </button>
                </div>

            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.querySelector('#addExportProcModal form');
            const submitBtn = document.getElementById('createExportInvoiceBtn');

            form.addEventListener('submit', function() {
                // Disable the button to prevent multiple clicks
                submitBtn.disabled = true;
                submitBtn.innerText = 'Submitting...';
            });
        });
    </script>

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
                            <option value="y">Yards (Y)</option>
                            <option value="c">Cones (C)</option>

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
@endsection
