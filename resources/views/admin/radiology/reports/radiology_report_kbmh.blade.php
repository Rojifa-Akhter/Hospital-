@php
    $hospital = DB::table('wsec_hospital')
        ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
        ->first();
    $body_mt = $hospital->hospital_code == 'GMC' ? '3.5' : '3.5';
@endphp
<!DOCTYPE html>
<html>

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
            margin-top: 0cm;
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
            margin-top: <?=$body_mt ?>cm;
            margin-left: 1.5cm;
            margin-right: 1.5cm;
            margin-bottom: 3.5cm;
            font-family: 'Roboto', sans-serif;
            font-size: 13px;
        }

        footer {
            position: fixed;
            z-index: 999999999;
            left: 1cm;
            right: 1cm;
            height: 1.1cm;
            vertical-align: text-bottom;
            padding-top: 10px;
            /* text-align: center; */
            font-size: 9px;
            bottom: 20px;
            /*border-top: 1px solid black;*/
        }

        .footer_2 {

            position: fixed;

            z-index: 999999999;

            bottom: 0cm;

            left: 1cm;

            right: 1cm;

            height: 4.3cm;

            vertical-align: text-top !important;

            padding-bottom: 15px;
            margin-left: 20px;


            /* text-align: center; */

            /* font-size: 9px; */

        }

        .signature_ {
            position: fixed;
            bottom: .5cm;
            left: .8cm;
            right: .8cm;
            /*width: 100%;*/
            height: 3.3cm;
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

        .header-barcode {
            margin-left: 25px !important;
            margin-right: 25px !important;
        }

        .border-kbmh {
            border: 1px solid black;
            border-collapse: collapse;
        }

        .border-kbmh-2 {
            border: 3px solid black;
            border-collapse: collapse;
        }

        .border-right {
            border-right: 1px solid black;
        }

        .barcode-css {
            width: 100%;
            margin-top: 5px;
            margin-bottom: 25px;
            border-top: 1px solid #000;
            border-left: 3px solid #000;
            border-right: 3px solid #000;
            border-bottom: 3px solid #000;
        }

        /* p {
               margin: 0px;
               padding: 0px;
           } */
    </style>
</head>
@if (is_array($radiology_appointment_data))
    @foreach ($radiology_appointment_data as $key => $value)

        <body onload="window.print()">
            <header>
                @if ($po_hospital_details->report_header_image_prshde_ind == 1)
                    <table style="width: 100%;" class="signature">

                        @if ($po_hospital_details->report_header_image_prshde_ind == 1)
                            <tr>

                                <td style="width: 10%;">

                                    <img class="hospital-logo"
                                        src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}"
                                        style="background-color: {{ $po_hospital_details->logo_background_color }}; width:70px "
                                        alt="">
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

                                {{-- <td style=" text-align:right; width: 18%;">

                                    <img src="data:image/png;base64, {{ $barcode_no }} " style="width: 100%" />

                                </td> --}}

                            </tr>
                        @else
                            <tr>

                                <td style="text-align: center ">



                                    <img class="hospital-logo"
                                        src="{{ asset('images/uploads/hospital_images/' . $po_hospital_details->report_header_image) }}"
                                        width="250" alt="">

                                </td>

                            </tr>
                        @endif

                    </table>
                @endif
            </header>

            <footer style="border-top: 1px solid transparent;">

                <?php

                $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));

                $date = $dt->format('g:i A');

                ?>
                <table style="">
                    <tr>
                        <td style="border: 0px; padding-top: 5px; text-align: left;">Prepared By:
                            {{ Session::get('user.ses_user_name') }},
                            Printing Date & Time: {{ date('d/m/Y') }} ,{{ $date }},

                            &nbsp;Powered By: [NEXTGEN]
                        </td>

                    </tr>
                </table>
            </footer>
            <main>
                <div class="wrapper">
                    <p
                        style="text-align: center; margin: 0 auto;  padding: 5px; width: 30%; font-size:20px !important;">
                        {{ strtoupper($radiology_appointment_data->serviceunit_name) }} REPORT</p>
                    <section>
                        <div>
                            <table width="100%" style="padding: 0px; margin:0px" class="header-barcode">
                                <tr>
                                    <td style="text-align:left" width="30%"> <img style=""
                                            src="data:image/png;base64, {{ $app_barcode }} " style="width: 120px; " />
                                        <br>
                                        <strong>Report ID</strong>: {{ $value->rad_report_no_pk }}
                                    </td>
                                    <td style="text-align: center"> </td>
                                    <td style="text-align: right" width="30%">
                                        <img style="" src="data:image/png;base64, {{ $invoice_barcode }} "
                                            style="width: 120px; " /> <br>
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
                                        {{ $patient_info->patient_name }}</td>

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
                                        {{ $patient_info->age }} </td>

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
                                        {{ $patient_info->gender_txt }}</td>

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
                                        {{ $radiology_appointment_data->ref_doc_name }}</td>
                                    {{-- <td width="15%" style="text-align: right;padding-left:20px;padding-right:20px;">
                                        <strong>Result Date</strong></td>
                                    <td width="2%" style="padding-left:10px;padding-right:10px;">:</td>
                                    <td width="15%" style="text-align: right;padding-left:10px;padding-right:10px;">
                                        {{ date('d/m/Y', strtotime($radiology_appointment_data->delivery_dttm)) }}
                                    </td> --}}
                                    <br>
                                </tr>
                            </table>
                            <div style="margin-top:5px;  text-align:center; width: 100%; padding-top:10px;">
                                <span class="report-name"
                                    style="width:100%;  font-size: 20px;  padding:2px; border-bottom: 1px solid rgb(29, 27, 27) ;">
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
                    </section>
                </div>
            </main>
            {{-- <div>
                   <table style="width: 100%; font-size: 13px; " class="footer_2">
                       <tr style=" ">
                           <td width="">
                               @if ($value->prepared_full_name != null)
                                   <i>Prepared BY</i>
                                   <div>
                                       <strong>{{ $value->prepared_full_name }}</strong>
                                   </div>
                                   <div>
                                       @php echo $value->doctor_signature_pr @endphp
                                   </div>
                               @endif
                           </td>
                           <td style="text-align: center;">
                               @if ($value->verify_full_name != null)
                                   <i>Verified BY</i>
                                   <div><strong>{{ $value->verify_full_name }}</strong></div>
                                   <div>
                                       @php echo $value->doctor_signature_vr @endphp
                                   </div>
                               @endif
                           </td>
                           <td style="float:right; text-align: right;">
                               @if ($value->final_full_name != null)
                                   <i>Finalized BY</i>
                                   <div><strong>{{ $value->final_full_name }}</strong></div>
                                   <div>
                                       @php echo $value->doctor_signature_fin @endphp
                                   </div>
                               @endif
                           </td>
                       </tr>
                   </table>
               </div> --}}

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

        </body>
        @if ($loop->iteration != count($radiology_appointment_data))
            <div class="page-break"></div>
        @endif
    @endforeach
@else

    <body onload="window.print()">
        <header>
            {{-- <table style="width: 100%; border:5px solid transparent !important" class="signature">
            <tr style="">
                <td style="width: 15%; border-right:1px solid transparent!important">
                    <img class="hospital-logo"
                        src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}" width="60"
                        alt="">
                </td>
                <td style="text-align:center;">
                    <span style="font-size: 15px;"> <strong>
                            {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}</strong></span>
                    <br>
                    Address:<span>
                        {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</span><br>
                    Phone
                    No:<span>{{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</span>
                </td>
            </tr>
        </table> --}}
            @if ($po_hospital_details->report_header_image_prshde_ind == 1)

                <table style="width: 100%;" class="signature">

                    @if ($po_hospital_details->report_header_image_prshde_ind == 1)

                        @if ($po_hospital_details->hospital_code != 'KBMH')
                            <tr>

                                <td style="width: 10%;">

                                    <img class="hospital-logo"
                                        src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}"
                                        style="background-color: {{ $po_hospital_details->logo_background_color }}; width:70px "
                                        alt="">
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

                                {{-- <td style=" text-align:right; width: 18%;">

                            <img src="data:image/png;base64, {{ $barcode_no }} " style="width: 100%" />

                        </td> --}}

                            </tr>
                        @endif
                    @else
                        <tr>

                            <td style="text-align: center ">



                                <img class="hospital-logo"
                                    src="{{ asset('images/uploads/hospital_images/' . $po_hospital_details->report_header_image) }}"
                                    width="250" alt="">

                            </td>

                        </tr>
                    @endif

                </table>

            @endif
        </header>

        <footer style="border-top: 1px solid transparent;">
            <?php

            $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));

            $date = $dt->format('g:i A');

            ?>

            <table style="">
                <tr>
                    <td style="border: 0px; padding-top: 5px; text-align: left;">Prepared By:
                        {{ Session::get('user.ses_user_name') }},
                        Printing Date & Time: {{ date('d/m/Y') }} , {{ $date }},

                        &nbsp;Powered By: [NEXTGEN]
                    </td>

                </tr>
            </table>
        </footer>
        <main>
            <div class="wrapper" style="max-height:400px !important ">

                <section id="">

                    <div class="">



                        <table width="100%" style="padding: 0px; margin:0px">
                            <tr>
                                <th style="text-align: center;">
                                    <h2
                                        style="text-align: center;
                                        margin: -17px auto;
                                        padding: 5px;
                                        width: 50%;
                                        font-size: 20px;
                                        border: 2px solid rgb(102, 96, 96);
                                        background: #d9d4d4;">
                                        {{ strtoupper($radiology_appointment_data->serviceunit_name) }} REPORT</h2>
                                </th>
                            </tr>
                        </table>


                        <table style="width: 100%;" class="border-kbmh-2">
                            <tr class="border-kbmh">
                                <td width="20%" style="padding-left:20px;padding-right:20px;"><strong>Patient
                                        Name</strong>
                                </td>
                                <td width="2%" style="padding-left:10px;padding-right:10px;">:</td>
                                <td style="text-align: left;padding-left:10px;padding-right:10px;" width="40%"
                                    class="border-right">
                                    {{ !empty($patient_info->salutation) ? ucfirst($patient_info->salutation) : '' }}
                                    {{ $patient_info->patient_name }}</td>

                                <td width="20%" style="padding-left:20px;padding-right:20px;"><strong>Patient
                                        ID</strong></td>
                                <td width="2%" style="padding-left:10px;padding-right:10px;">:</td>
                                <td style="text-align: left;padding-left:10px;padding-right:10px;">
                                    {{ $radiology_appointment_data->patient_no_fk }}
                                </td>
                            </tr>
                            <tr class="border-kbmh">
                                <td width="10%" style="padding-left:20px;padding-right:20px;"><strong>Age </strong>
                                </td>
                                <td width="2%" style="padding-left:10px;padding-right:10px;">:</td>
                                <td style="text-align: left;padding-left:10px;padding-right:10px;"
                                    class="border-right">
                                    {{ $patient_info->age }} </td>

                                <td width="15%" style="padding-left:20px;padding-right:20px;"><strong>Accession
                                        ID</strong></td>
                                <td width="2%" style="padding-left:10px;padding-right:10px;">:</td>
                                <td style="text-align: left;padding-left:10px;padding-right:10px;">
                                    {{ $radiology_appointment_data->accession_id }}
                                </td>
                            </tr>
                            <tr class="border-kbmh">
                                <td width="15%" style="text-align: left;padding-left:20px;padding-right:20px;">
                                    <strong>Gender </strong>
                                </td>
                                <td width="2%" style="padding-left:10px;padding-right:10px;">:</td>
                                <td width="15%" style="text-align: left;padding-left:10px;padding-right:10px;"
                                    class="border-right">
                                    {{ $patient_info->gender_txt }}</td>


                                <td width="15%" style="padding-left:20px;padding-right:20px;"><strong>Report
                                        Date</strong></td>
                                <td width="2%" style="padding-left:10px;padding-right:10px;">:</td>
                                <td style="text-align: left;padding-left:10px;padding-right:10px;">
                                    {{ !empty($radiology_appointment_data->img_app_dttm) ? date('d/m/Y', strtotime($radiology_appointment_data->img_app_dttm)) : date('d/m/Y'), $date }}
                                </td>

                            </tr>
                            <tr class="border-kbmh">
                                <td width="10%" style="padding-left:20px;padding-right:20px;">


                                    @if ($po_hospital_details->hospital_code == 'GMC')
                                        <strong> Consultant/Doctor </strong>
                                    @else
                                        <strong>Ref By</strong>
                                    @endif



                                </td>
                                <td width="2%" style="padding-left:10px;padding-right:10px;">:</td>
                                <td style="text-align: left;padding-left:10px;padding-right:10px;" colspan="5">
                                    @php
                                        $doc_array = explode('<br>', $radiology_appointment_data->doctor_signature);

                                        if (isset($doc_array[0])) {
                                            echo $doc_array[0] . ' ';
                                        }

                                        if (isset($doc_array[1])) {
                                            echo $doc_array[1];
                                        }
                                    @endphp

                                </td>
                                <br>
                            </tr>

                            <tr class="border-kbmh">
                                <td width="10%" style="padding-left:20px;padding-right:20px;">
                                    <strong>Nature of
                                        {{ ucfirst($radiology_appointment_data->serviceunit_name) }}</strong>
                                </td>
                                <td width="2%" style="padding-left:10px;padding-right:10px;">:</td>
                                <td style="text-align: left;padding-left:10px;padding-right:10px;" colspan="4">
                                    @php
                                        echo $radiology_appointment_data->item_name;
                                    @endphp
                                </td>
                                <br>
                            </tr>
                        </table>

                        <table class="barcode-css">
                            <tr>
                                <td style="text-align:left; font-size:13px !important;" width="30%"> <img
                                        style="" src="data:image/png;base64,{{ $app_barcode }} "
                                        style="width: 120px; " />
                                    <br>
                                    <strong>Report ID</strong>:
                                    {{ $radiology_appointment_data->rad_report_no_pk }}
                                </td>
                                <td style="text-align: center">

                                </td>
                                <td style="text-align: right; font-size:13px !important;" width="30%">
                                    <img style="" src="data:image/png;base64, {{ $invoice_barcode }} "
                                        style="width: 120px; " /> <br>
                                    <strong>Invoice ID</strong>: {{ $radiology_appointment_data->invoice_code }}
                                </td>
                            </tr>
                        </table>


                        <div style="margin-bottom:5px; margin-top:5px;" class="mb-2">
                            <div class="find" style="margin-left: 40px;">
                                <table id="findings">
                                    <tr>
                                        <div style="">
                                            <span style=" font-size: 14px"> @php
                                                echo $radiology_appointment_data->result0;
                                            @endphp
                                            </span>
                                        </div>
                                        {{-- <h2><strong>Findings:</strong></h2> --}}
                                    </tr>
                                </table>
                            </div>
                        </div>


                        @if ($radiology_appointment_data->item_code == 'S26834004' ||
                            $radiology_appointment_data->item_code == 'S26833997' ||
                            $radiology_appointment_data->item_code == 'S26834005')

                            <table style="width: 100%; font-size: 13px; " class="footer_2">
                                <tr>
                                    <td width="50%" style="text-align: left; vertical-align: text-top">
                                        {{-- @if ($radiology_appointment_data->final_full_name != '')
                            <div>@php echo $radiology_appointment_data->doctor_signature_fin @endphp</div>
                        @endif --}}

                                    </td>

                                    {{-- for ewmch --}}
                                    {{-- <td style="text-align: left;vertical-align: text-top">
                           @if ($radiology_appointment_data->verify_full_name != '')
                               <i>Verified BY</i>
                               <div>@php echo $radiology_appointment_data->doctor_signature_vr @endphp</div>
                           @endif
                       </td> --}}
                                    {{-- end --}}

                                    <td width="50%" class="text-left"
                                        style="vertical-align: text-top;text-align:center">
                                        @if ($radiology_appointment_data->prepared_full_name != '')
                                            <div>@php echo $radiology_appointment_data->doctor_signature_pr @endphp</div>
                                        @endif

                                    </td>
                                </tr>
                            </table>
                        @endif



                </section>
            </div>


        </main>

        @if ($radiology_appointment_data->item_code != 'S26834004' ||
            $radiology_appointment_data->item_code != 'S26833997' ||
            $radiology_appointment_data->item_code != 'S26834005')

            <table style="width: 100%; font-size: 13px; " class="footer_2">
                <tr>
                    <td width="50%" style="text-align: left; vertical-align: text-top">
                        {{-- @if ($radiology_appointment_data->final_full_name != '')
                <div>@php echo $radiology_appointment_data->doctor_signature_fin @endphp</div>
            @endif --}}

                    </td>

                    {{-- for ewmch --}}
                    {{-- <td style="text-align: left;vertical-align: text-top">
               @if ($radiology_appointment_data->verify_full_name != '')
                   <i>Verified BY</i>
                   <div>@php echo $radiology_appointment_data->doctor_signature_vr @endphp</div>
               @endif
           </td> --}}
                    {{-- end --}}

                    <td width="50%" class="text-left" style="vertical-align: text-top;text-align:center">
                        @if ($radiology_appointment_data->prepared_full_name != '')
                            <div>@php echo $radiology_appointment_data->doctor_signature_pr @endphp</div>
                        @endif

                    </td>
                </tr>
            </table>
        @endif


    </body>
@endif

</html>
