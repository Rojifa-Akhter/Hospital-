<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<section id="full_appointment">
	<div class="container-fluid">
		<div class="row bg-white border-bottom sticky-top shadow-sm">
			<div class="col-md-10 mb-1">
				<h5 class="mt-2 mb-0">Prescription Entry</h5>
				<small>Prescription / Prescription Entry</small>
			</div>
			<div class="col-md-2 mt-3">
				<a class="btn bg-navy text-white btn-md" href="{{ route('appointments.list-view') }}" rel="tab"><i class="far fa-calendar"></i> Appointment List</a>
			</div>
		</div>
		<div class="p-0">
			<form method="post" id="frm-pat-prescription" action="{{ route('pres-physio-save-update') }}" autocomplete="off">
				@csrf
				<div class="row">
					<div class="col-md-12 col-lg-3 col-sm-12 p-1">
						<div class="card mt-0">
							<div class="card-body pt-2" style="overflow-y: auto; max-height: 585px;">
								@php $action_url = route('physiotherapy.load-pres-favourit-list'); @endphp
								<input type="text" class="form-control" id="cheif_complaint" name="cheif_complaint" placeholder="Enter Chief Complaints" onclick="prescriptionFunc.loadToPresFavouritList('CHIEFCOM','CC','#chfcom', '{{ $action_url }}')">
								<div class="card mt-0 bg-light" style="min-height: 50px;">
									<div class="card-body pt-2">
										<ul class="list-unstyled mb-0" id="chfcom"></ul>
									</div>
								</div>

								<input type="text" class="form-control mt-3" id="history_of_objective" name="history_of_objective"  placeholder="Enter History of Objective" onclick="prescriptionFunc.loadToPresFavouritList('CLINICHIST','HO','#ho', '{{ $action_url }}')">
								<div class="card mt-0 bg-light" style="min-height: 50px;">
									<div class="card-body pt-2">
										<ul class="list-unstyled mb-0" id="ho"></ul>
									</div>
								</div>

								<input type="text" class="form-control mt-3" id="on_examination" name="on_examination"  placeholder="Enter On Eexamination" onclick="prescriptionFunc.loadToPresFavouritList('OEX','OE','#oxm', '{{ $action_url }}')">
								<div class="card mt-0 bg-light" style="min-height: 50px;">
									<div class="card-body pt-2">
										<ul class="list-unstyled mb-0" id="oxm"></ul>
									</div>
								</div>

								<input type="text" class="form-control mt-3" id="physical_examination" name="physical_examination"  placeholder="Enter Physical Eexamination" onclick="prescriptionFunc.loadToPresFavouritList('PHEX','PE','#pexm', '{{ $action_url }}')">
								<div class="card mt-0 bg-light" style="min-height: 50px;">
									<div class="card-body pt-2">
										<ul class="list-unstyled mb-0" id="pexm"></ul>
									</div>
								</div>

								<input type="text" class="form-control mt-3" id="desease" name="desease"  placeholder="Enter Disease" onclick="prescriptionFunc.loadToPresFavouritList('DISEASE','Desease','#desease_con', '{{ $action_url }}')">
								<div class="card mt-0 bg-light" style="min-height: 50px;">
									<div class="card-body pt-2">
										<ul class="list-unstyled mb-0" id="desease_con"></ul>
									</div>
								</div>

								<input type="text" class="form-control mt-3" id="chronic_desease" name="chronic_desease"  placeholder="Enter Chronic Disease" onclick="prescriptionFunc.loadToPresFavouritList('CHRDISEASE','Chronic Disease','#chronic_des', '{{ $action_url }}')">
								<div class="card mt-0 bg-light" style="min-height: 50px;">
									<div class="card-body pt-2">
										<ul class="list-unstyled mb-0" id="chronic_des"></ul>
									</div>
								</div>

								<input type="text" class="form-control mt-3" id="advice" name="advice" placeholder="Enter Advice" onclick="prescriptionFunc.loadToPresFavouritList('ADVICE','Advice','#adv', '{{ $action_url }}')">
								<div class="card mt-0 bg-light" style="min-height: 50px;">
									<div class="card-body pt-2">
										<ul class="list-unstyled mb-0" id="adv"></ul>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-12 col-lg-2 col-sm-12 p-1">
						<div class="card mt-0 bg-light">
							<div class="card-header">
								<span id="favourit_list_title" data-append-to="">Fevourite List</span>
								<span class="loading-img"></span>
							</div>
							<div class="card-body" style="overflow-y: auto; min-height: 557px;">
								<div class="form-group mt-2">
									<input type="search" class="form-control form-control-sm" id="" name="" placeholder="Search Fevourite Item">
								</div>
								<table class="table m-0">
									<tbody id="pres-favourit-list">
										@include('admin.components.pres_favourit_list')
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="col-md-12 col-lg-7 col-sm-12 p-1">

						<div class="accordion" id="accordionExample">
							<div class="card mt-0">
								<div class="card-header" id="headingOne">
									<div class="mb-0" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
										<i class="fa fa-user"></i> Patient Information
									</div>
								</div>

								<div id="collapseOne" class="collapse cursor-pointer show" aria-labelledby="headingOne" data-parent="#accordionExample">
									<div class="card-body p-1">
										@include('admin.components.patient_information')
									</div>
								</div>
							</div>
							<div class="card mt-0">
								<div class="card-header" id="headingTwo">
									<div class="mb-0" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
										<i class="fa fa-prescription"></i> &nbsp;Last Prescribed
									</div>
								</div>
								<div id="collapseTwo" class="collapse cursor-pointer" aria-labelledby="headingTwo" data-parent="#accordionExample">
									<div class="card-body p-1">
										<span class="text-danger">No Previous Prescription Found</span>
									</div>
								</div>
							</div>
							<div class="card mt-0">
								<div class="card-header" id="headingFour">
									<div class="mb-0" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
										<i class="fa fa-history" aria-hidden="true"></i> Therapy History
									</div>
								</div>
								<div id="collapseFour" class="collapse cursor-pointer" aria-labelledby="headingFour" data-parent="#accordionExample">
									<div class="card-body p-1">
										<span class="text-danger">No Therapy History Found</span>
									</div>
								</div>
							</div>
							<div class="card mt-0">
								<div class="card-header" id="headingThree">
									<div class="mb-0" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
										<i class="fa fa-capsules"></i> Past Medications
									</div>
								</div>
								<div id="collapseThree" class="collapse cursor-pointer" aria-labelledby="headingThree" data-parent="#accordionExample">
									<div class="card-body p-1">
										<span class="text-danger">No Past Medication Found</span>
									</div>
								</div>
							</div>
						</div>

						<div class="card">
							<div class="card-header">Electro Therapy / Therapy</div>
							<div class="card-body pt-2">
								<div class="row">
									<div class="col-md-12">
										<table class="table border-0 m-0">
											<thead>
												<tr class="border-0">
													<th class="p-0 px-1 border-0" width="43%" scope="col">
														Name
														<span class="badge badge-primary cursor-pointer open-modal" data-modal="common-modal-md" data-action="{{ route('item.create-quick-item') }}" data-title="Create New Item">+ New</span>
													</th>
													<th class="p-0 px-1 border-0" width="20%" scope="col">Duration</th>
													<th class="p-0 px-1 border-0" width="20%" scope="col">Duration MU</th>
													<th class="p-0 px-1 border-0" width="15%" scope="col">Unit/Intensity</th>
													<th class="p-0 px-1 border-0" scope="col"></th>
												</tr>
											</thead>
											<tbody id="data-append-to">
												<tr class="border-0" id="1">
													<td scope="row" class="p-0 px-1 border-0">
														<input type="text" class="form-control et_item_name item_element" id="et_item_name_1" name="et_item_name[]">
														<input type="hidden" class="form-control left-element" id="hdn_item_id_1" name="item_id[]">
														<input type="hidden" class="form-control" id="hdn_item_name_1" name="item_name[]">
														<input type="hidden" class="form-control" id="hdn_lookup_id_1" name="lookup_id[]" value="{{ isset($tr_lk_id_arr['ETHER']) ? $tr_lk_id_arr['ETHER'] :'' }}">
														<input type="hidden" class="form-control" id="hdn_lookup_code_1" name="lookup_code[]" value="ETHER">
														<input type="hidden" class="form-control" id="hdn_lookupdata_code_1" name="lookupdata_code[]">
														<input type="hidden" class="form-control" id="session_mu_1" name="session_mu[]">
														<input type="hidden" class="form-control" id="no_of_session_1" name="no_of_session[]">
													</td>
													<td class="p-0 px-1 border-0"><input type="text" class="form-control number_only" id="session_duration_1" name="session_duration[]"></td>
													<td class="p-0 px-1 border-0">
														<select class="form-control" id="unit_intensity_mu_1" name="unit_intensity_mu[]">
															<option value="0">Select</option>
															@if(!empty($duration_mu))
															@foreach($duration_mu as $key => $dmu)
															<option value="{{ $key }}">{{ $dmu }}</option>
															@endforeach
															@endif
														</select>
													</td>
													<td class="p-0 px-1 border-0"><input type="text" class="form-control number_only" id="unit_intensity_1" name="unit_intensity[]"></td>
													<td class="p-0 px-1 border-0" style="vertical-align: top;" id="et_td_action_1">
														<span class="btn btn-success btn-sm" onclick="prescriptionFunc.addRow(this, 'ETHER')"> <i class="fa fa-plus"></i> </span>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>

						<div class="card">
							<div class="card-header">Therapeutic Excercise / Package</div>
							<div class="card-body pt-2">
								<div class="row">
									<div class="col-md-12">
										<table class="table border-0 m-0">
											<thead>
												<tr class="border-0">
													<th class="p-0 px-1 border-0" width="43%" scope="col">
														Name
														<span class="badge badge-primary cursor-pointer open-modal" data-modal="common-modal-sm" data-id="1" data-action="{{ route('doctor.createquickregistration',1) }}" data-title="Add New Doctor">+ New</span>
													</th>
													<th class="p-0 px-1 border-0" width="20%" scope="col">Session Duration</th>
													<th class="p-0 px-1 border-0" width="20%" scope="col">Duration MU</th>
													<th class="p-0 px-1 border-0" width="15%" scope="col">No of Session</th>
													<th class="p-0 px-1 border-0" scope="col"></th>
												</tr>
											</thead>
											<tbody id="data-append-to">
												<tr class="border-0" id="1">
													<td scope="row" class="p-0 px-1 border-0">
														<input type="text" class="form-control item_element" id="te_item_name_1" name="te_item_name[]">
														<input type="hidden" class="form-control left-element" id="hdn_item_id_1" name="item_id[]">
														<input type="hidden" class="form-control" id="hdn_item_name_1" name="item_name[]">
														<input type="hidden" class="form-control" id="hdn_lookup_id_1" name="lookup_id[]" value="{{ isset($tr_lk_id_arr['THRPEX']) ? $tr_lk_id_arr['THRPEX'] : '' }}">
														<input type="hidden" class="form-control" id="hdn_lookup_code_1" name="lookup_code[]" value="THRPEX">
														<input type="hidden" class="form-control" id="hdn_lookupdata_code_1" name="lookupdata_code[]">
														<input type="hidden" class="form-control" id="unit_intensity_mu_1" name="unit_intensity_mu[]">
														<input type="hidden" class="form-control" id="unit_intensity_1" name="unit_intensity[]">
													</td>
													<td class="p-0 px-1 border-0"><input type="text" class="form-control number_only" id="session_duration_1" name="session_duration[]"></td>
													<td class="p-0 px-1 border-0">
														<select class="form-control" id="session_mu_1" name="session_mu[]">
															<option value="0">Select</option>
															@if(!empty($duration_mu))
															@foreach($duration_mu as $key => $dmu)
															<option value="{{ $key }}">{{ $dmu }}</option>
															@endforeach
															@endif
														</select>
													</td>
													<td class="p-0 px-1 border-0"><input type="text" class="form-control number_only" id="no_of_session_1" name="no_of_session[]"></td>
													<td class="p-0 px-1 border-0" style="vertical-align: top;" id="te_td_action_1">
														<span class="btn btn-success btn-sm" onclick="prescriptionFunc.addRow(this, 'THRPEX')"> <i class="fa fa-plus"></i> </span>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>

						<div class="card">
							<div class="card-header">Medicine</div>
							<div class="card-body pt-2">
								<div class="row">
									<div class="col-md-12">
										<table class="table border-0 m-0">
											<thead>
												<tr class="border-0">
													<th class="p-0 px-1 border-0 w-25">
														Generic / Brand
														<span class="badge badge-primary cursor-pointer open-modal" data-modal="common-modal-sm" data-id="1" data-action="{{ route('doctor.createquickregistration',1) }}" data-title="Add New Doctor">+ New</span>
													</th>
													<th class="p-0 px-1 border-0">Dose</th>
													<th class="p-0 px-1 border-0">Duration</th>
													<th class="p-0 px-1 border-0" >Quantity</th>
													<th class="p-0 px-1 border-0">Instruction</th>
													<th class="p-0 px-1 border-0">Continue</th>
													<th class="p-0 px-1 border-0"></th>
												</tr>
											</thead>
											<tbody id="data-append-to">
												<tr class="border-0" id="1">
													<td class="p-0 px-1 border-0">
														<input type="text" class="form-control form-control-sm m-0 p-0 item_element" id="medicine_item_1" name="medicine_item[]" placeholder="Generic / Brand" >
														<input type="hidden" id="hdn_medicine_item_id_1" name="hdn_medicine_item_id[]">
														<input type="hidden" id="hdn_report_serial_med_1" name="hdn_report_serial_med[]" value="1">
													</td>

													<td class="p-0 px-1 border-0">
														<select class="form-control form-control-sm select2 m-0 p-0 medicine_dose" id="medicine_dose_1" name="medicine_dose[]" onchange="prescriptionFunc.calculateMedicineQnty(this)" >
															<option value="0">Select</option>
															@if(!empty($dose))
															@foreach($dose as $key => $dmu)
															<option data-qnty="{{ $dmu['attr'] }}" value="{{ $key }}">{{ $dmu['data'] }}</option>
															@endforeach
															@endif
														</select>
													</td>

													<td class="p-0 px-1 border-0 w-20">

														<div class="input-group">
															<input type="text" class="form-control form-control-sm m-0 p-0 medicine_duration" id="medicine_duration_type_1" name="medicine_duration_type[]" onkeyup="prescriptionFunc.calculateMedicineQnty(this)" >
															<select class="form-control medicine_duration_mu" id="medicine_duration_mu_1" name="medicine_duration_mu[]" onchange="prescriptionFunc.calculateMedicineQnty(this)">
																<option value="0">Select</option>
																@if(!empty($meddurmu))
																@foreach($meddurmu as $key => $dmu)
																<option value="{{ $key }}">{{ $dmu['data'] }}</option>
																@endforeach
																@endif
															</select>
														</div>
													</td>

													<td class="p-0 px-1 border-0 w-10" >
														<input type="text" class="form-control form-control-sm m-0 p-0 medicine_quantity" id="medicine_quantity_1" name="medicine_quantity[]" >
													</td>

													<td class="p-0 px-1 border-0">
														<select class="form-control form-control-sm select2 m-0 p-0" id="instruction_1" name="instruction[]" >
															<option value="0">Select</option>
															@if(!empty($instructions))
															@foreach($instructions as $key => $dmu)
															<option value="{{ $key }}">{{ $dmu['data'] }}</option>
															@endforeach
															@endif
														</select>
													</td>

													<td class="p-0 px-1 border-0">
														<input type="checkbox" id="is_continue_1" name="is_continue[]" >
													</td>

													<td class="p-0 px-1 border-0" style="vertical-align: top;" id="med_td_action_1">
														<span class="btn btn-success btn-sm" onclick="prescriptionFunc.addMedRow(this)"> <i class="fa fa-plus"></i> </span>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="modal-footer mt-2">
					<input type="hidden" id="hdn_appointment_id" name="hdn_appointment_id" value="{{ $appointment_id }}" />
					<input type="hidden" id="hdn_patient_id" name="hdn_patient_id" value="{{ $patient_id }}" />
					<input type="hidden" id="hdn_patient_code" name="hdn_patient_code" value="{{ !empty($patient_info)?$patient_info->patient_code:'' }}" />
					@php
					$prescription_id="";
					$response_url = route('prescription-print', $prescription_id);
					@endphp
					<span class="btn btn-md btn-success" data-response_action="{{ $response_url }}" onclick="prescriptionFunc.savePTPrescription(this);" ><i class="fa fa-save"></i> Save Prescription</span>
					<button type="reset" class="btn btn-md btn-info" data-response_action="{{ $response_url }}" ><i class="fa fa-save"></i> Clear</button>
					<span class="btn btn-md btn-danger" data-response_action="{{ $response_url }}" onclick="prescriptionFunc.savePTPrescription(this);" ><i class="fa fa-save"></i> Close</span>
				</div>
			</form>
		</div>
	</div>
</section>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="text/javascript">
	$(document).ready(function () {
		openLookupAutocomplete("#cheif_complaint", "{{ route('lookup-pres-data-autocomplete') }}", "PRES", "CHIEFCOM", "#chfcom");
		openLookupAutocomplete("#history_of_objective", "{{ route('lookup-pres-data-autocomplete') }}", "PRES", "CLINICHIST", "#ho");
		openLookupAutocomplete("#on_examination", "{{ route('lookup-pres-data-autocomplete') }}", "PRES", "OEX", "#oxm");
		openLookupAutocomplete("#physical_examination", "{{ route('lookup-pres-data-autocomplete') }}", "PRES", "PHEX", "#pexm");
		openLookupAutocomplete("#desease", "{{ route('lookup-pres-data-autocomplete') }}", "PRES", "DISEASE", "#desease_con");
		openLookupAutocomplete("#chronic_desease", "{{ route('lookup-pres-data-autocomplete') }}", "PRES", "CHRDISEASE", "#chronic_des");
		openLookupAutocomplete("#advice", "{{ route('lookup-pres-data-autocomplete') }}", "PRES", "ADVICE", "#adv");

			openItemAutocomplete($("#et_item_name_1"), 'PT', "#hdn_item_id_1", "#hdn_item_name_1"); // 3 = SERVICE ITEM TYPE
			openItemAutocomplete($("#te_item_name_1"), 'PT', "#hdn_item_id_1", "#hdn_item_name_1"); // 3 = SERVICE ITEM TYPE

			openItemAutocomplete($("#medicine_item_1"), 'GENERIC','#hdn_medicine_item_id_1','#medicine_item_1');
		});
	</script>
