<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<section id="delivery_mens">
	<div class="container-fluid">
		<div class="row bg-white border-bottom sticky-top shadow-sm">
			<div class="col-md-12 mb-1">
				<h5 class="mt-2 mb-0">Delivery Man List</h5>
				<small>Settings / Delivery / Delivery Man List</small>
			</div>
		</div>
		<div class="card">
			<div class="card-header"><h5>Delivery Man List</h5></div>

			<div class="card-body">
				<div class="row mt-2">
					<div class="col-md-12 table-responsive">
						<table id="datatable" class="table table-bordered table-hover table-striped data-table-delivery-man-list">
							<thead class="bg-primary">
								<tr>
									<th class="text-center" scope="col">Sl#</th>
									<th class="text-center" scope="col">Id</th>
									<th class="text-left" scope="col">Name</th>
									<th class="text-left" scope="col">Mobile No</th>
									<th class="text-center" scope="col">Status</th>
									<th class="text-center" scope="col">Action</th>
								</tr>
							</thead>
							<tbody>

								@if(!empty($delivery_mans))
								@foreach( $delivery_mans as $data)
								<tr>
									<td>{{ $loop->iteration }}</td>
									<td>{{ucfirst(strtolower($data->person_code))}}</td>
									<td>{{ucfirst(strtolower($data->full_name))}}</td>
									<td>{{ucfirst(strtolower($data->phone_mobile))}}</td>
									<td>{{$data->status == 1 ? 'Active' : 'Inactive'}}</td>
									<td><span Class="btn btn-sm btn-primary open-modal" data-id="{{ $data->person_no_pk }}" data-action="{{ route('doctor.edit',$data->person_no_pk) }}" data-modal="common-modal" data-title="Edit Employee Information" title="Edit Employee Information"><i class="fa fa-pencil-alt"></i></span></td>

								</tr>
								@endforeach
								@endif
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
		var datatable = $('.data-table-delivery-man-list').DataTable();

	});
</script>
