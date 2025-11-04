<?php
$blood_group = $donor_info->doner_blood;
$rh_typing = $donor_info->doner_rh_typing;

$ext = '';
if (!empty($blood_group)) {
    $ext = explode('+', $blood_group);

    if (isset($ext[1])) {
    } else {
        $ext = explode('-', $blood_group);
    }
}
//dd($blood_group,$ext);
$blood_group_pat = $donor_info->pat_blood;
$rh_typing_1 = $donor_info->patient_rh_typing;
$ext_pat = '';
if (!empty($blood_group_pat)) {
    $ext_pat = explode('+', $blood_group_pat);
    if (isset($ext_pat[1])) {
    } else {
        $ext_pat = explode('-', $blood_group_pat);
    }
}

$hbsAg = '';
if (!empty($donor_info->doner_hbsag) && $donor_info->doner_hbsag == 1) {
    $hbsAg = 'Positive';
} elseif (!empty($donor_info->doner_hbsag) && $donor_info->doner_hbsag == 2) {
    $hbsAg = 'Negative';
} else {
    $hbsAg = 'Non-Reactive';
}

$hcp = '';
if (!empty($donor_info->doner_hcp) && $donor_info->doner_hcp == 1) {
    $hcp = 'Positive';
} elseif (!empty($donor_info->doner_hcp) && $donor_info->doner_hcp == 2) {
    $hcp = 'Negative';
} else {
    $hcp = 'Non-Reactive';
}

$hiv = '';
if (!empty($donor_info->doner_hiv) && $donor_info->doner_hiv == 1) {
    $hiv = 'Positive';
} elseif (!empty($donor_info->doner_hiv) && $donor_info->doner_hiv == 2) {
    $hiv = 'Negative';
} else {
    $hiv = 'Non-Reactive';
}

$mp = '';
if (!empty($donor_info->doner_mp) && $donor_info->doner_mp == 1) {
    $mp = 'Positive';
} elseif (!empty($donor_info->doner_mp) && $donor_info->doner_mp == 2) {
    $mp = 'Negative';
} else {
    $mp = 'Non-Reactive';
}

$vdrl = '';
if (!empty($donor_info->doner_vdrl) && $donor_info->doner_vdrl == 1) {
    $vdrl = 'Positive';
} elseif (!empty($donor_info->doner_vdrl) && $donor_info->doner_vdrl == 2) {
    $vdrl = 'Negative';
} elseif (!empty($donor_info->doner_vdrl) && $donor_info->doner_vdrl == 3) {
    $vdrl = 'Non-Reactive';
} else {
    $vdrl = 'Reactive';
}

$anti_hbc_total = '';
if (!empty($donor_info->anti_hbc_total) && $donor_info->anti_hbc_total == 1) {
    $anti_hbc_total = 'Positive';
} elseif (!empty($donor_info->anti_hbc_total) && $donor_info->anti_hbc_total == 2) {
    $anti_hbc_total = 'Negative';
} else {
    $anti_hbc_total = 'Non-Reactive';
}

$result = '';
if (!empty($donor_info->doner_room_temp) && $donor_info->doner_room_temp == 1) {
    $result = 'ok';
} elseif (!empty($donor_info->doner_room_temp) && $donor_info->doner_room_temp == 2) {
    $result = 'not ok';
}

$result_ew = '';
if (!empty($donor_info->doner_room_temp) && $donor_info->doner_room_temp == 1) {
    $result_ew = 'compatible';
} elseif (!empty($donor_info->doner_room_temp) && $donor_info->doner_room_temp == 2) {
    $result_ew = 'not compatible';
}

$result_ew = '';
if (!empty($donor_info->doner_room_temp) && $donor_info->doner_room_temp == 1) {
    $result_ew = 'compatible';
} elseif (!empty($donor_info->doner_room_temp) && $donor_info->doner_room_temp == 2) {
    $result_ew = 'In compatible';
}

$donation_type = '';
if (!empty($donor_info->type_of_donations) && $donor_info->type_of_donations == 1) {
    $donation_type = 'Voluntary';
} elseif (!empty($donor_info->type_of_donations) && $donor_info->type_of_donations == 2) {
    $donation_type = 'Directed';
}

$component_type = '';
if (!empty($donor_info->type_of_blood_component) && $donor_info->type_of_blood_component == 1) {
    $component_type = 'prbc';
} elseif (!empty($donor_info->type_of_blood_component) && $donor_info->type_of_blood_component == 2) {
    $component_type = 'whole blood';
}elseif (!empty($donor_info->type_of_blood_component) && $donor_info->type_of_blood_component == 3) {
    $component_type = 'Freshed Frozen Plasma(FFP)';
}elseif (!empty($donor_info->type_of_blood_component) && $donor_info->type_of_blood_component == 4) {
    $component_type = 'Frozen Plasma';
}elseif (!empty($donor_info->type_of_blood_component) && $donor_info->type_of_blood_component == 5) {
    $component_type = 'Platelet Concentrate';
}elseif (!empty($donor_info->type_of_blood_component) && $donor_info->type_of_blood_component == 6) {
    $component_type = 'Washed PRBC';
}
// dd($donor_info);
$imp_mergin_botton = $po_hospital_details->hospital_code == 'IMPERIAL'  || $po_hospital_details->hospital_code == 'DMHL'? 'margin-bottom: 64px;' : '';
?>
<html>

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>H360 - Pathology Report</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport" />
    <!--<link rel="stylesheet" href="{{ asset('print/pdf.css') }}" media="all"> -->
    <link rel="stylesheet" href="css/invoice.css" media="all" />
    <style type="text/css">
        @page {
            margin-top: 0cm;
            margin-bottom: 0cm;
            margin-left: 0cm;
            margin-right: 0cm;
            height: 29.7cm;
            width: 21 cm;
        }

        body {
            margin-top: 3.9cm;
            margin-left: 1.5cm;
            margin-right: 1cm;
            margin-bottom: 2cm;
            font-family: 'Roboto', sans-serif;
            font-size: 8px;
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
            font-size: 9px !important;
            bottom: 0px;
            /*border-top: 1px solid black;*/
        }

        .footer_2 {

            position: fixed;

            z-index: 999999999;

            bottom: 0cm;

            left: 1cm;

            right: 1cm;

            height: 5.5cm;

            vertical-align: text-top !important;

            padding-bottom: 15px;



            /* text-align: center; */

            /* font-size: 9px; */

        }

        .footer_3 {
            position: fixed;
            z-index: 999999999;
            bottom: 0cm;
            left: 1cm;
            right: 1cm;
            height: 4.5cm;
            vertical-align: text-bottom;
            padding-bottom: 80px;
        }

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

        table tr th {
            border: 0px;
            background-color: white;
            color: #222;
        }

        table tr td {
            border: 0px;
            padding: 5px;
        }

        table {
            border: 0px;
        }

        table {
            /* border: 1px solid black; */
            border-collapse: collapse;
        }

        table tr:first-child th {
            border: 1px solid black;
            border-collapse: collapse;
        }
    </style>
</head>

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
    @if (!in_array($po_hospital_details->hospital_code , ['IMPERIAL','DMHL']))
        <footer style="border-top: 1px solid transparent;">
            <?php

            $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));

            $date = $dt->format('g:i A');

            ?>

            <table style="">
                <tr>
                    <td style="border: 0px; padding-top: 5px; text-align: left; font-size:9px !important">Prepared By:
                        {{ Session::get('user.ses_user_name') }},
                        Printing Date & Time: {{ date('d/m/Y') }} , {{ $date }},
                        &nbsp;Powered By: [NEXTGEN]
                    </td>

                </tr>
            </table>
        </footer>
    @endif
    <main>
        <div class="">

            <div style=" margin-top: 25px !important;font-size:13px !important;">
                <table width="100%" style="padding: 0px; margin:0px">
                    <tr>
                        <td style="text-align:left" width="30%">
                            <img style="" src="data:image/png;base64, {{ $invoice_varcode }} "
                                style="width: 120px; " /> <br>
                            <strong>Invoice ID</strong>: {{ $report_header->invoice_code }}

                        </td>

                        <td style="text-align:center" width="40%"> <img style=""
                                src="data:image/png;base64, {{ $patient_varcode }} " style="width: 120px; " />
                            <br>
                            <strong>Patient ID</strong>: {{ $report_header->patient_code }}
                        </td>
                         {{-- Duplicate print --}}
                        @if(!is_null($report_header->result_print_key_ind) && $report_header->result_print_key_ind == 1)
                            <td style="text-align:left; color:blue; font-weight:bold; font-size:16px; width:15%;">
                                DUPLICATE
                            </td>
                        @endif

                        <td style="text-align: center"> </td>
                        <td style="text-align: right" width="30%">

                            <img style="" src="data:image/png;base64, {{ $report_varcode }} "
                                style="width: 120px; " />
                            <br>
                            <strong>Report ID</strong>: {{ $report_header->report_code }}
                        </td>
                    </tr>
                </table>
                <table
                    style="width: 100%; border:1px solid #999;border-collapse: separate; border-radius: 10px; margin-bottom:5px !important;font-size:14px">
                        <!-- <tr class="">
                            <td style="" colspan="6" style="border:1px solid #999;">
                                <p><strong>Patient Information</strong></p>
                            </td>
                        </tr> -->
                    <tr>
                        <td class="text-left" style=" padding-left:5px;padding-right:5px; width:15%;">
                            <strong>Patient Name</strong>
                        </td>
                        <td width="25%" class="text-left" style=" padding-left:5px;padding-right:5px;">
                            : {{ $report_header->patient_name }}
                        </td>

                        <td class="text-left" style=" padding-left:5px;padding-right:5px; width:13%;">
                            <strong>Age </strong>
                        </td>


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

                        <td class="text-left" style=" padding-left:5px;padding-right:5px;width:15%;">
                            {{-- {{ !empty($explode_age[0]) ? ": $explode_age[0]" : '' }}

                            {{ !empty($explode_age[1]) && !empty($explode_age[0]) ? "$explode_age[1]" : '' }}
                            {{ !empty($explode_age[2]) ? "$explode_age[2]" : '' }} --}}
                            {{ $interval->format('%yY %mM %dD') }}

                        </td>

                        <td class="text-left" style=" padding-left:5px;padding-right:5px;width:12%;">
                            <strong>Gender </strong>
                        </td>
                        <td class="text-left" style="width:20%; ">
                            {{ $report_header->gender_txt != '' ? " :  $report_header->gender_txt" : '' }}
                        </td>

                    </tr>

                    <tr>
                        <td class="text-left" style="">
                            <strong>Blood Group</strong>
                        </td>
                        <td width="" class="text-left" style="">

                        </td>

                        <td class="text-left" style=" ">
                            <strong>ABO Group </strong>
                        </td>

                        <td width="" class="text-left" style="">

                            : <strong> "{{ $ext_pat ? $ext_pat[0] : '' }}" </strong>
                        </td>

                        <td class="text-left" style=" ">
                            <strong>Rh Typing </strong>
                        </td>
                        <td class="text-left" style=" ">
                            : <strong> {{ $rh_typing_1 }} </strong>
                        </td>

                    </tr>
                    <tr>
                        {{-- <td class="text-left" style="">
                            <strong>Blood Group</strong>
                        </td>
                        <td width="" class="text-left" style="">

                        </td>

                        <td class="text-left" style=" ">
                            <strong>ABO Group </strong>
                        </td>

                        <td width="" class="text-left" style="">

                            : <strong> "{{ $ext_pat ? $ext_pat[0] : '' }}" </strong>
                        </td> --}}

                        <td class="text-left" style=" ">
                            <strong>Ref. Doctor</strong>
                        </td>
                        <td colspan="3" class="text-left">
                            {{ $report_header->ref_doc_name != '' ? ": $report_header->ref_doc_name" : '' }}
                            {{ $report_header->ref_doc_name_degree1 != '' ? ", $report_header->ref_doc_name_degree1" : '' }}
                            {{ $report_header->ref_doc_name_degree2 != '' ? ", $report_header->ref_doc_name_degree2" : '' }}
                            {{ $report_header->ref_doc_name_degree3 != '' ? ", $report_header->ref_doc_name_degree3" : '' }}

                        </td>
                        <td class="text-left" style="">
                            <strong>Mobile</strong>
                        </td>
                        <td class="text-left" style="">
                            : {{ $report_header->mobile1 }}
                        </td>

                    </tr>
                </table>

                <table
                    style="width: 100%; border:1px solid #999;border-collapse: separate; border-radius: 10px;margin-bottom:3px !important; font-size:13px">

                    <tr>
                        <td class="text-left" style=" padding-left:5px;padding-right:5px;">
                            <strong>Sample</strong>
                        </td>
                        <td width="19%" class="text-left" style=" padding-left:5px;padding-right:5px;">
                            {{ $report_header->sam_name != '' ? " :  $report_header->sam_name" : '' }}
                        </td>


                        <td class="text-left" style=" padding-left:5px;padding-right:5px;">
                            <strong>LAB Code</strong>
                        </td>
                        <td width="19%" class="text-left" style=" padding-left:5px;padding-right:5px;">
                            {{ $report_header->lab_code != 0 ? " : $report_header->lab_code" : '' }}
                        </td>

                        <td class="text-left" style=" padding-left:5px;padding-right:5px;">
                            <strong>Invoice Date </strong>
                        </td>
                        <td width="21%" class="text-left" style=" padding-left:5px;padding-right:5px;">
                            {{ !empty($report_header->order_date) ? ': ' . date('d/m/Y', strtotime($report_header->order_date)) : '' }}
                        </td>

                        {{-- <td width="10%" class="text-left" style=" padding-left:20px;padding-right:20px;">
                    <strong>Collected Date </strong>
                </td>
                <td width="" class="text-left" style=" padding-left:5px;padding-right:5px;">
                    {{ !empty($report_header->sc_sample_coll_keyed_time)? ': ' . date('d/m/Y H:i a', strtotime($report_header->sc_sample_coll_keyed_time)): '' }}
                </td> --}}
                    </tr>
                    <tr>
                        <td class="text-left" style=" padding-left:5px;padding-right:5px;">
                            <strong>Tests </strong>
                        </td>
                        <td width="50%" colspan="3" class="text-left"
                            style=" padding-left:5px;padding-right:5px;">
                            {{ $report_header->report_test_name_list != '' ? " :  $report_header->report_test_name_list" : '' }}
                        </td>

                        <td class="text-left" style=" padding-left:5px;padding-right:5px;">
                            <strong>Collected Date </strong>
                        </td>
                        <td width="21%" class="text-left" style=" padding-left:5px;padding-right:5px;">
                            {{ !empty($report_header->sc_sample_coll_keyed_time) ? ': ' . date('d/m/Y H:i a', strtotime($report_header->sc_sample_coll_keyed_time)) : '' }}
                        </td>
                    </tr>
                </table>
            </div>

            <p style="text-align: center; margin: 0px !important; padding: 2px;font-size:20px !important;">
                {{ $report_header->serviceunit_name }} REPORT</p>
            @if (!empty($report_label))
                <p
                    style="text-align: center !important; margin: 0px !important; padding: 2px;font-size:12px !important;">
                    <i>{{ $report_label }}</i>
                </p>
            @endif
            @if ($report_header->analyzer_desc != '' && Session::get('user.ses_hospital_code')!="UNICO")
                <p style="text-align: center; margin:0px !important;padding: 2px; font-size:12px !important;">
                     <strong> Analyzer Name : {{ $report_header->analyzer_desc }}</strong>
                </p>
            @endif
        </div>


        @if ($po_hospital_details->hospital_code == 'GMC')
            <div class="" style="width:100%;">
                <table style="border:1px solid #000 !important;float: right; " width=100%;>
                    <thead style=" ">
                        <tr style="font-size:16px !important;">
                            <th style="text-align: left;border:1px solid #000 !important;" colspan="6">
                                <strong>Test Information</strong>
                            </th>

                        </tr>
                    </thead>
                    <tbody>
                        <tr style="font-size:16px !important;">
                            <td
                                style="text-align: left;border:1px solid #000 !important;width:50%;font-size:18px !important;">
                                <strong>Result</strong>
                            </td>
                            <td
                                style="text-align: left;border:1px solid #000 !important;width:50%;font-size:18px !important;">
                                @if ($po_hospital_details->hospital_code == 'GMC')
                                    <strong>{{ $result }}</strong>
                                @else
                                    <strong>{{ $result_ew }}</strong>
                                @endif

                            </td>
                            <td style="text-align: center;border:1px solid #000 !important;">
                                <strong>Bag No</strong>
                            </td>
                            <td style="text-align: center;border:1px solid #000 !important;">
                                <strong>{{ !empty($donor_info->doner_beg_no) ? $donor_info->doner_beg_no : '' }}</strong>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="" style="width:100%;">
                <table style="border:1px solid #000 !important;float: right; " width=100%;>
                    <tbody>
                        <tr style="font-size:12px !important;">
                            <td style="text-align: left;border:1px solid #000 !important;width:50%;">
                                <strong>Type Of Donation </strong>
                            </td>
                            <td style="text-align: left;border:1px solid #000 !important;width:50%;">
                                <strong>{{ $donation_type }}</strong>

                            </td>
                        </tr>
                        <tr style="font-size:12px !important;">
                            <td style="text-align: left;border:1px solid #000 !important;">
                                <strong>Type Of Blood Component</strong>
                            </td>
                            <td style="text-align: left;border:1px solid #000 !important;">
                                <strong>{{ $component_type }}</strong>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        @else
            <div class="" style="width:100%;">
                <table style="border:1px solid #000 !important;float: right; " width=100%;>
                    <thead style=" ">
                        <tr style="font-size:16px !important;">
                            <th style="text-align: left;border:1px solid #000 !important;" colspan="6">
                                <strong>Donor
                                    Information</strong>
                            </th>

                        </tr>
                    </thead>
                    <tbody>
                        <tr style="font-size:12px !important;">
                            <td style="text-align: left;border:1px solid #000 !important;">
                                <strong>Donor Name</strong>
                            </td>
                            <td style="text-align: center;border:1px solid #000 !important;">
                                <strong>{{ ucfirst(!empty($donor_info->doner_name) ? $donor_info->doner_name : '') }}</strong>
                            </td>
                            <td style="text-align: center;border:1px solid #000 !important;">
                                <strong>Age</strong>
                            </td>
                            <td style="text-align: center;border:1px solid #000 !important;">
                                <strong>{{ !empty($donor_info->doner_age) ? $donor_info->doner_age : '' }}</strong>
                            </td>
                            <td style="text-align: center;border:1px solid #000 !important;">
                                <strong>Gender</strong>
                            </td>
                            <td style="text-align: center;border:1px solid #000 !important;">
                                <strong>{{ !empty($donor_info->gender_txt) ? $donor_info->gender_txt : '' }}</strong>
                            </td>
                        </tr>
                        <tr style="font-size:12px !important;">
                            <td style="text-align: left;border:1px solid #000 !important;">
                                <strong>Blood Group</strong>
                            </td>
                            <?php
                            $blodd = explode('+', $donor_info->blood);
                            ?>


                            <td style="text-align: center;border:1px solid #000 !important;" colspan="2">
                                <strong>ABO Group :

                                    @if ($po_hospital_details->hospital_code == 'KBMH')
                                        {{ !empty($blodd[0]) ? '"' . $blodd[0] . '"' : '' }}
                                    @else
                                        {{ !empty($donor_info->blood) ? '"' . $donor_info->blood . '"' : '' }}
                                    @endif
                                </strong>
                            </td>
                            <td style="text-align: center;border:1px solid #000 !important;">
                                <strong>Rh Typing</strong>
                            </td>
                            <td style="text-align: center;border:1px solid #000 !important;" colspan="2">
                                <strong>{{ ucfirst(!empty($donor_info->blood) ? $rh_typing : '') }}</strong>
                            </td>
                        </tr>
                        <tr style="font-size:12px !important;">
                            <td style="text-align: left;border:1px solid #000 !important;" rowspan="6">
                                <strong>Donor Screening Test</strong>
                            </td>
                            <td style="text-align: center;border:1px solid #000 !important;" colspan="2">
                                <strong>HBsAg:</strong>
                            </td>
                            {{-- {{dd($hbsAg)}} --}}
                            <td style="text-align: center;border:1px solid #000 !important;" colspan="3">
                                <strong>{{ ucfirst($hbsAg) }}</strong>
                            </td>
                        </tr>
                        <tr style="font-size:12px !important;">
                            <td style="text-align: center;border:1px solid #000 !important;" colspan="2">
                                <strong>HCV:</strong>
                            </td>
                            <td style="text-align: center;border:1px solid #000 !important;" colspan="3">
                                <strong>{{ ucfirst($hcp) }}</strong>
                            </td>
                        </tr>
                        <tr style="font-size:12px !important;">
                            <td style="text-align: center;border:1px solid #000 !important;" colspan="2">
                                <strong>HIV(1+2):</strong>
                            </td>
                            <td style="text-align: center;border:1px solid #000 !important;" colspan="3">
                                <strong>{{ ucfirst($hiv) }}</strong>
                            </td>
                        </tr>
                        <tr style="font-size:12px !important;">
                            <td style="text-align: center;border:1px solid #000 !important;" colspan="2">
                                <strong>MP:</strong>
                            </td>
                            <td style="text-align: center;border:1px solid #000 !important;" colspan="3">
                                <strong>{{ ucfirst($mp) }}</strong>
                            </td>
                        </tr>
                        <tr style="font-size:12px !important;">
                            <td style="text-align: center;border:1px solid #000 !important;" colspan="2">
                                <strong>VDRL:</strong>
                            </td>
                            <td style="text-align: center;border:1px solid #000 !important;" colspan="3">
                                <strong>{{ ucfirst($vdrl) }}</strong>
                            </td>
                        </tr>
                        <tr style="font-size:12px !important;">
                            <td style="text-align: center;border:1px solid #000 !important;" colspan="2">
                                <strong>Anti HBC Total:</strong>
                            </td>
                            <td style="text-align: center;border:1px solid #000 !important;" colspan="3">
                                <strong>{{ ucfirst($anti_hbc_total) }}</strong>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <br>
            <div class="" style="width:100%;">
                <table style="border:1px solid #000 !important;float: right; " width=100%;>
                    <tbody>
                        <tr style="font-size:12px !important;">
                            <td style="text-align: left;border:1px solid #000 !important;">
                                @if ($po_hospital_details->hospital_code == 'GMC')
                                    <strong>Result</strong>
                                @else
                                    <strong>Cross Match Status At Room Tempature</strong>
                                @endif

                            </td>
                            <td style="text-align: center;border:1px solid #000 !important;">
                                @if ($po_hospital_details->hospital_code == 'GMC')
                                    <strong>{{ ucfirst($result) }}</strong>
                                @else
                                    <strong>{{ ucfirst($result_ew) }}</strong>
                                @endif

                            </td>
                            <td style="text-align: center;border:1px solid #000 !important;">
                                <strong>Bag No</strong>
                            </td>
                            <td style="text-align: center;border:1px solid #000 !important;">
                                <strong>{{ !empty($donor_info->doner_beg_no) ? $donor_info->doner_beg_no : '' }}</strong>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <br>
            <div class="" style="width:100%;">
                <table style="border:1px solid #000 !important;float: right; " width=100%;>
                    <tbody>
                        <tr style="font-size:12px !important;">
                            <td style="text-align: left;border:1px solid #000 !important;width:50%;">
                                <strong>Type Of Donation </strong>
                            </td>
                            <td style="text-align: left;border:1px solid #000 !important;width:50%;">
                                <strong>{{ ucfirst($donation_type) }}</strong>

                            </td>
                        </tr>
                        <tr style="font-size:12px !important;">
                            <td style="text-align: left;border:1px solid #000 !important;">
                                <strong>Type Of Blood Component</strong>
                            </td>
                            <td style="text-align: left;border:1px solid #000 !important;">
                                <strong>{{ ucfirst($component_type) }}</strong>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            </td>
            </tr>
            </tbody>
            </table>
            </div>
            @if ($po_hospital_details->hospital_code != 'KBMH')
                <div style="font-size: 13px">
                    <strong>Instruction for use Blood Component/ Product:</strong>
                    <ol>
                        <li><strong> Do not add any medications to the unit of Blood/Blood Components or
                                Products.</strong>
                        </li>
                        <li><strong>Use only Standard Blood Transfusion Set. Filter for Transfusion of Blood and Blood
                                Component.
                            </strong></li>
                        <li><strong>Check the unit of Blood/Blood productd for color. Clot formation. If anything, find
                                abnormal
                                then contact with blood Bank.</strong></li>
                        <li><strong>Platelet, Washed RBS & Plasma products once issued cannot be received back and will
                                be
                                discarded. </strong></li>
                        <li><strong>If not required or any delay of transfusion please return the blood unit (Whole
                                Blood/RCC) with
                                requisition form.</strong></li>
                        <li><strong>Please complete the blood transfusion within 3 to 4 hours.</strong></li>
                        <li><strong>Transfusion should be started within 30 minutes of taking the blood out the
                                refrigerator.</strong></li>
                        <li><strong>Please do not warm the blood using any artificial measure.</strong></li>
                    </ol>
                    {{-- <strong>Note: please Check the labels on the blood bag & requisition form properly before starting
                        transfusion.
                    </strong> --}}

                    <strong>
                        <div>@php print_r('Note:'. $report_header->note_text) @endphp</div>
                    </strong>
                </div>
            @endif
        @endif
        </div>
    </main>
    @if (Session::get('user.ses_hospital_code') != 'GMC')


    @if (!in_array(Session::get('user.ses_hospital_code') , ['IMPERIAL','AMCSH','DMHL']) )
    
    <table style="width: 95%; font-size: 11px; " class="footer_2">
        
        <tr>
            <td width="25%" style="text-align: left;">
                @if ($report_header->prepared_by != '')
                @if ($po_hospital_details->hospital_code != 'EWMCH')
                <i>Prepared BY</i>
                @endif
                {{-- @dd($report_header->pr_doctor_signature_image) --}}
                {{-- <div><strong>{{ $report_header->prepared_by }}</strong></div> --}}
                <div>

                  
                    @if ($report_header->pr_digital_signature_ind == 1)
                    <img src="{{ asset('images/uploads/doctor_images/thumb/' . $report_header->pr_doctor_signature_image) }}" alt="image" style="width: 120px;height:30px">
                    @endif
                    @php echo $report_header->pr_doctor_signature @endphp
                </div>
                <!-- <div>Certified Ortopedic Surgeon</div> -->
                @endif
            </td>


            <td style="text-align: left;">
                @if ($report_header->verified_by != '')
                @if ($po_hospital_details->hospital_code != 'EWMCH')
               
                <i>{{Session::get('user.ses_hospital_code')=="UNICO" ? 'Checked By' : 'Verfied By'}} </i>
                @endif

                {{-- <div><strong>{{ $report_header->verified_by }}</strong></div> --}}
                <div>
                    @if ($report_header->vr_digital_signature_ind == 1)
                    <img src="{{ asset('images/uploads/doctor_images/thumb/' . $report_header->vr_doctor_signature_image) }}" alt="image" style="width: 120px;height:30px">
                    @endif
                    @php echo $report_header->vr_doctor_signature @endphp
                </div>
                @endif
            </td>
          
            @if ($draft != 'draft')
                <td width="25%" class="text-left">
                    @if ($report_header->finalized_by != '')
                    @if ($po_hospital_details->hospital_code != 'EWMCH')
                    <i>{{Session::get('user.ses_hospital_code')=="UNICO" ? 'Approved By' : 'Finalized BY'}}</i>
                    @endif

                    {{-- <div><strong>{{ $report_header->finalized_by }}</strong></div> --}}
                    <div>

                        @if ($report_header->fin_digital_signature_ind == 1)
                        <img src="{{ asset('images/uploads/doctor_images/thumb/' . $report_header->fin_doctor_signature_image) }}" alt="image" style="width: 120px;height:30px">
                        @endif

                        @php echo $report_header->fin_doctor_signature @endphp

                    </div>
                    @endif
                </td>
                <td width="25%" class="text-left">
                    @if ($report_header->ent_doctor_signature != '')
                    @if ($po_hospital_details->hospital_code != 'EWMCH')
                    <i>Consult BY</i>
                    @endif

                    {{-- <div><strong>{{ $report_header->finalized_by }}</strong></div> --}}
                    <div>
                        @if ($report_header->ent_digital_signature_ind == 1)
                        <img src="{{ asset('images/uploads/doctor_images/thumb/' . $report_header->ent_doctor_signature_image) }}" alt="image" style="width: 120px;height:30px">
                        @endif
                        @php echo $report_header->ent_doctor_signature @endphp
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
        @if ($draft =='draft')
            <tr>
                <td colspan="4" style="text-align: left; vertical-align:bottom">
                    Advice : Please collect the final report after finalization.
                </td>
            </tr>
        @endif
    </table>

    @else

    @if ($po_hospital_details->hospital_code == 'AMCSH')

    <table style="width: 95%; font-size: 11px; {{$imp_mergin_botton}} " class="footer_2">


        <tr>
            <td width="33%" style="text-align: left;">
                @if ($report_header->prepared_by != '')
                @if ($po_hospital_details->hospital_code != 'EWMCH')
                @if (!in_array(Session::get('user.ses_hospital_code') , ['IMPERIAL','AMCSH','DMHL']))
                <i>Prepared BY</i>
                @endif
                @endif
                {{-- <div><strong>{{ $report_header->prepared_by }}</strong></div> --}}
                <div>
                    @if ($report_header->pr_digital_signature_ind == 1)
                    <img src="{{ asset('images/uploads/doctor_images/thumb/' . $po_hospital_details->pr_doctor_signature_image) }}" alt="image" style="width: 120px;height:30px">
                    @endif
                    @php echo $report_header->pr_doctor_signature @endphp
                </div>
                <!-- <div>Certified Ortopedic Surgeon</div> -->
                @endif
            </td>

            <td width="33%" style="text-align: left;">
                @if ($report_header->verified_by != '')

                {{-- <div><strong>{{ $report_header->verified_by }}</strong></div> --}}
                <div>
                    @if ($report_header->vr_digital_signature_ind == 1)
                    <img src="{{ asset('images/uploads/doctor_images/thumb/' . $report_header->vr_doctor_signature_image) }}" alt="image" style="width: 120px;height:30px">
                    @endif
                    @php echo $report_header->vr_doctor_signature @endphp
                </div>
                @endif
            </td>
                @if ($draft != 'draft')
                            <td width="33%" class="text-left">
                                @if ($report_header->finalized_by != '')
                                @if ($po_hospital_details->hospital_code != 'EWMCH')
                                @if (!in_array(Session::get('user.ses_hospital_code') , ['IMPERIAL','AMCSH','DMHL']))
                                <i>{{Session::get('user.ses_hospital_code')=="UNICO" ? 'Approved By' : 'Finalized BY'}}</i>
                                @endif
                                @endif

                                {{-- <div><strong>{{ $report_header->finalized_by }}</strong></div> --}}
                                <div>
                                    @if ($report_header->fin_digital_signature_ind == 1)
                                    <img src="{{ asset('images/uploads/doctor_images/thumb/' . $po_hospital_details->fin_doctor_signature_image) }}" alt="image" style="width: 120px;height:30px">
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
        @if ($draft =='draft')
            <tr>
                <td colspan="4" style="text-align: left; vertical-align:bottom">
                    Advice : Please collect the final report after finalization.
                </td>
            </tr>
        @endif
    </table>
    @else   
    <table style="width: 95%; font-size: 11px; {{$imp_mergin_botton}} " class="footer_2">
        <tr>
            <td width="60%" style="text-align: left;">
                @if ($report_header->prepared_by != '')
                @if ($po_hospital_details->hospital_code != 'EWMCH')
                @if (!in_array(Session::get('user.ses_hospital_code') , ['IMPERIAL','AMCSH','DMHL']))
                <i>Prepared BY</i>
                @endif
                @endif

                <div>
                    @if ($report_header->pr_digital_signature_ind == 1)
                    <img src="{{ asset('images/uploads/doctor_images/thumb/' . $report_header->pr_doctor_signature_image) }}" alt="image" style="width: 120px;height:30px">
                    @endif
                    @php echo $report_header->pr_doctor_signature @endphp
                </div>
                @endif
            </td>
            @if ($draft != 'draft')
            <td width="40%" class="text-left">
                @if ($report_header->finalized_by != '')
                @if ($po_hospital_details->hospital_code != 'EWMCH')
                @if (!in_array(Session::get('user.ses_hospital_code') , ['IMPERIAL','AMCSH','DMHL']))
                <i>{{Session::get('user.ses_hospital_code')=="UNICO" ? 'Approved By' : 'Finalized BY'}}</i>
                @endif
                @endif

                {{-- <div><strong>{{ $report_header->finalized_by }}</strong></div> --}}
                <div>
                    @if ($report_header->fin_digital_signature_ind == 1)
                    <img src="{{ asset('images/uploads/doctor_images/thumb/' . $report_header->fin_doctor_signature_image) }}" alt="image" style="width: 120px;height:30px">
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
        @if ($draft =='draft')
            <tr>
                <td colspan="4" style="text-align: left; vertical-align:bottom">
                    Advice : Please collect the final report after finalization.
                </td>
            </tr>
        @endif
    </table>
    @endif


    @if (in_array($po_hospital_details->hospital_code ,[ 'IMPERIAL','DMHL']))
    <?php
    $dt = new DateTime("now", new DateTimezone("Asia/Dhaka"));

    $date = $dt->format("g:i A");
    ?>

    <table style="" class="footer_3">
        <tr>
            <td style="border: 0px; padding-top: 5px; text-align: left; font-size:8px">Prepared
                By:{{ Session::get('user.ses_user_name') }},
                Printing Date & Time: {{ date('d/m/Y') }} , {{ $date }},

                &nbsp;Powered By: [NEXTGEN]
            </td>

        </tr>
    </table>
    @endif

    @endif
    @endif


</body>

</html>
