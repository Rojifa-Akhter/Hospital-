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
                <table style="width: 100%;border-collapse:collapse;" cellpadding="1" cellspacing="0">
                    <tr class="table-tr" style="background-color: #E3E3E3;">
                                <td class="table-td"  scope="col" >
                                    <strong>SL</strong>
                                </td>
                                <td class="table-td"  scope="col" >
                                    <strong>Date</strong></td>
                                    <td class="table-td"  scope="col" >
                                    <strong>Cashier Name</strong></td>
                                <td class="table-td" scope="col" style="text-align: right;">
                                    <strong>Sales</strong></td>
                                <td class="table-td" scope="col" style="text-align: right;">
                                    <strong>Discount</strong></td>
                                <td class="table-td" scope="col" style="text-align: right;">
                                    <strong>Net Sales</strong></td>
                                <td class="table-td" scope="col" style="text-align: right;">
                                    <strong>Collection</strong></td>

                            </tr>
                            @if(isset($data))
                            @foreach($data as $value)
                            <tr class="table-tr">
                                <td class="table-td" style="text-align: center;" scope="col" >
                                    <strong>{{$loop->iteration}}</strong>
                                </td>
                                <td class="table-td" style="text-align: left;" scope="col" >
                                    <strong>{{ date("d/m/Y", strtotime($value->au_entry_at)) }}</strong></td>
                                    <td class="table-td" style="text-align: left;" scope="col" >
                                    <strong>{{$value->full_name}}</strong></td>
                                <td class="table-td" style="text-align: left;" scope="col" ><strong>
                                {{$value->person_code}}</strong></td>
                                <td class="table-td" style="text-align: right;" scope="col" >
                                    <strong>{{number_format($value->ledger_amt_sales_total,2)}}</strong></td>
                                <td class="table-td" style="text-align: right;" scope="col" >
                                    <strong>{{number_format($value->ledger_amt_discount_total,2)}}</strong></td>
                                <td class="table-td" style="text-align: right;" scope="col" >
                                    <strong>{{number_format($value->net_sales,2)}}</strong></td>
                                <td class="table-td" style="text-align: right;" scope="col" >
                                    <strong>{{number_format($value->collection_total,2)}}</strong></td>
                            </tr>
                            @endforeach
                            @endif


                        </table>
                    </div>
                </section>
            </div>
        </main>


        @include('admin.components.pdf_footer')
