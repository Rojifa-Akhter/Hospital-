<style>
    .sticky_header {
        position: sticky;
        top: 90px;

    }
</style>
@php
    $invoice_arr = 0;
    $invoice_su_arr[] = [];

@endphp
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<table class="table table-bordered table-striped mb-0 data-table">
    <thead class="sticky_header">
        <tr class="bg-light-blue">
            <th class="text-center">SL#</th>
            <th class="text-center">Invoice Date</th>
            <th class="text-center">Ledger Date</th>

            <th class="text-left">Admission ID</th>
            <th class="text-left">Patient info</th>
            {{-- <th class="text-center">Counter Name</th> --}}
            <th class="text-center">Transaction No</th>
            <th class="text-center">Invoice No</th>
            <th class="text-right">Sales</th>
            <th class="text-right">Discount</th>
            @if (Session::get('user.ses_hospital_code') != 'EWMCH')
                <th class="text-right">Cancel</th>
            @endif
            <th class="text-right">Net Sales</th>
            <th class="text-right">Collection</th>

            {{-- <th class="text-right">Due</th> --}}
            <th class="text-right">Refund</th>
            <th class="text-right">Net Collection</th>

            @if (Session::get('user.ses_hospital_code') == 'DMHL' && Session::get('user.serviceunit') == "Cafeteria")
                <th class="text-center">Category</th>
            @endif
        </tr>
    </thead>
    <tbody>
        <div style="display: none">

            {{ $invoice_count = 0 }}
            {{ $sales_total_final_final = 0 }}
            {{ $sales_discount_final = 0 }}
            {{ $collection_final = 0 }}
            {{ $invoice_count_final = 0 }}
            {{ $net_sales_final = 0 }}
            {{ $due_final = 0 }}
            {{ $refund_final = 0 }}
            {{ $netcollection_final = 0 }}
            {{ $net_sales_cancel = 0 }}
        </div>

        @php
            // $str1 = $cashier_arr;
            // dd($str1);
            // $service_point = (explode("_",$str));
        @endphp


        @if (!empty($cashier_arr))
            @foreach ($cashier_arr as $key1 => $cashier_arr1)
                @if (Session::get('user.ses_hospital_code') == 'GMC')
                    <tr>
                        <td class="text-left" colspan="14"> <strong>{{ $key1 }}</strong></td>
                    </tr>
                @else
                    <tr>
                        <td class="text-left" colspan="14"> <strong>{{ $key1 }}</strong></td>
                    </tr>
                @endif


                @foreach ($cashier_arr1 as $key => $value)
                    @php
                        $str = $key;
                        $service_point = explode('_', $str);
                    @endphp
                    @if (Session::get('user.ses_hospital_code') == 'GMC')
                        <tr>
                            <td class="text-left" colspan="14">
                                <strong> {{ $service_point[1] }} </strong>
                            </td>
                        </tr>
                    @else
                        <tr>
                            <td class="text-left" colspan="14">
                                <strong> {{ $service_point[1] }} </strong>
                            </td>
                        </tr>
                    @endif

                    <div style="display: none">

                        {{ $sl_count = 0 }}
                        {{ $sales_total = 0 }}
                        {{ $sales_discount = 0 }}
                        {{ $net_sales = 0 }}
                        {{ $due = 0 }}
                        {{ $due_total = 0 }}
                        {{ $collection = 0 }}
                        {{ $refund = 0 }}
                        {{ $net_collection = 0 }}
                        {{ $sales_cancel = 0 }}


                    </div>
                    @foreach ($value as $data)
                        @php
                            $invoice_su_arr[$service_point[1]][$key1][$data->invoice_code] = $data->invoice_code;
                            $due = round($data->ledger_amt_sales - $data->ledger_amt_payment);
                            //  $due=$data->ledger_amt_due > 0 ?round($data->ledger_amt_due): 0;
                        @endphp

                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">{{ date('d/m/Y', strtotime($data->invoice_date)) }}</td>
                            <td class="text-center">{{ date('d/m/Y', strtotime($data->ledger_datetime)) }}</td>
                            <td class="text-center">{{ $data->admission_no_pk }}</td>
                            <td class="text-left">
                                {{ $data->customer_name }} <br>
                                {{ $data->mobile1 }}
                            </td>
                            {{-- <td class="text-center">{{$value->counter_name}}</td> --}}
                            <td class="text-right">{{ $data->ledgertrn_no_pk }}</td>
                            <td class="text-right">{{ $data->invoice_code }}</td>

                            {{-- Sales --}}
                            <td class="text-right">{{ number_format(round($data->ledger_amt_sales), 2) }}</td>

                            {{-- Dicsount --}}
                            <td class="text-right">
                                <div> {{ number_format(round($data->ledger_amt_discount), 2) }} </div>
                                <div>{{ ucfirst($data->discount_detail) }}</div>

                            </td>
                            @if (Session::get('user.ses_hospital_code') != 'EWMCH')
                                {{-- Cancel --}}
                                <td class="text-right">{{ number_format(round($data->sales_cancel), 2) }}</td>
                            @endif

                            {{-- Net Sales --}}
                            {{-- <td class="text-right">{{ number_format(round($data->ledger_amt_sales_net) - $data->sales_cancel, 2) }} </td> --}}
                            <td class="text-right">
                                {{ number_format(round($data->ledger_amt_sales) - round($data->ledger_amt_discount) - round($data->sales_cancel, 2)) }}
                            </td>

                            {{-- Collection --}}
                            <td class="text-right">{{ number_format(round($data->ledger_amt_payment), 2) }} </td>

                            {{-- <td class="text-right">{{ number_format($due , 2)}} </td> --}}
                            <td class="text-right">{{ number_format($data->refund, 2) }} </td>

                            {{-- Net Collection --}}
                            <td class="text-right">{{ number_format($data->ledger_amt_payment - $data->refund, 2) }}
                            </td>

                            {{-- <td class="text-right">{{ number_format($data->net_collection, 2) }} </td> --}}

                            @if (Session::get('user.ses_hospital_code') == 'DMHL' && Session::get('user.serviceunit') == "Cafeteria")
                                <td class="text-left">

                                    @php
                                        $net_sales_arif = round($data->ledger_amt_sales) - round($data->ledger_amt_discount) - round($data->sales_cancel, 2);
                                        $collection_arif = round($data->ledger_amt_payment);
                                        $due_amount_arif = $net_sales_arif - $collection_arif;
                                    @endphp
                                    @if ($net_sales_arif > 0 && $collection_arif == $net_sales_arif)
                                    <span style="font-weight: bolder;">Sales Collection</span> <!-- Green -->
                                    @elseif ($net_sales_arif == 0 && $collection_arif > 0)
                                    <span style="font-weight: bolder;color:blue;">Due Collection</span> <!-- Orange -->
                                    @elseif ($net_sales_arif > 0 && $collection_arif < $net_sales_arif)
                                    <span style="font-weight: bolder;">Due Amount <p class="text-danger">({{ $due_amount_arif }})</p></span> <!-- Red -->
                                    @elseif ($net_sales_arif < 0 || $collection_arif < 0)
                                    <span style="font-weight: bolder;">Invalid Amount</span> <!-- Blue -->
                                    @else
                                    <span style="font-weight: bolder;">Others</span> <!-- Gray -->
                                    @endif

                                </td>
                            @endif
                        </tr>
                        <div style="display: none">
                        </div>
                        <div style="display: none">{{ $sales_total += $data->ledger_amt_sales }}</div>
                        <div style="display: none">{{ $sales_discount += $data->ledger_amt_discount }}</div>
                        <div style="display: none">{{ $collection += $data->ledger_amt_payment }}</div>
                        <div style="display: none">{{ $invoice_count += 1 }}</div>

                        {{-- <div style="display: none">{{ $net_sales += ($data->ledger_amt_sales_net - $data->sales_cancel) }}</div> --}}
                        <div style="display: none">
                            {{ $net_sales += $data->ledger_amt_sales - $data->ledger_amt_discount - $data->sales_cancel }}
                        </div>

                        @if (Session::get('user.ses_hospital_code') != 'EWMCH')
                            <div style="display: none">{{ $sales_cancel += $data->sales_cancel }}</div>
                        @endif

                        {{-- <div style="display: none">{{ $due_total += $due }}</div> --}}
                        <div style="display: none">{{ $refund += $data->refund }}</div>
                        <div style="display: none">{{ $net_collection += $data->ledger_amt_payment - $data->refund }}
                        </div>
                        {{-- <div style="display: none">{{ $net_collection += $data->net_collection }}</div> --}}
                        @php
                            $sl_count += 1;
                        @endphp
                    @endforeach
                    @php
                        $invoice_arr += count($invoice_su_arr[$service_point[1]][$key1]);
                    @endphp
                    <tr>

                        <td class="text-right" colspan="6">Sub Total</td>
                        <td class="text-right"><strong>{{ count($invoice_su_arr[$service_point[1]][$key1]) }}</strong>
                        </td>
                        <td class="text-right"><strong>{{ number_format($sales_total, 2) }}</strong></td>
                        <td class="text-right" style="text-align: right;">
                            <strong>{{ number_format($sales_discount, 2) }}</strong>
                        </td>
                        @if (Session::get('user.ses_hospital_code') != 'EWMCH')
                            <td class="text-right" style="text-align: right;">
                                <strong>{{ number_format($sales_cancel, 2) }}</strong>
                            </td>
                        @endif
                        <td class="text-right" style="text-align: right;">
                            <strong>{{ number_format($net_sales, 2) }}</strong>
                        </td>

                        <td class="text-right" style="text-align: right;">
                            <strong>{{ number_format($collection, 2) }}</strong>
                        </td>

                        {{-- <td class="text-right" style="text-align: right;">
                             <strong>{{ number_format($due_total, 2) }}</strong>
                         </td> --}}
                        <td class="text-right" style="text-align: right;">
                            <strong>{{ number_format($refund, 2) }}</strong>
                        </td>
                        <td class="text-right" style="text-align: right;">
                            <strong>{{ number_format($net_collection, 2) }}</strong>
                        </td>

                        <div style="display: none">{{ $sales_total_final_final += $sales_total }}</div>
                        <div style="display: none">{{ $sales_discount_final += $sales_discount }}</div>
                        <div style="display: none">{{ $collection_final += $collection }}</div>
                        <div style="display: none">{{ $net_sales_final += $net_sales }}</div>

                        <div style="display: none">{{ $net_sales_cancel += $sales_cancel }}</div>

                        <div style="display: none">
                            {{ Session::get('user.ses_hospital_no_pk') != 'JKMH' ? ($due_final += $due_total) : '' }}
                        </div>
                        <div style="display: none">{{ $refund_final += $refund }}</div>
                        <div style="display: none">{{ $netcollection_final += $net_collection }}</div>
                        @php
                            $invoice_count_final += $sl_count;
                        @endphp
                    </tr>
                @endforeach
            @endforeach

        @endif

    </tbody>
    <tfoot class="sticky_header">
        <tr>
            @php  $invoice_count_final; @endphp
            <th class="text-right" colspan="6">Total =</th>
            {{-- Invoice --}}
            <th class="text-right bg-light-blue" style="text-align: left;">{{ $invoice_arr }}</th>
            {{-- Sales --}}
            <th class="text-right bg-light-blue" style="text-align: right;">
                {{ number_format($sales_total_final_final, 2) }} </th>
            {{-- Discount --}}
            <th class="text-right bg-light-blue" style="text-align: right;">
                {{ number_format($sales_discount_final, 2) }} </th>
            @if (Session::get('user.ses_hospital_code') != 'EWMCH')
                {{-- Cancel --}}
                <th class="text-right bg-light-blue" style="text-align: right;">
                    {{ number_format($net_sales_cancel, 2) }}
                </th>
            @endif
            {{-- Net Sales --}}
            <th class="text-right bg-light-blue" style="text-align: right;">{{ number_format($net_sales_final, 2) }}
            </th>
            {{-- Collection --}}
            <th class="text-right bg-light-blue" style="text-align: right;">{{ number_format($collection_final, 2) }}
            </th>

            {{-- <th class="text-right bg-light-blue" style="text-align: right;">{{Session::get('user.ses_hospital_no_pk') !="JKMH" ?  number_format($due_final, 2) : ""}} </th> --}}
            {{-- Refund --}}
            <th class="text-right bg-light-blue" style="text-align: right;">{{ number_format($refund_final, 2) }}
            </th>
            {{-- Net Collection --}}
            <th class="text-right bg-light-blue" style="text-align: right;">
                {{ number_format($netcollection_final, 2) }} </th>
        </tr>
    </tfoot>
</table>



<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
 </script>

<script type="text/javascript">
    $('.data-table').DataTable({
        "ordering": false,
        "bPaginate": false,
        "bLengthChange": false,
        "bAutoWidth": false
    });
</script>
