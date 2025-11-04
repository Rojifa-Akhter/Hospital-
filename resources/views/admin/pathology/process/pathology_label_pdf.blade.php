{{-- <link rel="stylesheet" href="{{ public_path().'/css/print.css' }}" media="print"> --}}
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Appointment card</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <style>
        @page {
            margin: 0cm 0cm;
            width: 450px;
            /* size:  330mm 80mm  landscape; */
            /* size: 78mm 78mm portrait ; */

            size:  1.1in 1.6in portrait;
        }

        @font-face {
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-weight: normal;
            font-size: 11px;
            font-style: normal;
            font-variant: normal;
            src: url("font url");
        }


        /* Define the header rules */
        header {
            border-bottom: 1px solid #000;
            color: #007FD2;
        }

        header img {
            width: 80px;
        }

        /* Define now the real margins of every page in the PDF */
        body {
            margin-top: .4 .2cm;
            margin-left: .4 .2cm;
            margin-right: .4 .2cm;
            /* margin-bottom: 6.5cm; */
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-size: 10px;
            border-color: #000;
        }

        footer {
            position: fixed;
            bottom: 0cm;
            left: 1cm;
            right: 1cm;
            height: 3cm;
            text-align: center;
            font-size: 9px;
        }

        tfoot tr td {
            font-weight: bold;
            font-size: 10px;
        }

        .page-break {
            page-break-after: always;
        }

        .tbl-header {
            background-color: #0073b7;
            color: #ffffff;
        }

        ul {
            padding: 0;
            margin: 0;
            padding-top: 5px;
        }

        ul li {
            margin-bottom: 5px;
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

        /*Appointment Serial card end*/

        .hospital-name {
            margin-bottom: 0;
            font-size: 14px;
            padding-bottom: 0;
            display: block;
            color: #000;
        }

        .hospital-address {
            line-height: 1.2;
            display: block;
            font-size: 10px;
            color: #000;
        }

        .hospital-contact {
            line-height: 1.2;
            color: #000;
            /*width: 480px;*/
        }

        .hospital-card {
            display: block;
            margin-bottom: 10px;
            font-size: 10px;
            color: #000;
        }

        .hospital_info {
            margin-left: 10px;
            padding-bottom: 10px;
        }

        main img {
            width: 100px;
        }

        .card {
            width: 69mm;
            /*border:1px solid #000;*/
            padding: 0px 0px 0px 0px;
            /*margin: 0 auto;*/
        }

        .footer {
            padding: 5px 0;
        }

    </style>
</head>

<body>
    @if (is_array($appointment))
        @foreach ($appointment as $value)

            <div class="card" style="border-style: solid;border-width: thin;">
                <header>
                    <table style="width: 100%;">
                        <tr>
                            <td style="text-align: center;">
                                <span
                                    class="hospital-name">{{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}</span>
                                <span
                                    class="hospital-address">{{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</span>
                            </td>
                        </tr>
                    </table>
                </header>
                <main>
                    <div class="wrapper">
                        <section id="patient-info">
                            <div class="container">
                                <table
                                    style="width: 100%; padding-left: 10px; border-bottom: #222; padding-bottom: 0px; ">

                                    <tr>
                                        <td>Invoice Id</td>
                                        <td style="border-bottom: 1px solid #222;">
                                            <strong>{{ !empty($value->invoice_code) ? $value->invoice_code : '' }}</strong>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td width="50%">Patient Name</td>
                                        <td width="50%" style="border-bottom: 1px solid #222;">
                                            <strong>{{ !empty($value->patient_name) ? $value->patient_name : '' }}</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Age</td>
                                        <td style="border-bottom: 1px solid #222;">
                                            <strong>{{ '22' }}</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Referd. By</td>
                                        <td style="border-bottom: 1px solid #222;">
                                            <strong>{{ $value->collectd_by }}</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Name Of Specimen</td>
                                        <td style="border-bottom: 1px solid #222;">
                                            <strong>{{ !empty($value->sam_name) ? $value->sam_name : '' }}</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Sample Collect By</td>
                                        <td style="border-bottom: 1px solid #222;">
                                            <strong>{{ $value->collectd_by }} {{ date('d M Y H:i:s') }}
                                            </strong>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </section>
                        <div class="footer">
                            <div class="container">
                                <table style="width: 100%; padding-left: 10px; margin: 0">
                                    {{-- <tr>
                            <td width="50%">value Date & Time</td>
                            <td width="50%">:&nbsp;&nbsp;<strong>{{ !empty($value->patapp_date)?date('d/m/Y', strtotime($value->patapp_date)):''  }} 8:15 PM</strong></td>
                        </tr> --}}
                                    <tr>
                                        <td>Delivery Date</td>
                                        <td>
                                            <strong>
                                                :
                                                {{ !empty($value->report_delivery_date) ? date('d/m/Y', strtotime($value->report_delivery_date)) : '' }}
                                            </strong>
                                        </td>
                                    </tr>
                                    <?php
                                    $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
                                    $date = $dt->format('g:i A');
                                    ?>
                                    <tr>
                                        <td>Print On</td>
                                        <td>
                                            <strong> : {{ $date }} </strong>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                    </div>
                </main>
            </div>
            @if ($loop->iteration != count($appointment))
                <div class="page-break"></div>
            @endif
        @endforeach
    @else

        <div class="card" style="border-style: solid;border-width: thin;">
            <header>
                <table style="width: 100%;">
                    <tr>
                        <td style="text-align: center;">
                            <span
                                class="hospital-name">{{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}</span>
                            <span
                                class="hospital-address">{{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</span>
                        </td>
                    </tr>
                </table>
            </header>
            <main>
                <div class="wrapper">
                    <section id="patient-info">
                        <div class="container">
                            <table style="width: 100%; padding-left: 10px; border-bottom: #222; padding-bottom: 0px; ">

                                <tr>
                                    <td>Invoice Id</td>
                                    <td style="border-bottom: 1px solid #222;">
                                        <strong>{{ !empty($appointment->invoice_code) ? $appointment->invoice_code : '' }}</strong>
                                    </td>
                                </tr>

                                <tr>
                                    <td width="50%">Patient Name</td>
                                    <td width="50%" style="border-bottom: 1px solid #222;">
                                        <strong>{{ !empty($appointment->patient_name) ? $appointment->patient_name : '' }}</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Age</td>
                                    <td style="border-bottom: 1px solid #222;">
                                        <strong>{{ '22' }}</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Referd. By</td>
                                    <td style="border-bottom: 1px solid #222;">
                                        <strong>{{ !empty($appointment->collectd_by)?$appointment->collectd_by:'N/A' }}</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Name Of Specimen</td>
                                    <td style="border-bottom: 1px solid #222;">
                                        <strong>{{ !empty($appointment->sam_name) ? $appointment->sam_name : '' }}</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Sample Collect By</td>
                                    <td style="border-bottom: 1px solid #222;">
                                        <strong>{{ !empty($appointment->collectd_by)?$appointment->collectd_by:'N/A' }} {{ date('d M Y H:i:s') }} </strong>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </section>
                    <div class="footer">
                        <div class="container">
                            <table style="width: 100%; padding-left: 10px; margin: 0">
                                {{-- <tr>
                            <td width="50%">Appointment Date & Time</td>
                            <td width="50%">:&nbsp;&nbsp;<strong>{{ !empty($appointment->patapp_date)?date('d/m/Y', strtotime($appointment->patapp_date)):''  }} 8:15 PM</strong></td>
                        </tr> --}}
                                <tr>
                                    <td>Delivery Date</td>
                                    <td>
                                        <strong>
                                            :
                                            {{ !empty($appointment->report_delivery_date) ? date('d/m/Y', strtotime($appointment->report_delivery_date)) : '' }}
                                        </strong>
                                    </td>
                                </tr>
                                <?php
                                $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
                                $date = $dt->format('g:i A');
                                ?>
                                <tr>
                                    <td>Print On</td>
                                    <td>
                                        <strong> : {{ $date }} </strong>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                </div>
            </main>
        </div>
    @endif
</body>

</html>
