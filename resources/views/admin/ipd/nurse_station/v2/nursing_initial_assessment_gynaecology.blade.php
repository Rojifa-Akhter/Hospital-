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
                            <h5 class="mt-2 mb-0">NURSING INITIAL ASSESSMENT & CARE PLAN (OBSTETRICS AND GYNAECOLOGY)
                            </h5>
                            <small>IPD / Nurse Station / NURSING INITIAL ASSESSMENT & CARE PLAN(OBSTETRICS AND
                                GYNAECOLOGY)</small>
                        </div>
                        <div class="col-md-2">
                            <a class="btn btn-md btn-warning" target="_blank"
                                href="{{ route('nursing-initial-assessment-gynaecology-pdf', [$patient_info->patient_no_pk, $patient_info->admission_no_pk]) }}">PDF
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
                                    <form action="{{ route('nursing-initial-assessment-gynaecology-store') }}"
                                        method="post" id="GYNAECOLOGY">
                                        @csrf
                                        <input type="hidden" name="patient_no_fk" id="patient_no_fk"
                                            value="{{ $patient_no_fk }}">
                                        <input type="hidden" name="admission_no_fk" id="admission_no_fk"
                                            value="{{ $admission_id }}">
                                        <input type="hidden" name="ipd_gynaecology_no_pk"
                                            value="{{ isset($assessment_info->ipd_gynaecology_no_pk) ? $assessment_info->ipd_gynaecology_no_pk : '' }}">


                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th class="text-left border-right-0" style="width:5%">Date:
                                                        </th>
                                                        <th style="width:5%"><input class="custom-form date_picker"
                                                                type="text" name="assessment_date"
                                                                id="assessment_date"
                                                                value="{{ @$assessment_info->assessment_date }}"></th>
                                                        <th class="text-left border-left-0" colspan="2"
                                                            style="width:15%">Initiated at:</th>
                                                        <th class="text-left border-left-0" style="width:10%"><input
                                                                type="text" class="custom-form" name="initiated_at"
                                                                id="initiated_at"
                                                                value="{{ @$assessment_info->initiated_at }}"></th>
                                                        <th class="text-left border-left-0" colspan="3"
                                                            style="width:27%">How admitted:</th>
                                                        <th class="text-left border-left-0" colspan="2"
                                                            style="width:20%">

                                                            <select class="custom-form" name="admitted_type"
                                                                id="admitted_type">
                                                                <option value="">Select one</option>
                                                                <option value="walking"
                                                                    {{ @$assessment_info->admitted_type == 'walking' ? 'selected' : '' }}>
                                                                    walking</option>
                                                                <option value="wheel chair"
                                                                    {{ @$assessment_info->admitted_type == 'wheel chair' ? 'selected' : '' }}>
                                                                    wheel chair</option>
                                                                <option value="stretcher"
                                                                    {{ @$assessment_info->admitted_type == 'stretcher' ? 'selected' : '' }}>
                                                                    stretcher</option>
                                                            </select>


                                                        </th>
                                                        <th class="text-left border-left-0" style="width:13%">Bystander
                                                            present:</th>
                                                        <th class="text-left border-left-0" style="width:5%">
                                                            <select class="custom-form" name="bystander_present"
                                                                id="bystander_present">
                                                                <option value="1"
                                                                    {{ @$assessment_info->bystander_present == 1 ? 'selected' : '' }}>
                                                                    No</option>
                                                                <option value="2"
                                                                    {{ @$assessment_info->bystander_present == 2 ? 'selected' : '' }}>
                                                                    Yes</option>
                                                            </select>
                                                        </th>
                                                    </tr>
                                                </thead>

                                                <tbody>

                                                    <tr>
                                                        <td colspan="4" class="text-left"><b>General condition:</b>
                                                        </td>
                                                        <td colspan="8">
                                                            <select name="general_condition" id="general_condition"
                                                                class="custom-form">
                                                                <option value="1"
                                                                    {{ @$assessment_info->general_condition == 1 ? 'selected' : '' }}>
                                                                    CONSCIOUS</option>
                                                                <option value="3"
                                                                    {{ @$assessment_info->general_condition == 2 ? 'selected' : '' }}>
                                                                    RESTLESSNESS</option>
                                                                <option value="5"
                                                                    {{ @$assessment_info->general_condition == 3 ? 'selected' : '' }}>
                                                                    DISORIENTED</option>
                                                                <option value="4"
                                                                    {{ @$assessment_info->general_condition == 4 ? 'selected' : '' }}>
                                                                    DROWSY</option>
                                                                <option value="2"
                                                                    {{ @$assessment_info->general_condition == 5 ? 'selected' : '' }}>
                                                                    UNCONSCIOUS</option>
                                                                <option value="5"
                                                                    {{ @$assessment_info->general_condition == 6 ? 'selected' : '' }}>
                                                                    OTHERS</option>
                                                            </select>

                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td colspan="3" class="text-left"><b>Respiratory
                                                                Support:</b></td>
                                                        <td colspan="2">
                                                            <select name="room_airtype" id="room_airtype"
                                                                class="custom-form">
                                                                <option value="1"
                                                                    {{ @$assessment_info->room_airtype == 1 ? 'selected' : '' }}>
                                                                    Room air</option>
                                                                <option value="2"
                                                                    {{ @$assessment_info->room_airtype == 2 ? 'selected' : '' }}>
                                                                    O₂</option>
                                                                <option value="3"
                                                                    {{ @$assessment_info->room_airtype == 3 ? 'selected' : '' }}>
                                                                    Tracheostomy</option>
                                                                <option value="4"
                                                                    {{ @$assessment_info->room_airtype == 4 ? 'selected' : '' }}>
                                                                    BiPAP</option>
                                                                <option value="5"
                                                                    {{ @$assessment_info->room_airtype == 5 ? 'selected' : '' }}>
                                                                    C-PAP</option>
                                                                <option value="6"
                                                                    {{ @$assessment_info->room_airtype == 6 ? 'selected' : '' }}>
                                                                    Vent</option>
                                                            </select>




                                                            <input type="hidden" class="custom-form" id="patient_id"
                                                                name="patient_id"
                                                                value="{{ @$patient_info->patient_no_pk }}">
                                                            <input type="hidden" class="custom-form"
                                                                id="admission_no_pk" name="admission_no_pk"
                                                                value="{{ @$patient_info->admission_no_pk }}">

                                                        </td>
                                                        <td colspan="2" class="text-left"><b>Mother tongue:</b>
                                                        </td>
                                                        <td>
                                                            <select name="mother_tongue" id="mother_tongue"
                                                                class="custom-form">
                                                                <option value="1"
                                                                    {{ @$assessment_info->mother_tongue == 1 ? 'selected' : '' }}>
                                                                    Bangla</option>
                                                                <option value="2"
                                                                    {{ @$assessment_info->mother_tongue == 2 ? 'selected' : '' }}>
                                                                    English</option>
                                                                <option value="3"
                                                                    {{ @$assessment_info->mother_tongue == 3 ? 'selected' : '' }}>
                                                                    Hindi</option>
                                                                <option value="4"
                                                                    {{ @$assessment_info->mother_tongue == 4 ? 'selected' : '' }}>
                                                                    Others</option>
                                                            </select>
                                                        </td>
                                                        <td colspan="2" class="text-left"><b>Can speak:</b></td>
                                                        <td colspan="2">
                                                            <select name="multi_language" id="multi_language"
                                                                class="custom-form">
                                                                <option value="1"
                                                                    {{ @$assessment_info->multi_language == 1 ? 'selected' : '' }}>
                                                                    Bangla</option>
                                                                <option value="2"
                                                                    {{ @$assessment_info->multi_language == 2 ? 'selected' : '' }}>
                                                                    English</option>
                                                                <option value="3"
                                                                    {{ @$assessment_info->multi_language == 3 ? 'selected' : '' }}>
                                                                    Hindi</option>
                                                                <option value="4"
                                                                    {{ @$assessment_info->multi_language == 4 ? 'selected' : '' }}>
                                                                    Others</option>
                                                            </select>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td class="text-left" colspan="3"><b>Presence of
                                                                lines/tubes/drains: </b></td>
                                                        <td>
                                                            <select class="custom-form" name="presence_type"
                                                                id="presence_type"
                                                                onclick="onChangePresence(this.value)">
                                                                <option value="1"
                                                                    {{ @$assessment_info->presence_type == 1 ? 'selected' : '' }}>
                                                                    No</option>
                                                                <option value="3"
                                                                    {{ @$assessment_info->presence_type == 3 ? 'selected' : '' }}>
                                                                    Yes</option>
                                                            </select>
                                                        </td>
                                                        <td class="text-left"><b>Specify</b></td>
                                                        <td>
                                                            <div id="presence_lines_specify" style="display: none">
                                                                <select class="custom-form" name="presence_specify"
                                                                    id="presence_specify">
                                                                    <option value="1"
                                                                        {{ @$assessment_info->presence_specify == 1 ? 'selected' : '' }}>
                                                                        CV Line</option>
                                                                    <option value="2"
                                                                        {{ @$assessment_info->presence_specify == 2 ? 'selected' : '' }}>
                                                                        IV Cannula</option>
                                                                    <option value="3"
                                                                        {{ @$assessment_info->presence_specify == 3 ? 'selected' : '' }}>
                                                                        Folleyes Catheta</option>
                                                                    <option value="4"
                                                                        {{ @$assessment_info->presence_specify == 4 ? 'selected' : '' }}>
                                                                        ICD</option>
                                                                    <option value="5"
                                                                        {{ @$assessment_info->presence_specify == 5 ? 'selected' : '' }}>
                                                                        Ryles Tube</option>
                                                                    <option value="6"
                                                                        {{ @$assessment_info->presence_specify == 6 ? 'selected' : '' }}>
                                                                        Wound Drain</option>
                                                                    <option value="7"
                                                                        {{ @$assessment_info->presence_specify == 7 ? 'selected' : '' }}>
                                                                        Tracheostomy Tube</option>
                                                                    <option value="8"
                                                                        {{ @$assessment_info->presence_specify == 8 ? 'selected' : '' }}>
                                                                        Peg Tube</option>
                                                                    <option value="9"
                                                                        {{ @$assessment_info->presence_specify == 9 ? 'selected' : '' }}>
                                                                        Pig Line</option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td class="text-left"><b>Height</b></td>
                                                        <td class="text-left"><input type="text"
                                                                class="custom-form" name="height" id="height"
                                                                value="{{ @$assessment_info->height }}"></td>
                                                        <td class="text-left">cm</td>
                                                        <td class="text-left"><b>Weight</b></td>
                                                        <td class="text-left"><input type="text"
                                                                class="custom-form" name="weight" id="weight"
                                                                value="{{ @$assessment_info->weight }}"></td>
                                                        <td class="text-left">kg</td>
                                                    </tr>


                                                    <tr>
                                                        <td class="text-left" colspan="4"><b>Any
                                                                cultural/religious/special needs:</b></td>

                                                        <td class="text-left" colspan="2">
                                                            <select class="custom-form" name="any_cultural"
                                                                id="any_cultural">
                                                                <option value="1"
                                                                    {{ @$assessment_info->any_cultural == 1 ? 'selected' : '' }}>
                                                                    No</option>
                                                                <option value="2"
                                                                    {{ @$assessment_info->any_cultural == 2 ? 'selected' : '' }}>
                                                                    Yes</option>
                                                            </select>
                                                        </td>

                                                        <td class="text-left"><b>Allergies:</b></td>
                                                        <td colspan="2">
                                                            <select class="custom-form" name="allergies"
                                                                id="allergies" onchange="changeAllergy(this.value)">
                                                                <option value="0"
                                                                    {{ @$assessment_info->allergies == 0 ? 'selected' : '' }}>
                                                                    No</option>
                                                                <option value="1"
                                                                    {{ @$assessment_info->allergies == 1 ? 'selected' : '' }}>
                                                                    Yes</option>
                                                                <option value="2"
                                                                    {{ @$assessment_info->allergies == 2 ? 'selected' : '' }}>
                                                                    Not Known</option>
                                                            </select>
                                                        </td>
                                                        <td colspan="3">
                                                            <div id="allergy_list"
                                                                style="display: {{ @$assessment_info->allergies == 1 ? 'block' : 'none' }}">
                                                                <select class="custom-form" name="allerg"
                                                                    id="allerg">
                                                                    <option value="1"
                                                                        {{ @$assessment_info->allerg == 1 ? 'selected' : '' }}>
                                                                        Drug</option>
                                                                    <option value="2"
                                                                        {{ @$assessment_info->allerg == 2 ? 'selected' : '' }}>
                                                                        Food</option>
                                                                    <option value="3"
                                                                        {{ @$assessment_info->allerg == 3 ? 'selected' : '' }}>
                                                                        Skin</option>
                                                                    <option value="4"
                                                                        {{ @$assessment_info->allerg == 4 ? 'selected' : '' }}>
                                                                        Dust</option>
                                                                    <option value="5"
                                                                        {{ @$assessment_info->allerg == 5 ? 'selected' : '' }}>
                                                                        Pollen</option>
                                                                    <option value="6"
                                                                        {{ @$assessment_info->allerg == 6 ? 'selected' : '' }}>
                                                                        Latex</option>
                                                                    <option value="7"
                                                                        {{ @$assessment_info->allerg == 7 ? 'selected' : '' }}>
                                                                        Insect </option>
                                                                    <option value="8"
                                                                        {{ @$assessment_info->allerg == 8 ? 'selected' : '' }}>
                                                                        Pet </option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left" colspan="1"><b>Temp:</b></td>
                                                        <td class="text-left" colspan="2">
                                                            <div style="display: flex;justify-content:space-between">
                                                                <div><input type="text" class="custom-form w-80"
                                                                        name="temp" id="temp"
                                                                        value="{{ @$assessment_info->temp }}"></div>
                                                                <div>&deg;F</div>
                                                            </div>
                                                        </td>
                                                        <td class="text-left" colspan="1"><b>Pulse:</b></td>
                                                        <td class="text-left" colspan="1">
                                                            <div style="display: flex;justify-content:space-between">
                                                                <div><input type="text" class="custom-form w-80"
                                                                        name="pulse" id="pulse"
                                                                        value="{{ @$assessment_info->pulse }}"></div>
                                                                <div>/main</div>
                                                            </div>
                                                        </td>
                                                        <td class="text-left" colspan="1"><b>Resp:</b></td>
                                                        <td class="text-left" colspan="1">
                                                            <div style="display: flex;justify-content:space-between">
                                                                <div><input type="text" class="custom-form w-80"
                                                                        name="resp" id="resp"
                                                                        value="{{ @$assessment_info->resp }}"></div>
                                                                <div>/min</div>
                                                            </div>
                                                        </td>
                                                        <td class="text-left" colspan="1"><b>BP:</b></td>
                                                        <td class="text-left" colspan="1">
                                                            <div style="display: flex;justify-content:space-between">
                                                                <div><input type="text" class="custom-form w-80"
                                                                        name="bp_high" id="bp_high"
                                                                        value="{{ @$assessment_info->bp_high }}">
                                                                </div>

                                                            </div>
                                                        </td>
                                                        <td class="text-left" colspan="1">
                                                            <div style="display: flex;justify-content:space-between">
                                                                <div><input type="text" class="custom-form w-80"
                                                                        name="bp_low" id="bp_low"
                                                                        value="{{ @$assessment_info->bp_low }}"></div>
                                                                <div>mmHg</div>
                                                            </div>
                                                        </td>
                                                        <td class="text-left" colspan="1"><b>SpO2:</b></td>
                                                        <td class="text-left" colspan="1">
                                                            <div style="display: flex; justify-content:space-between">
                                                                <div><input type="text" class="custom-form w-80"
                                                                        name="spo2" id="spo2"
                                                                        value="{{ @$assessment_info->spo2 }}"></div>
                                                                <div>%</div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left" colspan="2"><b>Pain:</b></td>
                                                        <td class="text-left" colspan="10">
                                                            <select name="pain_mode" id="pain_mode"
                                                                class="custom-form"
                                                                onchange="changePainMode(this.value)">
                                                                <option value="1"
                                                                    {{ @$assessment_info->invasive_type == 1 ? 'selected' : '' }}>
                                                                    No</option>
                                                                <option value="2"
                                                                    {{ @$assessment_info->invasive_type == 2 ? 'selected' : '' }}>
                                                                    Yes</option>
                                                            </select>
                                                        </td>
                                                    </tr>

                                                    <tr class="pain_mode_list">
                                                        <td class="text-left" colspan="2"><b>Precipitating
                                                                Factor</b></td>
                                                        <td class="text-left" colspan="2"><b>Type</b></td>
                                                        <td class="text-left" colspan="2"><b>Location</b></td>
                                                        <td class="text-left" colspan="2"><b>Pain Score</b></td>
                                                        <td class="text-left" colspan="2"><b>Frequency</b></td>
                                                        <td class="text-left" colspan="2"><b>Duration</b></td>
                                                    </tr>


                                                    <tr class="pain_mode_list">
                                                        <td class="text-left" colspan="2"><input type="text"
                                                                class="custom-form" name="pain_precipitating"
                                                                id="pain_precipitating"
                                                                value="{{ @$assessment_info->pain_precipitating }}">
                                                        </td>
                                                        <td class="text-left" colspan="2"><input type="text"
                                                                class="custom-form" name="pain_type" id="pain_type"
                                                                value="{{ @$assessment_info->pain_type }}"></td>
                                                        <td class="text-left" colspan="2"><input type="text"
                                                                class="custom-form" name="pain_location"
                                                                id="pain_location"
                                                                value="{{ @$assessment_info->pain_location }}"></td>
                                                        <td class="text-left" colspan="2"><input type="text"
                                                                class="custom-form" name="pain_score" id="pain_score"
                                                                value="{{ @$assessment_info->pain_score }}"></td>
                                                        <td class="text-left" colspan="2">
                                                            <select name="pain_fequesncy" id="pain_fequesncy"
                                                                class="custom-form">
                                                                <option value="1"
                                                                    {{ @$assessment_info->pain_fequesncy == 1 ? 'selected' : '' }}>
                                                                    Constant</option>
                                                                <option value="2"
                                                                    {{ @$assessment_info->pain_fequesncy == 2 ? 'selected' : '' }}>
                                                                    Intermittent</option>
                                                            </select>
                                                        </td>
                                                        <td class="text-left" colspan="2"><input type="text"
                                                                class="custom-form" name="pain_duration"
                                                                id="pain_duration"
                                                                value="{{ @$assessment_info->pain_duration }}"></td>
                                                    </tr>

                                                    <tr>
                                                        <td colspan="12" style="text-align: left"><b>OBSTETRICS
                                                                ASSESSMENT</b></td>
                                                    </tr>

                                                    <tr class="pain_mode_list">
                                                        <td colspan="2" class="text-left">Age of menarche</td>
                                                        <td colspan="2" class="text-left"><input type="text"
                                                                name="age_menarche" class="custom-form"
                                                                value="{{ @$assessment_info->age_menarche }}"></td>
                                                        <td class="text-left">Menstrual cycle</td>
                                                        <td colspan="2" class="text-left">
                                                            <select name="menstrual_cycle" class="custom-form">
                                                                <option value=""></option>
                                                                <option value="1"
                                                                    {{ @$assessment_info->menstrual_cycle == 1 ? 'selected' : '' }}>
                                                                    Regular</option>
                                                                <option value="2"
                                                                    {{ @$assessment_info->menstrual_cycle == 2 ? 'selected' : '' }}>
                                                                    Irregular</option>
                                                            </select>
                                                        </td>
                                                        <td colspan="3" class="text-left">Age of Menopause</td>
                                                        <td colspan="2" class="text-left"><input type="text"
                                                                name="age_menopause"
                                                                value="{{ @$assessment_info->age_menopause }}"
                                                                class="custom-form"></td>

                                                    </tr>
                                                    <tr class="pain_mode_list">
                                                        <td class="text-left" colspan="2">Obstetric score</td>
                                                        <td class="text-left">
                                                            <select name="obstetric_score" class="custom-form">
                                                                <option value=""></option>
                                                                <option value="1"
                                                                    {{ @$assessment_info->obstetric_score == 1 ? 'selected' : '' }}>
                                                                    G</option>
                                                                <option value="2"
                                                                    {{ @$assessment_info->obstetric_score == 2 ? 'selected' : '' }}>
                                                                    P</option>
                                                                <option value="3"
                                                                    {{ @$assessment_info->obstetric_score == 3 ? 'selected' : '' }}>
                                                                    A</option>
                                                                <option value="4"
                                                                    {{ @$assessment_info->obstetric_score == 4 ? 'selected' : '' }}>
                                                                    L</option>
                                                            </select>
                                                        </td>
                                                        <td class="text-left">Gestational age:</td>
                                                        <td colspan="2" class="text-left"><input type="text"
                                                                name="age_gestation" class="custom-form"
                                                                value="{{ @$assessment_info->age_gestation }}"></td>
                                                        <td class="text-left">LMP:</td>
                                                        <td colspan="2" class="text-left"><input type="text"
                                                                name="lmp" value="{{ @$assessment_info->lmp }}"
                                                                class="custom-form"></td>
                                                        <td class="text-left">EDD:</td>
                                                        <td colspan="3" class="text-left"><input type="text"
                                                                name="edd" value="{{ @$assessment_info->edd }}"
                                                                class="custom-form"></td>

                                                    </tr>
                                                    <tr class="pain_mode_list">
                                                        <td class="text-left">FHS:</td>
                                                        <td class="text-left"><input type="text" name="fhs"
                                                                class="custom-form"
                                                                value="{{ @$assessment_info->fhs }}"></td>
                                                        <td class="text-left">FM:</td>
                                                        <td class="text-left"><input type="text" name="fm"
                                                                value="{{ @$assessment_info->fm }}"
                                                                class="custom-form"></td>
                                                        <td class="text-left">LCB:</td>
                                                        <td class="text-left"><input type="text" name="lcb"
                                                                value="{{ @$assessment_info->lcb }}"
                                                                class="custom-form"></td>
                                                        <td class="text-left">Previous LSCS</td>
                                                        <td class="text-left">
                                                            <select name="lscs" class="custom-form">
                                                                <option value=""></option>
                                                                <option value="Yes"
                                                                    {{ @$assessment_info->lscs == 'Yes' ? 'selected' : '' }}>
                                                                    Yes</option>
                                                                <option value="No"
                                                                    {{ @$assessment_info->lscs == 'No' ? 'selected' : '' }}>
                                                                    No</option>

                                                            </select>
                                                        </td>
                                                        <td class="text-left">Pedal oedema</td>
                                                        <td class="text-left">
                                                            <select name="oedema" class="custom-form">
                                                                <option value=""></option>
                                                                <option value="Yes"
                                                                    {{ @$assessment_info->oedema == 'Yes' ? 'selected' : '' }}>
                                                                    Yes</option>
                                                                <option value="No"
                                                                    {{ @$assessment_info->oedema == 'No' ? 'selected' : '' }}>
                                                                    No</option>

                                                            </select>
                                                        </td>
                                                        <td class="text-left">Leaking</td>
                                                        <td class="text-left">
                                                            <select name="leaking" class="custom-form">
                                                                <option value=""></option>
                                                                <option value="Yes"
                                                                    {{ @$assessment_info->leaking == 'Yes' ? 'selected' : '' }}>
                                                                    Yes</option>
                                                                <option value="No"
                                                                    {{ @$assessment_info->leaking == 'No' ? 'selected' : '' }}>
                                                                    No</option>

                                                            </select>
                                                        </td>


                                                    </tr>
                                                    <tr class="pain_mode_list">

                                                        <td class="text-left" colspan="2">Breast</td>
                                                        <td class="text-left" colspan="2">
                                                            <select name="breast" class="custom-form">
                                                                <option value=""></option>
                                                                <option value="1"
                                                                    {{ @$assessment_info->breast == 1 ? 'selected' : '' }}>
                                                                    Soft</option>
                                                                <option value="2"
                                                                    {{ @$assessment_info->breast == 2 ? 'selected' : '' }}>
                                                                    Edema</option>
                                                                <option value="3"
                                                                    {{ @$assessment_info->breast == 3 ? 'selected' : '' }}>
                                                                    Tender</option>
                                                                <option value="4"
                                                                    {{ @$assessment_info->breast == 4 ? 'selected' : '' }}>
                                                                    Discharge</option>

                                                            </select>
                                                        </td>
                                                        <td class="text-left" colspan="2">Nipples</td>
                                                        <td class="text-left" colspan="2">
                                                            <select name="nipples" class="custom-form">
                                                                <option value=""></option>
                                                                <option value="1"
                                                                    {{ @$assessment_info->nipples == 1 ? 'selected' : '' }}>
                                                                    Normal</option>
                                                                <option value="2"
                                                                    {{ @$assessment_info->nipples == 2 ? 'selected' : '' }}>
                                                                    Fiat</option>
                                                                <option value="3"
                                                                    {{ @$assessment_info->nipples == 3 ? 'selected' : '' }}>
                                                                    Inverted</option>
                                                                <option value="4"
                                                                    {{ @$assessment_info->nipples == 4 ? 'selected' : '' }}>
                                                                    Cracked</option>

                                                            </select>
                                                        </td>
                                                        <td class="text-left" colspan="2">Vaginal discharge</td>
                                                        <td class="text-left" colspan="2">
                                                            <select name="vaginal" class="custom-form">
                                                                <option value=""></option>
                                                                <option value="1"
                                                                    {{ @$assessment_info->vaginal == 1 ? 'selected' : '' }}>
                                                                    Present</option>
                                                                <option value="2"
                                                                    {{ @$assessment_info->vaginal == 2 ? 'selected' : '' }}>
                                                                    Absent</option>

                                                            </select>
                                                        </td>


                                                    </tr>
                                                    <tr class="pain_mode_list">
                                                        <td colspan="6" class="text-left">Any complications in
                                                            previous pregnancy</td>
                                                        <td colspan="6" class="text-left"><input type="text"
                                                                name="acipp"
                                                                value="{{ @$assessment_info->acipp }}"
                                                                class="custom-form"></td>


                                                    </tr>


                                                    <tr>
                                                        <td colspan="5" class="text-left custom-form">
                                                            <b>ORIENTATION ON FOLLOWING (Patient/Attendant)</b>
                                                        </td>
                                                        <td colspan="7">
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="side_rails" value="1" name="side_rails"
                                                                    {{ @$assessment_info->side_rails == 1 ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="side_rails"><b>Side rails</b></label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="patients_rights" value="1"
                                                                    name="patients_rights"
                                                                    {{ @$assessment_info->patients_rights == 1 ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="patients_rights"><b>Patient rights of privacy
                                                                        and confidentiality</b></label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="visitor_policy" value="1"
                                                                    name="visitor_policy"
                                                                    {{ @$assessment_info->visitor_policy == 1 ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="visitor_policy"><b>Visitor Policy:</b></label>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td class="text-left" colspan="3"><b>Personal AIDS</b></td>
                                                        <td class="text-left" colspan="2"><b>Dentures</b></td>
                                                        <td>
                                                            <select name="dentures" id="dentures"
                                                                class="custom-form">
                                                                <option value="1"
                                                                    {{ @$assessment_info->dentures == 1 ? 'selected' : '' }}>
                                                                    No</option>
                                                                <option value="2"
                                                                    {{ @$assessment_info->dentures == 2 ? 'selected' : '' }}>
                                                                    Yes</option>
                                                            </select>
                                                        </td>
                                                        <td class="text-left" colspan="2"><b>Eyewear</b></td>
                                                        <td>
                                                            <select name="eyewear" id="eyewear"
                                                                class="custom-form">
                                                                <option value="1"
                                                                    {{ @$assessment_info->eyewear == 1 ? 'selected' : '' }}>
                                                                    No</option>
                                                                <option value="2"
                                                                    {{ @$assessment_info->eyewear == 2 ? 'selected' : '' }}>
                                                                    Yes</option>
                                                            </select>
                                                        </td>
                                                        <td class="text-left"><b>Hearing</b></td>
                                                        <td colspan="2">
                                                            <select name="hearing" id="hearing"
                                                                class="custom-form">
                                                                <option value="1"
                                                                    {{ @$assessment_info->hearing == 1 ? 'selected' : '' }}>
                                                                    No</option>
                                                                <option value="2"
                                                                    {{ @$assessment_info->hearing == 2 ? 'selected' : '' }}>
                                                                    Yes</option>
                                                            </select>
                                                        </td>
                                                    </tr>


                                                </tbody>
                                            </table> <br>
                                            <table class="table table-bordered">
                                                <tr>
                                                    <td class="text-left" colspan="12"><b>VULNERABILITY
                                                            ASSESSMENT</b></td>

                                                </tr>

                                                <tr>
                                                    <td class="text-left" colspan="8"><b>Parameters</b></td>
                                                    <td class="text-left" colspan="4"><b>Yes/No</b></td>

                                                </tr>


                                                <tr>
                                                    <td class="text-left" colspan="8">
                                                        {{ 'Children <16 yrs' }}</td>
                                                    <td class="text-left" colspan="4">
                                                        <select name="children16" id="children16"
                                                            class="custom-form">
                                                            <option value="1"
                                                                {{ @$assessment_info->children16 == 1 ? 'selected' : '' }}>
                                                                No</option>
                                                            <option value="2"
                                                                {{ @$assessment_info->children16 == 2 ? 'selected' : '' }}>
                                                                Yes</option>
                                                        </select>
                                                    </td>

                                                </tr>

                                                <tr>
                                                    <td class="text-left" colspan="8">Adolescent</td>
                                                    <td class="text-left" colspan="4">
                                                        <select name="adolescent" id="adolescent"
                                                            class="custom-form">
                                                            <option value="1"
                                                                {{ @$assessment_info->adolescent == 1 ? 'selected' : '' }}>
                                                                No</option>
                                                            <option value="2"
                                                                {{ @$assessment_info->adolescent == 2 ? 'selected' : '' }}>
                                                                Yes</option>
                                                        </select>
                                                    </td>
                                                </tr>




                                                <tr>
                                                    <td class="text-left" colspan="8">
                                                        {{ 'Elderly>65 years' }}</td>
                                                    <td class="text-left" colspan="4">
                                                        <select name="elder65" id="elder65" class="custom-form">
                                                            <option value="1"
                                                                {{ @$assessment_info->elder65 == 1 ? 'selected' : '' }}>
                                                                No</option>
                                                            <option value="2"
                                                                {{ @$assessment_info->elder65 == 2 ? 'selected' : '' }}>
                                                                Yes</option>
                                                        </select>
                                                    </td>

                                                </tr>

                                                <tr>
                                                    <td class="text-left" colspan="8">Frail elderly</td>
                                                    <td class="text-left" colspan="4">
                                                        <select name="frail_elderly" id="frail_elderly"
                                                            class="custom-form">
                                                            <option value="1"
                                                                {{ @$assessment_info->frail_elderly == 1 ? 'selected' : '' }}>
                                                                No</option>
                                                            <option value="2"
                                                                {{ @$assessment_info->frail_elderly == 2 ? 'selected' : '' }}>
                                                                Yes</option>
                                                        </select>
                                                    </td>
                                                </tr>



                                                <tr>
                                                    <td class="text-left" colspan="8">
                                                        {{ 'Terminally ill/dying' }}</td>
                                                    <td class="text-left" colspan="4">
                                                        <select name="terminally_ill" id="terminally_ill"
                                                            class="custom-form">
                                                            <option value="1"
                                                                {{ @$assessment_info->terminally_ill == 1 ? 'selected' : '' }}>
                                                                No</option>
                                                            <option value="2"
                                                                {{ @$assessment_info->terminally_ill == 2 ? 'selected' : '' }}>
                                                                Yes</option>
                                                        </select>
                                                    </td>

                                                </tr>

                                                <tr>
                                                    <td class="text-left" colspan="8">Not able to do ADL</td>
                                                    <td class="text-left" colspan="4">
                                                        <select name="adl" id="ADL" class="custom-form">
                                                            <option value="1"
                                                                {{ @$assessment_info->adl == 1 ? 'selected' : '' }}>
                                                                No</option>
                                                            <option value="2"
                                                                {{ @$assessment_info->adl == 2 ? 'selected' : '' }}>
                                                                Yes</option>
                                                        </select>
                                                    </td>
                                                </tr>


                                                <tr>
                                                    <td class="text-left" colspan="8">Intense or chronic pain
                                                    </td>
                                                    <td class="text-left" colspan="4">
                                                        <select name="intense_chronic_pain" id="intense_chronic_pain"
                                                            class="custom-form">
                                                            <option value="1"
                                                                {{ @$assessment_info->intense_chronic_pain == 1 ? 'selected' : '' }}>
                                                                No</option>
                                                            <option value="2"
                                                                {{ @$assessment_info->intense_chronic_pain == 2 ? 'selected' : '' }}>
                                                                Yes</option>
                                                        </select>
                                                    </td>

                                                </tr>



                                                <tr>
                                                    <td class="text-left" colspan="8">Women in labour</td>
                                                    <td class="text-left" colspan="4">
                                                        <select name="women_labour" id="women_labour"
                                                            class="custom-form">
                                                            <option value="1"
                                                                {{ @$assessment_info->women_labour == 1 ? 'selected' : '' }}>
                                                                No</option>
                                                            <option value="2"
                                                                {{ @$assessment_info->women_labour == 2 ? 'selected' : '' }}>
                                                                Yes</option>
                                                        </select>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="text-left" colspan="8">Women experiencing
                                                        terminations in pregnancy</td>
                                                    <td class="text-left" colspan="4">
                                                        <select name="women_exp_ter_pregnancy"
                                                            id="women_exp_ter_pregnancy" class="custom-form">
                                                            <option value="1"
                                                                {{ @$assessment_info->women_exp_ter_pregnancy == 1 ? 'selected' : '' }}>
                                                                No</option>
                                                            <option value="2"
                                                                {{ @$assessment_info->women_exp_ter_pregnancy == 2 ? 'selected' : '' }}>
                                                                Yes</option>
                                                        </select>
                                                    </td>

                                                </tr>

                                                <tr>
                                                    <td class="text-left" colspan="8">Emotional or psychiatric
                                                        disorders</td>
                                                    <td class="text-left" colspan="4">
                                                        <select name="emotional_disorder" id="emotional_disorder"
                                                            class="custom-form">
                                                            <option value="1"
                                                                {{ @$assessment_info->emotional_disorder == 1 ? 'selected' : '' }}>
                                                                No</option>
                                                            <option value="2"
                                                                {{ @$assessment_info->emotional_disorder == 2 ? 'selected' : '' }}>
                                                                Yes</option>
                                                        </select>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td class="text-left" colspan="8">Suspected of drug and/or
                                                        alcohol dependency</td>
                                                    <td class="text-left" colspan="4">
                                                        <select name="drug_dependency" id="drug_dependency"
                                                            class="custom-form">
                                                            <option value="1"
                                                                {{ @$assessment_info->drug_dependency == 1 ? 'selected' : '' }}>
                                                                No</option>
                                                            <option value="2"
                                                                {{ @$assessment_info->drug_dependency == 2 ? 'selected' : '' }}>
                                                                Yes</option>
                                                        </select>
                                                    </td>

                                                </tr>

                                                <tr>
                                                    <td class="text-left" colspan="8">Victims of abuse or
                                                        neglect</td>
                                                    <td class="text-left" colspan="4">
                                                        <select name="victim_neglect" id="victim_neglect"
                                                            class="custom-form">
                                                            <option value="1"
                                                                {{ @$assessment_info->victim_neglect == 1 ? 'selected' : '' }}>
                                                                No</option>
                                                            <option value="2"
                                                                {{ @$assessment_info->victim_neglect == 2 ? 'selected' : '' }}>
                                                                Yes</option>
                                                        </select>
                                                    </td>

                                                </tr>

                                                <tr>
                                                    <td class="text-left" colspan="8">Infectious or
                                                        communicable diseases</td>
                                                    <td class="text-left" colspan="4">
                                                        <select name="infectious_diseases" id="infectious_diseases"
                                                            class="custom-form">
                                                            <option value="1"
                                                                {{ @$assessment_info->infectious_diseases == 1 ? 'selected' : '' }}>
                                                                No</option>
                                                            <option value="2"
                                                                {{ @$assessment_info->infectious_diseases == 2 ? 'selected' : '' }}>
                                                                Yes</option>
                                                        </select>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td class="text-left" colspan="8">Receiving
                                                        chemotherapy or radiation therapy</td>
                                                    <td class="text-left" colspan="4">
                                                        <select name="receiving_therapy" id="receiving_therapy"
                                                            class="custom-form">
                                                            <option value="1"
                                                                {{ @$assessment_info->receiving_therapy == 1 ? 'selected' : '' }}>
                                                                No</option>
                                                            <option value="2"
                                                                {{ @$assessment_info->receiving_therapy == 2 ? 'selected' : '' }}>
                                                                Yes</option>
                                                        </select>
                                                    </td>

                                                </tr>




                                                <tr>
                                                    <td class="text-left" colspan="8">Immune systems are
                                                        compromised</td>
                                                    <td class="text-left colspan="4"">
                                                        <select name="immune_compromised" id="immune_compromised"
                                                            class="custom-form">
                                                            <option value="1"
                                                                {{ @$assessment_info->immune_compromised == 1 ? 'selected' : '' }}>
                                                                No</option>
                                                            <option value="2"
                                                                {{ @$assessment_info->immune_compromised == 2 ? 'selected' : '' }}>
                                                                Yes</option>
                                                        </select>
                                                    </td>

                                                </tr>

                                                <tr>
                                                    <td class="text-center" colspan="12"><b> Needs & Action</b></td>

                                                </tr>

                                                <tr>
                                                    <td class="text-left" colspan="12">

                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox"
                                                                id="provide_assistance" value="1"
                                                                name="provide_assistance"
                                                                {{ @$assessment_info->provide_assistance == 1 ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="provide_assistance">Provide Assistance in
                                                                eating/ toileting/personal hygeiene/
                                                                mobilisation</label>
                                                        </div>

                                                    </td>

                                                </tr>

                                                <tr>
                                                    <td class="text-left" colspan="12">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox"
                                                                id="pain_management" value="1"
                                                                name="pain_management"
                                                                {{ @$assessment_info->pain_management == 1 ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="pain_management">Pain
                                                                Mangement</label>
                                                        </div>
                                                    </td>




                                                </tr>

                                                <tr>
                                                    <td class="text-left" colspan="12">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox"
                                                                id="safety_precaution" value="1"
                                                                name="safety_precaution"
                                                                {{ @$assessment_info->safety_precaution == 1 ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="safety_precaution">Safety precaution</label>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="text-left" colspan="12">

                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox"
                                                                id="initiate_end_care" value="1"
                                                                name="initiate_end_care"
                                                                {{ @$assessment_info->initiate_end_care == 1 ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="initiate_end_care">Initiate end of life
                                                                care</label>
                                                        </div>

                                                    </td>

                                                </tr>

                                            </table>
                                        </div>




                                        <h5><b>HISTORY COLLECTION</b></h5>
                                        <div class="table-responsive">
                                            <table class="table table-bordered">

                                                <tbody>
                                                    <tr>
                                                        <td style="width:25%" class="text-left">Present complaints:
                                                        </td>
                                                        <td style="width:75%"><input type="text"
                                                                class="custom-form" name="present_complaint"
                                                                id="present_complaint"
                                                                value="{{ @$assessment_info->present_complaint }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width:25%" class="text-left">Past medical history:
                                                        </td>
                                                        <td style="width:75%"><input type="text"
                                                                class="custom-form" name="past_med_history"
                                                                id="past_med_history"
                                                                value="{{ @$assessment_info->past_med_history }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width:25%" class="text-left">Past surgical history:
                                                        </td>
                                                        <td style="width:75%"><input type="text"
                                                                class="custom-form" name="past_surgical_history"
                                                                id="past_surgical_history"
                                                                value="{{ @$assessment_info->past_surgical_history }}">
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>



                                        <h5><b>SKIN INTEGRITY</b></h5>
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <td class="text-left" style="15%">Skin intact:</td>
                                                        <td style="5%">
                                                            <select name="skin_intact" id="skin_intact"
                                                                class="custom-form">
                                                                <option value="1"
                                                                    {{ @$assessment_info->skin_intact == 1 ? 'selected' : '' }}>
                                                                    No</option>
                                                                <option value="2"
                                                                    {{ @$assessment_info->skin_intact == 2 ? 'selected' : '' }}>
                                                                    Yes</option>
                                                            </select>
                                                        </td>
                                                        <td style="25%">
                                                            Details with PUSH Score
                                                        </td>
                                                        <td style="width:55%"><input type="text"
                                                                class="custom-form" name="skin_intact_details"
                                                                id="skin_intact_details"
                                                                value="{{ @$assessment_info->skin_intact_details }}">
                                                        </td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="text-left" style="15%">History of previous
                                                            pressure injury:</td>
                                                        <td style="5%">
                                                            <select name="history_injury" id="history_injury"
                                                                class="custom-form">
                                                                <option value="1"
                                                                    {{ @$assessment_info->history_injury == 1 ? 'selected' : '' }}>
                                                                    No</option>
                                                                <option value="2"
                                                                    {{ @$assessment_info->history_injury == 2 ? 'selected' : '' }}>
                                                                    Yes</option>
                                                            </select>
                                                        </td>
                                                        <td style="25%">
                                                            Pressure injury currently
                                                        </td>
                                                        <td style="width:55%">
                                                            <select name="pressure_injury" id="pressure_injury"
                                                                class="custom-form">
                                                                <option value="1"
                                                                    {{ @$assessment_info->pressure_injury == 1 ? 'selected' : '' }}>
                                                                    No</option>
                                                                <option value="2"
                                                                    {{ @$assessment_info->pressure_injury == 2 ? 'selected' : '' }}>
                                                                    Yes</option>
                                                            </select>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td class="text-left" style="15%">Details:</td>
                                                        <td colspan="3">
                                                            <textarea name="pressure_injury_dtl" id="pressure_injury_dtl" rows="4" placeholder="write here ..."
                                                                class="custom-form">{{ @$assessment_info->pressure_injury_dtl }}</textarea>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left" style="15%">Signature of
                                                            relatives/bystander:</td>
                                                        <td colspan="3">
                                                            <input name="bystander_signature_name"
                                                                id="bystander_signature_name" type="text"
                                                                placeholder="write here ..." class="custom-form"
                                                                value="{{ @$assessment_info->bystander_signature_name }}">
                                                            <input name="bystander_signature_id"
                                                                id="bystander_signature_id" type="hidden"
                                                                placeholder="write here ..." class="custom-form"
                                                                value="{{ @$assessment_info->bystander_signature_id }}">
                                                        </td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 15%;border:none"></th>
                                                        <th style="width: 15%;border:none"></th>
                                                        <th style="width: 15%;border:none"></th>
                                                        <th style="width: 15%;border:none"></th>
                                                        <th style="width: 15%;border:none"></th>
                                                        <th style="width: 25%;border:none"></th>

                                                    </tr>
                                                    <tr>
                                                        <th colspan="5">MODIFIED BRADEN PRESSURE ULCER RISK
                                                            ASSESSMENT SCALE</th>
                                                        <th>Time</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    <tr>
                                                        <td class="text-left"><b>Sensory perception</b></td>
                                                        <td colspan="4">
                                                            <select name="sensory" id="sensory" class="custom-form"
                                                                value="0"
                                                                onchange="changeBraden(this.value, 'sensory_value')">
                                                                <option value="">Select one</option>
                                                                <option value="1"
                                                                    {{ @$assessment_info->sensory_perception_value == 1 ? 'selected' : '' }}>
                                                                    Completely limited</option>
                                                                <option value="2"
                                                                    {{ @$assessment_info->sensory_perception_value == 2 ? 'selected' : '' }}>
                                                                    Very limited</option>
                                                                <option value="3"
                                                                    {{ @$assessment_info->sensory_perception_value == 3 ? 'selected' : '' }}>
                                                                    Slightly limited</option>
                                                                <option value="4"
                                                                    {{ @$assessment_info->sensory_perception_value == 4 ? 'selected' : '' }}>
                                                                    No impairment</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input id="sensory_value" type="number"
                                                                class="custom-form"
                                                                value="{{ @$assessment_info->sensory_perception_value }}"
                                                                name="braden[]" readonly />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left"><b>Moisture</b></td>
                                                        <td colspan="4">
                                                            <select name="moisture" id="moisture"
                                                                class="custom-form" value="0"
                                                                onchange="changeBraden(this.value, 'moisture_value')">
                                                                <option value="">Select one</option>
                                                                <option value="1"
                                                                    {{ @$assessment_info->moisture_value == 1 ? 'selected' : '' }}>
                                                                    Constantly moist</option>
                                                                <option value="2"
                                                                    {{ @$assessment_info->moisture_value == 2 ? 'selected' : '' }}>
                                                                    Often moist</option>
                                                                <option value="3"
                                                                    {{ @$assessment_info->moisture_value == 3 ? 'selected' : '' }}>
                                                                    Occasionally moist</option>
                                                                <option value="4"
                                                                    {{ @$assessment_info->moisture_value == 4 ? 'selected' : '' }}>
                                                                    Rarely moist</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input id="moisture_value" type="number"
                                                                class="custom-form"
                                                                value="{{ @$assessment_info->moisture_value }}"
                                                                name="braden[]" readonly />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left"><b>Activity</b></td>
                                                        <td colspan="4">
                                                            <select name="activity" id="activity"
                                                                class="custom-form" value="0"
                                                                onchange="changeBraden(this.value, 'activity_value')">
                                                                <option value="">Select one</option>
                                                                <option value="1"
                                                                    {{ @$assessment_info->activity_value == 1 ? 'selected' : '' }}>
                                                                    Bed fast</option>
                                                                <option value="2"
                                                                    {{ @$assessment_info->activity_value == 2 ? 'selected' : '' }}>
                                                                    Chair fast</option>
                                                                <option value="3"
                                                                    {{ @$assessment_info->activity_value == 3 ? 'selected' : '' }}>
                                                                    Walks Occasionally</option>
                                                                <option value="4"
                                                                    {{ @$assessment_info->activity_value == 4 ? 'selected' : '' }}>
                                                                    Walks frequently</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input id="activity_value" type="number"
                                                                class="custom-form" name="braden[]"
                                                                value="{{ @$assessment_info->activity_value }}"
                                                                readonly />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left"><b>Mobility</b></td>
                                                        <td colspan="4">
                                                            <select name="mobility" id="mobility"
                                                                class="custom-form" value="0" name="braden[ ]"
                                                                onchange="changeBraden(this.value, 'mobility_value')">
                                                                <option value="">Select one</option>
                                                                <option value="1"
                                                                    {{ @$assessment_info->mobility_value == 1 ? 'selected' : '' }}>
                                                                    Completely limited</option>
                                                                <option value="2"
                                                                    {{ @$assessment_info->mobility_value == 2 ? 'selected' : '' }}>
                                                                    Very limited</option>
                                                                <option value="3"
                                                                    {{ @$assessment_info->mobility_value == 3 ? 'selected' : '' }}>
                                                                    Slightly limited</option>
                                                                <option value="4"
                                                                    {{ @$assessment_info->mobility_value == 4 ? 'selected' : '' }}>
                                                                    No limitation</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input id="mobility_value" type="number"
                                                                class="custom-form"
                                                                value="{{ @$assessment_info->mobility_value }}"
                                                                name="braden[]" readonly />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left"><b>Nutrition</b></td>
                                                        <td colspan="4">
                                                            <select name="nutrition" id="nutrition"
                                                                class="custom-form" value="0"
                                                                onchange="changeBraden(this.value, 'nutrition_value')">
                                                                <option value="">Select one</option>
                                                                <option value="1"
                                                                    {{ @$assessment_info->nutrition_value == 1 ? 'selected' : '' }}>
                                                                    Very poor</option>
                                                                <option value="2"
                                                                    {{ @$assessment_info->nutrition_value == 2 ? 'selected' : '' }}>
                                                                    Probably inadequate</option>
                                                                <option value="3"
                                                                    {{ @$assessment_info->nutrition_value == 3 ? 'selected' : '' }}>
                                                                    Adequate</option>
                                                                <option value="4"
                                                                    {{ @$assessment_info->nutrition_value == 4 ? 'selected' : '' }}>
                                                                    Excellent</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input id="nutrition_value" type="number"
                                                                class="custom-form" name="braden[]"
                                                                value="{{ @$assessment_info->nutrition_value }}"
                                                                readonly />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left"><b>Friction and shear</b></td>
                                                        <td colspan="4">
                                                            <select name="friction" id="friction"
                                                                class="custom-form" value="0"
                                                                onchange="changeBraden(this.value, 'friction_value')">
                                                                <option value="">Select one</option>
                                                                <option value="1"
                                                                    {{ @$assessment_info->friction_value == 1 ? 'selected' : '' }}>
                                                                    Problem</option>
                                                                <option value="2"
                                                                    {{ @$assessment_info->friction_value == 2 ? 'selected' : '' }}>
                                                                    Potential problem</option>
                                                                <option value="3"
                                                                    {{ @$assessment_info->friction_value == 3 ? 'selected' : '' }}>
                                                                    No apparent problem</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input id="friction_value" type="number"
                                                                class="custom-form" name="braden[]"
                                                                value="{{ @$assessment_info->friction_value }}"
                                                                readonly />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="5" class="text-right"><b>Total score</b>
                                                        </td>
                                                        <td>
                                                            <input id="total_value" type="number"
                                                                class="custom-form" value="0" readonly />
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <td>Time</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td>None</td>
                                                        <td>Mild</td>
                                                        <td>Moderate</td>
                                                        <td>High</td>
                                                        <td>Severe</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Risk Scale</td>
                                                        <td>23,22,21,20,19</td>
                                                        <td>18,17,16,15</td>
                                                        <td>14,13</td>
                                                        <td>12,11,10</td>
                                                        <td>9,8,7,6</td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td class="text-center">A</td>
                                                        <td class="text-center">B</td>
                                                        <td class="text-center">C(A+B)</td>
                                                        <td class="text-center">C(A+B)</td>
                                                        <td class="text-center">C(A+B)</td>
                                                    </tr>

                                                    <tr>
                                                        <td colspan="3" class="text-center"> <b>Plan of care for
                                                                A</b></td>
                                                        <td colspan="3" class="text-center"> <b>Follow SKIN care
                                                                bundle for B and C</b></td>
                                                    </tr>


                                                    <tr>
                                                        <td colspan="3" style="width: 50%;padding:0px">
                                                            <div class="plan-a">
                                                                <table class="table">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td style="width:70%" class="text-left">
                                                                                Educate patient and family</td>
                                                                            <td style="width:30%"><input
                                                                                    type="text" name="a_education"
                                                                                    value="{{ @$assessment_info->a_education }}"
                                                                                    class="custom-form" /></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="width:70%" class="text-left">
                                                                                Evaluate the change of patient condition
                                                                            </td>
                                                                            <td style="width:30%"><input
                                                                                    type="text" name="a_evalution"
                                                                                    class="custom-form"
                                                                                    value="{{ @$assessment_info->a_evalution }}" />
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="width:70%" class="text-left">
                                                                                Evaluate the skin condition</td>
                                                                            <td style="width:30%"><input
                                                                                    type="text"
                                                                                    name="a_evalution_skin"
                                                                                    class="custom-form"
                                                                                    value="{{ @$assessment_info->a_evalution_skin }}" />
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </td>
                                                        <td colspan="3" style="width: 50%;padding:0px">
                                                            <div class="plan-b">
                                                                <table class="table">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td style="width:70%" class="text-left">
                                                                                <b>Surface:</b> Wringle free bed,
                                                                                appropriate pillows, Special mattress
                                                                            </td>
                                                                            <td style="width:30%"><input
                                                                                    type="text" name="bc_surface"
                                                                                    class="custom-form"
                                                                                    value="{{ @$assessment_info->bc_surface }}" />
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="width:70%" class="text-left">
                                                                                <b>Skin:</b> any device used, release
                                                                                the device and do the skin assessment
                                                                            </td>
                                                                            <td style="width:30%"><input
                                                                                    type="text" name="bc_skin"
                                                                                    class="custom-form"
                                                                                    value="{{ @$assessment_info->bc_skin }}" />
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="width:70%" class="text-left">
                                                                                <b>Keep moving:</b> mobilisation and
                                                                                2hrly position change
                                                                            </td>
                                                                            <td style="width:30%"><input
                                                                                    type="text" name="bc_moving"
                                                                                    class="custom-form"
                                                                                    value="{{ @$assessment_info->bc_moving }}" />
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="width:70%" class="text-left">
                                                                                <b>In case of Incontinence:</b> keep
                                                                                skin neat and dry, barrier lotion
                                                                                applied, change soiled diaper/under pad
                                                                                immediately
                                                                            </td>
                                                                            <td style="width:30%"><input
                                                                                    type="text"
                                                                                    name="bc_incontinence"
                                                                                    class="custom-form"
                                                                                    value="{{ @$assessment_info->bc_incontinence }}" />
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="width:70%" class="text-left">
                                                                                <b>Nutrition/hydration:</b> promote good
                                                                                nutrition and hydration of patient
                                                                            </td>
                                                                            <td style="width:30%"><input
                                                                                    type="text" name="bc_nutrition"
                                                                                    class="custom-form"
                                                                                    value="{{ @$assessment_info->bc_nutrition }}" />
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="width:70%" class="text-left">
                                                                                Educate patient and family daily</td>
                                                                            <td style="width:30%"><input
                                                                                    type="text" name="bc_educate"
                                                                                    class="custom-form"
                                                                                    value="{{ @$assessment_info->bc_educate }}" />
                                                                            </td>
                                                                        </tr>

                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td colspan="12">If the score is below 19, change position
                                                            and provide back
                                                            care</td>
                                                    </tr>
                                                </thead>
                                            </table>
                                            <table class="table border-0 mt-2 mb-0">
                                                <thead>

                                                    <tr class="border-0">
                                                        <th class="py-1 border-0 w-8">Time</th>
                                                        <th class="py-1 border-0 w-15">Back Care</th>
                                                        <th class="py-1 border-0 w-15">Position Change</th>
                                                        <th class="py-1 border-0 w-15">Skin Condition</th>
                                                        <th class="py-1 border-0 w-8">Time</th>
                                                        <th class="py-1 border-0 w-15">Back Care</th>
                                                        <th class="py-1 border-0 w-15">Position Change</th>
                                                        <th class="py-1 border-0 w-9">Action</th>
                                                    </tr>
                                                </thead>
                                                @php
                                                    $nc_time1_list = !empty($assessment_info->nc_time1)
                                                        ? json_decode($assessment_info->nc_time1, true)
                                                        : [];
                                                    $nc_backcare1_list = !empty($assessment_info->nc_backcare1)
                                                        ? json_decode($assessment_info->nc_backcare1, true)
                                                        : [];
                                                    $nc_pc1_list = !empty($assessment_info->nc_pc1)
                                                        ? json_decode($assessment_info->nc_pc1, true)
                                                        : [];
                                                    $nc_skin_list = !empty($assessment_info->nc_skin)
                                                        ? json_decode($assessment_info->nc_skin, true)
                                                        : [];
                                                    $nc_time2_list = !empty($assessment_info->nc_time2)
                                                        ? json_decode($assessment_info->nc_time2, true)
                                                        : [];
                                                    $nc_backcare2_list = !empty($assessment_info->nc_backcare2)
                                                        ? json_decode($assessment_info->nc_backcare2, true)
                                                        : [];
                                                    $nc_pc2_list = !empty($assessment_info->nc_pc2)
                                                        ? json_decode($assessment_info->nc_pc2, true)
                                                        : [];
                                                @endphp

                                                <tbody id="nursingCareBody">
                                                    @if (!empty($nc_time1_list))
                                                        @foreach ($nc_time1_list as $i => $time1)
                                                            <tr>
                                                                <td>
                                                                    <input type="time"
                                                                        class="form-control form-control-sm"
                                                                        name="nc_time1[]"
                                                                        value="{{ $time1 }}">
                                                                </td>
                                                                <td>
                                                                    <input type="text"
                                                                        class="form-control form-control-sm"
                                                                        name="nc_backcare1[]"
                                                                        value="{{ $nc_backcare1_list[$i] ?? '' }}">
                                                                </td>
                                                                <td>
                                                                    <input type="text"
                                                                        class="form-control form-control-sm"
                                                                        name="nc_pc1[]"
                                                                        value="{{ $nc_pc1_list[$i] ?? '' }}">
                                                                </td>
                                                                <td>
                                                                    <input type="text"
                                                                        class="form-control form-control-sm"
                                                                        name="nc_skin[]"
                                                                        value="{{ $nc_skin_list[$i] ?? '' }}">
                                                                </td>
                                                                <td>
                                                                    <input type="time"
                                                                        class="form-control form-control-sm"
                                                                        name="nc_time2[]"
                                                                        value="{{ $nc_time2_list[$i] ?? '' }}">
                                                                </td>
                                                                <td>
                                                                    <input type="text"
                                                                        class="form-control form-control-sm"
                                                                        name="nc_backcare2[]"
                                                                        value="{{ $nc_backcare2_list[$i] ?? '' }}">
                                                                </td>
                                                                <td>
                                                                    <input type="text"
                                                                        class="form-control form-control-sm"
                                                                        name="nc_pc2[]"
                                                                        value="{{ $nc_pc2_list[$i] ?? '' }}">
                                                                </td>
                                                                <td class="text-center">
                                                                    <span class="btn btn-success btn-md add"><i
                                                                            class="fa fa-plus"></i></span>
                                                                    <span class="btn btn-danger btn-md deleterow">
                                                                        <i class="fa fa-trash"></i>
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td><input type="time"
                                                                    class="form-control form-control-sm"
                                                                    name="nc_time1[]"></td>
                                                            <td><input type="text"
                                                                    class="form-control form-control-sm"
                                                                    name="nc_backcare1[]"></td>
                                                            <td><input type="text"
                                                                    class="form-control form-control-sm"
                                                                    name="nc_pc1[]"></td>
                                                            <td><input type="text"
                                                                    class="form-control form-control-sm"
                                                                    name="nc_skin[]"></td>
                                                            <td><input type="time"
                                                                    class="form-control form-control-sm"
                                                                    name="nc_time2[]"></td>
                                                            <td><input type="text"
                                                                    class="form-control form-control-sm"
                                                                    name="nc_backcare2[]"></td>
                                                            <td><input type="text"
                                                                    class="form-control form-control-sm"
                                                                    name="nc_pc2[]"></td>
                                                            <td class="text-center">
                                                                <span class="btn btn-success btn-md add"><i
                                                                        class="fa fa-plus"></i></span>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table> <br>

                                            <table class="table border-0 mt-2 mb-0">
                                                <thead>
                                                    <tr>
                                                        <th colspan="4" style="text-align: center">SPECIAL NOTE
                                                            CONTINUED</th>
                                                    </tr>
                                                    <tr class="border-0">
                                                        <th class="py-1 border-0 w-15" style="text-align: center">
                                                            Time</th>
                                                        <th class="py-1 border-0 w-45" style="text-align: center">
                                                            Taken over form</th>
                                                        <th class="py-1 border-0 w-20" style="text-align: center">
                                                            Sign with ID</th>
                                                        <th class="py-1 border-0 w-10" style="text-align: center">
                                                            Action</th>
                                                    </tr>
                                                </thead>
                                                @php
                                                    $sn_time_list = !empty($assessment_info->sn_time)
                                                        ? json_decode($assessment_info->sn_time, true)
                                                        : [];
                                                    $sn_taken_list = !empty($assessment_info->sn_taken)
                                                        ? json_decode($assessment_info->sn_taken, true)
                                                        : [];
                                                    $sn_signid_list = !empty($assessment_info->sn_signid)
                                                        ? json_decode($assessment_info->sn_signid, true)
                                                        : [];
                                                @endphp

                                                <tbody id="specialNoteBody">
                                                    @if (!empty($sn_time_list))
                                                        @foreach ($sn_time_list as $i => $time)
                                                            <tr>
                                                                <td>
                                                                    <input type="time"
                                                                        class="form-control form-control-sm"
                                                                        name="sn_time[]"
                                                                        value="{{ $time }}">
                                                                </td>
                                                                <td>
                                                                    <input type="text"
                                                                        class="form-control form-control-sm"
                                                                        name="sn_taken[]"
                                                                        value="{{ $sn_taken_list[$i] ?? '' }}">
                                                                </td>
                                                                <td>
                                                                    <input type="text"
                                                                        class="form-control form-control-sm"
                                                                        name="sn_signid[]"
                                                                        value="{{ $sn_signid_list[$i] ?? '' }}">
                                                                </td>
                                                                <td class="text-center">
                                                                    <span class="btn btn-success btn-md snadd"><i
                                                                            class="fa fa-plus"></i>
                                                                    </span> <span
                                                                        class="btn btn-danger btn-md sndelete">
                                                                        <i class="fa fa-trash"></i>
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td><input type="time"
                                                                    class="form-control form-control-sm"
                                                                    name="sn_time[]"></td>
                                                            <td><input type="text"
                                                                    class="form-control form-control-sm"
                                                                    name="sn_taken[]"></td>
                                                            <td><input type="text"
                                                                    class="form-control form-control-sm"
                                                                    name="sn_signid[]"></td>
                                                            <td class="text-center">
                                                                <span class="btn btn-success btn-md snadd"><i
                                                                        class="fa fa-plus"></i></span>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>


                                        </div>

                                        <div class="text-center">

                                            @php
                                                $redirect_url = route('nursing-initial-assessment-gynaecology', [
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
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('asset/timepicker/js/timepicker.js') }}"></script>
<script type="text/javascript">
    openDoctorAutocomplete('#sepsis_name', 'hh_sepsis_name', 'employee_ind', '1');
    openDoctorAutocomplete('#bystander_signature_name', 'bystander_signature_id');
    openDoctorAutocomplete('#rn_sign_name', 'complete_by');

    $(document).ready(function() {
        var currentDate = new Date();
        $('.date_picker').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            format: 'dd/mm/yyyy',
        }).datepicker('setDate', currentDate);

        let score = 0;
        $(".score:checked").each(function() {
            score += parseInt($(this).val(), 10); // Convert to integer before adding
        });
        $("#clinical_total_score").val(score);
        calaculateTotalScore();



        setUpdateValue();
    })

    $(document).on("click", ".score", function() {
        let scores = 0;
        $(".score:checked").each(function() {
            scores += parseInt($(this).val(), 10); // Convert to integer before adding
        });
        $("#clinical_total_score").val(scores);
    })

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function setUpdateValue() {
        var sum = 0;
        $("input[name^='braden[]']").each(function() {
            sum += parseFloat($(this).val()) || 0;
        });
        $("#total_value").val(sum);

        var plan_a = [23, 22, 21, 20, 19];
        var plan_b = [17, 17, 16, 15, 14, 13, 12, 11, 10, 9, 8, 7, 6];

        if (plan_a.includes(sum)) {
            $(".plan-b").hide();
            $(".plan-a").show();
        } else if (plan_b.includes(sum)) {
            $(".plan-a").hide();
            $(".plan-b").show();
        }
    }

    function calaculateTotalScore() {
        var motor_response = $("#motor_response").val();
        var eyes_open = $("#eyes_open").val();
        var verbal_response = $("#verbal_response").val();

        $("#total_score").val(parseFloat(motor_response) + parseFloat(eyes_open) + parseFloat(verbal_response));
    }

    function onChangePresence(value) {
        if (value == 3) {
            $("#presence_lines_specify").show();
        } else {
            $("#presence_lines_specify").hide();
        }
    }

    function changeAllergy(value) {
        if (value == 1) {
            $("#allergy_list").show();
        } else {
            $("#allergy_list").hide();
        }
    }

    function saveAssesment() {
        let formElement = document.querySelector('#assesmentForm');
        let formData = new FormData(formElement);
        if ($('#admission_no_pk').val() == '') {
            alert('Amission no required');
            return false;
        }

        if ($('#patient_id').val() == '') {
            alert('Patient no required');
            return false;
        }

        $.ajax({
            url: "{{ route('v2.ipd.nursing-assesment-save') }}",
            type: "post",
            dataType: "json",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                $.unblockUI();
                $('.common-modal-notify').modal('show');
                $('.common-modal-notify .modal-title').html('Success');
                $('.common-modal-notify .modal-body').html(data.message);
            },
            error: function(err) {
                $.unblockUI();
                var error = err.responseJSON;
                $('.common-modal-notify-error').modal('show');
                $('.common-modal-notify-error .modal-title').html('Failed');
                $('.common-modal-notify-error .modal-body').html(error.message);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    }

    // Change Braden
    function changeBraden(value, id) {
        $("#" + id).val(value);
        var sum = 0;
        $("input[name^='braden[]']").each(function() {
            sum += parseFloat($(this).val()) || 0;
        });
        $("#total_value").val(sum);

        var plan_a = [23, 22, 21, 20, 19];
        var plan_b = [17, 17, 16, 15, 14, 13, 12, 11, 10, 9, 8, 7, 6];

        if (plan_a.includes(sum)) {
            $(".plan-b").hide();
            $(".plan-a").show();
        } else if (plan_b.includes(sum)) {
            $(".plan-a").hide();
            $(".plan-b").show();
        }
    }


    function changeInvassive(value) {
        console.log('value', value)
        if (value == 2) {
            $("#invasive_type_text").attr('readonly', false);
        } else {
            $("#invasive_type_text").attr('readonly', true);
        }
    }

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

        $("#nursingCareBody").append(row);

        // reinit select2 if needed
        row.find(".select2").select2();
    });

    // Remove row
    $(document).on('click', '.deleterow', function() {
        $(this).closest('tr').remove();
    });

    $(document).on('click', '.snadd', function() {
        let row = $(this).closest('tr').clone();

        // clear inputs
        row.find("input, select").val("");

        // replace action buttons → only delete button
        row.find("td:last").html(`
            <span class="btn btn-danger btn-md sndelete">
                <i class="fa fa-trash"></i>
            </span>
        `);

        // append new row

        $("#specialNoteBody").append(row);

        // reinit select2 if needed
        row.find(".select2").select2();
    });

    // Remove row
    $(document).on('click', '.sndelete', function() {
        $(this).closest('tr').remove();
    });
</script>
