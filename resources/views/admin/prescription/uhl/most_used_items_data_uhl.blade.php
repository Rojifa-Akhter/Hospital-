<style>
    .badge-lg {
        font-size: 1.1rem;
        padding: 0.6em 1em;
        font-weight: 500;
        border-radius: 0.5rem;
        cursor: pointer;
    }
</style>

@if (!empty($item_list))
    @foreach ($item_list as $record)
        <div class="col-md-4 mb-3">
            <span class="badge badge-lg bg-success text-white rounded-pill"
                  onclick="mostUsedItemData(this)"
                  data-alt-id="{{ $record->item_no_fk }}"
                  data-alt-name="{{ $record->brand_name }}"
                  id="item_name_{{ $record->item_no_fk }}">
                {{ $record->brand_name }}
            </span>
        </div>
    @endforeach
@endif
