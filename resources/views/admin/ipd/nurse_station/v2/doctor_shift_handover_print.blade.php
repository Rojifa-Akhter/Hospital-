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

                    <div
                        style="padding: 7px; border-top:1px dotted black; border-bottom:1px dotted black;text-align:center;margin-top:10px; margin-bottom:20px">
                        <span style="font-size: 16px;"><b>IPD DOCTOR SHIFT HANDOVER FORM</b></span>
                    </div>

                    <table class="table table-bordered">
                        <tr>
                            <td colspan="4">
                                <h3>Clinical Summary:</h3>
                                {{ @$doc_handover->clinical_summary ? $doc_handover->clinical_summary : '' }}

                            </td>
                        </tr>

                        <tr>
                            <td colspan="4">
                                <h3>Current Condition</h3>

                            </td>
                        </tr>

                        <tr>
                            <td>
                                <strong> Stable:</strong>
                                {{ @$doc_handover->stable ? $doc_handover->stable : '' }}
                            </td>
                            <td>
                                <strong> Improving:</strong>
                                {{ @$doc_handover->improving ? $doc_handover->improving : '' }}

                            </td>

                            <td>
                                <strong> Deteriorating:</strong>
                                {{ @$doc_handover->deterior ? $doc_handover->deterior : '' }}

                            </td>
                            <td>
                                <strong>Critical:</strong>
                                {{ @$doc_handover->critical ? $doc_handover->critical : '' }}

                            </td>


                        </tr>

                        <tr>
                            <td>
                                <strong> Vital signs trend:</strong>
                                {{ @$doc_handover->vital_sign ? $doc_handover->vital_sign : '' }}
                            </td>
                            <td>
                                <strong>Oxygen requirement:</strong>
                                {{ @$doc_handover->oxygen ? $doc_handover->oxygen : '' }}

                            </td>


                            <td colspan="2">
                                <strong>Consciousness:</strong>
                                {{ @$doc_handover->consciousness == 'Alert' ? 'Alert' : '' }}
                                {{ @$doc_handover->consciousness == 'Drowsy' ? 'Drowsy' : '' }}
                                {{ @$doc_handover->consciousness == 'Unconscious' ? 'Unconscious' : '' }}
                            </td>



                        </tr>



                    </table> <br>

                    @php
                        $med_therap = json_decode($doc_handover->med_therap ?? '[]');
                        $dose_route = json_decode($doc_handover->dose_route ?? '[]');
                        $frequency = json_decode($doc_handover->frequency ?? '[]');
                        $s_date = json_decode($doc_handover->s_date ?? '[]');
                        $comments = json_decode($doc_handover->comments ?? '[]');

                        $hasData = !empty($med_therap) && is_array($med_therap) && count($med_therap) > 0;
                    @endphp

                    <h3>Ongoing Treatments</h3>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Medication / Therapy</th>
                                <th>Dose & Route</th>
                                <th>Frequency</th>
                                <th>Start Date</th>
                                <th>Comments</th>

                            </tr>
                        </thead>
                        <tbody id="medBody">
                            @if ($hasData)
                                @for ($i = 0; $i < count($med_therap); $i++)
                                    <tr>
                                        <td>{{ $med_therap[$i] ?? '' }}</td>
                                        <td>{{ $dose_route[$i] ?? '' }}</td>
                                        <td>{{ $frequency[$i] ?? '' }}</td>
                                        <td>{{ isset($s_date[$i]) ? date('Y-m-d', strtotime($s_date[$i])) : '' }}</td>

                                        <td>{{ $comments[$i] ?? '' }}</td>

                                    </tr>
                                @endfor
                            @endif
                        </tbody>

                    </table> <br>

                    @php
                        $test_name = json_decode($doc_handover->test_name ?? '[]');
                        $date_order = json_decode($doc_handover->date_order ?? '[]');
                        $result = json_decode($doc_handover->result ?? '[]');
                        $remarks = json_decode($doc_handover->remarks ?? '[]');

                        $hasTestData = !empty($test_name) && is_array($test_name) && count($test_name) > 0;
                    @endphp

                    <h3>Pending Investigations / Reportd</h3>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Test Name</th>
                                <th>Date Ordered</th>
                                <th>Result Available</th>
                                <th>Remarks</th>

                            </tr>
                        </thead>
                        <tbody id="repBody">
                            @if ($hasTestData)
                                @for ($i = 0; $i < count($test_name); $i++)
                                    <tr>
                                        <td>{{ $test_name[$i] ?? '' }}</td>
                                        <td>{{ $date_order[$i] ?? '' }}</td>
                                        <td>
                                            {{ isset($result[$i]) && $result[$i] === 'YES' ? 'YES' : '' }}
                                            {{ isset($result[$i]) && $result[$i] === 'NO' ? 'NO' : '' }}
                                        </td>
                                        <td>
                                            {{ $remarks[$i] ?? '' }}
                                        </td>

                                    </tr>
                                @endfor

                            @endif
                        </tbody>

                    </table> <br>

                    <table class="table table-bordered">
                        <tr>
                            <td colspan="4">
                                <h3>Planned Interventions / Instructions:</h3>
                                {{ @$doc_handover->planned_intervention ? $doc_handover->planned_intervention : '' }}

                            </td>
                        </tr>

                        <tr>
                            <td colspan="4">
                                <h3>Important Clinical Alerts</h3>

                            </td>
                        </tr>

                        <tr>
                            <td>
                                <strong>Allergy (Specify):</strong>
                                {{ @$doc_handover->allergy ? $doc_handover->allergy : '' }}
                            </td>
                            <td>
                                <strong>DNR Status:</strong>
                                {{ @$doc_handover->dna ? $doc_handover->dna : '' }}

                            </td>


                            <td>
                                <strong>Infectious Disease Precautions:</strong>
                                {{ @$doc_handover->disease ? $doc_handover->disease : '' }}

                            </td>
                            <td>
                                <strong>Fall Risk / Pressure Ulcer Risk:</strong>
                                {{ @$doc_handover->fall_risk ? $doc_handover->fall_risk : '' }}

                            </td>


                        </tr>

                        <tr>
                            <td colspan="4">
                                <h3>To-Do for Next Doctor:</h3>
                                {{ @$doc_handover->next_doc ? $doc_handover->next_doc : '' }}

                            </td>
                        </tr>


                        <tr>
                            <td colspan="4">
                                <h3>Shift Handover Details</h3>

                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <strong>Outgoing Doctor Name:</strong>
                                {{ @$doc_handover->out_doc ? $doc_handover->out_doc : '' }}

                            </td>
                            <td>
                                <strong>Signature:</strong>
                                {{ @$doc_handover->out_doc_sign ? $doc_handover->out_doc_sign : '' }}

                            </td>

                            <td>
                                <strong>Date/Time:</strong>
                                {{ isset($doc_handover->out_doc_date) ? date('Y-m-d\TH:i', strtotime($doc_handover->out_doc_date)) : '' }}

                            </td>

                        </tr>

                        <tr>
                            <td colspan="2">
                                <strong>Incoming Doctor Name:</strong>
                                {{ @$doc_handover->in_doc ? $doc_handover->in_doc : '' }}

                            </td>
                            <td>
                                <strong>Signature:</strong>
                                {{ @$doc_handover->in_doc_sign ? $doc_handover->in_doc_sign : '' }}

                            </td>

                            <td>
                                <strong>Date/Time: </strong>
                                {{ isset($doc_handover->in_doc_date) ? date('Y-m-d\TH:i', strtotime($doc_handover->in_doc_date)) : '' }}
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
