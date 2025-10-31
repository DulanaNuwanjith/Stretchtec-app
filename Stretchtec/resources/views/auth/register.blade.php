<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo/>
        </x-slot>

        <x-validation-errors class="mb-4"/>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <x-label for="name" value="{{ __('Name') }}"/>
                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                         autofocus autocomplete="name"/>
            </div>

            <div class="mt-4">
                <x-label for="email" value="{{ __('Email') }}"/>
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                         required autocomplete="username"/>
            </div>

            <div class="mt-4">
                <x-label for="role" value="{{ __('Role') }}"/>
                <select id="role" name="role" required
                        class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                    <option value="">-- Select Role --</option>
                    <option value="ADMIN">Admin</option>
                    <option value="SUPERADMIN">Super Admin</option>
                    <option value="STOREOFFICER">Store Officer</option>
                    <option value="CUSTOMERCOORDINATOR">Customer Coordinator</option>
                    <option value="SAMPLEDEVELOPER">Sample Developers</option>
                    <option value="PRODUCTIONOFFICER">Production Officer</option>
                    <option value="PRODUCTIONASSISTANT">Production Assistant</option>
                    <option value="PRODUCTIONKNITTED">Production Knitted</option>
                    <option value="PRODUCTIONLOOM">Production Loom</option>
                    <option value="PRODUCTIONBRAIDING">Production Braiding</option>
                </select>
            </div>


            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}"/>
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required
                         autocomplete="new-password"/>
            </div>

            <div class="mt-4">
                <x-label for="password_confirmation" value="{{ __('Confirm Password') }}"/>
                <x-input id="password_confirmation" class="block mt-1 w-full" type="password"
                         name="password_confirmation" required autocomplete="new-password"/>
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-label for="terms">
                        <div class="flex items-center">
                            <x-checkbox name="terms" id="terms" required/>

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

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                   href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="ms-4">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>

{{-- This is an alternative to the registration form above, showing a message instead --}}
{{-- If you want to use this, comment out the registration form above and uncomment this section --}}

{{-- This is an alternative to the registration form above, showing a message instead --}}
{{-- If you want to use this, comment out the registration form above and uncomment this section --}}

{{-- <x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 px-4 animate-fadeIn">
        <div
            class="max-w-md w-full bg-white p-8 rounded-lg shadow-lg text-center transform transition duration-300 hover:scale-105">
            <!-- Icon: Shield Lock -->
            <div class="flex justify-center mb-6">
                <svg class="w-16 h-16 text-red-600 animate-pulse" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 11c1.104 0 2-.672 2-1.5S13.104 8 12 8s-2 .672-2 1.5.896 1.5 2 1.5z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 11v6a5 5 0 0010 0v-6"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 11v-2a7 7 0 0114 0v2"></path>
                </svg>
            </div>

            <h1 class="text-4xl font-extrabold text-red-600 mb-4">Access Denied</h1>
            <p class="text-gray-700 mb-6">
                You are not authorized to access this page.<br>
                Please contact your administrator for assistance.
            </p>

            <a href="{{ route('login') }}"
                class="inline-block px-6 py-3 bg-indigo-600 text-white font-semibold rounded-md shadow-md hover:bg-indigo-700 hover:shadow-lg transform hover:scale-105 transition duration-300 ease-in-out">
                Return to Login
            </a>
        </div>
    </div>

    <!-- Custom Tailwind animation -->
    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fadeIn {
            animation: fadeIn 0.6s ease-out forwards;
        }
    </style>
</x-guest-layout> --}}
