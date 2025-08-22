<head>

    <!-- Include Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Include SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <title>StretchTec</title>
</head>

<div class="flex h-full w-full bg-white">
    @extends('layouts.sample-tabs')

    @section('content')
        <div class="flex-1 overflow-y-hidden">
            <div class="">
                <div class="w-full px-6 lg:px-2">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden">
                        <div class="p-4 text-gray-900 dark:text-gray-100">

                            {{-- Sweet Alert Styles --}}
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

                            {{-- Sweet Alert Script --}}
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

                            {{-- Filters --}}
                            <div class="flex justify-start">
                                <button onclick="toggleFilterForm()"
                                    class="bg-white border border-blue-500 text-blue-500 hover:text-blue-600 hover:border-blue-600 font-semibold py-1 px-3 rounded shadow flex items-center gap-2 mb-6">
                                    <img src="{{ asset('icons/filter.png') }}" class="w-6 h-6" alt="Filter Icon">
                                    Filters
                                </button>
                            </div>

                            <div id="filterFormContainer" class="hidden mt-4">
                                <!-- Filter Form -->
                                <form id="filterForm2" method="GET"
                                    action="{{ route('sample-preparation-details.index') }}" class="mb-6">
                                    <div class="flex items-center gap-4 flex-wrap">

                                        {{-- Filters - Order No Dropdown --}}
                                        <div class="relative inline-block text-left w-48">
                                            <label for="customerDropdown"
                                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Order
                                                No</label>
                                            <input type="hidden" name="order_no" id="orderInput"
                                                value="{{ request('order_no') }}">
                                            <button id="orderDropdown" type="button" onclick="toggleOrderDropdown()"
                                                class="inline-flex w-full justify-between rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-gray-300 hover:bg-gray-50 h-10 dark:bg-gray-700 dark:text-white"
                                                aria-expanded="false" aria-haspopup="listbox">
                                                <span
                                                    id="selectedOrderNo">{{ request('order_no') ?? 'Select Order No' }}</span>
                                                <svg class="ml-2 h-5 w-5 text-gray-400" viewBox="0 0 20 20"
                                                    fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 10.94l3.71-3.71a.75.75 0 1 1 1.06 1.06l-4.24 4.24a.75.75 0 0 1-1.06 0L5.25 8.29a.75.75 0 0 1-.02-1.08z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                            <div id="orderDropdownMenu"
                                                class="absolute z-40 mt-1 w-full bg-white border rounded-lg shadow-lg hidden max-h-48 overflow-y-auto p-2"
                                                role="listbox" aria-labelledby="orderDropdown">
                                                <input type="text" id="orderSearchInput" onkeyup="filterOrders()"
                                                    placeholder="Search..."
                                                    class="w-full px-2 py-1 text-sm border rounded-md dark:bg-gray-600 dark:text-white dark:placeholder-gray-300"
                                                    autocomplete="off">
                                                @foreach ($orderNos as $order)
                                                    <div onclick="selectOrder('{{ $order }}')" tabindex="0"
                                                        class="order-option px-4 py-2 hover:bg-gray-100 cursor-pointer text-sm"
                                                        role="option">
                                                        {{ $order }}
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        {{-- Filters - PO No Dropdown --}}
                                        <div class="relative inline-block text-left w-48">
                                            <label for="customerDropdown"
                                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">PO
                                                No</label>
                                            <input type="hidden" name="po_no" id="poInput"
                                                value="{{ request('po_no') }}">
                                            <button id="poDropdown" type="button" onclick="togglePODropdown()"
                                                class="inline-flex w-full justify-between rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-gray-300 hover:bg-gray-50 h-10 dark:bg-gray-700 dark:text-white"
                                                aria-expanded="false" aria-haspopup="listbox">
                                                <span id="selectedPONo">{{ request('po_no') ?? 'Select PO No' }}</span>
                                                <svg class="ml-2 h-5 w-5 text-gray-400" viewBox="0 0 20 20"
                                                    fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 10.94l3.71-3.71a.75.75 0 1 1 1.06 1.06l-4.24 4.24a.75.75 0 0 1-1.06 0L5.25 8.29a.75.75 0 0 1-.02-1.08z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                            <div id="poDropdownMenu"
                                                class="absolute z-40 mt-1 w-full bg-white border rounded-lg shadow-lg hidden max-h-48 overflow-y-auto p-2"
                                                role="listbox" aria-labelledby="poDropdown">
                                                <input type="text" id="poSearchInput" onkeyup="filterPOs()"
                                                    placeholder="Search..."
                                                    class="w-full px-2 py-1 text-sm border rounded-md dark:bg-gray-600 dark:text-white dark:placeholder-gray-300"
                                                    autocomplete="off">
                                                @foreach ($poNos as $po)
                                                    <div onclick="selectPO('{{ $po }}')" tabindex="0"
                                                        class="po-option px-4 py-2 hover:bg-gray-100 cursor-pointer text-sm"
                                                        role="option">
                                                        {{ $po }}
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        {{-- Filters - Shade Dropdown --}}
                                        <div class="relative inline-block text-left w-48">
                                            <label for="customerDropdown"
                                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Shade</label>
                                            <input type="hidden" name="shade" id="shadeInput"
                                                value="{{ request('shade') }}">
                                            <button id="shadeDropdown" type="button" onclick="toggleShadeDropdown()"
                                                class="inline-flex w-full justify-between rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-gray-300 hover:bg-gray-50 h-10 dark:bg-gray-700 dark:text-white"
                                                aria-expanded="false" aria-haspopup="listbox">
                                                <span id="selectedShade">{{ request('shade') ?? 'Select Shade' }}</span>
                                                <svg class="ml-2 h-5 w-5 text-gray-400" viewBox="0 0 20 20"
                                                    fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 10.94l3.71-3.71a.75.75 0 1 1 1.06 1.06l-4.24 4.24a.75.75 0 0 1-1.06 0L5.25 8.29a.75.75 0 0 1-.02-1.08z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                            <div id="shadeDropdownMenu"
                                                class="absolute z-40 mt-1 w-full bg-white border rounded-lg shadow-lg hidden max-h-48 overflow-y-auto p-2"
                                                role="listbox" aria-labelledby="shadeDropdown">
                                                <input type="text" id="shadeSearchInput" onkeyup="filterShades()"
                                                    placeholder="Search..."
                                                    class="w-full px-2 py-1 text-sm border rounded-md dark:bg-gray-600 dark:text-white dark:placeholder-gray-300"
                                                    autocomplete="off">
                                                @foreach ($shades as $shade)
                                                    <div onclick="selectShade('{{ $shade }}')" tabindex="0"
                                                        class="shade-option px-4 py-2 hover:bg-gray-100 cursor-pointer text-sm"
                                                        role="option">
                                                        {{ $shade }}
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        {{-- Filters - Coordinator Name Dropdown --}}
                                        <div class="relative inline-block text-left w-48"> <label
                                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Coordinator</label>
                                            <input type="hidden" name="coordinator_name" id="coordinatorInput"
                                                value="{{ request('coordinator_name') }}"> <button type="button"
                                                onclick="toggleCoordinatorDropdown()" id="coordinatorDropdown"
                                                class="inline-flex w-full justify-between rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-gray-300 hover:bg-gray-50 h-10 dark:bg-gray-700 dark:text-white"
                                                aria-expanded="false"> <span
                                                    id="selectedCoordinator">{{ request('coordinator_name') ?? 'Select Coordinator' }}</span>
                                                <svg class="ml-2 h-5 w-5 text-gray-400" viewBox="0 0 20 20"
                                                    fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.25 8.29a.75.75 0 01-.02-1.08z"
                                                        clip-rule="evenodd" />
                                                </svg> </button>
                                            <div id="coordinatorDropdownMenu"
                                                class="absolute z-40 mt-1 w-full bg-white border rounded-lg shadow-lg hidden max-h-48 overflow-y-auto p-2">
                                                <input type="text" id="coordinatorSearchInput"
                                                    onkeyup="filterCoordinators()" placeholder="Search..."
                                                    class="w-full px-2 py-1 text-sm border rounded-md dark:bg-gray-600 dark:text-white dark:placeholder-gray-300"
                                                    autocomplete="off">
                                                @foreach ($coordinators as $coordinator)
                                                    <div onclick="selectCoordinator('{{ $coordinator }}')"
                                                        class="coordinator-option px-4 py-2 hover:bg-gray-100 cursor-pointer text-sm">
                                                        {{ $coordinator }}</div>
                                                @endforeach
                                            </div>
                                        </div>

                                        {{-- Filters - Reference No Dropdown --}}
                                        <div class="relative inline-block text-left w-48">
                                            <label for="customerDropdown"
                                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Reference
                                                No</label>
                                            <input type="hidden" name="reference_no" id="refInput"
                                                value="{{ request('reference_no') }}">
                                            <button id="refDropdown" type="button" onclick="toggleRefDropdown()"
                                                class="inline-flex w-full justify-between rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-gray-300 hover:bg-gray-50 h-10 dark:bg-gray-700 dark:text-white"
                                                aria-expanded="false" aria-haspopup="listbox">
                                                <span
                                                    id="selectedRef">{{ request('reference_no') ?? 'Select Reference No' }}</span>
                                                <svg class="ml-2 h-5 w-5 text-gray-400" viewBox="0 0 20 20"
                                                    fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 10.94l3.71-3.71a.75.75 0 1 1 1.06 1.06l-4.24 4.24a.75.75 0 0 1-1.06 0L5.25 8.29a.75.75 0 0 1-.02-1.08z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                            <div id="refDropdownMenu"
                                                class="absolute z-40 mt-1 w-full bg-white border rounded-lg shadow-lg hidden max-h-48 overflow-y-auto p-2"
                                                role="listbox" aria-labelledby="refDropdown">
                                                <input type="text" id="refSearchInput" onkeyup="filterRefs()"
                                                    placeholder="Search..."
                                                    class="w-full px-2 py-1 text-sm border rounded-md dark:bg-gray-600 dark:text-white dark:placeholder-gray-300"
                                                    autocomplete="off">
                                                @foreach ($references as $ref)
                                                    <div onclick="selectRef('{{ $ref }}')" tabindex="0"
                                                        class="ref-option px-4 py-2 hover:bg-gray-100 cursor-pointer text-sm"
                                                        role="option">
                                                        {{ $ref }}
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="flex gap-6 items-end">

                                            {{-- Filters - Date: Customer Requested --}}
                                            <div class="inline-block text-left w-48">
                                                <label for="customer_requested_date"
                                                    class="block text-sm font-medium text-gray-700">Customer Requested
                                                    Date</label>
                                                <input type="date" name="customer_requested_date"
                                                    id="customerRequestedDate"
                                                    value="{{ request('customer_requested_date') }}"
                                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 text-sm">
                                            </div>

                                            {{-- Filters - Date: Development Plan --}}
                                            <div class="inline-block text-left w-48">
                                                <label for="development_plan_date"
                                                    class="block text-sm font-medium text-gray-700">Development Plan
                                                    Date</label>
                                                <input type="date" name="development_plan_date"
                                                    id="developmentPlanDate"
                                                    value="{{ request('development_plan_date') }}"
                                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 text-sm">
                                            </div>

                                            {{-- Filters - Buttons --}}
                                            <div class="flex items-end space-x-2 mt-2">
                                                <button type="submit"
                                                    class="mt-4 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Apply
                                                    Filters</button>
                                                <button type="button" id="clearFiltersBtn" onclick="clearFilters()"
                                                    class="mt-4 bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-200 px-4 py-2 rounded hover:bg-gray-300">Clear</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="flex justify-between items-center mb-6">
                                <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Sample Preparation R & D
                                    Records
                                </h1>

                                {{-- Other Tabs Buttons --}}
                                <div class="flex space-x-3">
                                    <a href="{{ route('sampleStock.index') }}">
                                        <button
                                            class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded shadow">
                                            Sample Stock Management
                                        </button>
                                    </a>
                                    <a href="{{ route('leftoverYarn.index') }}">
                                        <button
                                            class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded shadow">
                                            Leftover Yarn Management
                                        </button>
                                    </a>
                                </div>
                            </div>

                            {{-- Main Table --}}
                            <div id="ResearchAndDevelopmentRecordsScroll"
                                class="overflow-x-auto max-h-[1200px] bg-white dark:bg-gray-900 shadow rounded-lg">
                                <table class="table-fixed w-full text-sm divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead class="bg-gray-100 dark:bg-gray-700 text-left">
                                        <tr class="text-center">
                                            <th
                                                class="font-bold sticky left-0 top-0 z-30 bg-white px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                Order No</th>
                                            <th
                                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                Customer Requested Date</th>
                                            <th
                                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-48 text-center text-xs uppercase text-gray-600 dark:text-gray-300 whitespace-normal break-words">
                                                Colour Match Sent Date</th>
                                            <th
                                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-72 text-center text-xs uppercase text-gray-600 dark:text-gray-300 whitespace-normal break-words">
                                                Colour Match Receive Date</th>
                                            <th
                                                class="font-bold sticky top-0 z-20 bg-gray-200 px-4 py-3 w-56 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                Already Developed & In Sample Stock</th>
                                            <th
                                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-44 text-xs uppercase text-gray-600 dark:text-gray-300 whitespace-normal break-words">
                                                Development Plan Date</th>
                                            <th
                                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-48 text-center text-xs uppercase text-gray-600 dark:text-gray-300 whitespace-normal break-words">
                                                Yarn Ordered Date</th>
                                            <th
                                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-40 text-xs uppercase text-gray-600 dark:text-gray-300 whitespace-normal break-words">
                                                Yarn Ordered PO Number</th>
                                            <th
                                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-40 text-xs uppercase text-gray-600 dark:text-gray-300 whitespace-normal break-words">
                                                Shade</th>
                                            <th
                                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-40 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                Yarn Ordered Weight</th>
                                            <th
                                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-40 text-xs uppercase text-gray-600 dark:text-gray-300 whitespace-normal break-words">
                                                Tkt</th>
                                            <th
                                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-40 text-xs uppercase text-gray-600 dark:text-gray-300 whitespace-normal break-words">
                                                Yarn Supplier</th>
                                            <th
                                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-40 text-xs uppercase text-gray-600 dark:text-gray-300 whitespace-normal break-words">
                                                Yarn Price</th>
                                            <th
                                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-48 text-center text-xs uppercase text-gray-600 dark:text-gray-300 whitespace-normal break-words">
                                                Yarn Receive Date</th>
                                            <th
                                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-40 text-xs uppercase text-gray-600 dark:text-gray-300 whitespace-normal break-words">
                                                Production Deadline</th>
                                            <th
                                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-48 text-center text-xs uppercase text-gray-600 dark:text-gray-300 whitespace-normal break-words">
                                                Send Order To Production Status</th>
                                            <th
                                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-36 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                Production Status</th>
                                            <th
                                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                Production Output</th>
                                            <th
                                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                Damaged Output</th>
                                            <th
                                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                Yarn Leftover Weight</th>
                                            <th
                                                class="font-bold sticky top-0 z-20 bg-gray-200 px-4 py-3 w-56 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                Reference No</th>
                                            <th
                                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-72 text-xs text-center text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                Note</th>
                                            <th
                                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-48 text-xs uppercase text-gray-600 dark:text-gray-300 text-center whitespace-normal break-words">
                                                Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="sampleDevelopmentRecords"
                                        class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                        @foreach ($samplePreparations as $prep)
                                            <tr id="prodRow{{ $prep->id }}"
                                                class="odd:bg-white even:bg-gray-50 border-b border-gray-200  text-left">
                                                <td
                                                    class="sticky left-0 z-20 px-4 py-3 bg-gray-100 whitespace-normal break-words border-r border-gray-300">
                                                    <span
                                                        class="readonly font-bold hover:text-blue-600 hover:underline cursor-pointer {{ $prep->productionStatus == 'Order Delivered' ? 'text-red-600' : 'text-black' }}"
                                                        onclick="openRndSampleModal(
                                                            '{{ addslashes($prep->orderNo) }}',
                                                            '{{ addslashes($prep->sampleInquiry->customerName ?? '-') }}',
                                                            '{{ addslashes($prep->sampleInquiry->coordinatorName ?? '-') }}',
                                                            '{{ addslashes($prep->sampleInquiry->item ?? '-') }}',
                                                            '{{ addslashes($prep->sampleInquiry->ItemDiscription ?? '-') }}',
                                                            '{{ addslashes($prep->sampleInquiry->size ?? '-') }}',
                                                            '{{ addslashes($prep->sampleInquiry->qtRef ?? '-') }}',
                                                            '{{ addslashes($prep->sampleInquiry->color ?? '-') }}',
                                                            '{{ addslashes($prep->sampleInquiry->style ?? '-') }}',
                                                            '{{ addslashes($prep->sampleInquiry->sampleQty ?? '-') }}',
                                                            '{{ addslashes($prep->sampleInquiry->customerSpecialComment ?? '-') }}',
                                                            '{{ addslashes(optional($prep->sampleInquiry->customerRequestDate)->format('Y-m-d') ?? '-') }}'
                                                        )">
                                                        {{ $prep->orderNo }}
                                                    </span>

                                                    <input type="text" name="orderNo"
                                                        class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                        value="{{ $prep->orderNo }}" />
                                                </td>

                                                <td
                                                    class="px-4 py-3 whitespace-normal break-words border-r border-gray-300 text-center">
                                                    @if ($prep->customerRequestDate)
                                                        <span class="readonly">
                                                            {{ \Carbon\Carbon::parse($prep->customerRequestDate)->format('Y-m-d') }}
                                                        </span>
                                                        <input type="date" name="customerRequestDate"
                                                            class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                            value="{{ \Carbon\Carbon::parse($prep->customerRequestDate)->format('Y-m-d') }}" />
                                                    @else
                                                        <span
                                                            class="inline-block px-3 py-1 text-xs font-semibold text-gray-600 bg-gray-200 rounded">
                                                            Not Given
                                                        </span>
                                                        <input type="date" name="customerRequestDate"
                                                            class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                            value="" />
                                                    @endif
                                                </td>

                                                {{-- Colour Match Sent Date --}}
                                                <td
                                                    class="text-center py-3 border-r border-gray-300 whitespace-normal break-words">
                                                    @if (is_null($prep->colourMatchSentDate))
                                                        @if (Auth::user()->role === 'ADMIN' or Auth::user()->role === 'PRODUCTIONOFFICER')
                                                            {{-- Read-only for ADMIN --}}
                                                            <button type="button"
                                                                class="delivered-btn bg-gray-200 text-gray-500 px-2 py-1 mt-3 rounded cursor-not-allowed"
                                                                disabled>
                                                                Pending
                                                            </button>
                                                        @else
                                                            {{-- Editable for non-admins --}}
                                                            <form action="{{ route('rnd.markColourMatchSent') }}"
                                                                method="POST">
                                                                @csrf
                                                                <input type="hidden" name="id"
                                                                    value="{{ $prep->id }}">
                                                                <button type="submit"
                                                                    class="delivered-btn bg-gray-300 text-black px-2 py-1 mt-3 rounded hover:bg-gray-400 transition-all duration-200">
                                                                    Pending
                                                                </button>
                                                            </form>
                                                        @endif
                                                    @else
                                                        {{-- Show static timestamp --}}
                                                        <span
                                                            class="inline-block m-1 text-sm font-semibold text-gray-700 dark:text-white bg-yellow-100 dark:bg-gray-800 px-3 py-1 rounded">
                                                            Sent on <br>
                                                            {{ \Carbon\Carbon::parse($prep->colourMatchSentDate)->format('Y-m-d') }}
                                                            at
                                                            {{ \Carbon\Carbon::parse($prep->colourMatchSentDate)->format('H:i') }}
                                                        </span>
                                                    @endif
                                                </td>

                                                <td
                                                    class="py-3 whitespace-normal break-words border-r border-gray-300 text-center">
                                                    @if (is_null($prep->colourMatchReceiveDate))
                                                        @if (Auth::user()->role === 'ADMIN' or Auth::user()->role === 'PRODUCTIONOFFICER')
                                                            {{-- Read-only for ADMIN --}}
                                                            <button type="button"
                                                                class="receive-btn px-2 py-1 mt-3 rounded bg-gray-200 text-gray-500 cursor-not-allowed"
                                                                disabled
                                                                title="Admins cannot update Colour Match Receive Date">
                                                                Pending
                                                            </button>
                                                        @else
                                                            {{-- Editable for non-admins --}}
                                                            <form action="{{ route('rnd.markColourMatchReceive') }}"
                                                                method="POST">
                                                                @csrf
                                                                <input type="hidden" name="id"
                                                                    value="{{ $prep->id }}">
                                                                <button type="submit"
                                                                    class="receive-btn px-2 py-1 mt-3 rounded transition-all duration-200
                                                                        {{ $prep->colourMatchSentDate ? 'bg-gray-300 text-black hover:bg-gray-400' : 'bg-gray-200 text-gray-500 cursor-not-allowed' }}"
                                                                    {{ $prep->colourMatchSentDate ? '' : 'disabled' }}
                                                                    title="{{ $prep->colourMatchSentDate ? '' : 'Please set Colour Match Sent Date first' }}">
                                                                    Pending
                                                                </button>
                                                            </form>
                                                        @endif
                                                    @else
                                                        <div class="flex flex-wrap justify-center gap-2">
                                                            <button type="button"
                                                                class="openRejectDetails inline-block text-sm font-semibold text-gray-700 dark:text-white bg-blue-100 dark:bg-gray-800 px-3 py-1 rounded"
                                                                data-id="{{ $prep->id }}">
                                                                Received on <br>
                                                                {{ \Carbon\Carbon::parse($prep->colourMatchReceiveDate)->format('Y-m-d') }}
                                                                at
                                                                {{ \Carbon\Carbon::parse($prep->colourMatchReceiveDate)->format('H:i') }}
                                                            </button>

                                                            @if (Auth::user()->role !== 'ADMIN' or Auth::user()->role === 'PRODUCTIONOFFICER')
                                                                {{-- Reject button (hidden for Admin) --}}
                                                                <form action="" method="POST">
                                                                    @csrf
                                                                    <input type="hidden" name="id"
                                                                        value="{{ $prep->id }}">
                                                                    <button type="button"
                                                                        class="reject-btn mt-3 px-3 py-1 text-white bg-red-500 hover:bg-red-600 rounded text-sm
                                                                        {{ $prep->alreadyDeveloped ? 'cursor-not-allowed bg-red-300 hover:bg-red-300' : '' }}"
                                                                        @if ($prep->alreadyDeveloped) disabled @endif
                                                                        title="{{ $prep->alreadyDeveloped ? 'You cannot reject after development selection' : '' }}"
                                                                        onclick="openRejectModal({{ $prep->id }})">
                                                                        Reject
                                                                    </button>
                                                                </form>
                                                            @endif
                                                        </div>
                                                    @endif
                                                </td>

                                                <td
                                                    class="px-4 py-3 whitespace-normal break-words border-r border-gray-300">
                                                    <div x-data="{
                                                        openDropdown: false,
                                                        openModal: false,
                                                        selectedStatus: '{{ $prep->alreadyDeveloped ?? 'Select Development' }}',
                                                        id: {{ $prep->id }},
                                                        setStatus(status) {
                                                            if (status === 'Tape Match Pan Asia') {
                                                                // Open modal instead of submitting form immediately
                                                                this.openModal = true;
                                                                this.openDropdown = false;
                                                            } else {
                                                                this.selectedStatus = status;
                                                                // Submit the form for other statuses
                                                                this.$refs.formAlreadyDevelopedInput.value = status;
                                                                this.$refs.form.submit();
                                                            }
                                                        },
                                                        toggleDropdown() {
                                                            this.openDropdown = !this.openDropdown;
                                                        }
                                                    }" class="relative inline-block text-left"
                                                        @click.away="openDropdown = false; openModal = false">

                                                        @if ($prep->alreadyDeveloped == null)
                                                            {{-- Form for Need to Develop or No Need to Develop --}}
                                                            <form method="POST"
                                                                action="{{ route('rnd.updateDevelopedStatus') }}"
                                                                x-ref="form">
                                                                @csrf
                                                                <input type="hidden" name="id"
                                                                    value="{{ $prep->id }}">
                                                                <input type="hidden" name="alreadyDeveloped"
                                                                    x-ref="formAlreadyDevelopedInput"
                                                                    value="Need to Develop">

                                                                @if (Auth::user()->role === 'ADMIN' or Auth::user()->role === 'PRODUCTIONOFFICER')
                                                                    {{-- Read-only for ADMIN --}}
                                                                    <div class="inline-flex justify-between w-48 rounded-md px-3 py-2 text-sm font-semibold
                                                                                 text-gray-500 bg-gray-200 shadow-sm h-10 cursor-not-allowed"
                                                                        title="Admins cannot update Developed Status">
                                                                        {{ $prep->alreadyDeveloped ?? 'Select Development' }}
                                                                    </div>
                                                                @else
                                                                    {{-- Editable for non-admins --}}
                                                                    <!-- Dropdown Button -->
                                                                    <button type="button"
                                                                        class="inline-flex justify-between w-48 rounded-md px-3 py-2 text-sm font-semibold
                                                                        h-10 transition-all duration-200
                                                                        {{ is_null($prep->colourMatchReceiveDate) ? 'bg-gray-200 text-gray-500 cursor-not-allowed' : 'bg-white text-gray-900 shadow-sm ring-1 ring-gray-300 hover:bg-gray-50' }}"
                                                                        @click="!{{ is_null($prep->colourMatchReceiveDate) ? 'true' : 'false' }} && toggleDropdown()"
                                                                        :disabled="{{ is_null($prep->colourMatchReceiveDate) ? 'true' : 'false' }}"
                                                                        title="{{ is_null($prep->colourMatchReceiveDate) ? 'Complete Colour Match Receive first' : '' }}">
                                                                        <span x-text="selectedStatus"></span>
                                                                        <svg class="ml-2 h-5 w-5 text-gray-400"
                                                                            viewBox="0 0 20 20" fill="currentColor"
                                                                            aria-hidden="true">
                                                                            <path fill-rule="evenodd"
                                                                                d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 10.94l3.71-3.71a.75.75 0 1 1 1.06 1.06l-4.24 4.24a.75.75 0 0 1-1.06 0L5.25 8.29a.75.75 0 0 1-.02-1.08z"
                                                                                clip-rule="evenodd" />
                                                                        </svg>
                                                                    </button>

                                                                    <!-- Dropdown Menu -->
                                                                    <div x-show="openDropdown" x-transition
                                                                        class="absolute mt-2 w-48 rounded-md bg-white shadow-lg ring-1 ring-black/5 z-10"
                                                                        style="display: none;">
                                                                        <div class="py-1">
                                                                            <button type="button"
                                                                                @click.prevent="setStatus('Need to Develop')"
                                                                                class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                                                Need to Develop
                                                                            </button>
                                                                            <button type="button"
                                                                                @click.prevent="setStatus('No Need to Develop')"
                                                                                class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                                                No Need to Develop
                                                                            </button>
                                                                            <button type="button"
                                                                                @click.prevent="setStatus('Tape Match Pan Asia')"
                                                                                class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                                                Tape Match Pan Asia
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            </form>

                                                            {{-- Modal for Tape Match Pan Asia --}}
                                                            <div x-show="openModal" x-transition
                                                                class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
                                                                style="display: none;">
                                                                <div
                                                                    class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-full max-w-md relative">
                                                                    <button @click="openModal = false"
                                                                        class="absolute top-2 right-2 text-gray-600 hover:text-gray-900">✕</button>

                                                                    <h2
                                                                        class="text-lg font-semibold text-gray-800 dark:text-white mb-4">
                                                                        Additional Info for Tape Match Pan Asia
                                                                    </h2>

                                                                    {{-- Example form, you can add fields here as required --}}
                                                                    <form method="POST"
                                                                        action="{{ route('rnd.updateDevelopedStatus') }}">
                                                                        @csrf
                                                                        <input type="hidden" name="id"
                                                                            value="{{ $prep->id }}">
                                                                        <input type="hidden" name="alreadyDeveloped"
                                                                            value="Tape Match Pan Asia">

                                                                        {{-- Add any extra inputs here if needed --}}
                                                                        <p
                                                                            class="mb-4 text-sm text-gray-600 dark:text-gray-300">
                                                                            Please confirm your Selection and add extra
                                                                            information.
                                                                        </p>

                                                                        {{-- Shade Input --}}
                                                                        <div class="mb-4">
                                                                            <label
                                                                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                                                Shade
                                                                            </label>
                                                                            <input type="text" name="shade"
                                                                                class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                                                required>

                                                                        </div>

                                                                        {{-- Ticket Input --}}
                                                                        <div class="mb-4">
                                                                            <label
                                                                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                                                Ticket Number
                                                                            </label>
                                                                            <input type="text" name="tkt"
                                                                                class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                                                required>
                                                                        </div>

                                                                        {{-- Supplier Input --}}
                                                                        <div class="mb-4">
                                                                            <label
                                                                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                                                Supplier
                                                                            </label>
                                                                            <input type="text" name="yarnSupplier"
                                                                                value="Pan Asia" readonly
                                                                                class="w-full px-3 py-2 border rounded-md bg-gray-100 dark:bg-gray-700 dark:text-white text-sm cursor-not-allowed"
                                                                                required>
                                                                        </div>

                                                                        <div class="flex justify-end gap-3">
                                                                            <button type="button"
                                                                                @click="openModal = false"
                                                                                class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">
                                                                                Cancel
                                                                            </button>
                                                                            <button type="submit"
                                                                                class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                                                                                Confirm
                                                                            </button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        @else
                                                            {{-- Show locked status --}}
                                                            <div
                                                                class="inline-flex items-center w-48 rounded-md bg-gray-200 px-3 py-2 text-sm font-semibold text-gray-500 shadow-inner h-10">
                                                                {{ $prep->alreadyDeveloped }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </td>

                                                <td class="px-4 py-3 text-center border-r border-gray-300 break-words">
                                                    @if (Auth::user()->role === 'ADMIN' or Auth::user()->role === 'PRODUCTIONOFFICER')
                                                        {{-- Read-only for ADMIN --}}
                                                        @if ($prep->alreadyDeveloped == 'Need to Develop')
                                                            @if ($prep->developPlannedDate)
                                                                <span class="readonly">
                                                                    {{ \Carbon\Carbon::parse($prep->developPlannedDate)->format('Y-m-d') }}
                                                                </span>
                                                            @else
                                                                <span
                                                                    class="inline-block px-3 py-1 text-xs font-semibold text-gray-600 bg-gray-200 rounded">
                                                                    Not Set
                                                                </span>
                                                            @endif
                                                        @elseif (in_array($prep->alreadyDeveloped, ['No Need to Develop', 'Tape Match Pan Asia']))
                                                            <span class="text-gray-400 italic">—</span>
                                                        @else
                                                            <span
                                                                class="inline-block px-3 py-1 text-xs font-semibold text-gray-600 bg-gray-200 rounded">
                                                                Not Set
                                                            </span>
                                                        @endif
                                                    @else
                                                        {{-- Editable for non-admins --}}
                                                        @if ($prep->alreadyDeveloped == 'Need to Develop')
                                                            @if (!$prep->developPlannedDate)
                                                                {{-- Show input if not set --}}
                                                                <form action="{{ route('rnd.setDevelopPlanDate') }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    <input type="hidden" name="id"
                                                                        value="{{ $prep->id }}">
                                                                    <input type="date" name="developPlannedDate"
                                                                        class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                                        required>
                                                                    <button type="submit"
                                                                        class="w-full mt-1 bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm">
                                                                        Save
                                                                    </button>
                                                                </form>
                                                            @else
                                                                {{-- Locked and readonly --}}
                                                                <span class="readonly">
                                                                    {{ \Carbon\Carbon::parse($prep->developPlannedDate)->format('Y-m-d') }}
                                                                </span>
                                                            @endif
                                                        @elseif (in_array($prep->alreadyDeveloped, ['No Need to Develop', 'Tape Match Pan Asia']))
                                                            {{-- Not available for these statuses --}}
                                                            <span class="text-gray-400 italic">—</span>
                                                        @else
                                                            {{-- Disabled input and button --}}
                                                            <input type="date"
                                                                class="w-full px-3 py-2 border rounded-md bg-gray-100 text-gray-500 dark:bg-gray-800 dark:text-gray-400 text-sm"
                                                                disabled>
                                                            <button type="button"
                                                                class="w-full mt-1 bg-gray-300 text-gray-500 px-3 py-1 rounded text-sm cursor-not-allowed"
                                                                title="Only visible when status is 'Need to Develop'">
                                                                Save
                                                            </button>
                                                        @endif
                                                    @endif
                                                </td>

                                                <td
                                                    class="py-3 whitespace-normal break-words border-r border-gray-300 text-center">
                                                    @if (Auth::user()->role === 'ADMIN' || Auth::user()->role === 'PRODUCTIONOFFICER')
                                                        {{-- ADMIN: Read-only --}}
                                                        @if ($prep->alreadyDeveloped == 'Need to Develop')
                                                            @if ($prep->yarnOrderedDate)
                                                                <span
                                                                    class="inline-block m-1 text-sm font-semibold text-gray-700 dark:text-white bg-purple-200 dark:bg-gray-800 px-3 py-1 rounded">
                                                                    Ordered on <br>
                                                                    {{ \Carbon\Carbon::parse($prep->yarnOrderedDate)->format('Y-m-d') }}
                                                                    at
                                                                    {{ \Carbon\Carbon::parse($prep->yarnOrderedDate)->format('H:i') }}
                                                                </span>
                                                            @else
                                                                <span
                                                                    class="inline-block px-3 py-1 text-xs font-semibold text-gray-600 bg-gray-200 rounded">
                                                                    Not Ordered
                                                                </span>
                                                            @endif
                                                        @elseif(in_array($prep->alreadyDeveloped, ['No Need to Develop', 'Tape Match Pan Asia']))
                                                            <span class="text-gray-400 italic">—</span>
                                                        @else
                                                            <span
                                                                class="inline-block px-3 py-1 text-xs font-semibold text-gray-600 bg-gray-200 rounded">
                                                                Not Set
                                                            </span>
                                                        @endif
                                                    @else
                                                        {{-- Non-admin: Editable --}}
                                                        @if ($prep->alreadyDeveloped == 'Need to Develop')
                                                            @if (is_null($prep->yarnOrderedDate))
                                                                @php
                                                                    $canOrder =
                                                                        $prep->alreadyDeveloped ==
                                                                            'Tape Match Pan Asia' ||
                                                                        ($prep->alreadyDeveloped == 'Need to Develop' &&
                                                                            $prep->developPlannedDate);
                                                                @endphp

                                                                {{-- Alpine component --}}
                                                                <div x-data="{ open: false }" class="relative">
                                                                    {{-- Trigger Button --}}
                                                                    <button type="button"
                                                                        class="yarn-ordered-btn px-2 py-1 mt-3 rounded transition-all duration-200
                                                                            {{ $canOrder ? 'bg-gray-300 text-black hover:bg-gray-400' : 'bg-gray-200 text-gray-500 cursor-not-allowed' }}"
                                                                        @if ($canOrder) @click="open = true" @else disabled title="Please set Development Plan Date first" @endif>
                                                                        Pending
                                                                    </button>

                                                                    {{-- Modal --}}
                                                                    <div x-show="open" x-transition
                                                                        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
                                                                        style="display: none;">

                                                                        <div
                                                                            class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-md relative max-h-[90vh] overflow-y-auto p-8">
                                                                            {{-- Close button --}}
                                                                            <button @click="open = false"
                                                                                class="absolute top-2 right-2 text-gray-600 hover:text-gray-900">✕</button>

                                                                            {{-- Title --}}
                                                                            <h2
                                                                                class="text-lg font-semibold text-gray-800 dark:text-white mb-2 text-left">
                                                                                Mark Yarn Ordered
                                                                            </h2>

                                                                            <p
                                                                                class="mb-5 text-sm text-gray-600 dark:text-gray-300 text-left">
                                                                                Please provide the required details for the
                                                                                yarn order. All fields are mandatory.
                                                                            </p>

                                                                            {{-- Form --}}
                                                                            <form
                                                                                action="{{ route('rnd.markYarnOrdered') }}"
                                                                                method="POST">
                                                                                @csrf
                                                                                <input type="hidden" name="id"
                                                                                    value="{{ $prep->id }}">

                                                                                {{-- PO Number --}}
                                                                                <div class="mb-4">
                                                                                    <label
                                                                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 text-left">
                                                                                        PO Number
                                                                                    </label>
                                                                                    <input type="text"
                                                                                        name="yarnOrderedPONumber"
                                                                                        placeholder="Enter PO Number"
                                                                                        class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                                                </div>

                                                                                {{-- Number of Options --}}
                                                                                <div class="mb-4">
                                                                                    <label
                                                                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 text-left">
                                                                                        Number of Options
                                                                                    </label>

                                                                                    <div id="optionsWrapper"
                                                                                        class="space-y-2">
                                                                                        <div
                                                                                            class="flex items-center space-x-2">
                                                                                            <input type="text"
                                                                                                name="shades[]"
                                                                                                placeholder="Enter Shade"
                                                                                                class="flex-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                                                                required>
                                                                                            <button type="button"
                                                                                                onclick="removeOptionInput(this)"
                                                                                                class="text-blue-500 hover:text-blue-700">
                                                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                                                    fill="none"
                                                                                                    viewBox="0 0 24 24"
                                                                                                    stroke-width="2"
                                                                                                    stroke="currentColor"
                                                                                                    class="w-5 h-5">
                                                                                                    <path
                                                                                                        stroke-linecap="round"
                                                                                                        stroke-linejoin="round"
                                                                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0
                         01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0
                         011-1h4a1 1 0 011 1v3m-9 0h10" />
                                                                                                </svg>
                                                                                            </button>

                                                                                        </div>
                                                                                    </div>

                                                                                    <button type="button"
                                                                                        onclick="addOptionInput()"
                                                                                        class="mt-2 px-3 py-1 bg-blue-500 text-white rounded-md text-sm">
                                                                                        + Add Option
                                                                                    </button>
                                                                                </div>


                                                                                {{-- Weight --}}
                                                                                <div class="mb-4">
                                                                                    <label
                                                                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 text-left">
                                                                                        Weight (in grams)
                                                                                    </label>
                                                                                    <input type="number" step="0.01"
                                                                                        name="value"
                                                                                        placeholder="e.g. 150.50"
                                                                                        class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                                                </div>

                                                                                {{-- Ticket --}}
                                                                                <div class="mb-4">
                                                                                    <label
                                                                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 text-left">
                                                                                        Ticket Number
                                                                                    </label>
                                                                                    <input type="text" name="tkt"
                                                                                        placeholder="Enter Ticket Number"
                                                                                        class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                                                </div>

                                                                                {{-- Yarn Price --}}
                                                                                <div class="mb-4">
                                                                                    <label
                                                                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 text-left">
                                                                                        Yarn Price
                                                                                    </label>
                                                                                    <input type="text" name="yarnPrice"
                                                                                        placeholder="Enter Yarn Price"
                                                                                        class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                                                </div>

                                                                                {{-- Supplier --}}
                                                                                <div class="mb-6">
                                                                                    <label
                                                                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 text-left">
                                                                                        Supplier
                                                                                    </label>
                                                                                    <div class="relative inline-block w-full"
                                                                                        data-dropdown-root>
                                                                                        <!-- Trigger -->
                                                                                        <button type="button"
                                                                                            onclick="toggleDropdownItemAdd(this, 'supplier')"
                                                                                            class="w-full flex justify-between items-center px-4 py-2 border border-gray-300 rounded-md bg-white dark:bg-gray-700 text-sm text-gray-700 dark:text-white hover:bg-gray-50 focus:outline-none">
                                                                                            <span
                                                                                                class="selected-supplier">{{ old('yarnSupplier', 'Pan Asia') }}</span>
                                                                                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-300"
                                                                                                fill="none"
                                                                                                stroke="currentColor"
                                                                                                viewBox="0 0 24 24">
                                                                                                <path
                                                                                                    stroke-linecap="round"
                                                                                                    stroke-linejoin="round"
                                                                                                    stroke-width="2"
                                                                                                    d="M19 9l-7 7-7-7" />
                                                                                            </svg>
                                                                                        </button>

                                                                                        <!-- Dropdown Menu -->
                                                                                        <div
                                                                                            class="dropdown-menu-supplier hidden absolute z-10 mt-2 w-full rounded-md bg-white dark:bg-gray-700 shadow-lg ring-1 ring-black/5 max-h-48 overflow-y-auto">
                                                                                            <div class="py-1"
                                                                                                role="listbox"
                                                                                                tabindex="-1">
                                                                                                @foreach (['Pan Asia', 'Ocean Lanka', 'A and E', 'Metro Lanka', 'Stretchtec Stock', 'Other'] as $supplier)
                                                                                                    <button type="button"
                                                                                                        class="dropdown-option w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-600"
                                                                                                        onclick="selectDropdownOptionItemAdd(this, '{{ $supplier }}', 'supplier')">{{ $supplier }}</button>
                                                                                                @endforeach
                                                                                            </div>
                                                                                        </div>

                                                                                        <!-- Hidden input -->
                                                                                        <input type="hidden"
                                                                                            name="yarnSupplier"
                                                                                            class="input-supplier"
                                                                                            value="{{ old('yarnSupplier', 'Pan Asia') }}">

                                                                                        <!-- "Other" input field -->
                                                                                        <div
                                                                                            class="mt-4 hidden other-supplier-field">
                                                                                            <label
                                                                                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                                                                Please specify
                                                                                            </label>
                                                                                            <input type="text"
                                                                                                name="customSupplier"
                                                                                                placeholder="Enter Supplier Name"
                                                                                                class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm input-custom-supplier"
                                                                                                value="{{ old('customSupplier') }}"
                                                                                                @disabled(true)>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                {{-- Form Buttons --}}
                                                                                <div class="flex justify-end gap-3">
                                                                                    <button type="button"
                                                                                        @click="open = false"
                                                                                        class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400 transition">
                                                                                        Cancel
                                                                                    </button>
                                                                                    <button type="submit"
                                                                                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                                                                                        Save
                                                                                    </button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @else
                                                                {{-- Already Ordered --}}
                                                                <span
                                                                    class="inline-block m-1 text-sm font-semibold text-gray-700 dark:text-white bg-purple-200 dark:bg-gray-800 px-3 py-1 rounded">
                                                                    Ordered on <br>
                                                                    {{ \Carbon\Carbon::parse($prep->yarnOrderedDate)->format('Y-m-d') }}
                                                                    at
                                                                    {{ \Carbon\Carbon::parse($prep->yarnOrderedDate)->format('H:i') }}
                                                                </span>
                                                            @endif
                                                        @elseif(in_array($prep->alreadyDeveloped, ['No Need to Develop', 'Tape Match Pan Asia']))
                                                            <span class="text-gray-400 italic">—</span>
                                                        @else
                                                            <button type="button"
                                                                class="yarn-ordered-btn px-2 py-1 mt-3 rounded bg-gray-200 text-gray-500 cursor-not-allowed"
                                                                disabled title="Not applicable for this type">
                                                                Pending
                                                            </button>
                                                        @endif
                                                    @endif
                                                </td>



                                                <td class="px-4 py-3 border-r border-gray-300 text-center break-words">
                                                    @if ($prep->alreadyDeveloped == 'Need to Develop')
                                                        @if (!empty($prep->yarnOrderedPONumber))
                                                            {{-- Show saved PO Number --}}
                                                            <span
                                                                class="text-sm font-medium text-gray-800 dark:text-gray-200">
                                                                {{ $prep->yarnOrderedPONumber }}
                                                            </span>
                                                        @else
                                                            {{-- Not yet added --}}
                                                            <span
                                                                class="inline-block bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 text-sm font-medium px-3 py-1 rounded">
                                                                Not Added
                                                            </span>
                                                        @endif
                                                    @elseif($prep->alreadyDeveloped == 'Tape Match Pan Asia' || $prep->alreadyDeveloped == 'No Need to Develop')
                                                        {{-- PO not applicable --}}
                                                        <span class="text-gray-400 italic">—</span>
                                                    @else
                                                        {{-- Default fallback --}}
                                                        <span
                                                            class="inline-block bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 text-sm font-medium px-3 py-1 rounded">
                                                            Not Added
                                                        </span>
                                                    @endif
                                                </td>

                                                <td class="px-4 py-3 border-r border-gray-300 text-center break-words"
                                                    x-data="{ open: false }">
                                                    @if ($prep->shadeOrders->isNotEmpty())
                                                        {{-- Trigger button --}}
                                                        <button type="button" @click="open = true"
                                                            class="px-3 py-1 text-sm font-medium bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                                                            View Shades ({{ $prep->shadeOrders->count() }})
                                                        </button>

                                                        {{-- Modal --}}
                                                        <div x-show="open" x-transition
                                                            class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
                                                            style="display: none;">
                                                            <div
                                                                class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-full max-w-lg relative max-h-[80vh] overflow-y-auto">

                                                                {{-- Close button --}}
                                                                <button @click="open = false"
                                                                    class="absolute top-2 right-2 text-gray-600 hover:text-gray-900">✕</button>

                                                                {{-- Title --}}
                                                                <h2
                                                                    class="text-lg font-semibold text-blue-900 dark:text-white mb-4">
                                                                    Shades for Order #{{ $prep->orderNo }}
                                                                </h2>

                                                                {{-- Option cards --}}
                                                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                                                    @php
                                                                        $letters = range('A', 'Z');

                                                                        // Define status-to-color mapping
                                                                        $statusColors = [
                                                                            'In Production' =>
                                                                                'bg-yellow-100 text-yellow-800 dark:bg-yellow-700 dark:text-yellow-200',
                                                                            'Sent to Production' =>
                                                                                'bg-emerald-100 text-emerald-800 dark:bg-emerald-700 dark:text-emerald-200',
                                                                            'Yarn Received' =>
                                                                                'bg-pink-100 text-pink-800 dark:bg-pink-700 dark:text-pink-200',
                                                                            'Pending' =>
                                                                                'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200',
                                                                            'Order Delivered' =>
                                                                                'bg-blue-100 text-blue-800 dark:bg-blue-700 dark:text-blue-200',
                                                                        ];
                                                                    @endphp

                                                                    @foreach ($prep->shadeOrders as $index => $shade)
                                                                        @php
                                                                            $colorClass =
                                                                                $statusColors[$shade->status] ??
                                                                                'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200';
                                                                        @endphp

                                                                        <div
                                                                            class="border rounded-md p-4 {{ $colorClass }}">
                                                                            <div class="font-semibold mb-1">
                                                                                Option {{ $letters[$index] ?? $index + 1 }}
                                                                            </div>
                                                                            <div class="text-sm">
                                                                                <span
                                                                                    class="block mb-1"><strong>Shade:</strong>
                                                                                    {{ $shade->shade }}</span>
                                                                                <span
                                                                                    class="block"><strong>Status:</strong>
                                                                                    {{ $shade->status }}</span>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>

                                                            </div>
                                                        </div>
                                                    @elseif(in_array($prep->alreadyDeveloped, ['No Need to Develop']))
                                                        <span class="text-gray-400 italic">—</span>
                                                    @else
                                                        <span
                                                            class="inline-block bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 text-sm font-medium px-3 py-1 rounded">
                                                            Not Added
                                                        </span>
                                                    @endif
                                                </td>

                                                <!-- Yarn Ordered Weight -->
                                                <td class="px-4 py-3 border-r border-gray-300 text-center break-words">
                                                    @if (in_array($prep->alreadyDeveloped, ['Tape Match Pan Asia', 'No Need to Develop']))
                                                        {{-- Not available for these statuses --}}
                                                        <span class="text-gray-400 italic">—</span>
                                                    @elseif (!empty($prep->yarnOrderedWeight))
                                                        {{-- Show saved Yarn Ordered Weight --}}
                                                        <span class="text-sm font-medium text-gray-800 dark:text-gray-200">
                                                            {{ $prep->yarnOrderedWeight }} g
                                                        </span>
                                                    @else
                                                        {{-- Not yet added --}}
                                                        <span
                                                            class="inline-block bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 text-sm font-medium px-3 py-1 rounded">
                                                            Not Added
                                                        </span>
                                                    @endif
                                                </td>

                                                <td class="px-4 py-3 border-r border-gray-300 text-center break-words">
                                                    @if (!empty($prep->tkt))
                                                        {{-- Show saved TKT --}}
                                                        <span class="text-sm font-medium text-gray-800 dark:text-gray-200">
                                                            {{ $prep->tkt }}
                                                        </span>
                                                    @elseif(in_array($prep->alreadyDeveloped, ['No Need to Develop']))
                                                        {{-- Not available for these statuses --}}
                                                        <span class="text-gray-400 italic">—</span>
                                                    @else
                                                        {{-- Not yet added --}}
                                                        <span
                                                            class="inline-block bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 text-sm font-medium px-3 py-1 rounded">
                                                            Not Added
                                                        </span>
                                                    @endif
                                                </td>

                                                <td class="px-4 py-3 border-r border-gray-300 text-center break-words">
                                                    @if (!empty($prep->yarnSupplier))
                                                        {{-- Show saved Supplier --}}
                                                        <span class="text-sm font-medium text-gray-800 dark:text-gray-200">
                                                            {{ $prep->yarnSupplier }}
                                                        </span>
                                                    @elseif ($prep->alreadyDeveloped == 'No Need to Develop')
                                                        {{-- Not available for No Need to Develop --}}
                                                        <span class="text-gray-400 italic">—</span>
                                                    @else
                                                        {{-- Not yet added --}}
                                                        <span
                                                            class="inline-block bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 text-sm font-medium px-3 py-1 rounded">
                                                            Not Added
                                                        </span>
                                                    @endif
                                                </td>

                                                <td class="px-4 py-3 border-r border-gray-300 text-center break-words">
                                                    @if (!empty($prep->yarnPrice))
                                                        {{-- Show saved Supplier --}}
                                                        <span class="text-sm font-medium text-gray-800 dark:text-gray-200">
                                                            {{ $prep->yarnPrice }}
                                                        </span>
                                                    @elseif ($prep->alreadyDeveloped == 'No Need to Develop')
                                                        {{-- Not available for No Need to Develop --}}
                                                        <span class="text-gray-400 italic">—</span>
                                                    @else
                                                        {{-- Not yet added --}}
                                                        <span
                                                            class="inline-block bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 text-sm font-medium px-3 py-1 rounded">
                                                            Not Added
                                                        </span>
                                                    @endif
                                                </td>

                                                {{-- Yarn Receive Date --}}
                                                <td class="py-3 whitespace-normal break-words border-r border-gray-300 text-center"
                                                    x-data="{ open: false }">
                                                    @php
                                                        $pendingYarns = $prep->shadeOrders->where('status', 'Pending');
                                                        $receivedYarns = $prep->shadeOrders->where(
                                                            'status',
                                                            'Yarn Received',
                                                        );
                                                    @endphp

                                                    @if ($prep->alreadyDeveloped == 'Need to Develop')
                                                        @if ($pendingYarns->isNotEmpty())
                                                            <button type="button" @click="open = true"
                                                                class="px-2 py-1 mt-3 rounded transition-all duration-200 bg-gray-300 text-black hover:bg-gray-400">
                                                                Pending ({{ $pendingYarns->count() }})
                                                            </button>

                                                            {{-- Modal --}}
                                                            <div x-show="open" x-transition
                                                                class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
                                                                style="display:none;">
                                                                <div
                                                                    class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-full max-w-lg relative max-h-[80vh] overflow-y-auto">
                                                                    <button @click="open = false"
                                                                        class="absolute top-2 right-2 text-gray-600 hover:text-gray-900">✕</button>

                                                                    <h2
                                                                        class="text-lg font-semibold text-blue-900 dark:text-white mb-4">
                                                                        Mark Yarn Received</h2>
                                                                    <form action="{{ route('rnd.markYarnReceived') }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        <input type="hidden" name="rnd_id"
                                                                            value="{{ $prep->id }}">

                                                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                                                            @foreach ($pendingYarns as $shade)
                                                                                <div
                                                                                    class="p-4 border rounded bg-gray-100 dark:bg-gray-700">
                                                                                    <label class="flex items-start gap-2">
                                                                                        <input type="checkbox"
                                                                                            name="shade_ids[]"
                                                                                            value="{{ $shade->id }}"
                                                                                            class="mt-1">
                                                                                        <div>
                                                                                            <div class="font-semibold">
                                                                                                Shade: {{ $shade->shade }}
                                                                                            </div>
                                                                                        </div>
                                                                                    </label>

                                                                                    {{-- PST input only for Pan Asia --}}
                                                                                    @if ($prep->yarnSupplier === 'Pan Asia')
                                                                                        <input type="text"
                                                                                            name="pst_no[{{ $shade->id }}]"
                                                                                            placeholder="Enter PA/ST No"
                                                                                            class="mt-2 w-full px-2 py-1 border rounded text-sm dark:bg-gray-700 dark:text-white">
                                                                                    @endif
                                                                                </div>
                                                                            @endforeach
                                                                        </div>

                                                                        <div class="mt-4 flex justify-end gap-2">
                                                                            <button type="button" @click="open = false"
                                                                                class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">
                                                                                Cancel
                                                                            </button>
                                                                            <button type="submit"
                                                                                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                                                                Save
                                                                            </button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        @else
                                                            {{-- All shades received: show date & time --}}
                                                            <span
                                                                class="inline-block m-1 text-sm font-semibold text-gray-700 dark:text-white bg-pink-200 dark:bg-gray-800 px-3 py-1 rounded">
                                                                Received on <br>
                                                                {{ \Carbon\Carbon::parse($prep->yarnReceiveDate)->format('Y-m-d') }}
                                                                at
                                                                {{ \Carbon\Carbon::parse($prep->yarnReceiveDate)->format('H:i') }}
                                                            </span>
                                                        @endif
                                                    @else
                                                        <span class="text-gray-400 italic">—</span>
                                                    @endif
                                                </td>

                                                <td class="px-4 py-3 border-r border-gray-300 text-center break-words">
                                                    @if (Auth::user()->role === 'ADMIN' or Auth::user()->role === 'PRODUCTIONOFFICER')
                                                        {{-- ADMIN/PRODUCTION OFFICER: Read-only --}}
                                                        @if ($prep->alreadyDeveloped == 'Need to Develop')
                                                            @if (!$prep->is_deadline_locked)
                                                                <span
                                                                    class="inline-block bg-gray-200 dark:bg-gray-600 text-gray-500 dark:text-gray-400 text-sm font-medium px-3 py-1 rounded cursor-not-allowed"
                                                                    title="Admin view only">
                                                                    {{ $prep->productionDeadline?->format('Y-m-d') ?? 'Pending' }}
                                                                </span>
                                                            @else
                                                                <span class="readonly">
                                                                    {{ $prep->productionDeadline?->format('Y-m-d') ?? '-' }}
                                                                </span>
                                                            @endif
                                                        @else
                                                            <span class="text-gray-400 italic">—</span>
                                                        @endif
                                                    @else
                                                        {{-- Other Roles: Editable --}}
                                                        @if ($prep->alreadyDeveloped == 'Need to Develop')
                                                            @if (!$prep->is_deadline_locked)
                                                                <form action="{{ route('rnd.lockDeadlineField') }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    <input type="hidden" name="id"
                                                                        value="{{ $prep->id }}">
                                                                    <input type="date" name="productionDeadline"
                                                                        value="{{ $prep->productionDeadline?->format('Y-m-d') }}"
                                                                        class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                                        required>

                                                                    <button type="submit"
                                                                        class="w-full mt-1 px-3 py-1 rounded text-sm transition-all duration-200
                                                                            {{ $prep->developPlannedDate && $prep->yarnReceiveDate
                                                                                ? 'bg-blue-600 hover:bg-blue-700 text-white'
                                                                                : 'bg-gray-300 text-gray-500 cursor-not-allowed' }}"
                                                                        {{ $prep->developPlannedDate && $prep->yarnReceiveDate ? '' : 'disabled' }}
                                                                        title="{{ $prep->developPlannedDate && $prep->yarnReceiveDate ? '' : 'Please set Develop Plan Date & Yarn Received first' }}">
                                                                        Save
                                                                    </button>
                                                                </form>
                                                            @else
                                                                <span class="readonly">
                                                                    {{ $prep->productionDeadline?->format('Y-m-d') ?? '-' }}
                                                                </span>
                                                            @endif
                                                        @else
                                                            <span class="text-gray-400 italic">—</span>
                                                        @endif
                                                    @endif
                                                </td>

                                                <td class="py-3 whitespace-normal break-words border-r border-gray-300 text-center"
                                                    x-data="{ open: false, selectedShades: [] }">
                                                    @php
                                                        $pendingShades = $prep->shadeOrders->where(
                                                            'status',
                                                            'Yarn Received',
                                                        );
                                                    @endphp

                                                    @if ($prep->alreadyDeveloped == 'Need to Develop')
                                                        @if ($pendingShades->isNotEmpty())
                                                            {{-- Show Pending Button --}}
                                                            <button type="button"
                                                                    @click="open = true; selectedShades = []"
                                                                    class="send-production-btn px-2 py-1 mt-3 rounded transition-all duration-200
                                                                    {{ $prep->developPlannedDate && $prep->productionDeadline ? 'bg-gray-300 text-black hover:bg-gray-400' : 'bg-gray-200 text-gray-500 cursor-not-allowed' }}"
                                                                    {{ $prep->developPlannedDate && $prep->productionDeadline ? '' : 'disabled' }}
                                                                    title="{{ $prep->developPlannedDate && $prep->productionDeadline ? '' : 'Please set Development Plan & Production Deadline Date first' }}">
                                                                Pending ({{ $pendingShades->count() }})
                                                            </button>

                                                            {{-- Modal --}}
                                                            <div x-show="open" x-transition
                                                                class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
                                                                style="display:none;">
                                                                <div
                                                                    class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-full max-w-lg relative max-h-[80vh] overflow-y-auto">

                                                                    {{-- Close --}}
                                                                    <button @click="open = false"
                                                                        class="absolute top-2 right-2 text-gray-600 hover:text-gray-900">✕</button>

                                                                    <h2
                                                                        class="text-lg font-semibold text-gray-800 dark:text-white mb-4">
                                                                        Select Shades to Send to Production
                                                                    </h2>

                                                                    {{-- Shades --}}
                                                                    <form
                                                                        action="{{ route('rnd.markSendToProduction') }}"
                                                                        method="POST" @submit.prevent="$el.submit()">
                                                                        @csrf
                                                                        <input type="hidden" name="rnd_id"
                                                                            value="{{ $prep->id }}">
                                                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                                                            @php $letters = range('A', 'Z'); @endphp
                                                                            @foreach ($pendingShades as $index => $shade)
                                                                                <label
                                                                                    class="border rounded-md p-4 bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 cursor-pointer flex flex-col">
                                                                                    <div class="font-semibold mb-1">Option
                                                                                        {{ $letters[$index] ?? $index + 1 }}
                                                                                    </div>
                                                                                    <div class="text-sm mb-2">
                                                                                        <span
                                                                                            class="block mb-1"><strong>Shade:</strong>
                                                                                            {{ $shade->shade }}</span>
                                                                                        <span
                                                                                            class="block"><strong>Status:</strong>
                                                                                            {{ $shade->status }}</span>
                                                                                    </div>
                                                                                    <input type="checkbox"
                                                                                        name="shade_ids[]"
                                                                                        value="{{ $shade->id }}"
                                                                                        x-model="selectedShades">
                                                                                </label>
                                                                            @endforeach
                                                                        </div>

                                                                        <div class="mt-4 flex justify-end gap-2">
                                                                            <button type="button" @click="open = false"
                                                                                class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400 transition">Cancel</button>

                                                                            <button type="submit"
                                                                                :disabled="selectedShades.length == 0"
                                                                                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition"
                                                                                x-text="selectedShades.length > 1 ? 'Send Selected' : 'Send to Production'">
                                                                                Send
                                                                            </button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        @elseif ($prep->sendOrderToProductionStatus)
                                                            {{-- Show Sent Only If Status is Actually Set --}}
                                                            <span
                                                                class="inline-block m-1 text-sm font-semibold text-gray-700 dark:text-white bg-orange-200 dark:bg-gray-800 px-3 py-1 rounded">
                                                                Sent on <br>
                                                                {{ \Carbon\Carbon::parse($prep->sendOrderToProductionStatus)->format('Y-m-d') }}
                                                                at
                                                                {{ \Carbon\Carbon::parse($prep->sendOrderToProductionStatus)->format('H:i') }}
                                                            </span>
                                                        @else
                                                            {{-- No Pending + Not Sent = Show Placeholder --}}
                                                            <span class="text-gray-400 italic">—</span>
                                                        @endif
                                                    @else
                                                        <span class="text-gray-400 italic">—</span>
                                                    @endif
                                                </td>


                                                {{-- Production Status --}}
                                                <td
                                                    class="px-4 py-3 whitespace-normal break-words border-r border-gray-300 text-center">
                                                    @php
                                                        $status = $prep->productionStatus;
                                                        $badgeClass = match ($status) {
                                                            'Pending'
                                                                => 'bg-blue-100 text-blue-800 dark:bg-blue-700 dark:text-white',
                                                            'In Production'
                                                                => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-700 dark:text-white',
                                                            'Production Complete'
                                                                => 'bg-green-100 text-green-800 dark:bg-green-700 dark:text-white',
                                                            'Order Delivered'
                                                                => 'bg-green-500 text-white dark:bg-green-700 dark:text-white',
                                                            'Tape Match'
                                                                => 'bg-purple-100 text-purple-800 dark:bg-purple-700 dark:text-white',
                                                            'No Development'
                                                                => 'bg-red-100 text-red-800 dark:bg-red-700 dark:text-white',
                                                            'Yarn Ordered'
                                                                => 'bg-orange-100 text-orange-800 dark:bg-orange-700 dark:text-white',
                                                            'Yarn Received'
                                                                => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-700 dark:text-white',
                                                            'Sent to Production'
                                                                => 'bg-teal-100 text-teal-800 dark:bg-teal-700 dark:text-white',
                                                            'Colour Match Sent'
                                                                => 'bg-pink-100 text-pink-800 dark:bg-pink-700 dark:text-white',
                                                            'Colour Match Received'
                                                                => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-700 dark:text-white',
                                                            default
                                                                => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-white',
                                                        };
                                                    @endphp

                                                    <!-- Read-only badge -->
                                                    <span
                                                        class="readonly inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $badgeClass }}">
                                                        {{ $status }}
                                                    </span>

                                                    <!-- Editable input field (hidden by default, shown in edit mode) -->
                                                    <input type="text" name="productionStatus"
                                                        class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                        value="{{ $status }}" />
                                                </td>

                                                <td
                                                    class="px-4 py-3 whitespace-normal break-words border-r border-gray-300 text-center">
                                                    @if ($prep->alreadyDeveloped == 'Need to Develop')
                                                        @if ($prep->production && is_numeric($prep->production->production_output))
                                                            <span class="readonly">
                                                                {{ $prep->production->production_output }} g
                                                            </span>
                                                            <input
                                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                                value="{{ $prep->production->production_output }} g" />
                                                        @else
                                                            <span class="text-gray-400 italic">Pending output</span>
                                                        @endif
                                                    @else
                                                        <span class="text-gray-400 italic">—</span>
                                                    @endif
                                                </td>

                                                <td
                                                    class="px-4 py-3 whitespace-normal break-words border-r border-gray-300 text-center">
                                                    @if ($prep->alreadyDeveloped == 'Need to Develop')
                                                        @if ($prep->production && is_numeric($prep->production->damaged_output))
                                                            <span class="readonly">
                                                                {{ $prep->production->damaged_output }} g
                                                            </span>
                                                            <input
                                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                                value="{{ $prep->production->damaged_output }} g" />
                                                        @else
                                                            <span class="text-gray-400 italic">Pending output</span>
                                                        @endif
                                                    @else
                                                        <span class="text-gray-400 italic">—</span>
                                                    @endif
                                                </td>

                                                {{-- Yarn Leftover Weight --}}
                                                <td class="px-4 py-3 border-r border-gray-300 text-center">
                                                    @if ($prep->alreadyDeveloped == 'Need to Develop')
                                                        @if (Auth::user()->role === 'ADMIN' or Auth::user()->role === 'PRODUCTIONOFFICER')
                                                            {{-- ADMIN/PRODUCTION OFFICER --}}
                                                            @if ($prep->is_yarn_leftover_weight_locked)
                                                                <span class="readonly">{{ $prep->yarnLeftoverWeight }} g</span>
                                                            @elseif ($prep->yarnLeftoverWeight)
                                                                <span class="inline-block bg-gray-200 dark:bg-gray-600 text-gray-500 dark:text-gray-400 text-sm font-medium px-3 py-1 rounded cursor-not-allowed"
                                                                      title="Admin view only">
                                                                      {{ $prep->yarnLeftoverWeight }} g
                                                                </span>
                                                            @else
                                                                <span class="inline-block bg-gray-200 dark:bg-gray-600 text-gray-500 dark:text-gray-400 text-sm font-medium px-3 py-1 rounded cursor-not-allowed"
                                                                      title="Admin view only">
                                                                      Not Provided
                                                                </span>
                                                            @endif
                                                        @else
                                                            {{-- Non-Admin Users --}}
                                                            @php
                                                                $canSave = $prep->production &&
                                                                           is_numeric($prep->production->production_output) &&
                                                                           is_numeric($prep->production->damaged_output);

                                                                $shades = array_map('trim', explode(',', $prep->shade));
                                                                $weights = $prep->yarnLeftoverWeight ? explode(',', $prep->yarnLeftoverWeight) : [];
                                                            @endphp

                                                            @if (!$prep->is_yarn_leftover_weight_locked)
                                                                {{-- Editable form --}}
                                                                <form action="{{ route('rnd.updateYarnWeights') }}" method="POST">
                                                                    @csrf
                                                                    <input type="hidden" name="id" value="{{ $prep->id }}">
                                                                    <input type="hidden" name="field" value="yarnLeftoverWeight">

                                                                    @foreach ($shades as $index => $shade)
                                                                        <div class="mb-2">
                                                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                                                Shade: {{ $shade }}
                                                                            </label>
                                                                            <input type="number" step="0.01" min="0"
                                                                                   name="value[]"
                                                                                   value="{{ $weights[$index] ?? '' }}"
                                                                                   class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                                                   required>
                                                                        </div>
                                                                    @endforeach

                                                                    <button type="submit"
                                                                            class="w-full mt-1 px-3 py-1 rounded text-sm transition-all duration-200
                                                                            {{ $canSave ? 'bg-blue-600 hover:bg-blue-700 text-white' : 'bg-gray-300 text-gray-500 cursor-not-allowed' }}"
                                                                            {{ $canSave ? '' : 'disabled' }}
                                                                            title="{{ $canSave ? '' : 'Production Output and Damaged Output are required' }}">
                                                                        Save
                                                                    </button>
                                                                </form>
                                                            @else
                                                                {{-- Locked - readonly --}}
                                                                <span class="readonly">{{ $prep->yarnLeftoverWeight }} g</span>
                                                            @endif
                                                        @endif
                                                    @else
                                                        <span class="text-gray-400 italic">—</span>
                                                    @endif
                                                </td>

                                                <td class="px-4 py-3 border-r border-gray-300 text-center">
                                                    @php
                                                        $dispatchRecord = $dispatchCheck->firstWhere(
                                                            'sample_preparation_rnd_id',
                                                            $prep->id,
                                                        );
                                                        $canEditReference = false;

                                                        if (
                                                            in_array($prep->alreadyDeveloped, [
                                                                'No Need to Develop',
                                                                'Tape Match Pan Asia',
                                                            ])
                                                        ) {
                                                            $canEditReference = true;
                                                        } elseif (
                                                            $prep->alreadyDeveloped === 'Need to Develop' &&
                                                            ($dispatchRecord?->dispatch_to_rnd_at ?? null) != null
                                                        ) {
                                                            $canEditReference = true;
                                                        }
                                                    @endphp

                                                    @if (Auth::user()->role === 'ADMIN' or Auth::user()->role === 'PRODUCTIONOFFICER')
                                                        {{-- ADMIN: Read-only --}}
                                                        @if ($prep->is_reference_locked)
                                                            <span class="readonly">{{ $prep->referenceNo }}</span>
                                                        @elseif ($canEditReference)
                                                            <span
                                                                class="inline-block bg-gray-200 dark:bg-gray-600 text-gray-500 dark:text-gray-400 text-sm font-medium px-3 py-1 rounded cursor-not-allowed"
                                                                title="Admin view only">
                                                                {{ $prep->referenceNo ?? 'Pending' }}
                                                            </span>
                                                        @else
                                                            <span
                                                                class="timestamp mt-1 text-xs text-red-500 dark:text-red-400">
                                                                Not Available Until Production is Completed
                                                            </span>
                                                        @endif
                                                    @else
                                                        {{-- Other Roles --}}
                                                        @if ($canEditReference && !$prep->is_reference_locked)
                                                            {{-- Editable form --}}
                                                            <form action="{{ route('rnd.lockReferenceField') }}"
                                                                method="POST">
                                                                @csrf
                                                                <input type="hidden" name="id"
                                                                    value="{{ $prep->id }}">

                                                                @if ($prep->alreadyDeveloped === 'No Need to Develop')
                                                                    <div class="relative inline-block text-left w-full">
                                                                        <button type="button"
                                                                            class="dropdown-btn inline-flex w-full justify-between rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-gray-300 hover:bg-gray-50"
                                                                            onclick="toggleDropdownRef(this, 'ref')">
                                                                            <span
                                                                                class="selected-ref">{{ $prep->referenceNo ?? 'Select Reference No' }}</span>
                                                                            <svg class="ml-2 h-5 w-5 text-gray-400"
                                                                                viewBox="0 0 20 20" fill="currentColor">
                                                                                <path fill-rule="evenodd"
                                                                                    d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 10.94l3.71-3.71a.75.75 0 1 1 1.06 1.06l-4.24 4.24a.75.75 0 0 1-1.06 0L5.25 8.29a.75.75 0 0 1-.02-1.08z"
                                                                                    clip-rule="evenodd" />
                                                                            </svg>
                                                                        </button>

                                                                        <div
                                                                            class="dropdown-menu-ref hidden absolute z-10 mt-2 w-full rounded-md bg-white shadow-lg ring-1 ring-black/5 max-h-48 overflow-y-auto">
                                                                            <div class="p-2 sticky top-0 bg-white z-10">
                                                                                <input type="text"
                                                                                    placeholder="Search reference..."
                                                                                    class="w-full px-2 py-1 text-sm border rounded-md"
                                                                                    oninput="filterDropdownOptionsRef(this)" />
                                                                            </div>

                                                                            <div class="py-1" role="listbox"
                                                                                tabindex="-1">
                                                                                @foreach ($sampleStockReferences as $ref)
                                                                                    <button type="button"
                                                                                        class="dropdown-option w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                                                                        onclick="selectDropdownOptionRef(this, '{{ $ref }}', 'ref')">
                                                                                        {{ $ref }}
                                                                                    </button>
                                                                                @endforeach
                                                                            </div>
                                                                        </div>

                                                                        <input type="hidden" name="referenceNo"
                                                                            class="input-ref"
                                                                            value="{{ $prep->referenceNo }}">
                                                                    </div>
                                                                @else
                                                                    <input type="text" name="referenceNo"
                                                                        value="{{ $prep->referenceNo }}"
                                                                        class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                                        required>
                                                                @endif

                                                                <button type="submit"
                                                                    class="w-full mt-1 bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm">
                                                                    Save
                                                                </button>
                                                            </form>
                                                        @elseif ($prep->is_reference_locked)
                                                            {{-- Locked - Read-only --}}
                                                            <span class="readonly">{{ $prep->referenceNo }}</span>
                                                        @else
                                                            {{-- Not yet available --}}
                                                            <span
                                                                class="timestamp mt-1 text-xs text-red-500 dark:text-red-400">
                                                                Not Available Until Production is Completed
                                                            </span>
                                                        @endif
                                                    @endif
                                                </td>

                                                <!-- Notes -->
                                                <td
                                                    class="px-4 py-3 whitespace-normal break-words border-r border-gray-300 text-center">
                                                    @if (auth()->user()->role !== 'ADMIN' or Auth::user()->role === 'PRODUCTIONOFFICER')
                                                        <form
                                                            action="{{ route('sample-inquery-details.update-notes', $prep->sample_inquiry_id) }}"
                                                            method="POST" class="w-full">
                                                            @csrf
                                                            @method('PATCH')

                                                            <textarea name="notes"
                                                                class="w-full px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm" rows="2"
                                                                required>{{ old('notes', $prep->sampleInquiry->notes) }}</textarea>

                                                            <button type="submit"
                                                                class="w-full mt-1 px-2 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 transition-all duration-200 text-sm">
                                                                Save
                                                            </button>
                                                        </form>
                                                    @else
                                                        <span
                                                            class="readonly">{{ $prep->sampleInquiry->notes ?? 'N/D' }}</span>
                                                    @endif
                                                </td>

                                                <td class="px-4 py-3 whitespace-normal break-words text-center">
                                                    <div class="flex justify-center space-x-2">
                                                        {{-- <button
                                                            class="bg-green-600 h-10 px-3 py-1 rounded text-white text-sm hover:bg-green-700"
                                                            onclick="editRow('prodRow{{ $prep->id }}')">Edit</button>
                                                        <button
                                                            class="bg-blue-600 h-10 px-3 py-1 rounded text-white text-sm hover:bg-blue-700 hidden"
                                                            onclick="saveRow('prodRow{{ $prep->id }}')">Save</button> --}}
                                                        @if ($prep->sampleInquiry && $prep->sampleInquiry->orderFile)
                                                            <a href="{{ asset('storage/' . $prep->sampleInquiry->orderFile) }}"
                                                                target="_blank"
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

                                <div id="rejectDetailsModal"
                                    class="fixed inset-0 z-50 hidden overflow-y-auto bg-gray-900 bg-opacity-50 ">
                                    <div class="flex items-center justify-center min-h-screen px-4">
                                        <div
                                            class="relative w-full max-w-md p-10 overflow-y-auto bg-white rounded-lg shadow-lg dark:bg-gray-800 max-h-[80vh]">

                                            <!-- Close Button -->
                                            <button id="closeModal" aria-label="Close modal"
                                                class="absolute top-2 right-2 text-xl text-gray-500 transition hover:text-red-600 focus:outline-none">
                                                &times;
                                            </button>

                                            <!-- Modal Title -->
                                            <h2 class="mb-4 text-xl font-semibold text-gray-800 dark:text-white">
                                                Color Match Reject Details
                                            </h2>

                                            <!-- Modal Content -->
                                            <div id="rejectDetailsContent"
                                                class="text-sm text-gray-700 dark:text-gray-300">
                                                <!-- Content will be dynamically injected here -->
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Reject Reason Modal -->
                                <div id="rejectModal"
                                    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
                                    <div class="bg-white p-6 rounded-xl shadow-md w-96">
                                        <h2 class="text-lg font-semibold mb-4 text-blue-900">Reject Reason</h2>
                                        <form action="{{ route('colorMatchRejects.store') }}" method="POST"
                                            id="rejectForm">
                                            @csrf
                                            <input type="hidden" name="id" id="rejectOrderNo">
                                            <textarea name="rejectReason" id="rejectReason" rows="4" required
                                                class="w-full border border-gray-300 rounded p-2 mb-4" placeholder="Enter reason for rejection..."></textarea>
                                            <div class="flex justify-end gap-2 text-sm">
                                                <button type="button" onclick="closeRejectModal()"
                                                    class="px-3 py-1 bg-gray-300 hover:bg-gray-400 rounded">Cancel</button>
                                                <button type="submit"
                                                    class="px-3 py-1 bg-red-500 text-white hover:bg-red-700 rounded">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <!-- Sample R&D Details Modal -->
                                <div id="openRndSampleModal"
                                    class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center py-5"
                                    onclick="this.classList.add('hidden')">
                                    <div class="w-full max-w-[700px] bg-white dark:bg-gray-900 rounded-2xl shadow-2xl p-4 transform transition-all scale-95 max-h-[calc(100vh-10rem)] overflow-y-auto"
                                        onclick="event.stopPropagation()">

                                        <div class="max-w-[600px] mx-auto p-6">
                                            <h2 id="modalRndOrderNo"
                                                class="text-2xl font-semibold mb-6 text-blue-900 text-center">Order Number
                                            </h2>

                                            <table class="w-full text-left border border-gray-300 text-sm">
                                                <tbody>
                                                    <tr>
                                                        <th class="p-2 border">Customer</th>
                                                        <td class="p-2 border" id="modalCustomerName"></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="p-2 border">Coordinator Name</th>
                                                        <td class="p-2 border" id="modalCoordinatorName"></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="p-2 border">Item</th>
                                                        <td class="p-2 border" id="modalItem"></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="p-2 border">Item Description</th>
                                                        <td class="p-2 border" id="modalDescription"></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="p-2 border">Size</th>
                                                        <td class="p-2 border" id="modalSize"></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="p-2 border">QT Ref</th>
                                                        <td class="p-2 border" id="modalQTRef"></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="p-2 border">Color</th>
                                                        <td class="p-2 border" id="modalColor"></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="p-2 border">Style</th>
                                                        <td class="p-2 border" id="modalStyle"></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="p-2 border">Sample Qty</th>
                                                        <td class="p-2 border" id="modalSampleQty"></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="p-2 border">Customer Special Comment</th>
                                                        <td class="p-2 border" id="modalSpecialComment"></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="p-2 border">Customer Request Date</th>
                                                        <td class="p-2 border" id="modalRequestDate"></td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                            <div class="text-center mt-6">
                                                <button
                                                    onclick="document.getElementById('openRndSampleModal').classList.add('hidden')"
                                                    class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-md">
                                                    Close
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="py-6 flex justify-center">
                                {{ $samplePreparations->links() }}
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleDropdownItemAdd(button, type) {
            const root = button.closest('[data-dropdown-root]');
            const dropdownMenu = root.querySelector('.dropdown-menu-' + type);

            // Close other open menus of the same type
            document.querySelectorAll('.dropdown-menu-' + type).forEach(menu => {
                if (menu !== dropdownMenu) menu.classList.add('hidden');
            });

            dropdownMenu.classList.toggle('hidden');
        }

        function selectDropdownOptionItemAdd(button, selectedValue, type) {
            const root = button.closest('[data-dropdown-root]');
            root.querySelector('.selected-' + type).innerText = selectedValue;
            root.querySelector('.input-' + type).value = selectedValue;
            root.querySelector('.dropdown-menu-' + type).classList.add('hidden');

            const otherField = root.querySelector('.other-' + type + '-field');
            const customInput = root.querySelector('.input-custom-' + type) || root.querySelector('.input-custom-supplier');

            if (otherField) {
                if (selectedValue === 'Other') {
                    otherField.classList.remove('hidden');
                    if (customInput) {
                        customInput.removeAttribute('disabled');
                        customInput.setAttribute('required', 'required');
                        customInput.focus();
                    }
                } else {
                    otherField.classList.add('hidden');
                    if (customInput) {
                        customInput.setAttribute('disabled', 'disabled');
                        customInput.removeAttribute('required');
                        customInput.value = '';
                    }
                }
            }
        }

        // Click-outside handler: close any open menu when clicking outside its root
        document.addEventListener('click', function(event) {
            document.querySelectorAll('[class^="dropdown-menu-"]').forEach(menu => {
                const root = menu.closest('[data-dropdown-root]');
                if (root && !root.contains(event.target)) {
                    menu.classList.add('hidden');
                }
            });
        });
    </script>


    <script>
        // ===== ORDER dropdown =====
        function toggleOrderDropdown() {
            toggleDropdown('orderDropdown', 'orderDropdownMenu');
        }

        function selectOrder(orderNo) {
            selectDropdownValue('orderDropdown', 'orderDropdownMenu', 'selectedOrderNo', 'orderInput', orderNo,
                'Select Order No');
        }

        function filterOrders() {
            filterDropdown('.order-option', 'orderSearchInput');
        }

        // ===== PO dropdown =====
        function togglePODropdown() {
            toggleDropdown('poDropdown', 'poDropdownMenu');
        }

        function selectPO(poNo) {
            selectDropdownValue('poDropdown', 'poDropdownMenu', 'selectedPONo', 'poInput', poNo, 'Select PO No');
        }

        function filterPOs() {
            filterDropdown('.po-option', 'poSearchInput');
        }

        // ===== SHADE dropdown =====
        function toggleShadeDropdown() {
            toggleDropdown('shadeDropdown', 'shadeDropdownMenu');
        }

        function selectShade(shade) {
            selectDropdownValue('shadeDropdown', 'shadeDropdownMenu', 'selectedShade', 'shadeInput', shade, 'Select Shade');
        }

        function filterShades() {
            filterDropdown('.shade-option', 'shadeSearchInput');
        }

        // ===== REFERENCE NO dropdown =====
        function toggleRefDropdown() {
            toggleDropdown('refDropdown', 'refDropdownMenu');
        }

        function selectRef(ref) {
            selectDropdownValue('refDropdown', 'refDropdownMenu', 'selectedRef', 'refInput', ref, 'Select Reference No');
        }

        function filterRefs() {
            filterDropdown('.ref-option', 'refSearchInput');
        }

        // ===== COORDINATOR dropdown (NEW) =====
        function toggleCoordinatorDropdown() {
            toggleDropdown('coordinatorDropdown', 'coordinatorDropdownMenu');
        }

        function selectCoordinator(coordinator) {
            selectDropdownValue('coordinatorDropdown', 'coordinatorDropdownMenu', 'selectedCoordinator', 'coordinatorInput',
                coordinator, 'Select Coordinator');
        }

        function filterCoordinators() {
            filterDropdown('.coordinator-option', 'coordinatorSearchInput');
        }

        // ===== Helper functions =====
        function toggleDropdown(btnId, menuId) {
            const btn = document.getElementById(btnId);
            const menu = document.getElementById(menuId);
            const expanded = btn.getAttribute('aria-expanded') === 'true';

            menu.classList.toggle('hidden');
            btn.setAttribute('aria-expanded', !expanded);
        }

        function selectDropdownValue(btnId, menuId, selectedId, inputId, value, defaultText) {
            document.getElementById(selectedId).innerText = value || defaultText;
            document.getElementById(inputId).value = value;
            closeDropdown(btnId, menuId);
        }

        function filterDropdown(optionClass, inputId) {
            const input = document.getElementById(inputId).value.toLowerCase();
            const items = document.querySelectorAll(optionClass);

            items.forEach(item => {
                const text = item.textContent.toLowerCase();
                item.style.display = text.includes(input) ? 'block' : 'none';
            });
        }

        function closeDropdown(btnId, menuId) {
            const btn = document.getElementById(btnId);
            const menu = document.getElementById(menuId);
            menu.classList.add('hidden');
            btn.setAttribute('aria-expanded', false);
        }

        // ===== Clear all filters =====
        function clearFilters() {
            const dropdowns = [{
                    selected: 'selectedOrderNo',
                    input: 'orderInput',
                    search: 'orderSearchInput',
                    default: 'Select Order No',
                    filterFunc: filterOrders
                },
                {
                    selected: 'selectedPONo',
                    input: 'poInput',
                    search: 'poSearchInput',
                    default: 'Select PO No',
                    filterFunc: filterPOs
                },
                {
                    selected: 'selectedShade',
                    input: 'shadeInput',
                    search: 'shadeSearchInput',
                    default: 'Select Shade',
                    filterFunc: filterShades
                },
                {
                    selected: 'selectedRef',
                    input: 'refInput',
                    search: 'refSearchInput',
                    default: 'Select Reference No',
                    filterFunc: filterRefs
                },
                {
                    selected: 'selectedCoordinator',
                    input: 'coordinatorInput',
                    search: 'coordinatorSearchInput',
                    default: 'Select Coordinator',
                    filterFunc: filterCoordinators
                },
            ];

            dropdowns.forEach(d => {
                document.getElementById(d.selected).innerText = d.default;
                document.getElementById(d.input).value = '';
                document.getElementById(d.search).value = '';
                d.filterFunc();
            });

            // Clear dates
            document.getElementById('customerRequestedDate').value = '';
            document.getElementById('developmentPlanDate').value = '';
        }

        // ===== Close dropdowns if click outside =====
        document.addEventListener('click', function(e) {
            const dropdowns = [{
                    btn: 'orderDropdown',
                    menu: 'orderDropdownMenu'
                },
                {
                    btn: 'poDropdown',
                    menu: 'poDropdownMenu'
                },
                {
                    btn: 'shadeDropdown',
                    menu: 'shadeDropdownMenu'
                },
                {
                    btn: 'refDropdown',
                    menu: 'refDropdownMenu'
                },
                {
                    btn: 'coordinatorDropdown',
                    menu: 'coordinatorDropdownMenu'
                }, // new
            ];

            dropdowns.forEach(d => {
                const btn = document.getElementById(d.btn);
                const menu = document.getElementById(d.menu);

                if (!btn.contains(e.target) && !menu.contains(e.target)) {
                    closeDropdown(d.btn, d.menu);
                }
            });
        });
    </script>


    <script>
        function editRow(rowId) {
            const row = document.getElementById(rowId);
            const spans = row.querySelectorAll('span.readonly');
            const inputs = row.querySelectorAll('input.editable, textarea.editable');

            spans.forEach(s => s.classList.add('hidden'));
            inputs.forEach(i => i.classList.remove('hidden'));

            const editBtn = row.querySelector('button.bg-green-600');
            const saveBtn = row.querySelector('button.bg-blue-600');
            if (editBtn && saveBtn) {
                editBtn.classList.add('hidden');
                saveBtn.classList.remove('hidden');
            }
        }

        function saveRow(rowId) {
            const row = document.getElementById(rowId);
            const spans = row.querySelectorAll('span.readonly');
            const inputs = row.querySelectorAll('input.editable, textarea.editable');

            inputs.forEach((input, idx) => {
                spans[idx].textContent = input.value ?? input.innerText;
            });

            spans.forEach(s => s.classList.remove('hidden'));
            inputs.forEach(i => i.classList.add('hidden'));

            const editBtn = row.querySelector('button.bg-green-600');
            const saveBtn = row.querySelector('button.bg-blue-600');
            if (editBtn && saveBtn) {
                editBtn.classList.remove('hidden');
                saveBtn.classList.add('hidden');
            }
        }
    </script>

    <script>
        function toggleColourMatchSent(event, button) {
            const isPending = button.textContent.trim() === 'Pending';
            const container = button.closest('.colour-match-sent');
            const timestamp = container.querySelector('.timestamp');

            if (isPending) {
                // Mark as Done
                button.textContent = 'Done';
                button.classList.remove('bg-gray-300', 'text-black', 'hover:bg-gray-400');
                button.classList.add('bg-[#FF9119]', 'text-white', 'hover:bg-[#FF9119]/80');

                const now = new Date();
                timestamp.textContent = `Done on ${now.toLocaleDateString()} at ${now.toLocaleTimeString()}`;
            } else {
                // Revert to Pending
                button.textContent = 'Pending';
                button.classList.remove('bg-[#FF9119]', 'text-white', 'hover:bg-[#FF9119]/80');
                button.classList.add('bg-gray-300', 'text-black', 'hover:bg-gray-400');

                timestamp.textContent = '';
            }
        }
    </script>

    <script>
        function toggleColourMatchReceive(event, button) {
            const isPending = button.textContent.trim() === 'Pending';
            const container = button.closest('.colour-match-receive');
            const timestamp = container.querySelector('.receive-timestamp');

            if (isPending) {
                // Change to "Receive" with green color
                button.textContent = 'Receive';
                button.classList.remove('bg-gray-300', 'text-black', 'hover:bg-gray-400');
                button.classList.add('bg-green-500', 'text-white', 'hover:bg-green-600');

                const now = new Date();
                timestamp.textContent = `Received on ${now.toLocaleDateString()} at ${now.toLocaleTimeString()}`;
            } else {
                // Revert to "Pending" with gray color
                button.textContent = 'Pending';
                button.classList.remove('bg-green-500', 'text-white', 'hover:bg-green-600');
                button.classList.add('bg-gray-300', 'text-black', 'hover:bg-gray-400');

                timestamp.textContent = '';
            }
        }
    </script>

    <script>
        function toggleYarnOrdered(event, button) {
            const isPending = button.textContent.trim() === 'Pending';
            const container = button.closest('.yarn-ordered-item');
            const timestamp = container.querySelector('.yarn-timestamp');

            if (isPending) {
                // ✅ Set to "Ordered" with green color
                button.textContent = 'Ordered';
                button.classList.remove('bg-gray-300', 'text-black', 'hover:bg-gray-400');
                button.classList.add('bg-[#FF9119]', 'text-white', 'hover:bg-[#FF9119]/80');

                const now = new Date();
                timestamp.textContent = `Ordered on ${now.toLocaleDateString()} at ${now.toLocaleTimeString()}`;
            } else {
                // ✅ Set back to "Pending"
                button.textContent = 'Pending';
                button.classList.remove('bg-[#FF9119]', 'text-white', 'hover:bg-[#FF9119]/80');
                button.classList.add('bg-gray-300', 'text-black', 'hover:bg-gray-400');

                timestamp.textContent = '';
            }
        }
    </script>

    <script>
        function toggleYarnReceived(event, button) {
            const isPending = button.textContent.trim() === 'Pending';
            const container = button.closest('.yarn-receive-item');
            const timestamp = container.querySelector('.yarn-receive-timestamp');

            if (isPending) {
                // ✅ Change to "Received"
                button.textContent = 'Received';
                button.classList.remove('bg-gray-300', 'text-black', 'hover:bg-gray-400');
                button.classList.add('bg-green-500', 'text-white', 'hover:bg-green-600');

                const now = new Date();
                timestamp.textContent = `Received on ${now.toLocaleDateString()} at ${now.toLocaleTimeString()}`;
            } else {
                // ✅ Revert to "Pending"
                button.textContent = 'Pending';
                button.classList.remove('bg-green-500', 'text-white', 'hover:bg-green-600');
                button.classList.add('bg-gray-300', 'text-black', 'hover:bg-gray-400');

                timestamp.textContent = '';
            }
        }
    </script>

    <script>
        function toggleSendProduction(event, button) {
            const isPending = button.textContent.trim() === 'Pending';
            const container = button.closest('.send-production-item');
            const timestamp = container.querySelector('.send-production-timestamp');

            if (isPending) {
                // Change to Sent (green)
                button.textContent = 'Sent';
                button.classList.remove('bg-gray-300', 'text-black', 'hover:bg-gray-400');
                button.classList.add('bg-[#FF9119]', 'text-white', 'hover:bg-[#FF9119]/80');

                const now = new Date();
                timestamp.textContent = `Sent on ${now.toLocaleDateString()} at ${now.toLocaleTimeString()}`;
            } else {
                // Revert to Pending
                button.textContent = 'Pending';
                button.classList.remove('bg-[#FF9119]', 'text-white', 'hover:bg-[#FF9119]/80');
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
        function toggleDevelopedDropdown(event, id) {
            event.stopPropagation();
            document.querySelectorAll('[id^="alreadyDevelopedDropdownMenu"]').forEach(menu => menu.classList.add('hidden'));
            const dropdown = document.getElementById(`alreadyDevelopedDropdownMenu${id}`);
            dropdown.classList.toggle('hidden');
        }

        function setDevelopedStatus(id, statusText) {
            document.getElementById(`alreadyDevelopedInput${id}`).value = statusText;
            document.getElementById(`selectedAlreadyDeveloped${id}`).innerText = statusText;
        }

        document.addEventListener('click', function() {
            document.querySelectorAll('[id^="alreadyDevelopedDropdownMenu"]').forEach(menu => menu.classList.add(
                'hidden'));
        });
    </script>
    <script>
        function openRndSampleModal(orderNo, customerName, coordinatorName, item, description, size, qtRef, color, style,
            sampleQty,
            specialComment, requestDate) {
            document.getElementById('modalRndOrderNo').textContent = 'Order Number ' + orderNo;
            document.getElementById('modalCustomerName').textContent = customerName;
            document.getElementById('modalCoordinatorName').textContent = coordinatorName;
            document.getElementById('modalItem').textContent = item;
            document.getElementById('modalDescription').textContent = description;
            document.getElementById('modalSize').textContent = size;
            document.getElementById('modalQTRef').textContent = qtRef;
            document.getElementById('modalColor').textContent = color;
            document.getElementById('modalStyle').textContent = style;
            document.getElementById('modalSampleQty').textContent = sampleQty;
            document.getElementById('modalSpecialComment').textContent = specialComment;
            document.getElementById('modalRequestDate').textContent = requestDate;

            document.getElementById('openRndSampleModal').classList.remove('hidden');
        }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const tab2Filters = ['order', 'po', 'shade', 'ref'];

            // Toggle dropdowns
            tab2Filters.forEach(type => {
                const button = document.getElementById(`${type}Dropdown`);
                const menu = document.getElementById(`${type}DropdownMenu`);

                if (button && menu) {
                    button.addEventListener("click", (e) => {
                        e.stopPropagation();
                        closeAllDropdownsTab2();
                        menu.classList.toggle("hidden");
                        button.setAttribute("aria-expanded", !menu.classList.contains("hidden"));
                    });
                }
            });

            // Close dropdowns on outside click
            document.addEventListener("click", (e) => {
                tab2Filters.forEach(type => {
                    const menu = document.getElementById(`${type}DropdownMenu`);
                    const button = document.getElementById(`${type}Dropdown`);
                    if (menu && button && !menu.contains(e.target) && !button.contains(e.target)) {
                        menu.classList.add("hidden");
                        button.setAttribute("aria-expanded", "false");
                    }
                });
            });

            function closeAllDropdownsTab2() {
                tab2Filters.forEach(type => {
                    const menu = document.getElementById(`${type}DropdownMenu`);
                    const button = document.getElementById(`${type}Dropdown`);
                    if (menu && button) {
                        menu.classList.add("hidden");
                        button.setAttribute("aria-expanded", "false");
                    }
                });
            }
        });

        // Selection handlers
        function selectOrder(value) {
            document.getElementById("orderInput").value = value;
            document.getElementById("selectedOrderNo").textContent = value || "Select Order No";
            document.getElementById("orderDropdownMenu").classList.add("hidden");
        }

        function selectPO(value) {
            document.getElementById("poInput").value = value;
            document.getElementById("selectedPONo").textContent = value || "Select PO No";
            document.getElementById("poDropdownMenu").classList.add("hidden");
        }

        function selectShade(value) {
            document.getElementById("shadeInput").value = value;
            document.getElementById("selectedShade").textContent = value || "Select Shade";
            document.getElementById("shadeDropdownMenu").classList.add("hidden");
        }

        function selectRef(value) {
            document.getElementById("refInput").value = value;
            document.getElementById("selectedRef").textContent = value || "Select Reference No";
            document.getElementById("refDropdownMenu").classList.add("hidden");
        }

        // Search filters
        function filterOrders() {
            filterOptions('orderSearchInput', 'order-option');
        }

        function filterPOs() {
            filterOptions('poSearchInput', 'po-option');
        }

        function filterShades() {
            filterOptions('shadeSearchInput', 'shade-option');
        }

        function filterRefs() {
            filterOptions('refSearchInput', 'ref-option');
        }

        function filterOptions(inputId, optionClass) {
            const input = document.getElementById(inputId);
            const query = input.value.toLowerCase();
            const options = document.querySelectorAll(`.${optionClass}`);
            options.forEach(option => {
                option.style.display = option.textContent.toLowerCase().includes(query) ? "block" : "none";
            });
        }

        // Clear button handler
        function clearFilters() {
            const ids = ["orderInput", "poInput", "shadeInput", "refInput", "customerRequestedDate", "developmentPlanDate"];
            const labels = {
                orderInput: "Select Order No",
                poInput: "Select PO No",
                shadeInput: "Select Shade",
                refInput: "Select Reference No"
            };

            ids.forEach(id => {
                const el = document.getElementById(id);
                if (el) el.value = "";
            });

            Object.entries(labels).forEach(([id, label]) => {
                const spanId = id.replace("Input", "selected");
                const span = document.getElementById(spanId);
                if (span) span.textContent = label;
            });

            document.getElementById("filterForm2").submit();
        }
    </script>

    <script>
        document.getElementById('clearFiltersBtn').addEventListener('click', function() {
            // Reload the page to clear all filters and reset state
            window.location.href = window.location.pathname;
        });
    </script>
    <script>
        // Function to open modal and set orderNo dynamically
        function openRejectModal(orderNo) {
            document.getElementById('rejectOrderNo').value = orderNo;
            document.getElementById('rejectModal').classList.remove('hidden');
        }

        function closeRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('rejectDetailsModal');
            const modalContent = document.getElementById('rejectDetailsContent');
            const closeModal = document.getElementById('closeModal');

            document.querySelectorAll('.openRejectDetails').forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');

                    fetch(`/color-match-reject/${id}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                const sorted = data.rejects.sort((a, b) => new Date(b
                                    .rejectDate) - new Date(a.rejectDate));
                                const total = sorted.length;

                                const list = sorted.map((item, index) => {
                                    return `
                                    <div class="mb-4 border-b pb-2">
                                        <p><strong>#${total - index}</strong></p>
                                        <p><strong>Sent Date:</strong> ${item.sentDate}</p>
                                        <p><strong>Receive Date:</strong> ${item.receiveDate}</p>
                                        <p><strong>Reject Date:</strong> ${item.rejectDate}</p>
                                        <p><strong>Reject Reason:</strong> ${item.rejectReason}</p>
                                    </div>
                                `;
                                }).join('');

                                modalContent.innerHTML = `
                                <p class="font-semibold mb-2 text-sm text-gray-800 dark:text-white">
                                    Order No: ${data.orderNo}
                                </p>
                                ${list}
                            `;
                            } else {
                                modalContent.innerHTML =
                                    `<p class="text-red-500">${data.message}</p>`;
                            }

                            modal.classList.remove('hidden');
                        })
                        .catch(() => {
                            modalContent.innerHTML =
                                '<p class="text-red-500">Something went wrong.</p>';
                            modal.classList.remove('hidden');
                        });
                });
            });

            closeModal.addEventListener('click', () => {
                modal.classList.add('hidden');
            });
        });
    </script>
    <script>
        function toggleDropdownRef(button, type) {
            const dropdownMenu = button.nextElementSibling;
            document.querySelectorAll('.dropdown-menu-' + type).forEach(menu => {
                if (menu !== dropdownMenu) menu.classList.add('hidden');
            });
            dropdownMenu.classList.toggle('hidden');
        }

        function selectDropdownOptionRef(button, selectedValue, type) {
            const dropdown = button.closest('.relative');
            dropdown.querySelector('.selected-' + type).innerText = selectedValue;
            dropdown.querySelector('.input-' + type).value = selectedValue;
            dropdown.querySelector('.dropdown-menu-' + type).classList.add('hidden');
        }

        function filterDropdownOptionsRef(input) {
            const filter = input.value.toLowerCase();
            const options = input.closest('[class^="dropdown-menu-"]').querySelectorAll('.dropdown-option');
            options.forEach(option => {
                const text = option.textContent.toLowerCase();
                option.style.display = text.includes(filter) ? 'block' : 'none';
            });
        }

        document.addEventListener('click', function(event) {
            document.querySelectorAll('[class^="dropdown-menu-"]').forEach(menu => {
                if (!menu.contains(event.target) && !menu.previousElementSibling.contains(event.target)) {
                    menu.classList.add('hidden');
                }
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let container = document.getElementById("ResearchAndDevelopmentRecordsScroll");

            // Restore table scroll immediately after DOM loaded
            if (container) {
                let scrollTop = localStorage.getItem("tableScrollTop");
                let scrollLeft = localStorage.getItem("tableScrollLeft");
                if (scrollTop !== null) container.scrollTop = parseInt(scrollTop);
                if (scrollLeft !== null) container.scrollLeft = parseInt(scrollLeft);
                // Optionally clear
                localStorage.removeItem("tableScrollTop");
                localStorage.removeItem("tableScrollLeft");
            }

            // Save table scroll on form submit
            document.querySelectorAll("form").forEach(form => {
                form.addEventListener("submit", function() {
                    if (container) {
                        localStorage.setItem("tableScrollTop", container.scrollTop);
                        localStorage.setItem("tableScrollLeft", container.scrollLeft);
                    }
                });
            });
        });

        // Restore page scroll after full load (including images etc.)
        window.onload = function() {
            let pageScroll = localStorage.getItem("pageScrollY");
            if (pageScroll !== null) {
                window.scrollTo(0, parseInt(pageScroll));
                localStorage.removeItem("pageScrollY");
            }
        };

        // Save page scroll position before unload
        window.addEventListener("beforeunload", function() {
            localStorage.setItem("pageScrollY", window.scrollY);
        });
    </script>

    <script>
        function addOptionInput() {
            const wrapper = document.getElementById('optionsWrapper');

            // create container div
            const div = document.createElement('div');
            div.className = "flex items-center space-x-2";

            // create input
            const input = document.createElement('input');
            input.type = 'text';
            input.name = 'shades[]';
            input.placeholder = 'Enter Shade';
            input.className = 'flex-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm';
            input.required = true;

            // create delete button with SVG icon
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'text-blue-500 hover:text-blue-700';
            btn.innerHTML = `
        <svg xmlns="http://www.w3.org/2000/svg"
             fill="none"
             viewBox="0 0 24 24"
             stroke-width="2"
             stroke="currentColor"
             class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0
                     01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0
                     011-1h4a1 1 0 011 1v3m-9 0h10" />
        </svg>
    `;
            btn.onclick = function() {
                removeOptionInput(btn);
            };

            // append input and button to div
            div.appendChild(input);
            div.appendChild(btn);

            // append div to wrapper
            wrapper.appendChild(div);
        }

        function removeOptionInput(button) {
            button.parentElement.remove();
        }
    </script>

@endsection
