@php
$hospital = DB::table('wsec_hospital')
->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
->first();
$body_mt = $hospital->hospital_code == 'GMC' ? '3.5' : '3.9';
$sig_mb = $hospital->hospital_code == 'IMPERIAL' ? '3' : '0';
$footer_mb = $hospital->hospital_code == 'IMPERIAL' ? '1.4' : '0';
$dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));

$date = $dt->format('g:i A');
$today_date_time = date('d/m/Y H:i:s A');
$printed_by = Session::get('user.ses_user_name');
@endphp

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Radiology Report</title>

    <style>
        /* @page {
            margin-top: 3.0cm;
            margin-bottom: 2.3cm;
            margin-left: 0cm;
            margin-right: 0cm;
        } */

        @font-face {
            font-family: 'IBM Plex Sans', sans-serif;
            font-weight: normal;
            src: url("your-font-url-here");
        }

        body {
            margin-left: 0.8cm;
            margin-right: 0.4cm;
            padding-left: 15px;
            /* padding-right: 30px; */
            font-family: 'Roboto', sans-serif;
            font-size: 16px;
        }

        @media print {
            .signature {
                page-break-inside: avoid;
            }

        }




        .report-data {
            font-size: 13px;
            width: 100%;
        }

        .hospital-logo {
            width: 70px;
        }

        .barcode {
            width: 120px;
        }

        .item-name {
            width: 100%;
            font-size: 16px;
            padding: 2px;
            border-bottom: 1px solid rgb(29, 27, 27);
        }

        .print_footer {
            font-size: 8px;
        }

        /* Existing styles... */

        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 100px;
            color: rgba(0, 0, 0, 0.1);
            z-index: 0;
            pointer-events: none;
            user-select: none;
            white-space: nowrap;
        }

        @media print {
            .watermark {
                display: block;
            }
        }


        @media print {

            @page {

                margin-top: 3.0cm;

                margin-bottom: 2.2cm;
                margin-left: 10mm;
                margin-right: 1cm;
                /* margin-left: 0cm;
                margin-right: 0cm; */

                @bottom-left {
                    content: "Printed: {{ $today_date_time }} by {{ $printed_by }}";
                    font-size: 10px;
                    margin-bottom: 15px;
                }

                @bottom-center {
                    content: "Powered By: [NEXTGEN]";
                    margin-bottom: 15px;
                    font-size: 10px;
                }

                @bottom-right {
                    content: "Page " counter(page) " of " counter(pages);
                    font-size: 10px;
                    margin-bottom: 15px;
                }

            }

            @page: first {
                margin-top: 3cm;

                @top-right {
                    content: none;
                    /* Hide header on page 1 */

                }


            }

            .result-data {
                font-size: 12px;
            }

        }

        .signature-content p {
            margin: 0;
            /* Adjust the values as needed */
        }


        
    </style>
</head>

<body onload="window.print()">
    @if ($radiology_appointment_data->finalize_key_ind != 1 && $radiology_appointment_data->finalize_key_ind != '')
    <div class="watermark">DRAFT</div>
    @endif

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
                    <table style="width: 100%;" style="padding: 0px; margin:0px" class="header-barcode">
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
                                {{ $patient_info->pat_age }}
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
                        <div class="find" style=" ">
                            <table id="findings">
                                <tr>
                                    <div style="" class="result-data"
                                        style="font-family: 'Times New Roman', Times, serif !important; font-size: 50px !important;">
                                        @php
                                        $cleaned_html = preg_replace(
                                        '/font-size\s*:\s*[^;"]+;?/i',
                                        '',
                                        $radiology_appointment_data->result0,
                                        );
                                        $cleaned_html = preg_replace('/font-family\s*:\s*[^;"]+;?/i', '',
                                        $cleaned_html);
                                        $cleaned_html = preg_replace('/font-style\s*:\s*italic\s*;?/i', '',
                                        $cleaned_html);
                                        $cleaned_html = preg_replace('/<i\b[^>]*>(.*?)<\ /i>/i', '$1', $cleaned_html);
                                                $cleaned_html = preg_replace('/<em\b[^>]*>(.*?)<\ /em>/i', '$1',
                                                        $cleaned_html);
                                                        @endphp
                                                        {!! $cleaned_html !!}

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

                    <div class="" style="margin-top: 10px;">
                        <table style="width: 100%; font-size: 13px;">
                            <tbody>
                                <tr>
                                    <td width="55%" style="vertical-align: top; ">
                                        @if ($radiology_appointment_data->final_full_name != '')

                                        @if ($radiology_appointment_data->fin_digital_signature_ind == 1)
                                        <img src="{{ asset('images/uploads/doctor_images/thumb/' . $radiology_appointment_data->fin_doctor_signature_image) }}"
                                            alt="image" style="width: 120px;height:30px;">
                                        @endif


                                        <div class="signature-content">{!!
                                            $radiology_appointment_data->doctor_signature_fin !!}</div>
                                        @endif
                                    </td>
                                    <td width="45%" style="text-align: left; vertical-align: top;">
                                        <div style="text-align: center;">
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td style="border: 0; text-align: left; font-size: 8px;" colspan="2">
                                        <div class="print_footer">
                                            @php
                                            $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
                                            $date = $dt->format('g:i A');
                                            @endphp
                                            {{ Session::get('user.ses_user_name') }}, Printing Date & Time:
                                            {{ date('d/m/Y') }}, {{ $date }}, Powered By: [NEXTGEN]
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
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
                    <table class="report-header" style="width: 100%; font-size: 12px;margin-bottom: 3px;">
                        <tr style="vertical-align: top;">
                            <!-- Left: Report ID + Barcode -->
                            <td style="text-align: left; width: 30%; padding: 5px;">
                                @if (!empty($app_barcode))
                                <img src="data:image/png;base64,{{ $app_barcode }}" alt="Report Barcode"
                                    style="width: 90px; height: 25px; display: block; margin-bottom: 4px;" />
                                @endif
                                <div><strong>Report ID:</strong>
                                    {{ $radiology_appointment_data->rad_report_no_pk ?? 'N/A' }}
                                </div>
                            </td>

                            <!-- Center: Heading -->
                            <td style="text-align: center; width: 40%; padding: 5px; vertical-align: bottom;">
                                <h3 style="margin: 0; font-size: 16px; color: #333;">
                                    {{strtoupper($radiology_appointment_data->serviceunit_name)}} SERVICES
                                </h3>
                            </td>

                            <!-- Right: Invoice or Admission Barcode -->
                            <td style="text-align: right; width: 30%; padding: 5px;">
                                @if (empty($radiology_appointment_data->admission_no_pk))
                                @if (!empty($invoice_barcode))
                                <img src="data:image/png;base64,{{ $invoice_barcode }}" alt="Invoice Barcode"
                                    style="width: 90px; height: 25px; margin-bottom: 4px;" />
                                <div><strong>Invoice ID:</strong>
                                    {{ $radiology_appointment_data->invoice_code ?? 'N/A' }}
                                </div>
                                @endif
                                @else
                                @if (!empty($admission_barcode))
                                <img src="data:image/png;base64,{{ $admission_barcode }}" alt="Admission Barcode"
                                    style="width: 90px; height: 25px; margin-bottom: 4px;" />
                                <div><strong>Admission ID:</strong>
                                    {{ $radiology_appointment_data->admission_no_pk }}
                                </div>
                                @endif
                                @endif
                            </td>
                        </tr>
                    </table>
                    <!-- Part 1: Patient Details -->
                    <table
                        style="width: 100%; border:1px solid #999; border-radius:10px; font-size: 12px; margin-bottom: 3px;">
                        <tr>
                            <td width="16%" style="padding-left:5px;text-align: left;"><strong>Patient Name</strong>
                            </td>
                            <td width="2%" style="text-align:center">:</td>
                            <td width="38%" style="text-align: left;padding-left:10px;">
                                {{ !empty($patient_info->salutation) ? ucfirst($patient_info->salutation) : '' }}
                                {{ $patient_info->patient_name }}
                            </td>
                            <td width="12%" style="text-align:left"><strong>UHID</strong></td>
                            <td width="2%" style="text-align:center">:</td>
                            <td width="23%" style="text-align: left;padding-left:10px;">
                                {{ $radiology_appointment_data->patient_code }}
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-left:5px;text-align:left"><strong>Age/Gender</strong></td>
                            <td style="text-align:center">:</td>
                            <td style="text-align: left;padding-left:10px;">
                                {{ $patient_info->pat_age }} / {{ $patient_info->gender_txt }}
                            </td>
                        </tr>
                    </table>

                    <!-- Part 2: Admission & Report Info (Updated Serial) -->
                    <table style="width: 100%; border:1px solid #999; border-radius:10px; font-size: 12px;">

                        <!-- Row 1: Ref. By and Ward / Bed -->
                        <tr>
                            <td width="16%" style="text-align:left; padding-left:5px;"><strong>Ref. By</strong></td>
                            <td width="2%" style="text-align:center">:</td>
                            <td width="38%" style="text-align:left; padding-left:10px;">
                                {{ $radiology_appointment_data->ref_doc_name }}
                            </td>

                            <td width="12%" style="text-align:left"><strong>Ward / Bed</strong></td>
                            <td width="2%" style="text-align:center">:</td>
                            <td width="23%" style="text-align:left; padding-left:10px;">
                                @if (!empty($radiology_appointment_data->admission_no_pk))
                                {{ ucfirst($radiology_appointment_data->ward_name) }} /
                                {{ ucfirst($radiology_appointment_data->bed_name) }}
                                @else
                                OPD Patient
                                @endif
                            </td>
                        </tr>
                        <!-- Row 2: Invoice Date and Scan Date -->
                        <tr>
                            <td style="text-align:left; padding-left:5px;"><strong>Invoice Date</strong></td>
                            <td style="text-align:center">:</td>
                            <td style="text-align:left; padding-left:10px;">
                                {{ !empty($radiology_appointment_data->invoice_date) ? date('d/m/Y H:i A', strtotime($radiology_appointment_data->invoice_date)) : 'N/A' }}
                            </td>

                            <td style="text-align:left;"><strong>Scan Date</strong></td>
                            <td style="text-align:center">:</td>
                            <td style="text-align:left; padding-left:10px;">
                                {{ !empty($radiology_appointment_data->ic_image_capture_keyed_time) ? date('d/m/Y H:i A', strtotime($radiology_appointment_data->ic_image_capture_keyed_time)) : 'N/A' }}
                            </td>
                        </tr>

                        <!-- Row 3: Report Date and Status -->
                        <tr>
                            <td style="text-align:left; padding-left:5px;"><strong>Report Date</strong></td>
                            <td style="text-align:center">:</td>
                            <td style="text-align:left; padding-left:10px;">
                                {{ !empty($radiology_appointment_data->finalize_keyed_time) ? date('d/m/Y H:i A', strtotime($radiology_appointment_data->finalize_keyed_time)) : 'Not Finalized Yet' }}
                            </td>

                            <td style="text-align:left;"><strong>Status</strong></td>
                            <td style="text-align:center">:</td>
                            <td style="text-align:left; padding-left:10px;">
                                @if ($radiology_appointment_data->finalize_key_ind == 1)
                                Finalized
                                @elseif ($radiology_appointment_data->finalize_key_ind != 1 &&
                                $radiology_appointment_data->final_full_name != '')
                                Verified
                                @else
                                Not Finalized Yet
                                @endif
                            </td>
                        </tr>
                    </table>
                </th>
            </tr>

        </thead>
        <tbody>
            <tr>
                <th>
                    @if (strtoupper($radiology_appointment_data->serviceunit_name != 'ECHO'))
                    <div style="margin-top:2px;  text-align:center; width: 100%; padding-top:4px;">
                        <span class="report-name"
                            style="width:100%;  font-size: 16px;  padding:2px; border-bottom: 1px solid rgb(29, 27, 27) ;">
                            <strong>
                                @php
                                echo $radiology_appointment_data->item_name;
                                @endphp
                            </strong>
                        </span>
                    </div>
                    @endif



                    <div style="margin-bottom:5px; margin-top:5px; ">
                        <div class="find" style="">

                            <table id="findings">
                                <tr>
                                    <td>
                                        <span style=" font-size: 13px;">
                                            @php
                                            $html = $radiology_appointment_data->result0;
                                              $html = preg_replace('/<div class="JCLRgrips[^>]*>.*?<\/div>/s', '', $html);
                                            $html = preg_replace('/<div class="JCLRgrip[^>]*>.*?<\/div>/s', '', $html);
                                            $html = preg_replace('/<div class="JColResizer[^>]*>.*?<\/div>/s', '', $html);
                                            $html = preg_replace('/class="([^"]*\bJColResizer\b[^"]*)"/', '', $html);
                                            $html = preg_replace('/class="([^"]*\bresizable\b[^"]*)"/', '', $html);

                                            echo $html;
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
            <tr>
                <td colspan="2" style="page-break-inside: avoid; padding-top: 10px;">
                    <table style="width: 100%; font-size: 13px;">
                        <tr>
                            <td width="55%" style="vertical-align: top;">
                                @if ($radiology_appointment_data->final_full_name != '')
                                @if ($radiology_appointment_data->fin_digital_signature_ind == 1)
                                <img src="{{ asset('images/uploads/doctor_images/thumb/' . $radiology_appointment_data->fin_doctor_signature_image) }}"
                                    alt="image" style="width: 120px;height:30px;">
                                @endif
                                <div class="signature-content">{!! $radiology_appointment_data->doctor_signature_fin !!}</div>
                                @endif
                            </td>
                            <td width="45%" style="text-align: left; vertical-align: top;"></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>

    @endif
</body>
<script>
    window.onafterprint = function() {
        window.close()
    }
</script>