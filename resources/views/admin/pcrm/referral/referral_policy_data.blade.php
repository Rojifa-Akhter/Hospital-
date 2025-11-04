<div class="card">
	<div class="card-body">
		<div class="row mt-2">
			<div class="col-md-12 table-responsive">
				<table id="datatable" class="table table-bordered table-hover table-striped">
					<thead class="bg-primary">
						<tr>
							<th class="text-center" rowspan="2">Sl#</th>
							<th class="text-left" rowspan="2">Code</th>
							<th class="text-left" rowspan="2">Policy Name</th>
							<th class="text-center" rowspan="2">Applied To</th>
							<th class="text-center" colspan="3">Default(%)</th>

							<th class="text-center" rowspan="2">Item Type Policy</th>
							<th class="text-center" rowspan="2">Department Policy</th>
							<th class="text-center" rowspan="2">Item Policy</th>
                            <th class="text-center" rowspan="2">Actions</th>
						</tr>
						<tr>
							<th class="text-right">Referral</th>
							<th class="text-right">Agent</th>
							<th class="text-right">2nd Referral</th>
						</tr>

					</thead>
					<tbody>

						@if(isset($data))
						@foreach($data as $sample_row)
						<tr>
							<td  class="border-0 text-center">  {{ $loop->iteration }}</td>
							<td  class="border-0 text-left">  {{ $sample_row->referralpolicy_code }}</td>
							<td  class="border-0 text-left">  {{ $sample_row->policy_name }}</td>
							<div>

							</div>
							<td  class="border-0 text-center">
								<div>
									@if($sample_row->applied_to_ref_doctor_ind==1)
									<span class="badge badge-md badge-success p-1 mb-1 " >
										Referral Doctor
									</span>
									@else

									@endif
								</div>
								<div>
									@if($sample_row->applied_to_agent_ind==1)
									<span class="badge badge-md badge-success p-1 mb-1 " >Agent
									</span>
									@else

									@endif
								</div>

								<div>
									@if($sample_row->applied_to_seconnd_ref_ind==1)
									<span class="badge badge-md badge-success p-1 mb-1 " >2nd Referral
									</span>

									@else

									@endif
								</div>


							</td>

							<td class="text-right bg-light">
								@if($sample_row->applied_to_ref_doctor_ind != '')
								{{ !empty($sample_row->default_ref_percnet)?$sample_row->default_ref_percnet : '' }}
								@else
								@endif
                            </td>


								<td class="text-right bg-light">

									@if($sample_row->default_agent_percnet != '')
									{{ !empty($sample_row->default_agent_percnet)?$sample_row->default_agent_percnet : '' }}
									@else
									@endif
								</td>
								<td class="text-right bg-light">
									@if($sample_row->default_2nd_referral_percent != '')
									{{ !empty($sample_row->default_2nd_referral_percent)?$sample_row->default_2nd_referral_percent : '' }}
									@else
									@endif


								</td>


								<td class="border-0 text-center">
									<span class="badge badge-md badge-primary p-1 mb-1 cursor-pointer open-modal" data-id="" data-action="{{url('item-type-policy', $sample_row->referralpolicy_no_pk)}}" data-modal="common-modal-md" data-title="Item Type Wise Policy" title="Item Type Wise Policy"><i class="fa fa-pencil-alt"></i> Policy</span>
								</td>
								<td class="border-0 text-center">
									<span class="badge badge-md badge-success p-1 mb-1 cursor-pointer open-modal" data-id="" data-action="{{url('department-type-policy', $sample_row->referralpolicy_no_pk)}}" data-modal="common-modal-md" data-title="Service Unit Wise Policy" title="Service Unit Wise Policy"><i class="fa fa-pencil-alt"></i> Policy</span>
								</td>
								<td class="border-0 text-center">
									<span class="badge badge-md badge-warning p-1 mb-1 cursor-pointer open-modal" data-id="" data-action="{{url('item-wise-policy', $sample_row->referralpolicy_no_pk)}}" data-modal="common-modal-md" data-title="item Wise Policy" title="item Wise Policy"><i class="fa fa-pencil-alt"></i> Policy</span>
								</td>
                                <td  class="border-0 text-center">
									<div>
										<span class="badge badge-md badge-warning p-1 mb-1 cursor-pointer" data-id="" data-action="{{url('referral-policy-edit', $sample_row->referralpolicy_no_pk)}}" data-title="Edit Referral Policy" onclick="editReferralPolicy(this)" title="Edit"><i class="fa fa-pencil-alt"></i>Edit</span>

										<span onclick="deleteRefPolicyCon(this)" class="badge badge-md badge-danger p-1 mb-1 cursor-pointer" id="delete_fund" ><i class="fas fa-trash-alt"></i>Delete</span>
										<input type="hidden" name="ref_hdn_id" id="ref_hdn_id" value="{{$sample_row->referralpolicy_no_pk}}"/>


										<a href="{{url('referral-policy-print-pdf',$sample_row->referralpolicy_no_pk)}}" class="badge badge-md badge-primary p-1 mb-1 cursor-pointer"data-id=""  title="Print Prescription"><i class="fas fa-print"></i>Print</a>

										{{-- <span class="badge badge-md badge-warning p-1 mb-1 cursor-pointer " data-id="" data-action="" data-modal="common-modal-md" data-title="Referral Policy View" title="Item Type Wise Policy"><i class="fa fa-pencil-alt"></i> View</span> --}}
										<span class="badge badge-md badge-warning p-1 mb-1 cursor-pointer open-modal" data-id="" data-action="{{url('view-policy', $sample_row->referralpolicy_no_pk)}}" data-modal="common-modal-md" data-title="Referral Policy View" title="Item Type Wise Policy"><i class="fa fa-pencil-alt"></i> View</span>
									</div>
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




	<script type="text/javascript">
		function deleteRefPolicyCon(element) {
			var ref_id = $(element).siblings('#ref_hdn_id').val();
		//alert(ref_id);

		if ( confirm('Are you sure ?')) {
			$.ajax({
				data:{ref_id : ref_id},
				url:"{{route ('referral-list-delete')}}",
				type: 'get',
				beforeSend: function() {
					blockUI();

				},
				success: function(data) {
                 // alert("#"+fund_id);
                 $(element).parents("tr").remove();
                 // $(this).closest("tr").remove();
                 $('.common-modal-notify').modal('show');
                 $('.common-modal-notify .modal-body').html("<i class='fas fa-stroopwafel fa-spin'></i>");
                 $('.common-modal-notify .modal-body').html("Delete successfully");
             },
             complete: function() {

             	$.unblockUI();

             }
         });
		}
    // element.preventDefault();
}
// $('.data-table').DataTable({
//     "ordering": false,
//     "bPaginate": false,
//     "bLengthChange": false,
//     "bAutoWidth": false
// });



function editReferralPolicy(element){
	var action = $(element).attr("data-action");
	$.ajax({
		url:action,
		type: 'get',
		beforeSend: function() {
			blockUI();

		},
		success: function(data) {
			$("#referral_policy_form").html(data);
		},
		complete: function() {

			$.unblockUI();

		}
	});

}
</script>
