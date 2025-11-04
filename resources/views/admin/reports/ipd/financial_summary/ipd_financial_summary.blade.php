<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<style>
	.sorting{
		background-image:none !important;
	}
</style>
<section id="full_appointment">
	<div class="container-fluid">
		<div class="row bg-white border-bottom sticky-top shadow-sm">
			<div class="col-md-12 mb-1">
				<h5 class="mt-2 mb-0">Ipd Financial Summary Report</h5>
				<small>Report / Ipd Financial Summary Report</small>
			</div>
		</div>
		<div class="card">
			<div class="card-header "><h5><i class="fa fa-search"></i> Search Panel</h5></div>
			<div class="card-body pt-2">
				<form id="ipdFrmFinancialSummarySearch" method="post" action="{{ route('report.financial_summary_print_ipd') }}">
					@csrf
					<div class="form-row justify-content-center">
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
                            <button type="button" id="ipdFinc_summary_search"  class="btn btn-md btn-success mt-4 btn-md-global">Search</button>
                            <button type="submit" id="finc_report"  class="btn btn-md btn-primary mt-4 print btn-md-global"> Export PDF</button>

                        </div>
					</div>
				</form>
			</div>
		</div>
		<div class="card">
			<div class="card-header "><h5>Financial Summary Report</h5></div>

			<div class="card-body">
				<div class="row mt-2" id="ipd-financial-summary-list">
					@include('admin.reports.ipd.financial_summary.ipd_financial_summary_table')
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
    $(document).on("click", "#ipdFinc_summary_search", function(e) {
        var formID = $("#ipdFrmFinancialSummarySearch").attr("id");
        var formMethod = $("#ipdFrmFinancialSummarySearch").attr("method");
        $("#ipdFrmFinancialSummarySearch").attr('action',"{{ url('/reports/get-financial/ipd/summary') }}");
        $.ajax({
            data: $('#' + formID).serialize(),
            url:"{{ url('/reports/get-financial/ipd/summary') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $("#ipd-financial-summary-list").html(data);
                $("#ipdFrmFinancialSummarySearch").attr('action',"{{ route('report.financial_summary_print_ipd') }}");
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });
</script>
