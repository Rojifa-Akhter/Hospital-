

<select class="form-control form-control-sm select2" id="asset_location" name="asset_location" required>
    <option value="">Select Location</option>
    @if (!empty($location))
        @foreach ($location as $value)
            <option value="{{ $value->room_no_pk }}">{{ $value->room_name }}</option>
        @endforeach
    @endif
</select>
