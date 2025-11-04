@php

$item_policy = (isset($item_policy) && (!empty($item_policy))) ? $item_policy : [];

$default_referral_percnet = ($item_policy) ? $item_policy->default_referral_percnet : '';
$referralpolicy_item_no_pk = ($item_policy) ? $item_policy->referralpolicy_item_no_pk : '';
$default_agent_percnet = ($item_policy) ? $item_policy->default_agent_percnet : '';
$default_2nd_referral_percent = ($item_policy) ? $item_policy->default_2nd_referral_percent : '';
$commission_percent = ($item_policy) ? $item_policy->commission_percent : '';
$commission_taka = ($item_policy) ? $item_policy->commission_taka : '';
$item_name = ($item_policy) ? $item_policy->item_name : '';
$sales_price = ($item_policy) ? $item_policy->sales_price : '';
$referralpolicy_no_fk = ($item_policy) ? $item_policy->referralpolicy_no_fk : '';
$referralpolicy_code = ($item_policy) ? $item_policy->referralpolicy_code : '';
$referralpolicy_name = ($item_policy) ? $item_policy->referralpolicy_name : '';

// dd($refdata);
@endphp
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css')}}">
<form method="post" action="{{route('referral-item-wise-data-store')}}" id="ServiceUnitWisePolicy" onsubmit="">
	<input type="hidden" value="{{$refdata->referralpolicy_no_pk}}" name="ref_policy_pk">
	<div class="container-fluid">
		<div class="form-group row">
			<div class="col-md-4">
				<label for="bed_uid" class="">Code</label>
				<div class="">
					<input type="text" class="form-control form-control-sm" id="code" name="code" value="{{$refdata->referralpolicy_code}}" placeholder="Enter Code" disabled>
				</div>
			</div>
			<div class="col-md-5">
				<label for="bed_name" class="">Policy Name </label>
				<div class="">
					<input type="text" class="form-control form-control-sm" id="policy_name" name="policy_name" value="{{$refdata->referralpolicy_name}}" placeholder="Enter Policy Name" disabled>
				</div>
			</div>
			<div class="col-md-3">

				<label for="bed_name" class="">Default Referral </label>
				<div class="row">
					<input type="text" class="form-control form-control-sm col-md-9" id="def_ref" name="def_ref" value=""  ><span class="text-danger">%</span>
				</div>
			</div>
		</div>



		<div class="form-group row">
			<div class="col-md-4">

			</div>
			<div class="col-md-5">

			</div>
			<div class="col-md-3">
				<label for="bed_name" class="">Default Agent </label>
				<div class="row">
					<input type="text" class="form-control form-control-sm col-md-9" id="def_agent" name="def_agent" value=""  ><span class="text-danger">%</span>
				</div>
			</div>
		</div>



		<div class="form-group row">
			<div class="col-md-3">

				<label for="bed_uid" class="">Item </label>
				<input type="text" class="form-control form-control-sm" id="item_id" name="item_id" value="" placeholder="Entry Item Name"  >
				<input type="hidden" id="item_number" name="item_number">
			</div>
			<div class="col-md-2">

				<label for="rate" class="">Rate </label>
				<input type="text" class="form-control form-control-sm" id="rate" name="rate" value="Enter item rate"  >
			</div>
			<div class="col-md-2">
				<label for="bed_name" class="">Comission (%) </label>
				<div class="">
					<input type="text" class="form-control form-control-sm" id="comission" name="comission" value="" placeholder="Enter comission" >
				</div>
			</div>
			<div class="col-md-2">

				<label for="comission" class="">TK </label>
				<div class="">
					<input type="text" class="form-control form-control-sm" id="comission" name="comission_tk" value="" placeholder="Enter comission" >
				</div>

			</div>
			<div class="col-md-3">
				<label for="bed_name" class="">Default 2nd Referral </label>
				<div class="row">
					<input type="text" class="form-control form-control-sm col-md-9" id="sec_ref" name="sec_ref" value=""  ><span class="text-danger">%</span>
				</div>
			</div>
		</div>





		<div class="ml-1">
			@php
			$response_action = route('referral-policy-configaration');
			@endphp
			<button class="btn btn-success btn-md" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')"> Save</button>
			<button type="reset" class="btn btn-info btn-md" title="Click here to Clear form data">Clear</button>
			<a href="" class="btn btn-danger btn-md" rel="tab" title="Click here to go back to Dashboard">Exit</a>
		</form>




		<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js')}}"></script>
		<script>
			$('.select2').select2({});


			function selectItem(item, obj)
			{
				var total = item.item_rate;
				var item_id = item.item_id;
				$('#rate').val(total);
				$('#item_number').val(item_id);

			}
			openBillingItemAutocomplete("#item_id", "", "", selectItem);
		</script>
