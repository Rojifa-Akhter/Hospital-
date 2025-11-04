<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('css/colors.css') }}">
  <link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
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
            <h5 class="mt-2 mb-0">Create Comparative Statement</h5>
            <small>Inventory /Comparative Statement / Create Comparative Statement</small>
        </div>
        <div class="col-md-3 ">
            <div id="top-action">

                <a rel="tab" href="{{ route('inventory-purchase-requisition.index') }}"
                    class="btn btn-outline-primary btn-md float-right mt-2"><i class="fa fa-desktop"></i>&nbsp;My
                    Comparative Statement
                    Worklist</a>

            </div>
        </div>
    </div>
    <form action="{{ route('comparative-statement.store') }}" id="store_statement" method="post">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5> Create Comparative Statement</h5>
                            </div>

                            <div class="card-body  justify-content-between">

                                <input type="hidden" name="module_code" value="INV">


                                <div class="form-row justify-content-center">
                                    <div class="col-md-4">
                                        <div class="card shadow-sm mb-3">
                                            <div
                                                class="card-body d-flex align-items-center px-2 py-2 justify-content-between">
                                                <div class="d-flex align-items-center">
                                                    <strong class="mr-2">Req. No</strong>
                                                    <div class="">
                                                        <select id="in_requisition_code" name="in_requisition_code">
                                                            @foreach($approved_pr as $pr)
                                                                <option value="{{$pr->inv_requisition_po_no_pk}}">{{$pr->inv_requisition_po_no_pk}}</option>
                                                            @endforeach
                                                        </select>
                                                        
                                                    </div>
                                                </div>
                                                <div class="">
                                                    <button type="button" id="populate"
                                                        class="btn btn-md btn-md-global btn-success mx-1">Search</button>
                                                    <button type="reset" class="btn btn-md btn-md-global btn-danger mx-1"
                                                        onclick="billingEngine.resetBillForm()">Clear</button>
                                                </div>
                                            </div>
                                            <input type="hidden" name="hdn_invoice_id" id="hdn_invoice_id">
                                        </div>

                                    </div>
                                </div>


                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h5>Item List</h5>
                            </div>
                            <div class="card-body mt-2">
                                <div class="row">
                                    <div class="col-12 table-responsive mt-3">
                                        <table class="table  table-striped table-bordered table-hover ">
                                            <thead class="global-uhl-table-bg">
                                                <tr>
                                                    <th class="text-center ">SL</th>
                                                    <th class="text-center">Item Name</th>
                                                    <th class="text-center">UOM</th>
                                                    <th class="text-center">Supp.Product Details</th>
                                                    {{-- <th class="text-center">Barcode</th> --}}

                                                    <th class="text-center ">Rate</th>
                                                    <th class="text-center ">App. Quantity</th>
                                                    {{-- <th class="text-right width-100">Amount</th> --}}

                                                    <th class="text-center ">Suppiler Name</th>
                                                    <th class="text-center ">Unit Price</th>
                                                    <th class="text-center " colspan="2">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="demand_items">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>



                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                            </div>
                            <div class="card-body mt-2">
                                <div class="row">
                                    <div class="col-12 table-responsive mt-3">
                                        <table class="table  table-striped table-bordered table-hover ">

                                            <tfoot>
                                                @php
                                                    $response_url = route('comparative-statement.create');
                                                @endphp
                                                <tr>
                                                    <td colspan="5">
                                                        <button type="button" class="btn btn-sm btn-success"
                                                            onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_url }}')">Save</button>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
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




<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>

<script>
    function test(thisElement) {
        //if ($("#requsition_items tr").length > 0) {

            //$("#requsition_items tr").each(function() {
                var qty = $(thisElement).parents("tr").find(".item-qty").val() * 1;
                var price = $(thisElement).parents("tr").find(".item-rate").val() * 1;
                var total = qty * price;
                $(thisElement).parents("tr").find(".total_price").val(total);

            //});

        //}
        //poItemCalculateTotal1(thisElement)
    }

    function addItemRow(element) {

        var row = $(element).parents("tr").clone();
        $(element).parents("#demand_items").append(row);
        var newId = $(element).parents("#demand_items").find("tr").length + 1;
        var oldId = Number($(element).parents("tr").attr("id"));
        row.find('#item_name_' + oldId).attr('id', 'item_name_' + newId);
        row.find('#supplier_' + oldId).attr('id', 'supplier_' + newId);
        row.find('#item_uom_' + oldId).attr('id', 'item_uom_' + newId);
        row.find('#total_amount_' + oldId).attr('id', 'total_amount_' + newId);
        row.find('#proposed_system_' + oldId).attr('id', 'proposed_system_' + newId);
        row.find('#supplier_prd_details_' + oldId).attr('id', 'supplier_prd_details_' + newId);
        row.find('#item-rate_' + oldId).attr('id', 'item-rate_' + newId);
        row.find('#item_quantities_' + oldId).attr('id', 'item_quantities_' + newId);
        row.find('#proposed_system_' + oldId).attr('id', 'proposed_system_' + newId);



        row.find('#item_name_' + newId).val($(element).parents('tbody').find('#item_name_' +
            oldId).val());
        row.find('#supplier_' + newId).val($(element).parents('tbody').find('#supplier_' +
            oldId).val());
        row.find('#item_uom_' + newId).val($(element).parents('tbody').find('#item_uom_' +
            oldId).val());

        row.find('#total_amount_' + newId).val($(element).parents('tbody').find('#total_amount_' +
            oldId).val());

        row.find('#proposed_system_' + newId).val($(element).parents('tbody').find('#proposed_system_' +
            oldId).val());
        $(element).parents('tbody').find('#item_name_' + oldId).val('Select One');
        $(element).parents('tbody').find('#supplier_' + oldId).val('Select One');
        $(element).parents('tbody').find('#item_uom_' + oldId).val('Select One');
        // $(element).parents('tbody').find('#total_amount_' + oldId).val('');
        $(element).parents('tbody').find('#proposed_system_' + oldId).val('');
        $(element).parents('tbody').find('#supplier_prd_details_' + oldId).val('');
        $(element).parents('tbody').find('#item-rate_' + oldId).val('');
        $(element).parents('tbody').find('#item_quantities_' + oldId).val('');
        $(element).parents('tbody').find('#proposed_system_' + oldId).val('');

        row.find('#action_' + oldId).attr('id', 'action_' + newId);
        $('#action_' + newId).html(
            "<span class='btn btn-danger btn-sm' onclick='removeTableRowOnly(this)'> <i class='fa fa-times'></i> </span>"
        );

    }

    function poItemCalculateTotal1(thisElement) {

        var item_total = 0;
        // if ($("#requsition_items tr").length == 0) {
        //     alert("Please add one item");
        //     return;
        // } else {
        //     $("#requsition_items tr").each(function() {
        //         item_total += $(this).find(".total_price").val() * 1;
        //     });
        // }
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

        console.log(discount_percent, total_discount_amount, "Mohammed Minuddin Peal");

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




        $(document).on('click', '#populate', function(e) {
            e.preventDefault();
            var req_no = $("#in_requisition_code").val();
            var module_code = $("#module_code").val();
            $.ajax({
                url: "{{ route('get_item_list_by_req_no') }}",
                type: 'get',
                data: {
                    module_code: module_code,
                    req_no: req_no
                },
                success: function(data) {
                    // console.log('supplier name', data[0].manufacturer_no_fk);
                    if (data.requisition.length == 0) {
                        var row =
                            '<tr><td colspan="7"> Comparative Statement already approved</td></tr>';
                        $('#demand_items').append(row);
                    } else {


                        var cs_policy = '{{route('cs-policy')}}'
                        var uom_no_fk = '';
                        var uom_name = '';
                        var manufacturer = '';
                        $('#demand_items').html("");
                        var total = 0;
                        var html =
                            '<select name="item_id[]" onchange="setPrice(this)" id="item_name_0" class=""><option>Select One</option>';
                        for (i = 0; i < data.requisition.length; i++) {

                            html += '<option data-price="' +
                                '" data-qty="' + data.requisition[i].req_po_quantity +
                                '" data-item_name="' + data.requisition[i].item_name +
                                '" value="' + data.requisition[i].item_no_fk + '">' +
                                data.requisition[i].item_name + '</option>';
                        }
                        html += '</select>';


                        var uom =
                            '<select name="item_uom[]"  id="item_uom_0" class="select2"><option>Select One</option>';
                        for (i = 0; i < data.uom_data.length; i++) {

                            uom += '<option data-price="' +
                                '" data-uom_sl="' + i +
                                '" data-uom_label_desc="' + data.uom_data[i].uom_label_desc +
                                '" value="' + data.uom_data[i].uom_no_pk + '">' +
                                data.uom_data[i].uom_code + '</option>';
                        }
                        uom += '</select>';

                        var supp_html =
                            '<select name="supplier_id[]" id="supplier_0" class=""><option>Select One</option>';
                        for (i = 0; i < data.suppliers.length; i++) {

                            supp_html += '<option value="' + data.suppliers[i]
                                .supplier_no_pk +
                                '">' +
                                data.suppliers[i].supplier_name + '</option>';
                        }
                        supp_html += '</select>';


                        var supp_prd_dtl = '<textarea name="supplier_prd_details" id="supplier_prd_details_0" cols="30" rows="7"></textarea>';


                        var row =
                            '<tr id="0"><td class="text-center sl-td">0</td><td class="text-left">' +
                            html +
                            '</td><td class="text-center">' +
                                uom +
                            '</td><td class="text-center">' +
                                supp_prd_dtl + '</td><td class="text-right"> <input type="hidden" id="cs_policy_0" name="cs_policy"/><input class="item-name text-right number_only" onkeyup="test(this)" min="0" type="hidden" name="item_name[]" value=""> <input class="text-right number_only" onkeyup="test(this)" min="0" type="hidden" name="item_total[]" value=""> <input class="item-rate text-right" onkeyup="test(this)" min="0" type="text" id="item-rate_0" name="item_rates[]" value=""> </td><td><input class="item-qty text-right number_only" onkeyup="test(this)" min="0" type="text" readonly name="item_quantities[]" id="item_quantities_0" value=""> </td><td>' +
                            supp_html + '</td>' +
                            '<td class="text-center">' +
                            '<input class="total_price" type="text" id="proposed_system_0"' +
                            'name="proposed_system[]"></td>' +
                            '<td id="action_0"><span class="btn btn-sm btn-primary  open-modal" data-id="6156924" data-action="'+cs_policy+'" data-modal="common-modal-sm" data-title="CS Policy" title="Policy"><i class="fa fa-policy-alt">Policy</i></span><button type="button" class="btn btn-success btn-sm" onclick="addItemRow(this)">Add</button></td><td class="text-center" >' +
                            '</td></tr>';



                        $('.sl-td').each(function(index, elem) {
                            $(elem).text(index + 1);
                        });

                        $('#demand_items').append(row);

                        $('.sl-td').each(function(index, elem) {
                            $(elem).text(index + 1);
                        });
                        //poItemCalculateTotal1(this)
                        $("#total_amount_0").val(total);
                    }
                }
            });
            e.stopImmediatePropagation();
        });

        let cs_policy_arr = [];
        $(document).on('click','.add_css', function(){
            
            cs_policy_arr.push({
                policy_name: $('#policy_name').val(),
                policy_uom: $('#policy_uom').val(),
                policy_duration: $('#policy_duration').val(),
                policy_amount: $('#policy_amount').val()
            });

            console.log('Comparative statement ', cs_policy_arr);
            

            $('#cs_policy_0').val(JSON.stringify(cs_policy_arr));
        });





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

    function setPrice(element) {
        var price = $('option:selected', element).attr('data-price');
        var qty = $('option:selected', element).attr('data-qty');
        var item_name = $('option:selected', element).attr('data-item_name');

        // item-qty
        $(element).parents('td').parents('tr').find('.item-rate').val(price);
        $(element).parents('td').parents('tr').find('.item-qty').val(qty);
        $(element).parents('td').parents('tr').find('.item-name').val(item_name);
        $(element).parents('td').parents('tr').find('.total-rate').val(qty * price);
        // $(element).attr('data-price');
        // alert(price);
    }
</script>
