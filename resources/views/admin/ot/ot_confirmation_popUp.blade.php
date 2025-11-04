<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('select2/dist/css/select2.min.css')}}">
<link rel="stylesheet" href="{{ asset('asset/timepicker/css/timepicker.css') }}">
<form id="ot-confirmation-form" action="{{ route('ot.store-ot-confirmation-popUp') }}" method="post">
	<div class="form-row">
		<input type="hidden" id="hidden_ot_req_no_pk" name="hidden_ot_req_no_pk" value="{{$ot_req_no_pk}}">
		<input type="hidden" id="hdn_admission_id" name="hdn_admission_id" value="{{$admission_id}}">

		<div class="col-md-6">
			<div class="form-group">
				<label class="col-form-label col-form-label-sm" for="anest_name">Anest. Name</label>
				<select class="form-control form-control-sm " id="anest_name" name="anest_name">
					@if (!empty($selected_anes))

					<option value="{{ $selected_surgen->person_no_pk }}" selected>
						{{ $selected_anes->full_name }}
					</option>
					@else
					<option value="">Choose Anesthesiologist</option>
					@endif

					@if (!empty($anesthesiologists))
					@foreach($anesthesiologists as $anest)
					@if (empty($selected_anes) || $selected_anes->person_no_pk != $anest->person_no_pk)
					<option value="{{ $anest->person_no_pk }}">{{ $anest->full_name }}</option>
					@endif
					@endforeach
					@endif
				</select>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label class="col-form-label col-form-label-sm" for="surgeon_name">Surgeon Name</label>
				<select class="form-control form-control-sm " id="surgeon_name" name="surgeon_name">
					@if (!empty($selected_surgen))

					<option value="{{ $selected_surgen->person_no_pk }}" selected>
						{{ $selected_surgen->full_name }}
					</option>
					@else
					<option value="">Choose Surgeon</option>
					@endif

					@if (!empty($surgeons))
					@foreach($surgeons as $surgeon)
					{{-- Avoid duplicate if selected surgeon is also in the list --}}
					@if (empty($selected_surgen) || $selected_surgen->person_no_pk != $surgeon->person_no_pk)
					<option value="{{ $surgeon->person_no_pk }}">{{ $surgeon->full_name }}</option>
					@endif
					@endforeach
					@endif
				</select>

			</div>
		</div>

		<div class="col-md-6">
			<div class="form-group">
				<label class="col-form-label col-form-label-sm" for="clearance_date">Clearance Date</label>
				<input type="text"
					class="form-control form-control-sm date-picker"
					id="clearance_date"
					name="clearance_date"
					value="{{ !empty($selected_anes->anest_clearance_time) ? \Carbon\Carbon::parse($selected_anes->anest_clearance_time)->format('d-m-Y') : '' }}"
					placeholder="dd/mm/yyyy">

			</div>
		</div>
		@php
		use Carbon\Carbon;
		$formattedDate = $slot_details ? \Carbon\Carbon::parse($slot_details->schedule_dt)->format('d/m/Y') : '';

		$formattedTime = '';
		if ($slot_details && $slot_details->start_time && $slot_details->end_time) {
		$startTime = Carbon::parse($slot_details->start_time)->format('H:i A');
		$endTime = Carbon::parse($slot_details->end_time)->format('H:i A');
		$formattedTime = $startTime . ' - ' . $endTime;
		}
		@endphp

		<div class="col-md-6">
			<div class="form-group">
				<label class="col-form-label col-form-label-sm" for="ot_date">OT Date</label>
				<input type="text" class="form-control form-control-sm  today"
					id="ot_date" name="ot_date"
					value="{{ $formattedDate }}"
					placeholder="dd/mm/yyyy" readonly>
				<!-- <input type="text" class="form-control form-control-sm date-picker today" value="" id="ot_date" name="ot_date" value="" placeholder="dd/mm/yyyy"> -->
			</div>
		</div>

		<div class="col-md-6">
			<div class="form-group">
				<label class="col-form-label col-form-label-sm" for="ot_date">Estimated Time</label>
				<input type="text" class="timepicker form-control"
					name="ot_time" id="ot_time"
					value="{{ $formattedTime }}" readonly>
				<!-- <input type="text" class="timepicker form-control" name="ot_time" id="ot_time"> -->
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label class="col-form-label col-form-label-sm" for="ot_date">Diagnosis </label>
				<!-- <input type="text" class="form-control form-control-sm date-picker today" id="ot_date" name="ot_date" value="" placeholder="dd/mm/yyyy"> -->
				<input type="text" 
       class="form-control" 
       name="diagnosis" 
       id="diagnosis" 
       value="{{ old('diagnosis', $selected_anes->diagnosis ?? '') }}">
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group">
				<label class="col-form-label col-form-label-sm" for="ot_date">Surgeon remarks </label>
				<textarea name="surgeon_remarks" 
          id="surgeon_remarks" 
          class="form-control" 
          rows="3">{{ old('surgeon_remarks', $selected_anes->surgeons_remark ?? '') }}</textarea>
			</div>
		</div>

		<div class="col-md-6">
			<div class="form-group">
				<!-- <input type="checkbox" id="ot_anest_clearance_ind" name="ot_anest_clearance_ind" value="1"> -->
				<input type="checkbox" id="ot_anest_clearance_ind" name="ot_anest_clearance_ind" value="1"
					{{ isset($selected_anes->anest_clearance_ind) && $selected_anes->anest_clearance_ind == 1 ? 'checked' : '' }}>
				<label class="" for="ot_anest_clearance_ind">Anesthesiologist Clearance</label>
			</div>
		</div>
		@if(session('user.ses_hospital_code') == 'UNICO')
		<div class="col-md-6">
			<div class="form-group">
				<input type="checkbox" id="ot_confirm" name="ot_confirm" value="1">
				<label class="" for="ot_confirm">OT Confirm</label>
			</div>
		</div>
		@endif

		<div class="col-md-6">
			<div class="form-group">
				<!-- <input type="checkbox" id="pac_clearence" name="pac_clearence" value="1"> -->
				<input type="checkbox" id="pac_clearence" name="pac_clearence" value="1"
					{{ isset($selected_anes->pac_clearence_ind) && $selected_anes->pac_clearence_ind == 1 ? 'checked' : '' }}>
				<label class="" for="pac_clearence">PAC Clearence</label>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<!-- <input type="checkbox" id="bill_clearence" name="bill_clearence" value="1"> -->

				<input type="checkbox" id="bill_clearence" name="bill_clearence" value="1"
					{{ isset($selected_anes->bill_clearence_ind) && $selected_anes->bill_clearence_ind == 1 ? 'checked' : '' }}>
				<label class="" for="bill_clearence">Bill Clearance</label>
			</div>
		</div>

	</div>

	<div class="m-0 pt-2 text-right border-top">
		@php
		if(session('user.ses_hospital_code') == 'UNICO'){
		$response_action = route('ot.requisition-status');
		}else{
		$response_action = route('ot.operation-status');
		}

		@endphp
		<button type="submit" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Save</button>
		<button type="reset" class="btn btn-info btn-sm" title="Click here to Clear form data">Clear</button>
		<a href="{{ $response_action }}" class="btn btn-danger btn-sm" rel="tab" title="Click here to go back to Dashboard" data-dismiss="modal">Exit</a>
	</div>
</form>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('select2/dist/js/select2.min.js')}}"></script>
<script type="application/javascript" src="{{ asset('asset/timepicker/js/timepicker.js') }}"></script>
<script>
	$(document).ready(function() {

		$('.date-picker').datepicker({
			format: 'dd-mm-yyyy',
			autoclose: true,
			todayHighlight: true,
			clearBtn: true,
			startDate: new Date() // ⛔ disables all dates before today
		});
		// $(".today").datepicker('setDate', new Date());
		$('.select2').select2({});
		// $(".timepicker").timepicker({
		// 	defaultTime: new Date(),
		// 	interval: "5",
		// });

	})
</script>