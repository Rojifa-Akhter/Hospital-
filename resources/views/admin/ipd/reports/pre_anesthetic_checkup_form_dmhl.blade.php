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
                <h5 class="mt-2 mb-0">Pre Anesthesia Checkup Form</h5>
                <small>Report / Pre Anesthesia Checkup Form</small>
            </div>
        </div>
        {{-- @dd($anaesthetist_record_data) --}}
        <div class="anaesthetic__form">
            <form action="{{ route('pre-anesthetic-checkup-store') }}" method="post" id="PREANESTHETICCHECKUP">
                @csrf
                <input type="hidden" name="admission_id"
                    value="{{ isset($pat_info->admission_no_pk) ? $pat_info->admission_no_pk : '' }}">
                <input type="hidden" name="pat_id"
                    value="{{ isset($pat_info->patient_no_fk) ? $pat_info->patient_no_fk : '' }}">
                <input type="hidden" name="pre_anesthetics_checkup_no_pk"
                    value="{{ isset($pre_anesthetic_checkup->pre_anesthetics_checkup_no_pk) ? $pre_anesthetic_checkup->pre_anesthetics_checkup_no_pk : '' }}">
                <div class="">
                    <!-- header -->
                    {{-- <div class="form-row py-3 align-items-center">
                        <div class="col-md-4">
                            <img src="image/logo_ewmc-removebg-preview.png" alt="logo" />
                        </div>
                        <div class="col-md-8">
                            <div class="header-info text-center">
                                <h1>East West Medical College & Hospital</h1>
                                <p>Dhour, Nishatnagar, Turag, Dhaka-1230</p>
                            </div>
                        </div>
                    </div> --}}
                    <!-- header -->
                    <div class="form-row">
                        <div class="col-md-12">
                            <div class="card">
                                <!-- 1st card body -->
                                <div class="card-header text-center">
                                    <h2 class="card-title mb-0 text-left"> <strong> Patient Info</strong></h2>
                                </div>
                                <div class="card-body p-3">
                                    <div class="form-row" style="border: 1px solid #298949; padding: 10px;">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="nameOfpt" class="col-form-label col-form-label-sm">Name of
                                                    pt</label>
                                                <input type="text" class="form-control form-control-sm" readonly
                                                    id="nameOfpt" name="nameOfpt"
                                                    value="{{ isset($pat_info->patient_name) ? $pat_info->patient_name : '' }}"
                                                    placeholder="Name Of pt" />
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="regNo" class="col-form-label col-form-label-sm">Patient
                                                    Id</label>
                                                <input type="text" class="form-control form-control-sm"
                                                    id="regNo" name="regNo"
                                                    value="{{ isset($pat_info->patient_code) ? $pat_info->patient_code : '' }}"
                                                    placeholder="" readonly />
                                            </div>
                                        </div>
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
                                                    class="col-form-label col-form-label-sm">Sex</label>
                                                <input type="text" class="form-control form-control-sm"
                                                    id="ptSex" name="ptSex"
                                                    value="{{ isset($pat_info->gender_txt) ? $pat_info->gender_txt : '' }}"
                                                    placeholder="" readonly />
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="ptUnit"
                                                    class="col-form-label col-form-label-sm">Department</label>
                                                <input type="text" class="form-control form-control-sm"
                                                    id="ptUnit" name="ptUnit"
                                                    value="{{ isset($pat_info->new_su_name) ? $pat_info->new_su_name : '' }}"
                                                    placeholder="" readonly />
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="ptWard"
                                                    class="col-form-label col-form-label-sm">Ward</label>
                                                <input type="text" class="form-control form-control-sm"
                                                    id="ptWard" name="ptWard"
                                                    value="{{ isset($pat_info->new_ward_name) ? $pat_info->new_ward_name : '' }}"
                                                    placeholder="" readonly />
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="ptBed"
                                                    class="col-form-label col-form-label-sm">Bed</label>
                                                <input type="text" class="form-control form-control-sm"
                                                    id="ptBed" name="ptBed"
                                                    value="{{ isset($pat_info->new_bed_name) ? $pat_info->new_bed_name : '' }}"
                                                    placeholder="" readonly />
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="date"
                                                    class="col-form-label col-form-label-sm">Date</label>
                                                <input type="text" class="form-control form-control-sm date_picker"
                                                    id="date" name="date"
                                                    value="{{ isset($pre_anesthetic_checkup->ot_date) ? date('d-m-Y', strtotime($pre_anesthetic_checkup->ot_date)) : '' }}"
                                                    placeholder="dd-mm-YYYY" />
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="ptBed"
                                                    class="col-form-label col-form-label-sm">Referred Doctor</label>
                                                <input type="text" class="form-control form-control-sm"
                                                    id="doctor_name" name="doctor_name" placeholder="Dr. Name"
                                                    value="{{ isset($pat_info->primary_doctor_name) ? $pat_info->primary_doctor_name : '' }}" />
                                                <input type="hidden" name="hdn_doctor_id" id="hdn_doctor_id"
                                                    value="{{ isset($pat_info->primary_doctor_no_fk) ? $pat_info->primary_doctor_no_fk : '' }}">





                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="card-body p-3">
                                    <div class="">
                                        <table width="100%" border="1">
                                            <tr>
                                                <td style="">
                                                    <strong> Height : </strong> <input type="text"
                                                        class="form-control form-control  " id="height"
                                                        name="height"
                                                        value="{{ isset($pre_anesthetic_checkup->height) ? $pre_anesthetic_checkup->height : '' }}"
                                                        placeholder="eg. 170 cm" onkeyup="HeightCalculate()" />
                                                </td>
                                                <td style="">
                                                    <strong> Weight : </strong> <input type="text"
                                                        class="form-control form-control  " id="weight"
                                                        name="weight"
                                                        value="{{ isset($pre_anesthetic_checkup->weight) ? $pre_anesthetic_checkup->weight : '' }}"
                                                        placeholder="eg. 80 kg" onkeyup="WeightCalculate()" />
                                                </td>

                                                <td style="">
                                                    <strong> BMI : </strong> <input type="text"
                                                        class="form-control form-control  " id="bmi"
                                                        name="bmi"
                                                        value="{{ isset($pre_anesthetic_checkup->bmi) ? $pre_anesthetic_checkup->bmi : '' }}"
                                                        placeholder="Kg/m2 " />
                                                </td>
                                                <td style="">
                                                    <strong>B.Group</strong>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="ptBlood" name="ptBlood"
                                                        value="{{ isset($pat_info->blood_group_text) ? $pat_info->blood_group_text : '' }}"
                                                        placeholder="" readonly />
                                                </td>
                                            </tr>

                                            <tr>
                                                <td style="">
                                                    <strong> Smooker : </strong> <br>
                                                    <label for="smooker_1">Yes</label> <input type="radio"
                                                        name="smooker" id="smooker_1" value="Yes"
                                                        {{ isset($pre_anesthetic_checkup->smooker) && $pre_anesthetic_checkup->smooker == 'Yes' ? 'checked' : '' }}>
                                                    <label for="smooker_2">No</label> <input type="radio"
                                                        name="smooker" id="smooker_2" value="No"
                                                        {{ isset($pre_anesthetic_checkup->smooker) && $pre_anesthetic_checkup->smooker == 'No' ? 'checked' : '' }}>
                                                </td>

                                                <td style="">
                                                    <strong> Alcohol : </strong> <br>
                                                    <label for="alcohol_1">Yes</label> <input type="radio"
                                                        name="alcohol" id="alcohol_1" value="Yes"
                                                        {{ isset($pre_anesthetic_checkup->alcohol) && $pre_anesthetic_checkup->alcohol == 'Yes' ? 'checked' : '' }}>
                                                    <label for="alcohol_2">No</label> <input type="radio"
                                                        name="alcohol" id="alcohol_2" value="No"
                                                        {{ isset($pre_anesthetic_checkup->alcohol) && $pre_anesthetic_checkup->alcohol == 'No' ? 'checked' : '' }}>
                                                </td>
                                                <td style="">
                                                    <strong> Artificial Denture : </strong> <br>
                                                    <label for="artificial_denture_1">Yes</label> <input
                                                        type="radio" name="artificial_denture"
                                                        id="artificial_denture_1" value="Yes"
                                                        {{ isset($pre_anesthetic_checkup->artificial_denture) && $pre_anesthetic_checkup->artificial_denture == 'Yes' ? 'checked' : '' }}>
                                                    <label for="artificial_denture_2">No</label> <input type="radio"
                                                        name="artificial_denture" id="artificial_denture_2"
                                                        value="No"
                                                        {{ isset($pre_anesthetic_checkup->artificial_denture) && $pre_anesthetic_checkup->artificial_denture == 'No' ? 'checked' : '' }}>
                                                </td>
                                                <td style=""></td>
                                            </tr>

                                            <tr>
                                                <td style="width: 250px">Preoperative Diagnosis</td>
                                                <td colspan="3"> <input type="text"
                                                        class="form-control form-control  "
                                                        id="Preoperative_Diagnosis" name="Preoperative_Diagnosis"
                                                        value="{{ isset($pre_anesthetic_checkup->preoperative_diagnosis) ? $pre_anesthetic_checkup->preoperative_diagnosis : '' }}" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 200px">Proposed Surgery</td>
                                                <td colspan="3"> <input type="text"
                                                        class="form-control form-control  " id="propost_surgery"
                                                        name="propost_surgery"
                                                        value="{{ isset($pre_anesthetic_checkup->proposed_surgery) ? $pre_anesthetic_checkup->proposed_surgery : '' }}" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 200px">Date of Operation</td>
                                                <td colspan="3">
                                                    <input type="text"
                                                        class="form-control form-control-sm date_picker"
                                                        id="scheduled_for_surgery" name="scheduled_for_surgery"
                                                        value="{{ isset($pre_anesthetic_checkup->scheduled_surgery_date) ? date('d-m-Y', strtotime($pre_anesthetic_checkup->scheduled_surgery_date)) : '' }}"
                                                        placeholder="dd-mm-YYYY" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 200px">Operation</td>
                                                <td colspan="3">
                                                    <label for="elective"> Elective </label> <input type="radio"
                                                        name="operation" id="elective" value="Elective"
                                                        {{ isset($pre_anesthetic_checkup->operation) && $pre_anesthetic_checkup->operation == 'Elective' ? 'checked' : '' }}>
                                                    <label for="emergency"> Emergency </label><input type="radio"
                                                        name="operation" id="emergency" value="Emergency"
                                                        {{ isset($pre_anesthetic_checkup->operation) && $pre_anesthetic_checkup->operation == 'Emergency' ? 'checked' : '' }}>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="1">
                                                    <strong> Category </strong>
                                                </td>
                                                <td colspan="3">
                                                    <input type="radio" value="1" name="category"
                                                        id="category"
                                                        {{ isset($pre_anesthetic_checkup->asa_class1) && $pre_anesthetic_checkup->asa_class1 == '1' ? 'checked' : '' }}>
                                                    1 &nbsp;&nbsp;&nbsp;
                                                    <input type="radio" value="2" name="category"
                                                        id="category"
                                                        {{ isset($pre_anesthetic_checkup->asa_class1) && $pre_anesthetic_checkup->asa_class1 == '2' ? 'checked' : '' }}>
                                                    2 &nbsp;&nbsp;&nbsp;
                                                    <input type="radio" value="3" name="category"
                                                        id="category"
                                                        {{ isset($pre_anesthetic_checkup->asa_class1) && $pre_anesthetic_checkup->asa_class1 == '3' ? 'checked' : '' }}>
                                                    3 &nbsp;&nbsp;&nbsp;
                                                    <input type="radio" value="4" name="category"
                                                        id="category"
                                                        {{ isset($pre_anesthetic_checkup->asa_class1) && $pre_anesthetic_checkup->asa_class1 == '4' ? 'checked' : '' }}>
                                                    4 &nbsp;&nbsp;&nbsp;

                                                </td>
                                            </tr>

                                        </table>

                                        <table width="100%" border="1" style="margin-top:10px">
                                            <tr>
                                                <td colspan="1">
                                                    <strong> Previous Anesthesia : (Complications if any)</strong>
                                                </td>
                                                <td colspan="5">
                                                    <input type="text" class="form-control  "
                                                        id="previous_anesthesia_name" name="previous_anesthesia_name"
                                                        value="{{ isset($pre_anesthetic_checkup->previous_anesthesia) ? $pre_anesthetic_checkup->previous_anesthesia : '' }}" />
                                                    <input type="hidden" name="hdn_previous_anesthesia_id"
                                                        id="hdn_previous_anesthesia_id"
                                                        value="{{ isset($pre_anesthetic_checkup->previous_anesthesia_no_fk) ? $pre_anesthetic_checkup->previous_anesthesia_no_fk : '' }}">
                                                </td>
                                            </tr>

                                            <tr>
                                                <td colspan="6"><strong>Co-existing diseases with duration
                                                        :</strong></td>
                                            </tr>
                                            <tr>
                                                <td style="">
                                                    <strong> Hypertension : </strong> <input type="text"
                                                        class="form-control form-control  " id="hypertension"
                                                        name="hypertension"
                                                        value="{{ isset($pre_anesthetic_checkup->hypertension) ? $pre_anesthetic_checkup->hypertension : '' }}"
                                                        placeholder="" />
                                                </td>
                                                <td style="">
                                                    <strong> IHD : </strong> <input type="text"
                                                        class="form-control form-control  " id="ihd"
                                                        name="ihd"
                                                        value="{{ isset($pre_anesthetic_checkup->ihd) ? $pre_anesthetic_checkup->ihd : '' }}"
                                                        placeholder="" />
                                                </td>

                                                <td style="">
                                                    <strong> Myocardial infarction: </strong> <input type="text"
                                                        class="form-control form-control  " id="myocardial"
                                                        name="myocardial"
                                                        value="{{ isset($pre_anesthetic_checkup->myocardial) ? $pre_anesthetic_checkup->myocardial : '' }}"
                                                        placeholder="" />
                                                </td>
                                                <td style="">
                                                    <strong>Diabetes</strong>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="diabetes" name="diabetes"
                                                        value="{{ isset($pre_anesthetic_checkup->diabetes) ? $pre_anesthetic_checkup->diabetes : '' }}"
                                                        placeholder="" />
                                                </td>
                                                <td style="">
                                                    <strong>Thyroid disorder</strong>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="thyroid_disorder" name="thyroid_disorder"
                                                        value="{{ isset($pre_anesthetic_checkup->thyroid_disorder) ? $pre_anesthetic_checkup->thyroid_disorder : '' }}"
                                                        placeholder="" />
                                                </td>
                                                <td style="">
                                                    <strong>Others</strong>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="others_medical_problem" name="others_medical_problem"
                                                        value="{{ isset($pre_anesthetic_checkup->others_medical_problem) ? $pre_anesthetic_checkup->others_medical_problem : '' }}"
                                                        placeholder="" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="1" style="width: 300px;">
                                                    <strong> Present Medication : </strong>
                                                </td>
                                                <td colspan="5">
                                                    <input type="text" class="form-control  "
                                                        id="present_medication" name="present_medication"
                                                        value="{{ isset($pre_anesthetic_checkup->present_medication) ? $pre_anesthetic_checkup->present_medication : '' }}" />

                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong> Allergy : </strong>
                                                </td>
                                                <td colspan="5">
                                                    <input type="text" class="form-control  " id="allergy"
                                                        name="allergy"
                                                        value="{{ isset($pre_anesthetic_checkup->allergy) ? $pre_anesthetic_checkup->allergy : '' }}" />
                                                </td>
                                            </tr>
                                        </table>

                                        <h2>Investigations</h2>
                                        <table width="100%" border="1" style="margin-top:10px">
                                            <tr>
                                                <td>
                                                    <strong> HB</strong>
                                                    <input type="text" class="form-control" id="hb_pcv"
                                                        name="hb_pcv"
                                                        value="{{ isset($pre_anesthetic_checkup->hb_pcv) ? $pre_anesthetic_checkup->hb_pcv : '' }}" />
                                                </td>
                                                <td>
                                                    <strong> PCV</strong>
                                                    <input type="text" class="form-control" id="pcv"
                                                        name="pcv"
                                                        value="{{ isset($pre_anesthetic_checkup->pcv) ? $pre_anesthetic_checkup->pcv : '' }}" />
                                                </td>
                                                <td>
                                                    <strong> WBC</strong>
                                                    <input type="text" class="form-control" id="wbc"
                                                        name="wbc"
                                                        value="{{ isset($pre_anesthetic_checkup->wbc) ? $pre_anesthetic_checkup->wbc : '' }}" />
                                                </td>
                                                <td>
                                                    <strong> Platelet </strong>
                                                    <input type="text" class="form-control" id="platelet_count"
                                                        name="platelet_count"
                                                        value="{{ isset($pre_anesthetic_checkup->platelet_count) ? $pre_anesthetic_checkup->platelet_count : '' }}" />
                                                </td>

                                                <td>
                                                    <strong> Blood sugar:( Fasting/Random)</strong> <br>
                                                    <input type="text" class="form-control" id="fbs_rbs"
                                                        name="fbs_rbs"
                                                        value="{{ isset($pre_anesthetic_checkup->fbs_rbs) ? $pre_anesthetic_checkup->fbs_rbs : '' }}" />
                                                    {{-- <input type="radio" value="1" name="blood_suger" {{ isset($pre_anesthetic_checkup->blood_suger) && $pre_anesthetic_checkup->blood_suger == '1' ? 'checked' : '' }}> Yes &nbsp;&nbsp;
                                                    <input type="radio" value="2" name="blood_suger" {{ isset($pre_anesthetic_checkup->blood_suger) && $pre_anesthetic_checkup->blood_suger == '2' ? 'checked' : '' }}> No --}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong> HbA1C</strong>
                                                    <input type="text" class="form-control" id="hba1c"
                                                        name="hba1c"
                                                        value="{{ isset($pre_anesthetic_checkup->hba1c) ? $pre_anesthetic_checkup->hba1c : '' }}" />
                                                </td>

                                                <td>
                                                    <strong>Blood Group</strong>
                                                    <input type="text" class="form-control" id="blood_group"
                                                        name="blood_group"
                                                        value="{{ isset($pre_anesthetic_checkup->blood_group) ? $pre_anesthetic_checkup->blood_group : '' }}" />
                                                </td>

                                                <td>
                                                    <strong>TSH</strong>
                                                    <input type="text" class="form-control" id="tsh"
                                                        name="tsh"
                                                        value="{{ isset($pre_anesthetic_checkup->tsh) ? $pre_anesthetic_checkup->tsh : '' }}" />
                                                </td>
                                                <td>
                                                    <strong>T3/T4</strong>
                                                    <input type="text" class="form-control" id="T3_t4"
                                                        name="T3_t4"
                                                        value="{{ isset($pre_anesthetic_checkup->t3_t4) ? $pre_anesthetic_checkup->t3_t4 : '' }}" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong>Serum : [Na+]</strong>
                                                    <input type="text" class="form-control" id="na"
                                                        name="na"
                                                        value="{{ isset($pre_anesthetic_checkup->na) ? $pre_anesthetic_checkup->na : '' }}" />
                                                </td>
                                                <td>

                                                    <strong> [K+]</strong>
                                                    <input type="text" class="form-control" id="k"
                                                        name="k"
                                                        value="{{ isset($pre_anesthetic_checkup->k) ? $pre_anesthetic_checkup->k : '' }}" />
                                                </td>
                                                <td>
                                                    <strong> [CL <strong><sup>-</sup></strong>]</strong>
                                                    <input type="text" class="form-control" id="cl"
                                                        name="cl"
                                                        value="{{ isset($pre_anesthetic_checkup->cl) ? $pre_anesthetic_checkup->cl : '' }}" />
                                                </td>
                                                <td>
                                                    <strong> Creat.</strong>
                                                    <input type="text" class="form-control" id="screatinine"
                                                        name="screatinine"
                                                        value="{{ isset($pre_anesthetic_checkup->screatinine) ? $pre_anesthetic_checkup->screatinine : '' }}" />
                                                </td>
                                                <td>
                                                    <strong> Urea</strong>
                                                    <input type="text" class="form-control" id="urea"
                                                        name="urea"
                                                        value="{{ isset($pre_anesthetic_checkup->urea) ? $pre_anesthetic_checkup->urea : '' }}" />
                                                </td>

                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong>Coags : PT</strong>
                                                    <input type="text" class="form-control" id="pt"
                                                        name="pt"
                                                        value="{{ isset($pre_anesthetic_checkup->pt) ? $pre_anesthetic_checkup->pt : '' }}" />
                                                </td>
                                                <td>
                                                    <strong> APTT</strong>
                                                    <input type="text" class="form-control" id="aptt"
                                                        name="aptt"
                                                        value="{{ isset($pre_anesthetic_checkup->aptt) ? $pre_anesthetic_checkup->aptt : '' }}" />
                                                </td>

                                                <td>
                                                    <strong>INR</strong>
                                                    <input type="text" class="form-control" id="inr"
                                                        name="inr"
                                                        value="{{ isset($pre_anesthetic_checkup->inr) ? $pre_anesthetic_checkup->inr : '' }}" />
                                                </td>
                                                <td>
                                                    <strong>BT</strong>
                                                    <input type="text" class="form-control" id="bt"
                                                        name="bt"
                                                        value="{{ isset($pre_anesthetic_checkup->bt) ? $pre_anesthetic_checkup->bt : '' }}" />
                                                </td>
                                                <td>
                                                    <strong>CT</strong>
                                                    <input type="text" class="form-control" id="ct"
                                                        name="ct"
                                                        value="{{ isset($pre_anesthetic_checkup->ct) ? $pre_anesthetic_checkup->ct : '' }}" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong>ABG : pH</strong>
                                                    <input type="text" class="form-control" id="ph"
                                                        name="ph"
                                                        value="{{ isset($pre_anesthetic_checkup->ph) ? $pre_anesthetic_checkup->ph : '' }}" />
                                                </td>
                                                <td>
                                                    <strong>paO <sub>2</sub></strong>
                                                    <input type="text" class="form-control" id="pao2"
                                                        name="pao2"
                                                        value="{{ isset($pre_anesthetic_checkup->pao2) ? $pre_anesthetic_checkup->pao2 : '' }}" />
                                                </td>
                                                <td>
                                                    <strong>paCO <sub>2</sub></strong>
                                                    <input type="text" class="form-control" id="paco2"
                                                        name="paco2"
                                                        value="{{ isset($pre_anesthetic_checkup->paco2) ? $pre_anesthetic_checkup->paco2 : '' }}" />
                                                </td>
                                                <td>
                                                    {{-- <strong>BE</strong> <sub>3</sub> --}}
                                                    <strong>HCo</strong> <sub>3</sub>-
                                                    <input type="text" class="form-control" id="nco2"
                                                        name="nco2"
                                                        value="{{ isset($pre_anesthetic_checkup->nco2) ? $pre_anesthetic_checkup->nco2 : '' }}" />
                                                </td>
                                                <td></td>


                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong> HbsAg</strong>
                                                    <input type="text" class="form-control" id="hbsag"
                                                        name="hbsag"
                                                        value="{{ isset($pre_anesthetic_checkup->hbsag) ? $pre_anesthetic_checkup->hbsag : '' }}" />
                                                </td>
                                                <td>
                                                    <strong> HCB</strong>
                                                    <input type="text" class="form-control" id="hcv"
                                                        name="hcv"
                                                        value="{{ isset($pre_anesthetic_checkup->hcv) ? $pre_anesthetic_checkup->hcv : '' }}" />
                                                </td>
                                                <td>
                                                    <strong>HIV</strong>
                                                    <input type="text" class="form-control" id="hiv"
                                                        name="hiv"
                                                        value="{{ isset($pre_anesthetic_checkup->hiv) ? $pre_anesthetic_checkup->hiv : '' }}" />
                                                </td>
                                                <td></td>
                                                <td></td>
                                            </tr>

                                            <tr>
                                                <td colspan="3">
                                                    <strong>Liver function test</strong>
                                                    <input type="text" class="form-control" id="lft"
                                                        name="lft"
                                                        value="{{ isset($pre_anesthetic_checkup->lft) ? $pre_anesthetic_checkup->lft : '' }}" />
                                                </td>
                                                <td colspan="3">
                                                    <strong>CXR</strong>
                                                    <input type="text" class="form-control" id="cxr"
                                                        name="cxr"
                                                        value="{{ isset($pre_anesthetic_checkup->cxr) ? $pre_anesthetic_checkup->cxr : '' }}" />
                                                </td>
                                            </tr>

                                            <tr>
                                                <td colspan="3">
                                                    <strong>ECG</strong>
                                                    <input type="text" class="form-control" id="ecg"
                                                        name="ecg"
                                                        value="{{ isset($pre_anesthetic_checkup->ecg) ? $pre_anesthetic_checkup->ecg : '' }}" />
                                                </td>
                                                <td colspan="3">
                                                    <strong>Echo</strong>
                                                    <input type="text" class="form-control" id="echo"
                                                        name="echo"
                                                        value="{{ isset($pre_anesthetic_checkup->echo) ? $pre_anesthetic_checkup->echo : '' }}" />
                                                </td>
                                            </tr>

                                            <tr>
                                                <td colspan="6">
                                                    <strong>Others</strong>
                                                    <input type="text" class="form-control" id="others2"
                                                        name="others2"
                                                        value="{{ isset($pre_anesthetic_checkup->other2) ? $pre_anesthetic_checkup->other2 : '' }}" />
                                                </td>

                                            </tr>
                                        </table>


                                        <h3> <strong>General Examination </strong></h3>
                                        <table width="100%" border="1" style="margin-top:10px">
                                            {{-- <tr>
                                                <td>
                                                    <strong> General Examination : </strong>
                                                </td>
                                                <td colspan="3">
                                                    <input type="text" class="form-control  " id="general_examination" name="general_examination" value="{{ isset($pre_anesthetic_checkup->general_exam) ? $pre_anesthetic_checkup->general_exam : '' }}" />
                                                </td>

                                            </tr> --}}
                                            <tr>
                                                <td>
                                                    <strong> Pulse : </strong>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control  " id="pulse"
                                                        name="pulse"
                                                        value="{{ isset($pre_anesthetic_checkup->pulse) ? $pre_anesthetic_checkup->pulse : '' }}" />
                                                </td>
                                                <td>
                                                    <strong> Jaundice : </strong>
                                                </td>
                                                <td>
                                                    <input type="radio" value="(-) ve" name="jaundice"
                                                        id=""
                                                        {{ isset($pre_anesthetic_checkup->jaundice) && $pre_anesthetic_checkup->jaundice == '(-) ve' ? 'checked' : '' }}>
                                                    (-) ve
                                                    <input type="radio" value="(+) ve" name="jaundice"
                                                        id=""
                                                        {{ isset($pre_anesthetic_checkup->jaundice) && $pre_anesthetic_checkup->jaundice == '(+) ve' ? 'checked' : '' }}>
                                                    (+) ve
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <strong> BP : </strong>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control  " id="bp"
                                                        name="bp"
                                                        value="{{ isset($pre_anesthetic_checkup->bp) ? $pre_anesthetic_checkup->bp : '' }}" />
                                                </td>
                                                <td>
                                                    <strong> Cyanosis : </strong>
                                                </td>
                                                <td>
                                                    <input type="radio" value="(-) ve" name="cyanosis"
                                                        id="cyanosis"
                                                        {{ isset($pre_anesthetic_checkup->cyanosis) && $pre_anesthetic_checkup->cyanosis == '(-) ve' ? 'checked' : '' }}>
                                                    (-) ve
                                                    <input type="radio" value="(+) ve" name="cyanosis"
                                                        id="cyanosis"
                                                        {{ isset($pre_anesthetic_checkup->cyanosis) && $pre_anesthetic_checkup->cyanosis == '(+) ve' ? 'checked' : '' }}>
                                                    (+) ve
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong> Temperature : </strong>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control  " id="temperature"
                                                        name="temperature"
                                                        value="{{ isset($pre_anesthetic_checkup->temperature) ? $pre_anesthetic_checkup->temperature : '' }}" />
                                                </td>
                                                <td>
                                                    <strong> Odema : </strong>
                                                </td>
                                                <td>
                                                    <input type="radio" value="(-) ve" name="oedema"
                                                        id="oedema"
                                                        {{ isset($pre_anesthetic_checkup->oedema) && $pre_anesthetic_checkup->oedema == '(-) ve' ? 'checked' : '' }}>
                                                    (-) ve
                                                    <input type="radio" value="(+) ve" name="oedema"
                                                        id="oedema"
                                                        {{ isset($pre_anesthetic_checkup->oedema) && $pre_anesthetic_checkup->oedema == '(+) ve' ? 'checked' : '' }}>
                                                    (+) ve
                                                </td>

                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong> SPO<sub>2</sub> : </strong>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control  " id="spo2"
                                                        name="spo2"
                                                        value="{{ isset($pre_anesthetic_checkup->spo2) ? $pre_anesthetic_checkup->spo2 : '' }}" />
                                                </td>

                                                <td>
                                                    <strong> Anemia : </strong>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control  " id="anemia"
                                                        name="anemia"
                                                        value="{{ isset($pre_anesthetic_checkup->anemia) ? $pre_anesthetic_checkup->anemia : '' }}" />

                                                </td>

                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong> Systemic Examination : </strong>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control  "
                                                        id="systemic_examination" name="systemic_examination"
                                                        value="{{ isset($pre_anesthetic_checkup->systemic_exam) ? $pre_anesthetic_checkup->systemic_exam : '' }}" />
                                                </td>
                                                <td>
                                                    <strong> Cough : </strong>
                                                </td>
                                                <td>
                                                    <input type="radio" value="(-) ve" name="cough"
                                                        id=""
                                                        {{ isset($pre_anesthetic_checkup->cough) && $pre_anesthetic_checkup->cough == '(-) ve' ? 'checked' : '' }}>
                                                    (-) ve
                                                    <input type="radio" value="(+) ve" name="cough"
                                                        id=""
                                                        {{ isset($pre_anesthetic_checkup->cough) && $pre_anesthetic_checkup->cough == '(+) ve' ? 'checked' : '' }}>
                                                    (+) ve
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong> Central Nervous system : </strong>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control  " id="cns"
                                                        name="cns"
                                                        value="{{ isset($pre_anesthetic_checkup->cns) ? $pre_anesthetic_checkup->cns : '' }}" />
                                                </td>
                                                <td>
                                                    <strong> Others : </strong>
                                                </td>
                                                <td>
                                                    <input type="text" name="clinical_exam_others"
                                                        id="clinical_exam_others" class="form-control"
                                                        value="{{ isset($pre_anesthetic_checkup->clinical_exam_others) ? $pre_anesthetic_checkup->clinical_exam_others : '' }}">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="1">
                                                    <strong> Cardiovascular system : </strong>
                                                </td>
                                                <td colspan="3">
                                                    <input type="text" class="form-control  " id="cvs"
                                                        name="cvs"
                                                        value="{{ isset($pre_anesthetic_checkup->cvs) ? $pre_anesthetic_checkup->cvs : '' }}" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="1">
                                                    <strong> Respiratory System : </strong>
                                                </td>
                                                <td colspan="3">
                                                    <input type="text" class="form-control  "
                                                        id="respiratory_system" name="respiratory_system"
                                                        value="{{ isset($pre_anesthetic_checkup->respiratory_system) ? $pre_anesthetic_checkup->respiratory_system : '' }}" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="1">
                                                    <strong> Others : </strong>
                                                </td>
                                                <td colspan="3">
                                                    <input type="text" class="form-control  " id="others"
                                                        name="others"
                                                        value="{{ isset($pre_anesthetic_checkup->others) ? $pre_anesthetic_checkup->others : '' }}" />
                                                </td>
                                            </tr>

                                        </table>


                                        <h3><strong>Airway Assessment : </strong></h3>
                                        <table width="100%" border="1" style="margin-top:10px">

                                            <tr>
                                                <td colspan="1">
                                                    <strong>Mouth opening > 2 fingers : </strong>
                                                </td>
                                                <td colspan="3">
                                                    {{-- <input type="text" class="form-control  " id="mouth_opening" name="mouth_opening" value="{{ isset($pre_anesthetic_checkup->mouth_opening) ? $pre_anesthetic_checkup->mouth_opening : '' }}" placeholder="Yes or No" /> --}}
                                                    <input type="radio" value="Yes" name="mouth_opening"
                                                        id="mouth_opening1"
                                                        {{ isset($pre_anesthetic_checkup->mouth_opening) && $pre_anesthetic_checkup->mouth_opening == 'Yes' ? 'checked' : '' }}>
                                                    Yes &nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="radio" value="No" name="mouth_opening"
                                                        id="mouth_opening2"
                                                        {{ isset($pre_anesthetic_checkup->mouth_opening) && $pre_anesthetic_checkup->mouth_opening == 'No' ? 'checked' : '' }}>
                                                    No

                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="1">
                                                    <strong>Thyromental distance > 3 fingers: </strong>
                                                </td>
                                                <td colspan="3">
                                                    {{-- <input type="text" class="form-control  " id="thyromental_distance" name="thyromental_distance" value="{{ isset($pre_anesthetic_checkup->thyromental_distance) ? $pre_anesthetic_checkup->thyromental_distance : '' }}" placeholder="Yes or No" /> --}}
                                                    <input type="radio" value="Yes" name="thyromental_distance"
                                                        id="thyromental_distance1"
                                                        {{ isset($pre_anesthetic_checkup->thyromental_distance) && $pre_anesthetic_checkup->thyromental_distance == 'Yes' ? 'checked' : '' }}>
                                                    Yes &nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="radio" value="No" name="thyromental_distance"
                                                        id="thyromental_distance2"
                                                        {{ isset($pre_anesthetic_checkup->thyromental_distance) && $pre_anesthetic_checkup->thyromental_distance == 'No' ? 'checked' : '' }}>
                                                    No

                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="1">
                                                    <strong> Neck Movement- Full/ Restricted: </strong>
                                                </td>
                                                <td colspan="3">
                                                    {{-- <input type="text" class="form-control  " id="full_neck_movement" name="full_neck_movement" value="{{ isset($pre_anesthetic_checkup->full_neck_movement) ? $pre_anesthetic_checkup->full_neck_movement : '' }}" placeholder="Yes or No" /> --}}
                                                    <input type="radio" value="1" name="neck_movement"
                                                        id="neck_movement1"
                                                        {{ isset($pre_anesthetic_checkup->neck_movement) && $pre_anesthetic_checkup->neck_movement == '1' ? 'checked' : '' }}>
                                                    Full &nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="radio" value="2" name="neck_movement"
                                                        id="neck_movement2"
                                                        {{ isset($pre_anesthetic_checkup->neck_movement) && $pre_anesthetic_checkup->neck_movement == '2' ? 'checked' : '' }}>
                                                    Restricted
                                                </td>
                                            </tr>
                                            {{-- <tr>
                                                <td colspan="1">
                                                    <input type="checkbox" class="" id="short_neck" name="short_neck" {{ isset($pre_anesthetic_checkup->short_neck) && $pre_anesthetic_checkup->short_neck == 'Short Neck' ? 'checked' : '' }} value="Short Neck" /> <label for="short_neck"> Short Neck</label>

                                                </td>
                                                <td colspan="2">
                                                    <input type="checkbox" class="" id="neck_swelling" name="neck_swelling" {{ isset($pre_anesthetic_checkup->neck_swelling) && $pre_anesthetic_checkup->neck_swelling == 'Neck Swelling' ? 'checked' : '' }} value="Neck Swelling" /> <label for="neck_swelling">Neck Swelling</label>

                                                </td>
                                            </tr> --}}
                                            <tr>
                                                <td style="">
                                                    <strong> Short Neck</strong> <br>
                                                </td>
                                                <td>
                                                    <label for="short_neck">Yes</label> <input type="radio"
                                                        name="short_neck" id="short_neck" value="1"
                                                        {{ isset($pre_anesthetic_checkup->short_neck) && $pre_anesthetic_checkup->short_neck == '1' ? 'checked' : '' }}>
                                                    &nbsp; &nbsp; &nbsp;
                                                    <label for="short_neck">No</label> <input type="radio"
                                                        name="short_neck" id="short_neck" value="2"
                                                        {{ isset($pre_anesthetic_checkup->short_neck) && $pre_anesthetic_checkup->short_neck == '2' ? 'checked' : '' }}>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="">
                                                    <strong> Neck Swelling</strong> <br>
                                                </td>
                                                <td>
                                                    <label for="neck_swelling">Yes</label> <input type="radio"
                                                        name="neck_swelling" id="neck_swelling" value="1"
                                                        {{ isset($pre_anesthetic_checkup->neck_swelling) && $pre_anesthetic_checkup->neck_swelling == '1' ? 'checked' : '' }}>
                                                    &nbsp; &nbsp; &nbsp;
                                                    <label for="neck_swelling">No</label> <input type="radio"
                                                        name="neck_swelling" id="neck_swelling" value="2"
                                                        {{ isset($pre_anesthetic_checkup->neck_swelling) && $pre_anesthetic_checkup->neck_swelling == '2' ? 'checked' : '' }}>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td style="">
                                                    <strong> Artificial Denture : </strong> <br>
                                                </td>
                                                <td>
                                                    <label for="airway_artificial_denture_1">Yes</label> <input
                                                        type="radio" name="airway_artificial_denture"
                                                        id="airway_artificial_denture_1" value="1"
                                                        {{ isset($pre_anesthetic_checkup->airway_artificial_denture) && $pre_anesthetic_checkup->airway_artificial_denture == '1' ? 'checked' : '' }}>
                                                    &nbsp; &nbsp; &nbsp;
                                                    <label for="airway_artificial_denture_2">No</label> <input
                                                        type="radio" name="airway_artificial_denture"
                                                        id="airway_artificial_denture_2" value="2"
                                                        {{ isset($pre_anesthetic_checkup->airway_artificial_denture) && $pre_anesthetic_checkup->airway_artificial_denture == '2' ? 'checked' : '' }}>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td colspan="1">
                                                    <strong> Mallampati : </strong>
                                                </td>
                                                <td colspan="3">
                                                    <!-- <input type="radio" value="none" name="mallampati_score" id="mallampati_score" {{ isset($pre_anesthetic_checkup->mallampati_score) && $pre_anesthetic_checkup->mallampati_score == 'none' ? 'checked' : '' }}> none &nbsp;&nbsp; -->
                                                    <input type="radio" value="I" name="mallampati_score"
                                                        id="mallampati_score"
                                                        {{ isset($pre_anesthetic_checkup->mallampati_score) && $pre_anesthetic_checkup->mallampati_score == 'I' ? 'checked' : '' }}>
                                                    I &nbsp;&nbsp;
                                                    <input type="radio" value="II" name="mallampati_score"
                                                        id="mallampati_score"
                                                        {{ isset($pre_anesthetic_checkup->mallampati_score) && $pre_anesthetic_checkup->mallampati_score == 'II' ? 'checked' : '' }}>
                                                    II &nbsp;&nbsp;
                                                    <input type="radio" value="III" name="mallampati_score"
                                                        id="mallampati_score"
                                                        {{ isset($pre_anesthetic_checkup->mallampati_score) && $pre_anesthetic_checkup->mallampati_score == 'III' ? 'checked' : '' }}>
                                                    III &nbsp;&nbsp;
                                                    <input type="radio" value="IV" name="mallampati_score"
                                                        id="mallampati_score"
                                                        {{ isset($pre_anesthetic_checkup->mallampati_score) && $pre_anesthetic_checkup->mallampati_score == 'IV' ? 'checked' : '' }}>
                                                    IV
                                                </td>
                                            </tr>

                                        </table>



                                        {{-- <h2>Summary note/ Consideration for attending anesthesiologist:</h2> --}}
                                        <h3> <strong>Consideration for operating room anesthesiologist: </strong></h3>
                                        <table width="100%" border="1" style="margin-top:10px">
                                            <tr>
                                                <td style="">
                                                    <strong> Artificial Denture : </strong> <br>
                                                </td>
                                                <td>
                                                    <label for="coniser_artificial_denture_1">Yes</label> <input
                                                        type="radio" name="coniser_artificial_denture"
                                                        id="coniser_artificial_denture_1" value="1"
                                                        {{ isset($pre_anesthetic_checkup->coniser_artificial_denture) && $pre_anesthetic_checkup->coniser_artificial_denture == '1' ? 'checked' : '' }}>
                                                    &nbsp; &nbsp; &nbsp;
                                                    <label for="coniser_artificial_denture_2">No</label> <input
                                                        type="radio" name="coniser_artificial_denture"
                                                        id="coniser_artificial_denture_2" value="2"
                                                        {{ isset($pre_anesthetic_checkup->coniser_artificial_denture) && $pre_anesthetic_checkup->coniser_artificial_denture == '2' ? 'checked' : '' }}>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td style="">
                                                    <strong> Airway : </strong> <br>
                                                </td>
                                                <td>
                                                    <label for="airway_1">Normal</label> <input type="radio"
                                                        name="airway" id="airway_1" value="1"
                                                        {{ isset($pre_anesthetic_checkup->airway) && $pre_anesthetic_checkup->airway == '1' ? 'checked' : '' }}>
                                                    &nbsp; &nbsp; &nbsp;
                                                    <label for="airway_2">Difficult</label> <input type="radio"
                                                        name="airway" id="airway_2" value="2"
                                                        {{ isset($pre_anesthetic_checkup->airway) && $pre_anesthetic_checkup->airway == '2' ? 'checked' : '' }}>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td colspan="1">
                                                    <strong>Co-Existing Disease </strong>
                                                </td>
                                                <td colspan="3">
                                                    <input type="text" class="form-control" id="co_existing"
                                                        name="co_existing"
                                                        value="{{ isset($pre_anesthetic_checkup->co_existing) ? $pre_anesthetic_checkup->co_existing : '' }}" />

                                                </td>
                                            </tr>

                                            <tr>
                                                <td colspan="1">
                                                    <strong> ASA Class : </strong>
                                                </td>
                                                <td colspan="3">
                                                    <input type="radio" value="1" name="asa_class1"
                                                        id="asa_class1"
                                                        {{ isset($pre_anesthetic_checkup->asa_class1) && $pre_anesthetic_checkup->asa_class1 == '1' ? 'checked' : '' }}>
                                                    1 &nbsp;&nbsp;&nbsp;
                                                    <input type="radio" value="2" name="asa_class1"
                                                        id="asa_class1"
                                                        {{ isset($pre_anesthetic_checkup->asa_class1) && $pre_anesthetic_checkup->asa_class1 == '2' ? 'checked' : '' }}>
                                                    2 &nbsp;&nbsp;&nbsp;
                                                    <input type="radio" value="3" name="asa_class1"
                                                        id="asa_class1"
                                                        {{ isset($pre_anesthetic_checkup->asa_class1) && $pre_anesthetic_checkup->asa_class1 == '3' ? 'checked' : '' }}>
                                                    3 &nbsp;&nbsp;&nbsp;
                                                    <input type="radio" value="4" name="asa_class1"
                                                        id="asa_class1"
                                                        {{ isset($pre_anesthetic_checkup->asa_class1) && $pre_anesthetic_checkup->asa_class1 == '4' ? 'checked' : '' }}>
                                                    4 &nbsp;&nbsp;&nbsp;
                                                    <input type="radio" value="5" name="asa_class1"
                                                        id="asa_class1"
                                                        {{ isset($pre_anesthetic_checkup->asa_class1) && $pre_anesthetic_checkup->asa_class1 == '5' ? 'checked' : '' }}>
                                                    5 &nbsp;&nbsp;&nbsp;
                                                    <input type="radio" value="6" name="asa_class1"
                                                        id="asa_class1"
                                                        {{ isset($pre_anesthetic_checkup->asa_class1) && $pre_anesthetic_checkup->asa_class1 == '6' ? 'checked' : '' }}>
                                                    6 &nbsp;&nbsp;&nbsp;
                                                    <input type="radio" value="1" name="asa_class2"
                                                        id="asa_class2"
                                                        {{ isset($pre_anesthetic_checkup->asa_class2) && $pre_anesthetic_checkup->asa_class2 == '1' ? 'checked' : '' }}>
                                                    E &nbsp;&nbsp;&nbsp;

                                                </td>
                                            </tr>

                                            <tr>
                                                <td colspan="1">
                                                    <strong> NYHA Classification : </strong>
                                                </td>
                                                <td colspan="3">
                                                    <input type="radio" value="I" name="nyha_classification"
                                                        {{ isset($pre_anesthetic_checkup->nyha_classification) && $pre_anesthetic_checkup->nyha_classification == 'I' ? 'checked' : '' }}>
                                                    I &nbsp;&nbsp;
                                                    <input type="radio" value="II" name="nyha_classification"
                                                        {{ isset($pre_anesthetic_checkup->nyha_classification) && $pre_anesthetic_checkup->nyha_classification == 'II' ? 'checked' : '' }}>
                                                    II &nbsp;&nbsp;
                                                    <input type="radio" value="III" name="nyha_classification"
                                                        {{ isset($pre_anesthetic_checkup->nyha_classification) && $pre_anesthetic_checkup->nyha_classification == 'III' ? 'checked' : '' }}>
                                                    III &nbsp;&nbsp;
                                                    <input type="radio" value="IV" name="nyha_classification"
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
                                                    <input type="radio" value="I" name="mallampati_grade"
                                                        {{ isset($pre_anesthetic_checkup->mallampati_grade) && $pre_anesthetic_checkup->mallampati_grade == 'I' ? 'checked' : '' }}>
                                                    I &nbsp;&nbsp;
                                                    <input type="radio" value="II" name="mallampati_grade"
                                                        {{ isset($pre_anesthetic_checkup->mallampati_grade) && $pre_anesthetic_checkup->mallampati_grade == 'II' ? 'checked' : '' }}>
                                                    II &nbsp;&nbsp;
                                                    <input type="radio" value="III" name="mallampati_grade"
                                                        {{ isset($pre_anesthetic_checkup->mallampati_grade) && $pre_anesthetic_checkup->mallampati_grade == 'III' ? 'checked' : '' }}>
                                                    III &nbsp;&nbsp;
                                                    <input type="radio" value="IV" name="mallampati_grade"
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
                                                    <input type="checkbox" value="Spinal" name="tad_spinal"
                                                        id=""
                                                        {{ isset($pre_anesthetic_checkup->tad_spinal) && $pre_anesthetic_checkup->tad_spinal == 'Spinal' ? 'checked' : '' }}>
                                                    Spinal &nbsp;&nbsp;
                                                    <input type="checkbox" value="Epidural" name="tad_epidural"
                                                        id=""
                                                        {{ isset($pre_anesthetic_checkup->tad_epidural) && $pre_anesthetic_checkup->tad_epidural == 'Epidural' ? 'checked' : '' }}>
                                                    Epidural &nbsp;&nbsp;
                                                    <input type="checkbox" value="Nerve Block" name="tad_nerve_block"
                                                        id=""
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
                                                    <input type="checkbox" value="PCEA ? Oral" name="prd_pceaororal"
                                                        id=""
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
                                                    <input type="checkbox" value="Perrectal" name="prd_per_rectal"
                                                        id=""
                                                        {{ isset($pre_anesthetic_checkup->prd_per_rectal) && $pre_anesthetic_checkup->prd_per_rectal == 'Perrectal' ? 'checked' : '' }}>
                                                    Per rectal
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="1">
                                                    <strong> Risk factor( if any) : </strong>
                                                </td>
                                                <td colspan="3">
                                                    <input type="text" name="risk_factor" class="form-control"
                                                        id="risk_factor"
                                                        value="{{ isset($pre_anesthetic_checkup->risk_factor) ? $pre_anesthetic_checkup->risk_factor : '' }}">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="1">
                                                    <strong> Others : </strong>
                                                </td>
                                                <td colspan="3">
                                                    <input type="text" name="remarks" class="form-control"
                                                        id="remarks"
                                                        value="{{ isset($pre_anesthetic_checkup->remarks) ? $pre_anesthetic_checkup->remarks : '' }}">
                                                </td>
                                            </tr>
                                        </table>


                                        <table width="100%" border="1" style="margin-top:10px">
                                            <tr>
                                                <td colspan="2">
                                                    <strong>Pre Operative Instruction</strong>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <strong>1.</strong><br>
                                                    NPO- <input type="text" class="" id="pre_operative_ins1"
                                                        name="pre_operative_ins1"
                                                        value="{{ isset($pre_anesthetic_checkup->pre_operative_ins1) ? $pre_anesthetic_checkup->pre_operative_ins1 : '' }}" />
                                                    hours before operation.
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <strong>2. Drugs / Premedication</strong>

                                                </td>
                                            </tr>
                                            {{-- <tr>
                                                <td colspan="2">
                                                    <strong>2. Drugs / Premedication</strong>
                                                    <input type="text" class="form-control" id="pre_operative_ins2" name="pre_operative_ins2" value="{{ isset($pre_anesthetic_checkup->pre_operative_ins2) ? $pre_anesthetic_checkup->pre_operative_ins2 : '' }}" />
                                                </td>
                                            </tr> --}}
                                            @php
                                                $pre_operative_ins2 = isset($pre_anesthetic_checkup->pre_operative_ins2)
                                                    ? $pre_anesthetic_checkup->pre_operative_ins2
                                                    : '';
                                            @endphp
                                            <td colspan="3">
                                                <input type="hidden" name="pre_operative_ins2" id="editor_content3"
                                                    value="{{ $pre_operative_ins2 }}">
                                                <textarea id="editor3" class="ckeditor" style="height: 60vh" class="form-control form-control">
                                             <?php echo $pre_operative_ins2; ?>
                                             </textarea>
                                            </td>
                                            <tr>
                                                <td colspan="2">
                                                    <strong>3. Blood Donor Standby (cross-matched)</strong>
                                                    <input type="text" class="form-control"
                                                        id="blood_doner_standby" name="blood_doner_standby"
                                                        value="{{ isset($pre_anesthetic_checkup->blood_doner_standby) ? $pre_anesthetic_checkup->blood_doner_standby : '' }}" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong>4. Blood for Operation : </strong><br>
                                                    {{-- <input type="text" class="form-control" id="pre_operative_ins4" name="pre_operative_ins4" value="{{ isset($pre_anesthetic_checkup->pre_operative_ins4) ? $pre_anesthetic_checkup->pre_operative_ins4 : '' }}" /> --}}
                                                </td>
                                                <td>
                                                    <span style="margin-left: 09px;">Whole Blood : &nbsp; &nbsp; &nbsp;
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                                            type="text" class="" name="whole_blood"
                                                            id="whole_blood"
                                                            value="{{ isset($pre_anesthetic_checkup->whole_blood) ? $pre_anesthetic_checkup->whole_blood : '' }}">
                                                        Unit </span> <br>
                                                    <span>Packed Red Blood : &nbsp; &nbsp; &nbsp; <input type="text"
                                                            class="" name="red_blood" id="red_blood"
                                                            value="{{ isset($pre_anesthetic_checkup->red_blood) ? $pre_anesthetic_checkup->red_blood : '' }}">
                                                        Unit</span> <br>
                                                    <span>Fresh Frosen Plasma : &nbsp;<input type="text"
                                                            class="" name="fresh_frosen_plasma"
                                                            id="fresh_frosen_plasma"
                                                            value="{{ isset($pre_anesthetic_checkup->fresh_frosen_plasma) ? $pre_anesthetic_checkup->fresh_frosen_plasma : '' }}">
                                                        Unit</span>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td colspan="2">
                                                    <strong>Further Advice</strong>

                                                </td>
                                            </tr>
                                            @php
                                                $post_operative_order = isset($pre_anesthetic_checkup->special_note1)
                                                    ? $pre_anesthetic_checkup->special_note1
                                                    : '';
                                            @endphp
                                            <td colspan="3">
                                                <input type="hidden" name="special_note1" id="editor_content2"
                                                    value="{{ $post_operative_order }}">
                                                <textarea id="editor2" name="post_operative_order" class="ckeditor" style="height: 60vh"
                                                    class="form-control form-control">
                                             <?php echo $post_operative_order; ?>
                                             </textarea>
                                            </td>

                                        </table>
                                        <table width="100%" border="1" style="margin-top:10px">
                                            <tr>
                                                <td colspan="3" class="text-center">
                                                    <input type="checkbox" name="accepted_for_opn_under"
                                                        id="accepted_for_opn_under"
                                                        value="Accepted for operation Under"
                                                        {{ isset($pre_anesthetic_checkup->accepted_for_opn_under) && $pre_anesthetic_checkup->accepted_for_opn_under == 'Accepted for operation Under' ? 'checked' : '' }}>
                                                    Accepted for operation Under
                                                </td>

                                                {{-- <td colspan="3" class="text-center">
                                                    <input type="checkbox" name="revwfor_opn_under" id="revwfor_opn_under" value="Review for Operation Under" {{isset($pre_anesthetic_checkup->revwfor_opn_under) && $pre_anesthetic_checkup->revwfor_opn_under =="Review for Operation Under" ? 'checked' : ''}}> Review for Operation Under
                                                </td> --}}

                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="ga" id="ga"
                                                        value="GA"
                                                        {{ isset($pre_anesthetic_checkup->ga) && $pre_anesthetic_checkup->ga == 'GA' ? 'checked' : '' }}>
                                                    GA
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="ra" id="ra"
                                                        value="RA"
                                                        {{ isset($pre_anesthetic_checkup->ra) && $pre_anesthetic_checkup->ra == 'RA' ? 'checked' : '' }}>
                                                    RA
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="monitored_care" id="monitored_care"
                                                        value="Monitored Care"
                                                        {{ isset($pre_anesthetic_checkup->monitored_care) && $pre_anesthetic_checkup->monitored_care == 'Monitored Care' ? 'checked' : '' }}>
                                                    Monitored Care
                                                </td>

                                            </tr>
                                        </table>
                                        <table width="100%" border="1" style="margin-top:10px">
                                            <tr>
                                                <td colspan="" class="">
                                                    <label for="Anesthetist_name"
                                                        class="col-form-label col-form-label-sm">Anesthesiologist
                                                    </label>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="Anesthetist_name" name="Anesthetist_name"
                                                        placeholder="Dr. Name"
                                                        value="{{ isset($pre_anesthetic_checkup->full_name) ? $pre_anesthetic_checkup->full_name : '' }}" />
                                                    <input type="hidden" name="Anesthetist_no_fk"
                                                        id="Anesthetist_no_fk"
                                                        value="{{ isset($pre_anesthetic_checkup->anesthetist_id_fk) ? $pre_anesthetic_checkup->anesthetist_id_fk : '' }}">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="" class="">
                                                    <label for="record_date"
                                                        class="col-form-label col-form-label-sm">Date </label>
                                                    <input type="text"
                                                        class="form-control form-control-sm date_picker"
                                                        id="record_date" name="record_date" placeholder=""
                                                        value="{{ isset($pre_anesthetic_checkup->record_date) ? date('d-m-Y', strtotime($pre_anesthetic_checkup->record_date)) : '' }}" />
                                                </td>
                                            </tr>

                                        </table>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    @php
                        $redirect_url = route('ipd.pre-anesthetic-checkup-form', $pat_info->admission_no_pk);
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
    openDoctorAutocomplete('#Anesthetist_name', 'Anesthetist_no_fk', 'doctor_ind', '1,2');
    openDoctorAutocomplete('#preinduction_assessment_Anesthetist', 'preinduction_assessment_Anesthetist_no_fk',
        'doctor_ind', '1,2');
    openDoctorAutocomplete('#previous_anesthesia_name', 'hdn_previous_anesthesia_id', 'doctor_ind', '1,2');

    openDoctorAutocomplete('#assistant_surgeon_name', 'assistant_surgeon_no_fk', 'doctor_ind', '1,2');
    openDoctorAutocomplete('#assistant_2_surgeon_name', 'assistant_2_surgeon_no_fk', 'doctor_ind', '1,2');
    openDoctorAutocomplete('#assistant_3_surgeon_name', 'assistant_3_surgeon_no_fk', 'doctor_ind', '1,2');
    openDoctorAutocomplete('#assistant_4_surgeon_name', 'assistant_4_surgeon_no_fk', 'doctor_ind', '1,2');

    openDoctorAutocomplete('#anesthesiologist_name', 'anesthesiologist_no_fk', 'doctor_ind', '1,2');
    openDoctorAutocomplete('#assistant_anesthesiologist_name', 'assistant_anesthesiologist_no_fk', 'doctor_ind', '1,2');
    openDoctorAutocomplete('#assistant_2_anesthesiologist_name', 'assistant_2_anesthesiologist_no_fk', 'doctor_ind',
        '1,2');

    openDoctorAutocomplete('#scrub_nurse', 'scrub_nurse_no_fk');

    $(function() {
        $('.date_picker').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            // endDate: '+0d',
            'format': 'dd-mm-yyyy'
        });
        $('.timepicker').timepicker({
            // showInputs: false,
            // showMeridian: false,
            // setTime: null

        });

    });


    var editor2 = CKEDITOR.replace('editor2', {
        tabSpaces: 4
    });
    editor2.on('change', function(evt) {
        $('#editor_content2').val(evt.editor.getData())
    });

    var editor3 = CKEDITOR.replace('editor3', {
        tabSpaces: 4
    });
    editor3.on('change', function(evt) {
        $('#editor_content3').val(evt.editor.getData())
    });
</script>

<script>
    function HeightCalculate() {
        let height_to_meter = $("#height").val() != "" ? parseFloat($("#height").val()) * 0.01 : 0;
        let weight = $('#weight').val();
        let bmi = weight != "" ? weight / (height_to_meter * height_to_meter) : 0;
        $('#bmi').val(bmi.toFixed(1));
    }

    function WeightCalculate() {
        let height_to_meter = $("#height").val() != "" ? parseFloat($("#height").val()) * 0.01 : 0;
        let weight = $('#weight').val();
        let bmi = weight != "" ? weight / (height_to_meter * height_to_meter) : 0;
        $('#bmi').val(bmi.toFixed(1));
    }
</script>
