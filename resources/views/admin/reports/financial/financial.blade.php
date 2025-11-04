<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<style>
	.sorting {
		background-image: none !important;
	}
    .sticky_header {
        position: sticky;
        top: 90px;
    }

</style>

<section id="report_section">
	<div class="container-fluid">
		<div class="row bg-white border-bottom sticky-top shadow-sm">
			<div class="col-md-12 mb-1">
				<h5 class="mt-2 mb-0">Financial Report</h5>
				<small>Report / Financial Report</small>
			</div>
		</div>
		<div class="card">
			<div class="card-header ">
				<h5><i class="fa fa-search"></i> Search Panel</h5>
			</div>
			<div class="card-body pt-2 bg-light">
				<form method="post" action="{{ route('financial-list') }}" id="frmFinancialSearch">
					@csrf
					<div class="form-group row">
						<div class="col-md-2">
							<label for="patient_id">Patient ID </label>
							<input type="text" class="form-control" name="patient_id" id="patient_id" autocomlete="off" placeholder="Patient ID" />
							<input type="hidden" class="form-control" id="hdn_patient_id" name="hdn_patient_id" />
						</div>
						<div class="col-md-2">
							<label for="invoice_id">Voucher No</label>
							<input type="text" class="form-control" name="invoice_id" id="invoice_id" placeholder="Voucher No" autocomlete="off" />
							<input type="hidden" class="form-control" id="hdn_invoice_id" name="hdn_invoice_id" />
						</div>
						<div class="col-md-2">
							<label for="referral_doctor">Doctor </label>
							<input type="text" class="form-control" id="first_referral" name="first_referral" placeholder="Doctor Code">
							<input type="hidden" class="form-control" id="hdn_first_referral_id" name="hdn_first_referral_id">
						</div>
						<div class="col-md-3">
							<div class="row">
								<div class="col-md-6" style="margin-right: -30px;">
									<label for="type">From</label>
									<input type="text" class="form-control date_picker" name="date_from" value="" id="date_from" placeholder="From Date" autocomplete="off"/>
								</div>
								<div class="col-md-6">
									<label for="type">To </label>
									<input type="text" class="form-control date_picker" name="date_to" value="" id="date_to" autocomplete="off" placeholder="To Date" />
								</div>
							</div>
						</div>
						<div class="col-md-3 btn-group">
							<button type="button" id="finc_report_search" class="btn btn-md btn-success mt-4">Search</button>
							<button type="submit" id="finc_report" class="btn btn-md btn-primary mt-4 print"> Export PDF</button>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="card">
			<div class="card-header ">
				<h5>Financial Details List</h5>
			</div>
			<div class="card-body">
				<div class="mt-2" id="financial-list-data">
					@include('admin.reports.financial.financial_table')
				</div>
			</div>
		</div>
	</div>
</section>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
	$(document).ready(function() {
		$(function() {
			$('.date_picker').datepicker({
				todayHighlight: true,
				format: 'dd/mm/yyyy',
				clearBtn: true,
				autoclose: true,
				endDate: '+0d',
			});
		});

		$("#sidebar-left").addClass("active");
		$("#content").addClass("active");

		openPatientAutocomplete('#patient_id');
		openInvoiceAutocomplete('#invoice_id');
		openDoctorAutocomplete('#first_referral', 'hdn_first_referral_id', 'Y');




		$(document).on("click", "#finc_report_search", function(e) {
			var formID = $("#frmFinancialSearch").attr("id");
			var formMethod = $("#frmFinancialSearch").attr("method");
			$("#frmFinancialSearch").attr('action', "{{ url('financial-list') }}");
			$.ajax({
				data: $('#' + formID).serialize(),
				url: "{{ url('financial-list') }}",
				type: formMethod,
				beforeSend: function() {
					blockUI();

				},
				success: function(data) {
					$("#financial-list-data").html(data);
					$("#frmFinancialSearch").attr('action', "{{ route('report.invoice_print') }}");
				},
				complete: function() {
					$.unblockUI();
				}
			});
		});


	});
</script>