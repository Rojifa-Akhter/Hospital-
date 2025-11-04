
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<section id="full_appointment">
	<div class="container-fluid">
		<div class="row bg-white border-bottom sticky-top shadow-sm">
			<div class="col-md-12 mb-1">
				<h5 class="mt-2 mb-0"> Monthly Attendance Details Report</h5>
				<small>Report / HRM / Monthly Attendance Details Report</small>
			</div>
		</div>
		<div class="row">
            <div class="col-md-12">
                <div class="card mt-2">
                    <div class="card-header ">
                        <h5> Search</h5>
                    </div>

                    <div class="card-body ">
                        <div class="form-row mt-2">
                            <div class="col-md-12 table-responsive">
                                <form method="post" id="frmSearch" action="{{ route('hrm.monthly_attendance_details_report_print') }}" data-response-action="">
                                    @csrf
                                    <div class="form-group  form-row">
                                        <input type="hidden" name="id" value="">
                                        <label for="user_expire_date" class=" col-form-label col-form-label-sm ">Date</label>
                                        <div class=" col-md-2">
                                            <input type="text" class="form-control form-control-sm date_picker" id="date_pic" name="date_pic" value="" placeholder="YYYY/DD/MM" disabled>
                                            <span class="focus_input"></span>
                                        </div>
                                        <label for="card_no" class=" col-form-label col-form-label-sm ">Card No</label>
                                        <div class=" col-md-2 ">
                                            <input type="text" class="form-control form-control-sm " id="card_no" name="card_no" value="" placeholder="Cord no">

                                        </div>

                                        <div class="col-md-4">
                                        <div class="btn-group btn-block" role="group">
                                        <button type="button" class="btn btn-md btn-md-global btn-success btn-block mt-0"  id="monthlyAttendDetails" onclick=""> <i class="fas fa-search"></i> Search</button>
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
		<div class="card-header"> Monthly Attendance Report</div>
		<div class="card-body">

				<div class="form-row mt-2">
					<div class="col-md-12 table-responsive" id="search-container">
					@include('admin.reports.hrm.monthly_attendance_details_report_list')
					</div>
				</div>
			</div>
		</div>
		</div>


</section>


<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script>
	$('.date_picker').datepicker({
		format: 'yyyy-mm-dd',
		autoclose: true,
		todayHighlight: true,
		clearBtn: true,
	});

// 	$(document).on("click", "#monthlyAttendDetails", function(e) {
//     var formID = $("#frmSearch").attr("id");
//     // var formAction = $("#frmSearch").attr("action");
//     var formMethod = $("#frmSearch").attr("method");

//     $.ajax({
//         data: $('#' + formID).serialize(),
//         url:"{{ url('hrm.monthly_attendance_details_report_search') }}",
//         type: formMethod,
//         beforeSend: function() {
//             blockUI();

//         },
//         success: function(data) {
//             $("#search-container").html(data);
//         },
//         complete: function() {
//             $.unblockUI();
//         }
//     });
// });
</script>
