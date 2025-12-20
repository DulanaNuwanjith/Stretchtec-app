@php
    use Carbon\Carbon;
    use Illuminate\Support\Facades\Auth;
@endphp

<head>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <!-- Include Flatpickr (CDN) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <title>Stretchtec</title>
</head>

<div class="flex h-full w-full">
    @extends('layouts.production-tabs')

    @section('content')
        <div class="flex-1 overflow-y-hidden">
            <div class="">
                <div class="w-full px-6 lg:px-2">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-4 text-gray-900 dark:text-gray-100">

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
                                <button onclick="toggleReportForm()"
                                    class="bg-white border border-blue-500 text-blue-500 hover:text-blue-600 hover:border-blue-600 font-semibold py-1 px-3 rounded shadow flex items-center gap-2 mb-6 ml-2">
                                    Generate Report
                                </button>
                            </div>

                            <div id="filterFormContainer" class="hidden mt-4">
                                <!-- Mail Booking Filter Form -->
                                <form id="mailBookingFilterForm" method="GET" action="{{ route('mailBooking.index') }}"
                                    class="mb-6 sticky top-0 z-40 flex gap-6 items-center">
                                    <div class="flex items-center gap-4 flex-wrap">

                                        <!-- Mail Booking No -->
                                        <div class="relative inline-block text-left w-56">
                                            <label
                                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Mail
                                                Booking No</label>
                                            <div>
                                                <button type="button" id="mailBookingNoDropdown"
                                                    class="inline-flex w-full justify-between rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-gray-300 hover:bg-gray-50 h-10 dark:bg-gray-700 dark:text-white"
                                                    aria-haspopup="listbox" aria-expanded="false">
                                                    <span
                                                        id="selectedMailBookingNo">{{ request('mailBookingNo') ? request('mailBookingNo') : 'Select Mail Booking No' }}</span>
                                                    <svg class="ml-2 h-5 w-5 text-gray-400" viewBox="0 0 20 20"
                                                        fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                            d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 10.94l3.71-3.71a.75.75 0 1 1 1.06 1.06l-4.24 4.24a.75.75 0 0 1-1.06 0L5.25 8.29a.75.75 0 0 1-.02-1.08z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </div>
                                            <div id="mailBookingNoDropdownMenu"
                                                class="hidden absolute z-40 mt-2 w-full rounded-md bg-white shadow-lg ring-1 ring-black/5 dark:bg-gray-700 max-h-48 overflow-y-auto">
                                                <div class="p-2 sticky top-0 bg-white dark:bg-gray-700 z-10">
                                                    <input type="text" id="mailBookingNoSearchInput"
                                                        placeholder="Search..."
                                                        class="w-full px-2 py-1 text-sm border rounded-md dark:bg-gray-600 dark:text-white dark:placeholder-gray-300" />
                                                </div>
                                                <div class="py-1" role="listbox" tabindex="-1">
                                                    <button type="button"
                                                        class="mailBookingNo-option w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600">Select
                                                        Mail Booking No</button>
                                                    @isset($mailBookingNos)
                                                        @foreach ($mailBookingNos as $mbn)
                                                            <button type="button"
                                                                class="mailBookingNo-option w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600">{{ $mbn }}</button>
                                                        @endforeach
                                                    @endisset
                                                </div>
                                            </div>
                                            <input type="hidden" name="mailBookingNo" id="mailBookingNoInput"
                                                value="{{ request('mailBookingNo') }}">
                                        </div>

                                        <!-- Reference No -->
                                        <div class="relative inline-block text-left w-48">
                                            <label
                                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Reference
                                                No</label>
                                            <div>
                                                <button type="button" id="referenceNoDropdown"
                                                    class="inline-flex w-full justify-between rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-gray-300 hover:bg-gray-50 h-10 dark:bg-gray-700 dark:text-white"
                                                    aria-haspopup="listbox" aria-expanded="false">
                                                    <span
                                                        id="selectedReferenceNo">{{ request('referenceNo') ? request('referenceNo') : 'Select Reference No' }}</span>
                                                    <svg class="ml-2 h-5 w-5 text-gray-400" viewBox="0 0 20 20"
                                                        fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                            d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 10.94l3.71-3.71a.75.75 0 1 1 1.06 1.06l-4.24 4.24a.75.75 0 0 1-1.06 0L5.25 8.29a.75.75 0 0 1-.02-1.08z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </div>
                                            <div id="referenceNoDropdownMenu"
                                                class="hidden absolute z-40 mt-2 w-full rounded-md bg-white shadow-lg ring-1 ring-black/5 dark:bg-gray-700 max-h-48 overflow-y-auto">
                                                <div class="p-2 sticky top-0 bg-white dark:bg-gray-700 z-10">
                                                    <input type="text" id="referenceNoSearchInput"
                                                        placeholder="Search reference numbers..."
                                                        class="w-full px-2 py-1 text-sm border rounded-md dark:bg-gray-600 dark:text-white dark:placeholder-gray-300" />
                                                </div>
                                                <div class="py-1" role="listbox" tabindex="-1">
                                                    <button type="button"
                                                        class="referenceNo-option w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600">Select
                                                        Reference No</button>
                                                    @isset($referenceNumbers)
                                                        @foreach ($referenceNumbers as $ref)
                                                            <button type="button"
                                                                class="referenceNo-option w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600">{{ $ref }}</button>
                                                        @endforeach
                                                    @endisset
                                                </div>
                                            </div>
                                            <input type="hidden" name="referenceNo" id="referenceNoInput"
                                                value="{{ request('referenceNo') }}">
                                        </div>

                                        <!-- Email -->
                                        <div class="relative inline-block text-left w-56">
                                            <label
                                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
                                            <div>
                                                <button type="button" id="emailDropdown"
                                                    class="inline-flex w-full justify-between rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-gray-300 hover:bg-gray-50 h-10 dark:bg-gray-700 dark:text-white"
                                                    aria-haspopup="listbox" aria-expanded="false">
                                                    <span
                                                        id="selectedEmail">{{ request('email') ? request('email') : 'Select Email' }}</span>
                                                    <svg class="ml-2 h-5 w-5 text-gray-400" viewBox="0 0 20 20"
                                                        fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                            d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 10.94l3.71-3.71a.75.75 0 1 1 1.06 1.06l-4.24 4.24a.75.75 0 0 1-1.06 0L5.25 8.29a.75.75 0 0 1-.02-1.08z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </div>
                                            <div id="emailDropdownMenu"
                                                class="hidden absolute z-40 mt-2 w-full rounded-md bg-white shadow-lg ring-1 ring-black/5 dark:bg-gray-700 max-h-48 overflow-y-auto">
                                                <div class="p-2 sticky top-0 bg-white dark:bg-gray-700 z-10">
                                                    <input type="text" id="emailSearchInput"
                                                        placeholder="Search emails..."
                                                        class="w-full px-2 py-1 text-sm border rounded-md dark:bg-gray-600 dark:text-white dark:placeholder-gray-300" />
                                                </div>
                                                <div class="py-1" role="listbox" tabindex="-1">
                                                    <button type="button"
                                                        class="email-option w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600">Select
                                                        Email</button>
                                                    @isset($emails)
                                                        @foreach ($emails as $em)
                                                            <button type="button"
                                                                class="email-option w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600">{{ $em }}</button>
                                                        @endforeach
                                                    @endisset
                                                </div>
                                            </div>
                                            <input type="hidden" name="email" id="emailInput"
                                                value="{{ request('email') }}">
                                        </div>

                                        <!-- Coordinator (multi-select) -->
                                        <div class="relative inline-block text-left w-56">
                                            <label
                                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Coordinator</label>
                                            <div>
                                                <button type="button" id="coordinatorDropdown"
                                                    class="inline-flex w-full justify-between rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-gray-300 hover:bg-gray-50 h-10 dark:bg-gray-700 dark:text-white"
                                                    aria-haspopup="listbox" aria-expanded="false">
                                                    <span
                                                        id="selectedCoordinator">{{ request('coordinator') ? implode(', ', (array) request('coordinator')) : 'Select Coordinator(s)' }}</span>
                                                    <svg class="ml-2 h-5 w-5 text-gray-400" viewBox="0 0 20 20"
                                                        fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                            d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 10.94l3.71-3.71a.75.75 0 1 1 1.06 1.06l-4.24 4.24a.75.75 0 0 1-1.06 0L5.25 8.29a.75.75 0 0 1-.02-1.08z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </div>
                                            <div id="coordinatorDropdownMenu"
                                                class="hidden absolute z-40 mt-2 w-full rounded-md bg-white shadow-lg ring-1 ring-black/5 dark:bg-gray-700 max-h-48 overflow-y-auto">
                                                <div class="p-2 sticky top-0 bg-white dark:bg-gray-700 z-10">
                                                    <input type="text" id="coordinatorSearchInput"
                                                        placeholder="Search coordinators..."
                                                        class="w-full px-2 py-1 text-sm border rounded-md dark:bg-gray-600 dark:text-white dark:placeholder-gray-300" />
                                                </div>
                                                <div class="py-1" id="coordinatorOptions" role="listbox"
                                                    tabindex="-1">
                                                    @isset($coordinators)
                                                        @foreach ($coordinators as $coord)
                                                            <label
                                                                class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600">
                                                                <input type="checkbox" name="coordinator[]"
                                                                    value="{{ $coord }}"
                                                                    {{ in_array($coord, (array) request('coordinator', [])) ? 'checked' : '' }}
                                                                    class="mr-2 coordinator-checkbox">
                                                                {{ $coord }}
                                                            </label>
                                                        @endforeach
                                                    @endisset
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Merchandiser -->
                                        <div class="relative inline-block text-left w-48">
                                            <label
                                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Merchandiser</label>
                                            <div>
                                                <button type="button" id="merchandiserDropdown"
                                                    class="inline-flex w-full justify-between rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-gray-300 hover:bg-gray-50 h-10 dark:bg-gray-700 dark:text-white"
                                                    aria-haspopup="listbox" aria-expanded="false">
                                                    <span
                                                        id="selectedMerchandiser">{{ request('merchandiser') ? request('merchandiser') : 'Select Merchandiser' }}</span>
                                                    <svg class="ml-2 h-5 w-5 text-gray-400" viewBox="0 0 20 20"
                                                        fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                            d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 10.94l3.71-3.71a.75.75 0 1 1 1.06 1.06l-4.24 4.24a.75.75 0 0 1-1.06 0L5.25 8.29a.75.75 0 0 1-.02-1.08z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </div>
                                            <div id="merchandiserDropdownMenu"
                                                class="hidden absolute z-40 mt-2 w-full rounded-md bg-white shadow-lg ring-1 ring-black/5 dark:bg-gray-700 max-h-48 overflow-y-auto">
                                                <div class="p-2 sticky top-0 bg-white dark:bg-gray-700 z-10">
                                                    <input type="text" id="merchandiserSearchInput"
                                                        placeholder="Search merchandisers..."
                                                        class="w-full px-2 py-1 text-sm border rounded-md dark:bg-gray-600 dark:text-white dark:placeholder-gray-300" />
                                                </div>
                                                <div class="py-1" role="listbox" tabindex="-1">
                                                    <button type="button"
                                                        class="merchandiser-option w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600">Select
                                                        Merchandiser</button>
                                                    @isset($merchandisers)
                                                        @foreach ($merchandisers as $merch)
                                                            <button type="button"
                                                                class="merchandiser-option w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600">{{ $merch }}</button>
                                                        @endforeach
                                                    @endisset
                                                </div>
                                            </div>
                                            <input type="hidden" name="merchandiser" id="merchandiserInput"
                                                value="{{ request('merchandiser') }}">
                                        </div>

                                        <!-- Customer Name -->
                                        <div class="relative inline-block text-left w-48">
                                            <label
                                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Customer</label>
                                            <div>
                                                <button type="button" id="customerDropdown"
                                                    class="inline-flex w-full justify-between rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-gray-300 hover:bg-gray-50 h-10 dark:bg-gray-700 dark:text-white"
                                                    aria-haspopup="listbox" aria-expanded="false">
                                                    <span
                                                        id="selectedCustomer">{{ request('customer') ? request('customer') : 'Select Customer' }}</span>
                                                    <svg class="ml-2 h-5 w-5 text-gray-400" viewBox="0 0 20 20"
                                                        fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                            d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 10.94l3.71-3.71a.75.75 0 1 1 1.06 1.06l-4.24 4.24a.75.75 0 0 1-1.06 0L5.25 8.29a.75.75 0 0 1-.02-1.08z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </div>
                                            <div id="customerDropdownMenu"
                                                class="hidden absolute z-40 mt-2 w-full rounded-md bg-white shadow-lg ring-1 ring-black/5 dark:bg-gray-700 max-h-48 overflow-y-auto">
                                                <div class="p-2 sticky top-0 bg-white dark:bg-gray-700 z-10">
                                                    <input type="text" id="customerSearchInput"
                                                        placeholder="Search customers..."
                                                        class="w-full px-2 py-1 text-sm border rounded-md dark:bg-gray-600 dark:text-white dark:placeholder-gray-300" />
                                                </div>
                                                <div class="py-1" role="listbox" tabindex="-1">
                                                    <button type="button"
                                                        class="customer-option w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600">Select
                                                        Customer</button>
                                                    @isset($customers)
                                                        @foreach ($customers as $cust)
                                                            <button type="button"
                                                                class="customer-option w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600">{{ $cust }}</button>
                                                        @endforeach
                                                    @endisset
                                                </div>
                                            </div>
                                            <input type="hidden" name="customer" id="customerInput"
                                                value="{{ request('customer') }}">
                                        </div>

                                        <div class="relative inline-block text-left w-48">
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                Status</label>
                                            <div class="relative inline-block w-full">
                                                <button id="approvalStatusDropdown" type="button"
                                                    class="inline-flex w-full justify-between rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-gray-300 hover:bg-gray-50 h-10 dark:bg-gray-700 dark:text-white">
                                                    <span
                                                        id="selectedApprovalStatus">{{ request('isApproved') === '1' ? 'Approved' : (request('isApproved') === '0' ? 'Not Approved' : 'Select Status') }}</span>
                                                    <svg class="w-4 h-4 text-gray-500" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                    </svg>
                                                </button>
                                                <div id="approvalStatusDropdownMenu"
                                                    class="hidden absolute z-40 mt-2 w-full rounded-md bg-white shadow-lg ring-1 ring-black/5 dark:bg-gray-700 max-h-48 overflow-y-auto">
                                                    <ul class="max-h-48 overflow-auto py-1 text-sm">
                                                        <li
                                                            class="approvalStatus-option cursor-pointer select-none px-3 py-2 hover:bg-gray-100">
                                                            Select Approval Status</li>
                                                        <li class="approvalStatus-option cursor-pointer select-none px-3 py-2 hover:bg-gray-100"
                                                            data-value="1">Approved</li>
                                                        <li class="approvalStatus-option cursor-pointer select-none px-3 py-2 hover:bg-gray-100"
                                                            data-value="0">Not Approved</li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <input id="isApprovedInput" type="hidden" name="isApproved"
                                                value="{{ request('isApproved') === '1' ? '1' : (request('isApproved') === '0' ? '0' : '') }}">
                                        </div>

                                        <!-- Order Received Date -->
                                        <div class="relative inline-block text-left w-48">
                                            <label
                                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Order
                                                Received Date</label>
                                            <input type="date" id="orderReceivedDate" name="orderReceivedDate"
                                                value="{{ request('orderReceivedDate') }}"
                                                class="w-full px-3 py-2 text-sm border rounded-md bg-white dark:bg-gray-700 dark:text-white dark:border-gray-600 h-10">
                                        </div>

                                        <div class="flex items-end space-x-2 mt-2">
                                            <button type="submit"
                                                class="mt-4 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Apply
                                                Filters</button>
                                            <button type="button" id="clearFiltersBtn"
                                                class="mt-4 bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-200 px-4 py-2 rounded hover:bg-gray-300">Clear
                                                Filters</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="flex justify-between items-center mb-6">
                                <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Mail Booking Inquiry
                                    Records
                                </h1>
                                <button onclick="document.getElementById('addSampleModal').classList.remove('hidden')"
                                    class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded shadow">
                                    + Add New Mail Booking Order
                                </button>
                            </div>

                            <!-- Add Sample Modal -->
                            <div id="addSampleModal"
                                class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center py-5">
                                <div class="w-full max-w-[700px] bg-white dark:bg-gray-900 rounded-2xl shadow-2xl p-4 transform transition-all scale-95 max-h-[calc(100vh-10rem)] overflow-y-auto"
                                    onclick="event.stopPropagation()">
                                    <div class="max-w-[600px] mx-auto p-8">
                                        <h2
                                            class="text-2xl font-semibold mb-8 text-blue-900 mt-4 dark:text-gray-100 text-center">
                                            Add New Mail Booking Order
                                        </h2>

                                        <!-- Unified Form -->
                                        <form id="unifiedOrderForm" action="{{ route('mailBooking.store') }}"
                                            method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div id="itemsContainer"></div>

                                            <button type="button" id="addItemBtn"
                                                class="mt-4 px-4 py-2 bg-green-500 text-white rounded text-sm">
                                                + Add Item
                                            </button>

                                            <!-- Master Order fields -->
                                            <div class="mt-3">
                                                <label
                                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Customer
                                                    Name</label>
                                                <input type="text" name="customer_name" required
                                                    class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                            </div>
                                            <div class="mt-3">
                                                <label
                                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Merchandiser
                                                    Name</label>
                                                <input type="text" name="merchandiser_name" required
                                                    class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                            </div>
                                            <div class="mt-3">
                                                <label
                                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email
                                                    Address</label>
                                                <input type="email" name="email" required
                                                    class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                            </div>
                                            <div class="mt-3">
                                                <label
                                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Customer
                                                    Coordinator</label>
                                                <input type="text" name="customer_coordinator" readonly
                                                    value="{{ Auth::user()->name }}"
                                                    class="w-full mt-1 px-3 py-2 border rounded-md bg-gray-100 dark:bg-gray-600 dark:text-white text-sm">
                                            </div>
                                            <div class="mt-3">
                                                <label
                                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Customer
                                                    Requested Date</label>
                                                <input type="date" name="customer_req_date"
                                                    class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                            </div>
                                            <div class="mt-3">
                                                <label
                                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Customer
                                                    Notes</label>
                                                <input type="text" name="remarks"
                                                    class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                            </div>

                                            <div class="flex justify-end mt-6 space-x-3">
                                                <button type="button" id="cancelForm"
                                                    onclick="document.getElementById('addSampleModal').classList.add('hidden')"
                                                    class="px-4 py-2 bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-200 text-sm rounded hover:bg-gray-300">
                                                    Cancel
                                                </button>
                                                <button type="submit"
                                                    class="px-4 py-2 bg-blue-500 text-white text-sm rounded hover:bg-blue-600">
                                                    Create Order
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div id="MailBookingDetailsScroll"
                                class="overflow-x-auto max-h-[1200px] bg-white dark:bg-gray-900 shadow rounded-lg">
                                <table class="table-fixed w-full text-sm divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead class="bg-gray-200 dark:bg-gray-700 text-left">
                                        <tr class="text-center">
                                            <th
                                                class="font-bold sticky left-0 top-0 z-20 bg-white px-4 py-3 w-36 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                Mail Booking No
                                            </th>
                                            <th
                                                class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-48 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                Reference Number
                                            </th>
                                            <th
                                                class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-36 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                Email Received
                                            </th>
                                            <th
                                                class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                Customer Coordinator
                                            </th>
                                            <th
                                                class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                Quantity
                                            </th>
                                            <th
                                                class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                Customer Name
                                            </th>
                                            <th
                                                class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                PO Value
                                            </th>
                                            <th
                                                class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                Requested Date
                                            </th>
                                            <th
                                                class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-48 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                Production Deadline
                                            </th>
                                            <th
                                                class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                Notes
                                            </th>
                                            <th
                                                class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-48 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                Approval
                                            </th>
                                            <th
                                                class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-48 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                Send to Stores
                                            </th>
                                            <th
                                                class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-48 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                Send to Production
                                            </th>
                                            <th
                                                class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                Status
                                            </th>
                                            <th
                                                class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                Customer Delivery Status
                                            </th>
                                            <th
                                                class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                Action
                                            </th>
                                        </tr>
                                    </thead>


                                    <tbody id="productionDetailsRecords"
                                        class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                        @forelse($mailBookings as $inquiry)
                                            <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200  text-left">
                                                @if ($inquiry->supplier === null)
                                                    <td
                                                        class="px-4 py-3 font-bold sticky left-0 z-10 bg-gray-100 whitespace-normal break-words border-r border-gray-300 text-blue-500">
                                                        {{ $inquiry->mail_booking_number ?? 'N/A' }}
                                                        <div class="text-xs font-normal text-gray-500">
                                                            Date:
                                                            {{ $inquiry->order_received_date ? Carbon::parse($inquiry->order_received_date)->format('Y-m-d') : '' }}
                                                            <br>
                                                            Time:
                                                            {{ $inquiry->order_received_date ? Carbon::parse($inquiry->order_received_date)->format('H:i') : '' }}
                                                        </div>
                                                    </td>
                                                @else
                                                    <td
                                                        class="px-4 py-3 font-bold sticky left-0 z-10 bg-gray-100 whitespace-normal break-words border-r border-gray-300">
                                                        {{ $inquiry->mail_booking_number ?? 'N/A' }}
                                                        <div class="text-xs font-normal text-gray-500">
                                                            Date:
                                                            {{ $inquiry->order_received_date ? Carbon::parse($inquiry->order_received_date)->format('Y-m-d') : '' }}
                                                            <br>
                                                            Time:
                                                            {{ $inquiry->order_received_date ? Carbon::parse($inquiry->order_received_date)->format('H:i') : '' }}
                                                        </div>
                                                    </td>
                                                @endif

                                                <!-- Reference Number -->
                                                <td
                                                    class="px-4 py-3 whitespace-normal break-words border-r border-gray-300  text-center">
                                                    <button type="button"
                                                        class="text-blue-600 dark:text-blue-400 font-medium hover:text-blue-800"
                                                        onclick="openDetailsModal(this)"
                                                        data-ref-no="{{ $inquiry->reference_no ?? '' }}"
                                                        data-shade="{{ $inquiry->shade ?? '' }}"
                                                        data-colour="{{ $inquiry->color ?? '' }}"
                                                        data-item="{{ $inquiry->item ?? '' }}"
                                                        data-tkt="{{ $inquiry->tkt ?? '' }}"
                                                        data-size="{{ $inquiry->size ?? '' }}"
                                                        data-supplier="{{ $inquiry->supplier ?? '' }}"
                                                        data-pstno="{{ $inquiry->pst_no ?? '' }}"
                                                        data-suppliercomment="{{ $inquiry->supplier_comment ?? '' }}">
                                                        {{ $inquiry->reference_no ?? 'N/A' }}
                                                    </button>
                                                </td>

                                                <!-- Email -->
                                                <td
                                                    class="px-4 py-3 whitespace-normal break-words border-r border-gray-300  text-center">
                                                    {{ $inquiry->email ?? 'N/A' }}</td>

                                                <!-- Customer Coordinator -->
                                                <td
                                                    class="px-4 py-3 whitespace-normal break-words border-r border-gray-300  text-center">
                                                    {{ $inquiry->customer_coordinator ?? 'N/A' }}</td>

                                                <!-- Quantity -->
                                                <td
                                                    class="px-4 py-3 whitespace-normal break-words border-r border-gray-300  text-center">
                                                    {{ $inquiry->qty ?? '0' }} {{ $inquiry->uom ?? 'N/A' }}</td>

                                                <!-- Customer Name -->
                                                <td
                                                    class="px-4 py-3 whitespace-normal break-words border-r border-gray-300  text-center">
                                                    {{ $inquiry->customer_name ?? 'N/A' }}<br><span
                                                        class="text-xs text-gray-500">{{ $inquiry->merchandiser_name ?? 'N/A' }}</span>
                                                </td>

                                                <!-- PO Value -->
                                                <td
                                                    class="px-4 py-3 whitespace-normal break-words border-r border-gray-300  text-center text-green-600 font-medium">
                                                    {{ $inquiry->price ? '$  ' . number_format($inquiry->price, 2) : '0' }}
                                                    <br>
                                                    <span class="mt-2 text-xs text-blue-700 font-semibold">($
                                                        {{ $inquiry->unitPrice }} X {{ $inquiry->qty }})</span>
                                                </td>

                                                <!-- Requested Date -->
                                                <td
                                                    class="px-4 py-3 whitespace-normal break-words border-r border-gray-300  text-center">
                                                    {{ $inquiry->customer_req_date ?? 'N/A' }}</td>

                                                <!-- Production Deadline -->
                                                <td class="px-4 py-3 border-r border-gray-300 text-center">
                                                    @if ($inquiry->production_deadline)
                                                        <div class="flex flex-col">
                                                            <span class="font-medium">
                                                                {{ Carbon::parse($inquiry->production_deadline)->format('Y-m-d') }}
                                                            </span>
                                                            @if ($inquiry->deadline_reason)
                                                                <span class="text-xs text-gray-500 italic mt-1">
                                                                    {{ $inquiry->deadline_reason }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                    @else
                                                        <span class="text-red-600 text-sm">Deadline Not Set</span>
                                                    @endif
                                                </td>

                                                <!-- Notes -->
                                                <td
                                                    class="px-4 py-3 whitespace-normal break-words border-r border-gray-300  text-center text-gray-500 italic">
                                                    {{ $inquiry->remarks ?? '-' }}
                                                </td>

                                                <td
                                                    class="px-2 py-3 whitespace-normal break-words border-r border-gray-300 text-center">
                                                    <div class="approval-status flex flex-col justify-center items-center">

                                                        {{-- Case 1: Not sent for approval yet --}}
                                                        @if (!$inquiry->isSentForApproval && !$inquiry->isApproved)
                                                            <form
                                                                action="{{ route('mailBookingApproval.store', $inquiry->id) }}"
                                                                method="GET" onsubmit="handleSubmit(this)">
                                                                @csrf
                                                                <button type="submit"
                                                                    class="px-3 py-1 mt-2 text-xs rounded-lg bg-red-100 text-red-700 hover:bg-red-200 flex items-center justify-center"
                                                                    id="sendForApprovalBtn-{{ $inquiry->id }}">
                                                                    Send for Approval
                                                                </button>
                                                            </form>

                                                            {{-- Case 2: Sent for approval but not yet approved --}}
                                                        @elseif ($inquiry->isSentForApproval && !$inquiry->isApproved)
                                                            <span
                                                                class="inline-block m-1 text-sm font-semibold text-yellow-700 bg-yellow-100 dark:bg-gray-800 px-3 py-1 rounded">
                                                                Sent for Approval
                                                            </span>

                                                            {{-- Case 3: Sent for approval and approved --}}
                                                        @elseif ($inquiry->isSentForApproval && $inquiry->isApproved)
                                                            <span
                                                                class="inline-block m-1 text-sm font-semibold text-green-700 bg-green-100 dark:bg-gray-800 px-3 py-1 rounded">
                                                                Approved by {{ $inquiry->approvedBy?->name ?? 'N/A' }} <br>
                                                                {{ \Carbon\Carbon::parse($inquiry->approved_at)->format('Y-m-d') }}
                                                                at
                                                                {{ \Carbon\Carbon::parse($inquiry->approved_at)->format('H:i') }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </td>

                                                <td
                                                    class="py-3 whitespace-normal break-words border-r border-gray-300 text-center">
                                                    <div
                                                        class="colour-match-stock flex flex-col justify-center items-center">
                                                        @if (!$inquiry->isSentToStock && !$inquiry->canSendToProduction)
                                                            {{-- Show button if neither is true --}}
                                                            <form
                                                                action="{{ route('production.sendToStoreMail', $inquiry->id) }}"
                                                                method="POST" onsubmit="handleSubmit(this)">
                                                                @csrf
                                                                <button type="submit"
                                                                    @if (!$inquiry->isApproved) disabled @endif
                                                                    class="px-3 py-1 text-xs rounded-lg
                                                                               {{ !$inquiry->isApproved
                                                                                   ? 'bg-gray-200 text-gray-400 cursor-not-allowed'
                                                                                   : 'bg-blue-100 text-blue-700 hover:bg-blue-200' }}
                                                                               mt-4 flex items-center justify-center"
                                                                    id="sendToStoreBtn-{{ $inquiry->id }}">
                                                                    Send to Stores
                                                                </button>
                                                            </form>

                                                            {{-- Show note BELOW the button --}}
                                                            @if (!$inquiry->isApproved)
                                                                <span class="text-xs text-red-500 italic block">
                                                                    Requires approval first
                                                                </span>
                                                            @endif
                                                        @elseif($inquiry->isSentToStock && $inquiry->canSendToProduction && !$inquiry->sent_to_stock_at)
                                                            {{-- No stock available (red) --}}
                                                            <span
                                                                class="inline-block m-1 text-sm font-semibold text-red-700 bg-red-100 dark:bg-gray-800 px-3 py-1 rounded">
                                                                No Stock Available
                                                            </span>
                                                        @elseif($inquiry->isSentToStock && !$inquiry->canSendToProduction)
                                                            {{-- Sent to stock only (blue) --}}
                                                            <span
                                                                class="inline-block m-1 text-sm font-semibold text-blue-700 bg-blue-100 dark:bg-gray-800 px-3 py-1 rounded text-center">
                                                                Sent on <br>
                                                                {{ Carbon::parse($inquiry->sent_to_stock_at)->format('Y-m-d') }}
                                                                at
                                                                {{ Carbon::parse($inquiry->sent_to_stock_at)->format('H:i') }}
                                                            </span>
                                                        @elseif($inquiry->isSentToStock && $inquiry->canSendToProduction)
                                                            {{-- Both conditions true (green) --}}
                                                            <span
                                                                class="inline-block m-1 text-sm font-semibold text-green-700 bg-green-100 dark:bg-gray-800 px-3 py-1 rounded text-center">
                                                                Ready for Production <br>
                                                                {{ Carbon::parse($inquiry->sent_to_stock_at)->format('Y-m-d') }}
                                                                at
                                                                {{ Carbon::parse($inquiry->sent_to_stock_at)->format('H:i') }}
                                                            </span>
                                                        @endif
                                                    </div>

                                                    @if ($inquiry->isSentToStock && $inquiry->canSendToProduction && $inquiry->sent_to_stock_at)
                                                        <ul class="mt-2 text-xs text-green-700 font-semibold">
                                                            @forelse($inquiry->stores as $store)
                                                                <li>{{ $store->reference_no }}
                                                                    → {{ $store->qty_allocated ?? 0 }}
                                                                    {{ $store->allocated_uom ?? 'NA' }}</li>
                                                            @empty
                                                                <li>No allocations yet</li>
                                                            @endforelse
                                                        </ul>
                                                    @endif
                                                </td>

                                                <!-- Send to Production -->
                                                <td
                                                    class="py-3 whitespace-normal break-words border-r border-gray-300 text-center">
                                                    @if ($inquiry->canSendToProduction === 1)
                                                        <div class="colour-match-production">
                                                            @if ($inquiry->status === 'Ready For Delivery - Direct')
                                                                <!-- ✅ Always show this label when status is 'Ready For Delivery - Direct' -->
                                                                <span
                                                                    class="inline-block m-1 text-sm font-semibold text-green-700 bg-green-100 dark:bg-gray-800 px-3 py-1 rounded">
                                                                    No need of Production
                                                                </span>
                                                            @elseif ($inquiry->isSentToProduction)
                                                                <!-- ✅ Show timestamp only if sent to production AND status is not 'Ready For Delivery - Direct' -->
                                                                <span
                                                                    class="inline-block m-1 text-sm font-semibold text-gray-700 dark:text-white bg-yellow-100 dark:bg-gray-800 px-3 py-1 rounded">
                                                                    Sent on <br>
                                                                    {{ Carbon::parse($inquiry->sent_to_production_at)->format('Y-m-d') }}
                                                                    at
                                                                    {{ Carbon::parse($inquiry->sent_to_production_at)->format('H:i') }}
                                                                </span>
                                                            @else
                                                                <!-- ✅ Pending or ready-to-send state -->
                                                                @if (Auth::user()->role === 'ADMIN')
                                                                    <!-- Admin sees disabled button -->
                                                                    <button type="button"
                                                                        class="px-3 py-1 text-xs rounded-lg bg-gray-200 text-gray-500 cursor-not-allowed"
                                                                        disabled>
                                                                        Pending
                                                                    </button>
                                                                @else
                                                                    <div class="flex justify-center items-center">
                                                                        <!-- Other users see the active Send button -->
                                                                        <form
                                                                            action="{{ route('production-inquiry.sendToProductionMail', $inquiry->id) }}"
                                                                            method="POST" onsubmit="handleSubmit(this)">
                                                                            @csrf
                                                                            @method('PATCH')
                                                                            <button type="submit"
                                                                                class="px-3 py-1 mt-4 text-xs rounded-lg bg-indigo-100 text-indigo-700 hover:bg-indigo-200 flex items-center justify-center"
                                                                                id="sendToProductionBtn-{{ $inquiry->id }}">
                                                                                Send to Production
                                                                            </button>
                                                                        </form>
                                                                    </div>
                                                                @endif
                                                            @endif
                                                        </div>
                                                    @else
                                                        <!-- ✅ Disabled button when cannot send to production -->
                                                        <button type="button"
                                                            class="px-3 py-1 text-xs rounded-lg bg-gray-200 text-gray-500 cursor-not-allowed"
                                                            disabled>
                                                            Send to Production
                                                        </button>
                                                    @endif
                                                </td>


                                                <!-- Status -->
                                                <td
                                                    class="px-4 py-3 whitespace-normal break-words border-r border-gray-300 text-center">
                                                    <span
                                                        class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full shadow-sm
                                                    {{ $inquiry->status === 'Completed'
                                                        ? 'bg-green-100 text-green-700 border border-green-300'
                                                        : ($inquiry->status === 'Pending'
                                                            ? 'bg-yellow-100 text-yellow-700 border border-yellow-300'
                                                            : 'bg-gray-100 text-gray-600 border border-gray-300') }}">
                                                        {{ $inquiry->status ?? 'Pending' }}
                                                    </span>
                                                </td>


                                                <!-- Customer Delivery Status -->
                                                <td
                                                    class="px-4 py-3 whitespace-normal break-words border-r border-gray-300 text-center">
                                                    @if ($inquiry->status === 'Ready For Delivery' || $inquiry->status === 'Ready For Delivery - Direct')
                                                        <div class="flex justify-center items-center">
                                                            <form action="#" method="POST"
                                                                onsubmit="handleSubmit(this)">
                                                                @csrf
                                                                @method('PATCH')
                                                                <button type="submit"
                                                                    class="px-3 py-1 mt-4 text-xs rounded-lg bg-indigo-100 text-indigo-700 hover:bg-indigo-200 flex items-center justify-center">
                                                                    Deliver to Customer
                                                                </button>
                                                            </form>
                                                        </div>
                                                    @elseif ($inquiry->status === 'Delivered')
                                                        <span
                                                            class="inline-block m-1 text-sm font-semibold text-green-700 bg-green-100 px-3 py-1 rounded">
                                                            Delivered
                                                        </span>
                                                    @else
                                                        <span class="text-gray-500 italic">No action available</span>
                                                    @endif
                                                </td>

                                                <!-- Action -->
                                                <td
                                                    class="px-4 py-3 whitespace-normal break-words border-r border-gray-300  text-center">
                                                    <form id="delete-form-{{ $inquiry->id }}" method="POST"
                                                        action="{{ route('production-inquery-details.destroy', $inquiry->id) }}"
                                                        class="flex justify-center">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button"
                                                            onclick="confirmDelete('{{ $inquiry->id }}')"
                                                            class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-xs shadow-sm my-2">
                                                            Delete
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="14"
                                                    class="px-4 py-6 text-center text-gray-500 dark:text-gray-400">
                                                    No inquiries found.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <div class="py-6 flex justify-center">
                                {{ $mailBookings->links() }}
                            </div>

                            <!-- Details Modal -->
                            <div id="detailsModal"
                                class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
                                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-1/3 p-6">
                                    <h2 class="text-xl font-bold mb-4">Order Details</h2>
                                    <div id="modalContent" class="space-y-2">
                                        <!-- Details will be injected dynamically -->
                                    </div>
                                    <div class="mt-4 flex justify-end">
                                        <button onclick="closeDetailsModal()"
                                            class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">
                                            Close
                                        </button>
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
        document.addEventListener("DOMContentLoaded", function() {
            let container = document.getElementById("MailBookingDetailsScroll");

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
        // Generic dropdown binding
        function bindDropdown(buttonId, menuId, optionClass, selectedSpanId, inputId, searchInputId) {
            const button = document.getElementById(buttonId);
            const menu = document.getElementById(menuId);
            const selectedSpan = document.getElementById(selectedSpanId);
            const hiddenInput = document.getElementById(inputId);

            if (button) {
                button.addEventListener('click', () => menu.classList.toggle('hidden'));
            }

            document.querySelectorAll(`#${menuId} .${optionClass}`).forEach(opt => {
                opt.addEventListener('click', () => {
                    const val = opt.textContent.trim();
                    selectedSpan.textContent = val;
                    hiddenInput.value = val.includes('Select') ? '' : val;
                    menu.classList.add('hidden');
                });
            });

            if (searchInputId) {
                const searchInput = document.getElementById(searchInputId);
                if (searchInput) {
                    searchInput.addEventListener('input', () => {
                        const filter = searchInput.value.toLowerCase();
                        document.querySelectorAll(`#${menuId} .${optionClass}`).forEach(option => {
                            option.style.display = option.textContent.toLowerCase().includes(filter) ? '' :
                                'none';
                        });
                    });
                }
            }
        }

        bindDropdown('approvalStatusDropdown',
            'approvalStatusDropdownMenu',
            'approvalStatus-option',
            'selectedApprovalStatus',
            'isApprovedInput',
            'approvalStatusSearchInput');

        document.querySelectorAll('#approvalStatusDropdownMenu .approvalStatus-option').forEach(opt => {
            opt.addEventListener('click', () => {
                const val = opt.dataset.value ?? '';
                document.getElementById('selectedApprovalStatus').textContent =
                    val === '1' ? 'Approved' : (val === '0' ? 'Not Approved' : 'Select Approval Status');
                document.getElementById('isApprovedInput').value = val;
                document.getElementById('approvalStatusDropdownMenu').classList.add('hidden');
            });
        });

        // Bind single-select dropdowns
        bindDropdown('mailBookingNoDropdown', 'mailBookingNoDropdownMenu', 'mailBookingNo-option', 'selectedMailBookingNo',
            'mailBookingNoInput', 'mailBookingNoSearchInput');
        bindDropdown('referenceNoDropdown', 'referenceNoDropdownMenu', 'referenceNo-option', 'selectedReferenceNo',
            'referenceNoInput', 'referenceNoSearchInput');
        bindDropdown('emailDropdown', 'emailDropdownMenu', 'email-option', 'selectedEmail', 'emailInput',
            'emailSearchInput');
        bindDropdown('merchandiserDropdown', 'merchandiserDropdownMenu', 'merchandiser-option', 'selectedMerchandiser',
            'merchandiserInput', 'merchandiserSearchInput');
        bindDropdown('customerDropdown', 'customerDropdownMenu', 'customer-option', 'selectedCustomer', 'customerInput',
            'customerSearchInput');

        // Close dropdowns when clicking outside (single + multi-select)
        const filters = ['mailBookingNo', 'referenceNo', 'email', 'merchandiser', 'customer', 'approvalStatus'];
        const multiSelectFilters = ['coordinator'];

        document.addEventListener('click', (e) => {
            [...filters, ...multiSelectFilters].forEach(type => {
                const menu = document.getElementById(`${type}DropdownMenu`);
                const button = document.getElementById(`${type}Dropdown`);
                if (menu && button && !menu.contains(e.target) && !button.contains(e.target)) {
                    menu.classList.add('hidden');
                    button.setAttribute('aria-expanded', 'false');
                }
            });
        });

        // Coordinator multi-select label update
        const coordinatorBtn = document.getElementById('coordinatorDropdown');
        const coordinatorMenu = document.getElementById('coordinatorDropdownMenu');
        const coordinatorLabel = document.getElementById('selectedCoordinator');
        const coordinatorSearch = document.getElementById('coordinatorSearchInput');

        if (coordinatorBtn) {
            coordinatorBtn.addEventListener('click', () => coordinatorMenu.classList.toggle('hidden'));
        }

        function updateCoordinatorLabel() {
            const checked = Array.from(document.querySelectorAll('.coordinator-checkbox'))
                .filter(cb => cb.checked)
                .map(cb => cb.value);
            coordinatorLabel.textContent = checked.length ? checked.join(', ') : 'Select Coordinator(s)';
        }

        document.querySelectorAll('.coordinator-checkbox').forEach(cb => {
            cb.addEventListener('change', updateCoordinatorLabel);
        });

        if (coordinatorSearch) {
            coordinatorSearch.addEventListener('input', () => {
                const filter = coordinatorSearch.value.toLowerCase();
                document.querySelectorAll('#coordinatorOptions label').forEach(lbl => {
                    lbl.style.display = lbl.textContent.toLowerCase().includes(filter) ? '' : 'none';
                });
            });
        }

        // Clear filters
        const clearBtn = document.getElementById('clearFiltersBtn');
        if (clearBtn) {
            clearBtn.addEventListener('click', () => {
                const url = new URL(window.location.href);
                url.search = '';
                window.location.href = url.toString();
            });
        }
    </script>

    <script>
        function openDetailsModal(button) {
            const fields = {
                "Ref No": button.dataset.refNo,
                "Shade": button.dataset.shade,
                "Colour": button.dataset.colour,
                "Item": button.dataset.item,
                "TKT": button.dataset.tkt,
                "Size": button.dataset.size,
                "Supplier": button.dataset.supplier,
                "PST No": button.dataset.pstno,
                "Supplier Comment": button.dataset.suppliercomment
            };

            let html = "";

            Object.entries(fields).forEach(([label, value]) => {
                if (value && value !== "null" && value.trim() !== "") {
                    html += `<p><strong>${label}:</strong> ${value}</p>`;
                }
            });

            document.getElementById("modalContent").innerHTML = html || "<p>No details available.</p>";

            document.getElementById("detailsModal").classList.remove("hidden");
        }

        function closeDetailsModal() {
            document.getElementById("detailsModal").classList.add("hidden");
        }
    </script>

    <script>
        function handleSubmit(form) {
            let btn = form.querySelector("button[type='submit']");
            btn.disabled = true;

            // Replace text with loading spinner
            btn.innerHTML = `
            <svg class="animate-spin h-4 w-4 mr-2 text-blue-700" xmlns="http://www.w3.org/2000/svg" fill="none"
                 viewBox="0 0 24 24">
                 <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                 <path class="opacity-75" fill="currentColor"
                       d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
            </svg>
            Processing...
        `;

            // Allow form to continue submitting
            return true;
        }
    </script>

    <script>
        function handleSubmit(form) {
            let btn = form.querySelector("button[type='submit']");
            btn.disabled = true;

            // Replace button content with loading spinner
            btn.innerHTML = `
            <svg class="animate-spin h-4 w-4 mr-2 text-indigo-700" xmlns="http://www.w3.org/2000/svg" fill="none"
                 viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor"
                      d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
            </svg>
            Processing...
        `;

            return true; // allow form to submit
        }
    </script>

    <script>
        let itemIndex = 0;

        document.addEventListener('DOMContentLoaded', () => {
            const form = document.querySelector('#unifiedOrderForm');
            const submitBtn = form.querySelector("button[type='submit']");
            document.getElementById("addItemBtn").addEventListener("click", addItem);

            form.addEventListener('submit', function() {
                submitBtn.disabled = true;

                submitBtn.innerHTML = `
            <span class="flex items-center justify-center">
                <svg class="animate-spin h-4 w-4 mr-2 text-blue-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                </svg>
                <span>Processing...</span>
            </span>
        `;
            });
        });

        function addItem() {
            const container = document.getElementById("itemsContainer");

            const itemHTML = `
    <div class="item-group border rounded-md p-4 mb-4 bg-gray-50 dark:bg-gray-800" data-index="${itemIndex}">

        <!-- Order Type -->
        <div class="mt-3">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Order Type</label>
            <select name="items[${itemIndex}][order_type]" onchange="renderFields(this)"
                class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                <option value="">Select Order Type</option>
                <option value="sample">Sample</option>
                <option value="direct">Direct</option>
            </select>
        </div>

        <!-- Field container -->
        <div class="item-fields mt-3"></div>

        <!-- Remove button -->
        <div class="flex justify-end mt-4">
            <button type="button" onclick="removeItem(this)"
                class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 text-sm">
                Remove
            </button>
        </div>
    </div>
    `;

            container.insertAdjacentHTML("beforeend", itemHTML);
            itemIndex++;
        }

        function removeItem(button) {
            const container = document.getElementById("itemsContainer");
            const allItems = container.querySelectorAll('.item-group');
            if (allItems.length > 1) {
                button.closest(".item-group").remove();
            } else {
                alert("You must keep at least one item.");
            }
        }

        function renderFields(select) {
            const type = select.value;
            const index = select.closest(".item-group").dataset.index;
            const fieldsContainer = select.closest(".item-group").querySelector(".item-fields");

            if (!type) {
                fieldsContainer.innerHTML = "";
                return;
            }

            if (type === "sample") {
                fieldsContainer.innerHTML = getSampleFieldsHTML(index);
            } else if (type === "direct") {
                fieldsContainer.innerHTML = getDirectFieldsHTML(index);
            }
        }

        function getSampleFieldsHTML(index) {
            return `
    <div class="mt-3">
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Sample Reference</label>
        <div class="relative">
            <button type="button" class="sampleReferenceDropdown w-full inline-flex justify-between rounded-md bg-white px-3 py-2 text-sm font-semibold shadow-sm ring-1 ring-gray-300 hover:bg-gray-50 h-10"
                    onclick="toggleDropdown(this)" aria-haspopup="listbox">
                <span class="selectedSampleReference">Select Sample Reference</span>
                <svg class="ml-2 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.25 8.29a.75.75 0 01-.02-1.08z" clip-rule="evenodd"/>
                </svg>
            </button>
            <div class="dropdownMenu absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto hidden">
                <div class="sticky top-0 bg-white px-2 py-1">
                    <input type="text" placeholder="Search reference..." onkeyup="filterSamples(this)"
                           class="w-full px-2 py-1 text-sm border rounded-md focus:outline-none"/>
                </div>
                <ul class="sampleOptions max-h-48 overflow-y-auto">
                    @foreach ($samples as $sample)
        <li class="cursor-pointer select-none px-3 py-2 hover:bg-gray-100"
            onclick="selectSampleReference(this, '{{ $sample->id }}', '{{ $sample->reference_no }}', ${index})">
                            {{ $sample->reference_no }}
        </li>
@endforeach
        </ul>
    </div>
</div>
<input type="hidden" name="items[${index}][sample_id]" class="sampleReferenceHidden">
    </div>

    <div class="grid grid-cols-2 gap-4 mt-3">
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Shade</label>
            <input type="text" name="items[${index}][shade]" readonly class="sampleShade w-full mt-1 px-3 py-2 border rounded-md bg-gray-100 dark:bg-gray-600 dark:text-white text-sm">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Color</label>
            <input type="text" name="items[${index}][color]" readonly class="sampleColour w-full mt-1 px-3 py-2 border rounded-md bg-gray-100 dark:bg-gray-600 dark:text-white text-sm">
        </div>
    </div>

    <div class="grid grid-cols-2 gap-4 mt-3">
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">TKT</label>
            <input type="text" name="items[${index}][tkt]" readonly class="sampleTKT w-full mt-1 px-3 py-2 border rounded-md bg-gray-100 dark:bg-gray-600 dark:text-white text-sm">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Size</label>
            <input type="text" name="items[${index}][size]" readonly class="sampleSize w-full mt-1 px-3 py-2 border rounded-md bg-gray-100 dark:bg-gray-600 dark:text-white text-sm">
        </div>
    </div>

    <div class="grid grid-cols-2 gap-4 mt-3">
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Item</label>
            <input type="text" name="items[${index}][item]" readonly class="sampleItem w-full mt-1 px-3 py-2 border rounded-md bg-gray-100 dark:bg-gray-600 dark:text-white text-sm">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Supplier</label>
            <input type="text" name="items[${index}][supplier]" readonly class="sampleSupplier w-full mt-1 px-3 py-2 border rounded-md bg-gray-100 dark:bg-gray-600 dark:text-white text-sm">
        </div>
    </div>

    <div class="grid grid-cols-4 gap-4 mt-3">
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Qty</label>
            <input type="number" name="items[${index}][qty]" class="sampleQty w-full mt-1 px-3 py-2 border rounded-md text-sm" placeholder="Qty" oninput="updatePOValue(this)">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">UOM</label>
            <select name="items[${index}][uom]" class="sampleUom w-full mt-1 px-3 py-2 border rounded-md text-sm">
                <option value="meters">Meters</option>
                <option value="yards">Yards</option>
                <option value="pieces">Pieces</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Unit Price</label>
            <input type="number" step="0.01" name="items[${index}][unitPrice]" class="sampleUnitPrice w-full mt-1 px-3 py-2 border rounded-md text-sm" placeholder="Unit Price" oninput="updatePOValue(this)">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">PO Value</label>
            <input type="text" name="items[${index}][price]" readonly placeholder="PO Value" class="samplePOValue w-full mt-1 px-3 py-2 border rounded-md bg-gray-100 dark:bg-gray-600 dark:text-white text-sm">
        </div>
    </div>
    `;
        }

        function getDirectFieldsHTML(index) {
            return `
    <div class="grid grid-cols-2 gap-4 mt-3">
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Shade</label>
            <input type="text" name="items[${index}][shade]" placeholder="Shade"
                class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Color</label>
            <input type="text" name="items[${index}][color]" placeholder="Color"
                class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
        </div>
    </div>

    <div class="grid grid-cols-3 gap-4 mt-3">
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Size</label>
            <input type="text" name="items[${index}][size]" placeholder="Size"
                class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Quantity</label>
            <input type="number" name="items[${index}][qty]" placeholder="Quantity"
                class="w-full mt-1 px-3 py-2 border rounded-md text-sm" oninput="updatePOValue(this)">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">UOM</label>
            <select name="items[${index}][uom]"
                class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                <option value="meters">Meters</option>
                <option value="yards">Yards</option>
                <option value="pieces">Pieces</option>
            </select>
        </div>
    </div>

    <div class="mt-3">
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Item</label>
        <input type="text" name="items[${index}][item]" placeholder="Item"
            class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
    </div>

    <div class="grid grid-cols-2 gap-4 mt-3">
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Unit Price</label>
            <input type="number" step="0.01" name="items[${index}][unitPrice]" placeholder="Unit Price"
                class="w-full mt-1 px-3 py-2 border rounded-md text-sm" oninput="updatePOValue(this)">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">PO Value</label>
            <input type="text" name="items[${index}][price]" readonly placeholder="PO Value"
                class="w-full mt-1 px-3 py-2 border rounded-md bg-gray-100 dark:bg-gray-600 dark:text-white text-sm">
        </div>
    </div>
    `;
        }

        function toggleDropdown(button) {
            button.nextElementSibling.classList.toggle("hidden");
        }

        function filterSamples(input) {
            const filter = input.value.toLowerCase();
            const options = input.closest(".dropdownMenu").querySelectorAll("li");
            options.forEach(option => {
                option.style.display = option.textContent.toLowerCase().includes(filter) ? "" : "none";
            });
        }

        function selectSampleReference(element, sampleId, referenceNo, index) {
            const group = document.querySelector(`.item-group[data-index="${index}"]`);
            group.querySelector(".selectedSampleReference").innerText = referenceNo;
            group.querySelector(".sampleReferenceHidden").value = sampleId;
            group.querySelector(".dropdownMenu").classList.add("hidden");

            const base = "{{ url('product-catalog') }}";
            fetch(`${base}/${sampleId}/details`)
                .then(resp => resp.json())
                .then(data => {
                    group.querySelector(".sampleShade").value = data.shade || '';
                    group.querySelector(".sampleColour").value = data.colour || '';
                    group.querySelector(".sampleTKT").value = data.tkt || '';
                    group.querySelector(".sampleSize").value = data.size || '';
                    group.querySelector(".sampleItem").value = data.item || '';
                    group.querySelector(".sampleSupplier").value = data.supplier || '';
                })
                .catch(err => console.error('Error fetching sample details:', err));
        }

        function updatePOValue(element) {
            const itemGroup = element.closest('.item-group');
            const qty = parseFloat(itemGroup.querySelector('input[name*="[qty]"]')?.value) || 0;
            const unitPrice = parseFloat(itemGroup.querySelector('input[name*="[unitPrice]"]')?.value) || 0;
            const poValueField = itemGroup.querySelector('input[name*="[price]"]');
            if (poValueField) {
                poValueField.value = (qty * unitPrice).toFixed(2);
            }
        }
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
