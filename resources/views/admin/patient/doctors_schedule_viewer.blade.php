<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('asset/timepicker/css/timepicker.css') }}">
<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />

<section id="full_appointment">
	<div class="container-fluid">
		<div class="row bg-white border-bottom sticky-top shadow-sm">
			<div class="col-md-12 mb-1">
				<h5 class="mt-2 mb-0">Create Doctor/Physiotherapist Schedule</h5>
				<small>Appointments / New Schedule</small>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12 col-lg-6 col-xl-5">
				<div class="card">
					<div class="card-header">Doctor/Physiotherapist Schedule Form</div>
					<div class="card-body">
						<div class="row">
							<div class="col-md-12 ">
								<form method="post" id="frm-pat-registration" action="{{ route('store-doctor-schedule') }}">
									@csrf
									<div class="form-group">
										<label for="doctor_speciality">Speciality</label>
										<select class="select2 form-control form-control-sm text-center m-0 font_size_12 m-auto min-width-200" id="doctor_speciality" name="doctor_speciality" onchange="getDropdownListByConditionArray(this,'get-doctors-by-specl','doctor_name');" required>
											<option value="0">Select speciality</option>
											@if(empty($doctor_info))
											@if(!empty($docspl))
											@foreach($docspl as $spe_name)
											<option value="{{ $spe_name->specialization_id }}">{{ $spe_name->specialization_name }} ({{ $spe_name->no_of_doctor }})</option>
											@endforeach
											@endif
											@else
											<option value="{{ $doctor_info->specialization_lookup_no_fk }}" {{ $doctor_info->specialization_lookup_no_fk == $doctor_info->specialization_lookup_no_fk ? 'selected' : '' }} >{{ $doctor_info->specialization }}</option>
											@endif
										</select>
									</div>

									<div class="form-group">
										<label for="doctor_name">Doctor Name</label>
										<select class="select2 form-control form-control-sm text-center m-0 font_size_12 m-auto min-width-200" id="doctor_name" name="doctor_name" required>
											<option value="0">Select Doctor</option>
											@if(!empty($doctor_info))
											<option value="{{ $doctor_info->person_no_pk }}" {{ $doctor_info->person_no_pk == $doctor_info->person_no_pk ? 'selected' : '' }}>{{ $doctor_info->full_name }}</option>
											@endif
										</select>
									</div>

									<div class="form-group">
										<label for="from_date">Schedule Date <span class="text-danger">*</span></label>
										<div class="input-group">
											<input type="text" id="from_date" name="from_date" class="form-control date_picker required" placeholder="From Date" required>
											<input type="text" id="to_date" name="to_date" class="form-control date_picker" placeholder="To Date" required>
										</div>
									</div>
									<div class="form-row">
										<div class="form-group col-md-6">
											<label for="shift_type">Shift Type</label>
											<select class="form-control" id="shift_type" name="shift_type">
												<option value="0">Select Shift</option>
												@if(isset($shift))
												@foreach($shift as $val)
												<option value="{{$val->shift_no_pk}}" data-start_time="{{date('h:i A', strtotime($val->start_time))}}" data-end_time="{{date('h:i A', strtotime($val->end_time)) }}">{{$val->shift_desc}}</option>
												@endforeach
												@endif
											</select>
										</div>
										<div class="form-group col-md-6">
											<label for="shift_start_time">Time <span class="text-danger">*</span></label>
											<div class="input-group">
												<input type="text" id="shift_start_time" name="shift_start_time" class="form-control timepicker required" placeholder="Start Time" value="">
												<input type="text"  id="shift_end_time" name="shift_end_time" class="form-control timepicker required" placeholder="End Time" value="">
											</div>
										</div>
									</div>
									<div class="form-row">
										<div class="form-group col-md-4">
											<label for="avg_duration">Duration(Minutes)</label>
											<input type="text" id="avg_duration" name="avg_duration" class="form-control" placeholder="Avg. Duration" required>
										</div>
										<div class="form-group col-md-5">
											<label for="avg_load">Load(Slot)</label>
											<div class="input-group">
												<input type="text" id="avg_load" name="avg_load" class="form-control" placeholder="Average Load">
												<input type="text" name="block_load" class="form-control" placeholder="Block Load">
											</div>
										</div>

                                        <div class="form-group col-md-3">
											<label for="avg_load">Schedule Type</label>
                                            <div class="input-group">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input scheduletype" name="slab" type="checkbox" id="slab" value="1">
                                                    <label class="form-check-label" for="slab">Slab</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input scheduletype keep_me" name="slot" type="checkbox" id="slot" value="1">
                                                    <label class="form-check-label" for="slot">Slot</label>
                                                </div>

                                            </div>
                                        </div>


									</div>
									<div class="form-group">
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



                                    @php
                                    $response_action = route('doctor-schedule');
                                    @endphp
                                    <button class="btn btn-md btn-md-global btn-success uhl_common_btn
                                    btn-block mt-3" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')"> Create Schedule </button>


									{{-- <button type="button" class="btn btn-sm btn-success btn-block mt-3" onclick="btnSaveUpdate(this)"> Create Schedule </button> --}}
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-sm-12 col-lg-6 col-xl-7">
				<div class="card">
					<div class="card-header text-center text-danger">Schedule of Doctor <span id="doct_name"></span>
                        <button type="button" class="btn btn-info btn-sm btn-md-global" onclick="showSchedule()" title="Show Schedule">Show</button>
                        {{-- <button type="button" class="btn btn-warning btn-sm btn-md-global" onclick="blockSchedule()" title="Block Schedule">Block</button> --}}
                        {{-- <span Class="btn btn-sm btn-warning open-modal" data-id="{{ $val->schedule_no_pk}}" data-action="{{ route('get_doctor_slot',$val->schedule_no_pk) }}"data-modal="common-modal-sm" data-title="Block Schedule" title="Block Schedule"><i class="fa fa-eye"></i></span> --}}
                        {{-- {{ $val->schedule_no_pk.','.$val->doctor_person_no_fk }} --}}
                        {{-- <span class="btn btn-sm btn-md-global btn-warning open-modal" data-id="" id="block_modal" data-modal="common-modal-sm" data-title="Block Schedule" title="Block Schedule" data-action="">Block</span> --}}
                        <button disabled class="btn btn-sm btn-md-global btn-warning open-modal" data-id="" id="block_modal" data-modal="common-modal-sm" data-title="Block Schedule" title="Block Schedule" data-action="">Block</span>
                        <button type="button" class="btn btn-danger btn-sm btn-md-global" onclick="deleteAllSchedule()" title="Delete All">Delete All</button>
                    </div>

					<div class="card-body">
						<div class="row">
							<div class="col-md-12">
								<div class="table-responsive" id="doct_sch_table_div" style="max-height: 425px; overflow-y: auto; overflow-x: auto;">
									@if(!empty($schedules))
									@include('admin.patient.doctor_schedule')
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
	$(function() {
		$('.select2').select2();
		$('.date_picker').datepicker();
		$('.timepicker').timepicker({});
	})


	//getDoctorsShedules(21);
    $('input.scheduletype').on('change', function() {
    $('input.scheduletype').not(this).prop('checked', false);
   });
    function showSchedule()
    {
		var doc_name = $("#doctor_name").find('option:selected');

		var from_date = $("#from_date").val();
		var to_date = $("#to_date").val();
		var shift_type = $('#shift_type').find('option:selected').val();
       // alert(shift_type);
		getDoctorsShedules(doc_name.val(), from_date,to_date,shift_type);





            //alert(fdate);
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

	$(document).on("change","#doctor_name", function(e){
		var thisVal = $(this).find('option:selected');
		var doctor_name_txt = thisVal.text();
		$("#doct_name").text(doctor_name_txt);
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


	function getDoctorsShedules(doctor_id,from_date,to_date,shift_type=null) {

		$.ajax({
			type: "post",
			data:{ 'doctor_id':doctor_id,'from_date':from_date,'to_date':to_date,'shift_type':shift_type},
			url: "{{ route('get_doctor_schedule') }}",
			beforeSend:function(){
				$("#doct_sch_table_div").html('');
				blockUI();
			},
			success: function (data) {
				$("#doct_sch_table_div").html('').append(data.html);

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
        var doc_name = $("#doctor_name").find('option:selected');

        var doctor_id = doc_name.val();

        var from_date = $("#from_date").val();
		var to_date = $("#to_date").val();
		var con = confirm('Are you sure?');
		if (con == true) {

			$.ajax({
				type: "post",
				data:{'doctor_id':doctor_id,'from_date':from_date,'to_date':to_date},
				url: "{{ route('delete_doctor_schedule_all') }}",
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
					$('.common-modal-notify .modal-body').html("Doctor all Schedule removed successfully.");
					$.unblockUI();
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


</script>
