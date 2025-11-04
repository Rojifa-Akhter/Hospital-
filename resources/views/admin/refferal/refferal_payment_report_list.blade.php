<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<table class="table data-table table-bordered table-hover table-striped">
    <thead class="bg-primary">
        <tr>
            <th class="text-center">SL#</th>
            <th class="text-left">Date</th>
            <th class="text-left">Ref Code</th>
            <th class="text-left">Referral Name</th>
            <th class="text-left">1st Referral Name</th>
            <th class="text-left">2nd Referral Name</th>
            <th class="text-left">Invoice</th>
            <th class="text-left">Invoice Date</th>
            <th class="text-left">Patient Name </th>
            <th class="text-right">Invoice amount </th>
            <th class="text-right">Discount </th>
            <th class="text-right">Referral Amount </th>
            <th class="text-right"> 1st Referral Amount </th>
            <th class="text-right"> 2nd Referral Amount </th>
            <th class="text-right"> Referral Paid amount </th>

        </tr>

    </thead>
    <tbody>

        @if (!empty($doctor_income))
            @php
                $invoice_amt = 0;
                $discount = 0;
                $ref_amt = 0;
                $first_ref_amt = 0;
                $second_ref_amt = 0;
                $paid_amt = 0;

                $sl = 1;
            @endphp

            @foreach ($doctor_income as $data)
                <tr>
                    <td class="text-center">{{ $sl++ }}</td>
                    <td class="text-left">
                        {{ $data->invoice_date != '' ? date('d/m/Y', strtotime($data->invoice_date)) : '' }}</td>
                    <td class="text-left"></td>
                    <td class="text-left">
                        @if ($data->ref0_referral_payable_ind == 1)
                            {{ $data->doctor_name }}
                        @endif
                    </td>
                    <td class="text-left">
                        @if ($data->ref1_referral_payable_ind == 1)
                            {{ $data->first_ref_doc_name }}
                        @endif
                    </td>
                    <td class="text-left">
                        @if ($data->ref2_referral_payable_ind == 1)
                            {{ $data->sec_ref_doc_name }}
                        @endif
                    </td>
                    <td class="text-left">{{ $data->invoice_no_pk }}</td>
                    <td class="text-left">
                        {{ $data->invoice_date != '' ? date('d/m/Y', strtotime($data->invoice_date)) : '' }}</td>

                    <td class="text-left">{{ $data->patient_name }}</td>
                    <td class="text-right">{{ number_format($data->invoicemst_amt_sales, 2) ?? 0 }}</td>
                    <td class="text-right">{{ number_format($data->invoicemst_amt_discount, 2) ?? 0 }}</td>
                    <td class="text-right">{{ number_format($data->referral_amount_doc, 2) ?? 0 }}</td>
                    <td class="text-right">{{ number_format($data->referral_amount_first, 2) ?? 0 }}</td>
                    <td class="text-right">{{ number_format($data->referral_amount_second, 2) ?? 0 }}</td>
                    <td class="text-right">{{ number_format($data->referral_amt, 2) }}</td>
                </tr>
                @php
                    $invoice_amt += $data->invoicemst_amt_sales;
                    $discount += $data->invoicemst_amt_discount;
                    $ref_amt += $data->referral_amount_doc;
                    $first_ref_amt += $data->referral_amount_first;
                    $second_ref_amt += $data->referral_amount_second;
                    $paid_amt += $data->referral_amt;

                @endphp
            @endforeach

            <tr>
                <td class="text-right" colspan="9"> <strong> Total</strong></td>
                <td class="text-right"> <strong> {{ number_format($invoice_amt, 2) }}</strong></td>
                <td class="text-right"> <strong> {{ number_format($discount, 2) }}</strong></td>
                <td class="text-right"> <strong> {{ number_format($ref_amt, 2) }}</strong></td>
                <td class="text-right"> <strong> {{ number_format($first_ref_amt, 2) }}</strong></td>
                <td class="text-right"> <strong> {{ number_format($second_ref_amt, 2) }}</strong></td>
                <td class="text-right"> <strong> {{ number_format($paid_amt, 2) }}</strong></td>

            </tr>
        @endif
    </tbody>
</table>


<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>
<script>
    $('.data-table').DataTable({
        "lengthMenu": [
            [50],
            [50]
        ],
        "ordering": false,
        "bPaginate": false,
        "bLengthChange": false,
        "bAutoWidth": false
    });
</script>
