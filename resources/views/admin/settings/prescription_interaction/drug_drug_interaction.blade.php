<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<style type="text/css">
    th{
        text-align: center;
    }
</style>
<div class="container-fluid">
	<div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm align-items-center justify-content-between">
		<div class="col-md-6">
			<h5 class="mt-2 mb-0">Drug-Drug Interaction</h5>
			<small>Prescription Interaction / Drug-Drug Interaction</small>
		</div>
		<div class="col-md-6 text-right">
			<div id="top-action" class="m-0">
				<button class="btn btn-outline-primary btn-md open-modal" data-modal="common-modal-sm" data-action="{{ route('Prescription-Interaction.drug-drug-interaction-form') }}" data-title="Drug-Drug Interaction Setup" title="Drug-Drug Interaction Setup"><i class="fa fa-plus"></i> Add New Drug Interaction</button>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-12">
			<div class="card" id="">
				<div class="card-header"><h5>Drug-Drug Interaction</h5></div>
				<div class="card-body mt-3">
					<div class="row">
						<div class="col-12 table-responsive" >
                            <table id="datatable" class="table table-bordered table-hover table-striped data-table">
								<thead class="bg-primary">
									<tr>
										<th class="text-center">SL</th>
										<th class="text-left">Drug Name</th>
										<th class="text-left">Interact Drug Name</th>
										<th class="text-left">Interact Alert Message</th>
										<th class="text-left">Severity</th>
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

            "processing": true,
            "serverSide": true,
            "ajax":{
                "url": "{{ url('prescription-interaction/drug-drug-interaction-all-data') }}",
                "dataType": "json",
                "type": "POST",
                "data":{ _token: "{{csrf_token()}}"}
            },
            "columnDefs": [{
                "targets": -1,
                "data": "Edit",
                "render": function ( data, type, row, meta ) {
                    var edit_action = '{{ route("prescription-interaction.drug-drug-interaction.edit", ":id") }}';
                    edit_action = edit_action.replace(':id', row[5]);

                    return '<span Class="btn btn-sm btn-primary open-modal" data-id="'+ row[5] +'" data-action="'+edit_action+'" data-modal="common-modal-sm" data-title="Edit drug drug interaction" title="Edit"><i class="fa fa-pencil-alt"></i></span>';
                }
            }]
        });
    });
</script>
