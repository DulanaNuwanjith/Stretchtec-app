<head>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<div class="flex h-full w-full">
    @extends('layouts.production-tabs')

    @section('content')
    <div class="flex-1 overflow-y-hidden mb-20">
        <div class="w-full px-6 lg:px-2">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 text-gray-900 dark:text-gray-100 mb-20">

                    {{-- Success & Error Messages --}}
                    @if (session('success'))
                        <div class="mb-4 p-4 text-green-800 bg-green-100 border border-green-300 rounded-md dark:text-green-200 dark:bg-green-900 dark:border-green-800">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mb-4 p-4 text-red-800 bg-red-100 border border-red-300 rounded-md dark:text-red-200 dark:bg-red-900 dark:border-red-800">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">
                            Production Order Preparation Records
                        </h1>
                    </div>

                    {{-- Data Table --}}
                    <div id="orderPreparationScroll" class="overflow-x-auto max-h-[1200px] bg-white dark:bg-gray-900 shadow rounded-lg">
                        <table class="table-fixed w-full text-sm divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-200 dark:bg-gray-700 text-left">
                                <tr class="text-center">
                                    <th class="px-4 py-3 w-24 text-xs font-bold text-gray-600 dark:text-gray-300 uppercase">Order No</th>
                                    <th class="px-4 py-3 w-28 text-xs font-bold text-gray-600 dark:text-gray-300 uppercase">Customer</th>
                                    <th class="px-4 py-3 w-28 text-xs font-bold text-gray-600 dark:text-gray-300 uppercase">Item</th>
                                    <th class="px-4 py-3 w-20 text-xs font-bold text-gray-600 dark:text-gray-300 uppercase">Size</th>
                                    <th class="px-4 py-3 w-20 text-xs font-bold text-gray-600 dark:text-gray-300 uppercase">Color</th>
                                    <th class="px-4 py-3 w-20 text-xs font-bold text-gray-600 dark:text-gray-300 uppercase">Shade</th>
                                    <th class="px-4 py-3 w-20 text-xs font-bold text-gray-600 dark:text-gray-300 uppercase">TKT</th>
                                    <th class="px-4 py-3 w-20 text-xs font-bold text-gray-600 dark:text-gray-300 uppercase">Quantity</th>
                                    <th class="px-4 py-3 w-24 text-xs font-bold text-gray-600 dark:text-gray-300 uppercase">UOM</th>
                                    <th class="px-4 py-3 w-28 text-xs font-bold text-gray-600 dark:text-gray-300 uppercase">Supplier</th>
                                    <th class="px-4 py-3 w-24 text-xs font-bold text-gray-600 dark:text-gray-300 uppercase">PST No</th>
                                    <th class="px-4 py-3 w-36 text-xs font-bold text-gray-600 dark:text-gray-300 uppercase">Supplier Comment</th>
                                    <th class="px-4 py-3 w-28 text-xs font-bold text-gray-600 dark:text-gray-300 uppercase">Status</th>
                                    <th class="px-4 py-3 w-28 text-xs font-bold text-gray-600 dark:text-gray-300 uppercase">Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($orderPreparations as $order)
                                    <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-900 border-b border-gray-200 text-center">
                                        <td class="px-4 py-3 font-semibold">{{ $order->prod_order_no ?? 'N/A' }}</td>
                                        <td class="px-4 py-3">{{ $order->customer_name ?? 'N/A' }}</td>
                                        <td class="px-4 py-3">{{ $order->item ?? 'N/A' }}</td>
                                        <td class="px-4 py-3">{{ $order->size ?? 'N/A' }}</td>
                                        <td class="px-4 py-3">{{ $order->color ?? 'N/A' }}</td>
                                        <td class="px-4 py-3">{{ $order->shade ?? 'N/A' }}</td>
                                        <td class="px-4 py-3">{{ $order->tkt ?? 'N/A' }}</td>
                                        <td class="px-4 py-3">{{ $order->qty ?? 0 }}</td>
                                        <td class="px-4 py-3">{{ $order->uom ?? '-' }}</td>
                                        <td class="px-4 py-3">{{ $order->supplier ?? 'N/A' }}</td>
                                        <td class="px-4 py-3">{{ $order->pst_no ?? 'N/A' }}</td>
                                        <td class="px-4 py-3 text-gray-500 italic">{{ $order->supplier_comment ?? '-' }}</td>
                                        <td class="px-4 py-3">
                                            <span class="px-2 py-1 text-xs rounded-full
                                                {{ $order->status === 'Completed' ? 'bg-green-100 text-green-700' : ($order->status === 'Pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-gray-100 text-gray-600') }}">
                                                {{ $order->status ?? 'Pending' }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <form method="POST" action="{{ route('production-order-preparation.destroy', $order->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    onclick="return confirm('Are you sure you want to delete this order preparation?')"
                                                    class="px-3 py-1 text-xs rounded-lg bg-red-600 text-white hover:bg-red-700">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="14" class="px-4 py-6 text-center text-gray-500 dark:text-gray-400">
                                            No records found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="p-4 border-t border-gray-200 dark:border-gray-700">
                        {{ $orderPreparations->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
    @endsection

