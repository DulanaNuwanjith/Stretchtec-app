<head>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Stretchtec</title>
</head>

<div class="flex h-full w-full">
    @extends('layouts.production-tabs')

@section('content')
    <div class="flex-1 overflow-y-hidden mb-20">
        <div class="">
            <div class="w-full px-6 lg:px-2">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 text-gray-900 dark:text-gray-100">

                        @if (session('success'))
                            <div
                                class="mb-4 p-4 text-green-800 bg-green-100 border border-green-300 rounded-md dark:text-green-200 dark:bg-green-900 dark:border-green-800">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div
                                class="mb-4 p-4 text-red-800 bg-red-100 border border-red-300 rounded-md dark:text-red-200 dark:bg-red-900 dark:border-red-800">
                                {{ session('error') }}
                            </div>
                        @endif

                        <div class="flex justify-between items-center mb-6">
                            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Production Inquiry Records
                            </h1>
                            <button onclick="document.getElementById('addSampleModal').classList.remove('hidden')"
                                class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded shadow">
                                + Add New Production Order
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
                                        Add New Production Order
                                    </h2>
                                    <form action="" method="POST" enctype="multipart/form-data">
                                        @csrf

                                        <!-- ORDER TYPE TOGGLE -->
                                        <div class="mb-6">
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Order Type</label>

                                            <!-- Tab-style toggle -->
                                            <div class="flex space-x-4 mt-3 border-b border-gray-300 dark:border-gray-700">
                                                <button type="button"
                                                        onclick="setOrderType('sample')"
                                                        id="tab-sample"
                                                        class="pb-2 px-3 font-semibold border-b-2 border-blue-500 text-blue-600">
                                                    From Sample
                                                </button>
                                                <button type="button"
                                                        onclick="setOrderType('direct')"
                                                        id="tab-direct"
                                                        class="pb-2 px-3 font-semibold text-gray-600 dark:text-gray-300 hover:text-blue-500">
                                                    Direct Order
                                                </button>
                                            </div>

                                            <!-- Hidden input to send selected type -->
                                            <input type="hidden" name="order_type" id="order_type" value="sample">
                                        </div>

                                        <!-- DIRECT ORDER FIELDS -->
                                        <div id="directOrderFields" class="space-y-4 hidden">
                                            <!-- Reference Number -->
                                            <div>
                                                <label for="referenceNumber" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Reference Number</label>
                                                <input id="referenceNumber" type="text" name="referenceNumber"
                                                       class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                            </div>

                                            <!-- PO Number -->
                                            <div>
                                                <label for="poNumber" class="block text-sm font-medium text-gray-700 dark:text-gray-300">PO Number</label>
                                                <input id="poNumber" type="text" name="po_number"
                                                       class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                            </div>

                                            <!-- Shade & Colour -->
                                            <div class="flex gap-4">
                                                <div class="w-1/2">
                                                    <label for="shade" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Shade</label>
                                                    <input id="shade" type="text" name="shade"
                                                           class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                </div>
                                                <div class="w-1/2">
                                                    <label for="colour" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Colour</label>
                                                    <input id="colour" type="text" name="colour"
                                                           class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                </div>
                                            </div>

                                            <!-- Size & Quantity -->
                                            <div class="flex gap-4">
                                                <div class="w-1/2">
                                                    <label for="size" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Size</label>
                                                    <input id="size" type="text" name="size"
                                                           class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                </div>
                                                <div class="w-1/2">
                                                    <label for="qtyRequested" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Quantity Requested</label>
                                                    <input id="qtyRequested" type="text" name="qty_requested"
                                                           class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                </div>
                                            </div>

                                            <!-- Customer Merchandiser & TKT -->
                                            <div class="flex gap-4">
                                                <div class="w-1/2">
                                                    <label for="customerMerchandiser" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Customer Merchandiser</label>
                                                    <input id="customerMerchandiser" type="text" name="customer_merchandiser"
                                                           class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                </div>
                                                <div class="w-1/2">
                                                    <label for="tkt" class="block text-sm font-medium text-gray-700 dark:text-gray-300">TKT</label>
                                                    <input id="tkt" type="text" name="tkt"
                                                           class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                </div>
                                            </div>

                                            <!-- Customer Requested Date & Notes -->
                                            <div class="flex gap-4">
                                                <div class="w-1/2">
                                                    <label for="customerRequestedDate" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Customer Requested Date</label>
                                                    <input id="customerRequestedDate" type="date" name="customer_requested_date"
                                                           class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                </div>
                                                <div class="w-1/2">
                                                    <label for="customerNotes" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Customer Notes</label>
                                                    <input id="customerNotes" type="text" name="customer_notes"
                                                           class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- SAMPLE ORDER FIELDS (Default Visible) -->
                                        <div id="sampleOrderFields" class="space-y-4">
                                            <!-- Select Reference Number -->
                                            <div>
                                                <label for="sampleReference" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Select Sample Reference</label>
                                                <select id="sampleReference" name="sample_reference" onchange="fetchSampleDetails(this.value)"
                                                        class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                    <option value="">-- Select --</option>
                                                    @foreach($samples as $sample)
                                                        <option value="{{ $sample->id }}">{{ $sample->reference_no }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <!-- Auto-filled fields -->
                                            <div class="flex gap-4">
                                                <div class="w-1/2">
                                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Shade</label>
                                                    <input id="sampleShade" type="text" readonly
                                                           class="w-full mt-1 px-3 py-2 border rounded-md bg-gray-100 dark:bg-gray-600 text-sm">
                                                </div>
                                                <div class="w-1/2">
                                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Colour</label>
                                                    <input id="sampleColour" type="text" readonly
                                                           class="w-full mt-1 px-3 py-2 border rounded-md bg-gray-100 dark:bg-gray-600 text-sm">
                                                </div>
                                            </div>

                                            <div class="flex gap-4">
                                                <div class="w-1/2">
                                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">TKT</label>
                                                    <input id="sampleTKT" type="text" readonly
                                                           class="w-full mt-1 px-3 py-2 border rounded-md bg-gray-100 dark:bg-gray-600 text-sm">
                                                </div>
                                                <div class="w-1/2">
                                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Size</label>
                                                    <input id="sampleSize" type="text" readonly
                                                           class="w-full mt-1 px-3 py-2 border rounded-md bg-gray-100 dark:bg-gray-600 text-sm">
                                                </div>
                                            </div>

                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Supplier</label>
                                                <input id="sampleSupplier" type="text" readonly
                                                       class="w-full mt-1 px-3 py-2 border rounded-md bg-gray-100 dark:bg-gray-600 text-sm">
                                            </div>

                                            <!-- Editable fields -->
                                            <div class="flex gap-4">
                                                <div class="w-1/2">
                                                    <label for="sampleQty" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Quantity</label>
                                                    <input id="sampleQty" type="text" name="qty"
                                                           class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                </div>
                                                <div class="w-1/2">
                                                    <label for="samplePoNumber" class="block text-sm font-medium text-gray-700 dark:text-gray-300">PO Number</label>
                                                    <input id="samplePoNumber" type="text" name="po_number_sample"
                                                           class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                </div>
                                            </div>

                                            <div>
                                                <label for="sampleCustomerRequestedDate" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Customer Requested Date</label>
                                                <input id="sampleCustomerRequestedDate" type="date" name="customer_requested_date_sample"
                                                       class="w-full mt-1 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                            </div>
                                        </div>

                                        <!-- Buttons -->
                                        <div class="flex justify-end gap-3 mt-12">
                                            <button type="button" onclick="document.getElementById('addSampleModal').classList.add('hidden')"
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

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleOrderType(type) {
        document.getElementById('directOrderFields').classList.toggle('hidden', type !== 'direct');
        document.getElementById('sampleOrderFields').classList.toggle('hidden', type !== 'sample');
    }

    function fetchSampleDetails(sampleId) {
        if (!sampleId) return;

        fetch(`/product-catalog/${sampleId}/details`)
            .then(res => res.json())
            .then(data => {
                document.getElementById('sampleShade').value = data.shade ?? '';
                document.getElementById('sampleColour').value = data.colour ?? '';
                document.getElementById('sampleTKT').value = data.tkt ?? '';
                document.getElementById('sampleSize').value = data.size ?? '';
                document.getElementById('sampleSupplier').value = data.supplier ?? '';
            })
            .catch(err => {
                console.error("Error fetching sample details:", err);
            });
    }
</script>

<script>
    function setOrderType(type) {
        const directFields = document.getElementById('directOrderFields');
        const sampleFields = document.getElementById('sampleOrderFields');
        const orderTypeInput = document.getElementById('order_type');

        // reset tab styles
        document.getElementById('tab-direct').classList.remove('border-b-2', 'border-blue-500', 'text-blue-600');
        document.getElementById('tab-direct').classList.add('text-gray-600', 'dark:text-gray-300');

        document.getElementById('tab-sample').classList.remove('border-b-2', 'border-blue-500', 'text-blue-600');
        document.getElementById('tab-sample').classList.add('text-gray-600', 'dark:text-gray-300');

        if (type === 'direct') {
            directFields.classList.remove('hidden');
            sampleFields.classList.add('hidden');
            orderTypeInput.value = 'direct';
            document.getElementById('tab-direct').classList.add('border-b-2', 'border-blue-500', 'text-blue-600');
        } else {
            sampleFields.classList.remove('hidden');
            directFields.classList.add('hidden');
            orderTypeInput.value = 'sample';
            document.getElementById('tab-sample').classList.add('border-b-2', 'border-blue-500', 'text-blue-600');
        }
    }
</script>
@endsection
