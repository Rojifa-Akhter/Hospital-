<style>
    label.custom-file-label.form-control.upload_app_label {
        line-height: 1.7;
    }
</style>
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<div class="modal-dialog" role="document">
    <form action="{{ route('v1.hrm.letter-issue-save') }}" method="post" id="letter-issue-save-form">
        @csrf
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Issue Appointment Letter</h5>
            </div>
            <div class="modal-body p-0">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card mt-0">
                            <div class="card-body p-2">
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="hidden" name="hdn_applicant_id" value="{{ $applicant_id }}">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="letterissued_date" class="col-form-label">Issue
                                                Date</label>
                                            <input type="text" class="form-control form-control-sm date_picker"
                                                id="letterissued_date" name="letterissued_date" placeholder=""
                                                value="{{ isset($checkLetter) ? date('d-m-Y', strtotime($checkLetter->letterissued_date)) : '' }}" />
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="letterissued_remarks" class="col-form-label">Remarks</label>
                                            <textarea class="form-control" id="letterissued_remarks" name="letterissued_remarks" rows="3">{{ isset($checkLetter) ? $checkLetter->letterissued_remarks : '' }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                @php
                    $response_action = route('v1.hrm.applicant-work-list');
                @endphp
                <button type="button" class="btn btn-primary uhl_save_btn"
                    onclick="btnSaveUpdateUpload(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')"
                    id="">Save</button>
                <a href="{{ route('v1.hrm.appointment-letter', $applicant_id) }}" class="uhl_save_btn btn btn-success"
                    target="_blank">Appointment Letter</a>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </form>
</div>


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
