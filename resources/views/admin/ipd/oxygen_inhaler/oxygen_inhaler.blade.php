<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

<form action="{{ route('ipd-input-oxygen-inhaler.store') }}" method="post" id="deit-create">
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
            <strong for="followup_diagnosis" class="" name="">Start Date</strong>
        </div>
        <div class="col-md-12">
            <input type="date" id="followup_diagnosis" name="starting_oxygen_date" class="form-control">
        </div>

    </div>
    <div class="form-group row">
        <div class="col-md-12 ">
            <strong for="followup_diagnosis" class="" name="">Start Time</strong>
        </div>
        <div class="col-md-12">
            <input type="time" id="followup_diagnosis" name="volume" class="form-control">
        </div>

    </div>


    <div class="form-group row">
        <div class="col-md-12 ">
            <strong for="followup_diagnosis" class="" name="">Flow of Oxygen</strong>
        </div>
        <div class="col-md-12">
            <input type="textbox" id="followup_diagnosis" name="flow_oxygen_inhalation" class="form-control">
        </div>

    </div>

    <div class="form-group row">
        <div class="col-md-12 ">
            <strong for="followup_diagnosis" class="" name="">Total Hours of Oxygen Inhalation</strong>
        </div>
        <div class="col-md-12">
            <input type="textbox" id="followup_diagnosis" name="total_number_oxygen_inhal" class="form-control">
        </div>

    </div>
    <div class="form-group row">
        <div class="col-md-12 ">
            <strong for="followup_diagnosis" class="" name="">Remarks</strong>
        </div>
        <div class="col-md-12">
            <input type="textbox" id="followup_diagnosis" name="remarks" class="form-control">
        </div>

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
