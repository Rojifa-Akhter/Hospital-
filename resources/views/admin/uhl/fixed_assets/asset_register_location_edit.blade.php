
    <select class="form-control form-control-sm select2" id="asset_location" name="asset_location" disabled>
        <option value="">Select Location</option>
        @if (!empty($location))
            @foreach ($location as $value)
                <option value="{{ $value->room_no_pk }}"
                    {{ $asset_register_data->curr_room_no_fk == $value->room_no_pk ? 'selected' : '' }}>
                    {{ $value->room_name }}</option>
            @endforeach
        @endif
    </select>
