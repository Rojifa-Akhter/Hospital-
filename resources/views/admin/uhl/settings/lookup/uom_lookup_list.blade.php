<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<section id="full_lookup_list">
	<div class="container-fluid">
		<div class="row bg-white border-bottom sticky-top shadow-sm">
			<div class="col-md-12 mb-1">
				<h5 class="mt-2 mb-0">Lookup  List</h5>
				<small>Settings / Lookup Setup / Lookup  List</small>
			</div>
		</div>
		<div class="card">
			<div class="card-header"><h5>Lookup List <button class="btn btn-sm btn-primary float-right open-modal" data-modal="common-modal-sm" data-action="{{ route('uhl.uom.lookup.create_form') }}" data-title="Create New Lookup">Create Lookup</button></h5></div>

			<div class="card-body">
				<div class="row mt-2">
				    <div class="col-md-12 table-responsive">
				        <table id="datatable" class="table table-bordered table-hover table-striped data-table">
	                        <thead class="bg-primary">
	                            <tr>
	                                <th class="text-center" scope="col">Sl#</th>
	                                <th class="text-left" scope="col">Lookup Uid</th>
	                                <th class="text-center" scope="col">Lookup Name</th>
	                               <th class="text-center" scope="col">Status</th>
	                                <th class="text-center width-150" scope="col">Actions</th>
	                            </tr>
	                        </thead>
	                        <tbody>

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
			"processing": true,
			"serverSide": true,
            "order": [[ 2, "asc" ]],
			"ajax":{
				"url": "{{ url('uhl/uom-lookup/lookup-list') }}",
				"dataType": "json",
				"type": "POST",
				"data":{ _token: "{{csrf_token()}}"}
			},
			"columnDefs": [
			{
				"targets": 3,
				"data": "Edit",
				"render": function ( data, type, row, meta ) {

					// var create_action = '{{ route("lookup.create") }}';
					// create_action = create_action.replace(':id', row[0]);

					if (row[4] == 1) {
						return 'Active'
					} 
					
					if (row[4] != 1) {
						return 'Active'
					}			
				}
			},	
			{
				"targets": -1,
				"data": "Edit",
				"render": function ( data, type, row, meta ) {

					// var create_action = '{{ route("lookup.create") }}';
					// create_action = create_action.replace(':id', row[0]);

					var edit_action = '{{ route("uhl.uom.lookup.edit", ":id") }}';
					edit_action = edit_action.replace(':id', row[4]);
					// var delete_action = '{{ route("lookup.destroy", ":id") }}';
					// delete_action = delete_action.replace(':id', row[0]);

					return '<span Class="btn btn-sm btn-primary open-modal" data-id="'+ row[4] +'" data-action="'+edit_action+'" data-modal="common-modal-sm" data-title="Edit Lookup" title="Edit"><i class="fa fa-pencil-alt"></i></span>';
				}
			}]
		});
	});
</script>
