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

    .section-title {
        font-weight: bold;
        color: red;
        text-align: center;
        padding: 6px;
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
                            <h5 class="mt-2 mb-0">ADULT Emergency Department Sepsis Bundle</h5>
                            <small>IPD / Nurse Station / ADULT Emergency Department Sepsis Bundle</small>
                        </div>
                        <div class="col-md-2">
                            <a class="btn btn-md btn-warning" target="_blank"
                                href="{{ route('adult-emergency-dept-sepsis-pdf', [$patient_info->patient_no_pk, $patient_info->admission_no_pk]) }}">PDF
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
                                    <form action="{{ route('adult-emergency-dept-sepsis-store') }}" method="post"
                                        id="ADULTEMERGENCYSEPSIS">
                                        @csrf
                                        <input type="hidden" name="patient_no_fk" id="patient_no_fk"
                                            value="{{ $patient_no_fk }}">
                                        <input type="hidden" name="admission_no_fk" id="admission_no_fk"
                                            value="{{ $admission_id }}">
                                        <input type="hidden" name="adult_emergency_sepsis_no_pk"
                                            value="{{ isset($adult_emergency_dept->adult_emergency_sepsis_no_pk) ? $adult_emergency_dept->adult_emergency_sepsis_no_pk : '' }}">


                                        <div class="table-responsive">



                                            <table width="100%" border="1" style="margin-top:10px">
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
                                                        $criteria =
                                                            json_decode(
                                                                $adult_emergency_dept->criteria ?? '[]',
                                                                true,
                                                            ) ?? [];
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
                                                        <select class="form-control" name="vasopressor">
                                                            <option value="">--Select--</option>
                                                            <option value="Yes"
                                                                {{ @$adult_emergency_dept->vasopressor == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option value="No"
                                                                {{ @$adult_emergency_dept->vasopressor == 'No' ? 'selected' : '' }}>
                                                                No</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    @php
                                                        $task =
                                                            json_decode($adult_emergency_dept->task ?? '[]', true) ??
                                                            [];
                                                    @endphp
                                                    <td rowspan="2" style="width:70%;">
                                                        <div style="display:flex;flex-wrap:wrap;gap:6px;">
                                                            <!-- Box 1 -->
                                                            <div class="task-box">
                                                                <div class="task-content">
                                                                    <label>
                                                                        <input type="checkbox" name="task[]"
                                                                            value="1"
                                                                            {{ in_array('1', $task) ? 'checked' : '' }}>
                                                                        <b>1 Ensure ED Clinician attends</b>
                                                                    </label><br>
                                                                    Specialist and above or equivalent senior nurse
                                                                </div>
                                                                <div class="task-footer">
                                                                    <span>ID: <input type="text" name="clinical_id"
                                                                            value="{{ @$adult_emergency_dept->clinical_id }}"></span>
                                                                    <span>Time: <input type="text"
                                                                            name="clinical_time"
                                                                            value="{{ @$adult_emergency_dept->clinical_time }}"></span>
                                                                </div>
                                                            </div>

                                                            <!-- Box 2 -->
                                                            <div class="task-box">
                                                                <div class="task-content">
                                                                    <label>
                                                                        <input type="checkbox" name="task[]"
                                                                            value="2"
                                                                            {{ in_array('2', $task) ? 'checked' : '' }}>
                                                                        <b>2 Give O₂, if required</b>
                                                                    </label><br>
                                                                    Start if saturations less than 92%. Aim for 94-98%.
                                                                    If at risk of hypercarbia use 88-92%.
                                                                </div>
                                                                <div class="task-footer">
                                                                    <span>ID: <input type="text" name="o2_id"
                                                                            value="{{ @$adult_emergency_dept->o2_id }}"></span>
                                                                    <span>Time: <input type="text" name="o2_time"
                                                                            value="{{ @$adult_emergency_dept->o2_time }}"></span>
                                                                </div>
                                                            </div>

                                                            <!-- Box 3 -->
                                                            <div class="task-box">
                                                                <div class="task-content">
                                                                    <label>
                                                                        <input type="checkbox" name="task[]"
                                                                            value="3"
                                                                            {{ in_array('3', $task) ? 'checked' : '' }}>
                                                                        <b>3 Obtain IV access, take bloods</b>
                                                                    </label><br>
                                                                    Include blood cultures, glucose, lactate, FBC, U&Es,
                                                                    CRP, LFTs, Clotting.
                                                                </div>
                                                                <div class="task-footer">
                                                                    <span>ID: <input type="text" name="iv_id"
                                                                            value="{{ @$adult_emergency_dept->iv_id }}"></span>
                                                                    <span>Time: <input type="text" name="iv_time"
                                                                            value="{{ @$adult_emergency_dept->iv_time }}"></span>
                                                                </div>
                                                            </div>

                                                            <!-- Box 4 -->
                                                            <div class="task-box">
                                                                <div class="task-content">
                                                                    <label>
                                                                        <input type="checkbox" name="task[]"
                                                                            value="4"
                                                                            {{ in_array('4', $task) ? 'checked' : '' }}>
                                                                        <b>4 Give antibiotics and consider source
                                                                            control</b>
                                                                    </label><br>
                                                                    Maximum dose broad spectrum therapy.
                                                                </div>
                                                                <div class="task-footer">
                                                                    <span>ID: <input type="text" name="antibio_id"
                                                                            value="{{ @$adult_emergency_dept->antibio_id }}"></span>
                                                                    <span>Time: <input type="text"
                                                                            name="antibio_time"
                                                                            value="{{ @$adult_emergency_dept->antibio_time }}"></span>
                                                                </div>
                                                            </div>

                                                            <!-- Box 5 -->
                                                            <div class="task-box">
                                                                <div class="task-content">
                                                                    <label>
                                                                        <input type="checkbox" name="task[]"
                                                                            value="5"
                                                                            {{ in_array('5', $task) ? 'checked' : '' }}>
                                                                        <b>5 Give IV fluids</b>
                                                                    </label><br>
                                                                    Up to 20 ml/kg fluid boluses. Use lactate to guide
                                                                    fluid therapy.
                                                                </div>
                                                                <div class="task-footer">
                                                                    <span>ID: <input type="text" name="fluids_id"
                                                                            value="{{ @$adult_emergency_dept->fluids_id }}"></span>
                                                                    <span>Time: <input type="text"
                                                                            name="fluids_time"
                                                                            value="{{ @$adult_emergency_dept->fluids_time }}"></span>
                                                                </div>
                                                            </div>

                                                            <!-- Box 6 -->
                                                            <div class="task-box">
                                                                <div class="task-content">
                                                                    <label>
                                                                        <input type="checkbox" name="task[]"
                                                                            value="6"
                                                                            {{ in_array('6', $task) ? 'checked' : '' }}>
                                                                        <b>6 Monitor</b>
                                                                    </label><br>
                                                                    Use NEWS2. Measure urine output. Repeat lactate if
                                                                    elevated or clinical changes.
                                                                </div>
                                                                <div class="task-footer">
                                                                    <span>ID: <input type="text" name="monitor_id"
                                                                            value="{{ @$adult_emergency_dept->monitor_id }}"></span>
                                                                    <span>Time: <input type="text"
                                                                            name="monitor_time"
                                                                            value="{{ @$adult_emergency_dept->monitor_time }}"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    @php
                                                        $news2 =
                                                            json_decode($adult_emergency_dept->news2 ?? '[]', true) ??
                                                            [];
                                                    @endphp
                                                    <td style="width:30%; text-align:left;">
                                                        <b>Is NEWS2 7 or above?</b><br>
                                                        or is NEWS2 5 or 6 and one of:<br>
                                                        <input type="checkbox" value="1"
                                                            {{ in_array('1', $news2) ? 'checked' : '' }}
                                                            name="news2[]"> Any
                                                        NEWS2 parameter score of 3<br>
                                                        <input type="checkbox" value="2"
                                                            {{ in_array('2', $news2) ? 'checked' : '' }}
                                                            name="news2[]">
                                                        Mottled/ashen skin<br>
                                                        <input type="checkbox" value="3"
                                                            {{ in_array('3', $news2) ? 'checked' : '' }}
                                                            name="news2[]">
                                                        Non-blanching rash<br>
                                                        <input type="checkbox" value="4"
                                                            {{ in_array('4', $news2) ? 'checked' : '' }}
                                                            name="news2[]">
                                                        Cyanosis of lips/tongue<br>
                                                        <input type="checkbox" value="5"
                                                            {{ in_array('5', $news2) ? 'checked' : '' }}
                                                            name="news2[]">
                                                        Deterioration since last assessment<br>
                                                        <input type="checkbox" value="6"
                                                            {{ in_array('6', $news2) ? 'checked' : '' }}
                                                            name="news2[]">
                                                        Deterioration since recent
                                                        intervention<br>
                                                        <input type="checkbox" value="7"
                                                            {{ in_array('7', $news2) ? 'checked' : '' }}
                                                            name="news2[]"> Lactate
                                                        ≥ 2 mmol/L or known AKI<br><br>
                                                        NEWS2 Score: <input type="text" class="form-control"
                                                            name="news2_score"
                                                            value="{{ @$adult_emergency_dept->news2_score }}"><br>
                                                        Initial Lactate: <input type="text" class="form-control"
                                                            name="news2_lactate"
                                                            value="{{ @$adult_emergency_dept->news2_lactate }}">
                                                    </td>
                                                </tr>

                                            </table>

                                            <table width="100%" border="1" style="margin-top:10px">
                                                <tr>
                                                    <td colspan="2">Name of Antibiotic prescribed:</td>
                                                    <td><input type="text" style="width:60%;" class="form-control"
                                                            name="antibiotic_name"
                                                            value="{{ @$adult_emergency_dept->antibiotic_name }}">
                                                    </td>
                                                    <td>Lactate level after 1 hour: </td>
                                                    <td><input type="text" style="width:30%;" class="form-control"
                                                            name="lactate_level"
                                                            value="{{ @$adult_emergency_dept->lactate_level }}"></td>
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
                                                    <td><input type="text" class="form-control" name="sepsis_name"
                                                            id="sepsis_name"
                                                            value="{{ @$adult_emergency_dept->sepsis_name }}">
                                                        <input type="hidden" class="form-control"
                                                            name="hh_sepsis_name" id="hh_sepsis_name">
                                                    </td>
                                                    <td>{{ @$adult_emergency_dept->sepsis_name }}</td>
                                                    <td><input type="text" class="form-control"
                                                            name="sepsis_design"
                                                            value="{{ @$adult_emergency_dept->sepsis_design }}"></td>
                                                    <td><input type="text" class="form-control"
                                                            name="h_sepsis_name" id="h_sepsis_name"
                                                            value="{{ @$adult_emergency_dept->h_sepsis_name }}"></td>
                                                    @php
                                                        $sepsis_time = explode(
                                                            ' ',
                                                            @$adult_emergency_dept->sepsis_time,
                                                        );
                                                    @endphp
                                                    <td><input type="time" class="form-control" name="sepsis_time"
                                                            value="{{ $sepsis_time[1] ?? '' }}"></td>
                                                </tr>
                                            </table>

                                            <div class="table-responsive">
                                                <table class="table border-0 mt-2 mb-0 medicine_add_cart"
                                                    id="medicine_list">
                                                    <thead class="medicine_thead">
                                                        <tr>
                                                            <th colspan="7" style="text-align: center">Antibiotic
                                                            Prescription</th>
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



                                        </div>



                                        <div class="text-center">

                                            @php
                                                $redirect_url = route('adult-emergency-dept-sepsis', [
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



<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('asset/timepicker/js/timepicker.js') }}"></script>
<script type="text/javascript">

    $(document).ready(function() {

        openItemAutocomplete($("#medicine_item"), "MED", "#hdn_medicine_item_id", "#medicine_item");
        openDoctorAutocomplete('#sepsis_name', 'hh_sepsis_name', 'employee_ind', '1');





        $(".select2").select2();
    })


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
        $("#ADULTEMERGENCYSEPSIS").trigger("reset");
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
