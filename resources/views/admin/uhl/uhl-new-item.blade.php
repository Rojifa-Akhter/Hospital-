<main id="page-content">
    <link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
    <link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
    <style>
        .my-custom-scrollbar {
            position: relative;
            height: 190px;
            overflow-y: auto;
        }

        .table-wrapper-scroll-y {
            display: block;
        }

        .table-responsive {
            display: block;
            width: 100%;
            overflow-x: auto !important;
            -webkit-overflow-scrolling: touch !important;
        }
    </style>
    @php
        // dd($item);
        //dd($item->mainstore_su_no_fk);
        $item_no_pk = $item ? $item->item_no_pk : '';
        $item_name = $item ? $item->item_name : '';
        $item_code = $item ? $item->item_code : '';
        $item_short_name = $item ? $item->item_short_name : '';
        //dd($item_short_name);
        $generic_no_fk = $item ? $item->generic_no_fk : '';
        $generic_name = $item ? $item->generic_name : '';
        $itemtype_no_fk = $item ? $item->itemtype_no_fk : '';
        $serviceunit_no_fk = $item ? $item->serviceunit_no_fk : '';
        $main_store = $item ? $item->mainstore_su_no_fk : '';
        $uom_no_fk = $item ? $item->uom_no_fk : '';
        $item_pack_type = $item ? $item->pack_type : '';
        $manufacturer_no_fk = $item ? $item->manufacturer_no_fk : '';
        // $pack_type = $item ? $item->pack_type : '';
        $itemtype_db = $item ? $item->item_type : '';
        if (Session::get('user.ses_hospital_code') == "KPJ"){
            $crg_group_db = $item ? $item->crg_group : '';
        }
        
        $sales_price = $item ? $item->sales_price : '';
        $purchase_price = $item ? $item->purchase_price : '';
        $temperature = $item ? $item->temperature : '';
        $re_order_level = $item ? $item->re_order_level : '';
        $reorder_type = $item ? $item->reorder_type : '';
        $dealer_sales_price = $item ? $item->dealer_sales_price : '';
        $urgent_fee_amt = $item ? $item->urgent_fee_amt : '';
        
        $vat_percent = $item ? $item->vat_percent : '';
        $item_cat = $item && isset($item->item_cat_lookupdata_no_fk) ? $item->item_cat_lookupdata_no_fk : '';
        $item_cat_sub = $item && isset($item->item_cat_sub) ? $item->item_cat_sub : '';
        $item_cat_sub_2 = $item && isset($item->item_cat_sub_2) ? $item->item_cat_sub_2 : '';
        $item_cat_sub_1 = $item && isset($item->item_cat_sub_1) ? $item->item_cat_sub_1 : '';
        $pkg_referral_ind = $item ? $item->pkg_referral_ind : '';
        $item_status = $item ? $item->status : '';
        $item_rate_ind = $item ? $item->manual_item_rate_ind : '';
        $pr_uom_no_fk = $item ? $item->pr_uom_no_fk : '';
        $pr_uom_conversion_qty = $item ? $item->pr_uom_conversion_qty : '';
        $pr_uom_tradeprice = $item ? $item->pr_uom_tradeprice : '';
        $expireable_ind = $item ? $item->expireable : '';
        $dis_inapplicable = $item ? $item->disc_aplicable : '';
        $refferral_pay_calc_ind = $item ? $item->refferral_pay_calc_ind : '';
        $non_stock_ind = $item ? $item->non_stock_ind : '';
        $analyzer_ind = $item ? $item->analyzer_ind : '';
        $asset_ind = $item ? $item->asset_ind : '';
        $accounts_mapping_su_no_fk = $item ? $item->accounts_mapping_su_no_fk : '';
        $purchase_discount = $item ? $item->purchasediscount_pct : '';
        $closeforindent_ind = $item ? $item->closeforindent_ind : '';
        $closeforsales_ind = $item ? $item->closeforsales_ind : '';
        $consignment_ind = $item ? $item->consignment_ind : '';
        $slow_moving_ind = $item ? $item->slow_moving_ind : '';
        $profile_allow_ind = $item ? $item->profile_allow_ind : '';
        $reusable_ind = $item ? $item->reusable_ind : '';
        $consumable_ind = $item ? $item->consumable_ind : '';
        $disposal_ind = $item ? $item->disposal_ind : '';
        $autoindent_on_admission_ind = $item ? $item->autoindent_on_admission_ind : '';
        $saleonstriponly_ind = $item ? $item->saleonstriponly_ind : '';
        $billable_ind = $item ? $item->billable_ind : '';
        $breakable_ind = $item ? $item->breakable_ind : '';
        $individualidentify_ind = $item ? $item->individualidentify_ind : '';
        $salesnoprescription_otc_ind = $item ? $item->salesnoprescription_otc_ind : '';
        $medicalprovider_ind = $item ? $item->medicalprovider_ind : '';
        $packagerestricted_ind = $item ? $item->packagerestricted_ind : '';
        $narcoticdrug_ind = $item ? $item->narcoticdrug_ind : '';
        $pkg_referral_ind = $item ? $item->pkg_referral_ind : '';
        $uom_no_fk_2nd = $item ? $item->uom_no_fk_2nd : '';
        $uom_no_fk_3rd = $item ? $item->uom_no_fk_3rd : '';
        $uom_no_fk_4th = $item ? $item->uom_no_fk_4th : '';
        
        $item_uom_name_2nd = $item ? $item->item_uom_name_2nd : '';
        $item_uom_name_3rd = $item ? $item->item_uom_name_3rd : '';
        $item_uom_name_4th = $item ? $item->item_uom_name_4th : '';
        
        $uom_no_fk_2nd_conv_ratio = $item ? $item->uom_no_fk_2nd_conv_ratio : '';
        $uom_no_fk_3rd_conv_ratio = $item ? $item->uom_no_fk_3rd_conv_ratio : '';
        $uom_no_fk_4th_conv_ratio = $item ? $item->uom_no_fk_4th_conv_ratio : '';
        $route_no_fk = $item ? $item->route_no_fk : '';
        $rack_id_fk = $item ? $item->rack_id_fk : '';
        $item_req_trackable_ind = $item ? $item->item_req_trackable_ind : '';
        $budgetd_head_id = $item ? $item->budgeted_head_no_fk : '';
        $note_text = $item ? $item->note_text : '';
        $plain_text = $item ? $item->plain_text : '';
        $item_photo = $item ? $item->item_photo : '';
        $item_photo_1 = $item ? $item->item_photo_1 : '';
        $item_photo_2 = $item ? $item->item_photo_2 : '';
        $item_photo_3 = $item ? $item->item_photo_3 : '';
        $batchnorequired_ind = $item ? $item->batchnorequired_ind : '';
        $manual_item_rate_ind = $item ? $item->manual_item_rate_ind : '';
        $qty_edit_ind = $item ? $item->qty_edit_ind : '';
        $saleonstriponly_ind = $item ? $item->saleonstriponly_ind : '';

        $cssd_ind = $item ? $item->cssd_ind : '';
        $washable_ind = $item ? $item->washable_ind : '';
        $fin_major_group_no = $item ? $item->fin_major_group_no : '';
        
    @endphp

    <script>
        var uom_arr = [];
    </script>
    <form method="post" id="frm-item-store" action="{{ route('uhl.item.store') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" value="{{ empty($ind) ? $item_no_pk : '' }}">
        {{-- @if (!isset($ind))
            <input type="hidden" name="id" value="{{ $item_no_pk }}">
        @else
            <input type="hidden" name="id" value="">
        @endif --}}
        <section class="paitent__registration_details">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div
                            class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                            <div class="col-md-10">
                                <h5 class="mt-2 mb-0">New Item</h5>
                                <small>New Item / Create New Item</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-lg-12">
                        <form action="#">
                            <div class="card">
                                <div class="card-body border-bottom-3 p-2">
                                    <ul class="nav nav-pills" id="pills-tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="pills-basic-tab" data-toggle="pill"
                                                href="#pills-basic" role="tab" aria-controls="pills-basic"
                                                aria-selected="true">Basic</a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link" id="pills-advance-tab" data-toggle="pill"
                                                href="#pills-advance" role="tab" aria-controls="pills-advance"
                                                aria-selected="false">Advanced</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="pills-policy-tab" data-toggle="pill"
                                                href="#pills-policy" role="tab" aria-controls="pills-policy"
                                                aria-selected="false">Policy</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade show active" id="pills-basic" role="tabpanel"
                                            aria-labelledby="pills-basic-tab">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="form-row">
                                                        <div class="col-md-6">
                                                            <div class="form-row">
                                                                @if ($page_type == 'edit')
                                                                    <div class="col-sm-12">
                                                                        @if (empty($ind))
                                                                            <div class="form-group form-row">
                                                                                <label for="item_code"
                                                                                    class="col-sm-4 col-form-label">Item
                                                                                    Code<span
                                                                                        class="text-danger">*</span></label>
                                                                                <div class="col-sm-8">
                                                                                    <input type="text"
                                                                                        class="form-control form-control-sm"
                                                                                        id="item_code" name="item_code"
                                                                                        value="{{ $item_code }}"
                                                                                        placeholder="" />
                                                                                </div>
                                                                            </div>
                                                                        @endif

                                                                    </div>
                                                                @endif

                                                                <div class="col-sm-12">
                                                                    <div class="form-group form-row">
                                                                        <label for="short_name"
                                                                            class="col-sm-4 col-form-label">Short
                                                                            Name</label>
                                                                        <div class="col-sm-8">
                                                                            <input type="text"
                                                                                class="form-control form-control-sm"
                                                                                id="item_short_name"
                                                                                name="item_short_name"
                                                                                value="{{ empty($ind) ? $item_short_name : $item_short_name . ' - Copy' }}"
                                                                                placeholder="Enter Item Short Name"
                                                                                 />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @if (strtoupper(Session::get('user.ses_hospital_code')) != 'MCARE')
                                                                    <div class="col-sm-12">
                                                                        <div class="form-group form-row">
                                                                            <label for="item_type"
                                                                                class="col-sm-4 col-form-label">Minor Group
                                                                                <span
                                                                                    class="text-danger">*</span></label>
                                                                            <div class="col-sm-8">
                                                                                <select
                                                                                    class="form-control form-control-sm select2"
                                                                                    id="item_type" name="item_type"
                                                                                    required>
                                                                                    <option value="">Select Minor Group</option>
                                                                                    @if (isset($item_type))
                                                                                        @foreach ($item_type as $val)
                                                                                            <option
                                                                                                value="{{ $val->itemtype_no_pk }}"
                                                                                                @if (!empty($item)) {{ $itemtype_no_fk == $val->itemtype_no_pk ? 'selected' : '' }} @endif>
                                                                                                {{ ucwords(strtolower($val->item_name)) }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    @endif

                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group form-row">
                                                                            <label for="item_type" class="col-sm-4 col-form-label col-form-label-sm">Item Type <span class="text-danger">*</span></label>
                                                                                <div class="col-sm-8">
                                                                                    <select class="form-control font_size_12 m-auto select2" id="item_type_lookup" name="item_type_lookup" required>
                                                                                        <option value="">Select Item
                                                                                            Type</option>
                                                                                        @if (isset($item_type_lookup))
                                                                                        @foreach ($item_type_lookup as $key => $val)
                                                                                        <option value="{{ $val }}" {{ $itemtype_db == $val ? 'selected' : '' }}>
                                                                                            {{ ucwords(strtolower($val)) }}
                                                                                        </option>
                                                                                        @endforeach
                                                                                        @endif
                                                                                    </select>
                                                                                </div>
                                                                        </div>
                                                                    </div>
                                                                @else
                                                                    <div class="col-sm-12">
                                                                        <div class="form-group form-row">
                                                                            <label for="item_type"
                                                                                class="col-sm-4 col-form-label">Item
                                                                                Type<span
                                                                                    class="text-danger">*</span></label>
                                                                            <div class="col-sm-8">
                                                                                <select
                                                                                    class="form-control form-control-sm select2"
                                                                                    id="item_type" name="item_type"
                                                                                    required>
                                                                                    <option value="">Select Item
                                                                                        Type</option>
                                                                                    @if (isset($item_type))
                                                                                        @foreach ($item_type as $val)
                                                                                            <option
                                                                                                value="{{ $val->itemtype_no_pk }}"
                                                                                                @if (!empty($item)) {{ $itemtype_no_fk == $val->itemtype_no_pk ? 'selected' : '' }} @endif>
                                                                                                {{ ucwords(strtolower($val->item_name)) }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    @endif
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endif


                                                                <div class="col-sm-12">
                                                                    <div class="form-group form-row">
                                                                        <label for="item_uom"
                                                                            class="col-sm-4 col-form-label">UoM<span
                                                                                class="text-danger">*</span></label>
                                                                        <div class="col-sm-8">
                                                                            {{-- <select class="form-control form-control-sm select2" id="item_uom" name="item_uom" data-type="1" onchange="getUOMById(this)" required>
                                                                                <option value="">Select Item UoM</option>
                                                                                @if (isset($uom_data_pc))
                                                                                    @foreach ($uom_data_pc as $val)
                                                                                        <option value="{{ $val->uom_no_pk }}"
                                                                                        @if (!empty($item)) {{ $uom_no_fk == $val->uom_no_pk ? 'selected' : '' }} @endif
                                                                                            >
                                                                                            {{ $val->uom_code }}</option>
                                                                                    @endforeach
                                                                                @endif
                                                                            </select> --}}

                                                                            <select
                                                                                class="form-control form-control-sm select2 justify-content-center"
                                                                                id="item_uom" name="item_uom"
                                                                                data-type="1"
                                                                                onchange="getUOMById(this)">
                                                                                <option value="">Select Item UoM
                                                                                </option>
                                                                                @if (isset($uom_data))
                                                                                    @php
                                                                                        $u = 1;
                                                                                    @endphp
                                                                                    @foreach ($uom_data as $val)
                                                                                        <option
                                                                                            value="{{ $val->uom_no_pk }}"
                                                                                            data-uom_label_desc="{{ $val->uom_label_desc }}"
                                                                                            data-uom_sl="{{ $u }}"
                                                                                            @if (!empty($item)) {{ $uom_no_fk == $val->uom_no_pk ? 'selected' : '' }} @endif>
                                                                                            {{ $val->uom_code }}
                                                                                        </option>
                                                                                        @php
                                                                                            $u++;
                                                                                        @endphp
                                                                                    @endforeach
                                                                                @endif
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                {{-- <div class="col-sm-12">
                                                                    <div class="form-group form-row">
                                                                        <label for="item_uom" class="col-sm-4 col-form-label">UoM-2</label>
                                                                        <div class="col-sm-8">
                                                                            <select class="form-control form-control-sm select2" id="item_uom_2" name="item_uom_2" data-type="2">
                                                                                <option value="">Select Item UoM</option>
                                                                                @if (isset($uom_data_strip))
                                                                                    @foreach ($uom_data_strip as $val)
                                                                                        <option value="{{ $val->uom_no_pk }}"
                                                                                        @if (!empty($item)) {{ $uom_no_fk_2nd == $val->uom_no_pk ? 'selected' : '' }} @endif
                                                                                            >
                                                                                            {{ $val->uom_code }}</option>
                                                                                    @endforeach
                                                                                @endif
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div> --}}

                                                                {{-- <div class="col-sm-12">
                                                                    <div class="form-group form-row">
                                                                        <label for="item_uom" class="col-sm-4 col-form-label">UoM-3</label>
                                                                        <div class="col-sm-8">
                                                                            <select class="form-control form-control-sm select2" id="item_uom_3" name="item_uom_3" data-type="3" onchange="getUOMById(this)">
                                                                                <option value="">Select Item UoM</option>
                                                                                @if (isset($uom_data_box))
                                                                                    @foreach ($uom_data_box as $val)
                                                                                        <option value="{{ $val->uom_no_pk }}"
                                                                                        @if (!empty($item)) {{ $uom_no_fk_3rd == $val->uom_no_pk ? 'selected' : '' }} @endif
                                                                                            >
                                                                                            {{ $val->uom_code }}</option>
                                                                                    @endforeach
                                                                                @endif
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div> --}}

                                                                {{-- <div class="col-sm-12">
                                                                    <div class="form-group form-row">
                                                                        <label for="item_uom" class="col-sm-4 col-form-label">UoM-4</label>
                                                                        <div class="col-sm-8">
                                                                            <select class="form-control form-control-sm select2" id="item_uom_4" name="item_uom_4" data-type="4" onchange="getUOMById(this)">
                                                                                <option value="">Select Item UoM</option>
                                                                                @if (isset($uom_data_carton))
                                                                                    @foreach ($uom_data_carton as $val)
                                                                                        <option value="{{ $val->uom_no_pk }}"
                                                                                        @if (!empty($item)) {{ $uom_no_fk_4th == $val->uom_no_pk ? 'selected' : '' }} @endif
                                                                                            >
                                                                                            {{ $val->uom_code }}</option>
                                                                                    @endforeach
                                                                                @endif
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div> --}}


                                                                <div class="col-sm-12">
                                                                    <div>
                                                                        <div
                                                                            class="main-uom d-flex justify-content-center mt-3 mb-3">
                                                                            <label for=""
                                                                                class="col-form-label mr-2">Item Unit
                                                                                <span
                                                                                    class="text-danger">*</span></label>
                                                                            <select
                                                                                class="form-control form-control-sm select2 justify-content-center"
                                                                                id="item_uom_select"
                                                                                name="item_uom_select" data-type="2"
                                                                                @if ($item) @else required @endif>
                                                                                <option value="">Select Item UoM
                                                                                </option>
                                                                                @if (isset($uom_data))
                                                                                    @php
                                                                                        $u = 1;
                                                                                    @endphp
                                                                                    @foreach ($uom_data as $val)
                                                                                        <option
                                                                                            value="{{ $val->uom_no_pk }}"
                                                                                            data-uom_label_desc="{{ $val->uom_label_desc }}"
                                                                                            data-uom_sl="{{ $u }}">
                                                                                            {{ $val->uom_code }}
                                                                                        </option>
                                                                                        @php
                                                                                            $u++;
                                                                                        @endphp
                                                                                    @endforeach
                                                                                @endif
                                                                            </select>

                                                                            <input type="hidden"
                                                                                class="form-control form-control-sm"
                                                                                id="item_uom_2" name="item_uom_2"
                                                                                value="{{ $uom_no_fk_2nd }}" />
                                                                            <input type="hidden"
                                                                                class="form-control form-control-sm"
                                                                                id="item_uom_3" name="item_uom_3"
                                                                                value="{{ $uom_no_fk_3rd }}" />
                                                                            <input type="hidden"
                                                                                class="form-control form-control-sm"
                                                                                id="item_uom_4" name="item_uom_4"
                                                                                value="{{ $uom_no_fk_4th }}" />
                                                                            <input type="hidden"
                                                                                class="form-control form-control-sm"
                                                                                id="uom_no_fk_2nd_conv_ratio"
                                                                                name="uom_no_fk_2nd_conv_ratio"
                                                                                value="{{ $uom_no_fk_2nd_conv_ratio }}" />
                                                                            <input type="hidden"
                                                                                class="form-control form-control-sm"
                                                                                id="uom_no_fk_3rd_conv_ratio"
                                                                                name="uom_no_fk_3rd_conv_ratio"
                                                                                value="{{ $uom_no_fk_3rd_conv_ratio }}" />
                                                                            <input type="hidden"
                                                                                class="form-control form-control-sm"
                                                                                id="uom_no_fk_4th_conv_ratio"
                                                                                name="uom_no_fk_4th_conv_ratio"
                                                                                value="{{ $uom_no_fk_4th_conv_ratio }}" />
                                                                        </div>
                                                                    </div>
                                                                    {{-- <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar"> --}}
                                                                    <div
                                                                        class="table-responsive table-wrapper-scroll-y mb-3">
                                                                        <table
                                                                            class="table table-bordered table-striped mb-0"
                                                                            id="uom_list_table">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>Itemt Units(s)</th>
                                                                                    <th>Conversion Ratio</th>
                                                                                    <th>Action</th>
                                                                                </tr>
                                                                            </thead>

                                                                            <tbody>
                                                                                @if ($item && !empty($item_uom_name_2nd))
                                                                                    <script>
                                                                                        var uom_2nd = "{{ $item_uom_name_2nd }}"
                                                                                        uom_arr.push(uom_2nd.trim())
                                                                                    </script>
                                                                                    <tr>
                                                                                        <th>{{ $item_uom_name_2nd }}
                                                                                        </th>
                                                                                        <th>{{ $uom_no_fk_2nd_conv_ratio }}
                                                                                        </th>
                                                                                        <th>
                                                                                            <span class="del_uom"><i
                                                                                                    class="fa fa-trash-alt"></i></span>
                                                                                        </th>
                                                                                    </tr>
                                                                                @endif
                                                                                @if ($item && !empty($item_uom_name_3rd))
                                                                                    <script>
                                                                                        var uom_3rd = "{{ $item_uom_name_3rd }}"
                                                                                        uom_arr.push(uom_3rd.trim())
                                                                                    </script>
                                                                                    <tr>
                                                                                        <th>{{ $item_uom_name_3rd }}
                                                                                        </th>
                                                                                        <th>{{ $uom_no_fk_3rd_conv_ratio }}
                                                                                        </th>
                                                                                        <th>
                                                                                            <span class="del_uom"><i
                                                                                                    class="fa fa-trash-alt"></i></span>
                                                                                        </th>
                                                                                    </tr>
                                                                                @endif
                                                                                @if ($item && !empty($item_uom_name_4th))
                                                                                    <script>
                                                                                        var uom_4th = "{{ $item_uom_name_4th }}"
                                                                                        uom_arr.push(uom_4th.trim())
                                                                                    </script>
                                                                                    <tr>
                                                                                        <th>{{ $item_uom_name_4th }}
                                                                                        </th>
                                                                                        <th>{{ $uom_no_fk_4th_conv_ratio }}
                                                                                        </th>
                                                                                        <th>
                                                                                            <span class="del_uom"><i
                                                                                                    class="fa fa-trash-alt"></i></span>
                                                                                        </th>
                                                                                    </tr>
                                                                                @endif


                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-12">
                                                                    <div class="form-group form-row">
                                                                        <label for="pack_type"
                                                                            class="col-sm-4 col-form-label">Pack
                                                                            Type</label>
                                                                        <div class="col-sm-8">
                                                                            <select
                                                                                class="form-control form-control-sm select2"
                                                                                id="item_pack_type"
                                                                                name="item_pack_type">
                                                                                <option value="">Select Pack Type
                                                                                </option>

                                                                                @if (isset($pack_type))

                                                                                    @foreach ($pack_type as $key => $val)
                                                                                        <option
                                                                                            value="{{ $val }}"
                                                                                            @if (!empty($item)) {{ $item_pack_type == $val ? 'selected' : '' }} @endif>
                                                                                            {{ $val }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                @endif
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-12">
                                                                    <div class="form-group form-row">
                                                                        <label for="sales_price"
                                                                            class="col-sm-4 col-form-label">Sales
                                                                            Price<span
                                                                                class="text-danger">*</span></label>
                                                                        <div class="col-sm-8">
                                                                            <input type="text"
                                                                                class="form-control form-control-sm"
                                                                                id="item_sales_price"
                                                                                name="item_sales_price"
                                                                                value="{{ $sales_price }}"
                                                                                placeholder="Item Sales Price"
                                                                                required>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-12">
                                                                    <div class="form-group form-row">
                                                                        <label for="budgetd_head"
                                                                            class="col-sm-4 col-form-label">Budgeted
                                                                            Head Name</label>
                                                                        <div class="col-sm-8">
                                                                            <input type="text"
                                                                                class="form-control form-control-sm"
                                                                                id="budgetd_head" name="budgetd_head"
                                                                                value="{{ @$acc_head->account_name }}"
                                                                                placeholder="" />
                                                                            <input type="hidden" id="budgetd_head_id"
                                                                                name="budgetd_head_id"
                                                                                value="{{ $budgetd_head_id }}"
                                                                                placeholder="" />
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-12">
                                                                    <div class="form-group form-row">
                                                                        <label for="fin_major_group_no" class="col-sm-4 col-form-label">Major Group (Finanace)<span class="text-danger">*</span></label>
                                                                        <div class="col-sm-8">
                                                                            <select class="form-control form-control-sm select2" id="fin_major_group_no" name="fin_major_group_no" required>
                                                                                <option value="">Select Major Group </option>
                                                                                @if (isset($major_group_option))
                                                                                    @foreach ($major_group_option as $val)
                                                                                        <option value="{{ $val->itemtype_no_pk }}" @if (!empty($item)) {{ $fin_major_group_no == $val->itemtype_no_pk ? 'selected' : '' }} @endif>
                                                                                            {{ ucwords(strtolower($val->item_type_name)) }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                @endif
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @if (Session::get('user.ses_hospital_code') == "KPJ")
                                                                <div class="col-sm-12">
                                                                    <div class="form-group form-row">
                                                                    
                                                                        <label for="crg_group" class="col-sm-4 col-form-label col-form-label-sm">CRG group<span class="text-danger">*</span></label>
                                                                        <div class="col-sm-8">
                                                                            <select class="form-control font_size_12 m-auto select2" id="crg_group" name="crg_group" required>
                                                                                <option value="">Select CRG group</option>
                                                                                @if (isset($crg_group))
                                                                                @foreach ($crg_group as $key => $val)
                                                                                    @php
                                                                                        $lookup_code = $val->lookupdata_code;
                                                                                        $lookup_name = $val->lookupdata_name;
                                                                                    @endphp
                                                                                    <option value="{{ $lookup_code }}" {{ $crg_group_db == $lookup_code ? 'selected' : '' }}>
                                                                                        {{ ucwords(strtolower($lookup_name)) }} - {{ $lookup_code }}
                                                                                    </option>
                                                                                @endforeach
                                                                                @endif
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @endif

                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-row">
                                                                <div class="col-sm-12">
                                                                    <div class="form-group form-row">
                                                                        <label for="item_name"
                                                                            class="col-sm-4 col-form-label">Item
                                                                            Name<span class="text-danger">*</span></label>
                                                                        <div class="col-sm-8">
                                                                            <input type="text"
                                                                                class="form-control form-control-sm"
                                                                                id="item_name" name="item_name"
                                                                                value="{{ empty($ind) ? $item_name : $item_name . ' - Copy' }}"
                                                                                placeholder="Enter Item Name"
                                                                                required />
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-12">
                                                                    <div class="form-group form-row">
                                                                        <label for="generic_name"
                                                                            class="col-sm-4 col-form-label">Generic
                                                                            Name</label>
                                                                        <div class="col-sm-8">
                                                                            <input type="text"
                                                                                class="form-control form-control-sm"
                                                                                id="item_generic_name"
                                                                                name="item_generic_name"
                                                                                value="{{ $generic_name }}">
                                                                            <input type="hidden" class="form-control"
                                                                                id="item_generic_id"
                                                                                name="item_generic_id"
                                                                                value="{{ $generic_no_fk }}">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-12">
                                                                    <div class="form-group form-row">
                                                                        <label for="service_unit"
                                                                            class="col-sm-4 col-form-label">Service
                                                                            Unit</label>
                                                                        <div class="col-sm-8">
                                                                            <select
                                                                                class="form-control form-control-sm select2"
                                                                                id="service_unit" name="service_unit">
                                                                                <option value="">Select Service
                                                                                    Unit</option>
                                                                                @if (isset($service_unit))
                                                                                    @foreach ($service_unit as $val)
                                                                                        <option
                                                                                            value="{{ $val->serviceunit_no_pk }}"
                                                                                            @if (!empty($item)) {{ $serviceunit_no_fk == $val->serviceunit_no_pk ? 'selected' : '' }} @endif>
                                                                                            {{ $val->serviceunit_name }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                @endif
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-12">
                                                                    <div class="form-group form-row">
                                                                        <label for="service_unit"
                                                                            class="col-sm-4 col-form-label">Main
                                                                            Store</label>
                                                                        <div class="col-sm-8">
                                                                            <select
                                                                                class="form-control form-control-sm select2"
                                                                                id="mainstore_su_no_fk"
                                                                                name="mainstore_su_no_fk">
                                                                                <option value="">Select main
                                                                                    store</option>
                                                                                @if (isset($main_store_list))
                                                                                    @foreach ($main_store_list as $val)
                                                                                        <option
                                                                                            value="{{ $val->serviceunit_no_pk }}"
                                                                                            @if (!empty($item)) {{ $main_store == $val->serviceunit_no_pk ? 'selected' : '' }} @endif>
                                                                                            {{ $val->serviceunit_name }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                @endif
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-12">
                                                                    <div class="form-group form-row">
                                                                        <label for="supplier_manufac"
                                                                            class="col-sm-4 col-form-label">Supplier/Manufacturer</label>
                                                                        <div class="col-sm-8">
                                                                            <select
                                                                                class="form-control form-control-sm select2"
                                                                                id="supplier_name"
                                                                                name="supplier_name">
                                                                                <option value="">Select </option>
                                                                                @if (!empty($suppiler_arr))
                                                                                    @foreach ($suppiler_arr as $supplier)
                                                                                        <option
                                                                                            value="{{ $supplier->supplier_no_pk }}"
                                                                                            @if (!empty($item)) {{ $manufacturer_no_fk == $supplier->supplier_no_pk ? 'selected' : '' }} @endif>
                                                                                            {{ $supplier->supplier_name }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                @endif
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                {{-- <div class="col-sm-12">
                                                                    <div class="form-group form-row">
                                                                        <label for="purchase_price" class="col-sm-4 col-form-label">UOM-2 Conversion Ratio </label>
                                                                        <div class="col-sm-8">
                                                                            <input type="text" class="form-control form-control-sm" id="uom_no_fk_2nd_conv_ratio" name="uom_no_fk_2nd_conv_ratio"  value="{{ $uom_no_fk_2nd_conv_ratio }}" placeholder="UOM 2 Conversion Ration" />
                                                                        </div>
                                                                    </div>
                                                                </div> --}}

                                                                {{-- <div class="col-sm-12">
                                                                    <div class="form-group form-row">
                                                                        <label for="purchase_price" class="col-sm-4 col-form-label">UOM-3 Conversion Ratio </label>
                                                                        <div class="col-sm-8">
                                                                            <input type="text" class="form-control form-control-sm" id="uom_no_fk_3rd_conv_ratio" name="uom_no_fk_3rd_conv_ratio"  value="{{ $uom_no_fk_3rd_conv_ratio }}" placeholder="UOM 3 Conversion Ration" />
                                                                        </div>
                                                                    </div>
                                                                </div> --}}

                                                                {{-- <div class="col-sm-12">
                                                                    <div class="form-group form-row">
                                                                        <label for="purchase_price" class="col-sm-4 col-form-label">UOM-4 Conversion Ratio </label>
                                                                        <div class="col-sm-8">
                                                                            <input type="text" class="form-control form-control-sm" id="uom_no_fk_4th_conv_ratio" name="uom_no_fk_4th_conv_ratio"  value="{{ $uom_no_fk_4th_conv_ratio }}" placeholder="UOM 4 Conversion Ration" />
                                                                        </div>
                                                                    </div>
                                                                </div> --}}

                                                                <div class="col-sm-12">
                                                                    <div class="form-group form-row">
                                                                        <label for="purchase_price"
                                                                            class="col-sm-4 col-form-label">Purchase
                                                                            Price</label>
                                                                        <div class="col-sm-8">
                                                                            <input type="text"
                                                                                class="form-control form-control-sm"
                                                                                id="item_purchase_price"
                                                                                name="item_purchase_price"
                                                                                value="{{ $purchase_price }}"
                                                                                placeholder="Item Purchase Price" />
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-12">
                                                                    <div class="form-group form-row">
                                                                        <label for="purchase_discount"
                                                                            class="col-sm-4 col-form-label">Purchase
                                                                            Discount</label>
                                                                        <div class="col-sm-8">
                                                                            <input type="text"
                                                                                class="form-control form-control-sm"
                                                                                id="purchase_discount"
                                                                                name="purchase_discount"
                                                                                value="{{ $purchase_discount }}"
                                                                                placeholder="" />
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-12">
                                                                    <div class="form-group form-row">
                                                                        <label for="purchase_vat"
                                                                            class="col-sm-4 col-form-label">Purchase
                                                                            Vat</label>
                                                                        <div class="col-sm-8">
                                                                            <input type="text"
                                                                                class="form-control form-control-sm"
                                                                                id="item_vat_persent"
                                                                                name="item_vat_persent"
                                                                                value="{{ $vat_percent }}"
                                                                                placeholder="Enter Purchase Vat" />
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-12">
                                                                    <div class="form-group form-row">
                                                                        <label for="item_con_qty"
                                                                            class="col-sm-4 col-form-label">Item
                                                                            Conversion Qty</label>
                                                                        <div class="col-sm-8">
                                                                            <input type="text"
                                                                                class="form-control form-control-sm"
                                                                                id="box_conversion_qty"
                                                                                name="box_conversion_qty"
                                                                                value="{{ $pr_uom_conversion_qty }}"
                                                                                placeholder="Item Conversion Qty" />
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-12">
                                                                    <div class="form-group form-row">
                                                                        <label for="re-order_level"
                                                                            class="col-sm-4 col-form-label">Re Order
                                                                            Level</label>
                                                                        <div class="col-sm-8">
                                                                            <input type="text"
                                                                                class="form-control form-control-sm"
                                                                                id="re_order_type"
                                                                                name="re_order_level"
                                                                                value="{{ $re_order_level }}"
                                                                                placeholder="Re Order Level" />
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-12">
                                                                    <div class="form-group form-row">
                                                                        <label for="acc_mapp_su"
                                                                            class="col-sm-4 col-form-label">Accounts Mapping SU<span class="text-danger">*</span></label>
                                                                        <div class="col-sm-8">

                                                                            <select
                                                                                class="form-control form-control-sm select2"
                                                                                id="accounts_service_unit"
                                                                                name="accounts_service_unit" required>
                                                                                <option value="">Select Service
                                                                                    Unit</option>
                                                                                @if (isset($acc_map_service_unit))
                                                                                    @foreach ($acc_map_service_unit as $val)
                                                                                        <option
                                                                                            value="{{ $val->serviceunit_no_pk }}"
                                                                                            {{ $accounts_mapping_su_no_fk == $val->serviceunit_no_pk ? 'selected' : '' }}>
                                                                                            {{ $val->serviceunit_name }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                @endif
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-12">
                                                                    <div class="form-group form-row">
                                                                        <label for="sock_type"
                                                                            class="col-sm-4 col-form-label">Stock
                                                                            Type</label>
                                                                        <div class="col-sm-8">
                                                                            <select
                                                                                class="form-control form-control-sm select2"
                                                                                id="stock_type" name="stock_type">
                                                                                <option value="">Select One
                                                                                </option>
                                                                                <option value="1"
                                                                                    @if (!empty($item)) {{ $non_stock_ind == 1 ? 'selected' : '' }} @endif>
                                                                                    Non Stockable </option>

                                                                                <option value="2"
                                                                                    @if (!empty($item)) {{ $non_stock_ind == 2 ? 'selected' : '' }} @endif>
                                                                                    Stock </option>

                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-12">
                                                                    <div class="form-group form-row">
                                                                        <label for="item_status"
                                                                            class="col-sm-4 col-form-label">Status</label>
                                                                        <div class="col-sm-8">
                                                                            <select
                                                                                class="form-control form-control-sm select2"
                                                                                id="item_status" name="item_status">
                                                                                <option value="1"
                                                                                    @if (!empty($item)) {{ $item_status == '1' ? 'selected' : '' }} @endif>
                                                                                    Active</option>
                                                                                <option value="0"
                                                                                    @if (!empty($item)) {{ $item_status == '0' ? 'selected' : '' }} @endif>
                                                                                    Inactive</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-12">
                                                                    <div class="form-group form-row">
                                                                        <label for="ref_payment"
                                                                            class="col-sm-4 col-form-label">Referral
                                                                            Payment</label>
                                                                        <div class="col-sm-8">
                                                                            <select
                                                                                class="form-control form-control-sm select2"
                                                                                name="ref_payment" id="ref_payment">
                                                                                <option value="">Select</option>
                                                                                <option value="1"
                                                                                    @if (!empty($item)) {{ $refferral_pay_calc_ind == '1' ? 'selected' : '' }} @endif>
                                                                                    Include</option>
                                                                                <option value="0"
                                                                                    @if (!empty($item)) {{ $refferral_pay_calc_ind == '0' ? 'selected' : '' }} @endif>
                                                                                    Exclude</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>


                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="pills-advance" role="tabpanel"
                                            aria-labelledby="pills-advance-tab">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="form-row">

                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="form-group form-row">
                                                                <label for="dealer_preice"
                                                                    class="col-sm-4 col-form-label">Dealer
                                                                    Price</label>
                                                                <div class="col-sm-8">
                                                                    <input type="text"
                                                                        class="form-control form-control-sm"
                                                                        id="item_dealers_price"
                                                                        name="item_dealers_price"
                                                                        value="{{ $dealer_sales_price }}"
                                                                        placeholder="Item Dealer Price" />
                                                                </div>
                                                            </div>
                                                        </div>



                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="form-group form-row">
                                                                <label for="discount_fee"
                                                                    class="col-sm-4 col-form-label">Default Discount
                                                                    Fee</label>
                                                                <div class="col-sm-8">
                                                                    <input type="text"
                                                                        class="form-control form-control-sm"
                                                                        id="urgent_fee_amt" name="urgent_fee_amt"
                                                                        value="{{ $urgent_fee_amt }}"
                                                                        placeholder="Item Discount fee" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="form-group form-row">
                                                                <label for="emergency_fee"
                                                                    class="col-sm-4 col-form-label">Emergency
                                                                    Fee</label>
                                                                <div class="col-sm-8">
                                                                    <input type="text"
                                                                        class="form-control form-control-sm"
                                                                        id="urgent_fee_amt" name="urgent_fee_amt"
                                                                        value="{{ $urgent_fee_amt }}"
                                                                        placeholder="Item urgent fee" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="form-group form-row">
                                                                <label for="temperature_"
                                                                    class="col-sm-4 col-form-label">Temperature</label>
                                                                <div class="col-sm-8">
                                                                    <input type="text"
                                                                        class="form-control form-control-sm"
                                                                        id="temperature" name="temperature"
                                                                        value="{{ $temperature }}"
                                                                        placeholder="Temperature" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @if (strtoupper(Session::get('user.ses_hospital_code')) != 'MCARE')
                                                            <div class="col-md-6 col-sm-12">
                                                                <div class="form-group form-row">
                                                                    <label for="sales_vat"
                                                                        class="col-sm-4 col-form-label">Sales VAT (%)
                                                                    </label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text"
                                                                            class="form-control form-control-sm"
                                                                            id="item_vat_persent"
                                                                            name="item_vat_persent"
                                                                            value="{{ $vat_percent }}"
                                                                            placeholder="Enter Item Generic Name" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif

                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="form-group form-row">
                                                                <label for="item_cat" class="col-sm-4 col-form-label">
                                                                    Item Category</label>
                                                                <div class="col-sm-8">

                                                                    <select
                                                                        class="form-control form-control-sm select2"
                                                                        data-type="1" id="item_category"
                                                                        onchange="getSubCategory(this)"
                                                                        name="item_category">
                                                                        <option value="">Select Item Category
                                                                        </option>
                                                                        @if (isset($item_cat_data))
                                                                            @foreach ($item_cat_data as $key => $value)
                                                                                <option value="{{ $key }}"
                                                                                    {{ $item_cat == $key ? 'selected' : '' }}>
                                                                                    {{ $value }}</option>
                                                                            @endforeach
                                                                        @endif
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="form-group form-row">
                                                                <label for="item_cat_sub"
                                                                    class="col-sm-4 col-form-label"> Item Category
                                                                    Sub</label>
                                                                <div class="col-sm-8">

                                                                    <select
                                                                        class="form-control form-control-sm select2"
                                                                        data-type="2" onchange="getSubCategory(this)"
                                                                        id="item_category_sub"
                                                                        name="item_category_sub">
                                                                        <option value="">Select Item Category sub
                                                                        </option>
                                                                        @if (isset($item_cat_data_sub))
                                                                            @foreach ($item_cat_data_sub as $key => $val)
                                                                                <option value="{{ $key }}"
                                                                                    {{ $item_cat_sub == $key ? 'selected' : '' }}>
                                                                                    {{ $val }}</option>
                                                                            @endforeach
                                                                        @endif
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="form-group form-row">
                                                                <label for="item_cat_sub_one"
                                                                    class="col-sm-4 col-form-label"> Item Category Sub
                                                                    1</label>
                                                                <div class="col-sm-8">

                                                                    <select
                                                                        class="form-control form-control-sm select2"
                                                                        id="item_category_sub_1"
                                                                        onchange="getSubCategory(this)" data-type="3"
                                                                        name="item_category_sub_1">
                                                                        <option value="">Select Item Category 1
                                                                        </option>
                                                                        @if (isset($item_cat_sub_data_1))
                                                                            @foreach ($item_cat_sub_data_1 as $key => $val)
                                                                                <option value="{{ $key }}"
                                                                                    {{ $item_cat_sub_1 == $key ? 'selected' : '' }}>
                                                                                    {{ $val }}</option>
                                                                            @endforeach
                                                                        @endif
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="form-group form-row">
                                                                <label for="item_cat_sub_two"
                                                                    class="col-sm-4 col-form-label"> Item Category Sub
                                                                    2</label>
                                                                <div class="col-sm-8">

                                                                    <select data-type="4"
                                                                        class="form-control form-control-sm select2"
                                                                        onchange="getSubCategory(this)"
                                                                        id="item_category_sub_2"
                                                                        name="item_category_sub_2">
                                                                        <option value="">Select Item Category 2
                                                                        </option>
                                                                        @if (isset($item_cat_sub_data_2))
                                                                            @foreach ($item_cat_sub_data_2 as $key => $val)
                                                                                <option value="{{ $key }}"
                                                                                    {{ $item_cat_sub_2 == $key ? 'selected' : '' }}>
                                                                                    {{ $val }}</option>
                                                                            @endforeach
                                                                        @endif
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        

                                                        <div class="col-sm-12">
                                                            <div class="form-group form-row">
                                                                <label for="item_short_description"
                                                                    class="col-md-2 col-sm-4 col-form-label">Item Short
                                                                    Description</label>
                                                                <div class="col-md-10 col-sm-8">
                                                                    <textarea class="form-control form-control-sm" id="short_desc" name="short_desc" rows="3">{{ $note_text }}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <div class="form-group form-row">
                                                                <label for="item_long_description"
                                                                    class="col-md-2 col-sm-4 col-form-label">Item Long
                                                                    Description</label>
                                                                <div class="col-md-10 col-sm-8">
                                                                    <textarea class="form-control form-control-sm" name="long_desc" id="long_desc" rows="3">{{ $plain_text }}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 col-sm-12">
                                                            <div class="form-group form-row">
                                                                <label for="item_photo"
                                                                    class="col-sm-2 col-form-label">Item Photo</label>
                                                                <div class="col-sm-2">
                                                                    <div class="upload__img__box">
                                                                        <div class="avatar-upload">
                                                                            <div class="avatar-edit">
                                                                                <input type="file" id="imageUpload"
                                                                                    name="item_photo"
                                                                                    accept=".png, .jpg, .jpeg"
                                                                                    value="" />
                                                                                <label for="imageUpload"></label>
                                                                            </div>

                                                                            {{-- @if ($photo_name != '') --}}
                                                                            {{-- <img class="rounded"
                            src="{{ asset('images/uploads/doctor_images/thumb/' . $photo_name) }}">
                    @else --}}
                                                                            {{-- @if (ucfirst($gender_txt) == 'Male')
                            <img class="rounded" src="{{ asset('images/doc-1.png') }}">
                        @else
                            <img class="rounded" src="{{ asset('images/nurse-2.png') }}">
                        @endif --}}
                                                                            {{-- <img class="rounded" src="{{ asset('images/doc-1.png') }}">
                    @endif --}}
                                                                            @if ($item_photo != '')
                                                                                <div class="avatar-preview">
                                                                                    <div id="imagePreview"
                                                                                        style="background-image: url('../images/uploads/item_images/thumb/{{ $item_photo }}')">
                                                                                        @php
                                                                                            //dd($item_photo);
                                                                                        @endphp
                                                                                    </div>
                                                                                </div>
                                                                            @else
                                                                                <div class="avatar-preview">
                                                                                    <div id="imagePreview"
                                                                                        style="background-image: url('../images/patient.jpg')">
                                                                                    </div>
                                                                                </div>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>


                                                                <div class="col-sm-2">
                                                                    <div class="upload__img__box">
                                                                        <div class="avatar-upload">
                                                                            <div class="avatar-edit">
                                                                                <input type="file"
                                                                                    id="imageUpload1"
                                                                                    name="item_photo1"
                                                                                    accept=".png, .jpg, .jpeg"
                                                                                    value="" />
                                                                                <label for="imageUpload1"></label>
                                                                            </div>

                                                                            @if ($item_photo_1 != '')
                                                                                <div class="avatar-preview">
                                                                                    <div id="imagePreview1"
                                                                                        style="background-image: url('../images/uploads/item_images/thumb/{{ $item_photo_1 }}')">
                                                                                    </div>
                                                                                </div>
                                                                            @else
                                                                                <div class="avatar-preview">
                                                                                    <div id="imagePreview1"
                                                                                        style="background-image: url('../images/patient.jpg')">
                                                                                    </div>
                                                                                </div>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>


                                                                <div class="col-sm-2">
                                                                    <div class="upload__img__box">
                                                                        <div class="avatar-upload">
                                                                            <div class="avatar-edit">
                                                                                <input type="file"
                                                                                    id="imageUpload2"
                                                                                    name="item_photo2"
                                                                                    accept=".png, .jpg, .jpeg"
                                                                                    value="" />
                                                                                <label for="imageUpload2"></label>
                                                                            </div>

                                                                            @if ($item_photo_2 != '')
                                                                                <div class="avatar-preview">
                                                                                    <div id="imagePreview2"
                                                                                        style="background-image: url('../images/uploads/item_images/thumb/{{ $item_photo_2 }}')">
                                                                                    </div>
                                                                                </div>
                                                                            @else
                                                                                <div class="avatar-preview">
                                                                                    <div id="imagePreview2"
                                                                                        style="background-image: url('../images/patient.jpg')">
                                                                                    </div>
                                                                                </div>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>


                                                                <div class="col-sm-2">
                                                                    <div class="upload__img__box">
                                                                        <div class="avatar-upload">
                                                                            <div class="avatar-edit">
                                                                                <input type="file"
                                                                                    id="imageUpload3"
                                                                                    name="item_photo3"
                                                                                    accept=".png, .jpg, .jpeg"
                                                                                    value="" />
                                                                                <label for="imageUpload3"></label>
                                                                            </div>

                                                                            @if ($item_photo_3 != '')
                                                                                <div class="avatar-preview">
                                                                                    <div id="imagePreview3"
                                                                                        style="background-image: url('../images/uploads/item_images/thumb/{{ $item_photo_3 }}')">
                                                                                    </div>
                                                                                </div>
                                                                            @else
                                                                                <div class="avatar-preview">
                                                                                    <div id="imagePreview3"
                                                                                        style="background-image: url('../images/patient.jpg')">
                                                                                    </div>
                                                                                </div>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="pills-policy" role="tabpanel"
                                            aria-labelledby="pills-policy-tab">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="form-row">
                                                        <div class="col-lg-6">
                                                            <div class="card">
                                                                <div class="card-header">
                                                                    <h5 class="mt-2 mb-0">Advance</h5>
                                                                </div>
                                                                <div class="card-body">
                                                                    <div class="form-row">
                                                                        <div class="col-lg-6 col-md-12 col-sm-12">
                                                                            {{-- CSSD Instrument --}}
                                                                            <div class="form-group form-row">
                                                                                <label for="cssd_ind" class="col-md-8 col-sm-6 col-form-label">CSSD Instrument</label>
                                                                                <div class="col-md-4 col-sm-6">
                                                                                    <input class="form-check-input" type="checkbox" id="cssd_ind" name="cssd_ind" value="1" {{ $cssd_ind == '1' ? 'checked' : '' }} />
                                                                                </div>
                                                                            </div>   
                                                                            <div class="form-group form-row">
                                                                                <label for="close_for_indant"
                                                                                    class="col-md-8 col-sm-6 col-form-label">Close
                                                                                    for Indent</label>
                                                                                <div class="col-md-4 col-sm-6">
                                                                                    <input class="form-check-input"
                                                                                        type="checkbox"
                                                                                        id="closeforindent_ind"
                                                                                        name="closeforindent_ind"
                                                                                        value="1"
                                                                                        {{ $closeforindent_ind == '1' ? 'checked' : '' }} />
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group form-row">
                                                                                <label for="close_for_sales"
                                                                                    class="col-md-8 col-sm-6 col-form-label">Close
                                                                                    for Sales</label>
                                                                                <div class="col-md-4 col-sm-6">
                                                                                    <input class="form-check-input"
                                                                                        type="checkbox"
                                                                                        id="closeforsales_ind"
                                                                                        name="closeforsales_ind"
                                                                                        value="1"
                                                                                        {{ $closeforsales_ind == '1' ? 'checked' : '' }} />
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group form-row">
                                                                                <label for="lot_batch_no"
                                                                                    class="col-md-8 col-sm-6 col-form-label">Lot-Batch
                                                                                    No Required</label>
                                                                                <div class="col-md-4 col-sm-6">
                                                                                    <input class="form-check-input"
                                                                                        type="checkbox"
                                                                                        id="lot_batch_no"
                                                                                        name="lot_batch_no"
                                                                                        value="1"
                                                                                        {{ $batchnorequired_ind == '1' ? 'checked' : '' }} />
                                                                                </div>
                                                                            </div>

                                                                            <div class="form-group form-row">
                                                                                <label for="expireable_ind"
                                                                                    class="col-md-8 col-sm-6 col-form-label">Expirable</label>
                                                                                <div class="col-md-4 col-sm-6">
                                                                                    <input class="form-check-input"
                                                                                        type="checkbox"
                                                                                        id="expireable_ind"
                                                                                        name="expireable_ind"
                                                                                        value="1"
                                                                                        {{ $expireable_ind == '1' ? 'checked' : '' }} />
                                                                                </div>
                                                                            </div>


                                                                            <div class="form-group form-row">
                                                                                <label for="analyzer_ind"
                                                                                    class="col-md-8 col-sm-6 col-form-label">Analyzer
                                                                                    Ind</label>
                                                                                <div class="col-md-4 col-sm-6">
                                                                                    <input class="form-check-input"
                                                                                        type="checkbox"
                                                                                        id="analyzer_ind"
                                                                                        name="analyzer_ind"
                                                                                        value="1"
                                                                                        {{ $analyzer_ind == '1' ? 'checked' : '' }} />
                                                                                </div>
                                                                            </div>


                                                                            <div class="form-group form-row">
                                                                                <label for="requisition_trackable"
                                                                                    class="col-md-8 col-sm-6 col-form-label">Item
                                                                                    RequisitionTrackable</label>
                                                                                <div class="col-md-4 col-sm-6">
                                                                                    <input class="form-check-input"
                                                                                        type="checkbox"
                                                                                        id="requisition_trackable"
                                                                                        name="item_req_trackable_ind"
                                                                                        value="1"
                                                                                        {{ $item_req_trackable_ind == '1' ? 'checked' : '' }}
                                                                                        /">
                                                                                </div>
                                                                            </div>





                                                                            <div class="form-group form-row">
                                                                                <label for="consignment_"
                                                                                    class="col-md-8 col-sm-6 col-form-label">Consignment</label>
                                                                                <div class="col-md-4 col-sm-6">
                                                                                    <input class="form-check-input"
                                                                                        type="checkbox"
                                                                                        id="consignment_ind"
                                                                                        name="consignment_ind"
                                                                                        value="1"
                                                                                        {{ $consignment_ind == '1' ? 'checked' : '' }} />
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group form-row">
                                                                                <label for="slow_moving"
                                                                                    class="col-md-8 col-sm-6 col-form-label">Slow
                                                                                    Moving</label>
                                                                                <div class="col-md-4 col-sm-6">
                                                                                    <input class="form-check-input"
                                                                                        type="checkbox"
                                                                                        id="slow_moving_ind"
                                                                                        name="slow_moving_ind"
                                                                                        value="1"
                                                                                        {{ $slow_moving_ind == '1' ? 'checked' : '' }} />
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group form-row">
                                                                                <label for="profile_allow"
                                                                                    class="col-md-8 col-sm-6 col-form-label">Profile
                                                                                    Allow</label>
                                                                                <div class="col-md-4 col-sm-6">
                                                                                    <input class="form-check-input"
                                                                                        type="checkbox"
                                                                                        id="profile_allow_ind"
                                                                                        name="profile_allow_ind"
                                                                                        value="1"
                                                                                        {{ $profile_allow_ind == '1' ? 'checked' : '' }} />
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group form-row">
                                                                                <label for="reusable_"
                                                                                    class="col-md-8 col-sm-6 col-form-label">Reusable</label>
                                                                                <div class="col-md-4 col-sm-6">
                                                                                    <input class="form-check-input"
                                                                                        type="checkbox"
                                                                                        id="reusable_ind"
                                                                                        name="reusable_ind"
                                                                                        value="1"
                                                                                        {{ $reusable_ind == '1' ? 'checked' : '' }} />
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group form-row">
                                                                                <label for="consumable_"
                                                                                    class="col-md-8 col-sm-6 col-form-label">Consumable</label>
                                                                                <div class="col-md-4 col-sm-6">
                                                                                    <input class="form-check-input"
                                                                                        type="checkbox"
                                                                                        id="consumable_ind"
                                                                                        name="consumable_ind"
                                                                                        value="1"
                                                                                        {{ $consumable_ind == '1' ? 'checked' : '' }} />
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group form-row">
                                                                                <label for="disposal_"
                                                                                    class="col-md-8 col-sm-6 col-form-label">Disposal</label>
                                                                                <div class="col-md-4 col-sm-6">
                                                                                    <input class="form-check-input"
                                                                                        type="checkbox"
                                                                                        id="disposal_ind"
                                                                                        name="disposal_ind"
                                                                                        value="1"
                                                                                        {{ $disposal_ind == '1' ? 'checked' : '' }} />
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-6 col-md-12 col-sm-12">
                                                                            {{-- Washable Item --}}
                                                                            <div class="form-group form-row">
                                                                                <label for="washable_ind" class="col-md-8 col-sm-6 col-form-label">Washable Item</label>
                                                                                <div class="col-md-4 col-sm-6">
                                                                                    <input class="form-check-input" type="checkbox" id="washable_ind" name="washable_ind" value="1" {{ $washable_ind == '1' ? 'checked' : '' }} />
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group form-row">
                                                                                <label for="sale_strip"
                                                                                    class="col-md-8 col-sm-6 col-form-label">Sale
                                                                                    on Strip Only</label>
                                                                                <div class="col-md-4 col-sm-6">
                                                                                    <input class="form-check-input"
                                                                                        type="checkbox"
                                                                                        id="saleonstriponly_ind"
                                                                                        name="saleonstriponly_ind"
                                                                                        value="1"
                                                                                        {{ $saleonstriponly_ind == '1' ? 'checked' : '' }} />
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group form-row">
                                                                                <label for="billable_"
                                                                                    class="col-md-8 col-sm-6 col-form-label">Billable</label>
                                                                                <div class="col-md-4 col-sm-6">
                                                                                    <input class="form-check-input"
                                                                                        type="checkbox"
                                                                                        id="billable_ind"
                                                                                        name="billable_ind"
                                                                                        value="1"
                                                                                        {{ $billable_ind == '1' ? 'checked' : '' }} />
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group form-row">
                                                                                <label for="breakable_"
                                                                                    class="col-md-8 col-sm-6 col-form-label">Breakable</label>
                                                                                <div class="col-md-4 col-sm-6">
                                                                                    <input class="form-check-input"
                                                                                        type="checkbox"
                                                                                        id="breakable_ind"
                                                                                        name="breakable_ind"
                                                                                        value="1"
                                                                                        {{ $breakable_ind == '1' ? 'checked' : '' }} />
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group form-row">
                                                                                <label for="fixed_asset"
                                                                                    class="col-md-8 col-sm-6 col-form-label">Fixed
                                                                                    Asset</label>
                                                                                <div class="col-md-4 col-sm-6">
                                                                                    <input class="form-check-input"
                                                                                        type="checkbox" id="asset_ind"
                                                                                        name="asset_ind"
                                                                                        value="1"
                                                                                        {{ $asset_ind == '1' ? 'checked' : '' }} />
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group form-row">
                                                                                <label for="indivisual_identity"
                                                                                    class="col-md-8 col-sm-6 col-form-label">Indivisual
                                                                                    Identity</label>
                                                                                <div class="col-md-4 col-sm-6">
                                                                                    <input class="form-check-input"
                                                                                        type="checkbox"
                                                                                        id="individualidentify_ind"
                                                                                        name="individualidentify_ind"
                                                                                        value="1"
                                                                                        {{ $individualidentify_ind == '1' ? 'checked' : '' }} />
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group form-row">
                                                                                <label for="rate_editable"
                                                                                    class="col-md-8 col-sm-6 col-form-label">Item
                                                                                    Rate Editable</label>
                                                                                <div class="col-md-4 col-sm-6">
                                                                                    <input class="form-check-input"
                                                                                        type="checkbox"
                                                                                        id="rate_editable"
                                                                                        name="rate_editable"
                                                                                        value="1"
                                                                                        {{ $manual_item_rate_ind == '1' ? 'checked' : '' }} />
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group form-row">
                                                                                <label for="package_referal"
                                                                                    class="col-md-8 col-sm-6 col-form-label">Package
                                                                                    Referral</label>
                                                                                <div class="col-md-4 col-sm-6">
                                                                                    <input class="form-check-input"
                                                                                        type="checkbox"
                                                                                        id="pkg_referral_ind"
                                                                                        name="pkg_referral_ind"
                                                                                        value="1"
                                                                                        {{ $pkg_referral_ind == '1' ? 'checked' : '' }} />
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group form-row">
                                                                                <label for="dis_inapplicable"
                                                                                    class="col-md-8 col-sm-6 col-form-label">Dis.
                                                                                    Inapplicable</label>
                                                                                <div class="col-md-4 col-sm-6">
                                                                                    <input class="form-check-input"
                                                                                        type="checkbox"
                                                                                        id="disc_aplicable"
                                                                                        name="disc_aplicable"
                                                                                        value="1"
                                                                                        {{ $dis_inapplicable == '1' ? 'checked' : '' }} />
                                                                                </div>
                                                                            </div>

                                                                            <div class="form-group form-row">
                                                                                <label for="quatity_editable"
                                                                                    class="col-md-8 col-sm-6 col-form-label">Quantity
                                                                                    Editable</label>
                                                                                <div class="col-md-4 col-sm-6">
                                                                                    <input class="form-check-input"
                                                                                        type="checkbox"
                                                                                        id="quatity_editable"
                                                                                        name="quatity_editable"
                                                                                        value="1"
                                                                                        {{ $qty_edit_ind == '1' ? 'checked' : '' }} />
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group form-row">
                                                                                <label for="indent_admission"
                                                                                    class="col-md-8 col-sm-6 col-form-label">Auto
                                                                                    Indent on Admission</label>
                                                                                <div class="col-md-4 col-sm-6">
                                                                                    <input class="form-check-input"
                                                                                        type="checkbox"
                                                                                        id="autoindent_on_admission_ind"
                                                                                        name="autoindent_on_admission_ind"
                                                                                        value="1"
                                                                                        {{ $autoindent_on_admission_ind == '1' ? 'checked' : '' }} />
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="card">
                                                                <div class="card-header">
                                                                    <h5 class="mt-2 mb-0">Pharmacy</h5>
                                                                </div>
                                                                <div class="card-body">

                                                                    <div class="form-group form-row">
                                                                        <label for="sales_prescription"
                                                                            class="col-sm-6 col-form-label">Sales
                                                                            Without Prescription(OTC)</label>
                                                                        <div class="col-sm-6">
                                                                            <input class="form-check-input"
                                                                                type="checkbox"
                                                                                id="salesnoprescription_otc_ind"
                                                                                name="salesnoprescription_otc_ind"
                                                                                value="1"
                                                                                {{ $salesnoprescription_otc_ind == '1' ? 'checked' : '' }} />
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group form-row">
                                                                        <label for="medical_provider"
                                                                            class="col-sm-6 col-form-label">Medical
                                                                            Provider</label>
                                                                        <div class="col-sm-6">
                                                                            <input class="form-check-input"
                                                                                type="checkbox"
                                                                                id="medicalprovider_ind"
                                                                                name="medicalprovider_ind"
                                                                                value="1"
                                                                                {{ $medicalprovider_ind == '1' ? 'checked' : '' }} />
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group form-row">
                                                                        <label for="package_resticted"
                                                                            class="col-sm-6 col-form-label">Package
                                                                            Restricted</label>
                                                                        <div class="col-sm-6">
                                                                            <input class="form-check-input"
                                                                                type="checkbox"
                                                                                id="packagerestricted_ind"
                                                                                name="packagerestricted_ind"
                                                                                value="1"
                                                                                {{ $packagerestricted_ind == '1' ? 'checked' : '' }} />
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group form-row">
                                                                        <label for="narcotic_drug"
                                                                            class="col-sm-6 col-form-label">Narcotic
                                                                            Drug</label>
                                                                        <div class="col-sm-6">
                                                                            <input class="form-check-input"
                                                                                type="checkbox" id="narcoticdrug_ind"
                                                                                name="narcoticdrug_ind" value="1"
                                                                                {{ $narcoticdrug_ind == '1' ? 'checked' : '' }} />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="card">
                                                                <div class="card-header">
                                                                    <h5 class="mt-2 mb-0">Inventory</h5>
                                                                </div>
                                                                <div class="card-body">
                                                                    {{-- <div class="form-group form-row">
                                                                       <label for="pati_age_y" class="col-sm-4 col-form-label">AGE</label>
                                                                       <div class="col-sm-8">
                                                                           <div class="input-group">
                                                                               <div class="input-group-prepend w-100">
                                                                                   <input type="text" class="form-control number_only form-control-sm" id="pat_age_y" name="pat_age_y" value="" placeholder="YY" tabindex="3" required="" />
                                                                                   <input type="text" class="form-control number_only form-control-sm" id="pat_age_m" name="pat_age_m" value="" placeholder="MM" />
                                                                                   <input type="text" class="form-control number_only form-control-sm" id="pat_age_d" name="pat_age_d" value="" placeholder="DD" />
                                                                               </div>
                                                                           </div>
                                                                       </div>
                                                                   </div> --}}
                                                                    <div class="form-group form-row">
                                                                        <label for="rack_"
                                                                            class="col-sm-4 col-form-label">Rack</label>
                                                                        <div class="col-sm-8">
                                                                            <select
                                                                                class="form-control form-control-sm select2"
                                                                                id="rack_id_fk" name="rack_id_fk">
                                                                                <option value="">Select route
                                                                                </option>
                                                                                @if (isset($rack))
                                                                                    @foreach ($rack as $val)
                                                                                        <option
                                                                                            value="{{ $val->rack_id_pk }}"
                                                                                            @if (!empty($item)) {{ $rack_id_fk == $val->rack_id_pk ? 'selected' : '' }} @endif>
                                                                                            {{ $val->rack_name }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                @endif
                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                    {{-- <div class="form-group form-row">
                                                                        <label for="does_" class="col-sm-4 col-form-label">Does</label>
                                                                        <div class="col-sm-8">

                                                                            <input class="form-control form-control-sm" type="text" id="does_" name="" value="" />
                                                                        </div>
                                                                    </div> --}}

                                                                    <div class="form-group form-row">
                                                                        <label for="route_"
                                                                            class="col-sm-4 col-form-label">Route</label>
                                                                        <div class="col-sm-8">
                                                                            <select
                                                                                class="form-control form-control-sm select2"
                                                                                id="route_no_fk" name="route_no_fk">
                                                                                <option value="">Select route
                                                                                </option>
                                                                                @if (isset($route))
                                                                                    @foreach ($route as $key => $val)
                                                                                        <option
                                                                                            value="{{ $key }}"
                                                                                            @if (!empty($item)) {{ $route_no_fk == $key ? 'selected' : '' }} @endif>
                                                                                            {{ $val }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                @endif
                                                                            </select>
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
                        </form>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-2">
                            <div class="card-body">
                                <div class="form-group">
                                    <ul class="list-inline btn__box">
                                        <li class="list-inline-item">
                                            @php
                                                $doctor_id = '';
                                                $response_url = route('v1.uhl-new-item');
                                            @endphp

                                            <button type="submit" class="btn btn-secondary uhl_save_btn"
                                                id="save_update" data-func=""
                                                data-response-url="{{ $response_url }}"
                                                title="Click here to save Medicine Item Information">
                                                Save
                                            </button>
                                        </li>
                                        {{-- <li class="list-inline-item"><button type="button" class="btn btn-secondary btn-danger">Close</button></li> --}}

                                        <li class="list-inline-item"><button type="button"
                                                class="btn btn-secondary btn-warning"
                                                data-dismiss="modal">Exit</button></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </form>
</main>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
{{-- 
<script>
    $(document).ready(function () {
        function toggleMajorGroupRequirement() {
            const selectedItemType = $('#item_type').val();
            const requiredTypes = ['MED', 'INV', 'MSU', 'Consum'];

            console.log(selectedItemType);

            if (requiredTypes.includes(selectedItemType)) {
                $('#fin_major_group_no').attr('required', true);

                // Optional: Show prompt only if field is empty
                if (!$('#fin_major_group_no').val()) {
                    alert("Please select a Major Group (Finanace).");
                    // $('#item_type_lookup').val('').trigger('change');
                    // $('#pills-advance-tab').trigger('click');
                }
            } else {
                $('#fin_major_group_no').removeAttr('required');
            }
        }

        // Initial check in case the page loads with a pre-selected value
        toggleMajorGroupRequirement();

        // Bind the change event
        $('#item_type').on('change', function () {
            toggleMajorGroupRequirement();
        });
    });
</script> --}}

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

                            dynamicFunc.afterSaveLoadPage(
                                "{{ route('v1.uhl-item-list') }}");
                        }
                    },
                    error: function(data) {
                        console.log(data);
                    },
                    complete: function() {
                        $.unblockUI();
                        if (page_type == 'edit')
                            dynamicFunc.afterSaveLoadPage(
                                "{{ route('v1.uhl-item-list') }}");
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
        } else {

            return false;
        }
    });



    var fl = 0;
    var uom_sl = 0;
    $('#item_uom_select').on('change', function() {

        const uom_text = $(this).find("option:selected").text();
        const uom_val = $(this).find("option:selected").val();
        const uom_attr_val = $(this).find("option:selected").attr('data-uom_label_desc');
        const uom_attr_sl = $(this).find("option:selected").attr('data-uom_sl');

        uom_sl++;

        setTimeout(() => {

            if (!uom_arr.includes(uom_text.trim())) {
                uom_arr.push(uom_text.trim());
            }

        }, 1000);



        //alert(uom_attr_val)
        // <input type="hidden" class="form-control form-control-sm" id="item_uom_2" name="item_uom_2"/>
        // <input type="hidden" class="form-control form-control-sm" id="item_uom_3" name="item_uom_3"/>
        // <input type="hidden" class="form-control form-control-sm" id="item_uom_4" name="item_uom_4"/>
        // <input type="hidden" class="form-control form-control-sm" id="uom_no_fk_2nd_conv_ratio" name="uom_no_fk_2nd_conv_ratio"/>
        // <input type="hidden" class="form-control form-control-sm" id="uom_no_fk_3rd_conv_ratio" name="uom_no_fk_3rd_conv_ratio"/>
        // <input type="hidden" class="form-control form-control-sm" id="uom_no_fk_4th_conv_ratio" name="uom_no_fk_4th_conv_ratio"/>

        if (uom_sl == 1) {
            $('#item_uom_2').val(uom_val);
            $('#uom_no_fk_2nd_conv_ratio').val(uom_attr_val);
        }

        if (uom_sl == 2) {
            $('#item_uom_3').val(uom_val);
            $('#uom_no_fk_3rd_conv_ratio').val(uom_attr_val);
        }

        if (uom_sl == 3) {
            $('#item_uom_4').val(uom_val);
            $('#uom_no_fk_4th_conv_ratio').val(uom_attr_val);
        }

        //var unique = [...new Set(uom_arr)];
        if (!uom_arr.includes(uom_text.trim())) {


            $('#uom_list_table > tbody').append(`
                <tr>

                    <th>${uom_text}</th>
                    <th>${uom_attr_val}</th>
                    <th><span class="del_uom"><i class="fa fa-trash-alt"></i></th>

                </tr>
            `);

            console.log('Item after edit uom ', uom_arr)
        }



    });

    $('body').on('click', '.del_uom', function() {
        const get_uom_text = $(this).parents("tr").find("th:nth(0)").text();
        setTimeout(() => {
            const new_uom = uom_arr.splice(uom_arr.indexOf(get_uom_text.trim()), 1);
            console.log('uom array', uom_arr);
            $(this).parents("tr").remove();
        }, 1000)


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

    var uom_arr = [];
    var fl = 0;



    function getUOMById(element) {
        var type = $(element).attr('data-type');
        var uom_pk_no = $(element).val();

        var action = "{{ route('uhl.get-uom-val', ':id') }}";
        action = action.replace(':id', uom_pk_no);
        $.ajax({
            url: action,
            type: "get",
            data: {
                type: type,
                uom_pk_no: uom_pk_no
            },
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $.unblockUI();
                console.log(type);
                if (type == 1) {
                    $("#box_conversion_qty").val(data);
                    //$("#item_category_sub_1").html('');
                    //$("#item_category_sub_2").html('');
                }
                if (type == 2) {
                    $("#uom_no_fk_2nd_conv_ratio").val(data);
                    //$("#item_category_sub_2").html('');
                }
                if (type == 3) {
                    $("#uom_no_fk_3rd_conv_ratio").val(data);
                    //$("#item_category_sub_3").html('');
                }

                if (type == 4) {
                    $("#uom_no_fk_4th_conv_ratio").val(data);
                    //$("#item_category_sub_3").html('');
                }



            },
            complete: function(data) {

            }
        });

    }

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreview').css('background-image', 'url(' + e.target.result + ')');
                $('#imagePreview').hide();
                $('#imagePreview').fadeIn(650);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function readURL_TWO(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {

                $('#imagePreview1').css('background-image', 'url(' + e.target.result + ')');
                $('#imagePreview1').hide();
                $('#imagePreview1').fadeIn(650);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function readURL_THREE(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {

                $('#imagePreview2').css('background-image', 'url(' + e.target.result + ')');
                $('#imagePreview2').hide();
                $('#imagePreview2').fadeIn(650);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function readURL_FOUR(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {

                $('#imagePreview3').css('background-image', 'url(' + e.target.result + ')');
                $('#imagePreview3').hide();
                $('#imagePreview3').fadeIn(650);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#imageUpload").change(function() {
        readURL(this);
    });

    $("#imageUpload1").change(function() {
        readURL_TWO(this);
    });

    $("#imageUpload2").change(function() {
        readURL_THREE(this);
    });


    $("#imageUpload3").change(function() {
        readURL_FOUR(this);
    });

    $(document).on('keyup', '#item_generic_name', function() {
        if ($(this).val() == "") {
            $('#item_generic_id').val('');
        }
    })
    openItemAutocompleteGeneric("#item_generic_name", "#item_generic_id");
    openAccountsAutocomplete("#budgetd_head", "#budgetd_head_id");
</script>
