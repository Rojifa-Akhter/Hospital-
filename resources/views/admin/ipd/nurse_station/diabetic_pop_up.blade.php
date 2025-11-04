<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

<form action="{{ route('ipd-input-diabetic.store') }}" method="post" id="diabetic-create">
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
            <strong for="followup_diagnosis" class="">Type</strong>
        </div>
        <div class="col-md-12">
            <select name="type" id="" class="form-control">
                <option value="">Select One</option>
                <option value="Fasting Sugar">Fasting Sugar</option>
                <option value="Urinary Sugar">Urinary Sugar</option>
                <option value="Insulin">Insulin</option>
                <option value="2 Hr. After Breakfast">2 Hr. After Breakfast</option>
                <option value="Before Lunch">Before Lunch</option>
                <option value="Insulin (Before Lunch)">Insulin (Before Lunch)</option>
                <option value="Before Dinner">Before Dinner</option>
                <option value="Insulin (Before Dinner)">Insulin (Before Dinner)</option>
                <option value="After Dinner">After Dinner</option>
            </select>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-12 ">
            <strong for="followup_diagnosis" class="" name="">Volume</strong>
        </div>
        <div class="col-md-12">
            <input type="textbox" id="followup_diagnosis" name="volume" class="form-control">
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
