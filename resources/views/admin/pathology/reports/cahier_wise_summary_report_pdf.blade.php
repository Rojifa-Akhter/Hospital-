<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Cashier Wise Summary Report</title>
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
    </style>

</head>

<body>
    <header>
        <table style="width: 100%; border:none;" class="signature">
            <tr>
                <td style="width: 15%; border:none;">
                    <img class="hospital-logo"
                        src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}"
                        width="60" alt="">
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
            <div style=" text-align:center; margin-bottom:5px; margin-top:20px  " class="mb-2">
                <span class="report-name" style="width:70%; border:solid black 1px; padding:10px;  ">
                    Cashier Wise Summary Report
                </span>
            </div>
            <div style=" text-align:center;  width:100%; margin-bottom:10px" class="mb-2">

                <span class="report-date"><strong>From Date: {{ $from_date }}</strong> - <span
                        class="report-date"><strong>To Date: {{ $to_date }}</strong>
                    </span>
            </div>
            <section id="lp-items">
                <div class="container">
                    <table style="width: 100%;border-spacing: 0;" cellpadding="1">
                        <thead class="bg-soft-green">
                            <tr class="table-tr" style="background-color: #E3E3E3;border:1px solid black">
                                <th class="bg-soft-green text-center table-td" scope="col">Sl</th>
                                <th class="bg-soft-green text-center table-td" scope="col">Date</th>
                                <th class="bg-soft-green text-center table-td" scope="col">Cashier Name</th>
                                <th class="bg-soft-green text-center table-td" scope="col">No of Invoice</th>
                                <th class="bg-soft-green text-center table-td" scope="col" style="text-align:right">Sales</th>
                                <th class="bg-soft-green text-center table-td" scope="col" style="text-align:right">Discount</th>
                                <th class="bg-soft-green text-center table-td" scope="col" style="text-align:right">Net Sales</th>
                                <th class="bg-soft-green text-center table-td" scope="col" style="text-align:right">Collection</th>
                                {{-- <th class="bg-soft-green text-center table-td" scope="col" style="text-align:right">Due</th> --}}
                                <th class="bg-soft-green text-center table-td" scope="col" style="text-align:right">Refund</th>
                                <th class="bg-soft-green text-center table-td" scope="col" style="text-align:right">Net Collection</th>
                            </tr>
                        </thead>

                        <tbody>
                            @php
                                $total_payable = $total_discount = $total_net_payable = $total_paid = $total_due = $total_dis = $total_refund = $total_pay = $total_net_col = 0;
                            @endphp
                            @if (!empty($report_data))
                                @foreach ($report_data as $row)
                                    @php
                                        $due = 0;
                                        $net_col = 0;
                                        $refund = 0;

                                    @endphp
                                    <tr>
                                        <td class="border-1 bg-light text-center" style="text-align: center;">
                                            {{ $loop->iteration }}
                                        </td>
                                        <td class="text-left" scope="col">
                                            {{ date('d/m/Y', strtotime($row->invoice_date)) }}</td>

                                        <td class="bg-soft-green text-center table-td" scope="col">{{ ucfirst($row->full_name) }}</td>
                                        <td class="text-left" scope="col" style="text-align:right">{{ $row->total_invoice_cnt }}</td>
                                        <td scope="col" class="text-right" style="text-align:right">{{ number_format($row->sales, 2) }}
                                        </td>
                                        <td scope="col" class="text-right" style="text-align:right">{{ number_format($row->discount, 2) }}
                                        </td>
                                        <td scope="col" class="text-right" style="text-align:right">{{ number_format($row->net_sales, 2) }}
                                        </td>
                                        <td scope="col" class="text-right" style="text-align:right">
                                            {{ number_format($row->collection, 2) }}</td>
                                        {{-- <td scope="col" class="text-right" style="text-align:right">{{ number_format($row->due, 2) }}</td> --}}
                                        <td scope="col" class="text-right" style="text-align:right">{{ number_format($row->refund, 2) }}
                                        </td>

                                        <td scope="col" class="text-right" style="text-align:right">
                                            {{ number_format($row->net_collection, 2) }}</td>
                                    </tr>
                                    @php
                                        $total_payable += $row->total_invoice_cnt;
                                        $total_pay += $row->sales;
                                        $total_dis += $row->discount;
                                        $total_net_payable += $row->net_sales;
                                        $total_paid += $row->collection;
                                        $total_due += $row->due;
                                        $total_refund += $row->refund;
                                        $total_net_col += $row->net_collection;
                                    @endphp
                                @endforeach
                            @else
                                <tr>
                                    <th class="text-center" scope="col" colspan="10">No Data Available</th>
                                </tr>
                            @endif
                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="text-right" scope="col" colspan="3" style="text-align:right">Total = </th>
                                <th scope="col" class="text-left bg-light-blue" style="text-align:right">{{ $total_payable }}</th>
                                <th scope="col" class="text-right bg-light-blue" style="text-align:right">
                                    {{ number_format($total_pay, 2, '.', '') }}</th>
                                <th scope="col" class="text-right bg-light-blue" style="text-align:right">
                                    {{ number_format($total_dis, 2, '.', '') }}</th>
                                <th scope="col" class="text-right bg-light-blue" style="text-align:right">
                                    {{ number_format($total_net_payable, 2, '.', '') }}
                                </th>
                                <th scope="col" class="text-right bg-light-blue" style="text-align:right">
                                    {{ number_format($total_paid, 2, '.', '') }}</th>
                                {{-- <th scope="col" class="text-right bg-light-blue" style="text-align:right">
                                    {{ number_format($total_due, 2, '.', '') }}</th> --}}
                                <th scope="col" class="text-right bg-light-blue" style="text-align:right">
                                    {{ number_format($total_refund, 2, '.', '') }}</th>
                                <th scope="col" class="text-right bg-light-blue" style="text-align:right">
                                    {{ number_format($total_net_col, 2, '.', '') }}</th>


                            </tr>
                        </tfoot>
                    </table>
                </div>
            </section>
        </div>
    </main>




</body>

</html>
