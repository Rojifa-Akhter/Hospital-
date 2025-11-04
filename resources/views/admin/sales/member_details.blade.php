<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<table class="table data-table data_table_item_details table-bordered table-hover table-striped">
	<thead class="bg-primary">
		<tr>
			<th class="text-center" style="width:10%">SL#</th>
			<th class="text-left">Member Name</th>

		</tr>

	</thead>
	<tbody>

		@if (isset($member_details))

		@foreach ($member_details as $data)
		<tr>
			<td class="text-center">{{ $loop->iteration }}</td>
			<td class="text-left">{{ ucfirst(strtolower($data->full_name)) }}</td>
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
