<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/buttons.dataTables.min.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

<section id="full_appointment">
	<div class="container-fluid">
		<div class="row bg-white border-bottom sticky-top shadow-sm">
			<div class="col-md-10 mb-1">
				<h5 class="mt-2 mb-0">
					Free Appointment List</h5>
				<small>Appointments / Appointment List</small>
			</div>
			<div class="col-md-2 mt-3">
				<a class="btn bg-navy text-white btn-md" href="{{ route('appointments.create') }}" rel="tab"><i class="far fa-calendar"></i> New Appointment</a>
			</div>
		</div>
		@include('admin.patient.free_patient.appointment_search_form')
		<div class="card">
			{{-- <div class="card-header ">
				<h5>Appointed Patients List ( <span class="text-danger">{{ $appointment_date }}</span> )</h5>
			</div> --}}

			@include('admin.patient.free_patient.appointment_list_header_stat')

			<div id="appointment-list">
				<div class="table-responsive">
					<div class="card-body mt-3">
						<table class="table data-table table-striped table-bordered table-hover">
							<thead class="bg-primary">
								<tr>
									<th class="text-center" scope="col">SL</th>
									<th class="text-center" scope="col">Appointment No</th>
									<th class="text-center" scope="col">Date</th>
									<th class="text-center " scope="col">Doctor</th>
									<th class="text-center " scope="col">Patient</th>
									{{-- <th class="text-center" scope="col">CC</th>
									<th class="text-left" scope="col">Priority</th> --}}
									<th class="text-center" scope="col">Patient Type</th>
									<th class="text-left" scope="col">Status</th>
									<th class="text-center" scope="col" style="width: 16%;">Action</th>
								</tr>
							</thead>
							<tbody id="search-container">
								@include('admin.patient.free_patient.appointment_list_table')
							</tbody>
						</table>
					</div>
				</div>

			</div>
		</div>
	</div>
</section>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/dataTables.buttons.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/buttons.colVis.min.js') }}"></script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="text/javascript">
	openPatientAutocomplete('#patient_id');
	openDoctorAutocomplete('#doctor_code', 'hdn_doctor_id');
    $(document).on('click','.pdf_excel',function(){
        console.log($(this).attr("data-type"));
        var pdf=$(this).attr("data-type");
        $('#print_type').val(pdf);


    })
	$(document).ready(function() {
		$('.select2').select2();
		$('.data-table').DataTable({
			"ordering": false,
			"bPaginate": false,
			"bLengthChange": false,
			"bAutoWidth": false,
			dom: 'lBfrtip &nbsp;<"actions">',
			buttons: [

			],
		});

		$(document).on("click", "#btnSearchReport", function(e) {
			var formID = $("#frmSearch").attr("id");
			// var formAction = $("#frmSearch").attr("action");
			var formMethod = $("#frmSearch").attr("method");

			$.ajax({
				data: $('#' + formID).serialize(),
				url: "{{ url('/get-free-appointment-list') }}",
				type: formMethod,
				beforeSend: function() {
					blockUI();

				},
				success: function(data) {
					$("#search-container").html(data);
				},
				complete: function() {
					$.unblockUI();
				}
			});
		});

		var date = new Date();
		var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
		// $('.date_picker').datepicker('setDate', today);
		$('.date_picker').datepicker({
			format: 'dd-mm-yyyy',
			autoclose: true,
			todayHighlight: true,
			clearBtn: true,

		});

		$(document).on("click", "#btnSearchAppointment", function(e) {
			appointmentEngine.searchAppointment($(this));
			e.stopImmediatePropagation();
			return;
		});

		$(document).on("click", "#btnConsulationConfirm", function(e) {
			appointmentEngine.payConsultationBill($(this));
			e.stopImmediatePropagation();
			return;
		});
	});
</script>
