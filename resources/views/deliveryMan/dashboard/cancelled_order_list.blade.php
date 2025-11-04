@extends('deliveryMan.layouts.master')
@section('content')
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<style>
	table.dataTable thead th,
	table.dataTable thead td {
		padding: 10px 18px;
		border-bottom: 1px solid transparent;
		vertical-align: middle!important;
		text-transform:none;

	}
	table.dataTable.no-footer {
		border-bottom: 0;
	}

	.table td {
		padding: 0.75rem;
		vertical-align: middle;
	}
</style>
<section id="order_list">
	<div class="container-fluid">
		{{-- 		<div class="row bg-white border-bottom sticky-top shadow-sm">
			<div class="col-md-12 mb-1">
				<h5 class="mt-2 mb-0">Cancelled Order List</h5>
				<small>Settings / Delivery / Cancelled Order List</small>
			</div>
		</div> --}}

		<div class="page-header shadow-sm" style="background-color: #fff!important;padding: 15px 15px!important; border-radius: 5px!important;">
			<div class="page-leftheader">
				<h4 class="page-title" style="line-height: 1; margin-bottom: 5px;">Cancelled Order List</h4>
				<ol class="breadcrumb">
					<li class="breadcrumb-item">
						<a href="#"><i class="fa fa-cog fs-14"></i> Settings</a>
					</li>
					<li class="breadcrumb-item active" aria-current="page"><a href="#">Cancelled Order List</a></li>
				</ol>
			</div>
			<div class="page-rightheader">
			</div>
		</div>

		<div class="card shadow-sm">
			<div class="card-header"><h5 class="page-title">Cancelled Order List</h5></div>

			<div class="card-body">
				<div class="row">
					<div class="col-md-12 table-responsive">
						<table id="datatable" class="table table-bordered table-hover table-striped data-table-order-list mb-0">
							<thead class="">
								<tr>
									<th class="text-center">Sl#</th>
									<th class="text-center">Order Id</th>
									<th class="text-left">Customer Name</th>
									<th class="text-center">Customer Mobile</th>
									<th class="text-right">Amount</th>
									<th class="text-center">Order Date</th>
									<th class="text-left">Address</th>
									<th class="text-center">Cancelled Date</th>
									<th class="text-center">Status</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>

								@if(!empty($order_list))
								@foreach( $order_list as $data)

								<tr>
									<td class="text-center">{{$loop->iteration}}</td>
									<td class="text-center">{{ucfirst(strtolower($data->order_no))}}</td>
									<td class="text-left">{{ucfirst(strtolower($data->customer_name))}}</td>
									<td class="text-center">{{$data->phone_mobile}}</td>
									<td class="text-right">{{number_format($data->tot_amount,2)}}</td>

									<td class="text-center">{{date('d/m/Y', strtotime($data->order_date))}}</td>
									<td class="text-left">{{ucfirst(strtolower($data->address_name))}}</td>

									@if($data->canceled_date)
									<td class="text-center">{{date('d/m/Y', strtotime($data->canceled_date))}}
									</td>
									@else
									<td class="text-center">{{$data->canceled_date}}
									</td>

									@endif
									<td><span class="badge badge-danger" style="font-size: 13px">cancelled</span>
									</td>									
									<td class="text-center">
										<button type="button" data-toggle="modal" class="btn btn-success" data-target-id = "{{$data->order_no}}" data-target="#item_details_modal"  title="Item Details">
											<i class="fa fa-eye"></i>
										</button>
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
            <!-- Item details Modal -->

            <div class="modal fade" id="item_details_modal" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Item Details</h5>
                            <button  type="button" class="close" data-dismiss="modal"
                                aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <table id="datatable"
                                class="table table-bordered table-hover table-striped mb-0">
                                <thead class="">
                                    <tr>
                                        <th style="text-transform:none;" class="text-left" scope="col">Product Name</th>
                                        <th style="text-transform:none;" class="text-left" scope="col">Quantity</th>
                                        <th style="text-transform:none;" class="text-left" width="20%" scope="col">Unit Price</th>
                                        <th style="text-transform:none;" class="text-left" width="20%" scope="col">Total Price</th>

                                    </tr>
                                </thead>
                                <tbody id="orderWiseProduct">
                                    <tr>
                                        <td id=""></td>
                                        <td id=""></td>
                                        <td id=""></td>
                                        <td id=""></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
	</div>
</section>
@endsection
@section('scripts')
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script>
	$(document).ready(function () {
		var datatable = $('.data-table-order-list').DataTable();

	});
	$("#item_details_modal").on("hide.bs.modal", function(e) {
            // var id = $(e.relatedTarget).data('target-id');
            // var url = "{{ route('delivery-item-info', ':id') }}";
            // var url_rep = url.replace(':id', id);
            // $.get(url_rep, function(data) {
            // });
                $("#orderWiseProduct").html('');


        });
	$("#item_details_modal").on("show.bs.modal", function(e) {
            var id = $(e.relatedTarget).data('target-id');
            var url = "{{ route('delivery-item-info', ':id') }}";
            var url_rep = url.replace(':id', id);

            $.get(url_rep, function(data) {
            	$.blockUI();
                $("#orderWiseProduct").html(data);
				$.unblockUI();

            });

        });
</script>
@endsection
