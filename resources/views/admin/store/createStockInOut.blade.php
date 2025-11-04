<style type="text/css">
    .display_none {
        display: none;
    }

</style>
<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
        <div class="col-md-9">
            <h5 class="mt-2 mb-0">Stock in Out</h5>
            <small>Stock in Out Entry</small>
        </div>
        <div class="col-md-3">
            <div id="top-action">

                <a rel="tab" href="{{ route('inventory.stock_in_out') }}"
                    class="btn btn-outline-primary btn-md float-right mt-2"><i
                        class="fa fa-desktop"></i>&nbsp;Transaction
                    Worklist</a>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
                <form action="{{ route('inventory.store_stock_in_out') }}" id="store_purchase_order" method="post">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5>Select Stock Type</h5>
                            </div>

                            <div class="card-body mt-2">


                                <div class="row">
                                    <div class="col-md-12">

                                        <label for="pat_gender" class="col-sm-2 col-form-label col-form-label-sm">Stock
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
                                            <label class="form-check-label" for="RCVRTN">Receiev Return</label>
                                        </div>


                                        <div class="form-check form-check-inline" style="">
                                            <input class="form-check-input" type="radio" id="ISSRTN" value="ISSRTN"
                                                name="stock_type">
                                            <label class="form-check-label" for="ISSRTN">Issue Return</label>
                                        </div>
                                        <br>

                                        <div class="form-check form-check-inline"
                                            style="margin-right: 15px; margin-left: 17%;">
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

                                        <div class="form-check form-check-inline" style=" margin-bottom: 15px;">
                                            <input class="form-check-input" type="radio" id="TRANSOUT" value="TRANSOUT"
                                                name="stock_type">
                                            <label class="form-check-label" for="TRANSOUT">Transfer Out</label>
                                        </div>
                                    </div>



                                </div>








                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h5>Create Transaction</h5>
                            </div>

                            <div class="card-body mt-2">
                                <!-- <form action="{{ route('inventory.store_purchase_order') }}" id="store_demand_items" method="post"> -->

                                <div class="row">

                                    <div class="col-md-12">
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-row justify-content-center">
                                            <div class="col-md-2">
                                                <div class="form-group">

                                                    <label class="col-form-label col-form-label-sm" for="store_id">Store
                                                        <span class="text-danger"></span></label>
                                                    <select class="form-control select2" id="store_id" name="store_id"
                                                        style="width: 100%;">
                                                        <option value="">Select Store</option>


                                                        @if (!empty($stores))

                                                            @foreach ($stores as $store)

                                                                <option value="{{ $store->serviceunit_no_pk }}">
                                                                    {{ $store->serviceunit_name }}</option>

                                                            @endforeach
                                                        @endif


                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2 display_none store_from_wrapper">
                                                <div class="form-group">

                                                    <label class="col-form-label col-form-label-sm"
                                                        for="store_id_from">Store From<span
                                                            class="text-danger"></span></label>
                                                    <select class="form-control select2" id="store_id_from"
                                                        name="store_id_from" style="width: 100%;">
                                                        <option value="">Select Store</option>


                                                        @if (!empty($stores))

                                                            @foreach ($stores as $store)

                                                                <option value="{{ $store->serviceunit_no_pk }}">
                                                                    {{ $store->serviceunit_name }}</option>

                                                            @endforeach
                                                        @endif


                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label for="supplier_id" class="col-form-label col-form-label-sm">Select
                                                    Supplier <span class="text-danger">*</span></label>
                                                <select class="form-control select2" id="supplier_id"
                                                    name="supplier_id">
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
                                                    id="date" name="date" value="" placeholder="yyyy-mm-dd">
                                            </div>




                                            <div class="form-group col-md-2">
                                                <label class="col-form-label col-form-label-sm" for="demand_id">Purchase
                                                    Order</label>
                                                <input type="text" class="form-control form-control-sm m-0" id="po"
                                                    name="in_purchaseorder_no_fk" value=""
                                                    placeholder="Purchase Order No">
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="col-form-label col-form-label-sm"
                                                        for="challan_no">Challan No</label>
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
                                                <input type="text" class="form-control form-control-sm m-0"
                                                    id="item_code" name="item_code" value="" placeholder="Item Code">
                                            </div>

                                            <div class="form-group col-md-2">
                                                <label class="col-form-label col-form-label-sm" for="item_name">Item
                                                    Name</label>
                                                <input type="hidden" name="item_id_hidden" id="item_id_hidden">
                                                <input type="text" class="form-control form-control-sm m-0"
                                                    id="item_name" name="item_name" value="" placeholder="Item Name">
                                            </div>

                                            <div class="form-group col-md-2">
                                                <label class="col-form-label col-form-label-sm" for="item_uom">Item
                                                    UOM</label>
                                                <input type="hidden" name="item_uom_hidden" id="item_uom_hidden">
                                                <input type="text" class="form-control form-control-sm m-0"
                                                    id="item_uom" name="item_uom" value="" placeholder="Item UOM">
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label class="col-form-label col-form-label-sm"
                                                    for="item_price">Purchase Price</label>
                                                <input type="text"
                                                    class="form-control form-control-sm m-0 text-right number_only"
                                                    id="item_price" name="item_price" value="0"
                                                    placeholder="Item Price">
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label class="col-form-label col-form-label-sm" for="item_quantity">Item
                                                    Quantity</label>
                                                <input type="text"
                                                    class="form-control form-control-sm m-0 text-right number_only"
                                                    id="item_quantity" name="item_quantity" value="0"
                                                    placeholder="Item Quantity">
                                            </div>


                                            <div class="form-group col-md-2">
                                                <button type="button" id="add_item_btn"
                                                    class="btn btn-success btn-block btn-md mt-4"><i
                                                        class="fa fa-plus"></i> Add Item</button>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 table-responsive mt-3">
                                        <table class="table  table-striped table-bordered table-hover">
                                            <thead class="bg-primary">
                                                <tr>
                                                    <th class="text-center ">SL</th>
                                                    <th class="text-center">Item Code</th>
                                                    {{-- <th class="text-center">Barcode</th> --}}
                                                    <th class="text-center">Item Name</th>
                                                    <th class="text-center">UOM</th>
                                                    <th class="text-center ">Rate</th>
                                                    <th class="text-center ">Item Quantity</th>
                                                    {{-- <th class="text-right width-100">Amount</th> --}}
                                                    <th class="text-center ">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="demand_items">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="custom-box">
                                            <div class="custom-box-body m-0 text-right">

                                                @php
                                                    $response_action = route('inventory.stock_in_out');
                                                @endphp

                                                <button type="submit"
                                                    onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')"
                                                    class="btn btn-md btn-success">Save</button>

                                                <button type="reset" class="btn btn-info btn-md"
                                                    title="Click here to Clear form data">Clear</button>
                                                <a href="{{ route('admin-dashboard') }}"
                                                    class="btn btn-danger btn-md" rel="tab"
                                                    title="Click here to go back to Dashboard">Exit</a>
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
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="submit" id="entry_ready_items" class="btn btn-primary">Save changes</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<script type="application/javascript"
    src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>

<script>
    $(document).ready(function() {

        $('.date_picker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
            clearBtn: true,
            startDate: new Date()
        });
        $('.data-table').DataTable({
            "ordering": false,
            "bPaginate": false,
            "bLengthChange": false,
            "bAutoWidth": false
        });


        // openReceiveItemAutocomplete('#pvms_no', 'pvms_no', function(item, obj) {
        //     $('#item_id_hidden').val(item.item_id);
        //     $('#item_uom_hidden').val(item.uom_no_fk);
        //     $('#item_uom').val(item.uom_name);
        //     $('#item_name').val(item.item_name);
        //     $("#item_price").val(item.purchase_price);
        //     obj.stopImmediatePropagation();
        // });

        openReceiveItemAutocomplete('#item_name', 'item_name', function(item, obj) {
           // console.log(item)
            $('#item_code').val(item.item_code);
            $('#item_id_hidden').val(item.item_id);
            $('#item_uom_hidden').val(item.uom_no_fk);
            $('#item_uom').val(item.uom_name);
            $("#item_price").val(item.purchase_price);

            // $('#pvms_no').val(item.pvms_no);
            obj.stopImmediatePropagation();
        });

        openReceiveItemCodeAutocomplete('#item_code', 'item_code', function(item, obj) {
            //console.log(item)
            $('#item_code').val(item.item_code);
            $('#item_name').val(item.item_name);
            $('#item_id_hidden').val(item.item_id);
            $('#item_uom_hidden').val(item.uom_no_fk);
            $('#item_uom').val(item.uom_name);
            $("#item_price").val(item.purchase_price);

            // $('#pvms_no').val(item.pvms_no);
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
            "<?php foreach ($supplier_arr as $key => $ic): ?>"
            suppliers.push("<?php echo $ic; ?>")
            "<?php endforeach; ?>"

            $.ajax({
                async: true,
                data: {
                    supplier_id: $('#supplier_id').val(),
                    item_suppliers: suppliers,
                },
                dataType: "html",
                url: "{{ route('inventory.default_supplier_items') }}",
                type: 'post',
                beforeSend: function() {
                    if (isAModalOpen)
                        $('.modal').modal('hide');
                    blockUI();
                },
                success: function(data) {

                    //alert(data);

                    $('.modal-body').html(data)
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
            })
            e.stopImmediatePropagation();

        })




        $(document).on('click', '#add_item_btn', function(e) {
            e.preventDefault()
            var item_id = $('#item_id').val()
            var item_name = $('#item_name').val()
            var item_code = $('#item_code').val()

            var item_id_hidden = $('#item_id_hidden').val()
            var item_uom_name = $('#item_uom').val()
            var item_uom_no = $('#item_uom_hidden').val()
            var item_quantity = $('#item_quantity').val()
            var item_price = $('#item_price').val()

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
                e.stopImmediatePropagation();
                return false
            }

            var row = '<tr>' +
                '<td class="text-center sl-td">0</td>' +
                '<td class="text-left"> <input type="hidden" name="item_id[]" value="' + item_id +
                '">' + item_code + '</td>' +
                '<td class="text-left"> <input type="hidden" class="same-item-id" name="item_ids[]" value="' +
                item_id + '">' + item_name + '</td>' +
                '<td class="text-left"> <input type="hidden" name="item_uoms[]" value="' + item_uom_no +
                '">' + item_uom_name + '</td>' +
                '<td class="text-right"> <input class="item-rate text-right number_only" min="0" type="text" name="item_rates[]" value="' +
                item_price + '"></td>' +
                '<td class="text-right"> <input class="item-qty text-right number_only" min="0" type="text" name="item_quantities[]" value="' +
                item_quantity + '"></td>' +
                '<td> <a href="javascript:void(0)" class="btn btn-sm btn-danger remove-item-btn" title="Remove"><i class="fa fa-times-circle"></i></a></td>' +
                '</tr>'
            $('#demand_items').append(row)

            $('#item_id').val('')
            $('#item_name').val('')
            $('#item_id_hidden').val('')
            $('#item_uom').val('')
            $('#item_uom_hidden').val('')
            $('#item_quantity').val(0)
            $('#item_price').val(0)

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


    $(document).ready(function() {
        $('input:radio[name="stock_type"]').change(
            function() {
                if ($(this).is(':checked') && ($(this).val() == 'TRANSOUT' || $(this).val() == 'TRANSIN')) {
                    $(".store_from_wrapper").show();
                } else {
                    $(".store_from_wrapper").hide();
                }

            });

    });

</script>
