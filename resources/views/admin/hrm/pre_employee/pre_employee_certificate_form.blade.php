<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<div class="row">
<div class="col-sm-12 col-lg-12 col-xl-12">
    <form action="{{ route('v1.hrm.store-pre-employee-certificate') }}" method="post" id="certificate_id">
        @csrf
        <input type="hidden" name="invoice_no_fk" value="{{ $invoice_no_fk }}">
        <input type="hidden" name="certificate_id" value="{{ $certificate_id }}">
        <input type="hidden" name="person_id" value="{{ $person_id }}">
        <div class="form-group row">
            <div class="col-md-6">
                <label for="doc_name" class="col-sm-12 col-form-label col-form-label-sm mb-2">Doctor Name <span style="color:red"> *</span></label>
                <div class="col-sm-12">
                    <input type="text" class="form-control form-control-sm" id="doc_name" name="doc_name" value="{{ isset( $certificateData->doctor_no_fk) ?  $certificateData->full_name : Session::get('user.ses_user_name') }}" required>
                    <input type="hidden" name="doc_id" id="doc_id" value="{{ isset( $certificateData->doctor_no_fk) ?  $certificateData->doctor_no_fk : Session::get('user.ses_person_no_fk')}}">
                </div>
            </div>                
            <div class="col-md-6">
                <label for="doctor_id" class="col-sm-12 col-form-label col-form-label-sm mb-2">Examination Result</label>
                <div class="form-check form-check-inline ml-3">
                    <input class="form-check-input" type="radio" name="checkup_result" id="fit" value="1" <?= ((isset($certificateData->emp_status) && $certificateData->emp_status == 1) || !isset($certificateData->emp_status)) ? "checked" : "" ?>>

                    <label class="form-check-label" for="fit">
                        Medically Fit
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="checkup_result" id="unfit" value="2" <?= isset($certificateData->emp_status) &&  $certificateData->emp_status == 2 ? "checked" : "" ?> >
                    <label class="form-check-label" for="unfit">
                        Unfit
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="checkup_result" id="temp_unfit" value="3" <?= isset($certificateData->emp_status) &&  $certificateData->emp_status == 3 ? "checked" : "" ?> >
                    <label class="form-check-label" for="temp_unfit">
                        Temporarily Unfit 
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-12">
                <label for="remarks" class="col-sm-12 col-form-label col-form-label-sm mb-2">Remarks</label>
                <div class="col-sm-12">
                    <textarea type="text" class="form-control form-control-sm" id="remarks" name="remarks" rows="3">{{isset($certificateData->remarks) ? $certificateData->remarks : ""}}</textarea>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-12 col-md-12 ml-3 mt-2">
                <a class="btn btn-primary btn-sm" 
                    href="{{ route('emr.patient-emr') }}/{{ isset($patient_id) ? $patient_id : "" }}" target="_blank"><i class="fa fa-laptop-medical"></i> EMR
                </a>
            </div>
        </div>
        <div class="modal-footer mt-1" style="border: none">
            @php
                $response_action = route('v1.hrm.pre-employee-report');
            @endphp
            <button type="button" class="btn btn-success btn-md text-right" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Save</button>
        </div>
    </form>
    </div>
</div>

<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
    openDoctorAutocomplete('#doc_name', 'doc_id', 'doctor_ind', '1');
    $(document).ready(function() {
        $('#saveButton').click(function() {
            var formData = $('#hold_status').serialize();
            var url = $('#hold_status').attr('action');
            $("#myApprovalSearchReport").click();
            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                success: function(response) {
                    console.log(response);
                    $('.exampleModal').modal('hide' );
                    $('.common-modal-notify').modal('show');
                    $('.common-modal-notify .modal-body').html("<i class='fas fa-stroopwafel fa-spin'></i>");
                    $('.common-modal-notify .modal-title').html(response.title);
                    $('.common-modal-notify .modal-body').html(response.msg);
                    window.location.reload();
                },
                error: function(xhr) {
                    alert('Error in data. Please try again.');
                }
            });
        });
    });
</script>



