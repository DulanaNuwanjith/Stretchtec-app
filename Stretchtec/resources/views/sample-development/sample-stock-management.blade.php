<div class="flex h-full w-full font-sans">
    @include('layouts.side-bar')
    <div class="flex-1 overflow-y-auto p-8 bg-white">

        <a href="{{ route('sample-inquery-details.index') }}">
            <button class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded shadow mb-6">
                Back Sample Development
            </button>
        </a>

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Sample Stock Records</h1>
        </div>

        <div class="overflow-x-auto bg-white dark:bg-gray-900 shadow rounded-lg">
            <table class="table-fixed w-full text-sm divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-100 dark:bg-gray-700 text-left">
                    <tr>
                        <th
                            class="px-4 py-3 w-48 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                            Reference No</th>
                        <th
                            class="px-4 py-3 w-32 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                            Shade</th>
                        <th
                            class="px-4 py-3 w-32 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                            Available Stock</th>
                        <th
                            class="px-4 py-3 w-72 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                            Special Note</th>
                        <th
                            class="px-4 py-3 w-48 text-xs text-center font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                            Action Admin</th>
                    </tr>
                </thead>
                <tbody id="sampleInquiryRecords"
                       class="bg-white dark:bg-gray-800 divide-y text-left divide-gray-200 dark:divide-gray-700 ">

                @foreach ($sampleStocks as $stock)
                    <tr id="row{{ $stock->id }}">
                        <td class="px-4 py-3 w-48 whitespace-normal break-words">
                <span class="readonly hover:text-blue-600 hover:underline cursor-pointer"
                      onclick="openModel('{{ $stock->reference_no }}')">
                    {{ $stock->reference_no }}
                </span>
                            <input class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                   value="{{ $stock->reference_no }}" />
                        </td>

                        <td class="px-4 py-3 w-32 whitespace-normal break-words">
                            <span class="readonly">{{ $stock->shade }}</span>
                            <input class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                   value="{{ $stock->shade }}" />
                        </td>

                        <td class="px-4 py-3 w-32 whitespace-normal break-words">
                            <span class="readonly">{{ $stock->available_stock }}</span>
                            <input class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                   value="{{ $stock->available_stock }}" />
                        </td>

                        <td class="px-4 py-3 w-72 whitespace-normal break-words">
                            <span class="readonly">{{ $stock->special_note }}</span>
                            <input class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                   value="{{ $stock->special_note }}" />
                        </td>

                        <td class="px-4 py-3 w-48 text-center whitespace-normal break-words">
                            <div class="flex space-x-2 justify-center">
                                <button
                                    class="edit-btn bg-green-600 h-10 hover:bg-green-700 text-white px-3 py-1 rounded text-sm"
                                    onclick="editRow('row{{ $stock->id }}')">Edit</button>
                                <button
                                    class="save-btn bg-blue-600 h-10 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm hidden"
                                    onclick="saveRow('row{{ $stock->id }}')">Save</button>
                            </div>
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
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
