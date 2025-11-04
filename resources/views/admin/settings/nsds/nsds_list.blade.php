<link href="{{ asset('datatables/media/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<section id="full_lookup_list">
	<div class="container-fluid">
		<div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
			<div class="col-md-12">
				<div class="float-left">
					<h5 class="mt-2 mb-0">Nurse & Doctor Station List</h5>
					<small>Settings / NSDS setup / NSDS List</small>
				</div>
				<div id="top-action">
					<button class="btn btn-outline-primary btn-md float-right open-modal" data-modal="common-modal-sm" data-action="{{ route('nsds.create') }}" data-title="Create New Nusrse Station or Doctor Station"><i class="fa fa-plus"></i>New Nusrse or Doctor Station</button>
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
                                    <th class="text-center" scope="col">NSDS Name</th>
                                    <th class="text-center" scope="col">NSDS Code</th>
									<th class="text-center" scope="col">Room Name</th>
									<th class="text-center" scope="col">Room Category</th>
                                    <th class="text-center" scope="col">Room Serv Unit</th>
									<th class="text-center" scope="col">User Name</th>
									<th class="text-center" scope="col">NS type</th>
									<th class="text-center" scope="col">NS Indicator</th>
									<th class="text-center" scope="col">DS Indicator</th>
									<th class="text-center" scope="col">Department</th>
									<th class="text-center" scope="col">Status</th>


									<th class="text-center width-100" scope="col">Actions</th>
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
<script type="application/javascript" src="{{ asset('datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script>
	$(document).ready(function () {
		var datatable = $('.data-table').DataTable({
			"ordering": false,
			"language": {
				"infoFiltered": ""
			},
			"processing": true,
			"serverSide": true,
            "order": [[ 1, "desc" ]],
			"ajax":{
				"url": "{{ url('nsds/nsds-setup-list') }}",
				"dataType": "json",
				"type": "POST",
				"data":{ _token: "{{csrf_token()}}"}
			},
			"columnDefs": [{
				"targets": -1,
				"data": "Edit",
				"render": function ( data, type, row, meta ) {

					var edit_action = '{{ route("nsds.edit-nsds-setup", ":id") }}';
					edit_action = edit_action.replace(':id', row[12]);

					return '<span Class="btn btn-sm btn-primary open-modal" data-id="'+ row[12] +'" data-action="'+edit_action+'" data-modal="common-modal-sm" data-title="Edit Nurse or Doctor Station" title="Edit"><i class="fa fa-pencil-alt"></i></span>';
				}
			}]
		});
	});
</script>
