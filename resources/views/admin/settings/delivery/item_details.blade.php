<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<table class="table data-table data_table_item_details table-bordered table-hover table-striped">
	<thead class="bg-primary">
		<tr>
			<th class="text-center" style="width:10%">SL#</th>
			<th class="text-left">Item Name</th>
			<th class="text-center">Quantity</th>
			<th class="text-right" style="width: 20%">Unit Price</th>
			<th class="text-right">Price</th>

		</tr>

	</thead>
	<tbody>

		@if (isset($item_details))

		@foreach ($item_details as $data)
		<tr>
			<td class="text-center">{{ $loop->iteration }}</td>
			<td class="text-left">{{ ucfirst(strtolower($data->product_name)) }}</td>
			<td class="text-center">{{ $data->quantity }}</td>
			<td class="text-right">{{ number_format($data->product_price,2) }}</td>
			<td class="text-right">{{ number_format($data->product_price*$data->quantity,2) }}</td>

		</tr>
		@endforeach
		@endif
	</tbody>
</table>


<script type="application/javascript"
src="{{ asset('../node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script>
	$('.data_table_item_details').DataTable({
		"lengthMenu": [
		[50],
		[50]
		],
		"ordering": false,
		"bPaginate": false,
		"bLengthChange": false,
		"bAutoWidth": false,
	});
</script>
