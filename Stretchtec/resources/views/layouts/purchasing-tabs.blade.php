<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>StretchTec</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>
</head>

<body class="bg-white text-gray-900">

<div class="flex h-full w-full">

    @include('layouts.side-bar')

     <div class="flex-1 overflow-y-auto relative bg-white dark:bg-gray-900">
        <!-- ✅ TAB NAVIGATION (VISIBLE IN ALL PAGES) -->
        <div class="sticky top-0 z-50 flex space-x-4 border-b border-gray-300 bg-white p-5 dark:bg-gray-800">

                <a href="{{ route('purchasing.index') }}"
                   class="pb-2 px-3 font-semibold {{ request()->routeIs('purchasing.*') ? 'border-b-2 border-blue-500 text-blue-600' : 'text-gray-600' }}">
                    Purchase Order Processing
                </a>

                <a href="{{ route('localinvoiceManage.index') }}"
                   class="pb-2 px-3 font-semibold {{ request()->routeIs('localinvoiceManage.*') ? 'border-b-2 border-blue-500 text-blue-600' : 'text-gray-600' }}">
                    Local Procurement
                </a>

                <a href="{{ route('exportinvoiceManage.index') }}"
                   class="pb-2 px-3 font-semibold {{ request()->routeIs('exportinvoiceManage.*') ? 'border-b-2 border-blue-500 text-blue-600' : 'text-gray-600' }}">
                    Export Procurement
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
