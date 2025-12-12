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
                            </div>

                            <div id="filterFormContainer" class="hidden mt-4">
                                <!-- Mail Booking Approval Filter Form -->
                                <form id="mailBookingApprovalFilterForm" method="GET"
                                    action="{{ route('mail-booking-approval.index') }}"
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
                                                            d="M5.23 7.21a.75.75 0  1 1 1.06.02L10 10.94l3.71-3.71a.75.75 0 1 1 1.06 1.06l-4.24 4.24a.75.75 0 0 1-1.06 0L5.25 8.29a.75.75 0 0 1-.02-1.08z"
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
                                <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Mail Booking Approval
                                    Records
                                </h1>
                            </div>

                            <div id="productionDetailsScroll"
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
                                                class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                Received Email
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
                                                Customer Merchandiser
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
                                                class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                Notes
                                            </th>
                                            <th
                                                class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                Status
                                            </th>
                                            <th
                                                class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-48 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                        @forelse ($mailBookingApprovals as $approval)
                                            <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200  text-left">
                                                <td
                                                    class="px-4 py-3 font-bold sticky left-0 z-10 bg-gray-100 whitespace-normal break-words border-r border-gray-300 text-blue-500">
                                                    {{ $approval->mailBooking->mail_booking_number }}
                                                </td>
                                                <td
                                                    class="px-4 py-3 text-gray-800 dark:text-gray-100 whitespace-normal break-words border-r text-center">
                                                    {{ $approval->mailBooking->reference_no ?? 'N/A' }}
                                                </td>
                                                <td
                                                    class="px-4 py-3 text-gray-800 dark:text-gray-100 whitespace-normal break-words border-r text-center">
                                                    {{ $approval->mailBooking->email }}
                                                </td>
                                                <td
                                                    class="px-4 py-3 text-gray-800 dark:text-gray-100 whitespace-normal break-words border-r text-center">
                                                    {{ $approval->mailBooking->customer_coordinator }}
                                                </td>
                                                <td
                                                    class="px-4 py-3 text-gray-800 dark:text-gray-100 whitespace-normal break-words border-r text-center">
                                                    {{ $approval->mailBooking->qty }}
                                                </td>
                                                <td
                                                    class="px-4 py-3 text-gray-800 dark:text-gray-100 whitespace-normal break-words border-r text-center">
                                                    {{ $approval->mailBooking->customer_name }}
                                                </td>
                                                <td
                                                    class="px-4 py-3 text-gray-800 dark:text-gray-100 whitespace-normal break-words border-r text-center">
                                                    {{ $approval->mailBooking->merchandiser_name }}
                                                </td>
                                                <td
                                                    class="px-4 py-3 text-gray-800 dark:text-gray-100 whitespace-normal break-words border-r text-center">
                                                    {{ $approval->mailBooking->price }}
                                                </td>
                                                <td
                                                    class="px-4 py-3 text-gray-800 dark:text-gray-100 whitespace-normal break-words border-r text-center">
                                                    {{ $approval->mailBooking->customer_req_date ? Carbon::parse($approval->customer_req_date)->format('d M Y') : 'N/A' }}
                                                </td>
                                                <td
                                                    class="px-4 py-3 text-gray-800 dark:text-gray-100 whitespace-normal break-words border-r text-center">
                                                    {{ $approval->mailBooking->remarks }}
                                                </td>
                                                <td
                                                    class="px-4 py-3 text-gray-800 dark:text-gray-100 whitespace-normal break-words border-r text-center">
                                                    {{ $approval->mailBooking->status }}
                                                </td>
                                                <td class="px-4 py-3">
                                                    <div class="flex justify-center items-center" x-data="{ open: false }">
                                                        @if (!$approval->mailBooking->isApproved)
                                                            {{-- Approve button opens modal --}}
                                                            <button @click="open = true"
                                                                class="px-3 py-1 mt-2 text-xs rounded-lg bg-green-100 text-green-700 hover:bg-green-200 flex items-center justify-center"
                                                                id="approveBtn-{{ $approval->id }}">
                                                                Approve
                                                            </button>

                                                            {{-- Modal --}}
                                                            <div x-show="open" x-cloak
                                                                class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                                                                <div @click.away="open = false"
                                                                    class="bg-white dark:bg-gray-800 p-6 rounded-lg w-80">
                                                                    <h3 class="text-lg font-semibold mb-4">Enter Remark
                                                                    </h3>
                                                                    <form
                                                                        action="{{ route('mailBookingApproval.approve', $approval->id) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        <textarea name="remarks" rows="4"
                                                                            class="w-full border-gray-300 rounded-lg p-2 mb-4 text-sm focus:ring focus:ring-blue-200 focus:border-blue-400"
                                                                            placeholder="Enter remarks (optional)"></textarea>

                                                                        <div class="flex justify-end gap-2">
                                                                            <button type="button" @click="open = false"
                                                                                class="px-3 py-1 text-xs rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200">
                                                                                Cancel
                                                                            </button>
                                                                            <button type="submit"
                                                                                class="px-3 py-1 text-xs rounded-lg bg-green-100 text-green-700 hover:bg-green-200">
                                                                                Submit
                                                                            </button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        @else
                                                            {{-- Show Approved banner --}}
                                                            <span
                                                                class="inline-block m-1 text-sm font-semibold text-green-700 bg-green-100 dark:bg-gray-800 px-3 py-1 rounded text-center">
                                                                Approved on
                                                                {{ \Carbon\Carbon::parse($approval->mailBooking->approved_at)->format('Y-m-d') }}
                                                                at
                                                                {{ \Carbon\Carbon::parse($approval->mailBooking->approved_at)->format('H:i') }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="12"
                                                    class="text-center px-6 py-6 text-gray-500 text-sm italic">
                                                    No records found.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <div class="py-6 flex justify-center">
                                <div>
                                    {{ $mailBookingApprovals->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleFilterForm() {
            const form = document.getElementById('filterFormContainer');
            form.classList.toggle('hidden');
        }
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
        const filters = ['mailBookingNo', 'referenceNo', 'email', 'merchandiser', 'customer'];
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
@endsection
