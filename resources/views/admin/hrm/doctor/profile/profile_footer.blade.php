<div class="col-md-12 mt-2">
    @php
        $doctor_id = "";
        $response_action = route('manage-profile', $doctor_no_pk);
    @endphp

    <button class="btn btn-success btn-md" onclick="btnSaveUpdate(this)"> Update </button>
    <button type="reset" class="btn btn-info btn-md" title="Click here to Clear form data">Clear</button>
    <a href="{{ route('admin-dashboard') }}" class="btn btn-danger btn-md" rel="tab" title="Click here to go back to Dashboard">Exit</a>
</div>
