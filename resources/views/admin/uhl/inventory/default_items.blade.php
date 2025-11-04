<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="" id="search_default_items">
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
                    </form>
                    <input type="hidden" name="selected_supplier" id="selected_supplier"
                        value="{{ $selected_supplier }}">
                    <form action="{{ route('populate-default-items') }}" method="post" id="default_items_form">
                        @csrf                     
                        <div class="row">
                            
                            <div class="col-12 table-responsive mt-3" style="height: 350px; overflow-y: scroll"
                                id="default_item_table">
                                @include('admin.uhl.inventory.default_items_table')
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function setFormDefault(thisElement) {
        var rows = '';
        // $('#demand_items').html('');
        let item_id = [];
        let checked_item = [];
        let item_checkbox = $('.selected-default-item');
        Array.from(item_checkbox).map((element) => {
            
            if ($(element).prop('checked') == true) {
                item_id.push($(element).val());
                //checked_item = [$(element).val(),...item_id];
            }
        }); 

        console.log(item_id)
        if (confirm("Are You Sure?")) {
            $.ajax({
                data: {
                    item_no_pk: item_id
                },//$("#default_items_form").serializeArray(),
                url: "{{ route('v1.populate-default-items') }}",
                type: "POST",
                beforeSend: function() {
                    blockUI();
                },
                success: function(item) {
                    console.log(item);

                    if (item.length > 0) {

                        item.forEach(function(iteminfo) {
                            let uom_name = iteminfo.pr_uom_name != null ?
                                iteminfo.pr_uom_name : "";
                            var total = iteminfo.entry_qty * iteminfo.pr_uom_tradeprice;
                            var entry_qty = 0;
                            let lpd = iteminfo.lpd != null ?
                                iteminfo.lpd : "";

                                full_con_date='';
                                if (lpd !="") {
                                  var last_date=new Date(lpd);
                                  var conv_date =last_date.getDate();
                                  var conv_month =last_date.getMonth();
                                  var conv_year =last_date.getFullYear();
                                   full_con_date=conv_date+'/'+conv_month+'/'+conv_year;
                                }
                            var total = 0;
                          var item_rate=iteminfo.pr_uom_tradeprice !=null? iteminfo.pr_uom_tradeprice :0;

        var duplicate_item=0;
         $('.same-item-id').each(function(){
            var append_item_id=$(this).val();
            console.log(iteminfo.dutault_item_no , append_item_id)
            if (iteminfo.dutault_item_no == append_item_id) {
                duplicate_item =1;
                }
            });

            var l_qty=iteminfo.lpqty !=null ? iteminfo.lpqty :0;
            var l_price=iteminfo.lpp !=null ? iteminfo.lpp :0;
            if (duplicate_item == 0) {
                
          
                            //console.log(iteminfo.pr_uom_tradeprice)
                            rows += '<tr>' +
                                '<td class="text-center sl-td">0</td>' +
                                '<td class="text-left"> <input type="hidden" name="item_id[]" value="' +
                                iteminfo.dutault_item_no +
                                '"><input type="hidden" name="indent_no[]" value="">' + iteminfo.item_code + '</td>' +
                                '<td class="text-left"> <input type="hidden" class="same-item-id" name="item_ids[]" value="' +
                                iteminfo.dutault_item_no + '">' + iteminfo.item_name + '</td>' +'<td class="text-left"> <input type="text" class="form-control" name="item_specification[]" value=""  ></td>'+
                                '<td class="text-left"> <input type="hidden" name="item_uoms[]" value="' +
                                iteminfo.uom_no_fk +
                                '">' + '<input type="text" class="form-control" name="hdn_pur_um_name[]" value="'+uom_name+'" required readonly>'  + '</td>' +
                                '<td class="text-right"> <input class="form-control item-rate text-right number_only " read-only onkeyup="setTotalPrice()" min="0" type="text" name="item_rates[]" value="' +
                                item_rate + '"></td>' +
                                '<td class="text-right"> <input class="form-control text-right number_only"  min="0" type="text" name="last_purchase_price[]" value="' +
                                l_price +
                                '"><input type="hidden" class="total_price" value=""><input type="hidden" name="sales_uom[]" class="sales_uom" value="' +
                                iteminfo.uom +
                                '"><input type="hidden" name="item_conversion[]" class="item_conversion" value="' +
                                iteminfo.pr_uom_conversion_qty + '"></td>' +
                                '<td class="text-right"> <input class="form-control  text-right number_only" onkeyup="setTotalPrice()" min="0" type="text" name="last_purchase_qty[]" value="' +
                                l_qty +
                                '"></td>' +
                                '<td class="text-right"> <input class="form-control text-right "   type="text" name="last_purchase_date[]" value="' +
                                full_con_date + '"></td>' +
                                '<td class="text-right"> <input class="form-control item-qty text-right number_only" onkeyup="setTotalPrice()"  type="text" name="item_quantities[]" value=""><input type="hidden" name="sales_uom[]" class="sales_uom" value="' +
                                iteminfo.uom_no_fk +
                                '"><input type="hidden" name="item_conversion[]" class="item_conversion" value=""></td>'+'<td class="text-right"><input class="form-control text-right number_only item_rate_amount valid" read-only="" min="0" type="text" name="item_rates_amount[]" value="" aria-invalid="false"></td>' +
                                '<td class="text-right d-none"> <input class="item_vat text-right number_only" id="item_vat" onkeyup="CalculatePerItemVat(this)" min="0" type="hidden" name="item_vat[]" value=""></td>' +
                                '<td class="text-right d-none"> <input class="vat_amount text-right number_only" id="vat_amount"  min="0" type="hidden" name="vat_amount[]" value=""></td>' +
                                '<td class="text-right d-none"> <input class="item_discount text-right number_only" id="item_discount" onkeyup="CalculatePerItemDiscount(this)" min="0" type="hidden" name="item_discount[]" value=""></td>' +
                                '<td class="text-right d-none"> <input class="discount_amount text-right number_only" id="dicount_amount"  min="0" type="hidden" name="discount_amount[]" value=""></td>' +
                                '<td> <a href="javascript:void(0)" class="btn btn-sm btn-danger remove-item-btn" title="Remove"><i class="fa fa-times-circle"></i></a></td>' +
                                '</tr>';

                            }
                        })
                        $('#demand_items').append(rows)
                        // $('.sl-td').each(function(index, elem) {
                        //     $(elem).text(index + 1)
                        // })

                        $('.sl-td').each(function(index, elem) {
                            $(elem).text(index + 1)
                        })
                    } else {
                        alert('Sorry !!! No Data is found.')
                    }



                },
                complete: function() {

                },
                error: function(item) {
                    $.unblockUI();
                }
            }).done(function() {
                $.unblockUI();
            });
        }
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

    function setTotalPrice() {
        if ($("#demand_items tr").length > 0) {
            $("#demand_items tr").each(function() {
                var price = $(this).find(".item-rate").val() * 1;
                var qty = $(this).find(".item-qty").val() * 1;
                var total = price * qty;
                
                $(this).find(".total_price").val(parseFloat(total));
            });
        }
        calculateTotal();
    }
</script>
