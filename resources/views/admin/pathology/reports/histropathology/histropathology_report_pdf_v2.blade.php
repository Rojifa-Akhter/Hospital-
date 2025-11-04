@php
$hospital = DB::table('wsec_hospital')
->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
->first();
$specimen_name = $hospital->hospital_code == 'GMC' ? 'Source Of Specimen' : 'Sample';
$nature_of_examination = $hospital->hospital_code == 'GMC' ? 'Nature Of Examination' : 'Test';

$dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));

$date = $dt->format('g:i A');
$today_date_time = date('d/m/Y H:i:s A');
$printed_by = Session::get('user.ses_user_name');
@endphp

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Histopathology Report</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="" />
    <!-- custom style -->


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
            /* margin-left: 0.8cm;
            margin-right: 0.4cm; */
            /* padding-left: 15px; */
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

<body>
    @if ($po_hospital_details->report_header_image_prshde_ind == 1)
     @if ($draft != '')
    <div class="watermark">DRAFT</div>
    @endif
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

    <table style="width: 100%;" style="padding: 0px; margin:0px" class="header-barcode">
        <thead>
            <tr>
                <td>


                    <div class="lab_pat_info" style=" " id="">
                        <table class="lab_pat_info" width="100%" style="padding: 0px; margin:0px;font-size: 13px !important;">
                            <tr>
                                <td style="text-align:left" width="30%">

                                    <img style="" src="data:image/png;base64, {{ $invoice_varcode }} "
                                        style="width: 120px; " />
                                    <br>
                                    <strong style="">Invoice ID : </strong> <span
                                        style="">{{ $report_header->invoice_code }}</span>
                                </td>

                                <td style="text-align:center" width="40%"> <img style=""
                                        src="data:image/png;base64, {{ $patient_varcode }} " style="width: 120px; " />
                                    <br>

                                    <strong
                                        style="">{{ $hospital->hospital_code == 'UNICO' ? 'UHID' : 'Patient ID' }}
                                        : </strong> <span style="">{{ $report_header->patient_code }}</span>
                                </td>
                                {{-- Duplicate print --}}
                                @if(!is_null($report_header->result_print_key_ind) && $report_header->result_print_key_ind == 1)
                                <td style="text-align:left; color:blue!important; font-weight:bold; font-size:16px; width:15%;">
                                    DUPLICATE
                                </td>
                                @endif
                                {{-- @php
                            dd($report_header->result_print_key_ind)
                        @endphp --}}

                                <td style="text-align: center"> </td>
                                <td style="text-align: right" width="30%">
                                    <img style="" src="data:image/png;base64, {{ $report_varcode }} "
                                        style="width: 120px;" />
                                    <br>
                                    <strong style="">Report ID : </strong> <span
                                        style="">{{ $report_header->report_code }}</span>

                                </td>
                            </tr>
                        </table>


                        <table style="width: 100%; border:1px solid #999; border-radius:10px; font-size: 13px;">
                            <tr>
                                <td class="text-left" style=" padding-left:5px;padding-right:5px;">
                                    <strong>Patient Name</strong>
                                </td>
                                <td width="35%" class="text-left" style=" padding-left:5px;padding-right:5px;">
                                    : {{ $report_header->patient_name }}
                                </td>

                                <td class="text-left" style=" padding-left:5px;padding-right:5px;">
                                    <strong>Age </strong>
                                </td>
                                {{-- {{ dd($report_header->age) }} --}}


                                <?php
                                $explode_age = '';
                                if ($report_header->age != '') {
                                    $str_age = $report_header->age;
                                    $explode_age = explode(',', $str_age);
                                }
                                ?>
                                @php

                                $pat_dob = new \DateTime($report_header->dob);
                                $invoice_date = new \DateTime($report_header->order_date);
                                $interval = $invoice_date->diff($pat_dob);
                                @endphp

                                <td width="15%" class="text-left" style=" padding-left:5px;padding-right:5px;">
                                    {{-- {{ $report_header->age != '' ? " : $report_header->age" : '' }} --}}

                                    {{-- {{ $explode_age[0] != '' ? ": $explode_age[0]" : '' }}
                                    {{ $explode_age[1] != '' && $explode_age[0] == ' ' ? "$explode_age[1]" : '' }}
                                    {{ $explode_age[1] != '' && $explode_age[0] != '' ? ",$explode_age[1]" : '' }}
                                    {{ $explode_age[2] != '' ? ",$explode_age[2]" : '' }} --}}
                                    {{-- {{ !empty($explode_age[0]) ? ": $explode_age[0]" : '' }}

                                    {{ !empty($explode_age[1]) && !empty($explode_age[0]) ? "$explode_age[1]" : '' }}
                                    {{ !empty($explode_age[2]) ? "$explode_age[2]" : '' }} --}}
                                    : {{ $interval->format('%yY %mM %dD') }}



                                </td>

                                <td class="text-left" style=" padding-left:5px;padding-right:5px;">
                                    <strong>Gender </strong>
                                </td>
                                <td width="20%" class="text-left" style=" padding-left:5px;padding-right:5px;">
                                    {{ $report_header->gender_txt != '' ? " :  $report_header->gender_txt" : '' }}
                                </td>

                            </tr>
                            @if ($report_header->bed_name != '')
                            <tr>
                                <td width="10%" class="text-left" style=" padding-left:5px;padding-right:5px;">
                                    <strong>Ward/Bed</strong>
                                </td>
                                <td class="text-left" style=" padding-left:5px;padding-right:5px;">
                                    {{ $report_header->ward_name != '' ? ': ' . $report_header->ward_name : '' }}
                                    <strong>{{ $report_header->bed_name != '' ? '(' . $report_header->bed_name . ')' : '' }}</strong>
                                </td>
                                <td width="10%" class="text-left" style=" padding-left:5px;padding-right:5px;">
                                    <strong>IP No</strong>
                                </td>
                                <td class="text-left" style=" padding-left:5px;padding-right:5px;">
                                    {{ $report_header->admission_no_pk != '' ? ': ' . $report_header->admission_no_pk : '' }}
                                </td>

                            </tr>
                            @endif
                            @if ($report_header->passport_no != '')
                            <tr>
                                <td width="16%" class="text-left" style=" padding-left:5px;padding-right:5px;">
                                    <strong>Passport No</strong>
                                </td>
                                <td class="text-left" style=" padding-left:5px;padding-right:5px;" colspan="3">
                                    {{ $report_header->passport_no != '' ? ': ' . $report_header->passport_no : '' }}
                                </td>

                            </tr>
                            @endif
                            @if ($hospital->hospital_code == 'UNICO')
                            <tr>
                                <td width="16%" style="padding-left:5px"><strong>UHID</strong></td>
                                <td> : {{ $report_header->patient_code }}</td>
                                <td width="16%" class="text-left" style=" padding-left:5px;padding-right:5px;">
                                    <strong>Ref By</strong>
                                </td>
                                <td class="text-left" style=" padding-left:5px;padding-right:5px;" colspan="3">
                                    {{ $report_header->ref_doc_name != '' ? " : $report_header->ref_doc_name" : '' }}
                                    {{ $report_header->ref_doc_name_degree1 != '' ? ", $report_header->ref_doc_name_degree1" : '' }}
                                    {{ $report_header->ref_doc_name_degree2 != '' ? ", $report_header->ref_doc_name_degree2" : '' }}
                                    {{ $report_header->ref_doc_name_degree3 != '' ? ", $report_header->ref_doc_name_degree3" : '' }}
                                </td>
                            </tr>
                            @else
                            <tr>
                                <td width="16%" class="text-left" style=" padding-left:5px;padding-right:5px;">
                                    <strong>Ref By</strong>
                                </td>
                                <td class="text-left" style=" padding-left:5px;padding-right:5px;" colspan="3">
                                    {{ $report_header->ref_doc_name != '' ? " : $report_header->ref_doc_name" : '' }}
                                    {{ $report_header->ref_doc_name_degree1 != '' ? ", $report_header->ref_doc_name_degree1" : '' }}
                                    {{ $report_header->ref_doc_name_degree2 != '' ? ", $report_header->ref_doc_name_degree2" : '' }}
                                    {{ $report_header->ref_doc_name_degree3 != '' ? ", $report_header->ref_doc_name_degree3" : '' }}
                                </td>
                                <td><strong>Mobile </strong></td>
                                <td>{{ isset($report_header->mobile1) && $report_header->mobile1 != '' ? " : $report_header->mobile1" : '' }}
                                </td>
                            </tr>
                            @endif
                        </table>




                        <table style="width: 100%; border:1px solid #999; border-radius:10px; font-size: 13px;margin-top:3px;">
                            <tr>
                                <td class="text-left" width="15%" style=" padding-left:5px;padding-right:5px;">
                                    <strong>Sample</strong>
                                </td>
                                <td width="19%" class="text-left" style=" padding-left:5px;padding-right:5px;">
                                    {{ $report_header->sam_name != '' ? " :  $report_header->sam_name" : '' }}
                                </td>


                                <td width="15%" class="text-left" style=" padding-left:5px;padding-right:5px;">
                                    @if ($po_hospital_details->hospital_code == 'IMPERIAL')
                                    @if ($report_header->admission_no_pk != '')
                                    <strong style="font-size: 11px !important;">Admission ID</strong>
                                    @endif
                                    @else
                                    <strong>Sample ID</strong>
                                    @endif

                                </td>
                                <td width="20%" class="text-left" style=" padding-left:5px;padding-right:5px;">

                                    @if ($po_hospital_details->hospital_code == 'IMPERIAL')
                                    @if ($report_header->admission_no_pk != '')
                                    {{ $report_header->admission_no_pk != '' ? " : $report_header->admission_no_pk" : '' }}
                                    @endif
                                    @else
                                    {{ $report_header->lab_code != 0 ? " : $report_header->lab_code" : '' }}
                                    @endif


                                </td>

                                <td width="9%" class="text-left" style=" padding-left:5px;padding-right:5px;">
                                    <strong>Inv. Date </strong>
                                </td>
                                <td width="24%" class="text-left" style=" padding-left:5px;padding-right:5px;">
                                    {{ !empty($report_header->order_date) ? ': ' . date('d/m/Y', strtotime($report_header->order_date)) : '' }}
                                </td>
                            </tr>

                            <tr>

                                <td class="text-left" style=" padding-left:5px;padding-right:5px;">
                                    <strong> Collection time </strong>
                                </td>
                                <td width="20%" class="text-left" style=" padding-left:5px;padding-right:5px;">
                                    {{ !empty($report_header->sc_sample_coll_keyed_time) ? ': ' . date('d/m/Y H:i a', strtotime($report_header->sc_sample_coll_keyed_time)) : '' }}
                                </td>
                                <td class="text-left" style=" padding-left:5px;padding-right:5px;">
                                    <strong> Receiving Time </strong>
                                </td>
                                <td width="21%" class="text-left" style=" padding-left:5px;padding-right:5px;">
                                    {{ isset($report_header->sample_received_time) && !empty($report_header->sample_received_time) ? ': ' . date('d/m/Y H:i a', strtotime($report_header->sample_received_time)) : '' }}

                                </td>
                                <td class="text-left" style=" padding-left:5px;padding-right:5px;">
                                    <strong> Finalized Time </strong>
                                </td>
                                <td width="21%" class="text-left" style=" padding-left:5px;padding-right:5px;">
                                    {{ isset($report_header->result_final_keyed_time) && !empty($report_header->result_final_keyed_time) ? ': ' . date('d/m/Y h:i a', strtotime($report_header->result_final_keyed_time)) : '' }}

                                </td>

                            </tr>
                            <tr>
                                <td class="text-left" style=" padding-left:5px;padding-right:5px;vertical-align:top">
                                    <strong>Tests </strong>
                                </td>
                                @php
                                $item_code = explode(',', $report_header->item_code_list);

                                @endphp

                                <td class="text-left" style=" padding-left:5px;padding-right:5px;" colspan="5">
                                    @if (isset($item_code[0]))
                                    @if ($item_code[0] == 'OGTT' || $item_code[0] == 'OGTT-3')
                                    @php
                                    $item_name = explode(',', $report_header->report_test_name_list);
                                    @endphp
                                    : {{ $item_name[0] }}
                                    @else
                                    {{ $report_header->report_test_name_list != '' ? " :  $report_header->report_test_name_list" : '' }}
                                    @endif
                                    @else
                                    {{ $report_header->report_test_name_list != '' ? " :  $report_header->report_test_name_list" : '' }}
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>



                </td>
            </tr>
        </thead>


        <tbody>
            <tr>
                <td>
                    @if ($po_hospital_details->hospital_code != 'KBMH')
                    <p
                        style="text-align: center; margin: 0px !important; padding: 2px;font-size:20px !important;color:#000 !important; font-weight: bolder;">
                        {{ strtoupper($report_header->serviceunit_name) }} REPORT
                    </p>
                    @else
                    <p style="text-align: center; margin: 0px !important; padding: 2px;font-size:20px !important;">
                        {{ ucfirst(strtolower($report_header->serviceunit_name)) }} Report
                    </p>
                    @endif
                </td>
            </tr>
            <tr>
                <td>
                    <span style="font-size:14px !important; ">
                        @if ($po_hospital_details->hospital_code != 'IMPERIAL')

                        @if ($po_hospital_details->hospital_code != 'UNICO')
                        <div style="font-size: 16px">
                            <strong>Specimen </strong>
                            {{ $report_header1->sam_name != '' ? " :  $report_header1->sam_name" : '' }}
                        </div>
                        @endif
                        @else
                        @endif

                        <?php echo $report_header->note; ?>
                    </span>
                </td>
            </tr>
        </tbody>


    </table>
    <table width="100%">

        <tr>
            <td style="width: 100%; " colspan="12">
                @if (!in_array(Session::get('user.ses_hospital_code'), ['IMPERIAL', 'AMCSH', 'DMHL']))

                <table style="width: 95%; font-size: 11px; " class="footer_2">
                    <tr>

                        @if ($po_hospital_details->hospital_code == 'UNICO')

                        <td style="text-align: left;">
                            @if ($report_header->verified_by != '')
                            @if ($po_hospital_details->hospital_code == 'UNICO')
                            <i>Checked BY</i>
                            @elseif ($po_hospital_details->hospital_code != 'EWMCH')
                            <i>Checked By</i>
                            @endif
                            <br>
                            {{-- <div><strong>{{ $report_header->verified_by }}</strong></div> --}}
                            @if ($report_header->vr_digital_signature_ind == 1)
                            <img src="{{ asset('images/uploads/doctor_images/thumb/' . $report_header->vr_doctor_signature_image) }}"
                                alt="image" style="width: 120px; height:30px; margin-top:5px; margin-left: -25px;">
                            @endif
                            <div>@php echo $report_header->vr_doctor_signature @endphp</div>
                            @endif
                        </td>
                        @else
                        <td width="25%" style="text-align: left;">
                            @if ($report_header->prepared_by != '')
                            @if ($po_hospital_details->hospital_code != 'EWMCH')
                            <i>Prepared BY</i>
                            @elseif($po_hospital_details->hospital_code == 'UNICO')
                            <i>Checked By</i>
                            @endif
                            <br>
                            {{-- <div><strong>{{ $report_header->prepared_by }}</strong></div> --}}
                            @if ($report_header->pr_digital_signature_ind == 1)
                            <img src="{{ asset('images/uploads/doctor_images/thumb/' . $report_header->pr_doctor_signature_image) }}"
                                alt="image" style="width: 120px;height:30px">
                            @endif
                            <div>@php echo $report_header->pr_doctor_signature @endphp</div>
                            <!-- <div>Certified Ortopedic Surgeon</div> -->
                            @endif
                        </td>
                        <td style="text-align: left;">
                            @if ($report_header->verified_by != '')
                            @if ($po_hospital_details->hospital_code == 'UNICO')
                            <i>Verified BY</i>
                            @elseif ($po_hospital_details->hospital_code != 'EWMCH')
                            <i>Checked By</i>
                            @endif
                            <br>
                            {{-- <div><strong>{{ $report_header->verified_by }}</strong></div> --}}
                            @if ($report_header->vr_digital_signature_ind == 1)
                            <img src="{{ asset('images/uploads/doctor_images/thumb/' . $report_header->vr_doctor_signature_image) }}"
                                alt="image" style="width: 120px;height:30px">
                            @endif
                            <div>@php echo $report_header->vr_doctor_signature @endphp</div>
                            @endif
                        </td>
                        @endif


                        
                        
                        @if ($draft != 'draft')

                        <td width="30%" class="text-center" style="text-align: center">
                            @if ($report_header->finalized_by != '')
                            
                            @if ($po_hospital_details->hospital_code == 'UNICO')
                            <i>Approved By</i>
                            @elseif ($po_hospital_details->hospital_code != 'EWMCH')
                            <i>Finalized BY</i>
                            @endif
                            <br>
                            {{-- <div><strong>{{ $report_header->finalized_by }}</strong></div> --}}
                            @if ($report_header->fin_digital_signature_ind == 1)
                            <img src="{{ asset('images/uploads/doctor_images/thumb/' . $report_header->fin_doctor_signature_image) }}"
                                alt="image" style="width: 120px;height:30px">
                            @endif
                            <div>@php echo $report_header->fin_doctor_signature @endphp</div>
                            @endif
                        </td>
                        {{-- <td width="25%" class="text-left">
                                    @if ($report_header->finalized_by != '')
                                        @if ($po_hospital_details->hospital_code != 'EWMCH')
                                            <i>Consult BY</i>
                                        @endif
                                        
                                        @if ($report_header->ent_digital_signature_ind == 1)
                                            <img src="{{ asset('images/uploads/doctor_images/thumb' . $report_header->ent_doctor_signature_image) }}"
                        alt="image" style="width: 120px;height:30px">
                        @endif
                        <div>@php echo $report_header->ent_doctor_signature @endphp</div>
                        @endif
            </td> --}}
            @else
            <td width="25%" class="text-left">
                <i>Finalized BY</i>
                <p>
                    <Strong>Not Yet Finalized</Strong>
                <div>(Draft Copy)</div>
                </p>
            </td>
            @endif
        </tr>
        @if ($draft == 'draft')
        <tr>
            <td colspan="4" style="text-align: left; vertical-align:top">
                Advice : Please collect the final report after finalization.
            </td>
        </tr>
        @endif
    </table>
    @else
    <table style="width: 100%; font-size: 11px; padding-top:50px " class="footer_2">
        <tr>
            <td width="60%" style="text-align: left;">
                @if ($report_header->prepared_by != '')
                @if ($po_hospital_details->hospital_code != 'EWMCH')
                @if (!in_array(Session::get('user.ses_hospital_code'), ['IMPERIAL', 'AMCSH', 'DMHL']))
                <i>Prepared BY</i>
                @endif
                @endif
                <br>
                {{-- <div><strong>{{ $report_header->prepared_by }}</strong></div> --}}
                <div>
                    @if ($report_header->pr_digital_signature_ind == 1)
                    <img src="{{ asset('images/uploads/doctor_images/thumb/' . $po_hospital_details->pr_doctor_signature_image) }}"
                        alt="image" style="width: 120px;height:30px">
                    @endif
                    @php echo $report_header->pr_doctor_signature @endphp
                </div>
                <!-- <div>Certified Ortopedic Surgeon</div> -->
                @endif
            </td>
            @if ($draft != 'draft')
            <td width="40%" class="text-left" style="text-align: center;">
                @if ($report_header->finalized_by != '')
                @if ($po_hospital_details->hospital_code != 'EWMCH')
                @if (!in_array(Session::get('user.ses_hospital_code'), ['IMPERIAL', 'AMCSH', 'DMHL']))
                <i>Finalized BY</i>
                @endif
                @endif
                <br>
                {{-- <div><strong>{{ $report_header->finalized_by }}</strong></div> --}}
                <div>
                    @if ($report_header->fin_digital_signature_ind == 1)
                    <img src="{{ asset('images/uploads/doctor_images/thumb/' . $po_hospital_details->fin_doctor_signature_image) }}"
                        alt="image" style="width: 120px;height:30px">
                    @endif
                    @php echo $report_header->fin_doctor_signature @endphp
                </div>
                @endif
            </td>
            @else
            <td width="25%" class="text-left" style="vertical-align: top;">
                <i>Finalized BY</i>
                <p>
                    <Strong>Not Yet Finalized</Strong>
                <div>(Draft Copy)</div>
                </p>
            </td>
            @endif
        </tr>
        @if ($draft == 'draft')
        <tr>
            <td colspan="4" style="text-align: left; vertical-align:bottom">
                Advice : Please collect the final report after finalization.
            </td>
        </tr>
        @endif
    </table>
    @endif
    </td>
    </tr>

    </table>

</body>

</html>