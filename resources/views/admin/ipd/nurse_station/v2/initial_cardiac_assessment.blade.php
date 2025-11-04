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
                            <h5 class="mt-2 mb-0">Initial Cardiac Assessment</h5>
                            <small>IPD / Nurse Station / Initial Cardiac Assessment</small>
                        </div>
                        <div class="col-md-2">
                            <a class="btn btn-md btn-warning" target="_blank"
                                href="{{ route('initial-cardiac-assessment-pdf', [$patient_info->patient_no_pk, $patient_info->admission_no_pk]) }}">PDF
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
                                    <form action="{{ route('initial-cardiac-assessment-store') }}" method="post"
                                        id="INDOORDIALYSIS">
                                        @csrf
                                        <input type="hidden" name="patient_no_fk" id="patient_no_fk"
                                            value="{{ $patient_no_fk }}">
                                        <input type="hidden" name="admission_no_fk" id="admission_no_fk"
                                            value="{{ $admission_id }}">
                                        <input type="hidden" name="initial_c_a_no_pk" value="{{ @$indoor_dialysis->initial_c_a_no_pk }}">

                                        <div class="table-responsive">
                                            <table border="1" width="100%" cellspacing="0" cellpadding="5">
                                                <tr>
                                                    <th colspan="6" style="text-align:center;">Initial Cardiac Assessment</th>
                                                </tr>

                                                <tr>
                                                    <td colspan="2" style="width:25%;">
                                                        <b>Date:</b><br>
                                                        <input type="date" class="form-control" name="initial_cardiac_date" value="{{ old('initial_cardiac_date', @$order_form->initial_cardiac_date ? \Carbon\Carbon::parse($order_form->initial_cardiac_date)->format('Y-m-d') : '') }}"><br>
                                                        <b>LVEF:</b>
                                                        <input type="text" class="form-control" name="lvef" value="{{ old('lvef', @$order_form->lvef) }}">
                                                    </td>

                                                    <td colspan="2" style="width:25%;">
                                                        <b>Risk Factor</b><br>
                                                        <label>
                                                            <input type="checkbox" name="risk[]" value="CAD" {{ in_array('CAD', $order_form->risk_factors ?? []) ? 'checked' : '' }}>
                                                            F/H of CAD
                                                        </label><br>
                                                        <label>
                                                            <input type="checkbox" name="risk[]" value="DM" {{ in_array('DM', $order_form->risk_factors ?? []) ? 'checked' : '' }}>
                                                            DM
                                                        </label><br>
                                                        <label>
                                                            <input type="checkbox" name="risk[]" value="Hypertension" {{ in_array('Hypertension', $order_form->risk_factors ?? []) ? 'checked' : '' }}>
                                                            Hypertension
                                                        </label><br>
                                                        <label>
                                                            <input type="checkbox" name="risk[]" value="Dyslipidemia" {{ in_array('Dyslipidemia', $order_form->risk_factors ?? []) ? 'checked' : '' }}>
                                                            Dyslipidemia
                                                        </label><br>
                                                        <label>
                                                            <input type="checkbox" name="risk[]" value="Smoking" {{ in_array('Smoking', $order_form->risk_factors ?? []) ? 'checked' : '' }}>
                                                            Smoking
                                                        </label><br>
                                                        <label>
                                                            <input type="checkbox" name="risk[]" value="Personality" {{ in_array('Personality', $order_form->risk_factors ?? []) ? 'checked' : '' }}>
                                                            Type A Personality
                                                        </label><br>
                                                        <label>
                                                            <input type="checkbox" name="risk[]" value="Obesity" {{ in_array('Obesity', $order_form->risk_factors ?? []) ? 'checked' : '' }}>
                                                            Obesity
                                                        </label>
                                                    </td>

                                                    <td colspan="2" style="width:50%;">
                                                        <b>Drug & Food Allergies & Blood Transfusion</b><br>
                                                        <input type="text" class="form-control" name="allergies" value="{{ old('allergies', @$order_form->allergies) }}"><br>
                                                        <b>Medication Reconciliation (Advice):</b>
                                                        <select class="form-control" name="medication_reconciliation" id="medication_reconciliation">
                                                            <option value="yes" {{ old('medication_reconciliation', @$order_form->medication_reconciliation) == 'yes' ? 'selected' : '' }}>Yes</option>
                                                            <option value="no" {{ old('medication_reconciliation', @$order_form->medication_reconciliation) == 'no' ? 'selected' : '' }}>No</option>
                                                        </select>
                                                        <b>Nutritional Screening (Advice):</b>
                                                        <select class="form-control" name="nutritional_screening" id="nutritional_screening">
                                                            <option value="yes" {{ old('nutritional_screening', @$order_form->nutritional_screening) == 'yes' ? 'selected' : '' }}>Yes</option>
                                                            <option value="no" {{ old('nutritional_screening', @$order_form->nutritional_screening) == 'no' ? 'selected' : '' }}>No</option>
                                                        </select>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="6">
                                                        <b>First Assessment Date:</b>
                                                        <input type="date" class="form-control d-inline-block" name="first_assess_date" value="{{ old('first_assess_date', @$order_form->first_assess_date ? \Carbon\Carbon::parse($order_form->first_assess_date)->format('Y-m-d') : '') }}" style="width:auto;">
                                                        <b>Time:</b>
                                                        <input type="time" class="form-control d-inline-block" name="first_assess_time" value="{{ old('first_assess_time', @$order_form->first_assess_time) }}" style="width:auto;"><br><br>

                                                        Temp: <input type="text" class="form-control d-inline-block" name="first_assess_temp" style="width:80px;" value="{{ old('allergies', @$order_form->allergies) }}"> F
                                                        HR: <input type="text" class="form-control d-inline-block" name="first_assess_hr" style="width:80px;" value="{{ old('first_assess_hr', @$order_form->first_assess_hr) }}"> /min
                                                        BP: <input type="text" class="form-control d-inline-block" name="first_assess_bp" style="width:120px;" value="{{ old('first_assess_bp', @$order_form->first_assess_bp) }}"> mmHg <br><br>

                                                        Pain Score: <input type="text" class="form-control d-inline-block" name="pain_score" style="width:80px;" value="{{ old('pain_score', @$order_form->pain_score) }}">
                                                        SPO2: <input type="text" class="form-control d-inline-block" name="spo2" style="width:80px;" value="{{ old('spo2', @$order_form->spo2) }}"> %
                                                        Ht: <input type="text" class="form-control d-inline-block" name="first_assess_ht" style="width:80px;" value="{{ old('first_assess_ht', @$order_form->first_assess_ht) }}"> cm
                                                        Wt: <input type="text" class="form-control d-inline-block" name="first_assess_wt" style="width:80px;" value="{{ old('first_assess_wt', @$order_form->first_assess_wt) }}"> kg
                                                        BMI: <input type="text" class="form-control d-inline-block" name="bmi" style="width:80px;" value="{{ old('bmi', @$order_form->bmi) }}">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="6">
                                                        <b>Presenting complaints:</b>
                                                        <textarea class="form-control" name="complaints">{{ old('complaints', @$order_form->complaints) }}</textarea><br>

                                                        <b>Clinical notes:</b>
                                                        <textarea class="form-control" name="clinical_notes">{{ old('clinical_notes', @$order_form->clinical_notes) }}</textarea><br>

                                                        <b>Clinical Impression:</b>
                                                        <textarea class="form-control" name="impression">{{ old('impression', @$order_form->impression) }}</textarea><br>

                                                        <b>Advice/Plan of care:</b>
                                                        <textarea class="form-control" name="plan">{{ old('plan', @$order_form->plan) }}</textarea><br>

                                                        Doctor's name (in full): <input type="text" class="form-control d-inline-block" name="doctor_name" value="{{ old('doctor_name', @$order_form->doctor_name) }}">
                                                        Signature: <input type="text" class="form-control d-inline-block" name="doctor_signature" value="{{ old('doctor_signature', @$order_form->doctor_signature) }}"><br><br>

                                                        Consultants Counter Signature: 
                                                        <input type="text" class="form-control" name="consultants_signature" value="{{ old('consultants_signature', @$order_form->consultants_signature) }}">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="6">
                                                        <b>Present History:</b><br>
                                                        <b>Chest pain:</b>
                                                        <select class="form-control" name="chest_pain" id="chest_pain">
                                                            <option value="none" {{ old('chest_pain', @$order_form->chest_pain) == 'none' ? 'selected' : '' }}>None</option>
                                                            <option value="yes" {{ old('chest_pain', @$order_form->chest_pain) == 'yes' ? 'selected' : '' }}>Yes</option>
                                                        </select>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="pain_condition[]" value="rest" {{ in_array('rest', $order_form->pain_condition ?? []) ? 'checked' : '' }}> Even at rest</label>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="pain_input_rest" placeholder="" value="{{ old('consultants_signature', @$order_form->consultants_signature) }}">
                                                    </td>
                                                    <td colspan="2" rowspan="5" style="vertical-align: top;">
                                                        1. Relieved by rest<br>
                                                        2. Relieved by medication<br>
                                                        3. No relief<br>
                                                        4. Relieved by rest and medication<br>
                                                        5. Relieved by exertion
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="pain_condition[]" value="exertion" {{ in_array('exertion', $order_form->pain_condition ?? []) ? 'checked' : '' }}> On exertion</label>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="pain_input_exertion" placeholder="" value="{{ old('pain_input_exertion', @$order_form->pain_input_exertion) }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="pain_condition[]" value="emotion" {{ in_array('emotion', $order_form->pain_condition ?? []) ? 'checked' : '' }}> On emotion/exertion</label>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="pain_input_emotion" placeholder="" value="{{ old('pain_input_emotion', @$order_form->pain_input_emotion) }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="pain_condition[]" value="food" {{ in_array('food', $order_form->pain_condition ?? []) ? 'checked' : '' }}> Following food intake</label>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="pain_input_food" placeholder="" value="{{ old('pain_input_food', @$order_form->pain_input_food) }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="pain_condition[]" value="variable" {{ in_array('variable', $order_form->pain_condition ?? []) ? 'checked' : '' }}> Variable threshold</label>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="pain_input_variable" placeholder="" value="{{ old('pain_input_variable', @$order_form->pain_input_variable) }}">
                                                    </td>
                                                </tr>


                                                <tr>
                                                    <td colspan="6">
                                                        <b>Pain elsewhere like arm, shoulder, jaw:</b>
                                                        <select class="form-control" name="pain_elsewhere" id="pain_elsewhere">
                                                            <option value="none" {{ old('pain_elsewhere', @$order_form->pain_elsewhere) == 'none' ? 'selected' : '' }}>None</option>
                                                            <option value="yes" {{ old('pain_elsewhere', @$order_form->pain_elsewhere) == 'yes' ? 'selected' : '' }}>Yes</option>
                                                        </select>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="pain_elsewhere_select[]" value="rest" {{ in_array('rest', $order_form->pain_elsewhere_select ?? []) ? 'checked' : '' }}> Even at rest</label>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="even_at_rest" placeholder="" value="{{ old('even_at_rest', @$order_form->even_at_rest) }}">
                                                    </td>
                                                    <td colspan="2" rowspan="6" style="vertical-align: top;">
                                                        1. Relieved by rest<br>
                                                        2. Relieved by medication<br>
                                                        3. No relief<br>
                                                        4. Relieved by rest and medication<br>
                                                        5. Relieved by exertion
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="pain_elsewhere_select[]" value="exertion" {{ in_array('exertion', $order_form->pain_elsewhere_select ?? []) ? 'checked' : '' }}> On exertion</label>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="on_exertion" placeholder="" value="{{ old('on_exertion', @$order_form->on_exertion) }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="pain_elsewhere_select[]" value="emotion" {{ in_array('emotion', $order_form->pain_elsewhere_select ?? []) ? 'checked' : '' }}> variable thershold</label>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="variable_thershold" placeholder="" value="{{ old('variable_thershold', @$order_form->variable_thershold) }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="pain_elsewhere_select[]" value="food" {{ in_array('food', $order_form->pain_elsewhere_select ?? []) ? 'checked' : '' }}> Periodic</label>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="periodic" placeholder="" value="{{ old('periodic', @$order_form->periodic) }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="pain_elsewhere_select[]" value="variable" {{ in_array('variable', $order_form->pain_elsewhere_select ?? []) ? 'checked' : '' }}>  Following food intake</label>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="following_food_intake" placeholder="" value="{{ old('following_food_intake', @$order_form->following_food_intake) }}">
                                                    </td>
                                                </tr>

                                                <tr></tr>

                                                <tr>
                                                    <td colspan="6">
                                                        Give details about site , intensity, radiation and frequency.
                                                        <input type="text" class="form-control" name="site_intensity_radiation" value="{{ old('site_intensity_radiation', @$order_form->site_intensity_radiation) }}">
                                                    </td>
                                                </tr>

                                                {{-- Breathlessness --}}
                                                <tr>
                                                    <td colspan="6">
                                                        <b>Breathlessness:</b>
                                                        <select class="form-control" name="breathlessness_selection" id="breathlessness_selection">
                                                            <option value="none" {{ old('breathlessness_selection', @$order_form->breathlessness_selection) == 'none' ? 'selected' : '' }}>None</option>
                                                            <option value="yes" {{ old('breathlessness_selection', @$order_form->breathlessness_selection) == 'yes' ? 'selected' : '' }}>Yes</option>
                                                        </select>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="breathlessness_multiple[]" value="rest" {{ in_array('rest', $order_form->breathlessness_multiple ?? []) ? 'checked' : '' }}> Even at rest</label>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="breathlessness_even_rest" placeholder="" value="{{ old('breathlessness_even_rest', @$order_form->breathlessness_even_rest) }}">
                                                    </td>
                                                    <td colspan="2" rowspan="6" style="vertical-align: top;">
                                                        1. Relieved by rest <br>
                                                        2. Relieved by medication<br>
                                                        3. No relief<br>
                                                        4. Relieved by rest and posture<br>
                                                        5. Relieved by lying in propped up position
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="breathlessness_multiple[]" value="exertion" {{ in_array('exertion', $order_form->breathlessness_multiple ?? []) ? 'checked' : '' }}> On exertion</label>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="breathlessness_on_exertion" placeholder="" value="{{ old('breathlessness_on_exertion', @$order_form->breathlessness_on_exertion) }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="breathlessness_multiple[]" value="emotion" {{ in_array('emotion', $order_form->breathlessness_multiple ?? []) ? 'checked' : '' }}> variable thershold</label>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="breathlessness_variable_thershold" placeholder="" value="{{ old('breathlessness_variable_thershold', @$order_form->breathlessness_variable_thershold) }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="breathlessness_multiple[]" value="food" {{ in_array('food', $order_form->breathlessness_multiple ?? []) ? 'checked' : '' }}> Periodic</label>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="breathlessness_periodic" placeholder="" value="{{ old('breathlessness_periodic', @$order_form->breathlessness_periodic) }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="breathlessness_multiple[]" value="variable" {{ in_array('variable', $order_form->breathlessness_multiple ?? []) ? 'checked' : '' }}>  Following food intake</label>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="breathlessness_food_intake" placeholder="" value="{{ old('breathlessness_food_intake', @$order_form->breathlessness_food_intake) }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="breathlessness_multiple[]" value="only_lying" {{ in_array('only_lying', $order_form->breathlessness_multiple ?? []) ? 'checked' : '' }}>  Only on lying</label>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="breathlessness_only_lying" placeholder="" value="{{ old('breathlessness_only_lying', @$order_form->breathlessness_only_lying) }}">
                                                    </td>
                                                </tr>

                                                {{-- Heaviness --}}
                                                <tr>
                                                    <td colspan="6">
                                                        <b>Heaviness:</b>
                                                        <select class="form-control" name="heaviness_selection" id="heaviness_selection">
                                                            <option value="none" {{ old('heaviness_selection', @$order_form->heaviness_selection) == 'none' ? 'selected' : '' }}>None</option>
                                                            <option value="yes" {{ old('heaviness_selection', @$order_form->heaviness_selection) == 'yes' ? 'selected' : '' }}>Yes</option>
                                                        </select>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="heaviness_multiple[]" value="rest" {{ in_array('rest', $order_form->heaviness_multiple ?? []) ? 'checked' : '' }}> Even at rest</label>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="heaviness_even_rest" placeholder="" value="{{ old('heaviness_even_rest', @$order_form->heaviness_even_rest) }}">
                                                    </td>
                                                    <td colspan="2" rowspan="6" style="vertical-align: top;">
                                                        1. Relieved by rest <br>
                                                        2. Relieved by medication<br>
                                                        3. No relief<br>
                                                        4. Relieved by rest and poisture <br>
                                                        5. Relieved by exertion
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="heaviness_multiple[]" value="exertion" {{ in_array('exertion', $order_form->heaviness_multiple ?? []) ? 'checked' : '' }}> On exertion</label>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="heaviness_on_exertion" placeholder="" value="{{ old('heaviness_on_exertion', @$order_form->heaviness_on_exertion) }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="heaviness_multiple[]" value="emotion" {{ in_array('emotion', $order_form->heaviness_multiple ?? []) ? 'checked' : '' }}> variable thershold</label>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="heaviness_variable_th" placeholder="" value="{{ old('heaviness_variable_th', @$order_form->heaviness_variable_th) }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="heaviness_multiple[]" value="food" {{ in_array('food', $order_form->heaviness_multiple ?? []) ? 'checked' : '' }}> Periodic</label>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="heaviness_periodic" placeholder="" value="{{ old('heaviness_periodic', @$order_form->heaviness_periodic) }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="heaviness_multiple[]" value="variable" {{ in_array('variable', $order_form->heaviness_multiple ?? []) ? 'checked' : '' }}>  Following food intake</label>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="heaviness_food_intake" placeholder="" value="{{ old('heaviness_food_intake', @$order_form->heaviness_food_intake) }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="heaviness_multiple[]" value="variable" {{ in_array('variable', $order_form->heaviness_multiple ?? []) ? 'checked' : '' }}>  Only on lying</label>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="heaviness_only_lying" placeholder="" value="{{ old('heaviness_only_lying', @$order_form->heaviness_only_lying) }}">
                                                    </td>
                                                </tr>

                                                {{-- Chocking --}}
                                                <tr>
                                                    <td colspan="6">
                                                        <b>Chocking:</b>
                                                        <select class="form-control" name="chocking_selection" id="chocking_selection">
                                                            <option value="none" {{ old('chocking_selection', @$order_form->chocking_selection) == 'none' ? 'selected' : '' }}>None</option>
                                                            <option value="yes" {{ old('chocking_selection', @$order_form->chocking_selection) == 'yes' ? 'selected' : '' }}>Yes</option>
                                                        </select>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="chocking_multiple[]" value="rest" {{ in_array('rest', $order_form->chocking_multiple ?? []) ? 'checked' : '' }}> Even at rest</label>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="chocking_even_rest" placeholder="" value="{{ old('heaviness_only_lying', @$order_form->heaviness_only_lying) }}">
                                                    </td>
                                                    <td colspan="2" rowspan="6" style="vertical-align: top;">
                                                        1. Relieved by rest <br>
                                                        2. Relieved by medication<br>
                                                        3. No relief<br>
                                                        4. Relieved by change posture<br>
                                                        5. Relieved by exertion
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="chocking_multiple[]" value="exertion" {{ in_array('exertion', $order_form->chocking_multiple ?? []) ? 'checked' : '' }}> On exertion</label>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="chocking_on_exertion" placeholder="" value="{{ old('chocking_on_exertion', @$order_form->chocking_on_exertion) }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="chocking_multiple[]" value="emotion" {{ in_array('emotion', $order_form->chocking_multiple ?? []) ? 'checked' : '' }}> variable thershold</label>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="chocking_variable_th" placeholder="" value="{{ old('chocking_variable_th', @$order_form->chocking_variable_th) }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="chocking_multiple[]" value="periodic" {{ in_array('periodic', $order_form->chocking_multiple ?? []) ? 'checked' : '' }}> Periodic</label>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="chocking_periodic" placeholder="" value="{{ old('chocking_periodic', @$order_form->chocking_periodic) }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="chocking_multiple[]" value="intake" {{ in_array('intake', $order_form->chocking_multiple ?? []) ? 'checked' : '' }}>  Following food intake</label>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="chocking_food_intake" placeholder="" value="{{ old('chocking_food_intake', @$order_form->chocking_food_intake) }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="chocking_multiple[]" value="lying" {{ in_array('lying', $order_form->chocking_multiple ?? []) ? 'checked' : '' }}>  Only on lying</label>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="chocking_only_lying" placeholder="" value="{{ old('chocking_only_lying', @$order_form->chocking_only_lying) }}">
                                                    </td>
                                                </tr>

                                                {{-- Restlessness /Uneasiness  --}}
                                                <tr>
                                                    <td colspan="6">
                                                        <b>Restlessness /Uneasiness :</b>
                                                        <select class="form-control" name="restlessness_selection" id="restlessness_selection">
                                                            <option value="none" {{ old('restlessness_selection', @$order_form->restlessness_selection) == 'none' ? 'selected' : '' }}>None</option>
                                                            <option value="yes" {{ old('restlessness_selection', @$order_form->restlessness_selection) == 'yes' ? 'selected' : '' }}>Yes</option>
                                                        </select>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="restlessness_multiple[]" value="rest" {{ in_array('rest', $order_form->restlessness_multiple ?? []) ? 'checked' : '' }}> Even at rest</label>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="restlessness_even_rest" placeholder="" value="{{ old('restlessness_even_rest', @$order_form->restlessness_even_rest) }}">
                                                    </td>
                                                    <td colspan="2" rowspan="6" style="vertical-align: top;">
                                                        1. Relieved by rest <br>
                                                        2. Relieved by medication<br>
                                                        3. No relief<br>
                                                        4. Relieved by Change posture<br>
                                                        5. Relieved by lying in propped up position<br>
                                                        6. Relieved by antacid<br>
                                                        7. Relieved by blechig
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="restlessness_multiple[]" value="exertion" {{ in_array('exertion', $order_form->restlessness_multiple ?? []) ? 'checked' : '' }}> On exertion</label>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="restlessness_on_exertion" placeholder="" value="{{ old('restlessness_on_exertion', @$order_form->restlessness_on_exertion) }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="restlessness_multiple[]" value="thershold" {{ in_array('thershold', $order_form->restlessness_multiple ?? []) ? 'checked' : '' }}> variable thershold</label>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="restlessness_variable_th" placeholder="" value="{{ old('restlessness_variable_th', @$order_form->restlessness_variable_th) }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="restlessness_multiple[]" value="periodic" {{ in_array('periodic', $order_form->restlessness_multiple ?? []) ? 'checked' : '' }}> Periodic</label>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="restlessness_periodic" placeholder="" value="{{ old('restlessness_periodic', @$order_form->restlessness_periodic) }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="restlessness_multiple[]" value="intake" {{ in_array('intake', $order_form->restlessness_multiple ?? []) ? 'checked' : '' }}>  Following food intake</label>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="restlessness_food_intake" placeholder="" value="{{ old('restlessness_food_intake', @$order_form->restlessness_food_intake) }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="restlessness_multiple[]" value="lying" {{ in_array('lying', $order_form->restlessness_multiple ?? []) ? 'checked' : '' }}>  Only on lying</label>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="restlessness_only_lying" placeholder="" value="{{ old('restlessness_only_lying', @$order_form->restlessness_only_lying) }}">
                                                    </td>
                                                </tr>

                                                {{-- Gidiness  --}}
                                                <tr>
                                                    <td colspan="6">
                                                        <b>Gidiness :</b>
                                                        <select class="form-control" name="gidiness_selection" id="gidiness_selection">
                                                            <option value="none" {{ old('gidiness_selection', @$order_form->gidiness_selection) == 'none' ? 'selected' : '' }}>None</option>
                                                            <option value="yes" {{ old('gidiness_selection', @$order_form->gidiness_selection) == 'yes' ? 'selected' : '' }}>Yes</option>
                                                        </select>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="gidiness_multiple[]" value="rest" {{ in_array('rest', $order_form->gidiness_multiple ?? []) ? 'checked' : '' }}> Even at rest</label>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="gidiness_even_rest" placeholder="" value="{{ old('gidiness_even_rest', @$order_form->gidiness_even_rest) }}">
                                                    </td>
                                                    <td colspan="2" rowspan="8" style="vertical-align: top;">
                                                        1. Relieved by rest <br>
                                                        2. Relieved by medication <br>
                                                        3. No relief
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="gidiness_multiple[]" value="exertion" {{ in_array('exertion', $order_form->gidiness_multiple ?? []) ? 'checked' : '' }}> Aggravated by exertion</label>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="aggravated_by_exertion" placeholder="" value="{{ old('aggravated_by_exertion', @$order_form->aggravated_by_exertion) }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="gidiness_multiple[]" value="thershold" {{ in_array('thershold', $order_form->gidiness_multiple ?? []) ? 'checked' : '' }}> variable thershold</label>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="gidiness_variable_th" placeholder="" value="{{ old('gidiness_variable_th', @$order_form->gidiness_variable_th) }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="gidiness_multiple[]" value="periodic" {{ in_array('periodic', $order_form->gidiness_multiple ?? []) ? 'checked' : '' }}> Periodic</label>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="gidiness_periodic" placeholder="" value="{{ old('gidiness_periodic', @$order_form->gidiness_periodic) }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="gidiness_multiple[]" value="intake" {{ in_array('intake', $order_form->gidiness_multiple ?? []) ? 'checked' : '' }}>  Following food intake</label>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="gidiness_food_intake" placeholder="" value="{{ old('gidiness_food_intake', @$order_form->gidiness_food_intake) }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="gidiness_multiple[]" value="triggered" {{ in_array('triggered', $order_form->gidiness_multiple ?? []) ? 'checked' : '' }}>  Triggered by changing position from sitting / lying to upright</label>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="lying_to_upright" placeholder="" value="{{ old('lying_to_upright', @$order_form->lying_to_upright) }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="gidiness_multiple[]" value="acute_extension" {{ in_array('acute_extension', $order_form->gidiness_multiple ?? []) ? 'checked' : '' }}>  Triggered by acute extension of head</label>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="acute_extension_head" placeholder="" value="{{ old('acute_extension_head', @$order_form->acute_extension_head) }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="gidiness_multiple[]" value="movement" {{ in_array('movement', $order_form->gidiness_multiple ?? []) ? 'checked' : '' }}>  Triggered by sideways movement of head</label>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="sideways_movement_head" placeholder="" value="{{ old('sideways_movement_head', @$order_form->sideways_movement_head) }}">
                                                    </td>
                                                </tr>

                                                {{-- Presyncpe/Syncope  --}}
                                                <tr>
                                                    <td colspan="6">
                                                        <b>Presyncpe/Syncope :</b>
                                                        <select class="form-control" name="presyncpe_selection" id="presyncpe_selection">
                                                            <option value="none" {{ old('presyncpe_selection', @$order_form->presyncpe_selection) == 'none' ? 'selected' : '' }}>None</option>
                                                            <option value="yes" {{ old('presyncpe_selection', @$order_form->presyncpe_selection) == 'yes' ? 'selected' : '' }}>Yes</option>
                                                        </select>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="presyncpe_multiple[]" value="rest" {{ in_array('rest', $order_form->presyncpe_multiple ?? []) ? 'checked' : '' }}> Even at rest</label>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="presyncpe_even_rest" placeholder="" value="{{ old('presyncpe_even_rest', @$order_form->presyncpe_even_rest) }}">
                                                    </td>
                                                    <td colspan="2" rowspan="8" style="vertical-align: top;">
                                                        1. Relieved by rest <br>
                                                        2. Relieved by medication <br>
                                                        3. No relief
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="presyncpe_multiple[]" value="exertion" {{ in_array('exertion', $order_form->presyncpe_multiple ?? []) ? 'checked' : '' }}> Aggravated by exertion</label>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="presyncpe_aggravated_exertion" placeholder="" value="{{ old('presyncpe_aggravated_exertion', @$order_form->presyncpe_aggravated_exertion) }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="presyncpe_multiple[]" value="thershold" {{ in_array('thershold', $order_form->presyncpe_multiple ?? []) ? 'checked' : '' }}> variable thershold</label>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="presyncpe_variable_threshold" placeholder="" value="{{ old('presyncpe_variable_threshold', @$order_form->presyncpe_variable_threshold) }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="presyncpe_multiple[]" value="periodic" {{ in_array('periodic', $order_form->presyncpe_multiple ?? []) ? 'checked' : '' }}> Periodic</label>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="presyncpe_periodic" placeholder="" value="{{ old('presyncpe_periodic', @$order_form->presyncpe_periodic) }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="presyncpe_multiple[]" value="intake" {{ in_array('intake', $order_form->presyncpe_multiple ?? []) ? 'checked' : '' }}>  Following food intake</label>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="presyncpe_food_intake" placeholder="" value="{{ old('presyncpe_food_intake', @$order_form->presyncpe_food_intake) }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="presyncpe_multiple[]" value="sitting" {{ in_array('sitting', $order_form->presyncpe_multiple ?? []) ? 'checked' : '' }}>  Triggered by changing position from sitting / lying to upright</label>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="presyncpe_lying_upright" placeholder="" value="{{ old('presyncpe_lying_upright', @$order_form->presyncpe_lying_upright) }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="presyncpe_multiple[]" value="extension" {{ in_array('extension', $order_form->presyncpe_multiple ?? []) ? 'checked' : '' }}>  Triggered by acute extension of head</label>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="presyncpe_extension_head" placeholder="" value="{{ old('presyncpe_extension_head', @$order_form->presyncpe_extension_head) }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="presyncpe_multiple[]" value="movement" {{ in_array('movement', $order_form->presyncpe_multiple ?? []) ? 'checked' : '' }}>  Triggered by sideways movement of head</label>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="presyncpe_movement_head" placeholder="" value="{{ old('presyncpe_movement_head', @$order_form->presyncpe_movement_head) }}">
                                                    </td>
                                                </tr>

                                                {{-- Sweating  --}}
                                                <tr>
                                                    <td colspan="6">
                                                        <b>Sweating :</b>
                                                        <select class="form-control" name="sweating_selection" id="sweating_selection">
                                                            <option value="none" {{ old('sweating_selection', @$order_form->sweating_selection) == 'none' ? 'selected' : '' }}>None</option>
                                                            <option value="yes" {{ old('sweating_selection', @$order_form->sweating_selection) == 'yes' ? 'selected' : '' }}>Yes</option>
                                                        </select>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="sweating_multiple[]" value="rest" {{ in_array('rest', $order_form->sweating_multiple ?? []) ? 'checked' : '' }}> Even at rest</label>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="sweating_even_rest" placeholder="" value="{{ old('sweating_even_rest', @$order_form->sweating_even_rest) }}">
                                                    </td>
                                                    <td colspan="2" rowspan="5" style="vertical-align: top;">
                                                        1. Relieved by rest <br>
                                                        2. Relieved by medication <br>
                                                        3. No relief
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="sweating_multiple[]" value="exertion" {{ in_array('exertion', $order_form->sweating_multiple ?? []) ? 'checked' : '' }}> Aggravated by exertion</label>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="sweating_aggravated_exertion" placeholder="" value="{{ old('sweating_aggravated_exertion', @$order_form->sweating_aggravated_exertion) }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="sweating_multiple[]" value="spontaneous" {{ in_array('spontaneous', $order_form->sweating_multiple ?? []) ? 'checked' : '' }}> spontaneous</label>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="sweating_spontaneous" placeholder="" value="{{ old('sweating_spontaneous', @$order_form->sweating_spontaneous) }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="sweating_multiple[]" value="periodic" {{ in_array('periodic', $order_form->sweating_multiple ?? []) ? 'checked' : '' }}> Periodic</label>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="sweating_periodic" placeholder="" value="{{ old('sweating_periodic', @$order_form->sweating_periodic) }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="sweating_multiple[]" value="intake" {{ in_array('intake', $order_form->sweating_multiple ?? []) ? 'checked' : '' }}>  Following food intake</label>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="sweating_food_intake" placeholder="" value="{{ old('sweating_food_intake', @$order_form->sweating_food_intake) }}">
                                                    </td>
                                                </tr>

                                                {{-- Palpitation  --}}
                                                <tr>
                                                    <td colspan="6">
                                                        <b>Palpitation :</b>
                                                        <select class="form-control" name="palpitation_selection" id="palpitation_selection">
                                                            <option value="none" {{ old('palpitation_selection', @$order_form->palpitation_selection) == 'none' ? 'selected' : '' }}>None</option>
                                                            <option value="yes" {{ old('palpitation_selection', @$order_form->palpitation_selection) == 'yes' ? 'selected' : '' }}>Yes</option>
                                                        </select>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="palpitation_multiple[]" value="rest" {{ in_array('rest', $order_form->palpitation_multiple ?? []) ? 'checked' : '' }}> Even at rest</label>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="palpitation_even_rest" placeholder="" value="{{ old('palpitation_even_rest', @$order_form->palpitation_even_rest) }}">
                                                    </td>
                                                    <td colspan="2" rowspan="6" style="vertical-align: top;">
                                                        1. Relieved by rest <br>
                                                        2. Relieved by medication <br>
                                                        3. No relief
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="palpitation_multiple[]" value="exertion" {{ in_array('exertion', $order_form->palpitation_multiple ?? []) ? 'checked' : '' }}> Aggravated by exertion</label>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="palpitation_aggravated_exertion" placeholder="" value="{{ old('palpitation_aggravated_exertion', @$order_form->palpitation_aggravated_exertion) }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="palpitation_multiple[]" value="threshold" {{ in_array('threshold', $order_form->palpitation_multiple ?? []) ? 'checked' : '' }}> variable threshold</label>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="palpitation_variable_threshold" placeholder="" value="{{ old('palpitation_variable_threshold', @$order_form->palpitation_variable_threshold) }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="palpitation_multiple[]" value="periodic" {{ in_array('periodic', $order_form->palpitation_multiple ?? []) ? 'checked' : '' }}> Periodic</label>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="palpitation_periodic" placeholder="" value="{{ old('palpitation_periodic', @$order_form->palpitation_periodic) }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="palpitation_multiple[]" value="intake" {{ in_array('intake', $order_form->palpitation_multiple ?? []) ? 'checked' : '' }}>  On food intake</label>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="palpitation_food_intake" placeholder="" value="{{ old('palpitation_food_intake', @$order_form->palpitation_food_intake) }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="palpitation_multiple[]" value="emotion" {{ in_array('emotion', $order_form->palpitation_multiple ?? []) ? 'checked' : '' }}>  Emotion</label>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="palpitation_emotion" placeholder="" value="{{ old('palpitation_emotion', @$order_form->palpitation_emotion) }}">
                                                    </td>
                                                </tr>

                                                {{-- Coughing  --}}
                                                <tr>
                                                    <td colspan="6">
                                                        <b>Coughing :</b>
                                                        <select class="form-control" name="coughing_selection" id="coughing_selection">
                                                            <option value="none" {{ old('coughing_selection', @$order_form->coughing_selection) == 'none' ? 'selected' : '' }}>None</option>
                                                            <option value="yes" {{ old('coughing_selection', @$order_form->coughing_selection) == 'yes' ? 'selected' : '' }}>Yes</option>
                                                        </select>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="coughing_multiple[]" value="rest" {{ in_array('rest', $order_form->coughing_multiple ?? []) ? 'checked' : '' }}> Persistent</label>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="coughing_persistent" placeholder="" value="{{ old('coughing_persistent', @$order_form->coughing_persistent) }}">
                                                    </td>
                                                    <td colspan="2" rowspan="6" style="vertical-align: top;">
                                                        1. Relieved by change in position <br>
                                                        2. Associated with mucoid expectoration<br>
                                                        3. Associated with mucopurulent expectoration<br>
                                                        4. Bloody expectoration<br>
                                                        5. No expectoration
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="coughing_multiple[]" value="daytime" {{ in_array('daytime', $order_form->coughing_multiple ?? []) ? 'checked' : '' }}> Mostly during daytime</label>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="coughing_daytime" placeholder="" value="{{ old('coughing_daytime', @$order_form->coughing_daytime) }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="coughing_multiple[]" value="during" {{ in_array('during', $order_form->coughing_multiple ?? []) ? 'checked' : '' }}> Mostly during night-time</label>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="coughing_night_time" placeholder="" value="{{ old('coughing_night_time', @$order_form->coughing_night_time) }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="coughing_multiple[]" value="variable" {{ in_array('variable', $order_form->coughing_multiple ?? []) ? 'checked' : '' }}> Variable</label>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="coughing_variable" placeholder="" value="{{ old('coughing_variable', @$order_form->coughing_variable) }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="coughing_multiple[]" value="spasmodic" {{ in_array('spasmodic', $order_form->coughing_multiple ?? []) ? 'checked' : '' }}>  Does it occur in spasmodic attack?</label>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="coughing_spasmodic_attack" placeholder="" value="{{ old('coughing_spasmodic_attack', @$order_form->coughing_spasmodic_attack) }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="coughing_multiple[]" value="lying_position" {{ in_array('lying_position', $order_form->coughing_multiple ?? []) ? 'checked' : '' }}>  More in Lying position</label>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="coughing_lying_position" placeholder="" value="{{ old('coughing_lying_position', @$order_form->coughing_lying_position) }}">
                                                    </td>
                                                </tr>

                                                {{-- Gastric upset / Eruction /Bleching  --}}
                                                <tr>
                                                    <td colspan="6">
                                                        <b>Gastric upset / Eruction /Bleching :</b>
                                                        <select class="form-control" name="gastric_selection" id="gastric_selection">
                                                            <option value="none" {{ old('gastric_selection', @$order_form->gastric_selection) == 'none' ? 'selected' : '' }}>None</option>
                                                            <option value="yes" {{ old('gastric_selection', @$order_form->gastric_selection) == 'yes' ? 'selected' : '' }}>Yes</option>
                                                        </select>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="gastric_multiple[]" value="aggravating" {{ in_array('aggravating', $order_form->gastric_multiple ?? []) ? 'checked' : '' }}> No specific aggravating factor</label>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="gastric_no_specific" placeholder="" value="{{ old('gastric_no_specific', @$order_form->gastric_no_specific) }}">
                                                    </td>
                                                    <td colspan="2" rowspan="2" style="vertical-align: top;">
                                                        1.Releived by antacid
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="gastric_multiple[]" value="spicy" {{ in_array('spicy', $order_form->gastric_multiple ?? []) ? 'checked' : '' }}> Triggered by spicy food</label>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="gastric_spicy_food" placeholder="" value="{{ old('gastric_spicy_food', @$order_form->gastric_spicy_food) }}">
                                                    </td>
                                                </tr>

                                                {{-- Anasarca / Ankle swelling  --}}
                                                <tr>
                                                    <td colspan="6">
                                                        <b>Anasarca / Ankle swelling :</b>
                                                        <select class="form-control" name="anasarca_selection" id="anasarca_selection">
                                                            <option value="none" {{ old('anasarca_selection', @$order_form->anasarca_selection) == 'none' ? 'selected' : '' }}>None</option>
                                                            <option value="yes" {{ old('anasarca_selection', @$order_form->anasarca_selection) == 'yes' ? 'selected' : '' }}>Yes</option>
                                                        </select>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="anasarca_multiple[]" value="sudden" {{ in_array('sudden', $order_form->anasarca_multiple ?? []) ? 'checked' : '' }}> Sudden onset</label>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="anasarca_sudden_onset" placeholder="" value="{{ old('anasarca_sudden_onset', @$order_form->anasarca_sudden_onset) }}">
                                                    </td>
                                                    <td colspan="2" rowspan="3" style="vertical-align: top;">
                                                        1. Releived by position <br>
                                                        2. Releived by diuretics<br>
                                                        3. Releived by stockings
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="anasarca_multiple[]" value="gradual" {{ in_array('gradual', $order_form->anasarca_multiple ?? []) ? 'checked' : '' }}> Gradual onset</label>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="anasarca_gradual_onset" placeholder="" value="{{ old('anasarca_gradual_onset', @$order_form->anasarca_gradual_onset) }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="anasarca_multiple[]" value="gravity" {{ in_array('gravity', $order_form->anasarca_multiple ?? []) ? 'checked' : '' }}> Aggravated by gravity</label>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="anasarca_aggravated_gravity" placeholder="" value="{{ old('anasarca_aggravated_gravity', @$order_form->anasarca_aggravated_gravity) }}">
                                                    </td>
                                                </tr>

                                                {{-- Swelling / Fluid in the abdomen  --}}
                                                <tr>
                                                    <td colspan="6">
                                                        <b>Swelling / Fluid in the abdomen :</b>
                                                        <select class="form-control" name="swelling_selection" id="swelling_selection">
                                                            <option value="none" {{ old('swelling_selection', @$order_form->swelling_selection) == 'none' ? 'selected' : '' }}>None</option>
                                                            <option value="yes" {{ old('swelling_selection', @$order_form->swelling_selection) == 'yes' ? 'selected' : '' }}>Yes</option>
                                                        </select>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="swelling_multiple[]" value="onset" {{ in_array('onset', $order_form->swelling_multiple ?? []) ? 'checked' : '' }}> Sudden onset</label>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="swelling_sudden_onset" placeholder="" value="{{ old('swelling_sudden_onset', @$order_form->swelling_sudden_onset) }}">
                                                    </td>
                                                    <td colspan="2" rowspan="2" style="vertical-align: top;">
                                                        1. Releived by position <br>
                                                        2. Releived by duretics
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="swelling_multiple[]" value="gradual" {{ in_array('gradual', $order_form->swelling_multiple ?? []) ? 'checked' : '' }}> Gradual onset</label>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="swelling_gradual_onset" placeholder="" value="{{ old('swelling_gradual_onset', @$order_form->swelling_gradual_onset) }}">
                                                    </td>
                                                </tr>

                                                {{-- Fever  --}}
                                                <tr>
                                                    <td colspan="6">
                                                        <b>Fever :</b>
                                                        <select class="form-control" name="fever_selection" id="fever_selection">
                                                            <option value="none" {{ old('fever_selection', @$order_form->fever_selection) == 'none' ? 'selected' : '' }}>None</option>
                                                            <option value="yes" {{ old('fever_selection', @$order_form->fever_selection) == 'yes' ? 'selected' : '' }}>Yes</option>
                                                        </select>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="fever_multiple[]" value="continued" {{ in_array('continued', $order_form->fever_multiple ?? []) ? 'checked' : '' }}> Continued</label>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="fever_continued" placeholder="" value="{{ old('fever_continued', @$order_form->fever_continued) }}">
                                                    </td>
                                                    <td colspan="2" rowspan="3" style="vertical-align: top;">
                                                        1. Spontaneous returned to normal <br>
                                                        2. Releived by medication<br>
                                                        3. Relieved by cold sponging
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="fever_multiple[]" value="intermittent" {{ in_array('intermittent', $order_form->fever_multiple ?? []) ? 'checked' : '' }}> intermittent</label>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="fever_intermittent" placeholder="" value="{{ old('fever_intermittent', @$order_form->fever_intermittent) }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="fever_multiple[]" value="remittent" {{ in_array('remittent', $order_form->fever_multiple ?? []) ? 'checked' : '' }}> Remittent</label>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="fever_remittent" placeholder="" value="{{ old('fever_remittent', @$order_form->fever_remittent) }}">
                                                    </td>
                                                </tr>

                                                {{-- Heavy snoring  --}}
                                                <tr>
                                                    <td colspan="6">
                                                        <b>Heavy snoring :</b>
                                                        <select class="form-control" name="heavy_snoring" id="heavy_snoring">
                                                            <option value="none" {{ old('heavy_snoring', @$order_form->heavy_snoring) == 'none' ? 'selected' : '' }}>None</option>
                                                            <option value="yes" {{ old('heavy_snoring', @$order_form->heavy_snoring) == 'yes' ? 'selected' : '' }}>Yes</option>
                                                        </select>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="6">
                                                        <label for="">Finding</label>
                                                        <input type="text" class="form-control" name="snoring_finding" placeholder="" value="{{ old('snoring_finding', @$order_form->snoring_finding) }}">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="6">
                                                        <label for="">Others</label>
                                                        <input type="text" class="form-control" name="snoring_others" placeholder="" value="{{ old('snoring_others', @$order_form->snoring_others) }}">
                                                    </td>
                                                </tr>

                                                {{-- past history --}}
                                                <tr>
                                                    <th colspan="6" style="text-align:left;">PAST HISTORY</th>
                                                </tr>

                                                <tr>
                                                    <td colspan="6">
                                                        <b>History of previous myocardial infarction</b> 
                                                        <select class="form-control" name="prev_mi" id="prev_mi">
                                                            <option value="">-- Select --</option>
                                                            <option value="none" {{ old('prev_mi', @$order_form->prev_mi) == 'none' ? 'selected' : '' }}>None</option>
                                                            <option value="yes" {{ old('prev_mi', @$order_form->prev_mi) == 'yes' ? 'selected' : '' }}>Yes</option>
                                                        </select>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Date</th>
                                                    <th>First</th>
                                                    <th colspan="2">Second</th>
                                                    <th colspan="2">Third</th>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td><input type="date" class="form-control" name="mi_first_date" value="{{ old('mi_first_date', @$order_form->mi_first_date ? \Carbon\Carbon::parse($order_form->mi_first_date)->format('Y-m-d') : '') }}"></td>
                                                    <td colspan="2"><input type="date" class="form-control" name="mi_second_date" value="{{ old('mi_second_date', @$order_form->mi_second_date ? \Carbon\Carbon::parse($order_form->mi_second_date)->format('Y-m-d') : '') }}"></td>
                                                    <td colspan="2"><input type="date" class="form-control" name="mi_third_date" value="{{ old('mi_third_date', @$order_form->mi_third_date ? \Carbon\Carbon::parse($order_form->mi_third_date)->format('Y-m-d') : '') }}"></td>
                                                </tr>
                                                <tr>
                                                    <td>Site</td>
                                                    <td>
                                                        <label><input type="checkbox" name="mi_first_site[]" value="anterior" {{ in_array('anterior', $order_form->mi_first_site ?? []) ? 'checked' : '' }}> Anterior (125.2.00)</label><br>
                                                        <label><input type="checkbox" name="mi_first_site[]" value="anteroseptal" {{ in_array('anteroseptal', $order_form->mi_first_site ?? []) ? 'checked' : '' }}>  Anteroseptal (125.2.03)</label><br>
                                                        <label><input type="checkbox" name="mi_first_site[]" value="lateral" {{ in_array('lateral', $order_form->mi_first_site ?? []) ? 'checked' : '' }}> Lateral ( 125.2.20)</label><br>
                                                        <label><input type="checkbox" name="mi_first_site[]" value="inferior" {{ in_array('inferior', $order_form->mi_first_site ?? []) ? 'checked' : '' }}> Inferior (125.2.10)</label><br>
                                                        <label><input type="checkbox" name="mi_first_site[]" value="anterolateral" {{ in_array('anterolateral', $order_form->mi_first_site ?? []) ? 'checked' : '' }}> Anterolateral (125.2.02)</label><br>
                                                        <label><input type="checkbox" name="mi_first_site[]" value="other" {{ in_array('other', $order_form->mi_first_site ?? []) ? 'checked' : '' }}> Other (125.2)</label>
                                                    </td>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="mi_second_site[]" value="anterior" {{ in_array('anterior', $order_form->mi_second_site ?? []) ? 'checked' : '' }}> Anterior (125.2.00)</label><br>
                                                        <label><input type="checkbox" name="mi_second_site[]" value="anteroseptal" {{ in_array('anteroseptal', $order_form->mi_second_site ?? []) ? 'checked' : '' }}> Anteroseptal (125.2.03)</label><br>
                                                        <label><input type="checkbox" name="mi_second_site[]" value="lateral" {{ in_array('lateral', $order_form->mi_second_site ?? []) ? 'checked' : '' }}> Lateral (125.2.20)</label><br>
                                                        <label><input type="checkbox" name="mi_second_site[]" value="inferior" {{ in_array('inferior', $order_form->mi_second_site ?? []) ? 'checked' : '' }}> Inferior (125.2.10)</label><br>
                                                        <label><input type="checkbox" name="mi_second_site[]" value="anterolateral" {{ in_array('anterolateral', $order_form->mi_second_site ?? []) ? 'checked' : '' }}> Anterolateral (125.2.02)</label><br>
                                                        <label><input type="checkbox" name="mi_second_site[]" value="other" {{ in_array('other', $order_form->mi_second_site ?? []) ? 'checked' : '' }}> Other (125.2)</label>
                                                    </td>

                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="mi_third_site[]" value="anterior" {{ in_array('anterior', $order_form->mi_third_site ?? []) ? 'checked' : '' }}> Anterior (125.2.00)</label><br>
                                                        <label><input type="checkbox" name="mi_third_site[]" value="anteroseptal" {{ in_array('anteroseptal', $order_form->mi_third_site ?? []) ? 'checked' : '' }}> Anteroseptal (125.2.03)</label><br>
                                                        <label><input type="checkbox" name="mi_third_site[]" value="lateral" {{ in_array('lateral', $order_form->mi_third_site ?? []) ? 'checked' : '' }}> Lateral (125.2.20)</label><br>
                                                        <label><input type="checkbox" name="mi_third_site[]" value="inferior" {{ in_array('inferior', $order_form->mi_third_site ?? []) ? 'checked' : '' }}> Inferior (125.2.10)</label><br>
                                                        <label><input type="checkbox" name="mi_third_site[]" value="anterolateral" {{ in_array('anterolateral', $order_form->mi_third_site ?? []) ? 'checked' : '' }}> Anterolateral (125.2.02)</label><br>
                                                        <label><input type="checkbox" name="mi_third_site[]" value="other" {{ in_array('other', $order_form->mi_third_site ?? []) ? 'checked' : '' }}> Other (125.2)</label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>With ST Elevation</td>
                                                    <td colspan="5">
                                                        <select class="form-control" name="st_elev" id="st_elev">
                                                            <option value="">-- Select --</option>
                                                            <option value="yes" {{ old('st_elev', @$order_form->st_elev) == 'yes' ? 'selected' : '' }}>Yes</option>
                                                            <option value="no" {{ old('st_elev', @$order_form->st_elev) == 'no' ? 'selected' : '' }}>No</option>
                                                            <option value="not_known" {{ old('st_elev', @$order_form->st_elev) == 'not_known' ? 'selected' : '' }}>Not known</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Thrombolytic Therapy</td>
                                                    <td colspan="5">
                                                        <select class="form-control" name="thrombolytic" id="thrombolytic">
                                                            <option value="">-- Select --</option>
                                                            <option value="yes" {{ old('thrombolytic', @$order_form->thrombolytic) == 'yes' ? 'selected' : '' }}>Yes</option>
                                                            <option value="no" {{ old('thrombolytic', @$order_form->thrombolytic) == 'no' ? 'selected' : '' }}>No</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Thrombolytic Agent</td>
                                                    <td colspan="5"><input type="text" class="form-control" name="first_thrombolytic_agent" value="{{ old('first_thrombolytic_agent', @$order_form->first_thrombolytic_agent) }}"></td>
                                                </tr>
                                                <tr>
                                                    <td>Complications</td>
                                                    <td colspan="5">
                                                        <select class="form-control" name="complications" id="complications">
                                                            <option value="">-- Select --</option>
                                                            <option value="yes" {{ old('complications', @$order_form->complications) == 'yes' ? 'selected' : '' }}>Yes</option>
                                                            <option value="no" {{ old('complications', @$order_form->complications) == 'no' ? 'selected' : '' }}>No</option>
                                                        </select>
                                                    </td>
                                                </tr>

                                                <!-- History of -->
                                                <tr>
                                                    <th colspan="6">HISTORY OF</th>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">Angina</td>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="angina[]" value="unstable" {{ in_array('unstable', $order_form->angina ?? []) ? 'checked' : '' }}> Unstable angina (120.0)</label><br>
                                                        <label><input type="checkbox" name="angina[]" value="spasm" {{ in_array('spasm', $order_form->angina ?? []) ? 'checked' : '' }}> Angina pectoris with documented spasm</label><br>
                                                        <label><input type="checkbox" name="angina[]" value="effort" {{ in_array('effort', $order_form->angina ?? []) ? 'checked' : '' }}> Angina on effort (120.8)</label><br>
                                                        <label><input type="checkbox" name="angina[]" value="unspecified" {{ in_array('unspecified', $order_form->angina ?? []) ? 'checked' : '' }}> Angina pectoris, unspecified (120.9)</label>
                                                    </td>
                                                    <td colspan="2">
                                                        <select class="form-control" name="angina_present" id="angina_present">
                                                            <option value="">-- Select --</option>
                                                            <option value="yes" {{ old('angina_present', @$order_form->angina_present) == 'yes' ? 'selected' : '' }}>Yes</option>
                                                            <option value="no" {{ old('angina_present', @$order_form->angina_present) == 'no' ? 'selected' : '' }}>No</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">Essential Hypertension (110)</td>
                                                    <td colspan="4">
                                                        <select class="form-control" name="htn" id="htn">
                                                            <option value="">-- Select --</option>
                                                            <option value="yes" {{ old('htn', @$order_form->htn) == 'yes' ? 'selected' : '' }}>Yes</option>
                                                            <option value="no" {{ old('htn', @$order_form->htn) == 'no' ? 'selected' : '' }}>No</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">Arrhythmi</td>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="arrhythmia[]" value="svt" {{ in_array('svt', $order_form->arrhythmia ?? []) ? 'checked' : '' }}> Supraventricular tachycardia (147.1)</label><br>
                                                        <label><input type="checkbox" name="arrhythmia[]" value="vt" {{ in_array('vt', $order_form->arrhythmia ?? []) ? 'checked' : '' }}> Ventricular tachycardia (147.2)</label><br>
                                                        <label><input type="checkbox" name="arrhythmia[]" value="af" {{ in_array('af', $order_form->arrhythmia ?? []) ? 'checked' : '' }}> Atrial fibrillation (148.0)</label><br>
                                                        <label><input type="checkbox" name="arrhythmia[]" value="aflutter" {{ in_array('aflutter', $order_form->arrhythmia ?? []) ? 'checked' : '' }}> Atrial flutter (148.1)</label><br>
                                                        <label><input type="checkbox" name="arrhythmia[]" value="apb" {{ in_array('apb', $order_form->arrhythmia ?? []) ? 'checked' : '' }}> Atrial premature beat (149.1)</label><br>
                                                        <label><input type="checkbox" name="arrhythmia[]" value="ectopics" {{ in_array('ectopics', $order_form->arrhythmia ?? []) ? 'checked' : '' }}> Other ectopics (149.4)</label><br>
                                                        <label><input type="checkbox" name="arrhythmia[]" value="sss" {{ in_array('sss', $order_form->arrhythmia ?? []) ? 'checked' : '' }}> Sick sinus syndrome (149.5)</label><br>
                                                        <label><input type="checkbox" name="arrhythmia[]" value="av_block_1" {{ in_array('av_block_1', $order_form->arrhythmia ?? []) ? 'checked' : '' }}> 1° AV Block (144.0)</label><br>
                                                        <label><input type="checkbox" name="arrhythmia[]" value="av_block_2" {{ in_array('av_block_2', $order_form->arrhythmia ?? []) ? 'checked' : '' }}> 2° AV Block (144.1)</label><br>
                                                        <label><input type="checkbox" name="arrhythmia[]" value="av_block_complete" {{ in_array('av_block_complete', $order_form->arrhythmia ?? []) ? 'checked' : '' }}> Complete AV Block (144.2)</label><br>
                                                        <label><input type="checkbox" name="arrhythmia[]" value="lbbb" {{ in_array('lbbb', $order_form->arrhythmia ?? []) ? 'checked' : '' }}> LBBB (144.7)</label><br>
                                                        <label><input type="checkbox" name="arrhythmia[]" value="rbbb" {{ in_array('rbbb', $order_form->arrhythmia ?? []) ? 'checked' : '' }}> RBBB (145.1)</label><br>
                                                        <label><input type="checkbox" name="arrhythmia[]" value="wpw" {{ in_array('wpw', $order_form->arrhythmia ?? []) ? 'checked' : '' }}> Pre-excitation syndrome (WPW) (145.6)</label><br>
                                                        <label><input type="checkbox" name="arrhythmia[]" value="av_dissociation" {{ in_array('av_dissociation', $order_form->arrhythmia ?? []) ? 'checked' : '' }}> AV dissociation (145.8)</label>
                                                    </td>
                                                    <td colspan="2">
                                                        <b>Controlled</b><br>
                                                        <select class="form-control" name="arrhythmia_control" id="arrhythmia_control">
                                                            <option value="">-- Select --</option>
                                                            <option value="yes" {{ old('arrhythmia_control', @$order_form->arrhythmia_control) == 'yes' ? 'selected' : '' }}>Yes</option>
                                                            <option value="no" {{ old('arrhythmia_control', @$order_form->arrhythmia_control) == 'no' ? 'selected' : '' }}>No</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="cyanosis" value="cyanosis" {{ old('cyanosis', @$order_form->cyanosis) == 'cyanosis' ? 'checked' : '' }}> Cyanosis (R23.0)</label><br>
                                                    </td>
                                                    <td colspan="4">
                                                        <select class="form-control" name="cyanosis_select" id="cyanosis_select">
                                                            <option value="">-- Select --</option>
                                                            <option value="yes" {{ old('cyanosis_select', @$order_form->cyanosis_select) == 'yes' ? 'selected' : '' }}>Yes</option>
                                                            <option value="no" {{ old('cyanosis_select', @$order_form->cyanosis_select) == 'no' ? 'selected' : '' }}>No</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="heart_failure" value="heart_failure" {{ old('heart_failure', @$order_form->heart_failure) == 'heart_failure' ? 'checked' : '' }}> Heart failure (150.9)</label><br>
                                                    </td>
                                                    <td colspan="4">
                                                        <select class="form-control" name="heart_failure_select" id="heart_failure_select">
                                                            <option value="">-- Select --</option>
                                                            <option value="yes" {{ old('heart_failure_select', @$order_form->heart_failure_select) == 'yes' ? 'selected' : '' }}>Yes</option>
                                                            <option value="no" {{ old('heart_failure_select', @$order_form->heart_failure_select) == 'no' ? 'selected' : '' }}>No</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="rheumatic_fever" value="rheumatic_fever" {{ old('rheumatic_fever', @$order_form->rheumatic_fever) == 'rheumatic_fever' ? 'checked' : '' }}> Rheumatic fever (100)</label><br>
                                                    </td>
                                                    <td colspan="4">
                                                        <select class="form-control" name="rheumatic_fever_select" id="rheumatic_fever_select">
                                                            <option value="">-- Select --</option>
                                                            <option value="yes" {{ old('rheumatic_fever_select', @$order_form->rheumatic_fever_select) == 'yes' ? 'selected' : '' }}>Yes</option>
                                                            <option value="no" {{ old('rheumatic_fever_select', @$order_form->rheumatic_fever_select) == 'no' ? 'selected' : '' }}>No</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="peripheral_vascular" value="peripheral_vascular" {{ old('peripheral_vascular', @$order_form->peripheral_vascular) == 'peripheral_vascular' ? 'checked' : '' }}> Peripheral vascular disease</label><br>
                                                    </td>
                                                    <td colspan="4">
                                                        <select class="form-control" name="peripheral_vascular_select" id="peripheral_vascular_select">
                                                            <option value="">-- Select --</option>
                                                            <option value="yes" {{ old('peripheral_vascular_select', @$order_form->peripheral_vascular_select) == 'yes' ? 'selected' : '' }}>Yes</option>
                                                            <option value="no" {{ old('peripheral_vascular_select', @$order_form->peripheral_vascular_select) == 'no' ? 'selected' : '' }}>No</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="tuberculosis_of_lung" value="Tuberculosis" {{ old('tuberculosis_of_lung', @$order_form->tuberculosis_of_lung) == 'Tuberculosis' ? 'checked' : '' }}> Tuberculosis of Lung (A15.3)</label><br>
                                                    </td>
                                                    <td colspan="4">
                                                        <select class="form-control" name="tuberculosis_lung_select" id="tuberculosis_lung_select">
                                                            <option value="">-- Select --</option>
                                                            <option value="yes" {{ old('tuberculosis_lung_select', @$order_form->tuberculosis_lung_select) == 'yes' ? 'selected' : '' }}>Yes</option>
                                                            <option value="no" {{ old('tuberculosis_lung_select', @$order_form->tuberculosis_lung_select) == 'no' ? 'selected' : '' }}>No</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="convulsions" value="Convulsions" {{ old('convulsions', @$order_form->convulsions) == 'Convulsions' ? 'checked' : '' }}> Convulsions (G40.9)</label><br>
                                                    </td>
                                                    <td colspan="4">
                                                        <select class="form-control" name="convulsions_select" id="convulsions_select">
                                                            <option value="">-- Select --</option>
                                                            <option value="yes" {{ old('convulsions_select', @$order_form->convulsions_select) == 'yes' ? 'selected' : '' }}>Yes</option>
                                                            <option value="no" {{ old('convulsions_select', @$order_form->convulsions_select) == 'no' ? 'selected' : '' }}>No</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">Paralysis</td>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="paralysis[]" value="hemiplegia" {{ in_array('hemiplegia', $order_form->paralysis ?? []) ? 'checked' : '' }}> Hemiplegia (G81.9)</label><br>
                                                        <label><input type="checkbox" name="paralysis[]" value="paraplegia" {{ in_array('paraplegia', $order_form->paralysis ?? []) ? 'checked' : '' }}> Paraplegia (G82.20)</label><br>
                                                        <label><input type="checkbox" name="paralysis[]" value="other" {{ in_array('other', $order_form->paralysis ?? []) ? 'checked' : '' }}> Other (G83.9)</label>
                                                    </td>
                                                    <td colspan="2">
                                                        <select class="form-control" name="paralysis_select" id="paralysis_select">
                                                            <option value="">-- Select --</option>
                                                            <option value="yes" {{ old('paralysis_select', @$order_form->paralysis_select) == 'yes' ? 'selected' : '' }}>Yes</option>
                                                            <option value="no" {{ old('paralysis_select', @$order_form->paralysis_select) == 'no' ? 'selected' : '' }}>No</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="blackout" value="Blackout" {{ old('blackout', @$order_form->blackout) == 'Blackout' ? 'checked' : '' }}> Blackout (G45.9)</label><br>
                                                    </td>
                                                    <td colspan="4">
                                                        <select class="form-control" name="blackout_select" id="blackout_select">
                                                            <option value="">-- Select --</option>
                                                            <option value="yes" {{ old('blackout_select', @$order_form->blackout_select) == 'yes' ? 'selected' : '' }}>Yes</option>
                                                            <option value="no" {{ old('blackout_select', @$order_form->blackout_select) == 'no' ? 'selected' : '' }}>No</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="head_injury" value="head_injury" {{ old('head_injury', @$order_form->head_injury) == 'head_injury' ? 'checked' : '' }}> Head injury (S06.9)</label><br>
                                                    </td>
                                                    <td colspan="4">
                                                        <select class="form-control" name="head_injury_select" id="head_injury_select">
                                                            <option value="">-- Select --</option>
                                                            <option value="yes" {{ old('head_injury_select', @$order_form->head_injury_select) == 'yes' ? 'selected' : '' }}>Yes</option>
                                                            <option value="no" {{ old('head_injury_select', @$order_form->head_injury_select) == 'no' ? 'selected' : '' }}>No</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="depression" value="Depression" {{ old('depression', @$order_form->depression) == 'Depression' ? 'checked' : '' }}> Depression (F32.9)</label><br>
                                                    </td>
                                                    <td colspan="4">
                                                        <select class="form-control" name="depression_select" id="depression_select">
                                                            <option value="">-- Select --</option>
                                                            <option value="yes" {{ old('depression_select', @$order_form->depression_select) == 'yes' ? 'selected' : '' }}>Yes</option>
                                                            <option value="no" {{ old('depression_select', @$order_form->depression_select) == 'no' ? 'selected' : '' }}>No</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="gall_stones" value="gall_stones" {{ old('gall_stones', @$order_form->gall_stones) == 'gall_stones' ? 'checked' : '' }}> Gall stones (K80.80)</label><br>
                                                    </td>
                                                    <td colspan="4">
                                                        <select class="form-control" name="gall_stones_select" id="gall_stones_select">
                                                            <option value="">-- Select --</option>
                                                            <option value="yes" {{ old('gall_stones_select', @$order_form->gall_stones_select) == 'yes' ? 'selected' : '' }}>Yes</option>
                                                            <option value="no" {{ old('gall_stones_select', @$order_form->gall_stones_select) == 'no' ? 'selected' : '' }}>No</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="jaundice" value="Jaundice" {{ old('jaundice', @$order_form->jaundice) == 'Jaundice' ? 'checked' : '' }}> Jaundice (R17)</label><br>
                                                    </td>
                                                    <td colspan="4">
                                                        <select class="form-control" name="jaundice_select" id="jaundice_select">
                                                            <option value="">-- Select --</option>
                                                            <option value="yes" {{ old('jaundice_select', @$order_form->jaundice_select) == 'yes' ? 'selected' : '' }}>Yes</option>
                                                            <option value="no" {{ old('jaundice_select', @$order_form->jaundice_select) == 'no' ? 'selected' : '' }}>No</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="hernia" value="Hernia" {{ old('hernia', @$order_form->hernia) == 'Hernia' ? 'checked' : '' }}> Hernia (K40.90)</label><br>
                                                    </td>
                                                    <td colspan="4">
                                                        <select class="form-control" name="hernia_select" id="hernia_select">
                                                            <option value="">-- Select --</option>
                                                            <option value="yes" {{ old('hernia_select', @$order_form->hernia_select) == 'yes' ? 'selected' : '' }}>Yes</option>
                                                            <option value="no" {{ old('hernia_select', @$order_form->hernia_select) == 'no' ? 'selected' : '' }}>No</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="acid_peptic_disease" value="acid_peptic_disease" {{ old('acid_peptic_disease', @$order_form->acid_peptic_disease) == 'acid_peptic_disease' ? 'checked' : '' }}> Acid peptic disease (K27.9)</label><br>
                                                    </td>
                                                    <td colspan="4">
                                                        <select class="form-control" name="acid_peptic_select" id="acid_peptic_select">
                                                            <option value="">-- Select --</option>
                                                            <option value="yes" {{ old('acid_peptic_select', @$order_form->acid_peptic_select) == 'yes' ? 'selected' : '' }}>Yes</option>
                                                            <option value="no" {{ old('acid_peptic_select', @$order_form->acid_peptic_select) == 'no' ? 'selected' : '' }}>No</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="renal_dysfunction" value="renal_dysfunction" {{ old('renal_dysfunction', @$order_form->renal_dysfunction) == 'renal_dysfunction' ? 'checked' : '' }}> Renal dysfunction (N19)</label><br>
                                                    </td>
                                                    <td colspan="4">
                                                        <select class="form-control" name="renal_dysfunction_select" id="renal_dysfunction_select">
                                                            <option value="">-- Select --</option>
                                                            <option value="yes" {{ old('renal_dysfunction_select', @$order_form->renal_dysfunction_select) == 'yes' ? 'selected' : '' }}>Yes</option>
                                                            <option value="no" {{ old('renal_dysfunction_select', @$order_form->renal_dysfunction_select) == 'no' ? 'selected' : '' }}>No</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="hyperthyroidism" value="Hyperthyroidism" {{ old('hyperthyroidism', @$order_form->hyperthyroidism) == 'Hyperthyroidism' ? 'checked' : '' }}> Hyperthyroidism (E05.9)</label><br>
                                                    </td>
                                                    <td colspan="4">
                                                        <select class="form-control" name="hyperthyroidism_select" id="hyperthyroidism_select">
                                                            <option value="">-- Select --</option>
                                                            <option value="yes" {{ old('hyperthyroidism_select', @$order_form->hyperthyroidism_select) == 'yes' ? 'selected' : '' }}>Yes</option>
                                                            <option value="no" {{ old('hyperthyroidism_select', @$order_form->hyperthyroidism_select) == 'no' ? 'selected' : '' }}>No</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="hypothyroidism" value="Hypothyroidism" {{ old('hypothyroidism', @$order_form->hypothyroidism) == 'Hypothyroidism' ? 'checked' : '' }}> Hypothyroidism (E03.9)</label><br>
                                                    </td>
                                                    <td colspan="4">
                                                        <select class="form-control" name="hypothyroidism_select" id="hypothyroidism_select">
                                                            <option value="">-- Select --</option>
                                                            <option value="yes" {{ old('hypothyroidism_select', @$order_form->hypothyroidism_select) == 'yes' ? 'selected' : '' }}>Yes</option>
                                                            <option value="no" {{ old('hypothyroidism_select', @$order_form->hypothyroidism_select) == 'no' ? 'selected' : '' }}>No</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="hyperlipidemia" value="Hyperlipidemia" {{ old('hyperlipidemia', @$order_form->hyperlipidemia) == 'Hyperlipidemia' ? 'checked' : '' }}> Hyperlipidemia (E 78.5)</label><br>
                                                    </td>
                                                    <td colspan="4">
                                                        <select class="form-control" name="hyperlipidemia_select" id="hyperlipidemia_select">
                                                            <option value="">-- Select --</option>
                                                            <option value="yes" {{ old('hyperlipidemia_select', @$order_form->hyperlipidemia_select) == 'yes' ? 'selected' : '' }}>Yes</option>
                                                            <option value="no" {{ old('hyperlipidemia_select', @$order_form->hyperlipidemia_select) == 'no' ? 'selected' : '' }}>No</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">Diabetes mellitus<br>
                                                        <select class="form-control" name="diabetes_mellitus_select" id="diabetes_mellitus_select">
                                                            <option value="">-- Select --</option>
                                                            <option value="yes" {{ old('diabetes_mellitus_select', @$order_form->diabetes_mellitus_select) == 'yes' ? 'selected' : '' }}>Yes</option>
                                                            <option value="no" {{ old('diabetes_mellitus_select', @$order_form->diabetes_mellitus_select) == 'no' ? 'selected' : '' }}>No</option>
                                                        </select>
                                                    </td>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="diabetes_mellitus[]" value="niddm_controlled" {{ in_array('niddm_controlled', $order_form->diabetes_mellitus ?? []) ? 'checked' : '' }}> NIDDM - Controlled (E11.90)</label><br>
                                                        <label><input type="checkbox" name="diabetes_mellitus[]" value="niddm_poor" {{ in_array('niddm_poor', $order_form->diabetes_mellitus ?? []) ? 'checked' : '' }}> NIDDM - Poorly controlled (E11.91)</label><br>
                                                        <label><input type="checkbox" name="diabetes_mellitus[]" value="niddm_neuro" {{ in_array('niddm_neuro', $order_form->diabetes_mellitus ?? []) ? 'checked' : '' }}> NIDDM - Neuropathy (E11.40)</label><br>
                                                        <label><input type="checkbox" name="diabetes_mellitus[]" value="niddm_nephro" {{ in_array('niddm_nephro', $order_form->diabetes_mellitus ?? []) ? 'checked' : '' }}> NIDDM - Nephropathy (E11)</label><br>
                                                        <label><input type="checkbox" name="diabetes_mellitus[]" value="niddm_retino" {{ in_array('niddm_retino', $order_form->diabetes_mellitus ?? []) ? 'checked' : '' }}> NIDDM - Retinopathy (E11.30)</label><br>
                                                        <label><input type="checkbox" name="diabetes_mellitus[]" value="iddm_controlled" {{ in_array('iddm_controlled', $order_form->diabetes_mellitus ?? []) ? 'checked' : '' }}> IDDM - Controlled (E10.90)</label><br>
                                                        <label><input type="checkbox" name="diabetes_mellitus[]" value="iddm_poor" {{ in_array('iddm_poor', $order_form->diabetes_mellitus ?? []) ? 'checked' : '' }}> IDDM - Poorly controlled (E10.91)</label><br>
                                                        <label><input type="checkbox" name="diabetes_mellitus[]" value="iddm_neuro" {{ in_array('iddm_neuro', $order_form->diabetes_mellitus ?? []) ? 'checked' : '' }}> IDDM - Neuropathy (E10.40)</label><br>
                                                        <label><input type="checkbox" name="diabetes_mellitus[]" value="iddm_nephro" {{ in_array('iddm_nephro', $order_form->diabetes_mellitus ?? []) ? 'checked' : '' }}> IDDM - Nephropathy (E10.20)</label><br>
                                                        <label><input type="checkbox" name="diabetes_mellitus[]" value="iddm_retino" {{ in_array('iddm_retino', $order_form->diabetes_mellitus ?? []) ? 'checked' : '' }}> IDDM - Retinopathy (E10.30)</label>
                                                    </td>
                                                    <td colspan="2">
                                                        Drugs <br>
                                                        <input type="text" class="form-control" name="second_thrombolytic_agent" value="{{ old('second_thrombolytic_agent', @$order_form->second_thrombolytic_agent) }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">ANY OTHER HISTORY<br>
                                                        <textarea class="form-control" name="any_history">{{ old('any_history', @$order_form->any_history) }}</textarea>
                                                    </td>
                                                </tr>

                                                {{-- FAMILY HISTORY --}}
                                                <tr>
                                                    <td colspan="2"><b>FAMILY HISTORY</b></td>
                                                    <td colspan="4">
                                                        <select class="form-control" name="family_history" id="family_history">
                                                            <option value="">-- Select --</option>
                                                            <option value="yes" {{ old('family_history', @$order_form->family_history) == 'yes' ? 'selected' : '' }}>Yes</option>
                                                            <option value="no" {{ old('family_history', @$order_form->family_history) == 'no' ? 'selected' : '' }}>No</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Disease</th>
                                                    <th>Father</th>
                                                    <th>Mother</th>
                                                    <th>Brother</th>
                                                    <th colspan="2">Sister</th>
                                                </tr>
                                                <tr>
                                                    <td>Ischemic heart disease (Z82.4.0)</td>
                                                    <td><input type="checkbox" name="fh_ischemic_father" {{ old('fh_ischemic_father', @$order_form->fh_ischemic_father) ? 'checked' : '' }}></td>
                                                    <td><input type="checkbox" name="fh_ischemic_mother" {{ old('fh_ischemic_mother', @$order_form->fh_ischemic_mother) ? 'checked' : '' }}></td>
                                                    <td><input type="checkbox" name="fh_ischemic_brother" {{ old('fh_ischemic_brother', @$order_form->fh_ischemic_brother) ? 'checked' : '' }}></td>
                                                    <td colspan="2"><input type="checkbox" name="fh_ischemic_sister" {{ old('fh_ischemic_sister', @$order_form->fh_ischemic_sister) ? 'checked' : '' }}></td>
                                                </tr>

                                                <tr>
                                                    <td>Hypertension (Z82.4.1)</td>
                                                    <td><input type="checkbox" name="fh_hyper_father" {{ old('fh_hyper_father', @$order_form->fh_hyper_father) ? 'checked' : '' }}></td>
                                                    <td><input type="checkbox" name="fh_hyper_mother" {{ old('fh_hyper_mother', @$order_form->fh_hyper_mother) ? 'checked' : '' }}></td>
                                                    <td><input type="checkbox" name="fh_hyper_brother" {{ old('fh_hyper_brother', @$order_form->fh_hyper_brother) ? 'checked' : '' }}></td>
                                                    <td colspan="2"><input type="checkbox" name="fh_hyper_sister" {{ old('fh_hyper_sister', @$order_form->fh_hyper_sister) ? 'checked' : '' }}></td>
                                                </tr>

                                                <tr>
                                                    <td>Congenital heart disease (Z82.4.2)</td>
                                                    <td><input type="checkbox" name="fh_chd_father" {{ old('fh_chd_father', @$order_form->fh_chd_father) ? 'checked' : '' }}></td>
                                                    <td><input type="checkbox" name="fh_chd_mother" {{ old('fh_chd_mother', @$order_form->fh_chd_mother) ? 'checked' : '' }}></td>
                                                    <td><input type="checkbox" name="fh_chd_brother" {{ old('fh_chd_brother', @$order_form->fh_chd_brother) ? 'checked' : '' }}></td>
                                                    <td colspan="2"><input type="checkbox" name="fh_chd_sister" {{ old('fh_chd_sister', @$order_form->fh_chd_sister) ? 'checked' : '' }}></td>
                                                </tr>

                                                <tr>
                                                    <td>Diabetes mellitus (Z83.3)</td>
                                                    <td><input type="checkbox" name="fh_dm_father" {{ old('fh_dm_father', @$order_form->fh_dm_father) ? 'checked' : '' }}></td>
                                                    <td><input type="checkbox" name="fh_dm_mother" {{ old('fh_dm_mother', @$order_form->fh_dm_mother) ? 'checked' : '' }}></td>
                                                    <td><input type="checkbox" name="fh_dm_brother" {{ old('fh_dm_brother', @$order_form->fh_dm_brother) ? 'checked' : '' }}></td>
                                                    <td colspan="2"><input type="checkbox" name="fh_dm_sister" {{ old('fh_dm_sister', @$order_form->fh_dm_sister) ? 'checked' : '' }}></td>
                                                </tr>

                                                <tr>
                                                    <td>Bleeding disorder (Z83.2)</td>
                                                    <td><input type="checkbox" name="fh_bleeding_father" {{ old('fh_bleeding_father', @$order_form->fh_bleeding_father) ? 'checked' : '' }}></td>
                                                    <td><input type="checkbox" name="fh_bleeding_mother" {{ old('fh_bleeding_mother', @$order_form->fh_bleeding_mother) ? 'checked' : '' }}></td>
                                                    <td><input type="checkbox" name="fh_bleeding_brother" {{ old('fh_bleeding_brother', @$order_form->fh_bleeding_brother) ? 'checked' : '' }}></td>
                                                    <td colspan="2"><input type="checkbox" name="fh_bleeding_sister" {{ old('fh_bleeding_sister', @$order_form->fh_bleeding_sister) ? 'checked' : '' }}></td>
                                                </tr>

                                                <tr>
                                                    <td>Stroke / Paralysis (Z82.3)</td>
                                                    <td><input type="checkbox" name="fh_stroke_father" {{ old('fh_stroke_father', @$order_form->fh_stroke_father) ? 'checked' : '' }}></td>
                                                    <td><input type="checkbox" name="fh_stroke_mother" {{ old('fh_stroke_mother', @$order_form->fh_stroke_mother) ? 'checked' : '' }}></td>
                                                    <td><input type="checkbox" name="fh_stroke_brother" {{ old('fh_stroke_brother', @$order_form->fh_stroke_brother) ? 'checked' : '' }}></td>
                                                    <td colspan="2"><input type="checkbox" name="fh_stroke_sister" {{ old('fh_stroke_sister', @$order_form->fh_stroke_sister) ? 'checked' : '' }}></td>
                                                </tr>

                                                <tr>
                                                    <td>Sudden death at &lt; 45 yrs (Z84.8)</td>
                                                    <td><input type="checkbox" name="fh_sudden_father" {{ old('fh_sudden_father', @$order_form->fh_sudden_father) ? 'checked' : '' }}></td>
                                                    <td><input type="checkbox" name="fh_sudden_mother" {{ old('fh_sudden_mother', @$order_form->fh_sudden_mother) ? 'checked' : '' }}></td>
                                                    <td><input type="checkbox" name="fh_sudden_brother" {{ old('fh_sudden_brother', @$order_form->fh_sudden_brother) ? 'checked' : '' }}></td>
                                                    <td colspan="2"><input type="checkbox" name="fh_sudden_sister" {{ old('fh_sudden_sister', @$order_form->fh_sudden_sister) ? 'checked' : '' }}></td>
                                                </tr>

                                                <tr>
                                                    <td>Others</td>
                                                    <td><input type="checkbox" name="fh_other_father" {{ old('fh_other_father', @$order_form->fh_other_father) ? 'checked' : '' }}></td>
                                                    <td><input type="checkbox" name="fh_other_mother" {{ old('fh_other_mother', @$order_form->fh_other_mother) ? 'checked' : '' }}></td>
                                                    <td><input type="checkbox" name="fh_other_brother" {{ old('fh_other_brother', @$order_form->fh_other_brother) ? 'checked' : '' }}></td>
                                                    <td colspan="2"><input type="checkbox" name="fh_other_sister" {{ old('fh_other_sister', @$order_form->fh_other_sister) ? 'checked' : '' }}></td>
                                                </tr>

                                                <tr>
                                                    <td colspan="6"><b>PERSONAL HISTORY</b></td>
                                                </tr>

                                                <tr>
                                                    <td colspan="2">Smoking</td>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="smoking_select[]" value="no" {{ in_array('no', $order_form->smoking_select ?? []) ? 'checked' : '' }}> No</label><br>
                                                        <label><input type="checkbox" name="smoking_select[]" value="1-10/day" {{ in_array('1-10/day', $order_form->smoking_select ?? []) ? 'checked' : '' }}> 1-10/day</label><br>
                                                        <label><input type="checkbox" name="smoking_select[]" value="11-20/day" {{ in_array('11-20/day', $order_form->smoking_select ?? []) ? 'checked' : '' }}> 11-20/day</label><br>
                                                        <label><input type="checkbox" name="smoking_select[]" value=">20/day" {{ in_array('>20/day', $order_form->smoking_select ?? []) ? 'checked' : '' }}> >20/day</label><br>
                                                        <label><input type="checkbox" name="smoking_select[]" value="ex-smoker" {{ in_array('ex-smoker', $order_form->smoking_select ?? []) ? 'checked' : '' }}> Ex-Smoker</label><br>
                                                        <label><input type="checkbox" name="smoking_select[]" value="reformed" {{ in_array('reformed', $order_form->smoking_select ?? []) ? 'checked' : '' }}> Reformed</label>
                                                    </td>
                                                    <td colspan="2">
                                                        Duration <br>
                                                        <input type="text" class="form-control" name="smoking_duration" value="{{ old('smoking_duration', $order_form->smoking_duration ?? '') }}">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="2">Alcohol Intake</td>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="alcohol_intake[]" value="nil intake" {{ in_array('nil intake', $order_form->alcohol_intake ?? []) ? 'checked' : '' }}> Nil intake</label><br>
                                                        <label><input type="checkbox" name="alcohol_intake[]" value="reformed" {{ in_array('reformed', $order_form->alcohol_intake ?? []) ? 'checked' : '' }}> Reformed</label><br>
                                                        <label><input type="checkbox" name="alcohol_intake[]" value="occasional" {{ in_array('occasional', $order_form->alcohol_intake ?? []) ? 'checked' : '' }}> Occasional (once a month or less)</label><br>
                                                        <label><input type="checkbox" name="alcohol_intake[]" value="social" {{ in_array('social', $order_form->alcohol_intake ?? []) ? 'checked' : '' }}> Social (once a week or less)</label><br>
                                                        <label><input type="checkbox" name="alcohol_intake[]" value="regular" {{ in_array('regular', $order_form->alcohol_intake ?? []) ? 'checked' : '' }}> Regular (1-4/week)</label><br>
                                                        <label><input type="checkbox" name="alcohol_intake[]" value="moderate" {{ in_array('moderate', $order_form->alcohol_intake ?? []) ? 'checked' : '' }}> Moderate</label><br>
                                                        <label><input type="checkbox" name="alcohol_intake[]" value="daily moderate" {{ in_array('daily moderate', $order_form->alcohol_intake ?? []) ? 'checked' : '' }}> Daily Moderate</label><br>
                                                        <label><input type="checkbox" name="alcohol_intake[]" value="heavy" {{ in_array('heavy', $order_form->alcohol_intake ?? []) ? 'checked' : '' }}> Heavy</label>
                                                    </td>
                                                    <td colspan="2">
                                                        How much ml <br>
                                                        <label><input type="checkbox" name="how_much_ml[]" value="day" {{ in_array('day', $order_form->how_much_ml ?? []) ? 'checked' : '' }}> /day</label><br>
                                                        <label><input type="checkbox" name="how_much_ml[]" value="week" {{ in_array('week', $order_form->how_much_ml ?? []) ? 'checked' : '' }}> /week</label><br>
                                                        <label><input type="checkbox" name="how_much_ml[]" value="month" {{ in_array('month', $order_form->how_much_ml ?? []) ? 'checked' : '' }}> /month</label><br>
                                                        <label><input type="checkbox" name="how_much_ml[]" value="other" {{ in_array('other', $order_form->how_much_ml ?? []) ? 'checked' : '' }}> /other</label>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="2">Physical Exercise</td>
                                                    <td colspan="4">
                                                        <label><input type="checkbox" name="physical_exercise[]" value="nil" {{ in_array('nil', $order_form->physical_exercise ?? []) ? 'checked' : '' }}> Nil</label><br>
                                                        <label><input type="checkbox" name="physical_exercise[]" value="sedentary" {{ in_array('sedentary', $order_form->physical_exercise ?? []) ? 'checked' : '' }}> Sedentary</label><br>
                                                        <label><input type="checkbox" name="physical_exercise[]" value="occasional" {{ in_array('occasional', $order_form->physical_exercise ?? []) ? 'checked' : '' }}> Occasional</label><br>
                                                        <label><input type="checkbox" name="physical_exercise[]" value="light" {{ in_array('light', $order_form->physical_exercise ?? []) ? 'checked' : '' }}> Light (4 kmph up to 5 times a week)</label><br>
                                                        <label><input type="checkbox" name="physical_exercise[]" value="moderate" {{ in_array('moderate', $order_form->physical_exercise ?? []) ? 'checked' : '' }}> Moderate (4–6 kmph 5 times a week)</label><br>
                                                        <label><input type="checkbox" name="physical_exercise[]" value="jogging" {{ in_array('jogging', $order_form->physical_exercise ?? []) ? 'checked' : '' }}> Jogging</label><br>
                                                        <label><input type="checkbox" name="physical_exercise[]" value="strenuous irregularly" {{ in_array('strenuous irregularly', $order_form->physical_exercise ?? []) ? 'checked' : '' }}> Strenuous irregularly</label><br>
                                                        <label><input type="checkbox" name="physical_exercise[]" value="strenuous regularly" {{ in_array('strenuous regularly', $order_form->physical_exercise ?? []) ? 'checked' : '' }}> Strenuous regularly</label>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="2">Food Habits</td>
                                                    <td colspan="4">
                                                        <label><input type="checkbox" name="food_habits[]" value="vegetarian" {{ in_array('vegetarian', $order_form->food_habits ?? []) ? 'checked' : '' }}> Vegetarian</label><br>
                                                        <label><input type="checkbox" name="food_habits[]" value="lacto" {{ in_array('lacto', $order_form->food_habits ?? []) ? 'checked' : '' }}> Lacto-ovo vegetarian</label><br>
                                                        <label><input type="checkbox" name="food_habits[]" value="non-veg white" {{ in_array('non-veg white', $order_form->food_habits ?? []) ? 'checked' : '' }}> Non-vegetarian (white mutton only)</label><br>
                                                        <label><input type="checkbox" name="food_habits[]" value="non-veg white+red" {{ in_array('non-veg white+red', $order_form->food_habits ?? []) ? 'checked' : '' }}> Non-vegetarian (white & red mutton)</label>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="2">Yoga and Meditation</td>
                                                    <td colspan="4">
                                                        <label><input type="checkbox" name="yoga_meditation[]" value="no" {{ in_array('no', $order_form->yoga_meditation ?? []) ? 'checked' : '' }}> No</label><br>
                                                        <label><input type="checkbox" name="yoga_meditation[]" value="simple regularly" {{ in_array('simple regularly', $order_form->yoga_meditation ?? []) ? 'checked' : '' }}> Simple asana regularly</label><br>
                                                        <label><input type="checkbox" name="yoga_meditation[]" value="simple irregularly" {{ in_array('simple irregularly', $order_form->yoga_meditation ?? []) ? 'checked' : '' }}> Simple asana irregularly</label><br>
                                                        <label><input type="checkbox" name="yoga_meditation[]" value="complex regularly" {{ in_array('complex regularly', $order_form->yoga_meditation ?? []) ? 'checked' : '' }}> Complex asana regularly</label><br>
                                                        <label><input type="checkbox" name="yoga_meditation[]" value="complex irregularly" {{ in_array('complex irregularly', $order_form->yoga_meditation ?? []) ? 'checked' : '' }}> Complex asana irregularly</label>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="2">Addictive Drugs</td>
                                                    <td colspan="4">
                                                        <label><input type="checkbox" name="addictive_drugs[]" value="no" {{ in_array('no', $order_form->addictive_drugs ?? []) ? 'checked' : '' }}> No</label><br>
                                                        <label><input type="checkbox" name="addictive_drugs[]" value="opium" {{ in_array('opium', $order_form->addictive_drugs ?? []) ? 'checked' : '' }}> Opium</label><br>
                                                        <label><input type="checkbox" name="addictive_drugs[]" value="tobacco" {{ in_array('tobacco', $order_form->addictive_drugs ?? []) ? 'checked' : '' }}> Tobacco</label><br>
                                                        <label><input type="checkbox" name="addictive_drugs[]" value="narcotics" {{ in_array('narcotics', $order_form->addictive_drugs ?? []) ? 'checked' : '' }}> Narcotics</label><br>
                                                        <label><input type="checkbox" name="addictive_drugs[]" value="others" {{ in_array('others', $order_form->addictive_drugs ?? []) ? 'checked' : '' }}> Others</label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">Personality type A</td>
                                                    <td colspan="4">
                                                        <select class="form-control" name="personality_type" id="personality_type">
                                                            <option value="">-- Select --</option>
                                                            <option value="yes" {{ old('personality_type', @$order_form->personality_type) == 'yes' ? 'selected' : '' }}>Yes</option>
                                                            <option value="no" {{ old('personality_type', @$order_form->personality_type) == 'no' ? 'selected' : '' }}>No</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">Allergy</td>
                                                    <td colspan="2">
                                                        <select class="form-control" name="allergy" id="allergy">
                                                            <option value="">-- Select --</option>
                                                            <option value="yes" {{ old('allergy', @$order_form->allergy) == 'yes' ? 'selected' : '' }}>Yes</option>
                                                            <option value="no" {{ old('allergy', @$order_form->allergy) == 'no' ? 'selected' : '' }}>No</option>
                                                        </select>
                                                    </td>
                                                    <td colspan="2">
                                                        To what : <br>
                                                        <input type="text" class="form-control" name="allergy_to_what" value="{{ old('allergy_to_what', $order_form->allergy_to_what ?? '') }}">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="6"><b>Gynaecological & Obstetric History (for females)</b></td>
                                                </tr>
                                                <tr>
                                                    <td>Menarche<br>
                                                        <input type="text" class="form-control form-control-sm" name="gynaecological_menarche" value="{{ old('gynaecological_menarche', $order_form->gynaecological_menarche ?? '') }}">
                                                    </td>
                                                    <td>Cycle<br>
                                                        <input type="text" class="form-control form-control-sm" name="gynaecological_cycle" value="{{ old('gynaecological_cycle', $order_form->gynaecological_cycle ?? '') }}">
                                                    </td>
                                                    <td colspan="2">Loss<br>
                                                        <input type="text" class="form-control form-control-sm" name="gynaecological_loss" value="{{ old('gynaecological_loss', $order_form->gynaecological_loss ?? '') }}">
                                                    </td>
                                                    <td colspan="2">Inter Menstrual Bleeding<br>
                                                        <input type="text" class="form-control form-control-sm" name="gynaecological_bleeding" value="{{ old('gynaecological_bleeding', $order_form->gynaecological_bleeding ?? '') }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3">Pain<br>
                                                        <input type="text" class="form-control form-control-sm" name="gynaecological_pain" value="{{ old('gynaecological_pain', $order_form->gynaecological_pain ?? '') }}">
                                                    </td>
                                                    <td colspan="3">l.M.P<br>
                                                        <input type="text" class="form-control form-control-sm" name="gynaecological_lmp" value="{{ old('gynaecological_lmp', $order_form->gynaecological_lmp ?? '') }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3">Vaginal Discharge<br>
                                                        <input type="text" class="form-control form-control-sm" name="gynaecological_discharge" value="{{ old('gynaecological_discharge', $order_form->gynaecological_discharge ?? '') }}">
                                                    </td>
                                                    <td>Cervical smear<br>
                                                        <input type="text" class="form-control form-control-sm" name="gynaecological_cervical" value="{{ old('gynaecological_cervical', $order_form->gynaecological_cervical ?? '') }}">
                                                    </td>
                                                    <td colspan="3">Contracepjtion<br>
                                                        <input type="text" class="form-control form-control-sm" name="gynaecological_contracepjtion" value="{{ old('gynaecological_contracepjtion', $order_form->gynaecological_contracepjtion ?? '') }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">Obesteric History<br>
                                                        <textarea class="form-control" name="gynaecological_obesteric">{{ old('gynaecological_obesteric', @$order_form->gynaecological_obesteric) }}</textarea>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="6">
                                                        <div class="d-flex flex-col py-2 gap-2">
                                                            <div>
                                                                <b>Relevant Family History:</b>
                                                            </div>
                                                            <div>
                                                                <input type="text" class="form-control d-inline-block" name="relevant_family_history" style="width:auto;" value="{{ old('relevant_family_history', $order_form->relevant_family_history ?? '') }}">
                                                            </div>
                                                            <div>
                                                                <select class="form-control" name="family_history_select" id="family_history_select" style="width:180px;">
                                                                    <option value="negative" {{ old('family_history_select', @$order_form->family_history_select) == 'negative' ? 'selected' : '' }}>Negative</option>
                                                                    <option value="unknown" {{ old('family_history_select', @$order_form->family_history_select) == 'unknown' ? 'selected' : '' }}>Unknown</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex flex-col py-2 gap-2">
                                                            <div>
                                                                <b>Socioeconomic History :</b> Lifestyle: 
                                                            </div>
                                                            <div>
                                                                <select class="form-control" name="socioeconomic_history" id="socioeconomic_history" style="width:180px;">
                                                                    <option value="sedentary" {{ old('socioeconomic_history', @$order_form->socioeconomic_history) == 'sedentary' ? 'selected' : '' }}>Sedentary</option>
                                                                    <option value="active" {{ old('socioeconomic_history', @$order_form->socioeconomic_history) == 'active' ? 'selected' : '' }}>Active</option>
                                                                </select>
                                                            </div>
                                                            <div>
                                                                Occupation: <input type="text" class="form-control d-inline-block" name="occupation" style="width:120px;" value="{{ old('occupation', $order_form->occupation ?? '') }}">
                                                            </div>
                                                        </div>
                                                        <div class="d-flex flex-col py-2 gap-2">
                                                            <div>
                                                                <b>Educational Status :</b>
                                                            </div>
                                                            <div>
                                                                <select class="form-control" name="educational_status" id="educational_status" style="width:180px;">
                                                                    <option value="primary" {{ old('educational_status', @$order_form->educational_status) == 'primary' ? 'selected' : '' }}>Primary</option>
                                                                    <option value="higher_secondary" {{ old('educational_status', @$order_form->educational_status) == 'higher_secondary' ? 'selected' : '' }}>Higher Secondary</option>
                                                                    <option value="graduate" {{ old('educational_status', @$order_form->educational_status) == 'graduate' ? 'selected' : '' }}>Graduate</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td><b>Any emotional or psychiatric disorder</b></td>
                                                    <td colspan="2">
                                                        <select class="form-control" name="psychiatric_disorder" id="psychiatric_disorder">
                                                            <option value="">-- Select --</option>
                                                            <option value="yes" {{ old('psychiatric_disorder', @$order_form->psychiatric_disorder) == 'yes' ? 'selected' : '' }}>Yes</option>
                                                            <option value="no" {{ old('psychiatric_disorder', @$order_form->psychiatric_disorder) == 'no' ? 'selected' : '' }}>No</option>
                                                        </select>
                                                    </td>
                                                    <td>Recent death in the family</td>
                                                    <td colspan="2">
                                                        <select class="form-control" name="recent_death_family" id="recent_death_family">
                                                            <option value="">-- Select --</option>
                                                            <option value="yes" {{ old('recent_death_family', @$order_form->recent_death_family) == 'yes' ? 'selected' : '' }}>Yes</option>
                                                            <option value="no" {{ old('recent_death_family', @$order_form->recent_death_family) == 'no' ? 'selected' : '' }}>No</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Risk of suicide</td>
                                                    <td colspan="2">
                                                        <select class="form-control" name="risk_of_suicide" id="risk_of_suicide">
                                                            <option value="">-- Select --</option>
                                                            <option value="yes" {{ old('risk_of_suicide', @$order_form->risk_of_suicide) == 'yes' ? 'selected' : '' }}>Yes</option>
                                                            <option value="no" {{ old('risk_of_suicide', @$order_form->risk_of_suicide) == 'no' ? 'selected' : '' }}>No</option>
                                                        </select>
                                                    </td>
                                                    <td>Sleep Disorder</td>
                                                    <td colspan="2">
                                                        <select class="form-control" name="sleep_disorder" id="sleep_disorder">
                                                            <option value="">-- Select --</option>
                                                            <option value="yes" {{ old('sleep_disorder', @$order_form->sleep_disorder) == 'yes' ? 'selected' : '' }}>Yes</option>
                                                            <option value="no" {{ old('sleep_disorder', @$order_form->sleep_disorder) == 'no' ? 'selected' : '' }}>No</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><b>Victims of Abuse and Neglect</b></td>
                                                    <td colspan="5">
                                                        <select class="form-control" name="victims_abuse_neglect" id="victims_abuse_neglect">
                                                            <option value="">-- Select --</option>
                                                            <option value="yes" {{ old('victims_abuse_neglect', @$order_form->victims_abuse_neglect) == 'yes' ? 'selected' : '' }}>Yes</option>
                                                            <option value="no" {{ old('victims_abuse_neglect', @$order_form->victims_abuse_neglect) == 'no' ? 'selected' : '' }}>No</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">Drug or Alcohol Dependency</td>
                                                </tr>
                                                <tr>
                                                    <td>Addiction</td>
                                                    <td colspan="5">
                                                        <select class="form-control" name="addiction[]" id="addiction" multiple>
                                                            <option value="tobacco" {{ in_array('tobacco', old('addiction', @$order_form->addiction ?? [])) ? 'selected' : '' }}>Tobacco / Smoking</option>
                                                            <option value="ethanol" {{ in_array('ethanol', old('addiction', @$order_form->addiction ?? [])) ? 'selected' : '' }}>Ethanol</option>
                                                            <option value="drugs" {{ in_array('drugs', old('addiction', @$order_form->addiction ?? [])) ? 'selected' : '' }}>Drugs</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Action taken: </td>
                                                    <td colspan="5">
                                                        <textarea class="form-control" name="any_other_history">{{ old('any_other_history', @$order_form->any_other_history) }}</textarea>
                                                    </td>
                                                </tr>

                                                {{-- PHYSICAL EXAM --}}
                                                <tr>
                                                    <th colspan="6" style="text-align:center;">PHYSICAL EXAM</th>
                                                </tr>

                                                <tr>
                                                    <!-- Left Side -->
                                                    <td colspan="3" style="width:50%; vertical-align: top;">
                                                        <b>Pain Rating Scale:</b><br>
                                                        <label>
                                                            <input type="checkbox" name="pain_scale[]" value="numerical"
                                                                {{ in_array('numerical', old('pain_scale', $order_form->pain_scale ?? [])) ? 'checked' : '' }}>
                                                            Numerical rating scale
                                                        </label><br>

                                                        <label>
                                                            <input type="checkbox" name="pain_scale[]" value="cpot"
                                                                {{ in_array('cpot', old('pain_scale', $order_form->pain_scale ?? [])) ? 'checked' : '' }}>
                                                            CPOT (Ventilator/Comatose)
                                                        </label>
                                                    </td>

                                                    <!-- Right Side -->
                                                    <td colspan="3" style="width:50%; vertical-align: top;">
                                                        <b>Score:</b>
                                                        <input type="text" name="physical_exam_score" class="form-control d-inline-block" style="width:100px;"
                                                            value="{{ old('physical_exam_score', $order_form->physical_exam_score ?? '') }}">

                                                        <b>Location:</b>
                                                        <input type="text" name="physical_exam_location" class="form-control d-inline-block" style="width:200px;"
                                                            value="{{ old('physical_exam_location', $order_form->physical_exam_location ?? '') }}"><br><br>

                                                        <b>Acuity:</b>
                                                        <label>
                                                            <input type="checkbox" name="acuity[]" value="acute"
                                                                {{ in_array('acute', old('acuity', $order_form->acuity ?? [])) ? 'checked' : '' }}>
                                                            Acute (&lt;6 Weeks)
                                                        </label>
                                                        <label>
                                                            <input type="checkbox" name="acuity[]" value="chronic"
                                                                {{ in_array('chronic', old('acuity', $order_form->acuity ?? [])) ? 'checked' : '' }}>
                                                            Chronic (&gt;6 Weeks)
                                                        </label><br><br>

                                                        <b>Modifying factors:</b><br>
                                                        Decreasing:
                                                        <input type="text" name="decreasing" class="form-control"
                                                            value="{{ old('decreasing', $order_form->decreasing ?? '') }}"><br>
                                                        Increasing:
                                                        <input type="text" name="increasing" class="form-control"
                                                            value="{{ old('increasing', $order_form->increasing ?? '') }}"><br><br>

                                                        <b>Character:</b><br>
                                                        <label><input type="checkbox" name="character[]" value="sharp" {{ in_array('sharp', old('character', $order_form->character ?? [])) ? 'checked' : '' }}> Sharp</label> <br>
                                                        <label><input type="checkbox" name="character[]" value="dull" {{ in_array('dull', old('character', $order_form->character ?? [])) ? 'checked' : '' }}> Dull</label> <br>
                                                        <label><input type="checkbox" name="character[]" value="aching" {{ in_array('aching', old('character', $order_form->character ?? [])) ? 'checked' : '' }}> Aching</label><br>
                                                        <label><input type="checkbox" name="character[]" value="burning" {{ in_array('burning', old('character', $order_form->character ?? [])) ? 'checked' : '' }}> Burning</label><br>
                                                        <label><input type="checkbox" name="character[]" value="stabbing" {{ in_array('stabbing', old('character', $order_form->character ?? [])) ? 'checked' : '' }}> Stabbing</label><br>
                                                        <label><input type="checkbox" name="character[]" value="referred" {{ in_array('referred', old('character', $order_form->character ?? [])) ? 'checked' : '' }}> Referred/Radiating</label>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="6">
                                                        <b>Vital Signs:</b><br>
                                                        <table border="1" width="100%" cellspacing="0" cellpadding="5">
                                                            <tr>
                                                                <th>Pulse</th>
                                                                <th>Blood Pressure</th>
                                                                <th>Respiratory Rate</th>
                                                                <th>Temperature</th>
                                                            </tr>
                                                            <tr>
                                                                <td><input type="text" name="physical_pulse" class="form-control"
                                                                    value="{{ old('physical_pulse', $order_form->physical_pulse ?? '') }}"></td>
                                                                <td><input type="text" name="physical_exam_bp" class="form-control"
                                                                    value="{{ old('physical_exam_bp', $order_form->physical_exam_bp ?? '') }}"></td>
                                                                <td><input type="text" name="physical_exam_rate" class="form-control"
                                                                    value="{{ old('physical_exam_rate', $order_form->physical_exam_rate ?? '') }}"></td>
                                                                <td colspan="2"><input type="text" name="physical_exam_temp" class="form-control"
                                                                    value="{{ old('physical_exam_temp', $order_form->physical_exam_temp ?? '') }}"></td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="6">
                                                        (Encircle" WNL" if normal exam) (Encircle the system if the findings are to be part of the summary) <br><br>
                                                        GENERAL EXAMINATION: WNL <br>
                                                        Parameters: Height, Weight, Built, Nutrition, Anaemia, Jaundice, Gedema, Cyanosis, Dehydration, Clubbing. <br>
                                                        <textarea class="form-control" name="general_examination">{{ old('general_examination', @$order_form->general_examination) }}</textarea> <br><br>

                                                        BREAST: Size, Shape, Symmetry, Tenderness, and Masses <br>
                                                        WNL <br>
                                                        <textarea class="form-control" name="breast_size">{{ old('breast_size', @$order_form->breast_size) }}</textarea><br><br>

                                                        ENT: <br>
                                                        EARS; Pinna, auditory canals, tympanic membranes and gross hearing  <br>
                                                        WNL <br>
                                                        <textarea class="form-control" name="ent_ears">{{ old('ent_ears', @$order_form->ent_ears) }}</textarea><br><br>

                                                        NOSE: Deformities and seoptal deviation: obstruction, mucous membrane inflammation, polyps, bleeding and discharge. Turnibates  <br>
                                                        WNL <br>
                                                        <textarea class="form-control" name="nose_wnl">{{ old('nose_wnl', @$order_form->nose_wnl) }}</textarea><br><br>

                                                        THROAT: Mucosal color, exudates and lesions: tonsil size, symmetry and exudates: post nasal discharge,Dental hygiene <br>
                                                        WNL <br>
                                                        <textarea class="form-control" name="throat_wnl">{{ old('throat_wnl', @$order_form->throat_wnl) }}</textarea><br><br>

                                                        MUSCULOSKELETAL: Joint mobility, tenderness, effusion, erythema and deformity. <br>
                                                        WNL <br>
                                                        <textarea class="form-control" name="musculoskeletal_wnl">{{ old('musculoskeletal_wnl', @$order_form->musculoskeletal_wnl) }}</textarea><br><br>

                                                        CARDIO VASCULAR SYSTEM: WNL <br>
                                                        Parameters: Pulse: Rate, Rhythm, Character, Condition of arterial wall, Peripheral, Pulse: Apex beat, C.S from midline, Lt Para sternal heave Thrill Heart Sounds 1st & 2nd, Added Sounds, Murmur  <br>
                                                        <textarea class="form-control" name="cardio_vascular">{{ old('cardio_vascular', @$order_form->cardio_vascular) }}</textarea><br><br>

                                                        RESPIRATORY SYSTEM: WNL <br>
                                                        Parameters: Inspection. Palpation: Position Of Trachea, Chest Expansion, Vocal Fremitus, Percussion. <br>
                                                        Auscultation: Breath Sound, Added Sound. Vocal Resonance <br>
                                                        <textarea class="form-control" name="respiratory_system">{{ old('respiratory_system', @$order_form->respiratory_system) }}</textarea><br><br>

                                                        ALIMENTARY SYSTEM: WNL <br>
                                                        Parameters: Lip, Teeth, Gum, Tongue. Tonsil, Pharynx <br>
                                                        <textarea class="form-control" name="alimentary_system">{{ old('alimentary_system', @$order_form->alimentary_system) }}</textarea><br><br>

                                                        ORAL CAVITY: WNL <br>
                                                        <textarea class="form-control" name="oral_cavity">{{ old('oral_cavity', @$order_form->oral_cavity) }}</textarea><br><br>

                                                        ABDOMEN: WNL <br>
                                                        Parameters: Inspection: General Appearance, Umbilicus, Palpation: Liver, Hernias, Spleen, Kidneys DRE <br>
                                                        Percussion: Auscultation: Bowel Sound, Others <br>
                                                        <textarea class="form-control" name="abdomen_wnl">{{ old('abdomen_wnl', @$order_form->abdomen_wnl) }}</textarea><br><br>

                                                        UROLOGENITAL SYSTEM: WNL <br>
                                                        Parameters: Urinary Bladder. <br>
                                                        Male: Scrotum, Testes. Epididymis, Penis, Urinary incontinence. <br>
                                                        Female: Vulva, Vaginal, P/V Exam <br>
                                                        <textarea class="form-control" name="urologenital_system">{{ old('urologenital_system', @$order_form->urologenital_system) }}</textarea><br><br>

                                                        NEUROLOGICAL EXAMINATION: WNL <br>
                                                        Parameters: Higher psychic function, GCS and Pupils. Cranial Nerves, Motor System, Reflexes, Sensory System, Romberg's Test, Cerebellar Signs, Sign of meningeal irritation <br>
                                                        <textarea class="form-control" name="neurological_examination">{{ old('neurological_examination', @$order_form->neurological_examination) }}</textarea><br><br>

                                                        COGNITIVE FUNCTION: Orientation memory, short term memory. Long term memory, language skill, Visual <br>
                                                        spatial skill: Executive Function: Motor skill: <br>
                                                        Mini Mental State Exam: (Score) <br>
                                                        <textarea class="form-control" name="cognitive_function">{{ old('cognitive_function', @$order_form->cognitive_function) }}</textarea><br><br>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th colspan="6">Glasgow Coma Scale (GCS):</th>
                                                </tr>
                                                <tr>
                                                    <th>Eye opening </th>
                                                    <th>Verbal response </th>
                                                    <th colspan="2">Motor response </th>
                                                    <th colspan="2">GCS Score </th>
                                                </tr>
                                                <tr>
                                                    <td>Spontaneous - 4</td>
                                                    <td>Oriented - 5</td>
                                                    <td colspan="2">Obeys Command - 6</td>
                                                    <td colspan="2"><input type="text" name="gcs_score_one" class="form-control" value="{{ old('gcs_score_one', $order_form->gcs_score_one ?? '') }}"></td>
                                                </tr>
                                                <tr>
                                                    <td>To Speech - 3</td>
                                                    <td>Confused - 4</td>
                                                    <td colspan="2">Localizing pain - 5</td>
                                                    <td colspan="2"><input type="text" name="gcs_score_two" class="form-control" value="{{ old('gcs_score_two', $order_form->gcs_score_two ?? '') }}"></td>
                                                </tr>
                                                <tr>
                                                    <td>To pain - 2</td>
                                                    <td>Words (Inappropriate) - 3</td>
                                                    <td colspan="2">Withdraws to pain - 4</td>
                                                    <td colspan="2"><input type="text" name="gcs_score_three" class="form-control" value="{{ old('gcs_score_three', $order_form->gcs_score_three ?? '') }}"></td>
                                                </tr>
                                                <tr>
                                                    <td>None - 1</td>
                                                    <td>Sound</td>
                                                    <td colspan="2">Flexion to Pain - 3</td>
                                                    <td colspan="2"><input type="text" name="gcs_score_four" class="form-control" value="{{ old('gcs_score_four', $order_form->gcs_score_four ?? '') }}"></td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>(Incomprehensible) - 2</td>
                                                    <td colspan="2">Extension to pain - 2</td>
                                                    <td colspan="2"><input type="text" name="gcs_score_five" class="form-control" value="{{ old('gcs_score_five', $order_form->gcs_score_five ?? '') }}"></td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>None - 1</td>
                                                    <td colspan="2">None - 1</td>
                                                    <td colspan="2"><input type="text" name="gcs_score_six" class="form-control" value="{{ old('gcs_score_six', $order_form->gcs_score_six ?? '') }}"></td>
                                                </tr>

                                                <tr>
                                                    <th>Psychiatric</th>
                                                    <td colspan="3">
                                                        <label><input type="checkbox" name="psychiatric_multiple[]" value="calm" {{ in_array('calm', old('psychiatric_multiple', $order_form->psychiatric_multiple ?? [])) ? 'checked' : '' }}> Calm</label><br>
                                                        <label><input type="checkbox" name="psychiatric_multiple[]" value="anxious" {{ in_array('anxious', old('psychiatric_multiple', $order_form->psychiatric_multiple ?? [])) ? 'checked' : '' }}> Anxious</label><br>
                                                        <label><input type="checkbox" name="psychiatric_multiple[]" value="depressed" {{ in_array('depressed', old('psychiatric_multiple', $order_form->psychiatric_multiple ?? [])) ? 'checked' : '' }}> Depressed</label><br>
                                                        <label><input type="checkbox" name="psychiatric_multiple[]" value="other" {{ in_array('other', old('psychiatric_multiple', $order_form->psychiatric_multiple ?? [])) ? 'checked' : '' }}> Other (Specify)</label><br>
                                                        <input type="text" name="psychiatric_other" class="form-control" placeholder="If others" value="{{ old('psychiatric_other', $order_form->psychiatric_other ?? '') }}">
                                                    </td>
                                                    <td colspan="2">WNL</td>
                                                </tr>

                                                <tr>
                                                    <th>Functional Assessment: </th>
                                                    <td colspan="5">
                                                        <textarea class="form-control" name="functional_assessment">{{ old('functional_assessment', $order_form->functional_assessment ?? '') }}</textarea>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Activity </th>
                                                    <th>Independent </th>
                                                    <th colspan="2">Needs assistance </th>
                                                    <th colspan="2">Dependent </th>
                                                </tr>
                                                <tr>
                                                    <td>Sitting</td>
                                                    <td><input type="text" name="sitting_independent" class="form-control" value="{{ old('sitting_independent', $order_form->sitting_independent ?? '') }}"></td>
                                                    <td colspan="2"><input type="text" name="sitting_assistance" class="form-control" value="{{ old('sitting_assistance', $order_form->sitting_assistance ?? '') }}"></td>
                                                    <td colspan="2"><input type="text" name="sitting_dependent" class="form-control" value="{{ old('sitting_dependent', $order_form->sitting_dependent ?? '') }}"></td>
                                                </tr>
                                                <tr>
                                                    <td>Standing</td>
                                                    <td><input type="text" name="standing_independent" class="form-control" value="{{ old('standing_independent', $order_form->standing_independent ?? '') }}"></td>
                                                    <td colspan="2"><input type="text" name="standing_assistance" class="form-control" value="{{ old('standing_assistance', $order_form->standing_assistance ?? '') }}"></td>
                                                    <td colspan="2"><input type="text" name="standing_dependent" class="form-control" value="{{ old('standing_dependent', $order_form->standing_dependent ?? '') }}"></td>
                                                </tr>
                                                <tr>
                                                    <td>Ambulation</td>
                                                    <td><input type="text" name="ambulation_independent" class="form-control" value="{{ old('ambulation_independent', $order_form->ambulation_independent ?? '') }}"></td>
                                                    <td colspan="2"><input type="text" name="ambulation_assistance" class="form-control" value="{{ old('ambulation_assistance', $order_form->ambulation_assistance ?? '') }}"></td>
                                                    <td colspan="2"><input type="text" name="ambulation_dependent" class="form-control" value="{{ old('ambulation_dependent', $order_form->ambulation_dependent ?? '') }}"></td>
                                                </tr>
                                                <tr>
                                                    <td>Stair Climbing</td>
                                                    <td><input type="text" name="climbing_independent" class="form-control" value="{{ old('climbing_independent', $order_form->climbing_independent ?? '') }}"></td>
                                                    <td colspan="2"><input type="text" name="climbing_assistance" class="form-control" value="{{ old('climbing_assistance', $order_form->climbing_assistance ?? '') }}"></td>
                                                    <td colspan="2"><input type="text" name="climbing_dependent" class="form-control" value="{{ old('climbing_dependent', $order_form->climbing_dependent ?? '') }}"></td>
                                                </tr>
                                                <tr>
                                                    <td>Disabilities if any </td>
                                                    <td><input type="text" name="disabilities_independent" class="form-control" value="{{ old('disabilities_independent', $order_form->disabilities_independent ?? '') }}"></td>
                                                    <td colspan="2"><input type="text" name="disabilities_assistance" class="form-control" value="{{ old('disabilities_assistance', $order_form->disabilities_assistance ?? '') }}"></td>
                                                    <td colspan="2"><input type="text" name="disabilities_dependent" class="form-control" value="{{ old('disabilities_dependent', $order_form->disabilities_dependent ?? '') }}"></td>
                                                </tr>

                                                <tr>
                                                    <th colspan="6">If Dependent-Refer to Physiotherapist:</th>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">
                                                        <div class="d-flex flex-col py-2 gap-2">
                                                            <div>
                                                                <b>Suspected of communicable disease:</b>
                                                            </div>
                                                            <div>
                                                                <select class="form-control" name="suspected_communicable_disease" id="suspected_communicable_disease" style="width:180px;">
                                                                    <option>---Select---</option>
                                                                    <option value="yes" {{ old('suspected_communicable_disease', $order_form->suspected_communicable_disease ?? '') == 'yes' ? 'selected' : '' }}>Yes</option>
                                                                    <option value="no" {{ old('suspected_communicable_disease', $order_form->suspected_communicable_disease ?? '') == 'no' ? 'selected' : '' }}>No</option>
                                                                </select>
                                                            </div>
                                                            <div>
                                                                <input type="text" class="form-control d-inline-block" name="suspected_communicable_ifyes" placeholder="If yes specify" style="width:auto;" value="{{ old('suspected_communicable_ifyes', $order_form->suspected_communicable_ifyes ?? '') }}">
                                                            </div>
                                                        </div>

                                                        <div class="d-flex flex-col py-2 gap-2">
                                                            <div>
                                                                <b>Immuno compromised status:</b>
                                                            </div>
                                                            <div>
                                                                <select class="form-control" name="immuno_compromised_status" id="immuno_compromised_status" style="width:180px;">
                                                                    <option>---Select---</option>
                                                                    <option value="yes" {{ old('immuno_compromised_status', $order_form->immuno_compromised_status ?? '') == 'yes' ? 'selected' : '' }}>Yes</option>
                                                                    <option value="no" {{ old('immuno_compromised_status', $order_form->immuno_compromised_status ?? '') == 'no' ? 'selected' : '' }}>No</option>
                                                                </select>
                                                            </div>
                                                            <div>
                                                                <input type="text" class="form-control d-inline-block" name="immuno_compromised_ifyes" placeholder="If yes specify" style="width:auto;" value="{{ old('immuno_compromised_ifyes', $order_form->immuno_compromised_ifyes ?? '') }}">
                                                            </div>
                                                        </div>

                                                        <div class="d-flex flex-col py-2 gap-2">
                                                            <div>
                                                                <b>Isolation requirement & patient placement (Please tick):</b>
                                                            </div>
                                                        </div>

                                                        <div class="d-flex flex-col py-2 gap-2">
                                                            <div>
                                                                <label><input type="checkbox" name="psychiatric_select[]" value="no_need" {{ in_array('no_need', old('psychiatric_select', $order_form->psychiatric_select ?? [])) ? 'checked' : '' }}> No need -> Patient choice</label><br>
                                                                <label><input type="checkbox" name="psychiatric_select[]" value="protective" {{ in_array('protective', old('psychiatric_select', $order_form->psychiatric_select ?? [])) ? 'checked' : '' }}> Protective -> Single private</label><br>

                                                                <label>Source:</label><br>
                                                                <label>1. Airborne -> <input type="checkbox" name="psychiatric_select[]" value="airborne" {{ in_array('airborne', old('psychiatric_select', $order_form->psychiatric_select ?? [])) ? 'checked' : '' }}> Negative pressure room</label><br>
                                                                <label>2. Droplet -> <input type="checkbox" name="psychiatric_select[]" value="droplet" {{ in_array('droplet', old('psychiatric_select', $order_form->psychiatric_select ?? [])) ? 'checked' : '' }}> Single private</label><br>
                                                                <label>3. Contact Single -> <input type="checkbox" name="psychiatric_select[]" value="contact_single" {{ in_array('contact_single', old('psychiatric_select', $order_form->psychiatric_select ?? [])) ? 'checked' : '' }}> Private (preferred) or corner bed in ward</label><br>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th colspan="6">Nutritional (Encircle the findings for each criteria and add up the score):</th>
                                                </tr>
                                                <tr>
                                                    <th>Criteria </th>
                                                    <th>0 </th>
                                                    <th>1 </th>
                                                    <th>2 </th>
                                                    <th colspan="2">3 </th>
                                                </tr>
                                                <tr>
                                                    <td>Decreased food intake over last 3 months</td>
                                                    <td>Severe loss</td>
                                                    <td>Moderate loss</td>
                                                    <td></td>
                                                    <td colspan="2">No</td>
                                                </tr>
                                                <tr>
                                                    <td>Weight loss in last 3 months</td>
                                                    <td>>3 kg</td>
                                                    <td>Don't know</td>
                                                    <td>1-3 kg </td>
                                                    <td colspan="2">No loss </td>
                                                </tr>
                                                <tr>
                                                    <td>Mobility</td>
                                                    <td>Bed chair bound </td>
                                                    <td>Able to but doesn't</td>
                                                    <td>Fully mobile</td>
                                                    <td colspan="2"></td>
                                                </tr>
                                                <tr>
                                                    <td>Acute disease in last 3 months </td>
                                                    <td>Yes </td>
                                                    <td></td>
                                                    <td>No</td>
                                                    <td colspan="2"></td>
                                                </tr>
                                                <tr>
                                                    <td>Neuropsychological problem </td>
                                                    <td>Severe dementia/depression </td>
                                                    <td>Mild dementia</td>
                                                    <td>None</td>
                                                    <td colspan="2"></td>
                                                </tr>
                                                <tr>
                                                    <td>Body habitus </td>
                                                    <td>Cadhectic/Morbid obese </td>
                                                    <td>Obese</td>
                                                    <td>Thin</td>
                                                    <td colspan="2">Average</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6"><label for="Total Score:">Total Score: <input type="text" name="nutritional_score" id="nutritional_score" value="{{ old('nutritional_score', $order_form->nutritional_score ?? '') }}"></label> </td>
                                                </tr>

                                                <tr>
                                                    <th colspan="6">Discharge Planning: (Encircle):</th>
                                                </tr>
                                                <tr>
                                                    <td>Social support needed at home </td>
                                                    <td colspan="2">
                                                        <select class="form-control" name="social_support_needed" id="social_support_needed" style="width:180px;">
                                                            <option>---Select---</option>
                                                            <option value="yes" {{ old('social_support_needed', @$order_form->social_support_needed) == 'yes' ? 'selected' : '' }}>Yes</option>
                                                            <option value="no" {{ old('social_support_needed', @$order_form->social_support_needed) == 'no' ? 'selected' : '' }}>No</option>
                                                        </select>
                                                    </td>
                                                    <td colspan="3" rowspan="4"> Discharge  Plan : <br>
                                                        <textarea class="form-control" name="discharge_plan">{{ old('discharge_plan', $order_form->discharge_plan ?? '') }}</textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Home equipment anticipated </td>
                                                    <td colspan="2">
                                                        <select class="form-control" name="home_equipment_anticipate" id="home_equipment_anticipate" style="width:180px;">
                                                            <option>---Select---</option>
                                                            <option value="yes" {{ old('home_equipment_anticipate', @$order_form->home_equipment_anticipate) == 'yes' ? 'selected' : '' }}>Yes</option>
                                                            <option value="no" {{ old('home_equipment_anticipate', @$order_form->home_equipment_anticipate) == 'no' ? 'selected' : '' }}>No</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Physiotherapy at home anticipated </td>
                                                    <td colspan="2">
                                                        <select class="form-control" name="physiotherapy_home_anticipated" id="physiotherapy_home_anticipated" style="width:180px;">
                                                            <option>---Select---</option>
                                                            <option value="yes" {{ old('physiotherapy_home_anticipated', @$order_form->physiotherapy_home_anticipated) == 'yes' ? 'selected' : '' }}>Yes</option>
                                                            <option value="no" {{ old('physiotherapy_home_anticipated', @$order_form->physiotherapy_home_anticipated) == 'no' ? 'selected' : '' }}>No</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Wound card needs anticipated at home </td>
                                                    <td colspan="2">
                                                        <select class="form-control" name="wound_card_anticipated" id="wound_card_anticipated" style="width:180px;">
                                                            <option>---Select---</option>
                                                            <option value="yes" {{ old('wound_card_anticipated', @$order_form->wound_card_anticipated) == 'yes' ? 'selected' : '' }}>Yes</option>
                                                            <option value="no" {{ old('wound_card_anticipated', @$order_form->wound_card_anticipated) == 'no' ? 'selected' : '' }}>No</option>
                                                        </select>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="6"></td>
                                                </tr>
                                                <tr>
                                                    <th colspan="2">Psychological assessment</th>
                                                    <td colspan="2">Psychiatry Referral needed </td>
                                                    <th colspan="2">
                                                        <select class="form-control" name="psychiatry_referral_needed" id="psychiatry_referral_needed" style="width:180px;">
                                                            <option>---Select---</option>
                                                            <option value="yes" {{ old('psychiatry_referral_needed', @$order_form->psychiatry_referral_needed) == 'yes' ? 'selected' : '' }}>Yes</option>
                                                            <option value="no" {{ old('psychiatry_referral_needed', @$order_form->psychiatry_referral_needed) == 'no' ? 'selected' : '' }}>No</option>
                                                        </select>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th colspan="2">Functional</th>
                                                    <td colspan="2">Physiotherapy referral </td>
                                                    <th colspan="2">
                                                        <select class="form-control" name="physiotherapy_referral" id="physiotherapy_referral" style="width:180px;">
                                                            <option>---Select---</option>
                                                            <option value="yes" {{ old('physiotherapy_referral', @$order_form->physiotherapy_referral) == 'yes' ? 'selected' : '' }}>Yes</option>
                                                            <option value="no" {{ old('physiotherapy_referral', @$order_form->physiotherapy_referral) == 'no' ? 'selected' : '' }}>No</option>
                                                        </select>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th colspan="2">Nutritional</th>
                                                    <td colspan="2">Dietary referral </td>
                                                    <th colspan="2">
                                                        <select class="form-control" name="dietary_referral" id="dietary_referral" style="width:180px;">
                                                            <option>---Select---</option>
                                                            <option value="yes" {{ old('dietary_referral', @$order_form->dietary_referral) == 'yes' ? 'selected' : '' }}>Yes</option>
                                                            <option value="no" {{ old('dietary_referral', @$order_form->dietary_referral) == 'no' ? 'selected' : '' }}>No</option>
                                                        </select>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">Expected cost and outcome of treatment has been explained: </td>
                                                    <th colspan="4">
                                                        <select class="form-control" name="expected_cost_outcome" id="expected_cost_outcome" style="width:180px;">
                                                            <option>---Select---</option>
                                                            <option value="yes" {{ old('expected_cost_outcome', @$order_form->expected_cost_outcome) == 'yes' ? 'selected' : '' }}>Yes</option>
                                                            <option value="no" {{ old('expected_cost_outcome', @$order_form->expected_cost_outcome) == 'no' ? 'selected' : '' }}>No</option>
                                                        </select>
                                                    </th>
                                                </tr>

                                                <tr>
                                                    <td colspan="6"></td>
                                                </tr>
                                                <tr>
                                                    <th colspan="6">HISTOTY OF ANY OPERATIONS / ANGIOGRAMS/ ANGIOPLASTY ETC. </th>
                                                </tr>
                                                <tr>
                                                    <th colspan="2">Operations /Hospital </th>
                                                    <th colspan="2">Date (DD /MM /Year) </th>
                                                    <th colspan="2">Details </th>
                                                </tr>
                                                <tr>
                                                    <td colspan="2"><input type="text" name="operations_hospital_one" class="form-control" value="{{ old('operations_hospital_one', $order_form->operations_hospital_one ?? '') }}"></td>
                                                    <td colspan="2"><input type="text" name="angiograms_date_one" class="form-control" value="{{ old('angiograms_date_one', $order_form->angiograms_date_one ?? '') }}"></td>
                                                    <td colspan="2"><input type="text" name="angiograms_details_one" class="form-control" value="{{ old('angiograms_details_one', $order_form->angiograms_details_one ?? '') }}"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2"><input type="text" name="operations_hospital_two" class="form-control" value="{{ old('operations_hospital_two', $order_form->operations_hospital_two ?? '') }}"></td>
                                                    <td colspan="2"><input type="text" name="angiograms_date_two" class="form-control" value="{{ old('angiograms_date_two', $order_form->angiograms_date_two ?? '') }}"></td>
                                                    <td colspan="2"><input type="text" name="angiograms_details_two" class="form-control" value="{{ old('angiograms_details_two', $order_form->angiograms_details_two ?? '') }}"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2"><input type="text" name="operations_hospital_three" class="form-control" value="{{ old('operations_hospital_three', $order_form->operations_hospital_three ?? '') }}"></td>
                                                    <td colspan="2"><input type="text" name="angiograms_date_three" class="form-control" value="{{ old('angiograms_date_three', $order_form->angiograms_date_three ?? '') }}"></td>
                                                    <td colspan="2"><input type="text" name="angiograms_details_three" class="form-control" value="{{ old('angiograms_details_three', $order_form->angiograms_details_three ?? '') }}"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2"><input type="text" name="operations_hospital_four" class="form-control" value="{{ old('operations_hospital_four', $order_form->operations_hospital_four ?? '') }}"></td>
                                                    <td colspan="2"><input type="text" name="angiograms_date_four" class="form-control" value="{{ old('angiograms_date_four', $order_form->angiograms_date_four ?? '') }}"></td>
                                                    <td colspan="2"><input type="text" name="angiograms_details_four" class="form-control" value="{{ old('angiograms_details_four', $order_form->angiograms_details_four ?? '') }}"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2"><input type="text" name="operations_hospital_five" class="form-control" value="{{ old('operations_hospital_five', $order_form->operations_hospital_five ?? '') }}"></td>
                                                    <td colspan="2"><input type="text" name="angiograms_date_five" class="form-control" value="{{ old('angiograms_date_five', $order_form->angiograms_date_five ?? '') }}"></td>
                                                    <td colspan="2"><input type="text" name="angiograms_details_five" class="form-control" value="{{ old('angiograms_details_five', $order_form->angiograms_details_five ?? '') }}"></td>
                                                </tr>

                                                <tr>
                                                    <td colspan="6"></td>
                                                </tr>
                                                <tr>
                                                    <th colspan="6">PHYSICAL EXAMINATION</th>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">
                                                        <b>A-General</b>
                                                        <label><input type="checkbox" name="physical_examination_a" value="NAD" {{ old('physical_examination_a', $order_form->physical_examination_a ?? '') == 'NAD' ? 'checked' : '' }}> NAD</label>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="physical_exam_built[]" value="built" {{ in_array('built', old('physical_exam_built', $order_form->physical_exam_built ?? [])) ? 'checked' : '' }}> Built</label><br>
                                                        <label><input type="checkbox" name="physical_exam_built[]" value="endomorphic" {{ in_array('endomorphic', old('physical_exam_built', $order_form->physical_exam_built ?? [])) ? 'checked' : '' }}> Endomorphic</label><br>
                                                        <label><input type="checkbox" name="physical_exam_built[]" value="mesomorphic" {{ in_array('mesomorphic', old('physical_exam_built', $order_form->physical_exam_built ?? [])) ? 'checked' : '' }}> Mesomorphic</label><br>
                                                        <label><input type="checkbox" name="physical_exam_built[]" value="ectomorphic" {{ in_array('ectomorphic', old('physical_exam_built', $order_form->physical_exam_built ?? [])) ? 'checked' : '' }}> Ectomorphic</label><br>
                                                    </td>

                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="physical_exam_pallor[]" value="pallor" {{ in_array('pallor', old('physical_exam_pallor', $order_form->physical_exam_pallor ?? [])) ? 'checked' : '' }}> Pallor</label><br>
                                                        <label><input type="checkbox" name="physical_exam_pallor[]" value="absent" {{ in_array('absent', old('physical_exam_pallor', $order_form->physical_exam_pallor ?? [])) ? 'checked' : '' }}> Absent</label><br>
                                                        <label><input type="checkbox" name="physical_exam_pallor[]" value="mild" {{ in_array('mild', old('physical_exam_pallor', $order_form->physical_exam_pallor ?? [])) ? 'checked' : '' }}> Mild</label><br>
                                                        <label><input type="checkbox" name="physical_exam_pallor[]" value="moderate" {{ in_array('moderate', old('physical_exam_pallor', $order_form->physical_exam_pallor ?? [])) ? 'checked' : '' }}> Moderate</label><br>
                                                        <label><input type="checkbox" name="physical_exam_pallor[]" value="severe" {{ in_array('severe', old('physical_exam_pallor', $order_form->physical_exam_pallor ?? [])) ? 'checked' : '' }}> Severe</label><br>
                                                    </td>

                                                    <td colspan="2" rowspan="3">
                                                        <label><input type="checkbox" name="physical_exam_pedal_oedema[]" value="pedal_no" {{ in_array('pedal_no', old('physical_exam_pedal_oedema', $order_form->physical_exam_pedal_oedema ?? [])) ? 'checked' : '' }}> Pedal Oedema</label><br>
                                                        <label><input type="checkbox" name="physical_exam_pedal_oedema[]" value="no" {{ in_array('no', old('physical_exam_pedal_oedema', $order_form->physical_exam_pedal_oedema ?? [])) ? 'checked' : '' }}> No</label><br>
                                                        <label><input type="checkbox" name="physical_exam_pedal_oedema[]" value="yes" {{ in_array('yes', old('physical_exam_pedal_oedema', $order_form->physical_exam_pedal_oedema ?? [])) ? 'checked' : '' }}> Yes</label><br>
                                                        <label><input type="checkbox" name="physical_exam_pedal_oedema[]" value="anemia" {{ in_array('anemia', old('physical_exam_pedal_oedema', $order_form->physical_exam_pedal_oedema ?? [])) ? 'checked' : '' }}> Anemia</label><br>
                                                        <label><input type="checkbox" name="physical_exam_pedal_oedema[]" value="height" {{ in_array('height', old('physical_exam_pedal_oedema', $order_form->physical_exam_pedal_oedema ?? [])) ? 'checked' : '' }}> Height</label><br>
                                                        <label><input type="checkbox" name="physical_exam_pedal_oedema[]" value="weight" {{ in_array('weight', old('physical_exam_pedal_oedema', $order_form->physical_exam_pedal_oedema ?? [])) ? 'checked' : '' }}> Weight</label><br>
                                                        <label><input type="checkbox" name="physical_exam_pedal_oedema[]" value="nutrition" {{ in_array('nutrition', old('physical_exam_pedal_oedema', $order_form->physical_exam_pedal_oedema ?? [])) ? 'checked' : '' }}> Nutrition</label><br>
                                                        <label><input type="checkbox" name="physical_exam_pedal_oedema[]" value="dehydration" {{ in_array('dehydration', old('physical_exam_pedal_oedema', $order_form->physical_exam_pedal_oedema ?? [])) ? 'checked' : '' }}> Dehydration</label><br>
                                                        <label><input type="checkbox" name="physical_exam_pedal_oedema[]" value="thyroid" {{ in_array('thyroid', old('physical_exam_pedal_oedema', $order_form->physical_exam_pedal_oedema ?? [])) ? 'checked' : '' }}> Thyroid</label><br>
                                                        <label><input type="checkbox" name="physical_exam_pedal_oedema[]" value="skin" {{ in_array('skin', old('physical_exam_pedal_oedema', $order_form->physical_exam_pedal_oedema ?? [])) ? 'checked' : '' }}> Skin</label><br>
                                                        <label><input type="checkbox" name="physical_exam_pedal_oedema[]" value="others" {{ in_array('others', old('physical_exam_pedal_oedema', $order_form->physical_exam_pedal_oedema ?? [])) ? 'checked' : '' }}> Others</label><br>
                                                        <input type="text" name="physical_exam_pedal_text" value="{{ old('physical_exam_pedal_text', $order_form->physical_exam_pedal_text ?? '') }}" placeholder="If Others"><br>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="physical_exam_cyanosis[]" value="cyanosis_no" {{ in_array('cyanosis_no', old('physical_exam_cyanosis', $order_form->physical_exam_cyanosis ?? [])) ? 'checked' : '' }}> Cyanosis</label><br>
                                                        <label><input type="checkbox" name="physical_exam_cyanosis[]" value="absent" {{ in_array('absent', old('physical_exam_cyanosis', $order_form->physical_exam_cyanosis ?? [])) ? 'checked' : '' }}> Absent</label><br>
                                                        <label><input type="checkbox" name="physical_exam_cyanosis[]" value="central" {{ in_array('central', old('physical_exam_cyanosis', $order_form->physical_exam_cyanosis ?? [])) ? 'checked' : '' }}> Central Cyanosis</label><br>
                                                        <label><input type="checkbox" name="physical_exam_cyanosis[]" value="peripheral" {{ in_array('peripheral', old('physical_exam_cyanosis', $order_form->physical_exam_cyanosis ?? [])) ? 'checked' : '' }}> Peripheral Cyanosis</label><br>
                                                    </td>

                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="physical_exam_clubbing[]" value="clubbing_no" {{ in_array('clubbing_no', old('physical_exam_clubbing', $order_form->physical_exam_clubbing ?? [])) ? 'checked' : '' }}> Clubbing</label><br>
                                                        <label><input type="checkbox" name="physical_exam_clubbing[]" value="absent" {{ in_array('absent', old('physical_exam_clubbing', $order_form->physical_exam_clubbing ?? [])) ? 'checked' : '' }}> Absent</label><br>
                                                        <label><input type="checkbox" name="physical_exam_clubbing[]" value="mild" {{ in_array('mild', old('physical_exam_clubbing', $order_form->physical_exam_clubbing ?? [])) ? 'checked' : '' }}> Mild</label><br>
                                                        <label><input type="checkbox" name="physical_exam_clubbing[]" value="moderate" {{ in_array('moderate', old('physical_exam_clubbing', $order_form->physical_exam_clubbing ?? [])) ? 'checked' : '' }}> Moderate</label><br>
                                                        <label><input type="checkbox" name="physical_exam_clubbing[]" value="severe" {{ in_array('severe', old('physical_exam_clubbing', $order_form->physical_exam_clubbing ?? [])) ? 'checked' : '' }}> Severe</label><br>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="physical_exam_adenopthay[]" value="adenopathy_no" {{ in_array('adenopathy_no', old('physical_exam_adenopthay', $order_form->physical_exam_adenopthay ?? [])) ? 'checked' : '' }}> Lymph Adenopathy</label><br>
                                                        <label><input type="checkbox" name="physical_exam_adenopthay[]" value="axillary" {{ in_array('axillary', old('physical_exam_adenopthay', $order_form->physical_exam_adenopthay ?? [])) ? 'checked' : '' }}> Axillary</label><br>
                                                        <label><input type="checkbox" name="physical_exam_adenopthay[]" value="cervical" {{ in_array('cervical', old('physical_exam_adenopthay', $order_form->physical_exam_adenopthay ?? [])) ? 'checked' : '' }}> Cervical</label><br>
                                                        <label><input type="checkbox" name="physical_exam_adenopthay[]" value="inguinal" {{ in_array('inguinal', old('physical_exam_adenopthay', $order_form->physical_exam_adenopthay ?? [])) ? 'checked' : '' }}> Inguinal</label><br>
                                                    </td>

                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="physical_exam_jvp[]" value="jvp_no" {{ in_array('jvp_no', old('physical_exam_jvp', $order_form->physical_exam_jvp ?? [])) ? 'checked' : '' }}> JVP</label><br>
                                                        <label><input type="checkbox" name="physical_exam_jvp[]" value="not_raised" {{ in_array('not_raised', old('physical_exam_jvp', $order_form->physical_exam_jvp ?? [])) ? 'checked' : '' }}> Not raised</label><br>
                                                        <label><input type="checkbox" name="physical_exam_jvp[]" value="raised" {{ in_array('raised', old('physical_exam_jvp', $order_form->physical_exam_jvp ?? [])) ? 'checked' : '' }}> Raised</label><br>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="6"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">
                                                        <b>B-Peripheral pulses</b>
                                                        <label><input type="checkbox" name="peripheral_pulses_normal" value="No" {{ old('peripheral_pulses_normal', @$order_form->peripheral_pulses_normal) == 'No' ? 'checked' : '' }}> All peripheral pulses normal</label>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="b_peripheral_femoral" value="Femoral" {{ old('b_peripheral_femoral', @$order_form->b_peripheral_femoral) == 'Femoral' ? 'checked' : '' }}> Femoral</label><br>
                                                    </td>
                                                    <td>
                                                        <label>Right </label>
                                                        <input type="text" name="b_peripheral_femoral_right" value="{{ old('b_peripheral_femoral_right', @$order_form->b_peripheral_femoral_right) }}">
                                                    </td>
                                                    <td>
                                                        <label>Left </label>
                                                        <input type="text" name="b_peripheral_femoral_left" value="{{ old('b_peripheral_femoral_left', @$order_form->b_peripheral_femoral_left) }}">
                                                    </td>
                                                    <td colspan="2" rowspan="7">
                                                        1. Normal  <br>
                                                        2. Bounding /Hyperkinetic <br>
                                                        3. Feeble / Hypokinetic <br>
                                                        4. Absent <br>
                                                        5. Bruit present 
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="b_peripheral_popliteal" value="Popliteal" {{ old('b_peripheral_popliteal', @$order_form->b_peripheral_popliteal) == 'Popliteal' ? 'checked' : '' }}> Popliteal</label><br>
                                                    </td>
                                                    <td>
                                                        <label>Right </label> <input type="text" name="b_peripheral_popliteal_right" value="{{ old('b_peripheral_popliteal_right', @$order_form->b_peripheral_popliteal_right) }}">
                                                    </td>
                                                    <td>
                                                        <label>Left </label> <input type="text" name="b_peripheral_popliteal_left" value="{{ old('b_peripheral_popliteal_left', @$order_form->b_peripheral_popliteal_left) }}">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="b_peripheral_posttibial" value="Popliteal" {{ old('b_peripheral_posttibial', @$order_form->b_peripheral_posttibial) == 'Popliteal' ? 'checked' : '' }}> Posttibial</label><br>
                                                    </td>
                                                    <td>
                                                        <label>Right </label> <input type="text" name="b_peripheral_posttibial_right" value="{{ old('b_peripheral_posttibial_right', @$order_form->b_peripheral_posttibial_right) }}">
                                                    </td>
                                                    <td>
                                                        <label>Left </label> <input type="text" name="b_peripheral_posttibial_left" value="{{ old('b_peripheral_posttibial_left', @$order_form->b_peripheral_posttibial_left) }}">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="b_peripheral_dorsalis" value="Popliteal" {{ old('b_peripheral_dorsalis', @$order_form->b_peripheral_dorsalis) == 'Popliteal' ? 'checked' : '' }}> Dorsalis pedis</label><br>
                                                    </td>
                                                    <td>
                                                        <label>Right </label> <input type="text" name="b_peripheral_dorsalis_right" value="{{ old('b_peripheral_dorsalis_right', @$order_form->b_peripheral_dorsalis_right) }}">
                                                    </td>
                                                    <td>
                                                        <label>Left </label> <input type="text" name="b_peripheral_dorsalis_left" value="{{ old('b_peripheral_dorsalis_left', @$order_form->b_peripheral_dorsalis_left) }}">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="b_peripheral_brachial" value="Popliteal" {{ old('b_peripheral_brachial', @$order_form->b_peripheral_brachial) == 'Popliteal' ? 'checked' : '' }}> Brachial</label><br>
                                                    </td>
                                                    <td>
                                                        <label>Right </label> <input type="text" name="b_peripheral_brachial_right" value="{{ old('b_peripheral_brachial_right', @$order_form->b_peripheral_brachial_right) }}">
                                                    </td>
                                                    <td>
                                                        <label>Left </label> <input type="text" name="b_peripheral_brachial_left" value="{{ old('b_peripheral_brachial_left', @$order_form->b_peripheral_brachial_left) }}">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="b_peripheral_radial" value="Popliteal" {{ old('b_peripheral_radial', @$order_form->b_peripheral_radial) == 'Popliteal' ? 'checked' : '' }}> Radial</label><br>
                                                    </td>
                                                    <td>
                                                        <label>Right </label> <input type="text" name="b_peripheral_radial_right" value="{{ old('b_peripheral_radial_right', @$order_form->b_peripheral_radial_right) }}">
                                                    </td>
                                                    <td>
                                                        <label>Left </label> <input type="text" name="b_peripheral_radial_left" value="{{ old('b_peripheral_radial_left', @$order_form->b_peripheral_radial_left) }}">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="b_peripheral_carotid" value="Popliteal" {{ old('b_peripheral_carotid', @$order_form->b_peripheral_carotid) == 'Popliteal' ? 'checked' : '' }}> Carotid</label><br>
                                                    </td>
                                                    <td>
                                                        <label>Right </label> <input type="text" name="b_peripheral_carotid_right" value="{{ old('b_peripheral_carotid_right', @$order_form->b_peripheral_carotid_right) }}">
                                                    </td>
                                                    <td>
                                                        <label>Left </label> <input type="text" name="b_peripheral_carotid_left" value="{{ old('b_peripheral_carotid_left', @$order_form->b_peripheral_carotid_left) }}">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="6"></td>
                                                </tr>
                                                <tr>
                                                    <th colspan="6">Precordial Palpation </th>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">
                                                        <b>C -Apex Beat </b>
                                                        <label><input type="checkbox" name="normal_location_feel" value="No" {{ old('normal_location_feel', @$order_form->normal_location_feel) == 'No' ? 'checked' : '' }}>  Normal Location & feel</label>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="c_apex_beat_left" value="No" {{ old('c_apex_beat_left', @$order_form->c_apex_beat_left) == 'No' ? 'checked' : '' }}> Left sided</label><br>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" name="c_apex_beat_left_text" value="{{ old('c_apex_beat_left_text', @$order_form->c_apex_beat_left_text) }}">
                                                    </td>
                                                    <td colspan="2" rowspan="3">
                                                        1. Medical to mild calvicular line <br>
                                                        2. Leteral to mild calvicular line 
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="c_apex_beat_right" value="No" {{ old('c_apex_beat_right', @$order_form->c_apex_beat_right) == 'No' ? 'checked' : '' }}> Right Sided</label><br>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" name="c_apex_beat_right_text" value="{{ old('c_apex_beat_right_text', @$order_form->c_apex_beat_right_text) }}">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="c_apex_beat_type" value="No" {{ old('c_apex_beat_type', @$order_form->c_apex_beat_type) == 'No' ? 'checked' : '' }}> Type</label><br>
                                                    </td>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="c_apex_beat_select[]" value="Normal" {{ in_array('Normal', old('c_apex_beat_select', @$order_form->c_apex_beat_select ?? [])) ? 'checked' : '' }}> Normal</label><br>
                                                        <label><input type="checkbox" name="c_apex_beat_select[]" value="Tapping" {{ in_array('Tapping', old('c_apex_beat_select', @$order_form->c_apex_beat_select ?? [])) ? 'checked' : '' }}> Tapping</label><br>
                                                        <label><input type="checkbox" name="c_apex_beat_select[]" value="sustained" {{ in_array('sustained', old('c_apex_beat_select', @$order_form->c_apex_beat_select ?? [])) ? 'checked' : '' }}> Well sustained forceful</label><br>
                                                        <label><input type="checkbox" name="c_apex_beat_select[]" value="Hyperdynamic" {{ in_array('Hyperdynamic', old('c_apex_beat_select', @$order_form->c_apex_beat_select ?? [])) ? 'checked' : '' }}> Hyperdynamic</label><br>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="6"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">
                                                        <b> D-Left parasternal lift </b>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">
                                                        <label><input type="checkbox" name="d_left_parasternal[]" value="No" {{ in_array('No', $order_form->d_left_parasternal ?? []) ? 'checked' : '' }}> Absent</label><br>
                                                        <label><input type="checkbox" name="d_left_parasternal[]" value="Opium" {{ in_array('Opium', $order_form->d_left_parasternal ?? []) ? 'checked' : '' }}> Pesent</label><br>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="6"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">
                                                        <b>E-Thrill </b>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="e_thrill_absent" value="Absent" {{ old('e_thrill_absent', @$order_form->e_thrill_absent) == 'Absent' ? 'checked' : '' }}> Absent</label><br>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" name="e_thrill_absent_text" value="{{ old('e_thrill_absent_text', @$order_form->e_thrill_absent_text) }}">
                                                    </td>
                                                    <td colspan="2" rowspan="5">
                                                        1. Systolic <br>
                                                        2. Diastolic  
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="e_thrill_over" value="mitral" {{ old('e_thrill_over', @$order_form->e_thrill_over) == 'mitral' ? 'checked' : '' }}> Over mitral area</label><br>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" name="e_thrill_over_text" value="{{ old('e_thrill_over_text', @$order_form->e_thrill_over_text) }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="e_thrill_tricuspid" value="tricuspid" {{ old('e_thrill_tricuspid', @$order_form->e_thrill_tricuspid) == 'tricuspid' ? 'checked' : '' }}> Over tricuspid area</label><br>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" name="e_thrill_tricuspid_text" value="{{ old('e_thrill_tricuspid_text', @$order_form->e_thrill_tricuspid_text) }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="e_thrill_aortic" value="aortic" {{ old('e_thrill_aortic', @$order_form->e_thrill_aortic) == 'aortic' ? 'checked' : '' }}> Over aortic area</label><br>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" name="e_thrill_aortic_text" value="{{ old('e_thrill_aortic_text', @$order_form->e_thrill_aortic_text) }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <label><input type="checkbox" name="e_thrill_pulmonary" value="pulmonary" {{ old('e_thrill_pulmonary', @$order_form->e_thrill_pulmonary) == 'pulmonary' ? 'checked' : '' }}>  Over pulmonary area</label><br>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" name="e_thrill_pulmonary_text" value="{{ old('e_thrill_pulmonary_text', @$order_form->e_thrill_pulmonary_text) }}">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="6"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">
                                                        <b> F-Palpable </b>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">
                                                        <label><input type="checkbox" name="f_palpable_select[]" value="Absent" {{ in_array('Absent', $order_form->f_palpable_select ?? []) ? 'checked' : '' }}> Absent</label><br>
                                                        <label><input type="checkbox" name="f_palpable_select[]" value="Pesent" {{ in_array('Pesent', $order_form->f_palpable_select ?? []) ? 'checked' : '' }}> Pesent</label><br>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="6"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">
                                                        <b>Precordial auscultation</b>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">
                                                        <b>G-Heart Sounds</b>
                                                        <label>
                                                            <input type="checkbox" name="normal_heart_sounds" value="Normal" {{ old('normal_heart_sounds', @$order_form->normal_heart_sounds) == 'Normal' ? 'checked' : '' }}> Normal heart sounds
                                                        </label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label>
                                                            <input type="checkbox" name="normal_heart_sounds_s1" value="S1" {{ old('normal_heart_sounds_s1', @$order_form->normal_heart_sounds_s1) == 'S1' ? 'checked' : '' }}> S1
                                                        </label><br>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" name="normal_heart_sounds_s1_text" value="{{ old('normal_heart_sounds_s1_text', @$order_form->normal_heart_sounds_s1_text) }}"> <label>1. Normal</label>
                                                    </td>
                                                    <td>
                                                        <label>
                                                            <input type="checkbox" name="normal_heart_sounds_s3" value="S3" {{ old('normal_heart_sounds_s3', @$order_form->normal_heart_sounds_s3) == 'S3' ? 'checked' : '' }}> S3
                                                        </label><br>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="normal_heart_sounds_s3_text" value="{{ old('normal_heart_sounds_s3_text', @$order_form->normal_heart_sounds_s3_text) }}" class="form-control">
                                                    </td>
                                                    <td rowspan="4">
                                                        1. Absent <br>
                                                        2. Audible
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label>
                                                            <input type="checkbox" name="normal_heart_sounds_a2" value="A2" {{ old('normal_heart_sounds_a2', @$order_form->normal_heart_sounds_a2) == 'A2' ? 'checked' : '' }}> A2
                                                        </label><br>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" name="normal_heart_sounds_a2_text" value="{{ old('normal_heart_sounds_a2_text', @$order_form->normal_heart_sounds_a2_text) }}"> <label>2. Loud</label>
                                                    </td>
                                                    <td>
                                                        <label>
                                                            <input type="checkbox" name="normal_heart_sounds_s4" value="S4" {{ old('normal_heart_sounds_s4', @$order_form->normal_heart_sounds_s4) == 'S4' ? 'checked' : '' }}> S4
                                                        </label><br>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="normal_heart_sounds_s4_text" value="{{ old('normal_heart_sounds_s4_text', @$order_form->normal_heart_sounds_s4_text) }}" class="form-control">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label>
                                                            <input type="checkbox" name="normal_heart_sounds_p2" value="P2" {{ old('normal_heart_sounds_p2', @$order_form->normal_heart_sounds_p2) == 'P2' ? 'checked' : '' }}> P2
                                                        </label><br>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" name="normal_heart_sounds_p2_text" value="{{ old('normal_heart_sounds_p2_text', @$order_form->normal_heart_sounds_p2_text) }}"> <label>3. Absent</label>
                                                    </td>
                                                    <td>
                                                        <label>
                                                            <input type="checkbox" name="normal_heart_sounds_snap" value="Snap" {{ old('normal_heart_sounds_snap', @$order_form->normal_heart_sounds_snap) == 'Snap' ? 'checked' : '' }}> Opening snap
                                                        </label><br>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="normal_heart_sounds_snap_text" value="{{ old('normal_heart_sounds_snap_text', @$order_form->normal_heart_sounds_snap_text) }}" class="form-control">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td colspan="2"></td>
                                                    <td>
                                                        <label>
                                                            <input type="checkbox" name="normal_heart_sounds_click" value="Click" {{ old('normal_heart_sounds_click', @$order_form->normal_heart_sounds_click) == 'Click' ? 'checked' : '' }}> Click
                                                        </label><br>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="normal_heart_sounds_click_text" value="{{ old('normal_heart_sounds_click_text', @$order_form->normal_heart_sounds_click_text) }}" class="form-control">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="6"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">
                                                        <b>H-Murmurs</b>
                                                        <label>
                                                            <input type="checkbox" name="h_murmurs" value="No Murmurs" {{ old('h_murmurs', @$order_form->h_murmurs) == 'No Murmurs' ? 'checked' : '' }}> No Murmurs
                                                        </label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label>
                                                            <input type="checkbox" name="h_murmurs_mitral" value="Mitral area" {{ old('h_murmurs_mitral', @$order_form->h_murmurs_mitral) == 'Mitral area' ? 'checked' : '' }}> Mitral area
                                                        </label><br>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="h_murmurs_mitral_text" value="{{ old('h_murmurs_mitral_text', @$order_form->h_murmurs_mitral_text) }}" class="form-control">
                                                    </td>
                                                    <td>
                                                        <label>
                                                            <input type="checkbox" name="h_murmurs_systolic" value="Systolic" {{ old('h_murmurs_systolic', @$order_form->h_murmurs_systolic) == 'Systolic' ? 'checked' : '' }}> 1. Systolic
                                                        </label><br>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="h_murmurs_systolic_text" value="{{ old('h_murmurs_systolic_text', @$order_form->h_murmurs_systolic_text) }}" class="form-control">
                                                    </td>
                                                    <td colspan="2" rowspan="4">
                                                        1. Grade 1 <br>
                                                        2. Grade 2 <br>
                                                        3. Grade 3 <br>
                                                        4. Grade 4
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label>
                                                            <input type="checkbox" name="h_murmurs_aortic" value="Aortic" {{ old('h_murmurs_aortic', @$order_form->h_murmurs_aortic) == 'Aortic' ? 'checked' : '' }}> Aortic
                                                        </label><br>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="h_murmurs_aortic_text" value="{{ old('h_murmurs_aortic_text', @$order_form->h_murmurs_aortic_text) }}" class="form-control">
                                                    </td>
                                                    <td>
                                                        <label>
                                                            <input type="checkbox" name="h_murmurs_diastolic" value="Diastolic" {{ old('h_murmurs_diastolic', @$order_form->h_murmurs_diastolic) == 'Diastolic' ? 'checked' : '' }}> 2. Diastolic
                                                        </label><br>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="h_murmurs_diastolic_text" value="{{ old('h_murmurs_diastolic_text', @$order_form->h_murmurs_diastolic_text) }}" class="form-control">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label>
                                                            <input type="checkbox" name="h_murmurs_pulmonary" value="Pulmonary area" {{ old('h_murmurs_pulmonary', @$order_form->h_murmurs_pulmonary) == 'Pulmonary area' ? 'checked' : '' }}> Pulmonary area
                                                        </label><br>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="h_murmurs_pulmonary_text" value="{{ old('h_murmurs_pulmonary_text', @$order_form->h_murmurs_pulmonary_text) }}" class="form-control">
                                                    </td>
                                                    <td>
                                                        <label>
                                                            <input type="checkbox" name="h_murmurs_contineous" value="Contineous" {{ old('h_murmurs_contineous', @$order_form->h_murmurs_contineous) == 'Contineous' ? 'checked' : '' }}> 3. Contineous
                                                        </label><br>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="h_murmurs_contineous_text" value="{{ old('h_murmurs_contineous_text', @$order_form->h_murmurs_contineous_text) }}" class="form-control">
                                                    </td>
                                                </tr>
                                                
                                                <tr>
                                                    <td colspan="6"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">
                                                        <b>M- Remarks </b> <br>
                                                        <textarea class="form-control" name="m_remarks">{{ old('m_remarks', $order_form->m_remarks ?? '') }}</textarea> <br><br>

                                                        <b>ECHO DOPPLER –</b> <br>
                                                        <div class="d-flex flex-row">
                                                            <div>
                                                                <b>Date: </b>
                                                            </div>
                                                            <div>
                                                                <input type="date" class="form-control" name="echo_doppler_date" value="{{ old('echo_doppler_date', @$order_form->echo_doppler_date ? \Carbon\Carbon::parse($order_form->echo_doppler_date)->format('Y-m-d') : '') }}">
                                                            </div>
                                                        </div>
                                                        <b>Findings
                                                        <textarea class="form-control" name="echo_doppler_text">{{ old('echo_doppler_text', $order_form->echo_doppler_text ?? '') }}</textarea> <br><br>

                                                        <b>TEE</b> <br>
                                                        <div class="d-flex flex-row">
                                                            <div>
                                                                <b>Date: </b>
                                                            </div>
                                                            <div>
                                                                <input type="date" class="form-control" name="tee_date" value="{{ old('tee_date', @$order_form->tee_date ? \Carbon\Carbon::parse($order_form->tee_date)->format('Y-m-d') : '') }}">
                                                            </div>
                                                        </div>
                                                        <b>Findings
                                                        <textarea class="form-control" name="tee_text">{{ old('tee_text', $order_form->tee_text ?? '') }}</textarea> <br><br>

                                                        <b>VASCULAR DOPPLER</b> <br>
                                                        <div class="d-flex flex-row">
                                                            <div>
                                                                <b>Date: </b>
                                                            </div>
                                                            <div>
                                                                <input type="date" class="form-control" name="vascular_doppler_date" value="{{ old('vascular_doppler_date', @$order_form->vascular_doppler_date ? \Carbon\Carbon::parse($order_form->vascular_doppler_date)->format('Y-m-d') : '') }}">
                                                            </div>
                                                        </div>
                                                        <b>Findings
                                                        <textarea class="form-control" name="vascular_doppler_text">{{ old('vascular_doppler_text', $order_form->vascular_doppler_text ?? '') }}</textarea> <br><br>

                                                        <b>STRESS ECHO</b> <br>
                                                        <div class="d-flex flex-row">
                                                            <div>
                                                                <b>Date: </b>
                                                            </div>
                                                            <div>
                                                                <input type="date" class="form-control" name="stress_echo_date" value="{{ old('stress_echo_date', @$order_form->stress_echo_date ? \Carbon\Carbon::parse($order_form->stress_echo_date)->format('Y-m-d') : '') }}">
                                                            </div>
                                                        </div>
                                                        <b>Findings
                                                        <textarea class="form-control" name="stress_echo_text">{{ old('stress_echo_text', $order_form->stress_echo_text ?? '') }}</textarea> <br><br>

                                                        <b>EPS</b> <br>
                                                        <div class="d-flex flex-row">
                                                            <div>
                                                                <b>Date: </b>
                                                            </div>
                                                            <div>
                                                                <input type="date" class="form-control" name="eps_date" value="{{ old('eps_date', @$order_form->eps_date ? \Carbon\Carbon::parse($order_form->eps_date)->format('Y-m-d') : '') }}">
                                                            </div>
                                                        </div>
                                                        <b>Findings
                                                        <textarea class="form-control" name="eps_text">{{ old('eps_text', $order_form->eps_text ?? '') }}</textarea> <br><br>

                                                        <b>CAG / PAG</b> <br>
                                                        <div class="d-flex flex-row">
                                                            <div>
                                                                <b>Date: </b>
                                                            </div>
                                                            <div>
                                                                <input type="date" class="form-control" name="cag_date" value="{{ old('cag_date', @$order_form->cag_date ? \Carbon\Carbon::parse($order_form->cag_date)->format('Y-m-d') : '') }}">
                                                            </div>
                                                        </div>
                                                        <b>Findings
                                                        <textarea class="form-control" name="cag_text">{{ old('cag_text', $order_form->cag_text ?? '') }}</textarea> <br><br>

                                                        <b>CARDIAC CATH</b> <br>
                                                        <div class="d-flex flex-row">
                                                            <div>
                                                                <b>Date: </b>
                                                            </div>
                                                            <div>
                                                                <input type="date" class="form-control" name="cardiac_date" value="{{ old('cardiac_date', @$order_form->cardiac_date ? \Carbon\Carbon::parse($order_form->cardiac_date)->format('Y-m-d') : '') }}">
                                                            </div>
                                                        </div>
                                                        <b>Findings
                                                        <textarea class="form-control" name="cardiac_text">{{ old('cardiac_text', $order_form->cardiac_text ?? '') }}</textarea> <br><br>

                                                        <b>ENDOSCOPY</b> <br>
                                                        <div class="d-flex flex-row">
                                                            <div>
                                                                <b>Date: </b>
                                                            </div>
                                                            <div>
                                                                <input type="date" class="form-control" name="endoscopy_date" value="{{ old('endoscopy_date', @$order_form->endoscopy_date ? \Carbon\Carbon::parse($order_form->endoscopy_date)->format('Y-m-d') : '') }}">
                                                            </div>
                                                        </div>
                                                        <b>Findings
                                                        <textarea class="form-control" name="endoscopy_text">{{ old('endoscopy_text', $order_form->endoscopy_text ?? '') }}</textarea> <br><br>

                                                        <b>ULTRA SOUND</b> <br>
                                                        <div class="d-flex flex-row">
                                                            <div>
                                                                <b>Date: </b>
                                                            </div>
                                                            <div>
                                                                <input type="date" class="form-control" name="ultra_sound_date" value="{{ old('ultra_sound_date', @$order_form->ultra_sound_date ? \Carbon\Carbon::parse($order_form->ultra_sound_date)->format('Y-m-d') : '') }}">
                                                            </div>
                                                        </div>
                                                        <b>Findings
                                                        <textarea class="form-control" name="ultra_sound_text">{{ old('ultra_sound_text', $order_form->ultra_sound_text ?? '') }}</textarea> <br><br>

                                                        <b>CT /MRI </b> <br>
                                                        <div class="d-flex flex-row">
                                                            <div>
                                                                <b>Date: </b>
                                                            </div>
                                                            <div>
                                                                <input type="date" class="form-control" name="mri_date" value="{{ old('mri_date', @$order_form->mri_date ? \Carbon\Carbon::parse($order_form->mri_date)->format('Y-m-d') : '') }}">
                                                            </div>
                                                        </div>
                                                        <b>Findings
                                                        <textarea class="form-control" name="mri_text">{{ old('mri_text', $order_form->mri_text ?? '') }}</textarea> <br><br>

                                                        <b>ANY  OTHER NOTES  (Intervention/procedure/Surgery) </b> <br>
                                                        <textarea class="form-control" name="intervention_text">{{ old('intervention_text', $order_form->intervention_text ?? '') }}</textarea> <br><br>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="6"></td>
                                                </tr>
                                                <tr>
                                                    <th rowspan="2">Doctor</th>
                                                    <th>Signature</th>
                                                    <th>Name</th>
                                                    <th>Emp. ID</th>
                                                    <th>Date</th>
                                                    <th>Time</th>
                                                </tr>
                                                <tr>
                                                    <td><input type="text" name="last_doctor_signature" value="{{ old('last_doctor_signature', @$order_form->last_doctor_signature) }}" class="form-control" ></td>
                                                    <td><input type="text" name="doctor_name_final" id="doctor_name_final" value="{{ old('doctor_name_final', @$order_form->doctor_name_final) }}" class="form-control"></td>
                                                    <input type="hidden" name="h_doctor_name" id="h_doctor_name">
                                                    <td><input type="text" name="doctor_emp" value="{{ old('doctor_emp', @$order_form->doctor_emp) }}" class="form-control"></td>
                                                    <td><input type="date" name="doctor_date" value="{{ old('doctor_date', @$order_form->doctor_date ? \Carbon\Carbon::parse($order_form->doctor_date)->format('Y-m-d') : '') }}" class="form-control"></td>
                                                    <td><input type="time" name="doctor_time" value="{{ old('doctor_time', @$order_form->doctor_time) }}" class="form-control"></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Cousultant</b></td>
                                                    <td><input type="text" name="consultant_signature" value="{{ old('consultant_signature', @$order_form->consultant_signature) }}" class="form-control"></td>
                                                    <td><input type="text" name="consultant_name" value="{{ old('consultant_name', @$order_form->consultant_name) }}" class="form-control"></td>
                                                    <td><input type="text" name="consultant_emp" value="{{ old('consultant_emp', @$order_form->consultant_emp) }}" class="form-control"></td>
                                                    <td><input type="date" name="consultant_date" value="{{ old('consultant_date', @$order_form->consultant_date ? \Carbon\Carbon::parse($order_form->consultant_date)->format('Y-m-d') : '') }}" class="form-control"></td>
                                                    <td><input type="time" name="consultant_time" value="{{ old('consultant_time', @$order_form->consultant_time) }}" class="form-control"></td>
                                                </tr>

                                            </table>
                                        </div>


                                        <div class="text-center">

                                            @php
                                                $redirect_url = route('initial-cardiac-assessment', [
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
    openDoctorAutocomplete('#doctor_name_final', 'h_doctor_name', 'employee_ind', '1');

</script>
