
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css')}}">
<form method="post" action="{{route('referral-item-wise-data-store')}}" id="ServiceUnitWisePolicy" onsubmit="">
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
			<div class="col-md-5">
				<label for="bed_name" class="">Policy Name </label>
				<div class="">
					<input type="text" class="form-control form-control-sm" id="policy_name" name="policy_name" value="{{$referralpolicy_name}}" placeholder="Enter Policy Name" disabled>
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
					<input type="text" class="form-control form-control-sm col-md-9" id="def_agent" name="def_agent" value="{{$default_agent_percnet}}"  ><span class="text-danger">%</span>
				</div>
			</div>
		</div>



		<div class="form-group row">
			<div class="col-md-3">

				<label for="bed_uid" class="">Item </label>
				<input type="text" class="form-control form-control-sm" id="item_id" name="item_id" value="{{$item_name}}" placeholder="Entry Item Name"  >
				<input type="hidden" id="item_number" name="item_number">
			</div>
			<div class="col-md-2">

				<label for="rate" class="">Rate </label>
				<input type="text" class="form-control form-control-sm" id="rate" name="rate" value="{{$sales_price}}"  >
			</div>
			<div class="col-md-2">
				<label for="bed_name" class="">Comission (%) </label>
				<div class="">
					<input type="text" class="form-control form-control-sm" id="comission" name="comission" value="{{$commission_percent}}" placeholder="Enter comission" >
				</div>
			</div>
			<div class="col-md-2">

				<label for="comission" class="">TK </label>
				<div class="">
					<input type="text" class="form-control form-control-sm" id="comission" name="comission_tk" value="{{$commission_taka}}" placeholder="Enter comission" >
				</div>

			</div>
			<div class="col-md-3">
				<label for="bed_name" class="">Default 2nd Referral </label>
				<div class="row">
					<input type="text" class="form-control form-control-sm col-md-9" id="sec_ref" name="sec_ref" value="{{$default_2nd_referral_percent}}"  ><span class="text-danger">%</span>
				</div>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-md-4"></div>
			<div class="col-md-4">

				<label for="bed_uid" class="">Exclude </label>
				<input type="text" class="form-control form-control-sm" id="exclude" name="exclude" value="{{$exclude_ind}}" placeholder="Entry Exclude"  >
			</div>
			<div class="col-md-4">

				<label for="rate" class="">Active </label>
				<input type="text" class="form-control form-control-sm" id="active" name="active" value="{{$status}}"  >
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
