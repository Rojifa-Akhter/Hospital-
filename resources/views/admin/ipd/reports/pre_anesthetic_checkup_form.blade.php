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

        <div class="anaesthetic__form">
            <form action="{{ route('pre-anesthetic-checkup-store') }}" method="post" id="PREANESTHETICCHECKUP">
                @csrf
                <input type="hidden" name="admission_id"
                    value="{{ isset($pat_info->admission_no_pk) ? $pat_info->admission_no_pk : '' }}">
                <input type="hidden" name="ref_no" value="{{ isset($ref_no) ? $ref_no : '' }}">
                <input type="hidden" name="pat_id"
                    value="{{ isset($pat_info->patient_no_fk) ? $pat_info->patient_no_fk : '' }}">
                <input type="hidden" name="pre_anesthetics_checkup_no_pk"
                    value="{{ isset($pre_anesthetic_checkup->pre_anesthetics_checkup_no_pk) ? $pre_anesthetic_checkup->pre_anesthetics_checkup_no_pk : '' }}">
                <div class="">

                    <div class="form-row">
                        <div class="col-md-12">
                            <div class="card">
                                <!-- 1st card body -->
                                <div class="card-header text-center">
                                    <h2 class="card-title mb-0 text-left"> <strong> Patient Info</strong></h2>
                                </div>
                                <div class="card-body p-3">
                                    <div class="form-row" style="border: 1px solid #298949; padding: 10px;">

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="regNo" class="col-form-label col-form-label-sm">UHID
                                                </label>
                                                <input type="text" class="form-control form-control-sm"
                                                    id="regNo" name="regNo"
                                                    value="{{ isset($pat_info->patient_code) ? $pat_info->patient_code : '' }}"
                                                    placeholder="" readonly />
                                            </div>
                                        </div>


                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="ippt" class="col-form-label col-form-label-sm">
                                                    IP No</label>
                                                <input type="text" class="form-control form-control-sm" readonly
                                                    id="ippt" name="ippt"
                                                    value="{{ isset($pat_info->admission_uid) ? $pat_info->admission_uid : '' }}"
                                                    placeholder="ip no" />
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="nameOfpt" class="col-form-label col-form-label-sm">
                                                    Patient Name</label>
                                                <input type="text" class="form-control form-control-sm" readonly
                                                    id="nameOfpt" name="nameOfpt"
                                                    value="{{ isset($pat_info->patient_name) ? $pat_info->patient_name : '' }}"
                                                    placeholder="Name Of pt" />
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
                                                    class="col-form-label col-form-label-sm">Cabin</label>
                                                <input type="text" class="form-control form-control-sm"
                                                    id="ptWard" name="ptWard"
                                                    value="{{ isset($pat_info->new_ward_name) ? $pat_info->new_ward_name : '' }}"
                                                    placeholder="" readonly />
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="ptBed" class="col-form-label col-form-label-sm">Bed
                                                    Category</label>
                                                <input type="text" class="form-control form-control-sm"
                                                    id="ptBed" name="ptBed"
                                                    value="{{ isset($pat_info->new_bed_name) ? $pat_info->new_bed_name : '' }}"
                                                    placeholder="" readonly />
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="date"
                                                    class="col-form-label col-form-label-sm">Admission Date</label>
                                                <input type="text" class="form-control form-control-sm"
                                                    id="date" name="date"
                                                    value="{{ isset($pat_info->admission_date) ? date('Y-m-d', strtotime($pat_info->admission_date)) : date('Y-m-d') }}"
                                                    placeholder="YYYY-mm-dd" readonly tabindex="-1" />
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="ptBed"
                                                    class="col-form-label col-form-label-sm">Consultant</label>
                                                <input type="text" class="form-control form-control-sm"
                                                    id="doctor_name" name="doctor_name" placeholder="Dr. Name"
                                                    value="{{ isset($pre_anesthetic_checkup->doctor_name) ? $pre_anesthetic_checkup->doctor_name : '' }}" />
                                                <input type="hidden" name="hdn_doctor_id" id="hdn_doctor_id"
                                                    value="{{ isset($pre_anesthetic_checkup->doctor_no_fk) ? $pre_anesthetic_checkup->doctor_no_fk : '' }}">
                                            </div>
                                        </div>
                                        <table width="100%" border="1" style="margin-top:10px">
                                            <tr>
                                                <td>
                                                    <strong> Height (cm): </strong>
                                                    <input type="number" class="form-control form-control"
                                                        id="height" name="height"
                                                        value="{{ isset($pre_anesthetic_checkup->height) ? $pre_anesthetic_checkup->height : '' }}"
                                                        placeholder="cm" oninput="calculateBMI()" />
                                                </td>
                                                <td>
                                                    <strong> Weight (kg): </strong>
                                                    <input type="number" class="form-control form-control"
                                                        id="weight" name="weight"
                                                        value="{{ isset($pre_anesthetic_checkup->weight) ? $pre_anesthetic_checkup->weight : '' }}"
                                                        placeholder="Kg" oninput="calculateBMI()" />
                                                </td>
                                                <td>
                                                    <strong> BMI : </strong>
                                                    <input type="text" class="form-control form-control"
                                                        id="bmi" name="bmi"
                                                        value="{{ isset($pre_anesthetic_checkup->bmi) ? $pre_anesthetic_checkup->bmi : '' }}"
                                                        placeholder="Kg/m2" readonly />
                                                </td>
                                                <td>
                                                    <strong>Blood Group</strong>

                                                    <input type="text" class="form-control form-control-sm"
                                                        id="ptBlood" name="ptBlood"
                                                        value="{{ isset($pat_info->blood_group_text) && !empty($pat_info->blood_group_text) ? $pat_info->blood_group_text : (isset($pre_anesthetic_checkup->blood) ? $pre_anesthetic_checkup->blood : '') }}"
                                                        placeholder="Enter blood group"
                                                        @if (isset($pat_info->blood_group_text) && !empty($pat_info->blood_group_text)) readonly @endif />
                                                </td>

                                            </tr>
                                            <tr>

                                                <td style="">
                                                    <strong> Smoker : </strong> <br>
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
                                                <td>
                                                    <strong> Artificial Denture : </strong> <br>
                                                    <label for="artificial_1">Yes</label> <input type="radio"
                                                        name="artificial" id="artificial_1" value="Yes"
                                                        {{ isset($pre_anesthetic_checkup->airway_artificial_denture) && $pre_anesthetic_checkup->airway_artificial_denture == 'Yes' ? 'checked' : '' }}>
                                                    <label for="artificial_2">No</label> <input type="radio"
                                                        name="artificial" id="artificial_2" value="No"
                                                        {{ isset($pre_anesthetic_checkup->airway_artificial_denture) && $pre_anesthetic_checkup->airway_artificial_denture == 'No' ? 'checked' : '' }}>

                                                </td>

                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <!-- 1st card body -->
                                <!-- 2nd card body -->



                                <div class="card-body p-3">
                                    <div class="">
                                        <table width="100%" border="1">
                                            <tr>
                                                <td style="width: 250px"><strong>Preoperative Diagnosis</strong></td>
                                                <td> <input type="text" class="form-control form-control  "
                                                        id="Preoperative_Diagnosis" name="Preoperative_Diagnosis"
                                                        value="{{ isset($ot_info->diagnosis) ? $ot_info->diagnosis : '' }}"
                                                        readonly />
                                                </td>
                                                <td style="width: 250px"><strong>Proposed Surgery</strong></td>
                                                <td> <input type="text" class="form-control form-control  "
                                                        id="pro_surgery" name="pro_surgery" value="{{ isset($pre_anesthetic_checkup->pro_surgery) ? $pre_anesthetic_checkup->pro_surgery : '' }}" />
                                                </td>
                                            </tr>

                                            <tr>
                                                <td style="width: 250px"><strong>Date of Surgery</strong></td>
                                                <td>

                                                    <input type="text" class="form-control form-control-sm"
                                                        name="scheduled_for_surgery"
                                                        value="{{ isset($ot_info->reff_date) ? date('d-m-Y', strtotime($ot_info->reff_date)) : '' }}"
                                                        readonly />
                                                </td>
                                                <td style="width: 250px"> <strong>Surgery</strong></td>
                                                <td>
                                                    {{ isset($ot_info->urgency_details) ? $ot_info->urgency_details : '' }}
                                                </td>
                                            </tr>


                                        </table>


                                        <table width="100%" border="1" style="margin-top:10px">

                                            <tr>
                                                <td colspan="1" style="width: 300px;">
                                                    <strong>Previous Anesthesia Complication (if any)</strong>
                                                </td>
                                                <td>

                                                    <input type="text" class="form-control form-control-sm"
                                                        id="previous_anesthesia_and_complication"
                                                        name="previous_anesthesia_and_complication"
                                                        value="{{ isset($pre_anesthetic_checkup->pre_anes_and_comp) ? $pre_anesthetic_checkup->pre_anes_and_comp : '' }}"
                                                        placeholder="" />
                                                </td>
                                            </tr>
                                        </table>






                                        <br>
                                        <h4><u>Co-existing disease with duration :</u></h4>
                                        <table width="100%" border="1" style="margin-top:10px">
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
                                                    <strong> Myocardial Infarction: </strong> <input type="text"
                                                        class="form-control form-control  " id="myocardial"
                                                        name="myocardial"
                                                        value="{{ isset($pre_anesthetic_checkup->myocardial) ? $pre_anesthetic_checkup->myocardial : '' }}"
                                                        placeholder="" />
                                                </td>
                                                <td style="">
                                                    <strong> Bronchial Asthma/COPD : </strong> <input type="text"
                                                        class="form-control form-control  " id="asthma"
                                                        name="asthma"
                                                        value="{{ isset($pre_anesthetic_checkup->asthma) ? $pre_anesthetic_checkup->asthma : '' }}"
                                                        placeholder="" />
                                                </td>
                                                <td style="">
                                                    <strong>Diabetes:</strong>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="diabetes" name="diabetes"
                                                        value="{{ isset($pre_anesthetic_checkup->diabetes) ? $pre_anesthetic_checkup->diabetes : '' }}"
                                                        placeholder="" />
                                                </td>
                                                <td style="">
                                                    <strong>Thyroid disorder:</strong>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="thyroid_disorder" name="thyroid_disorder"
                                                        value="{{ isset($pre_anesthetic_checkup->thyroid_disorder) ? $pre_anesthetic_checkup->thyroid_disorder : '' }}"
                                                        placeholder="" />
                                                </td>

                                            </tr>

                                            <tr>

                                                <td style="">


                                                    <label for="pre_cough_1">Dyspnea</label> <input type="radio"
                                                        name="pre_cough" id="pre_cough_1" value="Dyspnea"
                                                        {{ isset($pre_anesthetic_checkup->pre_cough) && $pre_anesthetic_checkup->pre_cough == 'Dyspnea' ? 'checked' : '' }}>
                                                    <label for="pre_cough_2">Cough</label> <input type="radio"
                                                        name="pre_cough" id="pre_cough_2" value="Cough"
                                                        {{ isset($pre_anesthetic_checkup->pre_cough) && $pre_anesthetic_checkup->pre_cough == 'Cough' ? 'checked' : '' }}>
                                                </td>

                                                <td style="">
                                                    <strong> Chest Pain: </strong> <input type="text"
                                                        class="form-control form-control  " id="chestpain"
                                                        name="chestpain"
                                                        value="{{ isset($pre_anesthetic_checkup->chestpain) ? $pre_anesthetic_checkup->chestpain : '' }}"
                                                        placeholder="" />
                                                </td>
                                                <td colspan="4">
                                                    <strong>Others:</strong>
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



                                        <br>
                                        <h4><u>Investigations</u></h4>
                                        <table width="100%" border="1" style="margin-top:10px">
                                            <tr>
                                                <br>
                                                <h4>CBC-</h4>
                                                <td>
                                                    <div class="d-flex align-items-center" style="gap: 5px;">
                                                        <strong>HB</strong>
                                                        <input type="text" class="form-control" id="hb_pcv"
                                                            name="hb_pcv" style="width: 100px;"
                                                            value="{{ isset($pre_anesthetic_checkup->hb_pcv) ? $pre_anesthetic_checkup->hb_pcv : '' }}" />
                                                        <span>gm/dl</span>
                                                    </div>



                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center" style="gap: 5px;">
                                                        <strong> PCV</strong>
                                                        <input type="text" class="form-control" id="pcv"
                                                            name="pcv" style="width: 100px;"
                                                            value="{{ isset($pre_anesthetic_checkup->pcv) ? $pre_anesthetic_checkup->pcv : '' }}" />
                                                        <span>L/L</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center" style="gap: 5px;">

                                                        <strong> TC</strong>
                                                        <input type="text" class="form-control" id="tc"
                                                            name="tc" style="width: 100px;"
                                                            value="{{ isset($pre_anesthetic_checkup->tc) ? $pre_anesthetic_checkup->tc : '' }}" />
                                                        <span>10<sup>9</sup>/L</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center" style="gap: 5px;">
                                                        <strong> Platelet </strong>
                                                        <input type="text" class="form-control"
                                                            id="platelet_count" name="platelet_count"
                                                            style="width: 100px;"
                                                            value="{{ isset($pre_anesthetic_checkup->platelet_count) ? $pre_anesthetic_checkup->platelet_count : '' }}" />
                                                        <span>10<sup>9</sup>/L</span>
                                                    </div>
                                                </td>


                                            </tr>

                                        </table>


                                        <table width="100%" border="1" style="margin-top:10px">

                                            <tr>
                                                <br>
                                                <h4>Blood Sugar-</h4>
                                                <td>
                                                    <div class="d-flex align-items-center" style="gap: 5px;">
                                                        <strong>FBS</strong>
                                                        <input type="text" class="form-control" id="fbs_rbs"
                                                            name="fbs_rbs" style="width: 100px;"
                                                            value="{{ isset($pre_anesthetic_checkup->fbs_rbs) ? $pre_anesthetic_checkup->fbs_rbs : '' }}" />
                                                        <span>mmol/L</span>
                                                    </div>
                                                </td>

                                                <td>
                                                    <div class="d-flex align-items-center" style="gap: 5px;">
                                                        <strong>RBS</strong>
                                                        <input type="text" class="form-control" id="rbs"
                                                            name="rbs" style="width: 100px;"
                                                            value="{{ isset($pre_anesthetic_checkup->rbs) ? $pre_anesthetic_checkup->rbs : '' }}" />
                                                        <span>mmol/L</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center" style="gap: 5px;">
                                                        <strong>HbA1C</strong>
                                                        <input type="text" class="form-control" id="hba1c"
                                                            name="hba1c" style="width: 100px;"
                                                            value="{{ isset($pre_anesthetic_checkup->hba1c) ? $pre_anesthetic_checkup->hba1c : '' }}" />
                                                        <span>%</span>
                                                    </div>
                                                </td>


                                                <td>
                                                    <div class="d-flex align-items-center" style="gap: 5px;">
                                                        <strong>S. Creat.</strong>
                                                        <input type="text" class="form-control" id="screatinine"
                                                            name="screatinine" style="width: 100px;"
                                                            value="{{ isset($pre_anesthetic_checkup->screatinine) ? $pre_anesthetic_checkup->screatinine : '' }}" />
                                                        <span>mg/dl</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center" style="gap: 5px;">
                                                        <strong>Bl. Urea</strong>
                                                        <input type="text" class="form-control" id="urea"
                                                            name="urea" style="width: 100px;"
                                                            value="{{ isset($pre_anesthetic_checkup->urea) ? $pre_anesthetic_checkup->urea : '' }}" />
                                                        <span>mg/dl</span>
                                                    </div>
                                                </td>


                                            </tr>


                                        </table>

                                        <table width="100%" border="1" style="margin-top:10px">

                                            <br>
                                            <h4>Electrolyte-</h4>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center" style="gap: 5px;">
                                                        <strong>Na</strong>
                                                        <input type="text" class="form-control" id="na"
                                                            name="na" style="width: 100px;"
                                                            value="{{ isset($pre_anesthetic_checkup->na) ? $pre_anesthetic_checkup->na : '' }}" />
                                                        <span>mmol/L</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center" style="gap: 5px;">
                                                        <strong>K</strong>
                                                        <input type="text" class="form-control" id="k"
                                                            name="k" style="width: 100px;"
                                                            value="{{ isset($pre_anesthetic_checkup->k) ? $pre_anesthetic_checkup->k : '' }}" />
                                                        <span>mmol/L</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center" style="gap: 5px;">
                                                        <strong>CL</strong>
                                                        <input type="text" class="form-control" id="cl"
                                                            name="cl" style="width: 100px;"
                                                            value="{{ isset($pre_anesthetic_checkup->cl) ? $pre_anesthetic_checkup->cl : '' }}" />
                                                        <span>mmol/L</span>
                                                    </div>
                                                </td>

                                                <td>
                                                    <div class="d-flex align-items-center" style="gap: 5px;">
                                                        <strong>Ca</strong>
                                                        <input type="text" class="form-control" id="ca"
                                                            name="ca" style="width: 100px;"
                                                            value="{{ isset($pre_anesthetic_checkup->ca) ? $pre_anesthetic_checkup->ca : '' }}" />
                                                        <span>mmol/L</span>
                                                    </div>
                                                </td>


                                            </tr>





                                        </table>



                                        <table width="100%" border="1" style="margin-top:10px">

                                            <br>
                                            <h4>Coagulation-</h4>

                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center" style="gap: 5px;">
                                                        <strong>PT</strong>
                                                        <input type="text" class="form-control" id="pt"
                                                            name="pt" style="width: 100px;"
                                                            value="{{ isset($pre_anesthetic_checkup->pt) ? $pre_anesthetic_checkup->pt : '' }}" />
                                                        <span>Sec</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center" style="gap: 5px;">
                                                        <strong>APTT</strong>
                                                        <input type="text" class="form-control" id="aptt"
                                                            name="aptt" style="width: 100px;"
                                                            value="{{ isset($pre_anesthetic_checkup->aptt) ? $pre_anesthetic_checkup->aptt : '' }}" />
                                                        <span>Sec</span>
                                                    </div>
                                                </td>

                                                <td>
                                                    <div class="d-flex align-items-center" style="gap: 5px;">
                                                        <strong>INR</strong>
                                                        <input type="text" class="form-control" id="inr"
                                                            name="inr" style="width: 100px;"
                                                            value="{{ isset($pre_anesthetic_checkup->inr) ? $pre_anesthetic_checkup->inr : '' }}" />
                                                        <span>Sec</span>
                                                    </div>
                                                </td>

                                                <td>
                                                    <div class="d-flex align-items-center" style="gap: 5px;">
                                                        <strong>BT</strong>
                                                        <input type="text" class="form-control" id="bt"
                                                            name="bt" style="width: 100px;"
                                                            value="{{ isset($pre_anesthetic_checkup->bt) ? $pre_anesthetic_checkup->bt : '' }}" />
                                                        <span> min & Sec</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center" style="gap: 5px;">
                                                        <strong>CT</strong>
                                                        <input type="text" class="form-control" id="ct"
                                                            name="ct" style="width: 100px;"
                                                            value="{{ isset($pre_anesthetic_checkup->ct) ? $pre_anesthetic_checkup->ct : '' }}" />
                                                        <span> min & Sec</span>
                                                    </div>
                                                </td>


                                            </tr>





                                        </table>



                                        <table width="100%" border="1" style="margin-top:10px">

                                            <br>
                                            <h4>ABG-</h4>


                                            <tr>
                                                <td>
                                                    <strong>pH</strong>
                                                    <input type="text" class="form-control" id="ph"
                                                        name="ph"
                                                        value="{{ isset($pre_anesthetic_checkup->ph) ? $pre_anesthetic_checkup->ph : '' }}" />
                                                </td>
                                                <td>
                                                    <strong>PaO <sub>2</sub></strong>
                                                    <input type="text" class="form-control" id="pao2"
                                                        name="pao2"
                                                        value="{{ isset($pre_anesthetic_checkup->pao2) ? $pre_anesthetic_checkup->pao2 : '' }}" />
                                                </td>
                                                <td>
                                                    <strong>PaCO <sub>2</sub></strong>
                                                    <input type="text" class="form-control" id="paco2"
                                                        name="paco2"
                                                        value="{{ isset($pre_anesthetic_checkup->paco2) ? $pre_anesthetic_checkup->paco2 : '' }}" />
                                                </td>
                                                <td>
                                                    <strong>HCO</strong> <sub>3</sub>
                                                    <input type="text" class="form-control" id="hco3"
                                                        name="hco3"
                                                        value="{{ isset($pre_anesthetic_checkup->hco3) ? $pre_anesthetic_checkup->hco3 : '' }}" />
                                                </td>
                                                <td>
                                                    <strong>BE</strong>
                                                    <input type="text" class="form-control" id="be"
                                                        name="be"
                                                        value="{{ isset($pre_anesthetic_checkup->be) ? $pre_anesthetic_checkup->be : '' }}" />
                                                </td>
                                            </tr>

                                            <tr>
                                                <td colspan="2">
                                                    <div class="d-flex align-items-center" style="gap: 5px;">
                                                        <strong> HbsAg</strong>
                                                        <input type="text" class="form-control" id="hbsag"
                                                            name="hbsag" style="width: 100px;"
                                                            value="{{ isset($pre_anesthetic_checkup->hbsag) ? $pre_anesthetic_checkup->hbsag : '' }}" />
                                                        <span>+/-</span>
                                                    </div>

                                                </td>
                                                <td colspan="2">
                                                    <div class="d-flex align-items-center" style="gap: 5px;">
                                                        <strong> HCB</strong>
                                                        <input type="text" class="form-control" id="hcv"
                                                            name="hcv" style="width: 100px;"
                                                            value="{{ isset($pre_anesthetic_checkup->hcv) ? $pre_anesthetic_checkup->hcv : '' }}" />
                                                        <span>+/-</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center" style="gap: 5px;">
                                                        <strong>HIV</strong>
                                                        <input type="text" class="form-control" id="hiv"
                                                            name="hiv" style="width: 100px;"
                                                            value="{{ isset($pre_anesthetic_checkup->hiv) ? $pre_anesthetic_checkup->hiv : '' }}" />
                                                        <span>+/-</span>
                                                    </div>
                                                </td>
                                            </tr>





                                        </table>



                                        <table width="100%" border="1" style="margin-top:10px">

                                            <br>
                                            <h4>TFT-</h4>

                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center" style="gap: 5px;">
                                                        <strong>T3</strong>
                                                        <input type="text" class="form-control" id="T3_t4"
                                                            name="T3_t4" style="width: 100px;"
                                                            value="{{ isset($pre_anesthetic_checkup->t3_t4) ? $pre_anesthetic_checkup->t3_t4 : '' }}" />
                                                        <span>ng/dL</span>
                                                    </div>
                                                </td>

                                                <td>
                                                    <div class="d-flex align-items-center" style="gap: 5px;">
                                                        <strong>T4</strong>
                                                        <input type="text" class="form-control" id="t4"
                                                            name="t4" style="width: 100px;"
                                                            value="{{ isset($pre_anesthetic_checkup->t4) ? $pre_anesthetic_checkup->t4 : '' }}" />
                                                        <span>μg/dL</span>
                                                    </div>
                                                </td>


                                                <td>
                                                    <div class="d-flex align-items-center" style="gap: 5px;">
                                                        <strong>TSH</strong>
                                                        <input type="text" class="form-control" id="tsh"
                                                            name="tsh" style="width: 100px;"
                                                            value="{{ isset($pre_anesthetic_checkup->tsh) ? $pre_anesthetic_checkup->tsh : '' }}" />
                                                        <span>μIU/mL</span>
                                                    </div>
                                                </td>


                                            </tr>





                                        </table>

                                        <table width="100%" border="1" style="margin-top:10px">

                                            <br>
                                            <h4>LFT-</h4>

                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center" style="gap: 5px;">
                                                        <strong>ALT</strong>
                                                        <input type="text" class="form-control" id="alt"
                                                            name="alt" style="width: 100px;"
                                                            value="{{ isset($pre_anesthetic_checkup->alt) ? $pre_anesthetic_checkup->alt : '' }}" />
                                                        <span>U/L</span>
                                                    </div>

                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center" style="gap: 5px;">
                                                        <strong>AST</strong>
                                                        <input type="text" class="form-control" id="ast"
                                                            name="ast" style="width: 100px;"
                                                            value="{{ isset($pre_anesthetic_checkup->ast) ? $pre_anesthetic_checkup->ast : '' }}" />
                                                        <span>U/L</span>
                                                    </div>
                                                </td>


                                                <td>
                                                    <div class="d-flex align-items-center" style="gap: 5px;">
                                                        <strong>ALK PH</strong>
                                                        <input type="text" class="form-control" id="alkph"
                                                            name="alkph" style="width: 100px;"
                                                            value="{{ isset($pre_anesthetic_checkup->alkph) ? $pre_anesthetic_checkup->alkph : '' }}" />
                                                        <span>U/L</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center" style="gap: 5px;">
                                                        <strong>T.Bilirubin</strong>
                                                        <input type="text" class="form-control" id="bilirubin"
                                                            name="bilirubin" style="width: 100px;"
                                                            value="{{ isset($pre_anesthetic_checkup->sbilirubin) ? $pre_anesthetic_checkup->sbilirubin : '' }}" />
                                                        <span>mg/dL</span>
                                                    </div>
                                                </td>

                                            </tr>





                                        </table>


                                        <table width="100%" border="1" style="margin-top:10px">

                                            <br>
                                            <h4>Protein-</h4>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center" style="gap: 5px;">
                                                        <strong>T. Protein</strong>
                                                        <input type="text" class="form-control"
                                                            id="artificial_denture" name="artificial_denture"
                                                            style="width: 100px;"
                                                            value="{{ isset($pre_anesthetic_checkup->artificial_denture) ? $pre_anesthetic_checkup->artificial_denture : '' }}" />
                                                        <span>g/dL</span>
                                                    </div>

                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center" style="gap: 5px;">
                                                        <strong>Ab</strong>
                                                        <input type="text" class="form-control" id="ab"
                                                            name="ab" style="width: 100px;"
                                                            value="{{ isset($pre_anesthetic_checkup->ab) ? $pre_anesthetic_checkup->ab : '' }}" />
                                                        <span>g/dL</span>
                                                    </div>
                                                </td>

                                                <td>
                                                    <div class="d-flex align-items-center" style="gap: 5px;">
                                                        <strong>Glob</strong>
                                                        <input type="text" class="form-control" id="glob"
                                                            name="glob" style="width: 100px;"
                                                            value="{{ isset($pre_anesthetic_checkup->glob) ? $pre_anesthetic_checkup->glob : '' }}" />
                                                        <span>g/dL</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center" style="gap: 5px;">
                                                        <strong>Ratio</strong>
                                                        <input type="text" class="form-control" id="ratio"
                                                            name="ratio" style="width: 100px;"
                                                            value="{{ isset($pre_anesthetic_checkup->ratio) ? $pre_anesthetic_checkup->ratio : '' }}" />
                                                        <span>g/dL</span>
                                                    </div>

                                                </td>
                                            </tr>
                                        </table>
                                        <table width="100%" border="1" style="margin-top:10px">

                                            <tr>
                                                <td>
                                                    <strong>CXR</strong>
                                                    <input type="text" class="form-control" id="cxr"
                                                        name="cxr"
                                                        value="{{ isset($pre_anesthetic_checkup->cxr) ? $pre_anesthetic_checkup->cxr : '' }}" />
                                                </td>
                                                <td>
                                                    <strong>ECG</strong>
                                                    <input type="text" class="form-control" id="ecg"
                                                        name="ecg"
                                                        value="{{ isset($pre_anesthetic_checkup->ecg) ? $pre_anesthetic_checkup->ecg : '' }}" />
                                                </td>
                                                <td>
                                                    <strong>Echo</strong>
                                                    <input type="text" class="form-control" id="echo"
                                                        name="echo"
                                                        value="{{ isset($pre_anesthetic_checkup->echo) ? $pre_anesthetic_checkup->echo : '' }}" />
                                                </td>
                                                <td>
                                                    <strong>CT/MRI</strong>
                                                    <input type="text" class="form-control" id="mri"
                                                        name="mri"
                                                        value="{{ isset($pre_anesthetic_checkup->mri) ? $pre_anesthetic_checkup->mri : '' }}" />
                                                </td>





                                            </tr>

                                            <tr>
                                                <td colspan="4">
                                                    <strong> Others : </strong>

                                                    <input type="text" class="form-control  " id="others"
                                                        name="others"
                                                        value="{{ isset($pre_anesthetic_checkup->others) ? $pre_anesthetic_checkup->others : '' }}" />
                                                </td>
                                            </tr>

                                        </table>

                                        <br>
                                        <h4><u>Vital Signs</u></h4>

                                        <table width="100%" border="1" style="margin-top:10px">
                                            <tr>
                                                <td>
                                                    <strong> Pulse : </strong>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <input type="text" class="form-control  " id="pulse"
                                                            name="pulse"
                                                            value="{{ isset($pre_anesthetic_checkup->pulse) ? $pre_anesthetic_checkup->pulse : '' }}" />
                                                        <span>/main</span>
                                                    </div>
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
                                                    <div class="d-flex align-items-center">
                                                        <input type="text" class="form-control  " id="bp"
                                                            name="bp"
                                                            value="{{ isset($pre_anesthetic_checkup->bp) ? $pre_anesthetic_checkup->bp : '' }}" />
                                                        <span>mmHg</span>
                                                    </div>
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
                                                    <div class="d-flex align-items-center">
                                                        <input type="text" class="form-control  " id="temperature"
                                                            name="temperature"
                                                            value="{{ isset($pre_anesthetic_checkup->temperature) ? $pre_anesthetic_checkup->temperature : '' }}" />
                                                        <span>°F</span>

                                                    </div>

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
                                                    <div class="d-flex align-items-center">
                                                        <input type="text" class="form-control me-1"
                                                            id="spo2" name="spo2"
                                                            value="{{ isset($pre_anesthetic_checkup->spo2) ? $pre_anesthetic_checkup->spo2 : '' }}" />
                                                        <span>%</span>
                                                    </div>
                                                </td>





                                            </tr>
                                            <tr>

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
                                                    <strong> GCS : </strong>
                                                </td>


                                                <td>
                                                    <input type="text" class="form-control  " id="gcs"
                                                        name="gcs"
                                                        value="{{ isset($pre_anesthetic_checkup->gcs) ? $pre_anesthetic_checkup->gcs : '' }}" />

                                                </td>
                                            </tr>
                                            <tr>


                                                <td>
                                                    <strong> Others : </strong>
                                                </td>
                                                <td>
                                                    <input type="text" name="clinical_exam_others"
                                                        id="clinical_exam_others" class="form-control"
                                                        value="{{ isset($pre_anesthetic_checkup->clinical_exam_others) ? $pre_anesthetic_checkup->clinical_exam_others : '' }}">
                                                </td>
                                            </tr>
                                        </table>


                                        <br>
                                        <h4><u>Airway Assessment</u></h2>
                                            <table width="100%" border="1" style="margin-top:10px">
                                                <tr>
                                                    <td>
                                                        <strong>Mouth opening > 3 fingers:</strong>
                                                        <select class="form-select" id="mouth_opening"
                                                            name="mouth_opening">
                                                            <option value="" disabled
                                                                {{ empty($pre_anesthetic_checkup->mouth_opening) ? 'selected' : '' }}>
                                                                -- Select --</option>
                                                            <option value="Yes"
                                                                {{ isset($pre_anesthetic_checkup->mouth_opening) && $pre_anesthetic_checkup->mouth_opening == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option value="No"
                                                                {{ isset($pre_anesthetic_checkup->mouth_opening) && $pre_anesthetic_checkup->mouth_opening == 'No' ? 'selected' : '' }}>
                                                                No</option>
                                                        </select>
                                                    </td>

                                                    <td>
                                                        <strong>Thyromental distance > 2 fingers:</strong>
                                                        <select class="form-select" id="thyromental_distance"
                                                            name="thyromental_distance">
                                                            <option value="" disabled
                                                                {{ empty($pre_anesthetic_checkup->thyromental_distance) ? 'selected' : '' }}>
                                                                -- Select --</option>
                                                            <option value="Yes"
                                                                {{ isset($pre_anesthetic_checkup->thyromental_distance) && $pre_anesthetic_checkup->thyromental_distance == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option value="No"
                                                                {{ isset($pre_anesthetic_checkup->thyromental_distance) && $pre_anesthetic_checkup->thyromental_distance == 'No' ? 'selected' : '' }}>
                                                                No</option>
                                                        </select>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        <strong>Neck Movement Restricted:</strong>
                                                        <select class="form-select" id="neck_movement"
                                                            name="neck_movement">
                                                            <option value="" disabled
                                                                {{ empty($pre_anesthetic_checkup->neck_movement) ? 'selected' : '' }}>
                                                                -- Select --</option>
                                                            <option value="Yes"
                                                                {{ isset($pre_anesthetic_checkup->neck_movement) && $pre_anesthetic_checkup->neck_movement == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option value="No"
                                                                {{ isset($pre_anesthetic_checkup->neck_movement) && $pre_anesthetic_checkup->neck_movement == 'No' ? 'selected' : '' }}>
                                                                No</option>
                                                        </select>
                                                    </td>

                                                    <td>
                                                        <strong>Short Neck:</strong>
                                                        <select class="form-select" id="short_neck"
                                                            name="short_neck">
                                                            <option value="" disabled
                                                                {{ empty($pre_anesthetic_checkup->short_neck) ? 'selected' : '' }}>
                                                                -- Select --</option>
                                                            <option value="Yes"
                                                                {{ isset($pre_anesthetic_checkup->short_neck) && $pre_anesthetic_checkup->short_neck == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option value="No"
                                                                {{ isset($pre_anesthetic_checkup->short_neck) && $pre_anesthetic_checkup->short_neck == 'No' ? 'selected' : '' }}>
                                                                No</option>
                                                        </select>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        <strong>Neck Swelling:</strong>
                                                        <select class="form-select" id="neck_swelling"
                                                            name="neck_swelling">
                                                            <option value="" disabled
                                                                {{ empty($pre_anesthetic_checkup->neck_swelling) ? 'selected' : '' }}>
                                                                -- Select --</option>
                                                            <option value="Yes"
                                                                {{ isset($pre_anesthetic_checkup->neck_swelling) && $pre_anesthetic_checkup->neck_swelling == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option value="No"
                                                                {{ isset($pre_anesthetic_checkup->neck_swelling) && $pre_anesthetic_checkup->neck_swelling == 'No' ? 'selected' : '' }}>
                                                                No</option>
                                                        </select>
                                                    </td>


                                                </tr>


                                                <tr>



                                                    <td>
                                                        <strong> Mallampati Grade : </strong>

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
                                                    <td>
                                                        <strong> Others: </strong>
                                                        <input type="text" class="form-control  " id="air_others"
                                                            name="air_others"
                                                            value="{{ isset($pre_anesthetic_checkup->air_others) ? $pre_anesthetic_checkup->air_others : '' }}" />

                                                    </td>


                                                </tr>
                                                <tr>

                                                        <td colspan="2">
                                                            <h4><u>Reginal Site Assesment</u></h2> <br>
                                                            <input type="text" class="form-control  "
                                                                id="reg_site" name="reg_site"
                                                                value="{{ isset($pre_anesthetic_checkup->reg_site) ? $pre_anesthetic_checkup->reg_site : '' }}" />

                                                        </td>

                                                </tr>


                                            </table>




                                            <br>
                                            <h4><u>Systemic Examination</u></h2>
                                                <table width="100%" border="1" style="margin-top:10px">
                                                    <tr>
                                                        <td>
                                                            <strong> Central Nervous system : </strong>
                                                            <input type="text" class="form-control  "
                                                                id="cns" name="cns"
                                                                value="{{ isset($pre_anesthetic_checkup->cns) ? $pre_anesthetic_checkup->cns : '' }}" />
                                                        </td>

                                                        <td>
                                                            <strong> Cardiovascular system : </strong>
                                                            <input type="text" class="form-control  "
                                                                id="cvs" name="cvs"
                                                                value="{{ isset($pre_anesthetic_checkup->cvs) ? $pre_anesthetic_checkup->cvs : '' }}" />
                                                        </td>

                                                    </tr>

                                                    <tr>
                                                        <td>
                                                            <strong> Respiratory System : </strong>
                                                            <input type="text" class="form-control  "
                                                                id="respiratory_system" name="respiratory_system"
                                                                value="{{ isset($pre_anesthetic_checkup->respiratory_system) ? $pre_anesthetic_checkup->respiratory_system : '' }}" />
                                                        </td>

                                                        <td>
                                                            <strong> Others : </strong>
                                                            <input type="text" class="form-control  "
                                                                id="systemic_others" name="systemic_others"
                                                                value="{{ isset($pre_anesthetic_checkup->systemic_others) ? $pre_anesthetic_checkup->systemic_others : '' }}" />
                                                        </td>

                                                    </tr>

                                                </table>
                                                <br>
                                                <h4><u>Consideration for Operating Room Anesthesiologist:</u></h2>
                                                    <table width="100%" border="1" style="margin-top:10px">

                                                        <tr>
                                                            <td>
                                                                <strong>Artificial denture:</strong>
                                                                <select class="form-select"
                                                                    id="coniser_artificial_denture"
                                                                    name="coniser_artificial_denture">

                                                                    <option value="Yes"
                                                                        {{ isset($pre_anesthetic_checkup->coniser_artificial_denture) && $pre_anesthetic_checkup->coniser_artificial_denture == 'Yes' ? 'selected' : '' }}>
                                                                        Yes</option>
                                                                    <option value="No"
                                                                        {{ isset($pre_anesthetic_checkup->coniser_artificial_denture) && $pre_anesthetic_checkup->coniser_artificial_denture == 'No' ? 'selected' : '' }}>
                                                                        No</option>
                                                                </select>
                                                            </td>
                                                            <td colspan="2">
                                                                <strong> Airway Assessment : </strong>
                                                                <select class="form-select" id="airway_examination"
                                                                    name="airway_examination">

                                                                    <option value="Normal"
                                                                        {{ isset($pre_anesthetic_checkup->airway_exam) && $pre_anesthetic_checkup->airway_exam == 'Normal' ? 'selected' : '' }}>
                                                                        Normal</option>
                                                                    <option value="Difficult"
                                                                        {{ isset($pre_anesthetic_checkup->airway_exam) && $pre_anesthetic_checkup->airway_exam == 'Difficult' ? 'selected' : '' }}>
                                                                        Difficult</option>
                                                                </select>

                                                            </td>
                                                        </tr>

                                                        <tr>

                                                            <td colspan="3">
                                                                <strong>Co-Existing Disease: </strong>
                                                                <input type="text" class="form-control  "
                                                                    id="co_existing" name="co_existing"
                                                                    value="{{ isset($pre_anesthetic_checkup->co_existing) ? $pre_anesthetic_checkup->co_existing : '' }}"
                                                                    placeholder="" />
                                                            </td>

                                                        </tr>

                                                        <tr>
                                                            @php
                                                                $asaClassValue =
                                                                    $pre_anesthetic_checkup->asa_class ?? '';
                                                                $asaClassSelected = is_array($asaClassValue)
                                                                    ? $asaClassValue
                                                                    : (is_string($asaClassValue) &&
                                                                    str_contains($asaClassValue, '[')
                                                                        ? json_decode($asaClassValue, true)
                                                                        : [$asaClassValue]);
                                                            @endphp


                                                            <td>
                                                                <strong> ASA : </strong>

                                                                <input type="checkbox" name="asa_class[]"
                                                                    value="1"
                                                                    {{ in_array('1', $asaClassSelected) ? 'checked' : '' }}>
                                                                1 &nbsp;&nbsp;

                                                                <input type="checkbox" name="asa_class[]"
                                                                    value="2"
                                                                    {{ in_array('2', $asaClassSelected) ? 'checked' : '' }}>
                                                                2 &nbsp;&nbsp;

                                                                <input type="checkbox" name="asa_class[]"
                                                                    value="3"
                                                                    {{ in_array('3', $asaClassSelected) ? 'checked' : '' }}>
                                                                3 &nbsp;&nbsp;

                                                                <input type="checkbox" name="asa_class[]"
                                                                    value="4"
                                                                    {{ in_array('4', $asaClassSelected) ? 'checked' : '' }}>
                                                                4 &nbsp;&nbsp;

                                                                <input type="checkbox" name="asa_class[]"
                                                                    value="5"
                                                                    {{ in_array('5', $asaClassSelected) ? 'checked' : '' }}>
                                                                5 &nbsp;&nbsp;

                                                                <input type="checkbox" name="asa_class[]"
                                                                    value="6"
                                                                    {{ in_array('6', $asaClassSelected) ? 'checked' : '' }}>
                                                                6 &nbsp;&nbsp;

                                                                <input type="checkbox" name="asa_class[]"
                                                                    value="E"
                                                                    {{ in_array('E', $asaClassSelected) ? 'checked' : '' }}>
                                                                E
                                                            </td>

                                                            <td>
                                                                <strong> NYHA : </strong>

                                                                <input type="radio" value="I"
                                                                    name="nyha_classification"
                                                                    id="nyha_classification"
                                                                    {{ isset($pre_anesthetic_checkup->nyha_classification) && $pre_anesthetic_checkup->nyha_classification == 'I' ? 'checked' : '' }}>
                                                                I &nbsp;&nbsp;
                                                                <input type="radio" value="II"
                                                                    name="nyha_classification"
                                                                    id="nyha_classification"
                                                                    {{ isset($pre_anesthetic_checkup->nyha_classification) && $pre_anesthetic_checkup->nyha_classification == 'II' ? 'checked' : '' }}>
                                                                II &nbsp;&nbsp;
                                                                <input type="radio" value="III"
                                                                    name="nyha_classification"
                                                                    id="nyha_classification"
                                                                    {{ isset($pre_anesthetic_checkup->nyha_classification) && $pre_anesthetic_checkup->nyha_classification == 'III' ? 'checked' : '' }}>
                                                                III &nbsp;&nbsp;
                                                                <input type="radio" value="IV"
                                                                    name="nyha_classification"
                                                                    id="nyha_classification"
                                                                    {{ isset($pre_anesthetic_checkup->nyha_classification) && $pre_anesthetic_checkup->nyha_classification == 'IV' ? 'checked' : '' }}>
                                                                IV
                                                            </td>

                                                            <td>
                                                                <strong> Mallampati grade : </strong>

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
                                                        @php
                                                            $anesthesiaDiscussed =
                                                                json_decode(
                                                                    $pre_anesthetic_checkup->type_of_anesthesia_discussed ??
                                                                        '[]',
                                                                    true,
                                                                ) ?? [];
                                                            $painReliefDiscussed =
                                                                json_decode(
                                                                    $pre_anesthetic_checkup->pain_relief_discussed ??
                                                                        '[]',
                                                                    true,
                                                                ) ?? [];
                                                        @endphp
                                                        <tr>
                                                            <td colspan="1"><strong>Type of Anesthesia
                                                                    Discussed:</strong></td>
                                                            <td colspan="3">
                                                                <input type="checkbox"
                                                                    name="type_of_anesthesia_discussed[]"
                                                                    value="GA"
                                                                    {{ in_array('GA', $anesthesiaDiscussed) ? 'checked' : '' }}>
                                                                GA &nbsp;&nbsp;

                                                                <input type="checkbox"
                                                                    name="type_of_anesthesia_discussed[]"
                                                                    value="Spinal"
                                                                    {{ in_array('Spinal', $anesthesiaDiscussed) ? 'checked' : '' }}>
                                                                Spinal &nbsp;&nbsp;

                                                                <input type="checkbox"
                                                                    name="type_of_anesthesia_discussed[]"
                                                                    value="Epidural"
                                                                    {{ in_array('Epidural', $anesthesiaDiscussed) ? 'checked' : '' }}>
                                                                Epidural &nbsp;&nbsp;

                                                                <input type="checkbox"
                                                                    name="type_of_anesthesia_discussed[]"
                                                                    value="Regional Block"
                                                                    {{ in_array('Regional Block', $anesthesiaDiscussed) ? 'checked' : '' }}>
                                                                Regional Block
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td colspan="1"><strong>Pain Relief Discussed:</strong>
                                                            </td>
                                                            <td colspan="3">
                                                                <input type="checkbox" name="pain_relief_discussed[]"
                                                                    value="PCA"
                                                                    {{ in_array('PCA', $painReliefDiscussed) ? 'checked' : '' }}>
                                                                PCA &nbsp;&nbsp;

                                                                <input type="checkbox" name="pain_relief_discussed[]"
                                                                    value="Epidural infusion"
                                                                    {{ in_array('Epidural infusion', $painReliefDiscussed) ? 'checked' : '' }}>
                                                                Epidural infusion &nbsp;&nbsp;

                                                                <input type="checkbox" name="pain_relief_discussed[]"
                                                                    value="PCEA"
                                                                    {{ in_array('PCEA', $painReliefDiscussed) ? 'checked' : '' }}>
                                                                PCEA &nbsp;&nbsp;

                                                                <input type="checkbox" name="pain_relief_discussed[]"
                                                                    value="Oral"
                                                                    {{ in_array('Oral', $painReliefDiscussed) ? 'checked' : '' }}>
                                                                Oral &nbsp;&nbsp;

                                                                <input type="checkbox" name="pain_relief_discussed[]"
                                                                    value="IM"
                                                                    {{ in_array('IM', $painReliefDiscussed) ? 'checked' : '' }}>
                                                                IM &nbsp;&nbsp;

                                                                <input type="checkbox" name="pain_relief_discussed[]"
                                                                    value="IV"
                                                                    {{ in_array('IV', $painReliefDiscussed) ? 'checked' : '' }}>
                                                                IV &nbsp;&nbsp;

                                                                <input type="checkbox" name="pain_relief_discussed[]"
                                                                    value="Per rectal"
                                                                    {{ in_array('Per rectal', $painReliefDiscussed) ? 'checked' : '' }}>
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
                                                            <td colspan="3">
                                                                <strong>Others</strong>
                                                                <input type="text" class="form-control"
                                                                    id="others2" name="others2"
                                                                    value="{{ isset($pre_anesthetic_checkup->other2) ? $pre_anesthetic_checkup->other2 : '' }}" />
                                                            </td>

                                                        </tr>
                                                    </table>
                                                    <br>
                                                    <h4><u>Pre-operative Instructions:</u></h2>
                                                        <table width="100%" border="1" style="margin-top:10px">

                                                            <tr>
                                                                <td colspan="4">
                                                                    <strong>1. NPO-
                                                                        <input type="text" class=""
                                                                            id="pre_operative_ins1"
                                                                            name="pre_operative_ins1"
                                                                            value="{{ isset($pre_anesthetic_checkup->pre_operative_ins1) ? $pre_anesthetic_checkup->pre_operative_ins1 : '' }}" />
                                                                        hours before
                                                                        <select class="form-select" id="airway_others"
                                                                            name="airway_others">


                                                                            <option value="Operation"
                                                                                {{ isset($pre_anesthetic_checkup->airway_others) && $pre_anesthetic_checkup->airway_others == 'Operation' ? 'selected' : '' }}>
                                                                                Operation</option>
                                                                            <option value="Till further order"
                                                                                {{ isset($pre_anesthetic_checkup->airway_others) && $pre_anesthetic_checkup->airway_others == 'Till further order' ? 'selected' : '' }}>
                                                                                Till further order</option>
                                                                        </select>

                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <strong>2. Drugs / Premedication :</strong>

                                                                </td>
                                                                <td colspan="3">

                                                                    <textarea class="form-control" id="pre_operative_ins2" name="pre_operative_ins2" rows="3">{{ isset($pre_anesthetic_checkup->pre_operative_ins2) ? $pre_anesthetic_checkup->pre_operative_ins2 : '' }}</textarea>



                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <strong>3. Blood Donor Standby(Cross-matched):
                                                                    </strong>

                                                                </td>
                                                                <td colspan="3">

                                                                    <input type="text" class="form-control"
                                                                        id="pre_operative_ins3"
                                                                        name="pre_operative_ins3"
                                                                        value="{{ isset($pre_anesthetic_checkup->pre_operative_ins3) ? $pre_anesthetic_checkup->pre_operative_ins3 : '' }}" />
                                                                    <strong> Unit</strong>
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <strong>4. Blood for Operation</strong>

                                                                </td>
                                                                <td>
                                                                    <strong>Whole blood
                                                                        <input type="text" class="form-control"
                                                                            id="whole_blood" name="whole_blood"
                                                                            value="{{ $pre_anesthetic_checkup->whole_blood ?? '' }}" />
                                                                        Unit
                                                                    </strong>
                                                                </td>

                                                                <td>
                                                                    <strong>Packed red blood cell
                                                                        <input type="text" class="form-control"
                                                                            id="red_blood" name="red_blood"
                                                                            value="{{ $pre_anesthetic_checkup->red_blood ?? '' }}" />
                                                                        Unit
                                                                    </strong>
                                                                </td>

                                                                <td>
                                                                    <strong>Fresh frozen plasma
                                                                        <input type="text" class="form-control"
                                                                            id="fresh_frosen_plasma"
                                                                            name="fresh_frosen_plasma"
                                                                            value="{{ $pre_anesthetic_checkup->fresh_frosen_plasma ?? '' }}" />
                                                                        Unit
                                                                    </strong>
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <strong>5. Further advice :</strong>

                                                                </td>
                                                                <td colspan="3">
                                                                    <textarea class="form-control" id="further_advice" name="further_advice" rows="5">{{ isset($pre_anesthetic_checkup->further_advice) ? $pre_anesthetic_checkup->further_advice : '' }}</textarea>
                                                                </td>

                                                            </tr>
                                                        </table>

                                                        <table width="100%" border="1" style="margin-top:10px">
                                                            <tr>
                                                                <td>
                                                                    <strong>Accepted for operation Under:</strong>
                                                                </td>
                                                                <td>
                                                                    <input type="checkbox" name="ga"
                                                                        id="ga" value="GA"
                                                                        {{ isset($pre_anesthetic_checkup->ga) && $pre_anesthetic_checkup->ga == 'GA' ? 'checked' : '' }}>
                                                                    GA
                                                                </td>
                                                                <td>
                                                                    <input type="checkbox" name="ra"
                                                                        id="ra" value="RA"
                                                                        {{ isset($pre_anesthetic_checkup->ra) && $pre_anesthetic_checkup->ra == 'RA' ? 'checked' : '' }}>
                                                                    RA
                                                                </td>
                                                                <td>
                                                                    <input type="checkbox" name="monitored_care"
                                                                        id="monitored_care" value="Monitored Care"
                                                                        {{ isset($pre_anesthetic_checkup->monitored_care) && $pre_anesthetic_checkup->monitored_care == 'Monitored Care' ? 'checked' : '' }}>
                                                                    Monitored Anesthesia Care(MAC)
                                                                </td>



                                                            </tr>

                                                            <br>
                                                        </table>
                                                        <table width="100%" border="1" style="margin-top:10px">
                                                            <tr>
                                                                <td colspan="" class="">
                                                                    <label for="Anesthetist_name"
                                                                        class="col-form-label col-form-label-sm">
                                                                        Anesthesiologist</label>
                                                                    <input type="text"
                                                                        class="form-control form-control-sm"
                                                                        id="Anesthetist_name" name="Anesthetist_name"
                                                                        placeholder="Dr. Name"
                                                                        value="{{ isset($pre_anesthetic_checkup->full_name) ? $pre_anesthetic_checkup->full_name : '' }}" />
                                                                    <input type="hidden" name="Anesthetist_no_fk"
                                                                        id="Anesthetist_no_fk"
                                                                        value="{{ isset($pre_anesthetic_checkup->anesthetist_id_fk) ? $pre_anesthetic_checkup->anesthetist_id_fk : '' }}">
                                                                </td>
                                                            </tr>

                                                        </table>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    @php
                        $redirect_url = route('ipd.pre-anesthetic-checkup-form',[$pat_info->patient_no_fk,$ref_no]);
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
    var editor = CKEDITOR.replace('editor1', {
        tabSpaces: 4
    });

    editor.on('change', function(evt) {
        $('#editor_content').val(evt.editor.getData())
    });

    function calculateBMI() {
        const heightInput = document.getElementById('height').value;
        const weightInput = document.getElementById('weight').value;

        const height = parseFloat(heightInput);
        const weight = parseFloat(weightInput);

        if (!isNaN(height) && !isNaN(weight) && height > 0) {
            const heightInMeters = height / 100;
            const bmi = weight / (heightInMeters * heightInMeters);
            document.getElementById('bmi').value = bmi.toFixed(2);
        } else {
            document.getElementById('bmi').value = '';
        }
    }
</script>
