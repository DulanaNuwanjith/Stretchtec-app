<head>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<div class="flex h-full w-full bg-white">

    @extends('layouts.sample-tabs')

    @section('content')
        <div class="flex-1 overflow-y-hidden mb-20">
            <div class="">
                <div class="w-full px-6 lg:px-2">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden">
                        <div class="p-4 text-gray-900 dark:text-gray-100">

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

                            <div class="flex justify-start">
                                <button onclick="toggleFilterForm()"
                                    class="bg-white border border-blue-500 text-blue-500 hover:text-blue-600 hover:border-blue-600 font-semibold py-1 px-3 rounded shadow flex items-center gap-2 mb-6">
                                    <img src="{{ asset('icons/filter.png') }}" alt="" class="w-6 h-6"
                                        alt="Filter Icon">
                                    Filters
                                </button>
                            </div>

                            <div id="filterFormContainer" class="hidden mt-4">
                                <!-- Filter Form -->
                                <form id="filterForm3" method="GET" action="" class="mb-6 flex gap-6 items-center">
                                    <div class="mb-6 sticky top-0 z-20 flex gap-6 items-center">
                                        <!-- Sample No Dropdown -->
                                        <div class="relative inline-block text-left w-48">
                                            <label for="sampleDropdown"
                                                class="block text-sm font-medium text-gray-700 mb-1">Sample No</label>

                                            <button type="button" id="sampleDropdown"
                                                class="inline-flex w-full justify-between rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-gray-300 hover:bg-gray-50"
                                                onclick="toggleSampleDropdown()" aria-haspopup="listbox"
                                                aria-expanded="false">
                                                <span id="selectedSample">Select Sample No</span>
                                                <svg class="ml-2 h-5 w-5 text-gray-400" viewBox="0 0 20 20"
                                                    fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 10.94l3.71-3.71a.75.75 0 1 1 1.06 1.06l-4.24 4.24a.75.75 0 0 1-1.06 0L5.25 8.29a.75.75 0 0 1-.02-1.08z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </button>

                                            <div id="sampleDropdownMenu"
                                                class="hidden absolute z-10 mt-2 w-full rounded-md bg-white shadow-lg ring-1 ring-black/5 max-h-48 overflow-y-auto">

                                                <!-- Search box -->
                                                <div class="p-2 sticky top-0 bg-white z-10">
                                                    <input type="text" id="sampleSearchInput"
                                                        placeholder="Search Sample No..."
                                                        class="w-full px-2 py-1 text-sm border rounded-md"
                                                        oninput="filterSamples()" />
                                                </div>

                                                <div class="py-1" role="listbox" tabindex="-1">
                                                    <!-- Clear / Reset -->
                                                    <button type="button"
                                                        class="sample-option w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                                        onclick="selectSample('', 'Select Sample No')">
                                                        All Sample No
                                                    </button>

                                                    <!-- Sample Options -->
                                                    <button type="button"
                                                        class="sample-option w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                                        onclick="selectSample('001', 'SAMPLE-001')">SAMPLE-001</button>
                                                    <button type="button"
                                                        class="sample-option w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                                        onclick="selectSample('002', 'SAMPLE-002')">SAMPLE-002</button>
                                                    <button type="button"
                                                        class="sample-option w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                                        onclick="selectSample('003', 'SAMPLE-003')">SAMPLE-003</button>
                                                </div>
                                            </div>

                                            <input type="hidden" name="sample_no" id="sampleInput">
                                        </div>

                                        <div>
                                            <label
                                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Production
                                                Deadline</label>
                                            <input type="date" id="productionDeadlineFilter" name="production_deadline"
                                                value="{{ request('') }}"
                                                class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Order
                                                Complete Date</label>
                                            <input type="date" id="oderCompleteDateFilter" name="order_complete_date"
                                                value="{{ request('') }}"
                                                class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                        </div>
                                    </div>

                                    <button type="submit"
                                        class="mt-4 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                                        Apply Filters
                                    </button>

                                    <button type="button" id="clearFiltersBtnProduction"
                                        class="mt-4 bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-200 px-4 py-2 rounded hover:bg-gray-300">
                                        Clear Filters
                                    </button>
                                </form>
                            </div>


                            <div class="flex justify-between items-center mb-6">
                                <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Sample Preparation
                                    Production
                                    Records
                                </h1>
                            </div>

                            <div class="overflow-x-auto bg-white dark:bg-gray-900 shadow rounded-lg">
                                <table class="table-fixed w-full text-sm divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead class="bg-gray-100 dark:bg-gray-700 text-left">
                                        <tr class="text-center">
                                            <th
                                                class="font-bold sticky left-0 z-10 bg-white px-4 py-3 w-32 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                Order No
                                            </th>
                                            <th
                                                class="font-bold px-4 py-3 w-32 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                Production Deadline
                                            </th>
                                            <th
                                                class="font-bold px-4 py-3 w-48 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                Order Received Date & Time
                                            </th>
                                            <th
                                                class="font-bold px-4 py-3 w-48 text-center text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                Order Start Date & Time
                                            </th>
                                            <th
                                                class="font-bold px-4 py-3 w-52 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                Operator Name
                                            </th>
                                            <th
                                                class="font-bold px-4 py-3 w-52 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                Supervisor Name
                                            </th>
                                            <th
                                                class="font-bold px-4 py-3 w-48 text-center text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                Order Complete Date & Time
                                            </th>
                                            <th
                                                class="font-bold px-4 py-3 w-32 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                Production Output</th>
                                            <th
                                                class="font-bold px-4 py-3 w-56 text-center text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                Dispatch to R&D
                                            </th>
                                            <th
                                                class="font-bold px-4 py-3 w-72 text-center text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                Note
                                            </th>
                                            <th
                                                class="font-bold px-4 py-3 w-48 text-center text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="serviceRecords"
                                        class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                        @foreach ($productions as $prod)
                                            <tr id="serviceRow{{ $prod->id }}"
                                                class="odd:bg-white even:bg-gray-50 border-b border-gray-200  text-left">
                                                {{-- Order No --}}
                                                <td
                                                    class="sticky left-0 z-10 bg-white px-4 py-3 bg-gray-100 whitespace-normal break-words border-r border-gray-300">
                                                    <span
                                                        class="readonly font-bold hover:text-blue-600 hover:underline cursor-pointer"
                                                        onclick="document.getElementById('viewDetailsSample').classList.remove('hidden')">
                                                        {{ $prod->order_no }}
                                                    </span>
                                                    <input type="text" name="order_no"
                                                        class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                        value="{{ $prod->order_no }}" />
                                                </td>

                                                {{-- Production Deadline --}}
                                                <td
                                                    class="px-4 py-3 whitespace-normal break-words border-r border-gray-300  text-center">
                                                    <span class="readonly">
                                                        {{ $prod->production_deadline ? $prod->production_deadline->format('Y-m-d') : '-' }}
                                                    </span>
                                                    <input type="date" name="production_deadline"
                                                        class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                        value="{{ $prod->production_deadline ? $prod->production_deadline->format('Y-m-d') : '' }}" />
                                                </td>

                                                {{-- Order Received Date & Time --}}
                                                <td
                                                    class="py-3 whitespace-normal break-words border-r border-gray-300 text-center">
                                                    <span
                                                        class="readonly inline-block m-1 text-sm font-semibold text-gray-700 dark:text-white bg-yellow-100 dark:bg-gray-800 px-3 py-1 rounded">
                                                        Received on <br>
                                                        {{ \Carbon\Carbon::parse($prod->order_received_at)->format('Y-m-d') }}
                                                        at
                                                        {{ \Carbon\Carbon::parse($prod->order_received_at)->format('H:i') }}
                                                    </span>
                                                    <input type="datetime-local" name="order_received_at"
                                                        class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                        value="{{ $prod->order_received_at ? $prod->order_received_at->format('Y-m-d\TH:i') : '' }}" />
                                                </td>

                                                {{-- Order Start Date & Time --}}
                                                <td
                                                    class="py-3 whitespace-normal break-words border-r border-gray-300 text-center">
                                                    @auth
                                                        @if (auth()->user()->role === 'ADMIN')
                                                            @if (!$prod->order_start_at)
                                                                <span
                                                                    class="inline-block mt-3 text-sm font-semibold text-gray-700 dark:text-white bg-gray-200 dark:bg-gray-800 px-3 py-1 rounded">
                                                                    Pending
                                                                </span>
                                                            @else
                                                                <span
                                                                    class="inline-block m-1 text-sm font-semibold text-gray-700 dark:text-white bg-pink-200 dark:bg-gray-800 px-3 py-1 rounded">
                                                                    Started on <br>
                                                                    {{ $prod->order_start_at->format('Y-m-d') }} at
                                                                    {{ $prod->order_start_at->format('H:i') }}
                                                                </span>
                                                            @endif
                                                        @else
                                                            @if (!$prod->order_start_at)
                                                                <form action="{{ route('production.markStart') }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    <input type="hidden" name="id"
                                                                        value="{{ $prod->id }}">
                                                                    <button type="submit"
                                                                        class="order-start-btn px-2 py-1 mt-3 rounded transition-all duration-200 bg-gray-300 text-black hover:bg-gray-400">
                                                                        Pending
                                                                    </button>
                                                                </form>
                                                            @else
                                                                <span
                                                                    class="inline-block m-1 text-sm font-semibold text-gray-700 dark:text-white bg-pink-200 dark:bg-gray-800 px-3 py-1 rounded">
                                                                    Started on <br>
                                                                    {{ $prod->order_start_at->format('Y-m-d') }} at
                                                                    {{ $prod->order_start_at->format('H:i') }}
                                                                </span>
                                                            @endif
                                                        @endif
                                                    @endauth
                                                </td>

                                                {{-- Operator Name --}}
                                                <td
                                                    class="px-4 py-3 whitespace-normal break-words border-r border-gray-300 text-center">
                                                    @auth
                                                        @if (auth()->user()->role === 'ADMIN')
                                                            @if ($prod->operator_name)
                                                                <span>{{ $prod->operator_name }}</span>
                                                            @else
                                                                <span class="italic text-gray-500">Not Assigned</span>
                                                            @endif
                                                        @else
                                                            @if ($prod->operator_name)
                                                                <span>{{ $prod->operator_name }}</span>
                                                            @else
                                                                <form method="POST"
                                                                    action="{{ route('sample-preparation-production.update-operator', $prod->id) }}">
                                                                    @csrf
                                                                    @method('PATCH')

                                                                    <div class="relative inline-block text-left w-44">
                                                                        <button type="button"
                                                                            class="dropdown-btn inline-flex w-full justify-between rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-gray-300 hover:bg-gray-50"
                                                                            onclick="toggleDropdown(this, 'operator')">
                                                                            <span class="selected-operator">Select
                                                                                Operator</span>
                                                                            <svg class="ml-2 h-5 w-5 text-gray-400"
                                                                                viewBox="0 0 20 20" fill="currentColor">
                                                                                <path fill-rule="evenodd"
                                                                                    d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 10.94l3.71-3.71a.75.75 0 1 1 1.06 1.06l-4.24 4.24a.75.75 0 0 1-1.06 0L5.25 8.29a.75.75 0 0 1-.02-1.08z"
                                                                                    clip-rule="evenodd" />
                                                                            </svg>
                                                                        </button>

                                                                        <div
                                                                            class="dropdown-menu-operator hidden absolute z-10 mt-2 w-full rounded-md bg-white shadow-lg ring-1 ring-black/5 max-h-48 overflow-y-auto">
                                                                            <div class="p-2 sticky top-0 bg-white z-10">
                                                                                <input type="text"
                                                                                    placeholder="Search Operator..."
                                                                                    class="w-full px-2 py-1 text-sm border rounded-md"
                                                                                    oninput="filterDropdownOptions(this)" />
                                                                            </div>

                                                                            <div class="py-1" role="listbox"
                                                                                tabindex="-1">
                                                                                @foreach ($operators as $operator)
                                                                                    <button type="button"
                                                                                        class="dropdown-option w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                                                                        onclick="selectDropdownOption(this, '{{ $operator->name }}', 'operator')">
                                                                                        {{ $operator->name }}
                                                                                    </button>
                                                                                @endforeach
                                                                            </div>
                                                                        </div>

                                                                        <input type="hidden" name="operator_name"
                                                                            class="input-operator">
                                                                    </div>
                                                                </form>
                                                            @endif
                                                        @endif
                                                    @endauth
                                                </td>

                                                {{-- Supervisor Name --}}
                                                <td
                                                    class="px-4 py-3 whitespace-normal break-words border-r border-gray-300 text-center">
                                                    @auth
                                                        @if (auth()->user()->role === 'ADMIN')
                                                            @if ($prod->supervisor_name)
                                                                <span>{{ $prod->supervisor_name }}</span>
                                                            @else
                                                                <span class="italic text-gray-500">Not Assigned</span>
                                                            @endif
                                                        @else
                                                            @if ($prod->supervisor_name)
                                                                <span>{{ $prod->supervisor_name }}</span>
                                                            @else
                                                                <form method="POST"
                                                                    action="{{ route('sample-preparation-production.update-supervisor', $prod->id) }}">
                                                                    @csrf
                                                                    @method('PATCH')

                                                                    <div class="relative inline-block text-left w-44">
                                                                        <button type="button"
                                                                            class="dropdown-btn inline-flex w-full justify-between rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-gray-300 hover:bg-gray-50"
                                                                            onclick="toggleDropdown(this, 'supervisor')">
                                                                            <span class="selected-supervisor">Select
                                                                                Supervisor</span>
                                                                            <svg class="ml-2 h-5 w-5 text-gray-400"
                                                                                viewBox="0 0 20 20" fill="currentColor">
                                                                                <path fill-rule="evenodd"
                                                                                    d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 10.94l3.71-3.71a.75.75 0 1 1 1.06 1.06l-4.24 4.24a.75.75 0 0 1-1.06 0L5.25 8.29a.75.75 0 0 1-.02-1.08z"
                                                                                    clip-rule="evenodd" />
                                                                            </svg>
                                                                        </button>

                                                                        <div
                                                                            class="dropdown-menu-supervisor hidden absolute z-10 mt-2 w-full rounded-md bg-white shadow-lg ring-1 ring-black/5 max-h-48 overflow-y-auto">
                                                                            <div class="p-2 sticky top-0 bg-white z-10">
                                                                                <input type="text"
                                                                                    placeholder="Search Supervisor..."
                                                                                    class="w-full px-2 py-1 text-sm border rounded-md"
                                                                                    oninput="filterDropdownOptions(this)" />
                                                                            </div>

                                                                            <div class="py-1" role="listbox"
                                                                                tabindex="-1">
                                                                                @foreach ($supervisors as $supervisor)
                                                                                    <button type="button"
                                                                                        class="dropdown-option w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                                                                        onclick="selectDropdownOption(this, '{{ $supervisor->name }}', 'supervisor')">
                                                                                        {{ $supervisor->name }}
                                                                                    </button>
                                                                                @endforeach
                                                                            </div>
                                                                        </div>

                                                                        <input type="hidden" name="supervisor_name"
                                                                            class="input-supervisor">
                                                                    </div>
                                                                </form>
                                                            @endif
                                                        @endif
                                                    @endauth
                                                </td>

                                                {{-- Order Complete Date & Time --}}
                                                <td
                                                    class="py-3 whitespace-normal break-words border-r border-gray-300 text-center">
                                                    @auth
                                                        @if (auth()->user()->role === 'ADMIN')
                                                            @if (!$prod->order_complete_at)
                                                                <span
                                                                    class="inline-block mt-3 text-sm font-semibold text-gray-700 dark:text-white bg-gray-200 dark:bg-gray-800 px-3 py-1 rounded">
                                                                    Pending
                                                                </span>
                                                            @else
                                                                <span
                                                                    class="inline-block m-1 text-sm font-semibold text-gray-700 dark:text-white bg-green-100 dark:bg-gray-800 px-3 py-1 rounded">
                                                                    Completed on <br>
                                                                    {{ $prod->order_complete_at->format('Y-m-d') }} at
                                                                    {{ $prod->order_complete_at->format('H:i') }}
                                                                </span>
                                                            @endif
                                                        @else
                                                            @if (!$prod->order_complete_at)
                                                                <form action="{{ route('production.markComplete') }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    <input type="hidden" name="id"
                                                                        value="{{ $prod->id }}">
                                                                    <button type="submit"
                                                                        class="order-complete-btn px-2 py-1 mt-3 rounded transition-all duration-200 bg-gray-300 text-black hover:bg-gray-400">
                                                                        Pending
                                                                    </button>
                                                                </form>
                                                            @else
                                                                <span
                                                                    class="inline-block m-1 text-sm font-semibold text-gray-700 dark:text-white bg-green-100 dark:bg-gray-800 px-3 py-1 rounded">
                                                                    Completed on <br>
                                                                    {{ $prod->order_complete_at->format('Y-m-d') }} at
                                                                    {{ $prod->order_complete_at->format('H:i') }}
                                                                </span>
                                                            @endif
                                                        @endif
                                                    @endauth
                                                </td>

                                                {{-- Production Output --}}
                                                <td
                                                    class="px-4 py-3 whitespace-normal break-words border-r border-gray-300 text-center">
                                                    @auth
                                                        @if (auth()->user()->role === 'ADMIN')
                                                            <span class="readonly">
                                                                {{ is_numeric($prod->production_output) ? $prod->production_output . ' g' : '-' }}
                                                            </span>
                                                        @else
                                                            @if (!$prod->is_output_locked)
                                                                <form action="{{ route('production.updateOutput') }}"
                                                                    method="POST" class="inline-block w-full">
                                                                    @csrf
                                                                    <input type="hidden" name="id"
                                                                        value="{{ $prod->id }}">

                                                                    <input type="number" step="any"
                                                                        name="production_output"
                                                                        value="{{ old('production_output', $prod->production_output) }}"
                                                                        class="w-full px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                                        required>

                                                                    <button type="submit"
                                                                        class="mt-1 px-3 py-1 rounded text-sm transition-all duration-200 bg-blue-600 hover:bg-blue-700 text-white">
                                                                        Save
                                                                    </button>
                                                                </form>
                                                            @else
                                                                <span class="readonly">
                                                                    {{ is_numeric($prod->production_output) ? $prod->production_output . ' g' : '-' }}
                                                                </span>
                                                            @endif
                                                        @endif
                                                    @endauth
                                                </td>

                                                {{-- Dispatch to R&D --}}
                                                <td
                                                    class="px-4 py-3 whitespace-normal break-words border-r border-gray-300 text-center">
                                                    @auth
                                                        @if (auth()->user()->role === 'ADMIN')
                                                            <div class="text-sm text-gray-800 dark:text-white font-medium">
                                                                {{ $prod->dispatched_by ?? '-' }}
                                                            </div>
                                                            <div
                                                                class="sample-dispatch-timestamp text-xs text-gray-500 dark:text-gray-400">
                                                                {{ $prod->dispatch_to_rnd_at ? $prod->dispatch_to_rnd_at->format('Y-m-d H:i') : '-' }}
                                                            </div>
                                                        @else
                                                            @if (!$prod->dispatch_to_rnd_at)
                                                                <form action="{{ route('production.dispatchToRnd') }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    <input type="hidden" name="id"
                                                                        value="{{ $prod->id }}">

                                                                    <input type="text" name="dispatched_by"
                                                                        placeholder="Enter name"
                                                                        class="w-full px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                                        required>

                                                                    <button type="submit"
                                                                        class="sample-dispatch-btn bg-gray-300 text-black mt-1 px-2 py-1 rounded hover:bg-gray-400 transition-all duration-200 w-full">
                                                                        Dispatch
                                                                    </button>
                                                                </form>
                                                            @else
                                                                <span
                                                                    class="inline-block m-1 text-sm font-semibold text-gray-700 dark:text-white bg-blue-100 dark:bg-gray-800 px-3 py-1 rounded">
                                                                    <div
                                                                        class="text-sm text-gray-800 dark:text-white font-medium">
                                                                        Dispatch to {{ $prod->dispatched_by ?? '-' }}
                                                                    </div>
                                                                    <div
                                                                        class="sample-dispatch-timestamp text-xs text-gray-500 dark:text-gray-400">
                                                                        Dispatch
                                                                        on {{ $prod->dispatch_to_rnd_at->format('Y-m-d') }}
                                                                        <br>
                                                                        at {{ $prod->dispatch_to_rnd_at->format('H:i') }}
                                                                    </div>
                                                                </span>
                                                            @endif
                                                        @endif
                                                    @endauth
                                                </td>

                                                {{-- Note --}}
                                                <td class="px-4 py-3 whitespace-normal break-words border-r border-gray-300 text-center">
                                                    @if (auth()->user()->role !== 'ADMIN')
                                                        <form action="{{ route('sample-inquery-details.update-notes', $prod->id) }}" method="POST" class="w-full">
                                                            @csrf
                                                            @method('PATCH')

                                                            <textarea name="notes"
                                                                      rows="2"
                                                                      class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                                      required>{{ old('notes', $prod->note) }}</textarea>

                                                            <button type="submit"
                                                                    class="mt-1 px-2 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 transition-all duration-200 text-sm">
                                                                Save
                                                            </button>
                                                        </form>
                                                    @else
                                                        <span class="readonly">{{ $prod->note ?? 'N/D' }}</span>
                                                    @endif
                                                </td>

                                                {{-- Action Buttons --}}
                                                <td class="px-4 py-3 whitespace-normal break-words text-center">
                                                    <div class="flex space-x-2 justify-center">
                                                        {{-- @auth
                                                            @if (auth()->user()->role === 'SUPERADMIN')
                                                                <button type="button"
                                                                    class="bg-green-600 h-10 hover:bg-green-700 text-white px-3 py-1 rounded text-sm"
                                                                    onclick="editServiceRow('serviceRow{{ $prod->id }}')">
                                                                    Edit
                                                                </button>
                                                                <button type="button"
                                                                    class="bg-blue-600 h-10 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm hidden"
                                                                    onclick="saveServiceRow('serviceRow{{ $prod->id }}')">
                                                                    Save
                                                                </button>
                                                            @endif
                                                        @endauth --}}
                                                        @if ($prod->order_file_url)
                                                            <a href="{{ $prod->order_file_url }}" target="_blank"
                                                                class="bg-gray-600 h-10 w-20 hover:bg-gray-700 text-white px-3 py-2 rounded text-sm flex items-center justify-center ml-2">
                                                                View
                                                            </a>
                                                        @else
                                                            <button type="button"
                                                                class="bg-gray-300 h-10 w-20 text-gray-500 px-3 py-1 rounded text-sm cursor-not-allowed"
                                                                disabled>
                                                                No File
                                                            </button>
                                                        @endif
                                                    </div>
                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <!-- Add Sample Modal -->
                                <div id="viewDetailsSample"
                                    class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center py-5"
                                    onclick="document.getElementById('viewDetailsSample').classList.add('hidden')">

                                    <!-- Modal box -->
                                    <div class="w-full max-w-[700px] bg-white dark:bg-gray-900 rounded-2xl shadow-2xl p-4 transform transition-all scale-95 max-h-[calc(100vh-10rem)] overflow-y-auto"
                                        onclick="event.stopPropagation()">

                                        <div class="max-w-[600px] mx-auto p-8">
                                            <h2
                                                class="text-2xl font-semibold mb-8 text-blue-900 mt-4 dark:text-gray-100 text-center">
                                                Order Number 001
                                            </h2>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const clearFiltersBtn = document.getElementById('clearFiltersBtnProduction');
            const filterForm = document.getElementById('filterForm3');

            clearFiltersBtn.addEventListener('click', () => {
                // Reset dropdown label and hidden sample input
                document.getElementById('selectedSample').innerText = 'All Sample No';
                document.getElementById('sampleInput').value = '';

                // Reset date fields manually
                document.getElementById('productionDeadlineFilter').value = '';
                document.getElementById('oderCompleteDateFilter').value = '';

                // Close dropdown
                document.getElementById('sampleDropdownMenu').classList.add('hidden');
                document.getElementById('sampleDropdown').setAttribute('aria-expanded', 'false');

                // Prevent form submission and page reload
                // filterForm.submit(); // Removed as per your request
            });
        });


        function toggleSampleDropdown() {
            const menu = document.getElementById('sampleDropdownMenu');
            const btn = document.getElementById('sampleDropdown');
            const expanded = btn.getAttribute('aria-expanded') === 'true';

            menu.classList.toggle('hidden');
            btn.setAttribute('aria-expanded', String(!expanded));

            if (!menu.classList.contains('hidden')) {
                document.getElementById('sampleSearchInput').value = '';
                filterSamples();
            }
        }

        function filterSamples() {
            const filter = document.getElementById('sampleSearchInput').value.toLowerCase();
            const options = document.querySelectorAll('#sampleDropdownMenu .sample-option');

            options.forEach(option => {
                const text = option.textContent.toLowerCase();
                option.style.display = text.includes(filter) ? '' : 'none';
            });
        }

        function selectSample(id, label) {
            document.getElementById('selectedSample').innerText = label;
            document.getElementById('sampleInput').value = id;
            document.getElementById('sampleDropdownMenu').classList.add('hidden');
            document.getElementById('sampleDropdown').setAttribute('aria-expanded', 'false');
        }

        // Close dropdown if clicking outside of it
        document.addEventListener('click', function(e) {
            const btn = document.getElementById('sampleDropdown');
            const menu = document.getElementById('sampleDropdownMenu');

            if (!btn.contains(e.target) && !menu.contains(e.target)) {
                menu.classList.add('hidden');
                btn.setAttribute('aria-expanded', 'false');
            }
        });
    </script>

    <script>
        function editServiceRow(rowId) {
            const row = document.getElementById(rowId);
            const spans = row.querySelectorAll('span.readonly');
            const inputs = row.querySelectorAll('input.editable, textarea.editable');

            spans.forEach(span => span.classList.add('hidden'));
            inputs.forEach(input => input.classList.remove('hidden'));

            const editBtn = row.querySelector('button.bg-green-600');
            const saveBtn = row.querySelector('button.bg-blue-600');
            editBtn.classList.add('hidden');
            saveBtn.classList.remove('hidden');
        }

        function saveServiceRow(rowId) {
            const row = document.getElementById(rowId);
            const spans = row.querySelectorAll('span.readonly');
            const inputs = row.querySelectorAll('input.editable, textarea.editable');

            inputs.forEach((input, index) => {
                if (input.tagName.toLowerCase() === 'textarea') {
                    spans[index].textContent = input.value;
                } else {
                    spans[index].textContent = input.value;
                }
            });

            spans.forEach(span => span.classList.remove('hidden'));
            inputs.forEach(input => input.classList.add('hidden'));

            const editBtn = row.querySelector('button.bg-green-600');
            const saveBtn = row.querySelector('button.bg-blue-600');
            editBtn.classList.remove('hidden');
            saveBtn.classList.add('hidden');
        }
    </script>

    <script>
        function toggleOrderStart(event, button) {
            const isPending = button.textContent.trim() === 'Pending';
            const container = button.closest('.order-start-item');
            const timestamp = container.querySelector('.order-start-timestamp');

            if (isPending) {
                button.textContent = 'Started';
                button.classList.remove('bg-gray-300', 'text-black', 'hover:bg-gray-400');
                button.classList.add('bg-[#FF9119]', 'text-white', 'hover:bg-[#FF9119]/80');

                const now = new Date();
                timestamp.textContent = `Started on ${now.toLocaleDateString()} at ${now.toLocaleTimeString()}`;
            } else {
                button.textContent = 'Pending';
                button.classList.remove('bg-[#FF9119]', 'text-white', 'hover:bg-[#FF9119]/80');
                button.classList.add('bg-gray-300', 'text-black', 'hover:bg-gray-400');

                timestamp.textContent = '';
            }
        }
    </script>

    <script>
        function toggleOrderComplete(event, button) {
            const isPending = button.textContent.trim() === 'Pending';
            const container = button.closest('.order-complete-item');
            const timestamp = container.querySelector('.order-complete-timestamp');

            if (isPending) {
                button.textContent = 'Completed';
                button.classList.remove('bg-gray-300', 'text-black', 'hover:bg-gray-400');
                button.classList.add('bg-green-500', 'text-white', 'hover:bg-green-600');

                const now = new Date();
                timestamp.textContent = `Completed on ${now.toLocaleDateString()} at ${now.toLocaleTimeString()}`;
            } else {
                button.textContent = 'Pending';
                button.classList.remove('bg-green-500', 'text-white', 'hover:bg-green-600');
                button.classList.add('bg-gray-300', 'text-black', 'hover:bg-gray-400');

                timestamp.textContent = '';
            }
        }
    </script>

    <script>
        function toggleSampleDispatch(event, button) {
            const isPending = button.textContent.trim() === 'Pending';
            const container = button.closest('.sample-dispatch-item');
            const timestamp = container.querySelector('.sample-dispatch-timestamp');

            if (isPending) {
                button.textContent = 'Done';
                button.classList.remove('bg-gray-300', 'text-black', 'hover:bg-gray-400');
                button.classList.add('bg-green-500', 'text-white', 'hover:bg-green-600');

                const now = new Date();
                timestamp.textContent = `Done on ${now.toLocaleDateString()} at ${now.toLocaleTimeString()}`;
            } else {
                button.textContent = 'Pending';
                button.classList.remove('bg-green-500', 'text-white', 'hover:bg-green-600');
                button.classList.add('bg-gray-300', 'text-black', 'hover:bg-gray-400');

                timestamp.textContent = '';
            }
        }
    </script>

    <script>
        function toggleFilterForm() {
            const form = document.getElementById('filterFormContainer');
            form.classList.toggle('hidden');
        }
    </script>

    <script>
        function selectDropdownOption(button, value, type) {
            // Update the button text
            const wrapper = button.closest('.relative');
            const selectedSpan = wrapper.querySelector(`.selected-${type}`);
            const hiddenInput = wrapper.querySelector(`.input-${type}`);
            const dropdownMenu = wrapper.querySelector(`.dropdown-menu-${type}`);

            selectedSpan.textContent = value;
            hiddenInput.value = value;

            // Hide the dropdown
            dropdownMenu.classList.add('hidden');

            // Submit the form
            wrapper.closest('form').submit();
        }

        function filterDropdownOptions(inputElement) {
            const searchValue = inputElement.value.toLowerCase();
            const options = inputElement.closest('.dropdown-menu-operator, .dropdown-menu-supervisor')
                .querySelectorAll('.dropdown-option');

            options.forEach(option => {
                const text = option.textContent.toLowerCase();
                option.style.display = text.includes(searchValue) ? 'block' : 'none';
            });
        }

        function toggleDropdown(button, type) {
            const wrapper = button.closest('.relative');
            const menu = wrapper.querySelector(`.dropdown-menu-${type}`);
            document.querySelectorAll('.dropdown-menu-operator, .dropdown-menu-supervisor').forEach(d => {
                if (d !== menu) d.classList.add('hidden');
            });
            menu.classList.toggle('hidden');
        }

        // Click outside to close dropdown
        document.addEventListener('click', function(e) {
            document.querySelectorAll('.dropdown-menu-operator, .dropdown-menu-supervisor').forEach(menu => {
                if (!menu.closest('.relative').contains(e.target)) {
                    menu.classList.add('hidden');
                }
            });
        });
    </script>
@endsection
