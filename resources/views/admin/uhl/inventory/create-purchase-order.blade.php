<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link href="{{ asset('css/redactor.css') }}" rel="stylesheet">
<style type="text/css">
    form .error {
        color: #ff0000;
    }
</style>
@php
$purchase_date = isset($po_master_info) && !empty($po_master_info) ? date('d-m-Y', strtotime($po_master_info->purchase_date)) : date('d-m-Y');
$delivery_date = isset($po_master_info) && !empty($po_master_info) ? date('d-m-Y', strtotime($po_master_info->delivery_date)) : '';
$purchaseorder_no_pk = isset($po_master_info) && !empty($po_master_info) ? $po_master_info->purchaseorder_no_pk : '';
$supplier_no_pk = isset($po_master_info) && !empty($po_master_info) ? $po_master_info->supplier_no_pk : '';
$store_no_fk = isset($po_master_info) && !empty($po_master_info) ? $po_master_info->store_no_fk : '';
$vat_percent = isset($po_master_info) && !empty($po_master_info) ? $po_master_info->vat_percent : 0;
$vat_amount = isset($po_master_info) && !empty($po_master_info) ? $po_master_info->vat_amount : 0;
$discount_percent = isset($po_master_info) && !empty($po_master_info) ? $po_master_info->discount_percent : 0;
$discount_amount = isset($po_master_info) && !empty($po_master_info) ? $po_master_info->discount_amount : 0;
$map_date=isset($po_map) && !empty($po_map) ? $po_map : '';
@endphp

<main id="page-content">

    <form action="{{ route('v1-purchase-order.store') }}" id="create-po" method="post" enctype="multipart/form-data">
        
        @csrf
        <input type="hidden" name="hdn_po_no" value="{{ $purchaseorder_no_pk }}">
        <input type="hidden" name="po_edit_ind" value="{{ $purchaseorder_no_pk != '' ? 1 : '' }}">
        <input type="hidden" name="in_req_saveoption" id="in_req_saveoption">
        <input type="hidden" name="indent_pr" id="indent_pr" value="">
        <input type="hidden" name="delete_pr_item" id="delete_pr_item" value="">
        <input type="hidden" name="delete_pr_item_map" id="delete_pr_item_map" value="{{$map_date}}">


        <section class="paitent__registration_details">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                            <div class="col-md-8">
                                <h5 class="mt-2 mb-0">Inventory Create Purchase Order</h5>
                                <small>Inventory/Purchase Order Entry</small>
                            </div>

                            <div class="col-lg-4 col-md-4">
                                <div class="text-right">

                                    <a href="{{ route('v1-purchase-order.index') }}" rel="tab" class="btn btn-success uhl_common_outline_btn"><i class="fa fa-desktop"></i>&nbsp;Purchase Order Worklist</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="purchase_header">
                                    <h5>Purchase Order</h5>

                                    <div class="form-group form-row">
                                        <label for="" class="col-sm-4 col-form-label">Select Store</label>
                                        <div class="col-sm-8">
                                            <select name="in_store_no_fk" class="form-control" id="main_store_id" style="width: 200px">
                                                {{-- onchange="StoreTermsCon(this)"> --}}
                                                <option value="">Select Store</option>
                                                @if (!empty($main_store_list))
                                                @foreach ($main_store_list as $store)
                                                <option value="{{ $store->serviceunit_no_pk }}" {{ $store_no_fk == $store->serviceunit_no_pk ? 'selected' : '' }}>
                                                    {{ $store->serviceunit_name }}
                                                </option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <button type="button" id="" class="btn btn-success btn-md uhl_common_outline_btn" data-toggle="modal" data-target="#exampleModal">Purchase Application</button>
                                </div>
                            </div>
                            <div class="card-body border-bottom-3">
                                <input type="hidden" name="ref_no" id="ref_info" value="{{ isset($po_master_info->reference_no) ? $po_master_info->reference_no : '' }}">
                                <input type="hidden" name="subject_details" id="subject_info" value="{{ isset($po_master_info->reference_sub) ? $po_master_info->reference_sub : '' }}">
                                <input type="hidden" name="message_body" id="message_info" value="{{ isset($po_master_info->reference_sub_body) ? $po_master_info->reference_sub_body : '' }}">
                                <input type="hidden" name="contact_person" id="contact_person_info" value="{{ isset($po_master_info->refer_contact_name) ? $po_master_info->refer_contact_name : '' }}">
                                <input type="hidden" name="contact_number" id="contact_number_info" value="{{ isset($po_master_info->refer_contact_mobile) ? $po_master_info->refer_contact_mobile : '' }}">
                                <input type="hidden" name="contact_email" id="contact_email_info" value="{{ isset($po_master_info->refer_contact_email) ? $po_master_info->refer_contact_email : '' }}">
                                <input type="hidden" name="quotation_ref" id="quotation_ref_info" value="{{ isset($po_master_info->quotation_ref) ? $po_master_info->quotation_ref : '' }}">
                                <!-- <input type="hidden" name="item_specification" id="item_specification_info" value="{{ isset($po_master_info->refer_item_specification) ? $po_master_info->refer_item_specification : '' }}"> -->
                                <div class="form-row">
                                    <!-- <div class=" col-md-12 col-12">
                                        <div class="form-group form-row">
                                            <label for="requistion_no" class="col-sm-4 col-form-label">Indent
                                                No</label>
                                            <div class="col-sm-8">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="requistion_no"
                                                        placeholder="" aria-label="Recipient's username"
                                                        aria-describedby="basic-addon11" value="" />
                                                    <div class="input-group-append">
                                                        <button class="btn btn-secondary uhl_common_btn btn-md"
                                                            type="button"
                                                            style="height: auto !important;">Search</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->

                                    <div class=" col-md-2 ">
                                        <div class="form-group form-row">
                                            <label for="date" class="col-sm-4 col-form-label"> PO Date<span class="text-danger">*</span> </label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control date_picker" id="date" name="date" required value="{{ $purchase_date }}" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class=" col-md-2 ">
                                        <div class="form-group form-row">
                                            <label for="delivery_date" class="col-sm-5 col-form-label">Delivery Date<span class="text-danger">*</span></label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control date_picker" id="delivery_date" name="delivery_date" value="{{ $delivery_date }}" required/>
                                            </div>
                                        </div>
                                    </div>

                                    <div class=" col-md-5 ">
                                        <div class="form-group form-row">
                                            <label for="supplier_id" class="col-sm-2 col-form-label">Supplier<span class="text-danger">*</span> </label>
                                            <div class="col-sm-10">
                                            <!-- onchange="StoreTermsCon(this)" -->
                                                <select class="form-control select2" id="supplier_id" name="supplier_id" required>
                                                    <option value="">Select One</option>
                                                    @if (!empty($supplier_arr))
                                                    @foreach ($supplier_arr as $key => $ic)
                                                    <option value="{{ $key }}" {{ $supplier_no_pk == $key ? 'selected' : '' }}>
                                                        {{ $ic }}
                                                    </option>
                                                    @endforeach
                                                    @endif

                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class=" col-md-3 " id="set_item_block">
                                        <div class="form-group">
                                            <!-- <div class="btn-group" role="group"> -->
                                            <a href="javascript:void(0)" id="indent_item" class="btn btn-success btn-md  border-0 btn-md-global">P. R</a>
                                            <a href="javascript:void(0)" id="default_item" class="btn btn-success  btn-md uhl_common_btn border-0 btn-md-global">Default</a>
                                            <a href="javascript:void(0)" id="last_purchase_order_item" class="btn btn-info btn-md btn-md-global">Last Purchase
                                                Order</a>
                                            <!-- </div> -->
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row" id="add_item_block">
                                    <div class="form-group col-md-1">
                                        <label class="col-form-label col-form-label-sm" for="item_code">Item
                                            Code</label>
                                        <input type="text" class="form-control form-control-sm" id="item_code" name="" value="" placeholder="" readonly />
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label class="col-form-label col-form-label-sm" for="item_name">
                                            Item Name
                                            <span data-modal="common-modal-md " data-action="{{ route('uhl.uhl-new-item') }}" data-title="Create New Item" class="badge badge-secondary custom_badge  open-modal d-none">Create
                                                Item</span>
                                        </label>
                                        <input type="text" class="form-control form-control-sm" id="item_name" name="" autocomplete="off" />
                                        <input type="hidden" name="item_id_hidden" id="item_id_hidden">
                                    </div>

                                    <div class="form-group col-md-2">
                                        <label class="col-form-label col-form-label-sm" for="item_uom">Item
                                            UoM</label>

                                        <select name="item_uom" id="item_uom" class="form-control form-control-sm" style="min-height: 32px!important" onchange="setConversionQty(this)">
                                            <option value="">Select one</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-1">
                                        <label class="col-form-label col-form-label-sm" for="item_conversion">Item
                                            Con.</label>

                                        <input type="text" class="form-control form-control-sm" id="item_conversion" name="item_conversion" value="" placeholder="" />
                                    </div>

                                    <div class="form-group col-md-2">
                                        <label class="col-form-label col-form-label-sm" for="purchase_price">Purchase
                                            Price</label>
                                        <input type="text" class="form-control form-control-sm text-right" id="purchase_price" name="purchase_price" value="" placeholder="" />
                                        <input type="hidden" class="form-control form-control-sm text-right" id="old_purchase_price" name="old_purchase_price" value="" placeholder="" />
                                    </div>

                                    <div class="form-group col-md-2">
                                        <label class="col-form-label col-form-label-sm" for="item_quantity">Item
                                            Quantity</label>
                                        <input type="text" class="form-control form-control-sm text-right number_only" id="item_quantity" name="item_quantity" value="" placeholder="" />
                                    </div>

                                    <div class="form-group col-md-2">
                                        <input type="hidden" id="lpqty" value="">
                                        <input type="hidden" id="lpd" value="">
                                        <input type="hidden" id="lpp" value="">
                                        <input type="hidden" name="module_code" value="INV" class="keep_me">
                                        <button type="button" id="add_item_btn" class="btn btn-success  btn-md-global mt-4"><i class="fa fa-plus"></i> Add
                                            Item</button>
                                        <button type="button" id="add_item_btn_enable" class="btn btn-success  btn-md-global mt-4 d-none">Enable</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-striped">
                                        <thead class="global-uhl-table-bg">
                                            <tr>
                                                <th>SL</th>
                                                <th>Item No</th>
                                                <th>Item Name</th>
                                                <th>Item specification</th>
                                                <th>UoM</th>
                                                <th>U. Price</th>
                                                <th>L.P. Rate</th>
                                                <th>L.P. Qty</th>
                                                <th>L.P. Date</th>
                                                <th>Item Quantity</th>
                                                <th>Amount</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="demand_items">
                                            @php
                                            $total_amount = $rate = $quantity = $total_quantity = $adj_discount =$rate_dollar= $total_amount_dollar=$vat_amount_dollar=$discount_amount_dollar=$payable_amt_dollar=0;

                                            @endphp
                                            @if (isset($po_child_details_info) && !empty($po_child_details_info))
                                            @foreach ($po_child_details_info as $key => $data)
                                            {{-- {{ dd($data) }} --}}
                                            @php
                                            $rate = $data->item_rate != '' ? $data->item_rate : 0;
                                            $quantity = $data->entry_qty != '' ? $data->entry_qty : 0;
                                            $total_amount += $rate * $quantity;
                                            $adj_discount += $total_amount - abs($total_amount);
                                            $sub_total = $rate * $quantity;
                                            $lpd=$data->lpd !='' ? date('d/m/Y',strtotime($data->lpd)) : '';

                                            if(!empty($filteredArray_dollar)){
                                            $rate_dollar = $data->item_rate != '' && $data->dollar_rate !='' ? $data->item_rate / $data->dollar_rate : 0;
                                            $total_amount_dollar += $rate_dollar * $quantity;
                                            $vat_amount_dollar= $vat_amount / $data->dollar_rate;
                                            $discount_amount_dollar=$discount_amount / $data->dollar_rate;
                                            $payable_amt_dollar = $total_amount_dollar + $vat_amount_dollar - $discount_amount_dollar ;
                                            }

                                            @endphp



                                            <tr>
                                                <td class="text-center sl-td">{{ $loop->iteration }}</td>
                                                <td class="text-left">
                                                    @if(!empty($filteredArray_dollar))
                                                    <input type="hidden" name="dollar_rate[]" value="{{$data->dollar_rate}}">
                                                    <input type="hidden" name="currency_sign[]" value="{{$data->currency_sign}}">
                                                    <input type="hidden" name="pr_doc_attachment_path[]" class="pr_doc_attachment_path" value="{{ !empty($po_master_info)? $po_master_info->pr_doc_attachment_path :''}} ">
                                                    @endif


                                                    <input type="hidden" name="item_id[]" value="{{ !empty($data->req_item_no_fk) ? $data->req_item_no_fk : '' }}">{{ !empty($data->item_code) ? $data->item_code : '' }}
                                                </td>
                                                <td class="text-left"> <input type="hidden" class="same-item-id" name="item_ids[]" value="{{ !empty($data->req_item_no_fk) ? $data->req_item_no_fk : '' }}">{{ !empty($data->item_name) ? $data->item_name : '' }}
                                                </td>
                                                <td class="text-left"> <input type="text" class="form-control" name="item_specification[]" value="{{!empty($data->refer_item_specification) ? $data->refer_item_specification :''}}"></td>
                                                <td class="text-left"> <input type="hidden" name="item_uoms[]" value="{{ !empty($data->uom_no_pk) ? $data->uom_no_pk : '' }}">
                                                    <input type="text" class="form-control" name="hdn_pur_um_name[]" value=" {{ !empty($data->uom_code) ? $data->uom_code : '' }}" required readonly>

                                                </td>
                                                <td class="text-right">
                                                    @if(!empty($filteredArray_dollar))
                                                    <input class="form-control item-rate text-right number_only " read-only="" onkeyup="calculateTotal()" type="hidden" name="item_rates[]" value="{{ !empty($data->item_rate) ? $data->item_rate : 0 }}">
                                                    {{ number_format($rate_dollar,2)}}
                                                    @else
                                                    <input class="form-control item-rate text-right number_only " read-only="" onkeyup="calculateTotal()" type="text" name="item_rates[]" value="{{ !empty($data->item_rate) ? $data->item_rate : 0 }}">
                                                    @endif
                                                </td>
                                                <td class="text-right">
                                                    <input class="form-control text-right number_only" min="0" type="text" name="last_purchase_price[]" value="{{$data->lpp}}">
                                                    <input type="hidden" class="total_price" value="{{ $sub_total }}">
                                                    <input type="hidden" name="sales_uom[]" class="sales_uom" value="{{ !empty($data->item_sales_uom) ? $data->item_sales_uom : '' }}">
                                                    <input type="hidden" name="item_conversion[]" class="item_conversion" value="{{ !empty($data->pr_uom_conversion_qty) ? $data->pr_uom_conversion_qty : 0 }}">
                                                </td>
                                                <td class="text-right">
                                                    <input class="form-control  text-right number_only" onkeyup="calculateTotal()" min="0" type="text" name="last_purchase_qty[]" value="{{$data->lpqty}}">
                                                    <input type="hidden" class="total_price" value="{{ $sub_total }}">
                                                </td>
                                                <td class="text-right">
                                                    <input class="form-control  text-right number_only" onkeyup="calculateTotal()" type="text" name="last_purchase_date[]" value="{{$lpd}}">
                                                </td>
                                                <td class="text-right">
                                                    <input class="form-control item-qty text-right number_only" onkeyup="calculateTotal()" min="0" type="number" name="item_quantities[]" value="{{ !empty($data->entry_qty) ? $data->entry_qty : 0 }}">
                                                    <input type="hidden" class="total_price" value="450"><input type="hidden" name="sales_uom[]" class="sales_uom" value="{{ !empty($data->item_sales_uom) ? $data->item_sales_uom : '' }}">
                                                    <input type="hidden" name="item_conversion[]" class="item_conversion" value="{{ !empty($data->pr_uom_conversion_qty) ? $data->pr_uom_conversion_qty : 0 }}">
                                                </td>
                                                <td class="text-right">
                                                    @if(!empty($filteredArray_dollar))
                                                    <input class="form-control text-right number_only item_rate_amount valid" read-only="" min="0" type="hidden" name="item_rates_amount[]" value="{{$data->entry_qty * $data->item_rate}}" aria-invalid="false">
                                                    {{number_format($data->entry_qty *  $rate_dollar,2)}}
                                                    @else
                                                    <input class="form-control text-right number_only item_rate_amount valid" read-only="" min="0" type="text" name="item_rates_amount[]" value="{{$data->entry_qty * $data->item_rate}}" aria-invalid="false">
                                                    @endif

                                                </td>
                                                <td class="text-right d-none">
                                                    <input class="item_vat text-right number_only" id="item_vat" onkeyup="CalculatePerItemVat(this)" min="0" type="hidden" name="item_vat[]" value="">
                                                </td>
                                                <td class="text-right d-none">
                                                    <input class="vat_amount text-right number_only" id="vat_amount" min="0" type="hidden" name="vat_amount[]" value="">
                                                </td>
                                                <td class="text-right d-none">
                                                    <input class="item_discount text-right number_only" id="item_discount" onkeyup="CalculatePerItemDiscount(this)" min="0" type="hidden" name="item_discount[]" value="">
                                                </td>

                                                <td class="text-right d-none">

                                                    <input class="discount_amount text-right number_only" id="dicount_amount" min="0" type="hidden" name="discount_amount[]" value="">
                                                </td>
                                                <td> <a href="javascript:void(0)" class="btn btn-sm btn-danger remove-item-btn" title="Remove"><i class="fa fa-times-circle"></i></a>
                                                </td>
                                            </tr>
                                            @endforeach

                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-striped">
                                        <thead class="global-uhl-table-bg">
                                            <tr>
                                                <!-- <th style="width: 20px;">
                                                    Select</th> -->
                                                <!-- <th style="width: 20px;"></th> -->
                                                <th>Terms & Conditions</th>
                                                <th style="width: 150px;">
                                                    <span class="btn btn-sm btn-success " data-modal="common-modal-md" data-title="Terms & Condition" title="Terms & Condition" data-id="" onclick="default_terms_condition()">Default Terms</span>
                                                    <!-- <span class="btn btn-sm btn-success open-modal btnView terms_condition_popup" data-action="{{route('v1.default-po-terms-condition')}}" data-modal="common-modal-md" data-title="Terms & Condition" title="Terms & Condition" data-id="">Default Terms</span> -->
                                                </th>
                                                <th style="width: 10px;">
                                                    <span class="btn btn-sm btn-success open-modal btnView terms_condition_popup" data-action="{{route('v1.all-po-terms-condition')}}" data-modal="common-modal-md" data-title="Terms & Condition" title="Terms & Condition" data-id=""><i class="fa fa-eye"></i></span>
                                                </th>

                                            </tr>
                                        </thead>
                                        <tbody id="terms_condition">
                                            <tr class="terms_heder">

                                                <td></td>
                                                <td></td>
                                            </tr>

                                            @if (!empty($terms))
                                            @foreach ($terms as $header => $terms_text)
                                            <tr class="terms_heder">
                                                <td style="font-weight: bold; text-align:left;" class="terms_headers" colspan="3">{{$header}}</td>

                                            </tr>


                                            @foreach($terms_text as $value)
                                            <tr>
                                                <td style="text-align:left">
                                                    <input type="text" class="form-control" value="{{$value->description}}" name="terms_text[]">
                                                    <input type="hidden" name="header_name[]" value="{{$value->termscon_header}}">
                                                    <input type="hidden" name="terms_sl[]" value="{{$value->sl}}">
                                                </td>
                                                <td> <a href="javascript:void(0)" class="btn btn-sm btn-danger remove-item-btn" title="Remove"><i class="fa fa-times-circle"></i></a></td>
                                            </tr>
                                            @endforeach
                                            @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="purchase_order_footer">
                                <div class="card-body">
                                    <div class="form-row">
                                        <div class="col-md-2">
                                            <div class="inner_purchase_footer inner_purchase_footer_amt">
                                                <span class="col-form-label">Total Amount </span>

                                                @if(!empty($filteredArray_dollar))
                                                <input type="hidden" class="form-control form-control-sm text-right" placeholder="0.00" id="item_total" name="item_total" value="{{ $total_amount }}" readonly>
                                                = <strong> {{number_format($total_amount_dollar,2)}}</strong>
                                                @else
                                                <input type="text" class="form-control form-control-sm text-right" placeholder="0.00" id="item_total" name="item_total" value="{{ $total_amount }}" readonly>
                                                @endif


                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="inner_purchase_footer inner_purchase_footer_vat">
                                                <span class="col-form-label">Vat/Tax (%)</span>
                                                <div class="input-group">
                                                    <div class="input-group-prepend ">
                                                        @if(!empty($filteredArray_dollar))
                                                        <input type="text" class="form-control form-control-sm text-right w-50" onkeyup="calculateTotal()" id="vat_percent" name="vat_percent" placeholder="0" value="{{ $vat_percent }}" readonly />
                                                        <input type="hidden" class="form-control form-control-sm text-right" onkeyup="calculateTotal()" id="total_vat_amount" name="total_vat_amount" value="{{ $vat_amount }}" placeholder="0.00" />

                                                        <strong> {{number_format($vat_amount_dollar,2)}}</strong>
                                                        @else
                                                        <input type="text" class="form-control form-control-sm text-right" onkeyup="calculateTotal()" id="vat_percent" name="vat_percent" placeholder="0" value="{{ $vat_percent }}" />
                                                        <input type="text" class="form-control form-control-sm text-right" onkeyup="calculateTotal()" id="total_vat_amount" name="total_vat_amount" value="{{ $vat_amount }}" placeholder="0.00" />
                                                        @endif



                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="inner_purchase_footer inner_purchase_footer_dis">
                                                <span class="col-form-label">Discount (%)</span>
                                                <div class="input-group">
                                                    <div class="input-group-prepend ">

                                                        @if(!empty($filteredArray_dollar))
                                                        <input type="text" class="form-control form-control-sm text-right w-50" onkeyup="calculateTotal()" id="discount_percent" name="discount_percent" placeholder="0" value="{{ number_format($discount_percent, 2) }}" readonly />
                                                        <input type="hidden" class="form-control form-control-sm text-right" onkeyup="calculateTotal()" id="total_discount_amount" name="total_discount_amount" value="{{ $discount_amount }}" placeholder="0.00" />

                                                        <strong> {{number_format($discount_amount_dollar,2)}}</strong>
                                                        @else
                                                        <input type="text" class="form-control form-control-sm text-right" onkeyup="calculateTotal()" id="discount_percent" name="discount_percent" placeholder="0" value="{{ number_format($discount_percent, 2) }}" />
                                                        <input type="text" class="form-control form-control-sm text-right" onkeyup="calculateTotal()" id="total_discount_amount" name="total_discount_amount" value="{{ $discount_amount }}" placeholder="0.00" />
                                                        @endif


                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="inner_purchase_footer inner_purchase_footer_adj">
                                                <span class="col-form-label">Discount Adj. Amt.</span>

                                                @if(!empty($filteredArray_dollar))
                                                <input type="text" class="form-control form-control-sm text-right" id='discount_adj_amt' name="discount_adj_amt" readonly value="" placeholder="0.00">
                                                @else
                                                <input type="text" class="form-control form-control-sm text-right" id='discount_adj_amt' name="discount_adj_amt" readonly value="{{ $adj_discount }}" placeholder="0.00">
                                                @endif




                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="inner_purchase_footer inner_purchase_footer_pay">
                                                <span class="col-form-label">Payable Amount</span>



                                                @if(!empty($filteredArray_dollar))
                                                <input type="hidden" class="form-control form-control-sm text-right" id="total_payable" readonly name="" value="{{ $total_amount + $vat_amount - $discount_amount - $adj_discount }}" placeholder="" />
                                                <strong> = {{number_format($payable_amt_dollar,2)}} </strong>
                                                @else
                                                <input type="text" class="form-control form-control-sm text-right" id="total_payable" readonly name="" value="{{ $total_amount + $vat_amount - $discount_amount - $adj_discount }}" placeholder="" />
                                                @endif


                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card mb-2">
                                        <div class="card-body">
                                            <div class="form-group">
                                                <input type="hidden" id="po_type" value="{{isset($po_master_info->po_save_option)? $po_master_info->po_save_option : ''}}">
                                                @php
                                                $response_action = '';
                                                if(Session::get("user.approval_ind") == 1){
                                                $response_action = route('v1.my-approval');
                                                }else{
                                                $response_action = route('v1-purchase-order.index');
                                                }


                                                $condition= isset($po_master_info->po_save_option)? '@if($po_master_info->po_save_option == "POST" || $po_master_info->po_save_option == "ISSUE" || $po_master_info->po_save_option == "DRAFT") disabled @endif' :'';

                                                $approval_exp=!empty( $po_master_info->approval_level_status_text)&& $po_master_info->approval_level_status_text !="" ? explode('/', $po_master_info->approval_level_status_text) : '';
                                                @endphp

                                                @if($approval_exp =="" )
                                                @php
                                                $approval=1;
                                                @endphp
                                                @elseif($approval_exp !="" && $approval_exp[0] != $approval_exp[1])
                                                @php
                                                $approval=1;
                                                @endphp
                                                @else
                                                @php
                                                $approval=0;
                                                @endphp

                                                @endif
                                                <input type="hidden" id="approval_indc" value="{{$response_action}}">
                                                <ul class="list-inline btn__box">
                                                        @if(empty($po_master_info))
                                                        <li class="list-inline-item">
                                                            <button type="submit" class="btn btn-secondary uhl_save_btn" onclick="setType('DRAFT');" id="save_update" data-func="" {{ $condition}}>Draft</button>
                                                        </li>
                                                        @else

                                                        @endif

                                                    @if (isset($po_master_info->po_save_option) )
                                                        @if($po_master_info->po_save_option == "DRAFT" && ( $approval==1 ||Session::get("user.inv_hod_ind") == 1 || Session::get("user.approval_ind") == 1) )



                                                            <li class="list-inline-item"><button type="submit" class="btn btn-secondary uhl_common_btn" onclick="setType('POST');" data-func="" id="save_update">
                                                                    @if(Session::get("user.approval_ind") == 1)
                                                                    Save
                                                                    @else
                                                                    Post
                                                                    @endif

                                                                </button>
                                                            </li>


                                                        @endif
                                                        @if (($po_master_info->po_save_option == 'POST' || $po_master_info->po_save_option == 'ISSUE') && ( $approval==1 || Session::get("user.inv_hod_ind") == 1 || Session::get("user.approval_ind") == 1))
                                                            <li class="list-inline-item"><button type="submit" class="btn btn-secondary uhl_common_btn" onclick="setType('ISSUE');" data-func="" id="save_update">
                                                            <!-- btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}') -->
                                                                    @if(Session::get("user.approval_ind") == 1)
                                                                    Save
                                                                    @else
                                                                    Save
                                                                    @endif

                                                                </button>
                                                            </li>
                                                        @endif
                                                    @endif


                                                    <!-- <li class="list-inline-item"><button type="button"
                                                            class="btn btn-secondary uhl_common_btn">Clear</button>
                                                    </li> -->





                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-2">
                            <div class="card-body p-2">
                                <div class="form-group form-row">
                                <label for="attachment" class="col-sm-1 col-form-label">Attachment</label>

                                <input type="file" name="attachment" id="attachment" class="col-sm-3">
                                    <label for="indat_remarks" class="col-sm-2 col-form-label">Indent Remarks</label>
                                    <div class="col-sm-6">
                                        <textarea class="form-control form-control-sm" name="indent_remarks" id="Indent_remarks" placeholder="" row="3" style="min-height: 100px !important;"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </form>

    <!-- Button trigger modal -->

    <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
        @php
                if(in_array(Session::get('user.ses_hospital_code'),["UNICO"])){
                  $copy_to= '1) Finance & Accounts , 2) General Store , 3) Office File';
                  $message_body='<p>Dear Sir,</p><p>With reference to your quotation and subsequently negotiation, we are pleased to accept offer under the following terms and condition.</p>';
                }else{
                    $copy_to='';
                    $message_body='';
                }



         @endphp
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Purchase Application</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group form-row">
                        <label for="ref_no" class="col-sm-4 col-form-label">Ref No<span class="text-danger">*</span> </label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <input type="text" class="form-control" id="ref_no" name="ref_no" placeholder="" value="{{ isset($po_master_info->reference_no) ? $po_master_info->reference_no : '' }}" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-row">
                        <label for="subject_" class="col-sm-4 col-form-label">Subject<span class="text-danger">*</span> </label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <input type="text" class="form-control" id="subject_details" name="subject_details" placeholder="" value="{{ isset($po_master_info->reference_sub) ? $po_master_info->reference_sub : '' }}" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="message_body" class="col-md-4 col-form-label col-form-label-sm">Message Body<span class="text-danger">*</span> </label>
                        <div class="col-md-8">
                                <textarea class="" id="message_body" name="message_body" >{{ isset($po_master_info->reference_sub_body) ? $po_master_info->reference_sub_body : $message_body }}</textarea>
                        </div>
                    </div>

                    <div class="form-group form-row">
                        <label for="contact_person" class="col-sm-4 col-form-label">Contact Person </label>
                        <div class="col-sm-8">
                            <div class="input-group">

                                <input type="text" class="form-control" id="contact_person" name="contact_person" placeholder="" value="{{ isset($po_master_info->refer_contact_name) ? $po_master_info->refer_contact_name : '' }}" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-row">
                        <label for="contact_number" class="col-sm-4 col-form-label">Contact Number </label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <input type="text" class="form-control" id="contact_number" name="contact_number"  value="{{ isset($po_master_info->refer_contact_mobile) ? $po_master_info->refer_contact_mobile : '' }}"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-row">
                        <label for="contact_email" class="col-sm-4 col-form-label">Contact Email</label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <input type="text" class="form-control" id="contact_email" name="contact_email"  value="{{ isset($po_master_info->refer_contact_email) ? $po_master_info->refer_contact_email : '' }}"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-row">
                        <label for="quotation_ref" class="col-sm-4 col-form-label">Quotation Ref.</label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <input type="text" class="form-control" id="quotation_ref" name="quotation_ref"  value="{{ isset($po_master_info->quotation_ref) ? $po_master_info->quotation_ref : '' }}"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-row">
                    <label for="copy_to" class="col-sm-4 col-form-label">Copy To </label>
                    <div class="col-sm-8">

                            <div class="input-group">
                                <input type="text" class="form-control" id="copy_to" name="copy_to"  value="{{ isset($po_master_info->copy_to) ? $po_master_info->copy_to : $copy_to }}"/>
                            </div>
                        </div>
                    </div>



                    <!-- <div class="form-group form-row">
                        <label for="item_specification" class="col-sm-4 col-form-label">Item specification<span class="text-danger">*</span> </label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <textarea class="form-control" id="item_specification" name="item_specification"   row="3">{{ isset($po_master_info->refer_item_specification) ? $po_master_info->refer_item_specification : '' }}</textarea>
                            </div>
                        </div>
                    </div> -->

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-danger" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary uhl_save_btn" onclick="saveInformation()">Set</button>
                </div>
            </div>
        </div>
    </div>



    <div class="modal" tabindex="-1" role="dialog" id="indent_purchase_order_entry_modal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Requisition Items</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body modal-body2">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="setOnPoList()">Set For
                        PO</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
                    <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="setFormDefault()">Set For
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
                <div class="modal-body modal-body1 px-0" id="last_purchase_order_entry_modal_body">

                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" onclick="setFormLastPurchase()" class="btn btn-primary">Set
                        For PO</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
<script type="application/javascript" src="{{ asset('js/redactor.js') }}"></script>

<script>
    $("body").addClass("sidebar-collapse");
    loadEditor("message_body");
    loadEditor("result_comm");
    $(document).on("click", '#save_update', function(e) {
        if ($('#delivery_date').val() =="") {
            alert('Enter Delivery Date');
            return false;
        }
        if ($('#supplier_id').val() =="") {
            alert('Enter Supplier');
            return false;
        }
        if (confirm("Are you sure?")) {
            e.preventDefault();
            //    $('#item_issue_form').unbind().submit(function(e) {


                  var formAction = $('#create-po').attr("action");
                  var formMethod = $('#create-po').attr("method");
                  var formData = new FormData(document.querySelector('form'));
                  var customFunc = $("#save_update").attr("data-func");
                  var approval_url=$('#approval_indc').val();
                    console.log(approval_url+'____url')
                  $.ajax({
                      type: formMethod,
                      url: formAction,
                      data: formData,
                      cache: false,
                      contentType: false,
                      processData: false,
                      beforeSend: function() {
                          if (customFunc == "") {
                              if (isAModalOpen)
                                  $('.modal').modal('hide');


                          }
                          blockUI();
                      },
                      success: function(data) {

                        if (data.title == 'Success') {
                        $('.common-modal-notify').modal('show');
                        $('.common-modal-notify .modal-body').html("<i class='fas fa-stroopwafel fa-spin'></i>");
                        $('.common-modal-notify .modal-title').html(data.title);
                        $('.common-modal-notify .modal-body').html(data.msg);
                    } else {
                        $('.common-modal-notify-error').modal('show');
                        $('.common-modal-notify-error .modal-title').html(data.title);
                        $('.common-modal-notify-error .modal-body').html(data.msg);
                    }
                      },

                      complete: function() {
                        dynamicFunc.afterSaveLoadPage(approval_url)
                          $.unblockUI();
                        //   assetsSearchFunc();
                      },
                      error: function(data) {
                          var errors = jQuery.parseJSON(data.responseText).msg;

                          error_messages = "";
                          for (messages in errors) {
                              var field_name = $("#" + messages).siblings("label")
                                  .html();
                              error_messages +=
                                  "<div class='alert alert-danger' role='alert'>" +
                                  errors[messages] + "</div>";
                          }
                          $('.common-modal-notify-error').modal('show');
                          $('.common-modal-notify-error .modal-title').html(
                              "Validation Error");
                          $('.common-modal-notify-error .modal-body').html(
                              errors);
                          finished = false;
                          $.unblockUI();
                      }
                  });
            //   });
              e.stopImmediatePropagation();
          }else {

            return false;
          }
      });
    $(document).ready(function() {

        $("#create-po").validate();
        $('.select2').select2();
        $(".date_picker").datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
            clearBtn: true
        })

        if ($('#po_type').val() == "POST" || $('#po_type').val() == "ISSUE") {

            // $('input').prop('readonly',true);
            // $('.remove-item-btn').parents('td').html('');
            // $('#add_item_block').html('');
            // $('#set_item_block').html('');
            // $('.terms_condition_popup').prop('disabled' , true);



            // $(".date_picker").datepicker('disable');
            // $( ".date_picker" ).datepicker( "option", "disabled", true );
        }

    });








    function saveInformation() {

        if ($('#ref_no').val() != '' && $('#subject_details').val() != '' && $('#message_body').val() != '') {
            $('#ref_info').val($('#ref_no').val());
            $('#subject_info').val($('#subject_details').val());
            $('#message_info').val($('#message_body').val());
            $('#contact_person_info').val($('#contact_person').val());
            $('#contact_number_info').val($('#contact_number').val());
            $('#contact_email_info').val($('#contact_email').val());
            $('#quotation_ref_info').val($('#quotation_ref').val());
            // $('#item_specification_info').val($('#item_specification').val());
            $("#exampleModal").modal('hide');
        }

    }

    item_name_autocomplete_store_wise('#item_name', 'item_name', function(item, obj) {
        //console.log(item);
        var item_uom = '';
        //  console.log(item.uom_no_fk);
        if (item.uom_no_fk != null)
            item_uom +=
            `<option data-conversion='${item.pr_uom_conversion_qty}' value='${item.uom_no_fk}_${item.uom_name}'>${item.uom_name}</option>`;
        if (item.item_uom_name_2nd != null)
            item_uom +=
            `<option data-conversion='${item.uom_no_fk_2nd_conv_ratio}' value='${item.uom_no_fk_2nd}_${item.item_uom_name_2nd}'>${item.item_uom_name_2nd}</option>`;
        if (item.uom_no_fk_3rd != null)
            item_uom +=
            `<option data-conversion='${item.uom_no_fk_3rd_conv_ratio}' value='${item.uom_no_fk_3rd}_${item.item_uom_name_3rd}'>${item.item_uom_name_3rd}</option>`;
        if (item.uom_no_fk_4th != null)
            item_uom +=
            `<option data-conversion='${item.uom_no_fk_4th_conv_ratio}' value='${item.uom_no_fk_4th}_${item.item_uom_name_4th}'>${item.item_uom_name_4th}</option>`;
        //console.log(item_uom);
        var p_price = item.purchase_price == 0 ? '' : item.purchase_price;
        $('#item_code').val(item.item_code);
        $('#item_id_hidden').val(item.item_id);
        $('#item_uom_hidden').val(item.uom_no_fk);
        $('#item_uom').html(item_uom);
        $("#purchase_price").val(p_price);
        $("#old_purchase_price").val(item.purchase_price);
        $('#item_conversion').val(item.pr_uom_conversion_qty);
        $('#item_sales_uom').val(item.item_sales_uom);
        $('#lpqty').val(item.lpqty);
        $('#lpp').val(item.lpp);
        $('#lpd').val(item.lpd);
        var edit_action = "{{ route('item.edit-quick-item-po', ': id') }}";
        edit_action = edit_action.replace(':id', item.item_id);
        $('#item_info').html(
            `<span class="p-0 m-0 btn btn-sm btn-primary open-modal" data-id="${item.item_id}" data-action="${edit_action}" data-modal="common-modal-md" data-title="Edit Item" title="Edit"><i class="fa fa-pencil-alt"></i></span>`
        )
        if (p_price == '') {
            $('#purchase_price').focus();
        } else {
            $('#item_quantity').focus();
        }

        // $('#pvms_no').val(item.pvms_no);
        obj.stopImmediatePropagation();
    });

    $(document).on('click', '#add_item_btn', function(e) {
        e.preventDefault();

        var item_id = $('#item_id_hidden').val()
        var item_name = $('#item_name').val()
        var item_code = $('#item_code').val()
        var item_id_hidden = $('#item_id_hidden').val()
        var temp_uom = $('#item_uom').val().split('_');
        console.log(temp_uom);
        var item_uom_name = temp_uom[1]
        var item_uom_no = temp_uom[0]
        var item_quantity = $('#item_quantity').val()
        var item_price = $('#purchase_price').val()
        var sales_uom = temp_uom[0];
        var item_conversion = $("#item_conversion").val();
        var lpqty = $("#lpqty").val();
        var lpd = $("#lpd").val();
        var lpp = $("#lpp").val();


        if (item_price == '' || item_price == 0) {
            alert('Please Enter Item Price');
            e.stopImmediatePropagation();
            return false
        }
        if (item_quantity == '' || item_quantity == 0) {
            alert('Please Enter Item Quantity');
            e.stopImmediatePropagation();
            return false
        }


        if (item_id == '' || item_name == '') {
            alert('Item name cannot be blank.')
            e.stopImmediatePropagation();
            return false
        }


        let item_qty = 0
        let rec_ins = true;
        if ($('.item_id').length > 0) {

            Array.from($('.item_id')).map((item, i) => {
                console.log($(item).val() == Number(item_id), Number($(item).val()), Number(item_id))
                if (Number($(item).val()) == Number(item_id)) {

                    item_qty = Number($('input[data-item_id="' + Number($(item).val()) + '"]').val());

                    item_qty += Number($('#item_quantity').val());

                    $('input[data-item_id="' + Number($(item).val()) + '"]').val(item_qty);
                    $('input[data-rate_item_id="' + Number($(item).val()) + '"]').val(item_price);

                    $('#item_id').val('')
                    $('#item_code').val('')
                    $('#item_name').val('')
                    $('#item_id_hidden').val('')
                    $('#item_uom').val('')
                    $('#item_uom_hidden').val('')
                    $('#item_quantity').val('')
                    $('#item_price').val('')
                    $('#purchase_price').val('')
                    $("#item_conversion").val('')
                    $("#item_sales_uom").val('')
                    $('#item_name').focus();

                    rec_ins = false;
                }
            })

            if (rec_ins) {

                rec_ins = true;
            } else {

                e.stopImmediatePropagation();
                return false;
            }

            rec_ins = true;
        }

        if (item_qty == 0) {
            item_qty = Number(item_quantity);
        }


        var same_item = false
        $('input[class=same-item-id]').each(function(index, elem) {
            if ($(elem).val() == item_id) {
                same_item = true
                return false
            }
        })

        // if (same_item == true) {
        //     alert('You have already taken this item.')
        //     $('#item_id').val('')
        //     $('#item_code').val('')
        //     $('#item_name').val('')
        //     $('#item_id_hidden').val('')
        //     $('#item_uom').val('')
        //     $('#item_uom_hidden').val('')
        //     $('#item_quantity').val('')
        //     $('#item_price').val('')
        //     $('#purchase_price').val('')
        //     $("#item_conversion").val('')
        //     $("#item_sales_uom").val('')
        //     e.stopImmediatePropagation();
        //     return false
        // }

        var total = item_price * item_qty;
        var row = '<tr>' +
            '<td class="text-center sl-td">0</td>' +
            '<td class="text-left"> <input type="hidden" name="item_id[]" value="' + item_id +
            '" class="item_id"><input type="hidden" name="indent_no[]" value="">' + item_code + '</td>' +
            '<td class="text-left"> <input type="hidden" class="same-item-id" name="item_ids[]" value="' +
            item_id + '">' + item_name + '</td>' + '<td class="text-left"> <input type="text" class="form-control" name="item_specification[]" value=""  ></td>'+
            '<td class="text-left"> <input type="hidden" name="item_uoms[]" value="' + item_uom_no +
            '">' + '<input type="text" class="form-control" name="hdn_pur_um_name[]" value="' + item_uom_name + '" required readonly>' + '</td>' +
            '<td class="text-right"> <input class="form-control item-rate text-right number_only item_rates"   data-rate_item_id="' + item_id + '" read-only onkeyup="calculateTotal(),item_rate_amount(this)"  type="text" name="item_rates[]" value="' +
            item_price + '"></td>' +

            '<td class="text-right"> <input class="form-control text-right number_only"  min="0" type="text" name="last_purchase_price[]" value="' +
            lpp + '"><input type="hidden" class="total_price" value="' + total +
            '"><input type="hidden" name="sales_uom[]" class="sales_uom" value="' + sales_uom +
            '"><input type="hidden" name="item_conversion[]" class="item_conversion" value="' +
            item_conversion + '"></td>' +
            '<td class="text-right"> <input class="form-control  text-right number_only" onkeyup="calculateTotal()" min="0" type="text" name="last_purchase_qty[]" value="' +
            lpqty + '"><input type="hidden" class="total_price" value="' + total +
            '"></td>' +
            '<td class="text-right"> <input class="form-control  text-right number_only" onkeyup="calculateTotal()"  type="text" name="last_purchase_date[]" value="' +
            lpd + '"></td>' +
            '<td class="text-right"> <input class="form-control item-qty text-right" onkeyup="calculateTotal(), item_rate_amount(this)" min="0" type="number" name="item_quantities[]" value="' +
            item_qty + '"  data-item_id="' + item_id + '"><input type="hidden" class="total_price" value="' + total +
            '"><input type="hidden" name="sales_uom[]" class="sales_uom" value="' + sales_uom +
            '"><input type="hidden" name="item_conversion[]" class="item_conversion" value="' +
            item_conversion + '"></td>' +
            '<td class="text-right"> <input class="form-control item-rate text-right number_only item_rate_amount" read-only min="0" type="text" name="item_rates_amount[]" value="' +
            item_price * item_qty + '"></td>' +
            '<td class="text-right d-none"> <input class="item_vat text-right number_only" id="item_vat" onkeyup="CalculatePerItemVat(this)" min="0" type="hidden" name="item_vat[]" value=""></td>' +
            '<td class="text-right d-none"> <input class="vat_amount text-right number_only" id="vat_amount"  min="0" type="hidden" name="vat_amount[]" value=""></td>' +
            '<td class="text-right d-none"> <input class="item_discount text-right number_only" id="item_discount" onkeyup="CalculatePerItemDiscount(this)" min="0" type="hidden" name="item_discount[]" value=""></td>' +
            '<td class="text-right d-none"> <input class="discount_amount text-right number_only" id="dicount_amount"  min="0" type="hidden" name="discount_amount[]" value=""></td>' +
            '<td> <a href="javascript:void(0)" class="btn btn-sm btn-danger remove-item-btn" title="Remove"><i class="fa fa-times-circle"></i></a></td>' +
            '</tr>';

        // $('#demand_items').append(row)
        if ($("#demand_items tr").length > 0) {
            $('#demand_items tr:last').after(row);
        } else {
            $('#demand_items').append(row);
        }

        // $('#demand_items tr:last').after(row);
        $('#item_id').val('')
        $('#item_name').val('')
        $('#item_code').val('')
        $('#item_id_hidden').val('')
        $('#item_uom').val('')
        $('#item_conversion').val('')
        $('#item_uom_hidden').val('')
        $('#item_quantity').val('')
        $('#item_price').val('')
        $('#purchase_price').val('')
        $("#item_conversion").val('')
        $("#item_sales_uom").val('')
        $('#item_name').focus();
        //$('#item_name').focus()
        //poItemCalculateTotal1(this);
        calculateTotal();
        $('.sl-td').each(function(index, elem) {
            $(elem).text(index + 1)
        })

        // $('#item_name').parent('span').children('div').find('.tt-dataset').html('');
        // $('#item_name').parent('span').find('pre').html('');
        // $('#item_name').val('');
        // $('.tt-menu tt-dataset tt-dataset-0').html('');
        // $('.twitter-typeahead > pre').text('');


        e.stopImmediatePropagation();
    })

    $('#item_name').on('focus', function() {
        $('.tt-menu').css({
            'display': 'none'
        });
        $('.tt-menu').removeClass('tt-open');
        $('.tt-menu tt-dataset tt-dataset-0').html('');
        $('.twitter-typeahead > pre').text('');
        $('#item_name').val('');
    })

    function item_rate_amount(element) {
        const item_rate = Number($(element).parents("tr").find('.item_rates').val());
        const item_qty = Number($(element).parents("tr").find('.item-qty').val());
        const amount = (item_rate * item_qty).toFixed(2);
        $(element).parents("tr").find('.item_rate_amount').val(amount);

    }

    function setConversionQty(element) {
        console.log($('option:selected', element).attr('data-conversion'), $(element).val());
        $('#item_conversion').val($('option:selected', element).attr('data-conversion'));
        var conversion = parseInt($('option:selected', element).attr('data-conversion') * 1);
        var old_purchase_price = ($('#old_purchase_price').val() * 1);
        $('#purchase_price').val(conversion * old_purchase_price);
    }

    function setTotalPrice() {
        if ($("#demand_items tr").length > 0) {
            $("#demand_items tr").each(function() {

                var price = $(this).find(".item-rate").val() * 1;
                var qty = $(this).find(".item-qty").val() * 1;
                var pr = $(this).find('.item-qty').attr("data-pr");
                var pr_qty = $(this).find('.item-qty').attr("data-rate") * 1;
                if (pr == "PR" && pr_qty < qty) {
                    alert('Enter less then or equal P.R qty ')
                    qty = pr_qty * 1;
                    $(this).find('.item-qty').val(qty);
                }
                var total = price * qty;
                console.log(pr + '_prout_' + pr_qty + '_' + qty)
                $(this).find(".total_price").val(parseFloat(total));

            });
        }
        calculateTotal();
    }
var delete_pr_item_no=[];
    $(document).on('click', '.remove-item-btn', function() {
        delete_pr_item_no.push($(this).closest('tr').find("input[name='item_id[]']").val())

        if($(this).parent('td').parent('tr').prev().hasClass("terms_heder") && !$(this).parent('td').parent('tr').next().hasClass("terms_row")){
                $(this).parent('td').parent('tr').prev().remove()
        }

        $(this).closest('tr').remove()
        $('.sl-td').each(function(index, elem) {
            $(elem).text(index + 1)
        })
        setTotalPrice();
        // poItemCalculateTotal1(this);
        $('#delete_pr_item').val(delete_pr_item_no);

    })

    function calculateTotal() {
        var item_total = 0;

        var itemT_pay = (parseFloat($("#item_total").val()) - parseFloat($("#pay_amount").val()));
        var urgent_fee_total = $("#urgent_fee").val() != '' ? parseFloat($("#urgent_fee").val()) : 0;
        var discount_percent = $("#discount_percent").val() != "" ? parseFloat($("#discount_percent")
            .val()) : 0;
        var total_discount_amount = $("#total_discount_amount").val() != "" ? parseFloat($(
            "#total_discount_amount").val()) : 0;



        var item_total = 0;
        var delivery_status = 0;
        var urgent_fee = 0;
        var final_total = 0;
        var total_dollar_rate = 0;
        var dollar_rate=0;
        var dollar_sign='';
        // var urgent_fee = urgent_fee_total;

        if ($("#demand_items tr").length > 0) {
            $("#demand_items tr").each(function() {
                var price = $(this).find(".item-rate").val() * 1;
                var qty = $(this).find(".item-qty").val() * 1;
                if (qty >= 0) {
                    var total = price * qty;
                    //  console.log(total,'sadsd',qty,price);
                    $(this).find(".total_price").val(parseFloat(total));


                    item_total += $(this).find(".total_price").val() * 1;
                    $(this).find('.item_rate_amount ').val(total);
                } else {
                    $(this).find(".item-qty").val(0)
                    alert("Invalid Quantity");
                }

                dollar_rate =typeof  $(this).find('.dollar_rate').val() !="undefined" ? $(this).find('.dollar_rate').val() :0;
                dollar_sign =typeof   $(this).find('.currency_sign').val() !="undefined" ? $(this).find('.currency_sign').val():'';
                if (dollar_rate != '' && dollar_sign != '') {
                    total_dollar_rate += price / dollar_rate;
                }

            });
            console.log(dollar_rate+'________dollar_rate'+dollar_sign);
            if (dollar_rate !=0 && dollar_sign !='') {
                $('.inner_purchase_footer_amt').append('<strong>= ' + total_dollar_rate.toFixed(2)+'</strong>');
                $("#item_total").attr('type', 'hidden');
            }

            $("#item_total").val(item_total.toFixed(2));

            $("#total_payable").val((item_total + urgent_fee).toFixed(2));

            var vat_percent = $("#vat_percent").val() * 1;
            var total_vat_amount = 0;

            if (vat_percent != 0) {
                total_vat_amount = (item_total * vat_percent) / 100;
                $("#total_vat_amount").val(total_vat_amount.toFixed(2));
                final_total = item_total + total_vat_amount;
            } else {

                var vat_amount = parseFloat($("#total_vat_amount").val() * 1);

                if (vat_amount != 0) {
                    total_vat_amount = (vat_amount / item_total) * 100;

                    // $("#vat_percent").val(total_vat_amount.toFixed(2));

                } else {
                    $("#total_vat_amount").val(0)
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
            if (dollar_rate !=0 && dollar_sign !='') {
                $('.inner_purchase_footer_vat').append('<strong>'+(total_vat_amount / dollar_rate).toFixed(2)+'</strong>');
                $("#vat_percent").attr('readonly', 'readonly');
                $("#total_vat_amount").attr('type', 'hidden');

                $('.inner_purchase_footer_dis').append('<strong>'+(total_discount_amount / dollar_rate).toFixed(2)+'</strong>');
                $("#discount_percent").attr('readonly', 'readonly');
                $("#total_discount_amount").attr('type', 'hidden');

                $("#inner_purchase_footer_adj").addClass('d-none');

                $('.inner_purchase_footer_pay').append('<strong> = '+(final_total / dollar_rate).toFixed(2)+'</strong>');
                $("#total_payable").attr('type', 'hidden');
            }




            $("#total_payable").val(Math.floor(final_total).toFixed(2));
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


    $(document).on('click', '#indent_item', function(e) {
        e.preventDefault()
        var supplier_id = $('#supplier_id').val()

        var id_val = $(this).attr('id')

        // if (supplier_id == "") {
        //     alert('Please, select supplier.')
        //     return false
        // }

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
            url: "{{ route('v1.indent_supplier_items') }}",
            type: 'post',
            beforeSend: function() {
                if (isAModalOpen)
                    $('.modal').modal('hide');
                blockUI();
                //$('.data-table').DataTable().clear().destroy();
            },
            success: function(data) {

                //alert(data);

                $('.modal-body2').html(data)
                //$('#demand_entry_modal').modal('show')
                $('#indent_purchase_order_entry_modal').modal('show')
                // $('.data-table').DataTable({
                //     "ordering": false,
                //     "bPaginate": false,
                //     "bLengthChange": false,
                //     "bAutoWidth": false
                // });

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
            url: "{{ route('v1.default_supplier_items') }}",
            type: 'post',
            beforeSend: function() {
                if (isAModalOpen)
                    $('.modal').modal('hide');
                blockUI();
                //$('.data-table').DataTable().clear().destroy();
            },
            success: function(data) {

                //alert(data);

                $('.modal-body2').html(data)
                //$('#demand_entry_modal').modal('show')
                $('#purchase_order_entry_modal').modal('show')
                // $('.data-table').DataTable({
                //     "ordering": false,
                //     "bPaginate": false,
                //     "bLengthChange": false,
                //     "bAutoWidth": false
                // });

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
        // $('#demand_items').html("");
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
            url: "{{ route('v1.last_supplier_purchase_order_items') }}",
            type: 'post',
            beforeSend: function() {
                // $('.data-table').DataTable().clear().destroy();
                if (isAModalOpen)
                    $('.modal').modal('hide');
                blockUI();
            },
            success: function(data) {
                var rows = '';
                $('.modal-body1').html(data)
                //$('#last_purchase_order_entry_modal_body').html(data)
                //$('#demand_entry_modal').modal('show')
                $('#last_purchase_order_entry_modal').modal('show')
                // $('.data-table').DataTable({
                //     "ordering": false,
                //     "bPaginate": false,
                //     "bLengthChange": false,
                //     "bAutoWidth": false
                // });

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
    $(document).on('change', '#checked_all', function() {
        $('.selected-default-item').prop('checked', this.checked);
    });

    $(document).on('change', '.selected-default-item', function() {
        $(this).prop('checked', true);
    });

    $(document).on('change', '.selected-default-item', function() {
        if ($('.selected-default-item:checked').length == $('.selected-default-item').length) {
            $('#purchase_order_entry_modal #checked_all').prop('checked', true);
        } else {
            $('#purchase_order_entry_modal #checked_all').prop('checked', false);
        }

    });

    function setType(value) {
        $('#in_req_saveoption').val(value);
    }


    // let terms_head_arr = [];
    // let head_terms_arr = [];

    function StoreTermsCon(element) {
        var store_id = $(element).val();
        $('#terms_condition').html('');
        $.ajax({
            async: true,
            data: {
                store_id: store_id
            },
            dataType: "json",
            url: "{{ route('v1.get-store-terms-condition') }}",
            type: 'post',
            beforeSend: function() {
                // $('.data-table').DataTable().clear().destroy();
                if (isAModalOpen)
                    $('.modal').modal('hide');
                blockUI();
            },
            success: function(data) {
                let terms_arr = [];

                data.terms_header.map((terms_root, i) => {
                    // terms_head_arr.push(terms_root);
                    $('#terms_condition').append(`
                            <tr class="terms_heder">
                                <td style="font-weight: bold; text-align:left;" class="terms_headers" colspan="3">${terms_root}</td>

                            </tr>
                    `);
                    console.log('Terms & conditin ', terms_root)
                    var sl = 0;
                    terms_arr = Array.from(data.terms).map((terms) => {

                        if (terms_root === terms.termscon_header) {
                            let head_terms = terms.termscon_text1;
                            // head_terms_arr.push({
                            //     terms_root:head_terms
                            // });
                            console.log('Terms & conditin ', terms.termscon_text1)
                            sl += 1;
                            $('#terms_condition').append(`
                                <tr>

                                    <td style="text-align:left">
                                    <input type="text" class="form-control" value="${terms.termscon_text1}" name="terms_text[]">
                                    <input type="hidden" name="header_name[]" value="${terms_root}">
                                    <input type="hidden" name="terms_sl[]" value="${terms.terms_sl}">
                                    </td>
                                    <td> <a href="javascript:void(0)" class="btn btn-sm btn-danger remove-item-btn" title="Remove"><i class="fa fa-times-circle"></i></a></td>
                                </tr>
                            `);
                        }
                    });
                })


                // console.log('Terms header array child ', head_terms_arr)


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
        // element.stopImmediatePropagation();
    }


      function default_terms_condition() {

        $('#terms_condition').html('');
        $.ajax({
            async: true,
            dataType: "json",
            url: "{{ route('v1.default-po-terms-condition') }}",
            type: 'post',
            beforeSend: function() {
                // $('.data-table').DataTable().clear().destroy();
                if (isAModalOpen)
                    $('.modal').modal('hide');
                blockUI();
            },
            success: function(data) {
                let terms_arr = [];

                data.terms_header.map((terms_root, i) => {
                    // terms_head_arr.push(terms_root);
                    $('#terms_condition').append(`
                            <tr class="terms_heder">
                                <td style="font-weight: bold; text-align:left;" class="terms_headers" colspan="3">${terms_root}</td>

                            </tr>
                    `);
                    console.log('Terms & conditin ', terms_root)
                    var sl = 0;
                    terms_arr = Array.from(data.terms).map((terms) => {

                        if (terms_root === terms.termscon_header) {
                            let head_terms = terms.termscon_text1;
                            console.log('Terms & conditin ', terms.termscon_text1)
                            sl += 1;
                            $('#terms_condition').append(`
                                <tr>

                                    <td style="text-align:left">
                                    <input type="text" class="form-control" value="${terms.termscon_text1}" name="terms_text[]">
                                    <input type="hidden" name="header_name[]" value="${terms_root}">
                                    <input type="hidden" name="terms_sl[]" value="${terms.header_sl}">
                                    </td>
                                    <td> <a href="javascript:void(0)" class="btn btn-sm btn-danger remove-item-btn" title="Remove"><i class="fa fa-times-circle"></i></a></td>
                                </tr>
                            `);
                        }
                    });
                })
            },
            complete: function() {
                $.unblockUI();
            },
            error: function(data) {

                $.unblockUI();
            }
        });
      }

    function set_terms(element) {
        var old_header = [];
        var header = [];
        var terms = [];

        let check_terms = 0;
        let check_term_val = '';
        let p = 0;

        $('.selected-terms').each(function() {

            let header_block = $('.terms_headers');

            //setTimeout(function(){


            if ($(this).is(':checked')) {

                var terms_item = $(this).val();
                var terms_exp = terms_item.split('*');
                header.push(terms_exp[0]);
                terms.push(terms_exp[1]);
                // console.log(terms_item , header_block)

                if ($(header_block).length > 0) {


                    $('.terms_headers').each(function() {
                        // console.log( terms_exp[0] , $(this).html());
                        if (check_terms == 0) {
                            check_term_val = terms_exp[0];
                        }
                        console.log(terms_exp[0], $(this).html().trim())
                        if (terms_exp[0] == $(this).html().trim()) {
                            $(this).parent('tr').after(`<tr class="terms_row"><td style="text-align:left"><input type="text" class="form-control" value="${terms_exp[1]}" name="terms_text[]"><input type="hidden" name="header_name[]" value="${terms_exp[0]}"> <input type="hidden" name="terms_sl[]" value="${terms_exp[2]}"></td><td> <a href="javascript:void(0)" class="btn btn-sm btn-danger remove-item-btn" title="Remove"><i class="fa fa-times-circle"></i></a></td></tr>`);
                            check_terms = 1; //Need to handgle bug when no terms & condition with the store

                        } else {
                            if (check_terms == 0) {
                                check_term_val = terms_exp[0]
                                $('#terms_condition tr:last').after(`<tr class="terms_heder">
                                                <td style="font-weight: bold; text-align:left;" class="terms_headers" colspan="3">${terms_exp[0]}</td>
                                            </tr><tr class="terms_row"><td style="text-align:left"><input type="text" class="form-control" value="${terms_exp[1]}" name="terms_text[]"><input type="hidden" name="header_name[]" value="${terms_exp[0]}"> <input type="hidden" name="terms_sl[]" value="${terms_exp[2]}"></td><td> <a href="javascript:void(0)" class="btn btn-sm btn-danger remove-item-btn" title="Remove"><i class="fa fa-times-circle"></i></a></td></tr>`);

                                check_terms = 1;
                            }


                        }

                        if (check_term_val != terms_exp[0]) {
                            check_terms = 0;
                        }
                        old_header.push($(this).html().trim());
                    })
                } else {
                    $('#terms_condition').append(`<tr class="terms_heder">
                                            <td style="font-weight: bold; text-align:left;" class="terms_headers" colspan="3">${terms_exp[0]}</td>
                                        </tr><tr class="terms_row"><td style="text-align:left"><input type="text" class="form-control" value="${terms_exp[1]}" name="terms_text[]"><input type="hidden" name="header_name[]" value="${terms_exp[0]}"> <input type="hidden" name="terms_sl[]" value="${terms_exp[2]}"></td><td> <a href="javascript:void(0)" class="btn btn-sm btn-danger remove-item-btn" title="Remove"><i class="fa fa-times-circle"></i></a></td></tr>`);


                }
            }
            //}, 1000)

        })

    }

    $('#add_item_btn_enable').on('click',function(){
        $('#add_item_btn').prop('disabled', false);

    })
</script>
