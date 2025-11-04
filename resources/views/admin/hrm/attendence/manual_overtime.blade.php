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
			<h5 class="mt-2 mb-0">Overtime Requisition Entry</h5>
			<small>Admin / attendance / Overtime Requisition Entry</small>
		</div>
	</div>

	<form action="{{route('hrm.store-manual-overtime')}}" method="post" id="manual_overtime"> @csrf
		<div class="form-row">
			<div class="col-md-12" id="result-data">
				<div class="card">
					<div class="card-header"><h5>Overtime Requisition Form</h5></div>
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

							<div class="col-md-3">
								<div class="form-group">
									<label for="attendence_date"
									class="col-form-label col-form-label-sm">Attendance Date</label>
									<input type="text" class="form-control form-control-sm m-0 date_picker"
									id="attendence_date"
									name="attendence_date" value="" placeholder="dd-mm-yyyy"  />

								</div>
							</div>

							<div class="col-md-2">
								<div class="form-group">
									<label class="col-form-label col-form-label-sm" for="overtime">Overtime</label>
									<input type="text" class="field-start form-control form-control-sm m-0"
									id="overtime"
									name="overtime" placeholder="Overtime" value="" />
								</div>
							</div>


							<div class="col-md-1 mt-4">
								@php
								$response_action = route('hrm.manual-overtime');
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

					<div class="card-header"><h5> Overtime Requisition List </h5></div>
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
								@include("admin.hrm.attendence.manual_overtime_list")
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


function deleteManualOvertime(element) {
    // var fund_id = $("#fund_hdn_id").val();
    var over_time_req_no_pk = $(element).siblings('#manual_overtime_delete').val();

    if ( confirm('Are you sure ?')) {
        $.ajax({
            data:{over_time_req_no_pk : over_time_req_no_pk},
            url:"{{ route('hrm.delete-manual-overtime') }}",
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
            	url: "{{route ('hrm.search-manual-overtime') }}",
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


