@php

    $schedule_dt = isset($schedule_dt) && !empty($schedule_dt) ? $schedule_dt : [];
dd($schedule_dt);
    $room_shedsetup_no_pk = $schedule_dt ? $schedule_dt->room_shedsetup_no_pk : '';
    $person_no_fk = $schedule_dt ? $schedule_dt->person_no_fk : '';
    $su_no_fk = $schedule_dt ? $schedule_dt->su_no_fk : '';
    $room_no_fk = $schedule_dt ? $schedule_dt->room_no_fk : '';
    $start_time = $schedule_dt ? $schedule_dt->start_time : '';
    $end_time = $schedule_dt ? $schedule_dt->end_time : '';
    $avg_time = $schedule_dt ? $schedule_dt->avg_time : '';
    $status = $schedule_dt ? $schedule_dt->status : '';
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/timepicker/css/timepicker.css') }}">
</head>

<body>

    <form action="{{ route('radiology-user-wise-room.storeRadiologyUserWiseRoom') }}" class='form' method="post" id="user_room_setup">
        @csrf
        <input type="hidden" name="id" value="{{ $room_shedsetup_no_pk }}">
        <label for="user" class="col-form-label col-form-label-sm">User</label>
        <select name="user_no_fk" id="user" class='form-control select2'>
            <option value="" selected="selected">Select User</option>
            @if (!$user_name->isEmpty())
                @foreach ($user_name as $value)
                    <option value="{{ $value->person_no_fk }}" {{ $value->person_no_fk == $person_no_fk ? 'selected' : '' }}>
                        {{ $value->user_fullname }} ({{ $value->email }}) </option>
                @endforeach
            @endif
            {{-- {{ $value->user_no_pk == $person_no_fk ? 'selected' : '' }} --}}

        </select>
        <label for="department" class="col-form-label col-form-label-sm">Department <span
            class="text-danger">*</span></label>
        <select name="su_no_fk" id="department" class='form-control select2' onchange="getRoom(this.value)" required>
            <option value="" selected="selected">Select Department</option>
            @if (!$department_name->isEmpty())
                @foreach ($department_name as $value)
                    <option value="{{ $value->serviceunit_no_pk }}"
                        {{ $value->serviceunit_no_pk == $su_no_fk ? 'selected' : '' }}>{{ $value->serviceunit_name }}
                    </option>
                @endforeach
            @endif

        </select>
        <label for="room" class="col-form-label col-form-label-sm">Room <span
            class="text-danger">*</span></label>
        <div id="search_data">
            <select name="room_no_fk" id="room" class='form-control select2' required>
                <option value="" selected="selected">Select Room</option>

                {{-- @if (!$room_no->isEmpty()) --}}
                @foreach ($room_no as $value)
                    <option value="{{ $value->room_no_pk }}"
                        {{ $value->room_no_pk == $room_no_fk ? 'selected' : '' }}>{{ $value->room_name }}
                    </option>
                @endforeach
                {{-- @endif --}}
            </select>
        </div>

        <label for="start_time" class="col-form-label col-form-label-sm">Start Time <span
                class="text-danger">*</span></label>
        <div class="">
            <input type="text" class="form-control form-control-sm timepicker" id="start_time" name="start_time" value="{{$start_time}}"
                placeholder="Enter Start Time" required>
        </div>

        <label for="end_time" class="col-form-label col-form-label-sm">End Time <span
                class="text-danger">*</span></label>
        <div class="">
            <input type="text" class="form-control form-control-sm timepicker" id="end_time" name="end_time" value="{{$end_time}}"
                placeholder="Enter End Time" required>
        </div>

        <label for="avg_time" class="col-form-label col-form-label-sm">Average Time <span
                class="text-danger">*</span></label>
        <div class="">
            <input type="text" class="form-control form-control-sm number_only" id="avg_time" name="avg_time" value="{{$avg_time}}"
                placeholder="Enter Average Time" required>
        </div>


        <hr />
        <div style="text-align:right; ">
            @php
                $response_action = route('radiology-user-wise-room-schedule');
            @endphp
            <button type="button" class="btn btn-md btn-danger mr-auto " data-dismiss="modal">Exit</button>

            <button class="btn btn-success btn-md"
                onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">
                Save Changes
            </button>

        </div>
    </form>
    <script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js')}}"></script>
    <script type="application/javascript" src="{{ asset('asset/timepicker/js/timepicker.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({});

            $('body').on('focus', ".timepicker", function() {
                $(this).timepicker({
                    // showInputs: false,
                    // showMeridian: false,
                    // setTime: null

                });
            });
        });

        function getRoom(value) {
            $.ajax({
                url: "{{ route('room.get_room_data') }}",
                type: 'post',
                data: {
                    id: value,
                },
                success: function(data) {
                    // alert(data);  data:'_token = php echo csrf_token() ?>',
                    $('#search_data').html(data);
                },
                error: function() {
                    alert('error');
                }
            });
        }
    </script>
</body>

</html>
