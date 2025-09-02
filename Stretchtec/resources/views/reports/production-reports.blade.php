<head>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<div class="flex h-full w-full">
    @extends('layouts.reports')

    @section('content')
        <div class="flex h-full w-full bg-white">
            <div class="flex-1 overflow-y-auto p-8">
                <!-- Header -->
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-800 dark:text-white">Production Reports Generator</h2>
                </div>


            </div>
        </div>

</div>
@endsection
