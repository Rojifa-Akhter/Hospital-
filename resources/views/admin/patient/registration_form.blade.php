@php
$patient = (isset($data) && (!empty($data))) ? $data : [];

$patient_no_pk = ($patient) ? $patient->patient_no_pk : '';
$patient_salutation = ($patient) ? $patient->salutation : '';
$patient_first_name = ($patient) ? $patient->first_name : '';
$patient_last_name = ($patient) ? $patient->last_name : '';
$patient_age_d = ($patient) ? $patient->age_dd : '';
$patient_age_m = ($patient) ? $patient->age_mm : '';
$patient_age = ($patient) ? $patient->age : '';
$patient_dob = ($patient) ? date('d/m/Y',strtotime($patient->dob)) : '';
$patient_address1 = ($patient) ? $patient->emergency_contact_addr : '';
$patient_address2 = ($patient) ? $patient->present_addr : '';
$patient_address3 = ($patient) ? $patient->permanent_addr : '';
$patient_nid = ($patient) ? $patient->national_id : '';
$phone_no = ($patient) ? $patient->mobile1 : '';
$patient_father = ($patient) ? $patient->father_name : '';
$patient_mother = ($patient) ? $patient->mother_name : '';
$patient_spouse = ($patient) ? $patient->spouse_name : '';
$patient_email = ($patient) ? $patient->email : '';
$patient_blood_group = ($patient) ? $patient->blood_group : '';
$present_addres = ($patient) ? $patient->present_addr : '';
$parmanent_address = ($patient) ? $patient->permanent_addr : '';
$emergency_contact_address = ($patient) ? $patient->emergency_contact_addr : '';
$patient_nationality = ($patient) ? $patient->nationality : '';
$patient_passport = ($patient) ? $patient->passport_no : '';
$patient_gender = ($patient) ? $patient->gender : '';
$patient_marital_status = ($patient) ? $patient->marital_status : '';
$patient_religion = ($patient) ? $patient->religion : '';
$present_district = ($patient) ? $patient->present_district : '';
$parmanent_district = ($patient) ? $patient->permanent_district : '';
$emergency_contact_name = ($patient) ? $patient->emergency_contact_name : '';
$emergency_contact_relation = ($patient) ? $patient->relation_lookup_pk_no : '';
$emergency_contact_contact = ($patient) ? $patient->emergency_contact_contact : '';
$status = ($patient) ? $patient->status : '';
@endphp
<form method="post" id="frm-pat-registration" action="{{ route('registration.store') }}" enctype="multipart/form-data" action="javascript:void(0)">
	@csrf
	<input type="hidden" name="id" value="{{$patient_no_pk}}">
	<div class="row">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header"><h5>Basic Information</h5></div>
				<div class="card-body pt-2">
					<div class="form-group row">
						<label for="patient_name" class="col-sm-2 col-form-label col-form-label-sm">Patient Name <span class="text-danger">*</span></label>
						<div class="col-sm-10">
							<div class="input-group">
								<div class="input-group-prepend">
									<select class="form-control font_size_12 m-auto required" id="patient_salutation" name="pat_salutation" style="width:100px;" required>
										<option value="MR." @if($patient_salutation == 'MR.') selected @endif >MR.</option>
										<option value="MRS." @if($patient_salutation == 'MRS.') selected @endif >MRS.</option>
									</select>
								</div>
								<input type="text" class="form-control form-control-sm required text-capitalize" id="patient_first_name" name="pat_f_name" value="{{$patient_first_name}}" placeholder="First Name" onkeypress="return /^[a-zA-Z\s]+$/i.test(event.key)" required>

								<input type="text" class="form-control form-control-sm required text-capitalize" id="patient_last_name" name="pat_l_name" value="{{$patient_last_name}}" placeholder="Last Name" onkeypress="return /^[a-zA-Z\s]+$/i.test(event.key)" required>

							</div>
						</div>
					</div>
					<div class="form-group row">
						<label for="patient_gender" class="col-sm-2 col-form-label col-form-label-sm">Gender <span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<select class="form-control font_size_12 m-auto required" id="patient_gender" name="pat_gender" required>
								<option value="" disabled selected>Select Gender</option>
								@if(isset($gender))
								@foreach($gender as $key => $value )
								<option value="{{$key}}" @if($patient_gender == $key) selected @endif>{{$value}}</option>
								@endforeach
								@endif
							</select>
						</div>
						<label for="patient_blood_group" class="col-sm-2 col-form-label col-form-label-sm">Blood Group</label>
						<div class="col-sm-4">
							<select class="form-control font_size_12 m-auto" id="patient_blood_group" name="pat_blood_group">
								<option value="0">Select Blood Group</option>
								@if(isset($bloodg))
								@foreach($bloodg as $key => $value )
								<option value="{{$key}}" @if($patient_blood_group == $key) selected @endif>{{$value}}</option>
								@endforeach
								@endif
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label for="patient_age" class="col-sm-2 col-form-label col-form-label-sm">Patient Age <span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<div class="input-group">
								<div class="input-group-prepend w-100">
									<input type="number" class="form-control form-control-sm required" id="pat_age_y" name="pat_age_y" onkeyup="get_dob_by_age()" value="{{$patient_age}}" placeholder="YY" style="width: 100px;" required>
									<input type="number" class="form-control form-control-sm" id="pat_age_m" name="pat_age_m" onkeyup="get_dob_by_age()" value="{{$patient_age_m}}" placeholder="MM" style="width: 50px;" min="1" max="12">
									<input type="number" class="form-control form-control-sm" id="pat_age_d" name="pat_age_d" onkeyup="get_dob_by_age()" value="{{$patient_age_d}}" placeholder="DD" style="width: 50px;" min="1" max="31">
								</div>
							</div>
						</div>
						<label for="patient_dob" class="col-sm-2 col-form-label col-form-label-sm">Patient DOB</label>
						<div class="col-sm-4">
							<input type="text" class="form-control form-control-sm date_picker" id="patient_dob" name="pat_dob" value="{{ $patient_dob }}" placeholder="Patient DOB">
						</div>
					</div>
					<div class="form-group row">
						<label for="patient_nationality" class="col-sm-2 col-form-label col-form-label-sm">Nationality</label>
						<div class="col-sm-4">
							<input type="text" class="form-control form-control-sm text-capitalize" id="patient_nationality" name="pat_nationality" value="{{$patient_nationality}}" placeholder="Enter Patient Nationality" onkeypress="return /^[a-zA-Z\s]+$/i.test(event.key)">
						</div>

						<label for="patient_marital_status" class="col-sm-2 col-form-label col-form-label-sm">Marital Status</label>
						<div class="col-sm-4">
							<select class="form-control font_size_12 m-auto patient_marital_status" id="patient_marital_status" name="pat_marital_status">
								<option value="0">Select Marital Status</option>
								@if(isset($marital_status))
								@foreach($marital_status as $key => $value )
								<option value="{{$key}}" @if($patient_marital_status == $key) selected @endif>{{$value}}</option>
								@endforeach
								@endif

							</select>
						</div>
					</div>
					<div class="form-group row">
						<label for="patient_religion" class="col-sm-2 col-form-label col-form-label-sm">Religion</label>
						<div class="col-sm-4">
							<select class="form-control font_size_12 m-auto" id="patient_religion" name="pat_religion">
								<option value="">Select Religion</option>
								@if(isset($religion))
								@foreach($religion as $key => $value )
								<option value="{{$key}}" @if($patient_religion == $key) selected @endif>{{$value}}</option>
								@endforeach
								@endif
							</select>
						</div>
						<label for="patient_nid" class="col-sm-2 col-form-label col-form-label-sm">NID</label>
						<div class="col-sm-4">
							<input type="text" class="form-control form-control-sm" id="patient_nid" name="pat_nid" value="{{$patient_nid}}" placeholder="Enter Patient NID" onkeypress="return /^[0-9]+$/.test(event.key)">
						</div>
					</div>

					<div class="form-group row">
						<label for="patient_passport" class="col-sm-2 col-form-label col-form-label-sm">Passport No</label>
						<div class="col-sm-4">
							<input type="text" class="form-control form-control-sm" id="patient_passport" name="pat_passport" value="{{$patient_passport}}" placeholder="Enter Patient Passport No">
						</div>
					</div>

					<div class="form-group row">
						<label for="patient_passport" class="col-sm-2 col-form-label col-form-label-sm">Status</label>
						<div class="col-sm-4">

							<div class="custom-control custom-radio custom-control-inline">
								<input type="radio" id="customRadioStatus1" name="status" class="custom-control-input" value="1" {{ $status == '1' ? 'checked' : '' }}>
								<label class="custom-control-label" for="customRadioStatus1">Active</label>
							</div>
							<div class="custom-control custom-radio custom-control-inline">
								<input type="radio" id="customRadioStatus2" name="status" class="custom-control-input" {{ $status == '0' ? 'checked' : '' }}>
								<label class="custom-control-label" for="customRadioStatus2">Inctive</label>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="card">
				<div class="card-header"><h5>Contact Information</h5></div>
				<div class="card-body pt-2">
					<div class="form-group row">
						<label for="phone_no" class="col-sm-2 col-form-label col-form-label-sm">Phone No <span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="text" class="form-control form-control-sm required digits" id="phone_no" name="phone_no" value="{{$phone_no}}" placeholder="Enter Patient Phone Number" onkeypress="return /^[0-9]+$/.test(event.key)" required="required">
						</div>

						<label for="patient_email" class="col-sm-2 col-form-label col-form-label-sm">Email</label>
						<div class="col-sm-4">
							<input type="email" class="form-control form-control-sm email" id="patient_email" name="pat_email" value="{{$patient_email}}" placeholder="Enter Patient Emal ID">
						</div>
					</div>
				</div>
			</div>

			<div class="card">
				<div class="card-header"><h5>Address Information</h5></div>
				<div class="card-body pt-2">
					<div class="form-group row">
						<label for="present_addres" class="col-sm-2 col-form-label col-form-label-sm">Present <span class="text-danger">*</span></label>
						<div class="col-sm-10">
							<input type="text" class="form-control form-control-sm same_as_pre_add required" id="present_addres" name="present_addres" value="{{$present_addres}}" placeholder="Enter Present Address" required="required">
						</div>
					</div>
					<div class="form-group row">
						<label for="parmanent_address" class="col-sm-2 col-form-label col-form-label-sm">Permanent</label>
						<div class="col-sm-10">
							<div class="input-group mb-3">
								<div class="input-group-prepend" title="Same as Prensent Address">
									<div class="input-group-text">
										<input type="checkbox" aria-label="Checkbox for following text input" class="same_pre_and_par" {{$present_addres == $parmanent_address ? 'checked' : '' }}>
									</div>
								</div>
								<input type="text" class="form-control form-control-sm same_as_par_add" id="parmanent_address" name="parmanent_address" value="{{$parmanent_address}}" placeholder="Enter Parmanent Address" {{$present_addres == $parmanent_address ? 'readonly' : '' }}>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>
		<div class="col-md-4">
			<div class="card">
				<div class="card-header"><h5>Patient Image</h5></div>
				<div class="card-body pt-2">
					<div class="form-group row">
						<label for="patient_photo" class="col-sm-3 col-form-label col-form-label-sm">Photo</label>
						<div class="col-sm-9">
							<input type="file" class="form-control" id="patient_photo" name="pat_photo" >
						</div>
					</div>
				</div>
			</div>

			<div class="card">
				<div class="card-header"><h5>Family Information</h5></div>
				<div class="card-body pt-2">
					<div class="form-group row">
						<label for="patient_father" class="col-sm-3 col-form-label col-form-label-sm">Father</label>
						<div class="col-sm-9">
							<input type="text" class="form-control form-control-sm text-capitalize" id="patient_father" name="pat_father" value="{{$patient_father}}" placeholder="Enter Patient Father Name" onkeypress="return /^[a-zA-Z\s]+$/i.test(event.key)">
						</div>
					</div>
					<div class="form-group row">
						<label for="patient_mother" class="col-sm-3 col-form-label col-form-label-sm">Mother</label>
						<div class="col-sm-9">
							<input type="text" class="form-control form-control-sm text-capitalize" id="patient_mother" name="pat_mother" value="{{$patient_mother}}" placeholder="Enter Patient Mother Name" onkeypress="return /^[a-zA-Z\s]+$/i.test(event.key)">
						</div>
					</div>
					<div class="form-group row" id="spouse" style="display: none;">
						<label for="patient_spouse" class="col-sm-3 col-form-label col-form-label-sm">Spouse</label>
						<div class="col-sm-9">
							<input type="text" class="form-control form-control-sm text-capitalize" id="patient_spouse" name="pat_spouse" value="{{$patient_spouse}}" placeholder="Enter Patient Spouse Name" onkeypress="return /^[a-zA-Z\s]+$/i.test(event.key)">
						</div>
					</div>
				</div>
			</div>

			<div class="card">
				<div class="card-header"><h5>Emergency Contact</h5></div>
				<div class="card-body pt-2">
					<div class="form-group row">
						<label for="emergency_contact_name" class="col-sm-3 col-form-label col-form-label-sm">Name</label>
						<div class="col-sm-9">
							<input type="text" class="form-control form-control-sm" id="emergency_contact_name" name="emergency_contact_name" value="{{$emergency_contact_name}}" placeholder="Enter Emergency Contact Name">
						</div>
					</div>

					<div class="form-group row">
						<label for="emergency_contact_address" class="col-sm-3 col-form-label col-form-label-sm">Address</label>
						<div class="col-sm-9">
							<input type="text" class="form-control form-control-sm" id="emergency_contact_address" name="emergency_contact_address" value="{{$emergency_contact_address}}" placeholder="Enter Emergency Contact Adress">
						</div>
					</div>

					<div class="form-group row">
						<label for="emergency_contact_relation" class="col-sm-3 col-form-label col-form-label-sm">Relation</label>
						<div class="col-sm-9">
							<select class="form-control font_size_12 m-auto" id="emergency_contact_relation" name="emergency_contact_relation">
								<option value="">Select Relation</option>
								@if(isset($relation))
								@foreach($relation as $key => $value )
								<option value="{{$key}}" @if($emergency_contact_relation == $key) selected @endif>{{$value}}</option>
								@endforeach
								@endif
							</select>
						</div>
					</div>

					<div class="form-group row">
						<label for="emergency_contact_contact" class="col-sm-3 col-form-label col-form-label-sm">Contact</label>
						<div class="col-sm-9">
							<input type="text" class="form-control form-control-sm" id="emergency_contact_contact" name="emergency_contact_contact" value="{{$emergency_contact_contact}}" placeholder="Enter Emergency Contact Number">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="card">
		<div class="card-body p-2">
			@php
			$patient_id = "";
			$response_url = route('patient-card', $patient_id);
			@endphp

			<button class="btn btn-success btn-md" id="save_update" data-func="afterSaveModal" data-response-url="{{ $response_url }}" title="Click here to save Patient Information"> Save </button>
			<button type="reset" class="btn btn-info btn-md" title="Click here to Clear form data">Clear</button>
			<a href="{{ route('home') }}" class="btn btn-danger btn-md" rel="tab" title="Click here to go back to Dashboard">Exit</a>
		</div>
	</div>
</form>

<script type="text/javascript">

	function get_dob_by_age()
	{
		var pat_age_y = $('#pat_age_y').val();
		var pat_age_m = $('#pat_age_m').val();
		var pat_age_d = $('#pat_age_d').val();

		var cur_date = new Date();
		var cur_y = cur_date.getFullYear();

		var dob = pat_age_m + "/" + pat_age_d + "/" + (cur_y - pat_age_y);
		var dob_year = cur_y - pat_age_y;
		if((pat_age_m.length && pat_age_d.length) > 0){
			$("#patient_dob").val(dob);
		}else{
			$("#patient_dob").val(dob_year);
		}
	}

	$(function(){
		$('#patient_marital_status').on('change', function() {
			if ( this.value == 20)
			{
				$("#spouse").show();
			}else{
				$("#spouse").hide();
			}
		});

		$(document).on("click", '#save_update', function(e) {
			$('#frm-pat-registration').unbind().submit(function(e) {
				e.preventDefault();
				var formAction  = $(this).attr("action");
				var formMethod  = $(this).attr("method");
				var formData = new FormData(this);
				var customFunc = $("#save_update").attr("data-func");

				$.ajax({
					type: formMethod,
					url: formAction,
					data: formData,
					cache:false,
					contentType: false,
					processData: false,
					beforeSend:function(){
						if(customFunc == ""){
							if(isAModalOpen)
								$('.modal').modal('hide');

							$('.common-modal-notify').modal('show');
							$('.common-modal-notify .modal-body').html("<i class='fas fa-stroopwafel fa-spin'></i>");
						}
						blockUI();
					},
					success: (data) => {
						var response_url = $("#save_update").attr("data-response-url") + "/"+data.insert_id;
						dynamicFunc.afterSaveModal(response_url, "common-modal-sm", "Patient Card");

						$(this).find("input, textarea").not('.keep_me').val("");
						$(this).find("select").not('.keep_me').val("0");
					},
					error: function(data){
						console.log(data);
					},
					complete: function(){
						$.unblockUI();
						dynamicFunc.afterSaveLoadList("{{ route('registration.loadList') }}");
					},
					error: function (data) {
						var errors = jQuery.parseJSON(data.responseText).errors;
						error_messages="";
						for (messages in errors) {
							var field_name = $("#"+messages).siblings("label").html();
							error_messages +=  "<div class='alert alert-danger' role='alert'>"+errors[messages]+"</div>";
						}

						$('.common-modal-notify-error').modal('show');
						$('.common-modal-notify-error .modal-title').html("Validation Error");
						$('.common-modal-notify-error .modal-body').html(error_messages);
						finished = false;
						$.unblockUI();
					}
				});
			});
		});
	});

</script>

