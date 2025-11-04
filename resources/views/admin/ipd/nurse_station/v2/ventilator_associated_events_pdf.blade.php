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
            position: absolute;
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
                        <span style="font-size: 16px;"><b>VENTILATOR ASSOCIATED EVENTS INITIATION & MAINTENANCE
                                BUNDLE</b></span>
                    </div>
                    <table class="table table-bordered">
                        <tr>
                            <td><strong>Diagnosis:</strong> {{ $icu_ventilator->diagnosis ?? '' }}</td>
                            <td><strong>Location & Inserted by:</strong> {{ $icu_ventilator->location_by ?? '' }}</td>
                        </tr>
                        <tr>
                            <td><strong>ET/TT Inserted on:</strong>
                                {{ isset($icu_ventilator->inserted_on) ? date('d-m-Y H:i', strtotime($icu_ventilator->inserted_on)) : '' }}
                            </td>
                            <td><strong>Indication:</strong> {{ $icu_ventilator->indication1 ?? '' }}</td>
                        </tr>
                        <tr>
                            <td><strong>ET/TT Removed on:</strong>
                                {{ isset($icu_ventilator->removed_on) ? date('d-m-Y H:i', strtotime($icu_ventilator->removed_on)) : '' }}
                            </td>
                            <td><strong>Indication:</strong> {{ $icu_ventilator->indication2 ?? '' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Patient intubation and ventilation justified by clinical care team:</strong>
                            </td>
                            <td>{{ $icu_ventilator->clinical_care ?? '' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Standard aseptic precautions followed (as per HIC manual):</strong></td>
                            <td>{{ $icu_ventilator->hic ?? '' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Endotracheal tube with subglottic suction used:</strong></td>
                            <td>{{ $icu_ventilator->endotracheal ?? '' }}</td>
                        </tr>
                    </table>

                    @php
                        $fields = [
                            'semi_recumbent' =>
                                'Patient is in semi-recumbent position of 30-45 degrees (unless contraindicated)',
                            'cuff_pressure' => 'Cuff pressure maintained around 20 cms H2O',
                            'sedation_free' =>
                                'Sedation free interval for 2 hours given (to assess readiness to wean or extubate)',
                            'ulcer_prevention' =>
                                'Ulcer prevention measures (Sucralfate, H2 blockers/proton pump inhibitors)',
                            'dvt_prevention' => 'DVT prevention measures (pharma or mechanical)',
                            'oral_hygiene' => 'Oral hygiene with chlorhexidine solution 4th hourly',
                            'sterile_fluid' => 'Sterile fluid used for nebulization',
                            'suction' => 'Orotracheal suction performed',
                            'blood_sugar' => 'Blood sugar maintained <180mg/dl',
                        ];
                    @endphp

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width:40%">VAE – Yes / No / N/A</th>
                                @php
                                    $maxColumns = 0;
                                    foreach ($fields as $key => $label) {
                                        $values = json_decode($icu_ventilator->$key ?? '[]', true) ?? [];
                                        if (count($values) > $maxColumns) {
                                            $maxColumns = count($values);
                                        }
                                    }
                                @endphp
                                @for ($i = 0; $i < $maxColumns; $i++)
                                    <th>{{ $i + 1 }}</th>
                                @endfor
                                <th>Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($fields as $key => $label)
                                <tr>
                                    <td>{{ $label }}</td>
                                    @php
                                        $values = json_decode($icu_ventilator->$key ?? '[]', true) ?? [];
                                    @endphp
                                    @for ($i = 0; $i < $maxColumns; $i++)
                                        <td>{{ $values[$i] ?? '' }}</td>
                                    @endfor
                                    <td>{{ $icu_ventilator->{'remarks_' . $key} ?? '' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <table class="table table-bordered">
                        <tr>
                            <td><strong>Assigned Staff:</strong> {{ $icu_ventilator->staff ?? '' }}</td>
                            <td><strong>Emp ID:</strong> {{ $icu_ventilator->h_staff ?? '' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Verified by:</strong> {{ $icu_ventilator->verified_by ?? '' }}</td>
                            <td><strong>Emp ID:</strong> {{ $icu_ventilator->h_verified_by ?? '' }}</td>
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
                                    <td style="text-align:left;border:none;width:70%">Staff ID:
                                        {{ @$userInfo->user_code }}, Printing Date & Time: {{ date('d/m/Y h:ia') }}
                                    </td>
                                    <td style="text-align:right;border:none;width:30%">Powered By: NEXTGEN IT</td>
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
