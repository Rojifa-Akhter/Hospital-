<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<section id="full_lookup_list">
	<div class="container-fluid">
		<div class="row bg-white border-bottom sticky-top shadow-sm">
			<div class="col-md-12 mb-1">
				<h5 class="mt-2 mb-0">Delivery Charge List</h5>
				<small>Settings / Delivery Charge / Delivery Charge List</small>
			</div>
		</div>
		<div class="card">
			<div class="card-header"><h5>Delivery Charge List <button class="btn btn-sm btn-primary float-right open-modal" data-modal="common-modal-sm" data-action="{{ route('delivery-charge-form') }}" data-title="Create Delivery Charge">Create Delivery Charge</button></h5></div>

			<div class="card-body">
				<div class="row mt-2">
					<div class="col-md-12 table-responsive">
						<table id="datatable" class="table table-bordered table-hover table-striped data-table">
							<thead class="bg-primary">
								<tr>
									<th class="text-center" scope="col">Sl#</th>
									<th class="text-left" scope="col">Delivery Charge Type</th>
									<th class="text-left" scope="col">Delivery Charge</th>
									<th class="text-center width-150" scope="col">Action</th>
								</tr>
							</thead>
							<tbody>

								@if(!empty($delivery_charges))
								@foreach( $delivery_charges as $data)
								 @if($data->delivery_charge_no_pk)
								<tr>
									<td>{{ $loop->iteration }}</td>
									<td>{{$data->delivery_charge_type}}</td>
									<td>{{$data->delivery_charge}}</td>
									<td><span class="btn btn-sm btn-primary open-modal" data-id="{{$data->delivery_charge_no_pk}}" data-action="{{route('delivery-charge.edit',$data->delivery_charge_no_pk)}}" data-modal="common-modal-sm" data-title="Edit Delivery Charge" title="Edit"><i class="fa fa-pencil-alt"></i></span></td>

								</tr>
								@endif
								@endforeach
								@endif
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script>
	$(document).ready(function () {
		var datatable = $('.data-table').DataTable({
			      "aoColumnDefs": [
          { 'bSortable': false, 'aTargets': [ 3 ] }
       ]});
		// var datatable = $('.data-table').DataTable({
		// 	"processing": true,
		// 	"serverSide": true,
		// 	"ajax":{
		// 		"url": "{{ url('room-list') }}",
		// 		"dataType": "json",
		// 		"type": "POST",
		// 		"data":{ _token: "{{csrf_token()}}"}
		// 	},
		// 	"columnDefs": [{
		// 		"targets": -1,
		// 		"data": "Edit",
		// 		"render": function ( data, type, row, meta ) {

		// 			// var create_action = '{{ route("room.create") }}';
		// 			// create_action = create_action.replace(':id', row[0]);

		// 			var edit_action = '{{ route("room.edit", ":id") }}';
		// 			edit_action = edit_action.replace(':id', row[7]);

		// 			// var delete_action = '{{ route("room.destroy", ":id") }}';
		// 			// delete_action = delete_action.replace(':id', row[0]);

		// 			return '<span Class="btn btn-sm btn-primary open-modal" data-id="'+ row[7] +'" data-action="'+edit_action+'" data-modal="common-modal-sm" data-title="Edit Room" title="Edit"><i class="fa fa-pencil-alt"></i></span>';
		// 		}
		// 	}]
		// });
	});
</script>
