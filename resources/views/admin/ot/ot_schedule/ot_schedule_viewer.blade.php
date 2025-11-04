<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('asset/timepicker/css/timepicker.css') }}">
<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />

<section id="full_appointment">
	<div class="container-fluid">
		<div class="row bg-white border-bottom sticky-top shadow-sm">
			<div class="col-md-12 mb-1">
				<h5 class="mt-2 mb-0">OT Schedule</h5>
				<small>OT / OT Schedule</small>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12 col-lg-12 col-xl-12">
				<div class="card">
					{{-- <div class="card-header">OT Schedule Form</div> --}}
					<div class="card-body">
						<div class="row">
							<div class="col-md-12 ">
								<form method="post" id="frm-pat-registration" action="{{ route('store-ot-schedule') }}">
									@csrf
									<div class="form-row">
										<div class="form-group col-md-3">
											<label for="room_no">OT Room No. <span class="text-danger">*</span></label>
											<select class="select2 form-control form-control-sm m-0 font_size_12" id="room_no" name="room_no" required>
												<option value="">Select Room</option>
												@if(count($room_data) > 0)
													@foreach($room_data as $data)
														<option value="{{ $data->room_no_pk }}" 
															{{-- {{ $doctor_info->person_no_pk == $doctor_info->person_no_pk ? 'selected' : '' }} --}}
															>{{ $data->room_name }} <strong> ({{ $data->room_code }})</strong></option>
													@endforeach
												@endif
											</select>
										</div>
										<div class="form-group col-md-3">
											<label for="from_date">Schedule Date <span class="text-danger">*</span></label>
											<div class="input-group">
												<input type="text" id="from_date" name="from_date" class="form-control date_picker required" placeholder="From Date" autocomplete="off" required>
												<input type="text" id="to_date" name="to_date" class="form-control date_picker" placeholder="To Date"  autocomplete="off" required>
											</div>
										</div>
										<div class="form-group col-md-3">
											<label for="shift_start_time">Time <span class="text-danger">*</span></label>
											<div class="input-group">
												<input type="text" id="shift_start_time" name="shift_start_time" class="form-control timepicker" placeholder="Start Time" value="" required>
												<input type="text"  id="shift_end_time" name="shift_end_time" class="form-control timepicker" placeholder="End Time" value="" required>
											</div>
										</div>
										<div class="form-group col-md-3">
											<label for="avg_duration">Duration(Minutes)<span class="text-danger">*</span></label>
											<input type="text" id="avg_duration" name="avg_duration" class="form-control" placeholder="Avg. Duration" required autocomplete="off">
										</div>
									</div>
									<div class="form-row">
										<div class="form-group col-md-10">
											<label for="day_sat">Week Days <span class="text-danger">*</span></label>
											<div class="input-group">
												<div class="form-check form-check-inline">
													<input class="form-check-input" name="schedule_day[]" type="checkbox" id="day_sat" value="Sat">
													<label class="form-check-label" for="day_sat">Sat</label>
												</div>
												<div class="form-check form-check-inline">
													<input class="form-check-input" name="schedule_day[]" type="checkbox" id="day_sun" value="Sun">
													<label class="form-check-label" for="day_sun">Sun</label>
												</div>
												<div class="form-check form-check-inline">
													<input class="form-check-input" name="schedule_day[]" type="checkbox" id="day_mon" value="Mon">
													<label class="form-check-label" for="day_mon">Mon</label>
												</div>
												<div class="form-check form-check-inline">
													<input class="form-check-input" name="schedule_day[]" type="checkbox" id="day_tue" value="Tue">
													<label class="form-check-label" for="day_tue">Tue</label>
												</div>
												<div class="form-check form-check-inline">
													<input class="form-check-input" name="schedule_day[]" type="checkbox" id="day_wed" value="Wed">
													<label class="form-check-label" for="day_wed">Wed</label>
												</div>
												<div class="form-check form-check-inline">
													<input class="form-check-input" name="schedule_day[]" type="checkbox" id="day_thu" value="Thu">
													<label class="form-check-label" for="day_thu">Thu</label>
												</div>
												<div class="form-check form-check-inline">
													<input class="form-check-input" name="schedule_day[]" type="checkbox" id="day_fri" value="Fri">
													<label class="form-check-label" for="day_fri">Fri</label>
												</div>
												<div class="form-check form-check-inline">
													<input class="form-check-input" name="schedule_day[]" type="checkbox" id="day_all" value="All">
													<label class="form-check-label" for="day_all">All</label>
												</div>
											</div>
										</div>
										<div class="form-group col-md-2">
											@php
											$response_action = route('ot-schedule');
											@endphp
											<button class="btn btn-md btn-md-global btn-success uhl_common_btn
											btn-block mt-3" id="schedule_id">Create Schedule</button>
										</div>
									</div>
										{{-- <button type="button" class="btn btn-sm btn-success btn-block mt-3" onclick="btnSaveUpdate(this)"> Create Schedule </button> --}}
								</form>
							</div>
						</div>
					</div>
				</div>
				<div class="card">
					<div class="card-header text-center text-danger">Schedule of <span id="room_name_text">.... </span>
                        <button type="button" class="btn btn-info btn-sm btn-md-global" onclick="showSchedule()" title="Show Schedule">  Show</button>
                        {{-- <button type="button" class="btn btn-warning btn-sm btn-md-global" onclick="blockSchedule()" title="Block Schedule">Block</button> --}}
                        {{-- <span Class="btn btn-sm btn-warning open-modal" data-id="{{ $val->schedule_no_pk}}" data-action="{{ route('get_doctor_slot',$val->schedule_no_pk) }}"data-modal="common-modal-sm" data-title="Block Schedule" title="Block Schedule"><i class="fa fa-eye"></i></span> --}}
                        {{-- {{ $val->schedule_no_pk.','.$val->doctor_person_no_fk }} --}}
                        {{-- <span class="btn btn-sm btn-md-global btn-warning open-modal" data-id="" id="block_modal" data-modal="common-modal-sm" data-title="Block Schedule" title="Block Schedule" data-action="">Block</span> --}}
                        {{-- <button disabled class="btn btn-sm btn-md-global btn-warning open-modal" data-id="" id="block_modal" data-modal="common-modal-sm" data-title="Block Schedule" title="Block Schedule" data-action="">Block</span> --}}
                        <button type="button" class="btn btn-danger btn-sm btn-md-global" onclick="deleteAllSchedule()" title="Delete All">Delete All</button>
                    </div>

					<div class="card-body">
						<div class="row">
							<div class="col-md-12">
								<div class="table-responsive" id="room_sch_table_div" style="max-height: 425px; overflow-y: auto; overflow-x: auto;">
									@if(!empty($schedules))
									@include('admin.ot.ot_schedule.ot_schedule')
									@endif
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
    $(document).ready(function() {		
		$('.select2').select2();
	});
	$(function() {
		$('.date_picker').datepicker({
			format: 'dd-mm-yyyy',
			autoclose: true,
			todayHighlight: true,
			clearBtn: true,
		});
		$('.timepicker').timepicker({});
	})


	//getDoctorsShedules(21);
    $('input.scheduletype').on('change', function() {
    $('input.scheduletype').not(this).prop('checked', false);
   });
    function showSchedule()
    {
		var room_name = $("#room_no").find('option:selected');
		var from_date = $("#from_date").val();
		var to_date = $("#to_date").val();
		getDoctorsShedules(room_name.val(), from_date,to_date);
    }

    let toBeBlocked, date, doctor_id, url;
    function blockSchedule()
    {
        toBeBlocked = [];
        date        = [];
        doctor_id   = $('.blockCheckBox').attr('doctor-id');

        $('.blockCheckBox:checkbox:checked').each(function () {
            toBeBlocked.push($(this).val());
            date.push($(this).attr('date'));
        });

        // Disable block button if no checkbox is selected
        (toBeBlocked.length > 0) ? $('#block_modal').prop('disabled', false) : $('#block_modal').prop('disabled', true);

        toBeBlocked = JSON.stringify(toBeBlocked)
        date = JSON.stringify(date);
        url= '{{ route('prescription.blockSlotShow', [':schedule_id', ':doctor_id', ':date']) }}';

        url = url.replace(":schedule_id", toBeBlocked);
        url = url.replace(":doctor_id", doctor_id);
        url = url.replace(":date", date);
        $('#block_modal').attr('data-action',url);
        // $('#block_modal').attr('data-id', toBeBlocked);
    }

	$(document).on("change","#room_no", function(e){
		var thisVal = $(this).find('option:selected');
		var room_name_txt = thisVal.text();
		$("#room_name_text").text(room_name_txt);
		//getDoctorsShedules(thisVal.val());
       // showSchedule(thisVal.val(),'');
	})

	$(document).on("change","#from_date", function(e){
		var from_date = $(this).val();
        //alert(from_date);
		//var doc_name = $("#doctor_name").find('option:selected');
		//var doctor_name_txt = doc_name.text();

       // showSchedule('',from_date);

		// if (doc_name.val() != '0') {
		// 	$("#doct_name").text(doctor_name_txt);
		// 	//getDoctorsShedules(doc_name.val(), from_date);

		// }
	})

	$(document).on("change","#to_date", function(e){

		var to_date = $(this).val();
		// var from_date = $("#from_date").val();
		// var doc_name = $("#doctor_name").find('option:selected');
		// var doctor_name_txt = doc_name.text();

		// if (doc_name.val() != '0') {
		// 	$("#doct_name").text(doctor_name_txt);
		// 	getDoctorsShedules(doc_name.val(), from_date,to_date);
		//}
	})

	$(document).on("change", "#shift_type", function(e){

		var shift_type = $(this).find('option:selected').val();
		// var to_date = $("#to_date").val();
		// var from_date = $("#from_date").val();
		// var doc_name = $("#doctor_name").find('option:selected');
		// var doctor_name_txt = doc_name.text();

		// if (doc_name.val() != '0') {
		// 	$("#doct_name").text(doctor_name_txt);
		// 	getDoctorsShedules(doc_name.val(), from_date,to_date,shift_type);
		// }

	})

	function getDoctorsShedules(room_id,from_date,to_date) {
		$.ajax({
			type: "post",
			data:{ 'room_id':room_id,'from_date':from_date,'to_date':to_date},
			url: "{{ route('get-ot-schedule') }}",
			beforeSend:function(){
				$("#room_sch_table_div").html('');
				blockUI();
			},
			success: function (data) {
				$("#room_sch_table_div").html('').append(data.html);

			},
			complete: function (data) {
				$.unblockUI();
			}
		});
	}

	function deleteSchedule(schedule_id,doctor_id){
		var con = confirm('Are you sure?');
		if (con == true) {

			$.ajax({
				type: "post",
				data:{ 'schedule_id':schedule_id, 'doctor_id':doctor_id},
				url: "{{ route('delete_doctor_schedule') }}",
				beforeSend:function(){
					$("#doct_sch_table_div").html('');
					blockUI();
				},
				success: function (data) {
					$("#doct_sch_table_div").html('').append(data.html);

				},
				complete: function (data) {
					$('.common-modal-notify').modal('show');
					$('.common-modal-notify .modal-title').html("Success");
					$('.common-modal-notify .modal-body').html("Doctor Schedule removed successfully.");
					$.unblockUI();
				}
			});

		}
		else {
			return false;
		}
	}
    function deleteAllSchedule(){
        var room_name = $("#room_no").find('option:selected');
        var room_no = room_name.val();

        var from_date = $("#from_date").val();
		var to_date = $("#to_date").val();
		var con = confirm('Are you sure?');
		if (con == true) {
			$.ajax({
				type: "post",
				data:{'room_id':room_no,'from_date':from_date,'to_date':to_date},
				url: "{{ route('delete-ot-schedule-all') }}",
				beforeSend:function(){
					$("#room_sch_table_div").html('');
					blockUI();
				},
				success: function (data) {
					if(data.status == 'success'){
						$("#room_sch_table_div").html('').append(data.html);
						$('.common-modal-notify').modal('show');
						$('.common-modal-notify .modal-title').html("Success");
						$('.common-modal-notify .modal-body').html("OT Schedule removed successfully.");
						$.unblockUI();
					}else{
						$("#room_sch_table_div").html('').append(data.html);
						$('.common-modal-notify-error').modal('show');
						$('.common-modal-notify-error .modal-title').html("Error");
						$('.common-modal-notify-error .modal-body').html("OT schedule slot already booked so can not be removed !!");
						$.unblockUI();
						
					}
				}	
			});

		}
		else {
			return false;
		}
	}

	$(document).on("change","#shift_type", function(e){
		var thisVal = $(this).find('option:selected');
		var start_time = thisVal.attr("data-start_time");
		var end_time = thisVal.attr("data-end_time");
		$("#shift_start_time").val(start_time);
		$("#shift_end_time").val(end_time);

	})

	$(document).on("change","#day_all", function(e){

		$("input[name='schedule_day[]']").not(this).prop('checked', this.checked);

	})

	document.querySelector('#schedule_id').addEventListener('click', function(e) {
		let checkedBoxes = document.querySelectorAll('.form-check-input:checked');
		if (!checkedBoxes || checkedBoxes.length === 0) {
			alert('Please select Week Days !!');
			e.preventDefault(); 
			return; 
		} else {
			btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')
		}
    })


</script>
