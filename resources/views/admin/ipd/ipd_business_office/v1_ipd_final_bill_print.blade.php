<style>
    table tr {
        border-bottom: none;
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
        /*margin-top: 5.5cm;*/
        margin-left: 0cm;
        margin-right: 0cm;
        /*margin-bottom: 3.5cm;*/
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
        border-bottom: 1px solid #dee2e6;
    }
    .signature {
        width: 100%;
        height: 30px;
        margin-top: 20px;
        margin-bottom: 10px;
    }
    .table-bordered td,
    .table-bordered th {
        border: 1px solid #222
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
    .d-flex {
        display: flex;
    }
    .align-items-center {
        align-items: center;
    }
</style>

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

    <div style="border: 1px solid #dee2e6; height: 100px; padding: 0px 10px 10px; margin: 10px 0px;">
        <div class="patient-information d-flex align-items-center">
            <div class="text-left">
                <ul style="list-style: none; padding-left: 0;">
                    <li><i style="color: blue;"><b>Customer Copy</b></i></li>

                    <li><b>Date :</b>&nbsp;<span>{{ date('d/m/Y') }}</span></li>
                    <li><b>Admission ID
                            :</b>&nbsp;<span>{{ isset($admission_info->admission_no_pk) ? $admission_info->admission_no_pk : '' }}</span>
                    </li>
                    <li><b>Name
                            :</b>&nbsp;<span>{{ isset($paitent_info->patient_name) ? $paitent_info->patient_name : '' }}</span>
                    </li>
                    <li><b>Age
                            :</b>&nbsp;<span>{{ isset($paitent_info->age) ? $paitent_info->age : '' }}</span>
                    </li>
                    <li><b>Gender
                            :</b>&nbsp;<span>{{ isset($paitent_info->gender_txt) ? $paitent_info->gender_txt : '' }}</span>
                    </li>
                    <li><b>Contact No
                            :</b>&nbsp;<span>{{ isset($paitent_info->mobile1) ? $paitent_info->mobile1 : '' }}</span>
                    </li>
                </ul>
            </div>
            <div class="text-right">
                <ul style="list-style: none; padding-left: 0;">
                    {{-- <li><i>11-12-2021 (8:30:00PM)</i> </li> --}}
                    <li><b>Patient ID
                            :</b>&nbsp;<span>{{ isset($paitent_info->patient_code) ? $paitent_info->patient_code : '' }}</span>
                    </li>
                    <li>
                        <img style="" src="data:image/png;base64, {{ $pat_barcode }} " />
                    </li>

                    <li><i style="color: blue;"><b>Duplicate Copy</b></i></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="heading text-center border-bottom mb-10">
        <h2>Hospital and Consultant Bill</h2>
    </div>
    <table class="table table-bordered mt-3">
        <thead>
            <tr class="">
                <th class="text-center">SL</th>
                <th class="text-left">Service Type</th>
                <th class="text-left" colspan="2">Description</th>
                <th class="text-right">Amount</th>
            </tr>
        </thead>
        <tbody>
            @php
                $total = 0;
            @endphp
            @if (!empty($bill_info))
                @foreach ($bill_info as $row)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-left">{{ $row->item_type_name }}</td>
                        <td class="text-left" colspan="2">{{ $row->item_name }}</td>
                        <td class="text-right">{{ number_format($row->sales_amount_dtl, 2) }}
                        </td>
                    </tr>
                    @php
                        $total += $row->sales_amount_dtl;
                    @endphp
                @endforeach
            @endif

            @php

                $total_due_refund = $total - $amount[1] - $amount[0];
                $ledger_amt_discount = $amount[1] ? $amount[1] : 0;
                $ledger_amt_payment = $amount[0] ? $amount[0] : 0;
                $payable = $total - $ledger_amt_discount;
                $locale = 'en_US';
                $fmt = numfmt_create($locale, NumberFormatter::SPELLOUT);
                $in_words = numfmt_format($fmt, abs($payable));
            @endphp


            <tr>
                <th class="text-left" rowspan="3" colspan="3" style="padding: 5px;">
                    <span
                        style="font-size: 50px; line-height: 1; border: 5px solid #dee2e6; border-left-color: #dee2e6; color: #dee2e6; padding: 10px; margin: 10px;">
                        @if ($total_due_refund > 0)
                            DUE
                        @elseif($total_due_refund == 0)
                            PAID
                        @else
                            Balance
                        @endif

                    </span>
                </th>
                <td class="text-right"><b>Item Total Tk. :</b></td>
                <td class="text-right">{{ number_format($total, 2) }}</td>
            </tr>

            <tr>
                <td class="text-right"><b>(-)Discount Tk. :</b></td>
                <td class="text-right">{{ number_format($ledger_amt_discount, 2) }}</td>
            </tr>

            <tr>
                <td class="text-right"><b>Net Payable Tk. :</b></td>
                <td class="text-right">
                    {{ number_format($total - $ledger_amt_discount, 2) }}
                </td>
            </tr>

            <tr>
                <td class="text-left" rowspan="2" colspan="3"><b>In Word :</b>
                    {{ strtoupper($in_words) }} TAKA ONLY
                </td>
                <td class="text-right"><b>Total Payment Tk. :</b></td>
                <td class="text-right">{{ number_format($ledger_amt_payment, 2) }}</td>
            </tr>

            <tr>
                <td class="text-right"><b>{{ $total_due_refund >= 0 ? 'Due' : 'Balance' }} Tk.
                        :</b></td>
                <td class="text-right">{{ number_format(abs($total_due_refund), 2) }}</td>
            </tr>

        </tbody>
    </table>
    
    @if (!$bill_info_phr->isEmpty())

            <div class="heading text-center border-bottom mb-10">
                <h2>Pharmacy Bill</h2>
            </div>
            <table class="table table-bordered mt-3">
                <thead>
                    <tr class="">
                        <th class="text-center">SL</th>
                        <th class="text-left">Service Type</th>
                        <th class="text-left" colspan="2">Description</th>
                        <th class="text-right">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $total_phr = 0;
                    @endphp
                    @if (!empty($bill_info_phr))
                        @foreach ($bill_info_phr as $row)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-left">{{ $row->item_type_name }}</td>
                                <td class="text-left" colspan="2">{{ $row->item_name }}</td>
                                <td class="text-right">
                                    {{ number_format($row->sales_amount_dtl, 2) }}
                                </td>
                            </tr>
                            @php
                                $total_phr += $row->sales_amount_dtl;
                            @endphp
                        @endforeach
                    @endif

                    @php

                        $total_due_refund_phr = $total_phr - $amount_phr[1] - $amount_phr[0];
                        $ledger_amt_discount_phr = $amount_phr[1] ? $amount_phr[1] : 0;
                        $ledger_amt_payment_phr = $amount_phr[0] ? $amount_phr[0] : 0;
                        $payable_phr = $total_phr - $ledger_amt_discount;
                        $locale = 'en_US';
                        $fmt = numfmt_create($locale, NumberFormatter::SPELLOUT);
                        $in_words = numfmt_format($fmt, abs($payable_phr));
                    @endphp


                    <tr>
                        <th class="text-left" rowspan="3" colspan="3" style="padding: 5px;">
                            <span
                                style="font-size: 50px; line-height: 1; border: 5px solid
                #dee2e6; border-left-color: #dee2e6; color: #dee2e6; padding: 10px; margin: 10px;">
                                @if ($total_due_refund_phr > 0)
                                    DUE
                                @elseif($total_due_refund_phr == 0)
                                    PAID
                                @else
                                    Balance
                                @endif

                            </span>
                        </th>
                        <td class="text-right"><b>Item Total Tk. :</b></td>
                        <td class="text-right">{{ number_format($total_phr, 2) }}</td>
                    </tr>

                    <tr>
                        <td class="text-right"><b>(-)Discount Tk. :</b></td>
                        <td class="text-right">{{ number_format($ledger_amt_discount_phr, 2) }}
                        </td>
                    </tr>

                    <tr>
                        <td class="text-right"><b>Net Payable Tk. :</b></td>
                        <td class="text-right">
                            {{ number_format($total_phr - $ledger_amt_discount_phr, 2) }}
                        </td>
                    </tr>

                    <tr>
                        <td class="text-left" rowspan="2" colspan="3"><b>In Word :</b>
                            {{ strtoupper($in_words) }} TAKA ONLY
                        </td>
                        <td class="text-right"><b>Total Payment Tk. :</b></td>
                        <td class="text-right">{{ number_format($ledger_amt_payment_phr, 2) }}</td>
                    </tr>

                    <tr>
                        <td class="text-right">
                            <b>{{ $total_due_refund_phr >= 0 ? 'Due' : 'Balance' }} Tk.
                                :</b></td>
                        <td class="text-right">{{ number_format(abs($total_due_refund_phr), 2) }}
                        </td>
                    </tr>

                </tbody>
            </table>

            <div class="heading text-center border-bottom mb-10">
                <h2>Total Bill</h2>
            </div>
            <table class="table table-bordered mt-3">
                <tbody>

                    @php
                        $total_amt = $total + $total_phr;
                        $total_due_refund_amt = $total - $amount[1] - $amount[0] + ($total_phr - $amount_phr[1] - $amount_phr[0]);
                        $total_due_amt = $total - $amount[1] - $amount[0] + ($total_phr - $amount_phr[1] - $amount_phr[0]);
                        $ledger_amt_discount_amt = ($amount[1] ? $amount[1] : 0) + ($amount_phr[1] ? $amount_phr[1] : 0);
                        $ledger_amt_payment_amt = ($amount[0] ? $amount[0] : 0) + ($amount_phr[0] ? $amount_phr[0] : 0);
                        $payable_amt = $total - $ledger_amt_discount + ($total_phr - $ledger_amt_discount);
                        $locale = 'en_US';
                        $fmt = numfmt_create($locale, NumberFormatter::SPELLOUT);
                        $in_words = numfmt_format($fmt, abs($payable_amt));

                    @endphp


                    <tr>
                        <th class="text-left" rowspan="3" colspan="3"
                            style="padding: 5px;">
                            <span
                                style="font-size: 50px; line-height: 1; border: 5px solid
                #dee2e6; border-left-color: #dee2e6; color: #dee2e6; padding: 10px; margin: 10px;">
                                @if ($total_due_refund_amt > 0)
                                    DUE
                                @elseif($total_due_refund_amt == 0)
                                    PAID
                                @else
                                    Balance
                                @endif

                            </span>
                        </th>
                        <td class="text-right"><b>Item Total Tk. :</b></td>
                        <td class="text-right">{{ number_format($total_amt, 2) }}</td>
                    </tr>

                    <tr>
                        <td class="text-right"><b>(-)Discount Tk. :</b></td>
                        <td class="text-right">{{ number_format($ledger_amt_discount_amt, 2) }}
                        </td>
                    </tr>

                    <tr>
                        <td class="text-right"><b>Net Payable Tk. :</b></td>
                        <td class="text-right">
                            {{ number_format($total_amt - $ledger_amt_discount_amt, 2) }}
                        </td>
                    </tr>

                    <tr>
                        <td class="text-left" rowspan="2" colspan="3"><b>In Word :</b>
                            {{ strtoupper($in_words) }} TAKA ONLY
                        </td>
                        <td class="text-right"><b>Total Payment Tk. :</b></td>
                        <td class="text-right">{{ number_format($ledger_amt_payment_amt, 2) }}
                        </td>
                    </tr>

                    <tr>
                        <td class="text-right">
                            <b>{{ $total_due_refund_amt >= 0 ? 'Due' : 'Balance' }} Tk.
                                :</b></td>
                        <td class="text-right">{{ number_format(abs($total_due_refund_amt), 2) }}
                        </td>
                    </tr>

                </tbody>
            </table>

    @endif

    <div style="border: 1px solid #dee2e6; padding: 10px; margin-top: 10px;">
    
        <table class="table table-bordered mt-3">
            <tbody>


                @php
                    $totalPayAmount = 0;
                @endphp
                @if (!empty($paymentHistories))
                    @foreach ($paymentHistories as $key => $payhistory)
                        <tr>
                            <td class="text-center">
                                <b> {{ date('d/m/Y', strtotime($payhistory->invoice_date)) }}</b>
                            </td>
                            <td char="text-center"><b>{{ ucfirst($payhistory->pay_type) }}</b>
                            </td>
                            <td class="text-left">{{ $payhistory->ledger_entry_txt }}</td>
                            <td class="text-right">
                                {{ number_format(abs($payhistory->ledger_amt_payment), 2) }}</td>
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
    </div>

<footer>
    <?php
    $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
    $date = $dt->format('g:i A');
    ?>
    <div class="">
        <span style="float:left;">Prepared By: {{ $userInfo->user_fullname }}</span> &nbsp; <span
            style="">Printing Date & Time: {{ date('d/m/Y') }} , {{ $date }} </span>&nbsp;
        <span style="float:right">Powered By: NEXTGEN IT</span>
    </div>
</footer>
