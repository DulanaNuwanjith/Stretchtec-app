<div class="flex h-full w-full font-sans">
    @include('layouts.side-bar')
    <div class="flex-1 overflow-y-auto p-8 bg-white dark:bg-gray-900">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold text-gray-800 dark:text-white">Reports Genarator</h2>
        </div>

        <form action="{{ route('report.order') }}" method="GET">
            @csrf
            <label for="order_no">Enter Order Number:</label>
            <input type="text" name="order_no" id="order_no" required>
            <button type="submit">Generate Report</button>
        </form>


    </div>
</div>
