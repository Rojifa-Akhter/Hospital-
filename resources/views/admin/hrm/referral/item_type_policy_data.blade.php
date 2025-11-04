<div class="card">
	<div class="card-body">
		<div class="row mt-2">
			<div class="col-md-12 table-responsive">
				<table id="datatable" class="table table-bordered table-hover table-striped data-table">
					<thead class="bg-primary">
						<tr>
							<th class="text-center" scope="col">Sl#</th>
							<th class="text-center" scope="col">Item Type</th>
							<th class="text-center" scope="col">Comission</th>
							<th class="text-center" scope="col">Actions</th>
						</tr>
					</thead>
					<tbody>

						@if(!empty($ref_policy))
						@foreach($ref_policy as $sample_row)
						<tr>
							<td  class="border-0 text-center">  {{ $loop->iteration }}</td>
							<td  class="border-0 text-center">  {{ $sample_row->item_type }}</td>
							<td  class="border-0 text-center">  {{ $sample_row->commission_percent }}</td>

							<td class="border-0 text-center">
								<span class="badge badge-md badge-warning p-1 mb-1 cursor-pointer" onclick='editReferralItemWisePolicy(this)' data-id="" data-action="{{url('item-type-policy-edit', $sample_row->refpolicy_itemtype_no_pk)}}" data-title="Edit Item Wise Policy" title="Edit"><i class="fa fa-pencil-alt"></i>Edit</span>
							</td>
							</td>
						</tr>
						@endforeach
						@else
						<tr colspan='4'>
							<td>No Data Found</td>
						</tr>
						@endif
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>


<script type="text/javascript">
	function editReferralItemWisePolicy(element){
	var action = $(element).attr("data-action");
	$.ajax({
		url:action,
		type: 'get',
		beforeSend: function() {
			blockUI();

		},
		success: function(data) {
			$("#itemWisePolicyPopup").html(data);
		},
		complete: function() {

			$.unblockUI();

		}
	});

}
</script>