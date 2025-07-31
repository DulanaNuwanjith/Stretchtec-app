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
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Sample Stock Records</h1>
        </div>

        <div class="mb-8">
            <form method="GET" action="{{ route('sampleStock.index') }}" class="flex items-center space-x-2 max-w-md">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Search by Reference No, Shade or Note" autocomplete="off"
                    class="px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition duration-200 ease-in-out" />

                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm whitespace-nowrap">
                    Search
                </button>

                @if (request()->has('search'))
                    <a href="{{ route('sampleStock.index') }}"
                        class="px-4 py-2 bg-gray-400 text-white rounded hover:bg-gray-500 text-sm whitespace-nowrap select-none">
                        Clear
                    </a>
                @endif
            </form>
        </div>
        <div class="overflow-x-auto bg-white dark:bg-gray-900 shadow rounded-lg">
            <table class="table-fixed w-full text-sm divide-y divide-gray-200 dark:divide-gray-700 text-center">
                <thead class="bg-gray-100 dark:bg-gray-700">
                    <tr>
                        <th
                            class="px-4 py-3 w-48 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words border-r border-gray-300 dark:border-gray-600">
                            Reference No
                        </th>
                        <th
                            class="px-4 py-3 w-32 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words border-r border-gray-300 dark:border-gray-600">
                            Shade
                        </th>
                        <th
                            class="px-4 py-3 w-32 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words border-r border-gray-300 dark:border-gray-600">
                            Available Stock
                        </th>
                        <th
                            class="px-4 py-3 w-72 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words border-r border-gray-300 dark:border-gray-600">
                            Special Note
                        </th>
                        @php
                            $userRole = Auth::user()->role;
                        @endphp

                        @if (in_array($userRole, ['SUPERADMIN', 'MERCHANDISER', 'CUSTOMERCOORDINATOR']))
                            <th
                                class="px-4 py-3 w-48 text-xs text-center font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                Action
                            </th>
                        @endif

                    </tr>
                </thead>

                <tbody id="sampleInquiryRecords"
                    class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">

                    @foreach ($sampleStocks as $stock)
                        <tr id="row{{ $stock->id }}">
                            <td class="px-4 py-3 border-r border-gray-300 dark:border-gray-600">
                                <span class="hover:text-blue-600 hover:underline cursor-pointer"
                                    onclick="openModel('{{ $stock->reference_no }}')">
                                    {{ $stock->reference_no }}
                                </span>
                            </td>

                            <td class="px-4 py-3 border-r border-gray-300 dark:border-gray-600">
                                {{ $stock->shade }}
                            </td>

                            <td class="px-4 py-3 border-r border-gray-300 dark:border-gray-600">
                                {{ $stock->available_stock }}
                            </td>

                            <td class="px-4 py-3 border-r border-gray-300 dark:border-gray-600">
                                <div class="flex flex-col gap-3">
                                    {{-- Special Note Update --}}
                                    <form method="POST" action="{{ route('sampleStock.update', $stock->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <textarea name="special_note"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm resize-none"
                                            rows="2" placeholder="Enter special note...">{{ $stock->special_note }}</textarea>
                                        <button type="submit"
                                            class="mt-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-1 rounded text-sm w-full">
                                            Save
                                        </button>
                                    </form>
                                </div>
                            </td>

                            @php
                                $userRole = Auth::user()->role;
                            @endphp

                            @if (in_array($userRole, ['SUPERADMIN', 'MERCHANDISER', 'CUSTOMERCOORDINATOR']))
                                <td class="px-4 py-3 w-48 text-center whitespace-normal break-words">
                                    <div class="flex justify-center gap-2">
                                        {{-- Borrow Action --}}
                                        <form method="POST" action="{{ route('sampleStock.borrow', $stock->id) }}"
                                            class="flex items-center gap-2">
                                            @csrf
                                            <input type="number" name="borrow_qty"
                                                class="w-24 px-3 py-1 border border-gray-300 rounded text-sm"
                                                min="1" max="{{ $stock->available_stock }}" placeholder="Qty"
                                                required oninput="validateQty(this, {{ $stock->available_stock }})">
                                            <button type="submit"
                                                class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-1 rounded text-sm">
                                                Borrow
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            @endif
                        </tr>
                    @endforeach

                </tbody>

            </table>
        </div>


        <div class="px-4 py-4">
            {{ $sampleStocks->links() }}
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

    function validateQty(input, available) {
        if (parseInt(input.value) > available) {
            alert("Borrowing quantity exceeds available stock.");
            input.value = '';
        }
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
