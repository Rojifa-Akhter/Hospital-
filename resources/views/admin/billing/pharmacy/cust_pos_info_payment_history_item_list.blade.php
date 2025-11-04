<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<div class="form-row">
    @include('admin.billing.due_collection.patient_info')
    <div class="col-md-7">
        <div class="privious-history">
            <div class="card shadow-sm mt-1">
                <div class="card-header">
                    <h5>Invoice Payment & Discount History </h5>
                </div>
                <div class="card-body p-1">
                    <table class="table table-bordered mb-0">
                        <thead class="bg-primary">
                            <tr>
                                <th class="text-center">SL#</th>
                                <th class="text-center">Pay Date</th>
                                <th class="text-right">Pay Amt.</th>
                                <th class="text-right">Dis. Amt.</th>
                                <th class="text-left">Collected By</th>
                                <th class="text-left">Pay Mode</th>
                                <th class="text-left">Pay Type</th>
                                <th class="text-left">Disc. Mode</th>
                                <th class="text-left">Disc. Auth. By</th>
                            </tr>
                        </thead>
                        <tbody class="item_list">

                            @if (!empty($invoice_pay_dis_his))
                                @foreach ($invoice_pay_dis_his as $value)
                                    @php
                                        $dis = $value->ledger_amt_discount >= 0 ? abs(number_format($value->ledger_amt_discount, 2, '.', '')) : '(' . abs(number_format($value->ledger_amt_discount, 2, '.', '')) . ')';
                                    @endphp

                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="text-center">{{ date('d/m/Y', strtotime($value->invoice_date)) }}</td>
                                        <td class="text-right">
                                            {{ isset($value->ledger_amt_payment) ? $value->ledger_amt_payment : '0' }}
                                        </td>
                                        <td class="text-right">{{ isset($value->ledger_amt_discount) ? $dis : '0' }}</td>
                                        <td class="text-left">
                                            {{ isset($value->ledger_entry_txt) ? $value->ledger_entry_txt : '' }}</td>
                                        <td class="text-left">{{ $value->pay_mode == '0' ? ' ' : $value->pay_mode }}</td>

                                        <td class="text-left">
                                            {{ isset($value->pay_mood_type) ? $value->pay_mood_type : '' }}</td>
                                        <td class="text-left">
                                            {{ isset($value->disc_mode_text) ? $value->disc_mode_text : '' }}</td>
                                        <td class="text-left">
                                            {{ $value->discunted_by != '' && $value->disc_mode_text != '' ? $value->discunted_by : '' }}
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="9" class="text-center">No Data Found</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card shadow-sm mt-1">
            <div class="card-header">
                <h5>Invoice Item List</h5>
            </div>
            <div class="card-body p-2">
                <table class="table table-bordered mb-0">
                    <thead>
                        <tr class="bg-primary">
                            <th class="text-center">Item ID</th>
                            <th class="text-left">Item Name</th>
                            <th class="text-left">Item Type</th>
                            <th class="text-left">Department</th>
                            <th class="text-left">Del. Stat.</th>
                            <th class="text-right">Qty</th>
                            <th class="text-right">Rate</th>
                            <th class="text-left">Inv. Status</th>
                            <th class="text-center"></th>
                            <th class="text-right">Cancel Qty</th>
                            <th class="text-center">Report Delivery</th>
                            <th class="text-right">Disc. (%)</th>
                            <th class="text-right">Disc. Amt</th>
                        </tr>
                    </thead>
                    <tbody class="item_list">
                        @if (!empty($invoice_item_list))
                            @foreach ($invoice_item_list as $item)
                                <input type="hidden" name="hdn_item_id[]" value="{{ $item->item_no_fk }}">
                                <input type="hidden" name="hdn_item_name[]" value="{{ $item->item_name }}">
                                <input type="hidden" name="hdn_item_type[]" value="{{ $item->itemtype_no_fk }}">
                                <input type="hidden" name="item_delivery_status[]"
                                    value="{{ $item->delivery_status_lookup_no_fk }}">
                                <input type="hidden" name="delivery_date[]" value="{{ $item->report_delivery_date }}">
                                <input type="hidden" name="hdn_item_qnty[]" value="{{ $item->item_qty }}">
                                <input type="hidden" name="hdn_item_rate[]" class="hdn_item_rate"
                                    value="{{ $item->item_rate }}">
                                <input type="hidden" name="hdn_item_urgent_fee[]" value="{{ $item->urgent_fee }}">
                                <input type="hidden" name="txt_batch[]" value="{{ $item->batch_no }}">
                                <input type="hidden" name="txt_expire_date[]" value="{{ $item->expiry_date }}">
                                <input type="hidden" name="internal_batch_no[]" value="{{ $item->internal_batch_no_uq }}">
                                <tr>
                                    <td class="text-center">{{ $item->item_code }}</td>
                                    <td class="text-left">{{ $item->item_name }}</td>
                                    <td class="text-left">{{ $item->item_type_name }}</td>
                                    <td class="text-left">{{ $item->item_type_name }}</td>
                                    <td class="text-left">
                                        @if ($item->delivery_status_lookup_no_fk == 1)
                                            Routine
                                        @else
                                            Urgent
                                        @endif

                                    </td>
                                    <td class="text-right">{{ $item->item_qty }}</td>
                                    <td class="text-left" class="item_rate" style='font-weight: bold'>
                                        {{ $item->item_rate }}</td>
                                    <td class="text-left">{{ $item->investigation_status }}</td>
                                    <td class="text-center"><input disabled="disabled" type="checkbox" onclick=""
                                            name="" value="" id="cancel_ind"
                                            data-invoice-id="{{ $item->invoicedtl_no_pk }}"
                                            data-item-qty="{{ $item->item_qty }}"
                                            {{ $item->cancel_ind == 1 ? 'checked' : '' }}></td>
                                    <td class="text-right"> <input type="text" name="cancel_checkbox[]"
                                            id="cancel_checkbox_{{ $item->invoicedtl_no_pk }}" class="text-right"
                                            disabled="disabled" value="{{ $item->cancel_qty }}"></td>
                                    <input type="hidden" name="actual_qty[]"
                                        value="{{ $item->item_qty - $item->cancel_qty }}">
                                    <td class="text-right">
                                        {{ $item->report_delivery_date != '' ? date('d/m/Y', strtotime($item->report_delivery_date)) : '' }}
                                        {{-- @if (date('d/m/Y', strtotime($item->report_delivery_date)) == '01/01/1970')

                                @else
                                {{ date("d/m/Y",strtotime($item->report_delivery_date)) }}
                                @endif --}}
                                    </td>
                                    <td class="text-right"> {{ $item->disc_perc }} </td>
                                    <td class="text-right">
                                        {{ number_format((float) $item->disc_amount, 2, '.', '') }} </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="13" class="text-center">No Data Found</td>
                            </tr>
                        @endif




                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="form-row justify-content-between">
    <div class="col-md-12">
        <div class="card shadow-sm mt-1" id="amount_info">
            <div class="card-body p-1">
                <div class="right_side">
                    <div class="form-row">


                        <div class="col-md-5">
                            <ul class="list-group list-group-flush bg-light-blue rounded mb-2 border">
                                <li class="list-group-item d-flex align-items-center justify-content-between">
                                    <h6 class="float-left mr-2 mb-0">Discount&nbsp;Type&nbsp;&nbsp;:</h6>
                                    {{-- <span class="float-right btn btn-outline-success bg-none btn-md" id="net_payable"> 00.00</span> --}}

                                    <select class="form-control" name="" id="cmb_discount_due">
                                        @if (!empty($disctype))
                                            @foreach ($disctype as $key => $dtype)
                                                <option value="{{ $key }}"
                                                    {{ $key == 'GENERAL' ? 'selected' : '' }}>{{ $dtype }}</option>
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


                                                    <!-- <input type="text" name="" value="1">
                <input type="text" name="" value="2"> -->

                                                    <input type="text" class="  number_only" id="discount_percent"
                                                        name="discount_percent" placeholder="%"
                                                        style=" text-align: right;" onkeyup="" onfocusout="">
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
                                                        placeholder="%" style=" text-align: right;" onkeyup=""
                                                        onfocusout="">
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
                                            <!-- <span class="mr-2">Pay Amount</span> -->
                                            <div class="">
                                                <input type="hidden" class="form-control number_only"
                                                    id="pay_amount" name="pay_amount" onkeyup=""
                                                    onfocusout="calCulatePayment(this.value)" placeholder="00.00"
                                                    style="width: 70px; text-align: right;" value="">
                                            </div>
                                        </div>
                                        <!-- <div class="col-md-4 d-flex align-items-center">
             <span class="mr-2">Given Amount</span>
             <div>
              <input id="given_amount" type="text" class="form-control" style="width: 90px; text-align: right;" maxlength="8" placeholder="00.00" onkeyup="calCulateGivenAmount(this.value)">
             </div>
            </div>
            <div class="col-md-4 d-flex align-items-center justify-content-end">
             <span class="mr-2">Change Amount</span>
             <div class="">
              <input type="text" class="form-control number_only" id="change_amount" name="change_amount" placeholder="00.00" disabled="disabled" style="width: 70px; text-align: right;">
             </div>
            </div> -->
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
                                                <label class="btn btn-outline-primary payMode bg-none <?= $key == 'CS' ? 'active' : ' '?>">
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
                                            name="cash_amount" id="cash_bd_amount" checked="checked" value=""
                                            placeholder="Given Amount" onkeyup="calculateChangeAmt(this)">


                                        <div class="mb-2 mt-2">
                                            <input type="text" id="change_amount" class="form-control number_only"
                                                placeholder="Change Amount">
                                        </div>

                                        <!-- <button class="btn btn-md btn-success float-right mt-2" name="cash_amount" id="cash_add"  onclick="">Add</button> -->

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

                                            <!-- <input type="text" class="form-control payment_method_1 " name="bank_name" id="bank_name" checked="checked" value="" placeholder="Bank Name"> -->
                                        </div>
                                        <div class="cheque_field mb-2 mt-2">
                                            <input type="text" class="form-control payment_method_1
													"
                                                name="holder_name" id="holder_name" checked="checked" value=""
                                                placeholder="Holder Name">
                                        </div>
                                        <div class="cheque_field mb-2 mt-2">
                                            <input type="text" class="form-control payment_method_1"
                                                name="check_no" id="check_no" checked="checked" value=""
                                                maxlength="16" placeholder="Cheque No">
                                        </div>
                                        <!-- <span class="btn btn-md btn-success float-right mt-2" name="check_amount" id="check_add" onclick="addFuntion(this)" >Add</span> -->
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
                                                name="card_amount" id="card_amount" checked="checked" value=""
                                                placeholder="Amount">
                                        </div>
                                        <div class="cheque_field mb-2 mt-2">

                                            <select class="form-control select2 payment_method_1" id="bank_name_card"
                                                name="bank_name_card">
                                                <option value="">Bank name</option>
                                                @if ($bank_name)
                                                    @foreach ($bank_name as $value)
                                                        <option value="{{ $value }}">{{ $value }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <!-- <input type="text" class="form-control payment_method_1 " name="bank_name_card" id="bank_name_card" checked="checked" value="" placeholder="Bank Name"> -->
                                        </div>
                                        <div class="cheque_field mb-2 mt-2">
                                            <input type="text" class="form-control payment_method_1
													"
                                                name="cards_holder_name" id="card_holder_name" checked="checked"
                                                value="" placeholder="Holder Name">
                                        </div>

                                        <div class="card-field mb-2 mt-2">
                                            <input type="text" class="form-control payment_method_2 "
                                                name="card_no" id="card_no" value=""
                                                placeholder="Card No (minimum 4 digits)" minlength="4" maxlength="20">
                                        </div>
                                        <!-- <span class="btn btn-md btn-success float-right mt-2" name="card_amount" id="card_add" onclick="addFuntion(this)">Add</span> -->
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
                                        <!-- <span class="btn btn-md btn-success float-right mt-2" name="bkash_amount" id="bkash_add" onclick="addFuntion(this)">Add</span> -->
                                        <div style="border: 1px solid black"
                                            class=" float-right mt-2 text-white bg-success">
                                            <button type="button" onkedown="addFuntion(this)"
                                                onclick="addFuntion(this)" value="" name="bkash_amount"
                                                id="bkash_add" class="  bg-success"> Add </button>
                                        </div>
                                    </div>
                                    <!-- <label for="validationTooltip01">Remarks</label>
           <textarea id="remarks" name="remarks" rows="2" class="form-control"></textarea> -->
                                </div>
                            </div>
                            <div class="col-md-12  mt-2">
                                @php
                                    $bill_id="";
                                    $response_url = route('pos-due-colletion-invoice', $bill_id);
                                @endphp
                                <input type="hidden" name="hdn_patient_id"
                                    value="{{ isset($patient_info->patient_no_pk) ? $patient_info->patient_no_pk : '' }}"
                                    readonly="readonly">
                                <input type="hidden" name="page_type" value="2" class="keep_me">
                                <!-- <div class="btn btn-md btn-info">Save&nbsp;&&nbsp;Print</div> -->
                                <button class="btn btn-md btn-success" data-response_action="{{ $response_url }}"
                                    onclick="billingEngine.createDueCollection(this,resetDueBillForm)">Save&nbsp;&&nbsp;Show</button>
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
                                                            // $total_amount = 0;
                                                            // $urgent_fee = isset($patient_info->urgent_fee)? $patient_info->urgent_fee :'0';
                                                            // $sales =isset($total_item_rates->ledger_amt_sales)? $total_item_rates->ledger_amt_sales :0;
                                                            // $total_amount = $sales;
                                                            $total_amount = 0;
                                                            $urgent_fee = isset($finc_inv_sum_amount->urgent_fee) ? $finc_inv_sum_amount->urgent_fee : 0;
                                                            $vat = isset($finc_inv_sum_amount->ledger_amt_vat) ? $finc_inv_sum_amount->ledger_amt_vat : 0;
                                                            $led_amt_sales = isset($finc_inv_sum_amount->ledger_amt_sales) ? $finc_inv_sum_amount->ledger_amt_sales : 0;
                                                            $discount = isset($finc_inv_sum_amount->discount) ? round($finc_inv_sum_amount->discount) : 0;
                                                            $cancel_discount = isset($finc_inv_sum_amount->cancel_discount) ? $finc_inv_sum_amount->cancel_discount : 0;

                                                            $payment = isset($finc_inv_sum_amount->collection) ? $finc_inv_sum_amount->collection : 0;
                                                            $total_payment = isset($finc_inv_sum_amount->net_collection) ? $finc_inv_sum_amount->net_collection : 0;
                                                            // $due = isset($led_amt_sales) ? $led_amt_sales + $vat - ($discount + $cancel_discount) - $total_payment : 0;
                                                            $due = isset($led_amt_sales) ? round($led_amt_sales + $vat - $discount - $total_payment) : 0;

                                                            $refund = isset($finc_inv_sum_amount->refund) ? $finc_inv_sum_amount->refund : 0;
                                                            $total = round( $led_amt_sales);
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
                                                                style="width:70px; text-align: right;" value="{{$vat}}">
                                                        </div>
                                                    </li>
                                                    <li
                                                        class="list-group-item d-flex align-items-center justify-content-end">
                                                        <span class="mr-2">Total Urgent Fee</span>
                                                        <div class="">
                                                            <input type="text" class="form-control number_only"
                                                                id="urgent_fee" name="urgent_fee" placeholder="00.00"
                                                                disabled="disabled"
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
                                                                style="width: 70px; text-align: right;" maxlength="10"
                                                                placeholder="00.00"
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
                                                        <span class="mr-2">Paid Amount</span>
                                                        <div class="">
                                                            <input type="text" id="initial_payment"
                                                                class="form-control number_only"
                                                                style="width: 70px; text-align: right;" maxlength="10"
                                                                placeholder="00.00"
                                                                value="{{ isset($payment) ? number_format((float) $payment, 2, '.', '') : '0' }}">
                                                        </div>
                                                    </li>

                                                    <li
                                                        class="list-group-item d-flex align-items-center justify-content-end">
                                                        <span class="mr-2">Due Amount</span>
                                                        <div class="">
                                                            <input type="text" id="due_payment"
                                                                class="form-control number_only"
                                                                style="width: 70px; text-align: right;" maxlength="10"
                                                                placeholder="00.00"
                                                                value="{{ $due >= 0 && $refund <= 0 ? number_format($due, 2, '.', '') : 0.0 }}">
                                                        </div>
                                                    </li>

                                                    <li
                                                        class="list-group-item d-flex align-items-center justify-content-end">
                                                        <span class="mr-2">Cash Refund</span>
                                                        <div class="">
                                                            <input type="text" id="cash_refund"
                                                                class="form-control number_only"
                                                                style="width: 70px; text-align: right;" maxlength="10"
                                                                placeholder="00.00"
                                                                value="{{ $refund > 0 ? number_format($refund, 2, '.', '') : 0.0 }}">
                                                        </div>
                                                    </li>

                                                    <li
                                                        class="list-group-item d-flex align-items-center justify-content-end">
                                                        <span class="mr-2">Total Paid Amount</span>
                                                        <div class="">
                                                            <input type="text" id="total_paid_amount"
                                                                class="form-control number_only"
                                                                style="width: 70px; text-align: right;" maxlength="10"
                                                                placeholder="00.00">
                                                        </div>
                                                    </li>

                                                    <li
                                                        class="list-group-item d-flex align-items-center justify-content-end">
                                                        <span class="mr-2">Total Discount</span>
                                                        <div class="">
                                                            <input type="text" id="total_discount"
                                                                class="form-control number_only"
                                                                style="width: 70px; text-align: right;" maxlength="10"
                                                                placeholder="00.00">
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
                                                    @if ($final_due >= 0 && $refund <= 0)
                                                    <li
                                                        class="list-group-item d-flex align-items-center justify-content-end">
                                                        <h5 class="mb-0 mr-2" id="final_due">Final Due</h5>
                                                        <input type="hidden" class="form-control mb-0"
                                                            id="total_due" name="total_due">
                                                        <span class="btn btn-outline-danger bg-none btn-md"
                                                            id="total_due_con">
                                                            {{ isset($final_due) ? number_format((float) abs($final_due), 2, '.', '') : '00.00' }}</span>
                                                    </li>
                                                @elseif($refund > 0)
                                                    <li
                                                        class="list-group-item d-flex align-items-center justify-content-end">
                                                        <h5 class="mb-0 mr-2" id="final_due">Refund</h5>
                                                        <input type="hidden" class="form-control mb-0"
                                                            id="total_due" name="total_due">
                                                        <span class="btn btn-outline-danger bg-none btn-md"
                                                            id="total_due_con">
                                                            {{ isset($refund) ? number_format((float) abs($refund), 2, '.', '') : '00.00' }}</span>
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
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="text/javascript">
    openDoctorAutocomplete('#doctor_code_dis', 'hdn_doctor_id_dis');
    $(document).on('keyup', '#discount_percent', function(e) {
        var keyCode = e.keyCode || e.which;

        if (keyCode != 9) {
            e.preventDefault();

            calCulateDiscountHospital(this.value);
        }
    });

    $(document).on('keyup', '#discount_percent_doctors', function(e) {
        var keyCode = e.keyCode || e.which;

        if (keyCode != 9) {
            e.preventDefault();

            calCulateDiscountDoctor(this.value);
        }
    });

    function resetDueBillForm() {
        $("#due_collection").find("input, textarea").not('.keep_me').val("");
        $("#due_collection").find("select").not('.keep_me').val("0");
        $("#net_payable").html("00.00");
        $("#total_due_con").html("00.00");
        $("#total_due_data").html("00.00");
        $("#item_total").html("00.00");
        $("#total_due_con").html("00.00");
        $(" #tfoot, #tbody, #patient_info, #doctor_info, .item_list ").html('');
    }

    function removeTableRowPayment(thisElement) {

        if (confirm("Are you sure?")) {
            var amount = $(thisElement).parents('tr').children('td').find('.total_amt').val();
            var total_payment_amt = $('#total_payment_amt').val() - amount;
            var pay_amounts = $('#pay_amount').val() - amount;
            $('#total_payment_amt').val(total_payment_amt);
            $('#pay_amount').val(pay_amounts.toFixed(2));
            var total_amount = $("#total_payable").val() * 1;
            var pay_amount = pay_amounts * 1;


            if (pay_amount == '') {
                pay_amount = 0;
            }
            var discount_amt = $("#discount_amt").val();
            var discount_amt_doc = $("#discount_amt").val();
            if (discount_amt == '' || discount_amt_doc == '') {
                discount_amt = 0;
                discount_amt_doc = 0;
            }
            var due_payment = $("#due_payment").val();
            var paid = $("#initial_payment").val();
            var total_paid = parseFloat(paid) + parseFloat(pay_amount);
            $("#total_paid_amount").val(total_paid.toFixed(2));
            var total_due = parseFloat(due_payment) - (parseFloat(discount_amt) + parseFloat(discount_amt) + parseFloat(
                pay_amount));

            $("#total_due_con").html(total_due.toFixed(2));

            $(thisElement).parents("tr").remove();
            calCulateDiscount(this);
            calCulatePayment(this);
        }
        if (total_due >= 0) {
            $("#final_due").html(" ");
            $("#final_due").html("Final Due");
        } else {
            $("#final_due").html(" ");
            $("#final_due").html("Refund");
        }

        if ($("#tbody tr").length < 1) {

            $("#tfoot").html("");
        }
        calCulateDiscount(this);
        calCulatePayment(this);
        return;

    }

    function addFuntion(element) {

        let activeLabel = $(".payMode.active").find("#option").val();
        console.log(activeLabel )
          let   multiCash=false;
        if (activeLabel == 'CS') {
            $('.CS').each(function(index, element) {
            // "this" refers to the current element
            if ($(this).val()=='CASH') {
                alert('Already given Amount On Cash.');
                multiCash=true;
            }
            console.log(index, $(this).val());  
        });
        }
        if (multiCash == true) {
            return false;
        }
        var tfoot =
            "<tr><td  class='text-left'  >Total:</td> <td > <input type='text' name='total_payment_amt' id='total_payment_amt' class='text-right' style='border: 0;width: 80px;' readonly='readonly'></td><td colspan='6'></td></tr>"

        $("#tfoot").html(tfoot);
        var amt = 0;
        if (activeLabel == 'CS') {
            var amount = $(element).parents('div').find("#cash_amount").val();
            var method_mode = 'CASH';
            var bank_name = "";
            var b_type = "";
            var trans_id = "";
            var card_no = "";
            var acc_holder_name = "";
        }

        if (activeLabel == 'Mbanking') {

            if ($('#mBanking_type').val() != "" && $('#bkash_txn_id').val() != "") {
                var amount = $("#mBank_amount").val();
                var method_mode = 'Mbanking';
                var bank_name = "";
                var b_type = $('#mBanking_type').val();
                var trans_id = $('#bkash_txn_id').val();
                var card_no = "";
                var acc_holder_name = "";
            } else {
                if ($('#mBanking_type').val() == "") {
                    alert('Enter Mbanking  Type');
                } else if ($('#bkash_txn_id').val() == "") {
                    alert('Enter Transection  ID');
                }
                if ($("#tbody tr").length < 1) {
                    $("#tfoot").html("");
                }
                return;

            }
        }

        if (activeLabel == 'CQ') {
            if ($('#bank_name').val() != "" && $('#check_no').val() != "" && $('#holder_name').val() != "") {
                var method_mode = 'CHEQUE';
                var amount = $("#check_amount").val();
                var bank_name = $('#bank_name').val();
                var b_type = "";
                var trans_id = "";
                var card_no = $('#check_no').val();
                var acc_holder_name = $('#holder_name').val();
            } else {
                if ($('#bank_name').val() == "") {
                    alert('Enter Bank  Name');
                } else if ($('#holder_name').val() == "") {
                    alert('Enter Holder  Name');
                } else if ($('#check_no').val() == "") {
                    alert('Enter Cheque  No');
                }


                if ($("#tbody tr").length < 1) {
                    $("#tfoot").html("");
                }
                return;
            }

        }

        if (activeLabel == 'CARD') {
            if ($('#bank_name_card').val() != "" && $('#card_no').val() != "" && $('#card_holder_name').val() != "" &&
                $('#card_type').val() != "") {
                var method_mode = 'CARD';
                var amount = $("#card_amount").val();
                var bank_name = $('#bank_name_card').val();
                var b_type = $('#card_type').val();
                var trans_id = "";
                var card_no = $('#card_no').val();
                var acc_holder_name = $('#card_holder_name').val();
            } else {
                if ($('#card_type').val() == "") {
                    alert('Enter Card  Type');
                } else if ($('#bank_name_card').val() == "") {
                    alert('Enter  Bank  Name');
                } else if ($('#card_holder_name').val() == "") {
                    alert('Enter Holder  Name');
                } else if ($('#card_no').val() == "") {
                    alert('Enter Card  No');
                }


                if ($("#tbody tr").length < 1) {
                    $("#tfoot").html("");
                }
                return;
            }

        }

        var table_row = "<tr><td ><input class='"+activeLabel+"' type='text' name='pay_method_mode[]' value='" + method_mode +
            "' style='border: 0; width: 80px; text-align: right' readonly='readonly'></td><td><input class='total_amt' type='text' name='total_amt[]' value='" +
            amount +
            "' style='border: 0; width: 80px; text-align: right' readonly='readonly'></td><td><input class='' type='text' name='mBank_types[]' value='" +
            b_type +
            "' style='border: 0; width: 80px; text-align: right' readonly='readonly'></td><td><input class='' type='text' name='pay_bank_name[]' value='" +
            bank_name +
            "' style='border: 0; width: 80px; text-align: right' readonly='readonly'></td><td><input class='' type='text' name='trans_id_no[]' value='" +
            trans_id +
            "' style='border: 0; width: 80px; text-align: right' readonly='readonly'></td><td><input class='' type='text' name='card_number[]' value='" +
            card_no +
            "' style='border: 0; width: 80px; text-align: right' readonly='readonly'></td><td><input class='' type='text' name='acc_holder_name[]' value='" +
            acc_holder_name +
            "' style='border: 0; width: 80px; text-align: right' readonly='readonly'></td> <td class='text-center' style='width:3%'><span class='btn btn-sm btn-danger remove'  data-id='' onclick='removeTableRowPayment(this)' data-url='' title='Cancel '><i class='fas fa-times'></i></span></td></tr>";
        var due_amt = $('#due_payment').html() != "" ? $('#due_payment').html() : 0;
        var net_payable = $('#paid_amount').val();
        var discounted_amount = $('#discounted_amount').val() != "" ? $('#discounted_amount').val() : 0;
        var total_discount = $('#total_discount').val() ? $('#total_discount').val() : 0;
        var initial_payment = $('#initial_payment').val() ? $('#initial_payment').val() : 0;
        var total_payment = $('#total_paid_amount').val() ? $('#total_paid_amount').val() : 0;
        // var current_pay=$('#total_payment_amt').val() ? $('#total_payment_amt').val() : 0;
        var dis_diff = total_discount == 0 ? 0 : Math.abs(parseFloat(total_discount) - parseFloat(discounted_amount));
        var paid_diff = total_payment == 0 ? 0 : Math.abs(parseFloat(total_payment) - parseFloat(initial_payment));

        var pay_paid_due = parseFloat(net_payable) - (parseFloat(initial_payment) + parseFloat(paid_diff) + parseFloat(
            discounted_amount) + parseFloat(dis_diff));


        if ($("#tbody tr").length >= 1 && parseFloat(amount) > 0 && parseFloat(amount) <= parseFloat(pay_paid_due)) {


            $("#tbody").append(table_row);
            $('#cash').children().find(':input').val("");
            $('#payment_method_bkash').children().find(':input').val("");
            $('#payment_method_card').children().find(':input').val("");
            $('#payment_method_cheque').children().find(':input').val("");
            $('#cash_bd_amount').val("");
        } else {
            console.log(amount, pay_paid_due.toFixed(2) + '_' + 'due_amt');
            if (parseFloat(amount) > 0 && parseFloat(amount) <= parseFloat(Math.round(pay_paid_due).toFixed(2))) {

                $("#tbody").html(table_row);
                $('#cash').children().find(':input').val("");
                $('#payment_method_bkash').children().find(':input').val("");
                $('#payment_method_card').children().find(':input').val("");
                $('#payment_method_cheque').children().find(':input').val("");
                $('#cash_bd_amount').val("");
            } else {

                $('#cash').children().find(':input').val("");
                $('#payment_method_bkash').children().find('#mBank_amount').val("");
                $('#payment_method_card').children().find('#card_amount').val("");
                $('#payment_method_cheque').children().find('#check_amount').val("");
                $('#cash_bd_amount').val("");
                alert(" Invalid Amount");
                if ($("#tbody tr").length < 1) {
                    $("#tfoot").html("");
                }

                return;

            }
        }
        $("input[class='total_amt']").each(function() {
            if ($(this).val() != '') {
                amt += parseFloat($(this).val());

                $('#total_payment_amt').val(amt);
                $('#pay_amount').val(amt.toFixed(2));
            }
        });

        // alert(amt);
        // 		var total_amount = $("#due_payment").val() * 1;
        // 		var pay_amount = amt * 1;
        // 		$("#total_due_data").html((total_amount - pay_amount).toFixed(2));
        // 		if (total_amount>= pay_amount) {
        // 			$("#cash_amount").val(pay_amount);
        // 		}else{
        // 			$("#change_amount").val(pay_amount-total_amount);
        // 			$("#cash_amount").val(total_amount);

        // 		}



        var pay_amount = $("#pay_amount").val()


        if (pay_amount == '') {
            pay_amount = 0;
        }
        var discount_amt = ($("#discount_amt").val() != "") ? $("#discount_amt").val() : 0;
        var discount_amt_doc = ($("#discount_amt_doctor").val() != "") ? $("#discount_amt_doctor").val() : 0;
        if (discount_amt == '') {
            discount_amt = 0;
        }
        var due_payment = $("#due_payment").val();
        var paid = $("#initial_payment").val();
        var total_paid = parseFloat(paid) + parseFloat(pay_amount);
        $("#total_paid_amount").val(total_paid.toFixed(2));
        var total_due = parseFloat(due_payment) - pay_amount - (parseFloat(discount_amt) + parseFloat(
        discount_amt_doc));


        $("#total_due_con").html(Math.abs(total_due.toFixed(2)));

        if (total_due >= 0) {
            $("#final_due").html("");
            $("#final_due").html("Final Due");
        } else {
            $("#final_due").html("");
            $("#final_due").html("Refund");
        }
    }




    $(document).on("click", "#option", function() {
        var paymentType = $(this).val();
        $('#cash').children().find(':input').val("");
        $('#payment_method_bkash').children().find(':input').val("");
        $('#payment_method_card').children().find(':input').val("");
        $('#payment_method_cheque').children().find(':input').val("");
        if (paymentType == "CARD") {
            $("#payment_method_card").removeClass("d-none");
            $("#payment_method_cheque").addClass("d-none");
            $("#payment_method_bkash").addClass("d-none");
            $("#cash").addClass("d-none");
        } else if (paymentType == "CQ") {
            $("#payment_method_card").addClass("d-none");
            $("#payment_method_bkash").addClass("d-none");
            $("#payment_method_cheque").removeClass("d-none");
            $("#cash").addClass("d-none");
        } else if (paymentType == "Mbanking") {
            $("#payment_method_bkash").removeClass("d-none");
            $("#payment_method_card").addClass("d-none");
            $("#payment_method_cheque").addClass("d-none");
            $("#cash").addClass("d-none");
        } else {
            $("#cash").removeClass("d-none");
            $("#payment_method_card").addClass("d-none");
            $("#payment_method_cheque").addClass("d-none");
            $("#payment_method_bkash").addClass("d-none");


        }
    });

    function cancel_box(element) {
        var invoice = $(element).attr("data-invoice-id");
        var item_qty = $(element).attr("data-item-qty");
        if ($(element).is(':checked')) {
            $("#cancel_checkbox_" + invoice).removeAttr("disabled");
            $("#cancel_checkbox_" + invoice).val(item_qty);

        } else {
            $("#cancel_checkbox_" + invoice).val("");
            $("#cancel_checkbox_" + invoice).attr("disabled", "");
        }
    }


    function calCulateDiscountHospital(value) {
        var discount_percent = $("#discount_percent").val();
        var discount_percent_doctor = $("#discount_percent_doctors").val();
        var discount_amt = $("#discount_amt").val();
        var due_payment_cal = $("#total_amt_dis").val();
        var due_payment = $("#due_payment").val() ? $("#due_payment").val() : 0;
        var cash_refund = ($("#cash_refund").val() != "") ? $("#cash_refund").val() : 0;
        var discounted_amount = $("#discounted_amount").val();
        var initial_payment = $("#initial_payment").val();
        var pay_amt = ($("#pay_amount").val() != "") ? $("#pay_amount").val() : 0;
        var discount_percent_doc = $("#discount_amt_doctor").val();
        var total_due_con = $("#total_due_con").val() ? $("#total_due_con").val() : 0;

        discount_percent = (discount_percent != "") ? ((parseFloat(due_payment_cal) * parseFloat(discount_percent)) /
            100).toFixed(2) : "";
            discount_percent = Math.round(discount_percent,2);
        $("#discount_amt").val(discount_percent);

        // discount_percent_doc= (discount_percent_doctor != "") ? ((parseFloat(due_payment_cal)*parseFloat(discount_percent_doctor))/100).toFixed(2) : "";
        // $("#discount_amt_doctor").val(discount_percent_doc);

        var total_dis = 0;
        var h_perc = discount_percent != "" ? parseFloat(discount_percent) : 0;
        var doc_perc = discount_percent_doc != "" ? parseFloat(discount_percent_doc) : 0;
        if (h_perc + doc_perc != 0) {
            total_dis = h_perc + doc_perc;
        }
        var total_discount = parseFloat(discounted_amount) + parseFloat(total_dis);
        console.log(discounted_amount,total_dis,total_discount,h_perc)
        if (discount_percent == "" && discount_percent_doctor == "") {
            $("#total_discount").val("");
        } else {

            $("#total_discount").val(parseFloat(total_discount).toFixed(2));
        }
        if (cash_refund > 0) {
            due_payment = (parseFloat(due_payment)) - (total_dis + parseFloat(pay_amt) + parseFloat(cash_refund));
        } else {
            due_payment = (parseFloat(due_payment) + parseFloat(cash_refund)) - (total_dis + parseFloat(pay_amt));
        }


        if (due_payment_cal < total_discount) {
            console.log('shuvo mara khao 2',total_discount,due_payment_cal)
            $("#discount_amt").val("");
            $("#discount_percent").val("");
            $("#total_discount").val("");
            $("#discount_percent_doctors").val("");
            $("#discount_percent_doctors").val("");
            $("#discount_percent_doctors").val("");
            alert("Discount invalid");
            $("#total_refund").val('');
            calCulateDiscountHospital(value);
        } else {

            $("#total_due_con").html(Math.abs(due_payment.toFixed(2)));
            if (due_payment >= 0) {
                $("#final_due").html("");
                $("#final_due").html("Final Due");
            } else {
                $("#final_due").html("");
                $("#final_due").html("Refund");
            }
        }
        event.stopImmediatePropagation();
    }


    function calCulateDiscountDoctor(value) {
        var discount_percent = $("#discount_amt").val();
        var discount_percent_doctor = $("#discount_percent_doctors").val();
        var discount_amt = $("#discount_amt").val();
        var due_payment_cal = $("#total_amt_dis").val();
        var due_payment = $("#due_payment").val() ? $("#due_payment").val() : 0;
        var cash_refund = ($("#cash_refund").val() != "") ? $("#cash_refund").val() : 0;
        var discounted_amount = $("#discounted_amount").val();
        var initial_payment = $("#initial_payment").val();
        var pay_amt = ($("#pay_amount").val() != "") ? $("#pay_amount").val() : 0;
        var discount_percent_doc = $("#discount_percent_doctors").val();

        // discount_percent= (discount_percent != "") ? ((parseFloat(due_payment_cal)*parseFloat(discount_percent))/100).toFixed(2) : "";
        // $("#discount_amt").val(discount_percent);

        discount_percent_doc = (discount_percent_doctor != "") ? ((parseFloat(due_payment_cal) * parseFloat(
            discount_percent_doctor)) / 100).toFixed(2) : "";
        $("#discount_amt_doctor").val(discount_percent_doc);
        var total_dis = 0;
        var h_perc = discount_percent != "" ? parseFloat(discount_percent) : 0;
        var doc_perc = discount_percent_doc != "" ? parseFloat(discount_percent_doc) : 0;
        if (h_perc + doc_perc != 0) {
            total_dis = h_perc + doc_perc;
        }
        var total_discount = parseFloat(discounted_amount) + parseFloat(total_dis);
        if (discount_percent == "" && discount_percent_doctor == "") {
            $("#total_discount").val("");
        } else {

            $("#total_discount").val(parseFloat(total_discount).toFixed(2));
        }
        if (cash_refund > 0) {
            due_payment = (parseFloat(due_payment)) - (total_dis + parseFloat(pay_amt) + parseFloat(cash_refund));
        } else {
            due_payment = (parseFloat(due_payment) + parseFloat(cash_refund)) - (total_dis + parseFloat(pay_amt));
        }
        if (due_payment_cal < total_discount) {
            console.log('shuvo mara khao 3',total_discount,due_payment_cal)
            $("#discount_amt").val("");
            $("#discount_percent").val("");
            $("#total_discount").val("");
            $("#discount_percent_doctors").val("");
            $("#discount_percent_doctors").val("");
            $("#discount_percent_doctors").val("");
            alert("Discount invalid");
            $("#total_refund").val('');
            calCulateDiscountDoctor(value);
        } else {
            console.log(due_payment);
            $("#total_due_con").html(Math.abs(due_payment.toFixed(2)));

            if (due_payment >= 0) {
                $("#final_due").html("");
                $("#final_due").html("Final Due");
            } else {
                $("#final_due").html("");
                $("#final_due").html("Refund");
            }
        }
        event.stopImmediatePropagation();
    }

    function calCulatePayment(value) {
      



        var discount_percent = $("#discount_amt").val();
        var discount_percent_doctor = $("#discount_amt_doctor").val();
        var discount_amt = $("#discount_amt").val();
        var due_payment_cal = $("#total_amt_dis").val();
        var due_payment = $("#due_payment").val();
        var cash_refund = ($("#cash_refund").val() != "") ? $("#cash_refund").val() : 0;
        var discounted_amount = $("#discounted_amount").val();
        var initial_payment = $("#initial_payment").val();
        var pay_amt = ($("#pay_amount").val() != "") ? $("#pay_amount").val() : 0;
        var item_total_amount = $("#net_payable").html();


        discount_percent = (discount_percent != "") ? discount_percent : 0;
        var dis_amt_hos = (discount_percent > 0) ? (discount_percent * 100 / parseFloat(item_total_amount)) : "";

        $("#discount_percent").val(dis_amt_hos ? dis_amt_hos.toFixed(2) : 0);

        var discount_percent_doc = (discount_percent_doctor != "") ? discount_percent_doctor : 0;
        var dis_amt_hos = (discount_percent_doc > 0) ? (discount_percent_doc * 100 / parseFloat(item_total_amount)) :
        "";
        $("#discount_percent_doctors").val(dis_amt_hos ? dis_amt_hos.toFixed(2) : 0);
        // alert(discount_percent_doc);
        // $("#discount_amt_doctor").val(discount_percent_doc.toFixed(2));
        var total_dis = 0;
        if (parseFloat(discount_percent) + parseFloat(discount_percent_doc) != 0) {
            total_dis = parseFloat(discount_percent) + parseFloat(discount_percent_doc);
        }


        var total_discount = parseFloat(discounted_amount) + parseFloat(total_dis);
        $("#total_discount").val(total_discount.toFixed(2));
        if (parseFloat(cash_refund) > 0) {
            due_payment = (parseFloat(due_payment)) - (total_dis + parseFloat(pay_amt) + parseFloat(cash_refund));
        } else {
            due_payment = (parseFloat(due_payment) + parseFloat(cash_refund)) - (total_dis + parseFloat(pay_amt));
        }


        if (due_payment_cal < total_discount) {
            console.log('shuvo mara khao',total_discount,due_payment_cal)
            $("#discount_amt").val("");
            $("#discount_percent").val("");
            $("#total_discount").val("");
            $("#discount_percent_doctors").val("");
            $("#discount_amt_doctor").val("");
            $("#discount_amt").val("");
            alert("Discount invalid");
            $("#total_refund").val('');
            calCulatePayment(value);


        } else {

            $("#total_due_con").html(Math.abs(due_payment.toFixed(2)));
            if (due_payment >= 0) {
                $("#final_due").html(" ");
                $("#final_due").html("Final Due");
            } else {
                $("#final_due").html(" ");
                $("#final_due").html("Refund");
            }

        }
        event.stopImmediatePropagation();

    }

    function calculateChangeAmt(thisElement) {
        var pay_amount = $("#cash_bd_amount").val() * 1;
        var total_amount = $("#cash_amount").val() * 1;


        if (total_amount >= pay_amount) {


            $("#change_amount").val("");
        } else {
            if (total_amount > 0) {
                $("#change_amount").val((pay_amount - total_amount));
            } else {
                $("#change_amount").val("");
            }

            // $("#cash_amount").val(total_amount.toFixed(2));

        }
    }

    function calCulateGivenAmount(value) {
        var pay_amount = $("#pay_amount").val();
        var change_amount = value - pay_amount;

        if (change_amount > 0) {
            $("#change_amount").val(change_amount.toFixed(2));
        }

    }


    $(document).on('change', '#cmb_discount_due', function() {
        var type = $(this).find(":selected").val();
        $("#discount_percent_doctors").val("");
        $("#total_discount_amount").val("");
        $("#discount_percent").val("");
        $("#discount_percent_doctors").val("");
        $("#discount_amt").val("");
        $("#discount_amt_doctor").val("");
        // $("#discount_amount_doctor").val("");
        if (type == "GENERAL") {
            $("#discount_percent_doctors").val("");
            $("#total_discount_amount").val("");
            $("#discount_percent").val("");
            $(".percent_hospital").removeClass('d-none');
            $(".percent_doctor").addClass('d-none');
        }
        if (type == "DOCTOR") {
            $("#discount_percent_hospital").val("");
            $("#total_discount_amount").val("");
            $("#discount_percent").val("");

            $(".percent_hospital").addClass('d-none');
            $(".percent_doctor").removeClass('d-none');
        }
        if (type == "BOTH") {
            $("#total_discount_amount").val("");
            $("#discount_percent").val("");
            $(".percent_hospital").removeClass('d-none');
            $(".percent_doctor").removeClass('d-none');
        }

        if (type == "0") {
            $(".percent_hospital").addClass('d-none');
            $(".percent_doctor").addClass('d-none');
        }

        // calCulatePayment(this);
    });
</script>
