<head>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Include SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>StretchTec</title>
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
                                <form id="filterForm2" method="GET"
                                    action="{{ route('sample-preparation-details.index') }}">
                                    <div class="flex items-center gap-4 flex-wrap">

                                        {{-- Order No Dropdown --}}
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
                                                    placeholder="Search..." class="w-full px-2 py-1 text-sm border rounded-md dark:bg-gray-600 dark:text-white dark:placeholder-gray-300"
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

                                        {{-- PO No Dropdown --}}
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
                                                    placeholder="Search..." class="w-full px-2 py-1 text-sm border rounded-md dark:bg-gray-600 dark:text-white dark:placeholder-gray-300"
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

                                        {{-- Shade Dropdown --}}
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
                                                    placeholder="Search..." class="w-full px-2 py-1 text-sm border rounded-md dark:bg-gray-600 dark:text-white dark:placeholder-gray-300"
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

                                        {{-- Reference No Dropdown --}}
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
                                                    placeholder="Search..." class="w-full px-2 py-1 text-sm border rounded-md dark:bg-gray-600 dark:text-white dark:placeholder-gray-300"
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

                                        {{-- Date pickers --}}
                                        <div class="inline-block text-left w-48">
                                            <label for="customer_requested_date"
                                                class="block text-sm font-medium text-gray-700">Customer
                                                Requested Date</label>
                                            <input type="date" name="customer_requested_date"
                                                id="customerRequestedDate"
                                                value="{{ request('customer_requested_date') }}"
                                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 text-sm">
                                        </div>

                                        <div class="inline-block text-left w-48">
                                            <label for="development_plan_date"
                                                class="block text-sm font-medium text-gray-700">Development Plan
                                                Date</label>
                                            <input type="date" name="development_plan_date" id="developmentPlanDate"
                                                value="{{ request('development_plan_date') }}"
                                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 text-sm">
                                        </div>

                                        {{-- Buttons --}}
                                        <div class="flex items-end space-x-2 mt-2">
                                            <button type="submit"
                                                class="mt-4 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Apply Filters</button>
                                            <button type="button" onclick="clearFilters()"
                                                class="mt-4 bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-200 px-4 py-2 rounded hover:bg-gray-300">Clear</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="flex justify-between items-center mb-6">
                                <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Sample Preparation R & D
                                    Records
                                </h1>
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

                            <div class="overflow-x-auto bg-white dark:bg-gray-900 shadow rounded-lg">
                                <table class="table-fixed w-full text-sm divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead class="bg-gray-100 dark:bg-gray-700 text-left">
                                        <tr class="text-center">
                                            <th
                                                class="font-bold sticky left-0 z-30 bg-white px-4 py-3 w-32 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                Order No</th>
                                            <th
                                                class="font-bold px-4 py-3 w-32 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                Customer Requested Date</th>
                                            <th
                                                class="font-bold px-4 py-3 w-48 text-center text-xs font-medium uppercase text-gray-600 dark:text-gray-300 whitespace-normal break-words">
                                                Colour Match Sent Date</th>
                                            <th
                                                class="font-bold px-4 py-3 w-48 text-center text-xs font-medium uppercase text-gray-600 dark:text-gray-300 whitespace-normal break-words">
                                                Colour Match Receive Date</th>
                                            <th
                                                class="font-bold px-4 py-3 w-56 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                Already Developed & In Sample Stock</th>
                                            <th
                                                class="font-bold px-4 py-3 w-44 text-xs font-medium uppercase text-gray-600 dark:text-gray-300 whitespace-normal break-words">
                                                Development Plan Date</th>
                                            <th
                                                class="font-bold px-4 py-3 w-48 text-center text-xs font-medium uppercase text-gray-600 dark:text-gray-300 whitespace-normal break-words">
                                                Yarn Ordered Date</th>
                                            <th
                                                class="font-bold px-4 py-3 w-40 text-xs font-medium uppercase text-gray-600 dark:text-gray-300 whitespace-normal break-words">
                                                Yarn Ordered PO Number</th>
                                            <th
                                                class="font-bold px-4 py-3 w-40 text-xs font-medium uppercase text-gray-600 dark:text-gray-300 whitespace-normal break-words">
                                                Shade</th>
                                            <th
                                                class="font-bold px-4 py-3 w-40 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                Yarn Ordered Weight</th>
                                            <th
                                                class="font-bold px-4 py-3 w-40 text-xs font-medium uppercase text-gray-600 dark:text-gray-300 whitespace-normal break-words">
                                                Tkt</th>
                                            <th
                                                class="font-bold px-4 py-3 w-40 text-xs font-medium uppercase text-gray-600 dark:text-gray-300 whitespace-normal break-words">
                                                Yarn Supplier</th>
                                            <th
                                                class="font-bold px-4 py-3 w-48 text-center text-xs font-medium uppercase text-gray-600 dark:text-gray-300 whitespace-normal break-words">
                                                Yarn Receive Date</th>
                                            <th
                                                class="font-bold px-4 py-3 w-40 text-xs font-medium uppercase text-gray-600 dark:text-gray-300 whitespace-normal break-words">
                                                Production Deadline</th>
                                            <th
                                                class="font-bold px-4 py-3 w-48 text-center text-xs font-medium uppercase text-gray-600 dark:text-gray-300 whitespace-normal break-words">
                                                Send Order To Production Status</th>
                                            <th
                                                class="font-bold px-4 py-3 w-36 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                Production Status</th>
                                            <th
                                                class="font-bold px-4 py-3 w-48 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                Reference No</th>
                                            <th
                                                class="font-bold px-4 py-3 w-32 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                Production Output</th>
                                            <th
                                                class="font-bold px-4 py-3 w-32 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                Damaged Output</th>
                                            <th
                                                class="font-bold px-4 py-3 w-32 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                Yarn Leftover Weight</th>
                                            <th
                                                class="font-bold px-4 py-3 w-72 text-xs text-center font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                Note</th>
                                            <th
                                                class="font-bold px-4 py-3 w-48 text-xs font-medium uppercase text-gray-600 dark:text-gray-300 text-center whitespace-normal break-words">
                                                Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="sampleDevelopmentRecords"
                                        class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                        @foreach ($samplePreparations as $prep)
                                            <tr id="prodRow{{ $prep->id }}"
                                                class="odd:bg-white even:bg-gray-50 border-b border-gray-200  text-left">
                                                <td
                                                    class="sticky left-0 z-30 bg-white px-4 py-3 bg-gray-100 whitespace-normal break-words border-r border-gray-300">
                                                    <span
                                                        class="readonly font-bold hover:text-blue-600 hover:underline cursor-pointer"
                                                        onclick="openRndSampleModal(
                                                                    '{{ addslashes($prep->orderNo) }}',
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
                                                    class="px-4 py-3 whitespace-normal break-words border-r border-gray-300  text-center">
                                                    <span
                                                        class="readonly">{{ $prep->customerRequestDate->format('Y-m-d') }}</span>
                                                    <input type="date" name="customerRequestDate"
                                                        class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                        value="{{ $prep->customerRequestDate->format('Y-m-d') }}" />
                                                </td>

                                                {{-- Colour Match Sent Date --}}
                                                <td
                                                    class="text-center py-3 border-r border-gray-300 whitespace-normal break-words">
                                                    @if (is_null($prep->colourMatchSentDate))
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
                                                    @else
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
                                                    @else
                                                        <span
                                                            class="inline-block m-1 text-sm font-semibold text-gray-700 dark:text-white bg-blue-100 dark:bg-gray-800 px-3 py-1 rounded">
                                                            Received on <br>
                                                            {{ \Carbon\Carbon::parse($prep->colourMatchReceiveDate)->format('Y-m-d') }}
                                                            at
                                                            {{ \Carbon\Carbon::parse($prep->colourMatchReceiveDate)->format('H:i') }}
                                                        </span>
                                                    @endif
                                                </td>

                                                <td class="px-4 py-3 whitespace-normal break-words border-r border-gray-300">
                                                    <div x-data="{
            openDropdown: false,
            openModal: false,
            selectedStatus: '{{ $prep->alreadyDeveloped ?? 'Need to Develop' }}',
            id: {{ $prep->id }},
            setStatus(status) {
                if(status === 'Tape Match Pan Asia') {
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
        }"
                                                         class="relative inline-block text-left"
                                                         @click.away="openDropdown = false; openModal = false">

                                                        @if ($prep->alreadyDeveloped == null)
                                                            {{-- Form for Need to Develop or No Need to Develop --}}
                                                            <form method="POST" action="{{ route('rnd.updateDevelopedStatus') }}" x-ref="form">
                                                                @csrf
                                                                <input type="hidden" name="id" value="{{ $prep->id }}">
                                                                <input type="hidden" name="alreadyDeveloped" x-ref="formAlreadyDevelopedInput" value="Need to Develop">

                                                                <!-- Dropdown Button -->
                                                                <button type="button"
                                                                        class="inline-flex justify-between w-48 rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-gray-300 hover:bg-gray-50 h-10"
                                                                        @click="toggleDropdown()"
                                                                        aria-haspopup="true" aria-expanded="openDropdown">
                                                                    <span x-text="selectedStatus"></span>
                                                                    <svg class="ml-2 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                                        <path fill-rule="evenodd"
                                                                              d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 10.94l3.71-3.71a.75.75 0 1 1 1.06 1.06l-4.24 4.24a.75.75 0 0 1-1.06 0L5.25 8.29a.75.75 0 0 1-.02-1.08z"
                                                                              clip-rule="evenodd" />
                                                                    </svg>
                                                                </button>

                                                                <!-- Dropdown Menu -->
                                                                <div x-show="openDropdown" x-transition
                                                                     class="absolute mt-2 w-48 rounded-md bg-white shadow-lg ring-1 ring-black/5 z-20"
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
                                                            </form>

                                                            {{-- Modal for Tape Match Pan Asia --}}
                                                            <div x-show="openModal" x-transition
                                                                 class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
                                                                 style="display: none;">
                                                                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-full max-w-md relative">
                                                                    <button @click="openModal = false"
                                                                            class="absolute top-2 right-2 text-gray-600 hover:text-gray-900">✕</button>

                                                                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">
                                                                        Additional Info for Tape Match Pan Asia
                                                                    </h2>

                                                                    {{-- Example form, you can add fields here as required --}}
                                                                    <form method="POST" action="{{ route('rnd.updateDevelopedStatus') }}">
                                                                        @csrf
                                                                        <input type="hidden" name="id" value="{{ $prep->id }}">
                                                                        <input type="hidden" name="alreadyDeveloped" value="Tape Match Pan Asia">

                                                                        {{-- Add any extra inputs here if needed --}}
                                                                        <p class="mb-4 text-sm text-gray-600 dark:text-gray-300">
                                                                            Please confirm your Selection and add extra information.
                                                                        </p>

                                                                        {{-- Shade Input --}}
                                                                        <div class="mb-4">
                                                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                                                Shade
                                                                            </label>
                                                                            <input type="text" name="shade"
                                                                                   class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                                                   required>

                                                                        </div>

                                                                        {{-- Weight Input --}}
                                                                        <div class="mb-4">
                                                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                                                Weight
                                                                            </label>
                                                                            <input type="number" step="0.01" name="value"
                                                                                   class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                                                   required>
                                                                        </div>

                                                                        {{-- Ticket Input --}}
                                                                        <div class="mb-4">
                                                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                                                Ticket Number
                                                                            </label>
                                                                            <input type="number" name="tkt"
                                                                                   class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                                                   required>
                                                                        </div>

                                                                        {{-- Supplier Input --}}
                                                                        <div class="mb-4">
                                                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                                                Supplier
                                                                            </label>
                                                                            <input type="text" name="yarnSupplier"
                                                                                   value="Pan Asia"
                                                                                   readonly
                                                                                   class="w-full px-3 py-2 border rounded-md bg-gray-100 dark:bg-gray-700 dark:text-white text-sm cursor-not-allowed"
                                                                                   required>
                                                                        </div>

                                                                        <div class="flex justify-end gap-3">
                                                                            <button type="button" @click="openModal = false"
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
                                                            <div class="inline-flex items-center w-48 rounded-md bg-gray-200 px-3 py-2 text-sm font-semibold text-gray-500 shadow-inner h-10">
                                                                {{ $prep->alreadyDeveloped }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </td>

                                                <td class="px-4 py-3 text-center border-r border-gray-300">
                                                    @if ($prep->alreadyDeveloped == 'Need to Develop')
                                                        @if (!$prep->developPlannedDate)
                                                            {{-- Show input if not set --}}
                                                            <form action="{{ route('rnd.setDevelopPlanDate') }}" method="POST">
                                                                @csrf
                                                                <input type="hidden" name="id" value="{{ $prep->id }}">
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
                                                                {{ $prep->developPlannedDate->format('Y-m-d') }}
                                                            </span>
                                                        @endif
                                                    @elseif(in_array($prep->alreadyDeveloped, ['No Need to Develop', 'Tape Match Pan Asia']))
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
                                                </td>

                                                {{-- Yarn Ordered Date --}}
                                                <td class="py-3 whitespace-normal break-words border-r border-gray-300 text-center">
                                                    @if ($prep->alreadyDeveloped == 'Need to Develop')
                                                        @if (is_null($prep->yarnOrderedDate))
                                                            @php
                                                                $canOrder =
                                                                    $prep->alreadyDeveloped == 'Tape Match Pan Asia' ||
                                                                    ($prep->alreadyDeveloped == 'Need to Develop' && $prep->developPlannedDate);
                                                            @endphp

                                                            {{-- Wrap button + modal inside Alpine component --}}
                                                            <div x-data="{ open: false }" class="relative">
                                                                {{-- Trigger Button --}}
                                                                <button type="button"
                                                                        class="yarn-ordered-btn px-2 py-1 mt-3 rounded transition-all duration-200
                                                                        {{ $canOrder ? 'bg-gray-300 text-black hover:bg-gray-400' : 'bg-gray-200 text-gray-500 cursor-not-allowed' }}"
                                                                        @if($canOrder) @click="open = true" @else disabled title="Please set Development Plan Date first" @endif>
                                                                    Pending
                                                                </button>

                                                                {{-- Modal for Marking Yarn Ordered --}}
                                                                <div x-show="open" x-transition
                                                                     class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
                                                                     style="display: none;">
                                                                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-12 w-full max-w-md relative">

                                                                        {{-- Close button (X) --}}
                                                                        <button @click="open = false"
                                                                                class="absolute top-2 right-2 text-gray-600 hover:text-gray-900">
                                                                            ✕
                                                                        </button>

                                                                        {{-- Title --}}
                                                                        <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-2 text-left">
                                                                            Mark Yarn Ordered
                                                                        </h2>

                                                                        {{-- Description --}}
                                                                        <p class="mb-5 text-sm text-gray-600 dark:text-gray-300 text-left">
                                                                            Please provide the required details for the yarn order. All fields are mandatory.
                                                                        </p>

                                                                        {{-- Form --}}
                                                                        <form action="{{ route('rnd.markYarnOrdered') }}" method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="id" value="{{ $prep->id }}">

                                                                            {{-- PO Number Input --}}
                                                                            <div class="mb-4">
                                                                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 text-left">
                                                                                    PO Number
                                                                                </label>
                                                                                <input type="text" name="yarnOrderedPONumber"
                                                                                       placeholder="Enter PO Number"
                                                                                       class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm focus:ring-2 focus:ring-indigo-400 focus:outline-none"
                                                                                       required>
                                                                            </div>

                                                                            {{-- Shade Input --}}
                                                                            <div class="mb-4">
                                                                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 text-left">
                                                                                    Shade
                                                                                </label>
                                                                                <input type="text" name="shade"
                                                                                       placeholder="Enter Shade"
                                                                                       class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm focus:ring-2 focus:ring-indigo-400 focus:outline-none"
                                                                                       required>
                                                                            </div>

                                                                            {{-- Weight Input --}}
                                                                            <div class="mb-4">
                                                                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 text-left">
                                                                                    Weight (in grams)
                                                                                </label>
                                                                                <input type="number" step="0.01" name="value"
                                                                                       placeholder="e.g. 150.50"
                                                                                       class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm focus:ring-2 focus:ring-indigo-400 focus:outline-none"
                                                                                       required>
                                                                            </div>

                                                                            {{-- Ticket Input --}}
                                                                            <div class="mb-4">
                                                                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 text-left">
                                                                                    Ticket Number
                                                                                </label>
                                                                                <input type="number" name="tkt"
                                                                                       placeholder="Enter Ticket Number"
                                                                                       class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm focus:ring-2 focus:ring-indigo-400 focus:outline-none"
                                                                                       required>
                                                                            </div>

                                                                            {{-- Supplier Input --}}
                                                                            <div class="mb-6" x-data="{ supplier: 'Pan Asia' }">
                                                                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 text-left">
                                                                                    Supplier
                                                                                </label>

                                                                                <select name="yarnSupplier"
                                                                                        x-model="supplier"
                                                                                        class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm focus:ring-2 focus:ring-indigo-400 focus:outline-none"
                                                                                        required>
                                                                                    <option value="Pan Asia">Pan Asia</option>
                                                                                    <option value="Ocean Lanka">Ocean Lanka</option>
                                                                                    <option value="A and E">A and E</option>
                                                                                    <option value="Other">Other</option>
                                                                                </select>

                                                                                {{-- Show custom input if "Other" is selected --}}
                                                                                <div x-show="supplier === 'Other'" class="mt-4">
                                                                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                                                        Please specify
                                                                                    </label>
                                                                                    <input type="text" name="customSupplier"
                                                                                           placeholder="Enter Supplier Name"
                                                                                           class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm focus:ring-2 focus:ring-indigo-400 focus:outline-none">
                                                                                </div>
                                                                            </div>

                                                                            {{-- Buttons --}}
                                                                            <div class="flex justify-end gap-3">
                                                                                <button type="button"
                                                                                        @click="open = false"
                                                                                        class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400 transition">
                                                                                    Cancel
                                                                                </button>
                                                                                <button type="submit"
                                                                                        class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">
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
                                                        {{-- Not Available for these statuses --}}
                                                        <span class="text-gray-400 italic">—</span>
                                                    @else
                                                        {{-- Not applicable --}}
                                                        <button type="button"
                                                                class="yarn-ordered-btn px-2 py-1 mt-3 rounded bg-gray-200 text-gray-500 cursor-not-allowed"
                                                                disabled title="Not applicable for this type">
                                                            Pending
                                                        </button>
                                                    @endif
                                                </td>


                                                <td class="px-4 py-3 border-r border-gray-300 text-center">
                                                    @if ($prep->alreadyDeveloped == 'Need to Develop')
                                                        @if (!empty($prep->yarnOrderedPONumber))
                                                            {{-- Show saved PO Number --}}
                                                            <span class="text-sm font-medium text-gray-800 dark:text-gray-200">
                                                                {{ $prep->yarnOrderedPONumber }}
                                                            </span>
                                                        @else
                                                            {{-- Not yet added --}}
                                                            <span class="inline-block bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 text-sm font-medium px-3 py-1 rounded">
                                                                Not Added
                                                            </span>
                                                        @endif
                                                    @elseif($prep->alreadyDeveloped == 'Tape Match Pan Asia' || $prep->alreadyDeveloped == 'No Need to Develop')
                                                        {{-- PO not applicable --}}
                                                        <span class="text-gray-400 italic">—</span>
                                                    @else
                                                        {{-- Default fallback --}}
                                                        <span class="inline-block bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 text-sm font-medium px-3 py-1 rounded">
                                                            Not Added
                                                        </span>
                                                    @endif
                                                </td>

                                                <td class="px-4 py-3 border-r border-gray-300 text-center">
                                                    @if (!empty($prep->shade))
                                                        {{-- Show saved Shade --}}
                                                        <span class="text-sm font-medium text-gray-800 dark:text-gray-200">
                                                            {{ $prep->shade }}
                                                        </span>
                                                    @elseif(in_array($prep->alreadyDeveloped, ['No Need to Develop']))
                                                        {{-- Not available for these statuses --}}
                                                        <span class="text-gray-400 italic">—</span>
                                                    @else
                                                        {{-- Not yet added --}}
                                                        <span class="inline-block bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 text-sm font-medium px-3 py-1 rounded">
                                                            Not Added
                                                        </span>
                                                    @endif
                                                </td>

                                                <!-- Yarn Ordered Weight -->
                                                <td class="px-4 py-3 border-r border-gray-300 text-center">
                                                    @if (!empty($prep->yarnOrderedWeight))
                                                        {{-- Show saved Yarn Ordered Weight --}}
                                                        <span class="text-sm font-medium text-gray-800 dark:text-gray-200">
                                                            {{ $prep->yarnOrderedWeight }} g
                                                        </span>
                                                    @elseif(in_array($prep->alreadyDeveloped, ['No Need to Develop']))
                                                        {{-- Not available for these statuses --}}
                                                        <span class="text-gray-400 italic">—</span>
                                                    @else
                                                        {{-- Not yet added --}}
                                                        <span class="inline-block bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 text-sm font-medium px-3 py-1 rounded">
                                                            Not Added
                                                        </span>
                                                    @endif
                                                </td>


                                                <td class="px-4 py-3 border-r border-gray-300 text-center">
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
                                                        <span class="inline-block bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 text-sm font-medium px-3 py-1 rounded">
                                                            Not Added
                                                        </span>
                                                    @endif
                                                </td>


                                                <td class="px-4 py-3 border-r border-gray-300 text-center">
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
                                                        <span class="inline-block bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 text-sm font-medium px-3 py-1 rounded">
                                                            Not Added
                                                        </span>
                                                    @endif
                                                </td>

                                                {{-- Yarn Receive Date --}}
                                                <td
                                                    class="py-3 whitespace-normal break-words border-r border-gray-300 text-center">
                                                    @if ($prep->alreadyDeveloped == 'Need to Develop')
                                                        @if (is_null($prep->yarnReceiveDate))
                                                            <form action="{{ route('rnd.markYarnReceived') }}"
                                                                method="POST">
                                                                @csrf
                                                                <input type="hidden" name="id"
                                                                    value="{{ $prep->id }}">
                                                                <button type="submit"
                                                                    class="yarn-receive-btn px-2 py-1 mt-3 rounded transition-all duration-200
                                                                    {{ $prep->developPlannedDate && $prep->yarnOrderedDate && $prep->yarnSupplier && $prep->tkt && $prep->yarnOrderedWeight && $prep->shade && $prep->yarnOrderedPONumber ? 'bg-gray-300 text-black hover:bg-gray-400' : 'bg-gray-200 text-gray-500 cursor-not-allowed' }}"
                                                                    {{ $prep->developPlannedDate && $prep->yarnOrderedDate ? '' : 'disabled' }}
                                                                    title="{{ $prep->developPlannedDate && $prep->yarnOrderedDate && $prep->yarnSupplier && $prep->tkt && $prep->yarnOrderedWeight && $prep->shade && $prep->yarnOrderedPONumber ? '' : 'Please set Development Plan Date and Yarn Ordered Date first' }}">
                                                                    Pending
                                                                </button>
                                                            </form>
                                                        @else
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

                                                <td class="px-4 py-3 border-r border-gray-300 text-center">
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
                                                                    {{ $prep->developPlannedDate && $prep->yarnReceiveDate ? 'bg-blue-600 hover:bg-blue-700 text-white' : 'bg-gray-300 text-gray-500 cursor-not-allowed' }}"
                                                                    {{ $prep->developPlannedDate && $prep->yarnReceiveDate ? '' : 'disabled' }}
                                                                    title="{{ $prep->developPlannedDate && $prep->yarnReceiveDate ? '' : 'Please set Develop Plan Date & Yarn Received comfirm first' }}">
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
                                                </td>

                                                {{-- Send Order To Production Status --}}
                                                <td
                                                    class="py-3 whitespace-normal break-words border-r border-gray-300 text-center">
                                                    @if ($prep->alreadyDeveloped == 'Need to Develop')
                                                        @if (is_null($prep->sendOrderToProductionStatus))
                                                            <form action="{{ route('rnd.markSendToProduction') }}"
                                                                method="POST">
                                                                @csrf
                                                                <input type="hidden" name="id"
                                                                    value="{{ $prep->id }}">
                                                                <button type="submit"
                                                                    class="send-production-btn px-2 py-1 mt-3 rounded transition-all duration-200
                                                                    {{ $prep->developPlannedDate && $prep->productionDeadline ? 'bg-gray-300 text-black hover:bg-gray-400' : 'bg-gray-200 text-gray-500 cursor-not-allowed' }}"
                                                                    {{ $prep->developPlannedDate && $prep->productionDeadline ? '' : 'disabled' }}
                                                                    title="{{ $prep->developPlannedDate && $prep->productionDeadline ? '' : 'Please set Development Plan & Production Deadline Date first' }}">
                                                                    Pending
                                                                </button>
                                                            </form>
                                                        @else
                                                            <span
                                                                class="inline-block m-1 text-sm font-semibold text-gray-700 dark:text-white bg-orange-200 dark:bg-gray-800 px-3 py-1 rounded">
                                                                Sent on <br>
                                                                {{ \Carbon\Carbon::parse($prep->sendOrderToProductionStatus)->format('Y-m-d') }}
                                                                at
                                                                {{ \Carbon\Carbon::parse($prep->sendOrderToProductionStatus)->format('H:i') }}
                                                            </span>
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

                                                <td class="px-4 py-3 border-r border-gray-300 text-center">
                                                    @php
                                                        $canEditReference = false;

                                                        if (in_array($prep->alreadyDeveloped, ['No Need to Develop', 'Tape Match Pan Asia'])) {
                                                            $canEditReference = true;
                                                        } elseif ($prep->alreadyDeveloped === 'Need to Develop' && $prep->productionStatus === 'Production Complete') {
                                                            $canEditReference = true;
                                                        }
                                                    @endphp

                                                    @if ($canEditReference && !$prep->is_reference_locked)
                                                        {{-- Editable form --}}
                                                        <form action="{{ route('rnd.lockReferenceField') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="id" value="{{ $prep->id }}">

                                                            <input type="text" name="referenceNo"
                                                                   value="{{ $prep->referenceNo }}"
                                                                   class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                                   required>

                                                            <button type="submit"
                                                                    class="w-full mt-1 bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm">
                                                                Save
                                                            </button>
                                                        </form>
                                                    @elseif ($prep->is_reference_locked)
                                                        {{-- Already locked - show readonly --}}
                                                        <span class="readonly">{{ $prep->referenceNo }}</span>
                                                    @else
                                                        {{-- Not yet available --}}
                                                        <span class="timestamp mt-1 text-xs text-red-500 dark:text-red-400">
                                                            Not Available Until Production is Completed
                                                        </span>
                                                    @endif
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

                                                <!-- Yarn Leftover Weight -->
                                                <td class="px-4 py-3 border-r border-gray-300 text-center">
                                                    @if ($prep->alreadyDeveloped == 'Need to Develop')
                                                        @if (!$prep->is_yarn_leftover_weight_locked)
                                                            @php
                                                                $canSave =
                                                                    $prep->production &&
                                                                    is_numeric($prep->production->production_output) &&
                                                                    is_numeric($prep->production->damaged_output);
                                                            @endphp

                                                            <form action="{{ route('rnd.updateYarnWeights') }}"
                                                                method="POST">
                                                                @csrf
                                                                <input type="hidden" name="id"
                                                                    value="{{ $prep->id }}">
                                                                <input type="hidden" name="field"
                                                                    value="yarnLeftoverWeight">
                                                                <input type="number" step="0.01" name="value"
                                                                    value="{{ $prep->yarnLeftoverWeight }}"
                                                                    class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                                    required>

                                                                <button type="submit"
                                                                    class="w-full mt-1 px-3 py-1 rounded text-sm transition-all duration-200
                        {{ $canSave ? 'bg-blue-600 hover:bg-blue-700 text-white' : 'bg-gray-300 text-gray-500 cursor-not-allowed' }}"
                                                                    {{ $canSave ? '' : 'disabled' }}
                                                                    title="{{ $canSave ? '' : 'Production Output and Damaged Output are required' }}">
                                                                    Save
                                                                </button>
                                                            </form>
                                                        @else
                                                            <span class="readonly">{{ $prep->yarnLeftoverWeight }}
                                                                g</span>
                                                        @endif
                                                    @else
                                                        <span class="text-gray-400 italic">—</span>
                                                    @endif
                                                </td>

                                                <!-- Notes -->
                                                <td
                                                    class="px-4 py-3 whitespace-normal break-words border-r border-gray-300 text-center">
                                                    @if (auth()->user()->role !== 'ADMIN')
                                                        <form
                                                            action="{{ route('sample-inquery-details.update-notes', $prep->id) }}"
                                                            method="POST" class="w-full">
                                                            @csrf
                                                            @method('PATCH')

                                                            <textarea name="notes"
                                                                class="w-full px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm" rows="2"
                                                                required>{{ old('notes', $prep->note) }}</textarea>

                                                            <button type="submit"
                                                                class="w-full mt-1 px-2 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 transition-all duration-200 text-sm">
                                                                Save
                                                            </button>
                                                        </form>
                                                    @else
                                                        <span class="readonly">{{ $prep->note ?? 'N/D' }}</span>
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
                            <div class="mt-4">
                                {{ $samplePreparations->links() }}
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        // ===== ORDER dropdown =====
        function toggleOrderDropdown() {
            const menu = document.getElementById('orderDropdownMenu');
            const btn = document.getElementById('orderDropdown');
            const expanded = btn.getAttribute('aria-expanded') === 'true';

            menu.classList.toggle('hidden');
            btn.setAttribute('aria-expanded', !expanded);
        }

        function selectOrder(orderNo) {
            document.getElementById('selectedOrderNo').innerText = orderNo || 'Select Order No';
            document.getElementById('orderInput').value = orderNo;
            closeDropdown('orderDropdown', 'orderDropdownMenu');
        }

        function filterOrders() {
            const input = document.getElementById('orderSearchInput').value.toLowerCase();
            const items = document.querySelectorAll('.order-option');

            items.forEach(item => {
                const text = item.textContent.toLowerCase();
                item.style.display = text.includes(input) ? 'block' : 'none';
            });
        }

        // ===== PO dropdown =====
        function togglePODropdown() {
            const menu = document.getElementById('poDropdownMenu');
            const btn = document.getElementById('poDropdown');
            const expanded = btn.getAttribute('aria-expanded') === 'true';

            menu.classList.toggle('hidden');
            btn.setAttribute('aria-expanded', !expanded);
        }

        function selectPO(poNo) {
            document.getElementById('selectedPONo').innerText = poNo || 'Select PO No';
            document.getElementById('poInput').value = poNo;
            closeDropdown('poDropdown', 'poDropdownMenu');
        }

        function filterPOs() {
            const input = document.getElementById('poSearchInput').value.toLowerCase();
            const items = document.querySelectorAll('.po-option');

            items.forEach(item => {
                const text = item.textContent.toLowerCase();
                item.style.display = text.includes(input) ? 'block' : 'none';
            });
        }

        // ===== SHADE dropdown =====
        function toggleShadeDropdown() {
            const menu = document.getElementById('shadeDropdownMenu');
            const btn = document.getElementById('shadeDropdown');
            const expanded = btn.getAttribute('aria-expanded') === 'true';

            menu.classList.toggle('hidden');
            btn.setAttribute('aria-expanded', !expanded);
        }

        function selectShade(shade) {
            document.getElementById('selectedShade').innerText = shade || 'Select Shade';
            document.getElementById('shadeInput').value = shade;
            closeDropdown('shadeDropdown', 'shadeDropdownMenu');
        }

        function filterShades() {
            const input = document.getElementById('shadeSearchInput').value.toLowerCase();
            const items = document.querySelectorAll('.shade-option');

            items.forEach(item => {
                const text = item.textContent.toLowerCase();
                item.style.display = text.includes(input) ? 'block' : 'none';
            });
        }

        // ===== REFERENCE NO dropdown =====
        function toggleRefDropdown() {
            const menu = document.getElementById('refDropdownMenu');
            const btn = document.getElementById('refDropdown');
            const expanded = btn.getAttribute('aria-expanded') === 'true';

            menu.classList.toggle('hidden');
            btn.setAttribute('aria-expanded', !expanded);
        }

        function selectRef(ref) {
            document.getElementById('selectedRef').innerText = ref || 'Select Reference No';
            document.getElementById('refInput').value = ref;
            closeDropdown('refDropdown', 'refDropdownMenu');
        }

        function filterRefs() {
            const input = document.getElementById('refSearchInput').value.toLowerCase();
            const items = document.querySelectorAll('.ref-option');

            items.forEach(item => {
                const text = item.textContent.toLowerCase();
                item.style.display = text.includes(input) ? 'block' : 'none';
            });
        }

        // ===== Helper to close dropdown =====
        function closeDropdown(btnId, menuId) {
            const btn = document.getElementById(btnId);
            const menu = document.getElementById(menuId);

            menu.classList.add('hidden');
            btn.setAttribute('aria-expanded', false);
        }

        function clearFilters() {
            // Order
            document.getElementById('selectedOrderNo').innerText = 'Select Order No';
            document.getElementById('orderInput').value = '';
            document.getElementById('orderSearchInput').value = '';
            filterOrders();

            // PO
            document.getElementById('selectedPONo').innerText = 'Select PO No';
            document.getElementById('poInput').value = '';
            document.getElementById('poSearchInput').value = '';
            filterPOs();

            // Shade
            document.getElementById('selectedShade').innerText = 'Select Shade';
            document.getElementById('shadeInput').value = '';
            document.getElementById('shadeSearchInput').value = '';
            filterShades();

            // Reference No
            document.getElementById('selectedRef').innerText = 'Select Reference No';
            document.getElementById('refInput').value = '';
            document.getElementById('refSearchInput').value = '';
            filterRefs();

            // Dates
            document.getElementById('customerRequestedDate').value = '';
            document.getElementById('developmentPlanDate').value = '';
        }


        // ===== Close dropdowns if click outside =====
        document.addEventListener('click', function(e) {
            // List of dropdowns to check
            const dropdowns = [{
                    btnId: 'orderDropdown',
                    menuId: 'orderDropdownMenu'
                },
                {
                    btnId: 'poDropdown',
                    menuId: 'poDropdownMenu'
                },
                {
                    btnId: 'shadeDropdown',
                    menuId: 'shadeDropdownMenu'
                },
                {
                    btnId: 'refDropdown',
                    menuId: 'refDropdownMenu'
                }
            ];

            dropdowns.forEach(({
                btnId,
                menuId
            }) => {
                const btn = document.getElementById(btnId);
                const menu = document.getElementById(menuId);

                if (!btn.contains(e.target) && !menu.contains(e.target)) {
                    closeDropdown(btnId, menuId);
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
        function openRndSampleModal(orderNo, coordinatorName, item, description, size, qtRef, color, style, sampleQty,
            specialComment, requestDate) {
            document.getElementById('modalRndOrderNo').textContent = 'Order Number ' + orderNo;
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
                const button = document.getElementById(⁠$ {
                        type
                    }
                    Dropdown⁠);
                const menu = document.getElementById(⁠$ {
                        type
                    }
                    DropdownMenu⁠);

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
                    const menu = document.getElementById(⁠$ {
                            type
                        }
                        DropdownMenu⁠);
                    const button = document.getElementById(⁠$ {
                            type
                        }
                        Dropdown⁠);
                    if (menu && button && !menu.contains(e.target) && !button.contains(e.target)) {
                        menu.classList.add("hidden");
                        button.setAttribute("aria-expanded", "false");
                    }
                });
            });

            function closeAllDropdownsTab2() {
                tab2Filters.forEach(type => {
                    const menu = document.getElementById(⁠$ {
                            type
                        }
                        DropdownMenu⁠);
                    const button = document.getElementById(⁠$ {
                            type
                        }
                        Dropdown⁠);
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
            const options = document.querySelectorAll(⁠.$ {
                optionClass
            }⁠);
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
@endsection
