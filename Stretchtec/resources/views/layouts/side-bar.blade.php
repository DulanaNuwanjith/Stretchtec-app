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

<body class="flex h-screen bg-gray-100">

    <!-- Sidebar -->
    <aside class="w-64 bg-gradient-to-b from-white to-blue-600 min-h-screen shadow-md flex flex-col">
        <!-- Logo -->
        <div class="flex items-center p-4 text-xl font-bold text-gray-700 border-b mb-4 mt-4">
            <a href="{{ route('dashboard') }}">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-18 w-60 mr-2" />
            </a>
        </div>

        <!-- Navigation -->
        <nav class="flex flex-col justify-between flex-1 p-3 text-base font-bold text-blue-900">
            <!-- Menu Items -->
            @php
                $role = auth()->user()->role;
            @endphp

            <ul class="space-y-2">
                <li>
                    <a class="flex items-centerc bg-white px-4 py-2 rounded">
                        <span>ORDER MANAGEMENT</span>
                    </a>
                </li>

                {{-- Always visible --}}
                <li>
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center px-4 py-2 rounded hover:bg-gray-200 {{ request()->routeIs('dashboard') ? 'bg-gray-200' : '' }}">
                        <img src="{{ asset('icons/statisctics.png') }}" alt="Dashboard" class="w-6 h-6 mr-5" />
                        <span>Dashboard</span>
                    </a>
                </li>

                <li>
                    @php
                        $userRole = Auth::user()->role;
                        if (
                            $userRole === 'SUPERADMIN' ||
                            $userRole === 'ADMIN' ||
                            $userRole === 'CUSTOMERCOORDINATOR'
                        ) {
                            $route = route('sample-inquery-details.index');
                        } elseif (
                            $userRole === 'SUPERADMIN' ||
                            $userRole === 'ADMIN' ||
                            $userRole === 'SAMPLEDEVELOPER'
                        ) {
                            $route = route('sample-preparation-details.index');
                        } elseif (
                            $userRole === 'SUPERADMIN' ||
                            $userRole === 'ADMIN' ||
                            $userRole === 'PRODUCTIONOFFICER'
                        ) {
                            $route = route('sample-preparation-production.index');
                        } else {
                            $route = route('sampleStock.index'); // fallback link for other roles
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
                              )
                                  ? 'bg-gray-200'
                                  : '' }}">
                        <img src="{{ asset('icons/research.png') }}" alt="" class="w-6 h-6 mr-5" />
                        <span>Sample Development</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('elasticCatalog.index') }}"
                        class="flex items-center px-4 py-2 rounded hover:bg-gray-200 {{ request()->routeIs('elasticCatalog.*', 'codeCatalog.*', 'tapeCatalog.*') ? 'bg-gray-200' : '' }}">
                        <img src="{{ asset('icons/catalog.png') }}" alt="" class="w-6 h-6 mr-5" />
                        <span>Product Catalog</span>
                    </a>
                </li>


                {{-- Only for admin and superadmin --}}
                @if (in_array($role, ['ADMIN', 'SUPERADMIN']))
                    <li>
                        <a href="{{ route('production-inquery-details.index') }}"
                            class="flex items-center px-4 py-2 rounded hover:bg-gray-200 {{ request()->routeIs('production-inquery-details.*', 'production-order-preparation.*') ? 'bg-gray-200' : '' }}">
                            <img src="{{ asset('icons/factory.png') }}" alt="" class="w-6 h-6 mr-5" />
                            <span>Production</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('storeManagement.index') }}"
                            class="flex items-center px-4 py-2 rounded hover:bg-gray-200 {{ request()->routeIs('storeManagement.*') ? 'bg-gray-200' : '' }}">
                            <img src="{{ asset('icons/inventory.png') }}" alt="" class="w-6 h-6 mr-5" />
                            <span>Store Management</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('reports.index') }}"
                            class="flex items-center px-4 py-2 rounded hover:bg-gray-200 {{ request()->routeIs('reports.*') ? 'bg-gray-200' : '' }}">
                            <img src="{{ asset('icons/report.png') }}" alt="" class="w-6 h-6 mr-5" />
                            <span>Reports</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('operatorsandSupervisors.index') }}"
                            class="flex items-center px-4 py-2 rounded hover:bg-gray-200 {{ request()->routeIs('operatorsandSupervisors.*', 'userDetails.*') ? 'bg-gray-200' : '' }}">
                            <img src="{{ asset('icons/man.png') }}" alt="" class="w-6 h-6 mr-5" />
                            <span>Add Users</span>
                        </a>
                    </li>
                @endif
            </ul>

            <!-- Profile and Logout as Sidebar Buttons -->
            <ul class="space-y-2 border-t pt-4 mt-4">
                <li>
                    <a href="{{ route('profile.show') }}"
                        class="flex items-center px-4 py-2 rounded hover:bg-gray-200 {{ request()->routeIs('profile.edit') ? 'bg-gray-200' : '' }}">
                        <img src="{{ asset('icons/employee.png') }}" alt="Profile Icon" class="w-6 h-6 mr-5" />
                        <span>Profile</span>
                    </a>
                </li>

                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full flex items-center px-4 py-2 rounded hover:bg-gray-200 text-left text-blue-900">
                            <img src="{{ asset('icons/close.png') }}" alt="Logout Icon" class="w-6 h-6 mr-5" />
                            <span>Logout</span>
                        </button>
                    </form>
                </li>
            </ul>
        </nav>
    </aside>

</body>

</html>
