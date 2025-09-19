<head>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
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
                                + Add New Order
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
                                        Add New Sample Development
                                    </h2>
                                    <form action="" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="space-y-4">

                                            <!-- File Upload -->
                                            <div class="flex items-center justify-center w-full">
                                                <label for="sampleFile"
                                                    class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50
                                                     dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                                    <div class="flex flex-col items-center justify-center pt-5 pb-6 ">
                                                        <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400"
                                                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                            fill="none" viewBox="0 0 20 16">
                                                            <path stroke="currentColor" stroke-linecap="round"
                                                                stroke-linejoin="round" stroke-width="2"
                                                                d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                                        </svg>
                                                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                                                            <span class="font-semibold">Upload Order soft copy</span>
                                                            or drag and drop
                                                        </p>
                                                        <p class="text-xs text-gray-500 dark:text-gray-400">PDF, JPG
                                                            (MAX. 800x400px)</p>
                                                    </div>
                                                    <input id="sampleFile" name="order_file" type="file"
                                                        class="hidden" accept=".pdf,.jpg,.jpeg" />
                                                </label>
                                            </div>

                                            <!-- Oder Number -->
                                            <div>
                                                <label for="sampleQuantity"
                                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Oder
                                                    Number
                                                </label>
                                                <input id="sampleQuantity" type="text" name="sample_quantity"
                                                    required
                                                    class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm mb-4">
                                            </div>

                                            <!-- Inquiry receive date & Customer -->
                                            <div class="flex gap-4">
                                                <div class="w-1/2">
                                                    <label for="inquiryDate"
                                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Inquiry
                                                        Receive Date</label>
                                                    <input id="inquiryDate" type="date" name="inquiry_date"
                                                        required
                                                        class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                </div>
                                                <div class="w-1/2">
                                                    <label for="customer"
                                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Customer</label>
                                                    <input id="customer" type="text" name="customer" required
                                                        class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                </div>
                                            </div>

                                            <!-- Merchandiser & Item -->
                                            <div class="flex gap-4">
                                                <div class="w-1/2">
                                                    <label for="merchandiser"
                                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Merchandiser</label>
                                                    <input id="merchandiser" type="text" name="merchandiser"
                                                        required
                                                        class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                </div>
                                                <div class="w-1/2">
                                                    <label for="item"
                                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Item</label>
                                                    <input id="item" type="text" name="item" required
                                                        class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                </div>
                                            </div>

                                            <!-- Size & Colour -->
                                            <div class="flex gap-4">
                                                <div class="w-1/2">
                                                    <label for="size"
                                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Size</label>
                                                    <input id="size" type="text" name="size" required
                                                        class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                </div>
                                                <div class="w-1/2">
                                                    <label for="colour"
                                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Colour</label>
                                                    <input id="colour" type="text" name="colour" required
                                                        class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                </div>
                                            </div>

                                            <!-- Sample Quantity -->
                                            <div>
                                                <label for="sampleQuantity"
                                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Sample
                                                    Quantity (yds or mtr)</label>
                                                <input id="sampleQuantity" type="text" name="sample_quantity"
                                                    required
                                                    class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm mb-4">
                                            </div>

                                            <span class="font-sans font-semibold text-m block mb-2">SPECIAL CUSTOMER
                                                COMMENTS & REQUESTED DATES</span>

                                            <!-- Customer Comments & Requested Dates -->
                                            <div class="flex gap-4">
                                                <div class="w-1/2">
                                                    <label for="customerComments"
                                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Customer
                                                        Comments</label>
                                                    <input id="customerComments" type="text"
                                                        name="customer_comments"
                                                        class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                </div>
                                                <div class="w-1/2">
                                                    <label for="requestedDate"
                                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Customer
                                                        Requested Date</label>
                                                    <input id="requestedDate" type="date"
                                                        name="customer_requested_date"
                                                        class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                </div>
                                            </div>

                                        </div>

                                        <!-- Buttons -->
                                        <div class="flex justify-end gap-3 mt-12">
                                            <button type="button"
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
    