<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">

<form action="{{ route('send-mail') }}" method="post" id="grant-service-form-create">
    @csrf
    <div class="form-group row">
        <label for="grantuser_department" class="col-sm-12 col-form-label col-form-label-sm">To <span
                class="text-danger"></span></label>
        <div class="col-sm-12">
            <input type="text" class="form-control" name="sender_email" value="" placeholder="demo@app.com" required>
        </div>

        <label for="grantuser_department" class="col-sm-12 col-form-label col-form-label-sm">Patient Name <span
                class="text-danger"></span></label>
        <div class="col-sm-12">
            <input type="text" class="form-control" name=""
                value="{{ isset($patient_info->patient_name) ? $patient_info->patient_name : '' }}">
        </div>
        <div class="col-sm-12">
            <input type="hidden" class="form-control" name="id"
                value="{{ isset($patient_info->patient_no_pk) ? $patient_info->patient_no_pk : '' }}">
            <input type="hidden" class="form-control" name="sms" value="1">
        </div>

        <label for="grantuser_user" class="col-sm-12 col-form-label col-form-label-sm">Subject<span
                class="text-danger"></span></label>
        <div class="col-sm-12">
            <input type="text" name="subject" class="form-control" value="EMR Report"
                value="{{ isset($param_arr[3]) ? $param_arr[3] : '' }}">

        </div>

        <label for="grantuser_user" class="col-sm-12 col-form-label col-form-label-sm">Mail Preview<span
                class="text-danger"></span></label>
        <div class="col-sm-12">
            <textarea id="" cols="30" rows="10" class="form-control" name="message_body">In this Mail,we are going to send an Electronic Medical Record(EMR) of {{ isset($patient_info->patient_name) ? $patient_info->patient_name : '' }}
            </textarea>
        </div>
    </div>


    <div class="modal-footer pl-0">
        @php
            $response_action = route('emr.patient-emr', 7650);
        @endphp
        <button class="btn btn-success btn-md"
            onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">
            Send Mail
        </button>

        <button type="reset" class="btn btn-info btn-md" title="Click here to Clear form data">Clear</button>
        <a href="{{ route('serviceunit.grant-service-unit-to-user') }}" type="reset" class="btn btn-danger btn-md"
            title="Click here to Clear form data">Exit</a>

    </div>
</form>



<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
    // getDropdownListByCondition("#","","");
    $('.select2').select2({});
</script>
