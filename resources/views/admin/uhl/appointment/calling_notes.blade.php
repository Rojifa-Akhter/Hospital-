<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<form action="{{ route('uhl.update-calling-note') }}" method="post" id="cancel-appointment">
    @csrf


    <input type="hidden" name="hdn_appointment_id"
        value="{{ isset($appointment_info->appoint_no_pk) ? $appointment_info->appoint_no_pk : 0 }}">

    <input type="hidden" name="hdn_slot_no_fk"
        value="{{ isset($appointment_info->slot_no_fk) ? $appointment_info->slot_no_fk : 0 }}">
    <div class=" form-row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="grantuser_department" class="col-form-label col-form-label-sm">Calling Notes <span
                        class="text-danger"></span></label>
                <textarea name="calling_notes" required id="" class="form-control" cols="30" rows="5"
                    onkeyup="checkBlankSpace(this)" placeholder="Calling Notes" required>{{ $appointment_info->calling_note }}</textarea>
            </div>
        </div>

    </div>






    <div class="modal-footer pl-0">
        @php
            $response_action = route('uhl.appointment', ['schedule_no_fk' => $appointment_info->schedule_no_fk, 'specialization_lookup_no_fk' => $appointment_info->specialization_lookup_no_fk]);
        @endphp
        <button class="btn btn-success btn-md"
            onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">
            Save
        </button>

        <button type="reset" class="btn btn-info btn-md" title="Click here to Clear form data">Clear</button>
        <a href="{{ $response_action }}" type="reset" class="btn btn-danger btn-md"
            title="Click here to Clear form data">Exit</a>

    </div>
</form>


<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
    // getDropdownListByCondition("#","","");
    $('.select2').select2({});
</script>
