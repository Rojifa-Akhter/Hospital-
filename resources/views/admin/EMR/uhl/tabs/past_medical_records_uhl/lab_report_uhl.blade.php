<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<form id="frmSearch" method="post" action="{{ route('emr.lab-report-search') }}">
	<input type="hidden" value="{{$patient_id}}" class="keep_me" name="patient_id" id="hdn_patient_id">
	@csrf
	<div class="form-row justify-content-center mb-3 mt-3">
		<div class="col-md-3">
			<div class="form-group">
                <label for="invoice_id">Voucher Code</label>
                <input type="text" class="form-control" name="invoice_id" id="invoice_id" placeholder="Voucher No" autocomlete="off" />
                <input type="hidden" class="form-control" id="hdn_invoice_id" name="hdn_invoice_id" />

            </div>
		</div>

		<div class="col-md-3">
			<div class="form-group">
				<label class="col-form-label col-form-label-sm" for="lab_test_name">Test Name</label>
                <input type="text" class="form-control form-control-sm m-0" id="lab_test_name" name="lab_test_name" value="" placeholder="Test Name" required>

            </div>
		</div>


		<div class="col-md-3">
			<div class="form-group">
				<label class="col-form-label col-form-label-sm" for="lab_test_date">Date</label>
				<input type="text" class="form-control form-control-sm m-0 datepicker" id="lab_test_date" name="lab_test_date" value="" placeholder="dd/mm/yyy">
			</div>
		</div>
		<div class="col-md-3">
			<div class="btn-group btn-block" role="group">
				<button type="button" class="btn btn-success btn-block btn-md mt-4" id="labReportSearch"><i class="fa fa-search"></i> Search</button>
				<a rel="tab" href="#" class="btn btn-info btn-block btn-md mt-4"><i class="fa fa-redo"></i> Refresh</a>
			</div>
		</div>
	</div>
</form>

<div class="form-row">
	<div class="col-12 table-responsive" >
		<table class="table table-striped table-bordered table-hover mb-0">
			<thead class="bg-primary">
				<tr>
					<th class="text-center">SL</th>
					<th class="text-center">Date</th>
					{{-- <th class="text-center">Invoice Code</th> --}}
					<th class="text-center">Test Name</th>
					{{-- <th class="text-center">Date</th> --}}
					{{-- <th class="text-center">Admission ID</th> --}}
					{{-- <th class="text-center">Hospital</th> --}}
					 {{-- <th class="text-center">Action</th> --}}
					 <th class="text-center">View Graph</th>
				</tr>
			</thead>
			<tbody id="search_data">
				@include('admin.EMR.uhl.tabs.past_medical_records_uhl.lab_report_data_uhl')
			</tbody>
		</table>
	</div>
</div>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>

<script>
    openInvoiceAutocomplete('#invoice_id');
    openBillingItemAutocomplete("#lab_test_name", "", "",selectItem);
	$('.datepicker').datepicker({
		//format: 'dd-M-yyyy',
		autoclose: true,
		todayBtn: true,
		todayHighlight: true
	});

		$(document).on("click", "#labReportSearch",function(e){
			var formID      = $("#frmSearch").attr("id");
			var formAction  = $("#frmSearch").attr("action");
			var formMethod  = $("#frmSearch").attr("method");
			$.ajax({
				data: $('#'+formID).serialize(),
				url: formAction,
				type: formMethod,
				beforeSend:function(){
					blockUI();

				},
				success: function (data) {
					$("#search_data").html(data);
				},
				complete:function(){
					$.unblockUI();
				}
			});
		});




</script>
