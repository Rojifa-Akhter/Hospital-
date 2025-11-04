
@php

$item_policy = (isset($item_policy) && (!empty($item_policy))) ? $item_policy : [];

// $default_referral_percnet = ($item_policy) ? $item_policy->default_referral_percnet : '';
$referralpolicy_item_no_pk = ($item_policy) ? $item_policy->referralpolicy_item_no_pk : '';
$default_referral_percnet = ($item_policy) ? $item_policy->default_referral_percnet : '';
$default_2nd_referral_percent = ($item_policy) ? $item_policy->default_2nd_referral_percent : '';
$item_name = ($item_policy) ? $item_policy->item_name : '';
$commission_percent = ($item_policy) ? $item_policy->commission_percent : '';
$commission_taka = ($item_policy) ? $item_policy->commission_taka : '';
$default_agent_percnet = ($item_policy) ? $item_policy->default_agent_percnet : '';
$sales_price = ($item_policy) ? $item_policy->sales_price : '';
$exclude_ind = ($item_policy) ? $item_policy->exclude_ind : '';
$status = ($item_policy) ? $item_policy->status : '';


$refdata = (isset($refdata) && (!empty($refdata))) ? $refdata : [];

$referralpolicy_no_fk = ($refdata) ? $refdata->corporate_policy_no_pk : '';
$referralpolicy_code = ($refdata) ? $refdata->corporatepolicy_code : '';
$referralpolicy_name = ($refdata) ? $refdata->corporatepolicy_name : '';

@endphp
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css')}}">
<form method="post" action="{{route('corporate.item-wise-data-store')}}" id="ServiceUnitWisePolicyCorporate" >
    @csrf
	<input type="hidden" value="{{$referralpolicy_no_fk}}" name="ref_policy_pk" >
	<input type="hidden" value="{{$referralpolicy_item_no_pk}}" name="ref_policy_fk">
	<div class="container-fluid">
		<div class="form-group row">
			<div class="col-md-4">
				<label for="bed_uid" class="">Code</label>
				<div class="">
					<input type="text" class="form-control form-control-sm" id="code" name="code" value="{{$referralpolicy_code}}" placeholder="Enter Code" disabled>
				</div>
			</div>
			<div class="col-md-8">
				<label for="bed_name" class="">Policy Name </label>
				<div class="">
					<input type="text" class="form-control form-control-sm" id="policy_name" name="policy_name" value="{{$referralpolicy_name}}" placeholder="Enter Policy Name" disabled>
				</div>
			</div>

		</div>


		<div class="form-group row ml-0">
			<div class="col-md-4">
				<label for="bed_name" class="">Default Referral </label>
				<div class="row">
					<input type="text" class="form-control form-control-sm col-md-11" id="def_ref" name="def_ref" value="{{$default_referral_percnet}}" maxlength="3" ><span class="text-danger">%</span>
				</div>
			</div>
			<div class="col-md-4">
				<label for="bed_name" class="">Default Agent </label>
				<div class="row">
					<input type="text" class="form-control form-control-sm col-md-11" id="def_agent" name="def_agent" value="{{$default_agent_percnet}}"  maxlength="3"><span class="text-danger">%</span>
				</div>
			</div>
			<div class="col-md-4">
				<label for="bed_name" class="">Default 2nd Referral </label>
				<div class="row">
					<input type="text" class="form-control form-control-sm col-md-11" id="sec_ref" name="sec_ref" value="{{$default_2nd_referral_percent}}" maxlength="3" ><span class="text-danger">%</span>
				</div>
			</div>
		</div>



		<div class="form-group row">
			<div class="col-md-3">

				<label for="bed_uid" class="">Item </label>
				<input type="text" class="form-control form-control-sm" id="item_id_cor" name="item_id" value="{{$item_name}}" placeholder="Entry Item Name"  >
				<input type="hidden" id="hdn_item_number" name="item_number_cor" value="">
			</div>
			<div class="col-md-3">

				<label for="rate" class="">Rate </label>
				<input type="text" class="form-control form-control-sm" id="rate" name="rate" value="{{$sales_price}}"  >
			</div>
			<div class="col-md-3">
				<label for="bed_name" class="">Comission (%) </label>
				<div class="">
					<input type="text" class="form-control form-control-sm" id="comission" onkeyup="onchan(this)" name="comission" value="{{$commission_percent}}" placeholder="Enter comission" >
				</div>
			</div>
			<div class="col-md-3">

				<label for="comission" class="">TK </label>
				<div class="">
					<input type="text" class="form-control form-control-sm" id="comissionTk" name="comission_tk" value="{{$commission_taka}}" placeholder="Enter comission" readonly>
				</div>

			</div>

		</div>
		<div class="form-group row">
			<div class="col-md-6">

				<label for="bed_uid" class="">Exclude </label>
				<input type="text" class="form-control form-control-sm" id="exclude" name="exclude" value="{{$exclude_ind}}" placeholder="Entry Exclude"  >
			</div>
			<div class="col-md-6 mt-4">

				<label for="active" class="">Active </label>
				<input type="checkbox" id="active"  value='1' {{$status == '1' ? 'checked' : '' }} name="active">
			</div>
		</div>





		<div class="ml-1">
			@php
			$response_action = route('corporate.policy');
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
				$('#hdn_item_number').val(item_id);
                console.log(item_id);

			}
			function onchan(thisElement) {
                var comissionPercentage = $('#comission').val();
                var rate = $('#rate').val();
                var comissionTk = (rate * comissionPercentage)/100;
                $('#comissionTk').val(comissionTk);
            }

			openBillingItemAutocomplete("#item_id_cor", "", "", selectItem);
		</script>
