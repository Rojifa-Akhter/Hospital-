<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<section id="full_lookup_list">
	<div class="container-fluid">
		<div class="row bg-white border-bottom sticky-top shadow-sm">
			<div class="col-md-12 mb-1">
				<h5 class="mt-2 mb-0">Transection Type List</h5>
				<small>Settings / Transection Type Setup / Transection Type List</small>
			</div>
		</div>
		<div class="card">
			<div class="card-header"><h5>Transection Type List <button class="btn btn-sm btn-primary float-right open-modal" data-modal="common-modal-sm" data-action="{{ route('tran-type.create_form') }}" data-title="Create New Transection Type">Create Transection Type</button></h5></div>

			<div class="card-body">
				<div class="row mt-2">
				    <div class="col-md-12 table-responsive">
				        <table id="datatable" class="table table-bordered table-hover table-striped data-table">
	                        <thead class="bg-primary">
	                            <tr>
	                                <th class="text-center" scope="col">Sl#</th>
	                                <th class="text-left" scope="col">Transection Type Code</th>
	                                <th class="text-center" scope="col">Transection Type Name</th>
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
            "ordering": false,
            "language": {
                "infoFiltered": ""
            },
            "processing": true,
            "serverSide": true,
            "ajax":{
                "url": "{{ url('tran-list') }}",
                "dataType": "json",
                "type": "POST",
                "data":{ _token: "{{csrf_token()}}"}
            },
            "columnDefs": [{
                "targets": -1,
                "data": "Edit",
                "render": function ( data, type, row, meta ) {

                    //var create_action = '{{ route("tran-type.create") }}';
                    // create_action = create_action.replace(':id', row[0]);

                    var edit_action = '{{ route("tran-type.edit", ":id") }}';
                    edit_action = edit_action.replace(':id', row[3]);

                    // var delete_action = '{{ route("tran-type.destroy", ":id") }}';
                    // delete_action = delete_action.replace(':id', row[0]);

                    return '<span Class="btn btn-sm btn-primary open-modal" data-id="'+ row[3] +'" data-action="'+edit_action+'" data-modal="common-modal-sm" data-title="Edit Transection Type" title="Edit"><i class="fa fa-pencil-alt"></i></span>';
                }
            }]
        });
    });
</script>
