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
                            <h5 class="mt-2 mb-0">Doctor Initial Assesment</h5>
                            <small>IPD / Nurse Station / Doctor Initial Assesment</small>
                        </div>
                        <div class="col-md-2">
                            <a class="btn btn-md btn-warning" target="_blank"
                                href="{{ route('v2.ipd.download-patient-assesment', [$patient_info->patient_no_pk, $patient_info->admission_no_pk]) }}">PDF
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
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Bed Category:
                                        {{ $patient_info->ward_name }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Bed No.:
                                        {{ $patient_info->bed_name }}</span>
                                </div>

                                <div class="col-md-12">
                                    <form action="{{ route('v2.ipd.medicine-indent-request') }}" method="post"
                                        id="assesmentForm">
                                        @csrf

                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th class="text-left border-right-0" style="width:10%">
                                                            Informant: </th>
                                                        <th colspan="4"><input type="text" class="custom-form"
                                                                name="informant" id="informant"
                                                                value="{{ @$assessment_info->informant }}"></th>
                                                        <th class="text-left border-left-0">Relation</th>
                                                        <th colspan="2" class="text-left border-left-0">
                                                            <select name="relation" id="relation" class="custom-form">

                                                                <option value="" selected>Select one</option>
                                                                @foreach ($relationAll as $key => $value)
                                                                    <option value="{{ $key }}"
                                                                        {{ @$assessment_info->relation == $key ? 'selected' : '' }}>
                                                                        {{ $value }}</option>
                                                                @endforeach
                                                            </select>
                                                        </th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    <tr>
                                                        <td style="border:none;height:20px" colspan="8">
                                                    </tr>

                                                    <tr>
                                                        <td class="text-left"><strong>Bed Category</strong></td>
                                                        <td colspan="2"><input type="text" class="custom-form"
                                                                name="ward_no" id="ward_no"
                                                                value="{{ @$patient_info->ward_name }}" readonly></td>
                                                        <td class="text-left"><strong>Date</strong></td>
                                                        <td colspan="5"><input type="text" class="custom-form"
                                                                name="admission_date" id="admission_date"
                                                                value="{{ date('d/m/Y h:i:s A') }}" readonly></td>
                                                    </tr>

                                                    <tr>
                                                        <td class="text-left" colspan="3"><strong>Chief complaint/s
                                                                and
                                                                History of present illness:</strong></td>
                                                        <td colspan="5">
                                                            <textarea name="cheif_complaint" id="cheif_complaint" rows="4" placeholder="write here ..." class="custom-form">{{ @$assessment_info->chief_complaint }}</textarea>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left" colspan="3"><strong>History:</strong>
                                                        </td>
                                                        <td colspan="5">
                                                            <textarea name="history" id="history" rows="4" placeholder="write here ..." class="custom-form">{{ @$assessment_info->history }}</textarea>
                                                        </td>

                                                    </tr>

                                                    <tr>
                                                        <td class="text-center" colspan="8"><strong>PRE EXISTING
                                                                ILLNESS / PAST MEDICAL & SURGICAL HISTORY</strong></td>
                                                    </tr>

                                                    <tr>
                                                        <td colspan="7">
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="diabetes_ind" name="diabetes_ind" value="1"
                                                                    {{ @$assessment_info->diabetes_ind == 1 ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="diabetes_ind"><b>Diabetes</b></label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="heart_ind" name="heart_ind" value="1"
                                                                    {{ @$assessment_info->heart_disease_ind == 1 ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="heart_ind"><b>Heart Disease</b></label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="hight_bp_ind" value="1"
                                                                    name="hight_bp_ind"
                                                                    {{ @$assessment_info->high_bp_ind == 1 ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="hight_bp_ind"><b>High Blood
                                                                        Pressure</b></label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="tuberculosis_ind" value="1"
                                                                    name="tuberculosis_ind"
                                                                    {{ @$assessment_info->tuberculosis_ind == 1 ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="tuberculosis_ind"><b>Tuberculosis</b></label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="others_ind" value="1" name="others_ind"
                                                                    onclick="others_ind()"
                                                                    {{ @$assessment_info->others_ind == 1 ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="others_ind"><b>Others (Specify):</b></label>
                                                            </div>

                                                        </td>
                                                        <td><input type="text" class="custom-form"
                                                                id="others_specify" name="others_specify"
                                                                value="{{ @$assessment_info->other_remarks }}"></td>
                                                    </tr>

                                                    <tr>
                                                        <td><strong>Family History</strong></td>
                                                        <td colspan="7"><input type="text" class="custom-form"
                                                                id="family_history" name="family_history"
                                                                value="{{ @$assessment_info->family_history }}"></td>
                                                    </tr>

                                                    <tr>
                                                        <td rowspan="2"><strong>Personal History: </strong></td>
                                                        <td rowspan="2"><input type="text" class="custom-form"
                                                                id="personal_history" name="personal_history"
                                                                value="{{ @$assessment_info->personal_history }}">
                                                        </td>
                                                        <td rowspan="2"><label for="">Occupation</label>
                                                        </td>
                                                        <td rowspan="2"><input type="text" class="custom-form"
                                                                name="occupation" id="occupation"
                                                                value="{{ @$assessment_info->occupation }}"></td>
                                                        <td class="text-left">Lifestyle :</td>
                                                        <td colspan="3" class="text-left">
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="lifestyle_sedentary"
                                                                    name="lifestyle_sedentary" value="1"
                                                                    {{ @$assessment_info->sedentary_ind == 1 ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="lifestyle_sedentary"><b>Sedentary</b></label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="lifestyle_active" name="lifestyle_active"
                                                                    value="1"
                                                                    {{ @$assessment_info->lifestyle_act == 1 ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="lifestyle_active"><b>Active</b></label>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td class="text-left">Habits</td>
                                                        <td colspan="3" class="text-left">
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="habit_tobacco" name="habit_tobacco"
                                                                    value="1"
                                                                    {{ @$assessment_info->tobacco_ind == 1 ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="habit_tobacco"><b>Tobacco</b></label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="habit_alcohol" name="habit_alcohol"
                                                                    value="1"
                                                                    {{ @$assessment_info->alcohol_ind == 1 ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="habit_alcohol"><b>Alcohol</b></label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="habit_substance" name="habit_substance"
                                                                    value="1"
                                                                    {{ @$assessment_info->substance_abuse_ind == 1 ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="habit_substance"><b>Substance
                                                                        Abuse</b></label>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td rowspan="8" class="text-left">
                                                            <strong>SCREENING</strong>
                                                        </td>
                                                        <td class="text-left">Hearing</td>
                                                        <td colspan="6" class="text-left">
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="hearing_no_alteration"
                                                                    name="hearing_no_alteration" value="1"
                                                                    {{ @$assessment_info->hear_no_alteration_ind == 1 ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="hearing_no_alteration">No Alteration</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="hearing_if_alteration"
                                                                    name="hearing_if_alteration" value="1"
                                                                    {{ @$assessment_info->hear_alteration_ind == 1 ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="hearing_if_alteration">Alteration if hearing
                                                                    (Refer to ENT)</label>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td class="text-left">Vison</td>
                                                        <td colspan="6" class="text-left">
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="vission_no_alteration"
                                                                    name="vission_no_alteration" value="1"
                                                                    {{ @$assessment_info->vison_no_alteration_ind == 1 ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="vission_no_alteration">No Alteration</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="vision_alteration" name="vision_alteration"
                                                                    value="1"
                                                                    {{ @$assessment_info->vison_alteration_ind == 1 ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="vision_alteration">Alteration in vision (Refer
                                                                    to Ophthalmologist)</label>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td class="text-left">Dental</td>
                                                        <td colspan="6" class="text-left">
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="dental_info_ind" name="dental_info_ind"
                                                                    value="1"
                                                                    {{ @$assessment_info->dent_pain_ind == 1 ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="dental_info_ind">Pain/Caries/Poor Dental
                                                                    Hygiene (Refer to Dentist)</label>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td rowspan="2" class="text-left">Functional</td>
                                                        <td class="text-left">Ambulation:</td>
                                                        <td colspan="5" class="text-left">
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="ambulation_independent"
                                                                    name="ambulation_independent" value="1"
                                                                    {{ @$assessment_info->amb_indentpendent_ind == 1 ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="ambulation_independent">Independent</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="ambulation_assisted"
                                                                    name="ambulation_assisted" value="1"
                                                                    {{ @$assessment_info->amb_assisted_ind == 1 ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="ambulation_assisted">Assisted</label>
                                                            </div>
                                                        </td>
                                                    </tr>


                                                    <tr>
                                                        <td class="text-left">Hand Function</td>

                                                        <td colspan="5" class="text-left">
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="hand_independent" name="hand_independent"
                                                                    value="1"
                                                                    {{ @$assessment_info->hand_indentpendent_ind == 1 ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="hand_independent">Independent</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="hand_impaired" name="hand_impaired"
                                                                    value="1"
                                                                    {{ @$assessment_info->hand_assisted_ind == 1 ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="hand_impaired">Impaired</label>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td class="text-left" rowspan="3">Nutrition</td>
                                                        <td class="text-left">Evident loss or gain of weight (>10%)
                                                        </td>
                                                        <td colspan="5" class="text-left">
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio"
                                                                    id="nutrition_yes" name="nutrition_yes"
                                                                    value="1"
                                                                    {{ @$assessment_info->nutrition_weight == 1 ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="nutrition_yes">Yes</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio"
                                                                    id="nutrition_no" name="nutrition_yes"
                                                                    value="2"
                                                                    {{ @$assessment_info->nutrition_weight == 2 ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="nutrition_no">No</label>
                                                            </div>
                                                        </td>
                                                    </tr>


                                                    <tr>
                                                        <td class="text-left">Poor Oral Intake > 3days </td>
                                                        <td colspan="5" class="text-left">
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio"
                                                                    id="poor_oral_intake" name="poor_oral_intake"
                                                                    value="1"
                                                                    {{ @$assessment_info->nutrition_oral == 1 ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="poor_oral_intake">Yes</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio"
                                                                    id="poor_oral_no" name="poor_oral_intake"
                                                                    value="2"
                                                                    {{ @$assessment_info->nutrition_oral == 2 ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="poor_oral_no">No</label>
                                                            </div>
                                                        </td>
                                                    </tr>


                                                    <tr>

                                                        <td class="text-left">Acute Disease in last 3 months </td>
                                                        <td colspan="5" class="text-left">
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio"
                                                                    id="accute_disease" name="accute_disease"
                                                                    value="1"
                                                                    {{ @$assessment_info->nutrition_acute == 1 ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="accute_disease">Yes</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio"
                                                                    id="accute_no" name="accute_disease"
                                                                    value="2"
                                                                    {{ @$assessment_info->nutrition_acute == 2 ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="accute_no">No</label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <tbody>
                                                    <tr>
                                                        <td class="text-left" style="width:40%">
                                                            <b>KNOWN ALLERGIES AND DRUG SESSITIVITIES:</b>

                                                        </td>
                                                        <td class="text-left"><input type="text"
                                                                class="custom-form" name="allergy" id="allergy"
                                                                placeholder="write here ..."
                                                                value="{{ @$patient_info->allergies_drug }}"></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <h5>Previous Medication</h5>
                                        <div class="table-responsive">
                                            <table class="table border-0 mt-2 mb-0 medicine_add_cart"
                                                id="medicine_list">
                                                <thead class="medicine_thead">
                                                    <tr class="border-0">
                                                        <th class="py-1 border-0 w-25">Medicine/Surgical</th>
                                                        <th class="py-1 px-1 border-0 w-15">Route</th>
                                                        <th class="py-1 px-1 border-0 w-15">Frequency</th>
                                                        <th class="py-1 px-1 border-0 w-15">Duration</th>
                                                        <th class="py-1 px-1 border-0 w-8">Qty.</th>
                                                        <th class="py-1 px-1 border-0 w-16">Instruction</th>
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
                                                                name="hdn_report_serial_med_master[]" value="1">
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
                                                                <option data-qnty="0" data-dropdown_option="add_more"
                                                                    data-popup_header="Medicine Route"
                                                                    data-input_label="Route"
                                                                    data-input_placeholder="Enter medicine route (i.e., Oral, Ocular)"
                                                                    value="0">Add More</option>
                                                            </select>
                                                        </td>

                                                        <td class="py-1 px-1 border-0">
                                                            <select class="form-control select2 m-0 p-0 medicine_dose"
                                                                id="medicine_dose" name="medicine_dose_master[]"
                                                                onchange="prescriptionFunc.addMoreDropdownOption(this,'.medicine_dose');prescriptionFunc.calculateMedicineQnty(this)">
                                                                <option value="0">Select</option>
                                                                @foreach ($dose as $key => $dmu)
                                                                    <option data-qnty=""
                                                                        value="{{ $key }}">
                                                                        {{ $dmu['data'] }}</option>
                                                                @endforeach
                                                                <option data-qnty="0" data-dropdown_option="add_more"
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
                                                                class="form-control form-control-sm select2 m-0 p-0"
                                                                id="instruction" name="instruction_master[]">
                                                                <option value="0">Select</option>
                                                                @foreach ($instructions as $key => $dmu)
                                                                    <option value="{{ $key }}">
                                                                        {{ $dmu['data'] }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>

                                                        <td class="py-1 px-1 border-0 text-center" id="med_td_action">
                                                            <span class="btn btn-success btn-md"
                                                                onclick="addMedicineItem()"><i class="fa fa-plus"></i>
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
                                                                    <select class="form-control medicine_duration_mu"
                                                                        id="medicine_duration_mu_{{ $keys }}"
                                                                        name="medicine_duration_mu[]"
                                                                        onchange="prescriptionFunc.calculateMedicineQnty(this)">
                                                                        <option value="0">Select</option>
                                                                        @foreach ($meddurmu as $key => $dmu)
                                                                            <option value="{{ strtoupper($key) }}"
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
                                                                    class="form-control form-control-sm select2 m-0 p-0"
                                                                    id="instruction_{{ $keys }}"
                                                                    name="instruction[]">
                                                                    <option value="0">Select</option>
                                                                    @foreach ($instructions as $key => $dmu)
                                                                        <option value="{{ $key }}"
                                                                            {{ $item->instruction_take == $key ? 'selected' : '' }}>
                                                                            {{ $dmu['data'] }}</option>
                                                                    @endforeach
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
                                                            <td colspan="7" class="text-danger text-center">Your
                                                                Cart is Empty</td>
                                                        </tr>
                                                    @endforelse

                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <tbody>
                                                    <tr>
                                                        <td class="text-left" colspan="3"><b>GENERAL EXAMINATION
                                                            </b></td>
                                                        <td colspan="9"><input type="text" class="custom-form"
                                                                id="general_examination" name="general_examination"
                                                                value="{{ @$assessment_info->general_examination }}">
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td colspan="4" class="text-left">
                                                            <strong>Temp:</strong>
                                                            <input type="number" class="custom-form w-20"
                                                                id="temperature" name="temperature"
                                                                value="{{ @$assessment_info->temp }}"
                                                                style="width: 50%"><span>°F</span>
                                                        </td>
                                                        <td colspan="4" class="text-left">
                                                            <strong>Pulse:</strong>
                                                            <input type="number" class="custom-form w-20"
                                                                id="pulse" name="pulse"
                                                                value="{{ @$assessment_info->pulse }}"
                                                                style="width: 50%">
                                                            <span>/min</span>
                                                        </td>
                                                        <td colspan="4" class="text-left">
                                                            <strong>BP:</strong>
                                                            <input type="number" class="custom-form w-20"
                                                                id="bp" name="bp"
                                                                value="{{ @$assessment_info->bp }}"
                                                                placeholder="high" style="width: 25%">

                                                            <input type="number" class="custom-form w-20"
                                                                name="bp_low"
                                                                value="{{ @$assessment_info->bp_low }}"
                                                                placeholder="low" style="width: 25%">
                                                            <span>mmHg</span>
                                                        </td>
                                                    </tr>



                                                    <tr>

                                                        <td colspan="4" class="text-left">
                                                            <strong>RR:</strong>
                                                            <input type="number" class="custom-form" id="rr"
                                                                name="rr" value="{{ @$assessment_info->rr }}"
                                                                style="width: 50%">
                                                            <span>/min</span>
                                                        </td>


                                                        <td colspan="4" class="text-left">
                                                            <strong>Height:</strong>
                                                            <input type="number" step="0.01" class="custom-form"
                                                                id="height" name="height"
                                                                value="{{ @$assessment_info->height }}"
                                                                style="width: 50%">
                                                            <span>cm</span>
                                                        </td>


                                                        <td colspan="4" class="text-left">
                                                            <strong>Weight:</strong>
                                                            <input type="number" step="0.01" class="custom-form"
                                                                id="weight" name="weight"
                                                                value="{{ @$assessment_info->weight }}"
                                                                style="width: 50%">
                                                            <span>kg</span>
                                                        </td>
                                                    </tr>


                                                    <tr>
                                                        <td class="text-center" colspan="12"><b>REVIEW OF SYSTEM</b>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td colspan="4" class="text-center" style="width: 25%">
                                                            <b>System</b>
                                                        </td>
                                                        <td colspan="4" class="text-center" style="width: 35%">
                                                            <b>Symptoms</b>
                                                        </td>
                                                        <td colspan="4" class="text-center" style="width: 40%">
                                                            <b>Physical Examination</b>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="4" class="text-left"><b>General</b></td>
                                                        <td colspan="4" class="text-left">General Fever/ chills/
                                                            sleep/ weight/ appetite </td>
                                                        <td colspan="4" class="text-left"><input type="text"
                                                                class="custom-form" id="general" name="general"
                                                                value="{{ @$assessment_info->general_symptoms }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="4" class="text-left"><b>Skin</b></td>
                                                        <td colspan="4" class="text-left">Rash/color/ texture/
                                                            hair/ New moles/ lesion</td>
                                                        <td colspan="4" class="text-left"><input type="text"
                                                                class="custom-form" id="skin" name="skin"
                                                                value="{{ @$assessment_info->skin_symptoms }}"></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="4" class="text-left"><b>Eyes</b></td>
                                                        <td colspan="4" class="text-left">Pain/ inflammation/
                                                            vision/ Diplopia/ glaucoma</td>
                                                        <td colspan="4" class="text-left"><input type="text"
                                                                class="custom-form" id="eyes" name="eyes"
                                                                value="{{ @$assessment_info->eyes_symptoms }}"></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="4" class="text-left"><b>ENT</b></td>
                                                        <td colspan="4" class="text-left">Pain/sore throat/
                                                            hearing/ discharge/ tinnitus/ vertigo </td>
                                                        <td colspan="4" class="text-left"><input type="text"
                                                                class="custom-form" id="ent" name="ent"
                                                                value="{{ @$assessment_info->ent_symptoms }}"></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="4" class="text-left"><b>Breasts</b></td>
                                                        <td colspan="4" class="text-left">Pain/masses/ Nipple
                                                            discharge/ skin changes</td>
                                                        <td colspan="4" class="text-left"><input type="text"
                                                                class="custom-form" id="breasts" name="breasts"
                                                                value="{{ @$assessment_info->breast_symptoms }}"></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="4" class="text-left"><b>Cardio Vascular/
                                                                Pulmonary</b></td>
                                                        <td colspan="4" class="text-left">Pain/ discomfort/
                                                            pressure/ Edema/ dyspnea/ orthopnea/ Palpitations/ syncope/
                                                            Sputum/ cough/ hemoptysis</td>
                                                        <td colspan="4" class="text-left"><input type="text"
                                                                class="custom-form" id="cardio_vascular"
                                                                name="cardio_vascular"
                                                                value="{{ @$assessment_info->cardio_symptoms }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="4" class="text-left"><b>Gastro Intestinal</b>
                                                        </td>
                                                        <td colspan="4" class="text-left">Pain/ constipation/
                                                            diarrhea/ dysphagia/ nausea/ vomiting/ jaundice/ bleeding
                                                        </td>
                                                        <td colspan="4" class="text-left"><input type="text"
                                                                class="custom-form" id="gastro_intestinal"
                                                                name="gastro_intestinal"
                                                                value="{{ @$assessment_info->gastrop_symptoms }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="4" class="text-left"><b>Genito Urinary</b>
                                                        </td>
                                                        <td colspan="4" class="text-left">Dysuria/ discharge/
                                                            hesitancy/ Nocturia/ retention/ bleeding/ stones/
                                                            infections/ STD’s/ incontinence/ impotence</td>
                                                        <td colspan="4" class="text-left"><input type="text"
                                                                class="custom-form" id="genito_urinary"
                                                                name="genito_urinary"
                                                                value="{{ @$assessment_info->genito_symptoms }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="4" class="text-left"><b>Musculo-skeletal</b>
                                                        </td>
                                                        <td colspan="4" class="text-left">Pain/ stiffness/
                                                            swelling/ Joint/ inflammation</td>
                                                        <td colspan="4" class="text-left"><input type="text"
                                                                class="custom-form" id="musculo_skeletal"
                                                                name="musculo_skeletal"
                                                                value="{{ @$assessment_info->musculo_symptoms }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="4" class="text-left"><b>Neurological</b></td>
                                                        <td colspan="4" class="text-left">Neurological Headache/
                                                            seizures/ paralysis/ weakness/ tremor/ gait/ sensation</td>
                                                        <td colspan="4" class="text-left"><input type="text"
                                                                class="custom-form" id="neurological"
                                                                name="neurological"
                                                                value="{{ @$assessment_info->neurological_symptoms }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="4" class="text-left"><b>Psychological</b></td>
                                                        <td colspan="4" class="text-left">At risk of self harm/
                                                            mood swings/ depression/ anxiety/ memory</td>
                                                        <td colspan="4" class="text-left"><input type="text"
                                                                class="custom-form" id="psychological"
                                                                name="psychological"
                                                                value="{{ @$assessment_info->psychological_symptoms }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="4" class="text-left"><b>Endocrine</b></td>
                                                        <td colspan="4" class="text-left">Heat/cold intolerance/
                                                            weight change/ diabetes/ goiter/ appetite/ thirst/ polyuria
                                                        </td>
                                                        <td colspan="4" class="text-left"><input type="text"
                                                                class="custom-form" name="endocrine" id="endocrine"
                                                                value="{{ @$assessment_info->endocrine_symptoms }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="4" class="text-left"><b>Hemolymphatic</b></td>
                                                        <td colspan="4" class="text-left">Bruising/
                                                            enlargement/bleeding</td>
                                                        <td colspan="4" class="text-left"><input type="text"
                                                                class="custom-form" id="hemolymphatic"
                                                                name="hemolymphatic"
                                                                value="{{ @$assessment_info->hemolymphatic_symptoms }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="4" class="text-left"><b>Obstetrics &
                                                                Gynecological</b></td>
                                                        <td colspan="4" class="text-left">Obstetrics &
                                                            Gynecological Bleeding/ discharge/ lesions/ Itching/ pelvic
                                                            pain LMP Parity Birth Control Type used: </td>
                                                        <td colspan="4" class="text-left"><input type="text"
                                                                class="custom-form" id="obstetrics" name="obstetrics"
                                                                value="{{ @$assessment_info->obs_symptoms }}"></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>


                                       <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <tbody>
                                                    <tr>
                                                        <td colspan="2" class="text-center"><b>SPECIALIZED
                                                                ASSESSMENT OF HIGH RISK AND VULNERABLE PATIENTS WHEN
                                                                APPLICABLE</b></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" class="text-left">The patients requires
                                                            special assessment being part of special population group?
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td class="text-left border-right-0">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="frail_elderly" id="frail_elderly"
                                                                    value="1"
                                                                    {{ @$assessment_info->frail_elderly_ind == 1 ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="frail_elderly">Frail
                                                                    elderly</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="chronic_pain" id="chronic_pain"
                                                                    value="1"
                                                                    {{ @$assessment_info->chronic_pain_ind == 1 ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="chronic_pain">With
                                                                    intense or chronic
                                                                    pain</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="termination_pregnancy"
                                                                    id="termination_pregnancy" value="1"
                                                                    {{ @$assessment_info->exp_ter_pregnancy_ind == 1 ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="termination_pregnancy">Experiencing
                                                                    termination of pregnancy</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="substance_dependency"
                                                                    id="substance_dependency" value="1"
                                                                    {{ @$assessment_info->substance_ind == 1 ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="substance_dependency">Substance
                                                                    dependency</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="communicable_disease"
                                                                    id="communicable_disease" value="1"
                                                                    {{ @$assessment_info->comm_disease_ind == 1 ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="communicable_disease">With infectious or
                                                                    communicable disease</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="immunocompromised" id="immunocompromised"
                                                                    value="1"
                                                                    {{ @$assessment_info->immunocompromised_ind == 1 ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="immunocompromised">Immunocompromised </label>
                                                            </div>
                                                        </td>
                                                        <td class="text-left ">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="terminally" id="terminally" value="1"
                                                                    {{ @$assessment_info->terminally_ill_ind == 1 ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="terminally">Terminally
                                                                    ill/dying
                                                                    patient</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="women_labour" id="women_labour"
                                                                    value="1"
                                                                    {{ @$assessment_info->woman_in_labor_ind == 1 ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="women_labour">Women in
                                                                    labor</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="emotional_disorder" id="emotional_disorder"
                                                                    value="1"
                                                                    {{ @$assessment_info->psychiiatric_ind == 1 ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="emotional_disorder">Patient with emotional or
                                                                    psychiatric disorder</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="victim_neglect" id="victim_neglect"
                                                                    value="1"
                                                                    {{ @$assessment_info->vic_abuse_ind == 1 ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="victim_neglect">Victims
                                                                    of abuse and
                                                                    neglect</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="radiation_therapy" id="radiation_therapy"
                                                                    value="1"
                                                                    {{ @$assessment_info->chemotherapy_ind == 1 ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="radiation_therapy">Chemotherapy or radiation
                                                                    therapy</label>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td colspan="2" class="text-center"><b>ASSESSMENT NOTES
                                                                (Investigation Results / Reference / Additional
                                                                Notes)</b></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">
                                                            <textarea rows="5" placeholder="write here ..." class="custom-form" id="assesment_notes"
                                                                name="assesment_notes">{{ @$assessment_info->assessment_notes }}</textarea>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>




                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <tbody>
                                                    <tr>
                                                        <td colspan="8" class="text-center"><b>POVISIONAL DIAGNOSIS
                                                                / PROBLEM LIST</b></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="8">
                                                            <textarea name="povisional_diagnosis" id="povisional_diagnosis" rows="5" placeholder="write here ..."
                                                                class="custom-form">{{ @$assessment_info->povisional_diagnosis }}</textarea>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td colspan="8" class="text-center"><b>INITIAL CARE
                                                                PLAN</b></td>
                                                    </tr>

                                                    <tr>
                                                        <td colspan="4" class="text-center" style="width: 50%">
                                                            <b>Problems</b>
                                                        </td>
                                                        <td colspan="4" class="text-center"><b>Measurable treatment
                                                                goals</b></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="4" class="text-center" style="width: 50%">
                                                            <textarea name="initial_care_problem" id="initial_care_problem" rows="5" placeholder="write here ..."
                                                                class="custom-form">{{ @$assessment_info->care_plan_problem }}</textarea>
                                                        </td>
                                                        <td colspan="4" class="text-center">
                                                            <textarea name="initial_treatment_goals" id="initial_treatment_goals" rows="5" placeholder="write here ..."
                                                                class="custom-form">{{ @$assessment_info->care_plan_goals }}</textarea>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td colspan="3" class="text-left">
                                                            Preventive aspects of care (diet, exercise, rehabilitation,
                                                            curative, palliative care):
                                                        </td>
                                                        <td colspan="5">
                                                            <input type="text" class="custom-form"
                                                                name="preventive_aspects" id="preventive_aspects"
                                                                value="{{ @$assessment_info->preventive_aspects }}">
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td colspan="3" class="text-left">
                                                            Discharge plan
                                                        </td>

                                                        <td class="text-center">
                                                            <select class="custom-form" name="discharge_yes_no"
                                                                id="discharge_yes_no">
                                                                <option value="0" selected>No</option>
                                                                <option value="1"
                                                                    {{ @$assessment_info->discharge_ind == 1 ? 'selected' : '' }}>
                                                                    Yes</option>
                                                            </select>
                                                        </td>



                                                        <td colspan="4" class="text-left">
                                                            <input type="text" class="custom-form"
                                                                name="discharge_text" id="discharge_text"
                                                                value="{{ @$assessment_info->discharge_plan }}">
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td colspan="3" class="text-left">
                                                            Home Equipment anticipated
                                                        </td>

                                                        <td class="text-center">
                                                            <select class="custom-form" name="anticipated_yes_no"
                                                                id="anticipated_yes_no">
                                                                <option value="0" selected>No</option>
                                                                <option value="1"
                                                                    {{ @$assessment_info->home_equipment_ind == 1 ? 'selected' : '' }}>
                                                                    Yes</option>
                                                            </select>
                                                        </td>



                                                        <td colspan="4" class="text-left">
                                                            <input type="text" class="custom-form"
                                                                name="anticipated" id="anticipated"
                                                                value="{{ @$assessment_info->home_equipment_plan }}">
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td colspan="3" class="text-left">
                                                            Physiotherapy at home anticipated
                                                        </td>

                                                        <td class="text-center">
                                                            <select class="custom-form" name="physiotherapy_yes_no"
                                                                id="physiotherapy_yes_no">
                                                                <option value="0" selected>No</option>
                                                                <option value="1"
                                                                    {{ @$assessment_info->physiotheraphy_ind == 1 ? 'selected' : '' }}>
                                                                    Yes</option>
                                                            </select>
                                                        </td>

                                                        <td colspan="4" class="text-left">
                                                            <input type="text" class="custom-form"
                                                                name="physiotherapy" id="physiotherapy"
                                                                value="{{ @$assessment_info->physiotheraphy_plan }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3" class="text-left">
                                                            Wound Care need at home anticipated
                                                        </td>

                                                        <td class="text-center">
                                                            <select class="custom-form" name="wound_care_yes_no"
                                                                id="wound_care_yes_no">
                                                                <option value="0" selected>No</option>
                                                                <option value="1"
                                                                    {{ @$assessment_info->wound_care_ind == 1 ? 'selected' : '' }}>
                                                                    Yes</option>
                                                            </select>
                                                        </td>

                                                        <td colspan="3" class="text-left">
                                                            <input type="text" class="custom-form"
                                                                name="wound_care" id="wound_care"
                                                                value="{{ @$assessment_info->wound_care_plan }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3" class="text-left">
                                                            Social support need at home
                                                        </td>

                                                        <td class="text-center">
                                                            <select class="custom-form" name="social_yes_no"
                                                                id="social_yes_no">
                                                                <option value="0" selected>No</option>
                                                                <option value="1"
                                                                    {{ @$assessment_info->social_support_ind == 1 ? 'selected' : '' }}>
                                                                    Yes</option>
                                                            </select>
                                                        </td>

                                                        <td colspan="3" class="text-left">
                                                            <input type="text" class="custom-form"
                                                                id="social_support" name="social_support"
                                                                value="{{ @$assessment_info->social_support_plan }}">
                                                        </td>
                                                    </tr>





                                                    <tr>
                                                        <td>Expected duration of stay: </td>
                                                        <td colspan="3"><input type="text" class="custom-form"
                                                                id="expected_duration" name="expected_duration"
                                                                value="{{ @$assessment_info->expected_duration }}">
                                                        </td>
                                                        <td>Name, Sign & ID of the Doctor </td>
                                                        <td colspan="3">
                                                            <input type="text" class="custom-form"
                                                                id="doctor_signature" name="doctor_signature"
                                                                value="{{ @$assessment_info->doctor_signature_name }}">
                                                            <input type="hidden" class="custom-form"
                                                                id="doctor_signature_id" name="doctor_signature_id"
                                                                value="{{ @$assessment_info->doctor_no_fk }}">
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td><b>Noted by</b></td>
                                                        <td><b>Nurse</b></td>
                                                        <td><b>Dietician</b></td>
                                                        <td colspan="5"><b>Others</b></td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Sign Id</b></td>
                                                        <td>
                                                            <input type="text" class="custom-form" id="nurse_by"
                                                                name="nurse_by"
                                                                value="{{ @$assessment_info->nurse_name }}">
                                                            <input type="hidden" class="custom-form"
                                                                id="nurse_by_id" name="nurse_by_id"
                                                                value="{{ @$assessment_info->nurse_no_fk }}">
                                                        </td>

                                                        <td>
                                                            <input type="text" class="custom-form"
                                                                id="dietician_by" name="dietician_by"
                                                                value="{{ @$assessment_info->dietician_by_name }}">
                                                            <input type="hidden" class="custom-form"
                                                                id="dietician_by_id" name="dietician_by_id"
                                                                value="{{ @$assessment_info->dietician_no_fk }}">
                                                        </td>
                                                        <td colspan="5">
                                                            <input type="text" class="custom-form"
                                                                id="others_emp" name="others_emp"
                                                                value="{{ @$assessment_info->others_emp_name }}">
                                                            <input type="hidden" class="custom-form"
                                                                id="others_emp_id" name="others_emp_id"
                                                                value="{{ @$assessment_info->others_emp }}">
                                                        </td>

                                                    </tr>

                                                    <tr>
                                                        <td colspan="8">
                                                            <p style="text-align: justify">
                                                                I hereby affirm that all the information furnished by me
                                                                in this document is true & correct to the best of my
                                                                knowledge, belief and understanding. I shall assume
                                                                complete liability and indemnify Unico Hospitals Plc and
                                                                its associates against any action/ claim/ damage/
                                                                arising out of the above information. The treatment plan
                                                                as indicated above relating to me/my relative (patient
                                                                name & relationship) ………………………………………………………………………………….has
                                                                been explained to me in detail. I agree to the proposed
                                                                treatment plan after fully understanding the same. আমি
                                                                এতদ্বারা নিশ্চিত করছি যে এই নথিতে আমার দ্বারা প্রদত্ত
                                                                সমস্ত তথ্য আমার জ্ঞান, বিশ্বাস এবং বোধগম্যতা অনুসারে
                                                                সত্য এবং সঠিক। আমি সম্পূর্ণ দায়বদ্ধতা গ্রহণ করব এবং
                                                                উপরোক্ত তথ্য থেকে উদ্ভূত যেকোনো পদক্ষেপ/দাবি/ক্ষতি/এর
                                                                বিরুদ্ধে Unico Hospitals Plc এবং এর সহযোগীদের ক্ষতিপূরণ
                                                                দেব। আমার/আমার আত্মীয় (রোগীর নাম ও
                                                                সম্পর্ক)………………………………………………………………………………………………………………
                                                                সম্পর্কিত উপরে নির্দেশিত চিকিৎসা পরিকল্পনা আমাকে
                                                                বিস্তারিতভাবে ব্যাখ্যা করা হয়েছে। আমি সম্পূর্ণরূপে
                                                                বোঝার পরে প্রস্তাবিত চিকিত্সা পরিকল্পনার সাথে সম্মত।
                                                            </p>
                                                        </td>
                                                    </tr>


                                                    <tr>
                                                        <td colspan="3" class="text-left">
                                                            Patient’s Name:
                                                        </td>
                                                        <td colspan="5">
                                                            <input type="text" class="custom-form"
                                                                id="patient_name" name="patient_name"
                                                                value="{{ @$patient_info->patient_name }}" readonly>
                                                            <input type="hidden" class="custom-form"
                                                                id="patient_id" name="patient_id"
                                                                value="{{ @$patient_info->patient_no_pk }}">
                                                            <input type="hidden" class="custom-form"
                                                                id="admission_no_pk" name="admission_no_pk"
                                                                value="{{ @$patient_info->admission_no_pk }}">
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td colspan="3" class="text-left">
                                                            Consultant’s Name:
                                                        </td>
                                                        <td colspan="5">
                                                            <input type="text" class="custom-form"
                                                                id="primary_doctor_name" name="primary_doctor_name"
                                                                value="{{ @$patient_info->primary_doctor_name }}"
                                                                readonly>
                                                            <input type="hidden" class="custom-form"
                                                                id="primary_doctor_id" name="primary_doctor_id"
                                                                value="{{ @$patient_info->primary_doctor_no_fk }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3" class="text-left">
                                                            Surrogate Name:
                                                        </td>
                                                        <td colspan="5">
                                                            <input type="text" class="custom-form"
                                                                id="surrogate_name" name="surrogate_name"
                                                                value="{{ @$assessment_info->surrogate_name }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3" class="text-left">
                                                            Surrogate Relation:
                                                        </td>
                                                        <td colspan="5">
                                                            <input type="text" class="custom-form"
                                                                id="relation_surrogate" name="relation_surrogate"
                                                                value="{{ @$assessment_info->relation_surrogate }}">
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="text-center">
                                            <button class="btn btn-md btn-success px-5" type="button"
                                                onclick="saveAssesment()">Save</button>
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

<!-- Add New Dose Option Modal -->
<div class="modal fade" id="addMoreDropdownOption" tabindex="-1" role="dialog"
    aria-labelledby="addMoreDropdownOptionTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" id="newDropdownOptionDiv">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="addMoreDropdownOptionHeader">Header</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="col-md-12">
                        <label for="new_dose_opt" id="addMoreDropdownOptionLabel"
                            class="col-form-label col-form-label-sm">Label</label>
                        <input type="hidden" name="thisElement_id" id="thisElement_id" value="">
                        <input type="text" class="form-control" id="new_dropdown_opt" name="new_dropdown_opt"
                            value="" placeholder="Enter new option" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer py-1">
                <div class="col-md-12 text-right">
                    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-sm btn-primary add_new_option_btn"
                        onclick="prescriptionFunc.addToDropdown(this)">Add</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
    function others_ind() {
        if ($("#others_ind").is(":checked")) {
            $("#others_specify").attr('disabled', false);
        } else {
            $("#others_specify").attr('disabled', true);
        }
    }

    $(document).ready(function() {
        openDoctorAutocomplete("#doctor_name", "doctor_id");
        openItemAutocomplete($("#medicine_item"), "MED", "#hdn_medicine_item_id", "#medicine_item");

        // Autocomplete
        openDoctorAutocomplete('#doctor_signature', 'doctor_signature_id');
        openDoctorAutocomplete('#nurse_by', 'nurse_by_id');
        openDoctorAutocomplete('#dietician_by', 'dietician_by_id');
        openDoctorAutocomplete('#others_emp', 'others_emp_id');




        $(".select2").select2();
    })


    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function saveAssesment() {
        let formElement = document.querySelector('#assesmentForm');
        let formData = new FormData(formElement);
        if ($('#admission_no_pk').val() == '') {
            alert('Amission no required');
            return false;
        }

        if ($('#patient_id').val() == '') {
            alert('Amission no required');
            return false;
        }

        $.ajax({
            url: "{{ route('v2.ipd.assesment-save') }}",
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

        // if(medicine_route == 0){
        //     alert('Medicine Route Required !');
        //     return false;
        // }

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

        // if(instruction == 0){
        //     alert('Medicine Instruction !');
        //     return false;
        // }


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
                            <select class="form-control form-control-sm select2 m-0 p-0" id="instruction_${count}" name="instruction[]">
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
        $("#nurse_station_medicine").trigger("reset");
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


    function downloadPatientAssesment(type) {
        var admission_no_pk = '<?php echo json_encode(@$patient_info->admission_no_pk); ?>';
        var patient_no_pk = '<?php echo json_encode(@$patient_info->patient_no_pk); ?>';
        admission_no_pk = JSON.parse(admission_no_pk);
        patient_no_pk = JSON.parse(patient_no_pk);

        var url = '{{ route('v2.ipd.download-patient-assesment') }}';
        $.ajax({
            url: url,
            method: 'post',
            data: {
                admission_no_pk: admission_no_pk,
                patient_no_pk: patient_no_pk
            },

            xhrFields: {
                responseType: 'blob'
            },
            success: function(data) {
                var downloadLink = document.createElement('a');
                var url = window.URL.createObjectURL(new Blob([data]));
                downloadLink.href = url;
                downloadLink.setAttribute('download', 'patient_assesment.pdf');
                document.body.appendChild(downloadLink);
                downloadLink.click();
                document.body.removeChild(downloadLink);
                window.URL.revokeObjectURL(url);
            },
            error: function(xhr, status, error) {
                $('.common-modal-notify-error').modal('show');
                $('.common-modal-notify-error .modal-title').html('Failed');
                $('.common-modal-notify-error .modal-body').html(error);
            }
        });
    }
</script>
