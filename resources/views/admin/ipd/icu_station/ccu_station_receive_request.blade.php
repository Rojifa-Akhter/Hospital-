<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<style>
	.participent_img{
		width: 50px;
		border: 1px solid #d2d2d2;
		margin-right: 5px;
	}
</style>
<div class="container-fluid">
	<div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm align-items-center">
		<div class="col-md-6">
			<h5 class="mt-2 mb-0">CCU Station</h5>
			<small>IPD / CCU Station</small>
		</div>
	</div>

	<div class="form-row">
		<div class="col-md-12 mt-2">
			<ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
					<a class="nav-link" id="received-patient-tab" href="{{ route('ipd.ccu-station-received-patient') }}" rel="tab" role="tab" aria-controls="received-patient" aria-selected="false">Received Patient</a>
				</li>
				<li class="nav-item" role="presentation">
					<a class="nav-link active" id="receive-request-tab" data-toggle="tab" href="#receive-request" role="tab" aria-controls="receive-request" aria-selected="false">Receive Request</a>
				</li>


			</ul>

			<div class="tab-content p-0 bg-transparent" id="myTabContent">
				<div class="tab-pane fade active show" id="receive-request" role="tabpanel" aria-labelledby="receive-request-tab">
					<div class="card">
						<div class="card-header text-primary"><h5>Receive Request</h5></div>
						<div class="card-body">
							<div class="form-row justify-content-center border-bottom mb-2">
								<div class="col-md-3">
									<div class="form-group">
										<label class="col-form-label col-form-label-sm" for="nurse_station">Nurse Station</label>
										<select class="form-control form-control-sm select2" id="nurse_station" name="nurse_station">
											<option value="">Select Nurse Station</option>
											@if(!empty($ipds_nsds))
												@foreach($ipds_nsds as $ipds_ns)
													<option value="{{ $ipds_ns->nsds_no_pk}}">{{ $ipds_ns->nsds_name}}</option>
												@endforeach
											@endif
										</select>
									</div>
								</div>
							</div>

							<div class="form-row">
								<div class="col-12 table-responsive" >
									<table class="table data-table border table-striped table-bordered table-hover mb-0 nu-dt">
										<thead class="global-uhl-table-bg">
											<tr>
												<th class="text-center">SL</th>
												<th class="text-center">Patient Name</th>
												<th class="text-center">Prescription ID</th>

												<th class="text-center">Adm. Date</th>
												<th class="text-center">Adm. ID</th>
												<th class="text-center">Department</th>
												<th class="text-center">Request Ward Name</th>
												<th class="text-center">Doctor Name</th>
												<th class="text-center">Actions</th>
											</tr>
										</thead>
										<tbody>
											@if(!empty($icu_rcvRequests))
                                                @foreach($icu_rcvRequests as $rcvReq)
													<tr>
														<td class="text-center">{{ $loop->iteration }}</td>
														<td class="text-left">
															<div class="participent_info d-flex align-items-center">
																<div class="participent_img">
																	@if(!empty($rcvReq->patient_photo))
																		<img class="w-100" src="{{asset ('images/uploads/patient_images/thumb/')}}/{{$rcvReq->patient_photo }}" alt="">
																	@else
																		<img class="w-100" src="{{ asset('images/doctor.png') }}" alt="">
																	@endif
																</div>

																<div class="participent_details">
																	<span class="d-block">{{ !empty($rcvReq->patient_name)? $rcvReq->patient_name: '' }}</span>

																</div>
															</div>
														</td>
														<td class="text-left">{{ !empty($rcvReq->prescription_uid)? $rcvReq->prescription_uid: '' }}</td>
														<td class="text-left">{{ !empty($rcvReq->admission_date)? date('d/m/Y', strtotime($rcvReq->admission_date)): '' }}</td>
														<td class="text-left">{{ !empty($rcvReq->admission_uid)? $rcvReq->admission_uid: '' }}</td>
														<td class="text-left">{{ !empty($rcvReq->admitted_department)? $rcvReq->admitted_department: '' }}</td>
														<td class="text-center">{{ !empty($rcvReq->ward_name)? $rcvReq->ward_name: '' }}</td>
														<td class="text-center">{{ !empty($rcvReq->primary_doctor_name)? $rcvReq->primary_doctor_name: '' }}</td>
														<td class="text-center">
															<button title="Receive the Patient"
																	type="button"
																	data-admission-pk="{{ $rcvReq->admission_no_pk }}"
																	class="btn btn-success btn-sm nurse-pat-receive-btn">Receive</button>

                                                                    {{-- <span class="btn btn-md btn-info open-modal" data-id="{{$rcvReq->admission_no_pk }}" data-action="{{route('ipd.patient-history-form',$rcvReq->admission_no_pk )}}" data-modal="common-modal-xl" data-title="Patient History" title="Financial Clearance">
                                                                        Patient History
                                                                        </span> --}}
														</td>
													</tr>
                                                @endforeach
                                            @endif

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
</div>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script>
    $(document).ready(function () {
        // SideBar Collapse
        $("body").addClass("sidebar-collapse");

        $('.nu-dt').DataTable({
            "ordering": false,
            "bPaginate": true,
            "bLengthChange": false,
            "bAutoWidth": false
        });

        $('.date-picker').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
            clearBtn: true,
        });

        openPatientAutocomplete('#service_id', 'service_number');


		$('.select2').select2({});

		$(document).on('click', '.nurse-pat-receive-btn', function (e) {
			e.preventDefault()
			var nurseStation = parseInt($('#nurse_station').val())
			var admissionNoPk =  parseInt($(this).attr('data-admission-pk'))
			if (isNaN(nurseStation)) {
				alert('Please, Select a Nurse Station.')
				e.stopImmediatePropagation();
				return false
			}
			if (!confirm("Are you sure?")) {
				e.stopImmediatePropagation();
				return false
			}
			var response_action = "{{ route('ipd.icu-station-received-patient') }}"
			$.ajax({
				async: true,
				data: {
					nurse_station: nurseStation,
					admission_no_pk: admissionNoPk,
				},
				url: "{{ route('ipd.nurse-station-receive-a-patient') }}",
				type: 'post',
				beforeSend: function() {
					if (isAModalOpen)
						$('.modal').modal('hide');
					blockUI();
				},
				success: function(data) {
					if (data.title == 'Success') {
						$('.common-modal-notify').modal('show');
						$('.common-modal-notify .modal-body').html(
								"<i class='fas fa-stroopwafel fa-spin'></i>");
						$('.common-modal-notify .modal-title').html(data.title);
						$('.common-modal-notify .modal-body').html(data.msg);
					}
				},
				error: function(data) {
					var errors = jQuery.parseJSON(data.responseText).errors;
					error_messages = "";
					for (messages in errors) {
						var field_name = $("#" + messages).siblings("label").html();
						error_messages += "<div class='alert alert-danger' role='alert'>" +
								errors[messages] + "</div>";
					}

					$('.common-modal-notify-error').modal('show');
					$('.common-modal-notify-error .modal-title').html("Validation Error");
					$('.common-modal-notify-error .modal-body').html(error_messages);

					$.unblockUI();
				}
			}).done(function() {
				$.unblockUI();
				dynamicFunc.afterSaveLoadPage(response_action);
			});
			e.stopImmediatePropagation();

		})
    })
</script>
