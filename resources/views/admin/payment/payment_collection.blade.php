<style>
	
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

	.full_vat .inputVat {

	}

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

	.right_side .due_total {
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


	.right_side .due_amount {
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

	.right_side .total_due {
		border-radius: 5px;
		background-color: #ffa11e;
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

	.right_side input{
		border: 1px solid #003b6169;
	}

	.right_side .recived_amount {
		height: 38px !important;
		font-size: 26px !important;
		text-align: right;
		background-color: #d3edfb!important;
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

	.pay_bill{
		margin-top: 155px;
	}

	.custom-select {
		height: calc(1.9em + 0.2rem + 0px) !important;
		line-height: 1 !important;
		font-size: 0.75rem !important;
	}

	.right_side .form-control{
		margin-bottom: 0px!important;
	}
</style>



<div class="container-fluid">
	<div class="form-row bg-white border-bottom sticky-top shadow-sm">
		<div class="col-md-12 mb-1">
			<h5 class="mt-2 mb-0">Payment Collection</h5>
			<small>Payment / Payment Collection</small>
		</div>
	</div>

	<div class="form-row">
		@if(!empty($patient_info))
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-6">
			<div class="card">
				<div class="card-header"><h5><i class="fa fa-user"></i>&nbsp; Patient information</h5></div>
				<div class="card-body border-bottom-3 p-2 d-flex align-items-center">
					<div class="patient-infos">
						<table class="table mb-0 table-borderless">
							<tbody>
								<tr>
									<th class="text-left">Name</th>
									<td colspan="3"  class="text-left">{{ $patient_info->patient_name_rank }}</td>
								</tr>
								<tr>
									<th class="text-left">Base</th>
									<td colspan="3" class="text-left">{{ $patient_info->base_name }}</td>
								</tr>
								<tr>
									<th class="text-left">Age</th>
									<td class="text-left">{{ $patient_info->age }}</td>
									<th class="text-left">Gender</th>
									<td class="text-left">{{ $patient_info->gender_txt }}</td>
								</tr>
								<tr>
									<th class="text-left">Blood Group</th>
									<td class="text-left">{{ $patient_info->blood_group }}</td>
									<th class="text-left">Marital Status</th>
									<td class="text-left">{{ $patient_info->marital_status_txt }}</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="patient-img text-center">
						@if($patient_info->patient_photo != "")
						<img class="w-75 rounded" src="{{ asset('img/uploads/patient_images/thumb/') }}/{{ $patient_info->patient_photo }}" alt="">
						@else
						@if($patient_info->gender_txt == "Male")
						<img class="w-75 rounded" src="{{ asset('img/boy.jpg') }}" alt="">
						@else
						<img class="w-75 rounded" src="{{ asset('img/girl.jpg') }}" alt="">
						@endif
						@endif
					</div>
				</div>
			</div>
		</div>

		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-6">
			<div class="card">
				<div class="card-header"><h5><i class="fa fa-user"></i>&nbsp; C/O information</h5></div>
				<div class="card-body border-bottom-3 p-2 d-flex align-items-center">
					<div class="patient-infos">
						<table class="table mb-0 table-borderless">
							<tbody>
								<tr>
									<th class="text-left">Name</th>
									<td colspan="3"  class="text-left">{{ $patient_info->ref_patient_name_rank }}</td>
								</tr>

								<tr>
									<th class="text-left">Base</th>
									<td colspan="3" class="text-left">{{ isset($patient_info->ref_patient_base)?$patient_info->ref_patient_base:'' }}</td>
								</tr>

								<tr>
									<th class="text-left">Age</th>
									<td class="text-left">{{ isset($patient_info->ref_age)?$patient_info->ref_age:'' }}</td>
									<th class="text-left">Gender</th>
									<td class="text-left">{{ isset($patient_info->ref_patient_gender)?$patient_info->ref_patient_gender:'' }}</td>
								</tr>


								<tr>
									<th class="text-left">Blood Group</th>
									<td class="text-left">{{ isset($patient_info->ref_blood_group)?$patient_info->ref_blood_group:'' }}</td>
									<th class="text-left">Relationship</th>
									<td class="text-left">{{ $patient_info->pat_relation }}</td>
								</tr>

							</tbody>
						</table>
					</div>

					<div class="patient-img text-center">
						@if($patient_info->patient_photo != "")
						<img class="w-75 rounded" src="{{ asset('img/uploads/patient_images/thumb/') }}/{{ $patient_info->patient_photo }}" alt="">
						@else
						@if($patient_info->gender_txt == "Male")
						<img class="w-75 rounded" src="{{ asset('img/boy.jpg') }}" alt="">
						@else
						<img class="w-75 rounded" src="{{ asset('img/girl.jpg') }}" alt="">
						@endif
						@endif
					</div>
				</div>
			</div>
		</div>
		@endif
	</div>

	<div class="form-row">
		<div class="col-md-9">
			<div class="card">
				<div class="card-body">
					<div class="form-row mt-2">
						<div class="col-md-12">
							<table class="table table-striped table-bordered table-hover mb-0">
								<thead class="bg-primary">
									<tr>
										<th class="text-center">SL</th>
										<th class="text-center">Type</th>
										<th class="text-center">Item Code</th>
										<th class="text-left">Name</th>
										<th class="text-center">Qty</th>
										<th class="text-right">Rate</th>
										<th class="text-right">Total</th>
										<th class="text-center">Action</th>
									</tr>
								</thead>

								<tbody>
									<tr>
										<td class="text-center">01</td>
										<td class="text-left"></td>
										<td class="text-center">Item-01221552</td>
										<td class="text-center">Item-Radiology-012365785</td>
										<td class="text-left">X-Ray</td>
										<td class="text-center">01</td>
										<td class="text-right">1200</td>
										<td class="text-right">1200</td>
										<td></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>

				</div>
			</div>
		</div>

		<div class="col-md-3">
			<div class="card">
				<div class="card-body p-2">
					<div class="right_side">
						<div class="form-row">
							<div class="form-group col-md-12">
								<div class="input-group">
									<div class="input-group-prepend">
										<label class="input-group-text" for="patient_type">Patient Type</label>
									</div>
									<select class="custom-select" id="patient_type" name="patient_type">
										<option value="">Select Patient Type</option>
										<option value="">Patient Type-1</option>
										<option value="">Patient Type-2</option>
									</select>
								</div>
							</div>

							<div class="form-group col-md-12">
								<div class="input-group">
									<div class="input-group-prepend">
										<label class="input-group-text" for="cash_point">Cash Point</label>
									</div>
									<select class="custom-select" id="cash_point" name="cash_point">
										<option value="">Cash Point</option>
										<option value="">Cash Point</option>
										<option value="">Cash Point</option>
									</select>
								</div>
							</div>

							<div class="form-group col-md-12">
								<div class="input-group">
									<div class="input-group-prepend">
										<label class="input-group-text" for="payment_discount">Discount</label>
									</div>
									<input type="text" class="form-control form-control-sm m-0 text-right" id="payment_discount" name="payment_discount" value="" placeholder="0.00">


									<div class="input-group-prepend">
										<label class="input-group-text" for="discount_amount">%</label>
									</div>
									<input type="text" class="form-control form-control-sm m-0 text-right" id="discount_amount" name="discount_amount" value="" placeholder="0.00">
								</div>
							</div>
						</div>

						<div class="total_payment d-flex align-items-center justify-content-between mt-3">
							<span class="total-price">Total Amount <small>(Tk)</small> :</span> <span class="amount"> 1790.00</span>
						</div>

						<div class="total_payment d-flex align-items-center justify-content-between">
							<span class="total-price">Discount <small>(Tk)</small> :</span> <span class="amount"> 1790.00</span>
						</div>

						<div class="total_price">
							<span class="price_total">Net Payable :</span> <span class="total_amount">1760.00</span>
						</div>

						<div class="sub_total d-flex align-items-center justify-content-between">
							<span class="sub_price">Paid Amount <small>(Tk)</small> :</span>
							<span class="sub_amount">1760.00</span>
						</div>

						<div class="total_due mt-1">
							<span class="due_total">Due Amount :</span> <span class="due_amount">1760.00</span>
						</div>


						<div class="form-group mt-3 pt-3" style="border-top: 1px solid #5eb8e2">
							<div class="input-group">
								<div class="input-group-prepend">
									<label class="input-group-text" for="pay_mode">Pay Mode</label>
								</div>
								<select class="custom-select" id="pay_mode" name="pay_mode">
									<option value="">Select Pay Mode</option>
									<option value="">Cash</option>
									<option value="">Cheque</option>
									<option value="">Card</option>
								</select>
							</div>
						</div>


						<div class="sub_total d-flex align-items-center justify-content-between">
							<span class="sub_price">Pay Amount <small>(Tk)</small> :</span>
							<span class="sub_amount">1760.00</span>
						</div>

						<div class="other_discount d-flex align-items-center justify-content-between mb-2">
							<label class="Inputlable" for="received_amount">Recived Amount <small>(Tk)</small> :</label>
							<input type="text" class="form-control" id="received_amount" placeholder="0.00" style="width:70px; text-align: right;">
						</div>

						<div class="main_change_amount d-flex align-items-center justify-content-between">
							<span class="change_total">Change <small>(Tk)</small>:</span>
							<span class="change_amount"> 790 <span>.00</span></span>
						</div>

						<div class="btn-group btn-group-toggle btn-block mt-3">
							<label class="btn btn-md btn-success">
								<input type="radio" name="options" id="option3">Save
							</label>
							<label class="btn btn-md btn-primary">
								<input type="radio" name="options" id="option3">Save & Print
							</label>

						</div>
					</div>

				</div>
			</div>
		</div>
	</div>


</div>