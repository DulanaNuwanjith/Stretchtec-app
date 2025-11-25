@php use Carbon\Carbon; @endphp

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<div class="flex h-full w-full">
    @extends('layouts.purchasing-tabs')

    @section('content')

        {{-- SUCCESS & ERROR MESSAGES --}}
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
                {{ session('error') }}
            </div>
        @endif

        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="mb-4 p-3 bg-yellow-100 text-yellow-800 rounded">
                <strong>Validation Errors:</strong><br>
                {!! implode('<br>', $errors->all()) !!}
            </div>
        @endif

        <div class="p-6">

            {{-- ===================== PAGE HEADER ===================== --}}
            <div class="flex items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">
                    Export Procurement Records
                </h1>

                <div class="ml-auto flex space-x-3">
                    <button onclick="document.getElementById('addExportProcModal').classList.remove('hidden')"
                            class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded shadow">
                        + Add Export Procurement
                    </button>
                </div>
            </div>

            {{-- ===================== TABLE CONTAINER ===================== --}}
            <div class="overflow-x-auto border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm">
                <table class="min-w-full border-collapse">
                    <thead class="bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300">
                    <tr class="text-center">

                        <th class="sticky top-0 px-4 py-3 w-32 text-xs font-bold uppercase">
                            Date
                        </th>

                        <th class="sticky top-0 px-4 py-3 w-32 text-xs font-bold uppercase">
                            Invoice No
                        </th>

                        <th class="sticky top-0 px-4 py-3 w-40 text-xs font-bold uppercase">
                            Supplier
                        </th>

                        <th class="sticky top-0 px-4 py-3 w-64 text-xs font-bold uppercase">
                            Product Description
                        </th>

                        <th class="sticky top-0 px-4 py-3 w-28 text-xs font-bold uppercase">
                            Net Weight
                        </th>

                        <th class="sticky top-0 px-4 py-3 w-28 text-xs font-bold uppercase">
                            Unit Price
                        </th>

                        <th class="sticky top-0 px-4 py-3 w-32 text-xs font-bold uppercase">
                            Total Amount
                        </th>

                        <th class="sticky top-0 px-4 py-3 w-32 text-xs font-bold uppercase">
                            Checked By
                        </th>

                        <th class="sticky top-0 px-4 py-3 w-28 text-xs font-bold uppercase">
                            Actions
                        </th>

                    </tr>
                    </thead>

                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($exportProcurements as $exp)
                        <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200 text-center">

                            <td class="px-4 py-3">{{ $exp->date }}</td>
                            <td class="px-4 py-3">{{ $exp->invoice_number }}</td>
                            <td class="px-4 py-3">{{ $exp->supplier }}</td>
                            <td class="px-4 py-3 whitespace-normal break-words">
                                {{ $exp->product_description }}
                            </td>
                            <td class="px-4 py-3">{{ $exp->net_weight }}</td>
                            <td class="px-4 py-3">{{ number_format($exp->unit_price, 2) }}</td>
                            <td class="px-4 py-3">{{ number_format($exp->total_amount, 2) }}</td>
                            <td class="px-4 py-3">{{ $exp->checked_by }}</td>

                            <td class="px-4 py-3">
                                <button onclick="openEditModal('{{ $exp->id }}')" class="text-blue-600 hover:underline">
                                    Edit
                                </button>

                                <button onclick="confirmDelete('{{ $exp->id }}')"
                                        class="text-red-600 hover:underline ml-3">
                                    Delete
                                </button>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-4 py-4 text-gray-500 text-center">
                                No export procurement records found.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            {{-- ===================== PAGINATION ===================== --}}
            <div class="p-3 border-t border-gray-200 dark:border-gray-700">
                {{ $exportProcurements->links() }}
            </div>

        </div>

        {{-- ===================== DELETE CONFIRMATION ===================== --}}
        <script>
            function confirmDelete(id) {
                if (confirm("Are you sure you want to delete this record?")) {
                    document.getElementById(`delete-form-${id}`).submit();
                }
            }
        </script>
</div>


<!-- ================= ADD EXPORT PROCUREMENT MODAL ================== -->
<div id="addExportProcModal"
     class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center py-5"
     onclick="this.classList.add('hidden')">

    <div class="w-full max-w-[750px] bg-white dark:bg-gray-900 rounded-2xl shadow-2xl p-6
                transform transition-all scale-95 max-h-[calc(100vh-10rem)] overflow-y-auto"
         onclick="event.stopPropagation()">

        <!-- Modal Header -->
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100">Add Export Procurement</h2>
            <button onclick="document.getElementById('addExportProcModal').classList.add('hidden')"
                    class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 text-xl">
                ✖
            </button>
        </div>

        <!-- FORM -->
        <form action="{{ route('exportinvoiceManage.store') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Date + Invoice -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="font-medium text-sm">Date</label>
                    <input type="date" name="date" required
                           class="w-full p-2 rounded-lg border bg-white dark:bg-gray-800
                                  dark:text-white border-gray-300 dark:border-gray-700">
                </div>

                <div>
                    <label class="font-medium text-sm">Invoice Number</label>
                    <input type="text" name="invoice_number" required
                           class="w-full p-2 rounded-lg border bg-white dark:bg-gray-800
                                  dark:text-white border-gray-300 dark:border-gray-700">
                </div>
            </div>

            <!-- Supplier -->
            <div>
                <label class="font-medium text-sm">Supplier</label>
                <input type="text" name="supplier" required
                       class="w-full p-2 rounded-lg border bg-white dark:bg-gray-800
                              dark:text-white border-gray-300 dark:border-gray-700">
            </div>

            <!-- Product Description -->
            <div>
                <label class="font-medium text-sm">Product Description</label>
                <textarea name="product_description" rows="3" required
                          class="w-full p-2 rounded-lg border bg-white dark:bg-gray-800
                                 dark:text-white border-gray-300 dark:border-gray-700"></textarea>
            </div>

            <!-- Weight + Price -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="font-medium text-sm">Net Weight</label>
                    <input type="number" step="0.01" name="net_weight" required
                           class="w-full p-2 rounded-lg border bg-white dark:bg-gray-800
                                  dark:text-white border-gray-300 dark:border-gray-700">
                </div>

                <div>
                    <label class="font-medium text-sm">Unit Price</label>
                    <input type="number" step="0.01" name="unit_price" required
                           class="w-full p-2 rounded-lg border bg-white dark:bg-gray-800
                                  dark:text-white border-gray-300 dark:border-gray-700">
                </div>

                <div>
                    <label class="font-medium text-sm">Total Amount</label>
                    <input type="number" step="0.01" name="total_amount" required
                           class="w-full p-2 rounded-lg border bg-white dark:bg-gray-800
                                  dark:text-white border-gray-300 dark:border-gray-700">
                </div>
            </div>

            <!-- Total Weight + Invoice Value -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="font-medium text-sm">Total Weight</label>
                    <input type="number" step="0.01" name="total_weight"
                           class="w-full p-2 rounded-lg border bg-white dark:bg-gray-800
                                  dark:text-white border-gray-300 dark:border-gray-700">
                </div>

                <div>
                    <label class="font-medium text-sm">Invoice Value</label>
                    <input type="number" step="0.01" name="invoice_value"
                           class="w-full p-2 rounded-lg border bg-white dark:bg-gray-800
                                  dark:text-white border-gray-300 dark:border-gray-700">
                </div>
            </div>

            <!-- Checked By -->
            <div>
                <label class="font-medium text-sm">Checked By</label>
                <input type="text" name="checked_by"
                       class="w-full p-2 rounded-lg border bg-white dark:bg-gray-800
                              dark:text-white border-gray-300 dark:border-gray-700">
            </div>

            <!-- Notes -->
            <div>
                <label class="font-medium text-sm">Notes</label>
                <textarea name="notes" rows="3"
                          class="w-full p-2 rounded-lg border bg-white dark:bg-gray-800
                                 dark:text-white border-gray-300 dark:border-gray-700"></textarea>
            </div>

            <!-- Submit -->
            <div class="flex justify-end pt-4">
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg shadow">
                    Save Export Procurement
                </button>
            </div>

        </form>
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
