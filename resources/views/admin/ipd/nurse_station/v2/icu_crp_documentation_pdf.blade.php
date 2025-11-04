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
                        <span style="font-size: 16px;"><b>CPR DOCUMENTATION SHEET</b></span>
                    </div>

                    <table class="table table-bordered">
                        <tr>
                            <td><strong>Date:</strong>
                                {{ isset($cpr_doc->cpr_date) ? date('Y-m-d', strtotime($cpr_doc->cpr_date)) : '' }}
                            </td>
                            <td>
                                <strong>History of Event:</strong>
                            </td>

                        </tr>

                        <tr>
                            <td><strong>Time & Location of Arrest: </strong>
                                @php
                                    $cprr_time = explode(' ', @$cpr_doc->cprr_time);
                                @endphp
                                {{ $cprr_time[1] ?? '' }} | {{ isset($cpr_doc->cpr_loc) ? $cpr_doc->cpr_loc : '' }}
                            </td>
                            <td rowspan="6">
                                {{ isset($cpr_doc->history_event) ? $cpr_doc->history_event : '' }}
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Code blue activated:</strong> {{ @$cpr_doc->code_blue }}</td>
                        </tr>
                        <tr>
                            <td><strong>Witnessed:</strong> {{ @$cpr_doc->witnessed }}</td>
                        </tr>
                        <tr>
                            <td><strong>Consciousness at onset:</strong> {{ @$cpr_doc->consciousness }}</td>
                        </tr>
                        <tr>
                            <td><strong>Indicate all monitors that were present:</strong> {{ @$cpr_doc->monitors }}
                            </td>
                        </tr>
                        <tr>
                            <td><strong>CPR Started:</strong> {{ @$cpr_doc->cpr }}</td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <table cellspacing="0" cellpadding="4" style="width:100%; border-collapse:collapse;">
                                    <tr>
                                        <th>Initial VS</th>
                                        <th>BP(mmhg)</th>
                                        <th>Temp(°F)</th>
                                        <th>Pulse(/min)</th>
                                        <th>SpO₂(%)</th>
                                        <th>GCS</th>
                                        <th>Others</th>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>{{ isset($cpr_doc->bp) ? $cpr_doc->bp : '' }}</td>
                                        <td>{{ isset($cpr_doc->temp) ? $cpr_doc->temp : '' }}</td>
                                        <td>{{ isset($cpr_doc->pulse) ? $cpr_doc->pulse : '' }}</td>
                                        <td>{{ isset($cpr_doc->spo2) ? $cpr_doc->spo2 : '' }}</td>
                                        <td>{{ isset($cpr_doc->gcs) ? $cpr_doc->gcs : '' }}</td>
                                        <td>{{ isset($cpr_doc->initial_others) ? $cpr_doc->initial_others : '' }}</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <th>Airway/Breathing</th>
                            <th>Circulation</th>
                        </tr>
                        <tr>
                            <td><strong>Artificial Ventilation:</strong> {{ @$cpr_doc->art_ventilation }}</td>
                            <td><strong>First Documented Rhythm:</strong></td>
                        </tr>
                        <tr>
                            <td><strong>Intubated:</strong></td>
                            <td rowspan="3">{{ isset($cpr_doc->doc_rhythm) ? $cpr_doc->doc_rhythm : '' }}</td>
                        </tr>
                        <tr>
                            <td>
                                @php
                                    $intubated_time = explode(' ', @$cpr_doc->intubated_time);
                                @endphp
                                Time: {{ $intubated_time[1] ?? '' }} |
                                Size & Site: {{ isset($cpr_doc->intubated_size) ? $cpr_doc->intubated_size : '' }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                By: {{ isset($cpr_doc->intubated_by) ? $cpr_doc->intubated_by : '' }} |
                                No. of Attempts:
                                {{ isset($cpr_doc->intubated_attemp) ? $cpr_doc->intubated_attemp : '' }}
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Placement Confirmed By:</strong>
                                {{ isset($cpr_doc->placement_by) ? $cpr_doc->placement_by : '' }}</td>
                            <td><strong>Pt. Defibrillated:</strong> {{ @$cpr_doc->pt_defibrillated }}</td>
                        </tr>
                        <tr>
                            <td><strong>Tube Secured At (cm):</strong>
                                {{ isset($cpr_doc->tube_secured) ? $cpr_doc->tube_secured : '' }}</td>
                            <td>

                                @php
                                    $shock_time_list = !empty($cpr_doc->time_shock)
                                        ? json_decode($cpr_doc->time_shock, true)
                                        : [];

                                    function ordinal($number)
                                    {
                                        $ends = ['th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th'];
                                        if ($number % 100 >= 11 && $number % 100 <= 13) {
                                            return $number . 'th';
                                        } else {
                                            return $number . $ends[$number % 10];
                                        }
                                    }
                                @endphp
                                <table border="1" cellspacing="0" cellpadding="4"
                                    style="border-collapse:collapse; width:100%; text-align:center;">
                                    <tr>
                                        <th>If Yes,Time of Shocks</th>
                                        <th>Time</th>

                                    </tr>
                                    <tbody id="shockTableBody">
                                        @if (!empty($shock_time_list))
                                            @foreach ($shock_time_list as $i => $time)
                                                <tr>
                                                    <td style="text-align: center">
                                                        {{ ordinal($i + 1) }} Shock
                                                        <input type="hidden" name="shock_num[]"
                                                            value="{{ ordinal($i + 1) }}">
                                                    </td>
                                                    <td>
                                                        {{ $time }}
                                                    </td>


                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td style="text-align: center" colspan="2">
                                                    No data available !
                                                </td>

                                            </tr>
                                        @endif
                                    </tbody>
                                </table> <br>
                                <label><b>No. Of Attemps:</b>
                                    {{ isset($cpr_doc->shock_attemp) ? $cpr_doc->shock_attemp : '' }}</label>
                            </td>
                        </tr>
                </td>
            </tr>
            <tr>
                <td><strong>NG/OG Tube:</strong>
                    @php
                        $ng_time = explode(' ', @$cpr_doc->ng_time);
                    @endphp
                    Time: {{ $ng_time[1] ?? '' }} |
                    Size: {{ isset($cpr_doc->ng_size) ? $cpr_doc->ng_size : '' }} |
                    By: {{ isset($cpr_doc->ng_by) ? $cpr_doc->ng_by : '' }}
                </td>
                <td><strong>IO/IV/CV:</strong>
                    @php
                        $io_time = explode(' ', @$cpr_doc->io_time);
                    @endphp
                    Time: {{ $io_time[1] ?? '' }} |
                    Size & Site: {{ isset($cpr_doc->io_size) ? $cpr_doc->io_size : '' }} |
                    By: {{ isset($cpr_doc->io_by) ? $cpr_doc->io_by : '' }} |
                    No. of Attempts: {{ isset($cpr_doc->io_attemp) ? $cpr_doc->io_attemp : '' }}
                </td>
            </tr>
    </table>

    @php
        $cpr_time = json_decode($cpr_doc->cpr_time ?? '[]');
        $cpr_hr = json_decode($cpr_doc->cpr_hr ?? '[]');
        $cpr_rhythm = json_decode($cpr_doc->cpr_rhythm ?? '[]');
        $cpr_bp = json_decode($cpr_doc->cpr_bp ?? '[]');
        $cpr_rr = json_decode($cpr_doc->cpr_rr ?? '[]');
        $cpr_spo2 = json_decode($cpr_doc->cpr_spo2 ?? '[]');
        $defib = json_decode($cpr_doc->defib ?? '[]');
        $t1 = json_decode($cpr_doc->t1 ?? '[]');
        $epi = json_decode($cpr_doc->epi ?? '[]');
        $atropine = json_decode($cpr_doc->atropine ?? '[]');
        $lidocaine_med = json_decode($cpr_doc->lidocaine_med ?? '[]');
        $sodium_bicarb = json_decode($cpr_doc->sodium_bicarb ?? '[]');
        $calcium = json_decode($cpr_doc->calcium ?? '[]');
        $amiodarone = json_decode($cpr_doc->amiodarone ?? '[]');
        $rhythm_response = json_decode($cpr_doc->rhythm_response ?? '[]');
        $dopamine = json_decode($cpr_doc->dopamine ?? '[]');
        $lidocaine_iv = json_decode($cpr_doc->lidocaine_iv ?? '[]');
        $fluid_bolus = json_decode($cpr_doc->fluid_bolus ?? '[]');
        $abg_drawn = json_decode($cpr_doc->abg_drawn ?? '[]');
        $comments = json_decode($cpr_doc->comments ?? '[]');

        $hasData = !empty($cpr_time) && is_array($cpr_time) && count($cpr_time) > 0;
    @endphp

    <table border="1" cellspacing="0" cellpadding="4"
        style="border-collapse:collapse; width:100%; text-align:center; font-size:13px;">
        <thead>
            <tr>
                <th rowspan="2">Time</th>
                <th rowspan="2">HR</th>
                <th rowspan="2">Rhythm</th>
                <th rowspan="2">BP</th>
                <th rowspan="2">RR</th>
                <th rowspan="2">SpO₂</th>
                <th rowspan="2">Defib Joules</th>
                <th colspan="7">Medications (* if given by ET Tube)</th>
                <th rowspan="2">Rhythm Response</th>
                <th colspan="3">IV Meds/Fluids</th>
                <th rowspan="2">ABG Drawn (√)</th>
                <th rowspan="2">Comments</th>
            </tr>
            <tr>
                <th>1:1, 000EPI</th>
                <th>EPI1:10, 000</th>
                <th>Atropine</th>
                <th>Lidocaine</th>
                <th>Sodium Bicarbonate</th>
                <th>Calcium</th>
                <th>Amiodarone</th>
                <th>Dopamine</th>
                <th>Lidocaine</th>
                <th>IV Fluid Bolus</th>
            </tr>
        </thead>
        <tbody>
            @if ($hasData)
                @for ($i = 0; $i < count($cpr_time); $i++)
                    <tr>
                        <td>{{ $cpr_time[$i] ?? '' }}</td>
                        <td>{{ $cpr_hr[$i] ?? '' }}</td>
                        <td>{{ $cpr_rhythm[$i] ?? '' }}</td>
                        <td>{{ $cpr_bp[$i] ?? '' }}</td>
                        <td>{{ $cpr_rr[$i] ?? '' }}</td>
                        <td>{{ $cpr_spo2[$i] ?? '' }}</td>
                        <td>{{ $defib[$i] ?? '' }}</td>
                        <td>{{ $t1[$i] ?? '' }}</td>
                        <td>{{ $epi[$i] ?? '' }}</td>
                        <td>{{ $atropine[$i] ?? '' }}</td>
                        <td>{{ $lidocaine_med[$i] ?? '' }}</td>
                        <td>{{ $sodium_bicarb[$i] ?? '' }}</td>
                        <td>{{ $calcium[$i] ?? '' }}</td>
                        <td>{{ $amiodarone[$i] ?? '' }}</td>
                        <td>{{ $rhythm_response[$i] ?? '' }}</td>
                        <td>{{ $dopamine[$i] ?? '' }}</td>
                        <td>{{ $lidocaine_iv[$i] ?? '' }}</td>
                        <td>{{ $fluid_bolus[$i] ?? '' }}</td>
                        <td>{{ $abg_drawn[$i] ?? '' }}</td>
                        <td>{{ $comments[$i] ?? '' }}</td>
                    </tr>
                @endfor
            @else
                <tr>
                    <td colspan="20" style="text-align:center;">No data available</td>
                </tr>
            @endif
        </tbody>
    </table> <br>
    @php
        $disposition_time = explode(' ', @$cpr_doc->disposition_time);
        $expired_at = explode(' ', @$cpr_doc->expired_at);
        $cpr_reason = json_decode($cpr_doc->reason ?? '[]', true) ?? [];
    @endphp

    <table border="1" cellspacing="0" cellpadding="4" style="width:100%; border-collapse:collapse;">
        <tr>
            <td colspan="2"><strong>Was the patient successfully resuscitated?</strong><br>
                {{ @$cpr_doc->resuscitated ?? '' }}
            </td>
            <td><strong>Time code terminated:</strong><br>
                {{ @$cpr_doc->time_code ?? '' }}
            </td>
        </tr>
        <tr>
            <td><strong>Disposition of Patient:</strong></td>
            <td>Time: {{ $disposition_time[1] ?? '' }}</td>
            <td>Location: {{ @$cpr_doc->disposition_loc ?? '' }}</td>
        </tr>
        <tr>
            <td>Patient expired at: {{ $expired_at[1] ?? '' }}</td>
            <td>Pronounced by: {{ @$cpr_doc->pronounced_by ?? '' }}</td>
            <td>Family notified: {{ @$cpr_doc->family_notified ?? '' }}</td>
        </tr>
        <tr>
            <td colspan="3">
                <strong>Names of all individuals present at code:</strong><br>
                {{ @$cpr_doc->present_code ?? '' }}
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <strong>Reason for Resuscitation ended:</strong><br>
                @if (!empty($cpr_reason))
                    {{ implode(', ', $cpr_reason) }}
                @else
                    N/A
                @endif
            </td>
        </tr>
        <tr>
            <td><strong>Team Leader:</strong><br>
                {{ @$cpr_doc->team_leader ?? '' }}
            </td>
            <td><strong>CPR Committee Notification:</strong><br>
                {{ @$cpr_doc->cpr_notifi ?? '' }}
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
