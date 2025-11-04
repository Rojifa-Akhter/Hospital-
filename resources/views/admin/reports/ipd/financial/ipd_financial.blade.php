<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<style>
    .sorting{
		background-image:none !important;
	}
</style>

<section id="report_section">
	<div class="container-fluid">
		<div class="row bg-white border-bottom sticky-top shadow-sm">
			<div class="col-md-12 mb-1">
				<h5 class="mt-2 mb-0">Ipd Financial Report</h5>
				<small>Report / Ipd Financial Report</small>
			</div>
		</div>
		<div class="card">
			<div class="card-header "><h5><i class="fa fa-search"></i> Search Panel</h5></div>
			<div class="card-body pt-2 bg-light">
				<form id="frmIpdFinancialSearch" method="post" action="{{ route('financial-list-ipd') }}">
					@csrf
					<div class="form-group row">
						<div class="col-md-3">
							<label for="patient_id">Patient ID </label>
							<input type="text" class="form-control" name="patient_id" id="patient_id" autocomlete="off" placeholder="Patient ID" />
							<input type="hidden" class="form-control" id="hdn_patient_id" name="hdn_patient_id" />
						</div>
{{--						<div class="col-md-2">--}}
{{--							<label for="invoice_id">Voucher No</label>--}}
{{--							<input type="text" class="form-control" name="invoice_id" id="invoice_id" placeholder="Voucher No" autocomlete="off" />--}}
{{--							<input type="hidden" class="form-control" id="hdn_invoice_id" name="hdn_invoice_id" />--}}
{{--						</div>--}}
						<div class="col-md-3">
							<label for="referral_doctor">Doctor </label>
							<input type="text" class="form-control" id="first_referral" name="first_referral" placeholder="Doctor Code">
							<input type="hidden" class="form-control" id="hdn_first_referral_id" name="hdn_first_referral_id" >
						</div>
						<div class="col-md-3">
							<div class="row">
								<div class="col-md-6" style="margin-right: -30px;">
									<label for="type">From</label>
									<input type="text" class="form-control date_picker" name="date_from" value="" id="date_from" autocomlete="off" placeholder="From Date" />
								</div>
								<div class="col-md-6">
									<label for="type">To </label>
									<input type="text" class="form-control date_picker" name="date_to" value="" id="date_to" autocomlete="off" placeholder="To Date" />
								</div>
							</div>
                        </div>
						<div class="col-md-3">
                            <button type="button" id="finc_report_search"  class="btn btn-md btn-success mt-4 btn-md-global">Search</button>
                            <button type="submit" id="finc_report"  class="btn btn-md btn-primary mt-4 print btn-md-global"> Export PDF</button>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="card">
			<div class="card-header "><h5>Ipd Financial Details List</h5></div>
			<div class="card-body">
				<div class="mt-2" id="ipd-financial-list">
					@include('admin.reports.ipd.financial.ipd_financial_table')
				</div>
			</div>
		</div>
	</div>
</section>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>

	$(document).ready(function () {
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
            var formID = $("#frmIpdFinancialSearch").attr("id");
            var formMethod = $("#frmIpdFinancialSearch").attr("method");
            $("#frmIpdFinancialSearch").attr('action',"{{ url('financial-list-ipd') }}");
            $.ajax({
                data: $('#' + formID).serialize(),
                url:"{{ url('financial-list-ipd') }}",
                type: formMethod,
                beforeSend: function() {
                    blockUI();

                },
                success: function(data) {
                    $("#ipd-financial-list").html(data);
                    $("#frmIpdFinancialSearch").attr('action',"{{ route('report.invoice_print_ipd') }}");
                },
                complete: function() {
                    $.unblockUI();
                }
            });
        });


    });
</script>
