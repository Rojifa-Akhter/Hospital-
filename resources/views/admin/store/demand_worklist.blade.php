<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
<style>
	.custom-box{
		background-color: #ffffff;
		margin-top: 15px;
		border-top: 1px solid #009bff;
		border-left: 1px solid #009bff;
		border-right: 1px solid #009bff;
		border-bottom: 1px solid #009bff;
		padding: 10px;
		border-radius: 10px;
		-webkit-box-shadow: 0px 5px 10px -6px rgba(0,0,0,0.66);
		-moz-box-shadow: 0px 5px 10px -6px rgba(0,0,0,0.66);
		box-shadow: 0px 5px 10px -6px rgba(0,0,0,0.66);
	}

	.custom-box-header{
		background-color: #009bff;
		padding: 5px 10px 5px 10px;
		border-radius: 5px 5px 0px 0px;
	}

	.custom-box-header h3{
		color: #fff;
		font-size: 16px;
		margin: 0;
	}

	.custom-box-body{
		margin-top: 10px;
		background-color: #ffffff;
		border-radius: 0px 0px 5px 5px;
	}


	select.form-control {
		padding: 0 0.75rem !important;
	}

	.form-control:focus {
		box-shadow: 0 0 0 0.2rem rgb(52 144 220 / 0%);
	}

	.custom-form{
		color: #495057;
		background-color: #fff;
		border-color: #d1d1d1;
		outline: 0;
		box-shadow: 0 0 0 0.2rem rgb(52 144 220 / 0%);
		padding: .45rem .75rem !important;
		height: calc(1.3em + 0.75rem + 2px) !important;
	}

	.custom-form:hover,
	.custom-form:focus{
		border-color: #009bff85;
	}


	.select2-container .select2-selection--single {
		height: 33px;
	}

	.select2-container--default .select2-selection--single .select2-selection__arrow {
		height: 33px;
	}

	.select2-container--default .select2-selection--single .select2-selection__rendered {
		line-height: 33px;
	}

	.input-group-text {
		padding: 0.95rem 0.7rem;
	}

	.tab-content {
		padding: 0px 10px 10px 10px;
	}

	@media (min-width: 1600px) {
		.input-group-text {
			padding: 0.95rem 0.7rem;
		}
	}

	@media (max-width: 1400px) {
		.form-control {
			padding: .45rem .75rem !important;
			height: calc(1.5em + 0.75rem + 2px) !important;
		}
	}

</style>

<div class="container-fluid">
	<div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
		<div class="col-md-10">
			<h5 class="mt-2 mb-0">Demand Work List</h5>
			<small>Store / Demand Work List</small>
            {{--<a href="{{ route('demand_entry') }}" rel="tab"  class="fa-pull-right btn btn-success btn-md ml-auto mb-1 mt-1"> <i class="fas fa-plus"> </i>&nbsp;&nbsp;New Demand Entry</a>--}}
		</div>
		<div class="col-md-2">
			<div id="top-action">

				<a rel="tab"  href="{{ route('demand_entry') }}" class="btn btn-outline-primary btn-md float-right" ><i class="fa fa-desktop"></i>&nbsp;New Demand Entry</a>

			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="row">
				<div class="col-12">
					<div class="custom-box">
						<div class="custom-box-header">
							<h3>Demand Work List</h3>
						</div>

						<div class="custom-box-body">
							<div class="row">
								<div class="col-12 table-responsive mt-3" >
									<table class="table data-table table-striped table-bordered table-hover">
										<thead class="bg-primary">
											<tr>
												<th class="text-center">SL</th>
												<th class="text-center">Demand UID</th>
												<th class="text-center">Fiscal Year</th>
												<th class="text-center">Item Category</th>
												<th class="text-center">No Of Item</th>
												<th class="text-center">Finalized By</th>
												<th class="text-center">Finalized Date</th>
												<th class="text-center">Submitted By</th>
												<th class="text-center">Submitted Date</th>
												<th class="text-center">Status</th>
												<th class="text-center">Action</th>
											</tr>
										</thead>
										<tbody>
										@if(!empty($demand_work_list))
											@foreach($demand_work_list as $dwl)
												<tr>
													<td class="text-center">{{ $loop->iteration }}</td>
													<td class="text-center">{{ $dwl->demand_uid }}</td>
													<td class="text-center">{{ $dwl->fiscal_year }}</td>
													<td class="text-center">{{ $dwl->item_category_mst }}</td>
													<td class="text-center">{{ $dwl->no_of_item }}</td>
													<td class="text-center">{{ $dwl->name_finalized_by }}</td>
													<td class="text-center">{{ $dwl->finalized_at }}</td>
													<td class="text-left">{{ $dwl->name_submit_by }}</td>
													<td class="text-left">{{ $dwl->submit_at }}</td>
													<td class="text-left">
														<span class="badge btn-success">{{ $dwl->demand_status_text }}</span>
													</td>
													<td class="text-center">
														<a rel="tab" href="{{ route('edit_demand_worklist', ['demand_uid' => $dwl->demand_uid]) }}" class="btn btn-sm btn-success" title="Edit"><i class="fas fa-edit"></i></a>
														<a href="{{ route('view_demand_worklist', ['demand_uid' => $dwl->demand_uid]) }}" class="btn btn-sm btn-info" title="View"><i class="fas fa-eye"></i></a>
														<a href="#" class="btn btn-sm btn-warning" title="Print"><i class="fas fa-print"></i></a>
													</td>
												</tr>
											@endforeach

										@endif

										</tbody>
									</table>
								</div>
							</div>

							{{--<div class="row justify-content-start">
								<div class="col-3">
									<div class="btn-group btn-block" role="group">
										<button type="button" class="btn btn-md btn-success">Save</button>
										<button type="button" class="btn btn-md btn-info">Finalize</button>
										<button type="button" class="btn btn-md btn-warning">Print</button>
									</div>
								</div>
							</div>--}}

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
		$('.data-table').DataTable({
			"ordering": false,
			"bPaginate": false,
			"bLengthChange": false,
			"bAutoWidth": false
		});
	})
</script>
