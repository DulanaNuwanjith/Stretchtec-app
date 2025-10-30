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
                                <!-- Filter Form -->
                                <form id="filterForm1" method="GET" action="{{ route('sample-inquery-details.index') }}"
                                      class="mb-6 sticky top-0 z-40 flex gap-6 items-center">
                                    <div class="flex items-center gap-4 flex-wrap">


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
                                            Order No
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
                                            class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                            Action
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach ($mailBookingApprovals as $approval)
                                        <tr class="text-center hover:bg-gray-100 dark:hover:bg-gray-700">
                                            <td
                                                class="sticky left-0 bg-white dark:bg-gray-900 px-4 py-3 text-gray-800 dark:text-gray-100 whitespace-normal break-words">
                                                {{ $approval->mailBooking->mail_booking_number }}
                                            </td>
                                            <td
                                                class="px-4 py-3 text-gray-800 dark:text-gray-100 whitespace-normal break-words">
                                                {{ $approval->mailBooking->reference_no ?? 'N/A' }}
                                            </td>
                                            <td
                                                class="px-4 py-3 text-gray-800 dark:text-gray-100 whitespace-normal break-words">
                                                {{ $approval->mailBooking->email }}
                                            </td>
                                            <td
                                                class="px-4 py-3 text-gray-800 dark:text-gray-100 whitespace-normal break-words">
                                                {{ $approval->mailBooking->customer_coordinator }}
                                            </td>
                                            <td
                                                class="px-4 py-3 text-gray-800 dark:text-gray-100 whitespace-normal break-words">
                                                {{ $approval->mailBooking->qty }}
                                            </td>
                                            <td
                                                class="px-4 py-3 text-gray-800 dark:text-gray-100 whitespace-normal break-words">
                                                {{ $approval->mailBooking->customer_name }}
                                            </td>
                                            <td
                                                class="px-4 py-3 text-gray-800 dark:text-gray-100 whitespace-normal break-words">
                                                {{ $approval->mailBooking->merchandiser_name }}
                                            </td>
                                            <td
                                                class="px-4 py-3 text-gray-800 dark:text-gray-100 whitespace-normal break-words">
                                                {{ $approval->mailBooking->price }}
                                            </td>
                                            <td
                                                class="px-4 py-3 text-gray-800 dark:text-gray-100 whitespace-normal break-words">
                                                {{ $approval->mailBooking->customer_req_date ? Carbon::parse($approval->customer_req_date)->format('d M Y') : '' }}
                                            </td>
                                            <td
                                                class="px-4 py-3 text-gray-800 dark:text-gray-100 whitespace-normal break-words">
                                                {{ $approval->mailBooking->supplier_comment }}
                                            </td>
                                            <td
                                                class="px-4 py-3 text-gray-800 dark:text-gray-100 whitespace-normal break-words">
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
                                                        <div x-show="open" x-cloak class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                                                            <div @click.away="open = false" class="bg-white dark:bg-gray-800 p-6 rounded-lg w-80">
                                                                <h3 class="text-lg font-semibold mb-4">Enter Remark</h3>
                                                                <form action="{{ route('mailBookingApproval.approve', $approval->id) }}" method="POST">
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
                                                        <span class="inline-block m-1 text-sm font-semibold text-green-700 bg-green-100 dark:bg-gray-800 px-3 py-1 rounded text-center">
                                                            Approved on {{ \Carbon\Carbon::parse($approval->mailBooking->approved_at)->format('Y-m-d') }}
                                                            at {{ \Carbon\Carbon::parse($approval->mailBooking->approved_at)->format('H:i') }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
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
