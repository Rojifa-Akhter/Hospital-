<div class="card">
	<div class="card-body">
		<div class="row mt-2">
			<div class="col-md-12 table-responsive">
				<table id="datatable" class="table table-bordered table-hover table-striped data-table">
					<thead class="bg-primary">
						<tr>
							<th class="text-center" scope="col">Sl#</th>
							<th class="text-center" scope="col">Rate</th>
							<th class="text-center" scope="col">Comission(%)</th>
							<th class="text-center" scope="col">Comission(Tk.)</th>
							<th class="text-center" scope="col">Actions</th>
							<th class="text-center" scope="col">Exclude</th>
						</tr>
					</thead>
					<tbody>

						@if(isset($item_policy_data))
						@foreach($item_policy_data as $sample_row)
						<tr>
							<td  class="border-0 text-center">  {{ $loop->iteration }}</td>
							<td  class="border-0 text-center"> {{ $sample_row->sales_price }} </td>
							<td  class="border-0 text-center">  {{ $sample_row->commission_percent }}</td>
							<td  class="border-0 text-center">  {{ $sample_row->commission_taka }}</td>
							<td class="border-0 text-center">
								<span class="badge badge-md badge-warning p-1 mb-1 cursor-pointer" data-id="" data-action="{{url('item-wise-policy-edit', $sample_row->referralpolicy_item_no_pk)}}" onclick="editReferralItemPolicyData(this)" data-title="Edit Item Wise Data" title="Edit"><i class="fa fa-pencil-alt"></i>Edit</span>
							</td>
							<td class="border-0 text-center">{{ $sample_row->exclude_ind }}</td>
						</tr>
						@endforeach
						@endif
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	function editReferralItemPolicyData(element){
	var action = $(element).attr("data-action");
	$.ajax({
		url:action,
		type: 'get',
		beforeSend: function() {
			blockUI();

		},
		success: function(data) {
			$("#item-policy").html(data);
		},
		complete: function() {

			$.unblockUI();

		}
	});

}
</script>