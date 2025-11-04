<!DOCTYPE html>
<html lang="bn">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pre-Operative/Procedure Checklist</title>


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
                        <li><b>IP
                                No:</b>&nbsp;<span>{{ isset($pat_info->admission_no_pk) ? $pat_info->admission_no_pk : '' }}</span>
                        </li>
                        <li><img style="" src="data:image/png;base64, {{ $invoice_barcode }} "></li>
                        <li><span><b>Name:</b>{{ isset($pat_info->patient_name) ? $pat_info->patient_name : '' }}</span>
                            &nbsp;<span><b>Age:</b>{{ isset($pat_info->age) ? $pat_info->age : '' }}</span>
                            &nbsp;<b>Gender:</b><span>{{ isset($pat_info->gender_txt) ? $pat_info->gender_txt : '' }}</span>
                            &nbsp;<b>Bed:</b>&nbsp;<span>{{ isset($pat_info->bed_name) ? $pat_info->bed_name : '' }}</span>
                        </li>
                        <li><b>Con. Number :</b>&nbsp;<span>{{ $pat_info->mobile1 }}</span></li>
                        <li><b>Consultant Name:</b>&nbsp;<span>{{ $pat_info->primary_doctor_name }}</span></li>
                    </ul>
                </td>
                <td style="text-align:right;width:35%">
                    <ul style="list-style: none; padding-left: 0;">
                        <li><b>UHID:</b>&nbsp;<span>{{ isset($pat_info->patient_code) ? $pat_info->patient_code : '' }}</span>
                        </li>
                        <li><img style="" src="data:image/png;base64, {{ $pat_barcode }} "></li>
                        <li><b>Phone:</b>&nbsp;<span>{{ isset($pat_info->mobile1) ? $pat_info->mobile1 : '' }}</span>
                        </li>
                        <li><b>IP
                                Date:</b>&nbsp;<span>{{ date('d/m/Y h:i a', strtotime($pat_info->admission_date)) }}</span>
                        </li>
                        @if (!empty($pat_info->dis_datetime))
                            <li><b>Date of
                                    Discharge:</b>&nbsp;<span>{{ date('d/m/Y h:i a', strtotime($pat_info->dis_datetime)) }}</span>
                            </li>
                        @endif

                    </ul>
                </td>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td colspan="2">
                    <div
                        style="padding: 7px; border-top:1px dotted black; border-bottom:1px dotted black;text-align:center;margin-top:10px; margin-bottom:20px">
                        <span style="font-size: 16px;"><b>Pre-Operative/Procedure Checklist</b></span>
                    </div>
                    <table width="100%"class="table table-bordered">
                        <tr>
                            <th class="text-center" colspan="4">Pre Op-Diagnosis</th>
                        </tr>
                        <tr>
                            <td class=''>Proposed Surgery/Procedure: </td>
                            <td class=''>{{ @$pre_operative_checklist->proposed_surgery_proc }}</td>
                            <td class=''>Date:</td>
                            <td class=''>
                                {{ isset($pre_operative_checklist->proposed_surgery_proc_date) ? date('d/m/Y', strtotime($pre_operative_checklist->proposed_surgery_proc_date)) : '' }}
                            </td>
                        </tr>
                        <tr>
                            <td class=''>Patient & Family Education: </td>
                            <td class=''>
                                {{ @$pre_operative_checklist->pat_family_education == '1' ? 'Done' : '' }}
                                {{ @$pre_operative_checklist->pat_family_education == '2' ? 'Not Done' : '' }}
                            </td>
                            <td class=''>Anesthesia:</td>
                            <td class=''>
                                {{ @$pre_operative_checklist->anesthesia == '1' ? 'GA' : '' }}
                                {{ @$pre_operative_checklist->anesthesia == '2' ? 'Spinal' : '' }}
                                {{ @$pre_operative_checklist->anesthesia == '3' ? 'Epidural' : '' }}
                                {{ @$pre_operative_checklist->anesthesia == '4' ? 'Local' : '' }}
                                {{ @$pre_operative_checklist->anesthesia == '5' ? 'Others' : '' }}
                            </td>
                        </tr>
                        <tr>
                            <td class=''>Contacted Name: </td>
                            <td class=''>{{ @$pre_operative_checklist->attender_name }}</td>
                            <td class=''>Contacted Relation:</td>
                            <td class=''>{{ @$pre_operative_checklist->attender_relation }}</td>
                        </tr>
                        <tr>
                            <td class=''>Contacted Phone: </td>
                            <td class=''>{{ @$pre_operative_checklist->attender_phone }}</td>
                            <td class=''>On Isolation:</td>
                            <td class=''>
                                {{ @$pre_operative_checklist->on_isolation == '1' ? 'Airborne' : '' }}
                                {{ @$pre_operative_checklist->on_isolation == '2' ? 'Droplet' : '' }}
                                {{ @$pre_operative_checklist->on_isolation == '3' ? 'Contact' : '' }}
                                {{ @$pre_operative_checklist->on_isolation == '4' ? 'Protective' : '' }}
                                {{ @$pre_operative_checklist->on_isolation == '5' ? 'Not Applicable' : '' }}
                            </td>
                        </tr>
                        <tr>
                            <td class=''>Needs: </td>
                            <td class=''>
                                {{ @$pre_operative_checklist->religious_cul_special == '1' ? 'Religious' : '' }}
                                {{ @$pre_operative_checklist->religious_cul_special == '2' ? 'Cultural' : '' }}
                                {{ @$pre_operative_checklist->religious_cul_special == '3' ? 'Special Needs' : '' }}
                            </td>
                            <td class=''>Specify:</td>
                            <td class=''>
                                {{ @$pre_operative_checklist->religious_cul_special_specify }}
                            </td>
                        </tr>
                    </table>
                    <table width="100%" class="table table-bordered" style="margin-top: 20px;">
                        <tbody>
                            <tr>
                                <td class='' style="font-weight: bold">Sl#</td>
                                <td style="font-weight: bold">Description </td>
                                <td class="text-center" style="font-weight: bold">Checked in Ward/ICU</td>
                                <td class="text-center" style="font-weight: bold">Checked in Pre OP</td>
                            </tr>
                            <tr>
                                <td class=''>1 </td>
                                <td class=''>ID band with correct name & UHID No</td>
                                <td>
                                    {{ @$pre_operative_checklist->id_band_uhid_correct_icu == '1' ? 'NA' : '' }}
                                    {{ @$pre_operative_checklist->id_band_uhid_correct_icu == '2' ? 'Yes' : '' }}
                                    {{ @$pre_operative_checklist->id_band_uhid_correct_icu == '3' ? 'No' : '' }}
                                </td>
                                <td>
                                    {{ @$pre_operative_checklist->id_band_uhid_correct_preop == '1' ? 'NA' : '' }}
                                    {{ @$pre_operative_checklist->id_band_uhid_correct_preop == '2' ? 'Yes' : '' }}
                                    {{ @$pre_operative_checklist->id_band_uhid_correct_preop == '3' ? 'No' : '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class=''>2 </td>
                                <td class=''>
                                    <div style="display:flex" class="removeMargin">
                                        <p>Allergy</p>
                                        <p>{{ @$pre_operative_checklist->allergy_specify ? ': ' . $pre_operative_checklist->allergy_specify : '' }}
                                        </p>
                                    </div>
                                </td>
                                <td>
                                    {{ @$pre_operative_checklist->allergy_band_icu == '1' ? 'NA' : '' }}
                                    {{ @$pre_operative_checklist->allergy_band_icu == '2' ? 'Yes' : '' }}
                                    {{ @$pre_operative_checklist->allergy_band_icu == '3' ? 'No' : '' }}
                                </td>
                                <td>
                                    {{ @$pre_operative_checklist->allergy_band_preop == '1' ? 'NA' : '' }}
                                    {{ @$pre_operative_checklist->allergy_band_preop == '2' ? 'Yes' : '' }}
                                    {{ @$pre_operative_checklist->allergy_band_preop == '3' ? 'No' : '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class=''>3 </td>
                                <td class=''>Allergy band</td>
                                <td>
                                    {{ @$pre_operative_checklist->allergy_band_icu == '1' ? 'NA' : '' }}
                                    {{ @$pre_operative_checklist->allergy_band_icu == '2' ? 'Yes' : '' }}
                                    {{ @$pre_operative_checklist->allergy_band_icu == '3' ? 'No' : '' }}

                                </td>
                                <td>

                                    {{ @$pre_operative_checklist->allergy_band_preop == '1' ? 'NA' : '' }}
                                    {{ @$pre_operative_checklist->allergy_band_preop == '2' ? 'Yes' : '' }}
                                    {{ @$pre_operative_checklist->allergy_band_preop == '3' ? 'No' : '' }}

                                </td>
                            </tr>
                            <tr>
                                <td class=''>4 </td>
                                <td class=''>Surgical site marking</td>
                                <td>
                                    {{ @$pre_operative_checklist->surgical_site_mark_icu == '1' ? 'NA' : '' }}
                                    {{ @$pre_operative_checklist->surgical_site_mark_icu == '2' ? 'Yes' : '' }}
                                    {{ @$pre_operative_checklist->surgical_site_mark_icu == '3' ? 'No' : '' }}
                                </td>
                                <td>


                                    {{ @$pre_operative_checklist->surgical_site_mark_preop == '1' ? 'NA' : '' }}
                                    {{ @$pre_operative_checklist->surgical_site_mark_preop == '2' ? 'Yes' : '' }}

                                    {{ @$pre_operative_checklist->surgical_site_mark_preop == '3' ? 'Yes' : '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class=''>5 </td>
                                <td class=''>Informed consent</td>
                                <td>
                                    {{ @$pre_operative_checklist->informed_consent_icu == '1' ? 'NA' : '' }}
                                    {{ @$pre_operative_checklist->informed_consent_icu == '2' ? 'Yes' : '' }}
                                    {{ @$pre_operative_checklist->informed_consent_icu == '3' ? 'No' : '' }}
                                </td>
                                <td>
                                    {{ @$pre_operative_checklist->informed_consent_preop == '1' ? 'NA' : '' }}
                                    {{ @$pre_operative_checklist->informed_consent_preop == '2' ? 'Yes' : '' }}
                                    {{ @$pre_operative_checklist->informed_consent_preop == '3' ? 'No' : '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class=''>6 </td>
                                <td class=''>
                                    <div style="display:flex" class="removeMargin">
                                        <p>Special consent for</p>
                                        <p>{{ @$pre_operative_checklist->special_consent_for ? ': ' . $pre_operative_checklist->special_consent_for : '' }}
                                        </p>
                                    </div>
                                </td>
                                <td>

                                    {{ @$pre_operative_checklist->special_consent_icu == '1' ? 'NA' : '' }}
                                    {{ @$pre_operative_checklist->special_consent_icu == '2' ? 'Yes' : '' }}
                                    {{ @$pre_operative_checklist->special_consent_icu == '3' ? 'No' : '' }}
                                </td>
                                <td>
                                    {{ @$pre_operative_checklist->special_consent_preop == '1' ? 'NA' : '' }}
                                    {{ @$pre_operative_checklist->special_consent_preop == '2' ? 'Yes' : '' }}
                                    {{ @$pre_operative_checklist->special_consent_preop == '3' ? 'No' : '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class=''>7 </td>
                                <td class=''>PAC</td>
                                <td>
                                    {{ @$pre_operative_checklist->pac_icu == '1' ? 'NA' : '' }}
                                    {{ @$pre_operative_checklist->pac_icu == '2' ? 'Yes' : '' }}
                                    {{ @$pre_operative_checklist->pac_icu == '3' ? 'No' : '' }}
                                </td>
                                <td>
                                    {{ @$pre_operative_checklist->pac_preop == '1' ? 'NA' : '' }}
                                    {{ @$pre_operative_checklist->pac_preop == '2' ? 'Yes' : '' }}
                                    {{ @$pre_operative_checklist->pac_preop == '3' ? 'No' : '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class=''>8 </td>
                                <td class=''>Anaesthesia Consent</td>
                                <td>
                                    {{ @$pre_operative_checklist->anesthesia_consent_icu == '1' ? 'NA' : '' }}
                                    {{ @$pre_operative_checklist->anesthesia_consent_icu == '2' ? 'Yes' : '' }}
                                    {{ @$pre_operative_checklist->anesthesia_consent_icu == '3' ? 'No' : '' }}
                                </td>
                                <td>
                                    {{ @$pre_operative_checklist->anesthesia_consent_preop == '1' ? 'NA' : '' }}
                                    {{ @$pre_operative_checklist->anesthesia_consent_preop == '2' ? 'Yes' : '' }}
                                    {{ @$pre_operative_checklist->anesthesia_consent_preop == '3' ? 'No' : '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class=''>9</td>
                                <td class=''>H/O any diseases Like CVA, HTN, DM, COPD</td>
                                <td>
                                    {{ @$pre_operative_checklist->ho_any_diseas_icu == '1' ? 'NA' : '' }}
                                    {{ @$pre_operative_checklist->ho_any_diseas_icu == '2' ? 'Yes' : '' }}
                                    {{ @$pre_operative_checklist->ho_any_diseas_icu == '3' ? 'No' : '' }}
                                </td>
                                <td>

                                    {{ @$pre_operative_checklist->ho_any_diseas_preop == '1' ? 'NA' : '' }}
                                    {{ @$pre_operative_checklist->ho_any_diseas_preop == '2' ? 'Yes' : '' }}
                                    {{ @$pre_operative_checklist->ho_any_diseas_preop == '3' ? 'No' : '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class=''>10</td>
                                <td class=''>
                                    <div style="display:flex" class="removeMargin">
                                        <p>Past surgical history</p>
                                        <p>{{ @$pre_operative_checklist->past_surgical_history_specify ? ': ' . $pre_operative_checklist->past_surgical_history_specify : '' }}
                                        </p>
                                    </div>
                                </td>
                                <td>
                                    {{ @$pre_operative_checklist->past_surgical_history_icu == '1' ? 'NA' : '' }}
                                    {{ @$pre_operative_checklist->past_surgical_history_icu == '2' ? 'Yes' : '' }}
                                    {{ @$pre_operative_checklist->past_surgical_history_icu == '3' ? 'No' : '' }}

                                </td>
                                <td>
                                    {{ @$pre_operative_checklist->past_surgical_history_preop == '1' ? 'NA' : '' }}
                                    {{ @$pre_operative_checklist->past_surgical_history_preop == '2' ? 'Yes' : '' }}
                                    {{ @$pre_operative_checklist->past_surgical_history_preop == '3' ? 'No' : '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class=''>11</td>
                                <td class=''>Physician clearance</td>
                                <td>
                                    {{ @$pre_operative_checklist->physician_clearance_icu == '1' ? 'NA' : '' }}
                                    {{ @$pre_operative_checklist->physician_clearance_icu == '2' ? 'Yes' : '' }}
                                    {{ @$pre_operative_checklist->physician_clearance_icu == '3' ? 'No' : '' }}
                                </td>
                                <td>
                                    {{ @$pre_operative_checklist->physician_clearance_preop == '1' ? 'NA' : '' }}
                                    {{ @$pre_operative_checklist->physician_clearance_preop == '2' ? 'Yes' : '' }}
                                    {{ @$pre_operative_checklist->physician_clearance_preop == '3' ? 'No' : '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class=''>12</td>
                                <td class=''>
                                    <div style="display:flex" class="removeMargin">
                                        <p>Any implants</p>
                                        <p>{{ @$pre_operative_checklist->any_implants_site ? ': ' . $pre_operative_checklist->any_implants_site : '' }}
                                        </p>
                                    </div>
                                </td>
                                <td>
                                    {{ @$pre_operative_checklist->any_implants_icu == '1' ? 'NA' : '' }}
                                    {{ @$pre_operative_checklist->any_implants_icu == '2' ? 'Yes' : '' }}
                                    {{ @$pre_operative_checklist->any_implants_icu == '3' ? 'No' : '' }}
                                </td>
                                <td>
                                    {{ @$pre_operative_checklist->any_implants_preop == '1' ? 'NA' : '' }}
                                    {{ @$pre_operative_checklist->any_implants_preop == '2' ? 'Yes' : '' }}
                                    {{ @$pre_operative_checklist->any_implants_preop == '3' ? 'No' : '' }}

                                </td>
                            </tr>
                            <tr>
                                <td class=''>13</td>
                                <td class=''>Skin preparation done</td>
                                <td>
                                    {{ @$pre_operative_checklist->skin_preparation_icu == '1' ? 'NA' : '' }}
                                    {{ @$pre_operative_checklist->skin_preparation_icu == '2' ? 'Yes' : '' }}
                                    {{ @$pre_operative_checklist->skin_preparation_icu == '3' ? 'No' : '' }}
                                </td>
                                <td>
                                    {{ @$pre_operative_checklist->skin_preparation_preop == '1' ? 'NA' : '' }}
                                    {{ @$pre_operative_checklist->skin_preparation_preop == '2' ? 'Yes' : '' }}
                                    {{ @$pre_operative_checklist->skin_preparation_preop == '3' ? 'No' : '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class=''>14</td>
                                <td class=''>Bowel preparation</td>
                                <td>
                                    {{ @$pre_operative_checklist->bowel_preparation_icu == '1' ? 'NA' : '' }}
                                    {{ @$pre_operative_checklist->bowel_preparation_icu == '2' ? 'Yes' : '' }}
                                    {{ @$pre_operative_checklist->bowel_preparation_icu == '3' ? 'No' : '' }}
                                </td>
                                <td>
                                    {{ @$pre_operative_checklist->bowel_preparation_preop == '1' ? 'NA' : '' }}
                                    {{ @$pre_operative_checklist->bowel_preparation_preop == '2' ? 'Yes' : '' }}
                                    {{ @$pre_operative_checklist->bowel_preparation_preop == '3' ? 'No' : '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class=''>15</td>
                                <td class=''>Shower/Antisepic agent bath</td>
                                <td>
                                    {{ @$pre_operative_checklist->shower_anti_agent_bath_icu == '1' ? 'NA' : '' }}
                                    {{ @$pre_operative_checklist->shower_anti_agent_bath_icu == '2' ? 'Yes' : '' }}
                                    {{ @$pre_operative_checklist->shower_anti_agent_bath_icu == '3' ? 'No' : '' }}
                                </td>
                                <td>
                                    {{ @$pre_operative_checklist->shower_anti_agent_bath_preop == '1' ? 'NA' : '' }}
                                    {{ @$pre_operative_checklist->shower_anti_agent_bath_preop == '2' ? 'Yes' : '' }}
                                    {{ @$pre_operative_checklist->shower_anti_agent_bath_preop == '3' ? 'No' : '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class=''>16</td>
                                <td class=''>Nail cut short & polish removed</td>
                                <td>
                                    {{ @$pre_operative_checklist->nail_cut_short_polish_icu == '1' ? 'NA' : '' }}
                                    {{ @$pre_operative_checklist->nail_cut_short_polish_icu == '2' ? 'Yes' : '' }}
                                    {{ @$pre_operative_checklist->nail_cut_short_polish_icu == '3' ? 'No' : '' }}

                                </td>
                                <td>
                                    {{ @$pre_operative_checklist->nail_cut_short_polish_preop == '1' ? 'NA' : '' }}
                                    {{ @$pre_operative_checklist->nail_cut_short_polish_preop == '2' ? 'Yes' : '' }}
                                    {{ @$pre_operative_checklist->nail_cut_short_polish_preop == '3' ? 'No' : '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class=''>17</td>
                                <td class=''>
                                    <div style="display:flex" class="removeMargin">
                                        <p>NPO Date</p>
                                        <p style="margin-right: 5px">
                                            {{ @$pre_operative_checklist->npo_date ? ': ' . date('d-m-Y', strtotime($pre_operative_checklist->npo_date)) : '' }}
                                        </p>
                                        <p>NPO Date</p>
                                        @php  $npo_time = explode(" ", @$pre_operative_checklist->npo_time); @endphp
                                        <p>:
                                            @if (!empty(@$npo_time[1]))
                                                {{ date('h:i:s A', strtotime(@$npo_time[1])) }}
                                            @endif
                                        </p>
                                    </div>
                                </td>
                                <td>
                                    {{ @$pre_operative_checklist->npo_icu == '1' ? 'NA' : '' }}
                                    {{ @$pre_operative_checklist->npo_icu == '2' ? 'Yes' : '' }}
                                    {{ @$pre_operative_checklist->npo_icu == '3' ? 'No' : '' }}
                                </td>
                                <td>
                                    {{ @$pre_operative_checklist->npo_preop == '1' ? 'NA' : '' }}
                                    {{ @$pre_operative_checklist->npo_preop == '2' ? 'Yes' : '' }}
                                    {{ @$pre_operative_checklist->npo_preop == '3' ? 'No' : '' }}

                                </td>
                            </tr>
                            <tr>
                                <td class=''>18</td>
                                <td class=''>
                                    <div style="display:flex" class="removeMargin">
                                        <p>Patient on any medications</p>
                                        <p>{{ @$pre_operative_checklist->patient_medications_specify ? ': ' . $pre_operative_checklist->patient_medications_specify : '' }}
                                        </p>
                                    </div>

                                </td>
                                <td>
                                    {{ @$pre_operative_checklist->patient_medications_icu == '1' ? 'NA' : '' }}
                                    {{ @$pre_operative_checklist->patient_medications_icu == '2' ? 'Yes' : '' }}
                                    {{ @$pre_operative_checklist->patient_medications_icu == '3' ? 'No' : '' }}
                                </td>
                                <td>
                                    {{ @$pre_operative_checklist->patient_medications_preop == '1' ? 'NA' : '' }}
                                    {{ @$pre_operative_checklist->npo_preop == '2' ? 'Yes' : '' }}
                                    {{ @$pre_operative_checklist->npo_preop == '3' ? 'No' : '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class=''>19</td>
                                <td class=''>
                                    <div style="display:flex" class="removeMargin">
                                        <p>Pre-OP medication given</p>
                                        <p>{{ @$pre_operative_checklist->pre_op_medication_specify ? ': ' . $pre_operative_checklist->pre_op_medication_specify : '' }}
                                        </p>
                                    </div>
                                </td>
                                <td>
                                    {{ @$pre_operative_checklist->pre_op_medication_given_icu == '1' ? 'NA' : '' }}
                                    {{ @$pre_operative_checklist->pre_op_medication_given_icu == '2' ? 'Yes' : '' }}
                                    {{ @$pre_operative_checklist->pre_op_medication_given_icu == '3' ? 'No' : '' }}
                                </td>
                                <td>
                                    {{ @$pre_operative_checklist->pre_op_medication_given_preop == '1' ? 'NA' : '' }}
                                    {{ @$pre_operative_checklist->pre_op_medication_given_preop == '2' ? 'Yes' : '' }}
                                    {{ @$pre_operative_checklist->pre_op_medication_given_preop == '3' ? 'No' : '' }}

                                </td>
                            </tr>
                            <tr>
                                <td class=''>20</td>
                                <td class=''>
                                    <div style="display:flex" class="removeMargin">
                                        <p>Antibiotic Given</p>
                                        <p>{{ @$pre_operative_checklist->antibiotic_given_specify ? ': ' . $pre_operative_checklist->antibiotic_given_specify : '' }}
                                        </p>
                                    </div>

                                </td>
                                <td>
                                    {{ @$pre_operative_checklist->antibiotic_given_icu == '1' ? 'NA' : '' }}
                                    {{ @$pre_operative_checklist->antibiotic_given_icu == '2' ? 'Yes' : '' }}
                                    {{ @$pre_operative_checklist->antibiotic_given_icu == '3' ? 'No' : '' }}
                                </td>
                                <td>
                                    {{ @$pre_operative_checklist->antibiotic_given_preop == '1' ? 'NA' : '' }}
                                    {{ @$pre_operative_checklist->antibiotic_given_preop == '2' ? 'Yes' : '' }}
                                    {{ @$pre_operative_checklist->antibiotic_given_preop == '3' ? 'No' : '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class=''>21</td>
                                <td class=''>Hair tied in two plaits</td>
                                <td>
                                    {{ @$pre_operative_checklist->hair_tied_two_plaits_icu == '1' ? 'NA' : '' }}
                                    {{ @$pre_operative_checklist->hair_tied_two_plaits_icu == '2' ? 'Yes' : '' }}
                                    {{ @$pre_operative_checklist->hair_tied_two_plaits_icu == '3' ? 'No' : '' }}
                                </td>
                                <td>

                                    {{ @$pre_operative_checklist->hair_tied_two_plaits_preop == '1' ? 'NA' : '' }}
                                    {{ @$pre_operative_checklist->hair_tied_two_plaits_preop == '2' ? 'Yes' : '' }}
                                    {{ @$pre_operative_checklist->hair_tied_two_plaits_preop == '3' ? 'No' : '' }}

                                </td>
                            </tr>
                            <tr>
                                <td class=''>22</td>
                                <td class=''>Voided/Indwelling Catheter</td>
                                <td>
                                    {{ @$pre_operative_checklist->voided_indw_catheter_icu == '1' ? 'NA' : '' }}
                                    {{ @$pre_operative_checklist->voided_indw_catheter_icu == '2' ? 'Yes' : '' }}
                                    {{ @$pre_operative_checklist->voided_indw_catheter_icu == '3' ? 'No' : '' }}
                                </td>
                                <td>
                                    {{ @$pre_operative_checklist->voided_indw_catheter_preop == '1' ? 'NA' : '' }}
                                    {{ @$pre_operative_checklist->voided_indw_catheter_preop == '2' ? 'Yes' : '' }}
                                    {{ @$pre_operative_checklist->voided_indw_catheter_preop == '3' ? 'No' : '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class=''>23</td>
                                <td class=''>Skin Integrity Checked</td>
                                <td>
                                    {{ @$pre_operative_checklist->skin_integrity_checked_icu == '1' ? 'NA' : '' }}
                                    {{ @$pre_operative_checklist->skin_integrity_checked_icu == '2' ? 'Yes' : '' }}
                                    {{ @$pre_operative_checklist->skin_integrity_checked_icu == '3' ? 'No' : '' }}
                                </td>
                                <td>
                                    {{ @$pre_operative_checklist->skin_integrity_checked_preop == '1' ? 'NA' : '' }}
                                    {{ @$pre_operative_checklist->skin_integrity_checked_preop == '2' ? 'Yes' : '' }}
                                    {{ @$pre_operative_checklist->skin_integrity_checked_preop == '3' ? 'No' : '' }}

                                </td>
                            </tr>
                            <tr>
                                <td class=''>24</td>
                                <td class=''>Any belongings with patient</td>
                                <td>
                                    {{ @$pre_operative_checklist->any_belongings_patient_icu == '1' ? 'NA' : '' }}
                                    {{ @$pre_operative_checklist->any_belongings_patient_icu == '2' ? 'Yes' : '' }}
                                    {{ @$pre_operative_checklist->any_belongings_patient_icu == '3' ? 'No' : '' }}
                                </td>
                                <td>
                                    {{ @$pre_operative_checklist->any_belongings_patient_preop == '1' ? 'NA' : '' }}
                                    {{ @$pre_operative_checklist->any_belongings_patient_preop == '2' ? 'Yes' : '' }}
                                    {{ @$pre_operative_checklist->any_belongings_patient_preop == '3' ? 'No' : '' }}

                                </td>
                            </tr>
                            <tr>
                                <td class=''>25</td>
                                <td class=''>Jewellery removed</td>
                                <td>
                                    {{ @$pre_operative_checklist->jewelry_removed_icu == '1' ? 'NA' : '' }}
                                    {{ @$pre_operative_checklist->jewelry_removed_icu == '2' ? 'Yes' : '' }}
                                    {{ @$pre_operative_checklist->jewelry_removed_icu == '3' ? 'No' : '' }}
                                </td>
                                <td>

                                    {{ @$pre_operative_checklist->jewelry_removed_preop == '1' ? 'NA' : '' }}

                                    {{ @$pre_operative_checklist->jewelry_removed_preop == '2' ? 'Yes' : '' }}

                                    {{ @$pre_operative_checklist->jewelry_removed_preop == '3' ? 'No' : '' }}

                                </td>
                            </tr>
                            <tr>
                                <td class=''>26</td>
                                <td class=''>Dentures/ Loose Teeth /Contact Lens/Artifical Limbs
                                    Removed</td>
                                <td>
                                    {{ @$pre_operative_checklist->dentures_loose_tclalr_icu == '1' ? 'NA' : '' }}
                                    {{ @$pre_operative_checklist->dentures_loose_tclalr_icu == '2' ? 'Yes' : '' }}
                                    {{ @$pre_operative_checklist->dentures_loose_tclalr_icu == '3' ? 'No' : '' }}
                                </td>
                                <td>
                                    {{ @$pre_operative_checklist->dentures_loose_tclalr_preop == '1' ? 'NA' : '' }}

                                    {{ @$pre_operative_checklist->dentures_loose_tclalr_preop == '2' ? 'Yes' : '' }}

                                    {{ @$pre_operative_checklist->dentures_loose_tclalr_preop == '3' ? 'no' : '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class=''>27</td>
                                <td class=''>Under garments removed</td>
                                <td>
                                    {{ @$pre_operative_checklist->under_garments_removed_icu == '1' ? 'NA' : '' }}
                                    {{ @$pre_operative_checklist->under_garments_removed_icu == '2' ? 'Yes' : '' }}
                                    {{ @$pre_operative_checklist->under_garments_removed_icu == '3' ? 'No' : '' }}
                                </td>
                                <td>
                                    {{ @$pre_operative_checklist->under_garments_removed_preop == '1' ? 'NA' : '' }}

                                    {{ @$pre_operative_checklist->under_garments_removed_preop == '2' ? 'Yes' : '' }}

                                    {{ @$pre_operative_checklist->under_garments_removed_preop == '3' ? 'No' : '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class=''>28</td>
                                <td class=''>Hair pins removed</td>
                                <td>
                                    {{ @$pre_operative_checklist->under_garments_removed_preop == '1' ? 'NA' : '' }}
                                    {{ @$pre_operative_checklist->under_garments_removed_preop == '2' ? 'Yes' : '' }}
                                    {{ @$pre_operative_checklist->under_garments_removed_preop == '3' ? 'No' : '' }}
                                </td>
                                <td>
                                    {{ @$pre_operative_checklist->under_garments_removed_preop == '1' ? 'NA' : '' }}
                                    {{ @$pre_operative_checklist->under_garments_removed_preop == '2' ? 'Yes' : '' }}
                                    {{ @$pre_operative_checklist->under_garments_removed_preop == '3' ? 'No' : '' }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table width="100%" class="table table-bordered" style="margin-top: 20px;">
                        <tr>
                            <td class='' style="font-weight: bold">Sl#</td>
                            <td style="font-weight: bold">Investigation </td>
                            <td class="text-center" style="font-weight: bold">Checked in Ward/ICU</td>
                            <td class="text-center" style="font-weight: bold">Checked in Pre OP</td>
                            <td class="text-center" style="font-weight: bold">Received From OT</td>
                        </tr>
                        <tr>
                            <td class=''>1 </td>
                            <td class=''>Blood Investigation
                                CBC/PT/APTT/INR/LFT/TSH/Electrolyes /HbsAg/HCV/HIV/Cross Matching
                                /Urine R/E</td>
                            <td>
                                {{ @$pre_operative_checklist->blood_investigation_icu == '1' ? 'NA' : '' }}
                                {{ @$pre_operative_checklist->blood_investigation_icu == '2' ? 'Yes' : '' }}{{ @$pre_operative_checklist->blood_investigation_icu == '3' ? 'No' : '' }}
                            </td>
                            <td>
                                {{ @$pre_operative_checklist->blood_investigation_preop == '1' ? 'NA' : '' }}{{ @$pre_operative_checklist->blood_investigation_preop == '2' ? 'Yes' : '' }}{{ @$pre_operative_checklist->blood_investigation_preop == '3' ? 'no' : '' }}
                            </td>
                            <td>
                                {{ @$pre_operative_checklist->blood_investigation_rcvot }}
                            </td>
                        </tr>
                        <tr>
                            <td class=''>2 </td>
                            <td class=''>
                                <div style="display:flex" class="removeMargin">
                                    <p>Blood Components arranged No. of Units</p>
                                    <p>{{ @$pre_operative_checklist->blood_comp_unit_sepcify ? ': ' . $pre_operative_checklist->blood_comp_unit_sepcify : '' }}
                                    </p>
                                </div>

                            </td>
                            <td>
                                {{ @$pre_operative_checklist->blood_components_icu == '1' ? 'NA' : '' }}{{ @$pre_operative_checklist->blood_components_icu == '2' ? 'Yes' : '' }}{{ @$pre_operative_checklist->blood_components_icu == '3' ? 'No' : '' }}
                            </td>
                            <td>
                                {{ @$pre_operative_checklist->blood_components_preop == '1' ? 'NA' : '' }}{{ @$pre_operative_checklist->blood_components_preop == '2' ? 'Yes' : '' }}{{ @$pre_operative_checklist->blood_components_preop == '3' ? 'No' : '' }}
                            </td>
                            <td>
                                {{ @$pre_operative_checklist->blood_components_rcvot }}"
                            </td>
                        </tr>

                        <tr>
                            <td class=''>3</td>
                            <td class=''>Blood Group & Hb</td>
                            <td>
                                {{ @$pre_operative_checklist->blood_group_hb_icu == '1' ? 'NA' : '' }}{{ @$pre_operative_checklist->blood_group_hb_icu == '2' ? 'Yes' : '' }}{{ @$pre_operative_checklist->blood_group_hb_icu == '3' ? 'No' : '' }}
                            </td>
                            <td>
                                {{ @$pre_operative_checklist->blood_group_hb_preop == '1' ? 'NA' : '' }}
                                {{ @$pre_operative_checklist->blood_group_hb_preop == '2' ? 'Yes' : '' }}
                                {{ @$pre_operative_checklist->blood_group_hb_preop == '3' ? 'No' : '' }}
                            <td>
                                {{ @$pre_operative_checklist->blood_group_hb_rcvot }}
                            </td>
                        </tr>
                        <tr>
                            <td class=''>4 </td>
                            <td class=''>ECG</td>
                            <td>
                                {{ @$pre_operative_checklist->ecg_icu == '1' ? 'NA' : '' }}{{ @$pre_operative_checklist->ecg_icu == '2' ? 'Yes' : '' }}{{ @$pre_operative_checklist->ecg_icu == '3' ? 'No' : '' }}
                            </td>
                            <td>
                                {{ @$pre_operative_checklist->ecg_preop == '1' ? 'NA' : '' }}{{ @$pre_operative_checklist->ecg_preop == '2' ? 'Yes' : '' }}{{ @$pre_operative_checklist->ecg_preop == '3' ? 'No' : '' }}
                            </td>
                            <td>
                                {{ @$pre_operative_checklist->ecg_rcvot }}
                            </td>
                        </tr>
                        <tr>
                            <td class=''>5</td>
                            <td class=''>X-Ray with nos</td>
                            <td>
                                {{ @$pre_operative_checklist->xray_with_nos_icu == '1' ? 'NA' : '' }}{{ @$pre_operative_checklist->xray_with_nos_icu == '2' ? 'Yes' : '' }}{{ @$pre_operative_checklist->xray_with_nos_icu == '3' ? 'No' : '' }}
                            </td>
                            <td>
                                {{ @$pre_operative_checklist->xray_with_nos_preop == '1' ? 'NA' : '' }}{{ @$pre_operative_checklist->xray_with_nos_preop == '2' ? 'Yes' : '' }}{{ @$pre_operative_checklist->xray_with_nos_preop == '3' ? 'No' : '' }}
                            </td>
                            <td>
                                {{ @$pre_operative_checklist->xray_with_nos_rcvot }}
                            </td>
                        </tr>
                        <tr>
                            <td class=''>5</td>
                            <td class=''>CT scan/MRI/Ultrasound with nos</td>
                            <td>
                                {{ @$pre_operative_checklist->ctscan_mri_ultra_nos_icu == '1' ? 'NA' : '' }}{{ @$pre_operative_checklist->ctscan_mri_ultra_nos_icu == '2' ? 'Yes' : '' }}{{ @$pre_operative_checklist->ctscan_mri_ultra_nos_icu == '3' ? 'No' : '' }}
                            </td>
                            <td>
                                {{ @$pre_operative_checklist->ctscan_mri_ultra_nos_preop == '1' ? 'NA' : '' }}{{ @$pre_operative_checklist->ctscan_mri_ultra_nos_preop == '2' ? 'Yes' : '' }}{{ @$pre_operative_checklist->ctscan_mri_ultra_nos_preop == '3' ? 'No' : '' }}
                            </td>
                            <td>
                                {{ @$pre_operative_checklist->ctscan_mri_ultra_nos_rcvot }}
                            </td>
                        </tr>
                        <tr>
                            <td class=''>6</td>
                            <td class=''>ECHO /Doppler / PET/Angiogram /CD'S</td>
                            <td>
                                {{ @$pre_operative_checklist->echo_doppler_pet_cd_icu == '1' ? 'NA' : '' }}{{ @$pre_operative_checklist->echo_doppler_pet_cd_icu == '2' ? 'Yes' : '' }}{{ @$pre_operative_checklist->echo_doppler_pet_cd_icu == '3' ? 'No' : '' }}
                            </td>
                            <td>
                                {{ @$pre_operative_checklist->echo_doppler_pet_cd_preop == '1' ? 'NA' : '' }}{{ @$pre_operative_checklist->echo_doppler_pet_cd_preop == '2' ? 'Yes' : '' }}{{ @$pre_operative_checklist->echo_doppler_pet_cd_preop == '3' ? 'No' : '' }}
                            </td>
                            <td>
                                {{ @$pre_operative_checklist->echo_doppler_pet_cd_rcvot }}
                            </td>
                        </tr>
                    </table>
                    <table width="100%"class="table table-bordered" style="margin-top: 20px;">
                        <tr>
                            <th class="text-center" colspan="4">PRE- VITAL SIGNS</th>
                        </tr>
                        <tr>
                            <td class='text-center'colspan="2">WARD/ICU</td>
                            <td class='text-center' colspan="2">PRE OPERATIVE ROOM</td>
                        </tr>
                        <tr>

                            <td style="width:6%">Time</td>
                            <td style="width:44%">
                                @php  $icu_time = explode(" ", @$pre_operative_checklist->time_pre_vital_signs_icu); @endphp
                                @if (!empty(@$icu_time[1]))
                                    {{ date('h:i:s A', strtotime(@$icu_time[1])) }}
                                @endif
                            </td>

                            <td style="width:6%">Time</td>
                            <td style="width:44%">
                                @php  $por_time = explode(" ", @$pre_operative_checklist->time_pre_vital_signs_preop); @endphp
                                @if (!empty(@$por_time[1]))
                                    {{ date('h:i:s A', strtotime(@$por_time[1])) }}
                                @endif
                            </td>

                        </tr>
                        <tr>
                            <td>Temp</td>
                            <td>
                                <div class="d-flex justify-content-between">
                                    <div class="mr-2 w-100">
                                        {{ !empty(@$pre_operative_checklist->temp_pre_vital_signs_icu)
                                            ? $pre_operative_checklist->temp_pre_vital_signs_icu . ' F'
                                            : '' }}
                                    </div>
                                </div>
                            </td>
                            <td>Temp</td>
                            <td>
                                <div class="d-flex justify-content-between">
                                    <div class="mr-2 w-100">
                                        {{ !empty(@$pre_operative_checklist->temp_pre_vital_signs_preop) ? @$pre_operative_checklist->temp_pre_vital_signs_preop . ' F' : '' }}
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>

                            <td>Pulse</td>
                            <td>
                                <div class="d-flex justify-content-between">
                                    <div class="mr-2 w-100">
                                        {{ !empty(@$pre_operative_checklist->puls_pre_vital_signs_icu) ? $pre_operative_checklist->puls_pre_vital_signs_icu . '  /minute' : ' ' }}
                                    </div>
                            </td>


                            <td>Pulse</td>
                            <td>
                                <div class="d-flex justify-content-between">
                                    <div class="mr-2 w-100">
                                        {{ !empty(@$pre_operative_checklist->puls_pre_vital_signs_preop) ? $pre_operative_checklist->puls_pre_vital_signs_preop . ' /minute' : '' }}
                                    </div>
                                    <div>

                                    </div>
                                </div>
                            </td>

                        </tr>
                        <tr>

                            <td>Resp</td>
                            <td>
                                <div class="d-flex justify-content-between">
                                    <div class="mr-2 w-100">
                                        {{ !empty(@$pre_operative_checklist->resp_pre_vital_signs_icu) ? $pre_operative_checklist->resp_pre_vital_signs_icu . ' /minute' : '' }}
                                    </div>
                                </div>
                            </td>


                            <td>Resp</td>
                            <td>
                                <div class="d-flex justify-content-between">
                                    <div class="mr-2 w-100">
                                        {{ !empty(@$pre_operative_checklist->resp_pre_vital_signs_preop) ? $pre_operative_checklist->resp_pre_vital_signs_preop . '   /minute' : '' }}
                                    </div>
                                </div>
                            </td>

                        </tr>
                        <tr>

                            <td>BP</td>
                            <td>
                                <div class="d-flex justify-content-between">
                                    <div class="mr-2 w-100">
                                        {{ !empty(@$pre_operative_checklist->bp_pre_vital_signs_icu) ? $pre_operative_checklist->bp_pre_vital_signs_icu . '   /mm of Hg' : '' }}
                                    </div>
                                </div>
                            </td>


                            <td>BP</td>
                            <td>
                                <div class="d-flex justify-content-between">
                                    <div class="mr-2 w-100">
                                        {{ !empty(@$pre_operative_checklist->bp_pre_vital_signs_preop) ? $pre_operative_checklist->bp_pre_vital_signs_preop . '  /mm of Hg' : '' }}
                                    </div>
                                </div>
                            </td>

                        </tr>
                        <tr>

                            <td>SPO2</td>
                            <td>
                                <div class="d-flex justify-content-between">
                                    <div class="mr-2 w-100">
                                        {{ !empty(@$pre_operative_checklist->spo2_pre_vital_signs_icu) ? $pre_operative_checklist->spo2_pre_vital_signs_icu . ' %' : '' }}
                                    </div>
                                </div>
                            </td>


                            <td>SPO2</td>
                            <td>
                                <div class="d-flex justify-content-between">
                                    <div class="mr-2 w-100">
                                        {{ !empty(@$pre_operative_checklist->spo2_pre_vital_signs_preop) ? $pre_operative_checklist->spo2_pre_vital_signs_preop . ' %' : '' }}
                                    </div>
                                </div>
                            </td>

                        </tr>
                        <tr>
                            <td colspan="2">
                                <div style="display:flex; justify-content:space-start">
                                    <div class="" style="margin-right: 30px">Height:
                                        {{ @$pre_operative_checklist->height_pre_vital_icu }} cm</div>
                                    <div class="">Weight:
                                        {{ @$pre_operative_checklist->weight_pre_vital_icu }} kg</div>
                                </div>
                            </td>
                            <td colspan="2"></td>
                        </tr>
                    </table>

                    <table width="100%"class="table table-bordered" style="margin-top: 20px;">
                        <tr>
                            <th class="text-center" colspan="6">PATIENT, RECORDS &REPORTS
                                CHECKED /VERIFIED BY</th>
                        </tr>
                        <tr>
                            <td style="width:30%">Send From Ward /ICU RN</td>
                            <td>Received by Pre Op RN</td>
                            <td>Received by Circulating RN</td>
                            <td>Received By Recovery /ICU R/N</td>
                            <td>Received By Ward /ICU RN</td>
                            <td style="width:16%">Remarks</td>
                        </tr>
                        <tr>
                            <td>Name</td>
                            <td>
                                {{ @$pre_operative_checklist->empid_rcv_by_preop }}
                            </td>
                            <td>
                                {{ @$pre_operative_checklist->empid_rcv_by_circulating }}
                            </td>
                            <td>
                                {{ @$pre_operative_checklist->empid_rcv_by_recovery }}
                            </td>
                            <td>
                                {{ @$pre_operative_checklist->empid_rcv_by_ward_icu }}
                            </td>
                            <td rowspan="4">
                                {{ @$pre_operative_checklist->emp_remarks }}
                            </td>

                        </tr>
                        <tr>
                            <td>EMP ID </td>
                            <td>{{ @$pre_operative_checklist->empid_preop }}</td>
                            <td>{{ @$pre_operative_checklist->empid_circulating }}</td>
                            <td>{{ @$pre_operative_checklist->empid_recovery }}</td>
                            <td>{{ @$pre_operative_checklist->empid_ward }}</td>

                        </tr>
                        <tr>
                            <td>Sign</td>
                            <td>{{ @$pre_operative_checklist->empid_rcv_by_circulating }}</td>
                            <td>{{ @$pre_operative_checklist->empid_rcv_by_circulating }}</td>
                            <td>{{ @$pre_operative_checklist->empid_rcv_by_recovery }}</td>
                            <td>{{ @$pre_operative_checklist->empid_rcv_by_ward_icu }}</td>

                        </tr>
                        <tr>
                            @php
                                $time_rcv_by_preop = explode(' ', @$pre_operative_checklist->time_rcv_by_preop);
                                $time_rcv_by_circulating = explode(
                                    ' ',
                                    @$pre_operative_checklist->time_rcv_by_circulating,
                                );
                                $time_rcv_by_recovery = explode(' ', @$pre_operative_checklist->time_rcv_by_recovery);
                                $time_rcv_by_ward_icu = explode(' ', @$pre_operative_checklist->time_rcv_by_ward_icu);

                            @endphp
                            <td>Time</td>
                            <td>
                                @if (!empty(@$time_rcv_by_preop[1]))
                                    {{ date('h:i:s A', strtotime(@$time_rcv_by_preop[1])) }}
                                @endif
                            </td>
                            <td>
                                @if (!empty(@$time_rcv_by_circulating[1]))
                                    {{ date('h:i:s A', strtotime(@$time_rcv_by_circulating[1])) }}
                                @endif
                            </td>
                            <td>
                                @if (!empty(@$time_rcv_by_recovery[1]))
                                    {{ date('h:i:s A', strtotime(@$time_rcv_by_recovery[1])) }}
                                @endif
                            </td>
                            <td>
                                @if (!empty(@$time_rcv_by_ward_icu[1]))
                                    {{ date('h:i:s A', strtotime(@$time_rcv_by_ward_icu[1])) }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>Signature & Emp ID of Anaesthesia Technician </td>
                            <td>
                                {{ @$pre_operative_checklist->sign_emp_id_anes_technician }}
                            </td>
                            <td class="text-right">Remarks</td>
                            <td>
                                {{ @$pre_operative_checklist->anesthesia_technician_remarks }}
                            </td>
                            <td colspan="2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1"
                                        id="identity_confirmed" name="identity_confirmed"
                                        {{ @$pre_operative_checklist->pat_identity_confirmed_ind == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="identity_confirmed">
                                        Patient Identity Confirmed
                                    </label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="">Signature & Emp ID of Anaesthetist</td>
                            <td colspan="">
                                {{ @$pre_operative_checklist->sign_emp_id_anesthetist }}
                            </td>
                            <td class="text-right">Remarks</td>
                            <td colspan=""> {{ @$pre_operative_checklist->anesthetist_remarks }}</td>
                            <td colspan="2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="pac_reviewed"
                                        name="pac_reviewed"
                                        {{ @$pre_operative_checklist->pac_reviewed_ind == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="pac_reviewed">
                                        PAC Reviewed
                                    </label>
                                </div>
                            </td>
                        </tr>

                    </table>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>
