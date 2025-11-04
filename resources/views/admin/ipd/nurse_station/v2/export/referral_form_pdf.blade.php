<!DOCTYPE html>
<html lang="bn">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Referral Assessment</title>


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
            /* position: absolute;
            bottom: 0px;
            width: 100%; */

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
                        <li><b>Consultant Name:</b>&nbsp;<span>{{ @$admission_info->primary_doctor_name }}</span></li>
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
                        <span style="font-size: 16px;"><b>REFERRAL ASSESSMENT</b></span>
                    </div>

                    <table class="table table-bordered">

                        <tbody>

                           <tr>
                                <td class="text-left"><b>Consultation Referral:</b></td>
                                <td>
                                    {{ @$assessment_info->consultation_referral == 1 ? 'Yes' : 'No' }}
                                </td>
                                <td class="text-left"><b>Consultation Transfer:</b></td>
                                <td>
                                    {{ @$assessment_info->consultation_transfer == 1 ? 'Yes' : 'No' }}
                                </td>
                            </tr>

                            <tr>
                                <td class="text-left" style="20%"><b>Type of:</b></td>
                                <td style="30%">
                                    {{ @$assessment_info->type_referral == 1 ? 'Referral' : '' }}
                                    {{ @$assessment_info->type_transfer == 1 ? ', Transfer' : '' }}
                                    {{ @$assessment_info->type_routine == 1 ? ', Routine' : '' }}
                                    {{ @$assessment_info->type_urgent == 1 ? ', Urgent' : '' }}
                                </td>
                                <td class="text-left" style="20%"><b>Date:</b></td>
                                <td style="30%">{{ date('d/m/Y h:i:s A', strtotime(@$assessment_info->admission_date)) }}</td>
                            </tr>

                            <tr>
                                <td colspan="2" class="text-left"><b>Referred By:</b></td>
                                <td colspan="2" class="text-left"><b>Specialty:</b> {{ @$assessment_info->referred_specialty }}</td>
                            </tr>

                            <tr>
                                <td colspan="2" class="text-left"><b>Referred To:</b></td>
                                <td colspan="2" class="text-left"><b>Specialty:</b> {{ @$assessment_info->referred_to_specialty }}</td>
                            </tr>

                            <tr>
                                <td class="text-left"><b>Conduct Doctor:</b></td>
                                <td>
                                    {{ @$assessment_info->conduct_yes == 1 ? 'Yes' : '' }}
                                    {{ @$assessment_info->conduct_no == 1 ? 'No' : '' }}
                                </td>
                                <td colspan="2" class="text-left"><b>Reason For Reference:</b></td>
                            </tr>

                        </tbody>
                    </table>
                    <br><br>

                    <table class="table table-bordered">
                    <tbody>
                        <!-- Relevant Clinical History / Examination / Investigation -->
                        <tr>
                            <td class="text-left" style="width:25%">
                                <strong>Relevant Clinical History / Examination / Investigation:</strong>
                            </td>
                            <td colspan="6" style="width:75%">
                                {{ @$assessment_info->pressure_injury_dtl ?? '-' }}
                            </td>
                        </tr>

                        <!-- Current Medication Header -->
                        <tr>
                            <td class="text-left" colspan="4"><strong>Current Medication:</strong></td>   
                        </tr>

                        <!-- Name and Employee ID -->
                        <tr>
                            <td class="text-left"><strong>Name:</strong></td>
                            <td>{{ @$assessment_info->emp_name ?? '-' }}</td>

                            <td class="text-left"><strong>Employee ID:</strong></td>
                            <td>{{ @$assessment_info->emp_id ?? '-' }}</td>
                        </tr>

                        <!-- Date and Time -->
                        <tr>
                            <td class="text-left"><strong>Date:</strong></td>
                            <td>{{ isset($assessment_info->emp_date) ? date('d/m/Y', strtotime($assessment_info->emp_date)) : '-' }}</td>

                            <td class="text-left"><strong>Time:</strong></td>
                            <td>{{ @$assessment_info->emp_time ?? '-' }}</td>
                        </tr>
                    </tbody>
                </table>
                <br><br>

                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td class="text-left" style="width:25%">
                                <strong>Notes of Physician:</strong>
                            </td>
                            <td colspan="6" style="width:75%">
                                {{ @$assessment_info->pressure_injury_dtl ?? '-' }}
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left"><strong>Name:</strong></td>
                            <td>{{ @$assessment_info->emp_name ?? '-' }}</td>

                            <td class="text-left"><strong>Employee ID:</strong></td>
                            <td>{{ @$assessment_info->emp_id ?? '-' }}</td>
                        </tr>

                        <tr>
                            <td class="text-left"><strong>Date:</strong></td>
                            <td>{{ isset($assessment_info->emp_date) ? date('d/m/Y', strtotime($assessment_info->emp_date)) : '-' }}</td>

                            <td class="text-left"><strong>Time:</strong></td>
                            <td>{{ @$assessment_info->emp_time ?? '-' }}</td>
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
                    <td style="text-align:left;border:none;width:70%">Staff ID: {{ @$userInfo->user_code }}, Printing
                        Date & Time: {{ date('d/m/Y h:ia') }}</td>
                    <td style="text-align:right;border:none;width:30%">Powered By: NEXTGEN IT</td>
                </tr>
            </tbody>
        </table>
    </section>
</body>

</html>
