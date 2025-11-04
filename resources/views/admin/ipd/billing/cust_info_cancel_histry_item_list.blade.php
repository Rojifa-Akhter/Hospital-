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
                                <th class="text-center">Pharmacy Net Bill</th>
                                <th class="text-right">Pharmacy Net Paid</th>
                                <th class="text-right">Pharmacy Net Due</th>

                            </tr>
                        </thead>
                        <tbody class="item_list">
                            @if (!empty($invoice_pay_dis_his))
                                @foreach ($invoice_pay_dis_his as $value)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="text-right">
                                            {{ isset($value->net_sales) ? $value->net_sales : '0' }}
                                        </td>
                                        <td class="text-right">
                                            {{ isset($value->collection) ? $value->collection : '0' }}
                                        </td>
                                        <td class="text-right">
                                            {{ isset($value->due) ? $value->due : '0' }}</td>

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


                            <th class="text-right"> Total Qty</th>
                            <th class="text-right"> Cancelled Qty</th>
                            <th class="text-right"> Net Qty</th>
                            <th class="text-right"></th>
                            <th class="text-right">Return Qty</th>

                            <th class="text-right">Return Reason</th>


                        </tr>
                    </tbody>
                    <tbody class="item_list">

                        @if (!empty($invoice_item_list))
                            @foreach ($invoice_item_list as $item)
                                {{-- <input type="hidden" name="hdn_item_id[]" value="{{ $item->item_no_fk }}">
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
                                <input type="hidden" name="hdn_invoice_no_fk" value="{{ $item->invoice_no_fk }}"> --}}


                                <tr>
                                    <td class="text-center">{{ $item->item_code }}</td>
                                    <td class="text-left">{{ $item->item_name }}</td>
                                    <td class="text-left">{{ $item->item_type_name }}</td>
                                    <td class="text-right">{{ $item->item_qty }}</td>
                                    <td class="text-right">{{ $item->cancel_qty }}</td>
                                    <td class="text-right">{{ $item->item_qty - $item->cancel_qty }}</td>
                                    <td class="text-right"><input type="checkbox"
                                            data-qty="{{ $item->item_qty - $item->cancel_qty }}"
                                            onclick="removeDisable(this)" name="return_item[]"
                                            value="{{ $item->item_no_fk }}"></td>
                                    <td class="text-right"><input type="text"
                                            name="return_qty_{{ $item->item_no_fk }}" class="text-right return_qty"
                                            value="" disabled></td>
                                    <td class="text-center"><input type="text"
                                            name="return_reason_{{ $item->item_no_fk }}"></td>

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
<div class="form-row justify-content-center">

    <div class="col-md-3">
        <div class="card shadow-sm mt-1" id="amount_info">
            <div class="card-body p-1">
                <div class="right_side">
                    <div class="form-row">


                        <div class="col-md-12 text-center">
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

                                $response_url_inv = route('ipd.phr-bill-cancel');
                                // dd( $response_url_inv);
                                $response_url = $response_url_inv;
                            @endphp
                            <input type="hidden" name="hdn_addmission_id" value="{{ $addmission_no }}"
                                readonly="readonly">
                            <input type="hidden" name="admission_no_pk" value="{{ $addmission_no }}">
                            <!-- <div class="btn btn-md btn-info">Save&nbsp;&&nbsp;Print</div> -->
                            <button type="button" class="btn btn-md btn-success"
                                data-response_action="{{ $response_url }}"
                                onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_url }}')">Save</button>

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

    function removeDisable(element) {
        if ($(element).is(":checked")) {
            $(element).parents('td').parents('tr').find('.return_qty').prop('disabled', false);
            $(element).parents('td').parents('tr').find('.return_qty').val($(element).attr('data-qty'));
        } else {
            $(element).parents('td').parents('tr').find('.return_qty').prop('disabled', true);
            $(element).parents('td').parents('tr').find('.return_qty').val(0);
        }
    }

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
                        disvalsum += dis_rate != "" ? (dis_rate / curQty) * $(this).val() : 0;
                        console.log($(this).val() + '_try_bellal_' + dis_rate);
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
                disvalsum = Math.round(disvalsum);
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
                    disvalsum += dis_rate != "" ? (dis_rate / $(this).attr('data-current_qty')) * $(this)
                        .val() : 0;
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
            disvalsum = Math.round(disvalsum);
            net_pay += disvalsum;
            due_refund += disvalsum;
            refund += (due_refund);
            console.log(refund, due_refund, disvalsum + '_bellal_');
            // alert(parseFloat(argentfee) );


            $("#cancel_item_amount").val(cqtyvalsum.toFixed(2));
            $("#cancel_vat").val(cancelVatAmt.toFixed(2));
            $("#cancel_discounted_amount").val(disvalsum.toFixed(2));
            // $("#urgent_fee").val(argentfee);
            $("#cencel_net_amount").val((parseFloat(cqtyvalsum + cancelVatAmt) - parseFloat(disvalsum)).toFixed(2));
            $("#discounted_amount").val((discounted - disvalsum).toFixed(2));
            console.log(net_payable, "ANik", (parseFloat(cqtyvalsum + cancelVatAmt) - parseFloat(disvalsum)));
            // $("#net_payable_amt").val((net_payable - (cqtyvalsum +  (discounted - disvalsum))).toFixed(2)); - parseFloat(disvalsum)
            $("#net_payable_amt").val(((net_payable - (discounted - disvalsum)) - (parseFloat(cqtyvalsum +
                cancelVatAmt))).toFixed(2));
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
                    disvalsum += dis_rate != "" ? (dis_rate / $(this).attr('data-current_qty')) * $(this)
                        .val() : 0;
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
            disvalsum = Math.round(disvalsum);
            net_pay += disvalsum;
            due_refund += disvalsum;
            // alert(parseFloat(argentfee) );
            refund = parseFloat($('#refund_amount_hdn').val());
            if (cqtyvalsum > 0) {
                refund += (due_refund);
            } else {
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
            $("#net_payable_amt").val(((net_payable - (discounted - disvalsum)) - (parseFloat(cqtyvalsum +
                cancelVatAmt))).toFixed(2));
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
