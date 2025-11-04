<div class="row">
	<div class="col-md-6">
		{{-- <div class="card">
			
			<div class="card-header">Schedule Information</div>
			<div class="card-body pt-2">
				<div class="form-group row">
					<label for="doctor_name" class="col-sm-2 col-form-label col-form-label-sm">Schedule Date</label>
					<div class="col-sm-10">
						<div class="input-group">
							<div class="input-group-prepend">
								@if(!empty($schedule_data))
								@foreach($schedule_data as $value) 
								{{ date('Y-m-d',strtotime($value->schedule_dt)) }} ,
								@endforeach
								@endif 

							</div>
						</div>
					</div>
				</div>				
			</div>
		</div> --}}
		<div class="card">
			<div class="card-header">Doctor Information</div>
			<div class="card-body pt-2">
				<div class="form-group row">
					<label for="doctor_name" class="col-sm-2 col-form-label col-form-label-sm">Doctor Name</label>
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
				</div>
				<div class="form-group row">					
					<label for="doctor_religion" class="col-sm-2 col-form-label col-form-label-sm">Religion</label>
					<div class="col-sm-4">
						{{ $data->religion }}
					</div>
					<label for="doctor_nationality" class="col-sm-3 col-form-label col-form-label-sm">Nationality</label>
					<div class="col-sm-3">
						{{ $data->nationality }}
					</div>
				</div>
			</div>
		</div>		
	</div>
	<div class="col-md-3">
		<div class="card">
			<div class="card-header">Other Information</div>
			<div class="card-body pt-2">
				<div class="form-group row">
					<label for="doctor_ser_unit" class="col-sm-6 col-form-label col-form-label-sm">Specialization</label>
					<div class="col-sm-6">
						{{ $data->specialization }}
					</div>			
				</div>
				<div class="from-group row">
					<label for="doctor_job_type" class="col-sm-6 col-form-label col-form-label-sm">Mobile</label>
					<div class="col-sm-6">
						{{ $data->phone_mobile }}
					</div>
				</div>
				<div class="from-group row">
					<label for="doctor_job_type" class="col-sm-6 col-form-label col-form-label-sm">Email</label>
					<div class="col-sm-6">
						{{ $data->email_personal }}
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="card">
			<div class="card-header"><h5>Employee Image</h5></div>
			<div class="card-body pt-2">
				<div class="form-group row">
					<label for="doctor_photo" class="col-sm-3 col-form-label col-form-label-sm">Photo</label>
					<div class="col-sm-9">
						<img src="{{ asset('/images/doctor.png') }}" alt="Avatar" class="avatar" style="vertical-align: middle; width: 90px; height: 90px;border-radius: 50%;">
					</div>
				</div>
			</div>
		</div>
	</div>
	{{-- Search Work  --}}
	<div class="col-md-12">
		<div class="card">
		<div class="card-header"><h5><i class="fa fa-search"></i> Search</h5></div>
		<div class="card-body">
			<form action="" id="seduleDataSerchForm" method="post">
				@csrf
				<div class="form-row justify-content-center">
					<input type="hidden" value="{{$data->person_no_pk}}" name="person_data" id="person_data">
					<div class="col-md-4">
						<div class="form-group">
							<label class="col-form-label col-form-label-sm" for="search_date_from">Date</label>
							<div class="input-group">
								<div class="input-group-prepend">
									<div class="input-group-text">From</div>
								</div>
								<input type="text" class="form-control form-control-sm m-0 date_picker" id="search_date_from" name="search_date_from" value="{{date('m/d/Y')}}" placeholder="yyyy-mm-dd" autocomplete="off">
								<div class="input-group-prepend">
									<div class="input-group-text">To</div>
								</div>
								<input type="text" class="form-control form-control-sm m-0 date_picker" id="search_date_to" name="search_date_to" value="{{date('m/d/Y', strtotime('+7 days'))}}" placeholder="yyyy-mm-dd" autocomplete="off">
							</div>
						</div>
					</div>
					<div class="col-md-2">
						<div class="btn-group btn-block" role="group">
							<button type="button" id="schedule_search"  class="btn btn-md btn-success btn-block mt-4">Search</button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>

	<div class="card">
		<div class="card-body p-2">
			<div class="form-row">
				<div class="col-md-12" id="schedule_data">
					@include('admin.appointment.schedule_all_data')
				</div>
			</div>
		</div>
	</div>
	</div>
	



	{{-- Search End  --}}
</div>
<div class="card">
	<div class="card-body p-2">
		<button class="btn btn-danger btn-sm" onclick="" id="" data-func="" data-dismiss="modal"> Close </button>
		{{-- <button type="submit" class="btn btn-success btn-sm float-right" onclick="btnSaveUpdate(this)">Save</button> --}}
	</div>
</div>



<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript">
	$(function() {
		$('.date_picker').datepicker({
			todayHighlight: true,
			clearBtn: true,
			autoclose: true,
		});
	});

	$(document).on("click", "#schedule_search", function(e) {
		var formID = $("#seduleDataSerchForm").attr("id");
		var formMethod = $("#seduleDataSerchForm").attr("method");
		// var person_data = $('#person_data').val();
		$.ajax({
			data: $('#' + formID).serialize(),
			url:"{{ url('apointment.schedule_search_data') }}",
			type: formMethod,
			beforeSend: function() {
				blockUI();

			},
			success: function(data) {
				$("#schedule_data").html(data);
			},
			complete: function() {
				$.unblockUI();
			}
		});
	});
	
	$(document).on("click", "#schedule_search", function(e) {
		var formID = $("#seduleDataSerchForm").attr("id");
		var formMethod = $("#seduleDataSerchForm").attr("method");
		// var person_data = $('#person_data').val();
		$.ajax({
			data: $('#' + formID).serialize(),
			url:"{{ url('apointment.schedule_search_data') }}",
			type: formMethod,
			beforeSend: function() {
				blockUI();

			},
			success: function(data) {
				$("#schedule_data").html(data);
			},
			complete: function() {
				$.unblockUI();
			}
		});
	});
</script>