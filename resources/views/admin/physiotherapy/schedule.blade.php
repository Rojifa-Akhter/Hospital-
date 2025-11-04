<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('asset/timepicker/css/timepicker.css') }}">
<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<style>
	.patientInfo_schedule_view .patient_information_radiology  {
		border: 5px solid #eaeaea;
		padding: 0px 20px;
		margin-bottom: 20px;
	}


	.patientInfo_schedule_view .patient_img_radiology img {
		height: 72px;
		width: 72px;
	}

	.schedule_view h5{
		font-size: .9rem;
	}

</style>

<section id="full_appointment">
	<div class="container-fluid">
		<div class="row bg-white border-bottom sticky-top shadow-sm">
			<div class="col-md-12 mb-1">
				<h5 class="mt-2 mb-0">Physiotherapy Schedule</h5>
				<small>Physiotherapy / Physiotherapy Schedule</small>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12 col-lg-3 col-xl-3">
				<div class="card">
					<div class="card-header">Physiotherapy Schedule</div>
					<div class="card-body">
						<form action="">
							<div class="form-group row mt-2">
								<div class="col-sm-6">
									<label class="col-form-label col-form-label-sm" for="patient_ID">Patient ID</label>
									<select class="form-control select2 form-control-sm required" id="patient_ID" name="patient_ID" required="required">
										<option value="">Select Patient ID</option>
										<option value="">Patient-ID-1</option>
										<option value="">Patient-ID-2</option>
										<option value="">Patient-ID-3</option>
										<option value="">Patient-ID-4</option>
										<option value="">Patient-ID-5</option>
									</select>
								</div>

								<div class="col-sm-6">
									<label class="col-form-label col-form-label-sm" for="prescription_ID">Prescription ID</label>
									<select class="form-control select2 form-control-sm required" id="prescription_ID" name="prescription_ID" required="required">
										<option value="">Select Prescription ID</option>
										<option value="">Prescription-ID-1</option>
										<option value="">Prescription-ID-2</option>
										<option value="">Prescription-ID-3</option>
										<option value="">Prescription-ID-4</option>
										<option value="">Prescription-ID-5</option>
									</select>
								</div>

								<div class="col-sm-12">
									<label class="col-form-label col-form-label-sm" for="therapy_name">Therapy Name</label>
									<select class="form-control select2 form-control-sm required" id="therapy_name" name="therapy_name" required="required">
										<option value="">Select Therapy Name</option>
										<option value="">Therapy-1</option>
										<option value="">Therapy-2</option>
										<option value="">Therapy-3</option>
										<option value="">Therapy-4</option>
										<option value="">Therapy-5</option>
									</select>
								</div>

								<div class="col-md-12">
									<div class="form-group">
										<label class="col-form-label col-form-label-sm" for="therapy_duration">Duration</label>
										<div class="input-group">
											<div class="input-group-prepend">
												<input type="text" class="form-control" id="therapy_duration" name="therapy_duration" placeholder="Duration">
											</div>
											<select class="form-control form-control-sm" id="duration_value" name="duration_value">
												<option value="">Select Duration</option>
												<option value="">Hours</option>
												<option value="">Day</option>
												<option value="">Month</option>
												<option value="">yers</option>
											</select>
										</div>
									</div>
								</div>

								<div class="col-md-12">
									<div class="form-group">
										<label class="col-form-label col-form-label-sm" for="total_session">Total Session</label>
										<input type="text" class="form-control" id="total_session" name="total_session" placeholder="Total Session">
									</div>
								</div>

								<div class="col-md-12">
									<div class="form-group">
										<label class="col-form-label col-form-label-sm" for="session_length">Session Length</label>
										<div class="input-group">
											<div class="input-group-prepend">
												<input type="text" class="form-control" id="session_length" name="session_length" placeholder="Session Length">
											</div>
											<select class="form-control form-control-sm" id="length_value" name="length_value">
												<option value="">Select Length</option>
												<option value="">Hours</option>
												<option value="">Day</option>
												<option value="">Month</option>
												<option value="">yers</option>
											</select>
										</div>
									</div>
								</div>

								<div class="col-md-12">
									<div class="form-group">
										<label class="col-form-label col-form-label-sm" for="start_date">Start Date-Time</label>
										<div class="input-group">
											<div class="input-group-prepend">
												<input type="text" class="form-control" id="start_date" name="start_date" placeholder="Start Date">
											</div>
											<input type="text" class="form-control" id="start_time" name="start_time" placeholder="Start Time">
										</div>
									</div>
								</div>

								<div class="col-md-12">
									<div class="form-group">
										<label class="col-form-label col-form-label-sm" for="end_date">End Date-Time</label>
										<div class="input-group">
											<div class="input-group-prepend">
												<input type="text" class="form-control" id="end_date" name="end_date" placeholder="End Date">
											</div>
											<input type="text" class="form-control" id="end_time" name="end_time" placeholder="End Time">
										</div>
									</div>
								</div>

								<div class="col-md-12 text-right">
									<button class="btn btn-sm btn-save">Save</button>
									<button class="btn btn-sm btn-print">Print</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>

			<div class="col-sm-12 col-lg-9 col-xl-9">
				<div class="card">
					<div class="card-header">Physiotherapy Schedule Viewer <span id="doct_name"></span></div>
					<div class="card-body pt-2 schedule_view">
						<div class="row">
							<div class="col-md-12 mb-3">
							</div>
							<div class="col-12">
								<h5><strong>Therapy Name :</strong> <span>Therapy-1</span></h5>
							</div>
							<div class="col-md-12">
								<div class="table-responsive">
									<table class="table table-bordered table-striped table-hover">
										<thead class="bg-primary">
											<tr>
												<th>Session Number</th>
												<th>From</th>
												<th>To</th>
												<th>Duration (Days)</th>
												<th>Total Session</th>
												<th>Session Length(Hour)</th>
												<th>Start Time</th>
												<th>End Time</th>
												<th></th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td class="text-center">01</td>
												<td class="text-center">9/4/2020</td>
												<td class="text-center">9/4/2020</td>
												<td class="text-center">10</td>
												<td class="text-center">5</td>
												<td class="text-center">1</td>
												<td class="text-center">8:00 AM</td>
												<td class="text-center">9:00 AM</td>
												<td class="text-center"><button class="btn btn-sm btn-delete fa fa-times"></button></td>
											</tr>
											<tr>
												<td class="text-center">02</td>
												<td class="text-center">10/4/2020</td>
												<td class="text-center">10/4/2020</td>
												<td class="text-center">10</td>
												<td class="text-center">5</td>
												<td class="text-center">1</td>
												<td class="text-center">9:00 AM</td>
												<td class="text-center">10:00 AM</td>
												<td class="text-center"><button class="btn btn-sm btn-delete fa fa-times"></button></td>
											</tr>
											<tr>
												<td class="text-center">03</td>
												<td class="text-center">11/4/2020</td>
												<td class="text-center">11/4/2020</td>
												<td class="text-center">10</td>
												<td class="text-center">5</td>
												<td class="text-center">1</td>
												<td class="text-center">11:00 AM</td>
												<td class="text-center">12:00 AM</td>
												<td class="text-center"><button class="btn btn-sm btn-delete fa fa-times"></button></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-12">
								<h5><strong>Therapy Name :</strong> <span>Therapy-4</span></h5>
							</div>
							<div class="col-md-12">
								<div class="table-responsive">
									<table class="table table-bordered table-striped table-hover">
										<thead class="bg-primary">
											<tr>
												<th>Session Number</th>
												<th>From</th>
												<th>To</th>
												<th>Duration (Days)</th>
												<th>Total Session</th>
												<th>Session Length(Hour)</th>
												<th>Start Time</th>
												<th>End Time</th>
												<th></th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td class="text-center">01</td>
												<td class="text-center">12/4/2020</td>
												<td class="text-center">12/4/2020</td>
												<td class="text-center">12</td>
												<td class="text-center">2</td>
												<td class="text-center">1</td>
												<td class="text-center">8:00 AM</td>
												<td class="text-center">11:00 AM</td>
												<td class="text-center"><button class="btn btn-sm btn-delete fa fa-times"></button></td>
											</tr>
											<tr>
												<td class="text-center">02</td>
												<td class="text-center">13/4/2020</td>
												<td class="text-center">13/4/2020</td>
												<td class="text-center">12</td>
												<td class="text-center">2</td>
												<td class="text-center">1</td>
												<td class="text-center">9:00 AM</td>
												<td class="text-center">12:00 AM</td>
												<td class="text-center"><button class="btn btn-sm btn-delete fa fa-times"></button></td>
											</tr>
											<tr>
												<td class="text-center">03</td>
												<td class="text-center">14/4/2020</td>
												<td class="text-center">14/4/2020</td>
												<td class="text-center">12</td>
												<td class="text-center">2</td>
												<td class="text-center">1</td>
												<td class="text-center">10:00 AM</td>
												<td class="text-center">1:00 PM</td>
												<td class="text-center"><button class="btn btn-sm btn-delete fa fa-times"></button></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- datepicker -->
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('asset/timepicker/js/timepicker.js') }}"></script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
	$(function() {
		$('.select2').select2();
		$('.date_picker').datepicker();
		$('.timepicker').timepicker({});
	})

</script>
