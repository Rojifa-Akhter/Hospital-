<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>
        @if (!empty($type) != 'DEPT')
            OPD Doctor Performance
        @else
            Department Wise Performance
        @endif Summary
    </title>
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
                            src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}"
                            width="60" alt="">
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
            <span class="report-name" style="width:70%; border:solid black 1px; padding:10px;  ">
                @if (!empty($type) != 'DEPT')
                    OPD Doctor Performance
                @else
                    OPD Department Wise Performance
                @endif Summary

            </span>
        </div>
    </div>

    <div class="signature_">
        <table style="width: 100%;">
            <tr style=" ">

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


    <main class="">
        <div class="wrapper">


            <table>
                &nbsp;
                @if ($doctor_name != '')
                    <tr>
                        <th style="text-align: left ;border:none;padding:5px;width:100px"> Doctor</th>
                        <td style="text-align: left ;border:none"> : {{ $doctor_name }}</td>
                    </tr>
                @endif
                @if ($department != '')
                    <tr>
                        <th style="text-align: left ;border:none;padding:5px;width:100px"> department </th>
                        <td style="text-align: left ;border:none"> : {{ $department }}</td>
                    </tr>
                @endif
                @if ($from_date != '' && $to_date != '')
                    <tr>
                        <th style="text-align: left ;border:none;padding:5px;width:100px"> From date </th>
                        <td style="text-align: left ;border:none"> : {{ $from_date }}, <strong> To date
                            </strong> : {{ $to_date }}</td>
                    </tr>
                @elseif ($from_date != '')
                    <tr>
                        <th style="text-align: left ;border:none;padding:5px;width:100px"> Date</th>
                        <td style="text-align: left ;border:none"> : {{ $from_date }}</td>
                    </tr>
                @endif

            </table>



            <section id="lp-items ">
                <div class="container ">


                    <table style="width:100%;border-collapse:collapse;" cellpadding="1" cellspacing="0" border="1">
                        <thead>
                            <tr class="table-tr" style="background-color: #E3E3E3;  ">
                                <th class=" table-td"> <strong>SL# </strong></th>
                                {{-- @if (!empty($type) != 'DEPT')
                                    <th class=" table-td"> <strong> Invoice Date</strong></th>
                                @endif --}}
                                @if (!empty($type) != 'DEPT')
                                    <th class=" table-td"> <strong>Doctor Code</strong></th>
                                    <th class=" table-td"> <strong>Doctor Name</strong></th>
                                @endif
                                <th class=" table-td"> <strong>Department </strong></th>
                                @if ($type != 'DEPT')
                                    <th class=" table-td"> <strong>No Of Patient </strong></th>
                                    <th class=" table-td"> <strong>New Patient</strong></th>
                                    <th class="text-center">Follow Up/Old Patient</th>
                                    <th class=" table-td"> <strong>Free Patient</strong></th>
                                @else
                                    <th class=" table-td"> <strong>No of Services </strong></th>
                                @endif

                                <th class=" table-td"> <strong>Total Fee</strong></th>
                                <th class=" table-td"> <strong>Discount </strong></th>
                                <th class=" table-td"> <strong>Net Payable </strong></th>
                                <th class=" table-td"> <strong>Paid </strong></th>
                                @if ($type != 'DEPT')
                                    <th class=" table-td"> <strong>Due / Refund</strong></th>
                                @endif


                            </tr>


                        </thead>
                        <tbody>

                            @if (!empty($doctorPerformanceSummary))
                                @php
                                    $ledger_amt_sales = 0;
                                    $ledger_amt_discount = 0;
                                    $ledger_amt_payment = 0;
                                    $ledger_amt_payment = 0;
                                    $net_payable = 0;
                                    $due = 0;
                                    $total_discount_amt_by_hos = 0;
                                    $grand_total_referral_amount = 0;
                                    $net_total_referral_amount = 0;
                                    $number_of_patient = 0;
                                    $total_new_patient = 0;
                                    $total_free_patient = 0;
                                    $total_followup_patient = 0;
                                @endphp



                                @foreach ($doctorPerformanceSummary as $data)
                                    @php
                                        
                                        $ledger_amt_sales += $data->ledger_amt_sales;
                                        
                                        $total_discount_amt_by_hos += $data->ledger_amt_discount;
                                        $ledger_amt_payment += $data->ledger_amt_payment;
                                        $net_payable = $data->ledger_amt_sales - $data->ledger_amt_discount;
                                        $grand_total_referral_amount += $net_payable;
                                        
                                        $due = $net_payable - $data->ledger_amt_payment;
                                        $net_total_referral_amount += $due;
                                        // $number_of_patient += $data->total_appoint;
                                        // $total_new_patient += $data->total_appoint_new;
                                        if ($type != 'DEPT') {
                                            $number_of_patient += $data->total_appoint;
                                            $total_new_patient += $data->total_appoint_new;
                                            $total_free_patient += $data->total_appoint_free;
                                            $total_followup_patient += $data->total_appoint_followup;
                                        } else {
                                            $number_of_patient += $data->current_item_qty;
                                        }
                                        // $total_free_patient += $data->total_appoint_free;
                                    @endphp

                                    <tr>
                                        <td class="text-center" style="text-align: center;padding:5px">
                                            {{ $loop->iteration }}
                                        </td>
                                        {{-- <td class="text-left" style="padding:5px">
                                            {{ date('d/m/Y', strtotime($data->invoice_date)) }} </td> --}}
                                        @if (!empty($type) != 'DEPT')
                                            <td class="text-left" style="padding:5px">
                                                {{ $data->person_code }}
                                            </td>
                                            <td class="text-left" style="padding:5px">
                                                {{ $data->doctor_name }}
                                            </td>
                                        @endif
                                        <td class="text-left" style="text-align: left;padding:5px">
                                            {{ $data->serviceunit_name }}</ </td>


                                            @if ($type != 'DEPT')
                                        <td style="text-align: center;padding:5px">
                                            {{ $data->total_appoint }}
                                        </td>
                                        <td style="text-align: center;padding:5px">
                                            {{ $data->total_appoint_new }}
                                        </td>
                                        <td style="text-align: center;padding:5px">
                                            {{ $data->total_appoint_followup }}
                                        </td>
                                        <td style="text-align: center;padding:5px">
                                            {{ $data->total_appoint_free }}
                                        </td>
                                    @else
                                        <td style="text-align: center;padding:5px">
                                            {{ $data->current_item_qty }}
                                        </td>
                                        {{-- <td class="text-center">{{ $data->current_item_qty }}</td> --}}
                                @endif
                                <td style="text-align: right;padding:5px">
                                    {{ number_format($data->ledger_amt_sales, 2) }}
                                </td>

                                <td style="text-align: right;padding:5px">
                                    {{ number_format($data->ledger_amt_discount, 2) }}
                                </td>

                                <td style="text-align: right;padding:5px">
                                    {{ number_format($net_payable, 2) }}
                                </td>
                                <td style="text-align: right;padding:5px">
                                    {{ number_format($data->ledger_amt_payment, 2) }}
                                </td>

                                @if ($type != 'DEPT')
                                    <td style="text-align: right;padding:5px">
                                        @if ($due < 0)
                                            ({{ number_format(abs($due), 2) }})
                                        @else
                                            {{ number_format($due, 2) }}
                                        @endif
                                    </td>
                                @endif
                                </tr>
                            @endforeach
                            @if (!empty($type) != 'DEPT')
                                @php $col_span = 4; @endphp
                            @else
                                @php $col_span = 2; @endphp
                            @endif
                            <tr>
                                <td colspan="{{ $col_span }}" class="text-right" style="text-align: right">
                                    <strong>Total </strong>
                                </td>
                                @if ($type != 'DEPT')
                                    <td class="text-center" style="text-align: center">
                                        <strong>{{ $number_of_patient }} </strong>
                                    </td>
                                    <td class="text-center" style="text-align: center">
                                        <strong>{{ $total_new_patient }} </strong>
                                    </td>
                                    <td class="text-center" style="text-align: center">
                                        <strong>{{ $total_followup_patient }} </strong>
                                    </td>
                                    <td class="text-center" style="text-align: center">
                                        <strong>{{ $total_free_patient }} </strong>
                                    </td>
                                @else
                                    <td class="text-center" style="text-align: center">
                                        <strong>{{ $number_of_patient }} </strong>
                                    </td>
                                @endif
                                <td class="text-right" style="text-align: right">
                                    <strong>{{ number_format($ledger_amt_sales, 2) }} </strong>
                                </td>
                                <td class="text-right" style="text-align: right">
                                    <strong>{{ number_format($total_discount_amt_by_hos, 2) }} </strong>
                                </td>
                                <td class="text-right" style="text-align: right">
                                    <strong>{{ number_format($grand_total_referral_amount, 2) }} </strong>
                                </td>
                                <td class="text-right" style="text-align: right">
                                    <strong>{{ number_format($ledger_amt_payment, 2) }} </strong>
                                </td>
                                @if ($type != 'DEPT')
                                    <td class="text-right" style="text-align: right"><strong>
                                            @if ($net_total_referral_amount < 0)
                                                ({{ number_format(abs($net_total_referral_amount), 2) }})
                                            @else
                                                {{ number_format($net_total_referral_amount, 2) }}
                                            @endif

                                        </strong></td>
                                @endif
                            </tr>

                            @endif
                        </tbody>


                    </table>
                </div>
            </section>
        </div>
    </main>




    {{-- <footer class="">
        <div class="footer">
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
    </footer> --}}
</body>

</html>
