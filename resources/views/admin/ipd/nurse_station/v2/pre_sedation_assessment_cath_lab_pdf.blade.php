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

        .criteria {
            margin-bottom: 10px;
        }

        .red-box {
            background: red;
            color: white;
            font-weight: bold;
            text-align: center;
            padding: 4px;
            font-size: 14px;
        }

        .task-box {
            border: 1px solid #000;
            width: 32%;
            padding: 4px;
        }

        .task-content {
            background: #ff4d4d;
            color: white;
            padding: 5px;
            height: 90px;
            font-size: 12px;
        }

        .task-footer {
            display: flex;
            justify-content: space-between;
            margin-top: 4px;
            font-size: 12px;
        }

        .task-footer input {
            width: 80px;
        }

        .footer-input {
            margin-top: 8px;
            width: 100%;
        }

        .signoff-table th,
        .signoff-table td {
            text-align: center;
            font-size: 12px;
        }

        .signoff-table input,
        .signoff-table select {
            width: 100%;
            box-sizing: border-box;
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
                    <table class="table table-bordered">
                        <tr>
                            <td width="20%">Diagnosis:</td>
                            <td colspan="3">{{ @$cath_lab->diagnosis }}</td>
                        </tr>
                        <tr>
                            <td>Proposed procedure:</td>
                            <td colspan="3">{{ @$cath_lab->proposed_procedure }}</td>
                        </tr>
                        <tr>
                            <td>Height:</td>
                            <td>{{ @$cath_lab->height }}</td>
                            <td>Weight:</td>
                            <td>{{ @$cath_lab->weight }}</td>
                        </tr>
                        <tr>
                            <td>Allergies:</td>
                            <td colspan="3">{{ @$cath_lab->allergies }}</td>
                        </tr>
                        <tr>
                            <td>History of Pre-Anesthesia/Surgery:</td>
                            <td colspan="3">{{ @$cath_lab->history_pre_anesthesia }}</td>
                        </tr>
                        <tr>
                            <td>Current medication:</td>
                            <td colspan="3">{{ @$cath_lab->current_medication }}</td>
                        </tr>

                        <!-- PHYSICAL EXAMINATION -->
                        <tr class="header-row center">
                            <td colspan="4">PHYSICAL EXAMINATION</td>
                        </tr>
                        <tr>
                            <td>PULSE:</td>
                            <td>{{ @$cath_lab->pulse }}</td>
                            <td>BP:</td>
                            <td>{{ @$cath_lab->bp }}</td>
                        </tr>
                        <tr>
                            <td>SPO₂:</td>
                            <td>{{ @$cath_lab->spo2 }}</td>
                            <td>RR:</td>
                            <td>{{ @$cath_lab->rr }}</td>
                        </tr>
                        <tr>
                            <td>TEMP:</td>
                            <td>{{ @$cath_lab->temp }}</td>
                            <td colspan="2"></td>
                        </tr>
                        <tr>
                            <td colspan="4"><b>Airway</b></td>
                        </tr>

                        <tr>
                            <td>ASA grade:</td>
                            <td>{{ @$cath_lab->asa_grade }}</td>
                            <td>Denture / Others:</td>
                            <td>{{ @$cath_lab->denture }}</td>
                        </tr>
                        <tr>
                            <td>Risk factors(if any):</td>
                            <td>{{ @$cath_lab->risk_fact }}</td>
                            <td>Others:</td>
                            <td>{{ @$cath_lab->air_other }}</td>
                        </tr>
                        <tr>
                            <td><b>CARDIOVASCULAR:</b></td>
                            <td>{{ @$cath_lab->cardiovascular }}</td>
                            <td><b>RESPIRATORY:</b></td>
                            <td>{{ @$cath_lab->respiratory }}</td>
                        </tr>
                        <tr>
                            <td><b>CNS:</b></td>
                            <td>{{ @$cath_lab->cns }}</td>
                            <td><b>EXTREMITY:</b></td>
                            <td>{{ @$cath_lab->extremity }}</td>
                        </tr>
                        <tr>
                            <td><b>HEPATIC/RENAL:</b></td>
                            <td>{{ @$cath_lab->hepatic_renal }}</td>
                            <td><b>ENDOCRINE:</b></td>
                            <td>{{ @$cath_lab->endocrine }}</td>
                        </tr>

                        <!-- INVESTIGATIONS -->
                        <tr class="header-row center">
                            <td colspan="4">INVESTIGATIONS</td>
                        </tr>
                        <tr>
                            <td>Blood Group:</td>
                            <td>{{ @$cath_lab->blood_group }}</td>
                            <td>Urea:</td>
                            <td>{{ @$cath_lab->urea }}</td>
                        </tr>
                        <tr>
                            <td>HCT/Hb:</td>
                            <td>{{ @$cath_lab->hct_hb }}</td>
                            <td>Creatinine:</td>
                            <td>{{ @$cath_lab->creatinine }}</td>
                        </tr>
                        <tr>
                            <td>Platelet:</td>
                            <td>{{ @$cath_lab->platelet }}</td>
                            <td>Blood Sugar:</td>
                            <td>{{ @$cath_lab->blood_sugar }}</td>
                        </tr>
                        <tr>
                            <td>Na⁺:</td>
                            <td>{{ @$cath_lab->na }}</td>
                            <td>K⁺:</td>
                            <td>{{ @$cath_lab->k }}</td>
                        </tr>
                        <tr>
                            <td>ECG:</td>
                            <td>{{ @$cath_lab->ecg }}</td>
                            <td>ETT:</td>
                            <td>{{ @$cath_lab->ett }}</td>
                        </tr>
                        <tr>
                            <td>CXR:</td>
                            <td>{{ @$cath_lab->cxr }}</td>
                            <td>ECHO:</td>
                            <td>{{ @$cath_lab->echo }}</td>
                        </tr>
                        <tr>
                            <td>EF:</td>
                            <td>{{ @$cath_lab->ef }}</td>
                            <td>USD/ASD:</td>
                            <td>{{ @$cath_lab->usd_asd }}</td>
                        </tr>
                        <tr>
                            <td>Valvular:</td>
                            <td colspan="3">{{ @$cath_lab->valvular }}</td>
                        </tr>

                        <tr>
                            <td>Others:</td>
                            <td colspan="3">{{ @$cath_lab->others }}</td>
                        </tr>
                        <tr>
                            <td>Pre-procedure instructions:</td>
                            <td colspan="3">{{ @$cath_lab->pre_procedure_instructions }}</td>
                        </tr>
                        <tr>
                            <td>Nothing by mouth:</td>
                            <td colspan="3">{{ @$cath_lab->nothing_by_mouth }}</td>
                        </tr>
                        <tr>
                            <td>Pre-medications given:</td>
                            <td colspan="3">{{ @$cath_lab->pre_medications }}</td>
                        </tr>
                        <tr>
                            <td>Other advice:</td>
                            <td colspan="3">{{ @$cath_lab->other_advice }}</td>
                        </tr>
                    </table>

                    <br>

                    <table class="table table-bordered">
                        <tr>
                            <td><b>Anesthetist / Intensivist</b></td>
                            <td><b>Name:</b> {{ @$cath_lab->anesthetist }}</td>
                            <td><b>Emp. ID:</b> {{ @$cath_lab->anesthetist_empid }}</td>
                            <td><b>Date & Time:</b>
                                {{ isset($cath_lab->anesthetist_dt) ? date('Y-m-d H:i', strtotime($cath_lab->anesthetist_dt)) : '' }}
                            </td>
                        </tr>
                    </table>

                    <br>
                    <h4 style="text-align: center">PRE-PROCEDURE RECORD</h4>

                    <!-- PRE-PROCEDURE CHECKLIST -->
                    <table class="table table-bordered">
                        <tr class="header-row">
                            <td colspan="4">PRE-PROCEDURE CHECKLIST : (TO BE FILLED BY NURSE)</td>
                        </tr>

                        <tr>
                            <th>ELEMENTS</th>
                            <th>YES / NO / NA</th>
                            <th>ELEMENTS</th>
                            <th>YES / NO / NA</th>
                        </tr>

                        <tr>
                            <td>Nil by mouth from:</td>
                            <td>{{ @$cath_lab->nil_by_mouth }}</td>
                            <td>IV line in situ with heplock</td>
                            <td>{{ @$cath_lab->heplock }}</td>
                        </tr>

                        <tr>
                            <td>Consent Taken</td>
                            <td>{{ @$cath_lab->consent_taken }}</td>
                            <td>Investigations reports received</td>
                            <td>{{ @$cath_lab->investigations }}</td>
                        </tr>

                        <tr>
                            <td>Vital signs recorded</td>
                            <td>{{ @$cath_lab->vital_rec }}</td>
                            <td>Dentures/eyeglass removed</td>
                            <td>{{ @$cath_lab->dentures_removed }}</td>
                        </tr>

                        <tr>
                            <td>Pre-procedure medications given</td>
                            <td>{{ @$cath_lab->med_given }}</td>
                            <td>History & physical exam completed</td>
                            <td>{{ @$cath_lab->his_phy }}</td>
                        </tr>
                    </table>

                    <!-- VITALS -->
                    <br>
                    <table class="table table-bordered">
                        <tr class="header-row">
                            <td colspan="6">VITALS</td>
                        </tr>
                        <tr>
                            <td>TEMP: {{ @$cath_lab->v_temp }}</td>
                            <td>HR: {{ @$cath_lab->v_hr }}</td>
                            <td>RR: {{ @$cath_lab->v_rr }}</td>
                            <td>BP: {{ @$cath_lab->v_bp }}</td>
                            <td>SpO₂: {{ @$cath_lab->v_spo2 }}</td>
                            <td>Pain Score: {{ @$cath_lab->v_pain_score }}</td>
                        </tr>

                        <tr>
                            <td rowspan="2"><b>NURSE</b></td>
                            <td colspan="2"><b>Name</b></td>
                            <td><b>Emp.ID:</b></td>
                            <td colspan="2"><b>Time</b></td>
                        </tr>
                        <tr>
                            <td colspan="2">{{ @$cath_lab->nurse_name }}</td>
                            <td>{{ @$cath_lab->nurse_empid }}</td>
                            <td colspan="2">{{ $nurse_time[1] ?? '' }}</td>
                        </tr>
                    </table>

                    <br>
                    <table class="table table-bordered">
                        <tr class="header-row">
                            <td colspan="4" style="text-align: center">TO BE FILLED IN BY ANESTHETIST :</td>
                        </tr>
                        @php
                            $ivStarted = json_decode($cath_lab->iv_started ?? '[]', true) ?? [];
                        @endphp
                        <tr>
                            <td><label><input type="checkbox" name="iv_started[]" value="1"
                                        {{ in_array('1', $ivStarted) ? 'checked' : '' }}> IV
                                    Started</label></td>
                            <td><label><input type="checkbox" name="iv_started[]" value="2"
                                        {{ in_array('2', $ivStarted) ? 'checked' : '' }}>
                                    Cardiac Monitor</label></td>
                            <td><label><input type="checkbox" name="iv_started[]" value="3"
                                        {{ in_array('3', $ivStarted) ? 'checked' : '' }}>
                                    Suction Ready</label></td>
                            <td><label><input type="checkbox" name="iv_started[]" value="4"
                                        {{ in_array('4', $ivStarted) ? 'checked' : '' }}>
                                    Naloxone @ bedside</label></td>
                        </tr>
                        <tr>
                            <td><label><input type="checkbox" name="iv_started[]" value="5"
                                        {{ in_array('5', $ivStarted) ? 'checked' : '' }}> SpO₂
                                    Monitor</label></td>
                            <td><label><input type="checkbox" name="iv_started[]" value="6"
                                        {{ in_array('6', $ivStarted) ? 'checked' : '' }}> O₂ @
                                    Bedside</label></td>
                            <td><label><input type="checkbox" name="iv_started[]" value="7"
                                        {{ in_array('7', $ivStarted) ? 'checked' : '' }}> Ambu
                                    Bag
                                    @
                                    Bedside</label></td>
                            <td><label><input type="checkbox" name="iv_started[]" value="8"
                                        {{ in_array('8', $ivStarted) ? 'checked' : '' }}>
                                    Flumazenil @ Bedside</label></td>
                        </tr>


                        <tr>
                            <td><b>Anesthetist / Intensivist</b></td>
                            <td><b>Name:</b> {{ @$cath_lab->anesthetist2 }}</td>
                            <td><b>Emp. ID:</b> {{ @$cath_lab->anesthetist2_empid }}</td>
                            <td><b>Date & Time:</b>
                                {{ isset($cath_lab->anesthetist2_dt) ? date('Y-m-d H:i', strtotime($cath_lab->anesthetist2_dt)) : '' }}
                            </td>
                        </tr>
                    </table>

                    <!-- TIME OUT CHECKLIST -->
                    <br>
                    <table class="table table-bordered">
                        <tr class="header-row">
                            <td colspan="4">TIME OUT CHECKLIST</td>
                            <td colspan="3">TIME OUT PARTICIPANTS</td>
                        </tr>
                        <tr>
                            <th>ELEMENTS</th>
                            <th>YES</th>
                            <th>NO</th>
                            <th>REMARKS</th>
                            <th></th>
                            <th>Name</th>
                            <th>Emp.ID</th>
                        </tr>

                        <tr>
                            <td>Patient's name and ID checked?</td>
                            <td colspan="2">{{ @$cath_lab->pt_nameid }}</td>
                            <td>{{ @$cath_lab->toc_remarks1 }}</td>
                            <td rowspan="2">Doctor</td>
                            <td rowspan="2">{{ @$cath_lab->toc_docname }}</td>
                            <td rowspan="2">{{ @$cath_lab->toc_docid }}</td>
                        </tr>

                        <tr>
                            <td>Consent for procedure obtained?</td>
                            <td colspan="2">{{ @$cath_lab->consent_obtained_toc }}</td>
                            <td>{{ @$cath_lab->toc_remarks2 }}</td>
                        </tr>

                        <tr>
                            <td>Is correct site/side prepared and draped?</td>
                            <td colspan="2">{{ @$cath_lab->site_side_prepared }}</td>
                            <td>{{ @$cath_lab->toc_remarks3 }}</td>
                            <td rowspan="3">Nurse</td>
                            <td rowspan="3">{{ @$cath_lab->toc_nursename }}</td>
                            <td rowspan="3">{{ @$cath_lab->toc_nurseid }}</td>
                        </tr>
                        <tr>
                            <td>Is there anything unique or non-routine about this procedure?</td>
                            <td colspan="2">{{ @$cath_lab->non_routing }}</td>
                            <td>{{ @$cath_lab->toc_remarks4 }}</td>
                        </tr>
                        <tr>
                            <td>Availability of correct equipment/Implant/Documents?</td>
                            <td colspan="2">{{ @$cath_lab->eid }}</td>
                            <td>{{ @$cath_lab->toc_remarks5 }}</td>
                        </tr>
                        <tr>
                            <td>Is relevant investigations/essential radiological imaging available?</td>
                            <td colspan="2">{{ @$cath_lab->iriria }}</td>
                            <td>{{ @$cath_lab->toc_remarks6 }}</td>
                            <td rowspan="4">Technologist</td>
                            <td rowspan="4">{{ @$cath_lab->toc_tecname }}</td>
                            <td rowspan="4">{{ @$cath_lab->toc_tecid }}</td>
                        </tr>
                        <tr>
                            <td>HBsAg/Hepatitis C/HIV status checked? (if applicable)</td>
                            <td colspan="2">{{ @$cath_lab->hiv_check }}</td>
                            <td>{{ @$cath_lab->toc_remarks7 }}</td>
                        </tr>
                        <tr>
                            <td>Antibiotic prophylaxis given? (If applicable)</td>
                            <td colspan="2">{{ @$cath_lab->apg }}</td>
                            <td>{{ @$cath_lab->toc_remarks8 }}</td>
                        </tr>

                        <tr>
                            <td>Sterility confirmed?</td>
                            <td colspan="2">{{ @$cath_lab->sc }}</td>
                            <td>{{ @$cath_lab->toc_remarks9 }}</td>
                        </tr>
                    </table>

                    <br>
                    <h4 style="text-align: center">INTRA-PROCEDURAL RECORD</h4>
                    <table class="table table-bordered">
                        <tr>
                            <td colspan="4"><b>Procedure start time:</b></td>
                            <td>{{ $p_start[1] ?? '' }}</td>
                        </tr>
                        <tr>
                            <td><b>Approach:</b></td>
                            <td>RADIAL {{ @$cath_lab->a_radial }}</td>
                            <td>FEMORAL {{ @$cath_lab->a_femoral }}</td>
                            <td>ULNER {{ @$cath_lab->a_ulner }}</td>
                            <td>OTHER {{ @$cath_lab->a_other }}</td>
                        </tr>
                        <tr>
                            <td colspan="5"><b>INTRA PROCEDURE SEDATION MONITORING</b></td>
                        </tr>
                        @php
                            $equipment = json_decode($cath_lab->equipment ?? '[]', true) ?? [];
                        @endphp
                        <tr>
                            <td colspan="5"><b>Equipment Check:</b>
                                <label><input type="checkbox" name="equipment[]" value="1"
                                        {{ in_array('1', $equipment) ? 'checked' : '' }}>
                                    O<sub>2</sub> port with circuit</label>
                                <label><input type="checkbox" name="equipment[]" value="2"
                                        {{ in_array('2', $equipment) ? 'checked' : '' }}>
                                    Suction</label>
                                <label><input type="checkbox" name="equipment[]" value="3"
                                        {{ in_array('3', $equipment) ? 'checked' : '' }}>
                                    Drugs</label>
                            </td>

                        </tr>
                    </table>

                    <br>

                    <table class="table table-bordered">
                        <tr>
                            <td colspan="4"><b>Event Note:</b></td>
                        </tr>
                        <tr>
                            <td colspan="4">{{ @$cath_lab->event_note }}</td>
                        </tr>

                        <tr>
                            <td><b>Anesthetist / Intensivist</b></td>
                            <td><b>Name:</b> {{ @$cath_lab->anesthetist3 }}</td>
                            <td><b>Emp. ID:</b> {{ @$cath_lab->anesthetist3_empid }}</td>
                            <td><b>Date & Time:</b>
                                {{ isset($cath_lab->anesthetist3_dt) ? date('Y-m-d H:i', strtotime($cath_lab->anesthetist3_dt)) : '' }}
                            </td>
                        </tr>
                    </table>

                    <br>

                    <table class="table table-bordered">
                        <tr class="header-row">
                            <td colspan="4">SIGN OUT CHECKLIST</td>
                            <td colspan="3">Sign out particiapnt</td>
                        </tr>
                        <tr>
                            <th colspan="4">Name of the procedure done:</th>
                            <th rowspan="3">Nurse</th>
                            <th>Name</th>
                            <th>Emp.ID</th>
                        </tr>
                        <tr>
                            <th>ELEMENTS</th>
                            <th>YES</th>
                            <th>NO</th>
                            <th>REMARKS</th>
                            <td rowspan="2">{{ @$cath_lab->soc_nursename }}</td>
                            <td rowspan="2">{{ @$cath_lab->soc_nurseid }}</td>
                        </tr>

                        <tr>
                            <td>Instrument/sponge/needle counts are verified?</td>
                            <td colspan="2">{{ @$cath_lab->isncav }}</td>
                            <td>{{ @$cath_lab->soc_remarks1 }}</td>
                        </tr>

                        <tr>
                            <td>Labelling of specimen done? (if any)</td>
                            <td colspan="2">{{ @$cath_lab->losd }}</td>
                            <td>{{ @$cath_lab->soc_remarks2 }}</td>
                            <td rowspan="2"><b>Technologist (If applicable)</b></td>
                            <td rowspan="2">{{ @$cath_lab->soc_tecname }}</td>
                            <td rowspan="2">{{ @$cath_lab->soc_tecid }}</td>
                        </tr>

                        <tr>
                            <td>Any equipment problem to be addressed?</td>
                            <td colspan="2">{{ @$cath_lab->aeptba }}</td>
                            <td>{{ @$cath_lab->soc_remarks3 }}</td>
                        </tr>
                    </table>

                    <br>
                    <h4 style="text-align: center">POST PROCEDURE RECORD</h4>
                    <table class="table table-bordered">
                        <tr>
                            <td colspan="4"><b>PROCEDURE NOTES</b></td>
                        </tr>
                        <tr>
                            <td colspan="4"><b>Findings:</b></td>
                        </tr>
                        <tr>
                            <td colspan="4">{{ @$cath_lab->finding }}</td>
                        </tr>
                        <tr>
                            <td colspan="4"><b>Recommendation:</b></td>
                        </tr>
                        <tr>
                            <td colspan="4">{{ @$cath_lab->recommend }}</td>
                        </tr>
                        <tr>
                            <td colspan="4" style="text-align: left"><b>CORONARY ANGIOGRAM</b></td>
                        </tr>
                        <tr>
                            <td colspan="4">{{ @$cath_lab->coronary }}</td>
                        </tr>
                    </table>

                    <h4 style="text-align: center">POST PROCEDURE ORDER</h4>

                    <table class="table table-bordered">
                        <tr>
                            @php
                                $vital_sign = json_decode($cath_lab->vital_sign ?? '[]', true) ?? [];
                            @endphp
                            <td> 1. Observe vital signs:
                                <label><input type="checkbox" name="vital_sign[]" value="1"
                                        {{ in_array('1', $vital_sign) ? 'checked' : '' }}>
                                    Every 15 min for 1 hour</label>
                                <label><input type="checkbox" name="vital_sign[]" value="2"
                                        {{ in_array('2', $vital_sign) ? 'checked' : '' }}>
                                    Every 30 min for 1 hour</label>
                                <label><input type="checkbox" name="vital_sign[]" value="3"
                                        {{ in_array('3', $vital_sign) ? 'checked' : '' }}>
                                    Every hourly for 6 hours</label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                2. Watch puncture site/cut down site for bleeding. If swelling apply pressure and inform
                                doctor<br>
                                3. Watch for reaction (allergies) to contrast media e.g.. rashes<br>
                                4. In case of femoral approach, patient should not bend the leg at hip, sit up, stand up
                                for 6 hours. He/she should be assisted when eating, drinking, passing urine etc. during
                                this time. In case of arm approach, patient can mobilize when clinical condition is
                                suitable.
                            </td>
                        </tr>
                        <tr>
                            @php
                                $relevent_pulse = json_decode($cath_lab->relevent_pulse ?? '[]', true) ?? [];
                            @endphp
                            <td> 5. Check the relevant pulse:
                                <label><input type="checkbox" name="relevent_pulse[]" value="1"
                                        {{ in_array('1', $relevent_pulse) ? 'checked' : '' }}>
                                    Radial Pulse for arm approach</label>
                                <label><input type="checkbox" name="relevent_pulse[]" value="2"
                                        {{ in_array('2', $relevent_pulse) ? 'checked' : '' }}>
                                    Posterior Tibialis/Dorsalis pedis pulse for femoral
                                    approach</label>

                            </td>
                        </tr>
                        <tr>
                            @php
                                $sheath = json_decode($cath_lab->sheath ?? '[]', true) ?? [];
                            @endphp
                            <td> 6. Sheath Removal:
                                <label><input type="checkbox" name="sheath[]" value="1"
                                        {{ in_array('1', $sheath) ? 'checked' : '' }}>
                                    Cath Lab</label>
                                <label><input type="checkbox" name="sheath[]" value="2"
                                        {{ in_array('2', $sheath) ? 'checked' : '' }}>CCU/CHDU/Post
                                    Cath/Ward/Cabin</label>

                            </td>
                        </tr>
                        <tr>
                            <td>7. Other Instructions: </td>
                        </tr>
                        <tr>
                            <td>{{ @$cath_lab->otherinstruct }}</td>
                        </tr>
                    </table>

                    <br>
                    <table class="table table-bordered">
                        <tr>
                            <td>Doctor</td>
                            <td>Name {{ @$cath_lab->v_doc_name }}</td>
                            <td>Emp. ID {{ @$cath_lab->v_doc_empid }}</td>
                            <td>Time {{ $v_doc_time[1] ?? '' }}</td>
                        </tr>
                    </table>

                    <br>

                    @php
                        $time_list = !empty($cath_lab->time) ? json_decode($cath_lab->time, true) : [];
                        $temp_list = !empty($cath_lab->temp2) ? json_decode($cath_lab->temp2, true) : [];
                        $hr_list = !empty($cath_lab->hr) ? json_decode($cath_lab->hr, true) : [];
                        $rr_list = !empty($cath_lab->rr2) ? json_decode($cath_lab->rr2, true) : [];
                        $bp_list = !empty($cath_lab->bp2) ? json_decode($cath_lab->bp2, true) : [];
                        $spo2_list = !empty($cath_lab->spo2_2) ? json_decode($cath_lab->spo2_2, true) : [];
                        $act_time_list = !empty($cath_lab->act_time) ? json_decode($cath_lab->act_time, true) : [];
                        $act_res_list = !empty($cath_lab->act_result) ? json_decode($cath_lab->act_result, true) : [];
                    @endphp

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th colspan="6">Post Procedure Vitals</th>
                                <th colspan="3">ACT</th>
                            </tr>
                            <tr>
                                <th>TIME</th>
                                <th>TEMP</th>
                                <th>HR/Pulse</th>
                                <th>RR</th>
                                <th>BP</th>
                                <th>SpO₂</th>
                                <th>TIME</th>
                                <th>RESULT</th>
                            </tr>
                        </thead>
                        <tbody id="vitals">
                            @if (!empty($time_list))
                                @foreach ($time_list as $i => $time)
                                    <tr>
                                        <td>{{ $time }}</td>
                                        <td>{{ $temp_list[$i] ?? '' }}</td>
                                        <td>{{ $hr_list[$i] ?? '' }}</td>
                                        <td>{{ $rr_list[$i] ?? '' }}</td>
                                        <td>{{ $bp_list[$i] ?? '' }}</td>
                                        <td>{{ $spo2_list[$i] ?? '' }}</td>
                                        <td>{{ $act_time_list[$i] ?? '' }}</td>
                                        <td>{{ $act_res_list[$i] ?? '' }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>

                    <br>
                    <table class="table table-bordered">
                        <tr>
                            <td>Pain Score:</td>
                            <td>{{ @$cath_lab->pain_score }}</td>
                            <td>Fall Score:</td>
                            <td>{{ @$cath_lab->fall_score }}</td>
                        </tr>
                        <tr>
                            <td>Nurse</td>
                            <td>Name {{ @$cath_lab->vnurse }}</td>
                            <td>Emp. ID {{ @$cath_lab->vnurse_empid }}</td>
                            <td>Time {{ $vnurse_time[1] ?? '' }}</td>
                        </tr>
                    </table>

                    <br>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <td colspan="9" style="text-align: center"><b>MODIFIED ALDRETE RECOVERY SCORE</b>
                                    <br>
                                    <label>(To be filled in by Nurse under supervision of Doctor)</label>
                                    <label> These parameters should be monitored every 15 minutes. Total score is 10. A
                                        Score 29 (and/or are returned to similar pre-op status) are considered fit to be
                                        discharged from recovery area.</label>
                                </td>
                            </tr>
                            <tr>
                                <th>Criteria</th>
                                <th>Parameter</th>
                                <th>Scale</th>
                                <th class="time-header">INITIAL</th>
                                <th class="time-header">15'</th>
                                <th class="time-header">30'</th>
                                <th class="time-header">45'</th>
                                <th class="time-header">60'</th>
                                <th class="time-header">AT DISCHARGE</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $atmfe = json_decode($cath_lab->atmfe ?? '[]', true) ?? [];
                                $atmte = json_decode($cath_lab->atmte ?? '[]', true) ?? [];
                                $utme = json_decode($cath_lab->utme ?? '[]', true) ?? [];
                                $atbdcf = json_decode($cath_lab->atbdcf ?? '[]', true) ?? [];
                                $dolb = json_decode($cath_lab->dolb ?? '[]', true) ?? [];
                                $bopl = json_decode($cath_lab->bopl ?? '[]', true) ?? [];
                                $bpl = json_decode($cath_lab->bpl ?? '[]', true) ?? [];
                                $fa = json_decode($cath_lab->fa ?? '[]', true) ?? [];
                                $aon = json_decode($cath_lab->aon ?? '[]', true) ?? [];
                                $nr = json_decode($cath_lab->nr ?? '[]', true) ?? [];
                                $atmsor = json_decode($cath_lab->atmsor ?? '[]', true) ?? [];
                                $notms = json_decode($cath_lab->notms ?? '[]', true) ?? [];
                                $sewo = json_decode($cath_lab->sewo ?? '[]', true) ?? [];
                            @endphp

                            <tr>
                                <td rowspan="3" class="criteria-header">Activity</td>
                                <td class="parameter">Able to move four extremities</td>
                                <td class="score-cell">2</td>
                                <td><input type="checkbox" data-score="2" data-time="initial" name="atmfe[]"
                                        value="1" {{ in_array('1', $atmfe) ? 'checked' : '' }}></td>
                                <td><input type="checkbox" data-score="2" data-time="15" name="atmfe[]"
                                        value="2" {{ in_array('2', $atmfe) ? 'checked' : '' }}>
                                </td>
                                <td><input type="checkbox" data-score="2" data-time="30" name="atmfe[]"
                                        value="3" {{ in_array('3', $atmfe) ? 'checked' : '' }}>
                                </td>
                                <td><input type="checkbox" data-score="2" data-time="45" name="atmfe[]"
                                        value="4" {{ in_array('4', $atmfe) ? 'checked' : '' }}>
                                </td>
                                <td><input type="checkbox" data-score="2" data-time="60" name="atmfe[]"
                                        value="5" {{ in_array('5', $atmfe) ? 'checked' : '' }}>
                                </td>
                                <td><input type="checkbox" data-score="2" data-time="discharge" name="atmfe[]"
                                        value="6" {{ in_array('6', $atmfe) ? 'checked' : '' }}>
                                </td>
                            </tr>
                            <tr>
                                <td class="parameter">Able to move two extremities</td>
                                <td class="score-cell">1</td>
                                <td><input type="checkbox" data-score="1" data-time="initial" name="atmte[]"
                                        value="1" {{ in_array('1', $atmte) ? 'checked' : '' }}></td>
                                <td><input type="checkbox" data-score="1" data-time="15" name="atmte[]"
                                        value="2" {{ in_array('2', $atmte) ? 'checked' : '' }}>
                                </td>
                                <td><input type="checkbox" data-score="1" data-time="30" name="atmte[]"
                                        value="3" {{ in_array('3', $atmte) ? 'checked' : '' }}>
                                </td>
                                <td><input type="checkbox" data-score="1" data-time="45" name="atmte[]"
                                        value="4" {{ in_array('4', $atmte) ? 'checked' : '' }}>
                                </td>
                                <td><input type="checkbox" data-score="1" data-time="60" name="atmte[]"
                                        value="5" {{ in_array('5', $atmte) ? 'checked' : '' }}>
                                </td>
                                <td><input type="checkbox" data-score="1" data-time="discharge" name="atmte[]"
                                        value="6" {{ in_array('6', $atmte) ? 'checked' : '' }}>
                                </td>
                            </tr>
                            <tr>
                                <td class="parameter">Unable to move extremities</td>
                                <td class="score-cell">0</td>
                                <td><input type="checkbox" data-score="0" data-time="initial" name="utme[]"
                                        value="1" {{ in_array('1', $atmte) ? 'checked' : '' }}></td>
                                <td><input type="checkbox" data-score="0" data-time="15" name="utme[]"
                                        value="2" {{ in_array('2', $atmte) ? 'checked' : '' }}>
                                </td>
                                <td><input type="checkbox" data-score="0" data-time="30" name="utme[]"
                                        value="3" {{ in_array('3', $atmte) ? 'checked' : '' }}>
                                </td>
                                <td><input type="checkbox" data-score="0" data-time="45" name="utme[]"
                                        value="4" {{ in_array('4', $atmte) ? 'checked' : '' }}>
                                </td>
                                <td><input type="checkbox" data-score="0" data-time="60" name="utme[]"
                                        value="5" {{ in_array('5', $atmte) ? 'checked' : '' }}>
                                </td>
                                <td><input type="checkbox" data-score="0" data-time="discharge" name="utme[]"
                                        value="6" {{ in_array('6', $atmte) ? 'checked' : '' }}>
                                </td>
                            </tr>

                            <!-- Respiration -->
                            <tr>
                                <td rowspan="2" class="criteria-header">Respiration</td>
                                <td class="parameter">Able to breathe deeply and cough freely
                                </td>
                                <td class="score-cell">2</td>
                                <td><input type="checkbox" data-score="2" data-time="initial" name="atbdcf[]"
                                        value="1" {{ in_array('1', $atbdcf) ? 'checked' : '' }}></td>
                                <td><input type="checkbox" data-score="2" data-time="15" name="atbdcf[]"
                                        value="2" {{ in_array('2', $atbdcf) ? 'checked' : '' }}>
                                </td>
                                <td><input type="checkbox" data-score="2" data-time="30" name="atbdcf[]"
                                        value="3" {{ in_array('3', $atbdcf) ? 'checked' : '' }}>
                                </td>
                                <td><input type="checkbox" data-score="2" data-time="45" name="atbdcf[]"
                                        value="4" {{ in_array('4', $atbdcf) ? 'checked' : '' }}>
                                </td>
                                <td><input type="checkbox" data-score="2" data-time="60" name="atbdcf[]"
                                        value="5" {{ in_array('5', $atbdcf) ? 'checked' : '' }}>
                                </td>
                                <td><input type="checkbox" data-score="2" data-time="discharge" name="atbdcf[]"
                                        value="6" {{ in_array('6', $atbdcf) ? 'checked' : '' }}></td>
                            </tr>
                            <tr>
                                <td class="parameter">Dyspnea or limited breathing</td>
                                <td class="score-cell">1</td>
                                <td><input type="checkbox" data-score="1" data-time="initial" name="dolb[]"
                                        value="1" {{ in_array('1', $dolb) ? 'checked' : '' }}>
                                </td>
                                <td><input type="checkbox" data-score="1" data-time="15" name="dolb[]"
                                        value="2" {{ in_array('2', $dolb) ? 'checked' : '' }}>
                                </td>
                                <td><input type="checkbox" data-score="1" data-time="30" name="dolb[]"
                                        value="3" {{ in_array('3', $dolb) ? 'checked' : '' }}>
                                </td>
                                <td><input type="checkbox" data-score="1" data-time="45" name="dolb[]"
                                        value="4" {{ in_array('4', $dolb) ? 'checked' : '' }}>
                                </td>
                                <td><input type="checkbox" data-score="1" data-time="60" name="dolb[]"
                                        value="5" {{ in_array('5', $dolb) ? 'checked' : '' }}>
                                </td>
                                <td><input type="checkbox" data-score="1" data-time="discharge" name="dolb[]"
                                        value="6" {{ in_array('6', $dolb) ? 'checked' : '' }}></td>
                            </tr>


                            <tr>
                                <td rowspan="2" class="criteria-header">Circulation</td>
                                <td class="parameter">BP ± 20% of preanesthetic level</td>
                                <td class="score-cell">2</td>
                                <td><input type="checkbox" data-score="2" data-time="initial" name="bopl[]"
                                        value="1" {{ in_array('1', $bopl) ? 'checked' : '' }}>
                                </td>
                                <td><input type="checkbox" data-score="2" data-time="15" name="bopl[]"
                                        value="2" {{ in_array('2', $bopl) ? 'checked' : '' }}>
                                </td>
                                <td><input type="checkbox" data-score="2" data-time="30" name="bopl[]"
                                        value="3" {{ in_array('3', $bopl) ? 'checked' : '' }}>
                                </td>
                                <td><input type="checkbox" data-score="2" data-time="45" name="bopl[]"
                                        value="4" {{ in_array('4', $bopl) ? 'checked' : '' }}>
                                </td>
                                <td><input type="checkbox" data-score="2" data-time="60" name="bopl[]"
                                        value="5" {{ in_array('5', $bopl) ? 'checked' : '' }}>
                                </td>
                                <td><input type="checkbox" data-score="2" data-time="discharge" name="bopl[]"
                                        value="6" {{ in_array('6', $bopl) ? 'checked' : '' }}></td>
                            </tr>
                            <tr>
                                <td class="parameter">BP ± 20-50% of preanesthetic level</td>
                                <td class="score-cell">1</td>
                                <td><input type="checkbox" data-score="1" data-time="initial" name="bpl[]"
                                        value="1" {{ in_array('1', $bpl) ? 'checked' : '' }}>
                                </td>
                                <td><input type="checkbox" data-score="1" data-time="15" name="bpl[]"
                                        value="2" {{ in_array('2', $bpl) ? 'checked' : '' }}>
                                </td>
                                <td><input type="checkbox" data-score="1" data-time="30" name="bpl[]"
                                        value="3" {{ in_array('3', $bpl) ? 'checked' : '' }}>
                                </td>
                                <td><input type="checkbox" data-score="1" data-time="45" name="bpl[]"
                                        value="4" {{ in_array('4', $bpl) ? 'checked' : '' }}>
                                </td>
                                <td><input type="checkbox" data-score="1" data-time="60" name="bpl[]"
                                        value="5" {{ in_array('5', $bpl) ? 'checked' : '' }}>
                                </td>
                                <td><input type="checkbox" data-score="1" data-time="discharge" name="bpl[]"
                                        value="6" {{ in_array('6', $bpl) ? 'checked' : '' }}></td>
                            </tr>


                            <tr>
                                <td rowspan="3" class="criteria-header">Consciousness
                                </td>
                                <td class="parameter">Fully awake</td>
                                <td class="score-cell">2</td>
                                <td><input type="checkbox" data-score="2" data-time="initial" name="fa[]"
                                        value="1" {{ in_array('1', $fa) ? 'checked' : '' }}>
                                </td>
                                <td><input type="checkbox" data-score="2" data-time="15" name="fa[]"
                                        value="2" {{ in_array('2', $fa) ? 'checked' : '' }}>
                                </td>
                                <td><input type="checkbox" data-score="2" data-time="30" name="fa[]"
                                        value="3" {{ in_array('1', $fa) ? 'checked' : '' }}>
                                </td>
                                <td><input type="checkbox" data-score="2" data-time="45" name="fa[]"
                                        value="4" {{ in_array('4', $fa) ? 'checked' : '' }}>
                                </td>
                                <td><input type="checkbox" data-score="2" data-time="60" name="fa[]"
                                        value="5" {{ in_array('5', $fa) ? 'checked' : '' }}>
                                </td>
                                <td><input type="checkbox" data-score="2" data-time="discharge" name="fa[]"
                                        value="6" {{ in_array('6', $fa) ? 'checked' : '' }}></td>
                            </tr>
                            <tr>
                                <td class="parameter">Arousable on calling</td>
                                <td class="score-cell">1</td>
                                <td><input type="checkbox" data-score="1" data-time="initial" name="aon[]"
                                        value="1" {{ in_array('1', $aon) ? 'checked' : '' }}>
                                </td>
                                <td><input type="checkbox" data-score="1" data-time="15" name="aon[]"
                                        value="2" {{ in_array('2', $aon) ? 'checked' : '' }}>
                                </td>
                                <td><input type="checkbox" data-score="1" data-time="30" name="aon[]"
                                        value="3" {{ in_array('3', $aon) ? 'checked' : '' }}>
                                </td>
                                <td><input type="checkbox" data-score="1" data-time="45" name="aon[]"
                                        value="4" {{ in_array('4', $aon) ? 'checked' : '' }}>
                                </td>
                                <td><input type="checkbox" data-score="1" data-time="60" name="aon[]"
                                        value="5" {{ in_array('5', $aon) ? 'checked' : '' }}>
                                </td>
                                <td><input type="checkbox" data-score="1" data-time="discharge" name="aon[]"
                                        value="6" {{ in_array('6', $aon) ? 'checked' : '' }}></td>
                            </tr>
                            <tr>
                                <td class="parameter">Not responding</td>
                                <td class="score-cell">0</td>
                                <td><input type="checkbox" data-score="0" data-time="initial" name="nr[]"
                                        value="1" {{ in_array('1', $nr) ? 'checked' : '' }}>
                                </td>
                                <td><input type="checkbox" data-score="0" data-time="15" name="nr[]"
                                        value="2" {{ in_array('2', $nr) ? 'checked' : '' }}>
                                </td>
                                <td><input type="checkbox" data-score="0" data-time="30" name="nr[]"
                                        value="3" {{ in_array('3', $nr) ? 'checked' : '' }}>
                                </td>
                                <td><input type="checkbox" data-score="0" data-time="45" name="nr[]"
                                        value="4" {{ in_array('4', $nr) ? 'checked' : '' }}>
                                </td>
                                <td><input type="checkbox" data-score="0" data-time="60" name="nr[]"
                                        value="5" {{ in_array('5', $nr) ? 'checked' : '' }}>
                                </td>
                                <td><input type="checkbox" data-score="0" data-time="discharge" name="nr[]"
                                        value="6" {{ in_array('6', $nr) ? 'checked' : '' }}></td>
                            </tr>


                            <tr>
                                <td rowspan="3" class="criteria-header">Oxygenation</td>
                                <td class="parameter">Able to maintain saturation >92% on room
                                    air</td>
                                <td class="score-cell">2</td>
                                <td><input type="checkbox" data-score="2" data-time="initial" name="atmsor[]"
                                        value="1" {{ in_array('1', $atmsor) ? 'checked' : '' }}></td>
                                <td><input type="checkbox" data-score="2" data-time="15" name="atmsor[]"
                                        value="2" {{ in_array('2', $atmsor) ? 'checked' : '' }}>
                                </td>
                                <td><input type="checkbox" data-score="2" data-time="30" name="atmsor[]"
                                        value="3" {{ in_array('3', $atmsor) ? 'checked' : '' }}>
                                </td>
                                <td><input type="checkbox" data-score="2" data-time="45" name="atmsor[]"
                                        value="4" {{ in_array('4', $atmsor) ? 'checked' : '' }}>
                                </td>
                                <td><input type="checkbox" data-score="2" data-time="60" name="atmsor[]"
                                        value="5" {{ in_array('5', $atmsor) ? 'checked' : '' }}>
                                </td>
                                <td><input type="checkbox" data-score="2" data-time="discharge" name="atmsor[]"
                                        value="6" {{ in_array('6', $atmsor) ? 'checked' : '' }}></td>
                            </tr>
                            <tr>
                                <td class="parameter">Needs oxygen to maintain saturation >90%
                                </td>
                                <td class="score-cell">1</td>
                                <td><input type="checkbox" data-score="1" data-time="initial" name="notms[]"
                                        value="1" {{ in_array('1', $notms) ? 'checked' : '' }}>
                                </td>
                                <td><input type="checkbox" data-score="1" data-time="15" name="notms[]"
                                        value="2" {{ in_array('2', $notms) ? 'checked' : '' }}>
                                </td>
                                <td><input type="checkbox" data-score="1" data-time="30" name="notms[]"
                                        value="3" {{ in_array('3', $notms) ? 'checked' : '' }}>
                                </td>
                                <td><input type="checkbox" data-score="1" data-time="45" name="notms[]"
                                        value="4" {{ in_array('4', $notms) ? 'checked' : '' }}>
                                </td>
                                <td><input type="checkbox" data-score="1" data-time="60" name="notms[]"
                                        value="5" {{ in_array('5', $notms) ? 'checked' : '' }}>
                                </td>
                                <td><input type="checkbox" data-score="1" data-time="discharge" name="notms[]"
                                        value="6" {{ in_array('6', $notms) ? 'checked' : '' }}></td>
                            </tr>
                            <tr>
                                <td class="parameter">Saturation &lt;90% even with oxygen</td>
                                <td class="score-cell">0</td>
                                <td><input type="checkbox" data-score="0" data-time="initial" name="sewo[]"
                                        value="1" {{ in_array('1', $sewo) ? 'checked' : '' }}>
                                </td>
                                <td><input type="checkbox" data-score="0" data-time="15" name="sewo[]"
                                        value="2" {{ in_array('2', $sewo) ? 'checked' : '' }}>
                                </td>
                                <td><input type="checkbox" data-score="0" data-time="30" name="sewo[]"
                                        value="3" {{ in_array('3', $sewo) ? 'checked' : '' }}>
                                </td>
                                <td><input type="checkbox" data-score="0" data-time="45" name="sewo[]"
                                        value="4" {{ in_array('4', $sewo) ? 'checked' : '' }}>
                                </td>
                                <td><input type="checkbox" data-score="0" data-time="60" name="sewo[]"
                                        value="5" {{ in_array('5', $sewo) ? 'checked' : '' }}>
                                </td>
                                <td><input type="checkbox" data-score="0" data-time="discharge" name="sewo[]"
                                        value="6" {{ in_array('6', $sewo) ? 'checked' : '' }}></td>
                            </tr>


                            <tr class="total-row">
                                <td colspan="2">Total Score</td>
                                <td id="max-score">10</td>
                                <td>{{ @$cath_lab->score_initial }}</td>
                                <td>{{ @$cath_lab->score_15 }}</td>
                                <td>{{ @$cath_lab->score_30 }}</td>
                                <td>{{ @$cath_lab->score_45 }}</td>
                                <td>{{ @$cath_lab->score_60 }}</td>
                                <td>{{ @$cath_lab->score_discharge }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <br>

                    <table class="table table-bordered">
                        <tr>
                            <td><b>Nurse</b></td>
                            <td><b>Name </b>{{ @$cath_lab->mnurse }}</td>
                            <td><b>Emp. ID </b>{{ @$cath_lab->hmnurse_empid }}</td>
                            <td> <b>Time </b>{{ $mnurse_time[1] ?? '' }}</td>
                        </tr>
                        <tr>
                            <td>Patient fit for discharge:</td>
                            <td colspan="3">{{ @$cath_lab->pt_discharge }}</td>
                        </tr>
                        <tr>
                            <td><b>Anesthetist</b></td>
                            <td> <b>Name</b> {{ @$cath_lab->manesthetist }}</td>
                            <td><b>Emp. ID</b> {{ @$cath_lab->manesthetist_id }}</td>
                            <td><b>Time</b> {{ $manesthetist_time[1] ?? '' }}</td>
                        </tr>
                        <tr>
                            <td colspan="4"><b>Nursing Notes:</b></td>
                        </tr>
                        <tr>
                            <td colspan="4">{{ @$cath_lab->nursing_notes }}</td>
                        </tr>
                        <tr>
                            @php
                                $transfer = json_decode($cath_lab->transfer ?? '[]', true) ?? [];
                            @endphp
                            <td colspan="4" style="text-align: left">
                                <b>Transfer to:</b>
                                <label><input type="checkbox" name="transfer[]" value="1"
                                        {{ in_array('1', $transfer) ? 'checked' : '' }}>
                                    Pre/Post cath</label>
                                <label><input type="checkbox" name="transfer[]" value="2"
                                        {{ in_array('2', $transfer) ? 'checked' : '' }}>
                                    CHDU</label>
                                <label><input type="checkbox" name="transfer[]" value="3"
                                        {{ in_array('3', $transfer) ? 'checked' : '' }}>
                                    CCU</label>
                                <label><input type="checkbox" name="transfer[]" value="4"
                                        {{ in_array('4', $transfer) ? 'checked' : '' }}>
                                    Others</label> <br>
                                others: {{ @$cath_lab->t_others }}
                            </td>
                        </tr>
                        <tr>
                            @php
                                $condition = json_decode($cath_lab->condition ?? '[]', true) ?? [];
                            @endphp
                            <td colspan="4">
                                <b>Condition at transfer:</b>
                                <label><input type="checkbox" name="condition[]" value="1"
                                        {{ in_array('1', $condition) ? 'checked' : '' }}>
                                    Stable</label>
                                <label><input type="checkbox" name="condition[]" value="2"
                                        {{ in_array('2', $condition) ? 'checked' : '' }}>
                                    Critical</label>

                            </td>

                        </tr>
                        <tr>
                            <th></th>
                            <th>Name</th>
                            <th>Emp. ID</th>
                            <th>Date & Time</th>
                        </tr>
                        <tr>
                            <td>Transferring Staff</td>
                            <td>{{ @$cath_lab->trans_name }}</td>
                            <td>{{ @$cath_lab->trans_empid }}</td>
                            <td>{{ isset($cath_lab->trans_date) ? date('Y-m-d H:i', strtotime($cath_lab->trans_date)) : '' }}
                            </td>
                        </tr>
                        <tr>
                            <td>Receiving Staff</td>
                            <td>{{ @$cath_lab->recv_name }}</td>
                            <td>{{ @$cath_lab->recv_empid }}</td>
                            <td>{{ isset($cath_lab->recv_date) ? date('Y-m-d H:i', strtotime($cath_lab->recv_date)) : '' }}
                            </td>
                        </tr>
                    </table>

                    <br>

                    @php
                        $date_list = !empty($cath_lab->mr_date) ? json_decode($cath_lab->mr_date, true) : [];
                        $time_list = !empty($cath_lab->mr_time) ? json_decode($cath_lab->mr_time, true) : [];
                        $drug_list = !empty($cath_lab->mr_drug) ? json_decode($cath_lab->mr_drug, true) : [];
                        $doc_list = !empty($cath_lab->mr_doc) ? json_decode($cath_lab->mr_doc, true) : [];
                        $emp_list = !empty($cath_lab->mr_emp) ? json_decode($cath_lab->mr_emp, true) : [];
                        $admin_list = !empty($cath_lab->mr_admin) ? json_decode($cath_lab->mr_admin, true) : [];
                    @endphp

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th colspan="7" style="text-align: center">MEDICATION ADMINISTRATION RECORD</th>
                            </tr>
                            <tr>
                                <th rowspan="2" style="text-align: center">Date & Time</th>
                                <th rowspan="2" style="text-align: center">Drug Name<br>
                                    <small>(With Dose, Route & Frequency)<br>Infusion: Rate & Duration</small>
                                </th>
                                <th colspan="2" style="text-align: center">Doctor</th>
                                <th colspan="2" style="text-align: center">Administration Record</th>
                            </tr>
                            <tr>
                                <th>Sign</th>
                                <th>Emp. ID</th>
                                <th>Admin. Time</th>
                                <th>Checked By</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!empty($date_list))
                                @foreach ($date_list as $i => $mr_date)
                                    <tr>
                                        <td>{{ $mr_date }}</td>
                                        <td>{{ $time_list[$i] ?? '' }}</td>
                                        <td>{{ $drug_list[$i] ?? '' }}</td>
                                        <td>{{ $doc_list[$i] ?? '' }}</td>
                                        <td>{{ $emp_list[$i] ?? '' }}</td>
                                        <td>{{ $admin_list[$i] ?? '' }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>

                </td>
            </tr>
    </table>
