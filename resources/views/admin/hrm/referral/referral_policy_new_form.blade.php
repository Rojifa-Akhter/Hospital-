
<form method="post" action="{{route('referral_doctor_store')}}" id="frmBilling" onsubmit="">
	<div class="container-fluid">
		{{-- <input type="hidden" value="{{$referralpolicy_no_pk}}" name="hdn_ref"> --}}



		<div class="form-group row">
			<div class="col-md-6">
				<label for="bed_uid" class="col-form-label">Code <span>*</span></label>
				<div class="">
					<input type="text" class="form-control number_only" id="code" name="code" placeholder="Enter Refrral Code" value="" required>
				</div>
			</div>
			<div class="col-md-6">
				<label for="policy_name" class="col-form-label">Policy Name <span>*</span></label>
				<div class="">
					<input type="text" class="form-control bg-light" id="policy_name" name="referralpolicy_name" value="" placeholder="Enter Policy Name" required />
				</div>
			</div>
			{{-- <div class="col-md-4">				
				<label for="def_ref" class="col-form-label">Default Referral </label>
				<div class="row">
					<input type="text" class="form-control form-control-sm col-md-9" id="def_ref" name="def_ref" value=""  ><span class="text-danger">%</span>				
				</div>				
			</div> --}}
		</div>



		<div class="form-group row">
			<div class="col-md-4">
				
			</div>
			<div class="col-md-4">
				
			</div>
			{{-- <div class="col-md-4">				
				<label for="def_agent" class="col-form-label">Default Agent </label>
				<div class="row">
					<input type="text" class="form-control form-control-sm col-md-9" id="def_agent" name="def_agent" value=""  ><span class="text-danger">%</span>				
				</div>				
			</div> --}}
		</div>


	</div>



	<label class="mb-1 ml-2 text-primary">Applied To</label>


	<div class="ml-2 form-row">
		<div class="form-group col-md-3">
			<label>Referral Doctor</label>
			<div class="input-group mb-3">
				<div class="input-group-prepend">
					<div class="input-group-text">
						<input type="checkbox" id="doc_ref" aria-label="Checkbox for following text input" name="def_ref" value="1">
					</div>
				</div>
				<input type="text" name="ref_doc" class="form-control number_only doc_ref" value="" id = 'ref_doc' aria-label="Text input with checkbox">
			</div>
		</div>

		<div class="form-group col-md-3">
			<label>Agent</label>
			<div class="input-group mb-3">
				<div class="input-group-prepend">
					<div class="input-group-text">
						<input type="checkbox" id="agent_ref" aria-label="Checkbox for following text input">
					</div>
				</div>
				<input type="text" class="form-control number_only agent_ref" value="1" name="agent_ref" aria-label="Text input with checkbox">
			</div>
		</div>


		<div class="form-group col-md-3">
			<label>2nd Referral</label>
			<div class="input-group mb-3">
				<div class="input-group-prepend">
					<div class="input-group-text">
						<input type="checkbox" id="sec_ref" aria-label="Checkbox for following text input" value="1">
					</div>
				</div>
				<input type="text" class="form-control number_only sec_ref" name="second_referral" aria-label="Text input with checkbox" value="">
			</div>
		</div>
		<div class="form-group col-md-3">
			<label>active</label>
			<div class="input-group mb-3">
				<div class="input-group-prepend">
					<div class="input-group-text">
						<input type="checkbox"id='active_ref' aria-label="Checkbox for following text input">
					</div>
				</div>
				<input type="text" class="form-control number_only active_ref" value="" name="active" aria-label="Text input with checkbox">
			</div>
		</div>
		

		


		{{-- <div class="col-md-4">				
			<label for="def_2nd_ref" class="col-form-label">Default 2nd Referral </label>
			<div class="row ml-0">
				<input type="text" class="form-control form-control-sm col-md-8" id="def_2nd_ref" name="def_2nd_ref" value=""  ><span class="text-danger">%</span>				
			</div>				
		</div> --}}


	</div>

	{{-- <div class="border rounded mb-2 bg-light"> --}}

		{{-- 	<div class="row">

				<div class="col-sm border-right">
					<div class="ml-2 form-row">
						<div class="form-group col-md-9">
							<label>Referral Doctor</label>
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<div class="input-group-text">
										<input type="checkbox" id="doc_ref" aria-label="Checkbox for following text input">
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
								<input type="text" class="form-control number_only agent_ref" value="" name="agent agent_ref" aria-label="Text input with checkbox">
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
								<input type="text" class="form-control number_only sec_ref" name="second_referral" aria-label="Text input with checkbox" value="">
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
										<input type="checkbox"id='active_ref' aria-label="Checkbox for following text input">
									</div>
								</div>
								<input type="text" class="form-control number_only active_ref" value="" name="active" aria-label="Text input with checkbox">
							</div>
						</div>
					</div>

				</div>

				--}}
			{{-- </div>  --}}

			<div class="ml-3">
				@php
				$response_action = route('referral-policy-configaration');
				@endphp
				<button class="btn btn-success btn-md" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')"> Save</button>
				<button type="reset" class="btn btn-info btn-md" title="Click here to Clear form data">Clear</button>
				<a href="" class="btn btn-danger btn-md" rel="tab" title="Click here to go back to Dashboard">Exit</a>
			</div>
		</form>