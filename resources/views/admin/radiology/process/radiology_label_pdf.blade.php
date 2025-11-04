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
            /* width: 550px; */
            size: 3.8cm 7.5cm landscape;
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
            margin-top: .2 .1cm;
            margin-left: .2 .1cm;
            margin-right: .2 .1cm;
            /* margin-bottom: 6.5cm; */
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-size: 7px;
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
            font-size: 8px;
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
            font-size: 10px;
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
            line-height: 1;
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
                                {{-- <strong class="hospital-card">Radiology Appointment card</strong> --}}
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
                                        <td>
                                            <strong>{{ !empty($value->invoice_code) ? $value->invoice_code : '' }}</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="50%">Patient Name</td>
                                        <td width="50%">
                                            <strong>{{ !empty($value->patient_name) ? $value->patient_name : '' }}</strong>
                                        </td>
                                    </tr>
                                    @if (!empty($value->accession_id))
                                        <tr>
                                            <td>Addmission ID</td>
                                            <td>
                                                <strong>{{ $value->accession_id }}
                                                </strong>
                                            </td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td>Referd. By</td>
                                        <td>
                                            <strong>{{ 'Dr. Rahat Alam , MBBS(Dhaka)' }}</strong>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Age</td>
                                        <td>
                                            <strong>{{ $value->age }}</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Gender</td>
                                        <td>
                                            <strong>{{ !empty($value->gender_txt) ? $value->gender_txt : '' }}</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Address</td>
                                        <td>
                                            <strong>{{ !empty($value->present_addr) ? $value->present_addr : '' }}</strong>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </section>
                        <div class="footer">
                            <div class="container">
                                <table style="width: 100%; padding-left: 10px; margin: 0">
                                    <tr>
                                        <td>Delivery Date</td>
                                        <td>
                                            <strong>
                                                :
                                                {{ !empty($value->img_app_dttm) ? date('d/m/Y', strtotime($value->img_app_dttm)) : '' }}
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
                            <b
                                class="hospital-name" style="font-size:15px;">{{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}
                            </b>
                            {{-- <span
                                class="hospital-address">{{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</span> --}}
                        </td>
                    </tr>
                </table>
            </header>
            <main>
                <div class="wrapper">
                    <section id="patient-info">
                        <div class="container">
                            <table style="width: 100%; border-bottom: #222; padding-bottom: 0px; ">

                                <tr>
                                    {{-- <td style="width: 25%" style="font-style: 12px !important;">Invoice Id</td> --}}
                                    <td style="width: 25%" style="font-style: 12px !important; font-size:8px;"><strong>Invoice No.</strong></td>
                                    <td style="width: 25%" style="font-style: 12px !important; font-size:8px;">
                                        <strong style="">{{ !empty($appointment->invoice_code) ? $appointment->invoice_code : '' }}</strong>
                                    </td>
                                    <td style="width: 25%; font-size:9px;">
                                        @if (!empty($appointment->admission_no_pk))
                                           <strong>Addmission ID</strong>
                                        @endif
                                    </td>
                                    <td style="width: 25%" style="font-style: 12px !important;">
                                        <strong>
                                            @if (!empty($appointment->admission_no_pk))
                                                {{ !empty($appointment->admission_no_pk) ? $appointment->admission_no_pk : '' }}
                                            @endif

                                        </strong>
                                    </td>
                                </tr>

                                <tr>
                                    <td style="font-style: 12px !important; font-size:8px; width: 60px;"><strong>Patient Name</strong></td>
                                    <td style="font-style: 12px !important; font-size:8px; width: 150px;">
                                        <strong>{{ !empty($appointment->patient_name) ? $appointment->patient_name : '' }}</strong>
                                    </td>

                                    {{-- <td style="font-style: 12px !important;">Print On</td>
                                    <td style="font-size: 6px !important;">
                                        <strong> {{ $date }}</strong>
                                    </td> --}}
                                </tr>

                                <tr>
                                    <td style="font-style: 12px !important; font-size:8px;"> <strong>Referd. By</strong></td>
                                    <td colspan="3" style="font-style: 12px !important;">
                                        <strong style="font-size:8px;">{{ !empty($appointment->ref_doc_name) ? $appointment->ref_doc_name : '' }}</strong>
                                    </td>
                                </tr>
                                <tr>
                                    {{-- <td style="font-style: 12px !important;">Investi Name</td> --}}
                                    <td style="font-size:8px;"><strong>Investigation</strong></td>
                                    <td colspan="3" style="font-style: 12px !important; font-size:8px;">
                                        <strong>{{ !empty($appointment->item_name) ? $appointment->item_name : '' }}</strong>
                                    </td>
                                </tr>


                                @if (!empty($value->age))
                                    <tr>
                                        <td>Age</td>
                                        <td>
                                            <strong>{{ $value->age }}</strong>
                                        </td>
                                    </tr>
                                @endif

                                @if (!empty($value->gender_txt))
                                    <tr>
                                        <td>Gender</td>
                                        <td>
                                            <strong>{{ !empty($appointment->gender_txt) ? $appointment->gender_txt : '' }}</strong>
                                        </td>
                                    </tr>
                                @endif
                                <tr>
                                    <td style="font-size:8px;"><strong>Address</strong></td>
                                    <td>
                                        <strong>{{ !empty($appointment->present_addr) ? $appointment->present_addr : 'N/A' }}</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-size:8px;"><strong>Mobile No.</strong></td>
                                    <td>
                                        <strong style="font-size:8px;">{{ !empty($appointment->patient_mobile) ? $appointment->patient_mobile : 'N/A' }}</strong>
                                    </td>
                                </tr>
                                <?php
                                $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
                                $date = $dt->format('d/m/Y g:i A');
                                ?>
                                 <td style="font-size:6px;"> <strong>Print On</strong></td>
                                 <td style="font-size:6px;">
                                     <strong> {{ $date }}</strong>
                                 </td>
                            </table>

                        </div>
                    </section>

                </div>
            </main>
        </div>
    @endif
</body>

</html>
