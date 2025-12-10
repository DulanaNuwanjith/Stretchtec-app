<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<div class="flex h-full w-full">
    @extends('layouts.stores-tabs')

    @section('content')
        <div class="flex-1 overflow-y-hidden">
            <div class="">
                <div class="w-full px-6 lg:px-2">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden">
                        <div class="flex-1 overflow-y-auto p-4 bg-white">
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

                            <div class="flex justify-start">
                                <button onclick="toggleFilterForm()"
                                    class="bg-white border border-blue-500 text-blue-500 hover:text-blue-600 hover:border-blue-600 font-semibold py-1 px-3 rounded shadow flex items-center gap-2 mb-6">
                                    <img src="{{ asset('icons/filter.png') }}" class="w-6 h-6" alt="Filter Icon">
                                    Filters
                                </button>
                            </div>

                            <div id="filterFormContainer" class="mt-4 hidden">
                                <form id="exportRawFilterForm" method="GET"
                                    action="{{ route('rawMaterialReceipt.index') }}"
                                    class="mb-6 sticky top-0 z-40 flex gap-6 items-center flex-wrap">

                                    <div class="flex items-center gap-4 flex-wrap">

                                        {{-- Supplier Filter --}}
                                        <div class="relative inline-block text-left w-48">
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Supplier</label>

                                            <input type="hidden" name="supplier" id="exportSupplierInput"
                                                value="{{ request('supplier') }}">

                                            <button type="button" id="exportSupplierDropdownBtn"
                                                class="inline-flex w-full justify-between rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-gray-300 hover:bg-gray-50 h-10"
                                                onclick="toggleExportSupplierDropdown(event)">

                                                <span
                                                    id="exportSelectedSupplier">{{ request('supplier') ?? 'Select Supplier' }}</span>

                                                <svg class="ml-2 h-5 w-5 text-gray-400" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 10.94l3.71-3.71a.75.75 0 1 1 1.06 1.06l-4.24 4.24a.75.75 0 0 1-1.06 0L5.25 8.29a.75.75 0 0 1-.02-1.08z" />
                                                </svg>
                                            </button>

                                            <div id="exportSupplierDropdownMenu"
                                                class="absolute z-40 mt-1 w-full bg-white border rounded-lg shadow-lg hidden max-h-48 overflow-y-auto p-2">
                                                <input type="text" id="exportSupplierSearchInput"
                                                    onkeyup="filterExportSupplierOptions()" placeholder="Search..."
                                                    class="w-full px-2 py-1 text-sm border rounded-md">

                                                @foreach ($suppliers as $supplier)
                                                    <div onclick="selectExportSupplier('{{ $supplier }}')"
                                                        tabindex="0"
                                                        class="export-supplier-option px-4 py-2 hover:bg-gray-100 cursor-pointer text-sm">
                                                        {{ $supplier }}
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        {{-- Product Description Filter --}}
                                        <div class="relative inline-block text-left w-48">
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Product
                                                Description</label>

                                            <input type="hidden" name="product_description" id="exportProductInput"
                                                value="{{ request('product_description') }}">

                                            <button type="button" id="exportProductDropdownBtn"
                                                class="inline-flex w-full justify-between rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-gray-300 hover:bg-gray-50 h-10"
                                                onclick="toggleExportProductDropdown(event)">

                                                <span
                                                    id="exportSelectedProduct">{{ request('product_description') ?? 'Select Product' }}</span>

                                                <svg class="ml-2 h-5 w-5 text-gray-400" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 10.94l3.71-3.71a.75.75 0 1 1 1.06 1.06l-4.24 4.24a.75.75 0 0 1-1.06 0L5.25 8.29a.75.75 0 0 1-.02-1.08z" />
                                                </svg>
                                            </button>

                                            <div id="exportProductDropdownMenu"
                                                class="absolute z-40 mt-1 w-full bg-white border rounded-lg shadow-lg hidden max-h-48 overflow-y-auto p-2">
                                                <input type="text" id="exportProductSearchInput"
                                                    onkeyup="filterExportProductOptions()" placeholder="Search..."
                                                    class="w-full px-2 py-1 text-sm border rounded-md">

                                                @foreach ($products as $product)
                                                    <div onclick="selectExportProduct('{{ $product }}')"
                                                        tabindex="0"
                                                        class="export-product-option px-4 py-2 hover:bg-gray-100 cursor-pointer text-sm">
                                                        {{ $product }}
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        {{-- Apply + Clear Buttons --}}
                                        <div class="flex items-end space-x-2 mt-2">
                                            <button type="submit"
                                                class="mt-4 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Apply
                                                Filters</button>

                                            <button type="button" id="clearExportFilters"
                                                class="mt-4 bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">Clear</button>
                                        </div>

                                    </div>
                                </form>
                            </div>

                            <!-- Header Section -->
                            <div class="flex justify-between items-center mb-6">
                                <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Raw Material Receipt &
                                    Invoice
                                    Records</h1>
                                <div class="flex space-x-3">
                                    <button
                                        onclick="document.getElementById('addExportRawMaterial').classList.remove('hidden')"
                                        class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded shadow">
                                        + Add New Raw Material
                                    </button>
                                </div>
                            </div>

                            <!-- Add Export Raw Material Modal -->
                            <div id="addExportRawMaterial"
                                class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center py-5"
                                onclick="this.classList.add('hidden')">

                                <div class="w-full max-w-[700px] bg-white rounded-2xl shadow-2xl p-6"
                                    onclick="event.stopPropagation()">

                                    <h2 class="text-2xl font-semibold mb-6 text-blue-900 text-center">
                                        Add New Export Raw Material
                                    </h2>

                                    <form action="{{ route('rawMaterialReceipt.store') }}" method="POST">
                                        @csrf

                                        <div class="space-y-4">

                                            <!-- Row 1 -->
                                            <div class="grid grid-cols-2 gap-4">
                                                <div>
                                                    <label class="block text-sm font-medium">Supplier</label>
                                                    <input name="supplier" type="text" required
                                                        class="w-full mt-1 px-3 py-2 border rounded-md text-sm">
                                                </div>

                                                <div>
                                                    <label class="block text-sm font-medium">Product Description</label>
                                                    <input name="product_description" type="text" required
                                                        class="w-full mt-1 px-3 py-2 border rounded-md text-sm">
                                                </div>
                                            </div>

                                            <!-- Row 2 -->
                                            <div class="grid grid-cols-3 gap-4">
                                                <div>
                                                    <label class="block text-sm font-medium">Net Weight</label>
                                                    <input name="net_weight" type="number" min="0.01" step="0.01"
                                                        required class="w-full mt-1 px-3 py-2 border rounded-md text-sm">
                                                </div>

                                                <div>
                                                    <label class="block text-sm font-medium">Unit</label>
                                                    <select name="uom"
                                                        class="w-full mt-1 px-3 py-2 border rounded-md text-sm">
                                                        <option value="kg">KG</option>
                                                        <option value="g">Gram</option>
                                                        <option value="m">Meter</option>
                                                        <option value="pcs">Pieces</option>
                                                    </select>
                                                </div>

                                                <div>
                                                    <label class="block text-sm font-medium">Unit Price</label>
                                                    <input name="unit_price" type="number" min="0.01"
                                                        step="0.01" required
                                                        class="w-full mt-1 px-3 py-2 border rounded-md text-sm">
                                                </div>
                                            </div>

                                            <!-- Row 4 -->
                                            <div>
                                                <label class="block text-sm font-medium">Notes</label>
                                                <textarea name="notes" rows="2" class="w-full mt-1 px-3 py-2 border rounded-md text-sm"></textarea>
                                            </div>
                                        </div>

                                        <!-- Buttons -->
                                        <div class="flex justify-end gap-3 mt-6">
                                            <button type="button"
                                                onclick="document.getElementById('addExportRawMaterial').classList.add('hidden')"
                                                class="px-4 py-2 bg-gray-200 text-gray-700 text-sm rounded hover:bg-gray-300">
                                                Cancel
                                            </button>

                                            <button type="submit"
                                                class="px-4 py-2 bg-blue-500 text-white text-sm rounded hover:bg-blue-600">
                                                Save Record
                                            </button>
                                        </div>

                                    </form>

                                </div>
                            </div>

                            <!-- Stock / Stores Records Table -->
                            <div class="overflow-x-auto bg-white dark:bg-gray-900 shadow rounded-lg">
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
                                    <thead class="bg-gray-100 dark:bg-gray-700">
                                        <tr class="text-center">
                                            <th
                                                class="font-bold sticky left-0 z-10 bg-white px-4 py-3 w-36 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                Supplier
                                            </th>
                                            <th
                                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-48 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                Product Description
                                            </th>
                                            <th
                                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                Net Weight
                                            </th>
                                            <th
                                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                Unit Price
                                            </th>
                                            <th
                                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-48 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                Notes
                                            </th>
                                            <th
                                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-36 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                Action
                                            </th>
                                        </tr>
                                    </thead>

                                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                        @forelse ($exportRawMaterials as $material)
                                            <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200 text-center">
                                                <td
                                                    class="sticky left-0 z-10 bg-white px-4 py-3 text-sm bg-gray-100 border-r border-gray-300 text-left whitespace-normal break-words font-bold">
                                                    {{ $material->supplier }}
                                                </td>

                                                <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 border-r">
                                                    {{ $material->product_description }}
                                                </td>

                                                <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 border-r">
                                                    {{ number_format($material->net_weight, 2) }} {{ $material->uom }}
                                                </td>

                                                <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 border-r">
                                                    {{ number_format($material->unit_price, 2) }}
                                                </td>

                                                <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 border-r">
                                                    {{ $material->notes ?? '—' }}
                                                </td>

                                                <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 border-r">
                                                    <div class="flex gap-2 justify-center">
                                                        <!-- Borrow Button -->
                                                        <button type="button"
                                                            onclick="openBorrowModal({{ $material->id }}, '{{ $material->product_description }}')"
                                                            class="bg-yellow-500 h-10 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">
                                                            Borrow
                                                        </button>
                                                        <button
                                                            class="bg-red-600 h-10 hover:bg-red-700 text-white px-3 py-1 rounded text-sm"
                                                            onclick="confirmDelete({{ $material->id }})">
                                                            Delete
                                                        </button>
                                                        <form id="delete-form-{{ $material->id }}"
                                                            action="{{ route('rawMaterialReceipt.delete', $material->id) }}"
                                                            method="POST" class="hidden">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6"
                                                    class="px-4 py-6 text-center text-gray-500 dark:text-gray-400">
                                                    No records found.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="py-6 flex justify-center">
                                {{ $exportRawMaterials->links() ?? '' }}
                            </div>
                        </div>

                        <div id="borrowModal"
                            class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center">
                            <div class="bg-white p-6 rounded-xl w-96 shadow-xl" onclick="event.stopPropagation()">
                                <h2 class="text-xl font-bold text-gray-800 mb-4">Borrow Raw Material</h2>

                                <form id="borrowForm" method="POST">
                                    @csrf
                                    <input type="hidden" id="borrow_material_id" name="id">

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Enter Quantity</label>
                                        <input type="number" id="borrow_qty" name="borrow_qty" min="0.01"
                                            step="0.01" required class="w-full mt-1 px-3 py-2 border rounded"
                                            placeholder="Quantity">
                                    </div>

                                    <div class="flex justify-end gap-3 mt-6">
                                        <button type="button" onclick="closeBorrowModal()"
                                            class="px-4 py-2 bg-gray-300 rounded">
                                            Cancel
                                        </button>
                                        <button type="submit"
                                            class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                                            Borrow
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
            function openBorrowModal(id, description) {
                document.getElementById('borrowModal').classList.remove('hidden');
                document.getElementById('borrow_material_id').value = id;
                document.getElementById('borrowForm').action = `/export-raw-material/borrow/${id}`;
            }

            function closeBorrowModal() {
                document.getElementById('borrowModal').classList.add('hidden');
                document.getElementById('borrow_qty').value = '';
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
                const form = document.getElementById('filterFormContainer');
                form.classList.toggle('hidden');
            }
        </script>

        <script>
            document.addEventListener("DOMContentLoaded", () => {

                const dropdowns = [{
                        btn: 'exportSupplierDropdownBtn',
                        menu: 'exportSupplierDropdownMenu'
                    },
                    {
                        btn: 'exportProductDropdownBtn',
                        menu: 'exportProductDropdownMenu'
                    },
                ];

                // Prevent closing dropdown when clicking inside
                dropdowns.forEach(d => {
                    const menu = document.getElementById(d.menu);
                    if (menu) menu.addEventListener('click', e => e.stopPropagation());
                });

                function toggleDropdown(menuId) {
                    dropdowns.forEach(d => {
                        if (d.menu !== menuId) document.getElementById(d.menu).classList.add('hidden');
                    });
                    document.getElementById(menuId).classList.toggle('hidden');
                }

                // Supplier
                window.toggleExportSupplierDropdown = function(e) {
                    e.stopPropagation();
                    toggleDropdown('exportSupplierDropdownMenu');
                }
                window.selectExportSupplier = function(val) {
                    document.getElementById('exportSupplierInput').value = val;
                    document.getElementById('exportSelectedSupplier').innerText = val;
                    document.getElementById('exportSupplierDropdownMenu').classList.add('hidden');
                }
                window.filterExportSupplierOptions = function() {
                    const s = document.getElementById('exportSupplierSearchInput').value.toLowerCase();
                    document.querySelectorAll('.export-supplier-option').forEach(opt => {
                        opt.style.display = opt.innerText.toLowerCase().includes(s) ? "" : "none";
                    });
                }

                // Product
                window.toggleExportProductDropdown = function(e) {
                    e.stopPropagation();
                    toggleDropdown('exportProductDropdownMenu');
                }
                window.selectExportProduct = function(val) {
                    document.getElementById('exportProductInput').value = val;
                    document.getElementById('exportSelectedProduct').innerText = val;
                    document.getElementById('exportProductDropdownMenu').classList.add('hidden');
                }
                window.filterExportProductOptions = function() {
                    const s = document.getElementById('exportProductSearchInput').value.toLowerCase();
                    document.querySelectorAll('.export-product-option').forEach(opt => {
                        opt.style.display = opt.innerText.toLowerCase().includes(s) ? "" : "none";
                    });
                }

                // Clear Filters
                const clearBtn = document.getElementById('clearExportFilters');
                if (clearBtn) {
                    clearBtn.addEventListener('click', () => {
                        window.location.href = "{{ route('rawMaterialReceipt.index') }}";
                    });
                }

                // Close all dropdowns on outside click
                document.addEventListener('click', () => {
                    dropdowns.forEach(d => document.getElementById(d.menu).classList.add('hidden'));
                });

            });
        </script>
    @endsection
