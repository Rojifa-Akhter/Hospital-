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
                                <th colspan="4" class="text-center no-line"><span
                                        class="btn btn-sm bg-primary btn-rounded">Customer Copy</span></th>
                            </tr>
                            <tr>
                                <th class="text-left">Supplier Name : </th>
                                <td class="text-left">
                                    {{ !empty($supplier_info->supplier_name) ? $supplier_info->supplier_name : '' }}
                                </td>
                                <th class="text-right">Supplier UID : </th>
                                <td class="text-right">
                                    {{ !empty($supplier_info->supplier_uid) ? $supplier_info->supplier_uid : '' }}
                                </td>
                            </tr>
                            <tr>
                                <th class="text-left">Challan Number : </th>
                                <td class="text-left">
                                    {{ !empty($supplier_info->bill_challan_number) ? $supplier_info->bill_challan_number : '' }}
                                </td>
                                <th class="text-right">Date of Payment : </th>
                                <td class="text-right">
                                    {{ !empty($supplier_info->payment_date) ? date('d/m/Y', strtotime($supplier_info->payment_date)) : '' }}
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
                            <thead>
                                <tr>
                                    <td class="w-5 bg-primary text-center"><strong>SL#</strong></td>
                                    <td class="text-left bg-primary"><strong>PO UID</strong></td>
                                    <td class=" text-left bg-primary"><strong>PO Paid Status</strong></td>
                                    <td class=" text-right bg-primary"><strong>PO Deduct Amt.</strong></td>
                                    <td class=" text-right bg-primary"><strong>PO Payment Amt.</strong></td>
                                    <td class=" text-right bg-primary"><strong>PO Amt.</strong></td>

                                </tr>
                            </thead>
                            <tbody>
                                @if (!empty($payment_info))

                                    @php
                                        $total_po_amt = 0;
                                        $total_dis_amt = 0;
                                        $dis_amt = 0;
                                        $total_paid_amt = 0;
                                        $pre_po_amount_deduct = 0;
                                        $payable_amt = 0;
                                        $total_deduct_amt = 0;
                                        $total_current_payment_amt = 0;
                                        $due = 0;
                                        $in_words = 0;
                                    @endphp
                                    @foreach ($payment_info as $data)
                                        @php
                                            $total_po_amt += $data->po_amount;
                                            $total_dis_amt += $data->past_po_dis_amount;
                                            $dis_amt += $data->po_amount_discount;
                                            $total_paid_amt += $data->past_po_pay_amount;
                                            $pre_po_amount_deduct += $data->past_po_ded_amount;
                                            $payable_amt = $total_po_amt - $total_dis_amt - $total_paid_amt + $pre_po_amount_deduct;
                                            $total_deduct_amt += $data->po_amount_deduct;
                                            $total_current_payment_amt += $data->po_amount_payment;
                                            $due = (($payable_amt + $total_deduct_amt )- $dis_amt) - $total_current_payment_amt;
                                            $locale = 'en_US';
                                            $fmt = numfmt_create($locale, NumberFormatter::SPELLOUT);
                                            $in_words = numfmt_format($fmt, $payable_amt);
                                        @endphp
                                        <tr>
                                            <td class=" text-center">{{ $loop->iteration }}</td>
                                            <td class="text-left ">{{ $data->purchase_uid }}</td>
                                            <td class="text-left ">
                                                {{ $data->po_fullpaid_ind == 1 ? 'Paid' : 'Due' }}</td>
                                            <td class="text-right ">{{ number_format($data->po_amount_deduct, 2) }}
                                            </td>
                                            <td class="text-right ">
                                                {{ number_format($data->po_amount_payment, 2) }}
                                            </td>
                                            <td class="text-right ">{{ number_format($data->po_amount, 2) }}</td>

                                        </tr>
                                    @endforeach
                            <tfoot style="border-top: 1px solid #222!important;">
                                <tr>
                                    <td rowspan="9" colspan="4">
                                        <div style="margin-bottom: 5px; ">
                                            <span
                                                style="font-size: 30px; line-height: 1; border: 5px solid
                                                            #dee2e6; border-left-color: #dee2e6; color: #909dab; padding: 10px;">
                                                @if ($due == 0)
                                                    <strong>PAID</strong>
                                                @elseif($due<0) <strong>Advance</strong>
                                                    @else
                                                        <strong>DUE</strong>
                                                @endif
                                            </span>
                                        </div>
                                        <br>
                                        <b>Cash Receipt In :</b>
                                        @if (!empty($total_current_payment_amt))
                                            @if (!empty($supplier_info->pay_mode && $supplier_info->pay_mode == 'cash'))
                                                Cash : {{ $total_current_payment_amt }}
                                            @elseif (!empty($supplier_info->pay_mode) && $supplier_info->pay_mode ==
                                                'cheque')
                                                Cheque : {{ $total_current_payment_amt }}
                                            @endif
                                        @else
                                            @if (!empty($supplier_info->pay_mode && $supplier_info->pay_mode == 'cash'))
                                                Cash : {{ $total_deduct_amt }}
                                            @elseif (!empty($supplier_info->pay_mode) && $supplier_info->pay_mode ==
                                                'cheque')
                                                Cheque : {{ $total_deduct_amt }}
                                            @endif
                                        @endif
                                        <div style="padding-top: 5px">
                                            <b>In Word :</b> {{ ucwords($in_words) }} Taka Only
                                        </div>
                                    </td>
                                    <td class="text-right border-none">
                                        <strong>Total PO Amt.</strong>
                                    </td>
                                    <td class="text-right border-none">
                                        {{ number_format($total_po_amt, 2) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-right border-none">
                                        <strong> Discounted Amt.</strong>
                                    </td>
                                    <td class="text-right border-none">
                                        {{ number_format($total_dis_amt, 2) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-right border-none">
                                        <strong> Deducted Amt : </strong>
                                    </td>
                                    <td class="text-right border-none">
                                        <strong> {{ number_format($pre_po_amount_deduct, 2) }} </strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-right border-none">
                                        <strong> Paid Amt</strong>
                                    </td>
                                    <td class="text-right border-none">
                                        {{ number_format($total_paid_amt, 2) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-right border-none">
                                        <strong>Payable Amt.</strong>
                                    </td>
                                    <td class="text-right border-none">
                                        {{ number_format($payable_amt, 2) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-right border-none">
                                        <strong>Discount Amt.</strong>
                                    </td>
                                    <td class="text-right border-none">
                                        {{ number_format($dis_amt, 2) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-right border-none">
                                        <strong> Deduct Amt</strong>
                                    </td>
                                    <td class="text-right border-none">
                                        {{ number_format($total_deduct_amt, 2) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-right border-none">
                                        <strong> Payment Amt</strong>
                                    </td>
                                    <td class="text-right border-none">
                                        {{ number_format($total_current_payment_amt, 2) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-right border-none">
                                        <strong>Due</strong>
                                    </td>
                                    <td class="text-right border-none">
                                        {{ number_format($due, 2) }}
                                    </td>
                                </tr>
                            </tfoot>
                            @endif

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr />
    <div class="row">
        @php
            $supledger_id = $suppledger_id;
        @endphp
        <div class="col-md-12">
            <a href="{{ route('suplier-payment-invoice_print', $supledger_id) }}" target="_blank"
                class="btn btn-warning btn-md" title="Click here to Clear form data">Print</a>
            <button type="reset" class="btn btn-danger btn-md" title="Click here to Clear form data"
                data-dismiss="modal">Close</button>
            <a href="{{ route('home') }}" class="btn btn-info btn-md" rel="tab"
                title="Click here to go back to Dashboard" data-dismiss="modal">Exit</a>
        </div>
    </div>
</div>
