<!DOCTYPE html>
<html lang="bn">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Emergency Discharge Summary</title>


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

    .header>tbody>tr>td {
        border: none;
    }

    body {
        margin-bottom: 0.6cm;
        margin-left: 1cm;
    }

    .footer-table {
        margin-top: 10px;
    }

    td {
        page-break-inside: avoid
    }
    </style>
</head>

<body onload="window.print()">

    <table class="table header">
        <tbody>
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
        </tbody>
    </table>

    <div
        style="padding: 7px; border-top:1px dotted black; border-bottom:1px dotted black;text-align:center;margin-top:10px; margin-bottom:20px">
        <span style="font-size: 16px;text-transform:uppercase"><b>Emergency Discharge Summary</b></span>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered">
            <tbody>

                <tr>
                    <td colspan="3" class="text-left"><strong>Return to ED within 72 hours: </strong>
                        {{ $data->return_ed_72hrs ?? 'N/A' }}</td>
                    <td colspan="3" class="text-left"><strong>Triage Category: </strong>
                        {{ $data->triage_category ?? 'N/A' }}</td>

                </tr>
                <tr>
                    <td colspan="3" class="text-left"><strong>Allergies:</strong> {{ $data->allergies ?? 'N/A' }}</td>

                    <td colspan="3" class="text-left"><strong>Allergies Type: </strong> @if($data->allergies == 'Yes')
                        {{ $data->allergy_blood == 'Yes' ? 'Blood Transfusion, ' : '' }}
                        {{ $data->allergy_drug == 'Yes' ? 'Drug, ' : '' }}
                        {{ $data->allergy_food == 'Yes' ? 'Food, ' : '' }}
                        {{ $data->allergy_others == 'Yes' ? 'Others:' : '' }}
                        @else
                        N/A
                        @endif

                        @if($data->allergy_others == 'Yes')
                        {{ $data->allergy_others_specify ?? '' }}
                        @else
                        N/A
                        @endif</td>
                </tr>
                <tr>
                    <td colspan="2" class="text-left"><strong>MLC:</strong> {{ $data->mlc ?? 'N/A' }}</td>
                    <td colspan="2" class="text-left"><strong>If yes, MLC No:</strong> @if($data->mlc == 'Yes')
                        {{ $data->mlc_no ?? 'N/A' }}
                        @else
                        N/A
                        @endif</td>
                    <td colspan="2" class="text-left"><strong>Blood Group:</strong> {{ $data->blood_group ?? 'N/A' }}
                    </td>
                </tr>

                <tr>
                    <td colspan="6" class="text-left"><strong> Provisional Diagnosis:</strong>
                        <div style="white-space: pre-wrap;">{{ $data->provisional_diagnosis ?? 'N/A' }}</div>
                    </td>
                </tr>
                <tr>
                    <td colspan="6" class="text-left"><strong>Chief Complaints:</strong>
                        <div style="white-space: pre-wrap;">{{ $data->chief_complaints ?? 'N/A' }}</div>
                    </td>

                </tr>

                <tr>
                    <td colspan="6" class="text-left"><strong>Past Clinical History:
                        </strong>
                        <div style="white-space: pre-wrap;">{{ $data->past_clinical_history ?? 'N/A' }}</div>
                    </td>

                </tr>

                <tr>
                    <td rowspan="1" class="text-left align-top" colspan="3" style="vertical-align: top;">
                        <strong>Significant Physical &amp; Other findings:</strong><br>
                        <div style="white-space: pre-wrap;">{{ $data->significant_findings ?? 'N/A' }}</div>
                        <br>

                        <strong>Investigations Advised:</strong><br>
                        <div style="white-space: pre-wrap;">{{ $data->investigations_advised ?? 'N/A' }}</div>
                    </td>

                    <td class="text-left align-top" colspan="4" style="vertical-align: top;">
                        <strong>Treatment Given:</strong><br>
                        <div style="white-space: pre-wrap;">{{ $data->treatment_given ?? 'N/A' }}</div>
                    </td>
                </tr>


                <tr>
                    <td colspan="6" class="text-left"><strong>Discharge Medication &amp; Advice:</strong>
                        <div style="white-space: pre-wrap;">{{ $data->discharge_medication_advice ?? 'N/A' }}</div>
                    </td>

                </tr>
                <tr>
                    <td colspan="6" class="text-left"><strong>Followup Advice:</strong>
                        <div style="white-space: pre-wrap;">{{ $data->followup_advice ?? 'N/A' }}</div>
                    </td>

                </tr>


                <tr>
                    <td colspan="6" class="text-left"><strong>Condition at time of Discharge:</strong> @php
                        $condition = $data->condition_discharge ?? null;
                        $labels = [
                        'stable' => 'Stable',
                        'critical' => 'Critical',
                        'comatose_death_on_arrival' => 'Death on arrival',
                        ];
                        @endphp

                        {{ $labels[$condition] ?? 'N/A' }}</td>

                </tr>


                <tr>
                    <td colspan="6" class="text-left"><strong>Type of Discharge:</strong>
                        {{ @$data->type_of_discharge == 'normal' ? 'Normal' : '' }}
                        {{ @$data->type_of_discharge == 'referred_outside' ? 'Referred (Outside)' : '' }}
                        {{ @$data->type_of_discharge == 'referred_inside' ? 'Referred (Inside)' : '' }}
                        {{ @$data->type_of_discharge == 'LAMA' ? 'LAMA' : '' }}</td>

                </tr>

                <tr>
                    <td colspan="6">
                        <table class="table table-bordered mb-0">
                            <tbody>
                                <tr>
                                    <td class="text-center align-middle"><strong> Vitals</strong></td>
                                    <td class="text-center align-middle"><strong> BP (mm of Hg)</strong></td>
                                    <td class="text-center align-middle"><strong> HR/min RR/min</strong></td>
                                    <td class="text-center align-middle"><strong> Temp</strong></td>
                                    <td class="text-center align-middle"><strong> SpO<sub>2</sub> %</strong></td>
                                    <td class="text-center align-middle"><strong> Pain Score</strong></td>
                                    <td class="text-center align-middle"><strong> GCS</strong></td>
                                </tr>
                                <tr>
                                    <td class="text-center align-middle"><strong>At Admission</strong></td>
                                    <td class="text-center">{{ @$data->vitals_adm_bp ?? '' }}</td>
                                    <td class="text-center">{{ @$data->vitals_adm_hr_rr ?? '' }}</td>
                                    <td class="text-center">{{ @$data->vitals_adm_temp ?? '' }}</td>
                                    <td class="text-center">{{ @$data->vitals_adm_spo2 ?? '' }}</td>
                                    <td class="text-center">{{ @$data->vitals_adm_pain ?? '' }}</td>
                                    <td class="text-center">{{ @$data->vitals_adm_gcs ?? '' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-center align-middle"><strong>At Discharge</strong></td>
                                    <td class="text-center">{{ @$data->vitals_dis_bp ?? '' }}</td>
                                    <td class="text-center">{{ @$data->vitals_dis_hr_rr ?? '' }}</td>
                                    <td class="text-center">{{ @$data->vitals_dis_temp ?? '' }}</td>
                                    <td class="text-center">{{ @$data->vitals_dis_spo2 ?? '' }}</td>
                                    <td class="text-center">{{ @$data->vitals_dis_pain ?? '' }}</td>
                                    <td class="text-center">{{ @$data->vitals_dis_gcs ?? '' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>



                <tr>
                    <td colspan="6">
                        <table class="table table-bordered mb-0">

                            <tbody>
                                <tr>
                                    <td class="text-center align-middle"></td>
                                    <td class="text-center align-middle"><strong> Name </strong></td>
                                    <td class="text-center align-middle"><strong> Signature </strong></td>
                                    <td class="text-center align-middle"><strong> Emp ID </strong></td>
                                    <td class="text-center align-middle"><strong> Date </strong></td>
                                    <td class="text-center align-middle"><strong> Time </strong></td>
                                </tr>
                                <tr>
                                    <td class="text-center align-middle"><strong>Doctor</strong></td>
                                    <td class="text-center align-middle">
                                        <p class="text-center">{{ $data->doc_name ?? '' }}</p>
                                    </td>
                                    <td class="text-center align-middle">
                                        @if($doc_info && !empty($doc_info->doctor_signature_image))
                                        <img src="{{ asset('images/uploads/doctor_images/thumb/' . $doc_info->doctor_signature_image) }}"
                                            alt="signature" style="width: 90px; height:30px">
                                        @else
                                        <p>-</p>
                                        @endif
                                    </td>


                                    <td class="text-center align-middle">
                                        <p class="text-center">{{ $doc_info->person_code ?? '' }}</p>
                                    </td>
                                    <td class="text-center align-middle">
                                        <p class="text-center">
                                            {{ $data->au_update_at  ? date('Y-m-d', strtotime($data->au_update_at))     : ($data->au_entry_at ? date('Y-m-d', strtotime($data->au_entry_at)) : '') }}
                                        </p>
                                    </td>
                                    <td class="text-center align-middle">
                                        <p class="text-center">
                                            {{ $data->au_update_at    ? date('h:i A', strtotime($data->au_update_at))  : ($data->au_entry_at ? date('h:i A', strtotime($data->au_entry_at)) : '') }}
                                        </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>



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