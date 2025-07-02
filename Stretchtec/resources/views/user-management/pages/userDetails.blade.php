@extends('layouts.add-user-tabs')

@section('content')
    {{-- <div class="flex-1 overflow-y-auto">
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
                            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">User Details
                            </h1>
                            <button onclick="document.getElementById('addNewUserModal').classList.remove('hidden')"
                                class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded shadow">
                                + Add New User
                            </button>
                        </div>

                        <div class="overflow-x-auto bg-white dark:bg-gray-900 shadow rounded-lg">
                            <table class="table-fixed w-full text-sm divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-100 dark:bg-gray-700 text-left">
                                    <tr>
                                        <th
                                            class="px-4 py-3 w-24 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                            User ID</th>
                                        <th
                                            class="px-4 py-3 w-40 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                            Name</th>
                                        <th
                                            class="px-4 py-3 w-36 text-xs font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                            Email</th>
                                        <th
                                            class="px-4 py-3 w-48 text-xs text-center font-medium text-gray-600 dark:text-gray-300 uppercase whitespace-normal break-words">
                                            Action</th>
                                    </tr>
                                </thead>
                                <tbody id="serviceRecords"
                                    class="bg-white dark:bg-gray-800 divide-y text-left divide-gray-200 dark:divide-gray-700">
                                    <tr id="row1">
                                        <!-- Each cell has a span for readonly text and a hidden input for editing -->
                                        <td class="px-4 py-3 w-24 whitespace-normal break-words">
                                            <span class="readonly">1880</span>
                                            <input
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="1880" />
                                        </td>
                                        <td class="px-4 py-3 w-40 whitespace-normal break-words">
                                            <span class="readonly">Dulana Nuwanjith</span>
                                            <input type="text"
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="Dulana Nuwanjith" />
                                        </td>
                                        <td class="px-4 py-3 w-32 whitespace-normal break-words">
                                            <span class="readonly">dulana69@gmail.com</span>
                                            <input type="email"
                                                class="hidden editable w-full mt-1 px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white text-sm"
                                                value="dulana69@gmail.com" />
                                        </td>
                                        </td>
                                        <td class="px-4 py-3 w-48 text-center whitespace-normal break-words">
                                            <div class="flex space-x-2 justify-center">
                                                <button
                                                    class="bg-green-600 h-10 hover:bg-green-700 text-white px-3 py-1 rounded text-sm"
                                                    onclick="editRow('row1')">Edit</button>
                                                <button
                                                    class="bg-blue-600 h-10 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm hidden"
                                                    onclick="saveRow('row1')">Save</button>
                                                <button
                                                    class="bg-red-600 h-10 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">Delete</button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="py-6 flex justify-center">

                            </div>
                        </div>
                        <!-- Add Product Modal -->
                        <div id="addNewUserModal"
                            class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center py-5">
                            <div class="w-full max-w-[700px] bg-white dark:bg-gray-900 rounded-2xl shadow-2xl p-4 transform transition-all scale-95 max-h-[calc(100vh-10rem)] overflow-y-auto"
                                onclick="event.stopPropagation()">
                                <div class="max-w-[600px] mx-auto p-6">
                                    <h2
                                        class="text-2xl font-semibold mb-8 text-blue-900 mt-4 dark:text-gray-100 text-center">
                                        Add New User
                                    </h2>
                                    <x-validation-errors class="mb-10" />

                                    <form method="POST" action="{{ route('register') }}">
                                        @csrf

                                        <div>
                                            <x-label for="name" value="{{ __('Name') }}" />
                                            <x-input id="name" class="block mt-1 w-full h-10 p-4" type="text"
                                                name="name" :value="old('name')" required autofocus autocomplete="name" />
                                        </div>

                                        <div class="mt-4">
                                            <x-label for="email" value="{{ __('Email') }}" />
                                            <x-input id="email" class="block mt-1 w-full h-10 p-4" type="email"
                                                name="email" :value="old('email')" required autocomplete="username" />
                                        </div>

                                        <div class="mt-4">
                                            <x-label for="password" value="{{ __('Password') }}" />
                                            <div class="relative mb-2">
                                                <input id="password" type="password" name="password" required
                                                    autocomplete="new-password"
                                                    class="block mt-1 w-full h-10 p-4 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" />
                                                <button type="button" onclick="togglePassword()"
                                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-600 hover:text-blue-600">
                                                    <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.955 9.955 0 012.188-3.368M6.72 6.72A9.964 9.964 0 0112 5c4.477 0 8.267 2.943 9.541 7a9.966 9.966 0 01-4.292 5.222M15 12a3 3 0 00-4.243-2.828M9.878 9.878a3 3 0 004.243 4.243M3 3l18 18" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="mt-4">
                                            <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                                            <x-input id="password_confirmation" class="block mt-1 w-full h-10 p-4"
                                                type="password" name="password_confirmation" required
                                                autocomplete="new-password" />
                                        </div>

                                        @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                                            <div class="mt-4">
                                                <x-label for="terms">
                                                    <div class="flex items-center">
                                                        <x-checkbox name="terms" id="terms" required />

                                                        <div class="ms-2">
                                                            {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                                                'terms_of_service' =>
                                                                    '<a target="_blank" href="' .
                                                                    route('terms.show') .
                                                                    '" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">' .
                                                                    __('Terms of Service') .
                                                                    '</a>',
                                                                'privacy_policy' =>
                                                                    '<a target="_blank" href="' .
                                                                    route('policy.show') .
                                                                    '" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">' .
                                                                    __('Privacy Policy') .
                                                                    '</a>',
                                                            ]) !!}
                                                        </div>
                                                    </div>
                                                </x-label>
                                            </div>
                                        @endif

                                        <div class="flex items-center justify-end mt-10">
                                            <button type="button"
                                                onclick="document.getElementById('addNewUserModal').classList.add('hidden')"
                                                class="px-4 py-2 bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-200 text-sm rounded hover:bg-gray-300">
                                                Cancel
                                            </button>
                                            <x-button class="ms-4">
                                                {{ __('Register') }}
                                            </x-button>
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
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.innerHTML = `
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
      `;
        } else {
            passwordInput.type = 'password';
            eyeIcon.innerHTML = `
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.955 9.955 0 012.188-3.368M6.72 6.72A9.964 9.964 0 0112 5c4.477 0 8.267 2.943 9.541 7a9.966 9.966 0 01-4.292 5.222M15 12a3 3 0 00-4.243-2.828M9.878 9.878a3 3 0 004.243 4.243M3 3l18 18" />
      `;
        }
    }
</script> --}}
@endsection
