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

                    <table class="table table-bordered">
                        <tr>
                            <td colspan="3">
                                <h4>Clinical Summary / Provisional Diagnosis:</h4>
                                {{ @$investigation->clinical_summary ? $investigation->clinical_summary : '' }}

                            </td>
                        </tr>

                        <tr>
                            <td colspan="3">
                                <h4>Requested Investigations</h4>

                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <h4>Laboratory Tests</h4>

                            </td>
                        </tr>

                        <tr>
                            <td>
                                <strong>CBC (Complete Blood Count):</strong>
                                {{ @$investigation->cbc ? $investigation->cbc : '' }}
                            </td>
                            <td>
                                <strong>ESR:</strong>
                                {{ @$investigation->esr ? $investigation->esr : '' }}

                            </td>

                            <td>
                                <strong>Blood Group & Rh:</strong>
                                {{ @$investigation->blood_group ? $investigation->blood_group : '' }}

                            </td>


                        </tr>

                        <tr>

                            <td>
                                <strong>Blood Glucose:</strong>
                                {{ @$investigation->glucose == 'F' ? 'F' : '' }}
                                {{ @$investigation->glucose == 'RR' ? 'RR' : '' }}
                                {{ @$investigation->glucose == 'PP' ? 'PP' : '' }}



                            </td>

                            <td>
                                <strong>Renal Function Test:</strong>
                                {{ @$investigation->renal == 'Urea' ? 'Urea' : '' }}
                                {{ @$investigation->renal == 'Creatinine' ? 'Creatinine' : '' }}


                            </td>
                            <td>
                                <strong>Liver Function Test (LFT):</strong>
                                {{ @$investigation->lft ? $investigation->lft : '' }}
                            </td>


                        </tr>
                        <tr>
                            <td colspan="3">
                                <strong>Other:</strong>
                                {{ @$investigation->lab_other ? $investigation->lab_other : '' }}

                            </td>

                        </tr>
                        <tr>
                            <td colspan="3">
                                <h4>Microbiology / Serology </h4>

                            </td>
                        </tr>

                        <tr>
                            <td>
                                <strong>Widal Test:</strong>
                                {{ @$investigation->widal ? $investigation->widal : '' }}
                            </td>
                            <td>
                                <strong>Dengue:</strong>
                                {{ @$investigation->dengue == 'NS1' ? 'NS1' : '' }}
                                {{ @$investigation->dengue == 'IgG' ? 'IgG' : '' }}
                                {{ @$investigation->dengue == 'IgM' ? 'IgM' : '' }}


                            </td>

                            <td>
                                {{ @$investigation->anti == 'HBsAg' ? 'HBsAg' : '' }}
                                {{ @$investigation->anti == 'Anti-HCV' ? 'Anti-HCV' : '' }}


                            </td>


                        </tr>
                        <tr>
                            <td colspan="3">
                                <strong>Other:</strong>
                                {{ @$investigation->micro_other ? $investigation->micro_other : '' }}

                            </td>

                        </tr>
                        <tr>
                            <td colspan="3">
                                <h4>Radiology / Imaging </h4>

                            </td>
                        </tr>

                        <tr>
                            <td>
                                <strong>Chest X-ray:</strong>
                               {{ @$investigation->chest ? $investigation->chest : '' }}
                            </td>

                            <td>
                                <strong>Abdomen X-ray:</strong>
                               {{ @$investigation->abdomen ? $investigation->abdomen : '' }}
                            </td>


                            <td>
                                <strong>Ultrasound (Specify):</strong>
                                {{ @$investigation->ultrasound ? $investigation->ultrasound : '' }}



                            </td>


                        </tr>
                        <tr>

                            <td>
                                <strong>CT-Scan (Specify):</strong>
                                {{ @$investigation->ct_scan ? $investigation->ct_scan : '' }}
                            </td>

                            <td>
                                <strong>MRI (Specify):</strong>
                                {{ @$investigation->mri ? $investigation->mri : '' }}
                            </td>


                            <td>
                                <strong>ECHO:</strong>
                               {{ @$investigation->echo ? $investigation->echo : '' }}



                            </td>

                        </tr>

                        <tr>
                            <td>
                                <strong>ECG:</strong>
                               {{ @$investigation->ecg ? $investigation->ecg : '' }}
                            </td>
                            <td colspan="2">
                                <strong>Others:</strong>
                                {{ @$investigation->radio_other ? $investigation->radio_other : '' }}

                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <h4>Special Instructions / Notes:</h4>
                                {{ @$investigation->special_instruct ? $investigation->special_instruct : '' }}

                            </td>
                        </tr>


                        <tr>
                            <td colspan="2">
                                <strong>Doctor's Signature:</strong>
                                {{ @$investigation->out_doc ? $investigation->out_doc : '' }}

                            </td>


                            <td>
                                <strong>Date/Time:</strong>
                                {{ isset($investigation->out_doc_date) ? date('Y-m-d\TH:i', strtotime($investigation->out_doc_date)) : '' }}

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
                    <td style="text-align:left;border:none;width:70%">Staff ID:
                        {{ @$userInfo->user_code }}, Printing Date & Time: {{ date('d/m/Y h:ia') }}
                    </td>
                    <td style="text-align:right;border:none;width:30%">Powered By: NEXTGEN IT</td>
                </tr>
            </tbody>
        </table>
    </section>

</body>

</html>
