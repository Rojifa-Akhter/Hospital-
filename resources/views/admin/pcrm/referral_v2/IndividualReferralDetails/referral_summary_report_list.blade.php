<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<table class="table data-table table-bordered table-hover table-striped">
    <thead class="bg-primary">
        <tr>
            <th class="text-center">SL#</th>
            {{-- <th class="text-center">Invoice No</th> --}}
            <th class="text-center">Doctor Code</th>
            <th class="text-center">Doctor Name & Degree</th>
            <th class="text-center">Num.Inv</th>
            <th class="text-center">Total sale</th>
            <th class="text-center">Collection</th>
            <th class="text-center">Discount</th>
            <th class="text-center">Total Ref. Amt.</th>
            <th class="text-center">Net Ref. Amt.</th>
        </tr>

    </thead>
    <tbody>

        @if (isset($referral_arr))
            @php
                $ledger_amt_sales = 0;
                $total_referral_amount = 0;
                $total_discount_amt_by_hos = 0;
                $total_discount_amt_by_doc = 0;
                $grand_total_referral_amount = 0;
                $ledger_amt_payment = 0;
                $net_total_referral_amount = 0;
                $total_referral_amt = 0;
                $i = 0;
                $sl=1;
            @endphp
            @foreach ($referral_arr as $key => $value)
                @php
                    $doc_id_exp = explode('_', $key);

                @endphp
                @if ($doc_id_exp[0] != 0 && $doc_id_exp[0] != '')
                    @foreach ($value as $data)
                        @php

                            $ledger_amt_sales += $data->ledger_amt_sales;
                            $total_referral_amount += 0; //$data->referral_amount;
                            $total_discount_amt_by_hos += $data->ledger_amt_discount;
                            $ledger_amt_payment += $data->ledger_amt_payment;
                            $grand_total_referral_amount += $data->referral_amount_doc;
                            $net_total_referral_amount += $data->referral_amount_doc - $data->ledger_amt_discount;
                            $total_referral_amt=$data->referral_amount_doc - $data->ledger_amt_discount;
                        @endphp
                        <tr>
                            <td class="text-center">{{ $sl++ }}</td>
                            {{-- <td class="text-left">{{ $data->invoice_no_pk }}</td> --}}
                            <td class="text-left">{{ $data->person_code }}</td>
                            <td class="text-left">{{ $data->doc_full_name }}</td>
                            <td class="text-right">{{$data->count_inv}}</td>
                            <td class="text-right">{{ number_format($data->ledger_amt_sales, 2) }}</td>
                            <td class="text-right">{{ number_format($data->ledger_amt_payment, 2) }}</td>
                            <td class="text-right">{{ number_format($data->ledger_amt_discount, 2) }}</td>
                            <td class="text-right">{{ number_format($data->referral_amount_doc, 2) }}</td>
                            <td class="text-right">{{ number_format($total_referral_amt,2) }}</td>
                        </tr>

                    @endforeach
                @endif

                @if ($doc_id_exp[1] != 0 && $doc_id_exp[1] != '')
                    @foreach ($value as $data)
                        @php

                            $ledger_amt_sales += $data->ledger_amt_sales;
                            $total_referral_amount += 0; //$data->referral_amount;
                            $total_discount_amt_by_hos += $data->ledger_amt_discount;
                            $ledger_amt_payment += $data->ledger_amt_payment;
                            $grand_total_referral_amount += $data->referral_amount_first ;
                            $net_total_referral_amount += $data->referral_amount_first - $data->ledger_amt_discount;
                            $total_referral_amt=$data->referral_amount_first - $data->ledger_amt_discount;
                        @endphp
                        <tr>
                            <td class="text-center">{{ $sl++ }}</td>
                            {{-- <td class="text-left">{{ $data->invoice_no_pk }}</td> --}}
                            <td class="text-left">{{ $data->ref_first_person_code }}</td>
                            <td class="text-left">{{ $data->first_ref_doc_name }}</td>
                            <td class="text-right">{{$data->count_inv}}</td>
                            <td class="text-right">{{ number_format($data->ledger_amt_sales, 2) }}</td>
                            <td class="text-right">{{ number_format($data->ledger_amt_payment, 2) }}</td>
                            <td class="text-right">{{ number_format($data->ledger_amt_discount, 2) }}</td>
                            <td class="text-right">{{ number_format($data->referral_amount_first, 2) }}</td>
                            <td class="text-right">{{ number_format($total_referral_amt,2) }}</td>


                        </tr>

                    @endforeach
                @endif

                @if ($doc_id_exp[2] != 0 && $doc_id_exp[2] != '')
                    @foreach ($value as $data)
                        @php

                            $ledger_amt_sales += $data->ledger_amt_sales;
                            $total_referral_amount += 0; //$data->referral_amount;
                            $total_discount_amt_by_hos += $data->ledger_amt_discount;
                            $ledger_amt_payment += $data->ledger_amt_payment;
                            $grand_total_referral_amount += $data->referral_amount_second;
                            $net_total_referral_amount += $data->referral_amount_second - $data->ledger_amt_discount;
                            $total_referral_amt=$data->referral_amount_second - $data->ledger_amt_discount;
                        @endphp
                        <tr>
                            <td class="text-center">{{  $sl++ }}</td>
                            {{-- <td class="text-left">{{ $data->invoice_no_pk }}</td> --}}
                            <td class="text-left">{{ $data->ref_scn_person_code }}</td>
                            <td class="text-left">{{ $data->second_ref_doc_name }}</td>
                            <td class="text-right">{{$data->count_inv}}</td>
                            <td class="text-right">{{ number_format($data->ledger_amt_sales, 2) }}</td>
                            <td class="text-right">{{ number_format($data->ledger_amt_payment, 2) }}</td>
                            <td class="text-right">{{ number_format($data->ledger_amt_discount, 2) }}</td>
                            <td class="text-right">{{ number_format($data->referral_amount_second, 2) }}</td>
                            <td class="text-right">{{ number_format($total_referral_amt,2) }}</td>


                        </tr>

                    @endforeach
                @endif
            @endforeach
            <tr>
                <td colspan="7" class="text-right"> <strong>Referral-wise grand total </strong> </td>
                {{-- <td class="text-right"> <strong>{{ number_format($ledger_amt_sales, 2) }} </strong> </td>
                <td class="text-right"> <strong>{{ number_format($ledger_amt_payment, 2) }} </strong> </td>
                <td class="text-right"> <strong>{{ number_format($total_discount_amt_by_hos, 2) }} </strong>
                </td> --}}
                <td class="text-right"> <strong>{{ number_format($grand_total_referral_amount, 2) }} </strong>
                </td>
                <td class="text-right"><strong>{{ number_format($net_total_referral_amount, 2) }}</strong></td>

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
