<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
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
                                <th class="text-right">Bill ID = {{ $invoice_mst_info->invoice_code }}</th>
                                <td class="text-left">TRX ID = {{ $finc_inv_collection_amount->ledgertrn_no_pk }}</td>
                                <th class="w-10 text-right">Date of invoice:</th>
                                <td class="text-left">
                                    {{ date('d-m-Y ', strtotime($invoice_mst_info->au_entry_at)) }}</td>
                            </tr>
                            @if ($invoice_mst_info->admission_no_pk != '')
                                <tr>
                                    <th class="w-25">Admission ID :</th>
                                    <td>{{ $invoice_mst_info->admission_no_pk }} (<strong>Bed/Cabin</strong>: {{$bed_details}})</td>
                                </tr>
                            @endif
                            <tr>
                                <th>{{ $invoice_mst_info->patient_name ? 'Name' : '' }}</th>
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
                                <th>{{ $invoice_mst_info->age != 0 || $invoice_mst_info->age != '' ? 'Age' : '' }}
                                </th>
                                <td colspan="4" class="text-left">
                                    {{ isset($interval) ? $interval->format('%yY %mM %dD') : '' }}
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>{{ $invoice_mst_info->gender_txt ? 'Gender:' : '' }}
                                    </strong> {{ $invoice_mst_info->gender_txt }}
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>{{ $invoice_mst_info->mobile1 ? 'Contact:' : '' }}
                                    </strong> {{ $invoice_mst_info->mobile1 }} &nbsp;&nbsp;&nbsp;&nbsp;<strong>
                                        {{ $invoice_mst_info->present_addr != '  ' ? 'Address:' : '' }} </strong>
                                    {{ $invoice_mst_info->present_addr }} </td>
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
                                        @if ($po_hospital_details->hospital_code == 'GMC')
                                            {{ $invoice_mst_info->person_code != '' ? ucwords($invoice_mst_info->person_code) : '' }}</span>
                                        @else
                                            {{ $invoice_mst_info->first_doc_name != '' ? ucwords($invoice_mst_info->first_doc_name) : '' }}</span>
                                        @endif

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
                            <tr>
                                <th>{{ isset($discout_by->full_name) ? 'Disc. By:' : '' }}</th>
                                <td colspan="4" class="text-left">
                                    {{ isset($discout_by->full_name) ? ucwords($discout_by->full_name) : '' }}{{ isset($ledgermst_paydisc->disc_amt_by_hosp) && $ledgermst_paydisc->disc_amt_by_hosp != 0 ? '(' . $ledgermst_paydisc->disc_amt_by_hosp . ' ' . 'Tk' . ')' : '' }}
                                    {{ isset($ledgermst_paydisc->disc_amt_by_doc) && $ledgermst_paydisc->disc_amt_by_doc != 0 ? ' , Doctor Disc. ' . '(' . $ledgermst_paydisc->disc_amt_by_doc . ' ' . 'Tk' . ')' : '' }}
                                </td>
                            </tr>
                            <tr>
                                <th>{{ isset($ledgermst_paydisc->disc_amt_request_name) ? 'Disc. Request By' : '' }}
                                </th>
                                <td>{{ isset($ledgermst_paydisc->disc_amt_request_name) ? $ledgermst_paydisc->disc_amt_request_name : '' }}
                                </td>
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
                            <thead class="global-uhl-table-bg">
                                <tr>
                                    <td class="w-5 text-center"><strong>SL#</strong></td>
                                    <td class="text-left"><strong>Item Description</strong></td>
                                    <td class="w-20 text-right"><strong>Delivery Date</strong></td>
                                    <td class="w-20 text-right"><strong>Delivery Status</strong></td>
                                    <td class="w-10 text-right"><strong>Rate</strong></td>
                                    <td class="w-10 text-right"><strong>Quantity</strong></td>
                                    <td class="w-10 text-right"><strong>Cancel Qty</strong></td>
                                    <td class="w-10 text-right"><strong>Amount(BDT)</strong></td>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totals = 0;
                                    $service_charges = 0;
                                @endphp
                                @if (!empty($invoice_dtls_info))
                                    @foreach ($invoice_dtls_info as $row)
                                        @php
                                            $urgent_fee = 0;
                                            $item_rate = 0;
                                            $text_dec = $row->item_qty == $row->cancel_qty ? 'text-decoration: line-through; line-height:1' : '';
                                        @endphp
                                        <tr>
                                            <td class="bg-light text-center">{{ sprintf('%02d', $loop->iteration) }}
                                            </td>
                                            <td class="text-left; "><strong>{{ $row->item_code }}</strong>
                                                <span style="<?= $text_dec ?>"> {{ $row->item_name }} </span>
                                            </td>

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
                                                {{ number_format($row->item_qty * $item_rate, 2, '.', '') }}</td>
                                        </tr>
                                        @php

                                                $service_charges += $row->service_charge * $row->item_qty ;

                                        @endphp
                                    @endforeach
                                @endif

                                @php
                                    // $totals = $sub_total;
                                    // $amt_in_word = new \NumberFormatter( 'en_US', \NumberFormatter::SPELLOUT);
                                    // $total = $total_item_rates->ledger_amt_sales;
                                    // $vat = number_format($invoice_mst_info->ledger_amt_vat, 2, '.', '');
                                    // $urgent_fee = number_format($invoice_mst_info->urgent_fee, 2, '.', '');
                                    $vat = number_format($finc_inv_sum_amount->ledger_amt_vat, 2, '.', '');
                                    $urgent_fee = number_format($finc_inv_sum_amount->urgent_fee, 2, '.', '');
                                    // $totals = $sub_total + $vat + $urgent_fee;
                                    $service_charge = number_format($service_charges + $finc_inv_sum_amount->service_charge_cancel, 2, '.', '');
                                    $totals = $finc_inv_sum_amount->sales;
                                    $total_item_amt = $finc_inv_sum_amount->sales - $service_charge;
                                    // $c_discounts = isset($c_discount->disc_amount) ? $c_discount->disc_amount : 0;
                                    // $c_dis_cancelations = isset($c_dis_cancelation->disc_amount) ? $c_dis_cancelation->disc_amount : 0;
                                    // $discount = number_format($c_discount->disc_amount, 2, '.', '');
                                    $discount = number_format($finc_inv_sum_amount->discount, 2, '.', '');
                                    $cancel_discount = number_format($finc_inv_sum_amount->cancel_discount, 2, '.', '');
                                    // $payment = number_format($total_sales->ledger_amt_payment, 2, '.', '');
                                    $payment = number_format($finc_inv_sum_amount->collection, 2, '.', '');
                                    // $payable = number_format($totals - $discount, 2, '.', '');
                                    $payable = number_format(( ($totals - $discount ) - $finc_inv_sum_amount->sales_cancel), 2, '.', '');
                                    // $due = number_format($payable - $payment, 2, '.', '');
                                    $due = number_format($payable - $finc_inv_sum_amount->net_collection, 2, '.', '');
                                    $refund = number_format($finc_inv_sum_amount->refund, 2, '.', '');
                                    // $number = $totals - $discount;
                                    $number = $payable;
                                    $locale = 'en_US';
                                    $fmt = numfmt_create($locale, NumberFormatter::SPELLOUT);
                                    $in_words = numfmt_format($fmt, $number);
                                @endphp
                                <tr style="border-top:2px solid #38C172">
                                    <td class="no-line" colspan="5">
                                        @if (!empty($paymood))

                                            <div style=" margin-bottom: 5px"><span
                                                    style="border-bottom:1px solid black">Cash Receipt In</span> </div>
                                            @foreach ($paymood as $value)
                                                @if ($value->paymood == 'CASH')
                                                    CASH : {{ $value->pay_amount }} ,
                                                @elseif($value->paymood == 'Mbanking')
                                                    {{ strtoupper($value->pay_mood_type) }} :
                                                    {{ $value->pay_amount }}
                                                    ,
                                                @elseif($value->paymood == 'CARD')
                                                    CARD ({{ strtoupper($value->pay_mood_type) }}) :
                                                    {{ $value->pay_amount }} ,
                                                @else
                                                    OTHERS : {{ $value->pay_amount }} ,
                                                @endif
                                            @endforeach
                                        @endif
                                        <br>

                                        <strong>Remarks:</strong>{{ $invoice_mst_info->invoice_remarks }}
                                    </td>
                                    <td class="no-line text-right" colspan="2"><strong>Total Sales Amount</strong>
                                    </td>
                                    <td class="no-line text-right bg-light">{{ number_format( $total_item_amt, 2, '.', '') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="no-line" colspan="5"></td>
                                    <td class="no-line text-right" colspan="2"><strong>Urgent Fee</strong></td>
                                    <td class="no-line text-right bg-light">
                                        {{ number_format($urgent_fee, 2, '.', '') }}</td>
                                </tr>

                                <tr>
                                    <td class="no-line" colspan="5"></td>
                                    <td class="no-line text-right" colspan="2"><strong>Vat </strong></td>
                                    <td class="no-line text-right bg-light">{{ number_format($vat, 2, '.', '') }}
                                    </td>
                                </tr>
                                @if ($service_charge > 0)
                                <tr>
                                    <td class="no-line" colspan="5"></td>
                                    <td class="no-line text-right" colspan="2"><strong>Service Charge </strong></td>
                                    <td class="no-line text-right bg-light">{{ number_format($service_charge, 2, '.', '') }}
                                    </td>
                                </tr>
                                @endif

                                {{-- <tr>
                                    <td class="no-line" colspan="3"></td>
                                    <td class="no-line text-right"><strong>Urgent Fee</strong></td>
                                    <td class="no-line text-right bg-light">
                                        {{ number_format($urgent_fee, 2, '.', '') }}</td>
                                </tr> --}}


                                <tr>
                                    <td class="no-line" colspan="5"></td>
                                    <td class="no-line text-right" colspan="2"><strong> Total Discount</strong></td>
                                    <td class="no-line text-right bg-light">
                                        {{ number_format($discount, 2, '.', '') }}
                                    </td>
                                </tr>
                                <tr>

                                    <td class="no-line" colspan="5"></td>
                                    <td class="no-line text-right" colspan="2"><strong>Payable</strong></td>
                                    <td class="no-line text-right bg-light">{{ number_format($payable, 2, '.', '') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="no-line" colspan="5"> <strong>In Word: </strong>
                                        {{ ucfirst($in_words) }} Taka only</td>
                                    <td class="No-line text-right" colspan="2"><strong>Payment</strong></td>
                                    <td class="no-line text-right bg-light">

                                        {{ number_format($finc_inv_collection_amount->collection, 2, '.', '') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="no-line" colspan="5"></td>
                                    <td class="no-line text-right" colspan="2"><strong>Total Paid</strong></td>
                                    <td class="no-line text-right bg-light">
                                        {{ number_format($finc_inv_sum_amount->net_collection, 2, '.', '') }}
                                    </td>
                                </tr>


                                <tr>
                                    @if ($due >= 0 && $refund == 0)
                                        <td class="no-line" colspan="5"></td>
                                        <td class="no-line text-right" colspan="2"><strong>Due</strong></td>
                                        <td class="no-line text-right bg-light">{{ number_format($due, 2, '.', '') }}
                                        </td>
                                    @endif
                                    @if ($refund > 0)
                                        <td class="no-line" colspan="5">
                                        </td>
                                        <td class="no-line text-right" colspan="2"><strong>Refund</strong>
                                            <br><strong>Total Refund</strong></td>
                                        <td class="no-line text-right bg-light">
                                            {{ number_format(abs($finc_inv_collection_amount->refund), 2, '.', '') }}
                                            <br>
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
                <span style="font-size: 12px;"><strong>Prepared by:</strong> {{ !empty($preparedBy->user_name) ? $preparedBy->user_name : '' }}</span>  &nbsp;&nbsp;
                <span style="font-size: 12px;"><strong>Preparing Date & Time:</strong>{{ !empty($invoice_mst_info->ledger_datetime) ? date('d/m/Y h:i a',strtotime($invoice_mst_info->ledger_datetime))  : '' }}</span> <br>

            </div>
        </div>
    <hr />
    <div class="row">
        <div class="col-md-12">
            @if(Session::get('user.ses_hospital_code')=="UNICO" || Session::get('user.ses_hospital_code')=="KPJ")
            @if($invoice_mst_info->bill_type == "PKG")
                <a href="{{ route('due-invoice-print-v2-pkg', [$invoice_mst_info->invoice_no_pk, $finc_inv_collection_amount->ledgertrn_no_pk]) }}"
                    target="_blank" class="btn btn-warning btn-md" title="Click here to Clear form data">Print</a>
            @else
                <a href="{{ route('due-invoice-print-v2', [$invoice_mst_info->invoice_no_pk, $finc_inv_collection_amount->ledgertrn_no_pk]) }}"
                    target="_blank" class="btn btn-warning btn-md" title="Click here to Clear form data">Print</a>
            @endif
            @else
                <a href="{{ route('due-invoice-print', [$invoice_mst_info->invoice_no_pk, $finc_inv_collection_amount->ledgertrn_no_pk]) }}"
                    target="_blank" class="btn btn-warning btn-md" title="Click here to Clear form data">Print</a>
            @endif
            <button type="reset" class="btn btn-danger btn-md" title="Click here to Clear form data"
                data-dismiss="modal">Close</button>
            <a href="{{ route('home') }}" class="btn btn-info btn-md" rel="tab"
                title="Click here to go back to Dashboard" data-dismiss="modal">Exit</a>
        </div>
    </div>
</div>
