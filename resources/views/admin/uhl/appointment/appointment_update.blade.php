<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<form action="{{ route('uhl.update-pat-id') }}" method="post" id="update_pat">
    
    @csrf


    <input type="hidden" name="slot_no_pk"
        value="{{ isset($schedule_info->slot_no_pk) ? $schedule_info->slot_no_pk : 0 }}">
    <input type="hidden" name="in_doc_id"
        value="{{ isset($schedule_info->person_no_pk) ? $schedule_info->person_no_pk : 0 }}">

   
    <div class=" form-row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="grantuser_department" class="col-form-label col-form-label-sm">Appointment Update <span class="text-danger"></span></label>
                <input type="text" name="patient_id" required id="patient_id" class="form-control" 
                    onkeyup="checkBlankSpace(this)" placeholder="Enter UHID" required>                   
                <input type="hidden" class="form-control" id="hdn_patient_id"
                    name="hdn_patient_id" />


                <input type="hidden" name="app_id" id="app_id" value="{{$app_id}}">
            </div>
        </div>

    </div>






    <div class="modal-footer pl-0">
        @php
            $response_action = route('uhl.appointment', ['schedule_no_fk' => $schedule_info->schedule_no_fk, 'specialization_lookup_no_fk' => $schedule_info->specialization_lookup_no_fk]);
        @endphp
        <button class="btn btn-success btn-md"
            onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">
            Save
        </button>

        <button type="reset" class="btn btn-info btn-md" title="Click here to Clear form data">Clear</button>
        {{-- <a href="{{ $response_action }}" type="reset" class="btn btn-danger btn-md"
            title="Click here to Clear form data">Exit</a> --}}

    </div>
</form>


<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
      openPatientAutocomplete('#patient_id', 'patient_name');
    // getDropdownListByCondition("#","","");
    $('.select2').select2({});
</script>
