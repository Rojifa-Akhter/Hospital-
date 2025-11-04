<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('css/colors.css') }}">
@php
$purchase_date = isset($po_master_info) ? $po_master_info->purchase_date : date('d-m-Y');
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
            <h5 class="mt-2 mb-0">Pharmacy Create Purchase Order</h5>
            <small>Purchase Order Entry</small>
        </div>
        <div class="col-md-3 mt-2">
            <div id="top-action">

                <a rel="tab" href="{{ route('pharmacy.item_po_worklist') }}" class="btn btn-outline-primary btn-md float-right"><i class="fa fa-desktop"></i>&nbsp;Purchase Order
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
                            <h5>Purchase Order</h5>
                        </div>

                        <div class="card-body mt-2">
                            <!-- <form action="{{ route('inventory.store_purchase_order') }}" id="store_demand_items" method="post"> -->
                            <form action="{{ route('inventory.store_purchase_order') }}" id="store_purchase_order" method="post">
                                <input type="hidden" name="module_code" class="keep_me" value="PHR">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-row justify-content-center">
                                            <div class="form-group  col-md-2">
                                                <label class="col-form-label col-form-label-sm" for="date">Ref No
                                                </label>
                                                <input type="text" class="form-control form-control-sm m-0 " id="ref_no" name="in_refer_no" value="">
                                            </div>


                                            <div class="form-group col-md-10">
                                                <label for="supplier_id" class="col-form-label col-form-label-sm">Subject </label>
                                                <input type="text" class="form-control form-control-sm m-0 " id="in_refer_sub" name="in_refer_sub" value="">
                                            </div>

                                        </div>
                                        <div class="form-row justify-content-center">
                                            <div class="form-group  col-md-2">
                                                <label class="col-form-label col-form-label-sm" for="date">Date
                                                    <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control form-control-sm m-0 date_picker" id="date" name="date" value="{{ date('d-m-Y', strtotime($purchase_date)) }}" placeholder="dd-mm-yyyy">

                                                <input type="hidden" name="hdn_po_no" value="{{ isset($po_master_info) && !empty($po_master_info) ? $po_master_info->purchaseorder_no_pk : '' }}">
                                                <input type="hidden" name="po_edit_ind" value="{{ isset($po_child_details_info) && !empty($po_child_details_info) ? 1 : '' }}">
                                            </div>


                                            <div class="form-group col-md-2">
                                                <label for="supplier_id" class="col-form-label col-form-label-sm">Select
                                                    Supplier <span class="text-danger">*</span></label>
                                                <select class="form-control select2" id="supplier_id" name="supplier_id">
                                                    @php
                                                    $sup_name = isset($po_master_info) && !empty($po_master_info) ? $po_master_info->supplier_no_pk : '';
                                                    @endphp
                                                    <option value="">Select Supplier</option>
                                                    @if (!empty($supplier_arr))
                                                    @foreach ($supplier_arr as $key => $ic)
                                                    <option value="{{ $key }}" @if ($key==$sup_name) selected @endif>
                                                        {{ $ic }}
                                                    </option>
                                                    @endforeach
                                                    @endif


                                                </select>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-4">

                                                <div class="btn-group" role="group" style="width: 100%;">

                                                    <a href="javascript:void(0)" id="default_item" class="btn btn-success btn-block btn-md mt-4 popup-items">Default</a>

                                                    <a href="javascript:void (0)" id="last_purchase_order_item" class="btn btn-info btn-block btn-md mt-4 popup-items">Last
                                                        Purchase Order</a>

                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-row">
                                            <div class="form-group col-md-1">
                                                <label class="col-form-label col-form-label-sm" for="pvms_no" width="7%">Item
                                                    Code</label>
                                                <!--  <input type="text" class="form-control form-control-sm m-0" id="item_id" name="item_id" value="" placeholder="Item ID" > -->
                                                <input type="text" class="form-control form-control-sm m-0" id="item_code" name="item_code" value="" placeholder="Item Code" autocomplete="off">
                                            </div>

                                            <div class="form-group col-md-2">
                                                <label class="col-form-label col-form-label-sm" for="item_name" width="10%">Item
                                                    Name</label><span class="btn btn-sm btn-success float-right open-modal" data-modal="common-modal-md" data-action="{{ route('item.create-quick-item-po') }}" data-title="Create New Item">Create Item
                                                </span>
                                                <input type="hidden" name="item_id_hidden" id="item_id_hidden">
                                                <table width="100%">
                                                    <tr>
                                                        <td style="border: none"> <input type="text" class="form-control form-control-sm m-0" id="item_name" name="item_name" value="" placeholder="Item Name" autocomplete="off"></td>
                                                        <td style="border: none;text-align:right" id="item_info"></td>
                                                    </tr>
                                                </table>


                                            </div>
                                            <div class="form-group col-md-1">
                                                <label class="col-form-label col-form-label-sm" for="item_uom" width="5%">Item
                                                    UoM</label>
                                                <input type="hidden" name="item_uom_hidden" id="item_uom_hidden">
                                                <input type="hidden" name="item_sales_uom" id="item_sales_uom">
                                                <input type="text" class="form-control form-control-sm m-0" id="item_uom" name="item_uom" value="" placeholder="Item UoM" readonly>
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label class="col-form-label col-form-label-sm" for="item_uom" width="5%">Item
                                                    Conversion</label>

                                                <input type="text" class="form-control form-control-sm m-0" id="item_conversion" name="item_conversion" value="" placeholder="Item Conversion">
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label class="col-form-label col-form-label-sm" for="item_price" width="5%">Purchase Price</label>
                                                <input type="text" class="form-control form-control-sm m-0 text-right number_only" id="item_price" name="item_price" value="0" placeholder="Item Price">
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label class="col-form-label col-form-label-sm" for="item_quantity" width="5%">Item
                                                    Quantity</label>
                                                <input type="text" class="form-control form-control-sm m-0 text-right number_only" id="item_quantity" name="item_quantity" value="0" placeholder="Item Quantity">
                                            </div>

                                            <input type="hidden" name="vat_percent_itm" id="vat_percent_itm">

                                            <div class="form-group col-md-2">
                                                <button type="button" id="add_item_btn" width="10%" class="btn btn-success btn-block btn-md mt-4"><i class="fa fa-plus"></i> Add Item</button>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 table-responsive mt-3">
                                        <table class="table  table-striped table-bordered table-hover ">
                                            <thead class="bg-primary">
                                                <tr>
                                                    <th class="text-center" width="5%">SL</th>
                                                    <th class="text-center" width="7%">Item No</th>
                                                    {{-- <th class="text-center">Barcode</th> --}}
                                                    <th class="text-center" width="10%">Item Name</th>
                                                    <th class="text-center" width="5%">UoM</th>
                                                    <th class="text-center" width="5%">Box Quantity</th>
                                                    <th class="text-center " width="5%">Rate</th>
                                                    <th class="text-center " width="5%">Item Quantity</th>
                                                    <th class="text-center " width="5%">Item Amount</th>
                                                    <th class="text-center " width="5%">Vat(%)</th>
                                                    <th class="text-center " width="5%">Vat Amount</th>
                                                    <th class="text-center " width="5%">Discount(%)</th>
                                                    <th class="text-center " width="5%">Discount Amount</th>
                                                    {{-- <th class="text-right width-100">Amount</th> --}}
                                                    <th class="text-center " width="5%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="demand_items_vat_n_dis">

                                                {{-- for Edit --}}
                                                @php
                                                $total_amount = $rate = $quantity = $total_quantity = $total_payable= $adj_discount = $total_vat_amount = $total_discount_amount =0;
                                                @endphp
                                                @if (isset($po_child_details_info) && !empty($po_child_details_info))
                                                @foreach ($po_child_details_info as $key => $data)
                                                {{-- {{ dd($data) }} --}}
                                                @php
                                                $rate = $data->item_rate != '' ? $data->item_rate : 0;
                                                $quantity = $data->entry_qty != '' ? $data->entry_qty : 0;
                                                $total_amount += $rate * $quantity;
                                                $total_vat_amount += $data->vat_amount_itm;
                                                $total_discount_amount += $data->discount_amount_itm;
                                                @endphp

                                                <tr>
                                                    <td class="text-center sl-td">{{ $loop->iteration }}</td>
                                                    <td class="text-left"> <input type="hidden" name="item_id[]" value="{{ !empty($data->item_no_fk) ? $data->item_no_fk : '' }}">{{ !empty($data->item_code) ? $data->item_code : '' }}
                                                    </td>
                                                    <td class="text-left"> <input type="hidden" class="same-item-id" name="item_ids[]" value="{{ !empty($data->item_no_fk) ? $data->item_no_fk : '' }}">{{ !empty($data->item_name) ? $data->item_name : '' }}
                                                    </td>

                                                    <td class="text-left"> <input type="hidden" name="item_uoms[]" value="{{ !empty($data->uom_no_fk) ? $data->uom_no_fk : '' }}">{{ !empty($data->pr_uom_name) ? $data->pr_uom_name : '' }}
                                                    </td>

                                                    <td class="text-right"> <input class="item-rate text-right number_only" onkeyup="test(this)" min="0" type="text" name="item_rates[]" value="{{ !empty($data->item_rate) ? number_format($data->item_rate,2,'.','') : 0 }}">
                                                    </td>
                                                    <td class="text-right"> <input class="item-qty text-right number_only" onkeyup="test(this)" min="0" type="text" name="item_quantities[]" value="{{ !empty($data->entry_qty) ? $data->entry_qty : 0 }} "><input type="hidden" class="total_price" value="{{ !empty($data->item_rate) ? number_format(($data->item_rate * $data->entry_qty),2,'.','') : 0 }} "><input type="hidden" name="sales_uom[]" class="sales_uom" value="{{ !empty($data->item_sales_uom) ? $data->item_sales_uom : '' }} "><input type="hidden" name="item_conversion[]" class="item_conversion" value="{{ !empty($data->pr_uom_conversion_qty) ? $data->pr_uom_conversion_qty : 0 }}">
                                                    </td>
                                                    <td class="text-right"> <input class="item-rate text-right number_only" min="0" type="text" name="item_amount[]" value="{{ !empty($data->item_rate) ? number_format(($data->item_rate * $data->entry_qty),2,'.','') : 0 }} ">
                                                    </td>
                                                    <td class="text-right"> <input class="item_vat text-right number_only" onkeyup="CalculatePerItemVat(this)" id="item_vat" min="0" type="text" name="item_vat[]" value="{{ !empty($data->vat_percent_itm) ? $data->vat_percent_itm : 0 }}">
                                                    </td>

                                                    <td class="text-right"> <input class="vat_amount  text-right number_only" min="0" id="vat_amount" type="text" name="vat_amount[]" value="{{ !empty($data->vat_amount_itm) ? number_format($data->vat_amount_itm , 2,'.',''): 0 }}">
                                                    </td>
                                                    <td class="text-right"> <input class="item_discount text-right number_only" onkeyup="CalculatePerItemDiscount(this)" min="0" id="item_discount" type="text" name="item_discount[]" value="{{ !empty($data->discount_percent_itm) ? $data->discount_percent_itm : 0 }}">
                                                    </td>
                                                    <td class="text-right"> <input class="discount_amount text-right number_only" onkeyup="CalculatePerItemDiscountAmount(this)" min="0" id="discount_amount" type="text" name="discount_amount[]" value="{{ !empty($data->discount_amount_itm) ? number_format($data->discount_amount_itm,2,'.','') : 0 }}">
                                                    </td>
                                                    <td> <a href="javascript:void(0)" class="btn btn-sm btn-danger remove-item-btn" title="Remove"><i class="fa fa-times-circle"></i></a></td>
                                                </tr>
                                                @endforeach

                                                @endif

                                                {{-- End --}}

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                @php
                                $total_payable = ($total_amount + $total_vat_amount) - $total_discount_amount;
                                $adj_discount = $total_payable - floor($total_payable);

                                @endphp
                                <div class="row">
                                    <div class="col-12 table-responsive mt-3">
                                        <table class="table  table-striped table-bordered table-hover">
                                            <thead class="bg-primary">
                                                <tr>
                                                    <th class="text-center ">Select</th>
                                                    <th class="text-center">Terms & Conditions</th>
                                                </tr>
                                            </thead>
                                            <tbody id="">
                                                @if (!empty($poTerms))
                                                @foreach ($poTerms as $termId => $terms)
                                                <tr>
                                                    <td><input type="checkbox" name="termsid[]" value="{{ $termId }}" {{ $termId == '1' ? 'checked' : '' }}></td>
                                                    <td class="text-left">{{ $terms }}</td>
                                                    <input type="hidden" value="{{ $terms }}" name="terms_text_{{ $termId }}">
                                                </tr>
                                                @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="form-row justify-content-end">

                                    <div class="col-md-4  mt-2">
                                        <ul class="list-group bg-light-blue list-group-flush bg-light-blue rounded mb-2 border">
                                            <li class="list-group-item">
                                                <h5 class="float-left mr-2">Total Amount</h5>
                                                {{-- <span class="float-right btn btn-outline-danger bg-none btn-md"
                                                    id="item_total"> 0</span> --}}
                                                <input type="text" class="form-control float-right number_only " id="item_total" name="item_total" style="width:80px; text-align: right;" value="{{ number_format($total_amount, 2,'.','') }}" readonly="readonly">

                                            </li>
                                            <li class="list-group-item">
                                                <div class="form-row">
                                                    <div class="col-md-6">
                                                        <span class="mr-2 float-left d-none">Service Charge</span>
                                                        <div class="float-left d-none">
                                                            <input type="text" class="form-control mb-0" id="s_charge" name="s_charge" value="" placeholder="0.00" readonly="readonly" onkeyup="poItemCalculateTotal(this)" style="width: 70px; text-align: right;">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 text-right">
                                                        <span class="mr-2 ">VAT/Tax</span>
                                                        <div class="float-right">
                                                            <input type="text" class="form-control float-right number_only" id="total_vat_amount" name="total_vat_amount" value="{{ number_format($total_vat_amount,2,'.','') }}" onkeyup="poItemCalculateTotal1(this)" placeholder="0.00" style="width:70px; text-align: right;" maxlength="8">

                                                            <input type="text" class="form-control float-right number_only" id="vat_percent" name="vat_percent" placeholder="%" style="width:50px; text-align: right;" onkeyup="poItemCalculateTotal1(this)" value="0">
                                                            (%)
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="form-row">
                                                    <div class="col-md-6">
                                                    </div>
                                                    <div class="col-md-6 text-right">
                                                        <span class="mr-2">Discount</span>
                                                        <div class="float-right">
                                                            <input type="text" class="form-control float-right number_only" id="total_discount_amount" name="total_discount_amount" value="{{ number_format($total_discount_amount,2,'.','') }}" onkeyup="poItemCalculateTotal1(this)" placeholder="0.00" style="width:70px; text-align: right;" maxlength="8">

                                                            <input type="text" class="form-control float-right number_only" id="discount_percent" name="discount_percent" placeholder="%" style="width:50px; text-align: right;" onkeyup="poItemCalculateTotal1(this)" value="0">
                                                            (%)
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>

                                            <li class="list-group-item">
                                                <input type="text" class="form-control float-right number_only" id="discount_adj_amt" name="discount_adj_amt" placeholder="0.00" style="width:50px; text-align: right;" value="{{ number_format($adj_discount, 2,'.','') }}" readonly="readonly">
                                                <h5 class="float-right mr-2">
                                                    Discount Adj. Amt. </h5>

                                            </li>

                                            <li class="list-group-item">
                                                <input type="hidden" class="form-control mb-0" id="total_due" name="total_due">

                                                <span class="float-right btn btn-outline-danger bg-none btn-md" id="total_due_data">{{ number_format(($total_payable-$adj_discount), 2,'.','') }} </span>
                                                <h5 class="float-right mr-2">
                                                    Payable Amount </h5>
                                            </li>

                                        </ul>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="custom-box">
                                            <div class="custom-box-body m-0 text-right">

                                                @php
                                                $response_action = route('pharmacy.item_po_worklist');
                                                @endphp

                                                <button type="submit" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')" class="btn btn-md btn-success">Save</button>

                                                {{-- <button type="reset" class="btn btn-info btn-md"
                                                    title="Click here to Clear form data">Clear</button> --}}
                                                <a href="{{ route('admin-dashboard') }}" class="btn btn-danger btn-md" rel="tab" title="Click here to go back to Dashboard">Exit</a>
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
                <button type="button" data-dismiss="modal" onclick="setFormLastPurchase()" class="btn btn-primary">Set
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
        if ($("#demand_items_vat_n_dis tr").length > 0) {

            $("#demand_items_vat_n_dis tr").each(function() {
                var qty = $(this).find(".item-qty").val() * 1;
                var price = $(this).find(".item-rate").val() * 1;
                var total = parseFloat(qty * price).toFixed(2);
                $(this).find(".total_price").val(total);
                $(this).find(".item_amount").val(total);
            });
            var vat_percent_element = $(thisElement).parents('td').siblings().find(".item_vat")[0];
            var discount_element = $(thisElement).parents('td').siblings().find(".discount_amount")[0];
            console.log(vat_percent_element, discount_element);

            CalculatePerItemVat(vat_percent_element);
            //CalculatePerItemDiscount(vat_percent_element);
            CalculatePerItemDiscountAmount(discount_element);


            //console.log(vat_percent_element+'_bellal'+  $(thisElement).val());
        }
        poItemCalculateTotal1(this);


    }

    function CalculatePerItemVat(thisElement) {

        if ($("#demand_items_vat_n_dis tr").length > 0) {

            var qty = $(thisElement).parents('td').siblings().find(".item-qty").val() * 1;
            console.log(qty + '_bellal')
            var price = $(thisElement).parents('td').siblings().find(".item-rate").val() * 1;
            var total = qty * price;
            var vat = $(thisElement).val();
            var vat_amount = parseFloat(total * (vat / 100)).toFixed(2);
            console.log(vat_amount)

            $(thisElement).parents('td').siblings().find('.vat_amount').val(vat_amount);

            var total_vat = 0;
            var item_total = 0;
            var total_discount = 0;
            $("#demand_items_vat_n_dis tr").each(function() {

                total_vat += $(this).children('td').siblings().find(".vat_amount").val() * 1;
                item_total += $(this).find(".total_price").val() * 1;
                total_discount += $(this).children('td').siblings().find(".discount_amount").val() * 1;



                //     var qty = $(this).find(".item-qty").val() * 1;
                //     var price = $(this).find(".item-rate").val() * 1;
                //    var total = qty * price;
                //    var vat = $(thisElement).val();
                //    var vat_amount = parseFloat(total*(vat/100)).toFixed(2);
                //    console.log(vat_amount)

                //  $('.vat_amount').val(vat_amount);
                //    $('.vat_amount').val('');
                //    $('.item-qty').val('');
                //    $('.item-rate').val('');
                // alert(total)
                // alert(price);
                // $(this).find(".total_price").val(total);

            });
            $('#total_vat_amount').val(total_vat.toFixed(2));
            console.log(total_vat + '_total_vat')
            // $("#total_due_data").html(Math.floor((item_total + total_vat) - total_discount).toFixed(2));
            poItemCalculateTotal1(this);


        }
    }

    function CalculatePerItemDiscount(thisElement) {
        if ($("#demand_items_vat_n_dis tr").length > 0) {

            var qty = $(thisElement).parents('td').siblings().find(".item-qty").val() * 1;
            console.log(qty + '_bellal')
            var price = $(thisElement).parents('td').siblings().find(".item-rate").val() * 1;
            var total = qty * price;
            var discount = $(thisElement).val();
            var discount_amount = parseFloat(total * (discount / 100)).toFixed(2);
            console.log(discount_amount)

            $(thisElement).parents('td').siblings().find('.discount_amount').val(discount_amount);

            var total_discount = 0;
            var item_total = 0;
            var total_vat = 0;
            $("#demand_items_vat_n_dis tr").each(function() {

                total_discount += $(this).children('td').siblings().find(".discount_amount").val() * 1;
                item_total += $(this).find(".total_price").val() * 1;
                total_vat += $(this).children('td').siblings().find(".vat_amount").val() * 1;

                //     var qty = $(this).find(".item-qty").val() * 1;
                //     var price = $(this).find(".item-rate").val() * 1;
                //    var total = qty * price;
                //    var vat = $(thisElement).val();
                //    var vat_amount = parseFloat(total*(vat/100)).toFixed(2);
                //    console.log(vat_amount)

                //  $('.vat_amount').val(vat_amount);
                //    $('.vat_amount').val('');
                //    $('.item-qty').val('');
                //    $('.item-rate').val('');
                // alert(total)
                // alert(price);
                // $(this).find(".total_price").val(total);

            });


            console.log('total_discount_test' + total_discount);
            // console.log('item_total_test'+item_total);
            $('#total_discount_amount').val(total_discount.toFixed(2));
            //  console.log(total_vat+'_total_vat')
            $("#total_due_data").html(Math.floor((item_total + total_vat) - total_discount).toFixed(2));


        }
    }

    function CalculatePerItemDiscountAmount(thisElement) {
        if ($("#demand_items_vat_n_dis tr").length > 0) {

            // var qty = $(thisElement).parents('td').siblings().find(".item-qty").val() * 1;
            // console.log(qty + '_bellal')
            // var price = $(thisElement).parents('td').siblings().find(".item-rate").val() * 1;
            // var total = qty * price;
            // var discount = $(thisElement).val();
            // var discount_amount = parseFloat(total * (discount / 100)).toFixed(2);
            // console.log(discount_amount)

            //$(thisElement).parents('td').siblings().find('.discount_amount').val(discount_amount);

            var total_discount = 0;
            var item_total = 0;
            var total_vat = 0;
            $("#demand_items_vat_n_dis tr").each(function() {

                total_discount += $(this).children('td').siblings().find(".discount_amount").val() * 1;
                item_total += $(this).find(".total_price").val() * 1;
                total_vat += $(this).children('td').siblings().find(".vat_amount").val() * 1;

                //     var qty = $(this).find(".item-qty").val() * 1;
                //     var price = $(this).find(".item-rate").val() * 1;
                //    var total = qty * price;
                //    var vat = $(thisElement).val();
                //    var vat_amount = parseFloat(total*(vat/100)).toFixed(2);
                //    console.log(vat_amount)

                //  $('.vat_amount').val(vat_amount);
                //    $('.vat_amount').val('');
                //    $('.item-qty').val('');
                //    $('.item-rate').val('');
                // alert(total)
                // alert(price);
                // $(this).find(".total_price").val(total);

            });


            console.log('total_discount_test' + total_discount);
            // console.log('item_total_test'+item_total);
            $('#total_discount_amount').val(total_discount.toFixed(2));
            //  console.log(total_vat+'_total_vat')
            // $("#total_due_data").html(Math.floor((item_total + total_vat) - total_discount).toFixed(2));
            poItemCalculateTotal1(this);
        }
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
        var item_vat = 0;
        if ($("#demand_items_vat_n_dis tr").length == 0) {
            alert("Please add one item");
            return;
        } else {
            $("#demand_items_vat_n_dis tr").each(function() {
                item_total += $(this).find(".total_price").val() * 1;
                item_vat += $(this).find(".vat_amount").val() * 1;
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
        var item_vat = 0;
        // var urgent_fee = urgent_fee_total;

        if ($("#demand_items_vat_n_dis tr").length > 0) {
            $("#demand_items_vat_n_dis tr").each(function() {
                // console.log('database test '+ $(this).find(".total_price").val())
                var price = $(this).find(".total_price").val() * 1;
                // if(typeof price )
                if (price != NaN) {
                    item_total += $(this).find(".total_price").val() * 1;
                    item_vat += $(this).find(".vat_amount").val() * 1;
                }

            });
            $("#item_total").val(item_total.toFixed(2));
            $("#total_vat_amount").val(item_vat.toFixed(2));
            $("#total_payable").val((item_total + urgent_fee).toFixed(2));

            var vat_percent = $("#vat_percent").val() * 1;
            console.log(item_total, 'dd');
            var total_vat_amount = 0;
            //console.log('disc', vat_percent);
            if (vat_percent != 0) {
                total_vat_amount = (item_total * vat_percent) / 100;
                $("#total_vat_amount").val(total_vat_amount.toFixed(2));
                final_total = item_total;
            } else {
                var vat_amount = parseFloat($("#total_vat_amount").val() * 1);
                if (vat_amount != 0) {
                    total_vat_amount = (vat_amount / item_total) * 100;
                    console.log(total_vat_amount, vat_amount, item_total, 'ttt');
                    // $("#vat_percent").val(total_vat_amount.toFixed(2));

                }
                final_total = item_total;
            }
            console.log('Anik', final_total, total_vat_amount, total_discount_amount + '_dis_' + vat_amount);
            var discount_percent = $("#discount_percent").val() * 1;
            var total_discount_amount = 0;
            // console.log('disc', vat_percent);
            if (discount_percent != 0) {
                var vat_amount = parseFloat($("#total_vat_amount").val() * 1);
                total_discount_amount = (item_total * discount_percent) / 100;
                $("#total_discount_amount").val(total_discount_amount.toFixed(2));
                final_total = final_total;
            } else {
                var vat_amount = parseFloat($("#total_vat_amount").val() * 1);
                if ($("#total_discount_amount").val() != 0) {
                    total_discount_amount = parseFloat($("#total_discount_amount").val() * 1); //parseFloat( (vat_amount / item_total) * 100);

                    // $("#discount_percent").val(total_discount_amount.toFixed(2));

                }
                final_total = final_total;
            }

            console.log(final_total, total_discount_amount + '_dis_' + vat_amount);

            var total_final = (final_total - total_discount_amount) + vat_amount;

            $("#total_due_data").html(Math.floor(total_final).toFixed(2));
            $("#discount_adj_amt").val((total_final - Math.floor(total_final)).toFixed(2));

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



        openReceiveItemAutocomplete('#pvms_no', 'pvms_no', function(item, obj) {
            $('#item_id_hidden').val(item.item_id);
            $('#item_uom_hidden').val(item.uom_no_fk);
            $('#item_uom').val(item.uom_name);
            $('#item_name').val(item.item_name);
            $("#item_price").val(item.item_rate);

            obj.stopImmediatePropagation();
        });

        pharmacy_autocomplete_iteminfo_by_item_name('#item_name', 'item_name', function(item, obj) {
            console.log(item);
            $('#item_code').val(item.item_code);
            $('#item_id_hidden').val(item.item_id);
            $('#item_uom_hidden').val(item.uom_no_fk);
            $('#item_uom').val(item.pr_uom_name);
            $("#item_price").val(item.purchase_price);
            $('#item_conversion').val(item.pr_uom_conversion_qty);
            $('#item_sales_uom').val(item.item_sales_uom);
            $('#vat_percent_itm').val(item.vat_percent);
            // $('#supplier_id').val(item.manufacturer_no_fk).trigger('change');
            var edit_action = "{{ route('item.edit-quick-item-po', ':id') }}";
            edit_action = edit_action.replace(':id', item.item_id);
            $('#item_info').html(
                `<span class="p-0 m-0 btn btn-sm btn-primary open-modal" data-id="${item.item_id}" data-action="${edit_action}" data-modal="common-modal-md" data-title="Edit Item" title="Edit"><i class="fa fa-pencil-alt"></i></span>`
            )
            // $('#pvms_no').val(item.pvms_no);
            obj.stopImmediatePropagation();
        });

        pharmacy_autocomplete_iteminfo_by_item_code('#item_code', 'item_code', function(item, obj) {
            $('#item_code').val(item.item_code);
            $('#item_name').val(item.item_name);
            $('#item_id_hidden').val(item.item_id);
            $('#item_uom_hidden').val(item.uom_no_fk);
            $('#item_uom').val(item.uom_name);
            $("#item_price").val(item.purchase_price);
            $('#item_conversion').val(item.pr_uom_conversion_qty);

            // $('#pvms_no').val(item.pvms_no);
            var edit_action = "{{ route('item.edit-quick-item-po', ': id') }}";
            edit_action = edit_action.replace(':id', item.item_id);
            $('#item_info').html(
                `<span class="p-0 m-0 btn btn-sm btn-primary open-modal" data-id="${item.item_id}" data-action="${edit_action}" data-modal="common-modal-md" data-title="Edit Item" title="Edit"><i class="fa fa-pencil-alt"></i></span>`
            )
            obj.stopImmediatePropagation();
        });


        $(document).on('click', '#default_item', function(e) {
            e.preventDefault()
            var supplier_id = $('#supplier_id').val()

            var id_val = $(this).attr('id')

            if (supplier_id == "") {
                alert('Please, select supplier.')
                return false
            }

            var suppliers = []
            "<?php foreach ($supplier_arr as $key => $ic) : ?>"
            suppliers.push("<?php echo $ic; ?>")
            "<?php endforeach; ?>"

            $.ajax({
                async: true,
                data: {
                    supplier_id: $('#supplier_id').val(),
                    item_suppliers: suppliers,
                },
                dataType: "html",
                url: "{{ route('pharmacy.default_supplier_items') }}",
                type: 'post',
                beforeSend: function() {
                    if (isAModalOpen)
                        $('.modal').modal('hide');
                    blockUI();
                    $('.data-table').DataTable().clear().destroy();
                },
                success: function(data) {

                    //alert(data);

                    $('.modal-body2').html(data)
                    //$('#demand_entry_modal').modal('show')
                    $('#purchase_order_entry_modal').modal('show')
                    $('.data-table').DataTable({
                        "ordering": false,
                        "bPaginate": false,
                        "bLengthChange": false,
                        "bAutoWidth": false
                    });

                },
                complete: function() {
                    $.unblockUI();
                },
                error: function(data) {
                    $.unblockUI();
                }
            })
            e.stopImmediatePropagation();

        })

        $(document).on('click', '#last_purchase_order_item', function(e) {
            e.preventDefault()
            $('#demand_items_vat_n_dis').html("");
            var supplier_id = $('#supplier_id').val();


            if (supplier_id == '') {
                alert('Please, select supplier.')
                e.stopImmediatePropagation();
                return false
            }
            $.ajax({
                async: true,
                data: {
                    supplier_id: supplier_id
                },
                dataType: "html",
                url: "{{ route('pharmacy.last_supplier_purchase_order_items') }}",
                type: 'post',
                beforeSend: function() {
                    $('.data-table').DataTable().clear().destroy();
                    if (isAModalOpen)
                        $('.modal').modal('hide');
                    blockUI();
                },
                success: function(data) {

                    console.log(data);
                    var rows = '';
                    $('.modal-body1').html(data)
                    //$('#last_purchase_order_entry_modal_body').html(data)
                    //$('#demand_entry_modal').modal('show')
                    $('#last_purchase_order_entry_modal').modal('show')
                    $('.data-table').DataTable({
                        "ordering": false,
                        "bPaginate": false,
                        "bLengthChange": false,
                        "bAutoWidth": false
                    });

                },
                complete: function() {
                    $.unblockUI();
                },
                error: function(data) {
                    // var errors = jQuery.parseJSON(data.responseText).errors;
                    // error_messages = "";
                    // for (messages in errors) {
                    //     var field_name = $("#" + messages).siblings("label").html();
                    //     error_messages += "<div class='alert alert-danger' role='alert'>" +
                    //         errors[messages] + "</div>";
                    // }

                    // $('.common-modal-notify-error').modal('show');
                    // $('.common-modal-notify-error .modal-title').html("Validation Error");
                    // $('.common-modal-notify-error .modal-body').html(error_messages);

                    $.unblockUI();
                }
            });
            e.stopImmediatePropagation();

        })

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
            $('#demand_items_vat_n_dis').append(rows)
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
            console.log('test item price ' + item_price + 'test qty' + item_quantity);
            var sales_uom = $("#item_sales_uom").val();
            var item_conversion = $("#item_conversion").val();
            var item_vat = $("#vat_percent_itm").val();
            console.log(item_vat, item_price, item_quantity + '_bellal_vat');
            var total = parseFloat(item_price * item_quantity).toFixed(2);
            var vat_amount = 0;
            if (item_vat != null) {
                var total = item_quantity * item_price;
                var vat_amount = parseFloat(total * (item_vat / 100)).toFixed(2);
            }




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
            var row = '<tr>' +
                '<td class="text-center sl-td">0</td>' +
                '<td class="text-left"> <input type="hidden" name="item_id[]" value="' + item_id +
                '">' + item_code + '</td>' +
                '<td class="text-left"> <input type="hidden" class="same-item-id" name="item_ids[]" value="' +
                item_id + '">' + item_name + '</td>' +
                '<td class="text-left"> <input type="hidden" name="item_uoms[]" value="' +
                item_uom_no +
                '">' + item_uom_name + '</td>' +
                '<td class="text-right"> <input class="item-rate text-right number_only" onkeyup="test(this)" min="0" type="text" name="item_rates[]" value="' +
                item_price + '"></td>' +
                '<td class="text-right"> <input class="item-qty text-right number_only" onkeyup="test(this)" min="0" type="text" name="item_quantities[]" value="' +
                item_quantity + '"><input type="hidden" class="total_price" value="' + total +
                '"><input type="hidden" name="sales_uom[]" class="sales_uom" value="' + sales_uom +
                '"><input type="hidden" name="item_conversion[]" class="item_conversion" value="' +
                item_conversion + '"></td>' +
                '<td class="text-right"> <input class="item_amount text-right number_only" id="item_amount" onkeyup="" min="0" type="text" name="item_amount[]" value="' +
                total + '"></td></td>' +
                '<td class="text-right"> <input class="item_vat text-right number_only" id="item_vat" onkeyup="CalculatePerItemVat(this)" min="0" type="text" name="item_vat[]" value="' +
                item_vat +
                '"></td>' +
                '<td class="text-right"> <input class="vat_amount text-right number_only" id="vat_amount"   type="text" name="vat_amount[]" value="' +
                vat_amount + '"></td>' +
                '<td class="text-right"> <input class="item_discount text-right number_only" id="item_discount" onkeyup="CalculatePerItemDiscount(this)" min="0" type="text" name="item_discount[]" value=""></td>' +
                '<td class="text-right"> <input class="discount_amount text-right number_only" id="dicount_amount"  min="0" type="text" onkeyup="CalculatePerItemDiscountAmount(this)" name="discount_amount[]" value=""></td>' +
                '<td> <a href="javascript:void(0)" class="btn btn-sm btn-danger remove-item-btn" title="Remove"><i class="fa fa-times-circle"></i></a></td>' +
                '</tr>'
            // $('#demand_items').append(row)
            if ($("#demand_items_vat_n_dis tr").length > 0) {
                $('#demand_items_vat_n_dis tr:last').after(row);
            } else {
                $('#demand_items_vat_n_dis').append(row);
            }
            // $('#demand_items tr:last').after(row);
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
            CalculatePerItemVat(this);
            CalculatePerItemDiscount(this);
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
