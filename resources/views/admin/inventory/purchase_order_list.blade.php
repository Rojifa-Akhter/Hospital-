<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<table class="table data-table table-bordered table-hover table-striped">
							<thead class="bg-primary">
								<tr>
									<td class="text-center w-5" scope="col">#SL</td>
									<td class="text-center w-5" scope="col">PO ID</td>
									<td class="text-center w-15" scope="col">PO Date</td>
									<td class="text-center" scope="col"> Supplier</td>
									<td class="text-center w-15" scope="col">Delivery Date</td>
									<td class="text-center w-5" scope="col">Item Count PO Amount</td>
									<td class="text-center w-10" scope="col">Status</td>
									<td class="text-center w-10" scope="col">Action</td>
								</tr>
							</thead>
@if(isset($poList))
@foreach($poList as $value)
<tr>
    <td class="text-center" scope="col">{{$loop->iteration}}</td>
    <td class="text-center" scope="col">{{$value->purchaseorder_no_pk}}</td>
    <td class="text-left" scope="col">{{date('d/m/Y',strtotime($value->purchase_date))}}</td>
    <td class="text-left" scope="col"></td>
    <td class="text-left" scope="col"></td>
    <td class="text-center" scope="col">{{$value->item_no_fk}}</td>
    <td class="text-center" scope="col">{{$value->status}}</td>
    <td class="text-center" scope="col">
   <a href= "{{route('purchaseOrder.print', $value->purchaseorder_no_pk)}}"> <i class="fas fa-print"></i> </a> <a href= ""> <i class="far fa-edit"></i></a>
    </td>
</tr>
@endforeach
@endif

</table>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script>
  $('.data-table').DataTable( {
        "lengthMenu": [[ 50], [50]],
        "ordering": false,
            "bPaginate": false,
            "bLengthChange": false,
            "bAutoWidth": false
    } );
</script>
