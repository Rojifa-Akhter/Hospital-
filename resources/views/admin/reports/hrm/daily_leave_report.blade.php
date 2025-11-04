<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<section id="full_appointment">
	<div class="container-fluid">
		<div class="row bg-white border-bottom sticky-top shadow-sm">
			<div class="col-md-12 mb-1">
				<h5 class="mt-2 mb-0"> Daily Leave  Report</h5>
				<small>Report / HRM / Daily Leave Report</small>
			</div>
		</div>
		<div class="card mt-2" style="width: 90%; margin: auto">
			<div class="card-header ">
				<h5> Search</h5>
			</div>

			<div class="card-body ">
				<div class="form-row mt-2">
					<div class="col-md-12 ">
						<form method="post" id="frmSearch" action="{{ route('hrm.daily_leave_report_print') }}" data-response-action="">
							@csrf
							<div class="form-group  form-row">
								<input type="hidden" name="id" value="">
								<label for="user_expire_date" class=" col-form-label col-form-label-sm ">From Date</label>
								<div class=" col-md-2">
									<input type="text" class="form-control form-control-sm date_picker" id="date_pic" name="date_pic" value="{{date('d-m-Y')}}" placeholder="YYYY/DD/MM">
									<span class="focus_input"></span>
									</div>
									<label for="user_expire_date" class=" col-form-label col-form-label-sm ">To Date</label>
									<div class=" col-md-2">
									
									<input type="text" class="form-control form-control-sm date_picker" id="date_pic2" name="date_pic2" value="{{date('Y-m-d')}}" placeholder="YYYY/DD/MM">
									<span class="focus_input"></span>
								</div>
								<label for="card_no" class=" col-form-label col-form-label-sm ">Card No</label>
								<div class=" col-md-2 ">
								<input type="text" class="form-control form-control-sm " id="card_no" name="card_no" value="" placeholder="Cord no"> 
									<input type="hidden" name="card_hidn" id="card_hidn">

								</div>

								<div class="col-md-3">
                                <div class="btn-group btn-block" role="group">
                                <button type="button" class="btn btn-sm btn-success btn-block mt-0"  id="leaveReport" onclick=""> <i class="fas fa-search"></i> Search</button>
                                <button type='submit' class="btn btn-primary btn-block btn-md mt-0"> Export PDF</button>
								</div>
								</div>

							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="container-fluid">
		
		<div class="card">
		<div class="card-header">Daily Leave Report</div>
		<div class="card-body">
        
				<div class="form-row mt-2">
					<div class="col-md-12 table-responsive" id="leave-container">
					@include('admin.reports.hrm.daily_leave_report_list')
					</div>
				</div>
			</div>
		</div>
		</div>
	
</section>

<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
		openDoctorAutocomplete("#card_no", 'card_hidn');
	$('.date_picker').datepicker({
		format: 'dd-mm-yyyy',
		autoclose: true,
		todayHighlight: true,
		clearBtn: true,
	});

	$(document).on("click", "#leaveReport", function(e) {
    var formID = $("#frmSearch").attr("id");
    // var formAction = $("#frmSearch").attr("action");
    var formMethod = $("#frmSearch").attr("method");

    $.ajax({
        data: $('#' + formID).serialize(),
        url:"{{ url('hrm/daily_leave_report_search') }}",
        type: formMethod,
        beforeSend: function() {
            blockUI();

        },
        success: function(data) {
            $("#leave-container").html(data);
        },
        complete: function() {
            $.unblockUI();
        }
    });
});
</script>