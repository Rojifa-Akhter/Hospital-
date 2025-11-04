<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link href="{{ asset('css/redactor.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('asset/timepicker/css/timepicker.css') }}">

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        margin: 0;
    }

    .anaesthetic__form {
        padding: 25px 0;
        position: relative;
    }

    .anaesthetic__form fieldset {
        display: block;
        padding: 10px;
        border: 1px solid #ddd;
    }

    .anaesthetic__form legend {
        font-size: 18px;
        font-weight: 600;
    }

    .card-header h4.card-title {
        font-size: 18px;
        font-weight: 600;
        color: #c9272b;
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
                <h5 class="mt-2 mb-0">Nutrition Assessment Form</h5>
                <small>Nutrition / Nutrition Assessment Form</small>
            </div>
        </div>

        <div class="anaesthetic__form">
            <form action="{{ route('high-risk-consent-store') }}" method="post" id="HIGHRISK">
                @csrf
                <input type="hidden" name="admission_id"
                    value="{{ isset($pat_info->admission_no_pk) ? $pat_info->admission_no_pk : '' }}">
                <input type="hidden" name="pat_id"
                    value="{{ isset($pat_info->patient_no_fk) ? $pat_info->patient_no_fk : '' }}">
                <input type="hidden" name="ipd_high_riskconsent_no_pk"
                    value="{{ isset($high_risk_consent->ipd_high_riskconsent_no_pk) ? $high_risk_consent->ipd_high_riskconsent_no_pk : '' }}">

                <div class="">
                    <!-- Patient Info -->
                    <div class="form-row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header text-center">
                                    <h2 class="card-title mb-0 text-left"><strong>Patient Info</strong></h2>
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
                                                    readonly />
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="ptAge"
                                                    class="col-form-label col-form-label-sm">Age</label>
                                                <input type="text" class="form-control form-control-sm"
                                                    id="ptAge" name="ptAge"
                                                    value="{{ isset($pat_info->age) ? $pat_info->age : '' }}"
                                                    readonly />
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="ptSex"
                                                    class="col-form-label col-form-label-sm">Sex</label>
                                                <input type="text" class="form-control form-control-sm"
                                                    id="ptSex" name="ptSex"
                                                    value="{{ isset($pat_info->gender_txt) ? $pat_info->gender_txt : '' }}"
                                                    readonly />
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="ptBlood" class="col-form-label col-form-label-sm">B.
                                                    Group</label>
                                                <input type="text" class="form-control form-control-sm"
                                                    id="ptBlood" name="ptBlood"
                                                    value="{{ isset($pat_info->blood_group_text) ? $pat_info->blood_group_text : '' }}"
                                                    readonly />
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="ptUnit"
                                                    class="col-form-label col-form-label-sm">Department</label>
                                                <input type="text" class="form-control form-control-sm"
                                                    id="ptUnit" name="ptUnit"
                                                    value="{{ isset($pat_info->new_su_name) ? $pat_info->new_su_name : '' }}"
                                                    readonly />
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="ptWard"
                                                    class="col-form-label col-form-label-sm">Ward</label>
                                                <input type="text" class="form-control form-control-sm"
                                                    id="ptWard" name="ptWard"
                                                    value="{{ isset($pat_info->new_ward_name) ? $pat_info->new_ward_name : '' }}"
                                                    readonly />
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="ptBed"
                                                    class="col-form-label col-form-label-sm">Bed</label>
                                                <input type="text" class="form-control form-control-sm"
                                                    id="ptBed" name="ptBed"
                                                    value="{{ isset($pat_info->new_bed_name) ? $pat_info->new_bed_name : '' }}"
                                                    readonly />
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="date"
                                                    class="col-form-label col-form-label-sm">Date</label>
                                                <input type="text" class="form-control form-control-sm date_picker"
                                                    id="date" name="date"
                                                    value="{{ isset($high_risk_consent->reg_date) ? date('d-m-Y', strtotime($high_risk_consent->reg_date)) : '' }}"
                                                    placeholder="dd-mm-YYYY" />
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="doctor_name" class="col-form-label col-form-label-sm">Name
                                                    of the Doctor</label>
                                                <input type="text" class="form-control form-control-sm"
                                                    id="doctor_name" name="doctor_name" placeholder="Dr. Name"
                                                    value="{{ isset($high_risk_consent->doctor_name) ? $high_risk_consent->doctor_name : '' }}" />
                                                <input type="hidden" name="hdn_doctor_id" id="hdn_doctor_id"
                                                    value="{{ isset($high_risk_consent->doctor_no_fk) ? $high_risk_consent->doctor_no_fk : '' }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Problems Affecting Eating Habits Section -->
                            <div class="card mt-3">
                                <div class="card-header text-center">
                                    <h2 class="card-title mb-0 text-left"><strong>Problems Affecting Eating
                                            Habits</strong></h2>
                                </div>
                                <div class="card-body p-3">
                                    <!-- Problems affecting eating habits -->
                                    <div class="form-row">
                                        <div class="col-md-12">
                                            <h5 class="mb-3">Check any that apply:</h5>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="loss_of_appetite" name="eating_issues[]"
                                                            value="loss_of_appetite">
                                                        <label class="form-check-label" for="loss_of_appetite">Loss of
                                                            Appetite</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="nausea" name="eating_issues[]" value="nausea">
                                                        <label class="form-check-label" for="nausea">Nausea</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="vomiting" name="eating_issues[]" value="vomiting">
                                                        <label class="form-check-label"
                                                            for="vomiting">Vomiting</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="diarrhea" name="eating_issues[]" value="diarrhea">
                                                        <label class="form-check-label"
                                                            for="diarrhea">Diarrhea</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-md-3">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="changes_in_taste_and_smell" name="eating_issues[]"
                                                            value="changes_in_taste_and_smell">
                                                        <label class="form-check-label"
                                                            for="changes_in_taste_and_smell">Changes in Taste and
                                                            Smell</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="anorexia" name="eating_issues[]" value="anorexia">
                                                        <label class="form-check-label"
                                                            for="anorexia">Anorexia</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="constipation" name="eating_issues[]"
                                                            value="constipation">
                                                        <label class="form-check-label"
                                                            for="constipation">Constipation</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="lactose_intolerance" name="eating_issues[]"
                                                            value="lactose_intolerance">
                                                        <label class="form-check-label"
                                                            for="lactose_intolerance">Lactose Intolerance</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-md-3">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="pain" name="eating_issues[]" value="pain">
                                                        <label class="form-check-label" for="pain">Pain</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="dry_mouth" name="eating_issues[]" value="dry_mouth">
                                                        <label class="form-check-label" for="dry_mouth">Dry
                                                            Mouth</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="mouth_sores" name="eating_issues[]"
                                                            value="mouth_sores">
                                                        <label class="form-check-label" for="mouth_sores">Mouth
                                                            Sores</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Yes/No questions -->
                                    <div class="form-row mt-3">
                                        <div class="col-md-12">
                                            <h5 class="mb-3">Yes/No Questions:</h5>
                                            <div class="form-group">
                                                <label class="col-form-label col-form-label-sm"
                                                    for="swallowing_problems">Swallowing Problems</label>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio"
                                                        name="swallowing_problems" id="swallowing_yes"
                                                        value="yes">
                                                    <label class="form-check-label" for="swallowing_yes">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio"
                                                        name="swallowing_problems" id="swallowing_no" value="no">
                                                    <label class="form-check-label" for="swallowing_no">No</label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label col-form-label-sm"
                                                    for="chewing_problems">Chewing Problems</label>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio"
                                                        name="chewing_problems" id="chewing_yes" value="yes">
                                                    <label class="form-check-label" for="chewing_yes">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio"
                                                        name="chewing_problems" id="chewing_no" value="no">
                                                    <label class="form-check-label" for="chewing_no">No</label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label col-form-label-sm"
                                                    for="chewing_problems">Good Tolerate</label>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio"
                                                        name="chewing_problems" id="gt_yes" value="yes">
                                                    <label class="form-check-label" for="gt_yes">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio"
                                                        name="chewing_problems" id="gt_no" value="no">
                                                    <label class="form-check-label" for="gt_no" value="no">>No</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Required Calorie and Other Instructions Section -->
                            <div class="card mt-3">
                                <div class="card-header text-center">
                                    <h2 class="card-title mb-0 text-left"><strong>Required Calorie and Other
                                            Instructions</strong></h2>
                                </div>
                                <div class="card-body p-3">
                                    <div class="form-row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="energy_requirement"
                                                    class="col-form-label col-form-label-sm">Energy Requirement
                                                    (kcal)</label>
                                                <input type="number" class="form-control form-control-sm"
                                                    id="energy_requirement" name="energy_requirement"
                                                    placeholder="Enter Energy Requirement (kcal)" />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="food_allergy"
                                                    class="col-form-label col-form-label-sm">Food Allergy/Intolerance
                                                    (If Any)</label>
                                                <input type="text" class="form-control form-control-sm"
                                                    id="food_allergy" name="food_allergy"
                                                    placeholder="Enter Food Allergy/Intolerance" />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="dietary_restriction"
                                                    class="col-form-label col-form-label-sm">Dietary Restriction (If
                                                    Any)</label>
                                                <input type="text" class="form-control form-control-sm"
                                                    id="dietary_restriction" name="dietary_restriction"
                                                    placeholder="Enter Dietary Restriction" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="suggested_fluid_intake"
                                                    class="col-form-label col-form-label-sm">Suggested Fluid Intake
                                                    (ml)</label>
                                                <input type="number" class="form-control form-control-sm"
                                                    id="suggested_fluid_intake" name="suggested_fluid_intake"
                                                    placeholder="Enter Fluid Intake (ml)" />
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label for="others" class="col-form-label col-form-label-sm">Others
                                                    (if any)</label>
                                                <input type="text" class="form-control form-control-sm"
                                                    id="others" name="others"
                                                    placeholder="Enter other details" />
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Diet Type -->
                                    <div class="form-row mt-3">
                                        <div class="col-md-12">
                                            <h5 class="mb-3">Diet Type (Choose one):</h5>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="diet_normal" name="diet_type[]" value="normal_solid">
                                                        <label class="form-check-label"
                                                            for="diet_normal">Normal/Solid</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="diet_liquid" name="diet_type[]" value="liquid">
                                                        <label class="form-check-label"
                                                            for="diet_liquid">Liquid</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="diet_semisolid" name="diet_type[]"
                                                            value="semisolid_soft">
                                                        <label class="form-check-label"
                                                            for="diet_semisolid">Semisolid/Soft</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="diet_ng" name="diet_type[]" value="ng_feeding">
                                                        <label class="form-check-label" for="diet_ng">NG
                                                            Feeding</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Specifications -->
                                    <div class="form-row mt-3">
                                        <div class="col-md-12">
                                            <h5 class="mb-3">Specifications (Choose any):</h5>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="spec_diabetic" name="specifications[]"
                                                            value="diabetic">
                                                        <label class="form-check-label"
                                                            for="spec_diabetic">Diabetic</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="spec_high_protein" name="specifications[]"
                                                            value="high_protein">
                                                        <label class="form-check-label" for="spec_high_protein">High
                                                            Protein</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="spec_renal" name="specifications[]" value="renal">
                                                        <label class="form-check-label" for="spec_renal">Renal</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="spec_high_calorie" name="specifications[]"
                                                            value="high_calorie">
                                                        <label class="form-check-label" for="spec_high_calorie">High
                                                            Calorie</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-md-3">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="spec_heptic" name="specifications[]" value="heptic">
                                                        <label class="form-check-label"
                                                            for="spec_heptic">Hepatic</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="spec_fat_restricted" name="specifications[]"
                                                            value="fat_restricted">
                                                        <label class="form-check-label" for="spec_fat_restricted">Fat
                                                            Restricted</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="spec_cardiac" name="specifications[]"
                                                            value="cardiac">
                                                        <label class="form-check-label"
                                                            for="spec_cardiac">Cardiac</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="spec_fruit_restricted" name="specifications[]"
                                                            value="fruit_restricted">
                                                        <label class="form-check-label"
                                                            for="spec_fruit_restricted">Fruit Restricted</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-md-3">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="spec_hypertension" name="specifications[]"
                                                            value="hypertension">
                                                        <label class="form-check-label"
                                                            for="spec_hypertension">Hypertension</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="spec_salt_oil_restricted" name="specifications[]"
                                                            value="salt_oil_restricted">
                                                        <label class="form-check-label"
                                                            for="spec_salt_oil_restricted">Salt and Oil
                                                            Restricted</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="spec_dengue" name="specifications[]" value="dengue">
                                                        <label class="form-check-label"
                                                            for="spec_dengue">Dengue</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="spec_protein_restricted" name="specifications[]"
                                                            value="protein_restricted">
                                                        <label class="form-check-label"
                                                            for="spec_protein_restricted">Protein Restricted</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-row mt-4">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-submit float-right">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
