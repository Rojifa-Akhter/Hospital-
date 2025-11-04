<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

{{-- {{ dd($item_cat_sub_data_1) }} --}}
@php
    $item = isset($item) && !empty($item) ? $item : [];
    $item_no_pk = $item ? $item->item_no_pk : '';
    $item_name = $item ? $item->item_name : '';
    $item_code = $item ? $item->item_code : '';
    $item_short_name = $item ? $item->item_short_name : '';
    $generic_no_fk = $item ? $item->generic_no_fk : '';
    $generic_name = $item ? $item->generic_name : '';
    $itemtype_no_fk = $item ? $item->itemtype_no_fk : '';
    $itemtype_db = $item ? $item->item_type : '';
    $serviceunit_no_fk = $item ? $item->serviceunit_no_fk : '';
    $uom_no_fk = $item ? $item->uom_no_fk : '';
    $item_pack_type = $item ? $item->pack_type : '';
    $manufacturer_no_fk = $item ? $item->manufacturer_no_fk : '';
    $supplier_pk_no = $item ? $item->supplier_pk_no: '';
    $default_discount_pct = $item ? $item->default_discount_pct : '';
    // $pack_type = $item ? $item->pack_type : '';
    $main_store =$item ? $item->mainstore_su_no_fk : '';
    $sales_price = $item ? $item->sales_price : '';
    $purchase_price = $item ? $item->purchase_price : '';
    $temperature = $item ? $item->temperature : '';
    $re_order_level = $item ? $item->re_order_level : '';
    $reorder_type = $item ? $item->reorder_type : '';
    $dealer_sales_price = $item ? $item->dealer_sales_price : '';
    $urgent_fee_amt = $item ? $item->urgent_fee_amt : '';

    $vat_percent = $item ? $item->vat_percent : '';
    $item_cat = $item && isset($item->item_cat) ? $item->item_cat : '';
    $item_cat_sub = $item && isset($item->item_cat_sub) ? $item->item_cat_sub : '';
    $item_cat_sub_2 = $item && isset($item->item_cat_sub_2) ? $item->item_cat_sub_2 : '';
    $item_cat_sub_1 = $item && isset($item->item_cat_sub_1) ? $item->item_cat_sub_1 : '';
    $pkg_referral_ind = $item ? $item->pkg_referral_ind : '';
    $item_status = $item ? $item->status : '';
    $item_rate_ind = $item ? $item->manual_item_rate_ind : '';
    $pr_uom_no_fk = $item ? $item->pr_uom_no_fk : '';
    $pr_uom_conversion_qty = $item ? $item->pr_uom_conversion_qty : '';
    $pr_box_qty = $item ? $item->pr_box_qty : '';
    $pr_uom_tradeprice = $item ? $item->pr_uom_tradeprice : '';
    $expireable_ind = $item ? $item->expireable : '';
    $dis_inapplicable = $item ? $item->disc_aplicable : '';
    $refferral_pay_calc_ind = $item ? $item->refferral_pay_calc_ind : '';
    $non_stock_ind = $item ? $item->non_stock_ind : '';
    $analyzer_ind = $item ? $item->analyzer_ind : '';
    $asset_ind = $item ? $item->asset_ind : '';
    $accounts_mapping_su_no_fk = $item ? $item->accounts_mapping_su_no_fk : '';

    $expensive_ind = $item ? $item->expensive_ind : '';
    $freezing_ind = $item ? $item->freezing_ind : '';
    $slow_moving_ind = $item ? $item->slow_moving_ind : '';
    $narcoticdrug_ind = $item ? $item->narcoticdrug_ind : '';
    $package_ind = $item ? $item->package_ind : '';
    $referral_pay_amt = $item ? $item->referral_pay_amt : '';
    $referral_pay_pct = $item ? $item->referral_pay_pct : '';
    $provider_pay_amt = $item ? $item->provider_pay_amt : '';
    $provider_pay_pct = $item ? $item->provider_pay_pct : '';
    $housekeeping_ind = $item ? $item->housekeeping_ind : '';
    $washable_ind = $item ? $item->housekeeping_washable_ind : '';
    $mrp_ind = $item ? $item->mrp_ind : '';

@endphp

<form method="post" id="frm-item-store" action="{{ route('item.store') }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" value="{{ $item_no_pk }}">

    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link col-form-label s-12 active" id="basic-tab" data-toggle="tab" href="#basic"
                role="tab" aria-controls="basic" aria-selected="true">Basic</a>
        </li>

        <li class="nav-item" role="presentation">
            <a class="nav-link col-form-label s-12" id="advanced-tab" data-toggle="tab" href="#advanced" role="tab"
                aria-controls="advanced" aria-selected="false">Advanced</a>
        </li>
    </ul>

    <div class="tab-content p-0" id="myTabContent">
        <div class="tab-pane fade show active" id="basic" role="tabpanel" aria-labelledby="basic-tab">
            <div class="form-group row">
                <label for="item_code" class="col-sm-2 col-form-label col-form-label-sm">Item Code <span
                        class="text-danger">*</span></label>
                <div class="col-sm-4">
                    <input type="text" class="form-control form-control-sm" id="item_code" name="item_code"
                        value="{{ $item_code }}" placeholder="Enter Item Code" required>
                </div>


                <label for="item_name" class="col-sm-2 col-form-label col-form-label-sm">Item Name <span
                        class="text-danger">*</span></label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="item_name" name="item_name"
                        value="{{ $item_name }}" placeholder="Enter Item Name" required>
                </div>


                {{-- <label for="item_short_name" class="col-sm-2 col-form-label col-form-label-sm">Short Name <span
                        class="text-danger">*</span></label>
                <div class="col-sm-4">
                    <input type="text" class="form-control form-control-sm" id="item_short_name"
                        name="item_short_name" value="{{ $item_short_name }}" placeholder="Enter Item Short Name"
                        required>
                </div> --}}
                <label for="item_short_name" class="col-sm-2 col-form-label col-form-label-sm">Short Name </label>
                <div class="col-sm-4">
                    <input type="text" class="form-control form-control-sm" id="item_short_name"
                        name="item_short_name" value="{{ $item_short_name }}" placeholder="Enter Item Short Name"
                        >
                </div>

                <label for="item_generic_name" class="col-sm-2 col-form-label col-form-label-sm">Generic Name </label>
                <div class="col-sm-4">
                    <input type="text" class="form-control item_generic_name" id="item_generic_name"
                        name="item_generic_name" value="{{ $generic_name }}">
                    <input type="hidden" class="form-control" id="item_generic_id" name="item_generic_id"
                        value="{{ $generic_no_fk }}">
                </div>

                @if (strtoupper(Session::get('user.ses_hospital_code')) != 'MCARE')
                    <label for="item_type" class="col-sm-2 col-form-label col-form-label-sm">Report Header <span
                            class="text-danger">*</span></label>
                    <div class="col-sm-4">
                        <select class="form-control font_size_12 m-auto select2" id="item_type" name="item_type"
                            required>
                            <option value="">Select Report Header</option>
                            @if (isset($item_type))
                                @foreach ($item_type as $val)
                                    <option value="{{ $val->itemtype_no_pk }}"
                                        {{ $itemtype_no_fk == $val->itemtype_no_pk ? 'selected' : '' }}>
                                        {{ ucwords(strtolower($val->item_name)) }}</option>
                                @endforeach
                            @endif

                        </select>
                    </div>

                    <label for="item_type" class="col-sm-2 col-form-label col-form-label-sm">Item Type<span
                            class="text-danger">*</span></label>
                    <div class="col-sm-4">
                        <select class="form-control font_size_12 m-auto select2" id="item_type_lookup" name="item_type_lookup"
                            required>
                            <option value="">Select Item Type</option>

                            @if (isset($item_type_lookup))
                                @foreach ($item_type_lookup as $key => $val)
                                    <option value="{{ $key }}"
                                        {{ $itemtype_db == $key ? 'selected' : '' }}>
                                        {{ ucwords(strtolower($val.' ('.$key.')')) }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                @else
                    <label for="item_type" class="col-sm-2 col-form-label col-form-label-sm">Item Type <span
                            class="text-danger">*</span></label>
                    <div class="col-sm-4">
                        <select class="form-control font_size_12 m-auto select2" id="item_type" name="item_type"
                            required>
                            <option value="">Select Item Type</option>
                            @if (isset($item_type))
                                @foreach ($item_type as $key => $val)
                                    <option value="{{ $key }}"
                                        {{ $itemtype_no_fk == $key ? 'selected' : '' }}>
                                        {{ ucwords(strtolower($val)) }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                @endif


                @if (strtoupper(Session::get('user.ses_hospital_code')) != 'MCARE')
                    <label for="service_unit" class="col-sm-2 col-form-label col-form-label-sm">Service Unit</label>
                    <div class="col-sm-4">
                        <select class="form-control font_size_12 m-auto select2" id="service_unit"
                            name="service_unit">
                            <option value="">Select Service Unit</option>
                            @if (isset($service_unit))
                                @foreach ($service_unit as $val)
                                    <option value="{{ $val->serviceunit_no_pk }}"
                                        {{ $serviceunit_no_fk == $val->serviceunit_no_pk ? 'selected' : '' }}>
                                        {{ $val->serviceunit_name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                @endif

                <label for="mainstore_su_no_fk" class="col-sm-2 col-form-label">Main Store</label>
                    <div class="col-sm-4">
                        <select class="form-control form-control-sm select2" id="mainstore_su_no_fk" name="mainstore_su_no_fk">
                            <option value="">Select main
                                store</option>
                            @if (isset($main_store_list))
                            @foreach ($main_store_list as $val)
                            <option value="{{ $val->serviceunit_no_pk }}" @if (!empty($item)) {{ $main_store == $val->serviceunit_no_pk ? 'selected' : '' }} @endif>
                                {{ $val->serviceunit_name }}
                            </option>
                            @endforeach
                            @endif
                        </select>
                    </div>



                <label for="item_uom" class="col-sm-2 col-form-label col-form-label-sm">UoM</label>
                <div class="col-sm-4 mt-1">
                    <select class="form-control font_size_12 m-auto" id="item_uom" name="item_uom">
                        <option value="">Select Item UoM</option>
                        @if (isset($uom))
                            @foreach ($uom as $key => $val)
                                <option value="{{ $key }}" {{ $uom_no_fk == $key ? 'selected' : '' }}>
                                    {{ $val }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <label for="purchase_uom" class="col-sm-2 col-form-label col-form-label-sm">Purchase UoM</label>
                <div class="col-sm-4 mt-1">
                    <select class="form-control font_size_12 m-auto select2" id="purchase_uom" name="purchase_uom">
                        <option value="">Select Item UoM</option>
                        @if (isset($uom))
                            @foreach ($uom as $key => $val)
                                <option value="{{ $key }}" {{ $pr_uom_no_fk == $key ? 'selected' : '' }}>
                                    {{ $val }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <label for="item_pack_type" class="col-sm-2 col-form-label col-form-label-sm">Pack Type</label>
                <div class="col-sm-4 mt-1">
                    {{-- @dd($item_pack_type) --}}
                    <select class="form-control font_size_12 m-auto" id="item_pack_type" name="item_pack_type">
                        <option value="">Select Pack Type</option>

                        @if (isset($pack_type))

                            @foreach ($pack_type as $key => $val)
                                <option value="{{ $val }}" {{ $item_pack_type == $val ? 'selected' : '' }}>
                                    {{ $val }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <label for="supplier_name"
                    class="col-sm-2 col-form-label col-form-label-sm">Supplier</label>
                <div class="col-sm-4">
                    <select class="form-control font_size_12 m-auto select2" id="supplier_name" name="supplier_name">
                        <option value="">Select </option>
                        @if (!empty($suppiler_arr))
                            @foreach ($suppiler_arr as $supplier)
                                <option value="{{ $supplier->supplier_no_pk }}"
                                    {{ $supplier_pk_no == $supplier->supplier_no_pk ? 'selected' : '' }}>
                                    {{ $supplier->supplier_name }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>

                {{-- Manufacturer --}}
                <label for="manufacturer_no_fk"
                    class="col-sm-2 col-form-label col-form-label-sm">Manufacturer</label>
                <div class="col-sm-4">
                    <select class="form-control font_size_12 m-auto select2" id="manufacturer_no_fk" name="manufacturer_no_fk">
                        <option value="">Select </option>
                        @if (!empty($suppiler_arr))
                            @foreach ($suppiler_arr as $supplier)
                                <option value="{{ $supplier->supplier_no_pk }}"
                                    {{ $manufacturer_no_fk == $supplier->supplier_no_pk ? 'selected' : '' }}>
                                    {{ $supplier->supplier_name }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <label for="item_sales_price" class="col-sm-2 col-form-label col-form-label-sm">Sales Price <span
                        class="text-danger">*</span></label>
                <div class="col-sm-4">
                    <input type="text" class="form-control form-control-sm number_only" id="item_sales_price"
                        name="item_sales_price" value="{{ $sales_price }}" placeholder="Item Sales Price" required>
                </div>

                <label for="item_purchase_price" class="col-sm-2 col-form-label col-form-label-sm">Box Purchase Price
                </label>
                <div class="col-sm-4">
                    <input type="text" class="form-control form-control-sm number_only" onkeyup="calculatePrice()"
                        onfocus="calculatePrice()" id="box_purchase_price" name="box_purchase_price"
                        value="{{ $pr_uom_tradeprice }}" placeholder="Item Purchase Price">
                </div>

                <label for="item_purchase_price" class="col-sm-2 col-form-label col-form-label-sm">Item Conversion Qty
                </label>
                <div class="col-sm-4">
                    <input type="text" class="form-control form-control-sm number_only" onkeyup="calculatePrice()"
                        onfocus="calculatePrice()" id="box_conversion_qty" name="box_conversion_qty"
                        value="{{ $pr_uom_conversion_qty }}" placeholder="Item Conversion Qty">
                </div>

                <label for="item_purchase_price" class="col-sm-2 col-form-label col-form-label-sm">Purchase Price
                </label>
                <div class="col-sm-4">
                    <input type="text" class="form-control form-control-sm number_only" id="item_purchase_price"
                        name="item_purchase_price" value="{{ $purchase_price }}" placeholder="Item Purchase Price">
                </div>


                <label for="re_order_type" class="col-sm-2 col-form-label col-form-label-sm">Re Order Type</label>
                <div class="col-md-4">
                    <select name="re_order_type" id="re_order_type" class="form-control">
                        <option value="">Select One</option>
                        <option value="F" {{ $reorder_type == 'F' ? 'selected' : '' }}>Fix Quantity</option>
                        <option value="D" {{ $reorder_type == 'D' ? 'selected' : '' }}>Days Quantity</option>
                        <option value="P" {{ $reorder_type == 'P' ? 'selected' : '' }}>Dynamic Process</option>
                    </select>
                </div>

                <label for="accounts_service_unit" class="col-sm-2 col-form-label col-form-label-sm">Accounts Mapping
                    SU</label>
                <div class="col-sm-4">
                    <select class="form-control font_size_12 m-auto select2" id="accounts_service_unit"
                        name="accounts_service_unit">
                        <option value="">Select Service Unit</option>
                        @if (isset($service_unit))
                            @foreach ($service_unit as $val)
                                <option value="{{ $val->serviceunit_no_pk }}"
                                    {{ $accounts_mapping_su_no_fk == $val->serviceunit_no_pk ? 'selected' : '' }}>
                                    {{ $val->serviceunit_name }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <label for="re_order_level" class="col-sm-2 col-form-label col-form-label-sm">Re Order Level</label>
                <div class="col-md-4">
                    <input type="text" class="form-control form-control-sm" id="re_order_type"
                        name="re_order_level" value="{{ $re_order_level }}" placeholder="Re Order Level">
                </div>

                <label for="stock_type" class="col-sm-2 col-form-label col-form-label-sm">Stock Type</label>
                <div class="col-sm-4">
                    <select class="form-control font_size_12 m-auto select2" id="stock_type" name="stock_type">
                        <option value="">Select One</option>
                        <option value="1" {{ $non_stock_ind == 1 ? 'selected' : '' }}>Non Stockable </option>

                        <option value="2" {{ $non_stock_ind == 2 ? 'selected' : '' }}>Stock </option>

                    </select>
                </div>

                <label for="slow_moving_ind" class="col-sm-2 col-form-label col-form-label-sm">Slow Moving</label>
                <div class="col-sm-4">

                    {{-- <input class="form-check-input" type="checkbox" name="slow_moving_ind" id="slow_moving_ind"
                            value="1" {{ $slow_moving_ind == '1' ? 'checked' : '' }}> --}}
                    <select class="form-control  font_size_12 m-auto select2" name="slow_moving_ind"
                        id="slow_moving_ind">
                        <option value="">Select Moving</option>
                        <option value="1" {{ $slow_moving_ind == '1' ? 'selected' : '' }}>Slow</option>
                        <option value="2" {{ $slow_moving_ind == '2' ? 'selected' : '' }}>Fast</option>
                    </select>

                </div>


                <label for="ref_payment" class="col-sm-2 col-form-label col-form-label-sm">Referral Payment</label>
                <div class="col-sm-4">

                    <select class="form-control  font_size_12 m-auto select2" name="ref_payment" id="ref_payment">
                        <option value="">Select</option>
                        <option value="1" {{ $refferral_pay_calc_ind == '1' ? 'selected' : '' }}>Include
                        </option>
                        <option value="0" {{ $refferral_pay_calc_ind == '0' ? 'selected' : '' }}>Exclude
                        </option>
                    </select>

                </div>
                <label for="referral_pay_pct" class="col-sm-2 col-form-label col-form-label-sm">Referral Pay
                    Amount(%)</label>
                <div class="col-md-4">
                    <input type="text" class="form-control form-control-sm mt-2" id="referral_pay_pct"
                        name="referral_pay_pct" value="{{ $referral_pay_pct }}"
                        placeholder="Referral Pay Amount(%)">
                </div>

                <label for="referral_pay_amt" class="col-sm-2 col-form-label col-form-label-sm">Referral Pay
                    Amount</label>
                <div class="col-md-4">
                    <input type="text" class="form-control form-control-sm mt-2" id="referral_pay_amt"
                        name="referral_pay_amt" value="{{ $referral_pay_amt }}" placeholder="Referral Pay Amount">
                </div>

                <label for="provider_pay_pct" class="col-sm-2 col-form-label col-form-label-sm">Provider Pay Amount
                    (%)</label>
                <div class="col-md-4">
                    <input type="text" class="form-control form-control-sm" id="re_order_type"
                        name="provider_pay_pct" value="{{ $provider_pay_pct }}"
                        placeholder="Provider Pay Amount (%)">
                </div>

                <label for="pr_box_qty" class="col-sm-2 col-form-label col-form-label-sm">PR Box Qty.
                </label>
                <div class="col-sm-4">
                    <input type="text" class="form-control form-control-sm number_only" id="pr_box_qty" name="pr_box_qty"
                        value="{{ $pr_box_qty }}" placeholder="PR Box Qty.">
                </div>


                <label for="default_discount_pct" class="col-sm-2 col-form-label col-form-label-sm">Default Discount (%)</label>
                <div class="col-md-4">
                    <input type="text" class="form-control form-control-sm" id="re_order_type"
                        name="default_discount_pct" value="{{ $default_discount_pct }}"
                        placeholder="Default Discount (%)">
                </div>

                <label for="provider_pay_amt" class="col-sm-2 col-form-label col-form-label-sm">Provider Pay
                    Amount</label>
                <div class="col-md-4">
                    <input type="text" class="form-control form-control-sm" id="re_order_type"
                        name="provider_pay_amt" value="{{ $provider_pay_amt }}" placeholder="Provider Pay Amount">
                </div>
                <label for="rate_ind" class="col-sm-2 col-form-label col-form-label-sm">Item Rate</label>
                <div class="col-sm-4">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="rate_ind" id="rate_ind"
                            value="1" {{ $item_rate_ind == '1' ? 'checked' : '' }}>

                    </div>
                </div>

                <label for="rate_ind" class="col-sm-2 col-form-label col-form-label-sm">Expireable</label>
                <div class="col-sm-4">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="expireable_ind" id="Expireable"
                            value="1" {{ $expireable_ind == '1' ? 'checked' : '' }}>

                    </div>
                </div>
                <label for="pkg_ref" class="col-sm-2 col-form-label col-form-label-sm">Pkg referal</label>
                <div class="col-sm-4">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="pkg_ref_ind" id="pkg_ref_ind"
                            value="1" {{ $pkg_referral_ind == '1' ? 'checked' : '' }}>

                    </div>
                </div>

                <label for="item_status" class="col-sm-2 col-form-label col-form-label-sm">Status</label>
                <div class="col-sm-4">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="item_status" id="item_status"
                            value="1" {{ $item_status == '1' ? 'checked' : '' }}>

                    </div>
                </div>
                <label for="dis_inapplicable" class="col-sm-2 col-form-label col-form-label-sm">Dis
                    Inapplicable</label>
                <div class="col-sm-4">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="dis_inapplicable"
                            id="dis_inapplicable" value="1" {{ $dis_inapplicable == '1' ? 'checked' : '' }}>

                    </div>
                </div>



                <label for="ref_payment" class="col-sm-2 col-form-label col-form-label-sm">Fixed Asset</label>
                <div class="col-sm-4">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="asset_ind" id="asset_ind"
                            value="1" {{ $asset_ind == '1' ? 'checked' : '' }}>

                    </div>
                </div>

                <label for="analyzer" class="col-sm-2 col-form-label col-form-label-sm">Analyzer Ind</label>
                <div class="col-sm-4">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="analyzer_ind" id="analyzer_ind"
                            value="1" {{ $analyzer_ind == '1' ? 'checked' : '' }}>


                    </div>
                </div>



                {{-- For Stock   --}}

                <label for="expensive_ind" class="col-sm-2 col-form-label col-form-label-sm">Expensive</label>
                <div class="col-sm-4">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="expensive_ind" id="expensive_ind"
                            value="1" {{ $expensive_ind == '1' ? 'checked' : '' }}>

                    </div>
                </div>

                <label for="tempature_ind" class="col-sm-2 col-form-label col-form-label-sm">Temparature</label>
                <div class="col-sm-4">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="tempature_ind" id="tempature_ind"
                            value="1" {{ $freezing_ind == '1' ? 'checked' : '' }}>


                    </div>
                </div>



                <label for="narcotic_ind" class="col-sm-2 col-form-label col-form-label-sm">Narcotic</label>
                <div class="col-sm-4">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="narcotic_ind" id="narcotic_ind"
                            value="1" {{ $narcoticdrug_ind == '1' ? 'checked' : '' }}>


                    </div>
                </div>

                <label for="package_ind" class="col-sm-2 col-form-label col-form-label-sm">Package Ind</label>
                <div class="col-sm-4">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="package_ind" id="package_ind"
                            value="1" {{ $package_ind == '1' ? 'checked' : '' }}>


                    </div>
                </div>



                <label for="housekeeping_ind" class="col-sm-2 col-form-label col-form-label-sm">Housekeeping</label>
                <div class="col-sm-4">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="housekeeping_ind" id="housekeeping_ind"
                            value="1" {{ $housekeeping_ind == '1' ? 'checked' : '' }}>


                    </div>
                </div>

                <label for="washable_ind" class="col-sm-2 col-form-label col-form-label-sm">Washable</label>
                <div class="col-sm-4">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="washable_ind" id="washable_ind"
                            value="1" {{ $washable_ind == '1' ? 'checked' : '' }}>


                    </div>
                </div>

                <label for="mrp_ind" class="col-sm-2 col-form-label col-form-label-sm">MRP</label>
                <div class="col-sm-4">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="mrp_ind" id="mrp_ind"
                            value="1" {{ $mrp_ind == '1' ? 'checked' : '' }}>
                    </div>
                </div>



                {{-- end  --}}

            </div>
        </div>

        <div class="tab-pane fade" id="advanced" role="tabpanel" aria-labelledby="advanced-tab">
            <div class="form-group row">
                <label for="item_dealers_price" class="col-sm-2 col-form-label col-form-label-sm">Dealer Price</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control form-control-sm number_only" id="item_dealers_price"
                        name="item_dealers_price" value="{{ $dealer_sales_price }}" placeholder="Item Dealer Price">
                </div>

                <label for="urgent_fee_amt" class="col-sm-2 col-form-label col-form-label-sm">Discount Fee</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control form-control-sm number_only" id="urgent_fee_amt"
                        name="urgent_fee_amt" value="{{ $urgent_fee_amt }}" placeholder="Item Discount fee">
                </div>

                @if (strtoupper(Session::get('user.ses_hospital_code')) != 'MCARE')
                    <label for="urgent_fee_amt" class="col-sm-2 col-form-label col-form-label-sm">Emergency
                        Fee</label>
                    <div class="col-sm-4">
                        <input type="number" class="form-control form-control-sm number_only" id="urgent_fee_amt"
                            name="urgent_fee_amt" value="{{ $urgent_fee_amt }}" placeholder="Item urgent fee">
                    </div>
                @endif

                @if (strtoupper(Session::get('user.ses_hospital_code')) != 'MCARE')
                    <label for="temperature" class="col-sm-2 col-form-label col-form-label-sm">Temperature</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control form-control-sm" id="temperature"
                            name="temperature" value="{{ $temperature }}" placeholder="Temperature">
                    </div>
                @endif



                @if (strtoupper(Session::get('user.ses_hospital_code')) != 'MCARE')
                    <label for="item_vat_persent" class="col-sm-2 col-form-label col-form-label-sm">VAT (%)</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control form-control-sm number_only" id="item_vat_persent"
                            name="item_vat_persent" value="{{ $vat_percent }}"
                            placeholder="Enter Item item_vat_persent">
                    </div>
                @endif

                <label for="item_photo" class="col-sm-2 col-form-label col-form-label-sm">Item Photo</label>
                <div class="col-sm-4">
                    <input type="file" class="form-control" id="item_photo" name="item_photo">
                </div>

                <label for="item_photo" class="col-sm-2 col-form-label col-form-label-sm">Item Photo 1</label>
                <div class="col-sm-4">
                    <input type="file" class="form-control" id="item_photo" name="item_photo1">
                </div>

                <label for="item_photo" class="col-sm-2 col-form-label col-form-label-sm">Item Photo 2</label>
                <div class="col-sm-4">
                    <input type="file" class="form-control" id="item_photo" name="item_photo2">
                </div>

                <label for="item_photo" class="col-sm-2 col-form-label col-form-label-sm">Item Photo 3</label>
                <div class="col-sm-4">
                    <input type="file" class="form-control" id="item_photo" name="item_photo3">
                </div>

                <div class="col-sm-6">
                </div>

                <div class="col-sm-12">
                    <label for="" class=" col-form-label col-form-label-sm">E-Commerce</label>
                </div>

                <label for="item_uom" class="col-sm-2 col-form-label col-form-label-sm">Item Category</label>
                <div class="col-sm-4">
                    <select class="form-control font_size_12 m-auto" data-type="1" id="item_category"
                        onchange="getSubCategory(this)" name="item_category">
                        <option value="">Select Item Category</option>
                        @if (isset($item_cat_data))
                            @foreach ($item_cat_data as $key => $value)
                                <option value="{{ $key }}" {{ $item_cat == $value ? 'selected' : '' }}>
                                    {{ $value }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <label for="item_pack_type" class="col-sm-2 col-form-label col-form-label-sm">Item Category
                    Sub</label>
                <div class="col-sm-4">
                    <select class="form-control font_size_12 m-auto" data-type="2" onchange="getSubCategory(this)"
                        id="item_category_sub" name="item_category_sub">
                        <option value="">Select Item Category sub</option>
                        @if (isset($item_cat_data_sub))
                            @foreach ($item_cat_data_sub as $key => $val)
                                <option value="{{ $key }}" {{ $item_cat_sub == $val ? 'selected' : '' }}>
                                    {{ $val }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <label for="item_uom" class="col-sm-2 col-form-label col-form-label-sm">Item Category Sub 1</label>
                <div class="col-sm-4">
                    <select class="form-control font_size_12 m-auto" id="item_category_sub_1"
                        onchange="getSubCategory(this)" data-type="3" name="item_category_sub_1">
                        <option value="">Select Item Category 1</option>
                        @if (isset($item_cat_sub_data_1))
                            @foreach ($item_cat_sub_data_1 as $key => $val)
                                <option value="{{ $key }}" {{ $item_cat_sub_1 == $val ? 'selected' : '' }}>
                                    {{ $val }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <label for="item_pack_type" class="col-sm-2 col-form-label col-form-label-sm">Item Category Sub
                    2</label>
                <div class="col-sm-4">
                    <select data-type="4" class="form-control font_size_12 m-auto" onchange="getSubCategory(this)"
                        id="item_category_sub_2" name="item_category_sub_2">
                        <option value="">Select Item Category 2</option>
                        @if (isset($item_cat_sub_data_2))
                            @foreach ($item_cat_sub_data_2 as $key => $val)
                                <option value="{{ $key }}" {{ $item_cat_sub_2 == $val ? 'selected' : '' }}>
                                    {{ $val }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <label for="item_status" class="col-sm-12 col-form-label col-form-label-sm">Item Short
                    Description (Data insert to this column: note_text)</label>
                <div class="col-sm-12">
                    <textarea name="short_desc" class="form-control" id="" cols="30" rows="2"></textarea>
                </div>

                <label for="item_status" class="col-sm-12 col-form-label col-form-label-sm">Item Long
                    Description (Data insert to this column: plain_text)</label>
                <div class="col-sm-12">
                    <textarea name="long_desc" class="form-control" id="" cols="30" rows="4"></textarea>
                </div>


            </div>
        </div>

    </div>

    <div class="form-row">
        <div class="col-md-12 mt-3">
            @php
                $doctor_id = '';
                $response_url = route('med.item-ist');
            @endphp
            <button class="btn btn-md btn-success" id="save_update" data-func=""
                data-response-url="{{ $response_url }}"
                title="Click here to save Medicine Item Information">Save</button>
            <button type="button" class="btn btn-md btn-danger " data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-md btn-info " data-dismiss="modal">Exit</button>
        </div>
    </div>
</form>



<script src="{{ asset('js/typeahead.bundle.js') }}"></script>




<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
    $('.select2').select2();

    function calculatePrice() {
        var box_purchase_price = $('#box_purchase_price').val();
        var box_conversion_qty = $('#box_conversion_qty').val();
        $('#item_purchase_price').val('');
        if (box_purchase_price != '' && box_conversion_qty != '') {
            var price = box_purchase_price / box_conversion_qty;
            $('#item_purchase_price').val(price.toFixed(2));
        }


    }

    $(document).on("click", '#save_update', function(e) {
        e.stopImmediatePropagation();

        let _item_purchase_price = parseFloat($("#item_purchase_price").val());
        let _item_sales_price = parseFloat($("#item_sales_price").val());

        if(_item_purchase_price > _item_sales_price) {
            alert("Sales price must be less than or equal to purchase price.");
        }

        if (confirm("Are you sure?")) {
            var page_type = "{{ $page_type }}";
            $('#frm-item-store').unbind().submit(function(e) {
                e.preventDefault();
                var formAction = $(this).attr("action");
                var formMethod = $(this).attr("method");
                var formData = new FormData(this);
                var customFunc = $("#save_update").attr("data-func");

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

                            $('.common-modal-notify').modal('show');
                            $('.common-modal-notify .modal-body').html(
                                "<i class='fas fa-stroopwafel fa-spin'></i>"
                            );
                        }
                        blockUI();
                    },
                    success: function(data) {
                        if (data.title == 'Success') {
                            $('.common-modal-notify').modal('show');
                            $('.common-modal-notify .modal-body').html(
                                "<i class='fas fa-stroopwafel fa-spin'></i>");
                            $('.common-modal-notify .modal-title').html(data.title);
                            $('.common-modal-notify .modal-body').html(data.msg);
                            var response_url = $("#save_update").attr("data-response-url");
                            // dynamicFunc.afterSaveLoadList(response_url);

                            // marketing
                            //$("#referrer_name_con").val(data.insert_id);

                            $(this).find("input, textarea").not('.keep_me').val("");
                            $(this).find("select").not('.keep_me').val("0");
                        }
                    },
                    error: function(data) {
                        console.log(data);
                    },
                    complete: function() {
                        $.unblockUI();
                        if (page_type == 'edit')
                            dynamicFunc.afterSaveLoadList("{{ route('item.index') }}");
                    },
                    error: function(data) {
                        var errors = jQuery.parseJSON(data.responseText).errors;
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
                            error_messages);
                        finished = false;
                        $.unblockUI();
                    }
                });
            });
            e.stopImmediatePropagation();
        }else {

            return false;
          }
    });


    function getSubCategory(element) {
        var type = $(element).attr('data-type');
        var category_id = $(element).val();
        var action = "{{ route('get-category-wise-sub-category') }}";
        $.ajax({
            url: action,
            type: "get",
            data: {
                type: type,
                category_id: category_id
            },
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $.unblockUI();
                console.log(type);
                if (type == 1) {
                    $("#item_category_sub").html(data);
                    $("#item_category_sub_1").html('');
                    $("#item_category_sub_2").html('');
                }
                if (type == 2) {
                    $("#item_category_sub_1").html(data);
                    $("#item_category_sub_2").html('');
                }
                if (type == 3) {
                    $("#item_category_sub_2").html(data);
                    $("#item_category_sub_3").html('');
                }



            },
            complete: function(data) {

            }
        });

    }
    $(document).on('keyup', '#item_generic_name', function() {
        if ($(this).val() == "") {
            $('#item_generic_id').val('');
        }
    })

    $(document).ready(function() {
    // যখন কোনো বাটনে ক্লিক করবে তখন চেক করবে
    $("#checkButton").click(function() {
        var value = $("#item_type_lookup").val();
        if (value != '' || value == 'RAD' || value == 'PROC') {
            alert("Please give service unit name");
        }
    });
});

    openItemAutocompleteGeneric("#item_generic_name", "#item_generic_id");
</script>
