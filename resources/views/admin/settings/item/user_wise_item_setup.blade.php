<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<section id="full_lookup_list">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
            <div class="col-md-12">
                <div class="float-left">
                    <h5 class="mt-2 mb-0">Add New Item To User</h5>
                    <small>Settings / Item / User Item Setup</small>
                </div>
                <div id="top-action">
                    <button class="btn btn-outline-primary btn-md float-right open-modal mt-3" data-modal="common-modal-sm"
                        data-action="{{route('item.user-item-setup-popup')}}" data-title=" Add Item To User"><i
                            class="fa fa-plus"></i> Add New Item To User</button>
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
                                    <th class="text-center" scope="col">Sl#</th>
                                    <th class="text-center" scope="col">User</th>
                                    <th class="text-center" scope="col">Department</th>
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
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>

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
				"url": "{{ url('item/user-item-setup-list') }}",
				"dataType": "json",
				"type": "get",
				"data":{ _token: "{{csrf_token()}}"}
			},
			"columnDefs": [{
				"targets": -1,
				"data": "Edit",
				"render": function ( data, type, row, meta ) {

					var edit_action = '{{ route("room.edit-user-room-setup", ":id") }}';
					edit_action = edit_action.replace(':id', row[3]);

					return '<span Class="btn btn-sm btn-primary open-modal" data-id="'+ row[3] +'" data-action="'+edit_action+'" data-modal="common-modal-sm" data-title="Edit Room To User" title="Edit"><i class="fa fa-pencil-alt"></i></span>';
				}
			}]
		});
	});

</script>
