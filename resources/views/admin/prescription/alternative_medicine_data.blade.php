
@foreach ($item_list as $record)
    <div class="col-md-6">
        <span class="badge badge-success badge-md" id="item_name" name="item_name" onclick="setALternativeMed(this)"
            style="cursor: pointer;font-size: 10px;">{{ $record->item_name }} <b style="color: #000;font-size:10px;"
                data-id="{{ $data_row_id }}" data-alt-id="{{ $record->item_no_pk }}"
                data-alt-name="{{ $record->item_name }}">{{ !empty($record->supplier_name) ? '(' . $record->supplier_name . ')' : '' }}</b></span>

    </div>
@endforeach
