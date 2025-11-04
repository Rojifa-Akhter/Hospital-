<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
  <link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
        <div class="col-md-9">
            <h5 class="mt-2 mb-0">Item Transfer </h5>
            <small>Store /Item Transfer </small>
        </div>
        <div class="col-md-3 mt-2">
            <div id="top-action">

                {{-- <a rel="tab" href="{{ url('inventory/item-received-worklist') }}"
                    class="btn btn-outline-primary btn-md float-right"><i class="fa fa-desktop"></i>&nbsp;Item Recieve
                    List</a> --}}

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fa fa-plus"></i> Item Transfer </h5>
                </div>
                <div class="card-body border-bottom-3 p-2">
                    <form action="{{ route('inventory.store_stock_adjustment') }}" id="stock_adjustment" method="post">
                        @csrf
                        <input type="hidden" name="receive_type" value="chalan">
                        <input type="hidden" name="module_code" class="keep_me" value="INVENTORY">
                        <div class="row">
                            <div class="col-md-12">

                                <!-- <label for="pat_gender" class="col-sm-2 col-form-label col-form-label-sm">Stock
                                    Type <span class="text-danger">*</span></label>

                                <div class="form-check form-check-inline" style="margin-right: 126px;">
                                    <input class="form-check-input" type="radio" id="OPEN" value="OPEN"
                                        name="stock_type">
                                    <label class="form-check-label" for="OPEN">Opening</label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="ISSUE" value="ISSUE"
                                        name="stock_type">
                                    <label class="form-check-label" for="ISSUE">Issue</label>
                                </div>

                                <div class="form-check form-check-inline" style="margin-right: 80px;">
                                    <input class="form-check-input" type="radio" id="RECEIVE" value="RECEIVE"
                                        name="stock_type">
                                    <label class="form-check-label" for="RECEIVE">Receive</label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="RCVRTN" value="RCVRTN"
                                        name="stock_type">
                                    <label class="form-check-label" for="RCVRTN">Receive Return</label>
                                </div>


                                <div class="form-check form-check-inline" style="">
                                    <input class="form-check-input" type="radio" id="ISSRTN" value="ISSRTN"
                                        name="stock_type">
                                    <label class="form-check-label" for="ISSRTN">Issue Return</label>
                                </div> -->

                                <div class="form-check form-check-inline" style="">
                                    <input class="form-check-input" type="radio" id="subStoreToMainStore" value="TRANSFER" checked
                                        name="stock_type">
                                    <label class="form-check-label" for="subStoreToMainStore"
                                        title="Transfer Out > Trasnfer In">Return (Sub Store to Main Store)</label>
                                </div>
                                <div class="form-check form-check-inline" style="">
                                    <input class="form-check-input" type="radio" id="consumption" value="TRANSFER"
                                        name="stock_type">
                                    <label class="form-check-label" for="CONSUMPTION"
                                        title="Transfer Out > Trasnfer In">Consumption (Store to Store)</label>
                                </div>

                                <br>

                                <!-- <div class="form-check form-check-inline" style="margin-right: 15px; margin-left: 17%;">
                                    <input class="form-check-input" type="radio" id="DAMAGE" value="DAMAGE"
                                        name="stock_type">
                                    <label class="form-check-label" for="DAMAGE">Lost/ Damage</label>
                                </div>

                                <div class="form-check form-check-inline" style="margin-left: 8%;">
                                    <input class="form-check-input" type="radio" id="SURPLUS" value="SURPLUS"
                                        name="stock_type">
                                    <label class="form-check-label" for="SURPLUS">Surplus</label>
                                </div>

                                <div class="form-check form-check-inline" style="margin-right: 70px;">
                                    <input class="form-check-input" type="radio" id="EXPIRED" value="EXPIRED"
                                        name="stock_type">
                                    <label class="form-check-label" for="EXPIRED">Expired</label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="TRANSIN" value="TRANSIN"
                                        name="stock_type">
                                    <label class="form-check-label" for="TRANSIN">Transfer In</label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="TRANSOUT" value="TRANSOUT"
                                        name="stock_type">
                                    <label class="form-check-label" for="TRANSOUT">Transfer Out</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="transfer" value="TRANSFER"
                                        name="stock_type">
                                    <label class="form-check-label" for="TRANSFER">Expired Item Transfer</label>
                                </div>
                                <br>
                                <div class="form-check form-check-inline"
                                    style="margin-right: 15px; margin-left: 17%;">
                                    <input class="form-check-input" type="radio" id="direct_consumption"
                                        value="TRANSOUT" name="stock_type">
                                    <label class="form-check-label" for="direct_consumption"
                                        title="Transfer Out > Trasnfer In">Consumption</label>
                                </div> -->
                            </div>



                        </div>

                        <div class="row">

                            <div class="col-md-12">
                            </div>
                            <div class="col-md-12">
                                <div class="form-row justify-content-center">
                                    <div class="col-md-2 ">
                                        <div class="form-group">
                                            <label class="col-form-label col-form-label-sm" for="store_from">Store From
                                                <span class="text-danger">*</span></label>
                                            <select class="form-control select2" id="store_from" name="store_from"
                                                style="width: 100%;">
                                                <option value="">Select Store</option>
                                                @if (!empty($sub_stores))
                                                    @foreach ($sub_stores as $store)
                                                        <option value="{{ $store->serviceunit_no_pk }}">
                                                            {{ $store->serviceunit_name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2 stock_from" >
                                        <div class="form-group">
                                            <label class="col-form-label col-form-label-sm store_label"
                                                for="store_id">  Store To 
                                                <span class="text-danger spn_store_to">*</span></label>
                                            <select class="form-control select2" id="store_id" name="store_id"
                                                style="width: 100%;">
                                                <option value="">Select Store</option>
                                                @if (!empty($main_stores))

                                                    @foreach ($main_stores as $store)
                                                        <option value="{{ $store->serviceunit_no_pk }}">
                                                            {{ $store->serviceunit_name }}</option>
                                                    @endforeach
                                                @endif


                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2" id="subToStore">
                                        <div class="form-group">

                                            <label class="col-form-label col-form-label-sm store_label"
                                                for="store_id">  Store To
                                                <span class="text-danger spn_store_to">*</span></label>
                                            <select class="form-control select2" id="store_id2" name="store_id"
                                                style="width: 100%;">
                                                <option value="">Select Store</option>


                                                @if (!empty($sub_stores))

                                                    @foreach ($sub_stores as $store)
                                                        <option value="{{ $store->serviceunit_no_pk }}">
                                                            {{ $store->serviceunit_name }}</option>
                                                    @endforeach
                                                @endif


                                            </select>
                                        </div>
                                    </div>
                                   

                                    <div class="form-group col-md-2">
                                        <label for="supplier_id" class="col-form-label col-form-label-sm">Select
                                            Supplier</label>
                                        <select class="form-control select2" id="supplier_id" name="supplier_id">
                                            <option value="">Select Supplier</option>
                                            @if (!empty($supplier_arr))
                                                @foreach ($supplier_arr as $key => $ic)
                                                    <option value="{{ $key }}">{{ $ic }}
                                                    </option>
                                                @endforeach
                                            @endif


                                        </select>
                                    </div>
                                    <div class="form-group  col-md-2">
                                        <label class="col-form-label col-form-label-sm" for="date">Date <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-sm m-0 date_picker"
                                            id="date" name="date" value="" placeholder="dd-mm-yyyy">
                                    </div>




                                    <div class="form-group col-md-2">
                                        <label class="col-form-label col-form-label-sm" for="demand_id">PO

                                        </label>
                                        <input type="text" class="form-control form-control-sm m-0" id="po"
                                            name="in_purchaseorder_no_fk" value="" placeholder="PO">
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="col-form-label col-form-label-sm" for="challan_no">Challan
                                                No</label>
                                            <input type="text" class="form-control form-control-sm m-0"
                                                id="challan_no" name="challan_no" value=""
                                                placeholder="Challan No">
                                        </div>
                                    </div>
                                    <div class="col-md-2"></div>

                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-row">
                                    <div class="form-group col-md-2">
                                        <label class="col-form-label col-form-label-sm" for="pvms_no">Item
                                            Code</label>
                                        <!--  <input type="text" class="form-control form-control-sm m-0" id="item_id" name="item_id" value="" placeholder="Item ID" > -->
                                        <input type="text" class="form-control form-control-sm m-0" id="item_code"
                                            name="item_code" value="" placeholder="Item Code">
                                    </div>

                                    <div class="form-group col-md-2">
                                        <label class="col-form-label col-form-label-sm" for="item_name">Item
                                            Name</label>
                                        <input type="hidden" name="item_id_hidden" id="item_id_hidden">
                                        <input type="hidden" name="sales_price" id="sales_price">
                                        <input type="hidden" name="pre_item_price" id="pre_item_price">

                                        <input type="text" class="form-control form-control-sm m-0" id="item_name"
                                            name="item_name" value="" placeholder="Item Name">
                                    </div>

                                    <div class="form-group col-md-1">
                                        <label class="col-form-label col-form-label-sm" for="item_uom">
                                            UoM</label>
                                        <select name="item_uom_list" id="item_uom_list"
                                            class="form-control form-control-sm m-0">
                                            <option value="">select</option>
                                            @if (!empty($uom))
                                                @foreach ($uom as $key => $value)
                                                    <option value="{{ $key }}">{{ $value }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-group col-md-1">
                                        <label class="col-form-label col-form-label-sm" for="item_uom">Item
                                            UoM</label>
                                        <input type="hidden" name="item_uom_hidden" id="item_uom_hidden">
                                        <input type="hidden" name="pree_item_uom_hidden" id="pree_item_uom_hidden">
                                        <input type="text" class="form-control form-control-sm m-0" id="item_uom"
                                            name="item_uom" value="" placeholder="Item UoM">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label class="col-form-label col-form-label-sm" for="item_price">Purchase
                                            Price</label>
                                        <input type="text"
                                            class="form-control form-control-sm m-0 text-right number_only"
                                            id="item_price" name="item_price" value=""
                                            placeholder="Item Price">
                                    </div>
                                    <div class="form-group col-md-1">
                                        <label class="col-form-label col-form-label-sm" for="item_quantity">Item
                                            Quantity</label>
                                        <input type="text"
                                            class="form-control form-control-sm m-0 text-right number_only"
                                            id="item_quantity" name="item_quantity" value=""
                                            placeholder="Item Quantity">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label class="col-form-label col-form-label-sm" for="single_quantity">Single
                                            Quantity</label>
                                        <input type="text"
                                            class="form-control form-control-sm m-0 text-right number_only"
                                            id="single_quantity" name="single_quantity" value=""
                                            placeholder="Single Quantity">
                                    </div>


                                    <div class="form-group col-md-1">
                                        <button type="button" id="add_item_btn"
                                            class="btn btn-success btn-block btn-md btn-md-global mt-4"><i class="fa fa-plus"></i>
                                            Add
                                            </button>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 table-responsive mt-3">
                                <table class="table  table-striped table-bordered table-hover">
                                    <thead class="global-uhl-table-bg">
                                        <tr>
                                            <th class="text-center ">SL</th>
                                            <th class="text-center">Item Code</th>
                                            {{-- <th class="text-center">Barcode</th> --}}
                                            <th class="text-center">Item Name</th>
                                            <th class="text-center">UoM</th>
                                            <th class="text-center ">Rate</th>
                                            <th class="text-center ">Item Quantity</th>
                                            <th class="text-center ">single Quantity</th>
                                            {{-- <th class="text-right width-100">Amount</th> --}}
                                            <th class="text-center ">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="adjust_worklist">

                                    </tbody>
                                </table>
                            </div>
                        </div>



                        <div class="row">
                            @php
                                $response_action = route('inventory.stock_adjustment_sub_main');
                            @endphp
                            <div class="col-12 text-right">

                                <button type="submit"
                                    onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')"
                                    class="btn btn-success btn-md"><i class="fa fa-save"></i> Save
                                </button>


                                <button type="reset" class="btn btn-info btn-md"
                                    title="Click here to Clear form data">Clear
                                </button>

                                <a href="{{ route('admin-dashboard') }}" class="btn btn-danger btn-md"
                                    rel="tab" title="Click here to go back to Dashboard">Exit</a>

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

$("body").addClass("sidebar-collapse");
    $(document).ready(function() {
        $("[name='stock_type']").on('change', function() {
            //consumption
            if ($('#subStoreToMainStore').is(":checked")) {
                $('.stock_from').removeClass('d-none');
                $('#subToStore').addClass('d-none');
                $('#store_id2').attr('disabled',true);
                $('#store_id').attr('disabled',false);
                //  $("p").append("<b>Appended text</b>");
                // $('.store_label').html('Store From');
                // $(".store_label").append(`<span class="text-danger"> *</span>`);
                // $('.spn_store_to').show();
            }else if ($('#consumption').is(":checked")) {
                $('.stock_from').addClass('d-none');
                $('#store_id').attr('disabled',true);
                $('#store_id2').attr('disabled',false);
                $('#subToStore').removeClass('d-none');
                //  $("p").append("<b>Appended text</b>");
                // $('.store_label').html('Store To');
                // $(".store_label").append(`<span class="text-danger"> *</span>`);
                // $('.spn_store_to').show();
            } 
            // else {
            //     $('.store_label').html('Store');
            //     // $('.spn_store_to').show();
            //     $(".store_label").append(`<span class="text-danger"> *</span>`);

            //     $('.stock_from').hide();
            // }
        });
        $('#subToStore').addClass('d-none');
        $('#store_id2').attr('disabled',true);

        $("#item_quantity").blur(function() {
            var item_price = $("#item_price").val();
            var item_quantity = $('#item_quantity').val();

            var in_total = Number(item_price) * Number(item_quantity);
            $("#in_total").val(in_total);
        });


        $('.date_picker').datepicker({
            format: 'yyyy-mm-dd',
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

        inventory_autocomplete_iteminfo_by_item_name('#item_name', 'item_name', function(item, obj) {


            // alert(item.uom_no_fk);

            $('#item_id_hidden').val(item.item_id);
            $('#item_uom_hidden').val(item.uom_no_fk);
            $('#pree_item_uom_hidden').val(item.uom_no_fk);
            $('#item_uom').val(item.uom_name);
            $('#pvms_no').val(item.pvms_no);
            $('#item_code').val(item.item_code);

            $('#item_price').val(item.purchase_price);
            $('#pre_item_price').val(item.purchase_price);
            $('#sales_price').val(item.item_rate);
            // $('#item_id').val(item.item_id);
            $("#item_uom_list option").each(function() {

                if ($(this).val() == item.uom_no_fk) {
                    $(this).prop('selected', true);
                    return;
                }
            });
            obj.stopImmediatePropagation();

        });

        $(document).on('change', '#item_uom_list', function() {
            var uom_val = $('#item_uom_list :selected').val();
            var uom_text = $('#item_uom_list :selected').text();
            $('#item_uom').val(uom_text);
            $('#item_uom_hidden').val(uom_val);
            // $('#pree_item_uom_hidden').val(uom_val);
            if (uom_val == $('#pree_item_uom_hidden').val()) {
                $('#item_price').val($('#pre_item_price').val());
            } else {
                $('#item_price').val($('#sales_price').val());
            }

        })




        inventory_autocomplete_iteminfo_by_item_code('#item_code', 'item_code', function(item, obj) {
            $('#item_code').val(item.item_code);
            $('#item_name').val(item.item_name);
            $('#item_id_hidden').val(item.item_id);
            $('#item_uom_hidden').val(item.uom_no_fk);
            $('#item_uom').val(item.uom_name);
            // $('#pvms_no').val(item.pvms_no);
            obj.stopImmediatePropagation();
        });


        $(document).on('click', '#populate', function(e) {
            e.preventDefault();
            var purchase_order_id = $("#po").val();
            $.ajax({
                url: "{{ route('get_item_list_by_purchase_order') }}",
                type: 'get',
                data: {
                    purchase_order_id: purchase_order_id
                },
                success: function(data) {
                    var uom_no_fk = '';
                    var uom_name = '';
                    for (i = 0; i < data.length; i++) {
                        if (typeof data[i].uom_no_fk == "undefined") {
                            uom_no_fk = "";
                            uom_name = "";
                        } else {
                            uom_no_fk = data[i].uom_no_fk;
                            uom_name = data[i].uom_name;
                        }

                        var row = '<tr>' +
                            '<td class="sl-td">0</td>' +
                            '<td class="text-center"> <input type="hidden"  name="item_id[]" value="' +
                            data[i].item_no_pk + '">' + data[i].item_code +
                            '</td>' +
                            '<td class="text-center"> <input type="hidden" class="same-item-id" name="item_ids[]" value="' +
                            data[i].item_no_pk +
                            '">' + data[i].item_name + '</td>' +
                            '<td class="text-center"> <input type="hidden" name="item_uoms[]" value="' +
                            uom_no_fk + '">' +
                            uom_name + '</td>' +
                            '<td class="text-center"> <input type="hidden"  name="item_prices[]" value="' +
                            data[i].purchase_price + '">' + data[i].purchase_price +
                            '</td>' +
                            '<td class="text-center"> <input type="hidden"   name="item_quantities[]" value="' +
                            data[i].entry_qty + '">' + data[i].entry_qty + '</td>' +
                            '<td> <a href="javascript:void(0)" class="btn btn-sm btn-danger remove-item-btn" title="Remove"><i class="fa fa-times-circle"></i></a></td>' +
                            '</tr>';

                        $('#adjust_worklist').append(row);

                        $('.sl-td').each(function(index, elem) {
                            $(elem).text(index + 1);
                        });
                    }


                }
            });

            e.stopImmediatePropagation();

        });


        $(document).on('click', '#add_item_btn', function(e) {
            e.preventDefault()


            if ($('input[name="stock_type"]:checked').length == 0) {
                alert('please select stock type');
                return false;
            } else if ($('#store_id').find(":selected").val() == "") {
                alert('please select store');
                return false;
            } else if ($('#supplier_id').find(":selected").val() == "") {
                // alert('please select supplier');
                // return false;
            } else if ($('#date').val() == "") {
                alert('please select date');
                return false;
            } else {
                if ($('#transfer').is(":checked")) {
                    if ($('#store_from').val() == "") {
                        alert('please store from');
                        return false;
                    }
                }
            }





            console.log($('#sales_price').val() + '_sals')
            var pvms_no = $('#pvms_no').val();
            var item_name = $('#item_name').val();
            var item_id = $('#item_id').val();
            var item_code = $('#item_code').val();

            var item_id = $('#item_id_hidden').val();
            var item_uom_name = $('#item_uom').val();
            var item_uom_no = $('#item_uom_hidden').val();
            var item_quantity = $('#item_quantity').val();
            var single_quantity = $('#single_quantity').val() != "" ? $('#single_quantity').val() : 0;
            var item_price = $('#item_price').val();
            var sales_price = $('#sales_price').val();
            var purchase_price = $('#purchase_price').val();
            var in_total = $('#in_total').val();
            $('textbox').removeAttr('readonly').val('Changed Value');

            console.log(sales_price, item_name, item_id, item_code, item_id, item_uom_name, item_uom_no,
                item_quantity, item_price, sales_price, purchase_price, in_total)
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
                $('#single_quantity').val('');
                $('#item_price').val('');
                $('#sales_price').val('');
                $('#in_total').val('');
                $('#item_uom_list').val('')
                e.stopImmediatePropagation();
                return false
            }

            var row = '<tr>' +
                '<td class="sl-td">0</td>' +
                '<td class="text-center"> <input type="hidden"  name="item_id[]" value="' + item_id +
                '">' + item_code +
                '</td>' +
                '<td class="text-center"> <input type="hidden" class="same-item-id" name="item_ids[]" value="' +
                item_id +
                '">' + item_name + '</td>' +
                '<td class="text-center"> <input type="hidden" name="item_uoms[]" value="' +
                item_uom_no + '">' +
                item_uom_name + '</td>' +
                '<td class="text-center"> <input type="hidden"  name="item_prices[]" value="' +
                item_price + '">' + item_price + '</td>' +
                '<td class="text-center"> <input type="hidden"   name="item_quantities[]" value="' +
                item_quantity + '">' + item_quantity + '</td>' +
                '<td class="text-center"> <input type="hidden"   name="hdn_single_quantity[]" value="' +
                single_quantity + '">' + single_quantity + '</td>' +
                '<td> <a href="javascript:void(0)" class="btn btn-sm btn-danger remove-item-btn" title="Remove"><i class="fa fa-times-circle"></i></a></td>' +
                '</tr>';

            $('#adjust_worklist').append(row);

            $('#pvms_no').val('');
            $('#item_name').val('');
            $('#item_id').val('');
            $('#item_code').val('');
            $('#item_id_hidden').val('');
            $('#item_uom').val('');
            $('#item_uom_hidden').val('');
            $('#item_quantity').val(0);
            $('#single_quantity').val(0);
            $('#item_price').val(0);
            $('#sales_price').val(0);
            $('#in_total').val(0);
            $('#item_uom_list').val('')
            $('.sl-td').each(function(index, elem) {
                $(elem).text(index + 1);
            });

            e.stopImmediatePropagation();

        });

        $(document).on('click', '.remove-item-btn', function(e) {
            e.preventDefault();
            $(this).closest('tr').remove();
            $('.sl-td').each(function(index, elem) {
                $(elem).text(index + 1);
            })
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
                                    '<td> <input type="hidden" name="item_uoms[]" value="' +
                                    iteminfo.uom + '">' + iteminfo.uom_text +
                                    '</td>' +
                                    '<td class="text-right"> <input type="hidden"  name="item_prices[]" value="' +
                                    iteminfo.item_rate + '">' + iteminfo.item_rate +
                                    '</td>' +
                                    '<td class="text-right"> <input type="hidden"   name="item_quantities[]" value="' +
                                    iteminfo.entry_qty + '">' + iteminfo.entry_qty +
                                    '</td>' +
                                    '<td> <a href="javascript:void(0)" class="btn btn-sm btn-danger remove-item-btn" title="Remove"><i class="fa fa-times-circle"></i></a></td>' +
                                    '</tr>'
                            }

                        })

                        $('#adjust_worklist').append(rows);
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
</script>
