
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<style type="text/css">
	.board_member_img{
		width: 65px;
		border:2px solid #d6eefb;
		margin-right: 10px;
	}

	.table td,
	.table th {
		vertical-align: middle!important;
	}

	.board_member_info{
		padding: 5px 0 5px 0;
		border-bottom: 1px solid #c6d0d9;
	}

.board_member_info:last-child{
	border-bottom: 0px;
}
</style>
<section id="full_appointment">
	<div class="container-fluid">
		<div class="row bg-white border-bottom sticky-top shadow-sm">
			<div class="col-md-12 mb-1">
				<h5 class="mt-2 mb-0"> Daily Machine Attendance Report</h5>
				<small>Report / HRM / Daily Machine Attendance Report</small>
			</div>
		</div>
		<div class="row">
            <div class="col-md-12">
                <div class="card mt-2">
                    <div class="card-header ">
                        <h5> Search</h5>
                    </div>

                    <div class="card-body ">
                        <div class="form-row m-2">
                            <div class="col-md-12 ">
                                <form method="post" id="frmSearch" action="{{ route('hrm.daily_machine_attendance_report_print') }}" data-response-action="">
                                    @csrf
                                    <div class="form-group  form-row">
                                        <input type="hidden" name="id" value="">

                                            <div class=" col-md-2 ">
                                                <label for="card_no" class=" col-form-label col-form-label-sm ">Card No</label>
                                                <input type="text" class="form-control form-control-sm " id="card_no" name="card_no" value="" placeholder="Cord no">
                                                <input type="hidden" name="card_hidn" id="card_hidn">

                                            </div>

                                        <div class=" col-md-2">
                                            <label for="user_expire_date" class=" col-form-label col-form-label-sm ">From Date</label>
                                            <input type="text" class="form-control form-control-sm date_picker" id="date_pic" name="date_pic" value="{{date('d-m-Y')}}" placeholder="YYYY/DD/MM">
                                            <span class="focus_input"></span>
                                        </div>

                                        <div class=" col-md-2">
                                            <label for="user_expire_date" class=" col-form-label col-form-label-sm ">To Date</label>
                                            <input type="text" class="form-control form-control-sm date_picker" id="date_pic2" name="date_pic2" value="{{date('d-m-Y')}}" placeholder="YYYY/DD/MM">
                                            <span class="focus_input"></span>
                                        </div>

                                        <div class=" col-md-3 ">
                                            <label for="department_name" class=" col-form-label col-form-label-sm ">Department</label>
                                            <select class="form-control select2" id="department_name" name="department_name" style="margin:0px!important;">
                                                <option value="">Select Department</option>
                                                @if(isset($dept))
                                                @foreach($dept as $value)
                                                <option value="{{$value->serviceunit_no_pk}}" >{{$value->serviceunit_name}}</option>
                                                @endforeach
                                                @endif
                                            </select>

                                            <!-- <input type="text" class="form-control form-control-sm " id="department_name" name="department_name" value="" placeholder="Cord no">
                                                <input type="hidden" name="card_hidn" id="card_hidn"> -->

                                            </div>



                                            <div class="col-md-3 mt-4">
                                                <div class="btn-group btn-block" role="group">
                                                    <button type="button" class="btn btn-md btn-md-global btn-success btn-block mt-0"  id="dailyMachineAttSearchReport" onclick=""> <i class="fas fa-search"></i> Search</button>
                                                    <button type='submit' class="btn btn-primary btn-block btn-md btn-md-global mt-0"> Export PDF</button>
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

		<div class="container-fluid">

			<div class="card">
				<div class="card-header"> Daily Attendance Report</div>
				<div class="card-body">

					<div class="form-row mt-2">
						<div class="col-md-12 table-responsive" id="machine-attend-container">
							@include('admin.reports.hrm.daily_machine_attendance_list')
						</div>
					</div>
				</div>
			</div>
		</div>


	</div>
</section>


<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
	<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
	$('.select2').select2();
	openDoctorAutocomplete("#card_no", 'card_hidn');
	$('.date_picker').datepicker({
		format: 'dd-mm-yyyy',
		autoclose: true,
		todayHighlight: true,
		clearBtn: true,
	});

	$(document).on("click", "#dailyMachineAttSearchReport", function(e) {
		var formID = $("#frmSearch").attr("id");
    // var formAction = $("#frmSearch").attr("action");
    var formMethod = $("#frmSearch").attr("method");

    $.ajax({
    	data: $('#' + formID).serialize(),
    	url:"{{ url('hrm/daily_machine_attendance_report_search') }}",
    	type: formMethod,
    	beforeSend: function() {
    		blockUI();

    	},
    	success: function(data) {
    		$("#machine-attend-container").html(data);
    	},
    	complete: function() {
    		$.unblockUI();
    	}
    });
    e.stopImmediatePropagation();
});
</script>
