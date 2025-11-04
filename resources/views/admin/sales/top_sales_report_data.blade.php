@if ($reptype == 'MO')
    <table id="report_table" class="table table-bordered table-striped table-hover">
        <thead class="thead-dark">
            <tr>
                <th>SL#</th>
                <th>Marketing Officer ID</th>
                <th>Officer Name and Designation</th>
                <th>Invoice qty</th>
                <th>Test qty</th>
                <th>Total Sales</th>
                <th>Payment</th>
                <th>Discount</th>
                <th>Net Sales</th>
                <th>Due</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalInvoice = 0;
                $totalTest = 0;
                $totalSales = 0;
                $totalPayment = 0;
                $totalDiscount = 0;
                $totalNetSales = 0;
                $totalDue = 0;
            @endphp
            @if (!empty($reportData))

                @foreach ($reportData as $data)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $data->mkt_officer_id ?? 'N/A' }}</td>
                        <td>{{ $data->mkt_officer_name_desig ?? 'N/A' }}</td>
                        <td>{{ $data->invoice_qty ?? '0' }}</td>
                        <td>{{ $data->test_qty ?? '0' }}</td>
                        <td class="text-right">{{ number_format((float) ($data->total_sales ?? 0), 2) }}</td>
                        <td class="text-right">{{ number_format((float) ($data->payment ?? 0), 2) }}</td>
                        <!-- Fixed 'payemnt' typo -->
                        <td class="text-right">{{ number_format((float) ($data->discount ?? 0), 2) }}</td>
                        <td class="text-right">{{ number_format((float) ($data->net_sales ?? 0), 2) }}</td>
                        <td class="text-right">{{ number_format((float) ($data->due ?? 0), 2) }}</td>
                        <td>{{ $data->remarks ?? 'No issues' }}</td>
                    </tr>

                    @php
                        $totalInvoice += $data->invoice_qty ?? 0;
                        $totalTest += $data->test_qty ?? 0;
                        $totalSales += $data->total_sales ?? 0;
                        $totalPayment += $data->payment ?? 0;
                        $totalDiscount += $data->discount ?? 0;
                        $totalNetSales += $data->net_sales ?? 0;
                        $totalDue += $data->due ?? 0;
                    @endphp
                @endforeach
            @endif
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3">Total</td>
                <td>{{ $totalInvoice }}</td>
                <td>{{ $totalTest }}</td>
                <td class="text-right">{{ number_format((float) $totalSales, 2) }}</td>
                <td class="text-right">{{ number_format((float) $totalPayment, 2) }}</td>
                <td class="text-right">{{ number_format((float) $totalDiscount, 2) }}</td>
                <td class="text-right">{{ number_format((float) $totalNetSales, 2) }}</td>
                <td class="text-right">{{ number_format((float) $totalDue, 2) }}</td>
            </tr>
        </tfoot>
    </table>
@else
    <table id="report_table" class="table table-bordered table-striped table-hover">
        <thead class="thead-dark">
            <tr>
                <th>SL#</th>
                <th>Referral Name and Address</th>
                <th>Officer Name and Designation</th>
                <th>Invoice qty</th>
                <th>Test qty</th>
                <th>Total Sales</th>
                <th>Payment</th>
                <th>Discount</th>
                <th>Net Sales</th>
                <th>Due</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalInvoice = 0;
                $totalTest = 0;
                $totalSales = 0;
                $totalPayment = 0;
                $totalDiscount = 0;
                $totalNetSales = 0;
                $totalDue = 0;
            @endphp
            @if (!empty($reportData))
                @foreach ($reportData as $data)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $data->referral_name ?? 'N/A' }}-{{ $data->referral_addr ?? 'N/A' }}</td>
                        <td>{{ $data->mkt_officer_id ?? 'N/A' }}-{{ $data->mkt_officer_name_desig ?? 'N/A' }}</td>
                        <td>{{ $data->invoice_qty ?? '0' }}</td>
                        <td>{{ $data->test_qty ?? '0' }}</td>
                        <td class="text-right">{{ number_format((float) ($data->total_sales ?? 0), 2) }}</td>
                        <td class="text-right">{{ number_format((float) ($data->payment ?? 0), 2) }}</td>
                        <!-- Fixed 'payemnt' typo -->
                        <td class="text-right">{{ number_format((float) ($data->discount ?? 0), 2) }}</td>
                        <td class="text-right">{{ number_format((float) ($data->net_sales ?? 0), 2) }}</td>
                        <td class="text-right">{{ number_format((float) ($data->due ?? 0), 2) }}</td>
                        <td>{{ $data->remarks ?? 'No issues' }}</td>
                    </tr>

                    @php
                        $totalInvoice += $data->invoice_qty ?? 0;
                        $totalTest += $data->test_qty ?? 0;
                        $totalSales += $data->total_sales ?? 0;
                        $totalPayment += $data->payment ?? 0;
                        $totalDiscount += $data->discount ?? 0;
                        $totalNetSales += $data->net_sales ?? 0;
                        $totalDue += $data->due ?? 0;
                    @endphp
                @endforeach
            @endif
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3">Total</td>
                <td>{{ $totalInvoice }}</td>
                <td>{{ $totalTest }}</td>
                <td class="text-right">{{ number_format((float) $totalSales, 2) }}</td>
                <td class="text-right">{{ number_format((float) $totalPayment, 2) }}</td>
                <td class="text-right">{{ number_format((float) $totalDiscount, 2) }}</td>
                <td class="text-right">{{ number_format((float) $totalNetSales, 2) }}</td>
                <td class="text-right">{{ number_format((float) $totalDue, 2) }}</td>
            </tr>
        </tfoot>
    </table>
@endif
