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
                        <th class="font-bold sticky left-0 z-10 bg-white px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase">PO Number</th>
                        <th class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase">PO Date</th>
                        <th class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-28 text-xs text-gray-600 dark:text-gray-300 uppercase">Shade</th>
                        <th class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-28 text-xs text-gray-600 dark:text-gray-300 uppercase">Color</th>
                        <th class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-24 text-xs text-gray-600 dark:text-gray-300 uppercase">TKT</th>
                        <th class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-28 text-xs text-gray-600 dark:text-gray-300 uppercase">PST No</th>
                        <th class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-40 text-xs text-gray-600 dark:text-gray-300 uppercase">Supplier Comment</th>
                        <th class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-20 text-xs text-gray-600 dark:text-gray-300 uppercase">UOM</th>
                        <th class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-28 text-xs text-gray-600 dark:text-gray-300 uppercase">Quantity</th>
                        <th class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-28 text-xs text-gray-600 dark:text-gray-300 uppercase">Rate</th>
                        <th class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase">Amount</th>
                        <th class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase">Total Amount</th>
                        <th class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-28 text-xs text-gray-600 dark:text-gray-300 uppercase">Status</th>
                    </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700 text-center">
                    @foreach ($purchaseDepartments as $purchase)
                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                            <td class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ $purchase->po_number }}</td>
                            <td class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ $purchase->po_date }}</td>
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
    @endsection
