<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Department Wise Pdf Report</title>
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
            <span class="report-name" style="width:70%; border:solid black 1px; padding:10px;  "> OPD Department Wise
                Performance</span>
        </div>

        <div style=" text-align:center;  width:100%; margin-bottom:10px" class="mb-2">


            <span class="report-date"><strong>From Date: {{ $from_date }}</strong> - <span
                    class="report-date"><strong>To Date: {{ $to_date }}</strong>
                </span>
        </div>


    </div>

    <div class="signature_">
        <table style="width: 100%;border-spacing: 0; border:none !important;" cellpadding="1">
            <tr class="table-tr">
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
                                <th class="table-td"> <strong>SL# </strong></th>
                                <th class="table-td" style="text-align: left;"> <strong>Department Name</strong></th>
                                <th class="table-td"> <strong>Total Patients</strong></th>
                                <th class="table-td"> <strong>Free Patients</strong></th>
                                <th class="table-td"> <strong>Followup Patients </strong></th>
                                <th class="table-td"> <strong>Paid Patients </strong></th>
                                <th class="table-td"> <strong>Paid </strong></th>
                            </tr>


                        </thead>
                        <tbody>
                            @if (!empty($date_data))

                                @php
                                    $sl = 1;
                                    $total_free = $total_followup = $total_apointment = $total_paid = $toal_payment = 0;
                                    
                                @endphp



                                @foreach ($date_data as $key => $date_time)
                                    @php
                                        $t_free = $t_followup = $t_apointment = $t_paid = $t_payment = 0;
                                    @endphp
                                    <tr>
                                        <td colspan="7" class="text-left">
                                            <h2>{{ $key }}</h2>
                                        </td>
                                    </tr>
                                    @foreach ($date_time as $value)
                                        <tr>
                                            <td class="text-center" style="text-align: center;padding:5px">
                                                {{ $loop->iteration }}
                                            </td>
                                            <td class="text-left" style="padding:5px;">
                                                {{ $value->serviceunit_name }}
                                            </td>
                                            <td class="text-left" style="padding:5px;text-align:center;">
                                                {{ $value->total_appointment }}
                                            </td>
                                            <td class="text-left" style="padding:5px;text-align:center;">
                                                {{ $value->patient_free }}
                                            </td>
                                            <td class="text-left" style="padding:5px;text-align:center;">
                                                {{ $value->patient_followup_free }}</td>
                                            <td class="text-" style="text-align: center;padding:5px">
                                                {{ $value->patient_new_paid }}
                                            </td>

                                            <td style="text-align: right;padding:5px">
                                                {{ number_format($value->ledger_amt_payment) }}
                                            </td>


                                        </tr>

                                        @php
                                            
                                            $t_free += $value->patient_free;
                                            $t_apointment += $value->total_appointment;
                                            $t_paid += $value->patient_new_paid;
                                            $t_payment += $value->ledger_amt_payment;
                                            $t_followup += $value->patient_followup_free;
                                        @endphp
                                    @endforeach
                                    <tr>
                                        <td colspan="2" style="text-align: right"> <strong>Sub Total = </strong>
                                        </td>
                                        <td style="text-align: center;padding:5px">
                                            <strong>{{ $t_apointment }}
                                            </strong>
                                        </td>
                                        <td style="text-align: center;padding:5px">
                                            <strong>{{ $t_free }} </strong>
                                        </td>
                                        <td style="text-align: center;padding:5px">
                                            <strong>{{ $t_followup }}</strong>
                                        </td>
                                        <td style="text-align: center;padding:5px">
                                            <strong>{{ $t_paid }}</strong>
                                        </td>
                                        <td style="text-align: right;padding:5px"> <strong>
                                                {{ $t_payment }}

                                            </strong> </td>

                                    </tr>

                                    @php
                                        
                                        $total_apointment += $t_apointment;
                                        $total_free += $t_free;
                                        $total_followup += $t_followup;
                                        $toal_payment += $t_payment;
                                        $total_paid += $t_paid;
                                    @endphp
                                @endforeach

                                <tr>
                                    <td colspan="2" class="text-right" style="text-align: right;padding:5px;">
                                        <strong>Total = </strong> </td>
                                    <td class="text-center" style="text-align: center;padding:5px;">
                                        <strong>{{ $total_apointment }} </strong> </td>
                                    <td class="text-center" style="text-align: center;padding:5px;">
                                        <strong>{{ $total_free }} </strong>
                                    </td>
                                    <td class="text-center" style="text-align: center;padding:5px;">
                                        <strong>{{ $total_followup }} </strong>
                                    </td>
                                    <td class="text-center" style="text-align: center;padding:5px;">
                                        <strong>{{ $total_paid }} </strong> </td>
                                    <td class="text-right" style="text-align: right;padding:5px;">
                                        <strong>{{ $toal_payment }} </strong> </td>
                                </tr>


                            @endif
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </main>




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
