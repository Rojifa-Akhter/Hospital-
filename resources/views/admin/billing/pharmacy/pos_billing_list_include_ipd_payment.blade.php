<form action="{{ route('pos-ipd-payment-store') }}" method="post" id="idpPayment">
    <div class="form-check form-check-inline col-md-4 mr-0">
        <label class="form-check-label col-md-4" for="service_point">Service Point</label>
        <select class="form-control keep_me col-md-8" id="service_point" name="service_point" required>
            <option value="">Select One</option>
            @if (!empty($service_point))
                @foreach ($service_point as $value)
                    @if ($value->default_ind == 1)
                        <option selected value="{{ $value->serviceunit_no_pk }}" data-posind="{{ $value->hs_pos_ind }}">
                            {{ $value->serviceunit_name }}</option>
                    @else
                        <option data-posind="{{ $value->hs_pos_ind }}" value="{{ $value->serviceunit_no_pk }}">
                            {{ $value->serviceunit_name }}</option>
                    @endif
                @endforeach
            @endif
        </select>
    </div>
    <table id="datatable" class="table data-table table-bordered table-hover table-striped bill-list">
        <thead class="bg-primary">
            <tr>
                <th class="text-center w-5" scope="">SL</th>
                <th class="text-left " scope="">Invoice No</th>
                <th class="text-left " scope="">Invoice Date & Time</th>
                <th class="text-left" scope="col"> Admission Id </th>
                <th style="text-align: left" scope="col">Item Info</th>
                <th style="text-align: right" scope="col">Qty</th>
                <th style="text-align: right" scope="col">Cx. Qty</th>
                <th style="text-align: right" scope="col">Amt.</th>
                <th class="text-right " scope="col">Sales Amt.</th>
                <th class="text-right " scope="col">Dis. Amt.</th>
                <th class="text-right " scope="col">Payment Amt.</th>
                <th class="text-right " scope="col">All Select <input type="checkbox" name=""
                        id="all_checked"></th>
                <th class="text-center " scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @php
                $sl = 1;
                $sales = 0;
                $dis = 0;
                $payment = 0;
                $due = 0;
                $refund = 0;
                $total_sales = 0;
                $total_dis = 0;
                $total_payment = 0;
                $total_due = 0;
                $total_refund = 0;
                $refund_amt =0;
            // dd($bill_info , $item_info);
            @endphp
            @if (!empty($bill_info))

                @foreach ($bill_info as $value)

                    @php
                        $sales = $value->ledger_amt_sales != '' ? $value->ledger_amt_sales : 0;
                        $dis = $value->discount != '' ? $value->discount : 0;
                        $payment = $value->collection != '' ? $value->collection : 0;
                        $refund = $value->refund != '' ? $value->refund : 0;

                        $payable = $sales - $dis - $payment;
                        $due = $payable >= 0 ? $payable : 0;
                        $refund_amt = $payable < 0 ? $payable : 0;


                    @endphp

                    <tr>
                        <td class="text-center " scope="col">{{ $sl++ }}</td>
                        <td class="text-left" scope="">
                            <strong> {{ $value->invoice }} </strong>

                        </td>
                        <td class="text-left">
                            {{ $value->invoice_date != '' ? date('d/m/Y', strtotime($value->invoice_date)) : '' }} ,
                            {{ $value->au_entry_time != '' ? date('h:i:s a', strtotime($value->au_entry_time)) : '' }}
                        </td>
                        <td class="text-left " scope="col">
                            {{-- Patient Id = {{ $value->patient_code }} <br> --}}
                         <strong>   {{ $value->admission_no_pk }} </strong>
                            {{-- {{ $value->patient_code }} <br>
                            {{ $value->patient_name }} <br>
                            {{ $value->patient_gender }} <br>
                            {{ $value->mobile1 }} --}}
                        </td>
                        <td class="text-left " scope="col">

                            @if (!empty($item_info))
                                @foreach ($item_info as $item)
                                    @if ( $item->invoice_no_fk == $value->invoice)
                                        {{ $item->item_name }} <br>
                                    @endif
                                @endforeach
                            @endif

                        </td>
                        <td class="text-right " scope="col">

                            @if (!empty($item_info))
                                @foreach ($item_info as $item)
                                    @if ($item->invoice_no_fk == $value->invoice)
                                        {{ $item->current_item_qty }} <br>
                                    @endif
                                @endforeach
                            @endif
                        </td>
                        <td class="text-right " scope="col">
                            @if (!empty($item_info))
                                @foreach ($item_info as $item)
                                    @if ($item->invoice_no_fk == $value->invoice )
                                        {{ $item->cancel_qty }} <br>
                                    @endif
                                @endforeach
                            @endif
                        </td>

                        <td style="text-align: right" class="" scope="col">
                            @if (!empty($item_info))
                                @foreach ($item_info as $item)
                                    @if ($item->invoice_no_fk == $value->invoice )
                                        {{ $item->total_item_amt }} <br>
                                    @endif
                                @endforeach
                            @endif
                        </td>
                        <td class="text-right " scope="col">
                            <input type="hidden" class="sales_amt" value="{{ $sales }}">
                            <input type="hidden" class="discount_amt" value="{{ round($dis) }}">
                            <input type="hidden" class="collection_amt" value="{{ round($payment) }}">
                            {{ number_format($sales, 2) }}
                        </td>
                        <td class="text-right " scope="col">
                            {{ number_format(round($dis), 2) }}
                        </td>
                        <td class="text-right " scope="col">
                            {{ number_format(round($payment+$refund), 2) }}
                        </td>
                        <td class="text-right " scope="col"><input type="checkbox" class="select_all"
                                name="payment[]" id="payment"
                                value="{{ $value->admission_no_pk . '_' . $value->invoice . '_' . round(($sales - $dis) - ( $payment + $refund)) }}"
                                onclick="checkSingle(this)" @if ( (round($sales) - $dis) == round($payment +$refund )) disabled @endif></td>

                        @php
                            $trn_no = $value->invoice_trn_list != '' ? explode(',', $value->invoice_trn_list) : '';
                            $last_trn = $trn_no != '' ? end($trn_no) : 0;
                        @endphp
                        <td class="text-center " scope="col">
                            <span Class="btn btn-sm btn-success open-modal btnView"
                                data-action="{{ route('pos-due-colletion-invoice', [$value->invoice, $last_trn]) }}"
                                data-modal="common-modal-md" data-title="Invoice Details" title="View Invoice Details"
                                data-id="{{ $value->invoice }}"><i class="fa fa-eye"></i></span>
                        </td>

                    @php
                        $total_sales += $sales;
                        $total_dis += $dis;
                        $total_payment += $payment;
                        $total_due += $due;
                        $total_refund += $refund;
                    @endphp
                @endforeach
            @endif
        </tbody>
    </table>


    <div class="form-row justify-content-between">
        <div class="col-md-12">
            <div class="card shadow-sm mt-1" id="amount_info">
                <div class="card-body p-1">
                    <div class="right_side">
                        <div class="form-row">
                            <div class="col-md-5">

                                <ul class="list-group list-group-flush bg-light-blue rounded mb-2 border ">
                                    <li class="list-group-item d-flex align-items-center justify-content-between">
                                        <h6 class="float-left mr-2 mb-0">Discount&nbsp;Type&nbsp;&nbsp;:</h6>
                                        <select class="form-control" name="" id="cmb_discount_due">
                                            @if (!empty($disctype))

                                                @foreach ($disctype as $key => $dtype)

                                                @if($key == 'GENERAL')
                                                    <option value="{{ $key }}"
                                                        {{ $key == 'GENERAL' ? 'selected' : '' }}>{{ $dtype }}
                                                    </option>
                                                @endif
                                                @endforeach
                                            @endif
                                        </select>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="form-row">
                                            <div class="col-md-12 ">
                                                <div class="d-flex justify-content-end">
                                                    <div class="percent_hospital ">
                                                        <span class="mr-2">Hospital Prc.</span>
                                                        <input type="text" class="  number_only"
                                                            id="discount_percent" name="discount_percent"
                                                            placeholder="%" style=" text-align: right;"
                                                            onkeyup="" onfocusout="">
                                                        <input type="text" class="  number_only" id="discount_amt"
                                                            name="discount_amt" placeholder="Amount"
                                                            style=" text-align: right;"
                                                            onkeyup="calCulatePayment(this.value)"
                                                            onfocusout="calCulatePayment(this.value)">
                                                    </div>
                                                </div>


                                                <div class="d-flex justify-content-end">
                                                    <div class="percent_doctor d-none">
                                                        <span class="mr-2">Doctor Prc.</span>&nbsp;&nbsp;&nbsp;

                                                        <input type="text" class="  number_only"
                                                            id="discount_percent_doctors" name="discount_percent"
                                                            placeholder="%" style=" text-align: right;"
                                                            onkeyup="" onfocusout="">
                                                        <input type="text" class="  number_only"
                                                            id="discount_amt_doctor" name="doctor_amt"
                                                            placeholder="Amount" style=" text-align: right;"
                                                            onkeyup="calCulatePayment(this.value)"
                                                            onfocusout="calCulatePayment(this.value)">
                                                        <input type="hidden" id="disc_amt_hdn" name="">
                                                        <input type="hidden" id="disc_amt_hdn" name="">

                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </li>

                                    <li class="list-group-item d-flex align-items-center justify-content-between">
                                        <h6 class="float-left mr-2 mb-0">Discount&nbsp;By&nbsp;&nbsp;:</h6>
                                        <input type="text" name="" placeholder="Discount By"
                                            id="doctor_code_dis" class="form-control">
                                        <input type="hidden" name="hdn_doctor_id" id="hdn_doctor_id_dis">
                                    </li>
                                    <li class="list-group-item d-flex align-items-center justify-content-between">
                                        <h6 class="float-left mr-2 mb-0"> Request&nbsp;By&nbsp;&nbsp;:</h6>
                                        <input type="text" name="dis_requ_by" placeholder="Discount Request By"
                                            id="dis_requ_by" class="form-control">

                                    </li>

                                    <li class="list-group-item">
                                        <div class="form-row">
                                            <div class="col-md-4 d-flex align-items-center ">

                                                <div class="">
                                                    <input type="hidden" class="form-control number_only"
                                                        id="pay_amount" name="pay_amount" onkeyup=""
                                                        onfocusout="calCulatePayment(this.value)" placeholder="00.00"
                                                        style="width: 70px; text-align: right;" value="">
                                                </div>
                                            </div>

                                        </div>
                                    </li>
                                </ul>
                            </div>

                            <div class=" clearfix table-responsive mt-2 col-md-7">
                                <table class="table table-hover fixed_header table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Mode</th>
                                            <th style="text-align: right;">Amount</th>
                                            <th>Type (Card/Mbank)</th>
                                            <th>Bank</th>
                                            <th>Transaction ID</th>
                                            <th>Card No</th>
                                            <th colspan="2">Holder Name</th>

                                        </tr>
                                    </thead>
                                    <tbody id="tbody">

                                    </tbody>
                                    <tfoot id="tfoot">


                                    </tfoot>
                                </table>
                            </div>


                            <div class="col-md-5">
                                <div class="clearfix">
                                    <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                                        <div class="btn-group bg-none w-100" data-toggle="buttons"
                                            aria-label="First group">

                                            @if (!empty($paymodes))
                                                @foreach ($paymodes as $key => $paymode)
                                                    <label class="btn btn-outline-primary bg-none ">
                                                        <input type="radio" name="pay_mode" id="option"
                                                            class="keep_me" value="{{ $key }}"
                                                            {{ $key == 'CS' ? 'checked' : ' ' }}> {{ $paymode }}
                                                    </label>
                                                @endforeach
                                            @endif

                                        </div>
                                    </div>
                                </div>
                                <div class="form-row border-top mt-1">
                                    <div class="col-md-12">
                                        <div class="" id="cash">
                                            <div class="mb-2 mt-2">
                                                <input type="text" class="form-control cash_amount number_only "
                                                    name="cash_amount" id="cash_amount" value=""
                                                    placeholder="Paid Amount" onkeyup="calculateChangeAmt(this)">
                                            </div>
                                            <input type="text" class="form-control cash_amount number_only "
                                                name="cash_amount" id="cash_bd_amount" checked="checked"
                                                value="" placeholder="Given Amount"
                                                onkeyup="calculateChangeAmt(this)">


                                            <div class="mb-2 mt-2">
                                                <input type="text" id="change_amount"
                                                    class="form-control number_only" placeholder="Change Amount">
                                            </div>

                                            <div style="border: 1px solid black"
                                                class=" float-right mt-2 text-white bg-success">
                                                <button type="button" onkedown="addFuntion(this)"
                                                    onclick="addFuntion(this)" name="cash_amount" id="cash_add"
                                                    class="  bg-success"> Add </button>
                                            </div>

                                        </div>
                                        <div id="payment_method_cheque" class="d-none">
                                            <div class="cheque_field mb-2 mt-2">
                                                <input type="text" class="form-control check_amount number_only"
                                                    name="check_amount" id="check_amount" checked="checked"
                                                    value="" placeholder="Amount">
                                            </div>
                                            <div class="cheque_field mb-2 mt-2">

                                                <select class="form-control select2 payment_method_1" id="bank_name"
                                                    name="bank_name">
                                                    <option value="">Bank name</option>
                                                    @if ($bank_name)
                                                        @foreach ($bank_name as $value)
                                                            <option value="{{ $value }}">{{ $value }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="cheque_field mb-2 mt-2">
                                                <input type="text"
                                                    class="form-control payment_method_1
                                                    "
                                                    name="holder_name" id="holder_name" checked="checked"
                                                    value="" placeholder="Holder Name">
                                            </div>
                                            <div class="cheque_field mb-2 mt-2">
                                                <input type="text" class="form-control payment_method_1"
                                                    name="check_no" id="check_no" checked="checked" value=""
                                                    maxlength="16" placeholder="Cheque No">
                                            </div>

                                            <div style="border: 1px solid black"
                                                class=" float-right mt-2 text-white bg-success">
                                                <button type="button" onkedown="addFuntion(this)"
                                                    onclick="addFuntion(this)" value="" name="check_amount"
                                                    id="check_add" class="  bg-success"> Add </button>
                                            </div>

                                        </div>
                                        <div class="d-none" id="payment_method_card">
                                            <select class="form-control" id="card_type" name="card_type">
                                                <option value="">Card Type</option>
                                                <option value="visa">Visa</option>
                                                <option value="master">Master</option>

                                            </select>
                                            <div class="cheque_field mb-2 mt-2">
                                                <input type="text" class="form-control card_amount number_only"
                                                    name="card_amount" id="card_amount" checked="checked"
                                                    value="" placeholder="Amount">
                                            </div>
                                            <div class="cheque_field mb-2 mt-2">

                                                <select class="form-control select2 payment_method_1"
                                                    id="bank_name_card" name="bank_name_card">
                                                    <option value="">Bank name</option>
                                                    @if ($bank_name)
                                                        @foreach ($bank_name as $value)
                                                            <option value="{{ $value }}">{{ $value }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>

                                            </div>
                                            <div class="cheque_field mb-2 mt-2">
                                                <input type="text"
                                                    class="form-control payment_method_1
                                                    "
                                                    name="cards_holder_name" id="card_holder_name" checked="checked"
                                                    value="" placeholder="Holder Name">
                                            </div>

                                            <div class="card-field mb-2 mt-2">
                                                <input type="text" class="form-control payment_method_2 "
                                                    name="card_no" id="card_no" value=""
                                                    placeholder="Card No (minimum 4 digits)" minlength="4" maxlength="20">
                                            </div>

                                            <div style="border: 1px solid black"
                                                class=" float-right mt-2 text-white bg-success">
                                                <button type="button" onkedown="addFuntion(this)"
                                                    onclick="addFuntion(this)" value="" name="card_amount"
                                                    id="card_add" class="  bg-success"> Add </button>
                                            </div>
                                        </div>

                                        <div class="d-none" id="payment_method_bkash">


                                            <select class="form-control" id="mBanking_type" name="mBanking_type">
                                                <option value="">Mobile Banking Name</option>
                                                <option value="bKash">bKash</option>
                                                <option value="nogod">Nogod</option>
                                                <option value="rocket">Rocket</option>
                                            </select>

                                            <div class="cheque_field mb-2 mt-2">
                                                <input type="text" class="form-control mBank_amount number_only"
                                                    name="mBank_amount" id="mBank_amount" checked="checked"
                                                    value="" placeholder="Amount">
                                            </div>
                                            <div class="cheque_field mb-2 mt-2">
                                                <input type="text" class="form-control payment_method_1 "
                                                    name="bkash_txn_id" id="bkash_txn_id" checked="checked"
                                                    value="" placeholder=" Transection ID">
                                            </div>
                                            <div style="border: 1px solid black"
                                                class=" float-right mt-2 text-white bg-success">
                                                <button type="button" onkedown="addFuntion(this)"
                                                    onclick="addFuntion(this)" value="" name="bkash_amount"
                                                    id="bkash_add" class="  bg-success"> Add </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12  mt-2">
                                    @php
                                        $bill_id = '';
                                        $response_url = route('pos-billing-ipd-payment-slip', $bill_id );
                                    @endphp
                                    <input type="hidden" name="hdn_patient_id"
                                        value="{{ isset($patient_info->patient_no_pk) ? $patient_info->patient_no_pk : '' }}"
                                        readonly="readonly">
                                    <input type="hidden" name="page_type" value="2" class="keep_me">
                                    <!-- <div class="btn btn-md btn-info">Save&nbsp;&&nbsp;Print</div> -->
                                    <button class="btn btn-md btn-success" data-response_action="{{ $response_url }}"
                                        onclick="billingEngine.createIpdDueCollection(this,resetDueBillForm)">Save&nbsp;&&nbsp;Show</button>
                                    <!-- <button class="btn btn-md btn-danger">Cancel</button> -->
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="card shadow-sm mt-1" id="amount_info">
                                    <div class="card-body p-1">
                                        <div class="right_side">
                                            <div class="form-row">
                                                <div class="col-md-12">
                                                    <ul
                                                        class="list-group list-group-flush bg-light-blue rounded mb-2 border">
                                                        <li
                                                            class="list-group-item d-flex align-items-center justify-content-between">
                                                            @php

                                                                $total_amount = 0;
                                                                $urgent_fee = isset($finc_inv_sum_amount->urgent_fee) ? $finc_inv_sum_amount->urgent_fee : 0;
                                                                $vat = isset($finc_inv_sum_amount->ledger_amt_vat) ? $finc_inv_sum_amount->ledger_amt_vat : 0;
                                                                $led_amt_sales = isset($finc_inv_sum_amount->ledger_amt_sales) ? $finc_inv_sum_amount->ledger_amt_sales : 0;
                                                                $discount = isset($finc_inv_sum_amount->discount) ? round($finc_inv_sum_amount->discount) : 0;
                                                                $cancel_discount = isset($finc_inv_sum_amount->cancel_discount) ? $finc_inv_sum_amount->cancel_discount : 0;

                                                                $payment = isset($finc_inv_sum_amount->collection) ? $finc_inv_sum_amount->collection : 0;
                                                                $total_payment = isset($finc_inv_sum_amount->net_collection) ? $finc_inv_sum_amount->net_collection : 0;

                                                                $due = isset($led_amt_sales) ? round($led_amt_sales + $vat - $discount - $total_payment) : 0;

                                                                $refund = isset($finc_inv_sum_amount->refund) ? $finc_inv_sum_amount->refund : 0;
                                                                $total = round($led_amt_sales);
                                                                $total_amount = $led_amt_sales + $vat + $urgent_fee;
                                                            @endphp
                                                            <h5 class="float-left mr-2 mb-0">Total Item Amount</h5>
                                                            <span
                                                                class="float-right btn btn-outline-success bg-none btn-md"
                                                                id="net_payable">{{ number_format(round($total), 2, '.', '') }}</span>
                                                            <input type="hidden" id="total_amt_dis" name=""
                                                                value="{{ number_format((float) $total, 2, '.', '') }}">
                                                        </li>
                                                        <li
                                                            class="list-group-item d-flex align-items-center justify-content-end">
                                                            <span class="mr-2">Total VAT.</span>
                                                            <div class="d-flex align-items-center">
                                                                <input type="text" class="form-control number_only"
                                                                    id="" name="" placeholder="0.00"
                                                                    style="width:70px; text-align: right;"
                                                                    value="{{ $vat }}">
                                                            </div>
                                                        </li>
                                                        <li
                                                            class="list-group-item d-flex align-items-center justify-content-end">
                                                            <span class="mr-2">Total Urgent Fee</span>
                                                            <div class="">
                                                                <input type="text" class="form-control number_only"
                                                                    id="urgent_fee" name="urgent_fee"
                                                                    placeholder="00.00" disabled="disabled"
                                                                    value="{{ isset($urgent_fee) ? number_format((float) $urgent_fee, 2, '.', '') : '0' }}"
                                                                    style="width: 70px; text-align: right;">
                                                            </div>
                                                        </li>
                                                        <li
                                                            class="list-group-item d-flex align-items-center justify-content-end">
                                                            <span class="mr-2">Total Invoice Amt.</span>
                                                            <div class="">
                                                                <input type="text" id="paid_amount"
                                                                    class="form-control number_only"
                                                                    style="width: 70px; text-align: right;"
                                                                    maxlength="8" placeholder="00.00"
                                                                    value="{{ number_format(round($total_amount), 2, '.', '') }}">
                                                            </div>
                                                        </li>

                                                        <li
                                                            class="list-group-item d-flex align-items-center justify-content-end">
                                                            <span class="mr-2">Discounted Amount</span>
                                                            <div class="">
                                                                <input type="text" id="discounted_amount"
                                                                    class="form-control number_only"
                                                                    style="width: 70px; text-align: right;"
                                                                    placeholder="00.00"
                                                                    value="{{ isset($discount) ? number_format($discount, 2, '.', '') : '0' }}">
                                                            </div>
                                                        </li>
                                                        <li
                                                        class="list-group-item d-flex align-items-center justify-content-end">
                                                        <span class="mr-2"> Advance Paid </span>
                                                        <div class="">
                                                            <input type="text" id="advance_payment"
                                                                class="form-control number_only"
                                                                style="width: 70px; text-align: right;"
                                                                maxlength="8" placeholder="00.00"
                                                                value="{{ isset($advance_paid) && !empty($advance_paid) ? number_format((float) $advance_paid->net_collection, 2, '.', '') : '0' }}">
                                                        </div>
                                                    </li>
                                                        <li
                                                            class="list-group-item d-flex align-items-center justify-content-end">
                                                            <span class="mr-2">Paid Amount</span>
                                                            <div class="">
                                                                <input type="text" id="initial_payment"
                                                                    class="form-control number_only"
                                                                    style="width: 70px; text-align: right;"
                                                                    maxlength="8" placeholder="00.00"
                                                                    value="{{ isset($payment) ? number_format((float) $payment, 2, '.', '') : '0' }}">
                                                            </div>
                                                        </li>


                                                        <li
                                                            class="list-group-item d-flex align-items-center justify-content-end">
                                                            <span class="mr-2">Due Amount</span>
                                                            <div class="">
                                                                <input type="text" id="due_payment"
                                                                    class="form-control number_only"
                                                                    style="width: 70px; text-align: right;"
                                                                    maxlength="8" placeholder="00.00"
                                                                    value="{{ $due >= 0 && $refund <= 0 ? number_format($due, 2, '.', '') : 0.0 }}">
                                                            </div>
                                                        </li>

                                                        <li
                                                            class="list-group-item d-flex align-items-center justify-content-end">
                                                            <span class="mr-2">Cash Refund</span>
                                                            <div class="">
                                                                <input type="text" id="cash_refund"
                                                                    class="form-control number_only"
                                                                    style="width: 70px; text-align: right;"
                                                                    maxlength="8" placeholder="00.00"
                                                                    value="{{ $refund > 0 ? number_format($refund, 2, '.', '') : 0.0 }}">
                                                            </div>
                                                        </li>

                                                        <li
                                                            class="list-group-item d-flex align-items-center justify-content-end">
                                                            <span class="mr-2">Total Paid Amount</span>
                                                            <div class="">
                                                                <input type="text" id="total_paid_amount"
                                                                    class="form-control number_only"
                                                                    style="width: 70px; text-align: right;"
                                                                    maxlength="8" placeholder="00.00">
                                                            </div>
                                                        </li>

                                                        <li
                                                            class="list-group-item d-flex align-items-center justify-content-end">
                                                            <span class="mr-2">Total Discount</span>
                                                            <div class="">
                                                                <input type="text" id="total_discount"
                                                                    class="form-control number_only"
                                                                    style="width: 70px; text-align: right;"
                                                                    maxlength="8" placeholder="00.00">
                                                            </div>
                                                        </li>
                                                        @php
                                                            // if (isset($total_dis)) {
                                                            //     $final_due = $total_amount - $c_discount->disc_amount - $total_sales->ledger_amt_payment;
                                                            // } else {
                                                            //     $final_due = 0;
                                                            // }
                                                            if (isset($due)) {
                                                                // $final_due= $total_amount - $c_discount->disc_amount - $total_sales->ledger_amt_payment;
                                                                $final_due = $due;
                                                            } else {
                                                                $final_due = 0;
                                                            }

                                                        @endphp
                                                        @if ($final_due >= 0 && $refund_amt <= 0)
                                                            <li
                                                                class="list-group-item d-flex align-items-center justify-content-end">
                                                                <h5 class="mb-0 mr-2" id="final_due">Final Due</h5>
                                                                <input type="hidden" class="form-control mb-0"
                                                                    id="total_due" name="total_due">
                                                                <span class="btn btn-outline-danger bg-none btn-md"
                                                                    id="total_due_con">
                                                                    {{ isset($final_due) ? number_format((float) abs($final_due), 2, '.', '') : '00.00' }}</span>
                                                            </li>
                                                        @elseif($refund_amt > 0)
                                                            <li
                                                                class="list-group-item d-flex align-items-center justify-content-end">
                                                                <h5 class="mb-0 mr-2" id="final_due">Refund</h5>
                                                                <input type="hidden" class="form-control mb-0"
                                                                    id="total_due" name="total_due">
                                                                <span class="btn btn-outline-danger bg-none btn-md"
                                                                    id="total_due_con">
                                                                    {{ isset($refund_amt) ? number_format((float) abs($refund_amt), 2, '.', '') : '00.00' }}</span>
                                                            </li>
                                                        @endif

                                                    </ul>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<script>
     openDoctorAutocomplete('#doctor_code_dis', 'hdn_doctor_id_dis');
</script>
