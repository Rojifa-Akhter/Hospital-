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
        min-height: 100px;
        width: 630px;
    }
</style>

<section id="report_section">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">Anaesthetic Record</h5>
                <small>Report / Anaesthetic Record</small>
            </div>
        </div>
        {{-- @dd($anaesthetist_record_data) --}}
        <div class="anaesthetic__form">
            <form action="{{route('anaesthetic-record-store')}}" method="post" id="ANAESTHETICRECORD">
                @csrf
                <input type="hidden" name="ref_no" value="{{ isset($ref_no) ? $ref_no : '' }}">
                <input type="hidden" name="admission_id" value="{{isset($pat_info->admission_no_pk) ? $pat_info->admission_no_pk : ''}}">
                <input type="hidden" name="pat_id" value="{{isset($pat_info->patient_no_pk) ? $pat_info->patient_no_pk : ''}}">
                <input type="hidden" name="anaesthetic_no_pk" value="{{isset($anaesthetist_record_data->anaesthetic_no_pk) ? $anaesthetist_record_data->anaesthetic_no_pk :''}}">
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
                                                <input type="text" class="form-control form-control-sm" readonly id="nameOfpt" name="nameOfpt" value="{{isset($pat_info->patient_name) ? $pat_info->patient_name : ""}}" placeholder="Name Of pt" />
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="regNo" class="col-form-label col-form-label-sm">Patient Id</label>
                                                <input type="text" class="form-control form-control-sm" id="regNo" name="regNo" value="{{isset($pat_info->patient_code) ? $pat_info->patient_code : ""}}" placeholder="" readonly />
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="ptAge" class="col-form-label col-form-label-sm">Age</label>
                                                <input type="text" class="form-control form-control-sm" id="ptAge" name="ptAge" value="{{isset($pat_info->age) ? $pat_info->age : ""}}" placeholder="45 Years" readonly />
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="ptSex" class="col-form-label col-form-label-sm">Sex</label>
                                                <input type="text" class="form-control form-control-sm" id="ptSex" name="ptSex" value="{{isset($pat_info->gender_txt) ? $pat_info->gender_txt : ""}}" placeholder="" readonly />
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="ptBlood" class="col-form-label col-form-label-sm">B.
                                                    Group</label>
                                                <input type="text" class="form-control form-control-sm" id="ptBlood" name="ptBlood" value="{{isset($pat_info->blood_group_txt) ? $pat_info->blood_group_txt : ""}}" placeholder="" readonly />
                                            </div>
                                        </div>

                                        {{-- <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="ptUnit" class="col-form-label col-form-label-sm">Department</label>
                                                <input type="text" class="form-control form-control-sm" id="ptUnit" name="ptUnit" value="{{isset($pat_info->new_su_name) ? $pat_info->new_su_name : ""}}" placeholder="" readonly />
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="ptWard" class="col-form-label col-form-label-sm">Ward</label>
                                                <input type="text" class="form-control form-control-sm" id="ptWard" name="ptWard" value="{{isset($pat_info->new_ward_name) ? $pat_info->new_ward_name : ""}}" placeholder="" readonly />
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="ptBed" class="col-form-label col-form-label-sm">Bed</label>
                                                <input type="text" class="form-control form-control-sm" id="ptBed" name="ptBed" value="{{isset($pat_info->new_bed_name) ? $pat_info->new_bed_name : ""}}" placeholder="" readonly />
                                            </div>
                                        </div> --}}


                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="ptWeight" class="col-form-label col-form-label-sm">Weight
                                                    (kg)</label>
                                                <input type="text" class="form-control form-control-sm" id="ptWeight" name="ptWeight" placeholder="" value="{{isset($anaesthetist_record_data->weight) ? $anaesthetist_record_data->weight :''}}" />
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="preopDiag" class="col-form-label col-form-label-sm">Preop.
                                                    Diag</label>
                                                <input type="text" class="form-control form-control-sm" id="preopDiag" name="preopDiag" placeholder="" value="{{isset($anaesthetist_record_data->preep_diag) ? $anaesthetist_record_data->preep_diag :''}}" />
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="proposedOp" class="col-form-label col-form-label-sm">Proposed Op</label>
                                                <input type="text" class="form-control form-control-sm" id="proposedOp" name="proposedOp" placeholder="" value="{{isset($anaesthetist_record_data->proposed_op) ? $anaesthetist_record_data->proposed_op :''}}" />
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="coExistingDisease" class="col-form-label col-form-label-sm">Co-Existing
                                                    Disease</label>
                                                <input type="text" class="form-control form-control-sm" id="coExistingDisease" name="coExistingDisease" placeholder="" value="{{isset($anaesthetist_record_data->co_existing_disease) ? $anaesthetist_record_data->co_existing_disease :''}}" />
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="previousAnaes" class="col-form-label col-form-label-sm">Previous anaes</label>
                                                <input type="text" class="form-control form-control-sm" id="previousAnaes" name="previousAnaes" placeholder="" value="{{isset($anaesthetist_record_data->previous_anaes) ? $anaesthetist_record_data->previous_anaes :''}}" />
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="inlineRadioAllergy" class="col-form-label col-form-label-sm">Allergy</label>
                                                <input type="text" class="form-control form-control-sm" id="inlineRadioAllergy" name="inlineRadioAllergy" placeholder="" value="{{isset($anaesthetist_record_data->allergy) ? $anaesthetist_record_data->allergy :''}}" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- 1st card body -->
                                <!-- 2nd card body -->
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Pre induction Check list</h5>
                                </div>
                                <div class="card-body p-3">
                                    <div class="form-row">


                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="txt__pulse" class="col-form-label col-form-label-sm">Pulse/min</label>
                                                <input type="text" class="form-control form-control-sm" id="txt__pulse" name="txt__pulse" value="{{isset($anaesthetist_record_data->pulse_min) ? $anaesthetist_record_data->pulse_min :''}}" />
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="txt_bp_sys" class="col-form-label col-form-label-sm">BP
                                                    (mmHg)</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control form-control-sm" id="txt_bp_sys" name="txt_bp_sys" value="{{isset($anaesthetist_record_data->bp_mmhg) ? $anaesthetist_record_data->bp_mmhg :''}}" />
                                                    &nbsp; / &nbsp;
                                                    <input type="text" class="form-control form-control-sm" id="txt_bp_dia" name="txt_bp_dia" value="{{isset($anaesthetist_record_data->bp_mmhg_2) ? $anaesthetist_record_data->bp_mmhg_2 :''}}" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="ptHeart" class="col-form-label col-form-label-sm">Heart</label>
                                                <input type="text" class="form-control form-control-sm" id="ptHeart" name="ptHeart" placeholder="" value="{{isset($anaesthetist_record_data->heart) ? $anaesthetist_record_data->heart :''}}" />
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="ptLungs" class="col-form-label col-form-label-sm">Lungs</label>
                                                <input type="text" class="form-control form-control-sm" id="ptLungs" name="ptLungs" placeholder="" value="{{isset($anaesthetist_record_data->lungs) ? $anaesthetist_record_data->lungs :''}}" />
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="ptTeeth" class="col-form-label col-form-label-sm">Teeth</label>
                                                <input type="text" class="form-control form-control-sm" id="ptTeeth" name="ptTeeth" placeholder="" value="{{isset($anaesthetist_record_data->teeth) ? $anaesthetist_record_data->teeth :''}}" />
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="ptAnaemia" class="col-form-label col-form-label-sm">Anaemia</label>
                                                <input type="text" class="form-control form-control-sm" id="ptAnaemia" name="ptAnaemia" placeholder="" value="{{isset($anaesthetist_record_data->anaemia) ? $anaesthetist_record_data->anaemia :''}}" />
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="ptHb" class="col-form-label col-form-label-sm">HB%</label>
                                                <input type="text" class="form-control form-control-sm" id="ptHb" name="ptHb" placeholder="" value="{{isset($anaesthetist_record_data->hb) ? $anaesthetist_record_data->hb :''}}" />
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="ptFbsRbs" class="col-form-label col-form-label-sm">
                                                    <div class="form-check form-check-inline" style="margin-right: 0px;">
                                                        <input class="form-check-input" type="radio" name="inlineFbsRbs" id="inlineFbs1" value="FBS" @if ( isset($anaesthetist_record_data->fbs_rbs) && $anaesthetist_record_data->fbs_rbs == "FBS") checked @endif />
                                                        <label class="form-check-label" for="inlineFbs1">FBS</label>
                                                    </div>
                                                    &nbsp;/&nbsp;
                                                    <div class="form-check form-check-inline" style="margin-right: 0px;">
                                                        <input class="form-check-input" type="radio" name="inlineFbsRbs" id="inlineFbsRbs2" value="RBS" @if ( isset($anaesthetist_record_data->fbs_rbs) && $anaesthetist_record_data->fbs_rbs == "RBS") checked @endif />
                                                        <label class="form-check-label" for="inlineFbsRbs2">RBS</label>
                                                    </div>
                                                </label>
                                                <input type="text" class="form-control form-control-sm" id="ptFbsRbs" name="ptFbsRbs" placeholder="" value="{{isset($anaesthetist_record_data->fbs_rbs_text) ? $anaesthetist_record_data->fbs_rbs_text :''}}" />
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="ptBrea" class="col-form-label col-form-label-sm">B.
                                                    Urea</label>
                                                <input type="text" class="form-control form-control-sm" id="ptBrea" name="ptBrea" placeholder="" value="{{isset($anaesthetist_record_data->b_urea) ? $anaesthetist_record_data->b_urea :''}}" />
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="ptScreatinine" class="col-form-label col-form-label-sm">S.
                                                    Creatinine</label>
                                                <input type="text" class="form-control form-control-sm" id="ptScreatinine" name="ptScreatinine" placeholder="" value="{{isset($anaesthetist_record_data->s_creatinine) ? $anaesthetist_record_data->s_creatinine :''}}" />
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="ptSbilirubin" class="col-form-label col-form-label-sm">S.
                                                    Bilirubin</label>
                                                <input type="text" class="form-control form-control-sm" id="ptSbilirubin" name="ptSbilirubin" placeholder="" value="{{isset($anaesthetist_record_data->s_bilirubin) ? $anaesthetist_record_data->s_bilirubin :''}}" />
                                            </div>
                                        </div>

                                        <!-- <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="ptGri"
                                                    class="col-form-label col-form-label-sm">GRI</label>
                                                <input type="text" class="form-control form-control-sm"
                                                    id="ptGri" name="ptGri" placeholder="" value="{{isset($anaesthetist_record_data->gri) ? $anaesthetist_record_data->gri :''}}" />
                                            </div>
                                        </div> -->

                                        {{-- <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="ptSbilirubin" class="col-form-label col-form-label-sm">S.
                                                    Bilirubin</label>
                                                <input type="text" class="form-control form-control-sm"
                                                    id="ptSbilirubin" name="ptSbilirubin" placeholder="" value="{{isset($anaesthetist_record_data->fbs_rbs_text) ? $anaesthetist_record_data->fbs_rbs_text :''}}" />
                                    </div>
                                </div> --}}
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="ptCxr" class="col-form-label col-form-label-sm">CXR</label>
                                        <input type="text" class="form-control form-control-sm" id="ptCxr" name="ptCxr" placeholder="" value="{{isset($anaesthetist_record_data->cxr) ? $anaesthetist_record_data->cxr :''}}" />
                                    </div>
                                </div>
                                <!-- <div class="col-md-12">
                                            <fieldset>
                                                <legend style="font-size: 16px;">Rreoperative advice</legend>
                                                <div class="form-group">
                                                    @php
                                                       $Rreoperative=  isset($anaesthetist_record_data->for_anaesthetist) ? $anaesthetist_record_data->for_anaesthetist :'';
                                                    @endphp
                                                    <input type="hidden" name="editor_content" id="editor_content" value="{{$Rreoperative}}">
                                                    <label for="editor1">For Anaesthetist</label>
                                                    {{-- <textarea class="form-control form-control-sm" id="forAnaesthetist" rows="3"></textarea> --}}
                                                    <textarea id="editor1" name="lotha" class="ckeditor"
                                                    style="height: 60vh">
                                                <?php echo  $Rreoperative ?>
                                                </textarea>
                                                </div>
                                            </fieldset>
                                        </div> -->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="ptEcg" class="col-form-label col-form-label-sm">ECG</label>
                                        <textarea class="form-control form-control-sm" id="ptEcg" name="ptEcg" rows="3">{{isset($anaesthetist_record_data->ecg) ? $anaesthetist_record_data->ecg :''}}</textarea>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <fieldset>
                                        <legend style="font-size: 16px;">S. Electrolyles</legend>
                                        <div class="form-row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="ptNa__" class="col-form-label col-form-label-sm">NA+</label>
                                                    <input type="text" class="form-control form-control-sm" id="ptNa__" name="ptNa__" placeholder="" value="{{isset($anaesthetist_record_data->electrolyles_na) ? $anaesthetist_record_data->electrolyles_na :''}}" />
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="ptK__" class="col-form-label col-form-label-sm">K+</label>
                                                    <input type="text" class="form-control form-control-sm" id="ptK__" name="ptK__" placeholder="" value="{{isset($anaesthetist_record_data->electrolyles_k) ? $anaesthetist_record_data->electrolyles_k :''}}" />
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="ptCi__" class="col-form-label col-form-label-sm">Ci</label>
                                                    <input type="text" class="form-control form-control-sm" id="ptCi__" name="ptCi__" placeholder="" value="{{isset($anaesthetist_record_data->electrolyles_ci) ? $anaesthetist_record_data->electrolyles_ci :''}}" />
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="echo" class="col-form-label col-form-label-sm">Echo</label>
                                        <textarea class="form-control form-control-sm" id="echo" name="echo" rows="3">{{isset($anaesthetist_record_data->echo) ? $anaesthetist_record_data->echo :''}}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="consent" class="col-form-label col-form-label-sm">Consent</label>
                                        <input type="text" name="consent" class="form-control form-control-sm" value="{{isset($anaesthetist_record_data->consent) ? $anaesthetist_record_data->consent :''}}">

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="fasting" class="col-form-label col-form-label-sm">Fasting</label>
                                        <input type="text" name="fasting" class="form-control form-control-sm" value="{{isset($anaesthetist_record_data->fasting) ? $anaesthetist_record_data->fasting :''}}">

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="premed_taken" class="col-form-label col-form-label-sm">Premed taken</label>
                                        <input type="text" name="premed_taken" class="form-control form-control-sm" value="{{isset($anaesthetist_record_data->premed_taken) ? $anaesthetist_record_data->premed_taken :''}}">

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="blood_available" class="col-form-label col-form-label-sm">Blood available</label>
                                        <input type="text" name="blood_available" class="form-control form-control-sm" value="{{isset($anaesthetist_record_data->blood_available) ? $anaesthetist_record_data->blood_available :''}}">

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="anesthesia_machine_check" class="col-form-label col-form-label-sm">Anesthesia Machine check</label>
                                        <input type="text" name="anesthesia_machine_check" class="form-control form-control-sm" value="{{isset($anaesthetist_record_data->anes_mach_check) ? $anaesthetist_record_data->anes_mach_check :''}}">

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="suction_check" class="col-form-label col-form-label-sm">Suction check</label>
                                        <input type="text" name="suction_check" class="form-control form-control-sm" value="{{isset($anaesthetist_record_data->suction_check) ? $anaesthetist_record_data->suction_check :''}}">

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="scavenger_check" class="col-form-label col-form-label-sm">Scavenger check</label>
                                        <input type="text" name="scavenger_check" class="form-control form-control-sm" value="{{isset($anaesthetist_record_data->scavenger_check) ? $anaesthetist_record_data->scavenger_check :''}}">

                                    </div>
                                </div>
                                <!-- <div class="col-lg-4 col-md-4">
                                            <div class="form-group"
                                                style="display: flex; align-items: center; gap: 15px;">
                                                <label for="ptAsthme" class="col-form-label col-form-label-sm">Asthme
                                                    :</label>
                                                <div class="form-check form-check-inline" style="margin-right: 0px;">
                                                    <input class="form-check-input" type="radio"
                                                        name="inlineRadioAsthme" id="inlineAsthme1"
                                                        value="(+)"  @if ( isset($anaesthetist_record_data->asthme) && $anaesthetist_record_data->asthme == "(+)") checked @endif  />
                                                    <label class="form-check-label" for="inlineAsthme1">(+)</label>
                                                </div>
                                                <div class="form-check form-check-inline" style="margin-right: 0px;">
                                                    <input class="form-check-input" type="radio"
                                                        name="inlineRadioAsthme" id="inlineAsthme2"
                                                        value="(-)"  @if ( isset($anaesthetist_record_data->asthme) && $anaesthetist_record_data->asthme == "(-)") checked @endif />
                                                    <label class="form-check-label" for="inlineAsthme2">(-)</label>
                                                </div>
                                            </div>
                                        </div> -->



                                <div class="col-lg-4 col-md-4">
                                    <div class="form-group" style="display: flex; align-items: center; gap: 15px;">
                                        <label for="ptChestPain" class="col-form-label col-form-label-sm">Chest Pain</label>
                                        <div class="form-check form-check-inline" style="margin-right: 0px;">
                                            <input class="form-check-input" type="radio" name="inlineRadioChestPain" id="inlineChestPain1" value="(+)" @if ( isset($anaesthetist_record_data->chest_pain) && $anaesthetist_record_data->chest_pain == "(+)") checked @endif />
                                            <label class="form-check-label" for="inlineChestPain1">(+)</label>
                                        </div>
                                        <div class="form-check form-check-inline" style="margin-right: 0px;">
                                            <input class="form-check-input" type="radio" name="inlineRadioChestPain" id="inlineChestPain2" value="(-)" @if ( isset($anaesthetist_record_data->chest_pain) && $anaesthetist_record_data->chest_pain == "(-)") checked @endif />
                                            <label class="form-check-label" for="inlineChestPain2">(-)</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group" style="display: flex; align-items: center; gap: 15px;">
                                        <label for="ptAsaClass" class="col-form-label col-form-label-sm">ASA
                                            Class</label>

                                        <div class="form-check form-check-inline" style="margin-right: 0px;">
                                            <input class="form-check-input" type="radio" name="inlineRadioAsaClass" id="inlineAsaClass1" value="1" @if ( isset($anaesthetist_record_data->asa_class) && $anaesthetist_record_data->asa_class == "1") checked @endif />
                                            <label class="form-check-label" for="inlineAsaClass1">1</label>
                                        </div>
                                        <div class="form-check form-check-inline" style="margin-right: 0px;">
                                            <input class="form-check-input" type="radio" name="inlineRadioAsaClass" id="inlineAsaClass2" value="2" @if ( isset($anaesthetist_record_data->asa_class) && $anaesthetist_record_data->asa_class == "2") checked @endif />
                                            <label class="form-check-label" for="inlineAsaClass2">2</label>
                                        </div>
                                        <div class="form-check form-check-inline" style="margin-right: 0px;">
                                            <input class="form-check-input" type="radio" name="inlineRadioAsaClass" id="inlineAsaClass3" value="3" @if ( isset($anaesthetist_record_data->asa_class) && $anaesthetist_record_data->asa_class == "AsaClass2") checked @endif />
                                            <label class="form-check-label" for="inline3">3</label>
                                        </div>
                                        <div class="form-check form-check-inline" style="margin-right: 0px;">
                                            <input class="form-check-input" type="radio" name="inlineRadioAsaClass" id="inlineAsaClass4" value="4" @if ( isset($anaesthetist_record_data->asa_class) && $anaesthetist_record_data->asa_class == "4") checked @endif />
                                            <label class="form-check-label" for="inlineAsaClass4">4</label>
                                        </div>
                                        <div class="form-check form-check-inline" style="margin-right: 0px;">
                                            <input class="form-check-input" type="radio" name="inlineRadioAsaClass" id="inlineAsaClass5" value="5" @if ( isset($anaesthetist_record_data->asa_class) && $anaesthetist_record_data->asa_class == "5") checked @endif />
                                            <label class="form-check-label" for="inlineAsaClass5">5</label>
                                        </div>
                                        <div class="form-check form-check-inline" style="margin-right: 0px;">
                                            <input class="form-check-input" type="radio" name="inlineRadioAsaClass" id="inlineAsaClass6" value="E" @if ( isset($anaesthetist_record_data->asa_class) && $anaesthetist_record_data->asa_class == "E") checked @endif />
                                            <label class="form-check-label" for="inlineAsaClass6">E</label>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group">
                                        <label for="ptNyha" class="col-form-label col-form-label-sm">NYHA</label>
                                        <input type="text" class="form-control form-control-sm" id="ptNyha" name="ptNyha" placeholder="" value="{{isset($anaesthetist_record_data->nyha) ? $anaesthetist_record_data->nyha :''}}" />
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group" style="display: flex; align-items: center; gap: 15px;">
                                        <label for="ptMallampatiGrading" class="col-form-label col-form-label-sm">Mallampati Grading</label>
                                        <div class="form-check form-check-inline" style="margin-right: 0px;">
                                            <input class="form-check-input" type="radio" name="inlineRadioMallampatiGrading" id="inlineMallampatiGrading1" value="1" @if ( isset($anaesthetist_record_data->mallampati_grading) && $anaesthetist_record_data->mallampati_grading == "1") checked @endif />
                                            <label class="form-check-label" for="inlineMallampatiGrading1">1</label>
                                        </div>
                                        <div class="form-check form-check-inline" style="margin-right: 0px;">
                                            <input class="form-check-input" type="radio" name="inlineRadioMallampatiGrading" id="inlineMallampatiGrading2" value="2" @if ( isset($anaesthetist_record_data->mallampati_grading) && $anaesthetist_record_data->mallampati_grading == "2") checked @endif />
                                            <label class="form-check-label" for="inlineMallampatiGrading2">2</label>
                                        </div>
                                        <div class="form-check form-check-inline" style="margin-right: 0px;">
                                            <input class="form-check-input" type="radio" name="inlineRadioMallampatiGrading" id="inlineMallampatiGrading3" value="3" @if ( isset($anaesthetist_record_data->mallampati_grading) && $anaesthetist_record_data->mallampati_grading == "3") checked @endif />
                                            <label class="form-check-label" for="inlineMallampatiGrading3">3</label>
                                        </div>
                                        <div class="form-check form-check-inline" style="margin-right: 0px;">
                                            <input class="form-check-input" type="radio" name="inlineRadioMallampatiGrading" id="inlineMallampatiGrading4" value="4" @if ( isset($anaesthetist_record_data->mallampati_grading) && $anaesthetist_record_data->mallampati_grading == "4") checked @endif />
                                            <label class="form-check-label" for="inlineMallampatiGrading4">4</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="ptOthers" class="col-form-label col-form-label-sm">Pre induction assessment by attending Anesthesiologis</label>
                                        <textarea class="form-control form-control-sm" id="ptOthers" name="ptOthers" rows="3">
                                        {{isset($anaesthetist_record_data->others) ? $anaesthetist_record_data->others :''}}
                                        </textarea>
                                    </div>
                                </div>

                                <!-- <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="ptAnaesthDrug"
                                                    class="col-form-label col-form-label-sm">Maintenance drugs related
                                                    to anaesthesia</label>
                                                <textarea class="form-control form-control-sm" id="ptAnaesthDrug" name="ptAnaesthDrug" rows="3">
                                                    {{isset($anaesthetist_record_data->maintenance_drugs) ? $anaesthetist_record_data->maintenance_drugs :''}}
                                                </textarea>
                                            </div>
                                        </div> -->
                            </div>

                            <div class="row justify-content-end">
                                <div class="col-md-6">
                                    <fieldset>
                                        <legend style="font-size: 16px;">Assessed by :</legend>
                                        <div class="form-row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="drName" class="col-form-label col-form-label-sm">Dr.
                                                        Name</label>
                                                    <input type="text" class="form-control form-control-sm" id="drName" name="assessed_doctor_name" placeholder="Dr. Name" value="{{isset($anaesthetist_record_data->doctor_name) ? $anaesthetist_record_data->doctor_name :''}}" />
                                                    <input type="hidden" name="hdn_assessed_doctor_id" id="hdn_assessed_doctor_id" value="{{isset($anaesthetist_record_data->doctor_no_fk) ? $anaesthetist_record_data->doctor_no_fk :''}}">
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="DateOfAsses" class="col-form-label col-form-label-sm">Date of
                                                        Assessment</label>
                                                    <input type="text" class="form-control form-control-sm date_picker" placeholder="dd-mm-YYYY" id="DateOfAsses" name="DateOfAsses" name="DateOfAsses" value="{{isset($anaesthetist_record_data->assessment_date) ? date('d-m-Y',strtotime($anaesthetist_record_data->assessment_date)) :''}}" />
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
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
                                        <label for="ptAdvice" class="col-form-label col-form-label-sm">Advice</label>
                                        <textarea class="form-control form-control-sm" id="ptAdvice" name="ptAdvice" rows="3">
                                        {{isset($anaesthetist_record_data->preoperative_advice) ? $anaesthetist_record_data->preoperative_advice :''}}

                                        </textarea>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="ptDateOpn" class="col-form-label col-form-label-sm">Date
                                            of Opn</label>
                                        <input type="text" class="form-control form-control-sm date_picker" placeholder="dd-mm-YYYY" id="ptDateOpn" name="ptDateOpn" value="{{isset($anaesthetist_record_data->opn_date) ? date('d-m-Y',strtotime($anaesthetist_record_data->opn_date)) :''}}" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="ptSurgon" class="col-form-label col-form-label-sm">Surgon
                                            Name</label>
                                        <input type="text" class="form-control form-control-sm" id="ptSurgon" name="ptSurgon" value="{{isset($anaesthetist_record_data->surgon_name) ? $anaesthetist_record_data->surgon_name :''}}" />
                                        <input type="hidden" name="hdn_surgon_doctor_id" id="hdn_surgon_doctor_id" value="{{isset($anaesthetist_record_data->surgon_person_no_fk) ? $anaesthetist_record_data->surgon_person_no_fk :''}}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="ptOpn" class="col-form-label col-form-label-sm">Opn</label>
                                        <input type="text" class="form-control form-control-sm" id="ptOpn" name="ptOpn" value="{{isset($anaesthetist_record_data->opn) ? $anaesthetist_record_data->opn :''}}" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="ptAnaesth" class="col-form-label col-form-label-sm">Anaesth</label>
                                        <input type="text" class="form-control form-control-sm" id="ptAnaesth" name="ptAnaesth" value="{{isset($anaesthetist_record_data->anaesth) ? $anaesthetist_record_data->anaesth :''}}" />
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="ptAnaesthTec" class="col-form-label col-form-label-sm">Anesthesia Technique
                                        </label>
                                        <!-- <input type="text" class="form-control form-control-sm" id="ptAnaesthTec" /> -->
                                        <textarea class="form-control form-control-sm" id="ptAnaesthTec" name="ptAnaesthTec" rows="3">
                                        {{isset($anaesthetist_record_data->anaesthetic_technique) ? $anaesthetist_record_data->anaesthetic_technique :''}}
                                        </textarea>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <fieldset>
                                        <legend>GA/RA/MAC :</legend>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="inlineAccepted" id="inlineGA1" value="GA" {{isset($anaesthetist_record_data->accepted_for) && $anaesthetist_record_data->accepted_for == "GA" ?  'checked'  : ''}} />
                                            <label class="form-check-label" for="inlineGA1">GA</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="inlineAccepted" id="inlineSA2" value="SA" @if ( isset($anaesthetist_record_data->accepted_for) && $anaesthetist_record_data->accepted_for == "SA") checked @endif />
                                            <label class="form-check-label" for="inlineSA2">SA</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="inlineAccepted" id="inlineEA3" value="EA" @if ( isset($anaesthetist_record_data->accepted_for) && $anaesthetist_record_data->accepted_for == "EA") checked @endif />
                                            <label class="form-check-label" for="inlineEA3">EA</label>
                                        </div>
                                    </fieldset>
                                </div>
                                <div class="col-md-3">
                                    <fieldset style="margin-top: 34px;">
                                        <div class="form-check form-check-inline" style="margin-right: 0px;">
                                            <input class="form-check-input" type="radio" name="inlineRadioEpCaSp" id="inlineEpCaSp1" value="Epidural" @if ( isset($anaesthetist_record_data->inlineradioepcasp) && $anaesthetist_record_data->inlineradioepcasp == "Epidural") checked @endif />
                                            <label class="form-check-label" for="inlineEpCaSp1">Epidural</label>
                                        </div>
                                        &nbsp;/&nbsp;
                                        <div class="form-check form-check-inline" style="margin-right: 0px;">
                                            <input class="form-check-input" type="radio" name="inlineRadioEpCaSp" id="inlineEpCaSp2" value="Caudal" @if ( isset($anaesthetist_record_data->inlineradioepcasp) && $anaesthetist_record_data->inlineradioepcasp == "Caudal") checked @endif />
                                            <label class="form-check-label" for="inlineEpCaSp2">Caudal</label>
                                        </div>
                                        &nbsp;/&nbsp;
                                        <div class="form-check form-check-inline" style="margin-right: 0px;">
                                            <input class="form-check-input" type="radio" name="inlineRadioEpCaSp" id="inlineEpCaSp3" value="Spinal" @if ( isset($anaesthetist_record_data->inlineradioepcasp) && $anaesthetist_record_data->inlineradioepcasp == "Spinal") checked @endif />
                                            <label class="form-check-label" for="inlineEpCaSp3">Spinal</label>
                                        </div>
                                    </fieldset>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="technique_others" class="col-form-label col-form-label-sm">Others</label>
                                        <input type="text" class="form-control form-control-sm" id="technique_others" name="technique_others" value=" {{isset($anaesthetist_record_data->technique_others) ? $anaesthetist_record_data->technique_others :''}}" />
                                    </div>
                                </div>
                                <!-- <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="ptO2" class="col-form-label col-form-label-sm">O2
                                            (%)</label>
                                        <input type="text" class="form-control form-control-sm" id="ptO2" name="ptO2" value=" {{isset($anaesthetist_record_data->o2) ? $anaesthetist_record_data->o2 :''}}" />
                                    </div>
                                </div> -->

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="ptDmim" class="col-form-label col-form-label-sm">Dmim<sup>-1</sup>
                                            (%)</label>
                                        <input type="text" class="form-control form-control-sm" id="ptDmim" name="ptDmim" value="{{isset($anaesthetist_record_data->dmim) ? $anaesthetist_record_data->dmim :''}}" />
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="ptN2O" class="col-form-label col-form-label-sm">N2O
                                            (%)</label>
                                        <input type="text" class="form-control form-control-sm" id="ptN2O" name="ptN2O" value="{{isset($anaesthetist_record_data->n20) ? $anaesthetist_record_data->n20 :''}}" />
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="ptLmim" class="col-form-label col-form-label-sm">Lmim<sup>-1</sup>
                                            (%)</label>
                                        <input type="text" class="form-control form-control-sm" id="ptLmim" name="ptLmim" value="{{isset($anaesthetist_record_data->lmim) ? $anaesthetist_record_data->lmim :''}}" />
                                    </div>
                                </div>

                                <!-- <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="ptAir" class="col-form-label col-form-label-sm">Air
                                            (%)</label>
                                        <input type="text" class="form-control form-control-sm" id="ptAir" name="ptAir" value="{{isset($anaesthetist_record_data->air) ? $anaesthetist_record_data->air :''}}" />
                                    </div>
                                </div> -->

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="ptLmimHalo" class="col-form-label col-form-label-sm">Lmim
                                            Halo (%)</label>
                                        <input type="text" class="form-control form-control-sm" id="ptLmimHalo" name="ptLmimHalo" value="{{isset($anaesthetist_record_data->lmim_halo) ? $anaesthetist_record_data->lmim_halo :''}}" />
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <fieldset>
                                        <legend>Ciccuit Used :</legend>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="inlineCircle" value="Circle" name="circle" @if ( isset($anaesthetist_record_data->ciccuit_circle) && $anaesthetist_record_data->ciccuit_circle == "Circle") checked @endif />
                                            <label class="form-check-label" for="inlineCircle">Circle</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="inlineBain" name="inlineBain" value="Bain" @if ( isset($anaesthetist_record_data->ciccuit_bain) && $anaesthetist_record_data->ciccuit_bain == "Bain") checked @endif />
                                            <label class="form-check-label" for="inlineBain">Bain</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="inlineTpiece" name="inlineTpiece" value="T Piece" @if ( isset($anaesthetist_record_data->ciccuit_t_piece) && $anaesthetist_record_data->ciccuit_t_piece == "T Piece") checked @endif />
                                            <label class="form-check-label" for="inlineTpiece">T Piece</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="inlineMagills" name="inlineMagills" value="Magill's" @if ( isset($anaesthetist_record_data->ciccuit_magill) && $anaesthetist_record_data->ciccuit_magill == "Magill's") checked @endif />
                                            <label class="form-check-label" for="inlineMagills">Magill's</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="inlineMAPDSodalime" name="inlineMAPDSodalime" value="MAP. D.Sodalime" @if ( isset($anaesthetist_record_data->ciccuit_sodalime) && $anaesthetist_record_data->ciccuit_sodalime == "MAP. D.Sodalime") checked @endif />

                                            <label class="form-check-label" for="inlineMAPDSodalime">MAP. D.Sodalime</label>
                                        </div>
                                    </fieldset>
                                </div>

                                <div class="col-md-12">
                                    <fieldset>
                                        <legend>Monitoring :</legend>
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label" for="inlinePules">Pules </label>
                                            <input class="form-check-input form-control" type="text" id="inlinePules" name="inlinePules" value="{{isset($anaesthetist_record_data->monitoring_pules) ? $anaesthetist_record_data->monitoring_pules :''}}" />
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label" for="inlineBP">BP</label>
                                            <input class="form-check-input form-control" type="text" id="inlineBP" name="inlineBP" value="{{isset($anaesthetist_record_data->monitoring_bp)? $anaesthetist_record_data->monitoring_bp :''}}" />

                                        </div>
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label " for="inlineECG">ECG</label>
                                            <input class="form-check-input form-control" type="text" id="inlineECG" name="inlineECG" value="{{isset($anaesthetist_record_data->monitoring_ecg) ? $anaesthetist_record_data->monitoring_ecg :''}}" />

                                        </div>
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label" for="inlineSPO">SPO<sub>2</sub></label>
                                            <input class="form-check-input form-control" type="text" id="inlineSPO" name="inlineSPO" value="{{isset($anaesthetist_record_data->monitoring_spo) ?  $anaesthetist_record_data->monitoring_spo :''}}" />

                                        </div>
                                        <div class="form-check form-check-inline mt-2">
                                            <label class="form-check-label" for="inlinePTCO">ETCO<sub>2</sub></label>
                                            <input class="form-check-input form-control" type="text" id="inlinePTCO" name="inlinePTCO" value="{{isset($anaesthetist_record_data->monitoring_ptco) ? $anaesthetist_record_data->monitoring_ptco :''}}" />

                                        </div>



                                        <div class="form-check form-check-inline mt-2">
                                            <label class="form-check-label" for="nibp">NIBP</label>
                                            <input class="form-check-input form-control" type="text" id="nibp" name="nibp" value="{{isset($anaesthetist_record_data->nibp) ? $anaesthetist_record_data->nibp :''}}" />

                                        </div>
                                        <div class="form-check form-check-inline mt-2">
                                            <label class="form-check-label" for="fio2">FiO <sub>2</sub> </label>
                                            <input class="form-check-input form-control" type="text" id="fio2" name="fio2" value="{{isset($anaesthetist_record_data->fio2) ? $anaesthetist_record_data->fio2 :''}}" />

                                        </div>
                                        <div class="form-check form-check-inline mt-2">
                                            <label class="form-check-label" for="temp">Temp</label>
                                            <input class="form-check-input form-control" type="text" id="temp" name="temp" value="{{isset($anaesthetist_record_data->temp) ? $anaesthetist_record_data->temp :''}}" />

                                        </div>
                                        <div class="form-check form-check-inline mt-2">
                                            <label class="form-check-label" for="agent_monitor">Agent Monitor</label>
                                            <input class="form-check-input form-control" type="text" id="agent_monitor" name="agent_monitor" value="{{isset($anaesthetist_record_data->agent_monitor) ? $anaesthetist_record_data->agent_monitor :''}}" />

                                        </div>
                                        <div class="form-check form-check-inline mt-2">
                                            <label class="form-check-label" for="nmb_monitor">NMB Monitor</label>
                                            <input class="form-check-input form-control" type="text" id="nmb_monitor" name="nmb_monitor" value="{{isset($anaesthetist_record_data->nmb_monitor) ? $anaesthetist_record_data->nmb_monitor :''}}" />

                                        </div>
                                        <div class="form-check form-check-inline mt-2">
                                            <label class="form-check-label" for="cvp">CVP (site & cannula)</label>
                                            <input class="form-check-input form-control" type="text" id="cvp" name="cvp" value="{{isset($anaesthetist_record_data->cvp) ? $anaesthetist_record_data->cvp :''}}" />

                                        </div>
                                        <div class="form-check form-check-inline mt-2">
                                            <label class="form-check-label" for="art_line">Art line( Site & cannula)</label>
                                            <input class="form-check-input form-control" type="text" id="art_line" name="art_line" value="{{isset($anaesthetist_record_data->art_line) ? $anaesthetist_record_data->art_line :''}}" />

                                        </div>
                                        <div class="form-check form-check-inline mt-2">
                                            <label class="form-check-label" for="ng_tube">NG tube</label>
                                            <input class="form-check-input form-control" type="text" id="ng_tube" name="ng_tube" value="{{isset($anaesthetist_record_data->ng_tube) ? $anaesthetist_record_data->ng_tube :''}}" />

                                        </div>
                                        <div class="form-check form-check-inline mt-2">
                                            <label class="form-check-label" for="urinary_catheter">Urinary catheter</label>
                                            <input class="form-check-input form-control" type="text" id="urinary_catheter" name="urinary_catheter" value="{{isset($anaesthetist_record_data->urinary_catheter) ? $anaesthetist_record_data->urinary_catheter :''}}" />

                                        </div>
                                        <div class="form-check form-check-inline mt-2">
                                            <label class="form-check-label" for="monitoring_others">Others</label>
                                            <input class="form-check-input form-control" type="text" id="monitoring_others" name="monitoring_others" value="{{isset($anaesthetist_record_data->monitoring_others) ? $anaesthetist_record_data->monitoring_others :''}}" />

                                        </div>
                                    </fieldset>
                                </div>
                                <div class="col-md-12">
                                    <h3>Positioning</h3>
                                </div>
                                <div class="col-md-3">
                                    <label for="supine"> Supine</label>
                                    <input type="text" class="form-control" name="supine" value="{{isset($anaesthetist_record_data->supine) ? $anaesthetist_record_data->supine :''}}">
                                </div>
                                <div class="col-md-3">
                                    <label for="lithotomy"> Lithotomy</label>
                                    <input type="text" class="form-control" name="lithotomy" value="{{isset($anaesthetist_record_data->lithotomy) ? $anaesthetist_record_data->lithotomy :''}}">
                                </div>
                                <div class="col-md-3">
                                    <label for="prone"> Prone</label>
                                    <input type="text" class="form-control" name="prone" value="{{isset($anaesthetist_record_data->prone) ? $anaesthetist_record_data->prone :''}}">
                                </div>
                                <div class="col-md-3">
                                    <label for="lateral_r_l"> Lateral-R / L</label>
                                    <input type="text" class="form-control" name="lateral_r_l" value="{{isset($anaesthetist_record_data->lateral_r_l) ? $anaesthetist_record_data->lateral_r_l :''}}">
                                </div>
                                <div class="col-md-3">
                                    <label for="positioning_others"> Others</label>
                                    <input type="text" class="form-control" name="positioning_others" value="{{isset($anaesthetist_record_data->positioning_others) ? $anaesthetist_record_data->positioning_others :''}}">
                                </div>
                                <div class="col-md-3">
                                    <label for="eye_protected"> Eye protected</label>
                                    <input type="text" class="form-control" name="eye_protected" value="{{isset($anaesthetist_record_data->eye_protected) ? $anaesthetist_record_data->eye_protected :''}}">
                                </div>
                                <div class="col-md-3">
                                    <label for="p_point_padded"> P point padded</label>
                                    <input type="text" class="form-control" name="p_point_padded" value="{{isset($anaesthetist_record_data->p_point_padded) ? $anaesthetist_record_data->p_point_padded :''}}">
                                </div>
                                <div class="col-md-3">
                                    <label for="troniquet">Troniquet</label>
                                    <input type="text" class="form-control" name="troniquet" value="{{isset($anaesthetist_record_data->troniquet) ? $anaesthetist_record_data->troniquet :''}}">
                                </div>
                                <div class="col-md-12">
                                    <h3>Intubation</h3>
                                </div>
                                <div class="col-md-3">
                                    <label for="asleep">Asleep</label>
                                    <input type="text" class="form-control" name="asleep" value="{{isset($anaesthetist_record_data->asleep) ? $anaesthetist_record_data->asleep :''}}">
                                </div>
                                <div class="col-md-3">
                                    <label for="direct">Direct</label>
                                    <input type="text" class="form-control" name="direct" value="{{isset($anaesthetist_record_data->direct) ? $anaesthetist_record_data->direct :''}}">
                                </div>
                                <div class="col-md-3">
                                    <label for="oral">Oral</label>
                                    <input type="text" class="form-control" name="oral" value="{{isset($anaesthetist_record_data->oral) ? $anaesthetist_record_data->oral :''}}">
                                </div>
                                <div class="col-md-3">
                                    <label for="awake">Awake</label>
                                    <input type="text" class="form-control" name="awake" value="{{isset($anaesthetist_record_data->awake) ? $anaesthetist_record_data->awake :''}}">
                                </div>
                                <div class="col-md-3">
                                    <label for="blind">Blind</label>
                                    <input type="text" class="form-control" name="blind" value="{{isset($anaesthetist_record_data->blind) ? $anaesthetist_record_data->blind :''}}">
                                </div>
                                <div class="col-md-3">
                                    <label for="nasal_r_l">Nasal- R / L</label>
                                    <input type="text" class="form-control" name="nasal_r_l" value="{{isset($anaesthetist_record_data->nasal_r_l) ? $anaesthetist_record_data->nasal_r_l :''}}">
                                </div>
                                <div class="col-md-3">
                                    <label for="in_situ">In Situ</label>
                                    <input type="text" class="form-control" name="in_situ" value="{{isset($anaesthetist_record_data->in_situ) ? $anaesthetist_record_data->in_situ :''}}">
                                </div>
                                <div class="col-md-3">
                                    <label for="fibreoptic">Fibreoptic</label>
                                    <input type="text" class="form-control" name="fibreoptic" value="{{isset($anaesthetist_record_data->fibreoptic) ? $anaesthetist_record_data->fibreoptic :''}}">
                                </div>
                                <div class="col-md-3">
                                    <label for="tracheostomy">Tracheostomy</label>
                                    <input type="text" class="form-control" name="tracheostomy" value="{{isset($anaesthetist_record_data->tracheostomy) ? $anaesthetist_record_data->tracheostomy :''}}">
                                </div>
                                <div class="col-md-3">
                                    <label for="rapid_sequence">Rapid sequence</label>
                                    <input type="text" class="form-control" name="rapid_sequence" value="{{isset($anaesthetist_record_data->rapid_sequence) ? $anaesthetist_record_data->rapid_sequence :''}}">
                                </div>
                                <div class="col-md-3">
                                    <label for="ventilation_easy_difficult">Mask ventilation- Easy / Difficult</label>
                                    <input type="text" class="form-control" name="ventilation_easy_difficult" value="{{isset($anaesthetist_record_data->ventilation_easy_difficult) ? $anaesthetist_record_data->ventilation_easy_difficult :''}}">
                                </div>
                                <div class="col-md-3">
                                    <label for="external_laryngeal_manipulation">External Laryngeal manipulation</label>
                                    <input type="text" class="form-control" name="external_laryngeal_manipulation" value="{{isset($anaesthetist_record_data->ext_lary_maniptn) ? $anaesthetist_record_data->ext_lary_maniptn :''}}">
                                </div>
                                <div class="col-md-3">
                                    <label for="stylet_bogie">Stylet/ Bogie</label>
                                    <input type="text" class="form-control" name="stylet_bogie" value="{{isset($anaesthetist_record_data->stylet_bogie) ? $anaesthetist_record_data->stylet_bogie :''}}">
                                </div>
                                <div class="col-md-3">
                                    <label for="intubation_grade">Intubation grade</label>
                                    <input type="text" class="form-control" name="intubation_grade" value="{{isset($anaesthetist_record_data->intubation_grade) ? $anaesthetist_record_data->intubation_grade :''}}">
                                </div>
                                <div class="col-md-3">
                                    <label for="throat_pack">Throat pack</label>
                                    <input type="text" class="form-control" name="throat_pack" value="{{isset($anaesthetist_record_data->throat_pack) ? $anaesthetist_record_data->throat_pack :''}}">
                                </div>

                                <div class="col-md-12">
                                    <fieldset>
                                        <legend>Condition on leaving Q.T :</legend>

                                        <div class="form-check form-check-inline" style="margin-right: 0px;">
                                            <input class="form-check-input" type="radio" name="inlineRadioAwRoAs" id="inlineAwRoAs1" value="Awake" @if ( isset($anaesthetist_record_data->conditioning_leaving) && $anaesthetist_record_data->conditioning_leaving == "Awake") checked @endif />
                                            <label class="form-check-label" for="inlineAwRoAs1">Awake</label>
                                        </div>
                                        &nbsp;/&nbsp;
                                        <div class="form-check form-check-inline" style="margin-right: 0px;">
                                            <input class="form-check-input" type="radio" name="inlineRadioAwRoAs" id="inlineAwRoAs2" value="Roussble" @if ( isset($anaesthetist_record_data->conditioning_leaving) && $anaesthetist_record_data->conditioning_leaving == "Roussble") checked @endif />
                                            <label class="form-check-label" for="inlineAwRoAs2">Roussble</label>
                                        </div>
                                        &nbsp;/&nbsp;
                                        <div class="form-check form-check-inline" style="margin-right: 0px;">
                                            <input class="form-check-input" type="radio" name="inlineRadioAwRoAs" id="inlineAwRoAs3" value="Asleep" @if ( isset($anaesthetist_record_data->conditioning_leaving) && $anaesthetist_record_data->conditioning_leaving == "Asleep") checked @endif />
                                            <label class="form-check-label" for="inlineAwRoAs3">Asleep</label>
                                        </div>
                                    </fieldset>
                                </div>



                                <div> <strong> Volume :</strong></div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="ptPeFe" class="col-form-label col-form-label-sm">
                                            <div class="form-check form-check-inline" style="margin-right: 0px;">
                                                <input class="form-check-input" type="radio" name="inlinePeFe" id="inlinePeFe1" value="Peth" @if ( isset($anaesthetist_record_data->peth_fenta) && $anaesthetist_record_data->peth_fenta == "Peth") checked @endif />
                                                <label class="form-check-label" for="inlinePeFe1">
                                                    Peth</label>
                                            </div>
                                            &nbsp;/&nbsp;
                                            <div class="form-check form-check-inline" style="margin-right: 0px;">
                                                <input class="form-check-input" type="radio" name="inlinePeFe" id="inlinePeFe2" value="Fenta" @if ( isset($anaesthetist_record_data->peth_fenta) && $anaesthetist_record_data->peth_fenta == "Fenta") checked @endif />
                                                <label class="form-check-label" for="inlinePeFe2">Fenta</label>
                                            </div>
                                        </label>
                                        <input type="text" class="form-control form-control-sm" id="ptPeFe" name="ptPeFe" placeholder="" value="{{isset($anaesthetist_record_data->peth_fenta_text) ? $anaesthetist_record_data->peth_fenta_text :''}}" />
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="ptDiMi" class="col-form-label col-form-label-sm">
                                            <div class="form-check form-check-inline" style="margin-right: 0px;">
                                                <input class="form-check-input" type="radio" name="inlineDiMi" id="inlineDiMi1" value="Diaz" @if ( isset($anaesthetist_record_data->diaz_mida) && $anaesthetist_record_data->diaz_mida == "Diaz") checked @endif />
                                                <label class="form-check-label" for="inlineDiMi1">Diaz</label>
                                            </div>
                                            &nbsp;/&nbsp;
                                            <div class="form-check form-check-inline" style="margin-right: 0px;">
                                                <input class="form-check-input" type="radio" name="inlineDiMi" id="inlineDiMi2" value="Mida" @if ( isset($anaesthetist_record_data->diaz_mida) && $anaesthetist_record_data->diaz_mida == "Mida") checked @endif />
                                                <label class="form-check-label" for="inlineDiMi2">Mida</label>
                                            </div>
                                        </label>
                                        <input type="text" class="form-control form-control-sm" id="ptDiMi" name="ptDiMi" placeholder="" value="{{isset($anaesthetist_record_data->diaz_mida_text) ? $anaesthetist_record_data->diaz_mida_text :''}}" />
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="ptTPS" class="col-form-label col-form-label-sm">
                                                TPS</label>
                                            <input type="text" class="form-control form-control-sm" id="ptTPS" name="ptTPS" value="{{isset($anaesthetist_record_data->tps) ? $anaesthetist_record_data->tps :''}}" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group" style="margin-top: 10px;">
                                        <div class="form-group">
                                            <label for="" class="col-form-label col-form-label-sm" for="others_volume">Others</label>
                                            <input type="text" class="form-control form-control-sm" id="others_volume" name="others_volume" value="{{isset($anaesthetist_record_data->others_volume) ? $anaesthetist_record_data->others_volume :''}}" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <fieldset>
                                        <legend>Type & Needle Size</legend>
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="ptSpace" class="col-form-label col-form-label-sm">Space</label>
                                                    <input type="text" class="form-control form-control-sm" id="ptSpace" name="ptSpace" value="{{isset($anaesthetist_record_data->space) ? $anaesthetist_record_data->space :''}}" />
                                                </div>
                                            </div>

                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="ptDrug" class="col-form-label col-form-label-sm">Drug</label>
                                                    <input type="text" class="form-control form-control-sm" id="ptDrug" name="ptDrug" value="{{isset($anaesthetist_record_data->drug) ? $anaesthetist_record_data->drug :''}}" />
                                                </div>
                                            </div>

                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="ptDose" class="col-form-label col-form-label-sm">Dose</label>
                                                    <input type="text" class="form-control form-control-sm" id="ptDose" name="ptDose" value="{{isset($anaesthetist_record_data->dose) ? $anaesthetist_record_data->dose :''}}" />
                                                </div>
                                            </div>

                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="ptAdjuvant" class="col-form-label col-form-label-sm">Adjuvant</label>
                                                    <input type="text" class="form-control form-control-sm" id="ptAdjuvant" name="ptAdjuvant" value="{{isset($anaesthetist_record_data->adjuvant) ? $anaesthetist_record_data->adjuvant :''}}" />
                                                </div>
                                            </div>

                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="ptVolume" class="col-form-label col-form-label-sm">Volume</label>
                                                    <input type="text" class="form-control form-control-sm" id="ptVolume" name="ptVolume" value="{{isset($anaesthetist_record_data->volume) ? $anaesthetist_record_data->volume :''}}" />
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>

                                <div class="col-md-12">
                                    <fieldset>
                                        <legend>Airway :</legend>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <strong>Supraglottic airway</strong>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control form-control-sm" id="supraglottic_airway" name="supraglottic_airway" value="{{isset($anaesthetist_record_data->supraglottic_airway) ? $anaesthetist_record_data->supraglottic_airway :''}}" placeholder="" />
                                                    </div>
                                                    <label for="" class="col-form-label col-form-label-sm">
                                                        <div class="form-check form-check-inline" style="margin-right: 0px;">
                                                            <input class="form-check-input" type="radio" name="inlineRadioFaceMaskEtt" id="inlineFaceMaskEtt1" value="Face mask" @if ( isset($anaesthetist_record_data->airway) && $anaesthetist_record_data->airway == "Face mask") checked @endif />
                                                            <label class="form-check-label" for="inlineFaceMaskEtt1">Face mask</label>
                                                        </div>
                                                        &nbsp;/&nbsp;
                                                        <div class="form-check form-check-inline" style="margin-right: 0px;">
                                                            <input class="form-check-input" type="radio" name="inlineRadioFaceMaskEtt" id="inlineFaceMaskEtt2" value="ETT" @if ( isset($anaesthetist_record_data->airway) && $anaesthetist_record_data->airway == "ETT") checked @endif />
                                                            <label class="form-check-label" for="inlineFaceMaskEtt2">ETT</label>
                                                        </div>
                                                    </label>

                                                    &nbsp; : &nbsp;

                                                    <label for="" class="col-form-label col-form-label-sm">
                                                        <div class="form-check form-check-inline" style="margin-right: 0px;">
                                                            <input class="form-check-input" type="radio" name="inlineRadioOraNasal" id="inlineOraNasal1" value="Ora" @if ( isset($anaesthetist_record_data->airway_ora_nasal) && $anaesthetist_record_data->airway_ora_nasal == "Ora") checked @endif />
                                                            <label class="form-check-label" for="inlineOraNasal1">Ora</label>
                                                        </div>
                                                        &nbsp;/&nbsp;
                                                        <div class="form-check form-check-inline" style="margin-right: 0px;">
                                                            <input class="form-check-input" type="radio" name="inlineRadioOraNasal" id="inlineOraNasal2" value="Nasal" @if ( isset($anaesthetist_record_data->airway_ora_nasal) && $anaesthetist_record_data->airway_ora_nasal == "Nasal") checked @endif />
                                                            <label class="form-check-label" for="inlineOraNasal2">Nasal</label>
                                                        </div>
                                                    </label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control form-control-sm" id="faceMett" name="faceMett" value="{{isset($anaesthetist_record_data->airway_text) ? $anaesthetist_record_data->airway_text :''}}" placeholder="Size:---(mm)" />
                                                    </div>
                                                    <strong>ETT (Cuffed/Non cuffed)</strong>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control form-control-sm" id="ett_cuffed_non_cuffed" name="ett_cuffed_non_cuffed" value="{{isset($anaesthetist_record_data->ett_cuffed_non_cuffed) ? $anaesthetist_record_data->ett_cuffed_non_cuffed :''}}" placeholder="" />
                                                    </div>
                                                    <!-- <strong>Tracheostomy</strong>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control form-control-sm" id="tracheostomy" name="tracheostomy" value="{{isset($anaesthetist_record_data->tracheostomy) ? $anaesthetist_record_data->tracheostomy :''}}" placeholder="" />
                                                    </div> -->

                                                </div>
                                            </div>
                                            <div class="col-md-12"><h3>Breathing system</h3></div>
                                            <div class="col-md-3">
                                                <strong>Circle</strong>
                                                <div class="input-group">
                                                    <input type="text" class="form-control form-control-sm" id="circle" name="circle" value="{{isset($anaesthetist_record_data->circle) ? $anaesthetist_record_data->circle :''}}" placeholder="" />
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <strong>Bain’s</strong>
                                                <div class="input-group">
                                                    <input type="text" class="form-control form-control-sm" id="bains" name="bains" value="{{isset($anaesthetist_record_data->bains) ? $anaesthetist_record_data->bains :''}}" placeholder="" />
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <strong>Ayre’s T pice</strong>
                                                <div class="input-group">
                                                    <input type="text" class="form-control form-control-sm" id="ayres_t_pice" name="ayres_t_pice" value="{{isset($anaesthetist_record_data->ayres_t_pice) ? $anaesthetist_record_data->ayres_t_pice :''}}" placeholder="" />
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <strong>O <sub>2</sub> supplement only</strong>
                                                <div class="input-group">
                                                    <input type="text" class="form-control form-control-sm" id="supplement_only" name="supplement_only" value="{{isset($anaesthetist_record_data->supplement_only) ? $anaesthetist_record_data->supplement_only :''}}" placeholder="" />
                                                </div>

                                            </div>
                                           <div class="col-md-12"><h3>Ventilation</h3></div>

                                            <div class="col-md-3">
                                                <strong>Controlled</strong>
                                                <div class="input-group">
                                                    <input type="text" class="form-control form-control-sm" id="controlled" name="controlled" value="{{isset($anaesthetist_record_data->controlled) ? $anaesthetist_record_data->controlled :''}}" placeholder="" />
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <strong>Spontaneous/ Assisted</strong>
                                                <div class="input-group">
                                                    <input type="text" class="form-control form-control-sm" id="spontaneous_assisted" name="spontaneous_assisted" value="{{isset($anaesthetist_record_data->spontaneous_assisted) ? $anaesthetist_record_data->spontaneous_assisted :''}}" placeholder="" />
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <strong>HFV/ Jet ventilation</strong>
                                                <div class="input-group">
                                                    <input type="text" class="form-control form-control-sm" id="hfv_jet_ventilation" name="hfv_jet_ventilation" value="{{isset($anaesthetist_record_data->hfv_jet_ventilation) ? $anaesthetist_record_data->hfv_jet_ventilation :''}}" placeholder="" />
                                                </div>
                                            </div>

                                            <div class="col-md-12"><h3>Gas</h3></div>

                                            <div class="col-md-3">
                                                <strong>O<sub>2</sub> </strong>
                                                <div class="input-group">
                                                    <input type="text" class="form-control form-control-sm" id="o2" name="o2" value="{{isset($anaesthetist_record_data->o2) ? $anaesthetist_record_data->o2 :''}}" placeholder="" />
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <strong>N2 O</strong>
                                                <div class="input-group">
                                                    <input type="text" class="form-control form-control-sm" id="n2o" name="n2o" value="{{isset($anaesthetist_record_data->n2o) ? $anaesthetist_record_data->n2o :''}}" placeholder="" />
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <strong>Volatile-Isolurane/ Sevoflurane</strong>
                                                <div class="input-group">
                                                    <input type="text" class="form-control form-control-sm" id="volatile_isolurane_sevoflurane" name="volatile_isolurane_sevoflurane" value="{{isset($anaesthetist_record_data->vol_iso_sevof) ? $anaesthetist_record_data->vol_iso_sevof :''}}" placeholder="" />
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <strong>Air</strong>
                                                <div class="input-group">
                                                    <input type="text" class="form-control form-control-sm" id="air" name="air" value="{{isset($anaesthetist_record_data->air) ? $anaesthetist_record_data->air :''}}" placeholder="" />
                                                </div>
                                            </div>
                                            <div class="col-md-12"><h3>Regional Technique</h3></div>
                                            <div class="col-md-3">
                                                <strong>Type </strong>
                                                <div class="input-group">
                                                    <input type="text" class="form-control form-control-sm" id="regional_type" name="regional_type" value="{{isset($anaesthetist_record_data->regional_type) ? $anaesthetist_record_data->regional_type :''}}" placeholder="" />
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <strong>Site/Approach/level</strong>
                                                <div class="input-group">
                                                    <input type="text" class="form-control form-control-sm" id="site_approach_level" name="site_approach_level" value="{{isset($anaesthetist_record_data->site_approach_level) ? $anaesthetist_record_data->site_approach_level :''}}" placeholder="" />
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <strong>Needle</strong>
                                                <div class="input-group">
                                                    <input type="text" class="form-control form-control-sm" id="needle" name="needle" value="{{isset($anaesthetist_record_data->needle) ? $anaesthetist_record_data->needle :''}}" placeholder="" />
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <strong>Needle size</strong>
                                                <div class="input-group">
                                                    <input type="text" class="form-control form-control-sm" id="needle_size" name="needle_size" value="{{isset($anaesthetist_record_data->needle_size) ? $anaesthetist_record_data->needle_size :''}}" placeholder="" />
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <strong>Single Shot</strong>
                                                <div class="input-group">
                                                    <input type="text" class="form-control form-control-sm" id="single_shot" name="single_shot" value="{{isset($anaesthetist_record_data->single_shot) ? $anaesthetist_record_data->single_shot :''}}" placeholder="" />
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <strong>Catheter</strong>
                                                <div class="input-group">
                                                    <input type="text" class="form-control form-control-sm" id="catheter" name="catheter" value="{{isset($anaesthetist_record_data->catheter) ? $anaesthetist_record_data->catheter :''}}" placeholder="" />
                                                </div>
                                            </div>
                                            <!-- <div class="col-md-3">
                                                <strong>Blind</strong>
                                                <div class="input-group">
                                                    <input type="text" class="form-control form-control-sm" id="blind" name="blind" value="{{isset($anaesthetist_record_data->blind) ? $anaesthetist_record_data->blind :''}}" placeholder="" />
                                                </div>
                                            </div> -->

                                            <div class="col-md-3">
                                                <strong>Ultrasound guided</strong>
                                                <div class="input-group">
                                                    <input type="text" class="form-control form-control-sm" id="ultrasound_guided" name="ultrasound_guided" value="{{isset($anaesthetist_record_data->ultrasound_guided) ? $anaesthetist_record_data->ultrasound_guided :''}}" placeholder="" />
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <strong>Nerve stimulator</strong>
                                                <div class="input-group">
                                                    <input type="text" class="form-control form-control-sm" id="nerve_stimulator" name="nerve_stimulator" value="{{isset($anaesthetist_record_data->nerve_stimulator) ? $anaesthetist_record_data->nerve_stimulator :''}}" placeholder="" />
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <strong>Drugs</strong>
                                                <div class="input-group">
                                                    <input type="text" class="form-control form-control-sm" id="drugs" name="drugs" value="{{isset($anaesthetist_record_data->drugs) ? $anaesthetist_record_data->drugs :''}}" placeholder="" />
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <strong>Assessment-Complete/ partial/ failed</strong>
                                                <div class="input-group">
                                                    <input type="text" class="form-control form-control-sm" id="Assessment_Complete_partial" name="Assessment_Complete_partial" value="{{isset($anaesthetist_record_data->ass_comp_partial) ? $anaesthetist_record_data->ass_comp_partial :''}}" placeholder="" />
                                                </div>
                                            </div>
                                            <div class="col-md-12"><h3>Condition on leaving OT</h3></div>
                                            <div class="col-md-3">
                                                <strong>Induction agent used</strong>
                                                <div class="input-group">
                                                    <input type="text" class="form-control form-control-sm" id="induction_agent_used" name="induction_agent_used" value="{{isset($anaesthetist_record_data->induction_agent_used) ? $anaesthetist_record_data->induction_agent_used :''}}" placeholder="" />
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <strong>Analgesia used</strong>
                                                <div class="input-group">
                                                    <input type="text" class="form-control form-control-sm" id="analgesia_used" name="analgesia_used" value="{{isset($anaesthetist_record_data->analgesia_used) ? $anaesthetist_record_data->analgesia_used :''}}" placeholder="" />
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <strong>Muscle relaxant used</strong>
                                                <div class="input-group">
                                                    <input type="text" class="form-control form-control-sm" id="muscle_relaxant_used" name="muscle_relaxant_used" value="{{isset($anaesthetist_record_data->muscle_relaxant_used) ? $anaesthetist_record_data->muscle_relaxant_used :''}}" placeholder="" />
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <strong>Crystalloid fluid used</strong>
                                                <div class="input-group">
                                                    <input type="text" class="form-control form-control-sm" id="crystalloid_fluid_used" name="crystalloid_fluid_used" value="{{isset($anaesthetist_record_data->crystalloid_fluid_used) ? $anaesthetist_record_data->crystalloid_fluid_used :''}}" placeholder="" />
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <strong>Colloid fluid used</strong>
                                                <div class="input-group">
                                                    <input type="text" class="form-control form-control-sm" id="colloid_fluid_used" name="colloid_fluid_used" value="{{isset($anaesthetist_record_data->colloid_fluid_used) ? $anaesthetist_record_data->colloid_fluid_used :''}}" placeholder="" />
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <strong>Blood product used</strong>
                                                <div class="input-group">
                                                    <input type="text" class="form-control form-control-sm" id="blood_product_used" name="blood_product_used" value="{{isset($anaesthetist_record_data->blood_product_used) ? $anaesthetist_record_data->blood_product_used :''}}" placeholder="" />
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <strong>Additional drug used</strong>
                                                <div class="input-group">
                                                    <input type="text" class="form-control form-control-sm" id="additional_drug_used" name="additional_drug_used" value="{{isset($anaesthetist_record_data->additional_drug_used) ? $anaesthetist_record_data->additional_drug_used :''}}" placeholder="" />
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <strong>Reversal drugs</strong>
                                                <div class="input-group">
                                                    <input type="text" class="form-control form-control-sm" id="reversal_drugs" name="reversal_drugs" value="{{isset($anaesthetist_record_data->reversal_drugs) ? $anaesthetist_record_data->reversal_drugs :''}}" placeholder="" />
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <strong>Urine output</strong>
                                                <div class="input-group">
                                                    <input type="text" class="form-control form-control-sm" id="urine_output" name="urine_output" value="{{isset($anaesthetist_record_data->urine_output) ? $anaesthetist_record_data->urine_output :''}}" placeholder="" />
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <strong>Blood loss (Approx)</strong>
                                                <div class="input-group">
                                                    <input type="text" class="form-control form-control-sm" id="blood_loss" name="blood_loss" value="{{isset($anaesthetist_record_data->blood_loss) ? $anaesthetist_record_data->blood_loss :''}}" placeholder="" />
                                                </div>
                                            </div>

                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="" class="col-form-label col-form-label-sm">
                                                        <div class="form-check form-check-inline" style="margin-right: 0px;">
                                                            <input class="form-check-input" type="radio" name="inlineRadioCuNoCpv" id="inlineCuNoCpv1" value="Cuff" @if ( isset($anaesthetist_record_data->cuff_non_cutpvc) && $anaesthetist_record_data->cuff_non_cutpvc == "Cuff") checked @endif />
                                                            <label class="form-check-label" for="inlineCuNoCpv1">Cuff</label>
                                                        </div>
                                                        &nbsp;/&nbsp;
                                                        <div class="form-check form-check-inline" style="margin-right: 0px;">
                                                            <input class="form-check-input" type="radio" name="inlineRadioCuNoCpv" id="inlineCuNoCpv2" value="Non" @if ( isset($anaesthetist_record_data->cuff_non_cutpvc) && $anaesthetist_record_data->cuff_non_cutpvc == "Non") checked @endif />
                                                            <label class="form-check-label" for="inlineCuNoCpv2">Non</label>
                                                        </div>
                                                        &nbsp;/&nbsp;
                                                        <div class="form-check form-check-inline" style="margin-right: 0px;">
                                                            <input class="form-check-input" type="radio" name="inlineRadioCuNoCpv" id="inlineCuNoCpv3" value="-Cut PVC" @if ( isset($anaesthetist_record_data->cuff_non_cutpvc) && $anaesthetist_record_data->cuff_non_cutpvc == "-Cut PVC") checked @endif />
                                                            <label class="form-check-label" for="inlineCuNoCpv3">-Cut PVC</label>
                                                        </div>
                                                    </label>
                                                    <div class="input-group">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="Yes" @if ( isset($anaesthetist_record_data->yes_no) && $anaesthetist_record_data->yes_no == "Yes") checked @endif/>
                                                            <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="No" @if ( isset($anaesthetist_record_data->yes_no) && $anaesthetist_record_data->yes_no == "No") checked @endif/>
                                                            <label class="form-check-label" for="inlineRadio2">No</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="inlineLASpray1" class="col-form-label col-form-label-sm">
                                                        LASpray</label>
                                                    <div class="input-group">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="inlineLASpray" id="inlineLASpray1" value="Yes" @if ( isset($anaesthetist_record_data->laspray_yes_no) && $anaesthetist_record_data->laspray_yes_no == "Yes") checked @endif/>
                                                            <label class="form-check-label" for="inlineLASpray1">Yes</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="inlineLASpray" id="inlineLASpray2" value="No" @if ( isset($anaesthetist_record_data->laspray_yes_no) && $anaesthetist_record_data->laspray_yes_no == "No") checked @endif/>
                                                            <label class="form-check-label" for="inlineLASpray2">No</label>
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
                                            <label for="sCv1" class="col-form-label col-form-label-sm">
                                                <div class="form-check form-check-inline" style="margin-right: 0px;">
                                                    <input class="form-check-input" type="radio" name="inlineRadioSponCont" id="inlineSponCont1" value="Spontaneous" @if ( isset($anaesthetist_record_data->respitation_sp_co) && $anaesthetist_record_data->respitation_sp_co == "Spontaneous") checked @endif/>
                                                    <label class="form-check-label" for="inlineSponCont1">Spontaneous</label>
                                                </div>
                                                &nbsp;/&nbsp;
                                                <div class="form-check form-check-inline" style="margin-right: 0px;">
                                                    <input class="form-check-input" type="radio" name="inlineRadioSponCont" id="inlineSponCont2" value="Controlled" @if ( isset($anaesthetist_record_data->respitation_sp_co) && $anaesthetist_record_data->respitation_sp_co == "Controlled") checked @endif/>
                                                    <label class="form-check-label" for="inlineSponCont2">Controlled</label>
                                                </div>
                                            </label>
                                            &nbsp; : &nbsp;

                                            <label for="" class="col-form-label col-form-label-sm">
                                                <div class="form-check form-check-inline" style="margin-right: 0px;">
                                                    <input class="form-check-input" type="radio" name="inlineRadioManVen" id="inlineManVen1" value="Manual" @if ( isset($anaesthetist_record_data->respitation_manual_ventilator) && $anaesthetist_record_data->respitation_manual_ventilator == "Manual") checked @endif/>
                                                    <label class="form-check-label" for="inlineManVen1">Manual</label>
                                                </div>
                                                &nbsp;/&nbsp;
                                                <div class="form-check form-check-inline" style="margin-right: 0px;">
                                                    <input class="form-check-input" type="radio" name="inlineRadioManVen" id="inlineManVen2" value="Ventilator" @if ( isset($anaesthetist_record_data->respitation_manual_ventilator) && $anaesthetist_record_data->respitation_manual_ventilator == "Ventilator") checked @endif/>
                                                    <label class="form-check-label" for="inlineManVen2">Ventilator</label>
                                                </div>
                                            </label>
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm" id="sCv1" name="sCv1" placeholder="V₁ -ml" value="{{isset($anaesthetist_record_data->respitation_sp_co_text) ? $anaesthetist_record_data->respitation_sp_co_text :''}}" />
                                                <input type="text" class="form-control form-control-sm" id="sCrespRate" name="sCrespRate" placeholder="Resp. Rate" value="{{isset($anaesthetist_record_data->respitation_manu_venti_text) ? $anaesthetist_record_data->respitation_manu_venti_text :''}}" />
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="row justify-content-end">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="inJected" class="col-form-label col-form-label-sm">Courtesy By</label>
                                        <input type="text" class="form-control form-control-sm" id="courtesy_by" name="courtesy_by" placeholder="" value="{{isset($anaesthetist_record_data->injected_by_name) ? $anaesthetist_record_data->injected_by_name :''}}" />
                                        <input type="hidden" name="hdn_courtesyBy_doctor_id" id="hdn_courtesyBy_doctor_id" value="{{isset($anaesthetist_record_data->injected_by_id) ? $anaesthetist_record_data->injected_by_id :''}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <fieldset>
                                        <div class="form-row">

                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="signAnaName" class="col-form-label col-form-label-sm">Name of
                                                        Anaesthetist</label>
                                                    <input type="text" class="form-control form-control-sm" id="signAnaName" name="signAnaName" value="{{isset($anaesthetist_record_data->sign_anaesthetist_name) ? $anaesthetist_record_data->sign_anaesthetist_name :''}}" />
                                                    <input type="hidden" name="hdn_anaesthetist_doctor_id" id="hdn_anaesthetist_doctor_id" value="{{isset($anaesthetist_record_data->sign_anaesthetist_id) ? $anaesthetist_record_data->sign_anaesthetist_id :''}}">
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
        $redirect_url = route('ipd.anaesthetic-record-form',[$pat_info->patient_no_pk,$ref_no]);
        @endphp
        <button type="submit" class="btn btn-success btn-lg m-3 float-right" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $redirect_url }}')">Save</button>
    </div>
    </form>
    </div>
    </div>
</section>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="text/javascript">
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
        $('#editor_content').val(evt.editor.getData())
    });
</script>
