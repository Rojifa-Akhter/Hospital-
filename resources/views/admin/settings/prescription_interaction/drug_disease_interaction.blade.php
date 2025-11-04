<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<div class="container-fluid">
	<div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm align-items-center justify-content-between">
		<div class="col-md-6">
			<h5 class="mt-2 mb-0">Drug-Disease Interaction</h5>
			<small>Prescription Interaction / Drug-Disease Interaction</small>
		</div>
		<div class="col-md-6 text-right">
			<div id="top-action" class="m-0">
			<button class="btn btn-outline-primary btn-md open-modal" data-modal="common-modal-sm" data-action="{{ route('Prescription-Interaction.drug-disease-interaction-form') }}" data-title="Drug-Disease Interaction Setup" title="Drug-Disease Interaction Setup"><i class="fa fa-plus"></i> Add New Disease Interaction</button>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-12">
			<div class="card" id="">
				<div class="card-header"><h5>Drug-Disease Interaction</h5></div>
				<div class="card-body mt-3">
					<div class="row">
						<div class="col-12 table-responsive" >
							<table class="table datatable table-striped table-bordered table-hover mb-0 data-table">
								<thead class="bg-primary">
									<tr>
										<th class="text-center">SL</th>
										<th class="text-center">Drug UID</th>
										<th class="text-left">Drug Name</th>
										<th class="text-center">Interact Disease UID</th>
										<th class="text-left">Interact Disease Name</th>
										<th class="text-left">Severity</th>
										<th class="text-left">Interact Alert Message</th>
										<th class="text-center">Action</th>
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
				"url": "{{ url('Prescription-Interaction/drug-disease-interaction-list') }}",
				"dataType": "json",
				"type": "POST",
				"data":{ _token: "{{csrf_token()}}"}
			},
			"columnDefs": [{
				"targets": -1,
				"data": "Edit",
				"render": function ( data, type, row, meta ) {

					var edit_action = '{{ route("Prescription-Interaction.drug-disease-interaction-edit", ":id") }}';
					edit_action = edit_action.replace(':id', row[7]);

					return '<span Class="btn btn-sm btn-primary open-modal" data-id="'+ row[7] +'" data-action="'+edit_action+'" data-modal="common-modal-sm" data-title="Edit Drug disease Interaction" title="Edit"><i class="fa fa-pencil-alt"></i></span>';
				}
			}]
		});
	});
</script>
