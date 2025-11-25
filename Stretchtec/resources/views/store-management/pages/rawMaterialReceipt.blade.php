<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<div class="flex h-full w-full">
    @extends('layouts.stores-tabs')

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

            <!-- Header Section -->
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Raw Material Receipt & Invoice
                    Records</h1>
                <div class="flex space-x-3">
                    <button onclick="document.getElementById('addRawMaterial').classList.remove('hidden')"
                            class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded shadow">
                        + Add New Invoice
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
                        <th class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-40 text-xs text-gray-600 dark:text-gray-300 uppercase">
                            Supplier
                        </th>
                        <th class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-64 text-xs text-gray-600 dark:text-gray-300 uppercase">
                            Product Description
                        </th>
                        <th class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase">
                            Net Weight
                        </th>
                        <th class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase">
                            Unit Price
                        </th>
                        <th class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase">
                            Total Amount
                        </th>
                        <th class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-40 text-xs text-gray-600 dark:text-gray-300 uppercase">
                            Notes
                        </th>
                        <th class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase">
                            Action
                        </th>
                    </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($exportRawMaterials as $material)
                        <tr class="text-center hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                            <td class="px-4 py-3 text-gray-800 dark:text-gray-200">
                                {{ $material->supplier }}
                            </td>

                            <td class="px-4 py-3 text-gray-800 dark:text-gray-200 break-words">
                                {{ $material->product_description }}
                            </td>

                            <td class="px-4 py-3 text-gray-800 dark:text-gray-200">
                                {{ number_format($material->net_weight, 2) }}
                            </td>

                            <td class="px-4 py-3 text-gray-800 dark:text-gray-200">
                                {{ number_format($material->unit_price, 2) }}
                            </td>

                            <td class="px-4 py-3 text-gray-800 dark:text-gray-200 font-semibold">
                                {{ number_format($material->total_amount, 2) }}
                            </td>

                            <td class="px-4 py-3 text-gray-800 dark:text-gray-200 break-words">
                                {{ $material->notes ?? '—' }}
                            </td>

                            <td class="px-4 py-3">

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-6 text-center text-gray-500 dark:text-gray-400">
                                No records found.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>

                    <tfoot class="bg-gray-200 dark:bg-gray-700">
                    <tr>
                        <td colspan="7" class="px-4 py-3">
                            <div class="flex justify-end">
                                {{ $exportRawMaterials->links() ?? '' }}
                            </div>
                        </td>
                    </tr>
                    </tfoot>
                </table>

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
@endsection
