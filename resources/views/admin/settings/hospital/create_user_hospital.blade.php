@php

$hospital = (isset($data) && (!empty($data))) ? $data : [];

$id = ($hospital) ? $hospital->userhosp_no_pk : '';
$user_fullname= ($hospital) ? $hospital->user_fullname : '';
$hospital_no_fk = ($hospital) ? $hospital->hospital_no_fk : '';
$hospital_name = ($hospital) ? $hospital->hospital_name : '';
$status = ($hospital) ? $hospital->status : '';

@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
</head>

<body>

<form action="{{ route('user_hospital_store') }}" class='form' method="post" id="user_room_setup">
    @csrf
    <input type="hidden" name="id" value="{{$id}}">
    <label for="user">Hospital Name</label>
    <select name="hospital_name" id="hospital_name" class='form-control select2'>
        <option value="" selected="selected">Select Hospital</option>
        @if(!$hospitalName->isEmpty())
            @foreach($hospitalName as $value)
                <option
                    value="{{ $value->hospital_no_pk }}" {{$value->hospital_no_pk == $hospital_no_fk ? 'selected' : ''}} > {{ $value->hospital_name}} </option>
            @endforeach
        @endif


    </select>
    <div>
<label for="user">User Name</label>
    <input type="text" name="user_name" id="user_name" class='form-control' value="{{$user_fullname}}">
    <input type="hidden" name="user_hidn" id="user_hidn">

    </div>
     Status  &nbsp;
    <input type="checkbox" name="status" id="status" value="1" {{$status == 1 ? 'checked' : ''}} >
    <label for="status">  Active </label>
    <hr/>
    <div style="text-align:right; ">
        @php
            $response_action = route('user-hospital');
        @endphp
        <button class="btn btn-success btn-md"
                onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">
            Save Changes
        </button>
        <button type="button" data-dismiss="modal" class="btn btn-md btn-danger ">close</button>
        <button type="button" class="btn btn-md btn-info mr-auto " data-dismiss="modal">Exit</button>
    </div>
</form>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js')}}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
  openDoctorAutocomplete("#user_name", "user_hidn");
    $(document).ready(function () {
        $('.select2').select2({});
    });
    // function getRoom(value) {
    //     $.ajax({
    //         url: "{{route("room.get_room_data")}}",
    //         type: 'post',
    //         data: {
    //             id: value,
    //         },
    //         success: function (data) {
    //             // alert(data);  data:'_token = php echo csrf_token() ?>',
    //             $('#search_data').html(data);
    //         }, error: function () {
    //             alert('error');
    //         }
    //     });
    // }
</script>
</body>

</html>


