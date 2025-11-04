<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<table class="table data-table table-bordered table-hover table-striped">
    <thead class="bg-primary">
        <tr>
            <th class="text-center">SL#</th>
            <th class="text-center">Date</th>
            <th class="text-center">Appointment ID</th>
            <th class="text-center">Patient Info</th>

            <th class="text-center">Doctor Name</th>

            <th class="text-center">Fee</th>
            <th class="text-center">Discount</th>
            <th class="text-center">Net Payable</th>
            <th class="text-center">Paid</th>
            <th class="text-center">Due / Refund</th>
        </tr>

    </thead>
    <tbody>

        @if (!empty($referral_detail_data))
            @php
                $ledger_amt_sales = 0;
                $total_referral_amount = 0;
                $total_discount_amt_by_hos = 0;
                $total_discount_amt_by_doc = 0;
                $grand_total_referral_amount = 0;
                $ledger_amt_payment = 0;
                $net_payable = 0;
                $due = 0;
                $net_total_referral_amount = 0;
                $i = 0;
                $sl = 1;
            @endphp



            @foreach ($referral_detail_data as $data)
                @php

                    $ledger_amt_sales += $data->ledger_amt_sales;
                    $total_referral_amount += 0; //$data->referral_amount;
                    $total_discount_amt_by_hos += $data->ledger_amt_discount;
                    $ledger_amt_payment += $data->ledger_amt_payment;
                    $net_payable = $data->ledger_amt_sales - $data->ledger_amt_discount;
                    $grand_total_referral_amount += $net_payable;

                    $due = $net_payable - $data->ledger_amt_payment;
                    $net_total_referral_amount += $due;
                @endphp
                <tr>
                    <td class="text-center">{{ $sl++ }}</td>
                    <td class="text-left">{{ date('d/m/Y', strtotime($data->invoice_date)) }}</td>
                    <td class="text-left">{{ $data->appoint_service_no_fk }}</td>
                    <td class="text-left">
                        <strong>Name : </strong> {{ $data->patient_name != '' ? $data->patient_name : '' }} <br>
                        <strong>Age : </strong> {{ $data->age != '' ? $data->age : '' }} <br>
                        <strong>Gender : </strong> {{ $data->gender_txt != '' ? $data->gender_txt : '' }}
                    </td>
                    <td class="text-left"> {{ $data->doctor_name }} </td>


                    <td class="text-right">{{ number_format($data->ledger_amt_sales, 2) }}</td>
                    <td class="text-right">{{ number_format($data->ledger_amt_discount, 2) }}</td>
                    <td class="text-right">{{ number_format($net_payable, 2) }}</td>
                    <td class="text-right">{{ number_format($data->ledger_amt_payment, 2) }}</td>
                    <td class="text-right">
                        @if ($due < 0)
                        ({{ number_format(abs($due), 2) }})
                        @else
                        {{ number_format($due, 2) }}
                        @endif

                    </td>
                </tr>

            @endforeach


            @php

                $col_span = 5;

            @endphp

            <tr>
                <td colspan="{{ $col_span }}" class="text-right"> <strong>Total </strong> </td>
                <td class="text-right"> <strong>{{ number_format($ledger_amt_sales, 2) }} </strong> </td>
                <td class="text-right"> <strong>{{ number_format($total_discount_amt_by_hos, 2) }} </strong>
                </td>
                <td class="text-right"> <strong>{{ number_format($grand_total_referral_amount, 2) }} </strong>
                </td>
                <td class="text-right"> <strong>{{ number_format($ledger_amt_payment, 2) }} </strong> </td>


                <td class="text-right"><strong>
                    @if ($net_total_referral_amount < 0)
                    ({{ number_format(abs($net_total_referral_amount), 2) }})
                    @else
                    {{ number_format($net_total_referral_amount, 2) }}
                    @endif
                </strong></td>

            </tr>
        @endif
    </tbody>
</table>


<script type="application/javascript"
src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
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
