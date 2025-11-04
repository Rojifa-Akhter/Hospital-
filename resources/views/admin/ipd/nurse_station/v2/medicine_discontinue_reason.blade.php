<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

<form action="{{ route('v2.ipd.medicine-discontinue-request') }}" method="post" id="medReason">
    @csrf
    <input type="hidden" name="patient_no_fk" id="patient_no_fk" value="{{ $patient_no_fk }}">
    <input type="hidden" name="admission_no_fk" id="admission_no_fk" value="{{ $admission_id }}">
    <input type="hidden" name="prescription_med_no_pk" id="prescription_med_no_pk" value="{{ $prescription_med_no_pk }}">


    <div class="form-group row">
        <div class="col-md-12 ">
            <strong for="ref_referral" class="">Medicine Discontinue Reason</strong>
        </div>
        <div class="col-md-12">
            <textarea id="ref_referral" name="ref_referral" class="form-control" rows="4" placeholder="write here ..."></textarea>
        </div>
    </div>

    {{-- <div class="form-group mb-0">
        <label for="ref_doctor_name" class="col-form-label col-form-label-sm">Referral Doctor Name</label>
        <input type="text" class="form-control form-control-sm m-0 p-0 item_element  mb-0 resetClass"
            id="ref_doctor_name" name="ref_doctor_name" placeholder="Referral Doctor Name" value="" />
        <input type="hidden" id="ref_doctor_id" name="ref_doctor_id" value="" />
    </div> --}}


    <div class="modal-footer">
        @php
            $response_action = route('ipd.patient-medicine', [$patient_no_fk, $admission_id]);
        @endphp
        <button class="btn btn-success btn-md"
            onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Save</button>
        <button type="reset" class="btn btn-info btn-md" title="Click here to Clear form data">Clear</button>
    </div>
</form>

<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>

    openDoctorAutocomplete('#ref_doctor_name', 'ref_doctor_id');
</script>
