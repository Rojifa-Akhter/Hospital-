<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<section id="report_section">
	<div class="container-fluid">
		<div class="row bg-white border-bottom sticky-top shadow-sm">
			<div class="col-md-12 mb-1">
				<h5 class="mt-2 mb-0">Referral Report Detail</h5>
				<small>Reports / Referral Report Detail</small>
			</div>
		</div>

		<div class="card">
			<div class="card-header"><h5><i class="fa fa-search"></i> Search</h5></div>

			<div class="card-body">
				<form action="{{ route('report.referral-detail-print')}}" id="searchForm" method="post">
					@csrf
					<div class="form-row justify-content-center">

                        <div class="col-md-2">
                            <label for="invoice_id">Voucher No</label>
                            <input type="text" class="form-control" name="invoice_id" id="invoice_id" placeholder="Voucher No" autocomlete="off" />
                            <input type="hidden" class="form-control" id="hdn_invoice_id" name="hdn_invoice_id" />
                        </div>
                        <div class="col-md-2">
                            <label for="referral_doctor">Referral Id </label>
                            <input type="text" class="form-control" id="first_referral" name="first_referral" placeholder="Referral Id">
                            <input type="hidden" class="form-control" id="hdn_first_referral_id" name="hdn_first_referral_id" >
                        </div>
                        <div class="col-md-2">
                            <label for="type">Referral Type</label>
                            <select class="form-control form-control-md" id="type" name="type">
                                <option value="">Select Referral Type</option>
                                <option value="1">Doctor</option>
                                <option value="2">Agent</option>
                                <option value="3">Sales Person</option>
                            </select>
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
							<div class="btn-group btn-block" role="group">
								<button type="button" class="btn btn-md btn-success btn-block mt-4 print" id="referral_search">Search</button>
								<button type="submit" id="ref_data" value="1"  class="btn btn-md btn-primary btn-block mt-4 print"> Export PDF</button>

							</div>
						</div>
					</div>

				</form>
			</div>

		</div>

		<div class="card">
			<div class="card-body p-2">
				<div class="form-row">
					<div class="col-md-12" id="referral_search_data">
						@include('admin.reports.referral_detail_data')
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>

<script type="text/javascript">

     openInvoiceAutocomplete('#invoice_id');
     openDoctorAutocomplete('#first_referral', 'hdn_first_referral_id', 'Y');
	$(document).on("click", "#referral_search", function(e) {
		var formID = $("#searchForm").attr("id");
		var formMethod = $("#searchForm").attr("method");

		$("#searchForm").attr('action',"{{ url('report/referral-wise-search-data') }}");
		$.ajax({
			data: $('#' + formID).serialize(),
			url:"{{ url('report/referral-wise-search-data') }}",
			type: formMethod,
			beforeSend: function() {
				blockUI();

			},
			success: function(data) {
				$("#referral_search_data").html(data);
				$("#searchForm").attr('action',"{{ route('report.referral-detail-print') }}");
			},
			complete: function() {
				$.unblockUI();
			}
		});
	});
        $(document).ready(function () {
            $(function () {
                $('.date_picker').datepicker({
                    todayHighlight: true,
                    format: 'dd/mm/yyyy',
                    clearBtn: true,
                    autoclose: true,
                    endDate: '+0d',
                });
            });
        });


</script>
