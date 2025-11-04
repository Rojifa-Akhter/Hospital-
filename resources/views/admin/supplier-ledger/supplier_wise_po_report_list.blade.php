<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<table class="table data-table data_table_sup_po table-bordered table-hover table-striped">
	<thead class="bg-primary">
		<tr>
			<th class="text-center">SL#</th>
			<th class="text-center">Code</th>
			<th class="text-center">PO</th>
			<th class="text-center">PO Date</th>
			<th class="text-center">PO Amount</th>
			<th class="text-center">PO Discount</th>
			<th class="text-center">Paid Amount</th>
			<th class="text-center">No Of Item</th>
			<th class="text-center">Delivery Date</th>
			<th class="text-center">Last Payment Date</th>
			<th class="text-center">Status</th>
			<th class="text-center">Actions</th>

		</tr>

	</thead>
	<tbody>

		@if (!empty($supplierwisePo))
		@foreach ($supplierwisePo as $data)
		@if($data->purchaseorder_no_pk)
		<tr>
			<td class="text-center">{{ $loop->iteration }}</td>
			<td class="text-center">{{ $data->supplier_uid }}</td>
			<td class="text-center">{{ $data->purchase_uid }}</td>
			<td class="text-center">{{ date('d/m/Y', strtotime($data->purchase_date)) }}</td>
			<td class="text-center">{{ $data->po_amount }}</td>
			<td class="text-center">{{ $data->po_discount }}</td>
			<td class="text-center">{{ $data->po_paid_amount}}</td>
			<td class="text-center">{{ $data->no_of_item }}</td>
			<td class="text-center">{{ $data->delivery_date }}</td>
			<td class="text-center">{{ date('d/m/Y', strtotime($data->po_last_paid_date)) }}</td>
			<td class="text-left">{{ $data->po_status }}</td>
			<td class="text-left">
				<form method="GET" action="{{ route('inventory.purchase_order_print', $data->purchaseorder_no_pk) }}"
					data-response-action="">
					@csrf
					<button class="btn btn-sm btn-primary text-left" type='submit' target="_blank">PO Pdf
					</button>
				</form>
				<button class="btn btn-sm btn-primary open-modal" data-id="{{$data->purchaseorder_no_pk}}" data-action="{{route('pcrm.po-no',$data->purchaseorder_no_pk)}}" data-modal="common-modal-sm" data-title="Supplier Wise PO Payment Report" data-dismiss="modal" aria-label="Close">Payment
				</button>
			</td>

		</tr>
		@endif
		@endforeach
		@endif
	</tbody>
</table>


<script type="application/javascript"
src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script>
	$('.data_table_sup_po').DataTable({
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
