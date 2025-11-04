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
            margin-bottom: 2cm;
            /* Increased to accommodate footer */
            margin-left: 1cm;
            position: relative;
        }

        @page {
            size: auto;
            margin-bottom: 2cm;
            /* Space for footer */
        }

        .footer-table {
            position: bottom;
            bottom: 0;
            left: 1cm;
            right: 1cm;
            width: auto;
            margin-top: 10px;
            font-size: 12px;
        }

        .footer-table td {
            border: none !important;
        }

        .main-content {
            margin-bottom: 2cm;
            /* Ensure content doesn't overlap footer */
        }

        td {
            page-break-inside: avoid;
        }
    </style>


</head>

<body onload="window.print()">
    <div class="main-content">
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
                            <li><b>Consultant Name:</b>&nbsp;<span>{{ $admission_info->primary_doctor_name }}</span>
                            </li>
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
                            <span style="font-size: 16px;"><b>CENTRAL LINE INSERTION CHECKLIST</b></span>
                        </div>


                        <table class="table table-bordered">
                            <tr>
                                <td><strong>Date:</strong>
                                    {{ isset($central_line->proc_date) ? date('d/m/Y', strtotime($central_line->proc_date)) : '' }}
                                </td>
                                <td><strong>Name of the Doctor Inserting Line:</strong>
                                    {{ $central_line->doc_name ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Procedure Location:</strong> {{ $central_line->proc_location ?? '' }}</td>
                                <td><strong>Others:</strong> {{ $central_line->loc_other ?? '' }}</td>
                            </tr>
                            <tr>
                                <td colspan="2"><strong>Catheter Type:</strong> {{ $central_line->cath_type ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Number of Lumen:</strong> {{ $central_line->lumen_count ?? '' }}</td>
                                <td><strong>Catheter Lot No:</strong> {{ $central_line->cath_lot ?? '' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Side of The Body:</strong> {{ $central_line->body_side ?? '' }}</td>
                                <td><strong>Insertion Site:</strong> {{ $central_line->insert_site ?? '' }}</td>
                            </tr>
                            <tr>
                                <td colspan="2"><strong>Reason for Insertion:</strong>
                                    {{ $central_line->insert_reason ?? '' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Observer Name (Designation):</strong>
                                    {{ $central_line->observer_name ?? '' }}
                                </td>
                                <td>
                                    <strong>Procedure Start Time:</strong>
                                    {{ isset($central_line->proc_start) ? date('h:i A', strtotime($central_line->proc_start)) : '' }}
                                    <strong>End Time:</strong>
                                    {{ isset($central_line->proc_end) ? date('h:i A', strtotime($central_line->proc_end)) : '' }}
                                </td>
                            </tr>
                        </table>

                        <!-- Steps for Inserting Central Line -->
                        <table class="table table-bordered">
                            <tr>
                                <th colspan="4" class="text-center"><strong>STEPS FOR INSERTING CENTRAL LINE</strong>
                                </th>
                            </tr>
                            <tr>
                                <th><strong>Before procedure</strong></th>
                                <th>Yes</th>
                                <th>No</th>
                                <th>N/A</th>
                            </tr>
                            <tr>
                                <td>Patient and family education regarding central line insertion / Obtain informed
                                    consent.
                                </td>
                                <td colspan="3">{{ $central_line->consent_edu ?? '' }}</td>
                            </tr>
                            <tr>
                                <td>Consent form and other relevant documents complete and in chart (Exception: Emergent
                                    procedure)</td>
                                <td colspan="3">{{ $central_line->consent_docs ?? '' }}</td>
                            </tr>
                        </table>

                        <!-- Time Out Checklist -->
                        <table class="table table-bordered">
                            <tr>
                                <th colspan="4" class="text-center">
                                    <strong>TIME OUT CHECKLIST</strong> &nbsp;&nbsp;
                                    Time-Out (time):
                                    {{ isset($central_line->timeout_time) ? date('h:i A', strtotime($central_line->timeout_time)) : '' }}
                                </th>
                            </tr>
                            <tr>
                                <th>The following have been Verified</th>
                                <th>Yes</th>
                                <th>No</th>
                                <th>N/A</th>
                            </tr>
                            <tr>
                                <td>Name, DOB and UHID of the patient</td>
                                <td colspan="3">{{ $central_line->verify_patient ?? '' }}</td>
                            </tr>
                            <tr>
                                <td>Relevant investigations if any</td>
                                <td colspan="3">{{ $central_line->verify_invest ?? '' }}</td>
                            </tr>
                            <tr>
                                <td>Correct procedure verified</td>
                                <td colspan="3">{{ $central_line->verify_procedure ?? '' }}</td>
                            </tr>
                            <tr>
                                <td>Signature of Observers (Doctor)</td>
                                <td colspan="3">{{ $central_line->verify_sign ?? '' }}</td>
                            </tr>
                            <tr>
                                <td>Site and side of procedure verified</td>
                                <td colspan="3">{{ $central_line->verify_site ?? '' }}</td>
                            </tr>
                            <tr>
                                <td>Blood products required, if any</td>
                                <td colspan="3">{{ $central_line->verify_blood ?? '' }}</td>
                            </tr>
                            <tr>
                                <td>To check allergy for latex or adhesive</td>
                                <td colspan="3">{{ $central_line->verify_allergy ?? '' }}</td>
                            </tr>
                            <tr>
                                <td>Assess the status of anticoagulant therapy</td>
                                <td colspan="3">{{ $central_line->verify_anticoag ?? '' }}</td>
                            </tr>
                            <tr>
                                <td>Assembling of central line insertion cart</td>
                                <td colspan="3">{{ $central_line->verify_cart ?? '' }}</td>
                            </tr>
                            <tr>
                                <td>Site assessment</td>
                                <td colspan="3">{{ $central_line->verify_site_assess ?? '' }}</td>
                            </tr>
                            <tr>
                                <td>Wearing cap mask by all personnel in that room</td>
                                <td colspan="3">{{ $central_line->verify_ppe ?? '' }}</td>
                            </tr>
                            <tr>
                                <td>Hand hygiene</td>
                                <td colspan="3">{{ $central_line->verify_hygiene ?? '' }}</td>
                            </tr>
                            <tr>
                                <td colspan="4"><strong>Before Procedure</strong></td>
                            </tr>
                            <tr>
                                <td>Maintain sterile medium</td>
                                <td colspan="3">{{ $central_line->before_sterile ?? '' }}</td>
                            </tr>
                            <tr>
                                <td>All those performing procedure using sterile gloves, sterile gown, cap, mask (eye
                                    protection/shield, if required)</td>
                                <td colspan="3">{{ $central_line->before_ppe ?? '' }}</td>
                            </tr>
                            <tr>
                                <td>Others in room wearing mask</td>
                                <td colspan="3">{{ $central_line->before_mask ?? '' }}</td>
                            </tr>
                            <tr>
                                <td>Patient sedated</td>
                                <td colspan="3">{{ $central_line->before_sedated ?? '' }}</td>
                            </tr>
                            <tr>
                                <td>If patient is NOT sedated, local anesthetic used</td>
                                <td colspan="3">{{ $central_line->before_anesthetic ?? '' }}</td>
                            </tr>
                            <tr>
                                <td>Transducer set up for CVP monitoring</td>
                                <td colspan="3">{{ $central_line->before_transducer ?? '' }}</td>
                            </tr>
                            <tr>
                                <td colspan="4"><strong>During Procedure</strong></td>
                            </tr>
                            <tr>
                                <td>Maintain aseptic technique</td>
                                <td colspan="3">{{ $central_line->during_aseptic ?? '' }}</td>
                            </tr>
                            <tr>
                                <td>Skin preparation with 2% chlorhexidine and allow it to dry</td>
                                <td colspan="3">{{ $central_line->during_skin_prep ?? '' }}</td>
                            </tr>
                            <tr>
                                <td>Blood aspirated from each lumen</td>
                                <td colspan="3">{{ $central_line->during_aspirate ?? '' }}</td>
                            </tr>
                            <tr>
                                <td colspan="4"><strong>Type/Dosage ml/units of flush:</strong>
                                    {{ $central_line->flush_details ?? '' }}</td>
                            </tr>
                            <tr>
                                <td>Catheter caps placed on lumens</td>
                                <td colspan="3">{{ $central_line->during_caps ?? '' }}</td>
                            </tr>
                            <tr>
                                <td>All lumens clamped</td>
                                <td colspan="3">{{ $central_line->during_clamped ?? '' }}</td>
                            </tr>
                            <tr>
                                <td>Clean blood from the site using antiseptic agent (2% chlorhexidine) and apply
                                    sterile
                                    dressing</td>
                                <td colspan="3">{{ $central_line->during_clean ?? '' }}</td>
                            </tr>
                            <tr>
                                <td>USG guided / Non-USG guided</td>
                                <td colspan="3">{{ $central_line->during_usg ?? '' }}</td>
                            </tr>
                            <tr>
                                <td colspan="4"><strong>After Procedure</strong></td>
                            </tr>
                            <tr>
                                <td colspan="4"><strong>Type of dressing:</strong>
                                    {{ $central_line->after_dressing ?? '' }}</td>
                            </tr>
                            <tr>
                                <td>Verification of line (CXR)</td>
                                <td colspan="3">{{ $central_line->after_verify ?? '' }}</td>
                            </tr>
                            <tr>
                                <td>USG guided / Non-USG guided</td>
                                <td colspan="3">{{ $central_line->after_usg ?? '' }}</td>
                            </tr>
                            <tr>
                                <td>If in OT to be performed in Recovery/ICU</td>
                                <td colspan="3">{{ $central_line->after_transfer ?? '' }}</td>
                            </tr>
                            <tr>
                                <td>Dressing dated</td>
                                <td colspan="3">{{ $central_line->after_dated ?? '' }}</td>
                            </tr>
                            <tr>
                                <td colspan="4"><strong>Comments (If any deviation from usual course):</strong></td>
                            </tr>
                            <tr>
                                <td colspan="4">{{ $central_line->comments ?? '' }}</td>
                            </tr>
                        </table>

                        <!-- Personnel Table -->
                        <table border="1" style="border-collapse: collapse; width: 100%;">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Name</th>
                                    <th>Emp. ID</th>
                                    <th>Date & Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Performer</td>
                                    <td>{{ $central_line->per_name ?? '' }}</td>
                                    <td>{{ $central_line->per_id ?? '' }}</td>
                                    <td>{{ isset($central_line->per_datetime) ? date('d/m/Y h:i A', strtotime($central_line->per_datetime)) : '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Observer</td>
                                    <td>{{ $central_line->observer_name2 ?? '' }}</td>
                                    <td>{{ $central_line->observer_id ?? '' }}</td>
                                    <td>{{ isset($central_line->observer_datetime) ? date('d/m/Y h:i A', strtotime($central_line->observer_datetime)) : '' }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
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
