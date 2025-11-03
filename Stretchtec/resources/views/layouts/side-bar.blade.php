@php use Illuminate\Support\Facades\Auth; @endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>StretchTec</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="flex h-screen bg-gray-100">

    @php
        $role = auth()->user()->role;
        $userRole = Auth::user()->role;
        if (in_array($userRole, ['SUPERADMIN', 'ADMIN', 'CUSTOMERCOORDINATOR'])) {
            $sampleRoute = route('sample-inquery-details.index');
        } elseif ($userRole === 'SAMPLEDEVELOPER') {
            $sampleRoute = route('sample-preparation-details.index');
        } elseif (
            in_array($userRole, [
                'PRODUCTIONOFFICER',
                'PRODUCTIONKNITTED',
                'PRODUCTIONLOOM',
                'PRODUCTIONBRAIDING',
                'PRODUCTIONASSISTANT',
            ])
        ) {
            $sampleRoute = route('sample-preparation-production.index');
        } else {
            $sampleRoute = route('sampleStock.index');
        }
    @endphp

    <script>
        const savedSidebarState = localStorage.getItem('sidebarCollapsed');
        const initialCollapsed = savedSidebarState ? JSON.parse(savedSidebarState) : false;
        window.__initialCollapsed = initialCollapsed;
        document.documentElement.style.setProperty('--sidebar-width', initialCollapsed ? '5rem' : '18rem');
    </script>

    <aside x-data="{ collapsed: window.__initialCollapsed, initialized: false }" x-init="initialized = true" :class="collapsed ? 'w-20' : 'w-72'"
        class="relative bg-gradient-to-b from-white to-blue-500 min-h-screen shadow-md flex flex-col transition-all duration-300"
        style="width: var(--sidebar-width);">

        <!-- Toggle Button (always visible) -->
        <div class="flex justify-end p-6">
            <button
                @click="collapsed = !collapsed; localStorage.setItem('sidebarCollapsed', JSON.stringify(collapsed)); document.documentElement.style.setProperty('--sidebar-width', collapsed ? '5rem' : '18rem');"
                class="bg-white border border-gray-300 rounded-full w-8 p-1 shadow hover:bg-gray-200 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-900" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        :d="collapsed ? 'M9 5l7 7-7 7' : 'M15 19l-7-7 7-7'" />
                </svg>
            </button>
        </div>

        <!-- Sidebar Header -->
        <div class="flex items-center justify-between p-4 border-b mt-4 mb-4" x-cloak>
            <a href="{{ route('dashboard') }}" :class="collapsed ? 'hidden' : 'block'">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-18 w-64" />
            </a>
        </div>

        <!-- Navigation -->
        <nav class="flex flex-col justify-between flex-1 p-3 text-base font-bold text-blue-900" x-cloak>
            <ul class="space-y-2">

                <li>
                    <a x-show="initialized && !collapsed" class="flex items-center bg-white px-4 py-2 rounded">
                        <span>ORDER MANAGEMENT</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center px-4 py-2 rounded hover:bg-gray-200 {{ request()->routeIs('dashboard') ? 'bg-gray-200' : '' }}">
                        <img src="{{ asset('icons/statisctics.png') }}" alt="Dashboard" class="w-6 h-6 mr-5" />
                        <span x-show="initialized && !collapsed">Dashboard</span>
                    </a>
                </li>

                {{-- Hide these from STOREOFFICER --}}
                @if ($role !== 'STOREOFFICER')
                    <li>
                        <a href="{{ $sampleRoute }}"
                            class="flex items-center px-4 py-2 rounded hover:bg-gray-200
                      {{ request()->routeIs('sample-inquery-details.*', 'sample-preparation-details.*', 'sample-preparation-production.*', 'sampleStock.*', 'leftoverYarn.*') ? 'bg-gray-200' : '' }}">
                            <img src="{{ asset('icons/research.png') }}" alt="" class="w-6 h-6 mr-5" />
                            <span x-show="initialized && !collapsed">Sample Development</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('elasticCatalog.index') }}"
                            class="flex items-center px-4 py-2 rounded hover:bg-gray-200
                      {{ request()->routeIs('elasticCatalog.*', 'codeCatalog.*', 'tapeCatalog.*') ? 'bg-gray-200' : '' }}">
                            <img src="{{ asset('icons/catalog.png') }}" alt="" class="w-6 h-6 mr-5" />
                            <span x-show="initialized && !collapsed">Product Catalog</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('elasticTD.index') }}"
                            class="flex items-center px-4 py-2 rounded hover:bg-gray-200
                      {{ request()->routeIs('elasticTD.*', 'cordTD.*', 'tapeTD.*') ? 'bg-gray-200' : '' }}">
                            <img src="{{ asset('icons/writing.png') }}" alt="" class="w-6 h-6 mr-5" />
                            <span x-show="initialized && !collapsed">Technical Details</span>
                        </a>
                    </li>
                @endif

                {{-- For ADMIN and SUPERADMIN --}}
                @if (in_array($role, ['ADMIN', 'SUPERADMIN']))
                    <li>
                        <a href="{{ route('production-inquery-details.index') }}"
                            class="flex items-center px-4 py-2 rounded hover:bg-gray-200
                      {{ request()->routeIs('production-inquery-details.*', 'production-order-preparation.*', 'mail-booking.*', 'mail-booking-approval.*', 'packing.*', 'knitted.*', 'loom.*', 'braiding.*') ? 'bg-gray-200' : '' }}">
                            <img src="{{ asset('icons/factory.png') }}" alt="" class="w-6 h-6 mr-5" />
                            <span x-show="initialized && !collapsed">Production</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('purchasing.index') }}"
                            class="flex items-center px-4 py-2 rounded hover:bg-gray-200
                      {{ request()->routeIs('purchasing.*') ? 'bg-gray-200' : '' }}">
                            <img src="{{ asset('icons/purchasing.png') }}" alt="" class="w-6 h-6 mr-5" />
                            <span x-show="initialized && !collapsed">Purchasing Department</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('stockAvailabilityCheck.index') }}"
                            class="flex items-center px-4 py-2 rounded hover:bg-gray-200
                      {{ request()->routeIs('stockManagement.*', 'stockAvailabilityCheck.*') ? 'bg-gray-200' : '' }}">
                            <img src="{{ asset('icons/stores.png') }}" alt="" class="w-6 h-6 mr-5" />
                            <span x-show="initialized && !collapsed">Store Management</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('sample-reports.index') }}"
                            class="flex items-center px-4 py-2 rounded hover:bg-gray-200
                      {{ request()->routeIs('sample-reports.*', 'production-reports.*') ? 'bg-gray-200' : '' }}">
                            <img src="{{ asset('icons/report.png') }}" alt="" class="w-6 h-6 mr-5" />
                            <span x-show="initialized && !collapsed">Reports</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('operatorsandSupervisors.index') }}"
                            class="flex items-center px-4 py-2 rounded hover:bg-gray-200
                      {{ request()->routeIs('operatorsandSupervisors.*', 'userDetails.*') ? 'bg-gray-200' : '' }}">
                            <img src="{{ asset('icons/man.png') }}" alt="" class="w-6 h-6 mr-5" />
                            <span x-show="initialized && !collapsed">Add Users</span>
                        </a>
                    </li>
                @endif

                {{-- For STOREOFFICER only --}}
                @if ($role === 'STOREOFFICER')
                    <li>
                        <a href="{{ route('storeManagement.index') }}"
                            class="flex items-center px-4 py-2 rounded hover:bg-gray-200
                      {{ request()->routeIs('storeManagement.*') ? 'bg-gray-200' : '' }}">
                            <img src="{{ asset('icons/inventory.png') }}" alt="" class="w-6 h-6 mr-5" />
                            <span x-show="initialized && !collapsed">Store Management</span>
                        </a>
                    </li>
                @endif

            </ul>

            <!-- Profile & Logout -->
            <ul class="space-y-2 border-t pt-4 mt-4">
                <li>
                    <a href="{{ route('profile.show') }}"
                        class="flex items-center px-4 py-2 rounded hover:bg-gray-200">
                        <img src="{{ asset('icons/employee.png') }}" alt="Profile Icon" class="w-6 h-6 mr-5" />
                        <span x-show="initialized && !collapsed">Profile</span>
                    </a>
                </li>

                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full flex items-center px-4 py-2 rounded hover:bg-gray-200 text-left text-blue-900">
                            <img src="{{ asset('icons/close.png') }}" alt="Logout Icon" class="w-6 h-6 mr-5" />
                            <span x-show="initialized && !collapsed">Logout</span>
                        </button>
                    </form>
                </li>
            </ul>
        </nav>

    </aside>

</body>

</html>
