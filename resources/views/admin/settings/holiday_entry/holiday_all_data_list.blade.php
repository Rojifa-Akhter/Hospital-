<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<section id="full_lookup_list">
	<div class="container-fluid">

		<div class="card">

			<div class="card-body">
				<div class="row mt-2">
				    <div class="col-md-12 table-responsive">
				        <table id="datatable" class="table table-bordered table-hover table-striped data-table">
	                        <thead class="bg-primary">
	                            <tr>
	                                <th class="text-center col-md-1" scope="col">Sl#</th>
	                                <th class="text-center col-md-4" scope="col">Name</th>

	                                <th class="text-center col-md-3" scope="col">Date</th>
	                                <th class="text-center col-md-2" scope="col">Year</th>
	                                <!-- <th class="text-center" scope="col">Holiday</th> -->
	                                <!-- <th class="text-center" scope="col">Total Holiday</th> -->
	                                <!-- <th class="text-center" scope="col">Total Friday</th> -->
	                                <!-- <th class="text-center" scope="col">Friday</th> -->
	                                <th class="text-center width-150 col-md-2" scope="col">Actions</th>
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
			"order": [
                    [4, "desc"]
                ],
			"ajax":{
				"url": "{{ url('holiday_entry_list') }}",
				"dataType": "json",
				"type": "POST",
				"data":{ _token: "{{csrf_token()}}"}
			},
			
			"columnDefs": [
			{
				"targets": 0, // First column — for serial numbers
				"orderable": false,
				"searchable": false,
				"render": function (data, type, row, meta) {
					return meta.row + meta.settings._iDisplayStart + 1;
				}
			},
				
			{
				"targets": -1,
				"data": "Edit",
				"render": function ( data, type, row, meta ) {

					// var create_action = '{{ route("lookup.create") }}';
					// create_action = create_action.replace(':id', row[0]);

					var edit_action = '{{ route("holiday.edit-list", ":id") }}';
					edit_action = edit_action.replace(':id', row[4]);
					// var delete_action = '{{ route("lookup.destroy", ":id") }}';
					// delete_action = delete_action.replace(':id', row[0]);

					return '<span Class="btn btn-sm btn-primary open-modal" data-id="'+ row[4] +'" data-action="'+edit_action+'" data-modal="common-modal-md" data-title="Edit Holiday Entry" title="Edit"><i class="fa fa-pencil-alt"></i></span>';
				}
			}]
		});
	});
</script>
