<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">

                        </div>
                        <div class="col-md-2"></div>
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
                    <form action="{{ route('populate-default-items-from-last-purchase') }}" method="post"
                        id="last_purchase_order_items_form">
                        @csrf
                        <div class="row">

                            <div class="col-12 table-responsive mt-3" style="height: 350px; overflow-y: scroll"
                                id="crl">
                                <table class="table data-table table-striped table-bordered table-hover">
                                    <thead class="bg-primary">
                                        <tr>
                                            <th class="text-center width-50">SL</th>
                                            <th class="text-left">PO No</th>
                                            <th class="text-left">Date</th>
                                            <th class="text-center width-150">Number of Items</th>
                                            <th class="text-center width-150">Total Price</th>
                                            <th class="text-center width-50">Action</th>
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
    function calculatePrice(thisElement) {
        if ($("#demand_items tr").length > 0) {

            $("#demand_items tr").each(function() {
                var qty = $(this).find(".item-qty").val() * 1;
                var price = $(this).find(".item-rate").val() * 1;
                var total = qty * price;
                $(this).find(".total_price").val(total);

            });
        }
        poItemCalculateTotal1(thisElement)
    }

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
        $('#demand_items').html('');
        if (confirm("Are You Sure?")) {
            $.ajax({
                data: $("#last_purchase_order_items_form").serializeArray(),
                url: "{{ route('populate-default-items-from-last-purchase') }}",
                type: "POST",
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {
                    //console.log(data, data.length);

                    if (data.length > 0) {

                        data.forEach(function(iteminfo) {
                            let uom_name = iteminfo.uom_name != null ?
                                iteminfo.uom_name : "";
                            var total = iteminfo.entry_qty * iteminfo.pr_uom_tradeprice;
                           // console.log(iteminfo.pr_uom_tradeprice)
                            rows += '<tr>' +
                                '<td class="text-center sl-td">0</td>' +
                                '<td class="text-left"> <input type="hidden" name="ITEM_CODE[]" value="' +
                                iteminfo.item_code + '">' + iteminfo.item_code +
                                '</td>' +
                                '<td class="text-left"> <input type="hidden" class="same-item-id" name="item_ids[]" value="' +
                                iteminfo.item_no_fk + '">' + iteminfo.item_name +
                                '</td>' +
                                '<td class="text-left"> <input type="hidden" name="item_uoms[]" value="' +
                                iteminfo.uom + '">' + uom_name +
                                '</td>' +
                                '<td class="text-right"> <input class="item-rate number_only text-right" onkeyup="calculatePrice(this)" type="text" min="0"  name="item_rates[]" value="' +
                                iteminfo.pr_uom_tradeprice + '"></td>' +
                                '<td class="text-right"> <input class="item-qty number_only text-right" onkeyup="calculatePrice(this)" type="text" min="0" name="item_quantities[]" value="' +
                                iteminfo.entry_qty + '"></td>' +
                                '<td> <input type="hidden" class="total_price" value="' + total +
                                '">  <input type="hidden" name="sales_uom[]" name class="" value="' + iteminfo.uom_no_fk +
                                '">  <input type="hidden" name="item_conversion[]" name class="" value="' + iteminfo.pr_uom_conversion_qty +
                                '"><a href="javascript:void(0)" class="btn btn-sm btn-danger remove-item-btn" title="Remove"><i class="fa fa-times-circle"></i></a></td>' +
                                '</tr>'
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
</script>
