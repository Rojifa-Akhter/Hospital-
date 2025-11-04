<table class="table data-table data_table_slot_details table-bordered table-hover table-striped">
	<thead class="bg-primary">
		<tr>
			<th class="text-center" style="width:10%">SL#</th>
			<th class="text-left">Schedule Date</th>
			<th class="text-left">Start Time</th>
			<th class="text-left">End Time</th>
			{{-- <th class="text-right">Price</th> --}}

		</tr>

	</thead>
	<tbody>

		@if (isset($slot_details))

		@foreach ($slot_details as $data)
		<tr>
			<td class="text-center">{{ $loop->iteration }}</td>
            <td>
                {{ date("d-m-Y", strtotime($data->schedule_dt)) }}
            </td>
			<td class="text-left">{{ date('h:i A', strtotime($data->start_time)) }}</td>
			<td class="text-left">{{ date('h:i A', strtotime($data->end_time)) }}</td>
			{{-- <td class="text-right">{{ number_format($data->product_price,2) }}</td> --}}
			{{-- <td class="text-right">{{ number_format($data->product_price*$data->quantity,2) }}</td> --}}

		</tr>
		@endforeach
		@endif
	</tbody>
</table>
