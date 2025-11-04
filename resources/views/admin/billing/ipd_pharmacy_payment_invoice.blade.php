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
                                        class="btn btn-sm bg-primary btn-rounded">Customer Copy </span></th>
                            </tr>
                            <tr>
                                <th class="w-10">PID:</th>
                                <td class="text-left">{{ $payment_details[0]->patient_code }}</td>
                                <th class="text-right">Trn. No:</th>
                                <td class="text-left">{{ $payment_details[0]->ledgertrn_no_pk }}</td>
                                <th class="w-10 text-right">Date of Payment:</th>
                                <td class="text-left">{{ date('d-m-Y', strtotime($payment_details[0]->au_entry_at)) }}
                                </td>
                            </tr>
                            <tr>
                                <th>{{ $payment_details[0]->patient_name != ' ' ? 'Name' : '' }}</th>
                                <td colspan="4" class="text-left">
                                    {{ $payment_details[0]->patient_name ? ucwords($payment_details[0]->patient_name) . ' ( ' . $payment_details[0]->patient_type_code . ' ) ' : '' }}
                                </td>
                            </tr>
                            <tr>
                                @php
                                    $pat_dob = new \DateTime($payment_details[0]->dob);
                                    $invoice_date = new \DateTime($payment_details[0]->invoice_date);
                                    $interval = $invoice_date->diff($pat_dob);
                                @endphp
                                <th> {{ $payment_details[0]->age != '' ? 'Age:' : '' }}</th>
                                <td colspan="4" class="text-left">
                                    {{ isset($interval) ? $interval->format('%yY %mM %dD') : '' }}
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>{{ $payment_details[0]->gender_txt ? 'Gender:' : '' }}
                                    </strong>
                                    {{ $payment_details[0]->gender_txt ? $payment_details[0]->gender_txt : '' }}
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>{{ ($payment_details[0]->mobile1 != '') != '' ? 'Contact:' : '' }}
                                    </strong>
                                    {{ $payment_details[0]->mobile1 != '' ? $payment_details[0]->mobile1 : '' }}
                                    &nbsp;&nbsp;&nbsp;&nbsp;<strong>{{ $payment_details[0]->present_addr != ' ' ? 'Address: ' : '' }}</strong>
                                    {{ $payment_details[0]->present_addr ? $payment_details[0]->present_addr : '' }}
                                </td>
                            </tr>

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
                        <table class="table table-borderless" width="100%">
                            <thead>
                                <tr>
                                    <td class="bg-primary text-center"><strong>SL#</strong></td>
                                    <td class="text-center bg-primary"><strong>invoice No</strong></td>
                                    <td class=" text-right bg-primary"><strong>Sales</strong></td>
                                    {{-- <td class="w-10 text-right bg-primary"><strong>Discount</strong></td>
                                    <td class="w-10 text-right bg-primary"><strong>Payment</strong></td> --}}
                                    {{-- <td class="w-10 text-right bg-primary"><strong>Amount(BDT)</strong></td> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total_sales = 0;
                                    $total_discount = 0;
                                    $total_payment = 0;

                                @endphp

                                @if (!empty($payment_details))

                                    @foreach ($payment_details as $row)

                                        @php

                                            $urgent_fee = 0;
                                            $item_rate = 0;
                                        @endphp
                                        <tr>
                                            <td class="bg-light text-center">{{ sprintf('%02d', $loop->iteration) }}
                                            </td>


                                            <td class="text-center" style='font-weight: bold'>
                                                {{ $row->invoice_no_pk }}
                                            </td>

                                            <td class="text-right" style='font-weight: bold'>
                                                @php
                                                    $sales_price=0;
                                                    $dis_price=0;
                                                   $payment_amt=0;
                                                @endphp
                                                @if (!empty($payment_sales_price))
                                                    @foreach ($payment_sales_price as $value)

                                                        @if ($value->invoice_no_pk == $row->invoice_no_pk)
                                                        {{ number_format($value->sales - $value->sales_cancel, 2, '.', '') }}
                                                        @endif
                                                        @php
                                                        $sales_price +=($value->sales - $value->sales_cancel);
                                                        $dis_price +=$value->discount;
                                                         $payment_amt +=$value->net_collection;
                                                    @endphp
                                                    @endforeach
                                                @endif


                                            </td>
                                            {{-- <td class="text-right">{{ $row->discount }}</td>
                                            <td class="text-right bg-light">
                                                {{ number_format($row->net_collection, 2, '.', '') }}</td> --}}
                                        </tr>
                                        @php

                                            $total_sales =   $sales_price;
                                            $total_discount = $dis_price;
                                            $total_payment = $payment_amt;
                                            // dd($row->discount);
                                        @endphp
                                    @endforeach
                                @endif

                                @php
                                // dd( $total_discount);
                                $payable_amt= $total_sales- $total_discount;
                                $due= $payable_amt -   $total_payment;
                                    $locale = 'en_US';
                                    $fmt = numfmt_create($locale, NumberFormatter::SPELLOUT);
                                    $in_words = numfmt_format($fmt,  round($payable_amt));
                                @endphp


                                <tr style="border-top:2px solid #38C172">
                                    <td class="no-line" colspan="1">

                                        {{-- @if (isset($paymood) && !empty($paymood))
                                            <div style="margin-bottom: 3px"><span
                                                    style="border-bottom:1px solid black; margin-bottom: 3px">Cash
                                                    Receipt In</span> </div>

                                            @foreach ($paymood as $value)
                                                @if ($value->paymood == 'CASH')
                                                    CASH : {{  round($value->pay_amount) }} ,


                                                @elseif($value->paymood == 'Mbanking')
                                                    {{ strtoupper($value->pay_mood_type) }} : {{ round($value->pay_amount) }}
                                                    ,
                                                @elseif($value->paymood == 'CARD')
                                                    CARD ({{ strtoupper($value->pay_mood_type) }}) :
                                                    {{ round($value->pay_amount) }} ,
                                                @else
                                                    OTHERS : {{ round($value->pay_amount) }} ,
                                                @endif


                                            @endforeach

                                        @endif
                                        <br> --}}

                                    </td>
                                    <td class="no-line text-right"><strong>Amount</strong></td>
                                    <td class="no-line text-right bg-light">{{ number_format(round($total_sales), 2, '.', '') }}
                                    </td>
                                </tr>


                                <tr>
                                    <td class="no-line" colspan="1"></td>
                                    <td class="no-line text-right"><strong>(-) Discount</strong></td>
                                    <td class="no-line text-right bg-light">
                                        {{ number_format(round($total_discount), 2, '.', '') }}</td>
                                </tr>
                                <tr>
                                    <td class="no-line" colspan="1"></td>
                                    <td class="no-line text-right"><strong>Payable </strong></td>
                                    <td class="no-line text-right bg-light">
                                        {{ number_format(round($payable_amt), 2, '.', '') }}</td>
                                </tr>

                                <tr>
                                    <td class="no-line" colspan="1"> <strong>In Word: </strong>
                                        {{ ucfirst($in_words) }} Taka only
                                    </td>
                                    <td class="No-line text-right"><strong>Payment</strong></td>
                                    <td class="no-line text-right bg-light">
                                        {{ number_format(round($total_payment), 2, '.', '') }}</td>
                                </tr>
                                <tr>

                                    <td class="no-line" colspan="1"></td>
                                    <td class="no-line text-right">
                                        {{-- @if ($due < 0)
                                        <strong>Refund</strong>
                                        @else
                                        <strong>Due</strong>
                                        @endif --}}

                                        <b>Due :</b>

                                    </td>
                                    <td class="no-line text-right bg-light">
                                        {{-- @if ($due < 0)
                                        {{ number_format(abs($due),2,".","") }}
                                        @else
                                        {{ number_format($due,2,".","") }}
                                        @endif --}}
                                        {{ number_format(abs($due), 2, '.', '') }}
                                    </td>
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
            <?php
                $pos = '1';//$page_type ? $page_type : '1';
                ?>
            <a href="{{ route('pos-billing-ipd-payment-slip-print',  $trn_id) }}"
                target="_blank" class="btn btn-warning btn-md" title="Click here to Clear form data">Print</a>
            <a href="{{ route('pos-billing-ipd-payment-slip-print-phr',  $trn_id) }}"
                target="_blank" class="btn btn-warning btn-md" title="Click here to Clear form data">POS Print</a>
            <button type="reset" class="btn btn-danger btn-md" title="Click here to Clear form data"
                data-dismiss="modal">Close</button>
            <a href="{{ route('home') }}" class="btn btn-info btn-md" rel="tab"
                title="Click here to go back to Dashboard" data-dismiss="modal">Exit</a>
        </div>
    </div>
</div>
