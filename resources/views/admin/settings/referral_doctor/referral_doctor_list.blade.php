<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.min.css') }}" rel="stylesheet">




<section id="full_lookup_list">
	<div class="container-fluid">

        <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
            <div class="col-md-12">
                <div class="float-left">
                    <h5 class="mt-2 mb-0">Referral Doctor List</h5>
                    <small>Settings / Referral Doctor / Referral Doctor List</small>
                </div>
                <div id="top-action">
                    <button class="btn btn-outline-primary btn-md bg-none float-right mt-2 ml-2 open-modal"
                            data-modal="common-modal-md"
                            data-action="{{ route('doctor-referral.create_form') }}" data-title="Create Referral Doctor"><i
                            class="fa fa-plus"></i> Create New
                        Referral Doctor
                    </button>
                </div>
            </div>
        </div>


		<div class="card">
			<div class="card-header"><h5>Referral Doctor List </h5></div>

			<div class="card-body">
				<div class="row mt-2">
				    <div class="col-md-12 table-responsive">
				        <table id="datatable" class="table table-bordered table-hover table-striped data-table">
	                        <thead class="bg-primary">
	                            <tr>
	                                <th class="text-center" scope="col">Sl#</th>
	                                <th class="text-left" scope="col">Name</th>
	                                <th class="text-center" scope="col">Phone</th>
	                                <th class="text-center" scope="col">Email</th>
	                                <th class="text-center" scope="col">Location</th>
	                                <th class="text-center" scope="col">Area</th>
	                                <th class="text-center width-150" scope="col">Actions</th>
	                            </tr>
	                        </thead>
	                        <tbody>
	                            {{-- <tr>
	                                <td class="text-center">1</td>
	                                <td class="text-left">Userosp</td>
	                                <td class="text-center">User Wise Hospital</td>
	                                <td class="text-center">User Wise Hospital Assignment</td>
	                                <td class="text-center">1</td>
	                                <td class="text-center">
	                                    <a href="#" Class="btn btn-sm btn-primary" title="Edit Lookup"><i class="fa fa-pencil-alt"></i></a>
	                                    <a href="#" Class="btn btn-sm btn-danger" title="Delete Lookup"><i class="fa fa-trash"></i></a>

	                                    <button Class="btn btn-sm btn-info text-white open-modal" data-action="{{ route('lookup.create') }}" data-title="Create Lookup Item" title="Create Lookup Item">Lookup Item</button>

	                                    <button Class="btn btn-sm btn-success open-modal" data-action="" data-title="Create Lookup Mapping" title="Create Lookup Item Mapping">Lookup Item Mapping</button>
	                                </td>
	                            </tr> --}}
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
				"url": "{{ url('doctor-referral-list') }}",
				"dataType": "json",
				"type": "POST",
				"data":{ _token: "{{csrf_token()}}"}
			},
			"columnDefs": [{
				"targets": -1,
				"data": "Edit",
				"render": function ( data, type, row, meta ) {

					// var create_action = '{{ route("room.create") }}';
					// create_action = create_action.replace(':id', row[0]);

					var edit_action = '{{ route("doctor-referral.edit", ":id") }}';
					edit_action = edit_action.replace(':id', row[6]);

					// var delete_action = '{{ route("room.destroy", ":id") }}';
					// delete_action = delete_action.replace(':id', row[0]);

					return '<span Class="btn btn-sm btn-primary open-modal" data-id="'+ row[6] +'" data-action="'+edit_action+'" data-modal="common-modal-md" data-title="Edit Referral Doctor" title="Edit"><i class="fa fa-pencil-alt"></i></span>';
				}
			}]
		});
	});
</script>
