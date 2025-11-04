@php

// dd($ItemWiseEditdata);

$ItemWiseEditdata = (isset($ItemWiseEditdata) && (!empty($ItemWiseEditdata))) ? $ItemWiseEditdata : [];

$default_referral_percnet = ($ItemWiseEditdata) ? $ItemWiseEditdata->default_referral_percnet : '';
$refpolicy_itemtype_no_pk = ($ItemWiseEditdata) ? $ItemWiseEditdata->refpolicy_itemtype_no_pk : '';
$default_agent_percnet = ($ItemWiseEditdata) ? $ItemWiseEditdata->default_agent_percnet : '';
$default_2nd_referral_percent = ($ItemWiseEditdata) ? $ItemWiseEditdata->default_2nd_referral_percent : '';
$item_type = ($ItemWiseEditdata) ? $ItemWiseEditdata->item_type : '';
$commission_percent = ($ItemWiseEditdata) ? $ItemWiseEditdata->commission_percent : '';

//refdata
$ref_info= (isset($refdata) && (!empty($refdata))) ? $refdata : [];
$referralpolicy_no_fk = ($ref_info) ? $ref_info->referralpolicy_no_pk : '';
$referralpolicy_code = ($ref_info) ? $ref_info->referralpolicy_code : '';
$referralpolicy_name = ($ref_info) ? $ref_info->referralpolicy_name : '';
 // dd($referralpolicy_no_fk);
@endphp
<form method="post" action="{{route('referral-item-typ-store')}}" id="itemWisePolicy" onsubmit="">
	<input type="hidden" value="{{$referralpolicy_no_fk}}" name="ref_policy_pk">
	<input type="hidden" value="{{$refpolicy_itemtype_no_pk}}" name="item_type_no_pk">
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
		<div class="form-group row">
			<div class="col-md-4">
				<label for="bed_name" class="">Default Referral </label>
				<div class="row">
					<input type="text" class="form-control form-control-sm col-md-10 ml-3" id="sec_ref" name="def_ref" value="{{$default_referral_percnet}}"  ><span class="text-danger">%</span>
				</div>
			</div>
			
			<div class="col-md-4">
				<label for="bed_name" class="">Default Agent </label>
				<div class="row">
					<input type="text" class="form-control form-control-sm col-md-10 ml-3" id="def_agent" name="def_agent" value="{{$default_agent_percnet}}"  ><span class="text-danger">%</span>
				</div>
			</div>
			<div class="col-md-4">
				<label for="bed_name" class="">Default 2nd Referral </label>
				<div class="row">
					<input type="text" class="form-control form-control-sm col-md-10 ml-3" id="sec_ref" name="sec_ref" value="{{$default_2nd_referral_percent}}"  ><span class="text-danger">%</span>
				</div>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-md-6">
				<label for="bed_uid" class="">Item Type </label>
				<div class="">
					<select class="form-control form-control-sm" id="item_type" name="item_type" value="">
						<option value="">Select item Type</option>
						<option value="LAB" @if($item_type == 'LAB') ? selected : null @endif>LAB</option>
						<option value="RAD" @if($item_type == 'RAD') ? selected : null @endif>RAD</option>
						<option value="SUR" @if($item_type == 'SUR') ? selected : null @endif>SUR</option>                              
					</select>
				</div>
			</div>
			<div class="col-md-6">
				<label for="bed_name" class="">Comission (%) </label>
				<div class="">
					<input type="text" class="form-control form-control-sm" id="comission" name="comission" value="{{$commission_percent}}" placeholder="Enter comission" >
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