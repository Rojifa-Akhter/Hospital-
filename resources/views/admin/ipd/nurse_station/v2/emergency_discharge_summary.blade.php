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

<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

<main id="page-content">
    <section class="fixed_asset">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div
                        class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                        <div class="col-md-10">
                            <h5 class="mt-2 mb-0">Emergency Discharge Summary</h5>
                            <small>IPD / Nurse Station / Emergency Discharge Summary</small>
                        </div>
                        <div class="col-md-2">
                            <a class="btn btn-md btn-warning" target="_blank"
                                href="{{route('v2.ipd.download-emergency-discharge-summary',[$patient_info->patient_no_pk, $patient_info->admission_no_pk])}}">PDF
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
                                    <form action="" method="post" id="emergencyDischargeSummary">
                                        @csrf
                                        <div class="table-responsive">
                                            <table class="table table-bordered">


                                                <tbody>

                                                    <tr>
                                                        <td class="text-left"><strong>Return to ED within 72
                                                                hours:</strong></td>
                                                        <td class="text-center">
                                                            <input type="hidden" class="custom-form" id="patient_no_fk"
                                                                name="patient_no_fk"
                                                                value="{{@$patient_info->patient_no_pk}}">
                                                            <input type="hidden" class="custom-form"
                                                                id="admission_no_fk" name="admission_no_fk"
                                                                value="{{@$patient_info->admission_no_pk}}">
                                                            <select class="custom-form" name="return_ed_72hrs"
                                                                id="return_ed_72hrs">
                                                                <option value="" selected>select one</option>
                                                                <option value="No"
                                                                    {{ @$data->return_ed_72hrs == 'No' ? 'selected' : '' }}>
                                                                    No</option>
                                                                <option value="Yes"
                                                                    {{ @$data->return_ed_72hrs == 'Yes' ? 'selected' : '' }}>
                                                                    Yes</option>
                                                            </select>
                                                        </td>
                                                        <td class="text-center">
                                                            <span
                                                                id="return_ed_72hrs_text">{{ @$data->return_ed_72hrs }}</span>
                                                        </td>
                                                        <td class="text-left"><strong>Triage Category:</strong></td>
                                                        <td class="text-center">
                                                            <select class="custom-form" name="triage_category"
                                                                id="triage_category">
                                                                <option value="" selected>Select one</option>
                                                                <option value="1"
                                                                    {{ @$data->triage_category == '1' ? 'selected' : '' }}>
                                                                    1</option>
                                                                <option value="2"
                                                                    {{ @$data->triage_category == '2' ? 'selected' : '' }}>
                                                                    2</option>
                                                                <option value="3"
                                                                    {{ @$data->triage_category == '3' ? 'selected' : '' }}>
                                                                    3</option>
                                                                <option value="4"
                                                                    {{ @$data->triage_category == '4' ? 'selected' : '' }}>
                                                                    4</option>
                                                                <option value="5"
                                                                    {{ @$data->triage_category == '5' ? 'selected' : '' }}>
                                                                    5</option>
                                                            </select>
                                                        </td>
                                                        <td class="text-center">
                                                            <span id="triage_category_text"></span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left"><strong>Allergies:</strong></td>
                                                        <td class="text-center">
                                                            <select class="custom-form" name="allergies" id="allergies"
                                                                onchange="toggleAllergiesFields()">
                                                                <option value="" selected>Select one</option>
                                                                <option value="No"
                                                                    {{ @$data->allergies == 'No' ? 'selected' : '' }}>No
                                                                </option>
                                                                <option value="Yes"
                                                                    {{ @$data->allergies == 'Yes' ? 'selected' : '' }}>
                                                                    Yes</option>
                                                            </select>
                                                        </td>
                                                        <td class="text-left"><strong>Allergies Tpye:</strong></td>

                                                        <td class="text-center" colspan="2">
                                                            <div id="allergy_types_fields"
                                                                style="{{ @$data->allergies == 'Yes' ? '' : 'display:none;' }}">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="allergy_blood" id="allergy_blood"
                                                                        value="Yes"
                                                                        {{ @$data->allergy_blood == 'Yes' ? 'checked' : '' }}>
                                                                    <label class="form-check-label"
                                                                        for="allergy_blood">Blood Transfusion</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="allergy_drug" id="allergy_drug"
                                                                        value="Yes"
                                                                        {{ @$data->allergy_drug == 'Yes' ? 'checked' : '' }}>
                                                                    <label class="form-check-label"
                                                                        for="allergy_drug">Drug</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="allergy_food" id="allergy_food"
                                                                        value="Yes"
                                                                        {{ @$data->allergy_food == 'Yes' ? 'checked' : '' }}>
                                                                    <label class="form-check-label"
                                                                        for="allergy_food">Food</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="allergy_others" id="allergy_others"
                                                                        value="Yes"
                                                                        {{ @$data->allergy_others == 'Yes' ? 'checked' : '' }}
                                                                        onchange="toggleAllergyOthersInput()">
                                                                    <label class="form-check-label"
                                                                        for="allergy_others">Others:</label>

                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td colspan="1">
                                                            <input type="text" class="custom-form"
                                                                name="allergy_others_specify"
                                                                id="allergy_others_specify" placeholder="Please Specify"
                                                                value="{{ @$data->allergy_others_specify ?? '' }}"
                                                                style="display: {{ @$data->allergy_others == 'Yes' ? 'inline-block' : 'none' }};">
                                                        </td>

                                                    </tr>
                                                    <script>
                                                    function toggleAllergiesFields() {
                                                        var allergies = document.getElementById('allergies').value;
                                                        var allergyTypesFields = document.getElementById(
                                                            'allergy_types_fields');
                                                        if (allergies === 'Yes') {
                                                            allergyTypesFields.style.display = '';
                                                        } else {
                                                            allergyTypesFields.style.display = 'none';
                                                            // Uncheck all radios and hide others input
                                                            document.querySelectorAll(
                                                                    '#allergy_types_fields input[type="radio"]')
                                                                .forEach(function(rb) {
                                                                    rb.checked = false;
                                                                });
                                                            document.getElementById('allergy_others_specify').style
                                                                .display = 'none';
                                                            document.getElementById('allergy_others_specify').value =
                                                                '';
                                                        }
                                                    }

                                                    function toggleAllergyOthersInput() {
                                                        var othersRadio = document.getElementById('allergy_others');
                                                        var specifyInput = document.getElementById(
                                                            'allergy_others_specify');
                                                        if (othersRadio.checked) {
                                                            specifyInput.style.display = 'inline-block';
                                                        } else {
                                                            specifyInput.style.display = 'none';
                                                            specifyInput.value = '';
                                                        }
                                                    }
                                                    document.addEventListener('DOMContentLoaded', function() {
                                                        toggleAllergiesFields();
                                                        document.getElementById('allergies').addEventListener(
                                                            'change', toggleAllergiesFields);
                                                        var othersRadio = document.getElementById(
                                                            'allergy_others');
                                                        if (othersRadio) {
                                                            othersRadio.addEventListener('change',
                                                                toggleAllergyOthersInput);
                                                        }
                                                    });
                                                    </script>


                                                    <tr>
                                                        <td class="text-left"><strong>MLC:</strong></td>
                                                        <td class="text-center">
                                                            <select class="custom-form" name="mlc" id="mlc"
                                                                onchange="toggleMlcFields()">
                                                                <option value="" selected>Select one</option>
                                                                <option value="No"
                                                                    {{ @$data->mlc == 'No' ? 'selected' : '' }}>No
                                                                </option>
                                                                <option value="Yes"
                                                                    {{ @$data->mlc == 'Yes' ? 'selected' : '' }}>Yes
                                                                </option>
                                                            </select>
                                                        </td>
                                                        <td class="text-left"><strong>If yes, MLC No:</strong></td>
                                                        <td class="text-center">
                                                            <input type="text" class="custom-form" name="mlc_no"
                                                                id="mlc_no" value="{{ @$data->mlc_no ?? '' }}"
                                                                placeholder="Enter MLC No"
                                                                style="{{ @$data->mlc == 'Yes' ? '' : 'display:none;' }}">
                                                        </td>
                                                        <td class="text-left"><strong>Blood Group:</strong></td>
                                                        <td class="text-center">
                                                            <input type="text" class="custom-form" name="blood_group"
                                                                id="blood_group" value="{{ @$data->blood_group ?? '' }}"
                                                                placeholder="Enter Blood Group">
                                                        </td>
                                                        <script>
                                                        function toggleMlcFields() {
                                                            var mlc = document.getElementById('mlc').value;
                                                            var mlcNo = document.getElementById('mlc_no');
                                                            if (mlc === 'Yes') {
                                                                mlcNo.style.display = '';
                                                            } else {
                                                                mlcNo.style.display = 'none';
                                                                mlcNo.value = '';
                                                            }
                                                        }
                                                        document.addEventListener('DOMContentLoaded', function() {
                                                            toggleMlcFields();
                                                            document.getElementById('mlc').addEventListener(
                                                                'change', toggleMlcFields);
                                                        });
                                                        </script>
                                                    </tr>

                                                    <tr>
                                                        <td class="text-left"><strong>Provisional Diagnosis:</strong>
                                                        </td>
                                                        <td colspan="5">
                                                            <textarea class="custom-form" name="provisional_diagnosis"
                                                                id="provisional_diagnosis" rows="2"
                                                                placeholder="Enter provisional diagnosis">{{ @$data->provisional_diagnosis ?? '' }}</textarea>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left"><strong>Chief Complaints:</strong></td>
                                                        <td colspan="5">
                                                            <textarea class="custom-form" name="chief_complaints"
                                                                id="chief_complaints" rows="2"
                                                                placeholder="Enter chief complaints">{{ @$data->chief_complaints ?? '' }}</textarea>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left"><strong>Past Clinical History:</strong>
                                                        </td>
                                                        <td colspan="5">
                                                            <textarea class="custom-form" name="past_clinical_history"
                                                                id="past_clinical_history" rows="2"
                                                                placeholder="Enter past clinical history">{{ @$data->past_clinical_history ?? '' }}</textarea>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td rowspan="1" class="text-left align-top" colspan="3">
                                                            <strong>Significant Physical &amp; Other findings:</strong>
                                                            <textarea class="custom-form  border"
                                                                name="significant_findings" id="significant_findings"
                                                                rows="3"
                                                                placeholder="Enter significant physical & other findings">{{ @$data->significant_findings ?? '' }}</textarea>
                                                            <br>
                                                            <strong>Investigations Advised:</strong>
                                                            <textarea class="custom-form  border"
                                                                name="investigations_advised"
                                                                id="investigations_advised" rows="4"
                                                                placeholder="Enter investigations advised">{{ @$data->investigations_advised ?? '' }}</textarea>
                                                        </td>
                                                        <td class="text-left align-top" colspan="4">
                                                            <strong>Treatment Given:</strong>
                                                            <textarea class="custom-form border" name="treatment_given"
                                                                id="treatment_given" rows="9"
                                                                placeholder="Enter treatment given">{{ @$data->treatment_given ?? '' }}</textarea>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left"><strong>Discharge Medication &amp;
                                                                Advice:</strong></td>
                                                        <td colspan="5">
                                                            <textarea class="custom-form"
                                                                name="discharge_medication_advice"
                                                                id="discharge_medication_advice" rows="3"
                                                                placeholder="Enter discharge medication & advice">{{ @$data->discharge_medication_advice ?? '' }}</textarea>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left"><strong>Followup Advice:</strong></td>
                                                        <td colspan="5">
                                                            <textarea class="custom-form" name="followup_advice"
                                                                id="followup_advice" rows="3"
                                                                placeholder="Enter followup advice">{{ @$data->followup_advice ?? '' }}</textarea>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td class="text-left"><strong>Condition at time of
                                                                Discharge:</strong></td>
                                                        <td colspan="5">
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio"
                                                                    name="condition_discharge" id="cond_stable"
                                                                    value="stable"
                                                                    {{ @$data->condition_discharge == 'stable' ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="cond_stable">Stable</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio"
                                                                    name="condition_discharge" id="cond_critical"
                                                                    value="critical"
                                                                    {{ @$data->condition_discharge == 'critical' ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="cond_critical">Critical</label>
                                                            </div>

                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio"
                                                                    name="condition_discharge" id="cond_death"
                                                                    value="comatose_death_on_arrival"
                                                                    {{ @$data->condition_discharge == 'comatose_death_on_arrival' ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="cond_death">Death
                                                                    on arrival</label>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td class="text-left"><strong>Type of Discharge:</strong></td>
                                                        <td colspan="5">
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio"
                                                                    name="type_of_discharge" id="discharge_normal"
                                                                    value="normal"
                                                                    {{ @$data->type_of_discharge == 'normal' ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="discharge_normal">Normal</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio"
                                                                    name="type_of_discharge"
                                                                    id="discharge_referred_outside"
                                                                    value="referred_outside"
                                                                    {{ @$data->type_of_discharge == 'referred_outside' ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="discharge_referred_outside">Referred
                                                                    (Outside)</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio"
                                                                    name="type_of_discharge"
                                                                    id="discharge_referred_inside"
                                                                    value="referred_inside"
                                                                    {{ @$data->type_of_discharge == 'referred_inside' ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="discharge_referred_inside">Referred
                                                                    (Inside)</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio"
                                                                    name="type_of_discharge" id="discharge_lama"
                                                                    value="LAMA"
                                                                    {{ @$data->type_of_discharge == 'LAMA' ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="discharge_lama">LAMA</label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="6">
                                                            <table class="table table-bordered mb-0">
                                                                <thead class="medicine_thead">
                                                                    <tr>
                                                                        <th class="text-center align-middle">Vitals</th>
                                                                        <th class="text-center align-middle">BP (mm of
                                                                            Hg)</th>
                                                                        <th class="text-center align-middle">HR/min
                                                                            RR/min</th>
                                                                        <th class="text-center align-middle">Temp</th>
                                                                        <th class="text-center align-middle">
                                                                            SpO<sub>2</sub> %</th>
                                                                        <th class="text-center align-middle">Pain Score
                                                                        </th>
                                                                        <th class="text-center align-middle">GCS</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td class="text-left align-middle"><strong>At
                                                                                Admission</strong></td>
                                                                        <td><input type="text" class="custom-form"
                                                                                name="vitals_adm_bp"
                                                                                value="{{ @$data->vitals_adm_bp ?? '' }}">
                                                                        </td>
                                                                        <td><input type="text" class="custom-form"
                                                                                name="vitals_adm_hr_rr"
                                                                                value="{{ @$data->vitals_adm_hr_rr ?? '' }}">
                                                                        </td>
                                                                        <td><input type="text" class="custom-form"
                                                                                name="vitals_adm_temp"
                                                                                value="{{ @$data->vitals_adm_temp ?? '' }}">
                                                                        </td>
                                                                        <td><input type="text" class="custom-form"
                                                                                name="vitals_adm_spo2"
                                                                                value="{{ @$data->vitals_adm_spo2 ?? '' }}">
                                                                        </td>
                                                                        <td><input type="text" class="custom-form"
                                                                                name="vitals_adm_pain"
                                                                                value="{{ @$data->vitals_adm_pain ?? '' }}">
                                                                        </td>
                                                                        <td><input type="text" class="custom-form"
                                                                                name="vitals_adm_gcs"
                                                                                value="{{ @$data->vitals_adm_gcs ?? '' }}">
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="text-left align-middle"><strong>At
                                                                                Discharge</strong></td>
                                                                        <td><input type="text" class="custom-form"
                                                                                name="vitals_dis_bp"
                                                                                value="{{ @$data->vitals_dis_bp ?? '' }}">
                                                                        </td>
                                                                        <td><input type="text" class="custom-form"
                                                                                name="vitals_dis_hr_rr"
                                                                                value="{{ @$data->vitals_dis_hr_rr ?? '' }}">
                                                                        </td>
                                                                        <td><input type="text" class="custom-form"
                                                                                name="vitals_dis_temp"
                                                                                value="{{ @$data->vitals_dis_temp ?? '' }}">
                                                                        </td>
                                                                        <td><input type="text" class="custom-form"
                                                                                name="vitals_dis_spo2"
                                                                                value="{{ @$data->vitals_dis_spo2 ?? '' }}">
                                                                        </td>
                                                                        <td><input type="text" class="custom-form"
                                                                                name="vitals_dis_pain"
                                                                                value="{{ @$data->vitals_dis_pain ?? '' }}">
                                                                        </td>
                                                                        <td><input type="text" class="custom-form"
                                                                                name="vitals_dis_gcs"
                                                                                value="{{ @$data->vitals_dis_gcs ?? '' }}">
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td colspan="6">
                                                            <table class="table table-bordered mb-0">
                                                                <thead class="medicine_thead">
                                                                    <tr>
                                                                        <th class="text-center align-middle"></th>
                                                                        <th class="text-center align-middle">Name</th>
                                                                        <th class="text-center align-middle">Signature
                                                                        </th>
                                                                        <th class="text-center align-middle">Emp ID</th>
                                                                        <th class="text-center align-middle">Date</th>
                                                                        <th class="text-center align-middle">Time</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td>
                                                                            <strong>Doctor</strong>
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" class="custom-form"
                                                                                name="doc_name" id="doc_name"
                                                                                value="{{ isset($data->doc_name) ? $data->doc_name : '' }}">
                                                                            <input type="hidden" id="h_doc_id"
                                                                                name="h_doc_id"
                                                                                value="{{ isset($data->doc_no_fk) ? $data->doc_no_fk : '' }}">
                                                                        </td>
                                                                        <td>

                                                                            <p>
                                                                                <img src="{{ asset('images/uploads/doctor_images/thumb/' . $doc_info->doctor_signature_image) }}"
                                                                                    alt="image"
                                                                                    style="width: 120px;height:50px">
                                                                            </p>
                                                                        </td>
                                                                        <td>
                                                                            <p>
                                                                                {{ $doc_info->person_code ?? '' }}
                                                                            </p>

                                                                        </td>
                                                                        <td>
                                                                            <p>
                                                                                {{ $data->au_update_at  ? date('Y-m-d', strtotime($data->au_update_at))  : ($data->au_entry_at ? date('Y-m-d', strtotime($data->au_entry_at)) : '') }}
                                                                            </p>
                                                                           
                                                                        </td>
                                                                        <td>
                                                                            <p>
                                                                                {{ $data->au_update_at ? date('h:i A', strtotime($data->au_update_at)) : ($data->au_entry_at ? date('h:i A', strtotime($data->au_entry_at)) : '') }}

                                                                            </p>
                                                                            
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="text-center">
                                            <button class="btn btn-md btn-success px-5" type="button"
                                                onclick="saveEmergencyDischargeSummary()">Save</button>
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


<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
$(document).ready(function() {
    openDoctorAutocomplete('#doc_name', 'h_doc_id', 'doctor_ind', '1,2');
})


$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});






function saveEmergencyDischargeSummary() {
    let formElement = document.querySelector('#emergencyDischargeSummary');
    let formData = new FormData(formElement);
    if ($('#admission_no_fk').val() == '') {
        alert('Amission no required');
        return false;
    }

    if ($('#patient_no_fk').val() == '') {
        alert('Patient no required');
        return false;
    }

    $.ajax({
        url: "{{route('ipd.save-emergency-discharge-summary')}}",
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
            location.reload();

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
</script>