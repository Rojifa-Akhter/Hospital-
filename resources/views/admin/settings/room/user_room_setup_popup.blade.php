@php
    $roomSetup = (isset($roomSetup) && (!empty($roomSetup))) ? $roomSetup : [];


    $id = ($roomSetup) ? $roomSetup->lookupmap_no_pk : '';
    $user_no_fk = ($roomSetup) ? $roomSetup->user_no_fk : '';
    $su_no_fk = ($roomSetup) ? $roomSetup->su_no_fk : '';
    $room_no_fk = ($roomSetup) ? $roomSetup->room_no_fk : '';

@endphp
    <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css')}}">
</head>

<body>

<form action="{{ route('room.store-user-room') }}" class='form' method="post" id="user_room_setup">
    @csrf
    <input type="hidden" name="id" value="{{$id}}">
    <label for="user">User</label>
    <select name="user_no_fk" id="user" class='form-control select2'>
        <option value="" selected="selected">Select User</option>
        @if(!$user_name->isEmpty())
            @foreach($user_name as $value)
                <option
                    value="{{ $value->user_no_pk }}" {{$value->user_no_pk == $user_no_fk ? 'selected' : '' }}> {{ $value->user_fullname}} </option>
            @endforeach
        @endif


    </select>
    <label for="department">Department</label>
    <select name="su_no_fk" id="department" class='form-control select2' onchange="getRoom(this.value)">
        <option value="" selected="selected">Select Department</option>
        @if(!$department_name->isEmpty())
            @foreach($department_name as $value)
                <option value="{{ $value->serviceunit_no_pk }}" {{$value->serviceunit_no_pk == $su_no_fk ? 'selected' : '' }}>{{
                    $value->serviceunit_name}}
                </option>
            @endforeach
        @endif

    </select>
    <label for="room">Room</label>
    <div id="search_data">
        <select name="room_no_fk" id="room" class='form-control select2'>
            <option value="" selected="selected">Select Room</option>

            @if(!$room_no->isEmpty())
                @foreach($room_no as $value)
                    <option value="{{ $value->room_no_pk }}" {{$value->room_no_pk == $room_no_fk ? 'selected' : '' }}>{{
                        $value->room_name}}
                    </option>
                @endforeach
            @endif
        </select>
    </div>
    <hr/>
    <div style="text-align:right; ">
        @php
            $response_action = route('room.user-room-setup');
        @endphp
        <button type="button" class="btn btn-md btn-danger mr-auto " data-dismiss="modal">Exit</button>

        <button class="btn btn-success btn-md"
                onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">
            Save Changes
        </button>

    </div>
</form>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js')}}"></script>
<script>
    $(document).ready(function () {
        $('.select2').select2({});
    });
    function getRoom(value) {
        $.ajax({
            url: "{{route("room.get_room_data")}}",
            type: 'post',
            data: {
                id: value,
            },
            success: function (data) {
                // alert(data);  data:'_token = php echo csrf_token() ?>',
                $('#search_data').html(data);
            }, error: function () {
                alert('error');
            }
        });
    }
</script>
</body>

</html>
