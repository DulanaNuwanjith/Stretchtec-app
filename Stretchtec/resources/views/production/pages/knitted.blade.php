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
                                <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Knitted Section Order
                                    Records
                                </h1>
                            </div>

                            <div id="productionDetailsScroll"
                                 class="overflow-x-auto max-h-[1200px] bg-white dark:bg-gray-900 shadow rounded-lg">
                                <table class="table-fixed w-full text-sm divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead class="bg-gray-200 dark:bg-gray-700 text-left">
                                    <tr class="text-center">

                                        <th class="font-bold px-4 py-3 w-36 text-xs">Order No</th>
                                        <th class="font-bold px-4 py-3 w-36 text-xs">Reference Number</th>
                                        <th class="font-bold px-4 py-3 w-36 text-xs">Requested Date</th>
                                        <th class="font-bold px-4 py-3 w-36 text-xs">Customer</th>
                                        <th class="font-bold px-4 py-3 w-36 text-xs">Customer Merchandiser</th>
                                        <th class="font-bold px-4 py-3 w-36 text-xs">Customer Coordinator</th>
                                        <th class="font-bold px-4 py-3 w-36 text-xs">Reference No</th>
                                        <th class="font-bold px-4 py-3 w-36 text-xs">Qty To Produce</th>

                                    </tr>
                                    </thead>

                                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">

                                    @foreach ($orders as $order)
                                        <tr class="text-center">

                                            <!-- ORDER NO -->
                                            <td class="px-4 py-2">
                                                {{ $order->prod_order_no }}
                                            </td>

                                            <td class="px-4 py-2">
                                                <button type="button"
                                                        onclick="openDetailsModal(this)"
                                                        data-ref-no="{{ $order->productInquiry->reference_no }}"
                                                        data-shade="{{ $order->productInquiry->shade }}"
                                                        data-colour="{{ $order->productInquiry->color }}"
                                                        data-item="{{ $order->productInquiry->item }}"
                                                        data-tkt="{{ $order->productInquiry->tkt }}"
                                                        data-size="{{ $order->productInquiry->size }}"
                                                        data-supplier="{{ $order->productInquiry->supplier }}"
                                                        data-pstno="{{ $order->productInquiry->pst_no }}"
                                                        data-suppliercomment="{{ $order->productInquiry->supplier_comment }}">
                                                    {{ $order->productInquiry->reference_no }}
                                                </button>

                                            </td>

                                            <!-- REQUESTED DATE (from product_inquiries) -->
                                            <td class="px-4 py-2">
                                                {{ optional($order->productInquiry)->customer_req_date }}
                                            </td>

                                            <!-- CUSTOMER NAME -->
                                            <td class="px-4 py-2">
                                                {{ optional($order->productInquiry)->customer_name }}
                                            </td>

                                            <!-- CUSTOMER MERCHANDISER -->
                                            <td class="px-4 py-2">
                                                {{ optional($order->productInquiry)->merchandiser_name }}
                                            </td>

                                            <!-- CUSTOMER COORDINATOR -->
                                            <td class="px-4 py-2">
                                                {{ optional($order->productInquiry)->customer_coordinator }}
                                            </td>

                                            <!-- REFERENCE NUMBER -->
                                            <td class="px-4 py-2">
                                                {{ optional($order->productInquiry)->reference_no }}
                                            </td>

                                            <!-- TO MAKE QTY -->
                                            <td class="px-4 py-2">
                                                {{ optional($order->orderPreparation)->qty }}
                                            </td>

                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>

                            </div>

                            <div class="py-6 flex justify-center">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Inquiry Details Modal -->
        <div id="detailsModal"
             class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">

            <div class="bg-white w-full max-w-2xl rounded-lg shadow-lg p-6 relative">
                <!-- Close button -->
                <button onclick="closeDetailsModal()"
                        class="absolute top-3 right-3 text-gray-600 hover:text-gray-900 text-xl">&times;
                </button>

                <h2 class="text-2xl font-semibold mb-4 text-center text-gray-800">Inquiry Details</h2>

                <div class="grid grid-cols-2 gap-4 text-gray-700">

                    <div>
                        <p class="font-semibold">Reference No:</p>
                        <p id="modal_ref_no" class="text-gray-900"></p>
                    </div>

                    <div>
                        <p class="font-semibold">Item:</p>
                        <p id="modal_item" class="text-gray-900"></p>
                    </div>

                    <div>
                        <p class="font-semibold">Colour:</p>
                        <p id="modal_colour" class="text-gray-900"></p>
                    </div>

                    <div>
                        <p class="font-semibold">Shade:</p>
                        <p id="modal_shade" class="text-gray-900"></p>
                    </div>

                    <div>
                        <p class="font-semibold">Size:</p>
                        <p id="modal_size" class="text-gray-900"></p>
                    </div>

                    <div>
                        <p class="font-semibold">TKT:</p>
                        <p id="modal_tkt" class="text-gray-900"></p>
                    </div>

                    <div>
                        <p class="font-semibold">Supplier:</p>
                        <p id="modal_supplier" class="text-gray-900"></p>
                    </div>

                    <div>
                        <p class="font-semibold">PST No:</p>
                        <p id="modal_pst_no" class="text-gray-900"></p>
                    </div>

                    <div class="col-span-2">
                        <p class="font-semibold">Supplier Comment:</p>
                        <p id="modal_supplier_comment"
                           class="text-gray-900 whitespace-pre-line"></p>
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
    function openDetailsModal(button) {
        document.getElementById("modal_ref_no").textContent = button.dataset.refNo;
        document.getElementById("modal_item").textContent = button.dataset.item;
        document.getElementById("modal_colour").textContent = button.dataset.colour;
        document.getElementById("modal_shade").textContent = button.dataset.shade;
        document.getElementById("modal_size").textContent = button.dataset.size;
        document.getElementById("modal_tkt").textContent = button.dataset.tkt;
        document.getElementById("modal_supplier").textContent = button.dataset.supplier;
        document.getElementById("modal_pst_no").textContent = button.dataset.pstno;
        document.getElementById("modal_supplier_comment").textContent = button.dataset.suppliercomment;

        document.getElementById("detailsModal").classList.remove("hidden");
    }

    function closeDetailsModal() {
        document.getElementById("detailsModal").classList.add("hidden");
    }
</script>

@endsection
