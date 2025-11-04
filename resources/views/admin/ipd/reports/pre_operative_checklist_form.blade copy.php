{{-- <link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
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
    table{
        margin-top:10px;
    }
</style> --}}
<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">

<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link href="{{ asset('css/redactor.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('asset/timepicker/css/timepicker.css') }}">
<section id="report_section">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">Pre-operative Checklist</h5>
                <small>Report / Pre-operative Checklist</small>
            </div>
        </div>
        {{-- @dd($anaesthetist_record_data) --}}
        <div class="anaesthetic__form">
            <form action="{{ route('pre-operative-checklist-store') }}" method="post" id="PREOERATIVECHECK">
                @csrf
                <input type="hidden" name="admission_id"
                    value="{{ isset($pat_info->admission_no_pk) ? $pat_info->admission_no_pk : '' }}">
                <input type="hidden" name="pat_id"
                    value="{{ isset($pat_info->patient_no_fk) ? $pat_info->patient_no_fk : '' }}">
                <input type="hidden" name="pre_operativechklist_no_pk"
                    value="{{ isset($pre_operative_checklist->pre_operativechklist_no_pk) ? $pre_operative_checklist->pre_operativechklist_no_pk : '' }}">
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
                                                <label for="ptBlood" class="col-form-label col-form-label-sm">B.
                                                    Group</label>
                                                <input type="text" class="form-control form-control-sm"
                                                    id="ptBlood" name="ptBlood"
                                                    value="{{ isset($pat_info->blood_group_text) ? $pat_info->blood_group_text : '' }}"
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
                                                    value="{{ isset($pre_operative_checklist->reg_date) ? date('d-m-Y', strtotime($pre_operative_checklist->reg_date)) : '' }}"
                                                    placeholder="dd-mm-YYYY" />
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="ptBed" class="col-form-label col-form-label-sm">Name of
                                                    the Doctor</label>
                                                <input type="text" class="form-control form-control-sm"
                                                    id="doctor_name" name="doctor_name" placeholder="Dr. Name"
                                                    value="{{ isset($pre_operative_checklist->doctor_name) ? $pre_operative_checklist->doctor_name : '' }}" />
                                                <input type="hidden" name="hdn_doctor_id" id="hdn_doctor_id"
                                                    value="{{ isset($pre_operative_checklist->doctor_no_fk) ? $pre_operative_checklist->doctor_no_fk : '' }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- 1st card body -->
                                <!-- 2nd card body -->

                                <div class="card-body p-3">
                                    <div class="row justify-content-end">
                                        <!-- <table width="100%" border="1">
                                            <tr>

                                                <td class='w-15'>Patient Handover By </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="patient_handover_by" name="patient_handover_by"
                                                        placeholder=""
                                                        value="{{ isset($pre_operative_checklist->patient_handover_by) ? $pre_operative_checklist->patient_handover_by : '' }}" />
                                                    <input type="hidden" name="patient_handover_by_id"
                                                        id="patient_handover_by_id"
                                                        value="{{ isset($pre_operative_checklist->patient_handover_by_id) ? $pre_operative_checklist->patient_handover_by_id : '' }}">

                                                </td>

                                            </tr>
                                            <tr>
                                                <td>Patient Receive By</td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="patient_receive_by" name="patient_receive_by"
                                                        placeholder=""
                                                        value="{{ isset($pre_operative_checklist->patient_rcvd_by) ? $pre_operative_checklist->patient_rcvd_by : '' }}" />
                                                    <input type="hidden" name="patient_receive_by_id"
                                                        id="patient_receive_by_id"
                                                        value="{{ isset($pre_operative_checklist->patient_rcvd_by_id) ? $pre_operative_checklist->patient_rcvd_by_id : '' }}">
                                                </td>

                                            </tr>
                                        </table> -->
                                        <table width="100%" border="1">
                                            <tr>
                                                <td class=''>Sl# </td>
                                                <td class='w-35'>Issues </td>
                                                <td class="text-center">Ward Nurse</td>
                                                <td class="text-center">OR Nurse</td>
                                            </tr>
                                            <tr>
                                                <td class=''>1 </td>
                                                <td class=''>Correct Patient ID, names, age, sex (patient identity)  </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="patient_identity1" name="patient_identity1"
                                                        placeholder=""
                                                        value="{{ isset($pre_operative_checklist->patient_identity1) ? $pre_operative_checklist->patient_identity1 : '' }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="patient_identity2" name="patient_identity2"
                                                        placeholder=""
                                                        value="{{ isset($pre_operative_checklist->patient_identity2) ? $pre_operative_checklist->patient_identity2 : '' }}" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class=''>2 </td>
                                                <td class=''>Nil by Mouth since  </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="npo_ensured1" name="npo_ensured1"
                                                        placeholder=""
                                                        value="{{ isset($pre_operative_checklist->npo_ensured1) ? $pre_operative_checklist->npo_ensured1 : '' }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="npo_ensured2" name="npo_ensured2"
                                                        placeholder=""
                                                        value="{{ isset($pre_operative_checklist->npo_ensured2) ? $pre_operative_checklist->npo_ensured2 : '' }}" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class='' rowspan="2">3 </td>
                                                <td class=''>Dress Changed (Clean, Gowned and Cap)</td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="dress_changed1" name="dress_changed1"
                                                        placeholder=""
                                                        value="{{ isset($pre_operative_checklist->dress_changed1) ? $pre_operative_checklist->dress_changed1 : '' }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="dress_changed2" name="dress_changed2"
                                                        placeholder=""
                                                        value="{{ isset($pre_operative_checklist->dress_changed2) ? $pre_operative_checklist->dress_changed2 : '' }}" />
                                                </td>
                                            </tr>
                                            <tr>
                                                {{-- <td class=''>4 </td> --}}
                                                <td class=''>Ornaments/Jewellry/ Amulet /Nail polish removed </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="ornaments_jewellry_amulet1" name="ornaments_jewellry_amulet1"
                                                        placeholder=""
                                                        value="{{ isset($pre_operative_checklist->ornamentjwlryamulet_mv1) ? $pre_operative_checklist->ornamentjwlryamulet_mv1 : '' }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="ornaments_jewellry_amulet2" name="ornaments_jewellry_amulet2"
                                                        placeholder=""
                                                        value="{{ isset($pre_operative_checklist->ornamentjwlryamulet_mv2) ? $pre_operative_checklist->ornamentjwlryamulet_mv2 : '' }}" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class='' rowspan="2">4 </td>
                                                <td class=''>Operation Area Clean & Shaved </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="operation_area_clean_shaved1" name="operation_area_clean_shaved1"
                                                        placeholder=""
                                                        value="{{ isset($pre_operative_checklist->opnarea_clean_shaved1) ? $pre_operative_checklist->opnarea_clean_shaved1 : '' }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="operation_area_clean_shaved2" name="operation_area_clean_shaved2"
                                                        placeholder=""
                                                        value="{{ isset($pre_operative_checklist->opnarea_clean_shaved2) ? $pre_operative_checklist->opnarea_clean_shaved2 : '' }}" />
                                                </td>
                                            </tr>
                                            <tr>
                                                {{-- <td class=''>6 </td> --}}
                                                <td class=''> Operation Site Marked</td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="operation_side_marked1" name="operation_side_marked1"
                                                        placeholder=""
                                                        value="{{ isset($pre_operative_checklist->opn_side_marked1) ? $pre_operative_checklist->opn_side_marked1 : '' }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="operation_side_marked2" name="operation_side_marked2"
                                                        placeholder=""
                                                        value="{{ isset($pre_operative_checklist->opn_side_marked2) ? $pre_operative_checklist->opn_side_marked2 : '' }}" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class='' rowspan="2"> 5</td>
                                                <td class=''> Consent Form and/ High risk form signed</td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="consent_form_signed1" name="consent_form_signed1"
                                                        placeholder=""
                                                        value="{{ isset($pre_operative_checklist->consentfrm_sign1) ? $pre_operative_checklist->consentfrm_sign1 : '' }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="consent_form_signed2" name="consent_form_signed2"
                                                        placeholder=""
                                                        value="{{ isset($pre_operative_checklist->consentfrm_sign2) ? $pre_operative_checklist->consentfrm_sign2 : '' }}" />
                                                </td>
                                            </tr>
                                            <!-- <tr>                                              
                                                <td class=''> High Risk Consent Form Signed </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="high_risk_consent_form_signed1" name="high_risk_consent_form_signed1"
                                                        placeholder=""
                                                        value="{{ isset($pre_operative_checklist->highriskconsent_frmsign1) ? $pre_operative_checklist->highriskconsent_frmsign1 : '' }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="high_risk_consent_form_signed2" name="high_risk_consent_form_signed2"
                                                        placeholder=""
                                                        value="{{ isset($pre_operative_checklist->highriskconsent_frmsign2) ? $pre_operative_checklist->highriskconsent_frmsign2 : '' }}" />
                                                </td>
                                            </tr> -->
                                            <tr>
                                                <!-- <td class=''> 6</td> -->
                                                <td class=''> Pre-Anesthesia Checkup Done </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="pre_anesthetic_checkup_done1" name="pre_anesthetic_checkup_done1"
                                                        placeholder=""
                                                        value="{{ isset($pre_operative_checklist->pre_anesthetic_chkup1) ? $pre_operative_checklist->pre_anesthetic_chkup1 : '' }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="pre_anesthetic_checkup_done2" name="pre_anesthetic_checkup_done2"
                                                        placeholder=""
                                                        value="{{ isset($pre_operative_checklist->pre_anesthetic_chkup2) ? $pre_operative_checklist->pre_anesthetic_chkup2 : '' }}" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class=''> 6</td>
                                                <td class=''> Patient height, weight & BMI measured </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="Patient_height_weight_measured1" name="Patient_height_weight_measured1"
                                                        placeholder=""
                                                        value="{{ isset($pre_operative_checklist->patients_heightweight1) ? $pre_operative_checklist->patients_heightweight1 : '' }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="Patient_height_weight_measured2" name="Patient_height_weight_measured2"
                                                        placeholder=""
                                                        value="{{ isset($pre_operative_checklist->patients_heightweight2 ) ? $pre_operative_checklist->patients_heightweight2  : '' }}" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class=''> 7</td>
                                                <td class=''>Blood is ready in number-Donor standby/ Blood deposited </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="blood_is_ready1" name="blood_is_ready1"
                                                        placeholder=""
                                                        value="{{ isset($pre_operative_checklist->blood_is_ready1) ? $pre_operative_checklist->blood_is_ready1 : '' }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="blood_is_ready2" name="blood_is_ready2"
                                                        placeholder=""
                                                        value="{{ isset($pre_operative_checklist->blood_is_ready2) ? $pre_operative_checklist->blood_is_ready2 : '' }}" />
                                                </td>
                                            </tr>

                                            <!-- <tr>
                                                <td class=''> 9</td>
                                                <td class=''> Donor is ready </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="donor_is_ready1" name="donor_is_ready1"
                                                        placeholder=""
                                                        value="{{ isset($pre_operative_checklist->donor_is_ready1) ? $pre_operative_checklist->donor_is_ready1 : '' }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="donor_is_ready2" name="donor_is_ready2"
                                                        placeholder=""
                                                        value="{{ isset($pre_operative_checklist->donor_is_ready2) ? $pre_operative_checklist->donor_is_ready2 : '' }}" />
                                                </td>
                                            </tr> -->
                                            <tr>
                                                <td class=''> 8</td>
                                                <td class=''> HBsAg/HCV/HIV </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="hbsAg_hcv_hiv1" name="hbsAg_hcv_hiv1"
                                                        placeholder=""
                                                        value="{{ isset($pre_operative_checklist->hbs_ag_hcv_hiv1) ? $pre_operative_checklist->hbs_ag_hcv_hiv1 : '' }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="hbsAg_hcv_hiv2" name="hbsAg_hcv_hiv2"
                                                        placeholder=""
                                                        value="{{ isset($pre_operative_checklist->hbs_ag_hcv_hiv2) ? $pre_operative_checklist->hbs_ag_hcv_hiv2 : '' }}" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class=''> 9</td>
                                                <td class=''> All investigation Reports with Radiological Films available (file complete) </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="investigation_radiological1" name="investigation_radiological1"
                                                        placeholder=""
                                                        value="{{ isset($pre_operative_checklist->investigationrpt_radiflm1) ? $pre_operative_checklist->investigationrpt_radiflm1 : '' }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="investigation_radiological2" name="investigation_radiological2"
                                                        placeholder=""
                                                        value="{{ isset($pre_operative_checklist->investigationrpt_radiflm2) ? $pre_operative_checklist->investigationrpt_radiflm2 : '' }}" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class=''> 10</td>
                                                <td class=''> Monitoring (IV access / Spo2) opposite to the  operating site </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="monitoring_opposit_operating_site1" name="monitoring_opposit_operating_site1"
                                                        placeholder=""
                                                        value="{{ isset($pre_operative_checklist->monitoringopsite_operating1) ? $pre_operative_checklist->monitoringopsite_operating1 : '' }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="monitoring_opposit_operating_site2" name="monitoring_opposit_operating_site2"
                                                        placeholder=""
                                                        value="{{ isset($pre_operative_checklist->monitoringopsite_operating2) ? $pre_operative_checklist->monitoringopsite_operating2 : '' }}" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class=''> 11</td>
                                                <td class=''> Allergies </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="allergies1" name="allergies1"
                                                        placeholder=""
                                                        value="{{ isset($pre_operative_checklist->allergies1) ? $pre_operative_checklist->allergies1 : '' }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="allergies2" name="allergies2"
                                                        placeholder=""
                                                        value="{{ isset($pre_operative_checklist->allergies2) ? $pre_operative_checklist->allergies2 : '' }}" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class=''> 12</td>
                                                <td class=''> Pacemaker / Artificial Denture/Implant</td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="pacemaker1" name="pacemaker1"
                                                        placeholder=""
                                                        value="{{ isset($pre_operative_checklist->pacemaker1) ? $pre_operative_checklist->pacemaker1 : '' }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="pacemaker2" name="pacemaker2"
                                                        placeholder=""
                                                        value="{{ isset($pre_operative_checklist->pacemaker2) ? $pre_operative_checklist->pacemaker2 : '' }}" />
                                                </td>
                                            </tr>
                                            <!-- <tr>
                                                <td class=''> 15</td>
                                                <td class=''> Artifical Tooth/Denture/Implant </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="artifical_tooth_denture_implant1" name="artifical_tooth_denture_implant1"
                                                        placeholder=""
                                                        value="{{ isset($pre_operative_checklist->artificaltooth_denture1) ? $pre_operative_checklist->artificaltooth_denture1 : '' }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="artifical_tooth_denture_implant2" name="artifical_tooth_denture_implant2"
                                                        placeholder=""
                                                        value="{{ isset($pre_operative_checklist->artificaltooth_denture2) ? $pre_operative_checklist->artificaltooth_denture2 : '' }}" />
                                                </td>
                                            </tr> -->
                                            <!-- <tr>
                                                <td class=''> 16</td>
                                                <td class=''> Cornorbidity </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="cornorbidity1" name="cornorbidity1"
                                                        placeholder=""
                                                        value="{{ isset($pre_operative_checklist->cornorbidity1) ? $pre_operative_checklist->cornorbidity1 : '' }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="cornorbidity2" name="cornorbidity2"
                                                        placeholder=""
                                                        value="{{ isset($pre_operative_checklist->cornorbidity2) ? $pre_operative_checklist->cornorbidity2 : '' }}" />
                                                </td>
                                            </tr> -->
                                            <tr>
                                                <td class=''> 13</td>
                                                <td class=''> Anticoagulants in last 5 days </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="anticoagulants_in_last_5_days1" name="anticoagulants_in_last_5_days1"
                                                        placeholder=""
                                                        value="{{ isset($pre_operative_checklist->anticoagulants_last_5days1) ? $pre_operative_checklist->anticoagulants_last_5days1 : '' }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="anticoagulants_in_last_5_days2" name="anticoagulants_in_last_5_days2"
                                                        placeholder=""
                                                        value="{{ isset($pre_operative_checklist->anticoagulants_last_5days2) ? $pre_operative_checklist->anticoagulants_last_5days2 : '' }}" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class=''> 14</td>
                                                <td class=''> Antihypertensive / Bronchodilator/ Other medication taken </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="antihypertensive_bronchodilator1" name="antihypertensive_bronchodilator1"
                                                        placeholder=""
                                                        value="{{ isset($pre_operative_checklist->antihpt_bronchodilator1) ? $pre_operative_checklist->antihpt_bronchodilator1 : '' }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="antihypertensive_bronchodilator2" name="antihypertensive_bronchodilator2"
                                                        placeholder=""
                                                        value="{{ isset($pre_operative_checklist->antihpt_bronchodilator2) ? $pre_operative_checklist->antihpt_bronchodilator2 : '' }}" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class=''> 15</td>
                                                <td class=''>Hypoglycemic agent/ other (as adv) admitted </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="hypoglycemic_agent1" name="hypoglycemic_agent1"
                                                        placeholder=""
                                                        value="{{ isset($pre_operative_checklist->hypoglycemic_agent1) ? $pre_operative_checklist->hypoglycemic_agent1 : '' }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="hypoglycemic_agent2" name="hypoglycemic_agent2"
                                                        placeholder=""
                                                        value="{{ isset($pre_operative_checklist->hypoglycemic_agent2) ? $pre_operative_checklist->hypoglycemic_agent2 : '' }}" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class=''> 16</td>
                                                <td class=''>Voided urine </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="voided_urine1" name="voided_urine1"
                                                        placeholder=""
                                                        value="{{ isset($pre_operative_checklist->voided_urine1) ? $pre_operative_checklist->voided_urine1 : '' }}" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="voided_urine2" name="voided_urine2"
                                                        placeholder=""
                                                        value="{{ isset($pre_operative_checklist->voided_urine2) ? $pre_operative_checklist->voided_urine2 : '' }}" />
                                                </td>
                                            </tr>

                                        </table>
                                        <table width="100%" border="1" style="margin-top: 5px;">
                                            <tr>
                                                <td class='w-25'>Any Additional Information, Implants etc </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id=" additional_information_implants" name=" additional_information_implants" placeholder=""
                                                        value="{{ isset($pre_operative_checklist->add_info_implants) ? $pre_operative_checklist->add_info_implants : '' }}" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class='w-25'>Ward Nurse Name and Signature </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="word_nurse_name" name="word_nurse_name"
                                                        placeholder=""
                                                        value="{{ isset($pre_operative_checklist->word_nurse_name) ? $pre_operative_checklist->word_nurse_name : '' }}" />
                                                    <input type="hidden" name="word_nurse_name_id"
                                                        id="word_nurse_name_id"
                                                        value="{{ isset($pre_operative_checklist->word_nurse_person_no_fk ) ? $pre_operative_checklist->word_nurse_person_no_fk  : '' }}">

                                                </td>

                                            </tr>
                                            <tr>
                                                <td>Theatre Nurse Name and Signature</td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="theatre_nurse_name" name="theatre_nurse_name"
                                                        placeholder=""
                                                        value="{{ isset($pre_operative_checklist->theatre_nurse_name) ? $pre_operative_checklist->theatre_nurse_name : '' }}" />
                                                    <input type="hidden" name="theatre_nurse_name_id"
                                                        id="theatre_nurse_name_id"
                                                        value="{{ isset($pre_operative_checklist->theatre_nurse_person_no_fk ) ? $pre_operative_checklist->theatre_nurse_person_no_fk  : '' }}">
                                                </td>

                                            </tr>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    @php
                        $redirect_url = route('ipd.pre-operative-checklist-form', $pat_info->admission_no_pk);
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
    openDoctorAutocomplete('#patient_handover_by', 'patient_handover_by_id', 'doctor_ind', '1,2');

    openDoctorAutocomplete('#patient_receive_by', 'patient_receive_by_id', 'doctor_ind', '1,2');
    openDoctorAutocomplete('#assistant_2_surgeon_name', 'assistant_2_surgeon_no_fk', 'doctor_ind', '1,2');
    openDoctorAutocomplete('#assistant_3_surgeon_name', 'assistant_3_surgeon_no_fk', 'doctor_ind', '1,2');
    openDoctorAutocomplete('#assistant_4_surgeon_name', 'assistant_4_surgeon_no_fk', 'doctor_ind', '1,2');

    openDoctorAutocomplete('#anesthesiologist_name', 'anesthesiologist_no_fk', 'doctor_ind', '1,2');
    openDoctorAutocomplete('#assistant_anesthesiologist_name', 'assistant_anesthesiologist_no_fk', 'doctor_ind', '1,2');
    openDoctorAutocomplete('#assistant_2_anesthesiologist_name', 'assistant_2_anesthesiologist_no_fk', 'doctor_ind','1,2');

    openDoctorAutocomplete('#word_nurse_name', 'word_nurse_name_id', 'employee_ind','1');
    openDoctorAutocomplete('#theatre_nurse_name', 'theatre_nurse_name_id', 'employee_ind','1');

    openDoctorAutocomplete('#scrub_nurse', 'scrub_nurse_no_fk');

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

    editor.on('change', function(evt) {
        $('#editor_content').val(evt.editor.getData())
    });
</script>
