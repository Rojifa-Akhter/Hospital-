<form method="post" id="frm-cancel-appointment" action="{{ route('cancel-appointment') }}">
    @csrf
    <div class="form-group row">
        <label for="txt_cancel_reason" class="col-sm-2 col-form-label">Reason</label>
        <div class="col-sm-10">
            <textarea class="form-control" rows="4" name="txt_cancel_reason" id="txt_cancel_reason"
                placeholder="Write the reason for canceling the Appointment"></textarea>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Email</label>
        <div class="col-sm-10">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="cancelEmail" value="1" id="chkEmail"
                    {{ $app_info == null ? 'disabled' : '' }}>
                <label class="form-check-label" for="chkEmail">
                    {{ $app_info == null ? 'Unavailable email address' : 'Yes' }}
                </label>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">SMS</label>
        <div class="col-sm-10">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="cancelSms" value="1" id="chkSms">
                <label class="form-check-label" for="chkSms">
                    Yes
                </label>
            </div>
        </div>
    </div>
    <hr />
    <div class="form-group row">
        <div class="col-sm-2"></div>
        <div class="col-sm-10">
            <input type="hidden" name="hdn_appointment_id" value="{{ $appointment_id }}">
            @php
                $patient_id = '';
                $redirect_url = route('appointments.list-view');
            @endphp
            <button class="btn btn-md btn-success btn-save" onclick="appointmentEngine.cancelAppointment(this)"
                title="Click here to Cancel Appointment">Save</button>

            <button type="reset" class="btn btn-info btn-md" title="Click here to Clear form data">Clear</button>
            <a href="{{ route('home') }}" class="btn btn-danger btn-md" rel="tab"
                title="Click here to go back to Dashboard">Exit</a>
        </div>
    </div>
</form>
