@php
$hospital = DB::table('wsec_hospital')
->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
->first();
$body_mt = $hospital->hospital_code == 'GMC' ? '3.5' : '3.9';
$sig_mb = ($hospital->hospital_code == 'IMPERIAL') ? '3' : '0';
$footer_mb = ($hospital->hospital_code == 'IMPERIAL') ? '1.4' : '0';
$dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));

$date = $dt->format('g:i A');
@endphp

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Radiology Report</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    {{-- <link rel="stylesheet" href="{{ public_path().'/css/print.css' }}" media="print"> --}}
    {{-- <link rel="stylesheet" href="css/invoice.css" media="all" /> --}}
    <style>
        @page {
            margin-top: <?= $body_mt ?>cm;
            margin-bottom: 0cm;
            margin-left: 0cm;
            margin-right: 0cm;

            /* height: 29.7cm;
               width: 21 cm; */
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
            top: 1cm;
            height: 2.5cm;
            border-bottom: none !important;
            /* left: 0;
            right: 0;
            height: 2.5cm;
            font-size: 9px; */
            /*top: -10px;*/
            /* border-top: 1px solid black;
            padding-top: 10px;
            z-index: 999999999; */
        }

        header img {
            /*width: 80px;*/
        }

        /** Define now the real margins of every page in the PDF **/
        body {

            margin-left: 0.5cm;
            margin-right: 1.5cm;
            margin-bottom: 3.5cm;
            font-family: 'Roboto', sans-serif;
            font-size: 18px;

        }



        .footer {
            position: fixed;
            z-index: 999999999;
            left: 1cm;
            right: 1cm;
            height: 1.1cm;
            vertical-align: text-bottom;
            padding-top: 10px;
            /* text-align: center; */
            font-size: 7px;
            bottom: 1.4cm;
            bottom: <?= $footer_mb ?>cm;

            /*border-top: 1px solid black;*/
        }

        .footer_2 {

            /* position: fixed;

            z-index: 999999999;

            bottom: <?= $sig_mb ?>cm;

            left: 1cm;

            right: 1cm; */

            height: 4.3cm;

            vertical-align: text-top !important;

            padding-bottom: 45px;
            margin-left: 20px;


            /* text-align: center; */

            /* font-size: 9px; */


            display: flex;
            flex-direction: column;
            justify-content: end;

        }

        /* .signature_ {
            position: fixed;
            bottom: .5cm;
            left: .8cm;
            right: .8cm;
            height: 3.3cm;
        
        } */
    </style>
</head>

<body onload="window.print()">

    @if (is_array($radiology_appointment_data))
    @foreach ($radiology_appointment_data as $key => $value)

    <table>
        <thead>
            <tr>
                <th>
                    @if ($po_hospital_details->report_header_image_prshde_ind == 1)

                    <table style="width: 100%;" class="signature">

                        @if ($po_hospital_details->report_header_image_prshde_ind == 1)

                        @if ($po_hospital_details->hospital_code != 'KBMH')
                        <tr>

                            <td style="width: 10%;">

                                <img class="hospital-logo" src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}" style="background-color: {{ $po_hospital_details->logo_background_color }}; width:70px " alt="">
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



                        </tr>
                        @endif
                        @else
                        <tr>

                            <td style="text-align: center ">



                                <img class="hospital-logo" src="{{ asset('images/uploads/hospital_images/' . $po_hospital_details->report_header_image) }}" width="250" alt="">

                            </td>

                        </tr>
                        @endif

                    </table>

                    @endif
                    <table style="width: 100%;" style="padding: 0px; margin:0px" class="header-barcode">
                        <tr>
                            <td style="text-align:left" width="30%"> <img style="" src="data:image/png;base64, {{ $app_barcode }} " style="width: 120px; " />
                                <br>
                                <strong>Report ID</strong>: {{ $value->rad_report_no_pk }}
                            </td>
                            <td style="text-align: center"> </td>
                            <td style="text-align: right" width="30%">
                                <img style="" src="data:image/png;base64, {{ $invoice_barcode }} " style="width: 120px; " /> <br>
                                <strong>Invoice ID</strong>: {{ $value->invoice_code }}
                            </td>
                        </tr>
                    </table>

                    <table style="width: 100%; border:1px solid #999; border-radius:10px; font-size: 13px;">
                        <tr>
                            <td width="20%" style="padding-left:20px;padding-right:20px;"><strong>Patient
                                    Name</strong>
                            </td>
                            <td width="2%" style="padding-left:10px;padding-right:10px;">:</td>
                            <td style="text-align: left;padding-left:10px;padding-right:10px;" width="40%">
                                {{ $patient_info->patient_name }}
                            </td>

                            <td width="20%" style="padding-left:20px;padding-right:20px;"><strong>Patient
                                    ID</strong></td>
                            <td width="2%" style="padding-left:10px;padding-right:10px;">:</td>
                            <td style="text-align: left;padding-left:10px;padding-right:10px;">
                                {{ $radiology_appointment_data->patient_no_fk }}
                            </td>

                            {{-- <td width="15%" style="text-align: right;padding-left:20px;padding-right:20px;">
                                        <strong>Invoice ID</strong></td>
                                    <td width="2%" style="padding-left:10px;padding-right:10px;">:</td>
                                    <td width="15%" style="text-align: right;padding-left:10px;padding-right:10px;">
                                        {{ $radiology_appointment_data->invoice_code }}</td> --}}
                        </tr>



                        <tr>
                            <td width="10%" style="padding-left:20px;padding-right:20px;"><strong>Age
                                </strong>
                            </td>
                            <td width="2%" style="padding-left:10px;padding-right:10px;">:</td>
                            <td style="text-align: left;padding-left:10px;padding-right:10px;">
                                {{ $patient_info->age }}
                            </td>

                            <td width="15%" style="padding-left:20px;padding-right:20px;"><strong>Accession
                                    ID</strong></td>
                            <td width="2%" style="padding-left:10px;padding-right:10px;">:</td>
                            <td style="text-align: left;padding-left:10px;padding-right:10px;">
                                {{ $radiology_appointment_data->accession_id }}
                            </td>

                            {{-- <td width="15%" style="text-align: right;padding-left:20px;padding-right:20px;">
                                        <strong>LAB. No</strong></td>
                                    <td width="2%" style="padding-left:10px;padding-right:10px;">:</td>
                                    <td width="15%" style="text-align: right;padding-left:10px;padding-right:10px;">
                                        {{ $radiology_appointment_data->rad_report_uid }}</td> --}}
                        </tr>
                        <tr>


                            <td width="15%" style="text-align: left;padding-left:20px;padding-right:20px;">
                                <strong>Gender </strong>
                            </td>
                            <td width="2%" style="padding-left:10px;padding-right:10px;">:</td>
                            <td width="15%" style="text-align: left;padding-left:10px;padding-right:10px;">
                                {{ $patient_info->gender_txt }}
                            </td>

                            <td width="15%" style="padding-left:20px;padding-right:20px;"><strong>Report
                                    Date</strong></td>
                            <td width="2%" style="padding-left:10px;padding-right:10px;">:</td>
                            <td style="text-align: left;padding-left:10px;padding-right:10px;">
                                {{ date('d/m/Y', strtotime($radiology_appointment_data->img_app_dttm)) }}
                            </td>

                        </tr>
                        <tr>
                            <td width="10%" style="padding-left:20px;padding-right:20px;"><strong>Ref
                                    By</strong>
                            </td>
                            <td width="2%" style="padding-left:10px;padding-right:10px;">:</td>
                            <td style="text-align: left;padding-left:10px;padding-right:10px;" colspan="3">
                                {{ $radiology_appointment_data->ref_doc_name }}
                            </td>
                            {{-- <td width="15%" style="text-align: right;padding-left:20px;padding-right:20px;">
                                        <strong>Result Date</strong></td>
                                    <td width="2%" style="padding-left:10px;padding-right:10px;">:</td>
                                    <td width="15%" style="text-align: right;padding-left:10px;padding-right:10px;">
                                        {{ date('d/m/Y', strtotime($radiology_appointment_data->delivery_dttm)) }}
                            </td> --}}
                            <br>
                        </tr>
                    </table>
                </th>
            </tr>

        </thead>
        <tbody>
            <tr>
                <th>
                    <div style="margin-top:5px;  text-align:center; width: 100%; padding-top:10px;">
                        <span class="report-name" style="width:100%;  font-size: 20px;  padding:2px; border-bottom: 1px solid rgb(29, 27, 27) ;">
                            <strong>
                                @php
                                echo $value->item_name;
                                @endphp
                            </strong>
                        </span>
                    </div>


                    <div style="margin-bottom:5px; margin-top:5px;" class="mb-2">
                        <div class="find" style=" margin-left: 80px;">
                            <table id="findings">
                                <tr>
                                    <div style="">
                                        <span style=" font-size: 15px"> @php
                                            echo $value->result0;
                                            @endphp
                                        </span>
                                    </div>
                                    <h2><strong>Findings:</strong></h2>
                                </tr>
                            </table>
                        </div>
                    </div>
                </th>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <th>

                    <table style="width: 100%; font-size: 13px; " class="footer_2">
                        <tr>
                            <td width="30%" style="text-align: left; vertical-align: text-top ">
                                @if ($radiology_appointment_data->prepared_full_name != '')
                                <i>Prepared BY</i>
                                {{-- <div><strong>{{ $report_header->prepared_by }}</strong></div> --}}
                                <div>@php echo $radiology_appointment_data->doctor_signature_pr @endphp</div>
                                <!-- <div>Certified Ortopedic Surgeon</div> -->
                                @endif
                            </td>
                            <td style="text-align: left; vertical-align: text-top">
                                @if ($radiology_appointment_data->verify_full_name != '')
                                <i>Verified BY</i>
                                {{-- <div><strong>{{ $report_header->verified_by }}</strong></div> --}}
                                <div>@php echo $radiology_appointment_data->doctor_signature_vr @endphp</div>
                                @endif
                            </td>
                            <td width="30%" class="text-left" style="vertical-align: text-top">
                                @if ($radiology_appointment_data->final_full_name != '')
                                <i>Finalized BY</i>
                                {{-- <div><strong>{{ $report_header->finalized_by }}</strong></div> --}}
                                <div>@php echo $radiology_appointment_data->doctor_signature_fin @endphp</div>
                                @endif
                            </td>
                        </tr>
                    </table>
                    <?php

                    $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));

                    $date = $dt->format('g:i A');

                    ?>

                    <table style="margin-bottom:20px" class="footer">
                        <tr>
                            <td style="border: 0px; padding-top: 5px; text-align: left;">Prepared By:
                                {{ Session::get('user.ses_user_name') }},
                                Printing Date & Time: {{ date('d/m/Y') }} , {{ $date }},

                                &nbsp;Powered By: [NEXTGEN]
                            </td>

                        </tr>
                    </table>

                </th>
            </tr>
        </tfoot>

    </table>

    @if ($loop->iteration != count($radiology_appointment_data))
    <div class="page-break"></div>
    @endif
    @endforeach
    @else
    <table style="width: 100%;">
        <thead>
            <tr>
                <th>
                    @if ($po_hospital_details->report_header_image_prshde_ind == 1)

                    <table style="width: 100%;" class="signature">

                        @if ($po_hospital_details->report_header_image_prshde_ind == 1)

                        @if ($po_hospital_details->hospital_code != 'KBMH')
                        <tr>

                            <td style="width: 10%;">

                                <img class="hospital-logo" src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}" style="background-color: {{ $po_hospital_details->logo_background_color }}; width:70px " alt="">
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



                        </tr>
                        @endif
                        @else
                        <tr>

                            <td style="text-align: center ">



                                <img class="hospital-logo" src="{{ asset('images/uploads/hospital_images/' . $po_hospital_details->report_header_image) }}" width="250" alt="">

                            </td>

                        </tr>
                        @endif

                    </table>

                    @endif
                    <table width="100%" style="padding: 0px; margin-left:30px;margin-right:30px;" class="header-barcode">
                        <tr>
                            <td style="text-align:left" width="30%"> <img style="" src="data:image/png;base64,{{ $app_barcode }} " style="width: 120px; " />
                                <br>
                                <strong>Report ID</strong>:
                                {{ $radiology_appointment_data->rad_report_no_pk }}
                            </td>
                            <td style="text-align: center">
                                <h2 style="text-align: center; margin: 0 auto; padding: 5px; width: 100%; font-size: 20px">
                                    {{ strtoupper($radiology_appointment_data->serviceunit_name) }} REPORT
                                </h2>
                            </td>
                            <td style="text-align: right" width="30%">
                                <img style="" src="data:image/png;base64, {{ $invoice_barcode }} " style="width: 120px; " /> <br>
                                <strong>Invoice ID</strong>: {{ $radiology_appointment_data->invoice_code }}
                            </td>
                        </tr>
                    </table>

                    <table style="width: 100%; border:1px solid #999; border-radius:10px; font-size: 14px; margin-left:25px;margin-right:25px;">
                        <tr>
                            <td width="20%" style="padding-left:20px;padding-right:20px;"><strong>Patient
                                    Name</strong>
                            </td>
                            <td width="2%" style="padding-left:10px;padding-right:10px;">:</td>
                            <td style="text-align: left;padding-left:10px;padding-right:10px;" width="40%">
                                {{ !empty($patient_info->salutation) ? ucfirst($patient_info->salutation) : '' }}
                                {{ $patient_info->patient_name }}
                            </td>

                            <td width="20%" style="padding-left:20px;padding-right:20px;"><strong>Patient
                                    ID</strong></td>
                            <td width="2%" style="padding-left:10px;padding-right:10px;">:</td>
                            <td style="text-align: left;padding-left:10px;padding-right:10px;">
                                {{ $radiology_appointment_data->patient_no_fk }}
                            </td>

                            {{-- <td width="15%" style="text-align: right;padding-left:20px;padding-right:20px;">
                                       <strong>Invoice ID</strong></td>
                                   <td width="2%" style="padding-left:10px;padding-right:10px;">:</td>
                                   <td width="15%" style="text-align: right;padding-left:10px;padding-right:10px;">
                                       {{ $radiology_appointment_data->invoice_code }}</td> --}}
                        </tr>
                        <tr>
                            <td width="10%" style="padding-left:20px;padding-right:20px;"><strong>Age </strong>
                            </td>
                            <td width="2%" style="padding-left:10px;padding-right:10px;">:</td>
                            <td style="text-align: left;padding-left:10px;padding-right:10px;">
                                {{ $patient_info->age }}
                            </td>

                            <td width="15%" style="padding-left:20px;padding-right:20px;"><strong>Accession
                                    ID</strong></td>
                            <td width="2%" style="padding-left:10px;padding-right:10px;">:</td>
                            <td style="text-align: left;padding-left:10px;padding-right:10px;">
                                {{ $radiology_appointment_data->accession_id }}
                            </td>

                            {{-- <td width="15%" style="text-align: right;padding-left:20px;padding-right:20px;">
                                       <strong>LAB. No</strong></td>
                                   <td width="2%" style="padding-left:10px;padding-right:10px;">:</td>
                                   <td width="15%" style="text-align: right;padding-left:10px;padding-right:10px;">
                                       {{ $radiology_appointment_data->rad_report_uid }}</td> --}}
                        </tr>
                        <tr>


                            <td width="15%" style="text-align: left;padding-left:20px;padding-right:20px;">
                                <strong>Gender </strong>
                            </td>
                            <td width="2%" style="padding-left:10px;padding-right:10px;">:</td>
                            <td width="15%" style="text-align: left;padding-left:10px;padding-right:10px;">
                                {{ $patient_info->gender_txt }}
                            </td>


                            <td width="15%" style="padding-left:20px;padding-right:20px;"><strong>Report
                                    Date</strong></td>
                            <td width="2%" style="padding-left:10px;padding-right:10px;">:</td>
                            <td style="text-align: left;padding-left:10px;padding-right:10px;">
                                {{ !empty($radiology_appointment_data->img_app_dttm) ? date('d/m/Y', strtotime($radiology_appointment_data->img_app_dttm)) : date('d/m/Y'), $date }}
                            </td>

                        </tr>
                        <tr>
                            <td width="10%" style="padding-left:20px;padding-right:20px;">


                                @if ($po_hospital_details->hospital_code == 'GMC')
                                <strong>Consultant/Doctor</strong>
                                @else
                                <strong>Ref By</strong>
                                @endif



                            </td>
                            <td width="2%" style="padding-left:10px;padding-right:10px;">:</td>
                            <td style="text-align: left;padding-left:10px;padding-right:10px;" colspan="5">
                                {{ $radiology_appointment_data->ref_doc_name }}

                            </td>
                            {{-- <td width="15%" style="text-align: right;padding-left:20px;padding-right:20px;">
                                       <strong>Result Date</strong></td>
                                   <td width="2%" style="padding-left:10px;padding-right:10px;">:</td>
                                   <td width="15%" style="text-align: right;padding-left:10px;padding-right:10px;">
                                       {{ date('d/m/Y', strtotime($radiology_appointment_data->delivery_dttm)) }}
                            </td> --}}
                            <br>
                        </tr>
                        @if (!empty($patient_info->passport_no))

                        <tr>
                            <td width="20%" style="padding-left:20px;padding-right:20px;"><strong>Passport No</strong>
                            </td>
                            <td width="2%" style="padding-left:10px;padding-right:10px;">:</td>
                            <td style="text-align: left;padding-left:10px;padding-right:10px;" colspan="4">{{$patient_info->passport_no}}</td>


                            {{-- <td width="15%" style="text-align: right;padding-left:20px;padding-right:20px;">
                                        <strong>Invoice ID</strong></td>
                                    <td width="2%" style="padding-left:10px;padding-right:10px;">:</td>
                                    <td width="15%" style="text-align: right;padding-left:10px;padding-right:10px;">
                                        {{ $radiology_appointment_data->invoice_code }}</td> --}}
                        </tr>
                        @endif
                    </table>
                </th>
            </tr>

        </thead>
        <tbody>
            <tr>
                <th>
                    @if (strtoupper($radiology_appointment_data->serviceunit_name != 'ECHO'))
                    <div style="margin-top:2px;  text-align:center; width: 100%; padding-top:4px;">
                        <span class="report-name" style="width:100%;  font-size: 18px;  padding:2px; border-bottom: 1px solid rgb(29, 27, 27) ;">
                            <strong>
                                @php
                                echo $radiology_appointment_data->item_name;
                                @endphp
                            </strong>
                        </span>
                    </div>
                    @endif



                    <div style="margin-bottom:5px; margin-top:5px; ">
                        <div class="find" style="margin-left: 40px;">
                            <table id="findings">
                                <tr>
                                    <td>
                                        <span style=" font-size: 14px"> @php
                                            echo $radiology_appointment_data->result0;
                                            @endphp
                                        </span>

                                    </td>
                                    {{-- <h2><strong>Findings:</strong></h2> --}}
                                </tr>
                            </table>
                        </div>
                    </div>
                </th>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <th>

                    <table style="width: 100%; font-size: 13px; " class="footer_2">
                        @if($po_hospital_details->hospital_code == "GMC")
                        <tr>

                            <td width="45%" class="text-left" style="vertical-align: text-top">
                                @if ($radiology_appointment_data->prepared_full_name != '')
                                <div>@php echo $radiology_appointment_data->doctor_signature_pr @endphp</div>
                                @endif

                            </td>


                            <td width="55%" style="text-align: left; vertical-align: text-top">
                                @if ($radiology_appointment_data->final_full_name != '')

                                <div>@php echo $radiology_appointment_data->doctor_signature_fin @endphp</div>
                                @endif

                            </td>
                        </tr>

                        @else
                        <tr>
                            <td width="55%" style="text-align: left; vertical-align: text-top">
                                @if ($radiology_appointment_data->final_full_name != '')

                                <div>@php echo $radiology_appointment_data->doctor_signature_fin @endphp</div>
                                @endif

                            </td>


                            <td width="45%" class="text-left" style="vertical-align: text-top">
                                @if ($radiology_appointment_data->prepared_full_name != '')
                                <div>@php echo $radiology_appointment_data->doctor_signature_pr @endphp</div>
                                @endif

                            </td>
                        </tr>


                        @endif

                    </table>
                    <?php

                    $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));

                    $date = $dt->format('g:i A');

                    ?>

                    <table style="margin-bottom:20px" class="footer">
                        <tr>
                            <td style="border: 0px; padding-top: 5px; text-align: left;">Prepared By:
                                {{ Session::get('user.ses_user_name') }},
                                Printing Date & Time: {{ date('d/m/Y') }} , {{ $date }},

                                &nbsp;Powered By: [NEXTGEN]
                            </td>

                        </tr>
                    </table>

                </th>
            </tr>
        </tfoot>

    </table>
    @endif
</body>