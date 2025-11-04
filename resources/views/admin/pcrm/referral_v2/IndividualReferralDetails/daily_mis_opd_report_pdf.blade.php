<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>
        @if (!empty($type) != 'DEPT')
            Doctor Performance
        @else
            Department Wise Performance
        @endif Summary Report
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

        th,
        td {
            padding: 5px;
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
                        <img src="data:image/png;base64, {{ $barcode_no }} " width="100" height="40" />
                    </div>

                </td>
            </tr>
        </table>
    </header>
    <div style="width: 100%;">
        <div style=" text-align:center; margin-bottom:5px; margin-top:15px  ">
            <span class="report-name" style="width:70%; border:solid black 1px; padding:10px;  ">

                DAILY MIS REPORT

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
            <section id="lp-items">
                <div class="container">
                    <table style="width:100%;border-collapse:collapse; margin-top:20px" cellpadding="1" cellspacing="0"
                        border="1">
                        <thead class="bg-primary">
                            <tr>
                                <td colspan='5' style='text-align:center'> <strong> OPD</strong></td>
                                {{-- <td colspan='7' style='text-align:center'> <strong> OPD</strong></td> --}}
                            </tr>
                            <tr>
                                <th style="text-align:center">SL#</th>
                                {{-- <th style="text-align:center">SHIFT</th>
                                <th style="text-align:center">TIME</th> --}}
                                <th style="text-align:center">New Patients</th>
                                <th style="text-align:center">Free Patients</th>
                                <th style="text-align:center">Follow Up/Old Patients</th>
                                <th style="text-align:center">Total Patients</th>
                            </tr>
                        </thead>
                        @if (!empty($doctorPerformanceSummary))
                            <tbody>
                                @php
                                    $total_new_patient = 0;
                                    $total_free_patient = 0;
                                    $total_followup_patient = 0;
                                    $total_number_of_patient = 0;
                                    $total_new_patient2 = 0;
                                    $total_free_patient2 = 0;
                                    $total_followup_patient2 = 0;
                                    $total_number_of_patient2 = 0;

                                @endphp
                                @foreach ($doctorPerformanceSummary as $data)
                                    @php

                                        // if ($data->patient_new_paid >= 0 && $data->patient_new_paid < 2) {
                                            $total_new_patient += $data->patient_new_paid;
                                        // } else {
                                        //     $total_new_patient2 += $data->patient_new_paid;
                                        // }

                                        // if ($data->patient_free >= 0 && $data->patient_free < 2) {
                                            $total_free_patient += $data->patient_free;
                                        // } else {
                                        //     $total_free_patient2 += $data->patient_free;
                                        // }

                                        // if ($data->patient_followup_free >= 0 && $data->patient_followup_free < 2) {
                                            $total_followup_patient += $data->patient_followup_free;
                                        // } else {
                                        //     $total_followup_patient2 += $data->patient_followup_free;
                                        // }
                                        // if ($data->total_appointment >= 0 && $data->total_appointment < 2) {
                                            $total_number_of_patient += $data->total_appointment;
                                        // } else {
                                        //     $total_number_of_patient2 += $data->total_appointment;
                                        // }
                                    @endphp
                                @endforeach
                                <tr>
                                    <td style="text-align:center">1</td>
                                    {{-- <td style="text-align:center">Morning</td>
                                                <td style="text-align:center">7:30 AM - 2:30 PM</td> --}}
                                    <td style="text-align:center">{{ $total_new_patient }}</td>
                                    <td style="text-align:center">{{ $total_free_patient }}</td>
                                    <td style="text-align:center">{{ $total_followup_patient }}</td>
                                    <td style="text-align:center">{{ $total_number_of_patient }}</td>

                                </tr>
                               {{-- <tr>
                                    <td style="text-align:center">2</td>
                                     <td style="text-align:center">Evening</td>
                                                <td style="text-align:center"></td>
                                    <td style="text-align:center">{{ $total_new_patient2 }}</td>
                                    <td style="text-align:center">{{ $total_free_patient2 }}</td>
                                    <td style="text-align:center">{{ $total_followup_patient2 }}</td>
                                    <td style="text-align:center">{{ $total_number_of_patient2 }}</td>

                                </tr> --}}

                            </tbody>
                            <tfoot>
                                <tr>
                                    <td style="text-align:right"> <strong> Total = </strong> </td>
                                    {{-- <td style="text-align:right" colspan="3"> <strong> Total = </strong> </td> --}}
                                    {{-- <td style="text-align:center"> <strong>
                                            {{ $total_new_patient + $total_new_patient2 }} </strong></td>
                                    <td style="text-align:center"> <strong>
                                            {{ $total_free_patient + $total_free_patient2 }} </strong></td>
                                    <td style="text-align:center"> <strong>
                                            {{ $total_followup_patient + $total_followup_patient2 }} </strong></td>
                                    <td style="text-align:center"> <strong>
                                            {{ $total_number_of_patient + $total_number_of_patient2 }} </strong></td> --}}


                                            <td style="text-align:center"> <strong>
                                            {{ $total_new_patient }} </strong></td>
                                    <td style="text-align:center"> <strong>
                                            {{ $total_free_patient }} </strong></td>
                                    <td style="text-align:center"> <strong>
                                            {{ $total_followup_patient }} </strong></td>
                                    <td style="text-align:center"> <strong>
                                            {{ $total_number_of_patient}} </strong></td>
                                </tr>
                            </tfoot>
                        @endif

                    </table>
                    <table style="width:100%;border-collapse:collapse; margin-top:20px" cellpadding="1" cellspacing="0"
                        border="1">
                        <thead class="bg-primary">
                            <tr>
                                <td colspan='5' style='text-align:center'> <strong>EMERGENCY OPD</strong></td>
                                {{-- <td colspan='7' style='text-align:center'> <strong>EMERGENCY OPD</strong></td> --}}
                            </tr>
                            <tr>
                                <th style="text-align:center">SL#</th>
                                {{-- <th style="text-align:center">SHIFT</th>
                                <th style="text-align:center">TIME</th> --}}
                                <th style="text-align:center">New Patients</th>
                                <th style="text-align:center">Free Patients</th>
                                <th style="text-align:center">Follow Up/Old Patients</th>
                                <th style="text-align:center">Total Patients</th>
                            </tr>
                        </thead>
                        @if (!empty($doctorPerformanceSummaryEmr))
                            <tbody>
                                @php
                                    $total_new_patient = 0;
                                    $total_free_patient = 0;
                                    $total_followup_patient = 0;
                                    $total_number_of_patient = 0;
                                    $total_new_patient2 = 0;
                                    $total_free_patient2 = 0;
                                    $total_followup_patient2 = 0;
                                    $total_number_of_patient2 = 0;
                                    $total_new_patient3 = 0;
                                    $total_free_patient3 = 0;
                                    $total_followup_patient3 = 0;
                                    $total_number_of_patient3 = 0;

                                @endphp
                                @foreach ($doctorPerformanceSummaryEmr as $data)
                                    @php

                                        // if ($data->patient_new_paid >= 0 && $data->patient_new_paid < 2) {
                                            $total_new_patient += $data->patient_new_paid;
                                        // } elseif ($data->patient_new_paid >= 2 && $data->patient_new_paid < 50) {
                                        //     $total_new_patient2 += $data->patient_new_paid;
                                        // } elseif ($data->patient_new_paid >= 50) {
                                        //     $total_new_patient2 += $data->patient_new_paid;
                                        // }

                                        // if ($data->patient_free >= 0 && $data->patient_free < 2) {
                                            $total_free_patient += $data->patient_free;
                                        // } elseif ($data->patient_free >= 2 && $data->patient_free < 50) {
                                        //     $total_free_patient2 += $data->patient_free;
                                        // } elseif ($data->patient_free >= 50) {
                                        //     $total_free_patient3 += $data->patient_free;
                                        // }

                                        // if ($data->patient_followup_free >= 0 && $data->patient_followup_free < 2) {
                                            $total_followup_patient += $data->patient_followup_free;
                                        // } elseif ($data->patient_followup_free >= 2 && $data->patient_followup_free < 50) {
                                        //     $total_followup_patient2 += $data->patient_followup_free;
                                        // } elseif ($data->patient_followup_free >= 50) {
                                        //     $total_followup_patient3 += $data->patient_followup_free;
                                        // }
                                        // if ($data->total_appointment >= 0 && $data->total_appointment < 2) {
                                            $total_number_of_patient += $data->total_appointment;
                                        // } elseif ($data->total_appointment >= 2 && $data->total_appointment < 50) {
                                        //     $total_number_of_patient2 += $data->total_appointment;
                                        // } elseif ($data->total_appointment >= 50) {
                                        //     $total_number_of_patient3 += $data->total_appointment;
                                        // }
                                    @endphp
                                @endforeach
                                <tr>
                                    <td style="text-align:center">1</td>
                                    {{-- <td style="text-align:center">Morning</td>
                                                                <td style="text-align:center">7:30 AM - 2:30 PM</td> --}}
                                    <td style="text-align:center">{{ $total_new_patient }}</td>
                                    <td style="text-align:center">{{ $total_free_patient }}</td>
                                    <td style="text-align:center">{{ $total_followup_patient }}</td>
                                    <td style="text-align:center">{{ $total_number_of_patient }}</td>

                                </tr>
                               {{-- <tr>
                                    <td style="text-align:center">2</td>
                                     <td style="text-align:center">Evening</td>
                                                                <td style="text-align:center"></td>
                                    <td style="text-align:center">{{ $total_new_patient2 }}</td>
                                    <td style="text-align:center">{{ $total_free_patient2 }}</td>
                                    <td style="text-align:center">{{ $total_followup_patient2 }}</td>
                                    <td style="text-align:center">{{ $total_number_of_patient2 }}</td>

                                </tr>--}}
                                {{--<tr>
                                    <td style="text-align:center">3</td>
                                     <td style="text-align:center">Night</td>
                                                                <td style="text-align:center"></td>
                                    <td style="text-align:center">{{ $total_new_patient3 }}</td>
                                    <td style="text-align:center">{{ $total_free_patient3 }}</td>
                                    <td style="text-align:center">{{ $total_followup_patient3 }}</td>
                                    <td style="text-align:center">{{ $total_number_of_patient3 }}</td>

                                </tr>--}}

                            </tbody>
                            <tfoot>
                                <tr>
                                    <td style="text-align:right"> <strong> Total = </strong> </td>
                                    {{-- <td style="text-align:right" colspan="3"> <strong> Total = </strong> </td> --}}
                                    <td style="text-align:center"> <strong>
                                            {{ $total_new_patient  }} </strong></td>
                                    <td style="text-align:center"> <strong>
                                            {{ $total_free_patient  }} </strong></td>
                                    <td style="text-align:center"> <strong>
                                            {{ $total_followup_patient  }} </strong></td>
                                    <td style="text-align:center"> <strong>
                                            {{ $total_number_of_patient  }} </strong></td>
                                </tr>
                            </tfoot>
                        @endif

                    </table>
                    <table style="width:100%;border-collapse:collapse; margin-top:20px" cellpadding="1"
                        cellspacing="0" border="1">
                        <thead class="bg-primary">
                            <tr>
                                <td colspan='5' style='text-align:center'> <strong> EMERGENCY PROCEDURES</strong>
                                </td>
                                {{-- <td colspan='7' style='text-align:center'> <strong> EMERGENCY PROCEDURES</strong></td> --}}
                            </tr>
                            <tr>
                                <th style="text-align:center">SL#</th>
                                {{-- <th style="text-align:center">SHIFT</th>
                                <th style="text-align:center">TIME</th> --}}
                                <th style="text-align:center">New Patients</th>
                                <th style="text-align:center">Free Patients</th>
                                <th style="text-align:center">Follow Up/Old Patients</th>
                                <th style="text-align:center">Total Patients</th>
                            </tr>
                        </thead>
                        @if (!empty($emergencyProcedure))
                            <tbody>
                                @php
                                    $total_new_patient = 0;
                                    $total_free_patient = 0;
                                    $total_followup_patient = 0;
                                    $total_number_of_patient = 0;
                                    $total_new_patient2 = 0;
                                    $total_free_patient2 = 0;
                                    $total_followup_patient2 = 0;
                                    $total_number_of_patient2 = 0;
                                    $total_new_patient3 = 0;
                                    $total_free_patient3 = 0;
                                    $total_followup_patient3 = 0;
                                    $total_number_of_patient3 = 0;

                                @endphp
                                @foreach ($emergencyProcedure as $data)
                                    @php
                                        $total_patient = $data->patient_cnt_newcons + $data->free_patient + $data->patient_followup;

                                        // if ($data->patient_cnt_newcons >= 0 && $data->patient_cnt_newcons < 2) {
                                            $total_new_patient += $data->patient_cnt_newcons;
                                        // } elseif ($data->patient_cnt_newcons >= 2 && $data->patient_cnt_newcons < 50) {
                                        //     $total_new_patient2 += $data->patient_cnt_newcons;
                                        // } elseif ($data->patient_cnt_newcons >= 50) {
                                        //     $total_new_patient2 += $data->patient_cnt_newcons;
                                        // }

                                        // if ($data->free_patient >= 0 && $data->free_patient < 2) {
                                            $total_free_patient += $data->free_patient;
                                        // } elseif ($data->free_patient >= 2 && $data->free_patient < 50) {
                                        //     $total_free_patient2 += $data->free_patient;
                                        // } elseif ($data->free_patient >= 50) {
                                        //     $total_free_patient3 += $data->free_patient;
                                        // }

                                        // if ($data->patient_followup >= 0 && $data->patient_followup < 2) {
                                            $total_followup_patient += $data->patient_followup;
                                        // } elseif ($data->patient_followup >= 2 && $data->patient_followup < 50) {
                                        //     $total_followup_patient2 += $data->patient_followup;
                                        // } elseif ($data->patient_followup >= 50) {
                                        //     $total_followup_patient3 += $data->patient_followup;
                                        // }

                                        // if ($total_patient >= 0 && $total_patient < 2) {
                                            $total_number_of_patient += $total_patient;
                                        // } elseif ($total_patient >= 2 && $total_patient < 50) {
                                        //     $total_number_of_patient2 += $total_patient;
                                        // } elseif ($total_patient >= 50) {
                                        //     $total_number_of_patient3 += $total_patient;
                                        // }
                                    @endphp
                                @endforeach
                                <tr>
                                    <td style="text-align:center">1</td>
                                    {{-- <td style="text-align:center">Morning</td>
                                                                <td style="text-align:center">7:30 AM - 2:30 PM</td> --}}
                                    <td style="text-align:center">{{ $total_new_patient }}</td>
                                    <td style="text-align:center">{{ $total_free_patient }}</td>
                                    <td style="text-align:center">{{ $total_followup_patient }}</td>
                                    <td style="text-align:center">{{ $total_number_of_patient }}</td>

                                </tr>
                               {{-- <tr>
                                    <td style="text-align:center">2</td>
                                     <td style="text-align:center">Evening</td>
                                                                <td style="text-align:center"></td>
                                    <td style="text-align:center">{{ $total_new_patient2 }}</td>
                                    <td style="text-align:center">{{ $total_free_patient2 }}</td>
                                    <td style="text-align:center">{{ $total_followup_patient2 }}</td>
                                    <td style="text-align:center">{{ $total_number_of_patient2 }}</td>

                                </tr>--}}
                                {{--<tr>
                                    <td style="text-align:center">3</td>
                                     <td style="text-align:center">Night</td>
                                                                <td style="text-align:center"></td>
                                    <td style="text-align:center">{{ $total_new_patient3 }}</td>
                                    <td style="text-align:center">{{ $total_free_patient3 }}</td>
                                    <td style="text-align:center">{{ $total_followup_patient3 }}</td>
                                    <td style="text-align:center">{{ $total_number_of_patient3 }}</td>

                                </tr>
--}}
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td style="text-align:right"> <strong> Total = </strong> </td>
                                    {{-- <td style="text-align:right" colspan="3"> <strong> Total = </strong> </td> --}}
                                    <td style="text-align:center"> <strong>
                                            {{ $total_new_patient  }} </strong></td>
                                    <td style="text-align:center"> <strong>
                                            {{ $total_free_patient  }} </strong></td>
                                    <td style="text-align:center"> <strong>
                                            {{ $total_followup_patient  }} </strong></td>
                                    <td style="text-align:center"> <strong>
                                            {{ $total_number_of_patient  }} </strong></td>
                                </tr>
                            </tfoot>
                        @endif

                    </table>
                    <table style="width:100%;border-collapse:collapse; margin-top:20px" cellpadding="1"
                        cellspacing="0" border="1">
                        <thead class="bg-primary">
                            <tr>
                                <td colspan='7' style='text-align:center'>
                                    <strong> DEPARTMENT WISE OPD PATIENT CLASSIIFICATION</strong>
                                </td>
                            </tr>
                            <tr>
                                <th style="text-align:center">SL#</th>
                                <th style="text-align:left">DEPARTMENT</th>
                                <th style="text-align:center">New Patients</th>
                                <th style="text-align:center">Free Patients</th>
                                <th style="text-align:center">Follow Up/Old Patients</th>
                                <th style="text-align:center">Total Patients</th>
                                <th style="text-align:center">Remarks</th>
                            </tr>
                        </thead>
                        @if (!empty($doctorPerformanceSummarydept))
                            <tbody>
                                @php
                                    $total_new_patient = 0;
                                    $total_free_patient = 0;
                                    $total_followup_patient = 0;
                                    $total_number_of_patient = 0;

                                @endphp
                                @foreach ($doctorPerformanceSummarydept as $data)
                                    @php
                                        $total_new_patient += $data->patient_new_paid;
                                        $total_free_patient += $data->patient_free;
                                        $total_followup_patient += $data->patient_followup_free;
                                        $total_number_of_patient += $data->total_appointment;
                                    @endphp
                                    <tr>
                                        <td style="text-align:center">{{ $loop->iteration }}</td>
                                        <td style="text-align:left">{{ ucfirst($data->serviceunit_name) }}</td>
                                        <td style="text-align:center">{{ $data->patient_new_paid }}</td>
                                        <td style="text-align:center">{{ $data->patient_free }}</td>
                                        <td style="text-align:center">{{ $data->patient_followup_free }}</td>
                                        <td style="text-align:center">{{ $data->total_appointment }}</td>
                                        <td style="text-align:center"></td>

                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td style="text-align:right" colspan="2"> <strong> Total = </strong> </td>
                                    <td style="text-align:center"> <strong> {{ $total_new_patient }} </strong></td>
                                    <td style="text-align:center"> <strong> {{ $total_free_patient }} </strong></td>
                                    <td style="text-align:center"> <strong> {{ $total_followup_patient }} </strong>
                                    </td>
                                    <td style="text-align:center"> <strong> {{ $total_number_of_patient }} </strong>
                                    </td>
                                    <td style="text-align:center"></td>
                                </tr>
                            </tfoot>
                        @endif

                    </table>
                    {{-- <table style="width:100%;border-collapse:collapse; margin-top:20px" cellpadding="1" cellspacing="0" border="1">
                        <thead class="bg-primary">
                            <tr>
                                <td colspan='7' style='text-align:center'> <strong> OPD CLASSIFICATION OF EMERGENCY STATUS</strong></td>
                            </tr>
                            <tr>
                                <th style="text-align:center">SL#</th>
                                <th style="text-align:left">DEPARTMENT</th>
                                <th style="text-align:center">New Patients</th>
                                <th style="text-align:center">Free Patients</th>
                                <th style="text-align:center">Follow Up/Old Patients</th>
                                <th style="text-align:center">Total Patients</th>
                                <th style="text-align:center">Remarks</th>
                            </tr>
                        </thead>
                        @if (!empty($doctorPerformanceSummary))
                        <tbody>
                            @php
                            $total_new_patient = 0;
                            $total_free_patient = 0;
                            $total_followup_patient = 0;
                            $total_number_of_patient = 0;

                            @endphp
                            @foreach ($doctorPerformanceSummary as $data)
                            @php
                            $total_new_patient += $data->patient_new_paid;
                            $total_free_patient += $data->patient_free;
                            $total_followup_patient += $data->patient_followup_free;
                            $total_number_of_patient += $data->total_appointment;
                            @endphp
                            <tr>
                                <td style="text-align:center">{{$loop->iteration}}</td>
                                <td style="text-align:left">DEPARTMENT</td>
                                <td style="text-align:center">{{ $total_new_patient}}</td>
                                <td style="text-align:center">{{ $total_free_patient}}</td>
                                <td style="text-align:center">{{ $total_followup_patient}}</td>
                                <td style="text-align:center">{{ $total_number_of_patient}}</td>
                                <td style="text-align:center"></td>

                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td style="text-align:right" colspan="2"> <strong> Total = </strong> </td>
                                <td style="text-align:center"> <strong> {{ $total_new_patient }} </strong></td>
                                <td style="text-align:center"> <strong> {{ $total_free_patient }} </strong></td>
                                <td style="text-align:center"> <strong> {{ $total_followup_patient }} </strong></td>
                                <td style="text-align:center"> <strong> {{ $total_number_of_patient }} </strong></td>
                                <td style="text-align:center"></td>
                            </tr>
                        </tfoot>
                        @endif

                    </table> --}}
                </div>
            </section>
        </div>
    </main>

</body>

</html>
