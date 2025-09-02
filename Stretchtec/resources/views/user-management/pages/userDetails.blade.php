@extends('layouts.add-user-tabs')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
                            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">User Details
                            </h1>
                        </div>

                        <div class="overflow-x-auto bg-white dark:bg-gray-900 shadow rounded-lg">
                            <table class="table-fixed w-full text-sm divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-100 dark:bg-gray-700 text-left">
                                <tr>
                                    <th
                                        class="px-4 py-3 w-24 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                        User ID
                                    </th>
                                    <th
                                        class="px-4 py-3 w-40 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                        Name
                                    </th>
                                    <th
                                        class="px-4 py-3 w-40 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                        Role
                                    </th>
                                    <th
                                        class="px-4 py-3 w-36 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                        Email
                                    </th>
                                    <th
                                        class="px-4 py-3 w-48 text-xs text-center font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                        Action
                                    </th>
                                </tr>
                                </thead>
                                <tbody id="serviceRecords"
                                       class="bg-white dark:bg-gray-800 divide-y text-left divide-gray-200 dark:divide-gray-700">

                                @foreach ($users as $index => $user)
                                    @php
                                        $rowId = 'row' . ($index + 1);
                                    @endphp
                                    <tr id="{{ $rowId }}">
                                        <td class="px-4 py-3 w-24 whitespace-normal break-words">
                                            <span class="readonly">{{ $user->id }}</span>
                                            <input
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="{{ $user->id }}"/>
                                        </td>
                                        <td class="px-4 py-3 w-40 whitespace-normal break-words">
                                            <span class="readonly">{{ $user->name }}</span>
                                            <input type="text"
                                                   class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                   value="{{ $user->name }}"/>
                                        </td>
                                        <td class="px-4 py-3 w-40 whitespace-normal break-words">
                                                <span class="readonly">
                                                    {{ $user->role ?? 'N/A' }}
                                                </span>
                                            <input type="text"
                                                   class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                   value="{{ $user->role ?? 'N/A' }}"/>
                                        </td>
                                        <td class="px-4 py-3 w-32 whitespace-normal break-words">
                                            <span class="readonly">{{ $user->email }}</span>
                                            <input type="email"
                                                   class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                   value="{{ $user->email }}"/>
                                        </td>
                                        <td class="px-4 py-3 w-48 text-center whitespace-normal break-words">
                                            <div class="flex space-x-2 justify-center">
                                                <form id="delete-form-{{ $user->id }}"
                                                      action="{{ route('userDetails.destroy', $user->id) }}"
                                                      method="POST" class="inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button"
                                                            onclick="confirmDelete('{{ $user->id }}')"
                                                            class="bg-red-600 h-10 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach

                                @if ($users->isEmpty())
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-red-500">No users found.</td>
                                    </tr>
                                @endif
                                </tbody>

                            </table>
                        </div>
                        <div class="py-6 flex justify-center">
                            {{ $users->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const clearFiltersBtn = document.getElementById('clearFiltersBtn');
            const selectedVehicle = document.getElementById('selectedVehicle');
            const filterForm = document.getElementById('filterForm');

            clearFiltersBtn.addEventListener('click', () => {
                // Clear values
                document.getElementById('customerInput').value = '';
                document.getElementById('merchandiserInput').value = '';
                document.getElementById('itemInput').value = '';

                document.getElementById('selectedCustomer').textContent = 'Select Sample No';
                document.getElementById('selectedMerchandiser').textContent = 'Select Merchandiser';
                document.getElementById('selectedItem').textContent = 'Select Item';

                // Submit the form
                filterForm.submit();
            });

        });
    </script>

    <script>
        function toggleDropdown(type) {
            const menu = document.getElementById(`${type}DropdownMenu`);
            const btn = document.getElementById(`${type}Dropdown`);
            const expanded = btn.getAttribute('aria-expanded') === 'true';
            menu.classList.toggle('hidden');
            btn.setAttribute('aria-expanded', !expanded);
        }

        function selectOption(type, value) {
            const displayText = value || `Select ${type.charAt(0).toUpperCase() + type.slice(1)}`;
            document.getElementById(`selected${capitalize(type)}`).innerText = value || `All ${capitalize(type)}s`;
            document.getElementById(`${type}Input`).value = value;
            document.getElementById(`${type}DropdownMenu`).classList.add('hidden');
            document.getElementById(`${type}Dropdown`).setAttribute('aria-expanded', false);
        }

        function filterOptions(type) {
            const input = document.getElementById(`${type}SearchInput`).value.toLowerCase();
            const options = document.querySelectorAll(`.${type}-option`);
            options.forEach(option => {
                const text = option.textContent.toLowerCase();
                option.style.display = text.includes(input) ? 'block' : 'none';
            });
        }

        function capitalize(str) {
            return str.charAt(0).toUpperCase() + str.slice(1);
        }

        // Close dropdowns on outside click
        document.addEventListener('click', function (e) {
            ['item', 'customer', 'merchandiser'].forEach(type => {
                const btn = document.getElementById(`${type}Dropdown`);
                const menu = document.getElementById(`${type}DropdownMenu`);
                if (!btn.contains(e.target) && !menu.contains(e.target)) {
                    menu.classList.add('hidden');
                    btn.setAttribute('aria-expanded', false);
                }
            });
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
@endsection
