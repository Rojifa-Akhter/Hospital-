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
							<td  class="border-0 text-center">  {{ $sample_row->equal_percent }}</td>

							<td class="border-0 text-center">
								<span class="badge badge-md badge-warning p-1 mb-1 cursor-pointer" onclick='editDiscountItemWisePolicy(this)'   data-itemTypePerc={{$sample_row->equal_percent}} data-itemType="{{$sample_row->item_type}}"  data-id="{{$sample_row->corppolicy_itemtype_no_pk}}"  data-title="Edit Item Wise Policy" title="Edit"><i class="fa fa-pencil-alt"></i>Edit</span>
								{{-- data-action="{{url('item-type-policy-edit', $sample_row->corppolicy_itemtype_no_pk)}}" --}}


								<span class="badge badge-md badge-danger p-1 mb-1 cursor-pointer" data-id="{{$sample_row->corppolicy_itemtype_no_pk}}" data-action="{{url('item-type-policy-delete')}}" onclick="deleteType(this)" title="Delete"><i class="fa fa-trash-alt"></i></span>
							</td>
							</td>
						</tr>
						@endforeach
						@endif
						@if(!empty($discount_policy))
						@foreach($discount_policy as $sample_row)
						<tr>
							<td  class="border-0 text-center">  {{ $loop->iteration }}</td>
							<td  class="border-0 text-center">  {{ $sample_row->item_type }}</td>
							<td  class="border-0 text-center">  {{ $sample_row->equal_percent }}</td>

							<td class="border-0 text-center">
								<span class="badge badge-md badge-warning p-1 mb-1 cursor-pointer" onclick='editDiscountItemWisePolicy(this)' data-itemTypePerc={{$sample_row->equal_percent}} data-itemType="{{$sample_row->item_type}}" data-id="{{$sample_row->dispolicy_itemtype_no_pk}}" data-title="Edit Item Wise Policy" title="Edit"><i class="fa fa-pencil-alt"></i>Edit</span>
								
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


<script type="text/javascript">
	function deleteType(element){
		let action = $(element).attr("data-action");
		let typeIt= $(element).data('id');
		if (confirm('Are you sure?')) {
				$.ajax({
					url:action,
					type: 'post',
					data:{
						typeIt: typeIt
					},
					beforeSend: function() {
						blockUI();

					},
					success: function(data) {
						if (data==1) {
							$(element).parents('tr').remove();
						}
					},
					complete: function() {
						$.unblockUI();
					}
				});
		}
	

	}
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

function editDiscountItemWisePolicy(element){
	let discount_no=$(element).data('id');
	let discount_percent=$(element).data('itemtypeperc');
	let discount_item_type=$(element).attr('data-itemtype').trim().toUpperCase();
	console.log(discount_percent,discount_item_type,discount_no,$('#item_type_name').val())
	$('#item_type_no_pk').val(discount_no);
	$('#comission').val(discount_percent);
	$('#item_type_name').val(discount_item_type).trigger('change');
}

function clearData() {
	$('#item_type_no_pk').val('');
	$('#comission').val('');
	$('#sec_ref').val('');
	$('#def_agent').val('');
	$('#sec_ref').val('');
	$('#item_type').val('').trigger('change');
}
</script>
