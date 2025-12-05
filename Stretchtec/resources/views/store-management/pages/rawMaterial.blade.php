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
                <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Raw Material Records</h1>
                <div class="flex space-x-3">
                    <button onclick="document.getElementById('addRawMaterial').classList.remove('hidden')"
                        class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded shadow">
                        + Add New Raw Material
                    </button>
                </div>
            </div>

            <!-- Add New Raw Material Modal -->
            <div id="addRawMaterial"
                class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center py-5"
                onclick="this.classList.add('hidden')">
                <div class="w-full max-w-[700px] bg-white rounded-2xl shadow-2xl p-6" onclick="event.stopPropagation()">
                    <h2 class="text-2xl font-semibold mb-6 text-blue-900 text-center">
                        Add New Raw Material
                    </h2>

                    <form action="{{ route('rawMaterial.store') }}" method="POST">
                        @csrf

                        <div class="space-y-4">
                            <!-- Row 1 -->
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium">Date</label>
                                    <input name="date" type="date" required
                                        class="w-full mt-1 px-3 py-2 border rounded-md text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium">Supplier</label>
                                    <input name="supplier" type="text"
                                        class="w-full mt-1 px-3 py-2 border rounded-md text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium">Color</label>
                                    <input name="color" type="text" required
                                        class="w-full mt-1 px-3 py-2 border rounded-md text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium">Shade</label>
                                    <input name="shade" type="text" required
                                        class="w-full mt-1 px-3 py-2 border rounded-md text-sm">
                                </div>
                            </div>

                            <!-- Row 2 -->
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium">TKT</label>
                                    <input name="tkt" type="text"
                                        class="w-full mt-1 px-3 py-2 border rounded-md text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium">PST No</label>
                                    <input name="pst_no" type="text"
                                        class="w-full mt-1 px-3 py-2 border rounded-md text-sm">
                                </div>
                            </div>

                            <!-- Row 3 -->
                            <div class="grid grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-medium">Available Quantity</label>
                                    <input name="available_quantity" type="number" required min="1"
                                        class="w-full mt-1 px-3 py-2 border rounded-md text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium">Unit</label>
                                    <select name="unit"
                                        class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md text-sm dark:bg-gray-700 dark:text-white">
                                        <option value="kg">KG</option>
                                        <option value="cone">Cone</option>
                                        <option value="m">Meter</option>
                                        <option value="pcs">Pieces</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Row 4 -->
                            <div>
                                <label class="block text-sm font-medium">Remarks</label>
                                <textarea name="remarks" rows="2" class="w-full mt-1 px-3 py-2 border rounded-md text-sm"></textarea>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="flex justify-end gap-3 mt-6">
                            <button type="button"
                                onclick="document.getElementById('addRawMaterial').classList.add('hidden')"
                                class="px-4 py-2 bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-200 text-sm rounded hover:bg-gray-300">
                                Cancel
                            </button>
                            <button type="submit"
                                class="px-4 py-2 bg-blue-500 text-white text-sm rounded hover:bg-blue-600">
                                Save Raw Material
                            </button>
                        </div>
                    </form>
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
                                Shade
                            </th>
                            <th
                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                Date
                            </th>
                            <th
                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                Color
                            </th>
                            <th
                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                TKT
                            </th>
                            <th
                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                PST Number
                            </th>
                            <th
                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                Supplier
                            </th>
                            <th
                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                Quantity Available
                            </th>
                            <th
                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-40 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                        @foreach ($rawMaterials as $material)
                            <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200 text-center">
                                <td
                                    class="sticky left-0 z-10 bg-white px-4 py-3 text-sm bg-gray-100 border-r border-gray-300 text-left whitespace-normal break-words font-bold">
                                    {{ $material->shade }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 border-r">
                                    {{ $material->date }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 border-r">
                                    {{ $material->color }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 border-r">
                                    {{ $material->tkt }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 border-r">
                                    {{ $material->pst_no }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 border-r">
                                    {{ $material->supplier }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 border-r">
                                    {{ $material->available_quantity }} {{ $material->unit }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 border-r">
                                    <div class="flex gap-2 justify-center">
                                        <div x-data="{ open: false }">
                                            <!-- Button -->
                                            <button type="button" @click="open = true"
                                                class="bg-yellow-600 h-10 hover:bg-yellow-700 text-white px-3 py-1 rounded text-sm">
                                                Remarks
                                            </button>

                                            <!-- Modal -->
                                            <div x-show="open"
                                                class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
                                                x-cloak>

                                                <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full">
                                                    <h2 class="text-lg font-semibold mb-4">Remarks
                                                    </h2>
                                                    <p class="text-gray-700">
                                                        {{ $material->remarks }}
                                                    </p>

                                                    <div class="mt-6 flex justify-end">
                                                        <button @click="open = false"
                                                            class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded transition">
                                                            Close
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button
                                            class="bg-red-600 h-10 hover:bg-red-700 text-white px-3 py-1 rounded text-sm"
                                            onclick="confirmDelete({{ $material->id }})">
                                            Delete
                                        </button>
                                        <form id="delete-form-{{ $material->id }}"
                                            action="{{ route('rawMaterial.destroy', $material->id) }}" method="POST"
                                            class="hidden">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        <button type="button"
                                            onclick="openBorrowModal({{ $material->id }}, '{{ $material->shade }}')"
                                            class="bg-yellow-500 h-10 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">
                                            Borrow
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="py-6 flex justify-center">
                {{ $rawMaterials->links() }}
            </div>
        </div>

        <div id="borrowModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center">
            <div class="bg-white p-6 rounded-xl w-96 shadow-lg" onclick="event.stopPropagation()">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Borrow Raw Material</h2>

                <form id="borrowForm" method="POST">
                    @csrf
                    <input type="hidden" id="borrow_material_id" name="id">

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Quantity to Borrow</label>
                        <input type="number" id="borrow_qty" name="borrow_qty" min="1" required
                            class="w-full mt-1 px-3 py-2 border rounded" placeholder="Quantity">
                    </div>

                    <div class="flex justify-end gap-3 mt-6">
                        <button type="button" onclick="closeBorrowModal()" class="px-4 py-2 bg-gray-300 rounded">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                            Borrow
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <script>
            function openBorrowModal(id) {
                document.getElementById('borrow_material_id').value = id;
                document.getElementById('borrowForm').action = `/raw-material/borrow/${id}`;
                document.getElementById('borrow_qty').value = "";
                document.getElementById('borrowModal').classList.remove('hidden');
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
    @endsection
