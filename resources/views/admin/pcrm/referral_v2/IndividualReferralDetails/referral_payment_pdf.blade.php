<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Doctor Wise Income Summary</title>
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
    @if ($print_type == 'PDF')
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
                            <td style="font-size: 9px; text-align: right; border:none;"><strong>Powered By - H360
                                    [NextGen]
                                </strong></td>

                        </tr>
                    </table>
                </div>
            </div>
        </footer>
    @endif



    <main class="">
        <div class="wrapper">

            <section id="lp-items ">
                <div class="container ">

                    <div style="text-align: center; padding:5px">
                        <strong> Referral Payment Detail Report </strong>
                    </div>
                    <table width="100%">
                        <tr>

                            @if ($from_date != '' && $to_date != '')
                                <th style="text-align: left ;border:none;padding:5px;width:100px"> From date </th>
                                <td style="text-align: left ;border:none"> : {{ $from_date }}, <strong> To date
                                    </strong> : {{ $to_date }}</td>
                            @elseif ($from_date != '')
                                <th style="text-align: left ;border:none;padding:5px;width:100px"> Date</th>
                                <td style="text-align: left ;border:none"> : {{ $from_date }}</td>
                            @endif


                        </tr>
                    </table>



                    <table style="width:100%;border-collapse:collapse;" cellpadding="1" cellspacing="0" border="1">
                        <thead>
                            <br>
                            <tr>
                                <th class="text-center" style="background-color: rgb(214, 212, 212); text-align:center">SL#</th>
                                <th class="text-left" style="background-color: rgb(214, 212, 212);">Date</th>
                                <th class="text-left" style="background-color: rgb(214, 212, 212);">Ref Code</th>
                                <th class="text-left" style="background-color: rgb(214, 212, 212)">Referral Name
                                </th>
                                <th class="text-left" style="background-color: rgb(214, 212, 212)">1st Referral
                                    Name</th>
                                <th class="text-left" style="background-color: rgb(214, 212, 212)">2nd Referral
                                    Name </th>
                                <th class="text-left" style="background-color: rgb(214, 212, 212)">Invoice </th>
                                <th class="text-left" style="background-color: rgb(214, 212, 212)">Invoice Date
                                </th>
                                <th class="text-left" style="background-color: rgb(214, 212, 212)">Patient Name
                                </th>
                                <th  style="background-color: rgb(214, 212, 212); text-align:right">Invoice amount
                                </th>
                                <th  style="background-color: rgb(214, 212, 212); text-align:right">Discount</th>
                                <th  style="background-color: rgb(214, 212, 212); text-align:right">Referral Amount
                                </th>
                                <th  style="background-color: rgb(214, 212, 212); text-align:right">1st Referral
                                    Amount </th>
                                <th  style="background-color: rgb(214, 212, 212); text-align:right">2nd Referral
                                    Amount </th>
                                <th  style="background-color: rgb(214, 212, 212); text-align:right">Referral Paid
                                    amount </th>

                            </tr>



                        </thead>
                        <tbody>
                            @if (!empty($doctor_income))
                                @php
                                    $invoice_amt = 0;
                                    $discount = 0;
                                    $ref_amt = 0;
                                    $first_ref_amt = 0;
                                    $second_ref_amt = 0;
                                    $paid_amt = 0;

                                    $sl = 1;
                                @endphp

                                @foreach ($doctor_income as $data)
                                    <tr>
                                        <td style="text-align: center">{{ $sl++ }}</td>
                                        <td class="text-left">
                                            {{ $data->refinvoice_date != '' ? date('d/m/Y', strtotime($data->refinvoice_date)) : '' }}
                                        </td>
                                        <td class="text-left"></td>
                                        <td class="text-left">{{ $data->doctor_name }}</td>
                                        <td class="text-left">{{ $data->first_ref_doc_name }}</td>
                                        <td class="text-left">{{ $data->sec_ref_doc_name }}</td>
                                        <td class="text-left">{{ $data->invoice_no_pk }}</td>
                                        <td class="text-left">
                                            {{ $data->invoice_date != '' ? date('d/m/Y', strtotime($data->invoice_date)) : '' }}
                                        </td>

                                        <td class="text-left">{{ $data->patient_name }}</td>
                                        <td style="text-align: right">
                                            {{ number_format($data->ledger_amt_sales, 2) ?? 0 }}</td>
                                        <td style="text-align: right">
                                            {{ number_format($data->ledger_amt_discount, 2) ?? 0 }}</td>
                                        <td style="text-align: right">
                                            {{ number_format($data->referral_amount_doc, 2) ?? 0 }}</td>
                                        <td style="text-align: right">
                                            {{ number_format($data->referral_amount_first, 2) ?? 0 }}</td>
                                        <td style="text-align: right">
                                            {{ number_format($data->referral_amount_second, 2) ?? 0 }}</td>
                                        <td style="text-align: right">{{ number_format($data->paid_amount, 2) }}</td>
                                    </tr>
                                    @php
                                        $invoice_amt += $data->ledger_amt_sales;
                                        $discount += $data->ledger_amt_discount;
                                        $ref_amt += $data->referral_amount_doc;
                                        $first_ref_amt += $data->referral_amount_first;
                                        $second_ref_amt += $data->referral_amount_second;
                                        $paid_amt += $data->paid_amount;
                                    @endphp
                                @endforeach

                                <tr>
                                    <td style="text-align: right" colspan="9"> <strong> Total</strong></td>
                                    <td style="text-align: right" > <strong> {{ number_format($invoice_amt,2)}}</strong></td>
                                    <td style="text-align: right"> <strong> {{ number_format($discount,2)}}</strong></td>
                                    <td style="text-align: right"> <strong> {{ number_format($ref_amt,2)}}</strong></td>
                                    <td style="text-align: right"> <strong> {{ number_format($first_ref_amt,2)}}</strong></td>
                                    <td style="text-align: right"> <strong> {{number_format($second_ref_amt,2)}}</strong></td>
                                    <td style="text-align: right"> <strong> {{number_format($paid_amt,2)}}</strong></td>

                                </tr>
                            @endif

                        </tbody>

                    </table>
                </div>
            </section>
        </div>
    </main>

</body>

</html>
