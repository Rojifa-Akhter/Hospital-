<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<section id="full_lookup_list">
	<div class="container-fluid">
		<div class="card">
			<div class="card-header"><h5>Policy List</h5></div>

			<div class="card-body">
				<div class="row mt-2">
					<div class="col-md-12 table-responsive">
						<table id="datatable" class="table table-bordered table-hover table-striped data-table">
							<thead class="bg-primary">
								<tr>
									<th class="text-center" scope="col">Sl#</th>
									<th class="text-left" scope="col">Policy Code</th>
									<th class="text-center" scope="col">Policy Desc</th>
									<th class="text-center" scope="col">Apply To</th>
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
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script>
	$(document).ready(function () {
		var datatable = $('.data-table').DataTable({
			"processing": true,
			"serverSide": true,
			"ajax":{
				"url": "{{ route('policy.policy-list') }}",
				"dataType": "json",
				"type": "POST",
				"data":{ _token: "{{csrf_token()}}"}
			},
			"columnDefs": [{
				"targets": -1,
				"data": "Edit",
				"render": function ( data, type, row, meta ) {
					var action = '{{ route("policy.comission", ":id") }}';
					action = action.replace(':id', row[0]);

					return '<a class="btn btn-sm btn-primary" href="'+action+'" rel="tab" role="tab" aria-controls="nav-home" aria-selected="true">Commission Setup</a>';
				}
			}]
		});
	});
</script>
