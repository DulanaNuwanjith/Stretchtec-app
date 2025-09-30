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

            <!-- Stock / Stores Records Table -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
                <table class="min-w-full border-collapse">
                    <thead class="bg-gray-100 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">
                            #
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">
                            Order No
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">
                            Reference No
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">
                            Shade
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">
                            Qty Available
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">
                            Qty Allocated
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">
                            Qty for Production
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">
                            Assigned By
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">
                            Is Assigned
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">
                            Reason for Reject
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">
                            Actions
                        </th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                    @forelse ($stores as $store)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200">{{ $store->id }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200">{{ $store->prod_order_no }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200">{{ $store->reference_no }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200">{{ $store->shade }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200">{{ $store->qty_available }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200">{{ $store->qty_allocated ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200">{{ $store->qty_for_production ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200">{{ $store->assigned_by }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200">
                                @if($store->is_qty_assigned)
                                    <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded">Yes</span>
                                @else
                                    <span class="px-2 py-1 text-xs bg-red-100 text-red-800 rounded">No</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200">{{ $store->reason_for_reject ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-right">
                                <div class="flex justify-end space-x-2">
                                    <form id="delete-form-{{ $store->id }}"
                                          {{--                                          action="{{ route('stores.destroy', $store->id) }}" method="POST"--}}
                                          class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="confirmDelete({{ $store->id }})"
                                                class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 text-xs">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="px-6 py-4 text-center text-gray-500 dark:text-gray-300">No store
                                records found.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                {{ $stores->links() }}
            </div>

@endsection
