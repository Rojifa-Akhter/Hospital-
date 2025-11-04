<!DOCTYPE html>
<html lang="bn">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Intra Operative Nursing</title>


    <style>
        .fs-12 {
            font-size: 14px;
        }

        .table {
            border-collapse: collapse;
            width: 100%;
        }

        .table-bordered {
            border: 1px solid #333;
        }

        td {
            font-size: 13px;
            border: 1px solid #333;
            padding-right: 3px;
        }


        .form-check {
            position: relative;
            display: block;
            padding-left: 1.25rem;
        }

        .form-check-inline {
            display: inline-block !important;
            margin-right: 1rem;
        }

        .form-check-input {
            position: static;
            margin-top: 0.3rem;
            margin-left: -1.25rem;
        }

        .form-check-label {
            margin-bottom: 0px !important;
        }

        .w-16 {
            width: 16%;
        }

        .w-8 {
            width: 8%;
        }

        .w-15 {
            width: 15%;
        }

        .w-25 {
            width: 25%;
        }

        .text-left {
            text-align: left;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .header>tbody>tr>td,
        .header>thead>tr>td {
            border: none;
        }

        body {
            /* margin-top: 4cm; */
            margin-bottom: 0.6cm;
            margin-left: 1cm;
        }

        .footer-table {
            /* position: absolute;
            bottom: 0px;
            width: 100%; */

            margin-top: 10px;
        }

        td {
            page-break-inside: avoid
        }

        .removeMargin p {
            margin: 0;
        }
    </style>
</head>

<body onload="window.print()">

    <table class="table header">
        <thead>
            <tr>
                <td style="width:65%">
                    <ul style="list-style: none; padding-left: 0; display:inline-block;">

                        <li><img style="" src="data:image/png;base64, {{ $invoice_barcode }} "></li>
                        <li><span><b>Name:</b>{{ isset($pat_info->patient_name) ? $pat_info->patient_name : '' }}</span>
                            &nbsp;<span><b>Age:</b>{{ isset($pat_info->age) ? $pat_info->age : '' }}</span>
                            &nbsp;<b>Gender:</b><span>{{ isset($pat_info->gender_txt) ? $pat_info->gender_txt : '' }}</span>

                        <li><b>Con. Number :</b>&nbsp;<span>{{ $pat_info->mobile1 }}</span></li>

                    </ul>
                </td>
                <td style="text-align:right;width:35%">
                    <ul style="list-style: none; padding-left: 0;">
                        <li><b>UHID:</b>&nbsp;<span>{{ isset($pat_info->patient_code) ? $pat_info->patient_code : '' }}</span>
                        </li>
                        <li><img style="" src="data:image/png;base64, {{ $pat_barcode }} "></li>
                        <li><b>Phone:</b>&nbsp;<span>{{ isset($pat_info->mobile1) ? $pat_info->mobile1 : '' }}</span>
                        </li>
                        <li><b>Reg. Date:</b>&nbsp;<span>{{isset($pat_info->reg_date) ? $pat_info->reg_date : ''  }}</span>
                        </li>

                    </ul>
                </td>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td colspan="2">
                    <div
                        style="padding: 7px; border-top:1px dotted black; border-bottom:1px dotted black;text-align:center;margin-top:10px; margin-bottom:20px">
                        <span style="font-size: 16px;"><b>Intra-Operative Nursing Record</b></span>

                    </div>
                    <table width="100%" class="table table-bordered">
                        <tbody>
                        <tr>
                            <td><strong>DATE</strong></td>
                            <td>{{ @$intraOperativeNursingData->intra_date ? date('d-m-Y', strtotime($intraOperativeNursingData->intra_date)) : date('d-m-Y') }}</td>
                            <td><strong>OT NO </strong></td>
                            <td>{{ @$intraOperativeNursingData->ot_no }}</td>
                            <td><strong>PATIENT IN</strong></td>
                            <td>
                                @php
                                    $patient_in = explode(
                                        ' ',
                                        @$intraOperativeNursingData->patient_in,
                                    );
                                    $patient_out = explode(
                                        ' ',
                                        @$intraOperativeNursingData->patient_out,
                                    );
                                @endphp
                               @if(!empty(@$patient_in[1])) {{date('h:i A', strtotime(@$patient_in[1]))}} @endif
                            </td>
                            <td><strong>PATIENT OUT</strong></td>
                            <td>{{ @$patient_out[1] ?  date('h:i A', strtotime($patient_out[1]))  : ''}}</td>
                        </tr>
                        <tr>
                            <td class="text-center" colspan="5">Surgery Performed</td>
                            <td class="text-center" colspan="3">Anesthesia</td>
                        </tr>
                        <tr>
                            <td class="text-left" colspan="1">Surgeon</td>
                            <td class="text-left" colspan="3">
                                {{ @$intraOperativeNursingData->sur_surgeon_person_no_fk }}
                            </td>
                            <td class="text-left" colspan="1">Start Time</td>
                            <td class="text-left"
                                colspan="3
                            ">
                                @php $anes_stime = explode(" ", @$intraOperativeNursingData->anes_stime); @endphp
                                {{ @$anes_stime[1] ?  date('h:i A', strtotime($anes_stime[1]))  : ''}}
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left" colspan="1">Asst Surgeon</td>
                            <td class="text-left" colspan="3">
                                {{ @$intraOperativeNursingData->asst_sur_person_no_fk }}
                            </td>
                            <td class="text-left" colspan="1">End Time</td>
                            <td class="text-left" colspan="3">
                                @php $anes_etime = explode(" ", @$intraOperativeNursingData->anes_etime); @endphp
                                {{ @$anes_etime[1] ?  date('h:i A', strtotime($anes_etime[1]))  : ''}}
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left" colspan="1">Anesthetist</td>
                            <td class="text-left" colspan="3">
                               {{ @$intraOperativeNursingData->anesthesist_person_no_fk }}
                            </td>
                            <td class="text-center" colspan="4">Surgery</td>
                        </tr>
                        </tr>
                        <tr>
                            <td class="text-left" colspan="1">Anesthesia tech</td>
                            <td class="text-left" colspan="3">
                               {{ @$intraOperativeNursingData->anes_tech_person_no_fk }}
                            </td>
                            <td class="text-left" colspan="1">Start Time</td>
                            <td class="text-left" colspan="3">
                                @php $sur_stime = explode(" ", @$intraOperativeNursingData->sur_stime); @endphp
                                {{ @$sur_stime[1] ?  date('h:i A', strtotime($sur_stime[1]))  : ''}}
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left" colspan="1">Diathermy site</td>
                            <td class="text-left" colspan="3">{{ @$intraOperativeNursingData->dia_site }}</td>
                            <td class="text-left" colspan="1">End Time</td>
                            <td class="text-left" colspan="3">
                                @php $sur_etime = explode(" ", @$intraOperativeNursingData->sur_etime); @endphp
                               {{ @$sur_etime[1] ?  date('h:i A', strtotime($sur_etime[1]))  : ''}}
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left" colspan="1">Tourniquet site </td>
                            <td class="text-left" colspan="1">Start Time:</td>
                            <td class="text-left" colspan="1">
                                @php $tour_site_stime = explode(" ", @$intraOperativeNursingData->tour_site_stime); @endphp
                               {{ @$tour_site_stime[1] ?  date('h:i A', strtotime($tour_site_stime[1]))  : ''}}

                            </td>
                            <td class="text-left" colspan="1">End Time:</td>
                            <td class="text-left" colspan="1">
                                @php $tour_site_etime = explode(" ", @$intraOperativeNursingData->tour_site_etime); @endphp
                               {{ @$tour_site_etime[1] ?  date('h:i A', strtotime($tour_site_etime[1]))  : ''}}
                            </td>
                            <td colspan="2">Operation Category</td>
                            <td colspan="1">
                                        {{ @$intraOperativeNursingData->op_catergory == '1' ? 'Major' : '' }}
                                        {{ @$intraOperativeNursingData->op_catergory == '2' ? 'Minor' : '' }}
                                        {{ @$intraOperativeNursingData->op_catergory == '3' ? 'Emergency' : '' }}
                                        {{ @$intraOperativeNursingData->op_catergory == '4' ? 'Elective' : '' }}
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left" colspan="2"><strong>Position:</strong></td>
                            <td colspan="6">

                                        {{ @$intraOperativeNursingData->position == '1' ? 'Supine' : '' }}
                                        {{ @$intraOperativeNursingData->position == '2' ? 'Lithotomy' : '' }}
                                        {{ @$intraOperativeNursingData->position == '3' ? 'Prone' : '' }}
                                        {{ @$intraOperativeNursingData->position == '4' ? 'Lateral' : '' }}
                                        {{ @$intraOperativeNursingData->position == '5' ? 'Others' : '' }}
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left" colspan="2">Blood Transfusion:</td>
                            <td colspan="6">
                                        {{ @$intraOperativeNursingData->blood_trans == '1' ? 'No' : '' }}
                                        {{ @$intraOperativeNursingData->blood_trans == '2' ? 'Yes' : '' }}
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left" colspan="2">Implants:</td>
                            <td colspan="2">
                                        {{ @$intraOperativeNursingData->implant == '1' ? 'No' : '' }}
                                        {{ @$intraOperativeNursingData->implant == '2' ? 'Yes' : '' }}

                            </td>
                            <td colspan="4">
                                {{ @$intraOperativeNursingData->implant_text }}
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left" colspan="1">Specimen:</td>
                            <td colspan="2">
                                        {{ @$intraOperativeNursingData->specimen == '1' ? 'No' : '' }}
                                        {{ @$intraOperativeNursingData->specimen == '2' ? 'Yes' : '' }}

                            </td>
                            <td class="text-left" colspan="1">Frozen Section:</td>
                            <td colspan="2">
                                    {{ @$intraOperativeNursingData->froz_sec == '1' ? 'No' : '' }}
                                    {{ @$intraOperativeNursingData->froz_sec == '2' ? 'Yes' : '' }}
                            </td>
                            <td colspan="2">
                                {{ @$intraOperativeNursingData->froz_sec_text }}
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left" colspan="1"></td>
                            <td class="text-left" colspan="2"><strong>Pre Op</strong></td>
                            <td class="text-left" colspan="2"><strong>Pre Op</strong> </td>
                            <td class="text-center" colspan="3">If Yes Details:</td>

                        </tr>
                        <tr>
                            <td colspan="1">Packs</td>
                            <td colspan="2">
                                        {{ @$intraOperativeNursingData->preop_packs == '1' ? 'No' : '' }}
                                        {{ @$intraOperativeNursingData->preop_packs == '2' ? 'Yes' : '' }}
                            </td>
                            <td colspan="2">
                                        {{ @$intraOperativeNursingData->postop_packs == '1' ? 'No' : '' }}
                                        {{ @$intraOperativeNursingData->postop_packs == '2' ? 'Yes' : '' }}
                            </td>
                            <td colspan="3">
                               {{ @$intraOperativeNursingData->packs_text }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="1">Drains</td>
                            <td colspan="2">
                                        {{ @$intraOperativeNursingData->pre_drains == '1' ? 'No' : '' }}</option>
                                        {{ @$intraOperativeNursingData->pre_drains == '2' ? 'Yes' : '' }}
                            </td>
                            <td colspan="2">
                                        {{ @$intraOperativeNursingData->post_drans == '1' ? 'No' : '' }}
                                        {{ @$intraOperativeNursingData->post_drans == '2' ? 'Yes' : '' }}

                            </td>
                            <td colspan="3">
                                {{ @$intraOperativeNursingData->drain_text }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="1">Catheter</td>
                            <td colspan="2">
                                        {{ @$intraOperativeNursingData->pre_cath == '1' ? 'No' : '' }}
                                        {{ @$intraOperativeNursingData->pre_cath == '2' ? 'Yes' : '' }}
                            </td>
                            <td colspan="2">
                                        {{ @$intraOperativeNursingData->post_cath == '1' ? 'No' : '' }}
                                        {{ @$intraOperativeNursingData->post_cath == '2' ? 'Yes' : '' }}
                            </td>
                            <td colspan="3">
                               {{ @$intraOperativeNursingData->cath_text }}
                            </td>
                        </tr>
                        <tr>
                            <td><strong>COUNT<strong></td>
                            <td><strong>INITIAL<strong></td>
                            <td><strong>ADDITION<strong></td>
                            <td><strong>FIRST<strong></td>
                            <td><strong>ADDITTION<strong></td>
                            <td><strong>SECOND<strong></td>
                            <td><strong>ADDITION<strong></td>
                            <td><strong>FINAL CLOSING COUNT<strong></td>
                        </tr>
                        <tr>
                            <td>Raytex Gauze</td>
                            <td>
                              {{ @$intraOperativeNursingData->ini_raytex }}
                            </td>
                            <td>
                               {{ @$intraOperativeNursingData->add1_raytex }}
                            </td>
                            <td>
                               {{ @$intraOperativeNursingData->first_raytex }}
                            </td>
                            <td>
                               {{ @$intraOperativeNursingData->add2_raytex }}
                            </td>
                            <td>
                                {{ @$intraOperativeNursingData->seoond_raytex }}
                            </td>
                            <td>
                                {{ @$intraOperativeNursingData->add3_raytex }}
                            </td>
                            <td>
                                {{ @$intraOperativeNursingData->final_cc_raytex }}
                            </td>
                        </tr>
                        <tr>
                            <td>Sponge</td>
                            <td>
                               {{ @$intraOperativeNursingData->ini_sponge }}
                            </td>
                            <td>
                                {{ @$intraOperativeNursingData->add1_sponge }}
                            </td>
                            <td>
                                {{ @$intraOperativeNursingData->first_sponge }}
                            </td>
                            <td>
                               {{ @$intraOperativeNursingData->add2_sponge }}
                            </td>
                            <td>
                                {{ @$intraOperativeNursingData->seoond_sponge }}
                            </td>
                            <td>
                               {{ @$intraOperativeNursingData->add3_sponge }}
                            </td>
                            <td>
                                {{ @$intraOperativeNursingData->final_cc_sponge }}
                            </td>
                        </tr>
                        <tr>
                            <td>Packing sponge</td>
                            <td>
                                {{ @$intraOperativeNursingData->ini_pack }}
                            </td>
                            <td>
                               {{ @$intraOperativeNursingData->add1_pack }}
                            </td>
                            <td>
                               {{ @$intraOperativeNursingData->first_pack }}
                            </td>
                            <td>
                                {{ @$intraOperativeNursingData->add2_pack }}
                            </td>
                            <td>
                               {{ @$intraOperativeNursingData->seoond_pack }}
                            </td>
                            <td>
                               {{ @$intraOperativeNursingData->add3_pack }}
                            </td>
                            <td>
                                {{ @$intraOperativeNursingData->final_cc_packs }}
                            </td>
                        </tr>
                        <tr>
                            <td>Peanuts</td>
                            <td>
                                {{ @$intraOperativeNursingData->ini_peanuts }}
                            </td>
                            <td>
                                {{ @$intraOperativeNursingData->add1_peanuts }}
                            </td>
                            <td>
                                {{ @$intraOperativeNursingData->first_peanuts }}
                            </td>
                            <td>
                                {{ @$intraOperativeNursingData->add2_peanuts }}
                            </td>
                            <td>
                                {{ @$intraOperativeNursingData->seoond_peanuts }}
                            </td>
                            <td>
                               {{ @$intraOperativeNursingData->add3_peanuts }}
                            </td>
                            <td>
                                {{ @$intraOperativeNursingData->final_cc_peanuts }}
                            </td>
                        </tr>
                        <tr>
                            <td>Patties
                            <td>
                                {{ @$intraOperativeNursingData->ini_patties }}
                            </td>
                            <td>
                                {{ @$intraOperativeNursingData->add1_patties }}
                            </td>
                            <td>
                                {{ @$intraOperativeNursingData->first_patties }}
                            </td>
                            <td>
                                {{ @$intraOperativeNursingData->add2_patties }}
                            </td>
                            <td>
                               {{ @$intraOperativeNursingData->seoond_patties }}
                            </td>
                            <td>
                                {{ @$intraOperativeNursingData->add3_patties }}
                            </td>
                            <td>
                               {{ @$intraOperativeNursingData->final_cc_patties }}
                            </td>
                        </tr>
                        <tr>
                            <td>Cotton balls</td>
                            <td>
                                {{ @$intraOperativeNursingData->ini_cotton_ball }}
                            </td>
                            <td>
                               {{ @$intraOperativeNursingData->add1_cotton_ball }}
                            </td>
                            <td>
                               {{ @$intraOperativeNursingData->first_cotton_ball }}
                            </td>
                            <td>
                               {{ @$intraOperativeNursingData->add2_cotton_ball }}
                            </td>
                            <td>
                                {{ @$intraOperativeNursingData->seoond_cotton_ball }}
                            </td>
                            <td>
                                {{ @$intraOperativeNursingData->add3_cotton_ball }}
                            </td>
                            <td>
                               {{ @$intraOperativeNursingData->final_cc_cotton_ball }}
                            </td>
                        </tr>
                        <tr>
                            <td>Roller Gauze </td>
                            <td>
                                {{ @$intraOperativeNursingData->ini_roller }}
                            </td>
                            <td>
                                {{ @$intraOperativeNursingData->add1_roller }}
                            </td>
                            <td>
                               {{ @$intraOperativeNursingData->first_roller }}
                            </td>
                            <td>
                               {{ @$intraOperativeNursingData->add2_roller }}
                            </td>
                            <td>
                                {{ @$intraOperativeNursingData->seoond_roller }}
                            </td>
                            <td>
                                {{ @$intraOperativeNursingData->add3_roller }}
                            </td>
                            <td>
                                {{ @$intraOperativeNursingData->final_cc_roller }}
                            </td>
                        </tr>
                        <tr>
                            <td>Vessel loop</td>
                            <td>{{ @$intraOperativeNursingData->ini_vessel }}
                            </td>
                            <td>
                                {{ @$intraOperativeNursingData->add1_vessel }}
                            </td>
                            <td>
                                {{ @$intraOperativeNursingData->first_vessel }}
                            </td>
                            <td>
                                {{ @$intraOperativeNursingData->add2_vessel }}
                            </td>
                            <td>
                                {{ @$intraOperativeNursingData->seoond_vessel }}
                            </td>
                            <td>
                                {{ @$intraOperativeNursingData->add3_vessel }}
                            </td>
                            <td>
                               {{ @$intraOperativeNursingData->final_cc_vessel }}
                            </td>
                        </tr>
                        <tr>
                            <td>Blades</td>
                            <td> {{ @$intraOperativeNursingData->ini_blades }}
                            </td>
                            <td>
                                {{ @$intraOperativeNursingData->add1_blades }}
                            </td>
                            <td>
                                {{ @$intraOperativeNursingData->first_blades }}
                            </td>
                            <td>
                               {{ @$intraOperativeNursingData->add2_blades }}
                            </td>
                            <td>
                                {{ @$intraOperativeNursingData->seoond_blades }}
                            </td>
                            <td>
                                {{ @$intraOperativeNursingData->add3_blades }}
                            </td>
                            <td>
                               {{ @$intraOperativeNursingData->final_blades }}
                            </td>
                        </tr>
                        <tr>
                            <td>Suture Needles</td>
                            <td> {{ @$intraOperativeNursingData->ini_sture }}
                            </td>
                            <td>
                               {{ @$intraOperativeNursingData->add1_sture }}
                            </td>
                            <td>
                                {{ @$intraOperativeNursingData->first_sture }}
                            </td>
                            <td>
                                {{ @$intraOperativeNursingData->add2_sture }}
                            </td>
                            <td>
                               {{ @$intraOperativeNursingData->seoond_sture }}
                            </td>
                            <td>
                               {{ @$intraOperativeNursingData->add3_sture }}
                            </td>
                            <td>
                                {{ @$intraOperativeNursingData->final_sture }}
                            </td>
                        </tr>
                        <tr>
                            <td>Inj. Needle</td>
                            <td> {{ @$intraOperativeNursingData->ini_injneedle }}
                            </td>
                            <td>
                                {{ @$intraOperativeNursingData->add1_injneedle }}
                            </td>
                            <td>
                               {{ @$intraOperativeNursingData->first_injneedle }}
                            </td>
                            <td>
                                {{ @$intraOperativeNursingData->add2_injneedle }}
                            </td>
                            <td>
                                {{ @$intraOperativeNursingData->seoond_injneedle }}
                            </td>
                            <td>
                                {{ @$intraOperativeNursingData->add3_injneedle }}
                            </td>
                            <td>
                                {{ @$intraOperativeNursingData->final_injneedle }}
                            </td>
                        </tr>
                        <tr>
                            <td>Jelco</td>
                            <td> {{ @$intraOperativeNursingData->ini__jelco }}
                            </td>
                            <td>
                               {{ @$intraOperativeNursingData->add1_jelco }}
                            </td>
                            <td>
                                {{ @$intraOperativeNursingData->first_jelco }}
                            </td>
                            <td>
                                {{ @$intraOperativeNursingData->add2_jelco }}
                            </td>
                            <td>
                                {{ @$intraOperativeNursingData->seoond_jelco }}
                            </td>
                            <td>
                                {{ @$intraOperativeNursingData->add3_jelco }}
                            </td>
                            <td>
                                {{ @$intraOperativeNursingData->final_jelco }}
                            </td>
                        </tr>
                        <tr>
                            <td>Shunts</td>
                            <td> {{ @$intraOperativeNursingData->ini_shunts }}
                            </td>
                            <td>
                               {{ @$intraOperativeNursingData->add1_shunts }}
                            </td>
                            <td>
                               {{ @$intraOperativeNursingData->first_shunts }}
                            </td>
                            <td>
                                {{ @$intraOperativeNursingData->add2_shunts }}
                            </td>
                            <td>
                                {{ @$intraOperativeNursingData->seoond_shunts }}
                            </td>
                            <td>
                                {{ @$intraOperativeNursingData->add3_shunts }}
                            </td>
                            <td>
                               {{ @$intraOperativeNursingData->final_shunts }}
                            </td>
                        </tr>
                        <tr>
                            <td>Snuggers</td>
                            <td> {{ @$intraOperativeNursingData->ini_sunggers }}
                            </td>
                            <td>
                                {{ @$intraOperativeNursingData->add1_sunggers }}
                            </td>
                            <td>
                                {{ @$intraOperativeNursingData->first_sunggers }}
                            </td>
                            <td>
                                {{ @$intraOperativeNursingData->add2_sunggers }}
                            </td>
                            <td>
                                {{ @$intraOperativeNursingData->seoond_sunggers }}
                            </td>
                            <td>
                                {{ @$intraOperativeNursingData->add3_sunggers }}
                            </td>
                            <td>
                                {{ @$intraOperativeNursingData->final_sunggers }}
                            </td>
                        </tr>
                        <tr>
                            <td>Vessel Cannula</td>
                            <td> {{ @$intraOperativeNursingData->ini_vc }}
                            </td>
                            <td>
                                {{ @$intraOperativeNursingData->add1_vc }}
                            </td>
                            <td>
                               {{ @$intraOperativeNursingData->first_vc }}
                            </td>
                            <td>
                                {{ @$intraOperativeNursingData->add2_vc }}
                            </td>
                            <td>
                               {{ @$intraOperativeNursingData->seoond_vc }}
                            </td>
                            <td>
                                {{ @$intraOperativeNursingData->add3_vc }}
                            </td>
                            <td>
                                {{ @$intraOperativeNursingData->final_vc }}
                            </td>
                        </tr>
                        <tr>
                            <td>Bulloog clamp metal </td>
                            <td> {{ @$intraOperativeNursingData->ini_bullog_cm }}
                            </td>
                            <td>
                                {{ @$intraOperativeNursingData->add1_bullog_cm }}
                            </td>
                            <td>
                                {{ @$intraOperativeNursingData->first_bullog_cm }}
                            </td>
                            <td>
                                {{ @$intraOperativeNursingData->add2_bullog_cm }}
                            </td>
                            <td>
                               {{ @$intraOperativeNursingData->seoond_bullog_cm }}
                            </td>
                            <td>
                                {{ @$intraOperativeNursingData->add3_bullog_cm }}
                            </td>
                            <td>
                                {{ @$intraOperativeNursingData->final_bullog_cm }}
                            </td>
                        </tr>
                        <tr>
                            <td>Bulloog clamp Plastic</td>
                            <td> {{ @$intraOperativeNursingData->ini_bullog_cp }}
                            </td>
                            <td>
                               {{ @$intraOperativeNursingData->add1_bullog_cp }}
                            </td>
                            <td>
                                {{ @$intraOperativeNursingData->first_bullog_cp }}
                            </td>
                            <td>
                                {{ @$intraOperativeNursingData->add2_bullog_cp }}
                            </td>
                            <td>
                                {{ @$intraOperativeNursingData->seoond_bullog_cp }}
                            </td>
                            <td>
                               {{ @$intraOperativeNursingData->add3_bullog_cp }}
                            </td>
                            <td>
                                {{ @$intraOperativeNursingData->final_bullog_cp }}
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Instruments</strong></td>
                            <td> {{ @$intraOperativeNursingData->ini_ins }}
                            </td>
                            <td>
                                {{ @$intraOperativeNursingData->add1_ins }}
                            </td>
                            <td>
                                {{ @$intraOperativeNursingData->first_ins }}
                            </td>
                            <td>
                                {{ @$intraOperativeNursingData->add2_ins }}
                            </td>
                            <td>
                                {{ @$intraOperativeNursingData->seoond_ins }}
                            </td>
                            <td>
                              {{ @$intraOperativeNursingData->add3_ins }}
                            </td>
                            <td>
                                {{ @$intraOperativeNursingData->final_ins }}
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Instruments set used</strong>
                            </td>
                            <td> {{ @$intraOperativeNursingData->ini_ins_used }}
                            </td>
                            <td>
                                {{ @$intraOperativeNursingData->add1_ins_used }}
                            </td>
                            <td>
                                {{ @$intraOperativeNursingData->first_ins_used }}
                            </td>
                            <td>
                                {{ @$intraOperativeNursingData->add2_ins_used }}
                            </td>
                            <td>
                               {{ @$intraOperativeNursingData->seoond_ins_used }}
                            </td>
                            <td>
                                {{ @$intraOperativeNursingData->add3_ins_used }}
                            </td>
                            <td>
                                {{ @$intraOperativeNursingData->final_ins_used }}
                            </td>
                        </tr>
                        <tbody>
                    </table>
                    <table width="100%" class="table table-bordered" style="margin-top: 20px;">
                        <tr>
                            <td></td>
                            <td><strong>NAME</strong></td>
                            <td style="width: 10%;"><strong>Sign</strong></td>
                            <td><strong>RELEIVING NURSE</strong></td>
                            <td><strong>TIME</strong></td>
                            <td style="width: 10%;"><strong>SIGN</strong></td>
                        </tr>
                        <tr>
                            <td>INSTRUMENT NURSE</td>
                            <td>
                                {{ @$intraOperativeNursingData->ins_nurse_person_no_fk }}
                            </td>
                            <td></td>
                            <td>
                               {{ @$intraOperativeNursingData->ins_revnurse_person_no_fk }}
                            </td>
                            <td>
                                @php $ins_time = explode(" ", @$intraOperativeNursingData->ins_time); @endphp
                                {{ @$ins_time[1] ? date('h:i:s A', strtotime(@$ins_time[1])) :''}}
                            </td>
                            </td>
                            <td></td>
                        </tr>

                        <tr>
                            <td>SCRUB NURSE 1</td>
                            <td>
                                {{ @$intraOperativeNursingData->snurse1_person_no_fk }}
                            </td>
                            <td></td>
                            <td>
                               {{ @$intraOperativeNursingData->snurse1re_person_no_fk }}
                            </td>
                            <td>
                                @php $snurse1_time = explode(" ", @$intraOperativeNursingData->snurse1_time); @endphp
                               {{ @$snurse1_time[1] ? date('h:i:s A', strtotime(@$snurse1_time[1])) : ''}}
                            </td>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>SCRUB NURSE 2</td>
                            <td>
                               {{ @$intraOperativeNursingData->snurse2_person_no_fk }}
                            </td>
                            <td></td>
                            <td>
                               {{ @$intraOperativeNursingData->snurse2re_person_no_fk }}
                            </td>
                            <td>
                                @php $snurse2_time = explode(" ", @$intraOperativeNursingData->snurse2_time); @endphp
                                {{ @$snurse2_time[1] ? date('h:i:s A', strtotime(@$snurse2_time[1])) : '' }}
                            </td>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>CIRCULATING NURSE</td>
                            <td>
                               {{ @$intraOperativeNursingData->crnurse_person_no_fk }}
                            </td>
                            <td></td>
                            <td>
                                {{ @$intraOperativeNursingData->crnursere_person_no_fk }}
                            </td>
                            <td>
                                @php $crnurse_time = explode(" ", @$intraOperativeNursingData->crnurse_time); @endphp
                                {{ @$crnurse_time[1] ? date('h:i:s A', strtotime(@$crnurse_time[1])) : ''}}
                            </td>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>COUNT CORRECTION </td>
                            <td colspan="5"> {{ @$intraOperativeNursingData->cc_text }}</td>
                        </tr>
                        <tr>
                            <td>ANY UNTOWARD INCIDENT</td>
                            <td colspan="5"> {{ @$intraOperativeNursingData->ayi_text }}</td>
                        </tr>
                        <tr>
                            <td colspan="1">POST OP SKIN INTEGRITY</td>
                            <td colspan="1">
                                        {{ @$intraOperativeNursingData->post_osi == '1' ? 'INTACT' : '' }}
                                        {{ @$intraOperativeNursingData->post_osi == '2' ? 'REDNESS' : '' }}
                                        {{ @$intraOperativeNursingData->post_osi == '3' ? 'BLISTER' : '' }}
                                        {{ @$intraOperativeNursingData->post_osi == '4' ? 'HAEMATOMA' : '' }}
                            </td>
                            <td colspan="1">SIZE:</td>
                            <td colspan="1"> {{ @$intraOperativeNursingData->si_size }}</td>
                            <td colspan="1">SITE:</td>
                            <td colspan="1"> {{ @$intraOperativeNursingData->si_site }}</td>
                        </tr>
                        <tr>
                            <td>Patient Transfer to</td>
                            <td colspan="5">
                                        {{ @$intraOperativeNursingData->pt_trans == '1' ? 'Recovery Room' : '' }}
                                        {{ @$intraOperativeNursingData->pt_trans == '2' ? 'ICU' : '' }}
                                        {{ @$intraOperativeNursingData->pt_trans == '3' ? 'Ward' : '' }}
                                        {{ @$intraOperativeNursingData->pt_trans == '4' ? 'Daycare' : '' }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="1">HANDED OVER BY:</td>
                            <td colspan="2">
                                {{ @$intraOperativeNursingData->hby_person_no_fk }}
                            </td>
                            <td colspan="1">TAKEN OVER BY:</td>
                            <td colspan="2">
                                {{ @$intraOperativeNursingData->tby_person_no_fk }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="1">Remarks:</td>
                            <td colspan="5">
                                {{ @$intraOperativeNursingData->remarks }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>
