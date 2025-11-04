<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<style>
	.sorting{
		background-image:none !important;
	}
</style>
<section id="full_appointment">
	<div class="container-fluid">
		<div class="row bg-white border-bottom sticky-top shadow-sm">
			<div class="col-md-12 mb-1">
				<h5 class="mt-2 mb-0">Pharmacy Financial Summary Report</h5>
				<small>Report / Pharmacy Financial Summary Report</small>
			</div>
		</div>
		<div class="card">
			<div class="card-header "><h5><i class="fa fa-search"></i> Search Panel</h5></div>
			<div class="card-body pt-2">
				<form id="frmFinancialSummarySearch" method="post" action="{{ route('report.pharmacy-financial_summary_print') }}">
					@csrf
					<div class="form-row justify-content-center">
{{--						<div class="col-sm-2">--}}
{{--							<label for="patient_id">Patient ID </label>--}}
{{--							<input type="text" class="form-control" name="patient_id" id="patient_id" autocomlete="off" placeholder="Patient ID" />--}}
{{--							<input type="hidden" class="form-control" id="hdn_patient_id" name="hdn_patient_id" />--}}
{{--						</div>--}}
{{--						<div class="col-sm-2">--}}
{{--							<label for="invoice_id">Voucher No</label>--}}
{{--							<input type="text" class="form-control" name="invoice_id" id="invoice_id" placeholder="Voucher No" autocomlete="off" />--}}
{{--							<input type="hidden" class="form-control" id="hdn_invoice_id" name="hdn_invoice_id" />--}}
{{--						</div>--}}
{{--						<div class="col-sm-2">--}}
{{--							<label for="referral_doctor">Referral Doctors </label>--}}
{{--							<input type="text" class="form-control" id="first_referral" name="first_referral" placeholder="Doctor Code">--}}
{{--							<input type="hidden" class="form-control" id="hdn_first_referral_id" name="hdn_first_referral_id" >--}}
{{--						</div>--}}
{{--						<div class="col-sm-2">--}}
{{--							<label for="type">Type </label>--}}
{{--							<select class="form-control form-control-sm" id="type" name="type">--}}
{{--								<option value="0">Type</option>--}}
{{--								<option value="">Type 1</option>--}}
{{--								<option value="">Type 2</option>--}}
{{--							</select>--}}
{{--						</div>--}}
{{--						<div class="col-sm-4">--}}
{{--							<div class="row">--}}
{{--								<label for="type">Date</label>--}}
{{--								<div class="input-group">--}}
{{--									<input type="text" class="form-control date_picker" name="date_from" id="date_from" autocomlete="off" placeholder="From" />--}}

{{--									<label for="type"></label>--}}
{{--									<input type="text" class="form-control date_picker" name="date_to" id="date_to" autocomlete="off" placeholder="To" />--}}
{{--								</div>--}}
{{--							</div>--}}
{{--						</div>--}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-form-label col-form-label-sm" for="search_date_from">Date</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">From</div>
                                    </div>
                                    <input type="text" class="form-control form-control-sm m-0 date_picker" id="search_date_from" name="date_from" value="" placeholder="dd/mm/yyyy" autocomplete="off">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">To</div>
                                    </div>
                                    <input type="text" class="form-control form-control-sm m-0 date_picker" id="search_date_to" name="date_to" value="" placeholder="dd/mm/yyyy" autocomplete="off">
                                </div>
                            </div>
                        </div>
						<div class="col-md-3">
                            <button type="button" id="finc_summary_search"  class="btn btn-md btn-success mt-4">Search</button>
                            <button type="submit" id="finc_report"  class="btn btn-md btn-primary mt-4 print"> Export PDF</button>

                            {{--							<label class="mt-4">&nbsp;</label>--}}
{{--							@php $action = route('reports.get-financial'); @endphp--}}
{{--							<button type="button" class="btn btn-success btn-md" onclick="generateReport(this, 'frmFinancialSummarySearch', '{{ $action }}')">Search</button>--}}

{{--							<label class="mt-4">&nbsp;</label>--}}
{{--							<a href="{{ route('report.financial_summary_print') }}" title="Print Financial Summary" target="_blank" class="btn btn-primary btn-md">Export PDF</a>--}}
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="card">
			<div class="card-header "><h5>Pharmacy Financial Summary Report</h5></div>

			<div class="card-body">
				<div class="row mt-2" id="pharmacy-financial-summary-list">
					@include('admin.reports.pharmacy.financial_summary_table')
				</div>
			</div>
		</div>
	</div>
</section>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
	$(document).ready(function () {

		openPatientAutocomplete('#patient_id');
		openInvoiceAutocomplete('#invoice_id');
		openDoctorAutocomplete('#first_referral', 'hdn_first_referral_id', 'Y');
	});
    $(function() {
        $('.date_picker').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            endDate: '+0d',
            format: 'dd/mm/yyyy',
        });
    });
    $(document).on("click", "#finc_summary_search", function(e) {
        var formID = $("#frmFinancialSummarySearch").attr("id");
        var formMethod = $("#frmFinancialSummarySearch").attr("method");
        $("#frmFinancialSummarySearch").attr('action',"{{ url('reports/pharmacy/financial-summary/data') }}");
        $.ajax({
            data: $('#' + formID).serialize(),
            url:"{{ url('reports/pharmacy/financial-summary/data') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $("#pharmacy-financial-summary-list").html(data);
                $("#frmFinancialSummarySearch").attr('action',"{{ route('report.pharmacy-financial_summary_print') }}");
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });
</script>
