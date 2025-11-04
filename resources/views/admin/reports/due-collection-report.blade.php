<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<style>
    .sorting{
		background-image:none !important;
	}
</style>

<section id="report_section">
	<div class="container-fluid">
		<div class="row bg-white border-bottom sticky-top shadow-sm">
			<div class="col-md-12 mb-1">
				<h5 class="mt-2 mb-0">Due Collection Report</h5>
				<small>Report / Due Collection Report</small>
			</div>
		</div>
		<div class="card">
			<div class="card-header "><h5><i class="fa fa-search"></i> Search Panel</h5></div>
			<div class="card-body pt-2 bg-light">
				<form method="post" action="{{ route('due-collection-report-search') }}"  id="frmFinancialSearch">
					@csrf
					<div class="form-group row">
						{{-- <div class="col-md-2">
							<label for="patient_id">Patient ID </label>
							<input type="text" class="form-control" name="patient_id" id="patient_id" autocomlete="off" placeholder="Patient ID" />
							<input type="hidden" class="form-control" id="hdn_patient_id" name="hdn_patient_id" />
						</div> --}}
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="card_no" class=" col-form-label col-form-label-sm">Cashier Name <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm m-0" id="primary_doctor"
                                    name="primary_doctor" maxlength="50" value="" placeholder="Cashier Name" />
                                <input type="hidden" id="doctor_id" name="doctor_id" value="" />
                                <div><strong>
                                        <p id="autocomplete_data"></p>
                                    </strong></div>
                            </div>
                        </div>
						<div class="col-md-3">
							<label for="invoice_id">Voucher No</label>
							<input type="text" class="form-control" name="invoice_id" id="invoice_id" placeholder="Voucher No" autocomlete="off" />
							<input type="hidden" class="form-control" id="hdn_invoice_id" name="hdn_invoice_id" />
						</div>
						{{-- <div class="col-md-2">
							<label for="referral_doctor">Doctor </label>
							<input type="text" class="form-control" id="first_referral" name="first_referral" placeholder="Doctor Code">
							<input type="hidden" class="form-control" id="hdn_first_referral_id" name="hdn_first_referral_id" >
						</div> --}}
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
						<div class="col-md-3 btn-group" style="height: 55px">
                            <button type="button" id="finc_report_search"  class="btn btn-md btn-success mt-4">Search</button>
                            <button type="submit" id="finc_report"  class="btn btn-md btn-primary mt-4 print"> Export PDF</button>

                            {{--							<label class="mt-4">&nbsp;</label>--}}
{{--							@php $action = route('financial-list'); @endphp--}}
{{--							<button type="button" class="btn btn-success btn-md" onclick="generateReport(this, 'frmFinancialSearch', '{{ $action }}')">Search</button>--}}

{{--							<label class="mt-4">&nbsp;</label>--}}
{{--							<a href="{{ route('report.invoice_print') }}" title="Print Invoice" target="_blank" class="btn btn-primary btn-md">Export PDF</a>--}}
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="card">
			<div class="card-header "><h5>Due Collection List</h5></div>
			<div class="card-body">
				<div class="mt-2" id="financial-list-data">
					@include('admin.reports.due-collection-report-table')
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
        openDoctorAutocomplete('#primary_doctor', 'doctor_id');
		openPatientAutocomplete('#patient_id');
		openInvoiceAutocomplete('#invoice_id');
		// openDoctorAutocomplete('#first_referral', 'hdn_first_referral_id', 'Y');




        $(document).on("click", "#finc_report_search", function(e) {
            var formID = $("#frmFinancialSearch").attr("id");
            var formMethod = $("#frmFinancialSearch").attr("method");
            $("#frmFinancialSearch").attr('action',"{{ url('due-collection-report-search') }}");
            $.ajax({
                data: $('#' + formID).serialize(),
                url:"{{ url('due-collection-report-search') }}",
                type: formMethod,
                beforeSend: function() {
                    blockUI();

                },
                success: function(data) {
                    $("#financial-list-data").html(data);
                    $("#frmFinancialSearch").attr('action',"{{ route('reports.due-collection-report-print') }}");
                },
                complete: function() {
                    $.unblockUI();
                }
            });
        });


    });
</script>
