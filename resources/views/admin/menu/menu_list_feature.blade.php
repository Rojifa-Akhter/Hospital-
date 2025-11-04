<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">

<div class="container-fluid">
	<div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm align-items-center justify-content-between">
		<div class="col-md-6">
			<h5 class="mt-2 mb-0">Menu List Feature</h5>
			<small>Menu Management / Menu List Feature</small>
		</div>
		<div class="col-md-6 text-right">
			<div id="top-action" class="m-0">
				<button class="btn btn-outline-primary btn-md open-modal" data-modal="common-modal-sm" data-action="{{ route('menu-feature-create-form') }}" data-title="Add New Menu Feature" title="New Menu Feature"><i class="fa fa-plus"></i> Add New Menu Feature</button>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header"><h5>Menu Feature
                    </h5></div>
				<div class="card-body">
					<div class="row mt-2">
						<div class="col-md-12 table-responsive">
							<table id="data-table" class="table table-bordered table-hover table-striped data-table">
								<thead class="bg-primary">
									<tr>
										<th class="text-center" scope="col">Sl#</th>
										<th class="text-left" scope="col">Module name</th>
										<th class="text-center" scope="col">Feature Id</th>
										<th class="text-center" scope="col">Menu Name</th>
                                        <!-- <th class="text-center" scope="col">Icon</th> -->
                                        <th class="text-center" scope="col">Serial Number</th>
                                        <th class="text-center" scope="col">Page URL</th>
                                        <!-- <th class="text-center" scope="col">Status</th>                                         -->
                                        <th class="text-center" scope="col">Action</th>
									</tr>
								</thead>
								<tbody></tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script>
    $(document).ready(function () {
        var datatable = $('.data-table').DataTable({
            "ordering": false,
            "language": {
                "infoFiltered": ""
            },
            "processing": true,
            "serverSide": true,
            "ajax":{
                "url": "{{ url('menu-feature-list') }}",
                "dataType": "json",
                "type": "POST",
                "data":{ _token: "{{csrf_token()}}"}
            },
            "columnDefs": [{
                "targets": -1,
                "data": "Edit",
                "render": function ( data, type, row, meta ) {
                    var edit_action = '{{ route("menu-feature-create-editForm", ":id") }}';
                    edit_action = edit_action.replace(':id', row[6]);

                    return '<span Class="btn btn-sm btn-primary open-modal" data-id="'+ row[6] +'" data-action="'+edit_action+'" data-modal="common-modal-sm" data-title="Edit Menu Feature" title="Edit"><i class="fa fa-pencil-alt"></i></span>';
                }
            }]
        });
    });
</script>
