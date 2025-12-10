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

                            <div class="flex justify-between items-center mb-6">
                                <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Production Inquiries for
                                    Quantity
                                    Checks</h1>
                            </div>

                            <!-- Stock / Stores Records Table -->
                            <div class="overflow-x-auto max-h-[1200px] bg-white dark:bg-gray-900 shadow rounded-lg">
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
                                    <thead class="bg-gray-200 dark:bg-gray-700 text-left">
                                        <tr class="text-center">
                                            <th
                                                class="font-bold sticky left-0 z-10 bg-white px-4 py-3 w-36 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                Order No
                                            </th>
                                            <th
                                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                Reference No
                                            </th>
                                            <th
                                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                Shade
                                            </th>
                                            <th
                                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                Cust Requested Qty
                                            </th>
                                            <th
                                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                Qty Available
                                            </th>
                                            <th
                                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                Qty Allocated
                                            </th>
                                            <th
                                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                Assigned By
                                            </th>
                                            <th
                                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-40 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                Is Assigned
                                            </th>
                                            <th
                                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                Reason for Reject
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                        @forelse ($stores as $store)
                                            <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200 text-center">
                                                <td
                                                    class="sticky left-0 z-10 bg-white px-4 py-3 bg-gray-100 border-r border-gray-300 text-left whitespace-normal break-words font-bold">
                                                    {{ $store->mail_booking_no ?? $store->prod_order_no }}</td>
                                                <td
                                                    class="px-4 py-3 w-48 whitespace-normal break-words border-r border-gray-300 ">
                                                    {{ $store->reference_no }}</td>
                                                <td
                                                    class="px-4 py-3 w-48 whitespace-normal break-words border-r border-gray-300">
                                                    {{ $store->shade }}</td>
                                                <td
                                                    class="px-4 py-3 w-48 whitespace-normal break-words border-r border-gray-300">
                                                    {{ $store->mailBooking->qty ?? $store->productInquiry->qty }}
                                                    {{ $store->mailBooking->uom ?? $store->productInquiry->uom }}
                                                <td
                                                    class="px-4 py-3 w-48 whitespace-normal break-words border-r border-gray-300">
                                                    {{ $store->stock->qty_available ?? 'N/A' }}</td>
                                                <td
                                                    class="px-4 py-3 w-48 whitespace-normal break-words border-r border-gray-300">
                                                    {{ $store->qty_allocated ?? '-' }} {{ $store->allocated_uom }}</td>
                                                <td
                                                    class="px-4 py-3 w-48 whitespace-normal break-words border-r border-gray-300">
                                                    {{ $store->assigned_by }}</td>
                                                <td
                                                    class="px-4 py-3 w-48 whitespace-normal break-words border-r border-gray-300 text-center">
                                                    @if ($store->is_qty_assigned)
                                                        {{-- Already assigned --}}
                                                        <span
                                                            class="inline-block m-1 text-sm font-semibold text-gray-700 dark:text-white bg-yellow-100 dark:bg-gray-800 px-3 py-1 rounded">
                                                            Assigned ({{ $store->qty_allocated }}
                                                            {{ $store->allocated_uom }})
                                                        </span>
                                                    @else
                                                        {{-- Alpine component --}}
                                                        <div x-data="{ open: false }" class="relative">
                                                            {{-- Trigger Button --}}
                                                            <button type="button"
                                                                class="px-3 py-1 text-xs rounded transition-all duration-200 bg-blue-100 text-blue-700 hover:bg-blue-200"
                                                                @click="open = true">
                                                                Assign
                                                            </button>

                                                            {{-- Modal --}}
                                                            <div x-show="open" x-transition
                                                                class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
                                                                style="display: none;">
                                                                <div
                                                                    class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-md relative max-h-[90vh] overflow-y-auto p-8">

                                                                    {{-- Close button --}}
                                                                    <button @click="open = false"
                                                                        class="absolute top-2 right-2 text-gray-600 hover:text-gray-900">
                                                                        ✕
                                                                    </button>

                                                                    {{-- Title --}}
                                                                    <h2
                                                                        class="text-lg font-semibold text-gray-800 dark:text-white mb-2 text-left">
                                                                        Assign Quantity
                                                                    </h2>

                                                                    <p
                                                                        class="mb-5 text-sm text-gray-600 dark:text-gray-300 text-left">
                                                                        Please provide the quantity allocated and reason for
                                                                        reject (if
                                                                        any).
                                                                    </p>

                                                                    {{-- Form --}}
                                                                    <form action="{{ route('stores.assign', $store->id) }}"
                                                                        method="POST">
                                                                        @csrf

                                                                        {{-- Quantity Allocated --}}
                                                                        <div class="mb-4">
                                                                            <label
                                                                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 text-left">
                                                                                Quantity Allocated
                                                                            </label>
                                                                            <input type="number" name="qty_allocated"
                                                                                required placeholder="Enter quantity"
                                                                                class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                                        </div>

                                                                        {{-- Allocated UOM --}}
                                                                        <div class="mb-4">
                                                                            <label
                                                                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 text-left">
                                                                                Allocated UOM
                                                                            </label>
                                                                            <select name="allocated_uom" required
                                                                                class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                                                <option value="yards">Yards</option>
                                                                                <option value="meters">Meters</option>
                                                                                <option value="pieces">Pieces</option>
                                                                            </select>
                                                                        </div>

                                                                        {{-- Reason for Reject --}}
                                                                        <div class="mb-4">
                                                                            <label
                                                                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 text-left">
                                                                                Reason for Reject
                                                                            </label>
                                                                            <input type="text" name="reason_for_reject"
                                                                                placeholder="Enter reason (optional)"
                                                                                class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                                        </div>

                                                                        {{-- Form Buttons --}}
                                                                        <div class="flex justify-end gap-3">
                                                                            <button type="button" @click="open = false"
                                                                                class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400 transition">
                                                                                Cancel
                                                                            </button>
                                                                            <button type="submit"
                                                                                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                                                                                Save
                                                                            </button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </td>

                                                <td
                                                    class="px-4 py-3 w-48 whitespace-normal break-words border-r border-gray-300">
                                                    {{ $store->reason_for_reject ?? '-' }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8"
                                                    class="px-6 py-4 text-center text-gray-500 dark:text-gray-300">No store
                                                    records found.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                {{ $stores->links() }}
                            </div>
                        </div>
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
    @endsection
