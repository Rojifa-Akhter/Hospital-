<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<table class="table data-table table-bordered table-hover table-striped">
    <thead class="bg-primary">
        <tr>
            <th class="text-center">SL#</th>
            {{-- <th class="text-center">Invoice Date</th> --}}
            @if ($type != 'DEPT')
                <th class="text-center">Doctor Code</th>
                <th class="text-center">Doctor Name</th>
            @endif
            <th class="text-center">Department</th>

            @if ($type != 'DEPT')
                <th class="text-center">No of Patient</th>
                <th class="text-center">New Patient</th>
                <th class="text-center">Follow Up/Old Patient</th>
                <th class="text-center">Free Patient</th>
            @else
                <th class="text-center">No of Services</th>
            @endif
            <th class="text-center">Total Fee</th>
            <th class="text-center">Discount</th>
            <th class="text-center">Net Payable</th>
            <th class="text-center">Paid</th>
            @if ($type != 'DEPT')
                <th class="text-center">Due / Refund</th>
            @endif
            @if (!empty($po_hospital_details->hospital_code) == 'GMC')
                @if ($type == 'DEPT')
                    <th class="text-center">Action</th>
                @endif
            @endif
        </tr>

    </thead>
    <tbody>

        @if (!empty($doctorPerformanceSummary))
            @php
                $ledger_amt_sales = 0;
                $ledger_amt_discount = 0;
                $ledger_amt_payment = 0;
                $total_referral_amount = 0;
                $total_discount_amt_by_hos = 0;
                $total_discount_amt_by_doc = 0;
                $grand_total_referral_amount = 0;
                $ledger_amt_payment = 0;
                $net_payable = 0;
                $due = 0;
                $net_total_referral_amount = 0;
                $number_of_patient = 0;
                $total_new_patient = 0;
                $total_free_patient = 0;
                $total_followup_patient = 0;
            @endphp

{{-- @dd($doctorPerformanceSummary); --}}

            @foreach ($doctorPerformanceSummary as $data)
                @php

                    $ledger_amt_sales += $data->ledger_amt_sales;
                    //$total_referral_amount += 0; //$data->referral_amount;
                    $total_discount_amt_by_hos += $data->ledger_amt_discount;
                    $ledger_amt_payment += $data->ledger_amt_payment;
                    $net_payable = $data->ledger_amt_sales - $data->ledger_amt_discount;
                    $grand_total_referral_amount += $net_payable;

                    $due = $net_payable - $data->ledger_amt_payment;
                    $net_total_referral_amount += $due;
                    if ($type != 'DEPT') {
                        $number_of_patient += $data->total_appoint;
                        $total_new_patient += $data->total_appoint_new;
                        $total_free_patient += $data->total_appoint_free;
                        $total_followup_patient += $data->total_appoint_followup;
                    } else {
                        $number_of_patient += $data->current_item_qty;
                    }

                @endphp

                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    {{-- <td class="text-left">{{ date('d/m/Y', strtotime($data->invoice_date)) }}</td> --}}
                    @if ($type != 'DEPT')
                        <td class="text-left">{{ $data->person_code }}</td>
                        <td class="text-left">{{ $data->doctor_name }}</td>
                    @endif
                    <td class="text-left">{{ $data->serviceunit_name }}</td>

                    @if ($type != 'DEPT')
                        <td class="text-center">{{ $data->total_appoint }}</td>
                        <td class="text-center">{{ $data->total_appoint_new }}</td>
                        <td class="text-center">{{ $data->total_appoint_followup }}</td>
                        <td class="text-center">{{ $data->total_appoint_free }}</td>
                    @else
                        <td class="text-center">{{ $data->current_item_qty }}</td>
                    @endif


                    <td class="text-right">{{ number_format($data->ledger_amt_sales, 2) }}</td>
                    <td class="text-right">{{ number_format($data->ledger_amt_discount, 2) }}</td>
                    <td class="text-right">{{ number_format($net_payable, 2) }}</td>
                    <td class="text-right">{{ number_format($data->ledger_amt_payment, 2) }}</td>
                    @if ($type != 'DEPT')
                        <td class="text-right">
                            @if ($due < 0)
                                ({{ number_format(abs($due), 2) }})
                            @else
                                {{ number_format($due, 2) }}
                            @endif
                        </td>
                    @endif


                    @if (!empty($po_hospital_details->hospital_code) == 'GMC')
                        @if ($type == 'DEPT')
                            <td>
                                <span class="btn btn-sm btn-success open-modal btnView"
                                    data-action="{{ route('doctor-wise-income-summary-details', [$data->serviceunit_no_fk, date('Y-m-d', strtotime($data->invoice_date)), 'DEPT']) }}"
                                    data-modal="common-modal-xl" data-title="Details">
                                    <i class="fa fa-eye"></i>
                                </span>
                            </td>
                        @endif
                    @endif
                </tr>
            @endforeach

            @if (!empty($type) != 'DEPT')
                @php $col_span = 4; @endphp
            @else
                @php $col_span = 2; @endphp
            @endif
            <tr>
                <td colspan="{{ $col_span }}" class="text-right"> <strong>Total </strong> </td>

                @if ($type != 'DEPT')
                    <td class="text-center"> <strong>{{ $number_of_patient }} </strong> </td>
                    <td class="text-center"> <strong>{{ $total_new_patient }} </strong> </td>
                    <td class="text-center"> <strong>{{ $total_followup_patient }} </strong> </td>
                    <td class="text-center"> <strong>{{ $total_free_patient }} </strong> </td>

                @else
                    <td class="text-center"> <strong>{{ $number_of_patient }} </strong> </td>
                @endif
                <td class="text-right"> <strong>{{ number_format($ledger_amt_sales, 2) }} </strong> </td>
                <td class="text-right"> <strong>{{ number_format($total_discount_amt_by_hos, 2) }} </strong>
                </td>
                <td class="text-right"> <strong>{{ number_format($grand_total_referral_amount, 2) }} </strong>
                </td>
                <td class="text-right"> <strong>{{ number_format($ledger_amt_payment, 2) }} </strong> </td>
                @if ($type != 'DEPT')
                    <td class="text-right"><strong>
                            @if ($net_total_referral_amount < 0)
                                ({{ number_format(abs($net_total_referral_amount), 2) }})
                            @else
                                {{ number_format($net_total_referral_amount, 2) }}
                            @endif

                        </strong></td>
                @endif


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
