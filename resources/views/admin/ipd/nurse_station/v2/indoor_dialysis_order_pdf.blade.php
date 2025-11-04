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
        td { font-size: 15px; border: 1px solid #333; padding-right: 3px; }
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

    {{-- Indoor Dialysis Order Table --}}
    <table class="table table-bordered">
        <tr>
            <th colspan="4" class="text-center">INDOOR DIALYSIS ORDER</th>
        </tr>

        <tr>
            <td colspan="4">
                <label> <b>JVC/FVC Note:</b></label>
                {{ $indoor_dialysis->jvc ?? '' }} <br>

                <label> <b>JCS/FVC:</b></label>
                {{ $indoor_dialysis->jcs ?? '' }} <br>

                <label> <b>H B / Hep C:</b></label>
                {{ $indoor_dialysis->h_b_hep_c ?? '' }} <br>

                <label> <b>Note:</b></label>
                {{ $indoor_dialysis->note ?? '' }}
            </td>
        </tr>

        <tr>
            <td><b>RBS:</b></td>
            <td colspan="3">{{ $indoor_dialysis->rbs ?? '' }}</td>
        </tr>

        <tr>
            <td><b>Blood Flow:</b></td>
            <td colspan="3">{{ $indoor_dialysis->blood_flow ?? '' }}</td>
        </tr>

        <tr>
            <td><b>U/F:</b></td>
            <td colspan="3">{{ $indoor_dialysis->u_f ?? '' }} /L</td>
        </tr>

        <tr>
            <td><b>Heparin:</b></td>
            <td colspan="3">{{ $indoor_dialysis->heparin ?? '' }}</td>
        </tr>

        <tr>
            <td><b>Duration:</b></td>
            <td colspan="3">{{ $indoor_dialysis->duration ?? '' }} Hours</td>
        </tr>

        <tr>
            <td><b>Name of Doctor:</b></td>
            <td colspan="3">{{ $indoor_dialysis->dorcor_name ?? '' }}</td>
        </tr>
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
