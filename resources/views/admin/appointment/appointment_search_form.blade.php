

<div class="card">
	<div class="card-header"><h5><i class="fa fa-search"></i> Search Panel</h5></div>
	<div class="card-body pt-2">
		<form id="frmSearch" method="post" action="{{ route('appointments.appointments_list_print') }}" target="_blank">
			@csrf
			<input type="hidden" id="page-view-type" name="page_view_type" value="{{ $page_type}}">
			<div class="form-group row">
				{{-- <div class="col-sm-2">
					<label for="app_date">Appointment Date</label>
					<input type="text" class="form-control date_picker" name="app_date" id="app_date" autocomlete="off" placeholder="Appointment Date" />
				</div> --}}
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="col-form-label col-form-label-sm" for="search_date_from">Date</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">From</div>
                            </div>
                            <input type="text" class="form-control form-control-sm m-0 date_picker"
                                id="search_date_from" name="search_date_from" value=""
                                placeholder="dd-mm-yyyy" autocomplete="off">
                            <div class="input-group-prepend">
                                <div class="input-group-text">To</div>
                            </div>
                            <input type="text" class="form-control form-control-sm m-0 date_picker"
                                id="search_date_to" name="search_date_to" value=""
                                placeholder="dd-mm-yyyy" autocomplete="off">
                        </div>
                    </div>
                </div>

				<div class="col-sm-2">
					<label for="doctor_code">Doctor</label>
					<input type="text" class="form-control" id="doctor_code" name="doctor_code" placeholder="Code/Name/Mobile/SPL." title="Search by Code/ Name/ Mobile/ Specialization">
					<input type="hidden" class="form-control" id="hdn_doctor_id" name="hdn_doctor_id" >
				</div>
				<div class="col-sm-2">
					<label for="doctor_code">User</label>
					<input type="text" class="form-control" id="app_user" name="app_user" placeholder="Code/Name/Mobile." title="Search by Code/ Name/ Mobile/ Specialization">
					<input type="hidden" class="form-control" id="hdn_app_user" name="hdn_app_user" >
				</div>
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
				{{-- <div class="col-sm-2">
					<label for="app_priority">Priority</label>
					<select class="form-control font_size_12 m-auto select2" id="app_priority" name="app_priority">
						<option value="0">Select</option>
						@if(!empty($priority))
						@foreach($priority as $key=>$value)
						<option value="{{ $key }}">{{ $value }}</option>
						@endforeach
						@endif
					</select>
				</div> --}}
			</div>

			<div class="form-group row">
				<div class="col-sm-2">
					<label for="patient_type">Patient Type</label>
					<select class="form-control font_size_12 m-auto select2" id="patient_type" name="patient_type">
						<option value="0">Select</option>
						@if(!empty($patient_type))
						@foreach($patient_type as $value)
						<option value="{{ $value->patient_type_no_pk }}">{{ $value->patient_type_code }}</option>
						@endforeach
						@endif
					</select>
				</div>

				{{-- Status --}}
				<div class="col-sm-2">
					<label for="status">Status</label>
					<select class="form-control form-control-sm select2" id="status" name="status">
						<option value="">Select</option>
						<option value="pending">Pending</option>
						<option value="payment">Payment</option>
						<option value="canceled">Canceled</option>
					</select>
				</div>

				<div class="col-md-3 " style="text-align: left; margin-top:25px">
                    <div>
                        <input type="hidden" id="print_type" name="print_type">

                        <button type="button" class="btn btn-success btn-md mb-2" id="btnSearchReport">Search</button>
                        {{-- <button type="submit" title="Print Appointment List" target="_blank"  class="btn btn-primary btn-sm btn-right mb-2  pdf_excel" data-type="PDF">Export PDF</button> --}}
                         <button type="submit" title="Print Appointment List " target="_blank" class="btn btn-primary btn-md btn-right mb-2  pdf_excel" data-type="PDF">Export PDF</button>
                         <button type="submit" title="Print Appointment List " target="_blank" class="btn btn-primary btn-md btn-right mb-2  pdf_excel" data-type="EXCEL">Excel</button>
                    </div>
				</div>
			</div>
		</form>
        {{-- <form id="frmSearch" method="post" action="{{ route('appointments.appointments_list_print') }}">
            <input type="hidden" class="" name="app_date" id="app_date_excel" />
            <input type="hidden" class="" name="hdn_doctor_id" id="hdn_doctor_id_excel" />
            <input type="hidden" class="" name="hdn_patient_id" id="hdn_patient_id_excel" />
            <input type="hidden" class="" name="cheif_compl" id="cheif_compl_excel" />
            <input type="hidden" class="" name="app_priority" id="app_priority_excel" />

        </form> --}}

	</div>
</div>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script>
    $('.date_picker').datepicker({
			format: 'dd-mm-yyyy',
			autoclose: true,
			todayHighlight: true,
			clearBtn: true,

		});

        $(document).on("click", "#btnSearchReport", function(e) {
			var formID = $("#frmSearch").attr("id");
			var formMethod = $("#frmSearch").attr("method");

			$.ajax({
				data: $('#' + formID).serialize(),
				url: "{{ url('/get-appointment-list') }}",
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

</script>

