
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">


<div class="card">
	<div class="card-body">
		<div class="row mt-2">
			<div class="col-md-12 table-responsive">
				<table id="datatable" class="data-table table table-bordered table-hover table-striped">
					<thead class="bg-primary">
						<tr>
							<th class="text-center" >Sl#</th>
							<th class="text-center" >Effective Date</th>
							<th class="text-center" >Card No</th>
							<th class="text-center" >Bonus Name</th>
							<th class="text-center" >Bonus Percent</th>
							<th class="text-center" >Bonus Value</th>
							<th class="text-center" >Status</th>
							<th class="text-center" >Actions</th>
						</tr>

					</thead>
					<tbody>

						@if(!empty($json_data))

						@foreach($json_data as $row)
						<tr>
							<td class="text-center" scope="col">{{ $loop->iteration }}</td>
							<td class="text-left" scope="col">{{date("d/m/Y",strtotime($row->effective_date))}}
							</td>
                            <td class="text-left" scope="col">{{ $row->person_card_no }}</td>
							<td class="text-left" scope="col">{{ $row->bonus_name }}</td>
							<td class="text-left" scope="col">{{ $row->value_percent }}</td>
							<td class="text-left" scope="col">{{ $row->value_amount }}</td>

							<td class="text-left" scope="col" >
                                @if($row->status == 1){{'Active'}} @else{{'Inactive'}}@endif
                            </td>
							<td class="text-Center" scope="col">
								<span class="badge badge-md badge-warning p-1 mb-1 cursor-pointer" data-id="" data-action="{{url('hrm/salary-bonus-edit', $row->bonus_no_pk)}}" data-title="Edit Referral Policy" onclick="editBonusSalary(this)" title="Edit"><i class="fa fa-pencil-alt"></i>Edit</span>
							</td>


						</tr>
						@endforeach
						@endif
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>

<script>


    $(".data-table").DataTable({
        "ordering": false,
        "bPaginate": false,
        "bLengthChange": false,
        "bAutoWidth": false
    });
</script>

