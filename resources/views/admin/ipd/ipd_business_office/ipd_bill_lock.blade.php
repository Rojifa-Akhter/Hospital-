<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<form action="{{ route('ipd.update-ipd-bill-lock') }}" method="post" id="discharge-request">
    @csrf
    <div class="form-row">

        <div class="col-sm-12 col-lg-12 col-xl-12">

            <input type="hidden" id="hdn_admission_id" name="hdn_admission_id" value="{{ $admissionID }}">
            <input type="hidden" id="hdn_lock_ind" name="hdn_lock_ind" value="{{ $lockIND }}">
           
            <div class="form-group row">
                <label for="remarks" class="col-sm-12 col-form-label col-form-label-sm">Remarks <span
                        class="text-danger"></span></label>
                      
                <div class="col-sm-12">
                    <input type="text" class="form-control" id="remarks"  placeholder="remarks" name="remarks" value="{{isset($remarks)? $remarks:''}}">

                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer pl-0">
        @php
            $response_action = route('idp.ipd-business-office');
        @endphp
        <button class="btn btn-success btn-md"
            onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">
            Save
        </button>
        <button type="reset" class="btn btn-danger btn-md" title="Click here to Clear form data" data-dismiss="modal">Close</button>

        {{-- <a href="{{ route('idp.ipd-business-office') }}" type="reset" class="btn btn-info btn-md"
            title="Click here to Clear form data">Exit</a> --}}

    </div>
</form>


<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>

<script>
    // getDropdownListByCondition("#","","");
    $('.select2').select2({});
    openDoctorAutocomplete('#doctor_code', 'hdn_doctor_id','doctor_ind','1');


</script>
