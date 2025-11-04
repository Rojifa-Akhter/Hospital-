<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Refferal Report</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

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
            height: 2.0cm;
            border-bottom: 1px solid;
            padding: 0 1cm;
        }

        header img {
            /*width: 80px;*/
        }

        /** Define now the real margins of every page in the PDF **/
        body {
            margin-top: 2.0cm;
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

@if (count($doctor_income_opd) > 0)

    <body>
        @if ($print_type == 'PDF')
            <header>
                <table style="width: 100%; border:none;" class="signature">
                    <tr>


                        <td style="text-align:center; border:none;">
                            <span style="font-size: 25px;"> <strong>
                                    {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}
                                </strong></span>
                            <br>

                            <span style="font-size: 10px;">
                                Address:
                                {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</span><br>

                            <span style="font-size: 10px;">
                                Phone No:
                                {{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</span>
                        </td>

                    </tr>
                </table>
            </header>
        @endif


        @php
            $prev_date = date('d-m-Y', strtotime('-1 months', strtotime($from_date)));
            $end_date = date('t-m-Y', strtotime($prev_date));
        @endphp
        <main class="">
            <div class="wrapper">

                <section id="lp-items ">
                    <div class="container ">

                        <span style="font-size: 15px;">To</span> <br>
                        <span
                            style="font-size: 15px;">{{ isset($employee->full_name) ? $employee->full_name : '' }}</span><br><br>
                        <span style="font-size: 15px;"><strong>Respected Sir / Madam, </strong></span> <br> <br>
                        <span style="font-size: 15px;">Assalamu-Alai-kum. Hope You and your family members are well and
                            Good. We are happy to settle your
                            refferal patients statement. <br> From
                            01-{{ date('m-Y', strtotime($prev_date)) }} to
                            {{ $end_date }}
                        </span><br>

                        @if (count($doctor_income_opd) > 0)

                            <table style="width:100%;border-collapse:collapse;" cellpadding="1" cellspacing="0"
                                border="1">
                                <thead>
                                    <br>
                                    <tr>

                                        <th class="text-left"
                                            style="text-align: center;background-color: rgb(214, 212, 212)">
                                            Invoice </th>
                                        <th class="text-left"
                                            style="text-align: center;background-color: rgb(214, 212, 212)">
                                            Invoice Date
                                        </th>
                                        <th class="text-left"
                                            style="text-align: center;background-color: rgb(214, 212, 212)">
                                            Patient Name
                                        </th>
                                        <th style="background-color: rgb(214, 212, 212); text-align:right">Bill Amt
                                        </th>
                                        <th style="background-color: rgb(214, 212, 212); text-align:right">Discount</th>
                                        <th style="background-color: rgb(214, 212, 212); text-align:right">Payable Amt
                                        </th>
                                        <th style="background-color: rgb(214, 212, 212); text-align:right">Paid</th>
                                        <th style="background-color: rgb(214, 212, 212); text-align:right">Due</th>

                                        <th style="background-color: rgb(214, 212, 212); text-align:right">Reff.
                                            Amount </th>
                                        <th style="background-color: rgb(214, 212, 212); text-align:right">Paid
                                            Amount </th>


                                    </tr>



                                </thead>
                                <tbody>

                                    @if (!empty($doctor_income_opd))
                                        @php
                                            $invoice_amt = 0;
                                            $discount = 0;
                                            $ref_amt = 0;
                                            $first_ref_amt = 0;
                                            $second_ref_amt = 0;
                                            $paid_amt = 0;
                                            $payable = 0;
                                            $paid = 0;
                                            $due = 0;
                                            $sl = 1;
                                        @endphp

                                        @foreach ($doctor_income_opd as $data)
                                            <tr>

                                                <td style="text-align: center">{{ $data->invoice_no_pk }}</td>
                                                <td style="text-align: center">
                                                    {{ $data->invoice_date != '' ? date('d/m/Y', strtotime($data->invoice_date)) : '' }}
                                                </td>

                                                <td style="text-align: center">{{ $data->patient_name }}</td>
                                                <td style="text-align: right">
                                                    {{ number_format($data->ledger_amt_sales, 2) ?? 0 }}</td>
                                                <td style="text-align: right">
                                                    {{ number_format($data->ledger_amt_discount, 2) ?? 0 }}</td>
                                                <td style="text-align: right">
                                                    {{ number_format($data->ledger_amt_sales_net, 2) ?? 0 }}</td>
                                                <td style="text-align: right">
                                                    {{ number_format($data->ledger_amt_payment, 2) ?? 0 }}</td>


                                                <td style="text-align: right">
                                                    {{ number_format($data->ledger_amt_sales_net - $data->ledger_amt_payment, 2) ?? 0 }}
                                                </td>

                                                <td style="text-align: right">
                                                    @if ($data->referral_amount_doc != 0)
                                                        {{ number_format($data->referral_amount_doc, 2) ?? 0 }}
                                                    @endif
                                                    @if ($data->referral_amount_first != 0)
                                                        {{ number_format($data->referral_amount_first, 2) ?? 0 }}
                                                    @endif
                                                    @if ($data->referral_amount_second != 0)
                                                        {{ number_format($data->referral_amount_second, 2) ?? 0 }}
                                                    @endif

                                                </td>
                                                <td style="text-align: right">                                                   
                                                        {{ number_format($data->paid_amount, 2) ?? 0 }}                                                 

                                                </td>

                                            </tr>
                                            @php
                                                $invoice_amt += $data->ledger_amt_sales;
                                                $discount += $data->ledger_amt_discount;
                                                $ref_amt += $data->referral_amount_doc;

                                                if ($data->referral_amount_doc != 0) {
                                                    $first_ref_amt += $data->referral_amount_doc;
                                                }
                                                if ($data->referral_amount_first != 0) {
                                                    $first_ref_amt += $data->referral_amount_first;
                                                }
                                                if ($data->referral_amount_second != 0) {
                                                    $first_ref_amt += $data->referral_amount_second;
                                                }
                                                $second_ref_amt += $data->referral_amount_second;
                                                $paid_amt += $data->paid_amount;
                                                $payable += $data->ledger_amt_sales_net;
                                                $paid += $data->ledger_amt_payment;
                                                $due += $data->ledger_amt_sales_net - $data->ledger_amt_payment;
                                            @endphp
                                        @endforeach

                                        <tr>
                                            <td style="text-align: right" colspan="3"> <strong> Total</strong></td>
                                            <td style="text-align: right"> <strong>
                                                    {{ number_format($invoice_amt, 2) }}</strong></td>
                                            <td style="text-align: right"> <strong>
                                                    {{ number_format($discount, 2) }}</strong>
                                            </td>
                                            <td style="text-align: right"> <strong>
                                                    {{ number_format($payable, 2) }}</strong>
                                            </td>
                                            <td style="text-align: right"> <strong>
                                                    {{ number_format($paid, 2) }}</strong>
                                            </td>
                                            <td style="text-align: right"> <strong>
                                                    {{ number_format($due, 2) }}</strong>
                                            </td>

                                            <td style="text-align: right"> <strong>
                                                    {{ number_format($first_ref_amt, 2) }}</strong></td>
                                            <td style="text-align: right"> <strong>
                                                    {{ number_format($paid_amt, 2) }}</strong></td>
                                        </tr>

                                    @endif
                                </tbody>

                            </table>
                        @endif

                        <span>
                            Thanks you very much for co-operation to serve your patients
                        </span>
                        <br>
                        <span>
                            <strong>[N.B. IF ANY QUERY PLEASE INFORM US]</strong>
                        </span>
                    </div>
                   
                    @if ($print_type == 'PDF')
                        <div class="" style="margin-top: 45px">
                            <table style="width: 100%; border:none;">
                                <tr style=" ">
                                    <td style="text-align:left; border:none;">
                                        <span style="padding:5px; border-top: black solid 1px;">Received By
                                        </span>
                                    </td>
                                    <td style="text-align:left; border:none;">
                                        <span style="padding:5px; border-top: black solid 1px;">Checked By
                                        </span>
                                    </td>
                                    <td style="text-align:left; border:none;">
                                        <span style="padding:5px; border-top: black solid 1px;"> Accounts Dept.
                                        </span>
                                    </td>
                                    <td style="text-align:right; border:none;">
                                        <span style="padding:5px; border-top: black solid 1px;"> DGM </span>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div style="margin-top: 45px;border-top:1px solid black">
                            <div class="container">
                                <table style="width: 100%; padding:3px; margin: 0;border:none;">
                                    <tr>
                                        <td style="font-size: 9px; text-align:left;border:none;">Print Date & Time:
                                            <strong>
                                                <?php
                                                $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
                                                $date = $dt->format('g:i A');
                                                ?>
                                                {{ date('d/m/Y') }} {{ $date }}
                                            </strong> Printed By:
                                            <strong>{{ Session::get('user.ses_user_name') }}</strong>
                                        </td>
                                        <td style="font-size: 9px; text-align: right; border:none;"><strong>Powered By -
                                                H360
                                                [NextGen]
                                            </strong></td>

                                    </tr>
                                </table>
                            </div>
                        </div>
                    @endif
                </section>
            </div>
        </main>

    </body>

@endif

@if (count($doctor_income_ipd) > 0)
    @if (count($doctor_income_opd) > 0)
        <div class="page-break"></div>
    @endif

    <body>
        @if ($print_type == 'PDF')
            <header>
                <table style="width: 100%; border:none;" class="signature">
                    <tr>


                        <td style="text-align:center; border:none;">
                            <span style="font-size: 25px;"> <strong>
                                    {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}
                                </strong></span>
                            <br>

                            <span style="font-size: 10px;">
                                Address:
                                {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</span><br>

                            <span style="font-size: 10px;">
                                Phone No:
                                {{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</span>
                        </td>

                    </tr>
                </table>
            </header>
        @endif

        @php
            $prev_date = date('d-m-Y', strtotime('-1 months', strtotime($from_date)));
            $end_date = date('t-m-Y', strtotime($prev_date));
        @endphp

        <main class="">
            <div class="wrapper">

                <section id="lp-items ">
                    <div class="container ">

                        <span style="font-size: 15px;">To</span> <br>
                        <span
                            style="font-size: 15px;">{{ isset($employee->full_name) ? $employee->full_name : '' }}</span><br><br>
                        <span style="font-size: 15px;"><strong>Respected Sir / Madam, </strong></span> <br> <br>
                        <span style="font-size: 15px;">Assalamu-Alai-kum. Hope You and your family members are well and
                            Good. We are happy to settle your
                            refferal patients statement. <br> From 01-{{ date('m-Y', strtotime($prev_date)) }} to
                            {{ $end_date }}
                        </span><br>

                        @if (count($doctor_income_ipd) > 0)

                            <table style="width:100%;border-collapse:collapse;" cellpadding="1" cellspacing="0"
                                border="1">
                                <thead>
                                    <br>
                                    <tr>

                                        <th class="text-left"
                                            style="text-align: center;background-color: rgb(214, 212, 212)">
                                            Admission No </th>
                                        <th class="text-left"
                                            style="text-align: center;background-color: rgb(214, 212, 212)">
                                            Admission Date
                                        </th>
                                        <th class="text-left"
                                            style="text-align: center;background-color: rgb(214, 212, 212)">
                                            Patient Name
                                        </th>
                                        <th style="background-color: rgb(214, 212, 212); text-align:right">Payable
                                        </th>
                                        <th style="background-color: rgb(214, 212, 212); text-align:right">Reff. Fee
                                        </th>
                                        <th style="background-color: rgb(214, 212, 212); text-align:right">Paid Amt.
                                        </th>
                                        <th style="background-color: rgb(214, 212, 212); text-align:center">Reff. Type
                                        </th>


                                    </tr>



                                </thead>
                                <tbody>
                                    @if (!empty($doctor_income_ipd))
                                        @php
                                            $invoice_amt = 0;
                                            $discount = 0;
                                            $ref_amt = 0;
                                            $first_ref_amt = 0;
                                            $second_ref_amt = 0;
                                            $paid_amt = 0;
                                            $ref_paid_amt = 0;
                                            $payable = 0;
                                            $paid = 0;
                                            $due = 0;
                                            $sl = 1;
                                        @endphp
                                        
                                        @foreach ($doctor_income_ipd as $data)
                                            <tr>

                                                <td style="text-align: center">{{ $data->admission_no_pk }}</td>
                                                <td style="text-align: center">
                                                    {{ $data->admission_date != '' ? date('d/m/Y', strtotime($data->admission_date)) : '' }}
                                                </td>

                                                <td style="text-align: center">{{ $data->patient_name }}</td>
                                                <td style="text-align: right">
                                                    {{ number_format($data->ledger_amt_sales, 2) ?? 0 }}</td>

                                                <td style="text-align: right">
                                                    @if ($data->referral_amount_doc != 0)
                                                        {{ number_format($data->referral_amount_doc, 2) ?? 0 }}
                                                    @endif
                                                    @if ($data->referral_amount_first != 0)
                                                        {{ number_format($data->referral_amount_first, 2) ?? 0 }}
                                                    @endif
                                                    @if ($data->referral_amount_second != 0)
                                                        {{ number_format($data->referral_amount_second, 2) ?? 0 }}
                                                    @endif
                                                </td>
                                                <td style="text-align: right">
                                                   
                                                        {{ number_format($data->paid_amount, 2) ?? 0 }}
                                                   
                                                </td>
                                                <td style="text-align: center">
                                                    {{ isset($data->item_ref_code) ? $data->item_ref_code : 'GEN' }}
                                                </td>

                                            </tr>

                                            @php
                                                $invoice_amt += $data->ledger_amt_sales;
                                                if ($data->referral_amount_doc != 0) {
                                                    $first_ref_amt += $data->referral_amount_doc;
                                                }
                                                if ($data->referral_amount_first != 0) {
                                                    $first_ref_amt += $data->referral_amount_first;
                                                }
                                                if ($data->referral_amount_second != 0) {
                                                    $first_ref_amt += $data->referral_amount_second;
                                                }

                                                // $first_ref_amt += $data->referral_amount_first;
                                                $ref_paid_amt += $data->paid_amount;

                                            @endphp
                                        @endforeach

                                        <tr>
                                            <td style="text-align: right" colspan="3"> <strong> Total</strong></td>
                                            <td style="text-align: right"> <strong>
                                                    {{ number_format($invoice_amt, 2) }}</strong></td>


                                            <td style="text-align: right"> <strong>
                                                    {{ number_format($first_ref_amt, 2) }}</strong></td>
                                            <td style="text-align: right"> <strong>
                                                    {{ number_format($ref_paid_amt , 2) }}</strong></td>
                                            <td></td>



                                        </tr>
                                    @endif

                                </tbody>

                            </table>

                        @endif

                        <span>
                            Thanks you very much for co-operation to serve your patients
                        </span>
                        <br>
                        <span>
                            <strong>[N.B. IF ANY QUERY PLEASE INFORM US]</strong>
                        </span>
                    </div>

                    @if ($print_type == 'PDF')
                        <div class="" style="margin-top: 45px">
                            <table style="width: 100%; border:none;">
                                <tr style=" ">
                                    <td style="text-align:left; border:none;">
                                        <span style="padding:5px; border-top: black solid 1px;">Received By
                                        </span>
                                    </td>
                                    <td style="text-align:left; border:none;">
                                        <span style="padding:5px; border-top: black solid 1px;">Checked By
                                        </span>
                                    </td>
                                    <td style="text-align:left; border:none;">
                                        <span style="padding:5px; border-top: black solid 1px;"> Accounts Dept.
                                        </span>
                                    </td>
                                    <td style="text-align:right; border:none;">
                                        <span style="padding:5px; border-top: black solid 1px;"> DGM </span>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div style="margin-top: 45px;border-top:1px solid black">
                            <div class="container">
                                <table style="width: 100%; padding:3px; margin: 0;border:none;">
                                    <tr>
                                        <td style="font-size: 9px; text-align:left;border:none;">Print Date & Time:
                                            <strong>
                                                <?php
                                                $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
                                                $date = $dt->format('g:i A');
                                                ?>
                                                {{ date('d/m/Y') }} {{ $date }}
                                            </strong> Printed By:
                                            <strong>{{ Session::get('user.ses_user_name') }}</strong>
                                        </td>
                                        <td style="font-size: 9px; text-align: right; border:none;"><strong>Powered By
                                                -
                                                H360
                                                [NextGen]
                                            </strong></td>

                                    </tr>
                                </table>
                            </div>
                        </div>
                    @endif

                </section>
            </div>
        </main>

    </body>
@endif

</html>
