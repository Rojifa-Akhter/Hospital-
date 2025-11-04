<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Lp Report</title>
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


        .page-break {
            page-break-before: always;
        }

    </style>
</head>

<body>
    <header>
        <table style="width: 100%;" class="signature">
            <tr>
                <td style="width: 20%;">
                    @if (!empty($po_hospital_details->logo))

                        <img class="hospital-logo"
                            src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}" width="60"
                            alt="">
                    @endif
                </td>
                <td style="text-align:center;">
                    <span style="font-size: 15px;"> <strong>
                            {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}
                        </strong></span> <br>
                    Address: <span>
                        {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</span><br>
                    Phone No: <span>
                        {{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</span>
                </td>
                <td style=" text-align:right; width: 15%; ">
                    <div style="">
                        <img src="data:image/png;base64, {{ $barcode_no }} " width="200" height="40" />
                    </div>

                </td>
            </tr>
        </table>
    </header>
    <div style="width: 100%;">
        <div style=" text-align:center; margin-bottom:5px; margin-top:15px  ">
            <span class="report-name" style="width:70%; border:solid black 1px; padding:10px;  "> Referral Performance
                Summary
                Report</span>
        </div>
        <div style=" text-align:center; margin-bottom:5px; margin-top:5px  ">

            @if ($from_date != '' && $to_date != '')
                <strong>From date :</strong> {{ $from_date }}, <strong> To date </strong> : {{ $to_date }}

            @else
                <strong> Date : </strong> {{ $from_date }}
            @endif
        </div>


    </div>

    <div class="signature_">
        <table style="width: 100%;">
            <tr style=" ">
                {{-- <td style="text-align:left; ">
                    <span style="padding:5px; border-top: black solid 1px;"> HR & ADMIN
                    </span>
                </td>
                <td style=" ">
                    <span style="padding:5px; border-top: black solid 1px;"> MANAGER (HOSPITAL SERVICE)
                    </span>
                </td>
                <td style=" ">
                    <span style="padding:5px; border-top: black solid 1px;"> ACCOUNT OFFICER
                    </span>
                </td>
                <td style=" ">
                    <span style="padding:5px; border-top: black solid 1px;"> GENERAL MANAGER
                    </span>
                </td> --}}
                <td style="text-align:right; ">
                    <span style="padding:5px; border-top: black solid 1px;"> MANAGER </span>
                </td>
            </tr>
        </table>
    </div>

    <footer class="">
        <div class="footer ">
            <div class="container">
                <table style="width: 100%; padding:3px; margin: 0">
                    <tr>
                        <td style="font-size: 9px; text-align:left;">Print Date: <strong>
                                @php
                                    date_default_timezone_set('Asia/Dhaka');
                                    $date = date('d/m/Y H:m:s');
                                @endphp
                                {{ $date }}
                            </strong> Printed By: <strong>{{ Session::get('user.ses_user_name') }}</strong></td>
                        <td style="font-size: 9px; text-align: right;"><strong>Powered By - H360 [NextGenIT]
                            </strong></td>
                    </tr>
                </table>
            </div>
        </div>
    </footer>


    <main class="">
        <div class="wrapper">

            <section id="lp-items ">
                <div class="container ">

                    <table style="width:100%;border-collapse:collapse;" cellpadding="1" cellspacing="0" border="1">
                        <thead>
                            <tr class="table-tr" style="background-color: #E3E3E3;  ">
                                <th class=" table-td"> <strong>SL# </strong></th>
                                <th class=" table-td"> <strong>Doctor Code </strong></th>
                                <th class=" table-td"> <strong>Doctor Name & Degree </strong></th>

                                <th class=" table-td"> <strong>Num.Inv </strong></th>
                                <th class=" table-td"> <strong>Total sale </strong></th>
                                <th class=" table-td"> <strong>Collection </strong></th>
                                <th class=" table-td"> <strong>Discount</strong></th>
                                <th class=" table-td"> <strong>Referral Amt. </strong></th>
                                <th class=" table-td" style="border-right: 1px solid #222"> <strong>Total Ref. Amt.
                                    </strong></th>
                            </tr>


                        </thead>
                        <tbody>
                            @if (isset($referral_arr))
                                @php
                                    $ledger_amt_sales = 0;
                                    $total_referral_amount = 0;
                                    $total_discount_amt_by_hos = 0;
                                    $total_discount_amt_by_doc = 0;
                                    $grand_total_referral_amount = 0;
                                    $ledger_amt_payment = 0;
                                    $net_total_referral_amount = 0;
                                    $total_referral_amt = 0;
                                    $i = 0;
                                    $sl = 1;
                                @endphp
                                @foreach ($referral_arr as $key => $value)
                                    @php
                                        $doc_id_exp = explode('_', $key);

                                    @endphp
                                    @if ($doc_id_exp[0] != 0 && $doc_id_exp[0] != '')
                                        @foreach ($value as $data)
                                            @php
                                                $ledger_amt_sales += $data->ledger_amt_sales;
                                                $total_referral_amount += 0; //$data->referral_amount;
                                                $total_discount_amt_by_hos += $data->ledger_amt_discount;
                                                $ledger_amt_payment += $data->ledger_amt_payment;
                                                $grand_total_referral_amount += $data->referral_amount_doc;
                                                $net_total_referral_amount += $data->referral_amount_doc - $data->ledger_amt_discount;
                                                $total_referral_amt = $data->referral_amount_doc - $data->ledger_amt_discount;
                                            @endphp
                                            <tr>
                                                <td class="text-center" style="text-align: center;padding:5px">
                                                    {{ $sl++ }}
                                                </td>
                                                <td class="text-left" style="padding:5px">
                                                    {{ $data->person_code }}
                                                </td>
                                                <td class="text-left" style="padding:5px">
                                                    {{ $data->doc_full_name }}
                                                </td>
                                                <td class="text-right" style="padding:5px; text-align:right">
                                                    {{ $data->count_inv }}
                                                </td>

                                                <td style="text-align: right;padding:5px">
                                                    {{ number_format($data->ledger_amt_sales, 2) }}
                                                </td>
                                                <td style="text-align: right;padding:5px">
                                                    {{ number_format($data->ledger_amt_payment, 2) }}
                                                </td>
                                                <td style="text-align: right;padding:5px">
                                                    {{ number_format($data->ledger_amt_discount, 2) }}
                                                </td>
                                                <td style="text-align: right;padding:5px">
                                                    {{ number_format($data->referral_amount_doc, 2) }}
                                                </td>
                                                <td style="text-align: right;padding:5px">
                                                    {{ number_format($total_referral_amt, 2) }}
                                                </td>

                                            </tr>
                                        @endforeach
                                    @endif
                                    @if ($doc_id_exp[1] != 0 && $doc_id_exp[1] != '')
                                        @foreach ($value as $data)
                                            @php
                                                $ledger_amt_sales += $data->ledger_amt_sales;
                                                $total_referral_amount += 0; //$data->referral_amount;
                                                $total_discount_amt_by_hos += $data->ledger_amt_discount;
                                                $ledger_amt_payment += $data->ledger_amt_payment;
                                                $grand_total_referral_amount += $data->referral_amount_first;
                                                $net_total_referral_amount += $data->referral_amount_first - $data->ledger_amt_discount;
                                                $total_referral_amt = $data->referral_amount_first - $data->ledger_amt_discount;
                                            @endphp
                                            <tr>
                                                <td class="text-center" style="text-align: center;padding:5px">
                                                    {{ $sl++ }}
                                                </td>
                                                <td class="text-left" style="padding:5px">
                                                    {{ $data->ref_first_person_code }}
                                                </td>
                                                <td class="text-left" style="padding:5px">
                                                    {{ $data->first_ref_doc_name }}
                                                </td>
                                                <td class="text-right" style="padding:5px ;text-align:right">
                                                    {{ $data->count_inv }}
                                                </td>

                                                <td style="text-align: right;padding:5px">
                                                    {{ number_format($data->ledger_amt_sales, 2) }}
                                                </td>
                                                <td style="text-align: right;padding:5px">
                                                    {{ number_format($data->ledger_amt_payment, 2) }}
                                                </td>
                                                <td style="text-align: right;padding:5px">
                                                    {{ number_format($data->ledger_amt_discount, 2) }}
                                                </td>
                                                <td style="text-align: right;padding:5px">
                                                    {{ number_format($data->referral_amount_first, 2) }}
                                                </td>
                                                <td style="text-align: right;padding:5px">
                                                    {{ number_format($total_referral_amt, 2) }}
                                                </td>

                                            </tr>
                                        @endforeach
                                    @endif
                                    @if ($doc_id_exp[2] != 0 && $doc_id_exp[2] != '')
                                        @foreach ($value as $data)
                                            @php
                                                $ledger_amt_sales += $data->ledger_amt_sales;
                                                $total_referral_amount += 0; //$data->referral_amount;
                                                $total_discount_amt_by_hos += $data->ledger_amt_discount;
                                                $ledger_amt_payment += $data->ledger_amt_payment;
                                                $grand_total_referral_amount += $data->referral_amount_second;
                                                $net_total_referral_amount += $data->referral_amount_second - $data->ledger_amt_discount;
                                                $total_referral_amt = $data->referral_amount_second - $data->ledger_amt_discount;
                                            @endphp
                                            <tr>
                                                <td class="text-center" style="text-align: center;padding:5px">
                                                    {{ $sl++ }}
                                                </td>
                                                <td class="text-left" style="padding:5px">
                                                    {{ $data->ref_scn_person_code }}
                                                </td>
                                                <td class="text-left" style="padding:5px">
                                                    {{ $data->second_ref_doc_name }}
                                                </td>
                                                <td class="text-right" style="padding:5px ;text-align:right">
                                                    {{ $data->count_inv }}
                                                </td>

                                                <td style="text-align: right;padding:5px">
                                                    {{ number_format($data->ledger_amt_sales, 2) }}
                                                </td>
                                                <td style="text-align: right;padding:5px">
                                                    {{ number_format($data->ledger_amt_payment, 2) }}
                                                </td>
                                                <td style="text-align: right;padding:5px">
                                                    {{ number_format($data->ledger_amt_discount, 2) }}
                                                </td>
                                                <td style="text-align: right;padding:5px">
                                                    {{ number_format($data->referral_amount_second, 2) }}
                                                </td>
                                                <td style="text-align: right;padding:5px">
                                                    {{ number_format($total_referral_amt, 2) }}
                                                </td>

                                            </tr>
                                        @endforeach
                                    @endif
                                @endforeach
                                <tr>
                                    <td colspan="7" style="text-align: right"> <strong> grand total
                                        </strong> </td>
                                    {{-- <td style="text-align: right;padding:5px">
                                        <strong>{{ number_format($ledger_amt_sales, 2) }}
                                </strong>
                                </td>
                                <td style="text-align: right;padding:5px">
                                    <strong>{{ number_format($ledger_amt_payment, 2) }} </strong>
                                </td>
                                <td style="text-align: right;padding:5px">
                                    <strong>{{ number_format($total_discount_amt_by_hos, 2) }} </strong>
                                </td> --}}
                                    <td style="text-align: right;padding:5px">
                                        <strong>{{ number_format($grand_total_referral_amount, 2) }} </strong>
                                    </td>
                                    <td style="text-align: right;padding:5px"> <strong>
                                            {{ number_format($net_total_referral_amount, 2) }}</strong> </td>
                                </tr>
                            @endif
                        </tbody>
                        <tbody>
                            @php
                                $listSl = 0;
                            @endphp
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </main>


    <div class="signature_">
        <table style="width: 100%;">
            <tr style=" ">
                {{-- <td style="text-align:left; ">
                    <span style="padding:5px; border-top: black solid 1px;"> HR & ADMIN
                    </span>
                </td>
                <td style=" ">
                    <span style="padding:5px; border-top: black solid 1px;"> MANAGER (HOSPITAL SERVICE)
                    </span>
                </td>
                <td style=" ">
                    <span style="padding:5px; border-top: black solid 1px;"> ACCOUNT OFFICER
                    </span>
                </td>
                <td style=" ">
                    <span style="padding:5px; border-top: black solid 1px;"> GENERAL MANAGER
                    </span>
                </td> --}}
                {{-- <td style="text-align:left; ">
                    <span style="padding:5px; border-top: black solid 1px;"> MANAGER </span>
                </td> --}}
            </tr>
        </table>
    </div>

    <footer class="">
        <div class="footer ">
            <div class="container">
                <table style="width: 100%; padding:3px; margin: 0">
                    <tr>
                        <td style="font-size: 9px; text-align:left;">Print Date: <strong>
                                @php
                                    date_default_timezone_set('Asia/Dhaka');
                                    $date = date('d/m/Y H:m:s');
                                @endphp
                                {{ $date }}
                            </strong> Printed By: <strong>{{ Session::get('user.ses_user_name') }}</strong></td>
                        <td style="font-size: 9px; text-align: right;"><strong>Powered By - H360 [NextGenIT]
                            </strong></td>
                    </tr>
                </table>
            </div>
        </div>
    </footer>
</body>

</html>
