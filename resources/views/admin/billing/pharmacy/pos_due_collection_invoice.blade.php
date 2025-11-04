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
								<th colspan="6" class="text-center no-line"><span class="btn btn-sm bg-primary btn-rounded">Customer Copy</span></th>
							</tr>
							<tr>
                                @php
                                if (strtoupper(Session::get('user.ses_hospital_code')) == 'MCARE') {
                                 echo '<th class="w-10">Customer Id:</th>';
                              } else {
                                  echo  '<th class="w-10"> Patient ID :</th>';
                              }
                              @endphp

								<td class="text-left">{{ $invoice_mst_info->patient_code }}</td>
								<th class="text-right">Bill No.</th>
								<td class="text-left">{{ $invoice_mst_info->invoice_code }}</td>
								<th class="w-10 text-right">Date of invoice:</th>
								<td class="text-left">{{ date("d-m-Y ", strtotime($invoice_mst_info->au_entry_at)) }}</td>
							</tr>
							@if($invoice_mst_info->admission_no_pk !="")
							<tr>
							<th class="w-25">Admission ID :</th>
							<td>{{ $invoice_mst_info->admission_no_pk }}</td>
							</tr>
							@endif
							<tr>
								<th>{{ $invoice_mst_info->patient_name ? "Name" : "" }}</th>
								<td colspan="4" class="text-left">{{ ucwords($invoice_mst_info->patient_name) }}</td>
							</tr>
                            @if ($invoice_mst_info->admission_no_pk != '')

                            <tr>
								<th>{{ $invoice_mst_info->admission_no_pk ? "Admission ID" : "" }}</th>
								<td colspan="4" class="text-left">{{ $invoice_mst_info->admission_no_pk }}</td>
							</tr>
                        @endif

							<tr>
								<th>{{ $invoice_mst_info->age != 0 || $invoice_mst_info->age !=""? "Age":"" }}</th>
								<td colspan="4" class="text-left">{{ $invoice_mst_info->age != 0 || $invoice_mst_info->age !=""?$invoice_mst_info->age:"" }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>{{ $invoice_mst_info->gender_txt ? "Gender:" : "" }} </strong> {{ $invoice_mst_info->gender_txt }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>{{ $invoice_mst_info->mobile1 ? "Contact:" :""}} </strong> {{ $invoice_mst_info->mobile1 }} &nbsp;&nbsp;&nbsp;&nbsp;<strong> {{ ($invoice_mst_info->present_addr !="  ") ? "Address:" : ""}} </strong> {{ $invoice_mst_info->present_addr }} </td>
							</tr>
							@if($invoice_mst_info->doctor_name !="Self" && $invoice_mst_info->doctor_name !="")
							<tr>
								<th>Ref. Doctor:</th>
								<td colspan="4" class="text-left">{{ isset($invoice_mst_info->doctor_name)? ucwords($invoice_mst_info->doctor_name) : " " }}</td>
							</tr>
							@endif

							@if($invoice_mst_info->first_doc_name !="Self" && $invoice_mst_info->first_doc_name !=" ")

							<tr>
								<th>1st Ref:</th>
								<td colspan="4" class="text-left">{{ isset($invoice_mst_info->first_doc_name)? ucwords($invoice_mst_info->first_doc_name) : " " }}</td>
							</tr>
							@endif
							@if($invoice_mst_info->second_doc_name !="Self" && $invoice_mst_info->second_doc_name !=" ")
							<tr>
								<th>2nd Ref:</th>
								<td colspan="4" class="text-left">{{ isset($invoice_mst_info->second_doc_name)? ucwords($invoice_mst_info->second_doc_name) : " " }}</td>
							</tr>
							@endif
							<tr>
								<th>{{ isset($discout_by->full_name)? "Disc. By:" : "" }}</th>
								<td colspan="4" class="text-left">{{ isset($discout_by->full_name )? ucwords($discout_by->full_name) : "" }}{{ isset($ledgermst_paydisc->disc_amt_by_hosp ) && $ledgermst_paydisc->disc_amt_by_hosp !=0? "(".$ledgermst_paydisc->disc_amt_by_hosp ." "."Tk".")" : "" }} {{ isset($ledgermst_paydisc->disc_amt_by_doc )  && $ledgermst_paydisc->disc_amt_by_doc !=0 ? " , Doctor Disc. "."(".$ledgermst_paydisc->disc_amt_by_doc ." "."Tk".")" : "" }}</td>
							</tr>
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
						<table class="table table-borderless">
							<thead>
								<tr>
									<td class="w-5 bg-primary text-center"><strong>SL#</strong></td>
									<td class="text-left bg-primary"><strong>Item Description</strong></td>
									<td class="w-30  bg-primary"><strong>Expire Date</strong></td>
									<td class="w-10 text-right bg-primary"><strong>Rate</strong></td>
									<td class="w-10 text-right bg-primary"><strong>Quantity</strong></td>
									<td class="w-10 text-right bg-primary"><strong>Cancel Qty</strong></td>
									<td class="w-10 text-right bg-primary"><strong>Amount(BDT)</strong></td>
								</tr>
							</thead>
							<tbody>
								@php
								$totals = 0;

								@endphp
								@if(!empty($invoice_dtls_info))
								@foreach($invoice_dtls_info as $row)
								@php
								$urgent_fee=0;
								$item_rate =0;
								@endphp
								<tr>
									<td class="bg-light text-center">{{ sprintf("%02d", $loop->iteration)  }}</td>
									<td class="text-left"> {{ $row->item_name }}</td>
									<td class="text-left">
										@if(!empty($exp_date) )
										@foreach($exp_date as $data)

										@if($row->item_no_fk == $data->item_no_fk && $data->batch_no !="")
										{{$data->batch_no ? date('d-m-Y',strtotime($data->expiry_date)) : ""}} ,

										@endif
										@endforeach
										@endif
									</td>



									@php
									$item_rate = $row->item_rate;
									@endphp


									<td class="text-right" style='font-weight: bold'>{{ number_format($item_rate,2,".","") }}</td>
									<td class="text-right">{{ $row->item_qty }}</td>
									<td class="text-right">{{ $row->cancel_qty }}</td>
									<td class="text-right bg-light">{{ number_format($row->current_item_qty*$item_rate,2,".","") }}</td>
								</tr>
								@php

								@endphp
								@endforeach
								@endif

								@php
								// $totals= round($sub_total);
								// // $amt_in_word = new \NumberFormatter( 'en_US', \NumberFormatter::SPELLOUT);
								// $total = $total_item_rates->ledger_amt_sales;
								// $vat = number_format(0,2,".","");
								// $c_discounts =isset($c_discount->disc_amount) ? $c_discount->disc_amount : 0;
								// $c_dis_cancelations =isset($c_dis_cancelation->disc_amount) ? $c_dis_cancelation->disc_amount : 0;
								// $discount = number_format($c_discount->disc_amount,2,".","");
								// $urgent_fee = number_format($invoice_mst_info->urgent_fee,2,".","");
								// $payment = number_format($total_sales->ledger_amt_payment,2,".","");
								// $payable = number_format((($totals) - $discount),2,".","");
                                // $cancel_amt=number_format(($all_sub_total -  $totals),2,".","");
                                //     $due = number_format((($totals) - $payment),2,".","");
                                //     $due= round(($due- $discount) - $cancel_amt);
								// // $due = number_format(($payable - $payment),2,".","");
								// $number = number_format($totals - $discount,2,".","");
								// $locale = 'en_US';
								// $fmt = numfmt_create($locale, NumberFormatter::SPELLOUT);
								// $in_words = numfmt_format($fmt, $number);
                                $vat = number_format($finc_inv_sum_amount->ledger_amt_vat, 2, '.', '');
                                        $urgent_fee = number_format($finc_inv_sum_amount->urgent_fee, 2, '.', '');
                                        // $totals = $sub_total + $vat + $urgent_fee;
                                        // $totals = $finc_inv_sum_amount->ledger_amt_sales ;
                                        $totals = $finc_inv_sum_amount->sales;

                                        // $discount = number_format($c_discount->disc_amount, 2, '.', '');

                                        $discount = number_format($finc_inv_sum_amount->discount, 2, '.', '');
                                        $cancel_discount = number_format($finc_inv_sum_amount->cancel_discount, 2, '.', '');
                                        // $payment = number_format($finc_vouchermas_sum->collection, 2, '.', '');
                                        $payment = number_format($finc_inv_sum_amount->collection, 2, '.', '');
                                        // $payable = number_format($totals - $discount, 2, '.', '');
                                        $payable_total = $totals - ($discount + $finc_inv_sum_amount->sales_cancel);
                                        $payable = number_format($payable_total, 2, '.', '');
                                        // $due = number_format($totals - $discount - $payment, 2, '.', '');
                                        $due = round(number_format($payable - $finc_inv_sum_amount->net_collection, 2, '.', ''));
                                        $refund = number_format($finc_inv_sum_amount->refund, 2, '.', '');
                                        // $due = $due - $discount;
                                        // dd($due ,$payment ,  $payable ,  $totals );
                                        // $number = $totals - $discount;
                                        $number = $payable;
                                        $locale = 'en_US';
                                        $fmt = numfmt_create($locale, NumberFormatter::SPELLOUT);
                                        $in_words = numfmt_format($fmt, $number);
                                        $to_date = date('Y-m-d');
								@endphp
								<tr style="border-top:2px solid #38C172">
									<td class="no-line" colspan="4">
										@if(!empty($paymood))

										<div style=" margin-bottom: 5px"><span style="border-bottom:1px solid black">Cash Receipt In</span> </div>
										@foreach($paymood as $value)


										@if($value->paymood == "CASH")
										CASH : {{$value->pay_amount}} ,

										@elseif($value->paymood == "Mbanking")
										{{strtoupper($value->pay_mood_type)}} : {{$value->pay_amount}} ,


										@elseif($value->paymood == "CARD")
										CARD ({{strtoupper($value->pay_mood_type)}}) : {{$value->pay_amount}} ,

										@else
										OTHERS : {{$value->pay_amount}} ,
										@endif

										@endforeach
										@endif
										<br>

										<strong>Remarks:</strong>{{ $invoice_mst_info->invoice_remarks }}
									</td>
									<td class="no-line text-right" colspan="2"><strong>Total Sales Amount</strong></td>
									<td class="no-line text-right bg-light">{{ number_format($totals,2,".","") }}</td>
								</tr>
                                <tr>
									<td class="no-line" colspan="4"></td>
									<td class="no-line text-right" colspan="2"><strong> Total Discount</strong></td>
									<td class="no-line text-right bg-light">{{ number_format($discount,2,".","") }}</td>
								</tr>
								{{-- <tr>
									<td class="no-line" colspan="4"></td>
									<td class="no-line text-right" colspan="2"><strong>Urgent Fee</strong></td>
									<td class="no-line text-right bg-light">{{ number_format($invoice_mst_info->urgent_fee,2,".","") }}</td>
								</tr> --}}



								<tr>

									<td class="no-line" colspan="4"></td>
									<td class="no-line text-right" colspan="2"><strong>Payable</strong></td>
									<td class="no-line text-right bg-light">{{ number_format($payable,2,".","") }}</td>
								</tr>
								<tr>
									<td class="no-line" colspan="4"> <strong>In Word: </strong> {{ ucfirst($in_words) }} Taka only</td>
									<td class="No-line text-right" colspan="2"><strong>Payment</strong></td>
									<td class="no-line text-right bg-light">{{ ($finc_inv_collection_amount->collection != "") ? number_format($finc_inv_collection_amount->collection,2,".","") : 0.00 }}</td>
								</tr>
								<tr>
									<td class="no-line" colspan="4"></td>
									<td class="no-line text-right" colspan="2"><strong>Total Paid</strong></td>
									<td class="no-line text-right bg-light">{{ number_format($payment,2,".","") }}</td>
								</tr>


								<tr>
									@if($due >= 0 && $refund == 0)
									<td class="no-line" colspan="4"></td>
									<td class="no-line text-right" colspan="2"><strong>Due</strong></td>
									<td class="no-line text-right bg-light">{{ number_format($due,2,".","") }}</td>
									@endif

									@if($refund > 0)

                                        <td class="no-line" colspan="4">
										</td>
										<td class="no-line text-right" colspan="2"><strong>Cash Refund</strong> <br><strong>Total Refund</strong></td>
                                       <td class="no-line text-right">{{ number_format(abs($finc_inv_collection_amount->refund ), 2, '.', '') }} <br>
                                        {{ number_format(abs($refund), 2, '.', '') }}</td>
								    @endif
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
			<a href="{{ route('due-invoice-pos-print-pos',[$invoice_mst_info->invoice_no_pk , $finc_inv_collection_amount->ledgertrn_no_pk]) }}" target="_blank" class="btn btn-warning btn-md" title="Click here to Clear form data">POS</a>
			@if(Session::get('user.ses_hospital_code') == "UNICO" || Session::get('user.ses_hospital_code') == "KPJ")
			<a href="{{ route('pos-due-invoice-print-v2',[$invoice_mst_info->invoice_no_pk , $finc_inv_collection_amount->ledgertrn_no_pk]) }}" target="_blank" class="btn btn-warning btn-md" title="Click here to Clear form data">Print</a>
			@else
			<a href="{{ route('pos-due-invoice-print',[$invoice_mst_info->invoice_no_pk , $finc_inv_collection_amount->ledgertrn_no_pk]) }}" target="_blank" class="btn btn-warning btn-md" title="Click here to Clear form data">Print</a>
			 @endif
			
			<button type="reset" class="btn btn-danger btn-md" title="Click here to Clear form data" data-dismiss="modal">Close</button>
			<a href="{{ route('home') }}" class="btn btn-info btn-md" rel="tab" title="Click here to go back to Dashboard" data-dismiss="modal">Exit</a>
		</div>
	</div>
</div>
