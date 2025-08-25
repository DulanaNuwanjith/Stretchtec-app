<head>

    {{-- Tailwind CSS and Sweet Alert Imports --}}
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="//unpkg.com/alpinejs" defer></script>

    <title>StretchTec</title>
</head>

<div class="flex h-full w-full bg-white">

    {{-- Top Bar extending from layouts --}}
    @extends('layouts.sample-tabs')

    @section('content')
        <div class="flex-1 overflow-y-hidden">
            <div class="">
                <div class="w-full px-6 lg:px-2">
                    <div class="bg-white overflow-hidden">
                        <div class="p-4 text-gray-900">

                            {{-- Style for Sweet Alert --}}
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

                            {{-- Script for Sweet Alert --}}
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

                            <div id="filterFormContainerTab3" class="mt-4 hidden">
                                <form id="filterForm3" method="GET"
                                    action="{{ route('sample-preparation-production.index') }}"
                                    class="mb-6 sticky top-0 z-40 flex gap-6 items-center">
                                    <input type="hidden" name="tab" value="3">

                                    <div class="flex items-center gap-4 flex-wrap">

                                        {{-- Filter - Order No Dropdown --}}
                                        <div class="relative inline-block text-left w-48">
                                            <label for="orderDropdownTab3"
                                                class="block text-sm font-medium text-gray-700 mb-1">Order
                                                No</label>
                                            <input type="hidden" name="order_no" id="orderInputTab3"
                                                value="{{ request('order_no') }}">
                                            <button id="orderDropdownTab3" type="button"
                                                class="inline-flex w-full justify-between rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-gray-300 hover:bg-gray-50 h-10"
                                                aria-expanded="false" aria-haspopup="listbox"
                                                onclick="toggleOrderDropdownTab3(event)">
                                                <span
                                                    id="selectedOrderNoTab3">{{ request('order_no') ?? 'Select Order No' }}</span>
                                                <svg class="ml-2 h-5 w-5 text-gray-400" viewBox="0 0 20 20"
                                                    fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 10.94l3.71-3.71a.75.75 0 1 1 1.06 1.06l-4.24 4.24a.75.75 0 0 1-1.06 0L5.25 8.29a.75.75 0 0 1-.02-1.08z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </button>

                                            <div id="orderDropdownMenuTab3"
                                                class="absolute z-40 mt-1 w-full bg-white border rounded-lg shadow-lg hidden max-h-48 overflow-y-auto p-2"
                                                role="listbox" aria-labelledby="orderDropdownTab3">
                                                <input type="text" id="orderSearchInputTab3" onkeyup="filterOrdersTab3()"
                                                    placeholder="Search..."
                                                    class="w-full px-2 py-1 text-sm border rounded-md"
                                                    autocomplete="off">
                                                @foreach ($orderNosTab3 as $order)
                                                    <div onclick="selectOrderTab3('{{ $order }}')" tabindex="0"
                                                        class="order-option-tab3 px-4 py-2 hover:bg-gray-100 cursor-pointer text-sm">
                                                        {{ $order }}
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        {{-- Filter - Development Plan Date --}}
                                        <div class="inline-block text-left w-48">
                                            <label for="developmentPlanDateTab3"
                                                class="block text-sm font-medium text-gray-700">Production Deadline</label>
                                            <input type="date" name="development_plan_date" id="developmentPlanDateTab3"
                                                value="{{ request('development_plan_date') }}"
                                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 text-sm">
                                        </div>

                                        {{-- Filter - Buttons --}}
                                        <div class="flex items-end space-x-2 mt-2">
                                            <button type="submit"
                                                class="mt-4 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Apply
                                                Filters</button>
                                            <button type="button" id="clearFiltersBtnTab3"
                                                class="mt-4 bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">Clear</button>
                                        </div>

                                    </div>
                                </form>
                            </div>

                            <div class="flex justify-between items-center mb-6">
                                <h1 class="text-2xl font-bold text-gray-800 py-1">Sample Preparation
                                    Production
                                    Records
                                </h1>
                            </div>

                            {{-- Main Table --}}
                            <div id="SampleProductionRecordsScroll"
                                class="overflow-x-auto max-h-[1200px] bg-white shadow rounded-lg">
                                <table class="table-fixed w-full text-sm divide-y divide-gray-200">
                                    <thead class="bg-gray-100 text-left">
                                        <tr class="text-center">
                                            <th
                                                class="font-bold sticky left-0 top-0 z-30 bg-white px-4 py-3 w-32 box-border text-xs text-gray-600 uppercase whitespace-normal break-words">
                                                Order No
                                            </th>
                                            <th
                                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-32 text-xs text-gray-600 uppercase whitespace-normal break-words">
                                                Production Deadline
                                            </th>
                                            <th
                                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-48 text-xs text-gray-600 uppercase whitespace-normal break-words">
                                                Order Received Date & Time
                                            </th>
                                            <th
                                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-48 text-center text-xs text-gray-600 uppercase whitespace-normal break-words">
                                                Order Start Date & Time
                                            </th>
                                            <th
                                                class="font-bold sticky top-0 z-20 bg-gray-200 px-4 py-3 w-52 text-xs text-gray-600 uppercase whitespace-normal break-words">
                                                Operator Name
                                            </th>
                                            <th
                                                class="font-bold sticky top-0 z-20 bg-gray-200 px-4 py-3 w-52 text-xs text-gray-600 uppercase whitespace-normal break-words">
                                                Supervisor Name
                                            </th>
                                            <th
                                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-48 text-center text-xs text-gray-600 uppercase whitespace-normal break-words">
                                                Order Complete Date & Time
                                            </th>
                                            <th
                                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-32 text-xs text-gray-600 uppercase whitespace-normal break-words">
                                                Production Output</th>
                                            <th
                                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-32 text-xs text-gray-600 uppercase whitespace-normal break-words">
                                                Damaged Output</th>
                                            <th
                                                class="font-bold sticky top-0 z-20 bg-gray-200 px-4 py-3 w-64 text-center text-xs text-gray-600 uppercase whitespace-normal break-words">
                                                Dispatch to R&D
                                            </th>
                                            <th
                                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-72 text-center text-xs text-gray-600 uppercase whitespace-normal break-words">
                                                Note
                                            </th>
                                            <th
                                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-48 text-center text-xs text-gray-600 uppercase whitespace-normal break-words">
                                                Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="serviceRecords"
                                        class="bg-white divide-y divide-gray-200">
                                        @foreach ($productions as $prod)
                                            <tr id="serviceRow{{ $prod->id }}"
                                                class="odd:bg-white even:bg-gray-50 border-b border-gray-200  text-left">
                                                {{-- Order No --}}
                                                <td
                                                    class="sticky left-0 z-20 px-4 py-3 bg-gray-100 whitespace-normal break-words border-r border-gray-300">
                                                    <span
                                                        class="readonly font-bold hover:text-blue-600 hover:underline cursor-pointer"
                                                        onclick="openSampleModal(
                                                            '{{ addslashes($prod->order_no) }}',
                                                            '{{ addslashes($prod->sampleInquiry->customerName ?? '-') }}',
                                                            '{{ addslashes($prod->sampleInquiry->item ?? '-') }}',
                                                            '{{ addslashes($prod->sampleInquiry->ItemDiscription ?? '-') }}',
                                                            '{{ addslashes($prod->sampleInquiry->size ?? '-') }}',
                                                            '{{ addslashes($prod->sampleInquiry->qtRef ?? '-') }}',
                                                            '{{ addslashes($prod->sampleInquiry->color ?? '-') }}',
                                                            '{{ addslashes($prod->sampleInquiry->style ?? '-') }}',
                                                            '{{ addslashes($prod->sampleInquiry->sampleQty ?? '-') }}',
                                                            '{{ addslashes($prod->samplePreparationRnd->shade ?? '-') }}',
                                                            // '{{ addslashes($prod->operator_name ?? '-') }}',
                                                            // '{{ addslashes($prod->supervisor_name ?? '-') }}',
                                                        )">
                                                        {{ $prod->order_no }}
                                                    </span>

                                                    <input type="text" name="order_no"
                                                        class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md text-sm"
                                                        value="{{ $prod->order_no }}" />
                                                </td>

                                                {{-- Production Deadline --}}
                                                <td
                                                    class="px-4 py-3 whitespace-normal break-words border-r border-gray-300  text-center">
                                                    <span class="readonly">
                                                        {{ $prod->production_deadline ? $prod->production_deadline->format('Y-m-d') : '-' }}
                                                    </span>
                                                    <input type="date" name="production_deadline"
                                                        class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md text-sm"
                                                        value="{{ $prod->production_deadline ? $prod->production_deadline->format('Y-m-d') : '' }}" />
                                                </td>

                                                {{-- Order Received Date & Time --}}
                                                <td
                                                    class="py-3 whitespace-normal break-words border-r border-gray-300 text-center">
                                                    <span
                                                        class="readonly inline-block m-1 text-sm font-semibold text-gray-700 bg-yellow-100 px-3 py-1 rounded">
                                                        Received on <br>
                                                        {{ \Carbon\Carbon::parse($prod->order_received_at)->format('Y-m-d') }}
                                                        at
                                                        {{ \Carbon\Carbon::parse($prod->order_received_at)->format('H:i') }}
                                                    </span>
                                                    <input type="datetime-local" name="order_received_at"
                                                        class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md text-sm"
                                                        value="{{ $prod->order_received_at ? $prod->order_received_at->format('Y-m-d\TH:i') : '' }}" />
                                                </td>

                                                {{-- Order Start Date & Time --}}
                                                <td class="py-3 whitespace-normal break-words border-r border-gray-300 text-center"
                                                    x-data="{ open: false }">

                                                    @php
                                                        $sentShades = $prod->samplePreparationRnD->shadeOrders->where(
                                                            'status',
                                                            'Sent to Production',
                                                        );
                                                        $inProdShades = $prod->samplePreparationRnD->shadeOrders->where(
                                                            'status',
                                                            'In Production',
                                                        );
                                                    @endphp

                                                    @auth
                                                        @if (auth()->user()->role === 'ADMIN')
                                                            {{-- Just show status for admin --}}
                                                            @if ($inProdShades->isEmpty())
                                                                <span
                                                                    class="inline-block mt-3 text-sm font-semibold text-gray-700
                                                                            bg-gray-200 px-3 py-1 rounded">
                                                                    Pending
                                                                </span>
                                                            @else
                                                                <span
                                                                    class="inline-block m-1 text-sm font-semibold text-gray-700
                                                                    bg-pink-200 px-3 py-1 rounded">
                                                                    Started on <br>
                                                                    {{ $prod->order_start_at?->format('Y-m-d') }} at
                                                                    {{ $prod->order_start_at?->format('H:i') }}
                                                                </span>
                                                            @endif
                                                        @else
                                                            {{-- Operator View --}}
                                                            @if ($sentShades->isNotEmpty())
                                                                {{-- Button to trigger modal --}}
                                                                <button type="button" @click="open = true"
                                                                    class="order-start-btn px-2 py-1 mt-3 rounded transition-all duration-200
                                                                        bg-gray-300 text-black hover:bg-gray-400">
                                                                    Pending ({{ $sentShades->count() }})
                                                                </button>

                                                                {{-- Modal --}}
                                                                <div x-show="open" x-transition
                                                                    class="fixed inset-0 flex items-center justify-center
                                                                bg-black bg-opacity-50 z-50"
                                                                    style="display:none;">
                                                                    <div
                                                                        class="bg-white rounded-lg shadow-lg p-6 w-full max-w-lg relative max-h-[80vh] overflow-y-auto">

                                                                        <button @click="open = false"
                                                                            class="absolute top-2 right-2 text-gray-600 hover:text-gray-900">✕</button>

                                                                        <h2
                                                                            class="text-lg font-semibold text-blue-900 mb-4">
                                                                            Start Production for Shades
                                                                        </h2>

                                                                        <form action="{{ route('production.markStart') }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="production_id"
                                                                                value="{{ $prod->id }}">

                                                                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                                                                @foreach ($sentShades as $shade)
                                                                                    <div
                                                                                        class="p-4 border rounded bg-gray-100">
                                                                                        <label class="flex items-start gap-2">
                                                                                            <input type="checkbox"
                                                                                                name="shade_ids[]"
                                                                                                value="{{ $shade->id }}"
                                                                                                class="mt-1">
                                                                                            <div>
                                                                                                <div class="font-semibold">
                                                                                                    Shade: {{ $shade->shade }}
                                                                                                </div>
                                                                                                <div
                                                                                                    class="text-sm text-gray-600">
                                                                                                    Status:
                                                                                                    {{ $shade->status }}</div>
                                                                                            </div>
                                                                                        </label>
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
                                                                                    Start Selected
                                                                                </button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            @else
                                                                <span
                                                                    class="inline-block m-1 text-sm font-semibold text-gray-700
                                                                            bg-pink-200 px-3 py-1 rounded">
                                                                    Started on <br>
                                                                    {{ $prod->order_start_at?->format('Y-m-d') }} at
                                                                    {{ $prod->order_start_at?->format('H:i') }}
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

                                                {{-- Order Complete / Production Complete --}}
                                                <td class="py-3 whitespace-normal break-words border-r border-gray-300 text-center"
                                                    x-data="{ open: false, openCompleted: false }">
                                                    @auth
                                                        @if (auth()->user()->role !== 'ADMIN')
                                                            @php
                                                                $shadeOrders = $prod->samplePreparationRnD?->shadeOrders ?? collect();
                                                                $inProductionShades = $shadeOrders->where('status', 'In Production');
                                                                // Only shades related to this production that are complete
                                                                $completedShades = $shadeOrders->whereIn('status', [
                                                                    'Production Complete',
                                                                    'Dispatched to RnD',
                                                                    'Delivered',
                                                                ]);
                                                                $hasCompletedAtLeastOne = $completedShades->isNotEmpty();
                                                                $allComplete = $shadeOrders->isNotEmpty() && $shadeOrders->count() === $completedShades->count();
                                                            @endphp

                                                            @if ($hasCompletedAtLeastOne)
                                                                {{-- ✅ Production Complete Label (shown if at least one shade is completed) --}}
                                                                @php
                                                                    $lastCompleted = $completedShades->sortByDesc('production_complete_date')->first();
                                                                @endphp
                                                                <span @click="openCompleted = true"
                                                                      class="cursor-pointer inline-block m-1 text-sm font-semibold text-gray-700
                                                                      bg-green-100 px-3 py-1 rounded">
                                                                    Production Complete<br> on {{ \Carbon\Carbon::parse($lastCompleted->production_complete_date)->format('Y-m-d') }} at {{ \Carbon\Carbon::parse($lastCompleted->production_complete_date)->format('H:i') }}
                                                                </span>

                                                                {{-- Modal showing all completed shades --}}
                                                                <div x-show="openCompleted" x-transition x-cloak
                                                                     class="fixed inset-0 flex items-center justify-center bg-black/50 backdrop-blur-sm z-50">
                                                                    <div class="bg-white rounded-2xl shadow-xl p-6 w-full max-w-2xl relative">
                                                                        <button @click="openCompleted = false"
                                                                                class="absolute top-3 right-3 text-gray-400 hover:text-gray-600">✕</button>
                                                                        <h2 class="text-xl text-left font-semibold text-blue-900 border-b pb-3 mb-4">
                                                                            Completed Shades Details
                                                                        </h2>

                                                                        {{-- Shades List --}}
                                                                        <div class="space-y-4 max-h-[420px] overflow-y-auto pr-1">
                                                                            @foreach ($completedShades as $shade)
                                                                                <div class="flex justify-between items-center p-4 border rounded-lg bg-gray-50">
                                                                                    <span class="font-medium text-gray-900">{{ $shade->shade }}</span>
                                                                                    <span class="text-sm text-gray-700">
                                                                                        Completed on {{ $shade->production_complete_date }}
                                                                                    </span>
                                                                                </div>
                                                                            @endforeach
                                                                        </div>

                                                                        {{-- Footer --}}
                                                                        <div class="flex justify-end mt-5 border-t pt-4">
                                                                            <button @click="openCompleted = false"
                                                                                    class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100">
                                                                                Close
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif

                                                            @if ($inProductionShades->isNotEmpty())
                                                                @php
                                                                    $canComplete = $prod->operator_name && $prod->supervisor_name;
                                                                @endphp

                                                                {{-- Button to mark shades complete --}}
                                                                <button type="button" @click="open = true"
                                                                        class="px-2 py-1 mt-3 rounded transition
                                                                    {{ $canComplete ? 'bg-green-600 hover:bg-green-700 text-white' : 'bg-gray-300 text-black cursor-not-allowed' }}"
                                                                    {{ $canComplete ? '' : 'disabled' }}>
                                                                    Production Complete
                                                                </button>

                                                                {{-- Modal for marking shades complete --}}
                                                                <div x-show="open" x-transition x-cloak
                                                                     class="fixed inset-0 flex items-center justify-center bg-black/50 backdrop-blur-sm z-50">
                                                                    <div class="bg-white rounded-2xl shadow-xl p-6 w-full max-w-lg relative">
                                                                        <button @click="open = false"
                                                                                class="absolute top-3 right-3 text-gray-400 hover:text-gray-600">✕</button>
                                                                        <h2 class="text-xl font-semibold text-gray-900 border-b pb-3 mb-4">
                                                                            Mark Shades as Production Complete
                                                                        </h2>

                                                                        {{-- Shades List --}}
                                                                        <div class="space-y-4 max-h-[420px] overflow-y-auto pr-1">
                                                                            @foreach ($inProductionShades as $shade)
                                                                                <form action="{{ route('production.markComplete') }}" method="POST"
                                                                                      class="flex justify-between items-center p-4 border rounded-lg bg-gray-50 hover:shadow-md transition">
                                                                                    @csrf
                                                                                    <input type="hidden" name="shade_id" value="{{ $shade->id }}">
                                                                                    <span class="font-medium text-gray-900">🎨 {{ $shade->shade }}</span>
                                                                                    <button type="submit"
                                                                                            class="px-4 py-2 bg-green-600 text-white text-sm rounded-lg shadow-sm hover:bg-green-700 focus:ring-2 focus:ring-green-400">
                                                                                        Mark Complete
                                                                                    </button>
                                                                                </form>
                                                                            @endforeach
                                                                        </div>

                                                                        {{-- Footer --}}
                                                                        <div class="flex justify-end mt-5 border-t pt-4">
                                                                            <button @click="open = false"
                                                                                    class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100">
                                                                                Close
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @elseif(!$hasCompletedAtLeastOne)
                                                                {{-- No shades completed and none in production --}}
                                                                <span
                                                                    class="inline-block mt-3 text-sm font-semibold text-gray-700
                                                                        bg-gray-200 px-3 py-1 rounded">
                                                                    Pending
                                                                </span>
                                                            @endif
                                                        @else
                                                            {{-- Admin view --}}
                                                            @if ($prod->order_complete_at)
                                                                <span class="inline-block m-1 text-sm font-semibold text-gray-700
                                                                        bg-green-100 px-3 py-1 rounded">
                                                                    Completed on <br>
                                                                    {{ $prod->order_complete_at->format('Y-m-d') }} at
                                                                    {{ $prod->order_complete_at->format('H:i') }}
                                                                </span>
                                                            @else
                                                                <span class="inline-block mt-3 text-sm font-semibold text-gray-700
                                                                        bg-gray-200 px-3 py-1 rounded">
                                                                    Pending
                                                                </span>
                                                            @endif
                                                        @endif
                                                    @endauth
                                                </td>


                                                {{-- Production Output --}}
                                                <td
                                                    class="px-4 py-3 whitespace-normal break-words border-r border-gray-300 text-center">
                                                    <span class="readonly">
                                                        {{ is_numeric($prod->production_output) ? $prod->production_output . ' g' : '-' }}
                                                    </span>
                                                </td>

                                                {{-- Damaged Output --}}
                                                <td
                                                    class="px-4 py-3 whitespace-normal break-words border-r border-gray-300 text-center">
                                                    <span class="readonly">
                                                        {{ is_numeric($prod->damaged_output) ? $prod->damaged_output . ' g' : '-' }}
                                                    </span>
                                                </td>

                                                {{-- Dispatch to R&D --}}
                                                <td class="px-4 py-3 whitespace-normal break-words border-r border-gray-300 text-center"
                                                    x-data="{ openDispatch: false }">
                                                    @auth
                                                        @if (auth()->user()->role === 'ADMIN')
                                                            <div class="text-sm text-gray-800 font-medium">
                                                                {{ $prod->dispatched_by ?? '-' }}
                                                            </div>
                                                            <div class="sample-dispatch-timestamp text-xs text-gray-500">
                                                                {{ $prod->dispatch_to_rnd_at ? $prod->dispatch_to_rnd_at->format('Y-m-d H:i') : '-' }}
                                                            </div>
                                                        @else
                                                            @php
                                                                $shadeOrders = $prod->samplePreparationRnD?->shadeOrders ?? collect();
                                                                $dispatchedShades = $shadeOrders->whereIn('status', ['Dispatched to RnD', 'Delivered']);
                                                                $hasDispatchedAtLeastOne = $dispatchedShades->isNotEmpty();
                                                                $lastDispatched = $dispatchedShades->sortByDesc('dispatched_date')->first();
                                                                $hasProductionComplete = $shadeOrders->where('status', 'Production Complete')->count() > 0;
                                                            @endphp

                                                            @if ($hasDispatchedAtLeastOne && $lastDispatched)
                                                                {{-- ✅ Clickable banner --}}
                                                                <div @click="openDispatch = true"
                                                                     class="cursor-pointer inline-block m-1 text-sm font-semibold text-gray-700
                            bg-green-200 px-3 py-1 rounded">
                                                                    Dispatched to <span class="font-semibold">{{ explode(' ', $lastDispatched->dispatched_by ?? 'Unknown')[0] }}</span><br>
                                                                    on {{ \Carbon\Carbon::parse($lastDispatched->dispatched_date)->format('Y-m-d') }}
                                                                    at {{ \Carbon\Carbon::parse($lastDispatched->dispatched_date)->format('H:i') }}
                                                                </div>
                                                            @else
                                                                {{-- ✅ Dispatch button --}}
                                                                <button type="button"
                                                                        class="px-3 py-1 rounded text-white transition {{ $hasProductionComplete ? 'bg-blue-500 hover:bg-blue-600' : 'bg-gray-300 cursor-not-allowed' }}"
                                                                        @if($hasProductionComplete) @click="openDispatch = true" @endif
                                                                    {{ $hasProductionComplete ? '' : 'disabled' }}>
                                                                    Dispatch
                                                                </button>
                                                            @endif

                                                            {{-- ✅ Modal is ALWAYS rendered --}}
                                                            <div x-show="openDispatch" x-transition x-cloak
                                                                 class="fixed inset-0 flex items-center justify-center bg-black/50 backdrop-blur-sm z-50">
                                                                <div class="bg-white rounded-2xl shadow-xl p-6 w-full max-w-2xl relative">
                                                                    <div class="flex justify-between items-center border-b pb-3">
                                                                        <h2 class="text-xl font-semibold text-blue-900">
                                                                            Dispatched Shades Details
                                                                        </h2>
                                                                        <button type="button" @click="openDispatch = false"
                                                                                class="text-gray-400 hover:text-gray-600">✕</button>
                                                                    </div>

                                                                    <div class="space-y-4 max-h-[420px] overflow-y-auto pr-1 mt-4">
                                                                        @forelse ($dispatchedShades as $shade)
                                                                            <div class="flex justify-between items-center p-4 border rounded-lg bg-gray-50">
                                                                                <span class="font-medium text-gray-900">{{ $shade->shade }}</span>
                                                                                <span class="text-sm text-gray-700">
                                    Dispatched on {{ $shade->dispatched_date }} to {{ $shade->dispatched_by }}
                                </span>
                                                                            </div>
                                                                        @empty
                                                                            <p class="text-sm text-gray-500">No shades dispatched yet.</p>
                                                                        @endforelse
                                                                    </div>

                                                                    <div class="flex justify-end mt-5 border-t pt-4">
                                                                        <button @click="openDispatch = false"
                                                                                class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100">
                                                                            Close
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endauth
                                                </td>


                                                {{-- Note --}}
                                                <td
                                                    class="px-4 py-3 whitespace-normal break-words border-r border-gray-300 text-center">
                                                    @if (auth()->user()->role !== 'ADMIN' && $prod->sampleInquiry)
                                                        <form
                                                            action="{{ route('sample-inquery-details.update-notes', $prod->sampleInquiry->id) }}"
                                                            method="POST" class="w-full">
                                                            @csrf
                                                            @method('PATCH')

                                                            <textarea name="notes" rows="2"
                                                                class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md text-sm" required>{{ old('notes', $prod->sampleInquiry->notes) }}</textarea>

                                                            <button type="submit"
                                                                class="w-full mt-1 px-2 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 transition-all duration-200 text-sm">
                                                                Save
                                                            </button>
                                                        </form>
                                                    @elseif(auth()->user()->role !== 'ADMIN')
                                                        <span>No linked inquiry found</span>
                                                    @else
                                                        <span
                                                            class="readonly">{{ $prod->sampleInquiry->notes ?? 'N/D' }}</span>
                                                    @endif
                                                </td>

                                                {{-- Action Buttons --}}
                                                <td class="px-4 py-3 whitespace-normal break-words text-center">
                                                    <div class="flex space-x-2 justify-center">
                                                        @if ($prod->order_file_url)
                                                            <a href="{{ asset('storage/' . $prod->sampleInquiry->orderFile) }}"
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

                                {{-- Sample Details Modal --}}
                                <div id="viewDetailsSample"
                                    class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center py-5"
                                    onclick="this.classList.add('hidden')">

                                    <div class="w-full max-w-[700px] bg-white rounded-2xl shadow-2xl p-4 transform transition-all scale-95 max-h-[calc(100vh-10rem)] overflow-y-auto"
                                        onclick="event.stopPropagation()">

                                        <div class="max-w-[600px] mx-auto p-6" id="printAreaSample">
                                            <h2 id="modalOrderNo"
                                                class="text-2xl font-semibold mb-6 text-blue-900 text-center">Order Number
                                            </h2>

                                            <table class="w-full text-left border border-gray-300 text-sm">
                                                <tbody>
                                                    <tr>
                                                        <th class="p-2 border">Customer Name</th>
                                                        <td class="p-2 border" id="modalCustomerName"></td>
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
                                                        <th class="p-2 border">Shade</th>
                                                        <td class="p-2 border" id="modalShade"></td>
                                                    </tr>
                                                    {{-- <tr>
                                                        <th class="p-2 border">Operator Name</th>
                                                        <td class="p-2 border" id="modalOperator"></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="p-2 border">Supervisor Name</th>
                                                        <td class="p-2 border" id="modalSupervisor"></td>
                                                    </tr> --}}
                                                </tbody>
                                            </table>

                                            <!-- Signature spaces (only visible in print) -->
                                            <div class="hidden print:flex justify-between mt-20">
                                                <div class="w-1/3 text-center">
                                                    <div class="border-b border-black mt-16">&nbsp;</div>
                                                    <span class="text-sm">Operator Name</span>
                                                </div>
                                                <div class="w-1/3 text-center">
                                                    <div class="border-b border-black mt-16">&nbsp;</div>
                                                    <span class="text-sm">Supervisor Name</span>
                                                </div>
                                            </div>

                                            <!-- Signature spaces (only visible in print) -->
                                            <div class="hidden print:flex justify-between mt-10">
                                                <div class="w-1/3 text-center">
                                                    <div class="border-b border-black mt-10">{{ Auth::user()->name }}
                                                    </div>
                                                    <span class="text-sm">Prepared By</span>
                                                </div>
                                                <div class="w-1/3 text-center">
                                                    <div class="border-b border-black mt-10">&nbsp;</div>
                                                    <span class="text-sm">Approved By</span>
                                                </div>
                                            </div>

                                        </div>

                                        {{-- Buttons --}}
                                        <div class="text-center mt-6 flex justify-center gap-4 mb-10">
                                            <button
                                                onclick="document.getElementById('viewDetailsSample').classList.add('hidden')"
                                                class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-md">
                                                Close
                                            </button>

                                            {{-- <button onclick="printSampleDetails()"
                                                class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-md">
                                                Print
                                            </button> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="py-6 flex justify-center">
                                {{-- Pagination --}}
                                {{ $productions->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Printing Sample Details --}}
    <script>
        function printSampleDetails() {
            const printContent = document.getElementById('printAreaSample').innerHTML;
            const originalContent = document.body.innerHTML;

            document.body.innerHTML = `
            <div style="max-width: 700px; margin: auto;">
                ${printContent}
            </div>
        `;

            window.print();
            document.body.innerHTML = originalContent;
            location.reload(); // reload to restore JS event listeners
        }
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
            const form = document.getElementById('filterFormContainerTab3');
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

    <script>
        function openSampleModal(orderNo, customerName, item, description, size, qtRef, color, style, sampleQty, shade,
            operator,
            supervisor) {
            document.getElementById('modalOrderNo').textContent = 'Order Number: ' + orderNo;
            document.getElementById('modalCustomerName').textContent = customerName;
            document.getElementById('modalItem').textContent = item;
            document.getElementById('modalDescription').textContent = description;
            document.getElementById('modalSize').textContent = size;
            document.getElementById('modalQTRef').textContent = qtRef;
            document.getElementById('modalColor').textContent = color;
            document.getElementById('modalStyle').textContent = style;
            document.getElementById('modalSampleQty').textContent = sampleQty;
            document.getElementById('modalShade').textContent = shade;
            // document.getElementById('modalOperator').textContent = operator;
            // document.getElementById('modalSupervisor').textContent = supervisor;

            document.getElementById('viewDetailsSample').classList.remove('hidden');
        }
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // ======= ORDER NO DROPDOWN (Tab 3) =======
            const orderDropdownBtn = document.getElementById("orderDropdownTab3");
            const orderDropdownMenu = document.getElementById("orderDropdownMenuTab3");

            // Prevent clicks inside dropdown menu from closing it
            orderDropdownMenu.addEventListener("click", (event) => {
                event.stopPropagation();
            });

            // Toggle Order No dropdown
            window.toggleOrderDropdownTab3 = function(event) {
                event.stopPropagation();
                closeAllOrderDropdowns();
                orderDropdownMenu.classList.toggle("hidden");
                orderDropdownBtn.setAttribute("aria-expanded", !orderDropdownMenu.classList.contains("hidden"));
            };

            function closeAllOrderDropdowns() {
                orderDropdownMenu.classList.add("hidden");
                orderDropdownBtn.setAttribute("aria-expanded", "false");
            }

            // Close dropdown when clicking outside
            document.addEventListener("click", () => {
                closeAllOrderDropdowns();
            });

            // Select order from dropdown
            window.selectOrderTab3 = function(value) {
                document.getElementById("orderInputTab3").value = value;
                document.getElementById("selectedOrderNoTab3").textContent = value || "Select Order No";
                closeAllOrderDropdowns();
            };

            // Filter orders as user types
            window.filterOrdersTab3 = function() {
                const input = document.getElementById("orderSearchInputTab3");
                const filter = input.value.toLowerCase();
                const options = document.querySelectorAll(".order-option-tab3");

                options.forEach(option => {
                    option.style.display = option.textContent.toLowerCase().includes(filter) ? "block" :
                        "none";
                });
            };

            // ======= SAMPLE DROPDOWN =======
            const sampleDropdownBtn = document.getElementById('sampleDropdown');
            const sampleDropdownMenu = document.getElementById('sampleDropdownMenu');

            // Prevent clicks inside sample dropdown menu from closing it
            if (sampleDropdownMenu) {
                sampleDropdownMenu.addEventListener("click", (e) => {
                    e.stopPropagation();
                });
            }

            // Toggle sample dropdown
            window.toggleSampleDropdown = function() {
                const expanded = sampleDropdownBtn.getAttribute('aria-expanded') === 'true';

                sampleDropdownMenu.classList.toggle('hidden');
                sampleDropdownBtn.setAttribute('aria-expanded', String(!expanded));

                if (!sampleDropdownMenu.classList.contains('hidden')) {
                    document.getElementById('sampleSearchInput').value = '';
                    filterSamples();
                }
            };

            // Filter sample dropdown options
            window.filterSamples = function() {
                const filter = document.getElementById('sampleSearchInput').value.toLowerCase();
                const options = document.querySelectorAll('#sampleDropdownMenu .sample-option');

                options.forEach(option => {
                    option.style.display = option.textContent.toLowerCase().includes(filter) ? '' :
                        'none';
                });
            };

            // Select sample from dropdown
            window.selectSample = function(id, label) {
                document.getElementById('selectedSample').innerText = label;
                document.getElementById('sampleInput').value = id;
                sampleDropdownMenu.classList.add('hidden');
                sampleDropdownBtn.setAttribute('aria-expanded', 'false');
            };

            // Close sample dropdown when clicking outside
            document.addEventListener('DOMContentLoaded', () => {
                const sampleDropdownBtn = document.getElementById('sampleDropdownBtn');
                const sampleDropdownMenu = document.getElementById('sampleDropdownMenu');

                if (sampleDropdownBtn && sampleDropdownMenu) {
                    document.addEventListener('click', function(e) {
                        if (!sampleDropdownBtn.contains(e.target) && !sampleDropdownMenu.contains(e
                                .target)) {
                            sampleDropdownMenu.classList.add('hidden');
                            sampleDropdownBtn.setAttribute('aria-expanded', 'false');
                        }
                    });
                }
            });

        });
        // Clear filters button for Tab 3
        document.getElementById('clearFiltersBtnTab3').addEventListener('click', function() {
            window.location.href = window.location.pathname;
        });
    </script>

    <script>
        function toggleDropdownDispatch(button, type) {
            const dropdownMenu = button.nextElementSibling;
            document.querySelectorAll('.dropdown-menu-' + type).forEach(menu => {
                if (menu !== dropdownMenu) menu.classList.add('hidden');
            });
            dropdownMenu.classList.toggle('hidden');
        }

        function selectDropdownOptionDispatch(button, selectedValue, type) {
            const dropdown = button.closest('.relative');
            dropdown.querySelector('.selected-' + type).innerText = selectedValue;
            dropdown.querySelector('.input-' + type).value = selectedValue;
            dropdown.querySelector('.dropdown-menu-' + type).classList.add('hidden');
        }

        function filterDropdownOptionsDispatch(input) {
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
            let container = document.getElementById("SampleProductionRecordsScroll");

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

        // Restore page scroll after full load (including images)
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
        function openDispatchModal(id) {
            document.getElementById('dispatch-modal-' + id).classList.remove('hidden');
        }

        function closeDispatchModal(id) {
            document.getElementById('dispatch-modal-' + id).classList.add('hidden');
        }

        function validateDispatchForm(form) {
            const checkboxes = form.querySelectorAll('.shade-checkbox');
            let atLeastOneSelected = false;
            let valid = true;
            let messages = [];

            checkboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    atLeastOneSelected = true;
                    const shadeId = checkbox.getAttribute('data-shade');

                    const productionOutput = form.querySelector(
                        `.shade-input-${shadeId}[name*="[production_output]"]`);
                    const damagedOutput = form.querySelector(`.shade-input-${shadeId}[name*="[damaged_output]"]`);
                    const dispatchInput = form.querySelector(
                        `.input-dispatch-${form.querySelector('input[name=production_id]').value}-${shadeId}`);

                    if (!productionOutput.value.trim()) {
                        valid = false;
                        messages.push(`Production output required for shade ${shadeId}`);
                    }
                    if (!damagedOutput.value.trim()) {
                        valid = false;
                        messages.push(`Damaged output required for shade ${shadeId}`);
                    }
                    if (!dispatchInput.value.trim()) {
                        valid = false;
                        messages.push(`Dispatch name required for shade ${shadeId}`);
                    }
                }
            });

            if (!atLeastOneSelected) {
                alert("Please select at least one shade.");
                return false;
            }

            if (!valid) {
                alert(messages.join("\n"));
                return false;
            }

            return true;
        }
    </script>
@endsection
