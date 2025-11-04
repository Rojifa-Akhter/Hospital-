<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<form action="{{ route('ot.cancel-ot') }}" method="post" id="cancel-ot">
    @csrf


    <input type="hidden" name="hdn_req_id" value="{{ isset($req_data->ot_req_no_fk) ? $req_data->ot_req_no_fk : '' }}">
    <input type="hidden" name="hdn_reff_anes_dept_no_fk"
        value="{{ isset($req_data->reff_anes_dept_no_fk) ? $req_data->reff_anes_dept_no_fk : '' }}">

    <input type="hidden" name="hdn_slot_no_fk" value="{{ isset($slotId) ? $slotId : '' }}">
    <input type="hidden" name="patient_no_fk" value="{{ isset($req_data->patient_no_fk) ? $req_data->patient_no_fk : '' }}">
    <div class=" form-row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="cancel_reason" class="col-form-label col-form-label-sm">Cancel Reason <span
                        class="text-danger"></span></label>
                <textarea name="cancel_reason" required id="" class="form-control" cols="30" rows="5"
                    onkeyup="checkBlankSpace(this)" placeholder="Cancel Reason" required></textarea>
            </div>
        </div>

    </div>






    <div class="modal-footer pl-0">
        @php
            $response_action = route('ot.appointment-status');
        @endphp
        <button class="btn btn-success btn-md"
            onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">
            Cancel Appointment
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
