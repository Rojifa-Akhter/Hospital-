@include('admin.components.pdf_header')

<main>
    <div class="wrapper">
        <div style=" text-align:center; margin-bottom:5px; margin-top:20px  " class="mb-2">
            <span class="report-name" style="width:70%; border:solid black 1px; padding:10px;  "> Date Wise Cashier Report</span>
        </div>
        <div style=" text-align:center;  width:100%; margin-bottom:10px" class="mb-2">


            <span class="report-date"><strong>From Date: {{ date("d/m/Y", strtotime($from_date)) }}</strong> -  <span class="report-date"><strong>To Date: {{ date("d/m/Y", strtotime($to_date)) }}</strong>
            </span>
        </div>
        <section id="lp-items">
            <div class="container">
                <table style="width: 100%;border-collapse:collapse;" cellpadding="1" cellspacing="0" border="1">
                    <tr class="table-tr" style="background-color: #E3E3E3;">
                        <td class="table-td"  scope="col" >
                            <strong>SL</strong>
                        </td>
                        <td class="table-td"  scope="col" >
                            <strong>Date</strong></td>
                        <td class="table-td"  scope="col" >
                            <strong>Cashier Name</strong></td>
                        <td class="table-td"  scope="col" >
                            <strong>No Of Invoice</strong></td>
                        <td class="table-td" scope="col" >
                            <strong>Sales</strong></td>
                        <td class="table-td" scope="col" >
                            <strong>Discount</strong></td>
                        <td class="table-td" scope="col" >
                            <strong>Net Sales</strong></td>
                        <td class="table-td" scope="col" >
                            <strong>Collection</strong></td>

                    </tr>

{{--                    <div style="display: none">--}}
{{--                        {{ $sales_total = 0 }}--}}
{{--                        {{ $sales_discount = 0 }}--}}
{{--                        {{ $net_sales = 0 }}--}}
{{--                        {{ $collection = 0 }}--}}

{{--                        {{ $invoice_count = 0 }}--}}
{{--                    </div>--}}
{{--                    @if(isset($data))--}}
{{--                        @php $dt = 0; $t = 0; $rsv = ''; @endphp--}}
{{--                        @foreach($data as $value)--}}


{{--                            <?php--}}
{{--                            if($dt == 0){--}}
{{--                                $cachedate = date("d/m/Y", strtotime($value->invoice_date));--}}
{{--                                if ($rsv == $cachedate) {--}}
{{--                                    $cachedate = '';--}}
{{--                                }--}}
{{--                            }--}}
{{--                            ?>--}}



{{--                            <tr>--}}
{{--                                <td class="text-center">{{$loop->iteration}}</td>--}}
{{--                                <?php--}}
{{--                                if ($cachedate == date("d/m/Y", strtotime($value->invoice_date)) && $dt == 0) {--}}
{{--                                $rsv = $cachedate;--}}
{{--                                ?>--}}
{{--                                <td class="text-left">{{ $cachedate }}</td>--}}
{{--                                <?php $dt = 1;} else { ?>--}}
{{--                                <td class="text-left"></td>--}}
{{--                                <?php $dt = 0;} ?>--}}
{{--                                <td class="table-td" style="text-align: left;" scope="col" >--}}
{{--                                    <strong>{{$value->full_name}}</strong></td>--}}
{{--                                <td class="text-left">{{$value->invoice_count}}</td>--}}

{{--                                <td class="table-td" style="text-align: left;" scope="col" >--}}
{{--                                    <strong>{{$value->ledger_amt_sales_total}}</strong></td>--}}
{{--                                <td class="table-td" style="text-align: left;" scope="col" >--}}
{{--                                    <strong>{{$value->ledger_amt_discount_total}}</strong></td>--}}
{{--                                <td class="table-td" style="text-align: left;" scope="col" >--}}
{{--                                    <strong>{{$value->net_sales}}</strong></td>--}}
{{--                                <td class="table-td" style="text-align: left;" scope="col" >--}}

{{--                                    <strong>{{$value->collection_total}}</strong></td>--}}
{{--                                <div style="display: none">{{$sales_total += $value->ledger_amt_sales_total}}</div>--}}
{{--                                <div style="display: none">{{$sales_discount += $value->ledger_amt_discount_total}}</div>--}}
{{--                                <div style="display: none">{{$net_sales += $value->net_sales}}</div>--}}
{{--                                <div style="display: none">{{$collection += $value->collection_total}}</div>--}}
{{--                                <div style="display: none">{{$invoice_count += $value->invoice_count}}</div>--}}


{{--                            </tr>--}}
{{--                        @endforeach--}}
{{--                    @endif--}}

                    <tfoot>
{{--                    <tr>--}}
{{--                        <th class="text-right" style="text-align: right;" colspan="3">Total = </th>--}}
{{--                        <th class="text-left bg-light-blue" style="text-align: left;">{{$invoice_count}}</th>--}}
{{--                        <th class="text-left" style="text-align: left;">{{$sales_total}}</th>--}}
{{--                        <th class="text-left" style="text-align: left;">{{$sales_discount}}</th>--}}
{{--                        <th class="text-left" style="text-align: left;">{{$net_sales}}</th>--}}
{{--                        <th class="text-left" style="text-align: left;">{{$collection}}</th>--}}
{{--                    </tr>--}}
                    </tfoot>


                </table>
            </div>
        </section>
    </div>
</main>


@include('admin.components.pdf_footer')
