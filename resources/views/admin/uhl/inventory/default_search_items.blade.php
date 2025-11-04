<table class="table data-table table-striped table-bordered table-hover">
    <thead class="bg-primary">
        <tr>
            <th class="text-center width-50">SL</th>
            <th class="text-left">Item Name</th>
            <th class="text-center">UOM</th>
            <th class="text-center width-150">Rate</th>
            <th class="text-center width-150">Item Quantity</th>
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
                        <input id="item_id_{{ $loop->iteration }}" type="hidden" value="{{ $item->item_no_fk }}">
                        <input id="item_name_{{ $loop->iteration }}" type="hidden" value="{{ $item->item_name }}">
                    </td>
                    <td class="text-center">
                        {{ $item->uom_name }}
                        <input id="uom_no_{{ $loop->iteration }}" type="hidden" value="{{ $item->uom }}">
                        <input id="uom_name_{{ $loop->iteration }}" type="hidden" value="{{ $item->uom_name }}">
                    </td>
                    <td class="text-center">
                        {{ $item->default_rate ?: 0 }}
                        <input id="rate_{{ $loop->iteration }}" type="hidden" value="{{ $item->default_rate ?: 0 }}">
                    </td>
                    <td class="text-center">
                        {{ $item->default_qty ?: 0 }}
                        <input id="qty_{{ $loop->iteration }}" type="hidden" value="{{ $item->default_qty ?: 0 }}">
                    </td>
                    <td class="text-center">
                        <input data-iteration="{{ $loop->iteration }}" class="selected-default-item" type="checkbox">
                    </td>
                </tr>
            @endforeach
        @endif
        {{-- <tr>
        <td class="text-center">444</td>
        <td class="text-center">fgfg</td>
        <td class="text-center">23120152</td>
        <td class="text-left">gdfg</td>
        <td class="text-center">dgf</td>
        <td class="text-center">300</td>
        <td class="text-center">500</td>
        <td class="text-center">
            <input type="checkbox" name="" value="">
        </td>
    </tr> --}}
    </tbody>
</table>
