@php use Carbon\Carbon;use Illuminate\Support\Facades\Auth; @endphp

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
                                <!-- Filter Form -->
                                <form id="filterForm1" method="GET" action="{{ route('sample-inquery-details.index') }}"
                                      class="mb-6 sticky top-0 z-40 flex gap-6 items-center">
                                    <div class="flex items-center gap-4 flex-wrap">


                                    </div>
                                </form>
                            </div>

                            <div class="flex justify-between items-center mb-6">
                                <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Production Inquiry
                                    Records
                                </h1>
                                <button onclick="document.getElementById('addSampleModal').classList.remove('hidden')"
                                        class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded shadow">
                                    + Add New Production Order
                                </button>
                            </div>

                            <!-- Add Sample Modal -->
                            <div id="addSampleModal"
                                 class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center py-5">
                                <div
                                    class="w-full max-w-[700px] bg-white dark:bg-gray-900 rounded-2xl shadow-2xl p-4 transform transition-all scale-95 max-h-[calc(100vh-10rem)] overflow-y-auto"
                                    onclick="event.stopPropagation()">
                                    <div class="max-w-[600px] mx-auto p-8">
                                        <h2
                                            class="text-2xl font-semibold mb-8 text-blue-900 mt-4 dark:text-gray-100 text-center">
                                            Add New Production Order
                                        </h2>

                                        <!-- TABS -->
                                        <div class="mb-6">
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Order
                                                Type</label>
                                            <div
                                                class="flex space-x-4 mt-3 border-b border-gray-300 dark:border-gray-700">
                                                <button type="button" onclick="setOrderType('sample')" id="tab-sample"
                                                        class="pb-2 px-3 font-semibold">
                                                    From Sample
                                                </button>
                                                <button type="button" onclick="setOrderType('direct')" id="tab-direct"
                                                        class="pb-2 px-3 font-semibold">
                                                    Direct Order
                                                </button>
                                            </div>
                                        </div>

                                        <!-- ================= Direct ORDER FORM ================= -->
                                        <form id="directForm" class="space-y-4 hidden"
                                              action="{{ route('production-inquery-details.store') }}" method="POST"
                                              enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="order_type" value="direct">

                                            <div id="directItemsContainer">
                                                <!-- One Item Template -->
                                                <div
                                                    class="item-group border rounded p-4 mb-4 bg-gray-50 dark:bg-gray-800">
                                                    <!-- Shade & Colour -->
                                                    <div class="flex gap-4">
                                                        <input type="text" name="items[0][shade]"
                                                               class="w-1/2 border rounded-md px-3 py-2 dark:bg-gray-700 dark:text-white"
                                                               placeholder="Shade">
                                                        <input type="text" name="items[0][color]"
                                                               class="w-1/2 border rounded-md px-3 py-2 dark:bg-gray-700 dark:text-white"
                                                               placeholder="Colour">
                                                    </div>

                                                    <!-- Size, Qty, UoM -->
                                                    <div class="flex gap-4 mt-3">
                                                        <input type="text" name="items[0][size]"
                                                               class="w-1/3 border rounded-md px-3 py-2 dark:bg-gray-700 dark:text-white"
                                                               placeholder="Size">
                                                        <input type="number" name="items[0][qty]" min="0"
                                                               class="w-1/3 border rounded-md px-3 py-2 dark:bg-gray-700 dark:text-white"
                                                               placeholder="Quantity">
                                                        <select name="items[0][uom]"
                                                                class="w-1/3 border rounded-md px-3 py-2 dark:bg-gray-700 dark:text-white">
                                                            <option value="meters">Meters</option>
                                                            <option value="yards">Yards</option>
                                                            <option value="pieces">Pieces</option>
                                                        </select>
                                                    </div>

                                                    <!-- Item & TKT -->
                                                    <div class="flex gap-4 mt-3">
                                                        <input type="text" name="items[0][item]"
                                                               class="w-1/2 border rounded-md px-3 py-2 dark:bg-gray-700 dark:text-white"
                                                               placeholder="Item">
                                                        <input type="text" name="items[0][tkt]"
                                                               class="w-1/2 border rounded-md px-3 py-2 dark:bg-gray-700 dark:text-white"
                                                               placeholder="TKT">
                                                    </div>

                                                    <!-- Price -->
                                                    <div class="mt-3">
                                                        <input type="number" step="0.01" name="items[0][price]"
                                                               class="w-full border rounded-md px-3 py-2 dark:bg-gray-700 dark:text-white"
                                                               placeholder="PO Value">
                                                    </div>

                                                    <!-- Remove Button -->
                                                    <div id="optionsWrapper" class="space-y-2 my-4 flex justify-end">
                                                        <button type="button"
                                                                onclick="removeDirectItem(this)"
                                                                class="text-blue-500 hover:text-blue-700">
                                                            <svg
                                                                xmlns="http://www.w3.org/2000/svg"
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
                                                                                                                                                               011-1h4a1 1 0 011 1v3m-9 0h10"/>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Add More Items -->
                                            <button type="button" id="addDirectItem"
                                                    class="mt-4 px-4 py-2 bg-green-500 text-white rounded">
                                                + Add Another Item
                                            </button>

                                            <!-- Master Order fields -->
                                            <div class="mt-6">
                                                <label>Reference Number</label>
                                                <input type="text" name="reference_no" value="Direct Bulk" readonly
                                                       class="w-full border rounded-md px-3 py-2 bg-gray-100 dark:bg-gray-700 dark:text-white">
                                            </div>
                                            <div class="mt-3">
                                                <label>PO Number</label>
                                                <input type="text" name="po_number"
                                                       class="w-full border rounded-md px-3 py-2 dark:bg-gray-700 dark:text-white">
                                            </div>
                                            <div class="mt-3">
                                                <label>Customer Coordinator</label>
                                                <input type="text" name="customer_coordinator" readonly
                                                       value="{{ Auth::user()->name }}"
                                                       class="w-full border rounded-md px-3 py-2 bg-gray-100 dark:bg-gray-600">
                                            </div>
                                            <div class="mt-3">
                                                <label>Customer Name</label>
                                                <input type="text" name="customer_name"
                                                       class="w-full border rounded-md px-3 py-2 dark:bg-gray-700 dark:text-white">
                                            </div>
                                            <div class="mt-3">
                                                <label>Customer Merchandiser</label>
                                                <input type="text" name="merchandiser_name"
                                                       class="w-full border rounded-md px-3 py-2 dark:bg-gray-700 dark:text-white">
                                            </div>
                                            <div class="mt-3">
                                                <label>Customer Requested Date</label>
                                                <input type="date" name="customer_req_date"
                                                       class="w-full border rounded-md px-3 py-2 dark:bg-gray-700 dark:text-white">
                                            </div>
                                            <div class="mt-3">
                                                <label>Customer Notes</label>
                                                <input type="text" name="remarks"
                                                       class="w-full border rounded-md px-3 py-2 dark:bg-gray-700 dark:text-white">
                                            </div>

                                            <div class="flex justify-end gap-3 mt-6">
                                                <button type="button"
                                                        onclick="document.getElementById('addSampleModal').classList.add('hidden')"
                                                        class="px-4 py-2 bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-200 text-sm rounded hover:bg-gray-300">
                                                    Cancel
                                                </button>
                                                <button type="submit"
                                                        class="px-4 py-2 bg-blue-500 text-white text-sm rounded hover:bg-blue-600">
                                                    Create Direct Order
                                                </button>
                                            </div>
                                        </form>

                                        <form id="sampleForm" action="{{ route('production-inquery-details.store') }}"
                                              method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="order_type" value="sample">

                                            <div id="itemsContainer">
                                                <!-- Item Template -->
                                                <div
                                                    class="item-group border rounded p-4 mb-4 bg-gray-50 dark:bg-gray-800">
                                                    <!-- SAMPLE REFERENCE DROPDOWN -->
                                                    <div class="relative mb-3">
                                                        <button type="button"
                                                                class="sampleReferenceDropdown inline-flex w-full justify-between rounded-md bg-white px-3 py-2 text-sm font-semibold shadow-sm ring-1 ring-gray-300 hover:bg-gray-50 h-10 dark:bg-gray-700 dark:text-white dark:ring-gray-600"
                                                                onclick="toggleDropdown(this)" aria-haspopup="listbox">
                                                            <span class="selectedSampleReference">Select Sample Reference</span>
                                                            <svg class="ml-2 h-5 w-5 text-gray-400" viewBox="0 0 20 20"
                                                                 fill="currentColor">
                                                                <path fill-rule="evenodd"
                                                                      d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 10.94l3.71-3.71a.75.75 0 1 1 1.06 1.06l-4.24 4.24a.75.75 0 0 1-1.06 0L5.25 8.29a.75.75 0 0 1-.02-1.08z"
                                                                      clip-rule="evenodd"/>
                                                            </svg>
                                                        </button>

                                                        <div
                                                            class="dropdownMenu absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto hidden dark:bg-gray-700 dark:text-white sm:text-sm">
                                                            <div
                                                                class="sticky top-0 bg-white dark:bg-gray-700 px-2 py-1">
                                                                <input type="text" placeholder="Search reference..."
                                                                       onkeyup="filterSamples(this)"
                                                                       class="w-full px-2 py-1 text-sm border rounded-md focus:outline-none focus:ring focus:ring-indigo-500 dark:bg-gray-600 dark:text-white dark:border-gray-500"/>
                                                            </div>
                                                            <ul class="sampleOptions max-h-48 overflow-y-auto">
                                                                @foreach ($samples as $sample)
                                                                    <li class="cursor-pointer select-none px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-600"
                                                                        onclick="selectSampleReference(this, '{{ $sample->id }}', '{{ $sample->reference_no }}')">
                                                                        {{ $sample->reference_no }}
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    </div>

                                                    <!-- Hidden input for sample id -->
                                                    <input type="hidden" name="items[0][sample_id]"
                                                           class="sampleReferenceHidden">

                                                    <!-- Auto filled fields -->
                                                    <div class="grid grid-cols-2 gap-4 autoFields">
                                                        <input type="text" name="items[0][shade]"
                                                               class="sampleShade editable border rounded-md px-3 py-2 bg-gray-100 dark:bg-gray-600"
                                                               readonly placeholder="Shade">
                                                        <input type="text" name="items[0][color]"
                                                               class="sampleColour editable border rounded-md px-3 py-2 bg-gray-100 dark:bg-gray-600"
                                                               readonly placeholder="Color">
                                                        <input type="text" name="items[0][tkt]"
                                                               class="sampleTKT editable border rounded-md px-3 py-2 bg-gray-100 dark:bg-gray-600"
                                                               readonly placeholder="TKT">
                                                        <input type="text" name="items[0][size]"
                                                               class="sampleSize editable border rounded-md px-3 py-2 bg-gray-100 dark:bg-gray-600"
                                                               readonly placeholder="Size">
                                                        <input type="text" name="items[0][item]"
                                                               class="sampleItem editable border rounded-md px-3 py-2 bg-gray-100 dark:bg-gray-600"
                                                               readonly placeholder="Item">
                                                        <input type="text" name="items[0][supplier]"
                                                               class="sampleSupplier editable border rounded-md px-3 py-2 bg-gray-100 dark:bg-gray-600"
                                                               readonly placeholder="Supplier">
                                                    </div>

                                                    <!-- Editable fields -->
                                                    <div class="grid grid-cols-3 gap-4 mt-4">
                                                        <input type="number" name="items[0][qty]"
                                                               class="sampleQty border rounded-md px-3 py-2 dark:bg-gray-700 dark:text-white"
                                                               placeholder="Qty">
                                                        <select name="items[0][uom]"
                                                                class="sampleUom border rounded-md px-3 py-2 dark:bg-gray-700 dark:text-white">
                                                            <option value="meters">Meters</option>
                                                            <option value="yards">Yards</option>
                                                            <option value="pieces">Pieces</option>
                                                        </select>
                                                        <input type="number" step="0.01" name="items[0][price]"
                                                               class="samplePrice border rounded-md px-3 py-2 dark:bg-gray-700 dark:text-white"
                                                               placeholder="PO Value">
                                                    </div>

                                                    <!-- Options: Remove + Edit Button -->
                                                    <div id="optionsWrapper"
                                                         class="space-y-2 my-4 flex justify-between">
                                                        <!-- Edit Button -->
                                                        <button type="button"
                                                                onclick="toggleEdit(this)"
                                                                class="flex items-center px-3 py-1 text-sm bg-gray-200 rounded-md hover:bg-gray-300 dark:bg-gray-600 dark:hover:bg-gray-500">
                                                            <span>Edit</span>
                                                        </button>

                                                        <!-- Remove Button -->
                                                        <button type="button"
                                                                onclick="removeItem(this)"
                                                                class="text-blue-500 hover:text-blue-700">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                 fill="none" viewBox="0 0 24 24"
                                                                 stroke-width="2" stroke="currentColor"
                                                                 class="w-5 h-5">
                                                                <path stroke-linecap="round"
                                                                      stroke-linejoin="round"
                                                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0
                                                                         01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0
                                                                         011-1h4a1 1 0 011 1v3m-9 0h10"/>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                            <button type="button" id="addItem"
                                                    class="mt-4 px-4 py-2 bg-green-500 text-white rounded">+ Add Another
                                                Item
                                            </button>

                                            <!-- Master PO fields -->
                                            <div class="mt-6">
                                                <label>PO Number</label>
                                                <input type="text" name="po_number" required
                                                       class="w-full border rounded-md px-3 py-2 dark:bg-gray-700 dark:text-white">
                                            </div>
                                            <div class="mt-3">
                                                <label>Customer Name</label>
                                                <input type="text" name="customer_name" required
                                                       class="w-full border rounded-md px-3 py-2 dark:bg-gray-700 dark:text-white">
                                            </div>
                                            <div class="mt-3">
                                                <label>Merchandiser Name</label>
                                                <input type="text" name="merchandiser_name" required
                                                       class="w-full border rounded-md px-3 py-2 dark:bg-gray-700 dark:text-white">
                                            </div>
                                            <div class="mt-3">
                                                <label>Customer Coordinator</label>
                                                <input type="text" name="customer_coordinator" readonly
                                                       value="{{Auth::user()->name}}"
                                                       class="w-full border rounded-md px-3 py-2 dark:bg-gray-700 dark:text-white">
                                            </div>
                                            <div class="mt-3">
                                                <label>Customer Requested Date</label>
                                                <input type="date" name="customer_req_date" required
                                                       class="w-full border rounded-md px-3 py-2 dark:bg-gray-700 dark:text-white">
                                            </div>
                                            <div class="mt-3">
                                                <label for="direct_remarks"
                                                       class="block text-sm font-medium text-gray-700 dark:text-gray-300">Customer
                                                    Notes</label>
                                                <input id="direct_remarks" type="text" name="remarks"
                                                       class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                            </div>


                                            <div class="flex justify-end mt-6 space-x-3">
                                                <button type="button" id="cancelForm"
                                                        class="px-4 py-2 bg-gray-500 text-white rounded">Cancel
                                                </button>
                                                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">
                                                    Create Sample Order
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
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
                                            PO Number
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
                                            Send to Stock
                                        </th>
                                        <th
                                            class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-32 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
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
                                    @forelse($productInquiries as $inquiry)
                                        <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200  text-left">
                                            @if ($inquiry->supplier === null)
                                                <td
                                                    class="px-4 py-3 font-bold sticky left-0 z-10 bg-gray-100 whitespace-normal break-words border-r border-gray-300 text-blue-500">
                                                    {{ $inquiry->prod_order_no ?? 'N/A' }}
                                                    <div class="text-xs font-normal text-gray-500">
                                                        ({{ $inquiry->po_received_date ? Carbon::parse($inquiry->po_received_date)->format('Y-m-d') : '' }}
                                                        )
                                                    </div>
                                                </td>
                                            @else
                                                <td
                                                    class="px-4 py-3 font-bold sticky left-0 z-10 bg-gray-100 whitespace-normal break-words border-r border-gray-300">
                                                    {{ $inquiry->prod_order_no ?? 'N/A' }}
                                                    <div class="text-xs font-normal text-gray-500">
                                                        ({{ $inquiry->po_received_date ? Carbon::parse($inquiry->po_received_date)->format('Y-m-d') : '' }}
                                                        )
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

                                            <!-- PO Number -->
                                            <td
                                                class="px-4 py-3 whitespace-normal break-words border-r border-gray-300  text-center">
                                                {{ $inquiry->po_number ?? 'N/A' }}</td>

                                            <!-- Customer Coordinator -->
                                            <td
                                                class="px-4 py-3 whitespace-normal break-words border-r border-gray-300  text-center">
                                                {{ $inquiry->customer_coordinator ?? 'N/A' }}</td>

                                            <!-- Quantity -->
                                            <td
                                                class="px-4 py-3 whitespace-normal break-words border-r border-gray-300  text-center">
                                                {{ $inquiry->qty ?? '0' }}</td>

                                            <!-- Customer Name -->
                                            <td
                                                class="px-4 py-3 whitespace-normal break-words border-r border-gray-300  text-center">
                                                {{ $inquiry->customer_name ?? 'N/A' }}</td>

                                            <!-- Customer Merchandiser -->
                                            <td
                                                class="px-4 py-3 whitespace-normal break-words border-r border-gray-300  text-center">
                                                {{ $inquiry->merchandiser_name ?? 'N/A' }}</td>

                                            <!-- PO Value -->
                                            <td
                                                class="px-4 py-3 whitespace-normal break-words border-r border-gray-300  text-center text-green-600 font-medium">
                                                {{ $inquiry->price ? 'LKR  ' . number_format($inquiry->price, 2) : '0' }}
                                            </td>

                                            <!-- Requested Date -->
                                            <td
                                                class="px-4 py-3 whitespace-normal break-words border-r border-gray-300  text-center">
                                                {{ $inquiry->customer_req_date ?? 'N/A' }}</td>

                                            <!-- Notes -->
                                            <td
                                                class="px-4 py-3 whitespace-normal break-words border-r border-gray-300  text-center text-gray-500 italic">
                                                {{ $inquiry->remarks ?? '-' }}
                                            </td>

                                            <!-- Send to Stock -->
                                            <td
                                                class="px-4 py-3 whitespace-normal break-words border-r border-gray-300  text-center">
                                                <button
                                                    class="px-3 py-1 text-xs rounded-lg bg-blue-100 text-blue-700 hover:bg-blue-200">
                                                    Stock
                                                </button>
                                            </td>

                                            <!-- Send to Production -->
                                            <td
                                                class="px-4 py-3 whitespace-normal break-words border-r border-gray-300  text-center">
                                                <button
                                                    class="px-3 py-1 text-xs rounded-lg bg-indigo-100 text-indigo-700 hover:bg-indigo-200">
                                                    Production
                                                </button>
                                            </td>

                                            <!-- Status -->
                                            <td
                                                class="px-4 py-3 whitespace-normal break-words border-r border-gray-300  text-center">
                                                    <span
                                                        class="px-2 py-1 text-xs rounded-full
                                                    {{ $inquiry->status === 'Completed'
                                                        ? 'bg-green-100 text-green-700'
                                                        : ($inquiry->status === 'Pending'
                                                            ? 'bg-yellow-100 text-yellow-700'
                                                            : 'bg-gray-100 text-gray-600') }}">
                                                        {{ $inquiry->status ?? 'Pending' }}
                                                    </span>
                                            </td>

                                            <!-- Customer Delivery Status -->
                                            <td
                                                class="px-4 py-3 whitespace-normal break-words border-r border-gray-300  text-center text-gray-500 italic">

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
                                {{ $productInquiries->links() }}
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
    function toggleDropdown(id) {
        document.getElementById(`dropdownMenu${id}`).classList.toggle('hidden');
    }

    function selectSampleReference(id, referenceNo) {
        document.getElementById('selectedSampleReference').textContent = referenceNo;
        document.getElementById('sampleReferenceHidden').value = id;
        document.getElementById('dropdownMenusampleReference').classList.add('hidden');

        // If you want to trigger fetching details when selected
        if (typeof fetchSampleDetails === "function") {
            fetchSampleDetails(id);
        }
    }

    function filterSamples() {
        let input = document.getElementById('sampleSearchInput');
        let filter = input.value.toLowerCase();
        let options = document.getElementById("sampleOptions").getElementsByTagName("li");

        for (let i = 0; i < options.length; i++) {
            let txtValue = options[i].textContent || options[i].innerText;
            if (txtValue.toLowerCase().indexOf(filter) > -1) {
                options[i].style.display = "";
            } else {
                options[i].style.display = "none";
            }
        }
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function (event) {
        const dropdown = document.getElementById('dropdownMenusampleReference');
        const button = document.getElementById('sampleReferenceDropdown');

        if (!dropdown.contains(event.target) && !button.contains(event.target)) {
            dropdown.classList.add('hidden');
        }
    });
</script>

<script>
    flatpickr("#sampleCustomerRequestedDate", {
        minDate: "today",
        dateFormat: "Y-m-d",
        onDayCreate: function (dObj, dStr, fp, dayElem) {
            const today = new Date();
            const dayDate = new Date(dayElem.dateObj);
            const diffDays = Math.floor((dayDate - today) / (1000 * 60 * 60 * 24));

            // Style based on range
            if (diffDays >= 0 && diffDays <= 10) {
                dayElem.classList.add("bg-red-200", "text-red-800", "rounded-md");
            } else if (diffDays > 10 && diffDays <= 20) {
                dayElem.classList.add("bg-yellow-200", "text-yellow-800", "rounded-md");
            } else if (diffDays > 20) {
                dayElem.classList.add("bg-green-200", "text-green-800", "rounded-md");
            }
        }
    });
</script>

<!-- ========= SCRIPTS: tabs, dropdown, sample fetch ========= -->
<script>
    // initialize tabs on page load
    document.addEventListener('DOMContentLoaded', function () {
        setOrderType('sample'); // default
        // close sample dropdown if clicked outside
        document.addEventListener('click', function (e) {
            if (!e.target.closest('#dropdownMenusampleReference') && !e.target.closest(
                '#sampleReferenceDropdown')) {
                const dd = document.getElementById('dropdownMenusampleReference');
                if (dd) dd.classList.add('hidden');
            }
        });
    });

    function setOrderType(type) {
        const sampleForm = document.getElementById('sampleForm');
        const directForm = document.getElementById('directForm');
        const tabSample = document.getElementById('tab-sample');
        const tabDirect = document.getElementById('tab-direct');

        if (type === 'sample') {
            sampleForm.classList.remove('hidden');
            directForm.classList.add('hidden');
            tabSample.classList.add('border-b-2', 'border-blue-500', 'text-blue-600');
            tabDirect.classList.remove('border-b-2', 'border-blue-500', 'text-blue-600');
        } else {
            directForm.classList.remove('hidden');
            sampleForm.classList.add('hidden');
            tabDirect.classList.add('border-b-2', 'border-blue-500', 'text-blue-600');
            tabSample.classList.remove('border-b-2', 'border-blue-500', 'text-blue-600');
        }
    }

    function toggleDropdown(button) {
        const dropdown = button.parentElement.querySelector(".dropdownMenu");
        dropdown.classList.toggle("hidden");
    }

    function selectSampleReference(element, id, referenceNo) {
        const group = element.closest(".item-group");
        group.querySelector(".selectedSampleReference").innerText = referenceNo;
        group.querySelector(".sampleReferenceHidden").value = id;
        group.querySelector(".dropdownMenu").classList.add("hidden");

        // fetch details for this sample
        const base = "{{ url('product-catalog') }}";
        fetch(`${base}/${id}/details`)
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

    function filterSamples(input) {
        const filter = input.value.toLowerCase();
        const options = input.closest(".dropdownMenu").querySelectorAll("ul li");
        options.forEach(option => {
            option.style.display = option.textContent.toLowerCase().includes(filter) ? "" : "none";
        });
    }
</script>

<script>
    document.getElementById("editButton").addEventListener("click", function () {
        // Select all editable fields
        const fields = document.querySelectorAll(".editable");
        fields.forEach(field => {
            field.removeAttribute("readonly");
            field.classList.remove("bg-gray-100", "dark:bg-gray-600"); // remove gray background
            field.classList.add("bg-white", "dark:bg-gray-800"); // make editable background
        });
    });
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

<script>
    let itemIndex = 1;

    // Add new item
    document.getElementById('addItem').addEventListener('click', () => {
        let container = document.getElementById('itemsContainer');
        let firstItem = container.firstElementChild;
        let clone = firstItem.cloneNode(true);

        // Reset all input/select values and update indexes
        clone.querySelectorAll('input, select').forEach(el => {
            let name = el.getAttribute('name');
            if (name) {
                el.setAttribute('name', name.replace(/\d+/, itemIndex));
            }

            // Clear values
            if (el.type === "hidden" || el.type === "text" || el.type === "number" || el.type === "date") {
                el.value = '';
            }
            if (el.tagName === "SELECT") {
                el.selectedIndex = 0;
            }
        });

        // Reset sample reference text
        let ref = clone.querySelector(".selectedSampleReference");
        if (ref) ref.textContent = "Select Sample Reference";

        // Append new item
        itemIndex++;
        container.appendChild(clone);
    });

    // Cancel button hides modal
    document.getElementById("cancelForm").addEventListener("click", () => {
        document.getElementById("addSampleModal").classList.add("hidden");
    });

    // Close modal when clicking overlay
    document.getElementById("addSampleModal").addEventListener("click", (e) => {
        if (e.target.id === "addSampleModal") {
            document.getElementById("addSampleModal").classList.add("hidden");
        }
    });
</script>

<script>
    function removeItem(button) {
        const container = document.getElementById('itemsContainer');
        const allItems = container.querySelectorAll('.item-group');

        if (allItems.length > 1) {
            button.closest('.item-group').remove();
        } else {
            alert("You must keep at least one item.");
        }
    }
</script>

<script>
    let directItemIndex = 1;

    document.getElementById('addDirectItem').addEventListener('click', () => {
        const container = document.getElementById('directItemsContainer');
        const firstItem = container.firstElementChild;
        const clone = firstItem.cloneNode(true);

        // Reset all inputs and update names
        clone.querySelectorAll('input, select').forEach(el => {
            let name = el.getAttribute('name');
            if (name) {
                el.setAttribute('name', name.replace(/\d+/, directItemIndex));
            }
            if (el.type === "text" || el.type === "number" || el.type === "date") {
                el.value = '';
            }
            if (el.tagName === "SELECT") {
                el.selectedIndex = 0;
            }
        });

        directItemIndex++;
        container.appendChild(clone);
    });

    function removeDirectItem(button) {
        const container = document.getElementById('directItemsContainer');
        const allItems = container.querySelectorAll('.item-group');
        if (allItems.length > 1) {
            button.closest('.item-group').remove();
        } else {
            alert("You must keep at least one item.");
        }
    }
</script>

<script>
    function toggleEdit(button) {
        const itemGroup = button.closest('.item-group');
        const autoFields = itemGroup.querySelectorAll('.editable');
        const btnText = button.querySelector('span');

        let isReadOnly = autoFields[0].hasAttribute('readonly');

        autoFields.forEach(field => {
            if (isReadOnly) {
                field.removeAttribute('readonly');
                field.classList.remove('bg-gray-100', 'dark:bg-gray-600');
                field.classList.add('bg-white', 'dark:bg-gray-700');
            } else {
                field.setAttribute('readonly', true);
                field.classList.remove('bg-white', 'dark:bg-gray-700');
                field.classList.add('bg-gray-100', 'dark:bg-gray-600');
            }
        });

        btnText.textContent = isReadOnly ? "Lock" : "Edit";
    }
</script>


@endsection
