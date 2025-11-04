<style>
    .custom-form {
        width: 100%;
        border: none;
        outline: none;
    }

    .border-left-0 {
        border-left: none !important;
    }

    .border-right-0 {
        border-right: none !important;
    }

    .medicine_thead {
        background-color: #e1e1e5;
    }

    .w-15 {
        width: 15%;
    }

    .w-25 {
        width: 25%;
    }

    .w-8 {
        width: 8%;
    }

    .w-6 {
        width: 6%;
    }

    .w-16 {
        width: 16%;
    }

    .remove_row {
        cursor: pointer;
        background-color: white;
    }

    .fa-star {
        display: none;
    }

    thead {
        position: sticky;
        top: 0px;
        left: 0px;
        right: 0px;
        background-color: white;
    }

    .fs-12 {
        font-size: 14px;
    }

    .pdf-icon {
        font-size: 22px;
        color: red
    }

    .add-btn {

        margin: 5px 2px;
        padding: 2px 4px;
        cursor: pointer;
        background: #008CBA;
        color: #fff;
        border: none;
        border-radius: 3px;

    }

    #medTable input,
    #painTable input,
    #monitorTable input {
        width: 100%;

    }

    #medTable th,
    #painTable th,
    #monitorTable th {
        font-size: 14px
    }

    #medTable th,
    #painTable th,
    #monitorTable th #medTable td,
    #painTable td,
    #monitorTable td {
        text-align: center;
    }


    .add-col-btn:hover {
        color: darkgreen;
        transform: scale(1.2);
    }

    .remove-col-btn {
        cursor: pointer;
        background: #CF5C46;
        color: white;
        border: none;
        padding: 2px 5px;
        font-size: 12px;
    }

    .blood-gas-table input[type="text"] {
        width: 100%;
        padding: 2px;
        font-size: 12px;
        text-align: center;
    }

    textarea {
        width: 100%;
        height: 100%;
        font-size: 12px;
    }

    #tewsTable th {
        background: #00bfff;
        text-align: center;
    }

    .selected {
        background: lightgreen !important;
    }

    .level {
        font-weight: bold;
        color: white;
        padding: 4px;
    }

    .level1 {
        background: red;
    }

    .level2 {
        background: orange;
    }

    .level3 {
        background: yellow;
        color: black;
    }

    .level4 {
        background: green;
    }

    .level5 {
        background: blue;
    }
</style>

<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

<main id="page-content">
    <section class="fixed_asset">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div
                        class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                        <div class="col-md-10">
                            <h5 class="mt-2 mb-0">ADULT Emergency Department Clinical Bundle</h5>
                            <small>IPD / Nurse Station / ADULT Emergency Department Clinical Bundle</small>
                        </div>
                        <div class="col-md-2">
                            <a class="btn btn-md btn-warning" target="_blank"
                                href="{{ route('adult-emergency-dept-pdf', [$patient_info->patient_no_pk, $patient_info->admission_no_pk]) }}">PDF
                                Export</a>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body pt-2">
                            <div class="row">

                                <div class="col-12 pb-4 text-center">
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Patient Name:
                                        {{ @$patient_info->patient_name }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">UHID:
                                        {{ @$patient_info->patient_code }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">IP No:
                                        {{ @$patient_info->admission_uid }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Admission Date:
                                        {{ date('d/m/Y', strtotime($patient_info->admission_date)) }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Admission
                                        Department: {{ $patient_info->admitted_department }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Age:
                                        {{ $patient_info->age }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Gender:
                                        {{ $patient_info->gender_txt }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Bed No.:
                                        {{ $patient_info->bed_name }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Consultant Name:
                                        {{ $admission_info->primary_doctor_name }}</span>
                                </div>

                                <div class="col-md-12">
                                    <form action="{{ route('adult-emergency-dept-store') }}" method="post"
                                        id="ADULTEMERGENCY">
                                        @csrf
                                        <input type="hidden" name="patient_no_fk" id="patient_no_fk"
                                            value="{{ $patient_no_fk }}">
                                        <input type="hidden" name="admission_no_fk" id="admission_no_fk"
                                            value="{{ $admission_id }}">
                                        <input type="hidden" name="adult_emergency_dept_no_pk"
                                            value="{{ isset($adult_emergency_dept->adult_emergency_dept_no_pk) ? $adult_emergency_dept->adult_emergency_dept_no_pk : '' }}">


                                        <div class="table-responsive">

                                            @php
                                                $substanceMisuse =
                                                    json_decode(
                                                        $adult_emergency_dept->substance_misuse ?? '[]',
                                                        true,
                                                    ) ?? [];
                                                $aVisually =
                                                    json_decode($adult_emergency_dept->a_visually ?? '[]', true) ?? [];
                                                $oxygenReq =
                                                    json_decode($adult_emergency_dept->oxygen_req ?? '[]', true) ?? [];
                                                $aSounds =
                                                    json_decode($adult_emergency_dept->a_sounds ?? '[]', true) ?? [];
                                                $bVisually =
                                                    json_decode($adult_emergency_dept->b_visually ?? '[]', true) ?? [];
                                                $unequal =
                                                    json_decode($adult_emergency_dept->unequal ?? '[]', true) ?? [];
                                                $bSounds =
                                                    json_decode($adult_emergency_dept->b_sounds ?? '[]', true) ?? [];
                                                $rAir = json_decode($adult_emergency_dept->r_air ?? '[]', true) ?? [];
                                                $absent =
                                                    json_decode($adult_emergency_dept->absent ?? '[]', true) ?? [];
                                                $cVisually =
                                                    json_decode($adult_emergency_dept->c_visually ?? '[]', true) ?? [];
                                                $cSounds =
                                                    json_decode($adult_emergency_dept->c_sounds ?? '[]', true) ?? [];
                                                $exposure =
                                                    json_decode($adult_emergency_dept->exposure ?? '[]', true) ?? [];
                                            @endphp

                                            <table width="100%" border="1" style="margin-top:10px">
                                                <tr>
                                                    <td><label for="medico">Medico-Legal case:</label></td>
                                                    <td>
                                                        <select id="medico" class="form-control" name="medico"
                                                            onchange="toggleCaseNo()">
                                                            <option value="">--Select--</option>
                                                            <option value="Yes"
                                                                {{ @$adult_emergency_dept->medico == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option value="No"
                                                                {{ @$adult_emergency_dept->medico == 'No' ? 'selected' : '' }}>
                                                                No</option>
                                                        </select>
                                                    </td>
                                                    <td><label for="case_no"> Case No.:</label></td>
                                                    <td>
                                                        <input type="text" id="case_no" name="case_no"
                                                            class="form-control"
                                                            value="{{ @$adult_emergency_dept->case_no }}" readonly>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><label>Mode of Arrival:</label></td>
                                                    <td>
                                                        <select class="form-control" name="arrival">
                                                            <option value="">--Select--</option>
                                                            <option value="Ambulance"
                                                                {{ @$adult_emergency_dept->arrival == 'Ambulance' ? 'selected' : '' }}>
                                                                Ambulance</option>
                                                            <option value="Own transport"
                                                                {{ @$adult_emergency_dept->arrival == 'Own transport' ? 'selected' : '' }}>
                                                                Own transport</option>
                                                            <option value="On foot"
                                                                {{ @$adult_emergency_dept->arrival == 'On foot' ? 'selected' : '' }}>
                                                                On foot</option>
                                                        </select>
                                                    </td>
                                                    <td><label>Ambulation:</label></td>
                                                    <td>
                                                        <select class="form-control" name="ambulation">
                                                            <option value="">--Select--</option>
                                                            <option value="Stretcher"
                                                                {{ @$adult_emergency_dept->ambulation == 'Stretcher' ? 'selected' : '' }}>
                                                                Stretcher</option>
                                                            <option value="Wheelchair"
                                                                {{ @$adult_emergency_dept->ambulation == 'Wheelchair' ? 'selected' : '' }}>
                                                                Wheelchair</option>
                                                            <option value="Aided"
                                                                {{ @$adult_emergency_dept->ambulation == 'Aided' ? 'selected' : '' }}>
                                                                Aided</option>
                                                            <option value="Independent"
                                                                {{ @$adult_emergency_dept->ambulation == 'Independent' ? 'selected' : '' }}>
                                                                Independent</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><label>Name of attendant:</label>
                                                        <input type="text" name="sign" id="sign"
                                                            class="form-control"
                                                            value="{{ @$adult_emergency_dept->sign }}">
                                                        <input type="hidden" name="h_sign" id="h_sign"
                                                            value="{{ @$adult_emergency_dept->h_sign }}">
                                                    </td>
                                                    <td><label>Relationship with attendant:</label>
                                                        <input type="text" name="r_attendant" class="form-control"
                                                            value="{{ @$adult_emergency_dept->r_attendant }}">
                                                    </td>
                                                    <td colspan="2"><label>Contact Number:</label>
                                                        <input type="text" name="c_number" class="form-control"
                                                            value="{{ @$adult_emergency_dept->c_number }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4">
                                                        <label>Presenting Complaints:</label>
                                                        <textarea name="p_complaints" cols="30" rows="3" class="form-control">{{ @$adult_emergency_dept->p_complaints }}</textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">Triage Observations</td>
                                                    <td>Traumatic Injuries:</td>
                                                    <td>
                                                        <select class="form-control" name="traumatic">
                                                            <option value="">--Select--</option>
                                                            <option value="Yes"
                                                                {{ @$adult_emergency_dept->traumatic == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option value="No"
                                                                {{ @$adult_emergency_dept->traumatic == 'No' ? 'selected' : '' }}>
                                                                No</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                            </table>

                                            <table width="100%" border="1" style="margin-top:10px">
                                                <tr>
                                                    <th>Time</th>
                                                    <th>RR/min</th>
                                                    <th>SpO2 / FiO2</th>
                                                    <th>HR/min</th>
                                                    <th>BP (mmHg)</th>
                                                    <th>AVPU</th>
                                                    <th>RBS (mmol/L)</th>
                                                    <th>Temp (°F)</th>
                                                    <th>Pain (NRS)</th>
                                                    <th>TEWS</th>
                                                </tr>
                                                <tr>
                                                    <td><input type="text" name="to_time" class="form-control"
                                                            value="{{ @$adult_emergency_dept->to_time }}"></td>
                                                    <td><input type="text" name="to_rr" class="form-control"
                                                            value="{{ @$adult_emergency_dept->to_rr }}"></td>
                                                    <td><input type="text" name="to_spo2" class="form-control"
                                                            value="{{ @$adult_emergency_dept->to_spo2 }}"></td>
                                                    <td><input type="text" name="to_hr" class="form-control"
                                                            value="{{ @$adult_emergency_dept->to_hr }}"></td>
                                                    <td><input type="text" name="to_bp" class="form-control"
                                                            value="{{ @$adult_emergency_dept->to_bp }}"></td>
                                                    <td><input type="text" name="to_avpu" class="form-control"
                                                            value="{{ @$adult_emergency_dept->to_avpu }}"></td>
                                                    <td><input type="text" name="to_rbs" class="form-control"
                                                            value="{{ @$adult_emergency_dept->to_rbs }}"></td>
                                                    <td><input type="text" name="to_temp" class="form-control"
                                                            value="{{ @$adult_emergency_dept->to_temp }}"></td>
                                                    <td><input type="text" name="to_pain" class="form-control"
                                                            value="{{ @$adult_emergency_dept->to_pain }}"></td>
                                                    <td><input type="text" name="to_tews" class="form-control"
                                                            value="{{ @$adult_emergency_dept->to_tews }}"></td>
                                                </tr>
                                            </table>
                                            <div style="display:flex;gap:20px;">

                                                <table width="100%" border="1" style="margin-top:10px"
                                                    id="tewsTable">
                                                    <thead>
                                                        <tr>
                                                            <th colspan="8" style="text-align: center">ADULT TEWS
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th>OLDER THAN 12 YEARS <br> TALLER THAN 150cm</th>
                                                            <th>3</th>
                                                            <th>2</th>
                                                            <th>1</th>
                                                            <th>0</th>
                                                            <th>1</th>
                                                            <th>2</th>
                                                            <th>3</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td style="background: #00bfff"><b>Mobility</b></td>
                                                            <td style="background: #b8dfff"></td>
                                                            <td style="background: #b8dfff"></td>
                                                            <td style="background: #b8dfff"></td>
                                                            <td data-value="0">Walking</td>
                                                            <td data-value="1">With Help</td>
                                                            <td data-value="2">Stretcher/Immobile</td>
                                                            <td style="background: #b8dfff"></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="background: #00bfff"><b>RR</b></td>
                                                            <td style="background: #b8dfff"></td>
                                                            <td data-value="2">less than 9</td>
                                                            <td style="background: #b8dfff"></td>
                                                            <td data-value="0">9-14</td>
                                                            <td data-value="1">15-20</td>
                                                            <td data-value="2">21-29</td>
                                                            <td data-value="3">More than 29</td>
                                                        </tr>
                                                        <tr>
                                                            <td style="background: #00bfff"><b>HR</b></td>
                                                            <td style="background: #b8dfff"></td>
                                                            <td data-value="2">Less than 41</td>
                                                            <td data-value="1">41-50</td>
                                                            <td data-value="0">51-100</td>
                                                            <td data-value="1">101-110</td>
                                                            <td data-value="2">111-129</td>
                                                            <td data-value="3">more than 129</td>
                                                        </tr>
                                                        <tr>
                                                            <td style="background: #00bfff"><b>SBP</b></td>
                                                            <td data-value="3">Less than 71</td>
                                                            <td data-value="2">71-80</td>
                                                            <td data-value="1">81-100</td>
                                                            <td data-value="0">101-199</td>
                                                            <td style="background: #b8dfff"></td>
                                                            <td data-value="2">more than 199</td>
                                                            <td style="background: #b8dfff"></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="background: #00bfff"><b>Temp</b></td>
                                                            <td style="background: #b8dfff"></td>
                                                            <td data-value="2">Cold or Under &deg;95</td>
                                                            <td style="background: #b8dfff"></td>
                                                            <td data-value="0">&deg;95-&deg;101</td>
                                                            <td style="background: #b8dfff"></td>
                                                            <td data-value="2">Hot or Over &deg;101</td>
                                                            <td style="background: #b8dfff"></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="background:#00bfff"><b>AVPU</b></td>
                                                            <td style="background: #b8dfff"></td>
                                                            <td data-value="2">Confused</td>
                                                            <td style="background: #b8dfff"></td>
                                                            <td data-value="0">Alert</td>
                                                            <td data-value="1">Reacts to Voice</td>
                                                            <td data-value="2">Reacts to Pain</td>
                                                            <td data-value="3">Unresponsive</td>
                                                        </tr>
                                                        <tr>
                                                            <td style="background: #00bfff"><b>Trauma</b></td>
                                                            <td style="background: #b8dfff"></td>
                                                            <td style="background: #b8dfff"></td>
                                                            <td data-value="1">Yes</td>
                                                            <td data-value="0">No</td>
                                                            <td style="background: #b8dfff"></td>
                                                            <td style="background: #b8dfff"></td>
                                                            <td style="background: #b8dfff"></td>

                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <table width="100%" border="1" style="margin-top:10px">
                                                    <thead>
                                                        <tr>
                                                            <th colspan="3"
                                                                style="text-align: center;background:#00bfff">SATS
                                                                Triage Priority</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td class="level level1">Level 1</td>
                                                            <td>TWES 7 or more</td>
                                                            <td><input type="checkbox" id="level1"
                                                                    name="sats_triage[]" value="level1"
                                                                    {{ in_array('level1', json_decode($adult_emergency_dept->sats_triage ?? '[]', true) ?? []) ? 'checked' : '' }}>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="level level2">Level 2</td>
                                                            <td>TWES 5 or 6</td>
                                                            <td><input type="checkbox" id="level2"
                                                                    name="sats_triage[]" value="level2"
                                                                    {{ in_array('level2', json_decode($adult_emergency_dept->sats_triage ?? '[]', true) ?? []) ? 'checked' : '' }}>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="level level3">Level 3</td>
                                                            <td>TWES 3 or 4</td>
                                                            <td><input type="checkbox" id="level3"
                                                                    name="sats_triage[]" value="level3"
                                                                    {{ in_array('level3', json_decode($adult_emergency_dept->sats_triage ?? '[]', true) ?? []) ? 'checked' : '' }}>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="level level4">Level 4</td>
                                                            <td>TWES 0,1 or 2</td>
                                                            <td><input type="checkbox" id="level4"
                                                                    name="sats_triage[]" value="level4"
                                                                    {{ in_array('level4', json_decode($adult_emergency_dept->sats_triage ?? '[]', true) ?? []) ? 'checked' : '' }}>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="level level5">Level 5</td>
                                                            <td>Deceased</td>
                                                            <td><input type="checkbox" id="level5"
                                                                    name="sats_triage[]" value="level5"
                                                                    {{ in_array('level5', json_decode($adult_emergency_dept->sats_triage ?? '[]', true) ?? []) ? 'checked' : '' }}>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                            @php
                                                $substanceMisuse =
                                                    json_decode(
                                                        $adult_emergency_dept->substance_misuse ?? '[]',
                                                        true,
                                                    ) ?? [];
                                                $aVisually =
                                                    json_decode($adult_emergency_dept->a_visually ?? '[]', true) ?? [];
                                                $oxygenReq =
                                                    json_decode($adult_emergency_dept->oxygen_req ?? '[]', true) ?? [];
                                                $aSounds =
                                                    json_decode($adult_emergency_dept->a_sounds ?? '[]', true) ?? [];
                                                $bVisually =
                                                    json_decode($adult_emergency_dept->b_visually ?? '[]', true) ?? [];
                                                $unequal =
                                                    json_decode($adult_emergency_dept->unequal ?? '[]', true) ?? [];
                                                $bSounds =
                                                    json_decode($adult_emergency_dept->b_sounds ?? '[]', true) ?? [];
                                                $rAir = json_decode($adult_emergency_dept->r_air ?? '[]', true) ?? [];
                                                $absent =
                                                    json_decode($adult_emergency_dept->absent ?? '[]', true) ?? [];
                                                $cVisually =
                                                    json_decode($adult_emergency_dept->c_visually ?? '[]', true) ?? [];
                                                $cSounds =
                                                    json_decode($adult_emergency_dept->c_sounds ?? '[]', true) ?? [];
                                                $exposure =
                                                    json_decode($adult_emergency_dept->exposure ?? '[]', true) ?? [];
                                                $medSource =
                                                    json_decode($adult_emergency_dept->med_source ?? '[]', true) ?? [];
                                                $medDisposition =
                                                    json_decode($adult_emergency_dept->med_disposition ?? '[]', true) ??
                                                    [];
                                            @endphp

                                            <table width="100%" border="1" style="margin-top:10px">
                                                <tr>
                                                    <td colspan="7"><strong>Triage Sign-off:</strong></td>
                                                </tr>
                                                <tr>
                                                    <th colspan="2">Name</th>
                                                    <th>Signature</th>
                                                    <th colspan="2">Designation</th>
                                                    <th>Emp. ID</th>
                                                    <th>Time</th>
                                                </tr>
                                                <tr>
                                                    <td colspan="2"><input type="text" name="ts_name"
                                                            class="form-control" id="ts_name"
                                                            value="{{ @$adult_emergency_dept->ts_name }}">
                                                        <input type="hidden" name="hts_epmid" id="hts_epmid">
                                                    </td>
                                                    <td><input type="text" name="ts_sign" class="form-control"
                                                            value="{{ @$adult_emergency_dept->ts_sign }}"></td>
                                                    <td colspan="2"><input type="text" name="ts_design"
                                                            class="form-control"
                                                            value="{{ @$adult_emergency_dept->ts_design }}"></td>
                                                    <td><input type="text" name="ts_epmid"
                                                            value="{{ @$adult_emergency_dept->ts_epmid }}"></td>
                                                    <td><input type="text" name="ts_time" class="form-control"
                                                            value="{{ @$adult_emergency_dept->ts_time }}"></td>
                                                </tr>

                                                <tr>
                                                    <td colspan="7"><strong>Presenting History:</strong></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="7">
                                                        <textarea name="pre_history" class="form-control" rows="10">{{ @$adult_emergency_dept->pre_history }}</textarea>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="7"><strong>Significant Other History:</strong></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="7">
                                                        <textarea name="sf_history" class="form-control" rows="10">{{ @$adult_emergency_dept->sf_history }}</textarea>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="7"><strong>Substance misuse:</strong><br>
                                                        @foreach (['None', 'Smoking', 'Tobacco', 'Betel leaf/nut', 'Ethanol', 'Recreational drug'] as $opt)
                                                            <label><input type="checkbox" name="substance_misuse[]"
                                                                    value="{{ $opt }}"
                                                                    {{ in_array($opt, $substanceMisuse) ? 'checked' : '' }}>
                                                                {{ $opt }}</label>&nbsp;
                                                        @endforeach
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="7"><strong>ED Plan:</strong></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="7">
                                                        <textarea name="ed_plan" class="form-control" rows="10">{{ @$adult_emergency_dept->ed_plan }}</textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3">Initial Assessment:</td>
                                                    <td colspan="3"></td>
                                                    <td>Time of Assessment:</td>
                                                </tr>

                                                {{-- AIRWAY --}}
                                                <tr>
                                                    <td colspan="3">Assessment</td>
                                                    <td colspan="3" style="text-align: center">
                                                        <strong>AIRWAY</strong>
                                                    </td>
                                                    <td>Management</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3">
                                                        <b>Visually:</b>
                                                        @foreach (['Clear', 'Obstructed'] as $opt)
                                                            <label>
                                                                <input type="checkbox" name="a_visually[]"
                                                                    value="{{ $opt }}"
                                                                    {{ in_array($opt, $aVisually) ? 'checked' : '' }}>
                                                                {{ $opt }}
                                                            </label>&nbsp;
                                                        @endforeach
                                                    </td>
                                                    <td colspan="4">
                                                        <b>Oxygen requirement:</b>
                                                        @foreach (['No requirement', 'Nasal cannula or facemask', 'Non-invasive ventilation', 'Intubation'] as $opt)
                                                            <label>
                                                                <input type="checkbox" name="oxygen_req[]"
                                                                    value="{{ $opt }}"
                                                                    {{ in_array($opt, $oxygenReq) ? 'checked' : '' }}>
                                                                {{ $opt }}
                                                            </label>&nbsp;
                                                        @endforeach
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="7"><b>Sounds:</b>
                                                        @foreach (['Clear', 'Stridor', 'Snoring', 'Gurgling'] as $opt)
                                                            <label>
                                                                <input type="checkbox" name="a_sounds[]"
                                                                    value="{{ $opt }}"
                                                                    {{ in_array($opt, $aSounds) ? 'checked' : '' }}>
                                                                {{ $opt }}
                                                            </label>&nbsp;
                                                        @endforeach
                                                    </td>
                                                </tr>

                                                {{-- BREATHING --}}
                                                <tr>
                                                    <td colspan="3">Assessment</td>
                                                    <td colspan="3" style="text-align: center">
                                                        <strong>BREATHING</strong>
                                                    </td>
                                                    <td>Management</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="7"><b>Visually:</b>
                                                        @foreach (['Normal effort', 'Increased effort', 'Accessory muscles', 'Tripoding', 'Unequal expansion', 'No effort made'] as $opt)
                                                            @if ($opt === 'Unequal expansion')
                                                                <label>
                                                                    <input type="checkbox" name="b_visually[]"
                                                                        value="Unequal expansion"
                                                                        {{ in_array('Unequal expansion', $bVisually) ? 'checked' : '' }}>
                                                                    Unequal expansion (&nbsp;
                                                                    <label><input type="checkbox" name="unequal[]"
                                                                            value="Rt"
                                                                            {{ in_array('Rt', $unequal) ? 'checked' : '' }}>
                                                                        &gt;Rt</label>
                                                                    <label><input type="checkbox" name="unequal[]"
                                                                            value="Lt"
                                                                            {{ in_array('Lt', $unequal) ? 'checked' : '' }}>
                                                                        &gt;Lt</label>&nbsp;)
                                                                </label>
                                                            @else
                                                                <label>
                                                                    <input type="checkbox" name="b_visually[]"
                                                                        value="{{ $opt }}"
                                                                        {{ in_array($opt, $bVisually) ? 'checked' : '' }}>
                                                                    {{ $opt }}
                                                                </label>&nbsp;
                                                            @endif
                                                        @endforeach
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="5"><b>Sounds:</b>
                                                        @foreach (['Normal', 'Wheeze', 'Crackles', 'Reduced Air entry', 'Absent'] as $opt)
                                                            @if ($opt === 'Reduced Air entry')
                                                                <label>
                                                                    <input type="checkbox" name="b_sounds[]"
                                                                        value="Reduced Air entry"
                                                                        {{ in_array('Reduced Air entry', $bSounds) ? 'checked' : '' }}>
                                                                    Reduced Air entry (&nbsp;
                                                                    <label><input type="checkbox" name="r_air[]"
                                                                            value="Rt"
                                                                            {{ in_array('Rt', $rAir) ? 'checked' : '' }}>
                                                                        &gt;Rt</label>
                                                                    <label><input type="checkbox" name="r_air[]"
                                                                            value="Lt"
                                                                            {{ in_array('Lt', $rAir) ? 'checked' : '' }}>
                                                                        &gt;Lt</label>&nbsp;)
                                                                </label>
                                                            @elseif($opt === 'Absent')
                                                                <label>
                                                                    <input type="checkbox" name="b_sounds[]"
                                                                        value="Absent"
                                                                        {{ in_array('Absent', $bSounds) ? 'checked' : '' }}>
                                                                    Absent (&nbsp;
                                                                    <label><input type="checkbox" name="absent[]"
                                                                            value="Rt"
                                                                            {{ in_array('Rt', $absent) ? 'checked' : '' }}>
                                                                        Rt</label>
                                                                    <label><input type="checkbox" name="absent[]"
                                                                            value="Lt"
                                                                            {{ in_array('Lt', $absent) ? 'checked' : '' }}>
                                                                        Lt</label>&nbsp;)
                                                                </label>
                                                            @else
                                                                <label>
                                                                    <input type="checkbox" name="b_sounds[]"
                                                                        value="{{ $opt }}"
                                                                        {{ in_array($opt, $bSounds) ? 'checked' : '' }}>
                                                                    {{ $opt }}
                                                                </label>&nbsp;
                                                            @endif
                                                        @endforeach
                                                    </td>
                                                    <td><b>Vitals(RR/min):</b>
                                                        <input type="text" name="b_vital"
                                                            value="{{ @$adult_emergency_dept->b_vital }}">
                                                    </td>
                                                    <td><b>SpO<sub>2</sub>(%):</b>
                                                        <input type="text" name="b_spo2"
                                                            value="{{ @$adult_emergency_dept->b_spo2 }}">
                                                    </td>
                                                </tr>

                                                {{-- CIRCULATION --}}
                                                <tr>
                                                    <td colspan="3">Assessment</td>
                                                    <td colspan="3" style="text-align: center">
                                                        <strong>CIRCULATION</strong>
                                                    </td>
                                                    <td>Management</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="7"><b>Visually:</b>
                                                        @foreach (['Good colour', 'Pale', 'Cyanosed', 'Sweaty/clammy', 'Obvious bleeding'] as $opt)
                                                            <label>
                                                                <input type="checkbox" name="c_visually[]"
                                                                    value="{{ $opt }}"
                                                                    {{ in_array($opt, $cVisually) ? 'checked' : '' }}>
                                                                {{ $opt }}
                                                            </label>&nbsp;
                                                        @endforeach
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="5"><b>Sounds:</b>
                                                        @foreach (['Normal', 'Muffled', 'Murmur', 'Absent', 'Other'] as $opt)
                                                            <label>
                                                                <input type="checkbox" name="c_sounds[]"
                                                                    value="{{ $opt }}"
                                                                    {{ in_array($opt, $cSounds) ? 'checked' : '' }}>
                                                                {{ $opt }}
                                                            </label>&nbsp;
                                                        @endforeach
                                                    </td>
                                                    <td><b>Vitals(RR/min):</b>
                                                        <input type="text" name="c_vital"
                                                            value="{{ @$adult_emergency_dept->c_vital }}">
                                                    </td>
                                                    <td><b>BP/CRT:</b>
                                                        <input type="text" name="c_crt"
                                                            value="{{ @$adult_emergency_dept->c_crt }}">
                                                    </td>
                                                </tr>

                                                {{-- DISABILITY --}}
                                                <tr>
                                                    <td colspan="3">Assessment</td>
                                                    <td colspan="3" style="text-align: center">
                                                        <strong>DISABILITY</strong>
                                                    </td>
                                                    <td>Management</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2"><b>GCS:</b></td>
                                                    <td>Eyes (4) =
                                                        <select id="eyes" name="eyes">
                                                            <option value="">Select</option>
                                                            @for ($i = 1; $i <= 4; $i++)
                                                                <option value="{{ $i }}"
                                                                    {{ (string) ($adult_emergency_dept->eyes ?? '') === (string) $i ? 'selected' : '' }}>
                                                                    {{ $i }}</option>
                                                            @endfor
                                                        </select>
                                                    </td>
                                                    <td>Verbal (5) =
                                                        <select id="verbal" name="verbal">
                                                            <option value="">Select</option>
                                                            @for ($i = 1; $i <= 5; $i++)
                                                                <option value="{{ $i }}"
                                                                    {{ (string) ($adult_emergency_dept->verbal ?? '') === (string) $i ? 'selected' : '' }}>
                                                                    {{ $i }}</option>
                                                            @endfor
                                                        </select>
                                                    </td>
                                                    <td>Motor (6) =
                                                        <select id="motor" name="motor">
                                                            <option value="">Select</option>
                                                            @for ($i = 1; $i <= 6; $i++)
                                                                <option value="{{ $i }}"
                                                                    {{ (string) ($adult_emergency_dept->motor ?? '') === (string) $i ? 'selected' : '' }}>
                                                                    {{ $i }}</option>
                                                            @endfor
                                                        </select>
                                                    </td>
                                                    <td colspan="2">
                                                        <b>Total = <input type="text" id="total"
                                                                name="total" readonly
                                                                value="{{ @$adult_emergency_dept->total }}">
                                                            /15</b>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><b>PEARL:</b>
                                                        <select name="pearl">
                                                            <option value="">Select</option>
                                                            <option value="Yes"
                                                                {{ @$adult_emergency_dept->pearl === 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option value="No"
                                                                {{ @$adult_emergency_dept->pearl === 'No' ? 'selected' : '' }}>
                                                                No</option>
                                                        </select>
                                                    </td>
                                                    <td colspan="3">If NO, Comments
                                                        <input type="text" name="p_comment" class="form-control"
                                                            value="{{ @$adult_emergency_dept->p_comment }}">
                                                    </td>
                                                    <td><b>Gross focal neurology:</b>
                                                        <select name="gfn">
                                                            <option value="">Select</option>
                                                            <option value="Yes"
                                                                {{ @$adult_emergency_dept->gfn === 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option value="No"
                                                                {{ @$adult_emergency_dept->gfn === 'No' ? 'selected' : '' }}>
                                                                No</option>
                                                        </select>
                                                    </td>
                                                    <td colspan="2">If YES, Comments
                                                        <input type="text" name="gfn_comment" class="form-control"
                                                            value="{{ @$adult_emergency_dept->gfn_comment }}">
                                                    </td>
                                                </tr>

                                                {{-- EXPOSURE --}}
                                                <tr>
                                                    <td colspan="3">Assessment</td>
                                                    <td colspan="3" style="text-align: center">
                                                        <strong>Exposure</strong>
                                                    </td>
                                                    <td>Management</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4">(See body map)
                                                        @foreach (['Rash', 'Deformation', 'Injuries', 'Dehydration', 'Other'] as $opt)
                                                            <label>
                                                                <input type="checkbox" name="exposure[]"
                                                                    value="{{ $opt }}"
                                                                    {{ in_array($opt, $exposure) ? 'checked' : '' }}>
                                                                {{ $opt }}
                                                            </label>&nbsp;
                                                        @endforeach
                                                    </td>
                                                    <td colspan="3">
                                                        <input type="text" name="exposure_other"
                                                            class="form-control" placeholder="if Other (specify):"
                                                            value="{{ @$adult_emergency_dept->exposure_other }}">
                                                    </td>
                                                </tr>

                                                {{-- FOCUSED SYSTEMIC EXAM --}}
                                                <tr>
                                                    <td colspan="3">Assessment</td>
                                                    <td colspan="3" style="text-align: center"><strong>Focused
                                                            Systemic Examination</strong></td>
                                                    <td>Management</td>
                                                </tr>

                                                {{-- SIGNATURE BLOCK --}}
                                                <tr>
                                                    <th colspan="3">Assessment completed by</th>
                                                    <th colspan="2">Designation</th>
                                                    <th>Emp. ID</th>
                                                    <th>Time</th>
                                                </tr>
                                                <tr>
                                                    <td colspan="3">
                                                        <input type="text" name="f_name" id="f_name"
                                                            value="{{ @$adult_emergency_dept->f_name }}"
                                                            class="form-control" placeholder="name">
                                                        <input type="hidden" name="hf_empid" id="hf_empid">
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" name="f_design"
                                                            value="{{ @$adult_emergency_dept->f_design }}"
                                                            class="form-control">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="f_empid"
                                                            value="{{ @$adult_emergency_dept->f_empid }}">
                                                    </td>
                                                    <td>
                                                        <input type="time" name="f_time"
                                                            value="{{ @$adult_emergency_dept->f_time }}"
                                                            class="form-control">
                                                    </td>
                                                </tr>

                                                {{-- ALLERGIES --}}
                                                <tr>
                                                    <td colspan="2">Allergies and adverse drug reactions:</td>
                                                    <td>
                                                        <select name="drug_reaction">
                                                            <option value="">Select</option>
                                                            <option value="Yes"
                                                                {{ @$adult_emergency_dept->drug_reaction === 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option value="No"
                                                                {{ @$adult_emergency_dept->drug_reaction === 'No' ? 'selected' : '' }}>
                                                                No</option>
                                                            <option value="Unknown"
                                                                {{ @$adult_emergency_dept->drug_reaction === 'Unknown' ? 'selected' : '' }}>
                                                                Unknown</option>
                                                        </select>
                                                    </td>
                                                    <td>If yes, please specify:</td>
                                                    <td colspan="3">
                                                        <input type="text" name="drug_other"
                                                            value="{{ @$adult_emergency_dept->drug_other }}"
                                                            class="form-control">
                                                    </td>
                                                </tr>



                                            </table>
                                            @php
                                                $mr_drug_list = !empty($adult_emergency_dept->mr_drug)
                                                    ? json_decode($adult_emergency_dept->mr_drug, true)
                                                    : [];
                                                $mr_dose_list = !empty($adult_emergency_dept->mr_dose)
                                                    ? json_decode($adult_emergency_dept->mr_dose, true)
                                                    : [];
                                                $mr_route_list = !empty($adult_emergency_dept->mr_route)
                                                    ? json_decode($adult_emergency_dept->mr_route, true)
                                                    : [];
                                                $mr_freq_list = !empty($adult_emergency_dept->mr_freq)
                                                    ? json_decode($adult_emergency_dept->mr_freq, true)
                                                    : [];
                                                $mr_datetime_list = !empty($adult_emergency_dept->mr_datetime)
                                                    ? json_decode($adult_emergency_dept->mr_datetime, true)
                                                    : [];
                                                $continue_hos_list = !empty($adult_emergency_dept->continue_hos)
                                                    ? json_decode($adult_emergency_dept->continue_hos, true)
                                                    : [];
                                            @endphp


                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th colspan="7"
                                                            style="text-align:center;background:#E1E1E5">Medicine
                                                            reconcilliation</th>
                                                    </tr>
                                                    <tr>
                                                        <th style="text-align:center;background:#E1E1E5"
                                                            class="py-1 border-0 w-20">Drug Name</th>
                                                        <th style="text-align:center;background:#E1E1E5"
                                                            class="py-1 border-0 w-15">Dose</th>
                                                        <th style="text-align:center;background:#E1E1E5"
                                                            class="py-1 border-0 w-15">Route</th>
                                                        <th style="text-align:center;background:#E1E1E5"
                                                            class="py-1 border-0 w-15">Frequency</th>
                                                        <th style="text-align:center;background:#E1E1E5"
                                                            class="py-1 border-0 w-15">Last dose
                                                            (date & time)</th>
                                                        <th style="text-align:center;background:#E1E1E5"
                                                            class="py-1 border-0 w-15">Continue in
                                                            hospital</th>
                                                        <th style="text-align:center;background:#E1E1E5"
                                                            class="py-1 border-0 w-11">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="medicineTableBody">
                                                    @if (!empty($mr_drug_list))
                                                        @foreach ($mr_drug_list as $i => $drug)
                                                            <tr>
                                                                <td><input type="text"
                                                                        class="form-control form-control-sm"
                                                                        name="mr_drug[]" id="mr_drug"
                                                                        value="{{ $drug }}">
                                                                    <input type="hidden" name="hdn_mr_drug[]">

                                                                </td>
                                                                <td><input type="text"
                                                                        class="form-control form-control-sm"
                                                                        name="mr_dose[]"
                                                                        value="{{ $mr_dose_list[$i] ?? '' }}"></td>
                                                                <td>
                                                                    <select class="form-control form-control-sm"
                                                                        name="mr_route[]">
                                                                        <option value="0">Select</option>
                                                                        @foreach ($route as $key => $dmu)
                                                                            <option value="{{ $key }}"
                                                                                {{ ($mr_route_list[$i] ?? '') == $key ? 'selected' : '' }}>
                                                                                {{ $dmu['data'] }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <select class="form-control form-control-sm"
                                                                        name="mr_freq[]">
                                                                        <option value="0">Select</option>
                                                                        @foreach ($dose as $key => $dmu)
                                                                            <option value="{{ $key }}"
                                                                                {{ ($mr_freq_list[$i] ?? '') == $key ? 'selected' : '' }}>
                                                                                {{ $dmu['data'] }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                                <td><input type="datetime-local"
                                                                        class="form-control form-control-sm"
                                                                        name="mr_datetime[]"
                                                                        value="{{ $mr_datetime_list[$i] ?? '' }}">
                                                                </td>
                                                                <td>
                                                                    <select name="continue_hos[]"
                                                                        class="form-control form-control-sm">
                                                                        <option value="">Select</option>
                                                                        <option value="Yes"
                                                                            {{ ($continue_hos_list[$i] ?? '') == 'Yes' ? 'selected' : '' }}>
                                                                            Yes</option>
                                                                        <option value="No"
                                                                            {{ ($continue_hos_list[$i] ?? '') == 'No' ? 'selected' : '' }}>
                                                                            No</option>
                                                                    </select>
                                                                </td>
                                                                <td class="text-center">
                                                                    <span class="btn btn-success btn-md addRow"><i
                                                                            class="fa fa-plus"></i></span>
                                                                    <span class="btn btn-danger btn-md removeRow"><i
                                                                            class="fa fa-trash"></i></span>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        {{-- fallback empty row --}}
                                                        <tr>
                                                            <td><input type="text"
                                                                    class="form-control form-control-sm"
                                                                    name="mr_drug[]" id="mr_drug">
                                                                <input type="hidden" name="hdn_mr_drug[]">


                                                            </td>
                                                            <td><input type="text"
                                                                    class="form-control form-control-sm"
                                                                    name="mr_dose[]"></td>
                                                            <td>
                                                                <select class="form-control form-control-sm"
                                                                    name="mr_route[]">
                                                                    <option value="0">Select</option>
                                                                    @foreach ($route as $key => $dmu)
                                                                        <option value="{{ $key }}">
                                                                            {{ $dmu['data'] }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select class="form-control form-control-sm"
                                                                    name="mr_freq[]">
                                                                    <option value="0">Select</option>
                                                                    @foreach ($dose as $key => $dmu)
                                                                        <option value="{{ $key }}">
                                                                            {{ $dmu['data'] }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td><input type="datetime-local"
                                                                    class="form-control form-control-sm"
                                                                    name="mr_datetime[]"></td>
                                                            <td>
                                                                <select name="continue_hos[]"
                                                                    class="form-control form-control-sm">
                                                                    <option value="">Select</option>
                                                                    <option value="Yes">Yes</option>
                                                                    <option value="No">No</option>
                                                                </select>
                                                            </td>
                                                            <td class="text-center">
                                                                <span class="btn btn-success btn-md addRow"><i
                                                                        class="fa fa-plus"></i></span>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>

                                            <table width="100%" border="1" style="margin-top:10px">
                                                <tr>
                                                    <td colspan="7">
                                                        <b>Source of medication list:</b><br>
                                                        <label>
                                                            <input type="checkbox" name="med_source[]"
                                                                value="Patient’s medication list"
                                                                {{ in_array('Patient’s medication list', $medSource) ? 'checked' : '' }}>
                                                            Patient’s medication list
                                                        </label><br>
                                                        <label>
                                                            <input type="checkbox" name="med_source[]"
                                                                value="Physician’s list"
                                                                {{ in_array('Physician’s list', $medSource) ? 'checked' : '' }}>
                                                            Physician’s list
                                                        </label><br>
                                                        <label>
                                                            <input type="checkbox" name="med_source[]"
                                                                value="Patient/Family recall"
                                                                {{ in_array('Patient/Family recall', $medSource) ? 'checked' : '' }}>
                                                            Patient/Family recall
                                                        </label><br>
                                                        <label>
                                                            <input type="checkbox" name="med_source[]"
                                                                value="Previous discharge papers"
                                                                {{ in_array('Previous discharge papers', $medSource) ? 'checked' : '' }}>
                                                            Previous discharge papers
                                                        </label><br>
                                                        <label>
                                                            <input type="checkbox" name="med_source[]"
                                                                value="Referring facility"
                                                                {{ in_array('Referring facility', $medSource) ? 'checked' : '' }}>
                                                            Referring facility
                                                        </label><br>
                                                        <label>
                                                            <input type="checkbox" name="med_source[]"
                                                                value="Pharmacy"
                                                                {{ in_array('Pharmacy', $medSource) ? 'checked' : '' }}>
                                                            Pharmacy
                                                        </label><br>
                                                        <label>
                                                            <input type="checkbox" name="med_source[]" value="Others"
                                                                {{ in_array('Others', $medSource) ? 'checked' : '' }}>
                                                            Others: This patient is not on any prescription, OTC or
                                                            herbal remedies
                                                        </label>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="7">
                                                        <b>Disposition of medications:</b><br>
                                                        <label>
                                                            <input type="checkbox" name="med_disposition[]"
                                                                value="None with patient"
                                                                {{ in_array('None with patient', $medDisposition) ? 'checked' : '' }}>
                                                            None with patient
                                                        </label><br>
                                                        <label>
                                                            <input type="checkbox" name="med_disposition[]"
                                                                value="Sent home with family"
                                                                {{ in_array('Sent home with family', $medDisposition) ? 'checked' : '' }}>
                                                            Sent home with family
                                                        </label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th colspan="7" style="text-align:center">Oxygen Therapy</th>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">Indication</td>
                                                    <td>Target SpO<sub>2</sub></td>
                                                    <td>Flow rate</td>
                                                    <td>Route</td>
                                                    <td>Sign ID</td>
                                                    <td>Time started</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2"><input type="text" name="ot_indication"
                                                            class="form-control"
                                                            value="{{ @$adult_emergency_dept->ot_indication }}"></td>
                                                    <td><input type="text" name="ot_spo2" class="form-control"
                                                            value="{{ @$adult_emergency_dept->ot_spo2 }}"></td>
                                                    <td><input type="text" name="ot_flow" class="form-control"
                                                            value="{{ @$adult_emergency_dept->ot_flow }}"></td>
                                                    <td><input type="text" name="ot_route" class="form-control"
                                                            value="{{ @$adult_emergency_dept->ot_route }}"></td>
                                                    <td><input type="text" name="ot_sign" class="form-control"
                                                            value="{{ @$adult_emergency_dept->ot_sign }}"></td>
                                                    <td><input type="time" name="ot_time" class="form-control"
                                                            value="{{ @$adult_emergency_dept->ot_time }}"></td>
                                                </tr>
                                            </table>





                                            <div class="table-responsive">
                                                <table class="table border-0 mt-2 mb-0 medicine_add_cart"
                                                    id="medicine_list">
                                                    <thead class="medicine_thead">
                                                        <tr>
                                                            <th colspan="7" style="text-align: center">Analgesia
                                                                and
                                                                other STAT medication</th>
                                                        </tr>
                                                        <tr class="border-0">
                                                            <th class="py-1 border-0 w-25">Medicine/Surgical</th>
                                                            <th class="py-1 px-1 border-0 w-15">Route</th>
                                                            <th class="py-1 px-1 border-0 w-15">Frequency</th>
                                                            <th class="py-1 px-1 border-0 w-14">Duration</th>
                                                            <th class="py-1 px-1 border-0 w-5">Qty.</th>
                                                            <th class="py-1 px-1 border-0 w-20">Instruction</th>
                                                            <th class="py-1 px-1 border-0 w-6">Action</th>
                                                        </tr>

                                                        <tr class="border-0" id="0">
                                                            <td class="py-1 border-0">
                                                                <input type="text"
                                                                    class="form-control form-control-sm m-0 p-0 item_element"
                                                                    id="medicine_item" name="medicine_item_master[]"
                                                                    placeholder="Generic / Brand">
                                                                <input type="hidden" id="hdn_medicine_item_id"
                                                                    name="hdn_medicine_item_id_master[]">
                                                                <input type="hidden" id="hdn_report_serial_med"
                                                                    name="hdn_report_serial_med_master[]"
                                                                    value="1">
                                                            </td>

                                                            <td class="py-1 px-1 border-0">
                                                                <select
                                                                    class="form-control form-control-sm select2 m-0 p-0 medicine_route"
                                                                    id="medicine_route" name="medicine_route_master[]"
                                                                    onchange="prescriptionFunc.addMoreDropdownOption(this,'.medicine_route');">
                                                                    <option value="0">Select</option>
                                                                    @foreach ($route as $key => $dmu)
                                                                        <option value="{{ $key }}">
                                                                            {{ $dmu['data'] }}</option>
                                                                    @endforeach
                                                                    <option data-qnty="0"
                                                                        data-dropdown_option="add_more"
                                                                        data-popup_header="Medicine Route"
                                                                        data-input_label="Route"
                                                                        data-input_placeholder="Enter medicine route (i.e., Oral, Ocular)"
                                                                        value="0">Add More</option>
                                                                </select>
                                                            </td>

                                                            <td class="py-1 px-1 border-0">
                                                                <select
                                                                    class="form-control select2 m-0 p-0 medicine_dose"
                                                                    id="medicine_dose" name="medicine_dose_master[]"
                                                                    onchange="prescriptionFunc.addMoreDropdownOption(this,'.medicine_dose');prescriptionFunc.calculateMedicineQnty(this)">
                                                                    <option value="0">Select</option>
                                                                    @foreach ($dose as $key => $dmu)
                                                                        <option data-qnty=""
                                                                            value="{{ $key }}">
                                                                            {{ $dmu['data'] }}</option>
                                                                    @endforeach
                                                                    <option data-qnty="0"
                                                                        data-dropdown_option="add_more"
                                                                        data-popup_header="Medicine Dose"
                                                                        data-input_label="Dose"
                                                                        data-input_placeholder="Enter medicine doses (i.e., 0+0+0, 0tsf+0tsf+0tsf)"
                                                                        value="0">Add More</option>
                                                                </select>
                                                            </td>

                                                            <td class="py-1 px-1 border-0">
                                                                <div class="input-group">
                                                                    <input type="number" step="0.01"
                                                                        class="form-control form-control-sm m-0 p-0 medicine_duration negative-ignore"
                                                                        id="medicine_duration_type"
                                                                        name="medicine_duration_type_master[]"
                                                                        onkeyup="prescriptionFunc.calculateMedicineQnty(this)">
                                                                    <select class="form-control medicine_duration_mu"
                                                                        id="medicine_duration_mu"
                                                                        name="medicine_duration_mu_master[]"
                                                                        onchange="prescriptionFunc.calculateMedicineQnty(this)">
                                                                        <option value="0">Select</option>
                                                                        @foreach ($meddurmu as $key => $dmu)
                                                                            <option value="{{ strtoupper($key) }}"
                                                                                {{ strtoupper($key) == 'DAY' ? 'selected' : '' }}>
                                                                                {{ $dmu['data'] }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </td>

                                                            <td class="py-1 px-1 border-0">
                                                                <input type="number" step="0.01"
                                                                    class="form-control form-control-sm m-0 p-0 medicine_quantity negative-ignore"
                                                                    id="medicine_quantity"
                                                                    name="medicine_quantity_master[]">
                                                            </td>

                                                            <td class="py-1 px-1 border-0">

                                                                <select
                                                                    class="form-control form-control-sm select2 m-0 p-0 instruction"
                                                                    id="instruction" name="instruction_master[]"
                                                                    onchange="prescriptionFunc.addMoreDropdownOption(this,'.instruction');">
                                                                    <option value="0">Select</option>
                                                                    @foreach ($instructions as $key => $dmu)
                                                                        <option value="{{ $key }}">
                                                                            {{ $dmu['data'] }}
                                                                        </option>
                                                                    @endforeach
                                                                    <option data-qnty="0"
                                                                        data-dropdown_option="add_more"
                                                                        data-popup_header="Medicine Dose"
                                                                        data-input_label="Instruction"
                                                                        data-input_placeholder="Enter New Instruction"
                                                                        value="0">Add More</option>

                                                                </select>

                                                            </td>

                                                            <td class="py-1 px-1 border-0 text-center"
                                                                id="med_td_action">
                                                                <span class="btn btn-success btn-md"
                                                                    onclick="addMedicineItem()"><i
                                                                        class="fa fa-plus"></i>
                                                                </span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th colspan="8" class="py-2"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                        @forelse ($medicine_info as $keys => $item)
                                                            <tr class="border-0" id="tbl{{ $keys }}">
                                                                <td class="py-1 border-0">
                                                                    <input type="text"
                                                                        class="form-control form-control-sm m-0 p-0 item_element"
                                                                        id="medicine_item_{{ $keys }}"
                                                                        name="medicine_item[]"
                                                                        placeholder="Generic / Brand"
                                                                        value="{{ $item->brand_name }}">
                                                                    <input type="hidden"
                                                                        id="hdn_medicine_item_id_{{ $keys }}"
                                                                        name="hdn_medicine_item_id[]"
                                                                        value="{{ $item->item_no_fk }}">
                                                                    <input type="hidden"
                                                                        id="hdn_report_serial_med_{{ $keys }}"
                                                                        name="hdn_report_serial_med[]"
                                                                        value="{{ $keys }}">
                                                                </td>
                                                                <td class="py-1 px-1 border-0">
                                                                    <select
                                                                        class="form-control form-control-sm select2 m-0 p-0 medicine_route"
                                                                        id="medicine_route_{{ $keys }}"
                                                                        name="medicine_route[]"
                                                                        onchange="prescriptionFunc.addMoreDropdownOption(this,'.medicine_route');">
                                                                        <option value="0">Select</option>
                                                                        @foreach ($route as $key => $dmu)
                                                                            <option value="{{ $key }}"
                                                                                {{ $item->route == $key ? 'selected' : '' }}>
                                                                                {{ $dmu['data'] }}</option>
                                                                        @endforeach
                                                                        <option data-qnty="0"
                                                                            data-dropdown_option="add_more"
                                                                            data-popup_header="Medicine Route"
                                                                            data-input_label="Route"
                                                                            data-input_placeholder="Enter medicine route (i.e., Oral, Ocular)"
                                                                            value="0">Add More</option>
                                                                    </select>
                                                                </td>

                                                                <td class="py-1 px-1 border-0">
                                                                    <select
                                                                        class="form-control select2 m-0 p-0 medicine_dose"
                                                                        id="medicine_dose_{{ $keys }}"
                                                                        name="medicine_dose[]"
                                                                        onchange="prescriptionFunc.addMoreDropdownOption(this,'.medicine_dose');prescriptionFunc.calculateMedicineQnty(this)">
                                                                        <option value="0">Select</option>
                                                                        @foreach ($dose as $key => $dmu)
                                                                            <option data-qnty=""
                                                                                value="{{ $key }}"
                                                                                {{ $item->dosage == $key ? 'selected' : '' }}>
                                                                                {{ $dmu['data'] }}</option>
                                                                        @endforeach
                                                                        <option data-qnty="0"
                                                                            data-dropdown_option="add_more"
                                                                            data-popup_header="Medicine Dose"
                                                                            data-input_label="Dose"
                                                                            data-input_placeholder="Enter medicine doses (i.e., 0+0+0, 0tsf+0tsf+0tsf)"
                                                                            value="0">Add More</option>
                                                                    </select>
                                                                </td>

                                                                <td class="py-1 px-1 border-0">
                                                                    <div class="input-group">
                                                                        <input type="number" step="0.01"
                                                                            class="form-control form-control-sm m-0 p-0 medicine_duration number_only"
                                                                            id="medicine_duration_type_{{ $keys }}"
                                                                            name="medicine_duration_type[]"
                                                                            onkeyup="prescriptionFunc.calculateMedicineQnty(this)"
                                                                            value="{{ $item->duration }}">
                                                                        <select
                                                                            class="form-control medicine_duration_mu"
                                                                            id="medicine_duration_mu_{{ $keys }}"
                                                                            name="medicine_duration_mu[]"
                                                                            onchange="prescriptionFunc.calculateMedicineQnty(this)">
                                                                            <option value="0">Select</option>
                                                                            @foreach ($meddurmu as $key => $dmu)
                                                                                <option
                                                                                    value="{{ strtoupper($key) }}"
                                                                                    {{ $item->duration_mu == strtoupper($key) ? 'selected' : '' }}>
                                                                                    {{ $dmu['data'] }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </td>

                                                                <td class="py-1 px-1 border-0">
                                                                    <input type="number" step="0.01"
                                                                        class="form-control form-control-sm m-0 p-0 medicine_quantity"
                                                                        id="medicine_quantity_{{ $keys }}"
                                                                        name="medicine_quantity[]"
                                                                        value="{{ $item->item_qty }}">
                                                                </td>

                                                                <td class="py-1 px-1 border-0">

                                                                    <select
                                                                        class="form-control form-control-sm select2 m-0 p-0 instruction"
                                                                        id="instruction_{{ $keys }}"
                                                                        name="instruction[]"
                                                                        onchange="prescriptionFunc.addMoreDropdownOption(this,'.instruction');">
                                                                        <option value="0">Select</option>
                                                                        @foreach ($instructions as $key => $dmu)
                                                                            <option value="{{ $key }}"
                                                                                {{ $item->instruction_take == $key ? 'selected' : '' }}>
                                                                                {{ $dmu['data'] }}</option>
                                                                        @endforeach
                                                                        <option data-qnty="0"
                                                                            data-dropdown_option="add_more"
                                                                            data-popup_header="Medicine Dose"
                                                                            data-input_label="Instruction"
                                                                            data-input_placeholder="Enter New Instruction"
                                                                            value="0">Add More</option>
                                                                    </select>
                                                                </td>

                                                                <td class="py-1 px-1 border-0 text-center"
                                                                    id="med_td_action_{{ $keys }}">
                                                                    <span class="remove_row"
                                                                        onclick="removeRow('tbl{{ $keys }}')"><i
                                                                            class="fas fa-trash"
                                                                            style="color:red"></i></span>
                                                                </td>
                                                            </tr>
                                                        @empty
                                                            <tr class="emptyCart">
                                                                <td colspan="7" class="text-danger text-center">
                                                                    Your
                                                                    Cart is Empty</td>
                                                            </tr>
                                                        @endforelse

                                                    </tbody>
                                                </table>
                                            </div>

                                            @php
                                                $poct = array_map(
                                                    'strval',
                                                    json_decode($adult_emergency_dept->poct ?? '[]', true) ?? [],
                                                );
                                                $lab_test = array_map(
                                                    'strval',
                                                    json_decode($adult_emergency_dept->lab_test ?? '[]', true) ?? [],
                                                );
                                            @endphp

                                            <table width="100%" border="1" style="margin-top:10px">
                                                <tr>
                                                    <td colspan="5"><b>ED Narrative:</b></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="5">
                                                        <textarea name="ed_narrative" class="form-control" rows="10">{{ @$adult_emergency_dept->ed_narrative }}</textarea>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Name </th>
                                                    <th>Signature</th>
                                                    <th>Designation</th>
                                                    <th>Emp. ID</th>
                                                    <th>Time</th>
                                                </tr>
                                                <tr>
                                                    <td><input type="text" name="narr_name" id="narr_name"
                                                            class="form-control"
                                                            value="{{ @$adult_emergency_dept->narr_name }}">
                                                        <input type="hidden" name="hnarr_epmid" id="hnarr_epmid"
                                                            class="form-control">
                                                    </td>
                                                    <td><input type="text" name="narr_sign" class="form-control"
                                                            value="{{ @$adult_emergency_dept->narr_sign }}"></td>
                                                    <td><input type="text" name="narr_design" class="form-control"
                                                            value="{{ @$adult_emergency_dept->narr_design }}"></td>
                                                    <td><input type="text" name="narr_epmid" class="form-control"
                                                            value="{{ @$adult_emergency_dept->narr_epmid }}"></td>
                                                    <td><input type="text" name="narr_time" class="form-control"
                                                            value="{{ @$adult_emergency_dept->narr_time }}"></td>
                                                </tr>

                                                <tr>
                                                    <td>Has this patient been handed over?</td>
                                                    <td>
                                                        <select name="pt_handed" class="form-control">
                                                            <option value="">Select</option>
                                                            <option value="Yes"
                                                                {{ @$adult_emergency_dept->pt_handed === 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option value="No"
                                                                {{ @$adult_emergency_dept->pt_handed === 'No' ? 'selected' : '' }}>
                                                                No</option>
                                                        </select>
                                                    </td>
                                                    <td>If yes, to whom?</td>
                                                    <td colspan="2"><input type="text" name="pt_yes"
                                                            class="form-control"
                                                            value="{{ @$adult_emergency_dept->pt_yes }}"></td>
                                                </tr>

                                                <tr>
                                                    <td colspan="5"><b>ED Specialist Note:</b></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="5">
                                                        <textarea name="ed_note" class="form-control" rows="3">{{ @$adult_emergency_dept->ed_note }}</textarea>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Name </th>
                                                    <th>Signature</th>
                                                    <th>Designation</th>
                                                    <th>Emp. ID</th>
                                                    <th>Time</th>
                                                </tr>
                                                <tr>
                                                    <td><input type="text" name="eds_name" id="eds_name"
                                                            class="form-control"
                                                            value="{{ @$adult_emergency_dept->eds_name }}"><input
                                                            type="hidden" name="heds_epmid" id="heds_epmid"
                                                            class="form-control"></td>
                                                    <td><input type="text" name="eds_sign" class="form-control"
                                                            value="{{ @$adult_emergency_dept->eds_sign }}"></td>
                                                    <td><input type="text" name="eds_design" class="form-control"
                                                            value="{{ @$adult_emergency_dept->eds_design }}"></td>
                                                    <td><input type="text" name="eds_epmid" id="eds_epmid"
                                                            class="form-control"
                                                            value="{{ @$adult_emergency_dept->eds_epmid }}"></td>
                                                    <td><input type="text" name="eds_time" class="form-control"
                                                            value="{{ @$adult_emergency_dept->eds_time }}"></td>
                                                </tr>

                                                <tr>
                                                    <td colspan="5" style="text-align: center"><b>Body Map</b>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="5">
                                                        <textarea name="body_map" class="form-control" rows="10">{{ @$adult_emergency_dept->body_map }}</textarea>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="5"><b>Consultation 1:</b></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="5">
                                                        <textarea name="consult1" class="form-control" rows="10" placeholder="Specialty opinion:">{{ @$adult_emergency_dept->consult1 }}</textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Name </th>
                                                    <th>Signature</th>
                                                    <th>Designation</th>
                                                    <th>Emp. ID</th>
                                                    <th>Time</th>
                                                </tr>
                                                <tr>
                                                    <td><input type="text" name="consult1_name" id="consult1_name"
                                                            class="form-control"
                                                            value="{{ @$adult_emergency_dept->consult1_name }}">
                                                        <input type="hidden" name="hconsult1_epmid"
                                                            id="hconsult1_epmid" class="form-control">
                                                    </td>
                                                    <td><input type="text" name="consult1_sign"
                                                            class="form-control"
                                                            value="{{ @$adult_emergency_dept->consult1_sign }}"></td>
                                                    <td><input type="text" name="consult1_design"
                                                            class="form-control"
                                                            value="{{ @$adult_emergency_dept->consult1_design }}">
                                                    </td>
                                                    <td> <input type="text" name="consult1_epmid"
                                                            id="consult1_epmid" class="form-control"
                                                            value="{{ @$adult_emergency_dept->consult1_epmid }}">
                                                    </td>
                                                    <td><input type="text" name="consult1_time"
                                                            class="form-control"
                                                            value="{{ @$adult_emergency_dept->consult1_time }}"></td>
                                                </tr>

                                                <tr>
                                                    <td colspan="5"><b>Consultation 2:</b></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="5">
                                                        <textarea name="consult2" class="form-control" rows="10" placeholder="Specialty opinion:">{{ @$adult_emergency_dept->consult2 }}</textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Name </th>
                                                    <th>Signature</th>
                                                    <th>Designation</th>
                                                    <th>Emp. ID</th>
                                                    <th>Time</th>
                                                </tr>
                                                <tr>
                                                    <td><input type="text" name="consult2_name" id="consult2_name"
                                                            class="form-control"
                                                            value="{{ @$adult_emergency_dept->consult2_name }}">
                                                        <input type="hidden" name="hconsult2_epmid"
                                                            id="hconsult2_epmid" class="form-control">
                                                    </td>
                                                    <td><input type="text" name="consult2_sign"
                                                            class="form-control"
                                                            value="{{ @$adult_emergency_dept->consult2_sign }}"></td>
                                                    <td><input type="text" name="consult2_design"
                                                            class="form-control"
                                                            value="{{ @$adult_emergency_dept->consult2_design }}">
                                                    </td>
                                                    <td><input type="text" name="consult2_epmid"
                                                            id="consult2_epmid" class="form-control"
                                                            value="{{ @$adult_emergency_dept->consult2_epmid }}">
                                                    </td>
                                                    <td><input type="text" name="consult2_time"
                                                            class="form-control"
                                                            value="{{ @$adult_emergency_dept->consult2_time }}"></td>
                                                </tr>
                                            </table>


                                            <table width="100%" border="1" style="margin-top:10px">
                                                <thead>
                                                    <tr>
                                                        <td colspan="6" style="text-align: center">
                                                            <h4>Investigations ordered in ED</h4>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="6" style="text-align: center"><b>POINT OF CARE
                                                                TESTS</b></th>
                                                    </tr>
                                                    <tr>
                                                        <th>Tick</th>
                                                        <th>Doctor’s order</th>
                                                        <th>Sent</th>
                                                        <th>Due</th>
                                                        <th>Nurse’s Sign</th>
                                                        <th>Nurse’s ID</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    {{-- 1 --}}
                                                    <tr>
                                                        <td><input type="checkbox" value="1" name="poct[]"
                                                                {{ in_array('1', $poct) ? 'checked' : '' }}></td>
                                                        <td>Blood gas analysis</td>
                                                        <td><input type="text" name="poct_ba_s"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->poct_ba_s }}"></td>
                                                        <td><input type="text" name="poct_ba_d"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->poct_ba_d }}"></td>
                                                        <td><input type="text" name="poct_ba_sn"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->poct_ba_sn }}">
                                                        </td>
                                                        <td><input type="text" name="poct_ba_id"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->poct_ba_id }}">
                                                        </td>
                                                    </tr>
                                                    {{-- 2 --}}
                                                    <tr>
                                                        <td><input type="checkbox" value="2" name="poct[]"
                                                                {{ in_array('2', $poct) ? 'checked' : '' }}></td>
                                                        <td>Blood glucose</td>
                                                        <td><input type="text" name="poct_bg_s"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->poct_bg_s }}"></td>
                                                        <td><input type="text" name="poct_bg_d"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->poct_bg_d }}"></td>
                                                        <td><input type="text" name="poct_bg_sn"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->poct_bg_sn }}">
                                                        </td>
                                                        <td><input type="text" name="poct_bg_id"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->poct_bg_id }}">
                                                        </td>
                                                    </tr>
                                                    {{-- 3 --}}
                                                    <tr>
                                                        <td><input type="checkbox" value="3" name="poct[]"
                                                                {{ in_array('3', $poct) ? 'checked' : '' }}></td>
                                                        <td>Chem 8</td>
                                                        <td><input type="text" name="poct_chem_s"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->poct_chem_s }}">
                                                        </td>
                                                        <td><input type="text" name="poct_chem_d"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->poct_chem_d }}">
                                                        </td>
                                                        <td><input type="text" name="poct_chem_sn"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->poct_chem_sn }}">
                                                        </td>
                                                        <td><input type="text" name="poct_chem_id"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->poct_chem_id }}">
                                                        </td>
                                                    </tr>
                                                    {{-- 4 --}}
                                                    <tr>
                                                        <td><input type="checkbox" value="4" name="poct[]"
                                                                {{ in_array('4', $poct) ? 'checked' : '' }}></td>
                                                        <td>ECG</td>
                                                        <td><input type="text" name="poct_ecg_s"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->poct_ecg_s }}">
                                                        </td>
                                                        <td><input type="text" name="poct_ecg_d"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->poct_ecg_d }}">
                                                        </td>
                                                        <td><input type="text" name="poct_ecg_sn"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->poct_ecg_sn }}">
                                                        </td>
                                                        <td><input type="text" name="poct_ecg_id"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->poct_ecg_id }}">
                                                        </td>
                                                    </tr>
                                                    {{-- 5 --}}
                                                    <tr>
                                                        <td><input type="checkbox" value="5" name="poct[]"
                                                                {{ in_array('5', $poct) ? 'checked' : '' }}></td>
                                                        <td>NT-proBNP</td>
                                                        <td><input type="text" name="poct_nt_s"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->poct_nt_s }}">
                                                        </td>
                                                        <td><input type="text" name="poct_nt_d"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->poct_nt_d }}">
                                                        </td>
                                                        <td><input type="text" name="poct_nt_sn"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->poct_nt_sn }}">
                                                        </td>
                                                        <td><input type="text" name="poct_nt_id"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->poct_nt_id }}">
                                                        </td>
                                                    </tr>
                                                    {{-- 6 --}}
                                                    <tr>
                                                        <td><input type="checkbox" value="6" name="poct[]"
                                                                {{ in_array('6', $poct) ? 'checked' : '' }}></td>
                                                        <td>POCUS</td>
                                                        <td><input type="text" name="poct_ps_s"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->poct_ps_s }}">
                                                        </td>
                                                        <td><input type="text" name="poct_ps_d"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->poct_ps_d }}">
                                                        </td>
                                                        <td><input type="text" name="poct_ps_sn"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->poct_ps_sn }}">
                                                        </td>
                                                        <td><input type="text" name="poct_ps_id"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->poct_ps_id }}">
                                                        </td>
                                                    </tr>
                                                    {{-- 7 --}}
                                                    <tr>
                                                        <td><input type="checkbox" value="7" name="poct[]"
                                                                {{ in_array('7', $poct) ? 'checked' : '' }}></td>
                                                        <td>PT-INR</td>
                                                        <td><input type="text" name="poct_pr_s"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->poct_pr_s }}">
                                                        </td>
                                                        <td><input type="text" name="poct_pr_d"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->poct_pr_d }}">
                                                        </td>
                                                        <td><input type="text" name="poct_pr_sn"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->poct_pr_sn }}">
                                                        </td>
                                                        <td><input type="text" name="poct_pr_id"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->poct_pr_id }}">
                                                        </td>
                                                    </tr>
                                                    {{-- 8 --}}
                                                    <tr>
                                                        <td><input type="checkbox" value="8" name="poct[]"
                                                                {{ in_array('8', $poct) ? 'checked' : '' }}></td>
                                                        <td>Troponin</td>
                                                        <td><input type="text" name="poct_tn_s"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->poct_tn_s }}">
                                                        </td>
                                                        <td><input type="text" name="poct_tn_d"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->poct_tn_d }}">
                                                        </td>
                                                        <td><input type="text" name="poct_tn_sn"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->poct_tn_sn }}">
                                                        </td>
                                                        <td><input type="text" name="poct_tn_id"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->poct_tn_id }}">
                                                        </td>
                                                    </tr>
                                                    {{-- 9 --}}
                                                    <tr>
                                                        <td><input type="checkbox" value="9" name="poct[]"
                                                                {{ in_array('9', $poct) ? 'checked' : '' }}></td>
                                                        <td>Urinary β-hCG</td>
                                                        <td><input type="text" name="poct_ubh_s"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->poct_ubh_s }}">
                                                        </td>
                                                        <td><input type="text" name="poct_ubh_d"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->poct_ubh_d }}">
                                                        </td>
                                                        <td><input type="text" name="poct_ubh_sn"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->poct_ubh_sn }}">
                                                        </td>
                                                        <td><input type="text" name="poct_ubh_id"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->poct_ubh_id }}">
                                                        </td>
                                                    </tr>
                                                    {{-- 10 --}}
                                                    <tr>
                                                        <td><input type="checkbox" value="10" name="poct[]"
                                                                {{ in_array('10', $poct) ? 'checked' : '' }}></td>
                                                        <td>Urine combo test</td>
                                                        <td><input type="text" name="poct_uct_s"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->poct_uct_s }}">
                                                        </td>
                                                        <td><input type="text" name="poct_uct_d"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->poct_uct_d }}">
                                                        </td>
                                                        <td><input type="text" name="poct_uct_sn"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->poct_uct_sn }}">
                                                        </td>
                                                        <td><input type="text" name="poct_uct_id"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->poct_uct_id }}">
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>


                                            <table width="100%" border="1" style="margin-top:10px">
                                                <thead>
                                                    <tr>
                                                        <th colspan="6" style="text-align: center"><b>LABORATORY
                                                                TESTS</b></th>
                                                    </tr>
                                                    <tr>
                                                        <th>Tick</th>
                                                        <th>Doctor’s order</th>
                                                        <th>Sent</th>
                                                        <th>Due</th>
                                                        <th>Nurse’s Sign</th>
                                                        <th>Nurse’s ID</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    {{-- 1 Alk. Phosphatase --}}
                                                    <tr>
                                                        <td><input type="checkbox" value="1"
                                                                name="lab_test[]"
                                                                {{ in_array('1', $lab_test) ? 'checked' : '' }}></td>
                                                        <td>Alk. Phosphatase</td>
                                                        <td><input type="text" name="lab_ap_s"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_ap_s }}"></td>
                                                        <td><input type="text" name="lab_ap_d"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_ap_d }}"></td>
                                                        <td><input type="text" name="lab_ap_sn"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_ap_sn }}">
                                                        </td>
                                                        <td><input type="text" name="lab_ap_id"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_ap_id }}">
                                                        </td>
                                                    </tr>

                                                    {{-- 2 Amylase --}}
                                                    <tr>
                                                        <td><input type="checkbox" value="2"
                                                                name="lab_test[]"
                                                                {{ in_array('2', $lab_test) ? 'checked' : '' }}></td>
                                                        <td>Amylase</td>
                                                        <td><input type="text" name="lab_am_s"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_am_s }}"></td>
                                                        <td><input type="text" name="lab_am_d"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_am_d }}"></td>
                                                        <td><input type="text" name="lab_am_sn"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_am_sn }}">
                                                        </td>
                                                        <td><input type="text" name="lab_am_id"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_am_id }}">
                                                        </td>
                                                    </tr>

                                                    {{-- 3 Blood grouping --}}
                                                    <tr>
                                                        <td><input type="checkbox" value="3"
                                                                name="lab_test[]"
                                                                {{ in_array('3', $lab_test) ? 'checked' : '' }}></td>
                                                        <td>Blood grouping</td>
                                                        <td><input type="text" name="lab_bdg_s"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_bdg_s }}">
                                                        </td>
                                                        <td><input type="text" name="lab_bdg_d"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_bdg_d }}">
                                                        </td>
                                                        <td><input type="text" name="lab_bdg_sn"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_bdg_sn }}">
                                                        </td>
                                                        <td><input type="text" name="lab_bdg_id"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_bdg_id }}">
                                                        </td>
                                                    </tr>

                                                    {{-- 4 Bilirubin --}}
                                                    <tr>
                                                        <td><input type="checkbox" value="4"
                                                                name="lab_test[]"
                                                                {{ in_array('4', $lab_test) ? 'checked' : '' }}></td>
                                                        <td>Bilirubin</td>
                                                        <td><input type="text" name="lab_bn_s"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_bn_s }}"></td>
                                                        <td><input type="text" name="lab_bn_d"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_bn_d }}"></td>
                                                        <td><input type="text" name="lab_bn_sn"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_bn_sn }}">
                                                        </td>
                                                        <td><input type="text" name="lab_bn_id"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_bn_id }}">
                                                        </td>
                                                    </tr>

                                                    {{-- 5 β-hCG --}}
                                                    <tr>
                                                        <td><input type="checkbox" value="5"
                                                                name="lab_test[]"
                                                                {{ in_array('5', $lab_test) ? 'checked' : '' }}></td>
                                                        <td>β-hCG</td>
                                                        <td><input type="text" name="lab_bg_s"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_bg_s }}"></td>
                                                        <td><input type="text" name="lab_bg_d"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_bg_d }}"></td>
                                                        <td><input type="text" name="lab_bg_sn"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_bg_sn }}">
                                                        </td>
                                                        <td><input type="text" name="lab_bg_id"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_bg_id }}">
                                                        </td>
                                                    </tr>

                                                    {{-- 6 CBC --}}
                                                    <tr>
                                                        <td><input type="checkbox" value="6"
                                                                name="lab_test[]"
                                                                {{ in_array('6', $lab_test) ? 'checked' : '' }}></td>
                                                        <td>CBC</td>
                                                        <td><input type="text" name="lab_cbc_s"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_cbc_s }}">
                                                        </td>
                                                        <td><input type="text" name="lab_cbc_d"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_cbc_d }}">
                                                        </td>
                                                        <td><input type="text" name="lab_cbc_sn"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_cbc_sn }}">
                                                        </td>
                                                        <td><input type="text" name="lab_cbc_id"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_cbc_id }}">
                                                        </td>
                                                    </tr>

                                                    {{-- 7 Calcium --}}
                                                    <tr>
                                                        <td><input type="checkbox" value="7"
                                                                name="lab_test[]"
                                                                {{ in_array('7', $lab_test) ? 'checked' : '' }}></td>
                                                        <td>Calcium</td>
                                                        <td><input type="text" name="lab_cm_s"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_cm_s }}"></td>
                                                        <td><input type="text" name="lab_cm_d"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_cm_d }}"></td>
                                                        <td><input type="text" name="lab_cm_sn"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_cm_sn }}">
                                                        </td>
                                                        <td><input type="text" name="lab_cm_id"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_cm_id }}">
                                                        </td>
                                                    </tr>

                                                    {{-- 8 Creatine kinase --}}
                                                    <tr>
                                                        <td><input type="checkbox" value="8"
                                                                name="lab_test[]"
                                                                {{ in_array('8', $lab_test) ? 'checked' : '' }}></td>
                                                        <td>Creatine kinase</td>
                                                        <td><input type="text" name="lab_ck_s"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_ck_s }}"></td>
                                                        <td><input type="text" name="lab_ck_d"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_ck_d }}"></td>
                                                        <td><input type="text" name="lab_ck_sn"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_ck_sn }}">
                                                        </td>
                                                        <td><input type="text" name="lab_ck_id"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_ck_id }}">
                                                        </td>
                                                    </tr>

                                                    {{-- 9 CRP --}}
                                                    <tr>
                                                        <td><input type="checkbox" value="9"
                                                                name="lab_test[]"
                                                                {{ in_array('9', $lab_test) ? 'checked' : '' }}></td>
                                                        <td>CRP</td>
                                                        <td><input type="text" name="lab_cp_s"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_cp_s }}"></td>
                                                        <td><input type="text" name="lab_cp_d"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_cp_d }}"></td>
                                                        <td><input type="text" name="lab_cp_sn"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_cp_sn }}">
                                                        </td>
                                                        <td><input type="text" name="lab_cp_id"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_cp_id }}">
                                                        </td>
                                                    </tr>

                                                    {{-- 10 d-Dimer --}}
                                                    <tr>
                                                        <td><input type="checkbox" value="10"
                                                                name="lab_test[]"
                                                                {{ in_array('10', $lab_test) ? 'checked' : '' }}></td>
                                                        <td>d-Dimer</td>
                                                        <td><input type="text" name="lab_dd_s"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_dd_s }}"></td>
                                                        <td><input type="text" name="lab_dd_d"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_dd_d }}"></td>
                                                        <td><input type="text" name="lab_dd_sn"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_dd_sn }}">
                                                        </td>
                                                        <td><input type="text" name="lab_dd_id"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_dd_id }}">
                                                        </td>
                                                    </tr>

                                                    {{-- 11 Dengue NS1 --}}
                                                    <tr>
                                                        <td><input type="checkbox" value="11"
                                                                name="lab_test[]"
                                                                {{ in_array('11', $lab_test) ? 'checked' : '' }}></td>
                                                        <td>Dengue NS1</td>
                                                        <td><input type="text" name="lab_dn_s"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_dn_s }}"></td>
                                                        <td><input type="text" name="lab_dn_d"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_dn_d }}"></td>
                                                        <td><input type="text" name="lab_dn_sn"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_dn_sn }}">
                                                        </td>
                                                        <td><input type="text" name="lab_dn_id"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_dn_id }}">
                                                        </td>
                                                    </tr>

                                                    {{-- 12 Electrolytes --}}
                                                    <tr>
                                                        <td><input type="checkbox" value="12"
                                                                name="lab_test[]"
                                                                {{ in_array('12', $lab_test) ? 'checked' : '' }}></td>
                                                        <td>Electrolytes</td>
                                                        <td><input type="text" name="lab_el_s"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_el_s }}"></td>
                                                        <td><input type="text" name="lab_el_d"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_el_d }}"></td>
                                                        <td><input type="text" name="lab_el_sn"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_el_sn }}">
                                                        </td>
                                                        <td><input type="text" name="lab_el_id"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_el_id }}">
                                                        </td>
                                                    </tr>

                                                    {{-- 13 Ferritin --}}
                                                    <tr>
                                                        <td><input type="checkbox" value="13"
                                                                name="lab_test[]"
                                                                {{ in_array('13', $lab_test) ? 'checked' : '' }}></td>
                                                        <td>Ferritin</td>
                                                        <td><input type="text" name="lab_fn_s"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_fn_s }}"></td>
                                                        <td><input type="text" name="lab_fn_d"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_fn_d }}"></td>
                                                        <td><input type="text" name="lab_fn_sn"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_fn_sn }}">
                                                        </td>
                                                        <td><input type="text" name="lab_fn_id"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_fn_id }}">
                                                        </td>
                                                    </tr>

                                                    {{-- 14 Hs Trop-I --}}
                                                    <tr>
                                                        <td><input type="checkbox" value="14"
                                                                name="lab_test[]"
                                                                {{ in_array('14', $lab_test) ? 'checked' : '' }}></td>
                                                        <td>Hs Trop-I</td>
                                                        <td><input type="text" name="lab_ht_s"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_ht_s }}"></td>
                                                        <td><input type="text" name="lab_ht_d"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_ht_d }}"></td>
                                                        <td><input type="text" name="lab_ht_sn"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_ht_sn }}">
                                                        </td>
                                                        <td><input type="text" name="lab_ht_id"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_ht_id }}">
                                                        </td>
                                                    </tr>

                                                    {{-- 15 LFT --}}
                                                    <tr>
                                                        <td><input type="checkbox" value="15"
                                                                name="lab_test[]"
                                                                {{ in_array('15', $lab_test) ? 'checked' : '' }}></td>
                                                        <td>LFT</td>
                                                        <td><input type="text" name="lab_lft_s"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_lft_s }}">
                                                        </td>
                                                        <td><input type="text" name="lab_lft_d"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_lft_d }}">
                                                        </td>
                                                        <td><input type="text" name="lab_lft_sn"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_lft_sn }}">
                                                        </td>
                                                        <td><input type="text" name="lab_lft_id"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_lft_id }}">
                                                        </td>
                                                    </tr>

                                                    {{-- 16 Lipase --}}
                                                    <tr>
                                                        <td><input type="checkbox" value="16"
                                                                name="lab_test[]"
                                                                {{ in_array('16', $lab_test) ? 'checked' : '' }}></td>
                                                        <td>Lipase</td>
                                                        <td><input type="text" name="lab_le_s"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_le_s }}"></td>
                                                        <td><input type="text" name="lab_le_d"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_le_d }}"></td>
                                                        <td><input type="text" name="lab_le_sn"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_le_sn }}">
                                                        </td>
                                                        <td><input type="text" name="lab_le_id"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_le_id }}">
                                                        </td>
                                                    </tr>

                                                    {{-- 17 Lipid profile --}}
                                                    <tr>
                                                        <td><input type="checkbox" value="17"
                                                                name="lab_test[]"
                                                                {{ in_array('17', $lab_test) ? 'checked' : '' }}></td>
                                                        <td>Lipid profile</td>
                                                        <td><input type="text" name="lab_lp_s"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_lp_s }}"></td>
                                                        <td><input type="text" name="lab_lp_d"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_lp_d }}"></td>
                                                        <td><input type="text" name="lab_lp_sn"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_lp_sn }}">
                                                        </td>
                                                        <td><input type="text" name="lab_lp_id"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_lp_id }}">
                                                        </td>
                                                    </tr>

                                                    {{-- 18 Procalcitonin --}}
                                                    <tr>
                                                        <td><input type="checkbox" value="18"
                                                                name="lab_test[]"
                                                                {{ in_array('18', $lab_test) ? 'checked' : '' }}></td>
                                                        <td>Procalcitonin</td>
                                                        <td><input type="text" name="lab_pn_s"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_pn_s }}"></td>
                                                        <td><input type="text" name="lab_pn_d"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_pn_d }}"></td>
                                                        <td><input type="text" name="lab_pn_sn"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_pn_sn }}">
                                                        </td>
                                                        <td><input type="text" name="lab_pn_id"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_pn_id }}">
                                                        </td>
                                                    </tr>

                                                    {{-- 19 RFT --}}
                                                    <tr>
                                                        <td><input type="checkbox" value="19"
                                                                name="lab_test[]"
                                                                {{ in_array('19', $lab_test) ? 'checked' : '' }}></td>
                                                        <td>RFT</td>
                                                        <td><input type="text" name="lab_rft_s"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_rft_s }}">
                                                        </td>
                                                        <td><input type="text" name="lab_rft_d"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_rft_d }}">
                                                        </td>
                                                        <td><input type="text" name="lab_rft_sn"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_rft_sn }}">
                                                        </td>
                                                        <td><input type="text" name="lab_rft_id"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_rft_id }}">
                                                        </td>
                                                    </tr>

                                                    {{-- 20 SGPT --}}
                                                    <tr>
                                                        <td><input type="checkbox" value="20"
                                                                name="lab_test[]"
                                                                {{ in_array('20', $lab_test) ? 'checked' : '' }}></td>
                                                        <td>SGPT</td>
                                                        <td><input type="text" name="lab_sp_s"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_sp_s }}"></td>
                                                        <td><input type="text" name="lab_sp_d"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_sp_d }}"></td>
                                                        <td><input type="text" name="lab_sp_sn"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_sp_sn }}">
                                                        </td>
                                                        <td><input type="text" name="lab_sp_id"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_sp_id }}">
                                                        </td>
                                                    </tr>

                                                    {{-- 21 SGOT --}}
                                                    <tr>
                                                        <td><input type="checkbox" value="21"
                                                                name="lab_test[]"
                                                                {{ in_array('21', $lab_test) ? 'checked' : '' }}></td>
                                                        <td>SGOT</td>
                                                        <td><input type="text" name="lab_so_s"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_so_s }}"></td>
                                                        <td><input type="text" name="lab_so_d"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_so_d }}"></td>
                                                        <td><input type="text" name="lab_so_sn"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_so_sn }}">
                                                        </td>
                                                        <td><input type="text" name="lab_so_id"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_so_id }}">
                                                        </td>
                                                    </tr>

                                                    {{-- 22 S. Creatinine eGFR --}}
                                                    <tr>
                                                        <td><input type="checkbox" value="22"
                                                                name="lab_test[]"
                                                                {{ in_array('22', $lab_test) ? 'checked' : '' }}></td>
                                                        <td>S. Creatinine eGFR</td>
                                                        <td><input type="text" name="lab_sc_s"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_sc_s }}"></td>
                                                        <td><input type="text" name="lab_sc_d"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_sc_d }}"></td>
                                                        <td><input type="text" name="lab_sc_sn"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_sc_sn }}">
                                                        </td>
                                                        <td><input type="text" name="lab_sc_id"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_sc_id }}">
                                                        </td>
                                                    </tr>

                                                    {{-- 23 TSH --}}
                                                    <tr>
                                                        <td><input type="checkbox" value="23"
                                                                name="lab_test[]"
                                                                {{ in_array('23', $lab_test) ? 'checked' : '' }}></td>
                                                        <td>TSH</td>
                                                        <td><input type="text" name="lab_tsh_s"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_tsh_s }}">
                                                        </td>
                                                        <td><input type="text" name="lab_tsh_d"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_tsh_d }}">
                                                        </td>
                                                        <td><input type="text" name="lab_tsh_sn"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_tsh_sn }}">
                                                        </td>
                                                        <td><input type="text" name="lab_tsh_id"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_tsh_id }}">
                                                        </td>
                                                    </tr>

                                                    {{-- 24 Urea --}}
                                                    <tr>
                                                        <td><input type="checkbox" value="24"
                                                                name="lab_test[]"
                                                                {{ in_array('24', $lab_test) ? 'checked' : '' }}></td>
                                                        <td>Urea</td>
                                                        <td><input type="text" name="lab_ur_s"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_ur_s }}"></td>
                                                        <td><input type="text" name="lab_ur_d"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_ur_d }}"></td>
                                                        <td><input type="text" name="lab_ur_sn"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_ur_sn }}">
                                                        </td>
                                                        <td><input type="text" name="lab_ur_id"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_ur_id }}">
                                                        </td>
                                                    </tr>

                                                    {{-- 25 Viral markers --}}
                                                    <tr>
                                                        <td><input type="checkbox" value="25"
                                                                name="lab_test[]"
                                                                {{ in_array('25', $lab_test) ? 'checked' : '' }}></td>
                                                        <td>Viral markers</td>
                                                        <td><input type="text" name="lab_vm_s"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_vm_s }}"></td>
                                                        <td><input type="text" name="lab_vm_d"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_vm_d }}"></td>
                                                        <td><input type="text" name="lab_vm_sn"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_vm_sn }}">
                                                        </td>
                                                        <td><input type="text" name="lab_vm_id"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_vm_id }}">
                                                        </td>
                                                    </tr>

                                                    {{-- 26 Others --}}
                                                    <tr>
                                                        <td><input type="checkbox" value="26"
                                                                name="lab_test[]"
                                                                {{ in_array('26', $lab_test) ? 'checked' : '' }}></td>
                                                        <td>Others</td>
                                                        <td><input type="text" name="lab_ot_s"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_ot_s }}"></td>
                                                        <td><input type="text" name="lab_ot_d"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_ot_d }}"></td>
                                                        <td><input type="text" name="lab_ot_sn"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_ot_sn }}">
                                                        </td>
                                                        <td><input type="text" name="lab_ot_id"
                                                                class="form-control"
                                                                value="{{ @$adult_emergency_dept->lab_ot_id }}">
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            @php
                                                $img = json_decode($adult_emergency_dept->img ?? '[]', true) ?? [];
                                            @endphp

                                            <table width="100%" border="1" style="margin-top:10px">
                                                <thead>
                                                    <tr>
                                                        <th colspan="6" style="text-align: center"><b>IMAGING</b>
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th>Tick</th>
                                                        <th>Doctor’s order</th>
                                                        <th>Sent</th>
                                                        <th>Due</th>
                                                        <th>Nurse’s Sign</th>
                                                        <th>Nurse’s ID</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td><input type="checkbox" value="1" name="img[]"
                                                                {{ in_array('1', $img) ? 'checked' : '' }}></td>
                                                        <td>CT Scan</td>
                                                        <td><input type="text" name="img_ct_s"
                                                                value="{{ $adult_emergency_dept->img_ct_s ?? '' }}">
                                                        </td>
                                                        <td><input type="text" name="img_ct_d"
                                                                value="{{ $adult_emergency_dept->img_ct_d ?? '' }}">
                                                        </td>
                                                        <td><input type="text" name="img_ct_sn"
                                                                value="{{ $adult_emergency_dept->img_ct_sn ?? '' }}">
                                                        </td>
                                                        <td><input type="text" name="img_ct_id"
                                                                value="{{ $adult_emergency_dept->img_ct_id ?? '' }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><input type="checkbox" value="2" name="img[]"
                                                                {{ in_array('2', $img) ? 'checked' : '' }}></td>
                                                        <td>Echo</td>
                                                        <td><input type="text" name="img_echo_s"
                                                                value="{{ $adult_emergency_dept->img_echo_s ?? '' }}">
                                                        </td>
                                                        <td><input type="text" name="img_echo_d"
                                                                value="{{ $adult_emergency_dept->img_echo_d ?? '' }}">
                                                        </td>
                                                        <td><input type="text" name="img_echo_sn"
                                                                value="{{ $adult_emergency_dept->img_echo_sn ?? '' }}">
                                                        </td>
                                                        <td><input type="text" name="img_echo_id"
                                                                value="{{ $adult_emergency_dept->img_echo_id ?? '' }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><input type="checkbox" value="3" name="img[]"
                                                                {{ in_array('3', $img) ? 'checked' : '' }}></td>
                                                        <td>MRI</td>
                                                        <td><input type="text" name="img_mri_s"
                                                                value="{{ $adult_emergency_dept->img_mri_s ?? '' }}">
                                                        </td>
                                                        <td><input type="text" name="img_mri_d"
                                                                value="{{ $adult_emergency_dept->img_mri_d ?? '' }}">
                                                        </td>
                                                        <td><input type="text" name="img_mri_sn"
                                                                value="{{ $adult_emergency_dept->img_mri_sn ?? '' }}">
                                                        </td>
                                                        <td><input type="text" name="img_mri_id"
                                                                value="{{ $adult_emergency_dept->img_mri_id ?? '' }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><input type="checkbox" value="4" name="img[]"
                                                                {{ in_array('4', $img) ? 'checked' : '' }}>
                                                        </td>
                                                        <td>Ultrasound</td>
                                                        <td><input type="text" name="img_us_s"
                                                                value="{{ $adult_emergency_dept->img_us_s ?? '' }}">
                                                        </td>
                                                        <td><input type="text" name="img_us_d"
                                                                value="{{ $adult_emergency_dept->img_us_d ?? '' }}">
                                                        </td>
                                                        <td><input type="text" name="img_us_sn"
                                                                value="{{ $adult_emergency_dept->img_us_sn ?? '' }}">
                                                        </td>
                                                        <td><input type="text" name="img_us_id"
                                                                value="{{ $adult_emergency_dept->img_us_id ?? '' }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><input type="checkbox" value="5" name="img[]"
                                                                {{ in_array('5', $img) ? 'checked' : '' }}></td>
                                                        <td>X-ray</td>
                                                        <td><input type="text" name="img_xr_s"
                                                                value="{{ $adult_emergency_dept->img_xr_s ?? '' }}">
                                                        </td>
                                                        <td><input type="text" name="img_xr_d"
                                                                value="{{ $adult_emergency_dept->img_xr_d ?? '' }}">
                                                        </td>
                                                        <td><input type="text" name="img_xr_sn"
                                                                value="{{ $adult_emergency_dept->img_xr_sn ?? '' }}">
                                                        </td>
                                                        <td><input type="text" name="img_xr_id"
                                                                value="{{ $adult_emergency_dept->img_xr_id ?? '' }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><input type="checkbox" value="6" name="img[]"
                                                                {{ in_array('6', $img) ? 'checked' : '' }}></td>
                                                        <td>Others</td>
                                                        <td><input type="text" name="img_ot_s"
                                                                value="{{ $adult_emergency_dept->img_ot_s ?? '' }}">
                                                        </td>
                                                        <td><input type="text" name="img_ot_d"
                                                                value="{{ $adult_emergency_dept->img_ot_d ?? '' }}">
                                                        </td>
                                                        <td><input type="text" name="img_ot_sn"
                                                                value="{{ $adult_emergency_dept->img_ot_sn ?? '' }}">
                                                        </td>
                                                        <td><input type="text" name="img_ot_id"
                                                                value="{{ $adult_emergency_dept->img_ot_id ?? '' }}">
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                            @php
                                                $pam = json_decode($adult_emergency_dept->pam ?? '[]', true) ?? [];
                                            @endphp

                                            <table width="100%" border="1" style="margin-top:10px">
                                                <thead>
                                                    <tr>
                                                        <th colspan="6" style="text-align: center"><b>PATHOLOGY
                                                                AND MICROBIOLOGY</b></th>
                                                    </tr>
                                                    <tr>
                                                        <th>Tick</th>
                                                        <th>Doctor’s order</th>
                                                        <th>Sent</th>
                                                        <th>Due</th>
                                                        <th>Nurse’s Sign</th>
                                                        <th>Nurse’s ID</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td><input type="checkbox" value="1" name="pam[]"
                                                                {{ in_array('1', $pam) ? 'checked' : '' }}>
                                                        </td>
                                                        <td>Blood Cultures</td>
                                                        <td><input type="text" name="pam_bs_s"
                                                                value="{{ $adult_emergency_dept->pam_bs_s ?? '' }}">
                                                        </td>
                                                        <td><input type="text" name="pam_bs_d"
                                                                value="{{ $adult_emergency_dept->pam_bs_d ?? '' }}">
                                                        </td>
                                                        <td><input type="text" name="pam_bs_sn"
                                                                value="{{ $adult_emergency_dept->pam_bs_sn ?? '' }}">
                                                        </td>
                                                        <td><input type="text" name="pam_bs_id"
                                                                value="{{ $adult_emergency_dept->pam_bs_id ?? '' }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><input type="checkbox" value="2" name="pam[]"
                                                                {{ in_array('2', $pam) ? 'checked' : '' }}>
                                                        </td>
                                                        <td>Stool RE</td>
                                                        <td><input type="text" name="pam_sr_s"
                                                                value="{{ $adult_emergency_dept->pam_sr_s ?? '' }}">
                                                        </td>
                                                        <td><input type="text" name="pam_sr_d"
                                                                value="{{ $adult_emergency_dept->pam_sr_d ?? '' }}">
                                                        </td>
                                                        <td><input type="text" name="pam_sr_sn"
                                                                value="{{ $adult_emergency_dept->pam_sr_sn ?? '' }}">
                                                        </td>
                                                        <td><input type="text" name="pam_sr_id"
                                                                value="{{ $adult_emergency_dept->pam_sr_id ?? '' }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><input type="checkbox" value="3" name="pam[]"
                                                                {{ in_array('3', $pam) ? 'checked' : '' }}>
                                                        </td>
                                                        <td>Stool OBT</td>
                                                        <td><input type="text" name="pam_so_s"
                                                                value="{{ $adult_emergency_dept->pam_so_s ?? '' }}">
                                                        </td>
                                                        <td><input type="text" name="pam_so_d"
                                                                value="{{ $adult_emergency_dept->pam_so_d ?? '' }}">
                                                        </td>
                                                        <td><input type="text" name="pam_so_sn"
                                                                value="{{ $adult_emergency_dept->pam_so_sn ?? '' }}">
                                                        </td>
                                                        <td><input type="text" name="pam_so_id"
                                                                value="{{ $adult_emergency_dept->pam_so_id ?? '' }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><input type="checkbox" value="4" name="pam[]"
                                                                {{ in_array('4', $pam) ? 'checked' : '' }}>
                                                        </td>
                                                        <td>Urine RME</td>
                                                        <td><input type="text" name="pam_ur_s"
                                                                value="{{ $adult_emergency_dept->pam_ur_s ?? '' }}">
                                                        </td>
                                                        <td><input type="text" name="pam_ur_d"
                                                                value="{{ $adult_emergency_dept->pam_ur_d ?? '' }}">
                                                        </td>
                                                        <td><input type="text" name="pam_ur_sn"
                                                                value="{{ $adult_emergency_dept->pam_ur_sn ?? '' }}">
                                                        </td>
                                                        <td><input type="text" name="pam_ur_id"
                                                                value="{{ $adult_emergency_dept->pam_ur_id ?? '' }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><input type="checkbox" value="5" name="pam[]"
                                                                {{ in_array('5', $pam) ? 'checked' : '' }}>
                                                        </td>
                                                        <td>Urine C/S</td>
                                                        <td><input type="text" name="pam_uc_s"
                                                                value="{{ $adult_emergency_dept->pam_uc_s ?? '' }}">
                                                        </td>
                                                        <td><input type="text" name="pam_uc_d"
                                                                value="{{ $adult_emergency_dept->pam_uc_d ?? '' }}">
                                                        </td>
                                                        <td><input type="text" name="pam_uc_sn"
                                                                value="{{ $adult_emergency_dept->pam_uc_sn ?? '' }}">
                                                        </td>
                                                        <td><input type="text" name="pam_uc_id"
                                                                value="{{ $adult_emergency_dept->pam_uc_id ?? '' }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><input type="checkbox" value="6" name="pam[]"
                                                                {{ in_array('6', $pam) ? 'checked' : '' }}></td>
                                                        <td>Others</td>
                                                        <td><input type="text" name="pam_bc_s"
                                                                value="{{ $adult_emergency_dept->pam_bc_s ?? '' }}">
                                                        </td>
                                                        <td><input type="text" name="pam_bc_d"
                                                                value="{{ $adult_emergency_dept->pam_bc_d ?? '' }}">
                                                        </td>
                                                        <td><input type="text" name="pam_bc_sn"
                                                                value="{{ $adult_emergency_dept->pam_bc_sn ?? '' }}">
                                                        </td>
                                                        <td><input type="text" name="pam_bc_id"
                                                                value="{{ $adult_emergency_dept->pam_bc_id ?? '' }}">
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table> <br>
                                            @php
                                                $ds = json_decode($adult_emergency_dept->ds ?? '[]', true) ?? [];
                                                $admit = json_decode($adult_emergency_dept->admit ?? '[]', true) ?? [];
                                                $condition =
                                                    json_decode($adult_emergency_dept->condition ?? '[]', true) ?? [];
                                            @endphp

                                            <table border="1" width="100%" cellspacing="0" cellpadding="4"
                                                style="border-collapse: collapse;">
                                                <tr>
                                                    <td colspan="2" style="text-align: center"><b>Patient
                                                            disposition from ED</b></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <b>Provisional diagnosis:</b>
                                                        <input type="text" style="width: 100%;" name="pd"
                                                            value="{{ $adult_emergency_dept->pd ?? '' }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <b>Disposition status:</b>
                                                        <label><input type="checkbox" name="ds[]"
                                                                id="admit" value="Admit"
                                                                {{ in_array('Admit', $ds) ? 'checked' : '' }}>
                                                            Admit</label>
                                                        <label><input type="checkbox" name="ds[]"
                                                                value="Discharge"
                                                                {{ in_array('Discharge', $ds) ? 'checked' : '' }}>
                                                            Discharge</label>
                                                        <label><input type="checkbox" name="ds[]"
                                                                value="LAMA"
                                                                {{ in_array('LAMA', $ds) ? 'checked' : '' }}>
                                                            LAMA</label>
                                                        <label><input type="checkbox" name="ds[]"
                                                                value="Referred"
                                                                {{ in_array('Referred', $ds) ? 'checked' : '' }}>
                                                            Referred (OPD/Outside)</label>
                                                        <label><input type="checkbox" name="ds[]"
                                                                value="Death"
                                                                {{ in_array('Death', $ds) ? 'checked' : '' }}>
                                                            Death</label>
                                                        <br>
                                                        <label><input type="checkbox" class="admit-option"
                                                                name="admit[]" value="ICU"
                                                                {{ in_array('ICU', $admit) ? 'checked' : '' }}
                                                                {{ in_array('Admit', $ds) ? '' : 'disabled' }}>
                                                            ICU</label>
                                                        <label><input type="checkbox" class="admit-option"
                                                                name="admit[]" value="HDU"
                                                                {{ in_array('HDU', $admit) ? 'checked' : '' }}
                                                                {{ in_array('Admit', $ds) ? '' : 'disabled' }}>
                                                            HDU</label>
                                                        <label><input type="checkbox" class="admit-option"
                                                                name="admit[]" value="CCU"
                                                                {{ in_array('CCU', $admit) ? 'checked' : '' }}
                                                                {{ in_array('Admit', $ds) ? '' : 'disabled' }}>
                                                            CCU</label>
                                                        <label><input type="checkbox" class="admit-option"
                                                                name="admit[]" value="Cath"
                                                                {{ in_array('Cath', $admit) ? 'checked' : '' }}
                                                                {{ in_array('Admit', $ds) ? '' : 'disabled' }}> Cath
                                                            Lab</label>
                                                        <label><input type="checkbox" class="admit-option"
                                                                name="admit[]" value="OT"
                                                                {{ in_array('OT', $admit) ? 'checked' : '' }}
                                                                {{ in_array('Admit', $ds) ? '' : 'disabled' }}>
                                                            OT</label>
                                                        <label><input type="checkbox" class="admit-option"
                                                                name="admit[]" value="Cabin"
                                                                {{ in_array('Cabin', $admit) ? 'checked' : '' }}
                                                                {{ in_array('Admit', $ds) ? '' : 'disabled' }}>
                                                            Cabin</label>
                                                        <label><input type="checkbox" class="admit-option"
                                                                name="admit[]" value="Ward"
                                                                {{ in_array('Ward', $admit) ? 'checked' : '' }}
                                                                {{ in_array('Admit', $ds) ? '' : 'disabled' }}>
                                                            Ward</label>
                                                        <label><input type="checkbox" class="admit-option"
                                                                name="admit[]" value="Other"
                                                                {{ in_array('Other', $admit) ? 'checked' : '' }}
                                                                {{ in_array('Admit', $ds) ? '' : 'disabled' }}>
                                                            Other</label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <b>Condition at time of disposition:</b>
                                                        <label><input type="checkbox" name="condition[]"
                                                                value="Well"
                                                                {{ in_array('Well', $condition) ? 'checked' : '' }}>
                                                            Well</label>
                                                        <label><input type="checkbox" name="condition[]"
                                                                value="Fair"
                                                                {{ in_array('Fair', $condition) ? 'checked' : '' }}>
                                                            Fair</label>
                                                        <label><input type="checkbox" name="condition[]"
                                                                value="Poor"
                                                                {{ in_array('Poor', $condition) ? 'checked' : '' }}>
                                                            Poor</label>
                                                        <label><input type="checkbox" id="critical"
                                                                name="condition[]" value="Critical"
                                                                {{ in_array('Critical', $condition) ? 'checked' : '' }}>
                                                            Critical (if critical complete SBAR)</label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="50%">
                                                        <b>TRANSFER NOTE:</b> (In case of transferring from ED to
                                                        Critical areas)
                                                        <table border="1" width="100%"
                                                            style="border-collapse: collapse; font-size: 12px; margin-top: 5px;">
                                                            <tr>
                                                                <th>Staff</th>
                                                                <th>Name</th>
                                                                <th>Emp. ID</th>
                                                                <th>Date & Time</th>
                                                            </tr>
                                                            <tr>
                                                                <td>Transferring Doctor</td>
                                                                <td><input type="text" name="td_name"
                                                                        id="td_name" class="form-control"
                                                                        value="{{ $adult_emergency_dept->td_name ?? '' }}">
                                                                    <input type="hidden" name="htd_empid"
                                                                        id="htd_empid" class="form-control">
                                                                </td>
                                                                <td><input type="text" name="td_empid"
                                                                        id="td_empid" class="form-control"
                                                                        value="{{ $adult_emergency_dept->td_empid ?? '' }}">
                                                                </td>
                                                                <td><input type="datetime-local" name="td_datetime"
                                                                        class="form-control"
                                                                        value="{{ isset($adult_emergency_dept->td_datetime) ? date('Y-m-d\TH:i', strtotime($adult_emergency_dept->td_datetime)) : '' }}">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Receiving Doctor</td>
                                                                <td><input type="text" name="rd_name"
                                                                        id="rd_name" class="form-control"
                                                                        value="{{ $adult_emergency_dept->rd_name ?? '' }}">
                                                                    <input type="hidden" name="hrd_empid"
                                                                        id="hrd_empid" class="form-control">
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="rd_empid"
                                                                        id="rd_empid" class="form-control"
                                                                        value="{{ $adult_emergency_dept->rd_empid ?? '' }}">
                                                                </td>
                                                                <td><input type="datetime-local" name="rd_datetime"
                                                                        class="form-control"
                                                                        value="{{ isset($adult_emergency_dept->rd_datetime) ? date('Y-m-d\TH:i', strtotime($adult_emergency_dept->rd_datetime)) : '' }}">
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                    <td width="50%" valign="top">
                                                        <b>SBAR Handover</b><br>
                                                        Situation:
                                                        <textarea class="sbar-field" style="width:100%;" name="sbar_st"
                                                            {{ in_array('Critical', $condition) ? '' : 'disabled' }}>{{ $adult_emergency_dept->sbar_st ?? '' }}</textarea><br>
                                                        Background:
                                                        <textarea class="sbar-field" style="width:100%;" name="sbar_bg"
                                                            {{ in_array('Critical', $condition) ? '' : 'disabled' }}>{{ $adult_emergency_dept->sbar_bg ?? '' }}</textarea><br>
                                                        Assessment:
                                                        <textarea class="sbar-field" style="width:100%;" name="sbar_ass"
                                                            {{ in_array('Critical', $condition) ? '' : 'disabled' }}>{{ $adult_emergency_dept->sbar_ass ?? '' }}</textarea><br>
                                                        Recommendations:
                                                        <textarea class="sbar-field" style="width:100%;" name="sbar_rc"
                                                            {{ in_array('Critical', $condition) ? '' : 'disabled' }}>{{ $adult_emergency_dept->sbar_rc ?? '' }}</textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <b>Date & Time of Admission: </b>
                                                        {{ date('Y-m-d h:i A', strtotime($patient_info->admission_date)) }}
                                                    </td>
                                                    <td>
                                                        <b>Date & Time of Discharge: </b>
                                                        @if (!empty($admission_info->dis_datetime))
                                                            {{ date('Y-m-d h:i A', strtotime($admission_info->dis_datetime)) }}
                                                        @else
                                                            No Discharge Date Found
                                                        @endif
                                                    </td>
                                                </tr>
                                            </table>

                                        </div>



                                        <div class="text-center">

                                            @php
                                                $redirect_url = route('adult-emergency-dept', [
                                                    'patient_no_fk' => $patient_no_fk,
                                                    'admission_id' => $admission_id,
                                                ]);
                                            @endphp

                                            <button type="submit" class="btn btn-success btn-lg m-3 float-right"
                                                onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $redirect_url }}')">Save</button>
                                        </div>


                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</main>
<!-- Add New Dose Option Modal -->
<div class="modal fade" id="addMoreDropdownOption" tabindex="-1" role="dialog"
    aria-labelledby="addMoreDropdownOptionTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" id="newDropdownOptionDiv">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="addMoreDropdownOptionHeader">Header</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="col-md-12">
                        <label for="new_dose_opt" id="addMoreDropdownOptionLabel"
                            class="col-form-label col-form-label-sm">Label</label>
                        <input type="hidden" name="thisElement_id" id="thisElement_id" value="">
                        <input type="text" class="form-control" id="new_dropdown_opt" name="new_dropdown_opt"
                            value="" placeholder="Enter new option" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer py-1">
                <div class="col-md-12 text-right">
                    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-sm btn-primary add_new_option_btn"
                        onclick="prescriptionFunc.addToDropdown(this)">Add</button>
                </div>
            </div>
        </div>
    </div>
</div>




<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('asset/timepicker/js/timepicker.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {

        openItemAutocomplete($("#medicine_item"), "MED", "#hdn_medicine_item_id", "#medicine_item");
        openDoctorAutocomplete('#ts_name', 'hts_epmid', 'employee_ind', '1');
        openDoctorAutocomplete('#f_name', 'hf_empid', 'employee_ind', '1');
        openDoctorAutocomplete('#narr_name', 'hnarr_epmid', 'employee_ind', '1');
        openDoctorAutocomplete('#eds_name', 'heds_epmid', 'employee_ind', '1');
        openDoctorAutocomplete('#consult1_name', 'hconsult1_epmid', 'employee_ind', '1');
        openDoctorAutocomplete('#consult2_name', 'hconsult2_epmid', 'employee_ind', '1');
        openDoctorAutocomplete('#td_name', 'htd_empid', 'employee_ind', '1');
        openDoctorAutocomplete('#rd_name', 'hrd_empid', 'employee_ind', '1');

        // openItemAutocompleteWithStockPrescription($("#mr_drug"), 'MED', '#hdn_mr_drug',
        //     '#mr_drug');





        $(".select2").select2();
    })



    function toggleCaseNo() {
        let medico = document.getElementById("medico").value;
        let caseNoInput = document.getElementById("case_no");

        if (medico === "Yes") {
            caseNoInput.removeAttribute("readonly");
        } else {
            caseNoInput.value = ""; // clear previous input if switching back
            caseNoInput.setAttribute("readonly", true);
        }
    }
    let total = 0;

    // handle clicks in table 1
    document.querySelectorAll("#tewsTable td[data-value]").forEach(cell => {
        cell.addEventListener("click", function() {
            let row = this.parentNode;
            // deselect any previously selected in same row
            row.querySelectorAll("td").forEach(td => td.classList.remove("selected"));
            this.classList.add("selected");

            // recalc sum
            total = 0;
            document.querySelectorAll("#tewsTable td.selected").forEach(sel => {
                total += parseInt(sel.getAttribute("data-value"));
            });

            //document.getElementById("totalScore").innerText = total;

            updateLevel(total);
        });
    });

    function updateLevel(score) {
        // clear all
        document.querySelectorAll("input[type=checkbox]").forEach(cb => cb.checked = false);

        if (score >= 7) document.getElementById("level1").checked = true;
        else if (score >= 5) document.getElementById("level2").checked = true;
        else if (score >= 3) document.getElementById("level3").checked = true;
        else document.getElementById("level4").checked = true;
    }


    function updateTotal() {
        let eyes = parseInt(document.getElementById('eyes').value) || 0;
        let verbal = parseInt(document.getElementById('verbal').value) || 0;
        let motor = parseInt(document.getElementById('motor').value) || 0;

        let total = eyes + verbal + motor;
        document.getElementById('total').value = total > 0 ? total : '';
    }

    document.getElementById('eyes').addEventListener('change', updateTotal);
    document.getElementById('verbal').addEventListener('change', updateTotal);
    document.getElementById('motor').addEventListener('change', updateTotal);
    // Admit checkbox logic
    document.getElementById("admit").addEventListener("change", function() {
        const admitOptions = document.querySelectorAll(".admit-option");
        admitOptions.forEach(opt => {
            opt.disabled = !this.checked;
            if (!this.checked) opt.checked = false; // uncheck if disabled
        });
    });

    // Critical checkbox logic
    document.getElementById("critical").addEventListener("change", function() {
        const sbarFields = document.querySelectorAll(".sbar-field");
        sbarFields.forEach(field => {
            field.disabled = !this.checked;
        });
    });


    $(document).ready(function() {
        // Add row
        $(document).on('click', '.addRow', function() {
            let row = $(this).closest('tr').clone();

            // clear inputs
            row.find("input, select").val("");

            // replace action buttons → only delete button
            row.find("td:last").html(`
            <span class="btn btn-danger btn-md removeRow">
                <i class="fa fa-trash"></i>
            </span>
        `);

            // append new row
            $("#medicineTableBody").append(row);


            // reinit select2 if needed
            row.find(".select2").select2();
        });

        // Remove row
        $(document).on('click', '.removeRow', function() {
            $(this).closest('tr').remove();
        });
    });

    $(document).ready(function() {
        // Add row
        $(document).on('click', '.add', function() {
            let row = $(this).closest('tr').clone();

            // clear inputs
            row.find("input, select").val("");

            // replace action buttons → only delete button
            row.find("td:last").html(`
            <span class="btn btn-danger btn-md deleterow">
                <i class="fa fa-trash"></i>
            </span>
        `);

            // append new row

            $("#medicineTable").append(row);

            // reinit select2 if needed
            row.find(".select2").select2();
        });

        // Remove row
        $(document).on('click', '.deleterow', function() {
            $(this).closest('tr').remove();
        });
    });

    var count = $('.medicine_add_cart tbody tr').length;
    var medicine_item = "";
    var hdn_medicine_item_id = "";
    var hdn_report_serial_med = "";
    var medicine_route = "";
    var medicine_dose = 0;
    var medicine_duration_type = 0;
    var medicine_duration_mu = "";
    var medicine_quantity = "";
    var instruction = "";
    var tbl = "";

    function addMedicineItem() {

        var medicine_item = $("#medicine_item").val();
        var hdn_medicine_item_id = $("#hdn_medicine_item_id").val();
        var hdn_report_serial_med = $("#hdn_report_serial_med").val();
        var medicine_route = $("#medicine_route").val();
        var medicine_dose = $("#medicine_dose").val();
        var medicine_duration_type = $("#medicine_duration_type").val();
        var medicine_duration_mu = $("#medicine_duration_mu").val();
        var medicine_quantity = $("#medicine_quantity").val();
        var instruction = $("#instruction").val();

        if (medicine_item == "" || medicine_item == null) {
            alert('Medicine Item Required !');
            return false;
        }

        if (medicine_dose == 0) {
            alert('Medicine Dose Required !');
            return false;
        }
        if (medicine_duration_type == "" || medicine_duration_type == 0 || medicine_duration_type == null) {
            alert('Medicine Duration Required !');
            return false;
        }
        if (medicine_quantity == "" || medicine_quantity == 0 || medicine_quantity == null) {
            alert('Medicine Qty !');
            return false;
        }

        $("tr.emptyCart").remove();

        count += 1;
        tbl = `<tr class="border-0" id="tbl${count}">
                        <td class="py-1 border-0">
                            <input type="text" class="form-control form-control-sm m-0 p-0 item_element" id="medicine_item_${count}" name="medicine_item[]" placeholder="Generic / Brand" value="${medicine_item}">
                            <input type="hidden" id="hdn_medicine_item_id_${count}" name="hdn_medicine_item_id[]" value="${hdn_medicine_item_id}">
                            <input type="hidden" id="hdn_report_serial_med_${count}"  name="hdn_report_serial_med[]" value="${hdn_report_serial_med}">
                        </td>
                        <td class="py-1 px-1 border-0">
                            <select class="form-control form-control-sm select2 m-0 p-0 medicine_route" id="medicine_route_${count}" name="medicine_route[]" onchange="prescriptionFunc.addMoreDropdownOption(this,'.medicine_route');">
                                <option value="0">Select</option>
                                    @foreach ($route as $key => $dmu)
                                        <option value="{{ $key }}"> {{ $dmu['data'] }}</option>
                                    @endforeach
                                <option data-qnty="0" data-dropdown_option="add_more" data-popup_header="Medicine Route"  data-input_label="Route" data-input_placeholder="Enter medicine route (i.e., Oral, Ocular)"  value="0">Add More</option>
                            </select>
                        </td>

                        <td class="py-1 px-1 border-0">
                            <select class="form-control select2 m-0 p-0 medicine_dose" id="medicine_dose_${count}" name="medicine_dose[]" onchange="prescriptionFunc.addMoreDropdownOption(this,'.medicine_dose');prescriptionFunc.calculateMedicineQnty(this)">
                                <option value="0">Select</option>
                                    @foreach ($dose as $key => $dmu)
                                        <option data-qnty="" value="{{ $key }}">{{ $dmu['data'] }}</option>
                                    @endforeach
                                <option data-qnty="0" data-dropdown_option="add_more" data-popup_header="Medicine Dose" data-input_label="Dose"  data-input_placeholder="Enter medicine doses (i.e., 0+0+0, 0tsf+0tsf+0tsf)" value="0">Add More</option>
                            </select>
                        </td>

                        <td class="py-1 px-1 border-0">
                            <div class="input-group">
                                <input type="number" step="0.01" class="form-control form-control-sm m-0 p-0 medicine_duration number_only" id="medicine_duration_type_${count}"  name="medicine_duration_type[]" onkeyup="prescriptionFunc.calculateMedicineQnty(this)" value="${medicine_duration_type}">
                                <select class="form-control medicine_duration_mu" id="medicine_duration_mu_${count}" name="medicine_duration_mu[]" onchange="prescriptionFunc.calculateMedicineQnty(this)">
                                    <option value="0">Select</option>
                                        @foreach ($meddurmu as $key => $dmu)
                                            <option value="{{ strtoupper($key) }}" {{ strtoupper($key) == 'DAY' ? 'selected' : '' }}>{{ $dmu['data'] }}</option>
                                        @endforeach
                                </select>
                            </div>
                        </td>

                        <td class="py-1 px-1 border-0">
                            <input type="number" step="0.01" class="form-control form-control-sm m-0 p-0 medicine_quantity" id="medicine_quantity_${count}" name="medicine_quantity[]" value="${medicine_quantity}">
                        </td>

                        <td class="py-1 px-1 border-0">
                            <select class="form-control form-control-sm select2 m-0 p-0 instruction" id="instruction_${count}" name="instruction[]"  onchange="prescriptionFunc.addMoreDropdownOption(this,'.instruction');">
                                <option value="0">Select</option>
                                @foreach ($instructions as $key => $dmu)
                                    <option value="{{ $key }}" >{{ $dmu['data'] }}</option>
                                @endforeach
                            </select>
                        </td>

                        <td class="py-1 px-1 border-0 text-center" id="med_td_action_${count}">
                            <span class="remove_row" onclick="removeRow('tbl${count}')"><i class="fas fa-trash" style="color:red"></i></span>
                        </td>
                    </tr>`;

        $('.medicine_add_cart tbody').append(tbl);


        //set value
        $("#medicine_item_" + count).val(medicine_item);
        $("#hdn_medicine_item_id_" + count).val(hdn_medicine_item_id);
        $("#hdn_report_serial_med_" + count).val(hdn_report_serial_med);

        $("#medicine_duration_type_" + count).val(medicine_duration_type);
        $("#medicine_duration_mu_" + count).val(medicine_duration_mu);
        $("#medicine_quantity_" + count).val(medicine_quantity);


        if ($("#medicine_route_" + count + " option[value='" + medicine_route + "']").length == 0) {
            $("#medicine_route_" + count).append(
                $("<option></option>").attr("value", medicine_route).attr("selected", "selected").text(
                    medicine_route)
            );
        } else {
            $("#medicine_route_" + count).val(medicine_route);
        };

        if ($("#medicine_dose_" + count + " option[value='" + medicine_dose + "']").length == 0) {
            $("#medicine_dose_" + count).append(
                $("<option></option>").attr("value", medicine_dose).attr("selected", "selected").text(medicine_dose)
            );
        } else {
            $("#medicine_dose_" + count).val(medicine_dose);
        };

        if ($("#instruction_" + count + " option[value='" + instruction + "']").length == 0) {
            $("#instruction_" + count).append(
                $("<option></option>").attr("value", instruction).attr("selected", "selected").text(instruction)
            );
        } else {
            $("#instruction_" + count).val(instruction);
        };


        $('#medicine_route_' + count).select2({});
        $('#medicine_dose_' + count).select2({});
        $('#instruction_' + count).select2({});

        resetCart();
    }




    function resetForm() {
        $(".medicine_add_cart tbody").empty();
        $("#ADULTEMERGENCY").trigger("reset");
        emptyTable();
    }

    function resetCart() {
        $("#medicine_item").val("");
        $("#hdn_medicine_item_id").val("");
        $("#hdn_report_serial_med").val("");
        $("#medicine_duration_type").val("");
        $("#medicine_quantity").val("");

        $('#medicine_route').val(0).trigger('change');
        $('#medicine_dose').val(0).trigger('change');
        $('#medicine_duration_mu').val(0).trigger('change');
        $('#instruction').val(0).trigger('change');
    }

    function emptyTable() {
        $('.medicine_add_cart tbody').empty();
        $('.medicine_add_cart tbody').append(`
                    <tr class="emptyCart">
                        <td colspan="7" class="text-danger text-center">Your Cart is Empty</td>
                    </tr>
                `);
    }

    function removeRow(id) {
        if (confirm('Are you sure ?')) {
            $("#" + id).remove();

            if ($('.medicine_add_cart tbody tr').length == 0) {
                emptyTable();
            }
        }
    }

    $(document).on('input', '.negative-ignore', function() {
        if ($(this).val() < 0) {
            alert('Negative value not allowed');
            $(this).val(Math.abs($(this).val()));
            return false;
        }
    })
</script>
