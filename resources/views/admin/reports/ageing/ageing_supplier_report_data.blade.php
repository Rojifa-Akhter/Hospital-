@php
    $report_data = $report_data ?? []; // যদি report_data না থাকে, empty array হিসেবে set হবে
@endphp

<table class="table table-bordered table-striped mb-0 data-table">
    <thead>
        <tr class="bg-light-blue">
            <th >Supplier</th>
            <th class="text-right">1-30 Days</th>
            <th class="text-right">31-60 Days</th>
            <th class="text-right">61-90 Days</th>
            <th class="text-right">91-120 Days</th>
            <th class="text-right">121-150 Days</th>
            <th class="text-right">151-180 Days</th>
            <th class="text-right">181-210 Days</th>
            <th class="text-right">211-360 Days</th>
            <th class="text-right">> 360 Days</th>
            <th class="text-right">Total</th>
        </tr>
    </thead>
    <tbody>
        @if (!empty($report_data))
            @php
                $grandTotal = [
                    'f1to30' => 0,
                    'f31to60' => 0,
                    'f61to90' => 0,
                    'f91to120' => 0,
                    'f121to150' => 0,
                    'f151to180' => 0,
                    'f181to210' => 0,
                    'f211to360' => 0,
                    'f360' => 0,
                ];
            @endphp
            @foreach ($report_data as $row)
                @php
                    $rowTotal =
                        $row->f1to30 +
                        $row->f31to60 +
                        $row->f61to90 +
                        $row->f91to120 +
                        $row->f121to150 +
                        $row->f151to180 +
                        $row->f181to210 +
                        $row->f211to360 +
                        $row->f360;
                    foreach ($grandTotal as $key => $val) {
                        $grandTotal[$key] += $row->$key;
                    }
                @endphp
                <tr>
                    <td class="text-left">{{ $row->sup_name }}</td>
                    <td class="text-right">{{ number_format($row->f1to30) }}</td>
                    <td class="text-right">{{ number_format($row->f31to60) }}</td>
                    <td class="text-right">{{ number_format($row->f61to90) }}</td>
                    <td class="text-right">{{ number_format($row->f91to120) }}</td>
                    <td class="text-right">{{ number_format($row->f121to150) }}</td>
                    <td class="text-right">{{ number_format($row->f151to180) }}</td>
                    <td class="text-right">{{ number_format($row->f181to210) }}</td>
                    <td class="text-right">{{ number_format($row->f211to360) }}</td>
                    <td class="text-right">{{ number_format($row->f360) }}</td>
                    <td class="text-right bg-light-gray"><strong>{{ number_format($rowTotal) }}</strong></td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="11" class="text-center">No data available</td>
            </tr>
        @endif
    </tbody>
    @if (!empty($report_data))
        <tfoot class="bg-light-blue">
            @php $overallTotal = array_sum($grandTotal); @endphp
            <tr>
                <th class="text-right">Grand Total =</th>
                @foreach ($grandTotal as $val)
                    <th class="text-right">{{ number_format($val) }}</th>
                @endforeach
                <th class="text-right">{{ number_format($overallTotal) }}</th>
            </tr>
        </tfoot>
    @endif
</table>
