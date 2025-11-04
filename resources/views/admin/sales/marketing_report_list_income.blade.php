<table class="table table-bordered table-striped mb-0 data-table">
    <thead class="sticky_header">
        <tr class="bg-light-blue">
            <th class="text-center">SL#</th>
            {{-- <th class="text-center">Invoice Date</th> --}}
            <th class="text-center">UHID</th>
            <th class="text-center">Admission ID</th>
            <th class="text-center">Patient Name</th>
            <th class="text-center">Department</th>
            <th class="text-center">Sales</th>
            <th class="text-center">Sales Cancel</th>
            <th class="text-center">Discount</th>
            <th class="text-center">Discount Refund</th>
            <th class="text-center">Collection</th>
            <th class="text-center">Refund</th>
            <th class="text-center">Net Collection</th>
        </tr>
    </thead>
    <tbody>
        @php
            $total_sales = 0;
            $total_salescancel = 0;
            $total_discount = 0;
            $total_discount_refund = 0;
            $total_payment = 0;
            $total_refund = 0;
            $total_net_collection = 0;

        @endphp
        @if (!empty($data))


            @foreach ($data as $value)
                <tr>
                    <td class="text-right">{{ $loop->iteration }}</td>
                    {{-- <td class="text-left">
                        {{ date('d/m/y', strtotime($value->ledger_date)) }}
                    </td> --}}
                    <td class="text-center">{{ $value->patient_code }}</td>
                    <td class="text-center">{{ $value->admission_no_pk }}</td>
                    <td class="text-left">{{ $value->patient_name }}</td>
                    <td class="text-left">{{ $value->department }}</td>
                    <td class="text-right">{{ number_format($value->sales, 2) }}</td>
                    <td class="text-right">{{ number_format($value->salescancel, 2) }}</td>
                    <td class="text-right">{{ number_format($value->discount, 2) }}</td>
                    <td class="text-right">{{ number_format($value->discount_refund, 2) }}</td>
                    <td class="text-right">{{ number_format($value->payment, 2) }}</td>
                    <td class="text-right">{{ number_format($value->refund, 2) }}</td>
                    <td class="text-right">{{ number_format($value->payment - $value->refund, 2) }}</td>
                    <!-- You can calculate Total if needed -->

                    @php
                        $total_sales += $value->sales;
                        $total_salescancel += $value->salescancel;
                        $total_discount += $value->discount;
                        $total_discount_refund += $value->discount_refund;
                        $total_payment += $value->payment;
                        $total_refund += $value->refund;
                        $total_net_collection += $value->payment - $value->refund;
                    @endphp
                </tr>
            @endforeach
        @endif
    </tbody>
    <tfoot>
        <tr class="bg-light-blue">
            <td class="text-right" colspan="5"><strong>Total</strong></td>
            <td class="text-right">{{ number_format($total_sales, 2) }}</td>
            <td class="text-right">{{ number_format($total_salescancel, 2) }}</td>
            <td class="text-right">{{ number_format($total_discount, 2) }}</td>
            <td class="text-right">{{ number_format($total_discount_refund, 2) }}</td>
            <td class="text-right">{{ number_format($total_payment, 2) }}</td>
            <td class="text-right">{{ number_format($total_refund, 2) }}</td>
            <td class="text-right">{{ number_format($total_net_collection, 2) }}</td>
        </tr>
    </tfoot>
</table>
