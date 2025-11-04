<select class="form-control form-control-sm select2" id="item_name" name="item_name">
    <option value="">Select Item</option>
    @if (!empty($items))
        @foreach ($items as $rd)
            <option value="{{ $rd->item_no_pk }}">{{ $rd->item_name }}</option>
        @endforeach
    @endif
</select>
