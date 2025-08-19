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
                            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Operators & Supervisors Details
                            </h1>
                            <button
                                onclick="document.getElementById('addNewOperatorSupervisorModal').classList.remove('hidden')"
                                class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded shadow">
                                + Add New Operator or Supervisor
                            </button>
                        </div>

                        <div class="overflow-x-auto bg-white dark:bg-gray-900 shadow rounded-lg">
                            <table class="table-fixed w-full text-sm divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-100 dark:bg-gray-700 text-left">
                                    <tr>
                                        <th
                                            class="px-4 py-3 w-24 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                            EMP ID</th>
                                        <th
                                            class="px-4 py-3 w-40 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                            Name</th>
                                        <th
                                            class="px-4 py-3 w-40 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                            Responsible Role</th>
                                        <th
                                            class="px-4 py-3 w-36 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                            Telephone No</th>
                                        <th
                                            class="px-4 py-3 w-48 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                            Address</th>
                                        <th
                                            class="px-4 py-3 w-48 text-xs text-center font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                            Action</th>
                                    </tr>
                                </thead>
                                <tbody id="serviceRecords"
                                    class="bg-white dark:bg-gray-800 divide-y text-left divide-gray-200 dark:divide-gray-700">

                                    @foreach ($operatorsAndSupervisors as $index => $operator)
                                        @php
                                            $rowId = 'row' . ($index + 1);
                                        @endphp
                                        <tr id="{{ $rowId }}">
                                            <td class="px-4 py-3 whitespace-normal break-words">
                                                <span class="readonly">{{ $operator->empID }}</span>
                                                <input
                                                    class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                    value="{{ $operator->empID }}" />
                                            </td>
                                            <td class="px-4 py-3 whitespace-normal break-words">
                                                <span class="readonly">{{ $operator->name }}</span>
                                                <input type="text"
                                                    class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                    value="{{ $operator->name }}" />
                                            </td>
                                            <td class="px-4 py-3 whitespace-normal break-words">
                                                <span class="readonly">{{ ucfirst($operator->role) }}</span>
                                                <input type="text"
                                                    class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                    value="{{ $operator->role }}" />
                                            </td>
                                            <td class="px-4 py-3 whitespace-normal break-words">
                                                <span class="readonly">{{ $operator->phoneNo }}</span>
                                                <input type="email"
                                                    class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                    value="{{ $operator->phoneNo }}" />
                                            </td>
                                            <td class="px-4 py-3 whitespace-normal break-words">
                                                <span class="readonly">{{ $operator->address }}</span>
                                                <input type="text"
                                                    class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                    value="{{ $operator->address }}" />
                                            </td>
                                            <td class="px-4 py-3 w-48 text-center whitespace-normal break-words">
                                                <div class="flex space-x-2 justify-center">
                                                    <form id="delete-form-{{ $operator->id }}"
                                                        action="{{ route('operatorsandSupervisors.destroy', $operator->id) }}"
                                                        method="POST" class="inline-block">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button"
                                                            onclick="confirmDelete('{{ $operator->id }}')"
                                                            class="bg-red-600 h-10 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">
                                                            Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>
                        <div class="py-6 flex justify-center">
                            {{ $operatorsAndSupervisors->links() }}
                        </div>

                        <div id="addNewOperatorSupervisorModal"
                            class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center py-5">
                            <div class="w-full max-w-[700px] bg-white dark:bg-gray-900 rounded-2xl shadow-2xl p-4 transform transition-all scale-95 max-h-[calc(100vh-10rem)] overflow-y-auto"
                                onclick="event.stopPropagation()">
                                <div class="max-w-[600px] mx-auto p-6">
                                    <h2
                                        class="text-2xl font-semibold mb-8 text-blue-900 mt-4 dark:text-gray-100 text-center">
                                        Add New Operator or Supervisor
                                    </h2>
                                    <form action="{{ route('operatorsandSupervisors.store') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="space-y-4">

                                            <div class="flex gap-4">
                                                <div class="w-1/2">
                                                    <label for="empID"
                                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">EMP
                                                        ID</label>
                                                    <input id="empID" type="text" name="empID" required
                                                        class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                </div>

                                                <div class="w-1/2">
                                                    <label for="name"
                                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                                                    <input id="name" type="text" name="name" required
                                                        class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                </div>
                                            </div>

                                            <div class="flex gap-4">
                                                <div class="w-1/2">
                                                    <label for="phoneNo"
                                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Telephone
                                                        No</label>
                                                    <input id="phoneNo" type="text" name="phoneNo" required
                                                        pattern="\d{10}" maxlength="10"
                                                        title="Enter a 10-digit phone number"
                                                        class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm">
                                                </div>

                                                <div class="w-1/2 relative" data-dropdown-root>
                                                    <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                                        Responsible Role
                                                    </label>

                                                    <input type="hidden" name="role" required>

                                                    <button type="button"
                                                            onclick="toggleDropdownItemAdd(this)"
                                                            class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm flex justify-between items-center">
                                                        <span class="selected-item text-gray-700 dark:text-white">-- Select Role --</span>
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="none"
                                                             viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                  d="M19 9l-7 7-7-7" />
                                                        </svg>
                                                    </button>

                                                    <div class="dropdown-menu-item hidden absolute left-0 top-full mt-1 w-full rounded-md bg-white dark:bg-gray-700 shadow-lg ring-1 ring-black/5 max-h-48 overflow-y-auto z-10">
                                                        <div class="py-1" role="listbox" tabindex="-1">
                                                            <button type="button"
                                                                    class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-600"
                                                                    onclick="selectDropdownOptionItemAdd(this, 'OPERATOR')">Operator</button>
                                                            <button type="button"
                                                                    class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-600"
                                                                    onclick="selectDropdownOptionItemAdd(this, 'SUPERVISOR')">Supervisor</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                                <div>
                                                <label for="address"
                                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Address</label>
                                                <input id="address" type="text" name="address" required
                                                    class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm mb-4">
                                            </div>
                                        </div>

                                        <!-- Buttons -->
                                        <div class="flex justify-end gap-3 mt-12">
                                            <button type="button"
                                                onclick="document.getElementById('addNewOperatorSupervisorModal').classList.add('hidden')"
                                                class="px-4 py-2 bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-200 text-sm rounded hover:bg-gray-300">
                                                Cancel
                                            </button>
                                            <button type="submit"
                                                class="px-4 py-2 bg-blue-500 text-white text-sm rounded hover:bg-blue-600">
                                                Create
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
        document.addEventListener('click', function(e) {
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

    <script>
        function toggleDropdownItemAdd(button) {
            const root = button.closest('[data-dropdown-root]');
            const dropdownMenu = root.querySelector('.dropdown-menu-item');

            // Close all other open dropdowns
            document.querySelectorAll('.dropdown-menu-item').forEach(menu => {
                if (menu !== dropdownMenu) menu.classList.add('hidden');
            });

            dropdownMenu.classList.toggle('hidden');
        }

        function selectDropdownOptionItemAdd(button, selectedValue) {
            const root = button.closest('[data-dropdown-root]');

            // Update visible text
            const displaySpan = root.querySelector('.selected-item');
            displaySpan.innerText = selectedValue;

            // Update hidden input for backend submission
            const hiddenInput = root.querySelector('input[type="hidden"]');
            hiddenInput.value = selectedValue;

            // Close dropdown
            const dropdownMenu = root.querySelector('.dropdown-menu-item');
            dropdownMenu.classList.add('hidden');
        }

        // Click outside closes dropdown
        document.addEventListener('click', function(event) {
            document.querySelectorAll('.dropdown-menu-item').forEach(menu => {
                const root = menu.closest('[data-dropdown-root]');
                if (!root.contains(event.target)) {
                    menu.classList.add('hidden');
                }
            });
        });
    </script>

@endsection
