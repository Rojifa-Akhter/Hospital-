<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm align-items-center">
        <div class="col-md-6">
            <h5 class="mt-2 mb-0">Payment</h5>
            <small>IPD / Payment</small>
        </div>
        <div class="col-md-6 text-right">

            <a href="{{ route('ipd.ipd-pharmacy-payment', $admission_id) }}" rel="tab"
                class="btn bg-navy text-white btn-md ipd_pharmacy" id="pharmacy_bill">Pharmacy Billing</a>
            <a href="{{ route('ipd.ipd-payment', $admission_id) }}" rel="tab"
                class="btn bg-navy text-white btn-md ipd_pharmacy" id="ipd_bill">
                Billing</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Patient Info</h5>
                </div>



                <div class="card-body p-2">
                    @if (!empty($patientInfo[0]))
                        @inject('history', 'App\Http\Controllers\IPDController')

                        @php
                            $history = $history->getAdmissionHistory($patientInfo[0]->admission_uid);
                        @endphp

                        <div class="d-flex flex-row bd-highlight">
                            <div class="p-2 bd-highlight">
                                <strong>IP No</strong>:
                                {{ isset($patientInfo[0]->admission_uid) ? $patientInfo[0]->admission_uid : '' }}
                            </div>
                            <div class="p-2 bd-highlight">
                                <strong>UHID</strong>:
                                {{ isset($patientInfo[0]->patient_code) ? $patientInfo[0]->patient_code : '' }}
                            </div>
                            <div class="p-2 bd-highlight">
                                <strong>Patient name</strong>:
                                {{ isset($patientInfo[0]->patient_name) ? $patientInfo[0]->patient_name : '' }}
                            </div>
                            <div class="p-2 bd-highlight">
                                <strong>Bed Category</strong>: @foreach ($history as $item)
                                    @if ($loop->first)
                                        {{ $item->ward_name }}
                                    @endif
                                @endforeach
                            </div>
                            <div class="p-2 bd-highlight">
                                <strong>Bed Name</strong>: @foreach ($history as $item)
                                    @if ($loop->first)
                                        {{ $item->bed_name }}
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Bill Details</h5>
                </div>
                <div class="card-body p-2">
                    <div class="table_scrollbar" style="width: 100%;height: 200px;overflow: scroll;">
                        <form action="{{ route('ipd.item-cancel') }}" method="post" id="cancel_item">
                            @csrf
                            <table class="table table-bordered mb-0">
                                <thead>
                                    <tr class="bg-primary">
                                        <th class="text-center">SL#</th>
                                        <th class="text-center">Invoice No</th>
                                        <th class="text-center">Date & Time</th>
                                        <th class="text-left">Item Name</th>
                                        <th class="text-left">Item Type</th>
                                        <th class="text-right">Rate</th>
                                        <th class="text-center">Qty</th>
                                        <th class="text-center">Cx. Qty</th>
                                        <th class="text-right">Total</th>
                                        <th class="text-center"></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @php
                                        $total = 0;
                                        $item_price = 0;
                                        $response_action = !empty($patientInfo)
                                            ? route('ipd.ipd-payment', $patientInfo[0]->admission_no_pk)
                                            : '';
                                    @endphp

                                    @if (!empty($item_details))
                                        @foreach ($item_details as $key => $item)
                                            @php
                                                //Delivery status == 2 means its type urgent
                                                if ($item->delivery_status_lookup_no_fk == 2) {
                                                    $item_price = $item->item_rate + $item->urgent_fee;
                                                } else {
                                                    $item_price = $item->item_rate;
                                                }
                                                $item_qty = $item->item_qty - $item->cancel_qty;
                                                $bg_color = $item_qty <= 0 ? 'bg-danger' : '';
                                            @endphp

                                            <tr class="<?= $bg_color ?>">

                                                <input type="hidden"
                                                    name="invoice_no_{{ $item->item_no_fk }}_{{ $item->invoice_no_fk }}"
                                                    value="{{ $item->invoice_no_fk }}">
                                                <input type="hidden"
                                                    name="admissin_id_{{ $item->item_no_fk }}_{{ $item->invoice_no_fk }}"
                                                    value="{{ $item->admission_no_pk }}">
                                                <input type="hidden"
                                                    name="item_no_{{ $item->item_no_fk }}_{{ $item->invoice_no_fk }}"
                                                    value="{{ $item->item_no_fk }}">
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-left">{{ $item->invoice_no_fk }}</td>
                                                <td class="text-center">
                                                    {{ date('d-m-Y h:i:s', strtotime($item->invoice_date)) }}
                                                </td>
                                                <td class="text-left">{{ $item->item_name }}</td>
                                                <td class="text-left">{{ $item->item_type_name }}
                                                    {{ $item->invoicedtl_no_pk }}
                                                </td>
                                                <td class="text-right">{{ $item_price }}</td>
                                                <td class="text-center"> <input type="hidden" class="item_qty"
                                                        value="{{ $item_qty }}">{{ $item_qty }}</td>
                                                <td class="text-right"><input type="text"
                                                        class="number_only form-control cancel_qty"
                                                        name="cancel_qty_{{ $item->item_no_fk }}_{{ $item->invoice_no_fk }}"
                                                        value="{{ $item_qty }}"></td>
                                                <td class="text-right">{{ $item_price * $item_qty }}</td>
                                                <td class="text-center">
                                                    @if ($item_qty > 0)
                                                        <input type="checkbox" class="cancel_checkbox"
                                                            name="cancel_checkbox[]"
                                                            value="{{ $item->item_no_fk }}_{{ $item->invoice_no_fk }}">
                                                    @endif
                                                </td>

                                                @php
                                                    $total += $item_price * $item_qty;
                                                @endphp

                                            </tr>
                                        @endforeach
                                    @endif

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th class="text-right" colspan="7">Total : </th>
                                        <input type="hidden" id="getTotalCost" value="{{ $total }}">
                                        <th class="text-right">{{ $total }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                            @if (Session::get('user.ses_hospital_code') == 'UNICO')
                                <div class="text-right">

                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Cancel</button>
                                </div>
                            @endif
                        </form>
                    </div>
                    <br>
                    <input type="hidden" value="{{ $total }}" id="total_invoice_bill">
                    <h2>Total: {{ number_format($total, 2, '.', '') }} Tk </h2>
                </div>
            </div>
        </div>


        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Payment History</h5>
                </div>
                <div class="card-body p-2">
                    <div class="payment_scroll_bar" style="width: 100%;height: 200px;overflow: scroll;">
                        <table class="table table-bordered mb-0">
                            <thead>
                                <tr class="bg-primary">
                                    <th class="text-center">SL#</th>
                                    <th class="text-center">Date & Time</th>
                                    <th class="text-left">Pay Type</th>
                                    <th class="text-left">Cashier</th>
                                    <th class="text-right">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totalPayAmount = 0;

                                @endphp
                                @if (!empty($paymentHistories))
                                    @foreach ($paymentHistories as $key => $payhistory)
                                        <tr>
                                            <td class="text-center">{{ ++$key }}</td>
                                            <td class="text-center">
                                                {{ date('d-m-Y h:i:s', strtotime($payhistory->invoice_date)) }}
                                            </td>
                                            <td char="text-center">
                                                {{ ucfirst($payhistory->pay_type) != '' ? ucfirst($payhistory->pay_type) : 'Invoice' }}
                                            </td>
                                            <td class="text-left">{{ $payhistory->ledger_entry_txt }}</td>
                                            <td class="text-right">{{ abs($payhistory->ledger_amt_payment) }}</td>
                                        </tr>

                                        @php

                                            $totalPayAmount += $payhistory->ledger_amt_payment;

                                        @endphp
                                    @endforeach
                                @endif
                            </tbody>
                            <tfoot>

                                <tr>
                                    <th class="text-right" colspan="4">Payment : </th>
                                    <th class="text-right">{{ $totalPayAmount }} </th>
                                </tr>
                                <tr>
                                    <th class="text-right" colspan="4">Discount : </th>
                                    <th class="text-right">{{ $totalDiscount }}</th>
                                </tr>

                                <tr>
                                    <th class="text-right" colspan="4">Total : </th>
                                    <th class="text-right">{{ $totalPayAmount + $totalDiscount }}</th>
                                </tr>


                            </tfoot>
                        </table>

                    </div>
                    <br>
                    <h2>Total Payment : {{ number_format($totalPayAmount + $totalDiscount, 2, '.', '') }} Tk </h2>
                </div>
            </div>

        </div>

    </div>

    <form action="{{ route('ipd.patient.payment') }}" method="post" id="ipdpaymentform">
        @csrf
        <div class="form-row">

            <div class="col-md-7">
                <div class="card">
                    <div class="card-header">
                        {{-- <span> Payment</span> --}}
                        <input type="checkbox" name="emergency" id="emergency" class="emeday" value="1"
                            onclick="handleCheckbox(this)"> <label for="emergency">Emergency</label>
                        &nbsp; <input type="checkbox" name="daycare" id="daycare" class="emeday" value="1"
                            onclick="handleCheckbox(this)"> <label for="daycare">Day Care</label>
                        &nbsp; <input type="checkbox" name="ot" id="ot" class="emeday" value="1"
                            onclick="handleCheckbox(this)"> <label for="ot">OT</label>
                    </div>



                    <div class="col-md-12 mt-2">


                        @csrf
                        <div class="clearfix">

                            <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                                <div class="btn-group bg-none w-100" data-toggle="buttons" aria-label="First group">


                                    @if (!empty($paymodes))

                                        @foreach ($paymodes as $key => $paymode)
                                            <label class="btn btn-outline-primary bg-none ">
                                                <input type="radio" name="pay_mode" id="option" class="keep_me"
                                                    value="{{ $key }}" {{ $key == 'CS' ? 'checked' : ' ' }}>
                                                {{ $paymode }}
                                            </label>
                                        @endforeach
                                    @endif
                                </div>

                                <div class="col-md-12">

                                </div>



                            </div>
                        </div>
                        <div class="form-row border-top mt-1">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-2 mt-2">
                                            <select class="form-control" id="ipd_pay_type" name="pay_type">
                                                <option value="">Payment Type</option>
                                                @foreach ($pay_types as $key => $pay_type)
                                                    <option value="{{ $pay_type }}">{{ ucwords($pay_type) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <p class="text-danger" id="invalid_payment_type" style="display: none;">
                                                Select
                                                Payment Type</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-2 mt-2">
                                            <select class="form-control" id="sub_type" name="sub_type">
                                                <option value="">Sub Type</option>
                                                @if (!empty($ipd_sub_type))
                                                    @foreach ($ipd_sub_type as $key => $pay_type)
                                                        <option value="{{ $pay_type }}"
                                                            @if ($type == $pay_type) selected @endif>
                                                            {{ $pay_type }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <p class="text-danger" id="invalid_payment_type" style="display: none;">
                                                Select
                                                Payment Type</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="" id="cash">

                                    <div class="mb-2 mt-2">
                                        <input type="text" class="form-control cash_amount number_only "
                                            name="cash_amount" id="cash_amount" value=""
                                            placeholder="Paid Amount" onkeyup="calculatePayment(this)">
                                        <p class="text-danger" id="invalid_cash_amount" style="display: none;">Enter
                                            Paid Amount</p>
                                    </div>
                                    <div class="mb-2 mt-2">
                                        <input type="text" class="form-control number_only" id='cash_bd_amount'
                                            value="" placeholder="Given Amount"
                                            onkeyup="calculatePayment(this)">
                                        <p class="text-danger" id="invalid_amount" style="display: none;">Enter
                                            Amount
                                        </p>
                                    </div>
                                    <div class="mb-2 mt-2">
                                        <input type="text" id="change_amount" class="form-control number_only"
                                            placeholder="Change Amount">
                                        <p class="text-danger" id="invalid_change_amount" style="display: none;">
                                            Enter
                                            Change Amount</p>
                                    </div>


                                    <!-- <span class="btn btn-md btn-success float-right mt-2" name="cash_amount"
                                    id="cash_add" onclick="addFuntion(this)">Add</span> -->

                                    <button type="button" onkedown="addFuntion(this)" onclick="addFuntion(this)"
                                        name="cash_amount" id="cash_add" class="bg-success float-right ">Add
                                    </button>

                                </div>

                                <div id="payment_method_cheque" class="d-none">
                                    <div class="cheque_field mb-2 mt-2">
                                        <input type="text" class="form-control check_amount number_only"
                                            name="check_amount" id="check_amount" checked="checked" value=""
                                            placeholder="Amount">
                                    </div>
                                    <div class="cheque_field mb-2 mt-2">
                                        <select class="form-control select2 payment_method_1" id="bank_name"
                                            name="bank_name">
                                            <option value="">Bank name</option>
                                            @if ($bank_name)
                                                @foreach ($bank_name as $value)
                                                    <option value="{{ $value }}">{{ $value }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <!-- <input type="text" class="form-control payment_method_1 " name="bank_name" id="bank_name" checked="checked" value="" placeholder="Bank Name"> -->
                                    </div>
                                    <div class="cheque_field mb-2 mt-2">
                                        <input type="text"
                                            class="form-control payment_method_1
                                        "
                                            name="holder_name" id="holder_name" checked="checked" value=""
                                            placeholder="Holder Name">
                                    </div>
                                    <div class="cheque_field mb-2 mt-2">
                                        <input type="text" class="form-control payment_method_1" name="check_no"
                                            id="check_no" checked="checked" value="" maxlength="16"
                                            placeholder="Cheque No">
                                    </div>

                                    <button type="button" class=" bg-success float-right " name="check_amount"
                                        id="check_add" onclick="addFuntion(this)"
                                        onkedown="addFuntion(this)">Add</button>

                                </div>
                                <div class="d-none" id="payment_method_card">
                                    <select class="form-control" id="card_type" name="card_type">
                                        <option value="">Card Type</option>
                                        <option value="City Maxx">City Maxx</option>
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
                                                    <option value="{{ $value }}">{{ $value }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <!-- <input type="text" class="form-control payment_method_1 " name="bank_name_card" id="bank_name_card" checked="checked" value="" placeholder="Bank Name"> -->
                                    </div>
                                    <div class="cheque_field mb-2 mt-2">
                                        <input type="text"
                                            class="form-control payment_method_1
                                        "
                                            name="holder_name" id="card_holder_name" checked="checked"
                                            value="" placeholder="Holder Name">
                                    </div>

                                    <div class="card-field mb-2 mt-2">
                                        <input type="text" class="form-control payment_method_2 " name="card_no"
                                            id="card_no" value="" placeholder="Card No (minimum 4 digits)" minlength="4" maxlength="20">
                                    </div>
                                    <button type="button" class=" bg-success float-right" name="card_amount"
                                        id="card_add" onclick="addFuntion(this)">Add</button>
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
                                            name="mBank_amount" id="mBank_amount" checked="checked" value=""
                                            placeholder="Amount">
                                    </div>
                                    <div class="cheque_field mb-2 mt-2">
                                        <input type="text" class="form-control payment_method_1 "
                                            name="bkash_txn_id" id="bkash_txn_id" checked="checked" value=""
                                            placeholder="Transection ID">
                                    </div>
                                    <button type="button" class=" bg-success float-right" name="bkash_amount"
                                        id="bkash_add" onclick="addFuntion(this)">Add</button>
                                </div>
                                <div class="d-none" id="payment_method_deposited">
                                        <div class="form-row">
                                                <div class="col-md-3">
                                                   <div class="mb-2 mt-2">
                                                     <select class="form-control" id="deposit_type" name="deposit_type" onchange="getDipositAmt(this)">
                                                     <option value="">select</option>
                                                     @if(!empty($deposit_type))
                                                        @foreach($deposit_type as $kye => $value)
                                                        <option value="{{$kye}}">{{$value}}</option>
                                                        @endforeach
                                                       @endif 
                                                     </select>
                                                   </div>
                                                </div>
                                                <div class="col-md-3">
                                                   <div class="mb-2 mt-2">
                                                       <input type="text" class="form-control cash_amount number_only " name="deposited_amt" id="deposited_amt" value="" readonly>
                                                   </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="mb-2 mt-2">
                                                        <input type="text" class="form-control number_only" id='payment_deposited_amt' placeholder="0.00" >
                                                    </div>
                                                </div>

                                                <div class="col-md-1">
                                                    <div class=" float-right mt-1 text-white">
                                                        <button type="button" onkedown="addFuntion(this)" onclick="addFuntion(this)" name="" id="deposited_add" class="global_add_btn"><i class="fas fa-plus"></i> Add </button>
                                                    </div>
                                                </div>

                                        </div>
                                        </div>
                                <!-- <label for="validationTooltip01">Remarks</label>
                                 <textarea id="remarks" name="remarks" rows="2" class="form-control"></textarea> -->
                            </div>
                        </div>



                        <div class="payment_table" style="height: 263px;overflow: scroll;">
                            <div class=" clearfix table-responsive mt-2">
                                <table class="table table-hover fixed_header table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Type</th>
                                            <th>Sub Type</th>
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

                                        <!-- <tr>
            <td><input type="text" name="" id="mode" value=""></td>
            <td><input type="text" name="" id="all_amount" value=""></td>
            <td><input type="text" name="" id="type_card_mbank" value=""></td>
            <td><input type="text" name="" id="bank" value=""></td>
            <td><input type="text" name="" id="cand_trans_id" value=""></td>
        </tr> -->
                                    </tbody>
                                    <tfoot id="tfoot">


                                    </tfoot>
                                </table>
                            </div>

                        </div>


                        <div class="py-2">
                            <textarea rows="3" class="form-control " placeholder="Remarks ..." name="remarks" id="remarks"></textarea>
                        </div>
                        <!-- <div class="col-md-12" style="display: flex; justify-content: flex-end;padding: 0; margin-bottom: 14px;">

       <button class="btn btn-md btn-success" onclick="addipdPayment()">Save</button>

   </div> -->
                    </div>

                </div>
            </div>

            <div class="col-md-5">
                <input type="hidden" id="hospital_code" value="{{ Session::get('user.ses_hospital_code') }}">
                <div class="card mt-2">
                    <div class="col-md-12 d-none" id='discount_block'>
                        <div class="card-header">
                            <h5><i class="fas"></i> Discount</h5>
                        </div>

                        <div class="form-row">
                            <div class="col-md-12 ">
                                <div class="form-group">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend mt-2">
                                            <label class="input-group-text"
                                                for="cmb_discount">Discount&nbsp;&nbsp;</label>
                                        </div>
                                        <select class="custom-select keep_me mt-2" id="cmb_discount"
                                            name="cmb_discount" readonly>
                                            <option value="0">Discount Type</option>
                                            <option value="DOCTOR">Doctor</option>
                                            <option value="GENERAL" selected="">General</option>
                                            <option value="BOTH">Both</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 percent_hospital">
                                <div class="input-group  mb-2">
                                    <div class="input-group-prepend-ipd">
                                        <span class="input-group-text" id="basic-addon1">%</span>
                                    </div>
                                    <input type="text" class="form-control text-right number_only hospital_disc"
                                        id="discount_percent_hospital" name="discount_percent_hospital"
                                        placeholder="Hospital" onkeyup="" value="" readonly>
                                </div>
                            </div>
                            <div class="col-md-6 percent_hospital">
                                <input type="text" class="form-control text-right number_only hospital_disc"
                                    id="discount_amount_by_hospital" name="discount_amount_hospital"
                                    placeholder="Amount" onkeyup="calculateTotalinAmount(this)" value=""
                                    readonly>
                            </div>
                            <div class="form-group col-md-6 percent_doctor d-none">
                                <div class="input-group">
                                    <div class="input-group-prepend-ipd">
                                        <span class="input-group-text" id="basic-addon1">%</span>
                                    </div>
                                    <input type="text" class="form-control text-right number_only doctor_disc"
                                        id="discount_percent_doctor" name="discount_percent_doctor"
                                        placeholder="Doctor" onkeyup="" value="" readonly>
                                </div>
                            </div>
                            <div class="form-group col-md-6 percent_doctor d-none">
                                <input type="text" class="form-control text-right number_only doctor_disc"
                                    id="discount_amount_by_doctor" name="discount_amount_doctor" placeholder="Amount"
                                    onkeyup="calculateTotalinAmount(this)" value="" readonly>
                            </div>
                        </div>
                        <li class="list-group-item d-flex align-items-center justify-content-between">
                            <h6 class="float-left mr-2 mb-0">Discounted&nbsp;By&nbsp;&nbsp;:</h6>

                            <div class="col-md-8">
                                <input type="hidden" id="doctor_id" name="doctor_id" />
                                <input type="text" class="form-control form-control-sm m-0" id="primary_doctor"
                                    name="primary_doctor" maxlength="50" value=""
                                    placeholder="Search here..." />
                            </div>

                        </li>
                        <li class="list-group-item d-flex align-items-center justify-content-between">
                            <h6 class="float-left mr-2 mb-0">Request&nbsp;By&nbsp;&nbsp;:</h6>

                            <div class="col-md-8">

                                <input type="text" class="form-control form-control-sm m-0" id="dis_requ_by"
                                    name="dis_requ_by" value="" placeholder="Discount Request By" />
                            </div>
                        </li>
                    </div>
                    <div class="d-none p-2" id="return_discount">
                        <label class="float-left mr-2"><strong> Total Return Discount</strong></label>
                        <input type="text" id='discount_return_amt' class="" name="discount_return_amt"
                            value="">
                    </div>
                    <div class="col-md-12" id="set_discount">
                        <span class="btn btn-md btn-warning open-modal" id="batch_popup" data-id="ipd_discount"
                            data-modal="common-modal-xl"
                            data-action="{{ route('ipd.ipd-payment-discount', $admission_id) }}" data-title="Batch">
                            Set Discount</span>
                        <span id="set_service_type_dis"></span>
                        <span id="set_discount_return"></span>
                    </div>
                    <div class="col-md-12">
                        <ul class="list-group bg-light-blue list-group-flush bg-light-blue rounded mb-2 border">
                            <li class="list-group-item">
                                <h5 class="float-left mr-2">Total Bill Amount</h5>
                                <span
                                    class="float-right btn btn-outline-danger bg-none btn-md">{{ number_format(abs($total), 2, '.', '') }}</span>
                            </li>
                            <li class="list-group-item">
                                <h5 class="float-left mr-2">Total Discount Amount</h5>
                                <span class="float-right btn btn-outline-danger bg-none btn-md"
                                    id="total_dis_amt">{{ $totalDiscount > 0 ? number_format($totalDiscount, 2, '.', '') : 0.0 }}</span>
                            </li>
                            <li class="list-group-item">
                                <h5 class="float-left mr-2">Total Paid Amount</h5>
                                <span class="float-right btn btn-outline-danger bg-none btn-md"
                                    id="total_paid_amount">{{ number_format(abs($totalPayAmount), 2, '.', '') }}</span>
                            </li>


                            <li class="list-group-item">
                                <h5 class="float-left mr-2">
                                    @if (number_format($total - ($totalPayAmount + $totalDiscount)) >= 0)
                                        Due Amount
                                    @else
                                        Refund
                                    @endif
                                </h5>
                                @php
                                    $due_amt = abs($total - ($totalPayAmount + $totalDiscount));
                                @endphp

                                <span
                                    class="float-right btn btn-outline-danger bg-none btn-md">{{ number_format($due_amt, 2, '.', '') }}</span>
                                <input type="hidden" name="" id="due_refund_amt"
                                    value="{{ number_format($total - ($totalPayAmount + $totalDiscount), 2, '.', '') }}">
                            </li>

                            <li class="list-group-item">
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <span class="mr-2 float-left d-none">Service Charge</span>
                                        <div class="float-left d-none">
                                            <input type="text" class="form-control mb-0" id="s_charge"
                                                name="s_charge" value="" placeholder="0.00"
                                                readonly="readonly" onkeyup="billingEngine.calculateTotal(this)"
                                                style="width: 70px; text-align: right;">
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <span class="mr-2 float-left d-none">VAT/Tax</span>
                                        <div class="float-left">
                                            <input type="text" class="form-control mb-0 d-none" id="item_vat"
                                                name="item_vat" value="" placeholder="0.00"
                                                style="width: 70px; text-align: right;">
                                        </div>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <span class="mr-2">Discount</span>
                                        <div class="float-right">
                                            <input type="text" class="form-control float-right number_only"
                                                id="total_discount_amount" name="total_discount_amount"
                                                value="" readonly="readonly" placeholder="0.00"
                                                style="width:70px; text-align: right;" maxlength="8">
                                            <input type="text" class="form-control float-right number_only"
                                                id="discount_percent" name="discount_percent" placeholder="%"
                                                readonly="readonly" style="width:50px; text-align: right;"
                                                value="0">
                                        </div>
                                    </div>
                                </div>
                            </li>

                            @if (number_format($total - ($totalPayAmount + $totalDiscount)) > 0)
                                <li class="list-group-item">
                                    <div class="float-right">
                                        <input type="text" id="total_payable" name="total_payable"
                                            class="form-control number_only" style="width: 70px; text-align: right;"
                                            placeholder="" value="{{ number_format($due_amt, 2, '.', '') }}">
                                    </div>
                                    <span class="float-right mr-2">Payable Amount</span>
                                </li>
                            @else
                                <li class="list-group-item">
                                    <div class="float-right">
                                        <input type="text" id="total_payable" name="total_payable"
                                            class="form-control number_only" style="width: 70px; text-align: right;"
                                            placeholder="" value="0">
                                    </div>
                                    <span class="float-right mr-2">Payable Amount</span>
                                </li>
                            @endif
                            <li class="list-group-item">
                                <div class="float-right">
                                    <input type="text" id="pay_amount" name="total_payment"
                                        class="form-control number_only" style="width: 70px; text-align: right;"
                                        placeholder="" readonly="readonly" maxlength="12" value="">
                                </div>
                                <span class="float-right mr-2">Payment Amount</span>
                            </li>
                            @php
                                $due = 0;
                                $due = number_format($due_amt, 2, '.', '');
                            @endphp

                            <li class="list-group-item">
                                <input type="hidden" class="form-control mb-0" id="total_due" name="total_due"
                                    value="{{ number_format($total - ($totalPayAmount + $totalDiscount), 2, '.', '') }}">

                                <span class="float-right btn btn-outline-danger bg-none btn-md" id="total_due_data">
                                    {{ number_format($due_amt, 2, '.', '') }}
                                </span>
                                <h5 class="float-right mr-2" id="due_refund">
                                    @if (number_format($total - ($totalPayAmount + $totalDiscount) >= 0))
                                        Due
                                    @else
                                        Refund
                                    @endif
                                </h5>
                            </li>
                        </ul>
                    </div>
                    <input type="hidden" name="admission_id" value="{{ $admission_id }}">
                    <input type="hidden" name="patientid" value="{{ $patientId }}">
                    @php
                        $bill_id = '';
                        $response_url = route('bill-invoice-ipd', $bill_id);
                        if (Route::currentRouteName() == 'ipd.ipd-pharmacy-payment') {
                            $redirect_url = route('ipd.ipd-pharmacy-payment', $admission_id);
                        } else {
                            $redirect_url = route('ipd.ipd-payment', $admission_id);
                        }

                    @endphp
                    <div class="row justify-content-around px-2">
                        <div class="col-md-6 ">
                            {{-- <button id="invoice_adjustment" onclick="invoiceAdjustment()" data-redirect-action="{{ $redirect_url }}" type="button" class="btn btn-md btn-primary">Invoice Adjustment</button> --}}
                        </div>

                        <div class="col-md-6 text-right">

                            <!-- <button type="button" class="btn btn-md btn-success btn-save-update" onclick="btnSaveUpdate(this,'afterSaveModal','$action','common-modal-md',' Bill Payment')">Save</button> -->

                            <button class="btn btn-md btn-success " data-response_action="{{ $response_url }}"
                                data-redirect-action="{{ $redirect_url }}"
                                onclick="billingEngine.createIpdPayment(this)">Save</button>

                        </div>
                    </div>


                </div>
            </div>
        </div>
    </form>


</div>
</div>

<form action="{{ route('ipd.invoice-adjustment') }}" method="post" id="ipdInvoiceAdjustment">
    <input type="hidden" name="admission_id" value="{{ $admission_id }}">
</form>


<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>

<script type="text/javascript">
    function handleCheckbox(currentCheckbox) {
        var checkboxes = document.getElementsByClassName("emeday");
        for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i] !== currentCheckbox) {
                checkboxes[i].checked = false;
            }
        }
    }
    $(function() {
        if ($('#hospital_code').val() != "IMPERIAL" && $('#hospital_code').val() != "EWMCH") {
            $('#discount_block').removeClass('d-none');
            $('#cmb_discount').removeAttr('readonly', 'readonly');
            $('.hospital_disc').removeAttr('readonly', 'readonly');
            $('.doctor_disc').removeAttr('readonly', 'readonly');
            $('#set_discount').addClass('d-none');
        }

    })

    $(document).on('change', '.cancel_checkbox', function() {
        // $('.cancel_checkbox').prop('checked', false);
        // $(this).prop('checked', true);
        var qty = parseFloat($(this).parent('td').parent('tr').find('.item_qty').val());
        var cancel_qty = parseFloat($(this).parent('td').parent('tr').find('.cancel_qty').val());
        console.log(qty, cancel_qty)
        if (qty <= 0 || qty < cancel_qty || cancel_qty <= 0) {
            alert('Invalid Cancel Qty');
            $(this).parent('td').parent('tr').find('.cancel_checkbox').prop('checked', false);
            $(this).parent('td').parent('tr').find('.cancel_qty').val(0);
        }

    })

    $(document).on('keyup', '.cancel_qty', function() {
        $(this).parent('td').parent('tr').find('.cancel_checkbox').prop('checked', false);
    })

    function invoiceAdjustment() {
        var redirect_url = $('#invoice_adjustment').attr('data-redirect-action');
        console.log(redirect_url); //


        if (confirm("Are You Sure?")) {
            $.ajax({
                async: true,
                data: $('#ipdInvoiceAdjustment').serialize(),
                url: "{{ route('ipd.invoice-adjustment') }}",
                type: "post",
                cache: false,
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {

                    if (data.title == 'Success') {
                        $('.common-modal-notify').modal('show');
                        $('.common-modal-notify .modal-body').html(
                            "<i class='fas fa-stroopwafel fa-spin'></i>");
                        $('.common-modal-notify .modal-title').html(data.title);
                        $('.common-modal-notify .modal-body').html(data.msg);
                    } else {
                        $('.common-modal-notify-error').modal('show');
                        $('.common-modal-notify-error .modal-title').html(data.title);
                        $('.common-modal-notify-error .modal-body').html(data.msg);
                    }




                },
                complete: function() {

                },
                error: function(data) {
                    var errors = jQuery.parseJSON(data.responseText);
                    error_messages = "";
                    for (messages in errors) {
                        console.log(typeof(errors[messages]));
                        if (typeof(errors[messages]) == 'object') {
                            // test_data = JSON.parse(errors[messages]);
                            // console.log(test_data);
                            // test_data.forEach(function (item, index) {
                            //     console.log(item, index)
                            // })
                        } else {
                            var field_name = $("#" + messages).siblings("label").html();
                            error_messages += "<div class='alert alert-danger' role='alert'>" + errors[
                                messages] + "</div>";
                        }

                    }

                    $('.common-modal-notify-error').modal('show');
                    $('.common-modal-notify-error .modal-title').html("Validation Error");
                    $('.common-modal-notify-error .modal-body').html(error_messages);

                    $.unblockUI();
                }
            }).done(function() {
                $.unblockUI();
            });
        }

    }



    $(document).on('keyup', '#discount_percent_hospital', function(e) {
        var keyCode = e.keyCode || e.which;

        if (keyCode != 9) {
            e.preventDefault();

            calculateTotalinDiscount(this);
        }
    });

    $(document).on('keyup', '#discount_percent_doctor', function(e) {
        var keyCode = e.keyCode || e.which;

        if (keyCode != 9) {
            e.preventDefault();

            calculateTotalinDiscountDoc(this);
        }
    });


    function calculatePayment(thisElement) {
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
        }
    }
    // let totalCost = parseFloat($("#getTotalCost").val());

    // $("#cash_amount").val(totalCost);

    /**/
    // $("cash_bd_amount").keyup(function(){
    // 	console.log($("#cash_bd_amount").val());
    // });


    function removeTableRowPayment(thisElement) {


        if (confirm("Are you sure?")) {
            $(thisElement).parents("tr").remove();
            var pay_type_name = $(thisElement).parents('tr').children('td').find('.pay_type')
                .val(); //   find(".pay_type").val();

            var amount = $(thisElement).parents('tr').children('td').find('.total_amt').val();
            var totalDue = $('#total_due').val();
            amount = parseFloat(amount);
            totalDue = parseFloat(totalDue);


            var total_payment_amt = 0;
            var pay_amounts = 0; //$('#pay_amount').val() - amount

            var total_due_data = parseFloat($('#total_due_data').html());
            var total_payable = $("#total_payable").val() ? parseFloat($("#total_payable").val()) : 0;
            var total_payment = $("#pay_amount").val() ? parseFloat($("#pay_amount").val()) : 0;
            var total_discount = $("#total_discount_amount").val() ? parseFloat($("#total_discount_amount").val()) : 0;


            if (pay_type_name == "REFUND") {

                due_refund = totalDue - parseFloat(amount);

                total_payment_amt = parseFloat($('#total_payment_amt').val()) + amount;
                pay_amounts = parseFloat($('#pay_amount').val() ?? 0) - amount;
                $('#total_due_data').html(Math.abs(due_refund));
                // $('#total_due_data').html(Math.abs(total_payable - (total_payment - amount) - total_discount));
                $('#total_due').val(due_refund);
                $('#pay_amount').val(pay_amounts);
                $('#due_refund').html("Refund");
                console.log(due_refund);

            } else {
                // due_refund =   (parseFloat($('#due_refund_amt').val() - parseFloat(total_discount))) - amount ;
                due_refund_amt = amount + totalDue;
                console.log(totalDue + 'bbbbbbb');
                total_payment_amt = parseFloat($('#total_payment_amt').val()) - amount;
                pay_amounts = parseFloat($('#pay_amount').val() ?? 0) - amount;
                $('#total_due_data').html(Math.abs(due_refund_amt));
                // $('#total_due_data').html(Math.abs(total_payable - (total_payment - amount) - total_discount));
                $('#total_due').val(due_refund_amt);
                $('#pay_amount').val(pay_amounts);
                if (due_refund_amt >= 0) {
                    $('#due_refund').html("Due");
                } else {
                    $('#due_refund').html("Refund");
                }

                console.log((totalDue) + 'bellal');
            }

            console.log(total_due_data, pay_type_name, total_payment_amt, amount);
            $('#total_payment_amt').val(total_payment_amt);
            // $('#pay_amount').val(pay_amounts);
            var total_amount = parseFloat($("#total_payable").val() * 1);
            var pay_amount = parseFloat(pay_amounts * 1);

            if (total_amount > 0) {
                // $("#total_due_data").html((total_amount - pay_amount).toFixed(2));
                // $("#total_due").val((total_amount - pay_amount).toFixed(2));

                var given_amount = $("#given_amount").val() * 1;
                given_amount = parseFloat(given_amount);
                if (pay_amount > 0) {
                    if (given_amount > 0)
                        $("#change_amount").val(given_amount - pay_amount);
                    else
                        $("#change_amount").val("");
                } else {
                    $("#change_amount").val("");
                }
            }
            // calculateTotalinAmount(this);
            // addFuntion(this);

        }

        if ($("#tbody tr").length < 1) {

            $("#tfoot").html("");
        }
        calculateTotalinAmount(this);

        return;
    }

    function addFuntion(element) {


        $('#invalid_payment_type').hide()
        $('#invalid_amount').hide()
        $('#invalid_change_amount').hide()
        $('#invalid_cash_amount').hide()

        let paidAmount = parseFloat($('#cash_amount').val())
        // let payAmount = parseFloat($('#cash_bd_amount').val())
        let ipdPaymentType = $("#ipd_pay_type").val();
        let ipdPaymentName = $('#ipd_pay_type :selected').text();
        let changeAmount = parseFloat($('#change_amount').val());
        var mobileAmount = parseFloat($("#mBank_amount").val())
        var checkAmount = parseFloat($("#check_amount").val())
        var cardAmount = parseFloat($("#card_amount").val())
        var sub_type = $("#sub_type").val()
        var totalDueAmount = 0;
        if ($("#due_refund_amt").val() < 0) {
            var totalDueAmount = parseFloat(Math.abs($("#total_due").val()));
        } else {
            var totalDueAmount = 0;
        }

        if (ipdPaymentName == "FINAL BILL" && (parseFloat($("#total_due").val()) < paidAmount || parseFloat($(
                    "#total_due").val()) < mobileAmount || parseFloat($("#total_due").val()) < checkAmount ||
                parseFloat($("#total_due").val()) < cardAmount)) {
            alert("Invalid Amount");
            return false;
        }

        // var totalDueAmount = parseFloat($("#total_due").val());
        // var refund = parseFloat($("#total_due").val());



        // var totalDueAmount = parseFloat($('#total_due_data').html());
        var getTotalCost = parseFloat($('#getTotalCost').val()) ? parseFloat($('#getTotalCost').val()) : 0;
        var total_dis_amt = parseFloat($('#total_dis_amt').html()) ? parseFloat($('#total_dis_amt').html()) : 0;
        var total_cost = getTotalCost - total_dis_amt;

        // console.log(payAmount+mobileAmount+checkAmount+cardAmount)


        // if (!ipdPaymentType) {

        // 	$('#invalid_payment_type').show()

        // 	// alert("Please Select Payment Type");

        // } else if (!payAmount) {
        // 	$('#invalid_amount').show()
        // 	// alert('Enter Amount');

        // } else if (!paidAmount) {
        // 	$('#invalid_cash_amount').show()
        // 	// alert("Enter Paid Amount");

        // } else if (!changeAmount) {
        // 	$('#invalid_change_amount').show()
        // 	// alert("Enter Change Amount");

        // }

        // if (ipdPaymentType && payAmount && paidAmount && changeAmount) {


        if (ipdPaymentName == "REFUND") {
            console.log("Refund");


            if (paidAmount > totalDueAmount) {

                throw new Error(alert('Invalid Amount'));

            }
            if (mobileAmount > totalDueAmount) {

                throw new Error(alert('Invalid Amount'));

            }

            if (checkAmount > totalDueAmount) {

                throw new Error(alert('Invalid Amount'));

            }
            if (cardAmount > totalDueAmount) {

                throw new Error(alert('Invalid Amount'));

            }



        }



        if (paidAmount || mobileAmount || checkAmount || cardAmount) {


            if (ipdPaymentName == "REFUND") {
                if (paidAmount > totalDueAmount) {

                    throw new Error(alert('Invalid Amount'));

                }

                if (mobileAmount > totalDueAmount) {

                    throw new Error(alert('Invalid Amount'));

                }

                if (checkAmount > totalDueAmount) {

                    throw new Error(alert('Invalid Amount'));

                }
                if (cardAmount > totalDueAmount) {

                    throw new Error(alert('Invalid Amount'));

                }
            }




            var tfoot =
                "<tr><td></td> <td  class='text-left'  >Total:</td> <td > <input type='text' name='total_payment_amt' id='total_payment_amt' class='text-right' style='border: 0;width: 80px;' readonly='readonly'></td><td colspan='6'></td></tr>"

            $("#tfoot").html(tfoot);
            var amt = 0;


            if ($(element).attr('id') == 'cash_add') {
                if ($('#ipd_pay_type').val() != "") {
                    var amount = $(element).parents('div').find("#cash_amount").val();
                    var method_mode = 'CASH';
                    var bank_name = "";
                    var b_type = "";
                    var trans_id = "";
                    var card_no = "";
                    var acc_holder_name = "";
                } else {
                    alert('Enter Payment Type');
                    if ($("#tbody tr").length < 1) {
                        $("#tfoot").html("");
                    }
                    return;
                }
            }

            if ($(element).attr('id') == 'bkash_add') {
                if ($('#mBanking_type').val() != "" && $('#bkash_txn_id').val() != "" && $('#ipd_pay_type').val() !=
                    "") {

                    var amount = $("#mBank_amount").val();
                    var method_mode = 'Mbanking';
                    var bank_name = "";
                    var b_type = $('#mBanking_type').val();
                    var trans_id = $('#bkash_txn_id').val();
                    var card_no = "";
                    var acc_holder_name = "";
                } else {
                    if ($('#ipd_pay_type').val() == "") {
                        alert('Enter Payment Type');
                    } else if ($('#mBanking_type').val() == "") {
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

            if ($(element).attr('id') == 'check_add') {
                if ($('#bank_name').val() != "" && $('#check_no').val() != "" && $('#holder_name').val() != "" && $(
                        '#ipd_pay_type').val() != "") {
                    var method_mode = 'CQ';
                    var amount = $("#check_amount").val();
                    var bank_name = $('#bank_name').val();
                    var b_type = "";
                    var trans_id = "";
                    var card_no = $('#check_no').val();
                    var acc_holder_name = $('#holder_name').val();
                } else {
                    if ($('#ipd_pay_type').val() == "") {
                        alert('Enter Payment Type');
                    } else if ($('#bank_name').val() == "") {
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

            if ($(element).attr('id') == 'card_add') {
                if ($('#bank_name_card').val() != "" && $('#card_no').val() != "" && $('#card_holder_name').val() !=
                    "" && $('#card_type').val() != "" && $('#ipd_pay_type').val() != "") {
                    var method_mode = 'CARD';
                    var amount = $("#card_amount").val();
                    var bank_name = $('#bank_name_card').val();
                    var b_type = $('#card_type').val();
                    var trans_id = "";
                    var card_no = $('#card_no').val();
                    var acc_holder_name = $('#card_holder_name').val();
                } else {
                    if ($('#ipd_pay_type').val() == "") {
                        alert('Enter Payment Type');
                    } else if ($('#card_type').val() == "") {
                        alert('Enter Card  Type');
                    } else if ($('#bank_name_card').val() == "") {
                        alert('Enter Bank  Name');
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

            // var totalDue= $('#total_due').val();

            // if(amt>totalDue){
            // 	alert('Invalid Amount')
            // }else{


            var table_row = "<tr><td> <input class='' readonly='readonly' type='hidden' name='ipd_pay_type[]' value='" +
                ipdPaymentType +
                "' style='border: 0; width: 80px; text-align: right'><input class='pay_type' readonly='readonly' type='text' name='' value='" +
                ipdPaymentName +
                "' style='border: 0; width: 80px; text-align: right'> </td><td> <input type='text' name='sub_type' value='" +
                sub_type +
                "' readonly> </td> <td><input class='' readonly='readonly' type='text' name='pay_method_mode[]' value='" +
                method_mode +
                "' style='border: 0; width: 80px; text-align: right'></td><td><input class='total_amt' readonly='readonly' type='text' name='total_amt[]' value='" +
                amount +
                "' style='border: 0; width: 80px; text-align: right'></td><td><input class='' type='text' name='mBank_types[]' value='" +
                b_type +
                "' style='border: 0; width: 80px; text-align: right'></td><td><input class='' type='text' name='pay_bank_name[]' value='" +
                bank_name +
                "' style='border: 0; width: 80px; text-align: right'></td><td><input class='' type='text' name='trans_id_no[]' value='" +
                trans_id +
                "' style='border: 0; width: 80px; text-align: right'></td><td><input class='' type='text' name='card_number[]' value='" +
                card_no +
                "' style='border: 0; width: 80px; text-align: right'></td><td><input class='' type='text' name='acc_holder_name[]' value='" +
                acc_holder_name +
                "' style='border: 0; width: 80px; text-align: right'></td> <td class='text-center' style='width:3%'><span class='btn btn-sm btn-danger remove'  data-id='' onclick='removeTableRowPayment(this)' data-url='' title='Cancel '><i class='oi oi-circle-x'></i></span></td></tr>";

            if ($("#tbody tr").length >= 1 && amount > 0) {

                $("#tbody").append(table_row);
            } else {
                if (amount > 0) {

                    $("#tbody").html(table_row);
                } else {
                    alert("Enter amount");
                }

            }


            // $("input[class='total_amt']").each(function() {
            // 	if ($(this).val() != '') {
            // 		amt += parseFloat($(this).val());

            // 		$('#total_payment_amt').val(amt);
            // 		$('#pay_amount').val(amt);
            // 	}
            // });
            $("#tbody tr").each(function() {
                var pay_type_name = $(this).find(".pay_type").val();
                var amount = parseFloat($(this).find(".total_amt").val());

                if (amount != '') {

                    if (pay_type_name == "REFUND") {
                        amt -= amount;
                        $('#total_payment_amt').val(Math.abs(amt));
                        $('#pay_amount').val(Math.abs(amt));
                    } else {
                        amt += amount;

                        $('#total_payment_amt').val(Math.abs(amt));
                        $('#pay_amount').val(Math.abs(amt));
                    }

                }
            });

            // var totalDue = $('#total_due').val();
            var totalDue = $('#total_payable').val() ? parseFloat($('#total_payable').val()) : 0;

            var total_dis_amt = parseFloat($('#total_dis_amt').html()) ? parseFloat($('#total_dis_amt').html()) : 0;
            var due_refund = 0;
            var total_dis = $('#total_discount_amount').val() ? parseFloat($('#total_discount_amount').val()) : 0;
            if (ipdPaymentName == "REFUND") {
                due_refund = parseFloat(totalDue) + (Math.abs(amt) - (0 - $('#total_due').val()));
                // totalDue - (parseFloat(Math.abs($('#due_refund_amt').val())) - parseFloat($('#total_payment_amt').val())) + parseFloat(total_dis);
                console.log(Math.abs(amt), ($('#total_due').val()))
                //parseFloat(totalDue) + (parseFloat(amt) - parseFloat(total_dis_amt));

            } else {

                due_refund = (parseFloat($('#due_refund_amt').val() - parseFloat(total_dis))) - parseFloat($(
                    '#total_payment_amt').val());

            }

            if (due_refund >= 0) {
                $("#due_refund").html('Due');
                $('#total_due_data').html(Math.abs(due_refund.toFixed(2)));
                $('#total_due').val(due_refund);

            } else {
                console.log(due_refund);
                $("#due_refund").html('Refund');
                $('#total_due_data').html(Math.abs(due_refund.toFixed(2)));
                $('#total_due').val(due_refund);
            }
            //$('#total_due').val(due_refund)
            $("#change_amount").val("");
            $("#cash_amount").val("");
            $("#cash_bd_amount").val("");

            $("#mBank_amount").val("")
            $('#mBanking_type').val("")
            $('#bkash_txn_id').val("")

            $("#check_amount").val("")
            $('#bank_name').val("")
            $('#check_no').val("")
            $('#holder_name').val("")

            $("#card_amount").val("")
            $('#bank_name_card').val("")
            $('#card_type').val("")
            $('#card_no').val("")
            $('#card_holder_name').val("")


            // var total_amount = $("#total_payable").val() * 1;
            // var pay_amount = amt * 1;
            // $("#total_due_data").html((total_amount - pay_amount).toFixed(2));
            // if (total_amount>= pay_amount) {
            // 	$("#cash_amount").val(pay_amount);
            // }else{
            // 	$("#change_amount").val();
            // 	$("#cash_amount").val("");

            // }



        } else {
            alert('Invalid Amount')
        }


    }





    $(function() {

        $("#patient_type").focus();
        $('.select2').select2();





        $(document).on("click", "#option", function() {
            var paymentType = $(this).val();
            if (paymentType == "CARD") {
                $("#payment_method_card").removeClass("d-none");
                $("#payment_method_bkash").addClass("d-none");
                $("#payment_method_cheque").addClass("d-none");
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
            } else if (paymentType == "CS") {
                $("#payment_method_bkash").addClass("d-none");
                $("#payment_method_card").addClass("d-none");
                $("#payment_method_cheque").addClass("d-none");
                $("#cash").removeClass("d-none");
            } else if (paymentType == "DIPOSITED") {
                $("#payment_method_bkash").addClass("d-none");
                $("#payment_method_card").addClass("d-none");
                $("#payment_method_cheque").addClass("d-none");
                $("#cash").addClass("d-none");
                $("#payment_method_deposited").removeClass("d-none");
            } else {
                $("#payment_method_card").addClass("d-none");
                $("#payment_method_cheque").addClass("d-none");
                $("#payment_method_bkash").addClass("d-none");

            }
        });


        $(document).on('change', '#cmb_discount', function() {

            var type = $(this).find(":selected").val();


            if (type == "GENERAL") {
                $("#discount_percent_doctor").val('');
                $("#total_discount_amount").val('');
                $("#discount_percent").val('');
                $(".percent_hospital").removeClass('d-none');
                $(".percent_doctor").addClass('d-none');
            }
            if (type == "DOCTOR") {
                $("#discount_percent_hospital").val('');
                $("#total_discount_amount").val('');
                $("#discount_percent").val('');

                $(".percent_hospital").addClass('d-none');
                $(".percent_doctor").removeClass('d-none');
            }
            if (type == "BOTH") {
                $("#total_discount_amount").val('');
                $("#discount_percent").val('');
                $(".percent_hospital").removeClass('d-none');
                $(".percent_doctor").removeClass('d-none');
            }

            if (type == "0") {
                $(".percent_hospital").addClass('d-none');
                $(".percent_doctor").addClass('d-none');
            }

            //	ipdbillingEngine.calculateTotal(this);
        });

        $('.patient_entry').on('hidden.bs.modal', function(e) {})


        $(document).on("keypress", "input", function(e) {
            if (e.which == 13) {
                e.preventDefault();
            }
        });

        $(document).on("click", "#resetForm", function(e) {
            $("#frmBilling").find("input").val('');
        });

        $(document).on("change", "#su_no_fk", function(e) {
            $("#hdn_su_no_fk").val($("#su_no_fk").val());
        });
        $('.date_picker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
            clearBtn: true
        });



    });

    function selectItem(item, obj) {
        var total = item.item_rate;

        var sl = $("#billing_table-body tr").length + 1;

        if (item.itemtype_code == 'LAB' || item.itemtype_code == 'RAD') {
            var table_row = "<tr><td class='text-center bg-light' style='width:2%'>" + sl +
                "<input class='item_id' type='hidden' name='hdn_item_id[]' value='" + item.item_id +
                "' ><input class='hdn_item_name' type='hidden' name='hdn_item_name[]' value='" + item.item_name +
                "'><input class='hdn_item_type' type='hidden' name='hdn_item_type[]' value='" + item.item_type +
                "'> <input class='hdn_item_urgent_fee' type='hidden' name='hdn_item_urgent_fee[]' value='" + item
                .urgent_fee_amt + "'> </td><td style='width:12%'>" + item.item_dept +
                "<input type='hidden' name='hdn_item_dept_id[]' value='" + item.item_dept +
                "' ></td><td class='text-left'><strong>" + item.item_code + " - </strong> " + item.item_name +
                "</td><td class='text-center' style='width:12%'> <input type='text' name='delivery_date[]' class='date_picker form-control mb-0 text-right' placeholder='yyyy-mm-dd'></td><td class='text-center' style='width:12%'> <select name='item_delivery_status[]' class='form-control item_delivery_status' onchange='calculateUrgentFee(this)' style='margin-bottom:0px!important' ><option value='1'>Routine</option> <option value='2'>Urgent</option> </select> </td><td class='text-center qnty-width'><input type='text' class='form-control mb-0 text-right' name='item_rate[]' id='item_rate_" +
                item.item_id + "' value='" + item.item_rate +
                "' disabled='disabled' ><input type='hidden' class='form-control mb-0 text-right' name='hdn_item_rate[]' id='hdn_item_rate_" +
                item.item_id + "' value='" + item.item_rate +
                "' readonly='readonly' ><td class='text-center qnty-width'><input type='text' class='form-control mb-0 text-right' onkeyup='ipdbillingEngine.calculateItemTotal(this);ipdbillingEngine.calculateTotal(this)' id='hdn_item_qnty_" +
                item.item_id +
                "' name='hdn_item_qnty[]' readonly='readonly' value='1' ></td><td class='text-center qnty-width'><input type='text' class='form-control mb-0 text-right item_total_amt disabled' name='hdn_item_total_qnty[]' id='hdn_item_total_qnty_" +
                item.item_id + "' value='" + total +
                "' disabled='disabled' ></td><td class='text-center' style='width:3%'><span class='btn btn-sm btn-danger' data-id='' onclick='removeTableRowOnly(this)' data-url='' title='Cancel this appointment'><i class='oi oi-circle-x'></i></span></td></tr>";
        } else {
            var table_row = "<tr><td class='text-center bg-light' style='width:2%'>" + sl +
                "<input class='item_id' type='hidden' name='hdn_item_id[]' value='" + item.item_id +
                "' ><input class='hdn_item_name' type='hidden' name='hdn_item_name[]' value='" + item.item_name +
                "'><input class='hdn_item_type' type='hidden' name='hdn_item_type[]' value='" + item.item_type +
                "'>  <input class='hdn_item_urgent_fee' type='hidden' name='hdn_item_urgent_fee[]' value='" + item
                .urgent_fee_amt + "'></td><td style='width:12%'>" + item.item_dept +
                "<input type='hidden' name='hdn_item_dept_id[]' value='" + item.item_dept +
                "' ></td><td class='text-left'><strong>" + item.item_code + " - </strong> " + item.item_name +
                "</td><td class='text-center' style='width:12%'> <input type='hidden' name='delivery_date[]' class='date_picker form-control mb-0 text-right' placeholder='yyyy-mm-dd'></td><td class='text-center'> <input type='hidden' name='item_delivery_status[]' class='form-control' style='margin-bottom:0px!important'> </td><td class='text-center qnty-width'><input type='text' class='form-control mb-0 text-right' name='item_rate[]' id='item_rate_" +
                item.item_id + "' value='" + item.item_rate +
                "' disabled='disabled' ><input type='hidden' class='form-control mb-0 text-right' name='hdn_item_rate[]' id='hdn_item_rate_" +
                item.item_id + "' value='" + item.item_rate +
                "' readonly='readonly' ><td class='text-center qnty-width'><input type='text' class='form-control mb-0 text-right' onkeyup='ipdbillingEngine.calculateItemTotal(this);ipdbillingEngine.calculateTotal(this)' id='hdn_item_qnty_" +
                item.item_id +
                "' name='hdn_item_qnty[]' value='1' ></td><td class='text-center qnty-width'><input type='text' class='form-control mb-0 text-right item_total_amt disabled' name='hdn_item_total_qnty[]' id='hdn_item_total_qnty_" +
                item.item_id + "' value='" + total +
                "' disabled='disabled' ></td><td class='text-center' style='width:3%'><span class='btn btn-sm btn-danger' data-id='' onclick='removeTableRowOnly(this)' data-url='' title='Cancel this appointment'><i class='oi oi-circle-x'></i></span></td></tr>";
        }

        if ($("#billing_table-body tr").length >= 1) {
            $("#billing_table-body").append(table_row);
        } else {
            $("#billing_table-body").html(table_row);
        }

        ipdbillingEngine.calculateTotal(this);

        $('#item_code').typeahead('val', '');
        $('#item_name').typeahead('val', '');
        $('.date_picker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
            clearBtn: true
        });


    }

    function calculateUrgentFee(element) {
        var urgent_fee = $(element).parents("tr").find(".hdn_item_urgent_fee").val();
        if (urgent_fee == 'null') {
            urgent_fee = 0;
        } else {

        }

        var item_id = $(element).parents("tr").find(".item_id").val();
        var item_price = $('#hdn_item_rate_' + item_id).val();
        var total = 0;
        if ($(element).val() == 2) {
            total = parseFloat(urgent_fee) + parseFloat(item_price);
            $('#hdn_item_total_qnty_' + item_id).val(total);
            $('#item_rate_' + item_id).val(total);
        } else {
            $('#hdn_item_total_qnty_' + item_id).val(item_price);
            $('#item_rate_' + item_id).val(item_price);
        }
        ipdbillingEngine.calculateTotal(parseInt(this));
        ipdbillingEngine.calculatePayment(parseInt(this));
    }

    function patientInfo(item, obj) {
        var patientNumber = item.phone_mobile == null ? "N/A" : item.phone_mobile;
        var patient_information = "<strong>Patient Code: " + item.patient_code + " : </strong>Name: " + item
            .patient_name + ", <strong>Gender : </strong>" + item.gender + ", <strong>Age : </strong>" + item.age +
            ", <strong>Phone : </strong>" + item.phone_mobile;
        //var patient_information = "<strong>" + item.patient_code + " : </strong>" + item.patient_name + ",<strong>Phone : </strong>" +patientNumber;
        $("#patient_info").html(patient_information);
        $('#patient_id').typeahead('val', '');
        $('#admission_id').typeahead('val', '');
        $("#patient_id").removeAttr("required");
        $("#hdn_admission_id").val('');
    }

    function doctorInfo(item, obj) {
        var doctorPhone = item.phone_mobile == null ? "N/A" : item.phone_mobile;
        var doctor_info = "<strong>" + item.person_code + " : </strong>" + item.full_name + ", <i>(" + item
            .specialization + "), </i><strong>Gender : </strong>" + item.gender_txt + ", <strong>Phone : </strong>" +
            doctorPhone;
        //var doctor_info = "<strong>Patient Code: " + item.person_code + " : </strong>Name: " + item.full_name + ", <strong>Gender : </strong>" + item.gender_txt + ", <strong>Age : </strong>" + item.person_age + ", <strong>Phone : </strong>" + item.phone_mobile;
        $("#doctor_info").html(doctor_info);
        $('#doctor_code').typeahead('val', '');
        $("#doctor_code").removeAttr("required");
    }

    function doctorInfoFirstRef(item, obj) {
        var doctorPhone = item.phone_mobile == null ? "N/A" : item.phone_mobile;
        var doctor_info = "<strong>" + item.person_code + " : </strong>" + item.full_name + ", <i>(" + item
            .specialization + "), </i><strong>Gender : </strong>" + item.gender_txt + ", <strong>Phone : </strong>" +
            doctorPhone;
        $("#doctor_ref1_info").html(doctor_info);
        $('#first_refer').typeahead('val', '');

    }

    function doctorInfoSecondRef(item, obj) {
        var doctorPhone = item.phone_mobile == null ? "N/A" : item.phone_mobile;
        var doctor_info = "<strong>" + item.person_code + " : </strong>" + item.full_name + ", <i>(" + item
            .specialization + "), </i><strong>Gender : </strong>" + item.gender_txt + ", <strong>Phone : </strong>" +
            doctorPhone;
        $("#doctor_ref2_info").html(doctor_info);
        $('#second_refer').typeahead('val', '');

    }

    function removeTableRowOnly(thisElement) {
        if (confirm("Are you sure?")) {
            $(thisElement).parents("tr").remove();
        }
        ipdbillingEngine.calculateTotal(this);
        ipdbillingEngine.calculatePayment(this);
        return;
    }


    function calculateTotalDis(thisElement) {
        var t_amt = parseFloat($("#discount_amount_hospital").val()) + parseFloat($("#discount_amount_doctor").val());

        if (parseFloat(t_amt) > parseFloat($("#item_total").html())) {

            alert("discount amount is over");
            $("#discount_amount_hospital").val(0);
            $("#discount_percent_hospital").val(0);
            $("#discount_percent_doctor").val(0);
            $("#discount_percent").val(0);
            $("#discount_amount_doctor").val(0);
            $("#total_discount_amount").val(0);
            return calculateTotalDis(thisElement);

        } else {

            var item_total = 0;
            var delivery_status = 0;
            var urgent_fee = 0;
            if ($("#billing_table-body tr").length > 0) {

                $("#billing_table-body tr").each(function() {
                    item_total += $(this).find(".item_total_amt").val() * 1;
                    delivery_status = $(this).find(".item_delivery_status").val();
                    if (delivery_status == 2) {
                        if ($(this).find(".hdn_item_urgent_fee").val() != 'null') {
                            urgent_fee += parseFloat($(this).find(".hdn_item_urgent_fee").val());
                        }
                    }

                });
                $("#item_total").html(item_total.toFixed(2));
                $("#total_payable").val(item_total.toFixed(2));

                var discount_percent_hospital = ($("#discount_amount_hospital").val() != "") ? parseFloat($(
                    "#discount_amount_hospital").val()) : 0;
                var discount_amt_hospital = (discount_percent_hospital);
                var item_total_amount = $("#item_total").html();

                var discount_percent_hospital_dis = (discount_percent_hospital > 0) ? discount_percent_hospital * 100 /
                    item_total_amount : 0;

                $("#discount_percent_hospital").val(discount_percent_hospital_dis.toFixed(2));
                // $("#discount_percent").val(discount_percent_hospital_dis.toFixed(2));

                var discount_percent_doctor = ($("#discount_amount_doctor").val() != "") ? parseFloat($(
                    "#discount_amount_doctor").val()) : 0;
                var discount_amt_doctor = (discount_percent_doctor);
                var item_total_amount = $("#item_total").html();

                var discount_percent_doctor_dis = (discount_percent_doctor > 0) ? discount_percent_doctor * 100 /
                    item_total_amount : 0;

                $("#discount_percent_doctor").val(discount_percent_doctor_dis.toFixed(2));
                // $("#discount_amount_doctor").val(discount_amt_doctor.toFixed(2));
                // var discount_amt_doctor = ($(thisElement).val() != "") ? $(thisElement).val() : 0;

                var discount_percent = ($(thisElement).val() != "") ? $(thisElement).val() : 0;
                var discount_amt_total = (discount_percent);

                // $("#total_discount_amount").val(discount_amt_total);
                // var discount_amt_total = ($(thisElement).val() != "") ? $(thisElement).val() : 0;

                // if(discount_percent_hospital != 0 ||  discount_percent_doctor != 0)
                // 	$("#discount_percent").val(0);


                var after_disc_amt = 0;
                var total_discount_amount = 0;
                var total_discount_amount_per = 0;
                if (discount_percent == 0) {

                    total_discount_amount = (parseFloat(discount_amt_doctor) + parseFloat(discount_amt_hospital));

                    if ((discount_percent_hospital_dis + discount_percent_doctor_dis) == 0) {
                        $("#discount_percent").val();
                    } else {
                        total_discount_amount_per = parseFloat(discount_percent_hospital_dis) + parseFloat(
                            discount_percent_doctor_dis);

                        $("#discount_percent").val(total_discount_amount_per.toFixed(2));
                    }

                    $("#total_discount_amount").val(total_discount_amount);

                    after_disc_amt = (item_total - total_discount_amount);
                } else {

                    discount_percent = (parseFloat(discount_amt_doctor) + parseFloat(discount_amt_hospital));
                    total_discount_amount_per = parseFloat(discount_percent_hospital_dis) + parseFloat(
                        discount_percent_doctor_dis);

                    $("#discount_percent").val(total_discount_amount_per.toFixed(2));

                    discount_amt_total = (discount_percent);

                    // alert(discount_amt_total);
                    $("#total_discount_amount").val(discount_amt_total);
                    total_discount_amount = discount_amt_total;
                    after_disc_amt = item_total - discount_amt_total;
                }

                var item_vat = $("#item_vat").val() * 1;

                $("#urgent_fee").val(urgent_fee);
                var s_charge = $("#s_charge").val() * 1;


                var total_payable = ((after_disc_amt + item_vat + s_charge));
                $("#total_payable").val(total_payable.toFixed(2));
                // $("#pay_amount").val(total_payable.toFixed(2));


                var pay_amount = $('#pay_amount').val() * 1;
                $("#total_due_data").html((total_payable - pay_amount).toFixed(2));

            } else {
                $("#billing_table-body tr").html('');
                $('#total_payable').val(0);
                $('#pay_amount').val(0);
                $('#given_amount').val(0);
                $("#item_total").html(0.00);
                $("#change_amount").val(0.00);
                // alert("You did not selected any Item.");
                return;
            }
            event.stopImmediatePropagation();
        }
    }

    /*Calculate Percentage and Amount for Discount*/
    function calculateTotalinAmount(thisElement) {
        var totalPercentage = 0;
        var totalPercentageAmount = 0;
        var percentagebyDoctor = 0;
        var percentageAmountbyHospital = 0;
        var totalPayableAmount = $('#total_invoice_bill').val();
        var total_dis_amt = parseFloat($('#total_dis_amt').html());

        var PayableAmount = $('#pay_amount').val() ? $('#pay_amount').val() : 0;
        var cost = $('#getTotalCost').val() ? $('#getTotalCost').val() : 0;
        // var cost=$('#total_paid_amount').html() ? parseFloat($('#total_paid_amount').html()) : 0;

        if ((cost - total_dis_amt) >= $(thisElement).val()) {
            if ($('#discount_amount_by_hospital').val() > 0) {
                percentageAmountbyHospital = (parseFloat($('#discount_amount_by_hospital').val()) * 100) /
                    totalPayableAmount;
                totalPercentage += percentageAmountbyHospital;
                totalPercentageAmount += parseFloat($('#discount_amount_by_hospital').val());
                $('#discount_percent_hospital').val(percentageAmountbyHospital.toFixed(2));

            } else {
                $('#discount_percent_hospital').val("");
            }

            if ($('#discount_amount_by_doctor').val() > 0) {
                percentageAmountbyDoctor = (100 * parseFloat($('#discount_amount_by_doctor').val())) /
                    totalPayableAmount;
                totalPercentage += percentageAmountbyDoctor;
                totalPercentageAmount += parseFloat($('#discount_amount_by_doctor').val());
                $('#discount_percent_doctor').val(percentageAmountbyDoctor.toFixed(2));

            } else {
                $('#discount_percent_doctor').val("");
            }

            // if (totalPercentage > 100) {
            //     alert('Invalid Discount!')
            //     $('#discount_percent').val('');
            //     $('#total_discount_amount').val('')
            //     $('#discount_amount_by_hospital').val('');
            //     $('#discount_amount_by_doctor').val('');
            //     $('#discount_percent_doctor').val('')
            //     $('#discount_percent_hospital').val('')
            //     $('#total_payable').val(totalPayableAmount)

            // } else {
            var remaining_balance = parseFloat($('#total_paid_amount').html());
            var total_payment_amt = $('#total_payment_amt').val() ? parseFloat($('#total_payment_amt').val()) : 0;
            // $('#total_due').val(totalPayableAmount - totalPercentageAmount - remaining_balance);
            $('#discount_percent').val(totalPercentage.toFixed(3));

            $('#total_discount_amount').val(totalPercentageAmount)

            // $('#total_payable').val(totalPayableAmount - totalPercentageAmount - remaining_balance);

            if ((totalPayableAmount - (totalPercentageAmount + total_dis_amt) - remaining_balance) >= 0) {

                $('#due_refund').html("Due");

                $('#total_due_data').html(Math.abs(totalPayableAmount - (totalPercentageAmount + total_dis_amt) - (
                    remaining_balance + total_payment_amt)).toFixed(2));


                // $('#total_due_data').html(Math.abs(totalPayableAmount - (totalPercentageAmount + total_dis_amt) - remaining_balance - PayableAmount));

                $('#total_due').val((totalPayableAmount - (totalPercentageAmount + total_dis_amt) - (remaining_balance +
                    total_payment_amt)));

                // $('#total_due').val(Math.abs(totalPayableAmount - (totalPercentageAmount + total_dis_amt) - remaining_balance - PayableAmount));
            } else {

                console.log((totalPayableAmount - (totalPercentageAmount + total_dis_amt) - remaining_balance) +
                    'bellal');
                $('#due_refund').html("Refund");

                $('#total_due_data').html(Math.abs(totalPayableAmount - (totalPercentageAmount + total_dis_amt) - (
                    remaining_balance + total_payment_amt)).toFixed(2));
                $('#total_due').val(totalPayableAmount - (totalPercentageAmount + total_dis_amt) - (remaining_balance +
                    total_payment_amt));

                // $('#total_due_data').html(Math.abs(totalPayableAmount - (totalPercentageAmount + total_dis_amt) - remaining_balance - PayableAmount));
                // $('#total_due').val(Math.abs(totalPayableAmount - (totalPercentageAmount + total_dis_amt) - remaining_balance - PayableAmount));

                $('#total_payable').val(0);
            }
            // }
        } else {
            alert("Invalid Amount");
            $("#discount_percent_hospital").val('');
            $("#discount_amount_by_hospital").val('');
            $("#discount_percent_doctor").val('');
            $("#discount_amount_by_doctor").val('');
            calculateTotalinAmount(Element);
        }
    }



    function calculateTotalinDiscount(thisElement) {
        var totalPercentage = 0;
        var totalPercentageAmount = 0;
        var percentagebyDoctor = 0;
        var percentageAmountbyHospital = 0;
        var totalPayableAmount = $('#total_invoice_bill').val();
        var PayableAmount = $('#pay_amount').val() ? $('#pay_amount').val() : 0;
        if (totalPayableAmount > 0) {
            if ($('#discount_percent_hospital').val() > 0) {
                percentageAmountbyHospital = (totalPayableAmount * parseFloat($('#discount_percent_hospital').val())) /
                    100;
                totalPercentage += $('#discount_percent_hospital').val() ? parseFloat($('#discount_percent_hospital')
                    .val()) : 0;
                totalPercentageAmount += parseFloat(percentageAmountbyHospital);
                $('#discount_amount_by_hospital').val(percentageAmountbyHospital);

            } else {
                $('#discount_amount_by_hospital').val("");
            }
            totalPercentageAmount += $('#discount_amount_by_doctor').val() ? parseFloat($('#discount_amount_by_doctor')
                .val()) : 0;
            // if ($('#discount_percent_doctor').val() > 0) {
            //     percentageAmountbyDoctor = (totalPayableAmount * parseFloat($('#discount_percent_doctor').val())) / 100;
            //     totalPercentage += parseFloat($('#discount_percent_doctor').val());
            //     totalPercentageAmount += percentageAmountbyDoctor;
            //     $('#discount_amount_by_doctor').val(percentageAmountbyDoctor);

            // } else {
            //     $('#discount_amount_by_doctor').val("");
            // }

            if (totalPercentage > 100) {
                alert('Invalid Discount!')
                $('#discount_percent').val('');
                $('#total_discount_amount').val('')
                $('#discount_amount_by_hospital').val('');
                $('#discount_amount_by_doctor').val('');
                $('#discount_percent_doctor').val('')
                $('#discount_percent_hospital').val('')
                $('#total_payable').val(totalPayableAmount)

            } else {
                var remaining_balance = parseFloat($('#total_paid_amount').html());
                $('#total_due').val(totalPayableAmount - totalPercentageAmount - remaining_balance);
                $('#discount_percent').val(totalPercentage);
                $('#total_discount_amount').val(totalPercentageAmount);
                $('#total_payable').val(totalPayableAmount - totalPercentageAmount - remaining_balance);
                if ((totalPayableAmount - totalPercentageAmount - remaining_balance) >= 0) {
                    $('#due_refund').html("Due");
                    $('#total_due_data').html(Math.abs(totalPayableAmount - totalPercentageAmount - remaining_balance -
                        PayableAmount));
                } else {
                    $('#due_refund').html("Refund");
                    $('#total_due_data').html(Math.abs(totalPayableAmount - totalPercentageAmount - remaining_balance -
                        PayableAmount));
                    $('#total_payable').val(0);
                }
            }
        } else {
            alert("Invalid Amount");
            $("#discount_percent_hospital").val('');
            $("#discount_amount_by_hospital").val('');
            $("#discount_percent_doctor").val('');
            $("#discount_amount_by_doctor").val('');
        }
    }


    function calculateTotalinDiscountDoc(thisElement) {
        var totalPercentage = 0;
        var totalPercentageAmount = 0;
        var percentagebyDoctor = 0;
        var percentageAmountbyHospital = 0;
        var totalPayableAmount = $('#total_invoice_bill').val();
        var PayableAmount = $('#pay_amount').val() ? $('#pay_amount').val() : 0;
        if (totalPayableAmount > 0) {
            totalPercentageAmount += $('#discount_amount_by_hospital').val() ? parseFloat($(
                '#discount_amount_by_hospital').val()) : 0;
            totalPercentage += $('#discount_percent_hospital').val() ? parseFloat($('#discount_percent_hospital')
                .val()) : 0;

            // if ($('#discount_percent_hospital').val() > 0) {
            //     percentageAmountbyHospital = (totalPayableAmount * parseFloat($('#discount_percent_hospital').val())) /
            //     100;
            //     totalPercentage += parseFloat($('#discount_percent_hospital').val());
            //     totalPercentageAmount += percentageAmountbyHospital;
            //     $('#discount_amount_by_hospital').val(percentageAmountbyHospital);

            // } else {
            //     $('#discount_amount_by_hospital').val("");
            // }

            if ($('#discount_percent_doctor').val() > 0) {
                percentageAmountbyDoctor = (totalPayableAmount * parseFloat($('#discount_percent_doctor').val())) / 100;

                totalPercentage += $('#discount_percent_doctor').val() ? parseFloat($('#discount_percent_doctor')
                    .val()) : 0;
                totalPercentageAmount += parseFloat(percentageAmountbyDoctor);
                console.log(percentageAmountbyDoctor);
                $('#discount_amount_by_doctor').val(percentageAmountbyDoctor);

            } else {
                $('#discount_amount_by_doctor').val("");
            }

            if (totalPercentage > 100) {
                alert('Invalid Discount!')
                $('#discount_percent').val('');
                $('#total_discount_amount').val('')
                $('#discount_amount_by_hospital').val('');
                $('#discount_amount_by_doctor').val('');
                $('#discount_percent_doctor').val('')
                $('#discount_percent_hospital').val('')
                $('#total_payable').val(totalPayableAmount)

            } else {
                var remaining_balance = parseFloat($('#total_paid_amount').html());
                $('#total_due').val(totalPayableAmount - totalPercentageAmount - remaining_balance);
                $('#discount_percent').val(totalPercentage);
                $('#total_discount_amount').val(totalPercentageAmount);
                $('#total_payable').val(totalPayableAmount - totalPercentageAmount - remaining_balance);
                if ((totalPayableAmount - totalPercentageAmount - remaining_balance) >= 0) {
                    $('#due_refund').html("Due");
                    $('#total_due_data').html(Math.abs(totalPayableAmount - totalPercentageAmount - remaining_balance -
                        PayableAmount));
                } else {
                    $('#due_refund').html("Refund");
                    $('#total_due_data').html(Math.abs(totalPayableAmount - totalPercentageAmount - remaining_balance -
                        PayableAmount));
                    $('#total_payable').val(0);
                }
            }
        } else {
            alert("Invalid Amount");
            $("#discount_percent_hospital").val('');
            $("#discount_amount_by_hospital").val('');
            $("#discount_percent_doctor").val('');
            $("#discount_amount_by_doctor").val('');
        }
    }


    /*Calculate Percentage and Amount for Discount*/



    openPatientAutocomplete('#patient_id', 'patient_name', patientInfo);
    openDoctorAutocomplete('#doctor_code', 'hdn_doctor_id', 'doctor_ind', '1,2', doctorInfo);
    openDoctorAutocomplete('#first_refer', 'hdn_first_refer', 'referal_ind', '1,2', doctorInfoFirstRef);
    openDoctorAutocomplete('#second_refer', 'hdn_second_refer', 'referal_ind', '1,2', doctorInfoSecondRef);
    openBillingItemAutocomplete(".item_typehead", item_type = "", item_type_void = "MED,GENERIC", selectItem);
    openAdmissionAutocomplete('#admission_id', 'patient_name', patientInfo);
    openDoctorAutocomplete('#primary_doctor', 'doctor_id');

    /*
    @payment Entry from here

    */

    function addipdPayment() {
        formAction = $("#ipdpaymentform").attr("action");
        formMethod = $("#ipdpaymentform").attr("method");
        console.log($("#ipdpaymentform").serialize());
        $.ajax({
            data: $("#ipdpaymentform").serialize(),

            url: formAction,
            type: formMethod,
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                console.log(data)
                $("#ipdSearchResult").html(data);
            },
            complete: function() {
                if (isAModalOpen)
                    $('.modal').modal('hide');
                $.unblockUI();
            }
        });
    }
</script>
