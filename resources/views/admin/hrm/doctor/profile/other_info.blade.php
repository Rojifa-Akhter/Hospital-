<style>
    .redactor_.redactor_editor {
        color: #222 !important;
    }
</style>
<link href="{{ asset('css/redactor.css') }}" rel="stylesheet">
<div class="card">
	<div class="card-header" style="color: #0b2e13;"><h5>Other Information</h5></div>
	<div class="card-body">
		<form method="post" id="doctor_info_view" action="{{ route('profile-update') }}">
			@csrf
			<input type="hidden" name="id" value="{{ $doctor_no_pk }}">
			<input type="hidden" name="tab_type" value="3" id="tab_type">
			<div class="form-row align-items-center">
				<div class="col-md-6">
					<div class="form-row">
						<div class="col-md-6">
							<label for="o_full_name" class="col-form-label col-form-label-sm">Full Name </label>
							<input type="text" class="form-control form-control-sm keep_me" id="o_full_name"
							name="full_name" value="{{$doctor_full_name}}"
							placeholder="Full Name">
						</div>
						<div class="col-md-6">
							<label for="user_name" class="col-form-label col-form-label-sm">Degree 1 </label>
							<input type="text" class="form-control form-control-sm keep_me"
							id="doctor_degree1" name="doctor_degree1" value="{{ $doctor_degree1 }}" placeholder="Degree 1">
						</div>
						<div class="col-md-6">
							<label for="service_id" class="col-form-label col-form-label-sm">Degree 2 </label>
							<input type="text" class="form-control form-control-sm keep_me"
							id="doctor_degree2" name="doctor_degree2" value="{{ $doctor_degree2 }}" placeholder="Degree 2">
						</div>
						<div class="col-md-6">
							<label for="service_id" class="col-form-label col-form-label-sm">Degree 3 </label>
							<input type="text" class="form-control form-control-sm keep_me"
							id="doctor_degree3" name="doctor_degree3" value="{{ $doctor_degree3 }}" placeholder="Degree 3">
						</div>

						@if($ses_job_type_name == "DR")
						<div class="col-md-6">
							<label for="service_id" class="col-form-label col-form-label-sm">Change Hospital </label>
							<select class="form-control form-control-sm" id="change_hospital" name="change_hospital">
								<option>Select</option>
								@if(!empty($hospital))
								@foreach ($hospital as $value)
								<option value="{{$value->hospital_no_pk}}_{{$value->hospital_name}}" {{ ($ses_current_hospital == $value->hospital_no_pk ) ? 'selected' : ''}}>  {{$value->hospital_name}} </option>
								@endforeach
								@endif
							</select>

						</div>
						@endif
					</div>
				</div>
				<div class="col-md-6 ">
					<div class="card-body mt-2 form-group col-md-12 ">
						<label for="signature" class="col-form-label col-form-label-sm"> Signature</label>
						<textarea id="signature" name="signature"  placeholder="Signature Here" >{{$doctor_signature}}</textarea>
					</div>
				</div>
			</div>
			<div class="form-row border-top">
				<div class="form-row border-top">
					@include('admin.hrm.doctor.profile.profile_footer')
				</div>
			</div>
		</form>
	</div>
</div>


<script type="application/javascript" src="{{ asset('js/redactor.js') }}"></script>
<script>
	loadEditor("signature");

</script>
