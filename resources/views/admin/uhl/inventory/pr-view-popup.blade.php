<div class="col-12 table-responsive mt-3" style="height: 600px; overflow-y: scroll" id="default_item_table">
    <table class="table data-table table-striped table-bordered table-hover">
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
                {{-- <th class="text-center width-50">Action</th> --}}
            </tr>
        </thead>
        <tbody>

            @if (!empty($items))

                @foreach ($items as $item)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-left ">

                            {{$item->req_at !="" ? date('d/m/Y',strtotime($item->req_at)) :''}}
                            <input id="item_id_{{ $loop->iteration }}" type="hidden" value="{{ $item->req_item_no_fk }}">
                            <input id="item_name_{{ $loop->iteration }}" type="hidden" value="{{ $item->item_name }}">
                        </td>
                        <td class="text-center">{{ $item->req_item_no_fk ? $item->req_item_no_fk : 0 }}</td>
                        <td class="text-left">{{ $item->item_name ? $item->item_name : '' }}</td>
                        <!-- <td class="text-center">{{ $item->supp_name ? $item->supp_name : 0 }}</td> -->
                        <td class="text-center">
                            {{ $item->indent_req_by_name ? $item->indent_req_by_name : '' }}
                            {{ $item->indent_from_store ? $item->indent_from_store : ''}}

                        </td><td class="text-center">
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
                        {{-- <td class="text-center">
                            @php
                                $rate=$item->lpp !=null ? $item->lpp: $item->item_purchase_price;
                                $last_date=$item->lpd !="" ? date('Y-m-d',strtotime($item->lpd)):'';
                            @endphp

                            <input type="checkbox" data-iteration="{{ $loop->iteration }}" class="item_check"
                                name="item_no_pk[]" value="{{ $item->req_item_no_fk.'_'.$item->item_name.'_'.$item->req_quantity.'_'.$item->inv_requisition_po_no_pk.'_'.$item->inv_requisitiondtl_no_pk.'_'.$item->item_code.'_'.$item->pr_uom_no_fk.'_'.$item->item_pur_uom_name.'_'.$item->uom_no_fk.'_'.$item->sales_uom.'_'.$rate.'_'.$item->lpp.'_'.$item->pr_uom_conversion_qty.'_'.$item->lpqty.'_'.$last_date.'_'.$item->vat_percent.'_'.$item->dollar_rate.'_'.$item->currency_sign.'_'.$item->pr_doc_attachment_path.'_'.$item->item_remarks.'_'.$item->requisitiondtl_no_pk_list.'_'.$item->inv_requisitiondtl_po_no_pk}}"  onchange="selectedItem(this)">
                        </td> --}}
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
