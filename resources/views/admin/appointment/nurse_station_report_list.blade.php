<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<table class="table data-table table-bordered table-hover table-striped">
	<thead class="global-uhl-table-bg">
		<tr>
			<th class="text-center">SL#</th>
			<th class="text-center">Vitals Date</th>
			<th class="text-center">Patient Info</th>
			<th class="text-center">Primary Doc.Name</th>
			<th class="text-center">Department</th>
			<th class="text-center">Appoint SL No</th>
			<th class="text-center">Appoint Date</th>
		</tr>

	</thead>
	<tbody>

		@if (isset($nurse_arr))
		@php
		if($code == null)
		$col_span=7;
		@endphp
		@foreach ($nurse_arr as $key => $values)


		@if( $code == null)
		<tr>
		   <th colspan="{{ $col_span }}" class="text-left"> <h3>{{$key}} </h3> </th>

	   </tr>
	   @endif
	   @foreach ($values as $value)

	   <tr>
		<td class="text-center">{{ $loop->iteration }}</td>
		<td class="text-left">{{ date('d/m/Y', strtotime($value->vital_date)) }}</td>
		<td class="text-left"><strong>Patient Id : </strong>{{$value->patient_code != null ? $value->patient_code : ''}} <br>
			<strong>Patient Name : </strong>{{ $value->patient_name != null ? $value->patient_name : '' }} <br> <strong>Age : </strong>{{$value->age != null ? $value->age : ''}} <br> <strong>Gender :</strong>{{$value->gender_txt != null ? $value->gender_txt : ''}} <br> <strong>Mobile :</strong>{{$value->mobile1 != null ? $value->mobile1 : ''}}
		</td>
		<td class="text-left">{{ $value->full_name }}</td>
		<td class="text-left">{{ $value->serviceunit_name}}</td>
		<td class="text-center">{{ $value->slot_sl}}</td>
		<td class="text-left">{{ date('d/m/Y', strtotime($value->appoint_date)) }}</td>
	</tr>
	@endforeach
	@endforeach
	@endif

</tbody>
</table>


<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script>
	$('.data-table').DataTable({
		"lengthMenu": [
		[50],
		[50]
		],
		"ordering": false,
		"bPaginate": false,
		"bLengthChange": false,
		"bAutoWidth": false
	});
</script>
