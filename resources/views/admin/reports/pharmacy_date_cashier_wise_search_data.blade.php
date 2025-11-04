<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<table class="table table-bordered table-striped mb-0 data-table">
    <thead>
        <tr class="bg-light-blue">
            <th class="text-center">SL#</th>
            <th class="text-center">Date</th>
            <th class="text-left">Patient info</th>
            {{-- <th class="text-center">Counter Name</th> --}}
            <th class="text-center">Invoice No</th>
            <th class="text-right">Sales</th>
            <th class="text-right">Discount</th>
            <th class="text-right">Net Sales</th>
            <th class="text-right">Collection</th>
            <th class="text-right">Due</th>
            <th class="text-right">Refund</th>
            <th class="text-right">Net Collection</th>
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
        </div>

        @php
            // $str1 = $cashier_arr;
            // dd($str1);
            // $service_point = (explode("_",$str));
        @endphp


        @if (!empty($cashier_arr))
            @foreach ($cashier_arr as $key1 => $cashier_arr1)
                <tr>
                    <td class="text-left" colspan="11"> <strong>{{ $key1 }}</strong></td>
                </tr>

                @foreach ($cashier_arr1 as $key => $value)
                    @php
                        $str = $key;
                        $service_point = explode('_', $str);
                    @endphp
                    <tr>
                        <td class="text-left" colspan="11">
                            <strong> {{ $service_point[1] }} </strong>
                        </td>
                    </tr>

                    <div style="display: none">

                        {{ $sl_count = 0 }}
                        {{ $sales_total = 0 }}
                        {{ $sales_discount = 0 }}
                        {{ $net_sales = 0 }}
                        {{ $due = 0 }}
                        {{ $collection = 0 }}
                        {{ $refund = 0 }}
                        {{ $net_collection = 0 }}
                    </div>
                    @foreach ($value as $data)
                        {{-- <tr>
               <td>{{ $data->invoice_code }}</td>
               <td>{{ $data->customer_name }}</td>
           </tr> --}}



                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">{{ date('d/m/Y', strtotime($data->invoice_date)) }}</td>
                            <td class="text-left">
                                {{ $data->customer_name }} <br>
                               {{$data->mobile1}}
                               </td>
                            {{-- <td class="text-center">{{$value->counter_name}}</td> --}}
                            <td class="text-right">{{ $data->invoice_code }}</td>
                            <td class="text-right">{{ number_format($data->ledger_amt_sales, 2) }}</td>

                            <td class="text-right">
                               <div> {{ number_format($data->ledger_amt_discount, 2) }} </div>
                               <div>{{ ucfirst($data->discount_detail) }}</div>

                           </td>
                            <td class="text-right">{{ number_format($data->ledger_amt_sales_net, 2) }} </td>
                            <td class="text-right">{{ number_format($data->ledger_amt_payment, 2) }} </td>
                            <td class="text-right">{{ number_format($data->ledger_amt_due, 2) }} </td>
                            <td class="text-right">{{ number_format($data->refund, 2) }} </td>
                            <td class="text-right">{{ number_format($data->net_collection, 2) }} </td>


                        </tr>

                        <div style="display: none">{{ $sales_total += $data->ledger_amt_sales }}</div>
                        <div style="display: none">{{ $sales_discount += $data->ledger_amt_discount }}</div>
                        <div style="display: none">{{ $collection += $data->ledger_amt_payment }}</div>
                        <div style="display: none">{{ $invoice_count += $data->invoice_code }}</div>
                        <div style="display: none">{{ $net_sales += $data->ledger_amt_sales_net }}</div>
                        <div style="display: none">{{ $due += $data->ledger_amt_due }}</div>
                        <div style="display: none">{{ $refund += $data->refund }}</div>
                        <div style="display: none">{{ $net_collection += $data->net_collection }}</div>
                        @php
                            $sl_count += 1;
                        @endphp
                    @endforeach

                    <tr>
                        <td class="text-right" colspan="3">Sub Total</td>
                        <td class="text-right"><strong>{{ $sl_count }}</strong></td>
                        <td class="text-right"><strong>{{ number_format($sales_total, 2) }}</strong></td>
                        <td class="text-right" style="text-align: right;">
                            <strong>{{ number_format($sales_discount, 2) }}</strong></td>
                        <td class="text-right" style="text-align: right;">
                            <strong>{{ number_format($net_sales, 2) }}</strong></td>

                        <td class="text-right" style="text-align: right;">
                            <strong>{{ number_format($collection, 2) }}</strong></td>
                        <td class="text-right" style="text-align: right;">
                            <strong>{{ number_format($due, 2) }}</strong></td>
                        <td class="text-right" style="text-align: right;">
                            <strong>{{ number_format($refund, 2) }}</strong></td>
                        <td class="text-right" style="text-align: right;">
                            <strong>{{ number_format($net_collection, 2) }}</strong></td>

                        <div style="display: none">{{ $sales_total_final_final += $sales_total }}</div>
                        <div style="display: none">{{ $sales_discount_final += $sales_discount }}</div>
                        <div style="display: none">{{ $collection_final += $collection }}</div>
                        <div style="display: none">{{ $net_sales_final += $net_sales }}</div>
                        <div style="display: none">{{ $due_final += $due }}</div>
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
    <tfoot>
        <tr>
            <th class="text-right" colspan="3">Total =</th>
            <th class="text-right bg-light-blue" style="text-align: left;">{{ $invoice_count_final }}</th>
            <th class="text-right bg-light-blue" style="text-align: right;">
                {{ number_format($sales_total_final_final, 2) }} </th>
            <th class="text-right bg-light-blue" style="text-align: right;">
                {{ number_format($sales_discount_final, 2) }} </th>

            <th class="text-right bg-light-blue" style="text-align: right;">{{ number_format($net_sales_final, 2) }}
            </th>
            <th class="text-right bg-light-blue" style="text-align: right;">{{ number_format($collection_final, 2) }}
            </th>
            <th class="text-right bg-light-blue" style="text-align: right;">{{ number_format($due_final, 2) }} </th>
            <th class="text-right bg-light-blue" style="text-align: right;">{{ number_format($refund_final, 2) }} </th>
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
