@php

$shift = (isset($shift) && (!empty($shift))) ? $shift : [];

$shift_no_pk = ($shift) ? $shift->shift_no_pk : '';
$shift_code = ($shift) ? $shift->shift_code : '';
$start_time = ($shift) ? date('h:i A',strtotime($shift->start_time)) : '';
$end_time = ($shift) ? date('h:i A',strtotime($shift->end_time)) : '';
$shift_description = ($shift) ? $shift->shift_desc : '';
$shift_status = ($shift) ? $shift->status : '';

$start_date = ($shift) ? date('d-m-Y',strtotime($shift->start_time)) : '';
$end_date = ($shift) ? date('d-m-Y',strtotime($shift->end_time)) : '';

$min_in_time =  (!empty($shift->minimum_in_time)) ? date( 'h:i A',strtotime($shift->minimum_in_time)) : '';
$max_out_time = (!empty($shift->maximum_out_time)) ? date('h:i A',strtotime($shift->maximum_out_time)) :'';
$Grace_in_time_min =  ($shift) ?$shift->grace_in_time_min : '';
$Grace_out_time_min =  ($shift) ? $shift->grace_out_time_min : '';

@endphp

<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('asset/timepicker/css/timepicker.css') }}">

<div class="col-sm-12 col-lg-12 col-xl-12">
	<form action="{{ route('shift.store') }}" method="post" id="shift-create">
		@csrf
		<input type="hidden" name="id" value="{{ $shift_no_pk }}">
		<div class="form-group row">
			<label for="shift_code" class="col-sm-12 col-form-label col-form-label-sm">Shift Code <span class="text-danger">*</span></label>
			 
			<div class="col-sm-12">
				<input type="text" class="form-control form-control-sm" id="shift_code" name="shift_code" value="{{ $shift_code }}" placeholder="Enter Shift Code" required>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="start_date" class="col-form-label col-form-label-sm">Start Date <span class="text-danger">*</span></label>
					<input type="text" class="form-control form-control-sm m-0 date_picker"
					id="start_date"
					name="start_date" value="{{$start_date}}" placeholder="yyyy-mm-dd" required />
				</div>
				<div class="form-group">
					<label for="end_date" class="col-form-label col-form-label-sm">End Date <span class="text-danger">*</span></label>
					<input type="text" class="form-control form-control-sm m-0 date_picker"
					id="end_date"
					name="end_date" value="{{$end_date}}" placeholder="yyyy-mm-dd" required />
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="start_time" class="col-form-label col-form-label-sm">Start Time<span class="text-danger"> *</span></label>
					<input type="text" class="form-control form-control-sm timepicker" id="start_time" name="start_time" value="{{ $start_time }}" placeholder="Enter Start Time" required>
				</div>
				<div class="form-group">
					<label for="end_time" class="col-form-label col-form-label-sm">End Time<span class="text-danger"> *</span></label>
					<input type="text" class="form-control form-control-sm timepicker" id="end_time" name="end_time" value="{{ $end_time }}" placeholder="Enter End Time" required>
				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group">
					<label for="min_in_time" class="col-form-label col-form-label-sm">Min In Time</label>
					<input type="text" class="form-control form-control-sm timepicker" id="min_in_time" name="min_in_time" value="{{ $min_in_time }}" placeholder="Max In Time" >
				</div>
				
			</div>
			<div class="col-md-6" >
				<div class="form-group">
					<label for="max_out_time" class="col-form-label col-form-label-sm">Max Out Time</label>
					<input type="text" class="form-control form-control-sm timepicker" id="max_out_time" name="max_out_time" value="{{ $max_out_time }}" placeholder="Max Out Time" >
				</div>
			</div>
			<div class="col-md-6" >
				<div class="form-group">
					<label for="Grace_in_time_min" class="col-form-label col-form-label-sm">Grace In Time (Min)</label>
					<input type="text" class="form-control form-control-sm  number_only" id="Grace_in_time_min" name="Grace_in_time_min" value="{{$Grace_in_time_min }}" placeholder="Grace In Time (Min)" >
				</div>
			</div>
			<div class="col-md-6" >
				<div class="form-group">
					<label for="Grace_out_time_min" class="col-form-label col-form-label-sm">Grace Out Time (Min)</label>
					<input type="text" class="form-control form-control-sm number_only " id="Grace_out_time_min" name="Grace_out_time_min" value="{{ $Grace_out_time_min }}" placeholder="Grace Out Time (Min)" >
				</div>
			</div>

		</div>

		<div class="form-group row">
			<label for="shift_description" class="col-sm-12 col-form-label col-form-label-sm">Description</label>
			<div class="col-sm-12">
				<input type="text" class="form-control form-control-sm" id="shift_description" name="shift_description" value="{{ $shift_description }}" placeholder="Enter Shift Description">
			</div>

			<label for="status" class="col-sm-12 col-form-label col-form-label-sm">Status</label>
			<div class="col-sm-12">
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="checkbox" name="status" id="status" value="1" {{ $shift_status == '1' ? 'checked' : '' }}>
					<label class="form-check-label" for="status">Active</label>
				</div>	
			</div>
		</div>


		<div class="modal-footer mt-1">
			@php
			$response_action = route('shift.index');
			@endphp
			<button type="button" class="btn btn-sm btn-danger mr-auto" data-dismiss="modal">Exit</button>
			<button type="submit" class="btn btn-sm btn-success"  onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Save changes</button>
		</div>
	</form>
</div>

<!-- datepicker -->
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('asset/timepicker/js/timepicker.js') }}"></script>
<script>
	$('.date_picker').datepicker({
		format: 'dd-mm-yyyy',
		autoclose: true,
		todayHighlight: true,
		clearBtn: true
	});
	// $('.timepicker').timepicker();
	 $('body').on('focus',".timepicker", function(){
        $(this).timepicker({
            // showInputs: false,
            // showMeridian: false,
            // setTime: null,
      

        }); });
</script>


