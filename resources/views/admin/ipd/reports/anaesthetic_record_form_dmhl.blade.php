<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link href="{{ asset('css/redactor.css') }}" rel="stylesheet">
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
        max-height: 70px;
        width: 630px;
    }

    th,
    td {
        padding: 5px;
    }
</style>
<section id="create_lookup">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
            <div class="col-md-12">
                <div class="float-left">
                    <h5 class="mt-2 mb-0">Anaesthetic Record</h5>
                    <small>Report / Anaesthetic Record</small>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body mt-2">
                <div class="row">
                    <div class="container-fluid">
                        {{-- @dd($anaesthetist_record_data) --}}
                        <div class="anaesthetic__form">
                            <form action="{{ route('anaesthetic-record-store') }}" method="post"
                                id="ANAESTHETICRECORD">
                                @csrf
                                <input type="hidden" name="admission_id"
                                    value="{{ isset($pat_info->admission_no_pk) ? $pat_info->admission_no_pk : '' }}">
                                <input type="hidden" name="pat_id"
                                    value="{{ isset($pat_info->patient_no_pk) ? $pat_info->patient_no_pk : '' }}">
                                <input type="hidden" name="anaesthetic_no_pk"
                                    value="{{ isset($anaesthetist_record_data->anaesthetic_no_pk) ? $anaesthetist_record_data->anaesthetic_no_pk : '' }}">
                                <div class="">
                                    <div class="form-row">
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="form-row">
                                                    <div class="col-md-12">
                                                        <div class="card">
                                                            <!-- 1st card body -->
                                                            <div class="card-header text-center">
                                                                <h2 class="card-title mb-0 text-left"> <strong> Patient
                                                                        Info</strong>
                                                                </h2>
                                                            </div>
                                                            <div class="card-body p-3">
                                                                <div class="form-row"
                                                                    style="border: 1px solid #298949; padding: 10px;">
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label for="nameOfpt"
                                                                                class="col-form-label col-form-label-sm">Name
                                                                                of
                                                                                pt</label>
                                                                            <input type="text"
                                                                                class="form-control form-control-sm"
                                                                                readonly id="nameOfpt" name="nameOfpt"
                                                                                value="{{ isset($pat_info->patient_name) ? $pat_info->patient_name : '' }}"
                                                                                placeholder="Name Of pt" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <div class="form-group">
                                                                            <label for="regNo"
                                                                                class="col-form-label col-form-label-sm">Patient
                                                                                Id</label>
                                                                            <input type="text"
                                                                                class="form-control form-control-sm"
                                                                                id="regNo" name="regNo"
                                                                                value="{{ isset($pat_info->patient_code) ? $pat_info->patient_code : '' }}"
                                                                                placeholder="" readonly />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <div class="form-group">
                                                                            <label for="ptAge"
                                                                                class="col-form-label col-form-label-sm">Age</label>
                                                                            <input type="text"
                                                                                class="form-control form-control-sm"
                                                                                id="ptAge" name="ptAge"
                                                                                value="{{ isset($pat_info->age) ? $pat_info->age : '' }}"
                                                                                placeholder="45 Years" readonly />
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-2">
                                                                        <div class="form-group">
                                                                            <label for="ptSex"
                                                                                class="col-form-label col-form-label-sm">Sex</label>
                                                                            <input type="text"
                                                                                class="form-control form-control-sm"
                                                                                id="ptSex" name="ptSex"
                                                                                value="{{ isset($pat_info->gender_txt) ? $pat_info->gender_txt : '' }}"
                                                                                placeholder="" readonly />
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-2">
                                                                        <div class="form-group">
                                                                            <label for="ptUnit"
                                                                                class="col-form-label col-form-label-sm">Department</label>
                                                                            <input type="text"
                                                                                class="form-control form-control-sm"
                                                                                id="ptUnit" name="ptUnit"
                                                                                value="{{ isset($pat_info->new_su_name) ? $pat_info->new_su_name : '' }}"
                                                                                placeholder="" readonly />
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-2">
                                                                        <div class="form-group">
                                                                            <label for="ptWard"
                                                                                class="col-form-label col-form-label-sm">Ward</label>
                                                                            <input type="text"
                                                                                class="form-control form-control-sm"
                                                                                id="ptWard" name="ptWard"
                                                                                value="{{ isset($pat_info->new_ward_name) ? $pat_info->new_ward_name : '' }}"
                                                                                placeholder="" readonly />
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-2">
                                                                        <div class="form-group">
                                                                            <label for="ptBed"
                                                                                class="col-form-label col-form-label-sm">Bed</label>
                                                                            <input type="text"
                                                                                class="form-control form-control-sm"
                                                                                id="ptBed" name="ptBed"
                                                                                value="{{ isset($pat_info->new_bed_name) ? $pat_info->new_bed_name : '' }}"
                                                                                placeholder="" readonly />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <div class="form-group">
                                                                            <label for="date"
                                                                                class="col-form-label col-form-label-sm">Date</label>
                                                                            <input type="text"
                                                                                class="form-control form-control-sm date_picker"
                                                                                id="date" name="date"
                                                                                value="{{ isset($pre_anesthetic_checkup->ot_date) ? date('d-m-Y', strtotime($pre_anesthetic_checkup->ot_date)) : '' }}"
                                                                                placeholder="dd-mm-YYYY" />
                                                                        </div>
                                                                    </div>
                                                                    {{-- <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label for="ptBed"
                                                                                class="col-form-label col-form-label-sm">Referred Doctor</label>
                                                                            <input type="text" class="form-control form-control-sm"
                                                                                id="doctor_name" name="doctor_name"
                                                                                placeholder="Dr. Name"
                                                                                value="{{ isset($pre_anesthetic_checkup->doctor_name) ? $pre_anesthetic_checkup->doctor_name : '' }}" />
                                                                            <input type="hidden" name="hdn_doctor_id"
                                                                                id="hdn_doctor_id"
                                                                                value="{{ isset($pre_anesthetic_checkup->doctor_no_fk) ? $pre_anesthetic_checkup->doctor_no_fk : '' }}">
                                                                        </div>
                                                                    </div> --}}


                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label for="ptBed"
                                                                                class="col-form-label col-form-label-sm">Referred
                                                                                Doctor</label>
                                                                            <input type="text"
                                                                                class="form-control form-control-sm"
                                                                                id="doctor_name" name="doctor_name"
                                                                                placeholder="Dr. Name"
                                                                                value="{{ isset($pat_info->primary_doctor_name) ? $pat_info->primary_doctor_name : '' }}" />
                                                                            <input type="hidden" name="hdn_doctor_id"
                                                                                id="hdn_doctor_id"
                                                                                value="{{ isset($pat_info->primary_doctor_no_fk) ? $pat_info->primary_doctor_no_fk : '' }}">


                                                                        </div>
                                                                    </div>


                                                                </div>
                                                            </div>
                                                            <!-- 1st card body -->
                                                            <!-- 2nd card body -->

                                                            <div class="card-body p-3">
                                                                <h3 class="mb-0"><strong>Pre Induction Checklist
                                                                        :</strong></h3>
                                                                <div class="card-body p-3">
                                                                    <div class="form-row">
                                                                        <!-- Consent Section -->
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label for="consent"
                                                                                    class="col-form-label col-form-label-sm">Consent</label>
                                                                                <div>
                                                                                    <input type="radio"
                                                                                        value="Yes" name="consent"
                                                                                        id="consent"
                                                                                        {{ isset($pre_anesthetic_checkup->consent) && $pre_anesthetic_checkup->consent == '1' ? 'checked' : '' }}>
                                                                                    Yes
                                                                                    <input type="radio"
                                                                                        value="No" name="consent"
                                                                                        id="consent"
                                                                                        {{ isset($pre_anesthetic_checkup->consent) && $pre_anesthetic_checkup->consent == '2' ? 'checked' : '' }}>
                                                                                    No
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <!-- Fasting Section -->
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label for="fasting"
                                                                                    class="col-form-label col-form-label-sm">Fasting</label>
                                                                                <div>
                                                                                    <input type="radio"
                                                                                        value="Yes" name="fasting"
                                                                                        id="fasting"
                                                                                        {{ isset($pre_anesthetic_checkup->fasting) && $pre_anesthetic_checkup->fasting == '1' ? 'checked' : '' }}>
                                                                                    Yes
                                                                                    <input type="radio"
                                                                                        value="No" name="fasting"
                                                                                        id="fasting"
                                                                                        {{ isset($pre_anesthetic_checkup->fasting) && $pre_anesthetic_checkup->fasting == '2' ? 'checked' : '' }}>
                                                                                    No
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <!-- Premed Taken Section -->
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label for="premed_taken"
                                                                                    class="col-form-label col-form-label-sm">Premed
                                                                                    Taken</label>
                                                                                <div>
                                                                                    <input type="radio"
                                                                                        value="1"
                                                                                        name="premed_taken"
                                                                                        id="premed_taken"
                                                                                        {{ isset($pre_anesthetic_checkup->premed_taken) && $pre_anesthetic_checkup->premed_taken == '1' ? 'checked' : '' }}>
                                                                                    Yes
                                                                                    <input type="radio"
                                                                                        value="2"
                                                                                        name="premed_taken"
                                                                                        id="premed_taken"
                                                                                        {{ isset($pre_anesthetic_checkup->premed_taken) && $pre_anesthetic_checkup->premed_taken == '2' ? 'checked' : '' }}>
                                                                                    No
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <!-- Blood Available Section -->
                                                                        <div class="col-md-4 mt-2">
                                                                            <div class="form-group">
                                                                                <label for="blood_available"
                                                                                    class="col-form-label col-form-label-sm">Blood
                                                                                    Available</label>
                                                                                <div>
                                                                                    <input type="radio"
                                                                                        value="Yes"
                                                                                        name="blood_available"
                                                                                        id="blood_available"
                                                                                        {{ isset($pre_anesthetic_checkup->blood_available) && $pre_anesthetic_checkup->blood_available == '1' ? 'checked' : '' }}>
                                                                                    Yes
                                                                                    <input type="radio"
                                                                                        value="No"
                                                                                        name="blood_available"
                                                                                        id="blood_available"
                                                                                        {{ isset($pre_anesthetic_checkup->blood_available) && $pre_anesthetic_checkup->blood_available == '2' ? 'checked' : '' }}>
                                                                                    No
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <!-- Anesthesia Machine Check Section -->
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label for="anesthesia_machine_check"
                                                                                    class="col-form-label col-form-label-sm">Anesthesia
                                                                                    Machine Check</label>
                                                                                <div>
                                                                                    <input type="radio"
                                                                                        value="Yes"
                                                                                        name="anesthesia_machine_check"
                                                                                        id="anesthesia_machine_check"
                                                                                        {{ isset($pre_anesthetic_checkup->anesthesia_machine_check) && $pre_anesthetic_checkup->anesthesia_machine_check == '1' ? 'checked' : '' }}>
                                                                                    Yes
                                                                                    <input type="radio"
                                                                                        value="No"
                                                                                        name="anesthesia_machine_check"
                                                                                        id="anesthesia_machine_check"
                                                                                        {{ isset($pre_anesthetic_checkup->anesthesia_machine_check) && $pre_anesthetic_checkup->anesthesia_machine_check == '2' ? 'checked' : '' }}>
                                                                                    No
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <!-- Suction Check Section -->
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label for="suction_check"
                                                                                    class="col-form-label col-form-label-sm">Suction
                                                                                    Check</label>
                                                                                <div>
                                                                                    <input type="radio"
                                                                                        value="Yes"
                                                                                        name="suction_check"
                                                                                        id="suction_check"
                                                                                        {{ isset($pre_anesthetic_checkup->suction_check) && $pre_anesthetic_checkup->suction_check == '1' ? 'checked' : '' }}>
                                                                                    Yes
                                                                                    <input type="radio"
                                                                                        value="No"
                                                                                        name="suction_check"
                                                                                        id="suction_check"
                                                                                        {{ isset($pre_anesthetic_checkup->suction_check) && $pre_anesthetic_checkup->suction_check == '2' ? 'checked' : '' }}>
                                                                                    No
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <!-- Suction Check Section -->
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label for="investigation"
                                                                                    class="col-form-label col-form-label-sm">Investigation</label>
                                                                                <div>
                                                                                    <input type="radio"
                                                                                        value="Yes"
                                                                                        name="investigation"
                                                                                        id="investigation">
                                                                                    Yes
                                                                                    <input type="radio"
                                                                                        value="No"
                                                                                        name="investigation"
                                                                                        id="investigation">
                                                                                    No
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <!-- Suction Check Section -->
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label for="physical_examination"
                                                                                    class="col-form-label col-form-label-sm">Physical
                                                                                    Examination</label>
                                                                                <div>
                                                                                    <input type="radio"
                                                                                        value="Yes"
                                                                                        name="physical_examination"
                                                                                        id="physical_examination">
                                                                                    Yes
                                                                                    <input type="radio"
                                                                                        value="No"
                                                                                        name="physical_examination"
                                                                                        id="physical_examination">
                                                                                    No
                                                                                </div>
                                                                            </div>
                                                                        </div>



                                                                        <!-- Scavenger Check Section -->
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label for="scavenger_check"
                                                                                    class="col-form-label col-form-label-sm">Scavenger
                                                                                    Check</label>
                                                                                <div>
                                                                                    <input type="radio"
                                                                                        value="Yes"
                                                                                        name="scavenger_check"
                                                                                        id="scavenger_check"
                                                                                        {{ isset($pre_anesthetic_checkup->scavenger_check) && $pre_anesthetic_checkup->scavenger_check == '1' ? 'checked' : '' }}>
                                                                                    Yes
                                                                                    <input type="radio"
                                                                                        value="No"
                                                                                        name="scavenger_check"
                                                                                        id="scavenger_check"
                                                                                        {{ isset($pre_anesthetic_checkup->scavenger_check) && $pre_anesthetic_checkup->scavenger_check == '2' ? 'checked' : '' }}>
                                                                                    No
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <!-- Pre Induction Assessment by Attending Anesthesiologist -->
                                                                        <div class="col-md-12">
                                                                            <div class="form-group">
                                                                                <label for="ptOthers"
                                                                                    class="col-form-label col-form-label-sm">Pre
                                                                                    Induction Assessment by Attending
                                                                                    Anesthesiologist</label>
                                                                                {{-- <textarea class="form-control form-control-sm" id="ptOthers" name="ptOthers" rows="3">
                                                                                    {{ isset($anaesthetist_record_data->others) ? $anaesthetist_record_data->others : '' }}
                                                                                </textarea> --}}
                                                                                <input type="hidden" name="ptOthers"
                                                                                    id="ptOthers"
                                                                                    value=" {{ isset($anaesthetist_record_data->others) ? $anaesthetist_record_data->others : '' }}">
                                                                                <textarea id="editor1" class="form-control" rows="4" required> {{ isset($anaesthetist_record_data->others) ? $anaesthetist_record_data->others : '' }}</textarea>


                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>


                                                                {{-- <div class="row justify-content-end">
                                                                    <div class="col-md-6">
                                                                        <fieldset>
                                                                            <legend style="font-size: 16px;">Assessed
                                                                                by:</legend>
                                                                            <div class="form-row">
                                                                                <!-- Doctor's Name Input -->
                                                                                <div class="col-sm-12">
                                                                                    <div class="form-group">
                                                                                        <label for="drName"
                                                                                            class="col-form-label col-form-label-sm">Dr.
                                                                                            Name</label>
                                                                                        <input type="text"
                                                                                            class="form-control form-control-sm"
                                                                                            id="drName"
                                                                                            name="assessed_doctor_name"
                                                                                            placeholder="Dr. Name"
                                                                                            value="{{ isset($anaesthetist_record_data->doctor_name) ? $anaesthetist_record_data->doctor_name : '' }}" />
                                                                                        <input type="hidden"
                                                                                            name="hdn_assessed_doctor_id"
                                                                                            id="hdn_assessed_doctor_id"
                                                                                            value="{{ isset($anaesthetist_record_data->doctor_no_fk) ? $anaesthetist_record_data->doctor_no_fk : '' }}">
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Date of Assessment Input -->
                                                                                <div class="col-sm-12">
                                                                                    <div class="form-group">
                                                                                        <label for="DateOfAsses"
                                                                                            class="col-form-label col-form-label-sm">Date
                                                                                            of Assessment</label>
                                                                                        <input type="text"
                                                                                            class="form-control form-control-sm date_picker"
                                                                                            placeholder="dd-mm-YYYY"
                                                                                            id="DateOfAsses"
                                                                                            name="DateOfAsses"
                                                                                            value="{{ isset($anaesthetist_record_data->assessment_date) ? date('d-m-Y', strtotime($anaesthetist_record_data->assessment_date)) : '' }}" />
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </fieldset>
                                                                    </div>
                                                                </div> --}}


                                                                <div class="">
                                                                    <table width="100%" border="1">
                                                                        <tr>
                                                                            <td style="">
                                                                                <strong> Height : </strong> <input
                                                                                    type="text"
                                                                                    class="form-control form-control  "
                                                                                    id="height" name="height"
                                                                                    value="{{ isset($pre_anesthetic_checkup->height) ? $pre_anesthetic_checkup->height : '' }}"
                                                                                    placeholder="eg. 170 cm"
                                                                                    onkeyup="HeightCalculate()" />
                                                                            </td>
                                                                            <td style="">
                                                                                <strong> Weight : </strong> <input
                                                                                    type="text"
                                                                                    class="form-control form-control  "
                                                                                    id="weight" name="weight"
                                                                                    value="{{ isset($pre_anesthetic_checkup->weight) ? $pre_anesthetic_checkup->weight : '' }}"
                                                                                    placeholder="eg. 80 kg"
                                                                                    onkeyup="WeightCalculate()" />
                                                                            </td>

                                                                            <td style="">
                                                                                <strong> BMI : </strong> <input
                                                                                    type="text"
                                                                                    class="form-control form-control  "
                                                                                    id="bmi" name="bmi"
                                                                                    value="{{ isset($pre_anesthetic_checkup->bmi) ? $pre_anesthetic_checkup->bmi : '' }}"
                                                                                    placeholder="Kg/m2 " />
                                                                            </td>
                                                                            <td style="">
                                                                                <strong>B.Group</strong>
                                                                                <input type="text"
                                                                                    class="form-control form-control-sm"
                                                                                    id="ptBlood" name="ptBlood"
                                                                                    value="{{ isset($pat_info->blood_group_text) ? $pat_info->blood_group_text : '' }}"
                                                                                    placeholder="" readonly />
                                                                            </td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td style="">
                                                                                <strong> Smooker : </strong> <br>
                                                                                <label for="smooker_1">Yes</label>
                                                                                <input type="radio" name="smooker"
                                                                                    id="smooker_1" value="Yes"
                                                                                    {{ isset($pre_anesthetic_checkup->smooker) && $pre_anesthetic_checkup->smooker == 'Yes' ? 'checked' : '' }}>
                                                                                <label for="smooker_2">No</label>
                                                                                <input type="radio" name="smooker"
                                                                                    id="smooker_2" value="No"
                                                                                    {{ isset($pre_anesthetic_checkup->smooker) && $pre_anesthetic_checkup->smooker == 'No' ? 'checked' : '' }}>
                                                                            </td>

                                                                            <td style="">
                                                                                <strong> Alcohol : </strong> <br>
                                                                                <label for="alcohol_1">Yes</label>
                                                                                <input type="radio" name="alcohol"
                                                                                    id="alcohol_1" value="Yes"
                                                                                    {{ isset($pre_anesthetic_checkup->alcohol) && $pre_anesthetic_checkup->alcohol == 'Yes' ? 'checked' : '' }}>
                                                                                <label for="alcohol_2">No</label>
                                                                                <input type="radio" name="alcohol"
                                                                                    id="alcohol_2" value="No"
                                                                                    {{ isset($pre_anesthetic_checkup->alcohol) && $pre_anesthetic_checkup->alcohol == 'No' ? 'checked' : '' }}>
                                                                            </td>
                                                                            <td style="">
                                                                                <strong> Artificial Denture : </strong>
                                                                                <br>
                                                                                <label
                                                                                    for="artificial_denture_1">Yes</label>
                                                                                <input type="radio"
                                                                                    name="artificial_denture"
                                                                                    id="artificial_denture_1"
                                                                                    value="Yes"
                                                                                    {{ isset($pre_anesthetic_checkup->artificial_denture) && $pre_anesthetic_checkup->artificial_denture == 'Yes' ? 'checked' : '' }}>
                                                                                <label
                                                                                    for="artificial_denture_2">No</label>
                                                                                <input type="radio"
                                                                                    name="artificial_denture"
                                                                                    id="artificial_denture_2"
                                                                                    value="No"
                                                                                    {{ isset($pre_anesthetic_checkup->artificial_denture) && $pre_anesthetic_checkup->artificial_denture == 'No' ? 'checked' : '' }}>
                                                                            </td>
                                                                            <td style=""></td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td style="width: 250px">Preoperative
                                                                                Diagnosis</td>
                                                                            <td colspan="3"> <input type="text"
                                                                                    class="form-control form-control  "
                                                                                    id="Preoperative_Diagnosis"
                                                                                    name="Preoperative_Diagnosis"
                                                                                    value="{{ isset($pre_anesthetic_checkup->preoperative_diagnosis) ? $pre_anesthetic_checkup->preoperative_diagnosis : '' }}" />
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="width: 200px">Proposed Surgery
                                                                            </td>
                                                                            <td colspan="3"> <input type="text"
                                                                                    class="form-control form-control  "
                                                                                    id="propost_surgery"
                                                                                    name="propost_surgery"
                                                                                    value="{{ isset($pre_anesthetic_checkup->proposed_surgery) ? $pre_anesthetic_checkup->proposed_surgery : '' }}" />
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="width: 200px">Date of Operation
                                                                            </td>
                                                                            <td colspan="3">
                                                                                <input type="text"
                                                                                    class="form-control form-control-sm date_picker"
                                                                                    id="scheduled_for_surgery"
                                                                                    name="scheduled_for_surgery"
                                                                                    value="{{ isset($pre_anesthetic_checkup->scheduled_surgery_date) ? date('d-m-Y', strtotime($pre_anesthetic_checkup->scheduled_surgery_date)) : '' }}"
                                                                                    placeholder="dd-mm-YYYY" />
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="width: 200px">Operation</td>
                                                                            <td colspan="3">
                                                                                <label for="elective"> Elective
                                                                                </label> <input type="radio"
                                                                                    name="operation" id="elective"
                                                                                    value="Elective"
                                                                                    {{ isset($pre_anesthetic_checkup->operation) && $pre_anesthetic_checkup->operation == 'Elective' ? 'checked' : '' }}>
                                                                                <label for="emergency"> Emergency
                                                                                </label><input type="radio"
                                                                                    name="operation" id="emergency"
                                                                                    value="Emergency"
                                                                                    {{ isset($pre_anesthetic_checkup->operation) && $pre_anesthetic_checkup->operation == 'Emergency' ? 'checked' : '' }}>
                                                                            </td>
                                                                        </tr>

                                                                    </table>

                                                                    <table width="100%" border="1"
                                                                        style="margin-top:10px">
                                                                        <tr>
                                                                            <td colspan="1">
                                                                                <strong> Previous Anesthesia :
                                                                                    (Complications if
                                                                                    any)</strong>
                                                                            </td>
                                                                            <td colspan="5">
                                                                                <input type="text"
                                                                                    class="form-control  "
                                                                                    id="previous_anesthesia_name"
                                                                                    name="previous_anesthesia_name"
                                                                                    value="{{ isset($pre_anesthetic_checkup->previous_anesthesia) ? $pre_anesthetic_checkup->previous_anesthesia : '' }}" />
                                                                                <input type="hidden"
                                                                                    name="hdn_previous_anesthesia_id"
                                                                                    id="hdn_previous_anesthesia_id"
                                                                                    value="{{ isset($pre_anesthetic_checkup->previous_anesthesia_no_fk) ? $pre_anesthetic_checkup->previous_anesthesia_no_fk : '' }}">
                                                                            </td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td colspan="6"><strong>Co-existing
                                                                                    diseases with
                                                                                    duration :</strong></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="">
                                                                                <strong> Hypertension : </strong> <input
                                                                                    type="text"
                                                                                    class="form-control form-control  "
                                                                                    id="hypertension"
                                                                                    name="hypertension"
                                                                                    value="{{ isset($pre_anesthetic_checkup->hypertension) ? $pre_anesthetic_checkup->hypertension : '' }}"
                                                                                    placeholder="" />
                                                                            </td>
                                                                            <td style="">
                                                                                <strong> IHD : </strong> <input
                                                                                    type="text"
                                                                                    class="form-control form-control  "
                                                                                    id="ihd" name="ihd"
                                                                                    value="{{ isset($pre_anesthetic_checkup->ihd) ? $pre_anesthetic_checkup->ihd : '' }}"
                                                                                    placeholder="" />
                                                                            </td>

                                                                            <td style="">
                                                                                <strong> Myocardial infarction:
                                                                                </strong> <input type="text"
                                                                                    class="form-control form-control  "
                                                                                    id="myocardial" name="myocardial"
                                                                                    value="{{ isset($pre_anesthetic_checkup->myocardial) ? $pre_anesthetic_checkup->myocardial : '' }}"
                                                                                    placeholder="" />
                                                                            </td>
                                                                            <td style="">
                                                                                <strong>Diabetes</strong>
                                                                                <input type="text"
                                                                                    class="form-control form-control-sm"
                                                                                    id="diabetes" name="diabetes"
                                                                                    value="{{ isset($pre_anesthetic_checkup->diabetes) ? $pre_anesthetic_checkup->diabetes : '' }}"
                                                                                    placeholder="" />
                                                                            </td>
                                                                            <td style="">
                                                                                <strong>Thyroid disorder</strong>
                                                                                <input type="text"
                                                                                    class="form-control form-control-sm"
                                                                                    id="thyroid_disorder"
                                                                                    name="thyroid_disorder"
                                                                                    value="{{ isset($pre_anesthetic_checkup->thyroid_disorder) ? $pre_anesthetic_checkup->thyroid_disorder : '' }}"
                                                                                    placeholder="" />
                                                                            </td>
                                                                            <td style="">
                                                                                <strong>Others</strong>
                                                                                <input type="text"
                                                                                    class="form-control form-control-sm"
                                                                                    id="others_medical_problem"
                                                                                    name="others_medical_problem"
                                                                                    value="{{ isset($pre_anesthetic_checkup->others_medical_problem) ? $pre_anesthetic_checkup->others_medical_problem : '' }}"
                                                                                    placeholder="" />
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td colspan="1" style="width: 300px;">
                                                                                <strong> Present Medication : </strong>
                                                                            </td>
                                                                            <td colspan="5">
                                                                                <input type="text"
                                                                                    class="form-control  "
                                                                                    id="present_medication"
                                                                                    name="present_medication"
                                                                                    value="{{ isset($pre_anesthetic_checkup->present_medication) ? $pre_anesthetic_checkup->present_medication : '' }}" />

                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <strong> Allergy : </strong>
                                                                            </td>
                                                                            <td colspan="5">
                                                                                <input type="text"
                                                                                    class="form-control  "
                                                                                    id="allergy" name="allergy"
                                                                                    value="{{ isset($pre_anesthetic_checkup->allergy) ? $pre_anesthetic_checkup->allergy : '' }}" />
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                    <br>
                                                                    {{-- <h3> <strong>Consideration for operating room anesthesiologist:
                                                                        </strong></h3>
                                                                    <table width="100%" border="1" style="margin-top:10px">
                                                                        <tr>
                                                                            <td style="">
                                                                                <strong> Artificial Denture : </strong> <br>
                                                                            </td>
                                                                            <td>
                                                                                <label for="coniser_artificial_denture_1">Yes</label>
                                                                                <input type="radio"
                                                                                    name="coniser_artificial_denture"
                                                                                    id="coniser_artificial_denture_1" value="1"
                                                                                    {{ isset($pre_anesthetic_checkup->coniser_artificial_denture) && $pre_anesthetic_checkup->coniser_artificial_denture == '1' ? 'checked' : '' }}>
                                                                                &nbsp; &nbsp; &nbsp;
                                                                                <label for="coniser_artificial_denture_2">No</label>
                                                                                <input type="radio"
                                                                                    name="coniser_artificial_denture"
                                                                                    id="coniser_artificial_denture_2" value="2"
                                                                                    {{ isset($pre_anesthetic_checkup->coniser_artificial_denture) && $pre_anesthetic_checkup->coniser_artificial_denture == '2' ? 'checked' : '' }}>
                                                                            </td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td style="">
                                                                                <strong> Airway : </strong> <br>
                                                                            </td>
                                                                            <td>
                                                                                <label for="airway_1">Normal</label> <input
                                                                                    type="radio" name="airway" id="airway_1"
                                                                                    value="1"
                                                                                    {{ isset($pre_anesthetic_checkup->airway) && $pre_anesthetic_checkup->airway == '1' ? 'checked' : '' }}>
                                                                                &nbsp; &nbsp; &nbsp;
                                                                                <label for="airway_2">Difficult</label> <input
                                                                                    type="radio" name="airway" id="airway_2"
                                                                                    value="2"
                                                                                    {{ isset($pre_anesthetic_checkup->airway) && $pre_anesthetic_checkup->airway == '2' ? 'checked' : '' }}>
                                                                            </td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td colspan="1">
                                                                                <strong>Co-Existing Disease </strong>
                                                                            </td>
                                                                            <td colspan="3">
                                                                                <input type="text" class="form-control"
                                                                                    id="co_existing" name="co_existing"
                                                                                    value="{{ isset($pre_anesthetic_checkup->co_existing) ? $pre_anesthetic_checkup->co_existing : '' }}" />

                                                                            </td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td colspan="1">
                                                                                <strong> ASA Class : </strong>
                                                                            </td>
                                                                            <td colspan="3">
                                                                                <input type="radio" value="1"
                                                                                    name="asa_class1" id="asa_class1"
                                                                                    {{ isset($pre_anesthetic_checkup->asa_class1) && $pre_anesthetic_checkup->asa_class1 == '1' ? 'checked' : '' }}>
                                                                                1 &nbsp;&nbsp;&nbsp;
                                                                                <input type="radio" value="2"
                                                                                    name="asa_class1" id="asa_class1"
                                                                                    {{ isset($pre_anesthetic_checkup->asa_class1) && $pre_anesthetic_checkup->asa_class1 == '2' ? 'checked' : '' }}>
                                                                                2 &nbsp;&nbsp;&nbsp;
                                                                                <input type="radio" value="3"
                                                                                    name="asa_class1" id="asa_class1"
                                                                                    {{ isset($pre_anesthetic_checkup->asa_class1) && $pre_anesthetic_checkup->asa_class1 == '3' ? 'checked' : '' }}>
                                                                                3 &nbsp;&nbsp;&nbsp;
                                                                                <input type="radio" value="4"
                                                                                    name="asa_class1" id="asa_class1"
                                                                                    {{ isset($pre_anesthetic_checkup->asa_class1) && $pre_anesthetic_checkup->asa_class1 == '4' ? 'checked' : '' }}>
                                                                                4 &nbsp;&nbsp;&nbsp;
                                                                                <input type="radio" value="5"
                                                                                    name="asa_class1" id="asa_class1"
                                                                                    {{ isset($pre_anesthetic_checkup->asa_class1) && $pre_anesthetic_checkup->asa_class1 == '5' ? 'checked' : '' }}>
                                                                                5 &nbsp;&nbsp;&nbsp;
                                                                                <input type="radio" value="6"
                                                                                    name="asa_class1" id="asa_class1"
                                                                                    {{ isset($pre_anesthetic_checkup->asa_class1) && $pre_anesthetic_checkup->asa_class1 == '6' ? 'checked' : '' }}>
                                                                                6 &nbsp;&nbsp;&nbsp;
                                                                                <input type="radio" value="1"
                                                                                    name="asa_class2" id="asa_class2"
                                                                                    {{ isset($pre_anesthetic_checkup->asa_class2) && $pre_anesthetic_checkup->asa_class2 == '1' ? 'checked' : '' }}>
                                                                                E &nbsp;&nbsp;&nbsp;

                                                                            </td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td colspan="1">
                                                                                <strong> NYHA Classification : </strong>
                                                                            </td>
                                                                            <td colspan="3">
                                                                                <input type="radio" value="I"
                                                                                    name="nyha_classification"
                                                                                    {{ isset($pre_anesthetic_checkup->nyha_classification) && $pre_anesthetic_checkup->nyha_classification == 'I' ? 'checked' : '' }}>
                                                                                I &nbsp;&nbsp;
                                                                                <input type="radio" value="II"
                                                                                    name="nyha_classification"
                                                                                    {{ isset($pre_anesthetic_checkup->nyha_classification) && $pre_anesthetic_checkup->nyha_classification == 'II' ? 'checked' : '' }}>
                                                                                II &nbsp;&nbsp;
                                                                                <input type="radio" value="III"
                                                                                    name="nyha_classification"
                                                                                    {{ isset($pre_anesthetic_checkup->nyha_classification) && $pre_anesthetic_checkup->nyha_classification == 'III' ? 'checked' : '' }}>
                                                                                III &nbsp;&nbsp;
                                                                                <input type="radio" value="IV"
                                                                                    name="nyha_classification"
                                                                                    {{ isset($pre_anesthetic_checkup->nyha_classification) && $pre_anesthetic_checkup->nyha_classification == 'IV' ? 'checked' : '' }}>
                                                                                IV
                                                                            </td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td colspan="1">
                                                                                <strong> Mallampati grade : </strong>
                                                                            </td>
                                                                            <td colspan="3">
                                                                                <!-- <input type="radio" value="none" name="mallampati_grade" {{ isset($pre_anesthetic_checkup->mallampati_grade) && $pre_anesthetic_checkup->mallampati_grade == 'none' ? 'checked' : '' }}> none &nbsp;&nbsp; -->
                                                                                <input type="radio" value="I"
                                                                                    name="mallampati_grade"
                                                                                    {{ isset($pre_anesthetic_checkup->mallampati_grade) && $pre_anesthetic_checkup->mallampati_grade == 'I' ? 'checked' : '' }}>
                                                                                I &nbsp;&nbsp;
                                                                                <input type="radio" value="II"
                                                                                    name="mallampati_grade"
                                                                                    {{ isset($pre_anesthetic_checkup->mallampati_grade) && $pre_anesthetic_checkup->mallampati_grade == 'II' ? 'checked' : '' }}>
                                                                                II &nbsp;&nbsp;
                                                                                <input type="radio" value="III"
                                                                                    name="mallampati_grade"
                                                                                    {{ isset($pre_anesthetic_checkup->mallampati_grade) && $pre_anesthetic_checkup->mallampati_grade == 'III' ? 'checked' : '' }}>
                                                                                III &nbsp;&nbsp;
                                                                                <input type="radio" value="IV"
                                                                                    name="mallampati_grade"
                                                                                    {{ isset($pre_anesthetic_checkup->mallampati_grade) && $pre_anesthetic_checkup->mallampati_grade == 'IV' ? 'checked' : '' }}>
                                                                                IV
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td colspan="1">
                                                                                <strong> Type of Anesthesia Discussed : </strong>
                                                                            </td>
                                                                            <td colspan="3">
                                                                                <input type="checkbox" value="GA" name="tad_ga"
                                                                                    id="tad_ga"
                                                                                    {{ isset($pre_anesthetic_checkup->tad_ga) && $pre_anesthetic_checkup->tad_ga == 'GA' ? 'checked' : '' }}>
                                                                                GA &nbsp;&nbsp;
                                                                                <input type="checkbox" value="Spinal"
                                                                                    name="tad_spinal" id=""
                                                                                    {{ isset($pre_anesthetic_checkup->tad_spinal) && $pre_anesthetic_checkup->tad_spinal == 'Spinal' ? 'checked' : '' }}>
                                                                                Spinal &nbsp;&nbsp;
                                                                                <input type="checkbox" value="Epidural"
                                                                                    name="tad_epidural" id=""
                                                                                    {{ isset($pre_anesthetic_checkup->tad_epidural) && $pre_anesthetic_checkup->tad_epidural == 'Epidural' ? 'checked' : '' }}>
                                                                                Epidural &nbsp;&nbsp;
                                                                                <input type="checkbox" value="Nerve Block"
                                                                                    name="tad_nerve_block" id=""
                                                                                    {{ isset($pre_anesthetic_checkup->tad_nerve_block) && $pre_anesthetic_checkup->tad_nerve_block == 'Nerve Block' ? 'checked' : '' }}>
                                                                                Nerve Block
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td colspan="1">
                                                                                <strong> Pain Relief Discussed : </strong>
                                                                            </td>
                                                                            <td colspan="3">
                                                                                <input type="checkbox" value="PCA" name="prd_pca"
                                                                                    id=""
                                                                                    {{ isset($pre_anesthetic_checkup->prd_pca) && $pre_anesthetic_checkup->prd_pca == 'PCA' ? 'checked' : '' }}>
                                                                                PCA &nbsp;&nbsp;
                                                                                <input type="checkbox" value="Epidural infusion"
                                                                                    name="prd_epidural_infusion" id=""
                                                                                    {{ isset($pre_anesthetic_checkup->prd_epidural_infusion) && $pre_anesthetic_checkup->prd_epidural_infusion == 'Epidural infusion' ? 'checked' : '' }}>
                                                                                Epidural infusion &nbsp;&nbsp;
                                                                                <input type="checkbox" value="PCEA ? Oral"
                                                                                    name="prd_pceaororal" id=""
                                                                                    {{ isset($pre_anesthetic_checkup->prd_pceaororal) && $pre_anesthetic_checkup->prd_pceaororal == 'PCEA ? Oral' ? 'checked' : '' }}>
                                                                                PCEA? Oral &nbsp;&nbsp;
                                                                                <input type="checkbox" value="IM" name="prd_im"
                                                                                    id=""
                                                                                    {{ isset($pre_anesthetic_checkup->prd_im) && $pre_anesthetic_checkup->prd_im == 'IM' ? 'checked' : '' }}>
                                                                                IM
                                                                                <input type="checkbox" value="IV" name="prd_iv"
                                                                                    id=""
                                                                                    {{ isset($pre_anesthetic_checkup->prd_iv) && $pre_anesthetic_checkup->prd_iv == 'IV' ? 'checked' : '' }}>
                                                                                IV
                                                                                <input type="checkbox" value="Perrectal"
                                                                                    name="prd_per_rectal" id=""
                                                                                    {{ isset($pre_anesthetic_checkup->prd_per_rectal) && $pre_anesthetic_checkup->prd_per_rectal == 'Perrectal' ? 'checked' : '' }}>
                                                                                Per rectal
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td colspan="1">
                                                                                <strong> Risk factor( if any) : </strong>
                                                                            </td>
                                                                            <td colspan="3">
                                                                                <input type="text" name="risk_factor"
                                                                                    class="form-control" id="risk_factor"
                                                                                    value="{{ isset($pre_anesthetic_checkup->risk_factor) ? $pre_anesthetic_checkup->risk_factor : '' }}">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td colspan="1">
                                                                                <strong> Others : </strong>
                                                                            </td>
                                                                            <td colspan="3">
                                                                                <input type="text" name="remarks"
                                                                                    class="form-control" id="remarks"
                                                                                    value="{{ isset($pre_anesthetic_checkup->remarks) ? $pre_anesthetic_checkup->remarks : '' }}">
                                                                            </td>
                                                                        </tr>
                                                                    </table> --}}
                                                                    <h3><strong>Consideration for Operating Room
                                                                            Anesthesiologist:</strong></h3>

                                                                    <table width="100%" border="1"
                                                                        class="table" style="margin-top: 10px;">
                                                                        <thead>
                                                                            <tr>
                                                                                <th colspan="2">Pre-Anesthetic
                                                                                    Checkup</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <!-- Artificial Denture -->
                                                                            <tr>
                                                                                <td><strong>Artificial Denture:</strong>
                                                                                </td>
                                                                                <td>
                                                                                    <fieldset>
                                                                                        <label
                                                                                            for="coniser_artificial_denture_1">Yes</label>
                                                                                        <input type="radio"
                                                                                            name="coniser_artificial_denture"
                                                                                            id="coniser_artificial_denture_1"
                                                                                            value="1"
                                                                                            {{ isset($pre_anesthetic_checkup->coniser_artificial_denture) && $pre_anesthetic_checkup->coniser_artificial_denture == '1' ? 'checked' : '' }}>
                                                                                        &nbsp;&nbsp;
                                                                                        <label
                                                                                            for="coniser_artificial_denture_2">No</label>
                                                                                        <input type="radio"
                                                                                            name="coniser_artificial_denture"
                                                                                            id="coniser_artificial_denture_2"
                                                                                            value="2"
                                                                                            {{ isset($pre_anesthetic_checkup->coniser_artificial_denture) && $pre_anesthetic_checkup->coniser_artificial_denture == '2' ? 'checked' : '' }}>
                                                                                    </fieldset>
                                                                                </td>
                                                                            </tr>

                                                                            <!-- Airway -->
                                                                            <tr>
                                                                                <td><strong>Airway:</strong></td>
                                                                                <td>
                                                                                    <fieldset>
                                                                                        <label
                                                                                            for="airway_1">Normal</label>
                                                                                        <input type="radio"
                                                                                            name="airway"
                                                                                            id="airway_1"
                                                                                            value="1"
                                                                                            {{ isset($pre_anesthetic_checkup->airway) && $pre_anesthetic_checkup->airway == '1' ? 'checked' : '' }}>
                                                                                        &nbsp;&nbsp;
                                                                                        <label
                                                                                            for="airway_2">Difficult</label>
                                                                                        <input type="radio"
                                                                                            name="airway"
                                                                                            id="airway_2"
                                                                                            value="2"
                                                                                            {{ isset($pre_anesthetic_checkup->airway) && $pre_anesthetic_checkup->airway == '2' ? 'checked' : '' }}>
                                                                                    </fieldset>
                                                                                </td>
                                                                            </tr>

                                                                            <!-- Co-Existing Disease -->
                                                                            <tr>
                                                                                <td><strong>Co-Existing
                                                                                        Disease:</strong></td>
                                                                                <td><input type="text"
                                                                                        class="form-control"
                                                                                        name="co_existing"
                                                                                        value="{{ isset($pre_anesthetic_checkup->co_existing) ? $pre_anesthetic_checkup->co_existing : '' }}">
                                                                                </td>
                                                                            </tr>

                                                                            <!-- ASA Class -->
                                                                            <tr>
                                                                                <td><strong>ASA Class:</strong></td>
                                                                                <td>
                                                                                    <fieldset>
                                                                                        @foreach ([1, 2, 3, 4, 5, 6] as $class)
                                                                                            <label
                                                                                                for="asa_class{{ $class }}">{{ $class }}</label>
                                                                                            <input type="radio"
                                                                                                name="asa_class1"
                                                                                                id="asa_class{{ $class }}"
                                                                                                value="{{ $class }}"
                                                                                                {{ isset($pre_anesthetic_checkup->asa_class1) && $pre_anesthetic_checkup->asa_class1 == $class ? 'checked' : '' }}>
                                                                                            &nbsp;&nbsp;
                                                                                        @endforeach
                                                                                        <input type="radio"
                                                                                            name="asa_class2"
                                                                                            id="asa_class_e"
                                                                                            value="E"
                                                                                            {{ isset($pre_anesthetic_checkup->asa_class2) && $pre_anesthetic_checkup->asa_class2 == 'E' ? 'checked' : '' }}>
                                                                                        E
                                                                                    </fieldset>
                                                                                </td>
                                                                            </tr>

                                                                            <!-- NYHA Classification -->
                                                                            <tr>
                                                                                <td><strong>NYHA
                                                                                        Classification:</strong></td>
                                                                                <td>
                                                                                    <fieldset>
                                                                                        @foreach (['I', 'II', 'III', 'IV'] as $classification)
                                                                                            <label
                                                                                                for="nyha_classification_{{ $classification }}">{{ $classification }}</label>
                                                                                            <input type="radio"
                                                                                                name="nyha_classification"
                                                                                                id="nyha_classification_{{ $classification }}"
                                                                                                value="{{ $classification }}"
                                                                                                {{ isset($pre_anesthetic_checkup->nyha_classification) && $pre_anesthetic_checkup->nyha_classification == $classification ? 'checked' : '' }}>
                                                                                            &nbsp;&nbsp;
                                                                                        @endforeach
                                                                                    </fieldset>
                                                                                </td>
                                                                            </tr>

                                                                            <!-- Mallampati Grade -->
                                                                            <tr>
                                                                                <td><strong>Mallampati Grade:</strong>
                                                                                </td>
                                                                                <td>
                                                                                    <fieldset>
                                                                                        @foreach ([1, 2, 3, 4] as $grade)
                                                                                            <label
                                                                                                for="mallampati_grade_{{ $grade }}">{{ $grade }}</label>
                                                                                            <input type="radio"
                                                                                                name="mallampati_grade"
                                                                                                id="mallampati_grade_{{ $grade }}"
                                                                                                value="{{ $grade }}"
                                                                                                {{ isset($pre_anesthetic_checkup->mallampati_grade) && $pre_anesthetic_checkup->mallampati_grade == $grade ? 'checked' : '' }}>
                                                                                            &nbsp;&nbsp;
                                                                                        @endforeach
                                                                                    </fieldset>
                                                                                </td>
                                                                            </tr>

                                                                            <!-- Type of Anesthesia Discussed -->
                                                                            <tr>
                                                                                <td><strong>Type of Anesthesia
                                                                                        Discussed:</strong></td>
                                                                                <td>
                                                                                    <fieldset>
                                                                                        @foreach (['GA', 'Spinal', 'Epidural', 'Nerve Block'] as $anesthesia)
                                                                                            <label
                                                                                                for="tad_{{ strtolower($anesthesia) }}">{{ $anesthesia }}</label>
                                                                                            <input type="checkbox"
                                                                                                name="tad_{{ strtolower($anesthesia) }}"
                                                                                                id="tad_{{ strtolower($anesthesia) }}"
                                                                                                value="{{ $anesthesia }}"
                                                                                                {{ isset($pre_anesthetic_checkup->{'tad_' . strtolower($anesthesia)}) && $pre_anesthetic_checkup->{'tad_' . strtolower($anesthesia)} == $anesthesia ? 'checked' : '' }}>
                                                                                            &nbsp;&nbsp;
                                                                                        @endforeach
                                                                                    </fieldset>
                                                                                </td>
                                                                            </tr>

                                                                            <!-- Pain Relief Discussed -->
                                                                            <tr>
                                                                                <td><strong>Pain Relief
                                                                                        Discussed:</strong></td>
                                                                                <td>
                                                                                    <fieldset>
                                                                                        @foreach (['PCA', 'Epidural infusion', 'PCEA ? Oral', 'IM', 'IV', 'Perrectal'] as $painRelief)
                                                                                            <label
                                                                                                for="prd_{{ strtolower(str_replace(' ', '_', $painRelief)) }}">{{ $painRelief }}</label>
                                                                                            <input type="checkbox"
                                                                                                name="prd_{{ strtolower(str_replace(' ', '_', $painRelief)) }}"
                                                                                                id="prd_{{ strtolower(str_replace(' ', '_', $painRelief)) }}"
                                                                                                value="{{ $painRelief }}"
                                                                                                {{ isset($pre_anesthetic_checkup->{'prd_' . strtolower(str_replace(' ', '_', $painRelief))}) && $pre_anesthetic_checkup->{'prd_' . strtolower(str_replace(' ', '_', $painRelief))} == $painRelief ? 'checked' : '' }}>
                                                                                            &nbsp;&nbsp;
                                                                                        @endforeach
                                                                                    </fieldset>
                                                                                </td>
                                                                            </tr>

                                                                            <!-- Risk Factor -->
                                                                            <tr>
                                                                                <td><strong>Risk Factor (if
                                                                                        any):</strong></td>
                                                                                <td><input type="text"
                                                                                        name="risk_factor"
                                                                                        class="form-control"
                                                                                        value="{{ isset($pre_anesthetic_checkup->risk_factor) ? $pre_anesthetic_checkup->risk_factor : '' }}">
                                                                                </td>
                                                                            </tr>

                                                                            <!-- Remarks -->
                                                                            <tr>
                                                                                <td><strong>Remarks:</strong></td>
                                                                                <td><input type="text"
                                                                                        name="remarks"
                                                                                        class="form-control"
                                                                                        value="{{ isset($pre_anesthetic_checkup->remarks) ? $pre_anesthetic_checkup->remarks : '' }}">
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>

                                                                    <br>



                                                                    <!-- 1st card body -->
                                                                    <!-- 2nd card body -->
                                                                    <h3 class="mb-0"><strong> Pre Induction
                                                                            Assessment by
                                                                            Anesthesiologist</strong></h3>
                                                                    <div class="card-body p-3">
                                                                        <div class="form-row">
                                                                            <div class="col-md-2">
                                                                                <div class="form-group">
                                                                                    <label for="txt__pulse"
                                                                                        class="col-form-label col-form-label-sm">Pulse/min</label>
                                                                                    <input type="text"
                                                                                        class="form-control form-control-sm"
                                                                                        id="txt__pulse"
                                                                                        name="txt__pulse"
                                                                                        value="{{ isset($anaesthetist_record_data->pulse_min) ? $anaesthetist_record_data->pulse_min : '' }}" />
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-md-4">
                                                                                <div class="form-group">
                                                                                    <label for="txt_bp_sys"
                                                                                        class="col-form-label col-form-label-sm">BP
                                                                                        (mmHg)</label>
                                                                                    <div class="input-group">
                                                                                        <input type="text"
                                                                                            class="form-control form-control-sm"
                                                                                            id="txt_bp_sys"
                                                                                            name="txt_bp_sys"
                                                                                            value="{{ isset($anaesthetist_record_data->bp_mmhg) ? $anaesthetist_record_data->bp_mmhg : '' }}" />
                                                                                        &nbsp;/&nbsp;
                                                                                        <input type="text"
                                                                                            class="form-control form-control-sm"
                                                                                            id="txt_bp_dia"
                                                                                            name="txt_bp_dia"
                                                                                            value="{{ isset($anaesthetist_record_data->bp_mmhg_2) ? $anaesthetist_record_data->bp_mmhg_2 : '' }}" />
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-md-3">
                                                                                <div class="form-group">
                                                                                    <label for="ptHeart"
                                                                                        class="col-form-label col-form-label-sm">Heart</label>
                                                                                    <input type="text"
                                                                                        class="form-control form-control-sm"
                                                                                        id="ptHeart" name="ptHeart"
                                                                                        placeholder=""
                                                                                        value="{{ isset($anaesthetist_record_data->heart) ? $anaesthetist_record_data->heart : '' }}" />
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-md-3">
                                                                                <div class="form-group">
                                                                                    <label for="ptLungs"
                                                                                        class="col-form-label col-form-label-sm">Lungs</label>
                                                                                    <input type="text"
                                                                                        class="form-control form-control-sm"
                                                                                        id="ptLungs" name="ptLungs"
                                                                                        placeholder=""
                                                                                        value="{{ isset($anaesthetist_record_data->lungs) ? $anaesthetist_record_data->lungs : '' }}" />
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-md-3">
                                                                                <div class="form-group">
                                                                                    <label for="ptTeeth"
                                                                                        class="col-form-label col-form-label-sm">Teeth</label>
                                                                                    <input type="text"
                                                                                        class="form-control form-control-sm"
                                                                                        id="ptTeeth" name="ptTeeth"
                                                                                        placeholder=""
                                                                                        value="{{ isset($anaesthetist_record_data->teeth) ? $anaesthetist_record_data->teeth : '' }}" />
                                                                                </div>
                                                                            </div>



                                                                            <div class="col-md-3">
                                                                                <div class="form-group">
                                                                                    <label for="ptAnaemia"
                                                                                        class="col-form-label col-form-label-sm">Anaemia</label>
                                                                                    <input type="text"
                                                                                        class="form-control form-control-sm"
                                                                                        id="ptAnaemia"
                                                                                        name="ptAnaemia"
                                                                                        placeholder=""
                                                                                        value="{{ isset($anaesthetist_record_data->anaemia) ? $anaesthetist_record_data->anaemia : '' }}" />
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-md-3">
                                                                                <div class="form-group">
                                                                                    <label for="ptHb"
                                                                                        class="col-form-label col-form-label-sm">HB%</label>
                                                                                    <input type="text"
                                                                                        class="form-control form-control-sm"
                                                                                        id="ptHb" name="ptHb"
                                                                                        placeholder=""
                                                                                        value="{{ isset($anaesthetist_record_data->hb) ? $anaesthetist_record_data->hb : '' }}" />
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-md-3">
                                                                                <div class="form-group">
                                                                                    <label for="ptFbsRbs"
                                                                                        class="col-form-label col-form-label-sm">
                                                                                        <div class="form-check form-check-inline"
                                                                                            style="margin-right: 0px;">
                                                                                            <input
                                                                                                class="form-check-input"
                                                                                                type="radio"
                                                                                                name="inlineFbsRbs"
                                                                                                id="inlineFbs1"
                                                                                                value="FBS"
                                                                                                @if (isset($anaesthetist_record_data->fbs_rbs) && $anaesthetist_record_data->fbs_rbs == 'FBS') checked @endif />
                                                                                            <label
                                                                                                class="form-check-label"
                                                                                                for="inlineFbs1">FBS</label>
                                                                                        </div>
                                                                                        &nbsp;/&nbsp;
                                                                                        <div class="form-check form-check-inline"
                                                                                            style="margin-right: 0px;">
                                                                                            <input
                                                                                                class="form-check-input"
                                                                                                type="radio"
                                                                                                name="inlineFbsRbs"
                                                                                                id="inlineFbsRbs2"
                                                                                                value="RBS"
                                                                                                @if (isset($anaesthetist_record_data->fbs_rbs) && $anaesthetist_record_data->fbs_rbs == 'RBS') checked @endif />
                                                                                            <label
                                                                                                class="form-check-label"
                                                                                                for="inlineFbsRbs2">RBS</label>
                                                                                        </div>
                                                                                    </label>
                                                                                    <input type="text"
                                                                                        class="form-control form-control-sm"
                                                                                        id="ptFbsRbs" name="ptFbsRbs"
                                                                                        placeholder=""
                                                                                        value="{{ isset($anaesthetist_record_data->fbs_rbs_text) ? $anaesthetist_record_data->fbs_rbs_text : '' }}" />
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-md-3">
                                                                                <div class="form-group">
                                                                                    <label for="ptBrea"
                                                                                        class="col-form-label col-form-label-sm">B.
                                                                                        Urea</label>
                                                                                    <input type="text"
                                                                                        class="form-control form-control-sm"
                                                                                        id="ptBrea" name="ptBrea"
                                                                                        placeholder=""
                                                                                        value="{{ isset($anaesthetist_record_data->b_urea) ? $anaesthetist_record_data->b_urea : '' }}" />
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-md-3">
                                                                                <div class="form-group">
                                                                                    <label for="ptScreatinine"
                                                                                        class="col-form-label col-form-label-sm">S.
                                                                                        Creatinine</label>
                                                                                    <input type="text"
                                                                                        class="form-control form-control-sm"
                                                                                        id="ptScreatinine"
                                                                                        name="ptScreatinine"
                                                                                        placeholder=""
                                                                                        value="{{ isset($anaesthetist_record_data->s_creatinine) ? $anaesthetist_record_data->s_creatinine : '' }}" />
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-md-3">
                                                                                <div class="form-group">
                                                                                    <label for="ptSbilirubin"
                                                                                        class="col-form-label col-form-label-sm">S.
                                                                                        Bilirubin</label>
                                                                                    <input type="text"
                                                                                        class="form-control form-control-sm"
                                                                                        id="ptSbilirubin"
                                                                                        name="ptSbilirubin"
                                                                                        placeholder=""
                                                                                        value="{{ isset($anaesthetist_record_data->s_bilirubin) ? $anaesthetist_record_data->s_bilirubin : '' }}" />
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-md-3">
                                                                                <div class="form-group">
                                                                                    <label for="ptCxr"
                                                                                        class="col-form-label col-form-label-sm">CXR</label>
                                                                                    <input type="text"
                                                                                        class="form-control form-control-sm"
                                                                                        id="ptCxr" name="ptCxr"
                                                                                        placeholder=""
                                                                                        value="{{ isset($anaesthetist_record_data->cxr) ? $anaesthetist_record_data->cxr : '' }}" />
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-md-3">
                                                                                <div class="form-group">
                                                                                    <label for="spo2"
                                                                                        class="col-form-label col-form-label-sm">SpO2</label>
                                                                                    <input type="text"
                                                                                        class="form-control form-control-sm"
                                                                                        id="spo2" name="spo2"
                                                                                        placeholder=""
                                                                                        value="{{ isset($anaesthetist_record_data->spo2) ? $anaesthetist_record_data->spo2 : '' }}" />
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-md-3">
                                                                                <div class="form-group">
                                                                                    <label for="gcs"
                                                                                        class="col-form-label col-form-label-sm">GCS</label>
                                                                                    <input type="text"
                                                                                        class="form-control form-control-sm"
                                                                                        id="gcs" name="gcs"
                                                                                        placeholder=""
                                                                                        value="{{ isset($anaesthetist_record_data->gcs) ? $anaesthetist_record_data->gcs : '' }}" />
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-lg-3 col-md-3 mt-4">
                                                                                <div class="form-group"
                                                                                    style="display: flex; align-items: center; gap: 15px;">
                                                                                    <label for="ptChestPain"
                                                                                        class="col-form-label col-form-label-sm">Chest
                                                                                        Pain</label>
                                                                                    <div class="form-check form-check-inline"
                                                                                        style="margin-right: 0px;">
                                                                                        <input class="form-check-input"
                                                                                            type="radio"
                                                                                            name="inlineRadioChestPain"
                                                                                            id="inlineChestPain1"
                                                                                            value="(+)"
                                                                                            @if (isset($anaesthetist_record_data->chest_pain) && $anaesthetist_record_data->chest_pain == '(+)') checked @endif />
                                                                                        <label class="form-check-label"
                                                                                            for="inlineChestPain1">Yes</label>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline"
                                                                                        style="margin-right: 0px;">
                                                                                        <input class="form-check-input"
                                                                                            type="radio"
                                                                                            name="inlineRadioChestPain"
                                                                                            id="inlineChestPain2"
                                                                                            value="(-)"
                                                                                            @if (isset($anaesthetist_record_data->chest_pain) && $anaesthetist_record_data->chest_pain == '(-)') checked @endif />
                                                                                        <label class="form-check-label"
                                                                                            for="inlineChestPain2">No</label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-lg-3 col-md-3 mt-4">
                                                                                <div class="form-group"
                                                                                    style="display: flex; align-items: center; gap: 15px;">
                                                                                    <label for="ptCough"
                                                                                        class="col-form-label col-form-label-sm">Cough</label>
                                                                                    <div class="form-check form-check-inline"
                                                                                        style="margin-right: 0px;">
                                                                                        <input class="form-check-input"
                                                                                            type="radio"
                                                                                            name="inlineRadioCough"
                                                                                            id="inlineCough1"
                                                                                            value="(+)"
                                                                                            @if (isset($anaesthetist_record_data->cough) && $anaesthetist_record_data->cough == '(+)') checked @endif />
                                                                                        <label class="form-check-label"
                                                                                            for="inlineCough1">Yes</label>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline"
                                                                                        style="margin-right: 0px;">
                                                                                        <input class="form-check-input"
                                                                                            type="radio"
                                                                                            name="inlineRadioCough"
                                                                                            id="inlineCough2"
                                                                                            value="(-)"
                                                                                            @if (isset($anaesthetist_record_data->cough) && $anaesthetist_record_data->cough == '(-)') checked @endif />
                                                                                        <label class="form-check-label"
                                                                                            for="inlineCough2">No</label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>


                                                                            <div class="col-md-12">
                                                                                <fieldset>
                                                                                    <legend style="font-size: 16px;">S.
                                                                                        Electrolytes
                                                                                    </legend>
                                                                                    <div class="form-row">
                                                                                        <div class="col-md-4">
                                                                                            <div class="form-group">
                                                                                                <label for="ptNa__"
                                                                                                    class="col-form-label col-form-label-sm">NA+</label>
                                                                                                <input type="text"
                                                                                                    class="form-control form-control-sm"
                                                                                                    id="ptNa__"
                                                                                                    name="ptNa__"
                                                                                                    placeholder=""
                                                                                                    value="{{ isset($anaesthetist_record_data->electrolyles_na) ? $anaesthetist_record_data->electrolyles_na : '' }}" />
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-4">
                                                                                            <div class="form-group">
                                                                                                <label for="ptK__"
                                                                                                    class="col-form-label col-form-label-sm">K+</label>
                                                                                                <input type="text"
                                                                                                    class="form-control form-control-sm"
                                                                                                    id="ptK__"
                                                                                                    name="ptK__"
                                                                                                    placeholder=""
                                                                                                    value="{{ isset($anaesthetist_record_data->electrolyles_k) ? $anaesthetist_record_data->electrolyles_k : '' }}" />
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-4">
                                                                                            <div class="form-group">
                                                                                                <label for="ptCi__"
                                                                                                    class="col-form-label col-form-label-sm">Ci</label>
                                                                                                <input type="text"
                                                                                                    class="form-control form-control-sm"
                                                                                                    id="ptCi__"
                                                                                                    name="ptCi__"
                                                                                                    placeholder=""
                                                                                                    value="{{ isset($anaesthetist_record_data->electrolyles_ci) ? $anaesthetist_record_data->electrolyles_ci : '' }}" />
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </fieldset>
                                                                            </div>

                                                                            @php
                                                                                $Rreoperative = isset(
                                                                                    $anaesthetist_record_data->for_anaesthetist,
                                                                                )
                                                                                    ? $anaesthetist_record_data->for_anaesthetist
                                                                                    : '';
                                                                            @endphp

                                                                            <?php echo $Rreoperative; ?>

                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <label for="ptEcg"
                                                                                        class="col-form-label col-form-label-sm">ECG</label>
                                                                                    <textarea class="form-control form-control-sm" id="ptEcg" name="ptEcg" rows="3">{{ isset($anaesthetist_record_data->ecg) ? $anaesthetist_record_data->ecg : '' }}</textarea>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <label for="echo"
                                                                                        class="col-form-label col-form-label-sm">Echo</label>
                                                                                    <textarea class="form-control form-control-sm" id="echo" name="echo" rows="3">{{ isset($anaesthetist_record_data->echo) ? $anaesthetist_record_data->echo : '' }}</textarea>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <label for="others"
                                                                                        class="col-form-label col-form-label-sm">Others</label>
                                                                                    <textarea class="form-control form-control-sm" id="others" name="others" rows="3">{{ isset($anaesthetist_record_data->others) ? $anaesthetist_record_data->others : '' }}</textarea>
                                                                                </div>
                                                                            </div>


                                                                        </div>
                                                                    </div>








                                                                </div>
                                                                <!-- 2nd card body end -->

                                                                <!-- 3rd card body start -->

                                                                <!-- <div class="card-header">
                                                    <h5 class="card-title mb-0">PREOPERATIVE ADVICE</h5>
                                                </div> -->
                                                                <div class="card-body p-3">
                                                                    <div class="form-row">
                                                                        <div class="col-md-12">
                                                                            <div class="form-group">
                                                                                <label for="ptAdvice"
                                                                                    class="col-form-label col-form-label-sm">Advice</label>
                                                                                <textarea class="form-control form-control-sm" id="ptAdvice" name="ptAdvice" rows="3">
                                                                                    {{ isset($anaesthetist_record_data->preoperative_advice) ? $anaesthetist_record_data->preoperative_advice : '' }}

                                                                                </textarea>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label for="ptDateOpn"
                                                                                    class="col-form-label col-form-label-sm">Date
                                                                                    of Opn</label>
                                                                                <input type="text"
                                                                                    class="form-control form-control-sm date_picker"
                                                                                    placeholder="dd-mm-YYYY"
                                                                                    id="ptDateOpn" name="ptDateOpn"
                                                                                    value="{{ isset($anaesthetist_record_data->opn_date) ? date('d-m-Y', strtotime($anaesthetist_record_data->opn_date)) : '' }}" />
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label for="ptSurgon"
                                                                                    class="col-form-label col-form-label-sm">Surgon
                                                                                    Name</label>
                                                                                <input type="text"
                                                                                    class="form-control form-control-sm"
                                                                                    id="ptSurgon" name="ptSurgon"
                                                                                    value="{{ isset($anaesthetist_record_data->surgon_name) ? $anaesthetist_record_data->surgon_name : '' }}" />
                                                                                <input type="hidden"
                                                                                    name="hdn_surgon_doctor_id"
                                                                                    id="hdn_surgon_doctor_id"
                                                                                    value="{{ isset($anaesthetist_record_data->surgon_person_no_fk) ? $anaesthetist_record_data->surgon_person_no_fk : '' }}">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label for="ptOpn"
                                                                                    class="col-form-label col-form-label-sm">Opn</label>
                                                                                <input type="text"
                                                                                    class="form-control form-control-sm"
                                                                                    id="ptOpn" name="ptOpn"
                                                                                    value="{{ isset($anaesthetist_record_data->opn) ? $anaesthetist_record_data->opn : '' }}" />
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label for="ptAnaesth"
                                                                                    class="col-form-label col-form-label-sm">Anaesth</label>
                                                                                <input type="text"
                                                                                    class="form-control form-control-sm"
                                                                                    id="ptAnaesth" name="ptAnaesth"
                                                                                    value="{{ isset($anaesthetist_record_data->anaesth) ? $anaesthetist_record_data->anaesth : '' }}" />
                                                                            </div>
                                                                        </div>

                                                                        <h3 class="mb-0"><strong>Anesthesia Technique
                                                                                : </strong>
                                                                        </h3> <br>
                                                                        <div class="card-body p-3">
                                                                            <div class="form-row">

                                                                                <!-- GA/RA/MAC Section -->
                                                                                <div class="col-md-3">
                                                                                    <fieldset>
                                                                                        <legend>GA/RA/MAC :</legend>

                                                                                        <!-- General Anesthesia -->
                                                                                        <div
                                                                                            class="form-check form-check-inline">
                                                                                            <input
                                                                                                class="form-check-input"
                                                                                                type="checkbox"
                                                                                                name="inlineAccepted"
                                                                                                id="inlineGA1"
                                                                                                value="GA"
                                                                                                {{ isset($anaesthetist_record_data->accepted_for) && $anaesthetist_record_data->accepted_for == 'GA' ? 'checked' : '' }} />
                                                                                            <label
                                                                                                class="form-check-label"
                                                                                                for="inlineGA1">GA</label>
                                                                                        </div>

                                                                                        <!-- Spinal Anesthesia -->
                                                                                        <div
                                                                                            class="form-check form-check-inline">
                                                                                            <input
                                                                                                class="form-check-input"
                                                                                                type="checkbox"
                                                                                                name="inlineAccepted"
                                                                                                id="inlineSA2"
                                                                                                value="SA"
                                                                                                @if (isset($anaesthetist_record_data->accepted_for) && $anaesthetist_record_data->accepted_for == 'SA') checked @endif />
                                                                                            <label
                                                                                                class="form-check-label"
                                                                                                for="inlineSA2">SA</label>
                                                                                        </div>

                                                                                        <!-- Epidural Anesthesia -->
                                                                                        <div
                                                                                            class="form-check form-check-inline">
                                                                                            <input
                                                                                                class="form-check-input"
                                                                                                type="checkbox"
                                                                                                name="inlineAccepted"
                                                                                                id="inlineEA3"
                                                                                                value="EA"
                                                                                                @if (isset($anaesthetist_record_data->accepted_for) && $anaesthetist_record_data->accepted_for == 'EA') checked @endif />
                                                                                            <label
                                                                                                class="form-check-label"
                                                                                                for="inlineEA3">EA</label>
                                                                                        </div>
                                                                                    </fieldset>
                                                                                </div>

                                                                                <!-- Epidural/Caudal/Spinal Section -->
                                                                                <div class="col-md-3">
                                                                                    <fieldset
                                                                                        style="margin-top: 34px;">
                                                                                        <legend>Techniques:</legend>

                                                                                        <!-- Epidural -->
                                                                                        <div
                                                                                            class="form-check form-check-inline">
                                                                                            <input
                                                                                                class="form-check-input"
                                                                                                type="checkbox"
                                                                                                name="inlineRadioEpCaSp"
                                                                                                id="inlineEpCaSp1"
                                                                                                value="Epidural"
                                                                                                @if (isset($anaesthetist_record_data->inlineradioepcasp) && $anaesthetist_record_data->inlineradioepcasp == 'Epidural') checked @endif />
                                                                                            <label
                                                                                                class="form-check-label"
                                                                                                for="inlineEpCaSp1">Epidural</label>
                                                                                        </div>

                                                                                        <!-- Caudal -->
                                                                                        <div
                                                                                            class="form-check form-check-inline">
                                                                                            <input
                                                                                                class="form-check-input"
                                                                                                type="checkbox"
                                                                                                name="inlineRadioEpCaSp"
                                                                                                id="inlineEpCaSp2"
                                                                                                value="Caudal"
                                                                                                @if (isset($anaesthetist_record_data->inlineradioepcasp) && $anaesthetist_record_data->inlineradioepcasp == 'Caudal') checked @endif />
                                                                                            <label
                                                                                                class="form-check-label"
                                                                                                for="inlineEpCaSp2">Caudal</label>
                                                                                        </div>

                                                                                        <!-- Spinal -->
                                                                                        <div
                                                                                            class="form-check form-check-inline">
                                                                                            <input
                                                                                                class="form-check-input"
                                                                                                type="checkbox"
                                                                                                name="inlineRadioEpCaSp"
                                                                                                id="inlineEpCaSp3"
                                                                                                value="Spinal"
                                                                                                @if (isset($anaesthetist_record_data->inlineradioepcasp) && $anaesthetist_record_data->inlineradioepcasp == 'Spinal') checked @endif />
                                                                                            <label
                                                                                                class="form-check-label"
                                                                                                for="inlineEpCaSp3">Spinal</label>
                                                                                        </div>
                                                                                    </fieldset>
                                                                                </div>

                                                                                <!-- Additional Information Section -->
                                                                                <div class="col-md-2">
                                                                                    <div class="form-group">
                                                                                        <label for="technique_others"
                                                                                            class="col-form-label col-form-label-sm">Others</label>
                                                                                        <input type="text"
                                                                                            class="form-control form-control-sm"
                                                                                            id="technique_others"
                                                                                            name="technique_others"
                                                                                            value="{{ isset($anaesthetist_record_data->technique_others) ? $anaesthetist_record_data->technique_others : '' }}" />
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Block Section -->
                                                                                <div class="col-md-2">
                                                                                    <div class="form-group">
                                                                                        <label for="technique_block"
                                                                                            class="col-form-label col-form-label-sm">Block</label>
                                                                                        <input type="text"
                                                                                            class="form-control form-control-sm"
                                                                                            id="technique_block"
                                                                                            name="technique_block"
                                                                                            value=" " />
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Dmim (%) -->
                                                                                <div class="col-md-2">
                                                                                    <div class="form-group">
                                                                                        <label for="ptDmim"
                                                                                            class="col-form-label col-form-label-sm">Dmim<sup>-1</sup>
                                                                                            (%)</label>
                                                                                        <input type="text"
                                                                                            class="form-control form-control-sm"
                                                                                            id="ptDmim"
                                                                                            name="ptDmim"
                                                                                            value="{{ isset($anaesthetist_record_data->dmim) ? $anaesthetist_record_data->dmim : '' }}" />
                                                                                    </div>
                                                                                </div>

                                                                                <!-- N2O (%) -->
                                                                                <div class="col-md-2">
                                                                                    <div class="form-group">
                                                                                        <label for="ptN2O"
                                                                                            class="col-form-label col-form-label-sm">N2O
                                                                                            (%)</label>
                                                                                        <input type="text"
                                                                                            class="form-control form-control-sm"
                                                                                            id="ptN2O"
                                                                                            name="ptN2O"
                                                                                            value="{{ isset($anaesthetist_record_data->n20) ? $anaesthetist_record_data->n20 : '' }}" />
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Lmim (%) -->
                                                                                <div class="col-md-2">
                                                                                    <div class="form-group">
                                                                                        <label for="ptLmim"
                                                                                            class="col-form-label col-form-label-sm">Lmim<sup>-1</sup>
                                                                                            (%)</label>
                                                                                        <input type="text"
                                                                                            class="form-control form-control-sm"
                                                                                            id="ptLmim"
                                                                                            name="ptLmim"
                                                                                            value="{{ isset($anaesthetist_record_data->lmim) ? $anaesthetist_record_data->lmim : '' }}" />
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Lmim Halo (%) -->
                                                                                <div class="col-md-2">
                                                                                    <div class="form-group">
                                                                                        <label for="ptLmimHalo"
                                                                                            class="col-form-label col-form-label-sm">Lmim
                                                                                            Halo (%)</label>
                                                                                        <input type="text"
                                                                                            class="form-control form-control-sm"
                                                                                            id="ptLmimHalo"
                                                                                            name="ptLmimHalo"
                                                                                            value="{{ isset($anaesthetist_record_data->lmim_halo) ? $anaesthetist_record_data->lmim_halo : '' }}" />
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Circuit Used Section -->
                                                                                <div class="col-md-6">
                                                                                    <fieldset>
                                                                                        <legend>Circuit Used :</legend>

                                                                                        <!-- Circle Circuit -->
                                                                                        <div
                                                                                            class="form-check form-check-inline">
                                                                                            <input
                                                                                                class="form-check-input"
                                                                                                type="checkbox"
                                                                                                id="inlineCircle"
                                                                                                value="Circle"
                                                                                                name="circle"
                                                                                                @if (isset($anaesthetist_record_data->ciccuit_circle) && $anaesthetist_record_data->ciccuit_circle == 'Circle') checked @endif />
                                                                                            <label
                                                                                                class="form-check-label"
                                                                                                for="inlineCircle">Circle</label>
                                                                                        </div>

                                                                                        <!-- Bain Circuit -->
                                                                                        <div
                                                                                            class="form-check form-check-inline">
                                                                                            <input
                                                                                                class="form-check-input"
                                                                                                type="checkbox"
                                                                                                id="inlineBain"
                                                                                                name="inlineBain"
                                                                                                value="Bain"
                                                                                                @if (isset($anaesthetist_record_data->ciccuit_bain) && $anaesthetist_record_data->ciccuit_bain == 'Bain') checked @endif />
                                                                                            <label
                                                                                                class="form-check-label"
                                                                                                for="inlineBain">Bain</label>
                                                                                        </div>

                                                                                        <!-- T Piece Circuit -->
                                                                                        <div
                                                                                            class="form-check form-check-inline">
                                                                                            <input
                                                                                                class="form-check-input"
                                                                                                type="checkbox"
                                                                                                id="inlineTpiece"
                                                                                                name="inlineTpiece"
                                                                                                value="T Piece"
                                                                                                @if (isset($anaesthetist_record_data->ciccuit_t_piece) && $anaesthetist_record_data->ciccuit_t_piece == 'T Piece') checked @endif />
                                                                                            <label
                                                                                                class="form-check-label"
                                                                                                for="inlineTpiece">T
                                                                                                Piece</label>
                                                                                        </div>

                                                                                        <!-- Magill Circuit -->
                                                                                        <div
                                                                                            class="form-check form-check-inline">
                                                                                            <input
                                                                                                class="form-check-input"
                                                                                                type="checkbox"
                                                                                                id="inlineMagills"
                                                                                                name="inlineMagills"
                                                                                                value="Magill's"
                                                                                                @if (isset($anaesthetist_record_data->ciccuit_magill) && $anaesthetist_record_data->ciccuit_magill == "Magill's") checked @endif />
                                                                                            <label
                                                                                                class="form-check-label"
                                                                                                for="inlineMagills">Magill's</label>
                                                                                        </div>

                                                                                        <!-- MAP. D.Sodalime Circuit -->
                                                                                        <div
                                                                                            class="form-check form-check-inline">
                                                                                            <input
                                                                                                class="form-check-input"
                                                                                                type="checkbox"
                                                                                                id="inlineMAPDSodalime"
                                                                                                name="inlineMAPDSodalime"
                                                                                                value="MAP. D.Sodalime"
                                                                                                @if (isset($anaesthetist_record_data->ciccuit_sodalime) &&
                                                                                                        $anaesthetist_record_data->ciccuit_sodalime == 'MAP. D.Sodalime') checked @endif />
                                                                                            <label
                                                                                                class="form-check-label"
                                                                                                for="inlineMAPDSodalime">MAP.
                                                                                                D.Sodalime</label>
                                                                                        </div>
                                                                                    </fieldset>
                                                                                </div>

                                                                            </div>
                                                                        </div>



                                                                        <h3 class="mb-0"><strong>Monitoring:</strong>
                                                                        </h3>
                                                                        <div class="card-body p-3">
                                                                            <div class="form-row">
                                                                                <div class="col-md-12">
                                                                                    <fieldset>
                                                                                        <!-- Monitoring Parameters -->
                                                                                        <div
                                                                                            class="form-check form-check-inline">
                                                                                            <label
                                                                                                class="form-check-label"
                                                                                                for="inlinePules">Pulse:</label>
                                                                                            <input
                                                                                                class="form-control form-check-input"
                                                                                                type="text"
                                                                                                id="inlinePules"
                                                                                                name="inlinePules"
                                                                                                value="{{ isset($anaesthetist_record_data->monitoring_pules) ? $anaesthetist_record_data->monitoring_pules : '' }}" />
                                                                                        </div>

                                                                                        <div
                                                                                            class="form-check form-check-inline">
                                                                                            <label
                                                                                                class="form-check-label"
                                                                                                for="inlineBP">BP:</label>
                                                                                            <input
                                                                                                class="form-control form-check-input"
                                                                                                type="text"
                                                                                                id="inlineBP"
                                                                                                name="inlineBP"
                                                                                                value="{{ isset($anaesthetist_record_data->monitoring_bp) ? $anaesthetist_record_data->monitoring_bp : '' }}" />
                                                                                        </div>

                                                                                        <!-- Monitoring Devices (Checkboxes) -->
                                                                                        <div
                                                                                            class="form-check form-check-inline">
                                                                                            <input
                                                                                                class="form-check-input"
                                                                                                type="checkbox"
                                                                                                name="inlineECG"
                                                                                                id="inlineECG"
                                                                                                value=""
                                                                                                {{ isset($anaesthetist_record_data->monitoring_ecg) && $anaesthetist_record_data->monitoring_ecg ? 'checked' : '' }} />
                                                                                            <label
                                                                                                class="form-check-label"
                                                                                                for="inlineECG">ECG</label>
                                                                                        </div>

                                                                                        <div
                                                                                            class="form-check form-check-inline">
                                                                                            <input
                                                                                                class="form-check-input"
                                                                                                type="checkbox"
                                                                                                name="inlineSPO"
                                                                                                id="inlineSPO"
                                                                                                value=""
                                                                                                {{ isset($anaesthetist_record_data->monitoring_spo2) && $anaesthetist_record_data->monitoring_spo2 ? 'checked' : '' }} />
                                                                                            <label
                                                                                                class="form-check-label"
                                                                                                for="inlineSPO">SpO2</label>
                                                                                        </div>

                                                                                        <div
                                                                                            class="form-check form-check-inline">
                                                                                            <input
                                                                                                class="form-check-input"
                                                                                                type="checkbox"
                                                                                                name="inlinePTCO"
                                                                                                id="inlinePTCO"
                                                                                                value=""
                                                                                                {{ isset($anaesthetist_record_data->monitoring_etco2) && $anaesthetist_record_data->monitoring_etco2 ? 'checked' : '' }} />
                                                                                            <label
                                                                                                class="form-check-label"
                                                                                                for="inlinePTCO">ETCO2</label>
                                                                                        </div>

                                                                                        <div
                                                                                            class="form-check form-check-inline">
                                                                                            <input
                                                                                                class="form-check-input"
                                                                                                type="checkbox"
                                                                                                name="nibp"
                                                                                                id="nibp"
                                                                                                value=""
                                                                                                {{ isset($anaesthetist_record_data->monitoring_nibp) && $anaesthetist_record_data->monitoring_nibp ? 'checked' : '' }} />
                                                                                            <label
                                                                                                class="form-check-label"
                                                                                                for="nibp">NIBP</label>
                                                                                        </div>

                                                                                        <div
                                                                                            class="form-check form-check-inline">
                                                                                            <input
                                                                                                class="form-check-input"
                                                                                                type="checkbox"
                                                                                                name="temp"
                                                                                                id="temp"
                                                                                                value=""
                                                                                                {{ isset($anaesthetist_record_data->monitoring_temp) && $anaesthetist_record_data->monitoring_temp ? 'checked' : '' }} />
                                                                                            <label
                                                                                                class="form-check-label"
                                                                                                for="temp">Temp</label>
                                                                                        </div>

                                                                                        <div
                                                                                            class="form-check form-check-inline">
                                                                                            <input
                                                                                                class="form-check-input"
                                                                                                type="checkbox"
                                                                                                name="agent_monitor"
                                                                                                id="agent_monitor"
                                                                                                value=""
                                                                                                {{ isset($anaesthetist_record_data->monitoring_agent) && $anaesthetist_record_data->monitoring_agent ? 'checked' : '' }} />
                                                                                            <label
                                                                                                class="form-check-label"
                                                                                                for="agent_monitor">Agent
                                                                                                Monitor</label>
                                                                                        </div>

                                                                                        <div
                                                                                            class="form-check form-check-inline">
                                                                                            <input
                                                                                                class="form-check-input"
                                                                                                type="checkbox"
                                                                                                name="ng_tube"
                                                                                                id="ng_tube"
                                                                                                value=""
                                                                                                {{ isset($anaesthetist_record_data->monitoring_ng_tube) && $anaesthetist_record_data->monitoring_ng_tube ? 'checked' : '' }} />
                                                                                            <label
                                                                                                class="form-check-label"
                                                                                                for="ng_tube">NG
                                                                                                Tube</label>
                                                                                        </div>

                                                                                        <!-- FiO2 and CVP -->
                                                                                        <div
                                                                                            class="form-check form-check-inline mt-2">
                                                                                            <label
                                                                                                class="form-check-label"
                                                                                                for="fio2">FiO2:</label>
                                                                                            <input
                                                                                                class="form-control form-check-input"
                                                                                                type="text"
                                                                                                id="fio2"
                                                                                                name="fio2"
                                                                                                value="{{ isset($anaesthetist_record_data->fio2) ? $anaesthetist_record_data->fio2 : '' }}" />
                                                                                        </div>

                                                                                        <div
                                                                                            class="form-check form-check-inline mt-2">
                                                                                            <label
                                                                                                class="form-check-label"
                                                                                                for="cvp">CVP
                                                                                                (Site &
                                                                                                Cannula):</label>
                                                                                            <input
                                                                                                class="form-control form-check-input"
                                                                                                type="text"
                                                                                                id="cvp"
                                                                                                name="cvp"
                                                                                                value="{{ isset($anaesthetist_record_data->cvp) ? $anaesthetist_record_data->cvp : '' }}" />
                                                                                        </div>

                                                                                        <!-- Additional Monitoring Devices -->
                                                                                        <div
                                                                                            class="form-check form-check-inline mt-3">
                                                                                            <input
                                                                                                class="form-check-input"
                                                                                                type="checkbox"
                                                                                                name="urinary_catheter"
                                                                                                id="urinary_catheter"
                                                                                                value=""
                                                                                                {{ isset($anaesthetist_record_data->monitoring_urinary_catheter) && $anaesthetist_record_data->monitoring_urinary_catheter ? 'checked' : '' }} />
                                                                                            <label
                                                                                                class="form-check-label"
                                                                                                for="urinary_catheter">Urinary
                                                                                                Catheter</label>
                                                                                        </div>

                                                                                        <div
                                                                                            class="form-check form-check-inline mt-3">
                                                                                            <input
                                                                                                class="form-check-input"
                                                                                                type="checkbox"
                                                                                                name="nmb_monitor"
                                                                                                id="nmb_monitor"
                                                                                                value=""
                                                                                                {{ isset($anaesthetist_record_data->monitoring_nmb) && $anaesthetist_record_data->monitoring_nmb ? 'checked' : '' }} />
                                                                                            <label
                                                                                                class="form-check-label"
                                                                                                for="nmb_monitor">NMB
                                                                                                Monitor</label>
                                                                                        </div>

                                                                                        <div
                                                                                            class="form-check form-check-inline mt-2">
                                                                                            <label
                                                                                                class="form-check-label"
                                                                                                for="art_line">Art
                                                                                                Line (Site &
                                                                                                Cannula):</label>
                                                                                            <input
                                                                                                class="form-control form-check-input"
                                                                                                type="text"
                                                                                                id="art_line"
                                                                                                name="art_line"
                                                                                                value="{{ isset($anaesthetist_record_data->art_line) ? $anaesthetist_record_data->art_line : '' }}" />
                                                                                        </div>

                                                                                        <!-- Others Monitoring Devices -->
                                                                                        <div
                                                                                            class="form-check form-check-inline mt-3">
                                                                                            <label
                                                                                                class="form-check-label"
                                                                                                for="monitoring_others">Others:</label>
                                                                                            <input
                                                                                                class="form-control form-check-input"
                                                                                                type="text"
                                                                                                id="monitoring_others"
                                                                                                name="monitoring_others"
                                                                                                value="{{ isset($anaesthetist_record_data->monitoring_others) ? $anaesthetist_record_data->monitoring_others : '' }}" />
                                                                                        </div>
                                                                                    </fieldset>
                                                                                </div>
                                                                            </div>
                                                                        </div>



                                                                        <div class="col-md-12">
                                                                            <h3>Positioning</h3>
                                                                        </div>

                                                                        <div class="col-md-3">
                                                                            <label for="supine">Supine</label>
                                                                            <input type="text"
                                                                                class="form-control" name="supine"
                                                                                value="{{ isset($anaesthetist_record_data->supine) ? $anaesthetist_record_data->supine : '' }}">
                                                                        </div>

                                                                        <div class="col-md-3">
                                                                            <label for="lithotomy">Lithotomy</label>
                                                                            <input type="text"
                                                                                class="form-control"
                                                                                name="lithotomy"
                                                                                value="{{ isset($anaesthetist_record_data->lithotomy) ? $anaesthetist_record_data->lithotomy : '' }}">
                                                                        </div>

                                                                        <div class="col-md-3">
                                                                            <label for="prone">Prone</label>
                                                                            <input type="text"
                                                                                class="form-control" name="prone"
                                                                                value="{{ isset($anaesthetist_record_data->prone) ? $anaesthetist_record_data->prone : '' }}">
                                                                        </div>

                                                                        <div class="col-md-3">
                                                                            <label for="lateral_r_l">Lateral-R /
                                                                                L</label>
                                                                            <input type="text"
                                                                                class="form-control"
                                                                                name="lateral_r_l"
                                                                                value="{{ isset($anaesthetist_record_data->lateral_r_l) ? $anaesthetist_record_data->lateral_r_l : '' }}">
                                                                        </div>

                                                                        <div class="col-md-3">
                                                                            <label
                                                                                for="positioning_others">Others</label>
                                                                            <input type="text"
                                                                                class="form-control"
                                                                                name="positioning_others"
                                                                                value="{{ isset($anaesthetist_record_data->positioning_others) ? $anaesthetist_record_data->positioning_others : '' }}">
                                                                        </div>

                                                                        <div class="col-md-3">
                                                                            <label for="eye_protected">Eye
                                                                                protected</label>
                                                                            <input type="text"
                                                                                class="form-control"
                                                                                name="eye_protected"
                                                                                value="{{ isset($anaesthetist_record_data->eye_protected) ? $anaesthetist_record_data->eye_protected : '' }}">
                                                                        </div>

                                                                        <div class="col-md-3">
                                                                            <label for="p_point_padded">Pressure point
                                                                                padded</label>
                                                                            <input type="text"
                                                                                class="form-control"
                                                                                name="p_point_padded"
                                                                                value="{{ isset($anaesthetist_record_data->p_point_padded) ? $anaesthetist_record_data->p_point_padded : '' }}">
                                                                        </div>

                                                                        <div class="col-md-3">
                                                                            <label for="troniquet">Troniquet</label>
                                                                            <input type="text"
                                                                                class="form-control"
                                                                                name="troniquet"
                                                                                value="{{ isset($anaesthetist_record_data->troniquet) ? $anaesthetist_record_data->troniquet : '' }}">
                                                                        </div>

                                                                        <div class="col-md-12">
                                                                            <h3>Intubation</h3>
                                                                        </div>

                                                                        <div class="col-md-3">
                                                                            <label for="asleep">Asleep</label>
                                                                            <input type="text"
                                                                                class="form-control" name="asleep"
                                                                                value="{{ isset($anaesthetist_record_data->asleep) ? $anaesthetist_record_data->asleep : '' }}">
                                                                        </div>

                                                                        <div class="col-md-3">
                                                                            <label for="direct">Direct</label>
                                                                            <input type="text"
                                                                                class="form-control" name="direct"
                                                                                value="{{ isset($anaesthetist_record_data->direct) ? $anaesthetist_record_data->direct : '' }}">
                                                                        </div>

                                                                        <div class="col-md-3">
                                                                            <label for="oral">Oral</label>
                                                                            <input type="text"
                                                                                class="form-control" name="oral"
                                                                                value="{{ isset($anaesthetist_record_data->oral) ? $anaesthetist_record_data->oral : '' }}">
                                                                        </div>

                                                                        <div class="col-md-3">
                                                                            <label for="awake">Awake</label>
                                                                            <input type="text"
                                                                                class="form-control" name="awake"
                                                                                value="{{ isset($anaesthetist_record_data->awake) ? $anaesthetist_record_data->awake : '' }}">
                                                                        </div>

                                                                        <div class="col-md-3">
                                                                            <label for="blind">Blind</label>
                                                                            <input type="text"
                                                                                class="form-control" name="blind"
                                                                                value="{{ isset($anaesthetist_record_data->blind) ? $anaesthetist_record_data->blind : '' }}">
                                                                        </div>

                                                                        <div class="col-md-3">
                                                                            <label for="nasal_r_l">Nasal- R /
                                                                                L</label>
                                                                            <input type="text"
                                                                                class="form-control"
                                                                                name="nasal_r_l"
                                                                                value="{{ isset($anaesthetist_record_data->nasal_r_l) ? $anaesthetist_record_data->nasal_r_l : '' }}">
                                                                        </div>

                                                                        <div class="col-md-3">
                                                                            <label for="in_situ">In Situ</label>
                                                                            <input type="text"
                                                                                class="form-control" name="in_situ"
                                                                                value="{{ isset($anaesthetist_record_data->in_situ) ? $anaesthetist_record_data->in_situ : '' }}">
                                                                        </div>

                                                                        <div class="col-md-3">
                                                                            <label for="fibreoptic">Fibreoptic</label>
                                                                            <input type="text"
                                                                                class="form-control"
                                                                                name="fibreoptic"
                                                                                value="{{ isset($anaesthetist_record_data->fibreoptic) ? $anaesthetist_record_data->fibreoptic : '' }}">
                                                                        </div>

                                                                        <div class="col-md-3">
                                                                            <label
                                                                                for="tracheostomy">Tracheostomy</label>
                                                                            <input type="text"
                                                                                class="form-control"
                                                                                name="tracheostomy"
                                                                                value="{{ isset($anaesthetist_record_data->tracheostomy) ? $anaesthetist_record_data->tracheostomy : '' }}">
                                                                        </div>

                                                                        <div class="col-md-3">
                                                                            <label for="rapid_sequence">Rapid
                                                                                sequence</label>
                                                                            <input type="text"
                                                                                class="form-control"
                                                                                name="rapid_sequence"
                                                                                value="{{ isset($anaesthetist_record_data->rapid_sequence) ? $anaesthetist_record_data->rapid_sequence : '' }}">
                                                                        </div>

                                                                        <div class="col-md-3">
                                                                            <label
                                                                                for="ventilation_easy_difficult">Mask
                                                                                ventilation -
                                                                                Easy / Difficult</label>
                                                                            <select name="ventilation_easy_difficult"
                                                                                id="ventilation_easy_difficult"
                                                                                class="form-control">
                                                                                <option value="Easy"
                                                                                    @if (isset($anaesthetist_record_data->ventilation_easy_difficult) &&
                                                                                            $anaesthetist_record_data->ventilation_easy_difficult == 'Easy') selected @endif>
                                                                                    Easy</option>
                                                                                <option value="Difficult"
                                                                                    @if (isset($anaesthetist_record_data->ventilation_easy_difficult) &&
                                                                                            $anaesthetist_record_data->ventilation_easy_difficult == 'Difficult') selected @endif>
                                                                                    Difficult</option>
                                                                            </select>
                                                                        </div>

                                                                        <div class="col-md-3">
                                                                            <label
                                                                                for="Intubation_easy_difficult">Intubation
                                                                                - Easy /
                                                                                Difficult</label>
                                                                            <select name="Intubation_easy_difficult"
                                                                                id="Intubation_easy_difficult"
                                                                                class="form-control">
                                                                                <option value="Easy"
                                                                                    @if (isset($anaesthetist_record_data->Intubation_easy_difficult) &&
                                                                                            $anaesthetist_record_data->Intubation_easy_difficult == 'Easy') selected @endif>
                                                                                    Easy</option>
                                                                                <option value="Difficult"
                                                                                    @if (isset($anaesthetist_record_data->Intubation_easy_difficult) &&
                                                                                            $anaesthetist_record_data->Intubation_easy_difficult == 'Difficult') selected @endif>
                                                                                    Difficult</option>
                                                                            </select>
                                                                        </div>

                                                                        <div class="col-md-3">
                                                                            <label
                                                                                for="external_laryngeal_manipulation">External
                                                                                Laryngeal manipulation</label>
                                                                            <input type="text"
                                                                                class="form-control"
                                                                                name="external_laryngeal_manipulation"
                                                                                value="{{ isset($anaesthetist_record_data->ext_lary_maniptn) ? $anaesthetist_record_data->ext_lary_maniptn : '' }}">
                                                                        </div>

                                                                        <div class="col-md-3">
                                                                            <label for="stylet_bogie">Stylet/
                                                                                Bogie</label>
                                                                            <input type="text"
                                                                                class="form-control"
                                                                                name="stylet_bogie"
                                                                                value="{{ isset($anaesthetist_record_data->stylet_bogie) ? $anaesthetist_record_data->stylet_bogie : '' }}">
                                                                        </div>

                                                                        <div class="col-md-3">
                                                                            <label for="intubation_grade">Intubation
                                                                                grade</label>
                                                                            <input type="text"
                                                                                class="form-control"
                                                                                name="intubation_grade"
                                                                                value="{{ isset($anaesthetist_record_data->intubation_grade) ? $anaesthetist_record_data->intubation_grade : '' }}">
                                                                        </div>

                                                                        <div class="col-md-3">
                                                                            <label for="throat_pack">Throat
                                                                                pack</label>
                                                                            <input type="text"
                                                                                class="form-control"
                                                                                name="throat_pack"
                                                                                value="{{ isset($anaesthetist_record_data->throat_pack) ? $anaesthetist_record_data->throat_pack : '' }}">
                                                                        </div>

                                                                        <div class="col-md-12">
                                                                            <fieldset>
                                                                                <legend>Condition on leaving Recovery
                                                                                    Room (Q.T.)
                                                                                </legend>

                                                                                <div class="col-md-3">
                                                                                    <label
                                                                                        for="awake">Awake</label>
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        name="awake"
                                                                                        value="{{ isset($anaesthetist_record_data->awake) ? $anaesthetist_record_data->awake : '' }}">
                                                                                </div>

                                                                                <div class="col-md-3">
                                                                                    <label
                                                                                        for="rousable">Rousable</label>
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        name="rousable"
                                                                                        value="{{ isset($anaesthetist_record_data->rousable) ? $anaesthetist_record_data->rousable : '' }}">
                                                                                </div>

                                                                                <div class="col-md-3">
                                                                                    <label
                                                                                        for="asleep">Asleep</label>
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        name="asleep"
                                                                                        value="{{ isset($anaesthetist_record_data->asleep) ? $anaesthetist_record_data->asleep : '' }}">
                                                                                </div>
                                                                            </fieldset>
                                                                        </div>


                                                                        <div>
                                                                            <strong>Volume :</strong>
                                                                        </div>

                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label for="ptPeFe"
                                                                                    class="col-form-label col-form-label-sm">
                                                                                    <div class="form-check form-check-inline"
                                                                                        style="margin-right: 0px;">
                                                                                        <input
                                                                                            class="form-check-input"
                                                                                            type="radio"
                                                                                            name="inlinePeFe"
                                                                                            id="inlinePeFe1"
                                                                                            value="Peth"
                                                                                            @if (isset($anaesthetist_record_data->peth_fenta) && $anaesthetist_record_data->peth_fenta == 'Peth') checked @endif />
                                                                                        <label
                                                                                            class="form-check-label"
                                                                                            for="inlinePeFe1">Peth</label>
                                                                                    </div>
                                                                                    &nbsp;/&nbsp;
                                                                                    <div class="form-check form-check-inline"
                                                                                        style="margin-right: 0px;">
                                                                                        <input
                                                                                            class="form-check-input"
                                                                                            type="radio"
                                                                                            name="inlinePeFe"
                                                                                            id="inlinePeFe2"
                                                                                            value="Fenta"
                                                                                            @if (isset($anaesthetist_record_data->peth_fenta) && $anaesthetist_record_data->peth_fenta == 'Fenta') checked @endif />
                                                                                        <label
                                                                                            class="form-check-label"
                                                                                            for="inlinePeFe2">Fenta</label>
                                                                                    </div>
                                                                                </label>
                                                                                <input type="text"
                                                                                    class="form-control form-control-sm"
                                                                                    id="ptPeFe" name="ptPeFe"
                                                                                    value="{{ isset($anaesthetist_record_data->peth_fenta_text) ? $anaesthetist_record_data->peth_fenta_text : '' }}" />
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label for="ptDiMi"
                                                                                    class="col-form-label col-form-label-sm">
                                                                                    <div class="form-check form-check-inline"
                                                                                        style="margin-right: 0px;">
                                                                                        <input
                                                                                            class="form-check-input"
                                                                                            type="radio"
                                                                                            name="inlineDiMi"
                                                                                            id="inlineDiMi1"
                                                                                            value="Diaz"
                                                                                            @if (isset($anaesthetist_record_data->diaz_mida) && $anaesthetist_record_data->diaz_mida == 'Diaz') checked @endif />
                                                                                        <label
                                                                                            class="form-check-label"
                                                                                            for="inlineDiMi1">Diaz</label>
                                                                                    </div>
                                                                                    &nbsp;/&nbsp;
                                                                                    <div class="form-check form-check-inline"
                                                                                        style="margin-right: 0px;">
                                                                                        <input
                                                                                            class="form-check-input"
                                                                                            type="radio"
                                                                                            name="inlineDiMi"
                                                                                            id="inlineDiMi2"
                                                                                            value="Mida"
                                                                                            @if (isset($anaesthetist_record_data->diaz_mida) && $anaesthetist_record_data->diaz_mida == 'Mida') checked @endif />
                                                                                        <label
                                                                                            class="form-check-label"
                                                                                            for="inlineDiMi2">Mida</label>
                                                                                    </div>
                                                                                </label>
                                                                                <input type="text"
                                                                                    class="form-control form-control-sm"
                                                                                    id="ptDiMi" name="ptDiMi"
                                                                                    value="{{ isset($anaesthetist_record_data->diaz_mida_text) ? $anaesthetist_record_data->diaz_mida_text : '' }}" />
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label for="ptTPS"
                                                                                    class="col-form-label col-form-label-sm">TPS</label>
                                                                                <input type="text"
                                                                                    class="form-control form-control-sm"
                                                                                    id="ptTPS" name="ptTPS"
                                                                                    value="{{ isset($anaesthetist_record_data->tps) ? $anaesthetist_record_data->tps : '' }}" />
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-3">
                                                                            <div class="form-group"
                                                                                style="margin-top: 10px;">
                                                                                <label for="others_volume"
                                                                                    class="col-form-label col-form-label-sm">Others</label>
                                                                                <input type="text"
                                                                                    class="form-control form-control-sm"
                                                                                    id="others_volume"
                                                                                    name="others_volume"
                                                                                    value="{{ isset($anaesthetist_record_data->others_volume) ? $anaesthetist_record_data->others_volume : '' }}" />
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-12">
                                                                            <fieldset>
                                                                                <legend>Type & Needle Size</legend>
                                                                                <div class="row">
                                                                                    <div class="col-sm-4">
                                                                                        <div class="form-group">
                                                                                            <label for="ptSpace"
                                                                                                class="col-form-label col-form-label-sm">Space</label>
                                                                                            <input type="text"
                                                                                                class="form-control form-control-sm"
                                                                                                id="ptSpace"
                                                                                                name="ptSpace"
                                                                                                value="{{ isset($anaesthetist_record_data->space) ? $anaesthetist_record_data->space : '' }}" />
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-sm-4">
                                                                                        <div class="form-group">
                                                                                            <label for="ptDrug"
                                                                                                class="col-form-label col-form-label-sm">Drug</label>
                                                                                            <input type="text"
                                                                                                class="form-control form-control-sm"
                                                                                                id="ptDrug"
                                                                                                name="ptDrug"
                                                                                                value="{{ isset($anaesthetist_record_data->drug) ? $anaesthetist_record_data->drug : '' }}" />
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-sm-4">
                                                                                        <div class="form-group">
                                                                                            <label for="ptDose"
                                                                                                class="col-form-label col-form-label-sm">Dose</label>
                                                                                            <input type="text"
                                                                                                class="form-control form-control-sm"
                                                                                                id="ptDose"
                                                                                                name="ptDose"
                                                                                                value="{{ isset($anaesthetist_record_data->dose) ? $anaesthetist_record_data->dose : '' }}" />
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-sm-4">
                                                                                        <div class="form-group">
                                                                                            <label for="ptAdjuvant"
                                                                                                class="col-form-label col-form-label-sm">Adjuvant</label>
                                                                                            <input type="text"
                                                                                                class="form-control form-control-sm"
                                                                                                id="ptAdjuvant"
                                                                                                name="ptAdjuvant"
                                                                                                value="{{ isset($anaesthetist_record_data->adjuvant) ? $anaesthetist_record_data->adjuvant : '' }}" />
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-sm-4">
                                                                                        <div class="form-group">
                                                                                            <label for="ptVolume"
                                                                                                class="col-form-label col-form-label-sm">Volume</label>
                                                                                            <input type="text"
                                                                                                class="form-control form-control-sm"
                                                                                                id="ptVolume"
                                                                                                name="ptVolume"
                                                                                                value="{{ isset($anaesthetist_record_data->volume) ? $anaesthetist_record_data->volume : '' }}" />
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </fieldset>
                                                                        </div>

                                                                        <div class="col-md-12">
                                                                            <fieldset>
                                                                                <legend>Airway (Write size):</legend>
                                                                                <div class="row">
                                                                                    <div class="col-sm-12">
                                                                                        <div class="form-group">
                                                                                            <strong>Supraglottic
                                                                                                airway</strong>
                                                                                            <div class="input-group">
                                                                                                <input type="text"
                                                                                                    class="form-control form-control-sm"
                                                                                                    id="supraglottic_airway"
                                                                                                    name="supraglottic_airway"
                                                                                                    value="{{ isset($anaesthetist_record_data->supraglottic_airway) ? $anaesthetist_record_data->supraglottic_airway : '' }}"
                                                                                                    placeholder="" />
                                                                                            </div>
                                                                                            <label for=""
                                                                                                class="col-form-label col-form-label-sm">
                                                                                                <div class="form-check form-check-inline"
                                                                                                    style="margin-right: 0px;">
                                                                                                    <input
                                                                                                        class="form-check-input"
                                                                                                        type="radio"
                                                                                                        name="inlineRadioFaceMaskEtt"
                                                                                                        id="inlineFaceMaskEtt1"
                                                                                                        value="Face mask"
                                                                                                        @if (isset($anaesthetist_record_data->airway) && $anaesthetist_record_data->airway == 'Face mask') checked @endif />
                                                                                                    <label
                                                                                                        class="form-check-label"
                                                                                                        for="inlineFaceMaskEtt1">Face
                                                                                                        mask</label>
                                                                                                </div>
                                                                                                &nbsp;/&nbsp;
                                                                                                <div class="form-check form-check-inline"
                                                                                                    style="margin-right: 0px;">
                                                                                                    <input
                                                                                                        class="form-check-input"
                                                                                                        type="radio"
                                                                                                        name="inlineRadioFaceMaskEtt"
                                                                                                        id="inlineFaceMaskEtt2"
                                                                                                        value="ETT"
                                                                                                        @if (isset($anaesthetist_record_data->airway) && $anaesthetist_record_data->airway == 'ETT') checked @endif />
                                                                                                    <label
                                                                                                        class="form-check-label"
                                                                                                        for="inlineFaceMaskEtt2">ETT</label>
                                                                                                </div>
                                                                                            </label>

                                                                                            &nbsp; : &nbsp;

                                                                                            <label for=""
                                                                                                class="col-form-label col-form-label-sm">
                                                                                                <div class="form-check form-check-inline"
                                                                                                    style="margin-right: 0px;">
                                                                                                    <input
                                                                                                        class="form-check-input"
                                                                                                        type="radio"
                                                                                                        name="inlineRadioOraNasal"
                                                                                                        id="inlineOraNasal1"
                                                                                                        value="Ora"
                                                                                                        @if (isset($anaesthetist_record_data->airway_ora_nasal) && $anaesthetist_record_data->airway_ora_nasal == 'Ora') checked @endif />
                                                                                                    <label
                                                                                                        class="form-check-label"
                                                                                                        for="inlineOraNasal1">Ora</label>
                                                                                                </div>
                                                                                                &nbsp;/&nbsp;
                                                                                                <div class="form-check form-check-inline"
                                                                                                    style="margin-right: 0px;">
                                                                                                    <input
                                                                                                        class="form-check-input"
                                                                                                        type="radio"
                                                                                                        name="inlineRadioOraNasal"
                                                                                                        id="inlineOraNasal2"
                                                                                                        value="Nasal"
                                                                                                        @if (isset($anaesthetist_record_data->airway_ora_nasal) && $anaesthetist_record_data->airway_ora_nasal == 'Nasal') checked @endif />
                                                                                                    <label
                                                                                                        class="form-check-label"
                                                                                                        for="inlineOraNasal2">Nasal</label>
                                                                                                </div>
                                                                                            </label>
                                                                                            <div class="input-group">
                                                                                                <input type="text"
                                                                                                    class="form-control form-control-sm"
                                                                                                    id="faceMett"
                                                                                                    name="faceMett"
                                                                                                    value="{{ isset($anaesthetist_record_data->airway_text) ? $anaesthetist_record_data->airway_text : '' }}"
                                                                                                    placeholder="Size:---(mm)" />
                                                                                            </div>
                                                                                            <strong>ETT (Cuffed/Non
                                                                                                cuffed)</strong>
                                                                                            <div class="input-group">
                                                                                                <input type="text"
                                                                                                    class="form-control form-control-sm"
                                                                                                    id="ett_cuffed_non_cuffed"
                                                                                                    name="ett_cuffed_non_cuffed"
                                                                                                    value="{{ isset($anaesthetist_record_data->ett_cuffed_non_cuffed) ? $anaesthetist_record_data->ett_cuffed_non_cuffed : '' }}"
                                                                                                    placeholder="" />
                                                                                            </div>
                                                                                            <strong>Tracheostomy</strong>
                                                                                            <div class="input-group">
                                                                                                <input type="text"
                                                                                                    class="form-control form-control-sm"
                                                                                                    id="tracheostomy"
                                                                                                    name="tracheostomy"
                                                                                                    value="{{ isset($anaesthetist_record_data->tracheostomy) ? $anaesthetist_record_data->tracheostomy : '' }}"
                                                                                                    placeholder="" />
                                                                                            </div>

                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-12">
                                                                                        <h3>Breathing system</h3>
                                                                                    </div>
                                                                                    <div class="col-md-3">
                                                                                        <strong>Circle</strong>
                                                                                        <div class="input-group">
                                                                                            <input type="text"
                                                                                                class="form-control form-control-sm"
                                                                                                id="circle"
                                                                                                name="circle"
                                                                                                value="{{ isset($anaesthetist_record_data->circle) ? $anaesthetist_record_data->circle : '' }}"
                                                                                                placeholder="" />
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-3">
                                                                                        <strong>Bain’s</strong>
                                                                                        <div class="input-group">
                                                                                            <input type="text"
                                                                                                class="form-control form-control-sm"
                                                                                                id="bains"
                                                                                                name="bains"
                                                                                                value="{{ isset($anaesthetist_record_data->bains) ? $anaesthetist_record_data->bains : '' }}"
                                                                                                placeholder="" />
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-3">
                                                                                        <strong>Ayre’s T pice</strong>
                                                                                        <div class="input-group">
                                                                                            <input type="text"
                                                                                                class="form-control form-control-sm"
                                                                                                id="ayres_t_pice"
                                                                                                name="ayres_t_pice"
                                                                                                value="{{ isset($anaesthetist_record_data->ayres_t_pice) ? $anaesthetist_record_data->ayres_t_pice : '' }}"
                                                                                                placeholder="" />
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-3">
                                                                                        <strong>O <sub>2</sub>
                                                                                            supplement
                                                                                            only</strong>
                                                                                        <div class="input-group">
                                                                                            <input type="text"
                                                                                                class="form-control form-control-sm"
                                                                                                id="supplement_only"
                                                                                                name="supplement_only"
                                                                                                value="{{ isset($anaesthetist_record_data->supplement_only) ? $anaesthetist_record_data->supplement_only : '' }}"
                                                                                                placeholder="" />
                                                                                        </div>

                                                                                    </div>
                                                                                    <div class="col-md-12">
                                                                                        <h3>Ventilation</h3>
                                                                                    </div>

                                                                                    <div class="col-md-3">
                                                                                        <strong>Controlled</strong>
                                                                                        <div class="input-group">
                                                                                            <input type="text"
                                                                                                class="form-control form-control-sm"
                                                                                                id="controlled"
                                                                                                name="controlled"
                                                                                                value="{{ isset($anaesthetist_record_data->controlled) ? $anaesthetist_record_data->controlled : '' }}"
                                                                                                placeholder="" />
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-3">
                                                                                        <strong>Spontaneous/
                                                                                            Assisted</strong>
                                                                                        <div class="input-group">
                                                                                            <input type="text"
                                                                                                class="form-control form-control-sm"
                                                                                                id="spontaneous_assisted"
                                                                                                name="spontaneous_assisted"
                                                                                                value="{{ isset($anaesthetist_record_data->spontaneous_assisted) ? $anaesthetist_record_data->spontaneous_assisted : '' }}"
                                                                                                placeholder="" />
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-3">
                                                                                        <strong>HFV/ Jet
                                                                                            ventilation</strong>
                                                                                        <div class="input-group">
                                                                                            <input type="text"
                                                                                                class="form-control form-control-sm"
                                                                                                id="hfv_jet_ventilation"
                                                                                                name="hfv_jet_ventilation"
                                                                                                value="{{ isset($anaesthetist_record_data->hfv_jet_ventilation) ? $anaesthetist_record_data->hfv_jet_ventilation : '' }}"
                                                                                                placeholder="" />
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-3">
                                                                                        <strong>Ventilator</strong>
                                                                                        <div class="input-group">
                                                                                            <input type="text"
                                                                                                class="form-control form-control-sm"
                                                                                                id="ventilator"
                                                                                                name="ventilator"
                                                                                                value=""
                                                                                                placeholder="" />
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-md-12">
                                                                                        <h3>Gas</h3>
                                                                                    </div>

                                                                                    <div class="col-md-3">
                                                                                        <strong>O<sub>2</sub></strong>
                                                                                        <div class="input-group">
                                                                                            <input type="text"
                                                                                                class="form-control form-control-sm"
                                                                                                id="o2"
                                                                                                name="o2"
                                                                                                value="{{ isset($anaesthetist_record_data->o2) ? $anaesthetist_record_data->o2 : '' }}"
                                                                                                placeholder="" />
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-md-3">
                                                                                        <strong>N<sub>2</sub> O</strong>
                                                                                        <div class="input-group">
                                                                                            <input type="text"
                                                                                                class="form-control form-control-sm"
                                                                                                id="n2o"
                                                                                                name="n2o"
                                                                                                value="{{ isset($anaesthetist_record_data->n2o) ? $anaesthetist_record_data->n2o : '' }}"
                                                                                                placeholder="" />
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-md-3">
                                                                                        <strong>Air</strong>
                                                                                        <div class="input-group">
                                                                                            <input type="text"
                                                                                                class="form-control form-control-sm"
                                                                                                id="air"
                                                                                                name="air"
                                                                                                value="{{ isset($anaesthetist_record_data->air) ? $anaesthetist_record_data->air : '' }}"
                                                                                                placeholder="" />
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-md-12">
                                                                                        <h3>Regional Techniques (1)</h3>
                                                                                    </div>

                                                                                    <div class="col-md-3">
                                                                                        <strong>Type</strong>
                                                                                        <div class="input-group">
                                                                                            <input type="text"
                                                                                                class="form-control form-control-sm"
                                                                                                id="regional_type"
                                                                                                name="regional_type"
                                                                                                value="{{ isset($anaesthetist_record_data->regional_type) ? $anaesthetist_record_data->regional_type : '' }}"
                                                                                                placeholder="" />
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-md-3">
                                                                                        <strong>Site/Approach/Level</strong>
                                                                                        <div class="input-group">
                                                                                            <input type="text"
                                                                                                class="form-control form-control-sm"
                                                                                                id="site_approach_level"
                                                                                                name="site_approach_level"
                                                                                                value="{{ isset($anaesthetist_record_data->site_approach_level) ? $anaesthetist_record_data->site_approach_level : '' }}"
                                                                                                placeholder="" />
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-md-3">
                                                                                        <strong>Needle</strong>
                                                                                        <div class="input-group">
                                                                                            <input type="text"
                                                                                                class="form-control form-control-sm"
                                                                                                id="needle"
                                                                                                name="needle"
                                                                                                value="{{ isset($anaesthetist_record_data->needle) ? $anaesthetist_record_data->needle : '' }}"
                                                                                                placeholder="" />
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-md-3">
                                                                                        <strong>Needle Size</strong>
                                                                                        <div class="input-group">
                                                                                            <input type="text"
                                                                                                class="form-control form-control-sm"
                                                                                                id="needle_size"
                                                                                                name="needle_size"
                                                                                                value="{{ isset($anaesthetist_record_data->needle_size) ? $anaesthetist_record_data->needle_size : '' }}"
                                                                                                placeholder="" />
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-3">
                                                                                        <strong>Catheter</strong>
                                                                                        <div class="input-group">
                                                                                            <input type="text"
                                                                                                class="form-control form-control-sm"
                                                                                                id="catheter"
                                                                                                name="catheter"
                                                                                                value="{{ isset($anaesthetist_record_data->catheter) ? $anaesthetist_record_data->catheter : '' }}"
                                                                                                placeholder="" />
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-md-3">
                                                                                        <strong>Ultrasound
                                                                                            Guided</strong>
                                                                                        <div class="input-group">
                                                                                            <input type="text"
                                                                                                class="form-control form-control-sm"
                                                                                                id="ultrasound_guided"
                                                                                                name="ultrasound_guided"
                                                                                                value="{{ isset($anaesthetist_record_data->ultrasound_guided) ? $anaesthetist_record_data->ultrasound_guided : '' }}"
                                                                                                placeholder="" />
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-md-3">
                                                                                        <strong>Nerve
                                                                                            Stimulator</strong>
                                                                                        <div class="input-group">
                                                                                            <input type="text"
                                                                                                class="form-control form-control-sm"
                                                                                                id="nerve_stimulator"
                                                                                                name="nerve_stimulator"
                                                                                                value="{{ isset($anaesthetist_record_data->nerve_stimulator) ? $anaesthetist_record_data->nerve_stimulator : '' }}"
                                                                                                placeholder="" />
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-md-3">
                                                                                        <strong>Drugs</strong>
                                                                                        <div class="input-group">
                                                                                            <input type="text"
                                                                                                class="form-control form-control-sm"
                                                                                                id="drugs"
                                                                                                name="drugs"
                                                                                                value="{{ isset($anaesthetist_record_data->drugs) ? $anaesthetist_record_data->drugs : '' }}"
                                                                                                placeholder="" />
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-md-3">
                                                                                        <strong>Assessment -
                                                                                            Complete/Partial/Failed</strong>
                                                                                        <div class="input-group">
                                                                                            <input type="text"
                                                                                                class="form-control form-control-sm"
                                                                                                id="Assessment_Complete_partial"
                                                                                                name="Assessment_Complete_partial"
                                                                                                value="{{ isset($anaesthetist_record_data->ass_comp_partial) ? $anaesthetist_record_data->ass_comp_partial : '' }}"
                                                                                                placeholder="" />
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-md-3">
                                                                                        <strong>Anesthetic Drug</strong>
                                                                                        <div class="input-group">
                                                                                            <input type="text"
                                                                                                class="form-control form-control-sm"
                                                                                                id="anesthetic_drug"
                                                                                                name="anesthetic_drug"
                                                                                                value=""
                                                                                                placeholder="" />
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-md-3">
                                                                                        <strong>Adjuvant Drugs</strong>
                                                                                        <div class="input-group">
                                                                                            <input type="text"
                                                                                                class="form-control form-control-sm"
                                                                                                id="adjuvant_drugs"
                                                                                                name="adjuvant_drugs"
                                                                                                value=""
                                                                                                placeholder="" />
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-md-3">
                                                                                        <strong>Assessment</strong>
                                                                                        <div class="input-group">
                                                                                            <select name="assessment"
                                                                                                id="assessment"
                                                                                                class="form-control">
                                                                                                <option
                                                                                                    value="Complete">
                                                                                                    Complete
                                                                                                </option>
                                                                                                <option
                                                                                                    value="Partial">
                                                                                                    Partial
                                                                                                </option>
                                                                                                <option
                                                                                                    value="Failed">
                                                                                                    Failed</option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-md-3">
                                                                                        <strong>Single Shot</strong>
                                                                                        <div class="input-group">
                                                                                            <div
                                                                                                class="form-check form-check-inline">
                                                                                                <input
                                                                                                    class="form-check-input"
                                                                                                    type="radio"
                                                                                                    name="inlinesingle_shot"
                                                                                                    id="single_shot1"
                                                                                                    value="Yes" />
                                                                                                <label
                                                                                                    class="form-check-label"
                                                                                                    for="single_shot1">Yes</label>
                                                                                            </div>
                                                                                            <div
                                                                                                class="form-check form-check-inline">
                                                                                                <input
                                                                                                    class="form-check-input"
                                                                                                    type="radio"
                                                                                                    name="inlinesingle_shot"
                                                                                                    id="single_shot2"
                                                                                                    value="No" />
                                                                                                <label
                                                                                                    class="form-check-label"
                                                                                                    for="single_shot2">No</label>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-md-3">
                                                                                        <strong>Nerve
                                                                                            Stimulator</strong>
                                                                                        <div class="input-group">
                                                                                            <div
                                                                                                class="form-check form-check-inline">
                                                                                                <input
                                                                                                    class="form-check-input"
                                                                                                    type="radio"
                                                                                                    name="nerve_stimulator_radio"
                                                                                                    id="nerve_stimulator_yes"
                                                                                                    value="Yes" />
                                                                                                <label
                                                                                                    class="form-check-label"
                                                                                                    for="nerve_stimulator_yes">Yes</label>
                                                                                            </div>
                                                                                            <div
                                                                                                class="form-check form-check-inline">
                                                                                                <input
                                                                                                    class="form-check-input"
                                                                                                    type="radio"
                                                                                                    name="nerve_stimulator_radio"
                                                                                                    id="nerve_stimulator_no"
                                                                                                    value="No" />
                                                                                                <label
                                                                                                    class="form-check-label"
                                                                                                    for="nerve_stimulator_no">No</label>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-md-3">
                                                                                        <strong>USG</strong>
                                                                                        <div class="input-group">
                                                                                            <div
                                                                                                class="form-check form-check-inline">
                                                                                                <input
                                                                                                    class="form-check-input"
                                                                                                    type="radio"
                                                                                                    name="usg"
                                                                                                    id="usg_yes"
                                                                                                    value="Yes" />
                                                                                                <label
                                                                                                    class="form-check-label"
                                                                                                    for="usg_yes">Yes</label>
                                                                                            </div>
                                                                                            <div
                                                                                                class="form-check form-check-inline">
                                                                                                <input
                                                                                                    class="form-check-input"
                                                                                                    type="radio"
                                                                                                    name="usg"
                                                                                                    id="usg_no"
                                                                                                    value="No" />
                                                                                                <label
                                                                                                    class="form-check-label"
                                                                                                    for="usg_no">No</label>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>


                                                                                    <div class="col-md-12">
                                                                                        <h3>Regional Techniques (2)</h3>
                                                                                    </div>

                                                                                    <div class="col-md-3">
                                                                                        <strong>Type</strong>
                                                                                        <div class="input-group">
                                                                                            <input type="text"
                                                                                                class="form-control form-control-sm"
                                                                                                id="regional_type"
                                                                                                name="regional_type"
                                                                                                value="{{ isset($anaesthetist_record_data->regional_type) ? $anaesthetist_record_data->regional_type : '' }}"
                                                                                                placeholder="" />
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-md-3">
                                                                                        <strong>Site/Approach/Level</strong>
                                                                                        <div class="input-group">
                                                                                            <input type="text"
                                                                                                class="form-control form-control-sm"
                                                                                                id="site_approach_level"
                                                                                                name="site_approach_level"
                                                                                                value="{{ isset($anaesthetist_record_data->site_approach_level) ? $anaesthetist_record_data->site_approach_level : '' }}"
                                                                                                placeholder="" />
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-md-3">
                                                                                        <strong>Needle</strong>
                                                                                        <div class="input-group">
                                                                                            <input type="text"
                                                                                                class="form-control form-control-sm"
                                                                                                id="needle"
                                                                                                name="needle"
                                                                                                value="{{ isset($anaesthetist_record_data->needle) ? $anaesthetist_record_data->needle : '' }}"
                                                                                                placeholder="" />
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-md-3">
                                                                                        <strong>Needle Size</strong>
                                                                                        <div class="input-group">
                                                                                            <input type="text"
                                                                                                class="form-control form-control-sm"
                                                                                                id="needle_size"
                                                                                                name="needle_size"
                                                                                                value="{{ isset($anaesthetist_record_data->needle_size) ? $anaesthetist_record_data->needle_size : '' }}"
                                                                                                placeholder="" />
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-md-3">
                                                                                        <strong>Catheter</strong>
                                                                                        <div class="input-group">
                                                                                            <input type="text"
                                                                                                class="form-control form-control-sm"
                                                                                                id="catheter"
                                                                                                name="catheter"
                                                                                                value="{{ isset($anaesthetist_record_data->catheter) ? $anaesthetist_record_data->catheter : '' }}"
                                                                                                placeholder="" />
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-md-3">
                                                                                        <strong>Ultrasound
                                                                                            Guided</strong>
                                                                                        <div class="input-group">
                                                                                            <input type="text"
                                                                                                class="form-control form-control-sm"
                                                                                                id="ultrasound_guided"
                                                                                                name="ultrasound_guided"
                                                                                                value="{{ isset($anaesthetist_record_data->ultrasound_guided) ? $anaesthetist_record_data->ultrasound_guided : '' }}"
                                                                                                placeholder="" />
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-md-3">
                                                                                        <strong>Nerve
                                                                                            Stimulator</strong>
                                                                                        <div class="input-group">
                                                                                            <input type="text"
                                                                                                class="form-control form-control-sm"
                                                                                                id="nerve_stimulator"
                                                                                                name="nerve_stimulator"
                                                                                                value="{{ isset($anaesthetist_record_data->nerve_stimulator) ? $anaesthetist_record_data->nerve_stimulator : '' }}"
                                                                                                placeholder="" />
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-md-3">
                                                                                        <strong>Drugs</strong>
                                                                                        <div class="input-group">
                                                                                            <input type="text"
                                                                                                class="form-control form-control-sm"
                                                                                                id="drugs"
                                                                                                name="drugs"
                                                                                                value="{{ isset($anaesthetist_record_data->drugs) ? $anaesthetist_record_data->drugs : '' }}"
                                                                                                placeholder="" />
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-md-3">
                                                                                        <strong>Assessment -
                                                                                            Complete/Partial/Failed</strong>
                                                                                        <div class="input-group">
                                                                                            <input type="text"
                                                                                                class="form-control form-control-sm"
                                                                                                id="Assessment_Complete_partial"
                                                                                                name="Assessment_Complete_partial"
                                                                                                value="{{ isset($anaesthetist_record_data->ass_comp_partial) ? $anaesthetist_record_data->ass_comp_partial : '' }}"
                                                                                                placeholder="" />
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-md-3">
                                                                                        <strong>Anesthetic Drug</strong>
                                                                                        <div class="input-group">
                                                                                            <input type="text"
                                                                                                class="form-control form-control-sm"
                                                                                                id="anesthetic_drug"
                                                                                                name="anesthetic_drug"
                                                                                                value=""
                                                                                                placeholder="" />
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-md-3">
                                                                                        <strong>Adjuvant Drugs</strong>
                                                                                        <div class="input-group">
                                                                                            <input type="text"
                                                                                                class="form-control form-control-sm"
                                                                                                id="adjuvant_drugs"
                                                                                                name="adjuvant_drugs"
                                                                                                value=""
                                                                                                placeholder="" />
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-md-3">
                                                                                        <strong>Assessment</strong>
                                                                                        <div class="input-group">
                                                                                            <select name="assessment"
                                                                                                id="assessment"
                                                                                                class="form-control">
                                                                                                <option
                                                                                                    value="Complete">
                                                                                                    Complete
                                                                                                </option>
                                                                                                <option
                                                                                                    value="Partial">
                                                                                                    Partial
                                                                                                </option>
                                                                                                <option
                                                                                                    value="Failed">
                                                                                                    Failed</option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-md-3">
                                                                                        <strong>Single Shot</strong>
                                                                                        <div class="input-group">
                                                                                            <div
                                                                                                class="form-check form-check-inline">
                                                                                                <input
                                                                                                    class="form-check-input"
                                                                                                    type="radio"
                                                                                                    name="inlinesingle_shot"
                                                                                                    id="single_shot1"
                                                                                                    value="Yes" />
                                                                                                <label
                                                                                                    class="form-check-label"
                                                                                                    for="single_shot1">Yes</label>
                                                                                            </div>
                                                                                            <div
                                                                                                class="form-check form-check-inline">
                                                                                                <input
                                                                                                    class="form-check-input"
                                                                                                    type="radio"
                                                                                                    name="inlinesingle_shot"
                                                                                                    id="single_shot2"
                                                                                                    value="No" />
                                                                                                <label
                                                                                                    class="form-check-label"
                                                                                                    for="single_shot2">No</label>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-md-3">
                                                                                        <strong>Nerve
                                                                                            Stimulator</strong>
                                                                                        <div class="input-group">
                                                                                            <div
                                                                                                class="form-check form-check-inline">
                                                                                                <input
                                                                                                    class="form-check-input"
                                                                                                    type="radio"
                                                                                                    name="nerve_stimulator_radio"
                                                                                                    id="nerve_stimulator_yes"
                                                                                                    value="Yes" />
                                                                                                <label
                                                                                                    class="form-check-label"
                                                                                                    for="nerve_stimulator_yes">Yes</label>
                                                                                            </div>
                                                                                            <div
                                                                                                class="form-check form-check-inline">
                                                                                                <input
                                                                                                    class="form-check-input"
                                                                                                    type="radio"
                                                                                                    name="nerve_stimulator_radio"
                                                                                                    id="nerve_stimulator_no"
                                                                                                    value="No" />
                                                                                                <label
                                                                                                    class="form-check-label"
                                                                                                    for="nerve_stimulator_no">No</label>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-md-3">
                                                                                        <strong>USG</strong>
                                                                                        <div class="input-group">
                                                                                            <div
                                                                                                class="form-check form-check-inline">
                                                                                                <input
                                                                                                    class="form-check-input"
                                                                                                    type="radio"
                                                                                                    name="usg"
                                                                                                    id="usg_yes"
                                                                                                    value="Yes" />
                                                                                                <label
                                                                                                    class="form-check-label"
                                                                                                    for="usg_yes">Yes</label>
                                                                                            </div>
                                                                                            <div
                                                                                                class="form-check form-check-inline">
                                                                                                <input
                                                                                                    class="form-check-input"
                                                                                                    type="radio"
                                                                                                    name="usg"
                                                                                                    id="usg_no"
                                                                                                    value="No" />
                                                                                                <label
                                                                                                    class="form-check-label"
                                                                                                    for="usg_no">No</label>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>



                                                                                    {{-- <div class="col-md-12"><h3>Condition on leaving OT</h3></div> --}}
                                                                                    <div class="col-md-12">
                                                                                        <h3>At the End of Operation</h3>
                                                                                    </div>

                                                                                    <div class="col-md-3">
                                                                                        <strong>Induction Agent
                                                                                            Used</strong>
                                                                                        <div class="input-group">
                                                                                            <input type="text"
                                                                                                class="form-control form-control-sm"
                                                                                                id="induction_agent_used"
                                                                                                name="induction_agent_used"
                                                                                                value="{{ isset($anaesthetist_record_data->induction_agent_used) ? $anaesthetist_record_data->induction_agent_used : '' }}"
                                                                                                placeholder="" />
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-md-3">
                                                                                        <strong>Analgesic Used</strong>
                                                                                        <div class="input-group">
                                                                                            <input type="text"
                                                                                                class="form-control form-control-sm"
                                                                                                id="analgesia_used"
                                                                                                name="analgesia_used"
                                                                                                value="{{ isset($anaesthetist_record_data->analgesia_used) ? $anaesthetist_record_data->analgesia_used : '' }}"
                                                                                                placeholder="" />
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-md-3">
                                                                                        <strong>Muscle Relaxant
                                                                                            Used</strong>
                                                                                        <div class="input-group">
                                                                                            <input type="text"
                                                                                                class="form-control form-control-sm"
                                                                                                id="muscle_relaxant_used"
                                                                                                name="muscle_relaxant_used"
                                                                                                value="{{ isset($anaesthetist_record_data->muscle_relaxant_used) ? $anaesthetist_record_data->muscle_relaxant_used : '' }}"
                                                                                                placeholder="" />
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-md-3">
                                                                                        <strong>Crystalloid Fluid
                                                                                            Used</strong>
                                                                                        <div class="input-group">
                                                                                            <input type="text"
                                                                                                class="form-control form-control-sm"
                                                                                                id="crystalloid_fluid_used"
                                                                                                name="crystalloid_fluid_used"
                                                                                                value="{{ isset($anaesthetist_record_data->crystalloid_fluid_used) ? $anaesthetist_record_data->crystalloid_fluid_used : '' }}"
                                                                                                placeholder="" />
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-md-3">
                                                                                        <strong>Colloid Fluid
                                                                                            Used</strong>
                                                                                        <div class="input-group">
                                                                                            <input type="text"
                                                                                                class="form-control form-control-sm"
                                                                                                id="colloid_fluid_used"
                                                                                                name="colloid_fluid_used"
                                                                                                value="{{ isset($anaesthetist_record_data->colloid_fluid_used) ? $anaesthetist_record_data->colloid_fluid_used : '' }}"
                                                                                                placeholder="" />
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-md-3">
                                                                                        <strong>Blood Product
                                                                                            Used</strong>
                                                                                        <div class="input-group">
                                                                                            <input type="text"
                                                                                                class="form-control form-control-sm"
                                                                                                id="blood_product_used"
                                                                                                name="blood_product_used"
                                                                                                value="{{ isset($anaesthetist_record_data->blood_product_used) ? $anaesthetist_record_data->blood_product_used : '' }}"
                                                                                                placeholder="" />
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-md-3">
                                                                                        <strong>Additional drug
                                                                                            used</strong>
                                                                                        <div class="input-group">
                                                                                            <input type="text"
                                                                                                class="form-control form-control-sm"
                                                                                                id="additional_drug_used"
                                                                                                name="additional_drug_used"
                                                                                                value="{{ isset($anaesthetist_record_data->additional_drug_used) ? $anaesthetist_record_data->additional_drug_used : '' }}"
                                                                                                placeholder="" />
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-3">
                                                                                        <strong>Reversal drug
                                                                                            used</strong>
                                                                                        <div class="input-group">
                                                                                            <input type="text"
                                                                                                class="form-control form-control-sm"
                                                                                                id="reversal_drugs"
                                                                                                name="reversal_drugs"
                                                                                                value="{{ isset($anaesthetist_record_data->reversal_drugs) ? $anaesthetist_record_data->reversal_drugs : '' }}"
                                                                                                placeholder="" />
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-3">
                                                                                        <strong>Urine</strong>
                                                                                        <div class="input-group">
                                                                                            <input type="text"
                                                                                                class="form-control form-control-sm"
                                                                                                id="urine_output"
                                                                                                name="urine_output"
                                                                                                value="{{ isset($anaesthetist_record_data->urine_output) ? $anaesthetist_record_data->urine_output : '' }}"
                                                                                                placeholder="" />
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-3">
                                                                                        <strong>Blood loss
                                                                                            (Approx)</strong>
                                                                                        <div class="input-group">
                                                                                            <input type="text"
                                                                                                class="form-control form-control-sm"
                                                                                                id="blood_loss"
                                                                                                name="blood_loss"
                                                                                                value="{{ isset($anaesthetist_record_data->blood_loss) ? $anaesthetist_record_data->blood_loss : '' }}"
                                                                                                placeholder="" />
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-md-3">
                                                                                        <strong>Pulse</strong>
                                                                                        <div class="input-group">
                                                                                            <input type="text"
                                                                                                class="form-control form-control-sm"
                                                                                                id="end_operation_pulse"
                                                                                                name="end_operation_pulse"
                                                                                                value=""
                                                                                                placeholder="" />
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-md-3">
                                                                                        <strong>BP</strong>
                                                                                        <div class="input-group">
                                                                                            <input type="text"
                                                                                                class="form-control form-control-sm"
                                                                                                id="end_operation_bp"
                                                                                                name="end_operation_bp"
                                                                                                value=""
                                                                                                placeholder="" />
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-md-3">
                                                                                        <strong>SpO2</strong>
                                                                                        <div class="input-group">
                                                                                            <input type="text"
                                                                                                class="form-control form-control-sm"
                                                                                                id="end_operation_spo2"
                                                                                                name="end_operation_spo2"
                                                                                                value=""
                                                                                                placeholder="" />
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-md-3">
                                                                                        <strong>Respiration</strong>
                                                                                        <div class="input-group">
                                                                                            <div class="form-check form-check-inline"
                                                                                                style="margin-right: 0px;">
                                                                                                <input
                                                                                                    class="form-check-input"
                                                                                                    type="radio"
                                                                                                    name="Respiration"
                                                                                                    id="Respiration1"
                                                                                                    value="Spontaneous" />
                                                                                                <label
                                                                                                    class="form-check-label"
                                                                                                    for="Respiration1">Spontaneous</label>
                                                                                            </div>
                                                                                            &nbsp;&nbsp;
                                                                                            <div class="form-check form-check-inline"
                                                                                                style="margin-right: 0px;">
                                                                                                <input
                                                                                                    class="form-check-input"
                                                                                                    type="radio"
                                                                                                    name="Respiration"
                                                                                                    id="Respiration2"
                                                                                                    value="Assisted" />
                                                                                                <label
                                                                                                    class="form-check-label"
                                                                                                    for="Respiration2">Assisted</label>
                                                                                            </div>
                                                                                            &nbsp;&nbsp;
                                                                                            <div class="form-check form-check-inline"
                                                                                                style="margin-right: 0px;">
                                                                                                <input
                                                                                                    class="form-check-input"
                                                                                                    type="radio"
                                                                                                    name="Respiration"
                                                                                                    id="Respiration2"
                                                                                                    value="Controlled" />
                                                                                                <label
                                                                                                    class="form-check-label"
                                                                                                    for="Respiration2">Controlled
                                                                                                </label>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>


                                                                                    <div class="col-md-3">
                                                                                        <strong>Consciousness</strong>
                                                                                        <div class="input-group">
                                                                                            <div class="form-check form-check-inline"
                                                                                                style="margin-right: 0px;">
                                                                                                <input
                                                                                                    class="form-check-input"
                                                                                                    type="radio"
                                                                                                    name="Consciousness"
                                                                                                    id="Consciousness1"
                                                                                                    value="Awake" />
                                                                                                <label
                                                                                                    class="form-check-label"
                                                                                                    for="Consciousness1">Awake</label>
                                                                                            </div>
                                                                                            &nbsp;&nbsp;
                                                                                            <div class="form-check form-check-inline"
                                                                                                style="margin-right: 0px;">
                                                                                                <input
                                                                                                    class="form-check-input"
                                                                                                    type="radio"
                                                                                                    name="Consciousness"
                                                                                                    id="Consciousness2"
                                                                                                    value="Rousable" />
                                                                                                <label
                                                                                                    class="form-check-label"
                                                                                                    for="Consciousness2">Rousable</label>
                                                                                            </div>
                                                                                            &nbsp;&nbsp;
                                                                                            <div class="form-check form-check-inline"
                                                                                                style="margin-right: 0px;">
                                                                                                <input
                                                                                                    class="form-check-input"
                                                                                                    type="radio"
                                                                                                    name="Consciousness"
                                                                                                    id="Consciousness2"
                                                                                                    value="Asleep" />
                                                                                                <label
                                                                                                    class="form-check-label"
                                                                                                    for="Consciousness2">Asleep</label>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-sm-12">
                                                                                        <div class="form-group">
                                                                                            <label for=""
                                                                                                class="col-form-label col-form-label-sm">
                                                                                                <div class="form-check form-check-inline"
                                                                                                    style="margin-right: 0px;">
                                                                                                    <input
                                                                                                        class="form-check-input"
                                                                                                        type="radio"
                                                                                                        name="inlineRadioCuNoCpv"
                                                                                                        id="inlineCuNoCpv1"
                                                                                                        value="Cuff"
                                                                                                        @if (isset($anaesthetist_record_data->cuff_non_cutpvc) && $anaesthetist_record_data->cuff_non_cutpvc == 'Cuff') checked @endif />
                                                                                                    <label
                                                                                                        class="form-check-label"
                                                                                                        for="inlineCuNoCpv1">Cuff</label>
                                                                                                </div>
                                                                                                &nbsp;/&nbsp;
                                                                                                <div class="form-check form-check-inline"
                                                                                                    style="margin-right: 0px;">
                                                                                                    <input
                                                                                                        class="form-check-input"
                                                                                                        type="radio"
                                                                                                        name="inlineRadioCuNoCpv"
                                                                                                        id="inlineCuNoCpv2"
                                                                                                        value="Non"
                                                                                                        @if (isset($anaesthetist_record_data->cuff_non_cutpvc) && $anaesthetist_record_data->cuff_non_cutpvc == 'Non') checked @endif />
                                                                                                    <label
                                                                                                        class="form-check-label"
                                                                                                        for="inlineCuNoCpv2">Non</label>
                                                                                                </div>
                                                                                                &nbsp;/&nbsp;
                                                                                                <div class="form-check form-check-inline"
                                                                                                    style="margin-right: 0px;">
                                                                                                    <input
                                                                                                        class="form-check-input"
                                                                                                        type="radio"
                                                                                                        name="inlineRadioCuNoCpv"
                                                                                                        id="inlineCuNoCpv3"
                                                                                                        value="-Cut PVC"
                                                                                                        @if (isset($anaesthetist_record_data->cuff_non_cutpvc) && $anaesthetist_record_data->cuff_non_cutpvc == '-Cut PVC') checked @endif />
                                                                                                    <label
                                                                                                        class="form-check-label"
                                                                                                        for="inlineCuNoCpv3">-Cut
                                                                                                        PVC</label>
                                                                                                </div>
                                                                                            </label>
                                                                                            <div class="input-group">
                                                                                                <div
                                                                                                    class="form-check form-check-inline">
                                                                                                    <input
                                                                                                        class="form-check-input"
                                                                                                        type="radio"
                                                                                                        name="inlineRadioOptions"
                                                                                                        id="inlineRadio1"
                                                                                                        value="Yes"
                                                                                                        @if (isset($anaesthetist_record_data->yes_no) && $anaesthetist_record_data->yes_no == 'Yes') checked @endif />
                                                                                                    <label
                                                                                                        class="form-check-label"
                                                                                                        for="inlineRadio1">Yes</label>
                                                                                                </div>
                                                                                                <div
                                                                                                    class="form-check form-check-inline">
                                                                                                    <input
                                                                                                        class="form-check-input"
                                                                                                        type="radio"
                                                                                                        name="inlineRadioOptions"
                                                                                                        id="inlineRadio2"
                                                                                                        value="No"
                                                                                                        @if (isset($anaesthetist_record_data->yes_no) && $anaesthetist_record_data->yes_no == 'No') checked @endif />
                                                                                                    <label
                                                                                                        class="form-check-label"
                                                                                                        for="inlineRadio2">No</label>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-sm-6">
                                                                                        <div class="form-group">
                                                                                            <label
                                                                                                for="inlineLASpray1"
                                                                                                class="col-form-label col-form-label-sm">
                                                                                                LASpray</label>
                                                                                            <div class="input-group">
                                                                                                <div
                                                                                                    class="form-check form-check-inline">
                                                                                                    <input
                                                                                                        class="form-check-input"
                                                                                                        type="radio"
                                                                                                        name="inlineLASpray"
                                                                                                        id="inlineLASpray1"
                                                                                                        value="Yes"
                                                                                                        @if (isset($anaesthetist_record_data->laspray_yes_no) && $anaesthetist_record_data->laspray_yes_no == 'Yes') checked @endif />
                                                                                                    <label
                                                                                                        class="form-check-label"
                                                                                                        for="inlineLASpray1">Yes</label>
                                                                                                </div>
                                                                                                <div
                                                                                                    class="form-check form-check-inline">
                                                                                                    <input
                                                                                                        class="form-check-input"
                                                                                                        type="radio"
                                                                                                        name="inlineLASpray"
                                                                                                        id="inlineLASpray2"
                                                                                                        value="No"
                                                                                                        @if (isset($anaesthetist_record_data->laspray_yes_no) && $anaesthetist_record_data->laspray_yes_no == 'No') checked @endif />
                                                                                                    <label
                                                                                                        class="form-check-label"
                                                                                                        for="inlineLASpray2">No</label>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </fieldset>
                                                                        </div>

                                                                        <div class="col-md-6">
                                                                            <fieldset>
                                                                                <legend>Respitation :</legend>
                                                                                <div class="form-group">
                                                                                    <label for="sCv1"
                                                                                        class="col-form-label col-form-label-sm">
                                                                                        <div class="form-check form-check-inline"
                                                                                            style="margin-right: 0px;">
                                                                                            <input
                                                                                                class="form-check-input"
                                                                                                type="radio"
                                                                                                name="inlineRadioSponCont"
                                                                                                id="inlineSponCont1"
                                                                                                value="Spontaneous"
                                                                                                @if (isset($anaesthetist_record_data->respitation_sp_co) &&
                                                                                                        $anaesthetist_record_data->respitation_sp_co == 'Spontaneous') checked @endif />
                                                                                            <label
                                                                                                class="form-check-label"
                                                                                                for="inlineSponCont1">Spontaneous</label>
                                                                                        </div>
                                                                                        &nbsp;/&nbsp;
                                                                                        <div class="form-check form-check-inline"
                                                                                            style="margin-right: 0px;">
                                                                                            <input
                                                                                                class="form-check-input"
                                                                                                type="radio"
                                                                                                name="inlineRadioSponCont"
                                                                                                id="inlineSponCont2"
                                                                                                value="Controlled"
                                                                                                @if (isset($anaesthetist_record_data->respitation_sp_co) && $anaesthetist_record_data->respitation_sp_co == 'Controlled') checked @endif />
                                                                                            <label
                                                                                                class="form-check-label"
                                                                                                for="inlineSponCont2">Controlled</label>
                                                                                        </div>
                                                                                    </label>
                                                                                    &nbsp; : &nbsp;

                                                                                    <label for=""
                                                                                        class="col-form-label col-form-label-sm">
                                                                                        <div class="form-check form-check-inline"
                                                                                            style="margin-right: 0px;">
                                                                                            <input
                                                                                                class="form-check-input"
                                                                                                type="radio"
                                                                                                name="inlineRadioManVen"
                                                                                                id="inlineManVen1"
                                                                                                value="Manual"
                                                                                                @if (isset($anaesthetist_record_data->respitation_manual_ventilator) &&
                                                                                                        $anaesthetist_record_data->respitation_manual_ventilator == 'Manual') checked @endif />
                                                                                            <label
                                                                                                class="form-check-label"
                                                                                                for="inlineManVen1">Manual</label>
                                                                                        </div>
                                                                                        &nbsp;/&nbsp;
                                                                                        <div class="form-check form-check-inline"
                                                                                            style="margin-right: 0px;">
                                                                                            <input
                                                                                                class="form-check-input"
                                                                                                type="radio"
                                                                                                name="inlineRadioManVen"
                                                                                                id="inlineManVen2"
                                                                                                value="Ventilator"
                                                                                                @if (isset($anaesthetist_record_data->respitation_manual_ventilator) &&
                                                                                                        $anaesthetist_record_data->respitation_manual_ventilator == 'Ventilator') checked @endif />
                                                                                            <label
                                                                                                class="form-check-label"
                                                                                                for="inlineManVen2">Ventilator</label>
                                                                                        </div>
                                                                                    </label>
                                                                                    <div class="input-group">
                                                                                        <input type="text"
                                                                                            class="form-control form-control-sm"
                                                                                            id="sCv1"
                                                                                            name="sCv1"
                                                                                            placeholder="V₁ -ml"
                                                                                            value="{{ isset($anaesthetist_record_data->respitation_sp_co_text) ? $anaesthetist_record_data->respitation_sp_co_text : '' }}" />
                                                                                        <input type="text"
                                                                                            class="form-control form-control-sm"
                                                                                            id="sCrespRate"
                                                                                            name="sCrespRate"
                                                                                            placeholder="Resp. Rate"
                                                                                            value="{{ isset($anaesthetist_record_data->respitation_manu_venti_text) ? $anaesthetist_record_data->respitation_manu_venti_text : '' }}" />
                                                                                    </div>
                                                                                </div>
                                                                            </fieldset>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row justify-content-end">
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label for="inJected"
                                                                                    class="col-form-label col-form-label-sm">Courtesy
                                                                                    By</label>
                                                                                <input type="text"
                                                                                    class="form-control form-control-sm"
                                                                                    id="courtesy_by"
                                                                                    name="courtesy_by"
                                                                                    placeholder=""
                                                                                    value="{{ isset($anaesthetist_record_data->injected_by_name) ? $anaesthetist_record_data->injected_by_name : '' }}" />
                                                                                <input type="hidden"
                                                                                    name="hdn_courtesyBy_doctor_id"
                                                                                    id="hdn_courtesyBy_doctor_id"
                                                                                    value="{{ isset($anaesthetist_record_data->injected_by_id) ? $anaesthetist_record_data->injected_by_id : '' }}">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <fieldset>
                                                                                <div class="form-row">

                                                                                    <div class="col-sm-12">
                                                                                        <div class="form-group">
                                                                                            <label for="signAnaName"
                                                                                                class="col-form-label col-form-label-sm">Name
                                                                                                of
                                                                                                Anaesthetist</label>
                                                                                            <input type="text"
                                                                                                class="form-control form-control-sm"
                                                                                                id="signAnaName"
                                                                                                name="signAnaName"
                                                                                                value="{{ isset($anaesthetist_record_data->sign_anaesthetist_name) ? $anaesthetist_record_data->sign_anaesthetist_name : '' }}" />
                                                                                            <input type="hidden"
                                                                                                name="hdn_anaesthetist_doctor_id"
                                                                                                id="hdn_anaesthetist_doctor_id"
                                                                                                value="{{ isset($anaesthetist_record_data->sign_anaesthetist_id) ? $anaesthetist_record_data->sign_anaesthetist_id : '' }}">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </fieldset>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- 3rd card body end -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @php
                                                        $redirect_url = route(
                                                            'ipd.anaesthetic-record-form',
                                                            $pat_info->admission_no_pk,
                                                        );
                                                    @endphp
                                                    <button type="submit"
                                                        class="btn btn-success btn-lg m-3 float-right"
                                                        onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $redirect_url }}')">Save</button>
                                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="text/javascript">
    $("body").addClass("sidebar-collapse");
    openDoctorAutocomplete('#drName', 'hdn_assessed_doctor_id', 'doctor_ind', '1,2');
    openDoctorAutocomplete('#ptSurgon', 'hdn_surgon_doctor_id', 'doctor_ind', '1,2');
    openDoctorAutocomplete('#signAnaName', 'hdn_anaesthetist_doctor_id', 'doctor_ind', '1,2');
    openDoctorAutocomplete('#courtesy_by', 'hdn_courtesyBy_doctor_id', 'doctor_ind', '1,2');

    $(function() {
        $('.date_picker').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            endDate: '+0d',
            'format': 'dd-mm-yyyy'
        });
    });
    var editor = CKEDITOR.replace('editor1', {
        tabSpaces: 4
    });

    editor.on('change', function(evt) {
        $('#ptOthers').val(evt.editor.getData())
    });
</script>
