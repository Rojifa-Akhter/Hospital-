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
                <h5 class="mt-2 mb-0">High Risk Consent Form</h5>
                <small>Report / High Risk Consent Form</small>
            </div>
        </div>
        {{-- @dd($anaesthetist_record_data) --}}
        <div class="anaesthetic__form">
            <form action="{{ route('high-risk-consent-store') }}" method="post" id="HIGHRISK">
                @csrf
                <input type="hidden" name="ref_no" value="{{ isset($ref_no) ? $ref_no : '' }}">
                <input type="hidden" name="admission_id"
                    value="{{ isset($pat_info->admission_no_pk) ? $pat_info->admission_no_pk : '' }}">
                <input type="hidden" name="pat_id"
                    value="{{ isset($pat_info->patient_no_pk) ? $pat_info->patient_no_pk : '' }}">
                <input type="hidden" name="ipd_high_riskconsent_no_pk"
                    value="{{ isset($high_risk_consent->ipd_high_riskconsent_no_pk) ? $high_risk_consent->ipd_high_riskconsent_no_pk : '' }}">
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
                                                <label for="regNo" class="col-form-label col-form-label-sm">UHID No</label>
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
                                                    placeholder="" />
                                            </div>
                                        </div>

                                        {{-- <div class="col-md-2">
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
                                        </div> --}}
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="date"
                                                    class="col-form-label col-form-label-sm"> Reg. Date</label>
                                                <input type="text" class="form-control form-control-sm date_picker"
                                                    id="date" name="date"
                                                    value="{{ isset($pat_info->reg_date) ? $pat_info->reg_date : '' }}"
                                                    placeholder=""  readonly/>
                                            </div>
                                        </div>
                                        <div class="col-md-10">
                                            <div class="form-group">
                                                <label for="ptBed" class="col-form-label col-form-label-sm">Name of
                                                    the Doctor</label>
                                                <input type="text" class="form-control form-control-sm"
                                                    id="doctor_name" name="doctor_name" placeholder="Dr. Name"
                                                    value="{{ isset($high_risk_consent->doctor_name) ? $high_risk_consent->doctor_name : '' }}" />
                                                <input type="hidden" name="hdn_doctor_id" id="hdn_doctor_id"
                                                    value="{{ isset($high_risk_consent->doctor_no_fk) ? $high_risk_consent->doctor_no_fk : '' }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- 1st card body -->
                                <!-- 2nd card body -->

                                <div class="card-body p-3">
                                    <div class="row justify-content-end">
                                        <table width="100%" border="1">


                                            <tr>
                                                <td colspan="4">
                                                    @php
                                                        $Rreoperative = isset($high_risk_consent->person_name) ? $high_risk_consent->person_name : '';
                                                    @endphp
                                                    <input type="hidden" name="person_name" id="editor_content"
                                                        value="{{ $Rreoperative }}">


                                                    <textarea id="editor1" name="" class="ckeditor" style="height: 60vh" class="form-control form-control">
                                             <?php echo 'I / We '. $Rreoperative . '<br> <br> <br> <br> have been explained about the surgery by the doctors and the causes of High Risk are due to the following' ?>
                                             </textarea>
                                                </td>
                                            </tr>
                                                 <tr>
                                                    <td>
                                                        <strong>( Patient/Representative) Relation of Patient : </strong>
                                                        <input type="text" class="form-control form-control-sm"
                                                        id="representative" name="representative" placeholder="Relation of Patient"
                                                        value="{{ isset($high_risk_consent->representative) ? $high_risk_consent->representative : '' }}" />

                                                    </td>

                                                 </tr>

                                            <tr>
                                                <td colspan="4">
                                                    @php
                                                        $Rreoperative2 = isset($high_risk_consent->high_riskreason) ? $high_risk_consent->high_riskreason : '';
                                                    @endphp
                                                    <input type="hidden" name="high_riskreason" id="editor_content2"
                                                        value="{{ $Rreoperative }}">
                                                    <label for="editor2">Reasons for High Risk</label>

                                                    <textarea id="editor2" name="" class="ckeditor" style="height: 60vh" class="form-control form-control">
                                             <?php echo  $Rreoperative2  ?>
                                             </textarea>
                                                </td>
                                            </tr>


                                        </table>

                                        <table width="100%" border="1">

                                                 <tr>

                                                       <td style="width: 350px"> <strong>Name of the relative authorizing the surgeon to carry the operation  : </strong> </td>
                                                    <td>
                                                        <input type="text" class="form-control form-control-sm"
                                                        id="relative_name" name="relative_name" placeholder=""
                                                        value="{{ isset($high_risk_consent->relative_name) ? $high_risk_consent->relative_name : '' }}"/>

                                                    </td>
                                                 </tr>
                                                 <tr>

                                                       <td style="width: 150px"> <strong>Relationship to the patient  : </strong> </td>
                                                    <td>
                                                        <input type="text" class="form-control form-control-sm"
                                                        id="relationship" name="relationship" placeholder=""
                                                        value="{{ isset($high_risk_consent->relationship) ? $high_risk_consent->relationship : '' }}"/>

                                                    </td>
                                                 </tr>
                                        </table>
                                        <table width="100%" border="1">

                                                 <tr>
                                                 <td style="width: 350px" rowspan="2"> <strong>Signed in the presence of witness  : </strong> </td>
                                                    <td>
                                                        <input type="text" class="form-control form-control-sm"
                                                        id="witness_sign1" name="witness_sign1" placeholder="witness 1"
                                                        value="{{ isset($high_risk_consent->witness_sign1) ? $high_risk_consent->witness_sign1 : '' }}"/>

                                                    </td>
                                                 </tr>
                                                 <tr>
                                                       {{-- <td style="width: 150px"> <strong>Relationship to the patient  : </strong> </td> --}}
                                                    <td>
                                                        <input type="text" class="form-control form-control-sm"
                                                        id="witness_sign2" name="witness_sign2" placeholder=" witness 2"
                                                        value="{{ isset($high_risk_consent->witness_sign2) ? $high_risk_consent->witness_sign2 : '' }}"/>
                                                    </td>
                                                 </tr>
                                                 <tr>
                                                       <td style="width: 150px"> <strong>Name of the Doctor who explained the risk  : </strong> </td>
                                                    <td>
                                                        <input type="text" class="form-control form-control-sm"
                                                        id="explainery_doctor_name" name="explainery_doctor_name" placeholder="Dr. Name"
                                                        value="{{ isset($high_risk_consent->explainery_doctor_name) ? $high_risk_consent->explainery_doctor_name : '' }}" />
                                                    <input type="hidden" name="explainery_doctor_no_fk" id="explainery_doctor_no_fk"
                                                        value="{{ isset($high_risk_consent->explainery_doctor_no_fk) ? $high_risk_consent->explainery_doctor_no_fk : '' }}">
                                                    </td>
                                                 </tr>
                                                 <tr>
                                                     <td> <strong> Date </strong> </td>
                                                     <td >
                                                        <input type="text" class="form-control form-control-sm date_picker"
                                                        id="sig_date" name="sig_date"
                                                        value="{{ isset($high_risk_consent->sig_date) ? date('d-m-Y', strtotime($high_risk_consent->sig_date)) : '' }}"
                                                        placeholder="dd-mm-YYYY" />
                                                     </td>
                                                 </tr>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    @php
                        $redirect_url = route('ipd.high-risk-consent-form',[$pat_info->patient_no_pk,$ref_no]);
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
    openDoctorAutocomplete('#explainery_doctor_name', 'explainery_doctor_no_fk', 'doctor_ind', '1,2');

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

    editor.on('change', function(evt) {
        $('#editor_content').val(evt.editor.getData())
    });
    editor2.on('change', function(evt) {
        $('#editor_content2').val(evt.editor.getData())
    });
</script>
