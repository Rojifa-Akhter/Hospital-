<style>
    .paidAmt,
    .po_paid_amount,
    .po_amount,
    .deduct,
    .po_dis_amount,
    .po_uid,
    .po_payable_amount,
    .po_deduct_amount,
    .discout_amt {
        border-top-style: hidden;
        border-right-style: hidden;
        border-left-style: hidden;
        border-bottom-style: hidden;
    }

    .paidAmt:focus,
    .po_paid_amount:focus,
    .po_amount:focus,
    .deduct:focus,
    .po_dis_amount:focus,
    .po_uid:focus,
    .po_payable_amount:focus,
    .po_deduct_amount:focus,
    .discout_amt:focus {
        outline: none;
    }
</style>
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<section id="full_appointment">
    <form method="post" id="frmRefSearch" action="{{ route('supplier_payment_requ_po_store') }}" data-response-action="">
        @csrf
        <div class="container-fluid">
            <div class="row bg-white border-bottom sticky-top shadow-sm">
                <div class="col-md-12 mb-1">
                    <h5 class="mt-2 mb-0"> </h5>
                    <small>PCRP / Report / Supplier Payment Requisition</small>
                </div>
            </div>
            <div class="card mt-2" style="width: 100%; margin: auto">
                {{-- <div class="card-header ">
                <h5> Search</h5>
            </div> --}}

                <table>
                    <tr>
                        <td class="p-1">
                            <label for="hdn_supplier_name" class=" col-form-label col-form-label-sm ">Supplier Name
                                <span class="text-danger">*</span>
                        </td>
                        <td class="p-1">
                            <input type="hidden" name="hdn_supplier_id" class="hdn_supplier_id" id="hdn_supplier_id"
                                value="">
                            <input type="text" class="form-control form-control-sm " id="supplier_name"
                                name="supplier_name" value="" placeholder="Supplier name / code" required>

                        </td>
                        {{-- <td class="p-1">
                            <label for="payment_voucher" class=" col-form-label col-form-label-sm ">
                                Payment Voucher <span class="text-danger">*</span>
                            </label>
                        </td>
                        <td class="p-1">
                            <input type="text" class="form-control form-control-sm " readonly='readonly'
                                id="payment_voucher" name="payment_voucher" value="" placeholder="" required>
                        </td> --}}
                        <td class="p-1">
                            <label for="challan" class=" col-form-label col-form-label-sm ">Bill/Challan
                            </label>
                        </td>
                        <td class="p-1">
                            <input type="text" class="form-control form-control-sm " id="challan" name="challan"
                                value="" placeholder="">
                        </td>
                        <td class="p-1">
                            <label for="challan_date" class=" col-form-label col-form-label-sm ">Bill/Challan Date
                            </label>
                        </td>
                        <td class="p-1">
                            <input type="text" class="form-control form-control-sm date_picker" id="challan_date"
                                name="challan_date" value="" autocomplete="off" placeholder="DD-MM-YYYY">
                        </td>

                    </tr>
                    <tr>

                        <td class="p-1">
                            <label for="total_po_amount" class=" col-form-label col-form-label-sm po_amt_label">GRN Amount
                            </label>
                        </td>
                        <td class="p-1">
                            <input type="text" class="form-control form-control-sm text-right" readonly='readonly'
                                id="total_po_amount" name="total_po_amount" value="0" placeholder="">
                        </td>
                        <td class="p-1">
                            <label for="total_po_discount" class=" col-form-label col-form-label-sm po_amt_dis">GRN Discount
                            </label>
                        </td>
                        <td class="p-1">
                            <input type="text" class="form-control form-control-sm text-right" readonly='readonly'
                                id="total_po_discount" name="total_po_discount" value="0" placeholder="">
                        </td>
                        <td class="p-1">
                            <label for="net_po_paid" class=" col-form-label col-form-label-sm net_po_amt_label">Net GRN Amount
                            </label>
                        </td>
                        <td class="p-1">
                            <input type="text" class="form-control form-control-sm text-right" readonly='readonly'
                                id="net_po_paid" name="net_po_paid" value="0" placeholder="">
                        </td>
                        <td class="p-1">
                            <label for="total_po_paid" class=" col-form-label col-form-label-sm po_amt_paid_label">GRN Paid
                            </label>
                        </td>
                        <td class="p-1">
                            <input type="text" class="form-control form-control-sm text-right" readonly='readonly'
                                id="total_po_paid" name="total_po_paid" value="0" placeholder="">
                        </td>

                    </tr>
                    <tr>
                        <td class="p-1">
                            <label for="discount_amt" class=" col-form-label col-form-label-sm ">Discount Amount
                            </label>
                        </td>
                        <td class="p-1">
                            <span class="" id="">(Discount On PO Amt Percent)</span>
                            <input type="text" class="form-control form-control-sm number_only text-right"
                                id="discount_amt" name="discount_amt" value="0" placeholder=""
                                onkeyup="discountAmt()">
                        </td>
                        <td class="p-1">
                            <label for="net_total_po_amount" class=" col-form-label col-form-label-sm "> Payable
                                Amount
                            </label>
                        </td>
                        <td class="p-1">
                            <input type="text" class="form-control form-control-sm text-right" readonly='readonly'
                                id="net_total_po_amount" name="net_total_po_amount" value="0" placeholder="">
                        </td>
                        <td class="p-1">
                            <label for="total_diduct" class=" col-form-label col-form-label-sm ">Total Deduct
                            </label>
                        </td>
                        <td class="p-1">
                            <input type="text" class="form-control form-control-sm text-right" readonly='readonly'
                                id="total_diduct" name="total_diduct" value="0" placeholder="">
                        </td>
                        <td class="p-1">
                            <label for="total_paid" class=" col-form-label col-form-label-sm ">Total Paid
                            </label>
                        </td>
                        <td class="p-1">
                            <input type="text" class="form-control form-control-sm text-right" readonly='readonly'
                                id="total_paid" name="total_paid" value="0" placeholder="">
                        </td>

                    </tr>
                    <tr>
                        <td class="p-1">
                            <label for="total_due" class=" col-form-label col-form-label-sm ">Due
                            </label>
                        </td>
                        <td class="p-1">
                            <input type="text" class="form-control form-control-sm text-right" readonly='readonly'
                                id="total_due" name="total_due" value="0" placeholder="">
                        </td>

                        <td class="p-1">
                            <label for="payment_amt" class=" col-form-label col-form-label-sm ">Payment Amount
                            </label>
                        </td>
                        <td class="p-1">
                            <span class="text-danger" id="payment_invalid"></span>
                            <input type="text" class="form-control form-control-sm number_only text-right"
                                id="payment_amt" name="payment_amt" readonly='readonly' value=""
                                placeholder="" onkeyup="payment(this);">
                        </td>
                        <td class="p-1">
                            <label for="pay_mode" class=" col-form-label col-form-label-sm ">Mode
                            </label>
                        </td>
                        <td class="p-1">
                            <select class="form-control form-control-sm" name="pay_mode" id="pay_mode">

                                <option value="cash">Cash</option>
                                <option value="cheque">Cheque</option>
                            </select>
                        </td>

                        <td class="p-1" colspan="4">
                            <input type="radio" class="pay_type" id="regular_pay" name="pay_type" value="REGULAR"
                                placeholder="" checked="checked"> <label for="regular_pay"
                                class=" col-form-label col-form-label-sm "> Regular
                            </label> (GRN wise Payment) <br>
                            <input type="radio" class="pay_type" id="advance_pay" name="pay_type" value="ADVANCE"
                                placeholder=""> <label for="advance_pay" class=" col-form-label col-form-label-sm ">
                                Advance
                            </label> (PO Ratio Wise Payment)<br>
                            <input type="radio" class="pay_type" id="deduct" name="pay_type" value="DEDUCT"
                                placeholder=""> <label for="deduct" class=" col-form-label col-form-label-sm ">
                                Deduct
                            </label> (GRN Ratio Wise Deduct)
                        </td>
                        {{-- <td class="p-1">
                            <input type="radio" class="pay_type" id="advance_pay" name="pay_type" value="ADVANCE"
                                placeholder=""> <label for="advance_pay" class=" col-form-label col-form-label-sm ">
                                Advance (Ratio Wise Payment)
                            </label>
                        </td>
                        <td class="p-1">
                            <input type="radio" class="pay_type" id="defuct" name="pay_type" value="DEDUCT"
                                placeholder=""> <label for="defuct" class=" col-form-label col-form-label-sm "> Deduct
                                (Ratio Wise Payment)
                            </label>
                        </td> --}}



                    </tr>
                    <tr>

                        <td class="cheque_info d-none p-1">
                            <label for="pay_cqcc_number"
                                class=" col-form-label col-form-label-sm cheque_info d-none">Cheque No
                            </label>
                        </td>
                        <td class="cheque_info d-none p-1">

                            <input type="text" class="form-control form-control-sm" id="pay_cqcc_number"
                                name="pay_cqcc_number" value="" placeholder="">
                        </td>
                        <td class="cheque_info d-none p-1">
                            <label for="pay_cqcc_holder_name"
                                class=" col-form-label col-form-label-sm cheque_info d-none">Holder Name
                            </label>
                        </td>
                        <td class="cheque_info d-none p-1">
                            <input type="text" class="form-control form-control-sm " id="pay_cqcc_holder_name"
                                name="pay_cqcc_holder_name" value="" placeholder="">
                        </td>
                        <td class="cheque_info d-none p-1">
                            <label for="pay_bank_name"
                                class=" col-form-label col-form-label-sm cheque_info d-none">Bank
                                Name
                            </label>
                        </td>
                        <td class="cheque_info d-none p-1">
                            <input type="text" class="form-control form-control-sm " id="pay_bank_name"
                                name="pay_bank_name" value="" placeholder="">
                        </td>
                        <td class="p-1">
                            <label for="defuct" class="col-form-label col-form-label-sm "> Payment Note
                            </label>
                        </td>
                        <td class="p-1">
                            <textarea name="payment_note" id="" class="form-control form-control-sm" rows="2">
                        </textarea>
                        </td>
                        <td class="p-1">
                            <input type="hidden" id="total_advance" name="total_advance" value="">
                            <input type="hidden" id="total_regular" name="total_regular" value="">
                            <button type="button" class="btn btn-md btn-success" id="referralSummaryReport"
                                onclick="setData()"> Set Amount</button>
                        </td>
                    </tr>
                </table>

                <div class="card-body ">
                    <input type="hidden" name="" id="hdn_total_diduct_amt" value="0">
                    <input type="hidden" name="" id="hdn_paid_amt" value="0">
                    <div class="">
                        @php
                            $bill_id = '';
                            $response_action = route('suplier-payment-requsition');
                            $url = route('suplier-payment-invoice', $bill_id);
                        @endphp
                        {{-- <button type="button" class="btn btn-md btn-success  mt-0 " id="referralSummaryReport" onclick="">
                            Finalize</button>
                        <button type="button" class="btn btn-md btn-success  mt-0 " id="referralSummaryReport" onclick="">
                            Disburse </button> --}}
                        <button type="button" class="btn btn-success uhl_save_btn mt-0 float-right"
                            id="referralSummaryReport"
                            onclick="btnSaveUpdate(this, 'afterSaveModal', '{{ $url }}', 'common-modal-md', 'Supplier Payment Invoice', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">
                            Save</button>
                    </div>
                </div>
            </div>

        </div>



        <div class="container-fluid">

            <div class="card">
                <!-- <div class="card-header"> Monthly Salary Report</div> -->
                <div class="card-body">

                    <div class="form-row mt-2">
                        <div class="col-md-12 table-responsive" id="supplier_payment_list">
                            @include('admin.pcrm.referral_v2.IndividualReferralDetails.supplier_payment_requisition_list')
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>
</section>


<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript"
src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script>
    // $(function(){
    //     $("#supplier_name").focus();
    // });
    openSupplierAutocomplete('#supplier_name', 'supplier_name', poItem)
    $(document).on('change', '#pay_mode', function() {
        var data = $(this).val();
        $('#pay_cqcc_number').val('')
        $('#pay_cqcc_holder_name').val('')
        $('#pay_bank_name').val('')
        if (data == 'cash') {
            $('.cheque_info').addClass("d-none");
        } else {
            $('.cheque_info').removeClass('d-none');
        }
    })


    function poItem(item, obj) {
        var pay_type_class = $('input[name=pay_type]:checked').val();
        //alert(pay_type_class)


        var sup_id = item.supplier_no_pk;

        $.ajax({
            data: {
                sup_id: sup_id,
                pay_type: pay_type_class
            },
            url: "{{ route('supplier_payment_requ_po_list') }}",
            type: "post",
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {

                $('.data-table').DataTable().destroy();
                $('.tbody').html("");
               // $("input[type='text']").not('#hdn_supplier_id').val("");
                if (data[0] != null) {
                    var sl = 1;
                    var total_amt = 0;
                    var total_paid = 0;
                    var total_dis = 0;
                    // var vouchar = "";
                    data[0].forEach(element => {

                        var zero = 0;
                        total_amt_po = element.po_amount != null ? parseFloat(element.po_amount) :
                            0;
                        total_amt += total_amt_po;
                        total_paid_amt_po = element.po_paid_amount != null ? parseFloat(element
                            .po_paid_amount) : 0;
                        total_paid += total_paid_amt_po;
                        total_dis_amt_po = element.po_discount != null ? parseFloat(element
                            .po_discount) : 0;
                        total_dis += total_dis_amt_po;

                        var po_date = new Date(element.purchase_date);
                        var grn_date = element.challan_date != null ? new Date(element
                            .challan_date) : '';
                        var grn_date_format = grn_date != '' ? grn_date.getDate() + '/' + grn_date
                            .getMonth() + '/' + grn_date.getFullYear() : null;
                        console.log(grn_date_format);
                        // var grn_number = new Date(element.itemreceive_no_pk)
                        var delivery_date = new Date(element.delivery_date);
                        var last_pay_date = new Date(element.po_last_paid_date);
                        var element_deduct = element.po_amount_deduct != null ? element
                            .po_amount_deduct : 0;
                        // console.log(element_deduct);
                        $('.tbody').append(`
                            <tr>
                                <td class="text-right">${sl++}</td>
                                <td class="">${element.purchase_uid}<input type='hidden' style="width:90px" class='po_uid' value='${element.purchaseorder_no_pk}' /></td>


                                <td class="text-left ">${ element.purchase_date ? po_date.getDate()+'/'+po_date.getMonth()+'/'+po_date.getFullYear() : ""}</td>
                                <td class="text-left ">${ grn_date_format !=null ?  grn_date_format :'' }</td>
                                <td class="">${element.itemreceive_no_pk !=null ? element.itemreceive_no_pk :''}<input type='hidden' style="width:90px" class='po_uids' value='${element.itemreceive_no_pk}' /></td>

                                <td class="text-right" ><input type='text' class='text-right po_amount' id='po_amount_${element.purchaseorder_no_pk}' style="width:100px"  readonly name='po_amount[]' value=' ${element.po_amount !=null? parseFloat(element.po_amount).toFixed(2) : zero.toFixed(2)}' /></td>

                                <td class="text-right"><input type='text' id='po_dis_amount_${element.purchaseorder_no_pk}' class='po_dis_amount text-right' style="width:100px" readonly name='po_dis_amount[]' value='${element.po_amount_discount !=null? parseFloat(element.po_amount_discount).toFixed(2) : zero.toFixed(2)}' /></td>

                                <td class="text-right"><input type='text' id='po_deduct_amount_${element.purchaseorder_no_pk}' class='po_deduct_amount text-right' style="width:100px" readonly name='po_deduct_amount[]' value='${element.po_amount_deduct !=null? parseFloat(element.po_amount_deduct).toFixed(2) : zero.toFixed(2)}' /></td>

                                <td class="text-right"><input type='text' id='po_paid_amount_${element.purchaseorder_no_pk}' class='po_paid_amount text-right' style="width:100px" readonly name='po_paid_amount[]' value='${element.po_paid_amount !=null? parseFloat(element.po_paid_amount - element.po_amount_deduct).toFixed(2) : zero.toFixed(2)}' /></td>

                              <td class="text-right"><input type='text' id='po_payable_amount_${element.purchaseorder_no_pk}' class='po_payable_amount text-right' style="width:100px" readonly name='po_payable_amount[]' value='${
                                element.total_purchase_amount!=null ? parseFloat(element.total_purchase_amount).toFixed(2) :''}' /></td>

                                <td class="text-center">${element.item_q !=null ? element.item_q : 0}</td>
                                <td class="text-center">${element.no_of_item !=null ? element.no_of_item : 0}</td>
                                <td class="">${element.delivery_date !=null ? delivery_date.getDate()+'/'+delivery_date.getMonth()+'/'+delivery_date.getFullYear() : ""}</td>

                                <td class="text-right" > <input type='text' class='number_only paidAmt text-right' style="width:100px" name='paid_amt[]' id='paid_amt_${element.purchaseorder_no_pk}' value='0' readonly='readonly' /></td>

                                <td class="text-right" > <input type='text' style="width:100px" class='number_only deduct text-right' name='deduct_amt[]' id='deduct_amt_${element.purchaseorder_no_pk}' value='0' readonly='readonly' /></td>

                                <td class="text-right" > <input type='text' style="width:100px" class='number_only discout_amt text-right' name='discout_amt[]' id='discout_amt_${element.purchaseorder_no_pk}' value='0' readonly='readonly' /></td>

                                <td class="">${element.po_last_paid_date !=null? last_pay_date.getDate()+'/'+last_pay_date.getMonth()+'/'+last_pay_date.getFullYear() : ""}</td><td class="text-center">${element.po_status}</td>

                                <td class="text-center"><input type='checkbox' class='paid_radio' data-id='${element.purchaseorder_no_pk}' id='po_id_${element.purchaseorder_no_pk}' name='paid_radio[]' value='1' onclick='allAmountSum()' /></td>

                                <input type='hidden' name='hdn_po_id[]' value='${element.purchaseorder_no_pk}'/>
                                <input type='hidden' class='advance' id='advance_amt_${element.purchaseorder_no_pk}' name='advance_amt[]' value='0' /> <input type='hidden' class='regular' name='regular_amt[]' id='regular_amt_${element.purchaseorder_no_pk}' name='regular_amt' value='0' />
                            </tr>
                        `)
                    });
                    // <td class="text-right"><input type='text' id='po_payable_amount_${element.purchaseorder_no_pk}' class='po_payable_amount text-right' style="width:100px" readonly name='po_payable_amount[]' value='${parseFloat((element.po_amount - element.po_amount_discount + parseFloat(element_deduct)) - element.po_paid_amount).toFixed(2)}' /></td>
                    // $('#total_po_amount').val(total_amt.toFixed(2));
                    // $('#total_po_discount').val(total_dis.toFixed(2));
                    // $('#total_po_paid').val(total_paid.toFixed(2));
                    // $('#net_po_paid').val(total_amt.toFixed(2) - total_dis.toFixed(2));
                    // $('#net_total_po_amount').val((total_amt.toFixed(2) - total_dis.toFixed(2)) - total_paid
                    //     .toFixed(2));
                    // $('#total_due').val((total_amt.toFixed(2) - total_dis.toFixed(2)) - total_paid.toFixed(
                    //     2));

                    $('#total_diduct').val(0);
                    $('#total_paid').val(0);
                    var vouchar = data[1] != null ? 'V' + data[1] + Math.floor((Math.random() * 100000) +
                        1) : '';
                    $('#payment_voucher').val(vouchar);
                }
                $('.data-table').DataTable({
                    "lengthMenu": [
                        [50],
                        [50]
                    ],
                    "ordering": false,
                    "bPaginate": true,
                    "bLengthChange": false,
                    "bAutoWidth": false
                });
            },
            complete: function() {
                $.unblockUI();
            }
        });
    }

    function allAmountSum() {
        var all_po_amt = 0;
        var all_dis_amt = 0;
        var all_paid_amt = 0;
        var pay_type_class = $('input[name=pay_type]:checked').val();

        if (pay_type_class == 'REGULAR' || pay_type_class == 'DEDUCT') {
            $('.po_payable_amount').each(function() {
                if ($(this).parent('td').parent('tr').find('.paid_radio').is(':checked')) {
                    all_po_amt += parseFloat($(this).val());
                    all_dis_amt += parseFloat($(this).parent('td').parent('tr').find('.po_dis_amount').val());
                    all_paid_amt += parseFloat($(this).parent('td').parent('tr').find('.po_paid_amount').val());
                } else {
                    $(this).parent('td').parent('tr').find('.paidAmt').val(0);
                    $(this).parent('td').parent('tr').find('.deduct').val(0);
                    $(this).parent('td').parent('tr').find('.discout_amt').val(0);

                }
                if ($('#total_po_paid').val() == "" || $('#total_po_paid').val() == 0) {
                    $('#total_diduct').val(0.00);
                }
                //alert(all_po_amt);
                $('#total_po_amount').val(all_po_amt.toFixed(2));
                $('#total_po_discount').val(all_dis_amt.toFixed(2));
                $('#net_po_paid').val((all_po_amt - all_dis_amt).toFixed(2));
                $('#total_po_paid').val(all_paid_amt.toFixed(2));
                var net_payable = (all_po_amt - all_dis_amt) - all_paid_amt;
                console.log(net_payable.toFixed(2));
                // console.log('po_amt', all_po_amt, all_dis_amt, all_paid_amt, ((all_po_amt - all_dis_amt) -
                //     all_paid_amt).toFixed(2));
                // $('#net_total_po_amount').val(0);
                $('#net_total_po_amount').val(((all_po_amt - all_dis_amt) - all_paid_amt).toFixed(2));
                $('#total_due').val((net_payable.toFixed(2) - parseFloat($('#total_diduct').val())) - $(
                    '#total_paid').val());
                regularDiscountAmt();


            })
            regularSetData();
        }
        if (pay_type_class == 'ADVANCE') {
            $('.po_amount').each(function() {
                if ($(this).parent('td').parent('tr').find('.paid_radio').is(':checked')) {
                    all_po_amt += parseFloat($(this).val());
                    all_dis_amt += parseFloat($(this).parent('td').parent('tr').find('.po_dis_amount').val());
                    all_paid_amt += parseFloat($(this).parent('td').parent('tr').find('.po_paid_amount').val());
                } else {
                    $(this).parent('td').parent('tr').find('.paidAmt').val(0);
                    $(this).parent('td').parent('tr').find('.deduct').val(0);
                    $(this).parent('td').parent('tr').find('.discout_amt').val(0);

                }
                if ($('#total_po_paid').val() == "" || $('#total_po_paid').val() == 0) {
                    $('#total_diduct').val(0.00);
                }
                $('#total_po_amount').val(all_po_amt.toFixed(2));
                $('#total_po_discount').val(all_dis_amt.toFixed(2));
                $('#net_po_paid').val((all_po_amt - all_dis_amt).toFixed(2));
                $('#total_po_paid').val(all_paid_amt.toFixed(2));
                var net_payable = (all_po_amt - all_dis_amt) - all_paid_amt;
                console.log(net_payable.toFixed(2));
                // $('#net_total_po_amount').val(0);
                $('#net_total_po_amount').val(((all_po_amt - all_dis_amt) - all_paid_amt).toFixed(2));
                $('#total_due').val((net_payable.toFixed(2) - parseFloat($('#total_diduct').val())) - $(
                    '#total_paid').val());
                discountAmt();


            })
            setData();
        }
    }

    function regularDiscountAmt() {
        var all_po_amt = 0;
        var all_dis_amt = 0;
        var all_paid_amt = 0;
        var discount_amt = 0;
        var dis = parseFloat($('#discount_amt').val());
        var pay = parseFloat($('#net_po_paid').val() - $('#total_po_paid').val());

        if ($('#net_total_po_amount').val() == '' || $('#net_total_po_amount').val() == 0 || pay < dis) {
            $('#discount_amt').val(0);
            discount_amt = 0;
            console.log(discount_amt, pay);
        } else {
            discount_amt = $('#discount_amt').val() != "" ? parseFloat($('#discount_amt').val()) : 0;
            console.log(discount_amt, pay);
        }
        $('.po_payable_amount').each(function() {
            if ($(this).parent('td').parent('tr').find('.paid_radio').is(':checked')) {
                all_po_amt += parseFloat($(this).val());
                all_dis_amt += parseFloat($(this).parent('td').parent('tr').find('.po_dis_amount').val());
                all_paid_amt += parseFloat($(this).parent('td').parent('tr').find('.po_paid_amount').val());
            } else {
                $(this).parent('td').parent('tr').find('.paidAmt').val(0)
                $(this).parent('td').parent('tr').find('.deduct').val(0)
            }


            var payable_amt = (all_po_amt - all_dis_amt) - all_paid_amt;
            var net_payable = payable_amt - discount_amt;
            $('#net_total_po_amount').val(net_payable.toFixed(2));
            $('#total_due').val((net_payable.toFixed(2) - parseFloat($('#total_diduct').val())) - $(
                '#total_paid').val());

        })
    }
    function discountAmt() {
        var all_po_amt = 0;
        var all_dis_amt = 0;
        var all_paid_amt = 0;
        var discount_amt = 0;
        var dis = parseFloat($('#discount_amt').val());
        var pay = parseFloat($('#net_po_paid').val() - $('#total_po_paid').val());

        if ($('#net_total_po_amount').val() == '' || $('#net_total_po_amount').val() == 0 || pay < dis) {
            $('#discount_amt').val(0);
            discount_amt = 0;
            console.log(discount_amt, pay);
        } else {
            discount_amt = $('#discount_amt').val() != "" ? parseFloat($('#discount_amt').val()) : 0;
            console.log(discount_amt, pay);
        }
        var advance = '';
        if ($('#advance_pay').is(':checked')) {
            advance = $('#advance_pay').val();
        }
        console.log(advance+'tajul');
        if (advance == "ADVANCE") {
          //  alert('tstAdvance');
            $('.po_amount').each(function() {
            if ($(this).parent('td').parent('tr').find('.paid_radio').is(':checked')) {
                all_po_amt += parseFloat($(this).val());
                all_dis_amt += parseFloat($(this).parent('td').parent('tr').find('.po_dis_amount').val());
                all_paid_amt += parseFloat($(this).parent('td').parent('tr').find('.po_paid_amount').val());
            } else {
                $(this).parent('td').parent('tr').find('.paidAmt').val(0)
                $(this).parent('td').parent('tr').find('.deduct').val(0)
            }

            var payable_amt = (all_po_amt - all_dis_amt) - all_paid_amt;
            var net_payable = payable_amt - discount_amt;
            $('#net_total_po_amount').val(net_payable.toFixed(2));
            $('#total_due').val((net_payable.toFixed(2) - parseFloat($('#total_diduct').val())) - $(
                '#total_paid').val());
        })
        }else{
          //  alert('tstRegualr');
            $('.po_payable_amount').each(function() {
            if ($(this).parent('td').parent('tr').find('.paid_radio').is(':checked')) {
                all_po_amt += parseFloat($(this).val());
                all_dis_amt += parseFloat($(this).parent('td').parent('tr').find('.po_dis_amount').val());
                all_paid_amt += parseFloat($(this).parent('td').parent('tr').find('.po_paid_amount').val());
            } else {
                $(this).parent('td').parent('tr').find('.paidAmt').val(0)
                $(this).parent('td').parent('tr').find('.deduct').val(0)
            }


            var payable_amt = (all_po_amt - all_dis_amt) - all_paid_amt;
            var net_payable = payable_amt - discount_amt;
            $('#net_total_po_amount').val(net_payable.toFixed(2));
            $('#total_due').val((net_payable.toFixed(2) - parseFloat($('#total_diduct').val())) - $(
                '#total_paid').val());

             })
        }



    }
    $("body").addClass("sidebar-collapse");
    $('.date_picker').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true,
    });
    $(document).on('click', '.paid_radio', function() {
        $('#payment_amt').val("");
        if ($(this).is(':checked')) {
            $('#payment_amt').focus();
            $('#payment_amt').removeAttr('readonly');
        }
    })

    function payment(element) {
        return;
        // var this_amt = $(element).val();
        // var pay_type_class = $('.pay_type').val();
        // var pay_type = $("input:radio.pay_type:checked").val();
        // if (pay_type == 'DEDUCT') {
        //     var paid_radio = $('.tbody').children().find('.paid_radio');
        //     paid_radio.each(function() {
        //         if ($(this).is(':checked')) {
        //             var paid_id = $(this).attr('data-id');
        //             $('#deduct_amt_' + paid_id).val(this_amt);
        //         }
        //     });
        // } else {
        //     var paid_radio = $('.tbody').children().find('.paid_radio');
        //     paid_radio.each(function() {
        //         if ($(this).is(':checked')) {
        //             var paid_id = $(this).attr('data-id');
        //             $('#paid_amt_' + paid_id).val(this_amt);
        //         }
        //     });
        // }

        // if (pay_type == 'ADVANCE') {
        //     var paid_radio = $('.tbody').children().find('.paid_radio');
        //     paid_radio.each(function() {
        //         if ($(this).is(':checked')) {
        //             var paid_id = $(this).attr('data-id');
        //             $('#advance_amt_' + paid_id).val(this_amt);
        //         }
        //     });
        // }
        // if (pay_type == 'REGULAR') {
        //     {
        //         var paid_radio = $('.tbody').children().find('.paid_radio');
        //         paid_radio.each(function() {
        //             if ($(this).is(':checked')) {
        //                 var paid_id = $(this).attr('data-id');
        //                 $('#regular_amt_' + paid_id).val(this_amt);
        //             }
        //         });
        //     }
        // }
    }

    function regularSetData() {
        if ($('#payment_amt').val() == "") {
            return;
        }

        var total_payment = parseFloat($('#payment_amt').val());
        var paid_radio = $('.tbody').children().find('.paidAmt');
        var deduct_radio = $('.tbody').children().find('.deduct');
        var advance_radio = $('.tbody').children().find('.advance');
        var regular_radio = $('.tbody').children().find('.regular');
        var total_po_amount = $('#total_po_amount').val();
        var net_total_po_amount = parseFloat($('#net_total_po_amount').val());
        var total_diduct = parseFloat($('#hdn_total_diduct_amt').val());
        var total_paid = parseFloat($('#hdn_paid_amt').val());
        var total_diduct_amt = parseFloat($('#total_diduct').val());
        var total_discount_amt = $('#discount_amt').val() != "" ? parseFloat($('#discount_amt').val()) : 0;
        // console.log(total_discount_amt+'_bellal');
        // return;
        var paid_id = 0;
        var diduct_id = 0;
        var advance_id = 0;
        var regular_id = 0;

        var all_po_uid = [];
        var array = [];
        var po_amt_arr = [];
        var paid_amt_arr = [];
        var index = 0;
        var total_po_amt = 0;
        var total_payable_amt = 0;
        $('.po_uid').each(function() {
            if ($(this).parent('td').parent('tr').find('.paid_radio').is(':checked')) {
                array[index] = $(this).val();
                po_amt_arr[index] = parseFloat($(this).parent('td').parent('tr').find('.po_amount')
                    .val());
                paid_amt_arr[index] = parseFloat($(this).parent('td').parent('tr').find('.po_paid_amount')
                    .val());
                total_po_amt += parseFloat($(this).parent('td').parent('tr').find('.po_amount')
                    .val());
                total_payable_amt += parseFloat($(this).parent('td').parent('tr').find('.po_payable_amount')
                    .val());
                ++index
            }
        })

        var due = '';
        var uid_arr = $.makeArray(array);
        var total_current_paid = parseFloat($('#payment_amt').val());
        if ($('#deduct').is(':checked')) {
            // $('#total_diduct').val(parseFloat($('#payment_amt').val()));
            due = (net_total_po_amount + total_payment);
        } else {
            // $('#total_paid').val(parseFloat($('#payment_amt').val()));
            due = (net_total_po_amount - total_diduct_amt) - total_payment;
        }

        // for discount
        var discout_persent = (total_discount_amt / total_payable_amt) * 100;
        var sl_no = 0;
        uid_arr.forEach(function(item) {
            console.log(item+'___item')
            var dis_amt = 0;
            // $('#total_paid').val(parseFloat($('#payment_amt').val()));
            var payable_amt = $('#po_payable_amount_' + item).val();
            var discout_amt = (payable_amt * discout_persent) / 100;
            sl_no++
            if (uid_arr.length == sl_no) {
                $('#discout_amt_' + item).val(total_discount_amt.toFixed(2));
                dis_amt = total_discount_amt;
            } else {
                $('#discout_amt_' + item).val(Math.floor(discout_amt));
                dis_amt = Math.floor(discout_amt);
            }
            total_discount_amt -= dis_amt;
            // $('#total_due').val(due.toFixed(2));
            console.log(total_discount_amt, dis_amt);
        });

        // end discount

        // for regular payment
        if ($('#regular_pay').is(':checked')) {

            uid_arr.forEach(function(item) {
                if (net_total_po_amount < total_current_paid) {
                    $('#payment_invalid').html("Invalid amount");
                    $('#payment_amt').val('');
                    $('#total_paid').val(0);
                    $('#paid_amt_' + item).val(0);
                    var due_amt = (net_total_po_amount + 0);
                    $('#total_due').val(due_amt.toFixed(2));
                    return;
                } else {
                    var amt = 0;
                    $('#payment_invalid').html("");
                    $('#total_paid').val(parseFloat($('#payment_amt').val()));
                    var regular_discout = $('#discout_amt_' + item).val();
                    var paid_amt = (parseFloat($('#po_amount_' + item).val()) - parseFloat($(
                        '#po_dis_amount_' +
                        item).val()) - parseFloat(regular_discout)) - parseFloat($('#po_paid_amount_' +
                        item).val());

                    if (total_current_paid > paid_amt) {
                        $('#paid_amt_' + item).val(Math.floor(paid_amt));
                        amt = Math.floor(paid_amt);
                    } else {
                        $('#paid_amt_' + item).val(total_current_paid);
                        amt = total_current_paid;
                    }
                    total_current_paid -= amt;
                    $('#total_due').val(due.toFixed(2));
                }

            });
        }
        // end regular payment
        var all_po_amt = total_po_amt;

        if ($('#advance_pay').is(':checked') || $('#deduct').is(':checked')) {
            var po_amount_arr = $.makeArray(po_amt_arr);
            var paid_amount_arr = $.makeArray(paid_amt_arr);
            var po_amt_ratio = 0;
            var paid_amt_ratio_deduct = 0;
            var t_op_amt = 0;
            var t_op_amt_deduct = 0;
            var sl = 0;
            po_amount_arr.forEach(function(amt) {
                po_amt_ratio += amt;
            })
            paid_amount_arr.forEach(function(paidAmt) {
                paid_amt_ratio_deduct += paidAmt;
            })

            uid_arr.forEach(function(items) {
                // var paid_amt_ratio = $('#po_amount_' + items).val();
                var paid_amt_ratio = (parseFloat($('#po_amount_' + items).val()) - parseFloat($(
                    '#po_dis_amount_' + items).val())) - parseFloat($('#po_paid_amount_' +
                    items).val());
                var percent_amt = (paid_amt_ratio * 100) / po_amt_ratio;
                var ratio_amt = (total_current_paid * percent_amt) / 100;
                t_op_amt += parseFloat(Math.floor(ratio_amt));

                var paid_amt_ratio_wise_deduct = parseFloat($('#po_paid_amount_' + items).val());
                var percent_amt_deduct = (paid_amt_ratio_wise_deduct * 100) / paid_amt_ratio_deduct;
                var ratio_amt_deduct = (total_current_paid * percent_amt_deduct) / 100;

                t_op_amt_deduct += parseFloat(ratio_amt_deduct);

                sl++
                if ($('#advance_pay').is(':checked')) {
                    if (net_total_po_amount < total_current_paid) {
                        $('#payment_invalid').html("Invalid amount");
                        $('#payment_amt').val(0);
                        $('#total_paid').val(0);
                        $('#paid_amt_' + items).val(0);
                        var due_amt = (net_total_po_amount + 0);
                        $('#total_due').val(due_amt.toFixed(2));
                        return;
                    } else {
                        $('#payment_invalid').html("");
                        if (uid_arr.length == sl) {
                            t_op_amt -= parseFloat(ratio_amt);
                            var last_amt = total_current_paid - t_op_amt;
                            $('#paid_amt_' + items).val(last_amt.toFixed(2));
                        } else {
                            $('#paid_amt_' + items).val(Math.floor(ratio_amt));
                        }
                        $('#total_due').val(due.toFixed(2));
                        $('#total_paid').val(parseFloat($('#payment_amt').val()));
                    }

                } else {
                    var total_po_paid_amount = $('#total_po_paid').val();
                    if (total_po_paid_amount < total_current_paid) {
                        $('#payment_invalid').html("Invalid amount");
                        $('#payment_amt').val(0);
                        $('#total_paid').val(0);
                        $('#total_diduct').val(0);
                        $('#paid_amt_' + items).val(0);
                        $('#deduct_amt_' + items).val(0);
                        var due_amt = (net_total_po_amount + 0);
                        $('#total_due').val(due_amt.toFixed(2));
                        return;
                    } else {
                        $('#payment_invalid').html("");

                        if (uid_arr.length == sl) {
                            console.log(ratio_amt_deduct);
                            t_op_amt_deduct -= parseFloat(ratio_amt_deduct);

                            var last_amt = total_current_paid - t_op_amt_deduct;
                            $('#deduct_amt_' + items).val(last_amt.toFixed(2));

                        } else {
                            console.log(ratio_amt_deduct + 'else');
                            $('#deduct_amt_' + items).val(Math.floor(ratio_amt_deduct));
                        }
                        $('#total_diduct').val(parseFloat($('#payment_amt').val()));
                        $('#total_due').val(due.toFixed(2));
                    }
                }
            });
        }

        $('#payment_amt').val('');
    }
    function setData() {

        if ($('#payment_amt').val() == "") {
            return;
        }

        var total_payment = parseFloat($('#payment_amt').val());
        var paid_radio = $('.tbody').children().find('.paidAmt');
        var deduct_radio = $('.tbody').children().find('.deduct');
        var advance_radio = $('.tbody').children().find('.advance');
        var regular_radio = $('.tbody').children().find('.regular');
        var total_po_amount = $('#total_po_amount').val();
        var net_total_po_amount = parseFloat($('#net_total_po_amount').val());
        var total_diduct = parseFloat($('#hdn_total_diduct_amt').val());
        var total_paid = parseFloat($('#hdn_paid_amt').val());
        var total_diduct_amt = parseFloat($('#total_diduct').val());
        var total_discount_amt = $('#discount_amt').val() != "" ? parseFloat($('#discount_amt').val()) : 0;
        // console.log(total_discount_amt+'_bellal');
        // return;
        var paid_id = 0;
        var diduct_id = 0;
        var advance_id = 0;
        var regular_id = 0;

        var all_po_uid = [];
        var array = [];
        var po_amt_arr = [];
        var paid_amt_arr = [];
        var index = 0;
        var total_po_amt = 0;
        var total_payable_amt = 0;
        $('.po_uid').each(function() {
            if ($(this).parent('td').parent('tr').find('.paid_radio').is(':checked')) {
                array[index] = $(this).val();
                po_amt_arr[index] = parseFloat($(this).parent('td').parent('tr').find('.po_amount')
                    .val());
                paid_amt_arr[index] = parseFloat($(this).parent('td').parent('tr').find('.po_paid_amount')
                    .val());
                total_po_amt += parseFloat($(this).parent('td').parent('tr').find('.po_amount')
                    .val());
                total_payable_amt += parseFloat($(this).parent('td').parent('tr').find('.po_payable_amount')
                    .val());
                ++index
            }
        })

        var due = '';
        var uid_arr = $.makeArray(array);
        var total_current_paid = parseFloat($('#payment_amt').val());
        if ($('#deduct').is(':checked')) {
            // $('#total_diduct').val(parseFloat($('#payment_amt').val()));
            due = (net_total_po_amount + total_payment);
        } else {
            // $('#total_paid').val(parseFloat($('#payment_amt').val()));
            due = (net_total_po_amount - total_diduct_amt) - total_payment;
        }

        // for discount
        var discout_persent = (total_discount_amt / total_payable_amt) * 100;
        var sl_no = 0;
        uid_arr.forEach(function(item) {
console.log(item + '__ok')
            var dis_amt = 0;
            // $('#total_paid').val(parseFloat($('#payment_amt').val()));
            var payable_amt = $('#po_payable_amount_' + item).val();
            console.log(payable_amt+'___nazmul')
            var discout_amt = (payable_amt * discout_persent) / 100;

            sl_no++;
            if (uid_arr.length == sl_no) {
                $('#discout_amt_' + item).val(total_discount_amt.toFixed(2));
                dis_amt = total_discount_amt;
            } else {
                $('#discout_amt_' + item).val(Math.floor(discout_amt));
                dis_amt = Math.floor(discout_amt);
            }
            console.log('ok___nazmul')
            total_discount_amt -= dis_amt;
            // $('#total_due').val(due.toFixed(2));
            console.log(total_discount_amt, dis_amt);
        });

        // end discount

        // for regular payment
        if ($('#regular_pay').is(':checked')) {

            uid_arr.forEach(function(item) {
                if (net_total_po_amount < total_current_paid) {
                    $('#payment_invalid').html("Invalid amount");
                    $('#payment_amt').val('');
                    $('#total_paid').val(0);
                    $('#paid_amt_' + item).val(0);
                    var due_amt = (net_total_po_amount + 0);
                    $('#total_due').val(due_amt.toFixed(2));
                    return;
                } else {
                    var amt = 0;
                    $('#payment_invalid').html("");
                    $('#total_paid').val(parseFloat($('#payment_amt').val()));
                    var regular_discout = $('#discout_amt_' + item).val();
                    var paid_amt = (parseFloat($('#po_amount_' + item).val()) - parseFloat($(
                        '#po_dis_amount_' +
                        item).val()) - parseFloat(regular_discout)) - parseFloat($('#po_paid_amount_' +
                        item).val());

                    if (total_current_paid > paid_amt) {
                        $('#paid_amt_' + item).val(Math.floor(paid_amt));
                        amt = Math.floor(paid_amt);
                    } else {
                        $('#paid_amt_' + item).val(total_current_paid);
                        amt = total_current_paid;
                    }
                    total_current_paid -= amt;
                    $('#total_due').val(due.toFixed(2));
                }

            });
        }
        // end regular payment
        var all_po_amt = total_po_amt;

        if ($('#advance_pay').is(':checked') || $('#deduct').is(':checked')) {
            var po_amount_arr = $.makeArray(po_amt_arr);
            var paid_amount_arr = $.makeArray(paid_amt_arr);
            var po_amt_ratio = 0;
            var paid_amt_ratio_deduct = 0;
            var t_op_amt = 0;
            var t_op_amt_deduct = 0;
            var sl = 0;
            po_amount_arr.forEach(function(amt) {
                po_amt_ratio += amt;
            })
            paid_amount_arr.forEach(function(paidAmt) {
                paid_amt_ratio_deduct += paidAmt;
            })

            uid_arr.forEach(function(items) {
                // var paid_amt_ratio = $('#po_amount_' + items).val();
                var paid_amt_ratio = (parseFloat($('#po_amount_' + items).val()) - parseFloat($(
                    '#po_dis_amount_' + items).val())) - parseFloat($('#po_paid_amount_' +
                    items).val());
                var percent_amt = (paid_amt_ratio * 100) / po_amt_ratio;
                var ratio_amt = (total_current_paid * percent_amt) / 100;
                t_op_amt += parseFloat(Math.floor(ratio_amt));

                var paid_amt_ratio_wise_deduct = parseFloat($('#po_paid_amount_' + items).val());
                var percent_amt_deduct = (paid_amt_ratio_wise_deduct * 100) / paid_amt_ratio_deduct;
                var ratio_amt_deduct = (total_current_paid * percent_amt_deduct) / 100;

                t_op_amt_deduct += parseFloat(ratio_amt_deduct);

                sl++
                if ($('#advance_pay').is(':checked')) {
                    if (net_total_po_amount < total_current_paid) {
                        $('#payment_invalid').html("Invalid amount");
                        $('#payment_amt').val(0);
                        $('#total_paid').val(0);
                        $('#paid_amt_' + items).val(0);
                        var due_amt = (net_total_po_amount + 0);
                        $('#total_due').val(due_amt.toFixed(2));
                        return;
                    } else {
                        $('#payment_invalid').html("");
                        if (uid_arr.length == sl) {
                            t_op_amt -= parseFloat(ratio_amt);
                            var last_amt = total_current_paid - t_op_amt;
                            $('#paid_amt_' + items).val(last_amt.toFixed(2));
                        } else {
                            $('#paid_amt_' + items).val(Math.floor(ratio_amt));
                        }
                        $('#total_due').val(due.toFixed(2));
                        $('#total_paid').val(parseFloat($('#payment_amt').val()));
                    }

                } else {
                    var total_po_paid_amount = $('#total_po_paid').val();
                    if (total_po_paid_amount < total_current_paid) {
                        $('#payment_invalid').html("Invalid amount");
                        $('#payment_amt').val(0);
                        $('#total_paid').val(0);
                        $('#total_diduct').val(0);
                        $('#paid_amt_' + items).val(0);
                        $('#deduct_amt_' + items).val(0);
                        var due_amt = (net_total_po_amount + 0);
                        $('#total_due').val(due_amt.toFixed(2));
                        return;
                    } else {
                        $('#payment_invalid').html("");

                        if (uid_arr.length == sl) {
                            console.log(ratio_amt_deduct);
                            t_op_amt_deduct -= parseFloat(ratio_amt_deduct);

                            var last_amt = total_current_paid - t_op_amt_deduct;
                            $('#deduct_amt_' + items).val(last_amt.toFixed(2));

                        } else {
                            console.log(ratio_amt_deduct + 'else');
                            $('#deduct_amt_' + items).val(Math.floor(ratio_amt_deduct));
                        }
                        $('#total_diduct').val(parseFloat($('#payment_amt').val()));
                        $('#total_due').val(due.toFixed(2));
                    }
                }
            });
        }

        $('#payment_amt').val('');
    }


    $(document).on('change', '.pay_type', function() {
        var pay_type_class = $('input[name=pay_type]:checked').val();
         if(pay_type_class=='ADVANCE')
         {
          $('.po_amt_label').html('PO Amount');
          $('.po_amt_dis').html('PO Discount');
          $('.net_po_amt_label').html('Net PO Amount');
          $('.po_amt_paid_label').html('PO Paid');
         }
         else
         {
          $('.po_amt_label').html('GRN Amount');
          $('.po_amt_dis').html('GRN Discount');
          $('.net_po_amt_label').html('Net GRN Amount');
          $('.po_amt_paid_label').html('GRN Paid');
         }

        if ($(this).attr('id') == "deduct") {
            $('#discount_amt').attr('readonly', 'readonly');
        } else {
            $('#discount_amt').removeAttr('readonly');
        }
        var sup_id = $("#hdn_supplier_id").val();
        $.ajax({
            data: {
                sup_id: sup_id,
                pay_type: pay_type_class
            },
            url: "{{ route('supplier_payment_requ_po_list') }}",
            type: "post",
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {

                $('.data-table').DataTable().destroy();
                $('.tbody').html("");
               // $("input[type='text']").not('#hdn_supplier_id').val("");
                if (data[0] != null) {
                    var sl = 1;
                    var total_amt = 0;
                    var total_paid = 0;
                    var total_dis = 0;
                    // var vouchar = "";
                    data[0].forEach(element => {

                        var zero = 0;
                        total_amt_po = element.po_amount != null ? parseFloat(element.po_amount) :
                            0;
                        total_amt += total_amt_po;
                        total_paid_amt_po = element.po_paid_amount != null ? parseFloat(element
                            .po_paid_amount) : 0;
                        total_paid += total_paid_amt_po;
                        total_dis_amt_po = element.po_discount != null ? parseFloat(element
                            .po_discount) : 0;
                        total_dis += total_dis_amt_po;

                        var po_date = new Date(element.purchase_date);
                        var grn_date = element.challan_date != null ? new Date(element
                            .challan_date) : '';
                        var grn_date_format = grn_date != '' ? grn_date.getDate() + '/' + grn_date
                            .getMonth() + '/' + grn_date.getFullYear() : null;
                        console.log(grn_date_format);
                        // var grn_number = new Date(element.itemreceive_no_pk)
                        var delivery_date = new Date(element.delivery_date);
                        var last_pay_date = new Date(element.po_last_paid_date);
                        var element_deduct = element.po_amount_deduct != null ? element
                            .po_amount_deduct : 0;
                        // console.log(element_deduct);
                        $('.tbody').append(`
                            <tr>
                                <td class="text-right">${sl++}</td>
                                <td class="">${element.purchase_uid}<input type='hidden' style="width:90px" class='po_uid' value='${element.purchase_uid}' /></td>


                                <td class="text-left ">${ element.purchase_date ? po_date.getDate()+'/'+po_date.getMonth()+'/'+po_date.getFullYear() : ""}</td>
                                <td class="text-left ">${ grn_date_format !=null ?  grn_date_format :'' }</td>
                                <td class="">${element.itemreceive_no_pk !=null ? element.itemreceive_no_pk :''}<input type='hidden' style="width:90px" class='po_uid' value='${element.itemreceive_no_pk}' /></td>

                                <td class="text-right" ><input type='text' class='text-right po_amount' id='po_amount_${element.purchaseorder_no_pk}' style="width:100px"  readonly name='po_amount[]' value=' ${element.po_amount !=null? parseFloat(element.po_amount).toFixed(2) : zero.toFixed(2)}' /></td>

                                <td class="text-right"><input type='text' id='po_dis_amount_${element.purchaseorder_no_pk}' class='po_dis_amount text-right' style="width:100px" readonly name='po_dis_amount[]' value='${element.po_amount_discount !=null? parseFloat(element.po_amount_discount).toFixed(2) : zero.toFixed(2)}' /></td>

                                <td class="text-right"><input type='text' id='po_deduct_amount_${element.purchaseorder_no_pk}' class='po_deduct_amount text-right' style="width:100px" readonly name='po_deduct_amount[]' value='${element.po_amount_deduct !=null? parseFloat(element.po_amount_deduct).toFixed(2) : zero.toFixed(2)}' /></td>

                                <td class="text-right"><input type='text' id='po_paid_amount_${element.purchaseorder_no_pk}' class='po_paid_amount text-right' style="width:100px" readonly name='po_paid_amount[]' value='${element.po_paid_amount !=null? parseFloat(element.po_paid_amount - element.po_amount_deduct).toFixed(2) : zero.toFixed(2)}' /></td>

                              <td class="text-right"><input type='text' id='po_payable_amount_${element.purchaseorder_no_pk}' class='po_payable_amount text-right' style="width:100px" readonly name='po_payable_amount[]' value='${
                                element.total_purchase_amount!=null ? parseFloat(element.total_purchase_amount).toFixed(2) :''}' /></td>

                                <td class="text-center">${element.item_q !=null ? element.item_q : 0}</td>
                                <td class="text-center">${element.no_of_item !=null ? element.no_of_item : 0}</td>
                                <td class="">${element.delivery_date !=null ? delivery_date.getDate()+'/'+delivery_date.getMonth()+'/'+delivery_date.getFullYear() : ""}</td>

                                <td class="text-right" > <input type='text' class='number_only paidAmt text-right' style="width:100px" name='paid_amt[]' id='paid_amt_${element.purchaseorder_no_pk}' value='0' readonly='readonly' /></td>

                                <td class="text-right" > <input type='text' style="width:100px" class='number_only deduct text-right' name='deduct_amt[]' id='deduct_amt_${element.purchaseorder_no_pk}' value='0' readonly='readonly' /></td>

                                <td class="text-right" > <input type='text' style="width:100px" class='number_only discout_amt text-right' name='discout_amt[]' id='discout_amt_${element.purchaseorder_no_pk}' value='0' readonly='readonly' /></td>

                                <td class="">${element.po_last_paid_date !=null? last_pay_date.getDate()+'/'+last_pay_date.getMonth()+'/'+last_pay_date.getFullYear() : ""}</td><td class="text-center">${element.po_status}</td>

                                <td class="text-center"><input type='checkbox' class='paid_radio' data-id='${element.purchaseorder_no_pk}' id='po_id_${element.purchaseorder_no_pk}' name='paid_radio[]' value='1' onclick='allAmountSum()' /></td>

                                <input type='hidden' name='hdn_po_id[]' value='${element.purchaseorder_no_pk}'/>
                                <input type='hidden' class='advance' id='advance_amt_${element.purchaseorder_no_pk}' name='advance_amt[]' value='0' /> <input type='hidden' class='regular' name='regular_amt[]' id='regular_amt_${element.purchaseorder_no_pk}' name='regular_amt' value='0' />
                            </tr>
                        `)
                    });
                    // <td class="text-right"><input type='text' id='po_payable_amount_${element.purchaseorder_no_pk}' class='po_payable_amount text-right' style="width:100px" readonly name='po_payable_amount[]' value='${parseFloat((element.po_amount - element.po_amount_discount + parseFloat(element_deduct)) - element.po_paid_amount).toFixed(2)}' /></td>
                    // $('#total_po_amount').val(total_amt.toFixed(2));
                    // $('#total_po_discount').val(total_dis.toFixed(2));
                    // $('#total_po_paid').val(total_paid.toFixed(2));
                    // $('#net_po_paid').val(total_amt.toFixed(2) - total_dis.toFixed(2));
                    // $('#net_total_po_amount').val((total_amt.toFixed(2) - total_dis.toFixed(2)) - total_paid
                    //     .toFixed(2));
                    // $('#total_due').val((total_amt.toFixed(2) - total_dis.toFixed(2)) - total_paid.toFixed(
                    //     2));

                    $('#total_diduct').val(0);
                    $('#total_paid').val(0);
                    var vouchar = data[1] != null ? 'V' + data[1] + Math.floor((Math.random() * 100000) +
                        1) : '';
                    $('#payment_voucher').val(vouchar);
                }
                $('.data-table').DataTable({
                    "lengthMenu": [
                        [50],
                        [50]
                    ],
                    "ordering": false,
                    "bPaginate": true,
                    "bLengthChange": false,
                    "bAutoWidth": false
                });
            },
            complete: function() {
                $.unblockUI();
            }
        });
        //alert('hi');
        var net_total_po_amount = parseFloat($('#net_total_po_amount').val());
        $('#discount_amt').val(0);
        $('.paidAmt').val(0);
        $('.deduct').val(0);
        $('#total_diduct').val(0);
        $('#total_paid').val(0);
        $('#total_due').val(net_total_po_amount);
        allAmountSum();

    })
</script>
