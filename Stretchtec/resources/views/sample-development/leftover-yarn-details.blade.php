<div class="flex h-full w-full font-sans">
    @include('layouts.side-bar')
    <div class="flex-1 overflow-y-auto p-8 bg-white">

        @if(session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <a href="{{ route('sample-preparation-details.index') }}">
            <button class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded shadow mb-6">
                Back Sample Preparation R&D
            </button>
        </a>

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Sample Stock Records</h1>
        </div>

            <form method="GET" action="{{ route('leftoverYarn.index') }}" class="mb-4 flex items-center space-x-2">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search by Shade, PO Number or Supplier"
                    class="px-3 py-2 border rounded-md w-1/2 dark:bg-gray-700 dark:text-white"
                />

                <button
                    type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
                >
                    Search
                </button>

                @if(request()->has('search'))
                    <a
                        href="{{ route('leftoverYarn.index') }}"
                        class="px-4 py-2 bg-gray-400 text-white rounded hover:bg-gray-500"
                    >
                        Clear
                    </a>
                @endif
            </form>

            <div class="overflow-x-auto bg-white dark:bg-gray-900 shadow rounded-lg">
                <table class="table-fixed w-full text-sm divide-y divide-gray-200 dark:divide-gray-700 text-center"> <!-- text-center added -->
                    <thead class="bg-gray-100 dark:bg-gray-700">
                    <tr>
                        <th class="px-4 py-3 w-32 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase border-r border-gray-300 dark:border-gray-600">Shade</th>
                        <th class="px-4 py-3 w-32 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase border-r border-gray-300 dark:border-gray-600">Yarn Ordered PO Number</th>
                        <th class="px-4 py-3 w-32 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase border-r border-gray-300 dark:border-gray-600">Yarn Received Date</th>
                        <th class="px-4 py-3 w-32 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase border-r border-gray-300 dark:border-gray-600">Tkt</th>
                        <th class="px-4 py-3 w-32 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase border-r border-gray-300 dark:border-gray-600">Yarn Supplier</th>
                        <th class="px-4 py-3 w-32 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase border-r border-gray-300 dark:border-gray-600">Available Stock</th>
                        <th class="px-4 py-3 w-48 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Action Admin</th>
                    </tr>
                    </thead>

                    <tbody id="sampleInquiryRecords" class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach ($leftoverYarns as $record)
                        <tr id="row{{ $record->id }}">
                            <td class="px-4 py-3 border-r border-gray-300 dark:border-gray-600">
                                <span class="readonly">{{ $record->shade }}</span>
                                <input class="hidden editable w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm text-center" value="{{ $record->shade }}" />
                            </td>
                            <td class="px-4 py-3 border-r border-gray-300 dark:border-gray-600">
                                <span class="readonly">{{ $record->po_number }}</span>
                                <input class="hidden editable w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm text-center" value="{{ $record->po_number }}" />
                            </td>
                            <td class="px-4 py-3 border-r border-gray-300 dark:border-gray-600">
                                <span class="readonly">{{ \Carbon\Carbon::parse($record->yarn_received_date)->format('Y-m-d') }}</span>
                                <input type="date" class="hidden editable w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm text-center" value="{{ $record->yarn_received_date }}" />
                            </td>
                            <td class="px-4 py-3 border-r border-gray-300 dark:border-gray-600">
                                <span class="readonly">{{ $record->tkt }}</span>
                                <input class="hidden editable w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm text-center" value="{{ $record->tkt }}" />
                            </td>
                            <td class="px-4 py-3 border-r border-gray-300 dark:border-gray-600">
                                <span class="readonly">{{ $record->yarn_supplier }}</span>
                                <input class="hidden editable w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm text-center" value="{{ $record->yarn_supplier }}" />
                            </td>
                            <td class="px-4 py-3 border-r border-gray-300 dark:border-gray-600">
                                <span class="readonly">{{ $record->available_stock }} g</span>
                                <input class="hidden editable w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm text-center" value="{{ $record->available_stock }}" />
                            </td>

                            <td class="px-4 py-3">
                                <div class="flex flex-col items-center space-y-2">
                                    <!-- Borrow Form -->
                                    <form action="{{ route('leftover-yarn.borrow', $record->id) }}" method="POST" class="flex flex-col items-center space-y-2">
                                        @csrf
                                        <input type="number" name="borrow_qty"
                                               class="w-24 px-2 py-1 border rounded text-sm dark:bg-gray-700 dark:text-white text-center"
                                               placeholder="Qty" min="1" required>
                                        <button type="submit"
                                                class="bg-yellow-600 hover:bg-yellow-700 text-white px-3 py-1 rounded text-sm">
                                            Borrow
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $leftoverYarns->links() }}
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
