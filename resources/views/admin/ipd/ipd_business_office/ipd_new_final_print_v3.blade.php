

<style>
    table tr {
        border-bottom: none;
    }
    .nested-table{
        border-collapse: collapse
    }
    .nested-table>tbody>tr>td{
        border:none;
        text-align: left;
    }
    footer {
        position: fixed;
        z-index: 999999999;
        left: 0;
        right: 0;
        height: 3cm;
        text-align: center;
        font-size: 9px;
        bottom: -100px;
        border-top: 1px solid black;
        padding-top: 10px;
    }

    body {
        margin-left: 0cm;
        margin-right: 0cm;
        font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
        font-size: 9px;
    }

    table {
        border-collapse: collapse;
        width: 100%;
    }

    table tr td,
    table tr th {
        font-size: 10px;
        border: 0;
        padding: 2px;
    }
    .border-0 {
        border: 0px;
    }

    .text-center {
        text-align: center !important;
    }

    .text-left {
        text-align: left !important;
    }

    .text-right {
        text-align: right !important;
    }
    .align-items-center {
        align-items: center;
    }
    .border-bottom {
        border-bottom: 1px solid #333;
    }
    .signature {
        width: 100%;
        height: 30px;
        margin-top: 20px;
        margin-bottom: 10px;
    }
    .table-bordered td,
    .table-bordered th {
        border-bottom: 1px dotted #333;
    }
    .pb-2{
        padding-bottom: 2px;
    }
    .mb-10 {
        margin-bottom: 5px;
    }
    .mb-0 {
        margin-bottom: 0px;
    }
    .mt-0{
        margin-top: 0px
    }
</style>
<main id="page-content">
    <div>
        <table class="border-bottom" style="width:100%">
            <tr>
                <td style="width:15%">
                    @if(!empty($po_hospital_details->logo))
                    <img src="{{ asset('images/uploads/hospital_images/'.$po_hospital_details->logo) }}" width="80px"/>
                    @endif
                </td>
                <td style="width:85%">
                    <h1 class="mb-0 mt-0">{{isset($po_hospital_details->hospital_name )? $po_hospital_details->hospital_name : ""}}</h1>
                    <p class="mb-0 mt-0">{{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : ""}}</p>
                    <p class="mb-0 mt-0">{{isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : "" }}</p>
                </td>
            </tr>
        </table>

        <table style="border: 1px dotted #dee2e6; height: 80px; padding:5px;">
            <tr>
                <td>
                    <ul style="list-style: none; padding-left: 0; display:inline-block;">
                        <li><b>Admission ID:</b>&nbsp;<span>{{ isset($admission_info->admission_no_pk) ? $admission_info->admission_no_pk : '' }}</span></li>
                        <li><img style="" src="data:image/png;base64, {{ $invoice_barcode }} "></li>
                        <li>&nbsp;<span><b>Name:</b>{{ isset($paitent_info->patient_name) ? $paitent_info->patient_name : '' }}</span>&nbsp;
                            <span><b>Age:</b>{{ isset($paitent_info->age) ? $paitent_info->age : '' }}</span>
                            <b>Gender:</b>&nbsp;<span>{{ isset($paitent_info->gender_txt) ? $paitent_info->gender_txt : '' }}</span>
                            <b>Bed :</b>&nbsp;<span>{{ isset($admission_info->bed_name) ? $admission_info->bed_name : '' }}</span>
                        </li>
                        <li><b>Con. Number :</b>&nbsp;<span>{{$paitent_info->mobile1}}</span></li>
                    </ul>
                </td>
                <td style="text-align:right">
                    <ul style="list-style: none; padding-left: 0;">
                        <li><b>Patient ID:</b>&nbsp;<span>{{ isset($paitent_info->patient_code) ? $paitent_info->patient_code : '' }}</span></li>
                        <li><img style="" src="data:image/png;base64, {{ $pat_barcode }} "></li>
                        <li><b>Phone:</b>&nbsp;<span>{{ isset($paitent_info->mobile1) ? $paitent_info->mobile1 : '' }}</span></li>
                        <li><b>Date Of Admission:</b>&nbsp;<span>{{ date('d/m/Y', strtotime($admission_info->admission_date)) }}</span></li>
                        <li><b>BILL STATUS:</b>&nbsp;<span>FINAL</span></li>
                    </ul>
                </td>
            </tr>
        </table>

        @php
        $total = 0;
        $total_investigation = 0;
        $total_phr = 0;
        $ledger_amt_discount = 0;
        $ledger_amt_invst_discount = 0;
        $ledger_amt_phar_discount = 0;
        $ledger_amt_payment = 0;
        $ledger_amt_invst_payment = 0;
        $ledger_amt_phar_payment = 0;
        $service_charge = 0;
        $service_invst_charge = 0;
        $service_phart_charge = 0;
        $total_service_charge = 0;
        @endphp

        @if (!empty($hospital_service))
            <div class="text-center">
                <h4>{{$hospital_service[0]->par_item_type_name}}</h4>
            </div>
            <table class="table table-bordered border-bottom">
                <thead>
                    <tr>
                        <th class="text-left">SL</th>
                        <th class="text-left">Item</th>
                        <th class="text-center">Qty.</th>
                        <th class="text-right" colspan="2">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($hospital_service as $row)
                        <tr>
                            <td class="text-left">{{ $loop->iteration }}</td>
                            <td class="text-left">{{ $row->item_name }}</td>
                            <td class="text-center">{{ ($row->day_sum_item_qty - $row->day_sum_cancel_qty) }}</td>
                            <td class="text-right" colspan="2">{{ number_format($row->day_sum_invoicedtl_amt_sales,2) }}</td>
                        </tr>
                        @php
                        $total += $row->day_sum_invoicedtl_amt_sales;
                        $service_charge += $row->day_service_charge;
                        $ledger_amt_discount = $total_discount_hos_srv[0]->discount_hossrv;
                        @endphp
                    @endforeach

                    @php
                    if (!empty($hospital_service)) {
                        $ledger_amt_payment = isset($hospital_service[0]->sum_payment) ? $hospital_service[0]->sum_payment :0;
                        $payable=number_format(($total+$service_charge) - $ledger_amt_discount, 2, '.', '');
                        $locale = 'en_US';
                        $fmt = numfmt_create($locale, NumberFormatter::SPELLOUT);
                        $net_payable= number_format(($total+$service_charge) - $ledger_amt_discount);//number_format($total - $ledger_amt_discount, 2);
                        $in_words = numfmt_format($fmt, abs($payable));
                        $total_paid=number_format($ledger_amt_payment, 2);
                    }
                    else {
                        $ledger_amt_payment = 0;
                        $payable=$total - $ledger_amt_discount;
                        $locale = 'en_US';
                        $fmt = numfmt_create($locale, NumberFormatter::SPELLOUT);
                        $net_payable= number_format($total - $ledger_amt_discount, 2, '.', '');
                        $in_words = numfmt_format($fmt, abs($net_payable));
                        $total_paid=number_format($ledger_amt_payment, 2);
                    }
                    @endphp

                        <tr>
                            <td class="text-left" rowspan="4" colspan="3"><b>In Word :</b>{{ strtoupper($in_words) }} TAKA ONLY</td>
                            <td class="text-right"><b>Bill :</b></td>
                            <td class="text-right">{{ number_format($total,2) }}</td>
                        </tr>
                    @if($service_charge > 0)
                        <tr>
                            <td class="text-right"><b>(+)Service Charge :</b></td>
                            <td class="text-right">{{ number_format($service_charge,2) }}</td>
                        </tr>
                    @endif

                    @if($ledger_amt_discount > 0)
                        <tr>
                            <td class="text-right"><b>(-)Discount :</b></td>
                            <td class="text-right">{{ number_format($ledger_amt_discount,2) }}</td>
                        </tr>
                    @endif
                        <tr>
                            <td class="text-right"><b>Net Payable :</b></td>
                            <td class="text-right">{{ number_format(($total+$service_charge) - $ledger_amt_discount,2) }}</td>
                        </tr>
                </tbody>
            </table>
        @endif

        @if (!empty($investigation))
            <div class="text-center mb-10">
                <h4>&nbsp;</h4>
            </div>
            <table class="table  table-bordered border-bottom">
                <thead>
                    <tr>
                        <th class="text-left" style="width: 68px;">SL</th>
                        <th class="text-left" colspan="7">Service Type</th>
                        <th class="text-right" colspan="2">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($investigation as $row)
                        @php
                        $total_investigation += $row->day_sum_invoicedtl_amt_sales;
                        $service_invst_charge += $row->day_service_charge;
                        $ledger_amt_invst_discount = $total_discount_invst[0]->discount_invst;
                        @endphp
                    @endforeach
                    <tr>
                        <td class="text-left">1</td>
                        <td class="text-left" colspan="7">{{$investigation[0]->par_item_type_name}}</td>
                        <td class="text-right" colspan="2">{{ number_format($total_investigation,2) }}</td>
                    </tr>
                    @php
                    if (!empty($investigation)) {
                        $ledger_amt_invst_payment = isset($investigation[0]->sum_payment) ? $investigation[0]->sum_payment :0;
                        $payable=number_format(($total_investigation+$service_invst_charge) - $ledger_amt_invst_discount, 2, '.', '');
                        $locale = 'en_US';
                        $fmt = numfmt_create($locale, NumberFormatter::SPELLOUT);
                        $in_words = numfmt_format($fmt, abs($payable));
                        $net_payable= number_format(($total_investigation+$service_invst_charge) - $ledger_amt_invst_discount, 2);
                        $total_paid=number_format($ledger_amt_invst_payment, 2);
                    } else {
                        $ledger_amt_invst_payment = 0;
                        $payable=number_format($total_investigation - $ledger_amt_invst_discount, 2, '.', '');
                        $locale = 'en_US';
                        $fmt = numfmt_create($locale, NumberFormatter::SPELLOUT);
                        $in_words = numfmt_format($fmt, abs($payable));
                        $net_payable= number_format($total_investigation - $ledger_amt_invst_discount, 2);
                        $total_paid=number_format($ledger_amt_invst_payment, 2);
                    }
                    @endphp

                    <tr>
                        <td class="text-left" rowspan="4" colspan="7"><b>In Word :</b>{{ strtoupper($in_words) }} TAKA ONLY</td>
                        <td class="text-right" colspan="2"><b>Bill :</b></td>
                        <td class="text-right">{{ number_format($total_investigation,2) }}</td>
                    </tr>

                    @if($service_invst_charge > 0)
                        <tr>
                            <td class="text-right" colspan="2"><b>(+)Service Charge :</b></td>
                            <td class="text-right">{{ number_format($service_invst_charge,2) }}</td>
                        </tr>
                    @endif

                    @if($ledger_amt_invst_discount > 0)
                        <tr>
                            <td class="text-right" colspan="2"><b>(-)Discount :</b></td>
                            <td class="text-right">{{ number_format($ledger_amt_invst_discount,2) }}</td>
                        </tr>
                    @endif
                        <tr>
                            <td class="text-right" colspan="2"><b>Net Payable :</b></td>
                            <td class="text-right">{{ number_format(($total_investigation+$service_invst_charge) - $ledger_amt_invst_discount,2) }}</td>
                        </tr>
                </tbody>
            </table>
        @endif


        @if (!empty($pharmacy))
            @foreach ($pharmacy as $row)
                    @php
                    $total_phr += $row->day_sum_invoicedtl_amt_sales;
                    $service_phart_charge += $row->day_service_charge;
                    $ledger_amt_phar_discount = $total_discount_pharmacy[0]->discount_pharmacy;
                    @endphp
            @endforeach
            @php
                if (!empty($pharmacy)) {

                    $ledger_amt_phar_payment = isset($pharmacy[0]->sum_payment) ? $pharmacy[0]->sum_payment :0;
                    $payable=($total_phr+$service_phart_charge) - $ledger_amt_phar_discount;
                    $locale = 'en_US';
                    $fmt = numfmt_create($locale, NumberFormatter::SPELLOUT);
                    $in_words = numfmt_format($fmt, abs($payable));
                    $net_payable= number_format($total_phr - $ledger_amt_phar_discount);
                    $total_paid=number_format($ledger_amt_phar_payment);

                }
                    else {
                    $ledger_amt_phar_discount = 0;
                    $ledger_amt_phar_payment = 0;
                    $payable=$total_phr - $ledger_amt_phar_discount;
                    $locale = 'en_US';
                    $fmt = numfmt_create($locale, NumberFormatter::SPELLOUT);
                    $in_words = numfmt_format($fmt, abs($payable));
                    $net_payable= number_format($total_phr - $ledger_amt_phar_discount);
                    $total_paid=number_format($ledger_amt_phar_payment);
                }
            @endphp

            <div class="text-center mb-10">
                <h4>&nbsp;</h4>
            </div>

            <table class="table  table-bordered border-bottom">
                <thead>
                    <tr>
                        <th class="text-left" style="width: 68px;">SL</th>
                        <th class="text-left" colspan="7">Service Type</th>
                        <th class="text-right" colspan="2">Amount</th>
                    </tr>
                </thead>

                <tbody>

                    <tr>
                        <td class="text-left">1</td>
                        <td class="text-left" colspan="7">{{$pharmacy[0]->par_item_type_name}}</td>
                        <td class="text-right" colspan="2">{{ number_format($total_phr,2) }}</td>
                    </tr>

                    <tr>
                        <td class="text-left" rowspan="4" colspan="7" style="vertical-align: middle"><b>In Word :</b>{{ strtoupper($in_words) }} TAKA ONLY</td>
                        <td class="text-right" colspan="2"><b>Bill :</b></td>
                        <td class="text-right">{{ number_format($total_phr,2) }}</td>
                    </tr>

                    @if($service_phart_charge > 0)
                    <tr>
                        <td class="text-right" colspan="2"><b>(+)Service Charge :</b></td>
                        <td class="text-right">{{ number_format($service_phart_charge,2) }}</td>
                    </tr>
                    @endif

                    @if($ledger_amt_phar_discount > 0)
                    <tr>
                        <td class="text-right" colspan="2"><b>(-)Discount :</b></td>
                        <td class="text-right">{{ number_format($ledger_amt_phar_discount,2) }}</td>
                    </tr>
                    @endif
                    <tr>
                        <td class="text-right" colspan="2"><b>Net Payable :</b></td>
                        <td class="text-right">{{ number_format(($total_phr+$service_phart_charge) - $ledger_amt_phar_discount,2) }}</td>
                    </tr>
                </tbody>
            </table>
        @endif


        @php
            $tolat_amt = $total + $total_investigation + $total_phr;
            $ledger_amt_discount_amt = $ledger_amt_discount + $ledger_amt_invst_discount + $ledger_amt_phar_discount;
            $net_payable_amt=number_format(($total - $ledger_amt_discount) + ($total_phr - $ledger_amt_phar_discount) + ($total_investigation - $ledger_amt_invst_discount),2);
            $ledger_amt_payment_amt =number_format($total_payment[0]->total_payment);
            $ledger_amt_payment_amt_rtn =number_format($total_payment_return[0]->total_payment);
            $act_payment = ($total_payment[0]->total_payment-abs($total_payment_return[0]->total_payment));
            $payable_amt=($total - $ledger_amt_discount) + ($total_phr - $ledger_amt_phar_discount) + ($total_investigation - $ledger_amt_invst_discount);
            $total_service_charge = $service_charge + $service_invst_charge + $service_phart_charge;
            $total_payable = ($payable_amt+$total_service_charge);
            $total_due = (round($total_payable)-round($act_payment));
            $locale = 'en_US';
            $fmt = numfmt_create($locale, NumberFormatter::SPELLOUT);
            $in_words = numfmt_format($fmt, abs($total_due),2);
        @endphp

        <div class="text-center mb-10">
            <h4>Total Bill</h4>
        </div>

        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th style="width:65%;border:none" ></th>
                    <th style="width:35%;border:none"></th>
                </tr>
            </thead>
            <tbody>

                <tr>
                    <td style="vertical-align: middle">
                        <span style="font-size: 30px !important; border: 5px solid #dee2e6; border-left-color: #dee2e6; color: #909dab; padding: 10px;">
                            @if ($total_due == 0 )
                                <strong>PAID</strong>
                            @elseif($total_due < 0)
                                <strong>Refund</strong>
                            @elseif($total_due > 0)
                                <strong>DUE</strong>
                            @endif
                        </span> <br/> <br>

                        <span style="margin-top:10px"><b>In Word :</b> {{ strtoupper($in_words) }} TAKA ONLY </span>
                    </td>
                    <td>
                        <table>
                            <tbody>
                                <tr>
                                    <td class="text-right"><b>Bill :</b></td>
                                    <td class="text-right">{{ number_format($tolat_amt,2) }}</td>
                                </tr>
                                <tr>
                                    <td class="text-right"><b>(+)Total Service Charge :</b></td>
                                    <td class="text-right">{{ number_format($total_service_charge,2) }}</td>
                                </tr>
                                <tr>
                                    <td class="text-right"><b>(+)Total Bill :</b></td>
                                    <td class="text-right">{{ number_format($tolat_amt + $total_service_charge,2) }}</td>
                                </tr>
                                <tr>
                                    <td class="text-right" style="padding-top: 4px;padding-bottom: 5px;"><b>(-)Total Discount :</b></td>
                                    <td class="text-right" style="padding-top: 4px;padding-bottom: 5px;"><b>{{ number_format($ledger_amt_discount_amt,2) }}</b></td>
                                </tr>

                                <tr>
                                    <td class="text-right"><b>Net Payable :</b></td>
                                    <td class="text-right">{{ number_format($total_payable,2) }}</td>
                                </tr>

                                <tr>
                                    <td class="text-right"><b>Total Paid :</b></td>
                                    <td class="text-right">{{ $act_payment }}</td>
                                </tr>

                                <tr>
                                    <td class="text-right" style="border-bottom: none"><b>Total Due :</b></td>
                                    <td class="text-right" style="border-bottom: none">{{ number_format($total_due) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="text-center mb-10">
            <h4>Total Payment History</h4>
        </div>
        <table class="table table-bordered mt-3">
            <tbody>


                @php
                    $totalPayAmount = 0;
                @endphp
                @if (!empty($paymentHistories_new))
                    @foreach ($paymentHistories_new as $key => $payhistory)
                        <tr>
                            <td class="text-center">
                                <b> {{ date('d/m/Y', strtotime($payhistory->invoice_date)) }}</b>
                            </td>
                            <td char="text-center"><b>{{ ucfirst($payhistory->pay_type) }}</b>
                            </td>
                            <td class="text-left">{{ $payhistory->ledger_entry_txt }}</td>
                            <td class="text-right">{{ number_format(abs($payhistory->ledger_amt_payment), 2) }}</td>
                        </tr>

                        @php

                            $totalPayAmount += $payhistory->ledger_amt_payment;

                        @endphp
                    @endforeach
                @endif


            </tbody>
            <tfoot>
                <tr>
                    <td class="text-center" colspan="3"><b>Total</b></td>
                    <td class="text-right">{{ number_format($totalPayAmount, 2) }} </td>
                </tr>
            </tfoot>
        </table>
    
        <div style="margin-top: 50px;">
            <span style="float: left;"><strong>Authorised Signature</strong></span>
            <span style="float: right"><strong>Accounts</strong></span>
        </div>

        <footer>

            <?php
                $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
                $date = $dt->format('g:i A');
            ?>
            <div>
                {{-- <span style="float:left;">Prepared By: {{ $userInfo->user_fullname }}</span> --}}
                <span style="float:left;">Printed By: {{ Session::get('user.ses_user_name') }}</span>
                <span style="float:right">Powered By: NEXTGEN IT</span>
            </div>
        </footer>
</div>
</main>
