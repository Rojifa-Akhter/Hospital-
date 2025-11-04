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
                        <span style="font-size: 16px;"><b>DOCTORS INHOUSE TRANSFER FORM</b></span>
                    </div>

                    <table class="table table-bordered">
                        <tr>
                            <td><strong>Date & Time</strong><br>
                                {{ isset($doc_inhouse->date_time) ? date('d-m-Y h:i A', strtotime($doc_inhouse->date_time)) : '' }}
                            </td>
                            <td><strong>Shifting From</strong><br>{{ @$doc_inhouse->shifting_from }}</td>
                            <td><strong>Bed</strong><br>{{ @$doc_inhouse->bed_from }}</td>
                            <td><strong>Shifting To</strong><br>{{ @$doc_inhouse->shifting_to }}</td>
                            <td><strong>Bed</strong><br>{{ @$doc_inhouse->bed_to }}</td>
                        </tr>
                        <tr>
                            <td><b>Shifting From Doctor/Dept.</b></td>
                            <td>{{ @$doc_inhouse->sfdd }}</td>
                            <td><b>Shifting To Doctor/Dept.</b></td>
                            <td colspan="2">{{ @$doc_inhouse->stdd }}</td>
                        </tr>

                        <tr>
                            <td><strong>Diagnosis:</strong></td>
                            <td colspan="4">{{ @$doc_inhouse->diagnosis }}</td>
                        </tr>

                        <tr>
                            <td><strong>Reason for Transfer:</strong></td>
                            <td colspan="4">{{ @$doc_inhouse->reason_transfer }}</td>
                        </tr>

                        <tr>
                            <td><strong>Surgery Done:</strong></td>
                            <td>{{ @$doc_inhouse->surgery_done }}</td>
                            <td><strong>Date of Surgery & Time:</strong><br>
                                {{ isset($doc_inhouse->date_surgery) ? date('d-m-Y h:i A', strtotime($doc_inhouse->date_surgery)) : '' }}
                            </td>
                            <td><strong>No. of Post Operative Days:</strong></td>
                            <td>{{ @$doc_inhouse->post_op_days }}</td>
                        </tr>

                        <tr>
                            <td><strong>Name of Surgery:</strong></td>
                            <td colspan="4">{{ @$doc_inhouse->surgery_name }}</td>
                        </tr>

                        <tr>
                            <td><strong>Critical Report (Lab/Radiology):</strong></td>
                            <td colspan="4">{{ @$doc_inhouse->critical_report }}</td>
                        </tr>

                        <tr>
                            <td><strong>Cross Referrals / Follow up:</strong></td>
                            <td colspan="4">{{ @$doc_inhouse->cross_referral }}</td>
                        </tr>

                        <tr>
                            <td><strong>Infection Control Precautions:</strong></td>
                            <td colspan="4">{{ @$doc_inhouse->infection_control }}</td>
                        </tr>

                        <tr>
                            <td><strong>Status at Time of Transfer:</strong></td>
                            <td colspan="4">{{ @$doc_inhouse->status_transfer }}</td>
                        </tr>
                    </table>

                    <table class="table table-bordered">
                        <tr>
                            <td colspan="2"><strong>Pain Rating Score</strong></td>
                            <td>{{ @$doc_inhouse->pain_score }}</td>
                            <td colspan="2"><strong>Location</strong></td>
                            <td colspan="3">{{ @$doc_inhouse->location }}</td>
                        </tr>

                        <tr>
                            <td colspan="2"><strong>Acuity:</strong></td>
                            <td colspan="6">
                                <label><input type="radio" disabled
                                        {{ @$doc_inhouse->acuity == 'Acute' ? 'checked' : '' }}> Acute (&lt;6
                                    weeks)</label>
                                <label><input type="radio" disabled
                                        {{ @$doc_inhouse->acuity == 'Chronic' ? 'checked' : '' }}> Chronic (≥6
                                    weeks)</label>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2"><strong>Modifying Factors:</strong></td>
                            <td>Decreasing</td>
                            <td colspan="2">{{ @$doc_inhouse->decreasing }}</td>
                            <td>Increasing</td>
                            <td colspan="2">{{ @$doc_inhouse->increasing }}</td>
                        </tr>

                        <tr>
                            <td colspan="2"><strong>Character:</strong></td>
                            <td colspan="6">
                                <label><input type="checkbox" disabled
                                        {{ in_array('Sharp', json_decode(@$doc_inhouse->character ?? '[]', true) ?: []) ? 'checked' : '' }}>
                                    Sharp</label>
                                <label><input type="checkbox" disabled
                                        {{ in_array('Dull', json_decode(@$doc_inhouse->character ?? '[]', true) ?: []) ? 'checked' : '' }}>
                                    Dull</label>
                                <label><input type="checkbox" disabled
                                        {{ in_array('Aching', json_decode(@$doc_inhouse->character ?? '[]', true) ?: []) ? 'checked' : '' }}>
                                    Aching</label>
                                <label><input type="checkbox" disabled
                                        {{ in_array('Burning', json_decode(@$doc_inhouse->character ?? '[]', true) ?: []) ? 'checked' : '' }}>
                                    Burning</label>
                                <label><input type="checkbox" disabled
                                        {{ in_array('Spasmodic', json_decode(@$doc_inhouse->character ?? '[]', true) ?: []) ? 'checked' : '' }}>
                                    Spasmodic</label>
                            </td>
                        </tr>

                        <tr>
                            <td><strong>Temperature (°F):</strong></td>
                            <td>{{ @$doc_inhouse->temperature }}</td>
                            <td><strong>Respiratory Rate (Per min):</strong></td>
                            <td>{{ @$doc_inhouse->resp_rate }}</td>
                            <td><strong>Pulse (Per min):</strong></td>
                            <td>{{ @$doc_inhouse->pulse }}</td>
                            <td><strong>Blood Pressure (mmHg):</strong></td>
                            <td>{{ @$doc_inhouse->bp }}</td>
                        </tr>

                        <tr>
                            <td><strong>GCS:</strong></td>
                            <td>{{ @$doc_inhouse->gcs }}</td>
                            <td><strong>SpO₂:</strong></td>
                            <td>{{ @$doc_inhouse->spo2 }}</td>
                            <td><strong>Oxygen:</strong></td>
                            <td>{{ @$doc_inhouse->oxygen }}</td>
                            <td><strong>Others:</strong></td>
                            <td>{{ @$doc_inhouse->others }}</td>
                        </tr>

                        <tr>
                            <td colspan="2"><strong>Medication Reconciliation done?</strong></td>
                            <td colspan="6">{{ @$doc_inhouse->med_recon }}</td>
                        </tr>

                        <tr>
                            <td colspan="8"><strong>Tubing/ Line Reconciliation:</strong></td>
                        </tr>
                        <tr>
                            <td>I/V line</td>
                            <td>{{ @$doc_inhouse->iv_line }}</td>
                            <td>Fluid Rate</td>
                            <td>{{ @$doc_inhouse->fluid_rate }}</td>
                            <td>Medication Running</td>
                            <td colspan="3">{{ @$doc_inhouse->med_running }}</td>
                        </tr>

                        <tr>
                            <td>Foley’s</td>
                            <td>{{ @$doc_inhouse->foley }}</td>
                            <td>NG tube</td>
                            <td>{{ @$doc_inhouse->ng_tube }}</td>
                            <td>Other</td>
                            <td colspan="3">{{ @$doc_inhouse->line_other }}</td>
                        </tr>

                        <tr>
                            <td colspan="8"><strong>Special Concerns:</strong></td>
                        </tr>
                        <tr>
                            <td>None</td>
                            <td colspan="7">{{ @$doc_inhouse->special_none }}</td>
                        </tr>
                        <tr>
                            <td>NPO</td>
                            <td colspan="7">{{ @$doc_inhouse->special_npo }}</td>
                        </tr>
                        <tr>
                            <td>Impairments:</td>
                            <td>Hearing: {{ @$doc_inhouse->imp_hearing }}</td>
                            <td>Visual: {{ @$doc_inhouse->imp_visual }}</td>
                            <td>Cognitive: {{ @$doc_inhouse->imp_cognitive }}</td>
                            <td>Mobility: {{ @$doc_inhouse->imp_mobility }}</td>
                            <td colspan="3">Other: {{ @$doc_inhouse->imp_other }}</td>
                        </tr>

                        <tr>
                            <td colspan="4">Fall Risk (Score): {{ @$doc_inhouse->fall_risk }}</td>
                            <td colspan="2">Skin Condition: {{ @$doc_inhouse->skin_condition }}</td>
                            <td colspan="2">Bed Sore: {{ @$doc_inhouse->bed_sore }}</td>
                        </tr>

                        <tr>
                            <td colspan="8"><strong>Other Advice:</strong><br>{{ @$doc_inhouse->other_advice }}</td>
                        </tr>

                        <tr>
                            <td colspan="8"><strong>Patient & Family
                                    Education:</strong><br>{{ @$doc_inhouse->family_edu }}</td>
                        </tr>

                        <tr>
                            <td colspan="3">Transfer order by:</td>
                            <td>{{ @$doc_inhouse->order_by }}</td>
                            <td colspan="3">Transfer informed to:</td>
                            <td>{{ @$doc_inhouse->info_to }}</td>
                        </tr>

                        <tr>
                            <td colspan="3">Date & Time:</td>
                            <td>{{ isset($doc_inhouse->order_date) ? date('d-m-Y h:i A', strtotime($doc_inhouse->order_date)) : '' }}
                            </td>
                            <td colspan="3">Date & Time:</td>
                            <td>{{ isset($doc_inhouse->info_date) ? date('d-m-Y h:i A', strtotime($doc_inhouse->info_date)) : '' }}
                            </td>
                        </tr>

                        <tr>
                            <td colspan="3">Transferred by:</td>
                            <td>{{ @$doc_inhouse->trans_by }}</td>
                            <td colspan="3">Received by:</td>
                            <td>{{ @$doc_inhouse->receiv_by }}</td>
                        </tr>

                        <tr>
                            <td colspan="3">Signature & Seal:</td>
                            <td>{{ @$doc_inhouse->trans_by }}</td>
                            <td colspan="3">Signature & Seal:</td>
                            <td>{{ @$doc_inhouse->receiv_by }}</td>
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
