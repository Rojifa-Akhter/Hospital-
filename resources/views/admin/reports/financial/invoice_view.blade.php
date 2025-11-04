
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="card bg-light border">
				<div class="table-responsive">
					<table class="table table-borderless">
						<tbody>
							<tr style="border-bottom:2px solid #38C172">
								<th colspan="6" class="text-center no-line"><span class="btn btn-sm bg-primary btn-rounded">Invoice Details</span></th>
							</tr>
							<tr>
								<th class="w-10">HN No.</th>
								<td class="text-left">H11905005090</td>
								<th class="text-right">Bill No.</th>
								<td class="text-left">{{ $invoice_mst_info->invoice_code }}</td>
								<th class="w-10 text-right">Date</th>
								<td class="text-left">{{ date("d-m-Y h:i:s a", strtotime($invoice_mst_info->au_entry_at)) }}</td>
							</tr>
							<tr>
								<th>Name</th>
								<td colspan="4" class="text-left">{{ $invoice_mst_info->patient_name }}</td>
							</tr>
							<tr>
								<th>Age</th>
								<td colspan="4" class="text-left">{{ $invoice_mst_info->age }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Gender: </strong> {{ $invoice_mst_info->gender_txt }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Contact: </strong> {{ $invoice_mst_info->mobile1 }}</td>
							</tr>
							<tr>
								<th>Ref. By</th>
								<td colspan="4" class="text-left">{{ $invoice_mst_info->first_ref_doc_name }}</td>
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
									<td class="w-5 bg-primary text-center"><strong>SL</strong></td>
									<td class="w-10 bg-primary"><strong>Code</strong></td>
									<td class="text-left bg-primary"><strong>Test Name</strong></td>
									<td class="w-10 text-center bg-primary"><strong>S.Room</strong></td>
									<td class="w-10 text-right bg-primary"><strong>Price (Tk.)</strong></td>
								</tr>
							</thead>
							<tbody>
								@php
								    $total = 0;
								@endphp
								{{-- @if(!empty($invoice_dtls_info))
                                    @foreach($invoice_dtls_info as $row)
                                        <tr>
                                            <td class="bg-light text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $row->item_code }}</td>
                                            <td class="text-left">{{ $row->item_name }}</td>
                                            <td class="text-center"></td>
                                            <td class="text-right bg-light">{{ number_format($row->item_qty*$row->item_rate,2,".","") }}</td>
                                        </tr>
                                        @php
                                        $total += ($row->item_qty*$row->item_rate);
                                        @endphp
                                    @endforeach
								@endif --}}

								@php
                                    // $amt_in_word = new \NumberFormatter( 'en_US', \NumberFormatter::SPELLOUT);

                                    $discount = number_format(0,2,".","");
                                    $payment = number_format($invoice_mst_info->ledger_amt_payment,2,".","");
                                    $payable = number_format(($total - $discount),2,".","");
                                    $due = number_format(($payable - $payment),2,".","");
								@endphp
								<tr style="border-top:2px solid #38C172">
									{{-- <td class="no-line" colspan="3"><strong>Remarks:</strong>{{ $invoice_mst_info->disc_remarks }}</td> --}}
									<td class="no-line text-right"><strong>Amount</strong></td>
									<td class="no-line text-right bg-light">{{ number_format($total,2,".","") }}</td>
								</tr>
								<tr>
									{{-- <td class="no-line" colspan="3"><strong>Delivery Date:</strong>{{ $invoice_mst_info->disc_remarks }}</td> --}}
									<td class="no-line text-right"><strong>VAT</strong></td>
									<td class="no-line text-right bg-light">{{ number_format($discount,2,".","") }}</td>
								</tr>
								<tr>
									<td class="no-line" colspan="3"></td>
									<td class="no-line text-right"><strong>(-) Discount</strong></td>
									<td class="no-line text-right bg-light">{{ number_format($discount,2,".","") }}</td>
								</tr>
								<tr>
									<td class="no-line" colspan="3"></td>
									<td class="no-line text-right"><strong>Urgent Fee</strong></td>
									<td class="no-line text-right bg-light">{{ number_format($invoice_mst_info->urgent_fee,2,".","") }}</td>
								</tr>
								<tr>
									<td class="no-line" colspan="3"></td>
									<td class="no-line text-right"><strong>S. Charge</strong></td>
									<td class="no-line text-right bg-light">{{ number_format($invoice_mst_info->service_charge,2,".","") }}</td>
								</tr>
								<tr>
									<td class="no-line"></td>
									<td class="no-line"></td>
									<td class="no-line"></td>
									<td class="no-line text-right"><strong>Payable</strong></td>
									<td class="no-line text-right bg-light">{{ number_format($payable,2,".","") }}</td>
								</tr>
								<tr>
									<td class="no-line" colspan="3">{{-- <strong>In Word: </strong> Taka {{ ucwords($amt_in_word->format($payable)) }} only --}}</td>
									<td class="no-line text-right"><strong>Payment</strong></td>
									<td class="no-line text-right bg-light">{{ number_format($payment,2,".","") }}</td>
								</tr>
								<tr>
									<td class="no-line"></td>
									<td class="no-line"></td>
									<td class="no-line"></td>
									<td class="no-line text-right"><strong>Due</strong></td>
									<td class="no-line text-right bg-light">{{ number_format($due,2,".","") }}</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="table-responsive w-50">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th scope="col">Payment Type</th>
									<th scope="col">Collected By</th>
									<th scope="col">Mode</th>
									<th scope="col">Amount</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>Initial Collection</td>
									<td>ADMIN</td>
									<td></td>
									<td>0.00</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div><strong>Prepared By:</strong> <span>ADMIN</span></div>
					<div><strong>Modified By:</strong> <span>ADMIN</span></div>
				</div>
			</div>
		</div>
	</div>
</div>