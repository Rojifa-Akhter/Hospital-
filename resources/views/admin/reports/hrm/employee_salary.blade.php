
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />

<section id="full_appointment">
	<div class="container-fluid">
		<div class="row bg-white border-bottom sticky-top shadow-sm">
			<div class="col-md-12 mb-1">
				<h5 class="mt-2 mb-0">  Salary Structure</h5>
				<small>Report / HRM / Salary Structure</small>
			</div>
		</div>
		<div class="row">
            <div class="col-md-12">
                <div class="card mt-2 ">
                    <div class="card-header ">
                        <h5> Search</h5>
                    </div>

                    <div class="card-body ">
                        <div class="form-row mt-2">
                            <div class="col-md-12  ">
                                <form method="post" id="frmSearch" action="{{ route('hrm.employee_salary_print') }}" target="_blank" data-response-action="">
                                    @csrf
                                    <div class="form-group  form-row m-0">
                                        <input type="hidden" name="id" value="">
                                        <label for="user_expire_date" class=" col-form-label col-form-label-sm ">Department</label>
                                        <div class=" col-md-4">
                                            <select class="form-control select2" id="department_name" name="department_name" style="margin:0px!important;">
                                                <option value="">Select Department</option>
                                                @if(isset($dept))
                                                @foreach($dept as $value)
                                                <option value="{{$value->serviceunit_no_pk}}" >{{$value->serviceunit_name}}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <label for="card_no" class=" col-form-label col-form-label-sm ">Card No</label>
                                        <div class=" col-md-2 ">
                                            <input type="text" class="form-control form-control-sm " id="card_no" name="card_no" value="" placeholder="Card no">
                                            <input type="hidden" name="card_hidn" id="card_hidn">

                                        </div>

                                        <div class="col-md-3">
                                        <div class="btn-group btn-block" role="group">
                                        <button type="button" class="btn btn-md btn-md-global btn-success btn-block mt-0"  id="emp_salary_btn" onclick=""> <i class="fas fa-search"></i> Search</button>
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
		<div class="card-header"> Salary Structure list</div>
		<div class="card-body">

				<div class="form-row mt-2">
					<div class="col-md-12 table-responsive" id="daily-late-container">
					@include('admin.reports.hrm.employee_salary_list')
					</div>
				</div>
			</div>
		</div>
		</div>


	</div>
</section>


<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
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

$('.data-table').DataTable( {
		"ordering": false,
		"bPaginate": false,
		"bLengthChange": false,
		"bAutoWidth": false
	} );

	$(document).on("click", "#emp_salary_btn", function(e) {
    var formID = $("#frmSearch").attr("id");
    // var formAction = $("#frmSearch").attr("action");
    var formMethod = $("#frmSearch").attr("method");

    $.ajax({
        data: $('#' + formID).serialize(),
        url:"{{ url('hrm/employee_salary_search') }}",
        type: formMethod,
        beforeSend: function() {
            blockUI();

        },
        success: function(data) {
            $("#daily-late-container").html(data);
        },
        complete: function() {
            $.unblockUI();
        }
    });
});
</script>
