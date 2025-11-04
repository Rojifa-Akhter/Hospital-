@if (!empty($item_list))
    @foreach ($item_list as $record)
        @if ($record->lookup_uid == 'ADVICE')
            <div class="col-md-6" style="max-width: 90%;overflow:hidden;">
            @else
                <div class="col-md-4" style="max-width: 90%;overflow:hidden;">
        @endif

        <span class="badge badge-success badge-md favourit_list_item" id="item_name"
            data-item-name="{{ $record->prescrition_data }}" name="item_name"
            data-alt-id="{{ $record->lookupdata_item_no_fk }}" data-alt-name="{{ $record->prescrition_data }}"
            style="cursor: pointer;font-size: 10px;" data-id-value="{{ $record->lookupdata_item_no_fk }}"
            data-lookup-code="{{ $record->lookup_uid }}" data-lookup-id="121"
            data-lookup-data-code="{{ $record->lookupdata_uid }}"
            onclick="prescriptionFunc.addItemsDataMostUseUhl(this)">{{ $record->prescrition_data }}
        </span>


        </div>
    @endforeach
@endif
