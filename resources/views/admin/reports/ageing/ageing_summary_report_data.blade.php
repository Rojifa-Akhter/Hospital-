<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">

<table class="table table-bordered table-striped mb-0 data-table">
    <thead>
        <tr class="bg-light-blue">
            <th class="text-center">Category</th>
            <th class="text-right">1-30 Days</th>
            <th class="text-right">31-60 Days</th>
            <th class="text-right">61-90 Days</th>
            <th class="text-right">91-120 Days</th>
            <th class="text-right">121-150 Days</th>
            <th class="text-right">151-180 Days</th>
            <th class="text-right">181-210 Days</th>
            <th class="text-right">211-365 Days</th>
            <th class="text-right">> 365 Days</th>
            <th class="text-right">Total</th>
        </tr>
    </thead>

    <tbody>
        @php
            $grandTotal = [
                '1-30' => 0,
                '31-60' => 0,
                '61-90' => 0,
                '91-120' => 0,
                '121-150' => 0,
                '151-180' => 0,
                '181-210' => 0,
                '211-365' => 0,
                '>365' => 0,
            ];
        @endphp

        @if (!empty($report_data) && count($report_data) > 0)
            @foreach ($report_data as $row)
                @php
                    // Calculate category total
                    $categoryTotal =
                        $row->{'1-30'} +
                        $row->{'31-60'} +
                        $row->{'61-90'} +
                        $row->{'91-120'} +
                        $row->{'121-150'} +
                        $row->{'151-180'} +
                        $row->{'181-210'} +
                        $row->{'211-365'} +
                        $row->{'>365'};

                    // Add to grand total
                    foreach ($grandTotal as $key => $val) {
                        $grandTotal[$key] += $row->{$key};
                    }
                @endphp

                <tr>
                    <td class="text-left"><strong>{{ $row->pat_type }}</strong></td>
                    <td class="text-right">{{ number_format($row->{'1-30'}) }}</td>
                    <td class="text-right">{{ number_format($row->{'31-60'}) }}</td>
                    <td class="text-right">{{ number_format($row->{'61-90'}) }}</td>
                    <td class="text-right">{{ number_format($row->{'91-120'}) }}</td>
                    <td class="text-right">{{ number_format($row->{'121-150'}) }}</td>
                    <td class="text-right">{{ number_format($row->{'151-180'}) }}</td>
                    <td class="text-right">{{ number_format($row->{'181-210'}) }}</td>
                    <td class="text-right">{{ number_format($row->{'211-365'}) }}</td>
                    <td class="text-right">{{ number_format($row->{'>365'}) }}</td>
                    <td class="text-right bg-light-gray"><strong>{{ number_format($categoryTotal) }}</strong></td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="11" class="text-center">No data available</td>
            </tr>
        @endif
    </tbody>

    <tfoot>
        @php $totalSum = array_sum($grandTotal); @endphp
        <tr class="bg-light-blue text-center">
            <th class="text-right"><strong>Grand Total =</strong></th>
            @foreach ($grandTotal as $value)
                <th><strong>{{ number_format($value) }}</strong></th>
            @endforeach
            <th><strong>{{ number_format($totalSum) }}</strong></th>
        </tr>
    </tfoot>
</table>

<script type="application/javascript">
$(function() {
    $('.data-table').DataTable({
        "paging": false,
        "searching": false,
        "ordering": false,
        "info": false
    });
});
</script>
