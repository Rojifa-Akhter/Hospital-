<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<div class="form-row">
    @include('admin.billing.due_collection.patient_info')
    <div class="col-md-7">
        <div class="privious-history">
            <div class="card shadow-sm mt-1">
                <div class="card-header">
                    <h5>Invoice Payment & Discount History</h5>
                </div>
                <input type="hidden" id="admission_id" value="{{isset($finc_inv_collection_amount) && $finc_inv_collection_amount->admission_no_pk !=''  ? $finc_inv_collection_amount->admission_no_pk :''}}">
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
                                        <td class="text-center">{{ date('d/m/Y', strtotime($value->invoice_date)) }}
                                        </td>
                                        <td class="text-right">
                                            {{ isset($value->ledger_amt_payment) ? $value->ledger_amt_payment : '0' }}
                                        </td>
                                        <td class="text-right">{{ isset($value->ledger_amt_discount) ? $dis : '0' }}
                                        </td>
                                        <td class="text-left">
                                            {{ isset($value->ledger_entry_txt) ? $value->ledger_entry_txt : '' }}</td>
                                        <td class="text-left">{{ $value->pay_mode == '0' ? ' ' : $value->pay_mode }}
                                        </td>

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
                <div class="form-row">
                    <div class="col-md-2">
                        <h5>Item Name</h5>
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control item_typehead" id="item_code" name="item_code"
                            placeholder="Item Name / Code" />
                    </div>
                </div>

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
                            <th class="text-left">Provider</th>
                            <th class="text-left">Del. Stat.</th>
                            <th class="text-right w-5">Old Qty</th>
                            <th class="text-right w-5">Edit Qty</th>
                            <th class="text-right">Rate</th>
                            <th class="text-left">Inv. Status</th>
                            <th class="text-center"></th>
                            <th class="text-right">Cancel Qty</th>
                            <th class="text-center">Report Delivery</th>
                            <th class="text-right">Disc. (%)</th>
                            <th class="text-right">Disc. Amt</th>
                            <th class="text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="item_list">
                        @if (!empty($invoice_item_list))
                            @foreach ($invoice_item_list as $item)
                                <tr>
                                    <input type="hidden" class="invoice_dtl_no" name="hdn_invoice_dtl_no[]"
                                        value="{{ $item->invoicedtl_no_pk }}">
                                        <input type='hidden' class='w-100 mb-0 text-right form-control ipd_charge_amt' id='' name='ipd_charge[]' value='' readonly />
                                    <input type="hidden" class="item_id" name="hdn_item_id[]"
                                        value="{{ $item->item_no_fk }}">
                                    <input type="hidden" name="hdn_item_name[]" value="{{ $item->item_name }}">
                                    <input type="hidden" name="hdn_item_type[]" value="{{ $item->itemtype_no_fk }}">
                                    <input type="hidden" name="item_delivery_status[]" class="item_delivery_status"
                                        value="{{ $item->delivery_status_lookup_no_fk }}">
                                    <input type="hidden" name="delivery_date[]"
                                        value="{{ $item->report_delivery_date }}">
                                    <input type="hidden" name="hdn_item_qnty[]" value="{{ $item->item_qty }}">
                                    <input type="hidden" id="hdn_item_edited_ind" name="hdn_item_edited_ind[]"
                                        value="0">
                                    <input type="hidden" name="hdn_item_rate[]" class="hdn_item_rate"
                                        value="{{ $item->item_rate }}">
                                    <input type="hidden" name="hdn_item_urgent_fee[]" class="hdn_item_urgent_fee"
                                        value="{{ $item->urgent_fee }}">
                                    <td class="text-center">{{ $item->item_code }}</td>
                                    <td class="text-left">{{ $item->item_name }}</td>
                                    <td class="text-left">{{ $item->item_type_name }}</td>
                                    <td class="text-left">{{ $item->item_type_name }}</td>
                                    <td class="text-left">
                                        <input type="text" class="provider form-control" id="provider"
                                            name="provider[]">
                                        <input type="hidden" class="hdn_provider_no" id="hdn_provider_no"
                                            name="hdn_provider_no[]" value="">
                                    </td>
                                    <td class="text-left">
                                        @if ($item->delivery_status_lookup_no_fk == 1)
                                            Routine
                                        @else
                                            Urgent
                                        @endif

                                    </td>
                                    <td class="text-right"><input type="text" name="old_qty_[]"
                                            value="{{ $item->item_qty }}" class=" old_qty w-100" readonly></td>
                                    <td class="text-right">
                                        <input type="text" class=" edit_qty number_only text-right w-100"
                                            name="edit_qty_[]" onkeyup="newQty(this)">
                                        <input type="hidden" class="edit_ind" name="edit_ind[]" value="0">
                                    </td>
                                    <td class="text-left" class="item_rate" style='font-weight: bold'>
                                        {{ $item->item_rate }}</td>
                                    <td class="text-left">{{ $item->investigation_status }}</td>
                                    <td class="text-center"><input type="checkbox" onclick="" name=""
                                            value="" id="cancel_ind"
                                            data-invoice-id="{{ $item->invoicedtl_no_pk }}"
                                            data-item-qty="{{ $item->item_qty }}"
                                            {{ $item->cancel_ind == 1 ? 'checked' : '' }}></td>
                                    <td class="text-right"> <input type="text" name="cancel_checkbox[]"
                                            id="cancel_checkbox_{{ $item->invoicedtl_no_pk }}"
                                            class=" cancel_checkbox text-right" disabled="disabled"
                                            value="{{ $item->cancel_qty }}"></td>
                                    <td class="text-right">
                                        @if (date('d/m/Y', strtotime($item->report_delivery_date)) == '01/01/1970')
                                        @else
                                            {{ date('d/m/Y', strtotime($item->report_delivery_date)) }}
                                        @endif
                                    </td>
                                    <td class="text-right"> {{ $item->disc_perc }} </td>
                                    <td class="text-right">
                                        <input type="text" class="number_only item_dis_amt" name="item_dis_amt[]"
                                            value=" {{ number_format((float) $item->disc_amount, 2, '.', '') }}"
                                            readonly>

                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-danger mx-1" data-invoice=""
                                            onclick="invoiceItemDelete(this)" id="invoice_delete"
                                            data-invoice="{{ $item->invoice_no_fk }}"
                                            data-item="{{ $item->item_no_fk }}"><i class="fas fa-times"></i></button>

                                    </td>
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
                        <div class="col-md-6"></div>
                        <div class="col-md-6">
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
                                                            // $urgent_fee = isset($patient_info->urgent_fee)? $patient_info->urgent_fee :0;
                                                            // $vat = isset($patient_info->ledger_amt_vat)? $patient_info->ledger_amt_vat :0;
                                                            // $sales =isset($total_item_rates->ledger_amt_sales)? $total_item_rates->ledger_amt_sales :0;
                                                            // $total_amount = $sales + $urgent_fee + $vat;
                                                            $total_amount = 0;
                                                            $urgent_fee = isset($finc_inv_sum_amount->urgent_fee) ? $finc_inv_sum_amount->urgent_fee : 0;
                                                            $vat = isset($finc_inv_sum_amount->ledger_amt_vat) ? $finc_inv_sum_amount->ledger_amt_vat : 0;
                                                            $led_amt_sales = isset($finc_inv_sum_amount->ledger_amt_sales) ? $finc_inv_sum_amount->ledger_amt_sales : 0;
                                                            $discount = isset($finc_inv_sum_amount->discount) ? $finc_inv_sum_amount->discount : 0;
                                                            $cancel_discount = isset($finc_inv_sum_amount->cancel_discount) ? $finc_inv_sum_amount->cancel_discount : 0;

                                                            $payment = isset($finc_inv_sum_amount->collection) ? $finc_inv_sum_amount->collection : 0;
                                                            $total_payment = isset($finc_inv_sum_amount->net_collection) ? $finc_inv_sum_amount->net_collection : 0;
                                                            // $due = isset($led_amt_sales) ? $led_amt_sales + $vat - ($discount + $cancel_discount) - $total_payment : 0;
                                                            $due = isset($led_amt_sales) ? $led_amt_sales + ($vat + $urgent_fee) - ($discount + $total_payment) : 0;

                                                            $refund = isset($finc_inv_sum_amount->refund) ? $finc_inv_sum_amount->refund : 0;
                                                            $total = $led_amt_sales;
                                                            $total_amount = $led_amt_sales + $vat + $urgent_fee;
                                                        @endphp
                                                        <h5 class="float-left mr-2 mb-0">Total Item Amount</h5>
                                                        <span
                                                            class="float-right btn btn-outline-success bg-none btn-md"
                                                            id="net_payable">{{ $total }}</span>
                                                        <input type="hidden" id="total_amt_dis" name=""
                                                            value="{{ number_format((float) $total, 2, '.', '') }}">
                                                    </li>
                                                    <!-- <li
                                                        class="list-group-item d-flex align-items-center justify-content-end">
                                                        <span class="mr-2">Total VAT.</span>
                                                        <div class="d-flex align-items-center">
                                                            <input type="text" class="form-control number_only"
                                                                id="" name="" placeholder="0.00"
                                                                style="width:70px; text-align: right;"
                                                                value="{{ $vat }}">
                                                        </div>
                                                    </li> -->
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
                                                                style="width: 70px; text-align: right;"
                                                                placeholder="00.00"
                                                                value="{{ number_format((float) $total_amount, 2, '.', '') }}">
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
                                                                value="{{ isset($discount) ? number_format((float) $discount, 2, '.', '') : '0' }}">
                                                        </div>
                                                    </li>

                                                    <li
                                                        class="list-group-item d-flex align-items-center justify-content-end">
                                                        <span class="mr-2">Paid Amount</span>
                                                        <div class="">
                                                            <input type="text" id="initial_payment"
                                                                class="form-control number_only"
                                                                style="width: 70px; text-align: right;"
                                                                placeholder="00.00"
                                                                value="{{ isset($payment) ? number_format((float) $payment, 2, '.', '') : '0' }}">
                                                        </div>
                                                    </li>

                                                    <li
                                                        class="list-group-item d-flex align-items-center justify-content-end">
                                                        <span class="mr-2" id="span_due_txt">
                                                            @if ($due >= 0)
                                                                Due Amount
                                                            @else
                                                                Refund Amount
                                                            @endif
                                                        </span>
                                                        <div class="">

                                                            <input type="text" id="due_payment"
                                                                class="form-control number_only"
                                                                style="width: 70px; text-align: right;"
                                                                placeholder="00.00"
                                                                value="{{ $due >= 0 ? number_format($due, 2, '.', '') : abs( $due) }}">
                                                            <input type="hidden" id="due_payment_hdn"
                                                                class="form-control number_only"
                                                                style="width: 70px; text-align: right;"
                                                                placeholder="00.00"
                                                                value="{{ $due >= 0 ? number_format($due, 2, '.', '') : abs( $due)  }}">
                                                        </div>
                                                    </li>                                                 

                                                </ul>
                                            </div>
                                            <div class="col-md-12  mt-2">
                                                @php
                                                    $bill_id = '';
                                                    $response_url = route('due-colletion-invoice', $bill_id);
                                                @endphp
                                                <input type="hidden" name="hdn_patient_id" value=""
                                                    readonly="readonly">
                                                <input type="hidden" name="page_type" value="1"
                                                    class="keep_me">

                                                <button class="btn btn-md btn-success"
                                                    data-response_action="{{ $response_url }}"
                                                    onclick="billingEngine.editInvoice(this,resetDueBillForm)">Save&nbsp;&nbsp;Show</button>
                                                    <input type="hidden" value="{{$item_type_lists}}" id="item_type_list" name="item_type_list">
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
    $('.provider').keyup(function() {
        if ($(this).val() == "") {
            $(this).parent("span").siblings(".hdn_provider_no").val('');
        }
    })
    // function emptyDocId(element) {

    // }
    var admission_id = $('#admission_id').val();
        $(function(){
            let item_list_type = `"${$('#item_type_list').val()}"`;
            console.log(item_list_type)
            // "GENERIC,SERVICE,LAB,RAD,IPD,BED,SUR,AMB,FOOD,PTET,PTTE,OPD,COMS,ADM,OT"
            openBillingItemAutocomplete(".item_typehead", item_type =item_list_type, item_type_void = "MED", selectItem, "", "", "",admission_id);
        })
    // openBillingItemAutocomplete(".item_typehead", item_type =
    //     "GENERIC,SERVICE,LAB,RAD,IPD,BED,SUR,AMB,FOOD,PTET,PTTE,OPD,COMS,ADM,OT",
    //     item_type_void = "MED", selectItem, "", "", "", "");

    openDoctorAutocompleteV1('.provider', '.hdn_provider_no');


    function editQty(element) {
        console.log($(element).val())
        if ($(element).val() == null) {
            $(element).parents('td').parents('tr').find('#hdn_item_edited_ind').val(0);
        } else {
            $(element).parents('td').parents('tr').find('#hdn_item_edited_ind').val(1);
        }
    }

    function selectItem(item, obj) {

        var invoice_dtl_no = $('#invoice_dtl_no').val();
        var add = 0;
        $('.item_id').each(function() {
            var item_id_no = $(this).val();

            if (item.item_id == item_id_no) {
                alert("Already Selected");
                add = 1;
            }
        })
        var ipd_charge = item.ipd_charge;
        var provider_id_sl = $('.item_list tr').length;
        var add_item = `<tr>
                                <input type="hidden" class="invoice_dtl_no" name="hdn_invoice_dtl_no[]" value="">
                                <input type='hidden' class='w-100 mb-0 text-right form-control ipd_charge_amt' id='' name='ipd_charge[]' value='${ipd_charge}' readonly />
                                <input type="hidden" class="item_id" name="hdn_item_id[]" value="${item.item_id}">
                                <input type="hidden" name="hdn_item_name[]" value="${item.item_name}">
                                <input type="hidden" name="hdn_item_type[]" value="${item.item_type}">
                                <input type="hidden" name="item_delivery_status[]" class="item_delivery_status"
                                    value="">
                                <input type="hidden" name="delivery_date[]" value="">
                                <input type="hidden" name="hdn_item_qnty[]" value="1">
                                <input type="hidden" id="hdn_item_edited_ind" name="hdn_item_edited_ind[]" value="0">
                                <input type="hidden" name="hdn_item_rate[]" class="hdn_item_rate"
                                    value="${item.item_rate}">
                                <input type="hidden" name="hdn_item_urgent_fee[]" class="hdn_item_urgent_fee" value="">
                                    <td class="text-center">${item.item_code}</td>
                                    <td class="text-left">${item.item_name}</td>
                                    <td class="text-left"></td>
                                    <td class="text-left">${item.item_dept}</td>
                                    <td class="text-left">
                                    <input type="text" class="provider form-control" id="provider_${provider_id_sl}" name="provider[]" >
                                        <input type="hidden" class="hdn_provider_no" id="hdn_provider_no" name="hdn_provider_no[]"  value="">
                                    </td>
                                    <td class="text-left">
                                    <select name='' class='form-control item_delivery_status' data-urgent_fee='${item.urgent_fee_amt}' onchange='calculateUrgentFee(this)' style='margin-bottom:0px!important' ><option value='1'>Routine</option> <option value='2'>Urgent</option> </select>
                                    </td>
                                    <td class="text-right"><input type="text" name="old_qty_[]" value="0" class=" old_qty w-100" readonly></td>
                                    <td class="text-right">
                                    <input type="text" class=" edit_qty number_only text-right w-100" id="edit_qty_${item.item_id}" name="edit_qty_[]" onkeyup="newQty(this)" value="1">
                                    <input type="hidden" class="" name="edit_ind[]" value="0" >
                                    </td>
                                    <td class="text-left" class="item_rate" style='font-weight: bold'>
                                    ${item.item_rate}</td>
                                    <td class="text-left"></td>
                                    <td class="text-center"></td>
                                    <td class="text-right"><input type="hidden" name="cancel_checkbox[]" id="cancel_checkbox_${item.item_id}" class=" cancel_checkbox text-right" disabled="disabled" value="0"></td>
                                    <td class="text-right"></td>
                                    <td class="text-right">  </td>
                                    <td class="text-right">
                                    <input type="text" class="number_only item_dis_amt" name="item_dis_amt[]" value="0" onkeyup="newQty(this)">
                                    </td>
                                    <td><span class="btn btn-sm btn-danger" data-id="" onclick="removeTableRowOnly(this)" data-url="" title="Cancel this appointment"><i class="fas fa-times"></i></span></td>
                                </tr>`
        console.log(add, $('.item_list tr').length)
        if ($('.item_list tr').length >= 1 && add == 0) {
            $('.item_list tr:last').after(add_item);
            openDoctorAutocompleteV1('#provider_' + provider_id_sl, '.hdn_provider_no');
        }
        newQty($('edit_qty_'+item.item_id))

        $.ajax({
            data: {
                item_id: item.item_id,
                ccm_client_no_pk: item.ccm_client_no_pk,
                patient_type: item.patient_type_code
            },
            url: "{{ route('get-auto-items-list') }}",
            type: "post",
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                console.log(data)
                var total_auto = 0;
                $.each(data, function(key, value) {
                    var ipd_charge = value.ipd_charge;
                    var auto_item_sl = $(".item_list tr").length + 1;
                    if (value.itemtype_code == 'LAB' || value.itemtype_code == 'RAD') {
                        var table_row_auto =
                            ` <tr>
                                <input type="hidden" class="invoice_dtl_no" name="hdn_invoice_dtl_no[]" value="">
                                <input type='hidden' class='w-100 mb-0 text-right form-control ipd_charge_amt' id='' name='ipd_charge[]' value='${ipd_charge}' readonly />
                                <input type="hidden" class="item_id" name="hdn_item_id[]" value="${ value.auto_item_no_fk}">
                                <input type="hidden" name="hdn_item_name[]" value="${value.item_name}">
                                <input type="hidden" name="hdn_item_type[]" value="${value.item_type}">
                                <input type="hidden" name="item_delivery_status[]" class="item_delivery_status"
                                    value="">
                                <input type="hidden" name="delivery_date[]" value="">
                                <input type="hidden" name="hdn_item_qnty[]" value="1">
                                <input type="hidden" id="hdn_item_edited_ind" name="hdn_item_edited_ind[]" value="0">
                                <input type="hidden" name="hdn_item_rate[]" class="hdn_item_rate"
                                    value="${value.sales_price}">
                                <input type="hidden" name="hdn_item_urgent_fee[]" class="hdn_item_urgent_fee" value="">
                                    <td class="text-center">${value.item_code}</td>
                                    <td class="text-left">${value.item_name}</td>
                                    <td class="text-left"></td>
                                    <td class="text-left">${value.serviceunit_name}</td>
                                    <td class="text-left">
                                    <input type="text" class="provider form-control" id="provider_${auto_item_sl}" name="provider[]" >
                                        <input type="hidden" class="hdn_provider_no" id="hdn_provider_no" name="hdn_provider_no[]"  value="">
                                    </td>
                                    <td class="text-left">
                                    <select name='' class='form-control item_delivery_status' data-urgent_fee='${value.urgent_fee_amt}' onchange='calculateUrgentFee(this)' style='margin-bottom:0px!important' ><option value='1'>Routine</option> <option value='2'>Urgent</option> </select>
                                    </td>
                                    <td class="text-right"><input type="text" name="old_qty_[]" value="0" class=" old_qty w-100" readonly></td>
                                    <td class="text-right">
                                    <input type="text" class=" edit_qty number_only text-right w-100" id="edit_qty_${value.auto_item_no_fk}" name="edit_qty_[]" onkeyup="newQty(this)"  value="1">
                                    <input type="hidden" class="" name="edit_ind[]" value="0" >
                                    </td>
                                    <td class="text-left" class="item_rate" style='font-weight: bold'>
                                    ${value.sales_price}</td>
                                    <td class="text-left"></td>
                                    <td class="text-center"></td>
                                    <td class="text-right"><input type="hidden" name="cancel_checkbox[]" id="cancel_checkbox_${ value.auto_item_no_fk}" class=" cancel_checkbox text-right" disabled="disabled" value="0"></td>
                                    <td class="text-right"></td>
                                    <td class="text-right">  </td>
                                    <td class="text-right">
                                    <input type="text" class="number_only item_dis_amt" name="item_dis_amt[]" value="0" onkeyup="newQty(this)">
                                    </td>
                                    <td><span class="btn btn-sm btn-danger" data-id="" onclick="removeTableRowOnly(this)" data-url="" title="Cancel this appointment"><i class="fas fa-times"></i></span></td>
                                </tr>`;

                    } else {
                        var table_row_auto =
                            `   <tr>
                                <input type="hidden" class="invoice_dtl_no" name="hdn_invoice_dtl_no[]" value="">
                                <input type='hidden' class='w-100 mb-0 text-right form-control ipd_charge_amt' id='' name='ipd_charge[]' value='${ipd_charge}' readonly />
                                <input type="hidden" class="item_id" name="hdn_item_id[]" value="${ value.auto_item_no_fk}">
                                <input type="hidden" name="hdn_item_name[]" value="${value.item_name}">
                                <input type="hidden" name="hdn_item_type[]" value="${value.item_type}">
                                <input type="hidden" name="item_delivery_status[]" class="item_delivery_status"
                                    value="">
                                <input type="hidden" name="delivery_date[]" value="">
                                <input type="hidden" name="hdn_item_qnty[]" value="1">
                                <input type="hidden" id="hdn_item_edited_ind" name="hdn_item_edited_ind[]" value="0">
                                <input type="hidden" name="hdn_item_rate[]" class="hdn_item_rate"
                                    value="${value.sales_price}">
                                <input type="hidden" name="hdn_item_urgent_fee[]" class="hdn_item_urgent_fee" value="">
                                    <td class="text-center">${value.item_code}</td>
                                    <td class="text-left">${value.item_name}</td>
                                    <td class="text-left"></td>
                                    <td class="text-left">${value.serviceunit_name}</td>
                                    <td class="text-left">
                                    <input type="text" class="provider form-control" id="provider_${auto_item_sl}" name="provider[]" >
                                        <input type="hidden" class="hdn_provider_no" id="hdn_provider_no" name="hdn_provider_no[]"  value="">
                                    </td>
                                    <td class="text-left">
                                    <select name='' class='form-control item_delivery_status' data-urgent_fee='${value.urgent_fee_amt}' onchange='calculateUrgentFee(this)' style='margin-bottom:0px!important' ><option value='1'>Routine</option> <option value='2'>Urgent</option> </select>
                                    </td>
                                    <td class="text-right"><input type="text" name="old_qty_[]" value="0" class=" old_qty w-100" readonly></td>
                                    <td class="text-right">
                                    <input type="text" class=" edit_qty number_only text-right w-100" id="edit_qty_${value.auto_item_no_fk}" name="edit_qty_[]" onkeyup="newQty(this)" value="1">
                                    <input type="hidden" class="" name="edit_ind[]" value="0" >
                                    </td>
                                    <td class="text-left" class="item_rate" style='font-weight: bold'>
                                    ${value.sales_price}</td>
                                    <td class="text-left"></td>
                                    <td class="text-center"></td>
                                    <td class="text-right"><input type="hidden" name="cancel_checkbox[]" id="cancel_checkbox_${ value.auto_item_no_fk}" class=" cancel_checkbox text-right" disabled="disabled" value="0"></td>
                                    <td class="text-right"></td>
                                    <td class="text-right">  </td>
                                    <td class="text-right">
                                    <input type="text" class="number_only item_dis_amt" name="item_dis_amt[]" value="0" onkeyup="newQty(this)">
                                    </td>
                                    <td><span class="btn btn-sm btn-danger" data-id="" onclick="removeTableRowOnly(this)" data-url="" title="Cancel this appointment"><i class="fas fa-times"></i></span></td>
                                </tr>`;
                    };
                    $("#item_list tr").each(function() {
                        var items_id_auto = $(this).children('td').find('.item_id').val();

                        if (value.auto_item_no_fk == items_id_auto) {
                            // alert("This item is already selected");
                            table_row_auto = '';
                            return;
                        }
                    })

                    if ($(".item_list tr").length >= 1) {

                        $('.item_list tr:last').after(table_row_auto);
                        openDoctorAutocompleteV1('#provider_' + auto_item_sl, '.hdn_provider_no');

                    } else {
                        $(".item_list").html(table_row_auto);
                        openDoctorAutocompleteV1('#provider_' + auto_item_sl, '.hdn_provider_no');
                    }

                    newQty($('edit_qty_'+value.item_id))
                });

            },
            complete: function(data) {

                // openDoctorAutocompleteV1('.provider', '.hdn_provider_no');

                $.unblockUI();
                $('#item_code').typeahead('val', '');

                $('.date_picker').datepicker({
                    format: 'dd-mm-yyyy',
                    autoclose: true,
                    todayHighlight: true,
                    clearBtn: true
                });

            }

        });


    }

    function removeTableRowOnly(element) {
        if (confirm('Are you sure?')) {
            $(element).parents('td').parents('tr').remove();
            newQty(element);
        }


    }


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



        var tfoot =
            "<tr><td  class='text-left'  >Total:</td> <td > <input type='text' name='total_payment_amt' id='total_payment_amt' class='text-right' style='border: 0;width: 80px;' readonly='readonly'></td><td colspan='6'></td></tr>"

        $("#tfoot").html(tfoot);
        var amt = 0;
        if ($(element).attr('id') == 'cash_add') {
            var amount = $(element).parents('div').find("#cash_amount").val();
            var method_mode = 'CASH';
            var bank_name = "";
            var b_type = "";
            var trans_id = "";
            var card_no = "";
            var acc_holder_name = "";
        }

        if ($(element).attr('id') == 'bkash_add') {

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

        if ($(element).attr('id') == 'check_add') {
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

        if ($(element).attr('id') == 'card_add') {
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

        var table_row = "<tr><td ><input class='' type='text' name='pay_method_mode[]' value='" + method_mode +
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
        // var pay_paid_due = parseFloat(net_payable) - (parseFloat(total_payment) + parseFloat(paid_diff) + parseFloat(
        //     discounted_amount) + parseFloat(dis_diff));
        console.log(net_payable, total_payment, paid_diff, discounted_amount, dis_diff, pay_paid_due)


        if ($("#tbody tr").length >= 1 && parseFloat(amount) > 0 && parseFloat(amount) <= parseFloat(pay_paid_due)) {


            $("#tbody").append(table_row);
            $('#cash').children().find(':input').val("");
            $('#payment_method_bkash').children().find(':input').val("");
            $('#payment_method_card').children().find(':input').val("");
            $('#payment_method_cheque').children().find(':input').val("");
            $('#cash_bd_amount').val("");
        } else {
            if (parseFloat(amount) > 0 && parseFloat(amount) <= parseFloat(pay_paid_due)) {

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
        var cash_refund = $('#cash_refund').val();
        var total_due = parseFloat(due_payment) - pay_amount - (parseFloat(discount_amt) + parseFloat(
            discount_amt_doc));

        if (total_due < 0) {
            $("#total_refund").val((Math.abs(total_due) - cash_refund));
        }
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
            $("#discount_amt").val("");
            $("#discount_percent").val("");
            $("#total_discount").val("");
            $("#discount_percent_doctors").val("");
            $("#discount_percent_doctors").val("");
            $("#discount_percent_doctors").val("");
            alert("Discount invalid");
            calCulateDiscountHospital(value);
        } else {
            if (due_payment < 0) {
                $("#total_refund").val(Math.abs(due_payment) - cash_refund);
            }

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
            $("#discount_amt").val("");
            $("#discount_percent").val("");
            $("#total_discount").val("");
            $("#discount_percent_doctors").val("");
            $("#discount_percent_doctors").val("");
            $("#discount_percent_doctors").val("");
            alert("Discount invalid");
            calCulateDiscountDoctor(value);
        } else {
            console.log(due_payment);
            if (due_payment < 0) {
                $("#total_refund").val(Math.abs(due_payment) - cash_refund);
            }
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
        // var discount_percent = $("#discount_percent").val();
        // var discount_amt = ($("#discount_amt").val() != "") ? $("#discount_amt").val() : 0 ;
        // var discount_amt_doc = ($("#discount_amt_doctor").val() != "") ? $("#discount_amt_doctor").val() : 0 ;
        // var due_payment_cal =( $("#total_amt_dis").val() != "") ?  $("#total_amt_dis").val() : 0;
        // var due_payments = ($("#due_payment").val() !="") ? $("#due_payment").val()  : 0;
        // var cash_refund = ($("#cash_refund").val() !="") ? $("#cash_refund").val()  : 0;
        // var discounted_amount = ($("#discounted_amount").val() !="") ? $("#discounted_amount").val() : 0;
        // var initial_payment = ($("#initial_payment").val() !="") ? $("#initial_payment").val() : 0;
        // var pay_amt =($("#pay_amount").val() != "") ?$("#pay_amount").val() : 0 ;
        // var t = parseFloat(discount_amt) + parseFloat(pay_amt);
        // console.log(discount_amt);
        // var total_discount =0;
        // if(discount_amt != "" || discount_amt_doc !="" )
        // {
        // 	 total_discount =parseFloat(discount_amt) + parseFloat(discount_amt_doc) + parseFloat(discounted_amount);
        // }

        // $("#total_discount").val(total_discount.toFixed(2));

        // if(discount_amt != "" || discount_amt_doc !="")
        // {
        // 	 due_payment = ((parseFloat(due_payments) + parseFloat(cash_refund) ) - (parseFloat(discount_amt) + parseFloat(discount_amt_doc) + parseFloat(pay_amt))) ;
        // }





        // if (due_payment_cal < total_discount) {

        // 	$("#discount_amt").val("");
        // 	$("#discount_amt_doctor").val("");
        // 	$("#discount_percent").val("");
        // 	$("#total_discount").val("");
        // 	$("#total_due_con").html("");

        // 	alert("Discount invalid");

        // 	calCulatePayment(value);

        // 	// $("#total_due_con").val("");
        // }else{
        // 		console.log(discount_amt);
        // 	$("#total_due_con").html(Math.abs(due_payment.toFixed(2)));
        // 	if (due_payment >= 0 ) {
        // 		$("#final_due").html("");
        // 		$("#final_due").html("Final Due");
        // 	}else{
        // 		$("#final_due").html("");
        // 		$("#final_due").html("Refund");
        // 	}

        // }



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
            $("#discount_amt").val("");
            $("#discount_percent").val("");
            $("#total_discount").val("");
            $("#discount_percent_doctors").val("");
            $("#discount_amt_doctor").val("");
            $("#discount_amt").val("");
            alert("Discount invalid");
            calCulatePayment(value);


        } else {
            // if (due_payment < 0) {
            //     $("#total_refund").html(Math.abs(due_payment.toFixed(2)));
            // }
            $("#total_due_con").html(Math.abs(due_payment.toFixed(2)));
            if (due_payment >= 0) {
                $("#final_due").html(" ");
                $("#final_due").html("Final Due");
            } else {
                $("#final_due").html(" ");
                $("#final_due").html("Refund");
                $("#total_refund").val((Math.abs(due_payment) - cash_refund));
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

    function newQty(element) {
        var new_qty = $(element).val();
        var old_qty = 0;
        var cancel_qty = 0;
        var current_qty = 0;
        var item_rate = 0;
        var item_amt = 0;
        var edit_qty = 0;
        var item_dis = 0;
        $('.item_id').each(function() {
            var item_id = $(this).val();
            edit_qty = $(this).parents('tr').find(".edit_qty").val() != "" ? $(this).parents('tr').find(
                ".edit_qty").val() : 0;
            old_qty = $(this).parents('tr').find(".old_qty").val();
            cancel_qty = $(this).parents('tr').find(".cancel_checkbox").val();
            current_qty = edit_qty != 0 ? edit_qty : old_qty - cancel_qty;
            item_rate = $(this).parents('tr').find(".hdn_item_rate").val();
            item_dis += $(this).parents('tr').find(".item_dis_amt").val() != "" ? parseFloat($(this).parents(
                'tr').find(".item_dis_amt").val()) * current_qty : 0;
            item_amt += item_rate * current_qty;

            if (old_qty != null && edit_qty != "") {
                $(this).parents('tr').find(".edit_ind").val(1);
            } else {
                $(this).parents('tr').find(".edit_ind").val(0);
            }

            console.log(item_id, edit_qty, old_qty, cancel_qty, current_qty, item_dis, item_rate, item_amt +
                "_old_qty");
        });
        $('#net_payable').html(item_amt);
        $('#total_amt_dis').val(item_amt);
        $('#discounted_amount').val(item_dis.toFixed(2));
        // calCulateDiscount(this);
        // calCulatePayment(this);
        editFincCal();

    }

    function editFincCal() {
        var item_amt = parseFloat($('#total_amt_dis').val());
        var urgent_fee = parseFloat($('#urgent_fee').val());
        var invoice_total = (item_amt + urgent_fee).toFixed(2);
        var discounted_amt = parseFloat($('#discounted_amount').val());
        var paid_amt = parseFloat($('#initial_payment').val());
        var due_amt = (invoice_total - (paid_amt + discounted_amt)).toFixed(2);
        $('#paid_amount').val(invoice_total);
        console.log("A", due_amt);
        if (due_amt < 0) {
            $('#span_due_txt').html("Refund Amount")
        } else {
            $('#span_due_txt').html("Due Amount")

        }
        $('#due_payment_hdn').val(due_amt);
        $('#due_payment').val(Math.abs(due_amt));


    }

    function calculateUrgentFee(element) {
        var urgent_fee = $(element).attr('data-urgent_fee');
        var this_value = $(element).find(":selected").val();
        if (this_value == 2) {
            $(element).parents('td').parents('tr').find('.hdn_item_urgent_fee').val(urgent_fee);
            $(element).parents('td').parents('tr').find('.item_delivery_status').val(2);
        } else {
            $(element).parents('td').parents('tr').find('.hdn_item_urgent_fee').val(0);
            $(element).parents('td').parents('tr').find('.item_delivery_status').val(0);
        }
        var total_urgent_fee = 0;
        $('.hdn_item_urgent_fee').each(function() {
            total_urgent_fee += $(this).val() != "" ? parseFloat($(this).val()) : 0;
        })

        $('#urgent_fee').val(total_urgent_fee.toFixed(2));
        editFincCal();
        console.log(urgent_fee, this_value, total_urgent_fee);
        // hdn_item_urgent_fee
    }

    function invoiceItemDelete(element) {
        var voucher_no = $("#hdn_invoice_id").val();
        var item_id = $(element).attr('data-item');
        if (confirm('Are you sure ?')) {
            $(element).parents('td').parents('tr').remove();
            newQty(element);
            var due_payment = $("#due_payment_hdn").val();
            if (due_payment >= 0) {
                due_payment = 0;
            }
            due_payment = Math.abs(due_payment);
            $.ajax({
                async: true,
                data: {
                    voucher_no: voucher_no,
                    item_id: item_id,
                    due_payment: due_payment,
                },
                url: "{{ route('billing.delete-item-invoice') }}",
                type: "post",
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {
                    //var response_url= "{{ route('billing.billing-cancelation-edit') }}";
                    $('.common-modal-notify').modal('show');
                    $('.common-modal-notify .modal-body').html(
                        "<i class='fas fa-stroopwafel fa-spin'></i>");
                    $('.common-modal-notify .modal-title').html(data.title);
                    $('.common-modal-notify .modal-body').html(data.msg);
                    // dynamicFunc.afterSaveLoadPage(response_url);

                },
                complete: function() {

                },
                error: function(data) {
                    var errors = jQuery.parseJSON(data.responseText).errors;
                    error_messages = "";
                    for (messages in errors) {
                        var field_name = $("#" + messages).siblings("label").html();
                        error_messages += "<div class='alert alert-danger' role='alert'>" + errors[
                            messages] + "</div>";
                    }

                    $('.common-modal-notify-error').modal('show');
                    $('.common-modal-notify-error .modal-title').html(data.title);
                    $('.common-modal-notify-error .modal-body').html(data.msg);

                    $.unblockUI();
                }
            }).done(function() {
                $.unblockUI();
            });
        }

    }
</script>
