<div>
    <div class="row">
        <div class="col-md-12">
            <div class="hospital_info text-center">
                <h5 class="mb-0">
                    {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}</h5>
                <small>{{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</small>
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
                                <th colspan="6" class="text-center no-line"><span
                                        class="btn btn-sm bg-primary btn-rounded">Customer Copy</span></th>
                            </tr>
                            <tr>
                                <th class="w-10">PID</th>
                                <td class="text-left">{{ $invoice_mst_info->patient_code }}</td>
                                <th class="text-right">Bill No.</th>
                                <td class="text-left">{{ $invoice_mst_info->invoice_code }}</td>
                                <th class="w-10 text-right">Date of invoice:</th>
                                <td class="text-left">{{ date('d-m-Y ', strtotime($invoice_mst_info->au_entry_at)) }}
                                </td>
                            </tr>
                            @if ($invoice_mst_info->admission_no_pk != '')
                                <tr>
                                    <th class="w-25">Admission ID :</th>
                                    <td>{{ $invoice_mst_info->admission_no_pk }}</td>
                                </tr>
                            @endif
                            <tr>
                                <th>{{ $invoice_mst_info->patient_name != '' ? 'Name:' : '' }}</th>
                                <td colspan="4" class="text-left">
                                    {{ ucwords($invoice_mst_info->patient_name) . ' ( ' . $invoice_mst_info->patient_type_code . ' ) ' }}
                                </td>
                            </tr>
                            <tr>
                                @php
                                    $pat_dob = new \DateTime($invoice_mst_info->dob);
                                    $invoice_date = new \DateTime($invoice_mst_info->invoice_date);
                                    $interval = $invoice_date->diff($pat_dob);
                                @endphp
                                <th>{{ $invoice_mst_info->age != '' ? 'Age:' : '' }}</th>
                                <td colspan="4" class="text-left">
                                    {{ isset($interval) ? $interval->format('%yY %mM %dD') : '' }}
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>{{ $invoice_mst_info->gender_txt != '' ? 'Gender:' : '' }}
                                    </strong> {{ $invoice_mst_info->gender_txt }}
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>{{ $invoice_mst_info->mobile1 != '' ? 'Contact:' : '' }}
                                    </strong> {{ $invoice_mst_info->mobile1 }}
                                    &nbsp;&nbsp;&nbsp;&nbsp;<strong>{{ $invoice_mst_info->present_addr != '' ? 'Address:' : '' }}
                                    </strong> {{ $invoice_mst_info->present_addr }} </td>
                            </tr>
                            @if ($invoice_mst_info->doctor_name != 'Self' && $invoice_mst_info->doctor_name != '')
                                <tr>
                                    <th>Ref. Doctor:</th>
                                    <td colspan="4" class="text-left">
                                        {{ isset($invoice_mst_info->doctor_name) ? ucwords($invoice_mst_info->doctor_name) : ' ' }}
                                    </td>
                                </tr>
                            @endif

                            @if ($invoice_mst_info->first_doc_name != 'Self' && $invoice_mst_info->first_doc_name != ' ')
                                <tr>
                                    <th>1st Ref:</th>
                                    <td colspan="4" class="text-left">
                                        {{ isset($invoice_mst_info->first_doc_name) ? ucwords($invoice_mst_info->first_doc_name) : ' ' }}
                                    </td>
                                </tr>
                            @endif
                            @if ($invoice_mst_info->second_doc_name != 'Self' && $invoice_mst_info->second_doc_name != ' ')
                                <tr>
                                    <th>2nd Ref:</th>
                                    <td colspan="4" class="text-left">
                                        {{ isset($invoice_mst_info->second_doc_name) ? ucwords($invoice_mst_info->second_doc_name) : ' ' }}
                                    </td>
                                </tr>
                            @endif
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
                                    <td class=" text-right bg-primary"><strong>Delivery Date</strong></td>
                                    <td class=" text-right bg-primary"><strong>Delivery Status</strong></td>
                                    <td class=" text-right bg-primary"><strong>Rate</strong></td>
                                    <td class=" text-right bg-primary"><strong>Quantity</strong></td>
                                    <td class=" text-right bg-primary" style="width:100px"><strong>Cancel
                                            Quantity</strong></td>
                                    <td class=" text-right bg-primary"><strong>Amount(BDT)</strong></td>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total = 0;
                                    $total_item_rate = 0;
                                    $cancel_dic = 0;
                                    $service_charges=0;

                                @endphp
                                @if (!empty($invoice_dtls_info))
                                    @foreach ($invoice_dtls_info as $row)
                                        @php
                                            $urgent_fee = 0;
                                            $item_rate = 0;
                                            $cancel_fee = 0;
                                            $text_dec = $row->item_qty == $row->cancel_qty ? 'text-decoration: line-through; line-height:1' : '';
                                        @endphp
                                        <tr>
                                            <td class="bg-light text-center">{{ sprintf('%02d', $loop->iteration) }}
                                            </td>
                                            <td class="text-left; "><strong>{{ $row->item_code }}</strong> <span
                                                    style="<?= $text_dec ?>"> {{ $row->item_name }}</span></td>

                                            <td class="text-right">
                                                {{ $row->report_delivery_date == '' ? '' : date('d/m/Y', strtotime($row->report_delivery_date)) }}
                                            </td>



                                            @if ($row->delivery_status_lookup_no_fk == 1)
                                                <td class=" text-right"> Routine </td>
                                                @php
                                                    $item_rate = $row->item_rate_orig;
                                                @endphp
                                            @elseif($row->delivery_status_lookup_no_fk == 2)
                                                <td class=" text-right"> Urgent </td>
                                                @php
                                                    $urgent_fee = isset($row->urgent_fee) ? $row->urgent_fee : '0';
                                                    $item_rate = $row->item_rate_orig + $urgent_fee;
                                                @endphp
                                            @else
                                                <td></td>
                                                @php
                                                    $item_rate = $row->item_rate_orig;
                                                @endphp
                                            @endif

                                            <td class="text-right" style='font-weight: bold'>
                                                {{ number_format($item_rate, 2, '.', '') }}</td>
                                            <td class="text-right">{{ $row->item_qty }}</td>
                                            <td class="text-right">{{ $row->cancel_qty }}</td>
                                            <td class="text-right bg-light">
                                                {{ number_format($row->cancel_qty * $item_rate, 2, '.', '') }}</td>
                                        </tr>
                                        @php

                                            $total += $row->cancel_qty * $item_rate + $row->cancel_qty * $row->item_vat;
                                            $total_item_rate += $row->item_qty * ($item_rate + $row->item_vat);
                                            $cancel_dic += ($row->cancel_qty != '' ? $row->cancel_qty : 0) * $row->disc_amount;
                                            $cancel_fee += $row->cancel_qty * $row->urgent_fee;
                                            if ($row->cancel_ind != 1) {
                                    $service_charges += $row->service_charge;
                                }
                                        @endphp
                                    @endforeach
                                @endif

                                @php

                                    // $amt_in_word = new \NumberFormatter( 'en_US', \NumberFormatter::SPELLOUT);
                                    $sales_cancel = !empty($finc_inv_sum_amount->sales_cancel) ? $finc_inv_sum_amount->sales_cancel : 0;
                                    $calcel_discount = !empty($finc_inv_sum_amount->cancel_discount) ? $finc_inv_sum_amount->cancel_discount : 0;
                                    $service_charge = number_format($service_charges, 2, '.', '');
                                    $vat = number_format(0, 2, '.', '');
                                    $discount = number_format($finc_inv_sum_amount->discount, 2, '.', '');
                                    $urgent_fee = number_format($finc_inv_sum_amount->urgent_fee, 2, '.', '');
                                    $payment = number_format($finc_inv_sum_amount->net_collection, 2, '.', '');
                                    $payable = number_format($total - $discount, 2, '.', '');
                                    $due = number_format($payable - $payment, 2, '.', '');
                                    $number = $total - $discount;
                                    $locale = 'en_US';
                                    $fmt = numfmt_create($locale, NumberFormatter::SPELLOUT);
                                    $total = $finc_inv_sum_amount->sales - $service_charges;
                                    $total_amt = $finc_inv_sum_amount->sales;
                                    $total_dis = $invoice_mst_info->ledger_amt_discount ? $invoice_mst_info->ledger_amt_discount : 0;
                                    // $net_payable=number_format($total_amt - ($total + $discount),2,".","");
                                    $net_payable = number_format(($total_amt - $discount) - $sales_cancel, 2, '.', '');
                                    $paid_amount = number_format($finc_inv_sum_amount->net_collection, 2, '.', '');
                                    $due_refund = number_format($net_payable - $paid_amount, 2, '.', '');

                                    if ($due_refund <= 0) {
                                        $in_words = numfmt_format($fmt, abs($net_payable));
                                    } else {
                                        $in_words = numfmt_format($fmt, $net_payable);
                                    }

                                @endphp
                                <tr style="border-top:2px solid #38C172">
                                    <td class="no-line" colspan="5">
                                        <strong>Remarks:</strong>{{ $invoice_mst_info->invoice_remarks }}</td>
                                    <td class="no-line text-right" colspan="2" style="width:100px"><strong>Total Item
                                            Amount</strong></td>
                                    <td class="no-line text-right bg-light">
                                        {{ number_format($total, 2, '.', '') }}</td>
                                </tr>
                                <tr>
                                    <td class="no-line" colspan="5"></td>
                                    <td class="no-line text-right" colspan="2" style="width:100px"><strong>Total
                                            Cancel Amount</strong></td>
                                    <td class="no-line text-right bg-light">{{ number_format($sales_cancel, 2, '.', '') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="no-line" colspan="5"></td>
                                    <td class="no-line text-right" colspan="2" style="width:100px"><strong>(-)
                                            Discount</strong></td>
                                    <td class="no-line text-right bg-light">
                                        {{ number_format($calcel_discount, 2, '.', '') }}</td>
                                </tr>
                                {{-- <tr>
							<td class="no-line" colspan="5"></td>
							<td class="no-line text-right" colspan="2" style="width:100px"><strong>Urgent Fee</strong></td>
							<td class="no-line text-right bg-light">0.00
							<!-- {{ number_format($cancel_fee,2,".","") }} -->
						</td>
						</tr> --}}
                                <tr>
                                    <td class="no-line" colspan="5"></td>
                                    <td class="no-line text-right" colspan="2" style="width:100px"><strong>Net Cancel
                                            Amount</strong></td>
                                    <td class="no-line text-right bg-light">
                                        {{ number_format($sales_cancel - $calcel_discount, 2, '.', '') }}</td>
                                </tr>
                                <tr>
                                    <td class="no-line" colspan="5"></td>
                                    <td class="no-line text-right" colspan="2" style="width:100px"><strong>Discounted
                                            Amount</strong></td>
                                    <td class="no-line text-right bg-light">{{ number_format($discount, 2, '.', '') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="no-line" colspan="5"></td>
                                    <td class="no-line text-right" colspan="2" style="width:100px"><strong>Net
                                            Payable </strong></td>
                                    <td class="no-line text-right bg-light">
                                        {{ $net_payable }}</td>
                                    {{-- {{number_format($total_amt - ($sales_cancel ),2,".","") }}</td> --}}
                                    {{-- @dd($total_amt , $sales_cancel , $calcel_discount) --}}
                                </tr>
                                <tr>
                                    <td class="no-line" colspan="5"></td>
                                    <td class="no-line text-right" colspan="2" style="width:100px"><strong>Paid
                                            Amount </strong></td>
                                    <td class="no-line text-right bg-light">{{ $paid_amount }}</td>
                                </tr>
                                @if ($due_refund <= 0)
                                    <tr>
                                        <td class="no-line" colspan="5"></td>
                                        <td class="no-line text-right" colspan="2" style="width:100px">
                                            <strong>Cash Refund </strong></td>
                                        <td class="no-line text-right bg-light">
                                            {{ number_format(abs($finc_inv_collection_amount->refund), 2, '.', '') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="no-line" colspan="5"></td>
                                        <td class="no-line text-right" colspan="2" style="width:100px">
                                            <strong>Total Refund </strong></td>
                                        <td class="no-line text-right bg-light">
                                            {{ number_format(abs($due_refund), 2, '.', '') }}</td>
                                    </tr>
                                @else
                                    <tr>
                                        <td class="no-line" colspan="5"></td>
                                        <td class="no-line text-right" colspan="2" style="width:100px"><strong>Due
                                                Amount </strong></td>
                                        <td class="no-line text-right bg-light">
                                            {{ number_format($due_refund, 2, '.', '') }}</td>
                                    </tr>
                                @endif
                                <tr>
                                    <td class="no-line" colspan="5"> <strong>In Word: </strong>
                                        {{ ucfirst($in_words) }} Taka only</td>

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
            @if(Session::get('user.ses_hospital_code')=="UNICO")
            @if($invoice_mst_info->bill_type =="PKG")
                <a href="{{ route('due-invoice-print-v2-pkg', [$invoice_mst_info->invoice_no_pk, $finc_inv_collection_amount->ledgertrn_no_pk]) }}"
                    target="_blank" class="btn btn-warning btn-md" title="Click here to Clear form data">Print</a>
            @else
                <a href="{{ route('bill-cancel-print-v2', [$invoice_mst_info->invoice_no_pk, $finc_inv_collection_amount->ledgertrn_no_pk]) }}"
                    target="_blank" class="btn btn-warning btn-md" title="Click here to Clear form data">Print</a>
            @endif
            @else
                <a href="{{ route('bill-cancel-print', [$invoice_mst_info->invoice_no_pk, $finc_inv_collection_amount->ledgertrn_no_pk]) }}"
                    target="_blank" class="btn btn-warning btn-md" title="Click here to Clear form data">Print</a>
            @endif
            <button type="reset" class="btn btn-danger btn-md" title="Click here to Clear form data"
                data-dismiss="modal">Close</button>
            <a href="{{ route('home') }}" class="btn btn-info btn-md" rel="tab"
                title="Click here to go back to Dashboard" data-dismiss="modal">Exit</a>
        </div>
    </div>
</div>
