<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Financial Statement Report</title>
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
        header {
            position: fixed;
            top: 0;
            height: 2cm;
            border-bottom: 1px solid;
            padding: 0 1cm;
        }

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

        table td:last-child {
            border-right: 0px solid transparent;
        }
        .text-right{
            text-align:right;
        }

        th, td {
            border: 1px solid black;
        }
    </style>
</head>

<body>
    <header>
        <table style="width: 100%; border:none;" class="signature">
            <tr>
                <td style="width: 15%; border:none;" colspan="2">
                @if(!empty($po_hospital_details->logo) && !file_exists(asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo)))
                    <img class="hospital-logo"
                        src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}" width="60"
                        alt="">
                @endif
                </td>
                <td style="width: 70%; text-align: center; border:none;" colspan="6">
                    <span style="font-size: 25px;"> <strong>
                            {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}
                        </strong></span>
                    <br>
                    Address:
                    <span>
                        {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</span><br>
                    Phone No:
                    <span>
                        {{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</span>
                    <h4 class="text-center">Item Wise Financial Report</h4>
                    <h5 class="text-center">
                        From Date: {{ $form_date != '' ? $form_date : '' }}.
                        To Date: {{ $to_date != '' ? $to_date : '' }}
                    </h5>
                </td>
                <td style=" text-align:right; width: 15%; border:none;" colspan="2">
                    {{-- <div style="">
                        <img src="data:image/png;base64, {{ $barcode_no }} " width="100" />
                    </div> --}}
                </td>
            </tr>
        </table>
    </header>

    <main>
        <div class="wrapper">
            <section id="lp-items">
                <div class="container">
                    <div class="table-responsive border-top border-right">
                        @php
                            $total_item_qty = $total_sales = $total_salesreturn = $total_discount = $total_payment = $total_refund = $total_net_collection = $total_net_sales = 0;
                        @endphp
                        <table class="table table-bordered table-hover mb-0 itemTable" width="100%">
                            <thead class="bg-light-blue">
                                <tr>
                                    <th style="text-align: center" scope="col">SL</th>
                                    <th scope="col">Test Name</th>
                                    <th style="text-align: center" scope="col">Item Qty</th>
                                    <th style="text-align: right" scope="col">Sales</th>
                                    <th style="text-align: right" scope="col">Sales Cancel</th>
                                    <th style="text-align: right" scope="col">Discount</th>
                                    <th style="text-align: right" scope="col">Net Sales</th>
                                    <th style="text-align: right" scope="col">Collection</th>
                                    <th style="text-align: right" scope="col">Refund</th>
                                    <th style="text-align: right" scope="col">Net Collection</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!empty($serviceUnitData))
                                    @foreach ($serviceUnitData as $key => $rows)
                                    @php
                                        $item_qty = $sales = $salesreturn = $discount = $payment = $refund = $net_collection_amount = $net_sales_amount = 0;
                                    @endphp
                                        <tr>
                                            <td class="text-left" colspan="10"> <strong> {{ $rows[0]->dept }} </strong></td>
                                        </tr>
                                        @foreach ($rows as $row)
                                            @php
                                                $net_collection = $row->payment - $row->refund;
                                                $net_sales = $row->sales - ($row->salesreturn + $row->discount);
                                            @endphp
                                            <tr>
                                                <td class="text-center ">{{ $loop->iteration }}</td>
                                                <td class="text-left">{{ $row->item_name }} </td>
                                                <td style="text-align: center" class="text-center">{{ $row->item_qty }} </td>
                                                <td style="text-align: right" class="text-right">{{ number_format($row->sales, 2, '.', '') }}</td>
                                                <td style="text-align: right" class="text-right">{{ number_format($row->salesreturn, 2, '.', '') }}</td>
                                                <td style="text-align: right" class="text-right">{{ number_format($row->discount, 2, '.', '') }}</td>
                                                <td style="text-align: right" class="text-right">{{ number_format($net_sales, 2, '.', '') }}</td>
                                                <td style="text-align: right" class="text-right">{{ number_format($row->payment, 2, '.', '') }}</td>
                                                <td style="text-align: right" class="text-right">{{ number_format($row->refund, 2, '.', '') }}</td>
                                                <td style="text-align: right" class="text-right">{{ number_format($net_collection, 2, '.', '') }}</td>
                                            </tr>

                                            @php
                                                $item_qty               += $row->item_qty;
                                                $sales                  += $row->sales;
                                                $salesreturn            += $row->salesreturn;
                                                $discount               += $row->discount;
                                                $payment                += $row->payment;
                                                $refund                 += $row->refund;
                                                $net_collection_amount  += $net_collection;
                                                $net_sales_amount       += $net_sales;
                                            @endphp
                                        @endforeach
                                        @php
                                            $total_item_qty         += $item_qty; 
                                            $total_sales            += $sales;
                                            $total_salesreturn      += $salesreturn;
                                            $total_discount         += $discount;
                                            $total_payment          += $payment;
                                            $total_refund           += $refund;
                                            $total_net_collection   += $net_collection_amount;
                                            $total_net_sales        += $net_sales_amount;
                                        @endphp
                                        <tr>
                                            <td class="text-right" scope="col" colspan="2"> <strong> Department Total = </strong></td>
                                            <td scope="col" style="text-align: center" class="text-center bg-light-blue">{{ $item_qty }}</td>
                                            <td scope="col" style="text-align: right" class="text-right bg-light-blue">{{ $sales }}</td>
                                            <td scope="col" style="text-align: right" class="text-right bg-light-blue">{{ $salesreturn }}</td>
                                            <td scope="col" style="text-align: right" class="text-right bg-light-blue">{{ number_format($discount, 2, '.', '') }}</td>
                                            <td scope="col" style="text-align: right" class="text-right bg-light-blue">{{ number_format($net_sales_amount, 2, '.', '') }}</td>
                                            <td scope="col" style="text-align: right" class="text-right bg-light-blue">{{ number_format($payment, 2, '.', '') }}</td>
                                            <td scope="col" style="text-align: right" class="text-right bg-light-blue">{{ number_format($refund, 2, '.', '') }}</td>
                                            <td scope="col" style="text-align: right" class="text-right bg-light-blue">{{ number_format($net_collection_amount, 2, '.', '') }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td class="text-center" scope="col" colspan="10" style="text-align: center;">No Data Available</td>
                                    </tr>
                                @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td class="text-right" scope="col" colspan="2"> <strong> Total = </strong></td>
                                    <td scope="col" style="text-align: center" class="text-center bg-light-blue">{{ $total_item_qty }}</td>
                                    <td scope="col" style="text-align: right" class="text-right bg-light-blue">{{ $total_sales }}</td>
                                    <td scope="col" style="text-align: right" class="text-right bg-light-blue">{{ $total_salesreturn }}</td>
                                    <td scope="col" style="text-align: right" class="text-right bg-light-blue">{{ number_format($total_discount, 2, '.', '') }}</td>
                                    <td scope="col" style="text-align: right" class="text-right bg-light-blue">{{ number_format($total_net_sales, 2, '.', '') }}</td>
                                    <td scope="col" style="text-align: right" class="text-right bg-light-blue">{{ number_format($total_payment, 2, '.', '') }}</td>
                                    <td scope="col" style="text-align: right" class="text-right bg-light-blue">{{ number_format($total_refund, 2, '.', '') }}</td>
                                    <td scope="col" style="text-align: right" class="text-right bg-light-blue">{{ number_format($total_net_collection, 2, '.', '') }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </main>
</body>

</html>
