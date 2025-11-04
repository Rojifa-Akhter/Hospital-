<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('asset/timepicker/css/timepicker.css') }}">
<link href="{{ asset('css/redactor.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<style>
	.redactor_box {
		margin-bottom: 0px;
	}
</style>
<form id="ot-annest-note-form" action="{{ route('ot.store-annest-note') }}" method="post">
	<div class="form-row">
		<input type="hidden" id="hidden_ot_req_no_pk" name ="hidden_ot_req_no_pk" value="{{$ot_req_no_pk}}">
		<div class="card border-0 col-md-6">
			<div class="card-header p-0 m-0 bg-navy">Anesthesiologist Note</div>
			<div class="card-body p-0 m-0"><textarea id="annest_note" name="anest_note">{{!empty($ot_patient_info->anest_note)?$ot_patient_info->anest_note: ''}}</textarea></div>
		</div>

		<div class="col-md-6">
			<div class="form-group">
				<label class="col-form-label col-form-label-sm" for="anest_name">Anest. Name</label>
				<select class="form-control form-control-sm select2" id="anest_name" name="anest_name">
					<option value="">Choose Anesthesiologist</option>
					@if(!empty($anesthesiologists))
						@foreach($anesthesiologists as $anest)
							<option value="{{$anest->person_no_pk}}"  @if ( $anest->person_no_pk == $ot_patient_info->anest_doc_person_no_fk) selected @endif>{{$anest->full_name}}</option>
						@endforeach
					@endif
				</select>
			</div>


			<div class="form-row">
				<div class="col-md-6">
					<div class="form-group">
						<label class="col-form-label col-form-label-sm" for="annest_date">Annest. Date</label>
						<input type="text" class="form-control form-control-sm date_picker" id="annest_date" name="annest_date" value="{{!empty($ot_patient_info->anest_note_time)?date('d-m-Y', strtotime($ot_patient_info->anest_note_time)): ''}}" placeholder="dd/mm/yyyy">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label class="col-form-label col-form-label-sm" for="annest_time">Annest. Time</label>
						<input type="text" class="form-control form-control-sm timepicker" id="annest_time" name="annest_time" value="{{!empty($ot_patient_info->anest_note_time)?date('H:i:s', strtotime($ot_patient_info->anest_note_time)): ''}}" placeholder="--:--:--">
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="mt-2 pt-2 text-right border-top">
		@php
			$response_action = route('ot.ot-execution');
		@endphp
		<button type="submit" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Save</button>
		<button type="reset" class="btn btn-info btn-sm" title="Click here to Clear form data">Clear</button>
		<a href="{{ $response_action }}" class="btn btn-danger btn-sm" rel="tab" title="Click here to go back to Dashboard" data-dismiss="modal">Exit</a>
	</div>
</form>

<script type="application/javascript" src="{{ asset('js/redactor.js') }}"></script>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('asset/timepicker/js/timepicker.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
	loadEditor("annest_note");

	$('.timepicker').timepicker({
		defaultTime: new Date(),
		interval: '5'
	});


	$('.date_picker').datepicker({
		format: 'dd-mm-yyyy',
		autoclose: true,
		todayHighlight: true,
		clearBtn: true
	});
	$('.select2').select2({});

</script>

