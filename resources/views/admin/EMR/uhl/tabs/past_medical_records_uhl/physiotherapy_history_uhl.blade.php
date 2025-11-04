<div class="form-row mt-3">
	<div class="col-12 table-responsive" >
		<table class="table table-striped table-bordered table-hover mb-0">
			<thead class="bg-primary">
				<tr>
					<th class="text-center">SL</th>
					<th class="text-center">Date</th>
					{{-- <th class="text-center">Pres. Code</th> --}}
					<th class="text-left">Procedure with Duration</th>
					<th class="text-left">Physiotherapist</th>
					{{-- <th class="text-left">Physiotherapy Treatment</th> --}}
				</tr>
			</thead>
			<tbody>
				@if(isset($physiotherapy_details))
					@foreach($physiotherapy_details as $value)
					<tr>
						<td class="text-center">{{$loop->iteration}}</td>
						<td class="text-center">{{date('d/m/Y', strtotime($value->prescription_date))}}</td>
						{{-- <td class="text-center">{{$value->prescription_code}}</td> --}}

						<td class="text-left"></td>
						<td class="text-left">{{$value->doctor_name}}</td>
						{{-- <td class="text-left">{{$value->presdtl_data}}</td> --}}
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