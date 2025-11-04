<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('css/colors.css') }}">
@php
$purchase_date = isset($my_requsition) ? $my_requsition->pur_requisition_date : date('d-m-Y');
//dd($purchase_date);
@endphp
<style>
    .list-group-item {
        background-color: transparent !important;
    }
</style>
<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
        <div class="col-md-9">
            <h5 class="mt-2 mb-0">My Requisition</h5>
            <small>Inventory / My Requisition</small>
        </div>
        <div class="col-md-3 ">
            <div id="top-action">

                <a rel="tab" href="{{ route('inventory-purchase-requisition.index') }}"
                    class="btn btn-outline-primary btn-md float-right mt-2"><i class="fa fa-desktop"></i>&nbsp;My
                    Requisition
                    Worklist</a>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>My Requisition</h5>
                        </div>

                        <div class="card-body mt-2">
                            <form action="{{ route('inventory-purchase-requisition.store') }}" id="store_requistion"
                                method="post">
                                <input type="hidden" name="module_code" value="INV">


                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-row">
                                            <div class="form-group  col-md-2">
                                                <label class="col-form-label col-form-label-sm" for="date">Date
                                                    <span class="text-danger">*</span></label>
                                                <input type="text"
                                                    class="form-control form-control-sm m-0 date_picker" id="date"
                                                    name="date"
                                                    value="{{ date('d-m-Y', strtotime($purchase_date)) }}"
                                                    placeholder="dd-mm-yyyy">

                                                <input type="hidden" name="hdn_requisition_no"
                                                    value="{{ isset($my_requsition) && !empty($my_requsition) ? $my_requsition->pur_requisition_no_pk : '' }}">
                                                <input type="hidden" name="po_edit_ind"
                                                    value="{{ isset($po_child_details_info) && !empty($po_child_details_info) ? 1 : '' }}">
                                            </div>
                                            <div class="form-group col-md-1">
                                                <label class="col-form-label col-form-label-sm" for="pvms_no">Item
                                                    Code</label>
                                                <!--  <input type="text" class="form-control form-control-sm m-0" id="item_id" name="item_id" value="" placeholder="Item ID" > -->
                                                <input type="text" class="form-control form-control-sm m-0"
                                                    id="item_code" name="item_code" value=""
                                                    placeholder="Item Code" autocomplete="off">
                                            </div>

                                            <div class="form-group col-md-2">
                                                <label class="col-form-label col-form-label-sm" for="item_name">Item
                                                    Name</label>
                                                <input type="hidden" name="item_id_hidden" id="item_id_hidden">
                                                <table width="100%">
                                                    <tr>
                                                        <td style="border: none"> <input type="text"
                                                                class="form-control form-control-sm m-0" id="item_name"
                                                                name="item_name" value="" placeholder="Item Name"
                                                                autocomplete="off"></td>
                                                        <td style="border: none;text-align:right" id="item_info"></td>
                                                    </tr>
                                                </table>


                                            </div>
                                            <div class="form-group col-md-1">
                                                <label class="col-form-label col-form-label-sm" for="item_uom">Item
                                                    UoM</label>
                                                <input type="hidden" name="item_uom_hidden" id="item_uom_hidden">
                                                <input type="hidden" name="item_sales_uom" id="item_sales_uom">
                                                <input type="text" class="form-control form-control-sm m-0"
                                                    id="item_uom" name="item_uom" value="" placeholder="Item UoM"
                                                    readonly>
                                            </div>
                                            @if (Session::get('user.inv_proc_ind') == 1)
                                                <div class="form-group col-md-2">
                                                    <label class="col-form-label col-form-label-sm"
                                                        for="item_price">Purchase Price</label>
                                                    <input type="text"
                                                        class="form-control form-control-sm m-0 text-right number_only"
                                                        id="item_price" name="item_price" value="0"
                                                        placeholder="Item Price">
                                                </div>
                                            @endif
                                            <div class="form-group col-md-2">
                                                <label class="col-form-label col-form-label-sm"
                                                    for="item_quantity">Item
                                                    Quantity</label>
                                                <input type="text"
                                                    class="form-control form-control-sm m-0 text-right number_only"
                                                    id="item_quantity" name="item_quantity" value="0"
                                                    placeholder="Item Quantity">
                                            </div>


                                            <div class="form-group col-md-2">
                                                @if (Session::get('user.inv_auth_chairman_ind') == 1)
                                                    <button type="button" id="add_item_btn"
                                                        class="btn btn-success btn-block btn-md mt-4 " disabled><i
                                                            class="fa fa-plus"></i> Add Item</button>
                                                @elseif (Session::get('user.inv_auth_director_ind') == 1)
                                                    <button type="button" id="add_item_btn"
                                                        class="btn btn-success btn-block btn-md mt-4 " disabled><i
                                                            class="fa fa-plus"></i> Add Item</button>
                                                @elseif (Session::get('user.inv_auth_admin_ind') == 1)
                                                    <button type="button" id="add_item_btn"
                                                        class="btn btn-success btn-block btn-md mt-4 " disabled><i
                                                            class="fa fa-plus"></i> Add Item</button>
                                                @elseif (Session::get('user.inv_hod_ind') == 1)
                                                    <button type="button" id="add_item_btn"
                                                        class="btn btn-success btn-block btn-md mt-4 " disabled><i
                                                            class="fa fa-plus"></i> Add Item</button>
                                                @else
                                                    <button type="button" id="add_item_btn"
                                                        class="btn btn-success btn-block btn-md mt-4"><i
                                                            class="fa fa-plus"></i> Add Item</button>
                                                @endif
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 table-responsive mt-3">
                                        <table class="table  table-striped table-bordered table-hover ">
                                            <thead class="bg-primary">
                                                <tr>
                                                    <th class="text-center ">SL</th>
                                                    <th class="text-center">Item No</th>
                                                    {{-- <th class="text-center">Barcode</th> --}}
                                                    <th class="text-center">Item Name</th>
                                                    <th class="text-center">UoM</th>
                                                    @if (Session::get('user.inv_proc_ind') == 1)
                                                    <th class="text-center ">Rate</th>
                                                    @endif
                                                    <th class="text-center ">Req. Quantity</th>
                                                    @if (Session::get('user.inv_proc_ind') == 1)
                                                    <th class="text-center ">App. Quantity</th>
                                                    @endif
                                                    {{-- <th class="text-right width-100">Amount</th> --}}

                                                    <th class="text-center ">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="requsition_items">

                                                {{-- for Edit --}}
                                                @php
                                                    $total_amount = 0;
                                                @endphp
                                                @if (isset($my_requsition_dtls) && !empty($my_requsition_dtls))
                                                    @foreach ($my_requsition_dtls as $key => $data)
                                                        @php
                                                            $lookup_data = \App\Models\LookupItem::where('lookupdata_no_pk',$data->uom)->first();
                                                            //dd($lookup_data);
                                                        @endphp
                                                        {{-- {{ dd($data) }} --}}
                                                        <tr>
                                                            <td class="text-center sl-td">{{ $loop->iteration }}</td>
                                                            <td class="text-left"> <input type="hidden"
                                                                    name="item_id[]"
                                                                    value="{{ $data->item_no_fk }}">{{ $data->item_name }}
                                                            </td>
                                                            <input type="hidden" name="item_name_arr[]"
                                                                value="{{ $data->item_name }}">
                                                            <td class="text-left"> <input type="hidden"
                                                                    class="same-item-id" name="item_ids[]"
                                                                    value="6161384">{{ $data->item_name }}</td>
                                                            <td class="text-left"> 
                                                                {{@$lookup_data->lookupdata_name}}
                                                                <input type="hidden"
                                                                    name="item_uoms[]" value="{{ $data->uom }}">
                                                            </td>
                                                            @if (Session::get('user.inv_proc_ind') == 1)
                                                            <td class="text-right"> <input
                                                                    class="item-rate text-right number_only"
                                                                    onkeyup="test(this)" min="0"
                                                                    type="text" name="item_rates[]"
                                                                    value="{{ $data->rate }}"></td>
                                                            @endif
                                                            <td class="text-right"> <input
                                                                    class="item-rate text-right number_only"
                                                                    onkeyup="test(this)" min="0"
                                                                    type="text" name="item_quantities[]"
                                                                    value="{{ $data->req_quantity }}"></td>
                                                            @if (Session::get('user.inv_proc_ind') == 1)
                                                            <td class="text-right"> <input
                                                                    class="item-qty text-right number_only"
                                                                    onkeyup="test(this)" min="0"
                                                                    type="text" name="item_app_quantities[]"
                                                                    value="{{ $data->req_quantity != 0 || $data->req_quantity != '' ? $data->approval_qty : $data->req_quantity }}">
                                                                <input type="hidden" class="total_price"
                                                                    value="0"><input type="hidden"
                                                                    name="sales_uom[]" class="sales_uom"
                                                                    value=""><input type="hidden"
                                                                    name="item_conversion[]" class="item_conversion"
                                                                    value="0">
                                                            </td>
                                                            @endif

                                                            <td> <a href="javascript:void(0)"
                                                                    class="btn btn-sm btn-danger remove-item-btn"
                                                                    title="Remove"><i
                                                                        class="fa fa-times-circle"></i></a></td>

                                                        </tr>
                                                        @php
                                                            $total_amount += $data->req_quantity * $data->rate;
                                                        @endphp
                                                    @endforeach

                                                @endif

                                                {{-- End --}}

                                            </tbody>
                                        </table>
                                    </div>
                                </div>



                                @if (Session::get('user.inv_proc_ind') == 1)
                                <div class="form-row justify-content-end">

                                    <div class="col-md-4  mt-2">
                                        <ul
                                            class="list-group bg-light-blue list-group-flush bg-light-blue rounded mb-2 border">
                                            <li class="list-group-item">
                                                <h5 class="float-left mr-2">Total Amount</h5>
                                                {{-- <span class="float-right btn btn-outline-danger bg-none btn-md"
                                                    id="item_total"> 0</span> --}}
                                                <input type="text" class="form-control float-right number_only "
                                                    id="item_total" name="item_total"
                                                    style="width:80px; text-align: right;"
                                                    value="{{ number_format($total_amount, 2) }}"
                                                    readonly="readonly">

                                            </li>


                                        </ul>
                                    </div>
                                </div>
                                @endif

                                <div class="row">
                                    <div class="col-12">
                                        <div class="custom-box">
                                            <div class="custom-box-body m-0 text-right">

                                                @php
                                                    $response_action = route('inventory-purchase-requisition.index');
                                                @endphp

                                                <button type="submit"
                                                    onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')"
                                                    class="btn btn-md btn-success">Save</button>

                                                {{-- <button type="reset" class="btn btn-info btn-md"
                                                    title="Click here to Clear form data">Clear</button> --}}
                                                <a href="{{ route('admin-dashboard') }}"
                                                    class="btn btn-danger btn-md" rel="tab"
                                                    title="Click here to go back to Dashboard">Exit</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="purchase_order_entry_modal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Default Items</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body modal-body2">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="setFormDefault()">Set
                    For
                    PO</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<div class="modal" tabindex="-1" role="dialog" id="last_purchase_order_entry_modal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Last Purchase Order Entry </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body modal-body1" id="last_purchase_order_entry_modal_body">

            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" onclick="setFormLastPurchase()"
                    class="btn btn-primary">Set
                    For PO</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>

<script>
    function test(thisElement) {
        if ($("#requsition_items tr").length > 0) {

            $("#requsition_items tr").each(function() {
                var qty = $(this).find(".item-qty").val() * 1;
                var price = $(this).find(".item-rate").val() * 1;
                var total = qty * price;
                $(this).find(".total_price").val(total);

            });

        }
        poItemCalculateTotal1(thisElement)
    }

    // $(document).ready(function() {
    //     function calculatePrice(thisElement) {
    //         // if ($("#demand_items tr").length > 0) {

    //         //     $("#demand_items tr").each(function() {
    //                 var qty = $(this).find(".item-qty").val() * 1;
    //                 var price = $(this).find(".item-rate").val() * 1;
    //                 var total = qty * price;
    //                 $(this).find(".total_price").val(total);

    //             // });
    //             poItemCalculateTotal1(thisElement)
    //         // }

    //     }
    // });

    function poItemCalculateTotal1(thisElement) {

        var item_total = 0;
        if ($("#requsition_items tr").length == 0) {
            alert("Please add one item");
            return;
        } else {
            $("#requsition_items tr").each(function() {
                item_total += $(this).find(".total_price").val() * 1;
            });
        }
        //console.log($(thisElement).attr('id'));
        if ($(thisElement).attr('id') == 'total_vat_amount') {
            $("#vat_percent").val('');
            if ($(thisElement).val() > item_total) {
                alert("Invalid VAT/Tax");
                $(thisElement).val('');
                return;
            }
        }
        if ($(thisElement).attr('id') == 'vat_percent') {
            $("#total_vat_amount").val('');
            if ($(thisElement).val() > 100) {
                alert("Invalid VAT/Tax");
                $(thisElement).val('');
                return;
            }
        }
        if ($(thisElement).attr('id') == 'discount_percent') {
            $("#total_discount_amount").val('');
            //console.log("discount Percent",$(thisElement).val());
            if ($(thisElement).val() > 100) {
                alert("Invalid Discount");
                $(thisElement).val('');
                return;
            }


        }
        if ($(thisElement).attr('id') == 'total_discount_amount') {
            $("#discount_percent").val('');
            if ($(thisElement).val() > item_total) {
                alert("Invalid Discount");
                $(thisElement).val('');
                return;
            }

        }
        var itemT_pay = (parseFloat($("#item_total").val()) - parseFloat($("#pay_amount").val()));
        var urgent_fee_total = $("#urgent_fee").val() != '' ? parseFloat($("#urgent_fee").val()) : 0;
        var discount_percent = $("#discount_percent").val() != "" ? parseFloat($("#discount_percent")
            .val()) : 0;
        var total_discount_amount = $("#total_discount_amount").val() != "" ? parseFloat($(
            "#total_discount_amount").val()) : 0;

        console.log(discount_percent, total_discount_amount, "Anik");

        var item_total = 0;
        var delivery_status = 0;
        var urgent_fee = 0;
        var final_total = 0;
        // var urgent_fee = urgent_fee_total;

        if ($("#requsition_items tr").length > 0) {
            $("#requsition_items tr").each(function() {
                item_total += $(this).find(".total_price").val() * 1;
            });
            console.log(urgent_fee);
            $("#item_total").val(item_total.toFixed(2));
            $("#total_payable").val((item_total + urgent_fee).toFixed(2));

            var vat_percent = $("#vat_percent").val() * 1;
            var total_vat_amount = 0;
            //console.log('disc', vat_percent);
            if (vat_percent != 0) {
                total_vat_amount = (item_total * vat_percent) / 100;
                $("#total_vat_amount").val(total_vat_amount.toFixed(2));
                final_total = item_total + total_vat_amount;
            } else {
                var vat_amount = parseFloat($("#total_vat_amount").val() * 1);
                if (vat_amount != 0) {
                    total_vat_amount = (vat_amount / item_total) * 100;

                    // $("#vat_percent").val(total_vat_amount.toFixed(2));

                }
                final_total = item_total + vat_amount;
            }

            var discount_percent = $("#discount_percent").val() * 1;
            var total_discount_amount = 0;
            // console.log('disc', vat_percent);
            if (discount_percent != 0) {
                total_discount_amount = (item_total * discount_percent) / 100;
                $("#total_discount_amount").val(total_discount_amount.toFixed(2));
                final_total = final_total - total_discount_amount;
            } else {
                var vat_amount = parseFloat($("#total_discount_amount").val() * 1);
                if (vat_amount != 0) {
                    total_discount_amount = (vat_amount / item_total) * 100;

                    // $("#discount_percent").val(total_discount_amount.toFixed(2));

                }
                final_total = final_total - vat_amount;
            }





            $("#total_due_data").html(Math.floor(final_total).toFixed(2));
            $("#discount_adj_amt").val((final_total - Math.floor(final_total)).toFixed(2));

            // receiveItemCalculateTotal(thisElement);

        } else {
            $("#items_to_receive tr").html('');
            $('#total_payable').val(0);
            $('#pay_amount').val(0);
            $('#given_amount').val(0);
            $("#item_total").val(0.00);
            $("#change_amount").val(0.00);
            $("#vat_percent").val("");
            $("#total_vat_amount").val("");
            $("#total_vat_amount").val("");
            $("#total_discount_amount").val("");
            alert("You did not selected any Item.");
            return;
        }
        event.stopImmediatePropagation();

    }
    $(document).ready(function() {
        $("body").addClass("sidebar-collapse");
        $('.date_picker').datepicker({
            todayHighlight: true,
            format: 'dd-mm-yyyy',
            clearBtn: true,
            autoclose: true,
            startDate: new Date()
        });
        $('.data-table').DataTable({
            "ordering": true,
            "bPaginate": false,
            "bLengthChange": false,
            "bAutoWidth": false
        });




        inventory_autocomplete_iteminfo_by_item_name('#item_name', 'item_name', function(item, obj) {
            //console.log(item);
            $('#item_code').val(item.item_code);
            $('#item_id_hidden').val(item.item_id);
            $('#item_uom_hidden').val(item.uom_no_fk);
            $('#item_uom').val(item.uom_name);
            $("#item_price").val(item.purchase_price);
            $('#item_conversion').val(item.pr_uom_conversion_qty);
            $('#item_sales_uom').val(item.item_sales_uom);
            // $('#supplier_id').val(item.manufacturer_no_fk).trigger('change');
            var edit_action = '{{ route('item.edit-quick-item-po', ':id') }}';
            edit_action = edit_action.replace(':id', item.item_id);

            // $('#pvms_no').val(item.pvms_no);
            obj.stopImmediatePropagation();
        });

        inventory_autocomplete_iteminfo_by_item_code('#item_code', 'item_code', function(item, obj) {
            $('#item_code').val(item.item_code);
            $('#item_name').val(item.item_name);
            $('#item_id_hidden').val(item.item_id);
            $('#item_uom_hidden').val(item.uom_no_fk);
            $('#item_uom').val(item.uom_name);
            $("#item_price").val(item.purchase_price);
            $('#item_conversion').val(item.pr_uom_conversion_qty);

            // $('#pvms_no').val(item.pvms_no);
            var edit_action = '{{ route('item.edit-quick-item-po', ':id') }}';
            edit_action = edit_action.replace(':id', item.item_id);
            $('#item_info').html(
                `<span class="p-0 m-0 btn btn-sm btn-primary open-modal" data-id="${item.item_id}" data-action="${edit_action}" data-modal="common-modal-md" data-title="Edit Item" title="Edit"><i class="fa fa-pencil-alt"></i></span>`
            )
            obj.stopImmediatePropagation();
        });



        $(document).on('click', '#entry_ready_items', function(e) {
            e.preventDefault()

            var rows = '';
            var same_item = false;
            $('.selected-default-item').each(function(index, elem) {
                if ($(elem).is(":checked")) {
                    var iteration = $(elem).attr('data-iteration')
                    // var pvms_no = $('#pvms_'+iteration).val()
                    //                var barcode_no = $('#barcode_'+iteration).val()
                    var item_id = $('#item_id_' + iteration).val()
                    var item_name = $('#item_name_' + iteration).val()
                    var item_uom_no = $('#uom_' + iteration).val()
                    var item_uom_name = $('#lookupdate_name_' + iteration).val()
                    var rate = $('#rate_' + iteration).val()
                    var quantity = $('#qty_' + iteration).val()


                    $('input[class=same-item-id]').each(function(index, elm) {
                        if ($(elm).val() == item_id) {
                            same_item = true
                        }
                    })
                    if (same_item == true) {
                        return false
                    }

                    rows += '<tr>' +
                        '<td class="text-center sl-td">0</td>' +
                        '<td class="text-left"> <input type="hidden" name="item_id[]" value="' +
                        item_id + '">' + item_id + '</td>' +
                        '<td class="text-left"> <input type="hidden" class="same-item-id" name="item_ids[]" value="' +
                        item_id + '">' + item_name + '</td>' +
                        '<td class="text-left"> <input type="hidden" name="item_uoms[]" value="' +
                        item_uom_no + '">' + item_uom_name + '</td>' +
                        '<td class="text-right"> <input class="item-rate text-right number_only" min="0" type="text" name="item_rates[]" value="' +
                        rate + '"></td>' +
                        '<td class="text-right"> <input class="item-qty text-right number_only" min="0" type="text" name="item_quantities[]" value="' +
                        quantity + '"></td>' +
                        '<td> <a href="javascript:void(0)" class="btn btn-sm btn-danger remove-item-btn" title="Remove"><i class="fa fa-times-circle"></i></a></td>' +
                        '</tr>'
                }

            })
            if (same_item == true) {
                //alert('You have already taken some of the selected items.' )
                e.stopImmediatePropagation();
                return false
            }
            $('#requsition_items').append(rows)
            $('.sl-td').each(function(index, elem) {
                $(elem).text(index + 1)
            })
            $('#purchase_order_entry_modal').modal('hide')

        })

        $(document).on('click', '#add_item_btn', function(e) {
            e.preventDefault()
            var item_id = $('#item_id_hidden').val()
            var item_name = $('#item_name').val()
            var item_code = $('#item_code').val()
            var item_id_hidden = $('#item_id_hidden').val()
            var item_uom_name = $('#item_uom').val()
            var item_uom_no = $('#item_uom_hidden').val()
            var item_quantity = $('#item_quantity').val()
            var item_price = $('#item_price').val()
            var sales_uom = $("#item_sales_uom").val();
            var item_conversion = $("#item_conversion").val();

            if (item_id == '' || item_name == '') {
                alert('Item name cannot be blank.')
                e.stopImmediatePropagation();
                return false
            }
            var same_item = false
            $('input[class=same-item-id]').each(function(index, elem) {
                if ($(elem).val() == item_id) {
                    same_item = true
                    return false
                }
            })
            if (same_item == true) {
                alert('You have already taken this item.')
                $('#item_id').val('')
                $('#item_code').val('')
                $('#item_name').val('')
                $('#item_id_hidden').val('')
                $('#item_uom').val('')
                $('#item_uom_hidden').val('')
                $('#item_quantity').val(0)
                $('#item_price').val(0)
                $("#item_conversion").val('')
                $("#item_sales_uom").val('')
                e.stopImmediatePropagation();
                return false
            }

            var total = item_price * item_quantity;
            // var row = '<tr>' +
            //     '<td class="text-center sl-td">0</td>' +
            //     '<td class="text-left"> <input type="hidden" name="item_id[]" value="' + item_id +
            //     '">' + item_code + '</td><input type="hidden" name="item_name_arr[]" value="' +
            //     item_name +
            //     '"></td>' +
            //     '<td class="text-left"> <input type="hidden" class="same-item-id" name="item_ids[]" value="' +
            //     item_id + '">' + item_name + '</td>' +
            //     '<td class="text-left"> <input type="hidden" name="item_uoms[]" value="' + item_uom_no +
            //     '">' + item_uom_name + '</td>' +
            //     '<td class="text-right"> <input class="item-rate text-right number_only" onkeyup="test(this)" min="0" type="text" name="item_rates[]" value="' +
            //     item_price + '"></td>' +
            //     '<td class="text-right"> <input class="item-qty text-right number_only" onkeyup="test(this)" min="0" type="text" name="item_quantities[]" value="' +
            //     item_quantity + '"><input type="hidden" class="total_price" value="' + total +
            //     '"><input type="hidden" name="sales_uom[]" class="sales_uom" value="' + sales_uom +
            //     '"><input type="hidden" name="item_conversion[]" class="item_conversion" value="' +
            //     item_conversion + '"></td>' +
            //     '<td class="text-right"> <input class="item-qty text-right number_only" onkeyup="test(this)" min="0"type="text" name="item_app_quantities[]"></td><td> <a href="javascript:void(0)" class="btn btn-sm btn-danger remove-item-btn" title="Remove"><i class="fa fa-times-circle"></i></a></td>' +
            //     '</tr>'
            var row = '<tr>' +
                '<td class="text-center sl-td">0</td>' +
                '<td class="text-left"> <input type="hidden" name="item_id[]" value="' + item_id +
                '">' + item_code + '</td><input type="hidden" name="item_name_arr[]" value="' +
                item_name +
                '"></td>' +
                '<td class="text-left"> <input type="hidden" class="same-item-id" name="item_ids[]" value="' +
                item_id + '">' + item_name + '</td>' +
                '<td class="text-left"> <input type="hidden" name="item_uoms[]" value="' + item_uom_no +
                '">' + item_uom_name + '</td>' +
                '<td class="text-right"> <input class="item-qty text-right number_only" onkeyup="test(this)" min="0" type="text" name="item_quantities[]" value="' +
                item_quantity + '"><input type="hidden" class="total_price" value="' + total +
                '"><input type="hidden" name="sales_uom[]" class="sales_uom" value="' + sales_uom +
                '"><input type="hidden" name="item_conversion[]" class="item_conversion" value="' +
                item_conversion + '"></td>' +
                '<td> <a href="javascript:void(0)" class="btn btn-sm btn-danger remove-item-btn" title="Remove"><i class="fa fa-times-circle"></i></a></td>' +
                '</tr>'
            // $('#requsition_items').append(row)
            if ($("#requsition_items tr").length > 0) {
                $('#requsition_items tr:last').after(row);
            } else {
                $('#requsition_items').append(row);
            }
            // $('#requsition_items tr:last').after(row);
            $('#item_id').val('')
            $('#item_name').val('')
            $('#item_code').val('')
            $('#item_id_hidden').val('')
            $('#item_uom').val('')
            $('#item_conversion').val('')
            $('#item_uom_hidden').val('')
            $('#item_quantity').val(0)
            $('#item_price').val(0)
            $("#item_conversion").val('')
            $("#item_sales_uom").val('')
            $('#item_name').focus()
            poItemCalculateTotal1(this);
            $('.sl-td').each(function(index, elem) {
                $(elem).text(index + 1)
            })
            e.stopImmediatePropagation();
        })





        $(document).on('click', '.remove-item-btn', function() {
            $(this).closest('tr').remove()
            $('.sl-td').each(function(index, elem) {
                $(elem).text(index + 1)
            })
            poItemCalculateTotal1(this);
        })

        $(document).on('change', '#item_category_popup', function(e) {
            e.preventDefault()

            $.ajax({
                data: {
                    search_category: true,
                    category: $(this).val()
                },
                dataType: "html",
                url: "{{ route('inventory.default_supplier_items') }}",
                type: "post",
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {
                    $("#demand_entry_modal #crl").html(data);
                    $('#demand_entry_modal #crl .data-table').DataTable({
                        "ordering": false,
                        "bPaginate": false,
                        "bLengthChange": false,
                        "bAutoWidth": false
                    });
                },
                complete: function() {
                    $.unblockUI();
                }
            });

            e.stopImmediatePropagation();
        })

        /*$(document).on('change', '.min-zero', function (e) {
         e.preventDefault()
         if ($(this).val() < 0) {
         $(this).val(0)
         }
         e.stopImmediatePropagation();
         })*/


    })
</script>

<script type="text/javascript">
    $(document).on('change', '#checked_all', function() {
        $('.selected-default-item').prop('checked', this.checked);
    });

    $(document).on('change', '.selected-default-item', function() {
        if ($('.selected-default-item:checked').length == $('.selected-default-item').length) {
            $('#purchase_order_entry_modal #checked_all').prop('checked', true);
        } else {
            $('#purchase_order_entry_modal #checked_all').prop('checked', false);
        }
    });
</script>
