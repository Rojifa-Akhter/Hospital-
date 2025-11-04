<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">

<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link href="{{ asset('css/redactor.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('asset/timepicker/css/timepicker.css') }}">
<style>
    *,
    *::after,
    *::before {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
    }

    body {
        margin: 0;
        /* font-size: 14px; */
        /* background: #F4F3FE; */
    }

    h1,
    h2,
    h3,
    h4,
    h5,
    h6,
    p,
    ol,
    li,
    a {
        margin-bottom: 0;
        list-style: none;
    }

    a,
    a:hover {
        text-decoration: none;
    }

    .anaesthetic__form {
        padding: 25px 0px;
        position: relative;


    }

    .anaesthetic__form fieldset {
        display: block;
        margin-inline-start: 2px;
        margin-inline-end: 2px;
        padding-block-start: 0.35em;
        padding-inline-start: 0.75em;
        padding-inline-end: 0.75em;
        padding-block-end: 0.625em;
        min-inline-size: min-content;
        border-width: 1px;
        border-style: groove;
        border-color: #ffffff5e;
        border-image: initial;
    }

    .anaesthetic__form legend {
        display: block;
        padding-inline-start: 2px;
        padding-inline-end: 2px;
        border-width: initial;
        border-style: none;
        border-color: initial;
        border-image: initial;
        width: auto;
        font-size: 18px;
        font-weight: 600;
    }

    .anaesthetic__form .card {
        background-color: #fff0;

    }

    .col-form-label {
        font-size: 14px !important;
        font-weight: 700;
        color: #33449d;
    }

    img {
        max-width: 100%;
    }

    .header-info {
        float: right;
        overflow: hidden;
    }

    .header-info h1 {
        font-size: 35px;
        font-weight: 800;
        color: #970307;
    }

    .header-info h6 {
        font-size: 12px;
        font-weight: 400;
        font-style: italic;
    }

    .header-info p {
        font-size: 14px;
        font-weight: 500;
    }

    .card-header h4.card-title {
        font-size: 18px;
        font-weight: 600;
        color: #c9272b;
    }

    .capital_letter {
        display: block;
        text-align: center;
        font-size: 14px;
        font-weight: 500;
        color: #33449d;
    }

    .custom-file-input:lang(en)~.custom-file-label::after {
        content: "Upload";
    }

    .modal_link {
        text-decoration: underline;
        cursor: pointer;
    }

    .btn {
        display: inline-block;
        padding: 5px 15px;
        color: #fff;
        font-size: 14px;
        font-weight: 600;
        border-radius: 3px;
        transition: all 0.3s linear;
    }

    .btn-draft {
        background: #277ff5;
        border: 1px solid #277ff5;

    }

    .btn-preview {
        background: #2E2E2E;
        border: 1px solid #2E2E2E;
    }

    .btn-submit {
        background: #0066A2;
        border: 1px solid #0066A2;

    }

    .btn-draft:hover,
    .btn-preview:hover,
    .btn-submit:hover {
        background: transparent;
        color: #333;
    }


    .attested_section li {
        list-style: inside !important;
        font-size: 14px;
        font-weight: 400;
    }

    .custom-checkbox span {
        font-weight: 500;
        transition: all 0.3s;
    }

    .custom-checkbox span:hover {
        color: #33449d;
    }

    @media (max-width: 767px) {
        .admission_form img {
            max-width: 60%;
            display: block;
            margin: auto;
        }

        .header-info h1 {
            font-size: 25px;
            margin-top: 20px;
        }
    }

    .redactor_editor {
        min-height: 450px !important;
    }

    #cke_1_contents {
        min-height: 100px;
        width: 630px;
    }

    th,
    td {
        padding: 5px;
    }
</style>

<section id="report_section">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">Anesthesia Record (Time Flow)</h5>
                <small>Report / Anesthesia Record</small>
            </div>
        </div>
        {{-- @dd($anaesthetist_record_data) --}}
        <div class="anaesthetic__form">
            <form action="{{ route('operation-note-store') }}" method="post" id="OPERATIONNOTE">
                @csrf
                <input type="hidden" name="admission_id"
                    value="{{ isset($pat_info->admission_no_pk) ? $pat_info->admission_no_pk : '' }}">
                <input type="hidden" name="ref_no" value="{{ isset($ref_no) ? $ref_no : '' }}">
                <input type="hidden" name="pat_id"
                    value="{{ isset($pat_info->patient_no_pk) ? $pat_info->patient_no_pk : '' }}">
                <input type="hidden" name="ot_operation_no_pk"
                    value="{{ isset($ot_operation_note->ot_operation_no_pk) ? $ot_operation_note->ot_operation_no_pk : '' }}">
                <div class="">

                    <div class="form-row">
                        <div class="col-md-12">
                            <div class="card">
                                <!-- 1st card body -->
                                <div class="card-header text-center">
                                    <h2 class="card-title mb-0 text-left"> <strong>Patient Information</strong></h2>
                                </div>
                                <div class="col-md-2 mt-3"> <!-- ms-auto pushes to the right -->
                                    <div class="form-group d-flex align-items-center">
                                        <label for="date"
                                            class="col-form-label col-form-label-sm me-2 mb-0">Date:</label>
                                        <input type="text" class="form-control form-control-sm date_picker"
                                            id="date" name="date"
                                            value="{{ isset($ot_operation_note->ot_date) ? date('d-m-Y', strtotime($ot_operation_note->ot_date)) : '' }}"
                                            placeholder="dd-mm-YYYY" />
                                    </div>
                                </div>

                                <div class="card-body p-3">
                                    <div class="form-row" style="border: 1px solid #298949; padding: 10px;">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="regNo" class="col-form-label col-form-label-sm">
                                                    UHID
                                                </label>
                                                <input type="text" class="form-control form-control-sm"
                                                    id="regNo" name="regNo"
                                                    value="{{ isset($pat_info->patient_code) ? $pat_info->patient_code : '' }}"
                                                    placeholder="" readonly />
                                            </div>
                                        </div>
                                        {{-- <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="ippt" class="col-form-label col-form-label-sm">
                                                    IP No</label>
                                                <input type="text" class="form-control form-control-sm" readonly
                                                    id="ippt" name="ippt"
                                                    value="{{ isset($pat_info->admission_uid) ? $pat_info->admission_uid : '' }}"
                                                    placeholder="ip no" />
                                            </div>
                                        </div> --}}
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="nameOfpt" class="col-form-label col-form-label-sm">Patient
                                                    Name</label>
                                                <input type="text" class="form-control form-control-sm" readonly
                                                    id="nameOfpt" name="nameOfpt"
                                                    value="{{ isset($pat_info->patient_name) ? $pat_info->patient_name : '' }}"
                                                    placeholder="Name Of pt" />
                                            </div>
                                        </div>
                                        {{-- <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="ptBed" class="col-form-label col-form-label-sm">Bed
                                                    Category</label>
                                                <input type="text" class="form-control form-control-sm"
                                                    id="ptBed" name="ptBed"
                                                    value="{{ isset($pat_info->new_bed_name) ? $pat_info->new_bed_name : '' }}"
                                                    placeholder="" readonly />
                                            </div>
                                        </div> --}}

                                        {{-- <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="ptUnit"
                                                    class="col-form-label col-form-label-sm">Department</label>
                                                <input type="text" class="form-control form-control-sm"
                                                    id="ptUnit" name="ptUnit"
                                                    value="{{ isset($pat_info->new_su_name) ? $pat_info->new_su_name : '' }}"
                                                    placeholder="" readonly />
                                            </div>
                                        </div> --}}


                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="ptAge"
                                                    class="col-form-label col-form-label-sm">Age</label>
                                                <input type="text" class="form-control form-control-sm"
                                                    id="ptAge" name="ptAge"
                                                    value="{{ isset($pat_info->age) ? $pat_info->age : '' }}"
                                                    placeholder="45 Years" readonly />
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="ptSex"
                                                    class="col-form-label col-form-label-sm">Gender</label>
                                                <input type="text" class="form-control form-control-sm"
                                                    id="ptSex" name="ptSex"
                                                    value="{{ isset($pat_info->gender_txt) ? $pat_info->gender_txt : '' }}"
                                                    placeholder="" readonly />
                                            </div>
                                        </div>


                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="ptHeight"
                                                    class="col-form-label col-form-label-sm">Height(Cm/M)</label>
                                                <input type="text" class="form-control form-control-sm"
                                                    id="height" name="height" placeholder=""
                                                    value="{{ isset($ot_operation_note->height) ? $ot_operation_note->height : '' }}"
                                                    oninput="calculateBMI()" />
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="ptWeight"
                                                    class="col-form-label col-form-label-sm">Weight(Kg)</label>
                                                <input type="text" class="form-control form-control-sm"
                                                    id="weight" name="weight" placeholder=""
                                                    value="{{ isset($ot_operation_note->weight) ? $ot_operation_note->weight : '' }}"
                                                    oninput="calculateBMI()" />
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="ptBmi"
                                                    class="col-form-label col-form-label-sm">BMI</label>
                                                <input type="text" class="form-control form-control-sm"
                                                    id="bmi" name="bmi" placeholder=""
                                                    value="{{ isset($ot_operation_note->bmi) ? $ot_operation_note->bmi : '' }}"
                                                    readonly />
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="ptBlood" class="col-form-label col-form-label-sm">Blood
                                                    Group</label>
                                                <input type="text" class="form-control form-control-sm"
                                                    id="blood" name="blood"
                                                    value="{{ isset($pat_info->blood_group_txt) && !empty($pat_info->blood_group_txt) ? $pat_info->blood_group_txt : (isset($ot_operation_note->blood) ? $ot_operation_note->blood : '') }}"
                                                    @if (isset($pat_info->blood_group_txt) && !empty($pat_info->blood_group_txt)) readonly @endif />
                                            </div>
                                        </div>


                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="anesthesia_type"
                                                    class="col-form-label col-form-label-sm">Anesthesia Type</label>
                                                <input type="text" class="form-control form-control-sm"
                                                    id="anesthesia_type" name="anesthesia_type"
                                                    value="{{ isset($ot_operation_note->type_of_anesthesia) ? $ot_operation_note->type_of_anesthesia : '' }}" />
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="ptBed"
                                                    class="col-form-label col-form-label-sm">Consultant</label>
                                                <input type="text" class="form-control form-control-sm"
                                                    id="doctor_name" name="doctor_name" placeholder="Dr. Name"
                                                    value="{{ isset($ot_operation_note->doctor_name) ? $ot_operation_note->doctor_name : '' }}" />
                                                <input type="hidden" name="hdn_doctor_id" id="hdn_doctor_id"
                                                    value="{{ isset($ot_operation_note->doctor_no_fk) ? $ot_operation_note->doctor_no_fk : '' }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="card-body p-3">
                                    <div class="row justify-content-end">
                                        <table width="100%" border="1">


                                            <tr>
                                                <td>Hospital admission (Date & Time)</td>
                                                <td><input type="datetime-local" class="form-control"
                                                        name="admission_time" style="width: 100%;"
                                                        value="{{ isset($ot_operation_note->admission_time) ? date('Y-m-d\TH:i', strtotime($ot_operation_note->admission_time)) : '' }}" />
                                                </td>
                                                <td>Surgeon:</td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="surgeon_name" name="surgeon_name" style="width: 50%;"
                                                        placeholder="name"
                                                        value="{{ isset($ot_operation_note->surgeon_name) ? $ot_operation_note->surgeon_name : '' }}" />
                                                    <input type="hidden" name="hdn_surgeon_id" id="hdn_surgeon_id"
                                                        value="{{ isset($ot_operation_note->surgeon_no_fk) ? $ot_operation_note->surgeon_no_fk : '' }}">
                                                </td>

                                            </tr>
                                            <tr>
                                                <td>Arrive at OR (Time)</td>
                                                <td><input type="text"
                                                        class="form-control form-control timepicker "
                                                        name="arrive_time" style="width: 100%;"
                                                        value="{{ @$ot_operation_note->arrive_time ? $ot_operation_note->arrive_time : '' }}" />
                                                </td>
                                                <td colspan="2">Asst. Surgeon:</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label for="anesthesia_drop" class="form-label">
                                                        Anesthesia (Time)
                                                        <select name="anesthesia_drop"
                                                            class="form-select form-select-sm">
                                                            <option value="Induction"
                                                                @if (isset($ot_operation_note) && $ot_operation_note->anesthesia_drop == 'Induction') selected @endif>
                                                                Induction
                                                            </option>
                                                            <option value="Block"
                                                                @if (isset($ot_operation_note) && $ot_operation_note->anesthesia_drop == 'Block') selected @endif>
                                                                Block
                                                            </option>
                                                        </select>
                                                    </label>
                                                </td>

                                                <td><input type="text"
                                                        class="form-control form-control timepicker "
                                                        name="anesthesia_time" style="width: 100%;"
                                                        value="{{ @$ot_operation_note->anesthesia_time ? $ot_operation_note->anesthesia_time : '' }}" />
                                                </td>
                                                <td colspan="2">
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="assistant_surgeon_name" name="assistant_surgeon_name"
                                                        style="width: 100%;" placeholder="1."
                                                        value="{{ isset($ot_operation_note->assistant_surgeon_name) ? $ot_operation_note->assistant_surgeon_name : '' }}" />
                                                    <input type="hidden" name="assistant_surgeon_no_fk"
                                                        id="assistant_surgeon_no_fk"
                                                        value="{{ isset($ot_operation_note->assistant_surgeon_no_fk) ? $ot_operation_note->assistant_surgeon_no_fk : '' }}" />
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="assistant_2_surgeon_name" name="assistant_2_surgeon_name"
                                                        style="width: 100%;" placeholder="2."
                                                        value="{{ isset($ot_operation_note->assistant_2_surgeon_name) ? $ot_operation_note->assistant_2_surgeon_name : '' }}" />
                                                    <input type="hidden" name="assistant_2_surgeon_no_fk"
                                                        id="assistant_2_surgeon_no_fk"
                                                        value="{{ isset($ot_operation_note->assistant_2_surgeon_no_fk) ? $ot_operation_note->assistant_2_surgeon_no_fk : '' }}" />
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="assistant_surgeon3" name="assistant_surgeon3"
                                                        style="width: 100%;" placeholder="3."
                                                        value="{{ isset($ot_operation_note->assistant_surgeon3) ? $ot_operation_note->assistant_surgeon3 : '' }}" />
                                                    <input type="hidden" name="assistant_surgeon3_no_fk"
                                                        id="assistant_surgeon3_no_fk"
                                                        value="{{ isset($ot_operation_note->assistant_surgeon3_no_fk) ? $ot_operation_note->assistant_surgeon3_no_fk : '' }}" />
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="assistant_surgeon4" name="assistant_surgeon4"
                                                        style="width: 100%;" placeholder="4."
                                                        value="{{ isset($ot_operation_note->assistant_surgeon4) ? $ot_operation_note->assistant_surgeon4 : '' }}" />
                                                    <input type="hidden" name="assistant_surgeon4_no_fk"
                                                        id="assistant_surgeon4_no_fk"
                                                        value="{{ isset($ot_operation_note->assistant_surgeon4_no_fk) ? $ot_operation_note->assistant_surgeon4_no_fk : '' }}" />
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="assistant_surgeon5" name="assistant_surgeon5"
                                                        style="width: 100%;" placeholder="5."
                                                        value="{{ isset($ot_operation_note->assistant_surgeon5) ? $ot_operation_note->assistant_surgeon5 : '' }}" />
                                                    <input type="hidden" name="assistant_surgeon5_no_fk"
                                                        id="assistant_surgeon5_no_fk"
                                                        value="{{ isset($ot_operation_note->assistant_surgeon5_no_fk) ? $ot_operation_note->assistant_surgeon5_no_fk : '' }}" />
                                                </td>

                                            </tr>
                                            <tr>
                                                <td>Surgery Start (Incision) Time</td>
                                                <td><input type="text"
                                                        class="form-control form-control timepicker "
                                                        name="s_start_time" style="width: 100%;"
                                                        value="{{ @$ot_operation_note->s_start_time ? $ot_operation_note->s_start_time : '' }}" />
                                                </td>
                                                <td colspan="2">Anesthesiologist:</td>

                                            </tr>
                                            <tr>
                                                <td>Surgery Finish (Skin Close) Time</td>
                                                <td><input type="text"
                                                        class="form-control form-control timepicker "
                                                        name="s_finish_time" style="width: 100%;"
                                                        value="{{ @$ot_operation_note->s_finish_time ? $ot_operation_note->s_finish_time : '' }}" />
                                                </td>
                                                <td colspan="2">
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="assistant_3_surgeon_name" name="assistant_3_surgeon_name"
                                                        style="width: 100%;" placeholder="1."
                                                        value="{{ isset($ot_operation_note->assistant_3_surgeon_name) ? $ot_operation_note->assistant_3_surgeon_name : '' }}" />
                                                    <input type="hidden" name="assistant_3_surgeon_no_fk"
                                                        id="assistant_3_surgeon_no_fk"
                                                        value="{{ isset($ot_operation_note->assistant_3_surgeon_no_fk) ? $ot_operation_note->assistant_3_surgeon_no_fk : '' }}"><br>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="assistant_4_surgeon_name" name="assistant_4_surgeon_name"
                                                        style="width: 100%;" placeholder="2."
                                                        value="{{ isset($ot_operation_note->assistant_4_surgeon_name) ? $ot_operation_note->assistant_4_surgeon_name : '' }}" />
                                                    <input type="hidden" name="assistant_4_surgeon_no_fk"
                                                        id="assistant_4_surgeon_no_fk"
                                                        value="{{ isset($ot_operation_note->assistant_4_surgeon_no_fk) ? $ot_operation_note->assistant_4_surgeon_no_fk : '' }}">
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="anesthesiologist3" name="anesthesiologist3"
                                                        style="width: 100%;" placeholder="3."
                                                        value="{{ isset($ot_operation_note->anesthesiologist3) ? $ot_operation_note->anesthesiologist3 : '' }}" />
                                                    <input type="hidden" name="anesthesiologist3_fk"
                                                        id="anesthesiologist3_fk"
                                                        value="{{ isset($ot_operation_note->anesthesiologist3_fk) ? $ot_operation_note->anesthesiologist3_fk : '' }}">
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="anesthesiologist4" name="anesthesiologist4"
                                                        style="width: 100%;" placeholder="4."
                                                        value="{{ isset($ot_operation_note->anesthesiologist4) ? $ot_operation_note->anesthesiologist4 : '' }}" />
                                                    <input type="hidden" name="anesthesiologist4_fk"
                                                        id="anesthesiologist4_fk"
                                                        value="{{ isset($ot_operation_note->anesthesiologist4_fk) ? $ot_operation_note->anesthesiologist4_fk : '' }}">
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="anesthesiologist5" name="anesthesiologist5"
                                                        style="width: 100%;" placeholder="5."
                                                        value="{{ isset($ot_operation_note->anesthesiologist5) ? $ot_operation_note->anesthesiologist5 : '' }}" />
                                                    <input type="hidden" name="anesthesiologist5_fk"
                                                        id="anesthesiologist5_fk"
                                                        value="{{ isset($ot_operation_note->anesthesiologist5_fk) ? $ot_operation_note->anesthesiologist5_fk : '' }}">
                                                </td>

                                            </tr>
                                            <tr>
                                                <td>Baby out Time and Gender(
                                                    <select class="form-select" id="baby_gender" name="baby_gender">


                                                        <option value="Male"
                                                            {{ isset($pre_anesthetic_checkup->baby_gender) && $pre_anesthetic_checkup->baby_gender == 'Male' ? 'selected' : '' }}>
                                                            Male</option>
                                                        <option value="Female"
                                                            {{ isset($pre_anesthetic_checkup->baby_gender) && $pre_anesthetic_checkup->baby_gender == 'Female' ? 'selected' : '' }}>
                                                            Female</option>
                                                    </select>)

                                                </td>
                                                <td><input type="text" class="form-control timepicker"
                                                        name="baby_out_time" style="width: 100%;"
                                                        value="{{ @$ot_operation_note->baby_out_time ? $ot_operation_note->baby_out_time : '' }}" />
                                                </td>
                                                <td colspan="2">Technician:</td>

                                            </tr>
                                            <tr>
                                                <td>Shifting to recovery room</td>
                                                <td><input type="text" class="form-control" name="shift_room"
                                                        style="width: 100%;"
                                                        value="{{ @$ot_operation_note->shift_room ? $ot_operation_note->shift_room : '' }}" />
                                                </td>
                                                <td colspan="2">
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="technician1" name="technician1" style="width: 100%;"
                                                        placeholder="1."
                                                        value="{{ @$ot_operation_note->technician1 ? $ot_operation_note->technician1 : '' }}" />
                                                    <input type="hidden" name="technician1_no_fk"
                                                        id="technician1_no_fk"
                                                        value="{{ @$ot_operation_note->technician1_no_fk ? $ot_operation_note->technician1_no_fk : '' }}"><br>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="technician2" name="technician2" style="width: 100%;"
                                                        placeholder="2."
                                                        value="{{ @$ot_operation_note->technician2 ? $ot_operation_note->technician2 : '' }}" />
                                                    <input type="hidden" name="technician2_no_fk"
                                                        id="technician2_no_fk"
                                                        value="{{ @$ot_operation_note->technician2_no_fk ? $ot_operation_note->technician2_no_fk : '' }}" />

                                                    <input type="text" class="form-control form-control-sm"
                                                        id="technician3" name="technician3" style="width: 100%;"
                                                        placeholder="3."
                                                        value="{{ @$ot_operation_note->technician3 ? $ot_operation_note->technician3 : '' }}" />
                                                    <input type="hidden" name="technician3_fk" id="technician3_fk"
                                                        value="{{ @$ot_operation_note->technician3_fk ? $ot_operation_note->technician3_fk : '' }}" />
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="technician4" name="technician4" style="width: 100%;"
                                                        placeholder="4."
                                                        value="{{ @$ot_operation_note->technician4 ? $ot_operation_note->technician4 : '' }}" />
                                                    <input type="hidden" name="technician4_fk" id="technician4_fk"
                                                        value="{{ @$ot_operation_note->technician4_fk ? $ot_operation_note->technician4_fk : '' }}" />
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="technician5" name="technician5" style="width: 100%;"
                                                        placeholder="5."
                                                        value="{{ @$ot_operation_note->technician5 ? $ot_operation_note->technician5 : '' }}" />
                                                    <input type="hidden" name="technician5_fk" id="technician5_fk"
                                                        value="{{ @$ot_operation_note->technician5_fk ? $ot_operation_note->technician5_fk : '' }}" />



                                                </td>

                                            </tr>

                                            {{-- Staff Info --}}
                                            <tr>
                                                <td>
                                                    <label for="shift_location" class="form-label">
                                                        Shifting To (Time)
                                                        <select name="shift_location" id="shift_location"
                                                            class="form-select form-select-sm">
                                                            @php $shiftValue = old('shift_location', $ot_operation_note->shift_location ?? '') @endphp

                                                            <option value="Ward"
                                                                {{ $shiftValue == 'Ward' ? 'selected' : '' }}>Ward
                                                            </option>
                                                            <option value="Post-op ward"
                                                                {{ $shiftValue == 'Post-op ward' ? 'selected' : '' }}>
                                                                Post-op ward</option>
                                                            <option value="ICU"
                                                                {{ $shiftValue == 'ICU' ? 'selected' : '' }}>ICU
                                                            </option>
                                                            <option value="Discharge"
                                                                {{ $shiftValue == 'Discharge' ? 'selected' : '' }}>
                                                                Discharge</option>
                                                        </select>
                                                    </label>
                                                </td>

                                                <td><input type="text" class=" form-control timepicker"
                                                        name="shift_ward_time" style="width: 100%;"
                                                        value="{{ @$ot_operation_note->shift_ward_time ? $ot_operation_note->shift_ward_time : '' }}" />
                                                </td>
                                                <td colspan="2">Nurses:</td>

                                            </tr>
                                            <tr>
                                                <td>Blood Transfusion (Component & Unit)</td>
                                                <td><input type="text" id="blood_transfusion" class="form-control"
                                                        name="blood_transfusion" placeholder="e.g. PRBC - 2 units"
                                                        style="width: 100%;"
                                                        value="{{ isset($ot_operation_note->blood_transfusion) ? $ot_operation_note->blood_transfusion : '' }}" />
                                                </td>
                                                <td colspan="2">
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="nurse1" name="nurse1" style="width: 100%;"
                                                        placeholder="1."
                                                        value="{{ @$ot_operation_note->nurse1 ? $ot_operation_note->nurse1 : '' }}" />
                                                    <input type="hidden" name="nurse1_no_fk" id="nurse1_no_fk"
                                                        value="{{ @$ot_operation_note->nurse1_no_fk ? $ot_operation_note->nurse1_no_fk : '' }}" />
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="nurse2" name="nurse2" style="width: 100%;"
                                                        placeholder="2."
                                                        value="{{ @$ot_operation_note->nurse2 ? $ot_operation_note->nurse2 : '' }}" />
                                                    <input type="hidden" name="nurse2_no_fk" id="nurse2_no_fk"
                                                        value="{{ @$ot_operation_note->nurse2_no_fk ? $ot_operation_note->nurse2_no_fk : '' }}" />


                                                    <input type="text" class="form-control form-control-sm"
                                                        id="scrub_nurse" name="scrub_nurse" style="width: 100%;"
                                                        placeholder="3."
                                                        value="{{ isset($ot_operation_note->scrub_nurse_name) ? $ot_operation_note->scrub_nurse_name : '' }}" />
                                                    <input type="hidden" name="scrub_nurse_no_fk"
                                                        id="scrub_nurse_no_fk"
                                                        value="{{ isset($ot_operation_note->scrub_nurse_no_fk) ? $ot_operation_note->scrub_nurse_no_fk : '' }}">

                                                    <input type="text" class="form-control form-control-sm"
                                                        id="nurse4" name="nurse4" style="width: 100%;"
                                                        placeholder="4."
                                                        value="{{ @$ot_operation_note->nurse4 ? $ot_operation_note->nurse4 : '' }}" />
                                                    <input type="hidden" name="nurse4_fk" id="nurse4_fk"
                                                        value="{{ @$ot_operation_note->nurse4_fk ? $ot_operation_note->nurse4_fk : '' }}" />
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="nurse5" name="nurse5" style="width: 100%;"
                                                        placeholder="5."
                                                        value="{{ @$ot_operation_note->nurse5 ? $ot_operation_note->nurse5 : '' }}" />
                                                    <input type="hidden" name="nurse5_fk" id="nurse5_fk"
                                                        value="{{ @$ot_operation_note->nurse5_fk ? $ot_operation_note->nurse5_fk : '' }}" />

                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Drain (ml)</td>
                                                <td><input type="text" class="form-control" name="drain_ml"
                                                        value="{{ @$ot_operation_note->drain_ml ? $ot_operation_note->drain_ml : '' }}" />
                                                </td>
                                                <td>Urine</td>
                                                <td><input type="text" class="form-control" name="urine_output"
                                                        style="width: 50%;"
                                                        value="{{ @$ot_operation_note->urine_output ? $ot_operation_note->urine_output : '' }}" />
                                                </td>
                                            </tr>
                                        </table>

                                        <table width="100%" border="1">
                                            <tr>
                                                <td colspan="6"><strong><u>Note: Put Tick (✔) Mark as
                                                            applicable</u></strong></td>
                                            </tr>

                                            {{-- Pre-Induction Checklist --}}
                                            <tr>
                                                <td colspan="6"><strong><u>Pre-Induction Check List</u></strong>
                                                </td>
                                            </tr>
                                            @php
                                                $preInduction =
                                                    json_decode($ot_operation_note->pre_induction ?? '[]', true) ?? [];
                                            @endphp


                                            <tr>
                                                <td colspan="6">
                                                    <input type="checkbox" name="pre_induction[]"
                                                        value="Machine Check"
                                                        {{ in_array('Machine Check', $preInduction) ? 'checked' : '' }} />
                                                    Machine Check

                                                    <input type="checkbox" name="pre_induction[]"
                                                        value="Suction check"
                                                        {{ in_array('Suction check', $preInduction) ? 'checked' : '' }} />
                                                    Suction check

                                                    <input type="checkbox" name="pre_induction[]"
                                                        value="Scavenger Check"
                                                        {{ in_array('Scavenger Check', $preInduction) ? 'checked' : '' }} />
                                                    Scavenger Check

                                                    <input type="checkbox" name="pre_induction[]" value="Consent"
                                                        {{ in_array('Consent', $preInduction) ? 'checked' : '' }} />
                                                    Consent

                                                    <input type="checkbox" name="pre_induction[]"
                                                        value="PA assessment form"
                                                        {{ in_array('PA assessment form', $preInduction) ? 'checked' : '' }} />
                                                    PA assessment form

                                                    <input type="checkbox" name="pre_induction[]" value="Premed"
                                                        {{ in_array('Premed', $preInduction) ? 'checked' : '' }} />
                                                    Premed

                                                    <input type="checkbox" name="pre_induction[]"
                                                        value="Investigation"
                                                        {{ in_array('Investigation', $preInduction) ? 'checked' : '' }} />
                                                    Investigation

                                                    <input type="checkbox" name="pre_induction[]"
                                                        value="Blood available"
                                                        {{ in_array('Blood available', $preInduction) ? 'checked' : '' }} />
                                                    Blood available

                                                    <input type="checkbox" name="pre_induction[]"
                                                        value="Pressure points"
                                                        {{ in_array('Pressure points', $preInduction) ? 'checked' : '' }} />
                                                    Pressure points care
                                                </td>
                                            </tr>



                                            <tr>
                                                <td colspan="6"><strong><u>Pre-Induction Note</u></strong></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4">
                                                    <span>Patient reassessed prior to anesthesia; surgical site
                                                        verified</span>
                                                </td>
                                                <td colspan="2">
                                                    <select name="r_verified"
                                                        class="form-select form-select-sm w-auto ms-2">
                                                        <option value="Yes"
                                                            {{ @$ot_operation_note->r_verified == 'Yes' ? 'selected' : '' }}>
                                                            Yes</option>
                                                        <option value="No"
                                                            {{ @$ot_operation_note->r_verified == 'No' ? 'selected' : '' }}>
                                                            No</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="6"><strong>Preprocedural vitals</strong></td>
                                            </tr>

                                            <tr>

                                                <td>
                                                    Pulse:
                                                    <input type="text" style="width: 20%;" name="pulse"
                                                        value="{{ @$ot_operation_note->pulse ? $ot_operation_note->pulse : '' }}" />
                                                    /main

                                                </td>
                                                <td>

                                                    Resp:
                                                    <input type="text" style="width: 20%;" name="resp"
                                                        value="{{ @$ot_operation_note->resp ? $ot_operation_note->resp : '' }}" />
                                                    /min
                                                </td>
                                                <td>
                                                    SpO₂:
                                                    <input type="text" style="width: 20%;" name="spo2"
                                                        value="{{ @$ot_operation_note->spo2 ? $ot_operation_note->spo2 : '' }}" />
                                                    %
                                                </td>
                                                <td>
                                                    BP:
                                                    <input type="text" style="width: 20%;" name="bp"
                                                        value="{{ @$ot_operation_note->bp ? $ot_operation_note->bp : '' }}" />
                                                    mmHg

                                                </td>
                                                <td>
                                                    Temp:
                                                    <input type="text" style="width: 20%;" name="temp"
                                                        value="{{ @$ot_operation_note->temp ? $ot_operation_note->temp : '' }}" />
                                                    °F
                                                </td>
                                                <td>
                                                    Cough: <input type="text" style="width: 20%;" name="cough"
                                                        value="{{ @$ot_operation_note->cough ? $ot_operation_note->cough : '' }}" />
                                                    Dyspnoea: <input type="text" style="width: 20%;"
                                                        name="dyspnoea"
                                                        value="{{ @$ot_operation_note->dyspnoea ? $ot_operation_note->dyspnoea : '' }}" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong>Pre-anesthesia level of consciousness (GCS)</strong>
                                                </td>
                                                <td colspan="5">
                                                    <input type="text" class="form-control" id="procedure_done"
                                                        name="procedure_done" style="width: 100%;"
                                                        value="{{ isset($ot_operation_note->procedure_done) ? $ot_operation_note->procedure_done : '' }}" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong>NPO since (Time)</strong>
                                                </td>
                                                <td colspan="5">
                                                    <input type="text" class="timepicker" name="npo_time"
                                                        style="width: 100%;"
                                                        value="{{ @$ot_operation_note->npo_time ? $ot_operation_note->npo_time : '' }}" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="6"><strong>Pre-induction comments by attending
                                                        Anesthesiologist (If any):</strong></td>
                                            </tr>
                                            <tr>
                                                <td colspan="6">
                                                    <textarea id="pre_operative_diagnosis" class="form-control form-control" name="pre_operative_diagnosis"
                                                        cols="30" rows="2">{{ isset($ot_operation_note->pre_operative_diagnosis) ? $ot_operation_note->pre_operative_diagnosis : '' }}</textarea>
                                                </td>
                                            </tr>

                                            {{-- Anesthetic Technique --}}
                                            <tr>

                                                @php
                                                    $techniques =
                                                        json_decode($ot_operation_note->technique ?? '[]', true) ?: [];
                                                @endphp

                                                <td colspan="6">
                                                    <strong><u>Anesthetic Technique:</u></strong><br>
                                                    GA <input type="checkbox" name="technique[]" value="GA"
                                                        {{ in_array('GA', $techniques) ? 'checked' : '' }} />
                                                    Spinal <input type="checkbox" name="technique[]" value="Spinal"
                                                        {{ in_array('Spinal', $techniques) ? 'checked' : '' }} />
                                                    Epidural <input type="checkbox" name="technique[]"
                                                        value="Epidural"
                                                        {{ in_array('Epidural', $techniques) ? 'checked' : '' }} />
                                                    Nerve Block <input type="checkbox" name="technique[]"
                                                        value="Nerve Block"
                                                        {{ in_array('Nerve Block', $techniques) ? 'checked' : '' }} />
                                                    MAC <input type="checkbox" name="technique[]" value="MAC"
                                                        {{ in_array('MAC', $techniques) ? 'checked' : '' }} />
                                                    Others <input type="checkbox" name="technique[]" value="Others"
                                                        {{ in_array('Others', $techniques) ? 'checked' : '' }} />
                                                </td>



                                            </tr>

                                            {{-- Monitoring --}}
                                            <tr>
                                                <td colspan="3"><strong>Monitoring</strong></td>
                                                <td colspan="3"><strong>Positioning</strong></td>
                                            </tr>
                                            <tr>
                                                @php
                                                    $monitors =
                                                        json_decode($ot_operation_note->monitor ?? '[]', true) ?: [];
                                                @endphp
                                                <td colspan="3">
                                                    <label>
                                                        <input type="checkbox" name="monitor[]" value="ECG"
                                                            {{ in_array('ECG', $monitors) ? 'checked' : '' }}> ECG
                                                    </label>
                                                    <label>
                                                        <input type="checkbox" name="monitor[]" value="SpO2"
                                                            {{ in_array('SpO2', $monitors) ? 'checked' : '' }}> SpO₂
                                                    </label>
                                                    <label>
                                                        <input type="checkbox" name="monitor[]" value="ETCO2"
                                                            {{ in_array('ETCO2', $monitors) ? 'checked' : '' }}> ETCO₂
                                                    </label>
                                                    <label>
                                                        <input type="checkbox" name="monitor[]" value="NIBP"
                                                            {{ in_array('NIBP', $monitors) ? 'checked' : '' }}> NIBP
                                                    </label>
                                                    <label>
                                                        <input type="checkbox" name="monitor[]" value="IBP"
                                                            {{ in_array('IBP', $monitors) ? 'checked' : '' }}> IBP
                                                    </label>
                                                    <label>
                                                        <input type="checkbox" name="monitor[]" value="BIS"
                                                            {{ in_array('BIS', $monitors) ? 'checked' : '' }}> BIS
                                                    </label>
                                                </td>


                                                <td colspan="3">
                                                    <select name="position" class="form-select mb-2">
                                                        <option value="Supine"
                                                            {{ @$ot_operation_note->position == 'Supine' ? 'selected' : '' }}>
                                                            Supine</option>
                                                        <option value="Lithotomy"
                                                            {{ @$ot_operation_note->position == 'Lithotomy' ? 'selected' : '' }}>
                                                            Lithotomy</option>
                                                        <option value="Prone"
                                                            {{ @$ot_operation_note->position == 'Prone' ? 'selected' : '' }}>
                                                            Prone</option>
                                                        <option value="Lateral"
                                                            {{ @$ot_operation_note->position == 'Lateral' ? 'selected' : '' }}>
                                                            Lateral</option>
                                                    </select>

                                                    <select name="side" class="form-select mb-2">
                                                        <option value="Right"
                                                            {{ @$ot_operation_note->side == 'Right' ? 'selected' : '' }}>
                                                            Right</option>
                                                        <option value="Left"
                                                            {{ @$ot_operation_note->side == 'Left' ? 'selected' : '' }}>
                                                            Left</option>
                                                        <option value="Other"
                                                            {{ @$ot_operation_note->side == 'Other' ? 'selected' : '' }}>
                                                            Other</option>
                                                    </select>
                                                </td>

                                            </tr>
                                            <tr>
                                                <td colspan="3">

                                                    @php
                                                        $warmer =
                                                            json_decode(@$ot_operation_note->warmer ?? '[]', true) ?:
                                                            [];
                                                    @endphp

                                                    <input type="checkbox" name="warmer[]"
                                                        value="Anesthetic agents monitor"
                                                        {{ in_array('Anesthetic agents monitor', $warmer) ? 'checked' : '' }} />
                                                    Anesthetic agents monitor

                                                    <input type="checkbox" name="warmer[]" value="Warming blanket"
                                                        {{ in_array('Warming blanket', $warmer) ? 'checked' : '' }} />
                                                    Warming blanket

                                                    <input type="checkbox" name="warmer[]" value="Forced air warmer"
                                                        {{ in_array('Forced air warmer', $warmer) ? 'checked' : '' }} />
                                                    Forced air warmer

                                                    <input type="checkbox" name="warmer[]" value="Fluid warmer"
                                                        {{ in_array('Fluid warmer', $warmer) ? 'checked' : '' }} />
                                                    Fluid warmer <br>
                                                    <label for="temp_site">Temp:</label>
                                                    <select name="temp_site" id="temp_site" class="form-select mb-2">
                                                        <option value="Nasal"
                                                            {{ @$ot_operation_note->temp_site == 'Nasal' ? 'selected' : '' }}>
                                                            Nasal</option>
                                                        <option value="Skin"
                                                            {{ @$ot_operation_note->temp_site == 'Skin' ? 'selected' : '' }}>
                                                            Skin</option>
                                                        <option value="Rectal"
                                                            {{ @$ot_operation_note->temp_site == 'Rectal' ? 'selected' : '' }}>
                                                            Rectal</option>
                                                        <option value="Aural"
                                                            {{ @$ot_operation_note->temp_site == 'Aural' ? 'selected' : '' }}>
                                                            Aural</option>
                                                    </select>
                                                </td>

                                                <td colspan="2">

                                                    <label for="eye_protection">Eye Protected:</label>
                                                    <select name="eye_protection" class="form-select mb-2">
                                                        <option value="Yes"
                                                            {{ @$ot_operation_note->eye_protection == 'Yes' ? 'selected' : '' }}>
                                                            Yes</option>
                                                        <option value="No"
                                                            {{ @$ot_operation_note->eye_protection == 'No' ? 'selected' : '' }}>
                                                            No</option>
                                                    </select>&nbsp;&nbsp;&nbsp;&nbsp;

                                                    <label for="pressure_padded">Pressure Point Padded:</label>
                                                    <select name="pressure_padded" class="form-select">
                                                        <option value="Yes"
                                                            {{ @$ot_operation_note->pressure_padded == 'Yes' ? 'selected' : '' }}>
                                                            Yes</option>
                                                        <option value="No"
                                                            {{ @$ot_operation_note->pressure_padded == 'No' ? 'selected' : '' }}>
                                                            No</option>
                                                    </select>&nbsp;&nbsp;&nbsp;&nbsp;

                                                </td>
                                                <td>

                                                    <strong>Tourniquet:</strong> <br>
                                                    On time <input type="time" name="tourniquet_on"
                                                        value="{{ @$ot_operation_note->tourniquet_on ? $ot_operation_note->tourniquet_on : '' }}" />
                                                    <br> <br>
                                                    Off time <input type="time" name="tourniquet_off"
                                                        value="{{ @$ot_operation_note->tourniquet_off ? $ot_operation_note->tourniquet_off : '' }}" />



                                                </td>

                                            </tr>

                                            <tr>
                                                <td colspan="3">
                                                    @php
                                                        $ng_tube =
                                                            json_decode(@$ot_operation_note->ng_tube ?? '[]', true) ?:
                                                            [];
                                                    @endphp

                                                    <label>
                                                        <input type="checkbox" name="ng_tube[]" value="NG tube"
                                                            {{ in_array('NG tube', $ng_tube) ? 'checked' : '' }}>
                                                        NG tube
                                                    </label>

                                                    <label>
                                                        <input type="checkbox" name="ng_tube[]"
                                                            value="Urinary Catheter"
                                                            {{ in_array('Urinary Catheter', $ng_tube) ? 'checked' : '' }}>
                                                        Urinary Catheter
                                                    </label> <br> <br>
                                                    CVP Site: <input type="text" name="cvp_site"
                                                        value="{{ @$ot_operation_note->cvp_site ? $ot_operation_note->cvp_site : '' }}" />
                                                    Cannula(G):
                                                    <input type="text" name="cvp_cannula"
                                                        value="{{ @$ot_operation_note->cvp_cannula ? $ot_operation_note->cvp_cannula : '' }}" />
                                                    <br> <br>
                                                    Art Line Site: <input type="text" name="artline_site"
                                                        value="{{ @$ot_operation_note->artline_site ? $ot_operation_note->artline_site : '' }}" />
                                                    Cannula(G): <input type="text" name="artline_cannula"
                                                        value="{{ @$ot_operation_note->artline_cannula ? $ot_operation_note->artline_cannula : '' }}" />
                                                    <br>
                                                    <br>
                                                    Others: <input type="text" id="post_diagonisis"
                                                        name="post_diagonisis" placeholder=""
                                                        value="{{ isset($ot_operation_note->post_diagonisis) ? $ot_operation_note->post_diagonisis : '' }}" />
                                                </td>

                                                <td colspan="3">
                                                    <strong><u>Intubation</u></strong> <br>
                                                    <select name="intubation_state" id="intubation_state"
                                                        class="form-select form-select-sm">
                                                        <option value="Asleep"
                                                            {{ @$ot_operation_note->intubation_state == 'Asleep' ? 'selected' : '' }}>
                                                            Asleep</option>
                                                        <option value="Awake"
                                                            {{ @$ot_operation_note->intubation_state == 'Awake' ? 'selected' : '' }}>
                                                            Awake</option>
                                                        <option value="In Situ"
                                                            {{ @$ot_operation_note->intubation_state == 'In Situ' ? 'selected' : '' }}>
                                                            In Situ</option>
                                                    </select><br>

                                                    <select name="intubation_route" id="intubation_route"
                                                        class="form-select form-select-sm">
                                                        <option value="Oral"
                                                            {{ @$ot_operation_note->intubation_route == 'Oral' ? 'selected' : '' }}>
                                                            Oral</option>
                                                        <option value="Nasal"
                                                            {{ @$ot_operation_note->intubation_route == 'Nasal' ? 'selected' : '' }}>
                                                            Nasal</option>
                                                        <option value="Tracheostomy"
                                                            {{ @$ot_operation_note->intubation_route == 'Tracheostomy' ? 'selected' : '' }}>
                                                            Tracheostomy</option>
                                                    </select><br>

                                                    <select name="intubation_type" id="intubation_type"
                                                        class="form-select form-select-sm">
                                                        <option value="Direct"
                                                            {{ @$ot_operation_note->intubation_type == 'Direct' ? 'selected' : '' }}>
                                                            Direct</option>
                                                        <option value="Blind"
                                                            {{ @$ot_operation_note->intubation_type == 'Blind' ? 'selected' : '' }}>
                                                            Blind</option>
                                                        <option value="Fiberoptic"
                                                            {{ @$ot_operation_note->intubation_type == 'Fiberoptic' ? 'selected' : '' }}>
                                                            Fiberoptic</option>
                                                    </select><br>

                                                    <select name="airway_technique" id="airway_technique"
                                                        class="form-select form-select-sm">
                                                        <option value="Easy Mask Ventilation"
                                                            {{ @$ot_operation_note->airway_technique == 'Easy Mask Ventilation' ? 'selected' : '' }}>
                                                            Easy Mask Ventilation</option>
                                                        <option value="External Laryngeal Manipulation"
                                                            {{ @$ot_operation_note->airway_technique == 'External Laryngeal Manipulation' ? 'selected' : '' }}>
                                                            External Laryngeal Manipulation</option>
                                                        <option value="Stylet"
                                                            {{ @$ot_operation_note->airway_technique == 'Stylet' ? 'selected' : '' }}>
                                                            Stylet</option>
                                                        <option value="Bougie"
                                                            {{ @$ot_operation_note->airway_technique == 'Bougie' ? 'selected' : '' }}>
                                                            Bougie</option>
                                                        <option value="RSI"
                                                            {{ @$ot_operation_note->airway_technique == 'RSI' ? 'selected' : '' }}>
                                                            RSI</option>
                                                    </select><br>

                                                    <label>Intubation CL Grade (Laryngoscopy grade):</label>
                                                    <select name="cl_grade">
                                                        <option value="1"
                                                            {{ @$ot_operation_note->cl_grade == '1' ? 'selected' : '' }}>
                                                            1</option>
                                                        <option value="2"
                                                            {{ @$ot_operation_note->cl_grade == '2' ? 'selected' : '' }}>
                                                            2</option>
                                                        <option value="3"
                                                            {{ @$ot_operation_note->cl_grade == '3' ? 'selected' : '' }}>
                                                            3</option>
                                                        <option value="4"
                                                            {{ @$ot_operation_note->cl_grade == '4' ? 'selected' : '' }}>
                                                            4</option>
                                                    </select>

                                                    Secured at: <input type="text" name="secured_at"
                                                        value="{{ @$ot_operation_note->secured_at ? $ot_operation_note->secured_at : '' }}" />
                                                    cm <br>
                                                    Throat pack: <select name="throat_pack"
                                                        class="form-select form-select-sm w-auto ms-2">
                                                        <option value="Yes"
                                                            {{ @$ot_operation_note->throat_pack == 'Yes' ? 'selected' : '' }}>
                                                            Yes</option>
                                                        <option value="No"
                                                            {{ @$ot_operation_note->throat_pack == 'No' ? 'selected' : '' }}>
                                                            No</option>
                                                    </select><br>
                                                    If Yes: In time <input type="time" name="throat_in_time"
                                                        value="{{ @$ot_operation_note->throat_in_time ? $ot_operation_note->throat_in_time : '' }}" />
                                                    Out time <input type="time" name="throat_out_time"
                                                        value="{{ @$ot_operation_note->throat_out_time ? $ot_operation_note->throat_out_time : '' }}" />
                                                </td>
                                            </tr>
                                        </table>
                                        <table width="100%" border="1">
                                            <tr>
                                                <td colspan="6"><strong>Airway (Write in Size):</strong>
                                                    Mask: <input type="text" name="mask_size"
                                                        value="{{ @$ot_operation_note->mask_size ? $ot_operation_note->mask_size : '' }}" />
                                                    SGA: <input type="text" name="sga_size"
                                                        value="{{ @$ot_operation_note->sga_size ? $ot_operation_note->sga_size : '' }}" />
                                                    <label for="ett_type">ETT:</label>
                                                    <select name="ett_type" id="ett_type"
                                                        class="form-select form-select-sm">
                                                        <option value="Cuffed"
                                                            {{ @$ot_operation_note->ett_type == 'Cuffed' ? 'selected' : '' }}>
                                                            Cuffed</option>
                                                        <option value="Non-Cuffed"
                                                            {{ @$ot_operation_note->ett_type == 'Non-Cuffed' ? 'selected' : '' }}>
                                                            Non-Cuffed</option>
                                                        <option value="Reinforced"
                                                            {{ @$ot_operation_note->ett_type == 'Reinforced' ? 'selected' : '' }}>
                                                            Reinforced</option>
                                                    </select>

                                                    Tracheostomy: <input type="text" name="tracheostomy"
                                                        value="{{ @$ot_operation_note->tracheostomy ? $ot_operation_note->tracheostomy : '' }}" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="6">
                                                    <strong>Breathing System:</strong>
                                                    <select name="breathing_system" id="breathing_system"
                                                        class="form-select form-select-sm">
                                                        <option value="Circle"
                                                            {{ @$ot_operation_note->breathing_system == 'Circle' ? 'selected' : '' }}>
                                                            Circle</option>
                                                        <option value="Bain's"
                                                            {{ @$ot_operation_note->breathing_system == "Bain's" ? 'selected' : '' }}>
                                                            Bain's</option>
                                                        <option value="Ayre’s T Piece (modified)"
                                                            {{ @$ot_operation_note->breathing_system == 'Ayre’s T Piece (modified)' ? 'selected' : '' }}>
                                                            Ayre’s T Piece (modified)</option>
                                                        <option value="O2 Supplement only"
                                                            {{ @$ot_operation_note->breathing_system == 'O2 Supplement only' ? 'selected' : '' }}>
                                                            O<sub>2</sub> Supplement only</option>
                                                    </select>
                                            </tr>
                                            <tr>
                                                <td colspan="6">
                                                    <strong>Ventilation:</strong>
                                                    <select name="ventilation" id="ventilation"
                                                        class="form-select form-select-sm">
                                                        <option value="Controlled (manual)"
                                                            {{ @$ot_operation_note->ventilation == 'Controlled (manual)' ? 'selected' : '' }}>
                                                            Controlled (manual)</option>
                                                        <option value="Ventilator"
                                                            {{ @$ot_operation_note->ventilation == 'Ventilator' ? 'selected' : '' }}>
                                                            Ventilator</option>
                                                        <option value="Spontaneous"
                                                            {{ @$ot_operation_note->ventilation == 'Spontaneous' ? 'selected' : '' }}>
                                                            Spontaneous</option>
                                                        <option value="HFV"
                                                            {{ @$ot_operation_note->ventilation == 'HFV' ? 'selected' : '' }}>
                                                            HFV</option>
                                                        <option value="Jet Ventilation"
                                                            {{ @$ot_operation_note->ventilation == 'Jet Ventilation' ? 'selected' : '' }}>
                                                            Jet Ventilation</option>
                                                    </select>
                                                </td>

                                            </tr>
                                            <tr>
                                                @php
                                                    $gases =
                                                        json_decode(@$ot_operation_note->gases ?? '[]', true) ?: [];
                                                    $volatile_agents =
                                                        json_decode(
                                                            @$ot_operation_note->volatile_agents ?? '[]',
                                                            true,
                                                        ) ?:
                                                        [];
                                                @endphp

                                                <td colspan="3">
                                                    <strong>Gases</strong><br>
                                                    <label>
                                                        <input type="checkbox" name="gases[]" value="O2"
                                                            {{ in_array('O2', $gases) ? 'checked' : '' }}>
                                                        O<sub>2</sub>
                                                    </label>
                                                    <label>
                                                        <input type="checkbox" name="gases[]" value="N2O"
                                                            {{ in_array('N2O', $gases) ? 'checked' : '' }}>
                                                        N<sub>2</sub>O
                                                    </label>
                                                    <label>
                                                        <input type="checkbox" name="gases[]" value="Air"
                                                            {{ in_array('Air', $gases) ? 'checked' : '' }}>
                                                        Air
                                                    </label>
                                                </td>

                                                <td colspan="3">
                                                    <strong>Volatile agents</strong><br>
                                                    <label>
                                                        <input type="checkbox" name="volatile_agents[]"
                                                            value="Sevoflurane"
                                                            {{ in_array('Sevoflurane', $volatile_agents) ? 'checked' : '' }}>
                                                        Sevoflurane
                                                    </label>
                                                    <label>
                                                        <input type="checkbox" name="volatile_agents[]"
                                                            value="Isoflurane"
                                                            {{ in_array('Isoflurane', $volatile_agents) ? 'checked' : '' }}>
                                                        Isoflurane
                                                    </label>
                                                    <label>
                                                        <input type="checkbox" name="volatile_agents[]"
                                                            value="Others"
                                                            {{ in_array('Others', $volatile_agents) ? 'checked' : '' }}>
                                                        Others
                                                    </label>
                                                </td>



                                            </tr>
                                            <tr>
                                                <td colspan="3"><strong>Regional Technique One</strong></td>
                                                <td colspan="3"><strong>Regional Technique Two</strong><br /></td>
                                            </tr>
                                            <tr>
                                                <td colspan="3">Type: <input type="text" name="regional1_type"
                                                        value="{{ @$ot_operation_note->regional1_type ? $ot_operation_note->regional1_type : '' }}" />
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    <select name="regional1_drop" class="form-select form-select-sm">
                                                        <option value="Site"
                                                            {{ @$ot_operation_note->regional1_drop == 'Site' ? 'selected' : '' }}>
                                                            Site:</option>
                                                        <option value="Approach"
                                                            {{ @$ot_operation_note->regional1_drop == 'Approach' ? 'selected' : '' }}>
                                                            Approach:</option>
                                                    </select> <input type="text" name="regional1_site"
                                                        value="{{ @$ot_operation_note->regional1_site ? $ot_operation_note->regional1_site : '' }}" />

                                                </td>
                                                <td colspan="3">Type: <input type="text" name="regional2_type"
                                                        value="{{ @$ot_operation_note->regional2_type ? $ot_operation_note->regional2_type : '' }}" />
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    <select name="regional2_drop" class="form-select form-select-sm">
                                                        <option value="Site"
                                                            {{ @$ot_operation_note->regional2_drop == 'Site' ? 'selected' : '' }}>
                                                            Site:</option>
                                                        <option value="Approach"
                                                            {{ @$ot_operation_note->regional2_drop == 'Approach' ? 'selected' : '' }}>
                                                            Approach:</option>
                                                    </select> <input type="text" name="regional2_site"
                                                        value="{{ @$ot_operation_note->regional2_site ? $ot_operation_note->regional2_site : '' }}" />
                                                </td>

                                            </tr>
                                            <tr>
                                                <td colspan="3">
                                                    Needle: <input type="text" name="regional1_needle"
                                                        value="{{ @$ot_operation_note->regional1_needle ? $ot_operation_note->regional1_needle : '' }}" />
                                                    Gauge: <input type="text" name="regional1_gauge"
                                                        value="{{ @$ot_operation_note->regional1_gauge ? $ot_operation_note->regional1_gauge : '' }}" />

                                                </td>
                                                <td colspan="3">
                                                    Needle: <input type="text" name="regional2_needle"
                                                        value="{{ @$ot_operation_note->regional2_needle ? $ot_operation_note->regional2_needle : '' }}" />
                                                    Gauge: <input type="text" name="regional2_gauge"
                                                        value="{{ @$ot_operation_note->regional2_gauge ? $ot_operation_note->regional2_gauge : '' }}" />
                                                </td>

                                            </tr>
                                            <tr>
                                                <td colspan="3">
                                                    <select name="regional1_shot" id="regional1_shot"
                                                        class="form-select form-select-sm">
                                                        <option value="Single Shot"
                                                            {{ @$ot_operation_note->regional1_shot == 'Single Shot' ? 'selected' : '' }}>
                                                            Single Shot</option>
                                                        <option value="Catheter"
                                                            {{ @$ot_operation_note->regional1_shot == 'Catheter' ? 'selected' : '' }}>
                                                            Catheter</option>
                                                    </select> &nbsp;&nbsp;&nbsp;&nbsp;
                                                    <label for="regional1_stimulator" class="form-label">Nerve
                                                        Stimulator:</label>
                                                    <select name="regional1_stimulator" id="regional1_stimulator"
                                                        class="form-select form-select-sm">
                                                        <option value="Yes"
                                                            {{ @$ot_operation_note->regional1_stimulator == 'Yes' ? 'selected' : '' }}>
                                                            Yes</option>
                                                        <option value="No"
                                                            {{ @$ot_operation_note->regional1_stimulator == 'No' ? 'selected' : '' }}>
                                                            No</option>
                                                    </select> &nbsp;&nbsp;&nbsp;&nbsp;
                                                    <label for="regional1_ultrasound" class="form-label">Ultrasound
                                                        Guided:</label>
                                                    <select name="regional1_ultrasound" id="regional1_ultrasound"
                                                        class="form-select form-select-sm">
                                                        <option value="Yes"
                                                            {{ @$ot_operation_note->regional1_ultrasound == 'Yes' ? 'selected' : '' }}>
                                                            Yes</option>
                                                        <option value="No"
                                                            {{ @$ot_operation_note->regional1_ultrasound == 'No' ? 'selected' : '' }}>
                                                            No</option>
                                                    </select>

                                                </td>
                                                <td colspan="3">
                                                    <select name="regional2_shot" id="regional2_shot"
                                                        class="form-select form-select-sm">
                                                        <option value="Single Shot"
                                                            {{ @$ot_operation_note->regional2_shot == 'Single Shot' ? 'selected' : '' }}>
                                                            Single Shot</option>
                                                        <option value="Catheter"
                                                            {{ @$ot_operation_note->regional2_shot == 'Catheter' ? 'selected' : '' }}>
                                                            Catheter</option>
                                                    </select>&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <label for="regional2_stimulator" class="form-label">Nerve
                                                        Stimulator:</label>
                                                    <select name="regional2_stimulator" id="regional2_stimulator"
                                                        class="form-select form-select-sm">
                                                        <option value="Yes"
                                                            {{ @$ot_operation_note->regional2_stimulator == 'Yes' ? 'selected' : '' }}>
                                                            Yes</option>
                                                        <option value="No"
                                                            {{ @$ot_operation_note->regional2_stimulator == 'No' ? 'selected' : '' }}>
                                                            No</option>
                                                    </select> &nbsp;&nbsp;&nbsp;&nbsp;
                                                    <label for="regional2_ultrasound" class="form-label">Ultrasound
                                                        Guided:</label>
                                                    <select name="regional2_ultrasound" id="regional2_ultrasound"
                                                        class="form-select form-select-sm">
                                                        <option value="Yes"
                                                            {{ @$ot_operation_note->regional2_ultrasound == 'Yes' ? 'selected' : '' }}>
                                                            Yes</option>
                                                        <option value="No"
                                                            {{ @$ot_operation_note->regional2_ultrasound == 'No' ? 'selected' : '' }}>
                                                            No</option>
                                                    </select>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3">

                                                    Drugs:
                                                    <textarea class="form-control" id="regional1_drugs" name="regional1_drugs" rows="3">{{ @$ot_operation_note->regional1_drugs ? $ot_operation_note->regional1_drugs : '' }}</textarea>

                                                    <br>
                                                    <label for="regional1_assessment"
                                                        class="form-label">Assessment</label>
                                                    <select name="regional1_assessment" id="regional1_assessment"
                                                        class="form-select form-select-sm">
                                                        <option value="Complete"
                                                            {{ @$ot_operation_note->regional1_assessment == 'Complete' ? 'selected' : '' }}>
                                                            Complete</option>
                                                        <option value="Partial"
                                                            {{ @$ot_operation_note->regional1_assessment == 'Partial' ? 'selected' : '' }}>
                                                            Partial</option>
                                                        <option value="Failed"
                                                            {{ @$ot_operation_note->regional1_assessment == 'Failed' ? 'selected' : '' }}>
                                                            Failed</option>
                                                    </select><br />
                                                    Comments: <input type="text"
                                                        class="form-control form-control-sm" id="prosthesis"
                                                        name="prosthesis" placeholder=""
                                                        value="{{ isset($ot_operation_note->prosthesis) ? $ot_operation_note->prosthesis : '' }}" />
                                                </td>
                                                <td colspan="3">
                                                    Drugs:
                                                    <textarea class="form-control" id="regional2_drugs" name="regional2_drugs" rows="3">{{ @$ot_operation_note->regional2_drugs ? $ot_operation_note->regional2_drugs : '' }}</textarea>

                                                    <br>
                                                    <label for="regional2_assessment"
                                                        class="form-label">Assessment</label>
                                                    <select name="regional2_assessment" id="regional2_assessment"
                                                        class="form-select form-select-sm">
                                                        <option value="Complete"
                                                            {{ @$ot_operation_note->regional2_assessment == 'Complete' ? 'selected' : '' }}>
                                                            Complete</option>
                                                        <option value="Partial"
                                                            {{ @$ot_operation_note->regional2_assessment == 'Partial' ? 'selected' : '' }}>
                                                            Partial</option>
                                                        <option value="Failed"
                                                            {{ @$ot_operation_note->regional2_assessment == 'Failed' ? 'selected' : '' }}>
                                                            Failed</option>
                                                    </select><br />
                                                    Comments: <input type="text"
                                                        class="form-control form-control-sm" id="special_note"
                                                        name="special_note" placeholder=""
                                                        value="{{ isset($ot_operation_note->special_note) ? $ot_operation_note->special_note : '' }}" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="6"><strong><u>Drugs Used (in units- ml/mg
                                                            etc.)</u></strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Induction agent</td>
                                                <td><input type="text" name="induction_agent"
                                                        value="{{ @$ot_operation_note->induction_agent ? $ot_operation_note->induction_agent : '' }}" />
                                                </td>
                                                <td>Anxiolytic</td>
                                                <td><input type="text" name="anxiolytic"
                                                        value="{{ @$ot_operation_note->anxiolytic ? $ot_operation_note->anxiolytic : '' }}" />
                                                </td>
                                                <td>Analgesic</td>
                                                <td><input type="text" name="analgesic"
                                                        value="{{ @$ot_operation_note->analgesic ? $ot_operation_note->analgesic : '' }}" />
                                                </td>

                                            </tr>
                                            <tr>
                                                <td>Muscle relaxant</td>
                                                <td><input type="text" name="muscle_relaxant"
                                                        value="{{ @$ot_operation_note->muscle_relaxant ? $ot_operation_note->muscle_relaxant : '' }}" />
                                                </td>
                                                <td>Reversal agent</td>
                                                <td><input type="text" name="reversal_agent"
                                                        value="{{ @$ot_operation_note->reversal_agent ? $ot_operation_note->reversal_agent : '' }}" />
                                                </td>
                                                <td>Other drugs</td>
                                                <td><input type="text" name="other_drugs"
                                                        value="{{ @$ot_operation_note->other_drugs ? $ot_operation_note->other_drugs : '' }}" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Crystalloid fluid</td>
                                                <td><input type="text" name="crystalloid"
                                                        value="{{ @$ot_operation_note->crystalloid ? $ot_operation_note->crystalloid : '' }}" />
                                                </td>
                                                <td>Colloid fluid</td>
                                                <td><input type="text" name="colloid"
                                                        value="{{ @$ot_operation_note->colloid ? $ot_operation_note->colloid : '' }}" />
                                                </td>
                                                <td>Blood product</td>
                                                <td><input type="text" name="blood_product"
                                                        value="{{ @$ot_operation_note->blood_product ? $ot_operation_note->blood_product : '' }}" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Urine</td>
                                                <td><input type="text" name="urine"
                                                        value="{{ @$ot_operation_note->urine ? $ot_operation_note->urine : '' }}" />
                                                </td>
                                                <td>Blood loss</td>
                                                <td><input type="text" name="blood_loss"
                                                        value="{{ @$ot_operation_note->blood_loss ? $ot_operation_note->blood_loss : '' }}" />
                                                </td>
                                                <td colspan="2"></td>
                                            </tr>
                                        </table>

                                        <table width="100%" border="1">
                                            <tr>
                                                <td colspan="6"><strong><u>Anesthetic Events (Including Baby
                                                            note)</u></strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="6">
                                                    <textarea id="incision_ports" class="form-control form-control" name="incision_ports" cols="30"
                                                        rows="4">{{ isset($ot_operation_note->incision_ports) ? $ot_operation_note->incision_ports : '' }}</textarea>
                                                </td>

                                            </tr>


                                        </table>

                                        <table width="100%" border="1">
                                            <tr>
                                                <td colspan="6"><strong><u>Condition on Leaving OR</u></strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="6">
                                                    <strong>Airway Device:</strong>
                                                    <select name="leaving"
                                                        class="form-select form-select-sm w-auto d-inline-block ms-2">
                                                        <option value="Nil"
                                                            {{ @$ot_operation_note->leaving == 'Nil' ? 'selected' : '' }}>
                                                            Nil</option>
                                                        <option value="Oral"
                                                            {{ @$ot_operation_note->leaving == 'Oral' ? 'selected' : '' }}>
                                                            Oral</option>
                                                        <option value="Nasal"
                                                            {{ @$ot_operation_note->leaving == 'Nasal' ? 'selected' : '' }}>
                                                            Nasal</option>
                                                        <option value="LMA"
                                                            {{ @$ot_operation_note->leaving == 'LMA' ? 'selected' : '' }}>
                                                            LMA</option>
                                                        <option value="OETT"
                                                            {{ @$ot_operation_note->leaving == 'OETT' ? 'selected' : '' }}>
                                                            OETT</option>
                                                        <option value="NETT"
                                                            {{ @$ot_operation_note->leaving == 'NETT' ? 'selected' : '' }}>
                                                            NETT</option>
                                                        <option value="Tracheostomy"
                                                            {{ @$ot_operation_note->leaving == 'Tracheostomy' ? 'selected' : '' }}>
                                                            Tracheostomy</option>
                                                    </select>
                                                </td>
                                            </tr>



                                            <tr>
                                                <td colspan="6">
                                                    <strong>Respiration:</strong>
                                                    <select name="respiration"
                                                        class="form-select form-select-sm w-auto d-inline-block ms-2">
                                                        <option value="Spontaneous"
                                                            {{ @$ot_operation_note->respiration == 'Spontaneous' ? 'selected' : '' }}>
                                                            Spontaneous</option>
                                                        <option value="Assisted"
                                                            {{ @$ot_operation_note->respiration == 'Assisted' ? 'selected' : '' }}>
                                                            Assisted</option>
                                                        <option value="Mechanical"
                                                            {{ @$ot_operation_note->respiration == 'Mechanical' ? 'selected' : '' }}>
                                                            Mechanical</option>
                                                    </select>
                                                </td>
                                            </tr>



                                        </table>

                                        <table width="100%" border="1">
                                            <tr>

                                                <td colspan="3">
                                                    <strong>Anesthesia Technician:</strong>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="assistant_anesthesiologist_name"
                                                        name="assistant_anesthesiologist_name"
                                                        value="{{ isset($ot_operation_note->ass_anesthesiologist_name) ? $ot_operation_note->ass_anesthesiologist_name : '' }}" />
                                                    <input type="hidden" name="assistant_anesthesiologist_no_fk"
                                                        id="assistant_anesthesiologist_no_fk"
                                                        value="{{ isset($ot_operation_note->assistant_anesthesiologist_no) ? $ot_operation_note->assistant_anesthesiologist_no : '' }}">

                                                </td>
                                                <td colspan="3">
                                                    <strong>Anesthesiologist:</strong><input type="text"
                                                        class="form-control form-control-sm"
                                                        id="anesthesiologist_name" name="anesthesiologist_name"
                                                        value="{{ isset($ot_operation_note->anesthesiologist_name) ? $ot_operation_note->anesthesiologist_name : '' }}" />
                                                    <input type="hidden" name="anesthesiologist_no_fk"
                                                        id="anesthesiologist_no_fk"
                                                        value="{{ isset($ot_operation_note->anesthesiologist_no_fk) ? $ot_operation_note->anesthesiologist_no_fk : '' }}">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="6">

                                                    <strong>Pedistrician name:</strong>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="assistant_2_anesthesiologist_name"
                                                        name="assistant_2_anesthesiologist_name"
                                                        value="{{ isset($ot_operation_note->ass2_anesthesiologist_name) ? $ot_operation_note->ass2_anesthesiologist_name : '' }}" />
                                                    <input type="hidden" name="assistant_2_anesthesiologist_no_fk"
                                                        id="assistant_2_anesthesiologist_no_fk"
                                                        value="{{ isset($ot_operation_note->ass2_anesthesiologist_no_fk) ? $ot_operation_note->ass2_anesthesiologist_no_fk : '' }}">
                                                </td>

                                            </tr>
                                        </table>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    @php
                        $redirect_url = route('ipd.operation-note-form', [$pat_info->patient_no_pk, $ref_no]);
                    @endphp
                    <button type="submit" class="btn btn-success btn-lg m-3 float-right"
                        onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $redirect_url }}')">Save</button>
                </div>
            </form>
        </div>
    </div>
</section>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('asset/timepicker/js/timepicker.js') }}"></script>
<script type="text/javascript">
    openDoctorAutocomplete('#doctor_name', 'hdn_doctor_id', 'doctor_ind', '1,2');
    openDoctorAutocomplete('#surgeon_name', 'hdn_surgeon_id', 'doctor_ind', '1,2');

    openDoctorAutocomplete('#assistant_surgeon_name', 'assistant_surgeon_no_fk', 'doctor_ind', '1,2');
    openDoctorAutocomplete('#assistant_2_surgeon_name', 'assistant_2_surgeon_no_fk', 'doctor_ind', '1,2');
    openDoctorAutocomplete('#assistant_3_surgeon_name', 'assistant_3_surgeon_no_fk', 'doctor_ind', '1,2');
    openDoctorAutocomplete('#assistant_4_surgeon_name', 'assistant_4_surgeon_no_fk', 'doctor_ind', '1,2');

    openDoctorAutocomplete('#anesthesiologist_name', 'anesthesiologist_no_fk', 'doctor_ind', '1,2');
    openDoctorAutocomplete('#assistant_anesthesiologist_name', 'assistant_anesthesiologist_no_fk', 'doctor_ind', '1,2');
    openDoctorAutocomplete('#assistant_2_anesthesiologist_name', 'assistant_2_anesthesiologist_no_fk', 'doctor_ind',
        '1,2');
    openDoctorAutocomplete('#assistant_2_anesthesiologist_name', 'assistant_2_anesthesiologist_no_fk', 'doctor_ind',
        '1,2');
    openDoctorAutocomplete('#scrub_nurse', 'scrub_nurse_no_fk');
    openDoctorAutocomplete('#technician1', 'technician1_no_fk', 'doctor_ind', '1,2');
    openDoctorAutocomplete('#technician2', 'technician2_no_fk', 'doctor_ind', '1,2');
    openDoctorAutocomplete('#nurse1', 'nurse1_no_fk', 'doctor_ind', '1,2');
    openDoctorAutocomplete('#nurse2', 'nurse2_no_fk', 'doctor_ind', '1,2');

    openDoctorAutocomplete('#assistant_surgeon3', 'assistant_surgeon3_no_fk', 'doctor_ind', '1,2');
    openDoctorAutocomplete('#assistant_surgeon4', 'assistant_surgeon4_no_fk', 'doctor_ind', '1,2');
    openDoctorAutocomplete('#assistant_surgeon5', 'assistant_surgeon5_no_fk', 'doctor_ind', '1,2');
    openDoctorAutocomplete('#anesthesiologist3', 'anesthesiologist3_fk', 'doctor_ind', '1,2');
    openDoctorAutocomplete('#anesthesiologist4', 'anesthesiologist4_fk', 'doctor_ind', '1,2');
    openDoctorAutocomplete('#anesthesiologist5', 'anesthesiologist5_fk', 'doctor_ind', '1,2');
    openDoctorAutocomplete('#technician3', 'technician3_fk', 'doctor_ind', '1,2');
    openDoctorAutocomplete('#technician4', 'technician4_fk', 'doctor_ind', '1,2');
    openDoctorAutocomplete('#technician5', 'technician5_fk', 'doctor_ind', '1,2');
    openDoctorAutocomplete('#nurse4', 'nurse4_fk', 'doctor_ind', '1,2');
    openDoctorAutocomplete('#nurse5', 'nurse5_fk', 'doctor_ind', '1,2');





    $(function() {
        $('.date_picker').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            endDate: '+0d',
            'format': 'dd-mm-yyyy'
        });
        $('.timepicker').timepicker({
            // showInputs: false,
            // showMeridian: false,
            // setTime: null

        });

    });
    var editor = CKEDITOR.replace('editor1', {
        tabSpaces: 4
    });
    var editor2 = CKEDITOR.replace('editor2', {
        tabSpaces: 4
    });
    var editor3 = CKEDITOR.replace('editor3', {
        tabSpaces: 4
    });

    editor.on('change', function(evt) {
        $('#editor_content').val(evt.editor.getData())
    });
    editor2.on('change', function(evt) {
        $('#editor_content2').val(evt.editor.getData())
    });
    editor3.on('change', function(evt) {
        $('#editor_content3').val(evt.editor.getData())
    });

    function calculateBMI() {
        let height = parseFloat(document.getElementById('height').value);
        let weight = parseFloat(document.getElementById('weight').value);

        if (!isNaN(height) && !isNaN(weight) && height > 0) {
            // If height given in cm, convert to meters
            if (height > 3) {
                height = height / 100;
            }
            const bmi = weight / (height * height);
            document.getElementById('bmi').value = bmi.toFixed(2);
        } else {
            document.getElementById('bmi').value = '';
        }
    }
</script>
