<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
@php
$param_arr = explode('_', $param);
@endphp
<form action="{{ route('send-custom-sms') }}" method="post" id="grant-service-form-create">
    @csrf
    <div class="form-group row">
        <label for="grantuser_department" class="col-sm-12 col-form-label col-form-label-sm">Patient Name <span
                class="text-danger"></span></label>
        <div class="col-sm-12">
            <input type="text" class="form-control" name="" value="{{ isset($param_arr[2])? $param_arr[2]:'' }}">
        </div>
        <div class="col-sm-12">
            <input type="hidden" class="form-control" name="id" value="{{ isset($param_arr[0])? $param_arr[0]:'' }}">
            <input type="hidden" class="form-control" name="sms" value="1">
        </div>

        <label for="grantuser_user" class="col-sm-12 col-form-label col-form-label-sm">Doctor Name <span
                class="text-danger"></span></label>
        <div class="col-sm-12">
            <input type="text" class="form-control" value="{{ isset($param_arr[3])? $param_arr[3]:'' }}">

        </div>
        <label for="mobile_num" class="col-sm-12 col-form-label col-form-label-sm">Patient Number<span
                class="text-danger"></span></label>
        <div class="col-sm-12">
            <input type="text" class="form-control" name="mobile_num" value="{{ isset($param_arr[1])? $param_arr[1]:'' }}">
        </div>
        <label for="grantuser_user" class="col-sm-12 col-form-label col-form-label-sm">SMS Preview<span
                class="text-danger"></span></label>
        <div class="col-sm-12">
            <textarea id="" cols="30" rows="10" class="form-control" name="message_body">আসসালামুআলাইকুম,আমি ড: {{ isset($param_arr[3])? $param_arr[3]:'' }} | আমার সাথে আপনার আপনার পরবর্তী দেখা করা তারিখ {{ isset($param_arr[5])? date('d/m/Y',strtotime($param_arr[5])):'' }} |  {{ isset($hospital->hospital_name_bangla )? $hospital->hospital_name_bangla : $hospital->hospital_name }}। প্রয়োজনেঃ {{   $hospital->telephone1 }}
            </textarea>
        </div>
    </div>


    <div class="modal-footer pl-0">
        @php
            $response_action = route('pcrm.pcrm-dashboard');
        @endphp
        <button class="btn btn-success btn-md"
            onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">
            Send SMS
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
