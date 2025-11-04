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
{{-- <form method="post" action="{{route('referral_doctor_store')}}" id="popUp" onsubmit="">
    <div class="container-fluid">
    	<input type="hidden" value="{{$referralpolicy_no_pk}}" name="hdn_ref"> --}}



	        {{-- <div class="row ml-1">
	          <div class="col-md-3">
	            <div class="form-group row">
	              <label for="txtPolicy" class="col-form-label">Code <span>*</span></label>
	              <div class="col-sm-9">
	                <input type="text" class="form-control number_only" id="code" name="code" placeholder="Enter Refrral Code" value="{{$referralpolicy_code}}" required>
	              </div>
	            </div>
	          </div>
	          <div class="col-md-9">
	            <div class="form-group row">
	              <label for="txtItem" class="col-form-label col-md-2">Policy Name <span>*</span></label>
	              <div class="col-sm-10">
	                <input type="text" class="form-control bg-light" id="discount_name" name="discount_name" value="{{$referralpolicy_name}}" placeholder="Enter Policy Name" required />
	              </div>
	            </div>
	          </div>
	        </div>
	          <label class="mb-1 text-primary">Applied To</label>
	          <div class="border rounded mb-2 bg-light">

	            <div class="row">

	              <div class="col-sm border-right">
	                <div class="ml-2 form-row">
	                  <div class="form-group col-md-9">
	                    <label>Referral Doctor</label>
	                    <div class="input-group mb-3">
	                      <div class="input-group-prepend">
	                        <div class="input-group-text">
	                          <input type="checkbox" value="{{$default_ref_percnet}}" id="doc_ref" aria-label="Checkbox for following text input" >
	                        </div>
	                      </div>
	                      <input type="text" name="ref_doc" class="form-control number_only doc_ref" value="" id = 'ref_doc' aria-label="Text input with checkbox">
	                    </div>
	                  </div>

	                </div>
	              </div>
	              <div class="col-sm border-right">
	               <div class="form-row">
	                <div class="form-group col-md-9">
	                  <label>Agent</label>
	                  <div class="input-group mb-3">
	                    <div class="input-group-prepend">
	                      <div class="input-group-text">
	                        <input type="checkbox" id="agent_ref" aria-label="Checkbox for following text input">
	                      </div>
	                    </div>
	                    <input type="text" class="form-control number_only agent_ref" value="{{$default_agent_percnet}}" name="agent_ref" aria-label="Text input with checkbox">
	                  </div>
	                </div>

	              </div>
	            </div>
	            <div class="col-sm border-right">
	              <div class="form-row">
	                <div class="form-group col-md-9">
	                  <label>2nd Referral</label>
	                  <div class="input-group mb-3">
	                    <div class="input-group-prepend">
	                      <div class="input-group-text">
	                        <input type="checkbox" id="sec_ref" aria-label="Checkbox for following text input">
	                      </div>
	                    </div>
	                    <input type="text" class="form-control number_only sec_ref" name="second_referral" aria-label="Text input with checkbox" value="{{$default_2nd_ref_percent}}">
	                  </div>
	                </div>

	              </div>
	            </div>
	            <div class="col-sm border-right">
	             <div class="form-row">
	              <div class="form-group col-md-9">
	                <label>active</label>
	                <div class="input-group mb-3">
	                  <div class="input-group-prepend">
	                    <div class="input-group-text">
	                      <input type="checkbox"id='active_ref'  aria-label="Checkbox for following text input">
	                    </div>
	                  </div>
	                  <input type="text" class="form-control number_only active_ref" value="{{$status}}"name="active" aria-label="Text input with checkbox">
	                </div>
	              </div>

	            </div>

	          </div>


      </div>  --}}


      
		<div class="form-group row">
			<div class="col-md-4">
				<label for="bed_uid" class="col-form-label">Code <span>*</span></label>
				<div class="">
					<input type="text" class="form-control number_only" id="code" name="code" placeholder="Enter Refrral Code" value="{{$referralpolicy_code}}" disabled>
				</div>
			</div>
			<div class="col-md-4">
				<label for="policy_name" class="col-form-label">Policy Name <span>*</span></label>
				<div class="">
					<input type="text" class="form-control bg-light" id="policy_name" name="referralpolicy_name" value="{{$referralpolicy_name}}" placeholder="Enter Policy Name" required disabled />
				</div>
			</div>
			<div class="col-md-4">				
				<label for="def_ref" class="col-form-label">Default Referral </label>
				<div class="row">
					<input type="text" class="form-control form-control-sm col-md-9" id="def_ref" name="def_ref" value="{{$default_ref_percnet}}"  disabled><span class="text-danger">%</span>		
				</div>				
			</div>
		</div>



		<div class="form-group row">
			<div class="col-md-4">
				
			</div>
			<div class="col-md-4">
				
			</div>
			<div class="col-md-4">				
				<label for="def_agent" class="col-form-label">Default Agent </label>
				<div class="row">
					<input type="text" class="form-control form-control-sm col-md-9" id="def_agent" name="def_agent" value="{{$default_agent_percnet}}"  disabled><span class="text-danger">%</span>				
				</div>				
			</div>
		</div>


	</div>



	<label class="mb-1 ml-3 text-primary">Applied To</label>


	<div class="ml-3 form-row">
		<div class="form-group col-md-2">
			<label>Referral Doctor</label>
			<div class="input-group mb-3">
				
				<input type="text" name="ref_doc" class="form-control number_only doc_ref" value="{{$applied_to_ref_doctor_ind}}" id = 'ref_doc' aria-label="Text input with checkbox" disabled >
			</div>
		</div>

		<div class="form-group col-md-2">
			<label>Agent</label>
			<div class="input-group mb-3">
				<div class="input-group-prepend">
					
				</div>
				<input type="text" class="form-control number_only agent_ref" value="{{$default_agent_percnet}}" name="agent agent_ref" aria-label="Text input with checkbox" disabled>
			</div>
		</div>


		<div class="form-group col-md-2">
			<label>2nd Referral</label>
			<div class="input-group mb-3">
				
				<input type="text" class="form-control number_only sec_ref" name="second_referral" aria-label="Text input with checkbox" value="{{$default_2nd_ref_percent}}" disabled>
			</div>
		</div>
		<div class="form-group col-md-2">
			<label>active</label>
			<div class="input-group mb-3">
				<div class="input-group-prepend">
					
				</div>
				<input type="text" class="form-control number_only active_ref" value="{{$status}}" name="active" aria-label="Text input with checkbox" disabled>
			</div>
		</div>
		

		


		<div class="col-md-4">				
			<label for="def_2nd_ref" class="col-form-label">Default 2nd Referral </label>
			<div class="row ml-0">
				<input type="text" class="form-control form-control-sm col-md-8" id="def_2nd_ref" name="def_2nd_ref" value="{{$applied_to_seconnd_ref_ind}}" disabled ><span class="text-danger">%</span>				
			</div>				
		</div>

{{-- 
	</div>

	        <div class="ml-1">
	          @php
	          $response_action = route('referral-policy-configaration');
	          @endphp
	          <button class="btn btn-success btn-md" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')"> Save</button>
	          <button type="reset" class="btn btn-info btn-md" title="Click here to Clear form data">Clear</button>
	          <a href="" class="btn btn-danger btn-md" rel="tab" title="Click here to go back to Dashboard">Exit</a>
	        </div>
</form> --}}