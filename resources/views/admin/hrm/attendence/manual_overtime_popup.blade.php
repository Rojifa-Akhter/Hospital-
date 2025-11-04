@php

$attendence_data = (isset($attendence_data) && (!empty($attendence_data))) ? $attendence_data : [];

$attendance_date = ($attendence_data) ? date('d-m-Y',strtotime($attendence_data->attendance_date)) : '';
$over_time = (!empty($attendence_data->over_time)) ? $attendence_data->over_time : '';
$person_card_no = ($attendence_data) ? $attendence_data->person_card_no : '';
$over_time_req_no_pk = ($attendence_data) ? $attendence_data->over_time_req_no_pk : '';




@endphp

<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css')}}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('asset/timepicker/css/timepicker.css') }}">


<div class="row">
    <div class="col-sm-12 col-lg-12 col-xl-12">

        <form action="{{route('hrm.store-manual-overtime')}}" method="post"
            id="store-manual-overtime"> @csrf
            <input type="hidden" name="id" value="{{$over_time_req_no_pk}}">
            <div class="form-row">
                <div class="col-md-12" id="result-data">


                <div class="form-row">

                    <div class="col-md-4">
                    <div class="form-group">
                        <label class="col-form-label col-form-label-sm" for="card_no">Card Number </label>
                        <input type="text" class="form-control form-control-sm m-0 " id="employee_code_popup"
                        name="employee_code" value="{{ $person_card_no }}"
                        placeholder="Employee Code/Name/Phone Number"  required/>
                        <input type="hidden" class="keep_me" id="hdn_item_id_popup" name="card_num1" value="{{ $person_card_no }}" >
                        @error('employee_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="attendence_date"
                        class="col-form-label col-form-label-sm">Attendence Date </label>
                        <input type="text" class="form-control form-control-sm m-0 date_picker"
                        id="attendence_date1"
                        name="attendence_date1" value="{{$attendance_date}}" placeholder="dd-mm-yyyy" required />

                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label class="col-form-label col-form-label-sm" for="in_time">Overtime </label>
                        <input class="field-start form-control form-control-sm m-0"
                        id="over_time"
                        name="overtime" placeholder="Overtime" value="{{$over_time}}"/>
                    </div>
                </div>


                <div class="col-md-12 text-right mt-2">
                    @php
                    $response_action = route('hrm.manual-overtime');
                    @endphp
                        <button type="submit" class="btn btn-md btn-success" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Save</button>                        <button type="button" class="btn btn-md btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
</div>



</div>
</div>
</div>
</div>
</div>
</section>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js')}}"></script>

<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('asset/timepicker/js/timepicker.js') }}"></script>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>

<script>
   openDoctorAutocomplete("#employee_code_popup", 'hdn_item_id_popup');
    function searchEmployee(){

        var employee_id = $("#employee_code_search").val();
       // alert(employee_id);
       var btnAction = $("#btnSearchReport").attr("data-action");
       $.ajax({
        data:{
            employee_id:employee_id
        },
        url: btnAction,
        type: "post",
        beforeSend: function () {
            blockUI();

        },
        success: function (data) {
            $("#search-container").html(data);
        },
        error: function (data) {
            var errors = jQuery.parseJSON(data.responseText).errors;
            error_messages="";
            for (messages in errors) {
                var field_name = $("#"+messages).siblings("label").html();
                error_messages +=  "<div class='alert alert-danger' role='alert'>"+errors[messages]+"</div>";
            }

            $('.common-modal-notify-error').modal('show');
            $('.common-modal-notify-error .modal-title').html("Validation Error");
            $('.common-modal-notify-error .modal-body').html(error_messages);

            $.unblockUI();
        },
        complete: function () {
            $.unblockUI();
        }
    });
   }



   $('.select2').select2({});


   function check(elecment){
      var thisVal = $(elecment).find('option:selected');
      var start_time = thisVal.attr("data-start_time");
      var end_time = thisVal.attr("data-end_time");
      $("#shift_start_time_popup").val(start_time);
      $("#shift_end_time_popup").val(end_time);
    // alert(start_time);

}



$(function() {
    $('.date_picker').datepicker({
       format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
            clearBtn: true
    });
    $('body').on('focus',".timepicker", function(){
        $(this).timepicker({
            // showInputs: false,
            // showMeridian: false,
            // setTime: null

        }); });
})

$(document).on("click", "#btnSearchReport", function(e) {
    var formID = $("#searchForm").attr("id");
// var formAction = $("#frmSearch").attr("action");
var formMethod = $("#searchForm").attr("method");

$.ajax({
    data: $('#' + formID).serialize(),
    url:"{{ url('hrm.attendence-manual-attendence-search') }}",
    type: formMethod,
    beforeSend: function() {
        blockUI();

    },
    success: function(data) {
        $("#search-container").html(data);
    },
    complete: function() {
        $.unblockUI();
    }
});
});
</script>


