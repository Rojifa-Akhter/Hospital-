{{-- <link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<form  method="post" id="emr-current-patient" action="{{ route('emr.family-disease-store') }}" >
	<input type="hidden" class="keep_me" value="{{$patient_id}}" name="patient_id" id="hdn_patient_id">
<div class="form-row justify-content-center mb-3 align-items-center">
	<div class="col-md-3">
		<div class="form-group">
			<label for="relative" class="col-form-label col-form-label-sm">Relative</label>
			<select class="form-control form-control-sm" id="relative" name="relative">
				<option value="0">Choose Relative</option>
				<option value="Father">Father</option>
				<option value="Mother">Mother</option>
				<option value="Husband">Husband</option>
				<option value="Wife">Wife</option>
				<option value="Son">Son</option>
				<option value="Daughter">Daughter</option>
				<option value="Nephew">Nephew</option>
			</select>
		</div>
	</div>

	<div class="col-md-3">
		<div class="form-group">
			<label class="col-form-label col-form-label-sm" for="family_disease">Disease</label>
			<input type="text" class="form-control form-control-sm m-0" id="family_disease" name="family_disease" value="" placeholder="Disease">
		</div>
	</div>

	<div class="col-md-3">
		<div class="form-group">
			<label class="col-form-label col-form-label-sm" for="family_severity">Severity</label>
			<input type="text" class="form-control form-control-sm m-0" id="family_severity" name="family_severity" value="" placeholder="Severity">
		</div>
	</div>

	<div class="col-md-3">
		<div class="form-group">
			<label class="col-form-label col-form-label-sm" for="suffered_duration">Suffered Duration</label>
			<input type="text" class="form-control form-control-sm m-0" id="suffered_duration" name="suffered_duration" value="" placeholder="Suffered Duration">
		</div>
	</div>

	<div class="form-group col-md-4">
		<label class="col-form-label col-form-label-sm" for="lp_report_from">Date</label>
		<div class="input-group">
			<div class="input-group-prepend">
				<div class="input-group-text">From</div>
			</div>
			<input type="text" class="form-control form-control-sm m-0 datepicker" id="lp_report_from" name="lp_report_from" value="" placeholder="dd/mm/yyyy">
			<div class="input-group-prepend">
				<div class="input-group-text">To</div>
			</div>
			<input type="text" class="form-control form-control-sm m-0 datepicker" id="lp_report_to" name="lp_report_to" value="" placeholder="dd/mm/yyyy">
		</div>
	</div>

	<div class="col-md-1">
		<div class="form-group">
			<label class="col-form-label col-form-label-sm d-block">Death</label>
			<div class="custom-control custom-checkbox custom-control-inline text-center">
				<input type="checkbox" id="death_yes" name="death_yes" class="custom-control-input" value="1">
				<label class="custom-control-label" for="death_yes">Yes</label>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		@php
		$response_action = route('emr.patient-current-emr-use');
		@endphp

		<div class="mt-1">
			<button type="button" class="btn btn-md btn-success" onclick="EMRFunc.storeFamilyDisease(this)"><i class="fa fa-plus"></i>Add</button>
		</div>
	</div>
</div>

</form> --}}



<div class="form-row">
	<div class="col-12 table-responsive">
		<table class="table table-striped table-bordered table-hover mb-0" id="family_table">
			<thead class="bg-primary">
				<tr>
					<th class="text-center">SL</th>
					<th class="text-center">Relative</th>
					<th class="text-center">Disease</th>
					<th class="text-center">From Date </th>
					<th class="text-center">To Date </th>
					<th class="text-center">Severity</th>
					<th class="text-center">Sufferred Duration</th>
					<th class="text-center w-5">Death</th>
					<td class="text-center">Action</td>
				</tr>
			</thead>
			<tbody id='family_container'>
				@if(!empty($family_disease_data))
				@foreach ($family_disease_data as $value)
				<tr>
					<td class="text-center">{{$loop->iteration}}</td>
					<td class="text-center">{{$value->relation_name}}</td>
					<td class="text-center">{{$value->disease_name}}</td>
					<td class="text-center">{{!empty($value->date_from)?date("d/m/Y", strtotime($value->date_from)):""}}</td>
					<td class="text-center">{{!empty($value->date_to)?date("d/m/Y", strtotime($value->date_to)):""}}</td>
					<td class="text-center">{{$value->severity}}</td>
					<td class="text-center">{{$value->suffered_duration}} </td>
					<td class="text-center">
						@if($value->death_bydisease_ind == 1)
                            <span class="badge badge-primary">Yes</span>
{{--						<input type="checkbox" id="death_yes" name="death_yes" class="" value="" checked="checked">--}}
                        @else
                            <span class="badge badge-warning">No</span>
						@endif
					</td>
					<td class="text-center">
						<span onclick="EMRFunc.removeFamilyDisease(this)" class="btn btn-sm btn-danger" id="{{ $value->familymedhistory_no_pk }}" data-action="{{route('emr.family-disease-data-delete',$value->familymedhistory_no_pk)}}"><i class='fa fa-times'></i></span>
					</td>
				</tr>
				@endforeach
				@else

					<tr>
						<td colspan="10" class="text-center">No Data Found</td>
					</tr>
				@endif
			</tbody>
		</table>
	</div>
</div>

<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

<script type="text/javascript">
		$('.datepicker').datepicker({
		//format: 'dd/mm/yyyy',
		autoclose: true,
        todayBtn: true,
		todayHighlight: true
	});
</script>
