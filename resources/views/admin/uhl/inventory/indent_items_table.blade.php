<table class="table data-table table-striped table-bordered table-hover" id="requisition_item">
    <thead class="global-uhl-table-bg">
        <tr>
            <th class="text-center width-50">SL</th>
            <th class="text-left">Indent Date</th>
            <th class="text-center width-150">Item No</th>
            <th class="text-left">Name</th>
            <!-- <th class="text-left">Supplier</th> -->
            <th class="text-left ">Indent By Name & Department</th>
            <th class="text-center width-150">Indent No</th>
            <th class="text-left ">P.R By Name & Department</th>
            <th class="text-center width-150">P.R No</th>
            <th class="text-center width-150">Indent Qty</th>
            <th class="text-center width-50">Action
                <input type="checkbox" id="PathselectAll" />
            </th>
        </tr>
    </thead>
    <tbody>
        @if (!empty($items))

            @foreach ($items as $item)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-left ">

                        {{ $item->req_at != '' ? date('d/m/Y', strtotime($item->req_at)) : '' }}
                        <input id="item_id_{{ $loop->iteration }}" type="hidden" value="{{ $item->req_item_no_fk }}">
                        <input id="item_name_{{ $loop->iteration }}" type="hidden" value="{{ $item->item_name }}">
                    </td>
                    <td class="text-center">{{ $item->req_item_no_fk ? $item->req_item_no_fk : 0 }}</td>
                    <td class="text-left">{{ $item->item_name ? $item->item_name : '' }}</td>
                    <!-- <td class="text-center">{{ $item->supp_name ? $item->supp_name : 0 }}</td> -->
                    <td class="text-center">
                        {{ $item->indent_req_by_name ? $item->indent_req_by_name : '' }}
                        {{ $item->indent_from_store ? $item->indent_from_store : '' }}

                    </td>
                    <td class="text-center">
                        {{ $item->inv_requisition_no_pk ? $item->inv_requisition_no_pk : '' }}

                    </td>
                    <td class="text-center">
                        {{ $item->req_by_name ? $item->req_by_name : '' }}
                        {{ $item->from_store ? $item->from_store : '' }}

                    </td>
                    <td class="text-center">
                        {{ $item->inv_requisition_po_no_pk ? $item->inv_requisition_po_no_pk : '' }}

                    </td>
                    <input id="qty_{{ $loop->iteration }}" type="hidden" value="0">
                    <td class="text-center">
                        {{ $item->req_quantity ? $item->req_quantity : 0 }}

                    </td>
                    <td class="text-center">
                        @php
                            $rate = $item->lpp != null ? $item->lpp : $item->item_purchase_price;
                            $last_date = $item->lpd != '' ? date('Y-m-d', strtotime($item->lpd)) : '';
                        @endphp

                        <input type="checkbox" data-iteration="{{ $loop->iteration }}" class="item_check"
                            name="item_no_pk[]"
                            value="{{ $item->req_item_no_fk . '_' . $item->item_name . '_' . $item->req_quantity . '_' . $item->inv_requisition_po_no_pk . '_' . $item->inv_requisitiondtl_no_pk . '_' . $item->item_code . '_' . $item->pr_uom_no_fk . '_' . $item->item_pur_uom_name . '_' . $item->uom_no_fk . '_' . $item->sales_uom . '_' . $rate . '_' . $item->lpp . '_' . $item->pr_uom_conversion_qty . '_' . $item->lpqty . '_' . $last_date . '_' . $item->vat_percent . '_' . $item->dollar_rate . '_' . $item->currency_sign . '_' . $item->pr_doc_attachment_path . '_' . $item->item_remarks . '_' . $item->requisitiondtl_no_pk_list . '_' . $item->inv_requisitiondtl_po_no_pk }}"
                            onchange="selectedItem(this)">
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
<script>
    $(document).ready(function() {
        // var numberCount = 0;
        $('#PathselectAll').on('change', function() {

            var isChecked = $(this).prop('checked');
            $('.item_check').prop('checked', isChecked);
            if ($('#PathselectAll').is(':checked')) {

                // $('#basket').empty();
                let original_item_check_val = [];
                var serial_no = 0;
                $('.item_check:checked').each(function() {
                    var $row = $(this).closest('tr');
                    var value = $row.find('.item_check').val();
                    original_item_check_val.push(value);
                });
                let item_check_val = [];
                $.each(original_item_check_val, function(index, value) {

                    if ($.inArray(value, item_check_val) === -1) {
                        item_check_val.push(value);
                    }
                });
                item_check_val.map(function(data) {
                    var item_info = data;
                    var exp = item_info.split('_');

                    indent_dtl.push(exp[0] + '_' + exp[20] + '_' + exp[21])
                    numberCount++;
                    $('#basket_item_no').text(numberCount);
                    $('#indent_pr_no').val(indent_dtl);
                    if ($('#basket tr').length >= 1) {
                        var current_item_id = exp[0];
                        var current_qty = parseFloat(exp[2]);
                        var item_id = '';
                        var duplicate_item = 0;
                        $('.item_no').each(function() {
                            item_id = $(this).val();

                            if (current_item_id == item_id) {
                                duplicate_item = 1;
                                var entry_current_qty = parseFloat($(this).parents('td')
                                    .parents('tr').find('.item_qty').html());

                                $(this).parents('td').parents('tr').find('.item_qty')
                                    .html(entry_current_qty + current_qty);
                                $(this).parents('td').parents('tr').find(
                                    '#hdn_item_qty').val(entry_current_qty +
                                    current_qty);
                                $(this).parents('td').parents('tr').find(
                                    '#hdn_item_specification').val('');

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
                });

            } else {
                $('.item_check').prop('checked', false);
                $('#basket').empty();
                item_check_val = [];
                numberCount = 0;
                $('#basket_item_no').text(0)
            }
        });
    });

    $('.item_check').on('change', function() {
        var allChecked = $('.item_check:checked').length === $('.item_check').length;
        $('#PathselectAll').prop('checked', allChecked);
    });
</script>
