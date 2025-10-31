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

            @if (in_array($role, ['ADMIN', 'SUPERADMIN', 'PRODUCTIONOFFICER','SAMPLEDEVELOPER', 'PRODUCTIONKNITTED', 'PRODUCTIONASSISTANT']))
                <a href="{{ route('elasticTD.index') }}"
                   class="pb-2 px-3 font-semibold {{ request()->routeIs('elasticTD.*') ? 'border-b-2 border-blue-500 text-blue-600' : 'text-gray-600' }}">
                    Elastic Technical Details
                </a>
            @endif

            @if (in_array($role, ['ADMIN', 'SUPERADMIN', 'PRODUCTIONOFFICER','SAMPLEDEVELOPER', 'PRODUCTIONBRAIDING', 'PRODUCTIONASSISTANT']))
                <a href="{{ route('cordTD.index') }}"
                   class="pb-2 px-3 font-semibold {{ request()->routeIs('cordTD.*') ? 'border-b-2 border-blue-500 text-blue-600' : 'text-gray-600' }}">
                    Cord Technical Details
                </a>
            @endif

            @if (in_array($role, ['ADMIN', 'SUPERADMIN', 'PRODUCTIONOFFICER','SAMPLEDEVELOPER', 'PRODUCTIONLOOM','PRODUCTIONASSISTANT']))
                <a href="{{ route('tapeTD.index') }}"
                   class="pb-2 px-3 font-semibold {{ request()->routeIs('tapeTD.*') ? 'border-b-2 border-blue-500 text-blue-600' : 'text-gray-600' }}">
                    Twill Tape Technical Details
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
