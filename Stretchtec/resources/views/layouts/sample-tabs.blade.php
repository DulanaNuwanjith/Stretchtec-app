<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>StretchTec</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-white text-gray-900">

@php
    use Illuminate\Support\Facades\Auth;

    $role = Auth::user()->role;
@endphp

<div class="flex h-full w-full">
    @include('layouts.side-bar')

    <div class="flex-1 overflow-y-auto relative bg-white dark:bg-gray-900">
        <!-- ✅ TAB NAVIGATION (VISIBLE IN ALL PAGES) -->
        <div class="sticky top-0 z-50 flex space-x-4 border-b border-gray-300 bg-white p-5 dark:bg-gray-800">
            {{-- Inquiry Details Tab: visible to Customer Coordinator, Admin, Superadmin --}}
            @if (in_array($role, ['CUSTOMERCOORDINATOR', 'ADMIN', 'SUPERADMIN']))
                <a href="{{ route('sample-inquery-details.index') }}"
                   class="pb-2 px-3 font-semibold {{ request()->routeIs('sample-inquery-details.*') ? 'border-b-2 border-blue-500 text-blue-600' : 'text-gray-600' }}">
                    Inquiry Details
                </a>
            @endif

            {{-- Sample Preparation R&D Tab: visible to Sample Developers, Admin, Superadmin --}}
            @if (in_array($role, ['SAMPLEDEVELOPER', 'ADMIN', 'SUPERADMIN', 'PRODUCTIONOFFICER']))
                <a href="{{ route('sample-preparation-details.index') }}"
                   class="pb-2 px-3 font-semibold {{ request()->routeIs('sample-preparation-details.*') ? 'border-b-2 border-blue-500 text-blue-600' : 'text-gray-600' }}">
                    Research & Development
                </a>
            @endif

            {{-- Sample Preparation Production Tab: visible to Production Officer, Admin, Superadmin --}}
            @if (in_array($role, ['PRODUCTIONOFFICER', 'ADMIN', 'SUPERADMIN']))
                <a href="{{ route('sample-preparation-production.index') }}"
                   class="pb-2 px-3 font-semibold {{ request()->routeIs('sample-preparation-production.*') ? 'border-b-2 border-blue-500 text-blue-600' : 'text-gray-600' }}">
                    Sample Production Development
                </a>
            @endif
        </div>

        <!-- ✅ PAGE CONTENT -->
        <div class="pt-4 px-4">
            @yield('content')
        </div>
    </div>
</div>


</body>

</html>
