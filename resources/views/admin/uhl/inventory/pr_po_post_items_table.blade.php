
<table class="table data-table table-striped table-bordered table-hover ">
    <thead class="global-uhl-table-bg">
        <tr>
            <th class="text-center width-50">SL</th>
            <th class="text-left">Indent Date</th>
            <th class="text-left ">By Name & Department</th>
            <th class="text-center width-150">Indent No</th>
            <th class="text-center width-150">Indent Dtl. No</th>
            <th class="text-center width-150">Item No</th>
            <th class="text-left">Name</th>
            <th class="text-center width-150">Indent Qty</th>
            <th class="text-center width-50">Status</th>
        </tr>
    </thead>
    <tbody id="item_details">
        @if (!empty($items))
            @foreach ($items as $item)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-left ">
                        {{ $item->item_name }} <br>
                        {{date('d/m/Y',strtotime($item->req_at))}}
                        <input id="item_id_{{ $loop->iteration }}" type="hidden" value="{{ $item->req_item_no_fk }}">
                        <input id="item_name_{{ $loop->iteration }}" type="hidden" value="{{ $item->item_name }}">
                    </td>


                    <td class="text-left">
                        {{ $item->req_by_name ? $item->req_by_name : 0 }} <br>
                        {{ $item->from_store ? $item->from_store : 0 }}
                     
                    </td>
                    <td class="text-center">
                        {{ $item->inv_requisition_po_no_pk ? $item->inv_requisition_po_no_pk : '' }}
                      
                    </td>
                    <td class="text-center">
                        {{ $item->inv_requisitiondtl_no_pk ? $item->inv_requisitiondtl_no_pk : '' }}
                      
                    </td>
                    <input id="qty_{{ $loop->iteration }}" type="hidden" value="0">
                    <td class="text-center">
                        {{ $item->req_item_no_fk ? $item->req_item_no_fk : 0 }}

                    </td>
                    <td class="text-left">
                        {{ $item->item_name ? $item->item_name : 0 }}

                    </td>
                    <td class="text-center">
                        {{ $item->req_quantity ? $item->req_quantity : 0 }}

                    </td>
                    <td class="text-center">
                        {{ $item->req_po_save_option ? $item->req_po_save_option : 0 }}

                    </td>
                    <!-- <td class="text-center">
                        @php
                            $rate=$item->lpp !=null ? $item->lpp: $item->item_purchase_price;
                            $last_date=$item->lpd !="" ? date('Y-m-d',strtotime($item->lpd)):'';
                        @endphp
                        <input data-iteration="{{ $loop->iteration }}" class="selected-default-item"
                            name="item_no_pk[]" value="{{ $item->req_item_no_fk.'_'.$item->item_name.'_'.$item->req_quantity.'_'.$item->inv_requisition_po_no_pk.'_'.$item->inv_requisitiondtl_no_pk.'_'.$item->item_code.'_'.$item->req_uom.'_'.$item->req_uom_name.'_'.$item->uom_no_fk.'_'.$item->sales_uom.'_'.$rate.'_'.$item->lpp.'_'.$item->pr_uom_conversion_qty.'_'.$item->lpqty.'_'.$last_date }}" type="checkbox" onchange="selectedItem(this)">
                    </td> -->
                </tr>
            @endforeach
        @endif
    </tbody>
</table>


