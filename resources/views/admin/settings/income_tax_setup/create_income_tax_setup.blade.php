<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<section id="create_pres_favourite">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">Income Tax Setup</h5>
                <small>Settings / Income Tax Setup / Create Income Tax Setup</small>
            </div>
        </div>
        <div class="card">
            <div class="card-header"><h5>Create Income Tax Setup</h5></div>
            <div class="card-body mt-2">
                @include('admin.settings.income_tax_setup.create_income_tax_setup_form')
            </div>
        </div>
    </div>
</section>
{{-- <link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.min.css') }}" rel="stylesheet"> --}}
<section id="full_lookup_list">
	<div class="container-fluid">
		<div class="row bg-white border-bottom sticky-top shadow-sm">
			<div class="col-md-12 mb-1">
				<h5 class="mt-2 mb-0">Income Tax List</h5>
				<small>Settings / Income Tax / Income Tax List</small>
			</div>
		</div>
		<div class="card">
			<div class="card-header"><h5>Income Tax List <button class="btn btn-sm btn-primary float-right open-modal" data-modal="common-modal-sm" data-action="{{ route('delivery-charge-form') }}" data-title="Create Delivery Charge">Create Delivery Charge</button></h5></div>

			<div class="card-body">
				<div class="row mt-2">
					<div class="col-md-12 table-responsive">
						<table id="datatable" class="table table-bordered table-hover table-striped data-table">
							<thead class="bg-primary">
								<tr>
									<th class="text-center" scope="col">Sl#</th>
									<th class="text-left" scope="col">Tax Description</th>
									<th class="text-left" scope="col">Tax Fee amount(max)</th>
                                    <th class="text-left" scope="col">Min tax (%)</th>
									<th class="text-left" scope="col">Remaining next 1 Lac</th>
                                    <th class="text-left" scope="col">Remaining next 1 Lac percent</th>
									<th class="text-left" scope="col">Remaining next 3 Lac</th>
                                    <th class="text-left" scope="col">Remaining next 3 Lac percent</th>
									<th class="text-left" scope="col">Remaining next 4 Lac</th>
                                    <th class="text-left" scope="col">Remaining next 4 Lac percent</th>
									<th class="text-left" scope="col">Remaining next 5 Lac</th>
                                    <th class="text-left" scope="col">Remaining next 5 Lac percent</th>
									<th class="text-left" scope="col">Remaining next everything</th>
									<th class="text-left" scope="col">Default</th>

									<th class="text-center width-150">Action</th>
								</tr>
							</thead>
							<tbody>

								@if(isset($income_setup_info))
								@foreach( $income_setup_info as $data)

								<tr>
									<td>{{ $loop->iteration }}</td>
									<td>{{$data->tax_description}}</td>
									<td>{{$data->tax_fee_amount}}</td>
                                    <td>{{$data->min_tax_percent}}</td>
									<td>{{$data->rem_next_one_lac}}</td>
                                    <td>{{$data->rem_next_one_lac_percent}}</td>
									<td>{{$data->rem_next_three_lac}}</td>
                                    <td>{{$data->rem_next_three_lac_percent}}</td>
									<td>{{$data->rem_next_four_lac}}</td>
                                    <td>{{$data->rem_next_four_lac_percent}}</td>
									<td>{{$data->rem_next_five_lac}}</td>
                                    <td>{{$data->rem_next_five_lac_percent}}</td>
									<td>{{$data->rem_next_everything_percent}}</td>
                                    <td>{{$data->default_ind ==1 ? "active":"Inactive"}}</td>
									<td><span class="btn btn-sm btn-primary open-modal edit_btn" data-id="{{$data->income_tax_setup_no_pk}}" data-action="{{route('income-tax-setup.edit',$data->income_tax_setup_no_pk)}}" data-modal="common-modal-md" data-title="Edit Income Tax Setup" title="Edit"><i class="fa fa-pencil-alt"></i></span></td>

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
		var datatable = $('.data-table').DataTable();
      $('.edit_btn').on('click',function()
      {
        $("form").prop('id','income_tax_setup_edit');

      });

	});

</script>


