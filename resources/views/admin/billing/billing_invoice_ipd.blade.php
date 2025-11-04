<div>
	<div class="row">
		<div class="col-md-12">
			<div class="hospital_info text-center">
				<h5 class="mb-0">{{isset($po_hospital_details->hospital_name )? $po_hospital_details->hospital_name : ""}}</h5>
				<small>{{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : ""}}</small>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="card bg-light border">
				<div class="table-responsive">
					<table class="table table-borderless">
						<tbody>
							<tr style="border-bottom:2px solid #38C172">
								<th colspan="6" class="text-center no-line"><span class="btn btn-sm bg-primary btn-rounded">Customer Copy </span></th>
							</tr>
							<tr>
								<th class="w-10">PID:</th>
								<td class="text-left">{{ $invoice_mst_info->patient_code }}</td>
								<th class="text-right">Bill No:</th>
								<td class="text-left">{{ $invoice_mst_info->invoice_code }}</td>
								<th class="w-10 text-right">Date of invoice:</th>
								<td class="text-left">{{ date("d-m-Y", strtotime($invoice_mst_info->au_entry_at)) }}</td>
							</tr>
							<tr>
								<th>{{ ($invoice_mst_info->patient_name !=" ") ? "Name" : "" }}</th>
								<td colspan="4" class="text-left">{{ $invoice_mst_info->patient_name ? ucwords($invoice_mst_info->patient_name).' ( '. $invoice_mst_info->patient_type_code.' ) ' : "" }}</td>
							</tr>
							<tr>
                                @php
                                $pat_dob = new \DateTime($invoice_mst_info->dob);
                                $invoice_date = new \DateTime($invoice_mst_info->invoice_date);
                                $interval = $invoice_date->diff($pat_dob);
                            @endphp
								<th> {{ ( $invoice_mst_info->age != "") ? "Age:" : "" }}</th>
								<td colspan="4" class="text-left">{{ isset( $interval)?$interval->format('%yY %mM %dD'):'' }}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>{{ $invoice_mst_info->gender_txt ? "Gender:" : "" }} </strong> {{ $invoice_mst_info->gender_txt ? $invoice_mst_info->gender_txt : "" }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>{{ (( $invoice_mst_info->mobile1 != "") !="") ? "Contact:" : "" }}  </strong> {{( $invoice_mst_info->mobile1 != "") ? $invoice_mst_info->mobile1 : "" }}   &nbsp;&nbsp;&nbsp;&nbsp;<strong>{{ ($invoice_mst_info->present_addr !=" ") ? "Address: " : "" }}</strong> {{ $invoice_mst_info->present_addr ? $invoice_mst_info->present_addr : "" }} </td>
							</tr>
							 @if($invoice_mst_info->doctor_name !=" Self" && $invoice_mst_info->doctor_name !="")
							<tr>
								<th >Ref. Doctor:</th>
								<td colspan="4" class="text-left">{{ isset($invoice_mst_info->doctor_name)? ucwords($invoice_mst_info->doctor_name) : " " }}</td>
							</tr>
							@endif

							 @if($invoice_mst_info->first_doc_name !=" Self" && $invoice_mst_info->first_doc_name !=" ")

							<tr>
								<th >1st Ref:</th>
								<td colspan="4" class="text-left">{{ isset($invoice_mst_info->first_doc_name)? ucwords($invoice_mst_info->first_doc_name) : " " }}</td>
							</tr>
							@endif

								 @if($invoice_mst_info->second_doc_name !=" Self" && $invoice_mst_info->second_doc_name !=" ")
							<tr>
								<th >2nd Ref:</th>
								<td colspan="4" class="text-left">{{ isset($invoice_mst_info->second_doc_name)? ucwords($invoice_mst_info->second_doc_name) : " " }}</td>
							</tr>
							@endif
						<!-- <tr>
								<th >{{ isset($discout_by->full_name)? "Disc. By:" : "" }}</th>
								<td colspan="4" class="text-left">{{ isset($discout_by->full_name )? ucwords($discout_by->full_name) : "" }}{{ isset($ledgermst_paydisc->disc_amt_by_hosp ) && $ledgermst_paydisc->disc_amt_by_hosp !=0? "(".$ledgermst_paydisc->disc_amt_by_hosp ." "."Tk".")" : "" }} {{ isset($ledgermst_paydisc->disc_amt_by_doc )  && $ledgermst_paydisc->disc_amt_by_doc !=0 ? " , Doctor Disc. "."(".$ledgermst_paydisc->disc_amt_by_doc ." "."Tk".")" : "" }}</td>
							</tr> -->

							<tr>
								<th>{{ isset($ledgermst_paydisc->disc_amt_request_name )? "Disc. Request By" : "" }}</th>
								<td>{{ isset($ledgermst_paydisc->disc_amt_request_name )? $ledgermst_paydisc->disc_amt_request_name : "" }}</td>
							</tr>



						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table table-borderless" width="100%">
							<thead>
								<tr>
									<td class="w-5 bg-primary text-center"><strong>SL#</strong></td>
									<td class="text-left bg-primary"><strong>Item Description</strong></td>
									<!-- <td class="w-20 text-right bg-primary"><strong>Delivery Date</strong></td>
									<td class="w-20 text-right bg-primary"><strong>Delivery Status</strong></td> -->
									<!-- <td class="w-10 text-right bg-primary"><strong>Rate</strong></td> -->
									<!-- <td class="w-10 text-right bg-primary"><strong>Quantity</strong></td> -->
									<td class=" text-right bg-primary"  colspan="5"><strong>Amount(BDT)</strong></td>
								</tr>
							</thead>
							<tbody>
								@php
								$total = 0;

								@endphp
								@if(!empty($invoice_dtls_info))
								@foreach($invoice_dtls_info as $row)
								@php
								$urgent_fee=0;
								$item_rate =0;
								@endphp
								<tr>
									<td class="bg-light text-center">{{ sprintf("%02d", $loop->iteration)  }}</td>
									<td class="text-left"><strong>{{ $row->item_code }}</strong> {{ $row->item_name }}</td>

									<!-- <td class="text-right"> {{ ($row->report_delivery_date == '')? "": date("d/m/Y",strtotime($row->report_delivery_date)) }}</td> -->


<!--
									@if($row->delivery_status_lookup_no_fk == 1)
									<td></td>
									@php
									$item_rate = $row->item_rate;
									@endphp
									@elseif($row->delivery_status_lookup_no_fk == 2)
									<td class=" text-right"> Urgent </td>
									@php
									$urgent_fee=isset($row->urgent_fee)?$row->urgent_fee : "0" ;
									$item_rate = $row->item_rate + $urgent_fee;
									@endphp
									@else
									<td></td>
									@endif -->
									@php
									$item_rate = $row->item_rate;
									@endphp


									<!-- <td class="text-right" style='font-weight: bold'>{{ number_format($item_rate,2,".","") }}</td>									 -->
									<!-- <td class="text-right">{{ $row->item_qty }}</td> -->
									<td class="text-right bg-light"  colspan="5"> {{abs(number_format($total_sales->ledger_amt_payment,2,".",""))}}</td>
								</tr>
								@php
								$total += abs(number_format($total_sales->ledger_amt_payment,2,".",""));
								@endphp
								@endforeach
								@endif

								@php
								// $amt_in_word = new \NumberFormatter( 'en_US', \NumberFormatter::SPELLOUT);

								$vat =number_format($invoice_mst_info->ledger_amt_vat,2);
								$discount = number_format($total_dis->ledger_amt_discount,2,".","");
								//number_format($invoice_mst_info->ledger_amt_discount,2,".","");
								$urgent_fee = number_format($invoice_mst_info->urgent_fee,2,".","");
								$payment =  number_format($total_sales->ledger_amt_payment,2,".","");
								//number_format($ledger_pay_amount->pay_amount,2,".","");
								$payable = number_format((($total +$vat) - $discount),2,".","");
								$due = number_format(($payment),2,".","");
								$due=  $due;
								$number = ($total + $vat)  - $discount;
								$locale = 'en_US';
								$fmt = numfmt_create($locale, NumberFormatter::SPELLOUT);
								$in_words = numfmt_format($fmt, $due);
								@endphp



								<tr style="border-top:2px solid #38C172">
									<td class="no-line" colspan="5">

										@if(isset($paymood))
										<div style="margin-bottom: 3px"><span style="border-bottom:1px solid black; margin-bottom: 3px">Cash Receipt In</span> </div>
										@foreach($paymood as $value)
										@if($value->paymood !=null)
										@if($value->paymood == "CS")
										CASH  :  {{$value->pay_amount}}  ,

										@elseif($value->paymood == "Mbanking")
										 {{strtoupper($value->pay_mood_type)}} :  {{$value->pay_amount}}  ,


										@elseif($value->paymood == "CARD")
										CARD  ({{strtoupper($value->pay_mood_type)}}) :   {{$value->pay_amount}}  ,

										@else
										OTHERS :  {{$value->pay_amount}} ,
										@endif
										@endif
										@endforeach
										@endif
										<br>
										<strong>Remarks:</strong>{{ $invoice_mst_info->invoice_remarks }}
									</td>
									<td class="no-line text-right"><strong>Amount</strong></td>
									<td class="no-line text-right bg-light">{{ number_format(($total + $vat),2,".","") }}</td>
								</tr>
								 <tr>
									<td class="no-line" colspan="5"></td>
									<td class="no-line text-right"><strong>Urgent Fee</strong></td>
									<td class="no-line text-right bg-light">{{ number_format($urgent_fee,2,".","") }}</td>
								</tr>

							<!-- 	<tr>
									<td class="no-line" colspan="5"></td>
									<td class="no-line text-right"><strong>Urgent Fee</strong></td>
									<td class="no-line text-right bg-light">{{ number_format($invoice_mst_info->urgent_fee,2,".","") }}</td>
								</tr> -->
<!-- 								<tr>
									<td class="no-line" colspan="5"></td>
									<td class="no-line text-right"><strong>S. Charge</strong></td>
									<td class="no-line text-right bg-light">{{ number_format($invoice_mst_info->service_charge,2,".","") }}</td>
								</tr> -->
								<!-- <tr>
									<td class="no-line" colspan="5"></td>
									<td class="no-line text-right"><strong>(-) Discount</strong></td>
									<td class="no-line text-right bg-light">{{ number_format($discount,2,".","") }}</td>
								</tr> -->
								<!-- <tr>

									<td class="no-line" colspan="5"></td>
									<td class="no-line text-right"><strong>Bill Amount</strong></td>
									<td class="no-line text-right bg-light">{{ number_format($payable,2,".","") }}</td>
								</tr> -->
								<!-- <tr>
									<td class="no-line" colspan="5"> <strong>In Word: </strong>  {{ ucfirst($in_words) }} Taka  only</td>
									<td class="No-line text-right"><strong>Payment</strong></td>
									<td class="no-line text-right bg-light">{{ number_format($payment,2,".","") }}</td>
								</tr> -->
								<tr>

									<td class="no-line" colspan="5"></td>
									<td class="no-line text-right"><strong>
                                    @if($due < 0)
                                    Refund
                                    @else
                                    Advance
                                    @endif

                                    </strong></td>
									<td class="no-line text-right bg-light">{{ number_format(abs($due),2,".","") }}</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<hr />
	<div class="row">
		<div class="col-md-12">
			<?php $pos =  $page_type ? $page_type : ""; ?>
			@if(Session::get('user.ses_hospital_code') == "UNICO" || Session::get('user.ses_hospital_code') == "KPJ")
			<a href="{{ route('bill-invoice-ipd-print-v2',[$invoice_mst_info->invoice_no_pk , $pos]) }}" target="_blank" class="btn btn-warning btn-md" title="Click here to Clear form data">Print</a>
			@else
			<a href="{{ route('bill-invoice-ipd-print',[$invoice_mst_info->invoice_no_pk , $pos]) }}" target="_blank" class="btn btn-warning btn-md" title="Click here to Clear form data">Print</a>
			@endif
			<button type="reset" class="btn btn-danger btn-md" title="Click here to Clear form data" data-dismiss="modal">Close</button>
			<a href="{{ route('home') }}" class="btn btn-info btn-md" rel="tab" title="Click here to go back to Dashboard" data-dismiss="modal">Exit</a>
		</div>
	</div>
</div>
