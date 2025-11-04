<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Financial Report</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    {{-- <link rel="stylesheet" href="{{ public_path().'/css/print.css' }}" media="print"> --}}
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

        .itemTable td,
        th {
            padding: 5px;
        }

        .itemTable th {
            background-color: #222;
            color: white;
        }
    </style>

</head>

<body>
    <header>
        <table style="width: 100%; border:none;" class="signature">
            <tr>
                <td style="width: 15%; border:none;">
                    {{-- <img class="hospital-logo"
                        src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}" width="60"
                        alt=""> --}}
                </td>
                <td style="text-align:center; border:none;">
                    <span style="font-size: 15px;"> <strong>
                            {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}
                        </strong></span>
                    <br>
                    Address:
                    <span>
                        {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</span><br>
                    Phone No:
                    <span>
                        {{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</span>
                </td>
            </tr>
        </table>
    </header>

    <div class="signature_">
        <table style="width: 100%; border:none;">
            <tr style=" ">
                <td style="text-align:left; border:none;">
                    <span style="padding:5px; border-top: black solid 1px;"> Employee Signature
                    </span>
                </td>
                <td style="text-align:right; border:none;">
                    <span style="padding:5px; border-top: black solid 1px;"> Approved By </span>
                </td>
            </tr>
        </table>
    </div>

    <footer style="position: fixed;">
        <div class="footer">
            <div class="container">
                <table style="width: 100%; padding:3px; margin: 0;border:none;">
                    <tr>
                        <td style="font-size: 9px; text-align:left;border:none;">Print Date & Time: <strong>
                                @php
                                    $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
                                    $date = $dt->format('g:i A');
                                @endphp
                                {{ date('d/m/Y') }} {{ $date }}
                            </strong> Printed By: <strong>{{ Session::get('user.ses_user_name') }}</strong></td>
                        <td style="font-size: 9px; text-align: right; border:none;"><strong>Powered By - H360 [NextGen]
                            </strong></td>

                    </tr>
                </table>
            </div>
        </div>
    </footer>

    <main>
        <div class="wrapper">
            <div style=" text-align:center; margin-bottom:5px; margin-top:20px  " class="mb-2">
                <span class="report-name" style="width:70%; border:solid black 1px; padding:10px;  ">
                    Item Wise Financial Details Report
                </span>
            </div>
            <div style=" text-align:center;  width:100%; margin-bottom:10px" class="mb-2">
                <span class="report-date">
                    <strong>From Date: {{ $form_date != '' ? $form_date : '' }} </strong> 
                </span> - 
                <span class="report-date">
                    <strong>To Date: {{ $to_date != '' ? $to_date : '' }}</strong>
                </span>
            </div>
            <section id="lp-items">
                <div class="container">
                    <div class="table-responsive border-top border-right">
                            @php
                                $total_item_qty = $total_sales = $total_salesreturn = $total_discount = $total_payment = $total_refund = $total_net_collection = $total_net_sales = $total_collection = $total_net_payable = $total_duecollection = 0;
                            @endphp
                        
                            <table class="table table-bordered table-hover mb-0">
                                <thead class="bg-light-blue sticky">
                                    <tr>
                                        <th class="text-center" scope="col">SL</th>
                                        <th class="text-left" scope="col">Test Name</th>
                                        <th class="text-center" scope="col">Item Qty</th>
                                        <th class="text-right" scope="col">Sales</th>
                                        <th class="text-right" scope="col">Sales Cancel</th>
                                        
                                        <th class="text-right" scope="col">Net Sales</th>
                                        <th class="text-right" scope="col">Discount</th>
                                        <th class="text-right" scope="col">Collection</th>
                                        <th class="text-right" scope="col">Due Collection</th>
                                        <th class="text-right" scope="col">Refund</th>
                                        <th class="text-right" scope="col">Net Collection</th>
                                        <th class="text-right" scope="col">Receivable</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($serviceUnitData))
                                        @foreach ($serviceUnitData as $key => $rows)
                                            @php
                                                $item_qty = $sales = $salesreturn = $discount = $collection = $refund = $duecollection = $net_sales_amount = $net_collection_amount = $net_payable = 0;
                                            @endphp
                                            <tr>
                                                <td class="text-left" colspan="12"> <strong> {{ $rows[0]->dept }} </strong></td>
                                            </tr>
                                            @foreach ($rows as $row)
                                                @php
                                                    $net_collection = ($row->collection + $row->duecollection) - $row->refund; 
                                                    $net_sales      = $row->sales - ($row->salesreturn + $row->discount);
                                                    $payable        = $net_sales - $row->collection;
                                                @endphp
                                                <tr>
                                                    <td class="text-center ">{{ $loop->iteration }}</td>
                                                    <td class="text-left">{{ $row->item_name }} </td>
                                                    <td class="text-center">{{ $row->item_qty }} </td>
                                                    <td style="text-align: right;">{{ number_format($row->sales, 2, '.', '') }}</td>
                                                    <td style="text-align: right;">{{ number_format($row->salesreturn, 2, '.', '') }}</td>
                                                   
                                                    <td style="text-align: right;">{{ number_format($net_sales, 2, '.', '') }}</td> 
                                                    <td style="text-align: right;">{{ number_format($row->discount, 2, '.', '') }}</td>
                                                    <td style="text-align: right;">{{ number_format($row->collection, 2, '.', '') }}</td>
                                                    <td style="text-align: right;">{{ number_format($row->duecollection, 2, '.', '') }}</td>
                                                    <td style="text-align: right;">{{ number_format($row->refund, 2, '.', '') }}</td>
                                                    <td style="text-align: right;">{{ number_format($net_collection, 2, '.', '') }}</td>
                                                    <td style="text-align: right;">{{ number_format($payable, 2, '.', '') }}</td>
                                                </tr>
                        
                                                @php
                                                    $item_qty               += $row->item_qty;
                                                    $sales                  += $row->sales;
                                                    $salesreturn            += $row->salesreturn;
                                                    $discount               += $row->discount;
                                                    $collection             += $row->collection;
                                                    $duecollection          += $row->duecollection;
                                                    $refund                 += $row->refund;
                                                    $net_sales_amount       += $net_sales; 
                                                    $net_collection_amount  += $net_collection; 
                                                    $net_payable            += $payable; 
                                                @endphp
                                            @endforeach
                        
                                            @php
                                                $total_item_qty             += $item_qty; 
                                                $total_sales                += $sales;
                                                $total_salesreturn          += $salesreturn;
                                                $total_discount             += $discount;
                                                $total_refund               += $refund;
                                                $total_collection           += $collection;
                                                $total_duecollection        += $duecollection;
                                                $total_net_sales            += $net_sales_amount;
                                                $total_net_collection       += $net_collection_amount;
                                                $total_net_payable          += $net_payable;
                                            @endphp
                        
                                            <tr>
                                                <td class="text-right" scope="col" colspan="2"> <strong> Department Total = </strong></td>
                                                <td scope="col" class="text-center bg-light-blue">{{ $item_qty }}</td>
                                                <td style="text-align: right;">{{ number_format($sales, 2, '.', '') }}</td>
                                                <td style="text-align: right;">{{ number_format($salesreturn, 2, '.', '') }}</td>
                                                
                                                <td style="text-align: right;">{{ number_format($net_sales_amount, 2, '.', '') }}</td>
                                                <td style="text-align: right;">{{ number_format($discount, 2, '.', '') }}</td>
                                                <td style="text-align: right;">{{ number_format($collection, 2, '.', '') }}</td>
                                                <td style="text-align: right;">{{ number_format($duecollection, 2, '.', '') }}</td>
                                                <td style="text-align: right;">{{ number_format($refund, 2, '.', '') }}</td>
                                                <td style="text-align: right;">{{ number_format($net_collection_amount, 2, '.', '') }}</td>
                                                <td style="text-align: right;">{{ number_format($net_payable, 2, '.', '') }}</td>
                                              
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td class="text-center" scope="col" colspan="12">No Data Available</td>
                                        </tr>
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td class="text-right" scope="col" colspan="2"> <strong> Total = </strong></td>
                                        <td scope="col" class="text-center bg-light-blue">{{ $total_item_qty }}</td>
                                        <td style="text-align: right;">{{ number_format($total_sales, 2, '.', '') }}</td>
                                        <td style="text-align: right;">{{ number_format($total_salesreturn, 2, '.', '') }}</td>
                                        
                                        <td style="text-align: right;">{{ number_format($total_net_sales, 2, '.', '') }}</td>
                                        <td style="text-align: right;">{{ number_format($total_discount, 2, '.', '') }}</td>
                                        <td style="text-align: right;">{{ number_format($total_collection, 2, '.', '') }}</td>
                                        <td style="text-align: right;">{{ number_format($total_duecollection, 2, '.', '') }}</td>
                                        <td style="text-align: right;">{{ number_format($total_refund, 2, '.', '') }}</td>
                                        <td style="text-align: right;">{{ number_format($total_net_collection, 2, '.', '') }}</td>
                                        <td style="text-align: right;">{{ number_format($total_net_payable, 2, '.', '') }}</td>
                                        
                                    </tr>
                                </tfoot>
                            </table> 
                </div>
            </section>
        </div>
    </main>
</body>

</html>
