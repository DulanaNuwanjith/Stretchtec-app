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
                            <div
                                class="mb-4 p-4 text-green-800 bg-green-100 border border-green-300 rounded-md dark:text-green-200 dark:bg-green-900 dark:border-green-800">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div
                                class="mb-4 p-4 text-red-800 bg-red-100 border border-red-300 rounded-md dark:text-red-200 dark:bg-red-900 dark:border-red-800">
                                {{ session('error') }}
                            </div>
                        @endif

                        {{-- Filters --}}
                        <div class="flex justify-start">
                            <button onclick="toggleFilterForm()"
                                class="bg-white border border-blue-500 text-blue-500 hover:text-blue-600 hover:border-blue-600 font-semibold py-1 px-3 rounded shadow flex items-center gap-2 mb-6">
                                <img src="{{ asset('icons/filter.png') }}" class="w-6 h-6" alt="Filter Icon">
                                Filters
                            </button>
                            <button onclick="toggleReportForm()"
                                class="bg-white border border-blue-500 text-blue-500 hover:text-blue-600 hover:border-blue-600 font-semibold py-1 px-3 rounded shadow flex items-center gap-2 mb-6 ml-2">
                                Generate Report
                            </button>
                        </div>

                        <div id="filterFormContainer" class="hidden mt-4">
                            <!-- Filter Form -->
                            <form id="filterForm1" method="GET" action="{{ route('sample-inquery-details.index') }}"
                                class="mb-6 sticky top-0 z-40 flex gap-6 items-center">
                                <div class="flex items-center gap-4 flex-wrap">


                                </div>
                            </form>
                        </div>

                        <div class="flex justify-between items-center mb-6">
                            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">
                                Production Order Preparation Records
                            </h1>
                        </div>

                        {{-- Data Table --}}
                        <div id="orderPreparationScroll"
                            class="overflow-x-auto max-h-[1200px] bg-white dark:bg-gray-900 shadow rounded-lg">
                            <!-- Spinner -->
                            <div id="pageLoadingSpinner"
                                class="fixed inset-0 z-50 bg-white bg-opacity-80 flex flex-col items-center justify-center">
                                <svg class="animate-spin h-10 w-10 text-blue-600" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z">
                                    </path>
                                </svg>
                                <p class="mt-3 text-gray-700 font-semibold">Loading data...</p>
                            </div>
                            <table class="table-fixed w-full text-sm divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-200 dark:bg-gray-700 text-center">
                                <tr class="text-center">
                                    <th class="font-bold sticky left-0 top-0 z-20 bg-white px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                        Order No
                                    </th>
                                    <th class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase">Customer</th>
                                    <th class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase">Reference No</th>
                                    <th class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase">Item</th>
                                    <th class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-24 text-xs text-gray-600 dark:text-gray-300 uppercase">Size</th>
                                    <th class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-24 text-xs text-gray-600 dark:text-gray-300 uppercase">Color</th>
                                    <th class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-24 text-xs text-gray-600 dark:text-gray-300 uppercase">Shade</th>
                                    <th class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-24 text-xs text-gray-600 dark:text-gray-300 uppercase">TKT</th>
                                    <th class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-24 text-xs text-gray-600 dark:text-gray-300 uppercase">Quantity</th>
                                    <th class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-28 text-xs text-gray-600 dark:text-gray-300 uppercase">UOM</th>
                                    <th class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase">Supplier</th>
                                    <th class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-28 text-xs text-gray-600 dark:text-gray-300 uppercase">PST No</th>
                                    <th class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-36 text-xs text-gray-600 dark:text-gray-300 uppercase">Supplier Comment</th>
                                    <th class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-28 text-xs text-gray-600 dark:text-gray-300 uppercase">Status</th>
                                    <th class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-40 text-xs text-gray-600 dark:text-gray-300 uppercase">Mark Raw Material Ordered</th>
                                    <th class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-40 text-xs text-gray-600 dark:text-gray-300 uppercase">Mark Raw Material Received</th>
                                    <th class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-36 text-xs text-gray-600 dark:text-gray-300 uppercase">Assign Order</th>
                                </tr>
                                </thead>

                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($orderPreparations as $order)
                                    <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200 text-center">
                                        <!-- Sticky first column -->
                                        <td class="px-4 py-3 font-bold sticky left-0 z-10 bg-gray-100 whitespace-normal break-words border-r border-gray-300 text-blue-500">
                                            {{ $order->prod_order_no ?? 'N/A' }}
                                        </td>
                                        <td class="px-4 py-3 border-r border-gray-300">{{ $order->customer_name ?? '-' }}</td>
                                        <td class="px-4 py-3 border-r border-gray-300">{{ $order->reference_no ?? '-' }}</td>
                                        <td class="px-4 py-3 border-r border-gray-300">{{ $order->item ?? '-' }}</td>
                                        <td class="px-4 py-3 border-r border-gray-300">{{ $order->size ?? '-' }}</td>
                                        <td class="px-4 py-3 border-r border-gray-300">{{ $order->color ?? '-' }}</td>
                                        <td class="px-4 py-3 border-r border-gray-300">{{ $order->shade ?? '-' }}</td>
                                        <td class="px-4 py-3 border-r border-gray-300">{{ $order->tkt ?? '-' }}</td>
                                        <td class="px-4 py-3 border-r border-gray-300">{{ $order->qty ?? 0 }}</td>
                                        <td class="px-4 py-3 border-r border-gray-300">{{ $order->uom ?? '-' }}</td>
                                        <td class="px-4 py-3 border-r border-gray-300">{{ $order->supplier ?? '-' }}</td>
                                        <td class="px-4 py-3 border-r border-gray-300">{{ $order->pst_no ?? '-' }}</td>
                                        <td class="px-4 py-3 border-r border-gray-300">{{ $order->supplier_comment ?? '-' }}</td>
                                        <td class="px-4 py-3 border-r border-gray-300">
                <span class="px-2 py-1 text-xs rounded-full
                    {{ $order->status === 'Completed'
                        ? 'bg-green-100 text-green-700'
                        : ($order->status === 'Pending'
                            ? 'bg-yellow-100 text-yellow-700'
                            : 'bg-gray-100 text-gray-600') }}">
                    {{ $order->status ?? 'Pending' }}
                </span>
                                        </td>

                                        <!-- Mark Raw Material Ordered -->
                                        <td class="px-4 py-3 border-r border-gray-300">
                                            <form action="#" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                        class="bg-blue-500 hover:bg-blue-600 text-white text-xs font-semibold py-2 px-3 rounded shadow transition">
                                                    {{ $order->raw_material_ordered ? 'Ordered ✅' : 'Mark Ordered' }}
                                                </button>
                                            </form>
                                        </td>

                                        <!-- Mark Raw Material Received -->
                                        <td class="px-4 py-3 border-r border-gray-300">
                                            <form action="#" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                        class="bg-green-500 hover:bg-green-600 text-white text-xs font-semibold py-2 px-3 rounded shadow transition">
                                                    {{ $order->raw_material_received ? 'Received 📦' : 'Mark Received' }}
                                                </button>
                                            </form>
                                        </td>

                                        <!-- Assign Order -->
                                        <td class="px-4 py-3 border-r border-gray-300">
                                            <button type="button"
                                                    onclick="openAssignModal({{ $order->id }})"
                                                    class="bg-purple-500 hover:bg-purple-600 text-white text-xs font-semibold py-2 px-3 rounded shadow transition">
                                                Assign Order
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="16" class="px-4 py-6 text-center text-gray-500 dark:text-gray-400">
                                            No records found.
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>


                        {{-- Pagination --}}
                        <div class="p-2 border-t border-gray-200 dark:border-gray-700">
                            {{ $orderPreparations->links() }}
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

        <script>
            function toggleFilterForm() {
                const form = document.getElementById('filterFormContainer');
                form.classList.toggle('hidden');
            }

            function toggleReportForm() {
                const form = document.getElementById('reportFormContainer');
                form.classList.toggle('hidden');
            }
        </script>
    @endsection
