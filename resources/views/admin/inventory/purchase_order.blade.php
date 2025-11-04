<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<style>
	.sorting {
		background-image: none !important;
	}

	input.form-control {
		margin-bottom: 0px !important;
	}

	select.form-control {
		margin-bottom: 0px !important;
	}

	.input-group-text {
		padding: 6px 10px;
		border: 0;
		border-radius: 0px;
	}

	.search_product input.form-control {
		border-radius: 0 !important;
	}

	.product-qty {
		position: relative;
	}

	.product-qty input.form-control {
		padding: .375rem 1.5rem !important;
		text-align: center;
	}

	.product-qty .quantity-left-minus {
		position: absolute;
		top: 50%;
		left: 11%;
		transform: translate(-50%, -50%);
		font-size: 11px;
		color: red;
		width: 24px;
		line-height: 25px;
		border-right: 1px solid #dee2e6;
		text-align: center;
		cursor: pointer;
	}

	.product-qty .quantity-right-plus {
		position: absolute;
		top: 50%;
		right: -11%;
		transform: translate(-50%, -50%);
		font-size: 10px;
		color: green;
		width: 25px;
		line-height: 25px;
		border-left: 1px solid #dee2e6;
		text-align: center;
		cursor: pointer;
	}

	.product {
		margin: 5px 0;
		transition: all 0.3s;
		cursor: pointer;
		z-index: 9999;
		-webkit-box-shadow: 1px 1px 5px 1px rgba(0, 0, 0, 0.2);
		-moz-box-shadow: 1px 1px 5px 1px rgba(0, 0, 0, 0.2);
		box-shadow: 1px 1px 5px 1px rgba(0, 0, 0, 0.2);
	}

	.product:hover {
		transform: scale(1.05);
	}

	.product-img {
		width: 65px;
		margin: auto;
	}

	.product-details span {
		font-size: 10px;
	}

	table th,
	table td {
		border: 0px;
		border-right: 1px solid #dee2e6;
		border-bottom: 1px solid #dee2e6;
		/*border-right: 1px solid #dee2e6;*/
	}

	table th:first-child,
	table td:first-child {
		border-left: 1px solid #dee2e6;
	}

	.table th,
	.table td {
		border-top: 0px;
	}

	.dataTables_wrapper.no-footer .dataTables_scrollBody {
		border-bottom: 0;
	}

	table.dataTable tbody th,
	table.dataTable tbody td {
		padding: 3px 10px;
	}

	table.dataTable thead th,
	table.dataTable thead td {
		padding: 3px 10px;
		border-bottom: 0px;
	}

	table.dataTable tfoot th,
	table.dataTable tfoot td {
		padding: 3px 10px;
		border-top: 0px;
	}

	.total_calculation .detail {
		margin-right: 10px;
	}


	.total_calculation .detail:last-child {
		margin-right: 0px;
	}


	.custom-select {
		height: calc(1.9em + 0.2rem + 0px) !important;
		font-size: 0.75rem !important;
	}

	.input-group-text {
		font-size: 0.75rem;
	}




	/*============================================*/
	.right_side .amount {
		font-weight: 500;
		font-size: 18px;
	}

	.right_side .total-price {
		font-weight: 500;
		font-size: 18px;
		font-family: 'Raleway', sans-serif;
		color: rgb(123, 123, 123);
	}

	.right_side .dis_total {
		font-weight: 500;
		font-size: 18px;
		font-family: 'Raleway', sans-serif;
		color: rgb(123, 123, 123);
	}

	.right_side .dis_amount {
		font-weight: 500;
		font-size: 18px;
	}

	.sub_total {
		background-color: #f9f9f9;
		color: #222;
	}

	.sub_total .sub_price {
		font-weight: 500;
		font-size: 18px;
	}

	.sub_total .sub_amount {
		font-size: 18px;
	}

	.full_vat .vat {
		float: left;
		font-weight: 500;
		font-size: 16px;
		font-family: 'Raleway', sans-serif;
		color: rgb(123, 123, 123);
	}

	.full_vat .inputVat {}

	.right_side .Inputlable {
		font-weight: 500;
		font-size: 16px;
		font-family: 'Raleway', sans-serif;
		color: rgb(123, 123, 123);
	}


	.right_side .price_total {
		font-weight: 500;
		font-size: 17px;
		font-family: 'Raleway', sans-serif;
		color: #222;
	}

	.right_side .total_amount {
		font-weight: 500;
		font-size: 24px;
		font-weight: 600;
	}

	.right_side .total_price {
		border-radius: 5px;
		background-color: #d3edfb;
		padding: 5px;
		color: #222;
		display: flex;
		align-items: center;
		justify-content: space-between;
		margin-bottom: 10px;
	}

	.right_side .change_amount {
		font-weight: 500;
		font-size: 25px;
		color: red;
	}

	.right_side .change_total {
		font-weight: 500;
		font-size: 22px;
		font-family: 'Raleway', sans-serif;
		color: rgb(123, 123, 123);
	}

	/*	.right_side .main_change_amount {
		margin: 0px 0px 10px 0;

		}*/

	.right_side input {
		border: 1px solid #003b6169;
	}

	.right_side .recived_amount {
		height: 38px !important;
		font-size: 26px !important;
		text-align: right;
		background-color: #d3edfb !important;
		border: 1px solid #003b6169;
		color: #6c757d;
	}


	.right_side .total_payment {
		margin-bottom: 5px;
		border-bottom: 1px solid #003b6129;
	}


	.right_side .full_vat {
		padding-bottom: 6px;
		border-bottom: 1px solid #003b6129;
	}

	.right_side .sub_total {
		padding: 6px 0;
		border-bottom: 1px solid #003b6129;
	}

	.right_side .other_discount {
		padding: 5px 0;
		border-bottom: 1px solid #003b6129;
	}

	.pay_bill {
		margin-top: 155px;
	}

	/*	.btn-group .btn{
		vertical-align: middle;
	}
	.btn-group .btn i{
		font-size: 1.2rem;
		}*/
</style>
<div class="container-fluid">
	{{-- <div class="form-row bg-white border-bottom sticky-top shadow-sm">
			<div class="col-md-12 mb-1">
				<h5 class="mt-2 mb-0">POS</h5>
				<small>Pharmacy / POS</small>
			</div>
		</div> --}}
	<div class="form-row" id="mypos">
		<div class="col-md-8">
			<form method="post" id="frm-menu-store" action="{{ route('purchaseOrder.create') }}">
				@csrf
				<input type="hidden" name="id" value="" value="">

				<div class="card shadow-sm" >
					<div class="card-header">
						<h5>Purchase Order Entry</h5>
					</div>
					<div class="card-body p-2">

						<div class="form-row ">
							<label class="col-form-label col-form-label-sm" for="patient_id">Purchase Order Date</label>
							<div class="col-md-3">
								<input type="text" class="form-control form-control-sm m-0 date_picker" id="po_date" name="po_date" value="" placeholder="dd/mm/yyyy">
							</div>



						</div>
					</div>
				</div>

				<div class="card shadow-sm">
					<div class="card-body p-2">
						<div class="form-row">
							<div class="col-md-12">
								<div class="input-group d-flex align-items-center search_product">
									<!-- <div class="col-md-1">
										<span class="input-group-text text-white bg-info">
											<i class="fa fa-barcode"></i>
										</span>
									</div> -->

									<input type="text" class="form-control item_typehead" id="item_name" name="item_name" value="" placeholder="Enter Product Name/SKU/Scan Barcode">

									<!-- <div class="col-md-1">

										<span class="input-group-text text-white bg-primary">
											<i class="fa fa-plus"></i>
										</span>
									</div> -->
								</div>
							</div>

							<div class="col-12 mt-3">
								<table id="" class="table" style="width:100%">
									<thead>
										<tr class="bg-navy">
											<th class="text-left">#SL</th>
											<th class="text-left">Product</th>
											<th class="text-left">Rate</th>
											<th class="text-center">Quantity</th>
											<th class="text-right">Subtotal</th>
											<th class="text-center">Stock</th>
											<th class="text-center"><i class="fa fa-times"></i></th>
										</tr>
									</thead>
									<tbody id="billing_table-body">

									</tbody>
									<!-- <tfoot>
									<tr class="bg-navy">
										<th colspan="4" class="text-right">TOTAL</th>
										<th class="text-right">2500</th>
										<th class="text-right"></th>
										<th class="text-right"></th>

									</tr>
								</tfoot> -->
								</table>
							</div>
						</div>
					</div>
				</div>


				<div class='mr-auto col-md-4.5 float-right'>
					<div class="card shadow-sm " >
						<div class="card-body " >
							<table>
								<tr>
									<td> Total Price (Tk) = &nbsp; </td>
									<td > <input type="text" class="form-control mb-0 text-right" id="item_total" name="item_total" value="" placeholder="0.00" disabled="disabled"> </td>
								</tr>
								<tr class="">
									<td colspan="2">
										@php
										$doctor_id = "";
										$response_url = route('purchaseOrder.pos');
										@endphp
										<div class="btn-group btn-block mt-2" role="group" aria-label="Basic example">
											<button type="submit" class="btn btn-success" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_url }}')">Save</button>
										<button type=" button" class="btn btn-warning ">Save &amp; Print</button>
										</div>
									</td>

								</tr>
							</table>
						</div>
					</div>
				</div>


			</form>
		</div>

		<div class="col-md-4">
			<div class="card shadow-sm">
				<div class="card-body p-2">
					<div class="form-row">
						<div class="col-md-6">
							<select class="form-control form-control-sm mb-3" id="select-category" name="select-category">
								<option value="">All Categories</option>
								<option value="">Category-01</option>
								<option value="">Category-02</option>
								<option value="">Category-03</option>
								<option value="">Category-04</option>
							</select>
						</div>

						<div class="col-md-6">
							<select class="form-control form-control-sm mb-3" id="select-brands" name="select-brands">
								<option value="">All Supplier</option>
								<option value="">Supplier-01</option>
								<option value="">Supplier-02</option>
								<option value="">Supplier-03</option>
								<option value="">Supplier-04</option>
							</select>
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-4">
							<div class="product" title="ACCU CHEK ACTIVE 50 T. STRIP">
								<div class="product-img">
									<img class="w-100" src="{{ asset('images/product-01.jpg') }}" alt="">
								</div>
								<div class="product-details text-center">
									<span>ACCU CHEK ACTIVE</span> <br>
									<small>(5236921)</small>
								</div>
							</div>
						</div>

						<div class="col-md-4">
							<div class="product" title="ACCU CHEK ACTIVE 50 T. STRIP">
								<div class="product-img">
									<img class="w-100" src="{{ asset('images/product-01.jpg') }}" alt="">
								</div>
								<div class="product-details text-center">
									<span>ACCU CHEK ACTIVE</span> <br>
									<small>(5236921)</small>
								</div>
							</div>
						</div>

						<div class="col-md-4">
							<div class="product" title="ACCU CHEK ACTIVE 50 T. STRIP">
								<div class="product-img">
									<img class="w-100" src="{{ asset('images/product-01.jpg') }}" alt="">
								</div>
								<div class="product-details text-center">
									<span>ACCU CHEK ACTIVE</span> <br>
									<small>(5236921)</small>
								</div>
							</div>
						</div>

						<div class="col-md-4">
							<div class="product" title="ACCU CHEK ACTIVE 50 T. STRIP">
								<div class="product-img">
									<img class="w-100" src="{{ asset('images/product-01.jpg') }}" alt="">
								</div>
								<div class="product-details text-center">
									<span>ACCU CHEK ACTIVE</span> <br>
									<small>(5236921)</small>
								</div>
							</div>
						</div>

						<div class="col-md-4">
							<div class="product" title="ACCU CHEK ACTIVE 50 T. STRIP">
								<div class="product-img">
									<img class="w-100" src="{{ asset('images/product-01.jpg') }}" alt="">
								</div>
								<div class="product-details text-center">
									<span>ACCU CHEK ACTIVE</span> <br>
									<small>(5236921)</small>
								</div>
							</div>
						</div>

						<div class="col-md-4">
							<div class="product" title="ACCU CHEK ACTIVE 50 T. STRIP">
								<div class="product-img">
									<img class="w-100" src="{{ asset('images/product-01.jpg') }}" alt="">
								</div>
								<div class="product-details text-center">
									<span>ACCU CHEK ACTIVE</span> <br>
									<small>(5236921)</small>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="product" title="ACCU CHEK ACTIVE 50 T. STRIP">
								<div class="product-img">
									<img class="w-100" src="{{ asset('images/product-01.jpg') }}" alt="">
								</div>
								<div class="product-details text-center">
									<span>ACCU CHEK ACTIVE</span> <br>
									<small>(5236921)</small>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="product" title="ACCU CHEK ACTIVE 50 T. STRIP">
								<div class="product-img">
									<img class="w-100" src="{{ asset('images/product-01.jpg') }}" alt="">
								</div>
								<div class="product-details text-center">
									<span>ACCU CHEK ACTIVE</span> <br>
									<small>(5236921)</small>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="product" title="ACCU CHEK ACTIVE 50 T. STRIP">
								<div class="product-img">
									<img class="w-100" src="{{ asset('images/product-01.jpg') }}" alt="">
								</div>
								<div class="product-details text-center">
									<span>ACCU CHEK ACTIVE</span> <br>
									<small>(5236921)</small>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="product" title="ACCU CHEK ACTIVE 50 T. STRIP">
								<div class="product-img">
									<img class="w-100" src="{{ asset('images/product-01.jpg') }}" alt="">
								</div>
								<div class="product-details text-center">
									<span>ACCU CHEK ACTIVE</span> <br>
									<small>(5236921)</small>
								</div>
							</div>
						</div>

						<div class="col-md-4">
							<div class="product" title="ACCU CHEK ACTIVE 50 T. STRIP">
								<div class="product-img">
									<img class="w-100" src="{{ asset('images/product-01.jpg') }}" alt="">
								</div>
								<div class="product-details text-center">
									<span>ACCU CHEK ACTIVE</span> <br>
									<small>(5236921)</small>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="product" title="ACCU CHEK ACTIVE 50 T. STRIP">
								<div class="product-img">
									<img class="w-100" src="{{ asset('images/product-01.jpg') }}" alt="">
								</div>
								<div class="product-details text-center">
									<span>ACCU CHEK ACTIVE</span> <br>
									<small>(5236921)</small>
								</div>
							</div>
						</div>

						<div class="col-md-4">
							<div class="product" title="ACCU CHEK ACTIVE 50 T. STRIP">
								<div class="product-img">
									<img class="w-100" src="{{ asset('images/product-01.jpg') }}" alt="">
								</div>
								<div class="product-details text-center">
									<span>ACCU CHEK ACTIVE</span> <br>
									<small>(5236921)</small>
								</div>
							</div>
						</div>

						<div class="col-md-4">
							<div class="product" title="ACCU CHEK ACTIVE 50 T. STRIP">
								<div class="product-img">
									<img class="w-100" src="{{ asset('images/product-01.jpg') }}" alt="">
								</div>
								<div class="product-details text-center">
									<span>ACCU CHEK ACTIVE</span> <br>
									<small>(5236921)</small>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="product" title="ACCU CHEK ACTIVE 50 T. STRIP">
								<div class="product-img">
									<img class="w-100" src="{{ asset('images/product-01.jpg') }}" alt="">
								</div>
								<div class="product-details text-center">
									<span>ACCU CHEK ACTIVE</span> <br>
									<small>(5236921)</small>
								</div>
							</div>
						</div>


					</div>
				</div>
			</div>
		</div>




		{{-- <div class="col-md-4">
				<div class="card">
					<div class="card-header"><h5>Products</h5></div>
					<div class="products" style="height:550px; overflow-y: auto; padding: auto -10px;">
						<div class="card-body p-2">
							<div class="form-row">
								<div class="col-md-6">
									<select class="form-control form-control-sm mb-3" id="select-category" name="select-category">
										<option value="">All Categories</option>
										<option value="">Category-01</option>
										<option value="">Category-02</option>
										<option value="">Category-03</option>
										<option value="">Category-04</option>
									</select>
								</div>

								<div class="col-md-6">
									<select class="form-control form-control-sm mb-3" id="select-brands" name="select-brands">
										<option value="">All Brands</option>
										<option value="">Brand-01</option>
										<option value="">Brand-02</option>
										<option value="">Brand-03</option>
										<option value="">Brand-04</option>
									</select>
								</div>
							</div>

							<div class="form-row">
								<div class="col-md-4">
									<div class="product" title="ACCU CHEK ACTIVE 50 T. STRIP">
										<div class="product-img">
											<img class="w-100" src="{{ asset('images/product-01.jpg') }}" alt="">
	</div>
	<div class="product-details text-center">
		<span>ACCU CHEK ACTIVE</span> <br>
		<small>(5236921)</small>
	</div>
</div>
</div>

<div class="col-md-4">
	<div class="product" title="ACCU CHEK ACTIVE 50 T. STRIP">
		<div class="product-img">
			<img class="w-100" src="{{ asset('images/product-01.jpg') }}" alt="">
		</div>
		<div class="product-details text-center">
			<span>ACCU CHEK ACTIVE</span> <br>
			<small>(5236921)</small>
		</div>
	</div>
</div>

<div class="col-md-4">
	<div class="product" title="ACCU CHEK ACTIVE 50 T. STRIP">
		<div class="product-img">
			<img class="w-100" src="{{ asset('images/product-01.jpg') }}" alt="">
		</div>
		<div class="product-details text-center">
			<span>ACCU CHEK ACTIVE</span> <br>
			<small>(5236921)</small>
		</div>
	</div>
</div>


<div class="col-md-4">
	<div class="product" title="ACCU CHEK ACTIVE 50 T. STRIP">
		<div class="product-img">
			<img class="w-100" src="{{ asset('images/product-01.jpg') }}" alt="">
		</div>
		<div class="product-details text-center">
			<span>ACCU CHEK ACTIVE</span> <br>
			<small>(5236921)</small>
		</div>
	</div>
</div>


<div class="col-md-4">
	<div class="product" title="ACCU CHEK ACTIVE 50 T. STRIP">
		<div class="product-img">
			<img class="w-100" src="{{ asset('images/product-01.jpg') }}" alt="">
		</div>
		<div class="product-details text-center">
			<span>ACCU CHEK ACTIVE</span> <br>
			<small>(5236921)</small>
		</div>
	</div>
</div>


<div class="col-md-4">
	<div class="product" title="ACCU CHEK ACTIVE 50 T. STRIP">
		<div class="product-img">
			<img class="w-100" src="{{ asset('images/product-01.jpg') }}" alt="">
		</div>
		<div class="product-details text-center">
			<span>ACCU CHEK ACTIVE</span> <br>
			<small>(5236921)</small>
		</div>
	</div>
</div>


<div class="col-md-4">
	<div class="product" title="ACCU CHEK ACTIVE 50 T. STRIP">
		<div class="product-img">
			<img class="w-100" src="{{ asset('images/product-01.jpg') }}" alt="">
		</div>
		<div class="product-details text-center">
			<span>ACCU CHEK ACTIVE</span> <br>
			<small>(5236921)</small>
		</div>
	</div>
</div>


<div class="col-md-4">
	<div class="product" title="ACCU CHEK ACTIVE 50 T. STRIP">
		<div class="product-img">
			<img class="w-100" src="{{ asset('images/product-01.jpg') }}" alt="">
		</div>
		<div class="product-details text-center">
			<span>ACCU CHEK ACTIVE</span> <br>
			<small>(5236921)</small>
		</div>
	</div>
</div>


<div class="col-md-4">
	<div class="product" title="ACCU CHEK ACTIVE 50 T. STRIP">
		<div class="product-img">
			<img class="w-100" src="{{ asset('images/product-01.jpg') }}" alt="">
		</div>
		<div class="product-details text-center">
			<span>ACCU CHEK ACTIVE</span> <br>
			<small>(5236921)</small>
		</div>
	</div>
</div>

<div class="col-md-4">
	<div class="product" title="ACCU CHEK ACTIVE 50 T. STRIP">
		<div class="product-img">
			<img class="w-100" src="{{ asset('images/product-01.jpg') }}" alt="">
		</div>
		<div class="product-details text-center">
			<span>ACCU CHEK ACTIVE</span> <br>
			<small>(5236921)</small>
		</div>
	</div>
</div>

<div class="col-md-4">
	<div class="product" title="ACCU CHEK ACTIVE 50 T. STRIP">
		<div class="product-img">
			<img class="w-100" src="{{ asset('images/product-01.jpg') }}" alt="">
		</div>
		<div class="product-details text-center">
			<span>ACCU CHEK ACTIVE</span> <br>
			<small>(5236921)</small>
		</div>
	</div>
</div>

<div class="col-md-4">
	<div class="product" title="ACCU CHEK ACTIVE 50 T. STRIP">
		<div class="product-img">
			<img class="w-100" src="{{ asset('images/product-01.jpg') }}" alt="">
		</div>
		<div class="product-details text-center">
			<span>ACCU CHEK ACTIVE</span> <br>
			<small>(5236921)</small>
		</div>
	</div>
</div>

<div class="col-md-4">
	<div class="product" title="ACCU CHEK ACTIVE 50 T. STRIP">
		<div class="product-img">
			<img class="w-100" src="{{ asset('images/product-01.jpg') }}" alt="">
		</div>
		<div class="product-details text-center">
			<span>ACCU CHEK ACTIVE</span> <br>
			<small>(5236921)</small>
		</div>
	</div>
</div>

<div class="col-md-4">
	<div class="product" title="ACCU CHEK ACTIVE 50 T. STRIP">
		<div class="product-img">
			<img class="w-100" src="{{ asset('images/product-01.jpg') }}" alt="">
		</div>
		<div class="product-details text-center">
			<span>ACCU CHEK ACTIVE</span> <br>
			<small>(5236921)</small>
		</div>
	</div>
</div>

<div class="col-md-4">
	<div class="product" title="ACCU CHEK ACTIVE 50 T. STRIP">
		<div class="product-img">
			<img class="w-100" src="{{ asset('images/product-01.jpg') }}" alt="">
		</div>
		<div class="product-details text-center">
			<span>ACCU CHEK ACTIVE</span> <br>
			<small>(5236921)</small>
		</div>
	</div>
</div>
</div>
</div>
</div>
</div>
</div> --}}
</div>
</div>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
	// 		$("#item_name").focus();
	// openItemAutocomplete("#item_name", "#item_hidn");




	$(document).ready(function() {
		$("#sidebar-left").addClass("active");
		$("#content").addClass("active");

		$('.date_picker').datepicker({
			format: 'dd/mm/yyyy',
			autoclose: true,
			todayHighlight: true,
			clearBtn: true,


		});

		$('#example').DataTable({
			"scrollY": "150px",
			"scrollCollapse": true,
			"paging": false,
			"searching": false,
			"ordering": false,
			"info": false
		});

		var quantitiy = 0;
		$('.quantity-right-plus').on("click", function(e) {

			// Stop acting like a button
			e.preventDefault();

			// Get the field name
			var quantity = parseInt($('.input-number').val());

			// If is not undefined

			$(this).siblings('.input-number').val(quantity + 1);
			// $('.input-number').val(quantity + 1);

			// Increment
		});

		$('.quantity-left-minus').on("click", function(e) {
			// Stop acting like a button
			e.preventDefault();
			// Get the field name
			var quantity = parseInt($('.input-number').val());

			// If is not undefined

			// Increment
			if (quantity > 0) {
				// $('.input-number').val(quantity - 1);
				$(this).siblings('.input-number').val(quantity - 1);
			}
		});
	});

	// for Fullscreen
	var elem = document.getElementById("mypos");

	function openFullscreen() {
		if (elem.requestFullscreen) {
			elem.requestFullscreen();
		} else if (elem.webkitRequestFullscreen) {
			/* Safari */
			elem.webkitRequestFullscreen();
		} else if (elem.msRequestFullscreen) {
			/* IE11 */
			elem.msRequestFullscreen();
		}
	}


	//Auto Complete

	$(".item_typehead").each(function() {
		var input_type = $(this).attr("id");

		$(this).typeahead({
			hint: true,
			highlight: true,
			minLength: 1
		}, {
			limit: 'Infinity',
			async: true,
			source: function(query, processSync, processAsync) {
				return $.ajax({
					url: "{{ route('get-item-name') }}",
					type: 'POST',
					data: {
						query: query
					},
					dataType: 'json',
					success: function(result) {
						return processAsync(result);
					}
				});
			},
			display: 'item_name',
			templates: {
				suggestion: function(item) {
					if (input_type == "item_code") {
						return '<div id="user-selection" class="clearfix border-bottom">' +
							'<div style="display:block"><strong>' + item.item_code + '</strong> - ' + item.item_name + '</div></div>';
					} else {
						return '<div id="user-selection" class="clearfix border-bottom">' +
							'<div style="display:block">' + item.item_name + ' - <strong>' + item.item_code + '</strong>' + '</div></div>';
					}

				}
			}

		}).bind("typeahead:selected", function(obj, item, name) {
			var total = item.item_rate;
			var sl = $("#billing_table-body tr").length + 1
			var table_row = "<tr><td class='text-center bg-light' style='width:2%'>" + sl + "<input class='item_id' type='hidden' name='hdn_item_id[]' value='" + item.item_id + "' ><input class='hdn_item_name' type='hidden' name='hdn_item_name[]' value='" + item.item_name + "'><input class='hdn_item_type' type='hidden' name='hdn_item_type[]' value='" + item.item_type + "'> </td>  <td class='text-left'><strong>" + item.item_code + " - </strong> " + item.item_name + "</td><td class='text-center qnty-width'><input type='text' class='form-control mb-0 text-right' name='item_rate[]' id='item_rate_" + item.item_id + "' value='" + item.item_rate + "' disabled='disabled' ><input type='hidden' class='form-control mb-0 text-right' name='hdn_item_rate[]' id='hdn_item_rate_" + item.item_id + "' value='" + item.item_rate + "' readonly='readonly' ></td><td class='text-center qnty-width'><input type='text' class='form-control mb-0 text-right' onkeyup='billingEngine.calculateItemTotal(this);billingEngine.calculateTotal(this)' id='hdn_item_qnty_" + item.item_id + "' name='hdn_item_qnty[]' value='1' ></td><td class='text-center qnty-width'><input type='text' class='form-control mb-0 text-right item_total_amt disabled' name='hdn_item_total_qnty[]' id='hdn_item_total_qnty_" + item.item_id + "' value='" + total + "' disabled='disabled' ></td> <td></td><td class='text-center' style='width:3%'><span class='btn btn-sm btn-danger' data-id='' onclick='removeTableRowOnly(this)' data-url='' title='Cancel this appointment'><i class='oi oi-circle-x'></i></span></td></tr>";

			if ($("#billing_table-body tr").length >= 1) {
				$("#billing_table-body").append(table_row);
			} else {
				$("#billing_table-body").html(table_row);
			}

			billingEngine.calculateTotal(this);
			$('#item_code').typeahead('val', '');
			$('#item_name').typeahead('val', '');

		});
	});
</script>
