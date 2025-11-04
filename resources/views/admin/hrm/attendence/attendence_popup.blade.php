@php

$attendence_data = (isset($attendence_data) && (!empty($attendence_data))) ? $attendence_data : [];

$attendance_date = ($attendence_data) ? date('d-m-Y',strtotime($attendence_data->attendance_date)) : '';
$duty_shift_no_fk = ($attendence_data) ? $attendence_data->duty_shift_no_fk : '';
$in_time = ($attendence_data && isset($attendence_data->in_time)) ? date('h:i A',strtotime($attendence_data->in_time)) : '';
$out_time = ($attendence_data && isset($attendence_data->out_time)) ? date('h:i A',strtotime($attendence_data->out_time)) : '';
$duty_in_time = ($attendence_data) ? date('h:i A',strtotime($attendence_data->duty_in_time)) : '';
$duty_out_time = ($attendence_data) ? date('h:i A',strtotime($attendence_data->duty_out_time)) : '';
$lunch_out_time = (!empty($attendence_data->lunch_out_time)) ? date('h:i A',strtotime($attendence_data->lunch_out_time)) : '';
$lunch_in_time = (!empty($attendence_data->lunch_in_time)) ? date('h:i A',strtotime($attendence_data->lunch_in_time)) : '';
$person_card_no = ($attendence_data) ? $attendence_data->person_card_no : '';
$mattendance_no_pk = ($attendence_data) ? $attendence_data->mattendance_no_pk : '';
$remarks = ($attendence_data) ? $attendence_data->remarks : '';




@endphp

<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css')}}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('asset/timepicker/css/timepicker.css') }}">


<div class="row">
    <div class="col-sm-12 col-lg-12 col-xl-12">
        <form action="{{ route('hrm.attendence-manual-attendence-store') }}" method="post" id="attendence-form">
            @csrf
            <input type="hidden" name="id" value="{{$mattendance_no_pk}}">




            <form action="{{route('hrm.attendence-manual-attendence-store')}}" method="post"
            id="search-employee"> @csrf
            <div class="form-row">
                <div class="col-md-12" id="result-data">

   <!--      <div class="card">
            <div class="card-header"><h5>Manual Attendence</h5></div>
            <div class="card-body">
                <input type="hidden" name="id" value=""> -->


                <div class="form-row">

                    <div class="col-md-2">
                    <div class="form-group">
                        <label class="col-form-label col-form-label-sm" for="card_num">Card Number </label>
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
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="attendence_date"
                        class="col-form-label col-form-label-sm">Attendence Date </label>
                        <input type="text" class="form-control form-control-sm m-0 date_picker"
                        id="attendence_date1"
                        name="attendence_date1" value="{{$attendance_date}}" placeholder="dd-mm-yyyy" required />

                    </div>
                </div>


                {{-- <div class="col-md-3 mt-">
                    <div class="form-group">
                        <label for="shift_type"   class="col-form-label col-form-label-sm">Shift Type </label>
                        <select class="form-control" id="shift_type" name="shift_type1"onchange="check(this)" required>
                            <option value="0">Select Shift</option>
                            @if(isset($shift))
                            @foreach($shift as $val)
                            <option value="{{$val->shift_no_pk}}" data-start_time="{{date('h:i a', strtotime($val->start_time))}}" data-end_time="{{date('h:i a', strtotime($val->end_time)) }}" {{ ($val->shift_no_pk ==$duty_shift_no_fk) ? 'selected' : ''}}>{{$val->shift_code}}</option>
                            @endforeach
                            @endif

                        </select>
                    </div>
                </div> --}}

                {{-- <div class="col-md-3 mt-1">
                    <div class="form-group">
                        <label for="shift_start_time "   class="col-form-label col-form-label-sm">Time  </label>
                        <div class="input-group">
                            <input type="text" id="shift_start_time_popup" name="shift_start_time1" class="form-control required" placeholder="Start Time" value="{{$duty_in_time}}">
                            <input type="text"  id="shift_end_time_popup" name="shift_end_time1" class="form-control-sm m-0 form-control required" placeholder="End Time" value="{{$duty_out_time}}">
                        </div>
                    </div>
                </div> --}}

                {{-- <div class="col-md-3">
                    <div class="form-group">
                        <label class="col-form-label col-form-label-sm" for="lunch_out">L. Out Time</label>
                        <input class="field-start form-control form-control-sm m-0 timepicker "
                        id="lunch_out"
                        name="lunch_out" placeholder="Lunch Out" value="{{$lunch_out_time}}" />
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label class="col-form-label col-form-label-sm" for="lunch_in">L. In time</label>
                        <input class="form-control timepicker form-control-sm m-0 "
                        id="lunch_in"
                        name="lunch_in" placeholder="Lunch In" value="{{$lunch_in_time}}" />
                    </div>
                </div> --}}


                <div class="col-md-3">
                    <div class="form-group">
                        <label class="col-form-label col-form-label-sm" for="in_time">In Time </label>
                        <input class="field-start form-control form-control-sm m-0 timepicker "
                        id="in_time"
                        name="in_time1" placeholder="In Time" value="{{$in_time}}"/>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label class="col-form-label col-form-label-sm" for="out_time">Out Time</label>
                        <input class="form-control timepicker form-control-sm m-0 "
                        id="out_time"
                        name="out_time1" placeholder="Out Time" value="{{$out_time}}" />
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label class="col-form-label col-form-label-sm" for="remarks">Remarks</label>
                        <input class="form-control form-control-sm m-0 "
                        id="remarks"
                        name="remarks" placeholder="Remarks" value="{{ $remarks }}" />
                    </div>
                </div>



                <div class="col-md-12 text-right mt-2">
                    @php
                    $response_action = route('hrm.attendence-manual-attendence');
                    @endphp
                    <!-- <div class="modal-inline">           -->
                        <button type="submit" class="btn btn-md btn-success" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Save</button>                        <button type="button" class="btn btn-md btn-danger" data-dismiss="modal">Close</button>
                        <!-- <button type="reset" class="btn btn-info btn-md" title="Click here to Clear form data">Clear</button> -->
                        <!-- <button type="button" class="btn btn-md btn-danger mr-auto" data-dismiss="modal">Exit</button> -->
                        <!-- </div> -->
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


