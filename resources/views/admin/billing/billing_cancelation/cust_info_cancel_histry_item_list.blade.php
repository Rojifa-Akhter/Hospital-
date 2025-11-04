<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

<div class="form-row">
    @include('admin.billing.due_collection.patient_info')
    <div class="col-md-7">
        <div class="privious-history">
            <div class="card shadow-sm mt-1">
                <div class="card-header">
                    <h5>Invoice Payment & Discount History</h5>
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
                                        <td class="text-center">{{ date('d/m/Y', strtotime($value->invoice_date)) }}
                                        </td>
                                        <td class="text-right">
                                            {{ isset($value->ledger_amt_payment) ? $value->ledger_amt_payment : '0' }}
                                        </td>
                                        <td class="text-right">{{ isset($value->ledger_amt_discount) ? $dis : '0' }}
                                        </td>
                                        <td class="text-left">
                                            {{ isset($value->ledger_entry_txt) ? $value->ledger_entry_txt : '' }}</td>
                                        <td class="text-left">
                                            {{ $value->pay_mode == '0' ? ' ' : $value->pay_mode }}</td>

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
                    <tbody>
                        <tr class="bg-primary">
                            <th class="text-center">Item ID</th>
                            <th class="text-left">Item Name</th>
                            <th class="text-left">Item Type</th>
                            <th class="text-left">Department</th>
                            <th class="text-left">Del. Stat.</th>
                            <th class="text-right">Rate</th>
                            <th class="text-left">Inv. Status</th>
                            <th class="text-right"> Invoice Qty</th>
                            <th class="text-right"> C Qty</th>
                            <th class="text-center"></th>
                            <!-- <input type="checkbox" name="" value=""> -->
                            <th class="text-right">Cancel Qty</th>
                            <th class="">Cancel Reason</th>
                            <th class="text-center">Report Delivery</th>
                            <th class="text-right">Disc. (%)</th>
                            <th class="text-right">Disc. Amt</th>
                        </tr>
                    </tbody>
                    <tbody class="item_list">

                        @if (!empty($invoice_item_list))
                            @foreach ($invoice_item_list as $item)
                            
                                <input type="hidden" name="hdn_item_id[]" value="{{ $item->item_no_fk }}">
                                <input type="hidden" name="hdn_item_name[]" value="{{ $item->item_name }}">
                                <input type="hidden" name="hdn_item_type[]" value="{{ $item->itemtype_no_fk }}">
                                <input type="hidden" name="item_delivery_status[]"
                                    value="{{ $item->delivery_status_lookup_no_fk }}">
                                <input type="hidden" name="delivery_date[]" value="{{ $item->report_delivery_date }}">
                                <input type="hidden" id="hdn_item_qnty_{{ $item->invoicedtl_no_pk }}"
                                    name="hdn_item_qnty[]" value="{{ $item->item_qty }}">
                                <input type="hidden" id="hdn_canel_item_qnty_{{ $item->invoicedtl_no_pk }}"
                                    name="hdn_cencel_item_qnty[]" value="{{ $item->cancel_qty }}">
                                <input type="hidden" name="hdn_item_rate[]" class="total_cancel"
                                    id="total_cancel_{{ $item->invoicedtl_no_pk }}" value="">
                                <input type="hidden" name="hdn_item_vat[]" class="hdn_item_vat"
                                    id="hdn_item_vat_{{ $item->invoicedtl_no_pk }}" value="{{ $item->item_vat }}">
                                <input type="hidden" name="hdn_item_urgent_fee[]" value="{{ $item->urgent_fee }}">
                                <input type="hidden" name="hdn_invoice_no_fk" value="{{ $item->invoice_no_fk }}">


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

                                    <td class="text-left" class="item_rate" style='font-weight: bold'>
                                        {{ $item->item_rate }}</td>

                                    <td class="text-left">{{ $item->investigation_status }}</td>
                                    <td class="text-right">{{ $item->item_qty }}</td>
                                    <td class="text-right cancel_qty">{{ $item->cancel_qty }}</td>
                                    <td class="text-center"><input type="checkbox" onclick="cancel_box(this)"
                                            name="cancel_ind[]" value="{{ $item->item_no_fk }}"
                                            id="cancel_ind_{{ $item->invoicedtl_no_pk }}"
                                            data-invoice-id="{{ $item->invoicedtl_no_pk }}"
                                            data-item-qty="{{ $item->current_item_qty }}"
                                            data-sampCollectInd="{{ $item->item_type =="LAB" ?  $item->sc_sample_coll_key_ind : $item->rad_capture_or_finalize_ind}}"
                                            @if ($item->item_qty == $item->cancel_qty) disabled @endif></td>
                                    <td class="text-right"> <input type="text" name="cancel_checkbox[]"
                                            data-invoice-id="{{ $item->invoicedtl_no_pk }}"
                                            data-vat="{{ $item->item_vat }}" data-rateval="{{ $item->item_rate }}"
                                            data-dis="{{ $item->disc_amount  }}" data-fee="{{ $item->urgent_fee }}" data-current_qty={{$item->current_item_qty}}
                                            onkeyup="cancel_qty(this)" value=""
                                            id="cancel_checkbox_{{ $item->invoicedtl_no_pk }}"
                                            class="text-right number_only" disabled=""></td>

                                    <td class="text-right"> <input type="text" name="" id=""
                                            class="">
                                    </td>
                                    <td class="text-right">
                                        @if (date('d/m/Y', strtotime($item->report_delivery_date)) == '01/01/1970')
                                        @else
                                            {{ date('d/m/Y', strtotime($item->report_delivery_date)) }}
                                        @endif
                                    </td>
                                    <td class="text-right"> {{ $item->disc_perc }} </td>
                                    <td class="text-right">
                                        {{ number_format((float) $item->disc_amount , 2, '.', '') }} </td>
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

    <div class="col-md-2">
        <div class="card">
            <div class="card-body">
                <h2> Cashier Name</h2>
             
                    <input type="text" class="form-control" name="doctor_code" id="doctor_code" placeholder="Enter cashir name">
             <input type="hidden" name="hdn_doctor_id" id="hdn_doctor_id" value="">

            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h2> Cancel Reason</h2>
                <textarea class="form-control" name="cancel_reason" id="cancel_reason" cols="30" rows="3"></textarea>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm mt-1" id="amount_info">
            <div class="card-body p-1">
                <div class="right_side">
                    <div class="form-row">
                        <div class="col-md-12">
                            <ul class="list-group list-group-flush bg-light-blue rounded mb-2 border">
                                <li class="list-group-item d-flex align-items-center justify-content-between">
                                    @php

                                        $urgent_fee = isset($finc_inv_sum_amount->urgent_fee) ? $finc_inv_sum_amount->urgent_fee : 0;
                                        $sales = isset($finc_inv_sum_amount->ledger_amt_sales) ? $finc_inv_sum_amount->ledger_amt_sales : 0;
                                        $total_amount = $sales;

                                    @endphp
                                    <h5 class="float-left mr-2 mb-0">Total Item Amount</h5>
                                    <input type="hidden" name="apidiscount_type" id="apidiscount_type" value="{{isset($apiDiscount_ind) ? $apiDiscount_ind->apidiscount_type :''}}">
                                    <span class="float-right btn btn-outline-success bg-none btn-md"
                                        id="total_item_amount"
                                        data-totalamt="{{ $total_amount }}">{{ $total_amount }}</span>
                                </li>
                                <li class="list-group-item d-flex align-items-center justify-content-end">
                                    <span class="mr-2">Cancel Item Amount</span>
                                    <div class="">
                                        <input type="text" id="cancel_item_amount"
                                            class="form-control number_only" style="width: 70px; text-align: right;" readonly
                                             placeholder="00.00">
                                    </div>
                                </li>

                                <li class="list-group-item d-flex align-items-center justify-content-end">
                                    <span class="mr-2"> Cancel Dis. Amount</span>
                                    <div class="">
                                        <input type="text" id="cancel_discounted_amount" name="cancel_discounted_amount"
                                            class="form-control number_only" style="width: 70px; text-align: right;" readonly
                                             placeholder="00.00" value="">
                                    </div>
                                </li>
                                <li class="list-group-item d-flex align-items-center justify-content-end">
                                    <span class="mr-2">Cancel VAT. Amount</span>
                                    <div class="d-flex align-items-center">
                                        <input type="text" class="form-control number_only" id="cancel_vat"
                                            name="" placeholder="0.00" style="width:70px; text-align: right;" readonly
                                            >
                                    </div>
                                </li>
                                <li class="list-group-item d-flex align-items-center justify-content-end">
                                    <span class="mr-2">Cancel Urgent Fee</span>
                                    <div class="">
                                        <input type="text" class="form-control number_only" id="urgent_fee"
                                            name="urgent_fee" placeholder="00.00" disabled="disabled" readonly
                                            value="{{ isset($patient_info->urgent_fee) ? $patient_info->urgent_fee : '0' }}"
                                            style="width: 70px; text-align: right;">
                                    </div>
                                </li>


                                <li class="list-group-item d-flex align-items-center justify-content-end">
                                    <span class="mr-2">Cancel Net Amount</span>
                                    <div class="">
                                        <input type="text" id="cencel_net_amount" class="form-control number_only"
                                            style="width: 70px; text-align: right;"  readonly
                                            placeholder="00.00" name="cencel_net_amount">
                                    </div>
                                </li>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm mt-1" id="amount_info">
            <div class="card-body p-1">
                <div class="right_side">
                    <div class="form-row">
                        <div class="col-md-12">
                            <ul class="list-group list-group-flush bg-light-blue rounded mb-2 border">
                                <li class="list-group-item d-flex align-items-center justify-content-between">
                                    @php

                                        $total_amount = 0;
                                        $urgent_fee = isset($finc_inv_sum_amount->urgent_fee) ? $finc_inv_sum_amount->urgent_fee : '0';
                                        $sales = isset($finc_inv_sum_amount->ledger_amt_sales) ? $finc_inv_sum_amount->ledger_amt_sales : 0;
                                        $total_amount = $urgent_fee + $sales;
                                        $discount = isset($finc_inv_sum_amount->discount) ? $finc_inv_sum_amount->discount : 0;
                                        $total_refund = isset($finc_inv_sum_amount->refund) ? $finc_inv_sum_amount->refund : 0;

                                    @endphp
                                    <input type="hidden" value="{{ $discount }}" id="dis_amount_hdn">
                                    <input type="hidden" value="{{ $total_refund }}" id="refund_amount_hdn">
                                    <h5 class="float-left mr-2 mb-0">Current Item Amount</h5>
                                    <!-- <span class="float-right btn btn-outline-success bg-none btn-md" id="net_payable">{{ $total_amount }}</span> -->
                                </li>
                                <li class="list-group-item d-flex align-items-center justify-content-end">
                                    <span class="mr-2">Discounted Amt</span>
                                    <div class="">
                                        <input type="text" id="discounted_amount" class="form-control number_only"
                                            style="width: 70px; text-align: right;" maxlength="8" readonly
                                            placeholder="00.00" value="">
                                        <input type="hidden" id="total_item_amount_hdn" name=""
                                            data-distedamt="{{ isset($discount) ? $discount : '0' }}">
                                    </div>
                                </li>

                                <li class="list-group-item d-flex align-items-center justify-content-end">
                                    <span class="mr-2">Net Payable</span>
                                    <div class="">
                                        <input type="text" id="net_payable_amt" class="form-control number_only"
                                            style="width: 70px; text-align: right;" maxlength="8" readonly
                                            placeholder="00.00" value="">
                                    </div>
                                </li>



                                <li class="list-group-item d-flex align-items-center justify-content-end">
                                    <span class="mr-2">Paid Amount</span>
                                    <div class="">
                                        <input type="text" id="initial_payment" class="form-control number_only"
                                            style="width: 70px; text-align: right;" maxlength="8" readonly
                                            placeholder="00.00"
                                            value="{{ isset($finc_inv_sum_amount->net_collection) ? $finc_inv_sum_amount->net_collection : '0' }}">
                                    </div>
                                </li>

                                <li class="list-group-item d-flex align-items-center justify-content-end">
                                    <span class="mr-2">Due Amount</span>
                                    <div class="">
                                        <input type="text" id="cancel_due_payment"
                                            class="form-control number_only" style="width: 70px; text-align: right;"readonly
                                            maxlength="8" placeholder="00.00" value="">
                                    </div>
                                </li>

                                <li class="list-group-item d-flex align-items-center justify-content-end">
                                    <span class="mr-2">Cash Refund</span>
                                    <div class="">
                                        <input type="text" id="refund" name="refund" class="form-control number_only" readonly
                                            style="width: 70px; text-align: right;" maxlength="8"
                                            placeholder="00.00" value="">
                                    </div>
                                </li>
                                <li class="list-group-item d-flex align-items-center justify-content-end">
                                    <span class="mr-2">Total Refund</span>
                                    <div class="">
                                        <input type="text" id="cash_refund" class="form-control number_only"
                                            style="width: 70px; text-align: right;" maxlength="8" readonly
                                            placeholder="00.00" value="">
                                    </div>
                                </li>


                            </ul>
                        </div>

                        <div class="col-md-12 text-right">
                            @php
                               $invoice_id = '';
                                if (isset($patient_info)) {

                                    // $invoice_id = $patient_info->invoice_no_pk;
                                    $trx_id = '';
                                    $idm = '';
                                    $addmission_no = $patient_info->admission_no_pk;
                                } else {

                                    $trx_id = '';
                                    $idm = '';
                                    $addmission_no = '';
                                }

                                $response_url_inv = url('billing-cancelation-invoice');
                                // dd( $response_url_inv);
                                $response_url= $response_url_inv;
                            @endphp
                            <input type="hidden" name="hdn_patient_id"
                                value="{{ isset($patient_info->patient_no_pk) ? $patient_info->patient_no_pk : '' }}"
                                readonly="readonly">
                            <input type="hidden" name="admission_no_pk" value="{{ $addmission_no }}">
                            <!-- <div class="btn btn-md btn-info">Save&nbsp;&&nbsp;Print</div> -->
                            <button type="button" class="btn btn-md btn-success"
                                data-response_action="{{ $response_url }}"
                                onclick="billingEngine.createCancellation(this,resetDueBillForm)">Save&nbsp;&&nbsp;Show</button>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>

<script type="text/javascript">
    openDoctorAutocomplete('#doctor_code', 'hdn_doctor_id', 'employee_ind', '1');

    function resetDueBillForm() {
        $("#due_collection").find("input, textarea").not('.keep_me').val("");
        $("#due_collection").find("select").not('.keep_me').val("0");
        $("#net_payable").html("00.00");
        $("#total_due_con").html("00.00");
        $("#total_due_data").html("00.00");
        $("#item_total").html("00.00");
        $("#total_due_con").html("00.00");

        //$("#frmBilling").find("input").val('');
        //$("#frmBilling").find("select").val(0);
        $(" #tfoot, #tbody, #patient_info, #doctor_info, .item_list ").html('');
    }

    $(document).on("click", "#option", function() {
        var paymentType = $(this).val();
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
        } else if (paymentType == "bkash") {
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



    var cqty = [];
    var rqty = [];

    function cancel_qty(element) {
        var invoice = $(element).attr("data-invoice-id");
        if ($(element).val() + $('#hdn_canel_item_qnty_' + invoice).val() < $('#hdn_item_qnty_' + invoice).val()) {


            if ($("#cancel_ind_" + invoice).is(':checked')) {

                var cencel_q = $(element).val();
                var item_rate = $("#hdn_item_rate_" + invoice).val();
                var invoice_item_qty = $("#hdn_item_qnty_" + invoice).val();
                var total_cancel_amt = item_rate * cencel_q;
                $("#total_cancel_" + invoice).val(total_cancel_amt);
                $("#cancel_checkbox_" + invoice).removeAttr("disabled");

                var cqtyvalsum = 0;
                var disvalsum = 0;
                // var curQty = 0;
                var argentfee = 0;
                var cqtyrm = 0;
                var cancelVatAmt = 0;

                var discounted = 0;
                var net_payable = 0;
                var net_pay = 0;
                var paid_amount = 0;
                var due_refund = 0;
                $("input[name='cancel_checkbox[]']").each(function() {

                    var rate = $(this).data('rateval');
                    var dis_rate = $(this).data('dis');
                    var argent_fee = $(this).data('fee');
                    var cancel_vat_amt = $(this).data('vat');
                    var curQty = $(this).data('current_qty');
                    // alert(dis_rate);

                    if ($(this).val() != '') {
                        cqtyvalsum += rate * $(this).val();
                        disvalsum += dis_rate !="" ? (dis_rate / curQty ) * $(this).val()  : 0;
                        console.log( $(this).val()+'_try_bellal_'+dis_rate);
                        // disvalsum += $(this).val() * dis_rate;
                        argentfee += argent_fee * $(this).val();
                        cancelVatAmt += cancel_vat_amt * $(this).val();

                        discounted = $('#total_item_amount_hdn').data('distedamt');
                        // alert(discounted);
                        net_payable = $('#total_item_amount').data('totalamt') - cancelVatAmt;
                        net_pay = net_payable - ((cqtyvalsum + discounted) - disvalsum);
                        paid_amount = $('#initial_payment').val();
                        due_refund = net_pay - paid_amount;
                    }

                });
                disvalsum = Math.round( disvalsum);
                // alert(parseFloat(argentfee) );


                $("#cancel_item_amount").val(cqtyvalsum.toFixed(2));
                $("#cancel_vat").val(cancelVatAmt.toFixed(2));
                $("#cancel_discounted_amount").val(disvalsum.toFixed(2));
                // $("#urgent_fee").val(argentfee);
                $("#cencel_net_amount").val((parseFloat(cqtyvalsum + cancelVatAmt) - parseFloat(disvalsum)).toFixed(2));
                $("#discounted_amount").val((discounted - disvalsum).toFixed(2));
                $("#net_payable_amt").val((net_payable - (cqtyvalsum + (discounted - disvalsum))).toFixed(2));
                $('#cash_refund').val("");
                $('#cancel_due_payment').val("");
                if (due_refund <= 0) {

                    $('#cash_refund').val(Math.abs(due_refund.toFixed(2)));
                    $('#refund').val(Math.abs(due_refund.toFixed(2)));
                } else {

                    $('#cancel_due_payment').val(Math.abs(due_refund.toFixed(2)));
                }

            } else {

                $("#cancel_checkbox_" + invoice).val("");

            }

        } else {
            $('#cancel_ind_' + invoice).prop('checked', false);
            $('#cancel_checkbox_' + invoice).val("");
            $('#cancel_checkbox_' + invoice).attr('disabled', true);
            alert('Invalid Cancel quantity');
            // cancel_qty(element);



        }
    }



    function cancel_box(element) {
        var invoice = $(element).attr("data-invoice-id");
        var item_qty = $(element).attr("data-item-qty");
        if ($(element).is(':checked') && $(element).attr('data-sampCollectInd')==1) {
                alert('This item is already being processed for the report.');
                $(element).prop('checked',false);
                return false
            }
        if ($(element).is(':checked')) {
            
            $("#cancel_checkbox_" + invoice).val(item_qty);
            $("#cancel_checkbox_" + invoice).removeAttr("disabled");

            var cencel_q = $(element).val();
            var item_rate = $("#hdn_item_rate_" + invoice).val();
            var invoice_item_qty = $("#hdn_item_qnty_" + invoice).val();
            var total_cancel_amt = item_rate * cencel_q;
            $("#total_cancel_" + invoice).val(total_cancel_amt);
            $("#cancel_checkbox_" + invoice).removeAttr("disabled");

            var cqtyvalsum = 0;
            var disvalsum = 0;
            var argentfee = 0;
            var cqtyrm = 0;
            var cancelVatAmt = 0;
            var vatAmt = 0;


            var discounted = 0;
            var net_payable = 0;
            var net_pay = 0;
            var paid_amount = 0;
            var refund = 0;
            var due_refund = 0;
            $("input[name='cancel_checkbox[]']").each(function() {

                var rate = $(this).data('rateval');
                var dis_rate = $(this).data('dis');
                var argent_fee = $(this).data('fee');
                var cancel_vat_amt = $(this).data('vat');
                vatAmt += $(this).data('vat');
                // alert(dis_rate);

                if ($(this).val() != '') {
                    cqtyvalsum += rate * $(this).val();
                    disvalsum += dis_rate !="" ? (dis_rate / $(this).attr('data-current_qty') ) * $(this).val()  : 0;
                    argentfee += argent_fee * $(this).val();
                    cancelVatAmt += cancel_vat_amt * $(this).val();
                    discounted = $('#total_item_amount_hdn').data('distedamt');
                    // alert(discounted);
                    net_payable = parseFloat($('#total_item_amount').data('totalamt') - cancelVatAmt);
                    net_pay = net_payable - (cqtyvalsum + discounted);
                    paid_amount = $('#initial_payment').val();
                    due_refund = net_pay - paid_amount;
                }

            });
            // disvalsum = parseFloat($('#dis_amount_hdn').val());
            refund = parseFloat($('#refund_amount_hdn').val());
            disvalsum =  Math.round(disvalsum);
            net_pay += disvalsum;
            due_refund += disvalsum;
            refund += (due_refund );
            console.log(refund ,due_refund , disvalsum +'_bellal_');
            // alert(parseFloat(argentfee) );


            $("#cancel_item_amount").val(cqtyvalsum.toFixed(2));
            $("#cancel_vat").val(cancelVatAmt.toFixed(2));
            $("#cancel_discounted_amount").val(disvalsum.toFixed(2));
            // $("#urgent_fee").val(argentfee);
            $("#cencel_net_amount").val((parseFloat(cqtyvalsum + cancelVatAmt) - parseFloat(disvalsum)).toFixed(2));
            $("#discounted_amount").val((discounted - disvalsum).toFixed(2));
            console.log(net_payable,"ANik",(parseFloat(cqtyvalsum + cancelVatAmt) - parseFloat(disvalsum)));
            // $("#net_payable_amt").val((net_payable - (cqtyvalsum +  (discounted - disvalsum))).toFixed(2)); - parseFloat(disvalsum)
            $("#net_payable_amt").val(((net_payable - (discounted - disvalsum)) - (parseFloat(cqtyvalsum + cancelVatAmt))).toFixed(2));
            $('#cash_refund').val("");
            $('#refund').val("");
            $('#cancel_due_payment').val("");
            if (due_refund <= 0) {

                $('#cash_refund').val(Math.abs(due_refund.toFixed(2)));
                $('#refund').val(Math.abs(refund.toFixed(2)));
            } else {

                $('#cancel_due_payment').val(Math.abs(due_refund.toFixed(2)));
            }

        } else {
            // $("#cancel_checkbox_"+invoice).removeAttr("disabled");
            // $("#cancel_checkbox_"+invoice).val(item_qty);

            $("#cancel_checkbox_" + invoice).val("");
            $("#cancel_checkbox_" + invoice).attr("disabled", "");
            var cencel_q = $(element).val();
            var item_rate = $("#hdn_item_rate_" + invoice).val();
            var invoice_item_qty = $("#hdn_item_qnty_" + invoice).val();
            var total_cancel_amt = item_rate * cencel_q;
            $("#total_cancel_" + invoice).val(total_cancel_amt);
            // $("#cancel_checkbox_"+invoice).removeAttr("disabled");

            var cqtyvalsum = 0;
            var disvalsum = 0;
            var argentfee = 0;
            var cqtyrm = 0;
            var cancelVatAmt = 0;

            var discounted = 0;
            var net_payable = 0;
            var net_pay = 0;
            var paid_amount = 0;
            var due_refund = 0;
            $("input[name='cancel_checkbox[]']").each(function() {

                var rate = $(this).data('rateval');
                var dis_rate = $(this).data('dis');
                var argent_fee = $(this).data('fee');
                var cancel_vat_amt = $(this).data('vat');
                // alert(dis_rate);

                if ($(this).val() != '') {
                    cqtyvalsum += rate * $(this).val();
                    disvalsum += dis_rate !="" ? (dis_rate / $(this).attr('data-current_qty') ) * $(this).val()  : 0;
                    // disvalsum += dis_rate !="" ? Math.round((dis_rate / $(this).val() ) * $(this).val())  : 0;
                    // disvalsum += Math.round($(this).val() * dis_rate);
                    argentfee += argent_fee * $(this).val();
                    cancelVatAmt += cancel_vat_amt * $(this).val();
                    discounted = $('#total_item_amount_hdn').data('distedamt');
                    // alert(discounted);
                    net_payable = $('#total_item_amount').data('totalamt');
                    net_pay = net_payable - (cqtyvalsum + discounted);
                    paid_amount = $('#initial_payment').val();
                    due_refund = net_pay - paid_amount;
                }

            });
            // if (cqtyvalsum > 0) {
            //     disvalsum = parseFloat($('#dis_amount_hdn').val());
            // }
            disvalsum =  Math.round(disvalsum);
            net_pay += disvalsum;
            due_refund += disvalsum;
            // alert(parseFloat(argentfee) );
            refund = parseFloat($('#refund_amount_hdn').val());
            if (cqtyvalsum > 0) {
                refund += (due_refund);
            }else{
                refund = 0;
            }

            $("#cancel_item_amount").val(cqtyvalsum.toFixed(2));
            $("#cancel_vat").val(cancelVatAmt.toFixed(2));
            $("#cancel_discounted_amount").val(disvalsum.toFixed(2));

            // $("#urgent_fee").val(argentfee);
            $("#cencel_net_amount").val((parseFloat(cqtyvalsum + cancelVatAmt) - parseFloat(disvalsum)).toFixed(2));
            $("#discounted_amount").val((discounted - disvalsum).toFixed(2));
            // $("#net_payable_amt").val((net_payable - (cqtyvalsum + (discounted - disvalsum))).toFixed(2));
            // $("#net_payable_amt").val((net_payable - (parseFloat(cqtyvalsum + cancelVatAmt) - parseFloat(disvalsum))).toFixed(2));
            $("#net_payable_amt").val(((net_payable - (discounted - disvalsum)) - (parseFloat(cqtyvalsum + cancelVatAmt))).toFixed(2));
            $('#refund').val("");
            $('#cash_refund').val("");
            $('#cancel_due_payment').val("");
            if (due_refund <= 0) {

                $('#cash_refund').val(Math.abs(due_refund.toFixed(2)));
                $('#refund').val(Math.abs(refund.toFixed(2)));
            } else {

                $('#cancel_due_payment').val(Math.abs(due_refund.toFixed(2)));
            }
        }
    }
    // function calCulateDiscount(value){
    // 	var discount_percent = $("#discount_percent").val();
    // 	var discount_amt = $("#discount_amt").val();
    // 	var due_payment = $("#due_payment").val();
    // 	var discounted_amount = $("#discounted_amount").val();
    // 	var initial_payment = $("#initial_payment").val();



    // 	discount_percent= (due_payment*discount_percent)/100;
    // 	$("#discount_amt").val(discount_percent);
    // 	var total_discount = parseFloat(discount_percent) + parseFloat(discounted_amount) ;
    // 	$("#total_discount").val(total_discount);
    // 	due_payment = due_payment- discount_percent ;

    // 	var total_paid  =   parseFloat(due_payment)+ parseFloat(initial_payment);

    // 	$("#total_due_con").html(due_payment.toFixed(2));



    // }
    // function calCulatePayment(value){
    // 	if(value == ''){
    // 		value = 0;
    // 	}
    // 	var discount_amt = $("#discount_amt").val();
    // 	if (discount_amt == '') {
    // 		discount_amt=0;
    // 	}
    // 	var due_payment = $("#due_payment").val();
    // 	var paid = $("#initial_payment").val();
    // 	var total_paid = parseFloat(paid) + parseFloat(value);
    // 	$("#total_paid_amount").val(total_paid);
    // 	var total_due = parseFloat(due_payment) - parseFloat(discount_amt) -value;

    // 	$("#total_due_con").html(total_due);
    // }
    function calCulateGivenAmount(value) {
        var pay_amount = $("#pay_amount").val();
        var change_amount = value - pay_amount;

        if (change_amount > 0) {
            $("#change_amount").val(change_amount);
        }

    }
</script>
