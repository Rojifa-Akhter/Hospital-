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
        //dd($item->mainstore_su_no_fk);
        $item_no_pk = $item ? $item->item_no_pk : '';
        $item_name = $item ? $item->item_name : '';
        $item_code = $item ? $item->item_code : '';
        $item_short_name = $item ? $item->item_short_name : '';
        //dd($item_short_name);
        $brand = $item ? $item->brand : '';
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
        $non_stock_ind = $item ? $item->non_stock_ind : '';
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
        $purchase_item_vat_persent = $item ? $item->purchasevat_pct : '';
        
    @endphp

    <script>
        var uom_arr = [];
    </script>
    <form method="post" id="frm-item-store" action="{{ route('uhl.item.store') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" value="{{ $item_no_pk }}">
        <input type="hidden" name="item_status" value="1">
        <section class="paitent__registration_details">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div
                            class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                            <div class="col-md-10">
                                <h5 class="mt-2 mb-0">Quick New Item</h5>
                                <small>Quick New Item / Create New Item</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-lg-12">
                        <form action="#">
                            <div class="card">
                                <div class="card-body border-bottom-3 p-2">

                                    <div class="card">
                                        <div class="card-body">
                                            <div class="form-row">

                                                @if ($page_type == 'edit')
                                                    <div class="col-md-6 col-sm-12">
                                                        <div class="form-group form-row">
                                                            <label for="item_code" class="col-sm-4 col-form-label">Item
                                                                Code<span class="text-danger">*</span></label>
                                                            <div class="col-sm-8">
                                                                <input type="text"
                                                                    class="form-control form-control-sm" id="item_code"
                                                                    name="item_code" value="{{ $item_code }}"
                                                                    placeholder="" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif


                                                <div class="col-md-6 col-sm-12">
                                                    <div class="form-group form-row">
                                                        <label for="item_short_name"
                                                            class="col-sm-4 col-form-label">Short
                                                            Name</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control form-control-sm"
                                                                id="item_short_name" name="item_short_name"
                                                                value="" placeholder="Short Name" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-sm-12">
                                                    <div class="form-group form-row">
                                                        <label for="item_name" class="col-sm-4 col-form-label">Item
                                                            Name</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control form-control-sm"
                                                                id="item_name" name="item_name" value=""
                                                                placeholder="Item Name" />
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="col-md-6 col-sm-12">
                                                    <div class="form-group form-row">
                                                        <label for="item_type" class="col-sm-4 col-form-label">Report
                                                            Header<span class="text-danger">*</span></label>
                                                        <div class="col-sm-8">
                                                            <select class="form-control form-control-sm select2"
                                                                id="item_type" name="item_type" required>
                                                                <option value="">Select
                                                                    Report Header</option>
                                                                @if (isset($item_type))
                                                                    @foreach ($item_type as $val)
                                                                        <option value="{{ $val->itemtype_no_pk }}"
                                                                            @if (!empty($item)) {{ $itemtype_no_fk == $val->itemtype_no_pk ? 'selected' : '' }} @endif>
                                                                            {{ ucwords(strtolower($val->item_name)) }}
                                                                        </option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="col-md-6 col-sm-12">
                                                    <div class="form-group form-row">
                                                        <label for="item_type" class="col-sm-4 col-form-label">Item
                                                            Type</label>
                                                        <div class="col-sm-8">
                                                            <select class="form-control font_size_12 m-auto select2"
                                                                id="item_type_lookup" name="item_type_lookup" required>
                                                                <option value="">Select Item
                                                                    Type</option>
                                                                @if (isset($item_type_lookup))
                                                                    @foreach ($item_type_lookup as $key => $val)
                                                                        <option value="{{ $val }}"
                                                                            {{ $itemtype_db == $val ? 'selected' : '' }}>
                                                                            {{ ucwords(strtolower($val)) }}
                                                                        </option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-sm-12">
                                                    <div class="form-group form-row">
                                                        <label for="item_uom"
                                                            class="col-sm-4 col-form-label">UoM</label>
                                                        <div class="col-sm-8">
                                                            <select
                                                                class="form-control form-control-sm select2 justify-content-center"
                                                                id="item_uom" name="item_uom" data-type="1" required
                                                                onchange="getUOMById(this)">
                                                                <option value="">Select Item UoM
                                                                </option>
                                                                @if (isset($uom_data))
                                                                    @php
                                                                        $u = 1;
                                                                    @endphp
                                                                    @foreach ($uom_data as $val)
                                                                        <option value="{{ $val->uom_no_pk }}"
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


                                                            <input type="hidden"
                                                            class="form-control form-control-sm"
                                                            id="box_conversion_qty"
                                                            name="box_conversion_qty"
                                                            value="{{ $pr_uom_conversion_qty }}"
                                                            placeholder="Item Conversion Qty" />
                                                            <input type="hidden" class="form-control form-control-sm"
                                                                id="item_uom_2" name="item_uom_2"
                                                                value="{{ $uom_no_fk_2nd }}" />
                                                            <input type="hidden" class="form-control form-control-sm"
                                                                id="item_uom_3" name="item_uom_3"
                                                                value="{{ $uom_no_fk_3rd }}" />
                                                            <input type="hidden" class="form-control form-control-sm"
                                                                id="item_uom_4" name="item_uom_4"
                                                                value="{{ $uom_no_fk_4th }}" />
                                                            <input type="hidden" class="form-control form-control-sm"
                                                                id="uom_no_fk_2nd_conv_ratio"
                                                                name="uom_no_fk_2nd_conv_ratio"
                                                                value="{{ $uom_no_fk_2nd_conv_ratio }}" />
                                                            <input type="hidden" class="form-control form-control-sm"
                                                                id="uom_no_fk_3rd_conv_ratio"
                                                                name="uom_no_fk_3rd_conv_ratio"
                                                                value="{{ $uom_no_fk_3rd_conv_ratio }}" />
                                                            <input type="hidden" class="form-control form-control-sm"
                                                                id="uom_no_fk_4th_conv_ratio"
                                                                name="uom_no_fk_4th_conv_ratio"
                                                                value="{{ $uom_no_fk_4th_conv_ratio }}" />

                                                            <input type="hidden" name="item_uom_select"
                                                                id="item_uom_select" value="">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-sm-12">
                                                    <div class="form-group form-row">
                                                        <label for="service_unit" class="col-sm-4 col-form-label">Main
                                                            Store</label>
                                                        <div class="col-sm-8">
                                                            <select class="form-control form-control-sm select2"
                                                                id="mainstore_su_no_fk" name="mainstore_su_no_fk">
                                                                <option value="">Select main
                                                                    store</option>
                                                                @if (isset($main_store_list))
                                                                    @foreach ($main_store_list as $val)
                                                                        <option value="{{ $val->serviceunit_no_pk }}"
                                                                            @if (!empty($item)) {{ $main_store == $val->serviceunit_no_pk ? 'selected' : '' }} @endif>
                                                                            {{ $val->serviceunit_name }}
                                                                        </option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>



                                                <div class="col-md-6 col-sm-12">
                                                    <div class="form-group form-row">
                                                        <label for="item_purchase_price"
                                                            class="col-sm-4 col-form-label">Purchase
                                                            Price</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control form-control-sm"
                                                                id="item_purchase_price" name="item_purchase_price"
                                                                value="" placeholder="Purchase Price" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <input type="hidden" class="form-control form-control-sm"
                                                    id="item_sales_price" name="item_sales_price" value="0"
                                                    placeholder="Item Sales Price" required>

                                                <div class="col-md-6 col-sm-12">
                                                    <div class="form-group form-row">
                                                        <label for="purchase_discount"
                                                            class="col-sm-4 col-form-label">Purchase
                                                            Discount</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control form-control-sm"
                                                                id="purchase_discount" name="purchase_discount"
                                                                value="" placeholder="Purchase Discount" />
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="col-md-6 col-sm-12">
                                                    <div class="form-group form-row">
                                                        <label for="service_unit"
                                                            class="col-sm-4 col-form-label">Stock Type</label>
                                                        <div class="col-sm-8">
                                                            <select class="form-control form-control-sm select2"
                                                                id="stock_type" name="stock_type">
                                                                <option value="">Select One</option>
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
                                                $response_url = route('v1.uhl-item-list');
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
<script>
    $('.select2').select2();
    $('#supplier_manufac').select2({
        multiple: true,
        placeholder: 'Enter Supplier'
    });

    function calculatePrice() {
        var box_purchase_price = $('#box_purchase_price').val();
        var box_conversion_qty = $('#box_conversion_qty').val();
        $('#item_purchase_price').val('');
        if (box_purchase_price != '' && box_conversion_qty != '') {
            var price = box_purchase_price / box_conversion_qty;
            $('#item_purchase_price').val(price.toFixed(2));
        }
    }

    function selectServiceUnit(element) {
        var su_no = $(element).find(':selected').attr('data-su_no');
        $('#service_unit').val(su_no);
        $('#service_unit').trigger('change');
        console.log(su_no);
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
                                "{{ route('v1.uhl-inventory-item-list') }}");
                        }
                    },
                    error: function(data) {
                        // console.log(data);
                    },
                    complete: function() {
                        $.unblockUI();
                        if (page_type == 'edit')
                            dynamicFunc.afterSaveLoadPage(
                                "{{ route('v1.uhl-inventory-item-list') }}");
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
        // console.log(uom_sl);
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

            // console.log('Item after edit uom ', uom_arr)
        }



    });

    $('body').on('click', '.del_uom', function() {
        const get_uom_text = $(this).parents("tr").find("th:nth(0)").text();
        alert(get_uom_text)
        setTimeout(() => {
            const new_uom = uom_arr.splice(uom_arr.indexOf(get_uom_text.trim()), 1);
            // console.log('uom array', uom_arr);
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
                // console.log(type);
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
                var w = $("#item_uom_select").val(data);
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
