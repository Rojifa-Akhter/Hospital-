<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<section id="full_lookup_list">
	<div class="container-fluid">
		 <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">Shift List</h5>
				<small>Settings / Shift  Setup / Shift List</small>
            </div>
        </div>
		<div class="card">
			<div class="card-header"><h5>Shift List <button class="btn btn-sm btn-primary float-right open-modal" data-modal="common-modal-sm" data-action="{{ route('shift.create_form') }}" data-title="Create New Shift">Create Shift</button></h5></div>

			<div class="card-body">
				<div class="row mt-2">
				    <div class="col-md-12 table-responsive">
				        <table id="datatable" class="table table-bordered table-hover table-striped data-table">
	                        <thead class="bg-primary">
	                            <tr>
	                                <th class="text-center" scope="col">Sl#</th>
	                                <th class="text-left" scope="col">Shift Code</th>
	                                <th class="text-center" scope="col">Start Time</th>
	                                <th class="text-center" scope="col">End Time</th>
	                                <th class="text-center" scope="col">Min In Time</th>
	                                <th class="text-center" scope="col">Max Out Time</th>
	                                <th class="text-center" scope="col">Grace In Time (Min)</th>
	                                <th class="text-center" scope="col">Grace Out Time (Min)</th>
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
            "ordering": false,
            "searching": true,
            "language": {
                "infoFiltered": ""
            },
            "processing": true,
            "serverSide": true,
			"ajax":{
				"url": "{{ url('shift-list') }}",
				"dataType": "json",
				"type": "POST",
				"data":{ _token: "{{csrf_token()}}"}
			},
			"columnDefs": [{
				"targets": -1,
				"data": "Edit",
				"render": function ( data, type, row, meta ) {

					// var create_action = '{{ route("shift.create") }}';
					// create_action = create_action.replace(':id', row[0]);

					var edit_action = '{{ route("shift.edit", ":id") }}';
					edit_action = edit_action.replace(':id', row[8]);

					// var delete_action = '{{ route("shift.destroy", ":id") }}';
					// delete_action = delete_action.replace(':id', row[0]);

					return '<span Class="btn btn-sm btn-primary open-modal" data-id="'+ row[8] +'" data-action="'+edit_action+'" data-modal="common-modal-sm" data-title="Edit Shift" title="Edit"><i class="fa fa-pencil-alt"></i></span>';
				}
			}]
		});
	});
</script>
