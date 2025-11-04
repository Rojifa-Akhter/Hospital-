<div class="card-body mt-3">
	<div class="row">
		<div class="col-12 table-responsive" >
			<table class="table data-table table-striped table-bordered table-hover">
				<thead class="bg-primary">
				<tr>
					<th class="text-center">SL</th>
					<th class="text-center">Challan Date</th>
					<th class="text-center">Challan No</th>
					<th class="text-center">PVMS</th>
					<th class="text-center">Item Name</th>
					<th class="text-center">A/U</th>
					<th class="text-center">Received Quantity</th>
					<th class="text-center">Status</th>
					<th class="text-center">Action</th>
				</tr>
				</thead>
				<tbody>
				@if(!empty($recieves))
					@foreach($recieves as $rbi)
						@php
						$badgeStatus = '';
						switch($rbi->receive_status_text){
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
							<td>{{ !empty($rbi->challan_date)? date('d/m/Y', strtotime($rbi->challan_date)): 'N/A' }}</td>
							<td class="text-left">{{ $rbi->challan_no ?: 'N/A' }}</td>
							<td class="text-left">{{ $rbi->pvms_no ?: 'N/A' }}</td>
							<td class="text-left">{{ $rbi->item_name ?: 'N/A'}}</td>
							<td class="text-left">{{ $rbi->uom_short ?: 'N/A'}}</td>
							<td class="text-right">{{ $rbi->received_quantity ?: 'N/A'}}</td>
							<td class="text-center"><span class="badge {{ $badgeStatus }}">{{ $rbi->receive_status_text ?: 'N/A'}}</span> </td>
							<td class="text-center">
								<a href="#" class="btn btn-sm btn-info" title="Details"><i class="fas fa-book-open"></i></a>
							</td>
						</tr>
					@endforeach
				@endif
				</tbody>
			</table>
		</div>
	</div>
</div>