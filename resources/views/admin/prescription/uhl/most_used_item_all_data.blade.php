@if (!empty($item_list))
    <div class="row">
        @foreach ($item_list as $record)
            @php
                $colClass = ($record->lookup_uid == 'ADVICE') ? 'col-md-6' : 'col-md-4';
            @endphp
            <div class="{{ $colClass }} mb-2">
                <span
                    class="badge rounded-pill bg-success text-white favourit_list_item"
                    id="item_name"
                    name="item_name"
                    data-item-name="{{ $record->prescrition_data }}"
                    data-alt-id="{{ $record->lookupdata_item_no_fk }}"
                    data-alt-name="{{ $record->prescrition_data }}"
                    data-id-value="{{ $record->lookupdata_item_no_fk }}"
                    data-lookup-code="{{ $record->lookup_uid }}"
                    data-lookup-id="121"
                    data-lookup-data-code="{{ $record->lookupdata_uid }}"
                    onclick="prescriptionFunc.addItemsDataMostUseUhl(this)"
                    style="cursor: pointer; font-size: 0.9rem; padding: 0.5em 0.75em;"
                >
                    {{ $record->prescrition_data }}
                </span>
            </div>
        @endforeach
    </div>
@endif
