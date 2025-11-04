<!DOCTYPE html>
<html lang="bn">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- <title>Document</title> --}}


    <style>
        .border-left-0 {
            border-left: none !important;
        }

        .border-right-0 {
            border-right: none !important;
        }

        thead {
            background-color: white;
        }

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
                        <li><b>Consultant Name:</b>&nbsp;<span>{{ $admission_info->primary_doctor_name }}</span></li>
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
                        <span style="font-size: 16px;"><b>DOCTOR INITIAL ASSESSMENT AND PLAN OF CARE –
                                INPATIENT</b></span>
                    </div>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-left border-right-0" style="width:10%">Informant: </th>
                                <th colspan="4">{{ @$assessment_info->informant }}</th>
                                <th class="text-left border-left-0">Relation</th>
                                <th colspan="2" class="text-left border-left-0">
                                    @foreach ($relationAll as $key => $value)
                                        {{ @$assessment_info->relation == $key ? $value : '' }}
                                    @endforeach
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>

                                <td colspan="2" class="text-left"><strong>Bed Category</strong></td>
                                <td colspan="2">{{ @$patient_info->ward_name }}</td>
                                <td colspan="2" class="text-left"><strong>Date</strong></td>
                                <td colspan="2">{{ date('d/m/Y h:i:s A') }}</td>
                            </tr>

                            <tr>
                                <td class="text-left" colspan="3"><strong>Chief complaint/s and History of present
                                        illness:</strong>
                                </td>
                                <td colspan="5">{{ @$assessment_info->chief_complaint }}</td>
                            </tr>
                            <tr>
                                <td class="text-left" colspan="2"><strong>History:</strong></td>
                                <td colspan="6">{{ @$assessment_info->history }}</td>

                            </tr>

                            <tr>
                                <td class="text-center" colspan="8"><strong>PRE EXISTING ILLNESS / PAST MEDICAL &
                                        SURGICAL HISTORY</strong></td>
                            </tr>

                            <tr>
                                <td colspan="7">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="diabetes_ind"
                                            name="diabetes_ind" value="1"
                                            {{ @$assessment_info->diabetes_ind == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="diabetes_ind"><b>Diabetes</b></label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="heart_ind" name="heart_ind"
                                            value="1"
                                            {{ @$assessment_info->heart_disease_ind == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="heart_ind"><b>Heart Disease</b></label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="hight_bp_ind" value="1"
                                            name="hight_bp_ind"
                                            {{ @$assessment_info->high_bp_ind == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="hight_bp_ind"><b>High Blood
                                                Pressure</b></label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="tuberculosis_ind"
                                            value="1" name="tuberculosis_ind"
                                            {{ @$assessment_info->tuberculosis_ind == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label"
                                            for="tuberculosis_ind"><b>Tuberculosis</b></label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="others_ind" value="1"
                                            name="others_ind" onclick="others_ind()"
                                            {{ @$assessment_info->others_ind == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="others_ind"><b>Others
                                                (Specify):</b></label>
                                    </div>

                                </td>
                                <td>{{ @$assessment_info->other_remarks }}</td>
                            </tr>

                            <tr>
                                <td><strong>Family History</strong></td>
                                <td colspan="7">{{ @$assessment_info->family_history }}</td>
                            </tr>

                            <tr>
                                <td rowspan="2"><strong>Personal History: </strong></td>
                                <td rowspan="2"> {{ @$assessment_info->personal_history }}</td>
                                <td rowspan="2"><label for="">Occupation</label></td>
                                <td rowspan="2">{{ @$assessment_info->occupation }}</td>
                                <td class="text-left">Lifestyle :</td>
                                <td colspan="3" class="text-left">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="lifestyle_sedentary"
                                            name="lifestyle_sedentary" value="1"
                                            {{ @$assessment_info->sedentary_ind == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label"
                                            for="lifestyle_sedentary"><b>Sedentary</b></label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="lifestyle_active"
                                            name="lifestyle_active" value="1"
                                            {{ @$assessment_info->lifestyle_act == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="lifestyle_active"><b>Active</b></label>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td class="text-left">Habits</td>
                                <td colspan="3" class="text-left">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="habit_tobacco"
                                            name="habit_tobacco" value="1"
                                            {{ @$assessment_info->tobacco_ind == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="habit_tobacco"><b>Tobacco</b></label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="habit_alcohol"
                                            name="habit_alcohol" value="1"
                                            {{ @$assessment_info->alcohol_ind == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="habit_alcohol"><b>Alcohol</b></label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="habit_substance"
                                            name="habit_substance" value="1"
                                            {{ @$assessment_info->substance_abuse_ind == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="habit_substance"><b>Substance
                                                Abuse</b></label>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td rowspan="8" class="text-left"><strong>SCREENING</strong></td>
                                <td class="text-left">Hearing</td>
                                <td colspan="6" class="text-left">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="hearing_no_alteration"
                                            name="hearing_no_alteration" value="1"
                                            {{ @$assessment_info->hear_no_alteration_ind == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="hearing_no_alteration">No
                                            Alteration</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="hearing_if_alteration"
                                            name="hearing_if_alteration" value="1"
                                            {{ @$assessment_info->hear_alteration_ind == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="hearing_if_alteration">Alteration if
                                            hearing (Refer to ENT)</label>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td class="text-left">Vison</td>
                                <td colspan="6" class="text-left">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="vission_no_alteration"
                                            name="vission_no_alteration" value="1"
                                            {{ @$assessment_info->vison_no_alteration_ind == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="vission_no_alteration">No
                                            Alteration</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="vision_alteration"
                                            name="vision_alteration" value="1"
                                            {{ @$assessment_info->vison_alteration_ind == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="vision_alteration">Alteration in vision
                                            (Refer to Ophthalmologist)</label>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td class="text-left">Dental</td>
                                <td colspan="6" class="text-left">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="dental_info_ind"
                                            name="dental_info_ind" value="1"
                                            {{ @$assessment_info->dent_pain_ind == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="dental_info_ind">Pain/Caries/Poor Dental
                                            Hygiene (Refer to Dentist)</label>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td rowspan="2" class="text-left">Functional</td>
                                <td class="text-left">Ambulation:</td>
                                <td colspan="5" class="text-left">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="ambulation_independent"
                                            name="ambulation_independent" value="1"
                                            {{ @$assessment_info->amb_indentpendent_ind == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label"
                                            for="ambulation_independent">Independent</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="ambulation_assisted"
                                            name="ambulation_assisted" value="1"
                                            {{ @$assessment_info->amb_assisted_ind == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="ambulation_assisted">Assisted</label>
                                    </div>
                                </td>
                            </tr>


                            <tr>
                                <td class="text-left">Hand Function</td>

                                <td colspan="5" class="text-left">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="hand_independent"
                                            name="hand_independent" value="1"
                                            {{ @$assessment_info->hand_indentpendent_ind == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="hand_independent">Independent</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="hand_impaired"
                                            name="hand_impaired" value="1"
                                            {{ @$assessment_info->hand_assisted_ind == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="hand_impaired">Impaired</label>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td class="text-left" rowspan="3">Nutrition</td>
                                <td class="text-left">Evident loss or gain of weight (>10%)</td>
                                <td colspan="5" class="text-left">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" id="nutrition_yes"
                                            name="nutrition_yes" value="1"
                                            {{ @$assessment_info->nutrition_weight == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="nutrition_yes">Yes</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" id="nutrition_no"
                                            name="nutrition_yes" value="2"
                                            {{ @$assessment_info->nutrition_weight == 2 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="nutrition_no">No</label>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td class="text-left">Poor Oral Intake > 3days </td>
                                <td colspan="5" class="text-left">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" id="poor_oral_intake"
                                            name="poor_oral_intake" value="1"
                                            {{ @$assessment_info->nutrition_oral == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="poor_oral_intake">Yes</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" id="poor_oral_no"
                                            name="poor_oral_intake" value="2"
                                            {{ @$assessment_info->nutrition_oral == 2 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="poor_oral_no">No</label>
                                    </div>
                                </td>
                            </tr>


                            <tr>

                                <td class="text-left">Acute Disease in last 3 months </td>
                                <td colspan="5" class="text-left">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" id="accute_disease"
                                            name="accute_disease" value="1"
                                            {{ @$assessment_info->nutrition_acute == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="accute_disease">Yes</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" id="accute_no"
                                            name="accute_disease" value="2"
                                            {{ @$assessment_info->nutrition_acute == 2 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="accute_no">No</label>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td class="text-left" style="width:40%">
                                    <h4 class="py-0">KNOWN ALLERGIES AND DRUG SESSITIVITIES:</h4>
                                </td>
                                <td class="text-left">{{ @$patient_info->allergies_drug }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="w-25">Medicine/Surgical</th>
                                <th class="w-15">Route</th>
                                <th class="w-15">Frequency</th>
                                <th class="w-15">Duration</th>
                                <th class="w-8">Qty.</th>
                                <th class="w-16">Instruction</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($medicine_info as $keys => $item)
                                <tr class="border-0" id="tbl{{ $keys }}">
                                    <td class="text-left">
                                        {{ $item->brand_name }}
                                    </td>
                                    <td class="text-left">
                                        {{ $item->route }}
                                    </td>

                                    <td class="text-center">
                                        {{ $item->dosage }}
                                    </td>

                                    <td class="text-center">
                                        {{ $item->duration_mu }}
                                    </td>

                                    <td style="text-align: right">
                                        {{ $item->item_qty }}
                                    </td>

                                    <td class="text-left">
                                        @foreach ($instructions as $key => $dmu)
                                            {{ $item->instruction_take == $key ? $dmu['data'] : '' }}
                                        @endforeach
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-danger text-center">Your Cart is Empty</td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>

                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td class="text-left" colspan="3"><b>GENERAL EXAMINATION </b></td>
                                <td colspan="9">{{ @$assessment_info->general_examination }}</td>
                            </tr>

                            <tr>
                                <td class="text-left">Temp:</td>
                                <td class="text-left">{{ @$assessment_info->temp }} °F</td>

                                <td class="text-left">Pulse:</td>
                                <td class="text-left">{{ @$assessment_info->pulse }}/main</td>

                                <td class="text-left">BP:</td>
                                <td class="text-left">{{ @$assessment_info->bp }}/{{ @$assessment_info->bp_low }}
                                    mmHg</td>

                                <td class="text-left">RR:</td>
                                <td class="text-left">{{ @$assessment_info->rr }}/min</td>

                                <td class="text-left">Height:</td>
                                <td class="text-left">{{ @$assessment_info->height }} cm</td>

                                <td class="text-left">Weight:</td>
                                <td class="text-left">{{ @$assessment_info->weight }} kg</td>
                            </tr>


                            <tr>
                                <td class="text-center" colspan="12"><b>REVIEW OF SYSTEM</b></td>
                            </tr>

                            <tr>
                                <td colspan="4" class="text-center" style="width: 25%"><b>System</b></td>
                                <td colspan="4" class="text-center" style="width: 35%"><b>Symptoms</b></td>
                                <td colspan="4" class="text-center" style="width: 40%"><b>Physical Examination</b>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-left"><b>General</b></td>
                                <td colspan="4" class="text-left">General Fever/ chills/ sleep/ weight/ appetite
                                </td>
                                <td colspan="4" class="text-left">{{ @$assessment_info->general_symptoms }}</td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-left"><b>Skin</b></td>
                                <td colspan="4" class="text-left">Rash/color/ texture/ hair/ New moles/ lesion</td>
                                <td colspan="4" class="text-left">{{ @$assessment_info->skin_symptoms }}</td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-left"><b>Eyes</b></td>
                                <td colspan="4" class="text-left">Pain/ inflammation/ vision/ Diplopia/ glaucoma
                                </td>
                                <td colspan="4" class="text-left">{{ @$assessment_info->eyes_symptoms }}</td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-left"><b>ENT</b></td>
                                <td colspan="4" class="text-left">Pain/sore throat/ hearing/ discharge/ tinnitus/
                                    vertigo </td>
                                <td colspan="4" class="text-left">{{ @$assessment_info->ent_symptoms }}</td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-left"><b>Breasts</b></td>
                                <td colspan="4" class="text-left">Pain/masses/ Nipple discharge/ skin changes</td>
                                <td colspan="4" class="text-left">{{ @$assessment_info->breast_symptoms }}</td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-left"><b>Cardio Vascular/ Pulmonary</b></td>
                                <td colspan="4" class="text-left">Pain/ discomfort/ pressure/ Edema/ dyspnea/
                                    orthopnea/ Palpitations/ syncope/ Sputum/ cough/ hemoptysis</td>
                                <td colspan="4" class="text-left">{{ @$assessment_info->cardio_symptoms }}</td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-left"><b>Gastro Intestinal</b></td>
                                <td colspan="4" class="text-left">Pain/ constipation/ diarrhea/ dysphagia/ nausea/
                                    vomiting/ jaundice/ bleeding</td>
                                <td colspan="4" class="text-left">{{ @$assessment_info->gastrop_symptoms }}</td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-left"><b>Genito Urinary</b></td>
                                <td colspan="4" class="text-left">Dysuria/ discharge/ hesitancy/ Nocturia/
                                    retention/ bleeding/ stones/ infections/ STD’s/ incontinence/ impotence</td>
                                <td colspan="4" class="text-left">{{ @$assessment_info->genito_symptoms }}</td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-left"><b>Musculo-skeletal</b></td>
                                <td colspan="4" class="text-left">Pain/ stiffness/ swelling/ Joint/ inflammation
                                </td>
                                <td colspan="4" class="text-left">{{ @$assessment_info->musculo_symptoms }}</td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-left"><b>Neurological</b></td>
                                <td colspan="4" class="text-left">Neurological Headache/ seizures/ paralysis/
                                    weakness/ tremor/ gait/ sensation</td>
                                <td colspan="4" class="text-left">{{ @$assessment_info->neurological_symptoms }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-left"><b>Psychological</b></td>
                                <td colspan="4" class="text-left">At risk of self harm/ mood swings/ depression/
                                    anxiety/ memory</td>
                                <td colspan="4" class="text-left">{{ @$assessment_info->psychological_symptoms }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-left"><b>Endocrine</b></td>
                                <td colspan="4" class="text-left">Heat/cold intolerance/ weight change/ diabetes/
                                    goiter/ appetite/ thirst/ polyuria</td>
                                <td colspan="4" class="text-left">{{ @$assessment_info->endocrine_symptoms }}</td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-left"><b>Hemolymphatic</b></td>
                                <td colspan="4" class="text-left">Bruising/ enlargement/bleeding</td>
                                <td colspan="4" class="text-left">{{ @$assessment_info->hemolymphatic_symptoms }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-left"><b>Obstetrics & Gynecological</b></td>
                                <td colspan="4" class="text-left">Obstetrics & Gynecological Bleeding/ discharge/
                                    lesions/ Itching/ pelvic pain LMP Parity Birth Control Type used: </td>
                                <td colspan="4" class="text-left">{{ @$assessment_info->obs_symptoms }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td colspan="2" class="text-center"><b>SPECIALIZED ASSESSMENT OF HIGH RISK AND
                                        VULNERABLE PATIENTS WHEN APPLICABLE</b></td>
                            </tr>
                            <tr>
                                <td colspan="2" class="text-left">The patients requires special assessment being
                                    part of special population group?</td>
                            </tr>

                            <tr>
                                <td class="text-left border-right-0">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="frail_elderly"
                                            id="frail_elderly" value="1"
                                            {{ @$assessment_info->frail_elderly_ind == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="frail_elderly">Frail elderly</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="chronic_pain"
                                            id="chronic_pain" value="1"
                                            {{ @$assessment_info->chronic_pain_ind == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="chronic_pain">With intense or chronic
                                            pain</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="termination_pregnancy"
                                            id="termination_pregnancy" value="1"
                                            {{ @$assessment_info->exp_ter_pregnancy_ind == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="termination_pregnancy">Experiencing
                                            termination of pregnancy</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="substance_dependency"
                                            id="substance_dependency" value="1"
                                            {{ @$assessment_info->substance_ind == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="substance_dependency">Substance
                                            dependency</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="communicable_disease"
                                            id="communicable_disease" value="1"
                                            {{ @$assessment_info->comm_disease_ind == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="communicable_disease">With infectious or
                                            communicable disease</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="immunocompromised"
                                            id="immunocompromised" value="1"
                                            {{ @$assessment_info->immunocompromised_ind == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="immunocompromised">Immunocompromised
                                        </label>
                                    </div>
                                </td>
                                <td class="text-left ">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="terminally"
                                            id="terminally" value="1"
                                            {{ @$assessment_info->terminally_ill_ind == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="terminally">Terminally ill/dying
                                            patient</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="women_labour"
                                            id="women_labour" value="1"
                                            {{ @$assessment_info->woman_in_labor_ind == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="women_labour">Women in labor</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="emotional_disorder"
                                            id="emotional_disorder" value="1"
                                            {{ @$assessment_info->psychiiatric_ind == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="emotional_disorder">Patient with
                                            emotional or psychiatric disorder</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="victim_neglect"
                                            id="victim_neglect" value="1"
                                            {{ @$assessment_info->vic_abuse_ind == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="victim_neglect">Victims of abuse and
                                            neglect</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="radiation_therapy"
                                            id="radiation_therapy" value="1"
                                            {{ @$assessment_info->chemotherapy_ind == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="radiation_therapy">Chemotherapy or
                                            radiation therapy</label>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2" class="text-center"><b>ASSESSMENT NOTES (Investigation Results /
                                        Reference / Additional Notes)</b></td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    {{ @$assessment_info->assessment_notes }}
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td colspan="8" class="text-center"><b>POVISIONAL DIAGNOSIS / PROBLEM LIST</b></td>
                            </tr>
                            <tr>
                                <td colspan="8">
                                    {{ @$assessment_info->povisional_diagnosis }}
                                </td>
                            </tr>

                            <tr>
                                <td colspan="8" class="text-center"><b>INITIAL CARE PLAN</b></td>
                            </tr>

                            <tr>
                                <td colspan="4" class="text-center" style="width: 50%"><b>Problems</b></td>
                                <td colspan="4" class="text-center"><b>Measurable treatment goals</b></td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-center" style="width: 50%">
                                    {{ @$assessment_info->care_plan_problem }}
                                </td>
                                <td colspan="4" class="text-center">
                                    {{ @$assessment_info->care_plan_goals }}
                                </td>
                            </tr>

                            <tr>
                                <td colspan="3" class="text-left">
                                    Preventive aspects of care (diet, exercise, rehabilitation, curative, palliative
                                    care):
                                </td>
                                <td colspan="5">
                                    {{ @$assessment_info->preventive_aspects }}
                                </td>
                            </tr>

                            <tr>
                                <td colspan="3" class="text-left">
                                    Discharge plan
                                </td>

                                <td class="text-center">
                                    {{ @$assessment_info->discharge_ind == 1 ? 'Yes' : 'No' }}
                                </td>



                                <td colspan="4" class="text-left">
                                    {{ @$assessment_info->discharge_plan }}
                                </td>
                            </tr>

                            <tr>
                                <td colspan="3" class="text-left">
                                    Home Equipment anticipated
                                </td>

                                <td class="text-center">
                                    {{ @$assessment_info->home_equipment_ind == 1 ? 'Yes' : 'No' }}
                                </td>



                                <td colspan="4" class="text-left">
                                    {{ @$assessment_info->home_equipment_plan }}
                                </td>
                            </tr>

                            <tr>
                                <td colspan="3" class="text-left">
                                    Physiotherapy at home anticipated
                                </td>

                                <td class="text-center">
                                    {{ @$assessment_info->physiotheraphy_ind == 1 ? 'Yes' : 'No' }}
                                </td>

                                <td colspan="4" class="text-left">
                                    {{ @$assessment_info->physiotheraphy_plan }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-left">
                                    Wound Care need at home anticipated
                                </td>

                                <td class="text-center">
                                    {{ @$assessment_info->wound_care_ind == 1 ? 'Yes' : 'No' }}
                                </td>

                                <td colspan="3" class="text-left">
                                    {{ @$assessment_info->wound_care_plan }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-left">
                                    Social support need at home
                                </td>

                                <td class="text-center">
                                    {{ @$assessment_info->social_support_ind == 1 ? 'Yes' : 'No' }}
                                </td>

                                <td colspan="3" class="text-left">
                                    {{ @$assessment_info->social_support_plan }}
                                </td>
                            </tr>

                            <tr>
                                <td>Expected duration of stay: </td>
                                <td colspan="3">{{ @$assessment_info->expected_duration }}</td>
                                <td>Name, Sign & ID of the Doctor </td>
                                <td colspan="3">
                                    {{ @$assessment_info->doctor_signature_name }}
                                </td>
                            </tr>

                            <tr>
                                <td><b>Noted by</b></td>
                                <td><b>Nurse</b></td>
                                <td><b>Dietician</b></td>
                                <td colspan="5"><b>Others</b></td>
                            </tr>

                            <tr>
                                <td><b>Sign Id</b></td>
                                <td>
                                    {{ @$assessment_info->nurse_name }}
                                </td>

                                <td>
                                    {{ @$assessment_info->dietician_by_name }}
                                </td>
                                <td colspan="5">
                                    {{ @$assessment_info->others_emp_name }}
                                </td>

                            </tr>

                            <tr>
                                <td colspan="8" style="padding-top:0px;padding-bottom:0px">
                                    <p style="text-align: justify; padding:0px;margin:0px">
                                        I hereby affirm that all the information furnished by me in this document is
                                        true & correct to the best of my knowledge, belief and understanding. I shall
                                        assume complete liability and indemnify Unico Hospitals Plc and its associates
                                        against any action/ claim/ damage/ arising out of the above information. The
                                        treatment plan as indicated above relating to me/my relative (patient name &
                                        relationship) ………………………………………………………… has been explained to me in detail. I agree
                                        to the proposed treatment plan after fully understanding the same. <span
                                            style="font-size: 10px">আমি এতদ্বারা নিশ্চিত করছি যে এই নথিতে আমার দ্বারা
                                            প্রদত্ত সমস্ত তথ্য আমার জ্ঞান, বিশ্বাস এবং বোধগম্যতা অনুসারে সত্য এবং সঠিক।
                                            আমি সম্পূর্ণ দায়বদ্ধতা গ্রহণ করব এবং উপরোক্ত তথ্য থেকে উদ্ভূত যেকোনো
                                            পদক্ষেপ/দাবি/ক্ষতি/এর বিরুদ্ধে Unico Hospitals Plc এবং এর সহযোগীদের
                                            ক্ষতিপূরণ দেব। আমার/আমার আত্মীয় (রোগীর নাম ও সম্পর্ক)
                                            ………………………………………………………… সম্পর্কিত উপরে নির্দেশিত চিকিৎসা পরিকল্পনা আমাকে
                                            বিস্তারিতভাবে ব্যাখ্যা করা হয়েছে। আমি সম্পূর্ণরূপে বোঝার পরে প্রস্তাবিত
                                            চিকিত্সা পরিকল্পনার সাথে সম্মত।</span>
                                    </p>
                                </td>
                            </tr>


                            <tr>
                                <td colspan="3" class="text-left">
                                    Patient’s Name:
                                </td>
                                <td colspan="5">
                                    {{ @$patient_info->patient_name }}
                                </td>
                            </tr>

                            <tr>
                                <td colspan="3" class="text-left">
                                    Consultant’s Name:
                                </td>
                                <td colspan="5">
                                    {{ @$patient_info->primary_doctor_name }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-left">
                                    Surrogate Name:
                                </td>
                                <td colspan="5">
                                    {{ @$assessment_info->surrogate_name }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-left">
                                    Surrogate Relation:
                                </td>
                                <td colspan="5">
                                    {{ @$assessment_info->relation_surrogate }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>







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
