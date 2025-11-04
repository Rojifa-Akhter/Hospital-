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
                    <div
                        style="padding: 7px; border-top:1px dotted black; border-bottom:1px dotted black;text-align:center;margin-top:10px; margin-bottom:20px">
                        <span style="font-size: 16px;"><b>HEMODIALYSIS RECORD</b></span>
                    </div>

                    <table width="100%" border="1" cellspacing="0" cellpadding="5"
                        style="margin-top:10px; border-collapse: collapse;">
                        <tr>
                            <td><strong>Age:</strong> {{ $patient_info->age ?? '' }}</td>
                            <td><strong>Gender:</strong> {{ $patient_info->gender_txt ?? '' }}</td>
                            <td><strong>Consultant:</strong> {{ $admission_info->primary_doctor_name ?? '' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Type:</strong> {{ $hemodialysis->iop ?? '' }}</td>
                            <td colspan="2"><strong>Ward/ICU:</strong> {{ $hemodialysis->ward_icu ?? '' }}</td>
                        </tr>

                        <tr>
                            <td><strong>Dialysis Prescription:</strong></td>
                            <td colspan="2">
                                @php $prescrip = json_decode($hemodialysis->prescrip ?? '[]', true) ?? []; @endphp
                                {{ implode(', ', $prescrip) }}
                                @if (!empty($hemodialysis->prescrip_other))
                                    , Other: {{ $hemodialysis->prescrip_other }}
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <td><strong>Dialyser Surface Area:</strong> {{ $hemodialysis->dialyser_area ?? '' }}</td>
                            <td><strong>Duration:</strong> {{ $hemodialysis->duration ?? '' }}</td>
                            <td><strong>Dialysate Flow:</strong> {{ $hemodialysis->dialysate_flow ?? '' }}</td>
                        </tr>

                        <tr>
                            <td><strong>Dry Weight:</strong> {{ $hemodialysis->dry_weight ?? '' }}</td>
                            <td><strong>Ultra Filtration:</strong> {{ $hemodialysis->ultra_filtration ?? '' }}</td>
                            <td><strong>Dialysate Na⁺:</strong> {{ $hemodialysis->dialysate_na ?? '' }}</td>
                        </tr>

                        <tr>
                            <td><strong>Blood Flow:</strong> {{ $hemodialysis->blood_flow ?? '' }}</td>
                            <td><strong>Blood Group & Rh:</strong> {{ $hemodialysis->blood_group ?? '' }}</td>
                            <td><strong>Heparin:</strong> {{ $hemodialysis->heparin ?? '' }}</td>
                        </tr>

                        <tr>
                            <td><strong>Heparin Bolus:</strong> {{ $hemodialysis->heparin_bolus ?? '' }} IU</td>
                            <td colspan="2"><strong>Maintenance:</strong>
                                {{ $hemodialysis->heparin_maintenance ?? '' }} IU ×
                                {{ $hemodialysis->heparin_hr ?? '' }} Hr</td>
                        </tr>

                        <tr>
                            <td colspan="3"><strong>If Heparin free, Reason:</strong>
                                {{ $hemodialysis->heparin_reason ?? '' }}</td>
                        </tr>
                    </table>

                    <table width="100%" border="1" cellspacing="0" cellpadding="5"
                        style="margin-top:10px; border-collapse: collapse;">
                        <tr>
                            <td colspan="4" style="text-align:center;">
                                <h5><strong>TRANSFUSION HISTORY</strong></h5>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Last Hb%:</strong> {{ $hemodialysis->last_hb ?? '' }}</td>
                            <td><strong>Date of Test:</strong>
                                {{ isset($hemodialysis->test_date) ? date('d-m-Y', strtotime($hemodialysis->test_date)) : '' }}
                            </td>
                            <td><strong>Date of last Transfusion:</strong>
                                {{ isset($hemodialysis->last_date) ? date('d-m-Y', strtotime($hemodialysis->last_date)) : '' }}
                            </td>
                            <td><strong>Total No. of Transfusion:</strong> {{ $hemodialysis->total_transfusion ?? '' }}
                            </td>
                        </tr>
                        @php
                            $transfusionTypes = json_decode($hemodialysis->prbc ?? '[]', true) ?? [];
                            $healthEduTypes = json_decode($hemodialysis->health_edu ?? '[]', true) ?? [];
                        @endphp

                        <tr>
                            <td>Transfusion:</td>
                            <td colspan="3">
                                <label>
                                    <input type="checkbox" name="prbc[]" value="PRBC"
                                        {{ in_array('PRBC', $transfusionTypes) ? 'checked' : '' }}>
                                    PRBC
                                </label>
                                No: {{ isset($hemodialysis->prbc_no) ? $hemodialysis->prbc_no : '' }}

                                <label>
                                    <input type="checkbox" name="prbc[]" value="FFP"
                                        {{ in_array('FFP', $transfusionTypes) ? 'checked' : '' }}>
                                    FFP
                                </label>
                                No: {{ isset($hemodialysis->ffp_no) ? $hemodialysis->ffp_no : '' }}

                                <label>
                                    <input type="checkbox" name="prbc[]" value="Albumin"
                                        {{ in_array('Albumin', $transfusionTypes) ? 'checked' : '' }}>
                                    Albumin
                                </label>
                                No: {{ isset($hemodialysis->albumin_no) ? $hemodialysis->albumin_no : '' }}
                            </td>
                        </tr>

                    </table>

                    <table width="100%" border="1" cellspacing="0" cellpadding="5"
                        style="margin-top:10px; border-collapse: collapse;">
                        <tr>
                            <td colspan="4" style="text-align:center;">
                                <h5><strong>DOCTOR’S NOTES (Daily Clinical Assessment)</strong></h5>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">{{ $hemodialysis->doctor_notes ?? '' }}</td>
                        </tr>

                        <tr>
                            <td colspan="4" style="text-align:center;">
                                <h5><strong>INVESTIGATION</strong></h5>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Pre HD:</strong></td>
                            <td colspan="3">{{ $hemodialysis->pre_hd ?? '' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Post HD:</strong></td>
                            <td colspan="3">{{ $hemodialysis->post_hd ?? '' }}</td>
                        </tr>
                    </table>

                    <table width="100%" border="1" cellspacing="0" cellpadding="5"
                        style="margin-top:10px; border-collapse: collapse;">
                        <tr>
                            <td colspan="4" style="text-align:center;">
                                <h5><strong>PATIENT / FAMILY HEALTH EDUCATION</strong></h5>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                @php $healthEduTypes = json_decode($hemodialysis->health_edu ?? '[]', true) ?? []; @endphp
                                {{ implode(', ', $healthEduTypes) }}
                            </td>
                        </tr>
                    </table>
                    @php

                        $med_date = json_decode($hemodialysis->med_date ?? '[]', true) ?? [];
                        $med_time = json_decode($hemodialysis->med_time ?? '[]', true) ?? [];
                        $med_drug = json_decode($hemodialysis->med_drug ?? '[]', true) ?? [];
                        $med_dose = json_decode($hemodialysis->med_dose ?? '[]', true) ?? [];
                        $med_route = json_decode($hemodialysis->med_route ?? '[]', true) ?? [];
                        $med_freq = json_decode($hemodialysis->med_freq ?? '[]', true) ?? [];
                        $med_docsign = json_decode($hemodialysis->med_docsign ?? '[]', true) ?? [];
                        $med_admintime = json_decode($hemodialysis->med_admintime ?? '[]', true) ?? [];
                        $med_rnid = json_decode($hemodialysis->med_rnid ?? '[]', true) ?? [];
                        $med_countersign = json_decode($hemodialysis->med_countersign ?? '[]', true) ?? [];

                        $hasData = !empty($med_date) && is_array($med_date) && count($med_date) > 0;
                    @endphp


                    <table id="medTable" width="100%" border="1"
                        style="margin-top:10px; border-collapse:collapse;">
                        <thead>
                            <tr>
                                <th colspan="10" style="text-align: center">
                                    <h5>Medication Administration</h5></strong>
                                </th>
                            </tr>
                            <tr>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Name of Drug</th>
                                <th>Dose</th>
                                <th>Route</th>
                                <th>Frequency</th>
                                <th>Doctor Name</th>
                                <th>Administered Time</th>
                                <th>RN EMP</th>
                                <th>Counter Sign</th>

                            </tr>
                        </thead>
                        <tbody>
                            @if ($hasData)
                                @for ($i = 0; $i < count($med_date); $i++)
                                    <tr>
                                        <td>{{ isset($med_date[$i]) ? date('d-m-Y', strtotime($med_date[$i])) : '' }}
                                        </td>
                                        <td>{{ $med_time[$i] ?? '' }}</td>
                                        <td>{{ $med_drug[$i] ?? '' }}</td>
                                        <td>{{ $med_dose[$i] ?? '' }}</td>
                                        <td>{{ $med_route[$i] ?? '' }}</td>
                                        <td>{{ $med_freq[$i] ?? '' }}</td>
                                        <td>{{ $med_docsign[$i] ?? '' }}</td>
                                        <td>{{ $med_admintime[$i] ?? '' }}</td>
                                        <td>{{ $med_rnid[$i] ?? '' }}</td>
                                        <td>{{ $med_countersign[$i] ?? '' }}</td>

                                    </tr>
                                @endfor
                            @else
                                <tr>
                                    <td colspan="11" style="text-align:center;">No Medication Data Available</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    <table width="100%" border="1" cellspacing="0" cellpadding="5"
                        style="margin-top:10px; border-collapse: collapse;">
                        <tr>
                            <td colspan="3" class="text-center">
                                <h5><strong>THERAPIST / NURSE RECORD</strong></h5>
                            </td>
                        </tr>

                        <tr>
                            <td><strong>Access:</strong></td>
                            <td>
                                @php
                                    $access = json_decode($hemodialysis->acess ?? '[]', true) ?? [];
                                @endphp
                                {{ implode(', ', $access) }}
                            </td>
                            <td>
                                <strong>Right / Left:</strong> {{ ucfirst($hemodialysis->side ?? '') }}
                            </td>
                        </tr>

                        <tr>
                            <td><strong>Temporary Access Placed on (If Present):</strong>
                                {{ $hemodialysis->temp_access ?? '' }}</td>
                            <td colspan="2" style="text-align: center;"><strong>AVF</strong></td>
                        </tr>

                        <tr>
                            <td><strong>Heparin/Antibiotic Lock Aspirated:</strong> {{ $hemodialysis->heparin2 ?? '' }}
                            </td>
                            <td colspan="2"><strong>Created On:</strong>
                                {{ !empty($hemodialysis->created_on) ? date('d-m-Y', strtotime($hemodialysis->created_on)) : '' }}
                            </td>
                        </tr>

                        <tr>
                            <td rowspan="3">
                                <strong>Catheter Access Site:</strong>
                                @php
                                    $catheter = json_decode($hemodialysis->catheter_site ?? '[]', true) ?? [];
                                @endphp
                                {{ implode(', ', $catheter) }}
                            </td>
                            <td colspan="2"><strong>Ischemic Symptoms:</strong> {{ $hemodialysis->ischemic ?? '' }}
                            </td>
                        </tr>

                        <tr>
                            <td><strong>Outflow Stenosis:</strong> {{ $hemodialysis->outflow ?? '' }}</td>
                            <td>
                                <strong>Collapse of Vein:</strong> {{ $hemodialysis->collapse_vein ?? '' }} <br>
                                <strong>Water Hammer Pulse:</strong> {{ $hemodialysis->water_pulse ?? '' }}
                            </td>
                        </tr>

                        <tr>
                            <td><strong>Inflow Stenosis:</strong> {{ $hemodialysis->inflow ?? '' }}</td>
                            <td>
                                <strong>Continuous Bruit:</strong> {{ $hemodialysis->bruit ?? '' }} <br>
                                <strong>Pulse Augmentation:</strong> {{ $hemodialysis->pulse_aug ?? '' }}
                            </td>
                        </tr>

                        <tr>
                            <td colspan="3"><strong>Sign of Technician:</strong>
                                {{ $hemodialysis->tech_sign ?? '' }}</td>
                        </tr>
                    </table>


                    <table width="100%" border="1" cellspacing="0" cellpadding="5"
                        style="margin-top:10px; border-collapse: collapse;">
                        <tr>
                            <td><strong>Self-test of machine alarms passed:</strong>
                                {{ $hemodialysis->alarm_pass ?? '' }}</td>
                            <td><strong>Terminated By:</strong> {{ $hemodialysis->terminated_by ?? '' }}</td>
                        </tr>

                        <tr>
                            <td><strong>Dialysate pH between 6.5 & 7.5 with pH Meter:</strong>
                                {{ $hemodialysis->dialysate_ph ?? '' }}</td>
                            <td><strong>Kt/V (if applicable):</strong> {{ $hemodialysis->ktv ?? '' }}</td>
                        </tr>

                        <tr>
                            <td><strong>Renalin trace in effluent after priming:</strong>
                                {{ $hemodialysis->renalin_trace ?? '' }}</td>
                            <td><strong>Vascular Access Haemostasis Achieved:</strong>
                                {{ $hemodialysis->haemostasis ?? '' }}</td>
                        </tr>

                        <tr>
                            <td><strong>Pressure Leak test passed:</strong> {{ $hemodialysis->pressure_test ?? '' }}
                            </td>
                            <td><strong>Machine No:</strong> {{ $hemodialysis->machine_no ?? '' }}</td>
                        </tr>

                        <tr>
                            <td><strong>Priming done by:</strong> {{ $hemodialysis->priming_by ?? '' }}</td>
                            <td><strong>Dialyzer:</strong> {{ $hemodialysis->dialyzer ?? '' }}</td>
                        </tr>
                    </table>

                    <table width="100%" border="1" cellspacing="0" cellpadding="5"
                        style="margin-top:10px; border-collapse: collapse;">
                        <tr>
                            <td colspan="4" class="text-center">
                                <h5><strong>TIME OUT CHECKLIST</strong></h5>
                                (To be read out loud) The Following have been verified and confirmed:
                            </td>
                        </tr>
                        <tr>
                            @php
                                $timeoutchecklist = json_decode($hemodialysis->timeoutchecklist ?? '[]', true) ?? [];
                            @endphp
                            <td colspan="4">
                                {!! in_array('Patient', $timeoutchecklist) ? '✅ Correct Patient<br>' : '' !!}
                                {!! in_array('Site', $timeoutchecklist) ? '✅ Correct Site & Side Confirmed<br>' : '' !!}
                                {!! in_array('Consent', $timeoutchecklist) ? '✅ Consent for Procedure<br>' : '' !!}
                                {!! in_array('documents', $timeoutchecklist) ? '✅ All relevant documents<br>' : '' !!}
                                {!! in_array('Medical', $timeoutchecklist)
                                    ? '✅ Appropriate Medical Technology available and working (E.g. Dialyzer and Blood Tubing)<br>'
                                    : '' !!}
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2">Nurse Name: <strong>{{ @$hemodialysis->nurse_sign }}</strong></td>
                            <td colspan="2">Technician Name: <strong>{{ @$hemodialysis->tech_sign2 }}</strong></td>
                        </tr>
                    </table>

                    <table width="100%" border="1" cellspacing="0" cellpadding="5"
                        style="margin-top:10px; border-collapse: collapse;">
                        <tr>
                            <td class="text-center">
                                <h5><strong>PRE HD</strong></h5>
                            </td>
                            <td class="text-center">
                                <h5><strong>POST HD</strong></h5>
                            </td>
                        </tr>

                        <tr>
                            <td>Patient Entry Time:
                                @php $pre_entry_time = explode(' ', @$hemodialysis->pre_entry_time); @endphp
                                <strong>{{ $pre_entry_time[1] ?? '' }}</strong>
                            </td>
                            <td>Time of Termination:
                                @php $post_termination = explode(' ', @$hemodialysis->post_termination); @endphp
                                <strong>{{ $post_termination[1] ?? '' }}</strong>
                            </td>
                        </tr>

                        <tr>
                            <td>BP: <strong>{{ @$hemodialysis->pre_bp }}</strong> mmHg</td>
                            <td>BP: <strong>{{ @$hemodialysis->post_bp }}</strong> mmHg</td>
                        </tr>

                        <tr>
                            <td>SpO₂: <strong>{{ @$hemodialysis->pre_spo2 }}</strong> %</td>
                            <td>SpO₂: <strong>{{ @$hemodialysis->post_spo2 }}</strong> %</td>
                        </tr>

                        <tr>
                            <td>Pulse: <strong>{{ @$hemodialysis->pre_pulse }}</strong> /min</td>
                            <td>Pulse: <strong>{{ @$hemodialysis->post_pulse }}</strong> /min</td>
                        </tr>

                        <tr>
                            <td>Temp: <strong>{{ @$hemodialysis->pre_temp }}</strong> °F</td>
                            <td>Temp: <strong>{{ @$hemodialysis->post_temp }}</strong> °F</td>
                        </tr>

                        <tr>
                            <td>Weight: <strong>{{ @$hemodialysis->pre_weight }}</strong> kg</td>
                            <td>Weight: <strong>{{ @$hemodialysis->post_weight }}</strong> kg</td>
                        </tr>

                        <tr>
                            <td>Weight Gain: <strong>{{ @$hemodialysis->weight_gain }}</strong> kg</td>
                            <td>Weight Loss: <strong>{{ @$hemodialysis->weight_loss }}</strong> kg</td>
                        </tr>

                        <tr>
                            <td>Sensorium: <strong>{{ @$hemodialysis->pre_sensorium }}</strong></td>
                            <td>Sensorium: <strong>{{ @$hemodialysis->post_sensorium }}</strong></td>
                        </tr>

                        <tr>
                            <td>Starting Time:
                                @php $pre_start_time = explode(' ', @$hemodialysis->pre_start_time); @endphp
                                <strong>{{ $pre_start_time[1] ?? '' }}</strong>
                            </td>
                            <td>Patient Exit Time:
                                @php $post_exit_time = explode(' ', @$hemodialysis->post_exit_time); @endphp
                                <strong>{{ $post_exit_time[1] ?? '' }}</strong>
                            </td>
                        </tr>

                        <tr>
                            <td>Started By: <strong>{{ @$hemodialysis->started_by }}</strong></td>
                            <td>Discharge Criteria Met: <strong>{{ @$hemodialysis->discharge }}</strong></td>
                        </tr>

                        <tr>
                            <td>Name of Staff who received patient: <strong>{{ @$hemodialysis->pre_staff }}</strong>
                            </td>
                            <td>Name of Staff who sent patient: <strong>{{ @$hemodialysis->post_staff }}</strong></td>
                        </tr>
                    </table>
                    @php
                        $pain_time = json_decode($hemodialysis->pain_time ?? '[]', true) ?? [];
                        $pain_factor = json_decode($hemodialysis->pain_factor ?? '[]', true) ?? [];
                        $pain_type = json_decode($hemodialysis->pain_type ?? '[]', true) ?? [];
                        $pain_location = json_decode($hemodialysis->pain_location ?? '[]', true) ?? [];
                        $pain_score = json_decode($hemodialysis->pain_score ?? '[]', true) ?? [];
                        $pain_freq = json_decode($hemodialysis->pain_freq ?? '[]', true) ?? [];
                        $pain_duration = json_decode($hemodialysis->pain_duration ?? '[]', true) ?? [];
                        $pain_time2 = json_decode($hemodialysis->pain_time2 ?? '[]', true) ?? [];
                        $pain_intervention = json_decode($hemodialysis->pain_intervention ?? '[]', true) ?? [];
                        $pain_time3 = json_decode($hemodialysis->pain_time3 ?? '[]', true) ?? [];
                        $pain_postscore = json_decode($hemodialysis->pain_postscore ?? '[]', true) ?? [];
                        $hasPainData = !empty($pain_time) && is_array($pain_time) && count($pain_time) > 0;
                    @endphp

                    <table id="painTable" width="100%" border="1"
                        style="margin-top:10px; border-collapse:collapse;">
                        <thead>
                            <tr>
                                <td colspan="12">
                                    <h5><strong>MONITORING DURING DIALYSIS</strong></h5>
                                </td>
                            </tr>
                            <tr>
                                <th colspan="12">PAIN ASSESSMENT</th>
                            </tr>
                            <tr>
                                <th rowspan="2">Time</th>
                                <th colspan="5">Pain</th>
                                <th rowspan="2">Duration</th>
                                <th rowspan="2">Time</th>
                                <th rowspan="2">Intervention</th>
                                <th rowspan="2">Time</th>
                                <th rowspan="2">Post Intervention Score</th>
                            </tr>
                            <tr>
                                <th>Precipitating Factor</th>
                                <th>Type</th>
                                <th>Location</th>
                                <th>Pain Score</th>
                                <th>Frequency</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($hasPainData)
                                @for ($i = 0; $i < count($pain_time); $i++)
                                    <tr>
                                        <td>{{ $pain_time[$i] ?? '' }}</td>
                                        <td>{{ $pain_factor[$i] ?? '' }}</td>
                                        <td>{{ $pain_type[$i] ?? '' }}</td>
                                        <td>{{ $pain_location[$i] ?? '' }}</td>
                                        <td>{{ $pain_score[$i] ?? '' }}</td>
                                        <td>{{ $pain_freq[$i] ?? '' }}</td>
                                        <td>{{ $pain_duration[$i] ?? '' }}</td>
                                        <td>{{ $pain_time2[$i] ?? '' }}</td>
                                        <td>{{ $pain_intervention[$i] ?? '' }}</td>
                                        <td>{{ $pain_time3[$i] ?? '' }}</td>
                                        <td>{{ $pain_postscore[$i] ?? '' }}</td>
                                    </tr>
                                @endfor
                            @else
                                <tr>
                                    <td colspan="11" style="text-align:center;">No Pain Data Recorded</td>
                                </tr>
                            @endif
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="12">
                                    Precipitating factor:
                                    position/activity/stress/movement-walking/standing/lying/bending.
                                    Type of pain: sharp/Dull/Cramping/shooting/Pricking.
                                    If the pain score >2, inform doctor, follow doctor’s order and reassess pain.
                                </td>
                            </tr>
                        </tfoot>
                    </table>


                    <table class="table table-bordered">
                        <tr>
                            <td colspan="2" style="text-align: center;">
                                <h5><strong>FALL RISK ASSESSMENT AND SAFETY PRECAUTION</strong></h5>
                            </td>
                        </tr>
                        <tr>
                            <th>Adult fall risk screening</th>
                            <th>Yes/No</th>
                        </tr>
                        <tr>
                            <td>History of falling within past 3 months</td>
                            <td>{{ $hemodialysis->fall_history ?? '' }}</td>
                        </tr>
                        <tr>
                            <td>Ambulatory aids</td>
                            <td>{{ $hemodialysis->fall_ambulation ?? '' }}</td>
                        </tr>
                        <tr>
                            <td>• Wheelchair</td>
                            <td>{{ $hemodialysis->wheel_chair ?? '' }}</td>
                        </tr>
                        <tr>
                            <td>• Crutches/cane/walker</td>
                            <td>{{ $hemodialysis->crutches ?? '' }}</td>
                        </tr>
                        <tr>
                            <td>• Uses furniture for support</td>
                            <td>{{ $hemodialysis->furniture ?? '' }}</td>
                        </tr>
                        <tr>
                            <td>Gait / Transferring</td>
                            <td>{{ $hemodialysis->fall_gait ?? '' }}</td>
                        </tr>
                        <tr>
                            <td>• Bedrest/immobile</td>
                            <td>{{ $hemodialysis->fall_immobile ?? '' }}</td>
                        </tr>
                        <tr>
                            <td>• Weak</td>
                            <td>{{ $hemodialysis->fall_weak ?? '' }}</td>
                        </tr>
                        <tr>
                            <td>• Impaired</td>
                            <td>{{ $hemodialysis->fall_impaired ?? '' }}</td>
                        </tr>
                        <tr>
                            <td>Mental status</td>
                            <td>{{ $hemodialysis->mental ?? '' }}</td>
                        </tr>
                        <tr>
                            <td>• Forget limitations</td>
                            <td>{{ $hemodialysis->limitations ?? '' }}</td>
                        </tr>
                        <tr>
                            <th colspan="2">Paediatrics/Neonates fall prevention measures – up to 16 years</th>
                        </tr>
                        <tr>
                            <th colspan="2">All Paediatrics/neonates are considered at risk. Follow the fall
                                prevention measures:</th>
                        </tr>
                        @php
                            $safety_measures = json_decode($hemodialysis->safety_measures ?? '[]', true) ?? [];
                        @endphp
                        <tr>
                            <td>
                                @if (in_array('accompanied', $safety_measures))
                                    ✅
                                @endif Ensure child is carried/accompanied<br>
                                @if (in_array('escorted', $safety_measures))
                                    ✅
                                @endif Escort while shifting/moving
                            </td>
                            <td>
                                @if (in_array('secured', $safety_measures))
                                    ✅
                                @endif Secured with safety belts<br>
                                @if (in_array('educated', $safety_measures))
                                    ✅
                                @endif Educate family members
                            </td>
                        </tr>
                        <tr>
                            <th colspan="2">Note: If patient is "Yes" to any above, follow prevention measures:</th>
                        </tr>
                        @php
                            $escort = json_decode($hemodialysis->escort ?? '[]', true) ?? [];
                        @endphp
                        <tr>
                            <td>
                                @if (in_array('escort', $escort))
                                    ✅
                                @endif Escort with shifting<br>
                                @if (in_array('seatbelt', $escort))
                                    ✅
                                @endif Patient secured with seatbelt
                            </td>
                            <td>
                                @if (in_array('assist', $escort))
                                    ✅
                                @endif Assist the patient<br>
                                @if (in_array('educate', $escort))
                                    ✅
                                @endif Educate patient/family
                            </td>
                        </tr>
                    </table>
                    @php

                        $mon_time = json_decode($hemodialysis->mon_time ?? '[]', true) ?? [];
                        $mon_pulse = json_decode($hemodialysis->mon_pulse ?? '[]', true) ?? [];
                        $mon_bp = json_decode($hemodialysis->mon_bp ?? '[]', true) ?? [];
                        $mon_ufrate = json_decode($hemodialysis->mon_ufrate ?? '[]', true) ?? [];
                        $mon_ufvol = json_decode($hemodialysis->mon_ufvol ?? '[]', true) ?? [];
                        $mon_vp = json_decode($hemodialysis->mon_vp ?? '[]', true) ?? [];
                        $mon_ap = json_decode($hemodialysis->mon_ap ?? '[]', true) ?? [];
                        $mon_bflow = json_decode($hemodialysis->mon_bflow ?? '[]', true) ?? [];
                        $mon_spo2 = json_decode($hemodialysis->mon_spo2 ?? '[]', true) ?? [];
                        $mon_bleeding = json_decode($hemodialysis->mon_bleeding ?? '[]', true) ?? [];
                        $mon_remarks = json_decode($hemodialysis->mon_remarks ?? '[]', true) ?? [];

                        $hasMonData = !empty($mon_time) && is_array($mon_time) && count($mon_time) > 0;
                    @endphp
                    <table id="monitorTable" width="100%" border="1"
                        style="margin-top:10px; border-collapse:collapse;">
                        <thead>
                            <tr>
                                <td colspan="11" style="text-align:center;">
                                    <h5><strong>MONITORING CHART</strong></h5>
                                </td>
                            </tr>
                            <tr>
                                <th>Time</th>
                                <th>Pulse /min</th>
                                <th>BP mmHg</th>
                                <th>UF Rate</th>
                                <th>UF Volume</th>
                                <th>Venous Pressure</th>
                                <th>Arterial Pressure</th>
                                <th>Blood Flow</th>
                                <th>SpO2</th>
                                <th>Bleeding from access site</th>
                                <th>Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($hasMonData)
                                @for ($i = 0; $i < count($mon_time); $i++)
                                    <tr>
                                        <td>{{ $mon_time[$i] ?? '' }}</td>
                                        <td>{{ $mon_pulse[$i] ?? '' }}</td>
                                        <td>{{ $mon_bp[$i] ?? '' }}</td>
                                        <td>{{ $mon_ufrate[$i] ?? '' }}</td>
                                        <td>{{ $mon_ufvol[$i] ?? '' }}</td>
                                        <td>{{ $mon_vp[$i] ?? '' }}</td>
                                        <td>{{ $mon_ap[$i] ?? '' }}</td>
                                        <td>{{ $mon_bflow[$i] ?? '' }}</td>
                                        <td>{{ $mon_spo2[$i] ?? '' }}</td>
                                        <td>{{ $mon_bleeding[$i] ?? '' }}</td>
                                        <td>{{ $mon_remarks[$i] ?? '' }}</td>
                                    </tr>
                                @endfor
                            @else
                                <tr>
                                    <td colspan="11" style="text-align:center;">No monitoring data available</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    @php
                        $nurse_time = json_decode($hemodialysis->nurse_time ?? '[]', true) ?? [];
                        $nurse_notes = json_decode($hemodialysis->nurse_notes ?? '[]', true) ?? [];
                        $nurse_name = json_decode($hemodialysis->nurse_name ?? '[]', true) ?? [];
                        $hasNurseData = !empty($nurse_time) && is_array($nurse_time) && count($nurse_time) > 0;
                    @endphp

                    <table id="nurseNote" width="100%" border="1"
                        style="margin-top:10px; border-collapse:collapse;">
                        <thead>
                            <tr>
                                <th style="text-align: center;">Time</th>
                                <th style="text-align: center;">NURSES NOTES</th>
                                <th style="text-align: center;">Signature</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($hasNurseData)
                                @for ($i = 0; $i < count($nurse_time); $i++)
                                    <tr>
                                        <td>{{ $nurse_time[$i] ?? '' }}</td>
                                        <td>{{ $nurse_notes[$i] ?? '' }}</td>
                                        <td>{{ $nurse_name[$i] ?? '' }}</td>
                                    </tr>
                                @endfor
                            @else
                                <tr>
                                    <td colspan="3" style="text-align:center;">No nurse notes available</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    @php
                        $safety_precautions = json_decode($hemodialysis->safety_precautions ?? '[]', true) ?? [];
                    @endphp

                    <table width="100%" border="1" style="margin-top:10px; border-collapse:collapse;">
                        <tr>
                            <td colspan="2" class="text-center">
                                <h5><strong>PATIENT AND FAMILY EDUCATION</strong></h5>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Infection Control:
                                {{ in_array('Infection Control', $safety_precautions) ? 'Yes' : 'No' }} <br>
                                Fistula/line care:
                                {{ in_array('Fistula/line care', $safety_precautions) ? 'Yes' : 'No' }}
                            </td>
                            <td>
                                Safe use of medication:
                                {{ in_array('Safe use of medication', $safety_precautions) ? 'Yes' : 'No' }} <br>
                                Fall prevention measures:
                                {{ in_array('Fall prevention measures', $safety_precautions) ? 'Yes' : 'No' }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                Others: {{ $hemodialysis->pt_others ?? '-' }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="text-center">
                                <h5><strong>PATIENT RECORD AND REPORT CHECKED BY</strong></h5>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center"><strong>Hand over given by</strong></td>
                            <td class="text-center"><strong>Hand over taken by</strong></td>
                        </tr>
                        <tr>
                            <td>
                                RN: {{ $hemodialysis->rn_given ?? '-' }} <br>
                                Technician: {{ $hemodialysis->tech_given ?? '-' }}
                            </td>
                            <td>
                                RN: {{ $hemodialysis->rn_taken ?? '-' }} <br>
                                Technician: {{ $hemodialysis->tech_taken ?? '-' }}
                            </td>
                        </tr>
                    </table>

                    <table width="100%" border="1" style="margin-top:10px; border-collapse:collapse;">
                        <tr>
                            <td colspan="5" class="text-center">
                                <h5><strong>REPROCESSING</strong></h5>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">No. of Reuse Dialyzer</td>
                            <td class="text-center">No. of Reuse Blood Tubing</td>
                            <td class="text-center">FBV</td>
                            <td class="text-center">Dialyzer is reusable</td>
                            <td class="text-center">Checked by Technician</td>
                        </tr>
                        <tr>
                            <td>{{ $hemodialysis->dialyzer2 ?? '-' }}</td>
                            <td>{{ $hemodialysis->blood_tubing ?? '-' }}</td>
                            <td>{{ $hemodialysis->fbv ?? '-' }}</td>
                            <td>{{ $hemodialysis->reusable_dialyzer ?? '-' }}</td>
                            <td>{{ $hemodialysis->technician ?? '-' }}</td>
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
