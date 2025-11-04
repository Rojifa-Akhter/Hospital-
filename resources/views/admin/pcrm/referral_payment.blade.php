<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<style>
	.sorting{
		background-image:none !important;
	}
</style>

<section id="report_section">
	<div class="container-fluid">
		<div class="row bg-white border-bottom sticky-top shadow-sm">
			<div class="col-md-12 mb-1">
				<h5 class="mt-2 mb-0">Referral Payment</h5>
				<small>Report / Referral Payment</small>
			</div>
		</div>
		<div class="card">
			<div class="card-header "><h5><i class="fa fa-search"></i> Search Panel</h5></div>
			<div class="card-body pt-2 pb-0">
				<form id="frmPaymentProcess" method="post" action="{{ route('pcrm.referral-payment-process') }}">
					@csrf
					<div class="form-group row justify-content-center">
						<div class="col-sm-5">

							<div class="row">
								<label class="col-sm-4 text-right mt-1" for="type">Date Range</label>
								<div class="col-sm-4" style="margin-right: -30px;">
									<input type="text" class="form-control date_picker" name="date_from" id="date_from" autocomlete="off" placeholder="From" />
								</div>
								<div class="col-sm-4">
									<input type="text" class="form-control date_picker" name="date_to" id="date_to" autocomlete="off" placeholder="To" />
								</div>
							</div>
						</div>
						<div class="col-sm-3">
							@php $action = route('financial-list'); @endphp
							<button type="button" class="btn btn-success btn-md" onclick="pcrmEngine.processPayment(this)"><i class="fa fa-cogs fa-fw"></i> Process</button>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="card">
			<div class="card-header "><h5>Referral Payment List</h5></div>
			<div class="card-body">
				<div class="mt-2" id="payment-list"></div>
			</div>
		</div>
	</div>
</section>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script>
	$(document).ready(function () {
		$('.date_picker').datepicker();
	});

	var pcrmEngine = {
		processPayment: function(thisElement)
		{
			var formID      = $(thisElement).parents("form").attr("id");
			var formAction  = $(thisElement).parents("form").attr("action");
			var formMethod  = $(thisElement).parents("form").attr("method");
			$.ajax({
				url: formAction,
				type: "post",
				beforeSend: function() {
					blockUI();
				},
				success: function (data) {
					$('#appointment-list').html(data);
				},
				complete: function (data) {
					pcrmEngine.loadProcessedPaymentListByDateRange();
					//$.unblockUI();
				}
			});
		},
		loadProcessedPaymentListByDateRange: function()
		{
			$.ajax({
				url: "{{ route('pcrm.referral-payment-list') }}",
				type: "post",
				beforeSend: function() {
					//blockUI();
					$('#payment-list').html('');
				},
				success: function (data) {
					$('#payment-list').html(data);
				},
				complete: function (data) {
					$.unblockUI();
				}

			});
		}
	}
</script>
