@if (!empty($item_list))
    @foreach ($item_list as $record)
        <div class="col-md-3">
            <span class="badge badge-success badge-md" id="item_name" name="item_name" onclick="mostUsedItemData(this)"
                data-alt-id="{{ $record->item_no_fk }}" data-alt-name="{{ $record->brand_name }}"
                style="cursor: pointer;font-size: 10px;">{{ $record->brand_name }}
                {{-- <b style="color: #000;font-size:10px;"
                                                                >{{ !empty($record->supplier_name) ? '(' . $record->supplier_name . ')' : '' }}</b> --}}

            </span>

        </div>
    @endforeach
@endif
