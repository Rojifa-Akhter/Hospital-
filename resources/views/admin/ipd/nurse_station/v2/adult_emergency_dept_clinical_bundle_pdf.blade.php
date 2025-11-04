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
            font-size: 16px;
        }

        .table {
            border-collapse: collapse;
            width: 100%;
        }

        .table-bordered {
            border: 1px solid #333;
        }

        td {
            font-size: 15px;
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
            position: bottom;
            bottom: 0px;
            width: 95%;

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
                    @php
                        $substanceMisuse = json_decode($adult_emergency_dept->substance_misuse ?? '[]', true) ?? [];
                        $aVisually = json_decode($adult_emergency_dept->a_visually ?? '[]', true) ?? [];
                        $oxygenReq = json_decode($adult_emergency_dept->oxygen_req ?? '[]', true) ?? [];
                        $aSounds = json_decode($adult_emergency_dept->a_sounds ?? '[]', true) ?? [];
                        $bVisually = json_decode($adult_emergency_dept->b_visually ?? '[]', true) ?? [];
                        $unequal = json_decode($adult_emergency_dept->unequal ?? '[]', true) ?? [];
                        $bSounds = json_decode($adult_emergency_dept->b_sounds ?? '[]', true) ?? [];
                        $rAir = json_decode($adult_emergency_dept->r_air ?? '[]', true) ?? [];
                        $absent = json_decode($adult_emergency_dept->absent ?? '[]', true) ?? [];
                        $cVisually = json_decode($adult_emergency_dept->c_visually ?? '[]', true) ?? [];
                        $cSounds = json_decode($adult_emergency_dept->c_sounds ?? '[]', true) ?? [];
                        $exposure = json_decode($adult_emergency_dept->exposure ?? '[]', true) ?? [];
                    @endphp

                    <table class="table table-bordered">
                        <tr>
                            <td><b>Medico-Legal case:</b></td>
                            <td>{{ @$adult_emergency_dept->medico }}</td>
                            <td><b>Case No.:</b></td>
                            <td>{{ @$adult_emergency_dept->case_no }}</td>
                        </tr>
                        <tr>
                            <td><b>Mode of Arrival:</b></td>
                            <td>{{ @$adult_emergency_dept->arrival }}</td>
                            <td><b>Ambulation:</b></td>
                            <td>{{ @$adult_emergency_dept->ambulation }}</td>
                        </tr>
                        <tr>
                            <td>
                                <b>Name of attendant:</b> {{ @$adult_emergency_dept->sign }}
                                <br>
                                <b>Signature:</b> {{ @$adult_emergency_dept->h_sign }}
                            </td>
                            <td>
                                <b>Relationship with attendant:</b> {{ @$adult_emergency_dept->r_attendant }}
                            </td>
                            <td colspan="2">
                                <b>Contact Number:</b> {{ @$adult_emergency_dept->c_number }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <b>Presenting Complaints:</b><br>
                                {{ @$adult_emergency_dept->p_complaints }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"><b>Triage Observations</b></td>
                            <td><b>Traumatic Injuries:</b></td>
                            <td>{{ @$adult_emergency_dept->traumatic }}</td>
                        </tr>

                    </table>
                    <table width="100%" border="1"
                        style="margin-top:10px; border-collapse:collapse; text-align:center;">
                        <tr>
                            <th>Time</th>
                            <th>RR/min</th>
                            <th>SpO2 / FiO2</th>
                            <th>HR/min</th>
                            <th>BP (mmHg)</th>
                            <th>AVPU</th>
                            <th>RBS (mmol/L)</th>
                            <th>Temp (°F)</th>
                            <th>Pain (NRS)</th>
                            <th>TEWS</th>
                        </tr>
                        <tr>
                            <td>{{ @$adult_emergency_dept->to_time }}</td>
                            <td>{{ @$adult_emergency_dept->to_rr }}</td>
                            <td>{{ @$adult_emergency_dept->to_spo2 }}</td>
                            <td>{{ @$adult_emergency_dept->to_hr }}</td>
                            <td>{{ @$adult_emergency_dept->to_bp }}</td>
                            <td>{{ @$adult_emergency_dept->to_avpu }}</td>
                            <td>{{ @$adult_emergency_dept->to_rbs }}</td>
                            <td>{{ @$adult_emergency_dept->to_temp }}</td>
                            <td>{{ @$adult_emergency_dept->to_pain }}</td>
                            <td>{{ @$adult_emergency_dept->to_tews }}</td>
                        </tr>
                    </table>
                    <div style="display:flex;gap:20px;">

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th colspan="8" style="text-align: center">ADULT TEWS
                                    </th>
                                </tr>
                                <tr>
                                    <th>OLDER THAN 12 YEARS <br> TALLER THAN 150cm</th>
                                    <th>3</th>
                                    <th>2</th>
                                    <th>1</th>
                                    <th>0</th>
                                    <th>1</th>
                                    <th>2</th>
                                    <th>3</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="background: #00bfff"><b>Mobility</b></td>
                                    <td style="background: #b8dfff"></td>
                                    <td style="background: #b8dfff"></td>
                                    <td style="background: #b8dfff"></td>
                                    <td data-value="0">Walking</td>
                                    <td data-value="1">With Help</td>
                                    <td data-value="2">Stretcher/Immobile</td>
                                    <td style="background: #b8dfff"></td>
                                </tr>
                                <tr>
                                    <td style="background: #00bfff"><b>RR</b></td>
                                    <td style="background: #b8dfff"></td>
                                    <td data-value="2">less than 9</td>
                                    <td style="background: #b8dfff"></td>
                                    <td data-value="0">9-14</td>
                                    <td data-value="1">15-20</td>
                                    <td data-value="2">21-29</td>
                                    <td data-value="3">More than 29</td>
                                </tr>
                                <tr>
                                    <td style="background: #00bfff"><b>HR</b></td>
                                    <td style="background: #b8dfff"></td>
                                    <td data-value="2">Less than 41</td>
                                    <td data-value="1">41-50</td>
                                    <td data-value="0">51-100</td>
                                    <td data-value="1">101-110</td>
                                    <td data-value="2">111-129</td>
                                    <td data-value="3">more than 129</td>
                                </tr>
                                <tr>
                                    <td style="background: #00bfff"><b>SBP</b></td>
                                    <td data-value="3">Less than 71</td>
                                    <td data-value="2">71-80</td>
                                    <td data-value="1">81-100</td>
                                    <td data-value="0">101-199</td>
                                    <td style="background: #b8dfff"></td>
                                    <td data-value="2">more than 199</td>
                                    <td style="background: #b8dfff"></td>
                                </tr>
                                <tr>
                                    <td style="background: #00bfff"><b>Temp</b></td>
                                    <td style="background: #b8dfff"></td>
                                    <td data-value="2">Cold or Under &deg;95</td>
                                    <td style="background: #b8dfff"></td>
                                    <td data-value="0">&deg;95-&deg;101</td>
                                    <td style="background: #b8dfff"></td>
                                    <td data-value="2">Hot or Over &deg;101</td>
                                    <td style="background: #b8dfff"></td>
                                </tr>
                                <tr>
                                    <td style="background:#00bfff"><b>AVPU</b></td>
                                    <td style="background: #b8dfff"></td>
                                    <td data-value="2">Confused</td>
                                    <td style="background: #b8dfff"></td>
                                    <td data-value="0">Alert</td>
                                    <td data-value="1">Reacts to Voice</td>
                                    <td data-value="2">Reacts to Pain</td>
                                    <td data-value="3">Unresponsive</td>
                                </tr>
                                <tr>
                                    <td style="background: #00bfff"><b>Trauma</b></td>
                                    <td style="background: #b8dfff"></td>
                                    <td style="background: #b8dfff"></td>
                                    <td data-value="1">Yes</td>
                                    <td data-value="0">No</td>
                                    <td style="background: #b8dfff"></td>
                                    <td style="background: #b8dfff"></td>
                                    <td style="background: #b8dfff"></td>

                                </tr>
                            </tbody>
                        </table>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th colspan="3" style="text-align: center;background:#00bfff">SATS
                                        Triage Priority</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="level level1">Level 1</td>
                                    <td>TWES 7 or more</td>
                                    <td><input type="checkbox" id="level1" name="sats_triage[]" value="level1"
                                            {{ in_array('level1', json_decode($adult_emergency_dept->sats_triage ?? '[]', true) ?? []) ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="level level2">Level 2</td>
                                    <td>TWES 5 or 6</td>
                                    <td><input type="checkbox" id="level2" name="sats_triage[]" value="level2"
                                            {{ in_array('level2', json_decode($adult_emergency_dept->sats_triage ?? '[]', true) ?? []) ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="level level3">Level 3</td>
                                    <td>TWES 3 or 4</td>
                                    <td><input type="checkbox" id="level3" name="sats_triage[]" value="level3"
                                            {{ in_array('level3', json_decode($adult_emergency_dept->sats_triage ?? '[]', true) ?? []) ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="level level4">Level 4</td>
                                    <td>TWES 0,1 or 2</td>
                                    <td><input type="checkbox" id="level4" name="sats_triage[]" value="level4"
                                            {{ in_array('level4', json_decode($adult_emergency_dept->sats_triage ?? '[]', true) ?? []) ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="level level5">Level 5</td>
                                    <td>Deceased</td>
                                    <td><input type="checkbox" id="level5" name="sats_triage[]" value="level5"
                                            {{ in_array('level5', json_decode($adult_emergency_dept->sats_triage ?? '[]', true) ?? []) ? 'checked' : '' }}>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    @php
                        $substanceMisuse = json_decode($adult_emergency_dept->substance_misuse ?? '[]', true) ?? [];
                        $aVisually = json_decode($adult_emergency_dept->a_visually ?? '[]', true) ?? [];
                        $oxygenReq = json_decode($adult_emergency_dept->oxygen_req ?? '[]', true) ?? [];
                        $aSounds = json_decode($adult_emergency_dept->a_sounds ?? '[]', true) ?? [];
                        $bVisually = json_decode($adult_emergency_dept->b_visually ?? '[]', true) ?? [];
                        $unequal = json_decode($adult_emergency_dept->unequal ?? '[]', true) ?? [];
                        $bSounds = json_decode($adult_emergency_dept->b_sounds ?? '[]', true) ?? [];
                        $rAir = json_decode($adult_emergency_dept->r_air ?? '[]', true) ?? [];
                        $absent = json_decode($adult_emergency_dept->absent ?? '[]', true) ?? [];
                        $cVisually = json_decode($adult_emergency_dept->c_visually ?? '[]', true) ?? [];
                        $cSounds = json_decode($adult_emergency_dept->c_sounds ?? '[]', true) ?? [];
                        $exposure = json_decode($adult_emergency_dept->exposure ?? '[]', true) ?? [];
                        $medSource = json_decode($adult_emergency_dept->med_source ?? '[]', true) ?? [];
                        $medDisposition = json_decode($adult_emergency_dept->med_disposition ?? '[]', true) ?? [];
                    @endphp

                    <table class="table table-bordered">
                        <tr>
                            <td colspan="7"><strong>Triage Sign-off:</strong></td>
                        </tr>
                        <tr>
                            <th colspan="2">Name</th>
                            <th>Signature</th>
                            <th colspan="2">Designation</th>
                            <th>Emp. ID</th>
                            <th>Time</th>
                        </tr>
                        <tr>
                            <td colspan="2">{{ @$adult_emergency_dept->ts_name }}
                            </td>
                            <td>{{ @$adult_emergency_dept->ts_sign }}</td>
                            <td colspan="2">{{ @$adult_emergency_dept->ts_design }}</td>
                            <td>{{ @$adult_emergency_dept->ts_epmid }}</td>
                            <td>{{ @$adult_emergency_dept->ts_time }}</td>
                        </tr>

                        <tr>
                            <td colspan="7"><strong>Presenting History:</strong></td>
                        </tr>
                        <tr>
                            <td colspan="7">
                                {{ @$adult_emergency_dept->pre_history }}
                            </td>
                        </tr>

                        <tr>
                            <td colspan="7"><strong>Significant Other History:</strong></td>
                        </tr>
                        <tr>
                            <td colspan="7">
                                {{ @$adult_emergency_dept->sf_history }}
                            </td>
                        </tr>

                        <tr>
                            <td colspan="7"><strong>Substance misuse:</strong><br>
                                @foreach (['None', 'Smoking', 'Tobacco', 'Betel leaf/nut', 'Ethanol', 'Recreational drug'] as $opt)
                                    <label><input type="checkbox" name="substance_misuse[]"
                                            value="{{ $opt }}"
                                            {{ in_array($opt, $substanceMisuse) ? 'checked' : '' }}>
                                        {{ $opt }}</label>&nbsp;
                                @endforeach
                            </td>
                        </tr>

                        <tr>
                            <td colspan="7"><strong>ED Plan:</strong></td>
                        </tr>
                        <tr>
                            <td colspan="7">
                                {{ @$adult_emergency_dept->ed_plan }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">Initial Assessment:</td>
                            <td colspan="3"></td>
                            <td>Time of Assessment:</td>
                        </tr>

                        {{-- AIRWAY --}}
                        <tr>
                            <td colspan="3">Assessment</td>
                            <td colspan="3" style="text-align: center">
                                <strong>AIRWAY</strong>
                            </td>
                            <td>Management</td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <b>Visually:</b>
                                @foreach (['Clear', 'Obstructed'] as $opt)
                                    <label>
                                        <input type="checkbox" name="a_visually[]" value="{{ $opt }}"
                                            {{ in_array($opt, $aVisually) ? 'checked' : '' }}>
                                        {{ $opt }}
                                    </label>&nbsp;
                                @endforeach
                            </td>
                            <td colspan="4">
                                <b>Oxygen requirement:</b>
                                @foreach (['No requirement', 'Nasal cannula or facemask', 'Non-invasive ventilation', 'Intubation'] as $opt)
                                    <label>
                                        <input type="checkbox" name="oxygen_req[]" value="{{ $opt }}"
                                            {{ in_array($opt, $oxygenReq) ? 'checked' : '' }}>
                                        {{ $opt }}
                                    </label>&nbsp;
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <td colspan="7"><b>Sounds:</b>
                                @foreach (['Clear', 'Stridor', 'Snoring', 'Gurgling'] as $opt)
                                    <label>
                                        <input type="checkbox" name="a_sounds[]" value="{{ $opt }}"
                                            {{ in_array($opt, $aSounds) ? 'checked' : '' }}>
                                        {{ $opt }}
                                    </label>&nbsp;
                                @endforeach
                            </td>
                        </tr>

                        {{-- BREATHING --}}
                        <tr>
                            <td colspan="3">Assessment</td>
                            <td colspan="3" style="text-align: center">
                                <strong>BREATHING</strong>
                            </td>
                            <td>Management</td>
                        </tr>
                        <tr>
                            <td colspan="7"><b>Visually:</b>
                                @foreach (['Normal effort', 'Increased effort', 'Accessory muscles', 'Tripoding', 'Unequal expansion', 'No effort made'] as $opt)
                                    @if ($opt === 'Unequal expansion')
                                        <label>
                                            <input type="checkbox" name="b_visually[]" value="Unequal expansion"
                                                {{ in_array('Unequal expansion', $bVisually) ? 'checked' : '' }}>
                                            Unequal expansion (&nbsp;
                                            <label><input type="checkbox" name="unequal[]" value="Rt"
                                                    {{ in_array('Rt', $unequal) ? 'checked' : '' }}>
                                                &gt;Rt</label>
                                            <label><input type="checkbox" name="unequal[]" value="Lt"
                                                    {{ in_array('Lt', $unequal) ? 'checked' : '' }}>
                                                &gt;Lt</label>&nbsp;)
                                        </label>
                                    @else
                                        <label>
                                            <input type="checkbox" name="b_visually[]" value="{{ $opt }}"
                                                {{ in_array($opt, $bVisually) ? 'checked' : '' }}>
                                            {{ $opt }}
                                        </label>&nbsp;
                                    @endif
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5"><b>Sounds:</b>
                                @foreach (['Normal', 'Wheeze', 'Crackles', 'Reduced Air entry', 'Absent'] as $opt)
                                    @if ($opt === 'Reduced Air entry')
                                        <label>
                                            <input type="checkbox" name="b_sounds[]" value="Reduced Air entry"
                                                {{ in_array('Reduced Air entry', $bSounds) ? 'checked' : '' }}>
                                            Reduced Air entry (&nbsp;
                                            <label><input type="checkbox" name="r_air[]" value="Rt"
                                                    {{ in_array('Rt', $rAir) ? 'checked' : '' }}>
                                                &gt;Rt</label>
                                            <label><input type="checkbox" name="r_air[]" value="Lt"
                                                    {{ in_array('Lt', $rAir) ? 'checked' : '' }}>
                                                &gt;Lt</label>&nbsp;)
                                        </label>
                                    @elseif($opt === 'Absent')
                                        <label>
                                            <input type="checkbox" name="b_sounds[]" value="Absent"
                                                {{ in_array('Absent', $bSounds) ? 'checked' : '' }}>
                                            Absent (&nbsp;
                                            <label><input type="checkbox" name="absent[]" value="Rt"
                                                    {{ in_array('Rt', $absent) ? 'checked' : '' }}>
                                                Rt</label>
                                            <label><input type="checkbox" name="absent[]" value="Lt"
                                                    {{ in_array('Lt', $absent) ? 'checked' : '' }}>
                                                Lt</label>&nbsp;)
                                        </label>
                                    @else
                                        <label>
                                            <input type="checkbox" name="b_sounds[]" value="{{ $opt }}"
                                                {{ in_array($opt, $bSounds) ? 'checked' : '' }}>
                                            {{ $opt }}
                                        </label>&nbsp;
                                    @endif
                                @endforeach
                            </td>
                            <td><b>Vitals(RR/min):</b>
                                {{ @$adult_emergency_dept->b_vital }}
                            </td>
                            <td><b>SpO<sub>2</sub>(%):</b>
                                {{ @$adult_emergency_dept->b_spo2 }}
                            </td>
                        </tr>

                        {{-- CIRCULATION --}}
                        <tr>
                            <td colspan="3">Assessment</td>
                            <td colspan="3" style="text-align: center">
                                <strong>CIRCULATION</strong>
                            </td>
                            <td>Management</td>
                        </tr>
                        <tr>
                            <td colspan="7"><b>Visually:</b>
                                @foreach (['Good colour', 'Pale', 'Cyanosed', 'Sweaty/clammy', 'Obvious bleeding'] as $opt)
                                    <label>
                                        <input type="checkbox" name="c_visually[]" value="{{ $opt }}"
                                            {{ in_array($opt, $cVisually) ? 'checked' : '' }}>
                                        {{ $opt }}
                                    </label>&nbsp;
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5"><b>Sounds:</b>
                                @foreach (['Normal', 'Muffled', 'Murmur', 'Absent', 'Other'] as $opt)
                                    <label>
                                        <input type="checkbox" name="c_sounds[]" value="{{ $opt }}"
                                            {{ in_array($opt, $cSounds) ? 'checked' : '' }}>
                                        {{ $opt }}
                                    </label>&nbsp;
                                @endforeach
                            </td>
                            <td><b>Vitals(RR/min):</b>
                                {{ @$adult_emergency_dept->c_vital }}
                            </td>
                            <td><b>BP/CRT:</b>
                                {{ @$adult_emergency_dept->c_crt }}
                            </td>
                        </tr>


                        <tr>
                            <td colspan="3">Assessment</td>
                            <td colspan="3" style="text-align: center">
                                <strong>DISABILITY</strong>
                            </td>
                            <td>Management</td>
                        </tr>
                        <tr>
                            <td colspan="2"><b>GCS:</b></td>
                            <td>Eyes (4) = {{ @$adult_emergency_dept->eyes }}

                            </td>
                            <td>Verbal (5) = {{ @$adult_emergency_dept->verbal }}

                            </td>
                            <td>Motor (6) = {{ @$adult_emergency_dept->motor }}

                            </td>
                            <td colspan="2">
                                <b>Total = {{ @$adult_emergency_dept->total }}
                                    /15</b>
                            </td>
                        </tr>
                        <tr>
                            <td><b>PEARL:</b> {{ @$adult_emergency_dept->pearl }}

                            </td>
                            <td colspan="3">If NO, Comments
                                {{ @$adult_emergency_dept->p_comment }}
                            </td>
                            <td><b>Gross focal neurology:</b>
                                {{ @$adult_emergency_dept->gfn }}
                            </td>
                            <td colspan="2">If YES, Comments
                                {{ @$adult_emergency_dept->gfn_comment }}
                            </td>
                        </tr>

                        {{-- EXPOSURE --}}
                        <tr>
                            <td colspan="3">Assessment</td>
                            <td colspan="3" style="text-align: center">
                                <strong>Exposure</strong>
                            </td>
                            <td>Management</td>
                        </tr>
                        <tr>
                            <td colspan="4">(See body map)
                                @foreach (['Rash', 'Deformation', 'Injuries', 'Dehydration', 'Other'] as $opt)
                                    <label>
                                        <input type="checkbox" name="exposure[]" value="{{ $opt }}"
                                            {{ in_array($opt, $exposure) ? 'checked' : '' }}>
                                        {{ $opt }}
                                    </label>&nbsp;
                                @endforeach
                            </td>
                            <td colspan="3">
                                {{ @$adult_emergency_dept->exposure_other }}
                            </td>
                        </tr>

                        {{-- FOCUSED SYSTEMIC EXAM --}}
                        <tr>
                            <td colspan="3">Assessment</td>
                            <td colspan="3" style="text-align: center"><strong>Focused
                                    Systemic Examination</strong></td>
                            <td>Management</td>
                        </tr>

                        {{-- SIGNATURE BLOCK --}}
                        <tr>
                            <th colspan="3">Assessment completed by</th>
                            <th colspan="2">Designation</th>
                            <th>Emp. ID</th>
                            <th>Time</th>
                        </tr>
                        <tr>
                            <td colspan="3">
                                {{ @$adult_emergency_dept->f_name }}
                            </td>
                            <td colspan="2">
                                {{ @$adult_emergency_dept->f_design }}
                            </td>
                            <td>
                                {{ @$adult_emergency_dept->f_empid }}
                            </td>
                            <td>
                                {{ @$adult_emergency_dept->f_time }}
                            </td>
                        </tr>

                        {{-- ALLERGIES --}}
                        <tr>
                            <td colspan="2">Allergies and adverse drug reactions:</td>
                            <td>
                                {{ @$adult_emergency_dept->drug_reaction }}
                            </td>
                            <td>If yes, please specify:</td>
                            <td colspan="3">
                                {{ @$adult_emergency_dept->drug_other }}
                            </td>
                        </tr>

                    </table>
                    @php
                        $mr_drug_list = !empty($adult_emergency_dept->mr_drug)
                            ? json_decode($adult_emergency_dept->mr_drug, true)
                            : [];
                        $mr_dose_list = !empty($adult_emergency_dept->mr_dose)
                            ? json_decode($adult_emergency_dept->mr_dose, true)
                            : [];
                        $mr_route_list = !empty($adult_emergency_dept->mr_route)
                            ? json_decode($adult_emergency_dept->mr_route, true)
                            : [];
                        $mr_freq_list = !empty($adult_emergency_dept->mr_freq)
                            ? json_decode($adult_emergency_dept->mr_freq, true)
                            : [];
                        $mr_datetime_list = !empty($adult_emergency_dept->mr_datetime)
                            ? json_decode($adult_emergency_dept->mr_datetime, true)
                            : [];
                        $continue_hos_list = !empty($adult_emergency_dept->continue_hos)
                            ? json_decode($adult_emergency_dept->continue_hos, true)
                            : [];
                    @endphp

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th colspan="6">
                                    Medicine Reconciliation
                                </th>
                            </tr>
                            <tr>
                                <th>Drug Name</th>
                                <th>Dose</th>
                                <th>Route</th>
                                <th>Frequency</th>
                                <th>Last dose (date & time)
                                </th>
                                <th>Continue in hospital</th>

                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($mr_drug_list ?? [] as $i => $drug)
                                <tr>
                                    <td>{{ $drug }}
                                    </td>
                                    <td>{{ $mr_dose_list[$i] ?? '' }}</td>
                                    <td>
                                        {{ $mr_route_list[$i] ?? '' }}
                                    </td>
                                    <td>
                                        {{ $mr_freq_list[$i] ?? '' }}
                                    </td>
                                    <td>{{ $mr_datetime_list[$i] ?? '' }}</td>
                                    <td>
                                        {{ $continue_hos_list[$i] ?? '' }}
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">No data available</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>


                    <table class="table table-bordered">
                        <tr>
                            <td colspan="7">
                                <b>Source of medication list:</b><br>
                                <label>
                                    <input type="checkbox" name="med_source[]" value="Patient’s medication list"
                                        {{ in_array('Patient’s medication list', $medSource) ? 'checked' : '' }}>
                                    Patient’s medication list
                                </label><br>
                                <label>
                                    <input type="checkbox" name="med_source[]" value="Physician’s list"
                                        {{ in_array('Physician’s list', $medSource) ? 'checked' : '' }}>
                                    Physician’s list
                                </label><br>
                                <label>
                                    <input type="checkbox" name="med_source[]" value="Patient/Family recall"
                                        {{ in_array('Patient/Family recall', $medSource) ? 'checked' : '' }}>
                                    Patient/Family recall
                                </label><br>
                                <label>
                                    <input type="checkbox" name="med_source[]" value="Previous discharge papers"
                                        {{ in_array('Previous discharge papers', $medSource) ? 'checked' : '' }}>
                                    Previous discharge papers
                                </label><br>
                                <label>
                                    <input type="checkbox" name="med_source[]" value="Referring facility"
                                        {{ in_array('Referring facility', $medSource) ? 'checked' : '' }}>
                                    Referring facility
                                </label><br>
                                <label>
                                    <input type="checkbox" name="med_source[]" value="Pharmacy"
                                        {{ in_array('Pharmacy', $medSource) ? 'checked' : '' }}>
                                    Pharmacy
                                </label><br>
                                <label>
                                    <input type="checkbox" name="med_source[]" value="Others"
                                        {{ in_array('Others', $medSource) ? 'checked' : '' }}>
                                    Others: This patient is not on any prescription, OTC or
                                    herbal remedies
                                </label>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="7">
                                <b>Disposition of medications:</b><br>
                                <label>
                                    <input type="checkbox" name="med_disposition[]" value="None with patient"
                                        {{ in_array('None with patient', $medDisposition) ? 'checked' : '' }}>
                                    None with patient
                                </label><br>
                                <label>
                                    <input type="checkbox" name="med_disposition[]" value="Sent home with family"
                                        {{ in_array('Sent home with family', $medDisposition) ? 'checked' : '' }}>
                                    Sent home with family
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <th colspan="7" style="text-align:center">Oxygen Therapy</th>
                        </tr>
                        <tr>
                            <td colspan="2">Indication</td>
                            <td>Target SpO<sub>2</sub></td>
                            <td>Flow rate</td>
                            <td>Route</td>
                            <td>Sign ID</td>
                            <td>Time started</td>
                        </tr>
                        <tr>
                            <td colspan="2">{{ @$adult_emergency_dept->ot_indication }}</td>
                            <td>{{ @$adult_emergency_dept->ot_spo2 }}</td>
                            <td>{{ @$adult_emergency_dept->ot_flow }}</td>
                            <td>{{ @$adult_emergency_dept->ot_route }}</td>
                            <td>{{ @$adult_emergency_dept->ot_sign }}</td>
                            <td>{{ @$adult_emergency_dept->ot_time }}</td>
                        </tr>
                    </table>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th colspan="6" style="text-align: center">Analgesia and
                                    other STAT medication</th>
                            </tr>
                            <tr class="border-0">
                                <th>Medicine/Surgical</th>
                                <th>Route</th>
                                <th>Frequency</th>
                                <th>Duration</th>
                                <th>Qty.</th>
                                <th>Instruction</th>

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
                        <tr>
                            <td colspan="5"><b>ED Narrative:</b></td>
                        </tr>
                        <tr>
                            <td colspan="5">{{ @$adult_emergency_dept->ed_narrative }}</td>
                        </tr>

                        <tr>
                            <th>Name</th>
                            <th>Signature</th>
                            <th>Designation</th>
                            <th>Emp. ID</th>
                            <th>Time</th>
                        </tr>
                        <tr>
                            <td>{{ @$adult_emergency_dept->narr_name }}</td>
                            <td>{{ @$adult_emergency_dept->narr_sign }}</td>
                            <td>{{ @$adult_emergency_dept->narr_design }}</td>
                            <td>{{ @$adult_emergency_dept->narr_epmid }}</td>
                            <td>{{ @$adult_emergency_dept->narr_time }}</td>
                        </tr>

                        <tr>
                            <td>Has this patient been handed over?</td>
                            <td>{{ @$adult_emergency_dept->pt_handed }}</td>
                            <td>If yes, to whom?</td>
                            <td colspan="2">{{ @$adult_emergency_dept->pt_yes }}</td>
                        </tr>

                        <tr>
                            <td colspan="5"><b>ED Specialist Note:</b></td>
                        </tr>
                        <tr>
                            <td colspan="5">{{ @$adult_emergency_dept->ed_note }}</td>
                        </tr>

                        <tr>
                            <th>Name</th>
                            <th>Signature</th>
                            <th>Designation</th>
                            <th>Emp. ID</th>
                            <th>Time</th>
                        </tr>
                        <tr>
                            <td>{{ @$adult_emergency_dept->eds_name }}</td>
                            <td>{{ @$adult_emergency_dept->eds_sign }}</td>
                            <td>{{ @$adult_emergency_dept->eds_design }}</td>
                            <td>{{ @$adult_emergency_dept->eds_epmid }}</td>
                            <td>{{ @$adult_emergency_dept->eds_time }}</td>
                        </tr>

                        <tr>
                            <td colspan="5" style="text-align: center"><b>Body Map</b></td>
                        </tr>
                        <tr>
                            <td colspan="5">{{ @$adult_emergency_dept->body_map }}</td>
                        </tr>

                        <tr>
                            <td colspan="5"><b>Consultation 1:</b></td>
                        </tr>
                        <tr>
                            <td colspan="5">{{ @$adult_emergency_dept->consult1 }}</td>
                        </tr>
                        <tr>
                            <th>Name</th>
                            <th>Signature</th>
                            <th>Designation</th>
                            <th>Emp. ID</th>
                            <th>Time</th>
                        </tr>
                        <tr>
                            <td>{{ @$adult_emergency_dept->consult1_name }}</td>
                            <td>{{ @$adult_emergency_dept->consult1_sign }}</td>
                            <td>{{ @$adult_emergency_dept->consult1_design }}</td>
                            <td>{{ @$adult_emergency_dept->consult1_epmid }}</td>
                            <td>{{ @$adult_emergency_dept->consult1_time }}</td>
                        </tr>

                        <tr>
                            <td colspan="5"><b>Consultation 2:</b></td>
                        </tr>
                        <tr>
                            <td colspan="5">{{ @$adult_emergency_dept->consult2 }}</td>
                        </tr>
                        <tr>
                            <th>Name</th>
                            <th>Signature</th>
                            <th>Designation</th>
                            <th>Emp. ID</th>
                            <th>Time</th>
                        </tr>
                        <tr>
                            <td>{{ @$adult_emergency_dept->consult2_name }}</td>
                            <td>{{ @$adult_emergency_dept->consult2_sign }}</td>
                            <td>{{ @$adult_emergency_dept->consult2_design }}</td>
                            <td>{{ @$adult_emergency_dept->consult2_epmid }}</td>
                            <td>{{ @$adult_emergency_dept->consult2_time }}</td>
                        </tr>
                    </table>

                    @php
                        $poct = array_map('strval', json_decode($adult_emergency_dept->poct ?? '[]', true) ?? []);
                        $lab_test = array_map(
                            'strval',
                            json_decode($adult_emergency_dept->lab_test ?? '[]', true) ?? [],
                        );
                    @endphp
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <td colspan="6" style="text-align: center">
                                    <h4>Investigations ordered in ED</h4>
                                </td>
                            </tr>
                            <tr>
                                <th colspan="6" style="text-align: center"><b>POINT OF CARE TESTS</b></th>
                            </tr>
                            <tr>
                                <th>Tick</th>
                                <th>Doctor’s order</th>
                                <th>Sent</th>
                                <th>Due</th>
                                <th>Nurse’s Sign</th>
                                <th>Nurse’s ID</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- 1 --}}
                            <tr>
                                <td><input type="checkbox" {{ in_array('1', $poct ?? []) ? 'checked' : '' }}></td>
                                <td>Blood gas analysis</td>
                                <td>{{ @$adult_emergency_dept->poct_ba_s }}</td>
                                <td>{{ @$adult_emergency_dept->poct_ba_d }}</td>
                                <td>{{ @$adult_emergency_dept->poct_ba_sn }}</td>
                                <td>{{ @$adult_emergency_dept->poct_ba_id }}</td>
                            </tr>
                            {{-- 2 --}}
                            <tr>
                                <td><input type="checkbox" {{ in_array('2', $poct ?? []) ? 'checked' : '' }}></td>
                                <td>Blood glucose</td>
                                <td>{{ @$adult_emergency_dept->poct_bg_s }}</td>
                                <td>{{ @$adult_emergency_dept->poct_bg_d }}</td>
                                <td>{{ @$adult_emergency_dept->poct_bg_sn }}</td>
                                <td>{{ @$adult_emergency_dept->poct_bg_id }}</td>
                            </tr>
                            {{-- 3 --}}
                            <tr>
                                <td><input type="checkbox" {{ in_array('3', $poct ?? []) ? 'checked' : '' }}></td>
                                <td>Chem 8</td>
                                <td>{{ @$adult_emergency_dept->poct_chem_s }}</td>
                                <td>{{ @$adult_emergency_dept->poct_chem_d }}</td>
                                <td>{{ @$adult_emergency_dept->poct_chem_sn }}</td>
                                <td>{{ @$adult_emergency_dept->poct_chem_id }}</td>
                            </tr>
                            {{-- 4 --}}
                            <tr>
                                <td><input type="checkbox" {{ in_array('4', $poct ?? []) ? 'checked' : '' }}></td>
                                <td>ECG</td>
                                <td>{{ @$adult_emergency_dept->poct_ecg_s }}</td>
                                <td>{{ @$adult_emergency_dept->poct_ecg_d }}</td>
                                <td>{{ @$adult_emergency_dept->poct_ecg_sn }}</td>
                                <td>{{ @$adult_emergency_dept->poct_ecg_id }}</td>
                            </tr>
                            {{-- 5 --}}
                            <tr>
                                <td><input type="checkbox" {{ in_array('5', $poct ?? []) ? 'checked' : '' }}></td>
                                <td>NT-proBNP</td>
                                <td>{{ @$adult_emergency_dept->poct_nt_s }}</td>
                                <td>{{ @$adult_emergency_dept->poct_nt_d }}</td>
                                <td>{{ @$adult_emergency_dept->poct_nt_sn }}</td>
                                <td>{{ @$adult_emergency_dept->poct_nt_id }}</td>
                            </tr>
                            {{-- 6 --}}
                            <tr>
                                <td><input type="checkbox" {{ in_array('6', $poct ?? []) ? 'checked' : '' }}></td>
                                <td>POCUS</td>
                                <td>{{ @$adult_emergency_dept->poct_ps_s }}</td>
                                <td>{{ @$adult_emergency_dept->poct_ps_d }}</td>
                                <td>{{ @$adult_emergency_dept->poct_ps_sn }}</td>
                                <td>{{ @$adult_emergency_dept->poct_ps_id }}</td>
                            </tr>
                            {{-- 7 --}}
                            <tr>
                                <td><input type="checkbox" {{ in_array('7', $poct ?? []) ? 'checked' : '' }}></td>
                                <td>PT-INR</td>
                                <td>{{ @$adult_emergency_dept->poct_pr_s }}</td>
                                <td>{{ @$adult_emergency_dept->poct_pr_d }}</td>
                                <td>{{ @$adult_emergency_dept->poct_pr_sn }}</td>
                                <td>{{ @$adult_emergency_dept->poct_pr_id }}</td>
                            </tr>
                            {{-- 8 --}}
                            <tr>
                                <td><input type="checkbox" {{ in_array('8', $poct ?? []) ? 'checked' : '' }}></td>
                                <td>Troponin</td>
                                <td>{{ @$adult_emergency_dept->poct_tn_s }}</td>
                                <td>{{ @$adult_emergency_dept->poct_tn_d }}</td>
                                <td>{{ @$adult_emergency_dept->poct_tn_sn }}</td>
                                <td>{{ @$adult_emergency_dept->poct_tn_id }}</td>
                            </tr>
                            {{-- 9 --}}
                            <tr>
                                <td><input type="checkbox" {{ in_array('9', $poct ?? []) ? 'checked' : '' }}></td>
                                <td>Urinary β-hCG</td>
                                <td>{{ @$adult_emergency_dept->poct_ubh_s }}</td>
                                <td>{{ @$adult_emergency_dept->poct_ubh_d }}</td>
                                <td>{{ @$adult_emergency_dept->poct_ubh_sn }}</td>
                                <td>{{ @$adult_emergency_dept->poct_ubh_id }}</td>
                            </tr>
                            {{-- 10 --}}
                            <tr>
                                <td><input type="checkbox" {{ in_array('10', $poct ?? []) ? 'checked' : '' }}></td>
                                <td>Urine combo test</td>
                                <td>{{ @$adult_emergency_dept->poct_uct_s }}</td>
                                <td>{{ @$adult_emergency_dept->poct_uct_d }}</td>
                                <td>{{ @$adult_emergency_dept->poct_uct_sn }}</td>
                                <td>{{ @$adult_emergency_dept->poct_uct_id }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th colspan="6" style="text-align: center"><b>LABORATORY TESTS</b></th>
                            </tr>
                            <tr>
                                <th>Tick</th>
                                <th>Doctor's order</th>
                                <th>Sent</th>
                                <th>Due</th>
                                <th>Nurse's Sign</th>
                                <th>Nurse's ID</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- 1 Alk. Phosphatase -->
                            <tr>
                                <td><input type="checkbox" value="1" name="lab_test[]"
                                        {{ in_array('1', $lab_test) ? 'checked' : '' }}></td>
                                <td>Alk. Phosphatase</td>
                                <td>{{ @$adult_emergency_dept->lab_ap_s }}</td>
                                <td>{{ @$adult_emergency_dept->lab_ap_d }}</td>
                                <td>{{ @$adult_emergency_dept->lab_ap_sn }}</td>
                                <td>{{ @$adult_emergency_dept->lab_ap_id }}</td>
                            </tr>

                            <!-- 2 Amylase -->
                            <tr>
                                <td><input type="checkbox" value="2" name="lab_test[]"
                                        {{ in_array('2', $lab_test) ? 'checked' : '' }}></td>
                                <td>Amylase</td>
                                <td>{{ @$adult_emergency_dept->lab_am_s }}</td>
                                <td>{{ @$adult_emergency_dept->lab_am_d }}</td>
                                <td>{{ @$adult_emergency_dept->lab_am_sn }}</td>
                                <td>{{ @$adult_emergency_dept->lab_am_id }}</td>
                            </tr>

                            <!-- 3 Blood grouping -->
                            <tr>
                                <td><input type="checkbox" value="3" name="lab_test[]"
                                        {{ in_array('3', $lab_test) ? 'checked' : '' }}></td>
                                <td>Blood grouping</td>
                                <td>{{ @$adult_emergency_dept->lab_bdg_s }}</td>
                                <td>{{ @$adult_emergency_dept->lab_bdg_d }}</td>
                                <td>{{ @$adult_emergency_dept->lab_bdg_sn }}</td>
                                <td>{{ @$adult_emergency_dept->lab_bdg_id }}</td>
                            </tr>

                            <!-- 4 Bilirubin -->
                            <tr>
                                <td><input type="checkbox" value="4" name="lab_test[]"
                                        {{ in_array('4', $lab_test) ? 'checked' : '' }}></td>
                                <td>Bilirubin</td>
                                <td>{{ @$adult_emergency_dept->lab_bn_s }}</td>
                                <td>{{ @$adult_emergency_dept->lab_bn_d }}</td>
                                <td>{{ @$adult_emergency_dept->lab_bn_sn }}</td>
                                <td>{{ @$adult_emergency_dept->lab_bn_id }}</td>
                            </tr>

                            <!-- 5 β-hCG -->
                            <tr>
                                <td><input type="checkbox" value="5" name="lab_test[]"
                                        {{ in_array('5', $lab_test) ? 'checked' : '' }}></td>
                                <td>β-hCG</td>
                                <td>{{ @$adult_emergency_dept->lab_bg_s }}</td>
                                <td>{{ @$adult_emergency_dept->lab_bg_d }}</td>
                                <td>{{ @$adult_emergency_dept->lab_bg_sn }}</td>
                                <td>{{ @$adult_emergency_dept->lab_bg_id }}</td>
                            </tr>

                            <!-- 6 CBC -->
                            <tr>
                                <td><input type="checkbox" value="6" name="lab_test[]"
                                        {{ in_array('6', $lab_test) ? 'checked' : '' }}></td>
                                <td>CBC</td>
                                <td>{{ @$adult_emergency_dept->lab_cbc_s }}</td>
                                <td>{{ @$adult_emergency_dept->lab_cbc_d }}</td>
                                <td>{{ @$adult_emergency_dept->lab_cbc_sn }}</td>
                                <td>{{ @$adult_emergency_dept->lab_cbc_id }}</td>
                            </tr>

                            <!-- 7 Calcium -->
                            <tr>
                                <td><input type="checkbox" value="7" name="lab_test[]"
                                        {{ in_array('7', $lab_test) ? 'checked' : '' }}></td>
                                <td>Calcium</td>
                                <td>{{ @$adult_emergency_dept->lab_cm_s }}</td>
                                <td>{{ @$adult_emergency_dept->lab_cm_d }}</td>
                                <td>{{ @$adult_emergency_dept->lab_cm_sn }}</td>
                                <td>{{ @$adult_emergency_dept->lab_cm_id }}</td>
                            </tr>

                            <!-- 8 Creatine kinase -->
                            <tr>
                                <td><input type="checkbox" value="8" name="lab_test[]"
                                        {{ in_array('8', $lab_test) ? 'checked' : '' }}></td>
                                <td>Creatine kinase</td>
                                <td>{{ @$adult_emergency_dept->lab_ck_s }}</td>
                                <td>{{ @$adult_emergency_dept->lab_ck_d }}</td>
                                <td>{{ @$adult_emergency_dept->lab_ck_sn }}</td>
                                <td>{{ @$adult_emergency_dept->lab_ck_id }}</td>
                            </tr>

                            <!-- 9 CRP -->
                            <tr>
                                <td><input type="checkbox" value="9" name="lab_test[]"
                                        {{ in_array('9', $lab_test) ? 'checked' : '' }}></td>
                                <td>CRP</td>
                                <td>{{ @$adult_emergency_dept->lab_cp_s }}</td>
                                <td>{{ @$adult_emergency_dept->lab_cp_d }}</td>
                                <td>{{ @$adult_emergency_dept->lab_cp_sn }}</td>
                                <td>{{ @$adult_emergency_dept->lab_cp_id }}</td>
                            </tr>

                            <!-- 10 d-Dimer -->
                            <tr>
                                <td><input type="checkbox" value="10" name="lab_test[]"
                                        {{ in_array('10', $lab_test) ? 'checked' : '' }}></td>
                                <td>d-Dimer</td>
                                <td>{{ @$adult_emergency_dept->lab_dd_s }}</td>
                                <td>{{ @$adult_emergency_dept->lab_dd_d }}</td>
                                <td>{{ @$adult_emergency_dept->lab_dd_sn }}</td>
                                <td>{{ @$adult_emergency_dept->lab_dd_id }}</td>
                            </tr>

                            <!-- 11 Dengue NS1 -->
                            <tr>
                                <td><input type="checkbox" value="11" name="lab_test[]"
                                        {{ in_array('11', $lab_test) ? 'checked' : '' }}></td>
                                <td>Dengue NS1</td>
                                <td>{{ @$adult_emergency_dept->lab_dn_s }}</td>
                                <td>{{ @$adult_emergency_dept->lab_dn_d }}</td>
                                <td>{{ @$adult_emergency_dept->lab_dn_sn }}</td>
                                <td>{{ @$adult_emergency_dept->lab_dn_id }}</td>
                            </tr>

                            <!-- 12 Electrolytes -->
                            <tr>
                                <td><input type="checkbox" value="12" name="lab_test[]"
                                        {{ in_array('12', $lab_test) ? 'checked' : '' }}></td>
                                <td>Electrolytes</td>
                                <td>{{ @$adult_emergency_dept->lab_el_s }}</td>
                                <td>{{ @$adult_emergency_dept->lab_el_d }}</td>
                                <td>{{ @$adult_emergency_dept->lab_el_sn }}</td>
                                <td>{{ @$adult_emergency_dept->lab_el_id }}</td>
                            </tr>

                            <!-- 13 Ferritin -->
                            <tr>
                                <td><input type="checkbox" value="13" name="lab_test[]"
                                        {{ in_array('13', $lab_test) ? 'checked' : '' }}></td>
                                <td>Ferritin</td>
                                <td>{{ @$adult_emergency_dept->lab_fn_s }}</td>
                                <td>{{ @$adult_emergency_dept->lab_fn_d }}</td>
                                <td>{{ @$adult_emergency_dept->lab_fn_sn }}</td>
                                <td>{{ @$adult_emergency_dept->lab_fn_id }}</td>
                            </tr>

                            <!-- 14 Hs Trop-I -->
                            <tr>
                                <td><input type="checkbox" value="14" name="lab_test[]"
                                        {{ in_array('14', $lab_test) ? 'checked' : '' }}></td>
                                <td>Hs Trop-I</td>
                                <td>{{ @$adult_emergency_dept->lab_ht_s }}</td>
                                <td>{{ @$adult_emergency_dept->lab_ht_d }}</td>
                                <td>{{ @$adult_emergency_dept->lab_ht_sn }}</td>
                                <td>{{ @$adult_emergency_dept->lab_ht_id }}</td>
                            </tr>

                            <!-- 15 LFT -->
                            <tr>
                                <td><input type="checkbox" value="15" name="lab_test[]"
                                        {{ in_array('15', $lab_test) ? 'checked' : '' }}></td>
                                <td>LFT</td>
                                <td>{{ @$adult_emergency_dept->lab_lft_s }}</td>
                                <td>{{ @$adult_emergency_dept->lab_lft_d }}</td>
                                <td>{{ @$adult_emergency_dept->lab_lft_sn }}</td>
                                <td>{{ @$adult_emergency_dept->lab_lft_id }}</td>
                            </tr>

                            <!-- 16 Lipase -->
                            <tr>
                                <td><input type="checkbox" value="16" name="lab_test[]"
                                        {{ in_array('16', $lab_test) ? 'checked' : '' }}></td>
                                <td>Lipase</td>
                                <td>{{ @$adult_emergency_dept->lab_le_s }}</td>
                                <td>{{ @$adult_emergency_dept->lab_le_d }}</td>
                                <td>{{ @$adult_emergency_dept->lab_le_sn }}</td>
                                <td>{{ @$adult_emergency_dept->lab_le_id }}</td>
                            </tr>

                            <!-- 17 Lipid profile -->
                            <tr>
                                <td><input type="checkbox" value="17" name="lab_test[]"
                                        {{ in_array('17', $lab_test) ? 'checked' : '' }}></td>
                                <td>Lipid profile</td>
                                <td>{{ @$adult_emergency_dept->lab_lp_s }}</td>
                                <td>{{ @$adult_emergery_dept->lab_lp_d }}</td>
                                <td>{{ @$adult_emergency_dept->lab_lp_sn }}</td>
                                <td>{{ @$adult_emergency_dept->lab_lp_id }}</td>
                            </tr>

                            <!-- 18 Procalcitonin -->
                            <tr>
                                <td><input type="checkbox" value="18" name="lab_test[]"
                                        {{ in_array('18', $lab_test) ? 'checked' : '' }}></td>
                                <td>Procalcitonin</td>
                                <td>{{ @$adult_emergency_dept->lab_pn_s }}</td>
                                <td>{{ @$adult_emergency_dept->lab_pn_d }}</td>
                                <td>{{ @$adult_emergency_dept->lab_pn_sn }}</td>
                                <td>{{ @$adult_emergency_dept->lab_pn_id }}</td>
                            </tr>

                            <!-- 19 RFT -->
                            <tr>
                                <td><input type="checkbox" value="19" name="lab_test[]"
                                        {{ in_array('19', $lab_test) ? 'checked' : '' }}></td>
                                <td>RFT</td>
                                <td>{{ @$adult_emergency_dept->lab_rft_s }}</td>
                                <td>{{ @$adult_emergency_dept->lab_rft_d }}</td>
                                <td>{{ @$adult_emergency_dept->lab_rft_sn }}</td>
                                <td>{{ @$adult_emergency_dept->lab_rft_id }}</td>
                            </tr>

                            <!-- 20 SGPT -->
                            <tr>
                                <td><input type="checkbox" value="20" name="lab_test[]"
                                        {{ in_array('20', $lab_test) ? 'checked' : '' }}></td>
                                <td>SGPT</td>
                                <td>{{ @$adult_emergency_dept->lab_sp_s }}</td>
                                <td>{{ @$adult_emergency_dept->lab_sp_d }}</td>
                                <td>{{ @$adult_emergency_dept->lab_sp_sn }}</td>
                                <td>{{ @$adult_emergency_dept->lab_sp_id }}</td>
                            </tr>

                            <!-- 21 SGOT -->
                            <tr>
                                <td><input type="checkbox" value="21" name="lab_test[]"
                                        {{ in_array('21', $lab_test) ? 'checked' : '' }}></td>
                                <td>SGOT</td>
                                <td>{{ @$adult_emergency_dept->lab_so_s }}</td>
                                <td>{{ @$adult_emergency_dept->lab_so_d }}</td>
                                <td>{{ @$adult_emergency_dept->lab_so_sn }}</td>
                                <td>{{ @$adult_emergency_dept->lab_so_id }}</td>
                            </tr>

                            <!-- 22 S. Creatinine eGFR -->
                            <tr>
                                <td><input type="checkbox" value="22" name="lab_test[]"
                                        {{ in_array('22', $lab_test) ? 'checked' : '' }}></td>
                                <td>S. Creatinine eGFR</td>
                                <td>{{ @$adult_emergency_dept->lab_sc_s }}</td>
                                <td>{{ @$adult_emergency_dept->lab_sc_d }}</td>
                                <td>{{ @$adult_emergency_dept->lab_sc_sn }}</td>
                                <td>{{ @$adult_emergency_dept->lab_sc_id }}</td>
                            </tr>

                            <!-- 23 TSH -->
                            <tr>
                                <td><input type="checkbox" value="23" name="lab_test[]"
                                        {{ in_array('23', $lab_test) ? 'checked' : '' }}></td>
                                <td>TSH</td>
                                <td>{{ @$adult_emergency_dept->lab_tsh_s }}</td>
                                <td>{{ @$adult_emergency_dept->lab_tsh_d }}</td>
                                <td>{{ @$adult_emergency_dept->lab_tsh_sn }}</td>
                                <td>{{ @$adult_emergency_dept->lab_tsh_id }}</td>
                            </tr>

                            <!-- 24 Urea -->
                            <tr>
                                <td><input type="checkbox" value="24" name="lab_test[]"
                                        {{ in_array('24', $lab_test) ? 'checked' : '' }}></td>
                                <td>Urea</td>
                                <td>{{ @$adult_emergency_dept->lab_ur_s }}</td>
                                <td>{{ @$adult_emergency_dept->lab_ur_d }}</td>
                                <td>{{ @$adult_emergency_dept->lab_ur_sn }}</td>
                                <td>{{ @$adult_emergency_dept->lab_ur_id }}</td>
                            </tr>

                            <!-- 25 Viral markers -->
                            <tr>
                                <td><input type="checkbox" value="25" name="lab_test[]"
                                        {{ in_array('25', $lab_test) ? 'checked' : '' }}></td>
                                <td>Viral markers</td>
                                <td>{{ @$adult_emergency_dept->lab_vm_s }}</td>
                                <td>{{ @$adult_emergency_dept->lab_vm_d }}</td>
                                <td>{{ @$adult_emergency_dept->lab_vm_sn }}</td>
                                <td>{{ @$adult_emergency_dept->lab_vm_id }}</td>
                            </tr>

                            <!-- 26 Others -->
                            <tr>
                                <td><input type="checkbox" value="26" name="lab_test[]"
                                        {{ in_array('26', $lab_test) ? 'checked' : '' }}></td>
                                <td>Others</td>
                                <td>{{ @$adult_emergency_dept->lab_ot_s }}</td>
                                <td>{{ @$adult_emergency_dept->lab_ot_d }}</td>
                                <td>{{ @$adult_emergency_dept->lab_ot_sn }}</td>
                                <td>{{ @$adult_emergency_dept->lab_ot_id }}</td>
                            </tr>
                        </tbody>
                    </table>
                    @php
                        $img = json_decode($adult_emergency_dept->img ?? '[]', true) ?? [];

                        $pam = json_decode($adult_emergency_dept->pam ?? '[]', true) ?? [];

                    @endphp


                    {{-- IMAGING --}}
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th colspan="6" style="text-align: center"><b>IMAGING</b></th>
                            </tr>
                            <tr>
                                <th>Tick</th>
                                <th>Doctor’s order</th>
                                <th>Sent</th>
                                <th>Due</th>
                                <th>Nurse’s Sign</th>
                                <th>Nurse’s ID</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input type="checkbox" {{ in_array('1', $img ?? []) ? 'checked' : '' }}></td>
                                <td>CT Scan</td>
                                <td>{{ @$adult_emergency_dept->img_ct_s }}</td>
                                <td>{{ @$adult_emergency_dept->img_ct_d }}</td>
                                <td>{{ @$adult_emergency_dept->img_ct_sn }}</td>
                                <td>{{ @$adult_emergency_dept->img_ct_id }}</td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" {{ in_array('2', $img ?? []) ? 'checked' : '' }}></td>
                                <td>Echo</td>
                                <td>{{ @$adult_emergency_dept->img_echo_s }}</td>
                                <td>{{ @$adult_emergency_dept->img_echo_d }}</td>
                                <td>{{ @$adult_emergency_dept->img_echo_sn }}</td>
                                <td>{{ @$adult_emergency_dept->img_echo_id }}</td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" {{ in_array('3', $img ?? []) ? 'checked' : '' }}></td>
                                <td>MRI</td>
                                <td>{{ @$adult_emergency_dept->img_mri_s }}</td>
                                <td>{{ @$adult_emergency_dept->img_mri_d }}</td>
                                <td>{{ @$adult_emergency_dept->img_mri_sn }}</td>
                                <td>{{ @$adult_emergency_dept->img_mri_id }}</td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" {{ in_array('4', $img ?? []) ? 'checked' : '' }}></td>
                                <td>Ultrasound</td>
                                <td>{{ @$adult_emergency_dept->img_us_s }}</td>
                                <td>{{ @$adult_emergency_dept->img_us_d }}</td>
                                <td>{{ @$adult_emergency_dept->img_us_sn }}</td>
                                <td>{{ @$adult_emergency_dept->img_us_id }}</td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" {{ in_array('5', $img ?? []) ? 'checked' : '' }}></td>
                                <td>X-ray</td>
                                <td>{{ @$adult_emergency_dept->img_xr_s }}</td>
                                <td>{{ @$adult_emergency_dept->img_xr_d }}</td>
                                <td>{{ @$adult_emergency_dept->img_xr_sn }}</td>
                                <td>{{ @$adult_emergency_dept->img_xr_id }}</td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" {{ in_array('6', $img ?? []) ? 'checked' : '' }}></td>
                                <td>Others</td>
                                <td>{{ @$adult_emergency_dept->img_ot_s }}</td>
                                <td>{{ @$adult_emergency_dept->img_ot_d }}</td>
                                <td>{{ @$adult_emergency_dept->img_ot_sn }}</td>
                                <td>{{ @$adult_emergency_dept->img_ot_id }}</td>
                            </tr>
                        </tbody>
                    </table>

                    {{-- PATHOLOGY AND MICROBIOLOGY --}}
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th colspan="6" style="text-align: center"><b>PATHOLOGY AND MICROBIOLOGY</b></th>
                            </tr>
                            <tr>
                                <th>Tick</th>
                                <th>Doctor’s order</th>
                                <th>Sent</th>
                                <th>Due</th>
                                <th>Nurse’s Sign</th>
                                <th>Nurse’s ID</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input type="checkbox" {{ in_array('1', $pam ?? []) ? 'checked' : '' }}></td>
                                <td>Blood Cultures</td>
                                <td>{{ @$adult_emergency_dept->pam_bs_s }}</td>
                                <td>{{ @$adult_emergency_dept->pam_bs_d }}</td>
                                <td>{{ @$adult_emergency_dept->pam_bs_sn }}</td>
                                <td>{{ @$adult_emergency_dept->pam_bs_id }}</td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" {{ in_array('2', $pam ?? []) ? 'checked' : '' }}></td>
                                <td>Stool RE</td>
                                <td>{{ @$adult_emergency_dept->pam_sr_s }}</td>
                                <td>{{ @$adult_emergency_dept->pam_sr_d }}</td>
                                <td>{{ @$adult_emergency_dept->pam_sr_sn }}</td>
                                <td>{{ @$adult_emergency_dept->pam_sr_id }}</td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" {{ in_array('3', $pam ?? []) ? 'checked' : '' }}></td>
                                <td>Stool OBT</td>
                                <td>{{ @$adult_emergency_dept->pam_so_s }}</td>
                                <td>{{ @$adult_emergency_dept->pam_so_d }}</td>
                                <td>{{ @$adult_emergency_dept->pam_so_sn }}</td>
                                <td>{{ @$adult_emergency_dept->pam_so_id }}</td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" {{ in_array('4', $pam ?? []) ? 'checked' : '' }}></td>
                                <td>Urine RME</td>
                                <td>{{ @$adult_emergency_dept->pam_ur_s }}</td>
                                <td>{{ @$adult_emergency_dept->pam_ur_d }}</td>
                                <td>{{ @$adult_emergency_dept->pam_ur_sn }}</td>
                                <td>{{ @$adult_emergency_dept->pam_ur_id }}</td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" {{ in_array('5', $pam ?? []) ? 'checked' : '' }}></td>
                                <td>Urine C/S</td>
                                <td>{{ @$adult_emergency_dept->pam_uc_s }}</td>
                                <td>{{ @$adult_emergency_dept->pam_uc_d }}</td>
                                <td>{{ @$adult_emergency_dept->pam_uc_sn }}</td>
                                <td>{{ @$adult_emergency_dept->pam_uc_id }}</td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" {{ in_array('6', $pam ?? []) ? 'checked' : '' }}></td>
                                <td>Others</td>
                                <td>{{ @$adult_emergency_dept->pam_bc_s }}</td>
                                <td>{{ @$adult_emergency_dept->pam_bc_d }}</td>
                                <td>{{ @$adult_emergency_dept->pam_bc_sn }}</td>
                                <td>{{ @$adult_emergency_dept->pam_bc_id }}</td>
                            </tr>
                        </tbody>
                    </table>
                    @php
                        $ds = json_decode($adult_emergency_dept->ds ?? '[]', true) ?? [];
                        $admit = json_decode($adult_emergency_dept->admit ?? '[]', true) ?? [];
                        $condition = json_decode($adult_emergency_dept->condition ?? '[]', true) ?? [];
                    @endphp
                    <table class="table table-bordered">
                        <tr>
                            <td colspan="2" style="text-align: center"><b>Patient disposition from ED</b></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <b>Provisional diagnosis:</b>
                                {{ @$adult_emergency_dept->pd }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <b>Disposition status:</b>
                                <label><input type="checkbox" {{ in_array('Admit', $ds ?? []) ? 'checked' : '' }}>
                                    Admit</label>
                                <label><input type="checkbox"
                                        {{ in_array('Discharge', $ds ?? []) ? 'checked' : '' }}>
                                    Discharge</label>
                                <label><input type="checkbox" {{ in_array('LAMA', $ds ?? []) ? 'checked' : '' }}>
                                    LAMA</label>
                                <label><input type="checkbox" {{ in_array('Referred', $ds ?? []) ? 'checked' : '' }}>
                                    Referred
                                    (OPD/Outside)</label>
                                <label><input type="checkbox" {{ in_array('Death', $ds ?? []) ? 'checked' : '' }}>
                                    Death</label>
                                <br>
                                <label><input type="checkbox" {{ in_array('ICU', $admit ?? []) ? 'checked' : '' }}>
                                    ICU</label>
                                <label><input type="checkbox" {{ in_array('HDU', $admit ?? []) ? 'checked' : '' }}>
                                    HDU</label>
                                <label><input type="checkbox" {{ in_array('CCU', $admit ?? []) ? 'checked' : '' }}>
                                    CCU</label>
                                <label><input type="checkbox" {{ in_array('Cath', $admit ?? []) ? 'checked' : '' }}>
                                    Cath Lab</label>
                                <label><input type="checkbox" {{ in_array('OT', $admit ?? []) ? 'checked' : '' }}>
                                    OT</label>
                                <label><input type="checkbox" {{ in_array('Cabin', $admit ?? []) ? 'checked' : '' }}>
                                    Cabin</label>
                                <label><input type="checkbox" {{ in_array('Ward', $admit ?? []) ? 'checked' : '' }}>
                                    Ward</label>
                                <label><input type="checkbox" {{ in_array('Other', $admit ?? []) ? 'checked' : '' }}>
                                    Other</label>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <b>Condition at time of disposition:</b>
                                <label><input type="checkbox"
                                        {{ in_array('Well', $condition ?? []) ? 'checked' : '' }}>
                                    Well</label>
                                <label><input type="checkbox"
                                        {{ in_array('Fair', $condition ?? []) ? 'checked' : '' }}>
                                    Fair</label>
                                <label><input type="checkbox"
                                        {{ in_array('Poor', $condition ?? []) ? 'checked' : '' }}>
                                    Poor</label>
                                <label><input type="checkbox"
                                        {{ in_array('Critical', $condition ?? []) ? 'checked' : '' }}>
                                    Critical (if critical complete SBAR)</label>
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">
                                <b>TRANSFER NOTE:</b> (In case of transferring from ED to Critical areas)
                                <table border="1" width="100%"
                                    style="border-collapse: collapse; font-size: 12px; margin-top: 5px;">
                                    <tr>
                                        <th>Staff</th>
                                        <th>Name</th>
                                        <th>Emp. ID</th>
                                        <th>Date & Time</th>
                                    </tr>
                                    <tr>
                                        <td>Transferring Doctor</td>
                                        <td>{{ @$adult_emergency_dept->td_name }}</td>
                                        <td>{{ @$adult_emergency_dept->td_empid }}</td>
                                        <td>{{ isset($adult_emergency_dept->td_datetime) ? date('Y-m-d H:i', strtotime($adult_emergency_dept->td_datetime)) : '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Receiving Doctor</td>
                                        <td>{{ @$adult_emergency_dept->rd_name }}</td>
                                        <td>{{ @$adult_emergency_dept->rd_empid }}</td>
                                        <td>{{ isset($adult_emergency_dept->rd_datetime) ? date('Y-m-d H:i', strtotime($adult_emergency_dept->rd_datetime)) : '' }}
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td width="50%" valign="top">
                                <b>SBAR Handover</b><br>
                                <b>Situation:</b> {{ @$adult_emergency_dept->sbar_st }}<br>
                                <b>Background:</b> {{ @$adult_emergency_dept->sbar_bg }}<br>
                                <b>Assessment:</b> {{ @$adult_emergency_dept->sbar_ass }}<br>
                                <b>Recommendations:</b> {{ @$adult_emergency_dept->sbar_rc }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>Date & Time of Admission: </b>
                                {{ date('Y-m-d h:i A', strtotime($patient_info->admission_date)) }}
                            </td>
                            <td>
                                <b>Date & Time of Discharge: </b>
                                @if (!empty($admission_info->dis_datetime))
                                    {{ date('Y-m-d h:i A', strtotime($admission_info->dis_datetime)) }}
                                @else
                                    No Discharge Date Found
                                @endif
                            </td>
                        </tr>
                    </table>

                </td>
            </tr>
    </table>


    <section class="footer-table">
        @php
            $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
            $date = $dt->format('g:i A');
        @endphp

        <table style="width:100%" class="table">
            <tbody>
                <tr>
                    <td style="text-align:left;border:none;width:70%"><strong>Staff ID:</strong>
                        {{ @$userInfo->user_code }}, <strong>Printing Date & Time:</strong>
                        {{ date('d/m/Y h:ia') }}
                    </td>
                    <td style="text-align:right;border:none;width:30%"><strong>Powered By: NEXTGEN
                            IT</strong></td>
                </tr>
            </tbody>
        </table>
    </section>
    </td>
    </tr>
    </tbody>
    </table>
</body>

</html>
