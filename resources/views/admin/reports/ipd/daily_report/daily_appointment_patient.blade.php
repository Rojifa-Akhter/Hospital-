<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<style>
    .sorting{
		background-image:none !important;
	}
	.doctor_info img{
            padding: 5px;
            width: 40px;
            float: left;
            border: 1px solid #222;
            border: 1px solid #95e0b3;
            margin: 0 5px;
        }

        .doctor_info .doctor_info_data{
            margin-left: 10px;
        }

        .doctor_info .doctor_info_data ul{
            margin: 0px;
        }
</style>

<section id="report_section">
	<div class="container-fluid">
		<div class="card">
			<div class="card-header"><h5>Daily Appointment Patient Report </h5></div>
			<div class="card-body pt-2 bg-light">
				<form id="frmFinancialSearch" method="post" action="{{ route('reports.get-daily-report') }}">
					@csrf
					<div class="form-group row">
						<div class="col-sm-2">
							<label for="patient_id">Patient ID </label>
							<input type="text" class="form-control" name="patient_id" id="patient_id" autocomlete="off" placeholder="Patient ID/Name/Mobile" />
							<input type="hidden" class="form-control" id="hdn_patient_id" name="hdn_patient_id" />
						</div>
						<div class="col-sm-2">
							<label for="appointment_id">Appointment No</label>
							<input type="text" class="form-control" name="appointment_id" id="appointment_id" placeholder="Appointment Code" autocomlete="off" />
							<input type="hidden" class="form-control" id="hdn_appoint_id" name="hdn_appoint_id" />
							<p id="appoint_info" style="display: none"></p>
						</div>
						<div class="col-sm-2">
							<label for="referral_doctor">Doctors </label>
							<input type="text" class="form-control" id="first_referral" name="first_referral" placeholder="Doctor ID/Name/Mobile">
							<input type="hidden" class="form-control" id="hdn_first_referral_id" name="hdn_first_referral_id" >
						</div>
						<div class="col-sm-4">
							<div class="row">
								<div class="col-sm-6" style="margin-right: -30px;">
									<label for="type">From</label>
									<input type="text" class="form-control date_picker" name="date_from" id="date_from" autocomlete="off" placeholder="From Date" />
								</div>
								<div class="col-sm-6">
									<label for="type">To </label>
									<input type="text" class="form-control date_picker" name="date_to" id="date_to" autocomlete="off" placeholder="To Date" />
								</div>
							</div>
                        </div>
						<div class="col-sm-2">
							<label class="mt-4">&nbsp;</label>
							@php $action = route('daily-appointed-list'); @endphp
							<button type="button" class="btn btn-success btn-sm" onclick="generateReport(this, 'frmFinancialSearch', '{{ $action }}')">Search</button>

							<label class="mt-4">&nbsp;</label>
							<a href="{{ route('report.daily-appointed-print') }}" title="Print Daily Appointment Patient" target="_blank" class="btn btn-primary btn-sm">Export PDF</a>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="card">
			<div class="card-header "><h5>Daily Appointment Patient</h5></div>
			<div class="card-body">
				<div class="row mt-2" id="financial-list">
					@include('admin.reports.daily_report.daily_appointment_patient_table')
				</div>
			</div>
		</div>
	</div>
</section>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>

	$(document).ready(function () {
		$('.date_picker').datepicker();
		$('data-table').DataTable();

		$("#sidebar-left").addClass("active");
		$("#content").addClass("active");

		openPatientAutocomplete('#patient_id');
		openAppointmentAutocomplete('#appointment_id');
		openDoctorAutocomplete('#first_referral', 'hdn_first_referral_id', 'Y');
	});
</script>
