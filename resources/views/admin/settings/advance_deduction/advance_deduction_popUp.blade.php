@php

$advance = (isset($advance) && (!empty($advance))) ? $advance : [];

$addded_no_pk = ($advance) ? $advance->addded_no_pk : '';
$full_name = ($advance) ? $advance->full_name : '';
$lookupdata_name = ($advance) ? $advance->lookupdata_name : '';
$lookupdata_code1 = ($advance) ? $advance->lookupdata_code : '';
$amount = ($advance) ? $advance->amount : '';
$year = (!empty($year)) ? $year : 'Selected Year';
$month_data = (!empty($month_data)) ? $month_data : 'Selected Month';
$addded_date = ($advance) ? $advance->addded_date : '';
$status = ($advance) ? $advance-> status : '';
$person_no_pk = ($advance) ? $advance-> person_no_pk : '';


@endphp

<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">

<div class="col-sm-12 col-lg-5 col-xl-12">
	<form action="{{route('advance_deduction.store')}}" method="post" id="advance_deduction">
		@csrf
		<input type="hidden" name="id" value="{{$addded_no_pk}}">
		<div class="form-row">
            <div class="col-lg-4 col-md-6">
				<div class="form-group">
					<label for="employee_code" class="col-form-label col-form-label-sm">User Name <span>*</span></label>
					<input type="text" class="form-control font_size_12" id="employee_code" name="employee_code" value="{{$full_name}}" placeholder="Employee Code/Name/Phone Number"/ required="">
				</div>

				<input type="hidden" class="keep_me" id="hdn_item_item_id_0" name="hdn_item_item_id_0" value="{{ $person_no_pk }}">
				@error('employee_id')
				<span class="invalid-feedback" role="alert">
					<strong>{{ $message }}</strong>
				</span>
				@enderror
			</div>
            <div class="col-lg-4 col-md-6">
				<div class="form-group">
					<label for="leave_type" class="col-form-label col-form-label-sm">Deduction type <span>*</span></label>
					<select class="form-control font_size_12 m-auto" id="deduction_type" value="{{$lookupdata_name}}" name="deduction_type" required>
						<option value="0"  > Select name</option>

						@if(!empty($advanceDeduction))
						@foreach($advanceDeduction as $lookup_code => $lookup_name)
						<option value="{{ $lookup_code }}"  {{ $lookup_name == $lookupdata_code1 ? 'selected' : '' }}> {{ $lookup_name }}</option>
						@endforeach
						@endif
					</select>
				</div>
			</div>
            <div class="col-lg-4 col-md-6">
				<div class="form-group">
					<label for="amount" class="col-form-label col-form-label-sm">Amount <span>*</span></label>
					<input type="text" class="form-control form-control-sm number_only" id="amount" name="amount" value="{{$amount}}" placeholder="Amount" required>
				</div>
			</div>

			<div class="col-md-4">
				<div class="form-group ">
					<label for="year" class="col-form-label col-form-label-sm">Year</label>
					<?php $yearArray = range(2020, 2030);?>
					<select name="year"  class="form-control font_size_12 m-auto" id="year">
						<option value="{{$year}}" >{{$year}}</option>
						<?php
						foreach ($yearArray as $year) {
							echo '<option  value="'.$year.'">'.$year.'</option>';
						}
						?>
					</select>
				</div>
			</div>

			<div class="col-md-4">
				<div class="form-group">
					<label for="month" class="col-form-label col-form-label-sm">Month</label>
					<?php $monthArray = range(1, 12); ?>
					<select name="month"  class="form-control font_size_12 m-auto" id="month">
						<option value="{{$month_data}}">{{$month_data}}</option>
						<?php foreach ($monthArray as $month) {
							$monthPadding = str_pad($month, 2, "0", STR_PAD_LEFT);
							$fdate = date("F", strtotime("2015-$monthPadding-01"));
							echo '<option value="'.$monthPadding.'">'.$fdate.'</option>';
						} ?>
					</select>
				</div>
			</div>

			<div class="col-md-4">
				<div class="form-group">
					<label for="date" class="col-form-label col-form-label-sm">Date <span>*</span></label>
					<input type="text" class="form-control form-control-sm m-0 date_picker" value="{{$addded_date}}"
					id="date" name="date"
					value="" placeholder="yyyy-mm-dd" required>
				</div>
			</div>
            <div class="col-md-12">
				<div class="form-group">
					<label for="remarks" class="col-form-label col-form-label-sm">Remarks</label>
					<input type="text" class="form-control form-control-sm" id="remarks" name="remarks" value="{{$amount}}" placeholder="Enter Remarks" >
				</div>
			</div>

			<div class="col-sm-12">
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="checkbox" name="ad_deduction_status" id="ad_decucion_status" value="1" {{ $status == '1' ? 'checked' : '' }}>
					<label class="form-check-label" for="ad_decucion_status">Active</label>
				</div>
			</div>


			@php
			$response_action = route('advance_deduction.index');
			@endphp

			<div class="mt-2 modal-inline">
				<button type="submit" class="btn btn-md btn-success uhl_save_btn" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Save</button>
				<button type="reset" class="btn btn-info btn-md" title="Click here to Clear form data">Clear</button>
				<button type="button" class="btn btn-md btn-danger mr-auto" data-dismiss="modal">Exit</button>
			</div>





		</div>
	</form>
</div>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>

<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>



<script type="text/javascript">
	openDoctorAutocomplete("#employee_code", 'hdn_item_item_id_0');
</script>

<script>
	$('.date_picker').datepicker({
		format:'yyyy-mm-dd',
		todayHighlight: true,
		clearBtn: true,
		autoclose: true
	});

</script>
