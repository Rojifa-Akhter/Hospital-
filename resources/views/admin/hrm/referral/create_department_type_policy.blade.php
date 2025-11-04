
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css')}}">
<form method="post" action="{{route('referral-survice-unit-type-store')}}" id="ServiceUnitWisePolicy" onsubmit="">
	<input type="hidden" value="{{$refdata->referralpolicy_no_pk}}" name="ref_policy_pk">
	<div class="container-fluid">
		<div class="form-group row">
			<div class="col-md-4">
				<label for="bed_uid" class="">Code</label>
				<div class="">
					<input type="text" class="form-control form-control-sm" id="code" name="code" value="{{$refdata->referralpolicy_code}}" placeholder="Enter Code" disabled>
				</div>
			</div>
			<div class="col-md-4">
				<label for="bed_name" class="">Policy Name </label>
				<div class="">
					<input type="text" class="form-control form-control-sm" id="policy_name" name="policy_name" value="{{$refdata->referralpolicy_name}}" placeholder="Enter Policy Name" disabled>
				</div>
			</div>
			<div class="col-md-4">
				<label for="bed_name" class="">Default Referral </label>
				<div class="row">
					<input type="text" class="form-control form-control-sm col-md-11" id="def_ref" name="def_ref" value=""  ><span class="text-danger">%</span>
				</div>
			</div>
		</div>



		<div class="form-group row">
			<div class="col-md-4">

			</div>
			<div class="col-md-4">

			</div>
			<div class="col-md-4">
				<label for="bed_name" class="">Default Agent </label>
				<div class="row">
					<input type="text" class="form-control form-control-sm col-md-11" id="def_agent" name="def_agent" value=""  ><span class="text-danger">%</span>
				</div>
			</div>
		</div>



		<div class="form-group row">
			<div class="col-md-4">
				<label for="bed_uid" class="">Service Unit </label>
				<div class="">
					<select class="form-control form-control-sm select2" id="su_type" name="su_type" value="">
						 <option value="">Select Service Unit</option>
						@if(!empty($service_unit))
						@foreach($service_unit as $service )
						<option value="{{$service->serviceunit_no_pk}}">

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
			<div class="col-md-4">
				<label for="bed_name" class="">Comission (%) <span class="text-danger">*</span></label>
				<div class="">
					<input type="text" class="form-control form-control-sm" id="comission" name="comission" value="" placeholder="Enter comission" >
				</div>
			</div>
			<div class="col-md-4">
				<label for="bed_name" class="">Default 2nd Referral </label>
				<div class="row">
					<input type="text" class="form-control form-control-sm col-md-11" id="sec_ref" name="sec_ref" value=""  ><span class="text-danger">%</span>
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
