<div class="card-body mt-3">
	<div class="row">
		<div class="col-12 table-responsive" >
			<table class="table data-table table-striped table-bordered table-hover">
				<thead class="bg-primary">
				<tr>
					<th class="text-center">SL</th>
					<th class="text-center">Challan Date</th>
					<th class="text-center">Challan No</th>
					<th class="text-center">Fiscal Year </th>
					<th class="text-center">Quarter</th>
					<th class="text-center">No of Item</th>
					<th class="text-center">Received Item</th>
					<th class="text-center">Status</th>
					<th class="text-center">Action</th>
				</tr>
				</thead>

				<tbody>
				@if(!empty($recieves))
					@foreach($recieves as $rbc)
						@php
						$badgeStatus = '';
						switch($rbc->receive_status_text){
						case "Partial Received":
						$badgeStatus = 'badge-primary';
						break;
						case "Received":
						$badgeStatus = 'badge-success';
						break;
						case "Closed":
						$badgeStatus = 'badge-danger';
						break;
						default:
						$badgeStatus = 'badge-warning';
						}

						@endphp
						<tr>
							<td class="text-center">{{ $loop->iteration }}</td>
							<td class="text-left">{{ !empty($rbc->challan_date)? date('d/m/Y', strtotime($rbc->challan_date)): '' }}</td>
							<td class="text-left"> {{ $rbc->challan_no ?: ''}}</td>
							<td class="text-center"> {{ $rbc->fiscal_year ?: ''}}</td>
							<td class="text-left"> Quarter-{{ $rbc->year_quarter ?: ''}}</td>
							<td class="text-right"> {{ $rbc->no_of_item ?: ''}}</td>
							<td class="text-right"> {{ $rbc->sum_received_item_qty ?: ''}}</td>
							<td class="text-center"> <span class="badge {{ $badgeStatus }}">{{ $rbc->receive_status_text ?: ''}}</span></td>
							<td class="text-center">
								<a href="#" class="btn btn-sm btn-info" title="Details"><i class="fas fa-book-open"></i></a>
								<a href="#" class="btn btn-sm btn-success" title="Edit"><i class="fas fa-edit"></i></a>
							</td>
						</tr>
					@endforeach
				@endif
				</tbody>
			</table>
		</div>
	</div>
</div>