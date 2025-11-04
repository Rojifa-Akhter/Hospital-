<div class="card">
	<div class="card-header"><h5><i class="fa fa-search"></i> Search Panel</h5></div>
	<div class="card-body pt-2">
		<form id="frmSearch" method="post" action="{{ route('appointments.appointments_list_print') }}">
			@csrf
			<input type="hidden" id="page-view-type" name="page_view_type" value="{{ $page_type}}">
			<div class="form-group row">
				<div class="col-sm-2">
					<label for="app_date">Appointment Date</label>
					<input type="text" class="form-control date_picker" name="app_date" id="app_date" autocomlete="off" placeholder="Appointment Date" />
				</div>
				<!-- <div class="col-sm-2">
					<label for="doctor_code">Doctor</label>
					<input type="text" class="form-control" id="doctor_code" name="doctor_code" placeholder="Code/Name/Mobile/SPL." title="Search by Code/ Name/ Mobile/ Specialization">
					<input type="hidden" class="form-control" id="hdn_doctor_id" name="hdn_doctor_id" >
				</div> -->
				<div class="col-sm-2">
					<label for="patient_id">Patient</label>
					<input type="text" class="form-control" id="patient_id" name="patient_id" placeholder="Patient ID/Name/Mobile" title="Search By Patient ID/ Name/ Mobile" />
					<input type="hidden" class="form-control" id="hdn_patient_id" name="hdn_patient_id" />
				</div>
				<div class="col-sm-2">
					<label for="cheif_compl">Chief Complaint</label>
					<select class="form-control form-control-sm select2" id="cheif_compl" name="cheif_compl">
						<option value="">Select</option>
						@if(!empty($chiefcom))
						@foreach($chiefcom as $key=>$value)
						<option value="{{ $key }}">{{ $value }}</option>
						@endforeach
						@endif
					</select>
				</div>
				<div class="col-sm-2">
					<label for="app_priority">Priority</label>
					<select class="form-control font_size_12 m-auto select2" id="app_priority" name="app_priority">
						<option value="0">Select</option>
						@if(!empty($priority))
						@foreach($priority as $key=>$value)
						<option value="{{ $key }}">{{ $value }}</option>
						@endforeach
						@endif
					</select>
				</div>
				<div class="col-sm-2">
					<br/>
					<button type="button" class="btn btn-success btn-sm" id="btnSearchReport">Search</button>
                    <button type="submit" title="Print Appointment List" target="_blank"
                            class="btn btn-primary btn-sm btn-right mb-2 float-right">Export PDF</button>
				</div>
			</div>
		</form>
	</div>
</div>
