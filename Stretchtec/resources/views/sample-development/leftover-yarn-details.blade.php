<div class="flex h-full w-full font-sans">
    @include('layouts.side-bar')
    <div class="flex-1 overflow-y-auto p-8 bg-white">

        <a href="{{ route('sample-preparation-details.index') }}">
            <button class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded shadow mb-6">
                Back Sample Preparation R&D
            </button>
        </a>

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Sample Stock Records</h1>
        </div>

        <div class="overflow-x-auto bg-white dark:bg-gray-900 shadow rounded-lg">
            <table class="table-fixed w-full text-sm divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-100 dark:bg-gray-700 text-center">
                    <tr>
                        <th
                            class="px-4 py-3 w-32 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                            Shade</th>
                        <th
                            class="px-4 py-3 w-32 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                            Yarn Ordered PO Number</th>
                        <th
                            class="px-4 py-3 w-32 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                            Yarn Received Date</th>
                        <th
                            class="px-4 py-3 w-32 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                            Tkt</th>
                        <th
                            class="px-4 py-3 w-32 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                            Yarn Supplier</th>
                        <th
                            class="px-4 py-3 w-32 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                            Available Stock</th>
                        <th
                            class="px-4 py-3 w-48 text-xs text-center font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                            Action Admin</th>
                    </tr>
                </thead>
                <tbody id="sampleInquiryRecords"
                    class="bg-white dark:bg-gray-800 divide-y text-left divide-gray-200 dark:divide-gray-700 ">
                    <tr id="row1">
                        <td class="px-4 py-3 whitespace-normal break-words">
                            <span class="readonly">Black</span>
                            <input
                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm5"
                                value="Black" />
                        </td>
                        <td class="px-4 py-3 whitespace-normal break-words">
                            <span class="readonly">PO 001</span>
                            <input
                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm5"
                                value="PO 001" />
                        </td>
                        <td class="px-4 py-3 whitespace-normal break-words">
                            <span class="readonly">2025-05-04</span>
                            <input
                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                value="2025-05-04" />
                        </td>
                        <td class="px-4 py-3 whitespace-normal break-words">
                            <span class="readonly">1234</span>
                            <input
                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                value="1234" />
                        </td>
                        <td class="px-4 py-3 whitespace-normal break-words">
                            <span class="readonly">Pan Asia</span>
                            <input
                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                value="1234" />
                        </td>
                        <td class="px-4 py-3 whitespace-normal break-words">
                            <span class="readonly">50 g</span>
                            <input
                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                value="50 g" />
                        </td>
                        <td class="px-4 py-3 text-center whitespace-normal break-words">
                            <div class="flex space-x-2 justify-center">
                                <button
                                    class="edit-btn bg-green-600 h-10 hover:bg-green-700 text-white px-3 py-1 rounded text-sm"
                                    onclick="editRow('row1')">Edit</button>
                                <button
                                    class="save-btn bg-blue-600 h-10 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm hidden"
                                    onclick="saveRow('row1')">Save</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- Add Sample Modal -->
        <div id="balanceSampleStockModel"
            class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center py-5">
            <div class="w-full max-w-[700px] bg-white dark:bg-gray-900 rounded-2xl shadow-2xl p-4 transform transition-all scale-95 max-h-[calc(100vh-10rem)] overflow-y-auto"
                onclick="event.stopPropagation()">
                <div class="max-w-[600px] mx-auto p-8">
                    <h2 class="text-2xl font-semibold mb-8 text-blue-900 mt-4 dark:text-gray-100 text-center">
                        Dispatched Quantity <br>STKE/2025/JA25-B
                    </h2>
                    <form action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="space-y-4">

                            <!-- Dispatched Quantity -->
                            <div>
                                <input id="sampleQuantity" type="text" name="sample_quantity" required
                                    class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm mb-4">
                            </div>

                        <!-- Buttons -->
                        <div class="flex justify-end gap-3 mt-12">
                            <button type="button"
                                onclick="document.getElementById('balanceSampleStockModel').classList.add('hidden')"
                                class="px-4 py-2 bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-200 text-sm rounded hover:bg-gray-300">
                                Cancel
                            </button>
                            <button type="submit"
                                class="px-4 py-2 bg-blue-500 text-white text-sm rounded hover:bg-blue-600">
                                Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    function editRow(rowId) {
        const row = document.getElementById(rowId);

        // Show editable inputs, hide readonly spans
        row.querySelectorAll('.readonly').forEach(span => span.classList.add('hidden'));
        row.querySelectorAll('.editable').forEach(input => input.classList.remove('hidden'));

        // Hide the Edit button and show the Save button
        const editBtn = row.querySelector('button.edit-btn');
        const saveBtn = row.querySelector('button.save-btn');
        if (editBtn) editBtn.classList.add('hidden');
        if (saveBtn) saveBtn.classList.remove('hidden');
    }


    function saveRow(rowId) {
        const row = document.getElementById(rowId);

        // Hide inputs, show spans again
        row.querySelectorAll('.editable').forEach(input => input.classList.add('hidden'));
        row.querySelectorAll('.readonly').forEach(span => span.classList.remove('hidden'));

        // Show Edit, hide Save
        const editBtn = row.querySelector('button.edit-btn');
        const saveBtn = row.querySelector('button.save-btn');
        if (editBtn) editBtn.classList.remove('hidden');
        if (saveBtn) saveBtn.classList.add('hidden');
    }
</script>
