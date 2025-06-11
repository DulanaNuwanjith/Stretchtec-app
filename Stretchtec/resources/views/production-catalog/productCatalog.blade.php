<script src="//unpkg.com/alpinejs" defer></script>

<div x-data="{ tab: 'page1' }" class="flex h-full w-full">

    @include('layouts.side-bar')

    <div class="flex-1 overflow-y-auto p-4  bg-white ">

        <div class="flex justify-between items-center mb-4 p-4">
            <h2 class="text-3xl font-bold text-gray-800 dark:text-white">Production Catalog</h2>
            <button onclick="document.getElementById('').classList.remove('hidden')"
                class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded shadow">
                + Add New Item
            </button>
        </div>

        <!-- Tabs Header -->
        <div class="flex space-x-4 border-b border-gray-300 mb-4 bg-white p-4  dark:bg-gray-800 overflow-hidden  ">
            <button @click="tab = 'page1'"
                :class="tab === 'page1' ? 'border-b-2 border-blue-500 text-blue-600' : 'text-gray-600'"
                class="pb-2 px-3 font-semibold">
                Elastics
            </button>
            <button @click="tab = 'page2'"
                :class="tab === 'page2' ? 'border-b-2 border-blue-500 text-blue-600' : 'text-gray-600'"
                class="pb-2 px-3 font-semibold">
                Tapes
            </button>
            <button @click="tab = 'page3'"
                :class="tab === 'page3' ? 'border-b-2 border-blue-500 text-blue-600' : 'text-gray-600'"
                class="pb-2 px-3 font-semibold">
                Codes
            </button>
        </div>

        <!-- Tabs Content -->
        <div x-show="tab === 'page1'">
            @include('production-catalog.pages.elasticCatalog')
        </div>
        <div x-show="tab === 'page2'" x-cloak>
            @include('production-catalog.pages.tapeCatalog')
        </div>
        <div x-show="tab === 'page3'">
            @include('production-catalog.pages.codeCatalog')
        </div>
    </div>
</div>
