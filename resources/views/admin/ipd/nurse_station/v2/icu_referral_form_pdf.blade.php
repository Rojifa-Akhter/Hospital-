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
                        <span style="font-size: 16px;"><b>REFERRAL FORM</b></span>
                    </div>

                    <table class="table table-bordered">
                        <tr>
                            <td colspan="2" style="text-align:center; font-weight:bold;">
                                <label>
                                    <input type="radio" name="consultation_type" value="referral"
                                        {{ @$referral_form->consultation_type == 'referral' ? 'checked' : '' }}>
                                    CONSULTATION REFERRAL
                                </label>
                                <label>
                                    <input type="radio" name="consultation_type" value="transfer"
                                        {{ @$referral_form->consultation_type == 'transfer' ? 'checked' : '' }}>
                                    CONSULTATION TRANSFER
                                </label>
                            </td>
                        </tr>

                        <tr>
                            @php
                                $type_referral = json_decode($referral_form->type_referral ?? '[]', true) ?? [];
                            @endphp
                            <td>
                                Type of:
                                <label><input type="checkbox" name="type_referral[]" value="Referral"
                                        {{ in_array('Referral', $type_referral) ? 'checked' : '' }}>
                                    Referral</label>

                                <label><input type="checkbox" name="type_referral[]" value="Transfer"
                                        {{ in_array('Transfer', $type_referral) ? 'checked' : '' }}>
                                    Transfer</label>

                                <label><input type="checkbox" name="type_referral[]" value="Routine"
                                        {{ in_array('Routine', $type_referral) ? 'checked' : '' }}>
                                    Routine</label>

                                <label><input type="checkbox" name="type_referral[]" value="Urgent"
                                        {{ in_array('Urgent', $type_referral) ? 'checked' : '' }}>
                                    Urgent</label>
                            </td>

                            <td>
                                Date & Time:
                                {{ isset($referral_form->date_time) ? date('d-m-Y h:i A', strtotime($referral_form->date_time)) : '' }}
                            </td>
                        </tr>

                        <tr>
                            <td>
                                Referred By: {{ @$referral_form->referred_by }}
                            </td>
                            <td>
                                Specialty: {{ @$referral_form->specialty_by }}
                            </td>
                        </tr>

                        <tr>
                            <td>
                                Referred To: {{ @$referral_form->referred_to }}
                            </td>
                            <td>
                                Specialty: {{ @$referral_form->specialty_to }}
                            </td>
                        </tr>

                        <tr>
                            <td>
                                Conduct Doctor: {{ @$referral_form->conduct_doctor }}
                            </td>
                            <td>
                                Reason for Reference: {{ @$referral_form->reason_ref }}
                            </td>
                        </tr>
                    </table>

                    <br>

                    <table class="table table-bordered">
                        <tr>
                            <td colspan="3">
                                <strong>Relevant Clinical History / Examination / Investigation:</strong><br>
                                {!! nl2br(e(@$referral_form->clinical_history)) !!}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <strong>Current Medication:</strong><br>
                                {!! nl2br(e(@$referral_form->current_med)) !!}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Name: {{ @$referral_form->name_history }}
                            </td>
                            <td>
                                Emp ID: {{ @$referral_form->h_name_history }}
                            </td>
                            <td>
                                Date & Time:
                                {{ isset($referral_form->date_history) ? date('d-m-Y h:i A', strtotime($referral_form->date_history)) : '' }}
                            </td>
                        </tr>
                    </table>

                    <br>

                    <table class="table table-bordered">
                        <tr>
                            <td colspan="3">
                                <strong>Notes of Physician:</strong><br>
                                {!! nl2br(e(@$referral_form->phy_notes)) !!}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Name: {{ @$referral_form->name_physician }}
                            </td>
                            <td>
                                Emp ID: {{ @$referral_form->h_name_physician }}
                            </td>
                            <td>
                                Date & Time:
                                {{ isset($referral_form->date_physician) ? date('d-m-Y h:i A', strtotime($referral_form->date_physician)) : '' }}
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
