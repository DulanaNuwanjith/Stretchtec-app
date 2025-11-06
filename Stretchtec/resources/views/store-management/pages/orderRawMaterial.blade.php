@php use Illuminate\Support\Facades\Auth; @endphp
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="flex h-full w-full">
    @extends('layouts.stores-tabs')

    @section('content')
        <div class="flex-1 overflow-y-auto p-8 bg-white">
            {{-- SweetAlert Styles --}}
            <style>
                .swal2-toast {
                    font-size: 0.875rem;
                    padding: 0.75rem 1rem;
                    border-radius: 8px;
                    background-color: #ffffff !important;
                    position: relative;
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

            {{-- SweetAlert Messages --}}
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
                            customClass: { popup: 'swal2-toast swal2-shadow' },
                        });
                    @endif
                    @if ($errors->any())
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'warning',
                            title: 'Validation Error',
                            html: `{!! implode('<br>', $errors->all()) !!}`,
                            showConfirmButton: false,
                            timer: 3000,
                            customClass: { popup: 'swal2-toast swal2-shadow' },
                        });
                    @endif
                });

                function confirmDelete(id) {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'This order will be permanently deleted!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3b82f6',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Yes, delete it!',
                        background: '#ffffff',
                        color: '#3b82f6',
                        customClass: { popup: 'swal2-toast swal2-shadow' }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById(`delete-form-${id}`).submit();
                        }
                    });
                }
            </script>

            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Ordered Raw Material Records</h1>
                <button onclick="document.getElementById('orderNewRawMaterial').classList.remove('hidden')"
                    class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded shadow">
                    + Order New Raw Material
                </button>
            </div>

            {{-- Orders Table --}}
            <div class="overflow-x-auto max-h-[1200px] bg-white shadow rounded-lg">
                <table class="min-w-full border-collapse">
                    <thead class="bg-gray-100">
                        <tr class="text-center">
                            <th class="font-bold sticky left-0 z-10 bg-white px-4 py-3 w-36 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">Order No</th>
                            <th class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">Color</th>
                            <th class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">Shade</th>
                            <th class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">PST No</th>
                            <th class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">TKT</th>
                            <th class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">Supplier Comment</th>
                            <th class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">Quantity</th>
                            <th class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">Measurement</th>
                            <th class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">Price</th>
                            <th class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">Description</th>
                            <th class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                        @forelse ($orders as $order)
                            <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200 text-center">
                                <td class="sticky left-0 z-10 bg-white px-4 py-3 text-sm bg-gray-100 border-r border-gray-300 text-left whitespace-normal break-words font-bold">{{ $order->order_no }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 border-r">{{ $order->color }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 border-r">{{ $order->shade }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 border-r">{{ $order->pst_no ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 border-r">{{ $order->tkt ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 border-r">{{ $order->supplier_comment ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 border-r">{{ $order->qty }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 border-r capitalize">{{ $order->kg_or_cone ?? 'kg' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 border-r">{{ $order->price ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 border-r">{{ $order->description ?? '-' }}</td>
                                <td class="px-4 py-3">
                                    <form id="delete-form-{{ $order->id }}" method="POST"
                                        action="{{ route('orderRawMaterial.destroy', $order->id) }}">
                                        @csrf @method('DELETE')
                                        <button type="button" onclick="confirmDelete({{ $order->id }})"
                                            class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 text-xs">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="py-6 text-center text-gray-500">No orders found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $orders->links() }}
            </div>

            {{-- Add Modal --}}
            <div id="orderNewRawMaterial"
                class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center py-5">
                <div class="w-full max-w-[700px] bg-white rounded-2xl shadow-2xl p-6"
                    onclick="event.stopPropagation()">
                    <h2 class="text-2xl font-semibold mb-6 text-blue-900 text-center">
                        Order New Raw Material
                    </h2>
                    <form action="{{ route('orderRawMaterial.store') }}" method="POST">
                        @csrf
                        <div class="space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium">Order No</label>
                                    <input name="order_no" type="text" required
                                        class="w-full mt-1 px-3 py-2 border rounded-md text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium">Color</label>
                                    <input name="color" type="text" required
                                        class="w-full mt-1 px-3 py-2 border rounded-md text-sm">
                                </div>
                            </div>

                            <div class="grid grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-medium">Shade</label>
                                    <input name="shade" type="text" required
                                        class="w-full mt-1 px-3 py-2 border rounded-md text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium">PST No</label>
                                    <input name="pst_no" type="text"
                                        class="w-full mt-1 px-3 py-2 border rounded-md text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium">TKT</label>
                                    <input name="tkt" type="text"
                                        class="w-full mt-1 px-3 py-2 border rounded-md text-sm">
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium">Supplier Comment</label>
                                    <input name="supplier_comment" type="text"
                                        class="w-full mt-1 px-3 py-2 border rounded-md text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium">Quantity</label>
                                    <input name="qty" type="number" required min="1"
                                        class="w-full mt-1 px-3 py-2 border rounded-md text-sm">
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium">Measurement Type</label>
                                    <select name="kg_or_cone"
                                        class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                        <option value="kg" selected>KG</option>
                                        <option value="cone">Cone</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium">Price</label>
                                    <input name="price" type="number" step="0.01"
                                        class="w-full mt-1 px-3 py-2 border rounded-md text-sm">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium">Description</label>
                                <textarea name="description" rows="2"
                                    class="w-full mt-1 px-3 py-2 border rounded-md text-sm"></textarea>
                            </div>
                        </div>

                        <div class="flex justify-end gap-3 mt-6">
                            <button type="button"
                                onclick="document.getElementById('orderNewRawMaterial').classList.add('hidden')"
                                class="px-4 py-2 bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-200 text-sm rounded hover:bg-gray-300">Cancel</button>
                            <button type="submit"
                                class="px-4 py-2 bg-blue-500 text-white text-sm rounded hover:bg-blue-600">Create Order</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endsection
