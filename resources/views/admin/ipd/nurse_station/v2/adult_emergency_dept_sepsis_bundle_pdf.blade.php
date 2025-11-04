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

        .criteria {
            margin-bottom: 10px;
        }

        .red-box {
            background: red;
            color: white;
            font-weight: bold;
            text-align: center;
            padding: 4px;
            font-size: 14px;
        }

        .task-box {
            border: 1px solid #000;
            width: 32%;
            padding: 4px;
        }

        .task-content {
            background: #ff4d4d;
            color: white;
            padding: 5px;
            height: 90px;
            font-size: 12px;
        }

        .task-footer {
            display: flex;
            justify-content: space-between;
            margin-top: 4px;
            font-size: 12px;
        }

        .task-footer input {
            width: 80px;
        }

        .footer-input {
            margin-top: 8px;
            width: 100%;
        }

        .signoff-table th,
        .signoff-table td {
            text-align: center;
            font-size: 12px;
        }

        .signoff-table input,
        .signoff-table select {
            width: 100%;
            box-sizing: border-box;
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
                            <td colspan="2">
                                <p style="color:red; font-weight:bold; text-align:center;">
                                    Complete this section in one (1) hour of clinical suspicion
                                    <br>
                                    HIGH RISK Sepsis Six Checklist
                                </p>
                            </td>
                        </tr>
                        <tr>
                            @php
                                $criteria = json_decode($adult_emergency_dept->criteria ?? '[]', true) ?? [];
                            @endphp
                            <td> <b>Other Criteria:</b><br>
                                <label><input type="checkbox" name="criteria[]" value="1"
                                        {{ in_array('1', $criteria) ? 'checked' : '' }}>
                                    SBP &lt;90</label>
                                <label><input type="checkbox" name="criteria[]" value="2"
                                        {{ in_array('2', $criteria) ? 'checked' : '' }}>
                                    MAP &lt;65</label><br>
                                <label><input type="checkbox" name="criteria[]" value="3"
                                        {{ in_array('3', $criteria) ? 'checked' : '' }}>
                                    Acute respiratory failure
                                    requiring
                                    NIV/IV</label><br>
                            </td>
                            <td>Vasopressor:
                                {{ @$adult_emergency_dept->vasopressor }}
                            </td>
                        </tr>
                        <tr>
                            @php
                                $task = json_decode($adult_emergency_dept->task ?? '[]', true) ?? [];
                            @endphp
                            <td rowspan="2" style="width:70%;">
                                <div style="display:flex;flex-wrap:wrap;gap:6px;">
                                    <!-- Box 1 -->
                                    <div class="task-box">
                                        <div class="task-content">
                                            <label>
                                                <input type="checkbox" name="task[]" value="1"
                                                    {{ in_array('1', $task) ? 'checked' : '' }}>
                                                <b>1 Ensure ED Clinician attends</b>
                                            </label><br>
                                            Specialist and above or equivalent senior nurse
                                        </div>
                                        <div class="task-footer">
                                            <span>ID:{{ @$adult_emergency_dept->clinical_id }}</span>
                                            <span>Time:{{ @$adult_emergency_dept->clinical_time }}</span>
                                        </div>
                                    </div>

                                    <!-- Box 2 -->
                                    <div class="task-box">
                                        <div class="task-content">
                                            <label>
                                                <input type="checkbox" name="task[]" value="2"
                                                    {{ in_array('2', $task) ? 'checked' : '' }}>
                                                <b>2 Give O₂, if required</b>
                                            </label><br>
                                            Start if saturations less than 92%. Aim for 94-98%.
                                            If at risk of hypercarbia use 88-92%.
                                        </div>
                                        <div class="task-footer">
                                            <span>ID:{{ @$adult_emergency_dept->o2_id }}</span>
                                            <span>Time:{{ @$adult_emergency_dept->o2_time }}</span>
                                        </div>
                                    </div>

                                    <!-- Box 3 -->
                                    <div class="task-box">
                                        <div class="task-content">
                                            <label>
                                                <input type="checkbox" name="task[]" value="3"
                                                    {{ in_array('3', $task) ? 'checked' : '' }}>
                                                <b>3 Obtain IV access, take bloods</b>
                                            </label><br>
                                            Include blood cultures, glucose, lactate, FBC, U&Es,
                                            CRP, LFTs, Clotting.
                                        </div>
                                        <div class="task-footer">
                                            <span>ID:{{ @$adult_emergency_dept->iv_id }}</span>
                                            <span>Time:{{ @$adult_emergency_dept->iv_time }}</span>
                                        </div>
                                    </div>

                                    <!-- Box 4 -->
                                    <div class="task-box">
                                        <div class="task-content">
                                            <label>
                                                <input type="checkbox" name="task[]" value="4"
                                                    {{ in_array('4', $task) ? 'checked' : '' }}>
                                                <b>4 Give antibiotics and consider source
                                                    control</b>
                                            </label><br>
                                            Maximum dose broad spectrum therapy.
                                        </div>
                                        <div class="task-footer">
                                            <span>ID:{{ @$adult_emergency_dept->antibio_id }}</span>
                                            <span>Time:{{ @$adult_emergency_dept->antibio_time }}</span>
                                        </div>
                                    </div>

                                    <!-- Box 5 -->
                                    <div class="task-box">
                                        <div class="task-content">
                                            <label>
                                                <input type="checkbox" name="task[]" value="5"
                                                    {{ in_array('5', $task) ? 'checked' : '' }}>
                                                <b>5 Give IV fluids</b>
                                            </label><br>
                                            Up to 20 ml/kg fluid boluses. Use lactate to guide
                                            fluid therapy.
                                        </div>
                                        <div class="task-footer">
                                            <span>ID:{{ @$adult_emergency_dept->fluids_id }}</span>
                                            <span>Time:{{ @$adult_emergency_dept->fluids_time }}</span>
                                        </div>
                                    </div>

                                    <!-- Box 6 -->
                                    <div class="task-box">
                                        <div class="task-content">
                                            <label>
                                                <input type="checkbox" name="task[]" value="6"
                                                    {{ in_array('6', $task) ? 'checked' : '' }}>
                                                <b>6 Monitor</b>
                                            </label><br>
                                            Use NEWS2. Measure urine output. Repeat lactate if
                                            elevated or clinical changes.
                                        </div>
                                        <div class="task-footer">
                                            <span>ID:{{ @$adult_emergency_dept->monitor_id }}</span>
                                            <span>Time:{{ @$adult_emergency_dept->monitor_time }}</span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            @php
                                $news2 = json_decode($adult_emergency_dept->news2 ?? '[]', true) ?? [];
                            @endphp
                            <td style="width:30%; text-align:left;">
                                <b>Is NEWS2 7 or above?</b><br>
                                or is NEWS2 5 or 6 and one of:<br>
                                <input type="checkbox" value="1" {{ in_array('1', $news2) ? 'checked' : '' }}
                                    name="news2[]"> Any
                                NEWS2 parameter score of 3<br>
                                <input type="checkbox" value="2" {{ in_array('2', $news2) ? 'checked' : '' }}
                                    name="news2[]">
                                Mottled/ashen skin<br>
                                <input type="checkbox" value="3" {{ in_array('3', $news2) ? 'checked' : '' }}
                                    name="news2[]">
                                Non-blanching rash<br>
                                <input type="checkbox" value="4" {{ in_array('4', $news2) ? 'checked' : '' }}
                                    name="news2[]">
                                Cyanosis of lips/tongue<br>
                                <input type="checkbox" value="5" {{ in_array('5', $news2) ? 'checked' : '' }}
                                    name="news2[]">
                                Deterioration since last assessment<br>
                                <input type="checkbox" value="6" {{ in_array('6', $news2) ? 'checked' : '' }}
                                    name="news2[]">
                                Deterioration since recent
                                intervention<br>
                                <input type="checkbox" value="7" {{ in_array('7', $news2) ? 'checked' : '' }}
                                    name="news2[]"> Lactate
                                ≥ 2 mmol/L or known AKI<br><br>
                                NEWS2 Score:{{ @$adult_emergency_dept->news2_score }}<br>
                                Initial Lactate:{{ @$adult_emergency_dept->news2_lactate }}
                            </td>
                        </tr>

                    </table>

                    <table class="table table-bordered">
                        <tr>
                            <td colspan="2">Name of Antibiotic prescribed:</td>
                            <td>{{ $adult_emergency_dept->antibiotic_name ?? '' }}</td>
                            <td>Lactate level after 1 hour: </td>
                            <td>{{ $adult_emergency_dept->lactate_level ?? '' }}</td>
                        </tr>
                        <tr>
                            <td colspan="5">Sepsis Sign-off:</td>
                        </tr>
                        <tr>
                            <th>Name</th>
                            <th>Signature</th>
                            <th>Designation</th>
                            <th>Emp. ID</th>
                            <th>Time</th>
                        </tr>
                        <tr>
                            <td>{{ $adult_emergency_dept->sepsis_name ?? '' }}</td>
                            <td>{{ $adult_emergency_dept->sepsis_name ?? '' }}</td>
                            <td>{{ $adult_emergency_dept->sepsis_design ?? '' }}</td>
                            <td>{{ $adult_emergency_dept->h_sepsis_name ?? '' }}</td>
                            @php
                                $sepsis_time = explode(' ', $adult_emergency_dept->sepsis_time ?? '');
                            @endphp
                            <td>{{ $sepsis_time[1] ?? '' }}</td>
                        </tr>
                    </table>
                     <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th colspan="6" style="text-align: center">Antibiotic Prescription</th>
                            </tr>
                            <tr class="border-0">
                                <th>Medicine/Surgical</th>
                                <th>Route</th>
                                <th>Frequency</th>
                                <th>Duration</th>
                                <th>Qty.</th>
                                <th>Instruction</th>

                            </tr>


                        </thead>
                        <tbody>
                            @forelse ($medicine_info as $keys => $item)
                                <tr class="border-0" id="tbl{{ $keys }}">
                                    <td class="text-left">
                                        {{ $item->brand_name }}
                                    </td>
                                    <td class="text-left">
                                        {{ $item->route }}
                                    </td>

                                    <td class="text-center">
                                        {{ $item->dosage }}
                                    </td>

                                    <td class="text-center">
                                        {{ $item->duration_mu }}
                                    </td>

                                    <td style="text-align: right">
                                        {{ $item->item_qty }}
                                    </td>

                                    <td class="text-left">
                                        @foreach ($instructions as $key => $dmu)
                                            {{ $item->instruction_take == $key ? $dmu['data'] : '' }}
                                        @endforeach
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-danger text-center">Your Cart is Empty</td>
                                </tr>
                            @endforelse

                        </tbody>

                    </table>
                </td>
            </tr>
    </table>
