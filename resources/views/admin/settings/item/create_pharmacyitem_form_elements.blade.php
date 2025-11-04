<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
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
$serviceunit_no_fk = $item ? $item->serviceunit_no_fk : '';
$uom_no_fk = $item ? $item->uom_no_fk : '';
$item_pack_type = $item ? $item->item_pack_type : '';
$manufacturer_no_fk = $item ? $item->manufacturer_no_fk : '';

$sales_price = $item ? $item->sales_price : '';
$purchase_price = $item ? $item->purchase_price : '';
$temperature = $item ? $item->temperature : '';
$re_order_level = $item ? $item->re_order_level : '';
$reorder_type = $item ? $item->reorder_type : '';
$dealer_sales_price = $item ? $item->dealer_sales_price : '';
$urgent_fee_amt = $item ? $item->urgent_fee_amt : '';

$vat_percent = $item ? $item->vat_percent : '';
$item_cat = $item && isset($item->item_cat) ? $item->item_cat : '';
$item_cat_sub = $item && isset($item->item_cat_sub)? $item->item_cat_sub : '';
$item_cat_sub_2 = $item && isset($item->item_cat_sub_2)? $item->item_cat_sub_2 : '';
$item_cat_sub_1 = $item && isset($item->item_cat_sub_1)? $item->item_cat_sub_1 : '';
$pkg_referral_ind = $item ? $item->pkg_referral_ind : '';
$item_status = $item ? $item->status : '';
$item_rate_ind = $item ? $item->manual_item_rate_ind : '';
$pr_uom_no_fk = $item ? $item->pr_uom_no_fk : '';
$pr_uom_conversion_qty = $item ? $item->pr_uom_conversion_qty : '';
$pr_uom_tradeprice = $item ? $item->pr_uom_tradeprice : '';
$expireable_ind = $item ? $item->expireable : '';
$dis_inapplicable = $item ? $item->disc_aplicable : '';
$refferral_pay_calc_ind = $item ? $item->refferral_pay_calc_ind : '';

@endphp

<form method="post" id="frm-item-store" action="{{ route('item.store') }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" value="{{ $item_no_pk }}">

    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link col-form-label s-12 active" id="basic-tab" data-toggle="tab" href="#basic" role="tab" aria-controls="basic" aria-selected="true">Basic</a>
        </li>

        <li class="nav-item" role="presentation">
            <a class="nav-link col-form-label s-12" id="advanced-tab" data-toggle="tab" href="#advanced" role="tab" aria-controls="advanced" aria-selected="false">Advanced</a>
        </li>
    </ul>

    <div class="tab-content p-0" id="myTabContent">
        <div class="tab-pane fade show active" id="basic" role="tabpanel" aria-labelledby="basic-tab">
           <div class="form-group row">
               <label for="item_code" class="col-sm-2 col-form-label col-form-label-sm">Item Code <span class="text-danger">*</span></label>
               <div class="col-sm-4">
                   <input type="text" class="form-control form-control-sm" id="item_code" name="item_code"
                   value="{{ $item_code }}" placeholder="Enter Item Code" required>
               </div>


               <label for="item_name" class="col-sm-2 col-form-label col-form-label-sm">Item Name <span class="text-danger">*</span></label>
               <div class="col-sm-4">
                   <input type="text" class="form-control" id="item_name" name="item_name" value="{{ $item_name }}"
                   placeholder="Enter Item Name" required>
               </div>


               <label for="item_short_name" class="col-sm-2 col-form-label col-form-label-sm">Short Name <span class="text-danger">*</span></label>
               <div class="col-sm-4">
                   <input type="text" class="form-control form-control-sm" id="item_short_name" name="item_short_name"
                   value="{{ $item_short_name }}" placeholder="Enter Item Short Name" required>
               </div>

               <label for="item_generic_name" class="col-sm-2 col-form-label col-form-label-sm">Generic Name </label>
               <div class="col-sm-4">
                   <input type="text" class="form-control item_generic_name" id="item_generic_name" name="item_generic_name" value="{{$generic_name}}">
                   <input type="hidden" class="form-control" id="item_generic_id" name="item_generic_id" value="{{$generic_no_fk}}">
               </div>

               @if (strtoupper(Session::get('user.ses_hospital_code')) != 'MCARE')
               <label for="item_type" class="col-sm-2 col-form-label col-form-label-sm">Item Type <span class="text-danger">*</span></label>
               <div class="col-sm-4">
                   <select class="form-control font_size_12 m-auto select2" id="item_type" name="item_type" required>
                       <option value="">Select Item Type</option>
                       @if (isset($item_type))
                       @foreach ($item_type as $val)
                       <option value="{{ $val->itemtype_no_pk }}" {{ $itemtype_no_fk == $val->itemtype_no_pk ? 'selected' : '' }}> {{ ucwords(strtolower($val->item_name)) }}</option>
                       @endforeach
                       @endif

                   </select>
               </div>
               @else
             
               <label for="item_type" class="col-sm-2 col-form-label col-form-label-sm">Item Type <span class="text-danger">*</span></label>
               <div class="col-sm-4">
                   <select class="form-control font_size_12 m-auto select2" id="item_type" name="item_type" required>
                       <option value="">Select Item Type</option>
                       @if (isset($item_type))
                       @foreach ($item_type as $key => $val)
                       <option value="{{ $key }}" {{ $itemtype_no_fk == $key ? 'selected' : '' }}> {{ ucwords(strtolower($val)) }}</option>
                       @endforeach
                       @endif
                   </select>
               </div>
               @endif
              

               @if (strtoupper(Session::get('user.ses_hospital_code')) != 'MCARE')
               <label for="service_unit" class="col-sm-2 col-form-label col-form-label-sm">Service Unit</label>
               <div class="col-sm-4">
                   <select class="form-control font_size_12 m-auto select2" id="service_unit" name="service_unit">
                       <option value="">Select Service Unit</option>
                       @if (isset($service_unit))
                       @foreach ($service_unit as $val)
                       <option value="{{ $val->serviceunit_no_pk }}" {{ $serviceunit_no_fk == $val->serviceunit_no_pk ? 'selected' : '' }}> {{ $val->serviceunit_name }}</option>
                       @endforeach
                       @endif
                   </select>
               </div>
               @endif
              

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
                   <select class="form-control font_size_12 m-auto" id="purchase_uom" name="purchase_uom">
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

               <label for="supplier_name" class="col-sm-2 col-form-label col-form-label-sm">Supplier/Manufacturer</label>
               <div class="col-sm-4">
                   <select class="form-control font_size_12 m-auto" id="supplier_name" name="supplier_name">
                       <option value="">Select </option>
                       @if (!empty($suppiler_arr))
                       @foreach ($suppiler_arr as $supplier)
                       <option value="{{ $supplier->supplier_no_pk }}" {{ $manufacturer_no_fk == $supplier->supplier_no_pk ? 'selected' : '' }}>{{ $supplier->supplier_name }}</option>
                       @endforeach
                       @endif
                   </select>
               </div>

               <label for="item_sales_price" class="col-sm-2 col-form-label col-form-label-sm">Sales Price <span class="text-danger">*</span></label>
               <div class="col-sm-4">
                   <input type="text" class="form-control form-control-sm number_only" id="item_sales_price"
                   name="item_sales_price" value="{{ $sales_price }}" placeholder="Item Sales Price" required>
               </div>

               <label for="item_purchase_price" class="col-sm-2 col-form-label col-form-label-sm">Box Purchase Price </label>
               <div class="col-sm-4">
                   <input type="text" class="form-control form-control-sm number_only" onkeyup="calculatePrice()"
                   onfocus="calculatePrice()" id="box_purchase_price" name="box_purchase_price"
                   value="{{ $pr_uom_tradeprice }}" placeholder="Item Purchase Price">
               </div>

               <label for="item_purchase_price" class="col-sm-2 col-form-label col-form-label-sm">Item Conversion Qty </label>
               <div class="col-sm-4">
                   <input type="text" class="form-control form-control-sm number_only" onkeyup="calculatePrice()"
                   onfocus="calculatePrice()" id="box_conversion_qty" name="box_conversion_qty"
                   value="{{ $pr_uom_conversion_qty }}" placeholder="Item Conversion Qty">
               </div>

               <label for="item_purchase_price" class="col-sm-2 col-form-label col-form-label-sm">Purchase Price </label>
               <div class="col-sm-4">
                   <input type="text" class="form-control form-control-sm number_only" id="item_purchase_price"name="item_purchase_price" value="{{ $purchase_price }}" placeholder="Item Purchase Price">
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

               <label for="re_order_level" class="col-sm-2 col-form-label col-form-label-sm">Re Order Level</label>
               <div class="col-md-4">
                   <input type="text" class="form-control form-control-sm" id="re_order_type" name="re_order_level"
                   value="{{ $re_order_level }}" placeholder="Re Order Level">
               </div>



               <label for="rate_ind" class="col-sm-2 col-form-label col-form-label-sm">Item Rate</label>
               <div class="col-sm-4">
                   <div class="form-check form-check-inline">
                       <input class="form-check-input" type="checkbox" name="rate_ind" id="rate_ind" value="1"{{ $item_rate_ind == '1' ? 'checked' : '' }}>

                   </div>
               </div>

               <label for="rate_ind" class="col-sm-2 col-form-label col-form-label-sm">Expireable</label>
               <div class="col-sm-4">
                   <div class="form-check form-check-inline">
                       <input class="form-check-input" type="checkbox" name="expireable_ind" id="Expireable" value="1"{{ $expireable_ind == '1' ? 'checked' : '' }}>

                   </div>
               </div>
               <label for="pkg_ref" class="col-sm-2 col-form-label col-form-label-sm">Pkg referal</label>
               <div class="col-sm-4">
                   <div class="form-check form-check-inline">
                       <input class="form-check-input" type="checkbox" name="pkg_ref_ind" id="pkg_ref_ind" value="1" {{ $pkg_referral_ind == '1' ? 'checked' : '' }}>

                   </div>
               </div>

               <label for="item_status" class="col-sm-2 col-form-label col-form-label-sm">Status</label>
               <div class="col-sm-4">
                   <div class="form-check form-check-inline">
                       <input class="form-check-input" type="checkbox" name="item_status" id="item_status" value="1"{{ $item_status == '1' ? 'checked' : '' }}>

                   </div>
               </div>
               <label for="dis_inapplicable" class="col-sm-2 col-form-label col-form-label-sm">Dis Inapplicable</label>
               <div class="col-sm-4">
                   <div class="form-check form-check-inline">
                       <input class="form-check-input" type="checkbox" name="dis_inapplicable" id="dis_inapplicable" value="1"{{ $dis_inapplicable == '1' ? 'checked' : '' }}>

                   </div>
               </div>

               <label for="ref_payment" class="col-sm-2 col-form-label col-form-label-sm">Referral Payment</label>
               <div class="col-sm-4">
                   <div class="form-check form-check-inline">
                       <input class="form-check-input" type="checkbox" name="ref_payment" id="ref_payment" value="1"{{ $refferral_pay_calc_ind == '1' ? 'checked' : '' }}>

                   </div>
               </div>


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
                    <input type="text" class="form-control form-control-sm number_only" id="urgent_fee_amt"name="urgent_fee_amt" value="{{ $urgent_fee_amt }}" placeholder="Item Discount fee">
                </div>

                @if (strtoupper(Session::get('user.ses_hospital_code')) != 'MCARE')
                <label for="urgent_fee_amt" class="col-sm-2 col-form-label col-form-label-sm">Emergency Fee</label>
                <div class="col-sm-4">
                    <input type="number" class="form-control form-control-sm number_only" id="urgent_fee_amt"
                    name="urgent_fee_amt" value="{{ $urgent_fee_amt }}" placeholder="Item urgent fee">
                </div>
                @endif

                @if (strtoupper(Session::get('user.ses_hospital_code')) != 'MCARE')
                <label for="temperature" class="col-sm-2 col-form-label col-form-label-sm">Temperature</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control form-control-sm" id="temperature" name="temperature"
                    value="{{ $temperature }}" placeholder="Temperature">
                </div>
                @endif



                @if (strtoupper(Session::get('user.ses_hospital_code')) != 'MCARE')
                <label for="item_vat_persent" class="col-sm-2 col-form-label col-form-label-sm">VAT (%)</label>
                <div class="col-sm-4">
                    <input type="number" class="form-control form-control-sm" id="item_vat_persent" name="item_vat_persent"
                    value="{{ $vat_percent }}" placeholder="Enter Item Generic Name">
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
                    <select class="form-control font_size_12 m-auto" data-type="1" id="item_category" onchange="getSubCategory(this)" name="item_category">
                        <option value="">Select Item Category</option>
                        @if (isset($item_cat_data))
                        @foreach ($item_cat_data as $key => $value)
                        <option value="{{ $key }}" {{ $item_cat == $value ? 'selected' : '' }}>{{ $value }}</option>
                        @endforeach
                        @endif
                    </select>
                </div>

                <label for="item_pack_type" class="col-sm-2 col-form-label col-form-label-sm">Item Category Sub</label>
                <div class="col-sm-4">
                    <select class="form-control font_size_12 m-auto" data-type="2" onchange="getSubCategory(this)" id="item_category_sub" name="item_category_sub">
                        <option value="">Select Item Category sub</option>
                        @if (isset($item_cat_data_sub))
                        @foreach ($item_cat_data_sub as $key => $val)
                        <option value="{{ $key }}" {{ $item_cat_sub == $val ? 'selected' : '' }}>{{ $val }}</option>
                        @endforeach
                        @endif
                    </select>
                </div>

                <label for="item_uom" class="col-sm-2 col-form-label col-form-label-sm">Item Category Sub 1</label>
                <div class="col-sm-4">
                    <select class="form-control font_size_12 m-auto" id="item_category_sub_1" onchange="getSubCategory(this)" data-type="3" name="item_category_sub_1">
                        <option value="">Select Item Category 1</option>
                        @if (isset($item_cat_sub_data_1))
                        @foreach ($item_cat_sub_data_1 as $key => $val)
                        <option value="{{ $key }}" {{ $item_cat_sub_1 == $val ? 'selected' : '' }}>
                        {{ $val }}</option>
                        @endforeach
                        @endif
                    </select>
                </div>

                <label for="item_pack_type" class="col-sm-2 col-form-label col-form-label-sm">Item Category Sub 2</label>
                <div class="col-sm-4">
                    <select data-type="4" class="form-control font_size_12 m-auto" onchange="getSubCategory(this)" id="item_category_sub_2" name="item_category_sub_2">
                        <option value="">Select Item Category 2</option>
                        @if (isset($item_cat_sub_data_2))
                        @foreach ($item_cat_sub_data_2 as $key => $val)
                        <option value="{{ $key }}" {{ $item_cat_sub_2 == $val ? 'selected' : '' }}>{{ $val }}</option>
                        @endforeach
                        @endif
                    </select>
                </div>

                <label for="item_status" class="col-sm-12 col-form-label col-form-label-sm">Item Short Description</label>
                <div class="col-sm-12">
                    <textarea name="short_desc" class="form-control" id="" cols="30" rows="2"></textarea>
                </div>

                <label for="item_status" class="col-sm-12 col-form-label col-form-label-sm">Item Long Description</label>
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
            <button class="btn btn-md btn-success" id="save_update" data-func="" data-response-url="{{ $response_url }}" title="Click here to save Medicine Item Information">Save</button>
            <button type="button" class="btn btn-md btn-danger " data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-md btn-info " data-dismiss="modal">Exit</button>
        </div>
    </div>
</form>







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
    $(document).on('keyup','#item_generic_name',function(){
        if ($(this).val() == "") {
            $('#item_generic_id').val('');
        }
    })
    openItemAutocompleteGeneric("#item_generic_name",  "#item_generic_id");
</script>
