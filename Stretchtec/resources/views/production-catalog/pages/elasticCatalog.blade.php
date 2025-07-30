<head>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<div class="flex h-full w-full">
    @extends('layouts.product-catalog-tabs')

    @section('content')
        <div class="flex-1 overflow-y-auto">
            <div class="">
                <div class="w-full px-6 lg:px-2">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
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

                            <!-- Filter Form -->
                            <form id="filterForm1" method="GET" action="" class="mb-6 flex gap-6 items-center">
                                <div class="flex items-center gap-4">

                                    <!-- CUSTOMER DROPDOWN -->
                                    <div class="relative inline-block text-left w-48">
                                        <label for="customerDropdown"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Order
                                            No</label>
                                        <div>
                                            <button type="button" id="customerDropdown"
                                                class="inline-flex w-full justify-between rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-gray-300 hover:bg-gray-50 h-10 dark:bg-gray-700 dark:text-white"
                                                onclick="toggleDropdown('customer')" aria-haspopup="listbox"
                                                aria-expanded="false">
                                                <span
                                                    id="selectedCustomer">{{ request('customer') ? request('customer') : 'Select Sample No' }}</span>
                                                <svg class="ml-2 h-5 w-5 text-gray-400" viewBox="0 0 20 20"
                                                    fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 10.94l3.71-3.71a.75.75 0 1 1 1.06 1.06l-4.24 4.24a.75.75 0 0 1-1.06 0L5.25 8.29a.75.75 0 0 1-.02-1.08z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </div>
                                        <div id="customerDropdownMenu"
                                            class="hidden absolute z-10 mt-2 w-full rounded-md bg-white shadow-lg ring-1 ring-black/5 dark:bg-gray-700 max-h-48 overflow-y-auto">
                                            <div class="p-2 sticky top-0 bg-white dark:bg-gray-700 z-10">
                                                <input type="text" id="customerSearchInput"
                                                    placeholder="Search customers..."
                                                    class="w-full px-2 py-1 text-sm border rounded-md dark:bg-gray-600 dark:text-white dark:placeholder-gray-300"
                                                    onkeyup="filterOptions('customer')" />
                                            </div>
                                            <div class="py-1" role="listbox" tabindex="-1"
                                                aria-labelledby="customerDropdown">
                                                <button type="button"
                                                    class="customer-option w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600"
                                                    onclick="selectOption('customer', '')">Select Customer</button>
                                                <button type="button"
                                                    class="customer-option w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600"
                                                    onclick="selectOption('customer', 'TIMEX')">TIMEX</button>
                                                <button type="button"
                                                    class="customer-option w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600"
                                                    onclick="selectOption('customer', 'NESTLE')">NESTLE</button>
                                                <button type="button"
                                                    class="customer-option w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600"
                                                    onclick="selectOption('customer', 'PEPSI')">PEPSI</button>
                                            </div>
                                        </div>
                                        <input type="hidden" name="customer" id="customerInput"
                                            value="{{ request('customer') }}">
                                    </div>

                                    <!-- MERCHANDISER DROPDOWN -->
                                    <div class="relative inline-block text-left w-48">
                                        <label for="merchandiserDropdown"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Customer
                                            Coordinator</label>
                                        <div>
                                            <button type="button" id="merchandiserDropdown"
                                                class="inline-flex w-full justify-between rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-gray-300 hover:bg-gray-50 h-10 dark:bg-gray-700 dark:text-white"
                                                onclick="toggleDropdown('merchandiser')" aria-haspopup="listbox"
                                                aria-expanded="false">
                                                <span
                                                    id="selectedMerchandiser">{{ request('merchandiser') ? request('merchandiser') : 'Select Merchandiser' }}</span>
                                                <svg class="ml-2 h-5 w-5 text-gray-400" viewBox="0 0 20 20"
                                                    fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 10.94l3.71-3.71a.75.75 0 1 1 1.06 1.06l-4.24 4.24a.75.75 0 0 1-1.06 0L5.25 8.29a.75.75 0 0 1-.02-1.08z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </div>
                                        <div id="merchandiserDropdownMenu"
                                            class="hidden absolute z-10 mt-2 w-full rounded-md bg-white shadow-lg ring-1 ring-black/5 dark:bg-gray-700 max-h-48 overflow-y-auto">
                                            <div class="p-2 sticky top-0 bg-white dark:bg-gray-700 z-10">
                                                <input type="text" id="merchandiserSearchInput"
                                                    placeholder="Search merchandisers..."
                                                    class="w-full px-2 py-1 text-sm border rounded-md dark:bg-gray-600 dark:text-white dark:placeholder-gray-300"
                                                    onkeyup="filterOptions('merchandiser')" />
                                            </div>
                                            <div class="py-1" role="listbox" tabindex="-1"
                                                aria-labelledby="merchandiserDropdown">
                                                <button type="button"
                                                    class="merchandiser-option w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600"
                                                    onclick="selectOption('merchandiser', '')">Select Merchandiser</button>
                                                <button type="button"
                                                    class="merchandiser-option w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600"
                                                    onclick="selectOption('merchandiser', 'John Doe')">John Doe</button>
                                                <button type="button"
                                                    class="merchandiser-option w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600"
                                                    onclick="selectOption('merchandiser', 'Jane Smith')">Jane
                                                    Smith</button>
                                            </div>
                                        </div>
                                        <input type="hidden" name="merchandiser" id="merchandiserInput"
                                            value="{{ request('merchandiser') }}">
                                    </div>

                                    <!-- ITEM DROPDOWN -->
                                    <div class="relative inline-block text-left w-48">
                                        <label for="itemDropdown"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Reference
                                            No</label>
                                        <div>
                                            <button type="button" id="itemDropdown"
                                                class="inline-flex w-full justify-between rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-gray-300 hover:bg-gray-50 h-10 dark:bg-gray-700 dark:text-white"
                                                onclick="toggleDropdown('item')" aria-haspopup="listbox"
                                                aria-expanded="false">
                                                <span
                                                    id="selectedItem">{{ request('item') ? request('item') : 'Select Item' }}</span>
                                                <svg class="ml-2 h-5 w-5 text-gray-400" viewBox="0 0 20 20"
                                                    fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 10.94l3.71-3.71a.75.75 0 1 1 1.06 1.06l-4.24 4.24a.75.75 0 0 1-1.06 0L5.25 8.29a.75.75 0 0 1-.02-1.08z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </div>
                                        <div id="itemDropdownMenu"
                                            class="hidden absolute z-10 mt-2 w-full rounded-md bg-white shadow-lg ring-1 ring-black/5 dark:bg-gray-700 max-h-48 overflow-y-auto">
                                            <div class="p-2 sticky top-0 bg-white dark:bg-gray-700 z-10">
                                                <input type="text" id="itemSearchInput" placeholder="Search items..."
                                                    class="w-full px-2 py-1 text-sm border rounded-md dark:bg-gray-600 dark:text-white dark:placeholder-gray-300"
                                                    onkeyup="filterOptions('item')" />
                                            </div>
                                            <div class="py-1" role="listbox" tabindex="-1"
                                                aria-labelledby="itemDropdown">
                                                <button type="button"
                                                    class="item-option w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600"
                                                    onclick="selectOption('item', '')">Select Item</button>
                                                <button type="button"
                                                    class="item-option w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600"
                                                    onclick="selectOption('item', 'ITEM001')">ITEM001</button>
                                                <button type="button"
                                                    class="item-option w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600"
                                                    onclick="selectOption('item', 'ITEM002')">ITEM002</button>
                                                <button type="button"
                                                    class="item-option w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600"
                                                    onclick="selectOption('item', 'ITEM003')">ITEM003</button>
                                            </div>
                                        </div>
                                        <input type="hidden" name="item" id="itemInput"
                                            value="{{ request('item') }}">
                                    </div>


                                </div>

                                <button type="submit"
                                    class="mt-4 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                                    Apply Filters
                                </button>

                                <button type="button" id="clearFiltersBtn"
                                    class="mt-4 bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-200 px-4 py-2 rounded hover:bg-gray-300">
                                    Clear Filters
                                </button>
                            </form>


                            <div class="flex justify-between items-center mb-6">
                                <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Elastic Production Catalog
                                </h1>
                                <button
                                    onclick="document.getElementById('addElasticCatalogModal').classList.remove('hidden')"
                                    class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded shadow">
                                    + Add New Item
                                </button>
                            </div>

                            <div class="overflow-x-auto bg-white dark:bg-gray-900 shadow rounded-lg">
                                <table class="table-fixed w-full text-sm divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead class="bg-gray-200 dark:bg-gray-700 text-left">
                                        <tr class="text-center">
                                            <th
                                                class="font-bold sticky left-0 z-10 bg-white px-4 py-3 w-32 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                Order No</th>
                                            <th
                                                class="font-bold px-4 py-3 w-48 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                Reference No</th>
                                            <th
                                                class="font-bold px-4 py-3 w-32 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                Date</th>
                                            <th
                                                class="font-bold px-4 py-3 w-36 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                Customer Coordinator</th>
                                            <th
                                                class="font-bold px-4 py-3 w-32 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                Size</th>
                                            <th
                                                class="font-bold px-4 py-3 w-32 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                Colour</th>
                                            <th
                                                class="font-bold px-4 py-3 w-32 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                Shade</th>
                                            <th
                                                class="font-bold px-4 py-3 w-32 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                TKT</th>
                                        </tr>
                                    </thead>
                                    <tbody id="productionCatalogTable"
                                        class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                        @foreach ($catalogs as $catalog)
                                            <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200 text-center">
                                                <td
                                                    class="sticky left-0 z-10 bg-white px-4 py-3 bg-gray-100 whitespace-normal break-words border-r border-gray-300 text-left">
                                                    <span class="readonly font-bold">{{ $catalog->order_no }}</span>
                                                    <input
                                                        class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                        value="{{ $catalog->order_no }}" />
                                                </td>
                                                <td class="px-4 py-3 w-48 whitespace-normal break-words">
                                                    <span class="readonly">{{ $catalog->reference_no }}</span>
                                                    <input
                                                        class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                        value="{{ $catalog->reference }}" />
                                                </td>
                                                <td class="px-4 py-3 w-40 whitespace-normal break-words">
                                                    <span
                                                        class="readonly">{{ $catalog->reference_added_date?->format('Y-m-d') }}</span>
                                                    <input type="date"
                                                        class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                        value="{{ $catalog->reference_added_date?->format('Y-m-d') }}" />
                                                </td>
                                                <td class="px-4 py-3 w-36 whitespace-normal break-words">
                                                    <span class="readonly">{{ $catalog->coordinator_name }}</span>
                                                    <input
                                                        class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                        value="{{ $catalog->coordinator_name }}" />
                                                </td>
                                                <td class="px-4 py-3 w-32 whitespace-normal break-words">
                                                    <span class="readonly">{{ $catalog->size }}</span>
                                                    <input
                                                        class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                        value="{{ $catalog->size }}" />
                                                </td>
                                                <td class="px-4 py-3 w-32 whitespace-normal break-words">
                                                    <span class="readonly">{{ $catalog->colour }}</span>
                                                    <input
                                                        class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                        value="{{ $catalog->colour }}" />
                                                </td>
                                                <td class="px-4 py-3 w-32 whitespace-normal break-words">
                                                    <span class="readonly">{{ $catalog->shade }}</span>
                                                    <input
                                                        class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                        value="{{ $catalog->shade }}" />
                                                </td>
                                                <td class="px-4 py-3 w-32 whitespace-normal break-words">
                                                    <span class="readonly">{{ $catalog->tkt }}</span>
                                                    <input
                                                        class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                        value="{{ $catalog->tkt }}" />
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="flex justify-center">
                                    {{ $catalogs->links() }}
                                </div>
                            </div>
                            <!-- Add Product Modal -->
                            <div id="addElasticCatalogModal"
                                class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center py-5">
                                <div class="w-full max-w-[700px] bg-white dark:bg-gray-900 rounded-2xl shadow-2xl p-4 transform transition-all scale-95 max-h-[calc(100vh-10rem)] overflow-y-auto"
                                    onclick="event.stopPropagation()">
                                    <div class="max-w-[600px] mx-auto p-8">
                                        <h2
                                            class="text-2xl font-semibold mb-8 text-blue-900 mt-4 dark:text-gray-100 text-center">
                                            Add New Elastic Catalog Item
                                        </h2>
                                        <form action="" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="space-y-4">
                                                <div class="flex gap-4">
                                                    <div class="w-1/2">
                                                        <label for="sampleQuantity"
                                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Order
                                                            Number
                                                        </label>
                                                        <input id="sampleQuantity" type="text" name="sample_quantity"
                                                            required
                                                            class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm mb-4">
                                                    </div>
                                                    <div class="w-1/2">
                                                        <label for="item"
                                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Referance
                                                            No</label>
                                                        <input id="item" type="text" name="item" required
                                                            class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                    </div>
                                                </div>

                                                <!-- Referance No -->
                                                <div class="flex gap-4">
                                                    <div class="w-1/2">
                                                        <label for="inquiryDate"
                                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date</label>
                                                        <input id="Date" type="date" name="inquiry_date" required
                                                            class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                    </div>
                                                    <div class="w-1/2">
                                                        <label for="merchandiser"
                                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Customer
                                                            Coordinator</label>
                                                        <input id="Merchandiser" type="text" name="customer" required
                                                            class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                    </div>
                                                </div>

                                                <div class="flex gap-4">
                                                    <div class="w-1/2">
                                                        <label for="size"
                                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Size</label>
                                                        <input id="size" type="text" name="size" required
                                                            class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                    </div>
                                                    <div class="w-1/2">
                                                        <label for="item"
                                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Colour</label>
                                                        <input id="item" type="text" name="item" required
                                                            class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                    </div>
                                                </div>

                                                <!-- Merchandiser & Item -->
                                                <div class="flex gap-4">
                                                    <div class="w-1/2">
                                                        <label for="size"
                                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Shade</label>
                                                        <input id="size" type="text" name="size" required
                                                            class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                    </div>
                                                    <div class="w-1/2">
                                                        <label for="colour"
                                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">TKT</label>
                                                        <input id="colour" type="text" name="colour" required
                                                            class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Buttons -->
                                            <div class="flex justify-end gap-3 mt-12">
                                                <button type="button"
                                                    onclick="document.getElementById('addElasticCatalogModal').classList.add('hidden')"
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const clearFiltersBtn = document.getElementById('clearFiltersBtn');
            const selectedVehicle = document.getElementById('selectedVehicle');
            const filterForm = document.getElementById('filterForm');

            clearFiltersBtn.addEventListener('click', () => {
                // Clear values
                document.getElementById('customerInput').value = '';
                document.getElementById('merchandiserInput').value = '';
                document.getElementById('itemInput').value = '';

                document.getElementById('selectedCustomer').textContent = 'Select Sample No';
                document.getElementById('selectedMerchandiser').textContent = 'Select Merchandiser';
                document.getElementById('selectedItem').textContent = 'Select Item';

                // Submit the form
                filterForm.submit();
            });

        });
    </script>

    <script>
        function toggleDropdown(type) {
            const menu = document.getElementById(`${type}DropdownMenu`);
            const btn = document.getElementById(`${type}Dropdown`);
            const expanded = btn.getAttribute('aria-expanded') === 'true';
            menu.classList.toggle('hidden');
            btn.setAttribute('aria-expanded', !expanded);
        }

        function selectOption(type, value) {
            const displayText = value || `Select ${type.charAt(0).toUpperCase() + type.slice(1)}`;
            document.getElementById(`selected${capitalize(type)}`).innerText = value || `All ${capitalize(type)}s`;
            document.getElementById(`${type}Input`).value = value;
            document.getElementById(`${type}DropdownMenu`).classList.add('hidden');
            document.getElementById(`${type}Dropdown`).setAttribute('aria-expanded', false);
        }

        function filterOptions(type) {
            const input = document.getElementById(`${type}SearchInput`).value.toLowerCase();
            const options = document.querySelectorAll(`.${type}-option`);
            options.forEach(option => {
                const text = option.textContent.toLowerCase();
                option.style.display = text.includes(input) ? 'block' : 'none';
            });
        }

        function capitalize(str) {
            return str.charAt(0).toUpperCase() + str.slice(1);
        }

        // Close dropdowns on outside click
        document.addEventListener('click', function(e) {
            ['item', 'customer', 'merchandiser'].forEach(type => {
                const btn = document.getElementById(`${type}Dropdown`);
                const menu = document.getElementById(`${type}DropdownMenu`);
                if (!btn.contains(e.target) && !menu.contains(e.target)) {
                    menu.classList.add('hidden');
                    btn.setAttribute('aria-expanded', false);
                }
            });
        });
    </script>

    <script>
        function editRow(rowId) {
            const row = document.getElementById(rowId);
            row.querySelectorAll('.readonly').forEach(span => span.classList.add('hidden'));
            row.querySelectorAll('.editable').forEach(input => input.classList.remove('hidden'));
            row.querySelector('button.bg-green-600').classList.add('hidden'); // Hide Edit button
            row.querySelector('button.bg-blue-600').classList.remove('hidden'); // Show Save button
        }

        function saveRow(rowId) {
            const row = document.getElementById(rowId);
            const inputs = row.querySelectorAll('.editable');
            const spans = row.querySelectorAll('.readonly');

            inputs.forEach((input, i) => {
                spans[i].textContent = input.value;
                input.classList.add('hidden');
            });
            spans.forEach(span => span.classList.remove('hidden'));

            row.querySelector('button.bg-green-600').classList.remove('hidden'); // Show Edit button
            row.querySelector('button.bg-blue-600').classList.add('hidden'); // Hide Save button
        }
    </script>
@endsection
