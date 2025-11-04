@extends('deliveryMan.layouts.master')
@section('content')
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<style>
	table.dataTable thead th,
	table.dataTable thead td {
		padding: 10px 18px;
		border-bottom: 1px solid transparent;
		vertical-align: middle !important;
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
		{{-- <div class="row bg-white border-bottom sticky-top shadow-sm">
			<div class="col-md-12 mb-1">
				<h5 class="mt-2 mb-0">Picked Order List</h5>
				<small>Settings / Delivery / Picked Order List</small>
			</div>
		</div> --}}

		<div class="page-header shadow-sm"
		style="background-color: #fff!important;padding: 15px 15px!important; border-radius: 5px!important;">
		<div class="page-leftheader">
			<h4 class="page-title" style="line-height: 1; margin-bottom: 5px;">Picked Order List</h4>
			<ol class="breadcrumb">
				<li class="breadcrumb-item">
					<a href="#"><i class="fa fa-cog fs-14"></i> Settings</a>
				</li>
				<li class="breadcrumb-item active" aria-current="page"><a href="#">Picked Order List</a></li>
			</ol>
		</div>
		<div class="page-rightheader">
		</div>
	</div>

	<div class="card shadow-sm">
		<div class="card-header">
			<h5 class="page-title">Picked Order List</h5>
		</div>

		<div class="card-body">
			<div class="row">
				<div class="col-md-12 table-responsive">
					<table id="datatable"
					class="table table-bordered table-hover table-striped data-table-order-list mb-0">
					<thead class="">
						<tr>
							<th class="text-center">Sl#</th>
							<th class="text-center">Order Id</th>
							<th class="text-left">Customer Name</th>
							<th class="text-left">Customer Mobile</th>
							<th class="text-right">Amount</th>
							<th class="text-center">Order Date</th>
							<th class="text-left">Address</th>
							<th class="text-center">Delivery Date</th>
							<th class="text-center">Status</th>
							<th class="text-center">Action</th>

						</tr>
					</thead>
					<tbody>

						@if (!empty($order_list))
						@foreach ($order_list as $data)

						<tr>
							<td class="text-center">{{ $loop->iteration }}</td>
							<td class="text-center">{{ ucfirst(strtolower($data->order_no)) }}</td>
							<td class="text-left">{{ ucfirst(strtolower($data->customer_name)) }}
							</td>
							<td class="text-left">{{ $data->phone_mobile }}</td>
							<td class="text-right">{{number_format($data->tot_amount,2)}}</td>

							<td class="text-center">
								{{ date('d/m/Y', strtotime($data->order_date)) }}
							</td>
							<td class="text-left">{{ ucfirst(strtolower($data->address_name)) }}
							</td>
							<td class="text-center">
								{{ date('d/m/Y', strtotime($data->delivery_date)) }}</td>
								<td class="text-center"><span class="badge badge-success"
									style="font-size: 13px">Picked</span></td>
									<td class="text-center">
										<button type="button" data-toggle="modal" class="btn btn-success"
										data-target-id="{{ $data->order_no }}"
										data-target="#item_details_modal" title="Item Details">
										<i class="fa fa-eye"></i>
									</button>
									<!-- Example single danger button -->
									<button type="button" data-toggle="modal"
									data-target="#deliveryModal-{{ $loop->iteration }}"
									class="btn btn-secondary" title="Change Status">
									<i class="fas fa-exchange-alt"></i>
								</button>
							</td>
						</tr>
						<!-- Modal -->
						<div class="modal fade status-modal" id="deliveryModal-{{ $loop->iteration }}"
							tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
							aria-hidden="true">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="exampleModalLabel">Delivery
										Status</h5>
										<button type="button"
										class="close" data-dismiss="modal"
										aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<form class="delivery_form">
									<span class="msg"
									id="form_result_{{ $data->ecom_delivery_no }}"></span>
                                                            <!--
                   <input type="hidden" class="delivery_service_class" name="id" value="{{ $data->ecom_delivery_no }}">
                 -->
                 <div class="modal-body">
                 	<div class="form-group">
                 		<select class="form-control delivery_status"
                 		id="delivery_status_{{ $data->ecom_delivery_no }}"
                 		name="delivery_status" required
                 		data-del_no="{{ $data->ecom_delivery_no }}">
                 		<option value="">Select Delivery Status</option>
                 		<option value="2">
                 		Delivered</option>
                 		<option value="3">Cancelled</option>

                 	</select>
                 </div>
                 <input type="text" class=" form-control   d-none otp"
                 id="otp_{{ $data->ecom_delivery_no }}" name="otp"
                 placeholder="Paste Your OTP">

               </div>
               <p type="text" class="text-center otp_class d-none"></p>
               <div class="modal-footer">
               	<button type="button"
               	class="btn btn-secondary"
               	data-dismiss="modal">Close</button>
               	<button type="button" id="save" class="btn btn-primary"
               	value="{{ $data->ecom_delivery_no }}">Submit</button>
               </div>
             </form>
           </div>
         </div>
       </div>

       @endforeach
       @endif
     </tbody>
   </table>
 </div>
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
		class="table table-bordered table-hover table-striped  mb-0">
		<thead class="">
			<tr>
				<th style="text-transform:none;"class="text-left" scope="col">Product Name</th>
				<th style="text-transform:none;"class="text-left" scope="col">Quantity</th>
				<th style="text-transform:none;" class="text-left" width="20%" scope="col">Unit Price</th>
				<th style="text-transform:none;"class="text-left" width="20%" scope="col">Total Price</th>

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
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>
<script>
	$(document).ready(function() {
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
			$(".status-modal").on("hide.bs.modal", function(e) {
       		$('.delivery_status').val('');
		$('.otp').addClass('d-none');
		$('.msg').html('');
		$('.otp_class').html('');
		});

	$("#item_details_modal").on("show.bs.modal", function(e) {
		var id = $(e.relatedTarget).data('target-id');
		var url = "{{ route('delivery-item-info', ':id') }}";
		var url_rep = url.replace(':id', id);
		$.get(url_rep, function(data) {
			$("#orderWiseProduct").html(data);
		});

	});


	//function getSelectStatus() {
		// $('.delivery_status').val('');
		// $('.otp').addClass('d-none');
		// $('.msg').html('');
		// $('.otp_class').html('');
	//}


	$(document).on('change', '.delivery_status', function() {

            // alert(id);
            var del_id = $(this).attr('data-del_no');
            if ($(this).val() == 2) {

            	$('#otp_' + del_id).removeClass('d-none');
            	$('#otp_' + del_id).removeClass('d-none').val('');
            	var id = $(this).attr('data-del_no');
            	var url = "{{ route('send-otp-to-customer', ':id') }}";
            	var url_rep = url.replace(':id', id);
            	$.ajax({
            		url: url_rep,
            		type: 'get',
            		success: function(response) {
            			$(".otp_class").html(response);
            			$(".otp_class").removeClass('d-none');


            		},

            	});
            } else {
            	$('#otp_' + del_id).addClass('d-none');
              $('.otp_class').html('');

            }
          })

	$(document).on('click', '#save', function(e) {
		e.preventDefault();
		var delivery_id = $(this).val();
		var delivery_status = $('#delivery_status_' + delivery_id).find(':selected').val();
		if (delivery_status == 2) {
			var otp = $('#otp_' + delivery_id).val();
			var url = "{{ route('complete-delivery') }}";
			$.ajax({
				url: url,
				type: "POST",
				data: {
					"_token": "{{ csrf_token() }}",
					id: delivery_id,
					otp: otp,
				},
				success: function(response) {

					var html = '<div class="alert alert-success">' + 'Successfully Delivered!' +
					'</div>';
					$("#form_result_" + delivery_id).html(html);
					location.reload();

				},
				error: function(response) {
					var html = '<div class="alert alert-danger">' + 'OTP Mismatched!' + '</div>';
					$("#form_result_" + delivery_id).html(html);
                       // location.reload();

                     },
                   });
		} else if (delivery_status == 3) {

            var url = "{{ route('cancel-delivery') }}";
            $.ajax({
            	url: url,
            	type: "POST",
            	data: {
            		"_token": "{{ csrf_token() }}",
            		id: delivery_id,
            	},
            	success: function(response) {

            		var html = '<div class="alert alert-success">' + 'Successfully Cancelled!' +
            		'</div>';
            		$("#form_result_" + delivery_id).html(html);
            		location.reload();

            	},
            	error: function(response) {
            		var html = '<div class="alert alert-danger">' + 'Something Went Wrong!' +
            		'</div>';
            		$("#form_result_" + delivery_id).html(html);
            		location.reload();

            	},
            });
          } else {
          	return;
          }
        });
      </script>
      @endsection
