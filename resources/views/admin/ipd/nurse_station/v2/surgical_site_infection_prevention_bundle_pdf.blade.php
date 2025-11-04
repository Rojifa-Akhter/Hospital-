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
                        <span style="font-size: 16px;"><b>SURGICAL SITE INFECTION PREVENTION BUNDLE </b></span>
                    </div>
                    <table class="table table-bordered">
                        <tr>
                            <td><strong>Diagnosis:</strong>
                                {{ isset($surgical_infection->diagnosis) ? $surgical_infection->diagnosis : '' }}

                            </td>

                            <td><strong>Name of the Surgeon</strong>
                                {{ isset($surgical_infection->doc_name) ? $surgical_infection->doc_name : '' }}
                            </td>
                        </tr>

                        <tr>
                            <td><strong>Scrub Nurse:</strong>
                                {{ isset($surgical_infection->scrub_nurse) ? $surgical_infection->scrub_nurse : '' }}
                            </td>


                            <td><strong>Name of the Surgery:</strong>
                                {{ isset($surgical_infection->observer_name) ? $surgical_infection->observer_name : '' }}
                            </td>





                        </tr>
                        <tr>
                            <td><strong>Time of incision:</strong>
                                @php
                                    $proc_start = !empty($surgical_infection->proc_start)
                                        ? date('h:i A', strtotime($surgical_infection->proc_start))
                                        : '';
                                @endphp
                                {{ $proc_start }}
                            </td>
                            <td><strong>Time of completion surgery:</strong>
                                @php
                                    $proc_end = !empty($surgical_infection->proc_end)
                                        ? date('h:i A', strtotime($surgical_infection->proc_end))
                                        : '';
                                @endphp
                                {{ $proc_end }}
                            </td>
                        </tr>

                    </table> <br>

                    <table class="table table-bordered">

                        <tr>
                            <th>No.</th>
                            <th style="text-align: center">SSI</th>
                            <th>Yes/No</th>
                            <th>Remarks</th>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="text-align: center"><b>PRE-OP</b></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>If at all possible avoid hair removal; if hair removal is
                                necessary, surgical clippers used for hair removal</td>
                            <td>
                                {{ @$surgical_infection->verify_patient }}
                            </td>
                            <td>{{ @$surgical_infection->remarks1 }}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Advise patients to shower or bathe with an antiseptic agent on
                                the day of surgery and the previous day</td>
                            <td>{{ @$surgical_infection->verify_invest }}</td>
                            <td>{{ @$surgical_infection->remarks2 }}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Thoroughly wash and clean at and around the incision site</td>
                            <td>{{ @$surgical_infection->verify_invest }}</td>
                            <td>{{ @$surgical_infection->remarks3 }}</td>

                        </tr>

                        <tr>
                            <td></td>
                            <td>Screening and Nasal Decolonisation with mupirocin ointment for
                                long stay patients</td>
                            <td>{{ @$surgical_infection->verify_invest }}</td>
                            <td>{{ @$surgical_infection->remarks4 }}</td>
                        </tr>
                        <tr>
                            <td colspan="2">Signature of the assigned staff:</td>
                            <td colspan="2">{{ @$surgical_infection->sign_staff }}
                            </td>

                        </tr>
                        <tr>
                            <td></td>
                            <td style="text-align: center"><b>INTRA-OP</b></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Use appropriate antiseptic agent for skin preparation
                                (Chloroxidine/alcohol)</td>
                            <td>
                                {{ @$surgical_infection->verify_procedure }}
                            </td>
                            <td>{{ @$surgical_infection->remarks5 }}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Prophylactic antibiotic was prescribed & administered.
                                Name of the antibiotic with dose and time of administration.
                            </td>
                            <td>
                                {{ @$surgical_infection->verify_sign }}
                            </td>
                            <td>{{ @$surgical_infection->remarks6 }}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Ensure the patient's body temperature was normal throughout the
                                operation (excludes cardiac)</td>
                            <td>
                                {{ @$surgical_infection->verify_site }}
                            </td>
                            <td>{{ @$surgical_infection->remarks7 }}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Ensure the patient's blood glucose level was normal throughout
                                the operation (diabetic Patients only)</td>
                            <td>
                                {{ @$surgical_infection->verify_blood }}
                            </td>
                            <td>{{ @$surgical_infection->remarks8 }}</td>
                        </tr>

                        <tr>
                            <td colspan="2">Signature of the OT staff:</td>
                            <td colspan="2">{{ @$surgical_infection->ot_staff }}

                            </td>

                        </tr>
                        <tr>
                            <td></td>
                            <td style="text-align: center"><b>POST-OP</b></td>
                            <td></td>
                            <td></td>
                        </tr>


                        <tr>
                            <td></td>
                            <td>Protect with a sterile dressing for 24 to 48 hours post
                                operatively an incision that has been closed primarily</td>
                            <td>
                                {{ @$surgical_infection->verify_allergy }}
                            </td>
                            <td>{{ @$surgical_infection->remarks9 }}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Wash Hands before and after dressing changes and any contact
                                with the surgical site. When an incision dressing must be
                                changed, use sterile technique,</td>
                            <td>
                                {{ @$surgical_infection->verify_anticoag }}
                            </td>
                            <td>{{ @$surgical_infection->remarks10 }}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Educate the patient and family regarding proper incision care,
                                symptoms of SSI, and the need to report such symptoms.</td>
                            <td>
                                {{ @$surgical_infection->verify_cart }}
                            </td>
                            <td>{{ @$surgical_infection->remarks11 }}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Prolongation of Surgical antimicrobial prophylaxis, if indicated
                                or not.</td>
                            <td>
                                {{ @$surgical_infection->verify_site_assess }}
                            </td>
                            <td>{{ @$surgical_infection->remarks12 }}</td>
                        </tr>
                        <tr>
                            <td colspan="2">Signature of the assigned staff:</td>
                            <td colspan="2">{{ @$surgical_infection->assigned_staff }}
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
