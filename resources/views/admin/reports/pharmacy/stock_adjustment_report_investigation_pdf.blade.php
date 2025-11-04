<?php
$po_hospital_details = DB::table('WSEC_HOSPITAL')->first();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Item Wise Report Print</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="" />
    <!-- custom style -->
    {{-- <link rel="stylesheet" href="{{ public_path() . '/css/colors.css' }}" media="all"> --}}

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

        .text-center {
            text-align: center
        }

        .text-right {
            text-align: right
        }
    </style>

</head>

<body>
    <header>
        <table style="width: 100%; border:none;" class="signature">
            <tr>
                <td style="width: 15%; border:none;">
                    <img class="hospital-logo"
                        src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}" width="60"
                        alt="">
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
                <td style=" text-align:right; width: 15%;  border:none;">
                    <div style="">
                        <img src="data:image/png;base64, {{ $barcode_no }} " width="100" />
                    </div>

                </td>
            </tr>
        </table>
    </header>





    <footer style="position: fixed;">
        <div class="footer">
            <div class="container">
                <table style="width: 100%; padding:3px; margin: 0;border:none;">
                    <tr>
                        <td style="font-size: 9px; text-align:left;border:none;">Print Date & Time: <strong>
                                <?php
                                $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
                                $date = $dt->format('g:i A');
                                ?>
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
            <section id="prescription">
                <div class="container">
                    <div style=" text-align:center; margin-bottom:5px; margin-top:20px  " class="mb-2"> <span
                            class="report-name" style="width:70%; border:solid black 1px; padding:10px;  ">
                            Item Wise Report Print
                        </span>
                    </div>

                    <div style=" text-align:center;  width:100%; margin-bottom:10px" class="mb-2">


                        <span class="report-date"><strong>From Date: {{ $from_date }}</strong> - <span
                                class="report-date"><strong>To Date: {{ $to_date }}</strong>
                            </span>
                    </div>

                    <div>

                        <table class="Medical_Category  m-0" width="100%">
                            <thead class="bg-black" style="background-color: rgb(187, 183, 183);">
                                <tr>
                                    <th class="text-center">SL#</th>
                                    <th class="text-center">Date </th>
                                    <th class="text-center">Item Name</th>
                                    {{-- <th class="text-center">UoM</th> --}}

                                    <th class="text-right">Price</th>
                                    {{-- <th class="text-center">Counter Name</th> --}}
                                    <th class="text-center">Sales Qty</th>
                                    <th class="text-center">Cancel Qty</th>
                                    <th class="text-center">Actual Qty</th>
                                    {{-- <th class="text-center">Issue</th>
                                    <th class="text-center">Others</th> --}}
                                </tr>
                            </thead>
                            <tbody>


                                @php
                                    // $str1 = $cashier_arr;
                                    // dd($str1);
                                    // $service_point = (explode("_",$str));
                                    $total_sales_qty = $total_cancel_qty = $total_item_qty = 0;
                                @endphp

                                @if (!empty($stock_reports))
                                    @foreach ($stock_reports as $stock)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ date('d/m/Y', strtotime($stock->invoice_date)) }}</td>
                                            <td>{{ $stock->bill_item_name }}</td>
                                            {{-- <td class="text-center">{{ $stock->bill_uom_name }}</td> --}}
                                            <td class="text-right">{{ number_format($stock->item_rate, '2', '.', '') }}
                                            </td>
                                            <td class="text-center">
                                                {{ !empty($stock->item_qty) ? $stock->item_qty : 0 }}
                                            </td>
                                            <td class="text-center">
                                                {{ !empty($stock->cancel_qty) ? $stock->cancel_qty : 0 }}</td>
                                            <td class="text-center">
                                                {{ !empty($stock->sales_item_qty) ? $stock->sales_item_qty : 0 }}</td>
                                        </tr>
                                        <div style="display: none">{{ $total_sales_qty += $stock->sales_item_qty }}
                                        </div>
                                        <div style="display: none">{{ $total_cancel_qty += $stock->cancel_qty }}</div>
                                        <div style="display: none">{{ $total_item_qty += $stock->item_qty }}</div>
                                    @endforeach

                                @endif

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th class="text-right" colspan="4">Total =</th>
                                    <th class="text-center bg-light-blue">{{ $total_item_qty }}</th>
                                    <th class="text-center bg-light-blue">{{ $total_cancel_qty }}</th>
                                    <th class="text-center bg-light-blue">{{ $total_sales_qty }}</th>
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
