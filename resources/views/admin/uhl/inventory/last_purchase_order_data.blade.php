<div class="container-fluid">
    <div class="form-row">
        <div class="col-12">
            <div class="card mt-0">
                <div class="card-body p-0">

                    <form action="{{ route('populate-default-items-from-last-purchase') }}" method="post"
                        id="last_purchase_order_items_form">
                        @csrf
                        <div class="form-row">

                            <div class="col-12 table-responsive" style="height: 350px; overflow-y: scroll"
                                id="crl">
                                <table class="table data-table table-striped table-bordered table-hover">
                                    <thead class="global-uhl-table-bg">
                                        <tr>
                                            <th class="text-center width-50">SL</th>
                                            <th class="text-left">PO No</th>
                                            <th class="text-left">Date</th>
                                            <th class="text-center width-150">Number of Items</th>
                                            <th class="text-center width-150">Total Price</th>
                                            <th class="text-center width-50">Action <input type="checkbox"
                                                    id="checked_all" name="checked_all"></th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @if (!empty($supplier_purchase_order))
                                            @foreach ($supplier_purchase_order as $po)
                                                <tr>
                                                    <td class="text-center">{{ $loop->iteration }}</td>
                                                    <td class="text-left ">
                                                        {{ $po->purchase_uid }}

                                                    </td>

                                                    <td class="text-left ">

                                                        {{ date('d/m/Y', strtotime($po->purchase_date)) }}

                                                    </td>

                                                    <td class="text-center">
                                                        {{ $po->total_qty ? $po->total_qty : 0 }}
                                                    </td>
                                                    <td class="text-center">
                                                        {{ $po->total_amount ? $po->total_amount : 0 }}

                                                    </td>

                                                    <td class="text-center">
                                                        <input class="selected-default-item purchase_order"
                                                            name="purchase_order[]"
                                                            value="{{ $po->purchaseorder_no_pk }}" type="checkbox">
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
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
    // function calculatePrice(thisElement) {
    //     if ($("#demand_items tr").length > 0) {

    //         $("#demand_items tr").each(function() {
    //             var qty = $(this).find(".item-qty").val() * 1;
    //             var price = $(this).find(".item-rate").val() * 1;
    //             var total = qty * price;
    //             $(this).find(".total_price").val(total);

    //         });
    //     }
    //     poItemCalculateTotal1(thisElement)
    // }

    function poItemCalculateTotal1(thisElement) {
        var item_total = 0;
        if ($("#demand_items tr").length == 0) {
            alert("Please add one item");
            return;
        } else {
            $("#demand_items tr").each(function() {
                item_total += $(this).find(".total_price").val() * 1;
            });
        }
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

        console.log(discount_percent, total_discount_amount, "Anik");

        var item_total = 0;
        var delivery_status = 0;
        var urgent_fee = 0;
        var final_total = 0;
        // var urgent_fee = urgent_fee_total;

        if ($("#demand_items tr").length > 0) {
            $("#demand_items tr").each(function() {
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

                    $("#vat_percent").val(total_vat_amount.toFixed(2));

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

                    $("#discount_percent").val(total_discount_amount.toFixed(2));

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

    function setFormLastPurchase(thisElement) {
        var rows = '';
        // $('#demand_items').html('');
        if (confirm("Are You Sure?")) {
            $.ajax({
                data: $("#last_purchase_order_items_form").serializeArray(),
                url: "{{ route('v1.populate-default-items-from-last-purchase') }}",
                type: "POST",
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {
                    console.log(data.data, data.data.length);
                    
                    if (data.data.length > 0) {
                        console.log(data);
                        data.data.forEach(function(iteminfo) {
                            let uom_name = iteminfo.uom_name != null ?
                                iteminfo.uom_name : "";

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
                                var last_qty= iteminfo.lpqty !=null ?  iteminfo.lpqty: 0;
                                var last_pp=  iteminfo.lpp !=null ?   iteminfo.lpp: 0;
                            var total = 0;


            var duplicate_item=0;
         $('.same-item-id').each(function(){
            var append_item_id=$(this).val();
            console.log(iteminfo.req_item_no_fk , append_item_id)
            if (iteminfo.req_item_no_fk == append_item_id) {
                duplicate_item =1;
                }
            });

            if (duplicate_item == 0) {
                            // console.log(iteminfo.pr_uom_tradeprice)
                            rows += '<tr>' +
                                '<td class="text-center sl-td">0</td>' +
                                '<td class="text-left"> <input type="hidden" name="item_id[]" value="' +
                                iteminfo.req_item_no_fk +
                                '"><input type="hidden" name="indent_no[]" value="">' + iteminfo.item_code + '</td>' +
                                '<td class="text-left"> <input type="hidden" class="same-item-id" name="item_ids[]" value="' +
                                iteminfo.req_item_no_fk + '">' + iteminfo.item_name + '</td>'+'<td class="text-left"> <input type="text" class="form-control" name="item_specification[]" value=""  ></td>' +
                                '<td class="text-left"> <input type="hidden" name="item_uoms[]" value="' +
                                iteminfo.uom_no_fk +
                                '">' +'<input type="text" class="form-control" name="hdn_pur_um_name[]" value="'+uom_name+'" readonly required>'  + '</td>' +
                                '<td class="text-right"> <input class="form-control item-rate text-right number_only " read-only onkeyup="setTotalPrice()" min="0" type="text" name="item_rates[]" value="' +
                                iteminfo.pr_uom_tradeprice + '"></td>' +
                                '<td class="text-right"> <input class="form-control text-right number_only"  min="0" type="text" name="last_purchase_price[]" value="' +
                                last_pp +
                                '"><input type="hidden" class="total_price" value=""><input type="hidden" name="sales_uom[]" class="sales_uom" value="' +
                                iteminfo.uom_no_fk +
                                '"><input type="hidden" name="item_conversion[]" class="item_conversion" value="' +
                                iteminfo.pr_uom_conversion_qty + '"></td>' +
                                '<td class="text-right"> <input class="form-control  text-right number_only" onkeyup="setTotalPrice()" min="0" type="text" name="last_purchase_qty[]" value="' +
                                last_qty +
                                '"></td>' +
                                '<td class="text-right"> <input class="form-control text-right " onkeyup="setTotalPrice()"  type="text" name="last_purchase_date[]" value="' +
                                full_con_date + '"></td>' +
                                '<td class="text-right"> <input class="form-control item-qty text-right number_only" onkeyup="setTotalPrice()" min="0" type="text" name="item_quantities[]" value=""><input type="hidden" name="sales_uom[]" class="sales_uom" value="' +
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
                        $('.sl-td').each(function(index, elem) {
                            $(elem).text(index + 1)
                        })
                    } else {
                        alert('Sorry !!! No Data is found.')
                    }



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


    }

    function setTotalPrice() {
        if ($("#demand_items tr").length > 0) {
            $("#demand_items tr").each(function() {
                var price = $(this).find(".item-rate").val() * 1;
                var qty = $(this).find(".item-qty").val() * 1;
                var total = price * qty;
                console.log(total,'cahnge ');
                $(this).find(".total_price").val(parseFloat(total));
            });
        }
        calculateTotal();
    }
</script>
