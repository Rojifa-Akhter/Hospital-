<div class="table-responsive" style="overflow-x:auto;">
    <table class="table table-bordered table-striped mb-0 data-table">
        <thead class="thead-light">
            <tr class="bg-light-blue">
                <th style="white-space: nowrap; min-width: 120px;" class="text-left">Category</th>
                <th style="white-space: nowrap; min-width: 250px;" class="text-left">Corporate Client</th>
                <th style="white-space: nowrap; min-width: 80px;" class="text-right">1-30 |</th>
                <th style="white-space: nowrap; min-width: 80px;" class="text-right">31-60 |</th>
                <th style="white-space: nowrap; min-width: 80px;" class="text-right">61-90 |</th>
                <th style="white-space: nowrap; min-width: 80px;" class="text-right">91-120 |</th>
                <th style="white-space: nowrap; min-width: 80px;" class="text-right">121-150 |</th>
                <th style="white-space: nowrap; min-width: 80px;" class="text-right">151-180 |</th>
                <th style="white-space: nowrap; min-width: 80px;" class="text-right">181-210 |</th>
                <th style="white-space: nowrap; min-width: 80px;" class="text-right">211-365 |</th>
                <th style="white-space: nowrap; min-width: 80px;" class="text-right">&gt; 365 |</th>
                <th style="white-space: nowrap; min-width: 100px;" class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @php $grandTotal = array_fill(0, 9, 0); @endphp

            @if(!empty($report_data) && is_array($report_data))
                @forelse ($report_data as $row)
                    @php
                        $values = [
                            (float) $row->{'1-30'},
                            (float) $row->{'31-60'},
                            (float) $row->{'61-90'},
                            (float) $row->{'91-120'},
                            (float) $row->{'121-150'},
                            (float) $row->{'151-180'},
                            (float) $row->{'181-210'},
                            (float) $row->{'211-365'},
                            (float) $row->{'>365'},
                        ];
                        $categoryTotal = array_sum($values);
                        foreach ($values as $i => $v) $grandTotal[$i] += $v;
                    @endphp
                    <tr>
                        <td class="text-left">{{ $row->pat_type }}</td>
                        <td class="text-left">{{ $row->ccm_client_name ?? 'N/A' }}</td>
                        @foreach ($values as $v)
                            <td class="text-right">{{ number_format($v, 2) }}</td>
                        @endforeach
                        <td class="text-right bg-light-gray"><strong>{{ number_format($categoryTotal, 2) }}</strong></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="12" class="text-center">No data available</td>
                    </tr>
                @endforelse
            @else
                <tr>
                    <td colspan="12" class="text-center">No data available</td>
                </tr>
            @endif
        </tbody>
        <tfoot>
            <tr class="bg-light-blue">
                <th colspan="2" class="text-right"><strong>Grand Total =</strong></th>
                @php $totalSum = array_sum($grandTotal); @endphp
                @foreach ($grandTotal as $v)
                    <th class="text-right"><strong>{{ number_format($v, 2) }}</strong></th>
                @endforeach
                <th class="text-right bg-light-blue"><strong>{{ number_format($totalSum, 2) }}</strong></th>
            </tr>
        </tfoot>
    </table>
</div>
