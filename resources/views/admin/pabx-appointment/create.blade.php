<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<style>
	.pagination {
		display: inline-block;
		padding-left: 0;
		margin: 15px 0;
		border-radius: 4px;
	}

	.pagination>li {
		display: inline;
	}

	.pagination>li>a,
	.pagination>li>span {
		position: relative;
		float: left;
		padding: 6px 12px;
		margin-left: -1px;
		line-height: 1.42857143;
		color: #428bca;
		text-decoration: none;
		background-color: #fff;
		border: 1px solid #ddd;
	}

	.pagination>li:first-child>a,
	.pagination>li:first-child>span {
		margin-left: 0;
		border-top-left-radius: 4px;
		border-bottom-left-radius: 4px;
	}

	.pagination>li:last-child>a,
	.pagination>li:last-child>span {
		border-top-right-radius: 4px;
		border-bottom-right-radius: 4px;
	}

	.pagination>li>a:hover,
	.pagination>li>span:hover,
	.pagination>li>a:focus,
	.pagination>li>span:focus {
		color: #2a6496;
		background-color: #eee;
		border-color: #ddd;
	}

	.pagination>.active>a,
	.pagination>.active>span,
	.pagination>.active>a:hover,
	.pagination>.active>span:hover,
	.pagination>.active>a:focus,
	.pagination>.active>span:focus {
		z-index: 2;
		color: #fff;
		cursor: default;
		background-color: #428bca;
		border-color: #428bca;
	}

	.pagination>.disabled>span,
	.pagination>.disabled>span:hover,
	.pagination>.disabled>span:focus,
	.pagination>.disabled>a,
	.pagination>.disabled>a:hover,
	.pagination>.disabled>a:focus {
		color: #777;
		cursor: not-allowed;
		background-color: #fff;
		border-color: #ddd;
	}

	.pagination-lg>li>a,
	.pagination-lg>li>span {
		padding: 10px 16px;
		font-size: 18px;
	}

	.pagination-lg>li:first-child>a,
	.pagination-lg>li:first-child>span {
		border-top-left-radius: 6px;
		border-bottom-left-radius: 6px;
	}

	.pagination-lg>li:last-child>a,
	.pagination-lg>li:last-child>span {
		border-top-right-radius: 6px;
		border-bottom-right-radius: 6px;
	}

	.pagination-sm>li>a,
	.pagination-sm>li>span {
		padding: 5px 10px;
		font-size: 12px;
	}

	.pagination-sm>li:first-child>a,
	.pagination-sm>li:first-child>span {
		border-top-left-radius: 3px;
		border-bottom-left-radius: 3px;
	}

	.pagination-sm>li:last-child>a,
	.pagination-sm>li:last-child>span {
		border-top-right-radius: 3px;
		border-bottom-right-radius: 3px;
	}
</style>
<section id="full_appointment">
	<div class="container-fluid">
		<div class="row bg-white border-bottom sticky-top shadow-sm">
			<div class="col-md-10 mb-1">
				<h5 class="mt-2 mb-0">Create New Appointment</h5>
				<small>Appointments / New Appointment</small>

			</div>
			<div class="col-md-2 mt-3">
				<a class="btn bg-navy text-white btn-md" href="{{ route('pabxAppointment.index') }}" rel="tab"><i class="far fa-calendar"></i> PABX Appointment List</a>
			</div>
		</div>
		<div class="form-row">
			<div class="col-sm-12 col-lg-5 col-xl-4">
				<div class="card">
					<div class="card-body">
						<div class="row">
							<div class="col-md-12 mt-2">
								<div class="p-1 mb-2">
									@php
									$specl_route = route('get-doctors-by-specl');
									@endphp
									<select class="form-control select2" id="doctor_speciality" name="doctor_speciality">
										<option value="0">Select speciality</option>
										@if(!empty($specialization))
										@foreach($specialization as $key => $spe_name)
										<option value="{{$key}}">
											{{ $spe_name }}
										</option>
										@endforeach
										@endif
									</select>
								</div>
								{{-- start  --}}


								<div class="p-1 mb-2">
									<label for="" class="col-form-label col-form-label-sm" for="apointment_date">Schedule Date </label>
									<div class="">
										<input type="text" class="form-control form-control-sm date_picker" id="apointment_date" name="apointment_date" value="" placeholder="Enter Schedule Date">
									</div>
								</div>
								<div class="p-1 mb-2">
									<div class="row">
										<div class="col-md-6">
											<div class="custom-control custom-radio  text-center">
												<input type="radio" id="today" name="radioDate" class="custom-control-input todayDate" value="{{date('Y-m-d')}}">
												<label class="custom-control-label" for="today">Today</label>
											</div>
										</div>
										<div class="col-md-6">
											<div class="custom-control custom-radio  text-center date">
												<input type="radio" id="tomorrow" name="radioDate" class="custom-control-input" value="{{date('Y-m-d')}}">
												<label class="custom-control-label" for="tomorrow">Tomorrow</label>
											</div>
										</div>
									</div>
								</div>


								{{-- End  --}}





								<div class="table-responsive" style="max-height: 460px; overflow-y: auto;">
									<div class="list_view" id="doctor_list">
										<table id="data-table">
											<thead>
												<tr>
													<th class="text-center">Doctor List</th>
												</tr>
											</thead>
											<tbody>


												@if(!empty($doctor_list))
												@foreach($doctor_list as $doctor)

												<tr>
													<td>
														<div class="custom-card mt-0 mb-2">
															<div class="row no-gutters">
																<div class="col-md-4 text-center">
																	<div class="doctor_img">
																		@if ($doctor->photo_name != null)
																		<img class="w-100" src="{{ asset('images/uploads/doctor_images/thumb/'.$doctor->photo_name) }}">
																		@else
																		@if($doctor->gender == 6)
																		<img class="w-100" src="{{ asset('images/nurse-2.png') }}">
																		@elseif($doctor->gender == 5)
																		<img class="w-100" src="{{ asset('images/doc-1.png') }}">
																		@endif
																		@endif
																	</div>
																</div>
																<div class="col-md-8">
																	<div class="custom-card-body p-0">
																		<div class="informations text-left">
																			<span class="doctor_name">
																				<strong>{{ $doctor->person_code }} : </strong>{{ $doctor->full_name }}
																				<div>
																					<small>
																						@php
																						$doctor_degree = rtrim((($doctor->degree1!="")?$doctor->degree1.",":"") ." " . (($doctor->degree2!="")?$doctor->degree2.",":"") ." " . (($doctor->degree3!="")?$doctor->degree3.",":"") ." " . (($doctor->degree4!="")?$doctor->degree4.",":""),", ");
																						@endphp

																						{{ $doctor_degree }}
																					</small>
																				</div>
																			</span>
																			<span class="doctor_address">{{ $doctor->phone_mobile }}</span>
																			<span class="doc_specialist">{{ $doctor->specialization }}</span>
																		</div>
																		<div class="doc_actions text-center">
																			<span class="badge badge-sm badge-primary cursor-pointer open-modal p-1" data-id="{{ $doctor->person_no_pk }}" data-action="{{ route('doctor.show', $doctor->person_no_pk) }}" data-modal="common-modal" data-title="Doctor Information" title="View Doctor Information"><i class="fa fa-eye"></i> Profile</span>
																			{{-- <span
																			class="badge badge-sm badge-primary cursor-pointer open-modal p-1"
																			data-id="{{ $doctor->person_no_pk }}"
																			data-action="{{ route('doctor.apointment-shedule', $doctor->person_no_pk) }}"
																			data-modal="common-modal"
																			data-title="Doctor Information"
																			title="View Doctor Information"><i class="fa fa-eye"></i> Profile</span> --}}
																			<span class="badge badge-sm badge-success cursor-pointer doctor_select p-1" data-doc-id="{{ $doctor->person_no_pk }}"><i class="fa fa-calendar"></i> Book Appointment</span>
                                                                            <input type="hidden" value="" name="" id="doctor_click_id">
                                                                        </div>
																	</div>
																</div>
															</div>
														</div>
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
			<div class="col-sm-8">
				<div class="form-row">
					<div class="col col-lg-12">
						<div class="card shadow-sm">
							<div class="card-header">Patient Information </div>
							@include('admin.pabx-appointment.create_appointment')
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	</div>
</section>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('node_modules/moment/min/moment.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
	openLookupAutocomplete("#cheif_complaint", "{{ route('lookup-pres-data-autocomplete') }}", "PRES", "CHIEFCOM", "#chfcom");
	$("#data-table").DataTable({
		"ordering": false,
		"bPaginate": false,
		"bLengthChange": false,
		"bAutoWidth": false
	});

	function doctor_schedule_info(doctor_id, appointment_dt, is_paginator = 0) {
		var action = '{{ route("get-doctor-appointment-info") }}';
		$.ajax({
			url: action,
			data: {
				doctor_id: doctor_id,
				appointment_dt: appointment_dt
			},
			type: "post",
			beforeSend: function() {
				blockUI();
				if (is_paginator == 0) {
					$("#hdn_hospital_id").val('');
					$("#hdn_service_unit").val('');
					$("#hdn_doctor_id").val('');
				}
				$("#hdn_appointment_date").val('');
				$("#hdn_schedule_id").val('');

				$("#avg_load").html('0');
				$("#block_load").html('0');
				$("#total_appointment").html('0');
				$("#total_confirmed").html('0');
				$("#total_billed").html('0');
				$("#total_cancel").html('0');
			},
			success: function(data) {
				if (is_paginator == 0) {
					$("#hdn_hospital_id").val(data.hospital_id);
					$("#hdn_service_unit").val(data.service_unit_id);
					$("#hdn_doctor_id").val(doctor_id);
				}

				$("#doctor_click_id").val(doctor_id);
				$("#hdn_appointment_date").val(appointment_dt);
				$("#hdn_schedule_id").val(data.schedule_id);

				$("#avg_load").html(data.avg_load);
				$("#block_load").html(data.block_load);

				$("#total_appointment").html(data.total_appointment);
				$("#total_confirmed").html(data.total_confirmed);
				$("#total_billed").html(data.total_billed);
				$("#total_cancel").html(data.total_cancel);
				if (data != "" && data.schedule_id != "") {
					$msg = "<div class='alert alert-success mb-2'>Schedule available</div>";
				} else {
					$msg = "<div class='alert alert-danger mb-2'>Schedule not available</div>";
				}
				$("#is_available").html($msg);

				var app_type=data.visit_type_lookup_no_fk;
				console.log(app_type)
				// $('#visit_type option[value="'+app_type+'"]').attr("selected", "selected");
				$('#visit_type').val(app_type);
				var v_type_text = $("#visit_type option:selected").text(); //$("#visit_type [value='"+app_type+"']'").text();
                if(data.hospital_code=="IMPALA" || data.hospital_code=="DMHL")
                {
                    if (data.sales_price) {
							$("#sales_price").html('<h5>' + v_type_text + ' Fees = <span class="text-danger">' + data.sales_price + ' Taka Only</span></h5>');
							$("#hdn_item_id").val(data.item_no_fk);

							var option = '<option value="0" selected>No</option>' + '<option value = "1"  > Yes ';
							$('#is_pay_consultation').html(option);
						} else {
							$("#sales_price").html('');
							var option = '<option value="0" selected>No</option>';
							$('#is_pay_consultation').html(option)
						}
                }
                else{
                    if (data.sales_price) {
							$("#sales_price").html('<h5>' + v_type_text + ' Fees = <span class="text-danger">' + data.sales_price + ' Taka Only</span></h5>');
							$("#hdn_item_id").val(data.item_no_fk);

							var option = '<option value="0" >No</option>' + '<option value = "1" selected > Yes ';
							$('#is_pay_consultation').html(option);
						} else {
							$("#sales_price").html('');
							var option = '<option value="0">No</option>';
							$('#is_pay_consultation').html(option)
						}
                }
			},
			complete: function(data) {

				$.unblockUI();
			}
		});
	}

    function get_empty_time()
    {
      $('#start_time').val('');
      $('#end_time').val('');
    }

    function doctor_slot(doctor_id, appointment_dt)
    {
        var action = '{{ route("get-doctor-slot") }}';
		$.ajax({
			url: action,
			data: {
				doctor_id: doctor_id,
				appointment_dt: appointment_dt
			},
			type: "post",
			beforeSend: function() {
				blockUI();
			},
			success: function(data) {
				$("#appointment_slot_div").html(data);
			},
			complete: function(data) {
				$.unblockUI();
			}
		});
    }

    function getTime(start_time, end_time, slot_no_pk)
     {
                $('#slot_no_pk').val(slot_no_pk);
                $('#start_time').val(start_time);
                $('#end_time').val(end_time);

     }
     function get_doctor_slot_ind(slot_ind)
     {
         if(slot_ind == 1)
    {
        //$('#start_time').prop('readonly', true)
        //$('#end_time').prop('readonly', true)
        //alert('yes')

    }
    else
     {
       // alert('no')
        $('#start_time').prop('readonly', false);
        $('#end_time').prop('readonly', false);
     }
     }

	$(function() {
		$('.date_picker').datepicker({
			todayHighlight: true,
			clearBtn: true,
			autoclose: true,
			format: 'dd-mm-yyyy',
		});
		$('.select2').select2();
		var currDate = new Date();

		$(document).on("click", ".doctor_select", function() {
            console.log('tajjjjjjj');
            //console.log(get_doctor_slot_ind());

			$(".custom-card").removeClass("custom-card-active");
			$(this).parents('.custom-card').addClass("custom-card-active");
			var doctor_id = $(this).attr("data-doc-id");
			var appointment_dt = $(".dp-selected").attr("data-moment");
            var app_date=moment(appointment_dt).format('DD/MM/YYYY');
            get_empty_time();
			$("#selected_date").html(app_date);
			$("#selected_date").addClass('alert alert-primary');

			doctor_schedule_info(doctor_id, appointment_dt);
            doctor_slot(doctor_id, appointment_dt);
		});

		openPatientAutocomplete('#patient_code','patient_name',pre_apointment);
		openPatientAutocomplete('#mobile_no','patient_name',pre_apointment);
		openDoctorAutocomplete('#first_refer', 'hdn_first_refer');
		openDoctorAutocomplete('#second_refer', 'hdn_second_refer');
        openPatientAreaInfoAutocomplete('#search_data');

        function pre_apointment(item,obj) {
			$('#hdn_patient_id').val(item.patient_id);

            var action = '{{ route("get-doctor-patient-appointment-info") }}';
		    $.ajax({
				url: action,
				data: {
					doctor_click_id: $("#hdn_doctor_id").val(),
					patient_id: item.patient_id
				},
				type: "post",
				beforeSend: function() {
					blockUI();
				},
				success: function(data) {
					console.log(data);
					if (data) {
						var app_date='<table class="table data-table  table-bordered table-hover table-striped"><tbody>';
						$.each(data, function(index, value) {
							var date=new Date(value.appoint_date);			
							app_date +=`<tr><td class="w-2">${++index}</td><td> ${date.getDate()}/ ${date.getMonth()+1}/ ${date.getFullYear()}</td></tr>`;	
						});
						app_date+='</tbody></table>';
						$("#appoint_date_table").html(app_date);
						console.log(app_date)
					}
				},
				complete: function(data) {
					$.unblockUI();
				}
		    });
        }

		$(document).on('change', '#reffered_by', function() {
			var thisValue = $(this).val();
			if (thisValue == 2) {
				$("#referrer_name_con").removeClass("d-none");
			} else {
				$("#referrer_name_con").addClass("d-none");
			}
		});

		$(document).on("change", "#visit_type", function(e) {
           // console.log('h')
			var doctor_id = $("#hdn_doctor_id").val();
			if (doctor_id == "") {
				$('.common-modal-notify-error').modal('show');
				$('.common-modal-notify-error .modal-title').html("Validation Error");
				$('.common-modal-notify-error .modal-body').html("You did not select any Doctor");
				$(this).val(0);
				return;
			}

			var v_type = $(this).val();
			var v_type_text = $("#visit_type option:selected").text();
			$.ajax({
				type: "post",
				data: {
					v_type: v_type,
					doctor_id: doctor_id
				},
				url: "{{ route('visit_sales_price') }}",
				beforeSend: function() {
					blockUI();
				},
				success: function(data) {
                var hos_code = $('#hos_code').val();
               // console.log(hos_code);
                if(hos_code=='IMPALA' || hos_code=='DMHL')
                {
                    if (data.sales_price) {
						$("#sales_price").html('<h5>' + v_type_text + ' Fees = <span class="text-danger">' + data.sales_price + ' Taka Only</span></h5>');
						$("#hdn_item_id").val(data.item_no_fk);

						var option = '<option value="0" selected>No</option>' + '<option value = "1" > Yes ';
						$('#is_pay_consultation').html(option);
					} else {
						$("#sales_price").html('');
						var option = '<option value="0" selected>No</option>';
						$('#is_pay_consultation').html(option)
					}
                }
                else
                {
					if (data.sales_price) {
						$("#sales_price").html('<h5>' + v_type_text + ' Fees = <span class="text-danger">' + data.sales_price + ' Taka Only</span></h5>');
						$("#hdn_item_id").val(data.item_no_fk);

						var option = '<option value="0">No</option>' + '<option value = "1" selected> Yes ';
						$('#is_pay_consultation').html(option);
					} else {
						$("#sales_price").html('');
						var option = '<option value="0">No</option>';
						$('#is_pay_consultation').html(option)
					}
                }
				},
				complete: function(data) {
					$.unblockUI();
				}
			});
		});

		$(document).on("change", '#apointment_date', function() {
			var specialization_id = $('#doctor_speciality').val();
			var appoint_dt = $('#apointment_date').val();
			var today = ($('#today').is(':checked') ? $('#today').val() : "");
			var tomorrow = ($('#tomorrow').is(':checked') ? $('#tomorrow').val() : "");
            get_empty_time();
			$("#appointment_slot_div").html('');

			$.ajax({
				url: "{{ route('get-doctors-list-by-specl-date') }}",
				data: {
					specialization_id: specialization_id,
					appoint_dt: appoint_dt,
					today: today,
					tomorrow: tomorrow
				},
				type: "post",
				beforeSend: function() {
					$("#data-table").DataTable().destroy();
					blockUI();
					$('#doctor_list').html('');
				},
				success: function(data) {
					$('#doctor_list').html(data);
				},
				complete: function(data) {
					$.unblockUI();
					$("#data-table").DataTable({
						"ordering": false,
						// "bPaginate": false
						"bLengthChange": false,
						"bAutoWidth": false
					});
				}
			});
		});

		$(document).on("change", '#doctor_speciality', function() {
			var specialization_id = $('#doctor_speciality').val();
			var appoint_dt = $('#apointment_date').val();
			var today = ($('#today').is(':checked') ? $('#today').val() : "");
			var tomorrow = ($('#tomorrow').is(':checked') ? $('#tomorrow').val() : "");
            get_empty_time();
			$("#appointment_slot_div").html('');

			$.ajax({
				url: "{{ route('get-doctors-list-by-specl-date') }}",
				data: {
					specialization_id: specialization_id,
					appoint_dt: appoint_dt,
					today: today,
					tomorrow: tomorrow
				},
				type: "post",
				beforeSend: function() {
					$("#data-table").DataTable().destroy();
					blockUI();
					$('#doctor_list').html('');
				},
				success: function(data) {
					$('#doctor_list').html(data);
				},
				complete: function(data) {
					$.unblockUI();
					$("#data-table").DataTable({
						"ordering": false,
						// "bPaginate": false
						"bLengthChange": false,
						"bAutoWidth": false
					});
				}
			});
		});

		$(document).on("change", '#today', function() {
			var specialization_id = $('#doctor_speciality').val();
			var appoint_dt = $('#apointment_date').val();
			var today = ($('#today').is(':checked') ? $('#today').val() : "");
			var tomorrow = ($('#tomorrow').is(':checked') ? $('#tomorrow').val() : "");
            get_empty_time();
			$("#appointment_slot_div").html('');

			$.ajax({
				url: "{{ route('get-doctors-list-by-specl-date') }}",
				data: {
					specialization_id: specialization_id,
					appoint_dt: appoint_dt,
					today: today,
					tomorrow: tomorrow
				},
				type: "post",
				beforeSend: function() {
					$("#data-table").DataTable().destroy();
					blockUI();
					$('#doctor_list').html('');
				},
				success: function(data) {
					$('#doctor_list').html(data);
				},
				complete: function(data) {
					$.unblockUI();
					$("#data-table").DataTable({
						"ordering": false,
						// "bPaginate": false
						"bLengthChange": false,
						"bAutoWidth": false
					});
				}
			});
		});

		$(document).on("change", '#tomorrow', function() {
			var specialization_id = $('#doctor_speciality').val();
			var appoint_dt = $('#apointment_date').val();
			var today = ($('#today').is(':checked') ? $('#today').val() : "");
			var tomorrow = ($('#tomorrow').is(':checked') ? $('#tomorrow').val() : "");
            get_empty_time();
			$("#appointment_slot_div").html('');

			$.ajax({
				url: "{{ route('get-doctors-list-by-specl-date') }}",
				data: {
					specialization_id: specialization_id,
					appoint_dt: appoint_dt,
					today: today,
					tomorrow: tomorrow
				},
				type: "post",
				beforeSend: function() {
					$("#data-table").DataTable().destroy();
					blockUI();
					$('#doctor_list').html('');
				},
				success: function(data) {
					$('#doctor_list').html(data);
				},
				complete: function(data) {
					$.unblockUI();
					$("#data-table").DataTable({
						"ordering": false,
						// "bPaginate": false
						"bLengthChange": false,
						"bAutoWidth": false
					});

				}

			});
		});


		$(function() {
			enable_cb();
			$("#group1").click(enable_cb);
		});

		function enable_cb() {
			if (this.checked) {
				$("input.group1").removeAttr("disabled");
			} else {
				$("input.group1").attr("disabled", true);
			}
		}
	});
</script>
