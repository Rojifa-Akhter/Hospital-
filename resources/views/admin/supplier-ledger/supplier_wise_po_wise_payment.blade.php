<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<table class="table data-table data_table_sup_po_payment table-bordered table-hover table-striped">
	<thead class="bg-primary">
		<tr>
			<th class="text-center" style="width:10%">SL#</th>
			<th class="text-center">Ledger No</th>
			<th class="text-center">Payment Date</th>
			<th class="text-left">Payment Amount</th>

		</tr>

	</thead>
	<tbody>

		@if (isset($payment))
		@php
		$total_payment_amount = 0;
		@endphp
		@foreach ($payment as $data)
		@php
		$total_payment_amount += $data->payment_amount;
		@endphp
		<tr>
			<td class="text-center">{{ $loop->iteration }}</td>
			<td class="text-center">{{ $data->supledger_no_uid }}</td>
			<td class="text-left">{{ date('d/m/Y',strtotime($data->payment_date)) }}</td>
			<td class="text-right">{{ $data->payment_amount }}</td>
		</tr>
		@endforeach
		<tr>
			<td style="display:none;"></td>
			<td style="display:none;"></td>
			<td class="text-right" colspan="3"><strong>Total Payment Amount</strong></td>
			<td class="text-right">
				<strong>
					{{$total_payment_amount}}
				</strong>
			</td>

		</tr>
		@endif
	</tbody>
</table>


<script type="application/javascript"
src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script>
	$('.data_table_sup_po_payment').DataTable({
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
