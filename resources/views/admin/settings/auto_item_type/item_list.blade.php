<select class="form-control font_size_12 m-auto select2" id="" name="parent_item_name" required>
    <option selected="selected" value="">Select Item Name</option>
    @foreach ($items as $item)
        <option value="{{ $item->item_no_pk }}" {{ $item_no_fk == $item->item_no_pk ? 'selected' : '' }}>
            {{ $item->item_name }} </strong>
        </option>
    @endforeach
</select>
