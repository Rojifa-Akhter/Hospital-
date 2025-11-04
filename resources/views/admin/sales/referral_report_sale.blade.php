    <table class="table table-bordered">
        <thead>
            <tr>
                <th>SL#</th>
                <th>Referral ID</th>
                <th>Referral Name</th>
                <th>Branch Name</th>
                <th>Invoice Qty</th>
                <th>Sales Amt.</th>
                <th>Net Profit</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody>
            @php
                // Initialize totals for each column
                $total_invoice_qty = 0;
                $total_sales = 0;
                $total_payable_profit = 0;
            @endphp
            @if (!empty($data))
                @foreach ($data as $row)
                    <tr>
                        <!-- Individual Row Checkbox -->
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $row->referral_id ?? '' }}</td>
                        <td>{{ $row->referral_name ?? '' }}</td>
                        <td>{{ $row->branch_name ?? '' }}</td>
                        <td class="text-center">{{ number_format($row->total_invoice_qty, 0) }}</td>
                        <td class="text-right">{{ number_format($row->total_sales, 2) }}</td>

                        @php
                            $payable_profit = $row->total_doctor_profit - $row->total_doctor_discount;
                        @endphp
                        <td class="text-right">{{ number_format($payable_profit, 2) }}</td>
                        @php
                            // Accumulate totals for footer
                            $total_invoice_qty += $row->total_invoice_qty;
                            $total_sales += $row->total_sales;
                            $total_payable_profit += $payable_profit;
                        @endphp
                        <td></td>
                    </tr>
                @endforeach
            @endif
        </tbody>

        <tfoot>
            <tr>
                <td colspan="4"><strong>Total</strong></td>
                <td class="text-center">{{ number_format($total_invoice_qty, 0) }}</td>
                <td class="text-right">{{ number_format($total_sales, 2) }}</td>
                <td class="text-right">{{ number_format($total_payable_profit, 2) }}</td>
            </tr>
        </tfoot>
    </table>
