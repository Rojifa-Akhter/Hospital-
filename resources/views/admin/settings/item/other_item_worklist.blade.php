<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<div class="container-fluid">
	<div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm align-items-center">
		<div class="col-md-6">
			<h5 class="mt-2 mb-0">Other Item Worklist</h5>
			<small>Item Worklist / Other Item Worklist</small>
		</div>
		<div class="col-md-6">
			<div class="m-0 text-right" id="top-action">
				<a rel="tab"  href="{{ route('item.other-item-setup') }}" class="btn btn-outline-primary btn-md float-right" ><i class="fa fa-desktop"></i>&nbsp;Other Item Setup</a>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="card" id="">
				<div class="card-header"><h5>Other Item Worklist</h5></div>
				<div class="card-body mt-3">
					<div class="row">
						<div class="col-12 table-responsive" >
							<table class="table table-bordered table-hover data-table table-striped m-0 border">
								<thead class="bg-primary">
									<tr>
										<th class="text-center">SL</th>
										<th class="text-center">Item No./Barcode</th>
										<th class="text-left">Item Name</th>
										<th class="text-center">Department</th>
										{{-- <th class="text-center">AFMSD Category</th> --}}
										<th class="text-center">UOM Name</th>
										{{-- <th class="text-center">Item Map type</th> --}}
										<th class="text-center">Demand Flag</th>
										<th class="text-center">Expirable</th>
										<th class="text-left">Status</th>
										<th class="text-center">Action</th>
									</tr>
								</thead>
								<tbody>
									@if(!empty($data))
									@foreach($data as $otherItem)
									<tr>
										<td class="text-center">{{$loop->iteration}}</td>
										<td class="text-center">{{$otherItem->item_code}}</td>
										<td class="text-left">{{$otherItem->item_name}}</td>
										<td class="text-center">{{$otherItem->serviceunit_name}}</td>

										<td class="text-center">{{$otherItem->uom_name}}</td>
										{{-- <td class="text-center"></td> --}}
										{{-- <td class="text-center"></td> --}}
										<td class="text-center"><span class="badge bg-success text-white">{{!empty($otherItem->dk_current_ind)?'Active' : ''}}</span></td>
										<td class="text-center"><span class="badge bg-success text-white">{{!empty($otherItem->expireable)?'Active' : ''}}</span></td>
										<td class="text-left"><span class="badge bg-success text-white">{{!empty($otherItem->active_stat)?'Active' : ''}}</span></td>

										<td width="70px"><span Class="btn btn-sm btn-primary open-modal" data-id="" data-action="{{ route("item.other-item-edit", $otherItem->item_no_pk)}}" data-modal="common-modal-md" data-title="Edit Other Item" title="Edit"><i class="fa fa-pencil-alt"></i>
										</span>
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
	</div>
</div>
</div>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script>
	$(".data-table").DataTable({
		"lengthMenu": [
            [50],
            [50]
        ]
	});
</script>
