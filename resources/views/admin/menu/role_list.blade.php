<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<section id="full_lookup_list">
	<div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm align-items-center justify-content-between">
            <div class="col-md-6">
                <h5 class="mt-2 mb-0">Role List</h5>
                <small>Menu Management / Role List</small>
            </div>
            <div class="col-md-6 text-right">
                <div id="top-action" class="m-0">
                    <button class="btn btn-outline-primary btn-md open-modal" data-modal="common-modal-sm" data-action="{{ route('role-create-form') }}" data-title="Create Menu List" title="Create Role List"><i class="fa fa-plus"></i> Create Role</button>
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
	                                <th class="text-center w-28" scope="col">Role Name</th>
	                                <th class="text-center" scope="col">Description</th>
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
			"serverSide": true,
			"ajax":{
				"url": "{{ url('role-list-get') }}",
				"dataType": "json",
				"type": "POST",
				"data":{ _token: "{{csrf_token()}}"}
			},
			"columnDefs": [{
				"targets": -1,
				"data": "Edit",
				"render": function ( data, type, row, meta ) {

					var edit_action = '{{ route("role-edit", ":id") }}';
					var add_action = '{{ route("create-user-role-form", ":id") }}';
					edit_action = edit_action.replace(':id', row[4]);
					add_action = add_action.replace(':id', row[4]);

					return '<span href="#" Class="btn btn-sm btn-primary open-modal" data-id="'+ row[4] +'" data-action="'+edit_action+'" data-modal="common-modal-sm" data-title="Edit Menu" title="Edit Menu"><i class="fa fa-pencil-alt"></i></span>' +'  '+ '<span href="#" Class="btn btn-sm btn-success open-modal" data-id="'+ row[4] +'" data-action="'+add_action+'" data-modal="common-modal-sm" data-title="Add Role" title="Add Privilege">Add Privilege</span>';
				}
			}]
		});

	});
</script>
