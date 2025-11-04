<style>
        @page {
            margin: .5cm .6cm;
            width: 100%;
            height: 100%
        }

        @font-face {
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-weight: normal;
            font-size: 10px;
            font-style: normal;
            font-variant: normal;
            src: url("font url");
        }


        /** Define the header rules **/
        header {
            position: fixed;
            top: 0;
            height: 2cm;
            border-bottom: 1px solid;
            padding: 0 1cm;
        }

        header img {
            /*width: 80px;*/
        }

        /** Define now the real margins of every page in the PDF **/
        body {
            margin-top: 2cm;
            margin-left: .3cm;
            margin-right: .3cm;
            margin-bottom: 2cm;
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-size: 11px;
        }

        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: .7cm;
            text-align: center;
            padding: 0 1cm;
            border-top: 1px solid;
        }

        .signature_ {
            position: fixed;
            bottom: 1.6cm;
            left: .8cm;
            right: .8cm;
            width: 100%;
            /* text-align: center; */

            /* border-top: 1px solid; */
        }

        tfoot tr td {
            font-weight: bold;
        }

        .page-break {
            page-break-after: always;
        }

        .mt-5 {
            margin-top: 5px;
        }

        .mt-10 {
            margin-top: 10px;
        }

        .mt-20 {
            margin-top: 20px;
        }

        .mb-0 {
            margin-bottom: 0;
        }

        .mb-5 {
            margin-bottom: 15px;
        }

        .pb-0 {
            padding-bottom: 0;
        }

        table {
            border: 1px solid #222;
            border-spacing: 0;
        }

        td {
            border-bottom: 1px solid #222;
            border-right: 1px solid #222;
        }

        table td:last-child {
            border-right: 0px solid transparent;
        }

        th {
            border-top: 1px solid #222;
        }

    </style>

      

  

    <main>
        <div class="wrapper">
            <div style=" text-align:center; margin-bottom:5px; margin-top:20px  " class="mb-2">
                <span class="report-name" style="width:70%; border:solid black 1px; padding:10px;  "> Pharmacy Profit-Loss Report</span>
            </div>
            <div style=" text-align:center;  width:100%; margin-bottom:10px" class="mb-2">
                <span class="report-date"><strong>From Date: {{ $from_date }}</strong> - <span
                        class="report-date"><strong>To Date: {{ $to_date }}</strong></span>
                </span>
            </div>
            <section id="lp-items">
                <div class="container">
                    <table style="width: 100%;border-spacing: 0;" cellpadding="1">
                        <tr class="table-tr" style="background-color: #E3E3E3;">
                            <td class="table-td" scope="col">
                                <strong>SL</strong>
                            </td>
                            <td class="table-td" scope="col">
                                <strong>Item Name</strong>
                            </td>
                            <td class="table-td" scope="col">
                                <strong>Item Name</strong>
                            </td>

                            <td class="table-td" scope="col" style="text-align: center;">
                                <strong>Item Qty</strong>
                            </td>
                            <td class="table-td" scope="col" style="text-align: right;">
                                <strong>Purchase Price</strong>
                            </td>
                            <td class="table-td" style="text-align: right;" scope="col">
                                <strong>Sales Price</strong>
                            </td>
                            <td class="table-td" scope="col" style="text-align: right;">
                                <strong>Total Purchase Price</strong>
                            </td>
                            <td class="table-td" scope="col" style="text-align: right;">
                                <strong>Total Sales Price</strong>
                            </td>

                            <td class="table-td" scope="col" style="text-align: right;">
                                <strong>Discount</strong>
                            </td>
                            <td class="table-td" scope="col" style="text-align: right;">
                                <strong>Profit / Loss</strong>
                            </td>


                        </tr>

                        <div style="display: none">
                            @php
                                 $sales_total = 0;
                                $purchase_price = 0;
                                $total_item_qty = 0;
                                $total_sales_price = 0;
                                $total_purchase_price = 0;
                                $total_discount = 0;
                                $total_profit = 0;
                            @endphp
                           
                        </div>
                        @if (!empty($item_data))
                        @foreach ($item_data as $value)



                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="text-left">{{ $value->item_name }}</td>
                                    <td class="text-left">{{ $value->supplier_name }}</td>
                                    <td class="text-right" style="text-align: center;">{{ $value->item_qty }} </td>
                                    <td class="text-right" style="text-align: right;">{{ number_format($value->purchase_price, 2) }}</td>
                                    <td class="text-right" style="text-align: right;">{{ number_format($value->sales_price, 2) }} </td>
                                    <td class="text-right" style="text-align: right;">{{ number_format($value->total_purchase_price, 2) }} </td>
                                    <td class="text-right" style="text-align: right;">{{ number_format($value->total_sales_price, 2) }} </td>
                                    <td class="text-right" style="text-align: right;">{{ number_format($value->discount, 2) }} </td>
                                    <td class="text-right" style="text-align: right;">{{ number_format($value->profit, 2) }} </td>
                                    
                                    @php
                                        $sales_total += $value->sales_price;
                                        $purchase_price += $value->purchase_price;
                                        $total_item_qty += $value->item_qty;
                                        $total_sales_price += $value->total_sales_price;
                                        $total_purchase_price += $value->total_purchase_price;
                                        $total_discount += $value->discount;
                                        $total_profit += $value->profit;
                                    @endphp
                                    
                                </tr>

                        @endforeach
                        <tr>
                            <td class="text-right" colspan="6" style="text-align: right;"> <strong> Grand  Total </strong></th>
                            {{-- <td class="text-center bg-light-blue" style="text-align: right;" > <strong> {{number_format($sales_total,2)}}</strong></th>
                            <td class="text-right bg-light-blue" style="text-align: right;" ><strong>{{number_format($purchase_price,2)}} </strong></td>
                            <td class="text-right bg-light-blue" style="text-align: center;" ><strong>{{$total_item_qty}}</strong> </td> --}}
                            <td class="text-right bg-light-blue" style="text-align: right;" ><strong>{{number_format($total_purchase_price,2)}}</strong> </td>
                            <td class="text-right bg-light-blue" style="text-align: right;" ><strong>{{number_format($total_sales_price,2)}} </strong></td>
                            <td class="text-right bg-light-blue" style="text-align: right;" ><strong>{{number_format($total_discount,2)}} </strong></td>
                            <td class="text-right bg-light-blue" style="text-align: right;" ><strong>{{number_format($total_profit,2)}} </strong></td>
                        </tr>
                    @endif
                </tbody>
                    </table>
                </div>
            </section>
        </div>
    </main>
