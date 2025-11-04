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
                            <h5 class="mt-2 mb-0">Blood Transfusion Reaction Form</h5>
                            <small>IPD / Nurse Station / Blood Transfusion Reaction Form</small>
                        </div>
                        <div class="col-md-2">
                            <a class="btn btn-md btn-warning" target="_blank"
                                href="{{ route('blood-transfusion-reaction-form-pdf', [$patient_info->patient_no_pk, $patient_info->admission_no_pk]) }}">PDF
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
                                    <form action="{{ route('blood-transfusion-reaction-form-store') }}" method="post" id="BLOODTRANSFUSIONFORM">
                                        @csrf
                                        <input type="hidden" name="patient_no_fk" value="{{ $patient_no_fk }}">
                                        <input type="hidden" name="admission_no_fk" value="{{ $admission_id }}">
                                        <input type="hidden" name="blood_transfusion_no_pk" value="{{ isset($reaction_form->blood_transfusion_no_pk) ? $reaction_form->blood_transfusion_no_pk : '' }}">

                                        <div class="table-responsive">
                                            <table border="1" width="100%" cellspacing="0" cellpadding="5">
                                                <tr>
                                                    <th colspan="4" style="text-align:center;">BLOOD TRANSFUSION REACTION FORM</th>
                                                </tr>

                                                <!-- Patient / Recipient Information -->
                                                <tr>
                                                    <td colspan="2">
                                                        <b>Patient/Recipient Information:</b><br>
                                                        <b>Blood Grouping & Rh type:</b>
                                                        <input type="text" name="blood_group" class="form-control" value="{{ old('blood_group', @$reaction_form->blood_group) }}"><br>
                                                        <b>Primary Diagnosis:</b>
                                                        <input type="text" name="primary_diagnosis" class="form-control" value="{{ old('primary_diagnosis', @$reaction_form->primary_diagnosis) }}"><br>
                                                        <b>Indication for Transfusion:</b>
                                                        <input type="text" name="indication" class="form-control" value="{{ old('indication', @$reaction_form->indication) }}"><br>
                                                        <b>Relevant co-morbidities:</b>
                                                        <input type="text" name="comorbidities" class="form-control" value="{{ old('comorbidities', @$reaction_form->comorbidities) }}"><br>
                                                        <b>Relevant Medications:</b>
                                                        <input type="text" name="medications" class="form-control" value="{{ old('medications', @$reaction_form->medications) }}">
                                                    </td>
                                                    <td colspan="2">
                                                        <b>Previous H/O Transfusion:</b>
                                                        <label><input type="radio" name="prev_transfusion" value="Yes" {{ @$reaction_form->prev_transfusion == 'Yes' ? 'checked' : '' }} onclick="toggleField('prev_transfusion_detail_div', true)"> Yes</label>
                                                        <label><input type="radio" name="prev_transfusion" value="No" {{ @$reaction_form->prev_transfusion == 'No' ? 'checked' : '' }} onclick="toggleField('prev_transfusion_detail_div', false)"> No</label><br>
                                                        
                                                        <div id="prev_transfusion_detail_div" style="display: {{ @$reaction_form->prev_transfusion == 'Yes' ? 'block' : 'none' }};">
                                                            <b>Number of transfusion:</b>
                                                            <input type="text" name="prev_transfusion_detail" class="form-control" value="{{ old('prev_transfusion_detail', @$reaction_form->prev_transfusion_detail) }}">
                                                            <b>Date of last transfusion:</b>
                                                            <input type="datetime-local" name="prev_transfusion_datetime" class="form-control" value="{{ old('prev_transfusion_datetime', @$reaction_form->prev_transfusion_datetime) }}">

                                                        </div>

                                                        <b>Previous H/O Transfusion Reaction:</b>
                                                        <label><input type="radio" name="prev_reaction" value="Yes" {{ @$reaction_form->prev_reaction == 'Yes' ? 'checked' : '' }} onclick="toggleField('prev_reaction_detail_div', true)"> Yes</label>
                                                        <label><input type="radio" name="prev_reaction" value="No" {{ @$reaction_form->prev_reaction == 'No' ? 'checked' : '' }} onclick="toggleField('prev_reaction_detail_div', false)"> No</label><br>
                                                        
                                                        <div id="prev_reaction_detail_div" style="display: {{ @$reaction_form->prev_reaction == 'Yes' ? 'block' : 'none' }};">
                                                            <b>Date & Type of Reaction:</b>
                                                            <input type="datetime-local" name="prev_reaction_datetime" class="form-control" value="{{ old('prev_reaction_datetime', @$reaction_form->prev_reaction_datetime) }}"><br>
                                                        </div>

                                                        <b>Pre-medication given:</b>
                                                        <label><input type="radio" name="pre_medication" value="Yes" {{ @$reaction_form->pre_medication == 'Yes' ? 'checked' : '' }} onclick="toggleField('pre_medication_div', true)"> Yes</label>
                                                        <label><input type="radio" name="pre_medication" value="No" {{ @$reaction_form->pre_medication == 'No' ? 'checked' : '' }} onclick="toggleField('pre_medication_div', false)"> No</label><br>

                                                        <div id="pre_medication_div" style="display: {{ @$reaction_form->pre_medication == 'Yes' ? 'block' : 'none' }};">
                                                            <b>If yes, specify Drug, Dose and Route:</b>
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <input type="text" name="pre_medication_drug" placeholder="Drug" class="form-control" value="{{ old('pre_medication_drug', @$reaction_form->pre_medication_drug) }}">
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <input type="text" name="pre_medication_dose" placeholder="Dose" class="form-control" value="{{ old('pre_medication_dose', @$reaction_form->pre_medication_dose) }}">
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <input type="text" name="pre_medication_route" placeholder="Route" class="form-control" value="{{ old('pre_medication_route', @$reaction_form->pre_medication_route) }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- Transfused Component Details -->
                                                <tr>
                                                    <th colspan="4">Transfused Component Details</th>
                                                </tr>
                                                <tr>
                                                    <td><b>Unit ID:</b> <input type="text" name="unit_id" class="form-control" value="{{ old('unit_id', @$reaction_form->unit_id) }}"></td>
                                                    <td><b>Component Type:</b> <input type="text" name="component_type" class="form-control" value="{{ old('component_type', @$reaction_form->component_type) }}"></td>
                                                    <td><b>ABO Grouping & Rh typing:</b> <input type="text" name="abo_rh" class="form-control" value="{{ old('abo_rh', @$reaction_form->abo_rh) }}"></td>
                                                    <td><b>Volume Transfused:</b> <input type="text" name="volume" class="form-control" value="{{ old('volume', @$reaction_form->volume) }}"></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Date of Collection:</b> <input type="date" name="collection_date" class="form-control" value="{{ old('collection_date', @$reaction_form->collection_date ? \Carbon\Carbon::parse($reaction_form->collection_date)->format('Y-m-d') : '') }}"></td>
                                                    <td><b>Date of Expiry:</b> <input type="date" name="expiry_date" class="form-control" value="{{ old('expiry_date', @$reaction_form->expiry_date ? \Carbon\Carbon::parse($reaction_form->expiry_date)->format('Y-m-d') : '') }}"></td>
                                                    <td><b>Date & Time of Issue:</b> <input type="datetime-local" name="issue_datetime" class="form-control" value="{{ old('issue_datetime', @$reaction_form->issue_datetime) }}"></td>
                                                    <td></td>
                                                </tr>

                                                <!-- Transfusion Reaction Details -->
                                                <tr>
                                                    <th colspan="4">Transfusion Reaction Details</th>
                                                </tr>
                                                <tr>
                                                    <td><b>Date & Time Transfusion Started:</b><input type="datetime-local" name="transfusion_start" class="form-control" value="{{ old('transfusion_start', @$reaction_form->transfusion_start) }}"></td>
                                                    <td><b>Rate of Transfusion (drops/min):</b><input type="text" name="transfusion_rate" class="form-control" value="{{ old('transfusion_rate', @$reaction_form->transfusion_rate) }}"></td>
                                                    <td><b>Date & Time Reaction Started:</b><input type="datetime-local" name="reaction_start" class="form-control" value="{{ old('reaction_start', @$reaction_form->reaction_start) }}"></td>
                                                    <td><b>Date & Time Transfusion Stopped:</b><input type="datetime-local" name="transfusion_stop" class="form-control" value="{{ old('transfusion_stop', @$reaction_form->transfusion_stop) }}"></td>
                                                </tr>

                                                <!-- Vital signs -->
                                                <tr>
                                                    <th colspan="5">Vital signs at the time of Reaction</th>
                                                </tr>
                                                <tr>
                                                    <th></th>
                                                    <th>Pre-Transfusion</th>
                                                    <th>During Reaction</th>
                                                    <th>After Reaction</th>
                                                    <th>Remarks</th>
                                                </tr>
                                                @php
                                                    $vitals = [
                                                        'datetime' => 'Date/Time',
                                                        'temp' => 'Temperature (C/F)',
                                                        'bp' => 'Blood Pressure',
                                                        'pulse' => 'Pulse',
                                                        'rr' => 'Respiratory Rate',
                                                        'o2' => 'O2 Saturation',
                                                    ];
                                                @endphp
                                                @foreach($vitals as $key => $label)
                                                <tr>
                                                    <td><b>{{ $label }}</b></td>
                                                    <td><input type="text" name="vital_pre_{{ $key }}" class="form-control" value="{{ old('vital_pre_'.$key, @$reaction_form->{'vital_pre_'.$key}) }}"></td>
                                                    <td><input type="text" name="vital_during_{{ $key }}" class="form-control" value="{{ old('vital_during_'.$key, @$reaction_form->{'vital_during_'.$key}) }}"></td>
                                                    <td><input type="text" name="vital_after_{{ $key }}" class="form-control" value="{{ old('vital_after_'.$key, @$reaction_form->{'vital_after_'.$key}) }}"></td>
                                                    <td><input type="text" name="vital_remarks_{{ $key }}" class="form-control" value="{{ old('vital_remarks_'.$key, @$reaction_form->{'vital_remarks_'.$key}) }}"></td>
                                                </tr>
                                                @endforeach
                                            </table>
                                        </div>

                                        <div class="text-center mt-3">
                                            @php
                                                $redirect_url = route('blood-transfusion-reaction-form', [
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