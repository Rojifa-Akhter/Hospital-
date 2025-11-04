<form method="post" id="frm-result-search" action="" action="">
	@csrf

	<div class="form-row">
		<div class="col-4">
			<div class="form-group">
				<label for="voucher_no" class="col-form-label col-form-label-sm">Invoice No</label>
				<input class="form-control form-control-sm" type="text" id="voucher_no" name="voucher_no" value="" placeholder="Invoice No">
			</div>
		</div>
		{{-- <div class="col-4">
			<div class="form-group">
				<label for="lab_no" class="col-form-label col-form-label-sm">Lab No</label>
				<input class="form-control form-control-sm" type="text" id="lab_no" name="lab_no" value="" placeholder="Lab No">
			</div>
		</div> --}}
		<div class="col-4">
			<input type="hidden" name="hdn_operation" value="">
			<input type="hidden" name="hdn_type" value="">
			<button type="button" class="btn btn-md btn-success mt-4 btn-md-global" onclick="searchInvestigationCancel(this)"> <i class="fa fa-search mr-1"></i> Search</button>
		</div>
	</div>

</form>
