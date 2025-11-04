<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<section id="full_lookup_list">
	<div class="container-fluid">
		<div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm align-items-center">
			<div class="col-md-6">
				<h5 class="mt-2 mb-0">Menu List</h5>
				<small>Settings / Menu Setup / Create Menu List </small>
			</div>
		</div>
		<div class="card">
			<div class="card-header "><h5>Menu List <button class="btn btn-sm btn-primary float-right open-modal" data-modal="common-modal-md" data-action="{{ route('menu-create-form') }}" data-title="Create New Menu">Create Menu</button></h5></div>

			<div class="card-body">
				<div class="row mt-2">
				    <div class="col-md-12 table-responsive">
				        <table id="datatable" class="table table-bordered table-hover table-striped data-table">
	                        <thead class="bg-primary">
	                            <tr>
	                                <th class="text-center" scope="col">Sl#</th>
	                                <th class="text-center" scope="col">Menu Id</th>
	                                <th class="text-center" scope="col">Name</th>
	                                <th class="text-center" scope="col">Serial Number</th>
	                                <th class="text-center" scope="col">Page Link</th>
	                                <th class="text-center" scope="col">Menu Icon</th>
	                                <th class="text-center" scope="col">Status</th>
	                                <th class="text-center" scope="col">Actions</th>
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
				"url": "{{ url('menu-list') }}",
				"dataType": "json",
				"type": "POST",
				"data":{ _token: "{{csrf_token()}}"}
			},
			"columnDefs": [{
				"targets": -1,
				"data": "Edit",
				"render": function ( data, type, row, meta ) {

					var edit_action = '{{ route("menu.edit", ":id") }}';
					edit_action = edit_action.replace(':id', row[7]);

					return '<span href="#" Class="btn btn-sm btn-primary open-modal" data-id="'+ row[7] +'" data-action="'+edit_action+'" data-modal="common-modal-md" data-title="Edit Menu" title="Edit Menu"><i class="fa fa-pencil-alt"></i></span>';
				}
			}]
		});
	});
</script>
