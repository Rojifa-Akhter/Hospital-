<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<section id="full_lookup_list">
	<div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm align-items-center justify-content-between">
            <div class="col-md-6">
                <h5 class="mt-2 mb-0">UOM List</h5>
                <small>UOM List</small>
            </div>
            <div class="col-md-6 text-right">
                <div id="top-action" class="m-0">
                    <button class="btn btn-outline-primary btn-md open-modal" data-modal="common-modal-sm" data-action="{{ route('v1.store.uom_form') }}" data-title="Create UOM List" title="Create UOM"><i class="fa fa-plus"></i> Create UOM</button>
                </div>
            </div>
        </div>


		<div class="card">
			<div class="card-body">
				<div class="row mt-2">
				    <div class="col-md-12 table-responsive">
				        <table id="datatable" class="table table-bordered table-hover table-striped data-table">
	                        <thead class="bg-primary">
	                            <tr>
	                                <th class="text-center w-5" scope="col">Sl#</th>
	                                <th class="text-center w-28" scope="col">UOM Name</th>
	                                <th class="text-center" scope="col">Status</th>
	                                <th class="text-center w-15" scope="col">Actions</th>
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
			"serverSide": false, 
			"ajax": {
				"url": "{{ url('v1/store/get-uom') }}",
				"type": "POST",
				"data": { _token: "{{ csrf_token() }}" },
				"dataSrc": "data" 
			},
			"columns": [
				{ 
					"data": null, 
					"className": "text-center",
					"render": function (data, type, row, meta) {
						return meta.row + 1; 
					}
				},
				{ "data": "uom_code", "className": "text-center" }, 
				{ 
					"data": "status", 
					"className": "text-center",
					"render": function (data, type, row, meta) {
						if (data == 1) {
							return '<span class="badge badge-success px-3 py-1">Active</span>';
						} else {
							return '<span class="badge badge-danger px-3 py-1">Inactive</span>';
						}
					}
				},   
				{ 
					"data": "uom_no_pk", 
					"className": "text-center",
					"render": function (data, type, row, meta) {
						var edit_action = '{{ route("v1.store.edit-uom", ":id") }}'.replace(':id', data);
						return '<span href="#" 	 data-id="'+ data +'" data-action="'+ edit_action +'" data-modal="common-modal-sm" data-title="Edit UOM" title="Edit Menu"><i class="fa fa-pencil-alt"></i></span>';
					}
				}
			]
		});
	});
</script>
