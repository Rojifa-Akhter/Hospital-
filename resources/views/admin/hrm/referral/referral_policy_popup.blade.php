@php

$refdata = (isset($refdata) && (!empty($refdata))) ? $refdata : [];

$referralpolicy_code = ($refdata) ? $refdata->referralpolicy_code : '';
$referralpolicy_no_pk = ($refdata) ? $refdata->referralpolicy_no_pk : '';
$referralpolicy_name = ($refdata) ? $refdata->referralpolicy_name : '';
$default_ref_percnet = ($refdata) ? $refdata->default_ref_percnet : '';
$default_agent_percnet = ($refdata) ? $refdata->default_agent_percnet : '';
$default_2nd_ref_percent = ($refdata) ? $refdata->default_2nd_ref_percent : '';

$applied_to_agent_ind = ($refdata) ? $refdata->applied_to_agent_ind : '';
$applied_to_ref_doctor_ind = ($refdata) ? $refdata->applied_to_ref_doctor_ind : '';
$applied_to_seconnd_ref_ind = ($refdata) ? $refdata->applied_to_seconnd_ref_ind : '';
$status = ($refdata) ? $refdata->status : '';
// dd($refdata);
@endphp
<form method="post" action="{{route('referral_doctor_store')}}" id="popUp" onsubmit="">
	<div class="container-fluid">
		<input type="hidden" value="{{$referralpolicy_no_pk}}" name="hdn_ref">





		<div class="form-group row">
			<div class="col-md-6">
				<label for="code" class="col-form-label">Code <span>*</span></label>
				<div class="">
					<input type="text" class="form-control" id="code" name="code" placeholder="Enter Refrral Code" value="{{$referralpolicy_code}}" required>
				</div>
			</div>
			<div class="col-md-6">
				<label for="policy_name" class="col-form-label">Policy Name <span>*</span></label>
				<div class="">
					<input type="text" class="form-control bg-light" id="policy_name" name="referralpolicy_name" value="{{$referralpolicy_name}}" placeholder="Enter Policy Name" required />
				</div>
			</div>
		</div>



	</div>


	<div class="ml-2 mr-2 form-row">
		<div class="form-group col-md-4">
			<label class="col-form-label">Referral Doctor</label>
			<div class="input-group mb-3">
				<div class="input-group-prepend">
					<div class="input-group-text">
						<input type="checkbox" id="doc_ref" aria-label="Checkbox for following text input" name="def_ref" value='1' {{ $applied_to_ref_doctor_ind == '1' ? 'checked' : '' }} >
					</div>
				</div>
				<input type="text" name="doc_ref" class="form-control number_only doc_ref" value="{{$default_ref_percnet}}" id = 'def_doc' aria-label="Text input with checkbox" >
			</div>
		</div>

		<div class="form-group col-md-4">
			<label class="col-form-label">Agent</label>
			<div class="input-group mb-3">
				<div class="input-group-prepend">
					<div class="input-group-text">
						<input type="checkbox" id="agent_ref" aria-label="Checkbox for following text input" value='1' {{ $applied_to_agent_ind == '1' ? 'checked' : '' }} name="agent_ref">
					</div>
				</div>
				<input type="text" class="form-control number_only agent_ref" value="{{$default_agent_percnet}}" name="def_agent" aria-label="Text input with checkbox">
			</div>
		</div>


		<div class="form-group col-md-4">
			<label class="col-form-label">2nd Referral</label>
			<div class="input-group mb-3">
				<div class="input-group-prepend">
					<div class="input-group-text">
						<input type="checkbox" id="sec_ref" aria-label="Checkbox for following text input" value='1' {{ $applied_to_seconnd_ref_ind == '1' ? 'checked' : '' }} name="def_2nd_ref">
					</div>
				</div>
				<input type="text" class="form-control number_only sec_ref" name="second_referral" aria-label="Text input with checkbox" value="{{$default_2nd_ref_percent}}">
			</div>
		</div>
		<div class="form-group col-md-3">
			<div class="row ml-2 mb-2">
				<div class="check mt-1">
					<input type="checkbox"id='active_ref' name="active"  value='1'  {{ $status == '1' ? 'checked' : '' }} >
				</div>
				<label class="col-form-label  ml-1" for="active_ref">Active  </label>				
			</div>			
		</div>
		


	</div>

	<div class="ml-3">
		@php
		$response_action = route('referral-policy-configaration');
		@endphp
		<button class="btn btn-success btn-md" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')"> Save</button>
		<button type="reset" class="btn btn-info btn-md" title="Click here to Clear form data">Clear</button>
		<a href="" class="btn btn-danger btn-md" rel="tab" title="Click here to go back to Dashboard">Exit</a>
	</div>
</form>