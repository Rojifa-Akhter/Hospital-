<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<table class="table data-table table-bordered table-hover table-striped">
	<thead class="bg-primary">
		<tr>
			<th class="text-center">SL#</th>
			<th class="text-center">Order Id</th>
			<th class="text-center">No Of Item</th>
			<th class="text-center">Order Date</th>
			<th class="text-center">Delivered Date</th>
			<th class="text-center">Order Amount</th>
		</tr>

	</thead>
	<tbody>

		@if (isset($delivery_arr))
		@php
		if($code == null)
		$col_span=6;
		@endphp
		@foreach ($delivery_arr as $key => $values)


		@if( $code == null)
		<tr>
			<th colspan="{{ $col_span }}" class="text-left"> <h3>{{$key}} </h3> </th>

		</tr>
		@endif
		@foreach ($values as $value)

		<tr>
			<td class="text-center">{{ $loop->iteration }}</td>
			<td class="text-center">{{$value->order_no}}</td>
			<td class="text-center">{{$value->quantity}}</td>
			@if($value->order_date)
			<td class="text-center">{{date('d/m/Y', strtotime($value->order_date))}}</td>
			@else
			<td>{{$value->order_date}}</td>
			@endif
			@if($value->delivered_date)
			<td class="text-center">{{date('d/m/Y', strtotime($value->delivered_date))}}</td>
			@else
			<td>{{$value->delivered_date}}</td>
			@endif

			<td class="text-center">{{ $value->tot_amount}}</td>
		</tr>
		@endforeach
		@endforeach
		@endif

	</tbody>
</table>


<script type="application/javascript"
src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
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
