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
                        <span style="font-size: 16px;"><b>PROCEDURE SHEET WITHOUT SEDATION-CATH LAB</b></span>
                    </div>
                    <table class="table table-bordered">
                        <tr>
                            <td>Name of procedure:</td>
                            <td>{{ @$cath_lab->procedure_name }}</td>
                            <td>Date of procedure:</td>
                            <td>{{ isset($cath_lab->procedure_date) ? date('Y-m-d', strtotime($cath_lab->procedure_date)) : '' }}
                            </td>
                        </tr>
                        <tr>
                            <td>Indication of procedure:</td>
                            <td colspan="3">{{ @$cath_lab->procedure_indication }}</td>
                        </tr>
                        <tr>
                            <td>Known Allergy:</td>
                            <td colspan="3">{{ @$cath_lab->known_allergy }}</td>
                        </tr>
                    </table>

                    <br>
                    <table class="table table-bordered">
                        <tr class="header-row center">
                            <td colspan="2">PRE-PROCEDURE CHECKLIST (To be filled by nursing)</td>
                            <td width="15%">YES</td>
                            <td width="15%">NO</td>
                            <td width="20%">NOT APPLICABLE</td>
                        </tr>

                        <tr>
                            <td colspan="2">Nil by mouth from:</td>
                            <td colspan="3">{{ @$cath_lab->nil_mouth }}</td>
                        </tr>

                        <tr>
                            <td colspan="2">Vital signs recorded</td>
                            <td colspan="3">{{ @$cath_lab->vital_sign }}</td>
                        </tr>

                        <tr>
                            <td colspan="2">Pre-procedure medications given</td>
                            <td colspan="3">{{ @$cath_lab->pre_med }}</td>
                        </tr>

                        <tr>
                            <td colspan="2">IV line in situ with heplock</td>
                            <td colspan="3">{{ @$cath_lab->iv_line }}</td>
                        </tr>

                        <tr>
                            <td colspan="2">Investigations reports received</td>
                            <td colspan="3">{{ @$cath_lab->investigations }}</td>
                        </tr>

                        <tr>
                            <td colspan="2">Dentures/eyeglass removed</td>
                            <td colspan="3">{{ @$cath_lab->dentures_removed }}</td>
                        </tr>

                        <tr>
                            <td colspan="2">History and physical examination completed</td>
                            <td colspan="3">{{ @$cath_lab->his_completed }}</td>
                        </tr>
                    </table>

                    <br>
                    <table class="table table-bordered">
                        <tr class="header-row">
                            <td>TIME</td>
                            <td>TEMPERATURE</td>
                            <td>HR/Pulse</td>
                            <td>RR</td>
                            <td>BP</td>
                            <td>SpO₂</td>
                            <td>Pain Score</td>
                        </tr>
                        <tr>
                            <td>{{ @$cath_lab->pp_time }}</td>
                            <td>{{ @$cath_lab->pp_temp }}</td>
                            <td>{{ @$cath_lab->hr_pulse }}</td>
                            <td>{{ @$cath_lab->pp_rr }}</td>
                            <td>{{ @$cath_lab->pp_bp }}</td>
                            <td>{{ @$cath_lab->pp_spo2 }}</td>
                            <td>{{ @$cath_lab->pp_pain }}</td>
                        </tr>
                    </table>

                    <br>
                    <table class="table table-bordered">
                        <tr>
                            <td>Nurse</td>
                            <td>Emp. ID</td>
                            <td>Time</td>
                        </tr>
                        <tr>
                            <td>{{ @$cath_lab->nurse }}</td>
                            <td>{{ @$cath_lab->emp_id }}</td>
                            @php
                                $sign_time = explode(' ', @$cath_lab->sign_time);
                            @endphp
                            <td>{{ $sign_time[1] ?? '' }}</td>
                        </tr>
                    </table> <br>

                    <table class="table table-bordered">
                        <tr>
                            <th colspan="6">BLOOD REPORTS</th>
                        </tr>
                        <tr>
                            <td>Hb {{ @$cath_lab->br_hb }}</td>
                            <td colspan="3">PLT {{ @$cath_lab->br_plt }}</td>
                            <td>RBS {{ @$cath_lab->br_rbs }}</td>
                            <td>HIV {{ @$cath_lab->br_hiv }}</td>
                        </tr>
                        <tr>
                            <td>TRBC {{ @$cath_lab->br_trbc }}</td>
                            <td colspan="3">TLC {{ @$cath_lab->br_tlc }}</td>
                            <td>FBS {{ @$cath_lab->br_fbs }}</td>
                            <td>HCV {{ @$cath_lab->br_hcv }}</td>
                        </tr>
                        <tr>
                            <td>PCV {{ @$cath_lab->br_pcv }}</td>
                            <td>DC {{ @$cath_lab->br_dc }}</td>
                            <td>N {{ @$cath_lab->br_n }}</td>
                            <td>L {{ @$cath_lab->br_l }}</td>
                            <td>UREA {{ @$cath_lab->br_urea }}</td>
                            <td>HbsAg {{ @$cath_lab->br_hbsag }}</td>
                        </tr>
                        <tr>
                            <td>MCV {{ @$cath_lab->br_mcv }}</td>
                            <td colspan="2">M {{ @$cath_lab->br_m }}</td>
                            <td>E {{ @$cath_lab->br_e }}</td>
                            <td>CREATININE {{ @$cath_lab->br_creatinine }}</td>
                            <td>APTT {{ @$cath_lab->br_aptt }}</td>
                        </tr>
                        <tr>
                            <td>MCH {{ @$cath_lab->br_mch }}</td>
                            <td colspan="3">ESR {{ @$cath_lab->br_esr }}</td>
                            <td>SODIUM {{ @$cath_lab->br_sodium }}</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>MCHC {{ @$cath_lab->br_mchc }}</td>
                            <td colspan="3">GROUP {{ @$cath_lab->br_group }}</td>
                            <td>POTASSIUM {{ @$cath_lab->br_potassium }}</td>
                            <td></td>
                        </tr>
                    </table> <br>

                    <table class="table table-bordered">
                        <tr>
                            <td colspan="4" style="font-weight:bold; text-align:center;">
                                TIME OUT CHECKLIST (In cath lab before puncture/skin incision)
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4"><b>Name of procedure planned:</b></td>
                        </tr>
                        <tr>
                            <th>ELEMENTS</th>
                            <th>YES</th>
                            <th>NO</th>
                            <th>REMARKS</th>
                        </tr>
                        <tr>
                            <td>Patients name and ID checked?</td>
                            <td colspan="2">{{ @$cath_lab->pt_nameid }}</td>
                            <td>{{ @$cath_lab->remarks1 }}</td>
                        </tr>
                        <tr>
                            <td>Consent for procedure obtained?</td>
                            <td colspan="2">{{ @$cath_lab->consent }}</td>
                            <td>{{ @$cath_lab->remarks2 }}</td>
                        </tr>
                        <tr>
                            <td>Is the correct site/side prepared and draped?</td>
                            <td colspan="2">{{ @$cath_lab->site_prepared }}</td>
                            <td>{{ @$cath_lab->remarks3 }}</td>
                        </tr>
                        <tr>
                            <td>Is there anything unique or non-routine about this procedure?</td>
                            <td colspan="2">{{ @$cath_lab->u_procedure }}</td>
                            <td>{{ @$cath_lab->remarks4 }}</td>
                        </tr>
                        <tr>
                            <td>Availability of correct equipment/Implant/ Document?</td>
                            <td colspan="2">{{ @$cath_lab->correct_docu }}</td>
                            <td>{{ @$cath_lab->remarks5 }}</td>
                        </tr>
                        <tr>
                            <td>Is relevant investigations/essential imaging available?</td>
                            <td colspan="2">{{ @$cath_lab->img_available }}</td>
                            <td>{{ @$cath_lab->remarks6 }}</td>
                        </tr>
                        <tr>
                            <td>HBsAg/Hepatitis C/HIV status checked? (If applicable)</td>
                            <td colspan="2">{{ @$cath_lab->hiv_status }}</td>
                            <td>{{ @$cath_lab->remarks7 }}</td>
                        </tr>
                        <tr>
                            <td>Antibiotic prophylaxis given? (if applicable)</td>
                            <td colspan="2">{{ @$cath_lab->prophylaxis }}</td>
                            <td>{{ @$cath_lab->remarks8 }}</td>
                        </tr>
                        <tr>
                            <td>Sterility confirmed?</td>
                            <td colspan="2">{{ @$cath_lab->sterility }}</td>
                            <td>{{ @$cath_lab->remarks9 }}</td>
                        </tr>

                        <tr>
                            @php
                                $timeout_done = explode(' ', @$cath_lab->timeout_done);
                            @endphp
                            <td colspan="3"><b>TIME OUT DONE AT :</b></td>
                            <td>{{ $timeout_done[1] ?? '' }}</td>
                        </tr>
                    </table> <br>

                    <table class="table table-bordered">
                        <tr>
                            <td>Doctor</td>
                            <td>Name: {{ @$cath_lab->doctor_name }}</td>
                            <td>Signature: {{ @$cath_lab->doctor_name }}</td>
                            <td>Emp. ID: {{ @$cath_lab->doctor_empid }}</td>
                        </tr>
                        <tr>
                            <td>Scrub Nurse</td>
                            <td>Name: {{ @$cath_lab->nurse_name }}</td>
                            <td>Signature: {{ @$cath_lab->nurse_name }}</td>
                            <td>Emp. ID: {{ @$cath_lab->nurse_empid }}</td>
                        </tr>
                        <tr>
                            <td>Technician (if applicable)</td>
                            <td>Name: {{ @$cath_lab->tech_name }}</td>
                            <td>Signature: {{ @$cath_lab->tech_name }}</td>
                            <td>Emp. ID: {{ @$cath_lab->tech_empid }}</td>
                        </tr>
                    </table> <br>

                    <table class="table table-bordered">
                        <tr>
                            @php
                                $p_start = explode(' ', @$cath_lab->p_start);
                            @endphp
                            <td colspan="5">Procedure start time: {{ $p_start[1] ?? '' }}</td>

                        </tr>
                        <tr>
                            <td>Approach:</td>
                            <td>
                                RADIAL : {{ @$cath_lab->a_radial }}

                            </td>
                            <td>
                                FEMORAL : {{ @$cath_lab->a_femoral }}

                            </td>
                            <td>
                                ULNER : {{ @$cath_lab->a_ulner }}

                            </td>
                            <td>
                                OTHER :{{ @$cath_lab->a_other }}

                            </td>
                        </tr>
                    </table> <br>
                    @php
                        // Intra-procedural vitals (paired cols)
                        $time1_list = !empty($cath_lab->time1) ? json_decode($cath_lab->time1, true) : [];
                        $hr1_list = !empty($cath_lab->hr1) ? json_decode($cath_lab->hr1, true) : [];
                        $rr1_list = !empty($cath_lab->rr1) ? json_decode($cath_lab->rr1, true) : [];
                        $bp1_list = !empty($cath_lab->bp1) ? json_decode($cath_lab->bp1, true) : [];

                        $time2_list = !empty($cath_lab->time2) ? json_decode($cath_lab->time2, true) : [];
                        $hr2_list = !empty($cath_lab->hr2) ? json_decode($cath_lab->hr2, true) : [];
                        $rr2_list = !empty($cath_lab->rr2) ? json_decode($cath_lab->rr2, true) : [];
                        $bp2_list = !empty($cath_lab->bp2) ? json_decode($cath_lab->bp2, true) : [];
                    @endphp
                    <table class="table table-bordered">
                        <tr>
                            <th colspan="9">INTRAPROCEDURAL VITALS MONITORING</th>
                        </tr>
                        <tr>
                            <th>TIME</th>
                            <th>HR</th>
                            <th>RR</th>
                            <th>BP</th>
                            <th>TIME</th>
                            <th>HR</th>
                            <th>RR</th>
                            <th>BP</th>

                        </tr>
                        <tbody id="vitalsTable">
                            @if (!empty($time1_list))
                                @foreach ($time1_list as $i => $time1)
                                    <tr>
                                        <td>{{ $time1 }}</td>
                                        <td>{{ $hr1_list[$i] ?? '' }}</td>
                                        <td>{{ $rr1_list[$i] ?? '' }}</td>
                                        <td>{{ $bp1_list[$i] ?? '' }}</td>
                                        <td>{{ $time2_list[$i] ?? '' }}</td>
                                        <td>{{ $hr2_list[$i] ?? '' }}</td>
                                        <td>{{ $rr2_list[$i] ?? '' }}</td>
                                        <td>{{ $bp2_list[$i] ?? '' }}</td>

                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="8" style="text-align: center"><b>No Data Available</b></td>
                                </tr>
                            @endif
                        </tbody>
                    </table> <br>
                    <table class="table table-bordered">
                        <tr>
                            @php
                                $v_doc_time = explode(' ', @$cath_lab->v_doc_time);
                            @endphp
                            <td>Doctor</td>
                            <td>Name: {{ @$cath_lab->v_doc_name }}</td>
                            <td>Emp. ID: {{ @$cath_lab->v_doc_empid }}</td>
                            <td>Time: {{ $v_doc_time[1] ?? '' }}</td>
                        </tr>
                    </table> <br>

                    <table class="table table-bordered">
                        <tr>
                            <td colspan="4" style="font-weight:bold; text-align:center;">
                                SIGN OUT CHECKLIST (BEFORE PATIENT LEAVES CATH LAB)
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4"><b>Name of procedure done:</b></td>
                        </tr>
                        <tr>
                            <th>ELEMENTS</th>
                            <th>YES</th>
                            <th>NO</th>
                            <th>REMARKS</th>
                        </tr>
                        <tr>
                            <td>Instrument/sponge/needle counts are verified?</td>
                            <td colspan="2">{{ @$cath_lab->instrument }}</td>
                            <td>{{ @$cath_lab->i_remarks }}</td>
                        </tr>
                        <tr>
                            <td>Labelling of specimen done? (If any)</td>
                            <td colspan="2">{{ @$cath_lab->specimen }}</td>
                            <td>{{ @$cath_lab->s_remarks }}</td>
                        </tr>
                        <tr>
                            <td>Any equipment problem to be addressed?</td>
                            <td colspan="2">{{ @$cath_lab->equipment }}</td>
                            <td>{{ @$cath_lab->e_remarks }}</td>
                        </tr>
                        <tr>
                            <td colspan="3"><b>Sign out done at :</b></td>
                            <td>{{ @$cath_lab->signout_done }}</td>
                        </tr>
                    </table> <br>

                    <table class="table table-bordered">
                        <tr>
                            <td>Scrub Nurse</td>
                            <td colspan="2">Name: {{ @$cath_lab->nurse_name2 }}</td>
                            <td>Signature: {{ @$cath_lab->nurse_name2 }}</td>
                        </tr>
                        <tr>
                            <td>Technician (if applicable)</td>
                            <td colspan="2">Name: {{ @$cath_lab->tech_name2 }}</td>
                            <td>Signature: {{ @$cath_lab->tech_name2 }}</td>
                        </tr>
                        <tr>
                            <td colspan="4"><b>PROCEDURE NOTES</b></td>
                        </tr>
                        <tr>
                            <td colspan="4" style="text-align: left">Findings:</td>
                        </tr>
                        <tr>
                            <td colspan="4">{{ @$cath_lab->finding }}</td>
                        </tr>
                        <tr>
                            <td colspan="4" style="text-align: left">Recommendation:</td>
                        </tr>
                        <tr>
                            <td colspan="4">{{ @$cath_lab->recommend }}</td>
                        </tr>
                        <tr>
                            <td>Doctor</td>
                            <td>Name: {{ @$cath_lab->proce_docname }}</td>
                            <td>Emp. ID: {{ @$cath_lab->proce_empid }}</td>
                            <td>Time: {{ $proce_time[1] ?? '' }}</td>
                        </tr>
                        <tr>
                            <td colspan="4" style="text-align: left">CORONARY ANGIOGRAM</td>
                        </tr>
                        <tr>
                            <td colspan="4">{{ @$cath_lab->coronary }}</td>
                        </tr>
                    </table> <br>
                    @php
                        $time_list = !empty($cath_lab->time) ? json_decode($cath_lab->time, true) : [];
                        $temp_list = !empty($cath_lab->temp) ? json_decode($cath_lab->temp, true) : [];
                        $hr_list = !empty($cath_lab->hr) ? json_decode($cath_lab->hr, true) : [];
                        $rr_list = !empty($cath_lab->rr) ? json_decode($cath_lab->rr, true) : [];
                        $bp_list = !empty($cath_lab->bp) ? json_decode($cath_lab->bp, true) : [];
                        $spo2_list = !empty($cath_lab->spo2) ? json_decode($cath_lab->spo2, true) : [];
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
                            @else
                                <tr>
                                    <td colspan="8" style="text-align: center"><b>No Data Available</b></td>

                                </tr>
                            @endif
                        </tbody>
                    </table> <br>
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
                            <td>Emp. ID {{ @$cath_lab->vnurse_empid }} </td>
                            @php
                                $vnurse_time = explode(' ', @$cath_lab->vnurse_time);
                            @endphp
                            <td>Time {{ $vnurse_time[1] ?? '' }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" style="text-align: left"><b>Nursing Notes:</b>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                {{ @$cath_lab->nursing_notes }}
                            </td>
                        </tr>
                        <tr>
                            @php
                                $transfer = json_decode($cath_lab->transfer ?? '[]', true) ?? [];
                            @endphp
                            <td colspan="4" style="text-align: left">
                                <b>Transfer to:</b>
                                <label><input type="checkbox" name="transfer[]" value="post_cath"
                                        {{ in_array('post_cath', $transfer) ? 'checked' : '' }}>
                                    Post cath</label>
                                <label><input type="checkbox" name="transfer[]" value="sicu"
                                        {{ in_array('sicu', $transfer) ? 'checked' : '' }}>
                                    SICU</label>
                                <label><input type="checkbox" name="transfer[]" value="ccu"
                                        {{ in_array('ccu', $transfer) ? 'checked' : '' }}>
                                    CCU</label>
                                <label><input type="checkbox" name="transfer[]" value="others"
                                        {{ in_array('others', $transfer) ? 'checked' : '' }}>
                                    Others</label> <br> <br>
                                <label><b>Others:</b>{{ @$cath_lab->t_others }}</label>

                            </td>
                        </tr>
                    </table> <br>


                    <table class="table table-bordered">
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
                            <td>{{ isset($cath_lab->trans_date) ? date('Y-m-d\TH:i', strtotime($cath_lab->trans_date)) : '' }}
                            </td>
                        </tr>
                        <tr>
                            <td>Receiving Staff</td>
                            <td>{{ @$cath_lab->recv_name }}</td>
                            <td>{{ @$cath_lab->recv_empid }}</td>
                            <td>{{ isset($cath_lab->recv_date) ? date('Y-m-d\TH:i', strtotime($cath_lab->recv_date)) : '' }}
                            </td>
                        </tr>
                    </table> <br>

                    <table class="table table-bordered">
                        <thead class="medicine_thead">
                            <tr>
                                <th colspan="6" style="text-align: center">MEDICATION
                                    RECORD</th>
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
                        <tbody id="medicineTable">
                            @php
                                $medicine_items = !empty($adult_emergency_dept->medicine_item_master)
                                    ? json_decode($adult_emergency_dept->medicine_item_master, true)
                                    : [];
                                $medicine_routes = !empty($adult_emergency_dept->medicine_route_master)
                                    ? json_decode($adult_emergency_dept->medicine_route_master, true)
                                    : [];
                                $medicine_doses = !empty($adult_emergency_dept->medicine_dose_master)
                                    ? json_decode($adult_emergency_dept->medicine_dose_master, true)
                                    : [];
                                $medicine_durations = !empty($adult_emergency_dept->medicine_duration_type_master)
                                    ? json_decode($adult_emergency_dept->medicine_duration_type_master, true)
                                    : [];
                                $medicine_duration_mu = !empty($adult_emergency_dept->medicine_duration_mu_master)
                                    ? json_decode($adult_emergency_dept->medicine_duration_mu_master, true)
                                    : [];
                                $medicine_quantities = !empty($adult_emergency_dept->medicine_quantity_master)
                                    ? json_decode($adult_emergency_dept->medicine_quantity_master, true)
                                    : [];
                                $medicine_instructions = !empty($adult_emergency_dept->instruction_master)
                                    ? json_decode($adult_emergency_dept->instruction_master, true)
                                    : [];
                            @endphp

                            @forelse ($medicine_items as $i => $med)
                                <tr>
                                    <td>{{ $med }}</td>
                                    <td>{{ $medicine_routes[$i] ?? '' }}</td>
                                    <td>{{ $medicine_doses[$i] ?? '' }}</td>
                                    <td>
                                        <div class="input-group">
                                            {{ $medicine_durations[$i] ?? '' }}
                                            {{ $medicine_duration_mu[$i] ?? '' }}
                                        </div>
                                    </td>
                                    <td>{{ $medicine_quantities[$i] ?? '' }}</td>
                                    <td>{{ $medicine_instructions[$i] ?? '' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">No data available</td>
                                </tr>
                            @endforelse

                        </tbody>

                    </table> <br>
                    <table class="table table-bordered">
                        <tr>
                            <td colspan="4"><b>VASCULAR ACCESS MONITORING</b></td>
                            <td>
                                @php
                                    $v_start = explode(' ', @$cath_lab->v_start);
                                @endphp
                                {{ $v_start[1] ?? '' }}
                            </td>
                        </tr>
                        <tr>
                            <td>Vascular Access Site:</td>
                            <td>RADIAL: {{ @$cath_lab->v_radial }}

                            </td>
                            <td>FEMORAL: {{ @$cath_lab->v_femoral }}

                            </td>
                            <td>ULNER : {{ @$cath_lab->v_ulner }}

                            </td>
                            <td>OTHER : {{ @$cath_lab->v_other }}

                            </td>
                        </tr>
                        <tr>
                            <td>Vitals at arrival of Patient:</td>
                            <td>BP: {{ @$cath_lab->pt_bp }}</td>
                            <td>HR: {{ @$cath_lab->pt_hr }}</td>
                            <td>RR: {{ @$cath_lab->pt_rr }}</td>
                            <td>TEMP: {{ @$cath_lab->pt_temp }}</td>
                        </tr>
                    </table> <br>
                    <table class="table table-bordered">
                        <tr>
                            <th rowspan="2"></th>
                            <th rowspan="2">Time</th>
                            <th rowspan="2">Hematoma <br>(Present/Absent)</th>
                            <th colspan="2">Distal Pulses <br>(0=Absent, +1=Feeble, +2=Normal, +3=Strong,
                                +4=Bounding)</th>
                            <th rowspan="2">Initials With ID</th>
                            <th rowspan="2">Remarks</th>
                        </tr>
                        <tr>
                            <th>Posterior Tibial Artery</th>
                            <th>Dorsalis Pedis Artery</th>
                        </tr>

                        <tr>
                            <td>Baseline</td>
                            <td>{{ @$cath_lab->t_baseline }}</td>
                            <td>{{ @$cath_lab->hema_baseline }}</td>
                            <td>{{ @$cath_lab->tibial_baseline }}</td>
                            <td>{{ @$cath_lab->pedis_baseline }}</td>
                            <td>{{ @$cath_lab->initials_baseline }}</td>
                            <td>{{ @$cath_lab->remarks_baseline }}</td>
                        </tr>

                        <tr>
                            <td>30 min</td>
                            <td>{{ @$cath_lab->t_30 }}</td>
                            <td>{{ @$cath_lab->hema_30 }}</td>
                            <td>{{ @$cath_lab->tibial_30 }}</td>
                            <td>{{ @$cath_lab->pedis_30 }}</td>
                            <td>{{ @$cath_lab->initials_30 }}</td>
                            <td>{{ @$cath_lab->remarks_30 }}</td>
                        </tr>

                        <tr>
                            <td>60 min</td>
                            <td>{{ @$cath_lab->t_60 }}</td>
                            <td>{{ @$cath_lab->hema_60 }}</td>
                            <td>{{ @$cath_lab->tibial_60 }}</td>
                            <td>{{ @$cath_lab->pedis_60 }}</td>
                            <td>{{ @$cath_lab->initials_60 }}</td>
                            <td>{{ @$cath_lab->remarks_60 }}</td>
                        </tr>

                        <tr>
                            <td>90 min</td>
                            <td>{{ @$cath_lab->t_90 }}</td>
                            <td>{{ @$cath_lab->hema_90 }}</td>
                            <td>{{ @$cath_lab->tibial_90 }}</td>
                            <td>{{ @$cath_lab->pedis_90 }}</td>
                            <td>{{ @$cath_lab->initials_90 }}</td>
                            <td>{{ @$cath_lab->remarks_90 }}</td>
                        </tr>

                        <tr>
                            <td>2 hr</td>
                            <td>{{ @$cath_lab->t_2 }}</td>
                            <td>{{ @$cath_lab->hema_2 }}</td>
                            <td>{{ @$cath_lab->tibial_2 }}</td>
                            <td>{{ @$cath_lab->pedis_2 }}</td>
                            <td>{{ @$cath_lab->initials_2 }}</td>
                            <td>{{ @$cath_lab->remarks_2 }}</td>
                        </tr>

                        <tr>
                            <td>3 hr</td>
                            <td>{{ @$cath_lab->t_3 }}</td>
                            <td>{{ @$cath_lab->hema_3 }}</td>
                            <td>{{ @$cath_lab->tibial_3 }}</td>
                            <td>{{ @$cath_lab->pedis_3 }}</td>
                            <td>{{ @$cath_lab->initials_3 }}</td>
                            <td>{{ @$cath_lab->remarks_3 }}</td>
                        </tr>

                        <tr>
                            <td>4 hr</td>
                            <td>{{ @$cath_lab->t_4 }}</td>
                            <td>{{ @$cath_lab->hema_4 }}</td>
                            <td>{{ @$cath_lab->tibial_4 }}</td>
                            <td>{{ @$cath_lab->pedis_4 }}</td>
                            <td>{{ @$cath_lab->initials_4 }}</td>
                            <td>{{ @$cath_lab->remarks_4 }}</td>
                        </tr>

                        <tr>
                            <td>5 hr</td>
                            <td>{{ @$cath_lab->t_5 }}</td>
                            <td>{{ @$cath_lab->hema_5 }}</td>
                            <td>{{ @$cath_lab->tibial_5 }}</td>
                            <td>{{ @$cath_lab->pedis_5 }}</td>
                            <td>{{ @$cath_lab->initials_5 }}</td>
                            <td>{{ @$cath_lab->remarks_5 }}</td>
                        </tr>

                        <tr>
                            <td>6 hr</td>
                            <td>{{ @$cath_lab->t_6 }}</td>
                            <td>{{ @$cath_lab->hema_6 }}</td>
                            <td>{{ @$cath_lab->tibial_6 }}</td>
                            <td>{{ @$cath_lab->pedis_6 }}</td>
                            <td>{{ @$cath_lab->initials_6 }}</td>
                            <td>{{ @$cath_lab->remarks_6 }}</td>
                        </tr>

                        <tr>
                            <td>8 hr</td>
                            <td>{{ @$cath_lab->t_8 }}</td>
                            <td>{{ @$cath_lab->hema_8 }}</td>
                            <td>{{ @$cath_lab->tibial_8 }}</td>
                            <td>{{ @$cath_lab->pedis_8 }}</td>
                            <td>{{ @$cath_lab->initials_8 }}</td>
                            <td>{{ @$cath_lab->remarks_8 }}</td>
                        </tr>

                        <tr>
                            <td>12 hr</td>
                            <td>{{ @$cath_lab->t_12 }}</td>
                            <td>{{ @$cath_lab->hema_12 }}</td>
                            <td>{{ @$cath_lab->tibial_12 }}</td>
                            <td>{{ @$cath_lab->pedis_12 }}</td>
                            <td>{{ @$cath_lab->initials_12 }}</td>
                            <td>{{ @$cath_lab->remarks_12 }}</td>
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
