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
                {{-- <td style=" text-align:right; width: 15%;  border:none;">
                    <div style="">
                        <img src="data:image/png;base64, {{ $barcode_no }} " width="100" />
                    </div>

                </td> --}}
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

                    Item Wise Financial Report

                </span>
            </div>
            <div style=" text-align:center;  width:100%; margin-bottom:10px" class="mb-2">


                <span class="report-date"><strong>From Date:
                        {{ $form_date != '' ? date('d/m/Y', strtotime($form_date)) : '' }} </strong> - <span
                        class="report-date"><strong>To Date:
                            {{ $to_date != '' ? date('d/m/Y', strtotime($to_date)) : '' }}</strong>
                    </span>
            </div>
            <section id="lp-items">
                <div class="container">
                    <div class="table-responsive border-top border-right">
                        <table class="table table-bordered table-hover mb-0 itemTable" width="100%">
                            <thead class="bg-light-blue">
                                <tr>
                                    <th style="text-align: center" scope="col">SL</th>
                                    <th scope="col">Test Name</th>
                                    <th style="text-align: center" scope="col">Today Item Qty</th>
                                    <th style="text-align: center" scope="col">No of Item</th>
                                    <th style="text-align: right" scope="col">Sales Amt.</th>
                                    <th style="text-align: right" scope="col">S. Charge </th>
                                    <th style="text-align: right" scope="col">Discount</th>

                                    <th style="text-align: right" scope="col">Net Payable Amt.</th>
                                    <th style="text-align: right" scope="col">Receive Amt.</th>
                                    {{-- <th scope="col"  style="text-align: right">Dues Amt.</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $service_charge = $current_item_qty = $total_item_amt = $disc_amount = $net_payable_total = $ledgerdtl_amt_payment = $due_total = $today_current_item_qty = 0;
                                @endphp
                                @if (!empty($serviceUnitData))
                                    @foreach ($serviceUnitData as $key => $rows)
                                        @php
                                            $dept_exp = explode('_', $key);
                                            $dept = '';
                                            if (!empty($dept_exp)) {
                                                $dept = $dept_exp[1];
                                            }
                                            $dep_service_charge = $dep_current_item_qty = $dep_total_item_amt = $dep_disc_amount = $dep_net_payable_total = $dep_ledgerdtl_amt_payment = $dep_due_total = $today_dep_current_item_qty = 0;
                                        @endphp
                                        <tr>
                                            <td class="text-left" colspan="9"> <strong> {{ $dept }} </strong>
                                            </td>
                                        </tr>
                                        @foreach ($rows as $row)
                                            @php
                                                $net_payable = $row->total_item_amt + $row->service_charge - $row->disc_amount;
                                                $due = $net_payable - $row->ledgerdtl_amt_payment;
                                            @endphp


                                            <tr>
                                                <td class="text-center " style="text-align: center">
                                                    {{ $loop->iteration }}</td>
                                                <td class="text-left">{{ $row->item_name }} </td>
                                                <td class="text-center" style="text-align: center">
                                                    {{ $row->todays_item_qty }} </td>
                                                <td class="text-center" style="text-align: center">
                                                    {{ $row->current_item_qty }} </td>
                                                <td class="text-right" style="text-align: right">
                                                    {{ number_format($row->total_item_amt, 2, '.', '') }}</td>
                                                <td class="text-right" style="text-align: right">
                                                    {{ number_format($row->service_charge, 2, '.', '') }}</td>
                                                <td class="text-right" style="text-align: right">
                                                    {{ number_format($row->disc_amount, 2, '.', '') }}</td>

                                                <td class="text-right" style="text-align: right">
                                                    {{ number_format($net_payable, 2, '.', '') }}</td>


                                                <td class="text-right" style="text-align: right">
                                                    {{ number_format(round($row->ledgerdtl_amt_payment), 2, '.', '') }}
                                                </td>
                                                {{-- <td class="text-right " style="text-align: right">{{ number_format($due, 2, '.', '') }}</td> --}}

                                            </tr>
                                            @php
                                                $dep_current_item_qty += $row->current_item_qty;
                                                $today_dep_current_item_qty += $row->todays_item_qty;
                                                $dep_total_item_amt += $row->total_item_amt;
                                                $dep_disc_amount += $row->disc_amount;
                                                $dep_net_payable_total += $net_payable;
                                                $dep_ledgerdtl_amt_payment += $row->ledgerdtl_amt_payment;
                                                $dep_due_total += $due;
                                                $dep_service_charge += $row->service_charge;
                                                
                                            @endphp
                                        @endforeach
                                        <tr>
                                            <td class="text-right" scope="col" colspan="2"
                                                style="text-align: right"> <strong> Department Total = </strong></td>
                                            <td scope="col" class="text-right bg-light-blue"
                                                style="text-align: center">{{ $today_dep_current_item_qty }}</td>
                                            <td scope="col" class="text-right bg-light-blue"
                                                style="text-align: center">{{ $dep_current_item_qty }}</td>
                                            <td scope="col" class="text-right bg-light-blue"
                                                style="text-align: right">
                                                {{ number_format($dep_total_item_amt, 2, '.', '') }}</td>
                                            <td scope="col" class="text-right bg-light-blue"
                                                style="text-align: right">
                                                {{ number_format($dep_service_charge, 2, '.', '') }}</td>
                                            <td scope="col" class="text-right bg-light-blue"
                                                style="text-align: right">
                                                {{ number_format($dep_disc_amount, 2, '.', '') }}</td>
                                            <td scope="col" class="text-right bg-light-blue"
                                                style="text-align: right">
                                                {{ number_format($dep_net_payable_total, 2, '.', '') }}</td>

                                            <td scope="col" class="text-right bg-light-blue"
                                                style="text-align: right">
                                                {{ number_format($dep_ledgerdtl_amt_payment, 2, '.', '') }}</td>

                                            {{-- <td scope="col" class="text-right bg-light-blue" style="text-align: right">{{ number_format($dep_due_total, 2, '.', '') }}</td> --}}

                                        </tr>

                                        @php
                                            $current_item_qty += $dep_current_item_qty;
                                            $today_current_item_qty += $today_dep_current_item_qty;
                                            $total_item_amt += $dep_total_item_amt;
                                            $disc_amount += $dep_disc_amount;
                                            $net_payable_total += $dep_net_payable_total;
                                            $ledgerdtl_amt_payment += $dep_ledgerdtl_amt_payment;
                                            $due_total += $dep_due_total;
                                            $service_charge += $dep_service_charge;
                                            
                                        @endphp
                                    @endforeach
                                @else
                                    <tr>
                                        <th class="text-center" scope="col" colspan="8">No Data Available</th>
                                    </tr>
                                @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td class="text-right" scope="col" colspan="2" style="text-align: right">
                                        <strong> Total = </strong> </td>
                                    <td scope="col" class="text-right bg-light-blue" style="text-align: center">
                                        {{ $today_current_item_qty }}</td>
                                    <td scope="col" class="text-right bg-light-blue" style="text-align: center">
                                        {{ $current_item_qty }}</td>
                                    <td scope="col" class="text-right bg-light-blue" style="text-align: right">
                                        {{ number_format($total_item_amt, 2, '.', '') }}</td>
                                    <td scope="col" class="text-right bg-light-blue" style="text-align: right">
                                        {{ number_format($service_charge, 2, '.', '') }}
                                    </td>
                                    <td scope="col" class="text-right bg-light-blue" style="text-align: right">
                                        {{ number_format($disc_amount, 2, '.', '') }}</td>
                                    <td scope="col" class="text-right bg-light-blue" style="text-align: right">
                                        {{ number_format($net_payable_total, 2, '.', '') }}
                                    </td>

                                    <td scope="col" class="text-right bg-light-blue" style="text-align: right">
                                        {{ number_format($ledgerdtl_amt_payment, 2, '.', '') }}</td>
                                    {{-- <td scope="col" class="text-right bg-light-blue" style="text-align: right">{{ number_format($due_total, 2, '.', '') }}</td> --}}

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
