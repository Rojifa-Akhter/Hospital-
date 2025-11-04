<option value="">Select Room</option>
@if (!empty($room_number))
    @foreach ($room_number as $room)
        <option value="{{ $room->room_no_pk }}">
            {{ $room->room_name }}</option>
    @endforeach
@endif
