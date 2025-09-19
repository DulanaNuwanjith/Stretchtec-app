@php use Illuminate\Support\Facades\Auth; @endphp
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<div class="flex h-full w-full font-sans">
    @include('layouts.side-bar')
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
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Stock Records</h1>
            <div class="flex space-x-3">
                @if (Auth::user()->role !== 'ADMIN')
                    <a>
                        <button onclick="document.getElementById('addItemSampleStock').classList.remove('hidden')"
                            class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded shadow">
                            + Add New Item
                        </button>
                    </a>
                @endif
            </div>
        </div>

        <!-- Add Sample Modal -->
        <div id="addItemSampleStock"
            class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center py-5">
            <div class="w-full max-w-[700px] bg-white dark:bg-gray-900 rounded-2xl shadow-2xl p-4 transform transition-all scale-95 max-h-[calc(100vh-10rem)] overflow-y-auto"
                onclick="event.stopPropagation()">
                <div class="max-w-[600px] mx-auto p-8">
                    <h2 class="text-2xl font-semibold mb-8 text-blue-900 mt-4 dark:text-gray-100 text-center">
                        Add New Cord Catalog Item
                    </h2>
                    <form action="{{ route('sampleStock.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="space-y-4">
                            <div class="flex gap-4">
                                <div class="w-1/2">
                                    <label for="reference_no"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Reference
                                        No</label>
                                    <input id="reference_no" type="text" name="reference_no" required
                                        class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                </div>
                                <div class="w-1/2">
                                </div>
                            </div>

                            <div class="flex gap-4">
                                <div class="w-1/2">
                                    <label for="shade"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Shade</label>
                                    <input id="shade" type="text" name="shade" required
                                        class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                </div>
                                <div class="w-1/2">
                                    <label for="available_stock"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Available
                                        Stock</label>
                                    <input id="available_stock" type="number" name="available_stock" required
                                        class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                </div>
                            </div>

                            <div class="flex gap-4">
                                <div class="w-full">
                                    <label for="special_note"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Special
                                        note</label>
                                    <input id="special_note" type="text" name="special_note"
                                        class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                </div>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="flex justify-end gap-3 mt-12">
                            <button type="button"
                                onclick="document.getElementById('addItemSampleStock').classList.add('hidden')"
                                class="px-4 py-2 bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-200 text-sm rounded hover:bg-gray-300">
                                Cancel
                            </button>
                            <button type="submit"
                                class="px-4 py-2 bg-blue-500 text-white text-sm rounded hover:bg-blue-600">
                                Create Stock Item
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

</div>

