<form">
	{{-- <input type="hidden" name="id" value="{{ $doctor_no_pk }}"> --}}
	<div class="row">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header">Basic Information</div>
				<div class="card-body pt-2">
					<div class="form-group row">
						<label for="doctor_name" class="col-sm-2 col-form-label col-form-label-sm">Referral Name</label>
						<div class="col-sm-10">
							<div class="input-group">
								<div class="input-group-prepend">
                                    {{ $data->salutation }} {{ $data->full_name }}
								</div>
							</div>
						</div>
					</div>


					<div class="form-group row">
						<label for="doctor_gender" class="col-sm-2 col-form-label col-form-label-sm">Gender</label>
						<div class="col-sm-4">
							{{ $data->gender }}
						</div>

						<label for="doctor_blood_group" class="col-sm-2 col-form-label col-form-label-sm">Blood Group</label>
						<div class="col-sm-4">
							{{ $data->blood_group }}
						</div>
					</div>

					<div class="form-group row">
						<label for="doctor_date_of_birth" class="col-sm-2 col-form-label col-form-label-sm">Date of Birth</label>
						<div class="col-sm-4">
							{{ $data->dob }}
						</div>

						<label for="place_of_birth" class="col-sm-2 col-form-label col-form-label-sm">Place of Birth</label>
						<div class="col-sm-4">
							{{ $data->place_of_birth }}
						</div>
					</div>

					<div class="form-group row">
						<label for="doctor_marital_status" class="col-sm-2 col-form-label col-form-label-sm">Marital Status</label>
						<div class="col-sm-4">
							{{ $data->marital }}
						</div>

						<label for="doctor_religion" class="col-sm-2 col-form-label col-form-label-sm">Religion</label>
						<div class="col-sm-4">
							{{ $data->religion }}
						</div>
					</div>

					<div class="form-group row">
						<label for="doctor_passport_no" class="col-sm-2 col-form-label col-form-label-sm">Passport/NID</label>
						<div class="col-sm-4">
							{{ $data->passport_no }}
						</div>

						<label for="doctor_nationality" class="col-sm-2 col-form-label col-form-label-sm">Nationality</label>
						<div class="col-sm-4">
							{{ $data->nationality }}
						</div>
					</div>
				</div>
			</div>

			<div class="card">
				<div class="card-header"><h5>Contact Information</h5></div>
				<div class="card-body pt-2">
					<div class="form-group row">
						<label for="doctor_mobile" class="col-sm-2 col-form-label col-form-label-sm">Mobile</label>
						<div class="col-sm-4">
							{{ $data->phone_mobile }}
						</div>

						<label for="doctor_email" class="col-sm-2 col-form-label col-form-label-sm">Email</label>
						<div class="col-sm-4">
							{{ $data->email_personal }}
						</div>
					</div>
				</div>
			</div>

			<div class="card">
				<div class="card-header">Address information</div>
				<div class="card-body pt-2">
					<div class="form-group row">
						<label for="present_address" class="col-sm-2 col-form-label col-form-label-sm">Present</label>
						<div class="col-sm-4">
							{{ $data->pr_addr1 }}
						</div>

						<label for="doctor_present_district" class="col-sm-2 col-form-label col-form-label-sm">District</label>
						<div class="col-sm-4">
							{{ $data->pr_addr_dist }}
						</div>
					</div>

					<div class="form-group row">
						<label for="doctor_parmanent_address" class="col-sm-2 col-form-label col-form-label-sm">Permanent</label>
						<div class="col-sm-4">
							<div class="input-group">
								{{ $data->pe_addr1 }}
							</div>
						</div>

						<label for="doctor_permanent_district" class="col-sm-2 col-form-label col-form-label-sm">District</label>
						<div class="col-sm-4">
							{{ $data->pe_addr_dist }}
						</div>
					</div>
				</div>
			</div>

			<div class="card">
				<div class="card-header">Other Information</div>
				<div class="card-body pt-2">
					<div class="form-group row">
						<label for="doctor_ser_unit" class="col-sm-2 col-form-label col-form-label-sm">Service Unit</label>
						<div class="col-sm-4">
							{{ $data->service_unit }}
						</div>
						<label for="doctor_job_type" class="col-sm-2 col-form-label col-form-label-sm">Job Type</label>
						<div class="col-sm-4">
							{{ $data->job_type }}
						</div>

					</div>
					<div class="form-group row">
						<label for="doctor_specialization" class="col-sm-2 col-form-label col-form-label-sm">Specialization</label>
						<div class="col-sm-4">
							{{ $data->specialization }}
						</div>
						<label for="department" class="col-sm-2 col-form-label col-form-label-sm">Department</label>
						<div class="col-sm-4">
							{{-- {{ $data->department }} --}}
						</div>

					</div>

					<div class="form-group row">
						<label for="doctor_job_title" class="col-sm-2 col-form-label col-form-label-sm">Job Title</label>
						<div class="col-sm-4">
							{{ $data->job_title }}
						</div>
						<label for="doctor_hr_type" class="col-sm-2 col-form-label col-form-label-sm">HR Type</label>
						<div class="col-sm-4">
							{{ $data->hr_type }}
						</div>
					</div>


					<div class="form-group row">
						<label for="doctor_join_date" class="col-sm-2 col-form-label col-form-label-sm">join Date</label>
						<div class="col-sm-4">
							{{ $data->join_date }}
						</div>
						<label for="doctor_card_number" class="col-sm-2 col-form-label col-form-label-sm">Card Number</label>
						<div class="col-sm-4">
							{{ $data->card_no }}
						</div>


					</div>

					<div class="form-group row">
						<label for="emp_type" class="col-sm-2 col-form-label col-form-label-sm">Emp. Type</label>
						<div class="col-sm-4">
							{{ $data->emp_type }}
						</div>

					</div>
				</div>
			</div>
		</div>


		<div class="col-md-4">
			<div class="card">
				<div class="card-header"><h5>Referral Image</h5></div>
				<div class="card-body pt-2">
					<div class="form-group row">
						<label for="doctor_photo" class="col-sm-3 col-form-label col-form-label-sm">Photo</label>
						<div class="col-sm-9">
							<img src="{{ asset('/images/doctor.png') }}" alt="Avatar" class="avatar" style="vertical-align: middle; width: 120px; height: 120px;border-radius: 50%;">
						</div>
					</div>
				</div>
			</div>

			<div class="card">
				<div class="card-header"><h5>Family Information</h5></div>
				<div class="card-body pt-2">
					<div class="form-group row">
						<label for="doctor_father" class="col-sm-3 col-form-label col-form-label-sm">Father</label>
						<div class="col-sm-9">
							{{ $data->father_name }}
						</div>
					</div>
					<div class="form-group row">
						<label for="doctor_mother" class="col-sm-3 col-form-label col-form-label-sm">Mother</label>
						<div class="col-sm-9">
							{{ $data->mother_name }}
						</div>
					</div>
					<div class="form-group row">
						<label for="doctor_spouse" class="col-sm-3 col-form-label col-form-label-sm">Spouse</label>
						<div class="col-sm-9">
							{{ $data->spouse_name }}
						</div>
					</div>
				</div>
			</div>

			<div class="card">
				<div class="card-header"><h5>Emergency Contact</h5></div>
				<div class="card-body pt-2">
					<div class="form-group row">
						<label for="doctor_emergency_contact_name" class="col-sm-3 col-form-label col-form-label-sm">Name</label>
						<div class="col-sm-9">
							{{ $data->emergency_contact_name }}
						</div>
					</div>

					<div class="form-group row">
						<label for="doctor_emergency_contact_address" class="col-sm-3 col-form-label col-form-label-sm">Address</label>
						<div class="col-sm-9">
							{{ $data->emergency_contact_addr  }}
						</div>
					</div>

					<div class="form-group row">
						<label for="doctor_emergency_contact_relation" class="col-sm-3 col-form-label col-form-label-sm">Relation</label>
						<div class="col-sm-9">
							{{ $data->emergency_contact_relation }}
						</div>
					</div>

					<div class="form-group row">
						<label for="doctor_emergency_contact_contact" class="col-sm-3 col-form-label col-form-label-sm">Contact</label>
						<div class="col-sm-9">
							{{ $data->emergency_contact_contact  }}
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="card">
		<div class="card-body p-2">
			<button class="btn btn-danger btn-sm" onclick="" data-func="" data-dismiss="modal"> Close </button>
			{{-- <button type="submit" class="btn btn-success btn-sm float-right" onclick="btnSaveUpdate(this)">Save</button> --}}
		</div>
	</div>
</form>
