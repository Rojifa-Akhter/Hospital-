<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Transfusion Order</title>
    <style>
        .border-left-0 { border-left: none !important; }
        .border-right-0 { border-right: none !important; }
        thead { background-color: white; }
        .fs-12 { font-size: 16px; }
        .table { border-collapse: collapse; width: 100%; }
        .table-bordered { border: 1px solid #333; }
        td, th { font-size: 13px; border: 1px solid #333; padding: 6px; }
        .text-left { text-align: left; }
        .text-center { text-align: center; }
        .header>tbody>tr>td, .header>thead>tr>td { border: none; }
        body { margin-bottom: 0.6cm; }
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
        <tr>
            <th colspan="9" class="text-center">BLOOD PRODUCTS TRANSFUSION & MONITORING RECORD</th>
        </tr>

        <!-- Basic Info -->
        <tr>
            <td><b>Blood Group & Rh Type</b></td>
            <td colspan="2">{{ $order_form->blood_group ?? '' }}</td>
            <td><b>No. of Bags</b></td>
            <td colspan="2">{{ $order_form->bags ?? '' }}</td>
            <td><b>Time of Issue</b></td>
            <td colspan="2">{{ $order_form->issue_time ? date('d/m/Y H:i', strtotime($order_form->issue_time)) : '' }}</td>
        </tr>
        <tr>
            <td><b>Blood Product received by</b></td>
            <td colspan="3">{{ $order_form->received_by ?? '' }}</td>
            <td><b>Time of receiving</b></td>
            <td colspan="4">{{ $order_form->received_time ? date('d/m/Y H:i', strtotime($order_form->received_time)) : '' }}</td>
        </tr>

        <tr>
            <td><b>Blood components transfused</b></td>
            <td colspan="8">{{ implode(', ', $components) }}</td>
        </tr>

        <tr>
            <td><b>Bag No</b></td>
            <td>{{ $order_form->bag_no ?? '' }}</td>
            <td><b>Amount (ml)</b></td>
            <td>{{ $order_form->amount ?? '' }}</td>
            <td><b>DOC</b></td>
            <td>{{ $order_form->doc ?? '' }}</td>
            <td><b>DOE</b></td>
            <td colspan="2">{{ $order_form->doe ?? '' }}</td>   
        </tr>

        <tr>
            <td><b>Consent Obtained</b></td>
            <td colspan="2">{{ $order_form->consent ?? '' }}</td>
            <td><b>Pre-medication</b></td>
            <td colspan="2">{{ $order_form->premedication ?? '' }}</td>
            <td><b>IV Patient</b></td>
            <td colspan="2">{{ $order_form->iv_patient ?? '' }}</td>
        </tr>

        <tr>
            <td colspan="2"><b>Transfusion Starting Time</b></td>
            <td colspan="7">{{ $order_form->transfusion_start ? date('d/m/Y H:i', strtotime($order_form->transfusion_start)) : '' }}</td>
        </tr>

        <!-- Vitals -->
        <tr>
            <th colspan="9" class="text-center">VITAL SIGNS DURING TRANSFUSION</th>
        </tr>
        <tr>
            <th>Frequency</th>
            <th>Time</th>
            <th>Temp (°F)</th>
            <th>Pulse</th>
            <th>Resp</th>
            <th>BP</th>
            <th>Drops/min</th>
            <th>Sign</th>
            <th>Remarks</th>
        </tr>
        @php
            $intervals = ['Starting Time','15 Min','30 Min','45 Min','60 Min','Followed by every 30 mins','Followed by every 30 mins','Followed by every 30 mins','Followed by every 30 mins','Followed by every 30 mins','Followed by every 30 mins','Followed by every 30 mins'];
        @endphp
        @foreach($intervals as $i => $int)
        <tr>
            <td>{{ $int }}</td>
            <td>{{ !empty($vitals[$i]['time']) ? date('d/m/Y H:i', strtotime($vitals[$i]['time'])) : '' }}</td>
            <td>{{ $vitals[$i]['temp'] ?? '' }}</td>
            <td>{{ $vitals[$i]['pulse'] ?? '' }}</td>
            <td>{{ $vitals[$i]['resp'] ?? '' }}</td>
            <td>{{ $vitals[$i]['bp'] ?? '' }}</td>
            <td>{{ $vitals[$i]['drops'] ?? '' }}</td>
            <td>{{ $vitals[$i]['sign'] ?? '' }}</td>
            <td>{{ $vitals[$i]['remarks'] ?? '' }}</td>
        </tr>
        @endforeach

        <tr>
            <td><b>End Time of Transfusion</b></td>
            <td colspan="8">{{ $order_form->transfusion_end ? date('d/m/Y H:i', strtotime($order_form->transfusion_end)) : '' }}</td>
        </tr>

        <tr>
            <td><b>Transfusion Reaction</b></td>
            <td colspan="8">{{ $order_form->reaction ?? '' }} @if($order_form->reaction == 'Yes') ({{ $order_form->reaction_symptoms ?? '' }}) @endif</td>
        </tr>

        <tr>
            <td><b>Transfusion Reaction form completed and sent to Blood Bank?</b></td>
            <td colspan="8">{{ $order_form->reaction_form ?? '' }} @if($order_form->reaction_form == 'Yes') ({{ $order_form->reaction_form_text ?? '' }}) @endif</td>
        </tr>

        <!-- Blood & Blood Products Summary -->
        <tr>
            <th colspan="3">Blood & Blood Products</th>
            <th colspan="3">Time to Start Transfusion</th>
            <th colspan="3">Time to End Transfusion</th>
        </tr>
        <tr>
            <td colspan="3">Whole Blood</td>
            <td colspan="3">Within 30 mins of issue from Blood Bank</td>
            <td colspan="3">Within 4 hrs of starting transfusion</td>
        </tr>
        <tr>
            <td colspan="3">PRBC/RBC</td>
            <td colspan="3">Within 30 mins of issue from Blood Bank</td>
            <td colspan="3">Within 4 hrs of starting transfusion</td>
        </tr>
        <tr>
            <td colspan="3">Platelet Concentrate</td>
            <td colspan="3">Time to Start Infusion</td>
            <td colspan="3">Within 20–30 mins of starting transfusion</td>
        </tr>
        <tr>
            <td colspan="3">FFP & Cryo</td>
            <td colspan="3">Time to Start Infusion</td>
            <td colspan="3">Within 20–30 mins of starting transfusion</td>
        </tr>
        <tr>
            <td colspan="3">Platelet Apheresis</td>
            <td colspan="3">Time to Start Infusion</td>
            <td colspan="3">Within 20–30 mins of starting transfusion</td>
        </tr>

        <tr>
            <td colspan="3"><b>Assigned Nurse</b></td>
            <td>{{ $order_form->nurse_signature ?? '' }}</td>
            <td>{{ $order_form->nurse_name ?? '' }}</td>
            <td>{{ $order_form->nurse_emp_id ?? '' }}</td>
            <td>{{ $order_form->nurse_date ?? '' }}</td>
            <td colspan="2">{{ $order_form->nurse_time ?? '' }}</td>
        </tr>

        <tr>
            <td colspan="3"><b>Unit Supervisor</b></td>
            <td>{{ $order_form->supervisor_signature ?? '' }}</td>
            <td>{{ $order_form->supervisor_name ?? '' }}</td>
            <td>{{ $order_form->supervisor_emp_id ?? '' }}</td>
            <td>{{ $order_form->supervisor_date ?? '' }}</td>
            <td colspan="2">{{ $order_form->supervisor_time ?? '' }}</td>
        </tr>

        <tr>
            <td colspan="9">
                <p><b>Note:</b> If any delay in transfusion or unused blood, products should be returned to the blood bank within 30 min. For every blood product transfusion, this form must be filled separately.</p>
            </td>
        </tr>
    </table>

    {{-- Footer --}}
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
