<x-form-section submit="updatePassword">
    <!-- Title -->
    <x-slot name="title">
        {{ __('Update Password') }}
    </x-slot>

    <!-- Description -->
    <x-slot name="description">
        {{ __('Ensure your account is using a long, random password to stay secure.') }}
    </x-slot>

    <!-- Form Fields -->
    <x-slot name="form">
        <!-- Current Password -->
        <div class="col-span-6 sm:col-span-6 md:col-span-4">
            <x-label for="current_password" value="{{ __('Current Password') }}" />
            <x-input id="current_password" type="password"
                     class="mt-1 block w-full px-4 py-2 rounded-xl shadow-sm border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-sm focus:ring-amber-500 focus:border-amber-500"
                     wire:model="state.current_password"
                     autocomplete="current-password" />
            <x-input-error for="current_password" class="mt-2" />
        </div>

        <!-- New Password -->
        <div class="col-span-6 sm:col-span-6 md:col-span-4">
            <x-label for="password" value="{{ __('New Password') }}" />
            <x-input id="password" type="password"
                     class="mt-1 block w-full px-4 py-2 rounded-xl shadow-sm border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-sm focus:ring-amber-500 focus:border-amber-500"
                     wire:model="state.password"
                     autocomplete="new-password" />
            <x-input-error for="password" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="col-span-6 sm:col-span-6 md:col-span-4">
            <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
            <x-input id="password_confirmation" type="password"
                     class="mt-1 block w-full px-4 py-2 rounded-xl shadow-sm border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-sm focus:ring-amber-500 focus:border-amber-500"
                     wire:model="state.password_confirmation"
                     autocomplete="new-password" />
            <x-input-error for="password_confirmation" class="mt-2" />
        </div>
    </x-slot>

    <!-- Actions -->
    <x-slot name="actions">
        <x-action-message class="me-3 text-sm text-green-600 dark:text-green-400" on="saved">
            {{ __('Saved.') }}
        </x-action-message>

        <x-button class="rounded-xl px-6 py-2 text-sm font-semibold shadow-md">
            {{ __('Save') }}
        </x-button>
    </x-slot>
</x-form-section>
