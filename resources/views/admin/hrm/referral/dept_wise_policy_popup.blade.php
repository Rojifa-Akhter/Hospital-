@php

$DeptWiseEditdata = (isset($DeptWiseEditdata) && (!empty($DeptWiseEditdata))) ? $DeptWiseEditdata : [];

$default_referral_percnet = ($DeptWiseEditdata) ? $DeptWiseEditdata->default_referral_percnet : '';
$referralpolicy_su_no_pk = ($DeptWiseEditdata) ? $DeptWiseEditdata->referralpolicy_su_no_pk : '';
$default_agent_percnet = ($DeptWiseEditdata) ? $DeptWiseEditdata->default_agent_percnet : '';
$default_2nd_referral_percent = ($DeptWiseEditdata) ? $DeptWiseEditdata->default_2nd_referral_percent : '';
$su_no_fk = ($DeptWiseEditdata) ? $DeptWiseEditdata->su_no_fk : '';
$commission_percent = ($DeptWiseEditdata) ? $DeptWiseEditdata->commission_percent : '';

$refdata = (isset($refdata) && (!empty($refdata))) ? $refdata : [];
$referralpolicy_no_fk = ($refdata) ? $refdata->referralpolicy_no_pk : '';
$referralpolicy_code = ($refdata) ? $refdata->referralpolicy_code : '';
$referralpolicy_name = ($refdata) ? $refdata->referralpolicy_name : '';

// dd($refdata);
@endphp
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css')}}">
<form method="post" action="{{route('referral-survice-unit-type-store')}}" id="ServiceUnitWisePolicy" onsubmit="">
	<input type="hidden" value="{{$referralpolicy_no_fk}}" name="ref_policy_pk">
	<input type="hidden" value="{{$referralpolicy_su_no_pk}}" name="ref_su_policy_pk">
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



		<div class="form-group row ml-1">
			<div class="col-md-4">
				<label for="bed_name" class="">Default Referral </label>
				<div class="row">
					<input type="text" class="form-control form-control-sm col-md-11" id="def_ref" name="def_ref" value="{{$default_referral_percnet}}"  ><span class="text-danger">%</span>
				</div>
			</div>
			<div class="col-md-4">
				<label for="bed_name" class="">Default Agent </label>
				<div class="row">
					<input type="text" class="form-control form-control-sm col-md-11" id="def_agent" name="def_agent" value="{{$default_agent_percnet}}"  ><span class="text-danger">%</span>
				</div>
			</div>
			<div class="col-md-4">
				<label for="bed_name" class="">Default 2nd Referral </label>
				<div class="row">
					<input type="text" class="form-control form-control-sm col-md-11" id="sec_ref" name="sec_ref" value="{{$default_2nd_referral_percent}}"  ><span class="text-danger">%</span>
				</div>
			</div>
		</div>



		<div class="form-group row">
			<div class="col-md-6">
				<label for="bed_uid" class="">Service Unit </label>
				<div class="">
					<select class="form-control form-control-sm select2" id="su_type" name="su_type" value="">
						<option value="0">Select Service unit</option>
						@if(!empty($service_unit))
						@foreach($service_unit as $service )
						<option value="{{$service->serviceunit_no_pk}}">
							@if($service->serviceunit_no_pk == $su_no_fk) selected
							@endif
							{{strtoupper($service->serviceunit_name)}}
						</option>
						@endforeach
						@endif

						{{-- @if(!empty($service_unit))
						@foreach($service_unit as $service )
						<option value="{{$service->serviceunit_no_pk}}"
							@if($service->serviceunit_no_pk == $serviceunit_no_pk) selected
							@endif>
							{{strtoupper($service->serviceunit_name)}}
						</option>
						@endforeach
						@endif    --}}
					</select>
				</div>
			</div>
			<div class="col-md-6">
				<label for="bed_name" class="">Comission (%) <span class="text-danger">*</span></label>
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




		<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js')}}"></script>
		<script>
			$('.select2').select2({});
		</script>
