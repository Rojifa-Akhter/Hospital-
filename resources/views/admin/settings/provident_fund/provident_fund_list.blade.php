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
	                                <th class="text-center" scope="col">Sl#</th>
	                                <th class="text-center" scope="col">Pf-Bank Name</th>
	                                <th class="text-center" scope="col">Pf-Ammount type</th>
	                                <th class="text-center" scope="col">Bank Account</th>
	                                <th class="text-center" scope="col">Loan percent</th>
	                                <th class="text-center" scope="col">Value Amount</th>
	                                <th class="text-center" scope="col">Value Percent</th>
	                                <th class="text-center" scope="col">Effective Date</th>
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
				"url": "{{ url('provident_fund_list') }}",
				"dataType": "json",
				"type": "POST",
				"data":{ _token: "{{csrf_token()}}"}
			},
			"columnDefs": [{
				"targets": -1,
				"data": "Edit",
				"render": function ( data, type, row, meta ) {

					// var create_action = '{{ route("lookup.create") }}';
					// create_action = create_action.replace(':id', row[0]);

					var edit_action = '{{ route("provident-fund.edit-list", ":id") }}';
					edit_action = edit_action.replace(':id', row[7]);
					// var delete_action = '{{ route("lookup.destroy", ":id") }}';
					// delete_action = delete_action.replace(':id', row[0]);

					return '<span Class="btn btn-sm btn-primary open-modal" data-id="'+ row[7] +'" data-action="'+edit_action+'" data-modal="common-modal-md" data-title="Edit provident-fund list" title="Edit"><i class="fa fa-pencil-alt"></i></span>';
				}
			}]
		});
	});
</script>

