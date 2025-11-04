<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<section id="full_lookup_list">
	<div class="container-fluid">
		<div class="row bg-white border-bottom sticky-top shadow-sm">
			<div class="col-md-12 mb-1">
				<h5 class="mt-2 mb-0">Prescription Favourite Item List</h5>
				<small>Settings / Prescription Favourite Item / Prescription Favourite Item List</small>
			</div>
		</div>
		<div class="card">
			<div class="card-header"><h5>Prescription Favourite Item List <button class="btn btn-sm btn-primary float-right open-modal" data-modal="common-modal-sm" data-action="{{ route('prescription-favourite-item-form') }}" data-title="Create Prescription Favourite Item">Create Prescription Favourite Item</button></h5></div>

			<div class="card-body">
				<div class="row mt-2">
					<div class="col-md-12 table-responsive">
						<table id="datatable" class="table table-bordered table-hover table-striped data-table">
							<thead class="bg-primary">
								<tr>
									<th class="text-center" scope="col">Sl#</th>
									<th class="text-left" scope="col">Doctor Name</th>
									<th class="text-left" scope="col">Department</th>
									<th class="text-center" scope="col">Item Type Code</th>
									<th class="text-center" scope="col">Favourite Name</th>
									<th class="text-center" scope="col">Status</th>
									<th class="text-center width-150" scope="col">Actions</th>
								</tr>
							</thead>
							<tbody>

								@if(!empty($presFavItem))
								@foreach( $presFavItem as $data)
								<tr>
									<td>{{ $loop->iteration }}</td>
									<td>{{ucfirst(strtolower($data->full_name))}}</td>
									<td>{{ucfirst(strtolower($data->su_name))}}</td>
									<td>{{ucfirst(strtolower($data->item_type_lookup_code))}}</td>
									<td>{{ucfirst(strtolower($data->favourite_name))}}</td>
									<td>{{$data->status == 1 ? 'Active' : 'Inactive'}}</td>
									<td><span class="btn btn-sm btn-primary open-modal" data-id="{{$data->pres_fav_no_pk}}" data-action="{{route('prescription-favourite-item.edit',$data->pres_fav_no_pk)}}" data-modal="common-modal-sm" data-title="Edit Pres lookup detail data" title="Edit"><i class="fa fa-pencil-alt"></i></span></td>

								</tr>
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
		var datatable = $('.data-table').DataTable();
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
