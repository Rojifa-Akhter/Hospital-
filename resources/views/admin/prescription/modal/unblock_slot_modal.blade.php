<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">

<form action="{{ route('prescription.unblockSlot') }}" method="post" id="cancel-slot">
    @csrf
    <input type="hidden" name="schedule_id" value="{{ $id }}" />

    <p>Are you sure to unblock?</p>
    <div class="modal-footer pl-0">
        @php
            // $response_action = route('uhl.appointment', ['schedule_no_fk' => $schedule_info->schedule_no_fk, 'specialization_lookup_no_fk' => $schedule_info->specialization_lookup_no_fk]);
            $response_action = null;
        @endphp
        {{-- <button class="btn btn-success btn-md" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')"> --}}
            <button class="btn btn-success btn-md" onclick="btnSaveUpdate(this,'','','','', showSchedule,'{{ $response_action }}')">
            Unblock
        </button>
        <a href="{{ $response_action }}" type="reset" class="btn btn-danger btn-md" title="Click here to Clear form data">Exit</a>
    </div>
</form>

<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
    // getDropdownListByCondition("#","","");
    $('.select2').select2({});
</script>
