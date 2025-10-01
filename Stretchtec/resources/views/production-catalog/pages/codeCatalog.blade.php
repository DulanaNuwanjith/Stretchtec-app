<head>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<div class="flex h-full w-full">
    @extends('layouts.product-catalog-tabs')

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

                            <!-- Filter Form -->
                            <form id="filterForm1" method="GET" action="{{ route('codeCatalog.index') }}"
                                  class="mb-6 sticky top-0 z-20 flex gap-6 items-center">

                                <div class="flex items-center gap-4 flex-wrap">

                                    {{-- Order DROPDOWN --}}
                                    <div class="relative inline-block text-left w-48 dropdown-group">
                                        <label for="orderNoDropdown"
                                               class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Order
                                            No</label>

                                        <button type="button" id="orderNoDropdown"
                                                class="inline-flex w-full justify-between rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-gray-300 hover:bg-gray-50 h-10 dark:bg-gray-700 dark:text-white"
                                                onclick="toggleDropdown('orderNo')" aria-haspopup="listbox"
                                                aria-expanded="false">
                                            <span
                                                id="selectedOrderNo">{{ request('orderNo') ?: 'Select Order No' }}</span>
                                            <svg class="ml-2 h-5 w-5 text-gray-400" viewBox="0 0 20 20"
                                                 fill="currentColor">
                                                <path fill-rule="evenodd"
                                                      d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 10.94l3.71-3.71a.75.75 0 1 1 1.06 1.06l-4.24 4.24a.75.75 0 0 1-1.06 0L5.25 8.29a.75.75 0 0 1-.02-1.08z"
                                                      clip-rule="evenodd"/>
                                            </svg>
                                        </button>

                                        <div id="orderNoDropdownMenu"
                                             class="hidden absolute z-10 mt-2 w-full rounded-md bg-white shadow-lg ring-1 ring-black/5 dark:bg-gray-700 max-h-48 overflow-y-auto">
                                            <div class="p-2 sticky top-0 bg-white dark:bg-gray-700 z-10">
                                                <input type="text" id="orderNoSearchInput"
                                                       placeholder="Search Order No..."
                                                       class="w-full px-2 py-1 text-sm border rounded-md dark:bg-gray-600 dark:text-white"
                                                       onkeyup="filterOptions('orderNo')"/>
                                            </div>
                                            <div class="py-1" role="listbox">
                                                <button type="button"
                                                        class="orderNo-option w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600"
                                                        onclick="selectOption('orderNo', '')">All
                                                </button>
                                                @foreach ($orderNos as $orderNo)
                                                    <button type="button"
                                                            class="orderNo-option w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600"
                                                            onclick="selectOption('orderNo', '{{ $orderNo }}')">{{ $orderNo }}</button>
                                                @endforeach
                                            </div>
                                        </div>
                                        <input type="hidden" name="orderNo" id="orderNoInput"
                                               value="{{ request('orderNo') }}">
                                    </div>

                                    {{-- MERCHANDISER DROPDOWN --}}
                                    <div class="relative inline-block text-left w-48 dropdown-group">
                                        <label for="merchandiserDropdown"
                                               class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Merchandiser</label>

                                        <button type="button" id="merchandiserDropdown"
                                                class="inline-flex w-full justify-between rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-gray-300 hover:bg-gray-50 h-10 dark:bg-gray-700 dark:text-white"
                                                onclick="toggleDropdown('merchandiser')" aria-haspopup="listbox"
                                                aria-expanded="false">
                                            <span
                                                id="selectedMerchandiser">{{ request('merchandiser') ?: 'Select Merchandiser' }}</span>
                                            <svg class="ml-2 h-5 w-5 text-gray-400" viewBox="0 0 20 20"
                                                 fill="currentColor">
                                                <path fill-rule="evenodd"
                                                      d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 10.94l3.71-3.71a.75.75 0 1 1 1.06 1.06l-4.24 4.24a.75.75 0 0 1-1.06 0L5.25 8.29a.75.75 0 0 1-.02-1.08z"
                                                      clip-rule="evenodd"/>
                                            </svg>
                                        </button>

                                        <div id="merchandiserDropdownMenu"
                                             class="hidden absolute z-10 mt-2 w-full rounded-md bg-white shadow-lg ring-1 ring-black/5 dark:bg-gray-700 max-h-48 overflow-y-auto">
                                            <div class="p-2 sticky top-0 bg-white dark:bg-gray-700 z-10">
                                                <input type="text" id="merchandiserSearchInput"
                                                       placeholder="Search Merchandisers..."
                                                       class="w-full px-2 py-1 text-sm border rounded-md dark:bg-gray-600 dark:text-white"
                                                       onkeyup="filterOptions('merchandiser')"/>
                                            </div>
                                            <div class="py-1" role="listbox">
                                                <button type="button"
                                                        class="merchandiser-option w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600"
                                                        onclick="selectOption('merchandiser', '')">All
                                                </button>
                                                @foreach ($merchandisers as $merchandiser)
                                                    <button type="button"
                                                            class="merchandiser-option w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600"
                                                            onclick="selectOption('merchandiser', '{{ $merchandiser }}')">{{ $merchandiser }}</button>
                                                @endforeach
                                            </div>
                                        </div>
                                        <input type="hidden" name="merchandiser" id="merchandiserInput"
                                               value="{{ request('merchandiser') }}">
                                    </div>

                                    {{-- REFERENCE NO DROPDOWN --}}
                                    <div class="relative inline-block text-left w-48 dropdown-group">
                                        <label for="referenceNoDropdown"
                                               class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Reference
                                            No</label>

                                        <button type="button" id="referenceNoDropdown"
                                                class="inline-flex w-full justify-between rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-gray-300 hover:bg-gray-50 h-10 dark:bg-gray-700 dark:text-white"
                                                onclick="toggleDropdown('referenceNo')" aria-haspopup="listbox"
                                                aria-expanded="false">
                                            <span
                                                id="selectedReferenceNo">{{ request('referenceNo') ?: 'Select Reference No' }}</span>
                                            <svg class="ml-2 h-5 w-5 text-gray-400" viewBox="0 0 20 20"
                                                 fill="currentColor">
                                                <path fill-rule="evenodd"
                                                      d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 10.94l3.71-3.71a.75.75 0 1 1 1.06 1.06l-4.24 4.24a.75.75 0 0 1-1.06 0L5.25 8.29a.75.75 0 0 1-.02-1.08z"
                                                      clip-rule="evenodd"/>
                                            </svg>
                                        </button>

                                        <div id="referenceNoDropdownMenu"
                                             class="hidden absolute z-10 mt-2 w-full rounded-md bg-white shadow-lg ring-1 ring-black/5 dark:bg-gray-700 max-h-48 overflow-y-auto">
                                            <div class="p-2 sticky top-0 bg-white dark:bg-gray-700 z-10">
                                                <input type="text" id="referenceNoSearchInput"
                                                       placeholder="Search Reference Nos..."
                                                       class="w-full px-2 py-1 text-sm border rounded-md dark:bg-gray-600 dark:text-white"
                                                       onkeyup="filterOptions('referenceNo')"/>
                                            </div>
                                            <div class="py-1" role="listbox">
                                                <button type="button"
                                                        class="referenceNo-option w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600"
                                                        onclick="selectOption('referenceNo', '')">All
                                                </button>
                                                @foreach ($referenceNos as $referenceNo)
                                                    <button type="button"
                                                            class="referenceNo-option w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600"
                                                            onclick="selectOption('referenceNo', '{{ $referenceNo }}')">{{ $referenceNo }}</button>
                                                @endforeach
                                            </div>
                                        </div>
                                        <input type="hidden" name="referenceNo" id="referenceNoInput"
                                               value="{{ request('referenceNo') }}">
                                    </div>

                                </div>

                                {{-- ACTION BUTTONS --}}
                                <div class="flex items-end gap-2 mt-2">
                                    <button type="submit"
                                            class="mt-4 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                                        Apply
                                        Filters
                                    </button>
                                    <button type="button" id="clearFiltersBtn"
                                            class="mt-4 bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-white px-4 py-2 rounded hover:bg-gray-300">
                                        Clear
                                    </button>
                                </div>
                            </form>

                            <div class="flex justify-between items-center mb-6">
                                <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Cord Production Catalog
                                </h1>
                                @if (in_array(Auth::user()->role, ['SAMPLEDEVELOPER', 'SUPERADMIN']))
                                    <button
                                        onclick="document.getElementById('addCodeCatalogModal').classList.remove('hidden')"
                                        class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded shadow">
                                        + Add New Item
                                    </button>
                                @endif
                            </div>

                            <div class="overflow-x-auto bg-white dark:bg-gray-900 shadow rounded-lg">
                                <table class="table-fixed w-full text-sm divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead class="bg-gray-200 dark:bg-gray-700 text-left">
                                    <tr class="text-center">
                                        <th
                                            class="font-bold sticky left-0 z-10 bg-white px-4 py-3 w-36 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                            Order No
                                        </th>
                                        <th
                                            class="font-bold px-4 py-3 w-48 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                            Reference No
                                        </th>
                                        <th
                                            class="font-bold px-4 py-3 w-32 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                            Date
                                        </th>
                                        <th
                                            class="font-bold px-4 py-3 w-36 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                            Merchandiser
                                        </th>
                                        <th
                                            class="font-bold px-4 py-3 w-32 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                            Size
                                        </th>
                                        <th
                                            class="font-bold px-4 py-3 w-32 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                            Colour
                                        </th>
                                        <th
                                            class="font-bold px-4 py-3 w-32 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                            Shade
                                        </th>
                                        <th
                                            class="font-bold px-4 py-3 w-32 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                            TKT
                                        </th>
                                        <th
                                            class="font-bold px-4 py-3 w-32 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                            Supplier
                                        </th>
                                        <th colspan="2"
                                            class="font-bold px-4 py-3 w-[14rem] text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                            Approved By
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody id="productionCatalogTable"
                                           class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach ($catalogs as $catalog)
                                        <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200 text-center">
                                            @php
                                                $userRole = Auth::user()->role;
                                            @endphp
                                            @if (in_array($userRole, ['SUPERADMIN', 'SAMPLEDEVELOPER', 'CUSTOMERCOORDINATOR']))
                                                {{-- Editable: Upload allowed --}}
                                                <td
                                                    class="sticky left-0 z-10 bg-white px-4 py-3 bg-gray-100 border-r border-gray-300 text-left whitespace-normal break-words">
                                                    <form id="uploadForm-{{ $catalog->id }}"
                                                          action="{{ route('catalog.uploadImage', $catalog->id) }}"
                                                          method="POST" enctype="multipart/form-data" class="m-0 p-0">
                                                        @csrf

                                                        <span id="orderNo-{{ $catalog->id }}"
                                                              class="font-semibold text-sm text-blue-700 cursor-pointer hover:underline select-none"
                                                              onclick="handleOrderNoClick({{ $catalog->id }}, {{ $catalog->order_image ? 'true' : 'false' }})">
                                                                {{ $catalog->order_no }}
                                                            </span>

                                                        @if (!$catalog->order_image)
                                                            <div class="text-xs text-red-600 mt-1">Need to upload image
                                                            </div>
                                                        @endif

                                                        <input id="file-upload-{{ $catalog->id }}" type="file"
                                                               name="order_image" accept="image/*" class="hidden"
                                                               onchange="document.getElementById('uploadForm-{{ $catalog->id }}').submit()"/>

                                                        @if ($catalog->order_image)
                                                            <div id="imagePreview-{{ $catalog->id }}"
                                                                 class="hidden mt-2">
                                                                <a href="{{ asset('storage/order_images/' . $catalog->order_image) }}"
                                                                   target="_blank"
                                                                   class="block w-24 h-24 rounded overflow-hidden border border-gray-300 shadow-sm hover:shadow-md transition">
                                                                    <img
                                                                        src="{{ asset('storage/order_images/' . $catalog->order_image) }}"
                                                                        alt="Order Image"
                                                                        class="w-full h-full object-cover"/>
                                                                </a>
                                                            </div>
                                                        @endif
                                                    </form>
                                                </td>
                                            @else
                                                {{-- View-only for other roles --}}
                                                <td
                                                    class="sticky left-0 z-10 bg-white px-4 py-3 bg-gray-100 border-r border-gray-300 text-left whitespace-normal break-words">
                                                        <span class="font-semibold text-sm text-gray-700">
                                                            {{ $catalog->order_no }}
                                                        </span>

                                                    @if ($catalog->order_image)
                                                        <div class="mt-2">
                                                            <a href="{{ asset('storage/order_images/' . $catalog->order_image) }}"
                                                               target="_blank"
                                                               class="block w-24 h-24 rounded overflow-hidden border border-gray-300 shadow-sm hover:shadow-md transition">
                                                                <img
                                                                    src="{{ asset('storage/order_images/' . $catalog->order_image) }}"
                                                                    alt="Order Image"
                                                                    class="w-full h-full object-cover"/>
                                                            </a>
                                                        </div>
                                                    @else
                                                        <div class="text-xs text-red-600 mt-1">No image uploaded</div>
                                                    @endif
                                                </td>
                                            @endif

                                            <td
                                                class="px-4 py-3 w-48 whitespace-normal break-words border-r border-gray-300">
                                                <span class="readonly">{{ $catalog->reference_no }}</span>
                                                <input
                                                    class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                    value="{{ $catalog->reference_no }}"/>
                                            </td>
                                            <td
                                                class="px-4 py-3 w-40 whitespace-normal break-words border-r border-gray-300">
                                                    <span
                                                        class="readonly">{{ $catalog->reference_added_date?->format('Y-m-d') }}</span>
                                                <input type="date"
                                                       class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                       value="{{ $catalog->reference_added_date?->format('Y-m-d') }}"/>
                                            </td>
                                            <td
                                                class="px-4 py-3 w-36 whitespace-normal break-words border-r border-gray-300">
                                                <span class="readonly">{{ $catalog->coordinator_name }}</span>
                                                <input
                                                    class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                    value="{{ $catalog->coordinator_name }}"/>
                                            </td>
                                            <td
                                                class="px-4 py-3 w-32 whitespace-normal break-words border-r border-gray-300">
                                                <span class="readonly">{{ $catalog->size }}</span>
                                                <input
                                                    class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                    value="{{ $catalog->size }}"/>
                                            </td>
                                            <td
                                                class="px-4 py-3 w-32 whitespace-normal break-words border-r border-gray-300">
                                                <span class="readonly">{{ $catalog->colour }}</span>
                                                <input
                                                    class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                    value="{{ $catalog->colour }}"/>
                                            </td>

                                            <td class="px-4 py-3 w-32 whitespace-normal break-words border-r border-gray-300"
                                                x-data="{ open: false, selectedShade: '{{ $catalog->shade }}', optionText: '' }">

                                                @php
                                                    $shadeList = preg_split('/[\,\/]/', $catalog->shade);
                                                @endphp

                                                @if(count($shadeList) > 1)
                                                    {{-- Multiple shades: show button --}}
                                                    <button type="button" @click="open = true"
                                                            class="px-2 py-1 rounded bg-gray-300 text-black hover:bg-gray-400 text-sm">
                                                        Select Shade
                                                    </button>

                                                    {{-- Modal --}}
                                                    <div x-show="open" x-transition
                                                         class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
                                                         style="display: none;">
                                                        <div
                                                            class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-full max-w-sm relative">
                                                            {{-- Close button --}}
                                                            <button @click="open = false"
                                                                    class="absolute top-2 right-2 text-gray-600 hover:text-gray-900">
                                                                ✕
                                                            </button>

                                                            <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">
                                                                Select Shade</h2>

                                                            <form
                                                                action="{{ route('productCatalog.updateShade', $catalog->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('PATCH')

                                                                <div class="space-y-3">
                                                                    @foreach($shadeList as $shadeOption)
                                                                        <label class="flex items-center gap-2">
                                                                            <input type="radio" name="selected_shade"
                                                                                   value="{{ trim($shadeOption) }}"
                                                                                   @click="selectedShade = '{{ trim($shadeOption) }}'">
                                                                            <span>{{ trim($shadeOption) }}</span>
                                                                        </label>
                                                                    @endforeach
                                                                </div>

                                                                {{-- Input field only when a shade is selected --}}
                                                                <template x-if="selectedShade">
                                                                    <div class="mt-3">
                                                                        <label
                                                                            class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
                                                                            Enter Option for <span
                                                                                x-text="selectedShade"></span>
                                                                        </label>
                                                                        <input type="text" x-model="optionText"
                                                                               name="option_text"
                                                                               placeholder="e.g., Option A"
                                                                               class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring focus:ring-blue-200">
                                                                    </div>
                                                                </template>

                                                                <div class="mt-4 flex justify-end gap-2">
                                                                    <button type="button" @click="open = false"
                                                                            class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">
                                                                        Cancel
                                                                    </button>
                                                                    <button type="submit"
                                                                            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
                                                                            @click="$refs.finalShade.value = selectedShade + ' - ' + optionText">
                                                                        Save
                                                                    </button>
                                                                </div>

                                                                {{-- Hidden input to hold final value --}}
                                                                <input type="hidden" name="final_shade"
                                                                       x-ref="finalShade">
                                                            </form>
                                                        </div>
                                                    </div>
                                                @else
                                                    {{-- Single shade: show as readonly --}}
                                                    <span class="readonly">{{ $catalog->shade }}</span>
                                                @endif
                                            </td>

                                            <td
                                                class="px-4 py-3 w-32 whitespace-normal break-words border-r border-gray-300">
                                                <span class="readonly">{{ $catalog->tkt }}</span>
                                                <input
                                                    class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                    value="{{ $catalog->tkt }}"/>
                                            </td>
                                            <td class="px-4 py-3 w-32 whitespace-normal break-words border-r border-gray-300">
                                                <span class="readonly">
                                                    {{ $catalog->supplier }}
                                                    @if($catalog->supplier === 'Pan Asia')
                                                        <br>
                                                        <small
                                                            class="text-gray-600 dark:text-gray-300">PST No: {{ $catalog->pst_no }}</small>
                                                    @endif
                                                </span>

                                                <div x-data="{ open: false }">
                                                    <!-- Button -->
                                                    <button
                                                        type="button"
                                                        @click="open = true"
                                                        class="mt-1 bg-yellow-600 hover:bg-yellow-700 text-white px-2 py-1 rounded text-sm transition">
                                                        Supplier Comment
                                                    </button>

                                                    <!-- Modal -->
                                                    <div
                                                        x-show="open"
                                                        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
                                                        x-cloak>

                                                        <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full">
                                                            <h2 class="text-lg font-semibold mb-4">Supplier Comment</h2>
                                                            <p class="text-gray-700">
                                                                {{ $catalog->supplierComment }}
                                                            </p>

                                                            <div class="mt-6 flex justify-end">
                                                                <button
                                                                    @click="open = false"
                                                                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded transition">
                                                                    Close
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <input
                                                    class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                    value="{{ $catalog->supplier }}"/>
                                            </td>

                                            <!-- Approval Section -->
                                            <!-- Approval Section -->
                                            <td colspan="2" class="px-4 py-3 border-r border-gray-300 text-left">
                                                @if (in_array($userRole, ['SUPERADMIN', 'SAMPLEDEVELOPER', 'CUSTOMERCOORDINATOR']))
                                                    {{-- Editable form for permitted roles --}}
                                                    <form
                                                        action="{{ route('product-catalog.updateApproval', $catalog->id) }}"
                                                        method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PATCH')

                                                        {{-- Approved By --}}
                                                        @if (!$catalog->is_approved_by_locked)
                                                            <input type="text" name="approved_by"
                                                                   value="{{ old('approved_by', $catalog->approved_by) }}"
                                                                   class="w-full mb-2 px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                                   placeholder="Approved By" required>
                                                        @else
                                                            <div class="mb-2 text-sm">
                                                                <strong>Approved By:</strong>
                                                                {{ $catalog->approved_by ?? '-' }}
                                                            </div>
                                                        @endif

                                                        {{-- Approval Card --}}
                                                        @if (!$catalog->is_approval_card_locked)
                                                            <input type="file" name="approval_card"
                                                                   accept="image/*"
                                                                   class="w-full mb-2 text-sm dark:text-white dark:bg-gray-700">
                                                        @elseif ($catalog->approval_card)
                                                            <div class="mb-2">
                                                                <strong>Approval Card:</strong>
                                                                <a href="{{ asset('storage/' . $catalog->approval_card) }}"
                                                                   target="_blank"
                                                                   class="inline-block px-3 py-1 rounded text-sm bg-green-600 hover:bg-green-700 text-white transition">
                                                                    View
                                                                </a>
                                                            </div>
                                                        @else
                                                            <div class="text-sm text-red-500 mb-2">
                                                                <strong>Approval Card:</strong> No Image
                                                            </div>
                                                        @endif

                                                        {{-- Show Save button only if at least one field is unlocked --}}
                                                        @if (!$catalog->is_approved_by_locked || !$catalog->is_approval_card_locked)
                                                            <button type="submit"
                                                                    class="w-full px-3 py-1 rounded text-sm transition-all duration-200 bg-blue-600 hover:bg-blue-700 text-white">
                                                                Save
                                                            </button>
                                                        @endif
                                                    </form>
                                                @else
                                                    {{-- View-only for unauthorized roles --}}
                                                    <div class="text-sm mb-2">
                                                        <strong>Approved By:</strong>
                                                        {{ $catalog->approved_by ?? '-' }}
                                                    </div>

                                                    @if ($catalog->approval_card)
                                                        <div>
                                                            <strong>Approval Card:</strong>
                                                            <a href="{{ asset('storage/' . $catalog->approval_card) }}"
                                                               target="_blank"
                                                               class="inline-block px-3 py-1 rounded text-sm bg-green-600 hover:bg-green-700 text-white transition">
                                                                View
                                                            </a>
                                                        </div>
                                                    @else
                                                        <div class="text-sm text-red-500">
                                                            <strong>Approval Card:</strong> No Image
                                                        </div>
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="py-6 flex justify-center">
                                {{ $catalogs->links() }}
                            </div>

                            <div id="addCodeCatalogModal"
                                 class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center py-5">
                                <div
                                    class="w-full max-w-[700px] bg-white dark:bg-gray-900 rounded-2xl shadow-2xl p-4 transform transition-all scale-95 max-h-[calc(100vh-10rem)] overflow-y-auto"
                                    onclick="event.stopPropagation()">
                                    <div class="max-w-[600px] mx-auto p-8">
                                        <h2
                                            class="text-2xl font-semibold mb-8 text-blue-900 mt-4 dark:text-gray-100 text-center">
                                            Add New Cord Catalog Item
                                        </h2>
                                        <form action="{{ route('codeCatalog.store') }}" method="POST"
                                              enctype="multipart/form-data">
                                            @csrf
                                            <div class="space-y-4">
                                                <div class="flex gap-4">
                                                    <div class="w-1/2">
                                                        <label for="order_no"
                                                               class="block text-sm font-medium text-gray-700 dark:text-gray-300">Order
                                                            Number</label>
                                                        <input id="order_no" type="text" name="order_no" required
                                                               class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm mb-4">
                                                    </div>
                                                    <div class="w-1/2">
                                                        <label for="reference_no"
                                                               class="block text-sm font-medium text-gray-700 dark:text-gray-300">Reference
                                                            No</label>
                                                        <input id="reference_no" type="text" name="reference_no"
                                                               required
                                                               class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                    </div>
                                                </div>

                                                <div class="flex gap-4">
                                                    <div class="w-1/2">
                                                        <label for="reference_added_date"
                                                               class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date</label>
                                                        <input id="reference_added_date" type="date"
                                                               name="reference_added_date" required
                                                               class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                    </div>
                                                    <div class="w-1/2">
                                                        <label for="coordinator_name"
                                                               class="block text-sm font-medium text-gray-700 dark:text-gray-300">Customer
                                                            Coordinator</label>
                                                        <input id="coordinator_name" type="text"
                                                               name="coordinator_name" required
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
                                                        <label for="colour"
                                                               class="block text-sm font-medium text-gray-700 dark:text-gray-300">Colour</label>
                                                        <input id="colour" type="text" name="colour" required
                                                               class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                    </div>
                                                </div>

                                                <div class="flex gap-4">
                                                    <div class="w-1/2">
                                                        <label for="shade"
                                                               class="block text-sm font-medium text-gray-700 dark:text-gray-300">Shade</label>
                                                        <input id="shade" type="text" name="shade" required
                                                               class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                    </div>
                                                    <div class="w-1/2">
                                                        <label for="tkt"
                                                               class="block text-sm font-medium text-gray-700 dark:text-gray-300">TKT</label>
                                                        <input id="tkt" type="text" name="tkt" required
                                                               class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                    </div>
                                                </div>

                                                <div class="flex gap-4">
                                                    <div class="w-1/2">
                                                        <label for="supplier"
                                                               class="block text-sm font-medium text-gray-700 dark:text-gray-300">Supplier</label>
                                                        <input id="supplier" type="text" name="supplier" required
                                                               class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                    </div>
                                                    <div class="w-1/2">
                                                        <label for="tkt"
                                                               class="block text-sm font-medium text-gray-700 dark:text-gray-300">PST
                                                            No</label>
                                                        <input id="pst_no" type="text" name="pst_no"
                                                               class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Buttons -->
                                            <div class="flex justify-end gap-3 mt-12">
                                                <button type="button"
                                                        onclick="document.getElementById('addCodeCatalogModal').classList.add('hidden')"
                                                        class="px-4 py-2 bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-200 text-sm rounded hover:bg-gray-300">
                                                    Cancel
                                                </button>
                                                <button type="submit" id="createCodeBtn"
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
    function toggleDropdown(type) {
        closeAllDropdowns();
        const dropdownMenu = document.getElementById(`${type}DropdownMenu`);
        if (dropdownMenu) dropdownMenu.classList.toggle('hidden');
    }

    function selectOption(type, value) {
        const inputId = `${type}Input`;
        const labelId = `selected${capitalize(type)}`;
        const input = document.getElementById(inputId);
        const label = document.getElementById(labelId);

        input.value = value;
        label.textContent = value || `Select ${formatLabel(type)}`;

        document.getElementById(`${type}DropdownMenu`).classList.add('hidden');
    }

    function filterOptions(type) {
        const input = document.getElementById(`${type}SearchInput`);
        const filter = input.value.toLowerCase();
        document.querySelectorAll(`.${type}-option`).forEach(option => {
            option.style.display = option.textContent.toLowerCase().includes(filter) ? '' : 'none';
        });
    }

    document.getElementById('clearFiltersBtn').addEventListener('click', function () {
        // Reload the page to clear all filters and reset state
        window.location.href = window.location.pathname;
    });

    function closeAllDropdowns() {
        ['orderNo', 'merchandiser', 'referenceNo'].forEach(type => {
            const dropdown = document.getElementById(`${type}DropdownMenu`);
            if (dropdown) dropdown.classList.add('hidden');
        });
    }

    function capitalize(str) {
        return str.charAt(0).toUpperCase() + str.slice(1);
    }

    function formatLabel(key) {
        if (key === 'orderNo') return 'Order No';
        if (key === 'merchandiser') return 'Merchandiser';
        if (key === 'referenceNo') return 'Reference No';
        return key;
    }

    document.addEventListener('click', function (e) {
        if (!e.target.closest('.dropdown-group')) {
            closeAllDropdowns();
        }
    });
</script>

<script>
    function editRow(rowId) {
        const row = document.getElementById(rowId);
        row.querySelectorAll('.readonly').forEach(span => span.classList.add('hidden'));
        row.querySelectorAll('.editable').forEach(input => input.classList.remove('hidden'));
        row.querySelector('button.bg-green-600').classList.add('hidden'); // Hide Edit button
        row.querySelector('button.bg-blue-600').classList.remove('hidden'); // Show Save button
    }

    function saveRow(rowId) {
        const row = document.getElementById(rowId);
        const inputs = row.querySelectorAll('.editable');
        const spans = row.querySelectorAll('.readonly');

        inputs.forEach((input, i) => {
            spans[i].textContent = input.value;
            input.classList.add('hidden');
        });
        spans.forEach(span => span.classList.remove('hidden'));

        row.querySelector('button.bg-green-600').classList.remove('hidden'); // Show Edit button
        row.querySelector('button.bg-blue-600').classList.add('hidden'); // Hide Save button
    }
</script>
<script>
    function handleOrderNoClick(id, hasImage) {
        if (hasImage) {
            // Toggle image visibility
            const preview = document.getElementById('imagePreview-' + id);
            if (preview) {
                preview.classList.toggle('hidden');
            }
        } else {
            // No image — open file picker
            document.getElementById('file-upload-' + id).click();
        }
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.querySelector('#addCodeCatalogModal form');
        const submitBtn = document.getElementById('createCodeBtn');

        form.addEventListener('submit', function () {
            // Disable the button to prevent multiple clicks
            submitBtn.disabled = true;
            submitBtn.innerText = 'Submitting...';
        });
    });
</script>
@endsection
