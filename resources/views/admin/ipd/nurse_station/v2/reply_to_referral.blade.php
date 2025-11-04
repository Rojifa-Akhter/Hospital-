<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

<form action="{{ route('ipd.save-referral-doctor-reason') }}" method="post" id="refer_doctor">
    @csrf
    <input type="hidden" name="patient_no_fk" id="patient_no_fk" value="{{ $patient_no_fk }}">
    <input type="hidden" name="admission_no_fk" id="admission_no_fk" value="{{ $admission_id }}">
    <input type="hidden" name="consultrecord_no_pk" id="consultrecord_no_pk" value="{{ $consultrecord_no_pk }}">


    <div class="form-group row">
        <div class="col-md-12 ">
            <strong for="ref_referral" class="">Update Referral Reply</strong>
        </div>
        <div class="col-md-12">
            <textarea id="ref_referral" name="ref_referral" class="form-control" rows="4" placeholder="write here ...">{{$replay_to_reff}}</textarea>
        </div>
    </div>


    <div class="modal-footer">
        @php
            $response_action = route('v2.ipd.nurse-note', $admission_id);
        @endphp
        <button class="btn btn-success btn-md"
            onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Save</button>
        <button type="reset" class="btn btn-info btn-md" title="Click here to Clear form data">Clear</button>
    </div>



</form>

