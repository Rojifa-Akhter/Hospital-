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

    textarea {
        width: 100%;
        height: 100%;
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
                            <h5 class="mt-2 mb-0">Patient Discharge Diet Chart</h5>
                            <small>IPD / Nurse Station /Patient Discharge Diet Chart</small>
                        </div>
                        <div class="col-md-2">
                            <a class="btn btn-md btn-warning" target="_blank"
                                href="{{ route('ipd.patient-discharge-diet-chart-form-print', [$patient_info->patient_no_pk, $patient_info->admission_no_pk]) }}">PDF
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
                                    <form action="{{ route('ipd.store-patient-discharge-diet-chart-form') }}"
                                        method="post" id="PATIENT_CLINICAL_RECORDS">
                                        @csrf
                                        <input type="hidden" name="patient_no_fk" id="patient_no_fk"
                                            value="{{ $patient_no_fk }}">
                                        <input type="hidden" name="admission_no_fk" id="admission_no_fk"
                                            value="{{ $admission_id }}">
                                        <input type="hidden" name="patient_ddc_no_pk"
                                            value="{{ isset($ptddc->patient_ddc_no_pk) ? $ptddc->patient_ddc_no_pk : '' }}">




                                        <h5 class="fw-bold text-decoration-underline"><u>Nutritional Assessment
                                                Summary</u></h5>
                                        <table class="table table-bordered align-middle">
                                            <thead class="table-light text-center">
                                                <tr>
                                                    <th>Parameter</th>
                                                    <th>Details</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Weight (kg)</td>
                                                    <td>
                                                        <input type="number" step="0.1" name="weight"
                                                            id="weight" value="{{ @$ptddc->weight }}"
                                                            class="form-control form-control-sm">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Height (cm)</td>
                                                    <td>
                                                        <input type="number" step="0.1" name="height"
                                                            id="height" value="{{ @$ptddc->height }}"
                                                            class="form-control form-control-sm">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>BMI</td>
                                                    <td>
                                                        <input type="text" name="bmi" id="bmi"
                                                            value="{{ @$ptddc->bmi }}"
                                                            class="form-control form-control-sm" readonly>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Dietary Restrictions / Allergies</td>
                                                    <td><input type="text" name="d_restrictions"
                                                            value="{{ @$ptddc->d_restrictions }}"
                                                            class="form-control form-control-sm"></td>
                                                </tr>
                                                <tr>
                                                    <td>Nutrition Risk Score (if applicable)</td>
                                                    <td><input type="text" name="nr_score"
                                                            value="{{ @$ptddc->nr_score }}"
                                                            class="form-control form-control-sm"></td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <!-- Discharge Diet Plan -->
                                        <h5 class="fw-bold text-decoration-underline mt-4"><u>Discharge Diet
                                                Plan</u>
                                        </h5>
                                        <table class="table table-bordered align-middle">
                                            <thead class="table-light text-center">
                                                <tr>
                                                    <th>Meal Time</th>
                                                    <th>Recommended Food / Quantity</th>
                                                    <th>Avoid / Restrict</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $meals = [
                                                        'early_morning' => 'Early Morning',
                                                        'breakfast' => 'Breakfast',
                                                        'mid_morning' => 'Mid-Morning',
                                                        'lunch' => 'Lunch',
                                                        'evening_snack' => 'Evening Snack',
                                                        'dinner' => 'Dinner',
                                                        'bedtime' => 'Bedtime',
                                                    ];
                                                @endphp

                                                @foreach ($meals as $key => $label)
                                                    <tr>
                                                        <td style="text-align: left">{{ $label }}</td>
                                                        <td><input type="text"
                                                                name="recommended_{{ $key }}"
                                                                value="{{ @$ptddc->{'recommended_' . $key} }}"
                                                                class="form-control form-control-sm"></td>
                                                        <td><input type="text" name="avoid_{{ $key }}"
                                                                value="{{ @$ptddc->{'avoid_' . $key} }}"
                                                                class="form-control form-control-sm"></td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>

                                        <!-- Special Instructions -->
                                        <h5 class="fw-bold text-decoration-underline mt-4"><u>Special
                                                Instructions</u>
                                        </h5>
                                        <div class="ms-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="diabetic_diet"
                                                    value="1" {{ @$ptddc->diabetic_diet ? 'checked' : '' }}>
                                                <label class="form-check-label">Diabetic Diet</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="renal_diet"
                                                    value="1" {{ @$ptddc->renal_diet ? 'checked' : '' }}>
                                                <label class="form-check-label">Renal Diet</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="low_salt"
                                                    value="1" {{ @$ptddc->low_salt ? 'checked' : '' }}>
                                                <label class="form-check-label">Low Salt / Cardiac Diet</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="high_protein"
                                                    value="1" {{ @$ptddc->high_protein ? 'checked' : '' }}>
                                                <label class="form-check-label">High Protein Diet</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="soft_liquid"
                                                    value="1" {{ @$ptddc->soft_liquid ? 'checked' : '' }}>
                                                <label class="form-check-label">Soft / Liquid Diet</label>
                                            </div>
                                            <div class="form-check d-flex align-items-center">
                                                <input class="form-check-input me-2" type="checkbox"
                                                    name="other_diet" value="1"
                                                    {{ @$ptddc->other_diet ? 'checked' : '' }}>
                                                <label class="form-check-label me-2">Other (Specify):</label>
                                                <input type="text" name="other_diet_txt"
                                                    value="{{ @$ptddc->other_diet_txt }}"
                                                    class="form-control form-control-sm w-50">
                                            </div>
                                        </div>



                                        <!-- Notes / Instructions for Home -->
                                        <h5 class="fw-bold text-decoration-underline"><u>Notes / Instructions
                                                for
                                                Home:</u></h5>
                                        <div class="ms-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="drink_water"
                                                    value="1" {{ @$ptddc->drink_water ? 'checked' : '' }}>
                                                <label class="form-check-label">Drink adequate water unless
                                                    restricted.</label>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="af_food"
                                                    value="1" {{ @$ptddc->af_food ? 'checked' : '' }}>
                                                <label class="form-check-label">Avoid fried or spicy food
                                                    unless advised.</label>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="fp_control"
                                                    value="1" {{ @$ptddc->fp_control ? 'checked' : '' }}>
                                                <label class="form-check-label">Follow portion control as
                                                    demonstrated.</label>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="mm_timing"
                                                    value="1" {{ @$ptddc->mm_timing ? 'checked' : '' }}>
                                                <label class="form-check-label">Maintain regular meal
                                                    timing.</label>
                                            </div>

                                            <div class="form-check d-flex align-items-center">
                                                <input class="form-check-input me-2" type="checkbox"
                                                    name="c_supplements" value="1"
                                                    {{ @$ptddc->c_supplements ? 'checked' : '' }}>
                                                <label class="form-check-label me-2">Continue nutritional
                                                    supplements (if prescribed):</label>
                                                <input type="text" name="sup_text"
                                                    value="{{ @$ptddc->sup_text }}"
                                                    class="form-control form-control-sm w-50">
                                            </div>
                                        </div>

                                        <!-- Patient / Attendant Education -->
                                        <h5 class="fw-bold text-decoration-underline mt-4"><u>Patient /
                                                Attendant
                                                Education</u></h5>
                                        <table class="table table-bordered align-middle">
                                            <thead class="table-light text-center">
                                                <tr>
                                                    <th>Education Provided On</th>
                                                    <th>Yes / No</th>
                                                    <th>Remarks</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td style="text-align: left">Diet Plan Explained</td>
                                                    <td>
                                                        <select name="dp_explained"
                                                            class="form-select form-select-sm">
                                                            <option value="">Select</option>
                                                            <option value="Yes"
                                                                {{ @$ptddc->dp_explained == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option value="No"
                                                                {{ @$ptddc->dp_explained == 'No' ? 'selected' : '' }}>
                                                                No</option>
                                                        </select>
                                                    </td>
                                                    <td><input type="text" name="dpe_remarks"
                                                            value="{{ @$ptddc->dpe_remarks }}"
                                                            class="form-control form-control-sm"></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: left">Food Portion Demonstrated</td>
                                                    <td>
                                                        <select name="fp_demo" class="form-select form-select-sm">
                                                            <option value="">Select</option>
                                                            <option value="Yes"
                                                                {{ @$ptddc->fp_demo == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option value="No"
                                                                {{ @$ptddc->fp_demo == 'No' ? 'selected' : '' }}>
                                                                No</option>
                                                        </select>
                                                    </td>
                                                    <td><input type="text" name="fpd_remarks"
                                                            value="{{ @$ptddc->fpd_remarks }}"
                                                            class="form-control form-control-sm"></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: left">Follow-up Appointment Informed
                                                    </td>
                                                    <td>
                                                        <select name="followup_informed"
                                                            class="form-select form-select-sm">
                                                            <option value="">Select</option>
                                                            <option value="Yes"
                                                                {{ @$ptddc->followup_informed == 'Yes' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option value="No"
                                                                {{ @$ptddc->followup_informed == 'No' ? 'selected' : '' }}>
                                                                No</option>
                                                        </select>
                                                    </td>
                                                    <td><input type="text" name="fi_remarks"
                                                            value="{{ @$ptddc->fi_remarks }}"
                                                            class="form-control form-control-sm"></td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <!-- Acknowledgment -->
                                        <h5 class="fw-bold text-decoration-underline mt-4">
                                            <u>Acknowledgment</u>
                                        </h5>
                                        <p>I have received and understood the diet plan explained to me by the
                                            hospital dietician.</p>
                                        <table class="table table-bordered text-center align-middle">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Name & Signature of Patient / Attendant</th>
                                                    <th>Signature of Dietician</th>
                                                    <th>Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><input type="text" name="patient_signature"
                                                            id="patient_signature"
                                                            value="{{ @$ptddc->patient_signature }}"
                                                            class="form-control form-control-sm"></td>
                                                    <input type="hidden" name="hpatient_signature" value="">
                                                    </td>
                                                    <td><input type="text" name="dietician_signature"
                                                            value="{{ @$ptddc->dietician_signature }}"
                                                            class="form-control form-control-sm"></td>
                                                    <td><input type="date" name="ack_date"
                                                            value="{{ @$ptddc->ack_date }}"
                                                            class="form-control form-control-sm"></td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <!-- Follow-up Advice -->
                                        <h5 class="fw-bold text-decoration-underline mt-4"><u>Follow-up
                                                Advice</u>
                                        </h5>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label class="fw-semibold">Next Review Date:</label>
                                                <input type="date" name="next_review_date"
                                                    value="{{ @$ptddc->next_review_date }}"
                                                    class="form-control form-control-sm">
                                            </div>
                                        </div>















                                        <div class="text-center">

                                            @php
                                                $redirect_url = route('ipd.patient-discharge-diet-chart-form', [
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
    openDoctorAutocomplete('#patient_signature', 'hpatient_signature', 'employee_ind', '1');

    function calculateBMI() {
        const weight = parseFloat(document.getElementById('weight').value);
        const heightCm = parseFloat(document.getElementById('height').value);
        const bmiField = document.getElementById('bmi');

        if (weight > 0 && heightCm > 0) {
            const heightM = heightCm / 100;
            const bmi = weight / (heightM * heightM);
            bmiField.value = bmi.toFixed(2);
        } else {
            bmiField.value = '';
        }
    }

    document.getElementById('weight').addEventListener('input', calculateBMI);
    document.getElementById('height').addEventListener('input', calculateBMI);
</script>
