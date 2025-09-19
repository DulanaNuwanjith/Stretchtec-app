<head>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<div class="flex h-full w-full">
    @extends('layouts.technical-details-tabs')

    @section('content')
        <div class="flex-1 overflow-y-auto">
            <div class="">
                <div class="w-full px-6 lg:px-2">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
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

                            <div class="flex justify-between items-center mb-6">
                                <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Twill Tape Technical Details
                                </h1>
                                @if (in_array(Auth::user()->role, ['ADMIN', 'SUPERADMIN']))
                                    <button
                                        onclick="document.getElementById('addTapeTDModal').classList.remove('hidden')"
                                        class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded shadow">
                                        + Add New Item
                                    </button>
                                @endif
                            </div>

                            {{-- Main Table --}}
                            <div id="sampleInquiryRecordsScroll"
                                class="overflow-x-auto max-h-[1200px] bg-white dark:bg-gray-900 shadow rounded-lg">
                                <table class="table-fixed w-full text-sm divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead class="bg-gray-200 dark:bg-gray-700 text-left">
                                        <tr class="text-center">
                                            <th
                                                class="font-bold sticky left-0 top-0 z-20 bg-white px-4 py-3 w-48 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                Reference Number
                                            </th>
                                            <th
                                                class="font-bold sticky top-0 bg-gray-200 dark:bg-gray-700 px-4 py-3 w-56 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                Item Details
                                            </th>
                                            <th
                                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-56 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                Technical Details
                                            </th>
                                            <th
                                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-56 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                Quality Details
                                            </th>
                                            <th
                                                class="font-bold sticky top-0 bg-gray-200 px-4 py-3 w-56 text-xs text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                                Action
                                            </th>
                                        </tr>
                                    </thead>

                                    <tbody id="sampleInquiryRecords"
                                        class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                        <td class="text-center px-4 py-3">
                                            <div class="font-bold">REf 1234</div>
                                        </td>
                                        <!-- Item Details -->
                                        <td class="px-4 py-3 text-xs text-left break-words">
                                            <div>Created Date: </div>
                                            <div>Type: </div>
                                            <div>Size: </div>
                                            <div>Color: </div>
                                            <div>Machine: </div>
                                        </td>
                                        <!-- Technical Details -->
                                        <td class="px-4 py-3 text-xs text-left break-words">
                                            <div>Weft Yarn: </div>
                                            <div>Warp Yarn: </div>
                                            <div>Wheel Up: </div>
                                            <div>Wheel Down: </div>
                                            <div>Reed: </div>
                                            <div>Rubber Type: </div>
                                        </td>
                                        <!-- Quality Details -->
                                        <td class="px-4 py-3 text-xs text-left break-words">
                                            <div>Special Remarks: </div>
                                        </td>
                                    </tbody>
                                </table>
                            </div>

                            <div id="addTapeTDModal"
                                class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center py-5">
                                <div class="w-full max-w-[700px] bg-white dark:bg-gray-900 rounded-2xl shadow-2xl p-4 transform transition-all scale-95 max-h-[calc(100vh-10rem)] overflow-y-auto"
                                    onclick="event.stopPropagation()">
                                    <div class="max-w-[600px] mx-auto p-8">
                                        <h2
                                            class="text-2xl font-semibold mb-8 text-blue-900 mt-4 dark:text-gray-100 text-center">
                                            Add New Twill Tape Technical Detail
                                        </h2>
                                        <form action="" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="space-y-4">

                                                <div class="flex gap-4">
                                                    <div class="w-1/2">
                                                        <label for="reference_number"
                                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Reference
                                                            Number</label>
                                                        <input id="reference_number" type="text" name="reference_number"
                                                            required
                                                            class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                    </div>
                                                    <div class="w-1/2">
                                                        <label for="size"
                                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Size</label>
                                                        <input id="size" type="text" name="size" required
                                                            class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                    </div>
                                                </div>

                                                <div class="flex gap-4">
                                                    <div class="w-1/2">
                                                        <label for="reference_added_date"
                                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Color</label>
                                                        <input id="color" type="text" name="color" required
                                                            class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                    </div>
                                                    <div class="w-1/2">
                                                        <label for="rubber_type"
                                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Rubber
                                                            Type</label>
                                                        <input id="rubber_type" type="text" name="rubber_type" required
                                                            class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                    </div>
                                                </div>

                                                <div class="flex gap-4">
                                                    <div class="w-1/2">
                                                        <label for="weft_yarn"
                                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Weft
                                                            Yarn</label>
                                                        <input id="weft_yarn" type="text" name="weft_yarn" required
                                                            class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                    </div>
                                                    <div class="w-1/2">
                                                        <label for="warp_yarn"
                                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Warp
                                                            Yarn</label>
                                                        <input id="warp_yarn" type="text" name="warp_yarn" required
                                                            class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                    </div>
                                                </div>

                                                <div class="flex gap-4">
                                                    <div class="w-1/2">
                                                        <label for="wheel_up"
                                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Wheel
                                                            Up</label>
                                                        <input id="wheel_up" type="text" name="wheel_up" required
                                                            class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                    </div>
                                                    <div class="w-1/2">
                                                        <label for="wheel_down"
                                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Wheel
                                                            Down</label>
                                                        <input id="wheel_down" type="text" name="wheel_down" required
                                                            class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                    </div>
                                                </div>

                                                <div class="flex gap-4">
                                                    <div class="w-1/2">
                                                        <label for="needles"
                                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Reed</label>
                                                        <input id="needles" type="text" name="needles" required
                                                            class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                    </div>
                                                    <div class="w-1/2">
                                                        <label for="stretchability"
                                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Stretchability</label>
                                                        <input id="stretchability" type="text" name="stretchability"
                                                            class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                    </div>
                                                </div>
                                                <div class="flex gap-4">
                                                    <div class="w-1/2">
                                                        <label for="weight_per_yard"
                                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Weight
                                                            per Yard</label>
                                                        <input id="weight_per_yard" type="text" name="weight_per_yard"
                                                            class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                    </div>
                                                    <div class="w-1/2">

                                                    </div>
                                                </div>

                                                <div>
                                                    <label for="special_remarks"
                                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Special
                                                        Remarks</label>
                                                    <input id="special_remarks" type="text" name="special_remarks"
                                                        required
                                                        class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                </div>
                                            </div>

                                            <!-- File Upload -->
                                            <div class="flex flex-col items-center justify-center w-full mt-5">
                                                <label for="sampleFile" id="uploadLabel"
                                                    class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50
                                                        dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600 transition duration-200 overflow-hidden">
                                                    <div id="uploadContent"
                                                        class="flex flex-col items-center justify-center pt-5 pb-6 text-center w-full h-full">
                                                        <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400"
                                                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                            fill="none" viewBox="0 0 20 16">
                                                            <path stroke="currentColor" stroke-linecap="round"
                                                                stroke-linejoin="round" stroke-width="2"
                                                                d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                                        </svg>
                                                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                                                            <span class="font-semibold">Upload image related to technical
                                                                details(If have)</span>
                                                            or drag and drop
                                                        </p>
                                                        <p class="text-xs text-gray-500 dark:text-gray-400">PDF, JPG
                                                            (MAX. 800x400px)</p>
                                                    </div>

                                                    <div id="previewContainer"
                                                        class="hidden w-full h-full flex items-center justify-center overflow-hidden">
                                                    </div>

                                                    <input id="sampleFile" name="order_file" type="file"
                                                        class="hidden" accept=".pdf,.jpg,.jpeg" />
                                                </label>
                                            </div>

                                            <!-- Buttons -->
                                            <div class="flex justify-end gap-3 mt-12">
                                                <button type="button"
                                                    onclick="document.getElementById('addTapeTDModal').classList.add('hidden')"
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
