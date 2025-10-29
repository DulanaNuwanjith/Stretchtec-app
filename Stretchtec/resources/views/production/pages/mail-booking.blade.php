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
                                <!-- Filter Form -->
                                <form id="filterForm1" method="GET" action="{{ route('sample-inquery-details.index') }}"
                                      class="mb-6 sticky top-0 z-40 flex gap-6 items-center">
                                    <div class="flex items-center gap-4 flex-wrap">


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
                                <div
                                    class="w-full max-w-[700px] bg-white dark:bg-gray-900 rounded-2xl shadow-2xl p-4 transform transition-all scale-95 max-h-[calc(100vh-10rem)] overflow-y-auto"
                                    onclick="event.stopPropagation()">
                                    <div class="max-w-[600px] mx-auto p-8">
                                        <h2
                                            class="text-2xl font-semibold mb-8 text-blue-900 mt-4 dark:text-gray-100 text-center">
                                            Add New Mail Booking Order
                                        </h2>

                                        <!-- Unified Form -->
                                        <form id="unifiedOrderForm"
                                              action="{{ route('production-inquery-details.store') }}"
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
                                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email Address</label>
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
                                                <input type="date" name="customer_req_date" required
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


                                </table>
                            </div>

                            <div class="py-6 flex justify-center">

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
    document.addEventListener("DOMContentLoaded", function () {
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

        form.addEventListener('submit', function () {
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
