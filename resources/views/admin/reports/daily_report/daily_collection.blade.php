<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

<section id="report_section">
	<div class="container-fluid">
		<div class="row bg-white border-bottom sticky-top shadow-sm">
			<div class="col-md-12 mb-1">
				<h5 class="mt-2 mb-0">Daily Collection Report</h5>
				<small>Report / Daily Collection Report</small>
			</div>
		</div>
		<div class="card">
			<div class="card-header"><h5><i class="fa fa-search"></i> Search Panel</h5></div>
			<div class="card-body pt-2 bg-light">
{{--				<form id="frmFinancialSearch" method="post" action="{{ route('reports.get-daily-report') }}">--}}
{{--					@csrf--}}
{{--					<div class="form-group row">--}}
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
{{--						<div class="col-sm-4">--}}
{{--							<div class="row">--}}
{{--								<div class="col-sm-6" style="margin-right: -30px;">--}}
{{--									<label for="type">From</label>--}}
{{--									<input type="text" class="form-control date_picker" name="date_from" id="date_from" autocomlete="off" placeholder="From Date" />--}}
{{--								</div>--}}
{{--								<div class="col-sm-6">--}}
{{--									<label for="type">To </label>--}}
{{--									<input type="text" class="form-control date_picker" name="date_to" id="date_to" autocomlete="off" placeholder="To Date" />--}}
{{--								</div>--}}
{{--							</div>--}}
{{--                        </div>--}}
{{--						<div class="col-sm-2">--}}
{{--							<label class="mt-4">&nbsp;</label>--}}
{{--							@php $action = route('reports.get-daily-report',['type' => 'Collection']); @endphp--}}
{{--							<button type="button" class="btn btn-success btn-sm" onclick="generateReport(this, 'frmFinancialSearch', '{{ $action }}')">Search</button>--}}

{{--							<label class="mt-4">&nbsp;</label>--}}
{{--							<a href="{{ route('report.daily_report_print',['type' => 'Collection']) }}" title="Print Invoice" target="_blank" class="btn btn-primary btn-sm">Export PDF</a>--}}
{{--						</div>--}}
{{--					</div>--}}
{{--				</form>--}}
                <form id="frmDailyCollectionSearch" method="post" action="{{ route('report.daily_report_print') }}">
                    @csrf
                    <input type="hidden" value="Collection" name="type">
                    <div class="form-group row">
                        <div class="col-md-3">
                            <label for="patient_id">Patient ID </label>
                            <input type="text" class="form-control" name="patient_id" id="patient_id" autocomlete="off" placeholder="Patient ID" />
                            <input type="hidden" class="form-control" id="hdn_patient_id" name="hdn_patient_id" />
                        </div>
                        <div class="col-md-3">
                            <label for="invoice_id">Voucher No</label>
                            <input type="text" class="form-control" name="invoice_id" id="invoice_id" placeholder="Voucher No" autocomlete="off" />
                            <input type="hidden" class="form-control" id="hdn_invoice_id" name="hdn_invoice_id" />
                        </div>
{{--                        <div class="col-md-2">--}}
{{--                            <label for="referral_doctor">Referral Doctors </label>--}}
{{--                            <input type="text" class="form-control" id="first_referral" name="first_referral" placeholder="Doctor Code">--}}
{{--                            <input type="hidden" class="form-control" id="hdn_first_referral_id" name="hdn_first_referral_id" >--}}
{{--                        </div>--}}
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
                            <button type="button" id="daily_collection_search"  class="btn btn-md btn-success mt-4">Search</button>
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
			<div class="card-header "><h5>Daily Collection</h5></div>
			<div class="card-body">
				<div class="row mt-2" id="Daily-collection-list">
					@include('admin.reports.daily_report.daily_report_table')
				</div>
			</div>
		</div>
	</div>
</section>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>

	$(document).ready(function () {
        $(function() {
            $('.date_picker').datepicker({
                todayHighlight: true,
                clearBtn: true,
                autoclose: true,
                format:'dd/mm/yyyy',
                endDate: '+0d',
            });
        });


        $(document).on("click", "#daily_collection_search", function(e) {
            var formID = $("#frmDailyCollectionSearch").attr("id");
            var formMethod = $("#frmDailyCollectionSearch").attr("method");
            $("#frmDailyCollectionSearch").attr('action',"{{ url('/reports/get-daily-report') }}");
            $.ajax({
                data: $('#' + formID).serialize(),
                url:"{{ url('/reports/get-daily-report') }}",
                type: formMethod,
                beforeSend: function() {
                    blockUI();

                },
                success: function(data) {
                    $("#Daily-collection-list").html(data);
                    $("#frmDailyCollectionSearch").attr('action',"{{ route('report.daily_report_print') }}");
                },
                complete: function() {
                    $.unblockUI();
                }
            });
        });


        openPatientAutocomplete('#patient_id');
		openInvoiceAutocomplete('#invoice_id');
		openDoctorAutocomplete('#first_referral', 'hdn_first_referral_id', 'Y');

	});
</script>
