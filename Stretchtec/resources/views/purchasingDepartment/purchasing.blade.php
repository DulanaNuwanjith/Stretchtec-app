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
                <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Purchasing Records</h1>

                <div class="flex space-x-3">
                    <button
                        onclick="document.getElementById('newPurchaseModel').classList.remove('hidden')"
                        class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded shadow">
                        + Add New Purchasing
                    </button>
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
                            <th
                                class="font-bold sticky left-0 z-10 bg-white px-4 py-3 w-36 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                Order No
                            </th>
                            <th
                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                Color
                            </th>
                            <th
                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                Shade
                            </th>
                            <th
                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                PST No
                            </th>
                            <th
                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                TKT
                            </th>
                            <th
                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                Supplier Comment
                            </th>
                            <th
                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                Kg or Cone
                            </th>
                            <th
                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                Price
                            </th>
                            <th
                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                Description
                            </th>
                        </tr>
                    </thead>
                    <tbody id="purchaseRecords"
                        class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($purchasings ?? [] as $purchase)
                            <tr id="row{{ $purchase->id }}"
                                class="odd:bg-white even:bg-gray-50 border-b border-gray-200 text-center h-20">
                                
                                <!-- Order No -->
                                <td class="sticky left-0 z-10 px-4 py-3 bg-gray-100 font-semibold text-gray-700 dark:text-gray-200 border-r border-gray-300">
                                    {{ $purchase->order_no }}
                                </td>

                                <!-- Color -->
                                <td class="px-4 py-3 text-center text-gray-800 dark:text-gray-300 border-r border-gray-300">
                                    {{ $purchase->color }}
                                </td>

                                <!-- Shade -->
                                <td class="px-4 py-3 text-center text-gray-800 dark:text-gray-300 border-r border-gray-300">
                                    {{ $purchase->shade }}
                                </td>

                                <!-- PST No -->
                                <td class="px-4 py-3 text-center text-gray-800 dark:text-gray-300 border-r border-gray-300">
                                    {{ $purchase->pst_no }}
                                </td>

                                <!-- TKT -->
                                <td class="px-4 py-3 text-center text-gray-800 dark:text-gray-300 border-r border-gray-300">
                                    {{ $purchase->tkt }}
                                </td>

                                <!-- Supplier Comment -->
                                <td class="px-4 py-3 text-center text-gray-800 dark:text-gray-300 border-r border-gray-300">
                                    {{ $purchase->supplier_comment }}
                                </td>

                                <!-- KG or Cone -->
                                <td class="px-4 py-3 text-center text-gray-800 dark:text-gray-300 border-r border-gray-300">
                                    {{ $purchase->type }}
                                </td>

                                <!-- Price -->
                                <td class="px-4 py-3 text-center text-gray-800 dark:text-gray-300 border-r border-gray-300">
                                    {{ $purchase->price }}
                                </td>

                                <!-- Description -->
                                <td class="px-4 py-3 text-center text-gray-800 dark:text-gray-300">
                                    {{ $purchase->description }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-gray-500 py-6 bg-gray-50 dark:bg-gray-900 dark:text-gray-400">
                                    No purchase records found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>


                </table>

            </div>

            <!-- Purchase Model -->
            <div id="newPurchaseModel"
                class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center py-5">
                <div
                    class="w-full max-w-[700px] bg-white dark:bg-gray-900 rounded-2xl shadow-2xl p-4 transform transition-all scale-95 max-h-[calc(100vh-10rem)] overflow-y-auto"
                    onclick="event.stopPropagation()">
                    <div class="max-w-[600px] mx-auto p-8">
                        <h2 class="text-2xl font-semibold mb-8 text-blue-900 mt-4 dark:text-gray-100 text-center">
                            Add New Purchase Order
                        </h2>

                        <form action="{{ route('purchasings.store') }}" method="POST">
                            @csrf
                            <div class="space-y-4">

                                <!-- Row 1 -->
                                <div class="flex gap-4">
                                    <div class="w-1/2">
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Order No.</label>
                                        <input type="text" class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm" name="order_no">
                                    </div>
                                    <div class="w-1/2">
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Color</label>
                                        <input type="text" class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm" name="color">
                                    </div>
                                </div>

                                <!-- Row 2 -->
                                <div class="flex gap-4">
                                    <div class="w-1/2">
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Shade</label>
                                        <input type="text" class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm" name="shade">
                                    </div>
                                    <div class="w-1/2">
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">PST No.</label>
                                        <input type="text" class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm" name="pst_no">
                                    </div>
                                </div>

                                <!-- Row 3 -->
                                <div class="flex gap-4">
                                    <div class="w-1/2">
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">TKT</label>
                                        <input type="text" class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm" name="tkt">
                                    </div>
                                    <div class="w-1/2">
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Supplier Comment</label>
                                        <input type="text" class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm" name="supplier_comment">
                                    </div>
                                </div>

                                <!-- Row 4 -->
                                <div class="flex gap-4">
                                    <div class="relative inline-block text-left w-1/2">
                                        <label for="KgOrConetypeDropdown" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                            KG or Cone
                                        </label>
                                        <div>
                                            <button type="button" id="KgOrConetypeDropdown"
                                                class="inline-flex w-full justify-between rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-gray-300 hover:bg-gray-50 h-10 dark:bg-gray-700 dark:text-white"
                                                onclick="toggleDropdown('type')" aria-haspopup="listbox" aria-expanded="false">
                                                <span id="selectedType">Select Type</span>
                                                <svg class="ml-2 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 10.94l3.71-3.71a.75.75 0 1 1 1.06 1.06l-4.24 4.24a.75.75 0 0 1-1.06 0L5.25 8.29a.75.75 0 0 1-.02-1.08z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </div>

                                        <!-- Dropdown Menu -->
                                        <div id="typeDropdownMenu"
                                            class="absolute mt-1 w-full rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 hidden z-10">
                                            <ul tabindex="-1" role="listbox" class="max-h-60 overflow-auto py-1 text-sm text-gray-700">
                                                <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer" onclick="selectType('KG')">KG</li>
                                                <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer" onclick="selectType('Cone')">Cone</li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="w-1/2">
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                            Quantity
                                        </label>
                                        <input type="text"
                                            class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm" name="quantity">
                                    </div>
                                    <input type="hidden" name="type" id="typeInput">
                                </div>

                                <!-- Row 5 -->
                                <div class="flex gap-4">
                                    <div class="w-1/2">
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Price</label>
                                        <input type="text" class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm" name="price">
                                    </div>
                                    <div class="w-1/2">
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                                        <input type="text" class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md 
                                            dark:bg-gray-700 dark:text-white text-sm" name="description">
                                    </div>
                                </div>

                            </div>

                            <!-- Buttons -->
                            <div class="flex justify-end gap-3 mt-12">
                                <button type="button"
                                        onclick="document.getElementById('newPurchaseModel').classList.add('hidden')"
                                        class="px-4 py-2 bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-200 text-sm rounded hover:bg-gray-300">
                                    Cancel
                                </button>
                                <button type="submit"
                                        class="px-4 py-2 bg-blue-500 text-white text-sm rounded hover:bg-blue-600">
                                    Save
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>

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

        {{-- ModelDropDown --}}
        <script>
            function toggleDropdown(type) {
                const menu = document.getElementById(`${type}DropdownMenu`);
                menu.classList.toggle('hidden');
            }

            function selectType(value) {
            document.getElementById('selectedType').textContent = value;
            document.getElementById('typeInput').value = value;
            document.getElementById('typeDropdownMenu').classList.add('hidden');
}

        </script>
    @endsection
