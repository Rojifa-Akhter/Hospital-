@if(!empty($asset_register_data_arr) )
@foreach($asset_register_data_arr as $value)
<tr>
    <td>{{$loop->iteration}}</td>
    {{-- <td>{{$value->asset_tag_uid}}</td> --}}
    <td>
        @php
        $head=$value->ity_group_header_name !="" ? '/'.$value->ity_group_header_name :"";
        $department=$value->item_serviceunit_code !="" ? '/'.$value->item_serviceunit_code :"";
        @endphp
        {{-- {{ $value->asset_tag_uid }} --}}
        {{Session::get('user.ses_hospital_code'). $head.$department.'/'. $value->asset_tag_uid }}
    </td>
    <td>{{$value->ast_trans_req_date !="" ? date('d/m/Y',strtotime($value->ast_trans_req_date)) : ''}}</td>
    <td>
        <?php
            $currentDateTime = date('Y-m-d H:i:s');
            $currentDateTime = new DateTime($currentDateTime);
            $grndatetime = new DateTime($value->grn_date);
            $interval = $currentDateTime->diff($grndatetime);
            $years = $interval->y;
            $months = $interval->m;
            $days = $interval->d;
        ?>
        {{ $days . "D " . $months. "M " . $years. "Y"}}
    </td>
    <td>{{$value->item_code}}</td>
    <td>{{$value->item_name}}</td>
    {{-- <td>N/A</td> --}}
    {{-- <td>{{$value->assetcat_name}}</td>
    <td>{{$value->assetclass_name}}</td> --}}
    <td>{{date('d/m/Y', strtotime($value->grn_date))}}</td>
    {{-- <td>{{$value->current_store}}</td> --}}
    <td>
        {{ $value->current_room  ? $value->current_room : 'Asset Store' }}
        @if(!empty($value->current_room))
            <strong>{{ !empty($value->current_floor) ? '[' . $value->current_floor . ']' : '' }}</strong>
        @endif
    </td>
    <!-- <td>Mr. Saiful</td> -->
    {{-- <td>{{$value->to_su}}</td> --}}
    <td>
        {{ $value->to_room  ? $value->to_room : 'Asset Store' }}
        @if(!empty($value->to_room))
            <strong>{{ !empty($value->to_floor) ? '[' . $value->to_floor . ']' : '' }}</strong>
        @endif

    </td>
    <!-- <td>Sales</td> -->
    {{-- <td>{{$value->person_department}}</td> --}}
    <td>{{$value->full_name}}</td>
    <td>
        @if($value->ast_trans_rcv_ind == 1)
        <span class="badge badge-warning">Transferred</span>
        @else
        <span class="badge badge-danger">Requested</span>
        @endif
    </td>
    <td>
        {{-- <form action="{{route('v1.asset-transfer-conform-save')}}" id="tranFerSave" method="post">
            <input type="hidden" name="register_id" value="{{$value->ast_register_no_fk}}">
            <input type="hidden" name="to_store" value="{{$value->trans_to_store_su_no_fk}}">
            <input type="hidden" name="to_room" value="{{$value->trans_to_room_no_fk}}">
            <input type="hidden" name="to_person" value="{{$value->trans_to_person_no_fk}}">
            <input type="hidden" name="last_store" value="{{$value->curr_store_su_no_fk}}">
            <input type="hidden" name="last_room" value="{{$value->curr_room_no_fk}}">
            @php
            $redirect_url=route('v1.asset-transfer');
            @endphp
            <button type="button" class="btn btn-success btn-md btn-md-global" style="font-size: 12px; border:0;" onclick="btnSaveUpdate(this,'','','','', search_list)" @if($value->ast_trans_rcv_ind == 1) disabled @endif>Confirm</button> --}}
            <button title="Confirm" type="button" register_id="{{ $value->ast_register_no_fk }}" to_store="{{ $value->trans_to_store_su_no_fk }}" to_room="{{ $value->trans_to_room_no_fk }}" to_person="{{ $value->trans_to_person_no_fk }}"   last_store ="{{ $value->curr_store_su_no_fk }}" last_room="{{ $value->curr_room_no_fk }}" class="btn btn-success btn-md btn-md-global confirm-btn" @if($value->ast_trans_rcv_ind == 1) disabled @endif>Confirm</button>

        {{-- </form> --}}
    </td>
</tr>
@endforeach
@endif

<script>
    $(document).on('click', '.confirm-btn', function (e) {
    e.preventDefault()
    var register_id =  isNaN(parseInt($(this).attr('register_id'))) ? "": parseInt($(this).attr('register_id'));
    var to_store =  isNaN(parseInt($(this).attr('to_store'))) ? "": parseInt($(this).attr('to_store'));
    var to_room =  isNaN(parseInt($(this).attr('to_room'))) ? "": parseInt($(this).attr('to_room'));
    var to_person =  isNaN(parseInt($(this).attr('to_person'))) ? "": parseInt($(this).attr('to_person'));
    var last_store =  isNaN(parseInt($(this).attr('last_store'))) ? "": parseInt($(this).attr('last_store'));
    var last_room =  isNaN(parseInt($(this).attr('last_room'))) ? "": parseInt($(this).attr('last_room'));

    if (!confirm("Are you sure?")) {
        e.stopImmediatePropagation();
        return false
    }
    var response_action = "{{ route('v1.asset-transfer') }}"
    $.ajax({
        async: true,
        data: {
            register_id: register_id,
            to_store: to_store,
            to_room: to_room,
            to_person: to_person,
            last_store: last_store,
            last_room: last_room,
        },
        url: "{{ route('v1.asset-transfer-conform-save') }}",
        type: 'post',
        beforeSend: function() {
            if (isAModalOpen)
                $('.modal').modal('hide');
            blockUI();
        },
        success: function(data) {
            if (data.title == 'Success') {
                $('.common-modal-notify').modal('show');
                $('.common-modal-notify .modal-body').html(
                        "<i class='fas fa-stroopwafel fa-spin'></i>");
                $('.common-modal-notify .modal-title').html(data.title);
                $('.common-modal-notify .modal-body').html(data.msg);
            }
        },
        error: function(data) {
            var errors = jQuery.parseJSON(data.responseText).errors;
            error_messages = "";
            for (messages in errors) {
                var field_name = $("#" + messages).siblings("label").html();
                error_messages += "<div class='alert alert-danger' role='alert'>" +
                        errors[messages] + "</div>";
            }

            $('.common-modal-notify-error').modal('show');
            $('.common-modal-notify-error .modal-title').html("Validation Error");
            $('.common-modal-notify-error .modal-body').html(error_messages);

            $.unblockUI();
        }
    }).done(function() {
        $.unblockUI();
        dynamicFunc.afterSaveLoadPage(response_action);
    });
    e.stopImmediatePropagation();

})
</script>
