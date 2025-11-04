<div class="card shadow-sm mb-3">
	<div class="card-body d-flex align-items-center px-2 py-2 justify-content-between">
		<div class="d-flex align-items-center">
			<strong class="mr-2">Voucher No.</strong>
			<div class="">
				<input type="text" class="form-control mb-0" id="voucher_no" name="voucher_no" value="" placeholder="Voucher No." style="width: 100%;">
			</div>
		</div>
		<div class="">
			<button type="button" id="details" class="btn btn-md btn-success mx-1">Search</button>
			<button type="reset" class="btn btn-md btn-danger mx-1" onclick="billingEngine.resetBillForm()">Clear</button>
		</div>
	</div>
	<input type="hidden" name="hdn_invoice_id" id="hdn_invoice_id">
</div>