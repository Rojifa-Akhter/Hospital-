<div class="p-2">
	<form method="post" action="{{ route('billing.store') }}" id="frmBilling" onsubmit="">
		<!-- title row -->
		<div class="row">
			<div class="col-12">
				<div class="table-responsive bg-light rounded border">
					<table class="table table-borderless mb-0">
						<tbody>
							<tr>
								<td><strong>PID :</strong> {{ $consultation_details->patient_code }}</td>
								<td><strong>Name :</strong> {{ $consultation_details->patient_name }}</td>
								<td><strong>Gender :</strong> {{ $consultation_details->gender_txt }}</td>
								<td><strong>Age :</strong> {{ $consultation_details->age }}</td>
							</tr>
						</tbody>
					</table>
				</div>

			</div>
			<!-- /.col -->
		</div>

		<!-- Table row -->
		<div class="row my-3">
			<div class="col-12 table-responsive">
				<table class="table table-striped">
					<thead>
						<tr>
							<th width="8%">Serial #</th>
							<th>Service Name</th>
							<th class="text-right">Quantity</th>
							<th class="text-right">Price (Taka)</th>
							<th class="text-right">Amount (Taka)</th>
						</tr>
					</thead>
					<tbody id="billing_table-body">
						@php
						$service_ids 	= explode(",", $consultation_details->selected_service_no);
						$service_names 	= explode(",", $consultation_details->selected_service_name);
						$item_total = $discount = 0;
						@endphp

						@if(!empty($service_ids))
						@for($i=0; $i<sizeof($service_ids); $i++)
						<tr>
							<td class="text-center">{{ $i+1 }}</td>
							<td>
								{{ $service_names[$i] }}
								<input type="hidden" name="hdn_item_id[]" value="{{ $service_ids[$i] }}">
								<input type="hidden" name="hdn_item_name[]" value="{{ $service_names[$i] }}">
								<input type="hidden" name="hdn_item_type[]" value="1">
								<input type="hidden" name="hdn_item_rate[]" value="{{ number_format($item_arr[$service_ids[$i]],2,".","") }}">
								<input type="hidden" name="hdn_item_dept_id[]" value="0">
								<input type="hidden" name="hdn_item_qnty[]" value="1">
								<input type="hidden" name="item_delivery_status[]" value="0">
								<input type="hidden" name="hdn_item_deli_date[]" value="">
								<input type="hidden" name="hdn_item_total_qnty[]" value="{{ number_format($item_arr[$service_ids[$i]],2,".","") }}">
							</td>
							<td class="text-right">1</td>
							<td class="text-right">{{ number_format($item_arr[$service_ids[$i]],2,".","") }}</td>
							<td class="text-right">{{ number_format($item_arr[$service_ids[$i]],2,".","") }}</td>
						</tr>
						@php $item_total += $item_arr[$service_ids[$i]] @endphp
						@endfor
						@endif
					</tbody>
				</table>
			</div>
			<!-- /.col -->
		</div>
		<!-- /.row -->

		<div class="row">
			<!-- accepted payments column -->
			<div class="col-8">

			</div>
			<!-- /.col -->
			<div class="col-4">
				<div class="table-responsive">
					<table class="table border bg-light">
						<tbody>
							<tr>
								<th style="width:50%">Item Total</th>
								<td class="text-right">
									{{ number_format($item_total,2,".","") }}
									<input type="hidden" id="hdn_item_total" value="{{ number_format($item_total,2,".","") }}">
								</td>
							</tr>
							<tr>
								<th>Payment</th>
								<td><input type="text" class="form-control text-right number_only" name="total_payment" id="total_payment" style="margin-bottom: 0 !important" onkeyup="schedulerEngine.calculatePayment(this)" ></td>
							</tr>
							<tr class="border-bottom">
								<th>Due</th>
								<td><input type="text" class="form-control text-right" name="total_due" id="total_due" style="margin-bottom: 0 !important" readonly="readonly"></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<!-- /.col -->
		</div>
		<!-- /.row -->

		<!-- this row will not appear when printing -->
		<div class="row no-print">
			<div class="col-8"></div>
			<div class="col-4">
				<input type="hidden" name="patient_type" value="0" readonly="readonly">
				<input type="hidden" name="hdn_patient_id" value="{{ $consultation_details->patient_no_fk }}" readonly="readonly">
				<input type="hidden" name="patient_id" value="{{ $consultation_details->patient_code }}" readonly="readonly">
				<input type="hidden" name="service_appointment_id" value="{{ $schedule_id }}" readonly="readonly">
				<input type="hidden" name="prescription_id" value="{{ $consultation_details->prescription_no_fk }}" readonly="readonly">
				<input type="hidden" name="hdn_doctor_id" value="0" readonly="readonly">
				<input type="hidden" name="hdn_first_referral_id" value="0" readonly="readonly">
				<input type="hidden" name="hdn_second_referral_id" value="0" readonly="readonly">
				<input type="hidden" name="cmb_discount" value="0" readonly="readonly">
				<input type="hidden" name="discount_percent_hospital" value="0" readonly="readonly">
				<input type="hidden" name="discount_percent_doctor" value="0" readonly="readonly">
				<input type="hidden" name="discount_amount_hospital" value="0" readonly="readonly">
				<input type="hidden" name="discount_amount_doctor" value="0" readonly="readonly">
				<input type="hidden" name="pay_mode" value="0" readonly="readonly">
				<input type="hidden" name="pay_amount" value="0" readonly="readonly">
				<input type="hidden" name="given_amount" value="0" readonly="readonly">
				<input type="hidden" name="change_amount" value="0" readonly="readonly">
				<input type="hidden" name="item_vat" value="0" readonly="readonly">
				<input type="hidden" name="urgent_fee" value="0" readonly="readonly">
				<input type="hidden" name="s_charge" value="0" readonly="readonly">
				<input type="hidden" name="total_discount_amount" value="0" readonly="readonly">
				<input type="hidden" name="discount_remarks" value="0" readonly="readonly">
				<input type="hidden" name="total_payable" value="{{ $item_total-$discount }}" readonly="readonly">
				@php $bill_id = ""; @endphp
				<span class="btn btn-md btn-block btn-success" data-response-action="{{ route('physiotherapy.service-consultation-invoice', $bill_id) }}" onclick="schedulerEngine.createConsultation(this);" >Create Bill</span>
			</div>
		</div>
	</form>
</div>