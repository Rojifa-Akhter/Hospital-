
@php
$hk_clear_ind = isset($bill_info_details->hk_clear_ind)?$bill_info_details->hk_clear_ind : "0";
$phr_clear_ind = isset($bill_info_details->phr_clear_ind)?$bill_info_details->phr_clear_ind : "0";
$cafeteria_clear_ind =isset($bill_info_details->cafeteria_clear_ind)?$bill_info_details->cafeteria_clear_ind : "0";
$dk_clear_ind = isset($bill_info_details->dk_clear_ind)?$bill_info_details->dk_clear_ind : "0";
$fin_clear_ind = isset($bill_info_details->fin_clear_ind)?$bill_info_details->fin_clear_ind : "0";
@endphp

<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<form action="{{ route('ipd.update-financial-clearence') }}" method="post" id="financial-clearence-form">
	@csrf


	<input type="hidden" name="hdn_admission_id" value="{{ isset($bill_info_details->admission_no_pk)? $bill_info_details->admission_no_pk : 0 }}">
	<div class=" form-row">
		<div class="col-md-6">
			<div class="form-group">
				<label for="grantuser_department" class="col-form-label col-form-label-sm">Bills <span class="text-danger"></span></label>
				<input type="text" class="form-control  form-group" placeholder="0.00" name="bill" value="{{ isset($bill_info->ledger_amt_sales)? number_format($bill_info->ledger_amt_sales,2) : 0.00 }}">
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label for="grantuser_user" class=" col-form-label col-form-label-sm" >Discount <span class="text-danger"></span></label>
				<input type="text" class="form-control form-group" placeholder="0.00" name="discount" value="{{ isset($bill_info->ledger_amt_discount)? number_format($bill_info->ledger_amt_discount,2) : 0.00 }}">
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label for="grantuser_user" class=" col-form-label col-form-label-sm">Payable <span class="text-danger"></span></label>

				<input type="text" class="form-control " placeholder="0.00" name="payable" value="{{ isset($bill_info->ledger_amt_payable)? number_format($bill_info->ledger_amt_payable,2) : 0.00 }}">

			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label for="grantuser_user" class=" col-form-label col-form-label-sm">Paid <span class="text-danger"></span></label>

				<input type="text" class="form-control " placeholder="0.00" name="paid" value="{{ isset($bill_info->paid_amount)? number_format($bill_info->paid_amount,2) : 0.00 }}">

			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label for="grantuser_user" class=" col-form-label col-form-label-sm">Due/Refund
					<span class="text-danger"></span></label>

					<input type="text" class="form-control " placeholder="0.00" name="due_refund" value="{{ isset($bill_info->advance_due)? abs($bill_info->advance_due) : 0.00 }}">

				</div>
			</div>
		</div>
		<div class="form-row">
			<div class="col-sm-6">
				<div class="form-group form-check form-check-inline">
					<input class="form-check-input" type="checkbox" name="house_keeping_clr_ind"
					id="house_keeping_clr_ind" value="1" {{ ($hk_clear_ind==1)? "checked" : ""  }} >
					<label class="form-check-label" for="house_keeping_clr_ind">House Keeping Clearance
					</label>
				</div>
			</div>
			<div class="col-sm-6   ">
				<div class="form-group form-check form-check-inline">
					<input class="form-check-input" type="checkbox" name="food_service_clr_ind"
					id="food_service_clr_ind" value="1"  {{ ($dk_clear_ind==1)? "checked" : ""  }} >
					<label class="form-check-label" for="food_service_clr_ind">Food Service Clearance

					</label>
				</div>
			</div>
			<div class="col-sm-6   ">
				<div class="form-group form-check form-check-inline">
					<input class="form-check-input" type="checkbox" name="cafetaria_clr"
					id="cafetaria_clr" value="1"  {{ ($cafeteria_clear_ind==1)? "checked" : ""  }} >
					<label class="form-check-label" for="cafetaria_clr">Cafetaria Clearance

					</label>
				</div>
			</div>
			<div class="col-sm-6   ">
				<div class="form-group form-check form-check-inline">
					<input class="form-check-input" type="checkbox" name="pharmacy_clr"
					id="pharmacy_clr" value="1"  {{ ($phr_clear_ind==1)? "checked" : ""  }} >
					<label class="form-check-label" for="pharmacy_clr">Pharmacy Clearance

					</label>
				</div>
			</div>
			<div class="col-sm-6   ">
				<div class="form-group form-check form-check-inline">
					<input class="form-check-input" type="checkbox" name="financial_clr"
					id="financial_clr" value="1"  {{ ($fin_clear_ind==1)? "checked" : ""  }} >
					<label class="form-check-label" for="financial_clr">Financial Clearance

					</label>
				</div>
			</div>

			<div class="col-sm-12 text-center" >
				<a href="{{ route('ipd.ipd-payment', $bill_info_details->admission_no_pk ) }}" class="btn btn-success btn-md" rel="tab" data-dismiss="modal">Payment/Refund
				</a>
			</div>
		</div>






		<div class="modal-footer pl-0">
			@php
			$response_action = route('idp.ipd-business-office');
			@endphp
			<button class="btn btn-success btn-md"
			onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">
			Final Clearance
		</button>

		<button type="reset" class="btn btn-info btn-md" title="Click here to Clear form data">Clear</button>
		<a href="{{ route('idp.ipd-business-office') }}" type="reset" class="btn btn-danger btn-md"
		title="Click here to Clear form data">Exit</a>

	</div>
</form>


<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
    // getDropdownListByCondition("#","","");
    $('.select2').select2({});

</script>
