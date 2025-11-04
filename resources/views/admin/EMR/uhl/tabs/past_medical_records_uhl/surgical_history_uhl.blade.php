<div class="form-row mt-3">
	<div class="col-12 table-responsive" >
		<table class="table table-striped table-bordered table-hover mb-0">
			<thead class="bg-primary">
				<tr>
					<th class="text-center">SL</th>
					<th class="text-center">Admission Id</th>
					{{-- <th class="text-center">Ward Name</th> --}}
					<th class="text-center">Date</th>
					{{-- <th class="text-center">Bed Name</th> --}}
					{{-- <th class="text-center">Age</th> --}}
					<th class="text-center">Surgeon Name</th>
					<th class="text-center">OT Note</th>
					
					{{-- <th class="text-center">Operation Name</th> --}}
					{{-- <th class="text-center">Hospital</th> --}}
					{{-- <th class="text-center">Action/Status</th> --}}
				</tr>
			</thead>
			<tbody>
				 @if(!$sergical_data -> isEmpty())
				@foreach ($sergical_data as $value)
				<tr>
					<td class="text-center">{{$loop->iteration}}</td>
					<td class="text-left">{{$value->admission_uid}}</td>
					{{-- <td class="text-left">{{$value->ward_name}}</td> --}}
					<td class="text-left">{{date("d/m/Y", strtotime($value->ot_date))}}</td>
					{{-- <td class="text-left">{{$value->bed_name}}</td> --}}
					{{-- <td class="text-left">{{$value->age}}</td> --}}
					<td class="text-left">{{$value->surg_doctor_name}}</td>
					<td class="text-left"></td>
					
					{{-- <td class="text-left">{{$value->surg_doctor_name}}</td> --}}
					{{-- <td class="text-left">{{$value->hospital_code}}</td> --}}
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
