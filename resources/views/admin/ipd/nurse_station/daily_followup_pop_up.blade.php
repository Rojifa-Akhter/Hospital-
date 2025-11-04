<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

<form action="{{ route('ipd-daily-followup.store') }}" method="post" id="medication-create">
    @csrf
    <input type="hidden" name="id" value="">
    <input type="hidden" name="hdn_item_id" id="hdn_item_id" value="">
    <input type="hidden" name="hdn_item_name" id="hdn_item_name" value="">
    <input type="hidden" name="hdn_lookup_id" id="hdn_lookup_id" value="">
    <input type="hidden" name="hdn_lookup_code" id="hdn_lookup_code" value="">
    <input type="hidden" name="hdn_lookupdata_code" id="hdn_lookupdata_code" value="">
    <input type="hidden" name="patient_no_fk" id="patient_no_fk" value="{{ $patient_no_fk }}">
    <input type="hidden" name="admission_no_fk" id="admission_no_fk" value="{{ $admission_id }}">


    <div class="form-group row">
        <div class="col-md-4 ">
            <strong> Patient Name </strong>
        </div>
        <div class="col-md-8 ">
            : {{ @$patient_info->patient_name }}
        </div>


    </div>
    <div class="form-group row">
        <div class="col-md-12 ">
            <strong for="followup_diagnosis" class="">Diagnosis</strong>
        </div>
        <div class="col-md-12">
            <input type="textbox" id="followup_diagnosis" name="followup_diagnosis" class="form-control">
        </div>

    </div>

    <div class="form-group row">
        <div class="col-md-12 ">
            <strong for="symptom_lookupdata_no_fk" class="">Symptoms</strong>
        </div>
        <div class="col-md-12">
            <input type="textbox" id="symptom_lookupdata_no_fk" name="symptom_lookupdata_no_fk" class="form-control">

            <ul class="list-unstyled mb-0 pt-1" id="symptom_lookupdata_no">
            </ul>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-12 ">
            <strong for="followup_diagnosis" class="">Severity</strong>
        </div>
        <div class="col-md-12">
            <select name="symptom_severity_text" id="" class="form-control">
                <option value="">Select One</option>
                <option value="Improving">Improving</option>
                <option value="Deteriorating">Deteriorating</option>
                <option value="Same">Same</option>
            </select>
        </div>
    </div>

    <div class="form-group mb-0">
        <label for="doctor_name_0" class="col-form-label col-form-label-sm">Doctor
            Name <span class="text-danger">*</span></label>
        <input type="text" class="form-control form-control-sm m-0 p-0 item_element  mb-0 resetClass"
            id="doctor_name_0" name="doctor_name_0" placeholder="Doctor Name" required />
        <input type="hidden" id="doctor_id" name="doctor_id" />
    </div>





    <div class="modal-footer">
        @php
            $response_action = route('ipd.nurse-station-received-patient');
        @endphp
        <button class="btn btn-success btn-md"
            onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">
            Save</button>
        <button type="reset" class="btn btn-info btn-md" title="Click here to Clear form data">Clear</button>
        <a href="{{ route('ward.index') }}" class="btn btn-danger btn-md" rel="tab"
            title="Click here to go back to Dashboard">Exit</a>
    </div>
</form>


<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
    openIPDAutocomplete("#symptom_lookupdata_no_fk", "{{ route('lookup-pres-data-autocomplete') }}", "PRES",
        "IPDDISEASE");
    openDoctorAutocomplete("#doctor_name_0", "doctor_id");
</script>
