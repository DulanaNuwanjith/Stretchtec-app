<script src="//unpkg.com/alpinejs" defer></script>

<div x-data="{ tab: 'page1' }" class="flex h-full w-full">

    @include('layouts.side-bar')

    <div class="flex-1 overflow-y-auto p-4 relative bg-white dark:bg-gray-900">
        
        <!-- Fixed Tabs Header -->
        <div class="sticky top-0 z-10 flex space-x-4 border-b border-gray-300 bg-white p-4 dark:bg-gray-800">
            <button
                @click="tab = 'page1'"
                :class="tab === 'page1' ? 'border-b-2 border-blue-500 text-blue-600' : 'text-gray-600'"
                class="pb-2 px-3 font-semibold">
                Inquery Details
            </button>
            <button
                @click="tab = 'page2'"
                :class="tab === 'page2' ? 'border-b-2 border-blue-500 text-blue-600' : 'text-gray-600'"
                class="pb-2 px-3 font-semibold">
                Sample Preparation R & D
            </button>
            <button
                @click="tab = 'page3'"
                :class="tab === 'page3' ? 'border-b-2 border-blue-500 text-blue-600' : 'text-gray-600'"
                class="pb-2 px-3 font-semibold">
                Sample Preparation Production
            </button>
        </div>

        <!-- Tabs Content with padding top to avoid overlap -->
        <div class="pt-4 px-4">
            <div x-show="tab === 'page1'">
                @include('sample-development.pages.inquery-details')
            </div>
            <div x-show="tab === 'page2'" x-cloak>
                @include('sample-development.pages.sample-preparation-details')
            </div>
            <div x-show="tab === 'page3'">
                @include('sample-development.pages.sample-preparation-production')
            </div>
        </div>
    </div>
</div>

