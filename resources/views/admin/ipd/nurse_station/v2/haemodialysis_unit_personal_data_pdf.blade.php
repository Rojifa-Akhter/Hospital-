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
                        <span style="font-size: 16px;"><b>HAEMODIALYSIS UNIT PERSONAL DATA</b></span>
                    </div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th colspan="4">Personal Data</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Blood Group</td>
                                <td>
                                    {{ isset($patient_info->blood_group_txt) && !empty($patient_info->blood_group_txt)
                                        ? $patient_info->blood_group_txt
                                        : $haemodialysispd->blood ?? '' }}
                                </td>

                                <td>Mobile</td>
                                <td>{{ $patient_info->mobile1 ?? '' }}</td>
                            </tr>
                            <tr>
                                <td>Medical Condition:</td>
                                <td colspan="3">{{ $haemodialysispd->medical_condition ?? '' }}</td>
                            </tr>
                        </tbody>
                    </table> <br>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th colspan="4">Screening & Vaccination Data</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>HBsAg:</td>
                                <td>{{ $haemodialysispd->hbsag ?? '' }}</td>
                                <td>Last Screened:</td>
                                <td>{{ $haemodialysispd->hbsag_last ?? '' }}</td>
                            </tr>
                            <tr>
                                <td>Others:</td>
                                <td colspan="3">{{ $haemodialysispd->hbsag_others ?? '' }}</td>
                            </tr>
                            <tr>
                                <td>HBsAb:</td>
                                <td>{{ $haemodialysispd->hbsab ?? '' }}</td>
                                <td>Last Screened:</td>
                                <td>{{ $haemodialysispd->hbsab_last ?? '' }}</td>
                            </tr>
                            <tr>
                                <td>Hepatitis C Antibody:</td>
                                <td>{{ $haemodialysispd->hcv_antibody ?? '' }}</td>
                                <td>Last Screened:</td>
                                <td>{{ $haemodialysispd->hcv_last ?? '' }}</td>
                            </tr>
                            <tr>
                                <td>HIV Antibody:</td>
                                <td>{{ $haemodialysispd->hiv_antibody ?? '' }}</td>
                                <td>Last Screened:</td>
                                <td>{{ $haemodialysispd->hiv_last ?? '' }}</td>
                            </tr>
                            <tr>
                                <td>Hep B Vaccine Dose 1st:</td>
                                <td>{{ $haemodialysispd->hepb_dose1 ?? '' }}</td>
                                <td>2nd:</td>
                                <td>{{ $haemodialysispd->hepb_dose2 ?? '' }}</td>
                            </tr>
                            <tr>
                                <td>3rd:</td>
                                <td>{{ $haemodialysispd->hepb_dose3 ?? '' }}</td>
                                <td>4th:</td>
                                <td>{{ $haemodialysispd->hepb_dose4 ?? '' }}</td>
                            </tr>
                        </tbody>
                    </table> <br>

                    <table class="table table-bordered mt-2">
                        <thead>
                            <tr>
                                <th colspan="6">Haemodialysis Data</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Date of First Dialysis:</td>
                                <td>{{ isset($haemodialysispd->first_dialysis) ? date('Y-m-d', strtotime($haemodialysispd->first_dialysis)) : '' }}
                                </td>
                                <td>Initial Heparin:</td>
                                <td>{{ $haemodialysispd->initial_heparin ?? '' }}</td>
                                <td>Hourly Heparin:</td>
                                <td>{{ $haemodialysispd->hourly_heparin ?? '' }}</td>
                            </tr>
                            <tr>
                                <td>Date of Last Dialysis Supine:</td>
                                <td>{{ isset($haemodialysispd->last_dialysis_supine) ? date('Y-m-d', strtotime($haemodialysispd->last_dialysis_supine)) : '' }}
                                </td>
                                <td>Blood Pressure Pre:</td>
                                <td>{{ $haemodialysispd->bp_pre ?? '' }}</td>
                                <td>Post:</td>
                                <td>{{ $haemodialysispd->bp_post ?? '' }}</td>
                            </tr>
                            <tr>
                                <td>Length of Dialysis:</td>
                                <td>{{ $haemodialysispd->length_dialysis ?? '' }}</td>
                                <td>Dry Weight:</td>
                                <td>{{ $haemodialysispd->dry_weight ?? '' }}</td>
                                <td>Bath:</td>
                                <td>{{ $haemodialysispd->bath ?? '' }}</td>
                            </tr>
                            <tr>
                                <td>Frequency of Dialysis:</td>
                                <td>{{ $haemodialysispd->frequency_dialysis ?? '' }}</td>
                                <td>Dialyzer:</td>
                                <td>{{ $haemodialysispd->dialyzer ?? '' }}</td>
                                <td colspan="2"></td>
                            </tr>
                            <tr>
                                <td>Vascular Access:</td>
                                <td>{{ $haemodialysispd->vascular_access ?? '' }}</td>
                                <td>Dialyzer Material:</td>
                                <td>{{ $haemodialysispd->dialyzer_material ?? '' }}</td>
                                <td colspan="2"></td>
                            </tr>
                        </tbody>
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
