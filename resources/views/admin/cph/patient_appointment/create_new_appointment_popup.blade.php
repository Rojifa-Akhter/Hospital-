<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<style>
    label.custom-file-label.form-control.upload_app_label {
        line-height: 1.7;
    }
</style>
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<form action="{{ route('v1.hrm.applicant-marks-store') }}" method="post" id="applicant-marks-entry-form">
    @csrf
    {{-- <div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true"> --}}
    {{-- <div class="modal-dialog modal-lg" role="document"> --}}
    {{-- <div class="modal-content"> --}}
        {{-- <div class="modal-header"> --}}
            {{-- <h5 class="modal-title" id="exampleModalLabel">Marks</h5> --}}
            {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button> --}}
        {{-- </div> --}}
        <div class="modal-body p-0">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mt-0">
                        <div class="card-body p-2">
                            {{-- <div class="table-responsive"> --}}
                                <div class="justify-content-center  form-row">
                                    <div class="col-md-3">
                                        <label for="name" class=" col-form-label col-form-label-sm">Name</label>
                                        <input type="text" class="form-control form-control-sm " id="name" name="name"
                                            value="" placeholder="Name">
                                    </div>
    
                                    <div class="col-md-3">
                                        <label for="father_name" class=" col-form-label col-form-label-sm">Father Name</label>
                                        <input type="text" class="form-control form-control-sm " id="father_name" name="father_name"
                                            value="" placeholder="Father Name">
                                    </div>
    
                                    <div class="col-md-3">
                                        <label for="mother_name" class=" col-form-label col-form-label-sm">Mother Name</label>
                                        <input type="text" class="form-control form-control-sm " id="mother_name" name="mother_name"
                                            value="" placeholder="Mother Name">
                                    </div>
    
                                    <div class="col-md-3">
                                        <label for="bp_or_civ_no" class=" col-form-label col-form-label-sm">BP/CIV No.</label>
                                        <input type="text" class="form-control form-control-sm " id="bp_or_civ_no" name="bp_or_civ_no"
                                            value="" placeholder="BP/CIV No.">
                                    </div>

                                    <div class="col-md-3">
                                        <label for="relation" class=" col-form-label col-form-label-sm">Relation</label>
                                        <input type="text" class="form-control form-control-sm " id="relation" name="relation"
                                            value="" placeholder="Relation">
                                    </div>

                                    <div class="col-md-3">
                                        <label for="relation" class=" col-form-label col-form-label-sm">Maritial Status</label>
                                        <select class="form-control form-control-sm" name="relation" id="relation">
                                            <option value="">Select</option>
                                            <option value="">Single</option>
                                            <option value="">Married</option>
                                        </select>
                                    </div>

                                    <div class="col-md-3">
                                        <label for="gender" class=" col-form-label col-form-label-sm">Gender</label>
                                        <select class="form-control form-control-sm" name="gender" id="gender">
                                            <option value="">Select</option>
                                            <option value="">Male</option>
                                            <option value="">Female</option>
                                        </select>
                                    </div>

                                    <div class="col-md-3">
                                        <label for="dob" class=" col-form-label col-form-label-sm">Date of Birth</label>
                                        <input type="text" class="form-control form-control-sm date_picker" id="dob" name="dob"
                                            value="" placeholder="dd/mm/yyyy">
                                    </div>

                                    <div class="col-md-3">
                                        <label for="phone" class=" col-form-label col-form-label-sm">Phone</label>
                                        <input type="text" class="form-control form-control-sm " id="phone" name="phone"
                                            value="" placeholder="Phone">
                                    </div>

                                    <div class="col-md-3">
                                        <label for="blood_group" class=" col-form-label col-form-label-sm">Blood Group</label>
                                        <select class="form-control form-control-sm" name="blood_group" id="blood_group">
                                            <option value="">Select</option>
                                            <option value="">A+</option>
                                            <option value="">B+</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="email" class=" col-form-label col-form-label-sm">Email</label>
                                        <input type="text" class="form-control form-control-sm " id="email" name="email"
                                            value="" placeholder="Email">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="present_address" class=" col-form-label col-form-label-sm">Present Address</label>
                                        <textarea class="form-control form-control-sm m-0 p-0 item_element  mb-0 resetClass" name="present_address"
                                        id="present_address" cols="30" rows="3"></textarea>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="present_address" class=" col-form-label col-form-label-sm">Permanent Address</label>
                                        <textarea class="form-control form-control-sm m-0 p-0 item_element  mb-0 resetClass" name="present_address"
                                        id="present_address" cols="30" rows="3"></textarea>
                                    </div>
    
                                </div>
                                {{-- </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        {{-- </div> --}}
        <div class="modal-footer">
            @php
                $response_action = route('patient_appointment');
            @endphp
            <button type="button" class="btn btn-primary uhl_save_btn"
                onclick="btnSaveUpdateUpload(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')"
                id="">Registration</button>
            {{-- <button type="button" class="btn btn-primary uhl_save_btn">Save</button> --}}
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
</form>
</div>
{{-- </div> --}}
{{-- </div> --}}

<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
    $(document).ready(function() {
        $(".date_picker").datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
            clearBtn: true
        });
    });
</script>
