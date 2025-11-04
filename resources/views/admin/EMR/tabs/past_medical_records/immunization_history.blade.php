<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<form  method="post" id="emr-current-patient" action="{{ route('emr.immuzation-history-store') }}" >
	<input type="hidden" value="{{$patient_id}}" class="keep_me" name="patient_id" id="hdn_patient_id">
	<div class="form-row justify-content-center mb-3">
		<div class="col-md-3">
			<div class="form-group">
				<label class="col-form-label col-form-label-sm" for="immunization_name">Immunization Name</label>
				<input type="text" class="form-control form-control-sm m-0" id="immunization_name" name="immunization_name" value="" placeholder="Immunization Name">
			</div>
		</div>

		<div class="col-md-3">
			<div class="form-group">
				<label class="col-form-label col-form-label-sm" for="dose_numer">Dose Number</label>
				<input type="text" class="form-control form-control-sm m-0 number_only" id="dose_numer" name="dose_numer" value="" placeholder="Dose Numer">
			</div>
		</div>

		<div class="col-md-3">
			<div class="form-group">
				<label class="col-form-label col-form-label-sm" for="immunization_date">Date</label>
				<input type="text" class="form-control form-control-sm m-0 datepicker" id="immunization_date" name="immunization_date" value="" placeholder="dd/mm/yyyy">
			</div>
		</div>
		<div class="col-md-3">
			<div class="btn-group btn-block mt-4" role="group">
				@php
				$response_action = route('emr.patient-current-emr-use');
				@endphp


				<button type="button" class="btn btn-md btn-success" onclick="EMRFunc.storeImunization(this)"><i class="fa fa-plus"></i>Add</button>
				<button type="button" class="btn btn-info  btn-md"><i class="fa fa-redo"></i> Refresh</button>

			</div>
		</div>
	</div>
</form>

<div class="form-row">
	<div class="col-12 table-responsive">
		<table class="table table-striped table-bordered table-hover mb-0" id="immunization_table">
			<thead class="bg-primary">
				<tr>
					<th class="text-center">SL</th>
					<th class="text-center">Date</th>
					<th class="text-center">Immunization Name</th>
					<th class="text-center">Dose Number</th>
{{--					<th class="text-center">Hospital</th>--}}
					<th class="text-center">Action</th>
				</tr>
			</thead>
			<tbody id="immunization_container">
                    @if(!$immunization_data->isEmpty())
                        @foreach ($immunization_data as $value)
                        <tr>
                            <td class="text-center">{{$loop->iteration}}</td>
                            <td class="text-center">{{!empty($value->immunization_start_date)?date("d/m/Y", strtotime($value->immunization_start_date)):""}} </td>
                            <td class="text-center">{{$value->immunization_name}}</td>
                            <td class="text-center">{{$value->dose_number}}</td>
{{--                            <td class="text-left">--}}
{{--                            </td>--}}
                            <td class="text-center">
                                <span onclick="EMRFunc.removeImunization(this)" class="btn btn-sm btn-danger" id="{{ $value->immunization_no_pk }}" data-action="{{route('emr.immunization-data-delete',$value->immunization_no_pk)}}"><i class='fa fa-times'></i></span>
                            </td>
                        </tr>
                        @endforeach
{{--                    @else--}}

{{--				<tr>--}}
{{--					<td colspan="10" class="text-center">No Data Found</td>--}}
{{--				</tr>--}}
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
