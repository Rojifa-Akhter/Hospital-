<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

<section id="full_doctor_list">
	<div class="container-fluid">
		<div class="row bg-white border-bottom sticky-top shadow-sm">
			<div class="col-md-12 mb-1">
				<h5 class="mt-2 mb-0">Appointment List</h5>
				<small>Appointments / Appointment List</small>
			</div>
		</div>
		@include('admin.appointment.appointment_search_form')
		<div class="card">
			<div class="card-header"><h5>Appointed Patient List</h5></div>
			<input type="hidden" id="page-view-type" value="grid">
			<div id="appointment-list">
				@include('admin.physiotherapy.prescription.ptherapy_appointment_list_card')
			</div>
		</div>
	</div>
</section>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="text/javascript">
	openPatientAutocomplete('#patient_id');
	openDoctorAutocomplete('#doctor_code', 'hdn_doctor_id');
	$(document).ready(function () {
		$('.select2').select2();
		$('.data-table').DataTable({
			"ordering": false
		});

		var date = new Date();
		var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
		$('.date_picker').datepicker('setDate', today);

		$(document).on("click", "#btnSearchAppointment",function(e){
			appointmentEngine.searchAppointment($(this));
			e.stopImmediatePropagation();
			return;
		});

		$(document).on("click","#btnConsulationConfirm", function(e){
			appointmentEngine.payConsultationBill($(this));
			e.stopImmediatePropagation();
			return;
		});
	});
</script>
