<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

<form action="{{ route('ipd-input-cafeteria.store') }}" method="post" id="cafeteria-create">
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
            <strong for="meal_type" class="">Meals Type <span class="text-danger">*</span></strong>
        </div>
        <div class="col-md-12">
            <select name="meal_type" id="" class="form-control" required>
                <option value="">Select One</option>
                <option value="Breakfast">Breakfast</option>
                <option value="Morning Snacks">Morning Snacks</option>
                <option value="Lunch">Lunch</option>
                <option value="Evening Snacks">Evening Snacks</option>
                <option value="Dinner">Dinner</option>
                <option value="Night Snacks">Night Snacks</option>
            </select>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-12 ">
            <strong for="food_type" class="" name="">Food Bill(Tk)  <span class="text-danger">*</span></strong>
        </div>
        <div class="col-md-12">
            <input type="textbox" id="food_type" name="food_type" class="form-control number_only" required>
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
