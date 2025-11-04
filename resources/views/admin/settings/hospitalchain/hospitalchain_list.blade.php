<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<section id="full_lookup_list">
	<div class="container-fluid">
		<div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">Hospital Chain list</h5>
                <small>Settings / Hospital Chain  Setup / Hospital Chain list</small>
            </div>
        </div>
		<div class="card">
			<div class="card-header"><h5>Hospital Chain List <button class="btn btn-sm btn-primary float-right open-modal" data-modal="common-modal-md" data-action="{{ route('hospitalchain.create_form') }}" data-title="Create New Hospital Chain">Create Hospital Chain</button></h5></div>

			<div class="card-body">
				<div class="row mt-2">
				    <div class="col-md-12 table-responsive">
				        <table id="datatable" class="table table-bordered table-hover table-striped data-table">
	                        <thead class="bg-primary">
	                            <tr>
	                                <th class="text-center" scope="col">Sl#</th>
	                                <th class="text-left" scope="col">Hospital Chain Code</th>
	                                <th class="text-center" scope="col">Hospital Chain Name</th>
	                                <th class="text-center" scope="col">Address 1</th>
	                                <th class="text-center" scope="col">District</th>
	                                <th class="text-center" scope="col">Division</th>
	                                <th class="text-center" scope="col">Telephone 1</th>
	                                <!-- <th class="text-center" scope="col">email</th> -->
	                                <!-- <th class="text-center" scope="col">website</th> -->
	                                <th class="text-center width-150" scope="col">Actions</th>
	                            </tr>
	                        </thead>
	                        <tbody></tbody>
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
			"processing": true,
			"serverSide": true,
			"ajax":{
				"url": "{{ url('hospitalchain-list') }}",
				"dataType": "json",
				"type": "POST",
				"data":{ _token: "{{csrf_token()}}"}
			},
			"columnDefs": [{
				"targets": -1,
				"data": "Edit",
				"render": function ( data, type, row, meta ) {

					// var create_action = '{{ route("hospitalchain.create") }}';
					// create_action = create_action.replace(':id', row[0]);

					var edit_action = '{{ route("hospitalchain.edit", ":id") }}';
					edit_action = edit_action.replace(':id', row[9]);

					// var delete_action = '{{ route("hospitalchain.destroy", ":id") }}';
					// delete_action = delete_action.replace(':id', row[0]);

					return '<span Class="btn btn-sm btn-primary open-modal" data-id="'+ row[9] +'" data-action="'+edit_action+'" data-modal="common-modal-md" data-title="Edit Hospital Chain" title="Edit"><i class="fa fa-pencil-alt"></i></span>';
				}
			}]
		});
	});
</script>
