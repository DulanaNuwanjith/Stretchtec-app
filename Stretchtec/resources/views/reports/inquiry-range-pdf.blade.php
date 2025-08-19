<h2 style="text-align:center">Sample Delivary Report ({{ $start_date }} to {{ $end_date }})</h2>

<h3>Not Delivered Inquiries</h3>
<table border="1" cellpadding="5" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>Order No</th>
            <th>Customer</th>
            <th>Customer Coordinator</th>
            <th>Customer Decision</th>
        </tr>
    </thead>
    <tbody>
        @forelse($notDelivered as $inquiry)
            <tr>
                <td>{{ $inquiry->orderNo }}</td>
                <td>{{ $inquiry->customerName }}</td>
                <td>{{ $inquiry->coordinatorName }}</td>
                <td>{{ $inquiry->customerDecision }}</td>
            </tr>
        @empty
            <tr><td colspan="4" style="text-align:center">No records found</td></tr>
        @endforelse
    </tbody>
</table>

<h3 style="margin-top:30px">Delivered Inquiries</h3>
<table border="1" cellpadding="5" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>Order No</th>
            <th>Customer</th>
            <th>Customer Coordinator</th>
            <th>Customer Decision</th>
        </tr>
    </thead>
    <tbody>
        @forelse($needToDeliver as $inquiry)
            <tr>
                <td>{{ $inquiry->orderNo }}</td>
                <td>{{ $inquiry->customerName }}</td>
                <td>{{ $inquiry->coordinatorName }}</td>
                <td>{{ $inquiry->customerDecision }}</td>
            </tr>
        @empty
            <tr><td colspan="4" style="text-align:center">No records found</td></tr>
        @endforelse
    </tbody>
</table>
