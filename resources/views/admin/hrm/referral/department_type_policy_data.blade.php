<div class="card">
	<div class="card-body">
		<div class="row mt-2">
			<div class="col-md-12 table-responsive">
				<table id="datatable" class="table table-bordered table-hover table-striped data-table">
					<thead class="bg-primary">
						<tr>
							<th class="text-center" scope="col">Sl#</th>
							<th class="text-center" scope="col">Service Unit</th>
							<th class="text-center" scope="col">Comission (%)</th>
							<th class="text-center" scope="col">Actions</th>
						</tr>
					</thead>
					<tbody>

						@if(isset($dep_policy))
						@foreach($dep_policy as $sample_row)
						<tr>
							<td  class="border-0 text-center">  {{ $loop->iteration }}</td>
							<td  class="border-0 text-center">  {{ $sample_row->su_no_fk }}</td>
							<td  class="border-0 text-center">  {{ $sample_row->commission_percent }}</td>

							<td class="border-0 text-center">
								<span  class="badge badge-md badge-warning p-1 mb-1 cursor-pointer" data-id="" onclick="editDeptReferralPolicy(this)"data-id="" data-action="{{url('dept-wise-policy-edit', $sample_row->referralpolicy_su_no_pk)}}"data-title="Edit Department Type" title="Edit"><i class="fa fa-pencil-alt"></i>Edit</span>
							</td>
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
<script type="text/Javascript">
	function editDeptReferralPolicy(element){
	var action = $(element).attr("data-action");
	$.ajax({
		url:action,
		type: 'get',
		beforeSend: function() {
			blockUI();

		},
		success: function(data) {
			$("#dept_policy").html(data);
		},
		complete: function() {

			$.unblockUI();

		}
	});
}
</script>