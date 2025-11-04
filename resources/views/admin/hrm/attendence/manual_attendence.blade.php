<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css')}}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('asset/timepicker/css/timepicker.css') }}">
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />

<style>
	.dataTables_wrapper .dataTables_filter input {
		width: 190px;
		margin-top: 10px;
	}
</style>
<div class="container-fluid">
	<div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm align-items-center">
		<div class="col-md-6">
			<h5 class="mt-2 mb-0">Manual Attendance</h5>
			<small>Admin / attendance / Manual Attendance</small>
		</div>
	</div>

	<form action="{{route('hrm.attendence-manual-attendence-store')}}" method="post" id="search-employee"> @csrf
		<div class="form-row">
			<div class="col-md-12" id="result-data">
				<div class="card">
					<div class="card-header"><h5>New Attendance</h5></div>
					<div class="card-body">
						<input type="hidden" name="id" value="">

						<div class="form-row">
							<div class="col-md-3">
								<div class="form-group">
									<label class="col-form-label col-form-label-sm" for="card_num">Card Number</label>
									<input type="text" class="form-control form-control-sm m-0 keep_me" id="employee_code"
									name="employee_code"
									value="" placeholder="Employee Code/Name/Phone Number" />
									<input type="hidden" class="keep_me" id="hdn_item_item_id_0" name="card_num" value="" >
									@error('employee_id')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
									@enderror
									{{--                                    <input type="text" class="form-control form-control-sm m-0 keep_me" id="employee_code" name="card_num" placeholder="Card Number" value="">--}}
								</div>
							</div>

							<div class="col-md-2">
								<div class="form-group">
									<label for="attendence_date"
									class="col-form-label col-form-label-sm">Attendance Date</label>
									<input type="text" class="form-control form-control-sm m-0 date_picker"
									id="attendence_date"
									name="attendence_date" value="" placeholder="dd-mm-yyyy"  />

								</div>
							</div>

							{{-- <div class="col-md-1">
								<div class="form-group">
									<label for="shift_type"  class=" col-form-label  col-form-label-sm">Shift Type</label>
									<select class="form-control" id="shift_type" name="shift_type" >
										<option value="0">Select Shift</option>
										@if(isset($shift))
										@foreach($shift as $val)
										<option value="{{$val->shift_no_pk}}" data-start_time="{{date('h:i a', strtotime($val->start_time))}}" data-end_time="{{date('h:i a', strtotime($val->end_time)) }}">{{$val->shift_code}}</option>
										@endforeach
										@endif
									</select>
								</div>
							</div> --}}
{{--
							<div class="col-md-2">
								<div class="form-group">
									<label for="shift_start_time" class=" col-form-label  col-form-label-sm">Time</label>
									<div class="input-group">
										<input type="text" id="shift_start_time" name="shift_start_time" class="form-control " placeholder="Start Time" value="" readonly="readonly">
										<input type="text"  id="shift_end_time" name="shift_end_time" class="form-control-sm m-0 form-control" placeholder="End Time" value="" readonly="readonly">
									</div>
								</div>
							</div>

							<div class="col-md-1">
								<div class="form-group">
									<label class="col-form-label col-form-label-sm" for="lunch_out">Lunch Out </label>
									<input class=" form-control form-control-sm m-0 timepicker "
									id="lunch_out"
									name="lunch_out" placeholder="Lunch Out" value="" />
								</div>
							</div>

							<div class="col-md-1">
								<div class="form-group">
									<label class="col-form-label col-form-label-sm" for="lunch_in">Lunch In </label>
									<input class="form-control timepicker form-control-sm m-0 "
									id="lunch_in"
									name="lunch_in" placeholder="Lunch In" value="" />
								</div>
							</div> --}}

							<div class="col-md-2">
								<div class="form-group">
									<label class="col-form-label col-form-label-sm" for="in_time">In Time</label>
									<input class="field-start form-control form-control-sm m-0 timepicker "
									id="in_time"
									name="in_time" placeholder="In Time" value="" />
								</div>
							</div>

							<div class="col-md-2">
								<div class="form-group">
									<label class="col-form-label col-form-label-sm" for="out_time">Out Time</label>
									<input class="form-control timepicker form-control-sm m-0 "
									id="out_time"
									name="out_time" placeholder="Out Time" value="" />
								</div>
							</div>

							<div class="col-md-2">
								<div class="form-group">
									<label class="col-form-label col-form-label-sm" for="remarks">Remarks</label>
									<input class="form-control form-control-sm m-0 "
									id="remarks"
									name="remarks" placeholder="Remarks" value="" />
								</div>
							</div>

							<div class="col-md-1 mt-4">
								@php
								$response_action = route('hrm.attendence-manual-attendence');
								@endphp
								<button type="submit" class="btn btn-md btn-md-global btn-success uhl_save_btn" onclick="btnSaveUpdate(this,'','','','',dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Save</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>

	<!-- List  -->
	<div class="row">
		<div class="col-md-12">
			<div id="search-container">

				<div class="card">

					<div class="card-header"><h5> Attendance List </h5></div>
					<div class="card-body">
						<form action="" name="searchForm" id='searchForm' method="post">
							<div class="form-row  border-bottom  mt-2 mb-2">
								<div class="col-md-2">
									<div class="form-group">
										<input type="text" class="form-control form-control-sm m-0 keep_me" id="employee_code_search" name="employee_code_search" value="" placeholder="Card Number"  />
									</div>
								</div>

								<div class="col-sm-2">
									<button type="button" class="btn btn-md btn-success" id="btnSearchReport" data-action=""  onclick=""><i class="fa fa-search"></i>Search</button>
									<!-- <button type="reset" class="btn btn-md btn-info"> Clear </button> -->
								</div>
							</div>
						</form>
						<div class="row mt-2">
							<div id="searchData" class="col-12 table-responsive">
								@include("admin.hrm.attendence.manual_attendence_list")
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js')}}"></script>

<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('asset/timepicker/js/timepicker.js') }}"></script>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>

<script>


function deleteManualAtt(element) {
    // var fund_id = $("#fund_hdn_id").val();
    var attendence = $(element).siblings('#manual_att_delete').val();

    if ( confirm('Are you sure ?')) {
        $.ajax({
            data:{attendence : attendence},
            url:"{{ route('manual_attendence_delete') }}",
            type: 'get',
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                 // alert("#"+fund_id);
                 $(element).parents("tr").remove();
                 // $(this).closest("tr").remove();
                $('.common-modal-notify').modal('show');
                $('.common-modal-notify .modal-body').html("<i class='fas fa-stroopwafel fa-spin'></i>");
                $('.common-modal-notify .modal-body').html("Delete successfully");



            },
            complete: function() {

                $.unblockUI();

            }
        });
    }
    event.preventDefault();
}




 // $("body").addClass("sidebar-collapse");
    // function searchEmployee() {
    	openDoctorAutocomplete("#employee_code", 'hdn_item_item_id_0');
    	$('.select2').select2();

        // Searching
        $(document).on("click", "#btnSearchReport", function (e) {
        	var formID = $("#searchForm").attr("id");
            // var formAction = $("#frmSearch").attr("action");
            var formMethod = $("#searchForm").attr("method");

            $.ajax({
            	data: $('#' + formID).serialize(),
            	url: "{{route ('hrm.attendence-manual-attendence-search') }}",
            	type: formMethod,
            	beforeSend: function () {
            		blockUI();

            	},
            	success: function (data) {
            		$("#searchData").html(data);
            	},
            	complete: function () {
            		$.unblockUI();
            	}
            });
        });
    // }


    // time
    $(document).on("change","#shift_type", function(e){
    	var thisVal = $(this).find('option:selected');
    	var start_time = thisVal.attr("data-start_time");
    	var end_time = thisVal.attr("data-end_time");
    	$("#shift_start_time").val(start_time);
    	$("#shift_end_time").val(end_time);

    })



    $(function() {
    	$('.date_picker').datepicker({
    		format: 'dd-mm-yyyy',
    		todayHighlight: true,
    		clearBtn: true,
    		autoclose: true
    	});
    	$('body').on('focus',".timepicker", function(){
    		$(this).timepicker({
    			// showInputs: false,
    			// showMeridian: false,
    			// setTime: null

    		}); });
    })

// $(document).on("click", "#btnSearchReport", function(e) {
//     var formID = $("#searchForm").attr("id");
// // var formAction = $("#frmSearch").attr("action");
// var formMethod = $("#searchForm").attr("method");

{{--$.ajax({--}}
	{{--    data: $('#' + formID).serialize(),--}}
	{{--    url:"{{ url('hrm.attendence-manual-attendence-search') }}",--}}
	{{--    type: formMethod,--}}
	{{--    beforeSend: function() {--}}
	{{--        blockUI();--}}

	{{--    },--}}
	{{--    success: function(data) {--}}
	{{--        $("#search-container").html(data);--}}
	{{--    },--}}
	{{--    complete: function() {--}}
	{{--        $.unblockUI();--}}
	{{--    }--}}
	{{--});--}}
</script>


