<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">

<div class="col-md-12 table-responsive">
	<table class="table table-bordered table-hover datatable table-striped m-0 border data-table">
		<thead class="bg-primary">
			<tr>
				<th class="text-center">SL</th>
				<th class="text-center">Item No./Barcode</th>
				<th class="text-left">Item Name</th>
				<th class="text-center">Department</th>
				<th class="text-right">Normal Fee</th>
				<th class="text-right">Urgent Fee</th>
				<th class="text-center">Normal Delivery Hour</th>
				<th class="text-center">Urgent Delivery Hour</th>
				<th class="text-left">Status</th>
				<th class="text-center">Action</th>
			</tr>
		</thead>
		<tbody>
			@if(!empty($radiology_data))
			@foreach($radiology_data as $sample)
			<tr>
				<td class="text-center">{{$loop->iteration}}</td>
				<td class="text-center">{{!empty($sample->item_code)?$sample->item_code:''}}</td>
				<td class="text-center">{{!empty($sample->item_name)?$sample->item_name:''}}</td>
				<td class="text-left">{{!empty($sample->serviceunit_name)?$sample->serviceunit_name:''}}</td>
				<td class="text-right">{{!empty($sample->sales_price)?$sample->sales_price:''}}</td>
				<td class="text-right">{{!empty($sample->urgent_fee_amt)?$sample->urgent_fee_amt:''}}</td>
				<td class="text-center">{{!empty($sample->normal_delivery_hour)?$sample->normal_delivery_hour:''}}</td>
				<td class="text-center">{{!empty($sample->urgent_delivery_hour)?$sample->urgent_delivery_hour:''}}</td>
				<td class="text-left"><span class="badge {{ ($sample->active_stat==1)?'bg-success':'bg-danger' }}  text-white">{{($sample->active_stat==1)?'Active':'Inactive'}}</span></td>
				<td class="text-center">
					<span class="badge badge-md badge-warning p-1 mb-1 cursor-pointer" data-id="" data-action="{{url('item/radiology-item',$sample->item_no_pk)}}" data-title="Edit Referral Policy" onclick="editRadiologyPolicy(this)" title="Edit"><i class="fa fa-pencil-alt"></i>Edit</span>
				</td>
			</tr>
			@endforeach
			@endif
		</tbody>
	</table>
</div>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>

<script>
	var datatable = $('.data-table').DataTable();
	function editRadiologyPolicy(element){
		var action = $(element).attr("data-action");
		$.ajax({
			url:action,
			type: 'get',
			beforeSend: function() {
				blockUI();

			},
			success: function(data) {
				$("#radiology-item").html(data);
			},
			complete: function() {

				$.unblockUI();

			}
		});

	}

</script>

