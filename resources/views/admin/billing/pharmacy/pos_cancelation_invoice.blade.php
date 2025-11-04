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
                                @php
                                    if (strtoupper(Session::get('user.ses_hospital_code')) == 'MCARE') {
                                        echo '<th class="w-10">Customer Id:</th>';
                                    } else {
                                        echo '<th class="w-10"> Patient ID :</th>';
                                    }
                                @endphp

                                <td class="text-left">{{ $invoice_mst_info->patient_code }}</td>
                                <th class="text-right">Bill No.</th>
                                <td class="text-left">{{ $invoice_mst_info->invoice_code }}</td>
                                <th class="w-10 text-right">Date of invoice:</th>
                                <td class="text-left">{{ date('d-m-Y ', strtotime($invoice_mst_info->au_entry_at)) }}
                                </td>
                            </tr>
                            <tr>
                                <th>{{ $invoice_mst_info->patient_name != '' ? 'Name:' : '' }}</th>
                                <td colspan="4" class="text-left">{{ ucwords($invoice_mst_info->patient_name) }}</td>
                            </tr>
                            <tr>
                                <th>{{ $invoice_mst_info->admission_no_pk != '' ? 'Admission ID:' : '' }}</th>
                                <td colspan="4" class="text-left">{{ $invoice_mst_info->admission_no_pk }}</td>
                            </tr>
                            <tr>
                                <th>{{ $invoice_mst_info->age != '' ? 'Age:' : '' }}</th>
                                <td colspan="4" class="text-left">{{ $invoice_mst_info->age }}
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
                                    <td class="w-30  bg-primary"><strong>Expire Date</strong></td>
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

                                @endphp
                                @if (!empty($invoice_dtls_info))
                                    @foreach ($invoice_dtls_info as $row)
                                        @php
                                            $urgent_fee = 0;
                                            $item_rate = 0;
                                            // $cancel_fee =0;
                                        @endphp
                                        <tr>
                                            <td class="bg-light text-center">{{ sprintf('%02d', $loop->iteration) }}
                                            </td>
                                            <td class="text-left"> {{ $row->item_name }}</td>
                                            <td class="text-left">
                                                @if (!empty($exp_date))
                                                    @foreach ($exp_date as $data)
                                                        @if ($row->item_no_fk == $data->item_no_fk && $data->batch_no != '')
                                                            {{ $data->batch_no ? date('d-m-Y', strtotime($data->expiry_date)) : '' }}
                                                            ,
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </td>

                                            @php
                                                // $urgent_fee=isset($row->urgent_fee)?$row->urgent_fee : "0" ;
                                                $item_rate = $row->item_rate + $urgent_fee;
                                            @endphp

                                            @php
                                                $item_rate = $row->item_rate;
                                                $total_item_rate_cancel = number_format(($row->item_qty - $row->cancel_qty) * $item_rate, 2, '.', '');
                                                // number_format(($row->item_qty - $row->cancel_qty)*$item_rate,2,".","");
                                            @endphp


                                            <td class="text-right" style='font-weight: bold'>
                                                {{ number_format($item_rate, 2, '.', '') }}</td>
                                            <td class="text-right">{{ $row->item_qty }}</td>
                                            <td class="text-right">{{ $row->cancel_qty }}</td>
                                            <td class="text-right bg-light">
                                                {{ number_format(($row->item_qty - $row->cancel_qty) * $item_rate, 2, '.', '') }}
                                            </td>
                                        </tr>
                                        @php

                                            //$total += ($row->cancel_qty*$item_rate);
                                            // $total_item_rate += $total_item_rate_cancel;
                                            // $cancel_dic += ( (($row->cancel_qty != "") ? $row->cancel_qty : 0) *$row->disc_amount) ;
                                            // $cancel_fee += ($row->cancel_qty * $row->urgent_fee ) ;
                                            $total += $row->cancel_qty * $item_rate + $row->cancel_qty * $row->item_vat;
                                            $total_item_rate += $row->item_qty * ($item_rate + $row->item_vat);
                                        @endphp
                                    @endforeach
                                @endif

                                @php

                                    // $amt_in_word = new \NumberFormatter( 'en_US', \NumberFormatter::SPELLOUT);
                                    // $calcel_discount = 0;
                                    // $total = abs($cancel_sales->ledger_amt_sales);
                                    // $vat = number_format(0, 2, '.', '');
                                    // $discount = number_format($invoice_mst_info->ledger_amt_discount, 2, '.', ''); // $urgent_fee = number_format($invoice_mst_info->urgent_fee,2,".","");
                                    // $payment = number_format($invoice_mst_info->ledger_amt_payment, 2, '.', '');
                                    // $payable = number_format($total - $discount, 2, '.', '');
                                    // $due = number_format($payable - $payment, 2, '.', '');
                                    // $number = $total - $discount;
                                    // $locale = 'en_US';
                                    // $fmt = numfmt_create($locale, NumberFormatter::SPELLOUT);
                                    // $total_amt = $total_item_rate + ($c_urgent_fee->urgent_fee + $cancel_fee->cancel_urgent_fee);
                                    // $total_dis = $invoice_mst_info->ledger_amt_discount ? $invoice_mst_info->ledger_amt_discount : 0;
                                    // $canc_dis = !empty($cancel_dis) ? $cancel_dis->ledger_amt_discount : 0;
                                    // $current_cancel_rate = $invoice_mst_info->ledger_amt_payment > 0 ? round($total + $canc_dis) : 0;
                                    // $net_payable = number_format($total_amt - $current_cancel_rate - $c_discount->disc_amount, 2, '.', '');  // $paid_amount= $total_sales->ledger_amt_payment > 0 ? $total_sales->ledger_amt_payment :0;
                                    // $paid_amount = $finc_vouchermas_sum->collection > 0 ? $finc_vouchermas_sum->collection : 0;
                                    // $due_refund = number_format($total_amt - $c_discount->disc_amount - $paid_amount, 2, '.', '');

                                    // if ($due_refund <= 0) {
                                    //     $in_words = numfmt_format($fmt, number_format(abs($total_amt - $c_discount->disc_amount), 2, '.', ''));
                                    // } else {
                                    //     $in_words = numfmt_format($fmt, number_format($total_amt - $c_discount->disc_amount, 2, '.', ''));
                                    // }
                                    $total_item_rate = round( $total_item_rate);
                                    $sales_cancel = !empty($finc_inv_sum_amount->sales_cancel) ? $finc_inv_sum_amount->sales_cancel : 0;
                                        $calcel_discount = !empty($finc_inv_sum_amount->cancel_discount) ? $finc_inv_sum_amount->cancel_discount : 0;
                                        $vat = number_format(0, 2, '.', '');
                                        $discount = number_format($finc_inv_sum_amount->discount, 2, '.', '');
                                        $urgent_fee = number_format($finc_inv_sum_amount->urgent_fee, 2, '.', '');
                                        $payment = number_format($finc_inv_sum_amount->net_collection, 2, '.', '');
                                        $payable = number_format($total - $discount, 2, '.', '');
                                        $due = number_format($payable - $payment, 2, '.', '');
                                        $number = $total - $discount;
                                        $locale = 'en_US';
                                        $fmt = numfmt_create($locale, NumberFormatter::SPELLOUT);
                                        $total_amt = $total_item_rate;

                                        // $total_dis = $invoice_mst_info->ledger_amt_discount ? $invoice_mst_info->ledger_amt_discount : 0;
                                        // $net_payable = number_format($total_amt - ($total + $discount), 2, '.', '');
                                        $net_payable =number_format(($total_amt - $discount) - $sales_cancel, 2, '.', '');
                                        $paid_amount = number_format($finc_inv_sum_amount->net_collection, 2, '.', '');
                                        $due_refund = number_format($net_payable - $paid_amount, 2, '.', '');
                                        if ($due_refund <= 0) {
                                            $in_words = numfmt_format($fmt, abs($net_payable));
                                        } else {
                                            $in_words = numfmt_format($fmt, $net_payable);
                                        }
                                        $to_date = date('Y-m-d');

                                @endphp
                                <tr style="border-top:2px solid #38C172">
                                    <td class="no-line" colspan="4">
                                        <strong>Remarks:</strong>{{ $invoice_mst_info->invoice_remarks }}</td>
                                    <td class="no-line text-right" colspan="2" style="width:100px"><strong>Total Item
                                            Amount</strong></td>
                                    <td class="no-line text-right bg-light">
                                        {{ number_format($total_item_rate, 2, '.', '') }}</td>
                                </tr>
                                <tr>
                                    <td class="no-line" colspan="4"></td>
                                    <td class="no-line text-right" colspan="2" style="width:100px"><strong>Total
                                            Cancel Amount</strong></td>
                                    <td class="no-line text-right bg-light">{{ number_format($sales_cancel, 2, '.', '') }}</td>
                                </tr>

                                <tr>
                                    <td class="no-line" colspan="4"></td>
                                    <td class="no-line text-right" colspan="2" style="width:100px"><strong>Urgent
                                            Fee</strong></td>
                                    <td class="no-line text-right bg-light">0.00
                                        {{ number_format($c_urgent_fee->urgent_fee + (!empty($cancel_fee) ? $cancel_fee->cancel_urgent_fee:0), 2, '.', '') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="no-line" colspan="4"></td>
                                    <td class="no-line text-right" colspan="2" style="width:100px"> <b>(-) Discount :</b></td>
                                    <td class="no-line text-right bg-light">
                                        {{ number_format($calcel_discount, 2, '.', '') }}</td>
                                </tr>
                                <tr>
                                    <td class="no-line" colspan="4"></td>
                                    <td class="no-line text-right" colspan="2" style="width:100px"><strong>Net Cancel
                                            Amount</strong></td>
                                    <td class="no-line text-right bg-light">
                                        {{ number_format($sales_cancel - $calcel_discount, 2, '.', '') }}</td>
                                </tr>
                                <tr>
                                    <td class="no-line" colspan="4"></td>
                                    <td class="no-line text-right" colspan="2" style="width:100px"><strong>Discounted
                                            Amount</strong></td>
                                    <td class="no-line text-right bg-light">
                                        {{ number_format($discount, 2, '.', '') }}</td>
                                </tr>
                                <tr>
                                    <td class="no-line" colspan="4"></td>
                                    <td class="no-line text-right" colspan="2" style="width:100px"><strong>Net
                                            Payable </strong></td>
                                    <td class="no-line text-right bg-light">

                                        {{ number_format($net_payable, 2, '.', '') }}
                                    </td>

                                </tr>
                                <tr>
                                    <td class="no-line" colspan="4"></td>
                                    <td class="no-line text-right" colspan="2" style="width:100px"><strong>Paid
                                            Amount </strong></td>
                                    <td class="no-line text-right bg-light">
                                        {{ number_format($paid_amount, 2, '.', '') }}</td>
                                </tr>
                                @if ($due_refund < 0)

                                    <tr>
                                        <td class="no-line" colspan="4"></td>
                                        <td class="no-line text-right" colspan="2" style="width:100px">
                                            <strong>Cash Refund </strong></td>
                                        <td class="no-line text-right bg-light">
                                            {{ number_format(abs($finc_inv_collection_amount->refund), 2, '.', '') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="no-line" colspan="4"></td>
                                        <td class="no-line text-right" colspan="2" style="width:100px">
                                            <strong>Total Refund </strong></td>
                                        <td class="no-line text-right bg-light">
                                            {{ number_format(abs($due_refund), 2, '.', '') }}</td>
                                    </tr>
                                @else
                                    <tr>
                                        <td class="no-line" colspan="4"></td>
                                        <td class="no-line text-right" colspan="2" style="width:100px"><strong>Due
                                                Amount </strong></td>
                                        <td class="no-line text-right bg-light">
                                            {{ number_format($due_refund, 2, '.', '') }}</td>
                                    </tr>
                                @endif

                                <tr>
                                    <td class="no-line" colspan="4"> <strong>In Word: </strong>
                                        {{ ucfirst($in_words) }} Taka only</td>

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
            <a href="{{ route('cancel-invoice-pos-print-pos', [$invoice_mst_info->invoice_no_pk , 1 , $finc_inv_collection_amount->ledgertrn_no_pk]) }}" target="_blank"
                class="btn btn-warning btn-md" title="Click here to Clear form data">POS</a>
            @if(Session::get('user.ses_hospital_code') == "UNICO")
                <a href="{{ route('pos-due-invoice-print-v2', [$invoice_mst_info->invoice_no_pk , 1 , $finc_inv_collection_amount->ledgertrn_no_pk]) }}" target="_blank"
                    class="btn btn-warning btn-md" title="Click here to Clear form data">A5 Print</a>
            @else
                <a href="{{ route('pos-cancel-print', [$invoice_mst_info->invoice_no_pk , 1 , $finc_inv_collection_amount->ledgertrn_no_pk]) }}" target="_blank"
                    class="btn btn-warning btn-md" title="Click here to Clear form data">A5 Print</a>
            @endif
           
            <button type="reset" class="btn btn-danger btn-md" title="Click here to Clear form data"
                data-dismiss="modal">Close</button>
            <a href="{{ route('home') }}" class="btn btn-info btn-md" rel="tab"
                title="Click here to go back to Dashboard" data-dismiss="modal">Exit</a>
        </div>
    </div>
</div>
