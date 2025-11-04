@php

$receive_chalan = isset($receive_chalan) && !empty($receive_chalan) ? $receive_chalan : [];

$serviceunit_no_pk = $receive_chalan ? $receive_chalan->store_su_no_fk : '';
$challan_no = $receive_chalan ? $receive_chalan->challan_no : '';
$supplier_no_pk = $receive_chalan ? $receive_chalan->supplier_no_fk : '';
$challan_date = $receive_chalan ? date('Y-m-d', strtotime($receive_chalan->challan_date)) : '';
$demand_no_fk = $receive_chalan ? $receive_chalan->demand_no_fk : '';
$itemreceive_no_pk = $receive_chalan ? $receive_chalan->itemreceive_no_pk : '';

@endphp
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('css/colors.css') }}">
<style>
    .list-group-item {
        background-color: transparent !important;
    }
</style>
<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
        <div class="col-md-9">
            <h5 class="mt-2 mb-0">New Item Receive</h5>
            <small>Store / New Item Receive</small>
        </div>
        <div class="col-md-3 mt-2">
            <div id="top-action">

                <a rel="tab" href="{{ url('inventory/item-received-worklist') }}" class="btn btn-outline-primary btn-md float-right"><i class="fa fa-desktop"></i>&nbsp;Item Recieve
                    List</a>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fa fa-plus"></i> New Receive by Challan </h5>
                </div>
                <div class="card-body border-bottom-3 p-2">
                    <form action="{{ route('inventory.new-item-receive') }}" id="item_receive_form" method="post">
                        <input type="hidden" name="receive_type" value="chalan">
                        <input type="hidden" class="keep_me" name="module_code" id="module_code" value="INVENTORY">
                        <input type="hidden" name="receive_id" value="{{ $itemreceive_no_pk }}">
                        <div class="form-row">

                            <div class="form-group col-md-2">

                                <label class="col-form-label col-form-label-sm" for="store_id">Store <span class="text-danger">*</span></label>
                                <select class="form-control select2" id="store_id" name="store_id">
                                    <option value="">Select Store</option>


                                    @if (!empty($stores))

                                    @foreach ($stores as $store)
                                    <option value="{{ $store->serviceunit_no_pk }}" @if ($serviceunit_no_pk==$store->serviceunit_no_pk) selected @endif>
                                        {{ $store->serviceunit_name }}
                                    </option>
                                    @endforeach

                                    @endif


                                </select>
                            </div>

                            <div class="form-group col-md-2">
                                <label class="col-form-label col-form-label-sm" for="store_id">Supplier <span class="text-danger">*</span></label>
                                <select class="form-control select2" id="supplier_id" name="supplier_id">
                                    <option value="">Select Supplier</option>

                                    @if (!empty($allSuppliers))
                                    @foreach ($allSuppliers as $allSupplier)
                                    <option value="{{ $allSupplier->supplier_no_pk }}" @if ($supplier_no_pk==$allSupplier->supplier_no_pk) selected @endif>
                                        {{ $allSupplier->supplier_name }}
                                    </option>
                                    @endforeach
                                    @endif


                                </select>
                            </div>


                            <div class="form-group col-md-2">
                                <label class="col-form-label col-form-label-sm" for="challan_no">Challan No
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control form-control-sm m-0" id="challan_no" name="challan_no" value="{{ $challan_no }}" placeholder="Challan No">
                            </div>

                            <div class="form-group col-md-2">
                                <label class="col-form-label col-form-label-sm" for="date">Date<span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm m-0 date_picker" id="date" name="date" value="{{ $challan_date }}" placeholder="dd-mm-yyyy">
                            </div>


                            <div class="form-group col-md-2">
                                <label class="col-form-label col-form-label-sm" for="demand_id">Purchase Order</label>
                                <input type="text" class="form-control form-control-sm m-0" id="po" name="in_purchaseorder_no_fk" value="{{ $demand_no_fk }}" placeholder="Purchase Order No" autocomplete="off">
                            </div>

                            <div class="form-group col-md-2">
                                <button type="button" id="populate" class="btn btn-success btn-block btn-md mt-4"><i class="fa fa-search"></i>
                                    Search
                                </button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-row">

                                    <div class="form-group col-md-1">
                                        <label class="col-form-label col-form-label-sm" for="">Item Code</label>
                                        <!-- <input type="text" class="form-control form-control-sm m-0" id="item_id" name="item_id" value="" placeholder="Item Code" > -->
                                        <input type="text" class="form-control form-control-sm m-0" id="item_code" name="item_code" value="" placeholder="Item Code">
                                        <input type="hidden" id="expiriable_ind" value="">
                                    </div>

                                    <div class="form-group col-md-2">
                                        <label class="col-form-label col-form-label-sm" for="item_name">Item
                                            Name</label> <span class="btn btn-sm btn-success float-right open-modal" data-modal="common-modal-md" data-action="{{ route('item.create-quick-item-po') }}" data-title="Create New Item">Create Item
                                        </span>
                                        <input type="hidden" name="item_id_hidden" id="item_id_hidden">
                                        {{-- <input type="text" class="form-control form-control-sm m-0" id="item_name"
                                            name="item_name" value="" placeholder="Item Name"> --}}
                                        <table width="100%">
                                            <tr>
                                                <td style="border: none"> <input type="text" class="form-control form-control-sm m-0" id="item_name" name="item_name" value="" placeholder="Item Name" autocomplete="off"></td>
                                                <td style="border: none;text-align:right" id="item_info"></td>
                                            </tr>
                                        </table>
                                    </div>


                                    <div class="form-group col-md-1">
                                        <label class="col-form-label col-form-label-sm" for="pr_item_uom_name">Item UoM</label>
                                        <input type="hidden" name="item_uom_hidden" id="item_uom_hidden">
                                        <input type="hidden" name="item_sales_uom" id="item_sales_uom">
                                        <input type="hidden" name="pr_item_uom_no" id="pr_item_uom_no">
                                        {{-- <input type="hidden" name="pr_item_uom_name" id="pr_item_uom_name"> --}}
                                        <input type="text" class="form-control form-control-sm m-0" id="pr_item_uom_name" name="pr_item_uom_name" value="" placeholder="Item UoM" readonly>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label class="col-form-label col-form-label-sm" for="item_uom">Item
                                            Conversion</label>

                                        <input type="text" class="form-control form-control-sm m-0" id="item_conversion" name="item_conversion" value="" placeholder="Item Conversion">
                                    </div>

                                    <div class="form-group col-md-1">
                                        <label class="col-form-label col-form-label-sm " for="item_price">Purchase
                                            Price</label>
                                        <input type="text" class="form-control form-control-sm m-0  number_only text-right" id="item_price" name="item_price" value="" placeholder="Item Price">
                                    </div>

                                    <div class="form-group col-md-1">
                                        <label class="col-form-label col-form-label-sm " for="sales_price">MRP</label>
                                        <input type="text" class="form-control form-control-sm m-0  number_only text-right" id="sales_price" name="sales_price" value="" placeholder="0" readonly="">
                                    </div>

                                    <div class="form-group col-md-1">
                                        <label class="col-form-label col-form-label-sm" for="item_quantity">Item
                                            Quantity</label>
                                        <input type="text" class="form-control form-control-sm m-0 number_only text-right" id="item_quantity" name="item_quantity" value="" placeholder="Item Quantity">
                                    </div>


                                    <div class="form-group col-md-1">
                                        <label class="col-form-label col-form-label-sm" for="in_total">Total</label>
                                        <input type="text" class="form-control form-control-sm m-0 number_only text-right" id="in_total" name="in_total" value="" placeholder="Total" readonly="">
                                    </div>

                                    <input type="hidden" name="vat_percent_itm" id="vat_percent_itm">
                                    <div class="form-group col-md-2">
                                        <button type="button" id="add_item_btn" class="btn btn-success btn-block btn-md mt-4"><i class="fa fa-plus"></i>
                                            Add
                                            Item
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </div>


                        <div class="row">
                            <div class="col-12 table-responsive">

                                <table id="" class="table data-table table-striped table-bordered table-hover">
                                    <thead class="bg-primary">
                                        <tr>
                                            <th class="text-center">SL</th>
                                            <th class="" width="">ID</th>
                                            <th class="text-center">Item Name</th>
                                            <th class="text-center">Item UoM</th>
                                            <th class="text-center">Purchase Price</th>
                                            <th class="text-center">MRP</th>
                                            <th class="text-right w-10">Received QTY</th>
                                            <th class="text-right w-10">Free QTY</th>
                                            <th class="text-right w-10">Total</th>
                                            <th class="text-center ">Vat(%)</th>
                                            <th class="text-center ">Vat Amount</th>
                                            <th class="text-center ">Discount(%)</th>
                                            <th class="text-center ">Discount Amount</th>
                                            <th class="text-center">Remarks</th>
                                            <th class="">Exp</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>

                                    <tbody id="items_to_receive">
                                        <?php
                                        $sl = 1;
                                        $total_amt = 0;
                                        ?>
                                        @if (!empty($item_list))

                                        @foreach ($item_list as $data)
                                        @php

                                        $edit_action = 'route("inventory.show-popup-item-batch",$data->item_no_pk."_".$data->entry_qty."_".$data->purchase_price)';

                                        @endphp

                                        <tr>
                                            <td class="sl-td">{{ $sl++ }}</td>
                                            <td class=""> <input type="hidden" id="item_id" name="item_id[]" value="{{ $data->item_no_pk }}"><input type="hidden" id="item_id" name="item_id_pre[]" value="{{ $data->item_no_pk }}">
                                                {{ $data->item_code }}
                                                <br>

                                                <span id="exp_itemShow_{{ $data->item_no_pk }}">

                                                    @foreach ($notExp_date as $kye => $item)
                                                    @if ($kye == $data->item_no_pk && $item->batch_no == null)
                                                    <input type="hidden" name="txt_expire_date[]" value="{{ $data->item_no_pk }}_0 "><input type="hidden" name="txt_batch[]" value="{{ $data->item_no_pk }}_0 "><input type="hidden" name="batch_qty[]" value="">

                                                    <input type="hidden" id="item_prices_{{ $data->item_no_pk }}" name="item_prices[]" value="{{ $data->item_no_pk . '_' . $data->pr_uom_tradeprice }}">
                                                    {{-- <input type="hidden" id="" name="item_prices_pre[]"
                                                                value="{{ $data->item_no_pk . '_' . $data->pr_uom_tradeprice }}"> --}}
                                                    <input type="hidden" id="item_uoms_{{ $data->item_no_pk }}" name="item_uoms[]" value=" {{ $data->item_no_pk . '_' . $data->pr_uom_no_fk }} " id="item_uoms_{{ $data->item_no_pk }}">
                                                    <input type="hidden" id="conversion_{{ $data->item_no_pk }}" name="conversion[]" id="conversion_{{ $data->item_no_pk }}" value="{{ $data->item_no_pk . '_' . $data->pr_uom_conversion_qty }}" />
                                                    @endif
                                                    @endforeach
                                                    @if (!empty($exp_date) && isset($exp_date))
                                                    @php
                                                    // dd($notExp_date);
                                                    $expire_data = '';
                                                    // dd($exp_date);
                                                    @endphp
                                                    {{-- @if ($kye == $data->item_no_pk) --}}

                                                    @foreach ($exp_date as $value)
                                                    @if ($value->item_no_fk == $data->item_no_pk && $value->batch_no != null)
                                                    @php
                                                    $free_qty = $data->freeitem_qty != '' ? $data->freeitem_qty : 0;
                                                    @endphp
                                                    <span class='btn btn-outline-primary bg-primary btn-sm mt-2 mr-2' id="exp_details_{{ $value->item_no_fk }}">{{ $value->batch_no }},{{ date('Y-m-d', strtotime($value->expiry_date)) }},{{ $value->item_qty +$free_qty .'_' .$value->trade_price .'_' .$value->pr_uom_no_fk .'_' .$value->pr_uom_conversion_qty }}</span>

                                                    <input type='hidden' id='item_prices_{{ $value->item_no_fk }}' name='item_prices[]' value="{{ $value->item_no_fk . '_' . $value->trade_price }}">
                                                    <input type="hidden" name="item_uoms[]" value=" {{ $value->item_no_fk . '_' . $data->pr_uom_no_fk }} " id="item_uoms_{{ $value->item_no_fk }}">
                                                    <input type="hidden" name="conversion[]" id="conversion_{{ $value->item_no_fk }}" value="{{ $value->item_no_fk . '_' . $data->pr_uom_conversion_qty }}" />

                                                    <span id="remove_ext_qty_{{ $value->item_no_fk }}">
                                                        <input type='hidden' name='txt_expire_date[]' value="{{ $value->item_no_fk . '_' . $value->expiry_date }}"><input type='hidden' name='txt_batch[]' value="{{ $value->item_no_fk . '_' . $value->batch_no }}"><input type='hidden' name='batch_qty[]' value="{{ $value->item_no_fk . '_' . ($value->item_qty + $free_qty) }}">

                                                        {{-- <input type='hidden'
                                                                                name='txt_expire_date_pre[]'
                                                                                value="{{ $value->item_no_fk . '_' . $value->expiry_date }}"><input type='hidden' name='txt_batch_pre[]' value="{{ $value->item_no_fk . '_' . $value->batch_no }}"><input type='hidden' name='batch_qty_pre[]' value="{{ $value->item_no_fk . '_' . $value->item_qty }}">
                                                        <input type="hidden" name="conversion_pre[]" id="conversion_{{ $value->item_no_fk }}" value="{{ $value->item_no_fk . '_' . $data->pr_uom_conversion_qty }}" /> --}}
                                                    </span>
                                                    @php

                                                    $expire_data .= $value->batch_no . '_' . date('d-m-Y', strtotime($value->expiry_date)) . '_' . $value->item_qty . '_' . $value->trade_price . '_' . $data->pr_uom_no_fk . '_' . $data->pr_uom_conversion_qty . '|';
                                                    @endphp
                                                    @endif
                                                    @endforeach
                                                    @php

                                                    $qty_id = $data->received_quantity . ':' . $data->item_no_pk;

                                                    @endphp
                                                    @if ($expire_data != '')
                                                    {{-- <span Class='btn btn-sm btn-primary open-modal mt-2 mr-2' data-id='' data-action="{{ route('inventory.item-batch-edit', $qty_id . '^' . $expire_data) }}" data-modal='common-modal-sm' data-title='Edit Expire'
                                                    title='Edit'><i class='fa fa-pencil-alt'></i></span> --}}
                                                @endif
                                                {{-- @endif --}}
                                                {{-- @endforeach --}}
                                                @endif
                                                </span>

                                                @if (!empty($exp_date) && isset($exp_date))
                                                @foreach ($exp_date as $value)
                                                @if ($value->item_no_fk == $data->item_no_pk && $value->batch_no != null)
                                                <input type='hidden' name='txt_expire_date_pre[]' value="{{ $value->item_no_fk . '_' . $value->expiry_date }}"><input type='hidden' name='txt_batch_pre[]' value="{{ $value->item_no_fk . '_' . $value->batch_no }}"><input type='hidden' name='batch_qty_pre[]' value="{{ $value->item_no_fk . '_' . $value->item_qty }}">
                                                <input type="hidden" name="conversion_pre[]" id="conversion_{{ $value->item_no_fk }}" value="{{ $value->item_no_fk . '_' . $data->pr_uom_conversion_qty }}" />
                                                @endif
                                                @endforeach
                                                @endif
                                            </td>
                                            <td class="text-center"> <input type="hidden" class="same-item-id" name="item_ids[]" value="{{ $data->item_no_pk }} "><input type="hidden" class="same-item-id" name="item_ids_pre[]" value="{{ $data->item_no_pk }} ">
                                                {{ $data->item_name }}
                                            </td>
                                            <td class="text-center"> <input type="hidden" name="item_uoms_pre[]" value=" {{ $data->item_no_pk . '_' . $data->pr_uom_no_fk }} ">{{ $data->pr_uom_short }}
                                            </td>
                                            <td class="text-center">
                                                <input type="hidden" id="" name="item_prices_pre[]" value="{{ $data->item_no_pk . '_' . $data->pr_uom_tradeprice }}">
                                                <span id="item_rate_container_{{ $data->item_no_pk }}">
                                                    {{-- <input type="hidden"
                                                                id="item_prices_{{ $data->item_no_pk }}"
                                                    name="item_prices[]"
                                                    value="{{ $data->item_no_pk . '_' . $data->pr_uom_tradeprice }}"> --}}
                                                    {{-- <input type="hidden" id="" name="item_prices_pre[]"
                                                                value="{{ $data->item_no_pk . '_' . $data->pr_uom_tradeprice }}"> --}}
                                                    {{-- <input type="hidden" name="item_uoms[]"
                                                                value=" {{ $data->item_no_pk . '_' . $data->pr_uom_no_fk }} "
                                                    id="item_uoms_{{ $data->item_no_pk }}">
                                                    <input type="hidden" name="conversion[]" id="conversion_{{ $data->item_no_pk }}" value="{{ $data->item_no_pk . '_' . $data->pr_uom_conversion_qty }}" /> --}}
                                                </span>                                              

                                                <input type='text' class='form-control form-control-sm m-0 tt-input text-right item-rate' name='' id='tradeprice_{{ $data->item_no_pk }}' value='{{ $data->pr_uom_tradeprice }}' onkeyup='EditTradePrice(this)'>
                                            </td>
                                            <td class="text-center"> <input type="hidden" id="purchase_price_{{ $data->item_no_pk }}" name="mrr[]" value="{{ $data->sales_price }}"><input type="hidden" id="" name="mrr_pre[]" value="{{ $data->sales_price }}">
                                                <input type="hidden" id="pr_uom_tradeprice_{{ $data->item_no_pk }}" name="" value="{{ $data->pr_uom_tradeprice }}">
                                                {{-- {{ $data->sales_price }} --}}
                                            </td>
                                            <td class="">
                                                @php
                                                $pr_convensetion_qty = $data->pr_uom_conversion_qty != '' ? $data->pr_uom_conversion_qty : 0;
                                                @endphp
                                                <input type="text" class="form-control form-control-sm m-0 tt-input text-right  item-qty" id="item_quantities_{{ $data->item_no_pk }}" data-item_id="{{ $data->item_no_pk }}" name="item_quantities_{{ $data->item_no_pk }}[]" value="{{ $data->pr_uom_qty }}" onkeyup="qtyedit(this)">
                                                <input type="hidden" class="form-control form-control-sm m-0 tt-input text-right" id="" data-item_id="{{ $data->item_no_pk }}" name="item_quantities_pre[]" value="{{ $pr_convensetion_qty != '' ? $pr_convensetion_qty * $data->pr_uom_qty : $pr_convensetion_qty }}" onkeyup="qtyedit(this)">

                                            </td>
                                            <td class=""> <input type="text" class="form-control form-control-sm m-0 tt-input text-right" id="free_quantities_{{ $data->item_no_pk }}" data-item_id="{{ $data->item_no_pk }}" name="free_quantities_{{ $data->item_no_pk }}[]" value="{{ $data->freeitem_qty }}" onkeyup="freeQty(this)">
                                                <input type="hidden" class="form-control form-control-sm m-0 tt-input text-right" id="" data-item_id="{{ $data->item_no_pk }}" name="free_quantities_pre[]" value="{{ $data->freeitem_qty }}">
                                                <input type="hidden" class="form-control form-control-sm m-0 tt-input text-right" id="" data-item_id="{{ $data->item_no_pk }}" name="free_uom_pre[]" value="{{ $data->freeitem_uom }}">

                                            </td>
                                            <td class="text-center"> <input type="text" readonly="readonly" id="hdn_in_total_{{ $data->item_no_pk }}" class="form-control form-control-sm m-0 text-right total_price" name="in_total[]" value="{{ $data->pr_uom_tradeprice * $data->pr_uom_qty }}">
                                            </td>
                                            <td class="text-center"><input type="text" class="form-control form-control-sm m-0 text-right item_vat " id="item_vat_{{$data->item_no_pk}}" name="item_vat[]" onkeyup="CalculatePerItemVat(this)" value="{{$data->vat_percent_itm }}" />

                                            </td>
                                            <td class="text-center"><input type="text" class="form-control form-control-sm m-0 text-right vat_amount " id="vat_amount_{{$data->item_no_pk}}" name="vat_amount[]" value="{{$data->vat_amount_itm }}" />

                                            </td>
                                            <td class="text-center"><input type="text" class="form-control form-control-sm m-0 text-right item_discount " id="item_discount_{{$data->item_no_pk}}" name="item_discount[]" value="{{$data->discount_percent_itm }}" onkeyup="CalculatePerItemDiscountPercente(this)" />

                                            </td>
                                            <td class="text-center"><input type="text" class="form-control form-control-sm m-0 text-right discount_amount " id="discount_amount_{{$data->item_no_pk}}" name="discount_amount[]" value="{{$data->discount_amount_itm }}" onkeyup="CalculatePerItemDiscountAmount(this)" />

                                            </td>

                                            <td class="text-center"><input type="text" class="form-control form-control-sm m-0" placeholder="Remarks Here" name="remarks[]" value="" />
                                                <input type="hidden" placeholder="" class="form-control form-control-sm m-0" name="sales_uom[]" value="{{ $data->sort_uom_no_fk }}" />
                                            </td>
                                            <td>
                                                @php
                                                $free_qty = $data->freeitem_qty != '' ? $data->freeitem_qty : 0;
                                                @endphp
                                                <span Class="btn btn-sm btn-warning open-modal" data-modal="common-modal-sm" data-id="" onclick="expUrlSet(this)" data-action=" {{ route('inventory.show-popup-item-batch',$data->item_no_pk .'_' .($data->pr_uom_qty + $free_qty) .'_' .$data->pr_uom_tradeprice .'_' .$data->pr_uom_no_fk .'_' .$data->pr_uom_conversion_qty) }} " data-title="Batch No" id="expiry_date_{{ $data->item_no_pk }}"><i class="fas fa-circle"></i></span>
                                            </td>
                                            <td> <a href="javascript:void(0)" class="btn btn-sm btn-danger remove-item-btn" data-record_id="{{ $data->item_no_pk }}" title="Remove"><i class="fa fa-times-circle"></i></a></td>
                                        </tr>

                                        @php
                                        $total_amt += $data->pr_uom_tradeprice * $data->pr_uom_qty;
                                        @endphp
                                        @endforeach
                                        @endif


                                    </tbody>
                                </table>
                            </div>
                        </div>


                        <!--
                            <div class="row">
                            <div class="col-12 text-right">
                                <button type="submit" class="btn btn-success btn-md"><i class="fa fa-save"></i> Save</button>
                                <button type="reset" class="btn btn-info btn-md" title="Click here to Clear form data">Clear</button>
                                <a href="" class="btn btn-danger btn-md" rel="tab" title="Click here to go back to Dashboard">Exit</a>
                            </div>

                        </div>
                    -->
                        <div class="form-row justify-content-end">

                            <div class="col-md-4  mt-2">
                                <ul class="list-group bg-light-blue list-group-flush bg-light-blue rounded mb-2 border">
                                    <li class="list-group-item">
                                        <h5 class="float-left mr-2">Total Amount</h5>
                                        <span class="float-right btn btn-outline-danger bg-none btn-md" id="item_total"> {{ $total_amt }}</span>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <span class="mr-2 float-left d-none">Service Charge</span>
                                                <div class="float-left d-none">
                                                    <input type="text" class="form-control mb-0" id="s_charge" name="s_charge" value="" placeholder="0.00" readonly="readonly" onkeyup="billingEngine.receiveItemCalculateTotal(this)" style="width: 70px; text-align: right;">
                                                </div>
                                            </div>
                                            <div class="col-md-12 text-right">
                                                <div class="text-center"><input type="radio" name="vat_cal" id="vat_p" onchange="vatCal(this)"> <label for="vat_p">Percent</label>
                                                    <input type="radio" name="vat_cal" id="vat_a" onchange="vatCal(this)"><label for="vat_a">Amount</label>
                                                </div>
                                                <span class="mr-2  ">VAT/Tax</span>
                                                <div class="float-right">
                                                    <input type="text" class="form-control float-right number_only" id="total_vat_amount" name="total_vat_amount" value="{{ isset($item_mst->vat_amount) ? $item_mst->vat_amount : '' }}" onkeyup="billingEngine.receiveItemCalculateTotal(this)" placeholder="0.00" style="width:150px; text-align: right;" readonly>

                                                    <input type="text" class="form-control float-right number_only" id="vat_percent" name="vat_percent" placeholder="%" style="width:100px; text-align: right;" onkeyup="billingEngine.receiveItemCalculateTotal(this)" value="0" readonly> (%)

                                                </div>

                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="form-row">
                                            <div class="col-md-6">
                                            </div>
                                            <div class="col-md-12 text-right">
                                                <div class="text-center"><input type="radio" name="dis_cal" id="dis_p" onchange="disCal(this)"> <label for="dis_p">Percent</label>
                                                    <input type="radio" name="dis_cal" id="dis_a" onchange="disCal(this)"> <label for="dis_a">Amount</label>
                                                </div>
                                                <span class="mr-2 ">Discount</span>
                                                <div class="float-right">
                                                    <input type="text" class="form-control float-right number_only" id="total_discount_amount" name="total_discount_amount" value="{{ isset($item_mst->discount_amount) ? $item_mst->discount_amount : '' }}" onkeyup="billingEngine.receiveItemCalculateTotal(this)" placeholder="0.00" style="width:150px; text-align: right;" readonly>

                                                    <input type="text" class="form-control float-right number_only" id="discount_percent" name="discount_percent" placeholder="%" style="width:100px; text-align: right;" onkeyup="billingEngine.receiveItemCalculateTotal(this)" value="0" readonly> (%)
                                                </div>
                                            </div>
                                        </div>
                                    </li>

                                    @php
                                    $dis = isset($item_mst->discount_amount) ? $item_mst->discount_amount : 0;
                                    $vat = isset($item_mst->vat_amount) ? $item_mst->vat_amount : 0;
                                    $payable = $total_amt + $vat - $dis;
                                    $adj_dis= $payable - floor($payable);
                                    @endphp
                                    <li class="list-group-item">
                                        <div class="form-row">
                                            <div class="col-md-6">
                                            </div>
                                            <div class="col-md-12 text-right">
                                                <span class="mr-2 ">Payable Amt.</span>
                                                <div class="float-right">
                                                    <input type="text" class="form-control float-right number_only" id="total_payable" name="" value="{{number_format($payable,2)}}" onkeyup="billingEngine.receiveItemCalculateTotal(this)" style="width:250px; text-align: right;" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="form-row">
                                            <div class="col-md-6">
                                            </div>
                                            <div class="col-md-12 text-right">
                                                <span class="mr-2 ">Adj. Discount</span>
                                                <div class="float-right">
                                                    <input type="text" class="form-control float-right number_only" id="adj_discount_amount" name="adj_discount_amount" value="{{number_format($adj_dis,2)}}" onkeyup="billingEngine.receiveItemCalculateTotal(this)" style="width:250px; text-align: right;" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="form-row">
                                            <div class="col-md-6">
                                            </div>
                                            <div class="col-md-12 text-right">
                                                {{-- <span class="mr-2 ">Return Amt.</span> --}}
                                                <div class="float-right">
                                                    {{-- <input type="text" class="form-control float-right number_only"
                                                        id="" name="return_amt"
                                                        value=""style="width:250px; text-align: right;"
                                                        readonly> --}}
                                                    <span class="btn btn-sm btn-warning open-modal m-2" data-modal="common-modal-md" data-id="" data-action="{{route('pharmacy.expire-return-adj',[$supplier_no_pk , $itemreceive_no_pk])}}" data-title="Return Adjestment" id="return_amt">Return list </span>
                                                    <span id="adj_hdn_data"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-12 text-right">
                                                <span class="mr-2 ">Return Adj. Amt.</span>
                                                <div class="float-right">

                                                    <input type="text" class="form-control float-right number_only" id="return_adj_amt" name="return_adj_amt" value="{{!empty($return_adj_amt)? round($return_adj_amt->adjustment_amount) : 0}}" onkeyup="rtn_adj_amt(this)" style="width:250px; text-align: right;">
                                                </div>

                                            </div>
                                        </div>
                                    </li>
                                    @php
                                    $adj_amt=!empty($return_adj_amt) ? round($return_adj_amt->adjustment_amount) : 0;

                                    @endphp
                                    <li class="list-group-item">
                                        <input type="hidden" class="form-control mb-0" id="total_due" name="total_due" value="{{ $payable -  ($adj_amt+$adj_dis) }}">

                                        <span class="float-right btn btn-outline-danger bg-none btn-md" id="total_due_data"> {{ $payable -   ($adj_amt+$adj_dis) }}</span>
                                        <h5 class="float-right mr-2">
                                            Payable Amount </h5>
                                    </li>

                                </ul>
                            </div>
                        </div>

                        <div class="row">
                            @php
                            $response_action = route('inventory.item_receive');
                            @endphp
                            <div class="col-12 text-right">

                                <button type="button" class="btn btn-md btn-danger" onclick="receiveIssue(this)" data-response_action="{{ $response_action }}" title="Stock out">Receive Cancel </button>
                                <button type="submit" class="btn btn-md btn-success" onclick="receiveChalan(this)" data-response_action="{{ $response_action }}">Save</button>



                                <button type="reset" class="btn btn-info btn-md" title="Click here to Clear form data">Clear
                                </button>

                                <a href="{{ route('admin-dashboard') }}" class="btn btn-danger btn-md" rel="tab" title="Click here to go back to Dashboard">Exit</a>

                            </div>

                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

</div>

<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>

<script>
    function rtn_adj_amt(element) {
        var total_rtn_adj_amt = $('#return_amt').html();
        var rtn_adj_amt = $('#return_adj_amt').val();
        var payable_amt = $('#total_payable').val();
        var adj_amt = $('#adj_discount_amount').val();
        var net_payable = ((payable_amt - adj_amt) - rtn_adj_amt).toFixed(2);


        if (rtn_adj_amt > (payable_amt - adj_amt)) {
            $('#return_adj_amt').val(0);
            billingEngine.receiveItemCalculateTotal(this);

        } else {
            $('#total_due_data').html(net_payable);
            $('#total_due').val(net_payable);
        }

    }

    function freeQty(element) {

        var id_price = $(element).attr('id');
        var id = id_price.split('_');
        var item_id = id[1];
        // var free_qty = $(element).val() != "" ? parseFloat($(element).val()) : 0;
        //var item_id = $(element).parent("td").parent("tr").find("#item_id").val();
        //console.log('halarpoid '+ element);
        var item_uom_no_id = $(element).parent("td").parent("tr").find('#item_uoms_' + item_id).val();
        var free_qty = parseFloat($(element).parent("td").parent("tr").find('#free_quantities_' + item_id).val());
        var item_quantity = parseFloat($(element).parent("td").parent("tr").find('#item_quantities_' + item_id).val()) +
            free_qty;
        var item_price_id = $(element).parent("td").parent("tr").find('#item_prices_' + item_id).val();
        var conversion_id = $(element).parent("td").parent("tr").find("#conversion_" + item_id).val();
        //console.log('halarpo_prothom'+item_uom_no_id);

        var item_uom_no = item_uom_no_id.split('_');
        var item_price = item_price_id.split('_');
        var conversion = conversion_id.split('_');
        // console.log($(element).val());
        console.log(free_qty, item_id, item_uom_no, item_quantity, item_price, conversion + 'freeItem');



        $('#remove_ext_qty_' + item_id).html(
            `<input type="hidden" name="txt_expire_date[]" value="${item_id}_0 "><input type="hidden" name="txt_batch[]" value="${item_id}_0 "><input type="hidden" name="batch_qty[]" value="">`
        );
        $('#exp_details_' + item_id).html('');

        var edit_action = "{{ route('inventory.show-popup-item-batch', ':id') }}";
        edit_action = edit_action.replace(':id', item_id + '_' + item_quantity + '_' + item_price[1] +
            '_' + item_uom_no[1] + '_' + conversion[1]);
        $('#expiry_date_' + item_id).attr("data-action", edit_action);
    }

    function expUrlSet(Element) {
        var id = $(Element).parent("td").parent("tr").find("#item_id").val();
        var p_price = $(Element).parent("td").parent("tr").find("#pr_uom_tradeprice_" + id).val();
        var qty = $(Element).parent("td").parent("tr").find("#item_quantities_" + id).val();
        var uom = $(Element).parent("td").parent("tr").find("#item_uoms_" + id).val();
        var uom_exp = uom.split('_');
        var conversion = $(Element).parent("td").parent("tr").find("#conversion_" + id).val();
        var conversion_exp = conversion.split('_');
        var edit_action = "{{ route('inventory.show-popup-item-batch', ':id') }}";
        edit_action = edit_action.replace(':id', +id + '_' + qty + '_' + p_price + '_' + uom_exp[1] + '_' +
            conversion_exp[1]);
        // $(Element).attr("data-action", "");
        // $(Element).attr("data-action", edit_action);

    }



    function vatCal(element) {
        $('#dis_p').focus();
        var vat_id = $(element).attr('id');
        if (vat_id == "vat_p") {
            $('#vat_percent').focus();
            $('#vat_percent').select();
            $('#total_vat_amount').val('');
            $('#vat_percent').attr('readonly', false);
            $('#total_vat_amount').attr('readonly', true);
        } else {
            $('#vat_percent').val('');
            $('#total_vat_amount').focus();
            $('#total_vat_amount').select();
            $('#total_vat_amount').attr('readonly', false);
            $('#vat_percent').attr('readonly', true);
        }

    }

    function disCal(element) {
        var dis_id = $(element).attr('id');
        if (dis_id == "dis_p") {
            $('#discount_percent').focus();
            $('#discount_percent').select();
            $('#discount_percent').attr('readonly', false);
            $('#total_discount_amount').attr('readonly', true);
        } else {
            $('#total_discount_amount').focus();
            $('#total_discount_amount').select();
            $('#total_discount_amount').attr('readonly', false);
            $('#discount_percent').attr('readonly', true);
        }
    }
    $(document).ready(function() {
        $("body").addClass("sidebar-collapse");
        $("#item_quantity").blur(function() {
            var item_price = $("#item_price").val();
            var item_quantity = $('#item_quantity').val();

            var in_total = Number(item_price) * Number(item_quantity);
            $("#in_total").val(parseFloat(in_total).toFixed(2));
        });


        $('.date_picker').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
            clearBtn: true,
        });
        openReceiveItemAutocomplete('#pvms_no', 'pvms_no', function(item, obj) {
            $('#item_id_hidden').val(item.item_id);
            $('#item_uom_hidden').val(item.uom_no_fk);
            $('#item_uom').val(item.uom_name);
            $('#item_name').val(item.item_name);
            obj.stopImmediatePropagation();

        });

        // openItemAutocomplete('#item_name');


        // jQuery('#input-field-id').bind('keypress', function(e) {
        //     e.stopPropagation();
        // });


        // $(document).on('blur change', '#item_name', function(e) {
        //     var keyCode = e.keyCode || e.which;

        //     if (keyCode == 9) {
        //         e.stopPropagation();
        //     } else {
        openReceiveItemAutocomplete('#item_name','INV', 'item_name', function(item, obj) {
            console.log(item);
            // alert(item.uom_no_fk);
            var purchase_price = item.purchase_price ? parseFloat(item.purchase_price) : 0;
            var item_price = parseFloat(item.item_rate);
            console.log(item.uom_no_fk);
            $('#item_id_hidden').val(item.item_id);
            $('#pr_item_uom_no').val(item.pr_uom_no_fk);
            $('#pr_item_uom_name').val(item.pr_uom_name);
            $('#item_uom_hidden').val(item.uom_no_fk);
            //$('#item_uom').val(item.uom_name);
            //$('#pvms_no').val(item.pvms_no);
            $('#item_code').val(item.item_code);
            $('#item_price').val(purchase_price);
            $('#sales_price').val(item_price);
            $('#item_id').val(item.item_id);
            $('#item_code').val(item.item_code);
            $('#item_name').val(item.item_name);
            $('#item_id_hidden').val(item.item_id);
            // $('#item_uom_hidden').val(item.uom_no_fk);
            $('#item_sales_uom').val(item.item_sales_uom);
            // $('#item_uom').val(item.uom_name);
            $('#expiriable_ind').val(item.expireable);
            $('#item_conversion').val(item.pr_uom_conversion_qty);
            $('#vat_percent_itm').val(item.vat_percent);
            var edit_action = "{{ route('item.edit-quick-item-po', ':id') }}";
            edit_action = edit_action.replace(':id', item.item_id);
            $('#item_info').html(
                `<span class="p-0 m-0 btn btn-sm btn-primary open-modal" data-id="${item.item_id}" data-action="${edit_action}" data-modal="common-modal-md" data-title="Edit Item" title="Edit"><i class="fa fa-pencil-alt"></i></span>`
            )
            obj.stopImmediatePropagation();
        });
        //     }
        // });

        // openReceiveItemAutocomplete('#item_name', 'item_name', function(item, obj) {
        //     // alert(item.uom_no_fk);
        //     var purchase_price = parseFloat(item.purchase_price);
        //     var item_price = parseFloat(item.item_rate);
        //     console.log(item.uom_no_fk);
        //     $('#item_id_hidden').val(item.item_id);
        //     $('#item_uom_hidden').val(item.uom_no_fk);
        //     $('#item_uom').val(item.uom_name);
        //     $('#pvms_no').val(item.pvms_no);
        //     $('#item_code').val(item.item_code);
        //     $('#item_price').val(purchase_price.toFixed(2));
        //     $('#sales_price').val(item_price.toFixed(2));
        //     // $('#item_id').val(item.item_id);
        //     obj.stopImmediatePropagation();
        // });


        openReceiveItemCodeAutocomplete('#item_code', 'item_code', function(item, obj) {
            var purchase_price = parseFloat(item.purchase_price);
            var item_price = parseFloat(item.item_rate);
            console.log(item.uom_no_fk);
            $('#item_id_hidden').val(item.item_id);
            $('#item_uom_hidden').val(item.uom_no_fk);
            $('#item_uom').val(item.uom_name);
            //$('#pvms_no').val(item.pvms_no);
            $('#item_code').val(item.item_code);
            $('#item_price').val(purchase_price.toFixed(2));
            $('#sales_price').val(item_price.toFixed(2));
            $('#item_id').val(item.item_id);
            $('#item_code').val(item.item_code);
            $('#item_name').val(item.item_name);
            $('#item_id_hidden').val(item.item_id);
            $('#item_uom_hidden').val(item.uom_no_fk);
            $('#item_uom').val(item.uom_name);
            $('#expiriable_ind').val(item.expireable);
            $('#item_conversion').val(item.pr_uom_conversion_qty);

            // alert(item.expireable)
            // console.log(item.expireable);
            obj.stopImmediatePropagation();
        });


        $(document).on('click', '#populate', function(e) {
            e.preventDefault();
            var purchase_order_id = $("#po").val();
            var module_code = $("#module_code").val();
            $.ajax({
                url: "{{ route('get_item_list_by_purchase_order') }}",
                type: 'get',
                data: {
                    module_code: module_code,
                    purchase_order_id: purchase_order_id
                },
                success: function(data) {
                    // console.log('supplier name', data[0].manufacturer_no_fk);
                    console.log(data);
                   
                    var uom_no_fk = '';
                    var uom_name = '';
                    var manufacturer = '';
                    $('#items_to_receive').html("");
                    for (i = 0; i < data.length; i++) {
                        if (data[i].supplier_no_fk) {
                            manufacturer = data[i].supplier_no_fk;
                        }
                        console.log('tajul' + manufacturer)
                        console.log(data[i] + "uom");
                        if (typeof data[i].pr_uom_no_fk == "undefined") {
                            uom_no_fk = "";
                            uom_name = "";
                        } else {
                            uom_no_fk = data[i].pr_uom_no_fk ? data[i].pr_uom_no_fk : "";
                            uom_name = data[i].uom_name ? data[i].uom_name : "";
                        }
                        console.log(data[i].item_no_pk+'_item_no')
                        var edit_action =
                            "{{ route('inventory.show-popup-item-batch', ':id') }}";
                        edit_action = edit_action.replace(':id', data[i].item_no_pk + '_' +
                            data[i].entry_qty + '_' + data[i].item_rate + '_' +
                            uom_no_fk + '_' + data[i].pr_uom_conversion_qty);

                        // var expiriable_ind = $('#expiriable_ind').val();
                        var expiry_date = data[i].expireable == 1 ?
                            '<span Class="btn btn-sm btn-warning open-modal" data-modal="common-modal-sm" data-id="" data-action="' +
                            edit_action +
                            '"   data-title="Batch No" id="expiry_date_' + data[i]
                            .item_no_pk + '"><i class="fas fa-circle" ></i></span>' : "";
                        var row = '<tr>' +
                            '<td class="sl-td">0</td>' +
                            '<td class=""> <input type="hidden" id="item_id"  name="item_id[]" value="' +
                            data[i].item_no_pk + '">' + data[i].item_code +
                            '<br>  <span id="exp_itemShow_' +
                            data[i].item_no_pk +
                            '"><input type="hidden" name="txt_expire_date[]" value="' +
                            data[i].item_no_pk + "_" + 0 +
                            '"><input type="hidden" name="txt_batch[]" value="' + data[i]
                            .item_no_pk + "_" + 0 +
                            '"><input type="hidden" name="batch_qty[]" value=""> </span></td>' +
                            '<td class="text-center"> <input type="hidden" class="same-item-id" name="item_ids[]" value="' +
                            data[i].item_no_pk +
                            '">' + data[i].item_name + '</td>' +
                            '<td class="text-center"> ' +
                            data[i].pr_uom_name + '</td>' +
                            '<td class="text-center"> <span id="item_rate_container_' +
                            data[i].item_no_pk +
                            '"><input type="hidden" id="item_uoms_' + data[i]
                            .item_no_pk + '" name="item_uoms[]" value="' + data[i]
                            .item_no_pk + '_' + data[i].pr_uom_no_fk +
                            '"><input type="hidden" placeholder="Remarks Here" class="form-control form-control-sm m-0" id="conversion_' +
                            data[i]
                            .item_no_pk + '"   name="conversion[]" value="' +
                            data[i].item_no_pk + '_' + data[i].pr_uom_conversion_qty +
                            '"/><input type="hidden" id="item_prices_' + data[i]
                            .item_no_pk +
                            '"  name="item_prices[]" value="' + data[i].item_no_pk + '_' +
                            data[i].item_rate + '"></span>' + '<input type="text" class="form-control form-control-sm m-0 tt-input text-right item-rate" name="" id="tradeprice_' + data[i].item_no_pk + '" value="' + data[i].item_rate + '" onkeyup="EditTradePrice(this)">' +
                            '</td>' +
                            '<td class="text-center"> <input type="hidden"  name="mrr[]" value="' +
                            data[i].item_rate +
                            '">' +Number( data[i].sales_price)  + '</td>' +
                            '<td class=""> <input type="text" class="form-control form-control-sm m-0 tt-input text-right item-qty" id="item_quantities_' +
                            data[i].item_no_pk + '" data-item_id="' + data[i].item_no_pk +
                            '"   name="item_quantities_' +
                            data[i].item_no_pk + '[]" value="' +
                            data[i].entry_qty + '" onkeyup="qtyedit(this)"></td>' +
                            '<td class=""> <input type="text" class="form-control form-control-sm m-0 tt-input text-right" id="free_quantities_' +
                            data[i].item_no_pk + '" data-item_id="' + data[i].item_no_pk +
                            '"   name="free_quantities_' +
                            data[i].item_no_pk +
                            '[]" value="" onkeyup="freeQty(this)"></td>' +
                            '<td class="text-center"> <input type="text" readonly="readonly" id="hdn_in_total_' +
                            data[i].item_no_pk +
                            '" class="form-control form-control-sm m-0 text-right total_price"   name="in_total[]" value="' +
                            parseFloat(data[i].item_rate * data[i].entry_qty)
                            .toFixed(
                                2) +
                            '"></td>' +
                            '<td class="text-center"> <input type="text"  id="item_vat_' +data[i].item_no_pk +'" class="item_vat form-control form-control-sm m-0 text-right"   name="item_vat[]" value="' +data[i].vat_percent +'" onkeyup="CalculatePerItemVat(this)"></td>' +'<td class="text-center"> <input type="text" id="vat_amount_' +
                            data[i].item_no_pk +'" class="vat_amount form-control form-control-sm m-0 text-right"   name="vat_amount[]" value="' +parseFloat(data[i].vat_amount)
                            .toFixed(2) +'"></td>' +'<td class="text-center"> <input type="text" onkeyup="CalculatePerItemDiscountPercente(this)" id="item_discount_' +
                            data[i].item_no_pk +
                            '" class="item_discount form-control form-control-sm m-0 text-right"   name="item_discount[]" value="' +
                            data[i].discount_percent +'"></td>' +
                            '<td class="text-center"> <input type="text" onkeyup="CalculatePerItemDiscountAmount(this)" id="discount_amount_' +
                            data[i].item_no_pk +
                            '" class="discount_amount form-control form-control-sm m-0 text-right"   name="discount_amount[]" value="' +
                            parseFloat(data[i].discount_amount)
                            .toFixed(
                                2) +
                            '"></td>' +
                            '<td><input type="text" placeholder="Remarks Here" class="form-control form-control-sm m-0"   name="remarks[]" value=""/> <input type="hidden" placeholder="Remarks Here" class="form-control form-control-sm m-0"   name="sales_uom[]" value="' +
                            data[i].uom_no_fk + '"/></td>' +
                            '<td>' + expiry_date + '</td>' +
                            '<td> <a href="javascript:void(0)" class="btn btn-sm btn-danger remove-item-btn" title="Remove" data-record_id="' + data[i].item_no_pk + '" data-record_rcv_qty="' + data[i].entry_qty + '"><i class="fa fa-times-circle"></i></a></td>' +
                            '</tr>';


                        $('#items_to_receive').append(row);
                        //console.log(data.manufacturer_no_fk);
                        $('#supplier_id').val(manufacturer).trigger('change');

                        $('#total_vat_amount').val(data[i].vat_amount);
                        $('#total_discount_amount').val(data[i].discount_amount);
                        var vat_amt = parseFloat(data[i].vat_amount).toFixed(2);
                        var dis_amt = parseFloat(data[i].discount_amount).toFixed(2);
                        $('#total_vat_amount').val(vat_amt);

                        $('#total_discount_amount').val(dis_amt);
                        $('#item_conversion').val('');
                        $('.sl-td').each(function(index, elem) {
                            $(elem).text(index + 1);
                        });

                    }

                    setTimeout(function() {
                        const total_amount = Number($('#item_total').text());
                        const total_vat_amount = Number($('#total_vat_amount').val());
                        const total_discount_amount = Number($('#total_discount_amount').val());
                        const total_payable = Number($('#total_payable').val());
                        const adj_discount_amount = Number($('#adj_discount_amount').val());
                        const total_dis_vat_adj = (total_vat_amount + total_discount_amount + adj_discount_amount);
                        const total_po_bill_payable = (total_amount - total_dis_vat_adj);
                        $('#total_due_data').text(total_po_bill_payable);

                    }, 1000)
                    billingEngine.receiveItemCalculateTotal(this);

                }
            });
            e.stopImmediatePropagation();
        });



        $(document).on('click', '#add_item_btn', function(e) {
            e.preventDefault()
            console.log($('#item_uom_hidden').val() + 'item uom');
            var pvms_no = $('#pvms_no').val();
            var item_name = $('#item_name').val();
            var item_id = $('#item_id').val();
            var item_code = $('#item_code').val();

            var item_id = $('#item_id_hidden').val();
            var item_uom_name = $('#item_uom').val();
            var item_uom_no = $('#item_uom_hidden').val();
            var item_quantity = $('#item_quantity').val();
            var item_price = $('#item_price').val();
            var item_prices = $('#item_prices').val();
            var sales_price = $('#sales_price').val();
            var purchase_price = $('#purchase_price').val();
            var in_totals = parseFloat($('#in_total').val());
            var in_total = parseFloat(in_totals.toFixed(2));
            var conversion = $("#item_conversion").val();
            var item_sales_uom = $("#item_sales_uom").val();

            var pr_item_uom_name = $('#pr_item_uom_name').val();
            var pr_item_uom_no = $('#pr_item_uom_no').val();
            var item_vat = $("#vat_percent_itm").val() ? $("#vat_percent_itm").val() : 0;


            var vat_amount_itm = 0;
            if (item_vat != null) {
                var total = item_quantity * item_price;
                var vat_amount_itm = parseFloat(total * (item_vat / 100)).toFixed(2);
            }

            $('textbox').removeAttr('readonly').val('Changed Value');


            if (item_id == '' || item_name == '') {
                alert('Item name cannot be blank.')
                return false
                e.stopImmediatePropagation();
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
                $('#pvms_no').val('');
                $('#item_id').val('');
                $('#item_code').val('');
                $('#item_name').val('');
                $('#item_id_hidden').val('');
                $('#item_uom').val('');
                $('#item_uom_hidden').val('');
                $('#item_quantity').val('');
                $('#item_price').val('');
                $('#sales_price').val('');
                $('#in_total').val('');
                $('#item_conversion').val('');
                e.stopImmediatePropagation();
                return false
            }


            var edit_action = "{{ route('inventory.show-popup-item-batch', ':id') }}";
            edit_action = edit_action.replace(':id', item_id + '_' + item_quantity + '_' + item_price +
                '_' + item_uom_no + '_' + conversion);

            var expiriable_ind = $('#expiriable_ind').val();
            var expiry_date = expiriable_ind == 1 ?
                '<span Class="btn btn-sm btn-warning open-modal" data-modal="common-modal-sm" id="expiry_date_' +
                item_id + '" data-action="' + edit_action +
                '"   data-title="Batch" ><i class="fas fa-circle" ></i></span>' : "";

            var row = '<tr>' +
                '<td class="sl-td">0</td>' +
                '<td class=""> <input type="hidden" id="item_id"  name="item_id[]" value="' + item_id +
                '">' + item_code + '<br>  <span id="exp_itemShow_' + item_id +
                '"><input type="hidden" name="txt_expire_date[]" value="' + item_id + "_" +
                0 + '"><input type="hidden" name="txt_batch[]" value="' + item_id + "_" + 0 +
                '"><input type="hidden" name="batch_qty[]" value=""> </span>' +
                '</td>' +
                '<td class="text-center"> <input type="hidden" class="same-item-id" name="item_ids[]" value="' +
                item_id +
                '">' + item_name + '</td>' +
                '<td class="text-center">' +
                pr_item_uom_name + '</td>' +
                '<td class="text-center"><span id="item_rate_container_' + item_id +
                '"> <input type="hidden" id="item_uoms_' + item_id + '" name="item_uoms[]" value="' +
                item_id + '_' + pr_item_uom_no +
                '"><input type="hidden" placeholder="Remarks Here" class="form-control form-control-sm m-0" id="conversion_' +
                item_id + '"  name="conversion[]" value="' +
                item_id + '_' +
                conversion + '"/> <input type="hidden" id="item_prices_' + item_id +
                '" name="item_prices[]" value="' + item_id + '_' +
                item_price + '"></span>' + '<input type="text" class="form-control form-control-sm m-0 tt-input text-right item-rate" name="" id="tradeprice_' + item_id + '" value="' + item_price + '" onkeyup="EditTradePrice(this)">' + '</td>' +
                '<td class="text-center"> <input type="hidden"  name="mrr[]" value="' + sales_price +
                '">' + sales_price + '</td>' +
                '<td class=""> <input type="text"  class="form-control form-control-sm m-0 text-right item-qty" id="item_quantities_' +
                item_id + '" data-item_id="' + item_id + '"   name="item_quantities_' + item_id +
                '[]" value="' + item_quantity + '" onkeyup="qtyedit(this)"></td>' +
                '<td class=""> <input type="text"  class="form-control form-control-sm m-0 text-right" id="free_quantities_' +
                item_id + '" data-item_id="' + item_id + '"   name="free_quantities_' + item_id +
                '[]" value="" onkeyup="freeQty(this)"></td>' +
                '<td class=""> <input type="text" readonly="readonly" id="hdn_in_total_' + item_id +
                '" class="form-control form-control-sm m-0 text-right total_price"  name="in_total[]" value="' +
                in_total +
                '"></td>' +
                '<td class="text-center"> <input type="text"  id="item_vat_' +

                item_id +
                '" class="item_vat form-control form-control-sm m-0 text-right"   name="item_vat[]"  onkeyup="CalculatePerItemVat(this)" value="' + item_vat + '"></td>' +
                '<td class="text-center"> <input type="text" id="vat_amount_' +
                item_id +
                '" class="vat_amount form-control form-control-sm m-0 text-right"   name="vat_amount[]" value="' + vat_amount_itm + '"></td>' +



                '<td class="text-center"> <input type="text" onkeyup="CalculatePerItemDiscountPercente(this)" id="item_discount_' +
                item_id +
                '" class="item_discount form-control form-control-sm m-0 text-right"   name="item_discount[]" value=""></td>' +



                '<td class="text-center"> <input type="text" onkeyup="CalculatePerItemDiscountAmount(this)" id="discount_amount_' +
                item_id +
                '" class="discount_amount form-control form-control-sm m-0 text-right"   name="discount_amount[]" value=""></td>' + '<td><input type="text" placeholder="Remarks Here" class="form-control form-control-sm m-0"   name="remarks[]" value=""/><input type="hidden" placeholder="Remarks Here" class="form-control form-control-sm m-0"   name="sales_uom[]" value="' +
                item_sales_uom + '"/></td>' +
                '<td>' + expiry_date + '</td>' +
                '<td> <a href="javascript:void(0)" class="btn btn-sm btn-danger remove-item-btn" title="Remove"><i class="fa fa-times-circle"></i></a></td>' +


                '</tr>';

            //  &nbsp; <span id="exp_itemShow_' +
            // item_id + '"><input type="hidden" name="txt_expire_date[]" value="' + item_id + "_" +
            // 0 + '"><input type="hidden" name="txt_batch[]" value="' + item_id + "_" + 0 +
            // '"><input type="hidden" name="batch_qty[]" value=""> </span>


            $('#items_to_receive').append(row);

            $('#pvms_no').val('');
            $('#item_name').val('');
            $('#item_id').val('');
            $('#item_code').val('');
            $('#item_id_hidden').val('');
            $('#item_uom').val('');
            $('#item_uom_hidden').val('');
            $('#item_quantity').val(0);
            $('#item_price').val(0);
            $('#sales_price').val(0);
            $('#in_total').val(0);
            CalculatePerItemVat(this);
            billingEngine.receiveItemCalculateTotal(this);
            $('.sl-td').each(function(index, elem) {
                $(elem).text(index + 1);
            });

            e.stopImmediatePropagation();

        });



        let item_total_price = [];
        $(document).on('click', '.remove-item-btn', function(e) {
            e.preventDefault();
            CalculatePerItemVat(this);
            CalculatePerItemDiscountPercente(this);
            CalculatePerItemDiscountAmount(this);
            let _this = $(this);
            let item_pur_price = $('#tradeprice_' + $(this).data('record_id'));
            let item_rcv_qty = $(this).data('record_rcv_qty');

            let item_price = Number($(item_pur_price).val() * item_rcv_qty);
            item_total_price.shift(item_price)
            item_total_price.push(item_price)


            const item_sum = item_total_price.reduce((item_prc_val, a) => item_prc_val + a, 0);

            let bill_summery = $('#item_total').text();

            $('#item_total').text(bill_summery - item_sum);

            var vat_id = $('input[name="vat_cal"]').attr('id');
            if (vat_id == "vat_p") {
                $('#vat_percent').focus();
                $('#vat_percent').attr('readonly', false);
                $('#total_vat_amount').attr('readonly', true);
            } else {
                $('#vat_percent').val('');
                $('#total_vat_amount').focus();
                $('#total_vat_amount').select();
                $('#total_vat_amount').attr('readonly', false);
                $('#vat_percent').attr('readonly', true);
            }

            var dis_id = $('input[name="dis_cal"]').attr('id');
            if (dis_id == "dis_p") {
                $('#discount_percent').focus();
                $('#discount_percent').select();
                $('#discount_percent').attr('readonly', false);
                $('#total_discount_amount').attr('readonly', true);
            } else {
                $('#total_discount_amount').focus();
                $('#total_discount_amount').select();
                $('#total_discount_amount').attr('readonly', false);
                $('#discount_percent').attr('readonly', true);
            }

            setTimeout(function() {

                billingEngine.receiveItemCalculateTotal($('#item_total'))

            }, 500)

            $(this).closest('tr').remove();
            $('.sl-td').each(function(index, elem) {
                $(elem).text(index + 1);
            })


            console.log('Item purchase price ', item_sum, bill_summery, item_total_price, _this.length);


            e.stopImmediatePropagation();
        });


        $(document).on('change', '#demand_id', function(e) {
            e.preventDefault()
            $.ajax({
                async: true,
                data: {
                    demand_pk: $(this).val()
                },
                url: "",
                type: 'post',
                beforeSend: function() {
                    if (isAModalOpen)
                        $('.modal').modal('hide');
                    blockUI();
                },
                success: function(data) {
                    var rows = ''
                    if (data.length > 0) {
                        var rows = ''
                        var same_item = ''
                        data.forEach(function(iteminfo) {
                            $('input[class=same-item-id]').each(function(index,
                                elm) {
                                if ($(elm).val() == iteminfo.item_no_fk) {
                                    same_item = iteminfo.item_no_fk
                                }
                            })
                            if (same_item != iteminfo.item_no_fk) {
                                rows += '<tr>' +
                                    '<td class="sl-td">0</td>' +
                                    '<td> <input type="hidden" name="pvms_nos[]" value="' +
                                    iteminfo.pvms_no + '">' + iteminfo.pvms_no +
                                    '</td>' +
                                    '<td> <input type="hidden" class="same-item-id" name="item_ids[]" value="' +
                                    iteminfo.item_no_fk + '">' + iteminfo
                                    .item_name + '</td>' +
                                    '<td> <input type="hidden" id="item_uoms_' +
                                    iteminfo.item_no_fk +
                                    '" name="item_uoms[]" value="' +
                                    iteminfo.uom +
                                    '"><input type="hidden" placeholder="Remarks Here" class="form-control form-control-sm m-0" id="conversion_' +
                                    iteminfo.item_no_fk +
                                    '"  name="conversion[]" value="' + iteminfo
                                    .item_no_fk + '_' + +'"/>' + iteminfo.uom_text +
                                    '</td>' +
                                    '<td class="text-right"> <input type="hidden"  name="item_prices[]" value="' +
                                    iteminfo.item_rate + '">' + iteminfo.item_rate +
                                    '</td>' +
                                    '<td class="text-right"> <input type="hidden"   name="item_quantities[]" value="' +
                                    iteminfo.entry_qty + '">' + iteminfo.entry_qty +
                                    '</td>' +
                                    '<td> <a href="javascript:void(0)" class="btn btn-sm btn-danger remove-item-btn" data-record_id="' + iteminfo.item_no_fk + '" title="Remove"><i class="fa fa-times-circle"></i></a></td>' +
                                    '</tr>'
                            }

                        })

                        $('#items_to_receive').append(rows);
                        $('.sl-td').each(function(index, elem) {
                            $(elem).text(index + 1)
                        })
                    } else {
                        alert('Sorry !!! No Data is found.')
                    }
                },
                error: function(data) {
                    var errors = jQuery.parseJSON(data.responseText).errors;
                    error_messages = "";
                    for (messages in errors) {
                        var field_name = $("#" + messages).siblings("label").html();
                        error_messages += "<div class='alert alert-danger' role='alert'>" +
                            errors[messages] + "</div>";
                    }

                    $('.common-modal-notify-error').modal('show');
                    $('.common-modal-notify-error .modal-title').html("Validation Error");
                    $('.common-modal-notify-error .modal-body').html(error_messages);

                    $.unblockUI();
                }
            }).done(function() {
                $.unblockUI();
            });
            e.stopImmediatePropagation();
        })
    });

    function calculateTotal(element, price) {
        var total = price * $(element).val();
        $(element).parent().next().find(".item_list").html(total);
    }

    function qtyedit(element) {
        var item_id = $(element).attr('data-item_id');
        console.log(item_id + item_id)
        var qty = $(element).parent("td").parent("tr").find("#item_quantities_" + item_id).val() != "" ? $(element).parent("td").parent("tr").find("#item_quantities_" + item_id).val() : 0;
        var item_rate_id = $(element).parent("td").parent("tr").find("#item_prices_" + item_id).val();
        // var item_rate_id = $(element).parent("td").parent("tr").find("#item_quantities_" + item_id).val();
        var item_rate_expl = item_rate_id.split("_");
        var item_rate = item_rate_expl[1];
        var total = parseFloat(qty) * parseFloat(item_rate);

        $('#remove_ext_qty_' + item_id).html(
            `<input type="hidden" name="txt_expire_date[]" value="${item_id}_0 "><input type="hidden" name="txt_batch[]" value="${item_id}_0 "><input type="hidden" name="batch_qty[]" value="">`
        );
        $('#exp_details_' + item_id).html('');
        var item_uom_no_id = $(element).parent("td").parent("tr").find('#item_uoms_' + item_id).val();
        var conversion_id = $(element).parent("td").parent("tr").find("#conversion_" + item_id).val();
        var item_uom_no = item_uom_no_id.split('_');
        var conversion = conversion_id.split('_');

        console.log(item_uom_no, conversion + "item edit");
        var edit_action = '{{ route('inventory.show-popup-item-batch', ':id') }}';
        edit_action = edit_action.replace(':id', item_id + '_' + qty + '_' + item_rate + '_' + item_uom_no[1] + '_' +
            conversion[1]);
        $(element).parent("td").parent("tr").find('#expiry_date_' + item_id).removeAttr("data-action");
        $(element).parent("td").parent("tr").find('#expiry_date_' + item_id).attr("data-action", edit_action);
        // $('#in_total_'+item_id).html(total);
        $(element).parent("td").parent("tr").find('#hdn_in_total_' + item_id).val(total.toFixed(2));
        // $(element).parent("td").parent("tr").find('#exp_itemShow_' + item_id).html("");
        var vat_percent_element = $(element).parents('td').parent("tr").find(".item_vat")[0];
        var discount_element = $(element).parents('td').parent("tr").find(".discount_amount")[0];
        CalculatePerItemVat(vat_percent_element);
        CalculatePerItemDiscountAmount(discount_element);

        // $(element).parent("td").parent("tr").find('#item_rate_container_' + item_id).html(
        //     '<input type="hidden" id="item_prices_' + item_id + '" name="item_prices[]" value="' + item_id + '_' +
        //     item_rate + '">');
        // $('#item_quantity').val(total);
        // console.log(expiry);
        billingEngine.receiveItemCalculateTotal(this);

    }

    // save

    function receiveIssue(thisElement) {
        event.preventDefault();

        var formID = $(thisElement).parents("form").attr("id");
        var formAction = $(thisElement).parents("form").attr("action");
        var formMethod = $(thisElement).parents("form").attr("method");

        if (formValidation(formID) == false) {
            return;
        }

        if (confirm("Are You Sure?")) {

            $.ajax({
                async: true,
                data: $('#' + formID).serialize(),
                url: "{{ route('inventory.new-item-receive-issue') }}",
                type: formMethod,
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {
                    console.log(data.no)
                    // $("#hdn_patient_id").val(data.insert_id);
                    // $("#patient_id").val(data.patient_name);


                    // $("#" + formID + " input[name=hdn_patient_id]").val(data.insert_id);
                    var url = '{{ route('grn-report-print-inv-vat', ':id') }}';
                    url = url.replace(":id", data.no);
                    $('.common-modal-notify').modal('show');
                    $('.common-modal-notify .modal-body').html(
                        "<i class='fas fa-stroopwafel fa-spin'></i>");
                    $('.common-modal-notify .modal-title').html(data.title);
                    $('.common-modal-notify .modal-body').html(data.msg);

                    $("#" + formID).find("input, textarea").not('.keep_me').val("");
                    $("#" + formID).find("select").not('.keep_me').val("0");
                    $("#items_to_receive").html('');
                    $("#vat_percent").val('');
                    $("#total_vat_amount").val('');
                    $("#discount_percent").val('');
                    $("#total_discount_amount").val('');
                    $("#total_due_data").html(0);
                    $("#item_total").html(0);

                },
                complete: function() {
                    if (isAModalOpen)
                        $('.modal').modal('hide');
                    $.unblockUI();
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
                    $('.common-modal-notify-error .modal-title').html("Validation Error");

                    $.unblockUI();
                }
            });
        }

        event.stopImmediatePropagation();
    }

    function receiveChalan(thisElement) {
        event.preventDefault();

        var formID = $(thisElement).parents("form").attr("id");
        var formAction = $(thisElement).parents("form").attr("action");
        var formMethod = $(thisElement).parents("form").attr("method");

        if (formValidation(formID) == false) {
            return;
        }

        if (confirm("Are You Sure?")) {

            $.ajax({
                async: true,
                data: $('#' + formID).serialize(),
                url: formAction,
                type: formMethod,
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {
                    console.log(data.no)


                    // $("#hdn_patient_id").val(data.insert_id);
                    // $("#patient_id").val(data.patient_name);


                    // $("#" + formID + " input[name=hdn_patient_id]").val(data.insert_id);
                    var url = '{{ route('grn-report-print-inv-vat', ':id') }}';
                    url = url.replace(":id", data.no);
                    $('.common-modal-notify').modal('show');
                    $('.common-modal-notify .modal-body').html(
                        "<i class='fas fa-stroopwafel fa-spin'></i>");
                    $('.common-modal-notify .modal-title').html(data.title);
                    $('.common-modal-notify .modal-body').html(data.msg +
                        `<br>  <a href='${url}'  class='btn btn-primary btn-md cursor-pointer text-center' target='_blank' data-id='${url}' id='grn_report' title='Print GRN Report'>GRN Report</a>`
                    );

                    $("#" + formID).find("input, textarea").not('.keep_me').val("");
                    $("#" + formID).find("select").not('.keep_me').val("0");
                    $("#items_to_receive").html('');
                    $("#vat_percent").val('');
                    $("#total_vat_amount").val('');
                    $("#discount_percent").val('');
                    $("#total_discount_amount").val('');
                    $("#total_due_data").html(0);
                    $("#item_total").html(0);

                },
                complete: function() {
                    if (isAModalOpen)
                        $('.modal').modal('hide');
                    $.unblockUI();
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
                    $('.common-modal-notify-error .modal-title').html("Validation Error");

                    $.unblockUI();
                }
            });
        }

        event.stopImmediatePropagation();
    }

    function EditTradePrice(element) {
        var id_price = $(element).attr('id');
        var id = id_price.split('_');
        var item_id = id[1];
        var t_price = $(element).val() != "" ? $(element).val() : 0;
        $(element).parent("td").parent("tr").find('#item_prices_' + item_id).val(item_id + '_' + t_price);


        freeQty(element);


        var qty = $(element).parent("td").parent("tr").find("#item_quantities_" + item_id).val() != "" ? $(element).parent("td").parent("tr").find("#item_quantities_" + item_id).val() : 0;
        var item_rate_id = $(element).parent("td").parent("tr").find("#item_prices_" + item_id).val();
        // var item_rate_id = $(element).parent("td").parent("tr").find("#item_quantities_" + item_id).val();
        var item_rate_expl = item_rate_id.split("_");
        var item_rate = item_rate_expl[1];
        var total = parseFloat(qty) * parseFloat(item_rate);

        $('#remove_ext_qty_' + item_id).html(
            `<input type="hidden" name="txt_expire_date[]" value="${item_id}_0 "><input type="hidden" name="txt_batch[]" value="${item_id}_0 "><input type="hidden" name="batch_qty[]" value="">`
        );
        $('#exp_details_' + item_id).html('');
        var item_uom_no_id = $(element).parent("td").parent("tr").find('#item_uoms_' + item_id).val();
        console.log('halarpo' + item_uom_no_id);
        var conversion_id = $(element).parent("td").parent("tr").find("#conversion_" + item_id).val();
        var item_uom_no = item_uom_no_id.split('_');
        var conversion = conversion_id.split('_');

        console.log(item_uom_no, conversion + "item edit");
        var edit_action = '{{ route('inventory.show-popup-item-batch', ':id') }}';
        edit_action = edit_action.replace(':id', item_id + '_' + qty + '_' + item_rate + '_' + item_uom_no[1] + '_' +
            conversion[1]);
        $(element).parent("td").parent("tr").find('#expiry_date_' + item_id).removeAttr("data-action");
        $(element).parent("td").parent("tr").find('#expiry_date_' + item_id).attr("data-action", edit_action);
        // $('#in_total_'+item_id).html(total);
        $(element).parent("td").parent("tr").find('#hdn_in_total_' + item_id).val(total.toFixed(2));
        // $(element).parent("td").parent("tr").find('#exp_itemShow_' + item_id).html("");

        var vat_percent_element = $(element).parents('td').parent("tr").find(".item_vat")[0];
        var discount_element = $(element).parents('td').parent("tr").find(".discount_amount")[0];
        CalculatePerItemVat(vat_percent_element);
        CalculatePerItemDiscountAmount(discount_element);

        // $(element).parent("td").parent("tr").find('#item_rate_container_' + item_id).html(
        //     '<input type="hidden" id="item_prices_' + item_id + '" name="item_prices[]" value="' + item_id + '_' +
        //     item_rate + '">');
        // $('#item_quantity').val(total);
        // console.log(expiry);
        billingEngine.receiveItemCalculateTotal(this);
    }

    function CalculatePerItemVat(thisElement) {

        if ($("#items_to_receive tr").length > 0) {

            var qty = $(thisElement).parents('td').siblings().find(".item-qty").val();
            console.log(qty + '_tajqty')
            var price = $(thisElement).parents('td').siblings().find(".item-rate").val();
            console.log(price + '_tajprice')
            var total = qty * price;
            var vat = $(thisElement).val();
            var vat_amount = parseFloat(total * (vat / 100)).toFixed(2);
            console.log('tajul vat cal' + vat_amount)

            $(thisElement).parents('td').siblings().find('.vat_amount').val(vat_amount);
            var total_vat = 0;
            var item_total = 0;
            var total_discount = 0;
            console.log(total_vat + " every time total_vat");
            // total_vat = $('#total_vat_amount').val();
            //alert(total_vat);
            $("#items_to_receive tr").each(function() {

                total_vat += $(this).children('td').siblings().find(".vat_amount").val() * 1;
                item_total += $(this).find(".total_price").val() * 1;
                total_discount += $(this).children('td').siblings().find(".discount_amount").val() * 1;

            });
            $('#total_vat_amount').val(total_vat.toFixed(2));
            console.log(total_vat + '_tajul challan total_vat')
            // $("#total_due_data").html(Math.floor((item_total + total_vat) - total_discount).toFixed(2));
            billingEngine.receiveItemCalculateTotal(this);


        }
    }

    function CalculatePerItemDiscountPercente(thisElement) {
        if ($("#items_to_receive tr").length > 0) {

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
            $("#items_to_receive tr").each(function() {

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
            // $("#total_payable").val(((final_total + urg)).toFixed(2));
            $("#total_payable").val(Math.floor((item_total + total_vat) - total_discount).toFixed(2));
            $("#total_due_data").html(Math.floor((item_total + total_vat) - total_discount).toFixed(2));
        }
    }

    function CalculatePerItemDiscountAmount(thisElement) {
        console.log('dt');
        if ($("#items_to_receive tr").length > 0) {


            var total_discount = 0;
            var item_total = 0;
            var total_vat = 0;
            $("#items_to_receive tr").each(function() {

                total_discount += $(this).children('td').siblings().find(".discount_amount").val() * 1;
                item_total += $(this).find(".total_price").val() * 1;
                total_vat += $(this).children('td').siblings().find(".vat_amount").val() * 1;


            });


            console.log('total_discount_test' + total_discount);
            // console.log('item_total_test'+item_total);
            $('#total_discount_amount').val(total_discount.toFixed(2));
            //  console.log(total_vat+'_total_vat')
            // $("#total_due_data").html(Math.floor((item_total + total_vat) - total_discount).toFixed(2));
            billingEngine.receiveItemCalculateTotal(this);
        }
    }
</script>