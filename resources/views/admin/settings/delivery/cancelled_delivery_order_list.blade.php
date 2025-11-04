<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<section id="order_list">
	<div class="container-fluid">
		<div class="row bg-white border-bottom sticky-top shadow-sm">
			<div class="col-md-12 mb-1">
				<h5 class="mt-2 mb-0"> Cancelled 
				 Ecommerce Order List</h5>
				<small>Delivery Man / Delivery List / Cancelled 
				 Ecommerce Order List</small>
			</div>
		</div>
		<div class="card">
			<div class="card-header"><h5> Cancelled 
			 Ecommerce Order List</h5></div>

			<div class="card-body">
				<div class="row mt-2">
					<div class="col-md-12 table-responsive">
						<table id="datatable" class="table table-bordered table-hover table-striped data-table-order-list">
							<thead class="bg-primary">
								<tr>
									<th scope="col">Sl#</th>
									<th class="text-left" scope="col">Order Id</th>
									<th class="text-left" scope="col">Customer Name</th>
									<th class="text-left" scope="col">Customer Mobile</th>
									<th class="text-center" style="width: 10%" scope="col">Amount</th>
									<th class="text-center" scope="col">Order Date</th>
									<th class="text-left" scope="col">Address</th>
									<th class="text-left" scope="col">Assigned Delivery Man</th>
									<th class="text-left" scope="col">Cancelled Date</th>
									<th class="text-left" scope="col">Action</th>

								</tr>
							</thead>
							<tbody>

								@if(!empty($order_list))
								@foreach( $order_list as $data)
								<tr>
									<td >{{$loop->iteration}}</td>
									<td>{{ucfirst(strtolower($data->order_no))}}</td>
									<td>{{ucfirst(strtolower($data->customer_name))}}</td>
									<td>{{ucfirst(strtolower($data->phone_mobile))}}</td>
									<td class="text-right">{{number_format($data->tot_amount,2)}}</td>
									<td class="text-center">{{date('d/m/Y', strtotime($data->order_date))}}</td>
									<td>{{ucfirst(strtolower($data->address_name))}}</td>
									<td>{{ucfirst(strtolower($data->assign_name))}}</td>
									<td>{{date('d/m/Y', strtotime($data->canceled_date))}}</td>
									<td>
									<span Class="btn btn-sm btn-primary open-modal" data-id="{{ $data->order_no }}" data-action="{{ route('item-info',$data->order_no) }}"data-modal="common-modal-sm" data-title="Item Details"title="Item Details"><i class="fa fa-eye"></i></span>
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
</section>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script>
	$(document).ready(function () {
		var datatable = $('.data-table-order-list').DataTable(
						{
			      "aoColumnDefs": [
          { 'bSortable': false, 'aTargets': [ 9 ] }
       ]});

	});
</script>
