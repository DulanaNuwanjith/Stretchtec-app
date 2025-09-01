<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>StretchTec</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-white text-gray-900">

<div class="flex h-full w-full">

    @include('layouts.side-bar')

    <div class="flex-1 overflow-y-auto relative bg-white dark:bg-gray-900">

        <!-- ✅ TAB NAVIGATION (VISIBLE IN ALL PAGES) -->
        <div class="sticky top-0 z-10 flex space-x-4 border-b border-gray-300 bg-white p-5 dark:bg-gray-800">
            <a href="{{ route('sample-reports.index') }}"
               class="pb-2 px-3 font-semibold {{ request()->routeIs('sample-reports.index') ? 'border-b-2 border-blue-500 text-blue-600' : 'text-gray-600' }}">
                Sample Production Reports
            </a>
            <a href="{{ route('production-reports.index') }}"
               class="pb-2 px-3 font-semibold {{ request()->routeIs('production-reports.*') ? 'border-b-2 border-blue-500 text-blue-600' : 'text-gray-600' }}">
                Production Reports
            </a>
        </div>

        <!-- ✅ PAGE CONTENT -->
        <div class="pt-4 px-4">
            @yield('content')
        </div>
    </div>
</div>

</body>

</html>
