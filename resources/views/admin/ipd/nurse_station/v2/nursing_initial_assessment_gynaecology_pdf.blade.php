<!DOCTYPE html>
<html lang="bn">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Nurse Initial Assesment-Adult</title>


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
    </style>
</head>

<body onload="window.print()">

    <table class="table header">
        <thead>
            <tr>
                <td style="width:65%">
                    <ul style="list-style: none; padding-left: 0; display:inline-block;">
                        <li><b>IP
                                No:</b>&nbsp;<span>{{ isset($admission_info->admission_no_pk) ? $admission_info->admission_no_pk : '' }}</span>
                        </li>
                        <li><img style="" src="data:image/png;base64, {{ $invoice_barcode }} "></li>
                        <li><span><b>Name:</b>{{ isset($patient_info->patient_name) ? $patient_info->patient_name : '' }}</span>
                            &nbsp;<span><b>Age:</b>{{ isset($patient_info->age) ? $patient_info->age : '' }}</span>
                            &nbsp;<b>Gender:</b><span>{{ isset($patient_info->gender_txt) ? $patient_info->gender_txt : '' }}</span>
                            &nbsp;<b>Bed:</b>&nbsp;<span>{{ isset($admission_info->bed_name) ? $admission_info->bed_name : '' }}</span>
                        </li>
                        <li><b>Con. Number :</b>&nbsp;<span>{{ $patient_info->mobile1 }}</span></li>
                        <li><b>Consultant Name:</b>&nbsp;<span>{{ @$admission_info->primary_doctor_name }}</span></li>
                    </ul>
                </td>
                <td style="text-align:right;width:35%">
                    <ul style="list-style: none; padding-left: 0;">
                        <li><b>UHID:</b>&nbsp;<span>{{ isset($patient_info->patient_code) ? $patient_info->patient_code : '' }}</span>
                        </li>
                        <li><img style="" src="data:image/png;base64, {{ $pat_barcode }} "></li>
                        <li><b>Phone:</b>&nbsp;<span>{{ isset($patient_info->mobile1) ? $patient_info->mobile1 : '' }}</span>
                        </li>
                        <li><b>IP
                                Date:</b>&nbsp;<span>{{ date('d/m/Y h:i a', strtotime($admission_info->admission_date)) }}</span>
                        </li>
                        @if (!empty($admission_info->dis_datetime))
                            <li><b>Date of
                                    Discharge:</b>&nbsp;<span>{{ date('d/m/Y h:i a', strtotime($admission_info->dis_datetime)) }}</span>
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
                        <span style="font-size: 16px;"><b>NURSING INITIAL ASSESSMENT & CARE PLAN (OBSTETRICS AND
                                GYNAECOLOGY)</b></span>
                    </div>

                    <table class="table table-bordered">

                        <tbody>

                            <tr>
                                <th class="text-left" style="width:5%">Date: </th>
                                <th style="width:5%">
                                    {{ isset($assessment_info->assessment_date) ? substr($assessment_info->assessment_date, 0, 10) : '' }}
                                </th>
                                <th class="text-left" colspan="2" style="width:15%">Initiated at:</th>
                                <th class="text-left" style="width:10%">{{ @$assessment_info->initiated_at }}</th>
                                <th class="text-left" colspan="3" style="width:27%">How admitted</th>
                                <th class="text-left" colspan="2" style="width:20%">
                                    {{ @$assessment_info->admitted_type }}</th>
                                <th class="text-left" style="width:13%">Bystander present:</th>
                                <th class="text-left" style="width:5%">
                                    {{ @$assessment_info->bystander_present == 1 ? 'No' : 'Yes' }}</th>
                            </tr>

                            <tr>
                                <td colspan="6" class="text-left"><b>General condition:</b></td>
                                <td colspan="6">
                                    {{ @$assessment_info->general_condition == 1 ? 'CONSCIOUS' : '' }}
                                    {{ @$assessment_info->general_condition == 2 ? 'RESTLESSNESS' : '' }}
                                    {{ @$assessment_info->general_condition == 3 ? 'DISORIENTED' : '' }}
                                    {{ @$assessment_info->general_condition == 4 ? 'DROWSY' : '' }}
                                    {{ @$assessment_info->general_condition == 5 ? 'UNCONSCIOUS' : '' }}
                                    {{ @$assessment_info->general_condition == 6 ? 'OTHERS' : '' }}

                                </td>
                            </tr>

                            <tr>
                                <td colspan="3" class="text-left"><b>Respiratory Support:</b></td>
                                <td colspan="2">
                                    {{ @$assessment_info->room_airtype == 1 ? 'Room air' : '' }}
                                    {{ @$assessment_info->room_airtype == 2 ? 'O₂' : '' }}
                                    {{ @$assessment_info->room_airtype == 3 ? 'Tracheostomy' : '' }}
                                    {{ @$assessment_info->room_airtype == 4 ? 'BiPAP' : '' }}
                                    {{ @$assessment_info->room_airtype == 5 ? 'C-PAP' : '' }}
                                    {{ @$assessment_info->room_airtype == 6 ? 'Vent' : '' }}
                                </td>
                                <td class="text-left"><b>Mother tongue:</b></td>
                                <td colspan="2">
                                    {{ @$assessment_info->mother_tongue == 1 ? 'Bangla' : '' }}
                                    {{ @$assessment_info->mother_tongue == 2 ? 'English' : '' }}
                                    {{ @$assessment_info->mother_tongue == 3 ? 'Hindi' : '' }}
                                    {{ @$assessment_info->mother_tongue == 4 ? 'Others' : '' }}
                                </td>
                                <td class="text-left"><b>Can speak:</b></td>
                                <td colspan="3">
                                    {{ @$assessment_info->multi_language == 1 ? 'Bangla' : '' }}
                                    {{ @$assessment_info->multi_language == 2 ? 'English' : '' }}
                                    {{ @$assessment_info->multi_language == 3 ? 'Hindi' : '' }}
                                    {{ @$assessment_info->multi_language == 4 ? 'Others' : '' }}
                                </td>
                            </tr>

                            <tr>
                                <td class="text-left" colspan="3"><b>Presence of lines/tubes/drains: </b></td>
                                <td> {{ @$assessment_info->presence_type == 1 ? 'No' : 'Yes' }}</td>
                                <td class="text-left"><b>Specify</b></td>
                                <td>
                                    {{ @$assessment_info->presence_specify == 1 ? 'CV Line' : '' }}
                                    {{ @$assessment_info->presence_specify == 2 ? 'IV Cannula' : '' }}
                                    {{ @$assessment_info->presence_specify == 3 ? 'Folleyes Catheta' : '' }}
                                    {{ @$assessment_info->presence_specify == 4 ? 'ICD' : '' }}
                                    {{ @$assessment_info->presence_specify == 5 ? 'Ryles Tube' : '' }}
                                    {{ @$assessment_info->presence_specify == 6 ? 'Wound Drain' : '' }}
                                    {{ @$assessment_info->presence_specify == 7 ? 'Tracheostomy Tube' : '' }}
                                    {{ @$assessment_info->presence_specify == 8 ? 'Peg Tube' : '' }}
                                    {{ @$assessment_info->presence_specify == 9 ? 'Pig Line' : '' }}
                                <td>
                                <td class="text-left"><b>Height</b></td>
                                <td class="text-left">{{ @$assessment_info->height }}</td>
                                <td class="text-left">cm</td>
                                <td class="text-left"><b>Weight</b></td>
                                <td class="text-left" colspan="2">{{ @$assessment_info->weight }} kg</td>

                            </tr>


                            <tr>
                                <td class="text-left" colspan="4"><b>Any cultural/religious / special needs:</b></td>
                                <td class="text-left" colspan="2">{{ @$assessment_info->any_cultural }}</td>
                                <td colspan="6" class="text-left">
                                    <b>Allergies:</b>

                                    @if (@$assessment_info->allergies == 0)
                                        No
                                    @elseif(@$assessment_info->allergies == 1)
                                        Yes
                                        &nbsp;&nbsp;&nbsp;

                                        @switch(@$assessment_info->allerg)
                                            @case(1)
                                                Drug
                                            @break

                                            @case(2)
                                                Food
                                            @break

                                            @case(3)
                                                Skin
                                            @break

                                            @case(4)
                                                Dust
                                            @break

                                            @case(5)
                                                Pollen
                                            @break

                                            @case(6)
                                                Latex
                                            @break

                                            @case(7)
                                                Insect
                                            @break

                                            @case(8)
                                                Pet
                                            @break
                                        @endswitch
                                    @elseif(@$assessment_info->allergies == 2)
                                        Not Known
                                    @endif
                                </td>
                </td>
            </tr>


            <tr>
                <td class="text-left" colspan="1"><b>Temp:</b></td>
                <td class="text-left" colspan="1">
                    <div style="display: flex;justify-content:space-between">
                        <div>{{ @$assessment_info->temp }}</div>
                        <div>&deg;F</div>
                    </div>
                </td>
                <td class="text-left" colspan="1"><b>Pulse:</b></td>
                <td class="text-left" colspan="1">
                    <div style="display: flex;justify-content:space-between">
                        <div>{{ @$assessment_info->pulse }}</div>
                        <div>/mm</div>
                    </div>
                </td>
                <td class="text-left" colspan="1"><b>Resp:</b></td>
                <td class="text-left" colspan="1">
                    <div style="display: flex;justify-content:space-between">
                        <div>{{ @$assessment_info->resp }}</div>
                        <div>/min</div>
                    </div>
                </td>
                <td class="text-left" colspan="1"><b>BP:</b></td>
                <td class="text-left" colspan="1">
                    <div style="display: flex;justify-content:space-between">
                        <div>{{ @$assessment_info->bp_high }}</div>
                    </div>
                </td>
                <td class="text-left" colspan="2">
                    <div style="display: flex;justify-content:space-between">
                        <div>{{ @$assessment_info->bp_low }}</div>
                        <div>mmHg</div>
                    </div>
                </td>
                <td class="text-left" colspan="1"><b>SpO2:</b></td>
                <td class="text-left" colspan="1">
                    <div style="display: flex; justify-content:space-between">
                        <div>{{ @$assessment_info->spo2 }}</div>
                        <div>%</div>
                    </div>
                </td>
            </tr>

            <tr class="pain_mode_list">
                <td class="text-left" colspan="2"><b>Precipitating
                        Factor</b></td>
                <td class="text-left" colspan="2"><b>Type</b></td>
                <td class="text-left" colspan="2"><b>Location</b></td>
                <td class="text-left" colspan="2"><b>Pain Score</b></td>
                <td class="text-left" colspan="2"><b>Frequency</b></td>
                <td class="text-left" colspan="2"><b>Duration</b></td>
            </tr>


            <tr class="pain_mode_list">
                <td class="text-left" colspan="2">{{ @$assessment_info->pain_precipitating }}
                </td>
                <td class="text-left" colspan="2">{{ @$assessment_info->pain_type }}</td>
                <td class="text-left" colspan="2">{{ @$assessment_info->pain_location }}</td>
                <td class="text-left" colspan="2">{{ @$assessment_info->pain_score }}</td>
                <td class="text-left" colspan="2">
                    {{ @$assessment_info->pain_fequesncy == 1 ? 'Constant' : 'Intermittent' }}

                </td>
                <td class="text-left" colspan="2">{{ @$assessment_info->pain_duration }}</td>
            </tr>

            <tr>
                <td colspan="12" style="text-align: left"><b>OBSTETRICS
                        ASSESSMENT</b></td>
            </tr>

            <tr class="pain_mode_list">
                <td colspan="2" class="text-left">Age of menarche</td>
                <td colspan="2" class="text-left">{{ @$assessment_info->age_menarche }}</td>
                <td class="text-left">Menstrual cycle</td>
                <td colspan="2" class="text-left">
                    {{ @$assessment_info->menstrual_cycle == 1 ? 'Regular' : 'Irregular' }}


                </td>
                <td colspan="3" class="text-left">Age of Menopause</td>
                <td colspan="2" class="text-left">{{ @$assessment_info->age_menopause }}</td>

            </tr>
            <tr class="pain_mode_list">
                <td class="text-left" colspan="2">Obstetric score</td>
                <td class="text-left">
                    {{ @$assessment_info->obstetric_score == 1 ? 'G' : '' }}
                    {{ @$assessment_info->obstetric_score == 2 ? 'P' : '' }}
                    {{ @$assessment_info->obstetric_score == 3 ? 'A' : '' }}
                    {{ @$assessment_info->obstetric_score == 4 ? 'L' : '' }}

                </td>
                <td class="text-left">Gestational age:</td>
                <td colspan="2" class="text-left">{{ @$assessment_info->age_gestation }}</td>
                <td class="text-left">LMP:</td>
                <td colspan="2" class="text-left">{{ @$assessment_info->lmp }}</td>
                <td class="text-left">EDD:</td>
                <td colspan="3" class="text-left">{{ @$assessment_info->edd }}</td>

            </tr>
            <tr class="pain_mode_list">
                <td class="text-left">FHS:</td>
                <td class="text-left">{{ @$assessment_info->fhs }}</td>
                <td class="text-left">FM:</td>
                <td class="text-left">{{ @$assessment_info->fm }}</td>
                <td class="text-left">LCB:</td>
                <td class="text-left">{{ @$assessment_info->lcb }}</td>
                <td class="text-left">Previous LSCS</td>
                <td class="text-left">
                    {{ @$assessment_info->lscs }}
                </td>
                <td class="text-left">Pedal oedema</td>
                <td class="text-left">
                    {{ @$assessment_info->oedema }}>
                </td>
                <td class="text-left">Leaking</td>
                <td class="text-left">
                    {{ @$assessment_info->leaking }}
                </td>


            </tr>
            <tr class="pain_mode_list">

                <td class="text-left" colspan="2">Breast</td>
                <td class="text-left" colspan="2">
                    {{ @$assessment_info->breast == 1 ? 'Soft' : '' }}
                    {{ @$assessment_info->breast == 2 ? 'Edema' : '' }}
                    {{ @$assessment_info->breast == 3 ? 'Tender' : '' }}
                    {{ @$assessment_info->breast == 4 ? 'Discharge' : '' }}

                </td>
                <td class="text-left" colspan="2">Nipples</td>
                <td class="text-left" colspan="2">
                    {{ @$assessment_info->nipples == 1 ? 'Normal' : '' }}
                    {{ @$assessment_info->nipples == 2 ? 'Fiat' : '' }}
                    {{ @$assessment_info->nipples == 3 ? 'Inverted' : '' }}
                    {{ @$assessment_info->nipples == 4 ? 'Cracked' : '' }}

                </td>
                <td class="text-left" colspan="2">Vaginal discharge</td>
                <td class="text-left" colspan="2">
                    {{ @$assessment_info->vaginal == 1 ? 'Present' : 'Absent' }}

                </td>


            </tr>
            <tr class="pain_mode_list">
                <td colspan="6" class="text-left">Any complications in
                    previous pregnancy</td>
                <td colspan="6">{{ @$assessment_info->acipp }}</td>


            </tr>

            <tr>
                <td class="text-left" colspan="2"><b>Pain:</b></td>
                <td class="text-left" colspan="10">{{ @$assessment_info->pain_mode == 1 ? 'No' : 'Yes' }}</td>
            </tr>

            <tr>
                <td class="text-left" colspan="2"><b>Precipitating Factor</b></td>
                <td class="text-left" colspan="2"><b>Type</b></td>
                <td class="text-left" colspan="2"><b>Location</b></td>
                <td class="text-left" colspan="2"><b>Pain Score</b></td>
                <td class="text-left" colspan="2"><b>Fequency</b></td>
                <td class="text-left" colspan="2"><b>Duration</b></td>
            </tr>


            <tr>
                <td class="text-left" colspan="2">{{ @$assessment_info->pain_precipitating }}</td>
                <td class="text-left" colspan="2">{{ @$assessment_info->pain_type }}</td>
                <td class="text-left" colspan="2">{{ @$assessment_info->pain_location }}</td>
                <td class="text-left" colspan="2">{{ @$assessment_info->pain_score }}</td>
                <td class="text-left" colspan="2">
                    {{ @$assessment_info->pain_fequesncy == 1 ? 'Constant' : 'Intermittent' }}
                </td>
                <td class="text-left" colspan="2">{{ @$assessment_info->pain_duration }}</td>
            </tr>


            <tr>
                <td colspan="5" class="text-left custom-form">
                    <b>ORIENTATION ON FOLLOWING (Patient/Attendant)</b>
                </td>
                <td colspan="7">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="side_rails" value="1"
                            name="side_rails" {{ @$assessment_info->side_rails == 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="side_rails"><b>Side rails</b></label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="patients_rights" value="1"
                            name="patients_rights" {{ @$assessment_info->patients_rights == 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="patients_rights"><b>Patient rights of privecy and
                                confidentiality</b></label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="visitor_policy" value="1"
                            name="visitor_policy" {{ @$assessment_info->visitor_policy == 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="visitor_policy"><b>Visitor Policy:</b></label>
                    </div>
                </td>
            </tr>

            <tr>
                <td class="text-left" colspan="3"><b>Personal AIDS</b></td>
                <td class="text-left" colspan="2"><b>Dentures</b></td>
                <td>
                    {{ @$assessment_info->dentures == 1 ? 'No' : 'Yes' }}
                </td>
                <td class="text-left" colspan="2"><b>Eyewear</b></td>
                <td>
                    {{ @$assessment_info->eyewear == 1 ? 'No' : 'Yes' }}
                </td>
                <td class="text-left"><b>Hearing</b></td>
                <td colspan="2">
                    {{ @$assessment_info->hearing == 1 ? 'No' : 'Yes' }}
                </td>
            </tr>


            <tr>
                <td class="text-left" colspan="12"><b>VULNERABILITY
                        ASSESSMENT</b></td>

            </tr>

            <tr>
                <td class="text-left" colspan="8"><b>Parameters</b></td>
                <td class="text-left" colspan="4"><b>Yes/No</b></td>

            </tr>


            <tr>
                <td class="text-left" colspan="8">
                    {{ 'Children <16 yrs' }}</td>
                <td class="text-left" colspan="4">
                    <select name="children16" id="children16" class="custom-form">
                        <option value="1" {{ @$assessment_info->children16 == 1 ? 'selected' : '' }}>
                            No</option>
                        <option value="2" {{ @$assessment_info->children16 == 2 ? 'selected' : '' }}>
                            Yes</option>
                    </select>
                </td>

            </tr>

            <tr>
                <td class="text-left" colspan="8">Adolescent</td>
                <td class="text-left" colspan="4">
                    <select name="adolescent" id="adolescent" class="custom-form">
                        <option value="1" {{ @$assessment_info->adolescent == 1 ? 'selected' : '' }}>
                            No</option>
                        <option value="2" {{ @$assessment_info->adolescent == 2 ? 'selected' : '' }}>
                            Yes</option>
                    </select>
                </td>
            </tr>




            <tr>
                <td class="text-left" colspan="8">
                    {{ 'Elderly>65 years' }}</td>
                <td class="text-left" colspan="4">
                    <select name="elder65" id="elder65" class="custom-form">
                        <option value="1" {{ @$assessment_info->elder65 == 1 ? 'selected' : '' }}>
                            No</option>
                        <option value="2" {{ @$assessment_info->elder65 == 2 ? 'selected' : '' }}>
                            Yes</option>
                    </select>
                </td>

            </tr>

            <tr>
                <td class="text-left" colspan="8">Frail elderly</td>
                <td class="text-left" colspan="4">
                    <select name="frail_elderly" id="frail_elderly" class="custom-form">
                        <option value="1" {{ @$assessment_info->frail_elderly == 1 ? 'selected' : '' }}>
                            No</option>
                        <option value="2" {{ @$assessment_info->frail_elderly == 2 ? 'selected' : '' }}>
                            Yes</option>
                    </select>
                </td>
            </tr>



            <tr>
                <td class="text-left" colspan="8">
                    {{ 'Terminally ill/dying' }}</td>
                <td class="text-left" colspan="4">
                    <select name="terminally_ill" id="terminally_ill" class="custom-form">
                        <option value="1" {{ @$assessment_info->terminally_ill == 1 ? 'selected' : '' }}>
                            No</option>
                        <option value="2" {{ @$assessment_info->terminally_ill == 2 ? 'selected' : '' }}>
                            Yes</option>
                    </select>
                </td>

            </tr>

            <tr>
                <td class="text-left" colspan="8">Not able to do ADL</td>
                <td class="text-left" colspan="4">
                    <select name="adl" id="ADL" class="custom-form">
                        <option value="1" {{ @$assessment_info->adl == 1 ? 'selected' : '' }}>
                            No</option>
                        <option value="2" {{ @$assessment_info->adl == 2 ? 'selected' : '' }}>
                            Yes</option>
                    </select>
                </td>
            </tr>


            <tr>
                <td class="text-left" colspan="8">Intense or chronic pain
                </td>
                <td class="text-left" colspan="4">
                    <select name="intense_chronic_pain" id="intense_chronic_pain" class="custom-form">
                        <option value="1" {{ @$assessment_info->intense_chronic_pain == 1 ? 'selected' : '' }}>
                            No</option>
                        <option value="2" {{ @$assessment_info->intense_chronic_pain == 2 ? 'selected' : '' }}>
                            Yes</option>
                    </select>
                </td>

            </tr>



            <tr>
                <td class="text-left" colspan="8">Women in labour</td>
                <td class="text-left" colspan="4">
                    <select name="women_labour" id="women_labour" class="custom-form">
                        <option value="1" {{ @$assessment_info->women_labour == 1 ? 'selected' : '' }}>
                            No</option>
                        <option value="2" {{ @$assessment_info->women_labour == 2 ? 'selected' : '' }}>
                            Yes</option>
                    </select>
                </td>
            </tr>

            <tr>
                <td class="text-left" colspan="8">Women experiencing
                    terminations in pregnancy</td>
                <td class="text-left" colspan="4">
                    <select name="women_exp_ter_pregnancy" id="women_exp_ter_pregnancy" class="custom-form">
                        <option value="1"
                            {{ @$assessment_info->women_exp_ter_pregnancy == 1 ? 'selected' : '' }}>
                            No</option>
                        <option value="2"
                            {{ @$assessment_info->women_exp_ter_pregnancy == 2 ? 'selected' : '' }}>
                            Yes</option>
                    </select>
                </td>

            </tr>

            <tr>
                <td class="text-left" colspan="8">Emotional or psychiatric
                    disorders</td>
                <td class="text-left" colspan="4">
                    <select name="emotional_disorder" id="emotional_disorder" class="custom-form">
                        <option value="1" {{ @$assessment_info->emotional_disorder == 1 ? 'selected' : '' }}>
                            No</option>
                        <option value="2" {{ @$assessment_info->emotional_disorder == 2 ? 'selected' : '' }}>
                            Yes</option>
                    </select>
                </td>

            </tr>
            <tr>
                <td class="text-left" colspan="8">Suspected of drug and/or
                    alcohol dependency</td>
                <td class="text-left" colspan="4">
                    <select name="drug_dependency" id="drug_dependency" class="custom-form">
                        <option value="1" {{ @$assessment_info->drug_dependency == 1 ? 'selected' : '' }}>
                            No</option>
                        <option value="2" {{ @$assessment_info->drug_dependency == 2 ? 'selected' : '' }}>
                            Yes</option>
                    </select>
                </td>

            </tr>

            <tr>
                <td class="text-left" colspan="8">Victims of abuse or
                    neglect</td>
                <td class="text-left" colspan="4">
                    <select name="victim_neglect" id="victim_neglect" class="custom-form">
                        <option value="1" {{ @$assessment_info->victim_neglect == 1 ? 'selected' : '' }}>
                            No</option>
                        <option value="2" {{ @$assessment_info->victim_neglect == 2 ? 'selected' : '' }}>
                            Yes</option>
                    </select>
                </td>

            </tr>

            <tr>
                <td class="text-left" colspan="8">Infectious or
                    communicable diseases</td>
                <td class="text-left" colspan="4">
                    <select name="infectious_diseases" id="infectious_diseases" class="custom-form">
                        <option value="1" {{ @$assessment_info->infectious_diseases == 1 ? 'selected' : '' }}>
                            No</option>
                        <option value="2" {{ @$assessment_info->infectious_diseases == 2 ? 'selected' : '' }}>
                            Yes</option>
                    </select>
                </td>

            </tr>
            <tr>
                <td class="text-left" colspan="8">Receiving
                    chemotherapy or radiation therapy</td>
                <td class="text-left" colspan="4">
                    <select name="receiving_therapy" id="receiving_therapy" class="custom-form">
                        <option value="1" {{ @$assessment_info->receiving_therapy == 1 ? 'selected' : '' }}>
                            No</option>
                        <option value="2" {{ @$assessment_info->receiving_therapy == 2 ? 'selected' : '' }}>
                            Yes</option>
                    </select>
                </td>

            </tr>




            <tr>
                <td class="text-left" colspan="8">Immune systems are
                    compromised</td>
                <td class="text-left colspan="4"">
                    <select name="immune_compromised" id="immune_compromised" class="custom-form">
                        <option value="1" {{ @$assessment_info->immune_compromised == 1 ? 'selected' : '' }}>
                            No</option>
                        <option value="2" {{ @$assessment_info->immune_compromised == 2 ? 'selected' : '' }}>
                            Yes</option>
                    </select>
                </td>

            </tr>

            <tr>
                <td class="text-center" colspan="12"><b> Needs & Action</b></td>

            </tr>

            <tr>
                <td class="text-left" colspan="12">

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="provide_assistance" value="1"
                            name="provide_assistance"
                            {{ @$assessment_info->provide_assistance == 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="provide_assistance">Provide Assistance in
                            eating/ toileting/personal hygeiene/
                            mobilisation</label>
                    </div>

                </td>

            </tr>

            <tr>
                <td class="text-left" colspan="12">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="pain_management" value="1"
                            name="pain_management" {{ @$assessment_info->pain_management == 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="pain_management">Pain
                            Mangement</label>
                    </div>
                </td>




            </tr>

            <tr>
                <td class="text-left" colspan="12">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="safety_precaution" value="1"
                            name="safety_precaution"
                            {{ @$assessment_info->safety_precaution == 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="safety_precaution">Safety precaution</label>
                    </div>
                </td>
            </tr>

            <tr>
                <td class="text-left" colspan="12">

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="initiate_end_care" value="1"
                            name="initiate_end_care"
                            {{ @$assessment_info->initiate_end_care == 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="initiate_end_care">Initiate end of life
                            care</label>
                    </div>

                </td>

            </tr>



        </tbody>
    </table>

    <h5><b>HISTORY COLLECTION</b></h5>
    <table class="table table-bordered">

        <tbody>
            <tr>
                <td style="width:25%" class="text-left">Present complaints:</td>
                <td style="width:75%">{{ @$assessment_info->present_complaint }}</td>
            </tr>
            <tr>
                <td style="width:25%" class="text-left">Past medical history:</td>
                <td style="width:75%">{{ @$assessment_info->past_med_history }}</td>
            </tr>
            <tr>
                <td style="width:25%" class="text-left">Past surgical history:</td>
                <td style="width:75%">{{ @$assessment_info->past_surgical_history }}</td>
            </tr>
        </tbody>
    </table>

    <h5><b>SKIN INTEGRITY</b></h5>
    <table class="table table-bordered">
        <thead>
            <tr>
                <td class="text-left" style="15%">Skin intact:</td>
                <td style="5%">
                    {{ @$assessment_info->skin_intact == 1 ? 'No' : 'Yes' }}
                </td>
                <td style="25%">
                    Details with PUSH Score
                </td>
                <td style="width:55%">{{ @$assessment_info->skin_intact_details }}</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-left" style="15%">History of previous pressure injury:</td>
                <td style="5%">
                    {{ @$assessment_info->history_injury == 1 ? 'No' : 'Yes' }}
                </td>
                <td style="25%">
                    Pressure injury currently
                </td>
                <td style="width:55%">
                    {{ @$assessment_info->pressure_injury == 1 ? 'No' : 'Yes' }}
                </td>
            </tr>

            <tr>
                <td class="text-left" style="15%">Details:</td>
                <td colspan="3">
                    {{ @$assessment_info->pressure_injury_dtl }}
                </td>
            </tr>
            <tr>
                <td class="text-left" style="15%">Signature of relatives/bystander:</td>
                <td colspan="3">
                    {{ @$assessment_info->bystander_signature_name }}
                </td>
            </tr>

        </tbody>
    </table>
    </td>
    </tr>
    </tbody>
    </table> <br>
    <!-- 2nd page -->
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th style="width: 15%;border:none"></th>
                    <th style="width: 15%;border:none"></th>
                    <th style="width: 15%;border:none"></th>
                    <th style="width: 15%;border:none"></th>
                    <th style="width: 15%;border:none"></th>
                    <th style="width: 25%;border:none"></th>

                </tr>
                <tr>
                    <th colspan="5">MODIFIED BRADEN PRESSURE ULCER RISK ASSESSMENT SCALE</th>
                    <th>Time</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td class="text-left"><b>Sensory perception</b></td>
                    <td colspan="4">
                        {{ @$assessment_info->sensory_perception_value == 1 ? 'Completely limited' : '' }}
                        {{ @$assessment_info->sensory_perception_value == 2 ? 'Very limited' : '' }}
                        {{ @$assessment_info->sensory_perception_value == 3 ? 'Slightly limited' : '' }}
                        {{ @$assessment_info->sensory_perception_value == 4 ? 'No impairment' : '' }}
                    </td>
                    <td class="text-center">
                        {{ @$assessment_info->sensory_perception_value }}
                    </td>
                </tr>
                <tr>
                    <td class="text-left"><b>Moisture</b></td>
                    <td colspan="4">
                        {{ @$assessment_info->moisture_value == 1 ? 'Constantly moist' : '' }}
                        {{ @$assessment_info->moisture_value == 2 ? 'Often moist' : '' }}
                        {{ @$assessment_info->moisture_value == 3 ? 'Occasionally moist' : '' }}
                        {{ @$assessment_info->moisture_value == 4 ? 'Rarely moist' : '' }}
                    </td>
                    <td class="text-center">
                        {{ @$assessment_info->moisture_value }}
                    </td>
                </tr>
                <tr>
                    <td class="text-left"><b>Activity</b></td>
                    <td colspan="4">

                        {{ @$assessment_info->activity_value == 1 ? 'Bed fast' : '' }}
                        {{ @$assessment_info->activity_value == 2 ? 'Chair fast' : '' }}
                        {{ @$assessment_info->activity_value == 3 ? 'Walks Occasionally' : '' }}
                        {{ @$assessment_info->activity_value == 4 ? 'Walks frequently' : '' }}
                    </td>
                    <td class="text-center">
                        {{ @$assessment_info->activity_value }}
                    </td>
                </tr>
                <tr>
                    <td class="text-left"><b>Mobility</b></td>
                    <td colspan="4">
                        {{ @$assessment_info->mobility_value == 1 ? 'Completely limited' : '' }}
                        {{ @$assessment_info->mobility_value == 2 ? 'Very limited' : '' }}
                        {{ @$assessment_info->mobility_value == 3 ? 'Slightly limited' : '' }}
                        {{ @$assessment_info->mobility_value == 4 ? 'No limitation' : '' }}
                    </td>
                    <td class="text-center">
                        {{ @$assessment_info->mobility_value }}
                    </td>
                </tr>
                <tr>
                    <td class="text-left"><b>Nutrition</b></td>
                    <td colspan="4">
                        {{ @$assessment_info->nutrition_value == 1 ? 'Very poor' : '' }}
                        {{ @$assessment_info->nutrition_value == 2 ? 'Probably inadequate' : '' }}
                        {{ @$assessment_info->nutrition_value == 3 ? 'Adequate' : '' }}
                        {{ @$assessment_info->nutrition_value == 4 ? 'Excellent' : '' }}
                    </td>
                    <td class="text-center">
                        {{ @$assessment_info->nutrition_value }}
                    </td>
                </tr>
                <tr>
                    <td class="text-left"><b>Friction and shear</b></td>
                    <td colspan="4">
                        {{ @$assessment_info->friction_value == 1 ? 'Problem' : '' }}
                        {{ @$assessment_info->friction_value == 2 ? 'Potential problem' : '' }}
                        {{ @$assessment_info->friction_value == 3 ? 'No apparent problem' : '' }}
                    </td>
                    <td class="text-center">
                        {{ @$assessment_info->friction_value }}
                    </td>
                </tr>
                <tr>
                    <td colspan="5" class="text-right"><b>Total score</b></td>
                    <td class="text-center">
                        @php
                            $total_score =
                                @$assessment_info->sensory_perception_value +
                                @$assessment_info->moisture_value +
                                @$assessment_info->activity_value +
                                @$assessment_info->mobility_value +
                                @$assessment_info->nutrition_value +
                                @$assessment_info->friction_value;

                        @endphp
                        {{ @$total_score }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <td>Time</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td>None</td>
                    <td>Mild</td>
                    <td>Moderate</td>
                    <td>High</td>
                    <td>Severe</td>
                </tr>
                <tr>
                    <td>Risk Scale</td>
                    <td>23,22,21,20,19</td>
                    <td>18,17,16,15</td>
                    <td>14,13</td>
                    <td>12,11,10</td>
                    <td>9,8,7,6</td>
                </tr>
                <tr>
                    <td></td>
                    <td class="text-center">A</td>
                    <td class="text-center">B</td>
                    <td class="text-center">C(A+B)</td>
                    <td class="text-center">C(A+B)</td>
                    <td class="text-center">C(A+B)</td>
                </tr>

                <tr>
                    <td colspan="3" class="text-center"> <b>Plan of care for A</b></td>
                    <td colspan="3" class="text-center"> <b>Follow SKIN care bundle for B and C</b></td>
                </tr>




                @php
                    $plan_a = [23, 22, 21, 20, 19];
                    $plan_b = [17, 17, 16, 15, 14, 13, 12, 11, 10, 9, 8, 7, 6];
                    $planA = false;
                    $planB = false;
                    if (in_array($total_score, $plan_a)) {
                        $planA = true;
                        $planB = false;
                    } elseif (in_array($total_score, $plan_b)) {
                        $planA = false;
                        $planB = true;
                    }

                @endphp
                <tr>
                    <td colspan="3" style="width: 50%;padding:0px">
                        <div class="plan-a" style="@if ($planA == false) display: none @endif">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td style="width:70%;border-left:none;border-top:none" class="text-left">
                                            Educate patient and family</td>
                                        <td style="width:30%;border-right:none;border-top:none">
                                            {{ @$assessment_info->a_education }}</td>
                                    </tr>
                                    <tr>
                                        <td style="width:70%;border-left:none;" class="text-left">Evaluate the change
                                            of patient condition</td>
                                        <td style="width:30%;border-right:none;">{{ @$assessment_info->a_evalution }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:70%;border-left:none;border-bottom:none" class="text-left">
                                            Evaluate the skin condition</td>
                                        <td style="width:30%;border-right:none;border-bottom:none">
                                            {{ @$assessment_info->a_evalution_skin }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </td>
                    <td colspan="3" style="width: 50%;padding:0px">
                        <div class="plan-b" style="@if ($planB == false) display: none @endif">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td style="width:70%;border-top:none" class="text-left"><b>Surface:</b>
                                            Wringle free bed, appropriate pillows, Special mattress</td>
                                        <td style="width:30%">{{ @$assessment_info->bc_surface }}</td>
                                    </tr>
                                    <tr>
                                        <td style="width:70%;border-top:none" class="text-left"><b>Skin:</b> any
                                            device used, release the device and do the skin assessment</td>
                                        <td style="width:30%">{{ @$assessment_info->bc_skin }}</td>
                                    </tr>
                                    <tr>
                                        <td style="width:70%;border-top:none" class="text-left"><b>Keep moving:</b>
                                            mobilisation and 2hrly position change</td>
                                        <td style="width:30%">{{ @$assessment_info->bc_moving }}</td>
                                    </tr>
                                    <tr>
                                        <td style="width:70%;border-top:none" class="text-left"><b>In case of
                                                Incontinence:</b> keep skin neat and dry, barrier lotion applied, change
                                            soiled diaper/under pad immediately</td>
                                        <td style="width:30%">{{ @$assessment_info->bc_incontinence }}</td>
                                    </tr>
                                    <tr>
                                        <td style="width:70%;border-top:none" class="text-left">
                                            <b>Nutrition/hydration:</b> promote good nutrition and hydration of patient
                                        </td>
                                        <td style="width:30%">{{ @$assessment_info->bc_nutrition }}</td>
                                    </tr>
                                    <tr>
                                        <td style="width:70%;border-top:none" class="text-left">Educate patient and
                                            family daily</td>
                                        <td style="width:30%;border-bottom:none">{{ @$assessment_info->bc_educate }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </td>
                </tr>



            </thead>
        </table>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>

                <tr class="border-0">
                    <th>Time</th>
                    <th>Back Care</th>
                    <th>Position Change</th>
                    <th>Skin Condition</th>
                    <th>Time</th>
                    <th>Back Care</th>
                    <th>Position Change</th>
                </tr>
            </thead>
            @php
                $nc_time1_list = !empty($assessment_info->nc_time1)
                    ? json_decode($assessment_info->nc_time1, true)
                    : [];
                $nc_time1_list = array_map(function ($time) {
                    if (empty($time)) {
                        return null;
                    }
                    return date('h:i A', strtotime($time));
                }, $nc_time1_list);
                $nc_backcare1_list = !empty($assessment_info->nc_backcare1)
                    ? json_decode($assessment_info->nc_backcare1, true)
                    : [];
                $nc_pc1_list = !empty($assessment_info->nc_pc1) ? json_decode($assessment_info->nc_pc1, true) : [];
                $nc_skin_list = !empty($assessment_info->nc_skin) ? json_decode($assessment_info->nc_skin, true) : [];
                $nc_time2_list = !empty($assessment_info->nc_time2)
                    ? json_decode($assessment_info->nc_time2, true)
                    : [];
                $nc_time2_list = array_map(function ($time) {
                    if (empty($time)) {
                        return null;
                    }
                    return date('h:i A', strtotime($time));
                }, $nc_time2_list);

                $nc_backcare2_list = !empty($assessment_info->nc_backcare2)
                    ? json_decode($assessment_info->nc_backcare2, true)
                    : [];
                $nc_pc2_list = !empty($assessment_info->nc_pc2) ? json_decode($assessment_info->nc_pc2, true) : [];

                $all_empty =
                    empty($nc_time1_list) &&
                    empty($nc_backcare1_list) &&
                    empty($nc_pc1_list) &&
                    empty($nc_skin_list) &&
                    empty($nc_time2_list) &&
                    empty($nc_backcare2_list) &&
                    empty($nc_pc2_list);
            @endphp

            <tbody id="nursingCareBody">
                @if (!$all_empty)
                    @foreach ($nc_time1_list as $i => $time1)
                        <tr>
                            <td>{{ $time1 }}</td>
                            <td>{{ $nc_backcare1_list[$i] ?? '' }}</td>
                            <td>{{ $nc_pc1_list[$i] ?? '' }}</td>
                            <td>{{ $nc_skin_list[$i] ?? '' }}</td>
                            <td>{{ $nc_time2_list[$i] ?? '' }}</td>
                            <td>{{ $nc_backcare2_list[$i] ?? '' }}</td>
                            <td>{{ $nc_pc2_list[$i] ?? '' }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td style="text-align: center" colspan="7">No Data Found!</td>
                    </tr>
                @endif
            </tbody>
        </table> <br>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th colspan="4" style="text-align: center">SPECIAL NOTE
                        CONTINUED</th>
                </tr>
                <tr class="border-0">
                    <th style="text-align: center">
                        Time</th>
                    <th style="text-align: center">
                        Taken over form</th>
                    <th style="text-align: center">
                        Sign with ID</th>

                </tr>
            </thead>
            @php
                $sn_time_list = !empty($assessment_info->sn_time) ? json_decode($assessment_info->sn_time, true) : [];
                $sn_time_list = array_map(function ($time) {
                    if (empty($time)) {
                        return null;
                    }
                    return date('h:i A', strtotime($time));
                }, $sn_time_list);
                $sn_taken_list = !empty($assessment_info->sn_taken)
                    ? json_decode($assessment_info->sn_taken, true)
                    : [];
                $sn_signid_list = !empty($assessment_info->sn_signid)
                    ? json_decode($assessment_info->sn_signid, true)
                    : [];
            @endphp

            <tbody id="specialNoteBody">
                @if (!empty($sn_time_list))
                    @foreach ($sn_time_list as $i => $time)
                        <tr>
                            <td>
                                {{ $time }}
                            </td>
                            <td>
                                {{ $sn_taken_list[$i] ?? '' }}
                            </td>
                            <td>
                                {{ $sn_signid_list[$i] ?? '' }}
                            </td>

                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="3" style="text-align: center">No Data Found!</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>


    <section class="footer-table">
        @php
            $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
            $date = $dt->format('g:i A');
        @endphp

        <table style="width:100%" class="table">
            <tbody>
                <tr>
                    <td style="text-align:left;border:none;width:70%">Staff ID: {{ @$userInfo->user_code }}, Printing
                        Date & Time: {{ date('d/m/Y h:ia') }}</td>
                    <td style="text-align:right;border:none;width:30%">Powered By: NEXTGEN IT</td>
                </tr>
            </tbody>
        </table>
    </section>
</body>

</html>
