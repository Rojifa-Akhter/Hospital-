<!DOCTYPE html>
<html lang="bn">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <style>
        .border-left-0 { border-left: none !important; }
        .border-right-0 { border-right: none !important; }
        thead { background-color: white; }
        .fs-12 { font-size: 16px; }
        .table { border-collapse: collapse; width: 100%; }
        .table-bordered { border: 1px solid #333; }
        td { font-size: 16px; border: 1px solid #333; padding-right: 3px; }
        .form-check { position: relative; display: block; padding-left: 1.25rem; }
        .form-check-inline { display: inline-block !important; margin-right: 1rem; }
        .form-check-input { position: static; margin-top: 0.3rem; margin-left: -1.25rem; }
        .form-check-label { margin-bottom: 0px !important; }
        .w-16 { width: 16%; }
        .w-8 { width: 8%; }
        .w-15 { width: 15%; }
        .w-25 { width: 25%; }
        .text-left { text-align: left; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .header>tbody>tr>td, .header>thead>tr>td { border: none; }
        body { margin-bottom: 0.6cm; margin-left: 1cm; }
        .footer-table { position: bottom; bottom: 0px; width: 95%; margin-top: 10px; }
        td { page-break-inside: avoid }
    </style>
</head>

<body onload="window.print()">

    {{-- Header Section --}}
    <table class="table header">
        <thead>
            <tr>
                <td style="width:65%">
                    <ul style="list-style: none; padding-left: 0; display:inline-block;">
                        <li><b>IP No:</b> {{ $admission_info->admission_no_pk ?? '' }}</li>
                        <li><img src="data:image/png;base64, {{ $invoice_barcode ?? '' }}"></li>
                        <li>
                            <b>Name:</b> {{ $patient_info->patient_name ?? '' }} &nbsp;
                            <b>Age:</b> {{ $patient_info->age ?? '' }} &nbsp;
                            <b>Gender:</b> {{ $patient_info->gender_txt ?? '' }} &nbsp;
                            <b>Bed:</b> {{ $admission_info->bed_name ?? '' }}
                        </li>
                        <li><b>Con. Number:</b> {{ $patient_info->mobile1 ?? '' }}</li>
                        <li><b>Consultant Name:</b> {{ $admission_info->primary_doctor_name ?? '' }}</li>
                    </ul>
                </td>
                <td style="text-align:right;width:35%">
                    <ul style="list-style: none; padding-left: 0;">
                        <li><b>UHID:</b> {{ $patient_info->patient_code ?? '' }}</li>
                        <li><img src="data:image/png;base64, {{ $pat_barcode ?? '' }}"></li>
                        <li><b>Phone:</b> {{ $patient_info->mobile1 ?? '' }}</li>
                        <li><b>IP Date:</b> {{ date('d/m/Y h:i a', strtotime($admission_info->admission_date ?? now())) }}</li>
                        @if (!empty($admission_info->dis_datetime))
                            <li><b>Date of Discharge:</b> {{ date('d/m/Y h:i a', strtotime($admission_info->dis_datetime)) }}</li>
                        @endif
                    </ul>
                </td>
            </tr>
        </thead>
    </table>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th colspan="6" class="text-center">Initial Cardiac Assessment</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="2" style="width:25%;">
                    <b>Date:</b><br>
                    {{ $cardiac_assessment->initial_cardiac_date ? \Carbon\Carbon::parse($cardiac_assessment->initial_cardiac_date)->format('d/m/Y') : '' }}<br>
                    <b>LVEF:</b> {{ $cardiac_assessment->lvef ?? '' }}
                </td>

                <td colspan="2" style="width:25%;">
                    <b>Risk Factor:</b><br>
                    @php
                        $risk_factors = $cardiac_assessment->risk_factors ? explode(',', $cardiac_assessment->risk_factors) : [];
                    @endphp
                    @foreach(['CAD'=>'F/H of CAD','DM'=>'DM','Hypertension'=>'Hypertension','Dyslipidemia'=>'Dyslipidemia','Smoking'=>'Smoking','Personality'=>'Type A Personality','Obesity'=>'Obesity'] as $key => $label)
                        @if(in_array($key, $risk_factors))
                            ✔ {{ $label }}<br>
                        @endif
                    @endforeach
                </td>

                <td colspan="2" style="width:50%;">
                    <b>Drug & Food Allergies & Blood Transfusion:</b><br>
                    {{ $cardiac_assessment->allergies ?? '' }}<br>
                    <b>Medication Reconciliation (Advice):</b> {{ ucfirst($cardiac_assessment->medication_reconciliation ?? '') }}<br>
                    <b>Nutritional Screening (Advice):</b> {{ ucfirst($cardiac_assessment->nutritional_screening ?? '') }}
                </td>
            </tr>

            <tr>
                <td colspan="6">
                    <b>First Assessment Date:</b> {{ $cardiac_assessment->first_assess_date ? \Carbon\Carbon::parse($cardiac_assessment->first_assess_date)->format('d/m/Y') : '' }}
                    <b>Time:</b> {{ $cardiac_assessment->first_assess_time ?? '' }}<br><br>

                    Temp: {{ $cardiac_assessment->first_assess_temp ?? '' }} F &nbsp;
                    HR: {{ $cardiac_assessment->first_assess_hr ?? '' }} /min &nbsp;
                    BP: {{ $cardiac_assessment->first_assess_bp ?? '' }} mmHg<br><br>

                    Pain Score: {{ $cardiac_assessment->pain_score ?? '' }} &nbsp;
                    SPO2: {{ $cardiac_assessment->spo2 ?? '' }} % &nbsp;
                    Ht: {{ $cardiac_assessment->first_assess_ht ?? '' }} cm &nbsp;
                    Wt: {{ $cardiac_assessment->first_assess_wt ?? '' }} kg &nbsp;
                    BMI: {{ $cardiac_assessment->bmi ?? '' }}
                </td>
            </tr>

            <tr>
                <td colspan="6">
                    <b>Presenting complaints:</b><br>
                    {{ $cardiac_assessment->complaints ?? '' }}<br><br>

                    <b>Clinical notes:</b><br>
                    {{ $cardiac_assessment->clinical_notes ?? '' }}<br><br>

                    <b>Clinical Impression:</b><br>
                    {{ $cardiac_assessment->impression ?? '' }}<br><br>

                    <b>Advice/Plan of care:</b><br>
                    {{ $cardiac_assessment->plan ?? '' }}<br><br>

                    Doctor's name (in full): {{ $cardiac_assessment->doctor_name ?? '' }} &nbsp;
                    Signature: {{ $cardiac_assessment->doctor_signature ?? '' }}<br><br>

                    Consultants Counter Signature: {{ $cardiac_assessment->consultants_signature ?? '' }}
                </td>
            </tr>
        </tbody>
    </table>

    <table class="table table-bordered">
        <tbody>
            {{-- Present History --}}
            <tr>
                <td colspan="6">
                    <b>Present History:</b><br>
                    <b>Chest pain:</b> {{ ucfirst($cardiac_assessment->chest_pain ?? 'None') }}
                </td>
            </tr>

            {{-- Pain Condition --}}
            @php
                $pain_conditions = $cardiac_assessment->pain_condition ? explode(',', $cardiac_assessment->pain_condition) : [];
            @endphp
            <tr>
                <td colspan="2">Even at rest</td>
                <td colspan="2">{{ $cardiac_assessment->pain_input_rest ?? '' }}</td>
                <td colspan="2" rowspan="5" style="vertical-align: top;">
                    1. Relieved by rest<br>
                    2. Relieved by medication<br>
                    3. No relief<br>
                    4. Relieved by rest and medication<br>
                    5. Relieved by exertion
                </td>
            </tr>
            <tr>
                <td colspan="2">On exertion</td>
                <td colspan="2">{{ $cardiac_assessment->pain_input_exertion ?? '' }}</td>
            </tr>
            <tr>
                <td colspan="2">On emotion/exertion</td>
                <td colspan="2">{{ $cardiac_assessment->pain_input_emotion ?? '' }}</td>
            </tr>
            <tr>
                <td colspan="2">Following food intake</td>
                <td colspan="2">{{ $cardiac_assessment->pain_input_food ?? '' }}</td>
            </tr>
            <tr>
                <td colspan="2">Variable threshold</td>
                <td colspan="2">{{ $cardiac_assessment->pain_input_variable ?? '' }}</td>
            </tr>

            {{-- Pain elsewhere --}}
            <tr>
                <td colspan="6">
                    <b>Pain elsewhere (arm, shoulder, jaw):</b> {{ ucfirst($cardiac_assessment->pain_elsewhere ?? 'None') }}
                </td>
            </tr>

            @php
                $pain_elsewhere = $cardiac_assessment->pain_elsewhere_select ? explode(',', $cardiac_assessment->pain_elsewhere_select) : [];
            @endphp
            <tr>
                <td colspan="2">Even at rest</td>
                <td colspan="2">{{ $cardiac_assessment->even_at_rest ?? '' }}</td>
                <td colspan="2" rowspan="6" style="vertical-align: top;">
                    1. Relieved by rest<br>
                    2. Relieved by medication<br>
                    3. No relief<br>
                    4. Relieved by rest and medication<br>
                    5. Relieved by exertion
                </td>
            </tr>
            <tr>
                <td colspan="2">On exertion</td>
                <td colspan="2">{{ $cardiac_assessment->on_exertion ?? '' }}</td>
            </tr>
            <tr>
                <td colspan="2">Variable threshold</td>
                <td colspan="2">{{ $cardiac_assessment->variable_thershold ?? '' }}</td>
            </tr>
            <tr>
                <td colspan="2">Periodic</td>
                <td colspan="2">{{ $cardiac_assessment->periodic ?? '' }}</td>
            </tr>
            <tr>
                <td colspan="2">Following food intake</td>
                <td colspan="2">{{ $cardiac_assessment->following_food_intake ?? '' }}</td>
            </tr>
            <tr>
                <td colspan="6">
                    <b>Details about site, intensity, radiation, frequency:</b><br>
                    {{ $cardiac_assessment->site_intensity_radiation ?? '' }}
                </td>
            </tr>

            {{-- Breathlessness --}}
            <tr>
                <td colspan="6">
                    <b>Breathlessness:</b> {{ ucfirst($cardiac_assessment->breathlessness_selection ?? 'None') }}
                </td>
            </tr>

            @php
                $breathlessness = $cardiac_assessment->breathlessness_multiple ? explode(',', $cardiac_assessment->breathlessness_multiple) : [];
            @endphp
            <tr>
                <td colspan="2">Even at rest</td>
                <td colspan="2">{{ $cardiac_assessment->breathlessness_even_rest ?? '' }}</td>
                <td colspan="2" rowspan="6" style="vertical-align: top;">
                    1. Relieved by rest <br>
                    2. Relieved by medication<br>
                    3. No relief<br>
                    4. Relieved by rest and posture<br>
                    5. Relieved by lying in propped up position
                </td>
            </tr>
            <tr>
                <td colspan="2">On exertion</td>
                <td colspan="2">{{ $cardiac_assessment->breathlessness_on_exertion ?? '' }}</td>
            </tr>
            <tr>
                <td colspan="2">Variable threshold</td>
                <td colspan="2">{{ $cardiac_assessment->breathlessness_variable_thershold ?? '' }}</td>
            </tr>
            <tr>
                <td colspan="2">Periodic</td>
                <td colspan="2">{{ $cardiac_assessment->breathlessness_periodic ?? '' }}</td>
            </tr>
            <tr>
                <td colspan="2">Following food intake</td>
                <td colspan="2">{{ $cardiac_assessment->breathlessness_food_intake ?? '' }}</td>
            </tr>
            <tr>
                <td colspan="2">Only on lying</td>
                <td colspan="2">{{ $cardiac_assessment->breathlessness_only_lying ?? '' }}</td>
            </tr>
        </tbody>
    </table>

    <table class="table table-bordered">
        <tbody>
            {{-- Heaviness --}}
            <tr>
                <td colspan="6">
                    <b>Heaviness:</b> {{ ucfirst($cardiac_assessment->heaviness_selection ?? 'None') }}
                </td>
            </tr>

            @php
                $heaviness = $cardiac_assessment->heaviness_multiple ? explode(',', $cardiac_assessment->heaviness_multiple) : [];
            @endphp
            <tr>
                <td colspan="2">Even at rest</td>
                <td colspan="2">{{ $cardiac_assessment->heaviness_even_rest ?? '' }}</td>
                <td colspan="2" rowspan="6" style="vertical-align: top;">
                    1. Relieved by rest <br>
                    2. Relieved by medication<br>
                    3. No relief<br>
                    4. Relieved by rest and posture<br>
                    5. Relieved by exertion
                </td>
            </tr>
            <tr>
                <td colspan="2">On exertion</td>
                <td colspan="2">{{ $cardiac_assessment->heaviness_on_exertion ?? '' }}</td>
            </tr>
            <tr>
                <td colspan="2">Variable threshold</td>
                <td colspan="2">{{ $cardiac_assessment->heaviness_variable_th ?? '' }}</td>
            </tr>
            <tr>
                <td colspan="2">Periodic</td>
                <td colspan="2">{{ $cardiac_assessment->heaviness_periodic ?? '' }}</td>
            </tr>
            <tr>
                <td colspan="2">Following food intake</td>
                <td colspan="2">{{ $cardiac_assessment->heaviness_food_intake ?? '' }}</td>
            </tr>
            <tr>
                <td colspan="2">Only on lying</td>
                <td colspan="2">{{ $cardiac_assessment->heaviness_only_lying ?? '' }}</td>
            </tr>

            {{-- Choking --}}
            <tr>
                <td colspan="6">
                    <b>Choking:</b> {{ ucfirst($cardiac_assessment->chocking_selection ?? 'None') }}
                </td>
            </tr>

            @php
                $chocking = $cardiac_assessment->chocking_multiple ? explode(',', $cardiac_assessment->chocking_multiple) : [];
            @endphp
            <tr>
                <td colspan="2">Even at rest</td>
                <td colspan="2">{{ $cardiac_assessment->chocking_even_rest ?? '' }}</td>
                <td colspan="2" rowspan="6" style="vertical-align: top;">
                    1. Relieved by rest <br>
                    2. Relieved by medication<br>
                    3. No relief<br>
                    4. Relieved by change posture<br>
                    5. Relieved by exertion
                </td>
            </tr>
            <tr>
                <td colspan="2">On exertion</td>
                <td colspan="2">{{ $cardiac_assessment->chocking_on_exertion ?? '' }}</td>
            </tr>
            <tr>
                <td colspan="2">Variable threshold</td>
                <td colspan="2">{{ $cardiac_assessment->chocking_variable_th ?? '' }}</td>
            </tr>
            <tr>
                <td colspan="2">Periodic</td>
                <td colspan="2">{{ $cardiac_assessment->chocking_periodic ?? '' }}</td>
            </tr>
            <tr>
                <td colspan="2">Following food intake</td>
                <td colspan="2">{{ $cardiac_assessment->chocking_food_intake ?? '' }}</td>
            </tr>
            <tr>
                <td colspan="2">Only on lying</td>
                <td colspan="2">{{ $cardiac_assessment->chocking_only_lying ?? '' }}</td>
            </tr>

            {{-- Restlessness / Uneasiness --}}
            <tr>
                <td colspan="6">
                    <b>Restlessness / Uneasiness:</b> {{ ucfirst($cardiac_assessment->restlessness_selection ?? 'None') }}
                </td>
            </tr>

            @php
                $restlessness = $cardiac_assessment->restlessness_multiple ? explode(',', $cardiac_assessment->restlessness_multiple) : [];
            @endphp
            <tr>
                <td colspan="2">Even at rest</td>
                <td colspan="2">{{ $cardiac_assessment->restlessness_even_rest ?? '' }}</td>
                <td colspan="2" rowspan="7" style="vertical-align: top;">
                    1. Relieved by rest <br>
                    2. Relieved by medication<br>
                    3. No relief<br>
                    4. Relieved by change posture<br>
                    5. Relieved by lying in propped up position<br>
                    6. Relieved by antacid<br>
                    7. Relieved by belching
                </td>
            </tr>
            <tr>
                <td colspan="2">On exertion</td>
                <td colspan="2">{{ $cardiac_assessment->restlessness_on_exertion ?? '' }}</td>
            </tr>
            <tr>
                <td colspan="2">Variable threshold</td>
                <td colspan="2">{{ $cardiac_assessment->restlessness_variable_th ?? '' }}</td>
            </tr>
            <tr>
                <td colspan="2">Periodic</td>
                <td colspan="2">{{ $cardiac_assessment->restlessness_periodic ?? '' }}</td>
            </tr>
            <tr>
                <td colspan="2">Following food intake</td>
                <td colspan="2">{{ $cardiac_assessment->restlessness_food_intake ?? '' }}</td>
            </tr>
            <tr>
                <td colspan="2">Only on lying</td>
                <td colspan="2">{{ $cardiac_assessment->restlessness_only_lying ?? '' }}</td>
            </tr>
        </tbody>
    </table>

    <table class="table table-bordered">
        <tbody>
            {{-- Gidiness --}}
            <tr>
                <td colspan="6">
                    <b>Gidiness:</b> {{ ucfirst($cardiac_assessment->gidiness_selection ?? 'None') }}
                </td>
            </tr>

            <tr>
                <td colspan="2">Even at rest</td>
                <td colspan="2">{{ $cardiac_assessment->gidiness_even_rest ?? '' }}</td>
                <td colspan="2" rowspan="8" style="vertical-align: top;">
                    1. Relieved by rest <br>
                    2. Relieved by medication <br>
                    3. No relief
                </td>
            </tr>
            <tr>
                <td colspan="2">Aggravated by exertion</td>
                <td colspan="2">{{ $cardiac_assessment->aggravated_by_exertion ?? '' }}</td>
            </tr>
            <tr>
                <td colspan="2">Variable threshold</td>
                <td colspan="2">{{ $cardiac_assessment->gidiness_variable_th ?? '' }}</td>
            </tr>
            <tr>
                <td colspan="2">Periodic</td>
                <td colspan="2">{{ $cardiac_assessment->gidiness_periodic ?? '' }}</td>
            </tr>
            <tr>
                <td colspan="2">Following food intake</td>
                <td colspan="2">{{ $cardiac_assessment->gidiness_food_intake ?? '' }}</td>
            </tr>
            <tr>
                <td colspan="2">Triggered by changing position from sitting/lying to upright</td>
                <td colspan="2">{{ $cardiac_assessment->lying_to_upright ?? '' }}</td>
            </tr>
            <tr>
                <td colspan="2">Triggered by acute extension of head</td>
                <td colspan="2">{{ $cardiac_assessment->acute_extension_head ?? '' }}</td>
            </tr>
            <tr>
                <td colspan="2">Triggered by sideways movement of head</td>
                <td colspan="2">{{ $cardiac_assessment->sideways_movement_head ?? '' }}</td>
            </tr>

            {{-- Presyncope / Syncope --}}
            <tr>
                <td colspan="6">
                    <b>Presyncope/Syncope:</b> {{ ucfirst($cardiac_assessment->presyncpe_selection ?? 'None') }}
                </td>
            </tr>

            <tr>
                <td colspan="2">Even at rest</td>
                <td colspan="2">{{ $cardiac_assessment->presyncpe_even_rest ?? '' }}</td>
                <td colspan="2" rowspan="8" style="vertical-align: top;">
                    1. Relieved by rest <br>
                    2. Relieved by medication <br>
                    3. No relief
                </td>
            </tr>
            <tr>
                <td colspan="2">Aggravated by exertion</td>
                <td colspan="2">{{ $cardiac_assessment->presyncpe_aggravated_exertion ?? '' }}</td>
            </tr>
            <tr>
                <td colspan="2">Variable threshold</td>
                <td colspan="2">{{ $cardiac_assessment->presyncpe_variable_threshold ?? '' }}</td>
            </tr>
            <tr>
                <td colspan="2">Periodic</td>
                <td colspan="2">{{ $cardiac_assessment->presyncpe_periodic ?? '' }}</td>
            </tr>
            <tr>
                <td colspan="2">Following food intake</td>
                <td colspan="2">{{ $cardiac_assessment->presyncpe_food_intake ?? '' }}</td>
            </tr>
            <tr>
                <td colspan="2">Triggered by changing position from sitting/lying to upright</td>
                <td colspan="2">{{ $cardiac_assessment->presyncpe_lying_upright ?? '' }}</td>
            </tr>
            <tr>
                <td colspan="2">Triggered by acute extension of head</td>
                <td colspan="2">{{ $cardiac_assessment->presyncpe_extension_head ?? '' }}</td>
            </tr>
            <tr>
                <td colspan="2">Triggered by sideways movement of head</td>
                <td colspan="2">{{ $cardiac_assessment->presyncpe_movement_head ?? '' }}</td>
            </tr>

            {{-- Sweating --}}
            <tr>
                <td colspan="6">
                    <b>Sweating:</b> {{ ucfirst($cardiac_assessment->sweating_selection ?? 'None') }}
                </td>
            </tr>

            <tr>
                <td colspan="2">Even at rest</td>
                <td colspan="2">{{ $cardiac_assessment->sweating_even_rest ?? '' }}</td>
                <td colspan="2" rowspan="5" style="vertical-align: top;">
                    1. Relieved by rest <br>
                    2. Relieved by medication <br>
                    3. No relief
                </td>
            </tr>
            <tr>
                <td colspan="2">Aggravated by exertion</td>
                <td colspan="2">{{ $cardiac_assessment->sweating_aggravated_exertion ?? '' }}</td>
            </tr>
            <tr>
                <td colspan="2">Spontaneous</td>
                <td colspan="2">{{ $cardiac_assessment->sweating_spontaneous ?? '' }}</td>
            </tr>
            <tr>
                <td colspan="2">Periodic</td>
                <td colspan="2">{{ $cardiac_assessment->sweating_periodic ?? '' }}</td>
            </tr>
            <tr>
                <td colspan="2">Following food intake</td>
                <td colspan="2">{{ $cardiac_assessment->sweating_food_intake ?? '' }}</td>
            </tr>
        </tbody>
    </table>

    <table class="table table-bordered">
        <tbody>
            {{-- Palpitation --}}
            <tr>
                <td colspan="6">
                    <b>Palpitation:</b> {{ ucfirst($cardiac_assessment->palpitation_selection ?? 'None') }}
                </td>
            </tr>

            <tr>
                <td colspan="2">Even at rest</td>
                <td colspan="2">{{ $cardiac_assessment->palpitation_even_rest ?? '' }}</td>
                <td colspan="2" rowspan="6" style="vertical-align: top;">
                    1. Relieved by rest <br>
                    2. Relieved by medication <br>
                    3. No relief
                </td>
            </tr>
            <tr>
                <td colspan="2">Aggravated by exertion</td>
                <td colspan="2">{{ $cardiac_assessment->palpitation_aggravated_exertion ?? '' }}</td>
            </tr>
            <tr>
                <td colspan="2">Variable threshold</td>
                <td colspan="2">{{ $cardiac_assessment->palpitation_variable_threshold ?? '' }}</td>
            </tr>
            <tr>
                <td colspan="2">Periodic</td>
                <td colspan="2">{{ $cardiac_assessment->palpitation_periodic ?? '' }}</td>
            </tr>
            <tr>
                <td colspan="2">On food intake</td>
                <td colspan="2">{{ $cardiac_assessment->palpitation_food_intake ?? '' }}</td>
            </tr>
            <tr>
                <td colspan="2">Emotion</td>
                <td colspan="2">{{ $cardiac_assessment->palpitation_emotion ?? '' }}</td>
            </tr>

            {{-- Coughing --}}
            <tr>
                <td colspan="6">
                    <b>Coughing:</b> {{ ucfirst($cardiac_assessment->coughing_selection ?? 'None') }}
                </td>
            </tr>

            <tr>
                <td colspan="2">Persistent</td>
                <td colspan="2">{{ $cardiac_assessment->coughing_persistent ?? '' }}</td>
                <td colspan="2" rowspan="6" style="vertical-align: top;">
                    1. Relieved by change in position <br>
                    2. Associated with mucoid expectoration <br>
                    3. Associated with mucopurulent expectoration <br>
                    4. Bloody expectoration <br>
                    5. No expectoration
                </td>
            </tr>
            <tr>
                <td colspan="2">Mostly during daytime</td>
                <td colspan="2">{{ $cardiac_assessment->coughing_daytime ?? '' }}</td>
            </tr>
            <tr>
                <td colspan="2">Mostly during night-time</td>
                <td colspan="2">{{ $cardiac_assessment->coughing_night_time ?? '' }}</td>
            </tr>
            <tr>
                <td colspan="2">Variable</td>
                <td colspan="2">{{ $cardiac_assessment->coughing_variable ?? '' }}</td>
            </tr>
            <tr>
                <td colspan="2">Spasmodic attack</td>
                <td colspan="2">{{ $cardiac_assessment->coughing_spasmodic_attack ?? '' }}</td>
            </tr>
            <tr>
                <td colspan="2">More in lying position</td>
                <td colspan="2">{{ $cardiac_assessment->coughing_lying_position ?? '' }}</td>
            </tr>

            {{-- Gastric upset / Eruction / Bleching --}}
            <tr>
                <td colspan="6">
                    <b>Gastric upset / Eruction / Bleching:</b> {{ ucfirst($cardiac_assessment->gastric_selection ?? 'None') }}
                </td>
            </tr>

            <tr>
                <td colspan="2">No specific aggravating factor</td>
                <td colspan="2">{{ $cardiac_assessment->gastric_no_specific ?? '' }}</td>
                <td colspan="2" rowspan="2" style="vertical-align: top;">
                    1. Relieved by antacid
                </td>
            </tr>
            <tr>
                <td colspan="2">Triggered by spicy food</td>
                <td colspan="2">{{ $cardiac_assessment->gastric_spicy_food ?? '' }}</td>
            </tr>
        </tbody>
    </table>

    <table class="table table-bordered">
        <tbody>
            {{-- Anasarca / Ankle swelling --}}
            <tr>
                <td colspan="6">
                    <b>Anasarca / Ankle swelling:</b> {{ ucfirst($cardiac_assessment->anasarca_selection ?? 'None') }}
                </td>
            </tr>
            <tr>
                <td colspan="2">Sudden onset</td>
                <td colspan="2">{{ $cardiac_assessment->anasarca_sudden_onset ?? '' }}</td>
                <td colspan="2" rowspan="3" style="vertical-align: top;">
                    1. Relieved by position <br>
                    2. Relieved by diuretics <br>
                    3. Relieved by stockings
                </td>
            </tr>
            <tr>
                <td colspan="2">Gradual onset</td>
                <td colspan="2">{{ $cardiac_assessment->anasarca_gradual_onset ?? '' }}</td>
            </tr>
            <tr>
                <td colspan="2">Aggravated by gravity</td>
                <td colspan="2">{{ $cardiac_assessment->anasarca_aggravated_gravity ?? '' }}</td>
            </tr>

            {{-- Swelling / Fluid in the abdomen --}}
            <tr>
                <td colspan="6">
                    <b>Swelling / Fluid in the abdomen:</b> {{ ucfirst($cardiac_assessment->swelling_selection ?? 'None') }}
                </td>
            </tr>
            <tr>
                <td colspan="2">Sudden onset</td>
                <td colspan="2">{{ $cardiac_assessment->swelling_sudden_onset ?? '' }}</td>
                <td colspan="2" rowspan="2" style="vertical-align: top;">
                    1. Relieved by position <br>
                    2. Relieved by diuretics
                </td>
            </tr>
            <tr>
                <td colspan="2">Gradual onset</td>
                <td colspan="2">{{ $cardiac_assessment->swelling_gradual_onset ?? '' }}</td>
            </tr>

            {{-- Fever --}}
            <tr>
                <td colspan="6">
                    <b>Fever:</b> {{ ucfirst($cardiac_assessment->fever_selection ?? 'None') }}
                </td>
            </tr>
            <tr>
                <td colspan="2">Continued</td>
                <td colspan="2">{{ $cardiac_assessment->fever_continued ?? '' }}</td>
                <td colspan="2" rowspan="3" style="vertical-align: top;">
                    1. Spontaneous returned to normal <br>
                    2. Relieved by medication <br>
                    3. Relieved by cold sponging
                </td>
            </tr>
            <tr>
                <td colspan="2">Intermittent</td>
                <td colspan="2">{{ $cardiac_assessment->fever_intermittent ?? '' }}</td>
            </tr>
            <tr>
                <td colspan="2">Remittent</td>
                <td colspan="2">{{ $cardiac_assessment->fever_remittent ?? '' }}</td>
            </tr>

            {{-- Heavy snoring --}}
            <tr>
                <td colspan="6">
                    <b>Heavy snoring:</b> {{ ucfirst($cardiac_assessment->heavy_snoring ?? 'None') }}
                </td>
            </tr>
            <tr>
                <td colspan="6">Finding: {{ $cardiac_assessment->snoring_finding ?? '' }}</td>
            </tr>
            <tr>
                <td colspan="6">Others: {{ $cardiac_assessment->snoring_others ?? '' }}</td>
            </tr>
        </tbody>
    </table>

    <table class="table table-bordered">
        <tbody>
            {{-- Past History --}}
            <tr>
                <th colspan="6" style="text-align:left;">PAST HISTORY</th>
            </tr>

            <tr>
                <td colspan="6">
                    <b>History of previous myocardial infarction:</b> {{ ucfirst($cardiac_assessment->prev_mi ?? '--') }}
                </td>
            </tr>

            <tr>
                <th>Date</th>
                <th>First</th>
                <th colspan="2">Second</th>
                <th colspan="2">Third</th>
            </tr>
            <tr>
                <td></td>
                <td>{{ $cardiac_assessment->mi_first_date ? \Carbon\Carbon::parse($cardiac_assessment->mi_first_date)->format('Y-m-d') : '' }}</td>
                <td colspan="2">{{ $cardiac_assessment->mi_second_date ? \Carbon\Carbon::parse($cardiac_assessment->mi_second_date)->format('Y-m-d') : '' }}</td>
                <td colspan="2">{{ $cardiac_assessment->mi_third_date ? \Carbon\Carbon::parse($cardiac_assessment->mi_third_date)->format('Y-m-d') : '' }}</td>
            </tr>

            <tr>
                <td>Site</td>
                <td>
                    @if(!empty($cardiac_assessment->mi_first_site) && is_array($cardiac_assessment->mi_first_site))
                        {{ implode(', ', $cardiac_assessment->mi_first_site) }}
                    @elseif(!empty($cardiac_assessment->mi_first_site))
                        {{ $cardiac_assessment->mi_first_site }}
                    @else
                        --
                    @endif
                </td>

                <td colspan="2">
                    @if(!empty($cardiac_assessment->mi_second_site) && is_array($cardiac_assessment->mi_second_site))
                        {{ implode(', ', $cardiac_assessment->mi_second_site) }}
                    @elseif(!empty($cardiac_assessment->mi_second_site))
                        {{ $cardiac_assessment->mi_second_site }}
                    @else
                        --
                    @endif
                </td>

                <td colspan="2">
                    @if(!empty($cardiac_assessment->mi_third_site) && is_array($cardiac_assessment->mi_third_site))
                        {{ implode(', ', $cardiac_assessment->mi_third_site) }}
                    @elseif(!empty($cardiac_assessment->mi_third_site))
                        {{ $cardiac_assessment->mi_third_site }}
                    @else
                        --
                    @endif
                </td>
            </tr>

            <tr>
                <td>With ST Elevation</td>
                <td colspan="5">{{ ucfirst($cardiac_assessment->st_elev ?? '--') }}</td>
            </tr>

            <tr>
                <td>Thrombolytic Therapy</td>
                <td colspan="5">{{ ucfirst($cardiac_assessment->thrombolytic ?? '--') }}</td>
            </tr>

            <tr>
                <td>Thrombolytic Agent</td>
                <td colspan="5">{{ $cardiac_assessment->first_thrombolytic_agent ?? '' }}</td>
            </tr>

            <tr>
                <td>Complications</td>
                <td colspan="5">{{ ucfirst($cardiac_assessment->complications ?? '--') }}</td>
            </tr>
        </tbody>
    </table>

    <table class="table table-bordered">
        <tbody>
            {{-- Past History --}}
            <tr>
                <th colspan="6" style="text-align:left;">PAST HISTORY</th>
            </tr>

            {{-- Angina --}}
            <tr>
                <td colspan="6">
                    <b>Angina:</b> 
                    @if(!empty($cardiac_assessment->angina))
                        @php
                            $anginaArray = is_array($cardiac_assessment->angina) 
                                ? $cardiac_assessment->angina 
                                : explode(',', $cardiac_assessment->angina);
                        @endphp
                        {{ implode(', ', $anginaArray) }}
                    @else
                        --
                    @endif

                    @if(!empty($cardiac_assessment->angina_present))
                        | Present: {{ ucfirst($cardiac_assessment->angina_present) }}
                    @endif
                </td>
            </tr>

            {{-- Essential Hypertension --}}
            <tr>
                <td colspan="6">
                    <b>Essential Hypertension:</b> {{ ucfirst($cardiac_assessment->htn ?? '--') }}
                </td>
            </tr>

            {{-- Arrhythmia --}}
            <tr>
                <td colspan="6">
                    <b>Arrhythmia:</b>
                    @if(!empty($cardiac_assessment->arrhythmia))
                        @php
                            $arrhythmiaArray = is_array($cardiac_assessment->arrhythmia) 
                                ? $cardiac_assessment->arrhythmia 
                                : explode(',', $cardiac_assessment->arrhythmia);
                        @endphp
                        {{ implode(', ', $arrhythmiaArray) }}
                    @else
                        --
                    @endif

                    @if(!empty($cardiac_assessment->arrhythmia_control))
                        | Controlled: {{ ucfirst($cardiac_assessment->arrhythmia_control) }}
                    @endif
                </td>
            </tr>

            {{-- Cyanosis --}}
            <tr>
                <td colspan="6">
                    <b>Cyanosis:</b> {{ ucfirst($cardiac_assessment->cyanosis ?? '--') }}
                    @if(!empty($cardiac_assessment->cyanosis_select))
                        | Present: {{ ucfirst($cardiac_assessment->cyanosis_select) }}
                    @endif
                </td>
            </tr>

            {{-- Heart Failure --}}
            <tr>
                <td colspan="6">
                    <b>Heart Failure:</b> {{ ucfirst($cardiac_assessment->heart_failure ?? '--') }}
                    @if(!empty($cardiac_assessment->heart_failure_select))
                        | Present: {{ ucfirst($cardiac_assessment->heart_failure_select) }}
                    @endif
                </td>
            </tr>

            {{-- Rheumatic Fever --}}
            <tr>
                <td colspan="6">
                    <b>Rheumatic Fever:</b> {{ ucfirst($cardiac_assessment->rheumatic_fever ?? '--') }}
                    @if(!empty($cardiac_assessment->rheumatic_fever_select))
                        | Present: {{ ucfirst($cardiac_assessment->rheumatic_fever_select) }}
                    @endif
                </td>
            </tr>

            {{-- Peripheral Vascular --}}
            <tr>
                <td colspan="6">
                    <b>Peripheral Vascular Disease:</b> {{ ucfirst($cardiac_assessment->peripheral_vascular ?? '--') }}
                    @if(!empty($cardiac_assessment->peripheral_vascular_select))
                        | Present: {{ ucfirst($cardiac_assessment->peripheral_vascular_select) }}
                    @endif
                </td>
            </tr>

            {{-- Tuberculosis of Lung --}}
            <tr>
                <td colspan="6">
                    <b>Tuberculosis of Lung:</b> {{ ucfirst($cardiac_assessment->tuberculosis_of_lung ?? '--') }}
                    @if(!empty($cardiac_assessment->tuberculosis_lung_select))
                        | Present: {{ ucfirst($cardiac_assessment->tuberculosis_lung_select) }}
                    @endif
                </td>
            </tr>

            {{-- Convulsions --}}
            <tr>
                <td colspan="6">
                    <b>Convulsions:</b> {{ ucfirst($cardiac_assessment->convulsions ?? '--') }}
                    @if(!empty($cardiac_assessment->convulsions_select))
                        | Present: {{ ucfirst($cardiac_assessment->convulsions_select) }}
                    @endif
                </td>
            </tr>

            {{-- Paralysis --}}
            <tr>
                <td colspan="6">
                    <b>Paralysis:</b>
                    @if(!empty($cardiac_assessment->paralysis))
                        @php
                            $paralysisArray = is_array($cardiac_assessment->paralysis) 
                                ? $cardiac_assessment->paralysis 
                                : explode(',', $cardiac_assessment->paralysis);
                        @endphp
                        {{ implode(', ', $paralysisArray) }}
                    @else
                        --
                    @endif

                    @if(!empty($cardiac_assessment->paralysis_select))
                        | Present: {{ ucfirst($cardiac_assessment->paralysis_select) }}
                    @endif
                </td>
            </tr>

            {{-- Blackout --}}
            <tr>
                <td colspan="2"><b>Blackout (G45.9):</b> {{ @$cardiac_assessment->blackout ?? '--' }}</td>
                <td colspan="4"><b>Selected:</b> {{ @$cardiac_assessment->blackout_select ?? '--' }}</td>
            </tr>

            {{-- Head Injury --}}
            <tr>
                <td colspan="2"><b>Head injury (S06.9):</b> {{ @$cardiac_assessment->head_injury ?? '--' }}</td>
                <td colspan="4"><b>Selected:</b> {{ @$cardiac_assessment->head_injury_select ?? '--' }}</td>
            </tr>

            {{-- Depression --}}
            <tr>
                <td colspan="2"><b>Depression (F32.9):</b> {{ @$cardiac_assessment->depression ?? '--' }}</td>
                <td colspan="4"><b>Selected:</b> {{ @$cardiac_assessment->depression_select ?? '--' }}</td>
            </tr>

            {{-- Gall stones --}}
            <tr>
                <td colspan="2"><b>Gall stones (K80.80):</b> {{ @$cardiac_assessment->gall_stones ?? '--' }}</td>
                <td colspan="4"><b>Selected:</b> {{ @$cardiac_assessment->gall_stones_select ?? '--' }}</td>
            </tr>

            {{-- Jaundice --}}
            <tr>
                <td colspan="2"><b>Jaundice (R17):</b> {{ @$cardiac_assessment->jaundice ?? '--' }}</td>
                <td colspan="4"><b>Selected:</b> {{ @$cardiac_assessment->jaundice_select ?? '--' }}</td>
            </tr>

            {{-- Hernia --}}
            <tr>
                <td colspan="2"><b>Hernia (K40.90):</b> {{ @$cardiac_assessment->hernia ?? '--' }}</td>
                <td colspan="4"><b>Selected:</b> {{ @$cardiac_assessment->hernia_select ?? '--' }}</td>
            </tr>

            {{-- Acid peptic disease --}}
            <tr>
                <td colspan="2"><b>Acid peptic disease (K27.9):</b> {{ @$cardiac_assessment->acid_peptic_disease ?? '--' }}</td>
                <td colspan="4"><b>Selected:</b> {{ @$cardiac_assessment->acid_peptic_select ?? '--' }}</td>
            </tr>

            {{-- Renal dysfunction --}}
            <tr>
                <td colspan="2"><b>Renal dysfunction (N19):</b> {{ @$cardiac_assessment->renal_dysfunction ?? '--' }}</td>
                <td colspan="4"><b>Selected:</b> {{ @$cardiac_assessment->renal_dysfunction_select ?? '--' }}</td>
            </tr>

            {{-- Hyperthyroidism --}}
            <tr>
                <td colspan="2"><b>Hyperthyroidism (E05.9):</b> {{ @$cardiac_assessment->hyperthyroidism ?? '--' }}</td>
                <td colspan="4"><b>Selected:</b> {{ @$cardiac_assessment->hyperthyroidism_select ?? '--' }}</td>
            </tr>

            {{-- Hypothyroidism --}}
            <tr>
                <td colspan="2"><b>Hypothyroidism (E03.9):</b> {{ @$cardiac_assessment->hypothyroidism ?? '--' }}</td>
                <td colspan="4"><b>Selected:</b> {{ @$cardiac_assessment->hypothyroidism_select ?? '--' }}</td>
            </tr>

            {{-- Hyperlipidemia --}}
            <tr>
                <td colspan="2"><b>Hyperlipidemia (E78.5):</b> {{ @$cardiac_assessment->hyperlipidemia ?? '--' }}</td>
                <td colspan="4"><b>Selected:</b> {{ @$cardiac_assessment->hyperlipidemia_select ?? '--' }}</td>
            </tr>

            {{-- Diabetes mellitus --}}
            <tr>
                <td colspan="2"><b>Diabetes mellitus:</b> {{ @$cardiac_assessment->diabetes_mellitus_select ?? '--' }}</td>
                <td colspan="2">
                    <b>Types:</b>
                    @if(!empty($cardiac_assessment->diabetes_mellitus))
                        @php
                            $dmTypes = is_array($cardiac_assessment->diabetes_mellitus) 
                                ? $cardiac_assessment->diabetes_mellitus 
                                : explode(',', $cardiac_assessment->diabetes_mellitus);
                        @endphp
                        {{ implode(', ', $dmTypes) }}
                    @else
                        --
                    @endif
                </td>
                <td colspan="2"><b>Drugs:</b> {{ @$cardiac_assessment->second_thrombolytic_agent ?? '--' }}</td>
            </tr>

            {{-- Any other history --}}
            <tr>
                <td colspan="6"><b>Any Other History:</b><br> {{ @$cardiac_assessment->any_history ?? '--' }}</td>
            </tr>
        </tbody>
    </table>

    <table class="table table-bordered">
        <tbody>
            {{-- FAMILY HISTORY --}}
            <tr>
                <td colspan="6" class="text-center"><b>FAMILY HISTORY:</b></td>
            </tr>

            <tr>
                <th>Disease</th>
                <th>Father</th>
                <th>Mother</th>
                <th>Brother</th>
                <th colspan="2">Sister</th>
            </tr>

            <tr>
                <td>Ischemic heart disease (Z82.4.0)</td>
                <td>{{ !empty($cardiac_assessment->fh_ischemic_father) ? 'Yes' : '--' }}</td>
                <td>{{ !empty($cardiac_assessment->fh_ischemic_mother) ? 'Yes' : '--' }}</td>
                <td>{{ !empty($cardiac_assessment->fh_ischemic_brother) ? 'Yes' : '--' }}</td>
                <td colspan="2">{{ !empty($cardiac_assessment->fh_ischemic_sister) ? 'Yes' : '--' }}</td>
            </tr>

            <tr>
                <td>Hypertension (Z82.4.1)</td>
                <td>{{ !empty($cardiac_assessment->fh_hyper_father) ? 'Yes' : '--' }}</td>
                <td>{{ !empty($cardiac_assessment->fh_hyper_mother) ? 'Yes' : '--' }}</td>
                <td>{{ !empty($cardiac_assessment->fh_hyper_brother) ? 'Yes' : '--' }}</td>
                <td colspan="2">{{ !empty($cardiac_assessment->fh_hyper_sister) ? 'Yes' : '--' }}</td>
            </tr>

            <tr>
                <td>Congenital heart disease (Z82.4.2)</td>
                <td>{{ !empty($cardiac_assessment->fh_chd_father) ? 'Yes' : '--' }}</td>
                <td>{{ !empty($cardiac_assessment->fh_chd_mother) ? 'Yes' : '--' }}</td>
                <td>{{ !empty($cardiac_assessment->fh_chd_brother) ? 'Yes' : '--' }}</td>
                <td colspan="2">{{ !empty($cardiac_assessment->fh_chd_sister) ? 'Yes' : '--' }}</td>
            </tr>

            <tr>
                <td>Diabetes mellitus (Z83.3)</td>
                <td>{{ !empty($cardiac_assessment->fh_dm_father) ? 'Yes' : '--' }}</td>
                <td>{{ !empty($cardiac_assessment->fh_dm_mother) ? 'Yes' : '--' }}</td>
                <td>{{ !empty($cardiac_assessment->fh_dm_brother) ? 'Yes' : '--' }}</td>
                <td colspan="2">{{ !empty($cardiac_assessment->fh_dm_sister) ? 'Yes' : '--' }}</td>
            </tr>

            <tr>
                <td>Bleeding disorder (Z83.2)</td>
                <td>{{ !empty($cardiac_assessment->fh_bleeding_father) ? 'Yes' : '--' }}</td>
                <td>{{ !empty($cardiac_assessment->fh_bleeding_mother) ? 'Yes' : '--' }}</td>
                <td>{{ !empty($cardiac_assessment->fh_bleeding_brother) ? 'Yes' : '--' }}</td>
                <td colspan="2">{{ !empty($cardiac_assessment->fh_bleeding_sister) ? 'Yes' : '--' }}</td>
            </tr>

            <tr>
                <td>Stroke / Paralysis (Z82.3)</td>
                <td>{{ !empty($cardiac_assessment->fh_stroke_father) ? 'Yes' : '--' }}</td>
                <td>{{ !empty($cardiac_assessment->fh_stroke_mother) ? 'Yes' : '--' }}</td>
                <td>{{ !empty($cardiac_assessment->fh_stroke_brother) ? 'Yes' : '--' }}</td>
                <td colspan="2">{{ !empty($cardiac_assessment->fh_stroke_sister) ? 'Yes' : '--' }}</td>
            </tr>

            <tr>
                <td>Sudden death at &lt; 45 yrs (Z84.8)</td>
                <td>{{ !empty($cardiac_assessment->fh_sudden_father) ? 'Yes' : '--' }}</td>
                <td>{{ !empty($cardiac_assessment->fh_sudden_mother) ? 'Yes' : '--' }}</td>
                <td>{{ !empty($cardiac_assessment->fh_sudden_brother) ? 'Yes' : '--' }}</td>
                <td colspan="2">{{ !empty($cardiac_assessment->fh_sudden_sister) ? 'Yes' : '--' }}</td>
            </tr>

            <tr>
                <td>Others</td>
                <td>{{ !empty($cardiac_assessment->fh_other_father) ? 'Yes' : '--' }}</td>
                <td>{{ !empty($cardiac_assessment->fh_other_mother) ? 'Yes' : '--' }}</td>
                <td>{{ !empty($cardiac_assessment->fh_other_brother) ? 'Yes' : '--' }}</td>
                <td colspan="2">{{ !empty($cardiac_assessment->fh_other_sister) ? 'Yes' : '--' }}</td>
            </tr>
        </tbody>
    </table>

    <table class="table table-bordered">
        <tbody>
            {{-- PERSONAL HISTORY --}}
            <tr>
                <td colspan="6"><b>PERSONAL HISTORY</b></td>
            </tr>

            {{-- Smoking --}}
            <tr>
                <td colspan="2">Smoking</td>
                <td colspan="2">
                    @php
                        $smoking = is_array($cardiac_assessment->smoking_select) 
                            ? $cardiac_assessment->smoking_select 
                            : (!empty($cardiac_assessment->smoking_select) ? explode(',', $cardiac_assessment->smoking_select) : []);
                    @endphp
                    {{ !empty($smoking) ? implode(', ', $smoking) : '--' }}
                </td>
                <td colspan="2">
                    Duration: {{ $cardiac_assessment->smoking_duration ?? '--' }}
                </td>
            </tr>

            {{-- Alcohol Intake --}}
            <tr>
                <td colspan="2">Alcohol Intake</td>
                <td colspan="2">
                    @php
                        $alcohol = is_array($cardiac_assessment->alcohol_intake) 
                            ? $cardiac_assessment->alcohol_intake 
                            : (!empty($cardiac_assessment->alcohol_intake) ? explode(',', $cardiac_assessment->alcohol_intake) : []);
                    @endphp
                    {{ !empty($alcohol) ? implode(', ', $alcohol) : '--' }}
                </td>
                <td colspan="2">
                    @php
                        $how_much_ml = is_array($cardiac_assessment->how_much_ml) 
                            ? $cardiac_assessment->how_much_ml 
                            : (!empty($cardiac_assessment->how_much_ml) ? explode(',', $cardiac_assessment->how_much_ml) : []);
                    @endphp
                    How much ml: {{ !empty($how_much_ml) ? implode(', ', $how_much_ml) : '--' }}
                </td>
            </tr>

            {{-- Physical Exercise --}}
            <tr>
                <td colspan="2">Physical Exercise</td>
                <td colspan="4">
                    @php
                        $exercise = is_array($cardiac_assessment->physical_exercise) 
                            ? $cardiac_assessment->physical_exercise 
                            : (!empty($cardiac_assessment->physical_exercise) ? explode(',', $cardiac_assessment->physical_exercise) : []);
                    @endphp
                    {{ !empty($exercise) ? implode(', ', $exercise) : '--' }}
                </td>
            </tr>

            {{-- Food Habits --}}
            <tr>
                <td colspan="2">Food Habits</td>
                <td colspan="4">
                    @php
                        $food = is_array($cardiac_assessment->food_habits) 
                            ? $cardiac_assessment->food_habits 
                            : (!empty($cardiac_assessment->food_habits) ? explode(',', $cardiac_assessment->food_habits) : []);
                    @endphp
                    {{ !empty($food) ? implode(', ', $food) : '--' }}
                </td>
            </tr>

            {{-- Yoga and Meditation --}}
            <tr>
                <td colspan="2">Yoga and Meditation</td>
                <td colspan="4">
                    @php
                        $yoga = is_array($cardiac_assessment->yoga_meditation) 
                            ? $cardiac_assessment->yoga_meditation 
                            : (!empty($cardiac_assessment->yoga_meditation) ? explode(',', $cardiac_assessment->yoga_meditation) : []);
                    @endphp
                    {{ !empty($yoga) ? implode(', ', $yoga) : '--' }}
                </td>
            </tr>

            {{-- Addictive Drugs --}}
            <tr>
                <td colspan="2">Addictive Drugs</td>
                <td colspan="4">
                    @php
                        $drugs = is_array($cardiac_assessment->addictive_drugs) 
                            ? $cardiac_assessment->addictive_drugs 
                            : (!empty($cardiac_assessment->addictive_drugs) ? explode(',', $cardiac_assessment->addictive_drugs) : []);
                    @endphp
                    {{ !empty($drugs) ? implode(', ', $drugs) : '--' }}
                </td>
            </tr>

            {{-- Personality type A --}}
            <tr>
                <td colspan="2">Personality type A</td>
                <td colspan="4">
                    {{ $cardiac_assessment->personality_type ?? '--' }}
                </td>
            </tr>

            {{-- Allergy --}}
            <tr>
                <td colspan="2">Allergy</td>
                <td colspan="2">
                    {{ $cardiac_assessment->allergy ?? '--' }}
                </td>
                <td colspan="2">
                    To what: {{ $cardiac_assessment->allergy_to_what ?? '--' }}
                </td>
            </tr>
        </tbody>
    </table>

    <table class="table table-bordered">
        <tbody>
            {{-- Gynaecological & Obstetric History --}}
            <tr>
                <td colspan="6"><b>Gynaecological & Obstetric History (for females)</b></td>
            </tr>
            <tr>
                <td>Menarche</td>
                <td>Cycle</td>
                <td colspan="2">Loss</td>
                <td colspan="2">Inter Menstrual Bleeding</td>
            </tr>
            <tr>
                <td colspan="3">Pain</td>
                <td colspan="3">L.M.P</td>
            </tr>
            <tr>
                <td colspan="3">Vaginal Discharge</td>
                <td>Cervical smear</td>
                <td colspan="2">Contraception</td>
            </tr>
            <tr>
                <td colspan="6">Obstetric History</td>
            </tr>

            <tr>
                <td colspan="6">
                    <b>Relevant Family History:</b> {{ $cardiac_assessment->relevant_family_history ?? '--' }} <br>
                    Status: {{ $cardiac_assessment->family_history_select ?? '--' }} <br><br>

                    <b>Socioeconomic History:</b> Lifestyle: {{ $cardiac_assessment->socioeconomic_history ?? '--' }} <br>
                    Occupation: {{ $cardiac_assessment->occupation ?? '--' }} <br><br>

                    <b>Educational Status:</b> {{ $cardiac_assessment->educational_status ?? '--' }}
                </td>
            </tr>

            {{-- Psychiatric, Social & Addiction History --}}
            <tr>
                <td><b>Any emotional or psychiatric disorder</b></td>
                <td colspan="2">{{ $cardiac_assessment->psychiatric_disorder ?? '--' }}</td>
                <td>Recent death in the family</td>
                <td colspan="2">{{ $cardiac_assessment->recent_death_family ?? '--' }}</td>
            </tr>

            <tr>
                <td>Risk of suicide</td>
                <td colspan="2">{{ $cardiac_assessment->risk_of_suicide ?? '--' }}</td>
                <td>Sleep Disorder</td>
                <td colspan="2">{{ $cardiac_assessment->sleep_disorder ?? '--' }}</td>
            </tr>

            <tr>
                <td><b>Victims of Abuse and Neglect</b></td>
                <td colspan="5">{{ $cardiac_assessment->victims_abuse_neglect ?? '--' }}</td>
            </tr>

            <tr>
                <td colspan="6"><b>Drug or Alcohol Dependency</b></td>
            </tr>

            <tr>
                <td>Addiction</td>
                <td colspan="5">
                    @php
                        $addictionArray = !empty($cardiac_assessment->addiction) 
                            ? explode(',', $cardiac_assessment->addiction) 
                            : [];
                    @endphp

                    @if(!empty($addictionArray))
                        {{ implode(', ', $addictionArray) }}
                    @else
                        --
                    @endif
                </td>
            </tr>

            <tr>
                <td>Action taken:</td>
                <td colspan="5">{{ $cardiac_assessment->any_other_history ?? '--' }}</td>
            </tr>
        </tbody>
    </table>

    <table class="table table-bordered">
        <tbody>
            {{-- PHYSICAL EXAM --}}
            <tr>
                <th colspan="6" style="text-align:center;">PHYSICAL EXAM</th>
            </tr>

            <tr>
                @php
                    // Pain Scale
                    $pain_scale = $cardiac_assessment->pain_scale ?? '';
                    if (!empty($pain_scale)) {
                        // Try decode JSON first
                        $pain_scale_arr = json_decode($pain_scale, true);
                        if (json_last_error() !== JSON_ERROR_NONE || !is_array($pain_scale_arr)) {
                            // Fallback: treat as comma-separated string
                            $pain_scale_arr = explode(',', $pain_scale);
                        }
                    } else {
                        $pain_scale_arr = [];
                    }
                @endphp
                <!-- Left Side -->
                <td colspan="3" style="width:50%; vertical-align: top;">
                    <b>Pain Rating Scale:</b>
                    @if(!empty($pain_scale_arr))
                        {{ implode(', ', $pain_scale_arr) }}
                    @else
                        --
                    @endif
                    <br>
                </td>

                @php
                    // Acuity
                    $acuity = $cardiac_assessment->acuity ?? '';
                    $acuity_arr = [];
                    if (!empty($acuity)) {
                        $temp = json_decode($acuity, true);
                        $acuity_arr = (json_last_error() === JSON_ERROR_NONE && is_array($temp)) ? $temp : explode(',', $acuity);
                    }
                @endphp

                @php
                    // Character
                    $character = $cardiac_assessment->character ?? '';
                    $character_arr = [];
                    if (!empty($character)) {
                        $temp = json_decode($character, true);
                        $character_arr = (json_last_error() === JSON_ERROR_NONE && is_array($temp)) ? $temp : explode(',', $character);
                    }
                @endphp
                <!-- Right Side -->
                <td colspan="3" style="width:50%; vertical-align: top;">
                    <b>Score:</b> {{ $cardiac_assessment->physical_exam_score ?? '--' }} <br>
                    <b>Location:</b> {{ $cardiac_assessment->physical_exam_location ?? '--' }} <br><br>

                    <b>Acuity:</b>
                    @if(!empty($acuity_arr))
                        {{ implode(', ', $acuity_arr) }}
                    @else
                        --
                    @endif
                    <br>

                    <b>Modifying factors:</b><br>
                    Decreasing: {{ $cardiac_assessment->decreasing ?? '--' }} <br>
                    Increasing: {{ $cardiac_assessment->increasing ?? '--' }} <br><br>

                    <b>Character:</b>
                    @if(!empty($character_arr))
                        {{ implode(', ', $character_arr) }}
                    @else
                        --
                    @endif
                </td>
            </tr>

            <tr>
                <td colspan="6">
                    <b>Vital Signs:</b><br>
                    <table border="1" width="100%" cellspacing="0" cellpadding="5">
                        <tr>
                            <th>Pulse</th>
                            <th>Blood Pressure</th>
                            <th>Respiratory Rate</th>
                            <th>Temperature</th>
                        </tr>
                        <tr>
                            <td>{{ $cardiac_assessment->physical_pulse ?? '--' }}</td>
                            <td>{{ $cardiac_assessment->physical_exam_bp ?? '--' }}</td>
                            <td>{{ $cardiac_assessment->physical_exam_rate ?? '--' }}</td>
                            <td colspan="2">{{ $cardiac_assessment->physical_exam_temp ?? '--' }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>

    <table class="table table-bordered">
        <tbody>
            <tr>
                <td colspan="6">
                    (Encircle "WNL" if normal exam) (Encircle the system if the findings are to be part of the summary) <br><br>

                    <b>GENERAL EXAMINATION:</b> WNL <br>
                    Parameters: Height, Weight, Built, Nutrition, Anaemia, Jaundice, Gedema, Cyanosis, Dehydration, Clubbing. <br>
                    {{ $cardiac_assessment->general_examination ?? '--' }} <br><br>

                    <b>BREAST:</b> Size, Shape, Symmetry, Tenderness, and Masses <br>
                    WNL <br>
                    {{ $cardiac_assessment->breast_size ?? '--' }} <br><br>

                    <b>ENT:</b> <br>
                    EARS; Pinna, auditory canals, tympanic membranes and gross hearing <br>
                    WNL <br>
                    {{ $cardiac_assessment->ent_ears ?? '--' }} <br><br>

                    <b>NOSE:</b> Deformities and septal deviation: obstruction, mucous membrane inflammation, polyps, bleeding and discharge. Turnibates <br>
                    WNL <br>
                    {{ $cardiac_assessment->nose_wnl ?? '--' }} <br><br>

                    <b>THROAT:</b> Mucosal color, exudates and lesions: tonsil size, symmetry and exudates: post nasal discharge, Dental hygiene <br>
                    WNL <br>
                    {{ $cardiac_assessment->throat_wnl ?? '--' }} <br><br>

                    <b>MUSCULOSKELETAL:</b> Joint mobility, tenderness, effusion, erythema and deformity. <br>
                    WNL <br>
                    {{ $cardiac_assessment->musculoskeletal_wnl ?? '--' }} <br><br>

                    <b>CARDIO VASCULAR SYSTEM:</b> WNL <br>
                    Parameters: Pulse: Rate, Rhythm, Character, Condition of arterial wall, Peripheral, Pulse: Apex beat, C.S from midline, Lt Para sternal heave Thrill Heart Sounds 1st & 2nd, Added Sounds, Murmur <br>
                    {{ $cardiac_assessment->cardio_vascular ?? '--' }} <br><br>

                    <b>RESPIRATORY SYSTEM:</b> WNL <br>
                    Parameters: Inspection. Palpation: Position Of Trachea, Chest Expansion, Vocal Fremitus, Percussion. <br>
                    Auscultation: Breath Sound, Added Sound. Vocal Resonance <br>
                    {{ $cardiac_assessment->respiratory_system ?? '--' }} <br><br>

                    <b>ALIMENTARY SYSTEM:</b> WNL <br>
                    Parameters: Lip, Teeth, Gum, Tongue. Tonsil, Pharynx <br>
                    {{ $cardiac_assessment->alimentary_system ?? '--' }} <br><br>

                    <b>ORAL CAVITY:</b> WNL <br>
                    {{ $cardiac_assessment->oral_cavity ?? '--' }} <br><br>

                    <b>ABDOMEN:</b> WNL <br>
                    Parameters: Inspection: General Appearance, Umbilicus, Palpation: Liver, Hernias, Spleen, Kidneys DRE <br>
                    Percussion: Auscultation: Bowel Sound, Others <br>
                    {{ $cardiac_assessment->abdomen_wnl ?? '--' }} <br><br>

                    <b>UROLOGENITAL SYSTEM:</b> WNL <br>
                    Parameters: Urinary Bladder. <br>
                    Male: Scrotum, Testes. Epididymis, Penis, Urinary incontinence. <br>
                    Female: Vulva, Vaginal, P/V Exam <br>
                    {{ $cardiac_assessment->urologenital_system ?? '--' }} <br><br>

                    <b>NEUROLOGICAL EXAMINATION:</b> WNL <br>
                    Parameters: Higher psychic function, GCS and Pupils. Cranial Nerves, Motor System, Reflexes, Sensory System, Romberg's Test, Cerebellar Signs, Sign of meningeal irritation <br>
                    {{ $cardiac_assessment->neurological_examination ?? '--' }} <br><br>

                    <b>COGNITIVE FUNCTION:</b> Orientation memory, short term memory, long term memory, language skill, Visual-spatial skill: Executive Function: Motor skill: <br>
                    Mini Mental State Exam: (Score) <br>
                    {{ $cardiac_assessment->cognitive_function ?? '--' }}
                </td>
            </tr>
        </tbody>
    </table>

    <table class="table table-bordered">
        <tbody>
            <tr>
                <th colspan="6">Glasgow Coma Scale (GCS):</th>
            </tr>
            <tr>
                <th>Eye opening </th>
                <th>Verbal response </th>
                <th colspan="2">Motor response </th>
                <th colspan="2">GCS Score </th>
            </tr>
            <tr>
                <td>Spontaneous - 4</td>
                <td>Oriented - 5</td>
                <td colspan="2">Obeys Command - 6</td>
                <td colspan="2">{{ $cardiac_assessment->gcs_score_one ?? '--' }}</td>
            </tr>
            <tr>
                <td>To Speech - 3</td>
                <td>Confused - 4</td>
                <td colspan="2">Localizing pain - 5</td>
                <td colspan="2">{{ $cardiac_assessment->gcs_score_two ?? '--' }}</td>
            </tr>
            <tr>
                <td>To pain - 2</td>
                <td>Words (Inappropriate) - 3</td>
                <td colspan="2">Withdraws to pain - 4</td>
                <td colspan="2">{{ $cardiac_assessment->gcs_score_three ?? '--' }}</td>
            </tr>
            <tr>
                <td>None - 1</td>
                <td>Sound</td>
                <td colspan="2">Flexion to Pain - 3</td>
                <td colspan="2">{{ $cardiac_assessment->gcs_score_four ?? '--' }}</td>
            </tr>
            <tr>
                <td></td>
                <td>(Incomprehensible) - 2</td>
                <td colspan="2">Extension to pain - 2</td>
                <td colspan="2">{{ $cardiac_assessment->gcs_score_five ?? '--' }}</td>
            </tr>
            <tr>
                <td></td>
                <td>None - 1</td>
                <td colspan="2">None - 1</td>
                <td colspan="2">{{ $cardiac_assessment->gcs_score_six ?? '--' }}</td>
            </tr>

            <tr>
                <th>Psychiatric</th>
                <td colspan="3">
                    @php
                        $psychiatric_multiple = $cardiac_assessment->psychiatric_multiple;

                        if (!empty($psychiatric_multiple)) {
                            // Try JSON decode first
                            $psychiatric_multiple_array = json_decode($psychiatric_multiple, true);

                            // If JSON decode fails, assume comma-separated string
                            if (!is_array($psychiatric_multiple_array)) {
                                $psychiatric_multiple_array = explode(',', $psychiatric_multiple);
                            }
                        } else {
                            $psychiatric_multiple_array = [];
                        }
                    @endphp

                    @if(!empty($psychiatric_multiple_array))
                        {{ implode(', ', $psychiatric_multiple_array) }}
                    @else
                        --
                    @endif

                    @if(!empty($cardiac_assessment->psychiatric_other))
                        (Other: {{ $cardiac_assessment->psychiatric_other }})
                    @endif
                </td>
                <td colspan="2">WNL</td>
            </tr>

            <tr>
                <th>Functional Assessment: </th>
                <td colspan="5">{{ $cardiac_assessment->functional_assessment ?? '--' }}</td>
            </tr>

            <tr>
                <th>Activity </th>
                <th>Independent </th>
                <th colspan="2">Needs assistance </th>
                <th colspan="2">Dependent </th>
            </tr>
            <tr>
                <td>Sitting</td>
                <td>{{ $cardiac_assessment->sitting_independent ?? '--' }}</td>
                <td colspan="2">{{ $cardiac_assessment->sitting_assistance ?? '--' }}</td>
                <td colspan="2">{{ $cardiac_assessment->sitting_dependent ?? '--' }}</td>
            </tr>
            <tr>
                <td>Standing</td>
                <td>{{ $cardiac_assessment->standing_independent ?? '--' }}</td>
                <td colspan="2">{{ $cardiac_assessment->standing_assistance ?? '--' }}</td>
                <td colspan="2">{{ $cardiac_assessment->standing_dependent ?? '--' }}</td>
            </tr>
            <tr>
                <td>Ambulation</td>
                <td>{{ $cardiac_assessment->ambulation_independent ?? '--' }}</td>
                <td colspan="2">{{ $cardiac_assessment->ambulation_assistance ?? '--' }}</td>
                <td colspan="2">{{ $cardiac_assessment->ambulation_dependent ?? '--' }}</td>
            </tr>
            <tr>
                <td>Stair Climbing</td>
                <td>{{ $cardiac_assessment->climbing_independent ?? '--' }}</td>
                <td colspan="2">{{ $cardiac_assessment->climbing_assistance ?? '--' }}</td>
                <td colspan="2">{{ $cardiac_assessment->climbing_dependent ?? '--' }}</td>
            </tr>
            <tr>
                <td>Disabilities if any </td>
                <td>{{ $cardiac_assessment->disabilities_independent ?? '--' }}</td>
                <td colspan="2">{{ $cardiac_assessment->disabilities_assistance ?? '--' }}</td>
                <td colspan="2">{{ $cardiac_assessment->disabilities_dependent ?? '--' }}</td>
            </tr>
        </tbody>
    </table>

    <table class="table table-bordered">
        <tbody>
            <tr>
                <th colspan="6">If Dependent - Refer to Physiotherapist:</th>
            </tr>
            <tr>
                <td colspan="6">
                    <div class="d-flex flex-col py-2 gap-2">
                        <div><b>Suspected of communicable disease:</b></div>
                        <div>
                            {{ $cardiac_assessment->suspected_communicable_disease ?? '--' }}
                        </div>
                        <div>
                            @if(!empty($cardiac_assessment->suspected_communicable_ifyes))
                                (If yes specify: {{ $cardiac_assessment->suspected_communicable_ifyes }})
                            @endif
                        </div>
                    </div>

                    <div class="d-flex flex-col py-2 gap-2">
                        <div><b>Immuno compromised status:</b></div>
                        <div>
                            {{ $cardiac_assessment->immuno_compromised_status ?? '--' }}
                        </div>
                        <div>
                            @if(!empty($cardiac_assessment->immuno_compromised_ifyes))
                                (If yes specify: {{ $cardiac_assessment->immuno_compromised_ifyes }})
                            @endif
                        </div>
                    </div>

                    <div class="d-flex flex-col py-2 gap-2">
                        <div><b>Isolation requirement & patient placement:</b></div>
                        <div>
                            @php
                                $psychiatric_select = $cardiac_assessment->psychiatric_select;
                                if (!empty($psychiatric_select)) {
                                    $psychiatric_select_array = json_decode($psychiatric_select, true);
                                    if (!is_array($psychiatric_select_array)) {
                                        $psychiatric_select_array = explode(',', $psychiatric_select);
                                    }
                                } else {
                                    $psychiatric_select_array = [];
                                }
                            @endphp

                            @if(!empty($psychiatric_select_array))
                                {{ implode(', ', $psychiatric_select_array) }}
                            @else
                                --
                            @endif
                        </div>
                    </div>
                </td>
            </tr>

            <tr>
                <th colspan="6">Nutritional (Encircle the findings for each criteria and add up the score):</th>
            </tr>
            <tr>
                <th>Criteria</th>
                <th>0</th>
                <th>1</th>
                <th>2</th>
                <th colspan="2">3</th>
            </tr>
            <tr>
                <td>Decreased food intake over last 3 months</td>
                <td>Severe loss</td>
                <td>Moderate loss</td>
                <td></td>
                <td colspan="2">No</td>
            </tr>
            <tr>
                <td>Weight loss in last 3 months</td>
                <td>>3 kg</td>
                <td>Don't know</td>
                <td>1-3 kg</td>
                <td colspan="2">No loss</td>
            </tr>
            <tr>
                <td>Mobility</td>
                <td>Bed chair bound</td>
                <td>Able to but doesn't</td>
                <td>Fully mobile</td>
                <td colspan="2"></td>
            </tr>
            <tr>
                <td>Acute disease in last 3 months</td>
                <td>Yes</td>
                <td></td>
                <td>No</td>
                <td colspan="2"></td>
            </tr>
            <tr>
                <td>Neuropsychological problem</td>
                <td>Severe dementia/depression</td>
                <td>Mild dementia</td>
                <td>None</td>
                <td colspan="2"></td>
            </tr>
            <tr>
                <td>Body habitus</td>
                <td>Cadhectic/Morbid obese</td>
                <td>Obese</td>
                <td>Thin</td>
                <td colspan="2">Average</td>
            </tr>
            <tr>
                <td colspan="6">
                    Total Score: {{ $cardiac_assessment->nutritional_score ?? '--' }}
                </td>
            </tr>

            <tr>
                <th colspan="6">Discharge Planning: (Encircle):</th>
            </tr>
            <tr>
                <td>Social support needed at home</td>
                <td colspan="2">{{ $cardiac_assessment->social_support_needed ?? '--' }}</td>
                <td colspan="3" rowspan="4">
                    Discharge Plan: <br>
                    {{ $cardiac_assessment->discharge_plan ?? '--' }}
                </td>
            </tr>
            <tr>
                <td>Home equipment anticipated</td>
                <td colspan="2">{{ $cardiac_assessment->home_equipment_anticipate ?? '--' }}</td>
            </tr>
            <tr>
                <td>Physiotherapy at home anticipated</td>
                <td colspan="2">{{ $cardiac_assessment->physiotherapy_home_anticipated ?? '--' }}</td>
            </tr>
            <tr>
                <td>Wound card needs anticipated at home</td>
                <td colspan="2">{{ $cardiac_assessment->wound_card_anticipated ?? '--' }}</td>
            </tr>
        </tbody>
    </table>

    <table class="table table-bordered">
        <tbody>
            {{-- Referral Assessments --}}
            <tr>
                <th colspan="6" style="text-align:left;">ASSESSMENTS & REFERRALS</th>
            </tr>

            {{-- Psychological --}}
            <tr>
                <td colspan="6">
                    <b>Psychological assessment – Psychiatry Referral needed:</b> 
                    {{ ucfirst($cardiac_assessment->psychiatry_referral_needed ?? '--') }}
                </td>
            </tr>

            {{-- Functional --}}
            <tr>
                <td colspan="6">
                    <b>Functional – Physiotherapy referral:</b> 
                    {{ ucfirst($cardiac_assessment->physiotherapy_referral ?? '--') }}
                </td>
            </tr>

            {{-- Nutritional --}}
            <tr>
                <td colspan="6">
                    <b>Nutritional – Dietary referral:</b> 
                    {{ ucfirst($cardiac_assessment->dietary_referral ?? '--') }}
                </td>
            </tr>

            {{-- Expected Cost --}}
            <tr>
                <td colspan="6">
                    <b>Expected cost and outcome of treatment has been explained:</b> 
                    {{ ucfirst($cardiac_assessment->expected_cost_outcome ?? '--') }}
                </td>
            </tr>

            {{-- History of Operations --}}
            <tr>
                <th colspan="6" style="text-align:left;">HISTORY OF ANY OPERATIONS / ANGIOGRAMS / ANGIOPLASTY</th>
            </tr>
            <tr>
                <td colspan="2"><b>Operations / Hospital</b></td>
                <td colspan="2"><b>Date (DD/MM/Year)</b></td>
                <td colspan="2"><b>Details</b></td>
            </tr>

            <tr>
                <td colspan="2">{{ $cardiac_assessment->operations_hospital_one ?? '--' }}</td>
                <td colspan="2">{{ $cardiac_assessment->angiograms_date_one ?? '--' }}</td>
                <td colspan="2">{{ $cardiac_assessment->angiograms_details_one ?? '--' }}</td>
            </tr>
            <tr>
                <td colspan="2">{{ $cardiac_assessment->operations_hospital_two ?? '--' }}</td>
                <td colspan="2">{{ $cardiac_assessment->angiograms_date_two ?? '--' }}</td>
                <td colspan="2">{{ $cardiac_assessment->angiograms_details_two ?? '--' }}</td>
            </tr>
            <tr>
                <td colspan="2">{{ $cardiac_assessment->operations_hospital_three ?? '--' }}</td>
                <td colspan="2">{{ $cardiac_assessment->angiograms_date_three ?? '--' }}</td>
                <td colspan="2">{{ $cardiac_assessment->angiograms_details_three ?? '--' }}</td>
            </tr>
            <tr>
                <td colspan="2">{{ $cardiac_assessment->operations_hospital_four ?? '--' }}</td>
                <td colspan="2">{{ $cardiac_assessment->angiograms_date_four ?? '--' }}</td>
                <td colspan="2">{{ $cardiac_assessment->angiograms_details_four ?? '--' }}</td>
            </tr>
            <tr>
                <td colspan="2">{{ $cardiac_assessment->operations_hospital_five ?? '--' }}</td>
                <td colspan="2">{{ $cardiac_assessment->angiograms_date_five ?? '--' }}</td>
                <td colspan="2">{{ $cardiac_assessment->angiograms_details_five ?? '--' }}</td>
            </tr>
        </tbody>
    </table>

    <table class="table table-bordered">
        <tbody>
            {{-- Physical Examination --}}
            <tr>
                <th colspan="6" style="text-align:left;">PHYSICAL EXAMINATION</th>
            </tr>

            {{-- General --}}
            <tr>
                <td colspan="6">
                    <b>A - General:</b> {{ @$cardiac_assessment->physical_examination_a ?? '--' }}
                </td>
            </tr>

            {{-- Built --}}
            <tr>
                <td colspan="6">
                    <b>Built:</b>
                    @if(!empty($cardiac_assessment->physical_exam_built))
                        @php
                            $builtArray = is_array($cardiac_assessment->physical_exam_built) 
                                ? $cardiac_assessment->physical_exam_built 
                                : explode(',', $cardiac_assessment->physical_exam_built);
                        @endphp
                        {{ implode(', ', $builtArray) }}
                    @else
                        --
                    @endif
                </td>
            </tr>

            {{-- Pallor --}}
            <tr>
                <td colspan="6">
                    <b>Pallor:</b>
                    @if(!empty($cardiac_assessment->physical_exam_pallor))
                        @php
                            $pallorArray = is_array($cardiac_assessment->physical_exam_pallor) 
                                ? $cardiac_assessment->physical_exam_pallor 
                                : explode(',', $cardiac_assessment->physical_exam_pallor);
                        @endphp
                        {{ implode(', ', $pallorArray) }}
                    @else
                        --
                    @endif
                </td>
            </tr>

            {{-- Pedal Oedema & Related --}}
            <tr>
                <td colspan="6">
                    <b>Pedal Oedema & Related:</b>
                    @if(!empty($cardiac_assessment->physical_exam_pedal_oedema))
                        @php
                            $pedalArray = is_array($cardiac_assessment->physical_exam_pedal_oedema) 
                                ? $cardiac_assessment->physical_exam_pedal_oedema 
                                : explode(',', $cardiac_assessment->physical_exam_pedal_oedema);
                        @endphp
                        {{ implode(', ', $pedalArray) }}
                    @else
                        --
                    @endif

                    @if(!empty($cardiac_assessment->physical_exam_pedal_text))
                        | Others: {{ $cardiac_assessment->physical_exam_pedal_text }}
                    @endif
                </td>
            </tr>

            {{-- Cyanosis --}}
            <tr>
                <td colspan="6">
                    <b>Cyanosis:</b>
                    @if(!empty($cardiac_assessment->physical_exam_cyanosis))
                        @php
                            $cyanosisArray = is_array($cardiac_assessment->physical_exam_cyanosis) 
                                ? $cardiac_assessment->physical_exam_cyanosis 
                                : explode(',', $cardiac_assessment->physical_exam_cyanosis);
                        @endphp
                        {{ implode(', ', $cyanosisArray) }}
                    @else
                        --
                    @endif
                </td>
            </tr>

            {{-- Clubbing --}}
            <tr>
                <td colspan="6">
                    <b>Clubbing:</b>
                    @if(!empty($cardiac_assessment->physical_exam_clubbing))
                        @php
                            $clubbingArray = is_array($cardiac_assessment->physical_exam_clubbing) 
                                ? $cardiac_assessment->physical_exam_clubbing 
                                : explode(',', $cardiac_assessment->physical_exam_clubbing);
                        @endphp
                        {{ implode(', ', $clubbingArray) }}
                    @else
                        --
                    @endif
                </td>
            </tr>

            {{-- Lymph Adenopathy --}}
            <tr>
                <td colspan="6">
                    <b>Lymph Adenopathy:</b>
                    @if(!empty($cardiac_assessment->physical_exam_adenopthay))
                        @php
                            $adenopathyArray = is_array($cardiac_assessment->physical_exam_adenopthay) 
                                ? $cardiac_assessment->physical_exam_adenopthay 
                                : explode(',', $cardiac_assessment->physical_exam_adenopthay);
                        @endphp
                        {{ implode(', ', $adenopathyArray) }}
                    @else
                        --
                    @endif
                </td>
            </tr>

            {{-- JVP --}}
            <tr>
                <td colspan="6">
                    <b>JVP:</b>
                    @if(!empty($cardiac_assessment->physical_exam_jvp))
                        @php
                            $jvpArray = is_array($cardiac_assessment->physical_exam_jvp) 
                                ? $cardiac_assessment->physical_exam_jvp 
                                : explode(',', $cardiac_assessment->physical_exam_jvp);
                        @endphp
                        {{ implode(', ', $jvpArray) }}
                    @else
                        --
                    @endif
                </td>
            </tr>
        </tbody>
    </table>

    <table class="table table-bordered">
        <tbody>
            {{-- Peripheral Pulses --}}
            <tr>
                <th colspan="6" style="text-align:left;">B - PERIPHERAL PULSES</th>
            </tr>

            {{-- All normal --}}
            <tr>
                <td colspan="6">
                    <b>All peripheral pulses normal:</b> 
                    {{ @$cardiac_assessment->peripheral_pulses_normal == 'No' ? 'Yes' : 'No' }}
                </td>
            </tr>

            {{-- Femoral --}}
            <tr>
                <td colspan="2"><b>Femoral</b></td>
                <td><b>Right:</b> {{ @$cardiac_assessment->b_peripheral_femoral_right ?? '--' }}</td>
                <td><b>Left:</b> {{ @$cardiac_assessment->b_peripheral_femoral_left ?? '--' }}</td>
                <td colspan="2" rowspan="7">
                    <b>Legend:</b><br>
                    1. Normal <br>
                    2. Bounding / Hyperkinetic <br>
                    3. Feeble / Hypokinetic <br>
                    4. Absent <br>
                    5. Bruit present
                </td>
            </tr>

            {{-- Popliteal --}}
            <tr>
                <td colspan="2"><b>Popliteal</b></td>
                <td><b>Right:</b> {{ @$cardiac_assessment->b_peripheral_popliteal_right ?? '--' }}</td>
                <td><b>Left:</b> {{ @$cardiac_assessment->b_peripheral_popliteal_left ?? '--' }}</td>
            </tr>

            {{-- Posttibial --}}
            <tr>
                <td colspan="2"><b>Posttibial</b></td>
                <td><b>Right:</b> {{ @$cardiac_assessment->b_peripheral_posttibial_right ?? '--' }}</td>
                <td><b>Left:</b> {{ @$cardiac_assessment->b_peripheral_posttibial_left ?? '--' }}</td>
            </tr>

            {{-- Dorsalis pedis --}}
            <tr>
                <td colspan="2"><b>Dorsalis pedis</b></td>
                <td><b>Right:</b> {{ @$cardiac_assessment->b_peripheral_dorsalis_right ?? '--' }}</td>
                <td><b>Left:</b> {{ @$cardiac_assessment->b_peripheral_dorsalis_left ?? '--' }}</td>
            </tr>

            {{-- Brachial --}}
            <tr>
                <td colspan="2"><b>Brachial</b></td>
                <td><b>Right:</b> {{ @$cardiac_assessment->b_peripheral_brachial_right ?? '--' }}</td>
                <td><b>Left:</b> {{ @$cardiac_assessment->b_peripheral_brachial_left ?? '--' }}</td>
            </tr>

            {{-- Radial --}}
            <tr>
                <td colspan="2"><b>Radial</b></td>
                <td><b>Right:</b> {{ @$cardiac_assessment->b_peripheral_radial_right ?? '--' }}</td>
                <td><b>Left:</b> {{ @$cardiac_assessment->b_peripheral_radial_left ?? '--' }}</td>
            </tr>

            {{-- Carotid --}}
            <tr>
                <td colspan="2"><b>Carotid</b></td>
                <td><b>Right:</b> {{ @$cardiac_assessment->b_peripheral_carotid_right ?? '--' }}</td>
                <td><b>Left:</b> {{ @$cardiac_assessment->b_peripheral_carotid_left ?? '--' }}</td>
            </tr>
        </tbody>
    </table>

    <table class="table table-bordered">
        <tbody>
            {{-- Precordial Palpation --}}
            <tr>
                <th colspan="6" style="text-align:left;">PRECORDIAL PALPATION</th>
            </tr>

            {{-- Apex Beat --}}
            <tr>
                <td colspan="6">
                    <b>C - Apex Beat:</b> 
                    {{ @$cardiac_assessment->normal_location_feel == 'No' ? 'Normal Location & Feel' : '--' }}
                </td>
            </tr>

            {{-- Left Sided --}}
            <tr>
                <td colspan="2"><b>Left sided:</b></td>
                <td colspan="2">{{ @$cardiac_assessment->c_apex_beat_left_text ?? '--' }}</td>
                <td colspan="2" rowspan="3">
                    <b>Legend:</b><br>
                    1. Medial to mid clavicular line <br>
                    2. Lateral to mid clavicular line
                </td>
            </tr>

            {{-- Right Sided --}}
            <tr>
                <td colspan="2"><b>Right sided:</b></td>
                <td colspan="2">{{ @$cardiac_assessment->c_apex_beat_right_text ?? '--' }}</td>
            </tr>

            {{-- Type --}}
            <tr>
                <td colspan="2"><b>Type:</b></td>
                <td colspan="2">
                    @if(!empty($cardiac_assessment->c_apex_beat_select))
                        @php
                            $apexType = is_array($cardiac_assessment->c_apex_beat_select) 
                                ? $cardiac_assessment->c_apex_beat_select 
                                : explode(',', $cardiac_assessment->c_apex_beat_select);
                        @endphp
                        {{ implode(', ', $apexType) }}
                    @else
                        --
                    @endif
                </td>
            </tr>

            {{-- Left parasternal lift --}}
            <tr>
                <td colspan="6">
                    <b>D - Left parasternal lift:</b> 
                    @if(!empty($cardiac_assessment->d_left_parasternal))
                        @php
                            $parasternal = is_array($cardiac_assessment->d_left_parasternal) 
                                ? $cardiac_assessment->d_left_parasternal 
                                : explode(',', $cardiac_assessment->d_left_parasternal);
                        @endphp
                        {{ implode(', ', $parasternal) }}
                    @else
                        --
                    @endif
                </td>
            </tr>
        </tbody>
    </table>

    <table class="table table-bordered">
        <tbody>
            {{-- E-Thrill --}}
            <tr>
                <th colspan="6" style="text-align:left;">E-THRILL</th>
            </tr>
            <tr>
                <td colspan="2">
                    <b>Absent:</b> {{ $cardiac_assessment->e_thrill_absent ?? '--' }}
                </td>
                <td colspan="2">
                    <b>Remarks:</b> {{ $cardiac_assessment->e_thrill_absent_text ?? '--' }}
                </td>
                <td colspan="2" rowspan="5">
                    <b>Note:</b><br>
                    1. Systolic <br>
                    2. Diastolic
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <b>Over Mitral:</b> {{ $cardiac_assessment->e_thrill_over ?? '--' }}
                </td>
                <td colspan="2">
                    {{ $cardiac_assessment->e_thrill_over_text ?? '--' }}
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <b>Over Tricuspid:</b> {{ $cardiac_assessment->e_thrill_tricuspid ?? '--' }}
                </td>
                <td colspan="2">
                    {{ $cardiac_assessment->e_thrill_tricuspid_text ?? '--' }}
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <b>Over Aortic:</b> {{ $cardiac_assessment->e_thrill_aortic ?? '--' }}
                </td>
                <td colspan="2">
                    {{ $cardiac_assessment->e_thrill_aortic_text ?? '--' }}
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <b>Over Pulmonary:</b> {{ $cardiac_assessment->e_thrill_pulmonary ?? '--' }}
                </td>
                <td colspan="2">
                    {{ $cardiac_assessment->e_thrill_pulmonary_text ?? '--' }}
                </td>
            </tr>

            {{-- F-Palpable --}}
            @php
                $f_palpable = !empty($cardiac_assessment->f_palpable_select)
                    ? (is_array($cardiac_assessment->f_palpable_select)
                        ? $cardiac_assessment->f_palpable_select
                        : explode(',', $cardiac_assessment->f_palpable_select))
                    : [];
            @endphp
            <tr>
                <th colspan="6" style="text-align:left;">F-PALPABLE</th>
            </tr>
            <tr>
                <td colspan="6">
                    Absent: {{ in_array('Absent', $f_palpable) ? 'Yes' : 'No' }} <br>
                    Present: {{ in_array('Pesent', $f_palpable) ? 'Yes' : 'No' }}
                </td>
            </tr>

            {{-- Precordial Auscultation --}}
            <tr>
                <th colspan="6" style="text-align:left;">PRECORDIAL AUSCULTATION</th>
            </tr>
            <tr>
                <td colspan="6">
                    <b>G-Heart Sounds:</b> {{ $cardiac_assessment->normal_heart_sounds ?? '--' }}
                </td>
            </tr>
            <tr>
                <td>S1</td>
                <td colspan="2">{{ $cardiac_assessment->normal_heart_sounds_s1_text ?? '--' }} ({{ $cardiac_assessment->normal_heart_sounds_s1 ?? '--' }})</td>
                <td>S3</td>
                <td>{{ $cardiac_assessment->normal_heart_sounds_s3_text ?? '--' }} ({{ $cardiac_assessment->normal_heart_sounds_s3 ?? '--' }})</td>
                <td rowspan="4">
                    <b>Status:</b><br>
                    1. Absent <br>
                    2. Audible
                </td>
            </tr>
            <tr>
                <td>A2</td>
                <td colspan="2">{{ $cardiac_assessment->normal_heart_sounds_a2_text ?? '--' }} ({{ $cardiac_assessment->normal_heart_sounds_a2 ?? '--' }})</td>
                <td>S4</td>
                <td>{{ $cardiac_assessment->normal_heart_sounds_s4_text ?? '--' }} ({{ $cardiac_assessment->normal_heart_sounds_s4 ?? '--' }})</td>
            </tr>
            <tr>
                <td>P2</td>
                <td colspan="2">{{ $cardiac_assessment->normal_heart_sounds_p2_text ?? '--' }} ({{ $cardiac_assessment->normal_heart_sounds_p2 ?? '--' }})</td>
                <td>Opening Snap</td>
                <td>{{ $cardiac_assessment->normal_heart_sounds_snap_text ?? '--' }} ({{ $cardiac_assessment->normal_heart_sounds_snap ?? '--' }})</td>
            </tr>
            <tr>
                <td colspan="3"></td>
                <td>Click</td>
                <td>{{ $cardiac_assessment->normal_heart_sounds_click_text ?? '--' }} ({{ $cardiac_assessment->normal_heart_sounds_click ?? '--' }})</td>
            </tr>


            <tr>
                <td colspan="6"></td>
            </tr>
            <tr>
                <td colspan="6">
                    <b>H-Murmurs:</b> {{ ucfirst($cardiac_assessment->h_murmurs ?? '--') }}
                </td>
            </tr>

            <tr>
                <td><b>Mitral area:</b> {{ $cardiac_assessment->h_murmurs_mitral ?? '--' }}</td>
                <td>{{ $cardiac_assessment->h_murmurs_mitral_text ?? '--' }}</td>

                <td><b>1. Systolic:</b> {{ $cardiac_assessment->h_murmurs_systolic ?? '--' }}</td>
                <td>{{ $cardiac_assessment->h_murmurs_systolic_text ?? '--' }}</td>

                <td colspan="2" rowspan="4">
                    1. Grade 1 <br>
                    2. Grade 2 <br>
                    3. Grade 3 <br>
                    4. Grade 4
                </td>
            </tr>

            <tr>
                <td><b>Aortic:</b> {{ $cardiac_assessment->h_murmurs_aortic ?? '--' }}</td>
                <td>{{ $cardiac_assessment->h_murmurs_aortic_text ?? '--' }}</td>

                <td><b>2. Diastolic:</b> {{ $cardiac_assessment->h_murmurs_diastolic ?? '--' }}</td>
                <td>{{ $cardiac_assessment->h_murmurs_diastolic_text ?? '--' }}</td>
            </tr>

            <tr>
                <td><b>Pulmonary area:</b> {{ $cardiac_assessment->h_murmurs_pulmonary ?? '--' }}</td>
                <td>{{ $cardiac_assessment->h_murmurs_pulmonary_text ?? '--' }}</td>

                <td><b>3. Continuous:</b> {{ $cardiac_assessment->h_murmurs_contineous ?? '--' }}</td>
                <td>{{ $cardiac_assessment->h_murmurs_contineous_text ?? '--' }}</td>
            </tr>

            
            <tr>
                <td colspan="6"></td>
            </tr>

            <tr>
                <th colspan="6" style="text-align:left;">M- REMARKS</th>
            </tr>
            <tr>
                <td colspan="6">
                    {!! nl2br(e($cardiac_assessment->m_remarks ?? '--')) !!}
                </td>
            </tr>

            <tr>
                <th colspan="6" style="text-align:left;">ECHO DOPPLER</th>
            </tr>
            <tr>
                <td colspan="2"><b>Date:</b> {{ @$cardiac_assessment->echo_doppler_date ? \Carbon\Carbon::parse($cardiac_assessment->echo_doppler_date)->format('d-m-Y') : '--' }}</td>
                <td colspan="4"><b>Findings:</b> {!! nl2br(e($cardiac_assessment->echo_doppler_text ?? '--')) !!}</td>
            </tr>

            <tr>
                <th colspan="6" style="text-align:left;">TEE</th>
            </tr>
            <tr>
                <td colspan="2"><b>Date:</b> {{ @$cardiac_assessment->tee_date ? \Carbon\Carbon::parse($cardiac_assessment->tee_date)->format('d-m-Y') : '--' }}</td>
                <td colspan="4"><b>Findings:</b> {!! nl2br(e($cardiac_assessment->tee_text ?? '--')) !!}</td>
            </tr>

            <tr>
                <th colspan="6" style="text-align:left;">VASCULAR DOPPLER</th>
            </tr>
            <tr>
                <td colspan="2"><b>Date:</b> {{ @$cardiac_assessment->vascular_doppler_date ? \Carbon\Carbon::parse($cardiac_assessment->vascular_doppler_date)->format('d-m-Y') : '--' }}</td>
                <td colspan="4"><b>Findings:</b> {!! nl2br(e($cardiac_assessment->vascular_doppler_text ?? '--')) !!}</td>
            </tr>

            <tr>
                <th colspan="6" style="text-align:left;">STRESS ECHO</th>
            </tr>
            <tr>
                <td colspan="2"><b>Date:</b> {{ @$cardiac_assessment->stress_echo_date ? \Carbon\Carbon::parse($cardiac_assessment->stress_echo_date)->format('d-m-Y') : '--' }}</td>
                <td colspan="4"><b>Findings:</b> {!! nl2br(e($cardiac_assessment->stress_echo_text ?? '--')) !!}</td>
            </tr>

            <tr>
                <th colspan="6" style="text-align:left;">EPS</th>
            </tr>
            <tr>
                <td colspan="2"><b>Date:</b> {{ @$cardiac_assessment->eps_date ? \Carbon\Carbon::parse($cardiac_assessment->eps_date)->format('d-m-Y') : '--' }}</td>
                <td colspan="4"><b>Findings:</b> {!! nl2br(e($cardiac_assessment->eps_text ?? '--')) !!}</td>
            </tr>

            <tr>
                <th colspan="6" style="text-align:left;">CAG / PAG</th>
            </tr>
            <tr>
                <td colspan="2"><b>Date:</b> {{ @$cardiac_assessment->cag_date ? \Carbon\Carbon::parse($cardiac_assessment->cag_date)->format('d-m-Y') : '--' }}</td>
                <td colspan="4"><b>Findings:</b> {!! nl2br(e($cardiac_assessment->cag_text ?? '--')) !!}</td>
            </tr>

            <tr>
                <th colspan="6" style="text-align:left;">CARDIAC CATH</th>
            </tr>
            <tr>
                <td colspan="2"><b>Date:</b> {{ @$cardiac_assessment->cardiac_date ? \Carbon\Carbon::parse($cardiac_assessment->cardiac_date)->format('d-m-Y') : '--' }}</td>
                <td colspan="4"><b>Findings:</b> {!! nl2br(e($cardiac_assessment->cardiac_text ?? '--')) !!}</td>
            </tr>

            <tr>
                <th colspan="6" style="text-align:left;">ENDOSCOPY</th>
            </tr>
            <tr>
                <td colspan="2"><b>Date:</b> {{ @$cardiac_assessment->endoscopy_date ? \Carbon\Carbon::parse($cardiac_assessment->endoscopy_date)->format('d-m-Y') : '--' }}</td>
                <td colspan="4"><b>Findings:</b> {!! nl2br(e($cardiac_assessment->endoscopy_text ?? '--')) !!}</td>
            </tr>

            <tr>
                <th colspan="6" style="text-align:left;">ULTRA SOUND</th>
            </tr>
            <tr>
                <td colspan="2"><b>Date:</b> {{ @$cardiac_assessment->ultra_sound_date ? \Carbon\Carbon::parse($cardiac_assessment->ultra_sound_date)->format('d-m-Y') : '--' }}</td>
                <td colspan="4"><b>Findings:</b> {!! nl2br(e($cardiac_assessment->ultra_sound_text ?? '--')) !!}</td>
            </tr>

            <tr>
                <th colspan="6" style="text-align:left;">CT / MRI</th>
            </tr>
            <tr>
                <td colspan="2"><b>Date:</b> {{ @$cardiac_assessment->mri_date ? \Carbon\Carbon::parse($cardiac_assessment->mri_date)->format('d-m-Y') : '--' }}</td>
                <td colspan="4"><b>Findings:</b> {!! nl2br(e($cardiac_assessment->mri_text ?? '--')) !!}</td>
            </tr>

            <tr>
                <th colspan="6" style="text-align:left;">ANY OTHER NOTES (Intervention/procedure/Surgery)</th>
            </tr>
            <tr>
                <td colspan="6">
                    {!! nl2br(e($cardiac_assessment->intervention_text ?? '--')) !!}
                </td>
            </tr>



            <tr>
                <td colspan="6"></td>
            </tr>

            <tr>
                <th rowspan="2">Doctor</th>
                <th>Signature</th>
                <th>Name</th>
                <th>Emp. ID</th>
                <th>Date</th>
                <th>Time</th>
            </tr>
            <tr>
                <td>{{ $cardiac_assessment->last_doctor_signature ?? '--' }}</td>
                <td>{{ $cardiac_assessment->doctor_name_final ?? '--' }}</td>
                <td>{{ $cardiac_assessment->doctor_emp ?? '--' }}</td>
                <td>{{ $cardiac_assessment->doctor_date ? \Carbon\Carbon::parse($cardiac_assessment->doctor_date)->format('d-m-Y') : '--' }}</td>
                <td>{{ $cardiac_assessment->doctor_time ?? '--' }}</td>
            </tr>

            <tr>
                <td><b>Consultant</b></td>
                <td>{{ $cardiac_assessment->consultant_signature ?? '--' }}</td>
                <td>{{ $cardiac_assessment->consultant_name ?? '--' }}</td>
                <td>{{ $cardiac_assessment->consultant_emp ?? '--' }}</td>
                <td>{{ $cardiac_assessment->consultant_date ? \Carbon\Carbon::parse($cardiac_assessment->consultant_date)->format('d-m-Y') : '--' }}</td>
                <td>{{ $cardiac_assessment->consultant_time ?? '--' }}</td>
            </tr>
        </tbody>
    </table>



    {{-- Footer Section --}}
    <section class="footer-table">
        <table style="width:100%" class="table">
            <tbody>
                <tr>
                    <td style="text-align:left;border:none;width:70%">
                        <strong>Staff ID:</strong> {{ $userInfo->user_code ?? '' }},
                        <strong>Printing Date & Time:</strong> {{ date('d/m/Y h:ia') }}
                    </td>
                    <td style="text-align:right;border:none;width:30%">
                        <strong>Powered By: NEXTGEN IT</strong>
                    </td>
                </tr>
            </tbody>
        </table>
    </section>

</body>

</html>
