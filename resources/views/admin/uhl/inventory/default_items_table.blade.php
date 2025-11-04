<table class="table data-table table-striped table-bordered table-hover">
    <thead class="bg-primary">
        <tr>
            <th class="text-center width-50">SL</th>
            <th class="text-left">Item Name</th>
            <th class="text-center width-150">Rate</th>
            <th class="text-center width-150">Stock</th>
            <th class="text-center width-150">Re-Order Level</th>
            <th class="text-center width-50">Action</th>
        </tr>
    </thead>
    <tbody>

        @if (!empty($items))
            @foreach ($items as $item)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-left ">
                        {{ $item->item_name }}
                        <input id="item_id_{{ $loop->iteration }}" type="hidden" value="{{ $item->item_no_pk }}">
                        <input id="item_name_{{ $loop->iteration }}" type="hidden" value="{{ $item->item_name }}">
                    </td>


                    <td class="text-center">
                        {{ $item->pr_uom_tradeprice ? $item->pr_uom_tradeprice : 0 }}
                        <input id="rate_{{ $loop->iteration }}" type="hidden"
                            value="{{ $item->pr_uom_tradeprice ? $item->pr_uom_tradeprice : 0 }}">
                    </td>
                    <td class="text-center">
                        {{ $item->current_stock ? $item->current_stock : 0 }}
                        <input id="rate_{{ $loop->iteration }}" type="hidden"
                            value="{{ $item->current_stock ? $item->current_stock : 0 }}">
                    </td>
                    <input id="qty_{{ $loop->iteration }}" type="hidden" value="0">
                    <td class="text-center">
                        {{ $item->re_order_level ? $item->re_order_level : 0 }}

                    </td>
                    <td class="text-center">
                        <input data-iteration="{{ $loop->iteration }}" class="selected-default-item"
                            name="item_no_pk[]" value="{{ $item->item_no_pk }}" type="checkbox">
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>

