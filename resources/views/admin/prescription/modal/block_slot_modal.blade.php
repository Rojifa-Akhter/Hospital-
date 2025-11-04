<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">

<form action="{{ route('prescription.blockSlot') }}" method="post" id="cancel-slot">
    @csrf

    {{-- <input type="text" name="slot_no_pk" value="{{ isset($schedule_info->slot_no_pk) ? $schedule_info->slot_no_pk : 0 }}"> --}}
    {{-- <input type="text" name="in_doc_id"  value="{{ isset($schedule_info->person_no_pk) ? $schedule_info->person_no_pk : 0 }}"> --}}
    {{-- <input type="hidden" name="type" value="{{ $type }}"> --}}

    <input type="hidden" name="schedule_id" value="{{ $id }}" />
    <input type="hidden" name="doctor_id" value="{{ $doctor_id }}" />
    <input type="hidden" name="date" value="{{ $date }}" />

    <div class=" form-row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="grantuser_department" class="col-form-label col-form-label-sm">Slot Block Reason <span class="text-danger"></span></label>
                <textarea name="reason" required id="" class="form-control" cols="30" rows="5" onkeyup="checkBlankSpace(this)" placeholder="Slot Block Reason" required></textarea>
            </div>
        </div>
    </div>
    <div class="modal-footer pl-0">
        @php
            // $response_action = route('uhl.appointment', ['schedule_no_fk' => $schedule_info->schedule_no_fk, 'specialization_lookup_no_fk' => $schedule_info->specialization_lookup_no_fk]);
            $response_action = null;
        @endphp
        {{-- <button class="btn btn-success btn-md" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')"> --}}
            <button class="btn btn-success btn-md" onclick="btnSaveUpdate(this,'','','','', showSchedule,'{{ $response_action }}')">
            Save
        </button>
        <button type="reset" class="btn btn-info btn-md" title="Click here to Clear form data">Clear</button>
        <a href="{{ $response_action }}" type="reset" class="btn btn-danger btn-md" title="Click here to Clear form data">Exit</a>
    </div>
</form>

<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
    // getDropdownListByCondition("#","","");
    $('.select2').select2({});
</script>
