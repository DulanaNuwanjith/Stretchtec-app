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
                                <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Cord Technical Details
                                </h1>
                                @if (in_array(Auth::user()->role, ['ADMIN', 'SUPERADMIN']))
                                    <button onclick="document.getElementById('addCordTDModal').classList.remove('hidden')"
                                        class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded shadow">
                                        + Add New Technical Details
                                    </button>
                                @endif
                            </div>

                            {{-- Main Table --}}
                            <div id="CordTDRecordsScroll"
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

                                    <tbody id="CordTDRecords"
                                        class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                        @forelse($technicalCardCords as $technicalCardCord)
                                            <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200">

                                                <!-- Reference -->
                                                <td class="text-center sticky left-0 z-10 px-4 py-3 bg-gray-100 whitespace-normal break-words border-r border-gray-300">
                                                    <span class="text-sm font-bold text-gray-800 dark:text-gray-200">
                                                        {{ $technicalCardCord->reference_number ?? '-' }}
                                                    </span>
                                                </td>

                                                <!-- Item Details -->
                                                <td class="px-4 py-3 whitespace-normal break-words border-r border-gray-300">
                                                    <div><span class="font-medium text-gray-600 dark:text-gray-400">Created
                                                            Date:</span>
                                                        {{ $technicalCardCord->created_at?->format('Y-m-d') ?? '-' }}</div>
                                                    <div><span
                                                            class="font-medium text-gray-600 dark:text-gray-400">Type:</span>
                                                        {{ $technicalCardCord->type ?? '-' }}</div>
                                                    <div><span
                                                            class="font-medium text-gray-600 dark:text-gray-400">Size:</span>
                                                        {{ $technicalCardCord->size ?? '-' }}</div>
                                                    <div><span
                                                            class="font-medium text-gray-600 dark:text-gray-400">Color:</span>
                                                        {{ $technicalCardCord->color ?? '-' }}</div>
                                                    <div><span
                                                            class="font-medium text-gray-600 dark:text-gray-400">Machine:</span>
                                                        {{ $technicalCardCord->machine ?? '-' }}</div>
                                                </td>

                                                <!-- Technical Details -->
                                                <td class="px-4 py-3 whitespace-normal break-words border-r border-gray-300">
                                                    <div><span class="font-medium">Rubber Type:</span>
                                                        {{ $technicalCardCord->rubber_type ?? '-' }}</div>
                                                    <div><span class="font-medium">Yarn Count:</span>
                                                        {{ $technicalCardCord->yarn_count ?? '-' }}</div>
                                                    <div><span class="font-medium">Wheel Up:</span>
                                                        {{ $technicalCardCord->wheel_up ?? '-' }}</div>
                                                    <div><span class="font-medium">Wheel Down:</span>
                                                        {{ $technicalCardCord->wheel_down ?? '-' }}</div>
                                                    <div><span class="font-medium">Spindles:</span>
                                                        {{ $technicalCardCord->spindles ?? '-' }}</div>
                                                </td>

                                                <!-- Quality Details -->
                                                <td class="px-4 py-3 whitespace-normal break-words border-r border-gray-300">
                                                    <div><span class="font-medium">Stretchability:</span>
                                                        {{ $technicalCardCord->stretchability ?? '-' }}</div>
                                                    <div><span class="font-medium">Weight Per Yard:</span>
                                                        {{ $technicalCardCord->weight_per_yard ?? '-' }} g</div>
                                                    <div><span class="font-medium">Remarks:</span>
                                                        {{ $technicalCardCord->special_remarks ?? '-' }}</div>
                                                </td>

                                                <!-- Actions -->
                                                <td class="px-4 py-3 text-center">
                                                    <div class="flex gap-2 justify-center items-center">
                                                        <!-- View Button -->
                                                        @if ($technicalCardCord->url)
                                                            <a href="{{ $technicalCardCord->url }}" target="_blank"
                                                                class="flex items-center justify-center w-20 h-9 bg-blue-500 text-white text-sm font-semibold rounded-lg shadow hover:bg-blue-600 transition-all">
                                                                View </a>
                                                        @else
                                                            <span></span>
                                                            @endif <!-- Add Image Button (inline upload) -->
                                                            @if (!$technicalCardCord->url)
                                                                <form
                                                                    action="{{ route('technicalCards.storeImage', $technicalCardCord->id) }}"
                                                                    method="POST" enctype="multipart/form-data"
                                                                    class="inline-block"> @csrf <label
                                                                        class="flex items-center justify-center w-24 h-9 bg-green-500 text-white text-sm font-semibold rounded-lg shadow hover:bg-green-600 cursor-pointer transition-all mt-3.5">
                                                                        Add Image <input type="file" name="url"
                                                                            accept=".jpg,.jpeg,.png,.pdf" class="hidden"
                                                                            onchange="this.form.submit()"> </label> </form>
                                                            @endif <!-- Delete Button -->
                                                            <form
                                                                action="{{ route('technicalCards.delete', $technicalCardCord->id) }}"
                                                                method="POST"
                                                                onsubmit="return confirm('Are you sure you want to delete this record?');">
                                                                @csrf @method('DELETE') <button type="submit"
                                                                    class="flex items-center justify-center w-20 h-9 bg-red-500 text-white text-sm font-semibold rounded-lg shadow hover:bg-red-600 transition-all mt-3.5">
                                                                    Delete </button> </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5"
                                                    class="text-center px-6 py-6 text-gray-500 text-sm italic">
                                                    No Cord Technical Cards found.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>

                                <!-- Pagination Links -->
                                @if($technicalCardCords->hasPages())
                                    <div class="py-4 flex justify-center">
                                        {{ $technicalCardCords->links('pagination::tailwind') }}
                                    </div>
                                @endif
                            </div>

                            <div id="addCordTDModal"
                                class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center py-5">
                                <div class="w-full max-w-[700px] bg-white dark:bg-gray-900 rounded-2xl shadow-2xl p-4 transform transition-all scale-95 max-h-[calc(100vh-10rem)] overflow-y-auto"
                                    onclick="event.stopPropagation()">
                                    <div class="max-w-[600px] mx-auto p-8">
                                        <h2
                                            class="text-2xl font-semibold mb-8 text-blue-900 mt-4 dark:text-gray-100 text-center">
                                            Add New Cord Technical Detail
                                        </h2>
                                        <form action="{{ route('cordTD.create') }}" method="POST"
                                            enctype="multipart/form-data">
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
                                                        <label for="machine"
                                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Machine</label>
                                                        <input id="machine" type="text" name="machine" required
                                                            class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                    </div>
                                                </div>

                                                <div class="flex gap-4">
                                                    <div class="w-1/2">
                                                        <label for="size"
                                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Size</label>
                                                        <input id="size" type="text" name="size" required
                                                            class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                    </div>
                                                    <div class="w-1/2">
                                                        <label for="reference_added_date"
                                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Color</label>
                                                        <input id="color" type="text" name="color" required
                                                            class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                    </div>
                                                </div>

                                                <div class="flex gap-4">
                                                    <div class="w-1/2">
                                                        <label for="rubber_type"
                                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Rubber
                                                            Type</label>
                                                        <input id="rubber_type" type="text" name="rubber_type"
                                                            required
                                                            class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                    </div>
                                                    <div class="w-1/2">
                                                        <label for="yarn_count"
                                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Yarn
                                                            Count</label>
                                                        <input id="yarn_count" type="text" name="yarn_count" required
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
                                                        <label for="rubber_type"
                                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Rubber
                                                            Type</label>
                                                        <input id="rubber_type" type="text" name="rubber_type"
                                                            required
                                                            class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                    </div>
                                                    <div class="w-1/2">
                                                        <label for="spindles"
                                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Spindles</label>
                                                        <input id="spindles" type="text" name="spindles"
                                                            class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                    </div>
                                                </div>

                                                <div class="flex gap-4">
                                                    <div class="w-1/2">
                                                        <label for="weight_per_yard"
                                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Weight
                                                            per Yard</label>
                                                        <input id="weight_per_yard" type="number" name="weight_per_yard"
                                                            class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                    </div>
                                                    <div class="w-1/2">
                                                        <label for="stretchability"
                                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Stretchability</label>
                                                        <input id="stretchability" type="text" name="stretchability"
                                                            class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm">
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

                                                    <input id="sampleFile" name="url" type="file" class="hidden"
                                                        accept=".pdf,.jpg,.jpeg" />
                                                </label>
                                            </div>

                                            <!-- Buttons -->
                                            <div class="flex justify-end gap-3 mt-12">
                                                <button type="button"
                                                    onclick="document.getElementById('addCordTDModal').classList.add('hidden')"
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
        const fileInput = document.getElementById('sampleFile');
        const previewContainer = document.getElementById('previewContainer');
        const uploadContent = document.getElementById('uploadContent');
        const uploadLabel = document.getElementById('uploadLabel');

        // Show preview for a given file
        function showPreview(file) {
            previewContainer.innerHTML = ''; // Clear previous preview

            if (!file) {
                // No file: show instructions, hide preview
                previewContainer.classList.add('hidden');
                uploadContent.style.display = 'flex';
                return;
            }

            // Hide instructions, show preview
            uploadContent.style.display = 'none';
            previewContainer.classList.remove('hidden');

            const fileType = file.type;

            if (fileType === 'application/pdf') {
                // PDF preview: icon + filename
                const pdfPreview = document.createElement('div');
                pdfPreview.classList.add(
                    'flex',
                    'flex-col',
                    'items-center',
                    'justify-center',
                    'text-center',
                    'text-gray-800',
                    'dark:text-gray-200',
                    'p-4'
                );

                pdfPreview.innerHTML = `
            <svg class="w-16 h-16 mb-2 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 0C5.371 0 0 5.371 0 12s5.371 12 12 12 12-5.371 12-12S18.629 0 12 0zm1 17h-2v-2h2v2zm1.07-7.75l-.9.92C12.45 11.9 12 12.5 12 14h-2v-.5c0-.8.45-1.5 1.07-2.18l1.2-1.2c.37-.36.58-.86.58-1.42 0-1.1-.9-2-2-2s-2 .9-2 2H7c0-2.21 1.79-4 4-4s4 1.79 4 4c0 .88-.36 1.68-.93 2.25z"/>
            </svg>
            <p class="font-semibold break-words max-w-[90%]">${file.name}</p>
        `;

                previewContainer.appendChild(pdfPreview);

            } else if (fileType.startsWith('image/')) {
                // Image preview thumbnail
                const img = document.createElement('img');
                img.classList.add('max-w-full', 'max-h-full', 'object-contain', 'rounded');
                img.alt = 'Uploaded Image Preview';

                const reader = new FileReader();
                reader.onload = (e) => {
                    img.src = e.target.result;
                };
                reader.readAsDataURL(file);

                previewContainer.appendChild(img);

            } else {
                // Unsupported file type
                const unsupported = document.createElement('p');
                unsupported.classList.add('text-red-600', 'font-semibold');
                unsupported.textContent = 'File preview not available';
                previewContainer.appendChild(unsupported);
            }
        }

        // Handle file input change
        fileInput.addEventListener('change', () => {
            const file = fileInput.files[0];
            showPreview(file);
        });

        // Drag and drop handlers
        ['dragenter', 'dragover'].forEach(eventName => {
            uploadLabel.addEventListener(eventName, e => {
                e.preventDefault();
                e.stopPropagation();
                uploadLabel.classList.add('bg-gray-200', 'dark:bg-gray-600');
            });
        });

        ['dragleave', 'drop'].forEach(eventName => {
            uploadLabel.addEventListener(eventName, e => {
                e.preventDefault();
                e.stopPropagation();
                uploadLabel.classList.remove('bg-gray-200', 'dark:bg-gray-600');
            });
        });

        // Handle drop event - assign dropped files to input and show preview
        uploadLabel.addEventListener('drop', e => {
            const dt = e.dataTransfer;
            if (dt.files.length) {
                fileInput.files = dt.files;
                showPreview(dt.files[0]);
            }
        });
    </script>
@endsection
