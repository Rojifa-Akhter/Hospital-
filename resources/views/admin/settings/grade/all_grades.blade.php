<style>
    tr td {
        white-space: nowrap;
    }
</style>
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<section id="full_lookup_list">
	<div class="container-fluid">
		<div class="row bg-white border-bottom sticky-top shadow-sm">
			<div class="col-md-12 mb-1">
				<h5 class="mt-2 mb-0"> Grade List</h5>
				<small>Settings / Grade / Grade List</small>
			</div>
		</div>
		<div class="card">
			{{-- <div class="card-header"><h5>  Grade  List
				<!-- <button class="btn btn-sm btn-primary float-right open-modal" data-modal="common-modal-sm" data-action="{{route('grade.create-form')}}" data-title="Create New Salary Grade">Add New Grade</button> -->
			</h5></div> --}}

			<div class="card-body">
				<div class="row mt-2">
					<div class="col-md-12 table-responsive">
						<table id="datatable" class="table table-bordered table-hover table-striped data-table">
							<thead class="bg-primary">
								<tr>
									<th class="text-center" scope="col">Sl#</th>
									<th class="text-left" scope="col">Grade</th>
									<th class="text-center" scope="col">Grade Factor</th>
									<th class="text-center" scope="col">Gross Salary</th>
									<th class="text-center" scope="col">Basic Salary</th>
									<th class="text-center" scope="col">Basic Salary(%)</th>
									<th class="text-center" scope="col">House Rent</th>
									<th class="text-center" scope="col">House Rent(%)</th>
									<th class="text-center" scope="col">Medical Allowance</th>
									<th class="text-center" scope="col">Medical Allowance(%)</th>
									<th class="text-center" scope="col">Conveyance Allowance</th>
									<th class="text-center" scope="col">Conveyance Allowance(%)</th>
									<th class="text-center" scope="col">Utility </th>
									<th class="text-center" scope="col">Utility(%)</th>
									<th class="text-center" scope="col">Entertainment</th>
									<th class="text-center" scope="col">Entertainment(%)</th>
									<th class="text-center" scope="col">Festival Bonus</th>
									<th class="text-center" scope="col">Festival Bonus(%)</th>
									<th class="text-center" scope="col">TA/DA</th>
									<th class="text-center" scope="col">TA/DA(%)</th>
									<th class="text-center" scope="col">Attendence Bonus</th>
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
			"processing": true,
			"serverSide": true,
			"ajax":{
				"url": "{{ url('grade-list') }}",
				"dataType": "json",
				"type": "POST",
				"data":{ _token: "{{csrf_token()}}"}
			},
			"columnDefs": [{
				"targets": -1,
				"data": "Edit",
				"render": function ( data, type, row, meta ) {
					var edit_action = '{{ route("grade.edit-list", ":id") }}';
					edit_action = edit_action.replace(':id', row[21]);
					return '<span Class="btn btn-sm btn-primary open-modal" data-id="'+ row[21] +'" data-action="'+edit_action+'" data-modal="common-modal-md" data-title="Edit Grade" title="Edit"><i class="fa fa-pencil-alt"></i></span>';
				}
			}]
		});
	});
</script>
