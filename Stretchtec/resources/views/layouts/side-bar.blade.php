@php use Illuminate\Support\Facades\Auth; @endphp
    <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>StretchTec</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="flex h-screen bg-gray-100"
      x-data="{ collapsed: JSON.parse(localStorage.getItem('sidebarCollapsed') || 'false') }"
      x-init="$watch('collapsed', value => localStorage.setItem('sidebarCollapsed', JSON.stringify(value)))">

<!-- Sidebar -->
<aside :class="collapsed ? 'w-20' : 'w-64'"
       class="relative bg-gradient-to-b from-white to-blue-600 min-h-screen shadow-md flex flex-col transition-all duration-300">

    <!-- Sidebar Header with Logo & Toggle -->
    <div class="flex items-center justify-between p-4 border-b mt-4 mb-4">
        <!-- Logo -->
        <a href="{{ route('dashboard') }}" :class="collapsed ? 'hidden' : ''">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-18 w-60" />
        </a>

        <!-- Toggle Button -->
        <button @click="collapsed = !collapsed"
                class="bg-white border border-gray-300 rounded-full p-1 shadow hover:bg-gray-200 transition">
            <svg x-show="!collapsed" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-900" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            <svg x-show="collapsed" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-900" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
            </svg>
        </button>
    </div>

    <!-- Navigation -->
    <nav class="flex flex-col justify-between flex-1 p-3 text-base font-bold text-blue-900">
        @php
            $role = auth()->user()->role;
        @endphp

        <ul class="space-y-2">
            <li>
                <a class="flex items-center bg-white px-4 py-2 rounded">
                    <span :class="collapsed ? 'hidden' : ''">ORDER MANAGEMENT</span>
                </a>
            </li>

            {{-- Always visible --}}
            <li>
                <a href="{{ route('dashboard') }}"
                   class="flex items-center px-4 py-2 rounded hover:bg-gray-200 {{ request()->routeIs('dashboard') ? 'bg-gray-200' : '' }}">
                    <img src="{{ asset('icons/statisctics.png') }}" alt="Dashboard" class="w-6 h-6 mr-5" />
                    <span :class="collapsed ? 'hidden' : ''">Dashboard</span>
                </a>
            </li>

            <li>
                @php
                    $userRole = Auth::user()->role;
                    if ($userRole === 'SUPERADMIN' || $userRole === 'ADMIN' || $userRole === 'CUSTOMERCOORDINATOR') {
                        $route = route('sample-inquery-details.index');
                    } elseif ($userRole === 'SAMPLEDEVELOPER') {
                        $route = route('sample-preparation-details.index');
                    } elseif ($userRole === 'PRODUCTIONOFFICER') {
                        $route = route('sample-preparation-production.index');
                    } else {
                        $route = route('sampleStock.index');
                    }
                @endphp

                <a href="{{ $route }}"
                   class="flex items-center px-4 py-2 rounded hover:bg-gray-200
                              {{ request()->routeIs(
                                  'sample-inquery-details.*',
                                  'sample-preparation-details.*',
                                  'sample-preparation-production.*',
                                  'sampleStock.*',
                                  'leftoverYarn.*',
                              ) ? 'bg-gray-200' : '' }}">
                    <img src="{{ asset('icons/research.png') }}" alt="" class="w-6 h-6 mr-5" />
                    <span :class="collapsed ? 'hidden' : ''">Sample Development</span>
                </a>
            </li>

            <li>
                <a href="{{ route('elasticCatalog.index') }}"
                   class="flex items-center px-4 py-2 rounded hover:bg-gray-200 {{ request()->routeIs('elasticCatalog.*', 'codeCatalog.*', 'tapeCatalog.*') ? 'bg-gray-200' : '' }}">
                    <img src="{{ asset('icons/catalog.png') }}" alt="" class="w-6 h-6 mr-5" />
                    <span :class="collapsed ? 'hidden' : ''">Product Catalog</span>
                </a>
            </li>

            @if (in_array($role, ['ADMIN', 'SUPERADMIN']))
                <li>
                    <a href="{{ route('production-inquery-details.index') }}"
                       class="flex items-center px-4 py-2 rounded hover:bg-gray-200 {{ request()->routeIs('production-inquery-details.*', 'production-order-preparation.*') ? 'bg-gray-200' : '' }}">
                        <img src="{{ asset('icons/factory.png') }}" alt="" class="w-6 h-6 mr-5" />
                        <span :class="collapsed ? 'hidden' : ''">Production</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('storeManagement.index') }}"
                       class="flex items-center px-4 py-2 rounded hover:bg-gray-200 {{ request()->routeIs('storeManagement.*') ? 'bg-gray-200' : '' }}">
                        <img src="{{ asset('icons/inventory.png') }}" alt="" class="w-6 h-6 mr-5" />
                        <span :class="collapsed ? 'hidden' : ''">Store Management</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('sample-reports.index') }}"
                       class="flex items-center px-4 py-2 rounded hover:bg-gray-200 {{ request()->routeIs('sample-reports.*', 'production-reports.*') ? 'bg-gray-200' : '' }}">
                        <img src="{{ asset('icons/report.png') }}" alt="" class="w-6 h-6 mr-5" />
                        <span :class="collapsed ? 'hidden' : ''">Reports</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('operatorsandSupervisors.index') }}"
                       class="flex items-center px-4 py-2 rounded hover:bg-gray-200 {{ request()->routeIs('operatorsandSupervisors.*', 'userDetails.*') ? 'bg-gray-200' : '' }}">
                        <img src="{{ asset('icons/man.png') }}" alt="" class="w-6 h-6 mr-5" />
                        <span :class="collapsed ? 'hidden' : ''">Add Users</span>
                    </a>
                </li>
            @endif
        </ul>

        <!-- Profile & Logout -->
        <ul class="space-y-2 border-t pt-4 mt-4">
            <li>
                <a href="{{ route('profile.show') }}"
                   class="flex items-center px-4 py-2 rounded hover:bg-gray-200 {{ request()->routeIs('profile.edit') ? 'bg-gray-200' : '' }}">
                    <img src="{{ asset('icons/employee.png') }}" alt="Profile Icon" class="w-6 h-6 mr-5" />
                    <span :class="collapsed ? 'hidden' : ''">Profile</span>
                </a>
            </li>

            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="w-full flex items-center px-4 py-2 rounded hover:bg-gray-200 text-left text-blue-900">
                        <img src="{{ asset('icons/close.png') }}" alt="Logout Icon" class="w-6 h-6 mr-5" />
                        <span :class="collapsed ? 'hidden' : ''">Logout</span>
                    </button>
                </form>
            </li>
        </ul>
    </nav>
</aside>

</body>
</html>
