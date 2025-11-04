@php

    $schedule_dt = isset($schedule_dt) && !empty($schedule_dt) ? $schedule_dt : [];

    $room_shedsetup_no_pk = $schedule_dt ? $schedule_dt->room_shedsetup_no_pk : '';
    $item_no_fk = $schedule_dt ? $schedule_dt->item_no_fk : '';
    $su_no_fk = $schedule_dt ? $schedule_dt->su_no_fk : '';
    $room_no_fk = $schedule_dt ? $schedule_dt->room_no_fk : '';
    $start_time = $schedule_dt ? $schedule_dt->start_time : '';
    $end_time = $schedule_dt ? $schedule_dt->end_time : '';
    $avg_time = $schedule_dt ? $schedule_dt->avg_time : '';
    $status = $schedule_dt ? $schedule_dt->status : '';
    $pre_requisition = $schedule_dt ? $schedule_dt->pre_requisition : '';
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

    <form action="{{ route('radiology-item-wise-room.storeRadiologyitemWiseRoom') }}" class='form' method="post"
        id="user_room_setup">
        @csrf
        <input type="hidden" name="id" value="{{ $room_shedsetup_no_pk }}">
        <label for="item" class="col-form-label col-form-label-sm">Item Name</label>
        <select name="item" onchange="itemChecked(this)" id="item" class='form-control select2'>
            <option value="" selected="selected">Select Item</option>
            @if (!$items->isEmpty())
                @foreach ($items as $value)
                    <option value="{{ $value->item_no_pk }}" {{ $value->item_no_pk == $item_no_fk ? 'selected' : '' }}>
                        {{ $value->item_name }}</option>
                @endforeach
            @endif
        </select>

        <label for="department" class="col-form-label col-form-label-sm">Department <span
                class="text-danger">*</span></label>
        <select name="su_no_fk" id="department" class='form-control select2' required>
            <option value="" selected="selected">Select Department</option>
            @if (!$department_name->isEmpty())
                @foreach ($department_name as $value)
                    <option value="{{ $value->serviceunit_no_pk }}"
                        {{ $value->serviceunit_no_pk == $su_no_fk ? 'selected' : '' }}>
                        {{ $value->serviceunit_name }}
                    </option>
                @endforeach
            @endif
        </select>
        <label for="room" class="col-form-label col-form-label-sm">Room <span class="text-danger">*</span></label>
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

        <label for="duration" class="col-form-label col-form-label-sm">Duration(APPROXIMATELY) Time <span
                class="text-danger">*</span></label>
        <div class="">
            <input type="text" class="form-control form-control-sm number_only" id="duration" name="duration"
                value="{{ $avg_time }}" placeholder="Enter Duration Time" required>
        </div>

        <label for="avg_time" class="col-form-label col-form-label-sm">Average Time <span
                class="text-danger">*</span></label>
        <div class="">
            <input type="text" class="form-control form-control-sm number_only" id="avg_time" name="avg_time"
                value="{{ $avg_time }}" placeholder="Enter Average Time" required>
        </div>
        <label for="prerequisition" class="col-form-label col-form-label-sm">Pre Requisition<span
                class="text-danger">*</span></label>
        <div class="">
            <textarea name="prerequisition" id="prerequisition" class="form-control form-control-sm m-0 p-0 item_element mb-0"
                            cols="20" rows="5">{{ $pre_requisition }}</textarea>
        </div>


        <hr />
        <div style="text-align:right; ">
            @php
                $response_action = route('radiology-item-wise-room-schedule');
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

        function itemChecked(thisElement) {
            var item_id = $(thisElement).val();
            $("#department").prop('disabled', true); // Disable the department dropdown initially

            $.ajax({
                url: "{{ route('radiology.item_data_checked') }}",
                type: 'POST',
                data: {
                    item_id: item_id,
                    _token: "{{ csrf_token() }}"
                },
                success: function(data) {
                    console.log(data); // Log the data to the console
                    if (data.status == 'error') {
                        alert(data.message);
                        $("#department").val('').prop('disabled',
                            true); // Clear and disable the department field
                    } else {
                        // Check if dept is defined and is an array
                        if (Array.isArray(data.dept) && data.dept.length > 0) {
                            $("#department").empty(); // Clear existing options
                            $.each(data.dept, function(index, value) {
                                // Create and append options directly
                                $("#department").append($('<option>', {
                                    value: value.serviceunit_no_fk,
                                    text: value.serviceunit_name
                                }));
                            });
                            $("#department").prop('disabled', false); // Enable the department dropdown
                            getRoom(data.dept[0].serviceunit_no_fk); // Call getRoom with the first department
                        } else {
                            alert('No departments available');
                            $("#department").val('').prop('disabled',
                                true); // Clear and disable if no departments
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error: ', status, error);
                    alert('An error occurred.');
                    $("#department").val('').prop('disabled', true); // Clear and disable on error
                }
            });
        }
    </script>
</body>

</html>
