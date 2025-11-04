<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<section id="full_appointment">
<div class="container-fluid">
<div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm align-items-center">
			<div class="col-md-12 mb-1">
				<h5 class="mt-2 mb-0"> Machine Data</h5>
				<small> HRM / Machine Data</small>
			</div>
		</div>
    <div class="form-group form-row">
		<div class="col-md-12">
		<div class="col-md-6">


		<div class="card">
			<div class="card-header ">
				<h5> Search</h5>
			</div>

			<div class="card-body">
				<div class="row mt-2">
					<div class="col-md-12 table-responsive">
						<form method="post" id="frm-pat-registration" action="{{ route('user.store') }}" data-response-action="">
							@csrf
							<div class="form-group  form-row">
								<input type="hidden" name="id" value="">
								<label for="user_expire_date" class=" col-form-label col-form-label-sm ">Date</label>
								<div class=" col-md-3">
									<input type="text" class="form-control form-control-sm date_picker" id="date_pic" name="date_pic" value="" placeholder="YYYY/DD/MM">
									<span class="focus_input"></span>
								</div>
								<label for="card_no" class=" col-form-label col-form-label-sm ">Card No</label>
								<div class=" col-md-3 ">
									<input type="text" class="form-control form-control-sm " id="card_no" name="card_no" value="" placeholder="Cord no">

								</div>


								<div class="col-md-1">

								<button type="submit" class="btn btn-md btn-success " onclick="">Search</button>
								</div>

							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="col-md-12" >
<div class="col-md-6">
		<div class="row bg-white border-bottom sticky-top shadow-sm">

		</div>
		<div class="card">
			<div class="card-header ">
				<h5> Machine Data </h5>
			</div>

			<div class="card-body">
				<div class="row mt-2">
					<div class="col-md-12 table-responsive">
						<table class="table data-table table-bordered table-hover table-striped">
							<thead class="bg-primary">
								<tr>
									<th class="text-center" scope="col">#SL</th>
									<th class="text-left" scope="col">Date</th>
									<th class="text-center" scope="col">Card No</th>
									<th class="text-center" scope="col"> Punch Time</th>
									<th class="text-center" scope="col">Action</th>
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

    </div>


</section>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script>
	$('.date_picker').datepicker({
		format: 'yyyy-mm-dd',
		autoclose: true,
		todayHighlight: true,
		clearBtn: true,
	});

	// $(document).ready(function () {
	// 	// $('.data-table').DataTable();

	// 	var datatable = $('.data-table').DataTable({
	// 		"processing": "<i class='fas fa-stroopwafel fa-spin'></i>",
	// 		"serverSide": true,
	// 		"ajax":{
	// 			"url": "{{ url('user-list') }}",
	// 			"dataType": "json",
	// 			"type": "POST",
	// 			"data":{ _token: "{{csrf_token()}}"}
	// 		},
	// 		"columnDefs": [{
	// 			"targets": -1,
	// 			"data": "Edit",
	// 			"render": function ( data, type, row, meta ) {

	// 				var edit_action = '{{ route("user.edit", ":id") }}';
	// 				edit_action = edit_action.replace(':id', row[6]);

	// 				return '<span href="#" Class="btn btn-sm btn-primary open-modal" data-id="'+ row[6] +'" data-action="'+edit_action+'" data-modal="common-modal" data-title="Edit User Information" title="Edit User Information"><i class="fa fa-pencil-alt"></i></span>&nbsp;<span href="#" data-id="'+ row[5] +'" Class="btn btn-sm btn-success" title="Card"><i class="fa fa-address-card "></i></span>';
	// 			}
	// 		}]
	// 	});

	// });
</script>
