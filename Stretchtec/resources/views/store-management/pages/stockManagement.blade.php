@php use Illuminate\Support\Facades\Auth; @endphp
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

            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Stock Records</h1>
                <span class="text-xs text-gray-500">Increment Stock only in Yards or Pieces</span>
                <div class="flex space-x-3">
                    @if (Auth::user()->role !== 'ADMIN')
                        <button onclick="document.getElementById('addItemSampleStock').classList.remove('hidden')"
                            class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded shadow">
                            + Add New Item
                        </button>
                    @endif
                </div>
            </div>

            <!-- Stock Records Table -->
            <div class="overflow-x-auto bg-white dark:bg-gray-900 shadow rounded-lg">
                <table class="min-w-full border-collapse">
                    <thead class="bg-gray-100 dark:bg-gray-700">
                        <tr class="text-center">
                            <th
                                class="font-bold sticky left-0 z-10 bg-white px-4 py-3 w-36 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                Reference No
                            </th>
                            <th
                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                Shade
                            </th>
                            <th
                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                Available Stock
                            </th>
                            <th
                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-56 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                Special Note
                            </th>
                            <th
                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                        @forelse ($stock as $item)
                            <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200 text-center">
                                <td
                                    class="sticky left-0 z-10 bg-white px-4 py-3 text-sm bg-gray-100 border-r border-gray-300 text-left whitespace-normal break-words font-bold">
                                    {{ $item->reference_no }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 border-r">{{ $item->shade }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 border-r">
                                    {{ $item->qty_available }} {{ $item->uom === 'pcs' ? 'pcs' : 'y' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 border-r">
                                    {{ $item->notes ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm text-right">
                                    <div class="flex gap-2 justify-center">
                                        <!-- Add Stock Button -->
                                        <button type="button"
                                            onclick="openAddStockModal({{ $item->id }}, '{{ $item->reference_no }}')"
                                            class="bg-green-500 h-10 hover:bg-green-600 text-white px-3 py-1 rounded text-sm">
                                            Add Stock
                                        </button>

                                        <!-- Borrow Button -->
                                        <button type="button"
                                            onclick="openBorrowModal({{ $item->id }}, '{{ $item->reference_no }}')"
                                            class="bg-yellow-500 h-10 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">
                                            Borrow
                                        </button>

                                        <!-- Delete Button -->
                                        <form id="delete-form-{{ $item->id }}"
                                            action="{{ route('stockManagement.destroy', $item->id) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="confirmDelete({{ $item->id }})"
                                                class="bg-red-600 h-10 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500 dark:text-gray-300">No stock
                                    records found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="py-6 flex justify-center">
                {{ $stock->links() }}
            </div>

            <!-- Add Sample Modal -->
            <div id="addItemSampleStock"
                class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center py-5">
                <div class="w-full max-w-[700px] bg-white dark:bg-gray-900 rounded-2xl shadow-2xl p-4 transform transition-all scale-95 max-h-[calc(100vh-10rem)] overflow-y-auto"
                    onclick="event.stopPropagation()">
                    <div class="max-w-[600px] mx-auto p-8">
                        <h2 class="text-2xl font-semibold mb-8 text-blue-900 mt-4 dark:text-gray-100 text-center">
                            Add New Stock Item
                        </h2>
                        <form action="{{ route('stockManagement.store') }}" method="POST" enctype="multipart/form-data">
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
                                    <div class="w-1/3">
                                        <label for="shade"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Shade</label>
                                        <input id="shade" type="text" name="shade" required
                                            class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                    </div>
                                    <div class="w-1/3">
                                        <label for="available_stock"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Available
                                            Stock</label>
                                        <input id="available_stock" type="number" name="available_stock" required
                                            class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                    </div>
                                    <div class="w-1/3">
                                        <label for="uom"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Unit
                                            of Measure</label>
                                        <select id="uom" name="uom"
                                            class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                            <option value="m">Meters</option>
                                            <option value="y">Yards</option>
                                            <option value="pcs">Pieces</option>
                                        </select>
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
                                <button type="submit" id="createStockItemBtn"
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

    {{-- Add Stock Modal --}}
    <div id="addStockModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center"
        onclick="closeAddStockModal()">
        <div class="bg-white p-6 rounded-xl w-96 shadow-xl" onclick="event.stopPropagation()">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Add Stock</h2>
            <form id="addStockForm" method="POST">
                @csrf
                <input type="hidden" id="add_stock_id" name="id">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Enter Quantity</label>
                    <input type="number" id="add_qty" name="stock_increment" min="1" required
                        class="w-full mt-1 px-3 py-2 border rounded" placeholder="Quantity">
                </div>
                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="closeAddStockModal()"
                        class="px-4 py-2 bg-gray-300 rounded">Cancel</button>
                    <button type="submit"
                        class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">Add</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Borrow Modal --}}
    <div id="borrowModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white p-6 rounded-xl w-96 shadow-xl" onclick="event.stopPropagation()">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Borrow Stock</h2>
            <form id="borrowForm" method="POST">
                @csrf
                <input type="hidden" id="borrow_stock_id" name="id">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Enter Quantity</label>
                    <input type="number" id="borrow_qty" name="borrow_qty" min="1" required
                        class="w-full mt-1 px-3 py-2 border rounded">
                </div>
                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="closeBorrowModal()"
                        class="px-4 py-2 bg-gray-300 rounded">Cancel</button>
                    <button type="submit"
                        class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">Borrow</button>
                </div>
            </form>
        </div>
    </div>

    {{-- JS Functions --}}
    <script>
        function openAddStockModal(id) {
            document.getElementById('addStockModal').classList.remove('hidden');
            document.getElementById('add_stock_id').value = id;
            document.getElementById('addStockForm').action = `/stock/add/${id}`;
        }

        function closeAddStockModal() {
            document.getElementById('addStockModal').classList.add('hidden');
            document.getElementById('add_qty').value = '';
        }

        function openBorrowModal(id) {
            document.getElementById('borrowModal').classList.remove('hidden');
            document.getElementById('borrow_stock_id').value = id;
            document.getElementById('borrowForm').action = `/stock/borrow/${id}`;
        }

        function closeBorrowModal() {
            document.getElementById('borrowModal').classList.add('hidden');
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.querySelector('#addItemSampleStock form');
            const submitBtn = document.getElementById('createStockItemBtn');

            form.addEventListener('submit', function() {
                // Disable the button to prevent multiple clicks
                submitBtn.disabled = true;
                submitBtn.innerText = 'Submitting...';
            });
        });
    </script>
@endsection
