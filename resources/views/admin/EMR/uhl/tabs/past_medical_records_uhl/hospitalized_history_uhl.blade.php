<div class="form-row mt-3">
	<div class="col-12 table-responsive" >
		<table class="table table-striped table-bordered table-hover mb-0">
			<thead class="bg-primary">
				<tr>
					<th class="text-center">SL</th>
					<th class="text-center">Admission Date</th>
					<th class="text-center">Admission Id</th>
					<th class="text-center">Ward</th>
					{{-- <th class="text-center">Bed Name</th> --}}
					<th class="text-center">Department</th>
					{{-- <th class="text-center">Dis. Date</th> --}}
					<th class="text-center">Discharge Type</th>
					{{-- <th class="text-left">Hospital</th> --}}
				</tr>
			</thead>
			<tbody>
				 @if(!$hospitalized_data -> isEmpty())
                    @foreach ($hospitalized_data as $value)
                    <tr>
                        <td class="text-center">{{$loop->iteration}}</td>
                        <td class="text-left">{{date("d/m/Y", strtotime($value->admission_date))}}</td>
                        <td class="text-left">{{$value->admission_uid}}</td>
                        <td class="text-left">{{$value->ward_name}}</td>
                        {{-- <td class="text-left">{{$value->bed_name}}</td> --}}
                        <td class="text-left"></td>
                        {{-- <td class="text-left">{{!empty($value->dis_date)?date("d/m/Y", strtotime($value->dis_date)):"N/A"}}</td> --}}
                        <td class="text-left">{{!empty($value->dis_reason)?$value->dis_reason:"N/A"}}</td>
                        {{-- <td class="text-left">{{!empty($value->hospital_name)?$value->hospital_name:"N/A"}}</td> --}}
                    </tr>
                    @endforeach
				@else
				<tr>
					<td colspan="10" class="text-center">No Data Found</td>
				</tr>
				@endif
			</tr>
		</tbody>
	</table>
</div>
</div>
