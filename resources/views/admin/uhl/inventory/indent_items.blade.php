<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <!-- <form action="" id="search_default_items">
                        <div class="row justify-content-between align-items-center">
                            <div class="col-md-2">

                            </div>
                            <div class="col-md-4">
                                <input type="radio" name="type" onchange="filterItem(this)" value="1"> Below
                                ReOrder
                                Level
                                <input type="radio" name="type" onchange="filterItem(this)" value="2"> All
                            </div>
                            <div class="col-md-4">
                                <div class="form-row py-2 text-right">
                                    <label for="item_category" class="col-md-10 col-form-label text-right">Select All
                                        Items</label>
                                    <div class="col-md-2 text-left">
                                        <input type="checkbox" id="checked_all" name="checked_all">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form> -->
                    <form action="" id="">
                        <div class="form-group form-row">
                            <div class="col-sm-3">
                                <label for="pr_date_from" class="col-form-label"> From Date </label>
                                <input type="text" class="form-control date_picker" id="pr_date_from" name="pr_date_from" value="{{date('d-m-Y')}}" />
                            </div>
                            <div class="col-sm-3">
                            <label for="pr_date_to" class="col-form-label"> To Date </label>
                                <input type="text" class="form-control date_picker" id="pr_date_to" name="pr_date_to" value="{{date('d-m-Y')}}" />
                            </div>
                            <div class="col-sm-3">
                                <label for="pr_date_to" class="col-form-label"> P.R. No.</label>
                                <input type="text"  class="form-control" name="pr_no" id="pr_no">
                            </div>
                            <button type="button" class="btn btn-primary mt-4 col-sm-3"  onclick="prItemSearch()">Search</button>

                        </div>
                    </form>
                    <input type="hidden" name="selected_supplier" id="selected_supplier" value="{{ $selected_supplier }}">
                    <form action="#" method="post" id="indent_items_form">
                        @csrf
                        <input type="hidden" id="indent_pr_no" name="" value="">
                        <div class="row">

                            <div class="col-12 table-responsive mt-3" style="height: 350px; overflow-y: scroll" id="default_item_table">
                                @include('admin.uhl.inventory.indent_items_table')
                            </div>
                            <div class="col-12 mt-3">
                                <div class="d-flex justify-content-start"><h2>In basket</h2><p class="mt-1 text-danger"> (<span id="basket_item_no">0</span> Items)</p></div>
                                <table class="table data-table  table-bordered table-hover" width="100%" id="item_basket">
                                    <thead class="global-uhl-table-bg">
                                        <tr>
                                            <td class="text-left">Item Name</td>
                                            <td>Item Qty</td>
                                        </tr>
                                    </thead>
                                    <tbody id="basket">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>


    var numberCount = 0;
     $(document).ready(function() {
        if($('#indent_purchase_order_entry_modal').hasClass("show")){
            numberCount = 0;
            $('#basket_item_no').text(numberCount);
        }
    });
    $(".date_picker").datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true
    })

    function prItemSearch() {

        var pr_date_from = $('#pr_date_from').val();
        var pr_date_to = $('#pr_date_to').val();
        var pr_no = $('#pr_no').val();
        $.ajax({
            async: true,
            data: {
                pr_date_from: pr_date_from,
                pr_date_to: pr_date_to,
                pr_no: pr_no
            },
            dataType: "html",
            url: "{{ route('v1.search_pr_item') }}",
            type: 'post',
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                $('#requisition_item tbody tr').remove();
                $('#default_item_table').html(data)
            },
            complete: function() {
                $.unblockUI();
            },
            error: function(data) {
                $.unblockUI();
            }
        })
    }

    function filterItem(thisElement) {
        var type = $(thisElement).val();
        var selected_supplier = $("#selected_supplier").val();
        $.ajax({
            data: {
                type: type,
                supplier_id: selected_supplier
            },
            url: "{{ route('filter-default-supplier-items') }}",
            type: "POST",
            beforeSend: function() {
                // $('.data-table').DataTable().clear().destroy();
                blockUI();
            },
            success: function(data) {
                // $('.data-table').DataTable({
                //     "ordering": false,
                //     "bPaginate": false,
                //     "bLengthChange": false,
                //     "bAutoWidth": false
                // });
                $('#default_item_table').html(data)

            },
            complete: function() {

            },
            error: function(data) {
                $.unblockUI();
            }
        }).done(function() {
            $.unblockUI();
        });
    }

    // function setTotalPrice() {
    //     if ($("#demand_items tr").length > 0) {
    //         $("#demand_items tr").each(function() {
    //             var price = $(this).find(".item-rate").val() * 1;
    //             var qty = $(this).find(".item-qty").val() * 1;
    //             var total = price * qty;

    //             $(this).find(".total_price").val(parseFloat(total));
    //         });
    //     }
    //     calculateTotal();
    // }
    var indent_dtl=[];

    function selectedItem(element) {
        var item_info = $(element).val();

        console.log(item_info);
        var exp = item_info.split('_');
        // if (exp[16] !=null) {
        //     $(".item_check").prop("checked", false);
        //     $(element).prop("checked", true);
        //     $('#basket').html('');
        // }

        if ($(element).is(':checked')) {
             indent_dtl.push( exp[0]+'_'+exp[20]+'_'+exp[21])

            numberCount++;
        }else{
            indent_dtl = $.grep(indent_dtl, function(value) {
            return value !=  exp[0]+'_'+exp[20]+'_'+exp[21];
            });
            numberCount--;
        }
        if(numberCount < 0){
            numberCount = 0
        }

        $('#basket_item_no').text(numberCount);
        $('#indent_pr_no').val(indent_dtl);
        // console.log("indent_dtl", indent_dtl)
        if ($('#basket tr').length >= 1) {
            var current_item_id = exp[0];
            var current_qty = parseFloat(exp[2]);
            var item_id = '';
            var duplicate_item = 0;



            $('.item_no').each(function() {


                item_id = $(this).val();
                console.log(item_id, current_item_id, 0);
                if (current_item_id == item_id) {
                    duplicate_item = 1;
                    var entry_current_qty = parseFloat($(this).parents('td').parents('tr').find('.item_qty').html());
                    if ($(element).is(':checked')) {
                        $(this).parents('td').parents('tr').find('.item_qty').html(entry_current_qty + current_qty);
                        $(this).parents('td').parents('tr').find('#hdn_item_qty').val(entry_current_qty + current_qty);
                        $(this).parents('td').parents('tr').find('#hdn_item_specification').val('');
                    } else {
                        if (entry_current_qty == current_qty) {
                            $(this).parents('td').parents('tr').remove();
                        } else {
                            $(this).parents('td').parents('tr').find('.item_qty').html(entry_current_qty - current_qty);
                            $(this).parents('td').parents('tr').find('#hdn_item_qty').val(entry_current_qty - current_qty);
                            $(this).parents('td').parents('tr').find('#hdn_item_specification').val('');
                        }
                    }
                    console.log(item_id, current_item_id, 1);
                    return false;
                }
            })

            if (duplicate_item == 0) {

                var basket_data = `<tr>

                    <td class="text-left">
                    <input type="hidden"  name="" id="hdn_item_no" class="item_no" value="${exp[0]}">
                    <input type="hidden"  name="hdn_item_name" id="hdn_item_name"  value="${exp[1]}">
                    <input type="hidden"  name="hdn_item_specification" id="hdn_item_specification"  value="${exp[19]}">
                    <input type="hidden"  name="hdn_item_qty" id="hdn_item_qty"  value="${exp[2]}">
                    <input type="hidden"  name="hdn_requisitiondtl_no" id="hdn_requisitiondtl_no"  value="${exp[3]}">
                    <input type="hidden"  name="hdn_item_code" id="hdn_item_code"  value="${exp[5]}">
                    <input type="hidden"  name="hdn_pur_um_no" id="hdn_pur_um_no"  value="${exp[6]}">
                    <input type="hidden"  name="hdn_pur_um_name" id="hdn_pur_um_name"  value="${exp[7]}">
                    <input type="hidden"  name="hdn_sales_um_no" id="hdn_sales_um_no"  value="${exp[8]}">
                    <input type="hidden"  name="hdn_sales_um_name" id="hdn_sales_um_name"  value="${exp[9]}">
                    <input type="hidden"  name="hdn_item_rate" id="hdn_item_rate"  value="${exp[10]}">
                    <input type="hidden"  name="hdn_lpp" id="hdn_lpp"  value="${exp[11]}">
                    <input type="hidden"  name="hdn_conversetion_qty" id="hdn_conversetion_qty"  value="${exp[12]}">
                    <input type="hidden"  name="hdn_lpqty" id="hdn_lpqty"  value="${exp[13]}">
                    <input type="hidden"  name="hdn_last_date" id="hdn_last_date"  value="${exp[14]}">
                    <input type="hidden"  name="vat" id="vat"  value="${exp[15]}">
                    <input type="hidden"  name="dollar" id="dollar"  value="${exp[16]}">
                    <input type="hidden"  name="dollar" id="currency_sign"  value="${exp[17]}">
                    <input type="hidden"  name="pr_doc_attachment_path" id="pr_doc_attachment_path"  value="${exp[18]}">


                    ${exp[1]}
                    </td>
                    <td class="item_qty"> ${exp[2]}</td>
                    </tr>`;
                $('#basket').append(basket_data);

            }
        } else {
            var basket_data =
                `<tr>

            <td class="text-left">
            <input type="hidden"  name="" id="hdn_item_no" class="item_no" value="${exp[0]}">
                <input type="hidden"  name="hdn_item_name" id="hdn_item_name"  value="${exp[1]}">
                <input type="hidden"  name="hdn_item_specification" id="hdn_item_specification"  value="${exp[19]}">
                <input type="hidden"  name="hdn_item_qty" id="hdn_item_qty"  value="${exp[2]}">
                <input type="hidden"  name="hdn_requisitiondtl_no" id="hdn_requisitiondtl_no"  value="${exp[3]}">
                <input type="hidden"  name="hdn_item_code" id="hdn_item_code"  value="${exp[5]}">
                <input type="hidden"  name="hdn_pur_um_no" id="hdn_pur_um_no"  value="${exp[6]}">
                <input type="hidden"  name="hdn_pur_um_name" id="hdn_pur_um_name"  value="${exp[7]}">
                <input type="hidden"  name="hdn_sales_um_no" id="hdn_sales_um_no"  value="${exp[8]}">
                <input type="hidden"  name="hdn_sales_um_name" id="hdn_sales_um_name"  value="${exp[9]}">
                <input type="hidden"  name="hdn_item_rate" id="hdn_item_rate"  value="${exp[10]}">
                <input type="hidden"  name="hdn_lpp" id="hdn_lpp"  value="${exp[11]}">
                <input type="hidden"  name="hdn_conversetion_qty" id="hdn_conversetion_qty"  value="${exp[12]}">
                <input type="hidden"  name="hdn_lpqty" id="hdn_lpqty"  value="${exp[13]}">
                <input type="hidden"  name="hdn_last_date" id="hdn_last_date"  value="${exp[14]}">
                <input type="hidden"  name="vat" id="vat"  value="${exp[15]}">
                <input type="hidden"  name="dollar" id="dollar"  value="${exp[16]}">
                <input type="hidden"  name="dollar" id="currency_sign"  value="${exp[17]}">
                <input type="hidden"  name="pr_doc_attachment_path" id="pr_doc_attachment_path"  value="${exp[18]}">
            ${exp[1]}
            </td>
            <td class="item_qty"> ${exp[2]}</td>
            </tr>`;
            $('#basket').append(basket_data);

        }
    }

    function setOnPoList(element) {
        var rows = '';
        var item_no = '';
        var item_name = '';
        var item_specification = '';
        var hdn_item_qty = '';
        var hdn_requisitiondtl_no = '';
        var hdn_item_code = '';
        var hdn_pur_um_no = '';
        var hdn_pur_um_name = '';
        var hdn_sales_um_no = '';
        var hdn_sales_um_name = '';
        var hdn_item_rate = '';
        var hdn_lpp = '';
        var hdn_conversetion_qty = '';
        var hdn_lpqty = '';
        var hdn_last_date = '';
        var amount = 0;
        var vat = 0;
        $('.item_no').each(function() {
            item_no = $(this).val();
            item_name = $(this).siblings('#hdn_item_name').val();
            item_specification = $(this).siblings('#hdn_item_specification').val();
            hdn_item_qty = $(this).siblings('#hdn_item_qty').val();
            hdn_requisitiondtl_no = $(this).siblings('#hdn_requisitiondtl_no').val();
            hdn_item_code = $(this).siblings('#hdn_item_code').val();
            hdn_pur_um_no = $(this).siblings('#hdn_pur_um_no').val();
            hdn_pur_um_name = $(this).siblings('#hdn_pur_um_name').val();
            hdn_sales_um_no = $(this).siblings('#hdn_sales_um_no').val();
            hdn_sales_um_name = $(this).siblings('#hdn_sales_um_name').val();
            hdn_item_rate = $(this).siblings('#hdn_item_rate').val();
            hdn_lpp = $(this).siblings('#hdn_lpp').val();
            hdn_conversetion_qty = $(this).siblings('#hdn_conversetion_qty').val();
            hdn_lpqty = $(this).siblings('#hdn_lpqty').val();
            hdn_last_date = $(this).siblings('#hdn_last_date').val();
            hdn_dollar_rate = $(this).siblings('#dollar').val();
            hdn_currency_sign = $(this).siblings('#currency_sign').val();
            pr_doc_attachment_path = $(this).siblings('#pr_doc_attachment_path').val();
            amount = hdn_item_rate * hdn_item_qty;
            vat += $(this).siblings('#vat').val() !="" ? parseFloat($(this).siblings('#vat').val()) :'';
            hdn_item_rate_dollar =0;
           if (hdn_dollar_rate !='' ) {
             hdn_item_rate_dollar =parseFloat(hdn_item_rate / hdn_dollar_rate).toFixed(3);
           }

            var duplicate_item = 0;
            $('.same-item-id').each(function() {
                var append_item_id = $(this).val();

                if (item_no == append_item_id) {
                    duplicate_item = 1;
                }
            });
            var item_rate_dollar='';
            var amount_dollar='';
            if (duplicate_item == 0) {

                if (hdn_dollar_rate !='' &&  hdn_currency_sign !='') {
                    item_rate_dollar='<input class="form-control item-rate text-right number_only " read-only onkeyup="setTotalPrice()"  type="hidden" name="item_rates[]" value="' +hdn_item_rate + '">'+hdn_item_rate_dollar+'<input type="hidden" name="dollar_rate[]" class="dollar_rate" value="' +
                    hdn_dollar_rate +
                    '"><input type="hidden" name="currency_sign[]" class="currency_sign" value="' +
                    hdn_currency_sign +
                    '"><input type="hidden" name="pr_doc_attachment_path[]" class="pr_doc_attachment_path" value="' +
                    pr_doc_attachment_path +
                    '">';

                    amount_dollar='<input class="form-control text-right number_only item_rate_amount valid" read-only="" min="0" type="hidden" name="item_rates_amount[]" value="' + amount + '" aria-invalid="false">'+ hdn_item_rate_dollar * hdn_item_qty;
                }else{
                    item_rate_dollar='<input class="form-control item-rate text-right number_only " read-only onkeyup="setTotalPrice()"  type="text" name="item_rates[]" value="' +hdn_item_rate + '">';

                    amount_dollar='<input class="form-control text-right number_only item_rate_amount valid" read-only="" min="0" type="text" name="item_rates_amount[]" value="' + amount + '" aria-invalid="false">'  ;
                }

                rows += '<tr>' +
                    '<td class="text-center sl-td">0</td>' +
                    '<td class="text-left"> <input type="hidden" name="item_id[]" value="' +
                    item_no +
                    '"><input type="hidden" name="indent_no[]" value="' + hdn_requisitiondtl_no + '">' + hdn_item_code + '</td>' +
                    '<td class="text-left"> <input type="hidden" class="same-item-id" name="item_ids[]" value="' +
                    item_no + '">' + item_name + '</td>'+'<td class="text-left"> <input type="text" class="form-control" name="item_specification[]" value="'+item_specification+'"  ></td>'+
                    '<td class="text-left"> <input type="hidden" name="item_uoms[]" value="' +
                    hdn_pur_um_no +
                    '">' + '<input type="text" class="form-control" name="hdn_pur_um_name[]" value="' + hdn_pur_um_name + '" readonly required>' + '</td>' +
                    '<td class="text-right"> '+item_rate_dollar+'</td>' +
                    '<td class="text-right"> <input class="form-control text-right number_only"  min="0" type="text" name="last_purchase_price[]" value="' +
                    hdn_lpp +
                    '"><input type="hidden" class="total_price" value=""><input type="hidden" name="sales_uom[]" class="sales_uom" value="' +
                    hdn_sales_um_name +
                    '"><input type="hidden" name="item_conversion[]" class="item_conversion" value="' +
                    hdn_conversetion_qty + '"></td>' +
                    '<td class="text-right"> <input class="form-control  text-right number_only" onkeyup="setTotalPrice()" min="0" type="text" name="last_purchase_qty[]" value="' +
                    hdn_lpqty +
                    '"></td>' +
                    '<td class="text-right"> <input class="form-control text-right "   type="text" name="last_purchase_date[]" value="' +
                    hdn_last_date + '"></td>' +
                    '<td class="text-right"> <input class="form-control item-qty text-right number_only" data-pr="PR" data-rate="' + hdn_item_qty + '" onkeyup="setTotalPrice()"  type="text" name="item_quantities[]" value="' + hdn_item_qty + '"><input type="hidden" name="sales_uom[]" class="sales_uom" value="' +
                    hdn_sales_um_no +
                    '"><input type="hidden" name="item_conversion[]" class="item_conversion" value=""></td>' + '<td class="text-right">'+amount_dollar+'</td>' +
                    '<td class="text-right d-none"> <input class="item_vat text-right number_only" id="item_vat" onkeyup="CalculatePerItemVat(this)" min="0" type="hidden" name="item_vat[]" value=""></td>' +
                    '<td class="text-right d-none"> <input class="vat_amount text-right number_only" id="vat_amount"  min="0" type="hidden" name="vat_amount[]" value=""></td>' +
                    '<td class="text-right d-none"> <input class="item_discount text-right number_only" id="item_discount" onkeyup="CalculatePerItemDiscount(this)" min="0" type="hidden" name="item_discount[]" value=""></td>' +
                    '<td class="text-right d-none"> <input class="discount_amount text-right number_only" id="dicount_amount"  min="0" type="hidden" name="discount_amount[]" value=""></td>' +
                    '<td> <a href="javascript:void(0)" class="btn btn-sm btn-danger remove-item-btn" title="Remove"><i class="fa fa-times-circle"></i></a></td>' +
                    '</tr>';

            }
        })


        $('#vat_percent').val(vat >0? vat / $('.item_no').length : 0);

        // $('#demand_items').html('');

        // $('.same-item-id').each(function(){
        //     var append_item_id=$(this).val();
        //     console.log(item_no , append_item_id)
        //     if (item_no != append_item_id) {

        //     }
        // })


        if ($('#demand_items').append(rows)) {
            $('#add_item_btn').attr('disabled','disabled');
        }

        $('.sl-td').each(function(index, elem) {
            $(elem).text(index + 1)
        })
        var indent_pr=$('#indent_pr_no').val();
        $('#indent_pr').val(indent_pr);
        setTotalPrice();
        $('#add_item_btn_enable').removeClass('d-none');
        $('#indent_purchase_order_entry_modal').modal('toggle');


    }

</script>
