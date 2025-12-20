@php use Carbon\Carbon; @endphp

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<div class="flex h-full w-full">
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
                    <img src="{{ asset('images/filter.png') }}" class="w-6 h-6" alt="Filter Icon">
                    Filters
                </button>
            </div>

            <div id="filterFormContainer" class="hidden mt-4">
                <form id="filterForm" method="GET" action="{{ route('exportinvoiceManage.index') }}" class="mb-6">
                    <div class="flex items-center gap-4 flex-wrap">

                        {{-- Filter: Invoice Number --}}
                        <div class="relative inline-block text-left w-56">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Invoice Number</label>
                            <input type="hidden" name="invoice_number" id="invoiceNumberInput" value="{{ request('invoice_number') }}">
                            <button type="button" id="invoiceDropdown" onclick="toggleDropdown('invoiceDropdown', 'invoiceDropdownMenu')"
                                class="inline-flex w-full justify-between rounded-md bg-white px-3 py-2 text-sm font-semibold
                                text-gray-900 shadow-sm ring-1 ring-gray-300 hover:bg-gray-50 h-10 dark:bg-gray-700 dark:text-white"
                                aria-expanded="false">
                                <span id="selectedInvoiceNumber">{{ request('invoice_number') ?? 'Select Invoice Number' }}</span>
                                <svg class="ml-2 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 10.94l3.71-3.71a.75.75 0 1 1 1.06 1.06l-4.24
                                        4.24a.75.75 0 0 1-1.06 0L5.25 8.29a.75.75 0 0 1-.02-1.08z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>

                            <div id="invoiceDropdownMenu"
                                class="absolute z-40 mt-1 w-full bg-white border rounded-lg shadow-lg hidden max-h-48 overflow-y-auto p-2">
                                <input type="text" id="invoiceSearch" onkeyup="filterDropdown('.invoice-option', 'invoiceSearch')"
                                    placeholder="Search..."
                                    class="w-full px-2 py-1 text-sm border rounded-md dark:bg-gray-600 dark:text-white dark:placeholder-gray-300">

                                @foreach ($uniqueInvoiceNumbers as $invoice)
                                    <div onclick="selectDropdownValue('invoiceDropdown', 'invoiceDropdownMenu', 'selectedInvoiceNumber', 'invoiceNumberInput', '{{ $invoice->invoice_number }}', 'Select Invoice Number')"
                                        class="invoice-option px-4 py-2 hover:bg-gray-100 cursor-pointer text-sm">
                                        {{ $invoice->invoice_number }}
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Filter: Supplier --}}
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

                                @foreach ($invoiceItems->flatten()->pluck('supplier')->unique() as $supplier)
                                    <div onclick="selectDropdownValue('supplierDropdown', 'supplierDropdownMenu', 'selectedSupplier', 'supplierInput', '{{ $supplier }}', 'Select Supplier')"
                                        class="supplier-option px-4 py-2 hover:bg-gray-100 cursor-pointer text-sm">
                                        {{ $supplier }}
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Filter: Date --}}
                        <div class="w-48">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Date</label>
                            <input type="date" name="date" value="{{ request('date') }}"
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

            {{-- ===================== COLLAPSIBLE EXPORT PROCUREMENT TABLE ===================== --}}
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
                    <thead class="bg-gray-200 dark:bg-gray-700">
                        <tr class="text-center">

                            <!-- Parent Columns -->
                            <th
                                class="font-bold sticky left-0 z-10 bg-white px-4 py-3 w-36 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                Invoice No
                            </th>
                            <th
                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-36 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                Date</th>
                            <th
                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-40 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                Supplier</th>

                            <!-- Item Columns -->
                            <th
                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-36 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                Product Description</th>
                            <th
                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-28 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                Net Weight</th>
                            <th
                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-28 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                Unit Price</th>
                            <th
                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                Amount</th>
                            <th
                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                Total Amount</th>
                            <th
                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-28 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                Checked By</th>
                            <th
                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-40 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                Notes</th>
                            <th
                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                Actions</th>

                        </tr>
                    </thead>

                    @forelse ($invoiceItems as $invoiceNumber => $items)
                        @php
                            $hasMultiple = $items->count() > 1;
                            $first = $items->first();
                        @endphp

                        <tbody x-data="{ open: false }" class="divide-y divide-gray-200 dark:divide-gray-600">

                            <!-- ===================== PARENT ROW ===================== -->
                            <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200 text-center">

                                <!-- Expand/Collapse -->
                                <td
                                    class="sticky left-0 z-10 bg-white px-4 py-3 text-sm bg-gray-100 border-r border-gray-300 text-left whitespace-normal break-words font-bold">
                                    @if ($hasMultiple)
                                        <button @click="open = !open"
                                            class="flex items-center w-full gap-2 text-blue-600 hover:text-blue-800">
                                            <span class="w-2 shrink-0" x-text="open ? '▾' : '▸'"></span>
                                            <span class="flex-1 text-center">{{ $invoiceNumber }}</span>
                                        </button>
                                    @else
                                        <div class="flex items-center w-full gap-2">
                                            <span class="w-2 shrink-0 opacity-0">▸</span>
                                            <span class="flex-1 text-center">{{ $invoiceNumber }}</span>
                                        </div>
                                    @endif
                                </td>

                                <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 border-r break-words">
                                    {{ $first->date }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 border-r break-words">
                                    {{ $first->supplier }}</td>

                                <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 border-r break-words">
                                    {{ $first->product_description }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 border-r break-words">
                                    {{ $first->net_weight }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 border-r break-words">
                                    {{ number_format($first->unit_price, 2) }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 border-r break-words">
                                    {{ number_format($first->total_amount, 2) }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 border-r break-words">
                                    {{ number_format($first->invoice_value, 2) }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 border-r break-words">
                                    {{ $first->checked_by }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 border-r break-words">
                                    {{ $first->notes }}</td>
                                <!-- Actions -->
                                <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 border-r">
                                    <div class="flex space-x-2 justify-center items-center">
                                        @if (Auth::user()->role === 'SUPERADMIN')
                                            <form id="delete-form-{{ $first->id }}"
                                                action="{{ route('exportinvoiceManage.destroy', $first->id) }}"
                                                method="POST" class="flex items-center">

                                                @csrf
                                                @method('DELETE')

                                                <button type="button" onclick="confirmDelete('{{ $first->id }}')"
                                                    class="bg-red-600 h-10 mt-3 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">
                                                    Delete
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>

                            <!-- ===================== CHILD ROWS ===================== -->
                            @if ($hasMultiple)
                                @foreach ($items->skip(1) as $item)
                                    <tr x-show="open" style="display: none;" class="bg-gray-50">

                                        <td class="sticky left-0 border-r bg-white"></td>
                                        <td
                                            class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 border-r text-center break-words">
                                        </td>
                                        <td
                                            class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 border-r text-center break-words">
                                        </td>

                                        <td
                                            class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 border-r text-center break-words">
                                            {{ $item->product_description }}</td>
                                        <td
                                            class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 border-r text-center break-words">
                                            {{ $item->net_weight }}</td>
                                        <td
                                            class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 border-r text-center break-words">
                                            {{ number_format($item->unit_price, 2) }}</td>
                                        <td
                                            class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 border-r text-center break-words">
                                            {{ number_format($item->total_amount, 2) }}</td>
                                        <td
                                            class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 border-r text-center break-words">
                                            {{ $item->checked_by }}</td>
                                        <td
                                            class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 border-r text-center break-words">
                                            {{ $item->notes }}</td>

                                        <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 border-r text-center">
                                            -
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 border-r text-center">

                                        </td>


                                    </tr>
                                @endforeach
                            @endif

                        </tbody>
                        @empty
                            <tr>
                                <td colspan="11"
                                    class="text-center px-6 py-6 text-gray-500 text-sm italic">
                                    No records found.
                                </td>
                            </tr>
                    @endforelse

                </table>
            </div>

            {{-- Pagination --}}
            <div class="py-6 flex justify-center">
                {{ $uniqueInvoiceNumbers->links() }}
            </div>
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
                        <button type="button"
                            onclick="document.getElementById('addExportProcModal').classList.add('hidden')"
                            class="px-4 py-2 bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-200 text-sm rounded hover:bg-gray-300">
                            Cancel
                        </button>
                        <button type="submit" id="createExportInvoiceBtn"
                            class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white text-sm rounded">
                            Save Invoice Record
                        </button>
                    </div>

                </form>
            </div>
        </div>
        </div>
        </div>
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
                // Clear Invoice Number
                document.getElementById('selectedInvoiceNumber').innerText = 'Select Invoice Number';
                document.getElementById('invoiceNumberInput').value = '';
                document.getElementById('invoiceSearch').value = '';
                filterDropdown('.invoice-option', 'invoiceSearch');

                // Clear Supplier
                document.getElementById('selectedSupplier').innerText = 'Select Supplier';
                document.getElementById('supplierInput').value = '';
                document.getElementById('supplierSearch').value = '';
                filterDropdown('.supplier-option', 'supplierSearch');

                // Clear Date
                document.querySelector('input[name="date"]').value = '';

                // Reset form and reload page
                document.getElementById('filterForm').reset();
                window.location.href = "{{ route('exportinvoiceManage.index') }}";
            }

            // Close dropdown if click outside
            document.addEventListener('click', function(e) {
                const dropdowns = [
                    { btn: 'invoiceDropdown', menu: 'invoiceDropdownMenu' },
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
