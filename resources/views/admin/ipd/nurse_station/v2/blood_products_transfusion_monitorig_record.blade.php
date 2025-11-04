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
                            <h5 class="mt-2 mb-0">BLOOD PRODUCTS TRANSFUSION & MONITORING RECORD</h5>
                            <small>IPD / Nurse Station / BLOOD PRODUCTS TRANSFUSION & MONITORING RECORD</small>
                        </div>
                        <div class="col-md-2">
                            <a class="btn btn-md btn-warning" target="_blank"
                                href="{{ route('blood-products-transfusion-monitorig-record-pdf', [$patient_info->patient_no_pk, $patient_info->admission_no_pk]) }}">PDF
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
                                    <form action="{{ route('blood-products-transfusion-monitorig-record-store') }}" method="post" id="BLOODTRANSFUSIONFORM">
                                        @csrf
                                        <input type="hidden" name="patient_no_fk" value="{{ $patient_no_fk }}">
                                        <input type="hidden" name="admission_no_fk" value="{{ $admission_id }}">
                                        <input type="hidden" name="blood_p_t_m_r_no_pk" value="{{ @$order_form->blood_p_t_m_r_no_pk }}">

                                        <div class="table-responsive">
                                            <table border="1" width="100%" cellspacing="0" cellpadding="5">
                                                <tr>
                                                    <th colspan="9" style="text-align:center;">BLOOD PRODUCTS TRANSFUSION & MONITORING RECORD</th>
                                                </tr>

                                                <!-- Basic Information -->
                                                <tr>
                                                    <td><b>Blood Group & Rh Type:</b></td>
                                                    <td colspan="2"><input type="text" name="blood_group" class="form-control" value="{{ old('blood_group', @$order_form->blood_group) }}"></td>
                                                    <td><b>No. of Bags:</b></td>
                                                    <td colspan="2"><input type="text" name="bags" class="form-control" value="{{ old('bags', @$order_form->bags) }}"></td>
                                                    <td><b>Time of Issue from the Blood Bank:</b></td>
                                                    <td colspan="2"><input type="datetime-local" name="issue_time" class="form-control" value="{{ old('issue_time', @$order_form->issue_time) }}"></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Blood Product received by:</b></td>
                                                    <td colspan="3"><input type="text" name="received_by" class="form-control" value="{{ old('received_by', @$order_form->received_by) }}"></td>
                                                    <td><b>Time of receiving blood product in Ward/ICU:</b></td>
                                                    <td colspan="4"><input type="datetime-local" name="received_time" class="form-control" value="{{ old('received_time', @$order_form->received_time) }}"></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Blood components transfused:</b></td>
                                                    <td colspan="8">
                                                        @php
                                                            // Convert DB value (string) into array
                                                            $savedComponents = old('components', @$order_form->components ? explode(',', $order_form->components) : []);
                                                        @endphp

                                                        <select class="form-control" name="components[]" id="components" multiple style="padding: 50px !important;">
                                                            <option value="Whole Blood" {{ in_array('Whole Blood', $savedComponents) ? 'selected' : '' }}>Whole Blood</option>
                                                            <option value="RDP" {{ in_array('RDP', $savedComponents) ? 'selected' : '' }}>RDP</option>
                                                            <option value="SDP" {{ in_array('SDP', $savedComponents) ? 'selected' : '' }}>SDP</option>
                                                            <option value="PLT" {{ in_array('PLT', $savedComponents) ? 'selected' : '' }}>PLT</option>
                                                            <option value="FFP" {{ in_array('FFP', $savedComponents) ? 'selected' : '' }}>FFP</option>
                                                            <option value="Cyro" {{ in_array('Cyro', $savedComponents) ? 'selected' : '' }}>Cyro</option>
                                                            <option value="PRBC/RRC" {{ in_array('PRBC/RRC', $savedComponents) ? 'selected' : '' }}>PRBC/RRC</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><b>Bag No:</b></td>
                                                    <td><input type="text" name="bag_no" class="form-control" value="{{ old('bag_no', @$order_form->bag_no) }}"></td>
                                                    <td><b>Amount (ml):</b></td>
                                                    <td><input type="text" name="amount" class="form-control" value="{{ old('amount', @$order_form->amount) }}"></td>
                                                    <td><b>DOC:</b></td>
                                                    <td><input type="text" name="doc" class="form-control" value="{{ old('doc', @$order_form->doc) }}"></td>
                                                    <td><b>DOE:</b></td>
                                                    <td colspan="2"><input type="text" name="doe" class="form-control" value="{{ old('doe', @$order_form->doe) }}"></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Consent Obtained:</b></td>
                                                    <td colspan="2">
                                                        <select class="form-control" name="consent" id="consent">
                                                            <option value="Yes" {{ old('consent', @$order_form->consent) == 'Yes' ? 'selected' : '' }}>Yes</option>
                                                            <option value="No" {{ old('consent', @$order_form->consent) == 'No' ? 'selected' : '' }}>No</option>
                                                        </select>
                                                    </td>
                                                    <td><b>Pre-medication given:</b></td>
                                                    <td colspan="2">
                                                        <select class="form-control" name="premedication" id="premedication">
                                                            <option value="Yes" {{ old('premedication', @$order_form->premedication) == 'Yes' ? 'selected' : '' }}>Yes</option>
                                                            <option value="No" {{ old('premedication', @$order_form->premedication) == 'No' ? 'selected' : '' }}>No</option>
                                                        </select>
                                                    </td>
                                                    <td><b>IV Patient:</b></td>
                                                    <td colspan="2">
                                                        <select class="form-control" name="iv_patient" id="iv_patient">
                                                            <option value="Yes" {{ old('iv_patient', @$order_form->iv_patient) == 'Yes' ? 'selected' : '' }}>Yes</option>
                                                            <option value="No" {{ old('iv_patient', @$order_form->iv_patient) == 'No' ? 'selected' : '' }}>No</option>
                                                        </select>
                                                    </td>
                                                    <td colspan="3"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2"><b>Transfusion Starting Time:</b></td>
                                                    <td colspan="7"><input type="datetime-local" name="transfusion_start" class="form-control" value="{{ old('transfusion_start', @$order_form->transfusion_start) }}"></td>
                                                </tr>

                                                <!-- Vital Signs Table -->
                                                <tr>
                                                    <th colspan="8" style="text-align:center;">VITAL SIGNS DURING TRANSFUSION</th>
                                                </tr>
                                                <tr>
                                                    <th>Frequency of Monitoring</th>
                                                    <th>Time</th>
                                                    <th>Temp (°F)</th>
                                                    <th>Pulse (bts/min)</th>
                                                    <th>RP (bts/min)</th>
                                                    <th>BP (mmHg)</th>
                                                    <th>Drops per min</th>
                                                    <th>Sign</th>
                                                    <th>Remarks</th>
                                                </tr>
                                                @php
                                                $intervals = ['Starting Time','15 Min','30 Min','45 Min','60 Min','Followed by every 30 mins','Followed by every 30 mins','Followed by every 30 mins','Followed by every 30 mins','Followed by every 30 mins','Followed by every 30 mins','Followed by every 30 mins'];
                                                @endphp

                                                @foreach($intervals as $index => $int)
                                                <tr>
                                                    <td>{{ $int }}</td>
                                                    <td>
                                                        <input type="datetime-local" name="time[{{ $index }}]" class="form-control"
                                                            value="{{ old('time.'.$index, isset($vitals[$index]['time']) ? date('Y-m-d\TH:i', strtotime($vitals[$index]['time'])) : '') }}">
                                                    </td>
                                                    <td><input type="text" name="temp[{{ $index }}]" class="form-control" value="{{ old('temp.'.$index, $vitals[$index]['temp'] ?? '') }}"></td>
                                                    <td><input type="text" name="pulse[{{ $index }}]" class="form-control" value="{{ old('pulse.'.$index, $vitals[$index]['pulse'] ?? '') }}"></td>
                                                    <td><input type="text" name="resp[{{ $index }}]" class="form-control" value="{{ old('resp.'.$index, $vitals[$index]['resp'] ?? '') }}"></td>
                                                    <td><input type="text" name="bp[{{ $index }}]" class="form-control" value="{{ old('bp.'.$index, $vitals[$index]['bp'] ?? '') }}"></td>
                                                    <td><input type="text" name="drops[{{ $index }}]" class="form-control" value="{{ old('drops.'.$index, $vitals[$index]['drops'] ?? '') }}"></td>
                                                    <td><input type="text" name="sign[{{ $index }}]" class="form-control" value="{{ old('sign.'.$index, $vitals[$index]['sign'] ?? '') }}"></td>
                                                    <td><input type="text" name="remarks[{{ $index }}]" class="form-control" value="{{ old('remarks.'.$index, $vitals[$index]['remarks'] ?? '') }}"></td>
                                                </tr>
                                                @endforeach

                                                <!-- End Time -->
                                                <tr>
                                                    <td><b>End time of Transfusion:</b></td>
                                                    <td colspan="8"><input type="datetime-local" name="transfusion_end" class="form-control" value="{{ old('transfusion_end', @$order_form->transfusion_end) }}"></td>
                                                </tr>

                                                <!-- Reaction -->
                                                <tr>
                                                    <td><b>Transfusion Reaction:</b></td>
                                                    <td colspan="8">
                                                        <!-- Yes/No -->
                                                        <select class="form-control" name="reaction" id="reaction">
                                                            <option value="">-- Select --</option>
                                                            <option value="Yes" {{ old('reaction', @$order_form->reaction) == 'Yes' ? 'selected' : '' }}>Yes</option>
                                                            <option value="No" {{ old('reaction', @$order_form->reaction) == 'No' ? 'selected' : '' }}>No</option>
                                                        </select>

                                                        <!-- Symptoms (hidden by default) -->
                                                        @php
                                                            $savedSymptoms = old('reaction_symptoms', @$order_form->reaction_symptoms ? explode(',', $order_form->reaction_symptoms) : []);
                                                        @endphp

                                                        <select class="form-control mb-2" name="reaction_symptoms[]" id="reaction_symptoms" multiple style="padding: 50px !important; {{ old('reaction', @$order_form->reaction) == 'Yes' ? '' : 'display:none;' }}">
                                                            <option value="Fever" {{ in_array('Fever', $savedSymptoms) ? 'selected' : '' }}>Fever</option>
                                                            <option value="Chills" {{ in_array('Chills', $savedSymptoms) ? 'selected' : '' }}>Chills</option>
                                                            <option value="Flank Pain" {{ in_array('Flank Pain', $savedSymptoms) ? 'selected' : '' }}>Flank Pain</option>
                                                            <option value="Haemoglobuinuria" {{ in_array('Haemoglobuinuria', $savedSymptoms) ? 'selected' : '' }}>Haemoglobuinuria</option>
                                                            <option value="Hypotension" {{ in_array('Hypotension', $savedSymptoms) ? 'selected' : '' }}>Hypotension</option>
                                                            <option value="Urticaria" {{ in_array('Urticaria', $savedSymptoms) ? 'selected' : '' }}>Urticaria</option>
                                                            <option value="Dyspnoea" {{ in_array('Dyspnoea', $savedSymptoms) ? 'selected' : '' }}>Dyspnoea</option>
                                                            <option value="Chest Tightness" {{ in_array('Chest Tightness', $savedSymptoms) ? 'selected' : '' }}>Chest Tightness</option>
                                                            <option value="Desaturation" {{ in_array('Desaturation', $savedSymptoms) ? 'selected' : '' }}>Desaturation</option>
                                                            <option value="Vomiting" {{ in_array('Vomiting', $savedSymptoms) ? 'selected' : '' }}>Vomiting</option>
                                                            <option value="Others" {{ in_array('Others', $savedSymptoms) ? 'selected' : '' }}>Others</option>
                                                        </select>

                                                        <!-- Input for "Others" -->
                                                        <input type="text" name="reaction_symptom_other" id="reaction_symptom_other" 
                                                            class="form-control" placeholder="Please specify" style="display:none;">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td><b>Transfusion Reaction form completed and sent to Blood Bank?</b></td>
                                                    <td colspan="8">
                                                        <select class="form-control" name="reaction_form" id="reaction_form">
                                                            <option value="">-- Select --</option>
                                                            <option value="Yes" {{ old('reaction_form', @$order_form->reaction_form) == 'Yes' ? 'selected' : '' }}>Yes</option>
                                                            <option value="No" {{ old('reaction_form', @$order_form->reaction_form) == 'No' ? 'selected' : '' }}>No</option>
                                                        </select>

                                                        <!-- Hidden by default -->
                                                        <input type="text" name="reaction_form_text" id="reaction_form_text"
                                                            class="form-control" placeholder="Additional details" 
                                                            value="{{ old('reaction_form_text', @$order_form->reaction_form_text) }}" 
                                                            style="display:none;">
                                                    </td>
                                                </tr>

                                                <!-- Blood & Blood Products Summary -->
                                                <tr>
                                                    <th colspan="3">Blood & Blood Products</th>
                                                    <th colspan="3">Time to Start Transfusion</th>
                                                    <th colspan="3">Time to End Transfusion</th>
                                                </tr>
                                                <tr>
                                                    <td colspan="3">Whole Blood</td>
                                                    <td colspan="3">Within 30 mins of issue from Blood Bank</td>
                                                    <td colspan="3">Within 4 hrs of starting transfusion</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3">PRBC/RBC</td>
                                                    <td colspan="3">Within 30 mins of issue from Blood Bank</td>
                                                    <td colspan="3">Within 4 hrs of starting transfusion</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3">Platelet Concentrate</td>
                                                    <td colspan="3">Time to Start Infusion</td>
                                                    <td colspan="3">Within 20–30 mins of starting transfusion</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3">FFP & Cryo</td>
                                                    <td colspan="3">Time to Start Infusion</td>
                                                    <td colspan="3">Within 20–30 mins of starting transfusion</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3">Platelet Apheresis</td>
                                                    <td colspan="3">Time to Start Infusion</td>
                                                    <td colspan="3">Within 20–30 mins of starting transfusion</td>
                                                </tr>
                                            </table>
                                        </div>

                                        <!-- Signatures -->
                                        <table border="1" width="100%" cellspacing="0" cellpadding="5">
                                            <tr>
                                                <th rowspan="2">Assigned Nurse</th>
                                                <th>Signature</th>
                                                <th>Name</th>
                                                <th>Emp. ID</th>
                                                <th>Date</th>
                                                <th>Time</th>
                                            </tr>
                                            <tr>
                                                <td><input type="text" name="nurse_signature" class="form-control" value="{{ old('nurse_signature', @$order_form->nurse_signature) }}"></td>
                                                <td><input type="text" name="nurse_name" class="form-control" id="nurse_name" value="{{ old('nurse_name', @$order_form->nurse_name) }}">
                                                <td><input type="text" name="nurse_emp_id" class="form-control" value="{{ old('nurse_emp_id', @$order_form->nurse_emp_id) }}"></td>
                                                <td><input type="date" name="nurse_date" class="form-control" value="{{ old('nurse_date', @$order_form->nurse_date ? \Carbon\Carbon::parse($order_form->nurse_date)->format('Y-m-d') : '') }}"></td>
                                                <td><input type="time" name="nurse_time" class="form-control" value="{{ old('nurse_time', @$order_form->nurse_time) }}"></td>
                                            </tr>
                                            <tr>
                                                <th>Unit Supervisor</th>
                                                <td><input type="text" name="supervisor_signature" class="form-control" value="{{ old('supervisor_signature', @$order_form->supervisor_signature) }}"></td>
                                                <td><input type="text" name="supervisor_name" class="form-control" id="supervisor_name" value="{{ old('supervisor_name', @$order_form->supervisor_name) }}">
                                                <td><input type="text" name="supervisor_emp_id" class="form-control" value="{{ old('supervisor_emp_id', @$order_form->supervisor_emp_id) }}"></td>
                                                <td><input type="date" name="supervisor_date" class="form-control" value="{{ old('supervisor_date', @$order_form->supervisor_date ? \Carbon\Carbon::parse($order_form->supervisor_date)->format('Y-m-d') : '') }}"></td>
                                                <td><input type="time" name="supervisor_time" class="form-control" value="{{ old('supervisor_time', @$order_form->supervisor_time) }}"></td>
                                            </tr>
                                            <tr>
                                            <td colspan="6">
                                                <p>
                                                    NOTE: If any delay in transfusion or unused blood, products should be returned to the blood bank within 30 min. of issue from the blood bank. For every single blood product transfusion, this form needs to be filled separately.
                                                </p>
                                            </td>
                                        </tr>
                                        </table>

                                        <div class="text-center mt-3">
                                            @php
                                                $redirect_url = route('blood-products-transfusion-monitorig-record', [
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
    openDoctorAutocomplete('#doctor_name', 'h_doctor_name', 'employee_ind', '1');

</script>


<script>
    function toggleField(divId, show) {
        document.getElementById(divId).style.display = show ? 'block' : 'none';
    }
</script>

<script>
    // Reaction Yes/No
    document.getElementById('reaction').addEventListener('change', function () {
        let symptomsSelect = document.getElementById('reaction_symptoms');
        let otherInput = document.getElementById('reaction_symptom_other');

        if (this.value === "Yes") {
            symptomsSelect.style.display = 'block';
        } else {
            symptomsSelect.style.display = 'none';
            otherInput.style.display = 'none';
        }
    });

    // Show "Others" input only if "Others" is selected
    document.getElementById('reaction_symptoms').addEventListener('change', function () {
        let otherInput = document.getElementById('reaction_symptom_other');
        let selectedValues = Array.from(this.selectedOptions).map(opt => opt.value);

        if (selectedValues.includes("Others")) {
            otherInput.style.display = 'block';
        } else {
            otherInput.style.display = 'none';
        }
    });

    // Reaction form Yes/No
    document.getElementById('reaction_form').addEventListener('change', function () {
        let formTextInput = document.getElementById('reaction_form_text');

        if (this.value === "Yes") {
            formTextInput.style.display = 'block';
        } else {
            formTextInput.style.display = 'none';
        }
    });
</script>