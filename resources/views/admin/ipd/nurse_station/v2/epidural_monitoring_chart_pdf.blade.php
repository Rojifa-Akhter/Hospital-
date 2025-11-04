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
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background: white;
            /* optional, to cover content behind */
            z-index: 1000;
            /* keep it on top */
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
                        <span style="font-size: 16px;"><b>EPIDURAL MONITORING CHART </b></span>
                    </div>

                    <table class="table table-bordered">
                        @php
                            $time_list = !empty($epidural->dt_time) ? json_decode($epidural->dt_time, true) : [];
                            $lb = !empty($epidural->lb) ? json_decode($epidural->lb, true) : [];
                            $pr = !empty($epidural->pr) ? json_decode($epidural->pr, true) : [];
                            $llb = !empty($epidural->llb) ? json_decode($epidural->llb, true) : [];
                            $rswe = !empty($epidural->rswe) ? json_decode($epidural->rswe, true) : [];
                        @endphp


                        <div class="col-md-12">
                            <table class="table table-bordered text-center">
                                <thead>
                                    <tr>
                                        <th>Date & Time</th>
                                        <th>Level of Block</th>
                                        <th>Paresthesia</th>
                                        <th>Lower Limb Mobility</th>
                                        <th>RN Sign With Emp ID</th>

                                    </tr>
                                </thead>
                                <tbody id="vitalsTable">
                                    @if (!empty($time_list))
                                        @foreach ($time_list as $i => $time)
                                            <tr>
                                                <td>
                                                    {{ $time }}
                                                </td>
                                                <td>
                                                    {{ $lb[$i] ?? '' }}
                                                </td>
                                                <td>
                                                    {{ isset($pr[$i]) && $pr[$i] == 1 ? 'Yes' : '' }}
                                                    {{ isset($pr[$i]) && $pr[$i] == 2 ? 'No' : '' }}


                                                </td>
                                                <td>
                                                    {{ isset($llb[$i]) && $llb[$i] == 1 ? 'Full' : '' }}
                                                    {{ isset($llb[$i]) && $llb[$i] == 2 ? 'Partial' : '' }}
                                                    {{ isset($llb[$i]) && $llb[$i] == 3 ? 'Nill' : '' }}

                                                </td>
                                                <td>
                                                    {{ $rswe[$i] ?? '' }}
                                                </td>

                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5">No Data Found!</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>

                        </div>

                        <div class="col-md-12">
                            <label><b>If any one of these are seen:</b></label>

                        </div>

                        <div class="col-md-12">
                            <p>
                                1. Hypotension (BP &lt;90&#x2f;50mm of Hg) <br>
                                2. Bradycardia (Pulse
                                &lt;60b&#x2f;mt) <br>
                                3. Breathing difficulty <br>
                                4. Inability to
                                move lower limb of paresthesia of numberless <br>
                                5. Pain Relief
                                is inadequate <br>
                                6. Fetal Distress <br>
                                7. Patient unresponsive <br>
                                8.
                                Desaturation <br>
                                9. Headache <br>
                                10. Seizures </p>
                        </div>

                        <div class="col-md-3">
                            <input type="checkbox" name="ca" value="1"
                                {{ @$epidural->ca == 1 ? 'checked' : '' }}>
                            <b>Call Anesthetist</b>
                        </div>

                        <div class="col-md-3">
                            <input type="checkbox" name="se" value="1"
                                {{ @$epidural->se == 1 ? 'checked' : '' }}>
                            <b>Stop epidural</b>
                        </div>

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
