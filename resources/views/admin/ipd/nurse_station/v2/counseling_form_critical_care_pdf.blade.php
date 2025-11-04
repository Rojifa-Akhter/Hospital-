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
                        <span style="font-size: 16px;"><b>COUNSELING FORM CRITICAL CARE</b></span>
                    </div>
                    <table class="table table-bordered">
                        <tr>
                            <th colspan="4" style="text-align:center;">COUNSELING DETAILS</th>
                        </tr>
                        <tr>
                            <td colspan="4">
                                @php
                                    $counseling = json_decode($counseling_form->counseling ?? '[]', true) ?: [];
                                @endphp

                                <label>
                                    <input type="checkbox" {{ in_array('clinical', $counseling) ? 'checked' : '' }}>
                                    <b>Patient Clinical Condition :</b>
                                </label>
                                {{ $counseling_form->clinical ?? '' }} <br>

                                <label>
                                    <input type="checkbox" {{ in_array('care', $counseling) ? 'checked' : '' }}>
                                    <b>Plan of Care :</b>
                                </label>
                                {{ $counseling_form->care ?? '' }} <br>

                                <label>
                                    <input type="checkbox" {{ in_array('management', $counseling) ? 'checked' : '' }}>
                                    <b>Pain Management :</b>
                                </label>
                                {{ $counseling_form->management ?? '' }} <br>

                                <label>
                                    <input type="checkbox" {{ in_array('medication', $counseling) ? 'checked' : '' }}>
                                    <b>Medication Management :</b>
                                </label>
                                {{ $counseling_form->medication ?? '' }} <br>

                                <label>
                                    <input type="checkbox"
                                        {{ in_array('investigation', $counseling) ? 'checked' : '' }}>
                                    <b>Investigation :</b>
                                </label>
                                {{ $counseling_form->investigation ?? '' }} <br>

                                <label>
                                    <input type="checkbox" {{ in_array('others', $counseling) ? 'checked' : '' }}>
                                    <b>Any others :</b>
                                </label>
                                {{ $counseling_form->others ?? '' }}
                            </td>
                        </tr>

                        <tr>
                            <td style="width:20%;"><b>Counselled to</b></td>
                            <td>
                                <b>Name:</b> {{ @$patient_info->patient_name }} <br>
                                <b>Signature:</b> {{ @$patient_info->patient_name }}
                            </td>
                            <td colspan="2">
                                <b>Relationship:</b> {{ $counseling_form->relationship ?? '' }}
                            </td>
                        </tr>

                        <tr>
                            <td style="width:20%;"><b>Counselling done by</b></td>
                            <td>
                                <b>Doctor:</b> {{ $counseling_form->doc_name ?? '' }} <br>
                                <b>Signature:</b> {{ $counseling_form->doc_name ?? '' }}
                            </td>
                            <td colspan="2">
                                <b>Emp. ID:</b> {{ $counseling_form->h_doc_name ?? '' }} <br>
                                <b>Date & Time:</b>
                                {{ isset($counseling_form->date_time) ? date('d-m-Y h:i A', strtotime($counseling_form->date_time)) : '' }}
                            </td>
                        </tr>
                    </table>

                </td>
            </tr>
        </tbody>
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
