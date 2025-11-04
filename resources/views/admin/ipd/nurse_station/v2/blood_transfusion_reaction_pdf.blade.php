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
        td, th { font-size: 15px; border: 1px solid #333; padding: 6px; }
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
        <tr>
            <th colspan="5" class="text-center">BLOOD TRANSFUSION REACTION FORM</th>
        </tr>

        <tr>
            <td colspan="2">
                <b>Blood Grouping & Rh type:</b> {{ $reaction_form->blood_group ?? '' }} <br>
                <b>Primary Diagnosis:</b> {{ $reaction_form->primary_diagnosis ?? '' }} <br>
                <b>Indication for Transfusion:</b> {{ $reaction_form->indication ?? '' }} <br>
                <b>Relevant co-morbidities:</b> {{ $reaction_form->comorbidities ?? '' }} <br>
                <b>Relevant Medications:</b> {{ $reaction_form->medications ?? '' }}
            </td>
            <td colspan="3">
                <b>Previous H/O Transfusion:</b> {{ $reaction_form->prev_transfusion ?? '' }} <br>
                @if(optional($reaction_form)->prev_transfusion == 'Yes')
                    Number: {{ $reaction_form->prev_transfusion_detail ?? '' }} <br>
                    Date: {{ $reaction_form->prev_transfusion_datetime ?? '' }} <br>
                @endif

                <b>Previous Reaction:</b> {{ $reaction_form->prev_reaction ?? '' }} <br>
                @if(optional($reaction_form)->prev_reaction == 'Yes')
                    Date & Type: {{ $reaction_form->prev_reaction_datetime ?? '' }} <br>
                @endif

                <b>Pre-medication:</b> {{ $reaction_form->pre_medication ?? '' }} <br>
                @if(optional($reaction_form)->pre_medication == 'Yes')
                    Drug: {{ $reaction_form->pre_medication_drug ?? '' }},
                    Dose: {{ $reaction_form->pre_medication_dose ?? '' }},
                    Route: {{ $reaction_form->pre_medication_route ?? '' }}
                @endif
            </td>
            {{-- <td colspan="1">
            </td> --}}
        </tr>

        <tr>
            <th colspan="5">Transfused Component Details</th>
        </tr>
        <tr>
            <td>Unit ID: {{ $reaction_form->unit_id ?? '' }}</td>
            <td>Component Type: {{ $reaction_form->component_type ?? '' }}</td>
            <td>ABO & Rh: {{ $reaction_form->abo_rh ?? '' }}</td>
            <td>Volume: {{ $reaction_form->volume ?? '' }}</td>
            <td></td>
        </tr>
        <tr>
            <td>Date of Collection: {{ $reaction_form->collection_date ?? '' }}</td>
            <td>Date of Expiry: {{ $reaction_form->expiry_date ?? '' }}</td>
            <td>Issue Date & Time: {{ $reaction_form->issue_datetime ?? '' }}</td>
            <td></td>
        </tr>

        <tr>
            <th colspan="5">Transfusion Reaction Details</th>
        </tr>
        <tr>
            <td>Start: {{ $reaction_form->transfusion_start ?? '' }}</td>
            <td>Rate: {{ $reaction_form->transfusion_rate ?? '' }}</td>
            <td>Reaction Start: {{ $reaction_form->reaction_start ?? '' }}</td>
            <td>Stop: {{ $reaction_form->transfusion_stop ?? '' }}</td>
        </tr>

        <tr>
            <th colspan="5">Vital signs at the time of Reaction</th>
        </tr>
        <tr>
            <th></th>
            <th>Pre</th>
            <th>During</th>
            <th>After</th>
            <th>Remarks</th>
        </tr>
        @php
            $vitals = [
                'datetime' => 'Date/Time',
                'temp' => 'Temperature',
                'bp' => 'Blood Pressure',
                'pulse' => 'Pulse',
                'rr' => 'Respiratory Rate',
                'o2' => 'O2 Saturation',
            ];
        @endphp
        @foreach($vitals as $key => $label)
        <tr>
            <td>{{ $label }}</td>
            <td>{{ $reaction_form->{'vital_pre_'.$key} ?? '' }}</td>
            <td>{{ $reaction_form->{'vital_during_'.$key} ?? '' }}</td>
            <td>{{ $reaction_form->{'vital_after_'.$key} ?? '' }}</td>
            <td>{{ $reaction_form->{'vital_remarks_'.$key} ?? '' }}</td>
        </tr>
        @endforeach
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
