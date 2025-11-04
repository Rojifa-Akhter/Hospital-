{{--<!DOCTYPE html>--}}
{{--<html>--}}

{{--<head>--}}
{{--    <meta charset="utf-8">--}}
{{--    <meta http-equiv="X-UA-Compatible" content="IE=edge">--}}
{{--    <title>Referral Bill Payment</title>--}}
{{--    <!-- Tell the browser to be responsive to screen width -->--}}
{{--    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">--}}

{{--    <style>--}}
{{--        @page {--}}
{{--            margin: .5cm .6cm;--}}
{{--            width: 100%;--}}
{{--            height: 100%--}}
{{--        }--}}

{{--        @font-face {--}}
{{--            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';--}}
{{--            font-weight: normal;--}}
{{--            font-size: 10px;--}}
{{--            font-style: normal;--}}
{{--            font-variant: normal;--}}
{{--            src: url("font url");--}}
{{--        }--}}


{{--        /** Define the header rules **/--}}
{{--        header {--}}
{{--            position: fixed;--}}
{{--            top: 0;--}}
{{--            height: 2cm;--}}
{{--            border-bottom: 1px solid;--}}
{{--            padding: 0 1cm;--}}
{{--        }--}}

{{--        header img {--}}
{{--            /*width: 80px;*/--}}
{{--        }--}}

{{--        /** Define now the real margins of every page in the PDF **/--}}
{{--        body {--}}
{{--            margin-top: 2cm;--}}
{{--            margin-left: .3cm;--}}
{{--            margin-right: .3cm;--}}
{{--            margin-bottom: 2cm;--}}
{{--            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';--}}
{{--            font-size: 11px;--}}
{{--        }--}}

{{--        footer {--}}
{{--            position: fixed;--}}
{{--            bottom: 0cm;--}}
{{--            left: 0cm;--}}
{{--            right: 0cm;--}}
{{--            height: .7cm;--}}
{{--            text-align: center;--}}
{{--            padding: 0 1cm;--}}
{{--            border-top: 1px solid;--}}


{{--        }--}}

{{--        .signature_ {--}}
{{--            position: fixed;--}}
{{--            bottom: 1.6cm;--}}
{{--            left: .8cm;--}}
{{--            right: .8cm;--}}
{{--            width: 100%;--}}
{{--            /* text-align: center; */--}}

{{--            /* border-top: 1px solid; */--}}
{{--        }--}}

{{--        tfoot tr td {--}}
{{--            font-weight: bold;--}}
{{--        }--}}

{{--        .page-break {--}}
{{--            page-break-after: always;--}}
{{--        }--}}

{{--        .mt-5 {--}}
{{--            margin-top: 5px;--}}
{{--        }--}}

{{--        .mt-10 {--}}
{{--            margin-top: 10px;--}}
{{--        }--}}

{{--        .mt-20 {--}}
{{--            margin-top: 20px;--}}
{{--        }--}}

{{--        .mb-0 {--}}
{{--            margin-bottom: 0;--}}
{{--        }--}}

{{--        .mb-5 {--}}
{{--            margin-bottom: 15px;--}}
{{--        }--}}

{{--        .pb-0 {--}}
{{--            padding-bottom: 0;--}}
{{--        }--}}


{{--        .page-break {--}}
{{--            page-break-before: always;--}}
{{--        }--}}

{{--    </style>--}}
{{--</head>--}}

{{--<body>--}}
{{--<header>--}}
{{--    <table style="width: 100%;" class="signature">--}}
{{--        <tr>--}}
{{--            <td style="width: 15%;">--}}
{{--                <img class="hospital-logo"--}}
{{--                     src="{{ asset('images/uploads/hospital_images/'.$po_hospital_details->logo) }}" width="60" alt="">--}}
{{--            </td>--}}
{{--            <td style="text-align:center;">--}}
{{--                <span--}}
{{--                    style="font-size: 15px;"> <strong> {{isset($po_hospital_details->hospital_name )? $po_hospital_details->hospital_name : ""}} </strong></span>--}}
{{--                <br>--}}
{{--                Address:--}}
{{--                <span> {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : ""}}</span><br>--}}
{{--                Phone No:--}}
{{--                <span> {{isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : "" }}</span>--}}
{{--            </td>--}}
{{--            <td style=" text-align:right; width: 15%; ">--}}
{{--                <div style="">--}}
{{--                    <img src="data:image/png;base64, {{ $barcode_no }} " width="100"/>--}}
{{--                </div>--}}

{{--            </td>--}}
{{--        </tr>--}}
{{--    </table>--}}
{{--</header>--}}
{{--<div style="width: 100%;">--}}
{{--    <div style=" text-align:center; margin-bottom:5px; margin-top:15px  ">--}}
{{--        <span class="report-name" style="width:70%; border:solid black 1px; padding:10px;  "> Referral Payment Bill</span>--}}
{{--    </div>--}}

{{--</div>--}}

{{--<div class="signature_">--}}
{{--    <table style="width: 100%;">--}}
{{--        <tr style=" ">--}}
{{--            <td style="text-align:left; ">--}}
{{--                    <span style="padding:5px; border-top: black solid 1px;"> HR & ADMIN--}}
{{--                    </span>--}}
{{--            </td>--}}
{{--            <td style=" ">--}}
{{--                    <span style="padding:5px; border-top: black solid 1px;"> MANAGER (HOSPITAL SERVICE)--}}
{{--                    </span>--}}
{{--            </td>--}}
{{--            <td style=" ">--}}
{{--                    <span style="padding:5px; border-top: black solid 1px;"> ACCOUNT OFFICER--}}
{{--                    </span>--}}
{{--            </td>--}}
{{--            <td style=" ">--}}
{{--                    <span style="padding:5px; border-top: black solid 1px;"> GENERAL MANAGER--}}
{{--                    </span>--}}
{{--            </td>--}}
{{--            <td style="text-align:right; ">--}}
{{--                <span style="padding:5px; border-top: black solid 1px;"> MANAGING DIRECTOR </span>--}}
{{--            </td>--}}
{{--        </tr>--}}
{{--    </table>--}}
{{--</div>--}}

{{--<footer class="">--}}
{{--    <div class="footer ">--}}
{{--        <div class="container">--}}
{{--            <table style="width: 100%; padding:3px; margin: 0">--}}
{{--                <tr>--}}
{{--                    <td style="font-size: 9px; text-align:left;">Print Date: <strong>--}}
{{--                            @php--}}
{{--                                date_default_timezone_set('Asia/Dhaka');--}}
{{--                                $date = date('d/m/Y H:m:s');--}}
{{--                            @endphp--}}
{{--                            {{ $date }}--}}
{{--                        </strong> Printed By: <strong>{{ Session::get('user.ses_user_name') }}</strong></td>--}}
{{--                    <td style="font-size: 9px; text-align: right;"><strong>Powered By - H360 [NextGenIT]--}}
{{--                        </strong></td>--}}
{{--                </tr>--}}
{{--            </table>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</footer>--}}


{{--<main class="">--}}
{{--    <div class="wrapper">--}}

{{--        <section id="lp-items ">--}}
{{--            <div class="container ">--}}
{{--                @if(!empty($ref_info))--}}
{{--                    <table style="width:100%;border-collapse:collapse; margin-bottom:5px" cellpadding="1"--}}
{{--                           cellspacing="0" border="1">--}}
{{--                        <tr>--}}
{{--                            <th style="text-align: left ; border:none;padding:5px;width:100px"> Referral code</th>--}}
{{--                            <td style="text-align: left ;border:none"> : {{$ref_info->person_code}}</td>--}}
{{--                        </tr>--}}
{{--                        <tr>--}}
{{--                            <th style="text-align: left ;border:none;padding:5px;width:100px"> Name</th>--}}
{{--                            <td style="text-align: left ;border:none"> : {{$ref_info->full_name}}</td>--}}
{{--                        </tr>--}}
{{--                        <tr>--}}
{{--                            <th style="text-align: left ;border:none;padding:5px;width:100px"> Address</th>--}}
{{--                            <td style="text-align: left ;border:none"> :</td>--}}
{{--                        </tr>--}}

{{--                        @if ($from_date != '' && $to_date != '')--}}
{{--                            <tr>--}}
{{--                                <th style="text-align: left ;border:none;padding:5px;width:100px"> From date </th>--}}
{{--                                <td style="text-align: left ;border:none"> : {{ $from_date }}, <strong> To date--}}
{{--                                    </strong> : {{ $to_date }}</td>--}}

{{--                                @elseif ($from_date !="")--}}
{{--                                    <th style="text-align: left ;border:none;padding:5px;width:100px"> Date</th>--}}
{{--                                    <td style="text-align: left ;border:none"> : {{ $from_date }}</td>--}}

{{--                            </tr>--}}
{{--                        @endif--}}


{{--                    </table>--}}
{{--                @endif--}}
{{--                <table style="width:100%;border-collapse:collapse;" cellpadding="1" cellspacing="0" border="1">--}}
{{--                    <thead>--}}
{{--                    <tr class="table-tr" style="background-color: #E3E3E3;  ">--}}
{{--                        <th class=" table-td" rowspan="2"><strong>SL# </strong></th>--}}
{{--                        <th class=" table-td" rowspan="2"><strong>Invoice No </strong></th>--}}
{{--                        <th class=" table-td" rowspan="2"><strong>Invoice Date </strong></th>--}}

{{--                        <th class=" table-td" rowspan="2"><strong>Investigation Name </strong></th>--}}
{{--                        <th class=" table-td" rowspan="2"><strong>Rate </strong></th>--}}
{{--                        <th class=" table-td" rowspan="2"><strong>Referral Amt.</strong></th>--}}
{{--                        <th class=" table-td" colspan="2"><strong>Discount </strong></th>--}}
{{--                        <th class=" table-td" rowspan="2" style="border-right: 1px solid #222"><strong>Total Ref.--}}
{{--                                Amt. </strong></th>--}}
{{--                    </tr>--}}
{{--                    <tr class="table-tr" style="background-color: #E3E3E3;">--}}
{{--                        <td class=" table-td" style="text-align: center"><strong>Hospital </strong></td>--}}
{{--                        <td class=" table-td" style="text-align: center"><strong>Referral </strong></td>--}}

{{--                    </tr>--}}
{{--                    </thead>--}}
{{--                    <tbody>--}}
{{--                    @if (isset($referral_arr))--}}
{{--                        @php--}}
{{--                            $total_item_rate = 0;--}}
{{--                            $total_referral_amount = 0;--}}
{{--                            $total_discount_amt_by_hos = 0;--}}
{{--                            $total_discount_amt_by_doc = 0;--}}
{{--                            $grand_total_referral_amount = 0;--}}
{{--                        @endphp--}}
{{--                        @foreach ($referral_arr as $key => $value)--}}
{{--                            @php--}}
{{--                                $item_rate = 0;--}}
{{--                                $referral_amount = 0;--}}
{{--                                $discount_amt_by_hos = 0;--}}
{{--                                $discount_amt_by_doc = 0;--}}
{{--                                $sub_total_referral_amount = 0;--}}
{{--                            @endphp--}}
{{--                            <tr>--}}
{{--                                <td class="" style="" colspan="9"><strong>{{ $key }}--}}
{{--                                        </b> </strong>--}}

{{--                            </tr>--}}
{{--                            @foreach ($value as $data)--}}
{{--                                @php--}}
{{--                                    $item_rate += $data->item_rate;--}}
{{--                                    $referral_amount += $data->referral_amount;--}}
{{--                                    $discount_amt_by_hos += $data->discount_amt_by_hos;--}}
{{--                                    $discount_amt_by_doc += $data->discount_amt_by_doc;--}}
{{--                                    $sub_total_referral_amount +=   number_format(number_format($data->referral_amount, 2) - number_format($data->discount_amt_by_doc, 2), 2) ;--}}

{{--                                    $total_item_rate += $data->item_rate;--}}
{{--                                    $total_referral_amount += $data->referral_amount;--}}
{{--                                    $total_discount_amt_by_hos += $data->discount_amt_by_hos;--}}
{{--                                    $total_discount_amt_by_doc += $data->discount_amt_by_doc;--}}
{{--                                    $grand_total_referral_amount +=  number_format(number_format($data->referral_amount, 2) - number_format($data->discount_amt_by_doc, 2), 2) ;--}}
{{--                                @endphp--}}
{{--                                <tr>--}}
{{--                                    <td class="text-center"--}}
{{--                                        style="text-align: center;padding:5px">{{ $loop->iteration }}</td>--}}
{{--                                    <td class="text-left" style="padding:5px">{{ $data->invoice_no_pk }}</td>--}}
{{--                                    <td class="text-left" style="padding:5px">--}}
{{--                                        {{ $data->invoice_date ? date('d/m/Y', strtotime($data->invoice_date)) : '' }}--}}
{{--                                    </td>--}}
{{--                                    <td class="text-left" style="padding:5px">{{ $data->item_name }}</td>--}}

{{--                                    <td style="text-align: right;padding:5px">{{ number_format($data->item_rate, 2) }}--}}
{{--                                    </td>--}}
{{--                                    <td style="text-align: right;padding:5px">--}}
{{--                                        {{ number_format($data->referral_amount, 2) }}</td>--}}
{{--                                    <td style="text-align: right;padding:5px">--}}
{{--                                        {{ number_format($data->discount_amt_by_hos, 2) }}</td>--}}
{{--                                    <td style="text-align: right;padding:5px">--}}
{{--                                        {{ number_format($data->discount_amt_by_doc, 2) }}</td>--}}
{{--                                    <td style="text-align: right;padding:5px">--}}
{{--                                        {{ number_format(number_format($data->referral_amount, 2) - number_format($data->discount_amt_by_doc, 2), 2) }}--}}
{{--                                    </td>--}}

{{--                                </tr>--}}
{{--                            @endforeach--}}
{{--                            <tr>--}}
{{--                                <td colspan="4" style="text-align: right"><strong>Department-wise sub total--}}
{{--                                    </strong></td>--}}
{{--                                <td style="text-align: right;padding:5px"><strong>{{ number_format($item_rate, 2) }}--}}
{{--                                    </strong></td>--}}
{{--                                <td style="text-align: right;padding:5px">--}}
{{--                                    <strong>{{ number_format($referral_amount, 2) }} </strong></td>--}}
{{--                                <td style="text-align: right">--}}
{{--                                    <strong>{{ number_format($discount_amt_by_hos, 2) }} </strong></td>--}}
{{--                                <td style="text-align: right;padding:5px">--}}
{{--                                    <strong>{{ number_format($discount_amt_by_doc, 2) }} </strong></td>--}}
{{--                                <td style="text-align: right;padding:5px">--}}
{{--                                    <strong>{{number_format($sub_total_referral_amount,2)}} </strong></td>--}}

{{--                            </tr>--}}
{{--                        @endforeach--}}
{{--                        <tr>--}}
{{--                            <td colspan="4" style="text-align: right"><strong>Referral-wise grand total--}}
{{--                                </strong></td>--}}
{{--                            <td style="text-align: right;padding:5px"><strong>{{ number_format($total_item_rate, 2) }}--}}
{{--                                </strong></td>--}}
{{--                            <td style="text-align: right;padding:5px">--}}
{{--                                <strong>{{ number_format($total_referral_amount, 2) }} </strong></td>--}}
{{--                            <td style="text-align: right;padding:5px">--}}
{{--                                <strong>{{ number_format($total_discount_amt_by_hos, 2) }} </strong></td>--}}
{{--                            <td style="text-align: right;padding:5px">--}}
{{--                                <strong>{{ number_format($total_discount_amt_by_doc, 2) }} </strong></td>--}}
{{--                            <td style="text-align: right;padding:5px">--}}
{{--                                <strong> {{number_format($grand_total_referral_amount,2)}}</strong></td>--}}

{{--                        </tr>--}}
{{--                    @endif--}}
{{--                    </tbody>--}}
{{--                    <tbody>--}}
{{--                    @php--}}
{{--                        $listSl = 0;--}}
{{--                    @endphp--}}


{{--                    </tbody>--}}


{{--                </table>--}}
{{--            </div>--}}
{{--        </section>--}}
{{--    </div>--}}
{{--</main>--}}


{{--<div class="signature_">--}}
{{--    <table style="width: 100%;">--}}
{{--        <tr style=" ">--}}
{{--            <td style="text-align:left; ">--}}
{{--                    <span style="padding:5px; border-top: black solid 1px;"> HR & ADMIN--}}
{{--                    </span>--}}
{{--            </td>--}}
{{--            <td style=" ">--}}
{{--                    <span style="padding:5px; border-top: black solid 1px;"> MANAGER (HOSPITAL SERVICE)--}}
{{--                    </span>--}}
{{--            </td>--}}
{{--            <td style=" ">--}}
{{--                    <span style="padding:5px; border-top: black solid 1px;"> ACCOUNT OFFICER--}}
{{--                    </span>--}}
{{--            </td>--}}
{{--            <td style=" ">--}}
{{--                    <span style="padding:5px; border-top: black solid 1px;"> GENERAL MANAGER--}}
{{--                    </span>--}}
{{--            </td>--}}
{{--            <td style="text-align:right; ">--}}
{{--                <span style="padding:5px; border-top: black solid 1px;"> MANAGING DIRECTOR </span>--}}
{{--            </td>--}}
{{--        </tr>--}}
{{--    </table>--}}
{{--</div>--}}

{{--<footer class="">--}}
{{--    <div class="footer ">--}}
{{--        <div class="container">--}}
{{--            <table style="width: 100%; padding:3px; margin: 0">--}}
{{--                <tr>--}}
{{--                    <td style="font-size: 9px; text-align:left;">Print Date: <strong>--}}
{{--                            @php--}}
{{--                                date_default_timezone_set('Asia/Dhaka');--}}
{{--                                $date = date('d/m/Y H:m:s');--}}
{{--                            @endphp--}}
{{--                            {{ $date }}--}}
{{--                        </strong> Printed By: <strong>{{ Session::get('user.ses_user_name') }}</strong></td>--}}
{{--                    <td style="font-size: 9px; text-align: right;"><strong>Powered By - H360 [NextGenIT]--}}
{{--                        </strong></td>--}}
{{--                </tr>--}}
{{--            </table>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</footer>--}}
{{--</body>--}}

{{--</html>--}}



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
            <td style="width: 15%;">
                @if(!empty($po_hospital_details->logo))

                    <img class="hospital-logo" src="{{ asset('images/uploads/hospital_images/'.$po_hospital_details->logo) }}" width="60" alt="">
                @endif

            </td>
            <td style="text-align:center;">
                <span style="font-size: 15px;"> <strong> {{isset($po_hospital_details->hospital_name )? $po_hospital_details->hospital_name : ""}} </strong></span> <br>
                Address: <span> {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : ""}}</span><br>
                Phone No: <span> {{isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : "" }}</span>
            </td>
            <td style=" text-align:right; width: 15%; ">
                <div style="">
                    <img src="data:image/png;base64, {{ $barcode_no }} " width="100" />
                </div>

            </td>
        </tr>
    </table>
</header>
<div style="width: 100%;">
    @if (!empty($ref_info))
        <div style=" text-align:center; margin-bottom:5px; margin-top:15px  ">
            <span class="report-name" style="width:70%; border:solid black 1px; padding:10px;  "> Referral Payment Bill Report</span>
        </div>
    @elseif (!empty($dept_id))
        <div style=" text-align:center; margin-bottom:5px; margin-top:15px  ">
            <span class="report-name" style="width:70%; border:solid black 1px; padding:10px;  "> Department wise Referral Payment Bill Report</span>
        </div>
    @else
        <div style=" text-align:center; margin-bottom:5px; margin-top:15px  ">
            <span class="report-name" style="width:70%; border:solid black 1px; padding:10px;  "> Date wise Referral Payment Bill Report</span>
        </div>
    @endif


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
                @if (!empty($ref_info))
                    <table style="width:100%;border-collapse:collapse; margin-bottom:10px; " cellpadding="1" cellspacing="0" border="1">
                        <tr>
                            <th style="text-align: left ; border:none;padding:5px;width:100px"> Referral code</th>
                            <td style="text-align: left ;border:none"> : {{ $ref_info->person_code }}</td>

                            {{-- <td style="text-align: left ;border:none"> : {{$ref_info->person_code}}</td> --}}
                        </tr>
                        <tr>
                            <th style="text-align: left ;border:none;padding:5px;width:100px"> Name </th>
                            <td style="text-align: left ;border:none"> : {{ $ref_info->full_name }}</td>
                        </tr>
                        <tr>
                            <th style="text-align: left ;border:none;padding:5px;width:100px"> Address </th>
                            <td style="text-align: left ;border:none"> : </td>
                        </tr>


                        @if ($from_date != '' && $to_date != '')
                            <tr>
                                <td style="text-align: left ;border:none;padding:5px;width:100px"> From date </td>
                                <td style="text-align: left ;border:none"> : {{ $from_date }}, <strong> To date
                                    </strong> : {{ $to_date }}</td>

                                @elseif ($from_date !="")
                                    <th style="text-align: left ;border:none;padding:5px;width:100px"> Date</th>
                                    <td style="text-align: left ;border:none"> : {{ $from_date }}</td>

                            </tr>
                        @endif


                    </table>
                @else
                    <table>
                        <tr>

                            @if ($from_date != '' && $to_date != '')
                                <th style="text-align: left ;border:none;padding:5px;width:100px"> From date </th>
                                <td style="text-align: left ;border:none"> : {{ $from_date }}, <strong> To date
                                    </strong> : {{ $to_date }}</td>

                            @elseif ($from_date !="")
                                <th style="text-align: left ;border:none;padding:5px;width:100px"> Date</th>
                                <td style="text-align: left ;border:none"> : {{ $from_date }}</td>

                            @endif


                        </tr>
                    </table>
                @endif




                <table style="width:100%;border-collapse:collapse;" cellpadding="1" cellspacing="0" border="1">
                    <thead>
                    <tr class="table-tr" style="background-color: #E3E3E3;  ">
                        <th class=" table-td" rowspan="2"> <strong>SL# </strong></th>
                        <th class=" table-td" rowspan="2"> <strong>Invoice No </strong></th>
                        <th class=" table-td" rowspan="2"> <strong>Invoice Date </strong></th>
                        @if( $card_no == null)
                            <th class=" table-td" rowspan="2"> <strong>Referral Name </strong></th>
                        @endif
                        <th class=" table-td" rowspan="2"> <strong>Investigation Name </strong></th>
                        <th class=" table-td" rowspan="2"> <strong>Rate </strong></th>
                        <th class=" table-td" rowspan="2"> <strong>Referral Amt.</strong></th>
                        <th class=" table-td" colspan="2"> <strong>Discount </strong></th>
                        <th class=" table-td" rowspan="2" style="border-right: 1px solid #222">
                            <strong>Total Ref. Amt. </strong>
                        </th>
                    </tr>
                    <tr class="table-tr" style="background-color: #E3E3E3;">
                        <td class=" table-td" style="text-align: center"> <strong>Hospital </strong></td>
                        <td class=" table-td" style="text-align: center"> <strong>Referral </strong></td>

                    </tr>
                    </tr>
                    </thead>
                    <tbody>
                    @if (isset($referral_arr))
                        @php
                            $total_item_rate = 0;
                            $total_referral_amount = 0;
                            $total_discount_amt_by_hos = 0;
                            $total_discount_amt_by_doc = 0;
                            $grand_total_referral_amount = 0;
                        @endphp
                        @foreach ($referral_arr as $key => $value)
                            @php
                                $item_rate = 0;
                                $referral_amount = 0;
                                $discount_amt_by_hos = 0;
                                $discount_amt_by_doc = 0;
                                $sub_total_referral_amount = 0;

                                if( $card_no ==null)
                                $col_span=10;
                                else
                                $col_span=9;
                            @endphp
                            <tr>
                                <td class="" style="" colspan="{{$col_span}}"><strong>{{ $key }}
                                        </b> </strong>

                            </tr>
                            @foreach ($value as $data)
                                @php
                                    $item_rate += $data->item_rate;
                                    $referral_amount += $data->referral_amount;
                                    $discount_amt_by_hos += $data->discount_amt_by_hos;
                                    $discount_amt_by_doc += $data->discount_amt_by_doc;
                                    $sub_total_referral_amount += number_format(number_format($data->referral_amount, 2) - number_format($data->discount_amt_by_doc, 2), 2);

                                    $total_item_rate += $data->item_rate;
                                    $total_referral_amount += $data->referral_amount;
                                    $total_discount_amt_by_hos += $data->discount_amt_by_hos;
                                    $total_discount_amt_by_doc += $data->discount_amt_by_doc;
                                    $grand_total_referral_amount += number_format(number_format($data->referral_amount, 2) - number_format($data->discount_amt_by_doc, 2), 2);
                                @endphp
                                <tr>
                                    <td class="text-center" style="text-align: center;padding:5px">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="text-left" style="padding:5px">{{ $data->invoice_no_pk }}
                                    </td>
                                    <td class="text-left" style="padding:5px">
                                        {{ $data->invoice_date ? date('d/m/Y', strtotime($data->invoice_date)) : '' }}
                                    </td>
                                    @if( $card_no ==null)
                                        <td class="text-left" style="padding:5px">
                                            @if($data->full_name !=null && $data->full_name !="Self" )
                                                {{ $data->full_name }}
                                            @endif
                                            @if($data->first_ref_doc_name !=null)
                                                @if($data->full_name !=null && $data->full_name !="Self")
                                                    <br>
                                                @endif
                                                {{ $data->first_ref_doc_name }}
                                            @endif

                                            @if($data->second_ref_doc_name !=null)
                                                @if($data->full_name !=null && $data->full_name !="Self" || $data->first_ref_doc_name !=null)
                                                    <br>
                                                @endif
                                                {{ $data->second_ref_doc_name }}
                                            @endif

                                        </td>
                                    @endif
                                    <td class="text-left" style="padding:5px">{{ $data->item_name }}
                                    </td>

                                    <td style="text-align: right;padding:5px">
                                        {{ number_format($data->item_rate, 2) }}
                                    </td>
                                    <td style="text-align: right;padding:5px">
                                        {{ number_format($data->referral_amount, 2) }}
                                    </td>
                                    <td style="text-align: right;padding:5px">
                                        {{ number_format($data->discount_amt_by_hos, 2) }}
                                    </td>
                                    <td style="text-align: right;padding:5px">
                                        {{ number_format($data->discount_amt_by_doc, 2) }}
                                    </td>
                                    <td style="text-align: right;padding:5px">
                                        {{ number_format(number_format($data->referral_amount, 2) - number_format($data->discount_amt_by_doc, 2), 2) }}
                                    </td>

                                </tr>
                            @endforeach
                            @php
                                if( $card_no ==null)
                                $col_span=5;
                                else
                                $col_span=4;
                            @endphp
                            <tr>
                                <td colspan="{{$col_span}}" style="text-align: right"> <strong>Department-wise sub total
                                    </strong> </td>
                                <td style="text-align: right;padding:5px">
                                    <strong>{{ number_format($item_rate, 2) }}
                                    </strong>
                                </td>
                                <td style="text-align: right;padding:5px">
                                    <strong>{{ number_format($referral_amount, 2) }} </strong>
                                </td>
                                <td style="text-align: right">
                                    <strong>{{ number_format($discount_amt_by_hos, 2) }} </strong>
                                </td>
                                <td style="text-align: right;padding:5px">
                                    <strong>{{ number_format($discount_amt_by_doc, 2) }} </strong>
                                </td>
                                <td style="text-align: right;padding:5px">
                                    <strong>{{ number_format($sub_total_referral_amount, 2) }} </strong>
                                </td>

                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="{{$col_span}}" style="text-align: right"> <strong>Referral-wise grand total
                                </strong> </td>
                            <td style="text-align: right;padding:5px">
                                <strong>{{ number_format($total_item_rate, 2) }}
                                </strong>
                            </td>
                            <td style="text-align: right;padding:5px">
                                <strong>{{ number_format($total_referral_amount, 2) }} </strong>
                            </td>
                            <td style="text-align: right;padding:5px">
                                <strong>{{ number_format($total_discount_amt_by_hos, 2) }} </strong>
                            </td>
                            <td style="text-align: right;padding:5px">
                                <strong>{{ number_format($total_discount_amt_by_doc, 2) }} </strong>
                            </td>
                            <td style="text-align: right;padding:5px"> <strong>
                                    {{ number_format($grand_total_referral_amount, 2) }}</strong> </td>

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
